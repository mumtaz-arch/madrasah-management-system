<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class QuestionsTemplateExport implements FromArray, WithHeadings, WithStyles
{
    public function array(): array
    {
        return [
            ['pilihan_ganda', 'Apa ibukota Indonesia?', 'Jakarta', 'Bandung', 'Surabaya', 'Medan', '', 'A', 1],
            ['pilihan_ganda', '2 + 2 = ?', '3', '4', '5', '6', '', 'B', 1],
            ['essay', 'Jelaskan proses fotosintesis!', '', '', '', '', '', 'Fotosintesis adalah...', 5],
        ];
    }

    public function headings(): array
    {
        return [
            'jenis',
            'pertanyaan',
            'pilihan_a',
            'pilihan_b',
            'pilihan_c',
            'pilihan_d',
            'pilihan_e',
            'jawaban_benar',
            'poin',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true], 'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'E2E8F0']]],
        ];
    }
}
