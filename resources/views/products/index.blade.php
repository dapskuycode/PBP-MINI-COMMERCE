<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - TumbasLek Mini Commerce</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logoAtas.png') }}?v={{ time() }}">
    <link rel="shortcut icon" href="{{ asset('images/logoAtas.png') }}?v={{ time() }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logoAtas.png') }}?v={{ time() }}">
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
    {{-- Navbar --}}
    @include('components.navbar', ['isAdmin' => auth()->check() && auth()->user()->is_admin])

    <div class="container mx-auto px-4 py-4" style="margin-top:40px">
        {{-- Header --}}
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">All Products</h1>
            <p class="text-gray-600">Discover our complete collection of products</p>
        </div>

        {{-- GRID: Sidebar kategori (3) + Konten produk (9) --}}
        <div class="grid grid-cols-12 gap-6">
            {{-- Sidebar Kiri: Kategori elegan (tanpa query di Blade) --}}
            <aside class="col-span-12 md:col-span-3">
            <div class="sticky top-24 rounded-2xl bg-white border border-gray-200 shadow-sm p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Kategori Produk</h2>

                @php
                // Kalau $categories ada dari controller, pakai itu.
                // Kalau tidak, bangun dari $products (yang sudah include relasi category).
                $cats = isset($categories)
                    ? collect($categories)->map(function ($c) {
                        $slug = \Illuminate\Support\Str::slug(data_get($c, 'name', ''));
                        return (object)[ 'name' => data_get($c,'name'), 'slug' => $slug ];
                    })
                    : collect($products)
                        ->pluck('category')            // ambil relasi category
                        ->filter()                     // buang null
                        ->unique('name')               // unik berdasarkan name (bukan slug)
                        ->map(function ($c) {          // normalisasi bentuk object {name, slug}
                            $slug = \Illuminate\Support\Str::slug(data_get($c, 'name', ''));
                            return (object)[ 'name' => data_get($c,'name'), 'slug' => $slug ];
                        })
                        ->values();

                $active = request('category'); // ?category=slug
                @endphp

                <ul class="space-y-2 text-sm">
                <li>
                    <a href="{{ url('/products') }}"
                    class="block px-3 py-2 rounded-lg border transition
                            {{ empty($active)
                                ? 'border-emerald-600 bg-emerald-50 text-emerald-700 font-medium'
                                : 'border-gray-200 hover:border-emerald-500 hover:bg-emerald-50 hover:text-emerald-700' }}">
                    Semua Produk
                    </a>
                </li>

                @forelse($cats as $cat)
                    @php
                    $slug = data_get($cat, 'slug', '');
                    $name = data_get($cat, 'name', '-');
                    $isActive = $active === $slug;
                    @endphp
                    <li>
                    <a href="{{ url('/products?category=' . $slug) }}"
                        class="block px-3 py-2 rounded-lg border transition
                                {{ $isActive
                                    ? 'border-emerald-600 bg-emerald-50 text-emerald-700 font-medium'
                                    : 'border-gray-200 hover:border-emerald-500 hover:bg-emerald-50 hover:text-emerald-700' }}">
                        {{ $name }}
                    </a>
                    </li>
                @empty
                    <li>
                    <span class="block px-3 py-2 text-gray-400 border border-dashed rounded-lg">
                        Belum ada kategori
                    </span>
                    </li>
                @endforelse
                </ul>
            </div>
            </aside>


            {{-- Konten Produk --}}
            <section class="col-span-12 md:col-span-9">
                @if($products->count() > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 gap-6 mb-8">
                        @foreach($products as $product)
                            @include('components.product-card', ['product' => $product])
                        @endforeach
                    </div>

                    <div class="flex justify-center">
                        {{ $products->links() }}
                    </div>
                @else
                    <div class="text-center py-16 rounded-2xl bg-white border border-gray-200">
                        <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No products available</h3>
                        <p class="text-gray-500">Check back later for new products.</p>
                    </div>
                @endif
            </section>
        </div>
    </div>

    {{-- Footer --}}
    @include('components.footer')

    {{-- Add to Cart (tetap seperti punyamu) --}}
    <script>
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
                    showLoginModal();
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

        // Show login required modal
        function showLoginModal() {
            const modal = document.getElementById('modal');
            const modalIcon = document.getElementById('modal-icon');
            const modalTitle = document.getElementById('modal-title');
            const modalMessage = document.getElementById('modal-message');
            const modalButton = modal.querySelector('button');

            // Set login required style
            modalIcon.className = 'w-16 h-16 mx-auto mb-4 rounded-full flex items-center justify-center bg-blue-100';
            modalIcon.innerHTML = '<svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>';

            modalTitle.textContent = 'Login Diperlukan';
            modalMessage.textContent = 'Anda perlu login untuk menambahkan produk ke keranjang';
            
            // Change button to redirect to login
            modalButton.textContent = 'Login Sekarang';
            modalButton.onclick = function() {
                window.location.href = '/login';
            };

            modal.classList.remove('hidden');
        }

        // Close modal when clicking outside
        document.getElementById('modal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });

        // Toggle favorite function
        async function toggleFavorite(productId, event) {
            console.log('Toggling favorite for product:', productId);
            
            const csrfToken = document.querySelector('meta[name="csrf-token"]');
            if (!csrfToken) {
                showNotification('CSRF token tidak ditemukan', 'error');
                return;
            }
            
            try {
                const response = await fetch(`/favorites/toggle/${productId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken.getAttribute('content')
                    }
                });

                console.log('Response status:', response.status);

                if (!response.ok) {
                    if (response.status === 302 || response.redirected || response.url.includes('/login')) {
                        showLoginModal();
                        return;
                    }
                    const errorText = await response.text();
                    console.error('Response error:', errorText);
                    showNotification(`Error: ${response.status} - ${response.statusText}`, 'error');
                    return;
                }

                const data = await response.json();
                console.log('Response data:', data);

                if (data.success) {
                    // Update heart icons based on favorite status
                    const outlineIcon = document.getElementById(`fav-outline-${productId}`);
                    const solidIcon = document.getElementById(`fav-solid-${productId}`);

                    console.log('Outline icon found:', outlineIcon ? 'Yes' : 'No');
                    console.log('Solid icon found:', solidIcon ? 'Yes' : 'No');
                    console.log('Is favorited:', data.is_favorited);

                    if (outlineIcon && solidIcon) {
                        if (data.is_favorited) {
                            outlineIcon.classList.add('hidden');
                            solidIcon.classList.remove('hidden');
                        } else {
                            outlineIcon.classList.remove('hidden');
                            solidIcon.classList.add('hidden');
                        }
                    }

                    // Show notification
                    showNotification(data.message, data.is_favorited ? 'success' : 'info');
                } else {
                    showNotification(data.message, 'error');
                }
            } catch (error) {
                console.error('Error toggling favorite:', error);
                showNotification('Terjadi kesalahan. Silakan coba lagi.', 'error');
            }
        }

        // Show notification function
        function showNotification(message, type = 'success') {
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 p-4 rounded-lg shadow-lg text-white z-50 transition-all duration-300 ${
                type === 'success' ? 'bg-green-500' : 
                type === 'error' ? 'bg-red-500' : 
                type === 'info' ? 'bg-blue-500' :
                'bg-gray-500'
            }`;
            notification.textContent = message;

            document.body.appendChild(notification);

            // Remove notification after 3 seconds
            setTimeout(() => {
                notification.style.opacity = '0';
                setTimeout(() => {
                    document.body.removeChild(notification);
                }, 300);
            }, 3000);
        }
    </script>
</body>
</html>
