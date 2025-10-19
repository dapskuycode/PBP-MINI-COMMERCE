<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Ubah Password — TumbasLek Mini Commerce</title>
  <link rel="icon" type="image/png" href="{{ asset('images/logoAtas.png') }}?v={{ time() }}">
  <link rel="shortcut icon" href="{{ asset('images/logoAtas.png') }}?v={{ time() }}">
  <link rel="apple-touch-icon" href="{{ asset('images/logoAtas.png') }}?v={{ time() }}">
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-emerald-50 via-white to-rose-50 text-gray-900 antialiased">

  @include('components.navbar')

  {{-- Top banner kecil --}}
  <section class="mx-auto max-w-6xl px-4 pt-10">
    <nav class="text-sm text-gray-500">
      <a href="{{ route('user.profile') }}" class="hover:text-emerald-600">Profil</a>
      <span class="mx-2">/</span>
      <span class="text-gray-700 font-medium">Ubah Password</span>
    </nav>
  </section>

  <main class="mx-auto max-w-6xl px-4 pb-20">
    <div class="mx-auto mt-6 grid lg:grid-cols-2 gap-8 items-start">
      {{-- Info card kiri --}}
      <div class="hidden lg:block">
        <div class="rounded-2xl bg-white/70 backdrop-blur shadow-lg p-8 border border-gray-100">
          <div class="flex items-center gap-3 mb-4">
            <div class="h-10 w-10 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center">
              {{-- icon lock --}}
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor"><path d="M12 1a5 5 0 0 0-5 5v3H6a3 3 0 0 0-3 3v6a3 3 0 0 0 3 3h12a3 3 0 0 0 3-3v-6a3 3 0 0 0-3-3h-1V6a5 5 0 0 0-5-5Zm-3 8V6a3 3 0 0 1 6 0v3H9Z"/></svg>
            </div>
            <h2 class="text-lg font-semibold">Tips Password Aman</h2>
          </div>
          <ul class="space-y-2 text-sm text-gray-600">
            <li>• Gunakan frasa unik, bukan kata umum.</li>
            <li>• Campur huruf besar/kecil, angka, dan simbol.</li>
            <li>• Jangan pakai ulang password dari layanan lain.</li>
          </ul>

          {{-- checklist live --}}
          <div class="mt-6">
            <p class="text-sm font-medium text-gray-700 mb-2">Syarat minimal:</p>
            <ul id="reqList" class="space-y-2">
              <li class="flex items-center gap-2 text-sm text-gray-500" data-req="len">
                <span class="h-5 w-5 inline-flex items-center justify-center rounded-full border border-gray-300">–</span>
                Minimal 8 karakter
              </li>
              <li class="flex items-center gap-2 text-sm text-gray-500" data-req="upper">
                <span class="h-5 w-5 inline-flex items-center justify-center rounded-full border border-gray-300">–</span>
                Ada huruf besar
              </li>
              <li class="flex items-center gap-2 text-sm text-gray-500" data-req="lower">
                <span class="h-5 w-5 inline-flex items-center justify-center rounded-full border border-gray-300">–</span>
                Ada huruf kecil
              </li>
              <li class="flex items-center gap-2 text-sm text-gray-500" data-req="num">
                <span class="h-5 w-5 inline-flex items-center justify-center rounded-full border border-gray-300">–</span>
                Ada angka
              </li>
              <li class="flex items-center gap-2 text-sm text-gray-500" data-req="sym">
                <span class="h-5 w-5 inline-flex items-center justify-center rounded-full border border-gray-300">–</span>
                Ada simbol (!@#…)
              </li>
            </ul>
          </div>
        </div>
      </div>

      {{-- Form card kanan --}}
      <div class="w-full">
        <div class="rounded-2xl bg-white shadow-xl p-6 md:p-8 border border-gray-100">
          <div class="flex items-start justify-between">
            <div>
              <h1 class="text-2xl font-bold">Ubah Password</h1>
              <p class="text-sm text-gray-500 mt-1">Pastikan password baru minimal 8 karakter.</p>
            </div>
            <a href="{{ route('user.profile') }}" class="text-sm text-gray-500 hover:text-emerald-600">Kembali</a>
          </div>

          {{-- alert sukses / error --}}
          @if(session('success'))
            <div class="mt-4 p-3 rounded-lg bg-emerald-50 text-emerald-700 border border-emerald-100">
              {{ session('success') }}
            </div>
          @endif
          @if($errors->any())
            <div class="mt-4 p-3 rounded-lg bg-rose-50 text-rose-700 border border-rose-100">
              <ul class="list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          <form action="{{ route('user.change-password.update') }}" method="POST" class="mt-6 space-y-5" id="pwdForm">
            @csrf
            @method('PUT')

            {{-- Password lama --}}
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Password Lama</label>
              <div class="relative">
                <input type="password" name="current_password" id="current_password" required
                       class="w-full rounded-xl border border-gray-300 px-4 py-2.5 pr-11 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                <button type="button" data-toggle="#current_password"
                        class="absolute inset-y-0 right-0 px-3 text-gray-500 hover:text-gray-700">
                  👁
                </button>
              </div>
              @error('current_password') <p class="text-sm text-rose-600 mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Password baru + meter --}}
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
              <div class="relative">
                <input type="password" name="password" id="password" required
                       class="w-full rounded-xl border border-gray-300 px-4 py-2.5 pr-11 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                <button type="button" data-toggle="#password"
                        class="absolute inset-y-0 right-0 px-3 text-gray-500 hover:text-gray-700">
                  👁
                </button>
              </div>

              {{-- strength meter --}}
              <div class="mt-2">
                <div class="h-2 w-full rounded-full bg-gray-100 overflow-hidden">
                  <div id="strengthBar" class="h-2 w-0 rounded-full transition-all duration-300"></div>
                </div>
                <div id="strengthLabel" class="text-xs mt-1 text-gray-500">Kekuatan: –</div>
              </div>
              @error('password') <p class="text-sm text-rose-600 mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Konfirmasi --}}
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password Baru</label>
              <div class="relative">
                <input type="password" name="password_confirmation" id="password_confirmation" required
                       class="w-full rounded-xl border border-gray-300 px-4 py-2.5 pr-11 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                <button type="button" data-toggle="#password_confirmation"
                        class="absolute inset-y-0 right-0 px-3 text-gray-500 hover:text-gray-700">
                  👁
                </button>
              </div>
              <p id="matchHint" class="text-xs mt-1 text-gray-500">Ketik ulang sama persis.</p>
            </div>

            <div class="flex items-center gap-3 pt-2">
              <a href="{{ route('user.profile') }}"
                 class="px-4 py-2 rounded-xl border border-gray-300 hover:bg-gray-50">Batal</a>

              <button type="submit" id="saveBtn"
                      class="px-5 py-2.5 rounded-xl bg-emerald-600 text-white font-semibold shadow hover:bg-emerald-700 disabled:opacity-50 disabled:cursor-not-allowed">
                Simpan Perubahan
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </main>

  @include('components.footer')

  {{-- Tiny JS: toggle visibility + strength meter + match hint --}}
  <script>
    // Toggle eye
    document.querySelectorAll('[data-toggle]').forEach(btn => {
      btn.addEventListener('click', () => {
        const input = document.querySelector(btn.getAttribute('data-toggle'));
        input.type = input.type === 'password' ? 'text' : 'password';
      });
    });

    const pwd = document.getElementById('password');
    const confirmPwd = document.getElementById('password_confirmation');
    const bar = document.getElementById('strengthBar');
    const label = document.getElementById('strengthLabel');
    const reqList = document.getElementById('reqList');
    const saveBtn = document.getElementById('saveBtn');
    const matchHint = document.getElementById('matchHint');

    function assessStrength(v) {
      const checks = {
        len: v.length >= 8,
        upper: /[A-Z]/.test(v),
        lower: /[a-z]/.test(v),
        num: /[0-9]/.test(v),
        sym: /[^A-Za-z0-9]/.test(v)
      };
      // update checklist
      Object.keys(checks).forEach(key => {
        const li = reqList.querySelector(`[data-req="${key}"]`);
        const badge = li.querySelector('span');
        if (checks[key]) {
          li.classList.remove('text-gray-500'); li.classList.add('text-emerald-700');
          badge.textContent = '✓';
          badge.classList.remove('border-gray-300'); badge.classList.add('border-emerald-300','bg-emerald-50','text-emerald-700');
        } else {
          li.classList.add('text-gray-500'); li.classList.remove('text-emerald-700');
          badge.textContent = '–';
          badge.classList.add('border-gray-300'); badge.classList.remove('border-emerald-300','bg-emerald-50','text-emerald-700');
        }
      });

      const score = Object.values(checks).filter(Boolean).length;
      const percent = (score/5)*100;
      bar.style.width = percent + '%';
      if (score <= 2) { bar.style.backgroundColor = '#ef4444'; label.textContent = 'Kekuatan: Lemah'; }
      else if (score === 3) { bar.style.backgroundColor = '#f59e0b'; label.textContent = 'Kekuatan: Cukup'; }
      else if (score === 4) { bar.style.backgroundColor = '#10b981'; label.textContent = 'Kekuatan: Kuat'; }
      else { bar.style.backgroundColor = '#059669'; label.textContent = 'Kekuatan: Sangat Kuat'; }

      return score >= 3; // minimal cukup agar tombol tidak abu-abu
    }

    function validateAll() {
      const strong = assessStrength(pwd.value);
      const match = pwd.value && (pwd.value === confirmPwd.value);
      matchHint.textContent = match ? 'Cocok ✅' : 'Ketik ulang sama persis.';
      matchHint.className = 'text-xs mt-1 ' + (match ? 'text-emerald-600' : 'text-gray-500');
      // enable submit kalau kuat & cocok
      saveBtn.disabled = !(strong && match);
    }

    pwd.addEventListener('input', validateAll);
    confirmPwd.addEventListener('input', validateAll);
    validateAll(); // init
  </script>
</body>
</html>
