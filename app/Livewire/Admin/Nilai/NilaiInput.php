<?php

namespace App\Livewire\Admin\Nilai;

use App\Models\Nilai;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Santri;
use App\Models\Guru;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class NilaiInput extends Component
{
    public string $kelas_id = '';
    public string $mapel_id = '';
    public string $guru_id = '';
    public string $jenis = 'UH';
    public string $semester = '1';
    public string $tahun_ajaran = '';
    
    public array $nilaiInputs = [];
    public bool $showForm = false;

    public function mount()
    {
        $this->tahun_ajaran = date('Y') . '/' . (date('Y') + 1);
        
        // Default to first active guru if user is guru
        $user = Auth::user();
        if ($user->role === 'guru' && $user->guru) {
            $this->guru_id = (string) $user->guru->id;
        }
    }

    public function loadSantri()
    {
        $this->validate([
            'kelas_id' => 'required',
            'mapel_id' => 'required',
            'guru_id' => 'required',
        ]);

        $santris = Santri::where('kelas_id', $this->kelas_id)
            ->where('status', 'aktif')
            ->orderBy('nama_lengkap')
            ->get();

        $mapel = Mapel::find($this->mapel_id);

        $this->nilaiInputs = [];
        foreach ($santris as $santri) {
            // Check if nilai already exists
            $existingNilai = Nilai::where('santri_id', $santri->id)
                ->where('mapel_id', $this->mapel_id)
                ->where('jenis', $this->jenis)
                ->where('semester', $this->semester)
                ->where('tahun_ajaran', $this->tahun_ajaran)
                ->first();

            $this->nilaiInputs[] = [
                'santri_id' => $santri->id,
                'nama' => $santri->nama_lengkap,
                'nis' => $santri->nis,
                'nilai' => $existingNilai ? $existingNilai->nilai : '',
                'catatan' => $existingNilai ? $existingNilai->catatan : '',
                'kkm' => $mapel->kkm,
                'existing_id' => $existingNilai ? $existingNilai->id : null,
            ];
        }

        $this->showForm = true;
    }

    public function saveNilai()
    {
        foreach ($this->nilaiInputs as $input) {
            if ($input['nilai'] !== '' && $input['nilai'] !== null) {
                $data = [
                    'santri_id' => $input['santri_id'],
                    'mapel_id' => $this->mapel_id,
                    'guru_id' => $this->guru_id,
                    'jenis' => $this->jenis,
                    'nilai' => $input['nilai'],
                    'semester' => $this->semester,
                    'tahun_ajaran' => $this->tahun_ajaran,
                    'catatan' => $input['catatan'] ?? null,
                ];

                if ($input['existing_id']) {
                    Nilai::find($input['existing_id'])->update($data);
                } else {
                    Nilai::create($data);
                }
            }
        }

        session()->flash('success', 'Nilai berhasil disimpan.');
        return redirect()->route('admin.nilai.index');
    }

    public function render()
    {
        return view('livewire.admin.nilai.nilai-input', [
            'kelasList' => Kelas::orderBy('tingkat')->orderBy('nama_kelas')->get(),
            'mapelList' => Mapel::orderBy('nama')->get(),
            'guruList' => Guru::where('status', 'aktif')->orderBy('nama_lengkap')->get(),
        ]);
    }
}
