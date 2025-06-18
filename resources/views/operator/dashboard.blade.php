<!DOCTYPE html>

<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Operator Kepolisian</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f4f8;
        }

        .sidebar {
            transition: all 0.3s ease;
        }

        .sidebar-item:hover {
            background-color: rgba(59, 130, 246, 0.1);
        }

        .sidebar-active {
            background-color: #3b82f6;
            color: white;
        }

        .sidebar-active:hover {
            background-color: #2563eb;
        }

        .table-hover tr:hover {
            background-color: rgba(59, 130, 246, 0.05);
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.open {
                transform: translateX(0);
            }
        }

        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .status-pending {
            background-color: #fef3c7;
            color: #92400e;
        }

        .status-approved {
            background-color: #d1fae5;
            color: #065f46;
        }

        .status-rejected {
            background-color: #fee2e2;
            color: #b91c1c;
        }

        .status-processing {
            background-color: #e0f2fe;
            color: #0369a1;
        }
    </style>

</head>

<body>
    <!-- Navbar -->
    <nav class="bg-white shadow-md fixed w-full z-20">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <button id="sidebar-toggle" class="text-gray-600 hidden focus:outline-none mr-4"
                        fdprocessedid="idcgra">

                    </button>
                    <div class="flex items-center">
                        <div class="bg-blue-600 text-white p-2 rounded-lg mr-2">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <span class="font-semibold text-gray-800 text-lg">POLRI DIGITAL</span>
                    </div>
                </div>

                <!-- Notification and Profile Menu
                'kronologis',
        'data_tersangka_id',
        'laporan_polisi',
        'surat_perintah_penyidikan',
        'surat_uji_laboratorium',
        'berita_acara_pemeriksaan_tersangka',
        'surat_persetujuan_tat',
        'surat_pernyataan_penyidik',
        'status',
        'alasan_penolakan',
        'tanggal_pelaksanaan',
        'file_surat_penerimaan'
                
                -->
                {{-- @foreach ($laporanTAT as $laporan)
                        <div class="ml-4">
                            <span class="text-sm text-gray-600">Laporan TAT: {{ $laporan->status }}</span>
                        </div>
                        
                    @endforeach --}}
                <div class="flex items-center">
                    <div class="relative">
                        <button id="profile-menu-button" class="flex items-center focus:outline-none"
                            fdprocessedid="fv89jm">
                            <span
                                class="mr-2 text-sm font-medium text-gray-700 hidden md:block">{{ $nama }}</span>
                            <div class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center text-white">
                                <i class="fas fa-user"></i>
                            </div>
                        </button>

                        <div id="profile-dropdown"
                            class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 hidden z-50">
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-user mr-2"></i> Profil
                            </a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-cog mr-2"></i> Pengaturan
                            </a>
                            <div class="border-t border-gray-100"></div>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="block w-full px-4 py-2 text-left text-sm text-red-600 hover:bg-gray-100">
                                    <i class="fas fa-sign-out-alt mr-2"></i> Keluar
                                </button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <div id="sidebar"
        class="sidebar fixed left-0 top-0 pt-16 h-full w-64 bg-white shadow-lg z-10 transform -translate-x-full md:translate-x-0">
        <div class="px-4 py-6">
            <div class="mb-8">
                <div class="flex items-center justify-center mb-4">
                    <div class="h-20 w-20 rounded-full bg-blue-100 flex items-center justify-center">
                        <i class="fas fa-user-tie text-blue-600 text-3xl"></i>
                    </div>
                </div>
                <h5 class="text-center font-medium">Selamat Datang, {{ $nama }}</h5>
                <p class="text-center text-sm text-gray-500">{{ $satker }}</p>
            </div>

            <ul class="space-y-1">
                <li>
                    <a href="#" class="sidebar-item sidebar-active flex items-center px-4 py-3 rounded-lg">
                        <i class="fas fa-tachometer-alt w-5 mr-3"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="sidebar-item flex items-center px-4 py-3 rounded-lg text-gray-700">
                        <i class="fas fa-file-alt w-5 mr-3"></i>
                        <span>Buat Laporan</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="sidebar-item flex items-center px-4 py-3 rounded-lg text-gray-700">
                        <i class="fas fa-clipboard-check w-5 mr-3"></i>
                        <span>Verifikasi</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="sidebar-item flex items-center px-4 py-3 rounded-lg text-gray-700">
                        <i class="fas fa-chart-bar w-5 mr-3"></i>
                        <span>Statistik</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="sidebar-item flex items-center px-4 py-3 rounded-lg text-gray-700">
                        <i class="fas fa-users w-5 mr-3"></i>
                        <span>Pengguna</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="sidebar-item flex items-center px-4 py-3 rounded-lg text-gray-700">
                        <i class="fas fa-cog w-5 mr-3"></i>
                        <span>Pengaturan</span>
                    </a>
                </li>
            </ul>
        </div>


        <!--Example Routing Sidebar-->

        <!-- Sidebar -->
        {{-- <div id="sidebar" class="sidebar fixed left-0 top-0 pt-16 h-full w-64 bg-white shadow-lg z-10 transform -translate-x-full md:translate-x-0">
    <div class="px-4 py-6">
        <ul class="space-y-1">
            <li>
                <a href="{{ route('operator.dashboard') }}" class="sidebar-item @if (request()->routeIs('operator.dashboard')) sidebar-active @endif flex items-center px-4 py-3 rounded-lg">
                    <i class="fas fa-tachometer-alt w-5 mr-3"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ route('operator.laporan.index') }}" class="sidebar-item @if (request()->routeIs('operator.laporan.index')) sidebar-active @endif flex items-center px-4 py-3 rounded-lg text-gray-700">
                    <i class="fas fa-file-alt w-5 mr-3"></i>
                    <span>Laporan TAT</span>
                </a>
            </li>
            <li>
                <a href="{{ route('verifikasi.index') }}" class="sidebar-item @if (request()->routeIs('verifikasi.index')) sidebar-active @endif flex items-center px-4 py-3 rounded-lg text-gray-700">
                    <i class="fas fa-clipboard-check w-5 mr-3"></i>
                    <span>Verifikasi</span>
                </a>
            </li>
            <li>
                <a href="{{ route('operator.statistik') }}" class="sidebar-item @if (request()->routeIs('operator.statistik')) sidebar-active @endif flex items-center px-4 py-3 rounded-lg text-gray-700">
                    <i class="fas fa-chart-bar w-5 mr-3"></i>
                    <span>Statistik</span>
                </a>
            </li>
            <li>
                <a href="{{ route('operator.pengaturan') }}" class="sidebar-item @if (request()->routeIs('operator.pengaturan')) sidebar-active @endif flex items-center px-4 py-3 rounded-lg text-gray-700">
                    <i class="fas fa-cog w-5 mr-3"></i>
                    <span>Pengaturan</span>
                </a>
            </li>
        </ul>
    </div>
</div> --}}



    </div>

    <!-- Main Content -->
    <div class="md:ml-64 pt-16 min-h-screen">
        <div class="container mx-auto px-4 py-6">
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">Dashboard Operator </h1>
                        <p class="text-gray-600">Manajemen Laporan Tindak Pidana Tertentu (TAT)</p>
                    </div>
                    <a href={{ route('operator.laporan.create') }}
                        class="mt-4 md:mt-0 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg flex items-center transition-colors">
                        <i class="fas fa-plus-circle mr-2"></i>
                        Buat Laporan Baru
                    </a>
                </div>

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                    <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg p-4 text-white shadow-md">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-sm opacity-80">Total Laporan</p>
                                <h3 class="text-2xl font-bold">{{ $totalLaporan }}</h3>
                            </div>
                            <div class="bg-white bg-opacity-30 p-3 rounded-full">
                                <i class="fas fa-file-alt"></i>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-lg p-4 text-white shadow-md">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-sm opacity-80">Disetujui</p>
                                <h3 class="text-2xl font-bold">{{ $totalDiterima }}</h3>
                            </div>
                            <div class="bg-white bg-opacity-30 p-3 rounded-full">
                                <i class="fas fa-check-circle"></i>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-lg p-4 text-white shadow-md">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-sm opacity-80">Menunggu</p>
                                <h3 class="text-2xl font-bold">{{ $totalProses }}</h3>
                            </div>
                            <div class="bg-white bg-opacity-30 p-3 rounded-full">
                                <i class="fas fa-clock"></i>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-r from-red-500 to-red-600 rounded-lg p-4 text-white shadow-md">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-sm opacity-80">Ditolak</p>
                                <h3 class="text-2xl font-bold">{{ $totalDitolak }}</h3>
                            </div>
                            <div class="bg-white bg-opacity-30 p-3 rounded-full">
                                <i class="fas fa-times-circle"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Search and Filter -->
                <div class="flex flex-col md:flex-row gap-4 mb-6">
                    <div class="flex-grow">
                        <div class="relative">
                            <input type="text" placeholder="Cari laporan..."
                                class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                fdprocessedid="m59nn">
                            <div class="absolute left-3 top-2.5 text-gray-400">
                                <i class="fas fa-search"></i>
                            </div>
                        </div>
                    </div>

                    <div class="flex gap-2">
                        <select
                            class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            fdprocessedid="y3kulu">
                            <option value="">Semua Status</option>
                            <option value="pending">Menunggu</option>
                            <option value="approved">Disetujui</option>
                            <option value="rejected">Ditolak</option>
                            <option value="processing">Diproses</option>
                        </select>

                        <select
                            class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            fdprocessedid="jwdggn">
                            <option value="">Semua Tanggal</option>
                            <option value="today">Hari Ini</option>
                            <option value="week">Minggu Ini</option>
                            <option value="month">Bulan Ini</option>
                            <option value="year">Tahun Ini</option>
                        </select>
                    </div>
                </div>

                <!-- Daftar Laporan -->
                <div class="overflow-x-auto bg-white rounded-lg shadow">
                    <table class="min-w-full table-hover">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-200">
                                <th
                                    class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    No</th>
                                <th
                                    class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Surat Permohonan TAT</th>
                                <th
                                    class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Tanggal Pengajuan</th>
                                <th
                                    class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status</th>
                                <th
                                    class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">

                            @foreach ($laporanTAT as $laporan)
                                <tr>
                                    <!-- Menampilkan Nomor Urut -->
                                    <td class="py-3 px-4 whitespace-nowrap text-sm text-gray-700">
                                        {{ $loop->iteration }}</td>

                                    <!-- Menampilkan Surat Permohonan TAT -->
                                    <td class="py-3 px-4 whitespace-nowrap text-sm text-gray-700">
                                        {{ $laporan->nomor_surat_permohonan_tat }}</td>

                                    <!-- Menampilkan Tanggal Pengajuan -->
                                    <td class="py-3 px-4 whitespace-nowrap text-sm text-gray-700">
                                        {{ $laporan->created_at->format('d M Y') }}</td>

                                    <!-- Menampilkan Status dengan Warna Dinamis menggunakan Tailwind CSS -->
                                    <td class="py-3 px-4 whitespace-nowrap">
                                        <span
                                            class="
                status-badge 
                {{ $laporan->status == 'menunggu'
                    ? 'bg-yellow-100 text-yellow-800'
                    : ($laporan->status == 'diterima'
                        ? 'bg-green-100 text-green-800'
                        : ($laporan->status == 'ditolak'
                            ? 'bg-red-100 text-red-800'
                            : 'bg-blue-100 text-blue-800')) }} 
                px-3 py-1 rounded-full text-xs font-semibold">
                                            {{ ucfirst($laporan->status) }}
                                        </span>
                                    </td>

                                    <td class="py-3 px-4 whitespace-nowrap">
                                        {{-- Tombol Aksi --}}
                                        <div class="flex items-center space-x-2">
                                            @if ($laporan->status === 'diterima')
                                                <a href="#"
                                                    class="group relative inline-flex items-center justify-center px-4 py-2 
                  bg-white border border-green-300 text-green-700 text-sm font-medium 
                  rounded-md hover:bg-green-50 hover:border-green-400 hover:text-green-800 
                  transition-all duration-150 ease-in-out shadow-sm hover:shadow">
                                                    <i class="fas fa-eye mr-1.5 text-xs"></i>
                                                    Lihat
                                                    <span
                                                        class="absolute inset-x-0 -bottom-px h-px bg-gradient-to-r from-transparent 
                         via-green-500 to-transparent opacity-0 group-hover:opacity-100 
                         transition-opacity duration-150"></span>
                                                </a>
                                            @endif

                                            @if ($laporan->status === 'ditolak' || $laporan->status === 'menunggu')
                                                <a href="{{ route('operator.laporan.edit', $laporan->id) }}"
                                                    class="group relative inline-flex items-center justify-center px-4 py-2 
                  bg-white border border-blue-300 text-blue-700 text-sm font-medium 
                  rounded-md hover:bg-blue-50 hover:border-blue-400 hover:text-blue-800 
                  transition-all duration-150 ease-in-out shadow-sm hover:shadow">
                                                    <i class="fas fa-edit mr-1.5 text-xs"></i>
                                                    Edit
                                                    <span
                                                        class="absolute inset-x-0 -bottom-px h-px bg-gradient-to-r from-transparent 
                         via-blue-500 to-transparent opacity-0 group-hover:opacity-100 
                         transition-opacity duration-150"></span>
                                                </a>

                                                <button data-id="{{ $laporan->id }}"
                                                    class="deleteButton group relative inline-flex items-center justify-center px-4 py-2 
                       bg-white border border-red-300 text-red-700 text-sm font-medium 
                       rounded-md hover:bg-red-50 hover:border-red-400 hover:text-red-800 
                       transition-all duration-150 ease-in-out shadow-sm hover:shadow">
                                                    <i class="fas fa-trash mr-1.5 text-xs"></i>
                                                    Hapus
                                                    <span
                                                        class="absolute inset-x-0 -bottom-px h-px bg-gradient-to-r from-transparent 
                         via-red-500 to-transparent opacity-0 group-hover:opacity-100 
                         transition-opacity duration-150"></span>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach



                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="flex justify-between border-2 border-gray-200 items-center mt-6">
                    {{-- <p class="text-sm text-gray-600">Menampilkan 1-5 dari 124 laporan</p> --}}
                    <div class="flex  w-full ">
                        {{ $laporanTAT->links('vendor.pagination.tailwind') }}
                        {{-- <button
                            class="px-3 py-1 rounded border border-gray-300 text-gray-600 hover:bg-gray-50 disabled:opacity-50"
                            disabled="">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <button class="px-3 py-1 rounded border border-gray-300 bg-blue-600 text-white"
                            fdprocessedid="fca0ph">1</button>
                        <button class="px-3 py-1 rounded border border-gray-300 text-gray-600 hover:bg-gray-50"
                            fdprocessedid="jyjmjq">2</button>
                        <button class="px-3 py-1 rounded border border-gray-300 text-gray-600 hover:bg-gray-50"
                            fdprocessedid="c72ys">3</button>
                        <button class="px-3 py-1 rounded border border-gray-300 text-gray-600 hover:bg-gray-50"
                            fdprocessedid="s4g4ob">4</button>
                        <button class="px-3 py-1 rounded border border-gray-300 text-gray-600 hover:bg-gray-50"
                            fdprocessedid="pn6scr">5</button>
                        <button class="px-3 py-1 rounded border border-gray-300 text-gray-600 hover:bg-gray-50"
                            fdprocessedid="skupzxc">
                            <i class="fas fa-chevron-right"></i>
                        </button> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Toggle sidebar on mobile
        document.getElementById('sidebar-toggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('open');
        });

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const sidebarToggle = document.getElementById('sidebar-toggle');

            if (window.innerWidth < 768 &&
                !sidebar.contains(event.target) &&
                !sidebarToggle.contains(event.target) &&
                sidebar.classList.contains('open')) {
                sidebar.classList.remove('open');
            }
        });

        // Toggle profile dropdown
        document.getElementById('profile-menu-button').addEventListener('click', function() {
            document.getElementById('profile-dropdown').classList.toggle('hidden');
        });

        // Close profile dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('profile-dropdown');
            const button = document.getElementById('profile-menu-button');

            if (!dropdown.contains(event.target) &&
                !button.contains(event.target) &&
                !dropdown.classList.contains('hidden')) {
                dropdown.classList.add('hidden');
            }
        });
    </script>
    <script>
        // Ketika tombol hapus diklik
        document.querySelectorAll('.deleteButton').forEach(button => {
            button.addEventListener('click', function() {
                // Ambil ID dari tombol yang diklik
                var id = this.getAttribute('data-id');

                // Tampilkan konfirmasi SweetAlert
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data yang dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    // Jika pengguna mengklik 'Hapus'
                    if (result.isConfirmed) {
                        // Tampilkan loading
                        Swal.fire({
                            title: 'Menghapus...',
                            text: 'Mohon tunggu sebentar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            showConfirmButton: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        // Membuat form untuk mengirimkan request DELETE dengan CSRF token
                        var form = document.createElement('form');
                        form.method = 'POST';
                        form.action = `/operator/hapus/${id}`;
                        form.style.display = 'none';

                        // Membuat elemen input untuk method DELETE
                        var methodInput = document.createElement('input');
                        methodInput.type = 'hidden';
                        methodInput.name = '_method';
                        methodInput.value = 'DELETE';
                        form.appendChild(methodInput);

                        // Membuat elemen input untuk CSRF token
                        var csrfTokenInput = document.createElement('input');
                        csrfTokenInput.type = 'hidden';
                        csrfTokenInput.name = '_token';

                        // Ambil CSRF token dari meta tag
                        var csrfToken = document.querySelector('meta[name="csrf-token"]');
                        if (csrfToken) {
                            csrfTokenInput.value = csrfToken.getAttribute('content');
                        } else {
                            // Fallback: coba ambil dari form yang ada di halaman
                            var existingCsrfInput = document.querySelector('input[name="_token"]');
                            if (existingCsrfInput) {
                                csrfTokenInput.value = existingCsrfInput.value;
                            } else {
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'CSRF token tidak ditemukan. Mohon refresh halaman.',
                                    icon: 'error'
                                });
                                return;
                            }
                        }

                        form.appendChild(csrfTokenInput);

                        // Menambahkan form ke body dan mengirimkannya
                        document.body.appendChild(form);
                        form.submit(); // Kirimkan form
                    }
                });
            });
        });
    </script>
    {{-- <script>(function(){function c(){var b=a.contentDocument||a.contentWindow.document;if(b){var d=b.createElement('script');d.innerHTML="window.__CF$cv$params={r:'94bf8547c5d2d899',t:'MTc0OTI5MjcxNC4wMDAwMDA='};var a=document.createElement('script');a.nonce='';a.src='/cdn-cgi/challenge-platform/scripts/jsd/main.js';document.getElementsByTagName('head')[0].appendChild(a);";b.getElementsByTagName('head')[0].appendChild(d)}}if(document.body){var a=document.createElement('iframe');a.height=1;a.width=1;a.style.position='absolute';a.style.top=0;a.style.left=0;a.style.border='none';a.style.visibility='hidden';document.body.appendChild(a);if('loading'!==document.readyState)c();else if(window.addEventListener)document.addEventListener('DOMContentLoaded',c);else{var e=document.onreadystatechange||function(){};document.onreadystatechange=function(b){e(b);'loading'!==document.readyState&&(document.onreadystatechange=e,c())}}}})();</script><iframe height="1" width="1" style="position: absolute; top: 0px; left: 0px; border: none; visibility: hidden;"></iframe> --}}

    {{-- <span id="PING_IFRAME_FORM_DETECTION" style="display: none;"></span> --}}
</body>

</html>
