<?php

namespace App\Livewire\Admin\Attendance;

use App\Models\GuruAttendance as GuruAttendanceModel;
use App\Models\Guru;
use Livewire\Component;
use Carbon\Carbon;

class GuruAttendanceInput extends Component
{
    public string $tanggal;
    public array $attendances = [];
    public bool $saved = false;

    public function mount()
    {
        $this->tanggal = Carbon::today()->format('Y-m-d');
        $this->loadAttendances();
    }

    public function updatedTanggal()
    {
        $this->loadAttendances();
    }

    public function loadAttendances()
    {
        $gurus = Guru::orderBy('nama_lengkap')->get();
        $existingAttendances = GuruAttendanceModel::where('tanggal', $this->tanggal)
            ->get()
            ->keyBy('guru_id');

        $this->attendances = [];
        foreach ($gurus as $guru) {
            $existing = $existingAttendances->get($guru->id);
            $this->attendances[$guru->id] = [
                'guru_id' => $guru->id,
                'nama' => $guru->nama_lengkap,
                'nip' => $guru->nip,
                'status' => $existing?->status ?? 'hadir',
                'jam_masuk' => $existing?->jam_masuk?->format('H:i') ?? '',
                'jam_pulang' => $existing?->jam_pulang?->format('H:i') ?? '',
            ];
        }
    }

    public function saveAttendances()
    {
        if (empty($this->attendances)) {
            return;
        }

        foreach ($this->attendances as $guruId => $data) {
            GuruAttendanceModel::updateOrCreate(
                [
                    'tanggal' => $this->tanggal,
                    'guru_id' => $guruId,
                ],
                [
                    'status' => $data['status'],
                    'jam_masuk' => $data['jam_masuk'] ?: null,
                    'jam_pulang' => $data['jam_pulang'] ?: null,
                ]
            );
        }

        $this->saved = true;
        session()->flash('success', 'Presensi guru berhasil disimpan!');
    }

    public function render()
    {
        $stats = $this->getStats();
        return view('livewire.admin.attendance.guru-attendance-input', [
            'stats' => $stats,
        ]);
    }

    private function getStats(): array
    {
        if (empty($this->attendances)) {
            return ['hadir' => 0, 'izin' => 0, 'sakit' => 0, 'alpha' => 0];
        }

        $stats = ['hadir' => 0, 'izin' => 0, 'sakit' => 0, 'alpha' => 0];
        foreach ($this->attendances as $att) {
            $stats[$att['status']]++;
        }
        return $stats;
    }
}
