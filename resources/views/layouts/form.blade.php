<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel - Create Laporan</title>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
     @vite(['resources/css/app.css', 'resources/js/app.js']) <!-- Pastikan Tailwind CSS sudah dikompilasi -->
</head>
<body class="bg-gray-100 font-sans antialiased">

    <div class="min-h-screen flex flex-col">

        <!-- Navbar (Jika diperlukan) -->
        <header class="bg-blue-600 text-white p-4">
            <div class="container mx-auto">
                <h1 class="text-2xl font-semibold">Laporan Pembuatan</h1>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-grow container mx-auto px-4 py-6">
            @yield('content')
        </main>

        <!-- Footer (Jika diperlukan) -->
        <footer class="bg-gray-800 text-white text-center py-4">
            <p>&copy; 2025 Laporan App. All rights reserved.</p>
        </footer>
    </div>

</body>
</html>
