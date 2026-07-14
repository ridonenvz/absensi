@extends('layouts.app')
@section('title', 'Pengaturan')

@section('content')
<div class="page-header">
    <h1 class="page-title">Pengaturan</h1>
    <p class="page-subtitle">Kelola data master aplikasi: unit kerja, jam kerja, akun pengguna, dan tunjangan kinerja.</p>
</div>

<div class="row">
    <div class="col-md-3 col-sm-6 mb-3">
        <a href="{{ route('unit-kerja.index') }}" class="stat-card d-block text-decoration-none h-100">
            <span class="stat-icon"><i class="fas fa-building"></i></span>
            <div class="stat-value">{{ $totalUnitKerja }}</div>
            <p class="stat-label">Unit Kerja</p>
        </a>
    </div>
    <div class="col-md-3 col-sm-6 mb-3">
        <a href="{{ route('jam-kerja.index') }}" class="stat-card d-block text-decoration-none h-100">
            <span class="stat-icon"><i class="fas fa-calendar-days"></i></span>
            <div class="stat-value">{{ $totalJamKerja }}</div>
            <p class="stat-label">Jam Kerja</p>
        </a>
    </div>
    <div class="col-md-3 col-sm-6 mb-3">
        <a href="{{ route('user.index') }}" class="stat-card d-block text-decoration-none h-100">
            <span class="stat-icon"><i class="fas fa-user-shield"></i></span>
            <div class="stat-value">{{ $totalUser }}</div>
            <p class="stat-label">Akun Pengguna</p>
        </a>
    </div>
    <div class="col-md-3 col-sm-6 mb-3">
        <a href="{{ route('tukin.index') }}" class="stat-card d-block text-decoration-none h-100">
            <span class="stat-icon"><i class="fas fa-money-bill-wave"></i></span>
            <div class="stat-value"><i class="fas fa-calculator"></i></div>
            <p class="stat-label">Hitung Tukin</p>
        </a>
    </div>
</div>

<div class="card">
    <div class="card-header"><h3 class="card-title mb-0 font-weight-bold">Menu Pengaturan</h3></div>
    <div class="card-body">
        <div class="action-grid">
            <a href="{{ route('pegawai.index') }}" class="action-tile"><i class="fas fa-users mr-2 text-danger"></i>Data Pegawai</a>
            <a href="{{ route('unit-kerja.index') }}" class="action-tile"><i class="fas fa-building mr-2 text-danger"></i>Unit Kerja</a>
            <a href="{{ route('jam-kerja.index') }}" class="action-tile"><i class="fas fa-calendar-days mr-2 text-danger"></i>Jam Kerja</a>
            <a href="{{ route('user.index') }}" class="action-tile"><i class="fas fa-user-shield mr-2 text-danger"></i>Akun Pengguna</a>
            <a href="{{ route('tukin.index') }}" class="action-tile"><i class="fas fa-money-bill-wave mr-2 text-danger"></i>Tunjangan Kinerja</a>
        </div>
    </div>
</div>
@endsection
