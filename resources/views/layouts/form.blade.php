<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel - Create Laporan</title>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <!-- Pastikan Tailwind CSS sudah dikompilasi -->
</head>

<body class="bg-gray-100 font-sans antialiased">

    <div class="min-h-screen flex flex-col">

        <!-- Navbar (Jika diperlukan) -->
        {{-- <header class="bg-blue-600 text-white p-4">
            <div class="container mx-auto">
                <h1 class="text-2xl font-semibold">Laporan Pembuatan</h1>
            </div>
        </header> --}}

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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous">
</script>

</html>
