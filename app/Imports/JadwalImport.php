<?php

namespace App\Imports;

use App\Models\Jadwal;
use App\Models\Mapel;
use App\Models\Kelas;
use App\Models\Guru;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Carbon\Carbon;

class JadwalImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        $mapel = Mapel::where('kode', $row['kode_mapel'])->first();
        $kelas = Kelas::where('nama_kelas', $row['nama_kelas'])->first();
        $guru = Guru::where('nip', $row['nip_guru'])->orWhere('nama_lengkap', $row['nama_guru'] ?? '')->first();

        if (!$mapel || !$kelas || !$guru) {
            return null; // Skip invalid rows or handle error
        }

        return new Jadwal([
            'hari'        => strtolower($row['hari']),
            'jam_mulai'   => $row['jam_mulai'],
            'jam_selesai' => $row['jam_selesai'],
            'mapel_id'    => $mapel->id,
            'kelas_id'    => $kelas->id,
            'guru_id'     => $guru->id,
            'tahun_ajaran'=> $row['tahun_ajaran'] ?? date('Y') . '/' . (date('Y') + 1),
        ]);
    }

    public function rules(): array
    {
        return [
            'hari' => 'required|in:senin,selasa,rabu,kamis,jumat,sabtu,minggu',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
            'kode_mapel' => 'required|exists:mapels,kode',
            'nama_kelas' => 'required|exists:kelas,nama_kelas',
            'nip_guru' => 'nullable|exists:gurus,nip',
        ];
    }
}
