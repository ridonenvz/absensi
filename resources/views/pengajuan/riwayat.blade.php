@extends('layouts.app')
@section('title', 'Riwayat Approval')

@section('content')
<div class="page-header">
    <h1 class="page-title">Riwayat Approval</h1>
    <p class="page-subtitle">Daftar pengajuan yang sudah diproses (disetujui/ditolak).</p>
</div>

<div class="card mb-3">
    <div class="card-body py-3">
        <form class="d-flex align-items-center flex-wrap" method="GET" action="{{ route('pengajuan.approval.riwayat') }}">
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
                    <option value="approved" {{ ($filters['status'] ?? '') === 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="rejected" {{ ($filters['status'] ?? '') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
            </div>

            <div class="filter-field">
                <label class="mb-0 filter-field-label">Dari</label>
                <input type="date" name="dari" value="{{ $filters['dari'] ?? '' }}" class="form-control form-control-sm form-control-pill">
            </div>
            
            <div class="filter-field">
                <label class="mb-0 filter-field-label">Sampai</label>
                <input type="date" name="sampai" value="{{ $filters['sampai'] ?? '' }}" class="form-control form-control-sm form-control-pill">
            </div>

            <button class="btn btn-danger btn-sm px-3 btn-rounded-8 btn-filter-inline"><i class="fas fa-filter mr-1"></i>Filter</button>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header table-toolbar">
        <div>
            <h3 class="card-title mb-0 font-weight-bold">Data Riwayat</h3>
            <p class="toolbar-subtitle mb-0">Daftar permohonan berkas yang telah Anda proses selesai.</p>
        </div>
        <a href="{{ route('pengajuan.approval') }}" class="btn btn-outline-secondary px-3 d-inline-flex align-items-center btn-action-38 btn-rounded-8">
            <i class="fas fa-arrow-left mr-2"></i>Kembali ke Approval
        </a>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead><tr><th>Pegawai</th><th>Jenis</th><th>Periode</th><th>Status</th><th>Diproses Oleh</th><th>Catatan</th><th>Tanggal Proses</th><th class="text-right">Aksi</th></tr></thead>
                <tbody>
                @forelse($data as $item)
                    <tr>
                        <td class="cell-strong">{{ $item->pegawai->nama ?? '-' }}</td>
                        <td>{{ ucwords(str_replace('_',' ', $item->jenis)) }}</td>
                        <td>{{ $item->tanggal_mulai }} s.d. {{ $item->tanggal_selesai }}</td>
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
                        <td>{{ $item->approver->name ?? '-' }}</td>
                        <td>{{ \Illuminate\Support\Str::limit($item->catatan ?: '-', 40) }}</td>
                        <td>{{ $item->approved_at ? \Carbon\Carbon::parse($item->approved_at)->format('d M Y H:i') : '-' }}</td>
                        <td class="text-right">
                            <!-- Mengembalikan teks Detail -->
                            <a href="{{ route('pengajuan.show', $item->id) }}" class="btn btn-outline-secondary btn-sm px-3 btn-rounded-8">
                                <i class="fas fa-eye mr-1"></i>Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="text-center text-muted py-4">Belum ada riwayat approval.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if(method_exists($data, 'hasPages') && $data->hasPages())
        <div class="card-footer bg-white py-3">{{ $data->links() }}</div>
    @endif
</div>
@endsection