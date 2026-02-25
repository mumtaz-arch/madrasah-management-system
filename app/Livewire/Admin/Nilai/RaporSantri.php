<?php

namespace App\Livewire\Admin\Nilai;

use App\Models\Nilai;
use App\Models\Santri;
use Livewire\Component;

class RaporSantri extends Component
{
    public Santri $santri;
    public string $semester = '1';
    public string $tahun_ajaran = '';

    public function mount(Santri $santri)
    {
        $this->santri = $santri;
        $this->tahun_ajaran = date('Y') . '/' . (date('Y') + 1);
    }

    public function render()
    {
        $nilais = Nilai::with(['mapel', 'guru'])
            ->where('santri_id', $this->santri->id)
            ->where('semester', $this->semester)
            ->when($this->tahun_ajaran, function ($query) {
                $query->where('tahun_ajaran', $this->tahun_ajaran);
            })
            ->get()
            ->groupBy('mapel_id');

        // Calculate averages per mapel
        $raporData = [];
        foreach ($nilais as $mapelId => $mapelNilais) {
            $mapel = $mapelNilais->first()->mapel;
            $uh = $mapelNilais->where('jenis', 'UH')->avg('nilai');
            $uts = $mapelNilais->where('jenis', 'UTS')->avg('nilai');
            $uas = $mapelNilais->where('jenis', 'UAS')->avg('nilai');
            
            // Calculate final grade (UH 30% + UTS 30% + UAS 40%)
            $nilaiAkhir = 0;
            $count = 0;
            if ($uh) { $nilaiAkhir += $uh * 0.3; $count++; }
            if ($uts) { $nilaiAkhir += $uts * 0.3; $count++; }
            if ($uas) { $nilaiAkhir += $uas * 0.4; $count++; }
            
            if ($count > 0 && $count < 3) {
                // Normalize if not all components present
                $nilaiAkhir = ($uh ?: 0) * 0.3 + ($uts ?: 0) * 0.3 + ($uas ?: 0) * 0.4;
                if (!$uh && !$uts && $uas) $nilaiAkhir = $uas;
                elseif (!$uts && !$uas && $uh) $nilaiAkhir = $uh;
            }

            $raporData[] = [
                'mapel' => $mapel,
                'uh' => $uh ? round($uh, 1) : null,
                'uts' => $uts ? round($uts, 1) : null,
                'uas' => $uas ? round($uas, 1) : null,
                'nilai_akhir' => round($nilaiAkhir, 1),
                'kkm' => $mapel->kkm,
                'status' => $nilaiAkhir >= $mapel->kkm ? 'Tuntas' : 'Belum Tuntas',
            ];
        }

        // Overall average
        $rataRata = count($raporData) > 0 
            ? round(collect($raporData)->avg('nilai_akhir'), 1) 
            : 0;

        return view('livewire.admin.nilai.rapor-santri', [
            'raporData' => $raporData,
            'rataRata' => $rataRata,
        ]);
    }
}
