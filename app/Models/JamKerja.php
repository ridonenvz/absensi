<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JamKerja extends Model
{
    protected $table = 'jam_kerja';

    protected $fillable = [
        'hari',
        'jam_masuk',
        'jam_pulang',
        'is_wfh',
    ];

    protected $casts = [
        'is_wfh' => 'boolean',
    ];
}
