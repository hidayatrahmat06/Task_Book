<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpustakaan Digital - Sistem Manajemen Koleksi Buku</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-blue-900 text-white shadow-lg fixed w-full top-0 z-40">
        <div class="px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
            <div class="flex justify-between items-center h-16">
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-2 hover:opacity-90 transition">
                    <div class="bg-blue-400 p-2 rounded-lg">
                        <i class="fas fa-book text-xl"></i>
                    </div>
                    <span class="font-bold text-lg hidden sm:inline">Perpustakaan Digital</span>
                </a>

                <div class="flex items-center space-x-4">
                    @auth
                        <a href="{{ route('dashboard') }}" class="px-4 py-2 hover:bg-blue-800 rounded-lg transition">
                            Dashboard
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="px-4 py-2 hover:bg-blue-800 rounded-lg transition">
                                Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 hover:bg-blue-800 rounded-lg transition">
                            Login
                        </a>
                        <a href="{{ route('register') }}" class="px-4 py-2 bg-blue-400 text-white rounded-lg hover:bg-blue-500 transition">
                            Daftar
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="mt-16 bg-linear-to-br from-blue-900 via-blue-800 to-blue-700 text-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <div>
                    <h1 class="text-5xl font-bold mb-6">Sistem Manajemen Perpustakaan Digital</h1>
                    <p class="text-xl text-blue-100 mb-8">
                        Platform modern untuk mengelola koleksi buku dan transaksi peminjaman dengan mudah, cepat, dan efisien.
                    </p>
                    <div class="flex space-x-4">
                        @auth
                            <a href="{{ route('dashboard') }}" class="px-6 py-3 bg-white text-blue-900 font-semibold rounded-lg hover:bg-blue-50 transition">
                                <i class="fas fa-arrow-right mr-2"></i>Ke Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="px-6 py-3 bg-white text-blue-900 font-semibold rounded-lg hover:bg-blue-50 transition">
                                <i class="fas fa-sign-in-alt mr-2"></i>Masuk Sekarang
                            </a>
                            <a href="{{ route('register') }}" class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition border-2 border-white">
                                <i class="fas fa-user-plus mr-2"></i>Buat Akun
                            </a>
                        @endauth
                    </div>
                </div>
                <div class="hidden md:block">
                    <div class="bg-white bg-opacity-10 rounded-lg p-8 backdrop-blur-sm">
                        <i class="fas fa-book text-8xl opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-4xl font-bold text-center text-gray-900 mb-16">
                Fitur Unggulan
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="text-center p-8 bg-blue-50 rounded-lg hover:shadow-lg transition">
                    <div class="bg-blue-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-book-open text-blue-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Manajemen Koleksi</h3>
                    <p class="text-gray-600">Kelola semua buku di perpustakaan dengan mudah, termasuk kategori, penulis, dan stok yang tersedia.</p>
                </div>

                <!-- Feature 2 -->
                <div class="text-center p-8 bg-green-50 rounded-lg hover:shadow-lg transition">
                    <div class="bg-green-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-exchange-alt text-green-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Transaksi Peminjaman</h3>
                    <p class="text-gray-600">Sistem peminjaman yang terpadu untuk melacak siapa yang meminjam buku apa dan kapan pengembaliannya.</p>
                </div>

                <!-- Feature 3 -->
                <div class="text-center p-8 bg-purple-50 rounded-lg hover:shadow-lg transition">
                    <div class="bg-purple-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-chart-bar text-purple-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Laporan & Statistik</h3>
                    <p class="text-gray-600">Dashboard komprehensif dengan statistik real-time tentang peminjaman, anggota, dan kondisi perpustakaan.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Statistics Section -->
    <section class="py-16 bg-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="bg-white rounded-lg p-6 text-center shadow-md">
                    <p class="text-4xl font-bold text-blue-600">{{ \App\Models\Book::count() }}</p>
                    <p class="text-gray-600 mt-2">Total Buku</p>
                </div>
                <div class="bg-white rounded-lg p-6 text-center shadow-md">
                    <p class="text-4xl font-bold text-green-600">{{ \App\Models\User::where('role', 'member')->count() }}</p>
                    <p class="text-gray-600 mt-2">Total Anggota</p>
                </div>
                <div class="bg-white rounded-lg p-6 text-center shadow-md">
                    <p class="text-4xl font-bold text-purple-600">{{ \App\Models\Borrowing::count() }}</p>
                    <p class="text-gray-600 mt-2">Total Transaksi</p>
                </div>
                <div class="bg-white rounded-lg p-6 text-center shadow-md">
                    <p class="text-4xl font-bold text-red-600">{{ \App\Models\Category::count() }}</p>
                    <p class="text-gray-600 mt-2">Kategori Buku</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-blue-900 text-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-4xl font-bold mb-4">Siap Mengelola Perpustakaan Anda?</h2>
            <p class="text-xl text-blue-100 mb-8">
                Mulai gunakan sistem perpustakaan digital kami sekarang dan tingkatkan efisiensi pengelolaan koleksi buku Anda.
            </p>
            @auth
                <a href="{{ route('dashboard') }}" class="px-8 py-4 bg-white text-blue-900 font-bold rounded-lg hover:bg-blue-50 transition inline-block">
                    <i class="fas fa-arrow-right mr-2"></i>Buka Dashboard
                </a>
            @else
                <div class="space-x-4">
                    <a href="{{ route('register') }}" class="px-8 py-4 bg-white text-blue-900 font-bold rounded-lg hover:bg-blue-50 transition inline-block">
                        <i class="fas fa-user-plus mr-2"></i>Buat Akun Gratis
                    </a>
                    <a href="{{ route('login') }}" class="px-8 py-4 bg-blue-600 text-white font-bold rounded-lg hover:bg-blue-700 transition inline-block border-2 border-white">
                        <i class="fas fa-sign-in-alt mr-2"></i>Masuk
                    </a>
                </div>
            @endauth
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <div>
                    <h3 class="text-white font-bold mb-4 flex items-center space-x-2">
                        <i class="fas fa-book text-blue-400"></i>
                        <span>Perpustakaan Digital</span>
                    </h3>
                    <p class="text-sm">Sistem manajemen perpustakaan modern untuk sekolah, universitas, dan institusi.</p>
                </div>
                <div>
                    <h4 class="text-white font-bold mb-4">Navigasi</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-white transition">Tentang</a></li>
                        <li><a href="#" class="hover:text-white transition">Fitur</a></li>
                        <li><a href="#" class="hover:text-white transition">Kontak</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-bold mb-4">Dukungan</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-white transition">Bantuan</a></li>
                        <li><a href="#" class="hover:text-white transition">FAQ</a></li>
                        <li><a href="#" class="hover:text-white transition">Feedback</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-bold mb-4">Kontak</h4>
                    <ul class="space-y-2 text-sm">
                        <li><i class="fas fa-envelope mr-2"></i>perpustakaan@example.com</li>
                        <li><i class="fas fa-phone mr-2"></i>+62 123 4567 8900</li>
                        <li><i class="fas fa-map-marker-alt mr-2"></i>Jl. Perpustakaan No. 1</li>
                    </ul>
                </div>
            </div>
            <hr class="border-gray-700 my-6">
            <p class="text-center text-sm">&copy; 2024 Sistem Manajemen Perpustakaan Digital. Semua hak dilindungi.</p>
        </div>
    </footer>
</body>
</html>
