<?php

namespace App\Livewire\Admin\Guru;

use App\Models\Guru;
use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class GuruForm extends Component
{
    use WithFileUploads;

    public ?Guru $guru = null;
    public bool $isEdit = false;
    
    public ?string $nip = '';
    public string $nama_lengkap = '';
    public ?string $tempat_lahir = '';
    public ?string $tanggal_lahir = '';
    public string $jenis_kelamin = 'L';
    public ?string $alamat = '';
    public ?string $no_hp = '';
    public $foto;
    public ?string $jabatan = '';
    public ?string $bidang_keahlian = '';
    public bool $show_on_landing = false;
    public string $status = 'aktif';
    
    public string $email = '';
    public string $password = '';
    public bool $createAccount = true;

    public function mount(?Guru $guru = null)
    {
        if ($guru && $guru->exists) {
            $this->guru = $guru;
            $this->isEdit = true;
            $this->fill($guru->toArray());
            $this->tanggal_lahir = $guru->tanggal_lahir?->format('Y-m-d');
            $this->show_on_landing = (bool) $guru->show_on_landing;
            
            if ($guru->user) {
                $this->email = $guru->user->email;
                $this->createAccount = false;
            }
        }
    }

    public function rules()
    {
        $rules = [
            'nip' => ['nullable', 'string', 'max:30', Rule::unique('gurus', 'nip')->ignore($this->guru?->id)],
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'tempat_lahir' => ['nullable', 'string', 'max:100'],
            'tanggal_lahir' => ['nullable', 'date'],
            'jenis_kelamin' => ['required', 'in:L,P'],
            'alamat' => ['nullable', 'string'],
            'no_hp' => ['nullable', 'string', 'max:20'],
            'foto' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'jabatan' => ['nullable', 'string', 'max:100'],
            'bidang_keahlian' => ['nullable', 'string', 'max:255'],
            'show_on_landing' => ['boolean'],
            'status' => ['required', 'in:aktif,nonaktif,pensiun'],
        ];

        if ($this->createAccount && !$this->isEdit) {
            $rules['email'] = ['required', 'email', 'unique:users,email'];
            $rules['password'] = ['required', 'min:8'];
        } elseif ($this->email && $this->isEdit) {
            $rules['email'] = ['required', 'email', Rule::unique('users', 'email')->ignore($this->guru?->user?->id)];
        }

        return $rules;
    }

    public function save()
    {
        $this->validate();

        $data = [
            'nip' => $this->nip ?: null,
            'nama_lengkap' => $this->nama_lengkap,
            'tempat_lahir' => $this->tempat_lahir ?: null,
            'tanggal_lahir' => $this->tanggal_lahir ?: null,
            'jenis_kelamin' => $this->jenis_kelamin,
            'alamat' => $this->alamat ?: null,
            'no_hp' => $this->no_hp ?: null,
            'jabatan' => $this->jabatan ?: null,
            'bidang_keahlian' => $this->bidang_keahlian ?: null,
            'show_on_landing' => $this->show_on_landing,
            'status' => $this->status,
        ];

        if ($this->foto) {
            $data['foto'] = $this->foto->store('guru-photos', 'public');
        }

        if ($this->isEdit) {
            $this->guru->update($data);
            
            if ($this->guru->user && $this->email) {
                $userData = ['email' => $this->email, 'name' => $this->nama_lengkap];
                if ($this->password) {
                    $userData['password'] = Hash::make($this->password);
                }
                $this->guru->user->update($userData);
            }
            
            session()->flash('success', 'Data guru berhasil diperbarui.');
        } else {
            // Create user account
            $user = User::create([
                'name' => $this->nama_lengkap,
                'email' => $this->email,
                'password' => Hash::make($this->password),
                'role' => 'guru',
                'is_active' => true,
            ]);
            $data['user_id'] = $user->id;
            
            Guru::create($data);
            session()->flash('success', 'Data guru berhasil ditambahkan.');
        }

        return redirect()->route('admin.guru.index');
    }

    public function render()
    {
        return view('livewire.admin.guru.guru-form');
    }
}
