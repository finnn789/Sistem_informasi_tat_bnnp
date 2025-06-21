{{-- resources/views/admin/users/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Edit Akun Pengguna')

@push('styles')
    <style>
        .form-section {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
            border-left: 4px solid #3b82f6;
        }

        .current-photo {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #3b82f6;
            margin: 0 auto;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.5rem;
            font-size: 0.875rem;
        }

        .form-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 2px solid #d1d5db;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            transition: all 0.3s ease;
            background-color: #ffffff;
        }

        .form-input:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            transform: translateY(-1px);
        }

        .form-input.error {
            border-color: #ef4444;
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
        }

        .error-message {
            color: #ef4444;
            font-size: 0.75rem;
            margin-top: 0.25rem;
            display: flex;
            align-items: center;
        }

        .info-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 12px;
            padding: 1.5rem;
            color: white;
            margin-bottom: 2rem;
        }
    </style>
@endpush

@section('content')
    <div class="min-h-screen bg-gray-50 py-6">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Header --}}
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Edit Akun Pengguna</h1>
                        <p class="text-gray-600 mt-1">Perbarui informasi akun {{ $user->name }}</p>
                    </div>
                    <div class="flex space-x-3">
                        <a href="{{ route('admin.users.show', $user) }}"
                            class="inline-flex items-center px-4 py-2 bg-blue-500 text-white text-sm font-medium 
                              rounded-md hover:bg-blue-600 transition-colors duration-150">
                            <i class="fas fa-eye mr-2"></i>
                            Lihat Profil
                        </a>
                        <a href="{{ route('admin.users.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-500 text-white text-sm font-medium 
                              rounded-md hover:bg-gray-600 transition-colors duration-150">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Kembali
                        </a>
                    </div>
                </div>
            </div>

            {{-- User Info Card --}}
            <div class="info-card">
                <div class="flex items-center space-x-4">
                    <div class="flex-shrink-0">
                        @if ($user->profile_photo)
                            <img src="{{ $user->getProfilePhotoUrlAttributeV4() }}" alt="{{ $user->name }}"
                                class="current-photo">
                        @else
                            <div class="current-photo bg-white bg-opacity-20 flex items-center justify-center">
                                <span class="text-2xl font-bold">
                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                </span>
                            </div>
                        @endif
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold">{{ $user->name }}</h3>
                        <p class="opacity-90">{{ $user->email }}</p>
                        <p class="text-sm opacity-75">{{ $user->satuan_kerja }}</p>
                        <div class="flex items-center mt-2">
                            <span class="px-2 py-1 bg-white bg-opacity-20 rounded-full text-xs font-medium">
                                {{ $user->role === 'admin_bnn' ? 'Admin BNN' : 'Tim Penyidik' }}
                            </span>
                            <span class="ml-2 text-sm opacity-75">
                                Bergabung {{ $user->created_at->diffForHumans() }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <form action="{{ route('admin.users.update', $user) }}" method="POST" enctype="multipart/form-data"
                id="editUserForm">
                @csrf
                @method('PUT')

                {{-- Personal Information Section --}}
                <div class="form-section">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                        <i class="fas fa-user mr-3 text-blue-500"></i>
                        Informasi Personal
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Profile Photo --}}
                        <div class="md:col-span-2">
                            <label class="form-label">Foto Profil</label>

                            @if ($user->profile_photo)
                                <div class="text-center mb-4">
                                    <img src="{{ $user->getProfilePhotoUrlAttributeV4() }}" alt="Current photo"
                                        class="current-photo">
                                    <p class="text-sm text-gray-600 mt-2">Foto saat ini</p>
                                </div>
                            @endif

                            <div class="file-upload-area" id="photoUploadArea">
                                <input type="file" name="profile_photo" id="profile_photo" accept="image/*"
                                    class="hidden">
                                <div id="photoPreview" class="hidden">
                                    <img id="previewImage" class="preview-image" src="" alt="Preview">
                                    <p class="text-sm text-gray-600 mt-2">Foto baru yang akan diupload</p>
                                </div>
                                <div id="photoPlaceholder">
                                    <i class="fas fa-camera text-4xl text-gray-400 mb-4"></i>
                                    <p class="text-sm font-medium text-gray-700">
                                        {{ $user->profile_photo ? 'Klik untuk mengubah foto' : 'Klik untuk upload foto profil' }}
                                    </p>
                                    <p class="text-xs text-gray-500 mt-1">PNG, JPG, GIF hingga 2MB</p>
                                </div>
                            </div>
                            @error('profile_photo')
                                <p class="error-message">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Full Name --}}
                        <div class="form-group">
                            <label for="name" class="form-label">
                                Nama Lengkap <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="name" id="name"
                                class="form-input @error('name') error @enderror" value="{{ old('name', $user->name) }}"
                                placeholder="Masukkan nama lengkap" required>
                            @error('name')
                                <p class="error-message">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- NRP --}}
                        <div class="form-group">
                            <label for="nrp" class="form-label">
                                NRP (Nomor Registrasi Pokok) <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nrp" id="nrp"
                                class="form-input @error('nrp') error @enderror" value="{{ old('nrp', $user->nrp) }}"
                                placeholder="Masukkan NRP" maxlength="20" required>
                            @error('nrp')
                                <p class="error-message">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Phone Number --}}
                        <div class="form-group">
                            <label for="no_telp" class="form-label">
                                Nomor Telepon <span class="text-red-500">*</span>
                            </label>
                            <input type="tel" name="no_telp" id="no_telp"
                                class="form-input @error('no_telp') error @enderror"
                                value="{{ old('no_telp', $user->no_telp) }}" placeholder="08xxxxxxxxxx" maxlength="15"
                                required>
                            @error('no_telp')
                                <p class="error-message">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Work Unit --}}
                        <div class="form-group">
                            <label for="satuan_kerja" class="form-label">
                                Satuan Kerja <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="satuan_kerja" id="satuan_kerja"
                                class="form-input @error('satuan_kerja') error @enderror"
                                value="{{ old('satuan_kerja', $user->satuan_kerja) }}"
                                placeholder="Contoh: Polres Padang, BNN Sumbar" required>
                            @error('satuan_kerja')
                                <p class="error-message">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Account Information Section --}}
                <div class="form-section">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                        <i class="fas fa-key mr-3 text-blue-500"></i>
                        Informasi Akun
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Email --}}
                        <div class="form-group">
                            <label for="email" class="form-label">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input type="email" name="email" id="email"
                                class="form-input @error('email') error @enderror"
                                value="{{ old('email', $user->email) }}" placeholder="user@email.com" required>
                            @error('email')
                                <p class="error-message">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Role --}}
                        <div class="form-group">
                            <label for="role" class="form-label">
                                Role <span class="text-red-500">*</span>
                            </label>
                            <select name="role" id="role" class="form-input @error('role') error @enderror"
                                required>
                                <option value="">Pilih Role</option>
                                @foreach ($roles as $value => $label)
                                    <option value="{{ $value }}"
                                        {{ old('role', $user->role) == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            @error('role')
                                <p class="error-message">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Password Section --}}
                <div class="form-section">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                        <i class="fas fa-lock mr-3 text-blue-500"></i>
                        Ubah Password
                        <span class="ml-2 text-sm font-normal text-gray-500">(Opsional)</span>
                    </h3>

                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                        <div class="flex items-start">
                            <i class="fas fa-info-circle text-yellow-600 mt-0.5 mr-3"></i>
                            <div class="text-sm text-yellow-800">
                                <p class="font-medium">Informasi Password:</p>
                                <ul class="mt-1 list-disc list-inside space-y-1">
                                    <li>Kosongkan field password jika tidak ingin mengubah password</li>
                                    <li>Password minimal 8 karakter</li>
                                    <li>Pastikan password confirmation sama dengan password baru</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- New Password --}}
                        <div class="form-group">
                            <label for="password" class="form-label">
                                Password Baru
                            </label>
                            <div class="relative">
                                <input type="password" name="password" id="password"
                                    class="form-input @error('password') error @enderror"
                                    placeholder="Kosongkan jika tidak ingin mengubah" minlength="8">
                                <button type="button"
                                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600"
                                    onclick="togglePassword('password')">
                                    <i class="fas fa-eye" id="password-eye"></i>
                                </button>
                            </div>
                            @error('password')
                                <p class="error-message">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Confirm New Password --}}
                        <div class="form-group">
                            <label for="password_confirmation" class="form-label">
                                Konfirmasi Password Baru
                            </label>
                            <div class="relative">
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    class="form-input" placeholder="Ulangi password baru" minlength="8">
                                <button type="button"
                                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600"
                                    onclick="togglePassword('password_confirmation')">
                                    <i class="fas fa-eye" id="password_confirmation-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Account Activity Section --}}
                <div class="form-section">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                        <i class="fas fa-chart-line mr-3 text-blue-500"></i>
                        Informasi Akun
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-gray-50 rounded-lg p-4 text-center">
                            <div class="text-2xl font-bold text-blue-600">{{ $user->id }}</div>
                            <div class="text-sm text-gray-600">User ID</div>
                        </div>

                        <div class="bg-gray-50 rounded-lg p-4 text-center">
                            <div class="text-2xl font-bold text-green-600">
                                {{ $user->created_at->format('d/m/Y') }}
                            </div>
                            <div class="text-sm text-gray-600">Tanggal Daftar</div>
                        </div>

                        <div class="bg-gray-50 rounded-lg p-4 text-center">
                            <div class="text-2xl font-bold text-purple-600">
                                @if (isset($user->updated_at))
                                    {{ $user->updated_at->format('d/m/Y') }}
                                @else
                                    -
                                @endif
                            </div>
                            <div class="text-sm text-gray-600">Terakhir Update</div>
                        </div>
                    </div>
                </div>

                {{-- Form Actions --}}
                <div class="form-section">
                    <div
                        class="flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0 sm:space-x-4">
                        <div class="flex items-center text-sm text-gray-600">
                            <i class="fas fa-info-circle mr-2 text-blue-500"></i>
                            Perubahan akan disimpan secara permanen
                        </div>

                        <div class="flex space-x-3">
                            {{-- Quick Actions --}}
                            <div class="flex space-x-2 mr-4">
                                <button type="button" onclick="resetPassword()"
                                    class="px-4 py-2 bg-orange-500 text-white text-sm font-medium rounded-lg 
                                           hover:bg-orange-600 transition-colors duration-150 shadow-sm"
                                    title="Reset password ke default">
                                    <i class="fas fa-key mr-1"></i>
                                    Reset Password
                                </button>

                                <button type="button" onclick="toggleUserStatus()"
                                    class="px-4 py-2 {{ $user->is_active ?? true ? 'bg-red-500 hover:bg-red-600' : 'bg-green-500 hover:bg-green-600' }} 
                                           text-white text-sm font-medium rounded-lg transition-colors duration-150 shadow-sm"
                                    title="{{ $user->is_active ?? true ? 'Nonaktifkan akun' : 'Aktifkan akun' }}">
                                    <i class="fas {{ $user->is_active ?? true ? 'fa-ban' : 'fa-check' }} mr-1"></i>
                                    {{ $user->is_active ?? true ? 'Nonaktifkan' : 'Aktifkan' }}
                                </button>
                            </div>

                            <button type="button" onclick="resetForm()"
                                class="px-6 py-3 bg-gray-500 text-white font-medium rounded-lg 
                                       hover:bg-gray-600 transition-colors duration-150 shadow-sm">
                                <i class="fas fa-undo mr-2"></i>
                                Reset
                            </button>

                            <button type="submit"
                                class="px-8 py-3 bg-blue-600 text-white font-bold rounded-lg 
                                       hover:bg-blue-700 transition-all duration-150 shadow-lg 
                                       hover:shadow-xl transform hover:-translate-y-1">
                                <i class="fas fa-save mr-2"></i>
                                Update Akun
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // Photo upload functionality (same as create form)
            const photoUploadArea = document.getElementById('photoUploadArea');
            const photoInput = document.getElementById('profile_photo');
            const photoPreview = document.getElementById('photoPreview');
            const photoPlaceholder = document.getElementById('photoPlaceholder');
            const previewImage = document.getElementById('previewImage');

            photoUploadArea.addEventListener('click', () => photoInput.click());

            photoUploadArea.addEventListener('dragover', (e) => {
                e.preventDefault();
                photoUploadArea.classList.add('dragover');
            });

            photoUploadArea.addEventListener('dragleave', () => {
                photoUploadArea.classList.remove('dragover');
            });

            photoUploadArea.addEventListener('drop', (e) => {
                e.preventDefault();
                photoUploadArea.classList.remove('dragover');
                const files = e.dataTransfer.files;
                if (files.length > 0) {
                    photoInput.files = files;
                    handlePhotoUpload(files[0]);
                }
            });

            photoInput.addEventListener('change', (e) => {
                if (e.target.files.length > 0) {
                    handlePhotoUpload(e.target.files[0]);
                }
            });

            function handlePhotoUpload(file) {
                if (!file.type.startsWith('image/')) {
                    Swal.fire('Error', 'File harus berupa gambar', 'error');
                    return;
                }

                if (file.size > 2 * 1024 * 1024) {
                    Swal.fire('Error', 'Ukuran file maksimal 2MB', 'error');
                    return;
                }

                const reader = new FileReader();
                reader.onload = (e) => {
                    previewImage.src = e.target.result;
                    photoPlaceholder.classList.add('hidden');
                    photoPreview.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            }

            // Phone number validation
            const phoneInput = document.getElementById('no_telp');
            phoneInput.addEventListener('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '');
                if (this.value.length > 0 && !this.value.startsWith('0')) {
                    this.value = '0' + this.value;
                }
            });

            // NRP validation
            const nrpInput = document.getElementById('nrp');
            nrpInput.addEventListener('input', function() {
                this.value = this.value.toUpperCase();
            });

            // Form validation
            const form = document.getElementById('editUserForm');
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                // Validate required fields
                const requiredFields = ['name', 'email', 'nrp', 'no_telp', 'satuan_kerja', 'role'];
                let isValid = true;

                requiredFields.forEach(field => {
                    const input = document.getElementById(field);
                    if (!input.value.trim()) {
                        input.classList.add('error');
                        isValid = false;
                    } else {
                        input.classList.remove('error');
                    }
                });

                // Validate password match if passwords are provided
                const password = document.getElementById('password').value;
                const confirmPassword = document.getElementById('password_confirmation').value;

                if (password || confirmPassword) {
                    if (password !== confirmPassword) {
                        document.getElementById('password_confirmation').classList.add('error');
                        Swal.fire('Error', 'Password dan konfirmasi password tidak sama', 'error');
                        return;
                    }
                }

                if (!isValid) {
                    Swal.fire('Error', 'Mohon lengkapi semua field yang wajib diisi', 'error');
                    return;
                }

                // Show confirmation
                Swal.fire({
                    title: 'Konfirmasi Update',
                    text: 'Apakah Anda yakin ingin memperbarui akun ini?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3b82f6',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Ya, Update!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Show loading
                        Swal.fire({
                            title: 'Memperbarui Akun...',
                            text: 'Mohon tunggu sebentar',
                            allowOutsideClick: false,
                            showConfirmButton: false,
                            willOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        // Submit form
                        form.submit();
                    }
                });
            });

            // Real-time validation
            const inputs = document.querySelectorAll('.form-input');
            inputs.forEach(input => {
                input.addEventListener('input', function() {
                    if (this.classList.contains('error') && this.value.trim()) {
                        this.classList.remove('error');
                    }
                });
            });

            // Email validation
            const emailInput = document.getElementById('email');
            emailInput.addEventListener('blur', function() {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (this.value && !emailRegex.test(this.value)) {
                    this.classList.add('error');
                    Swal.fire('Error', 'Format email tidak valid', 'error');
                }
            });
        });

        // Toggle password visibility
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const eyeIcon = document.getElementById(fieldId + '-eye');

            if (field.type === 'password') {
                field.type = 'text';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                field.type = 'password';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        }

        // Reset form
        function resetForm() {
            Swal.fire({
                title: 'Reset Form?',
                text: 'Semua perubahan yang belum disimpan akan hilang',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Reset!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    location.reload();
                }
            });
        }

        // Reset password to default
        function resetPassword() {
            Swal.fire({
                title: 'Reset Password?',
                text: 'Password akan direset ke "password123". Pengguna perlu mengubah password setelah login.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#f59e0b',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Reset!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/admin/users/{{ $user->id }}/reset-password`, {
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
                                    html: `Password baru: <strong>${data.new_password}</strong>`,
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
        function toggleUserStatus() {
            const isActive = {{ $user->is_active ?? true ? 'true' : 'false' }};
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
                    fetch(`/admin/users/{{ $user->id }}/toggle-status`, {
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
    </script>
@endpush
