@extends('layouts.guest')

@section('title', 'Daftar - Sistem Manajemen Perpustakaan')

@section('content')
<!-- Card -->
<div class="bg-white rounded-xl shadow-2xl p-8 backdrop-blur-sm bg-opacity-95">
    <!-- Header -->
    <div class="text-center mb-8">
        <div class="flex justify-center mb-4">
            <div class="bg-linear-to-br from-blue-600 to-blue-800 rounded-full p-4 shadow-lg">
                <i class="fas fa-book text-white text-3xl"></i>
            </div>
        </div>
        <h1 class="text-3xl font-bold text-gray-900">Perpustakaan Digital</h1>
        <p class="text-gray-600 mt-2">Buat akun baru untuk memulai</p>
    </div>

    <!-- Form -->
    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                <i class="fas fa-user mr-2 text-blue-600"></i>Nama Lengkap
            </label>
            @if($errors->has('name'))
                <input
                    type="text"
                    name="name"
                    id="name"
                    value="{{ old('name') }}"
                    placeholder="Masukkan nama lengkap Anda"
                    class="w-full px-4 py-3 border-2 border-red-500 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition hover:border-red-600"
                >
            @else
                <input
                    type="text"
                    name="name"
                    id="name"
                    value="{{ old('name') }}"
                    placeholder="Masukkan nama lengkap Anda"
                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition hover:border-gray-300"
                >
            @endif
            @error('name')
                <p class="mt-2 text-sm text-red-600 flex items-center">
                    <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                </p>
            @enderror
        </div>

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
                >
            @else
                <input
                    type="email"
                    name="email"
                    id="email"
                    value="{{ old('email') }}"
                    placeholder="nama@example.com"
                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition hover:border-gray-300"
                >
            @endif
            @error('email')
                <p class="mt-2 text-sm text-red-600 flex items-center">
                    <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                </p>
            @enderror
        </div>

        <!-- Phone -->
        <div>
            <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">
                <i class="fas fa-phone mr-2 text-blue-600"></i>Nomor Telepon
            </label>
            @if($errors->has('phone'))
                <input
                    type="text"
                    name="phone"
                    id="phone"
                    value="{{ old('phone') }}"
                    placeholder="+62 812 3456 7890"
                    class="w-full px-4 py-3 border-2 border-red-500 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition hover:border-red-600"
                >
            @else
                <input
                    type="text"
                    name="phone"
                    id="phone"
                    value="{{ old('phone') }}"
                    placeholder="+62 812 3456 7890"
                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition hover:border-gray-300"
                >
            @endif
            @error('phone')
                <p class="mt-2 text-sm text-red-600 flex items-center">
                    <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                </p>
            @enderror
        </div>

        <!-- Address -->
        <div>
            <label for="address" class="block text-sm font-semibold text-gray-700 mb-2">
                <i class="fas fa-map-marker-alt mr-2 text-blue-600"></i>Alamat
            </label>
            @if($errors->has('address'))
                <textarea
                    name="address"
                    id="address"
                    rows="2"
                    placeholder="Masukkan alamat lengkap Anda"
                    class="w-full px-4 py-3 border-2 border-red-500 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition hover:border-red-600 resize-none"
                >{{ old('address') }}</textarea>
            @else
                <textarea
                    name="address"
                    id="address"
                    rows="2"
                    placeholder="Masukkan alamat lengkap Anda"
                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition hover:border-gray-300 resize-none"
                >{{ old('address') }}</textarea>
            @endif
            @error('address')
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
                    placeholder="Minimal 6 karakter"
                    class="w-full px-4 py-3 border-2 border-red-500 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition hover:border-red-600"
                >
            @else
                <input
                    type="password"
                    name="password"
                    id="password"
                    placeholder="Minimal 6 karakter"
                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition hover:border-gray-300"
                >
            @endif
            @error('password')
                <p class="mt-2 text-sm text-red-600 flex items-center">
                    <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                </p>
            @enderror
        </div>

        <!-- Password Confirmation -->
        <div>
            <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                <i class="fas fa-lock mr-2 text-blue-600"></i>Konfirmasi Password
            </label>
            @if($errors->has('password_confirmation'))
                <input
                    type="password"
                    name="password_confirmation"
                    id="password_confirmation"
                    placeholder="Ulangi password Anda"
                    class="w-full px-4 py-3 border-2 border-red-500 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition hover:border-red-600"
                >
            @else
                <input
                    type="password"
                    name="password_confirmation"
                    id="password_confirmation"
                    placeholder="Ulangi password Anda"
                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition hover:border-gray-300"
                >
            @endif
            @error('password_confirmation')
                <p class="mt-2 text-sm text-red-600 flex items-center">
                    <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                </p>
            @enderror
        </div>

        <!-- Submit Button -->
        <button
            type="submit"
            class="w-full bg-linear-to-r from-blue-600 to-blue-700 text-white py-3 rounded-lg font-semibold hover:shadow-lg transition transform hover:scale-105 duration-200 flex items-center justify-center space-x-2 mt-6"
        >
            <i class="fas fa-user-plus"></i>
            <span>Buat Akun</span>
        </button>
    </form>

    <!-- Divider -->
    <div class="my-6 flex items-center">
        <div class="flex-1 border-t-2 border-gray-300"></div>
        <span class="px-3 text-gray-500 text-sm font-medium">Atau</span>
        <div class="flex-1 border-t-2 border-gray-300"></div>
    </div>

    <!-- Login Link -->
    <p class="text-center text-gray-600">
        Sudah punya akun?
        <a href="{{ route('login') }}" class="text-blue-600 font-bold hover:text-blue-700 transition">
            Masuk di sini
        </a>
    </p>

    <!-- Info Box -->
    <div class="mt-6 bg-linear-to-r from-green-50 to-emerald-50 border-2 border-green-200 rounded-lg p-4">
        <h3 class="text-sm font-bold text-green-900 mb-2 flex items-center">
            <i class="fas fa-shield-alt mr-2 text-green-600"></i>Keamanan Data Anda
        </h3>
        <ul class="text-xs text-green-800 space-y-1">
            <li><i class="fas fa-check-circle mr-2 text-green-600"></i>Password dienkripsi dengan aman</li>
            <li><i class="fas fa-check-circle mr-2 text-green-600"></i>Data pribadi Anda terlindungi</li>
            <li><i class="fas fa-check-circle mr-2 text-green-600"></i>Akun member gratis, tanpa biaya</li>
        </ul>
    </div>
</div>
@endsection
