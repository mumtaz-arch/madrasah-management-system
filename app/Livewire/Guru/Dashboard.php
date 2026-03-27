<?php

namespace App\Livewire\Guru;

use App\Models\Jadwal;
use App\Models\Nilai;
use App\Models\Kelas;
use App\Models\Attendance;
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

        $nowDate = now();
        $openTime = \Carbon\Carbon::parse(\App\Models\AppSetting::getValue('journal_open_time', '07:00'));
        $closeTime = \Carbon\Carbon::parse(\App\Models\AppSetting::getValue('journal_close_time', '16:00'));

        if ($nowDate->format('H:i') < $openTime->format('H:i') || $nowDate->format('H:i') > $closeTime->format('H:i')) {
            $this->isOutsideTime = true;
            $this->outsideTimeMessage = 'Waktu pengisian jurnal sudah lewat (' . $openTime->format('H:i') . ' - ' . $closeTime->format('H:i') . '). Anda tidak dapat mengisi jurnal di luar jam tersebut.';
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
        
        // Fetch today's actual attendances for this class
        $todayAttendances = Attendance::where('kelas_id', $jadwal->kelas_id)
            ->where('tanggal', today()->format('Y-m-d'))
            ->get()
            ->keyBy('santri_id');

        // Fetch today's Kegiatan attendances for this class
        $kelasSantriIds = $jadwal->kelas->santris->pluck('id');
        $todayKegiatans = \App\Models\KegiatanAttendance::whereIn('santri_id', $kelasSantriIds)
            ->where('tanggal', today()->format('Y-m-d'))
            ->get()
            ->keyBy('santri_id');

        // Build per-student attendance list based on RFID scans
        $this->attendanceList = [];
        foreach ($jadwal->kelas->santris as $santri) {
            $att = $todayAttendances->get($santri->id);
            $keg = $todayKegiatans->get($santri->id);
            
            // Map status from db to journal abbreviation
            $statusCode = 'A'; // Default Alfa / Not yet scanned
            if ($att) {
                $statusCode = match($att->status) {
                    'hadir' => 'H',
                    'terlambat' => 'T',
                    'sakit' => 'S',
                    'izin' => 'I',
                    default => 'A',
                };
            } elseif ($keg) {
                // If they didn't check-in academically but they checked into a Kegiatan today
                $statusCode = 'K';
            }

            $this->attendanceList[] = [
                'id' => $santri->id,
                'nama' => $santri->nama_lengkap,
                'status' => $statusCode,
                'waktu_masuk' => $att ? $att->waktu_masuk : null
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
        $nowDate = now();
        $openTime = \Carbon\Carbon::parse(\App\Models\AppSetting::getValue('journal_open_time', '07:00'));
        $closeTime = \Carbon\Carbon::parse(\App\Models\AppSetting::getValue('journal_close_time', '16:00'));

        if ($nowDate->format('H:i') < $openTime->format('H:i') || $nowDate->format('H:i') > $closeTime->format('H:i')) {
            $this->dispatch('error', 'Pengisian jurnal hanya dapat dilakukan pukul ' . $openTime->format('H:i') . ' - ' . $closeTime->format('H:i') . '.');
            return;
        }

        $this->validate();

        if (!$this->selectedJadwal) {
            return;
        }

        // Calculate counts from attendance list
        $attendanceCollection = collect($this->attendanceList);
        $presentCount = $attendanceCollection->whereIn('status', ['H', 'T'])->count();
        $absentCount = $attendanceCollection->whereIn('status', ['S', 'I', 'A', 'K'])->count();

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
                'kelasWali' => null,
                'presensiKelasHariIni' => [],
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

        // Check if Guru is a Wali Kelas
        $kelasWali = Kelas::where('wali_kelas_id', $guru->id)->first();
        $presensiKelasHariIni = [];
        
        if ($kelasWali) {
            $today = \Carbon\Carbon::today()->format('Y-m-d');
            $attendances = Attendance::where('kelas_id', $kelasWali->id)
                ->where('tanggal', $today)
                ->get();
            
            $presensiKelasHariIni = [
                'hadir' => $attendances->where('status', 'hadir')->count(),
                'izin' => $attendances->where('status', 'izin')->count(),
                'sakit' => $attendances->where('status', 'sakit')->count(),
                'alpha' => $attendances->where('status', 'alpha')->count(),
                'total_santri' => $kelasWali->santris()->count(),
            ];
            $presensiKelasHariIni['belum_absen'] = max(0, $presensiKelasHariIni['total_santri'] - count($attendances));
        }

        return view('livewire.guru.dashboard', [
            'guru' => $guru,
            'jadwalHariIni' => $jadwalHariIni,
            'kelasAjar' => $kelasAjar,
            'stats' => $stats,
            'kelasWali' => $kelasWali,
            'presensiKelasHariIni' => $presensiKelasHariIni,
        ]);
    }
}
