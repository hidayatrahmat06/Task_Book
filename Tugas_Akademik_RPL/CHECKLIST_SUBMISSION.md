# CHECKLIST SUBMISSION TUGAS AKHIR
## Rekayasa Perangkat Lunak (RPL) - Magister Teknik Informatika

---

## INFORMASI PENGUMPULAN

**Nama Mahasiswa**: _______________________________________________

**NIM**: _______________________________________________

**Tanggal Submission**: _______________________________________________

**Program**: Magister Teknik Informatika

**Mata Kuliah**: Rekayasa Perangkat Lunak (RPL)

**Semester**: Ganjil / Genap - Semester 2

**Dosen Pengampu**: _______________________________________________

---

## ✅ CHECKLIST - DOKUMENTASI LENGKAP

### 1. LAPORAN UTAMA
- [ ] File `Dokumentasi/01_LAPORAN_UTAMA.md` ada
- [ ] Latar Belakang ditulis dengan jelas
- [ ] Rumusan Masalah mencakup 5+ pertanyaan
- [ ] Tujuan Proyek (umum + khusus) tertulis
- [ ] Metodologi Agile/Scrum dijelaskan:
  - [ ] Product Backlog (13+ items)
  - [ ] Sprint Planning (3 sprints)
  - [ ] Sprint Backlog (daily tasks)
  - [ ] Daily Scrum (10+ hari simulasi)
  - [ ] Sprint Review (feedback)
  - [ ] Sprint Retrospective (lessons learned)
- [ ] Perancangan Sistem ada:
  - [ ] Use Case Diagram
  - [ ] Activity Diagram
  - [ ] Entity Relationship Diagram (ERD)
  - [ ] Database Structure
- [ ] Implementasi dijelaskan
- [ ] Pengujian Black Box dijelaskan
- [ ] Kesimpulan dan Saran tertulis

### 2. PANDUAN INSTALASI
- [ ] File `Dokumentasi/02_PANDUAN_INSTALASI.md` ada
- [ ] Prasyarat sistem terdaftar
- [ ] Step-by-step installation tertulis:
  - [ ] Install PHP 8.1+ (3 OS)
  - [ ] Install MySQL
  - [ ] Install Composer
  - [ ] Install Node.js
- [ ] Langkah setup project jelas
- [ ] Database setup dijelaskan
- [ ] Running development server tertulis
- [ ] Troubleshooting section ada dengan 5+ solusi

### 3. USER STORIES & REQUIREMENTS
- [ ] File `Dokumentasi/03_USER_STORIES.md` ada
- [ ] Minimal 14 user stories dengan format lengkap:
  - [ ] User story statement
  - [ ] Acceptance criteria
  - [ ] Story points
  - [ ] Priority
  - [ ] Sprint assignment
- [ ] Functional requirements dijelaskan
- [ ] Non-functional requirements dijelaskan
- [ ] Acceptance criteria summary ada

### 4. API ENDPOINTS
- [ ] File `Dokumentasi/04_API_ENDPOINTS.md` ada
- [ ] Authentication endpoints: 5+ routes
- [ ] Dashboard endpoint: 1+ route
- [ ] Task management endpoints: 7+ routes
- [ ] Route table dengan HTTP method
- [ ] Status codes dijelaskan
- [ ] CSRF protection dijelaskan
- [ ] Example requests & responses ada
- [ ] Testing examples (cURL, Postman)

---

## ✅ CHECKLIST - SOURCE CODE

### 5. CONTOH KODE IMPLEMENTASI
- [ ] File `SourceCode/CONTOH_KODE_IMPLEMENTASI.md` ada
- [ ] Migration files:
  - [ ] users table migration
  - [ ] tasks table migration
- [ ] Model files:
  - [ ] User model
  - [ ] Task model
- [ ] Controller files:
  - [ ] AuthController (register, login, logout)
  - [ ] DashboardController
  - [ ] TaskController (CRUD)
- [ ] Routing:
  - [ ] web.php routes
- [ ] Blade Templates:
  - [ ] layouts/app.blade.php
  - [ ] auth/register.blade.php
  - [ ] auth/login.blade.php
  - [ ] dashboard.blade.php
  - [ ] tasks/index.blade.php
  - [ ] tasks/create.blade.php
  - [ ] tasks/edit.blade.php
- [ ] Environment file (.env) example
- [ ] TailwindCSS config
- [ ] Artisan commands reference

---

## ✅ CHECKLIST - DIAGRAM SISTEM

### 6. DIAGRAM & PERANCANGAN
- [ ] File `Diagram/DIAGRAM_SISTEM.md` ada
- [ ] Use Case Diagram:
  - [ ] 10+ use cases terdefinisi
  - [ ] Aktor teridentifikasi
  - [ ] Relasi jelas
- [ ] Activity Diagram:
  - [ ] Login process detailed
  - [ ] CRUD process detailed
- [ ] Entity Relationship Diagram:
  - [ ] users table schema
  - [ ] tasks table schema
  - [ ] Relationships defined
- [ ] Data Flow Diagram (DFD):
  - [ ] Level 0 (context diagram)
  - [ ] Data sources defined
  - [ ] Processes identified
- [ ] Class Diagram:
  - [ ] Models & Controllers
  - [ ] Relationships
- [ ] Deployment Architecture
- [ ] All diagrams dalam teks format atau visual

---

## ✅ CHECKLIST - TESTING

### 7. BLACK BOX TESTING
- [ ] File `TestCase/BLACK_BOX_TESTING.md` ada
- [ ] Test cases terdefinisi:
  - [ ] Authentication: 8 test cases
    - [ ] Register valid data
    - [ ] Register email exists
    - [ ] Register password validation
    - [ ] Login valid
    - [ ] Login invalid
    - [ ] Logout
  - [ ] Dashboard: 3 test cases
    - [ ] View dashboard
    - [ ] Statistics accuracy
    - [ ] Recent tasks
  - [ ] Create Task: 4 test cases
    - [ ] Valid creation
    - [ ] Validation errors
  - [ ] Read Task: 5 test cases
    - [ ] View all tasks
    - [ ] Filter by status
    - [ ] Filter by priority
    - [ ] Search functionality
  - [ ] Update Task: 3 test cases
  - [ ] Delete Task: 2 test cases
  - [ ] Responsive Design: 3 test cases
  - [ ] Security: 4 test cases
- [ ] Setiap test case mencakup:
  - [ ] Test ID
  - [ ] Pre-condition
  - [ ] Test steps
  - [ ] Expected result
  - [ ] Actual result (evidence)
  - [ ] Status (PASS/FAIL)
- [ ] Summary testing table (32 test cases total)
- [ ] Pass rate 100% atau explanation untuk failures
- [ ] No critical bugs found atau bug list

---

## ✅ CHECKLIST - FILE TAMBAHAN

### 8. README.md
- [ ] File `README.md` ada
- [ ] Overview proyek jelas
- [ ] Folder structure dijelaskan
- [ ] Teknologi listed
- [ ] Quick start guide ada
- [ ] Fitur utama terdaftar
- [ ] Links ke dokumentasi internal
- [ ] References/links eksternal

---

## ✅ CHECKLIST - KUALITAS KONTEN

### 9. KUALITAS DOKUMENTASI
- [ ] Bahasa Indonesia formal digunakan konsisten
- [ ] Tidak ada typo/grammar error signifikan
- [ ] Formatting dan structure rapi
- [ ] Code blocks di-format dengan benar
- [ ] Tables terformat dengan baik
- [ ] Images/diagrams jelas (jika ada)
- [ ] Links internal berfungsi
- [ ] Consistency dalam istilah & terminology
- [ ] Professional appearance

### 10. KUALITAS KODE
- [ ] Code indentation consistent
- [ ] Comments ada untuk complex logic
- [ ] Meaningful variable names
- [ ] No hardcoded values
- [ ] Error handling implemented
- [ ] Security best practices diterapkan
- [ ] Code follows Laravel conventions
- [ ] MVC pattern di-implementasi

### 11. KUALITAS METODOLOGI
- [ ] Agile/Scrum diterapkan dengan benar
- [ ] Minimal 3 sprints documented
- [ ] Daily scrum entries tertera (10+ hari)
- [ ] Sprint review & retrospective ada
- [ ] Velocity tracking terlihat
- [ ] Backlog prioritized dengan jelas
- [ ] User stories format konsisten

### 12. KUALITAS TESTING
- [ ] Test cases comprehensive
- [ ] Coverage mencakup:
  - [ ] Happy path (normal flow)
  - [ ] Sad path (error handling)
  - [ ] Edge cases
  - [ ] Security scenarios
- [ ] Test results documented
- [ ] Evidence/screenshots (jika applicable)
- [ ] Pass/fail rate tertera

---

## ✅ CHECKLIST - STRUKTUR & ORGANISASI

### 13. FOLDER STRUCTURE
```
Tugas_Akademik_RPL/
├── Dokumentasi/
│   ├── 01_LAPORAN_UTAMA.md              [✓]
│   ├── 02_PANDUAN_INSTALASI.md          [✓]
│   ├── 03_USER_STORIES.md               [✓]
│   └── 04_API_ENDPOINTS.md              [✓]
├── SourceCode/
│   └── CONTOH_KODE_IMPLEMENTASI.md      [✓]
├── Diagram/
│   └── DIAGRAM_SISTEM.md                [✓]
├── TestCase/
│   └── BLACK_BOX_TESTING.md             [✓]
├── README.md                             [✓]
└── CHECKLIST_SUBMISSION.md (this file)  [✓]
```

- [ ] Semua folder & file ada
- [ ] Naming konsisten & jelas
- [ ] File types sesuai (.md untuk semua doc)
- [ ] File size wajar (< 10MB per file)
- [ ] Total size < 100MB

### 14. FILE TIDAK BOLEH ADA
- [ ] node_modules/ folder (remove sebelum submit)
- [ ] vendor/ folder (remove sebelum submit)
- [ ] .git/ folder (jika ada, remove)
- [ ] .env file dengan credentials aktual
- [ ] Database dump
- [ ] Temporary files (~backup, .DS_Store)
- [ ] IDE-specific files (.vscode/settings.json dengan secrets)

---

## ✅ CHECKLIST - FINAL REVIEW

### 15. FINAL QUALITY CHECK

**Dokumentasi:**
- [ ] Semua dokumen sudah di-review
- [ ] No typos dalam judul & headings
- [ ] Consistency dalam terminology
- [ ] References & links valid
- [ ] Struktur logical & mudah diikuti
- [ ] Panjang dokumen appropriate (tidak terlalu pendek/panjang)

**Content Completeness:**
- [ ] Semua requirement tercakup
- [ ] Tidak ada section yang kosong
- [ ] Semua diagram terinci
- [ ] Semua test case terdokumentasi
- [ ] Semua code example berfungsi

**Technical Accuracy:**
- [ ] Laravel syntax benar
- [ ] Database queries benar
- [ ] Blade templates valid
- [ ] Routing configuration benar
- [ ] Validation rules sesuai

**Readability:**
- [ ] Font size readable
- [ ] Color contrast good
- [ ] Formatting consistent
- [ ] Spacing appropriate
- [ ] Flow logical

---

## ✅ SUBMISSION PACKAGE CHECKLIST

Sebelum submit, pastikan:

- [ ] Semua file dalam satu folder `Tugas_Akademik_RPL/`
- [ ] ZIP file dibuat: `Tugas_Akademik_RPL.zip`
- [ ] File size < 100MB
- [ ] Folder `node_modules/` DIHAPUS
- [ ] Folder `vendor/` DIHAPUS jika ada
- [ ] Tidak ada file CONFIDENTIAL atau PRIVATE
- [ ] Filename sesuai naming convention
- [ ] Submit ke platform yang ditentukan dosen
- [ ] Submission receipt/confirmation tersimpan

---

## SUBMISSION NOTES

**Tanggal Deadline**: _______________________________________________

**Platform Submission**: _______________________________________________

**Status Submission**: 
- [ ] Belum submit
- [ ] Sudah submit
- [ ] Submitted at: _______________________________________________
- [ ] Confirmation received: _______________________________________________

---

## ADDITIONAL NOTES / REMARKS

Catatan tambahan dari mahasiswa:

___________________________________________________________________

___________________________________________________________________

___________________________________________________________________

___________________________________________________________________

---

## TANDA TANGAN

Dengan ini saya menyatakan bahwa tugas akhir ini adalah hasil karya saya sendiri dan bukan plagiarisme dari karya orang lain.

**Tanda Tangan Mahasiswa**: ____________________________

**Nama Jelas**: ____________________________

**Tanggal**: ____________________________

---

## TANDA PERSETUJUAN DOSEN

**Dosen Pengampu**: 

**Status**: 
- [ ] Diterima
- [ ] Revisi diperlukan
- [ ] Ditolak

**Komentar Dosen**:

___________________________________________________________________

___________________________________________________________________

**Tanda Tangan Dosen**: ____________________________

**Tanggal**: ____________________________

---

## CATATAN PENTING

1. **Sebelum Submit:**
   - Print checklist ini
   - Check setiap item
   - Tanda centang untuk item yang completed
   - Lebih baik double-check daripada submit incomplete

2. **Jika Ada Yang Kurang:**
   - Jangan langsung submit
   - Lengkapi terlebih dahulu
   - Validate dengan checklist ini
   - Baru submit setelah 100% lengkap

3. **Submission Format:**
   - ZIP file dengan folder struktur yang benar
   - Atau folder direktori sesuai instruksi dosen
   - Include file CHECKLIST_SUBMISSION.md yang sudah diisi

4. **Contact Dosen:**
   - Jika ada pertanyaan, hubungi dosen sebelum submit
   - Clarify requirement yang tidak jelas
   - Diskusi tentang scope project

---

**Version**: 1.0  
**Last Updated**: Maret 2024  
**Status**: Ready for Use

---

**Catatan untuk Mahasiswa Lain:**
> Gunakan checklist ini sebagai template untuk memastikan tugas Anda lengkap dan memenuhi semua requirement. Jangan skip items karena setiap item penting untuk penilaian akademik.
