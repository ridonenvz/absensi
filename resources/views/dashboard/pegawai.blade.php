@extends('layouts.app')
@section('title', 'Dashboard Pegawai')

@section('content')
<div class="page-header">
    <h1 class="page-title">Dashboard Pegawai</h1>
    <p class="page-subtitle">Pantau absensi hari ini dan status pengajuan terbaru.</p>
</div>

@if(!$pegawai)
    <div class="empty-state">Akun Anda belum terhubung dengan data pegawai. Hubungi admin agar absensi dan pengajuan dapat digunakan.</div>
@else
<div class="row">
    <div class="col-lg-4 mb-3">
        <div class="stat-card">
            <span class="stat-icon"><i class="fas fa-fingerprint"></i></span>
            <div class="stat-value">{{ $absenHariIni ? ucfirst($absenHariIni->status) : 'Belum' }}</div>
            <p class="stat-label">Status Absensi Hari Ini</p>
            <a href="{{ route('absensi.index') }}" class="btn btn-danger btn-block mt-3">Buka Absensi</a>
        </div>
    </div>
    <div class="col-lg-8 mb-3">
        <div class="card h-100">
            <div class="card-header"><h3 class="card-title mb-0 font-weight-bold">Profil Singkat</h3></div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6"><span class="text-muted">Nama</span><h5>{{ $pegawai->nama }}</h5></div>
                    <div class="col-md-6"><span class="text-muted">{{ $pegawai->jenis_identitas }}</span><h5>{{ $pegawai->nomor_identitas }}</h5></div>
                    <div class="col-md-6"><span class="text-muted">Jabatan</span><h5>{{ $pegawai->jabatan }}</h5></div>
                    <div class="col-md-6"><span class="text-muted">Unit Kerja</span><h5>{{ $pegawai->unitKerja->nama_unit ?? '-' }}</h5></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-6 mb-3">
        <div class="card h-100">
            <div class="card-header"><h3 class="card-title mb-0 font-weight-bold">Riwayat Absensi</h3></div>
            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead><tr><th>Tanggal</th><th>Masuk</th><th>Pulang</th><th>Status</th></tr></thead>
                    <tbody>
                    @forelse($riwayat as $r)
                        <tr><td>{{ \Carbon\Carbon::parse($r->tanggal)->format('d M Y') }}</td><td>{{ $r->jam_masuk ?? '-' }}</td><td>{{ $r->jam_pulang ?? '-' }}</td><td><span class="badge badge-light">{{ ucfirst($r->status) }}</span></td></tr>
                    @empty
                        <tr><td colspan="4" class="text-center text-muted py-4">Belum ada riwayat absensi.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-6 mb-3">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center"><h3 class="card-title mb-0 font-weight-bold">Pengajuan Terbaru</h3><a href="{{ route('pengajuan.create') }}" class="btn btn-sm btn-danger">Buat</a></div>
            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead><tr><th>Jenis</th><th>Periode</th><th>Status</th></tr></thead>
                    <tbody>
                    @forelse($pengajuan as $p)
                        <tr><td>{{ ucwords(str_replace('_',' ', $p->jenis)) }}</td><td>{{ $p->tanggal_mulai }} - {{ $p->tanggal_selesai }}</td><td><span class="badge badge-{{ $p->status === 'approved' ? 'success' : ($p->status === 'rejected' ? 'danger' : 'warning') }}">{{ ucfirst($p->status) }}</span></td></tr>
                    @empty
                        <tr><td colspan="3" class="text-center text-muted py-4">Belum ada pengajuan.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endif
@endsection
