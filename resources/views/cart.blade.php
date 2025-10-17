{{-- resources/views/cart.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Keranjang • TokoKami</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800">

  {{-- Pakai navbar kamu (opsional) --}}
  @include('components.navbar')

  <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    {{-- Breadcrumb + Kosongkan --}}
    <div class="flex items-center justify-between mb-4">
      <nav class="text-sm text-gray-500">
        <a href="{{ route('home') }}" class="hover:text-emerald-600">Beranda</a>
        <span class="mx-2">/</span>
        <span class="text-gray-700 font-medium">Keranjang</span>
      </nav>
      <form method="POST" action="{{ route('cart.clear') }}">
        @csrf
        <button class="text-sm text-red-600 hover:text-red-700 font-medium" 
                onclick="return confirm('Apakah Anda yakin ingin mengosongkan keranjang?')">
          Kosongkan Keranjang
        </button>
      </form>
    </div>

    @php
      // Use real cart items from database
      $items = $cartItems ?? collect();

      // Calculate subtotal dynamically from product prices
      $subtotal = $items->sum(function($item) {
          return $item->product ? ($item->product->price * $item->quantity) : 0;
      });
      
      function rupiah_fmt($n){ return 'Rp '.number_format((int)$n,0,',','.'); }
      $shipping = $subtotal > 0 ? 12000 : 0;
      $discount = 0;
      $total = max($subtotal + $shipping - $discount, 0);
    @endphp

    {{-- State kosong --}}
    @if (empty($items))
      <section class="bg-white rounded-xl shadow p-10 text-center border border-gray-100">
        <div class="w-16 h-16 mx-auto rounded-full bg-gray-100 grid place-items-center">
          <svg class="w-8 h-8 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M5 8l2-3a2 2 0 011.7-1h6.6a2 2 0 011.7 1l2 3M6 8h12l-1 11a2 2 0 01-2 2H9a2 2 0 01-2-2L6 8z"/>
          </svg>
        </div>
        <h1 class="mt-4 text-2xl font-extrabold">Keranjang masih kosong</h1>
        <p class="mt-1 text-gray-600">Yuk pilih produk favoritmu dulu.</p>
        <a href="{{ route('home') }}"
           class="inline-flex items-center gap-2 mt-5 bg-emerald-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-emerald-700">
          Belanja Sekarang
        </a>
      </section>
    @else
      <section class="grid lg:grid-cols-3 gap-6">
        {{-- Daftar item --}}
        <div class="lg:col-span-2 space-y-4">
          @foreach ($items as $item)
            <div class="bg-white rounded-xl shadow p-4 sm:p-5 border border-gray-100 flex gap-4">
              <img src="{{ $item->product && $item->product->photos->count() > 0 ? asset('storage/' . $item->product->photos->first()->url) : asset('images/product-placeholder.png') }}"
                   class="w-24 h-24 rounded-lg object-cover"
                   alt="{{ $item->product->name ?? 'Produk' }}">
              <div class="flex-1">
                <div class="flex items-start justify-between gap-3">
                  <div>
                    <h3 class="font-semibold text-gray-900">{{ $item->product->name ?? 'Produk' }}</h3>
                    <p class="text-sm text-gray-500 mt-0.5" data-qty-display>Qty: {{ $item->quantity }}</p>
                  </div>
                  <div class="text-right">
                    <p class="font-semibold text-gray-900" data-product-price="{{ $item->product ? $item->product->price : 0 }}">{{ $item->product ? rupiah_fmt($item->product->price) : 'Rp 0' }}</p>
                    <p class="text-xs text-gray-400">/ item</p>
                    <p class="text-sm font-medium text-emerald-600 mt-1" data-item-total>Total: {{ $item->product ? rupiah_fmt($item->product->price * $item->quantity) : 'Rp 0' }}</p>
                  </div>
                </div>

                <div class="mt-3 flex items-center justify-between">
                  {{-- Qty control --}}
                  <div class="flex items-center gap-2">
                    <button onclick="decreaseQuantity({{ $item->id }})" 
                            class="w-8 h-8 rounded-md bg-gray-100 text-gray-700 grid place-items-center hover:bg-gray-200" 
                            id="decrease-{{ $item->id }}"
                            aria-label="Kurangi">−</button>
                    <input id="qty-{{ $item->id }}" value="{{ $item->quantity }}" 
                           class="w-12 text-center border rounded-md py-1" 
                           onchange="updateQuantity({{ $item->id }}, this.value)"
                           min="1" />
                    <button onclick="increaseQuantity({{ $item->id }})" 
                            class="w-8 h-8 rounded-md bg-gray-100 text-gray-700 grid place-items-center hover:bg-gray-200" 
                            id="increase-{{ $item->id }}"
                            aria-label="Tambah">+</button>
                  </div>

                  {{-- Remove item --}}
                  <form method="POST" action="{{ route('cart.remove', $item->id) }}" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button class="text-sm text-red-600 hover:text-red-700 font-medium" 
                            onclick="return confirm('Hapus item ini dari keranjang?')">Hapus</button>
                  </form>
                </div>
              </div>
            </div>
          @endforeach
        </div>

        {{-- Ringkasan --}}
        <aside class="bg-white rounded-xl shadow p-5 border border-gray-100 h-max">
          <h2 class="text-lg font-extrabold text-gray-900">Ringkasan Belanja</h2>
          <dl class="mt-4 space-y-2 text-sm">
            <div class="flex items-center justify-between">
              <dt class="text-gray-600">Subtotal</dt>
              <dd class="font-medium" data-subtotal>{{ rupiah_fmt($subtotal) }}</dd>
            </div>
            <div class="flex items-center justify-between">
              <dt class="text-gray-600">Ongkos Kirim</dt>
              <dd class="font-medium" data-shipping>{{ $shipping ? rupiah_fmt($shipping) : 'TBD' }}</dd>
            </div>
            @if($discount > 0)
            <div class="flex items-center justify-between">
              <dt class="text-gray-600">Diskon</dt>
              <dd class="font-medium text-emerald-700">-{{ rupiah_fmt($discount) }}</dd>
            </div>
            @endif
            <div class="pt-2 border-t flex items-center justify-between text-base">
              <dt class="font-bold text-gray-900">Total</dt>
              <dd class="font-extrabold text-gray-900" data-total>{{ rupiah_fmt($total) }}</dd>
            </div>
          </dl>

          <a href="{{ route('checkout.index') }}"
             class="mt-5 w-full inline-flex items-center justify-center bg-emerald-600 text-white px-5 py-3 rounded-lg font-semibold hover:bg-emerald-700">
            Lanjut ke Pembayaran
          </a>

          <p class="mt-3 text-xs text-gray-500">Harga dan ketersediaan bisa berubah sewaktu-waktu saat checkout.</p>
        </aside>
      </section>
    @endif
  </main>

  <script>
    // Add CSRF token to all AJAX requests
    document.querySelector('head').innerHTML += '<meta name="csrf-token" content="{{ csrf_token() }}">';

    // Helper functions for increase/decrease quantity
    function increaseQuantity(itemId) {
      const qtyInput = document.getElementById(`qty-${itemId}`);
      if (qtyInput) {
        const currentQty = parseInt(qtyInput.value) || 0;
        updateQuantity(itemId, currentQty + 1);
      }
    }

    function decreaseQuantity(itemId) {
      const qtyInput = document.getElementById(`qty-${itemId}`);
      if (qtyInput) {
        const currentQty = parseInt(qtyInput.value) || 0;
        updateQuantity(itemId, currentQty - 1);
      }
    }

    async function updateQuantity(itemId, newQuantity) {
      // Convert to integer and validate
      newQuantity = parseInt(newQuantity) || 0;
      
      if (newQuantity < 1) {
        if (confirm('Hapus item ini dari keranjang?')) {
          // Call remove function
          removeCartItem(itemId);
          return;
        } else {
          // Reset input value to original quantity
          const qtyInput = document.getElementById(`qty-${itemId}`);
          if (qtyInput) {
            qtyInput.value = qtyInput.getAttribute('data-original-qty') || 1;
          }
          return;
        }
      }

      // Check if quantity exceeds reasonable limit (let backend handle stock validation)
      if (newQuantity > 999) {
        alert('Quantity tidak boleh lebih dari 999');
        const qtyInput = document.getElementById(`qty-${itemId}`);
        if (qtyInput) {
          qtyInput.value = qtyInput.getAttribute('data-original-qty') || 1;
        }
        return;
      }

      try {
        // Show loading state
        const qtyInput = document.getElementById(`qty-${itemId}`);
        const itemCard = qtyInput?.closest('.bg-white');
        if (itemCard) {
          itemCard.style.opacity = '0.6';
          itemCard.style.pointerEvents = 'none';
        }

        const response = await fetch(`/cart/update/${itemId}`, {
          method: 'PATCH',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
          },
          body: JSON.stringify({
            quantity: newQuantity
          })
        });

        const data = await response.json();
        
        if (data.success) {
          // Update DOM without refresh
          updateCartItemDOM(itemId, newQuantity);
          updateCartSummary();
          
          // Show success feedback
          showNotification('Keranjang berhasil diperbarui!', 'success');
        } else {
          alert('Error: ' + data.message);
          // Reset quantity input to original value
          if (qtyInput) {
            qtyInput.value = qtyInput.getAttribute('data-original-qty') || 1;
          }
        }
      } catch (error) {
        console.error('Error updating cart:', error);
        alert('Error updating cart. Please try again.');
        // Reset quantity input to original value
        const qtyInput = document.getElementById(`qty-${itemId}`);
        if (qtyInput) {
          qtyInput.value = qtyInput.getAttribute('data-original-qty') || 1;
        }
      } finally {
        // Remove loading state
        const qtyInput = document.getElementById(`qty-${itemId}`);
        const itemCard = qtyInput?.closest('.bg-white');
        if (itemCard) {
          itemCard.style.opacity = '1';
          itemCard.style.pointerEvents = 'auto';
        }
      }
    }

    // Function to update cart item DOM
    function updateCartItemDOM(itemId, newQuantity) {
      const qtyInput = document.getElementById(`qty-${itemId}`);
      const itemCard = qtyInput?.closest('.bg-white');
      
      if (!itemCard) return;
      
      // Update quantity input
      qtyInput.value = newQuantity;
      qtyInput.setAttribute('data-original-qty', newQuantity);
      
      // Update decrease button state
      const decreaseBtn = document.getElementById(`decrease-${itemId}`);
      if (decreaseBtn) {
        if (newQuantity <= 1) {
          decreaseBtn.disabled = false; // Allow decrease to trigger delete confirmation
          decreaseBtn.classList.add('opacity-50');
        } else {
          decreaseBtn.disabled = false;
          decreaseBtn.classList.remove('opacity-50');
        }
      }
      
      // Get product price from data attribute or parse from DOM
      const priceElement = itemCard.querySelector('[data-product-price]');
      const productPrice = priceElement ? parseInt(priceElement.getAttribute('data-product-price')) : 0;
      
      // Update item total price display
      const totalPriceElement = itemCard.querySelector('[data-item-total]');
      if (totalPriceElement && productPrice > 0) {
        const newTotal = productPrice * newQuantity;
        totalPriceElement.textContent = `Total: ${formatRupiah(newTotal)}`;
      }
      
      // Update quantity display
      const qtyDisplay = itemCard.querySelector('[data-qty-display]');
      if (qtyDisplay) {
        qtyDisplay.textContent = `Qty: ${newQuantity}`;
      }
    }

    // Function to remove cart item
    async function removeCartItem(itemId) {
      try {
        const response = await fetch(`/cart/remove/${itemId}`, {
          method: 'DELETE',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
          }
        });

        const data = await response.json();
        
        if (data.success) {
          // Remove item from DOM with animation
          const qtyInput = document.getElementById(`qty-${itemId}`);
          const itemCard = qtyInput?.closest('.bg-white');
          
          if (itemCard) {
            itemCard.style.transform = 'translateX(-100%)';
            itemCard.style.opacity = '0';
            itemCard.style.transition = 'all 0.3s ease';
            
            setTimeout(() => {
              itemCard.remove();
              updateCartSummary();
              checkEmptyCart();
            }, 300);
          }
          
          showNotification('Item berhasil dihapus dari keranjang!', 'success');
        } else {
          alert('Error: ' + data.message);
        }
      } catch (error) {
        console.error('Error removing item:', error);
        alert('Error removing item. Please try again.');
      }
    }

    // Function to update cart summary (subtotal, total, etc.)
    function updateCartSummary() {
      let subtotal = 0;
      
      // Calculate new subtotal from all items
      document.querySelectorAll('[data-product-price]').forEach(priceElement => {
        const itemCard = priceElement.closest('.bg-white');
        const qtyInput = itemCard?.querySelector('input[id^="qty-"]');
        const productPrice = parseInt(priceElement.getAttribute('data-product-price')) || 0;
        const quantity = parseInt(qtyInput?.value) || 0;
        
        subtotal += productPrice * quantity;
      });
      
      // Update subtotal display
      const subtotalElement = document.querySelector('[data-subtotal]');
      if (subtotalElement) {
        subtotalElement.textContent = formatRupiah(subtotal);
      }
      
      // Calculate shipping and total
      const shipping = subtotal > 0 ? 12000 : 0;
      const discount = 0;
      const total = Math.max(subtotal + shipping - discount, 0);
      
      // Update shipping display
      const shippingElement = document.querySelector('[data-shipping]');
      if (shippingElement) {
        shippingElement.textContent = shipping > 0 ? formatRupiah(shipping) : 'TBD';
      }
      
      // Update total display
      const totalElement = document.querySelector('[data-total]');
      if (totalElement) {
        totalElement.textContent = formatRupiah(total);
      }
    }

    // Function to check if cart is empty and show empty state
    function checkEmptyCart() {
      const remainingItems = document.querySelectorAll('[data-product-price]').length;
      
      if (remainingItems === 0) {
        // Show empty cart state
        const cartSection = document.querySelector('.lg\\:col-span-2');
        if (cartSection) {
          cartSection.innerHTML = `
            <div class="bg-white rounded-xl shadow p-10 text-center border border-gray-100">
              <div class="w-16 h-16 mx-auto rounded-full bg-gray-100 grid place-items-center">
                <svg class="w-8 h-8 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5 8l2-3a2 2 0 011.7-1h6.6a2 2 0 011.7 1l2 3M6 8h12l-1 11a2 2 0 01-2 2H9a2 2 0 01-2-2L6 8z"/>
                </svg>
              </div>
              <h1 class="mt-4 text-2xl font-extrabold">Keranjang masih kosong</h1>
              <p class="mt-1 text-gray-600">Yuk pilih produk favoritmu dulu.</p>
              <a href="{{ route('home') }}"
                 class="inline-flex items-center gap-2 mt-5 bg-emerald-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-emerald-700">
                Belanja Sekarang
              </a>
            </div>
          `;
        }
      }
    }

    // Function to format number as Rupiah
    function formatRupiah(number) {
      return 'Rp ' + number.toLocaleString('id-ID');
    }

    // Function to show notification
    function showNotification(message, type = 'info') {
      // Create notification element
      const notification = document.createElement('div');
      notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg text-white transform translate-x-full transition-transform duration-300 ${
        type === 'success' ? 'bg-green-500' : type === 'error' ? 'bg-red-500' : 'bg-blue-500'
      }`;
      notification.textContent = message;
      
      document.body.appendChild(notification);
      
      // Show notification
      setTimeout(() => {
        notification.style.transform = 'translateX(0)';
      }, 100);
      
      // Hide notification after 3 seconds
      setTimeout(() => {
        notification.style.transform = 'translateX(full)';
        setTimeout(() => {
          if (notification.parentNode) {
            notification.parentNode.removeChild(notification);
          }
        }, 300);
      }, 3000);
    }

    // Initialize cart on page load
    document.addEventListener('DOMContentLoaded', function() {
      // Store original quantities in data attributes and initialize button states
      document.querySelectorAll('input[id^="qty-"]').forEach(input => {
        input.setAttribute('data-original-qty', input.value);
        
        // Initialize decrease button state 
        const itemId = input.id.replace('qty-', '');
        const currentQty = parseInt(input.value) || 1;
        const decreaseBtn = document.getElementById(`decrease-${itemId}`);
        
        if (decreaseBtn && currentQty <= 1) {
          decreaseBtn.classList.add('opacity-50');
        }
      });
    });
  </script>
</body>
</html>
