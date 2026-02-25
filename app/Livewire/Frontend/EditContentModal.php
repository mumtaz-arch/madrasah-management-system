<?php

namespace App\Livewire\Frontend;

use App\Models\LandingPageContent;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\On;

class EditContentModal extends Component
{
    use WithFileUploads;

    public $isOpen = false;
    public $key;
    public $value;
    public $type = 'text'; // text, image, richtext
    public $newImage;
    public $section = 'general';

    #[On('open-edit-modal')]
    public function openModal($key)
    {
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            return;
        }

        $content = LandingPageContent::where('key', $key)->first();

        $this->key = $key;
        $this->value = $content ? $content->value : '';
        $this->type = $content ? $content->type : 'text';
        $this->section = $content ? $content->section : 'general';
        
        // Infer type if new key
        if (!$content) {
            if (str_contains($key, 'image')) $this->type = 'image';
            else $this->type = 'text';
        }

        $this->newImage = null;
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->reset(['key', 'value', 'type', 'newImage']);
    }

    public function save()
    {
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized');
        }

        $data = ['value' => $this->value, 'type' => $this->type, 'section' => $this->section];

        if ($this->newImage && $this->type === 'image') {
            $path = $this->newImage->store('cms/uploads', 'public');
            $data['value'] = $path;
        }

        LandingPageContent::updateOrCreate(
            ['key' => $this->key],
            $data
        );

        session()->flash('message', 'Content updated!');
        $this->closeModal();
        return redirect(request()->header('Referer')); // Reload to see changes
    }

    public function render()
    {
        return view('livewire.frontend.edit-content-modal');
    }
}
