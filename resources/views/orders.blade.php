{{-- resources/views/orders/index.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Riwayat Pesanan — TokoKami</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50 flex flex-col min-h-screen">
  {{-- Navbar --}}
  @include('components.navbar', ['isAdmin' => false])

  {{-- Main Content --}}
  <main class="flex-1">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

      {{-- Alert Messages --}}
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
      <div class="bg-white rounded-xl shadow-md p-6 flex items-center gap-4 mb-8">
        <div>
          <h1 class="text-2xl font-bold text-gray-900">Riwayat Pesanan</h1>
          <p class="text-sm text-gray-500">Pantau status dan riwayat pesanan Anda</p>
        </div>
      </div>

      {{-- Stats Cards --}}
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-md p-6 text-center">
          <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mx-auto mb-3">
            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
            </svg>
          </div>
          <h3 class="text-lg font-semibold text-gray-900">Processing</h3>
          <p class="text-3xl font-bold text-blue-600" id="processing-count">0</p>
        </div>

        <div class="bg-white rounded-xl shadow-md p-6 text-center">
          <div class="w-12 h-12 bg-cyan-100 rounded-lg flex items-center justify-center mx-auto mb-3">
            <svg class="w-6 h-6 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
            </svg>
          </div>
          <h3 class="text-lg font-semibold text-gray-900">Shipped</h3>
          <p class="text-3xl font-bold text-cyan-600" id="shipped-count">0</p>
        </div>

        <div class="bg-white rounded-xl shadow-md p-6 text-center">
          <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mx-auto mb-3">
            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
          </div>
          <h3 class="text-lg font-semibold text-gray-900">Completed</h3>
          <p class="text-3xl font-bold text-green-600" id="completed-count">0</p>
        </div>
      </div>

      {{-- Orders Section --}}
      <div class="bg-white rounded-xl shadow-md p-6" x-data="ordersPage()">

        {{-- Pills kategori menyamping (tanpa pending) --}}
        <div class="flex flex-wrap gap-3 mb-6">
          <template x-for="t in tabs" :key="t.key">
            <button
              @click="setActive(t.key)"
              class="inline-flex items-center gap-2 rounded-full border px-4 py-2 transition"
              :class="activeStatus===t.key
                ? 'bg-emerald-600 text-white border-emerald-600'
                : 'bg-gray-50 text-gray-700 border-gray-200 hover:bg-gray-100'">
              <span x-text="t.label"></span>
              <span class="text-xs font-bold rounded-full px-2 py-0.5"
                    :class="activeStatus===t.key ? 'bg-emerald-500/30 text-white' : 'bg-gray-200 text-gray-700'"
                    x-text="countByStatus(t.key)"></span>
            </button>
          </template>
        </div>

        {{-- Search --}}
        <div class="mb-6">
          <div class="flex items-center gap-3">
            <div class="flex-1 relative">
              <svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
              </svg>
              <input x-model="searchQuery" type="text" placeholder="Cari berdasarkan kode pesanan atau nama produk..."
                     class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
            </div>
            <button @click="searchQuery = ''" class="px-4 py-2 text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200">
              Bersihkan
            </button>
          </div>
        </div>

        {{-- Orders List --}}
        <div class="space-y-4">
          <template x-for="order in filteredOrders()" :key="order.id">
            <div class="bg-gray-50 rounded-lg border border-gray-200 p-4">
              <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                  <div class="w-12 h-12 bg-emerald-100 rounded flex items-center justify-center text-emerald-700 font-semibold text-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                  </div>
                  <div>
                    <div class="font-medium text-lg" x-text="getOrderCode(order)"></div>
                    <div class="text-xs text-gray-500" x-text="formatDate(order.created_at)"></div>
                    <div class="text-xs text-gray-500" x-text="`${order.order_items?.length || 0} item(s)`"></div>
                  </div>
                </div>

                <div class="flex items-center gap-2">
                  <span class="px-3 py-1 rounded-full text-sm" :class="getStatusClass(order.status)" x-text="getStatusLabel(order.status)"></span>
                  <button @click="toggleDetails(order.id)" class="text-sm px-3 py-1 bg-white border rounded hover:bg-gray-50">
                    <span x-text="order.showDetails ? 'Sembunyikan' : 'Detail'"></span>
                  </button>
                </div>
              </div>

              <!-- Order Details (collapsible) -->
              <div x-show="order.showDetails" x-transition class="mt-3">
                <div class="border-t pt-3">
                  <h4 class="font-medium mb-2">Informasi Pengiriman:</h4>
                  <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-600">
                    <div>
                      <strong>Nama Pemesan:</strong> <span x-text="order.nama_pemesan"></span><br>
                      <strong>Alamat:</strong> <span x-text="order.address"></span><br>
                      <strong>Kota:</strong> <span x-text="order.kota"></span> <span x-text="order.kode_pos"></span>
                    </div>
                    <div>
                      <strong>No. HP:</strong> <span x-text="order.nomor_hp"></span><br>
                      <strong>Metode Pengiriman:</strong> <span x-text="order.jenis_pengiriman"></span><br>
                      <strong>Metode Pembayaran:</strong> <span x-text="order.metode_pembayaran"></span>
                    </div>
                  </div>

                  <h4 class="font-medium mt-4 mb-2">Item Pesanan:</h4>
                  <div class="space-y-3">
                    <template x-for="item in getOrderItems(order)" :key="item.id">
                      <div class="flex items-start gap-4 p-4 bg-white rounded-lg border border-gray-200 shadow-sm">
                        <!-- Product Image -->
                        <div class="w-16 h-16 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0">
                          <template x-if="item.product?.photos && item.product.photos.length > 0">
                            <img 
                              :src="`/storage/${item.product.photos[0].url}`" 
                              :alt="item.product?.name || 'Product Image'" 
                              class="w-full h-full object-cover"
                              onerror="this.parentElement.innerHTML='<div class=\'w-full h-full flex items-center justify-center text-gray-400\'><svg class=\'w-8 h-8\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14\'></path></svg></div>'"
                            >
                          </template>
                          <template x-if="!item.product?.photos || item.product.photos.length === 0">
                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                              <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14"></path>
                              </svg>
                            </div>
                          </template>
                        </div>

                        <!-- Product Details -->
                        <div class="flex-1 min-w-0">
                          <div class="font-semibold text-gray-900 mb-1" x-text="item.product?.name || 'Produk tidak tersedia'"></div>

                          <template x-if="item.product?.description">
                            <div class="text-sm text-gray-600 mb-2 truncate" x-text="item.product.description"></div>
                          </template>

                          <div class="flex items-center justify-between">
                            <div class="text-sm text-gray-500">
                              <span class="font-medium">Qty:</span>
                              <span x-text="item.quantity"></span>
                            </div>
                            <div class="text-right">
                              <div class="text-sm text-gray-500">
                                <span x-text="formatIDR(item.price)"></span> × <span x-text="item.quantity"></span>
                              </div>
                              <div class="font-semibold text-blue-600" x-text="formatIDR(item.quantity * item.price)"></div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </template>

                    <!-- No items message -->
                    <template x-if="getOrderItems(order).length === 0">
                      <div class="text-center py-8 text-gray-500">
                        <svg class="w-12 h-12 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2M4 13h2m13-8V4a1 1 0 00-1-1H7a1 1 0 00-1 1v1m8 0V4.5"></path>
                        </svg>
                        <p>Tidak ada item dalam pesanan ini</p>
                      </div>
                    </template>
                  </div>

                  <div class="mt-4 pt-3 border-t flex justify-between items-center">
                    <div class="text-lg font-semibold">
                      Total: <span x-text="formatIDR(order.total)"></span>
                    </div>
                    <div class="flex gap-2">
                      <!-- Tombol Batalkan untuk status processing -->
                      <template x-if="order.status === 'processing'">
                        <button 
                          @click="cancelOrder(order.id)"
                          class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 text-sm font-medium transition-colors"
                          :disabled="order.isUpdating">
                          <span x-show="!order.isUpdating">Batalkan Pesanan</span>
                          <span x-show="order.isUpdating" class="flex items-center">
                            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Membatalkan...
                          </span>
                        </button>
                      </template>

                      <!-- Tombol Pesanan Selesai untuk status shipped -->
                      <template x-if="order.status === 'shipped'">
                        <button 
                          @click="completeOrder(order.id)"
                          class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 text-sm font-medium transition-colors"
                          :disabled="order.isUpdating">
                          <span x-show="!order.isUpdating">Pesanan Selesai</span>
                          <span x-show="order.isUpdating" class="flex items-center">
                            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Menyelesaikan...
                          </span>
                        </button>
                      </template>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </template>

          {{-- Empty State --}}
          <div x-show="filteredOrders().length === 0" class="text-center py-12">
            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
            </svg>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada pesanan ditemukan</h3>
            <p class="text-gray-500 mb-4">Belum ada pesanan sesuai filter yang dipilih</p>
            <a href="{{ route('home') }}" class="inline-flex items-center px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700">
              <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
              </svg>
              Mulai Belanja
            </a>
          </div>
        </div>
      </div>
    </div>
  </main>

  {{-- Footer --}}
  <footer class="mt-auto">
    @include('components.footer')
  </footer>

  <script>
    function ordersPage() {
      return {
        // default tab: Dikemas
        activeStatus: 'processing',
        searchQuery: '',
        orders: @json($orders ?? []),

        // TABS TANPA PENDING
        tabs: [
          { key: 'processing', label: 'Dikemas' },
          { key: 'shipped',    label: 'Sedang Dikirim' },
          { key: 'completed',  label: 'Selesai' },
          { key: 'cancelled',  label: 'Dibatalkan' },
        ],
        setActive(k) { this.activeStatus = k; },

        init() {
          this.orders = this.orders.map(order => ({
            ...order,
            showDetails: false,
            isUpdating: false
          }));
          this.updateStats();
        },

        updateStats() {
          const processingElement = document.getElementById('processing-count');
          const shippedElement    = document.getElementById('shipped-count');
          const completedElement  = document.getElementById('completed-count');
          if (processingElement) processingElement.textContent = this.countByStatus('processing');
          if (shippedElement)    shippedElement.textContent    = this.countByStatus('shipped');
          if (completedElement)  completedElement.textContent  = this.countByStatus('completed');
        },

        countByStatus(status) {
          return this.orders.filter(order => order.status === status).length;
        },

        filteredOrders() {
          let filtered = this.orders;

          // Filter by active tab
          if (this.activeStatus) {
            filtered = filtered.filter(order => order.status === this.activeStatus);
          }

          // Filter by search
          if (this.searchQuery.trim()) {
            const query = this.searchQuery.toLowerCase().trim();
            filtered = filtered.filter(order => {
              const orderCode = `ORD${String(order.id).padStart(4, '0')}`.toLowerCase();
              if (orderCode.includes(query)) return true;
              if (order.order_items && order.order_items.some(item =>
                item.product && item.product.name &&
                item.product.name.toLowerCase().includes(query)
              )) return true;
              return false;
            });
          }
          return filtered;
        },

        getOrderCode(order) {
          return `ORD${String(order.id).padStart(4, '0')}`;
        },

        getStatusClass(status) {
          const classes = {
            'processing': 'bg-blue-100 text-blue-800',
            'shipped'   : 'bg-cyan-100 text-cyan-800',
            'completed' : 'bg-green-100 text-green-800',
            'cancelled' : 'bg-red-100 text-red-800'
          };
          return classes[status] || 'bg-gray-100 text-gray-800';
        },

        getStatusLabel(status) {
          const labels = {
            'processing': 'Dikemas',
            'shipped'   : 'Dikirim',
            'completed' : 'Selesai',
            'cancelled' : 'Dibatalkan'
          };
          return labels[status] || status;
        },

        formatIDR(amount) {
          return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
          }).format(Number(amount) || 0);
        },

        formatDate(dateString) {
          if (!dateString) return '-';
          try {
            const date = new Date(dateString);
            return date.toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' }) +
                   ' • ' + date.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
          } catch (e) {
            return dateString;
          }
        },

        getOrderItems(order) {
          return order.order_items || order.orderItems || [];
        },

        toggleDetails(orderId) {
          const i = this.orders.findIndex(o => o.id === orderId);
          if (i !== -1) this.orders[i].showDetails = !this.orders[i].showDetails;
        },

        async cancelOrder(orderId) {
          if (!confirm('Apakah Anda yakin ingin membatalkan pesanan ini?')) return;
          const i = this.orders.findIndex(o => o.id === orderId);
          if (i === -1) return alert('Pesanan tidak ditemukan');
          this.orders[i].isUpdating = true;

          try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            const res = await fetch(`/orders/${orderId}/cancel`, {
              method: 'PATCH',
              headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken }
            });
            if (!res.ok) throw new Error(`HTTP ${res.status}`);
            const data = await res.json();
            if (!data.success) throw new Error(data.message || 'Gagal membatalkan pesanan');
            this.orders[i].status = 'cancelled';
            this.updateStats();
            alert('Pesanan berhasil dibatalkan');
          } catch (e) {
            console.error(e); alert('Gagal membatalkan pesanan: ' + e.message);
          } finally {
            if (this.orders[i]) this.orders[i].isUpdating = false;
          }
        },

        async completeOrder(orderId) {
          if (!confirm('Apakah Anda yakin pesanan ini sudah selesai?')) return;
          const i = this.orders.findIndex(o => o.id === orderId);
          if (i === -1) return alert('Pesanan tidak ditemukan');
          this.orders[i].isUpdating = true;

          try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            const res = await fetch(`/orders/${orderId}/complete`, {
              method: 'PATCH',
              headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken }
            });
            if (!res.ok) throw new Error(`HTTP ${res.status}`);
            const data = await res.json();
            if (!data.success) throw new Error(data.message || 'Gagal menyelesaikan pesanan');
            this.orders[i].status = 'completed';
            this.updateStats();
            alert('Pesanan berhasil diselesaikan');
          } catch (e) {
            console.error(e); alert('Gagal menyelesaikan pesanan: ' + e.message);
          } finally {
            if (this.orders[i]) this.orders[i].isUpdating = false;
          }
        }
      }
    }
  </script>
</body>
</html>
