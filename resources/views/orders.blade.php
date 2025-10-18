<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Riwayat Pesanan — TumbasLek</title>

  {{-- TANPA VITE: pakai CDN agar langsung tampil --}}
  <script src="https://cdn.tailwindcss.com"></script>
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

  <script>
    // ==== INJEKSI DATA (NANTI) ====
    // Opsi 1 (front-end inject): isi window.ORDERS dari script atau ajax-mu:
    // window.ORDERS = [{ code:'INV...', date:'2025-10-09 09:00', status:'dikemas', total:85000, items:[{name:'...',qty:1}] }, ...];
    //
    // Opsi 2 (backend Blade): kirim variabel $orders (array) dan biarkan script di bawah mengambilnya.
  </script>
</head>
<body class="bg-gray-50 text-gray-900"
      x-data="ordersPage({ 
        // kalau backend kirim $orders, pakai itu; kalau tidak ada, fallback ke window.ORDERS; kalau tetap tidak ada, []
        initial: (typeof @json(isset($orders)) !== 'undefined' && @json(isset($orders)) ? @json($orders ?? []) : (window.ORDERS || []))
      })">

  {{-- Navbar --}}
  @include('components.navbar', ['isAdmin' => false])

  {{-- Header strip --}}
  <div class="bg-emerald-100/60 h-16 w-full rounded-b-2xl"></div>

  <main class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 -mt-8">
    {{-- Heading --}}
    <div class="bg-white rounded-2xl shadow-sm border p-6 mb-6 flex items-center gap-4">
  <img src="{{ asset('images/logo.png') }}" alt="TumbasLek" class="w-12 h-12 rounded-full">
      <div>
        <h1 class="text-2xl font-bold">Riwayat Pesanan</h1>
        <p class="text-sm text-gray-500">Pantau status pesananmu di sini</p>
      </div>
    </div>

    {{-- Tabs Status --}}
    <div class="bg-white rounded-2xl shadow-sm border p-4 mb-6">
      <div class="flex flex-wrap gap-2">
<<<<<<< HEAD
        <button @click="active='belum_bayar'" :class="tabClass('belum_bayar')" class="px-4 py-2 rounded-full text-sm border">
          Pending
          <span class="ml-2 inline-flex items-center justify-center min-w-5 h-5 text-xs rounded-full px-1"
                :class="badgeClass('belum_bayar')" x-text="count('belum_bayar')"></span>
        </button>
=======
>>>>>>> ac0ff3a7fffcfd4d63ed5b2b65cce359379e48a2
        <button @click="active='dikemas'" :class="tabClass('dikemas')" class="px-4 py-2 rounded-full text-sm border">
          Processing
          <span class="ml-2 inline-flex items-center justify-center min-w-5 h-5 text-xs rounded-full px-1"
                :class="badgeClass('dikemas')" x-text="count('dikemas')"></span>
        </button>
        <button @click="active='dikirim'" :class="tabClass('dikirim')" class="px-4 py-2 rounded-full text-sm border">
          Shipped
          <span class="ml-2 inline-flex items-center justify-center min-w-5 h-5 text-xs rounded-full px-1"
                :class="badgeClass('dikirim')" x-text="count('dikirim')"></span>
        </button>
        <button @click="active='selesai'" :class="tabClass('selesai')" class="px-4 py-2 rounded-full text-sm border">
          Completed
          <span class="ml-2 inline-flex items-center justify-center min-w-5 h-5 text-xs rounded-full px-1"
                :class="badgeClass('selesai')" x-text="count('selesai')"></span>
        </button>
        <button @click="active='dibatalkan'" :class="tabClass('dibatalkan')" class="px-4 py-2 rounded-full text-sm border">
          Cancelled
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

          <div class="mt-4 border-t pt-4 grid grid-cols-1 md:grid-cols-3 gap-4">
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
            </div>
            <div class="flex flex-wrap gap-2 md:justify-end">
              <template x-if="ord.status==='dikemas'">
                <button class="px-4 py-2 rounded-lg border text-sm hover:bg-gray-50">Hubungi Penjual</button>
              </template>
              <template x-if="ord.status==='dikirim'">
                <button class="px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700 text-sm">Lacak Paket</button>
              </template>
              <template x-if="ord.status==='selesai'">
                <button class="px-4 py-2 rounded-lg border text-sm hover:bg-gray-50">Beli Lagi</button>
              </template>
              <template x-if="ord.status==='dibatalkan'">
                <button class="px-4 py-2 rounded-lg border text-sm hover:bg-gray-50">Beli Lagi</button>
              </template>
              <button class="px-4 py-2 rounded-lg border text-sm hover:bg-gray-50">Detail</button>
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

  {{-- Footer --}}
  @include('components.footer')

  <script>
    function ordersPage({initial = []} = {}){
      return {
        active: 'dikemas',
        q: '',
        data: Array.isArray(initial) ? initial : [],
        label(s){
          return ({
            'dikemas':'Dikemas',
            'dikirim':'Sedang Dikirim',
            'selesai':'Selesai',
            'dibatalkan':'Dibatalkan'
          })[s] || s;
        },
        chip(s){
          return ({
            'dikemas':'bg-purple-100 text-purple-700',
            'dikirim':'bg-blue-100 text-blue-700',
            'selesai':'bg-emerald-100 text-emerald-700',
            'dibatalkan':'bg-red-100 text-red-700'
          })[s] || 'bg-gray-100 text-gray-700';
        },
        tabClass(s){
          return (this.active===s)
            ? 'bg-emerald-600 text-white border-emerald-600'
            : 'bg-white text-gray-700 hover:bg-gray-50 border-gray-200';
        },
        badgeClass(s){
          return (this.active===s)
            ? 'bg-white/20 text-white'
            : 'bg-gray-100 text-gray-700';
        },
        count(s){
          return this.data.filter(d => d.status===s).length;
        },
        filtered(){
          const term = this.q.toLowerCase().trim();
          return this.data
            .filter(d => d.status===this.active)
            .filter(d => !term || d.code?.toLowerCase().includes(term)
              || (d.items || []).some(it => (it.name||'').toLowerCase().includes(term)));
        },
        formatIDR(n){
          return new Intl.NumberFormat('id-ID', {style:'currency', currency:'IDR', maximumFractionDigits:0}).format(Number(n||0));
        },
        formatDate(str){
          if(!str) return '-';
          try{
            const d = new Date(String(str).replace(' ', 'T'));
            return d.toLocaleDateString('id-ID', {day:'2-digit', month:'short', year:'numeric'})
                 + ' • ' + d.toLocaleTimeString('id-ID', {hour:'2-digit', minute:'2-digit'});
          }catch{ return str; }
        }
      }
    }
  </script>
</body>
</html>
