@extends('layouts.app')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Pinjam Buku</h1>
                    <p class="text-gray-600 mt-1">Pilih buku yang ingin dipinjam dari koleksi kami</p>
                </div>
                <a href="{{ route('borrowings.index') }}" class="text-blue-600 hover:text-blue-800">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
            </div>

            <!-- Admin Member Selection -->
            @if(auth()->user()->isAdmin())
                <div class="bg-purple-50 border border-purple-200 rounded-lg p-4 mb-6">
                    <form method="GET" action="{{ route('borrowings.create') }}" class="flex gap-3 items-end">
                        <div class="flex-1">
                            <label for="member_id" class="block text-sm font-medium text-gray-700 mb-1">
                                <i class="fas fa-user mr-2 text-purple-600"></i>Pilih Anggota (untuk dipinjamkan)
                            </label>
                            <select 
                                id="member_id"
                                name="member_id"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                            >
                                <option value="">Untuk Diri Sendiri</option>
                                @foreach($users as $member)
                                    <option value="{{ $member->id }}">
                                        {{ $member->name }} ({{ $member->email }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <button 
                            type="submit"
                            class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition"
                        >
                            Filter
                        </button>
                    </form>
                </div>
            @endif

            <!-- Info Box -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                <p class="text-blue-800">
                    <i class="fas fa-info-circle mr-2"></i>
                    <strong>Kebijakan Peminjaman:</strong> Durasi peminjaman 14 hari. Denda keterlambatan Rp 1.000 per hari.
                </p>
            </div>
        </div>

        <!-- Available Books Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($books as $book)
                <div class="bg-white rounded-lg shadow-md hover:shadow-xl transition overflow-hidden group">
                    <!-- Book Cover -->
                    <div class="relative bg-gray-200 h-60 overflow-hidden flex items-center justify-center">
                        @if($book->cover_image)
                            <img 
                                src="{{ asset('storage/' . $book->cover_image) }}" 
                                alt="{{ $book->title }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition"
                            >
                        @else
                            <i class="fas fa-book text-6xl text-gray-400"></i>
                        @endif
                        
                        <!-- Stock Badge -->
                        <div class="absolute top-3 right-3">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-500 text-white">
                                <i class="fas fa-check-circle mr-1"></i>{{ $book->stock }} Tersedia
                            </span>
                        </div>
                    </div>

                    <!-- Book Info -->
                    <div class="p-4">
                        <p class="text-xs font-semibold text-blue-600 uppercase tracking-wider">{{ $book->category->name }}</p>
                        <h3 class="text-lg font-bold text-gray-900 mt-2 line-clamp-2 leading-tight">{{ $book->title }}</h3>
                        <p class="text-sm text-gray-600 mt-1">{{ $book->author }}</p>
                        
                        <!-- Book Meta -->
                        <div class="mt-3 space-y-1 text-xs text-gray-600">
                            <p><i class="fas fa-barcode mr-2 text-gray-400"></i>ISBN: {{ $book->isbn }}</p>
                            <p><i class="fas fa-calendar mr-2 text-gray-400"></i>{{ $book->year_published }}</p>
                            <p><i class="fas fa-building mr-2 text-gray-400"></i>{{ $book->publisher }}</p>
                        </div>

                        <!-- Borrow Button & Details -->
                        <div class="mt-4 space-y-2">
                            <form method="POST" action="{{ route('borrowings.store') }}">
                                @csrf
                                <input type="hidden" name="book_id" value="{{ $book->id }}">
                                @if(auth()->user()->isAdmin() && request('member_id'))
                                    <input type="hidden" name="user_id" value="{{ request('member_id') }}">
                                @endif
                                <button 
                                    type="submit"
                                    class="w-full px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition text-sm"
                                >
                                    <i class="fas fa-hand-holding-heart mr-2"></i>Pinjam
                                </button>
                            </form>
                            <a 
                                href="{{ route('books.show', $book) }}"
                                class="block w-full px-4 py-2 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition text-center text-sm"
                            >
                                <i class="fas fa-eye mr-2"></i>Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full">
                    <div class="bg-white rounded-lg shadow p-12 text-center">
                        <i class="fas fa-inbox text-6xl text-gray-300 mb-4 block"></i>
                        <p class="text-gray-500 font-medium text-lg">Tidak ada buku yang tersedia</p>
                        <p class="text-gray-400 text-sm mt-2">Semua buku sedang dipinjam. Silakan coba lagi nanti.</p>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $books->links() }}
        </div>
    </div>
</div>
@endsection
