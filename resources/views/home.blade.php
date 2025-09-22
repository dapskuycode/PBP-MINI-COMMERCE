<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TokoKami - Mini Commerce</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
        }

        /* Header hijau di atas */
        .top-header {
            background: linear-gradient(90deg, #7dd3fc 0%, #82D2BC 5%, #82D2BC 95%, #7dd3fc 100%);
            height: 60px;
            border-bottom: 3px solid #10b981;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1030;
        }

        /* Navbar */
        .main-navbar {
            background-color: #f8fafc;
            padding: 1rem 0;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            position: fixed;
            top: 60px;
            left: 0;
            right: 0;
            z-index: 1020;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
            background-color: rgba(248, 250, 252, 0.95);
        }

        /* Body padding untuk mengkompensasi navbar yang fixed */
        body {
            padding-top: 160px; /* 80px top-header + 80px navbar */
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            font-weight: bold;
            font-size: 1.5rem;
            color: #1f2937 !important;
            text-decoration: none;
        }

        .brand-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            margin-right: 10px;
        }

        .brand-text {
            color: #1f2937;
        }

        .brand-subtitle {
            font-size: 0.75rem;
            color: #6b7280;
            font-weight: normal;
        }

        .nav-menu .nav-link {
            color: #374151 !important;
            font-weight: 500;
            font-size: 1.1rem;
            margin: 0 15px;
            padding: 0.5rem 0 !important;
            transition: color 0.3s;
        }

        .nav-menu .nav-link:hover {
            color: #10b981 !important;
        }

        .search-container {
            position: relative;
            max-width: none;
            flex: 1;
            margin: 0 15px;
            min-width: 300px;
        }

        .search-input {
            border: 2px solid #e5e7eb;
            border-radius: 25px;
            padding: 12px 60px 12px 25px;
            width: 100%;
            font-size: 1rem;
            font-weight: 400;
            transition: all 0.3s ease;
        }

        .search-input:focus {
            border-color: #10b981;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
        }

        .search-btn {
            position: absolute;
            right: 8px;
            top: 50%;
            transform: translateY(-50%);
            background-color: #10b981;
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.1rem;
            transition: all 0.3s ease;
        }

        .search-btn:hover {
            background-color: #059669;
            transform: translateY(-50%) scale(1.05);
        }

        .user-actions {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .action-icon {
            width: 40px;
            height: 40px;
            background-color: #f3f4f6;
            border: none;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #374151;
            font-size: 1.2rem;
            transition: all 0.3s;
            position: relative;
        }

        .action-icon:hover {
            background-color: #10b981;
            color: white;
        }

        /* Banner Produk Terbaru - Full Width Slider */
        .product-banner {
            margin: 20px;
            border-radius: 15px;
            position: relative;
            overflow: hidden;
            height: 300px;
        }

        .banner-slider {
            display: flex;
            transition: transform 0.6s ease-in-out;
            width: 800%; /* 8 slides × 100% */
            height: 100%;
        }

        .banner-slide {
            width: 12.5%; /* 100% / 8 slides */
            height: 100%;
            color: white;
            padding: 60px 0;
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

        .banner-content h2 {
            font-size: 3rem;
            font-weight: bold;
            margin-bottom: 1rem;
            position: relative;
            z-index: 2;
        }

        .banner-subtitle {
            font-size: 1.5rem;
            margin-bottom: 2rem;
            opacity: 0.9;
            position: relative;
            z-index: 2;
        }

        .shop-now-btn {
            background-color: #fbbf24;
            color: #1f2937;
            border: none;
            padding: 15px 40px;
            border-radius: 25px;
            font-size: 1.1rem;
            font-weight: bold;
            transition: all 0.3s;
            position: relative;
            z-index: 2;
        }

        .shop-now-btn:hover {
            background-color: #f59e0b;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(251, 191, 36, 0.3);
        }

        /* Navigation buttons for full banner */
        .banner-nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background-color: rgba(255, 255, 255, 0.9);
            border: none;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.6rem;
            color: #374151;
            cursor: pointer;
            transition: all 0.3s ease;
            z-index: 20;
        }

        .banner-nav:hover {
            background-color: white;
            transform: translateY(-50%) scale(1.1);
            box-shadow: 0 8px 25px rgba(0,0,0,0.3);
        }

        .banner-prev {
            left: 30px;
        }

        .banner-next {
            right: 30px;
        }

        /* Dots indicator for full banner */
        .banner-dots {
            position: absolute;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 12px;
            z-index: 20;
        }

        .banner-dot {
            width: 14px;
            height: 14px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.5);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .banner-dot.active {
            background-color: white;
            transform: scale(1.3);
        }

        /* Section Produk Terlaris */
        .bestseller-section {
            margin: 50px 20px;
            padding: 40px 0;
        }

        .section-title {
            font-size: 2rem;
            font-weight: bold;
            color: #374151;
            margin-bottom: 30px;
        }

        .empty-products {
            text-align: center;
            padding: 60px 20px;
            background-color: #f9fafb;
            border-radius: 15px;
            border: 2px dashed #d1d5db;
        }

        .empty-icon {
            font-size: 4rem;
            color: #9ca3af;
            margin-bottom: 20px;
        }

        /* Dropdown user */
        .dropdown-menu {
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            border: none;
        }

        /* Responsive */
        @media (max-width: 991.98px) {
            .banner-content h2 {
                font-size: 2rem;
            }

            .banner-subtitle {
                font-size: 1.2rem;
            }

            .product-showcase {
                display: none;
            }

            .search-container {
                margin: 10px 0;
                width: 100%;
                min-width: auto;
                flex: 1;
            }

            .nav-menu {
                display: none;
            }

            .user-actions {
                margin-top: 10px;
                justify-content: center;
                gap: 15px;
            }
        }

        @media (max-width: 767.98px) {
            body {
                padding-top: 140px; /* 60px top-header + 80px navbar */
            }

            .top-header {
                height: 60px;
            }

            .main-navbar {
                top: 60px;
            }

            .brand-icon {
                width: 40px;
                height: 40px;
            }

            .navbar-brand {
                font-size: 1.2rem;
            }

            .banner-content h2 {
                font-size: 1.8rem;
            }

            .nav-menu {
                text-align: center;
                margin-top: 15px;
            }

            .product-banner {
                margin: 10px;
                padding: 40px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="top-header"></div>

    <nav class="main-navbar">
        <div class="container-fluid">
            <div class="row w-100 align-items-center">
                                <!-- Logo dan Brand -->
                <div class="col-lg-2 col-md-3 col-6">
                    <a href="{{ route('home') }}" class="navbar-brand">
                        <div class="brand-icon">
                            <img src="{{ asset('images/logo.png') }}" alt="TokoKami">
                        </div>
                        <div>
                            <div class="brand-text">TokoKami</div>
                            <div class="brand-subtitle">UMKM Mini-Commerce</div>
                        </div>
                    </a>
                </div>

                <div class="col-lg-4 col-md-8 col-6">
                    <div class="nav-menu d-flex justify-content">
                        <a href="#" class="nav-link">Produk</a>
                        <a href="#" class="nav-link">Tentang Kami</a>
                    </div>
                </div>

                <!-- Search dan User Actions -->
                <div class="col-lg-5 col-12">
                    <div class="d-flex align-items-center">
                        <!-- Search Bar -->
                        <div class="search-container">
                            <input type="text" class="form-control search-input" placeholder="Cari produk...">
                            <button class="search-btn">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>

                        <!-- User Actions -->
                        <div class="user-actions">
                            <button class="action-icon">
                                <i class="bi bi-cart3"></i>
                            </button>

                            @auth
                                <div class="dropdown">
                                    <button class="action-icon dropdown-toggle" data-bs-toggle="dropdown">
                                        <i class="bi bi-person"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><h6 class="dropdown-header">{{ Auth::user()->name }}</h6></li>
                                        @if(Auth::user()->is_admin)
                                            <li><a class="dropdown-item" href="{{ route('dashboard') }}">
                                                <i class="bi bi-speedometer2 me-2"></i>Dashboard
                                            </a></li>
                                        @endif
                                        <li><a class="dropdown-item" href="#">
                                            <i class="bi bi-person me-2"></i>Profile
                                        </a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item" href="{{ route('logout') }}">
                                            <i class="bi bi-box-arrow-right me-2"></i>Logout
                                        </a></li>
                                    </ul>
                                </div>
                            @else
                                <a href="{{ route('login') }}" class="action-icon">
                                    <i class="bi bi-person"></i>
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Banner Produk Terbaru - Full Width Slider -->
    <section class="product-banner">
        <div class="banner-slider" id="bannerSlider">
            <!-- Banner 1: Diskon Besar -->
            <div class="banner-slide" style="background: linear-gradient(135deg, rgba(239, 68, 68, 0.8), rgba(220, 38, 38, 0.8)), viewBox='0 0 1200 300'><rect width='1200' height='300' fill='%23dc2626'/></svg>')">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="banner-content">
                                <h2>DISKON BESAR 50%</h2>
                                <p class="banner-subtitle">Semua Produk Makanan & Minuman</p>
                                <button class="shop-now-btn">BELANJA SEKARANG</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Banner 2: Produk Baru -->
            <div class="banner-slide" style="background: linear-gradient(135deg, rgba(16, 185, 129, 0.8), rgba(5, 150, 105, 0.8)), url('data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1200 300'><rect width="1200" height="300" fill="%23059669"/></svg>'">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="banner-content">
                                <h2>PRODUK TERBARU</h2>
                                <p class="banner-subtitle">Snack Organik Premium</p>
                                <button class="shop-now-btn">LIHAT KOLEKSI</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Banner 3: Flash Sale -->
            <div class="banner-slide" style="background: linear-gradient(135deg, rgba(245, 158, 11, 0.8), rgba(217, 119, 6, 0.8)), url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 300"><rect width="1200" height="300" fill="%23d97706"/></svg>');">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="banner-content">
                                <h2>FLASH SALE</h2>
                                <p class="banner-subtitle">Hanya 12 Jam! Diskon hingga 70%</p>
                                <button class="shop-now-btn">BELI SEKARANG</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Banner 4: Gratis Ongkir -->
            <div class="banner-slide" style="background: linear-gradient(135deg, rgba(139, 92, 246, 0.8), rgba(124, 58, 237, 0.8)), url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 300"><rect width="1200" height="300" fill="%237c3aed"/></svg>');">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="banner-content">
                                <h2>GRATIS ONGKIR</h2>
                                <p class="banner-subtitle">Minimal Belanja Rp 50.000</p>
                                <button class="shop-now-btn">MULAI BELANJA</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Banner 5: Member Baru -->
            <div class="banner-slide" style="background: linear-gradient(135deg, rgba(6, 182, 212, 0.8), rgba(14, 165, 233, 0.8)), url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 300"><rect width="1200" height="300" fill="%230ea5e9"/></svg>');">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="banner-content">
                                <h2>MEMBER BARU</h2>
                                <p class="banner-subtitle">Diskon 30% + Cashback</p>
                                <button class="shop-now-btn">DAFTAR GRATIS</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Banner 6: Bundle Hemat -->
            <div class="banner-slide" style="background: linear-gradient(135deg, rgba(236, 72, 153, 0.8), rgba(219, 39, 119, 0.8)), url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 300"><rect width="1200" height="300" fill="%23db2777"/></svg>');">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="banner-content">
                                <h2>PAKET HEMAT</h2>
                                <p class="banner-subtitle">Beli 3 Gratis 1</p>
                                <button class="shop-now-btn">PILIH PAKET</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Banner 7: Weekend Sale -->
            <div class="banner-slide" style="background: linear-gradient(135deg, rgba(34, 197, 94, 0.8), rgba(22, 163, 74, 0.8)), url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 300"><rect width="1200" height="300" fill="%2316a34a"/></svg>');">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="banner-content">
                                <h2>WEEKEND SALE</h2>
                                <p class="banner-subtitle">Diskon hingga 70%</p>
                                <button class="shop-now-btn">JELAJAHI</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Banner 8: Loyalty Program -->
            <div class="banner-slide" style="background: linear-gradient(135deg, rgba(168, 85, 247, 0.8), rgba(147, 51, 234, 0.8)), url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 300"><rect width="1200" height="300" fill="%239333ea"/></svg>');">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="banner-content">
                                <h2>LOYAL MEMBER</h2>
                                <p class="banner-subtitle">Kumpulkan Poin Reward</p>
                                <button class="shop-now-btn">GABUNG SEKARANG</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Navigation buttons -->
        <button class="banner-nav banner-prev" onclick="moveBannerSlider(-1)">
            <i class="bi bi-chevron-left"></i>
        </button>
        <button class="banner-nav banner-next" onclick="moveBannerSlider(1)">
            <i class="bi bi-chevron-right"></i>
        </button>

        <!-- Dots indicator -->
        <div class="banner-dots">
            <span class="banner-dot active" onclick="currentBannerSlide(1)"></span>
            <span class="banner-dot" onclick="currentBannerSlide(2)"></span>
            <span class="banner-dot" onclick="currentBannerSlide(3)"></span>
            <span class="banner-dot" onclick="currentBannerSlide(4)"></span>
            <span class="banner-dot" onclick="currentBannerSlide(5)"></span>
            <span class="banner-dot" onclick="currentBannerSlide(6)"></span>
            <span class="banner-dot" onclick="currentBannerSlide(7)"></span>
            <span class="banner-dot" onclick="currentBannerSlide(8)"></span>
        </div>
    </section>

    <!-- Section Produk Terlaris -->
    <section class="bestseller-section">
        <div class="container">
            <h3 class="section-title">PRODUK TERLARIS</h3>

            <!-- Empty State -->
            <div class="empty-products">
                <div class="empty-icon">
                    <i class="bi bi-box-seam"></i>
                </div>
                <h5 class="text-muted mb-3">Belum ada produk tersedia</h5>
                <p class="text-muted mb-4">Toko masih dalam tahap pengembangan. Silakan login sebagai admin untuk menambahkan produk.</p>

                @guest
                    <div class="d-flex flex-column flex-sm-row gap-2 justify-content-center">
                        <a href="{{ route('login') }}" class="btn btn-success btn-lg px-4">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Login Sekarang
                        </a>
                        <a href="{{ route('register') }}" class="btn btn-outline-success btn-lg px-4">
                            <i class="bi bi-person-plus me-2"></i>Daftar Akun
                        </a>
                    </div>
                @else
                    <div class="alert alert-info d-inline-block">
                        <i class="bi bi-info-circle me-2"></i>
                        Selamat datang, {{ Auth::user()->name }}! Produk akan segera tersedia.
                    </div>
                @endguest
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-light mt-5 py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h6 class="text-muted">TokoKami</h6>
                    <p class="text-muted small">UMKM Mini-Commerce untuk pembelajaran Platform Based Programming.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="text-muted small mb-0">&copy; 2025 TokoKami. Dibuat untuk tugas kelas PBP.</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        let currentBannerIndex = 0;
        const totalBanners = 8; // Total number of banner slides
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
            const translateX = currentBannerIndex * -12.5; // 12.5% per slide
            bannerSlider.style.transform = `translateX(${translateX}%)`;

            // Update dots
            bannerDots.forEach((dot, index) => {
                dot.classList.toggle('active', index === currentBannerIndex);
            });
        }

        // Auto-slide functionality for banner
        function startAutoBanner() {
            autoBannerInterval = setInterval(() => {
                moveBannerSlider(1);
            }, 10000); // 10 seconds
        }

        // Stop auto-slide when user interacts
        function stopAutoBanner() {
            clearInterval(autoBannerInterval);
        }

        // Restart auto-slide after user interaction
        function restartAutoBanner() {
            stopAutoBanner();
            setTimeout(startAutoBanner, 15000); // Restart after 15 seconds
        }

        // Event listeners for manual navigation
        document.querySelector('.banner-prev').addEventListener('click', () => {
            restartAutoBanner();
        });

        document.querySelector('.banner-next').addEventListener('click', () => {
            restartAutoBanner();
        });

        bannerDots.forEach(dot => {
            dot.addEventListener('click', () => {
                restartAutoBanner();
            });
        });

        // Start auto-slide when page loads
        document.addEventListener('DOMContentLoaded', () => {
            startAutoBanner();
        });

        // Pause auto-slide when user hovers over the banner
        document.querySelector('.product-banner').addEventListener('mouseenter', stopAutoBanner);
        document.querySelector('.product-banner').addEventListener('mouseleave', startAutoBanner);
    </script>
</body>
</html>
