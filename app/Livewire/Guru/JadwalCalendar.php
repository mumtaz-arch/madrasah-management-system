<?php

namespace App\Livewire\Guru;

use App\Models\Jadwal;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class JadwalCalendar extends Component
{
    public $showJournalModal = false;
    public $selectedJadwal = null;
    public $isOutsideTime = false;
    public $outsideTimeMessage = '';
    public $attendanceList = [];
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

    public function openJournalModal($jadwalId)
    {
        $jadwal = Jadwal::with(['kelas.santris' => function($q) {
            $q->where('status', 'aktif')->orderBy('nama_lengkap');
        }, 'mapel'])->find($jadwalId);
        
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

        $existingJournal = \App\Models\TeacherJournal::where('jadwal_id', $jadwalId)
            ->whereDate('date', today())
            ->first();

        if ($existingJournal) {
             $this->dispatch('error', 'Jurnal untuk jadwal ini sudah diisi.');
             return;
        }

        $this->selectedJadwal = $jadwal;
        
        $this->attendanceList = [];
        foreach ($jadwal->kelas->santris as $santri) {
            $this->attendanceList[] = [
                'id' => $santri->id,
                'nama' => $santri->nama_lengkap,
                'status' => 'H',
            ];
        }

        $this->journalForm = [
            'topic' => '',
            'method' => '',
            'notes' => '',
        ];

        $this->showJournalModal = true;
    }

    public function toggleAttendance($index, $status)
    {
        if (isset($this->attendanceList[$index])) {
            $this->attendanceList[$index]['status'] = $status;
        }
    }

    public function closeJournalModal()
    {
        $this->showJournalModal = false;
        $this->selectedJadwal = null;
        $this->attendanceList = [];
        $this->isOutsideTime = false;
        $this->outsideTimeMessage = '';
    }

    public function saveJournal()
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

        $presentCount = collect($this->attendanceList)->where('status', 'H')->count();
        $absentCount = collect($this->attendanceList)->whereIn('status', ['S', 'I', 'A'])->count();

        \App\Models\TeacherJournal::create([
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

    public function render()
    {
        $guru = auth()->user()->guru;
        
        if (!$guru) {
            return view('livewire.guru.jadwal-calendar', [
                'jadwals' => collect(),
            ]);
        }

        $today = strtolower(now()->locale('id')->dayName);
        
        $jadwals = Jadwal::with(['mapel', 'kelas'])
            ->where('guru_id', $guru->id)
            ->where('hari', $today)
            ->orderBy('jam_mulai')
            ->get();

        foreach ($jadwals as $jadwal) {
            $jadwal->is_filled = \App\Models\TeacherJournal::where('jadwal_id', $jadwal->id)
                ->whereDate('date', today())
                ->exists();
        }

        return view('livewire.guru.jadwal-calendar', [
            'jadwals' => $jadwals,
            'hariIni' => $today,
        ]);
    }
}
