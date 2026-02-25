<?php

namespace App\Livewire\Santri;

use App\Models\Jadwal;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class JadwalSantri extends Component
{
    public function render()
    {
        $santri = Auth::user()->santri;
        
        $jadwals = collect();
        if ($santri && $santri->kelas_id) {
            $jadwals = Jadwal::with(['mapel', 'guru'])
                ->where('kelas_id', $santri->kelas_id)
                ->orderByRaw("FIELD(hari, 'senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu')")
                ->orderBy('jam_mulai')
                ->get()
                ->groupBy('hari');
        }

        return view('livewire.santri.jadwal-santri', [
            'jadwals' => $jadwals,
            'santri' => $santri,
        ]);
    }
}
