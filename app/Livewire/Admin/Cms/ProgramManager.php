<?php

namespace App\Livewire\Admin\Cms;

use App\Models\Program;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;

class ProgramManager extends Component
{
    use WithFileUploads;

    public $programs;
    public $title, $description, $slug, $icon, $image, $is_featured = true, $sort_order = 0;
    public $programId;
    public $isOpen = false;
    public $newImage;

    #[Layout('components.layouts.admin')]
    public function render()
    {
        $this->programs = Program::orderBy('sort_order')->get();
        return view('livewire.admin.cms.program-manager');
    }

    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    public function resetInputFields()
    {
        $this->title = '';
        $this->slug = '';
        $this->description = '';
        $this->icon = '';
        $this->image = '';
        $this->newImage = null;
        $this->programId = null;
        $this->is_featured = true;
        $this->sort_order = 0;
    }

    public function store()
    {
        $this->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        $data = [
            'title' => $this->title,
            'slug' => Str::slug($this->title),
            'description' => $this->description,
            'icon' => $this->icon,
            'is_featured' => $this->is_featured,
            'sort_order' => $this->sort_order,
        ];

        if ($this->newImage) {
            $data['image'] = $this->newImage->store('programs', 'public');
        }

        Program::updateOrCreate(['id' => $this->programId], $data);

        session()->flash('message', $this->programId ? 'Program Update Successfully.' : 'Program Created Successfully.');

        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $program = Program::findOrFail($id);
        $this->programId = $id;
        $this->title = $program->title;
        $this->slug = $program->slug;
        $this->description = $program->description;
        $this->icon = $program->icon;
        $this->image = $program->image;
        $this->is_featured = $program->is_featured;
        $this->sort_order = $program->sort_order;
    
        $this->openModal();
    }

    public function delete($id)
    {
        Program::find($id)->delete();
        session()->flash('message', 'Program Deleted Successfully.');
    }
}
