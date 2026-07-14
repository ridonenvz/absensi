@extends('layouts.app')
@section('title', 'Laporan')
@section('content')
<div class="page-header"><h1 class="page-title">Laporan</h1><p class="page-subtitle">Pilih jenis laporan yang ingin ditampilkan.</p></div>
<div class="action-grid">
    <a href="{{ route('laporan.absensi') }}" class="action-tile"><i class="fas fa-fingerprint mr-2 text-danger"></i>Rekap Absensi</a>
    <a href="{{ route('laporan.pegawai') }}" class="action-tile"><i class="fas fa-users mr-2 text-danger"></i>Rekap Pegawai</a>
    <a href="{{ route('laporan.pengajuan') }}" class="action-tile"><i class="fas fa-paper-plane mr-2 text-danger"></i>Rekap Pengajuan</a>
    <a href="{{ route('laporan.tukin') }}" class="action-tile"><i class="fas fa-money-bill-wave mr-2 text-danger"></i>Laporan Tukin</a>
    @if(auth()->user()->role === 'admin')
        <a href="{{ route('tukin.index') }}" class="action-tile"><i class="fas fa-calculator mr-2 text-danger"></i>Hitung Tukin</a>
    @endif
</div>
@endsection
