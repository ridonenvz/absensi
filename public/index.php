<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Cek apakah aplikasi sedang dalam mode perbaikan (maintenance)
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Daftarkan Autoloader Composer
require __DIR__.'/../vendor/autoload.php';

// Jalankan Aplikasi Laravel
$app = require_with_result(__DIR__.'/../bootstrap/app.php');

$handle = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $handle->handle(
    $request = Request::capture()
)->send();

$handle->terminate($request, $response);

function require_with_result($path) {
    return require $path;
}