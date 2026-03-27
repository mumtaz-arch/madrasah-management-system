<?php

namespace App\Exports;

use App\Models\Santri;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SantriExport implements FromCollection, WithHeadings, WithStyles, WithMapping
{
    protected $kelasId;

    public function __construct($kelasId = null)
    {
        $this->kelasId = $kelasId;
    }

    public function collection()
    {
        return Santri::with('kelas')
            ->when($this->kelasId, fn($q) => $q->where('kelas_id', $this->kelasId))
            ->orderBy('nama_lengkap')
            ->get();
    }

    public function map($santri): array
    {
        return [
            $santri->nis,
            $santri->nisn,
            $santri->rfid_uid,
            $santri->nama_lengkap,
            $santri->jenis_kelamin,
            $santri->tempat_lahir,
            $santri->tanggal_lahir?->format('Y-m-d'),
            $santri->alamat,
            $santri->no_hp,
            $santri->kelas?->nama_kelas,
            $santri->nama_ayah,
            $santri->nama_ibu,
            $santri->no_hp_ortu,
            $santri->status,
        ];
    }

    public function headings(): array
    {
        return [
            'NIS',
            'NISN',
            'RFID UID',
            'Nama Lengkap',
            'Jenis Kelamin (L/P)',
            'Tempat Lahir',
            'Tanggal Lahir (YYYY-MM-DD)',
            'Alamat',
            'No HP',
            'Kelas',
            'Nama Ayah',
            'Nama Ibu',
            'No HP Orang Tua',
            'Status (aktif/nonaktif)',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true], 'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '166534']], 'font' => ['color' => ['rgb' => 'FFFFFF'], 'bold' => true]],
        ];
    }
}
