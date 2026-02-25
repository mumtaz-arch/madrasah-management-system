<?php

namespace App\Livewire\Admin\Santri;

use App\Models\Santri;
use App\Models\Kelas;
use App\Models\Wali;
use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class SantriForm extends Component
{
    use WithFileUploads;

    public ?Santri $santri = null;
    public bool $isEdit = false;
    
    // Form fields
    public string $nis = '';
    public ?string $nisn = '';
    public string $nama_lengkap = '';
    public ?string $tempat_lahir = '';
    public ?string $tanggal_lahir = '';
    public string $jenis_kelamin = 'L';
    public ?string $alamat = '';
    public ?string $no_hp = '';
    public $foto;
    public ?string $kelas_id = '';
    public ?string $wali_id = '';
    public string $tahun_masuk = '';
    public string $status = 'aktif';
    
    // User account
    public string $email = '';
    public string $password = '';
    public bool $createAccount = true;

    public function mount(?Santri $santri = null)
    {
        if ($santri && $santri->exists) {
            $this->santri = $santri;
            $this->isEdit = true;
            $this->fill($santri->toArray());
            $this->kelas_id = (string) $santri->kelas_id;
            $this->wali_id = (string) $santri->wali_id;
            $this->tanggal_lahir = $santri->tanggal_lahir?->format('Y-m-d');
            
            if ($santri->user) {
                $this->email = $santri->user->email;
                $this->createAccount = false;
            }
        } else {
            $this->tahun_masuk = (string) date('Y');
        }
    }

    public function rules()
    {
        $rules = [
            'nis' => ['required', 'string', 'max:20', Rule::unique('santris', 'nis')->ignore($this->santri?->id)],
            'nisn' => ['nullable', 'string', 'max:20'],
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'tempat_lahir' => ['nullable', 'string', 'max:100'],
            'tanggal_lahir' => ['nullable', 'date'],
            'jenis_kelamin' => ['required', 'in:L,P'],
            'alamat' => ['nullable', 'string'],
            'no_hp' => ['nullable', 'string', 'max:20'],
            'foto' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'kelas_id' => ['nullable', 'exists:kelas,id'],
            'wali_id' => ['nullable', 'exists:walis,id'],
            'tahun_masuk' => ['required', 'integer', 'min:2000', 'max:' . (date('Y') + 1)],
            'status' => ['required', 'in:aktif,alumni,keluar,cuti'],
        ];

        if ($this->createAccount && !$this->isEdit) {
            $rules['email'] = ['required', 'email', 'unique:users,email'];
            $rules['password'] = ['required', 'min:8'];
        } elseif ($this->email && $this->isEdit) {
            $rules['email'] = ['required', 'email', Rule::unique('users', 'email')->ignore($this->santri?->user?->id)];
        }

        return $rules;
    }

    public function save()
    {
        $this->validate();

        $data = [
            'nis' => $this->nis,
            'nisn' => $this->nisn ?: null,
            'nama_lengkap' => $this->nama_lengkap,
            'tempat_lahir' => $this->tempat_lahir ?: null,
            'tanggal_lahir' => $this->tanggal_lahir ?: null,
            'jenis_kelamin' => $this->jenis_kelamin,
            'alamat' => $this->alamat ?: null,
            'no_hp' => $this->no_hp ?: null,
            'kelas_id' => $this->kelas_id ?: null,
            'wali_id' => $this->wali_id ?: null,
            'tahun_masuk' => $this->tahun_masuk,
            'status' => $this->status,
        ];

        // Handle foto upload
        if ($this->foto) {
            $data['foto'] = $this->foto->store('santri-photos', 'public');
        }

        if ($this->isEdit) {
            $this->santri->update($data);
            
            // Update user account if exists
            if ($this->santri->user && $this->email) {
                $userData = ['email' => $this->email, 'name' => $this->nama_lengkap];
                if ($this->password) {
                    $userData['password'] = Hash::make($this->password);
                }
                $this->santri->user->update($userData);
            }
            
            session()->flash('success', 'Data santri berhasil diperbarui.');
        } else {
            // Create user account first if enabled
            // Create user account
            $user = User::create([
                'name' => $this->nama_lengkap,
                'email' => $this->email,
                'password' => Hash::make($this->password),
                'role' => 'santri',
                'is_active' => true,
            ]);
            $data['user_id'] = $user->id;
            
            Santri::create($data);
            session()->flash('success', 'Data santri berhasil ditambahkan.');
        }

        return redirect()->route('admin.santri.index');
    }

    public function render()
    {
        return view('livewire.admin.santri.santri-form', [
            'kelasList' => Kelas::orderBy('tingkat')->orderBy('nama_kelas')->get(),
            'waliList' => Wali::orderBy('nama_lengkap')->get(),
        ]);
    }
}
