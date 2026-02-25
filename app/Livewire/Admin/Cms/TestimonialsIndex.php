<?php

namespace App\Livewire\Admin\Cms;

use App\Models\Testimonial;
use Livewire\Component;
use Livewire\WithPagination;

class TestimonialsIndex extends Component
{
    use WithPagination;

    public bool $showModal = false;
    public bool $showDeleteModal = false;
    public ?int $editingId = null;

    // Form data
    public string $nama = '';
    public string $peran = '';
    public string $isi = '';
    public bool $is_active = true;
    public int $urutan = 0;

    protected function rules()
    {
        return [
            'nama' => 'required|string|max:255',
            'peran' => 'required|string|max:255',
            'isi' => 'required|string',
            'is_active' => 'boolean',
            'urutan' => 'integer|min:0',
        ];
    }

    public function openModal()
    {
        $this->reset(['editingId', 'nama', 'peran', 'isi', 'is_active', 'urutan']);
        $this->is_active = true;
        $this->showModal = true;
    }

    public function edit(int $id)
    {
        $item = Testimonial::findOrFail($id);
        $this->editingId = $id;
        $this->nama = $item->nama;
        $this->peran = $item->peran;
        $this->isi = $item->isi;
        $this->is_active = $item->is_active;
        $this->urutan = $item->urutan;
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        $data = [
            'nama' => $this->nama,
            'peran' => $this->peran,
            'isi' => $this->isi,
            'is_active' => $this->is_active,
            'urutan' => $this->urutan,
        ];

        if ($this->editingId) {
            Testimonial::findOrFail($this->editingId)->update($data);
            session()->flash('success', 'Testimoni berhasil diupdate.');
        } else {
            Testimonial::create($data);
            session()->flash('success', 'Testimoni berhasil ditambahkan.');
        }

        $this->showModal = false;
        $this->reset(['editingId', 'nama', 'peran', 'isi']);
    }

    public function confirmDelete(int $id)
    {
        $this->editingId = $id;
        $this->showDeleteModal = true;
    }

    public function delete()
    {
        Testimonial::findOrFail($this->editingId)->delete();
        $this->showDeleteModal = false;
        $this->reset(['editingId']);
        session()->flash('success', 'Testimoni berhasil dihapus.');
    }

    public function render()
    {
        return view('livewire.admin.cms.testimonials-index', [
            'testimonials' => Testimonial::orderBy('urutan')->paginate(10),
        ]);
    }
}
