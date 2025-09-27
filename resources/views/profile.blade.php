{{-- resources/views/profile.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Profil • Mini Commerce</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    .glass{background:rgba(255,255,255,.78);backdrop-filter:blur(16px) saturate(140%)}
    .shadow-soft{box-shadow:0 20px 60px rgba(0,0,0,.15)}
  </style>
</head>
<body class="min-h-screen bg-emerald-700/20 relative">
  {{-- BG --}}
  <div class="fixed inset-0 -z-10">
    <img src="{{ asset('images/bg-login.jpg') }}" class="w-full h-full object-cover" alt="">
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm"></div>
  </div>

  <div class="max-w-3xl mx-auto px-4 py-10">
    {{-- Header --}}
    <div class="text-center mb-6">
      <div class="mx-auto w-16 h-16 rounded-full bg-emerald-500 flex items-center justify-center shadow-soft">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A9 9 0 1118.88 6.196M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
        </svg>
      </div>
      <h1 class="mt-3 text-3xl font-extrabold text-white drop-shadow">Profil Pengguna</h1>
      <p class="text-emerald-100">Kelola informasi akun Anda</p>
    </div>

    @if (session('success'))
      <div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 text-emerald-800 px-4 py-3 text-sm">
        {{ session('success') }}
      </div>
    @endif

    {{-- Card profil --}}
    <div class="glass rounded-2xl ring-1 ring-white/40 shadow-soft p-6 sm:p-8">
      <div class="flex flex-col sm:flex-row sm:items-center gap-6">
        {{-- Avatar inisial --}}
        <div class="shrink-0">
          @php
            $initials = collect(explode(' ', auth()->user()->name ?? 'User'))
              ->map(fn($p) => mb_substr($p,0,1))
              ->take(2)->implode('');
          @endphp
          <div class="w-20 h-20 rounded-full bg-emerald-600 text-white flex items-center justify-center text-2xl font-bold">
            {{ $initials }}
          </div>
        </div>

        <div class="flex-1 space-y-1">
          <h2 class="text-2xl font-bold text-gray-900">{{ auth()->user()->name }}</h2>
          <p class="text-gray-600">
            <span class="font-medium text-gray-700">Username:</span> {{ auth()->user()->username ?? '—' }}
          </p>
          <p class="text-gray-600">
            <span class="font-medium text-gray-700">Email:</span> {{ auth()->user()->email }}
          </p>
          <p class="text-gray-600">
            <span class="font-medium text-gray-700">Bergabung:</span>
            {{ optional(auth()->user()->created_at)->translatedFormat('d F Y') }}
          </p>
        </div>

        <div class="sm:self-start">
          <a href="{{ route('user.profile.edit') }}"
             class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 text-white font-semibold px-4 py-2 hover:bg-emerald-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M11 5h2m-7 7h8m-8 4h8M15.232 5.232l1.536-1.536a2.182 2.182 0 113.086 3.086L9 18l-4 1 1-4 9.232-9.768z"/>
            </svg>
            Edit Profil
          </a>
        </div>
      </div>

      <div class="mt-6 border-t pt-6 flex flex-wrap gap-3">
        <a href="{{ route('user.change-password') }}"
           class="inline-flex items-center gap-2 text-emerald-700 hover:text-emerald-800 font-medium">
          <i class="fa-solid fa-key"></i> Ubah Kata Sandi
        </a>
        <a href="{{ route('dashboard') }}"
           class="inline-flex items-center gap-2 text-gray-700 hover:text-gray-900 font-medium">
          <i class="fa-solid fa-gauge"></i> Kembali ke Dashboard
        </a>
      </div>
    </div>
  </div>
</body>
</html>
