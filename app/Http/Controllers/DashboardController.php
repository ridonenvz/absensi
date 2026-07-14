<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Pegawai;
use App\Models\Absensi;
use App\Models\Pengajuan;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $today = Carbon::today()->toDateString();
        $bulan = now()->month;
        $tahun = now()->year;

        if ($user->role === 'admin') {
            $chart = [
                'Hadir' => Absensi::where('status', 'hadir')->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->count(),
                'Terlambat' => Absensi::where('status', 'terlambat')->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->count(),
                'Izin' => Absensi::where('status', 'izin')->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->count(),
                'Cuti' => Absensi::where('status', 'cuti')->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->count(),
                'WFH' => Absensi::where('status', 'wfh')->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->count(),
            ];

            return view('dashboard.admin', [
                'pegawai' => Pegawai::count(),
                'hadir' => Absensi::whereDate('tanggal', $today)->whereIn('status', ['hadir', 'wfh'])->count(),
                'telat' => Absensi::whereDate('tanggal', $today)->where('status', 'terlambat')->count(),
                'izin' => Pengajuan::where('status', 'approved')->whereDate('tanggal_mulai', '<=', $today)->whereDate('tanggal_selesai', '>=', $today)->count(),
                'pengajuan' => Pengajuan::where('status', 'pending')->count(),
                'chartLabels' => array_keys($chart),
                'chartValues' => array_values($chart),
                'absensiTerbaru' => Absensi::with('pegawai')->latest()->take(6)->get(),
            ]);
        }

        if ($user->role === 'pegawai') {
            $pegawai = $user->pegawai;

            return view('dashboard.pegawai', [
                'pegawai' => $pegawai,
                'absenHariIni' => $pegawai ? Absensi::where('pegawai_id', $pegawai->id)->whereDate('tanggal', $today)->first() : null,
                'riwayat' => $pegawai ? Absensi::where('pegawai_id', $pegawai->id)->latest()->take(5)->get() : collect(),
                'pengajuan' => $pegawai ? Pengajuan::where('pegawai_id', $pegawai->id)->latest()->take(5)->get() : collect(),
            ]);
        }

        if ($user->role === 'atasan') {
            return view('dashboard.atasan', [
                'pengajuan_pending' => Pengajuan::where('status', 'pending')->count(),
                'pengajuan_disetujui' => Pengajuan::where('status', 'approved')->count(),
                'pengajuan_ditolak' => Pengajuan::where('status', 'rejected')->count(),
                'pengajuanTerbaru' => Pengajuan::with('pegawai')->latest()->take(8)->get(),
            ]);
        }

        if ($user->role === 'pimpinan') {
            $statistik = Absensi::query()
                ->selectRaw('tanggal, COUNT(*) as total')
                ->where('tanggal', '>=', now()->subDays(6)->toDateString())
                ->groupBy('tanggal')
                ->orderBy('tanggal')
                ->get();

            return view('dashboard.pimpinan', [
                'total_absensi' => Absensi::count(),
                'total_pengajuan' => Pengajuan::count(),
                'total_pegawai' => Pegawai::count(),
                'labels' => $statistik->pluck('tanggal')->map(fn ($tanggal) => Carbon::parse($tanggal)->format('d M'))->values(),
                'data' => $statistik->pluck('total')->values(),
                'pengajuanTerbaru' => Pengajuan::with('pegawai')->latest()->take(6)->get(),
            ]);
        }

        abort(403);
    }
}
