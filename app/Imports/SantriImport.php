<?php

namespace App\Imports;

use App\Models\Santri;
use App\Models\Kelas;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class SantriImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        // Skip if NIS already exists
        if (Santri::where('nis', $row['nis'])->exists()) {
            return null;
        }

        // Find kelas by name
        $kelas = Kelas::where('nama_kelas', 'like', '%' . $row['kelas'] . '%')->first();

        // Create user account for santri
        $user = User::create([
            'name' => $row['nama_lengkap'],
            'email' => strtolower(str_replace(' ', '.', $row['nama_lengkap'])) . '@santri.local',
            'password' => Hash::make($row['nis']),
            'role' => 'santri',
        ]);

        return new Santri([
            'user_id' => $user->id,
            'nis' => $row['nis'],
            'nisn' => $row['nisn'] ?? null,
            'nama_lengkap' => $row['nama_lengkap'],
            'jenis_kelamin' => strtoupper($row['jenis_kelamin_lp'] ?? $row['jenis_kelamin'] ?? 'L'),
            'tempat_lahir' => $row['tempat_lahir'] ?? null,
            'tanggal_lahir' => $row['tanggal_lahir_yyyy_mm_dd'] ?? $row['tanggal_lahir'] ?? null,
            'alamat' => $row['alamat'] ?? null,
            'no_hp' => $row['no_hp'] ?? null,
            'kelas_id' => $kelas?->id,
            'nama_ayah' => $row['nama_ayah'] ?? null,
            'nama_ibu' => $row['nama_ibu'] ?? null,
            'no_hp_ortu' => $row['no_hp_orang_tua'] ?? null,
            'status' => $row['status_aktifnonaktif'] ?? $row['status'] ?? 'aktif',
        ]);
    }

    public function rules(): array
    {
        return [
            'nis' => 'required',
            'nama_lengkap' => 'required',
        ];
    }
}
