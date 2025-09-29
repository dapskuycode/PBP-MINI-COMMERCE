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
            width: 400%; /* 4 slides × 100% */
            height: 100%;
        }

        .banner-slide {
            width: 25%; /* 100% / 4 slides */
            height: 100%;
            color: white;
            position: relative;
            flex-shrink: 0;
            background-size: cover;
            background-position: center;
        }

        .banner-slide::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.3);
        }

        .product-slider {
            /* Width will be set dynamically by JavaScript */
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Include Navbar Component -->
    @include('components.navbar')

    <!-- Hero Banner Section -->
    <section class="relative h-64 md:h-80 overflow-hidden rounded-lg mx-4 mt-4 shadow-lg">
        <div class="banner-slider" id="bannerSlider">
            <!-- Banner 1: Diskon Besar -->
            <div class="banner-slide bg-gradient-to-r from-red-500 to-red-600">
                <div class="relative z-10 flex items-center h-full px-8">
                    <div>
                        <h2 class="text-3xl md:text-5xl font-bold mb-4">DISKON BESAR 50%</h2>
                        <p class="text-lg md:text-xl mb-6 opacity-90">Semua Produk Makanan & Minuman</p>
                        <button class="bg-yellow-400 text-gray-900 px-6 py-3 rounded-lg font-semibold hover:bg-yellow-300 transition-colors">
                            BELANJA SEKARANG
                        </button>
                    </div>
                </div>
            </div>

            <!-- Banner 2: Produk Baru -->
            <div class="banner-slide bg-gradient-to-r from-emerald-500 to-emerald-600">
                <div class="relative z-10 flex items-center h-full px-8">
                    <div>
                        <h2 class="text-3xl md:text-5xl font-bold mb-4">PRODUK TERBARU</h2>
                        <p class="text-lg md:text-xl mb-6 opacity-90">Snack Organik Premium</p>
                        <button class="bg-yellow-400 text-gray-900 px-6 py-3 rounded-lg font-semibold hover:bg-yellow-300 transition-colors">
                            LIHAT KOLEKSI
                        </button>
                    </div>
                </div>
            </div>

            <!-- Banner 3: Flash Sale -->
            <div class="banner-slide bg-gradient-to-r from-orange-500 to-orange-600">
                <div class="relative z-10 flex items-center h-full px-8">
                    <div>
                        <h2 class="text-3xl md:text-5xl font-bold mb-4">FLASH SALE</h2>
                        <p class="text-lg md:text-xl mb-6 opacity-90">Hanya 12 Jam! Diskon hingga 70%</p>
                        <button class="bg-yellow-400 text-gray-900 px-6 py-3 rounded-lg font-semibold hover:bg-yellow-300 transition-colors">
                            BELI SEKARANG
                        </button>
                    </div>
                </div>
            </div>

            <!-- Banner 4: Gratis Ongkir -->
            <div class="banner-slide bg-gradient-to-r from-purple-500 to-purple-600">
                <div class="relative z-10 flex items-center h-full px-8">
                    <div>
                        <h2 class="text-3xl md:text-5xl font-bold mb-4">GRATIS ONGKIR</h2>
                        <p class="text-lg md:text-xl mb-6 opacity-90">Minimal Belanja Rp 50.000</p>
                        <button class="bg-yellow-400 text-gray-900 px-6 py-3 rounded-lg font-semibold hover:bg-yellow-300 transition-colors">
                            MULAI BELANJA
                        </button>
                    </div>
                </div>
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
            <span class="banner-dot w-3 h-3 bg-white bg-opacity-50 rounded-full cursor-pointer transition-all hover:bg-opacity-100" onclick="currentBannerSlide(3)"></span>
            <span class="banner-dot w-3 h-3 bg-white bg-opacity-50 rounded-full cursor-pointer transition-all hover:bg-opacity-100" onclick="currentBannerSlide(4)"></span>
        </div>
    </section>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Section Produk Terlaris -->
        <section class="mb-12">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-800">PRODUK TERLARIS</h2>
                <a href="#" class="text-emerald-600 hover:text-emerald-700 font-medium">Lihat Semua →</a>
            </div>

            <!-- Check if there are products -->
            @if(false) <!-- Change this condition based on your product data -->
                <!-- Product Grid -->
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 md:gap-6">
                    <!-- Sample Products using the component -->
                    @include('components.product-card', [
                        'title' => 'Cimol Bojot Premium',
                        'price' => 'Rp 20.000',
                        'originalPrice' => 'Rp 25.000',
                        'rating' => 4.3,
                        'sold' => 294,
                        'discount' => 20
                    ])
                    
                    @include('components.product-card', [
                        'title' => 'Keripik Buah Organik',
                        'price' => 'Rp 12.500',
                        'rating' => 4.8,
                        'sold' => 189
                    ])
                    
                    @include('components.product-card', [
                        'title' => 'Pempek Ikan Asli Palembang',
                        'price' => 'Rp 30.000',
                        'rating' => 4.9,
                        'sold' => 720
                    ])
                    
                    @include('components.product-card', [
                        'title' => 'Rendang Sapi Padang',
                        'price' => 'Rp 40.000',
                        'originalPrice' => 'Rp 50.000',
                        'rating' => 4.8,
                        'sold' => 186,
                        'discount' => 20
                    ])
                    
                    @include('components.product-card', [
                        'title' => 'Lumpia Rebung Semarang',
                        'price' => 'Rp 45.000',
                        'rating' => 5.0,
                        'sold' => 108
                    ])
                </div>
            @else
                <!-- Empty State -->
                <div class="bg-white rounded-lg shadow-md p-12 text-center">
                    <div class="w-24 h-24 mx-auto mb-6 bg-gray-100 rounded-full flex items-center justify-center">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-3">Belum ada produk tersedia</h3>
                    <p class="text-gray-600 mb-6 max-w-md mx-auto">
                        Toko masih dalam tahap pengembangan. Silakan login sebagai admin untuk menambahkan produk.
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
                            <span class="text-blue-700">Selamat datang, {{ Auth::user()->name }}! Produk akan segera tersedia.</span>
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
        const totalBanners = 4; // Total number of banner slides
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
            const translateX = currentBannerIndex * -25; // 25% per slide
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
                    if (confirm('Anda perlu login untuk menambahkan produk ke keranjang. Login sekarang?')) {
                        window.location.href = '/login';
                    }
                    return null;
                }
                
                // Check for other HTTP errors
                if (!response.ok) {
                    if (response.status === 419) {
                        alert('Session expired. Please refresh the page and try again.');
                        return null;
                    }
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                
                return response.json();
            })
            .then(data => {
                if (data === null) return; // Handle redirect case
                
                if (data && data.success) {
                    alert('Produk berhasil ditambahkan ke keranjang!');
                } else if (data && data.message) {
                    alert('Error: ' + data.message);
                } else {
                    alert('Unexpected response format');
                }
            })
            .catch(error => {
                console.error('Cart error details:', error);
                alert('Terjadi kesalahan saat menambahkan produk ke keranjang. Silakan coba lagi.');
            });
        }
    </script>
</body>
</html>
