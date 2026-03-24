# Panduan Super Pemula Google Cloud Console

Panduan ini dibuat khusus untuk Anda yang baru pertama kali memakai Google Cloud Console.
Tujuan akhirnya:
1. Aplikasi Laravel Anda online di Google Cloud.
2. Bisa dikelola dari Cloud Console.
3. Bisa diuji dari sisi server dan client.

Dokumen pendukung:
1. UAT lengkap: [UAT_PERPUSTAKAAN_DIGITAL.md](/Users/rahmat/Herd/task_book/UAT_PERPUSTAKAAN_DIGITAL.md)
2. Uji lokal: [PENGUJIAN_LANGSUNG_SERVER_CLIENT_GRATIS.md](/Users/rahmat/Herd/task_book/PENGUJIAN_LANGSUNG_SERVER_CLIENT_GRATIS.md)

---

## 0) Pahami Istilah Dasar (Sangat Singkat)

1. **Cloud Run**: tempat aplikasi Laravel Anda berjalan (server web).
2. **Cloud SQL**: database MySQL online.
3. **Secret Manager**: tempat simpan password/APP_KEY dengan aman.
4. **Cloud Storage**: tempat simpan file cover buku agar tidak hilang saat redeploy.
5. **Cloud Run Jobs**: dipakai untuk menjalankan `php artisan migrate --force`.

---

## 1) Checklist Sebelum Mulai

Centang ini dulu:
1. [ ] Anda sudah login ke `console.cloud.google.com`
2. [ ] Project yang benar sudah dipilih (contoh di screenshot Anda: `juaragcp-hidayat-ml-d082251052`)
3. [ ] Billing aktif
4. [ ] Source code Laravel Anda sudah siap di laptop
5. [ ] File ini ada di project:
   - [Dockerfile](/Users/rahmat/Herd/task_book/Dockerfile)
   - [.dockerignore](/Users/rahmat/Herd/task_book/.dockerignore)

---

## 2) Persiapan Lokal di Laptop

Jalankan dari terminal:

```bash
cd /Users/rahmat/Herd/task_book
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate:fresh --seed
php artisan test
```

Jika ini gagal, jangan lanjut ke cloud dulu.

---

## 3) Langkah di Cloud Console (Klik per Klik)

### 3.1 Aktifkan API Wajib

1. Klik menu kiri: **APIs & Services**
2. Klik **Enabled APIs & services**
3. Klik **+ ENABLE APIS AND SERVICES**
4. Aktifkan satu per satu:
   - Cloud Run Admin API
   - Cloud Build API
   - Artifact Registry API
   - Cloud SQL Admin API
   - Secret Manager API
   - Cloud Storage API
   - Cloud Monitoring API
   - Cloud Logging API

### 3.2 Buat Service Account Runtime

1. Menu kiri: **IAM & Admin**
2. Klik **Service Accounts**
3. Klik **Create service account**
4. Isi nama: `task-book-runner`
5. Klik **Create and continue**
6. Tambahkan role:
   - `Cloud SQL Client`
   - `Secret Manager Secret Accessor`
   - `Storage Object User`
7. Klik **Done**

### 3.3 Buat Database Cloud SQL

1. Menu kiri: **Cloud SQL**
2. Klik **Create instance**
3. Pilih **MySQL**
4. Isi:
   - Instance ID: `task-book-db`
   - Password root: buat yang kuat
   - Region: `asia-southeast2` (Jakarta) jika tersedia
5. Klik **Create instance**
6. Setelah jadi, masuk ke instance:
   - Buat database: `task_book`
   - Buat user: `task_book_app` + password kuat

### 3.4 Buat Secret

1. Menu kiri: **Security** > **Secret Manager**
2. Klik **Create secret**
3. Buat:
   - `TASK_BOOK_APP_KEY` (isi APP_KEY dari `.env` lokal)
   - `TASK_BOOK_DB_PASSWORD` (isi password user `task_book_app`)

### 3.5 Buat Bucket untuk File Upload

1. Menu kiri: **Cloud Storage** > **Buckets**
2. Klik **Create**
3. Nama contoh: `task-book-public-files-<project-id>`
4. Pilih region sama dengan Cloud Run/SQL
5. Selesaikan wizard

---

## 4) Upload Code dan Deploy ke Cloud Run

Ada 2 cara. Untuk pemula, pilih satu yang paling nyaman.

### Cara A (Disarankan): dari Repository GitHub

1. Push source code Anda ke GitHub.
2. Buka **Cloud Run**.
3. Klik **Deploy container** / **Create service**.
4. Pilih source/repository (hubungkan GitHub).
5. Isi:
   - Service name: `task-book-web`
   - Region: `asia-southeast2`
   - Authentication: **Allow unauthenticated**
   - Service account: `task-book-runner`
   - Port: `8080`
6. Tambahkan Cloud SQL connection ke instance `task-book-db`.
7. Set environment variables:

| Key | Value |
|-----|-------|
| APP_ENV | production |
| APP_DEBUG | false |
| APP_URL | URL Cloud Run service |
| LOG_CHANNEL | stderr |
| DB_CONNECTION | mysql |
| DB_HOST | 127.0.0.1 |
| DB_PORT | 3306 |
| DB_DATABASE | task_book |
| DB_USERNAME | task_book_app |
| DB_SOCKET | /cloudsql/PROJECT_ID:REGION:INSTANCE_NAME |
| SESSION_DRIVER | database |
| CACHE_STORE | database |
| QUEUE_CONNECTION | database |
| FILESYSTEM_DISK | public |

8. Tambahkan secrets:
   - `APP_KEY` -> `TASK_BOOK_APP_KEY`
   - `DB_PASSWORD` -> `TASK_BOOK_DB_PASSWORD`
9. Tambahkan volume Cloud Storage:
   - Volume type: Cloud Storage bucket
   - Bucket: bucket yang dibuat tadi
   - Mount path: `/app/storage/app/public`
10. Klik **Deploy**.

### Cara B: via Cloud Shell Upload ZIP (tanpa GitHub)

1. Klik icon **Cloud Shell** (terminal) di kanan atas Console.
2. Upload ZIP project dari laptop ke Cloud Shell.
3. Ekstrak ZIP.
4. Jalankan deploy dari folder project dengan gcloud (jika Anda sudah siap CLI).
5. Untuk pemula murni, tetap lebih mudah pakai Cara A.

---

## 5) Jalankan Migration di Cloud (Wajib)

Setelah service deploy, lakukan ini:

1. Buka **Cloud Run** > **Jobs**
2. Klik **Create Job**
3. Job name: `task-book-migrate`
4. Gunakan image yang sama dengan service `task-book-web`
5. Set command:
   - Command: `php`
   - Arguments: `artisan migrate --force`
6. Set env + secrets + Cloud SQL sama seperti service web
7. Klik **Execute**

Opsional seeding awal:
1. Buat job `task-book-seed-once`
2. Arguments: `artisan db:seed --force`
3. Jalankan sekali saja jika perlu.

---

## 6) Pengujian Server-Side (Backend)

Setelah deploy selesai, test endpoint berikut:

```bash
curl -i "https://<URL_CLOUD_RUN>/health"
curl -i "https://<URL_CLOUD_RUN>/ready"
curl -i "https://<URL_CLOUD_RUN>/login"
```

Expected:
1. `/health` -> 200
2. `/ready` -> 200
3. `/login` -> 200

Endpoint ini sudah ada di:
- [routes/web.php](/Users/rahmat/Herd/task_book/routes/web.php)

---

## 7) Pengujian Client-Side (Dari Browser User)

1. Buka URL Cloud Run di browser laptop.
2. Buka juga dari HP (jaringan berbeda jika memungkinkan).
3. Login akun uji:
   - Admin: `admin@library.com` / `Admin123!`
   - Member: `budi@example.com` / `password123`
4. Jalankan UAT satu per satu memakai:
   - [UAT_PERPUSTAKAAN_DIGITAL.md](/Users/rahmat/Herd/task_book/UAT_PERPUSTAKAAN_DIGITAL.md)
5. Isi kolom Pass/Fail/Comments.

---

## 8) Cara Kelola Harian di Cloud Console

1. **Lihat log error**: Cloud Run > Service > tab Logs
2. **Lihat error stack**: Error Reporting
3. **Monitoring uptime**: Monitoring > Uptime checks (target `/health`)
4. **Rollback release**:
   - Cloud Run > Service > Revisions
   - Manage traffic
   - Arahkan traffic ke revision lama yang stabil
5. **Cek backup DB**:
   - Cloud SQL > Instance > Backups
   - Pastikan backup aktif

---

## 9) Troubleshooting Paling Umum

### Kasus A: `/ready` status 503
1. Cek Cloud SQL connection di service Cloud Run.
2. Cek `DB_SOCKET` sudah benar.
3. Cek role `Cloud SQL Client` pada service account.

### Kasus B: Login tidak menyimpan session
1. Pastikan `SESSION_DRIVER=database`.
2. Pastikan migration tabel `sessions` sudah dijalankan.

### Kasus C: Upload cover gagal / hilang
1. Cek volume Cloud Storage benar-benar terpasang.
2. Cek mount path `/app/storage/app/public`.
3. Cek role `Storage Object User`.

### Kasus D: Service online tapi halaman 500
1. Buka tab Logs di Cloud Run.
2. Cek Error Reporting.
3. Rollback ke revision sebelumnya.

---

## 10) Checklist Akhir Go-Live

1. [ ] `APP_DEBUG=false`
2. [ ] Secret di Secret Manager (bukan hardcoded)
3. [ ] DB di Cloud SQL
4. [ ] `/health` dan `/ready` 200
5. [ ] UAT sudah diisi dan lulus
6. [ ] Uptime check aktif
7. [ ] Backup DB aktif
8. [ ] Sudah tahu cara rollback revision

---

## 11) Referensi Resmi (Google Cloud)

1. Cloud Run deploy: https://cloud.google.com/run/docs/deploying
2. Cloud Run container contract: https://cloud.google.com/run/docs/container-contract
3. Cloud SQL connect from Cloud Run: https://cloud.google.com/sql/docs/mysql/connect-run
4. Cloud Run secrets: https://cloud.google.com/run/docs/configuring/services/secrets
5. Cloud Run Cloud Storage volume mounts: https://cloud.google.com/run/docs/configuring/services/cloud-storage-volume-mounts
6. Cloud Run logging: https://cloud.google.com/run/docs/logging
7. Cloud Run rollback traffic: https://docs.cloud.google.com/run/docs/rollouts-rollbacks-traffic-migration
8. Cloud Run jobs: https://docs.cloud.google.com/run/docs/execute/jobs
9. Cloud Monitoring uptime checks: https://docs.cloud.google.com/monitoring/uptime-checks
10. Cloud SQL backups: https://docs.cloud.google.com/sql/docs/mysql/backup-recovery/backups

