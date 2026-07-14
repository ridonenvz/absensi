<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengajuan;

class ApprovalController extends Controller
{
    public function index(Request $request)
    {
        $query = Pengajuan::with('pegawai')->where('status', 'pending');

        $this->applyFilters($query, $request);

        $data = $query->latest()->paginate(15)->withQueryString();

        return view('pengajuan.approval', [
            'data' => $data,
            'filters' => $request->only(['jenis', 'cari', 'dari', 'sampai']),
        ]);
    }

    public function riwayat(Request $request)
    {
        $query = Pengajuan::with(['pegawai', 'approver'])->whereIn('status', ['approved', 'rejected']);

        $this->applyFilters($query, $request);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $data = $query->latest('approved_at')->paginate(15)->withQueryString();

        return view('pengajuan.riwayat', [
            'data' => $data,
            'filters' => $request->only(['status', 'jenis', 'cari', 'dari', 'sampai']),
        ]);
    }

    public function approve(Request $request, $id)
    {
        $data = Pengajuan::findOrFail($id);

        $data->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
            'catatan' => $request->input('catatan'),
        ]);

        return back()->with('success', 'Pengajuan berhasil disetujui.');
    }

    public function reject(Request $request, $id)
    {
        $data = Pengajuan::findOrFail($id);

        $data->update([
            'status' => 'rejected',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
            'catatan' => $request->input('catatan'),
        ]);

        return back()->with('success', 'Pengajuan berhasil ditolak.');
    }

    private function applyFilters($query, Request $request): void
    {
        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }

        if ($request->filled('cari')) {
            $query->whereHas('pegawai', fn ($q) => $q->where('nama', 'like', '%'.$request->cari.'%'));
        }

        if ($request->filled('dari')) {
            $query->whereDate('tanggal_mulai', '>=', $request->dari);
        }

        if ($request->filled('sampai')) {
            $query->whereDate('tanggal_selesai', '<=', $request->sampai);
        }
    }
}
