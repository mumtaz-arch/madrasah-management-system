<?php

namespace App\Http\Controllers;

use App\Models\Santri;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Payment;
use App\Models\Tagihan;
use App\Models\ExamAttempt;
use App\Models\Attendance;
use App\Models\PpdbRegistration;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AnalyticsExportController extends Controller
{
    public function export(Request $request)
    {
        $now = now();
        $lastMonth = $now->copy()->subMonth();

        // Gather all analytics data
        $data = [
            'title' => 'Laporan Analitik Pesantren',
            'generatedAt' => $now,
            'periode' => $now->translatedFormat('F Y'),
            
            // Santri Statistics
            'santri' => [
                'total' => Santri::count(),
                'aktif' => Santri::where('status', 'aktif')->count(),
                'byGender' => [
                    'L' => Santri::where('jenis_kelamin', 'L')->count(),
                    'P' => Santri::where('jenis_kelamin', 'P')->count(),
                ],
                'byKelas' => Kelas::withCount('santris')->orderBy('nama_kelas')->get(),
            ],
            
            // Guru Statistics
            'guru' => [
                'total' => Guru::count(),
                'aktif' => Guru::where('status', 'aktif')->count(),
            ],
            
            // Financial Statistics
            'keuangan' => [
                'totalTagihan' => Tagihan::sum('nominal'),
                'totalTerbayar' => Payment::sum('nominal'),
                'totalTunggakan' => Tagihan::where('status', 'belum_bayar')->sum('nominal'),
                'thisMonth' => Payment::whereMonth('tanggal_bayar', $now->month)->whereYear('tanggal_bayar', $now->year)->sum('nominal'),
                'lastMonth' => Payment::whereMonth('tanggal_bayar', $lastMonth->month)->whereYear('tanggal_bayar', $lastMonth->year)->sum('nominal'),
                'byStatus' => Tagihan::selectRaw('status, COUNT(*) as count, SUM(nominal) as total')->groupBy('status')->get(),
            ],
            
            // Academic Statistics
            'akademik' => [
                'totalKelas' => Kelas::count(),
                'avgNilaiUjian' => round(ExamAttempt::where('status', 'submitted')->avg('nilai') ?? 0, 2),
                'totalUjian' => ExamAttempt::where('status', 'submitted')->count(),
                'attendanceRate' => $this->getAttendanceRate($now),
            ],
            
            // PPDB Statistics
            'ppdb' => [
                'total' => PpdbRegistration::whereYear('created_at', $now->year)->count(),
                'diterima' => PpdbRegistration::whereYear('created_at', $now->year)->where('status', 'diterima')->count(),
                'pending' => PpdbRegistration::whereYear('created_at', $now->year)->where('status', 'pending')->count(),
                'ditolak' => PpdbRegistration::whereYear('created_at', $now->year)->where('status', 'ditolak')->count(),
            ],
            
            // Monthly Trends (last 6 months)
            'trends' => $this->getMonthlyTrends(),
        ];

        $pdf = Pdf::loadView('admin.analytics.export-pdf', $data);
        $pdf->setPaper('a4', 'portrait');
        
        return $pdf->download("laporan-analitik-{$now->format('Y-m-d')}.pdf");
    }

    protected function getAttendanceRate($now)
    {
        $total = Attendance::whereMonth('tanggal', $now->month)->count();
        $hadir = Attendance::whereMonth('tanggal', $now->month)->where('status', 'hadir')->count();
        
        return $total > 0 ? round(($hadir / $total) * 100, 1) : 0;
    }

    protected function getMonthlyTrends()
    {
        $trends = [];
        $now = now();
        
        for ($i = 5; $i >= 0; $i--) {
            $date = $now->copy()->subMonths($i);
            $trends[] = [
                'month' => $date->translatedFormat('M Y'),
                'santri' => Santri::whereMonth('created_at', $date->month)->whereYear('created_at', $date->year)->count(),
                'payments' => Payment::whereMonth('tanggal_bayar', $date->month)->whereYear('tanggal_bayar', $date->year)->sum('nominal'),
            ];
        }
        
        return $trends;
    }
}
