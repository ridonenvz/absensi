@extends('layouts.app')
@section('title', 'Dashboard Pimpinan')

@section('content')
<div class="page-header">
    <h1 class="page-title">Dashboard Pimpinan</h1>
    <p class="page-subtitle">Ringkasan strategis kehadiran dan pengajuan pegawai.</p>
</div>

<div class="row">
    <div class="col-md-4 mb-3"><div class="stat-card"><span class="stat-icon"><i class="fas fa-users"></i></span><div class="stat-value">{{ $total_pegawai }}</div><p class="stat-label">Pegawai</p></div></div>
    <div class="col-md-4 mb-3"><div class="stat-card"><span class="stat-icon"><i class="fas fa-fingerprint"></i></span><div class="stat-value">{{ $total_absensi }}</div><p class="stat-label">Total Rekam Absensi</p></div></div>
    <div class="col-md-4 mb-3"><div class="stat-card"><span class="stat-icon"><i class="fas fa-paper-plane"></i></span><div class="stat-value">{{ $total_pengajuan }}</div><p class="stat-label">Total Pengajuan</p></div></div>
</div>

<div class="card mt-2">
    <div class="card-header"><h3 class="card-title mb-0 font-weight-bold">Pengajuan Terbaru</h3></div>
    <div class="card-body p-0">
        <table class="table mb-0">
            <thead><tr><th>Pegawai</th><th>Jenis</th><th>Periode</th><th>Status</th></tr></thead>
            <tbody>
            @forelse($pengajuanTerbaru as $item)
                <tr>
                    <td>{{ $item->pegawai->nama ?? '-' }}</td>
                    <td>{{ ucwords(str_replace('_',' ', $item->jenis)) }}</td>
                    <td>{{ $item->tanggal_mulai }} s.d. {{ $item->tanggal_selesai }}</td>
                    <td><span class="badge badge-{{ $item->status === 'approved' ? 'success' : ($item->status === 'rejected' ? 'danger' : 'warning') }}">{{ ucfirst($item->status) }}</span></td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-center text-muted py-4">Belum ada pengajuan.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection