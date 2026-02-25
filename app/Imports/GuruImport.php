<?php

namespace App\Imports;

use App\Models\Guru;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class GuruImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        // Skip if NIP already exists
        if ($row['nip'] && Guru::where('nip', $row['nip'])->exists()) {
            return null;
        }

        // Create user account for guru
        $email = strtolower(str_replace(' ', '.', $row['nama_lengkap'])) . '@guru.local';
        $user = User::create([
            'name' => $row['nama_lengkap'],
            'email' => $email,
            'password' => Hash::make($row['nip'] ?? 'guru123'),
            'role' => 'guru',
        ]);

        return new Guru([
            'user_id' => $user->id,
            'nip' => $row['nip'] ?? null,
            'nama_lengkap' => $row['nama_lengkap'],
            'jenis_kelamin' => strtoupper($row['jenis_kelamin_lp'] ?? $row['jenis_kelamin'] ?? 'L'),
            'tempat_lahir' => $row['tempat_lahir'] ?? null,
            'tanggal_lahir' => $row['tanggal_lahir_yyyy_mm_dd'] ?? $row['tanggal_lahir'] ?? null,
            'alamat' => $row['alamat'] ?? null,
            'no_hp' => $row['no_hp'] ?? null,
            'jabatan' => $row['jabatan'] ?? null,
            'bidang_keahlian' => $row['bidang_keahlian'] ?? null,
            'status' => $row['status_aktifnonaktif'] ?? $row['status'] ?? 'aktif',
        ]);
    }

    public function rules(): array
    {
        return [
            'nama_lengkap' => 'required',
        ];
    }
}
