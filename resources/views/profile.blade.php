<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Profil Pengguna — TumbasLek Mini Commerce</title>

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
      <div class="mx-auto max-w-7xl px-6">
          <div class="py-6 text-gray-800">
              <h1 class="text-2xl font-bold">Profil Saya</h1>
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

                      <form action="{{ route('user.profile.update') }}" method="POST" class="p-6">
                          @csrf
                          @method('PUT')

                          @if(session('success'))
                              <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4">
                                  <div class="flex">
                                      <svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                          <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                      </svg>
                                      <p class="ml-3 text-sm text-green-700">{{ session('success') }}</p>
                                  </div>
                              </div>
                          @endif

                          @if ($errors->any())
                              <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                                  <ul class="list-disc list-inside text-sm text-red-700">
                                      @foreach ($errors->all() as $error)
                                          <li>{{ $error }}</li>
                                      @endforeach
                                  </ul>
                              </div>
                          @endif

                          <div class="grid grid-cols-12 items-center gap-y-6">
                              <dt class="col-span-12 md:col-span-4 text-gray-600">Nama Pengguna</dt>
                              <dd class="col-span-12 md:col-span-8">
                                  <input type="text" name="name" value="{{ old('name', $user->name) }}" 
                                         class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                              </dd>

                              <dt class="col-span-12 md:col-span-4 text-gray-600">Email</dt>
                              <dd class="col-span-12 md:col-span-8">
                                  <input type="email" name="email" value="{{ old('email', $user->email) }}" 
                                         class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                              </dd>

                              <dt class="col-span-12 md:col-span-4 text-gray-600">Nomor HP</dt>
                              <dd class="col-span-12 md:col-span-8">
                                  <input type="tel" name="nomor_hp" value="{{ old('nomor_hp', $user->nomor_hp) }}" 
                                         pattern="[0-9]{10,13}" placeholder="08123456789"
                                         class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                                  <p class="mt-1 text-xs text-gray-500">Format: 10-13 digit angka</p>
                              </dd>

                              <dt class="col-span-12 md:col-span-4 text-gray-600 self-start">Alamat Default</dt>
                              <dd class="col-span-12 md:col-span-8">
                                  <textarea name="alamat_default" rows="4" placeholder="Masukkan alamat lengkap Anda (opsional)"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 resize-none">{{ old('alamat_default', $user->alamat_default) }}</textarea>
                                  <p class="mt-1 text-xs text-gray-500">Alamat ini akan otomatis terisi saat checkout</p>
                              </dd>
                          </div>

                          <div class="mt-8 flex justify-end gap-4">
                              <button type="button" onclick="window.location.reload()" 
                                      class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                  Batal
                              </button>
                              <button type="submit" 
                                      class="px-6 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                                  Simpan Perubahan
                              </button>
                          </div>
                      </form>
                  </div>
              </main>
          </div>
      </div>
  </div>

  {{-- FOOTER kamu --}}
  @include('components.footer')

</body>
</html>
