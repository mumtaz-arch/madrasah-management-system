<?php

namespace App\Livewire\Admin\Announcements;

use App\Models\Announcement;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;

class AnnouncementForm extends Component
{
    use WithFileUploads;

    public $announcementId;
    public $title = '';
    public $content = '';
    public $excerpt = '';
    public $image;
    public $existingImage;
    public $is_active = true;

    public function mount($id = null)
    {
        if ($id) {
            $announcement = Announcement::findOrFail($id);
            $this->announcementId = $announcement->id;
            $this->title = $announcement->title;
            // Handle content for Quill/Trix correctly, ensuring no xss issues optionally
            $this->content = $announcement->content;
            $this->excerpt = $announcement->excerpt;
            $this->existingImage = $announcement->image;
            $this->is_active = $announcement->is_active;
        }
    }

    public function save()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|max:2048', // optional image upload max 2MB
        ]);

        $data = [
            'title' => $this->title,
            'slug' => Str::slug($this->title),
            'content' => $this->content,
            'excerpt' => $this->excerpt ?: Str::limit(strip_tags($this->content), 150),
            'is_active' => $this->is_active,
            // default type
            'type' => 'info',
            'published_at' => now(),
        ];

        if ($this->image) {
            $data['image'] = $this->image->store('cms/announcements', 'public');
        }

        if ($this->announcementId) {
            $announcement = Announcement::findOrFail($this->announcementId);
            // Regenerate slug only if title changed to avoid breaking URLs optionally, but simple overwrite is fine here
            $data['slug'] = Str::slug($this->title) . '-' . $announcement->id;
            $announcement->update($data);
            session()->flash('success', 'Berita berhasil diperbarui.');
        } else {
            $newAnnouncement = Announcement::create($data);
            // ensure unique slug
            $newAnnouncement->update(['slug' => Str::slug($this->title) . '-' . $newAnnouncement->id]);
            session()->flash('success', 'Berita berhasil diterbitkan.');
        }

        return redirect()->route('announcements.index');
    }

    public function render()
    {
        return view('livewire.admin.announcements.announcement-form')->layout('components.layouts.admin', [
            'title' => $this->announcementId ? 'Edit Berita' : 'Tambah Berita Baru',
            'header' => $this->announcementId ? 'Edit Berita' : 'Tambah Berita Baru',
        ]);
    }
}
