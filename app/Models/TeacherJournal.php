<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TeacherJournal extends Model
{
    use HasFactory, SoftDeletes;

    const STATUS_DRAFT = 'draft';
    const STATUS_SENT = 'sent';
    const STATUS_VERIFIED = 'verified';

    protected $fillable = [
        'teacher_id',
        'jadwal_id',
        'class_id',
        'subject_id',
        'date',
        'topic',
        'method',
        'present_count',
        'absent_count',
        'attendance_details',
        'notes',
        'status',
        'submitted_at',
        'verified_by',
        'verified_at',
    ];

    protected $casts = [
        'date' => 'date',
        'submitted_at' => 'datetime',
        'verified_at' => 'datetime',
        'present_count' => 'integer',
        'absent_count' => 'integer',
        'attendance_details' => 'array',
    ];

    // Relationships
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Guru::class, 'teacher_id');
    }

    public function jadwal(): BelongsTo
    {
        return $this->belongsTo(Jadwal::class, 'jadwal_id');
    }

    public function classroom(): BelongsTo
    {
        return $this->belongsTo(Kelas::class, 'class_id');
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Mapel::class, 'subject_id');
    }

    public function verifier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    // Scopes
    public function scopeDraft($query)
    {
        return $query->where('status', self::STATUS_DRAFT);
    }

    public function scopeSent($query)
    {
        return $query->where('status', self::STATUS_SENT);
    }

    public function scopeVerified($query)
    {
        return $query->where('status', self::STATUS_VERIFIED);
    }

    // Accessors
    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            self::STATUS_DRAFT => 'bg-gray-100 text-gray-700',
            self::STATUS_SENT => 'bg-yellow-100 text-yellow-700',
            self::STATUS_VERIFIED => 'bg-green-100 text-green-700',
            default => 'bg-gray-100 text-gray-700',
        };
    }
    
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            self::STATUS_DRAFT => 'Draft',
            self::STATUS_SENT => 'Terkirim',
            self::STATUS_VERIFIED => 'Diverifikasi',
            default => ucfirst($this->status),
        };
    }
}
