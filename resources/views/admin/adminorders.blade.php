<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Admin • TumbasLek</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-50" x-data="ordersData">
    <!-- Bungkus layout menjadi flex agar sidebar dan main sejajar -->
    <div class="min-h-screen flex">
        {{-- Sidebar --}}
      <aside class="w-64 bg-white border-r">
        <div class="p-4 text-center border-b">
          <img src="{{ asset('images/logo.png') }}" alt="TumbasLek" class="mx-auto w-16 mb-2">
          <h1 class="text-lg font-semibold text-emerald-700">TumbasLek</h1>
          <p class="text-xs text-gray-500">UMKM Mini-Commerce</p>
        </div>
        <nav class="p-4 space-y-2 text-sm">
          <a href="{{ route('dashboard') }}"
            class="flex items-center gap-3 px-3 py-2 rounded-lg font-medium 
            {{ request()->routeIs('dashboard') 
                  ? 'bg-emerald-100 text-emerald-700' 
                  : 'text-gray-700 hover:bg-gray-100 hover:text-emerald-700' }}">
            <i class="lucide lucide-home"></i> Dashboard
          </a>

          <a href="{{ route('admin.managecategories.index') }}"
            class="flex items-center gap-3 px-3 py-2 rounded-lg font-medium 
            {{ request()->routeIs('admin.managecategories.index') 
                  ? 'bg-emerald-100 text-emerald-700' 
                  : 'text-gray-700 hover:bg-gray-100 hover:text-emerald-700' }}">
            <i class="lucide lucide-box"></i> Manajemen Produk
          </a>

          <a href="{{ route('admin.manageorders.index') }}"
            class="flex items-center gap-3 px-3 py-2 rounded-lg font-medium 
            {{ request()->routeIs('admin.manageorders.index') 
                  ? 'bg-emerald-100 text-emerald-700' 
                  : 'text-gray-700 hover:bg-gray-100 hover:text-emerald-700' }}">
            <i class="lucide lucide-shopping-bag"></i> Manajemen Pesanan
          </a>

          <a href="{{ route('admin.manageusers.showUsers') }}"
            class="flex items-center gap-3 px-3 py-2 rounded-lg font-medium 
            {{ request()->routeIs('admin.manageusers.showUsers') 
                  ? 'bg-emerald-100 text-emerald-700' 
                  : 'text-gray-700 hover:bg-gray-100 hover:text-emerald-700' }}">
            <i class="lucide lucide-file-chart"></i> Pengguna
          </a>
          <a href="{{ route('logout') }}" class="block px-4 py-2 text-sm text-red-600 hover:bg-red-50">
            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
            </svg>
            Logout
          </a>
        </nav>
      </aside>

          <!-- Konten utama -->
          <main class="flex-1 max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            {{-- Heading --}}
            <div class="bg-white rounded-2xl shadow-sm border p-6 mb-6 flex items-center gap-4">
              <img src="{{ asset('images/logo.png') }}" alt="TumbasLek" class="w-12 h-12 rounded-full">
              <div>
                <h1 class="text-2xl font-bold">Manajemen Pesanan</h1>
                <p class="text-sm text-gray-500">Kelola semua pesanan customer di sini</p>
              </div>
            </div>

            {{-- Tabs Status --}}
            <div class="bg-white rounded-2xl shadow-sm border p-4 mb-6">
              <div class="flex flex-wrap gap-2">
                <button @click="active='dikemas'" :class="tabClass('dikemas')" class="px-4 py-2 rounded-full text-sm border">
                  Dikemas
                  <span class="ml-2 inline-flex items-center justify-center min-w-5 h-5 text-xs rounded-full px-1"
                        :class="badgeClass('dikemas')" x-text="count('dikemas')"></span>
                </button>
                <button @click="active='dikirim'" :class="tabClass('dikirim')" class="px-4 py-2 rounded-full text-sm border">
                  Sedang Dikirim
                  <span class="ml-2 inline-flex items-center justify-center min-w-5 h-5 text-xs rounded-full px-1"
                        :class="badgeClass('dikirim')" x-text="count('dikirim')"></span>
                </button>
                <button @click="active='selesai'" :class="tabClass('selesai')" class="px-4 py-2 rounded-full text-sm border">
                  Selesai
                  <span class="ml-2 inline-flex items-center justify-center min-w-5 h-5 text-xs rounded-full px-1"
                        :class="badgeClass('selesai')" x-text="count('selesai')"></span>
                </button>
                <button @click="active='dibatalkan'" :class="tabClass('dibatalkan')" class="px-4 py-2 rounded-full text-sm border">
                  Dibatalkan
                  <span class="ml-2 inline-flex items-center justify-center min-w-5 h-5 text-xs rounded-full px-1"
                        :class="badgeClass('dibatalkan')" x-text="count('dibatalkan')"></span>
                </button>
              </div>
            </div>
    
            {{-- Search --}}
            <div class="mb-4">
              <div class="bg-white rounded-2xl shadow-sm border p-4 flex items-center gap-3">
                <input x-model="q" type="text" placeholder="Cari kode pesanan / produk…"
                       class="flex-1 rounded-lg border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 px-4 py-2">
                <button @click="q=''" class="text-sm px-3 py-2 rounded-lg border hover:bg-gray-50">Bersihkan</button>
              </div>
            </div>
    
            {{-- List Pesanan --}}
            <section class="space-y-4">
              <template x-for="ord in filtered()" :key="ord.code">
                <article class="bg-white border rounded-2xl p-4 md:p-5 shadow-sm">
                  <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                    <div class="flex items-center gap-3">
                      <div class="w-10 h-10 rounded-xl bg-emerald-100 grid place-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-emerald-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.2 6h12.4L17 13M7 13H5.4m1.6 6a2 2 0 104 0m6 0a2 2 0 104 0"/>
                        </svg>
                      </div>
                      <div>
                        <div class="font-semibold" x-text="`#${ord.code}`"></div>
                        <div class="text-xs text-gray-500" x-text="formatDate(ord.date)"></div>
                      </div>
                    </div>
    
                    <span class="px-3 py-1 rounded-full text-sm" :class="chip(ord.status)" x-text="label(ord.status)"></span>
                  </div>
    
                  <div class="mt-4 border-t pt-4 grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="space-y-1">
                      <div class="text-sm text-gray-500">Customer</div>
                      <div class="text-sm font-medium" x-text="ord.customer"></div>
                      <div class="text-xs text-gray-500" x-text="ord.phone"></div>
                    </div>
                    <div class="space-y-1">
                      <div class="text-sm text-gray-500">Item</div>
                      <ul class="text-sm text-gray-800 list-disc pl-4">
                        <template x-for="it in ord.items" :key="it.name">
                          <li x-text="`${it.name} × ${it.qty}`"></li>
                        </template>
                      </ul>
                    </div>
                    <div class="space-y-1">
                      <div class="text-sm text-gray-500">Total</div>
                      <div class="font-semibold" x-text="formatIDR(ord.total)"></div>
                      <div class="text-xs text-gray-500" x-text="ord.payment_method"></div>
                      <template x-if="ord.status === 'dikirim' && ord.nomor_resi">
                        <div class="text-xs text-blue-600 font-medium">
                          <span class="block">📦 Nomor Resi:</span>
                          <span class="block" x-text="ord.nomor_resi"></span>
                        </div>
                      </template>
                    </div>
                    <div class="flex flex-wrap gap-2 md:justify-end">
                      <template x-if="ord.status==='dikemas'">
                        <button @click="showShipModal(ord)" class="px-4 py-2 rounded-lg bg-purple-600 text-white hover:bg-purple-700 text-sm">Kirim Pesanan</button>
                      </template>
                      <template x-if="ord.status==='dikirim'">
                        <span class="px-4 py-2 rounded-lg bg-blue-100 text-blue-700 text-sm">Sedang Dikirim</span>
                      </template>
                      <template x-if="ord.status==='selesai'">
                        <span class="px-4 py-2 rounded-lg bg-green-100 text-green-700 text-sm">Pesanan Selesai</span>
                      </template>
                      <template x-if="ord.status==='dibatalkan'">
                        <span class="px-4 py-2 rounded-lg bg-red-100 text-red-600 text-sm">Pesanan Dibatalkan</span>
                      </template>
                      <button @click="showDetail(ord)" class="px-4 py-2 rounded-lg border text-sm hover:bg-gray-50">Detail</button>
                    </div>
                  </div>
                </article>
              </template>
    
              {{-- Empty state --}}
              <div x-show="filtered().length===0" class="bg-white border rounded-2xl p-10 text-center text-gray-500">
                Belum ada pesanan pada status ini.
              </div>
            </section>
    
            <div class="h-6"></div>
          </main>
    </div>

    <!-- Modal Detail Pesanan -->
    <div x-show="showModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
      <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div x-show="showModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="closeModal()"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div x-show="showModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
          <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
            <div class="sm:flex sm:items-start">
              <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                <svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
              </div>
              <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                  Detail Pesanan
                </h3>
                <div class="mt-4" x-show="selectedOrder">
                  <div class="space-y-3">
                    <div class="border-b pb-2">
                      <p class="font-semibold" x-text="selectedOrder ? `#${selectedOrder.code}` : ''"></p>
                      <p class="text-sm text-gray-500" x-text="selectedOrder ? formatDate(selectedOrder.date) : ''"></p>
                    </div>
                    
                    <div>
                      <h4 class="font-medium mb-2">Informasi Customer</h4>
                      <p class="text-sm"><strong>Nama:</strong> <span x-text="selectedOrder ? selectedOrder.customer : ''"></span></p>
                      <p class="text-sm"><strong>Telepon:</strong> <span x-text="selectedOrder ? selectedOrder.phone : ''"></span></p>
                      <p class="text-sm"><strong>Alamat:</strong> <span x-text="selectedOrder ? selectedOrder.address : ''"></span></p>
                    </div>
                    
                    <div>
                      <h4 class="font-medium mb-2">Items Pesanan</h4>
                      <ul class="text-sm space-y-1">
                        <template x-for="item in (selectedOrder ? selectedOrder.items : [])" :key="item.name">
                          <li class="flex justify-between">
                            <span x-text="`${item.name} × ${item.qty}`"></span>
                          </li>
                        </template>
                      </ul>
                    </div>
                    
                    <div class="border-t pt-2">
                      <div class="flex justify-between font-semibold">
                        <span>Total:</span>
                        <span x-text="selectedOrder ? formatIDR(selectedOrder.total) : ''"></span>
                      </div>
                      <p class="text-sm text-gray-500 mt-1"><strong>Pembayaran:</strong> <span x-text="selectedOrder ? selectedOrder.payment_method : ''"></span></p>
                      <p class="text-sm text-gray-500"><strong>Pengiriman:</strong> <span x-text="selectedOrder ? selectedOrder.shipping : ''"></span></p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
            <button @click="closeModal()" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-gray-600 text-base font-medium text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:ml-3 sm:w-auto sm:text-sm">
              Tutup
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal Input Nomor Resi -->
    <div x-show="shipModalVisible" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="ship-modal-title" role="dialog" aria-modal="true">
      <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div x-show="shipModalVisible" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="closeShipModal()"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div x-show="shipModalVisible" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
          <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
            <div class="sm:flex sm:items-start">
              <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-purple-100 sm:mx-0 sm:h-10 sm:w-10">
                <svg class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
              </div>
              <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                <h3 class="text-lg leading-6 font-medium text-gray-900" id="ship-modal-title">
                  Kirim Pesanan
                </h3>
                <div class="mt-4" x-show="selectedShipOrder">
                  <div class="mb-4">
                    <p class="text-sm text-gray-600">Pesanan: <span class="font-semibold" x-text="selectedShipOrder ? `#${selectedShipOrder.code}` : ''"></span></p>
                    <p class="text-sm text-gray-600">Customer: <span class="font-semibold" x-text="selectedShipOrder ? selectedShipOrder.customer : ''"></span></p>
                  </div>
                  
                  <form @submit.prevent="submitShipOrder()">
                    <div class="mb-4">
                      <label for="nomor_resi" class="block text-sm font-medium text-gray-700 mb-2">
                        Nomor Resi <span class="text-red-500">*</span>
                      </label>
                      <input 
                        type="text" 
                        id="nomor_resi" 
                        x-model="nomorResi"
                        placeholder="Masukkan nomor resi pengiriman"
                        class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 px-4 py-2"
                        required>
                      <p class="text-xs text-gray-500 mt-1">Contoh: JNE123456789, TIKI987654321, POS555666777</p>
                    </div>
                    
                    <div class="mb-4">
                      <label class="block text-sm font-medium text-gray-700 mb-2">Ekspedisi</label>
                      <p class="text-sm text-gray-600" x-text="selectedShipOrder ? selectedShipOrder.shipping : ''"></p>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
            <button @click="submitShipOrder()" :disabled="!nomorResi.trim()" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-purple-600 text-base font-medium text-white hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 sm:ml-3 sm:w-auto sm:text-sm disabled:bg-gray-400 disabled:cursor-not-allowed">
              Kirim Pesanan
            </button>
            <button @click="closeShipModal()" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
              Batal
            </button>
          </div>
        </div>
      </div>
    </div>

    <script>
      const ordersData = {
        active: 'dikemas',
        q: '',
        data: @json($transformedOrders ?? []),
        showModal: false,
        selectedOrder: null,
        shipModalVisible: false,
        selectedShipOrder: null,
        nomorResi: '',
        
        init() {
          console.log('Alpine component initialized');
          console.log('Orders data:', this.data);
          console.log('Data length:', this.data.length);
        },
        
        // Status update methods
        async shipOrder(order) {
          if (confirm('Kirim pesanan ini?')) {
            await this.updateOrderStatus(order, 'shipped');
          }
        },
        
        // Ship modal methods
        showShipModal(order) {
          this.selectedShipOrder = order;
          this.nomorResi = '';
          this.shipModalVisible = true;
        },
        
        closeShipModal() {
          this.shipModalVisible = false;
          this.selectedShipOrder = null;
          this.nomorResi = '';
        },
        
        async submitShipOrder() {
          if (!this.nomorResi.trim()) {
            this.showErrorMessage('Nomor resi harus diisi');
            return;
          }
          
          try {
            const orderId = this.selectedShipOrder.code.replace('ORD', '').replace(/^0+/, '');
            
            const response = await fetch(`/admin/manageorders/${orderId}/ship`, {
              method: 'PATCH',
              headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
              },
              body: JSON.stringify({ nomor_resi: this.nomorResi.trim() })
            });
            
            const result = await response.json();
            
            if (result.success) {
              // Update status and nomor_resi in local data
              const orderIndex = this.data.findIndex(o => o.code === this.selectedShipOrder.code);
              if (orderIndex !== -1) {
                this.data[orderIndex].status = result.data.new_status;
                this.data[orderIndex].nomor_resi = result.data.nomor_resi;
              }
              
              this.closeShipModal();
              this.showSuccessMessage(result.message);
            } else {
              throw new Error(result.message || 'Gagal mengirim pesanan');
            }
          } catch (error) {
            console.error('Error shipping order:', error);
            this.showErrorMessage('Gagal mengirim pesanan: ' + error.message);
          }
        },
        
        async updateOrderStatus(order, newStatus) {
          try {
            const orderId = order.code.replace('ORD', '').replace(/^0+/, ''); // Extract ID from ORD0053 -> 53
            
            const response = await fetch(`/admin/manageorders/${orderId}/status`, {
              method: 'PATCH',
              headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
              },
              body: JSON.stringify({ status: newStatus })
            });
            
            const result = await response.json();
            
            if (result.success) {
              // Update status in local data
              const orderIndex = this.data.findIndex(o => o.code === order.code);
              if (orderIndex !== -1) {
                this.data[orderIndex].status = result.data.new_status;
              }
              
              // Show success message
              this.showSuccessMessage('Status pesanan berhasil diupdate!');
            } else {
              throw new Error(result.message || 'Gagal mengupdate status');
            }
          } catch (error) {
            console.error('Error updating status:', error);
            this.showErrorMessage('Gagal mengupdate status: ' + error.message);
          }
        },
        
        // Detail modal methods
        showDetail(order) {
          this.selectedOrder = order;
          this.showModal = true;
        },
        
        closeModal() {
          this.showModal = false;
          this.selectedOrder = null;
        },
        
        // Notification methods
        showSuccessMessage(message) {
          // You can implement a toast notification here
          alert(message);
        },
        
        showErrorMessage(message) {
          // You can implement a toast notification here
          alert(message);
        },
        
        label(s) {
          const labels = {
            'dikemas': 'Dikemas',
            'dikirim': 'Sedang Dikirim',
            'selesai': 'Selesai',
            'dibatalkan': 'Dibatalkan'
          };
          return labels[s] || s;
        },
        
        chip(s) {
          const classes = {
            'dikemas': 'bg-purple-100 text-purple-700',
            'dikirim': 'bg-blue-100 text-blue-700',
            'selesai': 'bg-emerald-100 text-emerald-700',
            'dibatalkan': 'bg-red-100 text-red-700'
          };
          return classes[s] || 'bg-gray-100 text-gray-700';
        },
        
        tabClass(s) {
          return (this.active === s)
            ? 'bg-emerald-600 text-white border-emerald-600'
            : 'bg-white text-gray-700 hover:bg-gray-50 border-gray-200';
        },
        
        badgeClass(s) {
          return (this.active === s)
            ? 'bg-white/20 text-white'
            : 'bg-gray-100 text-gray-700';
        },
        
        count(s) {
          const result = this.data.filter(d => d.status === s).length;
          console.log(`Count for status '${s}':`, result);
          return result;
        },
        
        filtered() {
          const term = this.q.toLowerCase().trim();
          let result = this.data.filter(d => d.status === this.active);
          
          if (term) {
            result = result.filter(d => 
              (d.code || '').toLowerCase().includes(term) ||
              (d.customer || '').toLowerCase().includes(term) ||
              (d.items || []).some(it => (it.name || '').toLowerCase().includes(term))
            );
          }
          
          console.log(`Filtered data for status '${this.active}':`, result);
          return result;
        },
        
        formatIDR(n) {
          return new Intl.NumberFormat('id-ID', {
            style: 'currency', 
            currency: 'IDR', 
            maximumFractionDigits: 0
          }).format(Number(n || 0));
        },
        
        formatDate(str) {
          if (!str) return '-';
          try {
            const d = new Date(String(str).replace(' ', 'T'));
            return d.toLocaleDateString('id-ID', {
              day: '2-digit', 
              month: 'short', 
              year: 'numeric'
            }) + ' • ' + d.toLocaleTimeString('id-ID', {
              hour: '2-digit', 
              minute: '2-digit'
            });
          } catch {
            return str;
          }
        }
      };
    </script>
    <!-- Muat Alpine.js setelah ordersPage didefinisikan agar x-data dapat memanggilnya -->
    <script defer src="https://unpkg.com/alpinejs@3.12.0/dist/cdn.min.js"></script>
  </body>
</html>