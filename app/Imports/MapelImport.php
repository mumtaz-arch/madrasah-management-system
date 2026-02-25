<?php

namespace App\Imports;

use App\Models\Mapel;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class MapelImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        return new Mapel([
            'kode'     => $row['kode'],
            'nama'     => $row['nama_mata_pelajaran'] ?? $row['nama'],
            'kategori' => $row['kategori'],
            'kkm'      => $row['kkm'],
        ]);
    }

    public function rules(): array
    {
        return [
            'kode' => 'required|unique:mapels,kode',
            'nama' => 'required', // fallback if key is nama
            'kategori' => 'required|in:umum,diniyah,tahfidz,bahasa',
            'kkm' => 'required|numeric|min:0|max:100',
        ];
    }
}
