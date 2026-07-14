<?php $__env->startSection('title', 'Dashboard Atasan'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <h1 class="page-title">Dashboard Atasan</h1>
    <p class="page-subtitle">Kelola persetujuan izin dan cuti pegawai.</p>
</div>

<div class="row">
    <div class="col-md-4 mb-3"><div class="stat-card"><span class="stat-icon"><i class="fas fa-hourglass-half"></i></span><div class="stat-value"><?php echo e($pengajuan_pending); ?></div><p class="stat-label">Menunggu Persetujuan</p></div></div>
    <div class="col-md-4 mb-3"><div class="stat-card"><span class="stat-icon"><i class="fas fa-check"></i></span><div class="stat-value"><?php echo e($pengajuan_disetujui); ?></div><p class="stat-label">Disetujui</p></div></div>
    <div class="col-md-4 mb-3"><div class="stat-card"><span class="stat-icon"><i class="fas fa-xmark"></i></span><div class="stat-value"><?php echo e($pengajuan_ditolak); ?></div><p class="stat-label">Ditolak</p></div></div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title mb-0 font-weight-bold">Pengajuan Terbaru</h3>
        <a href="<?php echo e(route('pengajuan.approval')); ?>" class="btn btn-danger btn-sm">Buka Approval</a>
    </div>
    <div class="card-body p-0">
        <table class="table mb-0">
            <thead><tr><th>Pegawai</th><th>Jenis</th><th>Periode</th><th>Status</th></tr></thead>
            <tbody>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $pengajuanTerbaru; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr><td><?php echo e($item->pegawai->nama ?? '-'); ?></td><td><?php echo e(ucwords(str_replace('_',' ', $item->jenis))); ?></td><td><?php echo e($item->tanggal_mulai); ?> - <?php echo e($item->tanggal_selesai); ?></td><td><span class="badge badge-light"><?php echo e(ucfirst($item->status)); ?></span></td></tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="4" class="text-center text-muted py-4">Belum ada pengajuan.</td></tr>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\absensirailwayupdate\resources\views/dashboard/atasan.blade.php ENDPATH**/ ?>