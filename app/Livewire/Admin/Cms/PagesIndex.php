<?php

namespace App\Livewire\Admin\Cms;

use App\Models\Page;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;

class PagesIndex extends Component
{
    use WithPagination;

    public bool $showModal = false;
    public bool $showDeleteModal = false;
    public ?int $editingId = null;

    // Form fields
    public string $title = '';
    public string $slug = '';
    public string $content = '';
    public bool $is_published = false;

    protected function rules()
    {
        $slugRule = $this->editingId 
            ? 'required|string|max:255|unique:pages,slug,' . $this->editingId
            : 'required|string|max:255|unique:pages,slug';
            
        return [
            'title' => 'required|string|max:255',
            'slug' => $slugRule,
            'content' => 'nullable|string',
            'is_published' => 'boolean',
        ];
    }

    public function updatedTitle($value)
    {
        if (!$this->editingId) {
            $this->slug = Str::slug($value);
        }
    }

    public function openModal()
    {
        $this->reset(['editingId', 'title', 'slug', 'content', 'is_published']);
        $this->showModal = true;
    }

    public function edit(int $id)
    {
        $page = Page::findOrFail($id);
        $this->editingId = $id;
        $this->title = $page->title;
        $this->slug = $page->slug;
        $this->content = $page->content ?? '';
        $this->is_published = $page->is_published;
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        $data = [
            'title' => $this->title,
            'slug' => $this->slug,
            'content' => $this->content,
            'is_published' => $this->is_published,
        ];

        if ($this->editingId) {
            Page::findOrFail($this->editingId)->update($data);
            session()->flash('success', 'Halaman berhasil diupdate.');
        } else {
            Page::create($data);
            session()->flash('success', 'Halaman berhasil dibuat.');
        }

        $this->showModal = false;
        $this->reset(['editingId', 'title', 'slug', 'content']);
    }

    public function confirmDelete(int $id)
    {
        $this->editingId = $id;
        $this->showDeleteModal = true;
    }

    public function delete()
    {
        Page::findOrFail($this->editingId)->delete();
        $this->showDeleteModal = false;
        $this->reset(['editingId']);
        session()->flash('success', 'Halaman berhasil dihapus.');
    }

    public function togglePublish(int $id)
    {
        $page = Page::findOrFail($id);
        $page->update(['is_published' => !$page->is_published]);
        session()->flash('success', 'Status halaman berhasil diubah.');
    }

    public function render()
    {
        return view('livewire.admin.cms.pages-index', [
            'pages' => Page::latest()->paginate(10),
        ]);
    }
}
