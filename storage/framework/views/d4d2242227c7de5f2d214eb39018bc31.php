<?php $__env->startSection('title', 'Tukin'); ?>
<?php $__env->startSection('content'); ?>
<div class="page-header">
    <h1 class="page-title">Perhitungan Tukin</h1>
    <p class="page-subtitle">Hitung potongan tukin berdasarkan keterlambatan dan kompensasi.</p>
</div>

<!-- FILTER BULAN & TAHUN -->
<div class="card mb-3">
    <div class="card-body">
        <form class="form-inline" method="GET" action="<?php echo e(route('tukin.index')); ?>">
            <label class="mr-2 font-weight-bold">Bulan</label>
            <input type="number" min="1" max="12" name="bulan" value="<?php echo e($bulan); ?>" class="form-control mr-3">
            
            <label class="mr-2 font-weight-bold">Tahun</label>
            <input type="number" name="tahun" value="<?php echo e($tahun); ?>" class="form-control mr-3">
            
            <!-- Tombol Filter Sesuai Gambar Contoh -->
            <button class="btn btn-danger btn-sm px-3 btn-rounded-8 btn-filter-inline">
                <i class="fas fa-filter mr-1"></i>Filter
            </button>
        </form>
    </div>
</div>

<!-- TABEL DATA PERHITUNGAN -->
<div class="card">
    <div class="card-body p-0">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>Pegawai</th>
                    <th>NIP/NIK</th>
                    <th>Telat</th>
                    <th>Kompensasi</th>
                    <th>Potongan</th>
                    <th class="text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php ($row = $potongan[$item->id] ?? null); ?>
                    <tr>
                        <td>
                            <strong><?php echo e($item->nama); ?></strong><br>
                            <span class="text-muted small"><?php echo e($item->unitKerja->nama_unit ?? '-'); ?></span>
                        </td>
                        <td>
                            <span class="badge badge-light mb-1"><?php echo e($item->jenis_identitas); ?></span><br>
                            <?php echo e($item->nomor_identitas); ?>

                        </td>
                        <td><?php echo e($row->total_telat ?? 0); ?> menit</td>
                        <td><?php echo e($row->total_kompensasi ?? 0); ?> menit</td>
                        
                        <!-- WARNA POTONGAN KEMBALI NORMAL (POLOS) -->
                        <td>Rp <?php echo e(number_format($row->potongan ?? 0,0,',','.')); ?></td>
                        
                        <td class="text-right">
                            <form method="POST" action="<?php echo e(route('tukin.hitung',$item->id)); ?>">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="bulan" value="<?php echo e($bulan); ?>">
                                <input type="hidden" name="tahun" value="<?php echo e($tahun); ?>">
                                <!-- Tombol Hitung Diseragamkan Kelengkungan & Ukurannya -->
                                <button class="btn btn-danger btn-sm px-3 btn-rounded-8">
                                    <i class="fas fa-calculator mr-1"></i>Hitung
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">Belum ada data pegawai.</td>
                    </tr>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\absensirailwayupdate\resources\views/tukin/index.blade.php ENDPATH**/ ?>