<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    protected $table = 'pegawai';

    protected $fillable = [
        'nip',
        'nik',
        'nama',
        'jabatan',
        'jenis_kelamin',
        'unit_kerja_id',
        'atasan_id',
        'status',
    ];

    public function getNomorIdentitasAttribute(): string
    {
        return $this->nip ?: ($this->nik ?: '-');
    }

    public function getJenisIdentitasAttribute(): string
    {
        if ($this->nip) {
            return 'NIP';
        }

        if ($this->nik) {
            return 'NIK';
        }

        return 'Identitas';
    }

    public function unitKerja()
    {
        return $this->belongsTo(UnitKerja::class);
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function atasan()
    {
        return $this->belongsTo(Pegawai::class, 'atasan_id');
    }

    public function bawahan()
    {
        return $this->hasMany(Pegawai::class, 'atasan_id');
    }

    public function absensi()
    {
        return $this->hasMany(Absensi::class);
    }

    public function pengajuan()
    {
        return $this->hasMany(Pengajuan::class);
    }

    public function tukin()
    {
        return $this->hasMany(PotonganTukin::class);
    }
}
