<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\Pegawai;
use App\Models\Pengajuan;
use App\Models\PotonganTukin;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function index()
    {
        return view('laporan.index');
    }

    public function absensi(Request $request)
    {
        $bulan = (int) ($request->bulan ?? date('m'));
        $tahun = (int) ($request->tahun ?? date('Y'));

        $data = Absensi::with('pegawai')
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('laporan.absensi', compact('data', 'bulan', 'tahun'));
    }

    public function pegawai(Request $request)
    {
        $bulan = (int) ($request->bulan ?? date('m'));
        $tahun = (int) ($request->tahun ?? date('Y'));

        $data = Pegawai::with('unitKerja')
            ->withCount([
                'absensi as hadir_count' => fn ($q) => $q->whereIn('status', ['hadir', 'wfh'])->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun),
                'absensi as terlambat_count' => fn ($q) => $q->where('status', 'terlambat')->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun),
                'absensi as izin_count' => fn ($q) => $q->where('status', 'izin')->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun),
                'absensi as cuti_count' => fn ($q) => $q->where('status', 'cuti')->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun),
                'pengajuan as pengajuan_count' => fn ($q) => $q->whereMonth('tanggal_mulai', $bulan)->whereYear('tanggal_mulai', $tahun),
            ])
            ->orderBy('nama')
            ->get();

        return view('laporan.pegawai', compact('data', 'bulan', 'tahun'));
    }

    public function pengajuan(Request $request)
    {
        $bulan = (int) ($request->bulan ?? date('m'));
        $tahun = (int) ($request->tahun ?? date('Y'));
        $status = $request->status;

        $query = Pengajuan::with('pegawai')
            ->whereMonth('tanggal_mulai', $bulan)
            ->whereYear('tanggal_mulai', $tahun);

        if ($status) {
            $query->where('status', $status);
        }

        $data = $query->orderBy('tanggal_mulai', 'desc')->get();

        $rekap = [
            'pending' => (clone $query)->where('status', 'pending')->count(),
            'approved' => (clone $query)->where('status', 'approved')->count(),
            'rejected' => (clone $query)->where('status', 'rejected')->count(),
        ];

        return view('laporan.pengajuan', compact('data', 'bulan', 'tahun', 'status', 'rekap'));
    }

    public function tukin(Request $request)
    {
        $bulan = (int) ($request->bulan ?? date('m'));
        $tahun = (int) ($request->tahun ?? date('Y'));

        $data = PotonganTukin::with('pegawai')
            ->where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->latest()
            ->get();

        return view('laporan.tukin', compact('data', 'bulan', 'tahun'));
    }

    public function exportAbsensiPDF(Request $request)
    {
        $bulan = (int) ($request->bulan ?? date('m'));
        $tahun = (int) ($request->tahun ?? date('Y'));

        $data = Absensi::with('pegawai')
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->orderBy('tanggal')
            ->get();

        $pdf = Pdf::loadView('laporan.pdf_absensi', compact('data', 'bulan', 'tahun'));

        return $pdf->download('laporan-absensi-'.$bulan.'-'.$tahun.'.pdf');
    }

    public function exportAbsensiExcel(Request $request)
    {
        $bulan = (int) ($request->bulan ?? date('m'));
        $tahun = (int) ($request->tahun ?? date('Y'));

        $data = Absensi::with('pegawai')
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->orderBy('tanggal')
            ->get();

        $rows = $data->map(fn ($row) => [
            $row->tanggal,
            $row->pegawai->nama ?? '-',
            $row->jam_masuk ?? '-',
            $row->jam_pulang ?? '-',
            $row->menit_telat,
            $row->menit_kompensasi,
            ucfirst($row->status),
        ]);

        return $this->excelDownload(
            'laporan-absensi-'.$bulan.'-'.$tahun,
            ['Tanggal', 'Pegawai', 'Masuk', 'Pulang', 'Telat (menit)', 'Kompensasi (menit)', 'Status'],
            $rows
        );
    }

    public function exportPegawaiExcel(Request $request)
    {
        $bulan = (int) ($request->bulan ?? date('m'));
        $tahun = (int) ($request->tahun ?? date('Y'));

        $data = Pegawai::with('unitKerja')
            ->withCount([
                'absensi as hadir_count' => fn ($q) => $q->whereIn('status', ['hadir', 'wfh'])->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun),
                'absensi as terlambat_count' => fn ($q) => $q->where('status', 'terlambat')->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun),
                'absensi as izin_count' => fn ($q) => $q->where('status', 'izin')->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun),
                'absensi as cuti_count' => fn ($q) => $q->where('status', 'cuti')->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun),
                'pengajuan as pengajuan_count' => fn ($q) => $q->whereMonth('tanggal_mulai', $bulan)->whereYear('tanggal_mulai', $tahun),
            ])
            ->orderBy('nama')
            ->get();

        $rows = $data->map(fn ($p) => [
            $p->nomor_identitas,
            $p->nama,
            $p->jabatan,
            $p->unitKerja->nama_unit ?? '-',
            $p->hadir_count,
            $p->terlambat_count,
            $p->izin_count,
            $p->cuti_count,
            $p->pengajuan_count,
        ]);

        return $this->excelDownload(
            'laporan-pegawai-'.$bulan.'-'.$tahun,
            ['NIP/NIK', 'Nama', 'Jabatan', 'Unit Kerja', 'Hadir', 'Terlambat', 'Izin', 'Cuti', 'Jumlah Pengajuan'],
            $rows
        );
    }

    public function exportPengajuanExcel(Request $request)
    {
        $bulan = (int) ($request->bulan ?? date('m'));
        $tahun = (int) ($request->tahun ?? date('Y'));
        $status = $request->status;

        $query = Pengajuan::with('pegawai')
            ->whereMonth('tanggal_mulai', $bulan)
            ->whereYear('tanggal_mulai', $tahun);

        if ($status) {
            $query->where('status', $status);
        }

        $data = $query->orderBy('tanggal_mulai', 'desc')->get();

        $rows = $data->map(fn ($row) => [
            $row->pegawai->nama ?? '-',
            ucwords(str_replace('_', ' ', $row->jenis)),
            $row->tanggal_mulai,
            $row->tanggal_selesai,
            ucfirst($row->status),
            $row->catatan ?: '-',
        ]);

        return $this->excelDownload(
            'laporan-pengajuan-'.$bulan.'-'.$tahun,
            ['Pegawai', 'Jenis', 'Mulai', 'Selesai', 'Status', 'Catatan'],
            $rows
        );
    }

    /**
     * Ekspor sederhana ke format Excel (.xls) tanpa dependensi tambahan,
     * memanfaatkan tabel HTML yang dapat dibuka langsung oleh Microsoft Excel.
     */
    private function excelDownload(string $filename, array $headers, $rows)
    {
        $html = '<table border="1"><thead><tr>';
        foreach ($headers as $header) {
            $html .= '<th>'.e($header).'</th>';
        }
        $html .= '</tr></thead><tbody>';

        foreach ($rows as $row) {
            $html .= '<tr>';
            foreach ($row as $cell) {
                $html .= '<td>'.e($cell).'</td>';
            }
            $html .= '</tr>';
        }

        $html .= '</tbody></table>';

        return response($html, 200, [
            'Content-Type' => 'application/vnd.ms-excel; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="'.$filename.'.xls"',
        ]);
    }
}
