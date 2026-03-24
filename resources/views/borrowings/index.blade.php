@extends('layouts.app')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Transaksi Peminjaman</h1>
                    <p class="text-gray-600 mt-1">
                        @if(auth()->user()->isAdmin())
                            Kelola semua peminjaman anggota perpustakaan
                        @else
                            Riwayat peminjaman Anda
                        @endif
                    </p>
                </div>
                @if(!auth()->user()->isAdmin())
                    <a href="{{ route('borrowings.create') }}" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                        <i class="fas fa-plus mr-2"></i>Pinjam Buku
                    </a>
                @endif
            </div>
        </div>

        <!-- Borrowings Table -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            @if(auth()->user()->isAdmin())
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Anggota</th>
                            @endif
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Buku</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Peminjaman</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jatuh Tempo</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Denda</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($borrowings as $borrowing)
                            <tr class="hover:bg-gray-50 transition">
                                @if(auth()->user()->isAdmin())
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div>
                                            <p class="font-semibold text-gray-900">{{ $borrowing->user->name }}</p>
                                            <p class="text-sm text-gray-600">{{ $borrowing->user->email }}</p>
                                        </div>
                                    </td>
                                @endif
                                <td class="px-6 py-4">
                                    <div>
                                        <p class="font-semibold text-gray-900">{{ $borrowing->book->title }}</p>
                                        <p class="text-sm text-gray-600">{{ $borrowing->book->author }}</p>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    {{ $borrowing->borrow_date->translatedFormat('d M Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $borrowing->due_date->translatedFormat('d M Y') }}</p>
                                        @if($borrowing->status === 'borrowed' && now()->isAfter($borrowing->due_date))
                                            <p class="text-xs text-red-600 font-semibold">
                                                <i class="fas fa-exclamation-circle mr-1"></i>{{ now()->diffInDays($borrowing->due_date) }} hari terlambat
                                            </p>
                                        @endif
                                    </div>
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
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($borrowing->fine_amount > 0)
                                        <p class="text-sm font-semibold text-red-600">
                                            Rp {{ number_format($borrowing->fine_amount, 0, ',', '.') }}
                                        </p>
                                    @else
                                        <p class="text-sm text-gray-600">-</p>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex gap-2">
                                        <a 
                                            href="{{ route('borrowings.show', $borrowing) }}" 
                                            class="text-blue-600 hover:text-blue-900 px-3 py-1 rounded hover:bg-blue-50"
                                            title="Lihat Detail"
                                        >
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if($borrowing->status !== 'returned' && (auth()->user()->isAdmin() || auth()->id() === $borrowing->user_id))
                                            <form 
                                                method="POST" 
                                                action="{{ route('borrowings.return', $borrowing) }}" 
                                                class="inline"
                                            >
                                                @csrf
                                                <button 
                                                    type="submit"
                                                    class="text-green-600 hover:text-green-900 px-3 py-1 rounded hover:bg-green-50"
                                                    title="Kembalikan"
                                                >
                                                    <i class="fas fa-undo"></i>
                                                </button>
                                            </form>
                                        @endif
                                        @if(auth()->user()->isAdmin())
                                            <form 
                                                method="POST" 
                                                action="{{ route('borrowings.destroy', $borrowing) }}" 
                                                class="inline"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus record ini?')"
                                            >
                                                @csrf
                                                @method('DELETE')
                                                <button 
                                                    type="submit"
                                                    class="text-red-600 hover:text-red-900 px-3 py-1 rounded hover:bg-red-50"
                                                    title="Hapus"
                                                >
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ auth()->user()->isAdmin() ? 7 : 6 }}" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <i class="fas fa-inbox text-5xl text-gray-300 mb-4"></i>
                                        <p class="text-gray-500 font-medium">Tidak ada data peminjaman</p>
                                        @if(!auth()->user()->isAdmin())
                                            <a href="{{ route('borrowings.create') }}" class="text-blue-600 hover:text-blue-800 mt-4">
                                                Mulai pinjam buku sekarang →
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $borrowings->links() }}
        </div>
    </div>
</div>
@endsection
