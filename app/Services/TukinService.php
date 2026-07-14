<?php

namespace App\Services;

use App\Models\Absensi;
use App\Models\PotonganTukin;

class TukinService
{
    public function hitungBulanan($pegawaiId, $bulan, $tahun)
    {
        $data = Absensi::where('pegawai_id', $pegawaiId)
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->get();

        $totalTelat = (int) $data->sum('menit_telat');
        $totalKompensasi = (int) $data->sum('menit_kompensasi');
        $selisih = max(0, $totalTelat - $totalKompensasi);
        $potonganPerMenit = 1000;

        return PotonganTukin::updateOrCreate(
            [
                'pegawai_id' => $pegawaiId,
                'bulan' => $bulan,
                'tahun' => $tahun,
            ],
            [
                'total_telat' => $totalTelat,
                'total_kompensasi' => $totalKompensasi,
                'potongan' => $selisih * $potonganPerMenit,
            ]
        );
    }
}
