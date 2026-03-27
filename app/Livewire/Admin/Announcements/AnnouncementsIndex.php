<?php

namespace App\Livewire\Admin\Announcements;

use App\Models\Announcement;
use Livewire\Component;
use Livewire\WithPagination;

class AnnouncementsIndex extends Component
{
    use WithPagination;

    public $search = '';

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function toggleActive($id)
    {
        $announcement = Announcement::find($id);
        if ($announcement) {
            $announcement->update(['is_active' => !$announcement->is_active]);
            session()->flash('success', 'Status pengumuman berhasil diubah.');
        }
    }

    public function delete($id)
    {
        $announcement = Announcement::find($id);
        if ($announcement) {
            $announcement->delete();
            session()->flash('success', 'Pengumuman berhasil dihapus.');
        }
    }

    public function render()
    {
        $announcements = Announcement::query()
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                      ->orWhere('excerpt', 'like', '%' . $this->search . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.admin.announcements.announcements-index', [
            'announcements' => $announcements
        ]);
    }
}
