# CONTOH KODE IMPLEMENTASI
## Sistem Manajemen Tugas - Task Management System

---

## 1. MIGRATION FILES

### Migration: Create Users Table

**File:** `database/migrations/2023_01_01_000000_create_users_table.php`

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
```

### Migration: Create Tasks Table

**File:** `database/migrations/2023_01_02_000000_create_tasks_table.php`

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('priority', ['low', 'medium', 'high'])->default('medium');
            $table->enum('status', ['todo', 'in_progress', 'completed'])->default('todo');
            $table->date('due_date')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
```

---

## 2. MODEL FILES

### Model: User

**File:** `app/Models/User.php`

```php
<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Relationships
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    // Helper Methods
    public function getTaskCount()
    {
        return $this->tasks()->count();
    }

    public function getCompletedTaskCount()
    {
        return $this->tasks()
            ->where('status', 'completed')
            ->count();
    }

    public function getPendingTaskCount()
    {
        return $this->tasks()
            ->where('status', '!=', 'completed')
            ->count();
    }

    public function getHighPriorityTaskCount()
    {
        return $this->tasks()
            ->where('priority', 'high')
            ->where('status', '!=', 'completed')
            ->count();
    }
};
```

### Model: Task

**File:** `app/Models/Task.php`

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'priority',
        'status',
        'due_date',
    ];

    protected $casts = [
        'due_date' => 'date',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Helper Methods
    public function isCompleted()
    {
        return $this->status === 'completed';
    }

    public function isPending()
    {
        return $this->status !== 'completed';
    }

    public function isOverdue()
    {
        return $this->due_date && $this->due_date < now()->toDateString() && !$this->isCompleted();
    }

    public function getPriorityBadgeClass()
    {
        return match($this->priority) {
            'high' => 'bg-red-100 text-red-800',
            'medium' => 'bg-yellow-100 text-yellow-800',
            'low' => 'bg-green-100 text-green-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    public function getStatusBadgeClass()
    {
        return match($this->status) {
            'completed' => 'bg-green-100 text-green-800',
            'in_progress' => 'bg-blue-100 text-blue-800',
            'todo' => 'bg-gray-100 text-gray-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }
};
```

---

## 3. CONTROLLER FILES

### Controller: AuthController

**File:** `app/Http/Controllers/AuthController.php`

```php
<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // Show register form
    public function showRegister()
    {
        return view('auth.register');
    }

    // Handle register
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'name.required' => 'Nama harus diisi',
            'email.required' => 'Email harus diisi',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password minimal 8 karakter',
            'password.confirmed' => 'Password tidak sesuai',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        return redirect('/dashboard')->with('success', 'Registrasi berhasil! Selamat datang ' . $user->name);
    }

    // Show login form
    public function showLogin()
    {
        return view('auth.login');
    }

    // Handle login
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ], [
            'email.required' => 'Email harus diisi',
            'password.required' => 'Password harus diisi',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        if (Auth::attempt([
            'email' => $request->email,
            'password' => $request->password,
        ], $request->remember)) {
            $request->session()->regenerate();
            return redirect('/dashboard')->with('success', 'Login berhasil!');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah',
        ])->withInput();
    }

    // Handle logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/').with('success', 'Logout berhasil!');
    }
}
```

### Controller: DashboardController

**File:** `app/Http/Controllers/DashboardController.php`

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = auth()->user();
        
        $stats = [
            'total_tasks' => $user->getTaskCount(),
            'completed_tasks' => $user->getCompletedTaskCount(),
            'pending_tasks' => $user->getPendingTaskCount(),
            'high_priority_tasks' => $user->getHighPriorityTaskCount(),
        ];

        $recentTasks = $user->tasks()
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard', compact('stats', 'recentTasks'));
    }
}
```

### Controller: TaskController

**File:** `app/Http/Controllers/TaskController.php`

```php
<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Display all tasks
    public function index(Request $request)
    {
        $query = Auth::user()->tasks();

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Filter by priority
        if ($request->has('priority') && $request->priority) {
            $query->where('priority', $request->priority);
        }

        // Search by title
        if ($request->has('search') && $request->search) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $tasks = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('tasks.index', compact('tasks'));
    }

    // Show create form
    public function create()
    {
        return view('tasks.create');
    }

    // Store new task
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:low,medium,high',
            'due_date' => 'nullable|date|after:today',
        ], [
            'title.required' => 'Judul tugas harus diisi',
            'priority.required' => 'Prioritas harus dipilih',
            'due_date.after' => 'Tanggal harus melebihi hari ini',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        Auth::user()->tasks()->create([
            'title' => $request->title,
            'description' => $request->description,
            'priority' => $request->priority,
            'due_date' => $request->due_date,
            'status' => 'todo',
        ]);

        return redirect('/tasks')->with('success', 'Tugas berhasil dibuat!');
    }

    // Show edit form
    public function edit(Task $task)
    {
        $this->authorize('update', $task);
        return view('tasks.edit', compact('task'));
    }

    // Update task
    public function update(Request $request, Task $task)
    {
        $this->authorize('update', $task);

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:todo,in_progress,completed',
            'due_date' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $task->update($request->all());

        return redirect('/tasks')->with('success', 'Tugas berhasil diperbarui!');
    }

    // Delete task
    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);
        $task->delete();
        return redirect('/tasks')->with('success', 'Tugas berhasil dihapus!');
    }

    // Update task status via AJAX
    public function updateStatus(Request $request, Task $task)
    {
        $this->authorize('update', $task);

        $validator = Validator::make($request->all(), [
            'status' => 'required|in:todo,in_progress,completed',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Status tidak valid'], 422);
        }

        $task->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'message' => 'Status tugas berhasil diperbarui',
        ]);
    }
}
```

---

## 4. ROUTING

### File: `routes/web.php`

```php
<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

// Guest routes
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
    
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
});

// Home page
Route::get('/', function () {
    return view('welcome');
});

// Auth routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Tasks CRUD
    Route::resource('tasks', TaskController::class);
    Route::post('/tasks/{task}/updateStatus', [TaskController::class, 'updateStatus'])->name('tasks.updateStatus');
});

Route::fallback(function () {
    return view('404');
});
```

---

## 5. BLADE TEMPLATES

### Template: Main Layout

**File:** `resources/views/layouts/app.blade.php`

```html
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Task Management System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <nav class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <a href="/" class="text-2xl font-bold text-blue-600">
                        📋 TaskMaster
                    </a>
                </div>
                
                @auth
                <div class="flex items-center space-x-4">
                    <a href="{{ route('dashboard') }}" 
                       class="text-gray-600 hover:text-gray-900 px-3 py-2 text-sm font-medium">
                        Dashboard
                    </a>
                    <a href="{{ route('tasks.index') }}" 
                       class="text-gray-600 hover:text-gray-900 px-3 py-2 text-sm font-medium">
                        Tugas
                    </a>
                    <span class="text-gray-600">{{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700">
                            Logout
                        </button>
                    </form>
                </div>
                @else
                <div class="flex items-center space-x-4">
                    <a href="{{ route('login') }}" 
                       class="text-gray-600 hover:text-gray-900 px-3 py-2 text-sm font-medium">
                        Login
                    </a>
                    <a href="{{ route('register') }}" 
                       class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                        Register
                    </a>
                </div>
                @endauth
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        @if ($errors->any())
        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
            {{ session('success') }}
        </div>
        @endif

        @yield('content')
    </main>

    <footer class="bg-white border-t border-gray-200 mt-12">
        <div class="max-w-7xl mx-auto py-6 px-4 text-center text-gray-500">
            <p>&copy; 2024 Task Management System - Tugas RPL</p>
        </div>
    </footer>
</body>
</html>
```

### Template: Register

**File:** `resources/views/auth/register.blade.php`

```html
@extends('layouts.app')

@section('title', 'Registrasi')

@section('content')
<div class="min-h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
        <h1 class="text-3xl font-bold text-center mb-6">Daftar Akun Baru</h1>

        <form method="POST" action="{{ route('register.store') }}" class="space-y-4">
            @csrf

            <div>
                <label class="block text-gray-700 font-bold mb-2">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name') }}" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                       required>
                @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-gray-700 font-bold mb-2">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                       required>
                @error('email')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-gray-700 font-bold mb-2">Password</label>
                <input type="password" name="password" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                       required>
                @error('password')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-gray-700 font-bold mb-2">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                       required>
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 font-bold">
                Daftar
            </button>
        </form>

        <p class="text-center text-gray-600 mt-4">
            Sudah punya akun? <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Login di sini</a>
        </p>
    </div>
</div>
@endsection
```

### Template: Login

**File:** `resources/views/auth/login.blade.php`

```html
@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="min-h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
        <h1 class="text-3xl font-bold text-center mb-6">Login</h1>

        <form method="POST" action="{{ route('login.store') }}" class="space-y-4">
            @csrf

            <div>
                <label class="block text-gray-700 font-bold mb-2">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                       required>
                @error('email')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-gray-700 font-bold mb-2">Password</label>
                <input type="password" name="password" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                       required>
                @error('password')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center">
                <input type="checkbox" name="remember" id="remember" class="h-4 w-4">
                <label for="remember" class="ml-2 text-gray-700">Ingat saya</label>
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 font-bold">
                Login
            </button>
        </form>

        <p class="text-center text-gray-600 mt-4">
            Belum punya akun? <a href="{{ route('register') }}" class="text-blue-600 hover:underline">Daftar di sini</a>
        </p>
    </div>
</div>
@endsection
```

### Template: Dashboard

**File:** `resources/views/dashboard.blade.php`

```html
@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="py-6">
    <h1 class="text-3xl font-bold mb-6">Dashboard</h1>

    <!-- Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-blue-100 p-6 rounded-lg">
            <h3 class="text-gray-700 font-bold">Total Tugas</h3>
            <p class="text-3xl font-bold text-blue-600">{{ $stats['total_tasks'] }}</p>
        </div>

        <div class="bg-green-100 p-6 rounded-lg">
            <h3 class="text-gray-700 font-bold">Tugas Selesai</h3>
            <p class="text-3xl font-bold text-green-600">{{ $stats['completed_tasks'] }}</p>
        </div>

        <div class="bg-yellow-100 p-6 rounded-lg">
            <h3 class="text-gray-700 font-bold">Tugas Pending</h3>
            <p class="text-3xl font-bold text-yellow-600">{{ $stats['pending_tasks'] }}</p>
        </div>

        <div class="bg-red-100 p-6 rounded-lg">
            <h3 class="text-gray-700 font-bold">Prioritas Tinggi</h3>
            <p class="text-3xl font-bold text-red-600">{{ $stats['high_priority_tasks'] }}</p>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="mb-6">
        <a href="{{ route('tasks.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 inline-block">
            + Buat Tugas Baru
        </a>
        <a href="{{ route('tasks.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 inline-block ml-2">
            Lihat Semua Tugas
        </a>
    </div>

    <!-- Recent Tasks -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-bold">Tugas Terbaru</h2>
        </div>

        @if($recentTasks->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Judul</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Prioritas</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentTasks as $task)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <a href="{{ route('tasks.edit', $task) }}" class="text-blue-600 hover:underline">
                                {{ $task->title }}
                            </a>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 rounded-full text-sm {{ $task->getPriorityBadgeClass() }}">
                                {{ ucfirst($task->priority) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 rounded-full text-sm {{ $task->getStatusBadgeClass() }}">
                                {{ str_replace('_', ' ', ucfirst($task->status)) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            {{ $task->created_at->format('d M Y') }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="px-6 py-4 text-center text-gray-500">
            <p>Tidak ada tugas. <a href="{{ route('tasks.create') }}" class="text-blue-600 hover:underline">Buat tugas baru</a></p>
        </div>
        @endif
    </div>
</div>
@endsection
```

### Template: Tasks Index

**File:** `resources/views/tasks/index.blade.php`

```html
@extends('layouts.app')

@section('title', 'Daftar Tugas')

@section('content')
<div class="py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Daftar Tugas</h1>
        <a href="{{ route('tasks.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
            + Buat Tugas Baru
        </a>
    </div>

    <!-- Filter dan Search -->
    <div class="bg-white p-4 rounded-lg shadow mb-6">
        <form method="GET" action="{{ route('tasks.index') }}" class="flex gap-4 flex-wrap">
            <input type="text" name="search" placeholder="Cari tugas..." 
                   value="{{ request('search') }}" 
                   class="px-4 py-2 border border-gray-300 rounded-lg flex-1 min-w-64">

            <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg">
                <option value="">Semua Status</option>
                <option value="todo" {{ request('status') == 'todo' ? 'selected' : '' }}>Belum Dimulai</option>
                <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>Sedang Dikerjakan</option>
                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
            </select>

            <select name="priority" class="px-4 py-2 border border-gray-300 rounded-lg">
                <option value="">Semua Prioritas</option>
                <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>Tinggi</option>
                <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>Sedang</option>
                <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>Rendah</option>
            </select>

            <button type="submit" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700">
                Filter
            </button>
        </form>
    </div>

    <!-- Tasks Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        @if($tasks->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase">Judul</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase">Prioritas</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase">Deadline</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tasks as $task)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-6 py-4 font-medium text-gray-900">
                            {{ Str::limit($task->title, 50) }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 rounded-full text-sm font-medium {{ $task->getPriorityBadgeClass() }}">
                                {{ ucfirst($task->priority) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 rounded-full text-sm font-medium {{ $task->getStatusBadgeClass() }}">
                                {{ str_replace('_', ' ', ucfirst($task->status)) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $task->due_date ? $task->due_date->format('d M Y') : '-' }}
                        </td>
                        <td class="px-6 py-4 text-sm space-x-2">
                            <a href="{{ route('tasks.edit', $task) }}" class="text-blue-600 hover:underline">Edit</a>
                            <form method="POST" action="{{ route('tasks.destroy', $task) }}" 
                                  style="display: inline;" 
                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus tugas ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t">
            {{ $tasks->links() }}
        </div>
        @else
        <div class="px-6 py-12 text-center text-gray-500">
            <p class="mb-4">Tidak ada tugas ditemukan.</p>
            <a href="{{ route('tasks.create') }}" class="text-blue-600 hover:underline">Buat tugas baru sekarang</a>
        </div>
        @endif
    </div>
</div>
@endsection
```

### Template: Create/Edit Task

**File:** `resources/views/tasks/create.blade.php` dan `resources/views/tasks/edit.blade.php`

```html
@extends('layouts.app')

@section('title', isset($task) ? 'Edit Tugas' : 'Buat Tugas')

@section('content')
<div class="py-6">
    <h1 class="text-3xl font-bold mb-6">{{ isset($task) ? 'Edit Tugas' : 'Buat Tugas Baru' }}</h1>

    <div class="bg-white p-8 rounded-lg shadow max-w-2xl">
        <form method="POST" 
              action="{{ isset($task) ? route('tasks.update', $task) : route('tasks.store') }}"
              class="space-y-4">
            @csrf
            @if(isset($task))
                @method('PUT')
            @endif

            <div>
                <label class="block text-gray-700 font-bold mb-2">Judul Tugas *</label>
                <input type="text" name="title" 
                       value="{{ isset($task) ? $task->title : old('title') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                       required>
                @error('title')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-gray-700 font-bold mb-2">Deskripsi</label>
                <textarea name="description" rows="4"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">{{ isset($task) ? $task->description : old('description') }}</textarea>
                @error('description')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 font-bold mb-2">Prioritas *</label>
                    <select name="priority" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
                        <option value="">Pilih Prioritas</option>
                        <option value="low" {{ (isset($task) && $task->priority == 'low') || old('priority') == 'low' ? 'selected' : '' }}>Rendah</option>
                        <option value="medium" {{ (isset($task) && $task->priority == 'medium') || old('priority') == 'medium' ? 'selected' : '' }}>Sedang</option>
                        <option value="high" {{ (isset($task) && $task->priority == 'high') || old('priority') == 'high' ? 'selected' : '' }}>Tinggi</option>
                    </select>
                    @error('priority')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                @if(isset($task))
                <div>
                    <label class="block text-gray-700 font-bold mb-2">Status</label>
                    <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        <option value="todo" {{ $task->status == 'todo' ? 'selected' : '' }}>Belum Dimulai</option>
                        <option value="in_progress" {{ $task->status == 'in_progress' ? 'selected' : '' }}>Sedang Dikerjakan</option>
                        <option value="completed" {{ $task->status == 'completed' ? 'selected' : '' }}>Selesai</option>
                    </select>
                    @error('status')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                @endif
            </div>

            <div>
                <label class="block text-gray-700 font-bold mb-2">Tanggal Deadline</label>
                <input type="date" name="due_date"
                       value="{{ isset($task) ? $task->due_date : old('due_date') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                @error('due_date')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-4 pt-4">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 font-bold">
                    {{ isset($task) ? 'Perbarui Tugas' : 'Buat Tugas' }}
                </button>
                <a href="{{ route('tasks.index') }}" class="bg-gray-600 text-white px-6 py-2 rounded-lg hover:bg-gray-700 font-bold">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
```

---

## 6. ENVIRONMENT FILE

**File:** `.env`

```
APP_NAME="Task Management System"
APP_ENV=local
APP_KEY=base64:YOUR_APP_KEY_HERE
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=task_management
DB_USERNAME=root
DB_PASSWORD=

AUTH_DRIVER=session
SESSION_DRIVER=file
QUEUE_CONNECTION=sync
```

---

## 7. KONFIGURASI TAILWIND

**File:** `tailwind.config.js`

```javascript
import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },
    plugins: [forms],
};
```

---

## 8. ARTISAN COMMANDS YANG DIGUNAKAN

```bash
# Setup project
composer install
npm install
npm run build

# Generate app key
php artisan key:generate

# Create database
mysql -u root -p
CREATE DATABASE task_management;

# Run migrations
php artisan migrate

# Seed database (opsional)
php artisan db:seed

# Start development server
php artisan serve
npm run dev
```

---

## CATATAN IMPLEMENTASI

1. **Authentication**: Menggunakan Laravel's built-in authentication dengan bcrypt password hashing
2. **Authorization**: Mengimplementasikan authorization policies untuk task ownership
3. **Validation**: Server-side validation untuk semua input form
4. **Error Handling**: Error messages ditampilkan dengan jelas kepada pengguna
5. **Responsive Design**: Menggunakan TailwindCSS grid system untuk responsive layout
6. **Database Relationships**: foreign key constraints untuk data integrity
7. **Routing Protection**: Middleware auth untuk melindungi protected routes
8. **CSRF Protection**: Automatic CSRF token protection di semua forms
