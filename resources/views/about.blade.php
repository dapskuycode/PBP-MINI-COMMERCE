{{-- resources/views/about.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Tentang Kami • TokoKami</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  {{-- Kalau beranda sudah load Tailwind/Vite global, baris di bawah boleh dihapus --}}
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800">

  {{-- NAVBAR SAMA DENGAN BERANDA --}}
  @include('components.navbar')

  {{-- CONTAINER UTAMA --}}
  <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

    {{-- Breadcrumb / Heading kecil  --}}
    <div class="flex items-center justify-between mb-4">
      <nav class="text-sm text-gray-500">
        <a href="{{ route('home') }}" class="hover:text-emerald-600">Beranda</a>
        <span class="mx-2">/</span>
        <span class="text-gray-700 font-medium">Tentang Kami</span>
      </nav>
    </div>

    {{-- HERO STRIP --}}
    <section class="rounded-xl bg-emerald-700 text-white p-6 sm:p-8 shadow-md">
      <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">Tentang TokoKami</h1>
      <p class="mt-2 text-emerald-50 max-w-3xl">
        <b>TokoKami</b> adalah platform e-commerce yang menyediakan berbagai <b>oleh-oleh khas daerah</b> dari seluruh Indonesia,
        mulai dari makanan tradisional hingga kerajinan tangan lokal. Kami berupaya memudahkan pelanggan menemukan produk
        berkualitas tanpa harus datang langsung ke tempat asalnya.
      </p>
      <p class="mt-2 text-emerald-50 max-w-3xl">
        Semua proses dikelola oleh satu admin toko yang memastikan setiap pesanan diproses dengan cepat, aman, dan profesional.
        Fokus kami adalah menghadirkan pengalaman belanja yang nyaman, terpercaya, dan mendukung pertumbuhan pelaku UMKM lokal.
      </p>
      <div class="mt-4 flex flex-wrap gap-3">
        <a href="{{ route('home') }}"
           class="inline-flex items-center gap-2 bg-white text-emerald-700 px-4 py-2 rounded-lg font-semibold hover:bg-emerald-50">
          Lihat Katalog
        </a>
      </div>
    </section>

    {{-- GRID 3 KOLOM (gaya card seperti beranda) --}}
    <section class="mt-8">
      <h2 class="text-xl sm:text-2xl font-extrabold text-gray-900 mb-4">Kenapa Memilih Kami</h2>
      <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
        <div class="bg-white rounded-xl shadow p-5 border border-gray-100">
          <h3 class="font-semibold text-gray-900">Produk Lokal Berkualitas</h3>
          <p class="mt-2 text-gray-600">Setiap produk dipilih dari pelaku usaha lokal dengan kualitas yang terjamin.</p>
        </div>
        <div class="bg-white rounded-xl shadow p-5 border border-gray-100">
          <h3 class="font-semibold text-gray-900">Pilihan Oleh-oleh Lengkap</h3>
          <p class="mt-2 text-gray-600">Mulai dari makanan khas, aksesoris, tas rajut, miniatur, hingga kerajinan tangan unik.</p>
        </div>
        <div class="bg-white rounded-xl shadow p-5 border border-gray-100">
          <h3 class="font-semibold text-gray-900">Pelayanan Cepat & Aman</h3>
          <p class="mt-2 text-gray-600">Pesanan diproses dengan sistem terkelola, pengemasan rapi, dan pengiriman tepat waktu.</p>
        </div>
      </div>
    </section>

    {{-- SECTION CERITA (gaya card besar) --}}
    <section class="mt-8">
      <div class="bg-white rounded-xl shadow p-6 border border-gray-100">
        <h2 class="text-xl sm:text-2xl font-extrabold text-gray-900">Profil Singkat</h2>
        <div class="mt-4 grid md:grid-cols-2 gap-6">
          <div>
            <p class="text-gray-700">
              TokoKami hadir sebagai solusi praktis bagi siapa pun yang ingin membeli oleh-oleh khas daerah tanpa repot.
              Melalui platform ini, pelanggan dapat menjelajahi beragam produk lokal yang dikurasi langsung dan dikelola oleh admin toko.
            </p>
            <p class="mt-3 text-gray-700">
              Dengan dukungan pelaku UMKM di berbagai wilayah, kami membantu memperluas jangkauan produk lokal agar bisa dinikmati oleh lebih banyak orang di seluruh Indonesia.
            </p>
          </div>
          <ul class="space-y-3">
            <li class="flex items-start gap-3">
              <span class="mt-1 w-2 h-2 rounded-full bg-emerald-600"></span>
              Dikelola secara profesional oleh 1 admin toko terpercaya.
            </li>
            <li class="flex items-start gap-3">
              <span class="mt-1 w-2 h-2 rounded-full bg-emerald-600"></span>
              Mendukung promosi produk pelaku UMKM daerah.
            </li>
            <li class="flex items-start gap-3">
              <span class="mt-1 w-2 h-2 rounded-full bg-emerald-600"></span>
              Pengiriman cepat, aman, dan dapat dilacak.
            </li>
          </ul>
        </div>
      </div>
    </section>

    {{-- STAT KECIL (matching style beranda) --}}
    <section class="mt-8">
      <div class="grid sm:grid-cols-3 gap-4">
        <div class="bg-white rounded-xl shadow p-6 text-center border border-gray-100">
          <p class="text-3xl font-extrabold text-gray-900">40+</p>
          <p class="text-gray-600">Varian Rasa/Kemasan</p>
        </div>
        <div class="bg-white rounded-xl shadow p-6 text-center border border-gray-100">
          <p class="text-3xl font-extrabold text-gray-900">1.000+</p>
          <p class="text-gray-600">Paket Terkirim</p>
        </div>
        <div class="bg-white rounded-xl shadow p-6 text-center border border-gray-100">
          <p class="text-3xl font-extrabold text-gray-900">4.9/5</p>
          <p class="text-gray-600">Rata-rata Ulasan</p>
        </div>
      </div>
    </section>

  </main>

  {{-- FOOTER (opsional, samakan dengan beranda bila ada) --}}
  @isset($withFooter)
    @include('components.footer')
  @endisset
</body>
</html>
