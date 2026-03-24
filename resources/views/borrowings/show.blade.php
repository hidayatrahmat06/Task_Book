@extends('layouts.app')

@section('content')
<div class="py-6">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('borrowings.index') }}" class="text-blue-600 hover:text-blue-800 transition">
                <i class="fas fa-arrow-left mr-2"></i>Kembali ke Daftar Peminjaman
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Book Cover (Left) -->
            <div>
                <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-6">
                    @if($borrowing->book->cover_image)
                        <img 
                            src="{{ asset('storage/' . $borrowing->book->cover_image) }}" 
                            alt="{{ $borrowing->book->title }}"
                            class="w-full h-auto object-cover"
                        >
                    @else
                        <div class="w-full h-80 bg-gray-200 flex items-center justify-center">
                            <i class="fas fa-book text-6xl text-gray-400"></i>
                        </div>
                    @endif
                </div>

                <!-- Status Card -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="font-bold text-gray-900 mb-4">Status Peminjaman</h3>
                    
                    <div class="mb-4">
                        <p class="text-gray-600 text-sm mb-2">Status Saat Ini:</p>
                        <div>
                            @if($borrowing->status === 'borrowed')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-blue-100 text-blue-800">
                                    <i class="fas fa-hourglass-half mr-2"></i>Sedang Dipinjam
                                </span>
                                @if(now()->isAfter($borrowing->due_date))
                                    <p class="text-xs text-red-600 font-semibold mt-2">
                                        <i class="fas fa-exclamation-circle mr-1"></i>TERLAMBAT {{ now()->diffInDays($borrowing->due_date) }} HARI
                                    </p>
                                @endif
                            @elseif($borrowing->status === 'returned')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-2"></i>Sudah Dikembalikan
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-red-100 text-red-800">
                                    <i class="fas fa-exclamation-circle mr-2"></i>Terlambat
                                </span>
                            @endif
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="space-y-3 text-sm">
                        <div>
                            <p class="text-gray-600 mb-1">Tanggal Peminjaman:</p>
                            <p class="font-semibold text-gray-900">{{ $borrowing->borrow_date->translatedFormat('d F Y \p\u{0075}kul H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600 mb-1">Jatuh Tempo:</p>
                            <p class="font-semibold text-gray-900">{{ $borrowing->due_date->translatedFormat('d F Y') }}</p>
                        </div>
                        @if($borrowing->return_date)
                            <div>
                                <p class="text-gray-600 mb-1">Tanggal Pengembalian:</p>
                                <p class="font-semibold text-gray-900">{{ $borrowing->return_date->translatedFormat('d F Y \p\u{0075}kul H:i') }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Borrowing Details (Right) -->
            <div class="md:col-span-2">
                <!-- Book & Member Info -->
                <div class="bg-white rounded-lg shadow-lg p-8 mb-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">{{ $borrowing->book->title }}</h2>
                    
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <p class="text-gray-600 text-sm mb-1">Penulis</p>
                            <p class="text-lg font-semibold text-gray-900">{{ $borrowing->book->author }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600 text-sm mb-1">Kategori</p>
                            <p class="text-lg font-semibold text-gray-900">{{ $borrowing->book->category->name }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600 text-sm mb-1">ISBN</p>
                            <p class="text-lg font-semibold text-gray-900">{{ $borrowing->book->isbn }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600 text-sm mb-1">Penerbit</p>
                            <p class="text-lg font-semibold text-gray-900">{{ $borrowing->book->publisher }}</p>
                        </div>
                    </div>

                    <hr class="my-6">

                    <h3 class="font-bold text-gray-900 mb-4">Informasi Peminjam</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-gray-600 text-sm mb-1">Nama</p>
                            <p class="text-lg font-semibold text-gray-900">{{ $borrowing->user->name }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600 text-sm mb-1">Email</p>
                            <p class="text-lg font-semibold text-gray-900">{{ $borrowing->user->email }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600 text-sm mb-1">Telepon</p>
                            <p class="text-lg font-semibold text-gray-900">{{ $borrowing->user->phone ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600 text-sm mb-1">Role</p>
                            <p class="text-lg font-semibold text-gray-900">
                                @if($borrowing->user->isAdmin())
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-purple-100 text-purple-800">
                                        Administrator
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-blue-100 text-blue-800">
                                        Anggota
                                    </span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Fine & Duration Info -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Duration -->
                    <div class="bg-linear-to-br from-blue-50 to-blue-100 border border-blue-200 rounded-lg p-6">
                        <h3 class="font-bold text-gray-900 mb-4 flex items-center">
                            <i class="fas fa-calendar text-blue-600 mr-2"></i>Durasi Peminjaman
                        </h3>
                        <p class="text-gray-700">
                            <i class="fas fa-arrow-right mr-2"></i>
                            {{ $borrowing->borrow_date->diffInDays($borrowing->due_date) }} hari
                        </p>
                        @if($borrowing->status === 'borrowed')
                            @if(now()->isBefore($borrowing->due_date))
                                <p class="text-gray-700 mt-2">
                                    <i class="fas fa-hourglass-end mr-2"></i>
                                    Sisa waktu: <strong>{{ $borrowing->due_date->diffInDays(now()) }} hari</strong>
                                </p>
                            @else
                                <p class="text-red-700 font-semibold mt-2">
                                    <i class="fas fa-exclamation-circle mr-2"></i>
                                    Terlambat: <strong>{{ now()->diffInDays($borrowing->due_date) }} hari</strong>
                                </p>
                            @endif
                        @endif
                    </div>

                    <!-- Fine Amount -->
                    <div class="bg-linear-to-br from-red-50 to-red-100 border border-red-200 rounded-lg p-6">
                        <h3 class="font-bold text-gray-900 mb-4 flex items-center">
                            <i class="fas fa-money-bill-wave text-red-600 mr-2"></i>Denda
                        </h3>
                        @if($borrowing->fine_amount > 0)
                            <p class="text-2xl font-bold text-red-600">
                                Rp {{ number_format($borrowing->fine_amount, 0, ',', '.') }}
                            </p>
                            <p class="text-sm text-gray-700 mt-2">
                                <i class="fas fa-info-circle mr-1"></i>
                                Rp 1.000 per hari keterlambatan
                            </p>
                        @else
                            <p class="text-2xl font-bold text-green-600">
                                Rp 0
                            </p>
                            <p class="text-sm text-gray-700 mt-2">
                                <i class="fas fa-check-circle mr-1"></i>
                                Tidak ada denda
                            </p>
                        @endif
                    </div>
                </div>

                <!-- Notes -->
                @if($borrowing->notes)
                    <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
                        <h3 class="font-bold text-gray-900 mb-2">Catatan</h3>
                        <p class="text-gray-700">{{ $borrowing->notes }}</p>
                    </div>
                @endif

                <!-- Return Button -->
                @if($borrowing->status !== 'returned' && (auth()->user()->isAdmin() || auth()->id() === $borrowing->user_id))
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 mb-6">
                        <p class="text-yellow-800 mb-4">
                            <i class="fas fa-info-circle mr-2"></i>
                            Apakah Anda ingin mengembalikan buku ini?
                        </p>
                        <form method="POST" action="{{ route('borrowings.return', $borrowing) }}">
                            @csrf
                            <button 
                                type="submit"
                                class="w-full px-6 py-3 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition"
                            >
                                <i class="fas fa-undo mr-2"></i>Kembalikan Buku
                            </button>
                        </form>
                    </div>
                @elseif($borrowing->status === 'returned')
                    <div class="bg-green-50 border border-green-200 rounded-lg p-6">
                        <p class="text-green-800">
                            <i class="fas fa-check-circle mr-2"></i>
                            Buku ini telah dikembalikan pada {{ $borrowing->return_date->translatedFormat('d F Y \p\u{0075}kul H:i') }}
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
