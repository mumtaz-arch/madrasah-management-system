<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Exam extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'deskripsi',
        'mapel_id',
        'kelas_id',
        'guru_id',
        'durasi_menit',
        'jumlah_soal',
        'randomize',
        'status',
        'mulai',
        'selesai',
    ];

    protected $casts = [
        'randomize' => 'boolean',
        'mulai' => 'datetime',
        'selesai' => 'datetime',
    ];

    public function mapel(): BelongsTo
    {
        return $this->belongsTo(Mapel::class);
    }

    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class);
    }

    public function guru(): BelongsTo
    {
        return $this->belongsTo(Guru::class);
    }

    public function questions(): BelongsToMany
    {
        return $this->belongsToMany(QuestionBank::class, 'exam_questions', 'exam_id', 'question_bank_id')
            ->withPivot('urutan')
            ->orderBy('exam_questions.urutan');
    }

    public function attempts(): HasMany
    {
        return $this->hasMany(ExamAttempt::class);
    }

    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'draft' => 'bg-gray-100 text-gray-700',
            'active' => 'bg-green-100 text-green-700',
            'finished' => 'bg-blue-100 text-blue-700',
            default => 'bg-gray-100 text-gray-700',
        };
    }
}
