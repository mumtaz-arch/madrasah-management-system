<?php

namespace App\Livewire\Wali;

use App\Models\Nilai;
use App\Models\Santri;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class NilaiAnak extends Component
{
    public ?int $selectedSantriId = null;
    public string $semester = 'ganjil';
    public string $tahunAjaran = '';

    public function mount()
    {
        $this->tahunAjaran = date('Y') . '/' . (date('Y') + 1);
        
        // Auto-select first santri
        $wali = Auth::user()->wali;
        if ($wali) {
            $firstSantri = Santri::where('wali_id', $wali->id)->first();
            if ($firstSantri) {
                $this->selectedSantriId = $firstSantri->id;
            }
        }
    }

    public function render()
    {
        $wali = Auth::user()->wali;
        $santris = collect();
        $nilaiData = [];
        $selectedSantri = null;
        $stats = [
            'rata_rata' => 0,
            'tertinggi' => 0,
            'terendah' => 0,
            'total_mapel' => 0,
        ];

        // Chart data
        $chartLabels = [];
        $chartValues = [];
        $chartColors = [];
        $chartBorders = [];

        if ($wali) {
            $santris = Santri::where('wali_id', $wali->id)->get();

            if ($this->selectedSantriId) {
                $selectedSantri = Santri::with('kelas:id,nama_kelas')->find($this->selectedSantriId);
                
                // Get nilai grouped by mapel
                // Optimizing query to select only needed columns
                $nilais = Nilai::with('mapel:id,nama')
                    ->where('santri_id', $this->selectedSantriId)
                    ->where('semester', $this->semester)
                    ->where('tahun_ajaran', $this->tahunAjaran)
                    ->get();
                
                // Group by Mapel ID to consolidation scores (Tugas, UTS, UAS)
                $groupedNilais = $nilais->groupBy('mapel_id');

                foreach ($groupedNilais as $mapelId => $scores) {
                    $mapelName = $scores->first()->mapel->nama ?? '-';
                    
                    // Extract scores based on type
                    $tugas = $scores->where('jenis', 'tugas')->first()?->nilai;
                    $uts = $scores->where('jenis', 'uts')->first()?->nilai;
                    $uas = $scores->where('jenis', 'uas')->first()?->nilai;

                    $avg = collect([$tugas, $uts, $uas])->filter()->avg();
                    
                    $nilaiData[] = [
                        'mapel' => $mapelName,
                        'tugas' => $tugas,
                        'uts' => $uts,
                        'uas' => $uas,
                        'rata_rata' => $avg ? round($avg, 1) : 0,
                    ];
                }

                // Calculate stats
                $averages = collect($nilaiData)->pluck('rata_rata')->filter();
                if ($averages->count() > 0) {
                    $stats['rata_rata'] = round($averages->avg(), 1);
                    $stats['tertinggi'] = round($averages->max(), 1);
                    $stats['terendah'] = round($averages->min(), 1);
                    $stats['total_mapel'] = $averages->count();
                }

                // Prepare Chart Data
                $collection = collect($nilaiData);
                $chartLabels = $collection->pluck('mapel')->toArray();
                $chartValues = $collection->pluck('rata_rata')->toArray();
                
                $chartColors = $collection->map(function($n) {
                    if ($n['rata_rata'] >= 75) return 'rgba(34, 197, 94, 0.7)'; // Green
                    if ($n['rata_rata'] >= 60) return 'rgba(234, 179, 8, 0.7)'; // Yellow
                    return 'rgba(239, 68, 68, 0.7)'; // Red
                })->toArray();

                $chartBorders = $collection->map(function($n) {
                    if ($n['rata_rata'] >= 75) return 'rgb(34, 197, 94)';
                    if ($n['rata_rata'] >= 60) return 'rgb(234, 179, 8)';
                    return 'rgb(239, 68, 68)';
                })->toArray();
            }
        }

        return view('livewire.wali.nilai-anak', [
            'santris' => $santris,
            'selectedSantri' => $selectedSantri,
            'nilaiData' => $nilaiData,
            'stats' => $stats,
            'chartLabels' => $chartLabels,
            'chartValues' => $chartValues,
            'chartColors' => $chartColors,
            'chartBorders' => $chartBorders,
        ]);
    }
}
