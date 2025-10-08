{{-- resources/views/checkout.blade.php --}}
@php
  // contoh data cart (ambil dari session/db kalau sudah ada)
  $cartItems = session('cart.items', [
      ['name' => 'Cimol Bojot', 'qty' => 1, 'price' => 20000],
      ['name' => 'Lumpia Rebung', 'qty' => 2, 'price' => 25000],
  ]);
  $subtotal = collect($cartItems)->sum(fn($i) => $i['qty'] * $i['price']);
@endphp

<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Checkout Pesanan — TokoKami</title>
  @vite('resources/css/app.css')
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50 text-gray-900">

  {{-- Navbar --}}
  @include('components.navbar', ['isAdmin' => false])

  {{-- Header strip --}}
  <div class="bg-emerald-100/60 h-16 w-full rounded-b-2xl"></div>

  <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 -mt-8"
       x-data="checkout({
          subtotal: {{ $subtotal }},
          shippingMethod: 'dikirim',
          shippingCost: 15000,
          items: @js($cartItems),
       })">

    {{-- Header card --}}
    <div class="bg-white rounded-2xl shadow-sm border p-6 flex items-center gap-4">
      <img src="{{ asset('images/logo.png') }}" alt="TokoKami" class="w-12 h-12 rounded-full">
      <div>
        <h1 class="text-2xl font-bold">Checkout</h1>
        <p class="text-sm text-gray-500">UMKM Mini-Commerce</p>
      </div>
    </div>

    {{-- Alerts --}}
    @if ($errors->any())
      <div class="mt-4 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
        <div class="font-semibold mb-1">Ada yang perlu dicek:</div>
        <ul class="list-disc pl-5 space-y-0.5">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    {{-- Form --}}
    <form action="{{ route('checkout.store') }}" method="POST"
          class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-6">
      @csrf

      {{-- Kiri --}}
      <div class="lg:col-span-2 space-y-6">
        {{-- Alamat --}}
        <section class="bg-white border rounded-2xl p-6">
          <h2 class="text-xl font-semibold mb-4">Alamat Pengiriman</h2>
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="sm:col-span-2">
              <label class="block text-sm text-gray-700 mb-1">Nama Lengkap</label>
              <input name="name" value="{{ old('name', auth()->user()->name ?? '') }}" required
                     class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                     placeholder="Masukkan nama Anda">
            </div>
            <div class="sm:col-span-2">
              <label class="block text-sm text-gray-700 mb-1">Alamat Lengkap</label>
              <textarea name="address" rows="3" required
                        class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                        placeholder="Jl. Pahlawan No. 12, Kota, Provinsi, 12345">{{ old('address') }}</textarea>
            </div>
            <div>
              <label class="block text-sm text-gray-700 mb-1">Kota/Kabupaten</label>
              <input name="city" value="{{ old('city') }}" required
                     class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                     placeholder="Nama Kota/Kabupaten">
            </div>
            <div>
              <label class="block text-sm text-gray-700 mb-1">Kode Pos</label>
              <input name="postal_code" value="{{ old('postal_code') }}" required
                     class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                     placeholder="12345">
            </div>
            <div class="sm:col-span-2">
              <label class="block text-sm text-gray-700 mb-1">Nomor Telepon</label>
              <input name="phone" value="{{ old('phone') }}" required
                     class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                     placeholder="08xxxxxxxxxx">
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
                <label class="flex items-center gap-3 p-3 border rounded-lg hover:bg-gray-50 cursor-pointer">
                  <input type="radio" name="shipping_method" value="dikirim" class="text-emerald-600"
                         x-model="shippingMethod" @change="updateShipping()">
                  <span class="text-gray-700">Dikirim</span>
                  <span class="ml-auto text-sm text-gray-500">Estimasi 1–3 hari</span>
                </label>
                <label class="flex items-center gap-3 p-3 border rounded-lg hover:bg-gray-50 cursor-pointer">
                  <input type="radio" name="shipping_method" value="pickup" class="text-emerald-600"
                         x-model="shippingMethod" @change="updateShipping()">
                  <span class="text-gray-700">Ambil di Tempat</span>
                  <span class="ml-auto text-sm text-gray-500">Gratis ongkir</span>
                </label>
              </div>
            </div>

            {{-- Pembayaran --}}
            <div>
              <h3 class="text-lg font-semibold mb-3">Metode Pembayaran</h3>
              <div class="space-y-2">
                <label class="flex items-center gap-3 p-3 border rounded-lg hover:bg-gray-50 cursor-pointer">
                  <input type="radio" name="payment_method" value="transfer" class="text-emerald-600" checked>
                  <span class="text-gray-700">Transfer Bank</span>
                </label>
                <label class="flex items-center gap-3 p-3 border rounded-lg hover:bg-gray-50 cursor-pointer">
                  <input type="radio" name="payment_method" value="cod" class="text-emerald-600">
                  <span class="text-gray-700">COD</span>
                </label>
                <label class="flex items-center gap-3 p-3 border rounded-lg hover:bg-gray-50 cursor-pointer">
                  <input type="radio" name="payment_method" value="ewallet" class="text-emerald-600">
                  <span class="text-gray-700">E-Wallet</span>
                </label>
              </div>
            </div>
          </div>

          {{-- Catatan --}}
          <div class="mt-6">
            <label class="block text-sm text-gray-700 mb-1">Catatan untuk Penjual (opsional)</label>
            <textarea name="note" rows="2"
                      class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                      placeholder="Contoh: jangan terlalu pedas, kurir siang hari, dsb.">{{ old('note') }}</textarea>
          </div>
        </section>
      </div>

      {{-- Kanan: Ringkasan --}}
      <aside class="lg:col-span-1">
        <div class="bg-white border rounded-2xl p-6 lg:sticky lg:top-6">
          <h2 class="text-xl font-semibold mb-4">Ringkasan Pesanan</h2>

          <div class="divide-y">
            <template x-for="(it, idx) in items" :key="idx">
              <div class="py-3 flex items-start gap-3">
                <div class="flex-1">
                  <div class="font-medium" x-text="it.name"></div>
                  <div class="text-sm text-gray-500">Jumlah: <span x-text="it.qty"></span></div>
                </div>
                <div class="text-right text-gray-700"
                     x-text="formatIDR(it.qty * it.price)"></div>
              </div>
            </template>
          </div>

          <dl class="mt-4 space-y-2 text-sm">
            <div class="flex justify-between">
              <dt class="text-gray-600">Subtotal</dt>
              <dd class="text-gray-800" x-text="formatIDR(subtotal)"></dd>
            </div>
            <div class="flex justify-between">
              <dt class="text-gray-600">Ongkos Kirim</dt>
              <dd class="text-gray-800" x-text="formatIDR(shippingCost)"></dd>
            </div>
          </dl>

          <div class="border-t mt-4 pt-4 flex justify-between items-center">
            <span class="text-lg font-semibold">Total</span>
            <span class="text-xl font-bold text-gray-900" x-text="formatIDR(total())"></span>
          </div>

          {{-- mirrors for server --}}
          <input type="hidden" name="computed_subtotal" :value="subtotal">
          <input type="hidden" name="computed_shipping" :value="shippingCost">
          <input type="hidden" name="computed_total" :value="total()">

          {{-- Voucher --}}
          <div class="mt-4">
            <label class="block text-sm text-gray-700 mb-1">Kode Voucher (opsional)</label>
            <div class="flex gap-2">
              <input name="voucher"
                     class="flex-1 rounded-lg border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                     placeholder="TOKOKAMIHEMAT">
              <button type="button"
                      class="px-3 py-2 rounded-lg border text-sm text-gray-700 hover:bg-gray-50">
                Terapkan
              </button>
            </div>
          </div>

          <button type="submit"
                  class="mt-6 w-full bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-3 rounded-xl shadow-sm">
            Buat Pesanan
          </button>

          <p class="text-[12px] text-gray-500 mt-3">
            Dengan menekan “Buat Pesanan”, Anda menyetujui
            <a href="{{ route('terms') ?? '#' }}" class="text-emerald-600 underline">Syarat & Ketentuan</a>.
          </p>
        </div>
      </aside>
    </form>

    <div class="lg:hidden mt-4 text-xs text-gray-500">
      * Total akan menyesuaikan ketika mengganti metode pengiriman.
    </div>
  </div>

  {{-- Footer --}}
  @include('components.footer')

  <script>
    function checkout(init) {
      return {
        items: init.items || [],
        subtotal: init.subtotal || 0,
        shippingMethod: init.shippingMethod || 'dikirim',
        shippingCost: init.shippingCost || 15000,
        updateShipping() {
          this.shippingCost = (this.shippingMethod === 'pickup') ? 0 : 15000;
        },
        total() { return this.subtotal + this.shippingCost; },
        formatIDR(n) {
          return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(n);
        }
      }
    }
  </script>
</body>
</html>
