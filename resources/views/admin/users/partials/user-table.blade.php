{{-- resources/views/admin/users/partials/user-table.blade.php --}}
@forelse ($users as $user)
    <tr class="hover:bg-gray-50 transition-all duration-300 border-b border-gray-100" data-user-id="{{ $user->id }}">
        {{-- User Info --}}
        <td class="py-4 px-4">
            <div class="flex items-center">
                <div class="flex-shrink-0 h-12 w-12 relative">
                    @if ($user->profile_photo)
                        <img class="h-12 w-12 rounded-full object-cover border-2 border-gray-200 shadow-sm" 
                             src="{{ $user->getProfilePhotoUrlAttributeV4() }}" 
                             alt="{{ $user->name }}">
                    @else
                        <div class="h-12 w-12 rounded-full bg-gradient-to-br from-blue-400 to-purple-500 flex items-center justify-center shadow-sm border-2 border-gray-200">
                            <span class="text-white font-semibold text-sm">
                                {{ strtoupper(substr($user->name, 0, 2)) }}
                            </span>
                        </div>
                    @endif
                    {{-- Online Indicator --}}
                    @if(($user->is_active ?? true))
                        <div class="absolute -bottom-0.5 -right-0.5 h-4 w-4 bg-green-400 rounded-full border-2 border-white shadow-sm"></div>
                    @endif
                </div>
                <div class="ml-4">
                    <div class="text-sm font-semibold text-gray-900">{{ $user->name }}</div>
                    <div class="text-sm text-gray-500 flex items-center">
                        <span class="w-1 h-1 bg-gray-400 rounded-full mr-2"></span>
                        {{ $user->email }}
                    </div>
                    <div class="text-xs text-gray-400 mt-1 flex items-center">
                        <span class="inline-block w-3 h-3 mr-1">
                            <svg viewBox="0 0 24 24" fill="currentColor" class="w-full h-full">
                                <path d="M4 4h16a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2zm8 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zM6 8h2v2H6V8zm10 0h2v2h-2V8zM6 12h2v2H6v-2zm10 0h2v2h-2v-2z"/>
                            </svg>
                        </span>
                        NRP: {{ $user->nrp }}
                    </div>
                </div>
            </div>
        </td>

        {{-- Role & Satuan Kerja --}}
        <td class="py-4 px-4">
            <div class="flex flex-col space-y-2">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium border
                    {{ $user->role === 'admin_bnn' 
                        ? 'bg-purple-50 text-purple-700 border-purple-200' 
                        : 'bg-blue-50 text-blue-700 border-blue-200' }}">
                    <span class="w-2 h-2 rounded-full mr-2
                        {{ $user->role === 'admin_bnn' ? 'bg-purple-400' : 'bg-blue-400' }}"></span>
                    @if ($user->role === 'admin_bnn')
                        <span class="inline-block w-3 h-3 mr-1">
                            <svg viewBox="0 0 24 24" fill="currentColor" class="w-full h-full">
                                <path d="M12 2C13.1 2 14 2.9 14 4C14 5.1 13.1 6 12 6C10.9 6 10 5.1 10 4C10 2.9 10.9 2 12 2ZM21 9V7L15 1H5C3.89 1 3 1.89 3 3V19A2 2 0 0 0 5 21H11V19H5V3H13V9H21ZM17 12V15H22V17H17V20L13 16L17 12Z"/>
                            </svg>
                        </span>
                        Admin BNN
                    @else
                        <span class="inline-block w-3 h-3 mr-1">
                            <svg viewBox="0 0 24 24" fill="currentColor" class="w-full h-full">
                                <path d="M12,1L3,5V11C3,16.55 6.84,21.74 12,23C17.16,21.74 21,16.55 21,11V5L12,1M12,7C13.4,7 14.8,8.6 14.8,10V11.5C15.4,12.1 16,12.8 16,14C16,15.3 14.3,16 12,16C9.7,16 8,15.3 8,14C8,12.8 8.6,12.1 9.2,11.5V10C9.2,8.6 10.6,7 12,7Z"/>
                            </svg>
                        </span>
                        Tim Penyidik
                    @endif
                </span>
                <div class="text-sm text-gray-600 flex items-center">
                    <span class="inline-block w-3 h-3 mr-2">
                        <svg viewBox="0 0 24 24" fill="currentColor" class="w-full h-full text-gray-400">
                            <path d="M12,11.5A2.5,2.5 0 0,1 9.5,9A2.5,2.5 0 0,1 12,6.5A2.5,2.5 0 0,1 14.5,9A2.5,2.5 0 0,1 12,11.5M12,2A7,7 0 0,0 5,9C5,14.25 12,22 12,22C12,22 19,14.25 19,9A7,7 0 0,0 12,2Z"/>
                        </svg>
                    </span>
                    {{ Str::limit($user->satuan_kerja, 25) }}
                </div>
            </div>
        </td>

        {{-- Contact Info --}}
        <td class="py-4 px-4">
            <div class="space-y-2">
                <div class="flex items-center text-sm text-gray-700">
                    <span class="inline-block w-4 h-4 mr-2">
                        <svg viewBox="0 0 24 24" fill="currentColor" class="w-full h-full text-gray-400">
                            <path d="M6.62,10.79C8.06,13.62 10.38,15.94 13.21,17.38L15.41,15.18C15.69,14.9 16.08,14.82 16.43,14.93C17.55,15.3 18.75,15.5 20,15.5A1,1 0 0,1 21,16.5V20A1,1 0 0,1 20,21A17,17 0 0,1 3,4A1,1 0 0,1 4,3H7.5A1,1 0 0,1 8.5,4C8.5,5.25 8.7,6.45 9.07,7.57C9.18,7.92 9.1,8.31 8.82,8.59L6.62,10.79Z"/>
                        </svg>
                    </span>
                    <a href="tel:{{ $user->no_telp }}" class="hover:text-blue-600 transition-colors">
                        {{ $user->no_telp }}
                    </a>
                </div>
                <div class="flex items-center text-sm">
                    <span class="inline-block w-4 h-4 mr-2">
                        <svg viewBox="0 0 24 24" fill="currentColor" class="w-full h-full text-gray-400">
                            <path d="M20,8L12,13L4,8V6L12,11L20,6M20,4H4C2.89,4 2,4.89 2,6V18A2,2 0 0,0 4,20H20A2,2 0 0,0 22,18V6C22,4.89 21.1,4 20,4Z"/>
                        </svg>
                    </span>
                    <a href="mailto:{{ $user->email }}" class="text-blue-600 hover:text-blue-800 transition-colors truncate">
                        {{ Str::limit($user->email, 20) }}
                    </a>
                </div>
            </div>
        </td>

        {{-- Registration Date --}}
        <td class="py-4 px-4">
            <div class="text-center">
                <div class="text-sm font-medium text-gray-900">{{ $user->created_at->format('d M Y') }}</div>
                <div class="text-xs text-gray-500">{{ $user->created_at->format('H:i') }}</div>
                <div class="text-xs text-gray-400 mt-1 px-2 py-1 bg-gray-100 rounded-full inline-block">
                    {{ $user->created_at->diffForHumans() }}
                </div>
            </div>
        </td>

        {{-- Status --}}
        <td class="py-4 px-4">
            <div class="flex flex-col space-y-2">
                {{-- Active Status --}}
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium border
                    {{ ($user->is_active ?? true) 
                        ? 'bg-green-50 text-green-700 border-green-200' 
                        : 'bg-red-50 text-red-700 border-red-200' }}">
                    <span class="w-2 h-2 rounded-full mr-2
                        {{ ($user->is_active ?? true) ? 'bg-green-400' : 'bg-red-400' }}"></span>
                    {{ ($user->is_active ?? true) ? 'Aktif' : 'Nonaktif' }}
                </span>

                {{-- Last Seen Status --}}
                @if(isset($user->last_seen))
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium border
                        {{ $user->last_seen && $user->last_seen->gt(now()->subMinutes(5)) 
                            ? 'bg-emerald-50 text-emerald-700 border-emerald-200' 
                            : 'bg-gray-50 text-gray-600 border-gray-200' }}">
                        <span class="w-2 h-2 rounded-full mr-2 animate-pulse
                            {{ $user->last_seen && $user->last_seen->gt(now()->subMinutes(5)) ? 'bg-emerald-400' : 'bg-gray-400' }}"></span>
                        {{ $user->last_seen && $user->last_seen->gt(now()->subMinutes(5)) ? 'Online' : 'Offline' }}
                    </span>
                @endif
            </div>
        </td>

        {{-- Actions --}}
        <td class="py-4 px-4">
            <div class="flex justify-center space-x-1">
                
                {{-- Reset Password Button --}}
                <button onclick="resetPassword({{ $user->id }}, '{{ addslashes($user->name) }}')"
                        class="group relative p-2 bg-orange-50 text-orange-600 hover:bg-orange-100 
                               rounded-lg transition-all duration-200 hover:scale-105 border border-orange-200"
                        title="Reset Password">
                    <span class="inline-block w-4 h-4">
                        <svg viewBox="0 0 24 24" fill="currentColor" class="w-full h-full">
                            <path d="M7,14A3,3 0 0,0 10,17A3,3 0 0,0 13,14A3,3 0 0,0 10,11A3,3 0 0,0 7,14M12.65,10C11.83,7.67 9.61,6 7,6A6,6 0 0,0 1,12A6,6 0 0,0 7,18C9.61,18 11.83,16.33 12.65,14H17V18H21V14H23V10H12.65Z"/>
                        </svg>
                    </span>
                    <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-2 py-1 
                                bg-gray-800 text-white text-xs rounded opacity-0 group-hover:opacity-100 
                                transition-opacity duration-200 whitespace-nowrap z-10">
                        Reset Password
                    </div>
                </button>

                {{-- Toggle Status Button --}}
                {{-- <button onclick="toggleUserStatus({{ $user->id }})"
                        class="group relative p-2 border transition-all duration-200 hover:scale-105 rounded-lg
                            {{ ($user->is_active ?? true) 
                                ? 'bg-red-50 text-red-600 hover:bg-red-100 border-red-200' 
                                : 'bg-green-50 text-green-600 hover:bg-green-100 border-green-200' }}"
                        title="{{ ($user->is_active ?? true) ? 'Nonaktifkan' : 'Aktifkan' }} Akun">
                    <span class="inline-block w-4 h-4">
                        @if(($user->is_active ?? true))
                            <svg viewBox="0 0 24 24" fill="currentColor" class="w-full h-full">
                                <path d="M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2M12,4A8,8 0 0,1 20,12A8,8 0 0,1 12,20A8,8 0 0,1 4,12A8,8 0 0,1 12,4M12,6A6,6 0 0,0 6,12A6,6 0 0,0 12,18V6Z"/>
                            </svg>
                        @else
                            <svg viewBox="0 0 24 24" fill="currentColor" class="w-full h-full">
                                <path d="M21,7L9,19L3.5,13.5L4.91,12.09L9,16.17L19.59,5.59L21,7Z"/>
                            </svg>
                        @endif
                    </span>
                    <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-2 py-1 
                                bg-gray-800 text-white text-xs rounded opacity-0 group-hover:opacity-100 
                                transition-opacity duration-200 whitespace-nowrap z-10">
                        {{ ($user->is_active ?? true) ? 'Nonaktifkan' : 'Aktifkan' }} Akun
                    </div>
                </button> --}}

                {{-- Delete Button (only if not current user) --}}
                @if ($user->id !== auth()->id())
                    <button onclick="deleteUser({{ $user->id }}, '{{ addslashes($user->name) }}')"
                            class="group relative p-2 bg-red-50 text-red-600 hover:bg-red-100 
                                   rounded-lg transition-all duration-200 hover:scale-105 border border-red-200"
                            title="Hapus Akun">
                        <span class="inline-block w-4 h-4">
                            <svg viewBox="0 0 24 24" fill="currentColor" class="w-full h-full">
                                <path d="M19,4H15.5L14.5,3H9.5L8.5,4H5V6H19M6,19A2,2 0 0,0 8,21H16A2,2 0 0,0 18,19V7H6V19Z"/>
                            </svg>
                        </span>
                        <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-2 py-1 
                                    bg-gray-800 text-white text-xs rounded opacity-0 group-hover:opacity-100 
                                    transition-opacity duration-200 whitespace-nowrap z-10">
                            Hapus Akun
                        </div>
                    </button>
                @else
                    <span class="group relative p-2 bg-gray-100 text-gray-400 rounded-lg cursor-not-allowed border border-gray-200"
                          title="Tidak dapat menghapus akun sendiri">
                        <span class="inline-block w-4 h-4">
                            <svg viewBox="0 0 24 24" fill="currentColor" class="w-full h-full">
                                <path d="M19,4H15.5L14.5,3H9.5L8.5,4H5V6H19M6,19A2,2 0 0,0 8,21H16A2,2 0 0,0 18,19V7H6V19Z"/>
                            </svg>
                        </span>
                    </span>
                @endif

                {{-- More Actions Dropdown --}}
                <div class="relative group">
                    {{-- <button class="p-2 bg-gray-50 text-gray-600 hover:bg-gray-100 rounded-lg 
                                   transition-all duration-200 hover:scale-105 border border-gray-200"
                            title="Menu Lainnya">
                        <span class="inline-block w-4 h-4">
                            <svg viewBox="0 0 24 24" fill="currentColor" class="w-full h-full">
                                <path d="M12,16A2,2 0 0,1 14,18A2,2 0 0,1 12,20A2,2 0 0,1 10,18A2,2 0 0,1 12,16M12,10A2,2 0 0,1 14,12A2,2 0 0,1 12,14A2,2 0 0,1 10,12A2,2 0 0,1 12,10M12,4A2,2 0 0,1 14,6A2,2 0 0,1 12,8A2,2 0 0,1 10,6A2,2 0 0,1 12,4Z"/>
                            </svg>
                        </span>
                    </button> --}}

                    <div class="absolute right-0 top-full mt-2 w-48 bg-white border border-gray-200 
                                rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 
                                group-hover:visible transition-all duration-200 z-20 overflow-hidden">
                        <div class="py-1">
                            <a href="#" onclick="viewUserActivity({{ $user->id }})"
                               class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                <span class="inline-block w-4 h-4 mr-3">
                                    <svg viewBox="0 0 24 24" fill="currentColor" class="w-full h-full text-gray-400">
                                        <path d="M13.5,8H12V13L16.28,15.54L17,14.33L13.5,12.25V8M13,3A9,9 0 0,0 4,12H1L4.96,16.03L9,12H6A7,7 0 0,1 13,5A7,7 0 0,1 20,12A7,7 0 0,1 13,19C11.07,19 9.32,18.21 8.06,16.94L6.64,18.36C8.27,20 10.5,21 13,21A9,9 0 0,0 22,12A9,9 0 0,0 13,3"/>
                                    </svg>
                                </span>
                                Riwayat Aktivitas
                            </a>

                            @if ($user->role === 'operator')
                                <a href="#" onclick="viewUserReports({{ $user->id }})"
                                   class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                    <span class="inline-block w-4 h-4 mr-3">
                                        <svg viewBox="0 0 24 24" fill="currentColor" class="w-full h-full text-gray-400">
                                            <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z"/>
                                        </svg>
                                    </span>
                                    Laporan Pengguna
                                </a>
                            @endif

                            <hr class="my-1 border-gray-200">

                            <a href="#" onclick="sendNotification({{ $user->id }})"
                               class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                <span class="inline-block w-4 h-4 mr-3">
                                    <svg viewBox="0 0 24 24" fill="currentColor" class="w-full h-full text-gray-400">
                                        <path d="M21,19V20H3V19L5,17V11C5,7.9 7.03,5.17 10,4.29C10,4.19 10,4.1 10,4A2,2 0 0,1 12,2A2,2 0 0,1 14,4C14,4.1 14,4.19 14,4.29C16.97,5.17 19,7.9 19,11V17L21,19M14,21A2,2 0 0,1 12,23A2,2 0 0,1 10,21"/>
                                    </svg>
                                </span>
                                Kirim Notifikasi
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="6" class="py-16 text-center">
            <div class="flex flex-col items-center justify-center">
                <div class="w-24 h-24 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center mb-6 shadow-inner">
                    <span class="inline-block w-12 h-12">
                        <svg viewBox="0 0 24 24" fill="currentColor" class="w-full h-full text-gray-400">
                            <path d="M16,4C16.88,4 17.67,4.84 17.67,5.84L17.67,7.84C18.86,8.24 19.77,9.32 19.77,10.61C19.77,11.9 18.86,12.98 17.67,13.38L17.67,15.84C17.67,16.96 16.88,17.84 16,17.84C15.12,17.84 14.33,16.96 14.33,15.84L14.33,13.38C13.14,12.98 12.23,11.9 12.23,10.61C12.23,9.32 13.14,8.24 14.33,7.84L14.33,5.84C14.33,4.84 15.12,4 16,4M8,6C8.88,6 9.67,6.84 9.67,7.84L9.67,9.84C10.86,10.24 11.77,11.32 11.77,12.61C11.77,13.9 10.86,14.98 9.67,15.38L9.67,17.84C9.67,18.96 8.88,19.84 8,19.84C7.12,19.84 6.33,18.96 6.33,17.84L6.33,15.38C5.14,14.98 4.23,13.9 4.23,12.61C4.23,11.32 5.14,10.24 6.33,9.84L6.33,7.84C6.33,6.84 7.12,6 8,6Z"/>
                        </svg>
                    </span>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-3">Tidak ada pengguna ditemukan</h3>
                <p class="text-gray-500 mb-6 max-w-md text-center leading-relaxed">
                    @if (request()->hasAny(['search', 'role', 'satuan_kerja']))
                        Coba ubah filter pencarian Anda atau 
                        <button onclick="document.getElementById('resetFilter').click()"
                                class="text-blue-600 hover:text-blue-800 underline font-medium">
                            reset semua filter
                        </button>
                    @else
                        Belum ada pengguna yang terdaftar dalam sistem. Mulai dengan menambahkan pengguna pertama.
                    @endif
                </p>
                @if (!request()->hasAny(['search', 'role', 'satuan_kerja']))
                    <a href="{{ route('admin.users.create') }}"
                       class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 
                              text-white font-medium rounded-lg hover:from-blue-700 hover:to-blue-800 
                              transition-all duration-200 transform hover:scale-105 shadow-lg">
                        <span class="inline-block w-5 h-5 mr-2">
                            <svg viewBox="0 0 24 24" fill="currentColor" class="w-full h-full">
                                <path d="M19,13H13V19H11V13H5V11H11V5H13V11H19V13Z"/>
                            </svg>
                        </span>
                        Tambah Pengguna Pertama
                    </a>
                @endif
            </div>
        </td>
    </tr>
@endforelse

<script>
    // Additional functions for dropdown actions
    function viewUserActivity(userId) {
        window.open(`/admin/users/${userId}/activity`, '_blank');
    }

    function viewUserReports(userId) {
        window.open(`/admin/users/${userId}/reports`, '_blank');
    }

    function sendNotification(userId) {
        Swal.fire({
            title: 'Kirim Notifikasi',
            input: 'textarea',
            inputPlaceholder: 'Tulis pesan notifikasi...',
            showCancelButton: true,
            confirmButtonText: 'Kirim',
            cancelButtonText: 'Batal',
            customClass: {
                popup: 'rounded-lg',
                title: 'text-lg font-semibold',
                input: 'rounded-lg border-2 border-gray-200 focus:border-blue-500',
                confirmButton: 'bg-blue-600 hover:bg-blue-700 rounded-lg px-6 py-2',
                cancelButton: 'bg-gray-500 hover:bg-gray-600 rounded-lg px-6 py-2'
            },
            inputValidator: (value) => {
                if (!value) {
                    return 'Pesan tidak boleh kosong!'
                }
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading
                Swal.fire({
                    title: 'Mengirim...',
                    text: 'Mohon tunggu sebentar',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                fetch(`/admin/users/${userId}/send-notification`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            message: result.value
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: 'Notifikasi berhasil dikirim',
                                confirmButtonText: 'OK',
                                customClass: {
                                    confirmButton: 'bg-green-600 hover:bg-green-700 rounded-lg px-6 py-2'
                                }
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: data.message,
                                confirmButtonText: 'OK',
                                customClass: {
                                    confirmButton: 'bg-red-600 hover:bg-red-700 rounded-lg px-6 py-2'
                                }
                            });
                        }
                    })
                    .catch(error => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Terjadi kesalahan saat mengirim notifikasi',
                            confirmButtonText: 'OK',
                            customClass: {
                                confirmButton: 'bg-red-600 hover:bg-red-700 rounded-lg px-6 py-2'
                            }
                        });
                    });
            }
        });
    }

    // Enhanced delete user function with better styling
    function deleteUser(userId, userName) {
        Swal.fire({
            title: 'Hapus Akun?',
            html: `Apakah Anda yakin ingin menghapus akun <strong>"${userName}"</strong>?<br><small class="text-gray-500">Tindakan ini tidak dapat dibatalkan.</small>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            customClass: {
                popup: 'rounded-lg',
                title: 'text-lg font-semibold',
                confirmButton: 'rounded-lg px-6 py-2',
                cancelButton: 'rounded-lg px-6 py-2'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading
                Swal.fire({
                    title: 'Menghapus...',
                    text: 'Mohon tunggu sebentar',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                fetch(`/admin/users/${userId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: data.message,
                            confirmButtonText: 'OK',
                            customClass: {
                                confirmButton: 'bg-green-600 hover:bg-green-700 rounded-lg px-6 py-2'
                            }
                        });
                        // Remove row from table with animation
                        const row = document.querySelector(`tr[data-user-id="${userId}"]`);
                        if (row) {
                            row.style.transition = 'all 0.3s ease';
                            row.style.opacity = '0';
                            row.style.transform = 'translateX(-20px)';
                            setTimeout(() => {
                                row.remove();
                            }, 300);
                        }
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: data.message,
                            confirmButtonText: 'OK',
                            customClass: {
                                confirmButton: 'bg-red-600 hover:bg-red-700 rounded-lg px-6 py-2'
                            }
                        });
                    }
                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Terjadi kesalahan saat menghapus akun',
                        confirmButtonText: 'OK',
                        customClass: {
                            confirmButton: 'bg-red-600 hover:bg-red-700 rounded-lg px-6 py-2'
                        }
                    });
                });
            }
        });
    }

    // Enhanced reset password function
    function resetPassword(userId, userName) {
        Swal.fire({
            title: 'Reset Password?',
            html: `Reset password untuk akun <strong>"${userName}"</strong>?<br><small class="text-gray-500">Password akan direset ke default.</small>`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#f59e0b',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Reset!',
            cancelButtonText: 'Batal',
            customClass: {
                popup: 'rounded-lg',
                title: 'text-lg font-semibold',
                confirmButton: 'rounded-lg px-6 py-2',
                cancelButton: 'rounded-lg px-6 py-2'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading
                Swal.fire({
                    title: 'Mereset Password...',
                    text: 'Mohon tunggu sebentar',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                fetch(`/admin/users/${userId}/reset-password`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Password Berhasil Direset!',
                            html: `<div class="text-center">
                                <p class="mb-3">Password baru:</p>
                                <div class="bg-gray-100 p-3 rounded-lg font-mono text-lg font-bold text-blue-600">
                                    ${data.new_password}
                                </div>
                                <p class="text-sm text-gray-500 mt-3">Harap catat password ini dan sampaikan kepada pengguna</p>
                            </div>`,
                            confirmButtonText: 'OK',
                            customClass: {
                                popup: 'rounded-lg',
                                confirmButton: 'bg-green-600 hover:bg-green-700 rounded-lg px-6 py-2'
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: data.message,
                            confirmButtonText: 'OK',
                            customClass: {
                                confirmButton: 'bg-red-600 hover:bg-red-700 rounded-lg px-6 py-2'
                            }
                        });
                    }
                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Terjadi kesalahan saat reset password',
                        confirmButtonText: 'OK',
                        customClass: {
                            confirmButton: 'bg-red-600 hover:bg-red-700 rounded-lg px-6 py-2'
                        }
                    });
                });
            }
        });
    }

    // Enhanced toggle user status function
    function toggleUserStatus(userId) {
        const userRow = document.querySelector(`tr[data-user-id="${userId}"]`);
        const statusBadge = userRow.querySelector('.inline-flex.items-center.px-3.py-1.rounded-full');
        const isActive = statusBadge.classList.contains('bg-green-50');
        const action = isActive ? 'menonaktifkan' : 'mengaktifkan';
        
        Swal.fire({
            title: `${action.charAt(0).toUpperCase() + action.slice(1)} Akun?`,
            html: `Apakah Anda yakin ingin <strong>${action}</strong> akun ini?<br><small class="text-gray-500">Status akun akan berubah.</small>`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: isActive ? '#ef4444' : '#10b981',
            cancelButtonColor: '#6b7280',
            confirmButtonText: `Ya, ${action.charAt(0).toUpperCase() + action.slice(1)}!`,
            cancelButtonText: 'Batal',
            customClass: {
                popup: 'rounded-lg',
                title: 'text-lg font-semibold',
                confirmButton: 'rounded-lg px-6 py-2',
                cancelButton: 'rounded-lg px-6 py-2'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading
                Swal.fire({
                    title: `${action.charAt(0).toUpperCase() + action.slice(1)}...`,
                    text: 'Mohon tunggu sebentar',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

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
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: data.message,
                            confirmButtonText: 'OK',
                            customClass: {
                                confirmButton: 'bg-green-600 hover:bg-green-700 rounded-lg px-6 py-2'
                            }
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: data.message,
                            confirmButtonText: 'OK',
                            customClass: {
                                confirmButton: 'bg-red-600 hover:bg-red-700 rounded-lg px-6 py-2'
                            }
                        });
                    }
                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Terjadi kesalahan saat mengubah status',
                        confirmButtonText: 'OK',
                        customClass: {
                            confirmButton: 'bg-red-600 hover:bg-red-700 rounded-lg px-6 py-2'
                        }
                    });
                });
            }
        });
    }
</script>

<style>
/* Additional CSS for enhanced animations */
.group:hover .group-hover\:opacity-100 {
    opacity: 1;
}

.group:hover .group-hover\:visible {
    visibility: visible;
}

/* Smooth transitions for all interactive elements */
button, a {
    transition: all 0.2s ease-in-out;
}

/* Enhanced tooltip positioning */
.group .absolute {
    z-index: 50;
}

/* Hover effects for table rows */
tr:hover {
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
}

/* Animation for status indicators */
@keyframes pulse {
    0%, 100% {
        opacity: 1;
    }
    50% {
        opacity: 0.5;
    }
}

.animate-pulse {
    animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}

/* Gradient backgrounds for avatars */
.bg-gradient-to-br {
    background-image: linear-gradient(to bottom right, var(--tw-gradient-stops));
}

/* Shadow enhancements */
.shadow-sm {
    box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
}

.shadow-lg {
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
}

/* Custom scrollbar for dropdown */
.overflow-hidden::-webkit-scrollbar {
    width: 4px;
}

.overflow-hidden::-webkit-scrollbar-track {
    background: #f1f1f1;
}

.overflow-hidden::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 2px;
}

.overflow-hidden::-webkit-scrollbar-thumb:hover {
    background: #a1a1a1;
}
</style>