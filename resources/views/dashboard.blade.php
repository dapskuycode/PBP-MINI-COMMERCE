<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Mini Commerce - Marketplace Indonesia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --success-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }

        body {
            background-color: #f8f9fc;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Navbar Styles */
        .navbar {
            background: var(--primary-gradient) !important;
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 32px rgba(102, 126, 234, 0.2);
            border: none;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: white !important;
        }

        .navbar-brand:hover {
            transform: scale(1.05);
            transition: all 0.3s ease;
        }

        .nav-link {
            color: white !important;
            font-weight: 500;
            margin: 0 10px;
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            color: #f8f9fa !important;
            transform: translateY(-2px);
        }

        .btn-auth {
            background: rgba(255, 255, 255, 0.2);
            border: 2px solid rgba(255, 255, 255, 0.3);
            color: white;
            border-radius: 25px;
            padding: 8px 20px;
            font-weight: 600;
            margin: 0 5px;
            transition: all 0.3s ease;
        }

        .btn-auth:hover {
            background: white;
            color: #667eea;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(255, 255, 255, 0.3);
        }

        .btn-profile {
            background: var(--secondary-gradient);
            border: none;
            border-radius: 25px;
            padding: 8px 20px;
            color: white;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-profile:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(240, 147, 251, 0.4);
            color: white;
        }

        .btn-cart {
            background: var(--accent-color);
            border: 2px solid var(--accent-color);
            color: white;
            border-radius: 25px;
            padding: 8px 16px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            position: relative;
        }

        .btn-cart:hover {
            background: #e67e22;
            border-color: #e67e22;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(241, 135, 77, 0.4);
            text-decoration: none;
        }

        .badge-count {
            background: #dc3545;
            color: white;
            border-radius: 50%;
            padding: 2px 6px;
            font-size: 0.75rem;
            position: absolute;
            top: -5px;
            right: -5px;
            min-width: 20px;
            text-align: center;
        }

        /* Hero Section */
        .hero-section {
            background: var(--primary-gradient);
            color: white;
            padding: 100px 0;
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/><circle cx="50" cy="10" r="1" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.3;
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 1.5rem;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }

        .hero-subtitle {
            font-size: 1.3rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }

        .search-box {
            background: white;
            border-radius: 50px;
            padding: 5px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            max-width: 600px;
            margin: 0 auto;
        }

        .search-input {
            border: none;
            padding: 15px 25px;
            border-radius: 50px;
            font-size: 1.1rem;
        }

        .search-input:focus {
            outline: none;
            box-shadow: none;
        }

        .search-btn {
            background: var(--secondary-gradient);
            border: none;
            border-radius: 50px;
            padding: 15px 30px;
            color: white;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .search-btn:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(245, 87, 108, 0.4);
        }

        /* Categories Section */
        .categories-section {
            padding: 80px 0;
            background: white;
        }

        .category-card {
            background: white;
            border-radius: 20px;
            padding: 30px;
            text-align: center;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            border: none;
            height: 100%;
        }

        .category-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.15);
        }

        .category-icon {
            width: 80px;
            height: 80px;
            background: var(--primary-gradient);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 2rem;
            color: white;
        }

        .category-title {
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 10px;
        }

        .category-count {
            color: #718096;
            font-size: 0.9rem;
        }

        /* Products Section */
        .products-section {
            padding: 80px 0;
            background: #f8f9fc;
        }

        .product-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            border: none;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.15);
        }

        .product-image {
            height: 200px;
            background: linear-gradient(45deg, #f0f2f5, #e2e8f0);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #a0aec0;
            font-size: 3rem;
            overflow: hidden;
            position: relative;
        }

        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .no-image-placeholder {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(45deg, #f0f2f5, #e2e8f0);
            color: #a0aec0;
            font-size: 3rem;
        }

        .product-info {
            padding: 1.5rem;
            flex: 1;
        }

        .product-title {
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 0.5rem;
            height: 3rem;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        .product-price {
            font-size: 1.1rem;
            color: #667eea !important;
        }

        .add-to-cart-btn {
            transition: all 0.3s ease;
        }

        .add-to-cart-btn:hover:not(:disabled) {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(34, 197, 94, 0.3);
        }

        .add-to-cart-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .buy-now-btn {
            background: #3b82f6;
            border: 2px solid #3b82f6;
            color: white;
            transition: all 0.3s ease;
        }

        .buy-now-btn:hover:not(:disabled) {
            background: #2563eb;
            border-color: #2563eb;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }

        .buy-now-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }
            object-fit: cover;
        }

        .product-info {
            padding: 20px;
        }

        .product-title {
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 8px;
            font-size: 1.1rem;
        }

        .product-price {
            color: #e53e3e;
            font-weight: 700;
            font-size: 1.2rem;
            margin-bottom: 10px;
        }

        .product-category {
            margin-bottom: 8px;
        }

        .product-stock, .product-date {
            color: #718096;
            font-size: 0.85rem;
            margin-bottom: 5px;
        }

        /* Features Section */
        .features-section {
            padding: 80px 0;
            background: white;
        }

        .feature-card {
            text-align: center;
            padding: 40px 20px;
        }

        .feature-icon {
            width: 100px;
            height: 100px;
            background: var(--success-gradient);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 2.5rem;
            color: white;
        }

        .feature-title {
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 15px;
            font-size: 1.3rem;
        }

        .feature-description {
            color: #718096;
            line-height: 1.6;
        }

        /* Footer */
        .footer {
            background: #2d3748;
            color: white;
            padding: 50px 0 30px;
        }

        .footer h5 {
            color: white;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .footer-link {
            color: #a0aec0;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .footer-link:hover {
            color: white;
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 800;
            color: #2d3748;
            text-align: center;
            margin-bottom: 3rem;
        }

        .section-subtitle {
            color: #718096;
            text-align: center;
            margin-bottom: 4rem;
            font-size: 1.1rem;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="fas fa-shopping-bag me-2"></i>Mini Commerce
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/') }}">
                            <i class="fas fa-home me-1"></i>Beranda
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#categories">
                            <i class="fas fa-th-large me-1"></i>Kategori
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#products">
                            <i class="fas fa-box me-1"></i>Produk
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">
                            <i class="fas fa-info-circle me-1"></i>Tentang
                        </a>
                    </li>
                </ul>

                <div class="navbar-nav">
                    @auth
                        <!-- Cart Button (only for buyers) -->
                        @if(Auth::user()->role === 'buyer')
                            <a href="{{ route('cart.index') }}" class="btn btn-cart me-2">
                                <i class="fas fa-shopping-cart me-1"></i>
                                Keranjang
                                <span id="cart-count" class="badge badge-count">0</span>
                            </a>
                        @endif

                        <!-- User logged in -->
                        <div class="dropdown">
                            <button class="btn btn-profile dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user me-2"></i>{{ Auth::user()->name }}
                            </button>
                            <ul class="dropdown-menu">
                                @if(Auth::user()->role === 'admin')
                                    <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                        <i class="fas fa-shield-alt me-2"></i>Admin Panel
                                    </a></li>
                                    <li><hr class="dropdown-divider"></li>
                                @endif
                                <li><a class="dropdown-item" href="{{ route('profile') }}">
                                    <i class="fas fa-user-circle me-2"></i>Profile
                                </a></li>
                                @if(Auth::user()->role === 'buyer')
                                    <li><a class="dropdown-item" href="#">
                                        <i class="fas fa-shopping-cart me-2"></i>Keranjang
                                    </a></li>
                                    <li><a class="dropdown-item" href="#">
                                        <i class="fas fa-history me-2"></i>Riwayat
                                    </a></li>
                                @endif
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger" style="border: none; background: none;">
                                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @else
                        <!-- User not logged in -->
                        <a href="{{ route('login') }}" class="btn btn-auth">
                            <i class="fas fa-sign-in-alt me-1"></i>Masuk
                        </a>
                        <a href="{{ route('register') }}" class="btn btn-auth">
                            <i class="fas fa-user-plus me-1"></i>Daftar
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Success/Error Messages -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show position-fixed" style="top: 80px; right: 20px; z-index: 1050; max-width: 400px;" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show position-fixed" style="top: 80px; right: 20px; z-index: 1050; max-width: 400px;" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('info'))
        <div class="alert alert-info alert-dismissible fade show position-fixed" style="top: 80px; right: 20px; z-index: 1050; max-width: 400px;" role="alert">
            <i class="fas fa-info-circle me-2"></i>{{ session('info') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="hero-content text-center">
                <h1 class="hero-title">Selamat Datang di Mini Commerce</h1>
                <p class="hero-subtitle">Temukan produk terbaik dengan harga terjangkau dari seluruh Indonesia</p>

                <div class="search-box d-flex">
                    <input type="text" class="form-control search-input" placeholder="Cari produk, kategori, atau toko...">
                    <button class="btn search-btn">
                        <i class="fas fa-search me-2"></i>Cari
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section id="categories" class="categories-section">
        <div class="container">
            <h2 class="section-title">Kategori Populer</h2>
            <p class="section-subtitle">Jelajahi berbagai kategori produk pilihan</p>

            <div class="row g-4">
                @if($categories->count() > 0)
                    @foreach($categories->take(4) as $category)
                    <div class="col-lg-3 col-md-6">
                        <div class="category-card">
                            <div class="category-icon">
                                @switch($category->name)
                                    @case('Elektronik')
                                        <i class="fas fa-mobile-alt"></i>
                                        @break
                                    @case('Fashion Pria')
                                    @case('Fashion Wanita')
                                        <i class="fas fa-tshirt"></i>
                                        @break
                                    @case('Rumah & Taman')
                                        <i class="fas fa-home"></i>
                                        @break
                                    @case('Olahraga & Outdoor')
                                        <i class="fas fa-dumbbell"></i>
                                        @break
                                    @case('Kesehatan & Kecantikan')
                                        <i class="fas fa-heart"></i>
                                        @break
                                    @case('Otomotif')
                                        <i class="fas fa-car"></i>
                                        @break
                                    @case('Buku & Hobi')
                                        <i class="fas fa-book"></i>
                                        @break
                                    @case('Makanan & Minuman')
                                        <i class="fas fa-utensils"></i>
                                        @break
                                    @default
                                        <i class="fas fa-boxes"></i>
                                @endswitch
                            </div>
                            <h5 class="category-title">{{ $category->name }}</h5>
                            <p class="category-count">{{ $category->products_count }} produk</p>
                        </div>
                    </div>
                    @endforeach
                @else
                    <!-- Default categories if no data -->
                    <div class="col-lg-3 col-md-6">
                        <div class="category-card">
                            <div class="category-icon">
                                <i class="fas fa-mobile-alt"></i>
                            </div>
                            <h5 class="category-title">Elektronik</h5>
                            <p class="category-count">0 produk</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="category-card">
                            <div class="category-icon">
                                <i class="fas fa-tshirt"></i>
                            </div>
                            <h5 class="category-title">Fashion</h5>
                            <p class="category-count">0 produk</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="category-card">
                            <div class="category-icon">
                                <i class="fas fa-home"></i>
                            </div>
                            <h5 class="category-title">Rumah Tangga</h5>
                            <p class="category-count">0 produk</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="category-card">
                            <div class="category-icon">
                                <i class="fas fa-dumbbell"></i>
                            </div>
                            <h5 class="category-title">Olahraga</h5>
                            <p class="category-count">0 produk</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- Products Section -->
    <section id="products" class="products-section">
        <div class="container">
            <h2 class="section-title">Produk Terbaru</h2>
            <p class="section-subtitle">Produk-produk terbaru dan terlaris dari berbagai kategori</p>

            <div class="row g-4">
                @if($featuredProducts->count() > 0)
                    @foreach($featuredProducts as $product)
                    <div class="col-lg-3 col-md-6">
                        <div class="product-card h-100">
                            <div class="product-image position-relative">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-fluid">
                                @else
                                    <div class="no-image-placeholder">
                                        <i class="fas fa-image"></i>
                                    </div>
                                @endif
                                @if($product->stock <= 5 && $product->stock > 0)
                                    <span class="badge bg-warning position-absolute top-0 end-0 m-2">Stok Terbatas</span>
                                @elseif($product->stock <= 0)
                                    <span class="badge bg-danger position-absolute top-0 end-0 m-2">Habis</span>
                                @endif
                            </div>
                            <div class="product-info d-flex flex-column">
                                <h6 class="product-title mb-2">{{ $product->name }}</h6>
                                <div class="product-price fw-bold text-primary mb-2">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                                <div class="product-category mb-2">
                                    <span class="badge bg-primary">{{ $product->category->name }}</span>
                                </div>
                                <div class="product-stock mb-2">
                                    <i class="fas fa-box me-1"></i>
                                    <span class="{{ $product->stock <= 5 ? 'text-warning' : 'text-success' }}">
                                        Stok: {{ $product->stock }}
                                    </span>
                                </div>
                                <div class="product-date text-muted small mb-3">
                                    <i class="fas fa-calendar me-1"></i>
                                    {{ $product->created_at->format('d M Y') }}
                                </div>

                                <!-- Action Buttons -->
                                <div class="mt-auto">
                                    <div class="d-grid gap-2">
                                        <a href="{{ route('products.detail', $product) }}" class="btn btn-outline-primary btn-sm">
                                            <i class="fas fa-eye me-1"></i>Lihat Detail
                                        </a>
                                        @auth
                                            @if(auth()->user()->role === 'buyer')
                                                <button type="button"
                                                        class="btn btn-success btn-sm add-to-cart-btn"
                                                        data-product-id="{{ $product->id }}"
                                                        {{ $product->stock <= 0 ? 'disabled' : '' }}>
                                                    <i class="fas fa-cart-plus me-1"></i>
                                                    {{ $product->stock <= 0 ? 'Stok Habis' : 'Tambah ke Keranjang' }}
                                                </button>
                                                @if($product->stock > 0)
                                                    <button type="button"
                                                            class="btn btn-primary btn-sm buy-now-btn"
                                                            data-product-id="{{ $product->id }}">
                                                        <i class="fas fa-bolt me-1"></i>Beli Sekarang
                                                    </button>
                                                @endif
                                            @elseif(auth()->user()->role === 'admin')
                                                <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-warning btn-sm">
                                                    <i class="fas fa-edit me-1"></i>Edit Produk
                                                </a>
                                            @endif
                                        @else
                                            <a href="{{ route('login') }}" class="btn btn-success btn-sm">
                                                <i class="fas fa-cart-plus me-1"></i>Login untuk Membeli
                                            </a>
                                        @endauth
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    <!-- No products message -->
                    <div class="col-12">
                        <div class="text-center py-5">
                            <i class="fas fa-box-open fa-4x text-muted mb-3"></i>
                            <h5 class="text-muted">Belum ada produk</h5>
                            <p class="text-muted">Produk akan muncul di sini setelah admin menambahkannya.</p>
                            @auth
                                @if(auth()->user()->role === 'admin')
                                    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                                        <i class="fas fa-plus me-2"></i>Tambah Produk Pertama
                                    </a>
                                @endif
                            @endauth
                        </div>
                    </div>
                @endif
            </div>

            @if($featuredProducts->count() > 0)
                <div class="text-center mt-5">
                    <a href="{{ route('products.catalog') }}" class="btn btn-primary btn-lg" style="background: var(--primary-gradient); border: none; border-radius: 25px; padding: 12px 40px;">
                        <i class="fas fa-eye me-2"></i>Lihat Semua Produk ({{ $totalProducts }})
                    </a>
                </div>
            @endif
        </div>
    </section>

    <!-- Features Section -->
    <section id="about" class="features-section">
        <div class="container">
            <h2 class="section-title">Mengapa Memilih Mini Commerce?</h2>
            <p class="section-subtitle">Nikmati pengalaman berbelanja online yang aman dan menyenangkan</p>

            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h5 class="feature-title">Aman & Terpercaya</h5>
                        <p class="feature-description">Transaksi aman dengan sistem keamanan berlapis dan jaminan uang kembali</p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-shipping-fast"></i>
                        </div>
                        <h5 class="feature-title">Pengiriman Cepat</h5>
                        <p class="feature-description">Pengiriman ke seluruh Indonesia dengan berbagai pilihan ekspedisi terpercaya</p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-headset"></i>
                        </div>
                        <h5 class="feature-title">Customer Service 24/7</h5>
                        <p class="feature-description">Tim support siap membantu Anda kapan saja melalui berbagai channel komunikasi</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <h5><i class="fas fa-shopping-bag me-2"></i>Mini Commerce</h5>
                    <p class="text-muted">Platform marketplace terpercaya di Indonesia dengan berbagai pilihan produk berkualitas.</p>
                    <div class="d-flex gap-3 mt-3">
                        <a href="#" class="footer-link"><i class="fab fa-facebook fa-lg"></i></a>
                        <a href="#" class="footer-link"><i class="fab fa-twitter fa-lg"></i></a>
                        <a href="#" class="footer-link"><i class="fab fa-instagram fa-lg"></i></a>
                        <a href="#" class="footer-link"><i class="fab fa-youtube fa-lg"></i></a>
                    </div>
                </div>
                <div class="col-lg-2">
                    <h5>Perusahaan</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="footer-link">Tentang Kami</a></li>
                        <li><a href="#" class="footer-link">Karir</a></li>
                        <li><a href="#" class="footer-link">Blog</a></li>
                        <li><a href="#" class="footer-link">Press</a></li>
                    </ul>
                </div>
                <div class="col-lg-2">
                    <h5>Bantuan</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="footer-link">Pusat Bantuan</a></li>
                        <li><a href="#" class="footer-link">Cara Berbelanja</a></li>
                        <li><a href="#" class="footer-link">Cara Berjualan</a></li>
                        <li><a href="#" class="footer-link">Hubungi Kami</a></li>
                    </ul>
                </div>
                <div class="col-lg-2">
                    <h5>Kebijakan</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="footer-link">Syarat & Ketentuan</a></li>
                        <li><a href="#" class="footer-link">Kebijakan Privasi</a></li>
                        <li><a href="#" class="footer-link">Kebijakan Pengembalian</a></li>
                        <li><a href="#" class="footer-link">Panduan Keamanan</a></li>
                    </ul>
                </div>
                <div class="col-lg-2">
                    <h5>Ikuti Kami</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="footer-link">Newsletter</a></li>
                        <li><a href="#" class="footer-link">Promo Terbaru</a></li>
                        <li><a href="#" class="footer-link">Event</a></li>
                        <li><a href="#" class="footer-link">Komunitas</a></li>
                    </ul>
                </div>
            </div>
            <hr class="my-4" style="border-color: #4a5568;">
            <div class="text-center">
                <p class="text-muted mb-0">&copy; 2025 Mini Commerce. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Load cart count on page load
        document.addEventListener('DOMContentLoaded', function() {
            loadCartCount();
        });

        function loadCartCount() {
            @auth
                @if(Auth::user()->role === 'buyer')
                    fetch('/cart/count')
                        .then(response => response.json())
                        .then(data => {
                            const cartCountElement = document.querySelector('#cart-count');
                            if (cartCountElement) {
                                cartCountElement.textContent = data.count || 0;
                            }
                        })
                        .catch(error => console.error('Error loading cart count:', error));
                @endif
            @endauth
        }

        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Navbar background change on scroll
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.style.background = 'var(--primary-gradient)';
                navbar.style.backdropFilter = 'blur(10px)';
            } else {
                navbar.style.background = 'var(--primary-gradient)';
            }
        });

        // Search functionality
        document.querySelector('.search-btn').addEventListener('click', function() {
            const searchInput = document.querySelector('.search-input');
            const searchTerm = searchInput.value.trim();

            if (searchTerm) {
                // Placeholder for search functionality
                alert('Mencari: ' + searchTerm + '\n\nFitur pencarian akan diimplementasikan dengan backend.');
                searchInput.value = '';
            } else {
                alert('Silakan masukkan kata kunci pencarian.');
            }
        });

        // Enter key for search
        document.querySelector('.search-input').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                document.querySelector('.search-btn').click();
            }
        });

        // Product card hover effects
        document.querySelectorAll('.product-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px) scale(1.02)';
            });

            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });

        // Add to cart functionality for dashboard
        document.querySelectorAll('.add-to-cart-btn').forEach(button => {
            button.addEventListener('click', function() {
                const productId = this.dataset.productId;
                const originalText = this.innerHTML;

                // Disable button and show loading
                this.disabled = true;
                this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menambahkan...';

                fetch(`/cart/add/${productId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Show success message
                        this.innerHTML = '<i class="fas fa-check"></i> Ditambahkan!';
                        this.classList.remove('btn-success');
                        this.classList.add('btn-secondary');

                        // Update cart count if element exists
                        loadCartCount();

                        // Show toast notification
                        showToast('Berhasil!', 'Produk berhasil ditambahkan ke keranjang', 'success');

                        // Reset button after 2 seconds
                        setTimeout(() => {
                            this.innerHTML = originalText;
                            this.classList.remove('btn-secondary');
                            this.classList.add('btn-success');
                            this.disabled = false;
                        }, 2000);
                    } else {
                        // Show error message
                        showToast('Gagal!', data.message || 'Gagal menambahkan produk ke keranjang', 'error');
                        this.innerHTML = originalText;
                        this.disabled = false;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showToast('Error!', 'Terjadi kesalahan. Silakan coba lagi.', 'error');
                    this.innerHTML = originalText;
                    this.disabled = false;
                });
            });
        });

        // Buy now functionality for dashboard
        document.querySelectorAll('.buy-now-btn').forEach(button => {
            button.addEventListener('click', function() {
                const productId = this.dataset.productId;

                // Redirect to direct checkout
                window.location.href = `/checkout/buy-now/${productId}`;
            });
        });

        // Toast notification function
        function showToast(title, message, type = 'success') {
            // Create toast container if not exists
            let toastContainer = document.querySelector('.toast-container');
            if (!toastContainer) {
                toastContainer = document.createElement('div');
                toastContainer.className = 'toast-container position-fixed top-0 end-0 p-3';
                toastContainer.style.zIndex = '9999';
                document.body.appendChild(toastContainer);
            }

            // Create toast element
            const toastId = 'toast-' + Date.now();
            const bgColor = type === 'success' ? 'bg-success' : 'bg-danger';

            const toastHtml = `
                <div id="${toastId}" class="toast align-items-center text-white ${bgColor} border-0" role="alert">
                    <div class="d-flex">
                        <div class="toast-body">
                            <strong>${title}</strong><br>${message}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                    </div>
                </div>
            `;

            toastContainer.insertAdjacentHTML('beforeend', toastHtml);

            // Show toast
            const toastElement = document.getElementById(toastId);
            const toast = new bootstrap.Toast(toastElement, { delay: 3000 });
            toast.show();

            // Remove toast element after it's hidden
            toastElement.addEventListener('hidden.bs.toast', function() {
                this.remove();
            });
        }

        // Category card click handler
        document.querySelectorAll('.category-card').forEach(card => {
            card.addEventListener('click', function() {
                const categoryTitle = this.querySelector('.category-title').textContent;
                alert('Mengakses kategori: ' + categoryTitle + '\n\nFitur navigasi kategori akan diimplementasikan dengan backend.');
            });
        });
    </script>
</body>
</html>
