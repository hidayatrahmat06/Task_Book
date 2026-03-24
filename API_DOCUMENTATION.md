# 🔌 API_DOCUMENTATION.md - Dokumentasi Backend & Routes

> Referensi lengkap untuk semua endpoint dan functionality backend

**Versi:** 1.0.0  
**Base URL:** `http://localhost:8000` (dev) | `https://perpustakaan.local` (prod)  
**Last Updated:** 16 Maret 2026

---

## 📖 Daftar Isi

1. [API Overview](#api-overview)
2. [Authentication Routes](#authentication-routes)
3. [Dashboard Routes](#dashboard-routes)
4. [Books Routes](#books-routes)
5. [Borrowings Routes](#borrowings-routes)
6. [Response Format](#response-format)
7. [Error Handling](#error-handling)

---

## 🎯 API Overview

### Architecture

```
HTTP Request
    ↓
Route Dispatcher (routes/web.php)
    ↓
Middleware Stack
    ├─ Session Auth
    ├─ Verify CSRF
    └─ Admin/Guest checks
    ↓
Controller Method
    ├─ Validate Input
    ├─ Query Database
    └─ Process Logic
    ↓
Response (View/Redirect)
```

### Base Configuration

```php
// config/app.php
'url' => env('APP_URL', 'http://localhost:8000'),
'debug' => env('APP_DEBUG', false),

// routes/web.php
// All routes are web routes (not API/JSON)
// Returns HTML views or redirects
```

---

## 🔐 Authentication Routes

### 1. Show Login Form

**Route:** `GET /login`  
**Method:** GET  
**Auth Required:** No  
**Controller:** `LoginController@create`

**Request:**
```http
GET /login HTTP/1.1
Host: localhost:8000
```

**Response:**
```
Status: 200 OK
Content-Type: text/html; charset=UTF-8
Body: HTML form page
```

**View:** `auth/login.blade.php`

---

### 2. Process Login

**Route:** `POST /login`  
**Method:** POST  
**Auth Required:** No  
**Controller:** `LoginController@store`

**Request:**
```http
POST /login HTTP/1.1
Host: localhost:8000
Content-Type: application/x-www-form-urlencoded

email=admin@library.com&password=Admin123!&token=<csrf_token>
```

**Validation Rules:**
```
email:     required|email|exists:users
password:  required|min:6
```

**Response (Success):**
```
Status: 302 Found
Location: http://localhost:8000/dashboard
Set-Cookie: XSRF-TOKEN=...
Set-Cookie: laravel_session=...
```

**Response (Failure):**
```
Status: 302 Found
Location: http://localhost:8000/login
Session Flash: 'error' => 'Email atau password salah'
```

---

### 3. Show Register Form

**Route:** `GET /register`  
**Method:** GET  
**Auth Required:** No  
**Controller:** `RegisterController@create`

**Request:**
```http
GET /register HTTP/1.1
Host: localhost:8000
```

**Response:**
```
Status: 200 OK
Body: HTML registration form
```

---

### 4. Process Registration

**Route:** `POST /register`  
**Method:** POST  
**Auth Required:** No  
**Controller:** `RegisterController@store`

**Request:**
```http
POST /register HTTP/1.1
Host: localhost:8000
Content-Type: application/x-www-form-urlencoded

name=John Doe&
email=john@example.com&
phone=081234567890&
address=Jalan ABC No. 1&
password=Password123&
password_confirmation=Password123&
token=<csrf_token>
```

**Validation Rules:**
```
name:                  required|string|max:255
email:                 required|email|unique:users
phone:                 required|string|max:20
address:               required|string
password:              required|min:8|confirmed
password_confirmation: required
```

**Response (Success):**
```
Status: 302 Found
Location: http://localhost:8000/dashboard
Session: User logged in as 'member' role
```

**Response (Failure):**
```
Status: 302 Found
Location: http://localhost:8000/register
Errors: {'email' => 'Email sudah terdaftar', ...}
```

---

### 5. Logout

**Route:** `POST /logout`  
**Method:** POST  
**Auth Required:** Yes  
**Controller:** `LoginController@destroy`

**Request:**
```http
POST /logout HTTP/1.1
Host: localhost:8000
Cookie: laravel_session=...
```

**Response:**
```
Status: 302 Found
Location: http://localhost:8000
Session: Cleared
```

---

## 📊 Dashboard Routes

### Show Dashboard

**Route:** `GET /dashboard`  
**Method:** GET  
**Auth Required:** Yes (Middleware: 'auth')  
**Controller:** `DashboardController@index`

**Request:**
```http
GET /dashboard HTTP/1.1
Host: localhost:8000
Cookie: laravel_session=...
```

**Response (Admin User):**
```
Status: 200 OK
Body: admin dashboard view
Data:
  - totalBooks: integer
  - totalMembers: integer
  - totalBorrowings: integer
  - overdueCount: integer
  - totalFines: integer
  - recentBorrowings: Borrowing[]
  - overdueBorrowings: Borrowing[]
```

**Response (Member User):**
```
Status: 200 OK
Body: member dashboard view
Data:
  - user: User
  - activeBorrowings: integer
  - completedBorrowings: integer
  - totalFines: integer
  - borrowingHistory: Borrowing[]
```

**View:** `dashboard/admin.blade.php` or `dashboard/member.blade.php`

---

## 📚 Books Routes

### 1. List Books

**Route:** `GET /books`  
**Method:** GET  
**Auth Required:** No  
**Controller:** `BooksController@index`

**Query Parameters:**
```
?search=judul          # Search by title/author/isbn
?category=1            # Filter by category_id
?sort=newest           # Sort: newest, oldest, title
?page=2                # Pagination page
```

**Request:**
```http
GET /books?search=laskar&category=1&sort=newest HTTP/1.1
Host: localhost:8000
```

**Response:**
```
Status: 200 OK
View: books/index.blade.php
Data:
{
  books: Paginator {
    current_page: 1,
    data: [
      {
        id: 1,
        title: "Laskar Pelangi",
        author: "Andrea Hirata",
        isbn: "978-602-7310-...",
        category_id: 1,
        stock: 4,
        created_at: "2026-03-01 10:00:00"
      },
      ...
    ],
    per_page: 12,
    total: 10,
    last_page: 1
  },
  categories: Category[]
}
```

---

### 2. Show Create Book Form

**Route:** `GET /books/create`  
**Method:** GET  
**Auth Required:** Yes  
**Middleware:** admin  
**Controller:** `BooksController@create`

**Request:**
```http
GET /books/create HTTP/1.1
Host: localhost:8000
Cookie: laravel_session=...
```

**Response:**
```
Status: 200 OK
View: books/create.blade.php
Data:
{
  categories: Category[]
}
```

---

### 3. Store New Book

**Route:** `POST /books`  
**Method:** POST  
**Auth Required:** Yes  
**Middleware:** admin  
**Controller:** `BooksController@store`  
**Request Validation:** BookRequest

**Request:**
```http
POST /books HTTP/1.1
Host: localhost:8000
Content-Type: multipart/form-data

title=New Book
author=Author Name
isbn=978-602-XXXX-XX-X
category_id=1
publisher=Publisher Name
year_published=2026
stock=5
cover_image=@/path/to/image.jpg
description=Book description...
```

**Validation Rules:** [See BookRequest]

**Response (Success):**
```
Status: 302 Found
Location: /books/11
Session Flash: 'success' => 'Buku berhasil ditambahkan'
```

**Response (Validation Error):**
```
Status: 302 Found
Location: /books/create
Session Errors: {title, author, isbn, ...}
```

---

### 4. Show Book Details

**Route:** `GET /books/{book}`  
**Method:** GET  
**Auth Required:** No  
**Controller:** `BooksController@show`

**Request:**
```http
GET /books/1 HTTP/1.1
Host: localhost:8000
```

**Response:**
```
Status: 200 OK
View: books/show.blade.php
Data:
{
  book: Book {
    id: 1,
    title: "Laskar Pelangi",
    author: "Andrea Hirata",
    isbn: "978-602-7310-XX-X",
    category: Category {
      id: 1,
      name: "Fiksi"
    },
    publisher: "Bentang Pustaka",
    year_published: 2005,
    stock: 4,
    description: "...",
    cover_image: "/storage/covers/laskar-pelangi.jpg",
    borrowing_count: 2,
    is_available: true
  }
}
```

---

### 5. Show Edit Book Form

**Route:** `GET /books/{book}/edit`  
**Method:** GET  
**Auth Required:** Yes  
**Middleware:** admin  
**Controller:** `BooksController@edit`

**Request:**
```http
GET /books/1/edit HTTP/1.1
Host: localhost:8000
```

**Response:**
```
Status: 200 OK
View: books/edit.blade.php
Data:
{
  book: Book { ... },
  categories: Category[]
}
```

---

### 6. Update Book

**Route:** `PUT /books/{book}`  
**Method:** PUT or POST (_method=PUT)  
**Auth Required:** Yes  
**Middleware:** admin  
**Controller:** `BooksController@update`

**Request:**
```http
PUT /books/1 HTTP/1.1
Host: localhost:8000
Content-Type: multipart/form-data

title=Updated Title
stock=3
_method=PUT
```

**Response (Success):**
```
Status: 302 Found
Location: /books/1
Session Flash: 'success' => 'Buku berhasil diperbarui'
```

---

### 7. Delete Book

**Route:** `DELETE /books/{book}`  
**Method:** DELETE or POST (_method=DELETE)  
**Auth Required:** Yes  
**Middleware:** admin  
**Controller:** `BooksController@destroy`

**Request:**
```http
DELETE /books/1 HTTP/1.1
Host: localhost:8000
Content-Type: application/x-www-form-urlencoded

_method=DELETE&_token=<csrf_token>
```

**Validation:**
- No active borrowings for this book
- Stock must be clearable

**Response (Success):**
```
Status: 302 Found
Location: /books
Session Flash: 'success' => 'Buku berhasil dihapus'
```

**Response (Protected):**
```
Status: 302 Found
Location: /books/1
Session Flash: 'error' => 'Tidak bisa menghapus. Buku masih dipinjam.'
```

---

## 📋 Borrowings Routes

### 1. List Borrowings

**Route:** `GET /borrowings`  
**Method:** GET  
**Auth Required:** Yes  
**Controller:** `BorrowingsController@index`

**Request:**
```http
GET /borrowings HTTP/1.1
Host: localhost:8000
Cookie: laravel_session=...
```

**Response (Admin):**
```
Status: 200 OK
View: borrowings/index.blade.php
Data:
{
  borrowings: Paginator {
    current_page: 1,
    data: [
      {
        id: 1,
        user: User { id: 2, name: "Budi" },
        book: Book { id: 1, title: "Laskar Pelangi" },
        borrow_date: "2026-03-10",
        due_date: "2026-03-17",
        return_date: null,
        status: "borrowed",
        fine_amount: 0
      },
      ...
    ],
    per_page: 15,
    total: 5
  }
}
```

**Response (Member):**
```
Status: 200 OK
Data: Only their own borrowings
```

---

### 2. Show Create Borrowing Form

**Route:** `GET /borrowings/create`  
**Method:** GET  
**Auth Required:** Yes  
**Controller:** `BorrowingsController@create`

**Request:**
```http
GET /borrowings/create HTTP/1.1
Host: localhost:8000
Cookie: laravel_session=...
```

**Response:**
```
Status: 200 OK
View: borrowings/create.blade.php
Data:
{
  books: Paginator[] # Available books (stock > 0)
  members: User[]    # For admin to select (if admin)
}
```

---

### 3. Create Borrowing

**Route:** `POST /borrowings`  
**Method:** POST  
**Auth Required:** Yes  
**Controller:** `BorrowingsController@store`

**Request (Member):**
```http
POST /borrowings HTTP/1.1
Host: localhost:8000
Content-Type: application/x-www-form-urlencoded

book_id=1&_token=<csrf_token>
```

**Request (Admin creating for member):**
```http
POST /borrowings HTTP/1.1
Host: localhost:8000
Content-Type: application/x-www-form-urlencoded

book_id=1&user_id=2&_token=<csrf_token>
```

**Validation:**
```
book_id:  required|exists:books
user_id:  (optional, only if admin) exists:users where role=member
```

**Business Logic:**
```
1. Check book stock > 0
2. Check member doesn't already have this book borrowed
3. Create borrowing record:
   - borrow_date = today
   - due_date = today + 7 days
   - status = 'borrowed'
   - fine_amount = 0
4. Decrement book stock (-1)
```

**Response (Success):**
```
Status: 302 Found
Location: /borrowings/1
Session Flash: 'success' => 'Peminjaman berhasil dibuat'
```

**Response (Failure):**
```
Status: 302 Found
Location: /borrowings/create
Session Error: 'Book not available' or 'You already have this book'
```

---

### 4. Show Borrowing Details

**Route:** `GET /borrowings/{borrowing}`  
**Method:** GET  
**Auth Required:** Yes  
**Authorization:** Check via BorrowingPolicy  
**Controller:** `BorrowingsController@show`

**Request:**
```http
GET /borrowings/1 HTTP/1.1
Host: localhost:8000
```

**Response:**
```
Status: 200 OK
View: borrowings/show.blade.php
Data:
{
  borrowing: Borrowing {
    id: 1,
    user: User { id: 2, name: "Budi Santoso" },
    book: Book { id: 1, title: "Laskar Pelangi" },
    borrow_date: "2026-03-10",
    due_date: "2026-03-17",
    return_date: null,
    status: "borrowed",
    fine_amount: 0,
    calculated_fine: 0,  # Calculated if overdue
    days_overdue: 0,
    is_overdue: false
  }
}
```

---

### 5. Return Book

**Route:** `POST /borrowings/{borrowing}/return`  
**Method:** POST  
**Auth Required:** Yes  
**Middleware:** admin  
**Controller:** `BorrowingsController@return`

**Request:**
```http
POST /borrowings/1/return HTTP/1.1
Host: localhost:8000
Content-Type: application/x-www-form-urlencoded

_method=PATCH&_token=<csrf_token>
```

**Business Logic:**
```
1. Get borrowing record
2. Check if already returned
3. Calculate fine:
   IF due_date < today:
     days_overdue = today - due_date
     fine = days_overdue * 1000
   ELSE:
     fine = 0
4. Update borrowing:
   - return_date = today
   - status = 'returned' (or 'overdue' if late)
   - fine_amount = calculated fine
5. Increment book stock (+1)
```

**Response (Success):**
```
Status: 302 Found
Location: /borrowings/1
Session Flash: 'success' => 'Buku berhasil dikembalikan'
  OR if late: 'warning' => 'Buku terlambat. Denda: Rp X.XXX'
```

---

### 6. Delete Borrowing (Admin Only)

**Route:** `DELETE /borrowings/{borrowing}`  
**Method:** DELETE or POST (_method=DELETE)  
**Auth Required:** Yes  
**Middleware:** admin  
**Controller:** `BorrowingsController@destroy`

**Request:**
```http
DELETE /borrowings/1 HTTP/1.1
Host: localhost:8000
```

**Business Logic:**
```
1. Get borrowing record
2. If status = 'borrowed':
   - Increment book stock back
3. Delete borrowing record
```

**Response (Success):**
```
Status: 302 Found
Location: /borrowings
Session Flash: 'success' => 'Peminjaman berhasil dihapus'
```

---

## 📤 Response Format

### Standard View Response

```php
return view('books.index', [
    'books' => $books,
    'categories' => $categories,
]);
```

**HTML Response:**
```
Status: 200 OK
Content-Type: text/html; charset=UTF-8
Set-Cookie: XSRF-TOKEN=...
Body: Rendered Blade template
```

---

### Standard Redirect Response

```php
return redirect()
    ->route('books.show', $book)
    ->with('success', 'Buku berhasil ditambahkan');
```

**Redirect Response:**
```
Status: 302 Found
Location: /books/1
Set-Cookie: XSRF-TOKEN=...
Session Flash: {
    'success': 'Buku berhasil ditambahkan'
}
```

---

### Error Response

```php
return redirect()
    ->back()
    ->withErrors($validator);
```

**Error Response:**
```
Status: 302 Found
Location: <previous>
Session Errors: {
    'title': 'Judul wajib diisi',
    'isbn': 'ISBN sudah terdaftar'
}
```

---

## ⚠️ Error Handling

### HTTP Status Codes

| Code | Meaning | Example |
|------|---------|---------|
| 200 | OK | View rendered |
| 302 | Redirect | After successful POST |
| 400 | Bad Request | Invalid input |
| 401 | Unauthorized | Not logged in |
| 403 | Forbidden | No permission |
| 404 | Not Found | Resource doesn't exist |
| 409 | Conflict | Duplicate/Business logic error |
| 422 | Validation Failed | Form validation error |
| 500 | Server Error | Application error |

---

### Flash Messages Types

#### Success
```blade
@if ($message = Session::get('success'))
    <div class="alert alert-success">{{ $message }}</div>
@endif
```

#### Error
```blade
@if ($message = Session::get('error'))
    <div class="alert alert-danger">{{ $message }}</div>
@endif
```

#### Warning
```blade
@if ($message = Session::get('warning'))
    <div class="alert alert-warning">{{ $message }}</div>
@endif
```

---

## 🔒 Security

### CSRF Protection

All POST/PUT/DELETE requests require CSRF token:

```blade
<form method="POST">
    @csrf
    <!-- form fields -->
</form>
```

### Authentication Middleware

```php
Route::middleware('auth')->group(function () {
    // Routes here require login
});
```

### Authorization with Policies

```php
// Check in controller
$this->authorize('update', $borrowing);

// Check in blade
@can('delete', $book)
    [Delete Button]
@endcan
```

---

**Last Updated:** 16 Maret 2026  
**Next Update:** 30 April 2026
