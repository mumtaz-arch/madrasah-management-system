<?php

namespace App\Livewire\Admin\Cbt;

use App\Models\Exam;
use App\Models\Kelas;
use App\Models\Mapel;
use Livewire\Component;
use Livewire\WithPagination;

class ExamIndex extends Component
{
    use WithPagination;

    public bool $showModal = false;
    public bool $showDeleteModal = false;
    public ?int $editingId = null;

    // Form data
    public string $nama = '';
    public ?int $mapel_id = null;
    public ?int $kelas_id = null;
    public int $durasi = 60;
    public string $tanggal_mulai = '';
    public string $tanggal_selesai = '';
    public string $status = 'draft';
    public bool $acak_soal = true;
    public bool $acak_jawaban = true;

    protected function rules()
    {
        return [
            'nama' => 'required|string|max:255',
            'mapel_id' => 'required|exists:mapels,id',
            'kelas_id' => 'required|exists:kelas,id',
            'durasi' => 'required|integer|min:1',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'status' => 'required|in:draft,active,completed',
            'acak_soal' => 'boolean',
            'acak_jawaban' => 'boolean',
        ];
    }

    public function openModal()
    {
        $this->reset(['editingId', 'nama', 'mapel_id', 'kelas_id', 'durasi', 'tanggal_mulai', 'tanggal_selesai', 'status', 'acak_soal', 'acak_jawaban']);
        $this->durasi = 60;
        $this->acak_soal = true;
        $this->acak_jawaban = true;
        $this->status = 'draft';
        $this->showModal = true;
    }

    public function edit(int $id)
    {
        $exam = Exam::findOrFail($id);
        $this->editingId = $id;
        $this->nama = $exam->nama;
        $this->mapel_id = $exam->mapel_id;
        $this->kelas_id = $exam->kelas_id;
        $this->durasi = $exam->durasi;
        $this->tanggal_mulai = $exam->tanggal_mulai->format('Y-m-d\TH:i');
        $this->tanggal_selesai = $exam->tanggal_selesai->format('Y-m-d\TH:i');
        $this->status = $exam->status;
        $this->acak_soal = $exam->acak_soal;
        $this->acak_jawaban = $exam->acak_jawaban;
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        $data = [
            'nama' => $this->nama,
            'mapel_id' => $this->mapel_id,
            'kelas_id' => $this->kelas_id,
            'durasi' => $this->durasi,
            'tanggal_mulai' => $this->tanggal_mulai,
            'tanggal_selesai' => $this->tanggal_selesai,
            'status' => $this->status,
            'acak_soal' => $this->acak_soal,
            'acak_jawaban' => $this->acak_jawaban,
        ];

        if ($this->editingId) {
            Exam::findOrFail($this->editingId)->update($data);
            session()->flash('success', 'Ujian berhasil diupdate.');
        } else {
            Exam::create($data);
            session()->flash('success', 'Ujian berhasil ditambahkan.');
        }

        $this->showModal = false;
        $this->reset(['editingId', 'nama', 'mapel_id', 'kelas_id']);
    }

    public function confirmDelete(int $id)
    {
        $this->editingId = $id;
        $this->showDeleteModal = true;
    }

    public function delete()
    {
        Exam::findOrFail($this->editingId)->delete();
        $this->showDeleteModal = false;
        $this->reset(['editingId']);
        session()->flash('success', 'Ujian berhasil dihapus.');
    }

    public function render()
    {
        return view('livewire.admin.cbt.exam-index', [
            'exams' => Exam::with(['mapel', 'kelas'])->latest()->paginate(10),
            'mapels' => Mapel::orderBy('nama')->get(),
            'kelasList' => Kelas::orderBy('nama_kelas')->get(),
        ]);
    }
}
