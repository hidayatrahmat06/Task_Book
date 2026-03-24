# User Acceptance Testing (UAT) Document

Project: Sistem Manajemen Perpustakaan Digital  
Version: 1.0  
UAT Date: ____________________  
Prepared by: ____________________  
Approved by: ____________________

## 1. Purpose

Dokumen UAT ini memastikan Sistem Manajemen Perpustakaan Digital memenuhi kebutuhan pengguna akhir sebelum dipakai secara penuh. Pengujian dilakukan dari sudut pandang pengguna (anggota dan admin), bukan dari sudut pandang developer.

## 2. User Roles

| Role | Description |
|------|-------------|
| Anggota (Member) | Pengguna yang mendaftar, melihat katalog, meminjam, dan mengembalikan buku |
| Admin | Pengguna yang mengelola data buku dan transaksi peminjaman |

## 3. Test Environment

| Item | Value |
|------|-------|
| Application URL | http://task_book.test (sesuaikan dengan environment Anda) |
| Browser | Chrome / Firefox / Safari (versi terbaru) |
| Test Date | ____________________ |
| Tester Name | ____________________ |
| Seed Data | Jalankan `php artisan migrate:fresh --seed` |

### Akun Uji (Berdasarkan Seeder)

- Admin: `admin@library.com` / `Admin123!`
- Member: `budi@example.com` / `password123`

## 4. UAT Test Cases

Cara mengisi hasil:
- Pass: fitur berjalan sesuai expected result.
- Fail: fitur tidak berjalan sesuai expected result (jelaskan pada Comments).
- N/A: tidak diuji pada sesi ini.

### 4.1 Authentication & Session

#### UAT-01 - Registrasi Anggota Baru

| Field | Detail |
|------|--------|
| Scenario | Sebagai calon anggota, saya dapat membuat akun baru dan langsung masuk ke sistem |
| Steps | 1. Buka halaman `/register`.<br>2. Isi semua field valid (nama, email unik, telepon, alamat, password, konfirmasi password).<br>3. Klik tombol `Buat Akun`. |
| Expected | User berhasil dibuat dengan role `member`, otomatis login, redirect ke dashboard, dan tampil pesan sukses registrasi. |
| Result | [ ] Pass  [ ] Fail  [ ] N/A |
| Comments | |

#### UAT-02 - Login Berhasil (Admin dan Member)

| Field | Detail |
|------|--------|
| Scenario | Sebagai pengguna terdaftar, saya dapat login dengan kredensial yang benar |
| Steps | 1. Buka halaman `/login`.<br>2. Login sebagai admin (`admin@library.com`).<br>3. Logout.<br>4. Login sebagai member (`budi@example.com`). |
| Expected | Login sukses, session terbentuk, redirect ke `/dashboard`, dan menu tampil sesuai role pengguna. |
| Result | [ ] Pass  [ ] Fail  [ ] N/A |
| Comments | |

#### UAT-03 - Login Gagal dengan Kredensial Salah

| Field | Detail |
|------|--------|
| Scenario | Sebagai pengguna, saya mendapatkan pesan error saat email/password salah |
| Steps | 1. Buka `/login`.<br>2. Isi email valid namun password salah.<br>3. Klik `Masuk`. |
| Expected | Login ditolak dan muncul pesan: `Email atau password tidak sesuai.` |
| Result | [ ] Pass  [ ] Fail  [ ] N/A |
| Comments | |

### 4.2 Katalog Buku (Member)

#### UAT-04 - Cari Buku Berdasarkan Judul/Penulis

| Field | Detail |
|------|--------|
| Scenario | Sebagai anggota, saya dapat mencari buku dengan cepat |
| Steps | 1. Login sebagai member.<br>2. Buka `/books`.<br>3. Isi kolom pencarian dengan kata kunci judul atau penulis.<br>4. Klik `Cari`. |
| Expected | Daftar buku terfilter sesuai kata kunci pada judul atau penulis. |
| Result | [ ] Pass  [ ] Fail  [ ] N/A |
| Comments | |

#### UAT-05 - Filter Kategori dan Sort Buku

| Field | Detail |
|------|--------|
| Scenario | Sebagai anggota, saya bisa menyaring dan mengurutkan daftar buku |
| Steps | 1. Pada halaman `/books`, pilih kategori tertentu.<br>2. Uji urutan `Terbaru`, `Terlama`, dan `Paling Sering Dipinjam`.<br>3. Klik `Cari`. |
| Expected | Data buku menyesuaikan kategori dan urutan yang dipilih. |
| Result | [ ] Pass  [ ] Fail  [ ] N/A |
| Comments | |

#### UAT-06 - Lihat Detail Buku

| Field | Detail |
|------|--------|
| Scenario | Sebagai anggota, saya bisa melihat informasi detail buku sebelum meminjam |
| Steps | 1. Dari `/books`, klik ikon `Lihat Detail` pada salah satu buku. |
| Expected | Halaman detail menampilkan judul, penulis, ISBN, kategori, penerbit, tahun, deskripsi (jika ada), status stok, dan statistik peminjaman. |
| Result | [ ] Pass  [ ] Fail  [ ] N/A |
| Comments | |

### 4.3 Proses Peminjaman & Pengembalian (Member)

#### UAT-07 - Pinjam Buku dengan Stok Tersedia

| Field | Detail |
|------|--------|
| Scenario | Sebagai anggota, saya bisa meminjam buku yang tersedia |
| Steps | 1. Login sebagai member.<br>2. Buka `/borrowings/create`.<br>3. Pilih buku dengan stok > 0.<br>4. Klik `Pinjam`. |
| Expected | Transaksi peminjaman berhasil dibuat, stok buku berkurang 1, dan tampil pesan sukses berisi tanggal tenggat (14 hari). |
| Result | [ ] Pass  [ ] Fail  [ ] N/A |
| Comments | |

#### UAT-08 - Cegah Peminjaman Ganda Buku yang Sama

| Field | Detail |
|------|--------|
| Scenario | Sebagai anggota, saya tidak boleh meminjam buku yang sama saat status pinjam masih aktif |
| Steps | 1. Pinjam 1 buku sampai status `borrowed`.<br>2. Coba pinjam buku yang sama lagi sebelum dikembalikan. |
| Expected | Sistem menolak transaksi dan menampilkan error bahwa anggota sudah meminjam buku tersebut dan belum mengembalikan. |
| Result | [ ] Pass  [ ] Fail  [ ] N/A |
| Comments | |

#### UAT-09 - Pengembalian Tepat Waktu (Tanpa Denda)

| Field | Detail |
|------|--------|
| Scenario | Sebagai anggota, saya dapat mengembalikan buku sebelum jatuh tempo |
| Steps | 1. Buka detail peminjaman aktif (`/borrowings/{id}`).<br>2. Klik `Kembalikan Buku` sebelum due date. |
| Expected | Status berubah menjadi `returned`, stok buku bertambah 1, `fine_amount` tetap 0, dan muncul pesan `Buku berhasil dikembalikan.` |
| Result | [ ] Pass  [ ] Fail  [ ] N/A |
| Comments | |

#### UAT-10 - Pengembalian Terlambat Menghitung Denda

| Field | Detail |
|------|--------|
| Scenario | Sebagai anggota/admin, denda dihitung otomatis untuk pengembalian melewati due date |
| Steps | 1. Gunakan data peminjaman yang sudah melewati due date.<br>2. Klik `Kembalikan Buku`. |
| Expected | Sistem menghitung denda `Rp 1.000 x jumlah hari terlambat`, status menjadi `returned`, dan pesan sukses memuat nominal denda. |
| Result | [ ] Pass  [ ] Fail  [ ] N/A |
| Comments | |

### 4.4 Manajemen Buku (Admin)

#### UAT-11 - Tambah Buku Baru

| Field | Detail |
|------|--------|
| Scenario | Sebagai admin, saya dapat menambah buku baru ke katalog |
| Steps | 1. Login sebagai admin.<br>2. Buka `/books/create`.<br>3. Isi field wajib valid (judul, penulis, ISBN unik, kategori, penerbit, tahun, stok).<br>4. Klik simpan. |
| Expected | Buku baru tersimpan, muncul pesan `Buku berhasil ditambahkan.`, dan data tampil di daftar buku. |
| Result | [ ] Pass  [ ] Fail  [ ] N/A |
| Comments | |

#### UAT-12 - Validasi ISBN Unik Saat Tambah Buku

| Field | Detail |
|------|--------|
| Scenario | Sebagai admin, saya tidak dapat menambah buku dengan ISBN duplikat |
| Steps | 1. Buka form tambah buku.<br>2. Isi ISBN yang sudah ada di database.<br>3. Submit form. |
| Expected | Data gagal disimpan dan muncul error validasi `ISBN sudah terdaftar di sistem.` |
| Result | [ ] Pass  [ ] Fail  [ ] N/A |
| Comments | |

#### UAT-13 - Hapus Buku Ditolak Jika Masih Dipinjam

| Field | Detail |
|------|--------|
| Scenario | Sebagai admin, saya tidak bisa menghapus buku yang masih memiliki peminjaman aktif |
| Steps | 1. Pilih buku yang punya borrowing status `borrowed` atau `overdue`.<br>2. Klik `Hapus` pada daftar/detail buku. |
| Expected | Penghapusan ditolak dan muncul pesan `Buku tidak dapat dihapus karena masih sedang dipinjam.` |
| Result | [ ] Pass  [ ] Fail  [ ] N/A |
| Comments | |

### 4.5 Manajemen Peminjaman (Admin)

#### UAT-14 - Admin Melihat Semua Transaksi

| Field | Detail |
|------|--------|
| Scenario | Sebagai admin, saya bisa memonitor seluruh transaksi peminjaman |
| Steps | 1. Login sebagai admin.<br>2. Buka `/borrowings`. |
| Expected | Tabel menampilkan semua transaksi dari seluruh anggota, termasuk kolom anggota, buku, tanggal, status, denda, dan aksi. |
| Result | [ ] Pass  [ ] Fail  [ ] N/A |
| Comments | |

#### UAT-15 - Admin Pinjamkan Buku untuk Anggota

| Field | Detail |
|------|--------|
| Scenario | Sebagai admin, saya dapat membuat peminjaman atas nama anggota |
| Steps | 1. Buka `/borrowings/create` sebagai admin.<br>2. Pilih anggota dari dropdown `Pilih Anggota`.<br>3. Pilih buku tersedia dan klik `Pinjam`. |
| Expected | Transaksi tercatat atas nama anggota yang dipilih (bukan admin), stok buku berkurang, dan transaksi muncul pada daftar peminjaman admin. |
| Result | [ ] Pass  [ ] Fail  [ ] N/A |
| Comments | |

#### UAT-16 - Admin Hapus Record Peminjaman

| Field | Detail |
|------|--------|
| Scenario | Sebagai admin, saya dapat menghapus record peminjaman yang tidak diperlukan |
| Steps | 1. Buka `/borrowings`.<br>2. Pilih salah satu transaksi.<br>3. Klik `Hapus` dan konfirmasi. |
| Expected | Record terhapus, tampil pesan `Record peminjaman berhasil dihapus.`, dan jika status belum `returned` maka stok buku otomatis bertambah 1. |
| Result | [ ] Pass  [ ] Fail  [ ] N/A |
| Comments | |

### 4.6 Access Control

#### UAT-17 - Member Tidak Bisa Akses Halaman Admin Buku

| Field | Detail |
|------|--------|
| Scenario | Sebagai member, saya tidak boleh mengakses endpoint admin |
| Steps | 1. Login sebagai member.<br>2. Akses `/books/create` secara langsung dari URL. |
| Expected | User diarahkan ke dashboard dan tampil pesan `Anda tidak memiliki akses untuk halaman ini.` |
| Result | [ ] Pass  [ ] Fail  [ ] N/A |
| Comments | |

#### UAT-18 - Member Tidak Bisa Melihat Peminjaman User Lain

| Field | Detail |
|------|--------|
| Scenario | Sebagai member, saya hanya bisa melihat detail peminjaman milik sendiri |
| Steps | 1. Login sebagai member A.<br>2. Coba buka URL detail borrowing milik member B (`/borrowings/{id}`). |
| Expected | Akses ditolak oleh policy (HTTP 403 atau halaman forbidden), data milik user lain tidak ditampilkan. |
| Result | [ ] Pass  [ ] Fail  [ ] N/A |
| Comments | |

## 5. Overall UAT Sign-Off

| # | UAT Case | Pass/Fail |
|---|----------|-----------|
| UAT-01 | Registrasi anggota baru | |
| UAT-02 | Login berhasil (admin/member) | |
| UAT-03 | Login gagal dengan kredensial salah | |
| UAT-04 | Cari buku judul/penulis | |
| UAT-05 | Filter kategori dan sort buku | |
| UAT-06 | Lihat detail buku | |
| UAT-07 | Pinjam buku stok tersedia | |
| UAT-08 | Cegah peminjaman ganda | |
| UAT-09 | Pengembalian tepat waktu | |
| UAT-10 | Pengembalian terlambat dengan denda | |
| UAT-11 | Admin tambah buku | |
| UAT-12 | Validasi ISBN unik | |
| UAT-13 | Tolak hapus buku yang masih dipinjam | |
| UAT-14 | Admin lihat semua transaksi | |
| UAT-15 | Admin pinjamkan untuk anggota | |
| UAT-16 | Admin hapus record peminjaman | |
| UAT-17 | Member tidak bisa akses halaman admin | |
| UAT-18 | Member tidak bisa lihat borrowing user lain | |

## 6. Issues Found

| # | UAT Case | Description | Severity | Status |
|---|----------|-------------|----------|--------|
| 1 | | | Low / Medium / High / Critical | Open / In Progress / Closed |
| 2 | | | Low / Medium / High / Critical | Open / In Progress / Closed |
| 3 | | | Low / Medium / High / Critical | Open / In Progress / Closed |

## 7. Acceptance Decision

| Item | Value |
|------|-------|
| Total Test Cases | 18 |
| Passed | ______ |
| Failed | ______ |
| Overall Result | [ ] ACCEPTED  [ ] REJECTED  [ ] ACCEPTED WITH CONDITIONS |

Conditions (if any):  
____________________________________________________________________  
____________________________________________________________________

## 8. Sign-Off

| Role | Name | Signature | Date |
|------|------|-----------|------|
| Tester (User) | | | |
| Project Lead | | | |
| Admin Representative | | | |

