<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PpdbRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_pendaftaran',
        'nama_lengkap',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'no_hp',
        'asal_sekolah',
        'nisn',
        'tahun_lulus',
        'nama_wali',
        'nama_ayah',
        'nama_ibu',
        'pekerjaan_ayah',
        'pekerjaan_ibu',
        'no_hp_wali',
        'email',
        'foto',
        'status',
        'catatan',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    public function documents(): HasMany
    {
        return $this->hasMany(PpdbDocument::class);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeDiterima($query)
    {
        return $query->where('status', 'diterima');
    }

    public static function generateNoPendaftaran(): string
    {
        $year = date('Y');
        $count = static::whereYear('created_at', $year)->count() + 1;
        return sprintf('PPDB-%s-%04d', $year, $count);
    }
}
