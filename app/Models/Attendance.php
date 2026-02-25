<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'tanggal',
        'santri_id',
        'kelas_id',
        'status',
        'keterangan',
        'recorded_by',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function santri(): BelongsTo
    {
        return $this->belongsTo(Santri::class);
    }

    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class);
    }

    public function recorder(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recorded_by');
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
