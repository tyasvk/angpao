<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Angpao extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'amount',
        'status',
        'claimed_by',
        'claimed_at',
        'expires_at',
        'reward_type', // uang atau barang
    'reward_name', // Nama barang atau nominal terformat
    'amount',      // Nilai angka untuk saldo
    'image_path',  // Path foto hadiah
    ];

    /**
     * Relasi ke User yang mengklaim angpao.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'claimed_by');
    }
}