@extends('layouts.app')
@section('title', 'Edit Unit Kerja')
@section('content')
<div class="page-header"><h1 class="page-title">Edit Unit Kerja</h1><p class="page-subtitle">Perbarui nama unit kerja.</p></div>
<div class="card"><div class="card-body"><form method="POST" action="{{ route('unit-kerja.update',$unitKerja->id) }}">@csrf @method('PUT')<div class="form-group"><label>Nama Unit</label><input name="nama_unit" class="form-control" value="{{ old('nama_unit',$unitKerja->nama_unit) }}" required></div><div class="d-flex justify-content-between"><a href="{{ route('unit-kerja.index') }}" class="btn btn-outline-secondary">Kembali</a><button class="btn btn-danger">Simpan</button></div></form></div></div>
@endsection
