<?php

namespace App\Exports;

use App\Models\Jadwal;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class JadwalExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    public function collection()
    {
        return Jadwal::with(['mapel', 'kelas', 'guru'])->orderBy('hari')->orderBy('jam_mulai')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Hari',
            'Jam Mulai',
            'Jam Selesai',
            'Mata Pelajaran',
            'Kode Mapel',
            'Kelas',
            'Guru',
            'NIP Guru',
            'Tahun Ajaran',
        ];
    }

    public function map($jadwal): array
    {
        return [
            $jadwal->id,
            $jadwal->hari,
            $jadwal->jam_mulai->format('H:i'),
            $jadwal->jam_selesai->format('H:i'),
            $jadwal->mapel->nama ?? '-',
            $jadwal->mapel->kode ?? '-',
            $jadwal->kelas->nama_kelas ?? '-',
            $jadwal->guru->nama_lengkap ?? '-',
            $jadwal->guru->nip ?? '-',
            $jadwal->tahun_ajaran,
        ];
    }
}
