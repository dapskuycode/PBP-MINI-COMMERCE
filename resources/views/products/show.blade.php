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
        <div class="mt-6">
          <div class="flex items-center gap-4">
            <div class="flex items-center rounded-2xl border border-gray-200 overflow-hidden">
              <button type="button" class="px-3 py-2 text-lg disabled:text-gray-400" id="minus" {{ $stock<=0 ? 'disabled' : '' }}>−</button>
              <input type="number" id="qty" value="1" min="1" max="{{ max($stock,1) }}"
                     class="w-16 text-center focus:outline-none" {{ $stock<=0 ? 'disabled' : '' }}>
              <button type="button" class="px-3 py-2 text-lg disabled:text-gray-400" id="plus" {{ $stock<=0 ? 'disabled' : '' }}>+</button>
            </div>

            <button type="button" id="addToCartBtn" {{ $stock<=0 ? 'disabled' : '' }}
              class="flex-1 inline-flex items-center justify-center gap-2 rounded-2xl
                     {{ $stock>0 ? 'bg-emerald-600 hover:bg-emerald-700 text-white' : 'bg-gray-200 text-gray-500 cursor-not-allowed' }}
                     px-5 py-3 font-semibold"
              onclick="addToCart({{ $product->id }})">
              {{-- cart icon --}}
              <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.2 6h12.4L17 13M7 13H5.4m1.6 6a2 2 0 104 0m6 0a2 2 0 104 0"/>
              </svg>
              {{ $stock>0 ? 'Tambah ke Keranjang' : 'Stok Habis' }}
            </button>
          </div>
        </div>

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

  // Close modal when clicking outside
  document.getElementById('modal').addEventListener('click', function(e) {
    if (e.target === this) {
      closeModal();
    }
  });

  // Add to cart function
  async function addToCart(productId) {
    const quantityInput = document.getElementById('qty');
    const addToCartBtn = document.getElementById('addToCartBtn');
    const quantity = parseInt(quantityInput.value) || 1;

    // Disable button during request
    addToCartBtn.disabled = true;
    addToCartBtn.innerHTML = '<svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Menambahkan...';

    try {
      const response = await fetch('{{ route('cart.add') }}', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
          product_id: productId,
          quantity: quantity
        })
      });

      const data = await response.json();

      if (data.success) {
        showModal('Berhasil!', 'Produk berhasil ditambahkan ke keranjang', 'success');
      } else if (data.already_exists) {
        showModal('Produk Sudah Ada', 'Produk ini sudah ada di keranjang Anda', 'warning');
      } else {
        showModal('Gagal', data.message || 'Terjadi kesalahan saat menambahkan produk', 'error');
      }
    } catch (error) {
      console.error('Error:', error);
      showModal('Error', 'Terjadi kesalahan jaringan. Silakan coba lagi.', 'error');
    } finally {
      // Restore button
      addToCartBtn.disabled = false;
      addToCartBtn.innerHTML = `
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.2 6h12.4L17 13M7 13H5.4m1.6 6a2 2 0 104 0m6 0a2 2 0 104 0"/>
        </svg>
        Tambah ke Keranjang
      `;
    }
  }
</script>
</body>
</html>
