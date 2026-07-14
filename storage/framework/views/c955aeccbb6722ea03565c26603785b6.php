<?php $__env->startSection('title', 'Absensi'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <h1 class="page-title">Absensi Pegawai</h1>
    <p class="page-subtitle">Lakukan absen masuk dan absen pulang sesuai jadwal kerja.</p>
</div>

<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$pegawai): ?>
    <div class="empty-state">Akun ini belum terhubung dengan data pegawai. Hubungi admin untuk mengaktifkan fitur absensi.</div>
<?php else: ?>
<div class="row">
    <div class="col-lg-4 mb-3">
        <div class="stat-card">
            <span class="stat-icon"><i class="fas fa-calendar-day"></i></span>
            <div class="stat-value"><?php echo e(now()->format('H:i')); ?></div>
            <p class="stat-label">Waktu Server · <?php echo e(now()->format('d M Y')); ?></p>
            <hr>
            <p class="mb-1"><strong><?php echo e($pegawai->nama); ?></strong></p>
            <p class="text-muted mb-0"><?php echo e($pegawai->jabatan); ?> · <?php echo e($pegawai->unitKerja->nama_unit ?? '-'); ?></p>
        </div>
    </div>
    <div class="col-lg-8 mb-3">
        <div class="card h-100">
            <div class="card-header"><h3 class="card-title mb-0 font-weight-bold">Aksi Absensi Hari Ini</h3></div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="p-4 rounded-lg bg-light h-100">
                            <h5 class="font-weight-bold">Absen Masuk</h5>
                            <p class="text-muted">Jam masuk: <?php echo e($absenHariIni->jam_masuk ?? 'Belum absen'); ?></p>
                            <form method="POST" action="<?php echo e(route('absensi.masuk')); ?>">
                                <?php echo csrf_field(); ?>
                                <button class="btn btn-success btn-block" <?php echo e($absenHariIni && $absenHariIni->jam_masuk ? 'disabled' : ''); ?>><i class="fas fa-sign-in-alt w-4 h-4 mr-1"></i><span class="font-semibold">Absen Masuk</span></button>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="p-4 rounded-lg bg-light h-100">
                            <h5 class="font-weight-bold">Absen Pulang</h5>
                            <p class="text-muted">Jam pulang: <?php echo e($absenHariIni->jam_pulang ?? 'Belum absen'); ?></p>
                            <form method="POST" action="<?php echo e(route('absensi.pulang')); ?>">
                                <?php echo csrf_field(); ?>
                                <button class="btn btn-danger btn-block" <?php echo e((!$absenHariIni || !$absenHariIni->jam_masuk || $absenHariIni->jam_pulang) ? 'disabled' : ''); ?>><i class="fas fa-sign-out-alt w-4 h-4 mr-1"></i><span class="font-semibold">Absen Pulang</span></button>
                            </form>
                        </div>
                    </div>
                </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($absenHariIni): ?>
                    <div class="alert alert-info mb-0">Status hari ini: <strong><?php echo e(ucfirst($absenHariIni->status)); ?></strong>. Terlambat <?php echo e($absenHariIni->menit_telat); ?> menit, kompensasi <?php echo e($absenHariIni->menit_kompensasi); ?> menit.</div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header"><h3 class="card-title mb-0 font-weight-bold">Riwayat Absensi Terbaru</h3></div>
    <div class="card-body p-0">
        <table class="table mb-0">
            <thead><tr><th>Tanggal</th><th>Masuk</th><th>Pulang</th><th>Terlambat</th><th>Kompensasi</th><th>Status</th></tr></thead>
            <tbody>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $riwayat; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e(\Carbon\Carbon::parse($row->tanggal)->format('d M Y')); ?></td>
                    <td><?php echo e($row->jam_masuk ?? '-'); ?></td>
                    <td><?php echo e($row->jam_pulang ?? '-'); ?></td>
                    <td><?php echo e($row->menit_telat); ?> menit</td>
                    <td><?php echo e($row->menit_kompensasi); ?> menit</td>
                    <td><span class="badge badge-<?php echo e($row->status === 'terlambat' ? 'warning' : 'success'); ?>"><?php echo e(ucfirst($row->status)); ?></span></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="6" class="text-center text-muted py-4">Belum ada riwayat absensi.</td></tr>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\absensirailwayupdate\resources\views/absensi/index.blade.php ENDPATH**/ ?>