<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GuruAttendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'tanggal',
        'guru_id',
        'status',
        'jam_masuk',
        'jam_pulang',
        'keterangan',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jam_masuk' => 'datetime:H:i',
        'jam_pulang' => 'datetime:H:i',
    ];

    public function guru(): BelongsTo
    {
        return $this->belongsTo(Guru::class);
    }

    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'hadir' => 'bg-green-100 text-green-700',
            'izin' => 'bg-blue-100 text-blue-700',
            'sakit' => 'bg-yellow-100 text-yellow-700',
            'alpha' => 'bg-red-100 text-red-700',
            default => 'bg-gray-100 text-gray-700',
        };
    }
}
