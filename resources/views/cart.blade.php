{{-- resources/views/cart.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Keranjang • TokoKami</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800">

  {{-- Pakai navbar kamu (opsional) --}}
  {{-- @include('components.navbar') --}}

  <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    {{-- Breadcrumb + Kosongkan --}}
    <div class="flex items-center justify-between mb-4">
      <nav class="text-sm text-gray-500">
        <a href="{{ route('home') }}" class="hover:text-emerald-600">Beranda</a>
        <span class="mx-2">/</span>
        <span class="text-gray-700 font-medium">Keranjang</span>
      </nav>
      <form method="POST" action="{{ route('cart.dummy') }}">
        @csrf
        <button class="text-sm text-red-600 hover:text-red-700 font-medium">
          Kosongkan Keranjang
        </button>
      </form>
    </div>

    @php
      // Ambil items dari session (atau kirimkan dari controller)
      // Contoh struktur item:
      // ['id'=>1,'name'=>'Keripik Balado','price'=>15000,'quantity'=>2,'image'=>'/images/p1.jpg','variant'=>'Pedas 100g']
      $items = $items ?? session('cart.items', []);

      // Hitung subtotal tanpa arrow function (aman semua PHP 7.x/8.x)
      $subtotal = 0;
      foreach ($items as $i) {
          $price = isset($i['price']) ? (int)$i['price'] : 0;
          $qty   = isset($i['quantity']) ? (int)$i['quantity'] : 1;
          $subtotal += $price * $qty;
      }
      $shipping = $subtotal > 0 ? 12000 : 0;
      $discount = 0;
      $total = max($subtotal + $shipping - $discount, 0);

      function rupiah_fmt($n){ return 'Rp '.number_format((int)$n,0,',','.'); }
    @endphp

    {{-- State kosong --}}
    @if (empty($items))
      <section class="bg-white rounded-xl shadow p-10 text-center border border-gray-100">
        <div class="w-16 h-16 mx-auto rounded-full bg-gray-100 grid place-items-center">
          <svg class="w-8 h-8 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M5 8l2-3a2 2 0 011.7-1h6.6a2 2 0 011.7 1l2 3M6 8h12l-1 11a2 2 0 01-2 2H9a2 2 0 01-2-2L6 8z"/>
          </svg>
        </div>
        <h1 class="mt-4 text-2xl font-extrabold">Keranjang masih kosong</h1>
        <p class="mt-1 text-gray-600">Yuk pilih produk favoritmu dulu.</p>
        <a href="{{ route('home') }}"
           class="inline-flex items-center gap-2 mt-5 bg-emerald-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-emerald-700">
          Belanja Sekarang
        </a>
      </section>
    @else
      <section class="grid lg:grid-cols-3 gap-6">
        {{-- Daftar item --}}
        <div class="lg:col-span-2 space-y-4">
          @foreach ($items as $item)
            <div class="bg-white rounded-xl shadow p-4 sm:p-5 border border-gray-100 flex gap-4">
              <img src="{{ $item['image'] ?? asset('images/product-placeholder.png') }}"
                   class="w-24 h-24 rounded-lg object-cover"
                   alt="{{ $item['name'] ?? 'Produk' }}">
              <div class="flex-1">
                <div class="flex items-start justify-between gap-3">
                  <div>
                    <h3 class="font-semibold text-gray-900">{{ $item['name'] ?? 'Produk' }}</h3>
                    @if(!empty($item['variant']))
                      <p class="text-sm text-gray-500 mt-0.5">{{ $item['variant'] }}</p>
                    @endif
                  </div>
                  <div class="text-right">
                    <p class="font-semibold text-gray-900">{{ rupiah_fmt($item['price'] ?? 0) }}</p>
                    <p class="text-xs text-gray-400">/ item</p>
                  </div>
                </div>

                <div class="mt-3 flex items-center justify-between">
                  {{-- Qty control (sementara kirim ke dummy) --}}
                  <form method="POST" action="{{ route('cart.dummy') }}" class="flex items-center gap-2">
                    @csrf
                    <button class="w-8 h-8 rounded-md bg-gray-100 text-gray-700 grid place-items-center hover:bg-gray-200" aria-label="Kurangi">−</button>
                    <input value="{{ $item['quantity'] ?? 1 }}" class="w-12 text-center border rounded-md py-1" />
                    <button class="w-8 h-8 rounded-md bg-gray-100 text-gray-700 grid place-items-center hover:bg-gray-200" aria-label="Tambah">+</button>
                  </form>

                  {{-- Hapus (sementara dummy) --}}
                  <form method="POST" action="{{ route('cart.dummy') }}">
                    @csrf
                    <button class="text-sm text-red-600 hover:text-red-700 font-medium">Hapus</button>
                  </form>
                </div>
              </div>
            </div>
          @endforeach
        </div>

        {{-- Ringkasan --}}
        <aside class="bg-white rounded-xl shadow p-5 border border-gray-100 h-max">
          <h2 class="text-lg font-extrabold text-gray-900">Ringkasan Belanja</h2>
          <dl class="mt-4 space-y-2 text-sm">
            <div class="flex items-center justify-between">
              <dt class="text-gray-600">Subtotal</dt>
              <dd class="font-medium">{{ rupiah_fmt($subtotal) }}</dd>
            </div>
            <div class="flex items-center justify-between">
              <dt class="text-gray-600">Ongkos Kirim</dt>
              <dd class="font-medium">{{ $shipping ? rupiah_fmt($shipping) : 'TBD' }}</dd>
            </div>
            @if($discount > 0)
            <div class="flex items-center justify-between">
              <dt class="text-gray-600">Diskon</dt>
              <dd class="font-medium text-emerald-700">-{{ rupiah_fmt($discount) }}</dd>
            </div>
            @endif
            <div class="pt-2 border-t flex items-center justify-between text-base">
              <dt class="font-bold text-gray-900">Total</dt>
              <dd class="font-extrabold text-gray-900">{{ rupiah_fmt($total) }}</dd>
            </div>
          </dl>

          <a href="{{ url('/checkout') }}"
             class="mt-5 w-full inline-flex items-center justify-center bg-emerald-600 text-white px-5 py-3 rounded-lg font-semibold hover:bg-emerald-700">
            Lanjut ke Pembayaran
          </a>

          <p class="mt-3 text-xs text-gray-500">Harga dan ketersediaan bisa berubah sewaktu-waktu saat checkout.</p>
        </aside>
      </section>
    @endif
  </main>
</body>
</html>
