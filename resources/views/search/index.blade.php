<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@if($query) Hasil Pencarian "{{ $query }}" @else Cari Produk @endif • TokoKami</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-gray-50">
    @include('components.navbar')

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <!-- Breadcrumb -->
        <nav class="text-sm text-gray-500 mb-4">
            <a href="{{ route('home') }}" class="hover:text-emerald-600">Beranda</a>
            <span class="mx-2">/</span>
            <span class="text-gray-700 font-medium">
                @if($query) Hasil Pencarian "{{ $query }}" @else Cari Produk @endif
            </span>
        </nav>

        <div class="lg:grid lg:grid-cols-4 lg:gap-8">
            <!-- Sidebar Filters -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-md p-6 mb-6 lg:mb-0">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Filter Pencarian</h3>
                    
                    <form method="GET" action="{{ route('search') }}" id="filterForm">
                        @if($query)
                            <input type="hidden" name="q" value="{{ $query }}">
                        @endif
                        
                        <!-- Category Filter -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                            <select name="category_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-emerald-500 focus:border-emerald-500" onchange="document.getElementById('filterForm').submit();">
                                <option value="">Semua Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ $categoryId == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }} ({{ $category->products_count }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Sort Options -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Urutkan</label>
                            <select name="sort" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-emerald-500 focus:border-emerald-500" onchange="document.getElementById('filterForm').submit();">
                                <option value="name" {{ $sortBy == 'name' ? 'selected' : '' }}>Nama (A-Z)</option>
                                <option value="price_low" {{ $sortBy == 'price_low' ? 'selected' : '' }}>Harga Terendah</option>
                                <option value="price_high" {{ $sortBy == 'price_high' ? 'selected' : '' }}>Harga Tertinggi</option>
                                <option value="newest" {{ $sortBy == 'newest' ? 'selected' : '' }}>Terbaru</option>
                                <option value="popular" {{ $sortBy == 'popular' ? 'selected' : '' }}>Terpopuler</option>
                            </select>
                        </div>

                        <!-- Price Range -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Rentang Harga</label>
                            <div class="space-y-2">
                                <input type="number" name="min_price" placeholder="Harga minimum" 
                                       value="{{ $minPrice }}"
                                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-emerald-500 focus:border-emerald-500">
                                <input type="number" name="max_price" placeholder="Harga maksimum" 
                                       value="{{ $maxPrice }}"
                                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-emerald-500 focus:border-emerald-500">
                            </div>
                            <button type="submit" class="mt-2 w-full bg-emerald-600 text-white py-2 px-4 rounded-lg hover:bg-emerald-700 text-sm">
                                Terapkan Filter
                            </button>
                        </div>
                    </form>

                    <!-- Clear Filters -->
                    @if(request()->hasAny(['category_id', 'sort', 'min_price', 'max_price']) && ($categoryId || $sortBy != 'name' || $minPrice || $maxPrice))
                        <a href="{{ route('search', ['q' => $query]) }}" 
                           class="block text-center text-sm text-emerald-600 hover:text-emerald-700 font-medium">
                            Hapus Semua Filter
                        </a>
                    @endif
                </div>
            </div>

            <!-- Main Content -->
            <div class="lg:col-span-3">
                <!-- Search Header -->
                <div class="bg-white rounded-xl shadow-md p-6 mb-6">
                    <div class="flex items-center justify-between">
                        <div>
                            @if($query)
                                <h1 class="text-2xl font-bold text-gray-900">Hasil Pencarian "{{ $query }}"</h1>
                                <p class="text-gray-600 mt-1">{{ $products->total() }} produk ditemukan</p>
                            @else
                                <h1 class="text-2xl font-bold text-gray-900">Cari Produk</h1>
                                <p class="text-gray-600 mt-1">Gunakan kotak pencarian untuk menemukan produk yang Anda inginkan</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Search Results -->
                @if($products->count() > 0)
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-6 mb-8">
                        @foreach($products as $product)
                            @include('components.product-card', ['product' => $product])
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="flex justify-center">
                        {{ $products->withQueryString()->links() }}
                    </div>
                @else
                    <!-- Empty State -->
                    <div class="bg-white rounded-xl shadow-md p-12 text-center">
                        <div class="w-16 h-16 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">
                            @if($query) Tidak ada hasil untuk "{{ $query }}" @else Mulai pencarian Anda @endif
                        </h3>
                        <p class="text-gray-600 mb-4">
                            @if($query) 
                                Coba gunakan kata kunci yang berbeda atau kurangi filter pencarian.
                            @else
                                Gunakan kotak pencarian di atas untuk menemukan produk yang Anda cari.
                            @endif
                        </p>
                        
                        @if(request()->hasAny(['category_id', 'sort', 'min_price', 'max_price']))
                            <a href="{{ route('search', ['q' => $query]) }}" 
                               class="inline-flex items-center px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 mr-3">
                                Hapus Filter
                            </a>
                        @endif
                        
                        <a href="{{ route('home') }}" 
                           class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">
                            Lihat Semua Produk
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </main>

    @include('components.footer')

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

    <!-- Add to Cart Script -->
    <script>
        function addToCart(productId) {
            fetch('/cart/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    product_id: productId,
                    quantity: 1
                })
            })
            .then(response => {
                console.log('Response status:', response.status);
                console.log('Response URL:', response.url);
                console.log('Response redirected:', response.redirected);
                
                // Check for authentication required (redirect to login)
                if (response.status === 302 || response.redirected || response.url.includes('/login')) {
                    showLoginModal();
                    return null;
                }
                
                // Check for other HTTP errors
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
                if (data === null) return; // Handle redirect case
                
                if (data && data.success) {
                    showModal('Berhasil!', 'Produk berhasil ditambahkan ke keranjang!', 'success');
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

        // Show login required modal
        function showLoginModal() {
            const modal = document.getElementById('modal');
            const modalIcon = document.getElementById('modal-icon');
            const modalTitle = document.getElementById('modal-title');
            const modalMessage = document.getElementById('modal-message');
            const modalButton = modal.querySelector('button');

            // Set login required style
            modalIcon.className = 'w-16 h-16 mx-auto mb-4 rounded-full flex items-center justify-center bg-blue-100';
            modalIcon.innerHTML = '<svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>';

            modalTitle.textContent = 'Login Diperlukan';
            modalMessage.textContent = 'Anda perlu login untuk menambahkan produk ke keranjang';
            
            // Change button to redirect to login
            modalButton.textContent = 'Login Sekarang';
            modalButton.onclick = function() {
                window.location.href = '/login';
            };

            modal.classList.remove('hidden');
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