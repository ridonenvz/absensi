#!/usr/bin/env bash
set -e

# Bersihkan cache lama agar environment variable Railway terbaca benar.
php artisan optimize:clear --no-interaction || true

# Jalankan migrasi database setiap deploy.
php artisan migrate --force --no-interaction

# Buat symbolic link agar upload di storage/app/public bisa diakses dari public/storage.
php artisan storage:link --no-interaction || true

# Cache config/view untuk production. Jika salah satu gagal, deployment tetap lanjut.
php artisan config:cache --no-interaction || true
php artisan view:cache --no-interaction || true
