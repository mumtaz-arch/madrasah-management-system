<?php

namespace App\Services;

use App\Models\Santri;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\User;
use App\Models\PpdbRegistration;
use App\Models\Tagihan;
use App\Models\Payment;
use App\Models\Attendance;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class CacheService
{
    const CACHE_TTL = 300; // 5 minutes
    const LONG_CACHE_TTL = 3600; // 1 hour

    /**
     * Get dashboard stats with caching.
     */
    public static function getDashboardStats(): array
    {
        return Cache::remember('dashboard_stats', self::CACHE_TTL, function () {
            return [
                'total_santri' => Santri::count(),
                'total_guru' => Guru::count(),
                'total_kelas' => Kelas::count(),
                'total_users' => User::count(),
                'ppdb_pending' => PpdbRegistration::where('status', 'pending')->count(),
                'ppdb_verified' => PpdbRegistration::where('status', 'verified')->count(),
            ];
        });
    }

    /**
     * Get recent PPDB registrations.
     */
    public static function getRecentPpdb(int $limit = 5)
    {
        return Cache::remember('recent_ppdb_' . $limit, self::CACHE_TTL, function () use ($limit) {
            return PpdbRegistration::with('user')
                ->latest()
                ->take($limit)
                ->get();
        });
    }

    /**
     * Get list of Kelas with santri counts.
     */
    public static function getKelasWithCounts()
    {
        return Cache::remember('kelas_with_counts', self::LONG_CACHE_TTL, function () {
            return Kelas::withCount('santris')->get();
        });
    }

    /**
     * Get list of Guru for dropdowns.
     */
    public static function getGuruList()
    {
        return Cache::remember('guru_list', self::LONG_CACHE_TTL, function () {
            return Guru::select('id', 'nama_lengkap', 'nip')->orderBy('nama_lengkap')->get();
        });
    }

    /**
     * Get list of Mapel for dropdowns.
     */
    public static function getMapelList()
    {
        return Cache::remember('mapel_list', self::LONG_CACHE_TTL, function () {
            return \App\Models\Mapel::select('id', 'nama', 'kode')->orderBy('nama')->get();
        });
    }

    /**
     * Clear specific cache keys.
     */
    public static function clearDashboardCache(): void
    {
        Cache::forget('dashboard_stats');
        Cache::forget('recent_ppdb_5');
        Cache::forget('kelas_with_counts');
        Cache::forget('analytics_summary_stats');
    }

    public static function clearGuruCache(): void
    {
        Cache::forget('guru_list');
    }

    public static function clearMapelCache(): void
    {
        Cache::forget('mapel_list');
    }

    public static function clearAllCache(): void
    {
        self::clearDashboardCache();
        self::clearGuruCache();
        self::clearMapelCache();
        Cache::flush();
    }

    /**
     * Get Financial Stats for Dashboard.
     */
    public static function getFinancialStats(): array
    {
        return Cache::remember('financial_stats', self::CACHE_TTL, function () {
            $stats = Tagihan::selectRaw("
                SUM(nominal) as total,
                SUM(CASE WHEN status = 'paid' THEN nominal ELSE 0 END) as paid,
                SUM(CASE WHEN status = 'pending' THEN nominal ELSE 0 END) as pending
            ")->first();

            $totalTagihan = $stats->total ?? 0;
            $totalPaid = $stats->paid ?? 0;

            return [
                'total_tagihan' => $totalTagihan,
                'total_paid' => $totalPaid,
                'total_pending' => $stats->pending ?? 0,
                'collection_rate' => $totalTagihan > 0 ? round(($totalPaid / $totalTagihan) * 100, 1) : 0,
            ];
        });
    }

    /**
     * Get Attendance stats for a specific date.
     */
    public static function getAttendanceStats(string $date): array
    {
        return Cache::remember('attendance_stats_' . $date, self::CACHE_TTL, function () use ($date) {
            $stats = Attendance::where('tanggal', $date)
                ->selectRaw('status, count(*) as count')
                ->groupBy('status')
                ->pluck('count', 'status')
                ->toArray();

            return [
                'hadir' => $stats['hadir'] ?? 0,
                'izin' => $stats['izin'] ?? 0,
                'sakit' => $stats['sakit'] ?? 0,
                'alpha' => $stats['alpha'] ?? 0,
            ];
        });
    }
}
