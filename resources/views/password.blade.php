{{-- resources/views/password.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lupa Password - TumbasLek Mini Commerce</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    .glass {
      background: rgba(255,255,255,.78);
      backdrop-filter: blur(16px) saturate(100%);
    }
    .shadow-soft { box-shadow: 0 20px 60px rgba(0,0,0,.15); }

    html, body {
      height: 100%;
      overflow: hidden; /* cegah scroll */
    }
  </style>
</head>

<body class="min-h-screen antialiased text-gray-800 bg-emerald-700/20 flex items-center justify-center">

  {{-- Background foto + overlay --}}
  <div class="absolute inset-0 bg-cover bg-center"
     style="background-image: url('/images/bg-login.jpg'); filter: blur(8px) brightness(0.7); transform: scale(1.05);">
    </div>

    <div class="relative z-10 max-w-3xl mx-auto px-4 transform -translate-y-8 md:-translate-y-12">
    {{-- Header brand seperti login --}}
    <div class="pt-10 md:pt-12 text-center">
      <div class="mx-auto w-14 h-14 rounded-full bg-emerald-500 flex items-center justify-center shadow-soft">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l3-8H6.4M7 13L5.4 5M7 13l-2 7h12m-8 0a1 1 0 100-2 1 1 0 000 2zm8 0a1 1 0 100-2 1 1 0 000 2z"/>
        </svg>
      </div>
      <h1 class="mt-3 text-4xl font-extrabold text-white drop-shadow">Mini Commerce</h1>
      <p class="mt-1 text-emerald-100 font-medium">Atur ulang akses akun Anda</p>
    </div>

    {{-- Card --}}
    <div class="mt-6 md:mt-8 glass rounded-2xl shadow-soft ring-1 ring-white/40">
      <div class="px-6 sm:px-10 py-7">
        <h2 class="text-2xl font-semibold text-gray-900 text-center">Lupa Password</h2>
        <p class="mt-1 text-sm text-gray-600 text-center">
          Masukkan email terdaftar, kami akan mengirim tautan untuk mengatur ulang kata sandi.
        </p>

        {{-- Alert sukses --}}
        @if (session('status'))
          <div class="mt-4 rounded-lg border border-emerald-200 bg-emerald-50 text-emerald-800 px-4 py-3 text-sm">
            {{ session('status') }}
          </div>
        @endif

        {{-- Error validasi --}}
        @if ($errors->any())
          <div class="mt-4 rounded-lg border border-red-200 bg-red-50 text-red-700 px-4 py-3 text-sm">
            <ul class="list-disc list-inside space-y-1">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="mt-6 space-y-5">
          @csrf

          {{-- Email --}}
          <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <div class="mt-1 relative">
              <input
                id="email" name="email" type="email" value="{{ old('email') }}" required autocomplete="email"
                placeholder="nama@student.univ.ac.id"
                class="w-full rounded-xl border border-gray-200 bg-white/80 px-4 py-3 pr-11 text-gray-900 placeholder-gray-400 shadow-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
              <div class="pointer-events-none absolute inset-y-0 right-3 flex items-center">
                <svg class="w-5 h-5 text-emerald-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M16 12H8m8-4H8m8 8H8M21 12A9 9 0 113 12a9 9 0 0118 0z" />
                </svg>
              </div>
            </div>
            <p class="mt-1 text-xs text-gray-500">Gunakan email yang terdaftar di Mini Commerce.</p>
          </div>

          {{-- Tombol --}}
          <button
            type="submit"
            class="w-full inline-flex items-center justify-center gap-2 rounded-xl bg-emerald-600 text-white font-semibold py-3 shadow-lg shadow-emerald-200/50 hover:bg-emerald-700 active:scale-[0.99] transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l9 6 9-6M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
