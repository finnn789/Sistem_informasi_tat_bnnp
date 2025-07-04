<!-- Main Content -->

@extends('layouts.operator')

@section('title', 'Dashboard Operator')
@section('content')
    <div class=" pt-16 min-h-screen">
        <div class="container mx-auto px-4 py-6">
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">Dashboard Operator </h1>
                        <p class="text-gray-600">Manajemen Laporan Tim Assesment Terpadu</p>
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
                            <input type="text" id="searchInput"
                                placeholder="Cari laporan (nomor surat, nama tersangka)..."
                                class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                value="{{ request('search') }}">
                            <div class="absolute left-3 top-2.5 text-gray-400">
                                <i class="fas fa-search"></i>
                            </div>
                        </div>
                    </div>

                    <div class="flex gap-2">
                        <select id="statusFilter"
                            class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Semua Status</option>
                            <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>Menunggu
                            </option>
                            <option value="diterima" {{ request('status') == 'diterima' ? 'selected' : '' }}>Diterima
                            </option>
                            <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                            <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Diproses
                            </option>
                        </select>

                        <select id="dateFilter"
                            class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Semua Tanggal</option>
                            <option value="today" {{ request('date_filter') == 'today' ? 'selected' : '' }}>Hari Ini
                            </option>
                            <option value="week" {{ request('date_filter') == 'week' ? 'selected' : '' }}>Minggu Ini
                            </option>
                            <option value="month" {{ request('date_filter') == 'month' ? 'selected' : '' }}>Bulan Ini
                            </option>
                            <option value="year" {{ request('date_filter') == 'year' ? 'selected' : '' }}>Tahun Ini
                            </option>
                        </select>

                        <button id="resetFilter"
                            class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors duration-200">
                            <i class="fas fa-undo mr-1"></i>
                            Reset
                        </button>
                    </div>
                </div>

                {{-- Loading Indicator --}}
                <div id="loadingIndicator" class="hidden text-center py-4">
                    <div class="inline-flex items-center">
                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-blue-500" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        Memuat data...
                    </div>
                </div>

                <!-- Daftar Laporan -->
                <div class="overflow-x-auto bg-white rounded-lg shadow">
                    <table class="min-w-full table-hover">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-200">
                                <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    No</th>
                                <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Surat Permohonan TAT</th>
                                
                                <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Tanggal Pengajuan</th>
                                <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status</th>
                                <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="laporanTableBody" class="divide-y divide-gray-200">
                            @forelse ($laporanTAT as $laporan)
                                <tr class="laporan-row"
                                    data-search="{{ strtolower($laporan->nomor_surat_permohonan_tat . ' ' . $laporan->tersangka->pluck('nama')->implode(' ')) }}">
                                    <!-- Menampilkan Nomor Urut -->
                                    <td class="py-3 px-4 whitespace-nowrap text-sm text-gray-700">
                                        {{ $loop->iteration }}</td>

                                    <!-- Menampilkan Surat Permohonan TAT -->
                                    <td class="py-3 px-4 whitespace-nowrap text-sm text-gray-700">
                                        {{ $laporan->nomor_surat_permohonan_tat }}</td>

                                    <!-- Menampilkan Nama Tersangka -->
                                    

                                    <!-- Menampilkan Tanggal Pengajuan -->
                                    <td class="py-3 px-4 whitespace-nowrap text-sm text-gray-700">
                                        {{ $laporan->created_at->format('d M Y') }}</td>

                                    <!-- Menampilkan Status dengan Warna Dinamis -->
                                    <td class="py-3 px-4 whitespace-nowrap">
                                        <span
                                            class="status-badge 
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
                                                <a href="{{ route('operator.laporan.preview', $laporan->id) }}"
                                                    class="group relative inline-flex items-center justify-center px-4 py-2 
                                           bg-white border border-green-300 text-green-700 text-sm font-medium 
                                           rounded-md hover:bg-green-50 hover:border-green-400 hover:text-green-800 
                                           transition-all duration-150 ease-in-out shadow-sm hover:shadow">
                                                    <i class="fas fa-eye mr-1.5 text-xs"></i>
                                                    Lihat
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
                                                </a>

                                                <button data-id="{{ $laporan->id }}"
                                                    class="deleteButton group relative inline-flex items-center justify-center px-4 py-2 
                                               bg-white border border-red-300 text-red-700 text-sm font-medium 
                                               rounded-md hover:bg-red-50 hover:border-red-400 hover:text-red-800 
                                               transition-all duration-150 ease-in-out shadow-sm hover:shadow">
                                                    <i class="fas fa-trash mr-1.5 text-xs"></i>
                                                    Hapus
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr id="noDataRow">
                                    <td colspan="6" class="py-8 text-center text-gray-500">
                                        <div class="flex flex-col items-center">
                                            <i class="fas fa-search text-4xl text-gray-300 mb-4"></i>
                                            <p class="text-lg font-medium">Tidak ada laporan ditemukan</p>
                                            <p class="text-sm">Coba ubah filter pencarian Anda</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
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
    <script src="{{ asset('js/searchFilterOperator.js') }}" ></script>

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
@endsection
