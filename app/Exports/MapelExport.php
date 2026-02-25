<?php

namespace App\Exports;

use App\Models\Mapel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class MapelExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    public function collection()
    {
        return Mapel::all();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Kode',
            'Nama Mata Pelajaran',
            'Kategori',
            'KKM',
            'Created At',
            'Updated At',
        ];
    }

    public function map($mapel): array
    {
        return [
            $mapel->id,
            $mapel->kode,
            $mapel->nama,
            $mapel->kategori,
            $mapel->kkm,
            $mapel->created_at,
            $mapel->updated_at,
        ];
    }
}
