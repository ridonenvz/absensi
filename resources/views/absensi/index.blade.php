@extends('layouts.app')
@section('title', 'Absensi')

@section('content')
<div class="page-header">
    <h1 class="page-title">Absensi Pegawai</h1>
    <p class="page-subtitle">Lakukan absen masuk dan absen pulang sesuai jadwal kerja.</p>
</div>

@if(!$pegawai)
    <div class="empty-state">Akun ini belum terhubung dengan data pegawai. Hubungi admin untuk mengaktifkan fitur absensi.</div>
@else
<div class="row">
    <div class="col-lg-4 mb-3">
        <div class="stat-card">
            <span class="stat-icon"><i class="fas fa-calendar-day"></i></span>
            <div class="stat-value">{{ now()->format('H:i') }}</div>
            <p class="stat-label">Waktu Server · {{ now()->format('d M Y') }}</p>
            <hr>
            <p class="mb-1"><strong>{{ $pegawai->nama }}</strong></p>
            <p class="text-muted mb-0">{{ $pegawai->jabatan }} · {{ $pegawai->unitKerja->nama_unit ?? '-' }}</p>
        </div>
    </div>
    <div class="col-lg-8 mb-3">
        <div class="card h-100">
            <div class="card-header"><h3 class="card-title mb-0 font-weight-bold">Aksi Absensi Hari Ini</h3></div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="p-4 rounded-lg bg-light h-100">
                            <h5 class="font-weight-bold">Absen Masuk</h5>
                            <p class="text-muted">Jam masuk: {{ $absenHariIni->jam_masuk ?? 'Belum absen' }}</p>
                            <form method="POST" action="{{ route('absensi.masuk') }}">
                                @csrf
                                <button class="btn btn-success btn-block" {{ $absenHariIni && $absenHariIni->jam_masuk ? 'disabled' : '' }}><i class="fas fa-sign-in-alt w-4 h-4 mr-1"></i><span class="font-semibold">Absen Masuk</span></button>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="p-4 rounded-lg bg-light h-100">
                            <h5 class="font-weight-bold">Absen Pulang</h5>
                            <p class="text-muted">Jam pulang: {{ $absenHariIni->jam_pulang ?? 'Belum absen' }}</p>
                            <form method="POST" action="{{ route('absensi.pulang') }}">
                                @csrf
                                <button class="btn btn-danger btn-block" {{ (!$absenHariIni || !$absenHariIni->jam_masuk || $absenHariIni->jam_pulang) ? 'disabled' : '' }}><i class="fas fa-sign-out-alt w-4 h-4 mr-1"></i><span class="font-semibold">Absen Pulang</span></button>
                            </form>
                        </div>
                    </div>
                </div>
                @if($absenHariIni)
                    <div class="alert alert-info mb-0">Status hari ini: <strong>{{ ucfirst($absenHariIni->status) }}</strong>. Terlambat {{ $absenHariIni->menit_telat }} menit, kompensasi {{ $absenHariIni->menit_kompensasi }} menit.</div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header"><h3 class="card-title mb-0 font-weight-bold">Riwayat Absensi Terbaru</h3></div>
    <div class="card-body p-0">
        <table class="table mb-0">
            <thead><tr><th>Tanggal</th><th>Masuk</th><th>Pulang</th><th>Terlambat</th><th>Kompensasi</th><th>Status</th></tr></thead>
            <tbody>
            @forelse($riwayat as $row)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($row->tanggal)->format('d M Y') }}</td>
                    <td>{{ $row->jam_masuk ?? '-' }}</td>
                    <td>{{ $row->jam_pulang ?? '-' }}</td>
                    <td>{{ $row->menit_telat }} menit</td>
                    <td>{{ $row->menit_kompensasi }} menit</td>
                    <td><span class="badge badge-{{ $row->status === 'terlambat' ? 'warning' : 'success' }}">{{ ucfirst($row->status) }}</span></td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center text-muted py-4">Belum ada riwayat absensi.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endif
@endsection
