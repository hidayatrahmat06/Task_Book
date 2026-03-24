# README - Tugas Akhir Rekayasa Perangkat Lunak
## Sistem Manajemen Tugas (Task Management System)

---

## 📋 DAFTAR ISI

1. [Pengenalan](#pengenalan)
2. [Struktur Folder](#struktur-folder)
3. [Teknologi yang Digunakan](#teknologi-yang-digunakan)
4. [Quick Start](#quick-start)
5. [Fitur Utama](#fitur-utama)
6. [File-File Penting](#file-file-penting)
7. [Catatan Penting](#catatan-penting)

---

## 📚 PENGENALAN

**Sistem Manajemen Tugas (Task Management System)** adalah aplikasi web yang dikembangkan sebagai tugas akhir mata kuliah Rekayasa Perangkat Lunak (RPL) program Magister Teknik Informatika.

### Tujuan Proyek
- Mengaplikasikan konsep Rekayasa Perangkat Lunak dalam pengembangan aplikasi
- Mengimplementasikan metodologi Agile/Scrum
- Menerapkan best practice web development
- Melakukan pengujian sistem dengan metode Black Box Testing

### Studi Kasus
Aplikasi ini merupakan sistem manajemen tugas yang memungkinkan pengguna untuk:
- Membuat, mengubah, dan menghapus tugas
- Mengatur prioritas dan deadline
- Melacak progress tugas
- Melihat statistik dan dashboard

---

## 📂 STRUKTUR FOLDER

```
Tugas_Akademik_RPL/
├── Dokumentasi/
│   ├── 01_LAPORAN_UTAMA.md              # Laporan lengkap proyek
│   ├── 02_PANDUAN_INSTALASI.md          # Setup & installation guide
│   └── 03_USER_STORIES.md               # User stories & requirements
│
├── SourceCode/
│   └── CONTOH_KODE_IMPLEMENTASI.md      # Contoh kode lengkap
│
├── Diagram/
│   └── DIAGRAM_SISTEM.md                # Use case, ERD, DFD, dll
│
├── TestCase/
│   └── BLACK_BOX_TESTING.md             # Test cases dan hasil testing
│
└── README.md                             # File ini
```

### Penjelasan Setiap Folder

#### Dokumentasi/
Folder ini berisi dokumentasi akademik lengkap:
- **01_LAPORAN_UTAMA.md**: Laporan komprehensif yang mencakup:
  - Latar belakang, rumusan masalah, tujuan
  - Metodologi Agile/Scrum (Product Backlog, Sprint Planning, Daily Scrum, dll)
  - Perancangan sistem (Use Case, Activity Diagram, ERD)
  - Kesimpulan dan saran

- **02_PANDUAN_INSTALASI.md**: Step-by-step installation guide
  - Prasyarat sistem
  - Instalasi PHP, MySQL, Node.js
  - Setup database
  - Running development server
  - Troubleshooting

- **03_USER_STORIES.md**: Daftar user stories dan requirements
  - 14 user stories dengan detail
  - Acceptance criteria
  - Story points
  - Sprint assignment

#### SourceCode/
Folder ini berisi contoh kode implementasi lengkap:
- Migration files (database schema)
- Model files (User, Task)
- Controller files (Auth, Dashboard, Task)
- Routing configuration
- Blade templates (HTML dengan Tailwind)
- Environment setup

#### Diagram/
Folder ini berisi diagram sistem:
- Use Case Diagram
- Activity Diagram (Login & CRUD Process)
- Entity Relationship Diagram (ERD)
- Data Flow Diagram (DFD)
- Class Diagram
- Deployment Architecture

#### TestCase/
Folder ini berisi test cases dan hasil testing:
- **BLACK_BOX_TESTING.md**: 32 test cases
  - 8 test cases untuk Authentication
  - 3 test cases untuk Dashboard
  - 4 test cases untuk Create Task
  - 5 test cases untuk Read Task
  - 3 test cases untuk Update Task
  - 2 test cases untuk Delete Task
  - 3 test cases untuk Responsive Design
  - 4 test cases untuk Security
  - Test result: 100% PASS

---

## 💻 TEKNOLOGI YANG DIGUNAKAN

### Backend
- **Laravel 10+** - PHP Web Framework (MVC Architecture)
- **PHP 8.1+** - Server-side programming language
- **Artisan CLI** - Command-line interface

### Frontend
- **HTML5** - Markup language
- **CSS3 + TailwindCSS** - Styling framework (Utility-first)
- **Blade Template Engine** - Laravel templating system
- **JavaScript (Vanilla)** - Client-side scripting
- **Vite** - Frontend build tool

### Database
- **MySQL 8.0** - Relational database management system

### Development Tools
- **Composer** - PHP dependency manager
- **NPM** - Node package manager
- **Git** - Version control
- **VS Code / PHP IDE** - Code editor

### Additional Libraries
- Laravel Breeze (Optional authentication scaffolding)
- Eloquent ORM - Object-Relational Mapping
- Blade Components

---

## 🚀 QUICK START

### 1. Clone atau Download Project

```bash
# Jika menggunakan git
git clone <repository-url>
cd Tugas_Akademik_RPL

# Atau extract ZIP file
```

### 2. Baca Panduan Instalasi

```bash
# Buka file ini
Dokumentasi/02_PANDUAN_INSTALASI.md
```

### 3. Setup Development Environment

```bash
# Copy .env
cp .env.example .env

# Install Composer dependencies
composer install

# Install NPM dependencies
npm install

# Generate app key
php artisan key:generate

# Create database
mysql -u root -p -e "CREATE DATABASE task_management"

# Run migrations
php artisan migrate

# Build frontend assets
npm run build
```

### 4. Start Development Server

```bash
# Terminal 1: Laravel server
php artisan serve

# Terminal 2: Asset watcher (optional)
npm run dev
```

### 5. Access Application

```
Homepage: http://localhost:8000
Dashboard: http://localhost:8000/dashboard (after login)
```

---

## ✨ FITUR UTAMA

### 1. Authentication Module
- ✓ Registrasi akun baru
- ✓ Login dengan email & password
- ✓ Logout functionality
- ✓ Remember me checkbox
- ✓ Password hashing (bcrypt)
- ✓ Session management

### 2. Dashboard
- ✓ Statistik tugas (Total, Selesai, Pending, Prioritas Tinggi)
- ✓ Tampilan tugas terbaru
- ✓ Quick action buttons
- ✓ Real-time updates

### 3. Task Management (CRUD)
- ✓ **Create**: Membuat tugas baru dengan title, description, priority, due_date
- ✓ **Read**: Melihat daftar semua tugas dengan pagination
- ✓ **Update**: Mengedit tugas (title, description, priority, status)
- ✓ **Delete**: Menghapus tugas dengan confirmation

### 4. Filtering & Search
- ✓ Filter berdasarkan status (todo, in_progress, completed)
- ✓ Filter berdasarkan prioritas (low, medium, high)
- ✓ Search berdasarkan judul tugas
- ✓ Kombinasi filter dan search

### 5. User Interface
- ✓ Responsive design (Mobile, Tablet, Desktop)
- ✓ Modern TailwindCSS styling
- ✓ User-friendly navigation
- ✓ Form validation dengan error messages
- ✓ Success/Error notifications

### 6. Security
- ✓ Password hashing
- ✓ SQL Injection prevention
- ✓ CSRF protection
- ✓ Authorization checks (task ownership)
- ✓ XSS prevention

---

## 📄 FILE-FILE PENTING

### Dokumentasi
| File | Deskripsi |
|------|-----------|
| `Dokumentasi/01_LAPORAN_UTAMA.md` | Laporan lengkap proyek (20+ halaman) |
| `Dokumentasi/02_PANDUAN_INSTALASI.md` | Setup guide & troubleshooting |
| `Dokumentasi/03_USER_STORIES.md` | 14 user stories dengan detail |

### Source Code
| File | Deskripsi |
|------|-----------|
| `SourceCode/CONTOH_KODE_IMPLEMENTASI.md` | Contoh kode lengkap (Controllers, Models, Views) |

### Diagram
| File | Deskripsi |
|------|-----------|
| `Diagram/DIAGRAM_SISTEM.md` | Use Case, ERD, Activity Diagram, DFD |

### Testing
| File | Deskripsi |
|------|-----------|
| `TestCase/BLACK_BOX_TESTING.md` | 32 test cases + hasil testing (100% PASS) |

---

## 📝 CATATAN PENTING

### Untuk Dosen Pengampu
1. Lihat **Laporan Utama** untuk overview proyek
2. Cek **Panduan Instalasi** sebelum run aplikasi
3. Review **User Stories** untuk requirement clarity
4. Test menggunakan **Test Cases** yang sudah disiapkan

### Untuk Mahasiswa yang Ingin Belajar
1. Mulai dari `Dokumentasi/01_LAPORAN_UTAMA.md` untuk memahami metodologi
2. Lihat `Diagram/DIAGRAM_SISTEM.md` untuk perancangan sistem
3. Baca `SourceCode/CONTOH_KODE_IMPLEMENTASI.md` untuk implementasi
4. Follow `Dokumentasi/02_PANDUAN_INSTALASI.md` untuk setup

### Struktur Database
Aplikasi menggunakan 2 tabel utama:

**users table:**
```sql
- id (Primary Key)
- name
- email (unique)
- password (hashed)
- created_at, updated_at
```

**tasks table:**
```sql
- id (Primary Key)
- user_id (Foreign Key)
- title
- description
- priority (enum: low, medium, high)
- status (enum: todo, in_progress, completed)
- due_date
- created_at, updated_at
```

### Metodologi Agile/Scrum yang Diterapkan
- ✓ Product Backlog (13 items)
- ✓ Sprint Planning (3 sprints × 2 minggu)
- ✓ Sprint Backlog (harian tasks)
- ✓ Daily Scrum (10 hari simulasi)
- ✓ Sprint Review (feedback dari stakeholder)
- ✓ Sprint Retrospective (lessons learned)

---

## 🧪 TESTING RESULTS

### Black Box Testing: 32 Test Cases
- ✓ Authentication: 8/8 PASS
- ✓ Dashboard: 3/3 PASS
- ✓ Create Task: 4/4 PASS
- ✓ Read Task: 5/5 PASS
- ✓ Update Task: 3/3 PASS
- ✓ Delete Task: 2/2 PASS
- ✓ Responsive Design: 3/3 PASS
- ✓ Security: 4/4 PASS

**Total: 32/32 PASS (100%)**

---

## 🔗 REFERENSI & LINKS

- **Laravel Docs**: https://laravel.com/docs
- **TailwindCSS Docs**: https://tailwindcss.com/docs
- **MySQL Docs**: https://dev.mysql.com/doc/
- **Scrum Guide**: https://scrumguides.org
- **Agile Manifesto**: https://agilemanifesto.org

---

## 👤 INFORMASI MAHASISWA

- **Nama**: [Isi Nama Mahasiswa]
- **NIM**: [Isi NIM]
- **Program**: Magister Teknik Informatika
- **Semester**: [Ganjil/Genap - Semester 2]
- **Mata Kuliah**: Rekayasa Perangkat Lunak (RPL)
- **Dosen Pengampu**: [Isi Nama Dosen]
- **Tanggal Pengumpulan**: [Isi Tanggal]

---

## 📧 SUPPORT

Jika ada pertanyaan atau error saat setup:

1. Cek **Dokumentasi/02_PANDUAN_INSTALASI.md** - bagian Troubleshooting
2. Baca error message dengan teliti
3. Pastikan semua dependencies sudah install
4. Check database configuration di `.env`

---

## ✅ CHECKLIST PENGUMPULAN

Sebelum mengumpulkan, pastikan:

- [ ] Folder `Tugas_Akademik_RPL` sudah siap
- [ ] Dokumentasi lengkap di folder `Dokumentasi/`
- [ ] Source code di folder `SourceCode/`
- [ ] Diagram di folder `Diagram/`
- [ ] Test cases di folder `TestCase/`
- [ ] File `README.md` ada
- [ ] Semua file dalam format `.md` atau `.pdf`
- [ ] Tidak ada folder `node_modules/`, `vendor/`, atau `.git/`
- [ ] Ukuran file total < 50MB

---

**Last Updated**: Maret 2024  
**Version**: 1.0  
**Status**: ✓ Ready for Submission

---

## Catatan:
> Tugas ini merupakan karya akademik. Semua dokumentasi, kode, diagram, dan test cases telah dibuat sesuai dengan requirement mata kuliah Rekayasa Perangkat Lunak. Gunakan sebagai referensi dan belajar dari implementasi yang ada.

