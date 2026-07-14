<?php $__env->startSection('title', 'Edit Pegawai'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <h1 class="page-title">Edit Pegawai</h1>
    <p class="page-subtitle">Perbarui data pegawai dan akun login.</p>
</div>

<div class="card">
    <div class="card-body">
        <form action="<?php echo e(route('pegawai.update', $pegawai->id)); ?>" method="POST">
            <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
            <div class="row">
                <div class="col-md-4 form-group"><label>NIP</label><input type="text" name="nip" class="form-control" value="<?php echo e(old('nip', $pegawai->nip)); ?>" placeholder="Isi jika pegawai memiliki NIP"></div>
                <div class="col-md-4 form-group"><label>NIK</label><input type="text" name="nik" class="form-control" value="<?php echo e(old('nik', $pegawai->nik)); ?>" placeholder="Isi jika pegawai tidak memiliki NIP"><small class="text-muted">Minimal isi salah satu: NIP atau NIK.</small></div>
                <div class="col-md-4 form-group"><label>Nama</label><input type="text" name="nama" class="form-control" value="<?php echo e(old('nama', $pegawai->nama)); ?>" required></div>
                <div class="col-md-4 form-group"><label>Jabatan</label><input type="text" name="jabatan" class="form-control" value="<?php echo e(old('jabatan', $pegawai->jabatan)); ?>" required></div>
                <div class="col-md-4 form-group"><label>Unit Kerja</label><select name="unit_kerja_id" class="custom-select" required><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $unitKerja; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($unit->id); ?>" <?php echo e(old('unit_kerja_id', $pegawai->unit_kerja_id) == $unit->id ? 'selected' : ''); ?>><?php echo e($unit->nama_unit); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?></select></div>
                <div class="col-md-4 form-group"><label>Jenis Kelamin</label><select name="jenis_kelamin" class="custom-select"><option value="L" <?php echo e($pegawai->jenis_kelamin === 'L' ? 'selected' : ''); ?>>Laki-laki</option><option value="P" <?php echo e($pegawai->jenis_kelamin === 'P' ? 'selected' : ''); ?>>Perempuan</option></select></div>
                <div class="col-md-4 form-group"><label>Status</label><select name="status" class="custom-select"><option value="aktif" <?php echo e($pegawai->status === 'aktif' ? 'selected' : ''); ?>>Aktif</option><option value="nonaktif" <?php echo e($pegawai->status === 'nonaktif' ? 'selected' : ''); ?>>Nonaktif</option></select></div>
                <div class="col-md-4 form-group"><label>Email Login</label><input type="email" name="email" class="form-control" value="<?php echo e(old('email', $pegawai->user->email ?? '')); ?>" required></div>
                <div class="col-md-4 form-group"><label>Role</label><select name="role" class="custom-select"><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = ['pegawai','atasan','pimpinan','admin']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($role); ?>" <?php echo e(old('role', $pegawai->user->role ?? 'pegawai') === $role ? 'selected' : ''); ?>><?php echo e(ucfirst($role)); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?></select></div>
                <div class="col-md-4 form-group"><label>Password Baru</label><input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak diubah"></div>
            </div>
            <div class="d-flex justify-content-between">
                <a href="<?php echo e(route('pegawai.index')); ?>" class="btn btn-outline-secondary">Kembali</a>
                <button class="btn btn-danger">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\absensirailwayupdate\resources\views/pegawai/edit.blade.php ENDPATH**/ ?>