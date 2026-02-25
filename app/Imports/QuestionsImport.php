<?php

namespace App\Imports;

use App\Models\QuestionBank;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class QuestionsImport implements ToModel, WithHeadingRow, WithValidation
{
    protected int $guruId;
    protected int $mapelId;

    public function __construct(int $guruId, int $mapelId)
    {
        $this->guruId = $guruId;
        $this->mapelId = $mapelId;
    }

    public function model(array $row)
    {
        // Parse pilihan from columns pilihan_a, pilihan_b, pilihan_c, pilihan_d
        $pilihan = [];
        if (!empty($row['pilihan_a'])) $pilihan['A'] = $row['pilihan_a'];
        if (!empty($row['pilihan_b'])) $pilihan['B'] = $row['pilihan_b'];
        if (!empty($row['pilihan_c'])) $pilihan['C'] = $row['pilihan_c'];
        if (!empty($row['pilihan_d'])) $pilihan['D'] = $row['pilihan_d'];
        if (!empty($row['pilihan_e'])) $pilihan['E'] = $row['pilihan_e'];

        return new QuestionBank([
            'guru_id' => $this->guruId,
            'mapel_id' => $this->mapelId,
            'jenis' => strtolower($row['jenis'] ?? 'pilihan_ganda') === 'essay' ? 'essay' : 'pilihan_ganda',
            'pertanyaan' => $row['pertanyaan'],
            'pilihan' => !empty($pilihan) ? $pilihan : null,
            'jawaban_benar' => $row['jawaban_benar'] ?? '',
            'poin' => $row['poin'] ?? 1,
        ]);
    }

    public function rules(): array
    {
        return [
            'pertanyaan' => 'required|string',
            'jenis' => 'nullable|string',
            'jawaban_benar' => 'nullable|string',
            'poin' => 'nullable|integer|min:1',
        ];
    }
}
