<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin BNN</title>
    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">

<div class="flex min-h-screen">
    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow p-6">
        <!-- Logo BNN -->
        <div class="flex flex-col items-center mb-4">
            <img src="{{ asset('images/logo2.png') }}" alt="Logo BNN" class="w-28 h-28 object-contain mb-2">
            <h1 class="text-xl font-bold">Admin BNN</h1>
        </div>

        <ul class="space-y-3 mt-6">
            <li>
                <a href="{{ route('admin.dashboard') }}"
                   class="block px-4 py-2 rounded hover:bg-gray-200 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-200 font-semibold' : '' }}">
                    Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('admin.suratmasuk') }}"
                   class="block px-4 py-2 rounded hover:bg-gray-200 {{ request()->routeIs('admin.suratmasuk') ? 'bg-gray-200 font-semibold' : '' }}">
                    Surat Masuk
                </a>
            </li>
        </ul>
    </aside>

    <!-- Content -->
    <main class="flex-1 p-6">
        @yield('content')
    </main>
</div>

</body>
</html>
