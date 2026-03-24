@extends('layouts.app')

@section('title', 'Dashboard - Perpustakaan Digital')

@section('content')
<!-- Header -->
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-2">
        <i class="fas fa-home text-blue-600 mr-3"></i>Dashboard Saya
    </h1>
    <p class="text-gray-600">Selamat datang, {{ auth()->user()->name }}! Kelola peminjaman buku Anda di sini.</p>
</div>

<!-- User Info Card -->
<div class="bg-linear-to-r from-blue-600 to-blue-700 text-white rounded-lg shadow-md p-6 mb-8">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <!-- User Profile -->
        <div class="flex items-center space-x-4 md:col-span-2">
            <div class="bg-white bg-opacity-20 rounded-full p-4">
                <i class="fas fa-user text-white text-2xl"></i>
            </div>
            <div>
                <p class="text-sm opacity-75">Anggota Terdaftar</p>
                <p class="text-2xl font-bold">{{ $user->name }}</p>
                <p class="text-sm opacity-75">{{ $user->email }}</p>
                <p class="text-sm opacity-75 mt-1">
                    <i class="fas fa-phone mr-2"></i>{{ $user->phone }}
                </p>
            </div>
        </div>

        <!-- Join Info -->
        <div>
            <p class="text-sm opacity-75 mb-1">Bergabung Sejak</p>
            <p class="text-lg font-semibold">{{ $user->created_at->format('d M Y') }}</p>
            <p class="text-sm opacity-75 mt-1">
                <i class="fas fa-id-card mr-2"></i>ID Anggota: {{ $user->id }}
            </p>
        </div>

        <!-- Status -->
        <div>
            <p class="text-sm opacity-75 mb-1">Status Anggota</p>
            <p class="text-lg font-semibold">Aktif</p>
            <p class="text-sm opacity-75 mt-1">
                <i class="fas fa-check-circle mr-2 text-green-300"></i>Terpercaya
            </p>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <!-- Active Borrowings Card -->
    <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition border-l-4 border-blue-500 p-6">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-gray-600 text-sm font-semibold mb-2">Buku Sedang Dipinjam</p>
                <p class="text-3xl font-bold text-gray-900">{{ $stats['active_count'] }}</p>
                <p class="text-xs text-gray-500 mt-2">Pinjaman aktif</p>
            </div>
            <div class="bg-blue-100 rounded-lg p-3">
                <i class="fas fa-hand-holding-book text-blue-600 text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- Returned Borrowings Card -->
    <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition border-l-4 border-green-500 p-6">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-gray-600 text-sm font-semibold mb-2">Buku Dikembalikan</p>
                <p class="text-3xl font-bold text-gray-900">{{ $stats['returned_count'] }}</p>
                <p class="text-xs text-gray-500 mt-2">Total pengembalian</p>
            </div>
            <div class="bg-green-100 rounded-lg p-3">
                <i class="fas fa-check-circle text-green-600 text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- Total Fine Card -->
    <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition border-l-4 border-red-500 p-6">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-gray-600 text-sm font-semibold mb-2">Total Denda</p>
                <p class="text-2xl font-bold text-red-600">Rp {{ number_format($stats['total_fine']) }}</p>
                <p class="text-xs text-gray-500 mt-2">Denda biaya keterlambatan</p>
            </div>
            <div class="bg-red-100 rounded-lg p-3">
                <i class="fas fa-coins text-red-600 text-2xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
    <!-- Browse Books -->
    <a href="{{ route('books.index') }}" class="bg-linear-to-br from-indigo-50 to-blue-50 border-2 border-indigo-200 rounded-lg p-6 hover:shadow-lg transition">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Jelajahi Koleksi Buku</h3>
                <p class="text-gray-600 text-sm">Lihat semua buku yang tersedia untuk dipinjam</p>
            </div>
            <i class="fas fa-arrow-right text-indigo-600 text-3xl"></i>
        </div>
    </a>

    <!-- Pinjam Buku -->
    <a href="{{ route('borrowings.create') }}" class="bg-linear-to-br from-green-50 to-emerald-50 border-2 border-green-200 rounded-lg p-6 hover:shadow-lg transition">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Pinjam Buku Baru</h3>
                <p class="text-gray-600 text-sm">Mulai meminjam buku dari koleksi kami</p>
            </div>
            <i class="fas fa-arrow-right text-green-600 text-3xl"></i>
        </div>
    </a>
</div>

<!-- Borrowing History -->
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-bold text-gray-900">
            <i class="fas fa-history text-blue-600 mr-3"></i>Riwayat Peminjaman
        </h2>
        <a href="{{ route('borrowings.index') }}" class="text-blue-600 hover:text-blue-700 text-sm font-semibold flex items-center space-x-1">
            <span>Lihat Semua</span>
            <i class="fas fa-arrow-right"></i>
        </a>
    </div>

    @if($myBorrowings->count() > 0)
        <div class="space-y-4">
            @foreach($myBorrowings->take(10) as $borrowing)
                @if($borrowing->status === 'borrowed')
                    <div class="bg-gray-50 rounded-lg p-4 hover:bg-gray-100 transition border-l-4 border-blue-500">
                @elseif($borrowing->status === 'returned')
                    <div class="bg-gray-50 rounded-lg p-4 hover:bg-gray-100 transition border-l-4 border-green-500">
                @elseif($borrowing->status === 'overdue')
                    <div class="bg-gray-50 rounded-lg p-4 hover:bg-gray-100 transition border-l-4 border-red-500">
                @endif
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 items-center">
                        <!-- Book Title -->
                        <div>
                            <p class="text-xs text-gray-500 font-semibold mb-1">JUDUL BUKU</p>
                            <p class="font-bold text-gray-900">{{ $borrowing->book->title }}</p>
                            <p class="text-xs text-gray-600">{{ $borrowing->book->author }}</p>
                        </div>

                        <!-- Category -->
                        <div>
                            <p class="text-xs text-gray-500 font-semibold mb-1">KATEGORI</p>
                            <p class="text-gray-900">{{ $borrowing->book->category->name }}</p>
                        </div>

                        <!-- Dates -->
                        <div>
                            <p class="text-xs text-gray-500 font-semibold mb-1">
                                @if($borrowing->status === 'returned')
                                    TGL PINJAM - KEMBALI
                                @else
                                    TGL PINJAM - JATUH TEMPO
                                @endif
                            </p>
                            <p class="text-gray-900 text-sm">
                                {{ $borrowing->borrow_date->format('d/m/Y') }} - 
                                @if($borrowing->status === 'returned')
                                    {{ $borrowing->return_date->format('d/m/Y') }}
                                @else
                                    {{ $borrowing->due_date->format('d/m/Y') }}
                                @endif
                            </p>
                        </div>

                        <!-- Status -->
                        <div>
                            <p class="text-xs text-gray-500 font-semibold mb-1">STATUS</p>
                            <div>
                                @if($borrowing->status === 'borrowed')
                                    <span class="inline-block bg-blue-100 text-blue-800 text-xs px-3 py-1 rounded-full font-semibold">
                                        <i class="fas fa-circle text-blue-600 mr-1"></i>Sedang Dipinjam
                                    </span>
                                @elseif($borrowing->status === 'returned')
                                    <span class="inline-block bg-green-100 text-green-800 text-xs px-3 py-1 rounded-full font-semibold">
                                        <i class="fas fa-check-circle text-green-600 mr-1"></i>Dikembalikan
                                    </span>
                                @elseif($borrowing->status === 'overdue')
                                    <span class="inline-block bg-red-100 text-red-800 text-xs px-3 py-1 rounded-full font-semibold">
                                        <i class="fas fa-exclamation-circle text-red-600 mr-1"></i>Terlambat
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Action -->
                        <div class="text-right">
                            @if($borrowing->status !== 'returned')
                                <a href="{{ route('borrowings.show', $borrowing) }}" class="text-blue-600 hover:text-blue-700 text-sm font-semibold">
                                    <i class="fas fa-eye mr-1"></i>Detail
                                </a>
                            @else
                                <p class="text-gray-400 text-sm">-</p>
                            @endif
                        </div>
                    </div>
                    </div>
            @endforeach
        </div>

        @if($myBorrowings->count() > 10)
            <div class="mt-6 text-center">
                <a href="{{ route('borrowings.index') }}" class="text-blue-600 hover:text-blue-700 font-semibold">
                    Tampilkan Semua Peminjaman →
                </a>
            </div>
        @endif
    @else
        <div class="text-center py-12">
            <i class="fas fa-inbox text-gray-300 text-5xl mb-4 block"></i>
            <p class="text-gray-500 font-semibold mb-4">Belum ada riwayat peminjaman</p>
            <a href="{{ route('borrowings.create') }}" class="text-blue-600 hover:text-blue-700 font-semibold inline-flex items-center space-x-2">
                <i class="fas fa-plus-circle"></i>
                <span>Mulai meminjam buku sekarang</span>
            </a>
        </div>
    @endif
</div>

<!-- Info Box -->
<div class="mt-8 bg-linear-to-r from-blue-50 to-indigo-50 border-2 border-blue-200 rounded-lg p-6">
    <h3 class="text-lg font-bold text-blue-900 mb-4 flex items-center">
        <i class="fas fa-lightbulb text-blue-600 mr-3"></i>Informasi Penting
    </h3>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-sm text-blue-800">
        <div>
            <p class="font-semibold mb-2"><i class="fas fa-calendar text-blue-600 mr-2"></i>Durasi Peminjaman</p>
            <p>Setiap buku dapat dipinjam selama 14 hari dari tanggal peminjaman.</p>
        </div>
        <div>
            <p class="font-semibold mb-2"><i class="fas fa-coins text-blue-600 mr-2"></i>Biaya Keterlambatan</p>
            <p>Denda sebesar Rp 1.000 per hari untuk setiap buku yang terlambat dikembalikan.</p>
        </div>
        <div>
            <p class="font-semibold mb-2"><i class="fas fa-clipboard-list text-blue-600 mr-2"></i>Batasan Peminjaman</p>
            <p>Setiap member dapat meminjam maksimal 5 buku secara bersamaan.</p>
        </div>
    </div>
</div>
@endsection
