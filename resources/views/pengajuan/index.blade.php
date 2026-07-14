@extends('layouts.app')
@section('title', $isAdminView ? 'Pengajuan' : 'Pengajuan Saya')

@section('content')
<div class="page-header">
    <h1 class="page-title">{{ $isAdminView ? 'Pengajuan' : 'Pengajuan Saya' }}</h1>
    <p class="page-subtitle">{{ $isAdminView ? 'Rekap seluruh pengajuan izin dan cuti pegawai.' : 'Riwayat pengajuan izin dan cuti.' }}</p>
</div>

@if($isAdminView)
<div class="card mb-3">
    <div class="card-body py-3">
        <form class="d-flex align-items-center flex-wrap" method="GET" action="{{ route('pengajuan.index') }}">
            <div class="filter-field">
                <label class="mb-0 filter-field-label">Nama Pegawai</label>
                <input type="text" name="cari" value="{{ $filters['cari'] ?? '' }}" class="form-control form-control-sm form-control-pill filter-input-narrow" placeholder="Cari nama...">
            </div>

            <div class="filter-field">
                <label class="mb-0 filter-field-label">Jenis</label>
                <select name="jenis" class="form-control form-control-sm form-control-pill filter-select-jenis">
                    <option value="">Semua Jenis</option>
                    @foreach(['izin','cuti_tahunan','cuti_sakit','cuti_melahirkan','cuti_penting'] as $j)
                        <option value="{{ $j }}" {{ ($filters['jenis'] ?? '') === $j ? 'selected' : '' }}>{{ ucwords(str_replace('_',' ',$j)) }}</option>
                    @endforeach
                </select>
            </div>

            <div class="filter-field">
                <label class="mb-0 filter-field-label">Status</label>
                <select name="status" class="form-control form-control-sm form-control-pill filter-select-status">
                    <option value="">Semua Status</option>
                    @foreach(['pending','approved','rejected'] as $s)
                        <option value="{{ $s }}" {{ ($filters['status'] ?? '') === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
            </div>

            <button class="btn btn-danger btn-sm px-3 btn-rounded-8 btn-filter-inline"><i class="fas fa-filter mr-1"></i>Filter</button>
        </form>
    </div>
</div>
@endif

<div class="card">
    <div class="card-header table-toolbar">
        <div>
            <h3 class="card-title mb-0 font-weight-bold">Daftar Pengajuan</h3>
            <p class="toolbar-subtitle mb-0">Seluruh berkas izin dan cuti yang terdata.</p>
        </div>
        @unless($isAdminView)
            <a href="{{ route('pengajuan.create') }}" class="btn btn-danger px-3 d-inline-flex align-items-center btn-action-38 btn-rounded-8">
                <i class="fas fa-plus mr-2"></i>Buat Pengajuan
            </a>
        @endunless
    </div>
    
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        @if($isAdminView)<th>Pegawai</th>@endif
                        <th>Jenis</th><th>Periode</th><th>Alasan</th><th>Status</th><th>Disetujui Pada</th><th class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($data as $item)
                    <tr>
                        @if($isAdminView)<td class="cell-strong">{{ $item->pegawai->nama ?? '-' }}</td>@endif
                        <td>{{ ucwords(str_replace('_',' ', $item->jenis)) }}</td>
                        <td>{{ $item->tanggal_mulai }} s.d. {{ $item->tanggal_selesai }}</td>
                        <td>{{ \Illuminate\Support\Str::limit($item->alasan, 60) }}</td>
                        <td>
                            @php
                            $statusClass = match($item->status) {
                                'approved' => 'badge-status-approved',
                                'rejected' => 'badge-status-rejected',
                                default => 'badge-status-pending',
                            };
                            @endphp
                            <span class="badge {{ $statusClass }} badge-pill-md">
                                {{ ucfirst($item->status) }}
                            </span>
                        </td>
                        <td>{{ $item->approved_at ? \Carbon\Carbon::parse($item->approved_at)->format('d M Y H:i') : '-' }}</td>
                        <td class="text-right">
                            <!-- Mengembalikan tombol outline-danger lengkap dengan teks Detail -->
                            <a href="{{ route('pengajuan.show', $item->id) }}" class="btn btn-sm btn-outline-danger px-3 btn-pill-outline">
                                <i class="fas fa-eye mr-1"></i>Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="{{ $isAdminView ? 7 : 6 }}" class="text-center text-muted py-4">Belum ada data pengajuan.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($isAdminView && method_exists($data, 'hasPages') && $data->hasPages())
        <div class="card-footer bg-white py-3">{{ $data->links() }}</div>
    @endif
</div>
@endsection