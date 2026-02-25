<?php

namespace App\Livewire\Admin\Mapel;

use App\Models\Mapel;
use Livewire\Component;
use Illuminate\Validation\Rule;

class MapelForm extends Component
{
    public ?Mapel $mapel = null;
    public bool $isEdit = false;
    
    public string $kode = '';
    public string $nama = '';
    public string $kategori = 'umum';
    public int $kkm = 70;

    public function mount(?Mapel $mapel = null)
    {
        if ($mapel && $mapel->exists) {
            $this->mapel = $mapel;
            $this->isEdit = true;
            $this->kode = $mapel->kode;
            $this->nama = $mapel->nama;
            $this->kategori = $mapel->kategori;
            $this->kkm = $mapel->kkm;
        }
    }

    public function rules()
    {
        return [
            'kode' => ['required', 'string', 'max:20', Rule::unique('mapels', 'kode')->ignore($this->mapel?->id)],
            'nama' => ['required', 'string', 'max:100'],
            'kategori' => ['required', 'in:diniyah,umum,tahfidz,bahasa'],
            'kkm' => ['required', 'integer', 'min:0', 'max:100'],
        ];
    }

    public function save()
    {
        $this->validate();

        $data = [
            'kode' => strtoupper($this->kode),
            'nama' => $this->nama,
            'kategori' => $this->kategori,
            'kkm' => $this->kkm,
        ];

        if ($this->isEdit) {
            $this->mapel->update($data);
            session()->flash('success', 'Data mata pelajaran berhasil diperbarui.');
        } else {
            Mapel::create($data);
            session()->flash('success', 'Data mata pelajaran berhasil ditambahkan.');
        }

        return redirect()->route('admin.mapel.index');
    }

    public function render()
    {
        return view('livewire.admin.mapel.mapel-form');
    }
}
