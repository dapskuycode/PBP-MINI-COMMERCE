<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - TumbasLek Mini Commerce</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logoAtas.png') }}?v={{ time() }}">
    <link rel="shortcut icon" href="{{ asset('images/logoAtas.png') }}?v={{ time() }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logoAtas.png') }}?v={{ time() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .gradient-bg {
     background: linear-gradient(rgba(130, 210, 188, 0.6), rgba(0, 0, 0, 0.5)), 
                url('/images/bg-login.jpg') no-repeat center center/cover;
    }

        .glass-effect {
            backdrop-filter: blur(16px) saturate(180%);
            -webkit-backdrop-filter: blur(16px) saturate(180%);
            background-color: rgba(255, 255, 255, 0.75);
            border: 1px solid rgba(209, 213, 219, 0.3);
        }
        .input-focus:focus {
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
    </style>
</head>
<body class="relative min-h-screen h-screen overflow-hidden flex items-center justify-center">

    <!-- Background blur (hanya gambar) -->
    <div class="absolute inset-0 bg-cover bg-center"
     style="background-image: url('/images/bg-login.jpg'); filter: blur(8px) brightness(0.7); transform: scale(1.05);">
    </div>

    <!-- Konten (semua form + logo) -->
    <div class="relative z-10 w-full max-w-md">
        
        <!-- Logo/Brand Section -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-white rounded-full shadow-lg mb-4">
                <i class="fas fa-shopping-cart text-2xl text-[#82D2BC]"></i>
            </div>
            <h1 class="text-4xl font-extrabold text-white drop-shadow-[0_4px_16px_rgba(0,0,0,0.45)]">
                TumbasLek
            </h1>
            <p class="text-white/90 drop-shadow-[0_2px_8px_rgba(0,0,0,0.45)]">
            Selamat datang kembali!
            </p>
        </div>

        <!-- Login Form -->
        <div class="glass-effect rounded-2xl shadow-xl p-8">
            <div class="text-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Masuk ke Akun</h2>
                <p class="text-gray-600">Silakan masuk untuk melanjutkan</p>
            </div>

            @if ($errors->any())
                <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6 rounded-lg">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-circle text-red-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-700 font-medium">Ada masalah dengan login Anda:</p>
                            <ul class="mt-2 text-sm text-red-600">
                                @foreach ($errors->all() as $error)
                                    <li class="flex items-center">
                                        <i class="fas fa-dot-circle text-xs mr-2"></i>
                                        {{ $error }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            @if (session('success'))
                <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-6 rounded-lg">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-check-circle text-green-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-green-700">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6 rounded-lg">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-circle text-red-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-700">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ url('/login') }}" class="space-y-6">
                @csrf

                <!-- Email Field -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-envelope mr-2 text-emerald-500"></i>Email
                    </label>
                    <div class="relative">
                        <input type="email"
                               class="w-full px-4 py-3 pl-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 input-focus transition-all duration-200 @error('email') border-red-500 @enderror"
                               id="email"
                               name="email"
                               value="{{ old('email') }}"
                               placeholder="Masukkan email Anda"
                               required>
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-gray-400"></i>
                        </div>
                    </div>
                    @error('email')
                        <p class="mt-1 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-triangle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Password Field -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-lock mr-2 text-emerald-500"></i>Password
                    </label>
                    <div class="relative">
                        <input type="password"
                               class="w-full px-4 py-3 pl-12 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 input-focus transition-all duration-200 @error('password') border-red-500 @enderror"
                               id="password"
                               name="password"
                               placeholder="Masukkan password Anda"
                               required>
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center" onclick="togglePassword()">
                            <i class="fas fa-eye text-gray-400 hover:text-gray-600" id="toggleIcon"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-1 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-triangle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input type="checkbox"
                               class="h-4 w-4 text-emerald-600 focus:ring-emerald-500 border-gray-300 rounded"
                               id="remember"
                               name="remember">
                        <label class="ml-2 block text-sm text-gray-700" for="remember">
                            Ingat saya
                        </label>
                    </div>
                    <a href="{{ route('password.request') }}" class="text-sm text-emerald-600 hover:text-emerald-500 font-medium">
                    Lupa password?
                    </a>
                </div>

                <!-- Login Button -->
                <button type="submit" class="w-full bg-gradient-to-r from-emerald-600 to-emerald-700 text-white py-3 px-4 rounded-lg font-medium hover:from-emerald-700 hover:to-emerald-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transform hover:scale-105 transition-all duration-200 shadow-lg">
                    <i class="fas fa-sign-in-alt mr-2"></i>
                    Masuk Sekarang
                </button>
            </form>

            <!-- Divider -->
            <div class="mt-6">
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white text-gray-500">atau</span>
                    </div>
                </div>
            </div>

            <!-- Register Link -->
            <div class="mt-6 text-center">
                <p class="text-gray-600">
                    Belum punya akun?
                    <a href="{{ url('/register') }}" class="text-emerald-600 hover:text-emerald-500 font-medium ml-1">
                        Daftar di sini
                    </a>
                </p>
            </div>

            <!-- Back to Home -->
            <div class="mt-4 text-center">
                <a href="{{ url('/') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>
