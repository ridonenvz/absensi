<?php $__env->startSection('title', 'Riwayat Approval'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <h1 class="page-title">Riwayat Approval</h1>
    <p class="page-subtitle">Daftar pengajuan yang sudah diproses (disetujui/ditolak).</p>
</div>

<div class="card mb-3">
    <div class="card-body py-3">
        <form class="d-flex align-items-center flex-wrap" method="GET" action="<?php echo e(route('pengajuan.approval.riwayat')); ?>">
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
                <label class="mb-0 filter-field-label">Status</label>
                <select name="status" class="form-control form-control-sm form-control-pill filter-select-status">
                    <option value="">Semua Status</option>
                    <option value="approved" <?php echo e(($filters['status'] ?? '') === 'approved' ? 'selected' : ''); ?>>Approved</option>
                    <option value="rejected" <?php echo e(($filters['status'] ?? '') === 'rejected' ? 'selected' : ''); ?>>Rejected</option>
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
            <h3 class="card-title mb-0 font-weight-bold">Data Riwayat</h3>
            <p class="toolbar-subtitle mb-0">Daftar permohonan berkas yang telah Anda proses selesai.</p>
        </div>
        <a href="<?php echo e(route('pengajuan.approval')); ?>" class="btn btn-outline-secondary px-3 d-inline-flex align-items-center btn-action-38 btn-rounded-8">
            <i class="fas fa-arrow-left mr-2"></i>Kembali ke Approval
        </a>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead><tr><th>Pegawai</th><th>Jenis</th><th>Periode</th><th>Status</th><th>Diproses Oleh</th><th>Catatan</th><th>Tanggal Proses</th><th class="text-right">Aksi</th></tr></thead>
                <tbody>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="cell-strong"><?php echo e($item->pegawai->nama ?? '-'); ?></td>
                        <td><?php echo e(ucwords(str_replace('_',' ', $item->jenis))); ?></td>
                        <td><?php echo e($item->tanggal_mulai); ?> s.d. <?php echo e($item->tanggal_selesai); ?></td>
                        <td>
                            <?php
                            $statusClass = match($item->status) {
                                'approved' => 'badge-status-approved',
                                'rejected' => 'badge-status-rejected',
                                default => 'badge-status-pending',
                            };
                            ?>
                            <span class="badge <?php echo e($statusClass); ?> badge-pill-md">
                                <?php echo e(ucfirst($item->status)); ?>

                            </span>
                        </td>
                        <td><?php echo e($item->approver->name ?? '-'); ?></td>
                        <td><?php echo e(\Illuminate\Support\Str::limit($item->catatan ?: '-', 40)); ?></td>
                        <td><?php echo e($item->approved_at ? \Carbon\Carbon::parse($item->approved_at)->format('d M Y H:i') : '-'); ?></td>
                        <td class="text-right">
                            <!-- Mengembalikan teks Detail -->
                            <a href="<?php echo e(route('pengajuan.show', $item->id)); ?>" class="btn btn-outline-secondary btn-sm px-3 btn-rounded-8">
                                <i class="fas fa-eye mr-1"></i>Detail
                            </a>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="8" class="text-center text-muted py-4">Belum ada riwayat approval.</td></tr>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(method_exists($data, 'hasPages') && $data->hasPages()): ?>
        <div class="card-footer bg-white py-3"><?php echo e($data->links()); ?></div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\absensirailwayupdate\resources\views/pengajuan/riwayat.blade.php ENDPATH**/ ?>