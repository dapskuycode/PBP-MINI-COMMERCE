<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} • TokoKami</title>
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
            <a href="#" class="hover:text-emerald-600">{{ $product->category->name ?? 'Kategori' }}</a>
            <span class="mx-2">/</span>
            <span class="text-gray-700 font-medium">{{ $product->name }}</span>
        </nav>

        <div class="grid lg:grid-cols-2 gap-8 mb-12">
            <!-- Product Images -->
            <div class="space-y-4">
                <div class="aspect-square bg-white rounded-xl shadow border border-gray-100 overflow-hidden">
                    @if($product->photos && $product->photos->count() > 0)
                        <img src="{{ asset('storage/' . $product->photos->first()->url) }}" 
                             alt="{{ $product->name }}" 
                             class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                            <div class="text-center">
                                <svg class="w-16 h-16 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <span class="text-sm text-gray-500">Foto Produk</span>
                            </div>
                        </div>
                    @endif
                </div>
                
                <!-- Thumbnail Gallery -->
                @if($product->photos && $product->photos->count() > 1)
                    <div class="grid grid-cols-4 gap-2">
                        @foreach($product->photos->take(4) as $photo)
                            <div class="aspect-square bg-white rounded-lg shadow border border-gray-100 overflow-hidden cursor-pointer hover:ring-2 hover:ring-emerald-500">
                                <img src="{{ asset('storage/' . $photo->url) }}" 
                                     alt="{{ $product->name }}" 
                                     class="w-full h-full object-cover">
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Product Info -->
            <div class="space-y-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">{{ $product->name }}</h1>
                    <p class="text-sm text-gray-500 mt-1">{{ $product->category->name ?? 'Kategori' }}</p>
                </div>

                <div class="flex items-center gap-4">
                    <div class="text-3xl font-bold text-emerald-600">
                        {{ $product->formatted_price }}
                    </div>
                    @if($product->stock > 0)
                        <span class="px-3 py-1 bg-emerald-100 text-emerald-800 text-sm font-medium rounded-full">
                            Stok: {{ $product->stock }}
                        </span>
                    @else
                        <span class="px-3 py-1 bg-red-100 text-red-800 text-sm font-medium rounded-full">
                            Stok Habis
                        </span>
                    @endif
                </div>

                <!-- Product Variants -->
                @if($product->variants && $product->variants->count() > 0)
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Pilih Varian</h3>
                        <div class="grid grid-cols-2 gap-3">
                            @foreach($product->variants as $variant)
                                <label class="cursor-pointer">
                                    <input type="radio" name="variant" value="{{ $variant->id }}" class="sr-only peer">
                                    <div class="p-3 bg-white border border-gray-200 rounded-lg peer-checked:border-emerald-500 peer-checked:bg-emerald-50 hover:border-emerald-300">
                                        <div class="font-medium text-gray-900">{{ $variant->name }}</div>
                                        <div class="text-sm text-gray-500">+Rp {{ number_format($variant->price_adjustment, 0, ',', '.') }}</div>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Quantity Selector -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Jumlah</h3>
                    <div class="flex items-center gap-3">
                        <button id="decreaseQty" class="w-10 h-10 rounded-lg bg-gray-100 text-gray-700 flex items-center justify-center hover:bg-gray-200">
                            −
                        </button>
                        <input type="number" id="quantity" value="1" min="1" max="{{ $product->stock }}" 
                               class="w-20 text-center border border-gray-300 rounded-lg py-2">
                        <button id="increaseQty" class="w-10 h-10 rounded-lg bg-gray-100 text-gray-700 flex items-center justify-center hover:bg-gray-200">
                            +
                        </button>
                    </div>
                </div>

                <!-- Add to Cart Button -->
                <div class="space-y-3">
                    @if($product->stock > 0)
                        <button id="addToCartBtn" 
                                class="w-full bg-emerald-600 text-white py-3 px-6 rounded-lg font-semibold hover:bg-emerald-700 flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m2.6 8L6 4H3M7 13L5.4 5M7 13l-2.293 2.293c-.39.39-.586.902-.586 1.414v.293h12m-10 2a1 1 0 012 0v.293m-2-.293a1 1 0 002 0M17 21a2 2 0 100-4 2 2 0 000 4z"></path>
                            </svg>
                            Tambah ke Keranjang
                        </button>
                    @else
                        <button disabled class="w-full bg-gray-400 text-white py-3 px-6 rounded-lg font-semibold cursor-not-allowed">
                            Stok Habis
                        </button>
                    @endif
                    
                    <button class="w-full border border-emerald-600 text-emerald-600 py-3 px-6 rounded-lg font-semibold hover:bg-emerald-50">
                        Beli Sekarang
                    </button>
                </div>

                <!-- Product Description -->
                @if($product->description)
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Deskripsi Produk</h3>
                        <div class="prose text-gray-700">
                            <p>{{ $product->description }}</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Reviews Section -->
        @if($product->reviews && $product->reviews->count() > 0)
            <section class="bg-white rounded-xl shadow border border-gray-100 p-6 mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Ulasan Pembeli</h2>
                
                <div class="space-y-6">
                    @foreach($product->reviews->take(5) as $review)
                        <div class="border-b border-gray-100 last:border-b-0 pb-6 last:pb-0">
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 bg-emerald-100 rounded-full flex items-center justify-center">
                                    <span class="text-emerald-600 font-semibold">
                                        {{ substr($review->user->name ?? 'User', 0, 1) }}
                                    </span>
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-2">
                                        <h4 class="font-semibold text-gray-900">{{ $review->user->name ?? 'Anonymous' }}</h4>
                                        <div class="flex items-center">
                                            @for($i = 1; $i <= 5; $i++)
                                                <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}" 
                                                     fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                                </svg>
                                            @endfor
                                        </div>
                                    </div>
                                    <p class="text-gray-700">{{ $review->comment }}</p>
                                    <p class="text-sm text-gray-500 mt-2">{{ $review->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif

        <!-- Related Products -->
        @if(isset($relatedProducts) && $relatedProducts && $relatedProducts->count() > 0)
            <section class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Produk Serupa</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    @foreach($relatedProducts as $relatedProduct)
                        @include('components.product-card', ['product' => $relatedProduct])
                    @endforeach
                </div>
            </section>
        @endif
    </main>

    @include('components.footer')

    <script>
        // Quantity controls
        const decreaseBtn = document.getElementById('decreaseQty');
        const increaseBtn = document.getElementById('increaseQty');
        const quantityInput = document.getElementById('quantity');
        const addToCartBtn = document.getElementById('addToCartBtn');

        if (decreaseBtn && increaseBtn && quantityInput) {
            decreaseBtn.addEventListener('click', () => {
                const currentValue = parseInt(quantityInput.value);
                if (currentValue > 1) {
                    quantityInput.value = currentValue - 1;
                }
            });

            increaseBtn.addEventListener('click', () => {
                const currentValue = parseInt(quantityInput.value);
                const maxStock = parseInt(quantityInput.getAttribute('max'));
                if (currentValue < maxStock) {
                    quantityInput.value = currentValue + 1;
                }
            });
        }

        // Add to cart functionality
        if (addToCartBtn) {
            addToCartBtn.addEventListener('click', async () => {
                const quantity = parseInt(quantityInput.value);
                const variantId = document.querySelector('input[name="variant"]:checked')?.value || null;
                
                try {
                    addToCartBtn.disabled = true;
                    addToCartBtn.innerHTML = 'Menambahkan...';
                    
                    const response = await fetch('/cart/add', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            product_id: {{ $product->id }},
                            quantity: quantity,
                            variant_id: variantId
                        })
                    });

                    // Check if the response is a redirect (authentication required)
                    if (response.redirected || response.url.includes('/login')) {
                        if (confirm('Anda perlu login untuk menambahkan produk ke keranjang. Login sekarang?')) {
                            window.location.href = '/login';
                        }
                        return;
                    }
                    
                    // Check for other HTTP errors
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }

                    const result = await response.json();
                    
                    if (result.success) {
                        // Update cart count in navbar if exists
                        const cartCount = document.querySelector('.cart-count');
                        if (cartCount && result.cart_count) {
                            cartCount.textContent = result.cart_count;
                            cartCount.classList.remove('hidden');
                        }
                        
                        // Show success message
                        alert('Produk berhasil ditambahkan ke keranjang!');
                    } else {
                        alert(result.message || 'Gagal menambahkan produk ke keranjang');
                    }
                    
                } catch (error) {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan. Silakan coba lagi.');
                } finally {
                    addToCartBtn.disabled = false;
                    addToCartBtn.innerHTML = `
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m2.6 8L6 4H3M7 13L5.4 5M7 13l-2.293 2.293c-.39.39-.586.902-.586 1.414v.293h12m-10 2a1 1 0 012 0v.293m-2-.293a1 1 0 002 0M17 21a2 2 0 100-4 2 2 0 000 4z"></path>
                        </svg>
                        Tambah ke Keranjang
                    `;
                }
            });
        }

        // Image gallery functionality
        const thumbnails = document.querySelectorAll('.grid img');
        const mainImage = document.querySelector('.aspect-square img');
        
        if (thumbnails.length > 0 && mainImage) {
            thumbnails.forEach(thumbnail => {
                thumbnail.addEventListener('click', () => {
                    mainImage.src = thumbnail.src;
                    
                    // Remove active state from all thumbnails
                    thumbnails.forEach(t => t.parentElement.classList.remove('ring-2', 'ring-emerald-500'));
                    // Add active state to clicked thumbnail
                    thumbnail.parentElement.classList.add('ring-2', 'ring-emerald-500');
                });
            });
        }
    </script>
</body>
</html>