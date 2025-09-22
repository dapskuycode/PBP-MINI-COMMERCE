@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('products.catalog') }}">Katalog</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
                </ol>
            </nav>

            <!-- Product Detail -->
            <div class="row">
                <div class="col-lg-6 mb-4">
                    <!-- Product Image -->
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}"
                             class="img-fluid rounded shadow"
                             alt="{{ $product->name }}"
                             style="width: 100%; height: 400px; object-fit: cover;">
                    @else
                        <div class="bg-light d-flex align-items-center justify-content-center rounded shadow"
                             style="width: 100%; height: 400px;">
                            <i class="fas fa-image fa-5x text-muted"></i>
                        </div>
                    @endif
                </div>
                <div class="col-lg-6">
                    <!-- Product Info -->
                    <div class="mb-3">
                        <span class="badge bg-primary">{{ $product->category->name }}</span>
                    </div>
                    <h1 class="h2 mb-3">{{ $product->name }}</h1>
                    <div class="mb-3">
                        <span class="h3 text-primary">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                    </div>
                    <div class="mb-3">
                        <strong>Stok: </strong>
                        <span class="badge {{ $product->stock > 0 ? 'bg-success' : 'bg-danger' }}">
                            {{ $product->stock > 0 ? $product->stock . ' tersedia' : 'Habis' }}
                        </span>
                    </div>
                    <div class="mb-4">
                        <h5>Deskripsi Produk</h5>
                        <p class="text-muted">{{ $product->description }}</p>
                    </div>

                    <!-- Add to Cart Section -->
                    @auth
                        @if(auth()->user()->role === 'buyer')
                            <div class="mb-4">
                                <div class="row g-2">
                                    <div class="col-md-4">
                                        <label for="quantity" class="form-label">Jumlah</label>
                                        <input type="number"
                                               class="form-control"
                                               id="quantity"
                                               value="1"
                                               min="1"
                                               max="{{ $product->stock }}"
                                               {{ $product->stock <= 0 ? 'disabled' : '' }}>
                                    </div>
                                    <div class="col-md-8 d-flex align-items-end">
                                        <button type="button"
                                                class="btn btn-success me-2 flex-fill add-to-cart-btn"
                                                data-product-id="{{ $product->id }}"
                                                {{ $product->stock <= 0 ? 'disabled' : '' }}>
                                            <i class="fas fa-cart-plus"></i>
                                            {{ $product->stock <= 0 ? 'Stok Habis' : 'Tambah ke Keranjang' }}
                                        </button>
                                        <a href="{{ route('cart.index') }}" class="btn btn-outline-primary">
                                            <i class="fas fa-shopping-cart"></i> Lihat Keranjang
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @else
                        <div class="mb-4">
                            <a href="{{ route('login') }}" class="btn btn-success me-2">
                                <i class="fas fa-cart-plus"></i> Login untuk Membeli
                            </a>
                        </div>
                    @endauth
                </div>
            </div>

            <!-- Related Products -->
            @if($relatedProducts->count() > 0)
                <div class="mt-5">
                    <h4 class="mb-4">Produk Terkait</h4>
                    <div class="row g-4">
                        @foreach($relatedProducts as $relatedProduct)
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <div class="card h-100 shadow-sm">
                                    @if($relatedProduct->image)
                                        <img src="{{ asset('storage/' . $relatedProduct->image) }}"
                                             class="card-img-top"
                                             alt="{{ $relatedProduct->name }}"
                                             style="height: 180px; object-fit: cover;">
                                    @else
                                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center"
                                             style="height: 180px;">
                                            <i class="fas fa-image fa-2x text-muted"></i>
                                        </div>
                                    @endif
                                    <div class="card-body d-flex flex-column">
                                        <h6 class="card-title">{{ $relatedProduct->name }}</h6>
                                        <p class="card-text small text-muted">{{ Str::limit($relatedProduct->description, 60) }}</p>
                                        <div class="mt-auto">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <span class="fw-bold text-primary">Rp {{ number_format($relatedProduct->price, 0, ',', '.') }}</span>
                                            </div>
                                            <a href="{{ route('products.detail', $relatedProduct) }}"
                                               class="btn btn-outline-primary btn-sm w-100">
                                                <i class="fas fa-eye"></i> Lihat Detail
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add to cart functionality
    const addToCartBtn = document.querySelector('.add-to-cart-btn');
    const quantityInput = document.querySelector('#quantity');

    if (addToCartBtn) {
        addToCartBtn.addEventListener('click', function() {
            const productId = this.dataset.productId;
            const quantity = quantityInput ? parseInt(quantityInput.value) : 1;
            const originalText = this.innerHTML;

            // Validate quantity
            if (quantity < 1) {
                alert('Jumlah harus minimal 1');
                return;
            }

            // Disable button and show loading
            this.disabled = true;
            this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menambahkan...';

            fetch(`/cart/add/${productId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ quantity: quantity })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show success message
                    this.innerHTML = '<i class="fas fa-check"></i> Berhasil Ditambahkan!';
                    this.classList.remove('btn-success');
                    this.classList.add('btn-secondary');

                    // Update cart count if element exists
                    const cartCount = document.querySelector('#cart-count');
                    if (cartCount) {
                        cartCount.textContent = data.cartCount;
                    }

                    // Reset button after 3 seconds
                    setTimeout(() => {
                        this.innerHTML = originalText;
                        this.classList.remove('btn-secondary');
                        this.classList.add('btn-success');
                        this.disabled = false;
                    }, 3000);
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
    }
});
</script>
@endpush
@endsection
