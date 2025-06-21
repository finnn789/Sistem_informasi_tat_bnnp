{{-- resources/views/admin/users/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Manajemen Akun Pengguna')


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<style>
    .stats-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 12px;
        padding: 1.5rem;
        color: white;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .stats-card:hover {
        transform: translateY(-5px);
    }

    .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
    }

    .role-badge {
        font-size: 0.75rem;
        font-weight: 600;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .table-hover tbody tr:hover {
        background-color: #f8fafc;
        transform: translateX(4px);
        transition: all 0.3s ease;
    }
</style>


@section('content')
    <div class="min-h-screen bg-gray-50 py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Header Section --}}
            <div class="mb-8">
                <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-blue-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">Manajemen Akun Pengguna</h1>
                            <p class="text-gray-600 mt-1">Kelola semua akun pengguna sistem</p>
                        </div>
                        <div class="flex space-x-3">
                            {{-- <a href="{{ route('admin.users.create') }}"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium 
                                  rounded-md hover:bg-blue-700 transition-colors duration-150 shadow-sm">
                                <i class="fas fa-plus mr-2"></i>
                                Tambah Akun Baru
                            </a> --}}

                            <a href="{{ route('admin.users.create') }}"
                                class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-medium 
                                       rounded-md hover:bg-green-700 transition-colors duration-150 shadow-sm">
                                <button>
                                    <i class="fas fa-plus mr-2"></i>

                                    Tambah User Baru
                                </button>   
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Statistics Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="stats-card">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-white bg-opacity-20">
                            <i class="fas fa-users text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium opacity-90">Total Pengguna</p>
                            <p class="text-2xl font-semibold" id="stat-total">{{ $stats['total_users'] }}</p>
                        </div>
                    </div>
                </div>

                <div class="stats-card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-white bg-opacity-20">
                            <i class="fas fa-user-shield text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium opacity-90">Tim Penyidik</p>
                            <p class="text-2xl font-semibold" id="stat-operators">{{ $stats['total_operators'] }}</p>
                        </div>
                    </div>
                </div>

                <div class="stats-card" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-white bg-opacity-20">
                            <i class="fas fa-user-cog text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium opacity-90">Admin BNN</p>
                            <p class="text-2xl font-semibold" id="stat-admins">{{ $stats['total_admins'] }}</p>
                        </div>
                    </div>
                </div>

                <div class="stats-card" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-white bg-opacity-20">
                            <i class="fas fa-user-plus text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium opacity-90">Baru (30 Hari)</p>
                            <p class="text-2xl font-semibold" id="stat-recent">{{ $stats['recent_registrations'] }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Filter Section --}}
            {{-- <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="md:col-span-2">
                        <div class="relative">
                            <input type="text" id="searchInput" placeholder="Cari nama, email, NRP, atau satuan kerja..."
                                class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                value="{{ request('search') }}">
                            <div class="absolute left-3 top-2.5 text-gray-400">
                                <i class="fas fa-search"></i>
                            </div>
                        </div>
                    </div>

                    <div>
                        <select id="roleFilter"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Semua Role</option>
                            <option value="operator" {{ request('role') == 'operator' ? 'selected' : '' }}>Tim Penyidik
                            </option>
                            <option value="admin_bnn" {{ request('role') == 'admin_bnn' ? 'selected' : '' }}>Admin BNN
                            </option>
                        </select>
                    </div>

                    <div>
                        <select id="satuanKerjaFilter"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Semua Satuan Kerja</option>
                            @foreach ($satuanKerjaOptions as $satker)
                                <option value="{{ $satker }}"
                                    {{ request('satuan_kerja') == $satker ? 'selected' : '' }}>
                                    {{ $satker }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div> --}}

            {{-- <div class="flex justify-between items-center mt-4">
                    <div class="flex space-x-2">
                        <button id="resetFilter"
                            class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors duration-200">
                            <i class="fas fa-undo mr-1"></i>
                            Reset
                        </button>
                    </div>

                    <div class="text-sm text-gray-600">
                        Menampilkan {{ $users->firstItem() ?? 0 }} - {{ $users->lastItem() ?? 0 }} dari
                        {{ $users->total() }} pengguna
                    </div>
                </div>
            </div> --}}

            {{-- Loading Indicator --}}
            {{-- <div id="loadingIndicator" class="hidden text-center py-4">
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
            </div> --}}

            {{-- Users Table --}}
            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full table-hover">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <button onclick="sortTable('name')" class="flex items-center hover:text-gray-700">
                                        Pengguna
                                        <i class="fas fa-sort ml-1"></i>
                                    </button>
                                </th>
                                <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <button onclick="sortTable('role')" class="flex items-center hover:text-gray-700">
                                        Role & Satuan Kerja
                                        <i class="fas fa-sort ml-1"></i>
                                    </button>
                                </th>
                                <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Kontak
                                </th>
                                <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <button onclick="sortTable('created_at')" class="flex items-center hover:text-gray-700">
                                        Terdaftar
                                        <i class="fas fa-sort ml-1"></i>
                                    </button>
                                </th>
                                <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th
                                    class="py-3 px-4 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody id="usersTableBody" class="bg-white divide-y divide-gray-200">
                            @include('admin.users.partials.user-table', ['users' => $users])
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if ($users->hasPages())
                    <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                        {{ $users->appends(request()->query())->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Modals --}}
    {{-- @include('admin.users.modals.reset-password')
    @include('admin.users.modals.delete-user') --}}

@endsection


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function exportUsers() {
        window.location.href = {{ route('admin.users.create') }};
    }
    document.addEventListener('DOMContentLoaded', function() {
        // Filter functionality
        const searchInput = document.getElementById('searchInput');
        const roleFilter = document.getElementById('roleFilter');
        const satuanKerjaFilter = document.getElementById('satuanKerjaFilter');
        const resetButton = document.getElementById('resetFilter');

        let searchTimeout;

        function performFilter() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                const params = new URLSearchParams();

                if (searchInput.value) params.set('search', searchInput.value);
                if (roleFilter.value) params.set('role', roleFilter.value);
                if (satuanKerjaFilter.value) params.set('satuan_kerja', satuanKerjaFilter.value);

                const url = `${window.location.pathname}?${params.toString()}`;

                fetch(url, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('usersTableBody').innerHTML = data.html;

                        // Update stats
                        if (data.stats) {
                            document.getElementById('stat-total').textContent = data.stats
                                .total_users;
                            document.getElementById('stat-operators').textContent = data.stats
                                .total_operators;
                            document.getElementById('stat-admins').textContent = data.stats
                                .total_admins;
                            document.getElementById('stat-recent').textContent = data.stats
                                .recent_registrations;
                        }

                        // Update URL without reload
                        window.history.replaceState({}, '', url);
                    })
                    .catch(error => {
                        console.error('Filter error:', error);
                        Swal.fire('Error', 'Terjadi kesalahan saat memfilter data', 'error');
                    });
            }, 500);
        }

        searchInput.addEventListener('input', performFilter);
        roleFilter.addEventListener('change', performFilter);
        satuanKerjaFilter.addEventListener('change', performFilter);

        resetButton.addEventListener('click', function() {
            searchInput.value = '';
            roleFilter.value = '';
            satuanKerjaFilter.value = '';
            window.location.href = window.location.pathname;
        });
    });

    // Delete user function
    function deleteUser(userId, userName) {
        Swal.fire({
            title: 'Hapus Akun?',
            text: `Apakah Anda yakin ingin menghapus akun "${userName}"? Tindakan ini tidak dapat dibatalkan.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`/admin/users/${userId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content'),
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        // console.log(data);
                        if (data.success) {
                            Swal.fire('Berhasil!', data.message, 'success');
                            // Remove row from table
                            document.querySelector(`tr[data-user-id="${userId}"]`).remove();
                            // Refresh page or update stats
                            location.reload();
                        } else {
                            Swal.fire('Error!', data.message, 'error');
                        }
                    })
                    .catch(error => {
                        Swal.fire('Error!', 'Terjadi kesalahan saat menghapus akun', error);
                    });
            }
        });
    }

    // Toggle user status
    function toggleUserStatus(userId) {
        fetch(`/admin/users/${userId}/toggle-status`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire('Berhasil!', data.message, 'success');
                    location.reload();
                } else {
                    Swal.fire('Error!', data.message, 'error');
                }
            })
            .catch(error => {
                Swal.fire('Error!', 'Terjadi kesalahan saat mengubah status', 'error');
            });
    }

    // Reset password
    function resetPassword(userId, userName) {
        Swal.fire({
            title: 'Reset Password?',
            text: `Reset password untuk akun "${userName}"?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3b82f6',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Reset!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`/admin/users/${userId}/reset-password`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content'),
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                title: 'Password Berhasil Direset!',
                                html: `Password baru: <strong>${data.new_password}</strong><br><small>Harap catat password ini dan sampaikan kepada pengguna</small>`,
                                icon: 'success',
                                confirmButtonText: 'OK'
                            });
                        } else {
                            Swal.fire('Error!', data.message, 'error');
                        }
                    })
                    .catch(error => {
                        Swal.fire('Error!', 'Terjadi kesalahan saat reset password', 'error');
                    });
            }
        });
    }

    // Export users


    // Sort table
    function sortTable(column) {
        const url = new URL(window.location);
        const currentSort = url.searchParams.get('sort_by');
        const currentOrder = url.searchParams.get('sort_order');

        let newOrder = 'asc';
        if (currentSort === column && currentOrder === 'asc') {
            newOrder = 'desc';
        }

        url.searchParams.set('sort_by', column);
        url.searchParams.set('sort_order', newOrder);

        window.location.href = url.toString();
    }
</script>
