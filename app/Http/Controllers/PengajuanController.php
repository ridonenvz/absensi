<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Models\Pengajuan;

class PengajuanController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $pegawai = $user->pegawai;

        // Admin tanpa data pegawai pribadi melihat rekap seluruh pengajuan.
        if (!$pegawai && $user->role === 'admin') {
            $query = Pengajuan::with('pegawai');

            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }
            if ($request->filled('jenis')) {
                $query->where('jenis', $request->jenis);
            }
            if ($request->filled('cari')) {
                $query->whereHas('pegawai', fn ($q) => $q->where('nama', 'like', '%'.$request->cari.'%'));
            }

            $data = $query->latest()->paginate(15)->withQueryString();

            return view('pengajuan.index', [
                'data' => $data,
                'pegawai' => null,
                'isAdminView' => true,
                'filters' => $request->only(['status', 'jenis', 'cari']),
            ]);
        }

        if (!$pegawai) {
            return view('pengajuan.index', ['data' => collect(), 'pegawai' => null, 'isAdminView' => false, 'filters' => []])
                ->with('error', 'Akun ini belum terhubung dengan data pegawai. Hubungi admin.');
        }

        $data = Pengajuan::where('pegawai_id', $pegawai->id)->latest()->get();

        return view('pengajuan.index', [
            'data' => $data,
            'pegawai' => $pegawai,
            'isAdminView' => false,
            'filters' => [],
        ]);
    }

    public function create()
    {
        return view('pengajuan.create');
    }

    public function store(Request $request)
    {
        $pegawai = Auth::user()->pegawai;

        if (!$pegawai) {
            return redirect('/pengajuan')->with('error', 'Akun ini belum terhubung dengan data pegawai. Hubungi admin.');
        }

        $validated = $request->validate([
            'jenis' => ['required', Rule::in(['izin', 'cuti_tahunan', 'cuti_sakit', 'cuti_melahirkan', 'cuti_penting'])],
            'tanggal_mulai' => ['required', 'date'],
            'tanggal_selesai' => ['required', 'date', 'after_or_equal:tanggal_mulai'],
            'alasan' => ['required', 'string', 'min:5'],
            'lampiran' => ['nullable', 'file', 'max:2048'],
        ]);

        $lampiran = $request->hasFile('lampiran')
            ? $request->file('lampiran')->store('lampiran', 'public')
            : null;

        Pengajuan::create([
            'pegawai_id' => $pegawai->id,
            'jenis' => $validated['jenis'],
            'tanggal_mulai' => $validated['tanggal_mulai'],
            'tanggal_selesai' => $validated['tanggal_selesai'],
            'alasan' => $validated['alasan'],
            'lampiran' => $lampiran,
            'status' => 'pending',
        ]);

        return redirect('/pengajuan')->with('success', 'Pengajuan berhasil dikirim.');
    }

    public function show(Pengajuan $pengajuan)
    {
        $user = Auth::user();
        $pegawai = $user->pegawai;

        $isOwner = $pegawai && $pengajuan->pegawai_id === $pegawai->id;
        $isReviewer = in_array($user->role, ['atasan', 'admin', 'pimpinan']);

        if (!$isOwner && !$isReviewer) {
            abort(403);
        }

        $pengajuan->load(['pegawai.unitKerja', 'approver']);

        return view('pengajuan.detail', compact('pengajuan'));
    }
}
