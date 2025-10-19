<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Produk Favorit — TumbasLek Mini Commerce</title>
  <link rel="icon" type="image/png" href="{{ asset('images/logoAtas.png') }}?v={{ time() }}">
  <link rel="shortcut icon" href="{{ asset('images/logoAtas.png') }}?v={{ time() }}">
  <link rel="apple-touch-icon" href="{{ asset('images/logoAtas.png') }}?v={{ time() }}">

  {{-- Tailwind CDN --}}
  <script src="https://cdn.tailwindcss.com"></script>
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-gray-50 text-gray-900 antialiased">

  {{-- NAVBAR --}}
  @include('components.navbar')

  @php
      $user = auth()->user();
  @endphp

  <div class="min-h-screen bg-rose-50">
      <div class="mx-auto max-w-7xl px-6">
          <div class="py-6 text-gray-800">
              <h1 class="text-2xl font-bold">Produk Favorit</h1>
          </div>

          <div class="grid grid-cols-12 gap-6 pb-12">
              {{-- Sidebar kiri --}}
              <aside class="col-span-12 md:col-span-3">
                  <div class="rounded-xl bg-white shadow-sm p-6">
                      <div class="flex flex-col items-center gap-3">
                          <div class="h-20 w-20 rounded-full bg-gray-200 flex items-center justify-center">
                              <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400" viewBox="0 0 24 24" fill="currentColor">
                                  <path d="M12 12a5 5 0 1 0-5-5 5 5 0 0 0 5 5Zm0 2c-4.33 0-8 2.17-8 4.5V21h16v-2.5C20 16.17 16.33 14 12 14Z"/>
                              </svg>
                          </div>
                          <div class="text-center">
                              <div class="font-semibold">{{ $user->name ?? 'Nama Pengguna' }}</div>
                              <div class="text-sm text-gray-500">{{ $user->email ?? 'email.pengguna@gmail.com' }}</div>
                          </div>
                      </div>

                      <nav class="mt-8 space-y-2">
                          <a href="{{ route('user.profile') }}"
                             class="block rounded-lg px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                              Profil Saya
                          </a>
                          @if(!$user->is_admin)
                          <a href="{{ route('orders.index') }}"
                             class="block rounded-lg px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                              Riwayat Pesanan
                          </a>
                          
                          <a href="{{ route('favorites') }}"
                             class="block rounded-lg px-4 py-2 text-sm font-medium bg-emerald-100 text-emerald-700">
                              Produk Favorit
                          </a>
                          @endif
                          <a href="{{ route('user.change-password') }}"
                             class="block rounded-lg px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                              Ubah Password
                          </a>
                      </nav>
                  </div>
              </aside>

              {{-- Konten utama --}}
              <main class="col-span-12 md:col-span-9">
                  <div class="rounded-xl bg-white shadow-sm overflow-hidden">
                      <div class="border-b px-6 py-4">
                          <h2 class="text-lg font-semibold">Daftar Produk Favorit</h2>
                      </div>

                      <div class="p-6">
                          @if(!$favorites || $favorites->isEmpty())
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
                                <div id="favorites-container" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                                    @foreach($favorites as $favorite)
                                        @php
                                            $product = $favorite->product;
                                        @endphp

                                        <div id="product-{{ $product->id }}" 
                                            class="product-card border rounded-xl overflow-hidden bg-white hover:shadow-md transition">

                                            <a href="{{ route('products.show', $product->id) }}">
                                                <img src="{{ asset('storage/' . $product->image) }}" 
                                                    alt="{{ $product->name }}" 
                                                    class="h-48 w-full object-cover">
                                            </a>

                                            <div class="p-4">
                                                <a href="{{ route('products.show', $product->id) }}">
                                                    <h3 class="text-gray-800 font-semibold text-base mb-1 hover:underline">
                                                        {{ $product->name }}
                                                    </h3>
                                                </a>
                                                <p class="text-emerald-600 font-bold text-sm mb-3">
                                                    Rp{{ number_format($product->price, 0, ',', '.') }}
                                                </p>

                                                <button 
                                                    type="button"
                                                    class="favorite-toggle bg-red-500 hover:bg-red-600 text-white text-sm px-3 py-1 rounded-md transition"
                                                    data-id="{{ $product->id }}">
                                                    Hapus dari Favorit
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                              <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                                  @foreach($favorites as $favorite)
                                      @php
                                          $product = $favorite->product;
                                      @endphp
                                      <div class="border rounded-xl overflow-hidden bg-white hover:shadow-md transition">
                                          <a href="{{ route('products.show', $product->id) }}">
                                              @if($product->photos && $product->photos->count() > 0)
                                                  <img src="{{ asset('storage/' . $product->photos->first()->url) }}" alt="{{ $product->name }}" 
                                                      class="h-48 w-full object-cover">
                                              @else
                                                  <div class="h-48 w-full bg-gradient-to-br from-emerald-100 to-emerald-200 flex items-center justify-center">
                                                      <div class="text-center">
                                                          <svg class="w-16 h-16 text-emerald-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                                          </svg>
                                                          <span class="text-xs text-emerald-600 font-medium">{{ $product->category->name ?? 'Produk' }}</span>
                                                      </div>
                                                  </div>
                                              @endif
                                              <div class="p-4">
                                                  <h3 class="text-gray-800 font-semibold text-base mb-1">{{ $product->name }}</h3>
                                                  <p class="text-emerald-600 font-bold text-sm mb-2">
                                                      Rp{{ number_format($product->price, 0, ',', '.') }}
                                                  </p>
                                                  <form action="{{ route('favorites.remove', $product->id) }}" method="POST">
                                                      @csrf
                                                      @method('DELETE')
                                                      <button type="submit"
                                                          class="text-sm text-red-500 hover:text-red-700">
                                                          Hapus dari Favorit
                                                      </button>
                                                  </form>
                                              </div>
                                          </a>
                                      </div>
                                  @endforeach
                              </div>
                          @endif
                      </div>
                  </div>
              </main>
          </div>
      </div>
  </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".favorite-toggle").forEach(button => {
                button.addEventListener("click", function(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    const productId = this.dataset.id;

                    fetch(`/favorites/toggle/${productId}`, {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success && !data.is_favorited) {
                            const card = document.querySelector(`#product-${productId}`);
                            if (card) card.remove();

                            // Cek sisa produk favorit
                            const remaining = document.querySelectorAll(".product-card").length;
                            if (remaining === 0) {
                                const productList = document.querySelector("#favorites-container");
                                productList.innerHTML = `
                                <div class="col-span-full text-center p-10 text-gray-500 border-2 border-dashed rounded-xl">
                                    <div class="mb-4">
                                    <svg class="w-16 h-16 mx-auto text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                    </svg>
                                    </div>
                                    <p class="mb-2">Belum ada produk favorit.</p>
                                    <a href="{{ route('products.index') }}" class="text-emerald-600 hover:underline font-medium">Jelajahi Produk</a>
                                </div>
                                `;
                            }
                        }
                    })
                    .catch(err => console.error(err));
                });
            });
        });
    </script>

  {{-- FOOTER --}}
  @include('components.footer')
</body>
</html>
