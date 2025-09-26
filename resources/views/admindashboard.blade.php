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
                    <a href="#" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createModal">
                        Tambah Produk
                    </a>    
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
                        <small class="text-muted">Stok: {{ $product->stock }}</small><br>
                        <h6 class="text-muted" style="color: white; padding: 3px 6px; border-radius: 4px; display: inline-block;">Diskon: {{ $product->discount }}%</h6>
                        <div class="d-flex gap-2 mt-2">
                            <button 
                                class="btn btn-warning btn-sm btn-edit"
                                data-id="{{ $product->id }}"
                                data-category_id="{{ $product->category_id }}"
                                data-name="{{ $product->name }}"
                                data-description="{{ $product->description }}"
                                data-price="{{ $product->price }}"
                                data-stock="{{ $product->stock }}"
                                data-discount="{{ $product->discount }}"
                                data-bs-toggle="modal"
                                data-bs-target="#editModal">
                                Edit
                            </button>
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
        @if($totalProducts > 100)
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
    <!-- Modal Edit -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" id="editForm">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Produk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <input type="hidden" name="id" id="edit-id">
                <div class="mb-3">
                    <label for="edit-name" class="form-label">Nama Produk</label>
                    <input type="text" class="form-control" id="edit-name" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="edit-category" class="form-label">Kategori</label>
                    <select class="form-select" id="edit-category" name="category_id" required>
                        <option value="" disabled selected>Pilih Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="edit-price" class="form-label">Harga</label>
                    <input type="number" class="form-control" id="edit-price" name="price" required>
                </div>
                <div class="mb-3">
                    <label for="edit-stock" class="form-label">Stok</label>
                    <input type="number" class="form-control" id="edit-stock" name="stock" required>
                </div>
                <div class="mb-3">
                    <label for="edit-discount" class="form-label">Diskon</label>
                    <input type="number" class="form-control" id="edit-discount" name="discount" required>
                </div>
                <div class="mb-3">
                    <label for="edit-description" class="form-label">Deskripsi</label>
                    <textarea class="form-control" id="edit-description" name="description"></textarea>
                </div>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
            </form>
        </div>
    </div>
    <!-- Modal Tambah Produk -->
    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('products.store') }}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createModalLabel">Tambah Produk</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="create-name" class="form-label">Nama Produk</label>
                            <input type="text" class="form-control" id="create-name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="create-category" class="form-label">Kategori</label>
                            <select class="form-select" id="create-category" name="category_id" required>
                                <option value="" disabled selected>Pilih Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="create-price" class="form-label">Harga</label>
                            <input type="number" class="form-control" id="create-price" name="price" required>
                        </div>
                        <div class="mb-3">
                            <label for="create-stock" class="form-label">Stok</label>
                            <input type="number" class="form-control" id="create-stock" name="stock" required>
                        </div>
                        <div class="mb-3">
                            <label for="create-discount" class="form-label">Diskon</label>
                            <input type="number" class="form-control" id="create-discount" name="discount" value="0" min="0" max="100" required>
                        </div>
                        <div class="mb-3">
                            <label for="create-description" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="create-description" name="description"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const editButtons = document.querySelectorAll(".btn-edit");
            const editForm = document.getElementById("editForm");

            editButtons.forEach(button => {
                button.addEventListener("click", function () {
                    // ambil data dari tombol
                    const id = this.dataset.id;
                    const category = this.dataset.category_id;
                    const name = this.dataset.name;
                    const price = this.dataset.price;
                    const stock = this.dataset.stock;
                    const discount = this.dataset.discount;
                    const description = this.dataset.description;

                    // isi form modal
                    document.getElementById("edit-id").value = id;
                    document.getElementById("edit-category").value = category;
                    document.getElementById("edit-name").value = name;
                    document.getElementById("edit-price").value = price;
                    document.getElementById("edit-stock").value = stock;
                    document.getElementById("edit-discount").value = discount + "%";
                    document.getElementById("edit-description").value = description;

                    // update action form agar sesuai dengan produk
                    editForm.action = `/products/${id}`;
                });
            });
        });
    </script>

</body>
</html>
