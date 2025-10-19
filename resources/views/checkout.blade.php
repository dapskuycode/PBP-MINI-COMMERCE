<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Checkout — TumbasLek Mini Commerce</title>
  <link rel="icon" type="image/png" href="{{ asset('images/logoAtas.png') }}?v={{ time() }}">
  <link rel="shortcut icon" href="{{ asset('images/logoAtas.png') }}?v={{ time() }}">
  <link rel="apple-touch-icon" href="{{ asset('images/logoAtas.png') }}?v={{ time() }}">

  {{-- langsung tailwind tanpa vite --}}
  <script src="https://cdn.tailwindcss.com"></script>
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50 text-gray-900" x-data="{
    shipping: 'regular',      // <-- PERUBAHAN 1: Nilai default pengiriman
    ongkir: 15000,          // <-- PERUBAHAN 2: Ongkir awal sesuai default
    updateOngkir(){           // <-- PERUBAHAN 3: Logika update ongkir
        switch(this.shipping) {
            case 'express':
                this.ongkir = 50000;
                break;
            case 'regular':
                this.ongkir = 25000;
                break;
            case 'cargo':
                this.ongkir = 15000;
                break;
            default:
                this.ongkir = 15000;
        }
    },
    total(){ return {{ $total }} + this.ongkir },
    formatIDR(n){ return new Intl.NumberFormat('id-ID',{style:'currency',currency:'IDR', minimumFractionDigits: 0}).format(n) }
}">

  {{-- Navbar --}}
  @include('components.navbar', ['isAdmin' => false])

  {{-- Header strip --}}
  {{-- <div class="bg-emerald-100/60 h-16 w-full rounded-b-2xl"></div> --}}
  <div class="bg-gray-50 h-16 w-full rounded-b-2xl"></div>

  {{-- Main --}}
  <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 -mt-9">
  {{-- <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 -mt-9 mb-20"> --}}
    {{-- Header --}}
    <div class="bg-white rounded-2xl shadow-sm border p-6 flex items-center gap-4">
  <img src="{{ asset('images/logo.png') }}" alt="TumbasLek" class="w-12 h-12 rounded-full">
      <div>
        <h1 class="text-2xl font-bold">Checkout</h1>
        <p class="text-sm text-gray-500">Belanja mudah dan cepat</p>
      </div>
    </div>

    {{-- Error Messages --}}
    @if(session('error'))
      <div class="mt-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
        {{ session('error') }}
      </div>
    @endif

    @if($errors->any())
      <div class="mt-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
        <ul class="list-disc list-inside">
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form action="{{ route('checkout.process') }}" method="POST" class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-6">
      @csrf

      {{-- Kiri --}}
      <div class="lg:col-span-2 space-y-6">
        {{-- Alamat --}}
        <section class="bg-white border rounded-2xl p-6">
          <h2 class="text-xl font-semibold mb-4">Alamat Pengiriman</h2>
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="sm:col-span-2">
              <label class="block text-sm mb-1 text-gray-700">Nama Lengkap</label>
              <input type="text" name="nama_pemesan" placeholder="Masukkan nama Anda" required
                     class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
            </div>

            <div class="sm:col-span-2">
              <label class="block text-sm mb-1 text-gray-700">Alamat Lengkap</label>
              <textarea rows="3" name="address" required placeholder="Jl. Pahlawan No. 12, Kota, Provinsi, 12345"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">{{ Auth::user()->alamat_default }}</textarea>
              @if(Auth::user()->alamat_default)
                <p class="mt-1 text-xs text-emerald-600">Alamat default telah diisi otomatis</p>
              @endif
            </div>

            <div>
              <label class="block text-sm mb-1 text-gray-700">Kota/Kabupaten</label>
              <input type="text" name="kota" placeholder="Nama Kota/Kabupaten" required
                     class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
            </div>

            <div>
              <label class="block text-sm mb-1 text-gray-700">Kode Pos</label>
              <input type="text" name="kode_pos" placeholder="12345" required
                     class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
            </div>

            <div class="sm:col-span-2">
              <label class="block text-sm mb-1 text-gray-700">Nomor Telepon</label>
              <input type="text" name="nomor_hp" placeholder="08xxxxxxxxxx" required
                     value="{{ Auth::user()->nomor_hp }}"
                     class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
            </div>
          </div>
        </section>

        {{-- Metode --}}
        <section class="bg-white border rounded-2xl p-6">
          <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- Pengiriman --}}
            <div>
              <h3 class="text-lg font-semibold mb-3">Metode Pengiriman</h3>
              <div class="space-y-2">
                <label class="flex items-center gap-3 p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                  <input type="radio" name="jenis_pengiriman" value="express" class="text-emerald-600" x-model="shipping" @change="updateOngkir()" required>
                  <div>
                    <div class="text-gray-700 font-medium">Express</div>
                    <div class="text-xs text-gray-500">1–3 hari • <span class="font-semibold">Rp50.000</span></div>
                  </div>
                </label>

                <label class="flex items-center gap-3 p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                  <input type="radio" name="jenis_pengiriman" value="regular" class="text-emerald-600" x-model="shipping" @change="updateOngkir()" required checked>
                  <div>
                    <div class="text-gray-700 font-medium">Regular</div>
                    <div class="text-xs text-gray-500">3–5 hari • <span class="font-semibold">Rp25.000</span></div>
                  </div>
                </label>

                <label class="flex items-center gap-3 p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                  <input type="radio" name="jenis_pengiriman" value="cargo" class="text-emerald-600" x-model="shipping" @change="updateOngkir()" required>
                  <div>
                    <div class="text-gray-700 font-medium">Cargo</div>
                    <div class="text-xs text-gray-500">5–14 hari • <span class="font-semibold">Rp15.000</span></div>
                  </div>
                </label>
              </div>
            </div>

            {{-- Pembayaran --}}
            <div>
              <h3 class="text-lg font-semibold mb-3">Metode Pembayaran</h3>
              <div class="space-y-2">
                <label class="flex items-center gap-3 p-3 border rounded-lg hover:bg-gray-50 cursor-pointer">
                  <input type="radio" name="metode_pembayaran" value="Transfer Bank" class="text-emerald-600" required checked>
                  <span class="text-gray-700">Transfer Bank</span>
                </label>
                <label class="flex items-center gap-3 p-3 border rounded-lg hover:bg-gray-50 cursor-pointer">
                  <input type="radio" name="metode_pembayaran" value="COD" class="text-emerald-600" required>
                  <span class="text-gray-700">COD</span>
                </label>
                <label class="flex items-center gap-3 p-3 border rounded-lg hover:bg-gray-50 cursor-pointer">
                  <input type="radio" name="metode_pembayaran" value="E-Wallet" class="text-emerald-600" required>
                  <span class="text-gray-700">E-Wallet</span>
                </label>
              </div>
            </div>
          </div>

        </section>
      </div>

      {{-- Kanan (Ringkasan) --}}
      <aside class="lg:col-span-1">
        <div class="bg-white border rounded-2xl p-6 lg:sticky lg:top-6">
          <h2 class="text-xl font-semibold mb-4">Ringkasan Pesanan</h2>

          <div class="divide-y">
            @foreach ($cartItems as $item)
              <div class="py-3 flex items-center justify-between gap-3">
                <div class="flex items-center gap-3 min-w-0">
                  <div class="w-14 h-14 bg-gray-100 rounded overflow-hidden flex-shrink-0">
                    @if($item->product->photos && $item->product->photos->count())
                      <img src="{{ asset('storage/' . $item->product->photos->first()->url) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                    @else
                      <svg class="w-6 h-6 text-gray-400 mx-auto my-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16"></path></svg>
                    @endif
                  </div>
                  <div class="min-w-0">
                    <div class="font-medium truncate">{{ $item->product->name }}</div>
                    <div class="text-xs text-gray-500">Jumlah: {{ $item->quantity }}</div>
                  </div>
                </div>
                <div class="text-gray-700 font-medium">
                  Rp{{ number_format($item->quantity * $item->product->price, 0, ',', '.') }}
                </div>
              </div>
            @endforeach
          </div>

          <dl class="mt-4 space-y-2 text-sm">
            <div class="flex justify-between">
              <dt class="text-gray-600">Subtotal</dt>
              <dd class="text-gray-800">Rp{{ number_format($total, 0, ',', '.') }}</dd>
            </div>
            <div class="flex justify-between">
              <dt class="text-gray-600">Ongkos Kirim</dt>
              <dd class="text-gray-800" x-text="formatIDR(ongkir)"></dd>
            </div>
          </dl>

          <div class="border-t mt-4 pt-4 flex justify-between items-center">
            <span class="text-lg font-semibold">Total</span>
            <span class="text-xl font-bold text-gray-900" x-text="formatIDR(total())"></span>
          </div>


          <button type="submit" class="mt-6 w-full bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-3 rounded-xl shadow-sm">
            Buat Pesanan
          </button>

          <p class="text-[12px] text-gray-500 mt-3">
            Dengan menekan “Buat Pesanan”, Anda menyetujui
            <a href="#" class="text-emerald-600 underline">Syarat & Ketentuan</a>.

            {{-- Dengan menekan “Buat Pesanan”, Anda menyetujui 
              <a href="{{ route('terms') }}" class="text-emerald-600 hover:underline" target="_blank">
                Syarat & Ketentuan
              </a>. --}}
          </p>
        </div>
        <input type="hidden" name="total" :value="total()">
      </aside>
    </form>

    {{-- Sticky mobile bar --}}
    <div class="lg:hidden fixed inset-x-0 bottom-0 bg-white border-t p-3 flex items-center justify-between gap-3">
      <div>
        <div class="text-xs text-gray-500">Subtotal</div>
        <div class="font-semibold">
          {{ 'Rp' . number_format($total, 0, ',', '.') }}
        </div>
      </div>

      <button type="button" onclick="document.querySelector('form').submit()"
              class="ml-2 bg-emerald-600 text-white px-5 py-3 rounded-lg font-semibold shadow-sm">
        Buat Pesanan
      </button>
    </div>
  </div>

  {{-- Footer --}}
  @include('components.footer')
</body>
</html>
