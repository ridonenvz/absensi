<?php $__env->startSection('title', 'Dashboard Pegawai'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <h1 class="page-title">Dashboard Pegawai</h1>
    <p class="page-subtitle">Pantau absensi hari ini dan status pengajuan terbaru.</p>
</div>

<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$pegawai): ?>
    <div class="empty-state">Akun Anda belum terhubung dengan data pegawai. Hubungi admin agar absensi dan pengajuan dapat digunakan.</div>
<?php else: ?>
<div class="row">
    <div class="col-lg-4 mb-3">
        <div class="stat-card">
            <span class="stat-icon"><i class="fas fa-fingerprint"></i></span>
            <div class="stat-value"><?php echo e($absenHariIni ? ucfirst($absenHariIni->status) : 'Belum'); ?></div>
            <p class="stat-label">Status Absensi Hari Ini</p>
            <a href="<?php echo e(route('absensi.index')); ?>" class="btn btn-danger btn-block mt-3">Buka Absensi</a>
        </div>
    </div>
    <div class="col-lg-8 mb-3">
        <div class="card h-100">
            <div class="card-header"><h3 class="card-title mb-0 font-weight-bold">Profil Singkat</h3></div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6"><span class="text-muted">Nama</span><h5><?php echo e($pegawai->nama); ?></h5></div>
                    <div class="col-md-6"><span class="text-muted"><?php echo e($pegawai->jenis_identitas); ?></span><h5><?php echo e($pegawai->nomor_identitas); ?></h5></div>
                    <div class="col-md-6"><span class="text-muted">Jabatan</span><h5><?php echo e($pegawai->jabatan); ?></h5></div>
                    <div class="col-md-6"><span class="text-muted">Unit Kerja</span><h5><?php echo e($pegawai->unitKerja->nama_unit ?? '-'); ?></h5></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-6 mb-3">
        <div class="card h-100">
            <div class="card-header"><h3 class="card-title mb-0 font-weight-bold">Riwayat Absensi</h3></div>
            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead><tr><th>Tanggal</th><th>Masuk</th><th>Pulang</th><th>Status</th></tr></thead>
                    <tbody>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $riwayat; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr><td><?php echo e(\Carbon\Carbon::parse($r->tanggal)->format('d M Y')); ?></td><td><?php echo e($r->jam_masuk ?? '-'); ?></td><td><?php echo e($r->jam_pulang ?? '-'); ?></td><td><span class="badge badge-light"><?php echo e(ucfirst($r->status)); ?></span></td></tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr><td colspan="4" class="text-center text-muted py-4">Belum ada riwayat absensi.</td></tr>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-6 mb-3">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center"><h3 class="card-title mb-0 font-weight-bold">Pengajuan Terbaru</h3><a href="<?php echo e(route('pengajuan.create')); ?>" class="btn btn-sm btn-danger">Buat</a></div>
            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead><tr><th>Jenis</th><th>Periode</th><th>Status</th></tr></thead>
                    <tbody>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $pengajuan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr><td><?php echo e(ucwords(str_replace('_',' ', $p->jenis))); ?></td><td><?php echo e($p->tanggal_mulai); ?> - <?php echo e($p->tanggal_selesai); ?></td><td><span class="badge badge-<?php echo e($p->status === 'approved' ? 'success' : ($p->status === 'rejected' ? 'danger' : 'warning')); ?>"><?php echo e(ucfirst($p->status)); ?></span></td></tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr><td colspan="3" class="text-center text-muted py-4">Belum ada pengajuan.</td></tr>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\absensirailwayupdate\resources\views/dashboard/pegawai.blade.php ENDPATH**/ ?>