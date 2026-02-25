<?php

namespace App\Livewire\Wali;

use App\Models\Santri;
use App\Models\Jadwal;
use Livewire\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Component
{
    public function render(): View
    {
        $user = Auth::user();
        $wali = $user->wali;

        if (!$wali) {
            return view('livewire.wali.dashboard', [
                'wali' => null,
                'santris' => collect(),
            ]);
        }

        // Eager load santris with kelas and nilais (with mapel) in a single query
        $santris = Santri::with([
                'kelas:id,nama_kelas',
                'nilais' => fn($q) => $q->select('id', 'santri_id', 'mapel_id', 'nilai', 'created_at')
                    ->with('mapel:id,nama'),
            ])
            ->select('id', 'nama_lengkap', 'kelas_id', 'wali_id', 'nis', 'status')
            ->where('wali_id', $wali->id)
            ->get();

        // Pre-fetch today's jadwal for ALL relevant kelas IDs in ONE query
        $kelasIds = $santris->pluck('kelas_id')->unique()->filter()->values();
        $hariIni = strtolower(now()->locale('id')->dayName);

        $jadwalByKelas = collect();
        if ($kelasIds->isNotEmpty()) {
            $jadwalByKelas = Jadwal::with(['mapel:id,nama,kode', 'guru:id,nama_lengkap'])
                ->select('id', 'kelas_id', 'mapel_id', 'guru_id', 'hari', 'jam_mulai', 'jam_selesai')
                ->whereIn('kelas_id', $kelasIds)
                ->where('hari', $hariIni)
                ->orderBy('jam_mulai')
                ->get()
                ->groupBy('kelas_id');
        }

        // Attach computed attributes without extra queries
        $santris->each(function ($santri) use ($jadwalByKelas) {
            $santri->rata_rata = $santri->nilais->avg('nilai') ?? 0;
            $santri->nilai_terbaru = $santri->nilais->sortByDesc('created_at')->take(3)->values();
            $santri->jadwal_hari_ini = $jadwalByKelas->get($santri->kelas_id, collect());
        });

        return view('livewire.wali.dashboard', [
            'wali' => $wali,
            'santris' => $santris,
        ]);
    }
}
