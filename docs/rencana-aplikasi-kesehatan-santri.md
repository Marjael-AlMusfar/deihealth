# Rencana Aplikasi Pemantauan Santri Sakit, Manajemen Obat, dan Laporan

## 1. Ringkasan Produk

Aplikasi ini terdiri dari dua kanal utama:

- **Aplikasi Android** untuk petugas kesehatan/asrama agar dapat mencatat kondisi santri sakit, pemberian obat, kunjungan, dan tindak lanjut secara cepat dari lingkungan pesantren.
- **Web Laravel** untuk admin, klinik pesantren, pengurus, dan pimpinan agar dapat mengelola master data, memantau kasus sakit, mengatur stok obat, serta menghasilkan laporan lengkap.

Tujuan utama sistem adalah menyediakan pencatatan kesehatan santri yang terpusat, akurat, mudah diaudit, dan dapat digunakan sebagai dasar pengambilan keputusan oleh pengelola pesantren.

## 2. Sasaran Pengguna

| Peran | Kanal Utama | Kebutuhan Utama |
| --- | --- | --- |
| Admin Sistem | Web Laravel | Mengatur pengguna, hak akses, master data, dan konfigurasi aplikasi. |
| Petugas Kesehatan/Klinik | Android & Web | Mencatat pemeriksaan, diagnosis awal, tindakan, resep, pemberian obat, dan rujukan. |
| Musyrif/Wali Asrama | Android | Melaporkan santri sakit, memantau status santri binaan, dan mencatat observasi harian. |
| Pengurus Pesantren | Web | Melihat dashboard, tren penyakit, laporan stok obat, dan laporan periodik. |
| Wali Santri/Orang Tua | Web/Mobile opsional | Menerima ringkasan kondisi dan riwayat kesehatan santri sesuai kebijakan pesantren. |

## 3. Modul Utama

### 3.1 Manajemen Santri

- Data identitas santri: NIS, nama, jenis kelamin, tanggal lahir, kelas, kamar/asrama, angkatan, dan status aktif.
- Data wali santri: nama, nomor telepon, alamat, dan kontak darurat.
- Riwayat alergi, penyakit bawaan, catatan medis penting, dan pantangan obat.
- Import data santri dari Excel/CSV.
- Pencarian dan filter berdasarkan nama, NIS, kelas, asrama, dan status kesehatan.

### 3.2 Pelaporan Santri Sakit

- Form laporan cepat dari musyrif/petugas asrama.
- Data yang dicatat:
  - santri terkait,
  - tanggal dan jam keluhan,
  - gejala utama,
  - suhu tubuh,
  - tingkat urgensi,
  - lokasi santri,
  - foto pendukung bila diperlukan,
  - pelapor.
- Status kasus: `dilaporkan`, `diperiksa`, `dalam pemantauan`, `sembuh`, `dirujuk`, atau `ditutup`.
- Notifikasi ke petugas kesehatan saat ada laporan baru atau kasus prioritas tinggi.

### 3.3 Pemeriksaan dan Rekam Kesehatan Ringkas

- Catatan pemeriksaan awal dan lanjutan.
- Pencatatan tanda vital: suhu, tekanan darah, nadi, saturasi oksigen, berat badan, dan catatan umum.
- Diagnosis awal atau klasifikasi penyakit.
- Tindakan yang diberikan di klinik pesantren.
- Lampiran dokumen/foto hasil pemeriksaan.
- Riwayat kunjungan per santri.
- Catatan rujukan ke puskesmas/rumah sakit.

### 3.4 Manajemen Obat

- Master obat:
  - nama obat,
  - kategori,
  - satuan,
  - dosis umum,
  - indikasi,
  - kontraindikasi,
  - batas stok minimum,
  - status aktif/nonaktif.
- Manajemen stok:
  - stok masuk,
  - stok keluar,
  - koreksi stok,
  - batch/nomor produksi,
  - tanggal kedaluwarsa,
  - lokasi penyimpanan.
- Peringatan stok minimum.
- Peringatan obat mendekati kedaluwarsa.
- Kartu stok dan riwayat mutasi obat.

### 3.5 Resep dan Jadwal Pemberian Obat

- Pembuatan resep berdasarkan hasil pemeriksaan.
- Detail resep:
  - obat,
  - dosis,
  - frekuensi,
  - durasi,
  - aturan pakai,
  - catatan khusus.
- Jadwal pemberian obat otomatis berdasarkan frekuensi.
- Checklist pemberian obat oleh petugas.
- Status pemberian: `terjadwal`, `diberikan`, `terlewat`, `ditolak`, atau `dihentikan`.
- Catatan efek samping atau keluhan setelah minum obat.
- Pengurangan stok otomatis ketika obat diberikan atau resep ditebus sesuai kebijakan sistem.

### 3.6 Pemantauan Harian Santri Sakit

- Daftar santri yang sedang sakit dan perlu observasi.
- Catatan perkembangan harian.
- Monitoring gejala, suhu, kepatuhan minum obat, nafsu makan, istirahat, dan aktivitas.
- Penanda kasus yang belum diperiksa ulang dalam periode tertentu.
- Riwayat perubahan status kesehatan.

### 3.7 Dashboard

Dashboard web untuk pengurus dan admin menampilkan:

- jumlah santri sakit hari ini,
- kasus aktif berdasarkan tingkat urgensi,
- penyakit/gejala terbanyak,
- santri yang dirujuk,
- stok obat kritis,
- obat kedaluwarsa atau mendekati kedaluwarsa,
- grafik tren sakit harian, mingguan, dan bulanan,
- performa tindak lanjut laporan.

Dashboard Android untuk petugas menampilkan:

- laporan baru,
- jadwal obat hari ini,
- daftar santri yang perlu dipantau,
- kasus prioritas tinggi,
- ringkasan stok obat penting.

### 3.8 Laporan Lengkap

Laporan dapat difilter berdasarkan periode, kelas, asrama, jenis kelamin, penyakit/gejala, petugas, dan status kasus.

Jenis laporan:

1. **Laporan Santri Sakit**
   - daftar kasus sakit,
   - durasi sakit,
   - status akhir,
   - petugas penanganan.

2. **Laporan Rekam Pemeriksaan**
   - riwayat pemeriksaan per santri,
   - tindakan yang diberikan,
   - diagnosis awal,
   - hasil pemantauan.

3. **Laporan Obat**
   - stok awal,
   - stok masuk,
   - stok keluar,
   - stok akhir,
   - obat paling banyak digunakan,
   - obat kedaluwarsa.

4. **Laporan Pemberian Obat**
   - jadwal obat,
   - kepatuhan pemberian,
   - obat terlewat,
   - catatan efek samping.

5. **Laporan Rujukan**
   - santri dirujuk,
   - fasilitas tujuan,
   - alasan rujukan,
   - hasil tindak lanjut.

6. **Laporan Analitik Kesehatan**
   - tren penyakit per periode,
   - sebaran kasus per asrama/kelas,
   - indikator kejadian luar biasa,
   - rekomendasi tindak lanjut berbasis data.

Output laporan:

- tampilan web interaktif,
- export PDF,
- export Excel,
- rekap otomatis bulanan,
- opsi kirim laporan melalui email/WhatsApp gateway bila tersedia.

## 4. Rancangan Teknologi

### 4.1 Backend Web Laravel

- Laravel 11/12 sesuai kesiapan proyek.
- REST API untuk aplikasi Android.
- Laravel Sanctum atau Passport untuk autentikasi API.
- Role & permission menggunakan Spatie Laravel Permission.
- Queue untuk notifikasi, export laporan, dan pekerjaan latar belakang.
- Laravel Scheduler untuk pengingat obat, stok minimum, dan obat kedaluwarsa.
- Database MySQL atau PostgreSQL.
- Redis opsional untuk cache dan queue.

### 4.2 Android

- Kotlin sebagai bahasa utama.
- Arsitektur MVVM.
- Retrofit/OkHttp untuk komunikasi API.
- Room Database untuk cache/offline mode terbatas.
- WorkManager untuk sinkronisasi data dan pengingat jadwal obat.
- Firebase Cloud Messaging atau notifikasi internal untuk notifikasi push.

### 4.3 Web Frontend

Pilihan implementasi:

- Laravel Blade + Alpine.js untuk pengembangan cepat dan sederhana.
- Laravel Livewire untuk dashboard dan form interaktif.
- Inertia.js + Vue/React bila membutuhkan SPA yang lebih kompleks.

Rekomendasi awal: **Laravel Blade/Livewire** agar modul administrasi, laporan, dan dashboard cepat dibangun serta mudah dirawat.

## 5. Rancangan Hak Akses

| Modul | Admin | Petugas Kesehatan | Musyrif | Pengurus | Wali Santri |
| --- | --- | --- | --- | --- | --- |
| Master santri | CRUD | Lihat | Lihat terbatas | Lihat | Lihat anak sendiri |
| Laporan sakit | CRUD | CRUD | Buat & lihat laporan sendiri/asrama | Lihat | Lihat ringkasan |
| Pemeriksaan | CRUD | CRUD | Lihat terbatas | Lihat | Lihat ringkasan |
| Manajemen obat | CRUD | CRUD | Tidak | Lihat laporan | Tidak |
| Pemberian obat | CRUD | CRUD | Checklist sesuai tugas | Lihat | Ringkasan |
| Dashboard | Semua | Operasional | Asrama | Manajemen | Terbatas |
| Export laporan | Semua | Sesuai modul | Tidak | Semua laporan | Tidak |

## 6. Rancangan Data Inti

Entitas utama yang perlu disiapkan:

- `users`
- `roles` dan `permissions`
- `students`
- `guardians`
- `dormitories`
- `classes`
- `health_reports`
- `medical_examinations`
- `vital_signs`
- `diagnoses`
- `medicines`
- `medicine_batches`
- `medicine_stock_movements`
- `prescriptions`
- `prescription_items`
- `medication_schedules`
- `medication_administrations`
- `daily_observations`
- `referrals`
- `attachments`
- `notifications`
- `audit_logs`

## 7. Alur Kerja Utama

### 7.1 Alur Laporan Santri Sakit

1. Musyrif membuka aplikasi Android.
2. Musyrif memilih santri dan mengisi keluhan.
3. Sistem membuat kasus dengan status `dilaporkan`.
4. Petugas kesehatan menerima notifikasi.
5. Petugas melakukan pemeriksaan dan memperbarui status kasus.
6. Jika perlu, petugas membuat resep dan jadwal obat.
7. Santri dipantau hingga status menjadi `sembuh`, `dirujuk`, atau `ditutup`.

### 7.2 Alur Pemberian Obat

1. Petugas membuat resep dari hasil pemeriksaan.
2. Sistem membuat jadwal pemberian obat.
3. Petugas menerima daftar jadwal harian.
4. Saat obat diberikan, petugas melakukan checklist.
5. Sistem mencatat waktu, petugas, status pemberian, dan catatan.
6. Stok obat berkurang sesuai aturan.
7. Data masuk ke laporan pemberian obat dan laporan stok.

### 7.3 Alur Laporan Bulanan

1. Admin/pengurus memilih periode laporan.
2. Sistem menampilkan rekap kasus, obat, rujukan, dan tren penyakit.
3. Pengguna memfilter data sesuai kebutuhan.
4. Pengguna mengekspor laporan ke PDF atau Excel.
5. Sistem menyimpan riwayat export untuk audit.

## 8. Prioritas Pengembangan

### Fase 1 — Fondasi dan MVP

- Setup Laravel, database, autentikasi, role & permission.
- Master data santri, kelas, asrama, dan pengguna.
- API autentikasi untuk Android.
- Modul laporan santri sakit.
- Modul pemeriksaan dasar.
- Dashboard sederhana kasus aktif.

### Fase 2 — Obat dan Pemantauan

- Master obat dan stok obat.
- Resep dan jadwal pemberian obat.
- Checklist pemberian obat di Android.
- Pemantauan harian santri sakit.
- Notifikasi laporan baru dan jadwal obat.

### Fase 3 — Laporan dan Analitik

- Laporan santri sakit.
- Laporan pemeriksaan.
- Laporan stok dan pemakaian obat.
- Laporan pemberian obat.
- Export PDF dan Excel.
- Grafik tren penyakit dan kasus per asrama/kelas.

### Fase 4 — Penyempurnaan

- Offline mode terbatas di Android.
- Audit log lengkap.
- Integrasi WhatsApp/email gateway.
- Portal wali santri bila dibutuhkan.
- Optimasi performa dashboard dan laporan.

## 9. Non-Functional Requirements

- Data kesehatan hanya dapat diakses oleh pengguna berwenang.
- Semua perubahan data penting tercatat di audit log.
- API menggunakan HTTPS di production.
- Password disimpan menggunakan hashing standar Laravel.
- Backup database terjadwal.
- Validasi input di sisi Android dan Laravel.
- Laporan besar diproses melalui queue agar tidak mengganggu performa aplikasi.
- Sistem menyediakan pagination, search, dan filter untuk semua daftar besar.

## 10. Risiko dan Mitigasi

| Risiko | Dampak | Mitigasi |
| --- | --- | --- |
| Data santri tidak rapi | Laporan tidak akurat | Sediakan import template dan validasi data. |
| Petugas lupa checklist obat | Kepatuhan obat tidak tercatat | Notifikasi jadwal dan daftar tugas harian. |
| Stok obat tidak sinkron | Stok fisik berbeda dengan sistem | Audit stok berkala dan fitur koreksi stok. |
| Internet tidak stabil | Android sulit mencatat laporan | Cache lokal dan sinkronisasi saat koneksi tersedia. |
| Akses data sensitif bocor | Masalah privasi | Role permission, audit log, dan pembatasan data wali santri. |

## 11. Deliverable yang Disarankan

- Dokumen kebutuhan sistem.
- Desain database ERD.
- Desain UI/UX Android dan web.
- Backend Laravel beserta REST API.
- Aplikasi Android petugas.
- Dashboard web admin/pengurus.
- Modul laporan PDF/Excel.
- Dokumentasi API.
- Panduan pengguna dan panduan admin.

## 12. Status Implementasi Saat Ini

Implementasi lanjutan sudah mencakup API autentikasi token, CRUD data inti, pembuatan resep dengan jadwal obat otomatis, observasi harian, rujukan, audit log, dashboard ringkas, laporan summary, export CSV laporan santri sakit, dan skeleton Android yang dapat memanggil endpoint inti.

Item yang masih perlu dikerjakan sebelum production meliputi UI web admin lengkap, UI Android produksi, registrasi middleware sesuai bootstrap Laravel final, seed data admin, export PDF/Excel yang kaya format, notifikasi push/WhatsApp, offline mode Android, test end-to-end, CI/CD, dan hardening deployment.
