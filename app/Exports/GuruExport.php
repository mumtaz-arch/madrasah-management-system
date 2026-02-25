<?php

namespace App\Exports;

use App\Models\Guru;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class GuruExport implements FromCollection, WithHeadings, WithStyles, WithMapping
{
    public function collection()
    {
        return Guru::orderBy('nama_lengkap')->get();
    }

    public function map($guru): array
    {
        return [
            $guru->nip,
            $guru->nama_lengkap,
            $guru->jenis_kelamin,
            $guru->tempat_lahir,
            $guru->tanggal_lahir?->format('Y-m-d'),
            $guru->alamat,
            $guru->no_hp,
            $guru->jabatan,
            $guru->bidang_keahlian,
            $guru->status,
        ];
    }

    public function headings(): array
    {
        return [
            'NIP',
            'Nama Lengkap',
            'Jenis Kelamin (L/P)',
            'Tempat Lahir',
            'Tanggal Lahir (YYYY-MM-DD)',
            'Alamat',
            'No HP',
            'Jabatan',
            'Bidang Keahlian',
            'Status (aktif/nonaktif)',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']], 'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '166534']]],
        ];
    }
}
