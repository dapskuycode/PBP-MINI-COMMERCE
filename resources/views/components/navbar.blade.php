{{-- resources/views/components/navbar.blade.php --}}
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
            <div class="text-xl font-bold text-gray-900">TokoKami</div>
            <div class="text-xs text-gray-500">UMKM Mini-Commerce</div>
          </div>
        </a>
      </div>

      {{-- Links (Desktop) --}}
      <div class="hidden md:flex items-center gap-8">
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

        <a href="{{ route('about') }}"
           class="relative py-2 {{ request()->routeIs('about') ? 'text-emerald-700 font-semibold after:absolute after:left-0 after:-bottom-1 after:h-0.5 after:w-full after:bg-emerald-600' : 'text-gray-700 hover:text-emerald-600' }}"
           {{ request()->routeIs('about') ? 'aria-current=page' : '' }}>
          Tentang Kami
        </a>
      </div>

      {{-- Search --}}
      <div class="flex-1 max-w-lg mx-8 hidden md:block">
        <div class="relative">
          <input type="text" placeholder="Cari produk…"
                 class="w-full pl-4 pr-12 py-2 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
          <button class="absolute right-2 top-1/2 -translate-y-1/2 bg-emerald-500 text-white p-2 rounded-full hover:bg-emerald-600">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
          </button>
        </div>
      </div>

      {{-- Actions kanan --}}
      <div class="flex items-center gap-4">
        {{-- Cart (ikon basket baru) --}}
        @php $cartCount = session('cart.count', 0); @endphp
        <a href="{{ url('/cart') }}" class="relative p-2 text-gray-700 hover:text-emerald-600">
          <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M5 8l2-3a2 2 0 011.7-1h6.6a2 2 0 011.7 1l2 3M6 8h12l-1 11a2 2 0 01-2 2H9a2 2 0 01-2-2L6 8zM9 11v6m6-6v6"/>
          </svg>
          <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 grid place-items-center">
            {{ $cartCount }}
          </span>
        </a>

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
                @if(Auth::user()->is_admin)
                  <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Dashboard</a>
                @endif
                <a href="{{ route('user.profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profil</a>
                <a href="{{ route('logout') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Logout</a>
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
        <div class="relative mb-2">
          <input type="text" placeholder="Cari produk…"
                 class="w-full pl-4 pr-12 py-2 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-emerald-500">
          <button class="absolute right-2 top-1/2 -translate-y-1/2 bg-emerald-500 text-white p-2 rounded-full">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
          </button>
        </div>

        {{-- Links (Mobile) --}}
        <a href="{{ route('home') }}"
           class="block px-3 py-2 rounded {{ request()->routeIs('home') ? 'bg-emerald-50 text-emerald-700 font-semibold' : 'text-gray-700 hover:bg-gray-100' }}">
          Beranda
        </a>
        <a href="{{ url('/products') }}"
           class="block px-3 py-2 rounded {{ request()->is('products*') ? 'bg-emerald-50 text-emerald-700 font-semibold' : 'text-gray-700 hover:bg-gray-100' }}">
          Produk
        </a>
        <a href="{{ route('about') }}"
           class="block px-3 py-2 rounded {{ request()->routeIs('about') ? 'bg-emerald-50 text-emerald-700 font-semibold' : 'text-gray-700 hover:bg-gray-100' }}">
          Tentang Kami
        </a>
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