<?php

namespace App\Exports;

use App\Models\TeacherJournal;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class JournalExport implements FromQuery, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $filters;

    public function __construct($filters)
    {
        $this->filters = $filters;
    }

    public function query()
    {
        $query = TeacherJournal::query()->with(['teacher', 'classroom', 'subject', 'verifier']);

        if (!empty($this->filters['teacher_id'])) {
            $query->where('teacher_id', $this->filters['teacher_id']);
        }
        if (!empty($this->filters['class_id'])) {
            $query->where('class_id', $this->filters['class_id']);
        }
        if (!empty($this->filters['subject_id'])) {
            $query->where('subject_id', $this->filters['subject_id']);
        }
        if (!empty($this->filters['status'])) {
            $query->where('status', $this->filters['status']);
        }
        if (!empty($this->filters['start_date'])) {
            $query->whereDate('date', '>=', $this->filters['start_date']);
        }
        if (!empty($this->filters['end_date'])) {
            $query->whereDate('date', '<=', $this->filters['end_date']);
        }

        return $query->latest('date');
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Guru',
            'Kelas',
            'Mata Pelajaran',
            'Materi',
            'Metode',
            'Hadir',
            'Tidak Hadir',
            'Catatan',
            'Status',
            'Diverifikasi Oleh',
            'Tgl Verifikasi',
        ];
    }

    public function map($journal): array
    {
        return [
            $journal->date->format('d-m-Y'),
            $journal->teacher->nama_lengkap ?? '-',
            $journal->classroom->nama_kelas ?? '-',
            $journal->subject->nama ?? '-',
            $journal->topic,
            $journal->method,
            $journal->present_count,
            $journal->absent_count,
            $journal->notes,
            ucfirst($journal->status),
            $journal->verifier->name ?? '-',
            $journal->verified_at ? $journal->verified_at->format('d-m-Y H:i') : '-',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
