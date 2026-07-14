<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pegawai;
use App\Models\PotonganTukin;
use App\Services\TukinService;

class TukinController extends Controller
{
    public function __construct(private TukinService $service)
    {
    }

    public function index(Request $request)
    {
        $bulan = (int) ($request->bulan ?? now()->month);
        $tahun = (int) ($request->tahun ?? now()->year);

        $data = Pegawai::with(['unitKerja', 'user'])->orderBy('nama')->get();
        $potongan = PotonganTukin::where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->get()
            ->keyBy('pegawai_id');

        return view('tukin.index', compact('data', 'potongan', 'bulan', 'tahun'));
    }

    public function hitung(Pegawai $pegawai, Request $request)
    {
        $bulan = (int) ($request->bulan ?? now()->month);
        $tahun = (int) ($request->tahun ?? now()->year);

        $this->service->hitungBulanan($pegawai->id, $bulan, $tahun);

        return redirect()->route('tukin.index', ['bulan' => $bulan, 'tahun' => $tahun])
            ->with('success', 'Tukin '.$pegawai->nama.' berhasil dihitung.');
    }
}
