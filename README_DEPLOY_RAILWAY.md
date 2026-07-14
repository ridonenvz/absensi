# Panduan Menjalankan Project Absensi Bawaslu

Project ini adalah Laravel 12 full-stack dengan Blade, MySQL, session login, export PDF/Excel sederhana, dan upload lampiran.

## A. Menjalankan di lokal

### 1. Syarat aplikasi

Install dulu:

- PHP 8.2 atau lebih baru
- Composer
- MySQL/MariaDB
- Git opsional
- Node.js tidak wajib untuk project ini karena asset sudah berada di folder `public/`

### 2. Extract dan masuk folder project

```bash
cd absensiiclud
```

### 3. Install dependency Laravel

```bash
composer install
```

### 4. Buat file `.env`

```bash
cp .env.example .env
```

Di Windows PowerShell:

```powershell
copy .env.example .env
```

### 5. Generate APP_KEY

```bash
php artisan key:generate
```

### 6. Buat database MySQL lokal

Buat database bernama:

```sql
CREATE DATABASE db_bawaslu;
```

Pastikan isi `.env` lokal sesuai:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_bawaslu
DB_USERNAME=root
DB_PASSWORD=
```

### 7. Migrasi dan isi data awal

```bash
php artisan migrate --seed
```

### 8. Buat storage link

```bash
php artisan storage:link
```

### 9. Jalankan server lokal

```bash
php artisan serve
```

Buka:

```text
http://127.0.0.1:8000
```

### 10. Akun login awal

Semua password default: `password`

```text
admin@bawaslu.go.id
pegawai@bawaslu.go.id
atasan@bawaslu.go.id
pimpinan@bawaslu.go.id
```

Ganti password/email dummy sebelum dipakai untuk production.

---

## B. Deploy ke Railway via GitHub

### 1. Upload project ke GitHub

Jangan upload folder ini:

```text
vendor/
node_modules/
.env
storage/logs/
storage/framework/views/
storage/framework/sessions/
```

File `.gitignore` sudah disiapkan untuk mencegah itu.

### 2. Buat project di Railway

1. Buka Railway.
2. New Project.
3. Deploy from GitHub repo.
4. Pilih repository project ini.

Railway akan mendeteksi Laravel dari file `artisan`.

### 3. Tambahkan MySQL service

Di Railway Project Canvas:

1. Klik `+ New`.
2. Pilih `Database`.
3. Pilih `MySQL`.

### 4. Isi Variables di service Laravel

Buka service Laravel, masuk ke tab `Variables`, lalu pakai Raw Editor dan isi contoh dari file:

```text
.env.railway.example
```

Yang wajib diganti:

```env
APP_KEY=base64:hasil_key_kamu
APP_URL=https://domain-railway-kamu.up.railway.app
```

Untuk membuat APP_KEY di lokal:

```bash
php artisan key:generate --show
```

Contoh DB Railway:

```env
DB_CONNECTION=mysql
DB_HOST=${{MySQL.MYSQLHOST}}
DB_PORT=${{MySQL.MYSQLPORT}}
DB_DATABASE=${{MySQL.MYSQLDATABASE}}
DB_USERNAME=${{MySQL.MYSQLUSER}}
DB_PASSWORD=${{MySQL.MYSQLPASSWORD}}
```

### 5. Setting build/deploy

File `railway.json` sudah disiapkan. Isinya:

- Builder: `RAILPACK`
- Build command: `null`, supaya Railway tidak memaksa `npm run build`
- Pre-deploy command: menjalankan `railway/init-app.sh`
- Healthcheck: `/up`

Railway akan menjalankan migrasi otomatis melalui:

```bash
chmod +x ./railway/init-app.sh && sh ./railway/init-app.sh
```

### 6. Deploy

Klik `Deploy` atau push commit baru ke GitHub.

### 7. Generate domain

Setelah deploy sukses:

1. Buka service Laravel.
2. Settings.
3. Networking.
4. Generate Domain.
5. Copy domain tersebut ke variable `APP_URL`.
6. Redeploy.

### 8. Seeder production

Migrasi otomatis jalan saat deploy, tetapi seeder tidak otomatis dijalankan agar data production tidak ke-reset.

Untuk menjalankan seeder pertama kali:

```bash
railway run php artisan db:seed --force
```

Atau dari Railway dashboard, gunakan shell/command jika tersedia.

### 9. Upload lampiran agar tidak hilang

Project menyimpan lampiran ke:

```text
storage/app/public/lampiran
```

Untuk production di Railway, tambahkan Volume ke service Laravel dengan mount path:

```text
/app/storage/app/public
```

Kalau tidak memakai Volume, file upload bisa hilang saat redeploy.

---

## C. Catatan penting

1. Jangan isi Custom Build Command dengan `npm run build` karena project ini belum memakai `vite.config.js`.
2. Jangan commit `.env` ke GitHub.
3. Jangan commit `vendor/` dan `node_modules/`.
4. Untuk production, selalu pakai:

```env
APP_ENV=production
APP_DEBUG=false
SESSION_DRIVER=database
LOG_CHANNEL=stderr
```

5. Setelah deploy, segera ganti akun/password dummy.
