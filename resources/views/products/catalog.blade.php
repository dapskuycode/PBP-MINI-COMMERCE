@extends('layouts.app')

@section('title', 'Katalog Produk')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4">Katalog Produk</h1>

            <!-- Search and Filter Form -->
            <div class="card mb-4">
                <div class="card-body">
                    <form method="GET" action="{{ route('products.catalog') }}">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="search" class="form-label">Cari Produk</label>
                                <input type="text"
                                       class="form-control"
                                       id="search"
                                       name="search"
                                       value="{{ request('search') }}"
                                       placeholder="Masukkan nama produk...">
                            </div>
                            <div class="col-md-4">
                                <label for="category" class="form-label">Kategori</label>
                                <select class="form-select" id="category" name="category">
                                    <option value="">Semua Kategori</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}"
                                                {{ request('category') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-search"></i> Cari
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Products Grid -->
            @if($products->count() > 0)
                <div class="row g-4">
                    @foreach($products as $product)
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="card h-100 shadow-sm">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}"
                                         class="card-img-top"
                                         alt="{{ $product->name }}"
                                         style="height: 200px; object-fit: cover;">
                                @else
                                    <div class="card-img-top bg-light d-flex align-items-center justify-content-center"
                                         style="height: 200px;">
                                        <i class="fas fa-image fa-3x text-muted"></i>
                                    </div>
                                @endif
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title">{{ $product->name }}</h5>
                                    <p class="card-text text-muted small">{{ $product->category->name }}</p>
                                    <p class="card-text flex-grow-1">{{ Str::limit($product->description, 80) }}</p>
                                    <div class="mt-auto">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="h5 text-primary mb-0">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                            <small class="text-muted">Stok: {{ $product->stock }}</small>
                                        </div>
                                        <div class="d-grid gap-2">
                                            <a href="{{ route('products.detail', $product) }}"
                                               class="btn btn-outline-primary btn-sm">
                                                <i class="fas fa-eye"></i> Detail
                                            </a>
                                            @auth
                                                @if(auth()->user()->role === 'buyer')
                                                    <button type="button"
                                                            class="btn btn-success btn-sm add-to-cart-btn"
                                                            data-product-id="{{ $product->id }}"
                                                            {{ $product->stock <= 0 ? 'disabled' : '' }}>
                                                        <i class="fas fa-cart-plus"></i>
                                                        {{ $product->stock <= 0 ? 'Stok Habis' : 'Tambah ke Keranjang' }}
                                                    </button>
                                                @endif
                                            @else
                                                <a href="{{ route('login') }}" class="btn btn-success btn-sm">
                                                    <i class="fas fa-cart-plus"></i> Tambah ke Keranjang
                                                </a>
                                            @endauth
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $products->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-search fa-3x text-muted mb-3"></i>
                    <h4 class="text-muted">Tidak ada produk ditemukan</h4>
                    <p class="text-muted">Coba ubah kata kunci pencarian atau filter kategori.</p>
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add to cart functionality
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
                    const cartCount = document.querySelector('#cart-count');
                    if (cartCount) {
                        cartCount.textContent = data.cartCount;
                    }

                    // Reset button after 2 seconds
                    setTimeout(() => {
                        this.innerHTML = originalText;
                        this.classList.remove('btn-secondary');
                        this.classList.add('btn-success');
                        this.disabled = false;
                    }, 2000);
                } else {
                    // Show error message
                    alert(data.message || 'Gagal menambahkan produk ke keranjang');
                    this.innerHTML = originalText;
                    this.disabled = false;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan. Silakan coba lagi.');
                this.innerHTML = originalText;
                this.disabled = false;
            });
        });
    });
});
</script>
@endpush
@endsection
