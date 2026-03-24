# 🗄️ DATABASE.md - Skema & Manajemen Database

> Dokumentasi lengkap database system, termasuk schema, relationships, migrations, dan queries

**Versi:** 1.0.0  
**Database:** MySQL 8.0+  
**Last Updated:** 16 Maret 2026

---

## 📖 Daftar Isi

1. [Database Overview](#database-overview)
2. [Schema & Tables](#schema--tables)
3. [Relationships](#relationships)
4. [Migrations](#migrations)
5. [Indexing Strategy](#indexing-strategy)
6. [Backup & Recovery](#backup--recovery)
7. [Performance Optimization](#performance-optimization)
8. [Common Queries](#common-queries)

---

## 📊 Database Overview

### Connection Details

```
Database Name:  task_book
Host:           localhost (dev) / production server (prod)
Port:           3306
Username:       root (dev) / db_user (prod)
Charset:        utf8mb4
Collation:      utf8mb4_unicode_ci
```

### Database Configuration

File: `.env`

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=task_book
DB_USERNAME=root
DB_PASSWORD=
```

---

## 📋 Schema & Tables

### 1. Users Table

**Purpose:** Menyimpan informasi pengguna (admin & member)

**Location:** `database/migrations/0001_01_01_000000_create_users_table.php`

#### Schema

```sql
CREATE TABLE users (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    email_verified_at TIMESTAMP NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'member') NOT NULL DEFAULT 'member',
    phone VARCHAR(20) NULL,
    address TEXT NULL,
    remember_token VARCHAR(100) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
```

#### Fields Description

| Field | Type | Nullable | Unique | Notes |
|-------|------|----------|--------|-------|
| `id` | BIGINT UNSIGNED | ❌ | ✓ | Primary key |
| `name` | VARCHAR(255) | ❌ | ❌ | Nama lengkap user |
| `email` | VARCHAR(255) | ❌ | ✓ | Email untuk login & kontak |
| `email_verified_at` | TIMESTAMP | ✓ | ❌ | Verifikasi email |
| `password` | VARCHAR(255) | ❌ | ❌ | Hashed password |
| `role` | ENUM | ❌ | ❌ | 'admin' atau 'member' |
| `phone` | VARCHAR(20) | ✓ | ❌ | Nomor telepon |
| `address` | TEXT | ✓ | ❌ | Alamat lengkap |
| `remember_token` | VARCHAR(100) | ✓ | ❌ | Remember me token |
| `created_at` | TIMESTAMP | ✓ | ❌ | Waktu pembuatan |
| `updated_at` | TIMESTAMP | ✓ | ❌ | Waktu perubahan terakhir |

#### Indexes

```sql
-- Primary Key
PRIMARY KEY (id)

-- Unique Constraints
UNIQUE KEY unique_email (email)

-- For foreign key searches
INDEX idx_role (role)
```

#### Sample Data

```sql
INSERT INTO users VALUES (
    1, 
    'Admin Perpustakaan', 
    'admin@library.com', 
    NULL, 
    'hashed_password_admin123', 
    'admin', 
    '081234567890', 
    'Jalan Perpustakaan No. 1', 
    NULL, 
    NOW(), 
    NOW()
);

INSERT INTO users VALUES (
    2, 
    'Budi Santoso', 
    'budi@example.com', 
    NULL, 
    'hashed_password_123',
    'member', 
    '081234567891', 
    'Jalan Merdeka No. 10', 
    NULL, 
    NOW(), 
    NOW()
);
```

---

### 2. Categories Table

**Purpose:** Menyimpan kategori buku

**Location:** `database/migrations/0001_01_01_000001_create_categories_table.php`

#### Schema

```sql
CREATE TABLE categories (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL UNIQUE,
    description TEXT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
```

#### Fields Description

| Field | Type | Nullable | Unique | Notes |
|-------|------|----------|--------|-------|
| `id` | BIGINT UNSIGNED | ❌ | ✓ | Primary key |
| `name` | VARCHAR(255) | ❌ | ✓ | Nama kategori (unik) |
| `description` | TEXT | ✓ | ❌ | Deskripsi kategori |
| `created_at` | TIMESTAMP | ✓ | ❌ | Waktu pembuatan |
| `updated_at` | TIMESTAMP | ✓ | ❌ | Waktu perubahan terakhir |

#### Sample Data

```sql
INSERT INTO categories (name, description) VALUES
('Fiksi', 'Novel dan cerita fiksi'),
('Non-Fiksi', 'Buku non-fiksi dan referensi'),
('Sains & Teknologi', 'Buku tentang sains dan teknologi');
```

---

### 3. Books Table

**Purpose:** Menyimpan informasi buku dalam perpustakaan

**Location:** `database/migrations/0001_01_01_000002_create_books_table.php`

#### Schema

```sql
CREATE TABLE books (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    author VARCHAR(255) NOT NULL,
    isbn VARCHAR(20) NOT NULL UNIQUE,
    category_id BIGINT UNSIGNED NOT NULL,
    publisher VARCHAR(255) NOT NULL,
    year_published INT NOT NULL,
    stock INT NOT NULL DEFAULT 1,
    description TEXT NULL,
    cover_image VARCHAR(255) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE RESTRICT
);
```

#### Fields Description

| Field | Type | Nullable | Unique | Notes |
|-------|------|----------|--------|-------|
| `id` | BIGINT UNSIGNED | ❌ | ✓ | Primary key |
| `title` | VARCHAR(255) | ❌ | ❌ | Judul buku |
| `author` | VARCHAR(255) | ❌ | ❌ | Nama penulis |
| `isbn` | VARCHAR(20) | ❌ | ✓ | ISBN unik |
| `category_id` | BIGINT UNSIGNED | ❌ | ❌ | FK ke categories |
| `publisher` | VARCHAR(255) | ❌ | ❌ | Penerbit |
| `year_published` | INT | ❌ | ❌ | Tahun terbit |
| `stock` | INT | ❌ | ❌ | Jumlah stok |
| `description` | TEXT | ✓ | ❌ | Deskripsi buku |
| `cover_image` | VARCHAR(255) | ✓ | ❌ | Path gambar cover |
| `created_at` | TIMESTAMP | ✓ | ❌ | Waktu pembuatan |
| `updated_at` | TIMESTAMP | ✓ | ❌ | Waktu perubahan terakhir |

#### Constraints & Indexes

```sql
-- Foreign Key
FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE RESTRICT

-- Unique Constraint
UNIQUE KEY unique_isbn (isbn)

-- Search Indexes
INDEX idx_title (title)
INDEX idx_author (author)
INDEX idx_category_id (category_id)
```

#### Sample Data

```sql
INSERT INTO books VALUES (
    1, 
    'Laskar Pelangi',
    'Andrea Hirata',
    '978-602-7310-XX-X',
    1,  -- Category: Fiksi
    'Bentang Pustaka',
    2005,
    4,  -- Stok 4 copy
    'Laskar Pelangi adalah novel terbaik...',
    '/covers/laskar-pelangi.jpg',
    NOW(),
    NOW()
);
```

---

### 4. Borrowings Table

**Purpose:** Menyimpan transaksi peminjaman buku

**Location:** `database/migrations/0001_01_01_000003_create_borrowings_table.php`

#### Schema

```sql
CREATE TABLE borrowings (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT UNSIGNED NOT NULL,
    book_id BIGINT UNSIGNED NOT NULL,
    borrow_date DATE NOT NULL,
    due_date DATE NOT NULL,
    return_date DATE NULL,
    status ENUM('borrowed', 'returned', 'overdue') NOT NULL DEFAULT 'borrowed',
    fine_amount INT NOT NULL DEFAULT 0,
    notes TEXT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (book_id) REFERENCES books(id) ON DELETE RESTRICT
);
```

#### Fields Description

| Field | Type | Nullable | Unique | Notes |
|-------|------|----------|--------|-------|
| `id` | BIGINT UNSIGNED | ❌ | ✓ | Primary key |
| `user_id` | BIGINT UNSIGNED | ❌ | ❌ | FK ke users (cascade delete) |
| `book_id` | BIGINT UNSIGNED | ❌ | ❌ | FK ke books (restrict delete) |
| `borrow_date` | DATE | ❌ | ❌ | Tanggal peminjaman |
| `due_date` | DATE | ❌ | ❌ | Tanggal jatuh tempo |
| `return_date` | DATE | ✓ | ❌ | Tanggal pengembalian |
| `status` | ENUM | ❌ | ❌ | Status: borrowed, returned, overdue |
| `fine_amount` | INT | ❌ | ❌ | Jumlah denda (Rp) |
| `notes` | TEXT | ✓ | ❌ | Catatan tambahan |
| `created_at` | TIMESTAMP | ✓ | ❌ | Waktu pembuatan |
| `updated_at` | TIMESTAMP | ✓ | ❌ | Waktu perubahan terakhir |

#### Constraints & Indexes

```sql
-- Foreign Keys
FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
FOREIGN KEY (book_id) REFERENCES books(id) ON DELETE RESTRICT

-- Search/Filter Indexes
INDEX idx_user_id (user_id)
INDEX idx_book_id (book_id)
INDEX idx_status (status)
INDEX idx_borrow_date (borrow_date)
INDEX idx_due_date (due_date)
```

#### Status Values

| Status | Warna | Arti |
|--------|-------|------|
| `borrowed` | 🔵 Biru | Buku sedang dipinjam, belum jatuh tempo |
| `overdue` | 🔴 Merah | Buku sudah melewati jatuh tempo |
| `returned` | 🟢 Hijau | Buku sudah dikembalikan |

#### Sample Data

```sql
-- Peminjaman aktif
INSERT INTO borrowings VALUES (
    1,
    2,  -- User: Budi Santoso
    1,  -- Book: Laskar Pelangi
    '2026-03-10',
    '2026-03-17',
    NULL,  -- Belum dikembalikan
    'borrowed',
    0,  -- Belum ada denda
    NULL,
    NOW(),
    NOW()
);

-- Peminjaman terlambat
INSERT INTO borrowings VALUES (
    2,
    5,  -- User: Hendra
    3,  -- Book: Kaya Mulai dari Mulai
    '2026-03-01',
    '2026-03-08',
    NULL,  -- Belum dikembalikan
    'overdue',
    6000,  -- Denda 6 hari × Rp 1.000
    'Terlambat',
    NOW(),
    NOW()
);

-- Peminjaman yang sudah dikembalikan
INSERT INTO borrowings VALUES (
    3,
    3,  -- User: Andi
    2,  -- Book: Cosmos
    '2026-02-15',
    '2026-02-22',
    '2026-02-22',
    'returned',
    0,  -- Tepat waktu
    NULL,
    NOW(),
    NOW()
);
```

---

## 🔗 Relationships

### Entity Relationship Diagram (ERD)

```
┌─────────────────────┐
│      User           │  (1)
├─────────────────────┤
│ id (PK)             │
│ name                │────────┐
│ email (UNIQUE)      │        │
│ password            │        │ (1:M)
│ role (ENUM)         │        │
│ phone               │        │
│ address             │        │
└─────────────────────┘        │
                               │
                               ↓
                      ┌─────────────────────┐
                      │   Borrowing (M)     │
                      ├─────────────────────┤
                      │ id (PK)             │
                      │ user_id (FK)        │
                      │ book_id (FK)        │
                      │ borrow_date         │
                      │ due_date            │
         ┌────────────┤ return_date         │
         │            │ status (ENUM)       │
         │            │ fine_amount         │
         │            └─────────────────────┘
         │                    (M)
         │                     |
    (M:1)|                (M:1)|
         │                     ↓
    ┌────┴──────────────────────┐
    │       Book (1)             │
    ├────────────────────────────┤
    │ id (PK)                    │
    │ title                      │
    │ author                     │
    │ isbn (UNIQUE)              │
    │ category_id (FK)           │
    │ publisher      ┌───────────┤
    │ year_published │           │ (M:1)
    │ stock          │           │
    │ description    │           │
    │ cover_image    │           ↓
    └────────────────┼──────────────────┐
                     │                  │
                     │              ┌─────────────────────┐
                     └─────────────→│   Category (1)      │
                                    ├─────────────────────┤
                                    │ id (PK)             │
                                    │ name (UNIQUE)       │
                                    │ description         │
                                    └─────────────────────┘
```

### Relationship Types

#### User (1) ← → (M) Borrowing
```php
// User Model
public function borrowings(): HasMany {
    return $this->hasMany(Borrowing::class);
}

// Borrowing Model
public function user(): BelongsTo {
    return $this->belongsTo(User::class);
}

// Usage
$user = User::find(1);
$borrowings = $user->borrowings; // Semua peminjaman user
```

#### Book (1) ← → (M) Borrowing
```php
// Book Model
public function borrowings(): HasMany {
    return $this->hasMany(Borrowing::class);
}

// Borrowing Model
public function book(): BelongsTo {
    return $this->belongsTo(Book::class);
}

// Usage
$book = Book::find(1);
$borrowings = $book->borrowings; // Semua peminjaman buku
```

#### Category (1) ← → (M) Book
```php
// Category Model
public function books(): HasMany {
    return $this->hasMany(Book::class);
}

// Book Model
public function category(): BelongsTo {
    return $this->belongsTo(Category::class);
}

// Usage
$category = Category::find(1);
$books = $category->books; // Semua buku dalam kategori
```

---

## 🔄 Migrations

### Migration Files

```
database/migrations/
├── 0001_01_01_000000_create_users_table.php
├── 0001_01_01_000001_create_categories_table.php
├── 0001_01_01_000002_create_books_table.php
└── 0001_01_01_000003_create_borrowings_table.php
```

### Running Migrations

```bash
# Run all pending migrations
php artisan migrate

# Run specific migration
php artisan migrate --path=database/migrations/0001_01_01_000000_create_users_table.php

# Rollback last batch
php artisan migrate:rollback

# Rollback all
php artisan migrate:reset

# Fresh (drop all + migrate)
php artisan migrate:fresh

# Fresh with seeding
php artisan migrate:fresh --seed

# Check status
php artisan migrate:status
```

### Example: Creating New Migration

```bash
php artisan make:migration add_new_field_to_books_table --table=books
```

Edit `database/migrations/XXXX_add_new_field_to_books_table.php`:

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->string('new_field')->nullable()->after('stock');
        });
    }

    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropColumn('new_field');
        });
    }
};
```

---

## 🔍 Indexing Strategy

### Indexes in Current Database

#### Users Table
```sql
INDEX idx_email (email)         -- Email lookups
INDEX idx_role (role)           -- Filter by role
```

#### Categories Table
```sql
INDEX idx_name (name)           -- Search by name
```

#### Books Table
```sql
INDEX idx_title (title)         -- Search books
INDEX idx_author (author)       -- Search by author
INDEX idx_category_id (category_id)  -- Filter by category
INDEX idx_isbn (isbn)           -- ISBN search
```

#### Borrowings Table
```sql
INDEX idx_user_id (user_id)     -- User borrowings
INDEX idx_book_id (book_id)     -- Book borrowings
INDEX idx_status (status)       -- Filter by status
INDEX idx_borrow_date (borrow_date)    -- Date range
INDEX idx_due_date (due_date)          -- Find overdue
```

### Adding New Index

```bash
# Create migration
php artisan make:migration add_index_to_borrowings_table --table=borrowings
```

```php
public function up(): void
{
    Schema::table('borrowings', function (Blueprint $table) {
        $table->index(['user_id', 'status']); // Composite index
    });
}
```

---

## 💾 Backup & Recovery

### Manual Backup

```bash
# Dump database to SQL file
mysqldump -u root task_book > backup_task_book.sql

# With timestamp
mysqldump -u root task_book > backup_task_book_$(date +%Y%m%d_%H%M%S).sql
```

### Restore from Backup

```bash
# Restore database
mysql -u root < backup_task_book.sql

# Or:
mysql -u root task_book < backup_task_book.sql
```

### Automated Backup Script

Create `backup.sh`:

```bash
#!/bin/bash

BACKUP_DIR="/path/to/backups"
DB_NAME="task_book"
TIMESTAMP=$(date +%Y%m%d_%H%M%S)

mkdir -p $BACKUP_DIR

mysqldump -u root $DB_NAME > $BACKUP_DIR/backup_${TIMESTAMP}.sql

# Keep only last 30 days
find $BACKUP_DIR -name "backup_*.sql" -mtime +30 -delete

echo "Backup completed: $BACKUP_DIR/backup_${TIMESTAMP}.sql"
```

Run via cron:

```bash
# Daily backup at 2 AM
0 2 * * * /path/to/backup.sh
```

---

## ⚡ Performance Optimization

### Query Optimization

#### 1. Use Eager Loading

```php
// ❌ Bad: N+1 problem
$borrowings = Borrowing::all();
foreach ($borrowings as $borrowing) {
    echo $borrowing->user->name; // Extra query per row!
}

// ✅ Good: Eager loading
$borrowings = Borrowing::with('user', 'book')->get();
foreach ($borrowings as $borrowing) {
    echo $borrowing->user->name; // No extra queries
}
```

#### 2. Use Pagination

```php
// ❌ Bad: Load all records
$books = Book::all();

// ✅ Good: Paginate results
$books = Book::paginate(15);
```

#### 3. Selective Fields

```php
// ❌ Bad: Select all columns
$books = Book::all();

// ✅ Good: Select only needed fields
$books = Book::select('id', 'title', 'author')->get();
```

### Database Optimization

```bash
# Optimize all tables
php artisan tinker
>>> DB::statement('OPTIMIZE TABLE users, categories, books, borrowings;')

# Check table status
ANALYZE TABLE books;

# Show statistics
SHOW TABLE STATUS FROM task_book;
```

---

## 📝 Common Queries

### User Queries

```sql
-- Get all users
SELECT * FROM users;

-- Get all members
SELECT * FROM users WHERE role = 'member';

-- Get admin count
SELECT COUNT(*) FROM users WHERE role = 'admin';

-- Get user with email
SELECT * FROM users WHERE email = 'budi@example.com';
```

### Book Queries

```sql
-- All books in category
SELECT * FROM books WHERE category_id = 1;

-- Books with low stock
SELECT * FROM books WHERE stock < 3;

-- Books by author
SELECT * FROM books WHERE author LIKE '%Andrea%';

-- Count books by category
SELECT category_id, COUNT(*) as count
FROM books
GROUP BY category_id;
```

### Borrowing Queries

```sql
-- Active borrowings
SELECT * FROM borrowings WHERE status = 'borrowed';

-- Overdue borrowings
SELECT * FROM borrowings WHERE status = 'overdue';

-- Member's borrowing history
SELECT b.*, bk.title, bk.author
FROM borrowings b
JOIN books bk ON b.book_id = bk.id
WHERE b.user_id = 2
ORDER BY b.created_at DESC;

-- Total fines per member
SELECT user_id, SUM(fine_amount) as total_fine
FROM borrowings
GROUP BY user_id
HAVING total_fine > 0;

-- Books never borrowed
SELECT * FROM books
WHERE id NOT IN (SELECT DISTINCT book_id FROM borrowings);

-- Borrowings due today
SELECT * FROM borrowings
WHERE due_date = DATE(NOW())
AND status = 'borrowed';
```

### Analytics Queries

```sql
-- Most borrowed books
SELECT b.id, b.title, COUNT(br.id) as borrow_count
FROM books b
LEFT JOIN borrowings br ON b.id = br.book_id
GROUP BY b.id
ORDER BY borrow_count DESC
LIMIT 10;

-- Member activity
SELECT u.id, u.name, COUNT(br.id) as total_borrows
FROM users u
LEFT JOIN borrowings br ON u.id = br.user_id
WHERE u.role = 'member'
GROUP BY u.id
ORDER BY total_borrows DESC;

-- Total fines collected
SELECT SUM(fine_amount) as total_fines
FROM borrowings;

-- Average borrowing duration
SELECT AVG(DATEDIFF(return_date, borrow_date)) as avg_days
FROM borrowings
WHERE return_date IS NOT NULL;
```

---

## ⚠️ Foreign Key Constraints

### Delete Rules

#### CASCADE
```sql
-- Ketika user dihapus, semua borrowing mereka juga dihapus
FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
```

**Digunakan untuk:** user_id dalam borrowings
**Alasan:** Jika member dihapus, data peminjaman mereka tidak perlu disimpan

#### RESTRICT
```sql
-- Tidak bisa hapus buku jika masih ada borrowing
FOREIGN KEY (book_id) REFERENCES books(id) ON DELETE RESTRICT
```

**Digunakan untuk:** book_id dalam borrowings, category_id dalam books
**Alasan:** Menjaga integritas data historis

---

## 📊 Database Statistics

### Current Database Size

```bash
# Check database size
mysql -u root -e "SELECT 
    table_name,
    ROUND(((data_length + index_length) / 1024 / 1024), 2) AS size_mb
FROM information_schema.TABLES
WHERE table_schema = 'task_book'
ORDER BY size_mb DESC;"
```

### Table Record Counts

```bash
mysql -u root task_book -e "
SELECT 
    table_name,
    TABLE_ROWS as record_count
FROM INFORMATION_SCHEMA.TABLES
WHERE TABLE_SCHEMA = 'task_book';"
```

---

**Last Updated:** 16 Maret 2026  
**Next Review:** 30 April 2026
