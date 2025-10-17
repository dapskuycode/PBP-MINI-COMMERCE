<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - TokoKami</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</head>
<body class="bg-gray-50">
    {{-- Navbar --}}
    @include('components.navbar', ['isAdmin' => auth()->check() && auth()->user()->is_admin])

    <div class="container mx-auto px-4 py-4" style="margin-top:40px">
        {{-- Header --}}
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">All Products</h1>
            <p class="text-gray-600">Discover our complete collection of products</p>
        </div>

        {{-- GRID: Sidebar kategori (3) + Konten produk (9) --}}
        <div class="grid grid-cols-12 gap-6">
            {{-- Sidebar Kiri: kategori vertikal (1 baris = 1 item) --}}
            <aside class="col-span-12 md:col-span-3">
                <div class="sticky top-24 rounded-2xl bg-white border border-gray-200 shadow-sm p-5">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="h-8 w-8 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center">🏷️</div>
                        <h2 class="font-semibold">Kategori</h2>
                    </div>

                    @php
                        // Pakai $categories dari controller jika ada; kalau belum, fallback contoh
                        $fallback = collect([
                            (object)['name'=>'Semua','slug'=>'semua'],
                            (object)['name'=>'Makanan Manis','slug'=>'makanan','emoji'=>'🍰'],
                            (object)['name'=>'Minuman','slug'=>'minuman','emoji'=>'🧃'],
                            (object)['name'=>'Makanan Kemasan','slug'=>'fashion','emoji'=>'👗'],
                        ]);
                        $cats = (isset($categories) && count($categories)) ? $categories : $fallback;
                    @endphp

                    <ul class="space-y-2">
                        @foreach($cats as $cat)
                            <li>
                                {{-- Belum aktif diklik → pakai button --}}
                                <button type="button"
                                        class="w-full flex items-center justify-between rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-sm hover:bg-gray-50">
                                    <span class="flex items-center gap-2">
                                        <span class="text-lg">{{ $cat->emoji ?? '🏷️' }}</span>
                                        <span class="font-medium text-gray-700">{{ $cat->name }}</span>
                                    </span>
                                    <span class="text-gray-400">›</span>
                                </button>
                            </li>
                        @endforeach
                    </ul>

                    {{-- Catatan kecil (opsional) --}}
                    <p class="mt-4 text-xs text-gray-500 leading-relaxed">
                        Nanti kalau mau diaktifkan, ubah tombol jadi link ke
                        <code class="bg-gray-100 px-1 rounded">/products?category=slug-kategori</code>.
                    </p>
                </div>
            </aside>

            {{-- Konten Produk --}}
            <section class="col-span-12 md:col-span-9">
                @if($products->count() > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 gap-6 mb-8">
                        @foreach($products as $product)
                            @include('components.product-card', ['product' => $product])
                        @endforeach
                    </div>

                    <div class="flex justify-center">
                        {{ $products->links() }}
                    </div>
                @else
                    <div class="text-center py-16 rounded-2xl bg-white border border-gray-200">
                        <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No products available</h3>
                        <p class="text-gray-500">Check back later for new products.</p>
                    </div>
                @endif
            </section>
        </div>
    </div>

    {{-- Footer --}}
    @include('components.footer')

    {{-- Add to Cart (tetap seperti punyamu) --}}
    <script>
        function addToCart(productId) {
            fetch('/cart/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ product_id: productId, quantity: 1 })
            })
            .then(response => {
                if (response.status === 302 || response.redirected || response.url.includes('/login')) {
                    if (confirm('Anda perlu login untuk menambahkan produk ke keranjang. Login sekarang?')) {
                        window.location.href = '/login';
                    }
                    return null;
                }
                if (!response.ok) {
                    if (response.status === 419) {
                        showModal('Session Expired', 'Session expired. Please refresh the page and try again.', 'error');
                        return null;
                    }
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data === null) return;
                
                if (data && data.success) {
                    showModal('Berhasil!', 'Produk berhasil ditambahkan ke keranjang', 'success');
                } else if (data && data.already_exists) {
                    showModal('Produk Sudah Ada', 'Produk ini sudah ada di keranjang Anda', 'warning');
                } else if (data && data.message) {
                    showModal('Error', data.message, 'error');
                } else {
                    showModal('Error', 'Unexpected response format', 'error');
                }
            })
            .catch(error => {
                console.error('Cart error details:', error);
                showModal('Error', 'Terjadi kesalahan saat menambahkan produk ke keranjang. Silakan coba lagi.', 'error');
            });
        }
    </script>
    {{-- Modal untuk feedback --}}
    <div id="modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-md w-full mx-4 shadow-2xl">
            <div class="p-6 text-center">
                <div id="modal-icon" class="w-16 h-16 mx-auto mb-4 rounded-full flex items-center justify-center">
                    <!-- Icon akan diatur via JavaScript -->
                </div>
                <h3 id="modal-title" class="text-xl font-bold mb-2"></h3>
                <p id="modal-message" class="text-gray-600 mb-6"></p>
                <button onclick="closeModal()" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-3 px-6 rounded-xl transition duration-200">
                    Tutup
                </button>
            </div>
        </div>
    </div>
    
    <script>
        // Modal functions
        function showModal(title, message, type = 'success') {
            const modal = document.getElementById('modal');
            const modalIcon = document.getElementById('modal-icon');
            const modalTitle = document.getElementById('modal-title');
            const modalMessage = document.getElementById('modal-message');

            // Set icon and colors based on type
            if (type === 'success') {
                modalIcon.className = 'w-16 h-16 mx-auto mb-4 rounded-full flex items-center justify-center bg-emerald-100';
                modalIcon.innerHTML = '<svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>';
            } else if (type === 'warning') {
                modalIcon.className = 'w-16 h-16 mx-auto mb-4 rounded-full flex items-center justify-center bg-amber-100';
                modalIcon.innerHTML = '<svg class="w-8 h-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L4.268 13.5c-.77.833.192 2.5 1.732 2.5z"></path></svg>';
            } else if (type === 'error') {
                modalIcon.className = 'w-16 h-16 mx-auto mb-4 rounded-full flex items-center justify-center bg-red-100';
                modalIcon.innerHTML = '<svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>';
            }

            modalTitle.textContent = title;
            modalMessage.textContent = message;
            modal.classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('modal').classList.add('hidden');
        }

        // Close modal when clicking outside
        document.getElementById('modal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });
    </script>
</body>
</html>
