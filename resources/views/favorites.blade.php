<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Produk Favorit — TumbasLek</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-900">

  @include('components.navbar', ['isAdmin' => false])
  <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-2xl font-bold mb-6">Profil Pengguna</h1>

    <div class="grid lg:grid-cols-4 gap-6">
      {{-- Sidebar kiri (samakan dengan profilmu) --}}
      <aside class="lg:col-span-1">
        <div class="bg-white rounded-2xl shadow border p-6">
          <div class="w-20 h-20 mx-auto rounded-full bg-gray-100 grid place-items-center text-gray-400 mb-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
              <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6.75a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 19.5a7.5 7.5 0 1115 0v.75H4.5v-.75z"/>
            </svg>
          </div>
          <div class="text-center font-semibold">{{ auth()->user()->name ?? 'User' }}</div>
          <div class="text-center text-sm text-gray-500 mb-4">{{ auth()->user()->email ?? '' }}</div>

          <nav class="space-y-1">
            <a href="{{ route('user.profile') }}"
               class="block px-4 py-2 rounded text-sm {{ request()->routeIs('user.profile') ? 'bg-emerald-100 text-emerald-800 font-medium' : 'text-gray-700 hover:bg-gray-100' }}">Profil Saya</a>

            <a href="{{ route('orders.index') }}"
               class="block px-4 py-2 rounded text-sm {{ request()->routeIs('orders.index') ? 'bg-emerald-100 text-emerald-800 font-medium' : 'text-gray-700 hover:bg-gray-100' }}">Riwayat Pesanan</a>

            <a href="{{ route('favorites') }}"
               class="block px-4 py-2 rounded text-sm {{ request()->routeIs('profile.favorites') ? 'bg-emerald-100 text-emerald-800 font-medium' : 'text-gray-700 hover:bg-gray-100' }}">Produk Favorit</a>

            <a href="{{ route('user.change-password') }}"
               class="block px-4 py-2 rounded text-sm {{ request()->routeIs('user.change-password') ? 'bg-emerald-100 text-emerald-800 font-medium' : 'text-gray-700 hover:bg-gray-100' }}">Ubah Password</a>
          </nav>
        </div>
      </aside>

      {{-- Konten kanan --}}
      <section class="lg:col-span-3">
        <div class="bg-white rounded-2xl shadow border p-6">
          <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-semibold">Produk Favorit</h2>
          </div>

          {{-- Tampilan kosong (tanpa dummy) --}}
          @php $favorites = $favorites ?? []; @endphp
          @if(empty($favorites) || count($favorites) === 0)
            <div class="text-center p-10 text-gray-500 border-2 border-dashed rounded-xl">
              Belum ada produk favorit.
              <a href="{{ route('products.index') }}" class="text-emerald-600 hover:underline font-medium">Lihat Produk</a>
            </div>
          @else
            {{-- Kalau nanti sudah ada data, render grid ini --}}
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
              @foreach($favorites as $product)
                <a href="{{ route('products.show', $product) }}" class="bg-white border rounded-2xl shadow-sm hover:shadow-md transition overflow-hidden">
                  @if(!empty($product->image))
                    <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}" class="w-full h-44 object-cover">
                  @else
                    <div class="w-full h-44 grid place-items-center bg-gray-50">
                      <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.2 6h12.4L17 13M7 13H5.4m1.6 6a2 2 0 104 0m6 0a2 2 0 104 0"/>
                      </svg>
                    </div>
                  @endif
                  <div class="p-4">
                    <div class="font-medium truncate">{{ $product->name }}</div>
                    <div class="text-emerald-700 font-bold">Rp {{ number_format((int)($product->price ?? 0), 0, ',', '.') }}</div>
                  </div>
                </a>
              @endforeach
            </div>
          @endif
        </div>
      </section>
    </div>
  </main>

  @include('components.footer')
</body>
</html>
