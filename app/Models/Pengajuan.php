<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengajuan extends Model
{
    protected $table = 'pengajuan';

    protected $fillable = [
        'pegawai_id',
        'jenis',
        'tanggal_mulai',
        'tanggal_selesai',
        'alasan',
        'lampiran',
        'status',
        'approved_by',
        'approved_at',
        'catatan'
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}