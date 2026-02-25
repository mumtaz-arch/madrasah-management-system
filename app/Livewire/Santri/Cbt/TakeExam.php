<?php

namespace App\Livewire\Santri\Cbt;

use App\Models\Exam;
use App\Models\ExamAttempt;
use App\Models\ExamAnswer;
use App\Models\Santri;
use Livewire\Component;
use Carbon\Carbon;

class TakeExam extends Component
{
    public Exam $exam;
    public ?ExamAttempt $attempt = null;
    public array $questions = [];
    public array $answers = [];
    public int $currentIndex = 0;
    public int $remainingSeconds = 0;
    public bool $isFinished = false;

    public function mount(Exam $exam)
    {
        $this->exam = $exam;
        
        // Check if student has existing attempt
        $santri = Santri::where('user_id', auth()->id())->first();
        if (!$santri) {
            session()->flash('error', 'Data santri tidak ditemukan.');
            return $this->redirect(route('santri.dashboard'));
        }

        $this->attempt = ExamAttempt::where('exam_id', $exam->id)
            ->where('santri_id', $santri->id)
            ->first();

        if ($this->attempt && $this->attempt->status === 'submitted') {
            $this->isFinished = true;
            return;
        }

        // Start new attempt if none exists
        if (!$this->attempt) {
            $this->attempt = ExamAttempt::create([
                'exam_id' => $exam->id,
                'santri_id' => $santri->id,
                'mulai' => now(),
                'status' => 'on_progress',
            ]);
        }

        // Load questions with randomization
        $this->loadQuestions();
        
        // Load existing answers
        $this->loadAnswers();
        
        // Calculate remaining time
        $this->calculateRemainingTime();
    }

    protected function loadQuestions()
    {
        $questions = $this->exam->questions()->get();
        
        // Apply randomization if enabled
        if ($this->exam->randomize) {
            $questions = $questions->shuffle();
        }
        
        $this->questions = $questions->toArray();
    }

    protected function loadAnswers()
    {
        $existingAnswers = $this->attempt->answers()->get()->keyBy('question_id');
        
        foreach ($this->questions as $index => $question) {
            $answer = $existingAnswers->get($question['id']);
            $this->answers[$question['id']] = $answer?->jawaban ?? '';
        }
    }

    protected function calculateRemainingTime()
    {
        $startTime = $this->attempt->mulai;
        $endTime = $startTime->addMinutes($this->exam->durasi_menit);
        $this->remainingSeconds = max(0, $endTime->diffInSeconds(now()));
        
        if ($this->remainingSeconds <= 0) {
            $this->submitExam();
        }
    }

    public function saveAnswer($questionId, $answer)
    {
        $this->answers[$questionId] = $answer;
        
        ExamAnswer::updateOrCreate(
            [
                'attempt_id' => $this->attempt->id,
                'question_id' => $questionId,
            ],
            [
                'jawaban' => $answer,
            ]
        );
    }

    public function nextQuestion()
    {
        if ($this->currentIndex < count($this->questions) - 1) {
            $this->currentIndex++;
        }
    }

    public function prevQuestion()
    {
        if ($this->currentIndex > 0) {
            $this->currentIndex--;
        }
    }

    public function goToQuestion(int $index)
    {
        if ($index >= 0 && $index < count($this->questions)) {
            $this->currentIndex = $index;
        }
    }

    public function submitExam()
    {
        // Auto-grade multiple choice questions
        $totalScore = 0;
        $totalPoints = 0;

        foreach ($this->questions as $question) {
            $totalPoints += $question['poin'] ?? 1;
            
            if ($question['jenis'] === 'pilihan_ganda') {
                $studentAnswer = $this->answers[$question['id']] ?? '';
                $correctAnswer = $question['jawaban_benar'];
                
                if (strtolower(trim($studentAnswer)) === strtolower(trim($correctAnswer))) {
                    $totalScore += $question['poin'] ?? 1;
                    
                    // Update answer as correct
                    ExamAnswer::where('attempt_id', $this->attempt->id)
                        ->where('question_id', $question['id'])
                        ->update(['is_correct' => true, 'poin' => $question['poin'] ?? 1]);
                } else {
                    ExamAnswer::where('attempt_id', $this->attempt->id)
                        ->where('question_id', $question['id'])
                        ->update(['is_correct' => false, 'poin' => 0]);
                }
            }
        }

        // Calculate final score (0-100)
        $finalScore = $totalPoints > 0 ? round(($totalScore / $totalPoints) * 100, 2) : 0;

        // Update attempt
        $this->attempt->update([
            'selesai' => now(),
            'nilai' => $finalScore,
            'status' => 'submitted',
        ]);

        $this->isFinished = true;
        session()->flash('success', 'Ujian berhasil dikumpulkan. Nilai: ' . $finalScore);
    }

    public function render()
    {
        $currentQuestion = $this->questions[$this->currentIndex] ?? null;
        
        return view('livewire.santri.cbt.take-exam', [
            'currentQuestion' => $currentQuestion,
            'totalQuestions' => count($this->questions),
            'answeredCount' => count(array_filter($this->answers)),
        ]);
    }
}
