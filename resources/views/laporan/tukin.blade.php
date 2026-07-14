@extends('layouts.app')
@section('title', 'Laporan Tukin')
@section('content')
<div class="page-header"><h1 class="page-title">Laporan Tukin</h1><p class="page-subtitle">Rekap potongan tukin pegawai.</p></div>
<div class="card mb-3"><div class="card-body"><form class="form-inline" method="GET" action="{{ route('laporan.tukin') }}"><label class="mr-2">Bulan</label><input type="number" min="1" max="12" name="bulan" value="{{ $bulan }}" class="form-control mr-2"><label class="mr-2">Tahun</label><input type="number" name="tahun" value="{{ $tahun }}" class="form-control mr-2"><button class="btn btn-danger">Tampilkan</button></form></div></div>
<div class="card"><div class="card-body p-0"><table class="table mb-0"><thead><tr><th>Pegawai</th><th>Bulan</th><th>Tahun</th><th>Telat</th><th>Kompensasi</th><th>Potongan</th></tr></thead><tbody>@forelse($data as $row)<tr><td>{{ $row->pegawai->nama ?? '-' }}</td><td>{{ $row->bulan }}</td><td>{{ $row->tahun }}</td><td>{{ $row->total_telat }} menit</td><td>{{ $row->total_kompensasi }} menit</td><td>Rp {{ number_format($row->potongan,0,',','.') }}</td></tr>@empty<tr><td colspan="6" class="text-center text-muted py-4">Data tidak ditemukan.</td></tr>@endforelse</tbody></table></div></div>
@endsection
