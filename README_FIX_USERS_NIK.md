# Perbaikan Error Tabel `users` dan NIK Pegawai

## Masalah
Error berikut muncul karena database `db_bawaslu` belum memiliki tabel `users`:

```text
SQLSTATE[42S02]: Base table or view not found: 1146 Table 'db_bawaslu.users' doesn't exist
```

## Perbaikan dalam versi ini
1. Migration dibuat ulang dengan urutan timestamp yang benar.
2. Tabel `users` dibuat sebelum data login admin dipakai.
3. Migration dibuat lebih aman untuk database yang sudah pernah dibuat sebagian.
4. Kolom `nik` tetap tersedia pada tabel `pegawai`.
5. Kolom `nip` boleh kosong.
6. Pegawai wajib memiliki salah satu identitas, yaitu `nip` atau `nik`.

## Cara menjalankan tanpa menghapus data lama
Gunakan ini jika data absensi/pegawai lama masih ingin dipertahankan.

```bash
php artisan optimize:clear
php artisan migrate
php artisan db:seed --class=UserSeeder
```

Login admin default:

```text
Email    : admin@bawaslu.go.id
Password : password
```

## Cara menjalankan dari database kosong
Gunakan ini jika database boleh di-reset dari awal.

```bash
php artisan optimize:clear
php artisan migrate:fresh --seed
```

## Catatan penting
Pastikan `.env` sudah sesuai dengan database lokal:

```text
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_bawaslu
DB_USERNAME=root
DB_PASSWORD=
```

Jika memakai XAMPP/Laragon dan password MySQL kosong, biarkan `DB_PASSWORD=` kosong.
