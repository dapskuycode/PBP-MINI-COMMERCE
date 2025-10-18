<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Admin • UMKM Mini-Commerce</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-rose-50 min-h-screen flex">
  {{-- Sidebar --}}
  <aside class="w-64 bg-white border-r">
    <div class="p-4 text-center border-b">
      <img src="{{ asset('images/logo.png') }}" alt="TokoKami" class="mx-auto w-16 mb-2">
      <h1 class="text-lg font-semibold text-emerald-700">TokoKami</h1>
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

  {{-- Konten utama --}}
  <main class="flex-1 p-8 space-y-6">
    <div class="flex justify-between items-center">
      <h1 class="text-3xl font-bold text-gray-800">Dashboard Admin</h1>
      <div class="text-right">
        <div class="text-lg font-semibold text-gray-700" id="currentDate"></div>
        <div class="text-sm text-gray-500">{{ date('l') }}</div>
      </div>
    </div>

    {{-- Kartu ringkasan --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <div class="bg-white p-5 rounded-xl shadow flex items-center gap-4">
        <div class="w-12 h-12 rounded-lg bg-amber-100 grid place-items-center">
          �
        </div>
        <div>
          <p class="text-sm text-gray-600">Pesanan Belum Dikirim</p>
          <p class="text-2xl font-semibold text-amber-600">8</p>
        </div>
      </div>
      <div class="bg-white p-5 rounded-xl shadow flex items-center gap-4">
        <div class="w-12 h-12 rounded-lg bg-green-100 grid place-items-center">
          💰
        </div>
        <div>
          <p class="text-sm text-gray-600">Pendapatan Bulan Ini</p>
          <p class="text-2xl font-semibold text-green-700">Rp25.350.000</p>
        </div>
      </div>
      <div class="bg-white p-5 rounded-xl shadow flex items-center gap-4">
        <div class="w-12 h-12 rounded-lg bg-blue-100 grid place-items-center">
          �
        </div>
        <div>
          <p class="text-sm text-gray-600">User Aktif</p>
          <p class="text-2xl font-semibold text-blue-600">127</p>
        </div>
      </div>
    </div>

    {{-- Layout dengan Stok Produk di kiri dan Grafik di kanan --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
      {{-- Stok Produk Hampir Habis (memanjang ke bawah) --}}
      <div class="bg-white rounded-xl shadow p-5">
        <h2 class="font-semibold mb-3 flex items-center gap-2">
          <div class="w-8 h-8 rounded-lg bg-red-100 grid place-items-center">⚠️</div>
          Stok Produk Hampir Habis
        </h2>
        <div class="space-y-3">
          <div class="flex justify-between items-center p-3 bg-red-50 rounded-lg border-l-4 border-red-500">
            <div>
              <div class="font-medium text-red-800">Keripik Singkong Pedas</div>
              <div class="text-sm text-red-600">Kategori: Makanan Ringan</div>
            </div>
            <div class="text-right">
              <div class="text-lg font-bold text-red-700">2</div>
              <div class="text-xs text-red-500">tersisa</div>
            </div>
          </div>
          
          <div class="flex justify-between items-center p-3 bg-orange-50 rounded-lg border-l-4 border-orange-500">
            <div>
              <div class="font-medium text-orange-800">Rendang Sapi Premium</div>
              <div class="text-sm text-orange-600">Kategori: Makanan Siap Saji</div>
            </div>
            <div class="text-right">
              <div class="text-lg font-bold text-orange-700">5</div>
              <div class="text-xs text-orange-500">tersisa</div>
            </div>
          </div>
          
          <div class="flex justify-between items-center p-3 bg-yellow-50 rounded-lg border-l-4 border-yellow-500">
            <div>
              <div class="font-medium text-yellow-800">Seblak Kuah Seafood</div>
              <div class="text-sm text-yellow-600">Kategori: Makanan Basah</div>
            </div>
            <div class="text-right">
              <div class="text-lg font-bold text-yellow-700">7</div>
              <div class="text-xs text-yellow-500">tersisa</div>
            </div>
          </div>
          
          <div class="flex justify-between items-center p-3 bg-red-50 rounded-lg border-l-4 border-red-500">
            <div>
              <div class="font-medium text-red-800">Pempek Ikan Tenggiri</div>
              <div class="text-sm text-red-600">Kategori: Makanan Tradisional</div>
            </div>
            <div class="text-right">
              <div class="text-lg font-bold text-red-700">3</div>
              <div class="text-xs text-red-500">tersisa</div>
            </div>
          </div>
          
          <div class="flex justify-between items-center p-3 bg-orange-50 rounded-lg border-l-4 border-orange-500">
            <div>
              <div class="font-medium text-orange-800">Kerupuk Udang Asli</div>
              <div class="text-sm text-orange-600">Kategori: Makanan Ringan</div>
            </div>
            <div class="text-right">
              <div class="text-lg font-bold text-orange-700">6</div>
              <div class="text-xs text-orange-500">tersisa</div>
            </div>
          </div>
          
          <div class="flex justify-between items-center p-3 bg-yellow-50 rounded-lg border-l-4 border-yellow-500">
            <div>
              <div class="font-medium text-yellow-800">Gudeg Jogja Original</div>
              <div class="text-sm text-yellow-600">Kategori: Makanan Tradisional</div>
            </div>
            <div class="text-right">
              <div class="text-lg font-bold text-yellow-700">8</div>
              <div class="text-xs text-yellow-500">tersisa</div>
            </div>
          </div>
        </div>
      </div>

      {{-- Grafik Penjualan 12 bulan --}}
      <div class="lg:col-span-2 bg-white rounded-xl shadow p-5">
        <h2 class="font-semibold mb-3">Rekap Penjualan 12 Bulan Terakhir</h2>
        <canvas id="salesChart" height="100"></canvas>
      </div>
    </div>

    {{-- Tabel Pesanan Terbaru & Produk Terlaris --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
      {{-- Pesanan Terbaru --}}
      <div class="lg:col-span-2 bg-white rounded-xl shadow p-5">
        <h2 class="font-semibold mb-3">Daftar Pesanan Terbaru</h2>
        <table class="min-w-full text-sm text-left border">
          <thead class="bg-gray-50 border-b">
            <tr>
              <th class="px-4 py-2">ID Pesanan</th>
              <th class="px-4 py-2">Pelanggan</th>
              <th class="px-4 py-2">Total</th>
              <th class="px-4 py-2">Status</th>
              <th class="px-4 py-2">Tanggal</th>
            </tr>
          </thead>
          <tbody>
            <tr class="border-b">
              <td class="px-4 py-2">ORD-001</td>
              <td class="px-4 py-2">Budi Santoso</td>
              <td class="px-4 py-2">Rp100.000,00</td>
              <td class="px-4 py-2"><span class="bg-amber-100 text-amber-700 text-xs px-2 py-1 rounded">Menunggu Diproses</span></td>
              <td class="px-4 py-2">2023-03-01</td>
            </tr>
            <tr class="border-b">
              <td class="px-4 py-2">ORD-002</td>
              <td class="px-4 py-2">Adi Wijaya</td>
              <td class="px-4 py-2">Rp72.000,00</td>
              <td class="px-4 py-2"><span class="bg-blue-100 text-blue-700 text-xs px-2 py-1 rounded">Dikirim</span></td>
              <td class="px-4 py-2">2023-03-01</td>
            </tr>
            <tr class="border-b">
              <td class="px-4 py-2">ORD-003</td>
              <td class="px-4 py-2">Citra Lestari</td>  
              <td class="px-4 py-2">Rp30.000,00</td>
              <td class="px-4 py-2"><span class="bg-green-100 text-green-700 text-xs px-2 py-1 rounded">Selesai</span></td>
              <td class="px-4 py-2">2023-03-01</td>
            </tr>
            <tr>
              <td class="px-4 py-2">ORD-004</td>
              <td class="px-4 py-2">Doni Setiawan</td>
              <td class="px-4 py-2">Rp55.000,00</td>
              <td class="px-4 py-2"><span class="bg-red-100 text-red-700 text-xs px-2 py-1 rounded">Batal</span></td>
              <td class="px-4 py-2">2023-03-01</td>
            </tr>
          </tbody>
        </table>
      </div>

      {{-- Produk Terlaris --}}
      <div class="bg-white rounded-xl shadow p-5">
        <h2 class="font-semibold mb-3 flex items-center gap-2">⭐ Produk Terlaris</h2>
        <div class="space-y-3">
          <div class="flex justify-between items-center p-3 bg-yellow-50 rounded-lg border-l-4 border-yellow-400">
            <div>
              <div class="font-medium text-yellow-800">Cimol Bojot</div>
              <div class="text-sm text-yellow-600">Makanan Ringan</div>
            </div>
            <div class="text-right">
              <div class="text-lg font-bold text-yellow-700">50</div>
              <div class="text-xs text-yellow-500">terjual</div>
            </div>
          </div>
          
          <div class="flex justify-between items-center p-3 bg-blue-50 rounded-lg border-l-4 border-blue-400">
            <div>
              <div class="font-medium text-blue-800">Seblak Kuah</div>
              <div class="text-sm text-blue-600">Makanan Basah</div>
            </div>
            <div class="text-right">
              <div class="text-lg font-bold text-blue-700">45</div>
              <div class="text-xs text-blue-500">terjual</div>
            </div>
          </div>
          
          <div class="flex justify-between items-center p-3 bg-green-50 rounded-lg border-l-4 border-green-400">
            <div>
              <div class="font-medium text-green-800">Pempek Ikan</div>
              <div class="text-sm text-green-600">Makanan Tradisional</div>
            </div>
            <div class="text-right">
              <div class="text-lg font-bold text-green-700">39</div>
              <div class="text-xs text-green-500">terjual</div>
            </div>
          </div>
          
          <div class="flex justify-between items-center p-3 bg-purple-50 rounded-lg border-l-4 border-purple-400">
            <div>
              <div class="font-medium text-purple-800">Keripik Buah</div>
              <div class="text-sm text-purple-600">Makanan Ringan</div>
            </div>
            <div class="text-right">
              <div class="text-lg font-bold text-purple-700">35</div>
              <div class="text-xs text-purple-500">terjual</div>
            </div>
          </div>
          
          <div class="flex justify-between items-center p-3 bg-red-50 rounded-lg border-l-4 border-red-400">
            <div>
              <div class="font-medium text-red-800">Rendang Sapi</div>
              <div class="text-sm text-red-600">Makanan Siap Saji</div>
            </div>
            <div class="text-right">
              <div class="text-lg font-bold text-red-700">32</div>
              <div class="text-xs text-red-500">terjual</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    // Set current date
    document.addEventListener('DOMContentLoaded', function() {
      const now = new Date();
      const options = { 
        day: 'numeric', 
        month: 'long', 
        year: 'numeric' 
      };
      document.getElementById('currentDate').textContent = now.toLocaleDateString('id-ID', options);
    });

    // Chart for 12 months sales data
    const ctx = document.getElementById('salesChart');
    new Chart(ctx, {
      type: 'line',
      data: {
        labels: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'],
        datasets: [{
          label: 'Penjualan (Juta Rupiah)',
          data: [15.2, 18.5, 22.1, 19.8, 25.3, 28.7, 31.2, 29.6, 26.8, 32.1, 35.4, 38.9],
          backgroundColor: 'rgba(16, 185, 129, 0.1)',
          borderColor: '#10b981',
          borderWidth: 3,
          fill: true,
          tension: 0.4,
          pointBackgroundColor: '#10b981',
          pointBorderColor: '#ffffff',
          pointBorderWidth: 2,
          pointRadius: 6
        }]
      },
      options: {
        responsive: true,
        plugins: {
          legend: {
            display: true,
            position: 'top'
          }
        },
        scales: {
          y: { 
            beginAtZero: true,
            ticks: {
              callback: function(value) {
                return 'Rp' + value + 'jt';
              }
            }
          },
          x: {
            grid: {
              display: false
            }
          }
        },
        elements: {
          point: {
            hoverRadius: 8
          }
        }
      }
    });
  </script>
</body>
</html>
