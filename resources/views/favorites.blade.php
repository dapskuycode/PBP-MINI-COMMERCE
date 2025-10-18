<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Produk Favorit — TumbasLek</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-900">

  @include('components.navbar', ['isAdmin' => false])
  <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-2xl font-bold mb-6">Profil Pengguna</h1>

    <div class="grid lg:grid-cols-4 gap-6">
      {{-- Sidebar kiri (samakan dengan profilmu) --}}
      <aside class="lg:col-span-1">
        <div class="bg-white rounded-2xl shadow border p-6">
          <div class="w-20 h-20 mx-auto rounded-full bg-gray-100 grid place-items-center text-gray-400 mb-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
              <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6.75a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 19.5a7.5 7.5 0 1115 0v.75H4.5v-.75z"/>
            </svg>
          </div>
          <div class="text-center font-semibold">{{ auth()->user()->name ?? 'User' }}</div>
          <div class="text-center text-sm text-gray-500 mb-4">{{ auth()->user()->email ?? '' }}</div>

          <nav class="space-y-1">
            <a href="{{ route('user.profile') }}"
               class="block px-4 py-2 rounded text-sm {{ request()->routeIs('user.profile') ? 'bg-emerald-100 text-emerald-800 font-medium' : 'text-gray-700 hover:bg-gray-100' }}">Profil Saya</a>

            <a href="{{ route('orders.index') }}"
               class="block px-4 py-2 rounded text-sm {{ request()->routeIs('orders.index') ? 'bg-emerald-100 text-emerald-800 font-medium' : 'text-gray-700 hover:bg-gray-100' }}">Riwayat Pesanan</a>

            <a href="{{ route('favorites') }}"
               class="block px-4 py-2 rounded text-sm {{ request()->routeIs('profile.favorites') ? 'bg-emerald-100 text-emerald-800 font-medium' : 'text-gray-700 hover:bg-gray-100' }}">Produk Favorit</a>

            <a href="{{ route('user.change-password') }}"
               class="block px-4 py-2 rounded text-sm {{ request()->routeIs('user.change-password') ? 'bg-emerald-100 text-emerald-800 font-medium' : 'text-gray-700 hover:bg-gray-100' }}">Ubah Password</a>
          </nav>
        </div>
      </aside>

      {{-- Konten kanan --}}
      <section class="lg:col-span-3">
        <div class="bg-white rounded-2xl shadow border p-6">
          <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-semibold">Produk Favorit</h2>
          </div>

          @if($favorites->isEmpty())
            <div class="text-center p-10 text-gray-500 border-2 border-dashed rounded-xl">
              <div class="mb-4">
                <svg class="w-16 h-16 mx-auto text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                </svg>
              </div>
              <p class="mb-2">Belum ada produk favorit.</p>
              <a href="{{ route('products.index') }}" class="text-emerald-600 hover:underline font-medium">Jelajahi Produk</a>
            </div>
          @else
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
              @foreach($favorites as $favoriteItem)
                @php $product = $favoriteItem->product; @endphp
                <div class="bg-white border rounded-2xl shadow-sm hover:shadow-md transition overflow-hidden relative">
                  {{-- Remove from favorites button --}}
                  <button onclick="toggleFavorite({{ $product->id }}, event)" 
                          class="absolute top-2 right-2 p-2 bg-white rounded-full shadow-md hover:bg-red-50 z-10">
                    <svg class="w-4 h-4 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                      <path d="M12.001 4.529c2.349-2.532 6.15-2.532 8.5 0 2.35 2.531 2.35 6.635 0 9.166l-7.07 7.622a2 2 0 0 1-2.86 0l-7.07-7.622c-2.35-2.531-2.35-6.635 0-9.166 2.35-2.532 6.151-2.532 8.5 0z"/>
                    </svg>
                  </button>

                  <a href="{{ route('products.show', $product->id) }}">
                    @if($product->photos && $product->photos->count() > 0)
                      <img src="{{ asset('storage/' . $product->photos->first()->url) }}" alt="{{ $product->name }}" class="w-full h-44 object-cover">
                    @else
                      <div class="w-full h-44 grid place-items-center bg-gray-50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                      </div>
                    @endif
                    
                    <div class="p-4">
                      <div class="font-medium truncate mb-2">{{ $product->name }}</div>
                      <div class="text-emerald-700 font-bold">{{ $product->formatted_price }}</div>
                      
                      @if($product->has_discount)
                        <div class="flex items-center space-x-2 mt-1">
                          <span class="text-sm text-gray-400 line-through">{{ $product->formatted_price }}</span>
                          <span class="text-xs bg-red-100 text-red-600 px-2 py-1 rounded">-{{ $product->discount }}%</span>
                        </div>
                      @endif

                      <div class="text-xs text-gray-500 mt-2">
                        Stok: {{ $product->stock }}
                      </div>
                    </div>
                  </a>
                </div>
              @endforeach
            </div>

            {{-- Pagination --}}
            @if($favorites->hasPages())
              <div class="mt-6">
                {{ $favorites->links() }}
              </div>
            @endif
          @endif
        </div>
      </section>
    </div>
  </main>

  @include('components.footer')

  <script>
    // Toggle favorite function for favorites page
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
          const errorText = await response.text();
          console.error('Response error:', errorText);
          showNotification(`Error: ${response.status} - ${response.statusText}`, 'error');
          return;
        }

        const data = await response.json();
        console.log('Response data:', data);

        if (data.success) {
          // If removed from favorites, remove the card from the page
          if (!data.is_favorited) {
            // Find the card and remove it using event if available
            let button = null;
            let card = null;

            if (event && event.target) {
              button = event.target.closest('button');
              card = button ? button.closest('.relative') : null;
            }

            // Fallback: find by productId if event method fails
            if (!card) {
              const allCards = document.querySelectorAll('.grid .relative');
              allCards.forEach(cardElement => {
                const cardButton = cardElement.querySelector('button[onclick*="' + productId + '"]');
                if (cardButton) {
                  card = cardElement;
                }
              });
            }
            
            if (card) {
              card.style.opacity = '0';
              card.style.transform = 'scale(0.95)';
              card.style.transition = 'all 0.3s ease';
              
              setTimeout(() => {
                card.remove();
                // Check if no favorites left
                const remainingCards = document.querySelectorAll('.grid .relative');
                if (remainingCards.length === 0) {
                  location.reload(); // Reload to show empty state
                }
              }, 300);
            }
          }

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
        'bg-blue-500'
      }`;
      notification.textContent = message;

      document.body.appendChild(notification);

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
