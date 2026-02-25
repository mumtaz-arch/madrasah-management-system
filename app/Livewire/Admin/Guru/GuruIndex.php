<?php

namespace App\Livewire\Admin\Guru;

use App\Models\Guru;
use Livewire\Component;
use Livewire\WithPagination;

class GuruIndex extends Component
{
    use WithPagination;

    public string $search = '';
    public string $filterStatus = '';
    public string $sortField = 'nama_lengkap';
    public string $sortDirection = 'asc';
    
    public bool $showDeleteModal = false;
    public ?int $guruIdToDelete = null;

    protected $queryString = [
        'search' => ['except' => ''],
        'filterStatus' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterStatus()
    {
        $this->resetPage();
    }

    public function sortBy(string $field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function confirmDelete(int $guruId)
    {
        $this->guruIdToDelete = $guruId;
        $this->showDeleteModal = true;
    }

    public function deleteGuru()
    {
        if ($this->guruIdToDelete) {
            $guru = Guru::find($this->guruIdToDelete);
            if ($guru) {
                if ($guru->user) {
                    $guru->user->delete();
                }
                $guru->delete();
                session()->flash('success', 'Data guru berhasil dihapus.');
            }
        }
        $this->showDeleteModal = false;
        $this->guruIdToDelete = null;
    }

    public function render()
    {
        $gurus = Guru::with(['user'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('nama_lengkap', 'like', '%' . $this->search . '%')
                      ->orWhere('nip', 'like', '%' . $this->search . '%')
                      ->orWhere('bidang_keahlian', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->filterStatus, function ($query) {
                $query->where('status', $this->filterStatus);
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        return view('livewire.admin.guru.guru-index', [
            'gurus' => $gurus,
        ]);
    }
}
