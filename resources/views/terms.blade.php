<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Syarat & Ketentuan - TumbasLek Mini Commerce</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800 leading-relaxed">
  <div class="max-w-3xl mx-auto py-10 px-6">
    <h1 class="text-3xl font-bold text-emerald-700 mb-6">Syarat & Ketentuan</h1>
    <p class="mb-4">Dengan menggunakan layanan <strong>Mini Commerce</strong>, Anda dianggap telah membaca, memahami, dan menyetujui Syarat & Ketentuan berikut:</p>

    <h2 class="text-xl font-semibold text-gray-700 mt-6 mb-2">1. Pendaftaran Akun</h2>
    <p class="mb-3">Pengguna wajib mendaftar dengan informasi yang benar, termasuk nama, username, email, dan password. Pengguna bertanggung jawab menjaga kerahasiaan akun dan password.</p>

    <h2 class="text-xl font-semibold text-gray-700 mt-6 mb-2">2. Penggunaan Layanan</h2>
    <p class="mb-3">Mini Commerce hanya digunakan untuk aktivitas jual-beli yang sah. Dilarang menggunakan layanan untuk aktivitas ilegal, penipuan, atau melanggar hukum yang berlaku di Indonesia.</p>

    <h2 class="text-xl font-semibold text-gray-700 mt-6 mb-2">3. Produk dan Transaksi</h2>
    <p class="mb-3">Setiap penjual bertanggung jawab atas kebenaran deskripsi, harga, dan kondisi produk. Mini Commerce tidak bertanggung jawab atas kerugian yang timbul dari transaksi antar pengguna.</p>

    <h2 class="text-xl font-semibold text-gray-700 mt-6 mb-2">4. Batasan Tanggung Jawab</h2>
    <p class="mb-3">Mini Commerce menyediakan platform sebagai penghubung. Segala bentuk sengketa antara penjual dan pembeli diselesaikan secara mandiri.</p>

    <h2 class="text-xl font-semibold text-gray-700 mt-6 mb-2">5. Perubahan</h2>
    <p class="mb-3">Mini Commerce berhak mengubah Syarat & Ketentuan kapan saja. Perubahan akan diumumkan melalui situs ini.</p>

    <p class="mt-8 text-sm text-gray-600">Terakhir diperbarui: {{ now()->format('d F Y') }}</p>

    <a href="{{ url('/register') }}" class="inline-block mt-6 text-emerald-600 hover:underline">← Kembali ke Pendaftaran</a>
  </div>
</body>
</html>
