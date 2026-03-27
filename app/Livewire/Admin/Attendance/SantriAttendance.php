<?php

namespace App\Livewire\Admin\Attendance;

use App\Models\Attendance;
use App\Models\Kelas;
use App\Models\Santri;
use Livewire\Component;
use Carbon\Carbon;

class SantriAttendance extends Component
{
    public ?int $kelasId = null;
    public string $tanggal;
    public array $attendances = [];
    public bool $saved = false;

    public function mount()
    {
        $this->tanggal = Carbon::today()->format('Y-m-d');
    }

    public function updatedKelasId()
    {
        $this->loadAttendances();
    }

    public function updatedTanggal()
    {
        $this->loadAttendances();
    }

    public function loadAttendances()
    {
        if (!$this->kelasId) {
            $this->attendances = [];
            return;
        }

        $santris = Santri::where('kelas_id', $this->kelasId)->orderBy('nama_lengkap')->get();
        $existingAttendances = Attendance::where('kelas_id', $this->kelasId)
            ->where('tanggal', $this->tanggal)
            ->get()
            ->keyBy('santri_id');

        $this->attendances = [];
        foreach ($santris as $santri) {
            $att = $existingAttendances[$santri->id] ?? null;
            $this->attendances[$santri->id] = [
                'santri_id' => $santri->id,
                'nama' => $santri->nama_lengkap,
                'nis' => $santri->nis,
                'status' => $att ? $att->status : 'hadir',
                'waktu_masuk' => $att && $att->waktu_masuk ? \Carbon\Carbon::parse($att->waktu_masuk)->format('H:i') : '',
                'waktu_pulang' => $att && $att->waktu_pulang ? \Carbon\Carbon::parse($att->waktu_pulang)->format('H:i') : '',
            ];
        }
    }

    public function saveAttendances()
    {
        if (!$this->kelasId || empty($this->attendances)) {
            return;
        }

        foreach ($this->attendances as $santriId => $data) {
            Attendance::updateOrCreate(
                [
                    'tanggal' => $this->tanggal,
                    'santri_id' => $santriId,
                ],
                [
                    'kelas_id' => $this->kelasId,
                    'status' => $data['status'] ?? 'hadir',
                    'waktu_masuk' => !empty($data['waktu_masuk']) ? $data['waktu_masuk'] : null,
                    'waktu_pulang' => !empty($data['waktu_pulang']) ? $data['waktu_pulang'] : null,
                    'recorded_by' => auth()->id(),
                ]
            );
        }

        $this->saved = true;
        session()->flash('success', 'Presensi berhasil disimpan!');
    }

    public function render()
    {
        return view('livewire.admin.attendance.santri-attendance', [
            'kelasList' => Kelas::orderBy('nama_kelas')->get(),
            'stats' => $this->getStats(),
        ]);
    }

    private function getStats(): array
    {
        if (empty($this->attendances)) {
            return ['hadir' => 0, 'terlambat' => 0, 'izin' => 0, 'sakit' => 0, 'alpha' => 0];
        }

        $stats = ['hadir' => 0, 'terlambat' => 0, 'izin' => 0, 'sakit' => 0, 'alpha' => 0];
        foreach ($this->attendances as $att) {
            $status = $att['status'] ?? 'hadir';
            if (isset($stats[$status])) {
                $stats[$status]++;
            }
        }
        return $stats;
    }
}
