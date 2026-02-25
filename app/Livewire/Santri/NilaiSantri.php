<?php

namespace App\Livewire\Santri;

use App\Models\Nilai;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class NilaiSantri extends Component
{
    public string $semester = '1';
    
    public function render()
    {
        $santri = Auth::user()->santri;
        
        $nilais = collect();
        $rataRata = 0;
        
        if ($santri) {
            $nilais = Nilai::with(['mapel', 'guru'])
                ->where('santri_id', $santri->id)
                ->where('semester', $this->semester)
                ->orderBy('created_at', 'desc')
                ->get()
                ->groupBy('mapel_id');
            
            $rataRata = Nilai::where('santri_id', $santri->id)
                ->where('semester', $this->semester)
                ->avg('nilai') ?? 0;
        }

        return view('livewire.santri.nilai-santri', [
            'nilais' => $nilais,
            'santri' => $santri,
            'rataRata' => round($rataRata, 1),
        ]);
    }
}
