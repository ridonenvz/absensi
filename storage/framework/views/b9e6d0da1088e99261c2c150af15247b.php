<?php $__env->startSection('title', 'Kelola Pegawai'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <h1 class="page-title">Kelola Pegawai</h1>
    <p class="page-subtitle">Tambah, ubah, dan hapus data pegawai beserta akun login.</p>
</div>

<div class="card">
    <div class="card-header table-toolbar">
        <div>
            <h3 class="card-title mb-0 font-weight-bold">Daftar Pegawai</h3>
            <p class="toolbar-subtitle mb-0">Data pegawai dan akun login yang terdaftar.</p>
        </div>
        <button type="button" class="btn btn-danger" data-modal-open="modal-tambah-pegawai">
            <i class="fas fa-plus mr-1"></i>Tambah Pegawai
        </button>
    </div>
    <div class="card-body p-0">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>NIP/NIK</th>
                    <th>Unit</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th class="text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $pegawais; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><strong><?php echo e($p->nama); ?></strong><br><span class="text-muted small"><?php echo e($p->user->email ?? '-'); ?></span></td>
                    <td><span class="badge badge-light"><?php echo e($p->jenis_identitas); ?></span><br><?php echo e($p->nomor_identitas); ?></td>
                    <td><?php echo e($p->unitKerja->nama_unit ?? '-'); ?></td>
                    <td><span class="badge badge-light"><?php echo e(ucfirst($p->user->role ?? '-')); ?></span></td>
                    <td><span class="badge badge-<?php echo e($p->status === 'aktif' ? 'success' : 'secondary'); ?>"><?php echo e(ucfirst($p->status)); ?></span></td>
                    <td class="text-right">
                        <a href="<?php echo e(route('pegawai.edit', $p->id)); ?>" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                        <form action="<?php echo e(route('pegawai.destroy', $p->id)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Hapus pegawai ini?')">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="6" class="text-center text-muted py-4">Belum ada data pegawai.</td></tr>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="form-modal" id="modal-tambah-pegawai" aria-hidden="true" data-modal-auto-open="<?php echo e($errors->any() ? 'true' : 'false'); ?>">
    <div class="form-modal-backdrop" data-modal-close></div>
    <div class="form-modal-panel form-modal-panel-lg" role="dialog" aria-modal="true" aria-labelledby="judul-tambah-pegawai">
        <div class="form-modal-header">
            <div>
                <h3 id="judul-tambah-pegawai" class="form-modal-title">Tambah Pegawai</h3>
                <p class="form-modal-subtitle">Isi data pegawai dan akun login.</p>
            </div>
            <button type="button" class="btn btn-outline-secondary btn-sm" data-modal-close aria-label="Tutup form">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form action="<?php echo e(route('pegawai.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <div class="form-modal-body">
                <div class="form-grid">
                    <div class="form-group">
                        <label>NIP</label>
                        <input type="text" name="nip" class="form-control" value="<?php echo e(old('nip')); ?>" placeholder="Isi jika pegawai memiliki NIP">
                    </div>
                    <div class="form-group">
                        <label>NIK</label>
                        <input type="text" name="nik" class="form-control" value="<?php echo e(old('nik')); ?>" placeholder="Isi jika pegawai tidak memiliki NIP">
                        <small class="text-muted">Minimal isi salah satu: NIP atau NIK.</small>
                    </div>
                    <div class="form-group">
                        <label>Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control" value="<?php echo e(old('nama')); ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Jabatan</label>
                        <input type="text" name="jabatan" class="form-control" value="<?php echo e(old('jabatan')); ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Unit Kerja</label>
                        <select name="unit_kerja_id" class="custom-select" required>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $unitKerja; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($unit->id); ?>" <?php if(old('unit_kerja_id') == $unit->id): echo 'selected'; endif; ?>><?php echo e($unit->nama_unit); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="custom-select">
                            <option value="L" <?php if(old('jenis_kelamin') == 'L'): echo 'selected'; endif; ?>>Laki-laki</option>
                            <option value="P" <?php if(old('jenis_kelamin') == 'P'): echo 'selected'; endif; ?>>Perempuan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="custom-select">
                            <option value="aktif" <?php if(old('status', 'aktif') == 'aktif'): echo 'selected'; endif; ?>>Aktif</option>
                            <option value="nonaktif" <?php if(old('status') == 'nonaktif'): echo 'selected'; endif; ?>>Nonaktif</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Email Login</label>
                        <input type="email" name="email" class="form-control" value="<?php echo e(old('email')); ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Role</label>
                        <select name="role" class="custom-select">
                            <option value="pegawai" <?php if(old('role', 'pegawai') == 'pegawai'): echo 'selected'; endif; ?>>Pegawai</option>
                            <option value="atasan" <?php if(old('role') == 'atasan'): echo 'selected'; endif; ?>>Atasan</option>
                            <option value="pimpinan" <?php if(old('role') == 'pimpinan'): echo 'selected'; endif; ?>>Pimpinan</option>
                            <option value="admin" <?php if(old('role') == 'admin'): echo 'selected'; endif; ?>>Admin</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Kosongkan untuk default: password">
                    </div>
                </div>
            </div>
            <div class="form-modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-modal-close>Batal</button>
                <button class="btn btn-danger"><i class="fas fa-check mr-1"></i>Simpan Pegawai</button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\absensirailwayupdate\resources\views/pegawai/index.blade.php ENDPATH**/ ?>