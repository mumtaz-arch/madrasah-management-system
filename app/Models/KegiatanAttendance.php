<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KegiatanAttendance extends Model
{
    protected $fillable = [
        'kegiatan_id',
        'santri_id',
        'tanggal',
        'waktu_tap',
        'keterangan',
    ];

    public function kegiatan()
    {
        return $this->belongsTo(Kegiatan::class);
    }

    public function santri()
    {
        return $this->belongsTo(Santri::class);
    }
}
