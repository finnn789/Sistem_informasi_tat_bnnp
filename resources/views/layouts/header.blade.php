<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Default Title')</title> <!-- Judul halaman, bisa di-override -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <header>
        <nav>
            <!-- Menu atau Navigasi -->
        </nav>
    </header>

    <main>
        <!-- Tempat untuk konten halaman -->
        @yield('content')
    </main>

    <footer>
        <p>&copy; 2025 My Application</p>
    </footer>

    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>
