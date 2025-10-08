<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Checkout — TokoKami</title>

  {{-- langsung tailwind tanpa vite --}}
  <script src="https://cdn.tailwindcss.com"></script>
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50 text-gray-900" x-data="{
      shipping: 'dikirim',
      ongkir: 15000,
      subtotal: 70000,
      updateOngkir(){ this.ongkir = this.shipping === 'pickup' ? 0 : 15000 },
      total(){ return this.subtotal + this.ongkir },
      formatIDR(n){ return new Intl.NumberFormat('id-ID',{style:'currency',currency:'IDR'}).format(n) }
  }">

  {{-- Navbar --}}
  @include('components.navbar', ['isAdmin' => false])

  {{-- Header strip --}}
  <div class="bg-emerald-100/60 h-16 w-full rounded-b-2xl"></div>

  {{-- Main --}}
  <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 -mt-8">
    {{-- Header --}}
    <div class="bg-white rounded-2xl shadow-sm border p-6 flex items-center gap-4">
      <img src="{{ asset('images/logo.png') }}" alt="TokoKami" class="w-12 h-12 rounded-full">
      <div>
        <h1 class="text-2xl font-bold">Checkout</h1>
        <p class="text-sm text-gray-500">UMKM Mini-Commerce</p>
      </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-6">
      {{-- Kiri --}}
      <div class="lg:col-span-2 space-y-6">

        {{-- Alamat --}}
        <section class="bg-white border rounded-2xl p-6">
          <h2 class="text-xl font-semibold mb-4">Alamat Pengiriman</h2>
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="sm:col-span-2">
              <label class="block text-sm mb-1 text-gray-700">Nama Lengkap</label>
              <input type="text" placeholder="Masukkan nama Anda"
                     class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
            </div>
            <div class="sm:col-span-2">
              <label class="block text-sm mb-1 text-gray-700">Alamat Lengkap</label>
              <textarea rows="3"
                        class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                        placeholder="Jl. Pahlawan No. 12, Kota, Provinsi, 12345"></textarea>
            </div>
            <div>
              <label class="block text-sm mb-1 text-gray-700">Kota/Kabupaten</label>
              <input type="text" placeholder="Nama Kota/Kabupaten"
                     class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
            </div>
            <div>
              <label class="block text-sm mb-1 text-gray-700">Kode Pos</label>
              <input type="text" placeholder="12345"
                     class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
            </div>
            <div class="sm:col-span-2">
              <label class="block text-sm mb-1 text-gray-700">Nomor Telepon</label>
              <input type="text" placeholder="08xxxxxxxxxx"
                     class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
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
                  <input type="radio" name="pengiriman" value="dikirim" class="text-emerald-600"
                         x-model="shipping" @change="updateOngkir()">
                  <span class="text-gray-700">Dikirim</span>
                  <span class="ml-auto text-sm text-gray-500">Estimasi 1–3 hari</span>
                </label>
                <label class="flex items-center gap-3 p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                  <input type="radio" name="pengiriman" value="pickup" class="text-emerald-600"
                         x-model="shipping" @change="updateOngkir()">
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
                  <input type="radio" name="pembayaran" class="text-emerald-600" checked>
                  <span class="text-gray-700">Transfer Bank</span>
                </label>
                <label class="flex items-center gap-3 p-3 border rounded-lg hover:bg-gray-50 cursor-pointer">
                  <input type="radio" name="pembayaran" class="text-emerald-600">
                  <span class="text-gray-700">COD</span>
                </label>
                <label class="flex items-center gap-3 p-3 border rounded-lg hover:bg-gray-50 cursor-pointer">
                  <input type="radio" name="pembayaran" class="text-emerald-600">
                  <span class="text-gray-700">E-Wallet</span>
                </label>
              </div>
            </div>
          </div>

          <div class="mt-6">
            <label class="block text-sm text-gray-700 mb-1">Catatan untuk Penjual (opsional)</label>
            <textarea rows="2"
                      class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                      placeholder="Contoh: kirim siang, jangan terlalu pedas, dll."></textarea>
          </div>
        </section>
      </div>

      {{-- Kanan --}}
      <aside class="lg:col-span-1">
        <div class="bg-white border rounded-2xl p-6 lg:sticky lg:top-6">
          <h2 class="text-xl font-semibold mb-4">Ringkasan Pesanan</h2>

          <div class="divide-y">
            <div class="py-3 flex justify-between">
              <div>
                <div class="font-medium">Cimol Bojot</div>
                <div class="text-sm text-gray-500">Jumlah: 1</div>
              </div>
              <div class="text-gray-700">Rp20.000</div>
            </div>
            <div class="py-3 flex justify-between">
              <div>
                <div class="font-medium">Lumpia Rebung</div>
                <div class="text-sm text-gray-500">Jumlah: 2</div>
              </div>
              <div class="text-gray-700">Rp50.000</div>
            </div>
          </div>

          <dl class="mt-4 space-y-2 text-sm">
            <div class="flex justify-between">
              <dt class="text-gray-600">Subtotal</dt>
              <dd class="text-gray-800" x-text="formatIDR(subtotal)"></dd>
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

          <div class="mt-4">
            <label class="block text-sm text-gray-700 mb-1">Kode Voucher (opsional)</label>
            <div class="flex gap-2">
              <input type="text" placeholder="TOKOKAMIHEMAT"
                     class="flex-1 rounded-lg border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
              <button class="px-3 py-2 rounded-lg border text-sm text-gray-700 hover:bg-gray-50">Terapkan</button>
            </div>
          </div>

          <button class="mt-6 w-full bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-3 rounded-xl shadow-sm">
            Buat Pesanan
          </button>

          <p class="text-[12px] text-gray-500 mt-3">
            Dengan menekan “Buat Pesanan”, Anda menyetujui
            <a href="#" class="text-emerald-600 underline">Syarat & Ketentuan</a>.
          </p>
        </div>
      </aside>
    </div>

    <div class="lg:hidden mt-4 text-xs text-gray-500">
      * Total akan berubah sesuai metode pengiriman.
    </div>
  </div>

  {{-- Footer --}}
  @include('components.footer')
</body>
</html>
