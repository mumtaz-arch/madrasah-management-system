<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tagihan extends Model
{
    use HasFactory;

    protected $fillable = [
        'santri_id',
        'payment_type_id',
        'bulan',
        'tahun',
        'nominal',
        'status',
        'jatuh_tempo',
        'metode_bayar',
        'bukti_bayar',
        'tanggal_bayar',
        'nominal_bayar',
        'verified_by',
        'verified_at',
        'catatan_pembayaran',
    ];

    protected $casts = [
        'nominal' => 'decimal:2',
        'nominal_bayar' => 'decimal:2',
        'jatuh_tempo' => 'date',
        'tanggal_bayar' => 'date',
        'verified_at' => 'datetime',
    ];

    public function santri(): BelongsTo
    {
        return $this->belongsTo(Santri::class);
    }

    public function paymentType(): BelongsTo
    {
        return $this->belongsTo(PaymentType::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'pending' => 'bg-yellow-100 text-yellow-700',
            'paid' => 'bg-green-100 text-green-700',
            'overdue' => 'bg-red-100 text-red-700',
            default => 'bg-gray-100 text-gray-700',
        };
    }

    public function getBulanNamaAttribute(): string
    {
        $bulan = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 
                  'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        return $bulan[$this->bulan] ?? '';
    }
}
