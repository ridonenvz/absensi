@extends('layouts.app')
@section('title', 'Dashboard Atasan')

@section('content')
<div class="page-header">
    <h1 class="page-title">Dashboard Atasan</h1>
    <p class="page-subtitle">Kelola persetujuan izin dan cuti pegawai.</p>
</div>

<div class="row">
    <div class="col-md-4 mb-3"><div class="stat-card"><span class="stat-icon"><i class="fas fa-hourglass-half"></i></span><div class="stat-value">{{ $pengajuan_pending }}</div><p class="stat-label">Menunggu Persetujuan</p></div></div>
    <div class="col-md-4 mb-3"><div class="stat-card"><span class="stat-icon"><i class="fas fa-check"></i></span><div class="stat-value">{{ $pengajuan_disetujui }}</div><p class="stat-label">Disetujui</p></div></div>
    <div class="col-md-4 mb-3"><div class="stat-card"><span class="stat-icon"><i class="fas fa-xmark"></i></span><div class="stat-value">{{ $pengajuan_ditolak }}</div><p class="stat-label">Ditolak</p></div></div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title mb-0 font-weight-bold">Pengajuan Terbaru</h3>
        <a href="{{ route('pengajuan.approval') }}" class="btn btn-danger btn-sm">Buka Approval</a>
    </div>
    <div class="card-body p-0">
        <table class="table mb-0">
            <thead><tr><th>Pegawai</th><th>Jenis</th><th>Periode</th><th>Status</th></tr></thead>
            <tbody>
            @forelse($pengajuanTerbaru as $item)
                <tr><td>{{ $item->pegawai->nama ?? '-' }}</td><td>{{ ucwords(str_replace('_',' ', $item->jenis)) }}</td><td>{{ $item->tanggal_mulai }} - {{ $item->tanggal_selesai }}</td><td><span class="badge badge-light">{{ ucfirst($item->status) }}</span></td></tr>
            @empty
                <tr><td colspan="4" class="text-center text-muted py-4">Belum ada pengajuan.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
