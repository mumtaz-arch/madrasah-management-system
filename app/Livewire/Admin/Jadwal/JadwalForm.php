<?php

namespace App\Livewire\Admin\Jadwal;

use App\Models\Jadwal;
use App\Models\Kelas;
use App\Models\Guru;
use App\Models\Mapel;
use Livewire\Component;

class JadwalForm extends Component
{
    public ?Jadwal $jadwal = null;
    public bool $isEdit = false;
    
    public string $guru_id = '';
    public string $kelas_id = '';
    public string $mapel_id = '';
    public string $hari = 'senin';
    public string $jam_mulai = '07:00';
    public string $jam_selesai = '08:30';
    public string $tahun_ajaran = '';

    public function mount(?Jadwal $jadwal = null)
    {
        if ($jadwal && $jadwal->exists) {
            $this->jadwal = $jadwal;
            $this->isEdit = true;
            $this->guru_id = (string) $jadwal->guru_id;
            $this->kelas_id = (string) $jadwal->kelas_id;
            $this->mapel_id = (string) $jadwal->mapel_id;
            $this->hari = $jadwal->hari;
            $this->jam_mulai = $jadwal->jam_mulai;
            $this->jam_selesai = $jadwal->jam_selesai;
            $this->tahun_ajaran = $jadwal->tahun_ajaran;
        } else {
            $this->tahun_ajaran = date('Y') . '/' . (date('Y') + 1);
        }
    }

    public function rules()
    {
        return [
            'guru_id' => ['required', 'exists:gurus,id'],
            'kelas_id' => ['required', 'exists:kelas,id'],
            'mapel_id' => ['required', 'exists:mapels,id'],
            'hari' => ['required', 'in:senin,selasa,rabu,kamis,jumat,sabtu'],
            'jam_mulai' => ['required'],
            'jam_selesai' => ['required', 'after:jam_mulai'],
            'tahun_ajaran' => ['required', 'string', 'max:20'],
        ];
    }

    public function save()
    {
        $this->validate();

        $data = [
            'guru_id' => $this->guru_id,
            'kelas_id' => $this->kelas_id,
            'mapel_id' => $this->mapel_id,
            'hari' => $this->hari,
            'jam_mulai' => $this->jam_mulai,
            'jam_selesai' => $this->jam_selesai,
            'tahun_ajaran' => $this->tahun_ajaran,
        ];

        if ($this->isEdit) {
            $this->jadwal->update($data);
            session()->flash('success', 'Jadwal berhasil diperbarui.');
        } else {
            Jadwal::create($data);
            session()->flash('success', 'Jadwal berhasil ditambahkan.');
        }

        return redirect()->route('admin.jadwal.index');
    }

    public function render()
    {
        return view('livewire.admin.jadwal.jadwal-form', [
            'guruList' => Guru::where('status', 'aktif')->orderBy('nama_lengkap')->get(),
            'kelasList' => Kelas::orderBy('tingkat')->orderBy('nama_kelas')->get(),
            'mapelList' => Mapel::orderBy('nama')->get(),
        ]);
    }
}
