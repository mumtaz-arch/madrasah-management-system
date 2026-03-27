<?php

namespace App\Livewire\Operator;

use App\Models\Attendance;
use App\Models\Santri;
use Livewire\Component;
use Livewire\Attributes\On;
use Carbon\Carbon;

class RfidScanner extends Component
{
    public string $rfid_uid = '';
    public ?string $kegiatan_id = '';
    public ?array $lastScanResult = null; 

    public function processScan()
    {
        $uid = trim($this->rfid_uid);
        $this->rfid_uid = ''; // Reset for next scan

        if (empty($uid)) {
            return;
        }

        // Retrieve settings
        $checkinStart = \App\Models\AppSetting::getValue('rfid_checkin_start', '05:30');
        $checkinEnd = \App\Models\AppSetting::getValue('rfid_checkin_end', '08:00');
        $checkoutStart = \App\Models\AppSetting::getValue('rfid_checkout_start', '13:00');
        $checkoutEnd = \App\Models\AppSetting::getValue('rfid_checkout_end', '17:00');
        $lateThreshold = \App\Models\AppSetting::getValue('rfid_late_threshold', '07:15');
        
        $msgUnregistered = \App\Models\AppSetting::getValue('msg_unregistered_card', 'Kartu Tidak Dikenali!');
        $msgCheckinSuccess = \App\Models\AppSetting::getValue('msg_checkin_success', 'Berhasil Absen Masuk');
        $msgCheckoutSuccess = \App\Models\AppSetting::getValue('msg_checkout_success', 'Berhasil Absen Pulang');
        $msgOutsideHours = \App\Models\AppSetting::getValue('msg_outside_hours', 'Di Luar Jam Presensi');

        $santri = Santri::where('rfid_uid', $uid)->with('kelas')->first();

        if (!$santri) {
            $this->lastScanResult = [
                'type' => 'error',
                'message' => $msgUnregistered,
                'santri' => null
            ];
            $this->dispatch('scan-error');
            return;
        }

        // Process Attendance
        $today = Carbon::today()->format('Y-m-d');
        $now = Carbon::now()->format('H:i');
        $nowFull = Carbon::now()->format('H:i:s');

        // ==== MODE KEGIATAN EKSTRAKURIKULER ====
        if (!empty($this->kegiatan_id)) {
            $kegiatan = \App\Models\Kegiatan::find($this->kegiatan_id);
            if (!$kegiatan) return;

            $kegiatanAttendance = \App\Models\KegiatanAttendance::where('santri_id', $santri->id)
                ->where('kegiatan_id', $this->kegiatan_id)
                ->where('tanggal', $today)
                ->first();

            if ($kegiatanAttendance) {
                // Already tapped for this kegiatan today
                $this->lastScanResult = [
                    'type' => 'warning',
                    'message' => 'Anda sudah absen untuk kegiatan ' . $kegiatan->nama_kegiatan . ' hari ini.',
                    'santri' => $this->formatSantriData($santri)
                ];
                $this->dispatch('scan-warning');
                return;
            }

            // Record Kegiatan Attendance
            \App\Models\KegiatanAttendance::create([
                'kegiatan_id' => $kegiatan->id,
                'santri_id' => $santri->id,
                'tanggal' => $today,
                'waktu_tap' => $nowFull,
            ]);

            $this->lastScanResult = [
                'type' => 'success',
                'message' => 'Berhasil Absen ' . $kegiatan->nama_kegiatan,
                'scan_type' => 'kegiatan',
                'time' => $nowFull,
                'santri' => $this->formatSantriData($santri)
            ];
            $this->dispatch('scan-success');
            return;
        }

        // ==== MODE PRESENSI HARIAN AKADEMIK ====
        $attendance = Attendance::where('santri_id', $santri->id)
            ->where('tanggal', $today)
            ->first();

        $scanType = '';
        $message = '';

        // Determing what time period it is currently
        if ($now >= $checkinStart && $now <= $checkinEnd) {
            // CHECK IN MODE
            if ($attendance && $attendance->waktu_masuk) {
                // Already checked in. Cooldown prevention.
                $timeIn = Carbon::parse($attendance->waktu_masuk);
                if (Carbon::now()->diffInMinutes($timeIn) < 5) {
                    $this->lastScanResult = [
                        'type' => 'warning',
                        'message' => 'Anda otomatis baru saja absen masuk. Harap tunggu.',
                        'santri' => $this->formatSantriData($santri)
                    ];
                    $this->dispatch('scan-warning');
                    return;
                }
                
                $this->lastScanResult = [
                    'type' => 'warning',
                    'message' => 'Anda sudah absen masuk hari ini.',
                    'santri' => $this->formatSantriData($santri)
                ];
                $this->dispatch('scan-warning');
                return;
            }

            // Create Check in
            $status = ($nowFull > Carbon::parse($lateThreshold)->format('H:i:s')) ? 'terlambat' : 'hadir';
            
            Attendance::create([
                'santri_id' => $santri->id,
                'kelas_id' => $santri->kelas_id,
                'tanggal' => $today,
                'waktu_masuk' => $nowFull,
                'status' => $status,
                'recorded_by' => auth()->id() ?? 1,
            ]);
            
            $scanType = 'masuk';
            $message = $msgCheckinSuccess . ($status == 'terlambat' ? ' (Terlambat)' : '');

        } elseif ($now >= $checkoutStart && $now <= $checkoutEnd) {
            // CHECK OUT MODE
            if ($attendance && $attendance->waktu_pulang) {
                // Already checked out
                $this->lastScanResult = [
                    'type' => 'warning',
                    'message' => 'Anda sudah absen pulang hari ini.',
                    'santri' => $this->formatSantriData($santri)
                ];
                $this->dispatch('scan-warning');
                return;
            }

            // Perform checkout (creates empty masuk if somehow they didn't check in)
            if (!$attendance) {
                Attendance::create([
                    'santri_id' => $santri->id,
                    'kelas_id' => $santri->kelas_id,
                    'tanggal' => $today,
                    'waktu_pulang' => $nowFull,
                    'status' => 'alpa', // Default status if only check out
                    'recorded_by' => auth()->id() ?? 1,
                ]);
            } else {
                $attendance->update(['waktu_pulang' => $nowFull]);
            }

            $scanType = 'pulang';
            $message = $msgCheckoutSuccess;

        } else {
            // OUTSIDE OPERATIONAL HOURS
            $this->lastScanResult = [
                'type' => 'error',
                'message' => $msgOutsideHours,
                'santri' => $this->formatSantriData($santri)
            ];
            $this->dispatch('scan-error');
            return;
        }

        $this->lastScanResult = [
            'type' => 'success',
            'message' => $message,
            'scan_type' => $scanType,
            'time' => $nowFull,
            'santri' => $this->formatSantriData($santri)
        ];
        $this->dispatch('scan-success');
    }

    private function formatSantriData($santri)
    {
        return [
            'nama_lengkap' => $santri->nama_lengkap,
            'nis' => $santri->nis,
            'kelas' => $santri->kelas ? $santri->kelas->nama_kelas : '-',
            'foto' => $santri->foto,
        ];
    }

    public function render()
    {
        $kegiatans = \App\Models\Kegiatan::where('is_active', true)->get();
        return view('livewire.operator.rfid-scanner', compact('kegiatans'))->layout('layouts.kiosk');
    }
}
