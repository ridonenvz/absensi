<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\AbsensiService;
use App\Models\Absensi;
use App\Models\UnitKerja;

class AbsensiController extends Controller
{
    public function __construct(private AbsensiService $service)
    {
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        $pegawai = $user->pegawai;

        // Pegawai (termasuk atasan/pimpinan/admin yang juga tercatat sebagai pegawai) absen mandiri.
        if ($pegawai) {
            return view('absensi.index', [
                'pegawai' => $pegawai,
                'absenHariIni' => Absensi::where('pegawai_id', $pegawai->id)->whereDate('tanggal', now()->toDateString())->first(),
                'riwayat' => Absensi::where('pegawai_id', $pegawai->id)->latest()->take(10)->get(),
            ]);
        }

        // Atasan / Pimpinan / Admin tanpa data pegawai pribadi: tampilkan monitoring kehadiran harian.
        if (in_array($user->role, ['atasan', 'pimpinan', 'admin'])) {
            $tanggal = $request->input('tanggal', now()->toDateString());
            $unitKerjaId = $request->input('unit_kerja_id');
            $status = $request->input('status');

            $query = Absensi::with(['pegawai.unitKerja'])
                ->whereDate('tanggal', $tanggal);

            if ($unitKerjaId) {
                $query->whereHas('pegawai', fn ($q) => $q->where('unit_kerja_id', $unitKerjaId));
            }

            if ($status) {
                $query->where('status', $status);
            }

            $data = $query->orderBy('tanggal', 'desc')->paginate(15)->withQueryString();

            return view('absensi.monitoring', [
                'data' => $data,
                'tanggal' => $tanggal,
                'unitKerjaId' => $unitKerjaId,
                'status' => $status,
                'unitKerjaList' => UnitKerja::orderBy('nama_unit')->get(),
                'rekapHariIni' => [
                    'hadir' => Absensi::whereDate('tanggal', $tanggal)->whereIn('status', ['hadir', 'wfh'])->count(),
                    'terlambat' => Absensi::whereDate('tanggal', $tanggal)->where('status', 'terlambat')->count(),
                    'izin' => Absensi::whereDate('tanggal', $tanggal)->where('status', 'izin')->count(),
                    'cuti' => Absensi::whereDate('tanggal', $tanggal)->where('status', 'cuti')->count(),
                ],
            ]);
        }

        return view('absensi.index', ['pegawai' => null, 'absenHariIni' => null, 'riwayat' => collect()]);
    }

    public function masuk()
    {
        $pegawai = Auth::user()->pegawai;

        if (!$pegawai) {
            return back()->with('error', 'Akun ini belum terhubung dengan data pegawai. Hubungi admin.');
        }

        $result = $this->service->absenMasuk($pegawai);

        return back()->with($result['ok'] ? 'success' : 'error', $result['message']);
    }

    public function pulang()
    {
        $pegawai = Auth::user()->pegawai;

        if (!$pegawai) {
            return back()->with('error', 'Akun ini belum terhubung dengan data pegawai. Hubungi admin.');
        }

        $result = $this->service->absenPulang($pegawai);

        return back()->with($result['ok'] ? 'success' : 'error', $result['message']);
    }
}
