<?php

namespace App\Livewire\Wali;

use App\Models\Attendance;
use App\Models\Santri;
use Livewire\Component;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PresensiAnak extends Component
{
    public ?int $selectedSantriId = null;
    public string $bulan = '';
    public string $tahun = '';

    public function mount()
    {
        $this->bulan = date('m');
        $this->tahun = date('Y');
        
        // Auto-select first santri
        $wali = Auth::user()->wali;
        if ($wali) {
            $firstSantri = Santri::where('wali_id', $wali->id)->first();
            if ($firstSantri) {
                $this->selectedSantriId = $firstSantri->id;
            }
        }
    }

    public function render()
    {
        $wali = Auth::user()->wali;
        $santris = collect();
        $presensiData = [];
        $selectedSantri = null;
        $stats = [
            'hadir' => 0,
            'izin' => 0,
            'sakit' => 0,
            'alpha' => 0,
            'persentase' => 0,
        ];

        if ($wali) {
            $santris = Santri::where('wali_id', $wali->id)->get();

            if ($this->selectedSantriId) {
                $selectedSantri = Santri::with('kelas')->find($this->selectedSantriId);
                
                // Get presensi for selected month
                $startDate = Carbon::create($this->tahun, $this->bulan, 1)->startOfMonth();
                $endDate = $startDate->copy()->endOfMonth();
                
                $attendances = Attendance::where('santri_id', $this->selectedSantriId)
                    ->whereBetween('tanggal', [$startDate, $endDate])
                    ->orderBy('tanggal')
                    ->get();

                // Build calendar data
                $currentDate = $startDate->copy();
                while ($currentDate <= $endDate) {
                    $dayOfWeek = $currentDate->dayOfWeek;
                    
                    // Skip Sunday (0)
                    if ($dayOfWeek !== 0) {
                        $attendance = $attendances->firstWhere('tanggal', $currentDate->format('Y-m-d'));
                        $presensiData[] = [
                            'tanggal' => $currentDate->format('Y-m-d'),
                            'hari' => $currentDate->locale('id')->dayName,
                            'tanggal_display' => $currentDate->format('d'),
                            'status' => $attendance->status ?? null,
                            'waktu_masuk' => $attendance->waktu_masuk ?? null,
                            'waktu_pulang' => $attendance->waktu_pulang ?? null,
                            'keterangan' => $attendance->keterangan ?? null,
                        ];

                        // Count stats
                        if ($attendance) {
                            $stats[$attendance->status] = ($stats[$attendance->status] ?? 0) + 1;
                        }
                    }
                    
                    $currentDate->addDay();
                }

                // Calculate percentage
                $totalHari = $stats['hadir'] + $stats['izin'] + $stats['sakit'] + $stats['alpha'];
                if ($totalHari > 0) {
                    $stats['persentase'] = round(($stats['hadir'] / $totalHari) * 100, 1);
                }
            }
        }

        return view('livewire.wali.presensi-anak', [
            'santris' => $santris,
            'selectedSantri' => $selectedSantri,
            'presensiData' => $presensiData,
            'stats' => $stats,
            'bulanList' => $this->getBulanList(),
        ]);
    }

    private function getBulanList()
    {
        return [
            '01' => 'Januari', '02' => 'Februari', '03' => 'Maret',
            '04' => 'April', '05' => 'Mei', '06' => 'Juni',
            '07' => 'Juli', '08' => 'Agustus', '09' => 'September',
            '10' => 'Oktober', '11' => 'November', '12' => 'Desember',
        ];
    }
}
