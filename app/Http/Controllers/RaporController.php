<?php

namespace App\Http\Controllers;

use App\Models\Santri;
use App\Models\Nilai;
use App\Models\Kelas;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class RaporController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search', '');
        $kelasId = $request->get('kelas_id', '');
        
        $santris = Santri::with(['kelas', 'user'])
            ->when($search, function ($query) use ($search) {
                $query->where('nama_lengkap', 'like', '%' . $search . '%')
                      ->orWhere('nis', 'like', '%' . $search . '%');
            })
            ->when($kelasId, function ($query) use ($kelasId) {
                $query->where('kelas_id', $kelasId);
            })
            ->orderBy('nama_lengkap')
            ->paginate(10)
            ->withQueryString();
            
        $kelasList = Kelas::orderBy('nama_kelas')->get();
        
        return view('admin.rapor.index', compact('santris', 'kelasList', 'search', 'kelasId'));
    }

    public function show(Santri $santri)
    {
        $nilais = Nilai::with(['mapel', 'guru'])
            ->where('santri_id', $santri->id)
            ->get()
            ->groupBy('mapel_id');
        
        return view('admin.rapor.show', compact('santri', 'nilais'));
    }

    public function generatePdf(Santri $santri)
    {
        // Authorization check for Wali
        $user = auth()->user();
        if ($user->role === 'wali') {
             if (!$user->wali || $user->wali->id !== $santri->wali_id) {
                 abort(403, 'Unauthorized action.');
             }
        }

        $nilais = Nilai::with(['mapel', 'guru'])
            ->where('santri_id', $santri->id)
            ->get();

        $rataRata = $nilais->avg(function($nilai) {
            return ($nilai->nilai_tugas + $nilai->nilai_uts + $nilai->nilai_uas) / 3;
        });

        $data = [
            'santri' => $santri->load('kelas'),
            'nilais' => $nilais,
            'rataRata' => round($rataRata, 2),
            'semester' => 'Ganjil',
            'tahunAjaran' => '2024/2025',
        ];

        $pdf = Pdf::loadView('admin.rapor.pdf', $data);
        $pdf->setPaper('a4', 'portrait');
        
        return $pdf->download("rapor-{$santri->nis}-{$santri->nama_lengkap}.pdf");
    }

    public function preview(Santri $santri)
    {
        $nilais = Nilai::with(['mapel', 'guru'])
            ->where('santri_id', $santri->id)
            ->get();

        $rataRata = $nilais->avg(function($nilai) {
            return ($nilai->nilai_tugas + $nilai->nilai_uts + $nilai->nilai_uas) / 3;
        });

        $data = [
            'santri' => $santri->load('kelas'),
            'nilais' => $nilais,
            'rataRata' => round($rataRata, 2),
            'semester' => 'Ganjil',
            'tahunAjaran' => '2024/2025',
        ];

        $pdf = Pdf::loadView('admin.rapor.pdf', $data);
        $pdf->setPaper('a4', 'portrait');
        
        return $pdf->stream("rapor-{$santri->nis}.pdf");
    }

    public function summary()
    {
        $kelasList = Kelas::withCount('santris')->with(['santris' => function($q) {
            $q->with('nilais');
        }])->get();

        $summary = $kelasList->map(function($kelas) {
            $santriCount = $kelas->santris->count();
            $avgNilai = 0;
            
            if ($santriCount > 0) {
                $totalNilai = 0;
                $nilaiCount = 0;
                foreach ($kelas->santris as $santri) {
                    foreach ($santri->nilais as $nilai) {
                        $totalNilai += ($nilai->nilai_tugas + $nilai->nilai_uts + $nilai->nilai_uas) / 3;
                        $nilaiCount++;
                    }
                }
                $avgNilai = $nilaiCount > 0 ? round($totalNilai / $nilaiCount, 2) : 0;
            }

            return [
                'kelas' => $kelas->nama_kelas,
                'jumlah_santri' => $santriCount,
                'rata_rata' => $avgNilai,
            ];
        });

        return view('admin.rapor.summary', compact('summary'));
    }
}
