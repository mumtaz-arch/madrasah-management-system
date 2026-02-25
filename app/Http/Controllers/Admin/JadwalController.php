<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\JadwalExport;
use App\Imports\JadwalImport;

class JadwalController extends Controller
{
    public function export()
    {
        return Excel::download(new JadwalExport, 'jadwal-'.date('Y-m-d').'.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        try {
            Excel::import(new JadwalImport, $request->file('file'));
            return redirect()->back()->with('success', 'Data jadwal berhasil diimport.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal import data: ' . $e->getMessage());
        }
    }

    public function downloadTemplate()
    {
        $headers = ['Hari', 'Jam Mulai', 'Jam Selesai', 'Kode Mapel', 'Nama Kelas', 'NIP Guru', 'Nama Guru', 'Tahun Ajaran'];
        $example = ['Senin', '07:00', '08:30', 'MP001', 'X IPA 1', '19800101...', 'Budi Santoso', '2024/2025'];

        $callback = function() use ($headers, $example) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $headers);
            fputcsv($file, $example);
            fclose($file);
        };

        return response()->stream($callback, 200, [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=template-jadwal.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ]);
    }
    public function exportPdf()
    {
        $jadwals = \App\Models\Jadwal::with(['guru', 'kelas', 'mapel'])
            ->orderBy('kelas_id')
            ->orderBy('hari')
            ->orderBy('jam_mulai')
            ->get();

        // Generate Codes
        $mapels = \App\Models\Mapel::orderBy('nama')->get();
        $mapelCodes = $mapels->mapWithKeys(function ($item) {
            $code = strtoupper(substr($item->nama, 0, 2));
            return [$item->id => $code];
        });

        $gurus = \App\Models\Guru::orderBy('nama_lengkap')->where('status', 'aktif')->get();
        $guruCodes = $gurus->mapWithKeys(function ($item, $key) {
            return [$item->id => $key + 1];
        });

        // Soft Color Palette
        $colors = [
            '#ffeb3b', '#ffcdd2', '#c8e6c9', '#bbdefb', '#e1bee7', 
            '#ffe0b2', '#b2dfdb', '#f0f4c3', '#d1c4e9', '#ffecb3',
        ];
        
        $mapelColors = $mapels->mapWithKeys(function ($item, $key) use ($colors) {
            return [$item->id => $colors[$key % count($colors)]];
        });

        // Group by Class
        $groupedByKelas = $jadwals->groupBy(function ($item) {
            return $item->kelas->nama_kelas;
        });

        $days = ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu'];

        // Prepare Data for Aligned Stack View
        $exportData = [];
        $totalSlots = 0;

        foreach ($groupedByKelas as $kelas => $items) {
            // Get Master Time Slots for this class (unique start-end pairs)
            $masterSlots = $items->map(function($item) {
                return $item->jam_mulai->format('H:i') . '-' . $item->jam_selesai->format('H:i');
            })->unique()->sort()->values();

            $totalSlots += $masterSlots->count();

            $exportData[$kelas] = [
                'slots' => $masterSlots,
                'items' => $items
            ];
        }

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.jadwal-export', [
            'exportData' => $exportData,
            'days' => $days,
            'mapelCodes' => $mapelCodes,
            'guruCodes' => $guruCodes,
            'mapelColors' => $mapelColors,
            'totalSlots' => $totalSlots
        ])->setPaper('a4', 'landscape');

        return $pdf->stream('jadwal-pelajaran.pdf');
    }
}
