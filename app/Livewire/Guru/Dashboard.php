<?php

namespace App\Livewire\Guru;

use App\Models\Jadwal;
use App\Models\Nilai;
use App\Models\Kelas;
use App\Models\TeacherJournal;
use Livewire\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Component
{
    public $showJournalModal = false;
    public $selectedJadwal = null;
    public $isOutsideTime = false;
    public $outsideTimeMessage = '';
    public $attendanceList = []; // Per-student attendance
    public $journalForm = [
        'topic' => '',
        'method' => '',
        'notes' => '',
    ];

    protected $rules = [
        'journalForm.topic' => 'required|string|max:255',
        'journalForm.method' => 'required|string|max:255',
        'journalForm.notes' => 'nullable|string',
    ];

    public function openJournalModal(int $jadwalId): void
    {
        $jadwal = Jadwal::with(['kelas.santris' => function($q) {
            $q->where('status', 'aktif')
              ->select('id', 'nama_lengkap', 'kelas_id', 'status')
              ->orderBy('nama_lengkap');
        }, 'mapel:id,nama,kode'])->find($jadwalId);
        
        if (!$jadwal) {
            $this->dispatch('error', 'Jadwal tidak ditemukan.');
            return;
        }

        $today = strtolower(now()->locale('id')->dayName);
        if (strtolower($jadwal->hari) !== $today) {
            $this->dispatch('error', 'Anda hanya bisa mengisi jurnal untuk jadwal hari ini.');
            return;
        }

        $hour = now()->hour;
        if ($hour < 7 || $hour >= 15) {
            $this->isOutsideTime = true;
            $this->outsideTimeMessage = 'Waktu pengisian jurnal sudah lewat (07.00 - 15.00). Anda tidak dapat mengisi jurnal di luar jam tersebut.';
        } else {
            $this->isOutsideTime = false;
            $this->outsideTimeMessage = '';
        }

        $existingJournal = TeacherJournal::where('jadwal_id', $jadwalId)
            ->whereDate('date', today())
            ->exists();

        if ($existingJournal) {
             $this->dispatch('error', 'Jurnal untuk jadwal ini sudah diisi.');
             return;
        }

        $this->selectedJadwal = $jadwal;
        
        // Build per-student attendance list, default all to 'H' (Hadir)
        $this->attendanceList = [];
        foreach ($jadwal->kelas->santris as $santri) {
            $this->attendanceList[] = [
                'id' => $santri->id,
                'nama' => $santri->nama_lengkap,
                'status' => 'H', // H=Hadir, S=Sakit, I=Izin, A=Alfa
            ];
        }

        // Reset Form
        $this->journalForm = [
            'topic' => '',
            'method' => '',
            'notes' => '',
        ];

        $this->showJournalModal = true;
    }

    public function toggleAttendance(int $index, string $status): void
    {
        if (isset($this->attendanceList[$index])) {
            $this->attendanceList[$index]['status'] = $status;
        }
    }

    public function closeJournalModal(): void
    {
        $this->showJournalModal = false;
        $this->selectedJadwal = null;
        $this->attendanceList = [];
        $this->isOutsideTime = false;
        $this->outsideTimeMessage = '';
    }

    public function saveJournal(): void
    {
        // Server-side time guard
        $hour = now()->hour;
        if ($hour < 7 || $hour >= 15) {
            $this->dispatch('error', 'Pengisian jurnal hanya dapat dilakukan pukul 07.00 - 15.00.');
            return;
        }

        $this->validate();

        if (!$this->selectedJadwal) {
            return;
        }

        // Calculate counts from attendance list
        $attendanceCollection = collect($this->attendanceList);
        $presentCount = $attendanceCollection->where('status', 'H')->count();
        $absentCount = $attendanceCollection->whereIn('status', ['S', 'I', 'A'])->count();

        TeacherJournal::create([
            'teacher_id' => Auth::user()->guru->id,
            'jadwal_id' => $this->selectedJadwal->id,
            'class_id' => $this->selectedJadwal->kelas_id,
            'subject_id' => $this->selectedJadwal->mapel_id,
            'date' => today(),
            'topic' => $this->journalForm['topic'],
            'method' => $this->journalForm['method'],
            'present_count' => $presentCount,
            'absent_count' => $absentCount,
            'attendance_details' => $this->attendanceList,
            'notes' => $this->journalForm['notes'],
            'status' => 'sent',
            'submitted_at' => now(),
        ]);

        $this->closeJournalModal();
        $this->dispatch('success', 'Jurnal mengajar berhasil disimpan!');
    }

    public function render(): View
    {
        $user = Auth::user();
        $guru = $user->guru;

        if (!$guru) {
            return view('livewire.guru.dashboard', [
                'guru' => null,
                'jadwalHariIni' => collect(),
                'kelasAjar' => collect(),
                'stats' => [],
            ]);
        }

        $hariIni = strtolower(now()->locale('id')->dayName);
        $jadwalHariIni = Jadwal::with(['mapel:id,nama,kode', 'kelas:id,nama_kelas'])
            ->select('id', 'guru_id', 'mapel_id', 'kelas_id', 'hari', 'jam_mulai', 'jam_selesai')
            ->where('guru_id', $guru->id)
            ->where('hari', $hariIni)
            ->orderBy('jam_mulai')
            ->get();

        // Batch check filled journals — ONE query instead of N queries in loop
        $filledJadwalIds = TeacherJournal::where('teacher_id', $guru->id)
            ->whereDate('date', today())
            ->pluck('jadwal_id')
            ->toArray();

        foreach ($jadwalHariIni as $jadwal) {
            $jadwal->is_filled = in_array($jadwal->id, $filledJadwalIds);
        }

        $kelasAjar = Kelas::whereHas('jadwals', function ($q) use ($guru) {
            $q->where('guru_id', $guru->id);
        })->withCount('santris')
          ->select('id', 'nama_kelas')
          ->get();

        // Consolidate stats queries
        $totalJadwal = Jadwal::where('guru_id', $guru->id)->count();
        $nilaiInput = Nilai::where('guru_id', $guru->id)->count();
        $jurnalHariIni = count(array_filter($filledJadwalIds)); // Reuse already fetched data

        $stats = [
            'total_jadwal' => $totalJadwal,
            'total_kelas' => $kelasAjar->count(),
            'total_santri' => $kelasAjar->sum('santris_count'),
            'nilai_input' => $nilaiInput,
            'jurnal_hari_ini' => TeacherJournal::where('teacher_id', $guru->id)->whereDate('date', today())->count(),
        ];

        return view('livewire.guru.dashboard', [
            'guru' => $guru,
            'jadwalHariIni' => $jadwalHariIni,
            'kelasAjar' => $kelasAjar,
            'stats' => $stats,
        ]);
    }
}
