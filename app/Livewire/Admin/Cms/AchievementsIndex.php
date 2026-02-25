<?php

namespace App\Livewire\Admin\Cms;

use App\Models\Achievement;
use Livewire\Component;
use Livewire\WithPagination;

class AchievementsIndex extends Component
{
    use WithPagination;

    public bool $showModal = false;
    public bool $showDeleteModal = false;
    public ?int $editingId = null;

    // Form data
    public string $judul = '';
    public string $deskripsi = '';
    public string $tahun = '';
    public string $tingkat = '';
    public bool $is_active = true;
    public int $urutan = 0;

    protected function rules()
    {
        return [
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tahun' => 'nullable|string|max:4',
            'tingkat' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            'urutan' => 'integer|min:0',
        ];
    }

    public function openModal()
    {
        $this->reset(['editingId', 'judul', 'deskripsi', 'tahun', 'tingkat', 'is_active', 'urutan']);
        $this->is_active = true;
        $this->showModal = true;
    }

    public function edit(int $id)
    {
        $item = Achievement::findOrFail($id);
        $this->editingId = $id;
        $this->judul = $item->judul;
        $this->deskripsi = $item->deskripsi ?? '';
        $this->tahun = $item->tahun ?? '';
        $this->tingkat = $item->tingkat ?? '';
        $this->is_active = $item->is_active;
        $this->urutan = $item->urutan;
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        $data = [
            'judul' => $this->judul,
            'deskripsi' => $this->deskripsi,
            'tahun' => $this->tahun,
            'tingkat' => $this->tingkat,
            'is_active' => $this->is_active,
            'urutan' => $this->urutan,
        ];

        if ($this->editingId) {
            Achievement::findOrFail($this->editingId)->update($data);
            session()->flash('success', 'Prestasi berhasil diupdate.');
        } else {
            Achievement::create($data);
            session()->flash('success', 'Prestasi berhasil ditambahkan.');
        }

        $this->showModal = false;
        $this->reset(['editingId', 'judul', 'deskripsi', 'tahun', 'tingkat']);
    }

    public function confirmDelete(int $id)
    {
        $this->editingId = $id;
        $this->showDeleteModal = true;
    }

    public function delete()
    {
        Achievement::findOrFail($this->editingId)->delete();
        $this->showDeleteModal = false;
        $this->reset(['editingId']);
        session()->flash('success', 'Prestasi berhasil dihapus.');
    }

    public function render()
    {
        return view('livewire.admin.cms.achievements-index', [
            'achievements' => Achievement::orderBy('urutan')->paginate(10),
        ]);
    }
}
