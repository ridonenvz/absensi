<?php $__env->startSection('title', 'Rekap Pegawai'); ?>
<?php $__env->startSection('content'); ?>
<div class="page-header"><h1 class="page-title">Rekap Pegawai</h1><p class="page-subtitle">Rekap kehadiran dan pengajuan per pegawai dalam satu bulan.</p></div>
<div class="card mb-3">
    <div class="card-body">
        <form class="form-inline" method="GET" action="<?php echo e(route('laporan.pegawai')); ?>">
            <label class="mr-2">Bulan</label>
            <input type="number" min="1" max="12" name="bulan" value="<?php echo e($bulan); ?>" class="form-control mr-2">
            <label class="mr-2">Tahun</label>
            <input type="number" name="tahun" value="<?php echo e($tahun); ?>" class="form-control mr-2">
            <button class="btn btn-danger mr-2">Tampilkan</button>
            <a href="<?php echo e(route('laporan.pegawai.excel', ['bulan'=>$bulan,'tahun'=>$tahun])); ?>" class="btn btn-outline-danger"><i class="fas fa-file-excel mr-1"></i>Excel</a>
        </form>
    </div>
</div>
<div class="card">
    <div class="card-body p-0">
        <table class="table mb-0">
            <thead><tr><th>Nama</th><th>Jabatan</th><th>Unit Kerja</th><th>Hadir</th><th>Terlambat</th><th>Izin</th><th>Cuti</th><th>Pengajuan</th></tr></thead>
            <tbody>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($p->nama); ?></td>
                    <td><?php echo e($p->jabatan); ?></td>
                    <td><?php echo e($p->unitKerja->nama_unit ?? '-'); ?></td>
                    <td><?php echo e($p->hadir_count); ?></td>
                    <td><?php echo e($p->terlambat_count); ?></td>
                    <td><?php echo e($p->izin_count); ?></td>
                    <td><?php echo e($p->cuti_count); ?></td>
                    <td><?php echo e($p->pengajuan_count); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="8" class="text-center text-muted py-4">Data tidak ditemukan.</td></tr>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\absensirailwayupdate\resources\views/laporan/pegawai.blade.php ENDPATH**/ ?>