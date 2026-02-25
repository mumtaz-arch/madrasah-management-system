<?php

namespace App\Livewire\Admin;

use App\Models\Santri;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Nilai;
use App\Models\Payment;
use App\Models\Tagihan;
use App\Models\ExamAttempt;
use App\Models\Attendance;
use App\Models\PpdbRegistration;
use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class AnalyticsDashboard extends Component
{
    public string $period = 'month'; // week, month, year
    public array $trendData = [];
    public array $summaryStats = [];

    private const CACHE_TTL = 300; // 5 minutes

    public function mount(): void
    {
        $this->loadData();
    }

    public function updatedPeriod(): void
    {
        $this->loadData();
    }

    protected function loadData(): void
    {
        $this->loadSummaryStats();
        $this->loadTrendData();
    }

    protected function loadSummaryStats(): void
    {
        $this->summaryStats = Cache::remember('analytics_summary_stats', self::CACHE_TTL, function () {
            $now = now();
            $lastMonth = $now->copy()->subMonth();

            // Santri stats — 2 queries instead of 3
            $santriStats = Santri::selectRaw("
                COUNT(*) as total,
                SUM(CASE WHEN status = 'aktif' THEN 1 ELSE 0 END) as active,
                SUM(CASE WHEN created_at < ? THEN 1 ELSE 0 END) as last_month_count
            ", [$lastMonth])->first();

            $santriTotal = $santriStats->total;
            $santriLastMonth = $santriStats->last_month_count;
            $santriGrowth = $santriLastMonth > 0 ? round((($santriTotal - $santriLastMonth) / $santriLastMonth) * 100, 1) : 0;

            // Financial stats — 2 queries consolidated into 1
            $financialStats = Payment::selectRaw("
                SUM(CASE WHEN MONTH(tanggal_bayar) = ? AND YEAR(tanggal_bayar) = ? THEN nominal ELSE 0 END) as this_month,
                SUM(CASE WHEN MONTH(tanggal_bayar) = ? AND YEAR(tanggal_bayar) = ? THEN nominal ELSE 0 END) as last_month
            ", [$now->month, $now->year, $lastMonth->month, $lastMonth->year])->first();

            $thisMonthPayments = $financialStats->this_month ?? 0;
            $lastMonthPayments = $financialStats->last_month ?? 0;
            $paymentGrowth = $lastMonthPayments > 0 ? round((($thisMonthPayments - $lastMonthPayments) / $lastMonthPayments) * 100, 1) : 0;

            // Attendance rate — 1 query instead of 2
            $attendanceStats = Attendance::whereMonth('tanggal', $now->month)
                ->selectRaw("COUNT(*) as total, SUM(CASE WHEN status = 'hadir' THEN 1 ELSE 0 END) as present")
                ->first();

            $attendanceRate = $attendanceStats->total > 0
                ? round(($attendanceStats->present / $attendanceStats->total) * 100, 1) : 0;

            // Exam average
            $examAverage = ExamAttempt::where('status', 'submitted')
                ->whereMonth('created_at', $now->month)
                ->avg('nilai') ?? 0;

            // PPDB stats — 1 query instead of 2
            $ppdbStats = PpdbRegistration::whereYear('created_at', $now->year)
                ->selectRaw("COUNT(*) as total, SUM(CASE WHEN status = 'diterima' THEN 1 ELSE 0 END) as accepted")
                ->first();

            return [
                'santri' => [
                    'total' => $santriTotal,
                    'growth' => $santriGrowth,
                    'active' => $santriStats->active,
                ],
                'guru' => [
                    'total' => Guru::count(),
                    'active' => Guru::where('status', 'aktif')->count(),
                ],
                'keuangan' => [
                    'thisMonth' => $thisMonthPayments,
                    'growth' => $paymentGrowth,
                    'tunggakan' => Tagihan::where('status', 'belum_bayar')->sum('nominal'),
                ],
                'akademik' => [
                    'attendanceRate' => $attendanceRate,
                    'examAverage' => round($examAverage, 1),
                    'totalKelas' => Kelas::count(),
                ],
                'ppdb' => [
                    'total' => $ppdbStats->total,
                    'accepted' => $ppdbStats->accepted,
                    'rate' => $ppdbStats->total > 0 ? round(($ppdbStats->accepted / $ppdbStats->total) * 100, 1) : 0,
                ],
            ];
        });
    }

    protected function loadTrendData(): void
    {
        $cacheKey = "analytics_trend_{$this->period}";

        $this->trendData = Cache::remember($cacheKey, self::CACHE_TTL, function () {
            $now = now();
            $labels = [];
            $santriData = [];
            $paymentData = [];
            $attendanceData = [];

            if ($this->period === 'week') {
                // Last 7 days — use ONE aggregated query per metric
                $startDate = $now->copy()->subDays(6)->startOfDay();

                $payments = Payment::where('tanggal_bayar', '>=', $startDate)
                    ->selectRaw('DATE(tanggal_bayar) as date, SUM(nominal) as total')
                    ->groupBy('date')
                    ->pluck('total', 'date');

                $attendances = Attendance::where('tanggal', '>=', $startDate)
                    ->where('status', 'hadir')
                    ->selectRaw('DATE(tanggal) as date, COUNT(*) as total')
                    ->groupBy('date')
                    ->pluck('total', 'date');

                for ($i = 6; $i >= 0; $i--) {
                    $date = $now->copy()->subDays($i);
                    $dateStr = $date->format('Y-m-d');
                    $labels[] = $date->format('D');
                    $paymentData[] = (int) ($payments[$dateStr] ?? 0);
                    $attendanceData[] = (int) ($attendances[$dateStr] ?? 0);
                }
            } elseif ($this->period === 'month') {
                // Last 4 weeks — use ONE aggregated query per metric
                $startDate = $now->copy()->subWeeks(3)->startOfWeek();

                $payments = Payment::where('tanggal_bayar', '>=', $startDate)
                    ->selectRaw('YEARWEEK(tanggal_bayar) as yw, SUM(nominal) as total')
                    ->groupBy('yw')
                    ->pluck('total', 'yw');

                $attendances = Attendance::where('tanggal', '>=', $startDate)
                    ->where('status', 'hadir')
                    ->selectRaw('YEARWEEK(tanggal) as yw, COUNT(*) as total')
                    ->groupBy('yw')
                    ->pluck('total', 'yw');

                for ($i = 3; $i >= 0; $i--) {
                    $weekDate = $now->copy()->subWeeks($i);
                    $yw = $weekDate->format('oW');
                    // MySQL YEARWEEK returns YYYYWW format
                    $mysqlYw = intval($weekDate->format('o') . $weekDate->format('W'));
                    $labels[] = 'Week ' . ($i === 0 ? 'Now' : "-$i");
                    $paymentData[] = (int) ($payments[$mysqlYw] ?? 0);
                    $attendanceData[] = (int) ($attendances[$mysqlYw] ?? 0);
                }
            } else {
                // Last 12 months — use ONE aggregated query per metric
                $startDate = $now->copy()->subMonths(11)->startOfMonth();

                $santris = Santri::where('created_at', '>=', $startDate)
                    ->selectRaw('YEAR(created_at) as y, MONTH(created_at) as m, COUNT(*) as total')
                    ->groupBy('y', 'm')
                    ->get()
                    ->keyBy(fn($item) => $item->y . '-' . $item->m);

                $payments = Payment::where('tanggal_bayar', '>=', $startDate)
                    ->selectRaw('YEAR(tanggal_bayar) as y, MONTH(tanggal_bayar) as m, SUM(nominal) as total')
                    ->groupBy('y', 'm')
                    ->get()
                    ->keyBy(fn($item) => $item->y . '-' . $item->m);

                for ($i = 11; $i >= 0; $i--) {
                    $date = $now->copy()->subMonths($i);
                    $key = $date->year . '-' . $date->month;
                    $labels[] = $date->format('M');
                    $santriData[] = (int) ($santris[$key]->total ?? 0);
                    $paymentData[] = (int) ($payments[$key]->total ?? 0);
                }
            }

            return [
                'labels' => $labels,
                'santri' => $santriData,
                'payments' => $paymentData,
                'attendance' => $attendanceData,
            ];
        });
    }

    public function render(): View
    {
        return view('livewire.admin.analytics-dashboard');
    }
}
