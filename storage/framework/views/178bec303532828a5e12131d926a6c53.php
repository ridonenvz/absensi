<?php $__env->startSection('title', 'Laporan'); ?>
<?php $__env->startSection('content'); ?>
<div class="page-header"><h1 class="page-title">Laporan</h1><p class="page-subtitle">Pilih jenis laporan yang ingin ditampilkan.</p></div>
<div class="action-grid">
    <a href="<?php echo e(route('laporan.absensi')); ?>" class="action-tile"><i class="fas fa-fingerprint mr-2 text-danger"></i>Rekap Absensi</a>
    <a href="<?php echo e(route('laporan.pegawai')); ?>" class="action-tile"><i class="fas fa-users mr-2 text-danger"></i>Rekap Pegawai</a>
    <a href="<?php echo e(route('laporan.pengajuan')); ?>" class="action-tile"><i class="fas fa-paper-plane mr-2 text-danger"></i>Rekap Pengajuan</a>
    <a href="<?php echo e(route('laporan.tukin')); ?>" class="action-tile"><i class="fas fa-money-bill-wave mr-2 text-danger"></i>Laporan Tukin</a>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->user()->role === 'admin'): ?>
        <a href="<?php echo e(route('tukin.index')); ?>" class="action-tile"><i class="fas fa-calculator mr-2 text-danger"></i>Hitung Tukin</a>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\absensirailwayupdate\resources\views/laporan/index.blade.php ENDPATH**/ ?>