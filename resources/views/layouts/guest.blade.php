<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Perpustakaan Digital')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    @stack('styles')
</head>
<body class="min-h-screen bg-linear-to-br from-blue-900 via-blue-800 to-blue-700 flex items-center justify-center p-4">
    <!-- Decorative Elements -->
    <div class="absolute top-0 right-0 w-96 h-96 bg-blue-400 opacity-10 rounded-full -mr-48 -mt-48"></div>
    <div class="absolute bottom-0 left-0 w-96 h-96 bg-blue-400 opacity-10 rounded-full -ml-48 -mb-48"></div>

    <!-- Main Container -->
    <div class="w-full max-w-md relative z-10">
        @yield('content')
    </div>

    <!-- Footer -->
    <footer class="fixed bottom-0 left-0 right-0 bg-gray-900 bg-opacity-90 text-gray-400 py-4 border-t border-gray-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center text-xs">
            <p>&copy; 2024 Sistem Manajemen Perpustakaan Digital. Semua hak dilindungi.</p>
            <div class="space-x-4">
                <a href="{{ route('register') }}" class="hover:text-white transition">Daftar</a>
                <a href="{{ route('login') }}" class="hover:text-white transition">Masuk</a>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
