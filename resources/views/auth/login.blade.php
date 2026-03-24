@extends('layouts.guest')

@section('title', 'Login - Sistem Manajemen Perpustakaan')

@section('content')
<!-- Card -->
<div class="bg-white rounded-xl shadow-2xl p-8 backdrop-blur-sm bg-opacity-95">
    <!-- Header -->
    <div class="text-center mb-8">
        <div class="flex justify-center mb-4">
            <div class="bg-linear-to-br from-blue-600 to-blue-800 rounded-full p-4 shadow-lg">
                <i class="fas fa-book text-blue-800 text-3xl"></i>
            </div>
        </div>
        <h1 class="text-3xl font-bold text-gray-900">Perpustakaan Digital</h1>
        <p class="text-gray-600 mt-2">Masuk ke akun Anda</p>
    </div>

    <!-- Form -->
    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email -->
        <div>
            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                <i class="fas fa-envelope mr-2 text-blue-600"></i>Email
            </label>
            @if($errors->has('email'))
                <input
                    type="email"
                    name="email"
                    id="email"
                    value="{{ old('email') }}"
                    placeholder="nama@example.com"
                    class="w-full px-4 py-3 border-2 border-red-500 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition hover:border-red-600"
                    autofocus
                >
            @else
                <input
                    type="email"
                    name="email"
                    id="email"
                    value="{{ old('email') }}"
                    placeholder="nama@example.com"
                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition hover:border-gray-300"
                    autofocus
                >
            @endif
            @error('email')
                <p class="mt-2 text-sm text-red-600 flex items-center">
                    <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                </p>
            @enderror
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                <i class="fas fa-lock mr-2 text-blue-600"></i>Password
            </label>
            @if($errors->has('password'))
                <input
                    type="password"
                    name="password"
                    id="password"
                    placeholder="Masukkan password Anda"
                    class="w-full px-4 py-3 border-2 border-red-500 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition hover:border-red-600"
                >
            @else
                <input
                    type="password"
                    name="password"
                    id="password"
                    placeholder="Masukkan password Anda"
                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition hover:border-gray-300"
                >
            @endif
            @error('password')
                <p class="mt-2 text-sm text-red-600 flex items-center">
                    <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                </p>
            @enderror
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <input
                type="checkbox"
                name="remember"
                id="remember"
                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded cursor-pointer"
            >
            <label for="remember" class="ml-3 block text-sm text-gray-600 cursor-pointer">
                Ingat saya
            </label>
        </div>

        <!-- Submit Button -->
        <button
            type="submit"
            class="w-full bg-linear-to-r from-blue-600 to-blue-700 text-white py-3 rounded-lg font-semibold hover:shadow-lg transition transform hover:scale-105 duration-200 flex items-center justify-center space-x-2"
        >
            <i class="fas fa-sign-in-alt"></i>
            <span>Masuk</span>
        </button>
    </form>

    <!-- Divider -->
    <div class="my-6 flex items-center">
        <div class="flex-1 border-t-2 border-gray-300"></div>
        <span class="px-3 text-gray-500 text-sm font-medium">Atau</span>
        <div class="flex-1 border-t-2 border-gray-300"></div>
    </div>

    <!-- Register Link -->
    <p class="text-center text-gray-600">
        Belum punya akun?
        <a href="{{ route('register') }}" class="text-blue-600 font-bold hover:text-blue-700 transition">
            Daftar di sini
        </a>
    </p>

    <!-- Flash Messages -->
    @if($errors->any())
        <div class="mt-6 bg-red-50 border-l-4 border-red-500 rounded-lg p-4">
            <div class="flex items-start">
                <i class="fas fa-exclamation-circle text-red-600 text-lg mt-0.5 mr-3"></i>
                <div>
                    <h3 class="font-semibold text-red-800 text-sm">Gagal Login</h3>
                    <ul class="mt-2 space-y-1 text-red-700 text-xs">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <!-- Demo Credentials Info -->
    <div class="mt-6 bg-linear-to-r from-blue-50 to-indigo-50 border-2 border-blue-200 rounded-lg p-4">
        <h3 class="text-sm font-bold text-blue-900 mb-3 flex items-center">
            <i class="fas fa-info-circle mr-2 text-blue-600"></i>Akun Demo (Testing)
        </h3>
        <div class="space-y-2 text-xs text-blue-800">
            <div class="flex items-start">
                <i class="fas fa-crown mr-2 text-blue-600 mt-0.5 shrink-0"></i>
                <div>
                    <strong>Admin:</strong>
                    <br>Email: admin@perpustakaan.com
                    <br>Password: password123
                </div>
            </div>
            <hr class="border-blue-200 my-2">
            <div class="flex items-start">
                <i class="fas fa-user mr-2 text-blue-600 mt-0.5 shrink-0"></i>
                <div>
                    <strong>Member:</strong>
                    <br>Email: budi@example.com
                    <br>Password: password123
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

