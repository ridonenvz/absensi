@extends('layouts.app')
@section('title', 'Buat Pengajuan')

@section('content')
<div class="page-header">
    <h1 class="page-title">Buat Pengajuan</h1>
    <p class="page-subtitle">Ajukan izin atau cuti kepada atasan.</p>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title mb-0 font-weight-bold">Formulir Pengajuan</h3>
    </div>
    
    <div class="card-body">
        <form method="POST" action="{{ route('pengajuan.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="row mb-4">
                <div class="col-md-4 mb-3 mb-md-0">
                    <div class="form-group mb-0">
                        <label class="font-weight-bold small text-uppercase text-muted">Jenis Pengajuan</label>
                        <select name="jenis" class="form-control form-control-tall" required>
                            <option value="izin">Izin</option>
                            <option value="cuti_tahunan">Cuti Tahunan</option>
                            <option value="cuti_sakit">Cuti Sakit</option>
                            <option value="cuti_melahirkan">Cuti Melahirkan</option>
                            <option value="cuti_penting">Cuti Penting</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4 mb-3 mb-md-0">
                    <div class="form-group mb-0">
                        <label class="font-weight-bold small text-uppercase text-muted">Tanggal Mulai</label>
                        <input type="date" name="tanggal_mulai" class="form-control form-control-tall" value="{{ old('tanggal_mulai') }}" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group mb-0">
                        <label class="font-weight-bold small text-uppercase text-muted">Tanggal Selesai</label>
                        <input type="date" name="tanggal_selesai" class="form-control form-control-tall" value="{{ old('tanggal_selesai') }}" required>
                    </div>
                </div>
            </div>
            
            <div class="form-group mb-4">
                <label class="font-weight-bold small text-uppercase text-muted">Alasan</label>
                <textarea name="alasan" class="form-control form-control-pill" rows="4" placeholder="Tulis alasan pengajuan secara singkat dan jelas" required>{{ old('alasan') }}</textarea>
            </div>
            
            <div class="form-group mb-4">
                <label class="font-weight-bold small text-uppercase text-muted mb-2">Lampiran <span class="text-lowercase font-weight-normal text-muted">(opsional, maksimal 2 MB)</span></label>
                <input type="file" name="lampiran" class="form-control-file">
            </div>
            
            <hr class="my-4 divider-soft">

            <div class="d-flex">
                <button class="btn btn-danger px-4 mr-2 btn-action-42">
                    <i class="fas fa-paper-plane mr-2"></i>Kirim Pengajuan
                </button>
                <a href="{{ route('pengajuan.index') }}" class="btn btn-outline-secondary px-4 d-inline-flex align-items-center justify-content-center btn-action-42">
                    Kembali
                </a>
            </div>
        </form>
    </div>
</div>
@endsection