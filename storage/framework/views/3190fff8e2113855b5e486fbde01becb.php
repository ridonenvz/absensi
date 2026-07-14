<?php $__env->startSection('title', 'Edit Unit Kerja'); ?>
<?php $__env->startSection('content'); ?>
<div class="page-header"><h1 class="page-title">Edit Unit Kerja</h1><p class="page-subtitle">Perbarui nama unit kerja.</p></div>
<div class="card"><div class="card-body"><form method="POST" action="<?php echo e(route('unit-kerja.update',$unitKerja->id)); ?>"><?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?><div class="form-group"><label>Nama Unit</label><input name="nama_unit" class="form-control" value="<?php echo e(old('nama_unit',$unitKerja->nama_unit)); ?>" required></div><div class="d-flex justify-content-between"><a href="<?php echo e(route('unit-kerja.index')); ?>" class="btn btn-outline-secondary">Kembali</a><button class="btn btn-danger">Simpan</button></div></form></div></div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\absensirailwayupdate\resources\views/unit-kerja/edit.blade.php ENDPATH**/ ?>