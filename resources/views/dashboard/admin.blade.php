@extends('layouts.app')
@section('title', 'Dashboard Admin')

@section('content')
<div class="page-header">
    <h1 class="page-title">Dashboard Admin</h1>
    <p class="page-subtitle">Ringkasan absensi, pegawai, dan pengajuan yang perlu dipantau.</p>
</div>

<div class="row">
    <div class="col-md-3 mb-3">
        <div class="stat-card">
            <span class="stat-icon"><i class="fas fa-users"></i></span>
            <div class="stat-value">{{ $pegawai }}</div>
            <p class="stat-label">Total Pegawai</p>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="stat-card">
            <span class="stat-icon"><i class="fas fa-check"></i></span>
            <div class="stat-value">{{ $hadir }}</div>
            <p class="stat-label">Hadir Hari Ini</p>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="stat-card">
            <span class="stat-icon"><i class="fas fa-clock"></i></span>
            <div class="stat-value">{{ $telat }}</div>
            <p class="stat-label">Terlambat Hari Ini</p>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="stat-card">
            <span class="stat-icon"><i class="fas fa-inbox"></i></span>
            <div class="stat-value">{{ $pengajuan }}</div>
            <p class="stat-label">Pengajuan Pending</p>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12 mb-3">
        <div class="card h-100">
            <div class="card-header">
                <h3 class="card-title mb-0 font-weight-bold">Absensi Terbaru</h3>
            </div>

            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Pegawai</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                    @forelse($absensiTerbaru as $row)
                        <tr>
                            <td>{{ $row->pegawai->nama ?? '-' }}</td>
                            <td>{{ \Carbon\Carbon::parse($row->tanggal)->format('d M Y') }}</td>
                            <td>
                                <span class="badge badge-{{ $row->status === 'terlambat' ? 'warning' : 'success' }}">
                                    {{ ucfirst($row->status) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted py-4">
                                Belum ada data absensi.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="action-grid mt-2">
    <a class="action-tile" href="{{ route('pegawai.index') }}">
        <i class="fas fa-users mr-2 text-danger"></i>Kelola Pegawai
    </a>

    <a class="action-tile" href="{{ route('unit-kerja.index') }}">
        <i class="fas fa-building mr-2 text-danger"></i>Kelola Unit Kerja
    </a>

    <a class="action-tile" href="{{ route('jam-kerja.index') }}">
        <i class="fas fa-calendar-days mr-2 text-danger"></i>Atur Jam Kerja
    </a>

    <a class="action-tile" href="{{ route('laporan.index') }}">
        <i class="fas fa-file-lines mr-2 text-danger"></i>Buka Laporan
    </a>
</div>
@endsection