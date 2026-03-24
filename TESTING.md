# 🧪 TESTING.md - Metode & Strategi Pengujian

> Dokumentasi lengkap tentang testing strategy, automation, dan manual testing

**Versi:** 1.0.0  
**Last Updated:** 16 Maret 2026

---

## 📖 Daftar Isi

1. [Testing Strategy](#testing-strategy)
2. [Unit Testing](#unit-testing)
3. [Feature Testing](#feature-testing)
4. [Manual Testing](#manual-testing)
5. [Test Data Setup](#test-data-setup)
6. [Performance Testing](#performance-testing)
7. [Best Practices](#best-practices)

---

## 🎯 Testing Strategy

### Testing Pyramid

```
         ╱╲
        ╱  ╲          E2E/UI Tests (5-10%)
       ╱────╲         Manual testing
      ╱      ╲
     ╱────────╲       Integration Tests (20-30%)
    ╱  Feature  ╲     Feature & Workflow tests
   ╱────────────╲
  ╱──────────────╲    Unit Tests (60-70%)
 ╱   Unit Tests   ╲   Models, Services, Helpers
╱──────────────────╲
```

### Test Coverage Targets

| Layer | Target | Current |
|-------|--------|---------|
| **Unit Tests** | 80%+ | 70% |
| **Feature Tests** | 60%+ | 50% |
| **Integration** | 40%+ | 30% |
| **Overall** | 70%+ | 55% |

### Testing Tools

```
Testing Framework:   PHPUnit 10.x
Mocking:             Mockery
Factories:           Laravel Factories
Seeders:             Database Seeders
Browser Testing:     Manual (Blade rendering)
Performance:         Built-in timers
```

---

## 🧬 Unit Testing

Unit tests verify individual components in isolation.

### Test Structure

```
tests/
├── Unit/
│   ├── Models/
│   │   ├── UserTest.php
│   │   ├── BookTest.php
│   │   ├── BorrowingTest.php
│   │   └── CategoryTest.php
│   ├── Services/
│   │   └── BorrowingServiceTest.php
│   └── Helpers/
│       └── CalculatorTest.php
└── Feature/
    ├── AuthTest.php
    ├── BooksTest.php
    ├── BorrowingsTest.php
    └── DashboardTest.php
```

### Example: User Model Tests

**File:** `tests/Unit/Models/UserTest.php`

```php
<?php

namespace Tests\Unit\Models;

use App\Models\User;
use App\Models\Borrowing;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * Test: User can be created
     */
    public function test_user_can_be_created()
    {
        $user = User::factory()->create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'role' => 'member',
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'john@example.com',
            'role' => 'member',
        ]);
    }

    /**
     * Test: User can be admin
     */
    public function test_user_is_admin()
    {
        $user = User::factory()->create(['role' => 'admin']);

        $this->assertTrue($user->isAdmin());
        $this->assertFalse($user->isMember());
    }

    /**
     * Test: User can have borrowings
     */
    public function test_user_can_have_borrowings()
    {
        $user = User::factory()->create();
        $borrowings = Borrowing::factory()
            ->count(3)
            ->create(['user_id' => $user->id]);

        $this->assertCount(3, $user->borrowings);
    }

    /**
     * Test: Admin cannot be deleted if has borrowings
     */
    public function test_admin_with_borrowings_cascade_delete()
    {
        $user = User::factory()->create(['role' => 'admin']);
        Borrowing::factory()->create(['user_id' => $user->id]);

        $user->delete();

        $this->assertDatabaseMissing('borrowings', [
            'user_id' => $user->id,
        ]);
    }
}
```

### Example: Book Model Tests

**File:** `tests/Unit/Models/BookTest.php`

```php
<?php

namespace Tests\Unit\Models;

use App\Models\Book;
use App\Models\Category;
use Tests\TestCase;

class BookTest extends TestCase
{
    /**
     * Test: Book belongs to category
     */
    public function test_book_belongs_to_category()
    {
        $category = Category::factory()->create();
        $book = Book::factory()->create(['category_id' => $category->id]);

        $this->assertInstanceOf(Category::class, $book->category);
        $this->assertEquals($category->id, $book->category->id);
    }

    /**
     * Test: Book availability based on stock
     */
    public function test_book_is_available_when_stock_gt_zero()
    {
        $book = Book::factory()->create(['stock' => 5]);

        $this->assertTrue($book->is_available);
    }

    /**
     * Test: Book not available when stock is zero
     */
    public function test_book_is_not_available_when_stock_zero()
    {
        $book = Book::factory()->create(['stock' => 0]);

        $this->assertFalse($book->is_available);
    }

    /**
     * Test: ISBN must be unique
     */
    public function test_book_isbn_must_be_unique()
    {
        $isbn = '978-602-7310-XX-X';
        Book::factory()->create(['isbn' => $isbn]);

        // This should fail
        $this->expectException(\Illuminate\Database\QueryException::class);
        Book::factory()->create(['isbn' => $isbn]);
    }
}
```

### Running Unit Tests

```bash
# Run all unit tests
php artisan test --testsuite=Unit

# Run specific test file
php artisan test tests/Unit/Models/BookTest.php

# Run specific test method
php artisan test tests/Unit/Models/BookTest.php --filter=test_book_is_available_when_stock_gt_zero

# Verbose output
php artisan test --verbose
```

---

## 🔌 Feature Testing

Feature tests verify application workflows (Controller → Model → Database).

### Example: Authentication Tests

**File:** `tests/Feature/AuthTest.php`

```php
<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class AuthTest extends TestCase
{
    /**
     * Test: User can view login page
     */
    public function test_user_can_view_login_page()
    {
        $response = $this->get('/login');

        $response->assertStatus(200)
                 ->assertViewIs('auth.login');
    }

    /**
     * Test: User can login with valid credentials
     */
    public function test_user_can_login()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('Password123'),
        ]);

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'Password123',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($user);
    }

    /**
     * Test: User cannot login with invalid password
     */
    public function test_user_cannot_login_with_invalid_password()
    {
        User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('Password123'),
        ]);

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'WrongPassword',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    /**
     * Test: User can register
     */
    public function test_user_can_register()
    {
        $response = $this->post('/register', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '081234567890',
            'address' => 'Jalan ABC No. 1',
            'password' => 'Password123',
            'password_confirmation' => 'Password123',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertDatabaseHas('users', [
            'email' => 'john@example.com',
            'role' => 'member',
        ]);
    }

    /**
     * Test: User can logout
     */
    public function test_user_can_logout()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
                        ->post('/logout');

        $response->assertRedirect('/');
        $this->assertGuest();
    }
}
```

### Example: Books Feature Tests

**File:** `tests/Feature/BooksTest.php`

```php
<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\User;
use Tests\TestCase;

class BooksTest extends TestCase
{
    /**
     * Test: Anyone can view books list
     */
    public function test_anyone_can_view_books()
    {
        Book::factory()->count(5)->create();

        $response = $this->get('/books');

        $response->assertStatus(200)
                 ->assertViewIs('books.index')
                 ->assertViewHas('books');
    }

    /**
     * Test: Admin can create book
     */
    public function test_admin_can_create_book()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)
                        ->post('/books', [
                            'title' => 'New Book',
                            'author' => 'Author Name',
                            'isbn' => '978-602-XXXX-XX-1',
                            'category_id' => 1,
                            'publisher' => 'Publisher',
                            'year_published' => 2026,
                            'stock' => 5,
                        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('books', [
            'title' => 'New Book',
        ]);
    }

    /**
     * Test: Member cannot create book
     */
    public function test_member_cannot_create_book()
    {
        $member = User::factory()->create(['role' => 'member']);

        $response = $this->actingAs($member)
                        ->post('/books', [
                            'title' => 'New Book',
                        ]);

        $response->assertStatus(403); // Forbidden
    }

    /**
     * Test: Admin cannot delete book with active borrowings
     */
    public function test_admin_cannot_delete_book_with_active_borrowings()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $book = Book::factory()->create();
        $user = User::factory()->create(['role' => 'member']);
        
        // Create active borrowing
        Borrowing::factory()->create([
            'book_id' => $book->id,
            'user_id' => $user->id,
            'status' => 'borrowed',
        ]);

        $response = $this->actingAs($admin)
                        ->delete("/books/{$book->id}");

        $response->assertSessionHasErrors();
        $this->assertModelExists($book);
    }
}
```

### Running Feature Tests

```bash
# Run all feature tests
php artisan test --testsuite=Feature

# Run specific feature test
php artisan test tests/Feature/BooksTest.php

# Run specific test method
php artisan test --filter=test_admin_can_create_book
```

---

## 📋 Manual Testing

Manual testing covers user workflows and UI/UX verification.

### Test Checklist

See: [MANUAL_TEST_CHECKLIST.md](MANUAL_TEST_CHECKLIST.md)

Contains 45 comprehensive test cases covering:
- Authentication (5 tests)
- Books Listing (8 tests)
- Book Details (4 tests)
- Books CRUD (9 tests)
- Borrowings (6+ tests)
- Admin & Member Dashboards
- Authorization & Security
- Responsive Design
- UI/UX Validation
- Data Integrity

### Running Manual Tests

#### 1. Start Server
```bash
php artisan serve
```

#### 2. Access Application
```
http://localhost:8000
```

#### 3. Login & Test
```
Admin: admin@library.com / Admin123!
Member: budi@example.com / Password123
```

#### 4. Follow Checklist
- Execute each test step
- Verify expected result
- Document pass/fail
- Screenshot issues

---

## 🎲 Test Data Setup

### Using Factories

```php
// Create single record
$user = User::factory()->create();

// Create multiple
$books = Book::factory()->count(10)->create();

// Create with specific attributes
$admin = User::factory()->create([
    'role' => 'admin',
    'email' => 'admin@example.com',
]);

// Create with relationships
$borrowing = Borrowing::factory()
    ->for(User::factory())
    ->for(Book::factory())
    ->create();
```

### Using Seeders

```bash
# Seed production data
php artisan db:seed

# Seed specific seeder
php artisan db:seed --class=UserSeeder

# Fresh database with seed
php artisan migrate:fresh --seed
```

### Test Database Isolation

```php
// Each test runs in isolation:
// 1. Begin transaction
// 2. Run test
// 3. Rollback changes
// 4. Clean database

public function test_something()
{
    // Database is fresh for each test
    $this->assertCount(0, User::all());
    
    User::factory()->create();
    
    $this->assertCount(1, User::all());
    
    // After test, all changes are rolled back
}
```

---

## ⚡ Performance Testing

### Query Performance

```php
// Detect N+1 queries
$this->expectNotToPerformQueries();

$books = Book::all();
foreach ($books as $book) {
    echo $book->category->name; // Extra query!
}
```

### Load Testing

```bash
# Apache Bench
ab -n 100 -c 10 http://localhost:8000/books

# Siege
siege -c 10 -r 10 -f urls.txt
```

### Metrics to Track

```php
// Response time
$start = microtime(true);
$response = $this->get('/books');
$time = microtime(true) - $start;
$this->assertLessThan(0.5, $time); // < 500ms

// Database queries
$this->assertQueryCount(3); // Expect 3 queries

// Memory usage
$memory = memory_get_peak_usage();
$this->assertLessThan(10 * 1024 * 1024, $memory); // < 10MB
```

---

## ✅ Best Practices

### 1. Naming Conventions

```php
// ✅ Good test names
public function test_admin_can_delete_book()
public function test_member_cannot_access_admin_panel()
public function test_book_cannot_be_deleted_if_borrowed()

// ❌ Poor test names
public function test1()
public function test_delete()
public function testBook()
```

### 2. Arrange-Act-Assert Pattern

```php
public function test_user_can_borrow_book()
{
    // ARRANGE: Set up test data
    $user = User::factory()->create(['role' => 'member']);
    $book = Book::factory()->create(['stock' => 5]);

    // ACT: Perform action
    $response = $this->actingAs($user)
                    ->post('/borrowings', ['book_id' => $book->id]);

    // ASSERT: Verify results
    $response->assertRedirect();
    $this->assertDatabaseHas('borrowings', [
        'user_id' => $user->id,
        'book_id' => $book->id,
    ]);
    $this->assertEquals(4, $book->fresh()->stock);
}
```

### 3. Test One Thing Per Test

```php
// ❌ Testing multiple things
public function test_borrowing()
{
    $user = User::factory()->create();
    $book = Book::factory()->create();
    $this->post('/borrowings', ['book_id' => $book->id]);
    $this->assertEquals(1, Borrowing::count());
    $this->post('/borrowings/1/return', []);
    $this->assertEquals(0, $user->fine_amount);
}

// ✅ Test one thing
public function test_user_can_borrow_book()
{
    // Just test borrowing
}

public function test_user_can_return_book()
{
    // Just test returning
}

public function test_fine_calculated_when_overdue()
{
    // Just test fine calculation
}
```

### 4. Use Descriptive Assertions

```php
// ✅ Clear assertions
$this->assertAuthenticated();
$this->assertGuest();
$this->assertViewIs('books.index');
$this->assertViewHas('books');
$this->assertDatabaseHas('books', ['title' => 'Test']);
$this->assertDatabaseMissing('users', ['email' => 'test@example.com']);

// ❌ Vague assertions
$this->assertTrue($response->ok());
$this->assertNotNull($data);
```

### 5. Test Edge Cases

```php
public function test_book_creation()
{
    // Valid case
    $this->assertValid(['title' => 'Book', 'stock' => 5]);
    
    // Edge cases
    $this->assertValid(['stock' => 0]);  // Zero stock
    $this->assertValid(['stock' => 999]); // High stock
    $this->assertInvalid(['stock' => -1]); // Negative
    $this->assertInvalid(['stock' => 'abc']); // Not integer
}
```

---

## 📊 Test Coverage Report

```bash
# Generate coverage report
php artisan test --coverage

# With detailed output
php artisan test --coverage --coverage-html=coverage

# View report
open coverage/index.html
```

### Coverage Targets

```
App\Models\User ........................... 95% (19/20)
App\Models\Book ........................... 92% (23/25)
App\Models\Borrowing ...................... 88% (22/25)
App\Http\Controllers\BooksController ...... 90% (18/20)
App\Http\Requests\BookRequest ............. 100% (12/12)

Overall Coverage: 92.3%
```

---

## 🚀 CI/CD Integration

### GitHub Actions Example

```yaml
name: Tests

on: [push, pull_request]

jobs:
  test:
    runs-on: ubuntu-latest
    
    steps:
      - uses: actions/checkout@v2
      
      - name: Setup PHP
        uses: shivammathur/setup-php@v2
        with:
          php-version: '8.2'
      
      - name: Install dependencies
        run: composer install
      
      - name: Run tests
        run: php artisan test
      
      - name: Generate coverage
        run: php artisan test --coverage
```

---

## 🔄 Test Development Workflow

```
1. Write test (RED)
   └─ Test fails because feature not implemented

2. Write minimal code (GREEN)
   └─ Test passes

3. Refactor code (REFACTOR)
   └─ Improve code while keeping tests passing

Repeat for each feature...
```

---

**Last Updated:** 16 Maret 2026  
**Next Update:** 30 April 2026
