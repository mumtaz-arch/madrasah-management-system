<?php

namespace App\Livewire\Admin\Ppdb;

use App\Models\PpdbRegistration;
use App\Models\Santri;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Str;

class PpdbDetail extends Component
{
    public PpdbRegistration $registration;

    public function mount(PpdbRegistration $registration)
    {
        $this->registration = $registration;
    }

    public function updateStatus(string $status)
    {
        $this->registration->update(['status' => $status]);
        session()->flash('success', 'Status berhasil diperbarui.');
    }

    public function convertToSantri()
    {
        // Create user account
        $user = User::create([
            'name' => $this->registration->nama_lengkap,
            'email' => $this->registration->email,
            'password' => bcrypt('password123'),
            'role' => 'santri',
            'is_active' => true,
        ]);

        // Generate NIS
        $year = date('y');
        $lastSantri = Santri::where('nis', 'like', $year . '%')->orderBy('nis', 'desc')->first();
        $sequence = $lastSantri ? (int)substr($lastSantri->nis, -4) + 1 : 1;
        $nis = $year . str_pad($sequence, 4, '0', STR_PAD_LEFT);

        // Create santri record
        Santri::create([
            'user_id' => $user->id,
            'nis' => $nis,
            'nisn' => $this->registration->nisn,
            'nama_lengkap' => $this->registration->nama_lengkap,
            'tempat_lahir' => $this->registration->tempat_lahir,
            'tanggal_lahir' => $this->registration->tanggal_lahir,
            'jenis_kelamin' => $this->registration->jenis_kelamin,
            'alamat' => $this->registration->alamat,
            'no_hp' => $this->registration->no_hp,
            'nama_ayah' => $this->registration->nama_ayah,
            'nama_ibu' => $this->registration->nama_ibu,
            'tahun_masuk' => date('Y'),
            'status' => 'aktif',
        ]);

        // Update registration status
        $this->registration->update(['status' => 'accepted']);

        session()->flash('success', 'Pendaftar berhasil dikonversi menjadi santri dengan NIS: ' . $nis);
        return redirect()->route('admin.ppdb.index');
    }

    public function render()
    {
        return view('livewire.admin.ppdb.ppdb-detail');
    }
}
