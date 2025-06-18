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
    {{-- <div id="sidebar"
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
                    <a href="#" class="sidebar-item {{ request()->routeIs('operator.dashboard') ? 'sidebar-active' : '' }} flex items-center px-4 py-3 rounded-lg">
                        <i class="fas fa-tachometer-alt w-5 mr-3"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="sidebar-item  flex items-center  px-4 py-3 rounded-lg ">
                        <i class="fas fa-file-alt w-5 mr-3"></i>
                        <span>Buat Laporan</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="sidebar-item flex items-center px-4 py-3 rounded-lg ">
                        <i class="fas fa-clipboard-check w-5 mr-3"></i>
                        <span>Laporan Disetujui</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="sidebar-item flex items-center px-4 py-3 rounded-lg ">
                        <i class="fas fa-clock  w-5 mr-3"></i>
                        <span>Laporan Menunggu</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="sidebar-item flex items-center px-4 py-3 rounded-lg ">
                         <i class="fas fa-times-circle  w-5 mr-3"></i>
                        <span>Laporan Ditolak</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="sidebar-item flex items-center px-4 py-3 rounded-lg ">
                        <i class="fas fa-cog w-5 mr-3"></i>
                        <span>Pengaturan</span>
                    </a>
                </li>
            </ul>
        </div>
    </div> --}}

    @yield('content')
    <!-- Main Content -->

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

</body>

</html>
