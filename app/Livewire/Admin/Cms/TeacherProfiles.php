<?php

namespace App\Livewire\Admin\Cms;

use App\Models\Guru;
use Livewire\Component;
use Livewire\WithPagination;

class TeacherProfiles extends Component
{
    use WithPagination;

    public string $search = '';

    public function toggleLandingVisibility(int $id)
    {
        $guru = Guru::findOrFail($id);
        $guru->update(['show_on_landing' => !$guru->show_on_landing]);
        session()->flash('success', 'Visibilitas guru di landing page berhasil diubah.');
    }

    public function render()
    {
        $teachers = Guru::query()
            ->when($this->search, function ($query) {
                $query->where('nama_lengkap', 'like', "%{$this->search}%")
                      ->orWhere('bidang_keahlian', 'like', "%{$this->search}%");
            })
            ->orderByDesc('show_on_landing')
            ->orderBy('nama_lengkap')
            ->paginate(10);

        return view('livewire.admin.cms.teacher-profiles', [
            'teachers' => $teachers,
            'landingCount' => Guru::where('show_on_landing', true)->count(),
        ]);
    }
}
