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
      <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-lg bg-emerald-100 text-emerald-700 font-medium">
        <i class="lucide lucide-home"></i> Dashboard
      </a>
      <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-100">
        <i class="lucide lucide-box"></i> Manajemen Produk
      </a>
      <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-100">
        <i class="lucide lucide-shopping-bag"></i> Manajemen Pesanan
      </a>
      <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-100">
        <i class="lucide lucide-file-chart"></i> Laporan
      </a>
    </nav>
  </aside>

  {{-- Konten utama --}}
  <main class="flex-1 p-8 space-y-6">
    <div class="flex justify-between items-center">
      <h1 class="text-3xl font-bold text-gray-800">Dashboard Admin</h1>
      <a href="#" class="text-emerald-700 font-semibold hover:underline">Logout</a>
    </div>

    {{-- Kartu ringkasan --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
      <div class="bg-white p-5 rounded-xl shadow flex items-center gap-4">
        <div class="w-12 h-12 rounded-lg bg-emerald-100 grid place-items-center">
          🛒
        </div>
        <div>
          <p class="text-sm text-gray-600">Pesanan Hari Ini</p>
          <p class="text-2xl font-semibold">12</p>
        </div>
      </div>
      <div class="bg-white p-5 rounded-xl shadow flex items-center gap-4">
        <div class="w-12 h-12 rounded-lg bg-green-100 grid place-items-center">
          💰
        </div>
        <div>
          <p class="text-sm text-gray-600">Pendapatan Hari Ini</p>
          <p class="text-2xl font-semibold text-green-700">Rp1.000.000,00</p>
        </div>
      </div>
      <div class="bg-white p-5 rounded-xl shadow flex items-center gap-4">
        <div class="w-12 h-12 rounded-lg bg-amber-100 grid place-items-center">
          🔄
        </div>
        <div>
          <p class="text-sm text-gray-600">Perlu Diproses</p>
          <p class="text-2xl font-semibold text-amber-600">4</p>
        </div>
      </div>
      <div class="bg-white p-5 rounded-xl shadow flex items-center gap-4">
        <div class="w-12 h-12 rounded-lg bg-red-100 grid place-items-center">
          ⚠️
        </div>
        <div>
          <p class="text-sm text-gray-600">Stok Menipis</p>
          <p class="text-2xl font-semibold text-red-600">3</p>
        </div>
      </div>
    </div>

    {{-- Grafik Penjualan --}}
    <div class="bg-white rounded-xl shadow p-5">
      <h2 class="font-semibold mb-3">Rekap Pesanan Mingguan</h2>
      <canvas id="salesChart" height="100"></canvas>
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
              <th class="px-4 py-2">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <tr class="border-b">
              <td class="px-4 py-2">ORD-001</td>
              <td class="px-4 py-2">Budi Santoso</td>
              <td class="px-4 py-2">Rp100.000,00</td>
              <td class="px-4 py-2"><span class="bg-amber-100 text-amber-700 text-xs px-2 py-1 rounded">Menunggu Diproses</span></td>
              <td class="px-4 py-2"><button class="text-sm px-3 py-1 border rounded-lg hover:bg-gray-50">Detail</button></td>
            </tr>
            <tr class="border-b">
              <td class="px-4 py-2">ORD-002</td>
              <td class="px-4 py-2">Adi Wijaya</td>
              <td class="px-4 py-2">Rp72.000,00</td>
              <td class="px-4 py-2"><span class="bg-blue-100 text-blue-700 text-xs px-2 py-1 rounded">Dikirim</span></td>
              <td class="px-4 py-2"><button class="text-sm px-3 py-1 border rounded-lg hover:bg-gray-50">Detail</button></td>
            </tr>
            <tr class="border-b">
              <td class="px-4 py-2">ORD-003</td>
              <td class="px-4 py-2">Citra Lestari</td>
              <td class="px-4 py-2">Rp30.000,00</td>
              <td class="px-4 py-2"><span class="bg-green-100 text-green-700 text-xs px-2 py-1 rounded">Selesai</span></td>
              <td class="px-4 py-2"><button class="text-sm px-3 py-1 border rounded-lg hover:bg-gray-50">Detail</button></td>
            </tr>
            <tr>
              <td class="px-4 py-2">ORD-004</td>
              <td class="px-4 py-2">Doni Setiawan</td>
              <td class="px-4 py-2">Rp55.000,00</td>
              <td class="px-4 py-2"><span class="bg-red-100 text-red-700 text-xs px-2 py-1 rounded">Batal</span></td>
              <td class="px-4 py-2"><button class="text-sm px-3 py-1 border rounded-lg hover:bg-gray-50">Detail</button></td>
            </tr>
          </tbody>
        </table>
      </div>

      {{-- Produk Terlaris --}}
      <div class="bg-white rounded-xl shadow p-5">
        <h2 class="font-semibold mb-3 flex items-center gap-2">⭐ Produk Terlaris</h2>
        <table class="w-full text-sm border">
          <tbody>
            <tr class="border-b"><td class="px-3 py-2">Cimol Bojot</td><td class="px-3 py-2 text-right text-blue-700 font-semibold">50</td></tr>
            <tr class="border-b"><td class="px-3 py-2">Seblak Kuah</td><td class="px-3 py-2 text-right text-blue-700 font-semibold">45</td></tr>
            <tr class="border-b"><td class="px-3 py-2">Pempek Ikan</td><td class="px-3 py-2 text-right text-blue-700 font-semibold">39</td></tr>
            <tr class="border-b"><td class="px-3 py-2">Keripik Buah</td><td class="px-3 py-2 text-right text-blue-700 font-semibold">35</td></tr>
            <tr><td class="px-3 py-2">Rendang Sapi</td><td class="px-3 py-2 text-right text-blue-700 font-semibold">32</td></tr>
          </tbody>
        </table>
      </div>
    </div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    const ctx = document.getElementById('salesChart');
    new Chart(ctx, {
      type: 'bar',
      data: {
        labels: ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'],
        datasets: [{
          label: 'Jumlah Terjual',
          data: [20, 35, 40, 55, 70, 90, 75],
          backgroundColor: '#10b981'
        }]
      },
      options: {
        responsive: true,
        scales: {
          y: { beginAtZero: true }
        }
      }
    });
  </script>
</body>
</html>
