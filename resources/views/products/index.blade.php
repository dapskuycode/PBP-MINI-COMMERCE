<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - TokoKami</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Include Navbar -->
    @include('components.navbar', ['isAdmin' => auth()->check() && auth()->user()->is_admin])

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-8 mt-20">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">All Products</h1>
            <p class="text-gray-600">Discover our complete collection of products</p>
        </div>

        <!-- Products Grid -->
        @if($products->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
                @foreach($products as $product)
                    @include('components.product-card', ['product' => $product])
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="flex justify-center">
                {{ $products->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-16">
                <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No products available</h3>
                <p class="text-gray-500">Check back later for new products.</p>
            </div>
        @endif
    </div>

    <!-- Include Footer -->
    @include('components.footer')

    <!-- Add to Cart Functionality -->
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