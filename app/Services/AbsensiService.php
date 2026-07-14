<?php

namespace App\Services;

use App\Models\Absensi;
use App\Models\JamKerja;
use App\Models\Pegawai;
use Carbon\Carbon;

class AbsensiService
{
    private array $namaHari = [
        1 => 'Senin',
        2 => 'Selasa',
        3 => 'Rabu',
        4 => 'Kamis',
        5 => 'Jumat',
        6 => 'Sabtu',
        7 => 'Minggu',
    ];

    public function absenMasuk(Pegawai $pegawai): array
    {
        $now = Carbon::now();
        $tanggal = $now->toDateString();
        $hari = $this->namaHari[$now->dayOfWeekIso] ?? $now->isoFormat('dddd');

        $existing = Absensi::where('pegawai_id', $pegawai->id)
            ->whereDate('tanggal', $tanggal)
            ->first();

        if ($existing && $existing->jam_masuk) {
            return ['ok' => false, 'message' => 'Anda sudah melakukan absen masuk hari ini.'];
        }

        $jamKerja = JamKerja::where('hari', $hari)->first();

        if (!$jamKerja) {
            return ['ok' => false, 'message' => 'Jadwal kerja hari ini belum diatur oleh admin.'];
        }

        $menitTelat = 0;
        $status = 'hadir';

        if ($jamKerja->is_wfh) {
            $status = 'wfh';
        } elseif ($jamKerja->jam_masuk) {
            $jamMasukResmi = Carbon::parse($tanggal.' '.$jamKerja->jam_masuk);
            $menitTelat = $now->greaterThan($jamMasukResmi)
                ? (int) $jamMasukResmi->diffInMinutes($now)
                : 0;
            $status = $menitTelat > 0 ? 'terlambat' : 'hadir';
        }

        Absensi::updateOrCreate(
            ['pegawai_id' => $pegawai->id, 'tanggal' => $tanggal],
            [
                'jam_masuk' => $now->format('H:i:s'),
                'status' => $status,
                'menit_telat' => $menitTelat,
                'keterangan' => $status === 'wfh' ? 'Work from home' : null,
            ]
        );

        return ['ok' => true, 'message' => 'Absen masuk berhasil disimpan.'];
    }

    public function absenPulang(Pegawai $pegawai): array
    {
        $now = Carbon::now();
        $tanggal = $now->toDateString();
        $hari = $this->namaHari[$now->dayOfWeekIso] ?? $now->isoFormat('dddd');

        $absen = Absensi::where('pegawai_id', $pegawai->id)
            ->whereDate('tanggal', $tanggal)
            ->first();

        if (!$absen || !$absen->jam_masuk) {
            return ['ok' => false, 'message' => 'Anda belum melakukan absen masuk hari ini.'];
        }

        if ($absen->jam_pulang) {
            return ['ok' => false, 'message' => 'Anda sudah melakukan absen pulang hari ini.'];
        }

        $jamKerja = JamKerja::where('hari', $hari)->first();
        $menitKompensasi = 0;

        if ($jamKerja && !$jamKerja->is_wfh && $jamKerja->jam_pulang) {
            $jamPulangResmi = Carbon::parse($tanggal.' '.$jamKerja->jam_pulang);
            $menitKompensasi = $now->greaterThan($jamPulangResmi)
                ? (int) $jamPulangResmi->diffInMinutes($now)
                : 0;
        }

        $absen->update([
            'jam_pulang' => $now->format('H:i:s'),
            'menit_kompensasi' => $menitKompensasi,
        ]);

        return ['ok' => true, 'message' => 'Absen pulang berhasil disimpan.'];
    }
}
