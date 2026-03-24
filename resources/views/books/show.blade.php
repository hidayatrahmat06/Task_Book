@extends('layouts.app')

@section('content')
<div class="py-6">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('books.index') }}" class="text-blue-600 hover:text-blue-800 transition">
                <i class="fas fa-arrow-left mr-2"></i>Kembali ke Daftar Buku
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Book Cover & Info (Left Column) -->
            <div class="md:col-span-1">
                <!-- Cover Image -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-6">
                    @if($book->cover_image)
                        <img 
                            src="{{ asset('storage/' . $book->cover_image) }}" 
                            alt="{{ $book->title }}"
                            class="w-full h-auto object-cover"
                        >
                    @else
                        <div class="w-full h-96 bg-gray-200 flex items-center justify-center">
                            <i class="fas fa-book text-6xl text-gray-400"></i>
                        </div>
                    @endif
                </div>

                <!-- Status & Stock Card -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="font-bold text-gray-900 mb-4">Status Stok</h3>
                    <div class="space-y-4">
                        <div>
                            <p class="text-gray-600 text-sm mb-1">Ketersediaan:</p>
                            @if($book->stock > 0)
                                <div class="flex items-center">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800 w-full justify-center">
                                        <i class="fas fa-check-circle mr-2"></i>Tersedia
                                    </span>
                                </div>
                            @else
                                <div class="flex items-center">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800 w-full justify-center">
                                        <i class="fas fa-times-circle mr-2"></i>Habis Terjual
                                    </span>
                                </div>
                            @endif
                        </div>
                        <div class="border-t pt-4">
                            <p class="text-gray-600 text-sm mb-1">Stok Tersedia:</p>
                            <p class="text-3xl font-bold text-blue-600">{{ $book->stock }}</p>
                            <p class="text-gray-500 text-xs mt-1">buku</p>
                        </div>
                    </div>
                </div>

                <!-- Admin Actions -->
                @if(auth()->user()->isAdmin())
                    <div class="mt-6 space-y-2">
                        <a 
                            href="{{ route('books.edit', $book) }}"
                            class="block w-full px-4 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition text-center"
                        >
                            <i class="fas fa-edit mr-2"></i>Edit Buku
                        </a>
                        <form 
                            method="POST" 
                            action="{{ route('books.destroy', $book) }}"
                            class="w-full"
                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus buku ini?')"
                        >
                            @csrf
                            @method('DELETE')
                            <button 
                                type="submit"
                                class="w-full px-4 py-3 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition"
                            >
                                <i class="fas fa-trash mr-2"></i>Hapus Buku
                            </button>
                        </form>
                    </div>
                @endif
            </div>

            <!-- Book Details (Right Column) -->
            <div class="md:col-span-2">
                <!-- Title & Author -->
                <div class="bg-white rounded-lg shadow-lg p-8 mb-6">
                    <h1 class="text-4xl font-bold text-gray-900 mb-2">{{ $book->title }}</h1>
                    <p class="text-xl text-gray-600 mb-6">
                        <i class="fas fa-user text-blue-600 mr-2"></i>{{ $book->author }}
                    </p>

                    <!-- Category Badge -->
                    <div class="mb-6">
                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                            <i class="fas fa-tag mr-2"></i>{{ $book->category->name }}
                        </span>
                    </div>

                    <!-- Basic Info -->
                    <div class="grid grid-cols-2 gap-4">
                        <div class="border-t pt-4">
                            <p class="text-gray-600 text-sm mb-1">ISBN</p>
                            <p class="text-lg font-semibold text-gray-900">{{ $book->isbn }}</p>
                        </div>
                        <div class="border-t pt-4">
                            <p class="text-gray-600 text-sm mb-1">Tahun Terbit</p>
                            <p class="text-lg font-semibold text-gray-900">{{ $book->year_published }}</p>
                        </div>
                        <div class="border-t pt-4">
                            <p class="text-gray-600 text-sm mb-1">Penerbit</p>
                            <p class="text-lg font-semibold text-gray-900">{{ $book->publisher }}</p>
                        </div>
                        <div class="border-t pt-4">
                            <p class="text-gray-600 text-sm mb-1">Ditambahkan</p>
                            <p class="text-lg font-semibold text-gray-900">{{ $book->created_at->translatedFormat('d M Y') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Description -->
                @if($book->description)
                    <div class="bg-white rounded-lg shadow-lg p-8 mb-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Deskripsi Buku</h3>
                        <p class="text-gray-700 leading-relaxed">{{ $book->description }}</p>
                    </div>
                @endif

                <!-- Borrowing Stats -->
                <div class="bg-white rounded-lg shadow-lg p-8 mb-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-6">Statistik Peminjaman</h3>
                    <div class="grid grid-cols-3 gap-4">
                        <div class="text-center p-4 bg-blue-50 rounded-lg">
                            <p class="text-3xl font-bold text-blue-600">{{ $book->borrowings()->count() }}</p>
                            <p class="text-gray-600 text-sm mt-2">Total Peminjaman</p>
                        </div>
                        <div class="text-center p-4 bg-green-50 rounded-lg">
                            <p class="text-3xl font-bold text-green-600">{{ $book->borrowings()->where('status', 'returned')->count() }}</p>
                            <p class="text-gray-600 text-sm mt-2">Sudah Dikembalikan</p>
                        </div>
                        <div class="text-center p-4 bg-red-50 rounded-lg">
                            <p class="text-3xl font-bold text-red-600">{{ $book->borrowings()->whereIn('status', ['borrowed', 'overdue'])->count() }}</p>
                            <p class="text-gray-600 text-sm mt-2">Sedang Dipinjam</p>
                        </div>
                    </div>
                </div>

                <!-- Borrow/Return Action -->
                <div class="bg-white rounded-lg shadow-lg p-8">
                    @if(auth()->user()->isAdmin())
                        <div class="text-center">
                            <p class="text-gray-600 mb-4">Administrator dapat mengedit atau menghapus buku dari tombol di sebelah kiri.</p>
                        </div>
                    @else
                        @if($book->stock > 0)
                            <!-- Check if user already borrowed this book -->
                            @php
                                $userBorrowing = $book->borrowings()
                                    ->where('user_id', auth()->id())
                                    ->whereIn('status', ['borrowed', 'overdue'])
                                    ->first();
                            @endphp

                            @if($userBorrowing)
                                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 text-center">
                                    <p class="text-yellow-800">
                                        <i class="fas fa-info-circle mr-2"></i>
                                        Anda saat ini sedang meminjam buku ini. Klik tombol di bawah untuk mengembalikan.
                                    </p>
                                </div>
                                <form method="POST" action="{{ route('borrowings.return', $userBorrowing) }}" class="mt-4">
                                    @csrf
                                    <button 
                                        type="submit"
                                        class="w-full px-6 py-3 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition"
                                    >
                                        <i class="fas fa-undo mr-2"></i>Kembalikan Buku
                                    </button>
                                </form>
                            @else
                                <a 
                                    href="{{ route('borrowings.create') }}?book_id={{ $book->id }}"
                                    class="block w-full px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition text-center"
                                >
                                    <i class="fas fa-hand-holding-heart mr-2"></i>Pinjam Buku Ini
                                </a>
                            @endif
                        @else
                            <div class="bg-red-50 border border-red-200 rounded-lg p-4 text-center">
                                <p class="text-red-800">
                                    <i class="fas fa-times-circle mr-2"></i>
                                    Maaf, buku ini sedang tidak tersedia (habis terjual).
                                </p>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>

        <!-- Recent Borrowings (Admin View) -->
        @if(auth()->user()->isAdmin() && $book->borrowings->isNotEmpty())
            <div class="mt-8 bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="px-8 py-6 border-b">
                    <h3 class="text-2xl font-bold text-gray-900">Riwayat Peminjaman Terbaru</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Peminjam</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Peminjaman</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Kembali</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($book->borrowings->take(10) as $borrowing)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div>
                                            <p class="font-semibold text-gray-900">{{ $borrowing->user->name }}</p>
                                            <p class="text-sm text-gray-600">{{ $borrowing->user->email }}</p>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ $borrowing->borrow_date->translatedFormat('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ $borrowing->return_date ? $borrowing->return_date->translatedFormat('d M Y') : '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($borrowing->status === 'borrowed')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                <i class="fas fa-hourglass-half mr-1"></i>Dipinjam
                                            </span>
                                        @elseif($borrowing->status === 'returned')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                <i class="fas fa-check-circle mr-1"></i>Dikembalikan
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                <i class="fas fa-exclamation-circle mr-1"></i>Terlambat
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
