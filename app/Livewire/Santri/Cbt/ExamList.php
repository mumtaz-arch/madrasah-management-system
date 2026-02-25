<?php

namespace App\Livewire\Santri\Cbt;

use App\Models\Exam;
use App\Models\ExamAttempt;
use App\Models\Santri;
use Livewire\Component;

class ExamList extends Component
{
    public function render()
    {
        $santri = Santri::where('user_id', auth()->id())->first();
        
        if (!$santri) {
            return view('livewire.santri.cbt.exam-list', [
                'availableExams' => collect(),
                'completedExams' => collect(),
            ]);
        }

        // Get available exams for student's class
        $availableExams = Exam::where('kelas_id', $santri->kelas_id)
            ->where('status', 'active')
            ->where('mulai', '<=', now())
            ->where('selesai', '>=', now())
            ->whereDoesntHave('attempts', function ($query) use ($santri) {
                $query->where('santri_id', $santri->id)
                      ->where('status', 'submitted');
            })
            ->with(['mapel', 'guru'])
            ->get();

        // Get completed exams
        $completedExams = ExamAttempt::where('santri_id', $santri->id)
            ->where('status', 'submitted')
            ->with(['exam.mapel', 'exam.guru'])
            ->latest('selesai')
            ->get();

        return view('livewire.santri.cbt.exam-list', [
            'availableExams' => $availableExams,
            'completedExams' => $completedExams,
        ]);
    }
}
