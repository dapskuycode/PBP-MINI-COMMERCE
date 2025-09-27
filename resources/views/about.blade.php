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

    {{-- HERO STRIP (gaya sama seperti banner kecil) --}}
    <section class="rounded-xl bg-emerald-700 text-white p-6 sm:p-8 shadow-md">
      <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">Tentang TokoKami</h1>
      <p class="mt-2 text-emerald-50 max-w-3xl">
        Usaha rumahan satu orang yang menghadirkan <b>makanan khas daerah</b> dalam kemasan praktis & higienis.
        Fokus pada rasa otentik, bahan lokal, dan pelayanan ramah.
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
          <h3 class="font-semibold text-gray-900">Homemade & Segar</h3>
          <p class="mt-2 text-gray-600">Diproduksi dalam batch kecil agar rasa konsisten dan selalu fresh.</p>
        </div>
        <div class="bg-white rounded-xl shadow p-5 border border-gray-100">
          <h3 class="font-semibold text-gray-900">Bahan Lokal Terpilih</h3>
          <p class="mt-2 text-gray-600">Mengutamakan bahan dari produsen lokal untuk rasa otentik.</p>
        </div>
        <div class="bg-white rounded-xl shadow p-5 border border-gray-100">
          <h3 class="font-semibold text-gray-900">Kemasan Beragam</h3>
          <p class="mt-2 text-gray-600">Ukuran 50g–500g, beberapa varian <i>vacuum-sealed</i>, food-grade.</p>
        </div>
      </div>
    </section>

    {{-- SECTION CERITA (gaya card besar) --}}
    <section class="mt-8">
      <div class="bg-white rounded-xl shadow p-6 border border-gray-100">
        <h2 class="text-xl sm:text-2xl font-extrabold text-gray-900">Cerita Singkat</h2>
        <div class="mt-4 grid md:grid-cols-2 gap-6">
          <div>
            <p class="text-gray-700">
              Berawal dari dapur rumah, saya mulai meracik camilan khas Nusantara seperti keripik, sambal, kue kering,
              dan bumbu instan. Seiring waktu, saya menambah <b>varian kemasan</b> agar mudah dibawa dan disimpan.
            </p>
            <p class="mt-3 text-gray-700">
              Kini pesanan bisa dikirim ke luar kota. Saya mengutamakan kualitas rasa, kebersihan,
              dan pelayanan—walau dikerjakan seorang diri, pesanan tetap diusahakan rapi & tepat waktu.
            </p>
          </div>
          <ul class="space-y-3">
            <li class="flex items-start gap-3">
              <span class="mt-1 w-2 h-2 rounded-full bg-emerald-600"></span>
              Fresh batch berkala, tanpa bahan berbahaya.
            </li>
            <li class="flex items-start gap-3">
              <span class="mt-1 w-2 h-2 rounded-full bg-emerald-600"></span>
              Pre-order & paket hampers (bisa custom isi).
            </li>
            <li class="flex items-start gap-3">
              <span class="mt-1 w-2 h-2 rounded-full bg-emerald-600"></span>
              Info masa simpan & saran penyajian jelas di label.
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
