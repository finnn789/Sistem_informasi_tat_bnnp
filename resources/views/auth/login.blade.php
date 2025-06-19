<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - BNN Provinsi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'bnn-primary': '#1e3a8a',
                        'bnn-secondary': '#1e40af',
                        'bnn-accent': '#dc2626',
                        'bnn-gold': '#d97706',
                        'bnn-light': '#eff6ff',
                        'bnn-dark': '#0f172a',
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.8s ease-in-out',
                        'slide-up': 'slideUp 0.6s ease-out',
                        'float': 'float 3s ease-in-out infinite',
                        'shake': 'shake 0.5s ease-in-out',
                        'pulse-error': 'pulseError 2s infinite',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' }
                        },
                        slideUp: {
                            '0%': { transform: 'translateY(20px)', opacity: '0' },
                            '100%': { transform: 'translateY(0)', opacity: '1' }
                        },
                        float: {
                            '0%, 100%': { transform: 'translateY(0px)' },
                            '50%': { transform: 'translateY(-10px)' }
                        },
                        shake: {
                            '0%, 100%': { transform: 'translateX(0)' },
                            '10%, 30%, 50%, 70%, 90%': { transform: 'translateX(-3px)' },
                            '20%, 40%, 60%, 80%': { transform: 'translateX(3px)' }
                        },
                        pulseError: {
                            '0%, 100%': { boxShadow: '0 0 0 0 rgba(220, 38, 38, 0.4)' },
                            '50%': { boxShadow: '0 0 0 10px rgba(220, 38, 38, 0)' }
                        }
                    }
                }
            }
        }
    </script>
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 50%, #3b82f6 100%);
        }

        .login-pattern {
            background-image:
                radial-gradient(circle at 25% 25%, rgba(255, 255, 255, 0.1) 2px, transparent 2px),
                radial-gradient(circle at 75% 75%, rgba(255, 255, 255, 0.05) 1px, transparent 1px);
            background-size: 40px 40px;
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .input-focus:focus {
            border-color: #1e40af;
            box-shadow: 0 0 0 3px rgba(30, 64, 175, 0.1);
        }

        .input-error {
            border-color: #dc2626 !important;
            box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1) !important;
        }

        .btn-bnn {
            background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%);
            transition: all 0.3s ease;
        }

        .btn-bnn:hover {
            background: linear-gradient(135deg, #1e40af 0%, #2563eb 100%);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(30, 58, 138, 0.3);
        }

        .btn-bnn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .logo-shadow {
            filter: drop-shadow(0 10px 20px rgba(0, 0, 0, 0.1));
        }

        .error-shake {
            animation: shake 0.5s ease-in-out;
        }
    </style>
</head>

<body class="min-h-screen gradient-bg login-pattern overflow-hidden">
    <!-- Background Decorative Elements -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <!-- Floating Shapes -->
        <div class="absolute top-10 left-10 w-32 h-32 bg-white opacity-5 rounded-full animate-float"></div>
        <div class="absolute top-1/3 right-20 w-24 h-24 bg-bnn-accent opacity-10 rounded-full animate-float"
            style="animation-delay: 1s;"></div>
        <div class="absolute bottom-20 left-1/4 w-20 h-20 bg-bnn-gold opacity-10 rounded-full animate-float"
            style="animation-delay: 2s;"></div>

        <!-- Geometric Patterns -->
        <div class="absolute top-0 right-0 w-96 h-96 opacity-5">
            <svg viewBox="0 0 100 100" class="w-full h-full">
                <defs>
                    <pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse">
                        <path d="M 10 0 L 0 0 0 10" fill="none" stroke="white" stroke-width="0.5" />
                    </pattern>
                </defs>
                <rect width="100" height="100" fill="url(#grid)" />
            </svg>
        </div>
    </div>

    <!-- Main Content -->
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-md">
            <!-- Login Card -->
            <div class="glass-effect rounded-2xl shadow-2xl p-8 animate-slide-up" id="loginCard">
                <!-- Header Section -->
                <div class="text-center mb-8">
                    <!-- Logo BNN -->
                    <div class="flex justify-center mb-4">
                        <div class="relative">
                            <div class="w-24 h-24 from-bnn-primary to-bnn-secondary rounded-full flex items-center justify-center logo-shadow animate-float">
                                <img src="{{ asset('images/logo2.png') }}" alt="Logo BNN" class="w-20 h-20 object-contain">
                            </div>
                        </div>
                    </div>

                    <!-- Title -->
                    <h1 class="text-2xl font-bold text-bnn-dark mb-2">
                        BADAN NARKOTIKA NASIONAL
                    </h1>
                    <p class="text-bnn-secondary font-medium">Provinsi</p>
                    <p class="text-gray-600 text-sm mt-2">Sistem Informasi Manajemen</p>

                    <!-- Divider -->
                    <div class="flex items-center my-6">
                        <div class="flex-1 h-px bg-gradient-to-r from-transparent via-bnn-primary to-transparent"></div>
                        <div class="px-4">
                            <i class="fas fa-lock text-bnn-primary"></i>
                        </div>
                        <div class="flex-1 h-px bg-gradient-to-r from-transparent via-bnn-primary to-transparent"></div>
                    </div>
                </div>

                <!-- Error Alert - Global -->
                @if ($errors->any() || session('error'))
                <div id="errorAlert" class="mb-6 bg-red-50 border-l-4 border-red-500 rounded-lg p-4 animate-fade-in">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-triangle text-red-500 text-lg"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-red-800">
                                @if(session('error'))
                                    {{ session('error') }}
                                @elseif($errors->has('email'))
                                    {{ $errors->first('email') }}
                                @elseif($errors->has('password'))
                                    Email atau password tidak sesuai
                                @else
                                    Terjadi kesalahan saat login
                                @endif
                            </p>
                        </div>
                        <div class="ml-auto">
                            <button type="button" class="text-red-400 hover:text-red-600" onclick="hideError()">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Session Status (Success) -->
                @if (session('status'))
                <div id="successAlert" class="mb-6 bg-green-50 border-l-4 border-green-500 rounded-lg p-4 animate-fade-in">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-check-circle text-green-500 text-lg"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800">
                                {{ session('status') }}
                            </p>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Login Form -->
                <form method="POST" action="{{ route('login') }}" class="space-y-6" id="loginForm">
                    @csrf

                    <!-- Email Field -->
                    <div class="space-y-2">
                        <label for="email" class="block text-sm font-semibold text-bnn-dark">
                            <i class="fas fa-envelope mr-2 text-bnn-primary"></i>
                            Email Address
                        </label>
                        <div class="relative">
                            <input id="email" 
                                   type="email" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   required 
                                   autofocus
                                   autocomplete="username"
                                   class="w-full px-4 py-3 pl-12 border-2 border-gray-200 rounded-xl input-focus transition-all duration-300 bg-white/80 @error('email') input-error @enderror"
                                   placeholder="Masukkan email Anda">
                            <div class="absolute left-4 top-1/2 transform -translate-y-1/2">
                                <i class="fas fa-user text-gray-400"></i>
                            </div>
                        </div>
                        @error('email')
                        <p class="text-red-600 text-sm flex items-center mt-1">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                        @enderror
                    </div>

                    <!-- Password Field -->
                    <div class="space-y-2">
                        <label for="password" class="block text-sm font-semibold text-bnn-dark">
                            <i class="fas fa-lock mr-2 text-bnn-primary"></i>
                            Password
                        </label>
                        <div class="relative">
                            <input id="password" 
                                   type="password" 
                                   name="password" 
                                   required
                                   autocomplete="current-password"
                                   class="w-full px-4 py-3 pl-12 pr-12 border-2 border-gray-200 rounded-xl input-focus transition-all duration-300 bg-white/80 @error('password') input-error @enderror"
                                   placeholder="Masukkan password Anda">
                            <div class="absolute left-4 top-1/2 transform -translate-y-1/2">
                                <i class="fas fa-key text-gray-400"></i>
                            </div>
                            <button type="button"
                                class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-bnn-primary transition-colors"
                                onclick="togglePassword()">
                                <i class="fas fa-eye" id="toggleIcon"></i>
                            </button>
                        </div>
                        @error('password')
                        <p class="text-red-600 text-sm flex items-center mt-1">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            Password yang Anda masukkan salah
                        </p>
                        @enderror
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between">
                        <label class="flex items-center space-x-3 cursor-pointer">
                            <input type="checkbox" 
                                   name="remember" 
                                   {{ old('remember') ? 'checked' : '' }}
                                   class="w-4 h-4 text-bnn-primary border-2 border-gray-300 rounded focus:ring-bnn-primary focus:ring-2">
                            <span class="text-sm text-gray-700 font-medium">Ingat Saya</span>
                        </label>

                        @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}"
                           class="text-sm text-bnn-primary hover:text-bnn-secondary font-medium transition-colors">
                            Lupa Password?
                        </a>
                        @endif
                    </div>

                    <!-- Login Button -->
                    <button type="submit" 
                            id="submitBtn"
                            class="w-full btn-bnn text-white font-semibold py-3 px-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 flex items-center justify-center space-x-2">
                        <i class="fas fa-sign-in-alt" id="submitIcon"></i>
                        <span id="submitText">Masuk Sistem</span>
                    </button>
                </form>

                <!-- Attempt Counter (if multiple failed attempts) -->
                @if(session('login_attempts') && session('login_attempts') > 2)
                <div class="mt-4 p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-triangle text-yellow-600 mr-2"></i>
                        <p class="text-sm text-yellow-800">
                            Percobaan login: {{ session('login_attempts') }}/5
                            @if(session('login_attempts') >= 4)
                                <span class="font-semibold text-red-600">- Akun akan dikunci setelah 5 percobaan gagal</span>
                            @endif
                        </p>
                    </div>
                </div>
                @endif

                <!-- Footer -->
                <div class="mt-8 text-center">
                    <div class="flex items-center justify-center space-x-4 mb-4">
                        <div class="w-8 h-px bg-gradient-to-r from-transparent to-bnn-primary"></div>
                        <span class="text-xs text-gray-500 font-medium">SECURE LOGIN</span>
                        <div class="w-8 h-px bg-gradient-to-l from-transparent to-bnn-primary"></div>
                    </div>

                    <p class="text-xs text-gray-500">
                        © {{ date('Y') }} Badan Narkotika Nasional Provinsi
                    </p>
                    <p class="text-xs text-gray-400 mt-1">
                        Sistem dilindungi dengan enkripsi SSL
                        <i class="fas fa-shield-alt ml-1 text-green-500"></i>
                    </p>
                </div>
            </div>

            <!-- Additional Info -->
            <div class="mt-6 text-center animate-fade-in">
                <div class="inline-flex items-center space-x-4 text-white/80 text-sm">
                    <div class="flex items-center space-x-2">
                        <i class="fas fa-phone"></i>
                        <span>Hotline: 184</span>
                    </div>
                    <div class="w-px h-4 bg-white/40"></div>
                    <div class="flex items-center space-x-2">
                        <i class="fas fa-envelope"></i>
                        <span>info@bnn.go.id</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading Overlay -->
    <div id="loadingOverlay"
        class="fixed inset-0 bg-bnn-primary/90 backdrop-blur-sm  items-center justify-center z-50 hidden">
        <div class="text-center text-white">
            <div class="w-16 h-16 border-4 border-white/30 border-t-white rounded-full animate-spin mx-auto mb-4"></div>
            <p class="text-lg font-semibold">Memverifikasi kredensial...</p>
            <p class="text-sm opacity-80">Mohon tunggu sebentar</p>
        </div>
    </div>

    <!-- Toast Notifications -->
    <div id="toastContainer" class="fixed top-4 right-4 z-50 space-y-2"></div>

    <script>
        // Form submission dengan loading dan error handling
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            // Show loading
            showLoading();
            
            // Clear previous errors
            clearFieldErrors();
            
            // Basic client-side validation
            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value;
            
            if (!email || !password) {
                e.preventDefault();
                hideLoading();
                showError('Email dan password harus diisi');
                return;
            }
            
            if (!isValidEmail(email)) {
                e.preventDefault();
                hideLoading();
                showFieldError('email', 'Format email tidak valid');
                return;
            }
            
            // Form akan submit normal ke Laravel
        });

        // Toggle Password Visibility
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.className = 'fas fa-eye-slash';
            } else {
                passwordInput.type = 'password';
                toggleIcon.className = 'fas fa-eye';
            }
        }

        // Show loading state
        function showLoading() {
            const submitBtn = document.getElementById('submitBtn');
            const submitIcon = document.getElementById('submitIcon');
            const submitText = document.getElementById('submitText');
            
            submitBtn.disabled = true;
            submitIcon.className = 'fas fa-spinner animate-spin';
            submitText.textContent = 'Memverifikasi...';
            
            document.getElementById('loadingOverlay').classList.remove('hidden');
        }

        // Hide loading state
        function hideLoading() {
            const submitBtn = document.getElementById('submitBtn');
            const submitIcon = document.getElementById('submitIcon');
            const submitText = document.getElementById('submitText');
            
            submitBtn.disabled = false;
            submitIcon.className = 'fas fa-sign-in-alt';
            submitText.textContent = 'Masuk Sistem';
            
            document.getElementById('loadingOverlay').classList.add('hidden');
        }

        // Show error message
        function showError(message) {
            showToast(message, 'error');
            shakeLoginCard();
        }

        // Show field-specific error
        function showFieldError(fieldId, message) {
            const field = document.getElementById(fieldId);
            field.classList.add('input-error', 'animate-pulse-error');
            
            // Create error message if not exists
            let errorEl = field.parentElement.parentElement.querySelector('.error-message');
            if (!errorEl) {
                errorEl = document.createElement('p');
                errorEl.className = 'error-message text-red-600 text-sm flex items-center mt-1';
                field.parentElement.parentElement.appendChild(errorEl);
            }
            
            errorEl.innerHTML = `<i class="fas fa-exclamation-circle mr-1"></i>${message}`;
            field.focus();
        }

        // Clear field errors
        function clearFieldErrors() {
            document.querySelectorAll('input').forEach(input => {
                input.classList.remove('input-error', 'animate-pulse-error');
            });
            
            document.querySelectorAll('.error-message').forEach(error => {
                error.remove();
            });
        }

        // Hide error alert
        function hideError() {
            const errorAlert = document.getElementById('errorAlert');
            if (errorAlert) {
                errorAlert.style.opacity = '0';
                setTimeout(() => errorAlert.remove(), 300);
            }
        }

        // Shake login card animation
        function shakeLoginCard() {
            const loginCard = document.getElementById('loginCard');
            loginCard.classList.add('error-shake');
            setTimeout(() => {
                loginCard.classList.remove('error-shake');
            }, 500);
        }

        // Email validation
        function isValidEmail(email) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }

        // Toast notification system
        function showToast(message, type = 'info') {
            const toastContainer = document.getElementById('toastContainer');
            const toast = document.createElement('div');
            
            const colors = {
                'success': 'bg-green-500',
                'error': 'bg-red-500',
                'warning': 'bg-yellow-500',
                'info': 'bg-blue-500'
            };
            
            const icons = {
                'success': 'fa-check-circle',
                'error': 'fa-exclamation-circle',
                'warning': 'fa-exclamation-triangle',
                'info': 'fa-info-circle'
            };
            
            toast.className = `${colors[type]} text-white px-6 py-4 rounded-lg shadow-lg flex items-center space-x-3 transform translate-x-full transition-transform duration-300`;
            toast.innerHTML = `
                <i class="fas ${icons[type]}"></i>
                <span>${message}</span>
                <button onclick="this.parentElement.remove()" class="ml-2 text-white/80 hover:text-white">
                    <i class="fas fa-times"></i>
                </button>
            `;
            
            toastContainer.appendChild(toast);
            
            // Animate in
            setTimeout(() => {
                toast.classList.remove('translate-x-full');
            }, 100);
            
            // Auto remove after 5 seconds
            setTimeout(() => {
                toast.classList.add('translate-x-full');
                setTimeout(() => toast.remove(), 300);
            }, 5000);
        }

        // Auto-hide alerts after 5 seconds
        setTimeout(() => {
            const alerts = document.querySelectorAll('#errorAlert, #successAlert');
            alerts.forEach(alert => {
                alert.style.transition = 'opacity 0.5s ease-out';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            });
        }, 5000);

        // Add focus effects
        document.querySelectorAll('input').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('ring-2', 'ring-bnn-primary/20');
                this.classList.remove('input-error');
            });

            input.addEventListener('blur', function() {
                this.parentElement.classList.remove('ring-2', 'ring-bnn-primary/20');
            });
        });

        // Clear errors on input
        document.querySelectorAll('input').forEach(input => {
            input.addEventListener('input', function() {
                clearFieldErrors();
                hideError();
            });
        });

        // Hide loading on page load (if redirected back due to errors)
        window.addEventListener('load', function() {
            hideLoading();
        });
    </script>
</body>

</html>