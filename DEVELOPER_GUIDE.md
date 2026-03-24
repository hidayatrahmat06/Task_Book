# 👨‍💻 DEVELOPER GUIDE - Panduan Pengembang

> Panduan lengkap untuk developer yang ingin mengembangkan dan maintain sistem

**Versi:** 1.0.0  
**Last Updated:** 16 Maret 2026  
**Target Audience:** Backend Developer, Full-Stack Developer

---

## 📖 Daftar Isi

1. [Project Setup](#project-setup)
2. [Project Structure](#project-structure)
3. [Architecture Overview](#architecture-overview)
4. [Coding Standards](#coding-standards)
5. [Development Workflow](#development-workflow)
6. [Database Development](#database-development)
7. [Adding Features](#adding-features)
8. [Testing](#testing)
9. [Debugging](#debugging)

---

## 🚀 Project Setup

### Prerequisites

```bash
# System Requirements
- PHP 8.1+
- MySQL 8.0+
- Composer 2.x
- Node.js 16+ (untuk frontend assets)
- Laravel Herd (untuk MacOS)
```

### Installation Steps

#### 1. Clone atau ekstrak project
```bash
cd /Users/rahmat/Herd/task_book
```

#### 2. Install PHP dependencies
```bash
composer install
```

#### 3. Install JavaScript dependencies
```bash
npm install
```

#### 4. Copy environment file
```bash
cp .env.example .env
```

#### 5. Generate APP_KEY
```bash
php artisan key:generate
```

#### 6. Setup Database
```bash
# Konfigurasi di .env terlebih dahulu
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=task_book
DB_USERNAME=root
DB_PASSWORD=
```

#### 7. Run migrations & seeders
```bash
php artisan migrate:fresh --seed
```

#### 8. Start development server
```bash
php artisan serve
```

Server akan berjalan di: `http://localhost:8000`

---

## 📁 Project Structure

```
task_book/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── DashboardController.php       # Dashboard logic
│   │   │   ├── BooksController.php            # Books CRUD
│   │   │   ├── BorrowingsController.php       # Borrowings logic
│   │   │   ├── LoginController.php            # Auth login
│   │   │   └── RegisterController.php         # Auth registration
│   │   ├── Middleware/
│   │   │   └── AdminMiddleware.php            # Admin role check
│   │   └── Requests/
│   │       └── BookRequest.php                # Book validation
│   ├── Models/
│   │   ├── User.php                           # User model
│   │   ├── Category.php                       # Category model
│   │   ├── Book.php                           # Book model
│   │   └── Borrowing.php                      # Borrowing model
│   ├── Policies/
│   │   └── BorrowingPolicy.php                # Authorization policy
│   └── Providers/
│       └── AppServiceProvider.php             # App configuration
│
├── bootstrap/
│   ├── app.php                                # App instantiation
│   └── providers.php                          # Service provider registration
│
├── config/
│   ├── app.php                                # App config
│   ├── auth.php                               # Auth config
│   ├── database.php                           # Database config
│   └── [other configs...]
│
├── database/
│   ├── factories/
│   │   └── UserFactory.php                    # Factory untuk testing
│   ├── migrations/
│   │   ├── 0001_01_01_000000_create_users_table.php
│   │   ├── 0001_01_01_000001_create_categories_table.php
│   │   ├── 0001_01_01_000002_create_books_table.php
│   │   └── 0001_01_01_000003_create_borrowings_table.php
│   └── seeders/
│       ├── DatabaseSeeder.php                 # Main seeder orchestrator
│       ├── UserSeeder.php                     # Seed users
│       ├── CategorySeeder.php                 # Seed categories
│       ├── BookSeeder.php                     # Seed books
│       └── BorrowingSeeder.php                # Seed borrowings
│
├── resources/
│   ├── css/
│   │   └── app.css                            # Custom CSS
│   ├── js/
│   │   ├── app.js                             # Main JS
│   │   └── bootstrap.js                       # Bootstrap setup
│   └── views/
│       ├── layouts/
│       │   ├── app.blade.php                  # Main layout
│       │   └── guest.blade.php                # Guest layout
│       ├── auth/
│       │   ├── login.blade.php
│       │   └── register.blade.php
│       ├── dashboard/
│       │   ├── admin.blade.php
│       │   └── member.blade.php
│       ├── books/
│       │   ├── index.blade.php
│       │   ├── create.blade.php
│       │   ├── edit.blade.php
│       │   └── show.blade.php
│       ├── borrowings/
│       │   ├── index.blade.php
│       │   ├── create.blade.php
│       │   └── show.blade.php
│       └── welcome.blade.php
│
├── routes/
│   ├── web.php                                # Web routes
│   └── console.php                            # Console commands
│
├── storage/
│   ├── app/                                   # File storage
│   ├── logs/                                  # Application logs
│   └── framework/                             # Framework cache
│
├── tests/
│   ├── Feature/                               # Feature tests
│   └── Unit/                                  # Unit tests
│
├── vendor/                                    # Composer packages
├── public/                                    # Public assets
├── .env                                       # Environment variables
├── .env.example                               # Example env
├── artisan                                    # Laravel CLI
├── composer.json                              # PHP dependencies
├── package.json                               # JS dependencies
├── phpunit.xml                                # PHPUnit config
└── vite.config.js                             # Vite config
```

---

## 🏗️ Architecture Overview

### MVC Architecture

```
Request
  ↓
Routes/Middleware
  ↓
Controller (DashboardController, BooksController, etc)
  ↓
Model (User, Book, Borrowing, Category)
  ↓
Database (MySQL)
  ↓
Response/View (Blade Template)
```

### Request Flow Diagram

```
┌─────────────┐
│   Browser   │
└──────┬──────┘
       │ HTTP Request
       ↓
┌─────────────────────────────────────┐
│ routes/web.php (Check route match)  │
└────────────┬────────────────────────┘
             │
             ↓
┌─────────────────────────────────────┐
│ Middleware (Auth, AdminMiddleware)  │
└────────────┬────────────────────────┘
             │
             ↓
┌─────────────────────────────────────┐
│ Controller (BooksController@index)  │
│ • Validate input                    │
│ • Call Model methods                │
│ • Prepare data                      │
└────────────┬────────────────────────┘
             │
             ↓
┌─────────────────────────────────────┐
│ Model (Book::where()->get())        │
│ • Query database                    │
│ • Apply relationships               │
│ • Return data                       │
└────────────┬────────────────────────┘
             │
             ↓
┌─────────────────────────────────────┐
│ Controller returns View              │
│ view('books.index', $data)          │
└────────────┬────────────────────────┘
             │
             ↓
┌─────────────────────────────────────┐
│ Blade Template (books/index.blade)  │
│ • Render HTML                       │
│ • Apply TailwindCSS styling         │
└────────────┬────────────────────────┘
             │
             ↓
┌─────────────────────────────────────┐
│ Response HTML                       │
│ • Send to browser                   │
│ • Browser renders UI                │
└─────────────────────────────────────┘
```

### Data Model Relationships

```
┌──────────────┐         ┌────────────────┐
│    User      │         │   Category     │
├──────────────┤         ├────────────────┤
│ id (PK)      │         │ id (PK)        │
│ name         │         │ name (Unique)  │
│ email        │         │ description    │
│ password     │◄───┐    │ timestamps     │
│ role (enum)  │    │    └────────┬───────┘
│ phone        │    │             │
│ address      │    │             │ 1:M
│ timestamps   │    │             │
└──────┬───────┘    │             ↓
       │            │    ┌────────────────┐
       │ 1:M        │    │     Book       │
       │            │    ├────────────────┤
       │            │    │ id (PK)        │
       ↓            │    │ title          │
┌──────────────┐    │    │ author         │
│ Borrowing    │    │    │ isbn (Unique)  │
├──────────────┤    │    │ category_id    │
│ id (PK)      │    │    │ publisher      │
│ user_id (FK)├────┴──→ │ year_published │
│ book_id (FK)├────┐    │ stock          │
│ borrow_date │    │    │ description    │
│ due_date    │    │    │ timestamps     │
│ return_date │    │    └────────────────┘
│ status      │    │
│ fine_amount │    │
│ notes       │    │
│ timestamps  │    │
└─────────────┘    │
                   │ M:1
                   │
            (Foreign Keys)
```

---

## 📋 Coding Standards

### 1. Naming Conventions

#### Controllers
```php
// ✅ Correct
class BooksController extends Controller { }
class BorrowingsController extends Controller { }

// ❌ Wrong
class BookController extends Controller { }
class BorrowingController extends Controller { }
```

#### Models
```php
// ✅ Correct (singular, PascalCase)
class Book extends Model { }
class Borrowing extends Model { }

// ❌ Wrong (plural)
class Books extends Model { }
```

#### Methods
```php
// ✅ Correct (camelCase for methods)
public function getUserBooks() { }
private function calculateFine() { }

// ❌ Wrong (PascalCase)
public function GetUserBooks() { }
```

#### Variables
```php
// ✅ Correct (camelCase)
$totalBooks = 10;
$borrowingStatus = 'borrowed';

// ❌ Wrong (snake_case for variables)
$total_books = 10;
```

#### Database Tables
```php
// ✅ Correct (plural, snake_case lowercase)
users, categories, books, borrowings

// ❌ Wrong
user, category, Book, Borrowing
```

#### Database Columns
```php
// ✅ Correct (snake_case)
id, user_id, book_id, created_at, updated_at

// ❌ Wrong
userId, bookId, createdAt
```

### 2. Code Style

#### Laravel Controller Style
```php
<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class BooksController extends Controller
{
    // Method docstring
    public function index(): View
    {
        $books = Book::with('category')
            ->paginate(12);
            
        return view('books.index', [
            'books' => $books,
        ]);
    }
    
    public function store(BookRequest $request): RedirectResponse
    {
        $book = Book::create($request->validated());
        
        return redirect()
            ->route('books.show', $book)
            ->with('success', 'Buku berhasil ditambahkan');
    }
}
```

#### Laravel Model Style
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = ['name', 'description'];
    
    protected $casts = [
        'created_at' => 'datetime',
    ];
    
    public function books(): HasMany
    {
        return $this->hasMany(Book::class);
    }
}
```

### 3. Comments & Documentation

```php
<?php

namespace App\Http\Controllers;

/**
 * BooksController mengelola semua operasi CRUD buku
 * 
 * @package App\Http\Controllers
 */
class BooksController extends Controller
{
    /**
     * Menampilkan daftar semua buku dengan pagination
     * 
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        // Ambil buku dengan pagination
        $books = Book::with('category')->paginate(12);
        
        return view('books.index', compact('books'));
    }
    
    /**
     * Menghitung denda keterlambatan
     * 
     * Denda dihitung: Rp 1.000 per hari untuk setiap hari 
     * setelah tanggal jatuh tempo
     * 
     * @param Carbon $dueDate Tanggal jatuh tempo
     * @return int Jumlah denda dalam rupiah
     */
    private function calculateFine($dueDate): int
    {
        if (now() <= $dueDate) {
            return 0;
        }
        
        $daysOverdue = now()->diffInDays($dueDate);
        return $daysOverdue * 1000; // Rp 1.000 per hari
    }
}
```

### 4. Error Handling

```php
// ✅ Good error handling
try {
    $book = Book::findOrFail($id);
} catch (ModelNotFoundException $e) {
    return redirect()
        ->route('books.index')
        ->with('error', 'Buku tidak ditemukan');
}

// ✅ Validation
if ($request->validated()) {
    // Process data
}

// ✅ Authorization
$this->authorize('update', $book);
```

---

## 🔄 Development Workflow

### 1. Creating a New Feature

#### Step 1: Create Migration
```bash
php artisan make:migration create_feature_table
```

Edit `database/migrations/XXXX_create_feature_table.php`:
```php
public function up(): void
{
    Schema::create('features', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->timestamp('created_at')->useCurrent();
    });
}

public function down(): void
{
    Schema::dropIfExists('features');
}
```

#### Step 2: Create Model
```bash
php artisan make:model Feature
```

Edit `app/Models/Feature.php`:
```php
protected $fillable = ['name'];
```

#### Step 3: Create Controller
```bash
php artisan make:controller FeatureController --resource
```

Edit `app/Http/Controllers/FeatureController.php`:
```php
public function index()
{
    $features = Feature::all();
    return view('features.index', compact('features'));
}
```

#### Step 4: Add Routes
Edit `routes/web.php`:
```php
Route::resource('features', FeatureController::class);
```

#### Step 5: Create Views
```bash
mkdir -p resources/views/features
```

Create blade templates:
- `resources/views/features/index.blade.php`
- `resources/views/features/create.blade.php`
- `resources/views/features/edit.blade.php`
- `resources/views/features/show.blade.php`

#### Step 6: Run Migration
```bash
php artisan migrate
```

---

### 2. Adding a New Field to Existing Table

```bash
# Create migration
php artisan make:migration add_new_field_to_books_table

# Edit migration
# database/migrations/XXXX_add_new_field_to_books_table.php
public function up(): void
{
    Schema::table('books', function (Blueprint $table) {
        $table->string('new_field')->after('field_name');
    });
}

public function down(): void
{
    Schema::table('books', function (Blueprint $table) {
        $table->dropColumn('new_field');
    });
}

# Run migration
php artisan migrate
```

---

## 🗄️ Database Development

### Running Migrations

```bash
# Run all pending migrations
php artisan migrate

# Rollback last batch
php artisan migrate:rollback

# Rollback all
php artisan migrate:reset

# Fresh (drop all, then migrate)
php artisan migrate:fresh

# Fresh with seeding
php artisan migrate:fresh --seed

# Show migration status
php artisan migrate:status
```

### Database Seeding

#### Create Seeder
```bash
php artisan make:seeder FeatureSeeder
```

#### Edit Seeder
```php
<?php

namespace Database\Seeders;

use App\Models\Feature;
use Illuminate\Database\Seeder;

class FeatureSeeder extends Seeder
{
    public function run(): void
    {
        Feature::create([
            'name' => 'Feature 1',
        ]);
        
        Feature::create([
            'name' => 'Feature 2',
        ]);
    }
}
```

#### Register in DatabaseSeeder
```php
public function run(): void
{
    $this->call([
        UserSeeder::class,
        CategorySeeder::class,
        BookSeeder::class,
        BorrowingSeeder::class,
        FeatureSeeder::class, // Baru
    ]);
}
```

#### Run Seeder
```bash
# Run all seeders
php artisan db:seed

# Run specific seeder
php artisan db:seed --class=FeatureSeeder
```

### Database Queries

#### Using Eloquent ORM

```php
// Get all
$books = Book::all();

// With conditions
$available = Book::where('stock', '>', 0)->get();

// With relationships
$books = Book::with('category', 'borrowings')->get();

// Pagination
$books = Book::paginate(12);

// Create
$book = Book::create([
    'title' => 'New Book',
    'author' => 'Author Name',
]);

// Update
$book->update(['stock' => 5]);

// Delete
$book->delete();

// Count
$count = Book::count();

// Aggregate
$total = Book::sum('stock');
```

---

## ➕ Adding Features

### Example: Add Email Notification Feature

#### 1. Create Notification
```bash
php artisan make:notification BorrowingOverdueNotification
```

#### 2. Edit Notification
```php
// app/Notifications/BorrowingOverdueNotification.php

public function via($notifiable)
{
    return ['mail'];
}

public function toMail($notifiable)
{
    return (new MailMessage)
        ->subject('Peminjaman Buku Terlambat')
        ->line('Peminjaman Anda telah terlambat.');
}
```

#### 3. Send Notification
```php
// In Controller or Job
$user->notify(new BorrowingOverdueNotification());
```

---

## 🧪 Testing

### Running Tests

```bash
# Run all tests
php artisan test

# Run specific test file
php artisan test tests/Feature/BooksTest.php

# Run specific test method
php artisan test --filter=testCreateBook

# With verbose output
php artisan test --verbose
```

### Writing Tests

```php
<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Book;

class BooksTest extends TestCase
{
    public function test_can_view_books_list()
    {
        $response = $this->get('/books');
        
        $response->assertStatus(200);
        $response->assertViewIs('books.index');
    }
    
    public function test_can_create_book()
    {
        $book = Book::factory()->make();
        
        $response = $this->post('/books', $book->toArray());
        
        $this->assertDatabaseHas('books', [
            'title' => $book->title,
        ]);
    }
}
```

---

## 🐛 Debugging

### Laravel Debugbar

```bash
composer require barryvdh/laravel-debugbar --dev
```

Access at bottom of page during development.

### Logging

```php
use Illuminate\Support\Facades\Log;

// Log debug
Log::debug('User created', ['user_id' => $user->id]);

// Log error
Log::error('Book not found', ['id' => $id]);

// Check logs
storage/logs/laravel.log
```

### Artisan Tinker

```bash
php artisan tinker

# Inside tinker
>>> $books = Book::all();
>>> $user = User::find(1);
>>> $user->name
```

### Dump & Die

```php
dd($variable); // Dump and die - bagus untuk debugging
dump($variable); // Dump only - continue execution
```

---

## 🔐 Security Best Practices

### 1. CSRF Protection
```blade
<form method="POST">
    @csrf
    <!-- form fields -->
</form>
```

### 2. Authentication
```php
// Check if authenticated
if (auth()->check()) { }

// Get current user
$user = auth()->user();

// Require login
Route::middleware('auth')->group(function () {
    // Protected routes
});
```

### 3. Authorization
```php
// Check policy
$this->authorize('update', $book);

// In Blade
@can('update', $book)
    [Edit]
@endcan
```

### 4. Input Validation
```php
// Always validate!
$validated = $request->validated();

// Use FormRequest
public function store(BookRequest $request) { }
```

### 5. SQL Injection Prevention
```php
// ✅ Safe (using ORM)
Book::where('title', $search)->get();

// ❌ Unsafe (never do this!)
Book::whereRaw("title = '$search'")->get();
```

---

## 📚 Useful Laravel Commands

| Command | Purpose |
|---------|---------|
| `php artisan serve` | Start development server |
| `php artisan migrate` | Run pending migrations |
| `php artisan make:model Model` | Create model |
| `php artisan make:controller ModelController --resource` | Create resource controller |
| `php artisan make:migration create_table` | Create migration |
| `php artisan make:seeder SeederName` | Create seeder |
| `php artisan db:seed` | Run seeders |
| `php artisan test` | Run tests |
| `php artisan tinker` | Interactive shell |
| `php artisan optimize` | Optimize app |
| `php artisan cache:clear` | Clear cache |
| `php artisan config:cache` | Cache configuration |

---

## 📖 Resources

- **Laravel Documentation:** https://laravel.com/docs
- **Eloquent ORM:** https://laravel.com/docs/eloquent
- **Blade Templates:** https://laravel.com/docs/blade
- **Database:** https://laravel.com/docs/database
- **Testing:** https://laravel.com/docs/testing

---

**Last Updated:** 16 Maret 2026  
**Next Update:** 30 April 2026
