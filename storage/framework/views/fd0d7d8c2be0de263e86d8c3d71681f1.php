<nav class="main-header navbar navbar-expand navbar-white navbar-light border-0 shadow-sm">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <ul class="navbar-nav ml-auto align-items-center">
        <li class="nav-item mr-3 d-none d-md-block text-muted small">
            <i class="far fa-user mr-1"></i><?php echo e(auth()->user()->name ?? 'User'); ?>

        </li>
        <li class="nav-item">
            <form method="POST" action="<?php echo e(route('logout')); ?>">
                <?php echo csrf_field(); ?>
                <button class="btn btn-outline-danger btn-sm"><i class="fas fa-sign-out-alt mr-1"></i>Logout</button>
            </form>
        </li>
    </ul>
</nav>
<?php /**PATH C:\xampp\htdocs\absensirailwayupdate\resources\views/layouts/navbar.blade.php ENDPATH**/ ?>