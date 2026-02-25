<?php

namespace App\Livewire\Admin\Nilai;

use App\Models\Nilai;
use App\Models\Kelas;
use App\Models\Mapel;
use Livewire\Component;
use Livewire\WithPagination;

class NilaiIndex extends Component
{
    use WithPagination;

    public string $filterKelas = '';
    public string $filterMapel = '';
    public string $filterSemester = '';
    public string $filterJenis = '';

    protected $queryString = [
        'filterKelas' => ['except' => ''],
        'filterMapel' => ['except' => ''],
        'filterSemester' => ['except' => ''],
    ];

    public function render()
    {
        $nilais = Nilai::with(['santri', 'mapel', 'guru'])
            ->when($this->filterKelas, function ($query) {
                $query->whereHas('santri', function ($q) {
                    $q->where('kelas_id', $this->filterKelas);
                });
            })
            ->when($this->filterMapel, function ($query) {
                $query->where('mapel_id', $this->filterMapel);
            })
            ->when($this->filterSemester, function ($query) {
                $query->where('semester', $this->filterSemester);
            })
            ->when($this->filterJenis, function ($query) {
                $query->where('jenis', $this->filterJenis);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Summary stats
        $stats = [
            'total' => Nilai::count(),
            'uh' => Nilai::where('jenis', 'UH')->count(),
            'uts' => Nilai::where('jenis', 'UTS')->count(),
            'uas' => Nilai::where('jenis', 'UAS')->count(),
        ];

        return view('livewire.admin.nilai.nilai-index', [
            'nilais' => $nilais,
            'stats' => $stats,
            'kelasList' => Kelas::orderBy('tingkat')->orderBy('nama_kelas')->get(),
            'mapelList' => Mapel::orderBy('nama')->get(),
        ]);
    }
}
