@extends('layouts.app')

@section('title', 'Data User')

@section('content')
<!-- HEADER UTAMA: Sudah selaras dengan struktur Unit Kerja -->
<div class="page-header">
    <h1 class="page-title">Data User</h1>
    <p class="page-subtitle">Daftar akun pengguna aplikasi absensi.</p>
</div>

<div class="card">
    <div class="card-header table-toolbar">
        <div>
            <h3 class="card-title mb-0 font-weight-bold">Daftar Akun</h3>
            <p class="toolbar-subtitle mb-0">Data user yang terdaftar dalam sistem.</p>
        </div>
    </div>

    <div class="card-body p-0">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Pegawai</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <span class="badge badge-brand badge-pill-sm">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td>{{ $user->pegawai->nama ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-4">Belum ada data user.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection