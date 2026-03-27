<?php

namespace App\Livewire\Admin\Settings;

use Livewire\Component;
use App\Models\AppSetting;
use Illuminate\Support\Facades\Artisan;

class SettingsIndex extends Component
{
    // Informasi Pesantren
    public $nama_pesantren;
    public $nama_singkat;
    public $alamat_lengkap;
    public $no_telepon;
    public $whatsapp;
    public $email;
    public $nama_pimpinan;
    public $tahun_berdiri;
    public $visi_pesantren;
    public $misi_pesantren;
    
    // Pengaturan PPDB
    public $ppdb_status;
    public $ppdb_tahun_ajaran;
    public $ppdb_kuota;
    public $ppdb_start_date;
    public $ppdb_end_date;
    public $ppdb_biaya;
    public $ppdb_info;

    public function mount()
    {
        $this->nama_pesantren = AppSetting::getValue('nama_pesantren', 'Pondok Pesantren Nurul Hidayah');
        $this->nama_singkat = AppSetting::getValue('nama_singkat', 'PPNH');
        $this->alamat_lengkap = AppSetting::getValue('alamat_lengkap', 'Jl. Pesantren No. 123');
        $this->no_telepon = AppSetting::getValue('no_telepon', '(022) 1234567');
        $this->whatsapp = AppSetting::getValue('whatsapp', '08123456789');
        $this->email = AppSetting::getValue('email', 'info@ponpes.sch.id');
        $this->nama_pimpinan = AppSetting::getValue('nama_pimpinan', 'KH. Ahmad Hidayatullah');
        $this->tahun_berdiri = AppSetting::getValue('tahun_berdiri', '1985');
        $this->visi_pesantren = AppSetting::getValue('visi_pesantren', 'Menjadi lembaga pendidikan Islam terdepan');
        $this->misi_pesantren = AppSetting::getValue('misi_pesantren', '1. Menyelenggarakan pendidikan...');
        
        $this->ppdb_status = AppSetting::getValue('ppdb_status', '1');
        $this->ppdb_tahun_ajaran = AppSetting::getValue('ppdb_tahun_ajaran', '2025/2026');
        $this->ppdb_kuota = AppSetting::getValue('ppdb_kuota', '150');
        $this->ppdb_start_date = AppSetting::getValue('ppdb_start_date', '2025-01-01');
        $this->ppdb_end_date = AppSetting::getValue('ppdb_end_date', '2025-06-30');
        $this->ppdb_biaya = AppSetting::getValue('ppdb_biaya', '250.000');
        $this->ppdb_info = AppSetting::getValue('ppdb_info', 'Pendaftaran dapat dilakukan secara online.');
    }

    public function save()
    {
        $settings = [
            // General Info
            'nama_pesantren' => ['value' => $this->nama_pesantren, 'type' => 'string'],
            'nama_singkat' => ['value' => $this->nama_singkat, 'type' => 'string'],
            'alamat_lengkap' => ['value' => $this->alamat_lengkap, 'type' => 'string'],
            'no_telepon' => ['value' => $this->no_telepon, 'type' => 'string'],
            'whatsapp' => ['value' => $this->whatsapp, 'type' => 'string'],
            'email' => ['value' => $this->email, 'type' => 'string'],
            'nama_pimpinan' => ['value' => $this->nama_pimpinan, 'type' => 'string'],
            'tahun_berdiri' => ['value' => $this->tahun_berdiri, 'type' => 'string'],
            'visi_pesantren' => ['value' => $this->visi_pesantren, 'type' => 'string'],
            'misi_pesantren' => ['value' => $this->misi_pesantren, 'type' => 'string'],
            
            // PPDB
            'ppdb_status' => ['value' => $this->ppdb_status, 'type' => 'boolean'],
            'ppdb_tahun_ajaran' => ['value' => $this->ppdb_tahun_ajaran, 'type' => 'string'],
            'ppdb_kuota' => ['value' => $this->ppdb_kuota, 'type' => 'string'],
            'ppdb_start_date' => ['value' => $this->ppdb_start_date, 'type' => 'string'],
            'ppdb_end_date' => ['value' => $this->ppdb_end_date, 'type' => 'string'],
            'ppdb_biaya' => ['value' => $this->ppdb_biaya, 'type' => 'string'],
            'ppdb_info' => ['value' => $this->ppdb_info, 'type' => 'string'],
        ];

        foreach ($settings as $key => $data) {
            AppSetting::updateOrCreate(
                ['key' => $key],
                ['value' => $data['value'], 'type' => $data['type']]
            );
        }

        session()->flash('success', 'Pengaturan berhasil disimpan!');
        
        // Clear cache if you use cache for settings
        // Artisan::call('cache:clear');
    }

    public function render()
    {
        return view('livewire.admin.settings.settings-index');
    }
}
