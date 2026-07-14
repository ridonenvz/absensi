@extends('layouts.app')
@section('title', 'Absensi')

@section('content')
<div class="page-header">
    <h1 class="page-title">Absensi Pegawai</h1>
    <p class="page-subtitle">Data kehadiran harian seluruh pegawai.</p>
</div>

<div class="row">
    <div class="col-md-3 col-sm-6 mb-3">
        <div class="stat-card">
            <span class="stat-icon"><i class="fas fa-check text-success"></i></span>
            <div class="stat-value">{{ $rekapHariIni['hadir'] }}</div>
            <p class="stat-label">Hadir / WFH</p>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 mb-3">
        <div class="stat-card">
            <span class="stat-icon"><i class="fas fa-clock text-warning"></i></span>
            <div class="stat-value">{{ $rekapHariIni['terlambat'] }}</div>
            <p class="stat-label">Terlambat</p>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 mb-3">
        <div class="stat-card">
            <span class="stat-icon"><i class="fas fa-file-lines text-info"></i></span>
            <div class="stat-value">{{ $rekapHariIni['izin'] }}</div>
            <p class="stat-label">Izin</p>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 mb-3">
        <div class="stat-card">
            <span class="stat-icon"><i class="fas fa-umbrella-beach text-danger"></i></span>
            <div class="stat-value">{{ $rekapHariIni['cuti'] }}</div>
            <p class="stat-label">Cuti</p>
        </div>
    </div>
</div>

<div class="card mb-3">
    <div class="card-body">
        <form class="form-inline" method="GET" action="{{ route('absensi.index') }}">
            <label class="mr-2">Tanggal</label>
            <input type="date" name="tanggal" value="{{ $tanggal }}" class="form-control mr-2">

            <label class="mr-2">Unit Kerja</label>
            <select name="unit_kerja_id" class="form-control mr-2">
                <option value="">Semua Unit</option>
                @foreach($unitKerjaList as $unit)
                    <option value="{{ $unit->id }}" {{ (string) $unitKerjaId === (string) $unit->id ? 'selected' : '' }}>{{ $unit->nama_unit }}</option>
                @endforeach
            </select>

            <label class="mr-2">Status</label>
            <select name="status" class="form-control mr-2">
                <option value="">Semua Status</option>
                @foreach(['hadir','terlambat','izin','cuti','wfh'] as $s)
                    <option value="{{ $s }}" {{ $status === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                @endforeach
            </select>

            <button class="btn btn-danger"><i class="fas fa-filter mr-1"></i>Tampilkan</button>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header"><h3 class="card-title mb-0 font-weight-bold">Kehadiran Tanggal {{ \Carbon\Carbon::parse($tanggal)->format('d M Y') }}</h3></div>
    <div class="card-body p-0">
        <table class="table mb-0">
            <thead><tr><th>Pegawai</th><th>Unit Kerja</th><th>Masuk</th><th>Pulang</th><th>Terlambat</th><th>Status</th></tr></thead>
            <tbody>
            @forelse($data as $row)
                <tr>
                    <td>{{ $row->pegawai->nama ?? '-' }}</td>
                    <td>{{ $row->pegawai->unitKerja->nama_unit ?? '-' }}</td>
                    <td>{{ $row->jam_masuk ?? '-' }}</td>
                    <td>{{ $row->jam_pulang ?? '-' }}</td>
                    <td>{{ $row->menit_telat }} menit</td>
                    <td><span class="badge badge-{{ $row->status === 'terlambat' ? 'warning' : 'success' }}">{{ ucfirst($row->status) }}</span></td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center text-muted py-4">Tidak ada data kehadiran pada tanggal ini.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    @if($data->hasPages())
        <div class="card-body">
            {{ $data->links() }}
        </div>
    @endif
</div>
@endsection
