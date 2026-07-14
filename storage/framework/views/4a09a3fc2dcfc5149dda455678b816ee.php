<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Absensi Bawaslu</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo e(asset('style.css')); ?>">
</head>
<body class="login-page">
<div class="login-box">
    <div class="card login-card">
        <div class="login-hero text-center">
            <div class="mb-3">
                <img src="https://upload.wikimedia.org/wikipedia/commons/6/62/Logo_Bawaslu.png" alt="Logo Bawaslu" class="brand-logo-img">
            </div>

            <h3 class="font-weight-bold mb-1 login-heading">
                Absensi Bawaslu Jawa Barat
            </h3>
            <p class="text-muted mb-0">Silakan masuk ke akun Anda</p>
        </div>
        <div class="card-body p-4">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
                <div class="alert alert-success"><?php echo e(session('success')); ?></div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->any()): ?>
                <div class="alert alert-danger"><?php echo e($errors->first()); ?></div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <form method="POST" action="<?php echo e(route('login.process')); ?>">
                <?php echo csrf_field(); ?>
          <div class="form-group mb-3">
                    <label class="font-weight-bold mb-1">Email</label>
                    <!-- Perbaikan: Mengeluarkan input dari kelas .input-group agar border radius-nya normal -->
                    <input type="email" name="email" value="<?php echo e(old('email')); ?>" class="form-control" placeholder="Masukkan email" required autofocus>
                </div>
                <div class="form-group mb-3">
                    <label class="font-weight-bold mb-1">Kata Sandi</label>
                    <!-- Perbaikan: Mengeluarkan input dari kelas .input-group agar border radius-nya normal -->
                    <input type="password" name="password" class="form-control" placeholder="Masukkan kata sandi" required>
                </div>
                <div class="form-check mb-3">
                    <input type="checkbox" name="remember" class="form-check-input" id="remember">
                    <label for="remember" class="form-check-label text-muted">Ingat sesi saya</label>
                </div>
                <button class="btn btn-danger btn-block">Login</button>
            </form>
        </div>
    </div>
</div>
</body>
</html><?php /**PATH C:\xampp\htdocs\absensirailwayupdate\resources\views/auth/login.blade.php ENDPATH**/ ?>