<?php

namespace App\Livewire\Admin\Kelas;

use App\Models\Kelas;
use App\Models\Guru;
use Livewire\Component;
use Illuminate\Validation\Rule;

class KelasForm extends Component
{
    public ?Kelas $kelas = null;
    public bool $isEdit = false;
    
    public string $nama_kelas = '';
    public string $tingkat = '7';
    public string $tahun_ajaran = '';
    public ?string $wali_kelas_id = '';

    public function mount(?Kelas $kelas = null)
    {
        if ($kelas && $kelas->exists) {
            $this->kelas = $kelas;
            $this->isEdit = true;
            $this->nama_kelas = $kelas->nama_kelas;
            $this->tingkat = (string) $kelas->tingkat;
            $this->tahun_ajaran = $kelas->tahun_ajaran;
            $this->wali_kelas_id = (string) $kelas->wali_kelas_id;
        } else {
            $this->tahun_ajaran = date('Y') . '/' . (date('Y') + 1);
        }
    }

    public function rules()
    {
        return [
            'nama_kelas' => ['required', 'string', 'max:50'],
            'tingkat' => ['required', 'integer', 'min:7', 'max:12'],
            'tahun_ajaran' => ['required', 'string', 'max:20'],
            'wali_kelas_id' => ['nullable', 'exists:gurus,id'],
        ];
    }

    public function save()
    {
        $this->validate();

        $data = [
            'nama_kelas' => $this->nama_kelas,
            'tingkat' => $this->tingkat,
            'tahun_ajaran' => $this->tahun_ajaran,
            'wali_kelas_id' => $this->wali_kelas_id ?: null,
        ];

        if ($this->isEdit) {
            $this->kelas->update($data);
            session()->flash('success', 'Data kelas berhasil diperbarui.');
        } else {
            Kelas::create($data);
            session()->flash('success', 'Data kelas berhasil ditambahkan.');
        }

        return redirect()->route('admin.kelas.index');
    }

    public function render()
    {
        return view('livewire.admin.kelas.kelas-form', [
            'guruList' => Guru::where('status', 'aktif')->orderBy('nama_lengkap')->get(),
        ]);
    }
}
