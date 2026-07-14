<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\TukinController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\UnitKerjaController;
use App\Http\Controllers\JamKerjaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PengaturanController;

Route::get('/', function () {
    return auth()->check() ? redirect('/dashboard') : redirect('/login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.process');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware([
    'auth',
    config('jetstream.auth_session'),
])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Alias lama agar tombol/redirect lama tetap aman.
    Route::redirect('/admin/dashboard', '/dashboard');
    Route::redirect('/pegawai/dashboard', '/dashboard');
    Route::redirect('/atasan/dashboard', '/dashboard');
    Route::redirect('/pimpinan/dashboard', '/dashboard');

    // Absensi: pegawai absen mandiri, atasan/pimpinan/admin memantau kehadiran harian.
    Route::get('/absensi', [AbsensiController::class, 'index'])->name('absensi.index');
    Route::post('/absensi/masuk', [AbsensiController::class, 'masuk'])->name('absensi.masuk');
    Route::post('/absensi/pulang', [AbsensiController::class, 'pulang'])->name('absensi.pulang');

    // Pengajuan: pegawai mengajukan izin/cuti, admin melihat rekap seluruh pengajuan.
    Route::get('/pengajuan', [PengajuanController::class, 'index'])->name('pengajuan.index');
    Route::get('/pengajuan/create', [PengajuanController::class, 'create'])->name('pengajuan.create');
    Route::post('/pengajuan/store', [PengajuanController::class, 'store'])->name('pengajuan.store');

    Route::middleware(['atasan'])->group(function () {
        Route::get('/pengajuan/approval', [ApprovalController::class, 'index'])->name('pengajuan.approval');
        Route::get('/pengajuan/approval/riwayat', [ApprovalController::class, 'riwayat'])->name('pengajuan.approval.riwayat');
        Route::post('/pengajuan/approve/{id}', [ApprovalController::class, 'approve'])->name('pengajuan.approve');
        Route::post('/pengajuan/reject/{id}', [ApprovalController::class, 'reject'])->name('pengajuan.reject');
    });

    // Wildcard didaftarkan PALING TERAKHIR agar tidak menangkap /pengajuan/approval dst.
    Route::get('/pengajuan/{pengajuan}', [PengajuanController::class, 'show'])->name('pengajuan.show');

    // Laporan: bisa diakses Admin maupun Pimpinan.
    Route::middleware(['role:admin,pimpinan'])->group(function () {
        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
        Route::get('/laporan/absensi', [LaporanController::class, 'absensi'])->name('laporan.absensi');
        Route::get('/laporan/absensi/pdf', [LaporanController::class, 'exportAbsensiPDF'])->name('laporan.absensi.pdf');
        Route::get('/laporan/absensi/excel', [LaporanController::class, 'exportAbsensiExcel'])->name('laporan.absensi.excel');
        Route::get('/laporan/pegawai', [LaporanController::class, 'pegawai'])->name('laporan.pegawai');
        Route::get('/laporan/pegawai/excel', [LaporanController::class, 'exportPegawaiExcel'])->name('laporan.pegawai.excel');
        Route::get('/laporan/pengajuan', [LaporanController::class, 'pengajuan'])->name('laporan.pengajuan');
        Route::get('/laporan/pengajuan/excel', [LaporanController::class, 'exportPengajuanExcel'])->name('laporan.pengajuan.excel');
        Route::get('/laporan/tukin', [LaporanController::class, 'tukin'])->name('laporan.tukin');
    });

    Route::middleware(['admin'])->group(function () {

        Route::get('/pengaturan', [PengaturanController::class, 'index'])->name('pengaturan.index');

        Route::get('/user', [UserController::class, 'index'])->name('user.index');
        Route::get('/pegawai', [PegawaiController::class, 'index'])->name('pegawai.index');
        Route::post('/pegawai', [PegawaiController::class, 'store'])->name('pegawai.store');
        Route::get('/pegawai/{pegawai}/edit', [PegawaiController::class, 'edit'])->name('pegawai.edit');
        Route::put('/pegawai/{pegawai}', [PegawaiController::class, 'update'])->name('pegawai.update');
        Route::delete('/pegawai/{pegawai}', [PegawaiController::class, 'destroy'])->name('pegawai.destroy');

        Route::get('/unit-kerja', [UnitKerjaController::class, 'index'])->name('unit-kerja.index');
        Route::post('/unit-kerja', [UnitKerjaController::class, 'store'])->name('unit-kerja.store');
        Route::get('/unit-kerja/{unitKerja}/edit', [UnitKerjaController::class, 'edit'])->name('unit-kerja.edit');
        Route::put('/unit-kerja/{unitKerja}', [UnitKerjaController::class, 'update'])->name('unit-kerja.update');
        Route::delete('/unit-kerja/{unitKerja}', [UnitKerjaController::class, 'destroy'])->name('unit-kerja.destroy');

        Route::get('/jam-kerja', [JamKerjaController::class, 'index'])->name('jam-kerja.index');
        Route::post('/jam-kerja', [JamKerjaController::class, 'store'])->name('jam-kerja.store');
        Route::get('/jam-kerja/{jamKerja}/edit', [JamKerjaController::class, 'edit'])->name('jam-kerja.edit');
        Route::put('/jam-kerja/{jamKerja}', [JamKerjaController::class, 'update'])->name('jam-kerja.update');
        Route::delete('/jam-kerja/{jamKerja}', [JamKerjaController::class, 'destroy'])->name('jam-kerja.destroy');

        Route::get('/tukin', [TukinController::class, 'index'])->name('tukin.index');
        Route::post('/tukin/hitung/{pegawai}', [TukinController::class, 'hitung'])->name('tukin.hitung');
    });
});
