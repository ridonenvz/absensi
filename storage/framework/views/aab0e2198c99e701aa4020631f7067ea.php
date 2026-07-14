<?php $__env->startSection('title', 'Rekap Pengajuan'); ?>
<?php $__env->startSection('content'); ?>
<div class="page-header"><h1 class="page-title">Rekap Pengajuan</h1><p class="page-subtitle">Rekap pengajuan izin dan cuti pegawai per bulan.</p></div>

<div class="row">
    <div class="col-md-4 mb-3">
        <div class="stat-card"><span class="stat-icon"><i class="fas fa-hourglass-half text-warning"></i></span><div class="stat-value"><?php echo e($rekap['pending']); ?></div><p class="stat-label">Pending</p></div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="stat-card"><span class="stat-icon"><i class="fas fa-check text-success"></i></span><div class="stat-value"><?php echo e($rekap['approved']); ?></div><p class="stat-label">Approved</p></div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="stat-card"><span class="stat-icon"><i class="fas fa-times text-danger"></i></span><div class="stat-value"><?php echo e($rekap['rejected']); ?></div><p class="stat-label">Rejected</p></div>
    </div>
</div>

<div class="card mb-3">
    <div class="card-body">
        <form class="form-inline" method="GET" action="<?php echo e(route('laporan.pengajuan')); ?>">
            <label class="mr-2">Bulan</label>
            <input type="number" min="1" max="12" name="bulan" value="<?php echo e($bulan); ?>" class="form-control mr-2">
            <label class="mr-2">Tahun</label>
            <input type="number" name="tahun" value="<?php echo e($tahun); ?>" class="form-control mr-2">
            <label class="mr-2">Status</label>
            <select name="status" class="form-control mr-2">
                <option value="">Semua Status</option>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = ['pending','approved','rejected']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($s); ?>" <?php echo e($status === $s ? 'selected' : ''); ?>><?php echo e(ucfirst($s)); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </select>
            <button class="btn btn-danger mr-2">Tampilkan</button>
            <a href="<?php echo e(route('laporan.pengajuan.excel', ['bulan'=>$bulan,'tahun'=>$tahun,'status'=>$status])); ?>" class="btn btn-outline-danger"><i class="fas fa-file-excel mr-1"></i>Excel</a>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table mb-0">
            <thead><tr><th>Pegawai</th><th>Jenis</th><th>Periode</th><th>Status</th><th>Catatan</th></tr></thead>
            <tbody>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($item->pegawai->nama ?? '-'); ?></td>
                    <td><?php echo e(ucwords(str_replace('_',' ', $item->jenis))); ?></td>
                    <td><?php echo e($item->tanggal_mulai); ?> s.d. <?php echo e($item->tanggal_selesai); ?></td>
                    <td><span class="badge badge-<?php echo e($item->status === 'approved' ? 'success' : ($item->status === 'rejected' ? 'danger' : 'warning')); ?>"><?php echo e(ucfirst($item->status)); ?></span></td>
                    <td><?php echo e(\Illuminate\Support\Str::limit($item->catatan ?: '-', 50)); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="5" class="text-center text-muted py-4">Data tidak ditemukan.</td></tr>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\absensirailwayupdate\resources\views/laporan/pengajuan.blade.php ENDPATH**/ ?>