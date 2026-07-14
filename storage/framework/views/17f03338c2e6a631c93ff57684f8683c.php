<?php $__env->startSection('title', 'Jam Kerja'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <h1 class="page-title">Jam Kerja</h1>
    <p class="page-subtitle">Atur jadwal masuk, pulang, dan status WFH.</p>
</div>

<div class="card">
    <div class="card-header table-toolbar">
        <div>
            <h3 class="card-title mb-0 font-weight-bold">Daftar Jadwal</h3>
            <p class="toolbar-subtitle mb-0">Data hari kerja dan pengaturan WFH.</p>
        </div>
        <button type="button" class="btn btn-danger" data-modal-open="modal-tambah-jadwal">
            <i class="fas fa-plus mr-1"></i>Tambah Jadwal
        </button>
    </div>
    <div class="card-body p-0">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>Hari</th>
                    <th>Masuk</th>
                    <th>Pulang</th>
                    <th>Status</th>
                    <th class="text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><strong><?php echo e($row->hari); ?></strong></td>
                    <td><?php echo e($row->jam_masuk ?? '-'); ?></td>
                    <td><?php echo e($row->jam_pulang ?? '-'); ?></td>
                    <td><span class="badge badge-<?php echo e($row->is_wfh ? 'info' : 'success'); ?>"><?php echo e($row->is_wfh ? 'WFH' : 'WFO'); ?></span></td>
                    <td class="text-right">
                        <a class="btn btn-warning btn-sm" href="<?php echo e(route('jam-kerja.edit',$row->id)); ?>"><i class="fas fa-edit"></i></a>
                        <form class="d-inline" method="POST" action="<?php echo e(route('jam-kerja.destroy',$row->id)); ?>" onsubmit="return confirm('Hapus jadwal ini?')">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="5" class="text-center text-muted py-4">Belum ada jadwal kerja.</td></tr>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="form-modal" id="modal-tambah-jadwal" aria-hidden="true" data-modal-auto-open="<?php echo e($errors->any() ? 'true' : 'false'); ?>">
    <div class="form-modal-backdrop" data-modal-close></div>
    <div class="form-modal-panel" role="dialog" aria-modal="true" aria-labelledby="judul-tambah-jadwal">
        <div class="form-modal-header">
            <div>
                <h3 id="judul-tambah-jadwal" class="form-modal-title">Tambah Jadwal</h3>
                <p class="form-modal-subtitle">Tentukan hari, jam masuk, jam pulang, dan status kerja.</p>
            </div>
            <button type="button" class="btn btn-outline-secondary btn-sm" data-modal-close aria-label="Tutup form">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form method="POST" action="<?php echo e(route('jam-kerja.store')); ?>">
            <?php echo csrf_field(); ?>
            <div class="form-modal-body">
                <div class="form-group">
                    <label>Hari</label>
                    <select name="hari" class="custom-select">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $hari; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $h): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($h); ?>" <?php if(old('hari') == $h): echo 'selected'; endif; ?>><?php echo e($h); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Jam Masuk</label>
                    <input type="time" name="jam_masuk" class="form-control" value="<?php echo e(old('jam_masuk')); ?>">
                </div>
                <div class="form-group">
                    <label>Jam Pulang</label>
                    <input type="time" name="jam_pulang" class="form-control" value="<?php echo e(old('jam_pulang')); ?>">
                </div>
                <div class="custom-control custom-switch">
                    <input type="checkbox" name="is_wfh" value="1" class="custom-control-input" id="is_wfh" <?php if(old('is_wfh')): echo 'checked'; endif; ?>>
                    <label class="custom-control-label" for="is_wfh">WFH</label>
                </div>
            </div>
            <div class="form-modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-modal-close>Batal</button>
                <button class="btn btn-danger"><i class="fas fa-check mr-1"></i>Simpan</button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\absensirailwayupdate\resources\views/jam-kerja/index.blade.php ENDPATH**/ ?>