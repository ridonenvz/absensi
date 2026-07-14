@extends('layouts.app')
@section('title', 'Rekap Pengajuan')
@section('content')
<div class="page-header"><h1 class="page-title">Rekap Pengajuan</h1><p class="page-subtitle">Rekap pengajuan izin dan cuti pegawai per bulan.</p></div>

<div class="row">
    <div class="col-md-4 mb-3">
        <div class="stat-card"><span class="stat-icon"><i class="fas fa-hourglass-half text-warning"></i></span><div class="stat-value">{{ $rekap['pending'] }}</div><p class="stat-label">Pending</p></div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="stat-card"><span class="stat-icon"><i class="fas fa-check text-success"></i></span><div class="stat-value">{{ $rekap['approved'] }}</div><p class="stat-label">Approved</p></div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="stat-card"><span class="stat-icon"><i class="fas fa-times text-danger"></i></span><div class="stat-value">{{ $rekap['rejected'] }}</div><p class="stat-label">Rejected</p></div>
    </div>
</div>

<div class="card mb-3">
    <div class="card-body">
        <form class="form-inline" method="GET" action="{{ route('laporan.pengajuan') }}">
            <label class="mr-2">Bulan</label>
            <input type="number" min="1" max="12" name="bulan" value="{{ $bulan }}" class="form-control mr-2">
            <label class="mr-2">Tahun</label>
            <input type="number" name="tahun" value="{{ $tahun }}" class="form-control mr-2">
            <label class="mr-2">Status</label>
            <select name="status" class="form-control mr-2">
                <option value="">Semua Status</option>
                @foreach(['pending','approved','rejected'] as $s)
                    <option value="{{ $s }}" {{ $status === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                @endforeach
            </select>
            <button class="btn btn-danger mr-2">Tampilkan</button>
            <a href="{{ route('laporan.pengajuan.excel', ['bulan'=>$bulan,'tahun'=>$tahun,'status'=>$status]) }}" class="btn btn-outline-danger"><i class="fas fa-file-excel mr-1"></i>Excel</a>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table mb-0">
            <thead><tr><th>Pegawai</th><th>Jenis</th><th>Periode</th><th>Status</th><th>Catatan</th></tr></thead>
            <tbody>
            @forelse($data as $item)
                <tr>
                    <td>{{ $item->pegawai->nama ?? '-' }}</td>
                    <td>{{ ucwords(str_replace('_',' ', $item->jenis)) }}</td>
                    <td>{{ $item->tanggal_mulai }} s.d. {{ $item->tanggal_selesai }}</td>
                    <td><span class="badge badge-{{ $item->status === 'approved' ? 'success' : ($item->status === 'rejected' ? 'danger' : 'warning') }}">{{ ucfirst($item->status) }}</span></td>
                    <td>{{ \Illuminate\Support\Str::limit($item->catatan ?: '-', 50) }}</td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center text-muted py-4">Data tidak ditemukan.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
