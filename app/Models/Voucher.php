<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $fillable = [
        'code',
        'amount',
        'limit',
        'used',
        'expires_at',
    ];

    // Opsional: Casting tanggal agar menjadi objek Carbon
    protected $casts = [
        'expires_at' => 'datetime',
    ];
}