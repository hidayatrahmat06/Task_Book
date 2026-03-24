<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BooksController;
use App\Http\Controllers\BorrowingsController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

// Health checks for load balancer / uptime monitoring
Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
        'service' => 'task_book',
    ]);
});

Route::get('/ready', function () {
    try {
        DB::select('SELECT 1');

        return response()->json([
            'status' => 'ready',
            'database' => 'connected',
        ]);
    } catch (\Throwable $e) {
        return response()->json([
            'status' => 'not_ready',
            'database' => 'disconnected',
            'message' => $e->getMessage(),
        ], 503);
    }
});

// Landing page
Route::get('/', function () {
    return view('welcome');
});

// ============================================
// GUEST ROUTES (Login & Register)
// ============================================
Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'showLoginForm'])
        ->name('login');
    Route::post('login', [LoginController::class, 'login']);

    Route::get('register', [RegisterController::class, 'showRegistrationForm'])
        ->name('register');
    Route::post('register', [RegisterController::class, 'register']);
});

// ============================================
// AUTHENTICATED ROUTES (All Users)
// ============================================
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Books (Public Read)
    Route::get('books', [BooksController::class, 'index'])
        ->name('books.index');
    Route::get('books/{book}', [BooksController::class, 'show'])
        ->name('books.show');

    // Borrowings (User specific)
    Route::get('borrowings', [BorrowingsController::class, 'index'])
        ->name('borrowings.index');
    Route::get('borrowings/create', [BorrowingsController::class, 'create'])
        ->name('borrowings.create');
    Route::post('borrowings', [BorrowingsController::class, 'store'])
        ->name('borrowings.store');
    Route::get('borrowings/{borrowing}', [BorrowingsController::class, 'show'])
        ->name('borrowings.show');
    Route::post('borrowings/{borrowing}/return', [BorrowingsController::class, 'return'])
        ->name('borrowings.return');

    // Logout
    Route::post('logout', [LoginController::class, 'logout'])
        ->name('logout');
});

// ============================================
// ADMIN ONLY ROUTES
// ============================================
Route::middleware(['auth', 'admin'])->group(function () {
    // Books Management (Create, Edit, Delete)
    Route::get('books/create', [BooksController::class, 'create'])
        ->name('books.create');
    Route::post('books', [BooksController::class, 'store'])
        ->name('books.store');
    Route::get('books/{book}/edit', [BooksController::class, 'edit'])
        ->name('books.edit');
    Route::put('books/{book}', [BooksController::class, 'update'])
        ->name('books.update');
    Route::delete('books/{book}', [BooksController::class, 'destroy'])
        ->name('books.destroy');

    // Borrowings Management (Admin can delete & manage)
    Route::delete('borrowings/{borrowing}', [BorrowingsController::class, 'destroy'])
        ->name('borrowings.destroy');
});
