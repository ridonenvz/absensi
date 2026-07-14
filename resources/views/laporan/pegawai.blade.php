@extends('layouts.app')
@section('title', 'Rekap Pegawai')
@section('content')
<div class="page-header"><h1 class="page-title">Rekap Pegawai</h1><p class="page-subtitle">Rekap kehadiran dan pengajuan per pegawai dalam satu bulan.</p></div>
<div class="card mb-3">
    <div class="card-body">
        <form class="form-inline" method="GET" action="{{ route('laporan.pegawai') }}">
            <label class="mr-2">Bulan</label>
            <input type="number" min="1" max="12" name="bulan" value="{{ $bulan }}" class="form-control mr-2">
            <label class="mr-2">Tahun</label>
            <input type="number" name="tahun" value="{{ $tahun }}" class="form-control mr-2">
            <button class="btn btn-danger mr-2">Tampilkan</button>
            <a href="{{ route('laporan.pegawai.excel', ['bulan'=>$bulan,'tahun'=>$tahun]) }}" class="btn btn-outline-danger"><i class="fas fa-file-excel mr-1"></i>Excel</a>
        </form>
    </div>
</div>
<div class="card">
    <div class="card-body p-0">
        <table class="table mb-0">
            <thead><tr><th>Nama</th><th>Jabatan</th><th>Unit Kerja</th><th>Hadir</th><th>Terlambat</th><th>Izin</th><th>Cuti</th><th>Pengajuan</th></tr></thead>
            <tbody>
            @forelse($data as $p)
                <tr>
                    <td>{{ $p->nama }}</td>
                    <td>{{ $p->jabatan }}</td>
                    <td>{{ $p->unitKerja->nama_unit ?? '-' }}</td>
                    <td>{{ $p->hadir_count }}</td>
                    <td>{{ $p->terlambat_count }}</td>
                    <td>{{ $p->izin_count }}</td>
                    <td>{{ $p->cuti_count }}</td>
                    <td>{{ $p->pengajuan_count }}</td>
                </tr>
            @empty
                <tr><td colspan="8" class="text-center text-muted py-4">Data tidak ditemukan.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
