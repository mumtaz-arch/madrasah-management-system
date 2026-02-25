<?php

namespace App\Livewire\Admin\Cbt;

use App\Models\QuestionBank;
use App\Models\Mapel;
use App\Models\Guru;
use Livewire\Component;
use Livewire\WithPagination;

class QuestionBankIndex extends Component
{
    use WithPagination;

    public string $search = '';
    public ?int $filterMapel = null;
    public string $filterJenis = '';

    // Modal state
    public bool $showModal = false;
    public bool $showDeleteModal = false;
    public ?int $editingId = null;

    // Form data
    public ?int $mapel_id = null;
    public string $jenis = 'pilihan_ganda';
    public string $pertanyaan = '';
    public array $pilihan = ['', '', '', ''];
    public string $jawaban_benar = 'A';
    public int $poin = 1;

    protected function rules()
    {
        return [
            'mapel_id' => 'required|exists:mapels,id',
            'jenis' => 'required|in:pilihan_ganda,essay',
            'pertanyaan' => 'required|string',
            'pilihan' => 'required_if:jenis,pilihan_ganda|array',
            'jawaban_benar' => 'required_if:jenis,pilihan_ganda',
            'poin' => 'required|integer|min:1',
        ];
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function openModal()
    {
        $this->reset(['editingId', 'mapel_id', 'jenis', 'pertanyaan', 'pilihan', 'jawaban_benar', 'poin']);
        $this->pilihan = ['', '', '', ''];
        $this->jenis = 'pilihan_ganda';
        $this->jawaban_benar = 'A';
        $this->poin = 1;
        $this->showModal = true;
    }

    public function edit(int $id)
    {
        $question = QuestionBank::findOrFail($id);
        $this->editingId = $id;
        $this->mapel_id = $question->mapel_id;
        $this->jenis = $question->jenis;
        $this->pertanyaan = $question->pertanyaan;
        $this->pilihan = $question->pilihan ?? ['', '', '', ''];
        $this->jawaban_benar = $question->jawaban_benar ?? 'A';
        $this->poin = $question->poin;
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        $data = [
            'mapel_id' => $this->mapel_id,
            'guru_id' => auth()->user()->guru?->id,
            'jenis' => $this->jenis,
            'pertanyaan' => $this->pertanyaan,
            'pilihan' => $this->jenis === 'pilihan_ganda' ? $this->pilihan : null,
            'jawaban_benar' => $this->jenis === 'pilihan_ganda' ? $this->jawaban_benar : null,
            'poin' => $this->poin,
        ];

        if ($this->editingId) {
            QuestionBank::findOrFail($this->editingId)->update($data);
            session()->flash('success', 'Soal berhasil diupdate.');
        } else {
            QuestionBank::create($data);
            session()->flash('success', 'Soal berhasil ditambahkan.');
        }

        $this->showModal = false;
        $this->reset(['editingId', 'mapel_id', 'pertanyaan', 'pilihan', 'jawaban_benar']);
    }

    public function confirmDelete(int $id)
    {
        $this->editingId = $id;
        $this->showDeleteModal = true;
    }

    public function delete()
    {
        QuestionBank::findOrFail($this->editingId)->delete();
        $this->showDeleteModal = false;
        $this->reset(['editingId']);
        session()->flash('success', 'Soal berhasil dihapus.');
    }

    public function render()
    {
        $questions = QuestionBank::query()
            ->with(['mapel', 'guru'])
            ->when($this->search, fn($q) => $q->where('pertanyaan', 'like', '%'.$this->search.'%'))
            ->when($this->filterMapel, fn($q) => $q->where('mapel_id', $this->filterMapel))
            ->when($this->filterJenis, fn($q) => $q->where('jenis', $this->filterJenis))
            ->latest()
            ->paginate(10);

        return view('livewire.admin.cbt.question-bank-index', [
            'questions' => $questions,
            'mapels' => Mapel::orderBy('nama')->get(),
        ]);
    }
}
