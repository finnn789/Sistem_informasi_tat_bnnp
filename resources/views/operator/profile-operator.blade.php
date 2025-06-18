@extends('layouts.profile-layout')

@section('content')
    <div class="min-h-screen pt-20 bg-gradient-to-br from-slate-50 to-slate-100">
        <!-- Header -->
        {{-- <div class="bg-white shadow-lg border-b border-gray-200">
            <div class="container mx-auto px-6 py-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-800 flex items-center">
                            <i class="fas fa-user-cog text-bnn-primary mr-3"></i>
                            Pengaturan Profil
                        </h1>
                        <p class="text-gray-600 mt-1">Kelola informasi akun dan keamanan Anda</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-500">Terakhir diubah</p>
                        <p class="text-sm font-medium text-gray-700">{{ $user->updated_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>
            </div>
        </div> --}}

        <!-- Main Content -->
        <div class="container mx-auto px-6 py-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <!-- Sidebar Profile Card -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl shadow-xl overflow-hidden sticky top-8">
                        <!-- Profile Header -->
                        <div class="bg-gradient-to-r f from-[#1e3a8a] to-[#1e40af] p-6 text-white">
                            <div class="text-center">
                                <div class="relative inline-block">
                                    <img src="{{ asset('storage/' . $user->profile_photo) }}" alt="Profile Photo"
                                        class="w-24 h-24 rounded-full border-4 border-white shadow-lg object-cover">
                                    <div
                                        class="absolute -bottom-2 -right-2 w-8 h-8 bg-green-500 rounded-full border-2 border-white flex items-center justify-center">
                                        <i class="fas fa-check text-white text-xs"></i>
                                    </div>
                                </div>
                                <h3 class="mt-4 text-xl font-semibold">{{ $user->name }}</h3>
                                <p class="text-blue-100">{{ $user->nrp ?? 'NRP belum diatur' }}</p>
                                <p class="text-blue-200 text-sm mt-1">{{ $user->role ?? 'User' }}</p>
                            </div>
                        </div>

                        <!-- Profile Stats -->
                        <div class="p-6">
                            <div class="space-y-4">
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-600 text-sm">Email</span>
                                    <span class="text-gray-800 font-medium text-sm">{{ $user->email }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-600 text-sm">Satuan Kerja</span>
                                    <span
                                        class="text-gray-800 font-medium text-sm">{{ $user->satuan_kerja ?? 'Belum diatur' }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-600 text-sm">No. Telepon</span>
                                    <span
                                        class="text-gray-800 font-medium text-sm">{{ $user->no_telp ?? 'Belum diatur' }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-600 text-sm">Bergabung</span>
                                    <span
                                        class="text-gray-800 font-medium text-sm">{{ $user->created_at->format('M Y') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Settings -->
                <div class="lg:col-span-2 space-y-8">

                    <!-- Success/Error Messages -->
                    @if (session('success'))
                        <div class="bg-green-50 border border-green-200 rounded-lg p-4 flex items-center space-x-3">
                            <i class="fas fa-check-circle text-green-500"></i>
                            <span class="text-green-800 font-medium">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="bg-red-50 border border-red-200 rounded-lg p-4 flex items-center space-x-3">
                            <i class="fas fa-exclamation-circle text-red-500"></i>
                            <span class="text-red-800 font-medium">{{ session('error') }}</span>
                        </div>
                    @endif

                    <!-- Profile Information Card -->
                    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                        <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
                            <h2 class="text-xl font-semibold text-white flex items-center">
                                <i class="fas fa-user mr-3"></i>
                                Informasi Profil
                            </h2>
                            <p class="text-blue-100 text-sm mt-1">Perbarui informasi dasar akun Anda</p>
                        </div>

                        <form action="{{ route('profile.update') }}" method="POST" class="p-6 space-y-6">
                            @csrf
                            @method('PATCH')

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Name -->
                                <div>
                                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                                        <i class="fas fa-user-tag text-blue-600 mr-2"></i>
                                        Nama Lengkap
                                    </label>
                                    <input type="text" id="name" name="name"
                                        value="{{ old('name', $user->name) }}"
                                        class="w-full px-4 py-3 border-2  rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all @error('name') border-red-400 @enderror"
                                        required>
                                    @error('name')
                                        <p class="text-red-600 text-sm mt-1 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Email -->
                                <div>
                                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                                        <i class="fas fa-envelope text-blue-600 mr-2"></i>
                                        Email
                                    </label>
                                    <input type="email" id="email" name="email"
                                        value="{{ old('email', $user->email) }}"
                                        class="w-full px-4 py-3 border-2  rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all @error('email') border-red-400 @enderror"
                                        required>
                                    @error('email')
                                        <p class="text-red-600 text-sm mt-1 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- NRP -->
                                <div>
                                    <label for="nrp" class="block text-sm font-semibold text-gray-700 mb-2">
                                        <i class="fas fa-id-badge text-blue-600 mr-2"></i>
                                        NRP
                                    </label>
                                    <input type="text" id="nrp" name="nrp"
                                        value="{{ old('nrp', $user->nrp) }}"
                                        class="w-full px-4 py-3 border-2  rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all @error('nrp') border-red-400 @enderror"
                                        placeholder="Nomor Register Pokok">
                                    @error('nrp')
                                        <p class="text-red-600 text-sm mt-1 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Phone -->
                                <div>
                                    <label for="no_telp" class="block text-sm font-semibold text-gray-700 mb-2">
                                        <i class="fas fa-phone text-blue-600 mr-2"></i>
                                        No. Telepon
                                    </label>
                                    <input type="text" id="no_telp" name="no_telp"
                                        value="{{ old('no_telp', $user->no_telp) }}"
                                        class="w-full px-4 py-3 border-2  rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all @error('no_telp') border-red-400 @enderror"
                                        placeholder="Contoh: 08123456789">
                                    @error('no_telp')
                                        <p class="text-red-600 text-sm mt-1 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Satuan Kerja -->
                            <div>
                                <label for="satuan_kerja" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-building text-blue-600 mr-2"></i>
                                    Satuan Kerja
                                </label>
                                <input type="text" id="satuan_kerja" name="satuan_kerja"
                                    value="{{ old('satuan_kerja', $user->satuan_kerja) }}"
                                    class="w-full px-4 py-3 border-2  rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all @error('satuan_kerja') border-red-400 @enderror"
                                    placeholder="Contoh: BNN Provinsi DKI Jakarta">
                                @error('satuan_kerja')
                                    <p class="text-red-600 text-sm mt-1 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Submit Button -->
                            <div class="flex justify-end">
                                <button type="submit"
                                    class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold py-3 px-8 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 flex items-center space-x-2">
                                    <i class="fas fa-save"></i>
                                    <span>Simpan Perubahan</span>
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Photo Management Card -->
                    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                        <div class="bg-gradient-to-r from-purple-600 to-purple-700 px-6 py-4">
                            <h2 class="text-xl font-semibold text-white flex items-center">
                                <i class="fas fa-camera mr-3"></i>
                                Foto Profil
                            </h2>
                            <p class="text-purple-100 text-sm mt-1">Upload atau ubah foto profil Anda</p>
                        </div>

                        <div class="p-6">
                            <div class="flex flex-col md:flex-row items-center space-y-6 md:space-y-0 md:space-x-8">
                                <!-- Current Photo -->
                                <div class="text-center">
                                    <img src="{{ asset('storage/' . $user->profile_photo) }}" alt="Current Profile Photo"
                                        class="w-32 h-32 rounded-full border-4  border-gray-200 shadow-lg object-cover">
                                    <p class="text-gray-600 text-sm mt-2">Foto saat ini</p>
                                </div>

                                <!-- Upload Form -->
                                <div class="flex-1">
                                    <form action="{{ route('profile.photo') }}" method="POST"
                                        enctype="multipart/form-data" id="photoForm">
                                        @csrf

                                        <div
                                            class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:border-purple-400 transition-colors">
                                            <i class="fas fa-cloud-upload-alt text-gray-400 text-3xl mb-4"></i>
                                            <p class="text-gray-600 mb-4">Klik untuk memilih foto atau drag & drop</p>

                                            <input type="file" name="profile_photo" id="profile_photo"
                                                accept="image/*" class="hidden" onchange="previewPhoto(this)">

                                            <label for="profile_photo"
                                                class="inline-flex items-center px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors cursor-pointer">
                                                <i class="fas fa-folder-open mr-2"></i>
                                                Pilih Foto
                                            </label>

                                            <p class="text-gray-400 text-xs mt-2">
                                                Format: JPEG, PNG, JPG, GIF. Maksimal 2MB.
                                            </p>
                                        </div>

                                        <!-- Preview Area -->
                                        <div id="photoPreview" class="hidden mt-4">
                                            <div class="flex items-center justify-between bg-gray-50 rounded-lg p-4">
                                                <div class="flex items-center space-x-3">
                                                    <img id="previewImage" class="w-12 h-12 rounded-full object-cover">
                                                    <div>
                                                        <p id="fileName" class="text-sm font-medium text-gray-700"></p>
                                                        <p id="fileSize" class="text-xs text-gray-500"></p>
                                                    </div>
                                                </div>
                                                <div class="flex space-x-2">
                                                    <button type="submit"
                                                        class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors text-sm">
                                                        <i class="fas fa-upload mr-1"></i>
                                                        Upload
                                                    </button>
                                                    <button type="button" onclick="cancelPhoto()"
                                                        class="bg-gray-400 text-white px-4 py-2 rounded-lg hover:bg-gray-500 transition-colors text-sm">
                                                        <i class="fas fa-times mr-1"></i>
                                                        Batal
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        @error('profile_photo')
                                            <p class="text-red-600 text-sm mt-2 flex items-center">
                                                <i class="fas fa-exclamation-circle mr-1"></i>
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </form>

                                    <!-- Delete Photo Button -->
                                    @if ($user->profile_photo)
                                        <form action="{{ route('profile.photo.delete') }}" method="POST" class="mt-4"
                                            onsubmit="return confirm('Yakin ingin menghapus foto profil?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-colors text-sm">
                                                <i class="fas fa-trash mr-1"></i>
                                                Hapus Foto
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Password Change Card -->
                    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                        <div class="bg-gradient-to-r from-red-600 to-red-700 px-6 py-4">
                            <h2 class="text-xl font-semibold text-white flex items-center">
                                <i class="fas fa-lock mr-3"></i>
                                Keamanan Password
                            </h2>
                            <p class="text-red-100 text-sm mt-1">Ubah password untuk menjaga keamanan akun</p>
                        </div>

                        <form action="{{ route('profile.password') }}" method="POST" class="p-6 space-y-6">
                            @csrf
                            @method('PATCH')

                            <!-- Current Password -->
                            <div>
                                <label for="current_password" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-key text-red-600 mr-2"></i>
                                    Password Saat Ini
                                </label>
                                <div class="relative">
                                    <input type="password" id="current_password" name="current_password"
                                        class="w-full px-4 py-3 pr-12 border-2  rounded-xl focus:border-red-500 focus:ring-2 focus:ring-red-200 transition-all @error('current_password') border-red-400 @enderror"
                                        required>
                                    <button type="button"
                                        class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600"
                                        onclick="togglePassword('current_password')">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                @error('current_password')
                                    <p class="text-red-600 text-sm mt-1 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- New Password -->
                                <div>
                                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                                        <i class="fas fa-lock text-red-600 mr-2"></i>
                                        Password Baru
                                    </label>
                                    <div class="relative">
                                        <input type="password" id="password" name="password"
                                            class="w-full px-4 py-3 pr-12 border-2  rounded-xl focus:border-red-500 focus:ring-2 focus:ring-red-200 transition-all @error('password') border-red-400 @enderror"
                                            required>
                                        <button type="button"
                                            class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600"
                                            onclick="togglePassword('password')">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    @error('password')
                                        <p class="text-red-600 text-sm mt-1 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Confirm Password -->
                                <div>
                                    <label for="password_confirmation"
                                        class="block text-sm font-semibold text-gray-700 mb-2">
                                        <i class="fas fa-check-circle text-red-600 mr-2"></i>
                                        Konfirmasi Password
                                    </label>
                                    <div class="relative">
                                        <input type="password" id="password_confirmation" name="password_confirmation"
                                            class="w-full px-4 py-3 pr-12 border-2 border-gray-200 rounded-xl focus:border-red-500 focus:ring-2 focus:ring-red-200 transition-all"
                                            required>
                                        <button type="button"
                                            class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600"
                                            onclick="togglePassword('password_confirmation')">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Password Requirements -->
                            <div class="bg-gray-50 rounded-lg p-4">
                                <h4 class="text-sm font-semibold text-gray-700 mb-2">Persyaratan Password:</h4>
                                <ul class="text-sm text-gray-600 space-y-1">
                                    <li class="flex items-center">
                                        <i class="fas fa-check text-green-500 mr-2"></i>
                                        Minimal 8 karakter
                                    </li>
                                    <li class="flex items-center">
                                        <i class="fas fa-check text-green-500 mr-2"></i>
                                        Mengandung huruf dan angka
                                    </li>
                                    <li class="flex items-center">
                                        <i class="fas fa-check text-green-500 mr-2"></i>
                                        Berbeda dari password sebelumnya
                                    </li>
                                </ul>
                            </div>

                            <!-- Submit Button -->
                            <div class="flex justify-end">
                                <button type="submit"
                                    class="bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white font-semibold py-3 px-8 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 flex items-center space-x-2">
                                    <i class="fas fa-shield-alt"></i>
                                    <span>Ubah Password</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <style>
        .text-bnn-primary {
            color: #1e3a8a;
        }

        .text-bnn-secondary {
            color: #1e40af;
        }

        .bg-bnn-primary {
            background-color: #1e3a8a;
        }

        .bg-bnn-secondary {
            background-color: #1e40af;
        }
    </style>


    <script>
        function previewPhoto(input) {
            const file = input.files[0];

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('previewImage').src = e.target.result;
                    document.getElementById('fileName').textContent = file.name;
                    document.getElementById('fileSize').textContent = formatFileSize(file.size);
                    document.getElementById('photoPreview').classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            }
        }
        // Toggle password visibility
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const button = field.nextElementSibling.querySelector('i');

            if (field.type === 'password') {
                field.type = 'text';
                button.className = 'fas fa-eye-slash';
            } else {
                field.type = 'password';
                button.className = 'fas fa-eye';
            }
        }

        // Photo preview functionality


        function cancelPhoto() {
            document.getElementById('profile_photo').value = '';
            document.getElementById('photoPreview').classList.add('hidden');
        }

        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }

        // Auto-hide success messages
        setTimeout(() => {
            const alerts = document.querySelectorAll('.bg-green-50, .bg-red-50');
            alerts.forEach(alert => {
                alert.style.transition = 'opacity 0.5s ease-out';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            });
        }, 5000);

        // Form submission with loading states
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function() {
                const submitBtn = this.querySelector('button[type="submit"]');
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = submitBtn.innerHTML.replace(/Simpan|Ubah|Upload/, 'Memproses...');
                }
            });
        });
    </script>
@endsection
