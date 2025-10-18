{{-- resources/views/orders/index.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Riwayat Pesanan — TokoKami</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50">
  {{-- Navbar --}}
  @include('components.navbar', ['isAdmin' => false])

  {{-- Main --}}
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="ordersTabs()">
    {{-- Alert --}}
    @if(session('success'))
      <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4">
        <div class="flex items-center">
          <svg class="w-5 h-5 text-green-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
          </svg>
          <p class="text-green-700 font-medium">{{ session('success') }}</p>
        </div>
      </div>
    @endif

    {{-- Header --}}
    <div class="bg-white rounded-xl shadow-md p-6 flex items-center gap-4 mb-6">
      <img src="{{ asset('images/logo.png') }}" alt="TokoKami" class="w-16 h-16 rounded-full">
      <div>
        <h1 class="text-2xl font-bold text-gray-900">Riwayat Pesanan</h1>
        <p class="text-sm text-gray-500">Pantau status dan riwayat pesanan Anda</p>
      </div>
    </div>

    {{-- Pills kategori (menyamping) --}}
    <div class="bg-white rounded-2xl shadow-md p-3 mb-6">
      <div class="flex flex-wrap gap-3">
        <template x-for="tab in tabs" :key="tab.key">
          <button
            class="group relative inline-flex items-center gap-2 rounded-full border px-4 py-2 transition"
            :class="activeStatus===tab.key
              ? 'bg-emerald-600 text-white border-emerald-600'
              : 'bg-gray-50 text-gray-700 border-gray-200 hover:bg-gray-100'"
            @click="setActive(tab.key)"
          >
            <span x-text="tab.label"></span>
            <span
              class="inline-flex items-center justify-center text-xs font-bold rounded-full w-6 h-6"
              :class="activeStatus===tab.key
                ? 'bg-emerald-500/30 text-white'
                : 'bg-gray-200 text-gray-700'"
              x-text="count(tab.key)"
            ></span>
          </button>
        </template>
      </div>
    </div>

    {{-- Pencarian --}}
    <div class="bg-white rounded-2xl shadow-md p-4 mb-6">
      <div class="flex items-center gap-3">
        <div class="flex-1 relative">
          <svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
          </svg>
          <input x-model="searchQuery" type="text" placeholder="Cari kode pesanan / produk..."
                 class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
        </div>
        <button @click="searchQuery=''"
                class="px-4 py-2 rounded-xl border border-gray-200 text-gray-700 hover:bg-gray-50">
          Bersihkan
        </button>
      </div>
    </div>

    {{-- Daftar pesanan (sesuai tab aktif) --}}
    <div class="bg-white rounded-2xl shadow-md p-4">
      <div class="space-y-4">
        <template x-for="order in filtered()" :key="order.id">
          <div class="bg-gray-50 rounded-xl border border-gray-200 p-4">
            <div class="flex items-center justify-between">
              <div class="flex items-center gap-4">
                <div class="w-11 h-11 bg-emerald-100 rounded-lg flex items-center justify-center text-emerald-700">
                  <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                  </svg>
                </div>
                <div>
                  <div class="font-semibold text-gray-900" x-text="getOrderCode(order)"></div>
                  <div class="text-xs text-gray-500" x-text="formatDate(order.created_at)"></div>
                  <div class="text-xs text-gray-500" x-text="`${getOrderItems(order).length} item(s)`"></div>
                </div>
              </div>

              <div class="flex items-center gap-2">
                <span class="px-3 py-1 rounded-full text-xs"
                      :class="statusClass(order.status)"
                      x-text="statusLabel(order.status)"></span>
                <button @click="order._open=!order._open"
                        class="text-sm px-3 py-1 bg-white border rounded-lg hover:bg-gray-50">
                  <span x-text="order._open ? 'Sembunyikan' : 'Detail'"></span>
                </button>
              </div>
            </div>

            <div x-show="order._open" x-transition class="mt-3">
              <div class="border-t pt-3">
                <h4 class="font-medium mb-2">Informasi Pengiriman</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-600">
                  <div>
                    <strong>Nama Pemesan:</strong> <span x-text="order.nama_pemesan || '-'"></span><br>
                    <strong>Alamat:</strong> <span x-text="order.address || '-'"></span><br>
                    <strong>Kota:</strong> <span x-text="order.kota || '-'"></span>
                    <span x-text="order.kode_pos || ''"></span>
                  </div>
                  <div>
                    <strong>No. HP:</strong> <span x-text="order.nomor_hp || '-'"></span><br>
                    <strong>Pengiriman:</strong> <span x-text="order.jenis_pengiriman || '-'"></span><br>
                    <strong>Pembayaran:</strong> <span x-text="order.metode_pembayaran || '-'"></span>
                  </div>
                </div>

                <h4 class="font-medium mt-4 mb-2">Item Pesanan</h4>
                <div class="space-y-3">
                  <template x-for="item in getOrderItems(order)" :key="item.id">
                    <div class="flex items-start gap-4 p-3 bg-white rounded-lg border">
                      <div class="w-16 h-16 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0">
                        <template x-if="item.product?.photos?.length">
                          <img :src="`/storage/${item.product.photos[0].url}`" class="w-full h-full object-cover">
                        </template>
                      </div>
                      <div class="flex-1 min-w-0">
                        <div class="font-semibold text-gray-900" x-text="item.product?.name || 'Produk tidak tersedia'"></div>
                        <div class="text-xs text-gray-500 mb-1" x-show="item.product?.description" x-text="item.product?.description"></div>
                        <div class="flex items-center justify-between">
                          <div class="text-sm text-gray-600">Qty: <span x-text="item.quantity"></span></div>
                          <div class="text-right">
                            <div class="text-xs text-gray-500">
                              <span x-text="formatIDR(item.price)"></span> × <span x-text="item.quantity"></span>
                            </div>
                            <div class="font-semibold text-blue-600" x-text="formatIDR(item.quantity * item.price)"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </template>

                  <template x-if="getOrderItems(order).length===0">
                    <div class="text-center py-8 text-gray-500 text-sm">Tidak ada item dalam pesanan ini</div>
                  </template>
                </div>

                <div class="mt-4 pt-3 border-t flex justify-between items-center">
                  <div class="text-lg font-semibold">Total</div>
                  <div class="text-lg font-bold" x-text="formatIDR(order.total)"></div>
                </div>
              </div>
            </div>
          </div>
        </template>

        {{-- Empty state --}}
        <div x-show="filtered().length===0" class="text-center py-12">
          <svg class="w-14 h-14 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
          </svg>
          <h3 class="text-lg font-semibold text-gray-900 mb-1">Tidak ada pesanan</h3>
          <p class="text-gray-500">Coba ubah kategori atau kata kunci pencarian</p>
        </div>
      </div>
    </div>
  </div>

  {{-- Footer --}}
  @include('components.footer')

  <script>
    function ordersTabs() {
      return {
        // Data
        searchQuery: '',
        activeStatus: 'pending', // default tab
        orders: @json($orders ?? []),

        // Definisi tab + pemetaan label
        tabs: [
          { key: 'pending',    label: 'Belum Dibayar' },
          { key: 'processing', label: 'Dikemas' },
          { key: 'shipped',    label: 'Sedang Dikirim' },
          { key: 'completed',  label: 'Selesai' },
          { key: 'cancelled',  label: 'Dibatalkan' },
        ],

        init() {
          this.orders = (this.orders || []).map(o => ({ ...o, _open: false }));
        },

        setActive(key) { this.activeStatus = key; },

        // Helpers
        getOrderItems(order) { return order.order_items || order.orderItems || []; },

        getOrderCode(order) { return `ORD${String(order.id).padStart(4,'0')}`; },

        formatIDR(amount) {
          return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 })
            .format(Number(amount) || 0);
        },

        formatDate(s) {
          if (!s) return '-';
          const d = new Date(s);
          if (isNaN(d)) return s;
          return d.toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' }) +
                 ' • ' + d.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
        },

        statusLabel(s) {
          return ({
            pending: 'Belum Dibayar',
            processing: 'Dikemas',
            shipped: 'Sedang Dikirim',
            completed: 'Selesai',
            cancelled: 'Dibatalkan'
          })[s] || s;
        },

        statusClass(s) {
          const map = {
            pending:   'bg-yellow-100 text-yellow-800',
            processing:'bg-blue-100 text-blue-800',
            shipped:   'bg-cyan-100 text-cyan-800',
            completed: 'bg-green-100 text-green-800',
            cancelled: 'bg-red-100 text-red-800'
          };
          return map[s] || 'bg-gray-100 text-gray-800';
        },

        // Filter & hitung
        matchesSearch(order) {
          const q = this.searchQuery.trim().toLowerCase();
          if (!q) return true;
          if (this.getOrderCode(order).toLowerCase().includes(q)) return true;
          return this.getOrderItems(order)?.some(it => it.product?.name?.toLowerCase().includes(q));
        },

        filtered() {
          return (this.orders || [])
            .filter(o => o.status === this.activeStatus)
            .filter(o => this.matchesSearch(o));
        },

        count(statusKey) {
          return (this.orders || []).filter(o => o.status === statusKey).length;
        },
      }
    }
  </script>
</body>
</html>
