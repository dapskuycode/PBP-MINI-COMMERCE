<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Profil Pengguna — UMKM Mini-Commerce</title>

  {{-- Pakai Tailwind via CDN supaya langsung tampil rapi tanpa build --}}
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-900 antialiased">

  {{-- NAVBAR kamu --}}
  @include('components.navbar')

  @php
      $user = auth()->user();
      $maskedPhone = ($user && ($user->phone ?? null))
          ? str_repeat('*', max(strlen($user->phone) - 2, 0)) . substr($user->phone, -2)
          : '**********23';
  @endphp

  <div class="min-h-screen bg-rose-50">
      {{-- Top bar judul --}}
      <header class="bg-emerald-400">
          <div class="mx-auto max-w-7xl px-6 py-3 flex items-center justify-between">
              <div class="text-white font-semibold text-lg">UMKM Mini-Commerce</div>

              <div class="flex items-center gap-4">
                  <div class="h-9 w-9 rounded-full bg-gray-100 flex items-center justify-center text-gray-600">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor">
                          <path d="M12 12a5 5 0 1 0-5-5 5 5 0 0 0 5 5Zm0 2c-4.33 0-8 2.17-8 4.5V21h16v-2.5C20 16.17 16.33 14 12 14Z"/>
                      </svg>
                  </div>

                  {{-- Logout GET (sesuai web.php kamu) --}}
                  <a href="{{ route('logout') }}"
                     class="rounded-md bg-rose-100 px-4 py-1.5 text-rose-600 text-sm font-medium hover:bg-rose-200">
                      Logout
                  </a>
              </div>
          </div>
      </header>

      <div class="mx-auto max-w-7xl px-6">
          <div class="py-6 text-gray-800">
              <h1 class="text-2xl font-bold">Profil Pengguna</h1>
          </div>

          <div class="grid grid-cols-12 gap-6 pb-12">
              {{-- Sidebar kiri --}}
              <aside class="col-span-12 md:col-span-3">
                  <div class="rounded-xl bg-white shadow-sm p-6">
                      <div class="flex flex-col items-center gap-3">
                          <div class="h-20 w-20 rounded-full bg-gray-200 flex items-center justify-center">
                              <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400" viewBox="0 0 24 24" fill="currentColor">
                                  <path d="M12 12a5 5 0 1 0-5-5 5 5 0 0 0 5 5Zm0 2c-4.33 0-8 2.17-8 4.5V21h16v-2.5C20 16.17 16.33 14 12 14Z"/>
                              </svg>
                          </div>
                          <div class="text-center">
                              <div class="font-semibold">{{ $user->name ?? 'Nama Pengguna' }}</div>
                              <div class="text-sm text-gray-500">{{ $user->email ?? 'email.pengguna@gmail.com' }}</div>
                          </div>
                      </div>

                      <nav class="mt-8 space-y-2">
                          <a href="{{ route('user.profile') }}"
                             class="block rounded-lg px-4 py-2 text-sm font-medium bg-emerald-100 text-emerald-700">
                              Profil Saya
                          </a>
                          @if(!$user->is_admin)
                          <a href="{{ route('orders.index') }}"
                             class="block rounded-lg px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                              Riwayat Pesanan
                          </a>
                          
                            <a href="{{ route('favorites') }}"
                                class="block px-4 py-2 rounded text-sm
                                        {{ request()->routeIs('profile.favorites') ? 'bg-emerald-100 text-emerald-800 font-medium' : 'text-gray-700 hover:bg-gray-100' }}">
                                Produk Favorit
                             </a>
                          @endif
                          <a href="{{ route('user.change-password') }}"
                             class="block rounded-lg px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                              Ubah Password
                          </a>
                      </nav>
                  </div>
              </aside>

              {{-- Konten utama --}}
              <main class="col-span-12 md:col-span-9">
                  <div class="rounded-xl bg-white shadow-sm overflow-hidden">
                      <div class="border-b px-6 py-4">
                          <h2 class="text-lg font-semibold">Informasi Akun</h2>
                      </div>

                      <div class="p-6">
                          <dl class="grid grid-cols-12 items-center gap-y-6">
                              <dt class="col-span-12 md:col-span-4 text-gray-600">Username</dt>
                              <dd class="col-span-12 md:col-span-8 font-medium">
                                  {{ $user->username ?? 'username_pengguna' }}
                              </dd>

                              <dt class="col-span-12 md:col-span-4 text-gray-600">Nama Pengguna</dt>
                              <dd class="col-span-12 md:col-span-8 flex items-center gap-3">
                                  <span class="font-medium">{{ $user->name ?? 'nama pengguna' }}</span>
                                  <a href="{{ route('user.profile.edit') }}"
                                     class="text-emerald-600 text-sm font-semibold hover:underline">Ubah</a>
                              </dd>

                              <dt class="col-span-12 md:col-span-4 text-gray-600">Email</dt>
                              <dd class="col-span-12 md:col-span-8 font-medium">
                                  {{ $user->email ?? 'email.admin@gmail.com' }}
                              </dd>

                              <dt class="col-span-12 md:col-span-4 text-gray-600">Nomor HP</dt>
                              <dd class="col-span-12 md:col-span-8 font-medium">
                                  {{ $maskedPhone }}
                              </dd>

                              <dt class="col-span-12 md:col-span-4 text-gray-600">Jenis Kelamin</dt>
                              <dd class="col-span-12 md:col-span-8">
                                  <div class="flex items-center gap-8">
                                      <label class="inline-flex items-center gap-2">
                                          <input type="radio" class="h-4 w-4"
                                                 @checked(($user->gender ?? null) === 'male') disabled>
                                          <span>Laki-laki</span>
                                      </label>
                                      <label class="inline-flex items-center gap-2">
                                          <input type="radio" class="h-4 w-4"
                                                 @checked(($user->gender ?? null) === 'female') disabled>
                                          <span>Perempuan</span>
                                      </label>
                                  </div>
                              </dd>
                          </dl>
                      </div>
                  </div>
              </main>
          </div>
      </div>
  </div>

  {{-- FOOTER kamu --}}
  @include('components.footer')

</body>
</html>
