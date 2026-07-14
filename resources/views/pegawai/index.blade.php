@extends('layouts.app')
@section('title', 'Kelola Pegawai')

@section('content')
<div class="page-header">
    <h1 class="page-title">Kelola Pegawai</h1>
    <p class="page-subtitle">Tambah, ubah, dan hapus data pegawai beserta akun login.</p>
</div>

<div class="card">
    <div class="card-header table-toolbar">
        <div>
            <h3 class="card-title mb-0 font-weight-bold">Daftar Pegawai</h3>
            <p class="toolbar-subtitle mb-0">Data pegawai dan akun login yang terdaftar.</p>
        </div>
        <button type="button" class="btn btn-danger" data-modal-open="modal-tambah-pegawai">
            <i class="fas fa-plus mr-1"></i>Tambah Pegawai
        </button>
    </div>
    <div class="card-body p-0">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>NIP/NIK</th>
                    <th>Unit</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th class="text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
            @forelse($pegawais as $p)
                <tr>
                    <td><strong>{{ $p->nama }}</strong><br><span class="text-muted small">{{ $p->user->email ?? '-' }}</span></td>
                    <td><span class="badge badge-light">{{ $p->jenis_identitas }}</span><br>{{ $p->nomor_identitas }}</td>
                    <td>{{ $p->unitKerja->nama_unit ?? '-' }}</td>
                    <td><span class="badge badge-light">{{ ucfirst($p->user->role ?? '-') }}</span></td>
                    <td><span class="badge badge-{{ $p->status === 'aktif' ? 'success' : 'secondary' }}">{{ ucfirst($p->status) }}</span></td>
                    <td class="text-right">
                        <a href="{{ route('pegawai.edit', $p->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('pegawai.destroy', $p->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus pegawai ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center text-muted py-4">Belum ada data pegawai.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="form-modal" id="modal-tambah-pegawai" aria-hidden="true" data-modal-auto-open="{{ $errors->any() ? 'true' : 'false' }}">
    <div class="form-modal-backdrop" data-modal-close></div>
    <div class="form-modal-panel form-modal-panel-lg" role="dialog" aria-modal="true" aria-labelledby="judul-tambah-pegawai">
        <div class="form-modal-header">
            <div>
                <h3 id="judul-tambah-pegawai" class="form-modal-title">Tambah Pegawai</h3>
                <p class="form-modal-subtitle">Isi data pegawai dan akun login.</p>
            </div>
            <button type="button" class="btn btn-outline-secondary btn-sm" data-modal-close aria-label="Tutup form">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form action="{{ route('pegawai.store') }}" method="POST">
            @csrf
            <div class="form-modal-body">
                <div class="form-grid">
                    <div class="form-group">
                        <label>NIP</label>
                        <input type="text" name="nip" class="form-control" value="{{ old('nip') }}" placeholder="Isi jika pegawai memiliki NIP">
                    </div>
                    <div class="form-group">
                        <label>NIK</label>
                        <input type="text" name="nik" class="form-control" value="{{ old('nik') }}" placeholder="Isi jika pegawai tidak memiliki NIP">
                        <small class="text-muted">Minimal isi salah satu: NIP atau NIK.</small>
                    </div>
                    <div class="form-group">
                        <label>Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control" value="{{ old('nama') }}" required>
                    </div>
                    <div class="form-group">
                        <label>Jabatan</label>
                        <input type="text" name="jabatan" class="form-control" value="{{ old('jabatan') }}" required>
                    </div>
                    <div class="form-group">
                        <label>Unit Kerja</label>
                        <select name="unit_kerja_id" class="custom-select" required>
                            @foreach($unitKerja as $unit)
                                <option value="{{ $unit->id }}" @selected(old('unit_kerja_id') == $unit->id)>{{ $unit->nama_unit }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="custom-select">
                            <option value="L" @selected(old('jenis_kelamin') == 'L')>Laki-laki</option>
                            <option value="P" @selected(old('jenis_kelamin') == 'P')>Perempuan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="custom-select">
                            <option value="aktif" @selected(old('status', 'aktif') == 'aktif')>Aktif</option>
                            <option value="nonaktif" @selected(old('status') == 'nonaktif')>Nonaktif</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Email Login</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                    </div>
                    <div class="form-group">
                        <label>Role</label>
                        <select name="role" class="custom-select">
                            <option value="pegawai" @selected(old('role', 'pegawai') == 'pegawai')>Pegawai</option>
                            <option value="atasan" @selected(old('role') == 'atasan')>Atasan</option>
                            <option value="pimpinan" @selected(old('role') == 'pimpinan')>Pimpinan</option>
                            <option value="admin" @selected(old('role') == 'admin')>Admin</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Kosongkan untuk default: password">
                    </div>
                </div>
            </div>
            <div class="form-modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-modal-close>Batal</button>
                <button class="btn btn-danger"><i class="fas fa-check mr-1"></i>Simpan Pegawai</button>
            </div>
        </form>
    </div>
</div>
@endsection
