@php
    $role = auth()->user()->role ?? null;
    $active = fn($pattern) => request()->is($pattern) ? 'active' : '';
@endphp

<aside class="main-sidebar sidebar-dark-primary elevation-4">

    <div class="sidebar pt-3">
        <div class="user-panel d-flex align-items-center pb-3 mb-3">
                <img src="https://upload.wikimedia.org/wikipedia/commons/6/62/Logo_Bawaslu.png" alt="Logo Bawaslu" class="brand-logo-img">
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ $active('dashboard') }}">
                        <i class="nav-icon fas fa-gauge-high"></i><p>Dashboard</p>
                    </a>
                </li>

                @if($role === 'admin')
                    <li class="nav-item">
                        <a href="{{ route('pegawai.index') }}" class="nav-link {{ $active('pegawai*') }}">
                            <i class="nav-icon fas fa-users"></i><p>Data Pegawai</p>
                        </a>
                    </li>
                @endif

                @if(in_array($role, ['pegawai', 'atasan', 'pimpinan', 'admin']))
                    <li class="nav-item">
                        <a href="{{ route('absensi.index') }}" class="nav-link {{ $active('absensi*') }}">
                            <i class="nav-icon fas fa-fingerprint"></i><p>Absensi</p>
                        </a>
                    </li>
                @endif

                @if(in_array($role, ['pegawai', 'atasan', 'pimpinan']))
                    <li class="nav-item">
                        <a href="{{ route('pengajuan.index') }}" class="nav-link {{ ($active('pengajuan') || request()->is('pengajuan/create')) ? 'active' : '' }}">
                            <i class="nav-icon fas fa-paper-plane"></i><p>Pengajuan Saya</p>
                        </a>
                    </li>
                @endif

                @if($role === 'admin')
                    <li class="nav-item">
                        <a href="{{ route('pengajuan.index') }}" class="nav-link {{ ($active('pengajuan') || request()->is('pengajuan/create')) ? 'active' : '' }}">
                            <i class="nav-icon fas fa-paper-plane"></i><p>Pengajuan</p>
                        </a>
                    </li>
                @endif

                @if($role === 'atasan')
                    <li class="nav-item">
                        <a href="{{ route('pengajuan.approval') }}" class="nav-link {{ request()->is('pengajuan/approval*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-clipboard-check"></i><p>Approval</p>
                        </a>
                    </li>
                @endif

                @if(in_array($role, ['admin', 'pimpinan']))
                    <li class="nav-item">
                        <a href="{{ route('laporan.index') }}" class="nav-link {{ $active('laporan*') }}">
                            <i class="nav-icon fas fa-file-lines"></i><p>Laporan</p>
                        </a>
                    </li>
                @endif

                @if($role === 'admin')
                    <li class="nav-header">Pengaturan</li>
                    <li class="nav-item">
                        <a href="{{ route('unit-kerja.index') }}" class="nav-link {{ $active('unit-kerja*') }}">
                            <i class="nav-icon fas fa-building"></i><p>Unit Kerja</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('jam-kerja.index') }}" class="nav-link {{ $active('jam-kerja*') }}">
                            <i class="nav-icon fas fa-calendar-days"></i><p>Jam Kerja</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('user.index') }}" class="nav-link {{ $active('user*') }}">
                            <i class="nav-icon fas fa-users"></i><p>Akun Pengguna</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('tukin.index') }}" class="nav-link {{ $active('tukin*') }}">
                            <i class="nav-icon fas fa-money-bill-wave"></i><p>Tunjangan Kinerja</p>
                        </a>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
</aside>
