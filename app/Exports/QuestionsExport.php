<?php

namespace App\Exports;

use App\Models\QuestionBank;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class QuestionsExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected ?int $mapelId;

    public function __construct(?int $mapelId = null)
    {
        $this->mapelId = $mapelId;
    }

    public function collection()
    {
        $query = QuestionBank::with(['mapel', 'guru']);
        
        if ($this->mapelId) {
            $query->where('mapel_id', $this->mapelId);
        }
        
        return $query->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Jenis',
            'Pertanyaan',
            'Pilihan A',
            'Pilihan B',
            'Pilihan C',
            'Pilihan D',
            'Pilihan E',
            'Jawaban Benar',
            'Poin',
            'Mapel',
        ];
    }

    public function map($question): array
    {
        $pilihan = $question->pilihan ?? [];
        
        return [
            $question->id,
            $question->jenis === 'pilihan_ganda' ? 'Pilihan Ganda' : 'Essay',
            $question->pertanyaan,
            $pilihan['A'] ?? '',
            $pilihan['B'] ?? '',
            $pilihan['C'] ?? '',
            $pilihan['D'] ?? '',
            $pilihan['E'] ?? '',
            $question->jawaban_benar,
            $question->poin,
            $question->mapel->nama ?? '',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
