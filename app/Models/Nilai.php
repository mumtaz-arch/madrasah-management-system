<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Nilai extends Model
{
    use HasFactory;

    protected $fillable = [
        'santri_id',
        'mapel_id',
        'guru_id',
        'jenis',
        'nilai',
        'semester',
        'tahun_ajaran',
        'catatan',
    ];

    protected $casts = [
        'nilai' => 'decimal:2',
    ];

    public function santri(): BelongsTo
    {
        return $this->belongsTo(Santri::class);
    }

    public function mapel(): BelongsTo
    {
        return $this->belongsTo(Mapel::class);
    }

    public function guru(): BelongsTo
    {
        return $this->belongsTo(Guru::class);
    }

    public function getStatusAttribute(): string
    {
        $kkm = $this->mapel->kkm ?? 70;
        return $this->nilai >= $kkm ? 'Tuntas' : 'Belum Tuntas';
    }
}
