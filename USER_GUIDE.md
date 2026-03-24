# 👤 USER GUIDE - Panduan Pengguna Sistem Manajemen Perpustakaan

> Panduan lengkap untuk pengguna akhir sistem perpustakaan digital

**Versi:** 1.0.0  
**Last Updated:** 16 Maret 2026

---

## 📖 Daftar Isi

1. [Memulai](#memulai)
2. [Login Akun](#login-akun)
3. [Dashboard](#dashboard)
4. [Meminjam Buku](#meminjam-buku)
5. [Mengembalikan Buku](#mengembalikan-buku)
6. [Kelola Buku (Admin Only)](#kelola-buku-admin-only)
7. [FAQ](#faq)

---

## 🚀 Memulai

### Akses Sistem

1. Buka browser Anda
2. Masukkan URL: `http://localhost:8000` (development) atau `https://perpustakaan.local` (production)
3. Anda akan melihat halaman **Welcome/Landing Page**

### Halaman Welcome

```
┌─────────────────────────────────────────┐
│  🎓 Sistem Manajemen Perpustakaan 📚    │
│                                         │
│  [Login]  [Register]                    │
│                                         │
│  Fitur Utama:                           │
│  • Cari & Temukan Buku                  │
│  • Peminjaman Online                    │
│  • Tracki Pengembalian                  │
└─────────────────────────────────────────┘
```

### Tombol Navigasi
- **Login** - Untuk pengguna terdaftar
- **Register** - Daftar akun baru sebagai member

---

## 🔐 Login Akun

### Langkah-Langkah Login

#### 1. Klik Tombol "Login"
```
1. Berada di halaman welcome
2. Klik tombol login (kanan atas atau di hero section)
3. Anda akan diarahkan ke halaman login
```

#### 2. Isi Form Login
```
Email:      (Masukkan email terdaftar)
Password:   (Masukkan password)
```

#### 3. Tekan "Login"
Sistem akan memverifikasi kredensial Anda.

### Akun Demo (Testing)

**Admin Account:**
```
Email:    admin@library.com
Password: Admin123!
Role:     Administrator
```

**Member Accounts (Pilih salah satu):**
```
Account 1:
Email:    budi@example.com
Password: Password123

Account 2:
Email:    siti@example.com
Password: Password123

Account 3:
Email:    andi@example.com
Password: Password123

Account 4:
Email:    rini@example.com
Password: Password123

Account 5:
Email:    hendra@example.com
Password: Password123
```

### Registrasi Akun Baru

Jika Anda belum memiliki akun:

1. **Klik "Register"** dari halaman login atau welcome
2. **Isi form dengan data Anda:**
   - Nama Lengkap
   - Email
   - Nomor Telepon
   - Alamat
   - Password (minimal 8 karakter)
   - Konfirmasi Password

3. **Klik "Register"** untuk membuat akun baru
4. Anda akan otomatis login sebagai **Member**

> **Catatan:** Akun baru otomatis dibuat sebagai Member (tidak Admin)

---

## 📊 Dashboard

### Dashboard Admin

Setelah login sebagai Admin, Anda akan melihat:

```
┌──────────────────────────────────────────────┐
│  Dashboard Admin - Statistik Perpustakaan    │
├──────────────────────────────────────────────┤
│                                              │
│  📚 Total Buku      : 10 buku                │
│  👥 Total Member    : 5 member               │
│  📋 Total Pinjaman  : 5 pinjaman             │
│  ⏰ Overdue Books   : 1 pinjaman             │
│  💰 Total Denda     : Rp 6.000               │
│                                              │
├─ Tabel: Buku Paling Baru ────────────────────┤
│ [Laskar Pelangi] [Negeri 5 Menara] ...       │
│                                              │
├─ Tabel: Peminjaman Terbaru ──────────────────┤
│ Budi → Laskar Pelangi | Status: Borrowed    │
│ Siti → Filosofi Teras | Status: Borrowed    │
│ ...                                          │
│                                              │
├─ Tabel: Pinjaman Terlambat ──────────────────┤
│ Hendra → Kaya Mulai... | Fine: Rp 6.000    │
│ ...                                          │
└──────────────────────────────────────────────┘
```

**Fitur Admin:**
- 📊 Lihat statistik keseluruhan
- 📚 Manajemen koleksi buku (CRUD)
- 👥 Monitor peminjaman member
- 💰 Track denda yang belum dibayar
- 🔍 Search & filter data

---

### Dashboard Member

Setelah login sebagai Member, Anda akan melihat:

```
┌──────────────────────────────────────────────┐
│  Dashboard Member - Profil & Aktivitas       │
├──────────────────────────────────────────────┤
│                                              │
│  Profil Anda:                                │
│  Nama: Budi Santoso                          │
│  Email: budi@example.com                     │
│  Nomor Member: #MEM-001                      │
│  Member Sejak: 1 Januari 2026                │
│                                              │
│  📊 Statistik Aktivitas:                     │
│  ┌─────────────────────────────────────┐    │
│  │ Pinjaman Aktif   : 1 buku          │    │
│  │ Pinjaman Selesai : 0 buku          │    │
│  │ Total Denda      : Rp 0            │    │
│  └─────────────────────────────────────┘    │
│                                              │
│  [Cari Buku]  [Lihat Pinjaman Saya]        │
│                                              │
├─ Pinjaman Aktif: ────────────────────────────┤
│ 📚 Laskar Pelangi                           │
│    Dipinjam: 10 Maret 2026                  │
│    Deadline: 17 Maret 2026                  │
│    Status:   Borrowed (6 hari tersisa)      │
│    [Kembalikan]                             │
│                                              │
└──────────────────────────────────────────────┘
```

**Fitur Member:**
- 👤 Lihat profil & statistik aktivitas
- 📚 Cari & browse buku
- 📋 Lihat riwayat peminjaman
- 💰 Monitor denda yang belum dibayar
- ✏️ Update profil

---

## 📚 Meminjam Buku

### Langkah-Langkah Peminjaman

#### 1. Masuk ke Halaman Daftar Buku
```
Dari dashboard → Klik "Buku" atau "Cari Buku"
```

#### 2. Cari Buku yang Ingin Dipinjam
```
┌──────────────────────────────────────┐
│ Cari: [_______________] 🔍           │
│ Kategori: [All ▼] [Fiksi ▼] ...      │
│ Status: [All ▼] [Available ▼]        │
│ Sort: [Terbaru ▼]                    │
└──────────────────────────────────────┘
```

**Opsi Pencarian:**
- **Cari Teks** - Cari judul, penulis, ISBN
- **Filter Kategori** - Fiksi, Non-Fiksi, Sains & Teknologi
- **Filter Status** - Available (stok tersedia), Out of Stock
- **Sort** - Terbaru, Terpopuler, Judul (A-Z)

#### 3. Pilih Buku dari Daftar
```
┌──────────────────────────────────────┐
│ 📚 Laskar Pelangi                    │
│    Penulis: Andrea Hirata            │
│    Status: ✅ Available (4 copies)   │
│    [Lihat Detail] [Pinjam]           │
└──────────────────────────────────────┘
```

#### 4. Konfirmasi Peminjaman
```
┌──────────────────────────────────────┐
│ Konfirmasi Peminjaman                │
├──────────────────────────────────────┤
│ Buku: Laskar Pelangi                 │
│ Tanggal Pinjam: 16 Maret 2026        │
│ Tanggal Jatuh Tempo: 23 Maret 2026   │
│ Durasi: 7 hari                       │
│ Denda Keterlambatan: Rp 1.000/hari   │
│                                      │
│ [Batal]  [Konfirmasi Pinjam]        │
└──────────────────────────────────────┘
```

#### 5. Peminjaman Berhasil ✅
```
Anda akan menerima pesan:
"✅ Peminjaman berhasil! 
Buku 'Laskar Pelangi' siap dipinjam.
Jatuh tempo: 23 Maret 2026"
```

---

### Lihat Detail Buku

Sebelum meminjam, Anda bisa lihat detail:

```
┌────────────────────────────────────────────┐
│ Detail Buku                                │
├────────────────────────────────────────────┤
│                                            │
│ [Cover Image]  📚 Laskar Pelangi          │
│                                            │
│ Penulis:       Andrea Hirata              │
│ Penerbit:      Bentang Pustaka            │
│ Tahun:         2005                       │
│ ISBN:          978-602-7310-XX-X          │
│ Kategori:      Fiksi                      │
│ Stok:          4 copies                   │
│ Status:        ✅ Available                │
│                                            │
│ Deskripsi:                                │
│ Laskar Pelangi adalah novel karya        │
│ Andrea Hirata... (deskripsi panjang)     │
│                                            │
│ [Kembali]  [Pinjam Buku]                 │
│                                            │
└────────────────────────────────────────────┘
```

---

## 📖 Mengembalikan Buku

### Langkah-Langkah Pengembalian

#### 1. Buka "Pinjaman Saya"
```
Dashboard → Klik "Pinjaman Saya" atau 
Menu Sidebar → Borrowings
```

#### 2. Lihat Daftar Pinjaman Aktif
```
┌────────────────────────────────────────────┐
│ Pinjaman Aktif                             │
├────────────────────────────────────────────┤
│                                            │
│ 📚 Laskar Pelangi                         │
│ Status: Borrowed (Biru)                   │
│ Tanggal Pinjam: 10 Maret 2026             │
│ Jatuh Tempo: 17 Maret 2026                │
│ Sisa Hari: 1 hari                         │
│ Denda: Rp 0                               │
│ [Detail] [Kembalikan]                     │
│                                            │
└────────────────────────────────────────────┘
```

#### 3. Klik "Kembalikan"
Tombol kembalikan akan terbuka dialog konfirmasi.

#### 4. Konfirmasi Pengembalian
```
┌────────────────────────────────────────────┐
│ Konfirmasi Pengembalian                    │
├────────────────────────────────────────────┤
│ Buku: Laskar Pelangi                       │
│ Dipinjam: 10 Maret 2026                    │
│ Dikembalikan: 16 Maret 2026                │
│ Status Pengembalian: ON TIME ✅             │
│ Denda Keterlambatan: Rp 0                  │
│                                            │
│ [Batal] [Konfirmasi Pengembalian]         │
└────────────────────────────────────────────┘
```

#### 5. Pengembalian Berhasil ✅
```
✅ Pengembalian berhasil!
Terima kasih telah mengembalikan "Laskar Pelangi"
Stok buku telah ditambahkan kembali.
```

---

### Status Peminjaman

| Status | Warna | Arti |
|--------|-------|------|
| **Borrowed** | 🔵 Biru | Sedang dipinjam, belum jatuh tempo |
| **Overdue** | 🔴 Merah | Sudah melewati jatuh tempo |
| **Returned** | 🟢 Hijau | Sudah dikembalikan |

### Denda Keterlambatan

```
Perhitungan Denda:
─────────────────────────
Denda per Hari = Rp 1.000
Maksimal Denda = Tergantung kebijakan

Contoh:
Jatuh Tempo: 23 Maret 2026
Dikembalikan: 29 Maret 2026
Keterlambatan: 6 hari
Denda: 6 × Rp 1.000 = Rp 6.000
```

---

## 🔧 Kelola Buku (Admin Only)

### Akses Manajemen Buku

Hanya **Admin** yang dapat:
- ✏️ Tambah buku baru
- 📝 Edit informasi buku
- 🗑️ Hapus buku
- 📊 Lihat statistik koleksi

```
Sidebar → Kelola Buku → 
  [Daftar Buku] [Tambah Buku Baru]
```

---

### 1. Melihat Daftar Buku

```
┌─────────────────────────────────────────────┐
│ Manajemen Buku                              │
├─────────────────────────────────────────────┤
│ [Tambah Buku Baru]                          │
│                                             │
│ Tabel:                                      │
│ No | Judul | Penulis | Kategori | Stok    │
│────────────────────────────────────────────│
│ 1  | Laskar... | Andrea | Fiksi | 4      │
│    | [Detail] [Edit] [Hapus]               │
│ 2  | Negeri 5... | Ahmad | Fiksi | 3     │
│    | [Detail] [Edit] [Hapus]               │
│ ...                                        │
└─────────────────────────────────────────────┘
```

---

### 2. Tambah Buku Baru

#### Form Input:
```
┌─────────────────────────────────────────────┐
│ Tambah Buku Baru                            │
├─────────────────────────────────────────────┤
│                                             │
│ Judul:           [________________]         │
│ Penulis:         [________________]         │
│ Penerbit:        [________________]         │
│ Tahun Terbit:    [________]                 │
│ ISBN:            [________________]         │
│ Kategori:        [Fiksi ▼]                  │
│ Stok:            [__] (jumlah copy)        │
│ Cover Gambar:    [Pilih File]              │
│ Deskripsi:       [__________________]     │
│                  [__________________]     │
│                                             │
│ [Batal] [Simpan Buku]                     │
└─────────────────────────────────────────────┘
```

#### Field yang Wajib Diisi:
- ✓ Judul
- ✓ Penulis
- ✓ ISBN (harus unik/berbeda)
- ✓ Kategori
- ✓ Penerbit
- ✓ Tahun Terbit
- ✓ Stok (minimal 1)
- Cover (opsional)
- Deskripsi (opsional)

---

### 3. Edit Buku Existing

1. Klik **[Edit]** di daftar buku
2. Form akan terisi dengan data saat ini
3. Ubah field yang diperlukan
4. Klik **[Update]** untuk simpan

```
┌─────────────────────────────────────────────┐
│ Edit Buku: Laskar Pelangi                   │
├─────────────────────────────────────────────┤
│                                             │
│ Judul:    [Laskar Pelangi       ]          │
│ Stok:     [4                     ]          │
│ (fields lainnya sudah terisi)               │
│                                             │
│ [Batal] [Update Buku]                      │
└─────────────────────────────────────────────┘
```

---

### 4. Hapus Buku

**Syarat Penghapusan:**
- ✓ Stok kosong (tidak sedang dipinjam)
- ✗ Tidak boleh hapus jika ada peminjaman aktif

```
Jika data tidak bisa dihapus:
❌ "Tidak bisa menghapus. Buku masih dipinjam.
    Tunggu hingga semua pinjaman selesai."
```

---

## ❓ FAQ

### Pertanyaan Umum

#### Q1: Berapa lama durasi peminjaman?
**A:** 7 hari dari tanggal peminjaman.

#### Q2: Apakah ada biaya peminjaman?
**A:** Tidak, peminjaman gratis. Hanya ada denda jika terlambat.

#### Q3: Berapa denda keterlambatan?
**A:** Rp 1.000 per hari setelah tanggal jatuh tempo.

#### Q4: Bisakah saya meminjam lebih dari 1 buku?
**A:** Ya, jumlah peminjaman tidak terbatas (sesuai kebijakan).

#### Q5: Bagaimana jika lupa password?
**A:** Hubungi admin untuk reset password (fitur akan ditambahkan).

#### Q6: Dapatkah saya memperpanjang peminjaman?
**A:** Feature sedang dalam pengembangan. Hubungi admin perpustakaan.

#### Q7: Bagaimana cara membayar denda?
**A:** Silakan ke perpustakaan atau hubungi admin untuk metode pembayaran.

#### Q8: Apa yang terjadi jika tidak mengembalikan buku?
**A:** Denda akan terus bertambah setiap hari hingga buku dikembalikan.

---

## 📞 Kontak Dukungan

- **Email:** support@perpustakaan.local
- **Telepon:** -
- **Jam Kerja:** Ketika aplikasi diakses
- **Admin:** Hubungi langsung di perpustakaan

---

## 💡 Tips & Trik

### ✅ Tips Menggunakan Sistem

1. **Manfaatkan Fitur Pencarian**
   - Gunakan search untuk menemukan buku dengan cepat
   - Filter berdasarkan kategori

2. **Cek Deadline Secara Berkala**
   - Monitor tanggal jatuh tempo peminjaman
   - Kembalikan tepat waktu untuk menghindari denda

3. **Update Profil**
   - Pastikan email dan nomor HP selalu aktif
   - Alamat diperlukan untuk notifikasi

4. **Print Bukti Peminjaman**
   - Simpan bukti peminjaman electronic
   - Berguna untuk referensi

---

**Last Updated:** 16 Maret 2026  
**Next Update:** 30 April 2026
