<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>TokoKami - Mini Commerce</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        .banner-slider {
            display: flex;
            transition: transform 0.6s ease-in-out;
            width: 200%; /* 2 slides × 100% */
            height: 100%;
        }

        .banner-slide {
            width: 50%; /* 100% / 2 slides */
            height: 100%;
            position: relative;
            flex-shrink: 0;
            background-color: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .banner-slide img {
            max-width: 100%;
            max-height: 100%;
        }

        .product-slider {
            /* Width will be set dynamically by JavaScript */
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Flash Messages -->
    @if(session('success'))
        <div class="fixed top-4 right-4 z-50 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="fixed top-4 right-4 z-50 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
                {{ session('error') }}
            </div>
        </div>
    @endif

    <!-- Include Navbar Component -->
    @include('components.navbar')

    <!-- Hero Banner Section -->
    <section class="relative h-64 md:h-80 overflow-hidden rounded-lg mx-4 mt-4 shadow-lg">
        <div class="banner-slider" id="bannerSlider">
            <!-- Banner 1: Produk Baru -->
            <div class="banner-slide">
                <img src="{{ asset('images/Produk Terbaru.png') }}" 
                     alt="Produk Terbaru" 
                     class="w-full h-full object-contain md:object-cover">
            </div>

            <!-- Banner 2: Flash Sale -->
            <div class="banner-slide">
                <img src="{{ asset('images/Flash Sale.png') }}" 
                     alt="Flash Sale" 
                     class="w-full h-full object-contain md:object-cover">
            </div>
        </div>

        <!-- Navigation buttons -->
        <button class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-white bg-opacity-80 hover:bg-opacity-100 rounded-full p-2 transition-all" onclick="moveBannerSlider(-1)">
            <i class="bi bi-chevron-left text-gray-800"></i>
        </button>
        <button class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-white bg-opacity-80 hover:bg-opacity-100 rounded-full p-2 transition-all" onclick="moveBannerSlider(1)">
            <i class="bi bi-chevron-right text-gray-800"></i>
        </button>

        <!-- Dots indicator -->
        <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2">
            <span class="banner-dot w-3 h-3 bg-white bg-opacity-50 rounded-full cursor-pointer transition-all hover:bg-opacity-100" onclick="currentBannerSlide(1)"></span>
            <span class="banner-dot w-3 h-3 bg-white bg-opacity-50 rounded-full cursor-pointer transition-all hover:bg-opacity-100" onclick="currentBannerSlide(2)"></span>
        </div>
    </section>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Section Produk Terlaris -->
        <section class="mb-12">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-800">PRODUK TERLARIS</h2>
                <a href="{{ route('products.index') }}" class="text-emerald-600 hover:text-emerald-700 font-medium">Lihat Semua →</a>
            </div>

            <!-- Check if there are top selling products -->
            @if($topSellingProducts && $topSellingProducts->count() > 0)
                <!-- Product Grid -->
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 md:gap-6">
                    @foreach($topSellingProducts as $product)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300 group">
                            <!-- Product Image -->
                            <div class="relative aspect-square overflow-hidden bg-gray-100">
                                @if($product->image_url)
                                    <img src="{{ asset('storage/' . $product->image_url) }}" 
                                         alt="{{ $product->name }}" 
                                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-gray-200">
                                        <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 16m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                @endif
                                
                                <!-- Bestseller Badge -->
                                <div class="absolute top-2 left-2 bg-red-500 text-white px-2 py-1 rounded-md text-xs font-medium">
                                    <i class="bi bi-fire mr-1"></i>Terlaris
                                </div>
                                
                                <!-- Total Sold Badge -->
                                <div class="absolute top-2 right-2 bg-emerald-500 text-white px-2 py-1 rounded-md text-xs font-medium">
                                    {{ $product->total_sold }} Terjual
                                </div>
                            </div>

                            <!-- Product Info -->
                            <div class="p-4">
                                <!-- Product Title -->
                                <h3 class="font-semibold text-gray-800 mb-2 line-clamp-2 text-sm md:text-base">
                                    {{ $product->name }}
                                </h3>

                                <!-- Rating -->
                                <div class="flex items-center mb-2">
                                    <div class="flex text-yellow-400 text-sm">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= floor($product->average_rating))
                                                <i class="bi bi-star-fill"></i>
                                            @elseif($i <= ceil($product->average_rating))
                                                <i class="bi bi-star-half"></i>
                                            @else
                                                <i class="bi bi-star"></i>
                                            @endif
                                        @endfor
                                    </div>
                                    <span class="text-gray-500 text-sm ml-1">({{ number_format($product->average_rating, 1) }})</span>
                                </div>

                                <!-- Price -->
                                <div class="mb-3">
                                    <span class="text-emerald-600 font-bold text-lg">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex gap-2">
                                    <button onclick="addToCart({{ $product->id }})" 
                                            class="flex-1 bg-emerald-500 text-white text-sm py-2 px-3 rounded-md hover:bg-emerald-600 transition-colors">
                                        <i class="bi bi-cart-plus mr-1"></i>Keranjang
                                    </button>
                                    <a href="{{ route('products.show', $product->id) }}" 
                                       class="bg-gray-100 text-gray-700 text-sm py-2 px-3 rounded-md hover:bg-gray-200 transition-colors">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Empty State -->
                <div class="bg-white rounded-lg shadow-md p-12 text-center">
                    <div class="w-24 h-24 mx-auto mb-6 bg-gray-100 rounded-full flex items-center justify-center">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-3">Belum ada produk terlaris</h3>
                    <p class="text-gray-600 mb-6 max-w-md mx-auto">
                        Produk terlaris akan muncul di sini berdasarkan data penjualan.
                    </p>

                    @guest
                        <div class="flex flex-col sm:flex-row gap-3 justify-center">
                            <a href="{{ route('login') }}" class="bg-emerald-500 text-white px-6 py-3 rounded-lg hover:bg-emerald-600 transition-colors font-medium">
                                <i class="bi bi-box-arrow-in-right mr-2"></i>Login Sekarang
                            </a>
                            <a href="{{ route('register') }}" class="border border-emerald-500 text-emerald-500 px-6 py-3 rounded-lg hover:bg-emerald-50 transition-colors font-medium">
                                <i class="bi bi-person-plus mr-2"></i>Daftar Akun
                            </a>
                        </div>
                    @else
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 inline-block">
                            <i class="bi bi-info-circle text-blue-500 mr-2"></i>
                            <span class="text-blue-700">Selamat datang, {{ Auth::user()->name }}! Produk terlaris akan segera tersedia.</span>
                        </div>
                    @endguest
                </div>
            @endif
        </section>

        <!-- Section Rekomendasi Toko -->
        <section class="mb-12">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-800">REKOMENDASI TOKO</h2>
                <a href="{{ route('products.index') }}" class="text-emerald-600 hover:text-emerald-700 font-medium">Lihat Semua →</a>
            </div>

            @if($recommendedProducts && $recommendedProducts->count() > 0)
                <!-- Product Slider Container -->
                <div class="relative overflow-hidden">
                    <!-- Product Slider -->
                    <div class="product-slider flex transition-transform duration-500 ease-in-out" id="productSlider">
                        @foreach($recommendedProducts as $product)
                            <div class="flex-shrink-0 w-1/2 md:w-1/3 lg:w-1/4 xl:w-1/5 px-2">
                                @include('components.product-card', ['product' => $product])
                            </div>
                        @endforeach
                    </div>

                    <!-- Navigation buttons -->
                    <button class="absolute left-2 top-1/2 transform -translate-y-1/2 bg-white bg-opacity-90 hover:bg-opacity-100 rounded-full p-2 shadow-lg transition-all z-10" onclick="moveProductSlider(-1)">
                        <i class="bi bi-chevron-left text-gray-800"></i>
                    </button>
                    <button class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-white bg-opacity-90 hover:bg-opacity-100 rounded-full p-2 shadow-lg transition-all z-10" onclick="moveProductSlider(1)">
                        <i class="bi bi-chevron-right text-gray-800"></i>
                    </button>

                    <!-- Dots indicator -->
                    <div class="flex justify-center mt-4 space-x-2" id="productDotsContainer">
                        <!-- Dots will be generated dynamically by JavaScript -->
                    </div>
                </div>
            @else
                <!-- Empty State when no products -->
                <div class="bg-white rounded-lg shadow-md p-12 text-center">
                    <div class="w-24 h-24 mx-auto mb-6 bg-gray-100 rounded-full flex items-center justify-center">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-3">Belum ada produk untuk direkomendasikan</h3>
                    <p class="text-gray-600 mb-6 max-w-md mx-auto">
                        Produk akan muncul di sini setelah admin menambahkan produk ke database.
                    </p>
                    @auth
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.products.index') }}" class="bg-emerald-500 text-white px-6 py-3 rounded-lg hover:bg-emerald-600 transition-colors font-medium">
                                <i class="bi bi-plus-circle mr-2"></i>Tambah Produk
                            </a>
                        @endif
                    @endauth
                </div>
            @endif
        </section>
    </main>

    <!-- Include Footer Component -->
    @include('components.footer')

    <script>
        let currentBannerIndex = 0;
        const totalBanners = 2; // Total number of banner slides
        const bannerSlider = document.getElementById('bannerSlider');
        const bannerDots = document.querySelectorAll('.banner-dot');
        let autoBannerInterval;

        // Function to move banner slider
        function moveBannerSlider(direction) {
            currentBannerIndex += direction;

            if (currentBannerIndex < 0) {
                currentBannerIndex = totalBanners - 1;
            } else if (currentBannerIndex >= totalBanners) {
                currentBannerIndex = 0;
            }

            updateBannerSlider();
        }

        // Function to go to specific banner slide
        function currentBannerSlide(slideNumber) {
            currentBannerIndex = slideNumber - 1;
            updateBannerSlider();
        }

        // Function to update banner slider position and dots
        function updateBannerSlider() {
            const translateX = currentBannerIndex * -50; // 50% per slide
            bannerSlider.style.transform = `translateX(${translateX}%)`;

            // Update dots
            bannerDots.forEach((dot, index) => {
                if (index === currentBannerIndex) {
                    dot.classList.remove('bg-opacity-50');
                    dot.classList.add('bg-opacity-100');
                } else {
                    dot.classList.remove('bg-opacity-100');
                    dot.classList.add('bg-opacity-50');
                }
            });
        }

        // Auto-slide functionality for banner
        function startAutoBanner() {
            autoBannerInterval = setInterval(() => {
                moveBannerSlider(1);
            }, 5000); // 5 seconds
        }

        // Stop auto-slide when user interacts
        function stopAutoBanner() {
            clearInterval(autoBannerInterval);
        }

        // Restart auto-slide after user interaction
        function restartAutoBanner() {
            stopAutoBanner();
            setTimeout(startAutoBanner, 10000); // Restart after 10 seconds
        }

        // Event listeners for manual navigation
        document.querySelector('.banner-slide').parentElement.addEventListener('mouseenter', stopAutoBanner);
        document.querySelector('.banner-slide').parentElement.addEventListener('mouseleave', startAutoBanner);

        // Start auto-slide when page loads
        document.addEventListener('DOMContentLoaded', () => {
            updateBannerSlider(); // Initialize first slide
            startAutoBanner();
            initProductSlider(); // Initialize product slider
            
            // Auto-hide flash messages after 5 seconds
            const flashMessages = document.querySelectorAll('.fixed.top-4.right-4');
            flashMessages.forEach(message => {
                setTimeout(() => {
                    message.style.transform = 'translateX(100%)';
                    message.style.transition = 'transform 0.3s ease';
                    setTimeout(() => message.remove(), 300);
                }, 5000);
            });
        });

        // Product Slider Variables
        let currentProductIndex = 0;
        let itemsPerSlide = 5; // Default for xl screens
        let totalProductSlides = 0;
        const productSlider = document.getElementById('productSlider');

        // Initialize product slider
        function initProductSlider() {
            if (!productSlider) return;
            
            updateItemsPerSlide();
            const totalProducts = {{ $recommendedProducts ? $recommendedProducts->count() : 0 }};
            totalProductSlides = Math.ceil(totalProducts / itemsPerSlide);
            
            generateProductDots();
            updateProductSlider();
            
            // Update on window resize
            window.addEventListener('resize', () => {
                updateItemsPerSlide();
                totalProductSlides = Math.ceil(totalProducts / itemsPerSlide);
                currentProductIndex = Math.min(currentProductIndex, totalProductSlides - 1);
                generateProductDots();
                updateProductSlider();
            });
        }

        // Generate dots dynamically
        function generateProductDots() {
            const dotsContainer = document.getElementById('productDotsContainer');
            if (!dotsContainer) return;
            
            dotsContainer.innerHTML = '';
            
            for (let i = 0; i < totalProductSlides; i++) {
                const dot = document.createElement('span');
                dot.className = 'product-dot w-3 h-3 bg-gray-300 rounded-full cursor-pointer transition-all hover:bg-emerald-500';
                dot.onclick = () => currentProductSlide(i + 1);
                dotsContainer.appendChild(dot);
            }
        }

        // Update items per slide based on screen size
        function updateItemsPerSlide() {
            const width = window.innerWidth;
            if (width < 768) {
                itemsPerSlide = 2; // Mobile
            } else if (width < 1024) {
                itemsPerSlide = 3; // Tablet
            } else if (width < 1280) {
                itemsPerSlide = 4; // Desktop
            } else {
                itemsPerSlide = 5; // Large desktop
            }
        }

        // Function to move product slider
        function moveProductSlider(direction) {
            currentProductIndex += direction;

            if (currentProductIndex < 0) {
                currentProductIndex = totalProductSlides - 1;
            } else if (currentProductIndex >= totalProductSlides) {
                currentProductIndex = 0;
            }

            updateProductSlider();
        }

        // Function to go to specific product slide
        function currentProductSlide(slideNumber) {
            currentProductIndex = slideNumber - 1;
            updateProductSlider();
        }

        // Function to update product slider position and dots
        function updateProductSlider() {
            if (!productSlider) return;
            
            // Set slider width based on total products
            const totalProducts = {{ $recommendedProducts ? $recommendedProducts->count() : 0 }};
            const sliderWidth = (totalProducts / itemsPerSlide) * 100;
            productSlider.style.width = `${sliderWidth}%`;
            
            const translateX = currentProductIndex * -(100 / totalProductSlides);
            productSlider.style.transform = `translateX(${translateX}%)`;

            // Update dots
            const currentProductDots = document.querySelectorAll('.product-dot');
            currentProductDots.forEach((dot, index) => {
                if (index === currentProductIndex) {
                    dot.classList.remove('bg-gray-300');
                    dot.classList.add('bg-emerald-500');
                } else {
                    dot.classList.remove('bg-emerald-500');
                    dot.classList.add('bg-gray-300');
                }
            });
        }

        // Add to Cart functionality
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
