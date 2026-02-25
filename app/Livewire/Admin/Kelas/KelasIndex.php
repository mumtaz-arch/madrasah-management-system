<?php

namespace App\Livewire\Admin\Kelas;

use App\Models\Kelas;
use App\Models\Guru;
use Livewire\Component;
use Livewire\WithPagination;

class KelasIndex extends Component
{
    use WithPagination;

    public string $search = '';
    public string $filterTingkat = '';
    public string $sortField = 'nama_kelas';
    public string $sortDirection = 'asc';
    
    public bool $showDeleteModal = false;
    public ?int $kelasIdToDelete = null;

    protected $queryString = [
        'search' => ['except' => ''],
        'filterTingkat' => ['except' => ''],
    ];

    public function updatingSearch()
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

    public function confirmDelete(int $kelasId)
    {
        $this->kelasIdToDelete = $kelasId;
        $this->showDeleteModal = true;
    }

    public function deleteKelas()
    {
        if ($this->kelasIdToDelete) {
            $kelas = Kelas::find($this->kelasIdToDelete);
            if ($kelas) {
                if ($kelas->santris()->count() > 0) {
                    session()->flash('error', 'Tidak dapat menghapus kelas yang masih memiliki santri.');
                } else {
                    $kelas->delete();
                    session()->flash('success', 'Data kelas berhasil dihapus.');
                }
            }
        }
        $this->showDeleteModal = false;
        $this->kelasIdToDelete = null;
    }

    public function render()
    {
        $kelasList = Kelas::with(['waliKelas', 'santris'])
            ->when($this->search, function ($query) {
                $query->where('nama_kelas', 'like', '%' . $this->search . '%');
            })
            ->when($this->filterTingkat, function ($query) {
                $query->where('tingkat', $this->filterTingkat);
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        return view('livewire.admin.kelas.kelas-index', [
            'kelasList' => $kelasList,
        ]);
    }
}
