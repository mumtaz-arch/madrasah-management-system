<?php

namespace App\Livewire\Admin\Jadwal;

use App\Models\Jadwal;
use App\Models\Kelas;
use App\Models\Guru;
use Livewire\Component;
use Livewire\WithPagination;

class JadwalIndex extends Component
{
    // Remove WithPagination as we show all for calendar
    // use WithPagination; 

    public string $search = '';
    public string $filterKelas = '';
    public string $filterGuru = '';
    
    // Modal State
    public bool $showEditModal = false;
    public bool $isEdit = false;
    public bool $showDeleteModal = false;
    public ?int $jadwalIdToDelete = null;

    // Form Data
    public $form = [
        'id' => null,
        'guru_id' => '',
        'kelas_id' => '',
        'mapel_id' => '',
        'hari' => 'senin',
        'jam_mulai' => '',
        'jam_selesai' => '',
        'tahun_ajaran' => '',
    ];

    protected $queryString = [
        'search' => ['except' => ''],
        'filterKelas' => ['except' => ''],
        'filterGuru' => ['except' => ''],
    ];

    public function rules()
    {
        return [
            'form.guru_id' => ['required', 'exists:gurus,id'],
            'form.kelas_id' => ['required', 'exists:kelas,id'],
            'form.mapel_id' => ['required', 'exists:mapels,id'],
            'form.hari' => ['required', 'in:senin,selasa,rabu,kamis,jumat,sabtu'],
            'form.jam_mulai' => ['required'],
            'form.jam_selesai' => ['required', 'after:form.jam_mulai'],
            'form.tahun_ajaran' => ['required', 'string', 'max:20'],
        ];
    }

    public function mount()
    {
        $this->form['tahun_ajaran'] = date('Y') . '/' . (date('Y') + 1);
    }

    public function create()
    {
        $this->resetForm();
        $this->isEdit = false;
        $this->showEditModal = true;
    }

    public function edit(Jadwal $jadwal)
    {
        $this->form = [
            'id' => $jadwal->id,
            'guru_id' => $jadwal->guru_id,
            'kelas_id' => $jadwal->kelas_id,
            'mapel_id' => $jadwal->mapel_id,
            'hari' => $jadwal->hari,
            'jam_mulai' => \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i'), 
            'jam_selesai' => \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i'),
            'tahun_ajaran' => $jadwal->tahun_ajaran,
        ];
        $this->isEdit = true;
        $this->showEditModal = true;
    }

    public function save()
    {
        $this->validate();

        $data = [
            'guru_id' => $this->form['guru_id'],
            'kelas_id' => $this->form['kelas_id'],
            'mapel_id' => $this->form['mapel_id'],
            'hari' => $this->form['hari'],
            'jam_mulai' => $this->form['jam_mulai'],
            'jam_selesai' => $this->form['jam_selesai'],
            'tahun_ajaran' => $this->form['tahun_ajaran'],
        ];

        if ($this->isEdit && $this->form['id']) {
            Jadwal::find($this->form['id'])?->update($data);
            session()->flash('success', 'Jadwal berhasil diperbarui.');
        } else {
            Jadwal::create($data);
            session()->flash('success', 'Jadwal berhasil ditambahkan.');
        }

        $this->showEditModal = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->form = [
            'id' => null,
            'guru_id' => '',
            'kelas_id' => '',
            'mapel_id' => '',
            'hari' => 'senin',
            'jam_mulai' => '07:00',
            'jam_selesai' => '08:30',
            'tahun_ajaran' => date('Y') . '/' . (date('Y') + 1),
        ];
        $this->resetErrorBag();
    }

    public function confirmDelete(int $jadwalId)
    {
        $this->jadwalIdToDelete = $jadwalId;
        $this->showDeleteModal = true;
    }

    public function deleteJadwal()
    {
        if ($this->jadwalIdToDelete) {
            Jadwal::find($this->jadwalIdToDelete)?->delete();
            session()->flash('success', 'Jadwal berhasil dihapus.');
        }
        $this->showDeleteModal = false;
        $this->jadwalIdToDelete = null;
    }

    public function render()
    {
        $query = Jadwal::with(['guru', 'kelas', 'mapel'])
            ->when($this->search, function ($query) {
                $query->whereHas('mapel', function ($q) {
                    $q->where('nama', 'like', '%' . $this->search . '%');
                })->orWhereHas('guru', function ($q) {
                    $q->where('nama_lengkap', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->filterKelas, function ($query) {
                $query->where('kelas_id', $this->filterKelas);
            })
            ->when($this->filterGuru, function ($query) {
                $query->where('guru_id', $this->filterGuru);
            })
            ->orderBy('jam_mulai');

        $jadwals = $query->get()->groupBy('hari');

        // Ensure all days exist and group by class within each day
        $days = ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu'];
        $groupedJadwals = collect($days)->mapWithKeys(function ($day) use ($jadwals) {
            $daySchedules = $jadwals->get($day, collect());
            // Group the day's schedules by class name
            $byClass = $daySchedules->groupBy(function($item) {
                return $item->kelas->nama_kelas;
            })->sortKeys();
            
            return [$day => $byClass];
        });

        // Soft Color Palette
        $colors = [
            '#ffeb3b', // Yellow
            '#ffcdd2', // Red
            '#c8e6c9', // Green
            '#bbdefb', // Blue
            '#e1bee7', // Purple
            '#ffe0b2', // Orange
            '#b2dfdb', // Teal
            '#f0f4c3', // Lime
            '#d1c4e9', // Deep Purple Light
            '#ffecb3', // Amber Light
        ];
        
        $mapels = \App\Models\Mapel::orderBy('nama')->get();
        $mapelColors = $mapels->mapWithKeys(function ($item, $key) use ($colors) {
            return [$item->id => $colors[$key % count($colors)]];
        });

        return view('livewire.admin.jadwal.jadwal-index', [
            'groupedJadwals' => $groupedJadwals,
            'kelasList' => Kelas::orderBy('tingkat')->orderBy('nama_kelas')->get(),
            'guruList' => Guru::where('status', 'aktif')->orderBy('nama_lengkap')->get(),
            'mapelList' => $mapels,
            'mapelColors' => $mapelColors,
        ]);
    }
}
