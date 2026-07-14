# Absensi Bawaslu - Versi Disesuaikan Panduan Laravel

Project ini sudah disesuaikan dengan checklist praktikum:

- Laravel 12
- PHP 8.2+
- MVC: Model, View Blade, Controller
- Blade Template
- Eloquent ORM
- Koneksi MySQL melalui `.env`
- Migration tabel database
- Seeder user sesuai panduan: `UserTableSeeder.php`
- Controller user sesuai panduan: `UserController.php`
- Struktur Jetstream/Livewire compatibility sudah ditambahkan pada source
- Login dan role aplikasi tetap berjalan untuk admin, pegawai, atasan, dan pimpinan

## Database

Nama database default pada file `.env`:

```env
DB_DATABASE=db_bawaslu
DB_USERNAME=root
DB_PASSWORD=
```

Buat database tersebut di phpMyAdmin/MySQL sebelum migrate.

## Cara menjalankan

```bash
cd absensi
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan migrate:fresh --seed
php artisan serve
```

Buka:

```text
http://127.0.0.1:8000/login
```

## Akun demo

```text
admin@bawaslu.go.id / password
pegawai@bawaslu.go.id / password
atasan@bawaslu.go.id / password
pimpinan@bawaslu.go.id / password
```

## Catatan Jetstream

Source sudah diberi konfigurasi dan compatibility layer Jetstream/Livewire agar struktur tugas sesuai panduan. Bila dosen meminta package Jetstream resmi dari Composer, jalankan di laptop yang terkoneksi internet:

```bash
composer require laravel/jetstream
php artisan jetstream:install livewire
npm install
npm run build
php artisan migrate:fresh --seed
```

## Perubahan NIP/NIK Pegawai

- Tabel `pegawai` sekarang memiliki kolom `nik`.
- Kolom `nip` dibuat nullable karena tidak semua pegawai memiliki NIP.
- Form tambah dan edit pegawai sekarang menyediakan input NIP dan NIK.
- Validasi dibuat wajib salah satu: NIP atau NIK.
- Daftar pegawai, dashboard pegawai, dan halaman tukin menampilkan identitas sebagai NIP/NIK otomatis.

## Perbaikan Error Tabel `users` Tidak Ada

Jika muncul error seperti ini:

```text
SQLSTATE[42S02]: Base table or view not found: 1146 Table 'db_bawaslu.users' doesn't exist
```

Jalankan perintah berikut tanpa menghapus data lama:

```bash
php artisan optimize:clear
php artisan migrate
php artisan db:seed --class=UserSeeder
```

Jika database boleh di-reset dari awal, gunakan:

```bash
php artisan optimize:clear
php artisan migrate:fresh --seed
```
