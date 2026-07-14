@extends('layouts.app')
@section('title', 'Edit Pegawai')

@section('content')
<div class="page-header">
    <h1 class="page-title">Edit Pegawai</h1>
    <p class="page-subtitle">Perbarui data pegawai dan akun login.</p>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('pegawai.update', $pegawai->id) }}" method="POST">
            @csrf @method('PUT')
            <div class="row">
                <div class="col-md-4 form-group"><label>NIP</label><input type="text" name="nip" class="form-control" value="{{ old('nip', $pegawai->nip) }}" placeholder="Isi jika pegawai memiliki NIP"></div>
                <div class="col-md-4 form-group"><label>NIK</label><input type="text" name="nik" class="form-control" value="{{ old('nik', $pegawai->nik) }}" placeholder="Isi jika pegawai tidak memiliki NIP"><small class="text-muted">Minimal isi salah satu: NIP atau NIK.</small></div>
                <div class="col-md-4 form-group"><label>Nama</label><input type="text" name="nama" class="form-control" value="{{ old('nama', $pegawai->nama) }}" required></div>
                <div class="col-md-4 form-group"><label>Jabatan</label><input type="text" name="jabatan" class="form-control" value="{{ old('jabatan', $pegawai->jabatan) }}" required></div>
                <div class="col-md-4 form-group"><label>Unit Kerja</label><select name="unit_kerja_id" class="custom-select" required>@foreach($unitKerja as $unit)<option value="{{ $unit->id }}" {{ old('unit_kerja_id', $pegawai->unit_kerja_id) == $unit->id ? 'selected' : '' }}>{{ $unit->nama_unit }}</option>@endforeach</select></div>
                <div class="col-md-4 form-group"><label>Jenis Kelamin</label><select name="jenis_kelamin" class="custom-select"><option value="L" {{ $pegawai->jenis_kelamin === 'L' ? 'selected' : '' }}>Laki-laki</option><option value="P" {{ $pegawai->jenis_kelamin === 'P' ? 'selected' : '' }}>Perempuan</option></select></div>
                <div class="col-md-4 form-group"><label>Status</label><select name="status" class="custom-select"><option value="aktif" {{ $pegawai->status === 'aktif' ? 'selected' : '' }}>Aktif</option><option value="nonaktif" {{ $pegawai->status === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option></select></div>
                <div class="col-md-4 form-group"><label>Email Login</label><input type="email" name="email" class="form-control" value="{{ old('email', $pegawai->user->email ?? '') }}" required></div>
                <div class="col-md-4 form-group"><label>Role</label><select name="role" class="custom-select">@foreach(['pegawai','atasan','pimpinan','admin'] as $role)<option value="{{ $role }}" {{ old('role', $pegawai->user->role ?? 'pegawai') === $role ? 'selected' : '' }}>{{ ucfirst($role) }}</option>@endforeach</select></div>
                <div class="col-md-4 form-group"><label>Password Baru</label><input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak diubah"></div>
            </div>
            <div class="d-flex justify-content-between">
                <a href="{{ route('pegawai.index') }}" class="btn btn-outline-secondary">Kembali</a>
                <button class="btn btn-danger">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection
