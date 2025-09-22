@extends('layouts.app')

@section('title', 'Keranjang Belanja')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Keranjang Belanja</h1>
                <a href="{{ route('products.catalog') }}" class="btn btn-outline-primary">
                    <i class="fas fa-arrow-left"></i> Lanjut Belanja
                </a>
            </div>

            @if($cartItems->count() > 0)
                <div class="row">
                    <div class="col-lg-8">
                        <!-- Cart Items -->
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-md-6 d-flex align-items-center">
                                        <div class="form-check me-3">
                                            <input class="form-check-input" type="checkbox" id="select-all">
                                            <label class="form-check-label" for="select-all">
                                                Pilih Semua
                                            </label>
                                        </div>
                                        <h5 class="mb-0">Produk ({{ $cartItems->count() }} item)</h5>
                                    </div>
                                    <div class="col-md-6 text-end">
                                        <button type="button" class="btn btn-outline-danger btn-sm" id="clear-cart-btn">
                                            <i class="fas fa-trash"></i> Kosongkan Keranjang
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                @foreach($cartItems as $item)
                                    <div class="cart-item border-bottom p-3" data-item-id="{{ $item->id }}">
                                        <div class="row align-items-center">
                                            <div class="col-md-1">
                                                <div class="form-check">
                                                    <input class="form-check-input item-checkbox"
                                                           type="checkbox"
                                                           value="{{ $item->id }}"
                                                           id="item-{{ $item->id }}">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                @if($item->product->image)
                                                    <img src="{{ asset('storage/' . $item->product->image) }}"
                                                         class="img-fluid rounded"
                                                         alt="{{ $item->product->name }}"
                                                         style="width: 80px; height: 80px; object-fit: cover;">
                                                @else
                                                    <div class="bg-light d-flex align-items-center justify-content-center rounded"
                                                         style="width: 80px; height: 80px;">
                                                        <i class="fas fa-image text-muted"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-md-3">
                                                <h6 class="mb-1">{{ $item->product->name }}</h6>
                                                <small class="text-muted">{{ $item->product->category->name }}</small>
                                                <br>
                                                <span class="text-primary fw-bold">Rp {{ number_format($item->product->price, 0, ',', '.') }}</span>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="input-group input-group-sm">
                                                    <button class="btn btn-outline-secondary decrease-qty"
                                                            type="button"
                                                            data-item-id="{{ $item->id }}">-</button>
                                                    <input type="number"
                                                           class="form-control text-center quantity-input"
                                                           value="{{ $item->quantity }}"
                                                           min="1"
                                                           max="{{ $item->product->stock }}"
                                                           data-item-id="{{ $item->id }}">
                                                    <button class="btn btn-outline-secondary increase-qty"
                                                            type="button"
                                                            data-item-id="{{ $item->id }}"
                                                            {{ $item->quantity >= $item->product->stock ? 'disabled' : '' }}>+</button>
                                                </div>
                                                <small class="text-muted">Stok: {{ $item->product->stock }}</small>
                                            </div>
                                            <div class="col-md-2 text-center">
                                                <span class="fw-bold item-total" data-price="{{ $item->product->price }}" data-quantity="{{ $item->quantity }}">Rp {{ number_format($item->total_price, 0, ',', '.') }}</span>
                                            </div>
                                            <div class="col-md-1 text-center">
                                                <button type="button"
                                                        class="btn btn-outline-danger btn-sm remove-item-btn"
                                                        data-item-id="{{ $item->id }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <!-- Cart Summary -->
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Ringkasan Belanja</h5>
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Total Item Dipilih:</span>
                                    <span id="selected-quantity">0</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Total Item:</span>
                                    <span id="total-quantity">{{ $cart->total_quantity }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-3">
                                    <span>Subtotal Dipilih:</span>
                                    <span id="selected-subtotal">Rp 0</span>
                                </div>
                                <div class="d-flex justify-content-between mb-3">
                                    <span>Subtotal Total:</span>
                                    <span id="subtotal">Rp {{ number_format($cart->total, 0, ',', '.') }}</span>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between mb-3">
                                    <strong>Total yang Dipilih:</strong>
                                    <strong id="selected-total" class="text-primary">Rp 0</strong>
                                </div>

                                <form action="{{ route('checkout.from-cart') }}" method="POST" id="checkout-form">
                                    @csrf
                                    <div id="selected-items-input"></div>
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-success btn-lg" id="checkout-btn" disabled>
                                            <i class="fas fa-credit-card"></i> Checkout (<span id="checkout-count">0</span> item)
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <!-- Empty Cart -->
                <div class="text-center py-5">
                    <i class="fas fa-shopping-cart fa-5x text-muted mb-4"></i>
                    <h3 class="text-muted mb-3">Keranjang belanja kosong</h3>
                    <p class="text-muted mb-4">Anda belum menambahkan produk apapun ke keranjang belanja.</p>
                    <a href="{{ route('products.catalog') }}" class="btn btn-primary">
                        <i class="fas fa-shopping-bag"></i> Mulai Belanja
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

@if($cartItems->count() > 0)
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {

    // Checkbox selection functionality
    const selectAllCheckbox = document.getElementById('select-all');
    const itemCheckboxes = document.querySelectorAll('.item-checkbox');
    const checkoutBtn = document.getElementById('checkout-btn');
    const selectedItemsInput = document.getElementById('selected-items-input');

    function updateSelectedTotals() {
        const checkedBoxes = document.querySelectorAll('.item-checkbox:checked');
        let selectedQuantity = 0;
        let selectedTotal = 0;

        checkedBoxes.forEach(checkbox => {
            const itemId = checkbox.value;
            const cartItem = document.querySelector(`[data-item-id="${itemId}"]`);
            const itemTotal = cartItem.querySelector('.item-total');
            const quantity = parseInt(cartItem.querySelector('.quantity-input').value);
            const price = parseInt(itemTotal.dataset.price);

            selectedQuantity += quantity;
            selectedTotal += (price * quantity);
        });

        // Update display
        document.getElementById('selected-quantity').textContent = selectedQuantity;
        document.getElementById('selected-subtotal').textContent = `Rp ${selectedTotal.toLocaleString('id-ID')}`;
        document.getElementById('selected-total').textContent = `Rp ${selectedTotal.toLocaleString('id-ID')}`;
        document.getElementById('checkout-count').textContent = checkedBoxes.length;

        // Update checkout button state
        if (checkedBoxes.length > 0) {
            checkoutBtn.disabled = false;
            checkoutBtn.classList.remove('btn-secondary');
            checkoutBtn.classList.add('btn-success');
        } else {
            checkoutBtn.disabled = true;
            checkoutBtn.classList.remove('btn-success');
            checkoutBtn.classList.add('btn-secondary');
        }

        // Update hidden inputs for form
        selectedItemsInput.innerHTML = '';
        checkedBoxes.forEach(checkbox => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'selected_items[]';
            input.value = checkbox.value;
            selectedItemsInput.appendChild(input);
        });
    }

    // Select all functionality
    selectAllCheckbox.addEventListener('change', function() {
        itemCheckboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        updateSelectedTotals();
    });

    // Individual checkbox functionality
    itemCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const checkedCount = document.querySelectorAll('.item-checkbox:checked').length;
            const totalCount = itemCheckboxes.length;

            // Update select all checkbox state
            selectAllCheckbox.checked = (checkedCount === totalCount);
            selectAllCheckbox.indeterminate = (checkedCount > 0 && checkedCount < totalCount);

            updateSelectedTotals();
        });
    });

    // Initialize
    updateSelectedTotals();

    // Update quantity functions
    function updateQuantity(itemId, newQuantity) {
        fetch(`/cart/update/${itemId}`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ quantity: newQuantity })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update item total
                const cartItem = document.querySelector(`[data-item-id="${itemId}"]`);
                const itemTotal = cartItem.querySelector('.item-total');
                itemTotal.textContent = `Rp ${data.itemTotal.toLocaleString('id-ID')}`;
                itemTotal.dataset.quantity = newQuantity;

                // Update cart summary
                document.getElementById('total-quantity').textContent = data.cartTotalQuantity;
                document.getElementById('subtotal').textContent = `Rp ${data.cartTotal.toLocaleString('id-ID')}`;

                // Update increase button state
                const increaseBtn = cartItem.querySelector('.increase-qty');
                const maxStock = parseInt(cartItem.querySelector('.quantity-input').getAttribute('max'));
                increaseBtn.disabled = newQuantity >= maxStock;

                // Update selected totals if this item is selected
                updateSelectedTotals();
            } else {
                alert(data.message || 'Gagal mengupdate quantity');
                // Reset quantity input
                const quantityInput = document.querySelector(`[data-item-id="${itemId}"] .quantity-input`);
                quantityInput.value = quantityInput.dataset.originalValue;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan. Silakan coba lagi.');
        });
    }

    // Decrease quantity buttons
    document.querySelectorAll('.decrease-qty').forEach(button => {
        button.addEventListener('click', function() {
            const itemId = this.dataset.itemId;
            const quantityInput = document.querySelector(`[data-item-id="${itemId}"] .quantity-input`);
            const currentQuantity = parseInt(quantityInput.value);

            if (currentQuantity > 1) {
                const newQuantity = currentQuantity - 1;
                quantityInput.value = newQuantity;
                updateQuantity(itemId, newQuantity);
            }
        });
    });

    // Increase quantity buttons
    document.querySelectorAll('.increase-qty').forEach(button => {
        button.addEventListener('click', function() {
            const itemId = this.dataset.itemId;
            const quantityInput = document.querySelector(`[data-item-id="${itemId}"] .quantity-input`);
            const currentQuantity = parseInt(quantityInput.value);
            const maxStock = parseInt(quantityInput.getAttribute('max'));

            if (currentQuantity < maxStock) {
                const newQuantity = currentQuantity + 1;
                quantityInput.value = newQuantity;
                updateQuantity(itemId, newQuantity);
            }
        });
    });

    // Direct quantity input change
    document.querySelectorAll('.quantity-input').forEach(input => {
        input.dataset.originalValue = input.value;

        input.addEventListener('change', function() {
            const itemId = this.dataset.itemId;
            const newQuantity = parseInt(this.value);
            const maxStock = parseInt(this.getAttribute('max'));

            if (newQuantity < 1) {
                this.value = 1;
                updateQuantity(itemId, 1);
            } else if (newQuantity > maxStock) {
                this.value = maxStock;
                updateQuantity(itemId, maxStock);
            } else {
                updateQuantity(itemId, newQuantity);
            }

            this.dataset.originalValue = this.value;
        });
    });

    // Remove item buttons
    document.querySelectorAll('.remove-item-btn').forEach(button => {
        button.addEventListener('click', function() {
            if (confirm('Apakah Anda yakin ingin menghapus item ini dari keranjang?')) {
                const itemId = this.dataset.itemId;

                fetch(`/cart/remove/${itemId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Remove item from DOM
                        document.querySelector(`[data-item-id="${itemId}"]`).remove();

                        // Check if cart is empty
                        if (data.cartEmpty) {
                            location.reload();
                        } else {
                            // Update cart summary
                            document.getElementById('total-quantity').textContent = data.cartTotalQuantity;
                            document.getElementById('subtotal').textContent = `Rp ${data.cartTotal.toLocaleString('id-ID')}`;
                            document.getElementById('total').textContent = `Rp ${data.cartTotal.toLocaleString('id-ID')}`;
                        }
                    } else {
                        alert(data.message || 'Gagal menghapus item');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan. Silakan coba lagi.');
                });
            }
        });
    });

    // Clear cart button
    document.getElementById('clear-cart-btn').addEventListener('click', function() {
        if (confirm('Apakah Anda yakin ingin mengosongkan seluruh keranjang belanja?')) {
            fetch('/cart/clear', {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert(data.message || 'Gagal mengosongkan keranjang');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan. Silakan coba lagi.');
            });
        }
    });
});
</script>
@endpush
@endif
@endsection
