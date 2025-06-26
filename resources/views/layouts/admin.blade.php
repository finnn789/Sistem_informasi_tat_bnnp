<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin BNN</title>
    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-100 text-gray-800">

    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow p-6">
            <!-- Logo BNN -->
            <div class="flex flex-col items-center mb-4">
                <img src="{{ asset('images/logo2.png') }}" alt="Logo BNN" class="w-28 h-28 object-contain mb-2">
                <h1 class="text-xl font-bold">Tim Assesment</h1>
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
                        Daftar Laporan Masuk
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.users.index') }}"
                        class="block px-4 py-2 rounded hover:bg-gray-200 {{ request()->routeIs('admin.users.index') ? 'bg-gray-200 font-semibold' : '' }}">
                        User Management
                    </a>
                </li>
                <li>
                   <button onclick="logOut()"  class="flex px-4 py-2 rounded hover:text-white hover:bg-red-500 w-full justify-start" >
                       
                        Log Out
                    </button>
                </li>
            </ul>
        </aside>
        <form action="{{ route('admin.logout') }}" method="POST">
            @csrf
        </form>
        <!-- Content -->
        <main class="flex-1 p-6">
            @yield('content')
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function logOut(){
            document.querySelector('form').submit();
        }
    </script>
</body>

</html>
