<?php $__env->startSection('title', 'Approval Pengajuan'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <h1 class="page-title">Approval Pengajuan</h1>
    <p class="page-subtitle">Setujui atau tolak pengajuan izin/cuti pegawai.</p>
</div>

<div class="card mb-3">
    <div class="card-body py-3">
        <form class="d-flex align-items-center flex-wrap" method="GET" action="<?php echo e(route('pengajuan.approval')); ?>">
            <div class="filter-field">
                <label class="mb-0 filter-field-label">Nama Pegawai</label>
                <input type="text" name="cari" value="<?php echo e($filters['cari'] ?? ''); ?>" class="form-control form-control-sm form-control-pill filter-input-narrow" placeholder="Cari nama...">
            </div>

            <div class="filter-field">
                <label class="mb-0 filter-field-label">Jenis</label>
                <select name="jenis" class="form-control form-control-sm form-control-pill filter-select-jenis">
                    <option value="">Semua Jenis</option>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = ['izin','cuti_tahunan','cuti_sakit','cuti_melahirkan','cuti_penting']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $j): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($j); ?>" <?php echo e(($filters['jenis'] ?? '') === $j ? 'selected' : ''); ?>><?php echo e(ucwords(str_replace('_',' ',$j))); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </select>
            </div>

            <div class="filter-field">
                <label class="mb-0 filter-field-label">Dari</label>
                <input type="date" name="dari" value="<?php echo e($filters['dari'] ?? ''); ?>" class="form-control form-control-sm form-control-pill">
            </div>
            
            <div class="filter-field">
                <label class="mb-0 filter-field-label">Sampai</label>
                <input type="date" name="sampai" value="<?php echo e($filters['sampai'] ?? ''); ?>" class="form-control form-control-sm form-control-pill">
            </div>

            <button class="btn btn-danger btn-sm px-3 btn-rounded-8 btn-filter-inline"><i class="fas fa-filter mr-1"></i>Filter</button>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header table-toolbar">
        <div>
            <h3 class="card-title mb-0 font-weight-bold">Daftar Persetujuan</h3>
            <p class="toolbar-subtitle mb-0">Daftar permohonan pending yang membutuhkan respon Anda.</p>
        </div>
        <a href="<?php echo e(route('pengajuan.approval.riwayat')); ?>" class="btn btn-danger px-3 d-inline-flex align-items-center btn-action-38 btn-rounded-8">
            <i class="fas fa-history mr-2"></i>Riwayat Approval
        </a>
    </div>
    
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead><tr><th>Pegawai</th><th>Jenis</th><th>Periode</th><th>Alasan</th><th class="text-right">Aksi</th></tr></thead>
                <tbody>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="cell-strong"><?php echo e($item->pegawai->nama ?? '-'); ?></td>
                        <td><?php echo e(ucwords(str_replace('_',' ', $item->jenis))); ?></td>
                        <td><?php echo e($item->tanggal_mulai); ?> s.d. <?php echo e($item->tanggal_selesai); ?></td>
                        <td><?php echo e(\Illuminate\Support\Str::limit($item->alasan, 60)); ?></td>
                        <td class="text-right text-nowrap">
                            <a href="<?php echo e(route('pengajuan.show', $item->id)); ?>" class="btn btn-outline-secondary btn-sm px-3 btn-rounded-8 mr-2">
                                <i class="fas fa-eye mr-1"></i>Detail
                            </a>
                            <button type="button" class="btn btn-success btn-sm px-3 btn-rounded-8 mr-2" data-modal-open="modal-approve-<?php echo e($item->id); ?>">
                                <i class="fas fa-check mr-1"></i>Setujui
                            </button>
                            <button type="button" class="btn btn-danger btn-sm px-3 btn-rounded-8" data-modal-open="modal-reject-<?php echo e($item->id); ?>">
                                <i class="fas fa-times mr-1"></i>Tolak
                            </button>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="5" class="text-center text-muted py-4">Tidak ada pengajuan pending.</td></tr>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(method_exists($data, 'hasPages') && $data->hasPages()): ?>
        <div class="card-footer bg-white py-3"><?php echo e($data->links()); ?></div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>

<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="form-modal" id="modal-approve-<?php echo e($item->id); ?>" aria-hidden="true">
        <div class="form-modal-backdrop" data-modal-close></div>
        <div class="form-modal-panel" role="dialog" aria-modal="true">
            <div class="form-modal-header">
                <div>
                    <h3 class="form-modal-title">Setujui Pengajuan</h3>
                    <p class="form-modal-subtitle"><?php echo e($item->pegawai->nama ?? '-'); ?> &middot; <?php echo e(ucwords(str_replace('_',' ', $item->jenis))); ?></p>
                </div>
                <button type="button" class="btn btn-sm" data-modal-close><i class="fas fa-times"></i></button>
            </div>
            <form method="POST" action="<?php echo e(route('pengajuan.approve', $item->id)); ?>">
                <?php echo csrf_field(); ?>
                <div class="form-modal-body">
                    <div class="form-group mb-0">
                        <label>Catatan (opsional)</label>
                        <textarea name="catatan" class="form-control" rows="3" placeholder="Catatan persetujuan..."></textarea>
                    </div>
                </div>
                <div class="form-modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-modal-close>Batal</button>
                    <button class="btn btn-success"><i class="fas fa-check mr-1"></i>Setujui</button>
                </div>
            </form>
        </div>
    </div>

    <div class="form-modal" id="modal-reject-<?php echo e($item->id); ?>" aria-hidden="true">
        <div class="form-modal-backdrop" data-modal-close></div>
        <div class="form-modal-panel" role="dialog" aria-modal="true">
            <div class="form-modal-header">
                <div>
                    <h3 class="form-modal-title">Tolak Pengajuan</h3>
                    <p class="form-modal-subtitle"><?php echo e($item->pegawai->nama ?? '-'); ?> &middot; <?php echo e(ucwords(str_replace('_',' ', $item->jenis))); ?></p>
                </div>
                <button type="button" class="btn btn-sm" data-modal-close><i class="fas fa-times"></i></button>
            </div>
            <form method="POST" action="<?php echo e(route('pengajuan.reject', $item->id)); ?>">
                <?php echo csrf_field(); ?>
                <div class="form-modal-body">
                    <div class="form-group mb-0">
                        <label>Catatan Penolakan</label>
                        <textarea name="catatan" class="form-control" rows="3" placeholder="Alasan penolakan..." required></textarea>
                    </div>
                </div>
                <div class="form-modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-modal-close>Batal</button>
                    <button class="btn btn-danger"><i class="fas fa-times mr-1"></i>Tolak</button>
                </div>
            </form>
        </div>
    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\absensirailwayupdate\resources\views/pengajuan/approval.blade.php ENDPATH**/ ?>