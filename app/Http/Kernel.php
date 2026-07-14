protected $routeMiddleware = [
    'admin' => \App\Http\Middleware\AdminMiddleware::class,
    'atasan' => \App\Http\Middleware\AtasanMiddleware::class,
    'pimpinan' => \App\Http\Middleware\PimpinanMiddleware::class,
    'role' => \App\Http\Middleware\RoleMiddleware::class,
];