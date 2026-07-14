<?php $__env->startSection('title', 'Data User'); ?>

<?php $__env->startSection('content'); ?>
<!-- HEADER UTAMA: Sudah selaras dengan struktur Unit Kerja -->
<div class="page-header">
    <h1 class="page-title">Data User</h1>
    <p class="page-subtitle">Daftar akun pengguna aplikasi absensi.</p>
</div>

<div class="card">
    <div class="card-header table-toolbar">
        <div>
            <h3 class="card-title mb-0 font-weight-bold">Daftar Akun</h3>
            <p class="toolbar-subtitle mb-0">Data user yang terdaftar dalam sistem.</p>
        </div>
    </div>

    <div class="card-body p-0">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Pegawai</th>
                </tr>
            </thead>
            <tbody>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($user->name); ?></td>
                        <td><?php echo e($user->email); ?></td>
                        <td>
                            <span class="badge badge-brand badge-pill-sm">
                                <?php echo e(ucfirst($user->role)); ?>

                            </span>
                        </td>
                        <td><?php echo e($user->pegawai->nama ?? '-'); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="4" class="text-center text-muted py-4">Belum ada data user.</td>
                    </tr>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\absensirailwayupdate\resources\views/user/index.blade.php ENDPATH**/ ?>