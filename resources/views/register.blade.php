<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Mini Commerce</title>
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
        .input-focus:focus { box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1); }
    </style>
</head>
<body class="relative min-h-screen overflow-x-hidden overflow-y-auto flex items-center justify-center py-8 px-4">
  <!-- BG -->
  <div class="fixed inset-0 -z-10 overflow-hidden">
    <div class="absolute inset-0 bg-cover bg-center"
         style="background-image:url('/images/bg-login.jpg'); filter:blur(8px) brightness(1.0);transform:scale(1.05);">
    </div>
    <div class="absolute inset-0 bg-black/35"></div>
  </div>

  <!-- Konten -->
  <div class="relative z-10 w-full max-w-md">
    <!-- Brand -->
    <div class="text-center mb-8">
      <div class="inline-flex items-center justify-center w-16 h-16 bg-white rounded-full shadow-lg mb-4">
        <i class="fas fa-shopping-cart text-2xl text-[#82D2BC]"></i>
      </div>
      <h1 class="text-4xl font-extrabold text-white drop-shadow-[0_4px_16px_rgba(0,0,0,0.45)]">TumbasLek</h1>
      <p class="text-emerald-100">Bergabunglah dengan kami!</p>
    </div>

    <!-- Form -->
    <div class="glass-effect rounded-2xl shadow-xl p-8">
      <div class="text-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-2">Buat Akun Baru</h2>
        <p class="text-gray-600">Daftar untuk memulai berbelanja</p>
      </div>

      @if ($errors->any())
        <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6 rounded-lg">
          <div class="flex">
            <div class="flex-shrink-0">
              <i class="fas fa-exclamation-circle text-red-400"></i>
            </div>
            <div class="ml-3">
              <p class="text-sm text-red-700 font-medium">Ada beberapa masalah dengan input Anda:</p>
              <ul class="mt-2 text-sm text-red-600">
                @foreach ($errors->all() as $error)
                  <li class="flex items-center">
                    <i class="fas fa-dot-circle text-xs mr-2"></i>{{ $error }}
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

      <form action="{{ url('/register') }}" method="POST" class="space-y-6">
        @csrf

        <!-- Nama -->
        <div>
          <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
            <i class="fas fa-user mr-2 text-emerald-500"></i>Nama Lengkap
          </label>
          <div class="relative">
            <input type="text" id="name" name="name" value="{{ old('name') }}"
                   class="w-full px-4 py-3 pl-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 input-focus transition-all duration-200 @error('name') border-red-500 @enderror"
                   placeholder="Masukkan nama lengkap Anda" required>
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
              <i class="fas fa-user text-gray-400"></i>
            </div>
          </div>
          @error('name')
            <p class="mt-1 text-sm text-red-600 flex items-center">
              <i class="fas fa-exclamation-triangle mr-1"></i>{{ $message }}
            </p>
          @enderror
        </div>

        <!-- Email -->
        <div>
          <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
            <i class="fas fa-envelope mr-2 text-emerald-500"></i>Email
          </label>
          <div class="relative">
            <input type="email" id="email" name="email" value="{{ old('email') }}"
                   class="w-full px-4 py-3 pl-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 input-focus transition-all duration-200 @error('email') border-red-500 @enderror"
                   placeholder="contoh@email.com" required>
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
              <i class="fas fa-envelope text-gray-400"></i>
            </div>
          </div>
          @error('email')
            <p class="mt-1 text-sm text-red-600 flex items-center">
              <i class="fas fa-exclamation-triangle mr-1"></i>{{ $message }}
            </p>
          @enderror
        </div>

        <!-- Nomor HP -->
        <div>
          <label for="nomor_hp" class="block text-sm font-medium text-gray-700 mb-2">
            <i class="fas fa-phone mr-2 text-emerald-500"></i>Nomor HP
          </label>
          <div class="relative">
            <input type="tel" id="nomor_hp" name="nomor_hp" value="{{ old('nomor_hp') }}"
                   class="w-full px-4 py-3 pl-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 input-focus transition-all duration-200 @error('nomor_hp') border-red-500 @enderror"
                   placeholder="08123456789" pattern="[0-9]{10,13}" required>
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
              <i class="fas fa-phone text-gray-400"></i>
            </div>
          </div>
          @error('nomor_hp')
            <p class="mt-1 text-sm text-red-600 flex items-center">
              <i class="fas fa-exclamation-triangle mr-1"></i>{{ $message }}
            </p>
          @enderror
          <p class="mt-1 text-xs text-gray-500">Format: 10-13 digit angka (contoh: 08123456789)</p>
        </div>

        <!-- Password -->
        <div>
          <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
            <i class="fas fa-lock mr-2 text-emerald-500"></i>Password
          </label>
          <div class="relative">
            <input type="password" id="password" name="password"
                   class="w-full px-4 py-3 pl-12 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 input-focus transition-all duration-200 @error('password') border-red-500 @enderror"
                   placeholder="Minimal 8 karakter" required>
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
              <i class="fas fa-lock text-gray-400"></i>
            </div>
            <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center" onclick="togglePassword('password')">
              <i class="fas fa-eye text-gray-400 hover:text-gray-600" id="toggleIconPassword"></i>
            </button>
          </div>
          @error('password')
            <p class="mt-1 text-sm text-red-600 flex items-center">
              <i class="fas fa-exclamation-triangle mr-1"></i>{{ $message }}
            </p>
          @enderror
        </div>

        <!-- Konfirmasi Password -->
        <div>
          <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
            <i class="fas fa-lock mr-2 text-emerald-500"></i>Konfirmasi Password
          </label>
          <div class="relative">
            <input type="password" id="password_confirmation" name="password_confirmation"
                   class="w-full px-4 py-3 pl-12 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 input-focus transition-all duration-200"
                   placeholder="Ulangi password Anda" required>
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
              <i class="fas fa-lock text-gray-400"></i>
            </div>
            <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center" onclick="togglePassword('password_confirmation')">
              <i class="fas fa-eye text-gray-400 hover:text-gray-600" id="toggleIconConfirmation"></i>
            </button>
          </div>
        </div>

            <!-- Terms -->
        <div class="flex items-start">
        <div class="flex items-center h-5">
            <input type="checkbox" id="terms" name="terms"
                class="h-4 w-4 text-emerald-600 focus:ring-emerald-500 border-gray-300 rounded" required>
        </div>
        <div class="ml-3 text-sm">
            <label for="terms" class="text-gray-700">
  Saya setuju dengan
  <a href="{{ route('terms') }}" target="_blank" class="text-emerald-600 hover:text-emerald-500 font-medium">
    Syarat & Ketentuan
  </a>
  dan
  <a href="{{ route('privacy') }}" target="_blank" class="text-emerald-600 hover:text-emerald-500 font-medium">
    Kebijakan Privasi
  </a>
</label>

        </div>
        </div>


        <!-- Submit -->
        <button type="submit"
                class="w-full bg-gradient-to-r from-emerald-600 to-emerald-700 text-white py-3 px-4 rounded-lg font-medium hover:from-emerald-700 hover:to-emerald-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transform hover:scale-105 transition-all duration-200 shadow-lg">
          <i class="fas fa-user-plus mr-2"></i>Daftar Sekarang
        </button>
      </form>

      <!-- Divider -->
      <div class="mt-6">
        <div class="relative">
          <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-gray-300"></div></div>
          <div class="relative flex justify-center text-sm">
            <span class="px-2 bg-white text-gray-500">atau</span>
          </div>
        </div>
      </div>

      <!-- Login link -->
      <div class="mt-6 text-center">
        <p class="text-gray-600">
          Sudah punya akun?
          <a href="{{ url('/login') }}" class="text-emerald-600 hover:text-emerald-500 font-medium ml-1">Masuk di sini</a>
        </p>
      </div>

      <!-- Back to Home -->
      <div class="mt-4 text-center">
        <a href="{{ url('/') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700">
          <i class="fas fa-arrow-left mr-2"></i>Kembali ke Beranda
        </a>
      </div>
    </div>
  </div>

  <script>
    function togglePassword(fieldId) {
      const input = document.getElementById(fieldId);
      const toggleIcon = document.getElementById('toggleIcon' + (fieldId === 'password' ? 'Password' : 'Confirmation'));
      if (input.type === 'password') { input.type = 'text'; toggleIcon.classList.replace('fa-eye','fa-eye-slash'); }
      else { input.type = 'password'; toggleIcon.classList.replace('fa-eye-slash','fa-eye'); }
    }

    // Password strength
    document.getElementById('password').addEventListener('input', function() {
      const password = this.value;
      const container = this.closest('div').parentNode;
      let strength = 0;
      if (password.length >= 8) strength++;
      if (/[a-z]/.test(password)) strength++;
      if (/[A-Z]/.test(password)) strength++;
      if (/[0-9]/.test(password)) strength++;
      if (/[^A-Za-z0-9]/.test(password)) strength++;
      const map = [
        ['Sangat Lemah','text-red-600'],
        ['Lemah','text-orange-600'],
        ['Sedang','text-yellow-600'],
        ['Kuat','text-green-600'],
        ['Sangat Kuat','text-green-700'],
      ];
      const [text,color] = map[Math.max(0, strength-1)];
      let el = document.getElementById('password-strength');
      if (!el) { el = document.createElement('p'); el.id = 'password-strength'; container.appendChild(el); }
      el.className = `mt-1 text-sm flex items-center ${color}`;
      el.innerHTML = `<i class="fas fa-shield-alt mr-1"></i>Kekuatan Password: ${text}`;
    });
  </script>
</body>
</html>
