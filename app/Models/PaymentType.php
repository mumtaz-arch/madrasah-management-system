<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PaymentType extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'nominal',
        'jatuh_tempo_hari',
        'is_monthly',
        'is_active',
    ];

    protected $casts = [
        'nominal' => 'decimal:2',
        'is_monthly' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function tagihans(): HasMany
    {
        return $this->hasMany(Tagihan::class);
    }
}
