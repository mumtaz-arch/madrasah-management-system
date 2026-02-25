<?php

namespace App\Livewire\Admin\Santri;

use App\Models\Santri;
use App\Models\Kelas;
use Livewire\Component;
use Livewire\WithPagination;

class SantriIndex extends Component
{
    use WithPagination;

    public string $search = '';
    public string $filterKelas = '';
    public string $filterStatus = '';
    public string $sortField = 'nama_lengkap';
    public string $sortDirection = 'asc';
    
    public bool $showDeleteModal = false;
    public ?int $santriIdToDelete = null;

    protected $queryString = [
        'search' => ['except' => ''],
        'filterKelas' => ['except' => ''],
        'filterStatus' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterKelas()
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

    public function confirmDelete(int $santriId)
    {
        $this->santriIdToDelete = $santriId;
        $this->showDeleteModal = true;
    }

    public function deleteSantri()
    {
        if ($this->santriIdToDelete) {
            $santri = Santri::find($this->santriIdToDelete);
            if ($santri) {
                // Also delete the user account if exists
                if ($santri->user) {
                    $santri->user->delete();
                }
                $santri->delete();
                session()->flash('success', 'Data santri berhasil dihapus.');
            }
        }
        $this->showDeleteModal = false;
        $this->santriIdToDelete = null;
    }

    public function render()
    {
        $santris = Santri::with(['kelas', 'wali', 'user'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('nama_lengkap', 'like', '%' . $this->search . '%')
                      ->orWhere('nis', 'like', '%' . $this->search . '%')
                      ->orWhere('nisn', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->filterKelas, function ($query) {
                $query->where('kelas_id', $this->filterKelas);
            })
            ->when($this->filterStatus, function ($query) {
                $query->where('status', $this->filterStatus);
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        $kelasList = Kelas::orderBy('tingkat')->orderBy('nama_kelas')->get();

        return view('livewire.admin.santri.santri-index', [
            'santris' => $santris,
            'kelasList' => $kelasList,
        ]);
    }
}
