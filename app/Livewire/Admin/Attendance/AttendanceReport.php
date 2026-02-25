<?php

namespace App\Livewire\Admin\Attendance;

use App\Models\Attendance;
use App\Models\GuruAttendance as GuruAttendanceModel;
use App\Models\Kelas;
use Livewire\Component;
use Carbon\Carbon;

class AttendanceReport extends Component
{
    public string $filterType = 'santri';
    public ?int $kelasId = null;
    public string $startDate;
    public string $endDate;
    public array $reportData = [];

    public function mount()
    {
        $this->startDate = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->endDate = Carbon::now()->endOfMonth()->format('Y-m-d');
    }

    public function generateReport()
    {
        if ($this->filterType === 'santri') {
            $this->generateSantriReport();
        } else {
            $this->generateGuruReport();
        }
    }

    private function generateSantriReport()
    {
        $query = Attendance::with(['santri', 'kelas'])
            ->whereBetween('tanggal', [$this->startDate, $this->endDate])
            ->when($this->kelasId, fn($q) => $q->where('kelas_id', $this->kelasId));

        $attendances = $query->get()->groupBy('santri_id');

        $this->reportData = $attendances->map(function($records, $santriId) {
            $first = $records->first();
            $stats = [
                'hadir' => $records->where('status', 'hadir')->count(),
                'izin' => $records->where('status', 'izin')->count(),
                'sakit' => $records->where('status', 'sakit')->count(),
                'alpha' => $records->where('status', 'alpha')->count(),
            ];
            $total = array_sum($stats);
            $persentase = $total > 0 ? round(($stats['hadir'] / $total) * 100, 1) : 0;

            return [
                'nama' => $first->santri->nama_lengkap ?? '-',
                'nis' => $first->santri->nis ?? '-',
                'kelas' => $first->kelas->nama_kelas ?? '-',
                'stats' => $stats,
                'persentase' => $persentase,
            ];
        })->values()->toArray();
    }

    private function generateGuruReport()
    {
        $attendances = GuruAttendanceModel::with('guru')
            ->whereBetween('tanggal', [$this->startDate, $this->endDate])
            ->get()
            ->groupBy('guru_id');

        $this->reportData = $attendances->map(function($records, $guruId) {
            $first = $records->first();
            $stats = [
                'hadir' => $records->where('status', 'hadir')->count(),
                'izin' => $records->where('status', 'izin')->count(),
                'sakit' => $records->where('status', 'sakit')->count(),
                'alpha' => $records->where('status', 'alpha')->count(),
            ];
            $total = array_sum($stats);
            $persentase = $total > 0 ? round(($stats['hadir'] / $total) * 100, 1) : 0;

            return [
                'nama' => $first->guru->nama_lengkap ?? '-',
                'nis' => $first->guru->nip ?? '-',
                'kelas' => '-',
                'stats' => $stats,
                'persentase' => $persentase,
            ];
        })->values()->toArray();
    }

    public function render()
    {
        return view('livewire.admin.attendance.attendance-report', [
            'kelasList' => Kelas::orderBy('nama_kelas')->get(),
        ]);
    }
}
