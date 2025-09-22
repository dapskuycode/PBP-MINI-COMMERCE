<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Checkout - Mini Commerce</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --accent-color: #f1574b;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }

        .checkout-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            margin: 2rem 0;
        }

        .checkout-header {
            background: var(--primary-gradient);
            color: white;
            padding: 1.5rem;
            border-radius: 15px 15px 0 0;
        }

        .order-summary {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .order-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 0;
            border-bottom: 1px solid #e9ecef;
        }

        .order-item:last-child {
            border-bottom: none;
        }

        .product-image {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
        }

        .total-section {
            background: var(--secondary-gradient);
            color: white;
            padding: 1.5rem;
            border-radius: 10px;
            margin: 1.5rem 0;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 0.5rem;
        }

        .form-control {
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }

        .btn-checkout {
            background: var(--primary-gradient);
            border: none;
            color: white;
            padding: 1rem 2rem;
            border-radius: 10px;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            width: 100%;
        }

        .btn-checkout:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
            color: white;
        }

        .btn-back {
            background: #6c757d;
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 10px;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .btn-back:hover {
            background: #5a6268;
            color: white;
            text-decoration: none;
        }

        .payment-option {
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            padding: 1rem;
            margin-bottom: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .payment-option:hover {
            border-color: #667eea;
        }

        .payment-option.selected {
            border-color: #667eea;
            background: rgba(102, 126, 234, 0.1);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="checkout-container">
            <div class="checkout-header">
                <div class="d-flex align-items-center">
                    <i class="fas fa-shopping-cart me-3 fs-4"></i>
                    <h2 class="mb-0">Checkout</h2>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8">
                    <div class="p-4">
                        <h4 class="mb-4">Informasi Pengiriman</h4>

                        <form action="{{ route('checkout.process') }}" method="POST">
                            @csrf

                            @if(isset($cartItems))
                                @foreach($cartItems as $item)
                                    <input type="hidden" name="selected_items[]" value="{{ $item->id }}">
                                @endforeach
                            @elseif(isset($product))
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="quantity" value="{{ $items->first()->quantity }}">
                            @endif

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Nama Lengkap</label>
                                        <input type="text" class="form-control" name="name" value="{{ Auth::user()->name }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control" name="email" value="{{ Auth::user()->email }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Nomor Telepon</label>
                                        <input type="tel" class="form-control" name="phone" required>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Alamat Lengkap</label>
                                <textarea class="form-control" name="address" rows="3" required placeholder="Masukkan alamat lengkap untuk pengiriman"></textarea>
                            </div>

                            <h4 class="mb-3">Metode Pembayaran</h4>
                            <div class="payment-methods">
                                <div class="payment-option" data-payment="bank_transfer">
                                    <input type="radio" name="payment_method" value="bank_transfer" id="bank_transfer" required>
                                    <label for="bank_transfer" class="ms-2">
                                        <i class="fas fa-university me-2"></i>Transfer Bank
                                    </label>
                                </div>
                                <div class="payment-option" data-payment="e_wallet">
                                    <input type="radio" name="payment_method" value="e_wallet" id="e_wallet" required>
                                    <label for="e_wallet" class="ms-2">
                                        <i class="fas fa-mobile-alt me-2"></i>E-Wallet (GoPay, OVO, Dana)
                                    </label>
                                </div>
                                <div class="payment-option" data-payment="cod">
                                    <input type="radio" name="payment_method" value="cod" id="cod" required>
                                    <label for="cod" class="ms-2">
                                        <i class="fas fa-money-bill-wave me-2"></i>Bayar di Tempat (COD)
                                    </label>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <a href="{{ url()->previous() }}" class="btn-back">
                                    <i class="fas fa-arrow-left me-2"></i>Kembali
                                </a>
                                <button type="submit" class="btn-checkout">
                                    <i class="fas fa-check me-2"></i>Konfirmasi Pesanan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="p-4">
                        <div class="order-summary">
                            <h5 class="mb-3">Ringkasan Pesanan</h5>

                            @foreach($items as $item)
                                <div class="order-item">
                                    <div class="d-flex align-items-center">
                                        @if($item->product->image)
                                            <img src="{{ asset('storage/' . $item->product->image) }}" class="product-image me-3" alt="{{ $item->product->name }}">
                                        @else
                                            <div class="product-image me-3 bg-light d-flex align-items-center justify-content-center">
                                                <i class="fas fa-image text-muted"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <h6 class="mb-1">{{ $item->product->name }}</h6>
                                            <small class="text-muted">{{ $item->quantity }}x</small>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <strong>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</strong>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="total-section">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Subtotal:</span>
                                <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Ongkos Kirim:</span>
                                <span>Gratis</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between">
                                <strong>Total:</strong>
                                <strong class="fs-5">Rp {{ number_format($total, 0, ',', '.') }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Payment method selection
        document.querySelectorAll('.payment-option').forEach(option => {
            option.addEventListener('click', function() {
                // Remove selected class from all options
                document.querySelectorAll('.payment-option').forEach(opt => {
                    opt.classList.remove('selected');
                });

                // Add selected class to clicked option
                this.classList.add('selected');

                // Check the radio button
                const radio = this.querySelector('input[type="radio"]');
                radio.checked = true;
            });
        });

        // Form validation
        document.querySelector('form').addEventListener('submit', function(e) {
            const requiredFields = this.querySelectorAll('[required]');
            let isValid = true;

            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    field.classList.add('is-invalid');
                } else {
                    field.classList.remove('is-invalid');
                }
            });

            if (!isValid) {
                e.preventDefault();
                alert('Mohon lengkapi semua field yang wajib diisi.');
            }
        });
    </script>
</body>
</html>
