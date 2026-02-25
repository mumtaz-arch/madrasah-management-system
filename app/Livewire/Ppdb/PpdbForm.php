<?php

namespace App\Livewire\Ppdb;

use App\Models\PpdbRegistration;
use App\Models\PpdbDocument;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class PpdbForm extends Component
{
    use WithFileUploads;

    public int $step = 1;
    
    // Step 1: Data Pribadi
    public string $nama_lengkap = '';
    public string $tempat_lahir = '';
    public string $tanggal_lahir = '';
    public string $jenis_kelamin = 'L';
    public string $alamat = '';
    public string $no_hp = '';
    public string $email = '';
    
    // Step 2: Data Orang Tua
    public string $nama_ayah = '';
    public string $nama_ibu = '';
    public string $pekerjaan_ayah = '';
    public string $pekerjaan_ibu = '';
    public string $no_hp_ortu = '';
    
    // Step 3: Data Pendidikan
    public string $asal_sekolah = '';
    public string $tahun_lulus = '';
    public string $nisn = '';
    
    // Step 4: Upload Dokumen
    public $file_kk;
    public $file_akta;
    public $file_ijazah;
    public $file_ktp_ortu;
    public $file_pas_foto;
    
    // Success
    public bool $submitted = false;
    public ?string $noRegistrasi = null;

    public function nextStep()
    {
        if ($this->step === 1) {
            $this->validate([
                'nama_lengkap' => 'required|string|max:255',
                'tempat_lahir' => 'required|string|max:100',
                'tanggal_lahir' => 'required|date',
                'jenis_kelamin' => 'required|in:L,P',
                'alamat' => 'required|string',
                'no_hp' => 'required|string|max:20',
                'email' => 'required|email',
            ]);
        } elseif ($this->step === 2) {
            $this->validate([
                'nama_ayah' => 'required|string|max:255',
                'nama_ibu' => 'required|string|max:255',
                'no_hp_ortu' => 'required|string|max:20',
            ]);
        } elseif ($this->step === 3) {
            $this->validate([
                'asal_sekolah' => 'required|string|max:255',
                'nisn' => 'nullable|string|max:20',
            ]);
        }
        
        $this->step++;
    }

    public function prevStep()
    {
        $this->step--;
    }

    public function submit()
    {
        // Validate file uploads
        $this->validate([
            'file_kk' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'file_akta' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'file_ijazah' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'file_ktp_ortu' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'file_pas_foto' => 'required|image|mimes:jpg,jpeg,png|max:1024',
        ], [
            'file_kk.required' => 'Kartu Keluarga wajib diupload',
            'file_akta.required' => 'Akta Kelahiran wajib diupload',
            'file_ijazah.required' => 'Ijazah/SKL wajib diupload',
            'file_ktp_ortu.required' => 'KTP Orang Tua wajib diupload',
            'file_pas_foto.required' => 'Pas Foto wajib diupload',
            '*.max' => 'Ukuran file maksimal 2MB',
            'file_pas_foto.max' => 'Ukuran pas foto maksimal 1MB',
        ]);

        // Create registration
        $registration = PpdbRegistration::create([
            'no_pendaftaran' => PpdbRegistration::generateNoPendaftaran(),
            'nama_lengkap' => $this->nama_lengkap,
            'tempat_lahir' => $this->tempat_lahir,
            'tanggal_lahir' => $this->tanggal_lahir,
            'jenis_kelamin' => $this->jenis_kelamin,
            'alamat' => $this->alamat,
            'no_hp' => $this->no_hp,
            'asal_sekolah' => $this->asal_sekolah,
            'nisn' => $this->nisn,
            'tahun_lulus' => $this->tahun_lulus,
            'nama_wali' => $this->nama_ayah ?: $this->nama_ibu,
            'nama_ayah' => $this->nama_ayah,
            'nama_ibu' => $this->nama_ibu,
            'pekerjaan_ayah' => $this->pekerjaan_ayah,
            'pekerjaan_ibu' => $this->pekerjaan_ibu,
            'no_hp_wali' => $this->no_hp_ortu,
            'email' => $this->email,
            'status' => 'pending',
        ]);

        // Upload and save documents
        $documents = [
            'Kartu Keluarga' => $this->file_kk,
            'Akta Kelahiran' => $this->file_akta,
            'Ijazah/SKL' => $this->file_ijazah,
            'KTP Orang Tua' => $this->file_ktp_ortu,
            'Pas Foto' => $this->file_pas_foto,
        ];

        foreach ($documents as $jenis => $file) {
            if ($file) {
                $path = $file->store('ppdb-documents/' . $registration->id, 'public');
                PpdbDocument::create([
                    'ppdb_registration_id' => $registration->id,
                    'jenis_dokumen' => $jenis,
                    'file_path' => $path,
                ]);
            }
        }

        $this->noRegistrasi = $registration->no_pendaftaran;
        $this->submitted = true;
    }

    public function render()
    {
        return view('livewire.ppdb.ppdb-form');
    }
}
