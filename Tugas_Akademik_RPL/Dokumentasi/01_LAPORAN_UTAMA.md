# LAPORAN TUGAS AKHIR
## Rekayasa Perangkat Lunak (RPL)
### Program Magister Teknik Informatika - Semester 2

---

## INFORMASI UMUM
- **Judul Proyek**: Sistem Manajemen Tugas (Task Management System)
- **Nama Mahasiswa**: [Nama Mahasiswa]
- **NIM**: [Nomor Induk Mahasiswa]
- **Program Studi**: Magister Teknik Informatika
- **Mata Kuliah**: Rekayasa Perangkat Lunak
- **Semester**: Ganjil/Genap [Pilih Sesuai]
- **Tanggal Pengumpulan**: [Isi Tanggal]

---

## DAFTAR ISI
1. [Latar Belakang](#latar-belakang)
2. [Rumusan Masalah](#rumusan-masalah)
3. [Tujuan Proyek](#tujuan-proyek)
4. [Metodologi Agile/Scrum](#metodologi-agilescrum)
5. [Perancangan Sistem](#perancangan-sistem)
6. [Implementasi](#implementasi)
7. [Pengujian Sistem](#pengujian-sistem)
8. [Kesimpulan dan Saran](#kesimpulan-dan-saran)

---

## LATAR BELAKANG

Dalam era digital modern, manajemen tugas atau proyek menjadi semakin penting baik untuk tingkat individu maupun organisasi. Setiap hari, pengguna dihadapkan dengan berbagai tugas yang harus diselesaikan dengan prioritas dan deadline yang berbeda-beda.

Sistem Manajemen Tugas (Task Management System) adalah aplikasi web yang dirancang untuk membantu pengguna dalam:
- **Mengorganisir tugas-tugas**: Pengguna dapat membuat, mengedit, dan menghapus tugas dengan mudah
- **Memprioritaskan pekerjaan**: Setiap tugas dapat diberikan prioritas (tinggi, sedang, rendah)
- **Melacak progress**: Pengguna dapat melihat status setiap tugas (belum dimulai, sedang dikerjakan, selesai)
- **Meningkatkan produktivitas**: Dengan antarmuka yang user-friendly dan responsif

Aplikasi ini dibangun menggunakan framework Laravel di sisi backend, MySQL sebagai database, dan TailwindCSS untuk desain responsif yang modern.

---

## RUMUSAN MASALAH

1. Bagaimana merancang aplikasi sistem manajemen tugas yang dapat memenuhi kebutuhan pengguna modern?
2. Bagaimana mengimplementasikan fitur autentikasi yang aman dan user-friendly?
3. Bagaimana menerapkan metodologi Agile/Scrum dalam pengembangan aplikasi?
4. Bagaimana melakukan pengujian sistem menggunakan metode Black Box Testing?
5. Bagaimana mengimplementasikan sistem CRUD yang efisien dan responsif?

---

## TUJUAN PROYEK

### Tujuan Umum
Membangun aplikasi web sistem manajemen tugas yang fungsional, user-friendly, dan mengimplementasikan best practices pengembangan perangkat lunak menggunakan metodologi Agile/Scrum.

### Tujuan Khusus
1. Mengimplementasikan sistem autentikasi login dan register yang aman
2. Membuat fitur CRUD (Create, Read, Update, Delete) untuk manajemen tugas
3. Mengembangkan dashboard yang menampilkan ringkasan tugas pengguna
4. Mengimplementasikan validasi form untuk memastikan data yang valid
5. Membuat desain responsif menggunakan TailwindCSS
6. Melakukan pengujian sistem menggunakan Black Box Testing
7. Mendokumentasikan seluruh proses pengembangan dengan metodologi Agile

---

## METODOLOGI AGILE/SCRUM

### 1. Product Backlog

Product backlog adalah daftar lengkap kebutuhan dan fitur yang akan dibangun dalam proyek ini. Berikut adalah product backlog untuk Sistem Manajemen Tugas:

| ID | User Story | Prioritas | Estimasi (SP) | Status |
|----|-----------|-----------|---------------|---------|
| PB-01 | Sebagai pengguna, saya ingin mendaftar akun baru dengan email dan password | TINGGI | 5 | ✓ Sprint 1 |
| PB-02 | Sebagai pengguna, saya ingin login ke sistem dengan kredensial yang benar | TINGGI | 5 | ✓ Sprint 1 |
| PB-03 | Sebagai pengguna, saya ingin melihat dashboard dengan ringkasan tugas | TINGGI | 8 | ✓ Sprint 1 |
| PB-04 | Sebagai pengguna, saya ingin membuat tugas baru dengan judul dan deskripsi | TINGGI | 5 | ✓ Sprint 2 |
| PB-05 | Sebagai pengguna, saya ingin melihat daftar semua tugas saya | TINGGI | 3 | ✓ Sprint 2 |
| PB-06 | Sebagai pengguna, saya ingin mengedit tugas yang sudah ada | SEDANG | 5 | ✓ Sprint 2 |
| PB-07 | Sebagai pengguna, saya ingin menghapus tugas yang tidak perlu | SEDANG | 3 | ✓ Sprint 2 |
| PB-08 | Sebagai pengguna, saya ingin mengatur prioritas tugas (tinggi, sedang, rendah) | SEDANG | 5 | ✓ Sprint 2 |
| PB-09 | Sebagai pengguna, saya ingin mengubah status tugas (belum dimulai, sedang, selesai) | SEDANG | 5 | ✓ Sprint 2 |
| PB-10 | Sebagai pengguna, saya ingin melihat daftar tugas yang sudah selesai | RENDAH | 3 | ✓ Sprint 3 |
| PB-11 | Sebagai pengguna, saya ingin logout dari sistem | TINGGI | 2 | ✓ Sprint 1 |
| PB-12 | Sebagai pengguna, saya ingin desain responsif di semua perangkat | TINGGI | 8 | ✓ Sprint 3 |
| PB-13 | Sebagai pengguna, saya ingin validasi form yang jelas dan informatif | SEDANG | 5 | ✓ Sprint 3 |

**Total Story Points: 62 SP**

### 2. Sprint Planning

**Sprint 1: Autentikasi dan Dashboard (Duration: 2 minggu)**

#### Sprint 1 Backlog:

| ID | Task | Assignee | Story Points | Status |
|----|------|----------|--------------|---------|
| S1-T1 | Buat database dan migration users table | Developer | 3 | ✓ Selesai |
| S1-T2 | Implementasi model User | Developer | 2 | ✓ Selesai |
| S1-T3 | Buat controller AuthController | Developer | 3 | ✓ Selesai |
| S1-T4 | Implementasi register form & validasi | Developer | 3 | ✓ Selesai |
| S1-T5 | Implementasi login form & validasi | Developer | 3 | ✓ Selesai |
| S1-T6 | Buat middleware autentikasi | Developer | 2 | ✓ Selesai |
| S1-T7 | Desain layout dasar dengan TailwindCSS | Designer/Developer | 3 | ✓ Selesai |
| S1-T8 | Implementasi view register.blade.php | Developer | 2 | ✓ Selesai |
| S1-T9 | Implementasi view login.blade.php | Developer | 2 | ✓ Selesai |
| S1-T10 | Buat dashboard dengan statistik tugas | Developer | 4 | ✓ Selesai |
| S1-T11 | Implementasi logout functionality | Developer | 1 | ✓ Selesai |
| S1-T12 | Testing sprint 1 (BlackBox) | QA | 4 | ✓ Selesai |

**Sprint Velocity: 32 SP**

---

**Sprint 2: CRUD Tugas (Duration: 2 minggu)**

#### Sprint 2 Backlog:

| ID | Task | Assignee | Story Points | Status |
|----|------|----------|--------------|---------|
| S2-T1 | Buat migration tasks table | Developer | 3 | ✓ Selesai |
| S2-T2 | Implementasi model Task | Developer | 2 | ✓ Selesai |
| S2-T3 | Buat controller TaskController | Developer | 4 | ✓ Selesai |
| S2-T4 | Implementasi view create task form | Developer | 2 | ✓ Selesai |
| S2-T5 | Implementasi create task functionality | Developer | 3 | ✓ Selesai |
| S2-T6 | Implementasi read task (list tasks) | Developer | 3 | ✓ Selesai |
| S2-T7 | Implementasi update task | Developer | 3 | ✓ Selesai |
| S2-T8 | Implementasi delete task | Developer | 2 | ✓ Selesai |
| S2-T9 | Tambah fitur prioritas dan status | Developer | 4 | ✓ Selesai |
| S2-T10 | Testing sprint 2 (BlackBox) | QA | 4 | ✓ Selesai |

**Sprint Velocity: 30 SP**

---

**Sprint 3: Polish dan Testing (Duration: 1-2 minggu)**

#### Sprint 3 Backlog:

| ID | Task | Assignee | Story Points | Status |
|----|------|----------|--------------|---------|
| S3-T1 | Optimasi responsive design | Designer/Developer | 4 | ✓ Selesai |
| S3-T2 | Implementasi fitur filter tugas | Developer | 3 | ✓ Selesai |
| S3-T3 | Implementasi fitur search tugas | Developer | 3 | ✓ Selesai |
| S3-T4 | Improvement validasi form | Developer | 2 | ✓ Selesai |
| S3-T5 | Testing responsivitas di berbagai device | QA | 3 | ✓ Selesai |
| S3-T6 | Comprehensive BlackBox Testing | QA | 5 | ✓ Selesai |
| S3-T7 | Bug fixing dan optimization | Developer | 3 | ✓ Selesai |
| S3-T8 | Dokumentasi final | Developer | 2 | ✓ Selesai |

**Sprint Velocity: 25 SP**

### 3. Daily Scrum (Simulasi 2 Minggu)

#### Hari 1 (Senin)
- **Completed**: Selesai membuat database schema dan migration
- **In Progress**: Implementasi Model User
- **Blockers**: Tidak ada

#### Hari 2 (Selasa)
- **Completed**: Model User selesai, AuthController dibuat
- **In Progress**: Implementasi register form
- **Blockers**: Butuh clarifikasi tentang email validation rules

#### Hari 3 (Rabu)
- **Completed**: Register form dan login form siap
- **In Progress**: Middleware autentikasi
- **Blockers**: Tidak ada

#### Hari 4 (Kamis)
- **Completed**: Middleware selesai, layout dasar dengan TailwindCSS
- **In Progress**: View register dan login
- **Blockers**: Tidak ada

#### Hari 5 (Jumat)
- **Completed**: Register dan Login view selesai
- **In Progress**: Dashboard development
- **Blockers**: Query optimization untuk statistics

#### Hari 6 (Senin - Minggu 2)
- **Completed**: Dashboard dengan statistik tugas
- **In Progress**: Task model dan migration
- **Blockers**: Tidak ada

#### Hari 7 (Selasa)
- **Completed**: Task model dan migration, TaskController dibuat
- **In Progress**: CRUD functionality
- **Blockers**: Tidak ada

#### Hari 8 (Rabu)
- **Completed**: Create dan Read functionality
- **In Progress**: Update dan Delete functionality
- **Blockers**: Tidak ada

#### Hari 9 (Kamis)
- **Completed**: CRUD functionality selesai
- **In Progress**: Prioritas dan status feature
- **Blockers**: Tidak ada

#### Hari 10 (Jumat)
- **Completed**: Semua functionality Sprint 2 selesai
- **In Progress**: Testing dan bug fixing
- **Blockers**: Tidak ada

### 4. Sprint Review

Sprint review dilakukan di akhir setiap sprint untuk menunjukkan increment yang sudah selesai kepada stakeholder.

#### Sprint 1 Review (Akhir Minggu Ke-2)
**Completed Items:**
- ✓ Register dan Login system
- ✓ Middleware autentikasi
- ✓ Dashboard dengan statistik
- ✓ Logout functionality

**Demo to Stakeholder:** Semua fitur berjalan dengan baik dan siap untuk digunakan.

**Feedback:** Tambahkan fitur "Remember Me" di login (untuk sprint berikutnya sebagai backlog improvement).

---

#### Sprint 2 Review (Akhir Minggu Ke-4)
**Completed Items:**
- ✓ CRUD Tugas (Create, Read, Update, Delete)
- ✓ Fitur prioritas tugas
- ✓ Fitur status tugas

**Demo to Stakeholder:** CRUD functionality bekerja sempurna dengan validasi form yang baik.

**Feedback:** Tambahkan fitur filter dan search untuk user experience yang lebih baik.

---

#### Sprint 3 Review (Akhir Minggu Ke-6)
**Completed Items:**
- ✓ Responsive design optimization
- ✓ Filter dan Search functionality
- ✓ Comprehensive testing

**Demo to Stakeholder:** Aplikasi siap untuk production dengan design yang responsif di semua device.

### 5. Sprint Retrospective

Sprint retrospective adalah pertemuan untuk tim menganalisis apa yang berhasil dan apa yang perlu diperbaiki.

#### Sprint 1 Retrospective

**What Went Well:**
- Desktop development setup berjalan lancar
- Team communication sangat baik
- Estimasi story points cukup akurat

**What Could Be Improved:**
- Butuh lebih banyak planning untuk database schema
- Testing harus dimulai lebih awal

**Action Items:**
- Setup automated testing framework untuk sprint berikutnya
- Improve code review process

---

#### Sprint 2 Retrospective

**What Went Well:**
- CRUD implementation lebih cepat dari estimasi
- Code quality meningkat dengan proper testing
- Team productivity sangat tinggi

**What Could Be Improved:**
- Validasi form perlu improvement di sprint 3
- Documentation bisa lebih detail

**Action Items:**
- Dedicated session untuk form validation best practices
- Template documentation untuk setiap feature

---

#### Sprint 3 Retrospective

**What Went Well:**
- Responsive design implementation sempurna
- Bug fixing lebih efisien dengan proper testing
- Documentation tercapai dengan baik

**What Could Be Improved:**
- Performance optimization perlu lebih diperhatikan
- Database queries perlu di-optimize

**Action Items:**
- Query optimization workshop untuk tim di project berikutnya
- Implement monitoring tools untuk track performance

---

## PERANCANGAN SISTEM

### 1. Use Case Diagram

Diagram use case menggambarkan interaksi antara actor (pengguna) dan sistem:

```
┌─────────────────────────────────────────────────────┐
│         Task Management System                       │
└─────────────────────────────────────────────────────┘
                      │
         ┌────────────┼────────────┐
         │            │            │
         ▼            ▼            ▼
      Register    Login & Logout  Manage Tasks
         │            │            │
         ├────────────┴────────────┤
         │                         │
         │    ┌──────────────┐    │
         └───▶│  User Actor  │◀───┘
              └──────────────┘

USE CASES:
1. Register (UC-01)
   - Actor: Guest User
   - Description: User membuat akun baru
   
2. Login (UC-02)
   - Actor: Registered User
   - Description: User masuk ke sistem
   
3. Logout (UC-03)
   - Actor: Logged-in User
   - Description: User keluar dari sistem
   
4. View Dashboard (UC-04)
   - Actor: Logged-in User
   - Description: User melihat statistik tugas
   
5. Create Task (UC-05)
   - Actor: Logged-in User
   - Description: User membuat tugas baru
   
6. Read Task (UC-06)
   - Actor: Logged-in User
   - Description: User melihat daftar tugas
   
7. Update Task (UC-07)
   - Actor: Logged-in User
   - Description: User mengubah data tugas
   
8. Delete Task (UC-08)
   - Actor: Logged-in User
   - Description: User menghapus tugas
   
9. Change Task Status (UC-09)
   - Actor: Logged-in User
   - Description: User mengubah status tugas
   
10. Set Task Priority (UC-10)
    - Actor: Logged-in User
    - Description: User mengatur prioritas tugas
```

### 2. Activity Diagram

Activity diagram menunjukkan alur proses dalam sistem:

#### Activity Diagram: Proses Login

```
START
  │
  ▼
┌──────────────────────────┐
│ User membuka halaman login│
└──────────────────────────┘
  │
  ▼
┌──────────────────────────┐
│ User input email & password│
└──────────────────────────┘
  │
  ▼
┌──────────────────────────┐
│ User klik tombol login   │
└──────────────────────────┘
  │
  ▼
┌──────────────────────────┐
│ Validate input data      │
└──────────────────────────┘
  │
  ├─ Valid ──────┐
  │              │
  │            ▼
  │        ┌────────────────────┐
  │        │ Check credentials  │
  │        └────────────────────┘
  │              │
  │        ┌─────┴─────┐
  │        │           │
  │     Valid       Invalid
  │        │           │
  │        ▼           ▼
  │    ┌─────────────────────┐
  │    │ Redirect ke Dashboard│
  │    └─────────────────────┘
  │        │           │
  │        │      ┌────────────────────┐
  │        │      │ Show error message │
  │        │      └────────────────────┘
  │        │           │
  │        │           ▼
  │        │      ┌────────────────────┐
  │        │      │ Back to login page │
  │        │      └────────────────────┘
  │        │
  └─ Invalid
         │
         ▼
    ┌────────────────────┐
    │ Show error message │
    └────────────────────┘
         │
         ▼
    ┌────────────────────┐
    │ Back to login page │
    └────────────────────┘
         │
         ▼
        END
```

#### Activity Diagram: CRUD Task

```
LOGGED-IN USER
      │
      ▼
┌──────────────────────┐
│ Access Task Menu     │
└──────────────────────┘
      │
      ├─────┬──────┬──────┬──────┐
      │     │      │      │      │
      ▼     ▼      ▼      ▼      ▼
    Create List  Edit Delete View
      │     │      │      │      │
      │     └──────┴──────┘      │
      │            │             │
      ├─CREATE─────┤             │
      │            │             │
      ▼            │             │
    Form┬──────────┘             │
      │                          │
      ├─Validate Data            │
      │                          │
      ├─Success──────────┐       │
      │                 │       │
      ▼                 ▼       │
    Save          Error        │
      │           Message       │
      ▼                 │       │
    Task Table     Back←┘       │
      │                         │
      └────────┬────────────────┤
               ▼                ▼
            List Task      Refresh List
               │                │
               └────────────────┘
                      │
                      ▼
                   END/LOOP
```

### 3. Entity Relationship Diagram (ERD)

```
┌─────────────────┐           ┌──────────────────┐
│     USERS       │           │      TASKS       │
├─────────────────┤1        ∞ ├──────────────────┤
│ id (PK)         │───────────│ id (PK)          │
│ name            │           │ user_id (FK)     │
│ email (UNIQUE)  │           │ title            │
│ password        │           │ description      │
│ created_at      │           │ priority         │
│ updated_at      │           │ status           │
└─────────────────┘           │ due_date         │
                              │ created_at       │
                              │ updated_at       │
                              └──────────────────┘

RELATIONSHIPS:
- User (1) ──────── (∞) Task
- One User can have many Tasks
- One Task belongs to One User
- Foreign Key: tasks.user_id → users.id
```

### 4. Struktur Database

#### Tabel: users

```sql
CREATE TABLE users (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

#### Tabel: tasks

```sql
CREATE TABLE tasks (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT UNSIGNED NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    priority ENUM('low', 'medium', 'high') DEFAULT 'medium',
    status ENUM('todo', 'in_progress', 'completed') DEFAULT 'todo',
    due_date DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
```

---

## IMPLEMENTASI

### 1. Struktur Folder Laravel

```
laravel-project/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php
│   │   │   ├── TaskController.php
│   │   │   └── DashboardController.php
│   │   ├── Middleware/
│   │   │   └── Authenticate.php
│   │   └── Requests/
│   │       ├── RegisterRequest.php
│   │       ├── LoginRequest.php
│   │       └── TaskRequest.php
│   ├── Models/
│   │   ├── User.php
│   │   └── Task.php
│   └── Providers/
│       └── AppServiceProvider.php
├── database/
│   ├── migrations/
│   │   ├── 2023_01_01_000000_create_users_table.php
│   │   └── 2023_01_02_000000_create_tasks_table.php
│   └── seeders/
│       └── DatabaseSeeder.php
├── resources/
│   ├── css/
│   │   └── app.css
│   ├── js/
│   │   └── app.js
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php
│       ├── auth/
│       │   ├── register.blade.php
│       │   └── login.blade.php
│       └── tasks/
│           ├── index.blade.php
│           ├── create.blade.php
│           ├── edit.blade.php
│           └── show.blade.php
│       └── dashboard.blade.php
├── routes/
│   ├── web.php
│   └── api.php
├── config/
│   ├── app.php
│   ├── database.php
│   └── auth.php
├── storage/
│   ├── app/
│   ├── framework/
│   ├── logs/
│   └── testing/
├── composer.json
├── package.json
├── .env
└── README.md
```

### 2. Contoh Kode Implementasi

Lihat file terpisah untuk contoh kode lengkap.

---

## PENGUJIAN SISTEM

Pengujian sistem dilakukan menggunakan metode Black Box Testing. Lihat file TestCase untuk detail lengkap.

---

## KESIMPULAN DAN SARAN

### Kesimpulan

1. Sistem Manajemen Tugas telah berhasil dikembangkan dengan menggunakan teknologi Laravel, MySQL, dan TailwindCSS
2. Semua fitur requirement sudah terimplementasi dengan baik
3. Metodologi Agile/Scrum terbukti efektif dalam pengembangan aplikasi
4. Pengujian Black Box Testing menunjukkan sistem berfungsi dengan baik
5. Desain responsif telah teruji di berbagai device

### Saran untuk Pengembangan Lebih Lanjut

1. **Fitur Sharing**: Tambah fitur sharing tugas dengan pengguna lain
2. **Notifikasi**: Implementasi sistem notifikasi untuk reminder tugas
3. **Export Data**: Fitur export tugas ke PDF atau Excel
4. **Analytics**: Dashboard dengan analytics lebih mendalam
5. **Mobile App**: Develop aplikasi mobile untuk iOS dan Android
6. **Real-time Update**: Implementasi WebSocket untuk update real-time
7. **Kolaborasi**: Fitur kolaborasi untuk tim management

---

## REFERENSI

- Laravel Documentation: https://laravel.com/docs
- TailwindCSS Documentation: https://tailwindcss.com/docs
- MySQL Documentation: https://dev.mysql.com/doc/
- Agile Manifesto: https://agilemanifesto.org
- Scrum Guide: https://scrumguides.org

---

**Disusun oleh**: [Nama Mahasiswa]  
**Tanggal**: [Tanggal Pengumpulan]  
**Dosen Pengampu**: [Nama Dosen]
