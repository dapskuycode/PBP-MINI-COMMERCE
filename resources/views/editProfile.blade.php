{{-- resources/views/profile/edit.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Edit Profil • Mini Commerce</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    .glass{background:rgba(255,255,255,.78);backdrop-filter:blur(16px) saturate(140%)}
    .shadow-soft{box-shadow:0 20px 60px rgba(0,0,0,.15)}
  </style>
</head>
<body class="min-h-screen bg-emerald-700/20 relative">
  <div class="fixed inset-0 -z-10">
    <img src="{{ asset('images/bg-login.jpg') }}" class="w-full h-full object-cover" alt="">
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm"></div>
  </div>

  <div class="max-w-2xl mx-auto px-4 py-10">
    <div class="text-center mb-6">
      <h1 class="text-3xl font-extrabold text-white drop-shadow">Edit Profil</h1>
      <p class="text-emerald-100">Perbarui informasi akun Anda</p>
    </div>

    @if ($errors->any())
      <div class="mb-4 rounded-lg border border-red-200 bg-red-50 text-red-700 px-4 py-3 text-sm">
        <ul class="list-disc list-inside">
          @foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach
        </ul>
      </div>
    @endif

    <div class="glass rounded-2xl ring-1 ring-white/40 shadow-soft p-6 sm:p-8">
      <form method="POST" action="{{ route('user.profile.update') }}" class="space-y-5">
        @csrf
        @method('PUT')

        <div>
          <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
          <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}"
                 class="mt-1 w-full rounded-xl border border-gray-200 bg-white/90 px-4 py-3 shadow-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500" required>
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700">Username</label>
          <input type="text" name="username" value="{{ old('username', auth()->user()->username) }}"
                 class="mt-1 w-full rounded-xl border border-gray-200 bg-white/90 px-4 py-3 shadow-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                 minlength="3" maxlength="20" pattern="[A-Za-z0-9]+" title="A–Z, a–z, 0–9 saja" required>
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700">Email</label>
          <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}"
                 class="mt-1 w-full rounded-xl border border-gray-200 bg-white/90 px-4 py-3 shadow-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500" required>
        </div>

        <div class="flex items-center justify-between gap-3 pt-2">
          <a href="{{ route('user.profile') }}" class="text-gray-700 hover:text-gray-900 font-medium">Batal</a>
          <button type="submit"
                  class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 text-white font-semibold px-5 py-3 hover:bg-emerald-700">
            <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
          </button>
        </div>
      </form>

      <div class="border-t mt-6 pt-6">
        <p class="text-sm text-gray-600">Ingin mengubah kata sandi?</p>
        <a href="{{ route('user.change-password') }}" class="inline-flex items-center gap-2 mt-2 text-emerald-700 hover:text-emerald-800 font-medium">
          <i class="fa-solid fa-key"></i> Ganti Kata Sandi
        </a>
      </div>
    </div>
  </div>
</body>
</html>
