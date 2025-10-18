<!-- Product Card Component -->
@props(['product' => null, 'title' => 'Sample Product', 'price' => 'Rp 25.000', 'originalPrice' => null, 'rating' => 4.5, 'sold' => 100, 'image' => null, 'discount' => null])

@php
    // Use product data if available, otherwise use props
    $displayTitle = $product ? $product->name : $title;
    $displayPrice = $product ? $product->formatted_price : $price;
    $displayRating = $product ? ($product->reviews->avg('rating') ?: 4.5) : $rating;
    $displaySold = $product && $product->relationLoaded('orderItems') ? $product->orderItems->sum('quantity') : ($sold ?: 0);
    $productId = $product ? $product->id : null;
    $categoryName = $product && $product->category ? $product->category->name : 'Produk';
    $stockAvailable = $product ? $product->stock > 0 : true;
    $productDiscount = $product ? $product->discount : $discount;
@endphp

<div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 overflow-hidden group">
    <!-- Product Image -->
    <div class="relative overflow-hidden">
        @if($productId)
            <a href="{{ route('products.show', $productId) }}" class="block">
        @endif
        
        @if($product && $product->photos && $product->photos->count() > 0)
            <img src="{{ asset('storage/' . $product->photos->first()->url) }}" alt="{{ $displayTitle }}" class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300">
        @elseif($image)
            <img src="{{ $image }}" alt="{{ $displayTitle }}" class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300">
        @else
            <div class="w-full h-48 bg-gradient-to-br from-emerald-100 to-emerald-200 flex items-center justify-center">
                <div class="text-center">
                    <svg class="w-16 h-16 text-emerald-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    <span class="text-xs text-emerald-600 font-medium">{{ $categoryName }}</span>
                </div>
            </div>
        @endif
        
        @if($productId)
            </a>
        @endif
        
        <!-- Discount Badge -->
        @if($productDiscount && $productDiscount > 0)
            <div class="absolute top-2 left-2 bg-red-500 text-white px-2 py-1 rounded-md text-xs font-semibold">
                -{{ $productDiscount }}%
            </div>
        @endif

        <!-- Stock Badge -->
        @if(!$stockAvailable)
            <div class="absolute top-2 left-2 bg-gray-500 text-white px-2 py-1 rounded-md text-xs font-semibold">
                Stok Habis
            </div>
        @endif
        
        <!-- Favorite Button -->
        @if($productId && Auth::check() && !Auth::user()->is_admin)
        <button onclick="toggleFavorite({{ $productId }}, event)" 
                id="fav-btn-{{ $productId }}" 
                class="absolute top-2 right-2 p-2 bg-white rounded-full shadow-md opacity-0 group-hover:opacity-100 transition-opacity duration-300 hover:bg-red-50">
            <svg id="fav-outline-{{ $productId }}" class="w-4 h-4 text-gray-400 hover:text-red-500 {{ $product && $product->isFavoritedBy(Auth::user()) ? 'hidden' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
            </svg>
            <svg id="fav-solid-{{ $productId }}" class="w-4 h-4 text-red-500 {{ $product && $product->isFavoritedBy(Auth::user()) ? '' : 'hidden' }}" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12.001 4.529c2.349-2.532 6.15-2.532 8.5 0 2.35 2.531 2.35 6.635 0 9.166l-7.07 7.622a2 2 0 0 1-2.86 0l-7.07-7.622c-2.35-2.531-2.35-6.635 0-9.166 2.35-2.532 6.151-2.532 8.5 0z"/>
            </svg>
        </button>
        @endif
    </div>
    
    <!-- Product Info -->
    <div class="p-4">
        <!-- Product Title -->
        <h3 class="font-semibold text-gray-800 text-sm mb-2 line-clamp-2 hover:text-emerald-600 transition-colors">
            @if($productId)
                <a href="{{ route('products.show', $productId) }}" class="hover:text-emerald-600">
                    {{ $displayTitle }}
                </a>
            @else
                {{ $displayTitle }}
            @endif
        </h3>
        
        <!-- Rating and Sold -->
        <div class="flex items-center justify-between mb-3">
            <div class="flex items-center space-x-1">
                <div class="flex items-center">
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= floor($displayRating))
                            <svg class="w-3 h-3 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        @else
                            <svg class="w-3 h-3 text-gray-300 fill-current" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        @endif
                    @endfor
                </div>
                <span class="text-xs text-gray-500">({{ number_format($displayRating, 1) }})</span>
            </div>
            <span class="text-xs text-gray-500">{{ $displaySold }} terjual</span>
        </div>
        
        <!-- Price -->
        <div class="flex items-center justify-between mb-3">
            <div class="flex items-center space-x-2">
                <span class="text-lg font-bold text-emerald-600">{{ $displayPrice }}</span>
                @if($originalPrice)
                    <span class="text-sm text-gray-400 line-through">{{ $originalPrice }}</span>
                @endif
            </div>
        </div>

        <!-- Stock Info -->
        @if($product)
            <div class="text-xs text-gray-500 mb-3">
                Stok: {{ $product->stock }}
            </div>
        @endif
        
        <!-- Add to Cart Button -->
        @if($productId && $stockAvailable)
            <button 
                onclick="addToCart({{ $productId }})" 
                class="add-to-cart-btn w-full bg-emerald-500 text-white py-2 px-4 rounded-lg hover:bg-emerald-600 transition-colors duration-300 flex items-center justify-center space-x-2 group"
                data-product-id="{{ $productId }}"
            >
                <svg class="w-4 h-4 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6m8 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4.01"></path>
                </svg>
                <span class="text-sm font-medium">Tambah ke Keranjang</span>
            </button>
        @elseif(!$stockAvailable)
            <button disabled class="w-full bg-gray-400 text-white py-2 px-4 rounded-lg cursor-not-allowed flex items-center justify-center space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
                <span class="text-sm font-medium">Stok Habis</span>
            </button>
        @else
            <button disabled class="w-full bg-gray-400 text-white py-2 px-4 rounded-lg cursor-not-allowed flex items-center justify-center space-x-2">
                <span class="text-sm font-medium">Produk Tidak Tersedia</span>
            </button>
        @endif
    </div>
</div>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>