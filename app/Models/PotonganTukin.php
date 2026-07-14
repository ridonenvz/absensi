<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PotonganTukin extends Model
{
    protected $table = 'potongan_tukin';

    protected $fillable = [
        'pegawai_id',
        'bulan',
        'tahun',
        'total_telat',
        'total_kompensasi',
        'potongan'
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }
}