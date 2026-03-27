<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
    protected $fillable = [
        'nama_kegiatan',
        'deskripsi',
        'is_active',
    ];

    public function attendances()
    {
        return $this->hasMany(KegiatanAttendance::class);
    }
}
