<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem Manajemen Perpustakaan Digital')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    @stack('styles')
</head>
<body class="bg-gray-100">
    <!-- Mobile Menu Toggle Script -->
    <script>
        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            const toggle = document.getElementById('menu-toggle');
            menu.classList.toggle('hidden');
            toggle.classList.toggle('rotate-180');
        }

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }
    </script>

    <!-- Top Navigation Bar -->
    <nav class="bg-blue-900 text-white shadow-lg fixed w-full top-0 z-40">
        <div class="px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo & Brand -->
                <div class="flex items-center space-x-3">
                    <!-- Sidebar Toggle (Mobile) -->
                    <button onclick="toggleSidebar()" class="lg:hidden text-white hover:bg-blue-800 p-2 rounded-lg transition">
                        <i class="fas fa-bars text-xl"></i>
                    </button>

                    <!-- Logo -->
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-2 hover:opacity-90 transition">
                        <div class="bg-blue-400 p-2 rounded-lg">
                            <i class="fas fa-book text-xl"></i>
                        </div>
                        <span class="font-bold text-lg hidden sm:inline">Perpustakaan Digital</span>
                    </a>
                </div>

                <!-- Center Menu (Desktop) -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('books.index') }}" class="hover:text-blue-300 transition flex items-center space-x-2">
                        <i class="fas fa-book"></i>
                        <span>Buku</span>
                    </a>
                    <a href="{{ route('borrowings.index') }}" class="hover:text-blue-300 transition flex items-center space-x-2">
                        <i class="fas fa-receipt"></i>
                        <span>Peminjaman</span>
                    </a>
                    @auth
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('books.create') }}" class="hover:text-blue-300 transition flex items-center space-x-2">
                                <i class="fas fa-plus-circle"></i>
                                <span>Tambah Buku</span>
                            </a>
                        @endif
                    @endauth
                </div>

                <!-- Right Side (User Menu) -->
                <div class="flex items-center space-x-4">
                    @auth
                        <!-- User Dropdown -->
                        <div class="relative group">
                            <button class="flex items-center space-x-2 hover:bg-blue-800 px-3 py-2 rounded-lg transition">
                                <i class="fas fa-user-circle text-2xl"></i>
                                <span class="hidden sm:inline">{{ auth()->user()->name }}</span>
                                <i class="fas fa-chevron-down text-xs"></i>
                            </button>
                            <div class="absolute right-0 mt-0 w-56 bg-white rounded-lg shadow-xl hidden group-hover:block z-50 text-gray-800">
                                <div class="px-4 py-3 border-b border-gray-200">
                                    <p class="text-sm font-semibold">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-gray-500">{{ auth()->user()->email }}</p>
                                    <p class="text-xs text-gray-500 mt-1">
                                        <span class="inline-block bg-blue-100 text-blue-800 px-2 py-1 rounded">
                                            {{ auth()->user()->isAdmin() ? 'Admin' : 'Member' }}
                                        </span>
                                    </p>
                                </div>
                                <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 text-sm">
                                    <i class="fas fa-tachometer-alt mr-2 text-blue-600"></i>Dashboard
                                </a>
                                @if(auth()->user()->isAdmin())
                                    <a href="{{ route('books.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 text-sm">
                                        <i class="fas fa-cog mr-2 text-blue-600"></i>Kelola Buku
                                    </a>
                                @else
                                    <a href="{{ route('borrowings.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 text-sm">
                                        <i class="fas fa-history mr-2 text-blue-600"></i>Riwayat Peminjaman
                                    </a>
                                @endif
                                <hr class="my-2">
                                <form method="POST" action="{{ route('logout') }}" class="block">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100 text-sm">
                                        <i class="fas fa-sign-out-alt mr-2 text-red-600"></i>Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="hover:bg-blue-800 px-3 py-2 rounded-lg transition">
                            <i class="fas fa-sign-in-alt mr-2"></i>Login
                        </a>
                    @endauth
                </div>

                <!-- Mobile Menu Toggle -->
                <button onclick="toggleMobileMenu()" id="menu-toggle" class="md:hidden text-white hover:bg-blue-800 p-2 rounded-lg transition">
                    <i class="fas fa-ellipsis-v text-xl"></i>
                </button>
            </div>

            <!-- Mobile Menu -->
            <div id="mobile-menu" class="hidden md:hidden pb-4 space-y-2">
                <a href="{{ route('books.index') }}" class="block px-4 py-2 hover:bg-blue-800 rounded-lg transition">
                    <i class="fas fa-book mr-2"></i>Buku
                </a>
                <a href="{{ route('borrowings.index') }}" class="block px-4 py-2 hover:bg-blue-800 rounded-lg transition">
                    <i class="fas fa-receipt mr-2"></i>Peminjaman
                </a>
                @auth
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('books.create') }}" class="block px-4 py-2 hover:bg-blue-800 rounded-lg transition">
                            <i class="fas fa-plus-circle mr-2"></i>Tambah Buku
                        </a>
                    @endif
                @endauth
            </div>
        </div>
    </nav>

    <!-- Sidebar Overlay (Mobile) -->
    <div id="sidebar-overlay" onclick="toggleSidebar()" class="hidden fixed inset-0 bg-black bg-opacity-50 z-20 lg:hidden"></div>

    <!-- Sidebar (Desktop & Mobile) -->
    @auth
        <aside id="sidebar" class="fixed left-0 top-16 h-[calc(100vh-64px)] w-64 bg-blue-800 text-white shadow-lg transform -translate-x-full lg:translate-x-0 transition-transform duration-300 z-30 overflow-y-auto">
            <div class="p-6">
                <h3 class="text-lg font-bold mb-6">Menu</h3>

                @if(auth()->user()->isAdmin())
                    <!-- Admin Menu -->
                    <div class="space-y-2">
                        <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-blue-700 transition {{ request()->routeIs('dashboard') ? 'bg-blue-700' : '' }}">
                            <i class="fas fa-chart-line"></i>
                            <span>Dashboard</span>
                        </a>
                        <a href="{{ route('books.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-blue-700 transition {{ request()->routeIs('books.*') ? 'bg-blue-700' : '' }}">
                            <i class="fas fa-book"></i>
                            <span>Kelola Buku</span>
                        </a>
                        <a href="{{ route('borrowings.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-blue-700 transition {{ request()->routeIs('borrowings.index') ? 'bg-blue-700' : '' }}">
                            <i class="fas fa-receipt"></i>
                            <span>Data Peminjaman</span>
                        </a>
                    </div>

                    <hr class="my-4 border-blue-700">

                    <div class="space-y-2">
                        <p class="text-xs font-semibold text-blue-300 px-4 mb-3">STATISTIK</p>
                        <div class="bg-blue-700 rounded-lg p-4 space-y-3">
                            <div class="text-center">
                                <p class="text-2xl font-bold">{{ \App\Models\Book::count() }}</p>
                                <p class="text-xs text-blue-100">Total Buku</p>
                            </div>
                            <div class="text-center">
                                <p class="text-2xl font-bold">{{ \App\Models\Borrowing::where('status', 'borrowed')->count() }}</p>
                                <p class="text-xs text-blue-100">Sedang Dipinjam</p>
                            </div>
                            <div class="text-center">
                                <p class="text-2xl font-bold">{{ \App\Models\Borrowing::where('status', 'overdue')->count() }}</p>
                                <p class="text-xs text-blue-100">Terlambat</p>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Member Menu -->
                    <div class="space-y-2">
                        <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-blue-700 transition {{ request()->routeIs('dashboard') ? 'bg-blue-700' : '' }}">
                            <i class="fas fa-home"></i>
                            <span>Dashboard</span>
                        </a>
                        <a href="{{ route('books.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-blue-700 transition {{ request()->routeIs('books.*') ? 'bg-blue-700' : '' }}">
                            <i class="fas fa-book"></i>
                            <span>Koleksi Buku</span>
                        </a>
                        <a href="{{ route('borrowings.create') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-blue-700 transition {{ request()->routeIs('borrowings.create') ? 'bg-blue-700' : '' }}">
                            <i class="fas fa-plus-circle"></i>
                            <span>Pinjam Buku</span>
                        </a>
                        <a href="{{ route('borrowings.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-blue-700 transition {{ request()->routeIs('borrowings.*') ? 'bg-blue-700' : '' }}">
                            <i class="fas fa-receipt"></i>
                            <span>Peminjaman Saya</span>
                        </a>
                    </div>

                    <hr class="my-4 border-blue-700">

                    <div class="space-y-2">
                        <p class="text-xs font-semibold text-blue-300 px-4 mb-3">STATISTIK SAYA</p>
                        <div class="bg-blue-700 rounded-lg p-4 space-y-3">
                            <div class="text-center">
                                <p class="text-2xl font-bold">{{ auth()->user()->borrowings()->whereIn('status', ['borrowed', 'overdue'])->count() }}</p>
                                <p class="text-xs text-blue-100">Buku Dipinjam</p>
                            </div>
                            <div class="text-center">
                                <p class="text-2xl font-bold">Rp {{ number_format(auth()->user()->total_fine) }}</p>
                                <p class="text-xs text-blue-100">Total Denda</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </aside>
    @endauth

    <!-- Main Content -->
    <main class="@auth lg:ml-64 @endauth mt-16">
        <!-- Flash Messages -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6">
            @if($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 rounded-lg p-4 mb-4 shadow-sm">
                    <div class="flex items-start">
                        <i class="fas fa-exclamation-circle text-red-600 text-xl mt-0.5 mr-3 shrink-0"></i>
                        <div class="flex-1">
                            <h3 class="font-semibold text-red-800 mb-2">Terjadi Kesalahan</h3>
                            <ul class="list-disc list-inside text-red-700 text-sm space-y-1">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <button onclick="this.parentElement.parentElement.remove()" class="text-red-600 hover:text-red-800">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            @endif

            @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 rounded-lg p-4 mb-4 shadow-sm">
                    <div class="flex items-start">
                        <i class="fas fa-check-circle text-green-600 text-xl mt-0.5 mr-3 shrink-0"></i>
                        <div class="flex-1">
                            <p class="text-green-800 font-semibold">{{ session('success') }}</p>
                        </div>
                        <button onclick="this.parentElement.parentElement.remove()" class="text-green-600 hover:text-green-800">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            @endif

            @if(session('warning'))
                <div class="bg-yellow-50 border-l-4 border-yellow-500 rounded-lg p-4 mb-4 shadow-sm">
                    <div class="flex items-start">
                        <i class="fas fa-exclamation-triangle text-yellow-600 text-xl mt-0.5 mr-3 shrink-0"></i>
                        <div class="flex-1">
                            <p class="text-yellow-800 font-semibold">{{ session('warning') }}</p>
                        </div>
                        <button onclick="this.parentElement.parentElement.remove()" class="text-yellow-600 hover:text-yellow-800">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-50 border-l-4 border-red-500 rounded-lg p-4 mb-4 shadow-sm">
                    <div class="flex items-start">
                        <i class="fas fa-times-circle text-red-600 text-xl mt-0.5 mr-3 shrink-0"></i>
                        <div class="flex-1">
                            <p class="text-red-800 font-semibold">{{ session('error') }}</p>
                        </div>
                        <button onclick="this.parentElement.parentElement.remove()" class="text-red-600 hover:text-red-800">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            @endif
        </div>

        <!-- Page Content -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-300 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
                <!-- About -->
                <div>
                    <div class="flex items-center space-x-2 mb-4">
                        <i class="fas fa-book text-blue-400 text-2xl"></i>
                        <h3 class="text-lg font-bold text-white">Perpustakaan Digital</h3>
                    </div>
                    <p class="text-sm text-gray-400">Sistem manajemen perpustakaan modern untuk mengelola koleksi buku dan transaksi peminjaman dengan mudah dan efisien.</p>
                </div>

                <!-- Quick Links -->
                <div>
                    <h3 class="text-white font-bold mb-4">Tautan Cepat</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('books.index') }}" class="text-gray-400 hover:text-white transition">Daftar Buku</a></li>
                        @auth
                            <li><a href="{{ route('borrowings.index') }}" class="text-gray-400 hover:text-white transition">Peminjaman Saya</a></li>
                            <li><a href="{{ route('dashboard') }}" class="text-gray-400 hover:text-white transition">Dashboard</a></li>
                        @else
                            <li><a href="{{ route('login') }}" class="text-gray-400 hover:text-white transition">Login</a></li>
                            <li><a href="{{ route('register') }}" class="text-gray-400 hover:text-white transition">Daftar</a></li>
                        @endauth
                    </ul>
                </div>

                <!-- Contact -->
                <div>
                    <h3 class="text-white font-bold mb-4">Hubungi Kami</h3>
                    <div class="space-y-2 text-sm text-gray-400">
                        <p><i class="fas fa-envelope mr-2 text-blue-400"></i> perpustakaan@example.com</p>
                        <p><i class="fas fa-phone mr-2 text-blue-400"></i> +62 123 4567 8900</p>
                        <p><i class="fas fa-map-marker-alt mr-2 text-blue-400"></i> Jl. Perpustakaan No. 1, Kota</p>
                    </div>
                </div>
            </div>

            <hr class="border-gray-700 my-6">

            <div class="flex flex-col md:flex-row justify-between items-center text-sm text-gray-400">
                <p>&copy; 2024 Sistem Manajemen Perpustakaan Digital. Semua hak dilindungi.</p>
                <div class="flex space-x-6 mt-4 md:mt-0">
                    <a href="#" class="hover:text-white transition">Privacy Policy</a>
                    <a href="#" class="hover:text-white transition">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
