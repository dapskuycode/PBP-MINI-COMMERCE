<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Mini Commerce</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .navbar {
            background-color: #007bff !important;
        }
        .product-card {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            transition: transform 0.2s;
        }
        .product-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .product-image {
            height: 200px;
            background-color: #e9ecef;
            border-radius: 8px 8px 0 0;
        }
        .price {
            color: #007bff;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">Sanny Shop</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Produk</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Kategori</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Pesanan</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Profil</a></li>
                            <li><a class="dropdown-item" href="#">Pengaturan</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ route('logout') }}">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mt-4">
        <!-- Welcome Section -->
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-body">
                        <h4>Selamat Datang di Dashboard!</h4>
                        <p class="text-muted">Kelola produk dan pesanan Anda dengan mudah.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Total Produk</h5>
                        <h2 class="text-primary">{{ $totalProducts }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Total Kategori</h5>
                        <h2 class="text-success">{{ $totalCategories }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Stok Tersedia</h5>
                        <h2 class="text-info">{{ $products->sum('stock') }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Nilai Stok</h5>
                        <h2 class="text-warning">Rp {{ number_format($products->sum(function($product) { return $product->price * $product->stock; }), 0, ',', '.') }}</h2>
                    </div>
                </div>
            </div>
        </div>

        <!-- Products Section -->
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5>Produk Terbaru</h5>
                    <a href="#" class="btn btn-primary btn-sm">Tambah Produk</a>
                </div>
            </div>
        </div>

        <!-- Product Grid -->
        <div class="row">
            @forelse($products as $product)
            <div class="col-md-3 mb-4">
                <div class="card product-card">
                    <div class="product-image d-flex align-items-center justify-content-center">
                        <span class="text-muted">Foto Produk</span>
                    </div>
                    <div class="card-body">
                        <h6 class="card-title">{{ $product->name }}</h6>
                        <p class="card-text text-muted">{{ Str::limit($product->description, 60) }}</p>
                        <p class="price">{{ $product->formatted_price }}</p>
                        <small class="text-muted">Kategori: {{ $product->category->name }}</small><br>
                        <small class="text-muted">Stok: {{ $product->stock }}</small>
                        <div class="d-flex gap-2 mt-2">
                            <button class="btn btn-outline-primary btn-sm">Edit</button>
                            <button class="btn btn-outline-danger btn-sm">Hapus</button>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="alert alert-info text-center">
                    <h5>Belum ada produk</h5>
                    <p>Silakan tambahkan produk pertama Anda.</p>
                    <a href="#" class="btn btn-primary">Tambah Produk</a>
                </div>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($totalProducts > 8)
        <div class="row">
            <div class="col-12">
                <nav>
                    <ul class="pagination justify-content-center">
                        <li class="page-item disabled">
                            <a class="page-link" href="#">Sebelumnya</a>
                        </li>
                        <li class="page-item active">
                            <a class="page-link" href="#">1</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#">2</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#">3</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#">Selanjutnya</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
