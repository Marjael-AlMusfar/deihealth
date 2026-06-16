# DeiHealth Santri Health

Backend Laravel dan skeleton Android untuk memantau santri sakit, mengelola obat, mencatat resep/jadwal pemberian obat, observasi harian, rujukan, audit log, user approval, dan laporan operasional pesantren.

## Modul yang tersedia

- Registrasi dan autentikasi token: `POST /api/v1/auth/register`, `POST /api/v1/auth/login`, dan `POST /api/v1/auth/logout`.
- User approval admin: `GET /api/v1/user-approvals`, `PATCH /api/v1/user-approvals/{user}/approve`, dan `PATCH /api/v1/user-approvals/{user}/reject`.
- Master santri: `GET/POST /api/v1/students`.
- Laporan santri sakit: `GET/POST /api/v1/health-reports`.
- Master obat dan stok: `GET/POST /api/v1/medicines` serta `POST /api/v1/medicines/{medicine}/stock-movements`.
- Resep dan jadwal obat otomatis: `POST /api/v1/health-reports/{healthReport}/prescriptions`.
- Observasi harian santri sakit: `POST /api/v1/health-reports/{healthReport}/observations`.
- Rujukan dan tindak lanjut: `POST /api/v1/health-reports/{healthReport}/referrals` dan `PATCH /api/v1/referrals/{referral}`.
- Checklist status pemberian obat: `PATCH /api/v1/medication-administrations/{id}/status`.
- Dashboard ringkas: `GET /api/v1/dashboard`.
- Laporan ringkasan: `GET /api/v1/reports/summary?from=YYYY-MM-DD&to=YYYY-MM-DD`.
- Export CSV laporan santri sakit: `GET /api/v1/reports/sick-students.csv?from=YYYY-MM-DD&to=YYYY-MM-DD`.

## Database MySQL

Konfigurasi default `.env.example` sudah diarahkan ke MySQL:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=deihealth
DB_USERNAME=favian
DB_PASSWORD=123
```

Pastikan database dan user MySQL sudah dibuat sebelum menjalankan migration:

```sql
CREATE DATABASE deihealth CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'favian'@'localhost' IDENTIFIED BY '123';
GRANT ALL PRIVILEGES ON deihealth.* TO 'favian'@'localhost';
FLUSH PRIVILEGES;
```

## Setup lokal

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

Seeder membuat admin awal dari variabel `ADMIN_NAME`, `ADMIN_EMAIL`, dan `ADMIN_PASSWORD` agar admin bisa melakukan approval user baru.

> Catatan: dependency tidak ikut dikomit. Jalankan `composer install` di lingkungan dengan akses Packagist.

## Alur user approval

1. User mendaftar melalui `POST /api/v1/auth/register`.
2. Akun otomatis berstatus `pending` dan `is_active=false` sehingga belum bisa login.
3. Admin login memakai akun hasil seeder.
4. Admin membuka daftar approval dengan `GET /api/v1/user-approvals?status=pending`.
5. Admin menyetujui user dengan `PATCH /api/v1/user-approvals/{user}/approve` atau menolak dengan `PATCH /api/v1/user-approvals/{user}/reject`.
6. User yang sudah disetujui berubah menjadi `approved`, `is_active=true`, lalu bisa login.

## Android client skeleton

Folder `android/` berisi skeleton aplikasi Android Kotlin dengan Retrofit client untuk endpoint inti, autentikasi token, laporan sakit, resep, observasi harian, dan obat. Setelah backend berjalan, atur `baseUrl` pada pemanggilan `ApiClient.create(...)` sesuai alamat server Laravel.

## Catatan production readiness

Kode ini sudah bergerak melewati MVP awal, namun sebelum production perlu menambahkan Laravel bootstrap standar, registrasi middleware role sesuai versi Laravel yang dipakai, test suite end-to-end, CI, hardening security, dan review UI/UX Android/Web.

## Menjalankan backend dan database dengan Docker

Cara tercepat untuk menjalankan backend dan MySQL bersama-sama:

```bash
docker compose up --build
```

Setelah container aktif:

- Backend Laravel tersedia di `http://localhost:8000`.
- API tersedia di `http://localhost:8000/api/v1`.
- MySQL memakai database `deihealth`, username `favian`, dan password `123`.
- Admin awal: `admin@deihealth.local` / `password123`.

## Menjalankan Android

Dari folder `android/` gunakan JDK 21:

```bash
JAVA_HOME=/path/to/jdk-21 gradle assembleDebug
```

Jika memakai emulator Android Studio, gunakan base URL default `http://10.0.2.2:8000/`. Jika memakai device fisik, ganti base URL di layar login ke IP komputer backend, misalnya `http://192.168.1.10:8000/`.

Screen Android yang tersedia:

- Login admin/user.
- Register user baru untuk approval admin.
- Dashboard petugas.
- Form laporan santri sakit.
- Daftar ringkas obat.
- Daftar ringkas laporan sakit.

## Checklist post-production

Sebelum production publik, pastikan:

- Jalankan `APP_ENV=production` dan `APP_DEBUG=false`.
- Ganti `APP_KEY`, admin password, dan semua credential default.
- Gunakan HTTPS di reverse proxy.
- Jalankan `php artisan migrate --force --seed` saat deployment.
- Jalankan `php artisan config:cache` dan `php artisan route:cache` setelah env final.
- Aktifkan backup MySQL terjadwal.
- Aktifkan monitoring log dan error reporting.
- Batasi endpoint approval hanya untuk role admin melalui middleware role pada bootstrap final.
- Jalankan test backend dan Android di CI sebelum release.
