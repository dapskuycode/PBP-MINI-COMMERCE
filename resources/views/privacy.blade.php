<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Kebijakan Privasi - TumbasLek Mini Commerce</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800 leading-relaxed">
  <div class="max-w-3xl mx-auto py-10 px-6">
    <h1 class="text-3xl font-bold text-emerald-700 mb-6">Kebijakan Privasi</h1>
    <p class="mb-4">Kebijakan Privasi ini menjelaskan bagaimana <strong>Mini Commerce</strong> mengumpulkan, menggunakan, dan melindungi data pribadi Anda.</p>

    <h2 class="text-xl font-semibold text-gray-700 mt-6 mb-2">1. Data yang Dikumpulkan</h2>
    <p class="mb-3">Kami mengumpulkan data yang Anda berikan saat pendaftaran (nama, username, email, password) dan data aktivitas saat menggunakan layanan.</p>

    <h2 class="text-xl font-semibold text-gray-700 mt-6 mb-2">2. Penggunaan Data</h2>
    <p class="mb-3">Data digunakan untuk: (a) memverifikasi akun, (b) memproses transaksi, (c) meningkatkan pengalaman pengguna, dan (d) komunikasi terkait layanan.</p>

    <h2 class="text-xl font-semibold text-gray-700 mt-6 mb-2">3. Perlindungan Data</h2>
    <p class="mb-3">Kami berkomitmen menjaga keamanan data pribadi Anda. Namun, kami tidak dapat menjamin keamanan penuh dari ancaman pihak ketiga.</p>

    <h2 class="text-xl font-semibold text-gray-700 mt-6 mb-2">4. Pembagian Data</h2>
    <p class="mb-3">Mini Commerce tidak menjual atau membagikan data pribadi kepada pihak ketiga tanpa persetujuan Anda, kecuali diwajibkan hukum.</p>

    <h2 class="text-xl font-semibold text-gray-700 mt-6 mb-2">5. Perubahan</h2>
    <p class="mb-3">Kebijakan ini dapat diperbarui sewaktu-waktu. Perubahan akan diumumkan di situs ini.</p>

    <p class="mt-8 text-sm text-gray-600">Terakhir diperbarui: {{ now()->format('d F Y') }}</p>

    <a href="{{ url('/register') }}" class="inline-block mt-6 text-emerald-600 hover:underline">← Kembali ke Pendaftaran</a>
  </div>
</body>
</html>
