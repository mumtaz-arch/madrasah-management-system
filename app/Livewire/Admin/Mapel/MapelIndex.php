<?php

namespace App\Livewire\Admin\Mapel;

use App\Models\Mapel;
use Livewire\Component;
use Livewire\WithPagination;

class MapelIndex extends Component
{
    use WithPagination;

    public string $search = '';
    public string $filterKategori = '';
    public string $sortField = 'nama';
    public string $sortDirection = 'asc';
    
    public bool $showDeleteModal = false;
    public ?int $mapelIdToDelete = null;

    protected $queryString = [
        'search' => ['except' => ''],
        'filterKategori' => ['except' => ''],
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

    public function confirmDelete(int $mapelId)
    {
        $this->mapelIdToDelete = $mapelId;
        $this->showDeleteModal = true;
    }

    public function deleteMapel()
    {
        if ($this->mapelIdToDelete) {
            $mapel = Mapel::find($this->mapelIdToDelete);
            if ($mapel) {
                if ($mapel->jadwals()->count() > 0 || $mapel->nilais()->count() > 0) {
                    session()->flash('error', 'Tidak dapat menghapus mapel yang masih digunakan di jadwal atau nilai.');
                } else {
                    $mapel->delete();
                    session()->flash('success', 'Data mata pelajaran berhasil dihapus.');
                }
            }
        }
        $this->showDeleteModal = false;
        $this->mapelIdToDelete = null;
    }

    public function render()
    {
        $mapels = Mapel::withCount(['jadwals'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('nama', 'like', '%' . $this->search . '%')
                      ->orWhere('kode', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->filterKategori, function ($query) {
                $query->where('kategori', $this->filterKategori);
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        return view('livewire.admin.mapel.mapel-index', [
            'mapels' => $mapels,
        ]);
    }
}
