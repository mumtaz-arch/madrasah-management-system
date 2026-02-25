<?php

namespace App\Livewire\Admin\Cbt;

use App\Models\Exam;
use App\Models\ExamAttempt;
use Livewire\Component;
use Livewire\WithPagination;

class ExamResults extends Component
{
    use WithPagination;

    public ?int $examId = null;
    public string $search = '';

    public function mount(?int $examId = null)
    {
        $this->examId = $examId;
    }

    public function getExamAnalytics(Exam $exam): array
    {
        $attempts = $exam->attempts()->where('status', 'submitted')->get();
        
        if ($attempts->isEmpty()) {
            return [
                'total_peserta' => 0,
                'sudah_selesai' => 0,
                'rata_rata' => 0,
                'nilai_tertinggi' => 0,
                'nilai_terendah' => 0,
                'lulus' => 0,
                'tidak_lulus' => 0,
            ];
        }

        $nilai = $attempts->pluck('nilai');
        $kkm = 70; // Passing grade

        return [
            'total_peserta' => $exam->kelas->santris()->count(),
            'sudah_selesai' => $attempts->count(),
            'rata_rata' => round($nilai->avg(), 2),
            'nilai_tertinggi' => round($nilai->max(), 2),
            'nilai_terendah' => round($nilai->min(), 2),
            'lulus' => $nilai->filter(fn($n) => $n >= $kkm)->count(),
            'tidak_lulus' => $nilai->filter(fn($n) => $n < $kkm)->count(),
        ];
    }

    public function render()
    {
        $examsQuery = Exam::with(['mapel', 'kelas', 'guru'])
            ->withCount(['attempts as completed_count' => function ($q) {
                $q->where('status', 'submitted');
            }])
            ->where('status', '!=', 'draft');

        if ($this->examId) {
            $exam = Exam::with(['mapel', 'kelas', 'guru'])->find($this->examId);
            $analytics = $exam ? $this->getExamAnalytics($exam) : null;
            
            $results = ExamAttempt::where('exam_id', $this->examId)
                ->where('status', 'submitted')
                ->when($this->search, function ($query) {
                    $query->whereHas('santri', function ($q) {
                        $q->where('nama_lengkap', 'like', "%{$this->search}%");
                    });
                })
                ->with('santri')
                ->orderByDesc('nilai')
                ->paginate(10);

            return view('livewire.admin.cbt.exam-results', [
                'exam' => $exam,
                'analytics' => $analytics,
                'results' => $results,
                'exams' => null,
            ]);
        }

        return view('livewire.admin.cbt.exam-results', [
            'exam' => null,
            'analytics' => null,
            'results' => null,
            'exams' => $examsQuery->latest()->paginate(10),
        ]);
    }
}
