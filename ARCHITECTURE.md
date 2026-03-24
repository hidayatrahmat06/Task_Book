# 🏗️ ARCHITECTURE.md - Arsitektur Sistem

> Dokumentasi lengkap arsitektur sistem, design patterns, dan alur data

**Versi:** 1.0.0  
**Last Updated:** 16 Maret 2026

---

## 📖 Daftar Isi

1. [System Overview](#system-overview)
2. [Architecture Layers](#architecture-layers)
3. [Request Flow](#request-flow)
4. [Data Flow](#data-flow)
5. [Component Interaction](#component-interaction)
6. [Design Patterns](#design-patterns)
7. [Scalability](#scalability)

---

## 🎯 System Overview

### Technology Stack

```
┌─────────────────────────────────────────────────────┐
│                    User Layer                       │
│          (Browser, Client-side)                     │
├─────────────────────────────────────────────────────┤
│                                                     │
│  Frontend:                                          │
│  • HTML Templates (Blade)                          │
│  • TailwindCSS Styling                             │
│  • Font Awesome Icons                              │
│  • Form Submissions                                │
│                                                     │
├─────────────────────────────────────────────────────┤
│            Application Layer (Laravel)              │
├─────────────────────────────────────────────────────┤
│                                                     │
│  API/Routing:                                       │
│  • Route Dispatcher                                │
│  • Middleware Pipeline                             │
│  • Request/Response Handler                        │
│                                                     │
│  Controllers:                                       │
│  • DashboardController                             │
│  • BooksController                                 │
│  • BorrowingsController                            │
│  • Auth Controllers                                │
│                                                     │
│  Business Logic:                                    │
│  • Authentication                                  │
│  • Authorization (Policies)                        │
│  • Form Validation                                 │
│  • Fine Calculation                                │
│                                                     │
├─────────────────────────────────────────────────────┤
│             Data Access Layer (Eloquent)            │
├─────────────────────────────────────────────────────┤
│                                                     │
│  Models:                                            │
│  • User Model                                      │
│  • Book Model                                      │
│  • Category Model                                  │
│  • Borrowing Model                                 │
│                                                     │
│  Query Builder:                                     │
│  • ORM (Object-Relational Mapping)                │
│  • Relationships                                   │
│  • Eager Loading                                   │
│                                                     │
├─────────────────────────────────────────────────────┤
│              Database Layer (MySQL)                 │
├─────────────────────────────────────────────────────┤
│                                                     │
│  Tables:                                            │
│  • users, categories, books, borrowings            │
│  • Indexes, Foreign Keys, Constraints              │
│                                                     │
└─────────────────────────────────────────────────────┘
```

---

## 📊 Architecture Layers

### 1. Presentation Layer (UI/Frontend)

**Responsibility:** Display data & capture user input

**Components:**
- Blade Templates
- HTML Forms
- TailwindCSS Styling
- JavaScript (minimal)

**Example Flow:**

```blade
<!-- resources/views/books/index.blade.php -->
<div class="grid grid-cols-4 gap-4">
    @forelse($books as $book)
        <div class="book-card">
            <h3>{{ $book->title }}</h3>
            <p>{{ $book->author }}</p>
            <a href="{{ route('books.show', $book) }}">Detail</a>
        </div>
    @empty
        <p>Tidak ada buku</p>
    @endforelse
</div>
```

---

### 2. Application Layer (Business Logic)

**Responsibility:** Process requests & implement business rules

**Components:**

#### A. Routing (`routes/web.php`)
```php
// Guest routes (no auth required)
Route::middleware('guest')->group(function () {
    Route::get('/', [WelcomeController::class, 'index'])->name('welcome');
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');
});

// Authenticated routes (requires login)
Route::middleware('auth')->group(function () {
    Route::resource('books', BooksController::class)->except('destroy');
});

// Admin only routes
Route::middleware(['auth', 'admin'])->group(function () {
    Route::delete('books/{book}', [BooksController::class, 'destroy']);
});
```

#### B. Controllers
```php
// Example: BooksController
class BooksController extends Controller
{
    public function index(): View
    {
        // 1. Get request data
        $search = request('search');
        $category = request('category');
        
        // 2. Query database via Model
        $books = Book::with('category')
            ->when($search, fn($q) => $q->where('title', 'like', "%$search%"))
            ->when($category, fn($q) => $q->where('category_id', $category))
            ->paginate(12);
        
        // 3. Return view with data
        return view('books.index', compact('books'));
    }
    
    public function store(BookRequest $request): RedirectResponse
    {
        // 1. Validate input (using BookRequest)
        // 2. Create record in database
        $book = Book::create($request->validated());
        
        // 3. Redirect with success message
        return redirect()->route('books.show', $book)
            ->with('success', 'Buku berhasil ditambahkan');
    }
}
```

#### C. Middleware
```php
// AdminMiddleware: Check user is admin
class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->isAdmin()) {
            return $next($request);
        }
        
        return redirect()->route('login');
    }
}
```

#### D. Authorization Policies
```php
// BorrowingPolicy: Row-level authorization
class BorrowingPolicy
{
    public function view(User $user, Borrowing $borrowing): bool
    {
        // Member dapat melihat pinjaman mereka sendiri
        // Admin dapat melihat semua
        return $user->isAdmin() || $user->id === $borrowing->user_id;
    }
    
    public function update(User $user, Borrowing $borrowing): bool
    {
        return $user->isAdmin();
    }
}
```

---

### 3. Data Access Layer (ORM)

**Responsibility:** Interact with database

**Components:**

#### A. Models with Relationships
```php
// Book Model with relationships
class Book extends Model
{
    protected $fillable = ['title', 'author', 'isbn', ...];
    
    // Relationship: Book belongs to Category (1:M)
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
    
    // Relationship: Book can have many Borrowing records
    public function borrowings(): HasMany
    {
        return $this->hasMany(Borrowing::class);
    }
    
    // Accessor: Check availability
    public function getIsAvailableAttribute(): bool
    {
        return $this->stock > 0 && !$this->borrowings()
            ->where('status', '!=', 'returned')
            ->exists();
    }
}
```

#### B. Query Building
```php
// Complex query example
$borrowings = Borrowing::with('user', 'book')     // Eager load relationships
    ->whereIn('status', ['borrowed', 'overdue'])  // Filter
    ->orderBy('due_date', 'asc')                  // Sort
    ->paginate(15);                               // Paginate
```

---

### 4. Database Layer

**Responsibility:** Persistent data storage

**Components:**
- MySQL Tables
- Relationships (Foreign Keys)
- Indexes
- Constraints

```sql
-- Example: Query directly (rarely needed)
SELECT b.*, c.name as category_name
FROM books b
JOIN categories c ON b.category_id = c.id
WHERE b.stock > 0
LIMIT 10;
```

---

## 🔄 Request Flow

### Complete Request Lifecycle

#### Scenario: Member Meminjam Buku

```
1. USER INTERACTION
   └─ Member click "Pinjam Buku" button

2. HTTP REQUEST SENT
   └─ POST http://localhost:8000/borrowings
      Headers: CSRF Token, Session ID
      Body: book_id=1

3. LARAVEL ROUTING
   └─ routes/web.php matches POST /borrowings
      └─ Mapped to: BorrowingsController@store

4. MIDDLEWARE PIPELINE
   ├─ 'auth' middleware: Check user logged in ✓
   ├─ 'verified' middleware: Check email verified ✓
   └─ Continue to controller

5. CONTROLLER (BorrowingsController@store)
   ├─ Validate input using BorrowingRequest
   │  └─ Check: book_id is valid, exists, in stock
   ├─ Get Book model: $book = Book::find($request->book_id)
   ├─ Check stock: if ($book->stock <= 0) throw error
   ├─ Create Borrowing record:
   │  Borrowing::create([
   │      'user_id' => auth()->id(),
   │      'book_id' => $book->id,
   │      'borrow_date' => now(),
   │      'due_date' => now()->addDays(7),
   │      'status' => 'borrowed'
   │  ])
   ├─ Decrement stock: $book->decrement('stock')
   └─ Return redirect + success message

6. DATABASE CHANGES
   ├─ INSERT INTO borrowings (...)
   └─ UPDATE books SET stock = stock - 1 WHERE id = 1

7. RESPONSE TO USER
   ├─ HTTP Status: 302 (redirect)
   ├─ Location: /borrowings/1
   ├─ Session Flash: success message
   └─ Browser redirects to show page

8. SHOW PAGE REQUEST
   ├─ GET http://localhost:8000/borrowings/1
   ├─ BorrowingsController@show returns view
   ├─ View displays borrowing details
   └─ User sees confirmation

9. UI UPDATE
   ├─ Browser renders HTML
   ├─ TailwindCSS applies styling
   ├─ Success message displayed
   └─ User sees "Peminjaman berhasil!"
```

---

## 📊 Data Flow

### Create Book Flow

```
User Input Form
↓
POST /books (BooksController@store)
↓
BookRequest Validation
├─ Check title required
├─ Check ISBN unique
├─ Check category exists
└─ Validate all fields
↓
Create Book Record
├─ $book = Book::create($validated)
├─ Save to database
└─ Get book id
↓
Store Book Image (optional)
├─ Upload file
├─ Store path
└─ Update book record
↓
Success Response
├─ Redirect to books.show
├─ Flash: "Buku berhasil ditambahkan"
└─ Display book details
```

### Return Book & Calculate Fine Flow

```
User Click "Return Book"
↓
POST /borrowings/{id}/return
↓
BorrowingPolicy Authorization
└─ Check user is admin or owner
↓
Check Return Date
├─ If due_date < today → overdue
└─ Calculate days late
↓
Calculate Fine
├─ If overdue: days_late × 1000
└─ Store in fine_amount
↓
Update Borrowing Status
├─ Set return_date = today
├─ Set status = "returned" or "overdue"
├─ Set fine_amount
└─ Save changes
↓
Update Book Stock
├─ Increment stock (+1)
└─ Update last_borrowed
↓
Success Response
├─ Redirect to borrowings.show
├─ Display return details
└─ Show fine if any
```

---

## 🔄 Component Interaction

### DashboardController Interaction

```
DashboardController
   │
   ├─ AdminDashboard Access
   │  ├─ Requires: admin role
   │  ├─ Queries:
   │  │  ├─ Book::count()
   │  │  ├─ User::where('role', 'member')->count()
   │  │  ├─ Borrowing::count()
   │  │  ├─ Borrowing::where('status', 'overdue')->get()
   │  │  └─ Borrowing::sum('fine_amount')
   │  └─ Returns: admin dashboard view
   │
   ├─ MemberDashboard Access
   │  ├─ Requires: auth user
   │  ├─ Queries:
   │  │  ├─ auth()->user()
   │  │  ├─ auth()->user()->borrowings()->where('status', 'borrowed')
   │  │  ├─ auth()->user()->borrowings()->where('status', 'returned')
   │  │  └─ Borrowing::where('user_id', auth()->id())->sum('fine_amount')
   │  └─ Returns: member dashboard view
   │
   └─ Access Control (Middleware)
      ├─ 'auth': User must be logged in
      └─ 'verified': Email must be verified
```

### BooksController Interaction

```
BooksController
   │
   ├─ index() → List Books
   │  ├─ Query: Book::with('category')->paginate(12)
   │  ├─ Search: $search can filter by title/author
   │  ├─ Filter: by category
   │  └─ Return: books/index view
   │
   ├─ create() → Form to Add
   │  ├─ Query: Category::all()
   │  └─ Return: books/create view
   │
   ├─ store() → Save New Book
   │  ├─ Validation: BookRequest
   │  ├─ Create: Book::create()
   │  ├─ Upload: Store cover image
   │  └─ Redirect: to books.show
   │
   ├─ show() → Book Details
   │  ├─ Query: Book::findOrFail($id)
   │  ├─ Load: with('category', 'borrowings')
   │  ├─ Calculate: availability, borrowing count
   │  └─ Return: books/show view
   │
   ├─ edit() → Edit Form
   │  ├─ Check: Authorize(admin)
   │  ├─ Query: Book::findOrFail($id)
   │  └─ Return: books/edit view
   │
   ├─ update() → Save Changes
   │  ├─ Validation: BookRequest
   │  ├─ Update: $book->update()
   │  └─ Redirect: to books.show
   │
   └─ destroy() → Delete Book
      ├─ Check: Authorize(admin)
      ├─ Check: No active borrowings
      ├─ Delete: $book->delete()
      └─ Redirect: to books.index
```

---

## 🎨 Design Patterns

### 1. MVC Pattern

```
Model (Data)
  ├─ Book, User, Category, Borrowing
  ├─ Database interaction
  └─ Business logic

View (Presentation)
  ├─ Blade templates
  ├─ User interface
  └─ Display data

Controller (Logic)
  ├─ BooksController, BorrowingsController
  ├─ Route requests
  └─ Coordinate Model & View
```

### 2. Repository Pattern (Implicit)

Models act as repositories:

```php
// Instead of raw SQL:
// DB::select("SELECT * FROM books WHERE category_id = ?");

// Use Model (repository):
$books = Book::where('category_id', $categoryId)->get();
```

### 3. Policy Pattern (Authorization)

```php
// Policy checks row-level permissions
$this->authorize('update', $borrowing);

// Instead of:
if ($user->id !== $borrowing->user_id && !$user->isAdmin()) {
    abort(403);
}
```

### 4. Factory Pattern (Testing)

```php
// Create test data efficiently
$book = Book::factory()->create();
$user = User::factory()->create(['role' => 'member']);
```

### 5. Service Pattern (Optional)

Could be implemented for complex logic:

```php
// Could create: app/Services/BorrowingService.php
class BorrowingService
{
    public function createBorrowing($book, $user)
    {
        // Complex borrowing logic
    }
    
    public function calculateFine($borrowing)
    {
        // Fine calculation logic
    }
}
```

---

## 🚀 Scalability

### Current State

```
Tier 1: Single Server (Development)
├─ Laravel App: 1 instance
├─ MySQL: 1 instance
└─ File Storage: Local filesystem
```

### Recommended Scaling (Future)

```
Tier 2: Multiple Servers (Growth Phase)
├─ Load Balancer
├─ Application Servers: 2-3 instances
├─ MySQL Master-Slave Replication
├─ Redis Cache Server
└─ Dedicated File Storage (S3, etc)

Tier 3: Enterprise Scale
├─ Kubernetes Orchestration
├─ Database Sharding
├─ CDN for static assets
├─ Message Queue (for async tasks)
└─ Microservices Architecture
```

### Optimization Strategies

#### 1. Caching
```php
// Cache frequently accessed data
$categories = cache()->remember('categories', 3600, function () {
    return Category::with('books')->get();
});
```

#### 2. Queue Jobs
```php
// Async processing
SendBorrowingNotification::dispatch($borrowing)
    ->delay(now()->addMinutes(5));
```

#### 3. Database Optimization
```php
// Eager loading prevents N+1 queries
$borrowings = Borrowing::with('user', 'book')->get();

// vs
$borrowings = Borrowing::all(); // 1 query
// then in loop: $borrowing->user->name // N more queries
```

#### 4. Static Asset Optimization
- Minify CSS/JS
- Use CDN for images
- Lazy loading
- Compression

---

## 🔐 Security Architecture

### Authentication Flow

```
User enters email/password
    ↓
LoginController validates
    ↓
Check against password hash
    ↓
Create session/token
    ↓
Set auth cookie
    ↓
Redirect to dashboard
    ↓
Middleware 'auth' checks session
    ↓
Grant access to protected routes
```

### Authorization Flow

```
User requests action (e.g., delete book)
    ↓
Controller: $this->authorize('delete', $book)
    ↓
Check BorrowingPolicy
    ↓
Policy checks user role/conditions
    ↓
If allowed → Continue
If denied → 403 Forbidden
```

### CSRF Protection

```
Form includes @csrf token
    ↓
Laravel middleware verifies token
    ↓
If valid → Process request
If invalid → Reject request
```

---

## 📈 Monitoring & Metrics

### Key Metrics to Track

```
Performance:
├─ Average response time
├─ Page load time
├─ Database query time
└─ Error rate

Business:
├─ Total books borrowed per day
├─ Member activity
├─ Fine collected
└─ Book popularity

System:
├─ Server CPU usage
├─ Memory consumption
├─ Database size
└─ File storage usage
```

### Logging Strategy

```
Laravel logs all activity:
├─ Requests (input/output)
├─ Errors and exceptions
├─ Database queries (debug mode)
└─ User actions (via middleware)

Location: storage/logs/laravel.log
```

---

**Last Updated:** 16 Maret 2026  
**Next Review:** 30 April 2026
