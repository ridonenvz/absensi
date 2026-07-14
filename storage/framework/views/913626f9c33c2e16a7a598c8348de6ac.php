<?php $__env->startSection('title', 'Dashboard Admin'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <h1 class="page-title">Dashboard Admin</h1>
    <p class="page-subtitle">Ringkasan absensi, pegawai, dan pengajuan yang perlu dipantau.</p>
</div>

<div class="row">
    <div class="col-md-3 mb-3">
        <div class="stat-card">
            <span class="stat-icon"><i class="fas fa-users"></i></span>
            <div class="stat-value"><?php echo e($pegawai); ?></div>
            <p class="stat-label">Total Pegawai</p>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="stat-card">
            <span class="stat-icon"><i class="fas fa-check"></i></span>
            <div class="stat-value"><?php echo e($hadir); ?></div>
            <p class="stat-label">Hadir Hari Ini</p>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="stat-card">
            <span class="stat-icon"><i class="fas fa-clock"></i></span>
            <div class="stat-value"><?php echo e($telat); ?></div>
            <p class="stat-label">Terlambat Hari Ini</p>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="stat-card">
            <span class="stat-icon"><i class="fas fa-inbox"></i></span>
            <div class="stat-value"><?php echo e($pengajuan); ?></div>
            <p class="stat-label">Pengajuan Pending</p>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12 mb-3">
        <div class="card h-100">
            <div class="card-header">
                <h3 class="card-title mb-0 font-weight-bold">Absensi Terbaru</h3>
            </div>

            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Pegawai</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $absensiTerbaru; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e($row->pegawai->nama ?? '-'); ?></td>
                            <td><?php echo e(\Carbon\Carbon::parse($row->tanggal)->format('d M Y')); ?></td>
                            <td>
                                <span class="badge badge-<?php echo e($row->status === 'terlambat' ? 'warning' : 'success'); ?>">
                                    <?php echo e(ucfirst($row->status)); ?>

                                </span>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="3" class="text-center text-muted py-4">
                                Belum ada data absensi.
                            </td>
                        </tr>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="action-grid mt-2">
    <a class="action-tile" href="<?php echo e(route('pegawai.index')); ?>">
        <i class="fas fa-users mr-2 text-danger"></i>Kelola Pegawai
    </a>

    <a class="action-tile" href="<?php echo e(route('unit-kerja.index')); ?>">
        <i class="fas fa-building mr-2 text-danger"></i>Kelola Unit Kerja
    </a>

    <a class="action-tile" href="<?php echo e(route('jam-kerja.index')); ?>">
        <i class="fas fa-calendar-days mr-2 text-danger"></i>Atur Jam Kerja
    </a>

    <a class="action-tile" href="<?php echo e(route('laporan.index')); ?>">
        <i class="fas fa-file-lines mr-2 text-danger"></i>Buka Laporan
    </a>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\absensirailwayupdate\resources\views/dashboard/admin.blade.php ENDPATH**/ ?>