<?php $__env->startSection('title', 'Absensi'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <h1 class="page-title">Absensi Pegawai</h1>
    <p class="page-subtitle">Data kehadiran harian seluruh pegawai.</p>
</div>

<div class="row">
    <div class="col-md-3 col-sm-6 mb-3">
        <div class="stat-card">
            <span class="stat-icon"><i class="fas fa-check text-success"></i></span>
            <div class="stat-value"><?php echo e($rekapHariIni['hadir']); ?></div>
            <p class="stat-label">Hadir / WFH</p>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 mb-3">
        <div class="stat-card">
            <span class="stat-icon"><i class="fas fa-clock text-warning"></i></span>
            <div class="stat-value"><?php echo e($rekapHariIni['terlambat']); ?></div>
            <p class="stat-label">Terlambat</p>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 mb-3">
        <div class="stat-card">
            <span class="stat-icon"><i class="fas fa-file-lines text-info"></i></span>
            <div class="stat-value"><?php echo e($rekapHariIni['izin']); ?></div>
            <p class="stat-label">Izin</p>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 mb-3">
        <div class="stat-card">
            <span class="stat-icon"><i class="fas fa-umbrella-beach text-danger"></i></span>
            <div class="stat-value"><?php echo e($rekapHariIni['cuti']); ?></div>
            <p class="stat-label">Cuti</p>
        </div>
    </div>
</div>

<div class="card mb-3">
    <div class="card-body">
        <form class="form-inline" method="GET" action="<?php echo e(route('absensi.index')); ?>">
            <label class="mr-2">Tanggal</label>
            <input type="date" name="tanggal" value="<?php echo e($tanggal); ?>" class="form-control mr-2">

            <label class="mr-2">Unit Kerja</label>
            <select name="unit_kerja_id" class="form-control mr-2">
                <option value="">Semua Unit</option>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $unitKerjaList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($unit->id); ?>" <?php echo e((string) $unitKerjaId === (string) $unit->id ? 'selected' : ''); ?>><?php echo e($unit->nama_unit); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </select>

            <label class="mr-2">Status</label>
            <select name="status" class="form-control mr-2">
                <option value="">Semua Status</option>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = ['hadir','terlambat','izin','cuti','wfh']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($s); ?>" <?php echo e($status === $s ? 'selected' : ''); ?>><?php echo e(ucfirst($s)); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </select>

            <button class="btn btn-danger"><i class="fas fa-filter mr-1"></i>Tampilkan</button>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header"><h3 class="card-title mb-0 font-weight-bold">Kehadiran Tanggal <?php echo e(\Carbon\Carbon::parse($tanggal)->format('d M Y')); ?></h3></div>
    <div class="card-body p-0">
        <table class="table mb-0">
            <thead><tr><th>Pegawai</th><th>Unit Kerja</th><th>Masuk</th><th>Pulang</th><th>Terlambat</th><th>Status</th></tr></thead>
            <tbody>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($row->pegawai->nama ?? '-'); ?></td>
                    <td><?php echo e($row->pegawai->unitKerja->nama_unit ?? '-'); ?></td>
                    <td><?php echo e($row->jam_masuk ?? '-'); ?></td>
                    <td><?php echo e($row->jam_pulang ?? '-'); ?></td>
                    <td><?php echo e($row->menit_telat); ?> menit</td>
                    <td><span class="badge badge-<?php echo e($row->status === 'terlambat' ? 'warning' : 'success'); ?>"><?php echo e(ucfirst($row->status)); ?></span></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="6" class="text-center text-muted py-4">Tidak ada data kehadiran pada tanggal ini.</td></tr>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($data->hasPages()): ?>
        <div class="card-body">
            <?php echo e($data->links()); ?>

        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\absensirailwayupdate\resources\views/absensi/monitoring.blade.php ENDPATH**/ ?>