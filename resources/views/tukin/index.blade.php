@extends('layouts.app')
@section('title', 'Tukin')
@section('content')
<div class="page-header">
    <h1 class="page-title">Perhitungan Tukin</h1>
    <p class="page-subtitle">Hitung potongan tukin berdasarkan keterlambatan dan kompensasi.</p>
</div>

<!-- FILTER BULAN & TAHUN -->
<div class="card mb-3">
    <div class="card-body">
        <form class="form-inline" method="GET" action="{{ route('tukin.index') }}">
            <label class="mr-2 font-weight-bold">Bulan</label>
            <input type="number" min="1" max="12" name="bulan" value="{{ $bulan }}" class="form-control mr-3">
            
            <label class="mr-2 font-weight-bold">Tahun</label>
            <input type="number" name="tahun" value="{{ $tahun }}" class="form-control mr-3">
            
            <!-- Tombol Filter Sesuai Gambar Contoh -->
            <button class="btn btn-danger btn-sm px-3 btn-rounded-8 btn-filter-inline">
                <i class="fas fa-filter mr-1"></i>Filter
            </button>
        </form>
    </div>
</div>

<!-- TABEL DATA PERHITUNGAN -->
<div class="card">
    <div class="card-body p-0">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>Pegawai</th>
                    <th>NIP/NIK</th>
                    <th>Telat</th>
                    <th>Kompensasi</th>
                    <th>Potongan</th>
                    <th class="text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $item)
                    @php($row = $potongan[$item->id] ?? null)
                    <tr>
                        <td>
                            <strong>{{ $item->nama }}</strong><br>
                            <span class="text-muted small">{{ $item->unitKerja->nama_unit ?? '-' }}</span>
                        </td>
                        <td>
                            <span class="badge badge-light mb-1">{{ $item->jenis_identitas }}</span><br>
                            {{ $item->nomor_identitas }}
                        </td>
                        <td>{{ $row->total_telat ?? 0 }} menit</td>
                        <td>{{ $row->total_kompensasi ?? 0 }} menit</td>
                        
                        <!-- WARNA POTONGAN KEMBALI NORMAL (POLOS) -->
                        <td>Rp {{ number_format($row->potongan ?? 0,0,',','.') }}</td>
                        
                        <td class="text-right">
                            <form method="POST" action="{{ route('tukin.hitung',$item->id) }}">
                                @csrf
                                <input type="hidden" name="bulan" value="{{ $bulan }}">
                                <input type="hidden" name="tahun" value="{{ $tahun }}">
                                <!-- Tombol Hitung Diseragamkan Kelengkungan & Ukurannya -->
                                <button class="btn btn-danger btn-sm px-3 btn-rounded-8">
                                    <i class="fas fa-calculator mr-1"></i>Hitung
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">Belum ada data pegawai.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection