# USER STORIES & REQUIREMENTS DETAIL
## Sistem Manajemen Tugas (Task Management System)

---

## USER STORIES

User story digunakan untuk mendefinisikan requirement dari perspektif end-user.

Format: **Sebagai [Role], saya ingin [Feature], sehingga [Benefit]**

---

### US-01: Registrasi Akun Baru

```
Sebagai: Calon pengguna yang belum memiliki akun
Saya ingin: Dapat membuat akun baru dengan mudah
Sehingga: Saya dapat menggunakan aplikasi

ACCEPTANCE CRITERIA:
✓ User dapat mengakses halaman registrasi dari homepage
✓ Form registrasi meminta: Nama, Email, Password, Konfirmasi Password
✓ Form memiliki validasi:
  - Nama tidak boleh kosong (max 255 karakter)
  - Email harus valid dan belum terdaftar
  - Password minimal 8 karakter
  - Password dan konfirmasi harus sama
✓ Setelah submit, user ter-redirect ke dashboard
✓ User dapat langsung login dengan akun baru
✓ Password ter-hash di database (bcrypt)
✓ Toast/flash message success ditampilkan

STORY POINTS: 5
PRIORITY: TINGGI
SPRINT: Sprint 1
```

---

### US-02: Login ke Aplikasi

```
Sebagai: Pengguna terdaftar
Saya ingin: Dapat login dengan email dan password
Sehingga: Saya dapat mengakses dashboard dan mengelola tugas saya

ACCEPTANCE CRITERIA:
✓ User dapat mengakses halaman login
✓ Form login meminta: Email dan Password
✓ Ada checkbox "Ingat saya" untuk remember me
✓ Validasi:
  - Email required
  - Password required
  - Kombinasi email/password benar
✓ Jika login berhasil: ter-redirect ke dashboard
✓ Jika login gagal: tampil error message "Email atau password salah"
✓ User session dibuat dan valid di semua halaman
✓ User data dapat diakses via Auth::user()

STORY POINTS: 5
PRIORITY: TINGGI
SPRINT: Sprint 1
```

---

### US-03: Logout dari Aplikasi

```
Sebagai: Pengguna yang sedang login
Saya ingin: Dapat logout dari aplikasi
Sehingga: Sesi saya berakhir dan data saya aman

ACCEPTANCE CRITERIA:
✓ Tombol logout tersedia di navbar
✓ Saat diklik, session pengguna dihapus
✓ User ter-redirect ke homepage atau login
✓ Flash message success ditampilkan
✓ User tidak bisa kembali ke dashboard tanpa login ulang
✓ Cookie/session token dihapus

STORY POINTS: 2
PRIORITY: TINGGI
SPRINT: Sprint 1
```

---

### US-04: Melihat Dashboard

```
Sebagai: Pengguna yang sudah login
Saya ingin: Dapat melihat dashboard dengan statistik tugas saya
Sehingga: Saya dapat mengetahui overview tugas dan progress

ACCEPTANCE CRITERIA:
✓ Dashboard accessible di /dashboard
✓ Menampilkan 4 card statistik:
  - Total Tugas
  - Tugas Selesai
  - Tugas Pending
  - Tugas Prioritas Tinggi
✓ Nilai statistik akurat dan real-time
✓ Menampilkan 5 tugas terbaru
✓ Quick action buttons:
  - Buat Tugas Baru
  - Lihat Semua Tugas
✓ Design responsif untuk semua device
✓ Loading time < 2 detik

STORY POINTS: 8
PRIORITY: TINGGI
SPRINT: Sprint 1
```

---

### US-05: Membuat Tugas Baru

```
Sebagai: Pengguna yang ingin menambahkan tugas
Saya ingin: Dapat membuat tugas baru dengan detail
Sehingga: Tugas saya ter-track dan terorganisir

ACCEPTANCE CRITERIA:
✓ User dapat akses form create task di /tasks/create
✓ Form meminta:
  - Title (required, max 255)
  - Description (optional, text)
  - Priority (required: low/medium/high)
  - Due Date (optional, format: YYYY-MM-DD)
✓ Validasi:
  - Title tidak boleh kosong
  - Priority harus dipilih
  - Due Date harus ≥ hari ini (tidak boleh date masa lalu)
✓ Default status: "todo"
✓ Task tersimpan ke database
✓ User ter-redirect ke task list
✓ Success message ditampilkan
✓ Task ownership: task belong to logged-in user

STORY POINTS: 5
PRIORITY: TINGGI
SPRINT: Sprint 2
```

---

### US-06: Melihat Daftar Tugas

```
Sebagai: Pengguna yang ingin melihat semua tugas
Saya ingin: Dapat melihat daftar lengkap tugas saya
Sehingga: Saya tahu apa saja yang harus dikerjakan

ACCEPTANCE CRITERIA:
✓ Accessible di /tasks
✓ Tampilkan tabel dengan kolom:
  - Judul
  - Prioritas (badge dengan warna)
  - Status (badge dengan warna)
  - Tanggal dibuat / deadline
  - Action (Edit, Hapus)
✓ Pagination: 10 item per halaman
✓ Total count ditampilkan
✓ Table responsive di mobile
✓ Bisa klik pada judul untuk detail
✓ Edit button menuju /tasks/{id}/edit
✓ Hapus button dengan confirmation

STORY POINTS: 3
PRIORITY: TINGGI
SPRINT: Sprint 2
```

---

### US-07: Mengedit Tugas

```
Sebagai: Pengguna yang ingin mengubah detail tugas
Saya ingin: Dapat edit tugas yang sudah ada
Sehingga: Tugas saya tetap ter-update dengan informasi terbaru

ACCEPTANCE CRITERIA:
✓ Edit form accessible di /tasks/{id}/edit
✓ Form pre-filled dengan data tugas saat ini
✓ User dapat mengubah:
  - Title
  - Description
  - Priority
  - Status (new field di edit)
  - Due Date
✓ Edit hanya bisa dilakukan oleh owner task
✓ Validasi sama dengan create
✓ Setelah save, ter-redirect ke /tasks
✓ Success message ditampilkan
✓ Last updated timestamp berubah

STORY POINTS: 5
PRIORITY: SEDANG
SPRINT: Sprint 2
```

---

### US-08: Menghapus Tugas

```
Sebagai: Pengguna yang ingin menghapus tugas
Saya ingin: Dapat menghapus tugas yang tidak diperlukan
Sehingga: Daftar tugas tetap rapi dan relevan

ACCEPTANCE CRITERIA:
✓ Hapus button ada di setiap task row
✓ Saat diklik, show confirmation dialog
✓ Dialog berisi: "Apakah Anda yakin ingin menghapus tugas ini?"
✓ Delete hanya bisa dilakukan oleh owner
✓ Jika dikonfirmasi: task dihapus dari DB
✓ Database: cascade delete dijalankan
✓ Success message ditampilkan
✓ Redirect ke /tasks dengan updated list
✓ Cannot undo (permanent delete)

STORY POINTS: 3
PRIORITY: SEDANG
SPRINT: Sprint 2
```

---

### US-09: Mengubah Status Tugas

```
Sebagai: Pengguna yang ingin track progress
Saya ingin: Dapat mengubah status tugas (todo/in_progress/completed)
Sehingga: Saya tahu tugas saya sudah sampai tahap mana

ACCEPTANCE CRITERIA:
✓ Status dropdown ada di form edit
✓ Status options: 
  - "Belum Dimulai" (todo)
  - "Sedang Dikerjakan" (in_progress)
  - "Selesai" (completed)
✓ Default status untuk task baru: "Belum Dimulai"
✓ Dapat diubah kapan saja
✓ Update real-time
✓ Completed tasks tidak bisa edit (optional)
✓ Status change timestamp ter-update

STORY POINTS: 5
PRIORITY: SEDANG
SPRINT: Sprint 2
```

---

### US-10: Mengatur Prioritas Tugas

```
Sebagai: Pengguna yang ingin fokus tugas penting
Saya ingin: Dapat mengatur prioritas setiap tugas
Sehingga: Saya tahu tugas mana yang harus dikerjakan duluan

ACCEPTANCE CRITERIA:
✓ Priority field ada di form create dan edit
✓ Priority options:
  - Low (Priority Rendah) - badge hijau
  - Medium (Priority Sedang) - badge kuning
  - High (Priority Tinggi) - badge merah
✓ Default priority: Medium
✓ Priority ditampilkan dengan badge berbeda warna
✓ Dashboard statistik track "high priority pending tasks"
✓ Can filter tasks by priority

STORY POINTS: 5
PRIORITY: SEDANG
SPRINT: Sprint 2
```

---

### US-11: Filter Tugas Berdasarkan Status

```
Sebagai: Pengguna dengan banyak tugas
Saya ingin: Dapat filter tugas berdasarkan status
Sehingga: Saya bisa fokus melihat tugas dengan status tertentu

ACCEPTANCE CRITERIA:
✓ Filter dropdown di halaman /tasks
✓ Options: Semua, Belum Dimulai, Sedang Dikerjakan, Selesai
✓ Saat filter dipilih, list ter-update
✓ URL berubah: ?status=completed
✓ Filter dapat dikombinasi dengan search
✓ Clear filter button tersedia
✓ Filter status disave di query string

STORY POINTS: 3
PRIORITY: SEDANG
SPRINT: Sprint 3
```

---

### US-12: Filter Tugas Berdasarkan Prioritas

```
Sebagai: Pengguna yang ingin fokus tugas penting
Saya ingin: Dapat filter tugas berdasarkan prioritas
Sehingga: Saya hanya melihat tugas dengan prioritas tertentu

ACCEPTANCE CRITERIA:
✓ Filter dropdown di halaman /tasks
✓ Options: Semua, Rendah, Sedang, Tinggi
✓ Filter real-time
✓ URL: ?priority=high
✓ Kombinasi dengan status filter
✓ Clear filter button

STORY POINTS: 3
PRIORITY: SEDANG
SPRINT: Sprint 3
```

---

### US-13: Search Tugas

```
Sebagai: Pengguna dengan banyak tugas
Saya ingin: Dapat mencari tugas berdasarkan judul
Sehingga: Saya cepat menemukan tugas tertentu

ACCEPTANCE CRITERIA:
✓ Search box di halaman /tasks
✓ Search berdasarkan title task
✓ Real-time search (saat type)
✓ URL: ?search=laravel
✓ Partial match (LIKE query)
✓ Case-insensitive search
✓ Kombinasi dengan filter

STORY POINTS: 3
PRIORITY: SEDANG
SPRINT: Sprint 3
```

---

### US-14: Responsive Design

```
Sebagai: Pengguna yang akses dari berbagai device
Saya ingin: Aplikasi responsif dan user-friendly di HP, tablet, desktop
Sehingga: Saya bisa manage tugas dari mana saja

ACCEPTANCE CRITERIA:
✓ Mobile (375px - 768px):
  - Single column layout
  - Large buttons dan touch targets
  - Menu hamburger (if needed)
✓ Tablet (768px - 1024px):
  - 2 column grid
  - Readable text
  - Accessible navigation
✓ Desktop (1024px+):
  - Multi-column layout
  - Table view untuk list
  - Full feature accessible
✓ Tested pada:
  - iPhone 12
  - iPad
  - Desktop 1920x1080
✓ No horizontal scroll pada mobile
✓ Images responsive
✓ Forms easy to fill

STORY POINTS: 8
PRIORITY: TINGGI
SPRINT: Sprint 3
```

---

## FUNCTIONAL REQUIREMENTS

### FR-01: Autentikasi Pengguna
- User dapat register dengan email unik
- Password di-hash menggunakan bcrypt
- User dapat login dengan email & password
- Session management dengan Laravel
- Logout functionality
- Remember me functionality

### FR-02: Manajemen Tugas
- User dapat membuat tugas baru
- User dapat melihat semua tugas miliknya
- User dapat edit tugas miliknya
- User dapat delete tugas miliknya
- Task memiliki: title, description, priority, status, due_date
- Task ownership: user hanya bisa manage tugas miliknya

### FR-03: Statistik & Dashboard
- Dashboard menampilkan statistik real-time
- Statistik: total tasks, completed, pending, high priority
- Dashboard menampilkan recent tasks
- Quick action buttons: create task, view all tasks

### FR-04: Filtering & Search
- Filter tasks by status
- Filter tasks by priority
- Search tasks by title
- Kombinasi filter dan search
- Pagination untuk task list

---

## NON-FUNCTIONAL REQUIREMENTS

### NFR-01: Performance
- Page load time < 2 detik
- Database queries optimized
- Pagination untuk data besar
- No N+1 query problems

### NFR-02: Security
- Password hashing (bcrypt)
- SQL Injection prevention (use parameterized queries)
- CSRF protection
- XSS prevention
- Authorization checks

### NFR-03: Usability
- User-friendly interface
- Clear error messages
- Responsive design
- Accessible navigation

### NFR-04: Reliability
- 99% uptime
- Error handling

### NFR-05: Scalability
- Database indexing
- Eager loading untuk relations
- Caching strategy

---

## ACCEPTANCE CRITERIA SUMMARY

Untuk setiap user story diterima, berikut criteria yang harus terpenuhi:

1. ✓ Semua test cases (Black Box) PASS
2. ✓ Code review approved
3. ✓ Responsive design tested
4. ✓ Security audit passed
5. ✓ Documentation updated
6. ✓ Performance acceptable
7. ✓ No critical bugs

