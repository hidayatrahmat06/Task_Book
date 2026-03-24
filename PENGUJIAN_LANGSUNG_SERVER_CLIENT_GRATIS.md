# Panduan Pengujian Langsung (Server + Client) Dengan Server Gratis

Dokumen ini untuk menjalankan pengujian langsung aplikasi Laravel Anda dari dua sisi:
- Server-side (validasi backend, database, route)
- Client-side (uji UI/UX dari device lain via URL publik gratis)

Referensi test case UAT: [UAT_PERPUSTAKAAN_DIGITAL.md](/Users/rahmat/Herd/task_book/UAT_PERPUSTAKAAN_DIGITAL.md)
Untuk deploy + manajemen penuh Google Cloud Console, lihat: [GCP_CLOUD_CONSOLE_PUBLISH_DAN_PENGUJIAN.md](/Users/rahmat/Herd/task_book/GCP_CLOUD_CONSOLE_PUBLISH_DAN_PENGUJIAN.md)

## 1. Persiapan

Jalankan dari root project:

```bash
cd /Users/rahmat/Herd/task_book
```

Pastikan dependency sudah ada:

```bash
composer install
npm install
```

## 2. Pengujian Server-Side (Backend)

### 2.0 Opsi Cepat (1 Perintah)

```bash
bash scripts/uat_smoke.sh
```

Script ini akan:
- reset DB + seed
- jalankan `php artisan test`
- start server lokal sebentar
- cek endpoint `/`, `/login`, `/register`

### 2.1 Reset DB + Seed Data Uji

```bash
php artisan migrate:fresh --seed
```

### 2.2 Jalankan Automated Test

```bash
php artisan test
```

Hasil yang diharapkan:
- Semua test `PASS`
- Tidak ada error koneksi DB

## 3. Jalankan Aplikasi untuk Uji Client

Gunakan salah satu:

### Opsi A (disarankan di Herd)

```bash
herd open
```

### Opsi B (manual php artisan serve)

```bash
php artisan serve --host=127.0.0.1 --port=8000
```

Jika pakai opsi B, URL lokal:
- http://127.0.0.1:8000

## 4. Share URL Publik Gratis (Untuk Uji Client Device Lain)

Fitur gratis ini memakai `herd share` (Expose tunnel).

Di terminal baru:

```bash
herd share
```

Catatan first run:
- Anda akan diminta login/create akun Expose gratis.
- Setelah login sukses, tunnel aktif dan menghasilkan URL publik HTTPS.

Untuk mengecek URL share aktif:

```bash
herd fetch-share-url
```

## 5. Pengujian Client-Side Langsung

1. Buka URL share di HP/laptop lain (beda jaringan juga bisa).
2. Login pakai akun uji:
   - Admin: `admin@library.com` / `Admin123!`
   - Member: `budi@example.com` / `password123`
3. Jalankan test case satu per satu sesuai dokumen UAT.
4. Isi kolom `Pass/Fail/N/A` dan `Comments` pada setiap test case.

## 6. Skenario UAT yang Wajib Dijalankan

Minimal jalankan:
1. `UAT-01` sampai `UAT-03` (auth)
2. `UAT-04` sampai `UAT-06` (katalog buku)
3. `UAT-07` sampai `UAT-10` (peminjaman/pengembalian)
4. `UAT-11` sampai `UAT-16` (admin management)
5. `UAT-17` sampai `UAT-18` (akses role/policy)

## 7. Monitoring Saat Pengujian

Lihat log realtime untuk mendeteksi error backend:

```bash
tail -f storage/logs/laravel.log
```

## 8. Penutupan Sesi Uji

Setelah selesai:

1. Hentikan server (`Ctrl + C` pada terminal server).
2. Hentikan tunnel share (`Ctrl + C` pada terminal `herd share`).
3. Simpan hasil pengujian di dokumen UAT.

## 9. Troubleshooting Cepat

### `herd fetch-share-url` menampilkan "There is no Expose instance running."
- Pastikan `herd share` masih berjalan di terminal lain.

### `herd share` berhenti di "Waiting for authentication..."
- Selesaikan login Expose di browser dari link yang diberikan.

### Login gagal walau kredensial benar
- Jalankan ulang:

```bash
php artisan migrate:fresh --seed
```
