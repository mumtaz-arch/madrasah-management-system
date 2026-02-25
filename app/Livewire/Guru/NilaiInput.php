<?php

namespace App\Livewire\Guru;

use App\Models\Jadwal;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Nilai;
use App\Models\Santri;
use Livewire\Component;
use Livewire\WithPagination;

class NilaiInput extends Component
{
    use WithPagination;

    public ?int $selectedMapelId = null;
    public ?int $selectedKelasId = null;
    public string $semester = 'ganjil';
    public string $tahunAjaran = '';
    
    // For inline editing
    public array $nilaiData = [];
    
    protected $rules = [
        'nilaiData.*.tugas' => 'nullable|numeric|min:0|max:100',
        'nilaiData.*.uts' => 'nullable|numeric|min:0|max:100',
        'nilaiData.*.uas' => 'nullable|numeric|min:0|max:100',
    ];

    public function mount()
    {
        $this->tahunAjaran = date('Y') . '/' . (date('Y') + 1);
        
        // Auto-select first mapel if available
        $guru = auth()->user()->guru;
        if ($guru) {
            $firstMapel = Jadwal::where('guru_id', $guru->id)
                ->distinct('mapel_id')
                ->first();
            if ($firstMapel) {
                $this->selectedMapelId = $firstMapel->mapel_id;
                
                // Auto-select first kelas for this mapel
                $firstKelas = Jadwal::where('guru_id', $guru->id)
                    ->where('mapel_id', $this->selectedMapelId)
                    ->first();
                if ($firstKelas) {
                    $this->selectedKelasId = $firstKelas->kelas_id;
                }
            }
        }
    }

    public function updatedSelectedMapelId($value)
    {
        $this->selectedKelasId = null;
        $this->nilaiData = [];
        
        if ($value) {
            $guru = auth()->user()->guru;
            $firstKelas = Jadwal::where('guru_id', $guru->id)
                ->where('mapel_id', $value)
                ->first();
            if ($firstKelas) {
                $this->selectedKelasId = $firstKelas->kelas_id;
            }
        }
    }

    public function updatedSelectedKelasId()
    {
        $this->loadNilaiData();
    }

    public function loadNilaiData()
    {
        $this->nilaiData = [];
        
        if (!$this->selectedMapelId || !$this->selectedKelasId) {
            return;
        }

        $santris = Santri::where('kelas_id', $this->selectedKelasId)
            ->where('status', 'aktif')
            ->orderBy('nama_lengkap')
            ->get();

        $guru = auth()->user()->guru;
        
        foreach ($santris as $santri) {
            $nilai = Nilai::where('santri_id', $santri->id)
                ->where('mapel_id', $this->selectedMapelId)
                ->where('guru_id', $guru->id)
                ->where('semester', $this->semester)
                ->where('tahun_ajaran', $this->tahunAjaran)
                ->first();

            $this->nilaiData[$santri->id] = [
                'santri_id' => $santri->id,
                'nama' => $santri->nama_lengkap,
                'nis' => $santri->nis,
                'tugas' => $nilai->tugas ?? null,
                'uts' => $nilai->uts ?? null,
                'uas' => $nilai->uas ?? null,
                'nilai_id' => $nilai->id ?? null,
            ];
        }
    }

    public function saveNilai()
    {
        if (!$this->selectedMapelId || !$this->selectedKelasId) {
            session()->flash('error', 'Pilih mata pelajaran dan kelas terlebih dahulu.');
            return;
        }

        $guru = auth()->user()->guru;

        foreach ($this->nilaiData as $santriId => $data) {
            Nilai::updateOrCreate(
                [
                    'santri_id' => $santriId,
                    'mapel_id' => $this->selectedMapelId,
                    'guru_id' => $guru->id,
                    'semester' => $this->semester,
                    'tahun_ajaran' => $this->tahunAjaran,
                ],
                [
                    'tugas' => $data['tugas'] ?? null,
                    'uts' => $data['uts'] ?? null,
                    'uas' => $data['uas'] ?? null,
                ]
            );
        }

        session()->flash('success', 'Nilai berhasil disimpan!');
    }

    public function render()
    {
        $guru = auth()->user()->guru;
        
        $mapelList = [];
        $kelasList = [];
        
        if ($guru) {
            // Get mapel taught by this guru
            $mapelIds = Jadwal::where('guru_id', $guru->id)
                ->distinct('mapel_id')
                ->pluck('mapel_id');
            $mapelList = Mapel::whereIn('id', $mapelIds)->orderBy('nama')->get();
            
            // Get kelas for selected mapel
            if ($this->selectedMapelId) {
                $kelasIds = Jadwal::where('guru_id', $guru->id)
                    ->where('mapel_id', $this->selectedMapelId)
                    ->distinct('kelas_id')
                    ->pluck('kelas_id');
                $kelasList = Kelas::whereIn('id', $kelasIds)->orderBy('tingkat')->orderBy('nama_kelas')->get();
            }
        }

        // Load nilai data if kelas selected
        if ($this->selectedKelasId && empty($this->nilaiData)) {
            $this->loadNilaiData();
        }

        return view('livewire.guru.nilai-input', [
            'mapelList' => $mapelList,
            'kelasList' => $kelasList,
        ]);
    }
}
