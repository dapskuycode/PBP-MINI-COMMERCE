{{-- resources/views/components/navbar.blade.php --}}
@props(['isAdmin' => false])

<nav class="bg-white shadow-lg sticky top-0 z-50">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center h-16">
      {{-- Logo --}}
      <div class="flex items-center">
        <a href="{{ route('home') }}" class="flex items-center gap-3">
          <div class="w-10 h-10 bg-emerald-500 rounded-full grid place-items-center">
            <img src="{{ asset('images/logo.png') }}" alt="TokoKami" class="w-8 h-8 rounded-full">
          </div>
          <div>
            <div class="text-xl font-bold text-gray-900">
              TokoKami
            </div>
            <div class="text-xs text-gray-500">UMKM Mini-Commerce</div>
          </div>
        </a>
      </div>

      {{-- Links (Desktop) --}}
      <div class="hidden md:flex items-center gap-8">
        @if($isAdmin)
          {{-- Admin Links --}}
          <a href="{{ route('dashboard') }}"
             class="relative py-2 {{ request()->routeIs('dashboard') ? 'text-emerald-700 font-semibold after:absolute after:left-0 after:-bottom-1 after:h-0.5 after:w-full after:bg-emerald-600' : 'text-gray-700 hover:text-emerald-600' }}">
            Dashboard
          </a>
          <a href="#"
             class="relative py-2 text-gray-700 hover:text-emerald-600">
            Produk
          </a>
          <a href="#"
             class="relative py-2 text-gray-700 hover:text-emerald-600">
            Kategori
          </a>
          <a href="#"
             class="relative py-2 text-gray-700 hover:text-emerald-600">
            Pesanan
          </a>
          <a href="#"
             class="relative py-2 text-gray-700 hover:text-emerald-600">
            Pengguna
          </a>
        @else
          {{-- Public Links --}}
          <a href="{{ route('home') }}"
             class="relative py-2 {{ request()->routeIs('home') ? 'text-emerald-700 font-semibold after:absolute after:left-0 after:-bottom-1 after:h-0.5 after:w-full after:bg-emerald-600' : 'text-gray-700 hover:text-emerald-600' }}"
             {{ request()->routeIs('home') ? 'aria-current=page' : '' }}>
            Beranda
          </a>

          <a href="{{ url('/products') }}"
             class="relative py-2 {{ request()->is('products*') ? 'text-emerald-700 font-semibold after:absolute after:left-0 after:-bottom-1 after:h-0.5 after:w-full after:bg-emerald-600' : 'text-gray-700 hover:text-emerald-600' }}"
             {{ request()->is('products*') ? 'aria-current=page' : '' }}>
            Produk
          </a>

          @if(isset($categories) && $categories->count() > 0)
            <a href="{{ route('categories.index') }}"
               class="relative py-2 {{ request()->is('categories*') ? 'text-emerald-700 font-semibold after:absolute after:left-0 after:-bottom-1 after:h-0.5 after:w-full after:bg-emerald-600' : 'text-gray-700 hover:text-emerald-600' }}">
              Kategori
            </a>
          @endif

          <a href="{{ route('about') }}"
             class="relative py-2 {{ request()->routeIs('about') ? 'text-emerald-700 font-semibold after:absolute after:left-0 after:-bottom-1 after:h-0.5 after:w-full after:bg-emerald-600' : 'text-gray-700 hover:text-emerald-600' }}"
             {{ request()->routeIs('about') ? 'aria-current=page' : '' }}>
            Tentang Kami
          </a>
        @endif
      </div>

      {{-- Search --}}
      @if(!$isAdmin)
        <div class="flex-1 max-w-lg mx-8 hidden md:block">
          <form action="{{ route('search') }}" method="GET" class="relative">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari produk…"
                   class="w-full pl-4 pr-12 py-2 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
            <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 bg-emerald-500 text-white p-2 rounded-full hover:bg-emerald-600">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
              </svg>
            </button>
          </form>
        </div>
      @endif

      {{-- Actions kanan --}}
      <div class="flex items-center gap-4">
        @if(!$isAdmin)
          {{-- Cart (ikon basket baru) --}}
          @php $cartCount = session('cart.count', 0); @endphp
          <a href="{{ url('/cart') }}" class="relative p-2 text-gray-700 hover:text-emerald-600">
            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M5 8l2-3a2 2 0 011.7-1h6.6a2 2 0 011.7 1l2 3M6 8h12l-1 11a2 2 0 01-2 2H9a2 2 0 01-2-2L6 8zM9 11v6m6-6v6"/>
            </svg>
            <span class="cart-count absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 grid place-items-center {{ $cartCount > 0 ? '' : 'hidden' }}">
              {{ $cartCount }}
            </span>
          </a>
        @else

          

          {{-- Admin: Link to store view --}}
          <a href="{{ route('home') }}" class="flex items-center gap-2 px-3 py-2 text-sm text-gray-700 hover:text-emerald-600 bg-gray-50 rounded-lg hover:bg-gray-100">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
            </svg>
            Lihat Toko
          </a>
        @endif

        {{-- User --}}
        @auth
          <div class="relative group">
            <button class="flex items-center gap-2 text-gray-700 hover:text-emerald-600">
              <div class="w-8 h-8 bg-emerald-500 rounded-full grid place-items-center text-white font-medium">
                {{ mb_substr(Auth::user()->name,0,1) }}
              </div>
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
              </svg>
            </button>
            <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
              <div class="py-2">
                <div class="px-4 py-2 text-sm text-gray-500 border-b">{{ Auth::user()->name }}</div>
                @if(!$isAdmin && Auth::user()->is_admin)
                  <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    Dashboard
                  </a>
                @endif
                <a href="{{ route('user.profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                  <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                  </svg>
                  Akun Saya
                </a>
                <a href="{{ route('orders.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition">
                  <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 inline mr-2 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.2 6h12.4L17 13M7 13H5.4m1.6 6a2 2 0 104 0m6 0a2 2 0 104 0"/>
                  </svg>
                  Pesanan Saya
                </a>


                <div class="border-t my-1"></div>
                <a href="{{ route('logout') }}" class="block px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                  <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                  </svg>
                  Logout
                </a>
              </div>
            </div>
          </div>
        @else
          <a href="{{ route('login') }}" class="bg-emerald-500 text-white px-4 py-2 rounded-lg hover:bg-emerald-600">Login</a>
          <a href="{{ route('register') }}" class="bg-emerald-500 text-white px-4 py-2 rounded-lg hover:bg-emerald-600">Register</a>
        @endauth

        {{-- Mobile toggler --}}
        <button class="md:hidden p-2 text-gray-700 hover:text-emerald-600" onclick="toggleMobileMenu()">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
          </svg>
        </button>
      </div>
    </div>

    {{-- Mobile menu --}}
    <div id="mobileMenu" class="md:hidden hidden border-t border-gray-200">
      <div class="px-3 pt-3 pb-4 space-y-1">
        {{-- Mobile search --}}
        @if(!$isAdmin)
          <form action="{{ route('search') }}" method="GET" class="relative mb-2">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari produk…"
                   class="w-full pl-4 pr-12 py-2 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-emerald-500">
            <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 bg-emerald-500 text-white p-2 rounded-full">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
              </svg>
            </button>
          </form>
        @endif

        {{-- Links (Mobile) --}}
        @if($isAdmin)
          {{-- Admin Mobile Links --}}
          <a href="{{ route('dashboard') }}"
             class="block px-3 py-2 rounded {{ request()->routeIs('dashboard') ? 'bg-emerald-50 text-emerald-700 font-semibold' : 'text-gray-700 hover:bg-gray-100' }}">
            Dashboard
          </a>
          <a href="#" class="block px-3 py-2 rounded text-gray-700 hover:bg-gray-100">Produk</a>
          <a href="#" class="block px-3 py-2 rounded text-gray-700 hover:bg-gray-100">Kategori</a>
          <a href="#" class="block px-3 py-2 rounded text-gray-700 hover:bg-gray-100">Pesanan</a>
          <a href="#" class="block px-3 py-2 rounded text-gray-700 hover:bg-gray-100">Pengguna</a>
        @else
          {{-- Public Mobile Links --}}
          <a href="{{ route('home') }}"
             class="block px-3 py-2 rounded {{ request()->routeIs('home') ? 'bg-emerald-50 text-emerald-700 font-semibold' : 'text-gray-700 hover:bg-gray-100' }}">
            Beranda
          </a>
          <a href="{{ url('/products') }}"
             class="block px-3 py-2 rounded {{ request()->is('products*') ? 'bg-emerald-50 text-emerald-700 font-semibold' : 'text-gray-700 hover:bg-gray-100' }}">
            Produk
          </a>
          @if(isset($categories) && $categories->count() > 0)
            <a href="{{ route('categories.index') }}"
               class="block px-3 py-2 rounded {{ request()->is('categories*') ? 'bg-emerald-50 text-emerald-700 font-semibold' : 'text-gray-700 hover:bg-gray-100' }}">
              Kategori
            </a>
          @endif
          <a href="{{ route('about') }}"
             class="block px-3 py-2 rounded {{ request()->routeIs('about') ? 'bg-emerald-50 text-emerald-700 font-semibold' : 'text-gray-700 hover:bg-gray-100' }}">
            Tentang Kami
          </a>
        @endif
      </div>
    </div>
  </div>
</nav>

<script>
  function toggleMobileMenu() {
    const el = document.getElementById('mobileMenu');
    el.classList.toggle('hidden');
  }
</script>