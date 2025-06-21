{{-- resources/views/admin/users/show.blade.php --}}
@extends('layouts.admin')

@section('title', 'Detail Pengguna - ' . $user->name)

@push('styles')
<style>
    .profile-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 20px;
        padding: 2rem;
        color: white;
        position: relative;
        overflow: hidden;
    }
    
    .profile-header::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 200px;
        height: 200px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        transform: translate(50px, -50px);
    }
    
    .profile-avatar {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    }
    
    .info-card {
        background: white;
        border-radius: 16px;
        padding: 1.5rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        border-left: 4px solid #3b82f6;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .info-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    }
    
    .stat-card {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        text-align: center;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }
    
    .stat-card:hover {
        transform: translateY(-3px);
    }
    
    .badge {
        display: inline-flex;
        align-items: center;
        padding: 0.5rem 1rem;
        border-radius: 9999px;
        font-size: 0.875rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    
    .activity-item {
        display: flex;
        align-items: start;
        padding: 1rem;
        border-left: 3px solid #e5e7eb;
        margin-left: 1rem;
        position: relative;
    }
    
    .activity-item::before {
        content: '';
        position: absolute;
        left: -6px;
        top: 1.5rem;
        width: 12px;
        height: 12px;
        background: #3b82f6;
        border-radius: 50%;
        border: 2px solid white;
    }
    
    .activity-item:hover {
        background: #f8fafc;
        border-left-color: #3b82f6;
    }
</style>
@endpush

@section('content')
<div class="min-h-screen bg-gray-50 py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Header Actions --}}
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Detail Pengguna</h1>
                <p class="text-gray-600">Informasi lengkap pengguna sistem</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.users.edit', $user) }}" 
                   class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium 
                          rounded-md hover:bg-blue-700 transition-colors duration-150 shadow-sm">
                    <i class="fas fa-edit mr-2"></i>
                    Edit Pengguna
                </a>
                <a href="{{ route('admin.users.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-gray-500 text-white text-sm font-medium 
                          rounded-md hover:bg-gray-600 transition-colors duration-150 shadow-sm">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali
                </a>
            </div>
        </div>

        {{-- Profile Header --}}
        <div class="profile-header mb-8">
            <div class="relative z-10">
                <div class="flex flex-col md:flex-row items-start md:items-center space-y-4 md:space-y-0 md:space-x-6">
                    <div class="flex-shrink-0">
                        @if($user->profile_photo)
                            <img src="{{ $user->getProfilePhotoUrlAttributeV4() }}" 
                                 alt="{{ $user->name }}" 
                                 class="profile-avatar">
                        @else
                            <div class="profile-avatar bg-white bg-opacity-20 flex items-center justify-center">
                                <span class="text-3xl font-bold">
                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                </span>
                            </div>
                        @endif
                    </div>
                    
                    <div class="flex-grow">
                        <h2 class="text-3xl font-bold mb-2">{{ $user->name }}</h2>
                        <p class="text-xl opacity-90 mb-1">{{ $user->email }}</p>
                        <p class="opacity-75 mb-3">{{ $user->satuan_kerja }}</p>
                        
                        <div class="flex flex-wrap items-center gap-3">
                            <span class="badge {{ $user->role === 'admin_bnn' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                                @if($user->role === 'admin_bnn')
                                    <i class="fas fa-user-cog mr-2"></i>
                                    Admin BNN
                                @else
                                    <i class="fas fa-user-shield mr-2"></i>
                                    Tim Penyidik
                                @endif
                            </span>
                            
                            <span class="badge {{ ($user->is_active ?? true) ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                <span class="w-2 h-2 rounded-full mr-2 {{ ($user->is_active ?? true) ? 'bg-green-500' : 'bg-red-500' }}"></span>
                                {{ ($user->is_active ?? true) ? 'Aktif' : 'Nonaktif' }}
                            </span>
                            
                            <span class="badge bg-white bg-opacity-20 text-white">
                                <i class="fas fa-calendar-alt mr-2"></i>
                                Bergabung {{ $user->created_at->diffForHumans() }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            {{-- Main Content --}}
            <div class="lg:col-span-2 space-y-6">
                
                {{-- Personal Information --}}
                <div class="info-card">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-user mr-3 text-blue-500"></i>
                        Informasi Personal
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">Nama Lengkap</label>
                            <p class="text-gray-900 font-medium">{{ $user->name }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">NRP</label>
                            <p class="text-gray-900 font-mono">{{ $user->nrp }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">Email</label>
                            <p class="text-gray-900">
                                <a href="mailto:{{ $user->email }}" class="text-blue-600 hover:text-blue-800">
                                    {{ $user->email }}
                                </a>
                            </p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">Nomor Telepon</label>
                            <p class="text-gray-900">
                                <a href="tel:{{ $user->no_telp }}" class="text-blue-600 hover:text-blue-800">
                                    {{ $user->no_telp }}
                                </a>
                            </p>
                        </div>
                        
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-600 mb-1">Satuan Kerja</label>
                            <p class="text-gray-900">{{ $user->satuan_kerja }}</p>
                        </div>
                    </div>
                </div>

                {{-- Account Information --}}
                <div class="info-card">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-cog mr-3 text-blue-500"></i>
                        Informasi Akun
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">User ID</label>
                            <p class="text-gray-900 font-mono">#{{ $user->id }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">Role</label>
                            <p class="text-gray-900">
                                {{ $user->role === 'admin_bnn' ? 'Admin Tim Assessment Terpadu' : 'Tim Penyidik (Operator)' }}
                            </p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">Tanggal Bergabung</label>
                            <p class="text-gray-900">{{ $user->created_at->format('d F Y, H:i') }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">Terakhir Update</label>
                            <p class="text-gray-900">
                                @if($user->updated_at)
                                    {{ $user->updated_at->format('d F Y, H:i') }}
                                @else
                                    Belum pernah update
                                @endif
                            </p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">Status Akun</label>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                         {{ ($user->is_active ?? true) ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                <span class="w-2 h-2 rounded-full mr-2 {{ ($user->is_active ?? true) ? 'bg-green-500' : 'bg-red-500' }}"></span>
                                {{ ($user->is_active ?? true) ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">Nama Lengkap dengan NRP</label>
                            <p class="text-gray-900">{{ $user->getFullNameAttribute() }}</p>
                        </div>
                    </div>
                </div>

                {{-- Recent Activity (if you have activity logs) --}}
                <div class="info-card">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-history mr-3 text-blue-500"></i>
                        Aktivitas Terbaru
                    </h3>
                    
                    <div class="space-y-4">
                        {{-- Sample activities - replace with real data --}}
                        <div class="activity-item">
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-900">Akun dibuat</p>
                                <p class="text-xs text-gray-500">{{ $user->created_at->format('d F Y, H:i') }}</p>
                            </div>
                        </div>
                        
                        @if($user->updated_at && $user->updated_at != $user->created_at)
                            <div class="activity-item">
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-900">Profil diperbarui</p>
                                    <p class="text-xs text-gray-500">{{ $user->updated_at->format('d F Y, H:i') }}</p>
                                </div>
                            </div>
                        @endif
                        
                        {{-- Add more activities based on your system logs --}}
                        <div class="text-center py-4">
                            <p class="text-sm text-gray-500">Riwayat aktivitas lengkap akan ditampilkan di sini</p>
                            <button class="mt-2 text-blue-600 hover:text-blue-800 text-sm font-medium">
                                Lihat Semua Aktivitas
                            </button>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Sidebar --}}
            <div class="space-y-6">
                
                {{-- Statistics Cards --}}
                <div class="grid grid-cols-1 gap-4">
                    
                    {{-- Total Reports (if user is operator) --}}
                    @if($user->role === 'operator')
                        <div class="stat-card">
                            <div class="flex items-center justify-center w-12 h-12 bg-blue-100 rounded-lg mx-auto mb-3">
                                <i class="fas fa-file-alt text-2xl text-blue-600"></i>
                            </div>
                            <div class="text-2xl font-bold text-gray-900">{{ $userStats['total_reports'] ?? 0 }}</div>
                            <div class="text-sm text-gray-600">Total Laporan</div>
                        </div>
                        
                        <div class="stat-card">
                            <div class="flex items-center justify-center w-12 h-12 bg-yellow-100 rounded-lg mx-auto mb-3">
                                <i class="fas fa-clock text-2xl text-yellow-600"></i>
                            </div>
                            <div class="text-2xl font-bold text-gray-900">{{ $userStats['pending_reports'] ?? 0 }}</div>
                            <div class="text-sm text-gray-600">Menunggu Review</div>
                        </div>
                        
                        <div class="stat-card">
                            <div class="flex items-center justify-center w-12 h-12 bg-green-100 rounded-lg mx-auto mb-3">
                                <i class="fas fa-check-circle text-2xl text-green-600"></i>
                            </div>
                            <div class="text-2xl font-bold text-gray-900">{{ $userStats['approved_reports'] ?? 0 }}</div>
                            <div class="text-sm text-gray-600">Disetujui</div>
                        </div>
                        
                        <div class="stat-card">
                            <div class="flex items-center justify-center w-12 h-12 bg-red-100 rounded-lg mx-auto mb-3">
                                <i class="fas fa-times-circle text-2xl text-red-600"></i>
                            </div>
                            <div class="text-2xl font-bold text-gray-900">{{ $userStats['rejected_reports'] ?? 0 }}</div>
                            <div class="text-sm text-gray-600">Ditolak</div>
                        </div>
                    @endif
                </div>

                {{-- Quick Actions --}}
                <div class="info-card">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Aksi Cepat</h3>
                    
                    <div class="space-y-3">
                        <a href="{{ route('admin.users.edit', $user) }}" 
                           class="w-full inline-flex items-center justify-center px-4 py-2 bg-blue-600 text-white 
                                  text-sm font-medium rounded-md hover:bg-blue-700 transition-colors duration-150">
                            <i class="fas fa-edit mr-2"></i>
                            Edit Pengguna
                        </a>
                        
                        <button onclick="resetPassword({{ $user->id }}, '{{ addslashes($user->name) }}')"
                                class="w-full inline-flex items-center justify-center px-4 py-2 bg-orange-600 text-white 
                                       text-sm font-medium rounded-md hover:bg-orange-700 transition-colors duration-150">
                            <i class="fas fa-key mr-2"></i>
                            Reset Password
                        </button>
                        
                        <button onclick="toggleUserStatus({{ $user->id }})"
                                class="w-full inline-flex items-center justify-center px-4 py-2 
                                       {{ ($user->is_active ?? true) ? 'bg-red-600 hover:bg-red-700' : 'bg-green-600 hover:bg-green-700' }} 
                                       text-white text-sm font-medium rounded-md transition-colors duration-150">
                            <i class="fas {{ ($user->is_active ?? true) ? 'fa-ban' : 'fa-check' }} mr-2"></i>
                            {{ ($user->is_active ?? true) ? 'Nonaktifkan' : 'Aktifkan' }} Akun
                        </button>
                        
                        <button onclick="sendNotification({{ $user->id }})"
                                class="w-full inline-flex items-center justify-center px-4 py-2 bg-purple-600 text-white 
                                       text-sm font-medium rounded-md hover:bg-purple-700 transition-colors duration-150">
                            <i class="fas fa-bell mr-2"></i>
                            Kirim Notifikasi
                        </button>
                        
                        @if($user->role === 'operator')
                            <a href="#" onclick="viewUserReports({{ $user->id }})"
                               class="w-full inline-flex items-center justify-center px-4 py-2 bg-indigo-600 text-white 
                                      text-sm font-medium rounded-md hover:bg-indigo-700 transition-colors duration-150">
                                <i class="fas fa-file-alt mr-2"></i>
                                Lihat Laporan
                            </a>
                        @endif
                        
                        @if($user->id !== auth()->id())
                            <button onclick="deleteUser({{ $user->id }}, '{{ addslashes($user->name) }}')"
                                    class="w-full inline-flex items-center justify-center px-4 py-2 bg-red-600 text-white 
                                           text-sm font-medium rounded-md hover:bg-red-700 transition-colors duration-150">
                                <i class="fas fa-trash mr-2"></i>
                                Hapus Akun
                            </button>
                        @endif
                    </div>
                </div>

                {{-- Contact Information --}}
                <div class="info-card">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Kontak</h3>
                    
                    <div class="space-y-3">
                        <div class="flex items-center">
                            <i class="fas fa-envelope text-gray-400 mr-3"></i>
                            <a href="mailto:{{ $user->email }}" class="text-blue-600 hover:text-blue-800 text-sm">
                                {{ $user->email }}
                            </a>
                        </div>
                        
                        <div class="flex items-center">
                            <i class="fas fa-phone text-gray-400 mr-3"></i>
                            <a href="tel:{{ $user->no_telp }}" class="text-blue-600 hover:text-blue-800 text-sm">
                                {{ $user->no_telp }}
                            </a>
                        </div>
                        
                        <div class="flex items-center">
                            <i class="fas fa-building text-gray-400 mr-3"></i>
                            <span class="text-gray-700 text-sm">{{ $user->satuan_kerja }}</span>
                        </div>
                        
                        <div class="flex items-center">
                            <i class="fas fa-id-card text-gray-400 mr-3"></i>
                            <span class="text-gray-700 text-sm">NRP: {{ $user->nrp }}</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// Reset password function
function resetPassword(userId, userName) {
    Swal.fire({
        title: 'Reset Password?',
        text: `Reset password untuk akun "${userName}"?`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#f59e0b',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Ya, Reset!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
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

// Toggle user status
function toggleUserStatus(userId) {
    const isActive = {{ ($user->is_active ?? true) ? 'true' : 'false' }};
    const action = isActive ? 'menonaktifkan' : 'mengaktifkan';
    
    Swal.fire({
        title: `${action.charAt(0).toUpperCase() + action.slice(1)} Akun?`,
        text: `Apakah Anda yakin ingin ${action} akun ini?`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: isActive ? '#ef4444' : '#10b981',
        cancelButtonColor: '#6b7280',
        confirmButtonText: `Ya, ${action.charAt(0).toUpperCase() + action.slice(1)}!`,
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
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
                    Swal.fire('Berhasil!', data.message, 'success').then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire('Error!', data.message, 'error');
                }
            })
            .catch(error => {
                Swal.fire('Error!', 'Terjadi kesalahan saat mengubah status', 'error');
            });
        }
    });
}

// Send notification function
function sendNotification(userId) {
    Swal.fire({
        title: 'Kirim Notifikasi',
        input: 'textarea',
        inputPlaceholder: 'Tulis pesan notifikasi...',
        showCancelButton: true,
        confirmButtonText: 'Kirim',
        cancelButtonText: 'Batal',
        inputValidator: (value) => {
            if (!value) {
                return 'Pesan tidak boleh kosong!'
            }
        }
    }).then((result) => {
        if (result.isConfirmed) {
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
                    Swal.fire('Berhasil!', 'Notifikasi berhasil dikirim', 'success');
                } else {
                    Swal.fire('Error!', data.message, 'error');
                }
            })
            .catch(error => {
                Swal.fire('Error!', 'Terjadi kesalahan saat mengirim notifikasi', 'error');
            });
        }
    });
}

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
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire('Berhasil!', data.message, 'success').then(() => {
                        window.location.href = '/admin/users';
                    });
                } else {
                    Swal.fire('Error!', data.message, 'error');
                }
            })
            .catch(error => {
                Swal.fire('Error!', 'Terjadi kesalahan saat menghapus akun', 'error');
            });
        }
    });
}

// View user reports
function viewUserReports(userId) {
    window.open(`/admin/users/${userId}/reports`, '_blank');
}
</script>
@endpush