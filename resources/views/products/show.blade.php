<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ $product->name ?? 'Produk' }} — UMKM Mini-Commerce</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-emerald-50 via-white to-rose-50 text-gray-900 antialiased">

@include('components.navbar')

<header class="mx-auto max-w-7xl px-4 md:px-6 pt-6">
  <nav class="text-sm text-gray-500">
    <a href="{{ route('products.index') }}" class="hover:text-emerald-600">Produk</a>
    <span class="mx-2">/</span>
    <span class="text-gray-700 font-medium line-clamp-1">{{ $product->name }}</span>
  </nav>
</header>

<main class="mx-auto max-w-7xl px-4 md:px-6 py-6">
  <div class="grid lg:grid-cols-2 gap-8">
    {{-- Gambar / gallery --}}
    <section class="rounded-3xl bg-white border border-gray-100 shadow overflow-hidden">
      @if(!empty($product->image))
        <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}" class="w-full h-[420px] object-cover">
      @else
        <div class="w-full h-[420px] flex items-center justify-center bg-gradient-to-br from-amber-100 via-rose-100 to-emerald-100">
          <div class="text-7xl">🧸</div>
        </div>
      @endif
    </section>

    {{-- Info --}}
    <section>
      <div class="rounded-3xl bg-white border border-gray-100 shadow p-6 md:p-8">
        <div class="flex items-start justify-between gap-3">
          <div>
            <h1 class="text-2xl md:text-3xl font-extrabold">{{ $product->name }}</h1>
            <div class="mt-1 text-sm text-amber-600">
              @php $rating = $product->rating ?? 0; @endphp
              @if($rating)
                {{ str_repeat('★', (int)$rating) }}{{ str_repeat('☆', 5-(int)$rating) }}
                <span class="text-gray-500">({{ number_format($rating,1) }})</span>
              @else
                Baru! ✨
              @endif
            </div>
          </div>
          <button id="fav" class="h-11 w-11 rounded-full border border-gray-200 hover:bg-rose-50 flex items-center justify-center text-xl">🤍</button>
        </div>

        <div class="mt-4 p-4 rounded-2xl bg-emerald-50 border border-emerald-100">
          <div class="text-sm text-emerald-700">Harga</div>
          <div class="text-3xl font-black text-emerald-700">
            Rp {{ number_format($product->price ?? 0, 0, ',', '.') }}
          </div>
        </div>

        <p class="mt-5 text-gray-600 leading-relaxed">
          {{ $product->description ?? 'Deskripsi belum tersedia. Produk ini cocok untuk kamu yang suka barang lucu & berguna setiap hari.' }}
        </p>

        <form action="{{ route('cart.add') }}" method="POST" class="mt-6">
          @csrf
          <input type="hidden" name="product_id" value="{{ $product->id }}">

          <div class="flex items-center gap-4">
            <div class="flex items-center rounded-2xl border border-gray-200 overflow-hidden">
              <button type="button" class="px-3 py-2 text-lg" id="minus">−</button>
              <input type="number" name="quantity" id="qty" value="1" min="1"
                     class="w-16 text-center focus:outline-none">
              <button type="button" class="px-3 py-2 text-lg" id="plus">+</button>
            </div>

            <button class="flex-1 rounded-2xl bg-emerald-600 text-white px-5 py-3 font-semibold hover:bg-emerald-700">
              Tambah ke Keranjang 🛒
            </button>
          </div>
        </form>

        <div class="mt-6 grid sm:grid-cols-3 gap-4 text-sm">
          <div class="rounded-2xl border border-gray-200 p-3 bg-gray-50"><span class="font-semibold">Garansi</span><br> 7 hari retur</div>
          <div class="rounded-2xl border border-gray-200 p-3 bg-gray-50"><span class="font-semibold">Pengiriman</span><br> JNE / J&amp;T / Sicepat</div>
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
              @if(!empty($p->image))
                <img src="{{ asset('storage/'.$p->image) }}" alt="{{ $p->name }}" class="w-full h-40 object-cover">
              @else
                <div class="w-full h-40 flex items-center justify-center bg-gradient-to-br from-emerald-100 via-rose-100 to-amber-100">
                  <div class="text-4xl">🛒</div>
                </div>
              @endif
              <div class="p-3">
                <div class="font-medium line-clamp-1">{{ $p->name }}</div>
                <div class="text-emerald-700 font-bold">Rp {{ number_format($p->price ?? 0, 0, ',', '.') }}</div>
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
  const qty = document.getElementById('qty');
  document.getElementById('minus').onclick = () => qty.value = Math.max(1, (+qty.value||1)-1);
  document.getElementById('plus').onclick  = () => qty.value = (+qty.value||1)+1;

  // fav toggle
  const fav = document.getElementById('fav');
  fav.addEventListener('click', () => {
    fav.classList.toggle('bg-rose-500'); fav.classList.toggle('text-white');
    fav.textContent = fav.classList.contains('bg-rose-500') ? '💖' : '🤍';
  });
</script>
</body>
</html>
