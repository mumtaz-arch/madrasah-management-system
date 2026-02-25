<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class GuruTemplateExport implements FromArray, WithHeadings, WithStyles
{
    public function array(): array
    {
        return [
            ['197001011995031001', 'Ahmad Fadli, S.Pd', 'L', 'Surabaya', '1970-01-01', 'Jl. Pendidikan No 15', '081234567890', 'Guru Mapel', 'Matematika', 'aktif'],
            ['198502152010012002', 'Siti Rahayu, M.Pd', 'P', 'Bandung', '1985-02-15', 'Jl. Guru No 20', '081234567891', 'Waka Kurikulum', 'Bahasa Indonesia', 'aktif'],
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
        $sheet->getColumnDimension('A')->setWidth(20);
        $sheet->getColumnDimension('B')->setWidth(25);
        $sheet->getColumnDimension('C')->setWidth(18);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(22);
        $sheet->getColumnDimension('F')->setWidth(30);
        $sheet->getColumnDimension('G')->setWidth(15);
        $sheet->getColumnDimension('H')->setWidth(18);
        $sheet->getColumnDimension('I')->setWidth(20);
        $sheet->getColumnDimension('J')->setWidth(20);

        return [
            1 => ['font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']], 'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '166534']]],
        ];
    }
}
