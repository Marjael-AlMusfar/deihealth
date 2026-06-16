# DeiHealth Santri Health MVP

Backend Laravel untuk memantau santri sakit, mengelola obat, mencatat pemberian obat, dan menyiapkan laporan operasional pesantren.

## Modul yang tersedia

- Master santri melalui endpoint `GET/POST /api/v1/students`.
- Laporan santri sakit melalui endpoint `GET/POST /api/v1/health-reports`.
- Master obat dan stok melalui endpoint `GET/POST /api/v1/medicines` serta `POST /api/v1/medicines/{medicine}/stock-movements`.
- Checklist status pemberian obat melalui endpoint `PATCH /api/v1/medication-administrations/{id}/status`.
- Dashboard ringkas melalui endpoint `GET /api/v1/dashboard`.
- Laporan ringkasan melalui endpoint `GET /api/v1/reports/summary?from=YYYY-MM-DD&to=YYYY-MM-DD`.

## Setup lokal

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
```

> Catatan: dependency tidak ikut dikomit. Jalankan `composer install` di lingkungan dengan akses Packagist.

## Android client skeleton

Folder `android/` berisi skeleton aplikasi Android Kotlin dengan Retrofit client untuk endpoint inti. Setelah backend berjalan, atur `baseUrl` pada pemanggilan `ApiClient.create(...)` sesuai alamat server Laravel.
