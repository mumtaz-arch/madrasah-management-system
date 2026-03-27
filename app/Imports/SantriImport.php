<?php

namespace App\Imports;

use App\Models\Santri;
use App\Models\Kelas;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class SantriImport implements ToModel, WithHeadingRow, WithValidation, SkipsEmptyRows
{
    public function model(array $row)
    {
        // Skip entirely empty rows or rows without NIS
        if (empty($row['nis']) || trim($row['nis']) === '') {
            return null;
        }

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

        // Sanitize date and other optional fields
        $rawDate = $row['tanggal_lahir_yyyy_mm_dd'] ?? $row['tanggal_lahir'] ?? null;
        if (empty($rawDate) || $rawDate === '0' || $rawDate === 0 || $rawDate === '0000-00-00') {
            $rawDate = null;
        }

        return new Santri([
            'user_id' => $user->id,
            'nis' => $row['nis'],
            'nisn' => (!empty($row['nisn']) && $row['nisn'] !== '0' && $row['nisn'] !== 0) ? $row['nisn'] : null,
            'rfid_uid' => (!empty($row['rfid_uid']) && $row['rfid_uid'] !== '0' && $row['rfid_uid'] !== 0) ? str_pad($row['rfid_uid'], 10, '0', STR_PAD_LEFT) : null,
            'nama_lengkap' => $row['nama_lengkap'],
            'jenis_kelamin' => strtoupper($row['jenis_kelamin_lp'] ?? $row['jenis_kelamin'] ?? 'L'),
            'tempat_lahir' => (!empty($row['tempat_lahir']) && $row['tempat_lahir'] !== '0' && $row['tempat_lahir'] !== 0) ? $row['tempat_lahir'] : null,
            'tanggal_lahir' => $rawDate,
            'alamat' => (!empty($row['alamat']) && $row['alamat'] !== '0' && $row['alamat'] !== 0) ? $row['alamat'] : null,
            'no_hp' => (!empty($row['no_hp']) && $row['no_hp'] !== '0' && $row['no_hp'] !== 0) ? $row['no_hp'] : null,
            'kelas_id' => $kelas?->id,
            'nama_ayah' => (!empty($row['nama_ayah']) && $row['nama_ayah'] !== '0' && $row['nama_ayah'] !== 0) ? $row['nama_ayah'] : null,
            'nama_ibu' => (!empty($row['nama_ibu']) && $row['nama_ibu'] !== '0' && $row['nama_ibu'] !== 0) ? $row['nama_ibu'] : null,
            'no_hp_ortu' => (!empty($row['no_hp_orang_tua']) && $row['no_hp_orang_tua'] !== '0' && $row['no_hp_orang_tua'] !== 0) ? $row['no_hp_orang_tua'] : null,
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
