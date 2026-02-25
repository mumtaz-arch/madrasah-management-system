<?php

namespace App\Livewire\Santri;

use App\Models\Jadwal;
use App\Models\Nilai;
use Livewire\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Component
{
    public function render(): View
    {
        $user = Auth::user();
        $santri = $user->santri;

        if (!$santri) {
            return view('livewire.santri.dashboard', [
                'santri' => null,
                'jadwalHariIni' => collect(),
                'nilaiTerbaru' => collect(),
                'rataRata' => 0,
            ]);
        }

        // Jadwal hari ini with select()
        $hariIni = strtolower(now()->locale('id')->dayName);
        $jadwalHariIni = Jadwal::with(['mapel:id,nama,kode', 'guru:id,nama_lengkap'])
            ->select('id', 'kelas_id', 'mapel_id', 'guru_id', 'hari', 'jam_mulai', 'jam_selesai')
            ->where('kelas_id', $santri->kelas_id)
            ->where('hari', $hariIni)
            ->orderBy('jam_mulai')
            ->get();

        // Nilai terbaru with select()
        $nilaiTerbaru = Nilai::with(['mapel:id,nama'])
            ->select('id', 'santri_id', 'mapel_id', 'nilai', 'created_at')
            ->where('santri_id', $santri->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Rata-rata nilai
        $rataRata = Nilai::where('santri_id', $santri->id)->avg('nilai') ?? 0;

        return view('livewire.santri.dashboard', [
            'santri' => $santri,
            'jadwalHariIni' => $jadwalHariIni,
            'nilaiTerbaru' => $nilaiTerbaru,
            'rataRata' => round($rataRata, 1),
        ]);
    }
}
