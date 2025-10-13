<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ $product->name ?? 'Produk' }} — UMKM Mini-Commerce</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-emerald-50 via-white to-rose-50 text-gray-900 antialiased">

@include('components.navbar', ['isAdmin' => false])

<header class="mx-auto max-w-7xl px-4 md:px-6 pt-6">
  <nav class="text-sm text-gray-500">
    <a href="{{ route('products.index') }}" class="hover:text-emerald-600">Produk</a>
    <span class="mx-2">/</span>
    <span class="text-gray-700 font-medium line-clamp-1">{{ $product->name }}</span>
  </nav>
</header>

@php
  $price = (int)($product->price ?? 0);
  $stock = (int)($product->stock ?? 0);
@endphp

<main class="mx-auto max-w-7xl px-4 md:px-6 py-6">
  <div class="grid lg:grid-cols-2 gap-8">
    {{-- FOTO PRODUK --}}
    <section class="rounded-3xl bg-white border border-gray-100 shadow overflow-hidden">
      @if($product->photos && $product->photos->count() > 0)
        @php
          // Get primary photo or first photo
          $primaryPhoto = $product->photos->where('is_primary', true)->first() ?? $product->photos->first();
        @endphp
        <div class="relative">
          <img src="{{ asset('storage/' . $primaryPhoto->url) }}" 
               alt="{{ $primaryPhoto->alt_text ?? $product->name }}" 
               class="w-full h-[420px] object-cover">
          
          @if($product->photos->count() > 1)
            {{-- Photo counter badge --}}
            <div class="absolute top-4 right-4 bg-black/60 text-white text-sm px-3 py-1 rounded-full">
              {{ $product->photos->count() }} foto
            </div>
            
            {{-- Thumbnail navigation --}}
            <div class="absolute bottom-4 left-4 right-4">
              <div class="flex gap-2 overflow-x-auto pb-1">
                @foreach($product->photos as $index => $photo)
                  <img src="{{ asset('storage/' . $photo->url) }}" 
                       alt="{{ $photo->alt_text ?? $product->name . ' - Foto ' . ($index + 1) }}"
                       class="w-16 h-16 rounded-lg object-cover border-2 {{ $photo->id === $primaryPhoto->id ? 'border-white' : 'border-white/50' }} hover:border-white cursor-pointer transition-all"
                       onclick="changeMainImage('{{ asset('storage/' . $photo->url) }}', '{{ $photo->alt_text ?? $product->name . ' - Foto ' . ($index + 1) }}', this)">
                @endforeach
              </div>
            </div>
          @endif
        </div>
      @else
        {{-- Fallback jika tidak ada foto --}}
        <div class="w-full h-[420px] flex items-center justify-center bg-gradient-to-br from-amber-100 via-rose-100 to-emerald-100">
          {{-- Placeholder icon (no emoji) --}}
          <svg xmlns="http://www.w3.org/2000/svg" class="w-24 h-24 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 7a2 2 0 012-2h14a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V7z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 7l6.5 6.5a2 2 0 002.8 0L21 5" />
            <circle cx="8" cy="9" r="2" />
          </svg>
        </div>
      @endif
    </section>

    {{-- INFO PRODUK --}}
    <section>
      <div class="rounded-3xl bg-white border border-gray-100 shadow p-6 md:p-8">
        <div class="flex items-start justify-between gap-3">
          <div>
            <h1 class="text-2xl md:text-3xl font-extrabold capitalize">{{ $product->name }}</h1>

            {{-- STOK --}}
            <div class="mt-2 flex items-center gap-2">
              @if($stock > 0)
                <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-sm bg-emerald-100 text-emerald-700">
                  {{-- check icon --}}
                  <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                  </svg>
                  Stok tersedia • {{ $stock }}
                </span>
              @else
                <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-sm bg-red-100 text-red-700">
                  {{-- x-circle icon --}}
                  <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m6-3H6"/>
                  </svg>
                  Stok habis
                </span>
              @endif
            </div>
          </div>

          {{-- WISHLIST tombol (tanpa emoji) --}}
          <button id="fav" type="button"
                  class="h-11 w-11 rounded-full border border-gray-200 hover:bg-rose-50 grid place-items-center"
                  aria-label="Tambah ke favorit">
            {{-- heart outline --}}
            <svg id="fav-outline" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-rose-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 016.364 0L12 7.636l1.318-1.318a4.5 4.5 0 116.364 6.364L12 21l-7.682-7.318a4.5 4.5 0 010-6.364z"/>
            </svg>
            {{-- heart solid --}}
            <svg id="fav-solid" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white hidden" viewBox="0 0 24 24" fill="currentColor">
              <path d="M12.001 4.529c2.349-2.532 6.15-2.532 8.5 0 2.35 2.531 2.35 6.635 0 9.166l-7.07 7.622a2 2 0 0 1-2.86 0l-7.07-7.622c-2.35-2.531-2.35-6.635 0-9.166 2.35-2.532 6.151-2.532 8.5 0z"/>
            </svg>
          </button>
        </div>

        {{-- HARGA --}}
        <div class="mt-4 p-4 rounded-2xl bg-emerald-50 border border-emerald-100">
          <div class="text-sm text-emerald-700">Harga</div>
          <div class="text-3xl font-black text-emerald-700">
            Rp {{ number_format($price, 0, ',', '.') }}
          </div>
        </div>

        {{-- DESKRIPSI --}}
        <div class="mt-5">
          <h2 class="text-base font-semibold mb-1">Deskripsi</h2>
          <p class="text-gray-700 leading-relaxed">
            {{ $product->description ?? 'Deskripsi belum tersedia.' }}
          </p>
        </div>

        {{-- KUANTITAS + ADD TO CART --}}
        <form action="{{ route('cart.add') }}" method="POST" class="mt-6">
          @csrf
          <input type="hidden" name="product_id" value="{{ $product->id }}">

          <div class="flex items-center gap-4">
            <div class="flex items-center rounded-2xl border border-gray-200 overflow-hidden">
              <button type="button" class="px-3 py-2 text-lg disabled:text-gray-400" id="minus" {{ $stock<=0 ? 'disabled' : '' }}>−</button>
              <input type="number" name="quantity" id="qty" value="1" min="1" max="{{ max($stock,1) }}"
                     class="w-16 text-center focus:outline-none" {{ $stock<=0 ? 'disabled' : '' }}>
              <button type="button" class="px-3 py-2 text-lg disabled:text-gray-400" id="plus" {{ $stock<=0 ? 'disabled' : '' }}>+</button>
            </div>

            <button {{ $stock<=0 ? 'disabled' : '' }}
              class="flex-1 inline-flex items-center justify-center gap-2 rounded-2xl
                     {{ $stock>0 ? 'bg-emerald-600 hover:bg-emerald-700 text-white' : 'bg-gray-200 text-gray-500 cursor-not-allowed' }}
                     px-5 py-3 font-semibold">
              {{-- cart icon --}}
              <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.2 6h12.4L17 13M7 13H5.4m1.6 6a2 2 0 104 0m6 0a2 2 0 104 0"/>
              </svg>
              {{ $stock>0 ? 'Tambah ke Keranjang' : 'Stok Habis' }}
            </button>
          </div>
        </form>

        {{-- Info singkat --}}
        <div class="mt-6 grid sm:grid-cols-3 gap-4 text-sm">
          <div class="rounded-2xl border border-gray-200 p-3 bg-gray-50"><span class="font-semibold">Garansi</span><br> 7 hari retur</div>
          <div class="rounded-2xl border border-gray-200 p-3 bg-gray-50"><span class="font-semibold">Pengiriman</span><br> JNE / J&amp;T / SiCepat</div>
          <div class="rounded-2xl border border-gray-200 p-3 bg-gray-50"><span class="font-semibold">Asal</span><br> UMKM Lokal</div>
        </div>
      </div>
    </section>
  </div>

  {{-- Produk terkait (opsional jika ada $relatedProducts) --}}
  @isset($relatedProducts)
    @if(count($relatedProducts))
      <section class="mt-10">
        <h2 class="text-lg font-semibold mb-4">Produk Terkait</h2>
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
          @foreach($relatedProducts as $p)
            <a href="{{ route('products.show', $p) }}" class="rounded-2xl bg-white border border-gray-100 shadow hover:shadow-lg transition overflow-hidden">
              @php
                $relatedPrimaryPhoto = $p->photos && $p->photos->count() > 0 
                  ? ($p->photos->where('is_primary', true)->first() ?? $p->photos->first())
                  : null;
              @endphp
              @if($relatedPrimaryPhoto)
                <img src="{{ asset('storage/' . $relatedPrimaryPhoto->url) }}" 
                     alt="{{ $relatedPrimaryPhoto->alt_text ?? $p->name }}" 
                     class="w-full h-40 object-cover">
              @else
                <div class="w-full h-40 flex items-center justify-center bg-gradient-to-br from-emerald-100 via-rose-100 to-amber-100">
                  {{-- cart placeholder --}}
                  <svg xmlns="http://www.w3.org/2000/svg" class="w-9 h-9 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.2 6h12.4L17 13M7 13H5.4m1.6 6a2 2 0 104 0m6 0a2 2 0 104 0"/>
                  </svg>
                </div>
              @endif
              <div class="p-3">
                <div class="font-medium line-clamp-1">{{ $p->name }}</div>
                <div class="text-emerald-700 font-bold">Rp {{ number_format((int)($p->price ?? 0), 0, ',', '.') }}</div>
              </div>
            </a>
          @endforeach
        </div>
      </section>
    @endif
  @endisset
</main>

@include('components.footer')

<script>
  // qty stepper
  const qty  = document.getElementById('qty');
  const minus= document.getElementById('minus');
  const plus = document.getElementById('plus');
  if (qty && minus && plus) {
    minus.onclick = () => qty.value = Math.max(1, (+qty.value||1)-1);
    plus.onclick  = () => qty.value = Math.min((+qty.max||99), (+qty.value||1)+1);
  }

  // wishlist toggle (tanpa emoji)
  const favBtn    = document.getElementById('fav');
  const favOutline= document.getElementById('fav-outline');
  const favSolid  = document.getElementById('fav-solid');
  if (favBtn) {
    favBtn.addEventListener('click', () => {
      const active = favBtn.classList.toggle('bg-rose-500');
      favBtn.classList.toggle('text-white', active);
      favOutline.classList.toggle('hidden', active);
      favSolid.classList.toggle('hidden', !active);
    });
  }

  // change main product image
  function changeMainImage(newSrc, newAlt, clickedThumb) {
    const mainImg = document.querySelector('section img');
    if (mainImg && newSrc && newAlt) {
      mainImg.src = newSrc;
      mainImg.alt = newAlt;
      
      // Update thumbnail borders
      const allThumbs = document.querySelectorAll('.absolute.bottom-4 img');
      allThumbs.forEach(thumb => {
        thumb.classList.remove('border-white');
        thumb.classList.add('border-white/50');
      });
      
      if (clickedThumb) {
        clickedThumb.classList.remove('border-white/50');
        clickedThumb.classList.add('border-white');
      }
    }
  }
</script>
</body>
</html>
