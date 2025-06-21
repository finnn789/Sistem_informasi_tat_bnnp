{{-- resources/views/admin/users/create.blade.php --}}
@extends('layouts.admin')

@section('title', 'Tambah Akun Pengguna Baru')


<style>
    .form-section {
        background: white;
        border-radius: 12px;
        padding: 2rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        margin-bottom: 2rem;
        border-left: 4px solid #3b82f6;
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
    
    .file-upload-area {
        border: 2px dashed #d1d5db;
        border-radius: 0.5rem;
        padding: 2rem;
        text-align: center;
        transition: all 0.3s ease;
        cursor: pointer;
    }
    
    .file-upload-area:hover {
        border-color: #3b82f6;
        background-color: #f8fafc;
    }
    
    .file-upload-area.dragover {
        border-color: #3b82f6;
        background-color: #eff6ff;
    }
    
    .preview-image {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #3b82f6;
        margin: 0 auto;
    }
</style>


@section('content')
<div class="min-h-screen bg-gray-50 py-6">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Header --}}
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Tambah Akun Pengguna Baru</h1>
                    <p class="text-gray-600 mt-1">Buat akun baru untuk tim penyidik atau admin BNN</p>
                </div>
                <a href="{{ route('admin.users.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-gray-500 text-white text-sm font-medium 
                          rounded-md hover:bg-gray-600 transition-colors duration-150">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali
                </a>
            </div>
        </div>

        <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data" id="createUserForm">
            @csrf
            
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
                        <div class="file-upload-area" id="photoUploadArea">
                            <input type="file" name="profile_photo" id="profile_photo" 
                                   accept="image/*" class="hidden">
                            <div id="photoPreview" class="hidden">
                                <img id="previewImage" class="preview-image" src="" alt="Preview">
                                <p class="text-sm text-gray-600 mt-2">Klik untuk mengubah foto</p>
                            </div>
                            <div id="photoPlaceholder">
                                <i class="fas fa-camera text-4xl text-gray-400 mb-4"></i>
                                <p class="text-sm font-medium text-gray-700">Klik untuk upload foto profil</p>
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
                        <input type="text" 
                               name="name" 
                               id="name" 
                               class="form-input @error('name') error @enderror"
                               value="{{ old('name') }}"
                               placeholder="Masukkan nama lengkap"
                               required>
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
                        <input type="text" 
                               name="nrp" 
                               id="nrp" 
                               class="form-input @error('nrp') error @enderror"
                               value="{{ old('nrp') }}"
                               placeholder="Masukkan NRP"
                               maxlength="20"
                               required>
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
                        <input type="tel" 
                               name="no_telp" 
                               id="no_telp" 
                               class="form-input @error('no_telp') error @enderror"
                               value="{{ old('no_telp') }}"
                               placeholder="08xxxxxxxxxx"
                               maxlength="15"
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
                        <input type="text" 
                               name="satuan_kerja" 
                               id="satuan_kerja" 
                               class="form-input @error('satuan_kerja') error @enderror"
                               value="{{ old('satuan_kerja') }}"
                               placeholder="Contoh: Polres Padang, BNN Sumbar"
                               required>
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
                        <input type="email" 
                               name="email" 
                               id="email" 
                               class="form-input @error('email') error @enderror"
                               value="{{ old('email') }}"
                               placeholder="user@email.com"
                               required>
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
                        <select name="role" 
                                id="role" 
                                class="form-input @error('role') error @enderror"
                                required>
                            <option value="">Pilih Role</option>
                            @foreach($roles as $value => $label)
                                <option value="{{ $value }}" {{ old('role') == $value ? 'selected' : '' }}>
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

                    {{-- Password --}}
                    <div class="form-group">
                        <label for="password" class="form-label">
                            Password <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="password" 
                                   name="password" 
                                   id="password" 
                                   class="form-input @error('password') error @enderror"
                                   placeholder="Minimal 8 karakter"
                                   minlength="8"
                                   required>
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

                    {{-- Confirm Password --}}
                    <div class="form-group">
                        <label for="password_confirmation" class="form-label">
                            Konfirmasi Password <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="password" 
                                   name="password_confirmation" 
                                   id="password_confirmation" 
                                   class="form-input"
                                   placeholder="Ulangi password"
                                   minlength="8"
                                   required>
                            <button type="button" 
                                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600"
                                    onclick="togglePassword('password_confirmation')">
                                <i class="fas fa-eye" id="password_confirmation-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Form Actions --}}
            <div class="form-section">
                <div class="flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0 sm:space-x-4">
                    <div class="flex items-center text-sm text-gray-600">
                        <i class="fas fa-info-circle mr-2 text-blue-500"></i>
                        Field dengan tanda <span class="text-red-500">*</span> wajib diisi
                    </div>
                    
                    <div class="flex space-x-3">
                        <button type="button" 
                                onclick="resetForm()"
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
                            Simpan Akun
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    
    // Photo upload functionality
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
        // Validate file type
        if (!file.type.startsWith('image/')) {
            Swal.fire('Error', 'File harus berupa gambar', 'error');
            return;
        }

        // Validate file size (2MB)
        if (file.size > 2 * 1024 * 1024) {
            Swal.fire('Error', 'Ukuran file maksimal 2MB', 'error');
            return;
        }

        // Show preview
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
        // Remove non-numeric characters
        this.value = this.value.replace(/[^0-9]/g, '');
        
        // Validate Indonesian phone number format
        if (this.value.length > 0 && !this.value.startsWith('0')) {
            this.value = '0' + this.value;
        }
    });

    // NRP validation
    const nrpInput = document.getElementById('nrp');
    nrpInput.addEventListener('input', function() {
        // Convert to uppercase
        this.value = this.value.toUpperCase();
    });

    // Form validation
    const form = document.getElementById('createUserForm');
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Validate required fields
        const requiredFields = ['name', 'email', 'nrp', 'no_telp', 'satuan_kerja', 'role', 'password', 'password_confirmation'];
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

        // Validate password match
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('password_confirmation').value;
        
        if (password !== confirmPassword) {
            document.getElementById('password_confirmation').classList.add('error');
            Swal.fire('Error', 'Password dan konfirmasi password tidak sama', 'error');
            return;
        }

        if (!isValid) {
            Swal.fire('Error', 'Mohon lengkapi semua field yang wajib diisi', 'error');
            return;
        }

        // Show confirmation
        Swal.fire({
            title: 'Konfirmasi',
            text: 'Apakah Anda yakin ingin membuat akun ini?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3b82f6',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Buat Akun!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading
                Swal.fire({
                    title: 'Membuat Akun...',
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

        input.addEventListener('blur', function() {
            if (this.hasAttribute('required') && !this.value.trim()) {
                this.classList.add('error');
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
        text: 'Semua data yang sudah diisi akan hilang',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Ya, Reset!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('createUserForm').reset();
            
            // Reset photo preview
            document.getElementById('photoPlaceholder').classList.remove('hidden');
            document.getElementById('photoPreview').classList.add('hidden');
            
            // Remove error classes
            document.querySelectorAll('.form-input').forEach(input => {
                input.classList.remove('error');
            });
            
            Swal.fire('Reset!', 'Form berhasil direset', 'success');
        }
    });
}

// Auto-save draft (optional)
function saveDraft() {
    const formData = new FormData(document.getElementById('createUserForm'));
    const draftData = {};
    
    for (let [key, value] of formData.entries()) {
        if (key !== 'password' && key !== 'password_confirmation' && key !== 'profile_photo') {
            draftData[key] = value;
        }
    }
    
    localStorage.setItem('userCreateDraft', JSON.stringify(draftData));
}

// Load draft on page load
function loadDraft() {
    const draft = localStorage.getItem('userCreateDraft');
    if (draft) {
        const draftData = JSON.parse(draft);
        Object.keys(draftData).forEach(key => {
            const field = document.getElementById(key);
            if (field) {
                field.value = draftData[key];
            }
        });
    }
}

// Auto-save every 30 seconds
setInterval(saveDraft, 30000);

// Clear draft on successful submission
document.getElementById('createUserForm').addEventListener('submit', function() {
    localStorage.removeItem('userCreateDraft');
});
</script>
