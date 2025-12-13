<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    protected $fillable = [
        'nama',
        'nomor_hp',
        'alamat',
        'latitude',
        'longitude',
        'qr_token',
        'is_followed_up',
        'follow_up_notes',
    ];

    protected $casts = [
        'is_followed_up' => 'boolean',
    ];
}
