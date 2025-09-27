{{-- resources/views/profile/change-password.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Ganti Password • Mini Commerce</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    .glass{background:rgba(255,255,255,.78);backdrop-filter:blur(16px) saturate(140%)}
  </style>
</head>
<body class="min-h-screen bg-emerald-700/20 relative">
  <div class="fixed inset-0 -z-10">
    <img src="{{ asset('images/bg-login.jpg') }}" class="w-full h-full object-cover" alt="">
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm"></div>
  </div>

  <div class="max-w-md mx-auto px-4 py-10">
    <div class="text-center mb-6">
      <h1 class="text-3xl font-extrabold text-white drop-shadow">Ganti Kata Sandi</h1>
      <p class="text-emerald-100">Pastikan kata sandi baru kuat & aman</p>
    </div>

    @if ($errors->any())
      <div class="mb-4 rounded-lg border border-red-200 bg-red-50 text-red-700 px-4 py-3 text-sm">
        <ul class="list-disc list-inside">
          @foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach
        </ul>
      </div>
    @endif

    <div class="glass rounded-2xl ring-1 ring-white/40 p-6 sm:p-8">
      <form method="POST" action="{{ route('user.change-password.update') }}" class="space-y-5">
        @csrf
        @method('PUT')

        <div>
          <label class="block text-sm font-medium text-gray-700">Password Saat Ini</label>
          <input type="password" name="current_password"
                 class="mt-1 w-full rounded-xl border border-gray-200 bg-white/90 px-4 py-3 shadow-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500" required>
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700">Password Baru</label>
          <input type="password" name="password"
                 class="mt-1 w-full rounded-xl border border-gray-200 bg-white/90 px-4 py-3 shadow-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500" required>
          <p class="text-xs text-gray-500 mt-1">Minimal 8 karakter, disarankan kombinasi huruf besar, kecil, angka, simbol.</p>
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700">Konfirmasi Password Baru</label>
          <input type="password" name="password_confirmation"
                 class="mt-1 w-full rounded-xl border border-gray-200 bg-white/90 px-4 py-3 shadow-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500" required>
        </div>

        <div class="flex items-center justify-between gap-3 pt-2">
          <a href="{{ route('user.profile') }}" class="text-gray-700 hover:text-gray-900 font-medium">Batal</a>
          <button type="submit"
                  class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 text-white font-semibold px-5 py-3 hover:bg-emerald-700">
            <i class="fa-solid fa-key"></i> Ubah Password
          </button>
        </div>
      </form>
    </div>
  </div>
</body>
</html>
