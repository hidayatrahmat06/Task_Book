@extends('layouts.app')

@section('title', 'Dashboard Admin - Perpustakaan Digital')

@section('content')
<!-- Header -->
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-2">
        <i class="fas fa-chart-line text-blue-600 mr-3"></i>Dashboard Admin
    </h1>
    <p class="text-gray-600">Selamat datang kembali, {{ auth()->user()->name }}! Berikut adalah ringkasan sistem perpustakaan Anda.</p>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Books Card -->
    <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition border-l-4 border-blue-500 p-6">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-gray-600 text-sm font-semibold mb-2">Total Buku</p>
                <p class="text-3xl font-bold text-gray-900">{{ $stats['total_books'] }}</p>
                <p class="text-xs text-gray-500 mt-2">Koleksi perpustakaan</p>
            </div>
            <div class="bg-blue-100 rounded-lg p-3">
                <i class="fas fa-book text-blue-600 text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- Total Members Card -->
    <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition border-l-4 border-green-500 p-6">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-gray-600 text-sm font-semibold mb-2">Total Anggota</p>
                <p class="text-3xl font-bold text-gray-900">{{ $stats['total_users'] }}</p>
                <p class="text-xs text-gray-500 mt-2">Member aktif</p>
            </div>
            <div class="bg-green-100 rounded-lg p-3">
                <i class="fas fa-users text-green-600 text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- Active Borrowings Card -->
    <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition border-l-4 border-purple-500 p-6">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-gray-600 text-sm font-semibold mb-2">Sedang Dipinjam</p>
                <p class="text-3xl font-bold text-gray-900">{{ $stats['active_borrowings'] }}</p>
                <p class="text-xs text-gray-500 mt-2">Pinjaman aktif</p>
            </div>
            <div class="bg-purple-100 rounded-lg p-3">
                <i class="fas fa-hand-holding-book text-purple-600 text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- Overdue Borrowings Card -->
    <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition border-l-4 border-red-500 p-6">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-gray-600 text-sm font-semibold mb-2">Terlambat</p>
                <p class="text-3xl font-bold text-gray-900">{{ $stats['overdue_borrowings'] }}</p>
                <p class="text-xs text-gray-500 mt-2">Perlu perhatian</p>
            </div>
            <div class="bg-red-100 rounded-lg p-3">
                <i class="fas fa-exclamation-triangle text-red-600 text-2xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Additional Info Cards -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Total Borrowings -->
    <div class="bg-linear-to-br from-blue-50 to-indigo-50 rounded-lg shadow-md border border-blue-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm font-semibold">Total Transaksi Peminjaman</p>
                <p class="text-3xl font-bold text-blue-600 mt-2">{{ $stats['total_borrowings'] }}</p>
            </div>
            <i class="fas fa-receipt text-blue-200 text-5xl"></i>
        </div>
    </div>

    <!-- Total Fine Amount -->
    <div class="bg-linear-to-br from-red-50 to-orange-50 rounded-lg shadow-md border border-red-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm font-semibold">Total Denda Terkumpul</p>
                <p class="text-3xl font-bold text-red-600 mt-2">Rp {{ number_format($stats['total_fine']) }}</p>
            </div>
            <i class="fas fa-coins text-red-200 text-5xl"></i>
        </div>
    </div>
</div>

<!-- Recent Borrowings Table -->
<div class="bg-white rounded-lg shadow-md p-6 mb-8">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-bold text-gray-900">
            <i class="fas fa-history text-blue-600 mr-3"></i>Peminjaman Terbaru
        </h2>
        <a href="{{ route('borrowings.index') }}" class="text-blue-600 hover:text-blue-700 text-sm font-semibold flex items-center space-x-1">
            <span>Lihat Semua</span>
            <i class="fas fa-arrow-right"></i>
        </a>
    </div>

    @if($recentBorrowings->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b-2 border-gray-200">
                    <tr>
                        <th class="px-4 py-3 text-left text-gray-700 font-semibold">Member</th>
                        <th class="px-4 py-3 text-left text-gray-700 font-semibold">Buku</th>
                        <th class="px-4 py-3 text-left text-gray-700 font-semibold">Tgl Pinjam</th>
                        <th class="px-4 py-3 text-left text-gray-700 font-semibold">Tgl Kembali</th>
                        <th class="px-4 py-3 text-left text-gray-700 font-semibold">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($recentBorrowings as $borrowing)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-3">
                                <p class="font-semibold text-gray-900">{{ $borrowing->user->name }}</p>
                                <p class="text-xs text-gray-500">{{ $borrowing->user->email }}</p>
                            </td>
                            <td class="px-4 py-3">
                                <p class="text-gray-900">{{ $borrowing->book->title }}</p>
                                <p class="text-xs text-gray-500">{{ $borrowing->book->author }}</p>
                            </td>
                            <td class="px-4 py-3">
                                <p class="text-gray-900">{{ $borrowing->borrow_date->format('d/m/Y') }}</p>
                            </td>
                            <td class="px-4 py-3">
                                <p class="text-gray-900">{{ $borrowing->due_date->format('d/m/Y') }}</p>
                            </td>
                            <td class="px-4 py-3">
                                @if($borrowing->status === 'borrowed')
                                    <span class="inline-block bg-blue-100 text-blue-800 text-xs px-3 py-1 rounded-full font-semibold">
                                        <i class="fas fa-circle text-blue-600 mr-1"></i>Aktif
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
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="text-center py-12">
            <i class="fas fa-inbox text-gray-300 text-5xl mb-4 block"></i>
            <p class="text-gray-500 font-semibold">Tidak ada data peminjaman</p>
        </div>
    @endif
</div>

<!-- Overdue Borrowings Table -->
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-bold text-gray-900">
            <i class="fas fa-warning text-red-600 mr-3"></i>Peminjaman Terlambat
        </h2>
        <a href="{{ route('borrowings.index') }}" class="text-red-600 hover:text-red-700 text-sm font-semibold flex items-center space-x-1">
            <span>Lihat Semua</span>
            <i class="fas fa-arrow-right"></i>
        </a>
    </div>

    @if($overdueBorrowings->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-red-50 border-b-2 border-red-200">
                    <tr>
                        <th class="px-4 py-3 text-left text-red-700 font-semibold">Member</th>
                        <th class="px-4 py-3 text-left text-red-700 font-semibold">Buku</th>
                        <th class="px-4 py-3 text-left text-red-700 font-semibold">Tgl Kembali</th>
                        <th class="px-4 py-3 text-left text-red-700 font-semibold">Hari Terlambat</th>
                        <th class="px-4 py-3 text-left text-red-700 font-semibold">Denda</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-red-200">
                    @foreach($overdueBorrowings as $borrowing)
                        <tr class="hover:bg-red-50 transition">
                            <td class="px-4 py-3">
                                <p class="font-semibold text-gray-900">{{ $borrowing->user->name }}</p>
                                <p class="text-xs text-gray-500">{{ $borrowing->user->phone }}</p>
                            </td>
                            <td class="px-4 py-3">
                                <p class="text-gray-900">{{ $borrowing->book->title }}</p>
                            </td>
                            <td class="px-4 py-3">
                                <p class="text-gray-900">{{ $borrowing->due_date->format('d/m/Y') }}</p>
                            </td>
                            <td class="px-4 py-3">
                                <p class="font-semibold text-red-600">{{ $borrowing->days_overdue }} hari</p>
                            </td>
                            <td class="px-4 py-3">
                                <p class="font-semibold text-red-600">Rp {{ number_format($borrowing->fine_amount) }}</p>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="text-center py-12 text-green-600">
            <i class="fas fa-check-circle text-green-200 text-5xl mb-4 block"></i>
            <p class="text-green-700 font-semibold">Tidak ada peminjaman yang terlambat</p>
        </div>
    @endif
</div>
@endsection
