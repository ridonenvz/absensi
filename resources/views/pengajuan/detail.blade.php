@extends('layouts.app')
@section('title', 'Detail Pengajuan')

@section('content')
<div class="page-header">
    <h1 class="page-title">Detail Pengajuan</h1>
    <p class="page-subtitle">Informasi lengkap pengajuan izin/cuti.</p>
</div>

<!-- Menghapus col-lg-8 agar Card otomatis melebar penuh ke ujung kanan -->
<div class="card mb-4">
    <div class="card-header">
        <h3 class="card-title mb-0 font-weight-bold">Informasi Pengajuan</h3>
    </div>
    <div class="card-body">
        <table class="table table-borderless mb-0 detail-table">
            <tr class="border-bottom">
                <th>Nama Pegawai</th>
                <td class="detail-value-strong">{{ $pengajuan->pegawai->nama ?? '-' }}</td>
            </tr>
            <tr class="border-bottom">
                <th>Unit Kerja</th>
                <td>{{ $pengajuan->pegawai->unitKerja->nama_unit ?? '-' }}</td>
            </tr>
            <tr class="border-bottom">
                <th>Jenis Pengajuan</th>
                <td>{{ ucwords(str_replace('_',' ', $pengajuan->jenis)) }}</td>
            </tr>
            <tr class="border-bottom">
                <th>Periode</th>
                <td>{{ \Carbon\Carbon::parse($pengajuan->tanggal_mulai)->format('d M Y') }} s.d. {{ \Carbon\Carbon::parse($pengajuan->tanggal_selesai)->format('d M Y') }}</td>
            </tr>
            
            <!-- BARIS ALASAN: Sudah dibuat polos total tanpa kotak abu-abu dan tanpa garis kiri -->
            <tr class="border-bottom">
                <th>Alasan</th>
                <td>{{ $pengajuan->alasan }}</td>
            </tr>
            
            <tr class="border-bottom">
                <th>Lampiran</th>
                <td>
                    @if($pengajuan->lampiran)
                        <a href="{{ asset('storage/'.$pengajuan->lampiran) }}" target="_blank" class="btn btn-outline-secondary btn-sm"><i class="fas fa-paperclip mr-1"></i>Lihat Lampiran</a>
                    @else
                        <span class="text-muted font-italic">Tidak ada lampiran</span>
                    @endif
                </td>
            </tr>
            <tr class="border-bottom">
                <th>Status</th>
                <td>
                    @php
                    $statusClass = match($pengajuan->status) {
                        'approved' => 'badge-status-approved',
                        'rejected' => 'badge-status-rejected',
                        default => 'badge-status-pending',
                    };
                    @endphp
                    <span class="badge {{ $statusClass }} badge-pill-lg">
                        {{ ucfirst($pengajuan->status) }}
                    </span>
                </td>
            </tr>
            @if($pengajuan->status !== 'pending')
                <tr class="border-bottom">
                    <th>Diproses Oleh</th>
                    <td>{{ $pengajuan->approver->name ?? '-' }}</td>
                </tr>
                <tr class="border-bottom">
                    <th>Diproses Pada</th>
                    <td>{{ $pengajuan->approved_at ? \Carbon\Carbon::parse($pengajuan->approved_at)->format('d M Y H:i') : '-' }}</td>
                </tr>
                
                <!-- BARIS CATATAN ATASAN: Dibuat polos juga tanpa kotak abu-abu -->
                <tr>
                    <th>Catatan Atasan</th>
                    <td class="font-italic text-muted">"{{ $pengajuan->catatan ?: '-' }}"</td>
                </tr>
            @endif
        </table>
    </div>
</div>

<!-- FORM AKSI UNTUK ATASAN JIKA STATUS MASIH PENDING -->
@if(auth()->user()->role === 'atasan' && $pengajuan->status === 'pending')
<div class="card mb-4">
    <div class="card-header">
        <h3 class="card-title mb-0 font-weight-bold">Aksi Persetujuan</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6 mb-3 mb-md-0">
                <form method="POST" action="{{ route('pengajuan.approve', $pengajuan->id) }}">
                    @csrf
                    <div class="form-group">
                        <label class="small font-weight-bold text-muted text-uppercase">Catatan Persetujuan (opsional)</label>
                        <textarea name="catatan" class="form-control form-control-pill mb-3" rows="2" placeholder="Catatan persetujuan..."></textarea>
                    </div>
                    <button class="btn btn-success btn-block btn-action-42 btn-rounded-8"><i class="fas fa-check mr-2"></i>Setujui Pengajuan</button>
                </form>
            </div>
            <div class="col-md-6">
                <form method="POST" action="{{ route('pengajuan.reject', $pengajuan->id) }}">
                    @csrf
                    <div class="form-group">
                        <label class="small font-weight-bold text-muted text-uppercase">Catatan Penolakan (wajib)</label>
                        <textarea name="catatan" class="form-control form-control-pill mb-3" rows="2" placeholder="Alasan penolakan..." required></textarea>
                    </div>
                    <button class="btn btn-danger btn-block btn-action-42 btn-rounded-8"><i class="fas fa-times mr-2"></i>Tolak Pengajuan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endif

<div class="mt-3">
    <a href="{{ url()->previous() }}" class="btn btn-outline-secondary px-4 d-inline-flex align-items-center justify-content-center btn-action-40 btn-rounded-8">
        <i class="fas fa-arrow-left mr-2"></i>Kembali
    </a>
</div>
@endsection