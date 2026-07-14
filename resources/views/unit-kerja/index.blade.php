@extends('layouts.app')
@section('title', 'Unit Kerja')

@section('content')
<div class="page-header">
    <h1 class="page-title">Unit Kerja</h1>
    <p class="page-subtitle">Kelola daftar unit kerja pegawai.</p>
</div>

<div class="card">
    <div class="card-header table-toolbar">
        <div>
            <h3 class="card-title mb-0 font-weight-bold">Daftar Unit</h3>
            <p class="toolbar-subtitle mb-0">Data unit kerja yang tersedia.</p>
        </div>
        <button type="button" class="btn btn-danger" data-modal-open="modal-tambah-unit">
            <i class="fas fa-plus mr-1"></i>Tambah Unit
        </button>
    </div>
    <div class="card-body p-0">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>Nama Unit</th>
                    <th>Pegawai</th>
                    <th class="text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
            @forelse($unitKerja as $unit)
                <tr>
                    <td>{{ $unit->nama_unit }}</td>
                    <td>{{ $unit->pegawai_count }}</td>
                    <td class="text-right">
                        <a class="btn btn-warning btn-sm" href="{{ route('unit-kerja.edit',$unit->id) }}"><i class="fas fa-edit"></i></a>
                        <form class="d-inline" method="POST" action="{{ route('unit-kerja.destroy',$unit->id) }}" onsubmit="return confirm('Hapus unit kerja ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="3" class="text-center text-muted py-4">Belum ada unit kerja.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="form-modal" id="modal-tambah-unit" aria-hidden="true" data-modal-auto-open="{{ $errors->any() ? 'true' : 'false' }}">
    <div class="form-modal-backdrop" data-modal-close></div>
    <div class="form-modal-panel" role="dialog" aria-modal="true" aria-labelledby="judul-tambah-unit">
        <div class="form-modal-header">
            <div>
                <h3 id="judul-tambah-unit" class="form-modal-title">Tambah Unit</h3>
                <p class="form-modal-subtitle">Masukkan nama unit kerja baru.</p>
            </div>
            <button type="button" class="btn btn-outline-secondary btn-sm" data-modal-close aria-label="Tutup form">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form method="POST" action="{{ route('unit-kerja.store') }}">
            @csrf
            <div class="form-modal-body">
                <div class="form-group mb-0">
                    <label>Nama Unit</label>
                    <input name="nama_unit" class="form-control" value="{{ old('nama_unit') }}" required>
                </div>
            </div>
            <div class="form-modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-modal-close>Batal</button>
                <button class="btn btn-danger"><i class="fas fa-check mr-1"></i>Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection
