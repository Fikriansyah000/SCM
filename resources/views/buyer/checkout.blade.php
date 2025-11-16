@extends('layouts.app')

@section('title', 'Checkout - PestiMart')

@section('content')
<style>
    .checkout-container {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 2rem;
        max-width: 1200px;
        margin: 0 auto;
    }

    .checkout-card {
        background: white;
        border-radius: 0.75rem;
        padding: 1.5rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .section-title {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid #f0f0f0;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        display: block;
        font-weight: 500;
        margin-bottom: 0.5rem;
        color: #333;
    }

    .form-control {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #ddd;
        border-radius: 0.5rem;
        font-family: inherit;
    }

    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        outline: none;
    }

    .radio-group {
        display: flex;
        gap: 1rem;
        margin-top: 0.5rem;
    }

    .radio-option {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem;
        border: 1px solid #ddd;
        border-radius: 0.5rem;
        cursor: pointer;
        transition: all 0.3s ease;
        flex: 1;
    }

    .radio-option input[type="radio"] {
        cursor: pointer;
    }

    .radio-option:has(input:checked) {
        background: #f0f4ff;
        border-color: #667eea;
    }

    .cart-item {
        display: flex;
        gap: 1rem;
        padding: 1rem;
        border-bottom: 1px solid #f0f0f0;
    }

    .cart-item img {
        width: 80px;
        height: 80px;
        background: #f0f0f0;
        border-radius: 0.4rem;
        object-fit: cover;
    }

    .item-details {
        flex-grow: 1;
    }

    .item-name {
        font-weight: 600;
        margin-bottom: 0.25rem;
    }

    .item-qty {
        font-size: 0.85rem;
        color: #999;
    }

    .item-price {
        font-weight: 600;
        color: #667eea;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 1rem;
    }

    .summary-total {
        display: flex;
        justify-content: space-between;
        font-size: 1.2rem;
        font-weight: 700;
        color: #667eea;
        padding-top: 1rem;
        border-top: 2px solid #f0f0f0;
    }

    .btn-checkout {
        width: 100%;
        padding: 0.875rem;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        border-radius: 0.5rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-top: 1.5rem;
    }

    .btn-checkout:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
    }

    .btn-checkout:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }

    @media (max-width: 768px) {
        .checkout-container {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="container my-4">
    <h2 class="mb-4">
        <i class="fas fa-shopping-cart me-2"></i>Checkout
    </h2>

    <form method="POST" action="{{ route('buyer.checkout.store') }}" class="checkout-container">
        @csrf

        <!-- Form -->
        <div>
            <!-- Alamat Pengiriman -->
            <div class="checkout-card">
                <h3 class="section-title">
                    <i class="fas fa-map-marker-alt me-2"></i>Alamat Pengiriman
                </h3>

                <div class="form-group">
                    <label for="shipping_address" class="form-label">Alamat Lengkap</label>
                    <textarea class="form-control @error('shipping_address') is-invalid @enderror" 
                              id="shipping_address" name="shipping_address" rows="3" required
                              placeholder="Masukkan alamat pengiriman lengkap">{{ old('shipping_address', auth()->user()->address) }}</textarea>
                    @error('shipping_address')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Metode Pengiriman -->
            <div class="checkout-card">
                <h3 class="section-title">
                    <i class="fas fa-truck me-2"></i>Metode Pengiriman
                </h3>

                <div class="form-group">
                    <div class="radio-group">
                        <label class="radio-option">
                            <input type="radio" name="shipping_method" value="pickup" required>
                            <div>
                                <strong>Ambil Sendiri</strong><br>
                                <small>Gratis</small>
                            </div>
                        </label>
                        <label class="radio-option">
                            <input type="radio" name="shipping_method" value="delivery" checked required>
                            <div>
                                <strong>Diantar</strong><br>
                                <small>Rp 10.000</small>
                            </div>
                        </label>
                    </div>
                    @error('shipping_method')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Summary -->
        <div>
            <!-- Cart Items -->
            <div class="checkout-card">
                <h3 class="section-title">
                    <i class="fas fa-box me-2"></i>Produk
                </h3>

                @foreach($cart as $item)
                <div class="cart-item">
                    <img src="{{ $item->product->image ? asset('storage/' . $item->product->image) : asset('images/no-product.png') }}" 
                         alt="{{ $item->product->name }}">
                    <div class="item-details">
                        <div class="item-name">{{ $item->product->name }}</div>
                        <div class="item-qty">{{ $item->quantity }}x</div>
                    </div>
                    <div class="item-price">
                        Rp{{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Summary -->
            <div class="checkout-card">
                <h3 class="section-title">
                    <i class="fas fa-receipt me-2"></i>Ringkasan
                </h3>

                @php
                    $subtotal = $cart->sum(fn($item) => $item->product->price * $item->quantity);
                @endphp

                <div class="summary-row">
                    <span>Subtotal</span>
                    <strong>Rp{{ number_format($subtotal, 0, ',', '.') }}</strong>
                </div>

                <div class="summary-row" id="shipping-fee">
                    <span>Ongkir</span>
                    <strong>Rp 10.000</strong>
                </div>

                <div class="summary-total">
                    <span>Total</span>
                    <span id="total-amount">Rp{{ number_format($subtotal + 10000, 0, ',', '.') }}</span>
                </div>

                <button type="submit" class="btn-checkout">
                    <i class="fas fa-check me-2"></i>Lanjutkan Pembayaran
                </button>
            </div>
        </div>
    </form>
</div>

<script>
document.querySelectorAll('input[name="shipping_method"]').forEach(radio => {
    radio.addEventListener('change', function() {
        const shippingFee = this.value === 'pickup' ? 0 : 10000;
        const subtotal = {{ $subtotal }};
        const total = subtotal + shippingFee;

        document.getElementById('shipping-fee').innerHTML = `
            <span>Ongkir</span>
            <strong>Rp${shippingFee.toLocaleString('id-ID')}</strong>
        `;

        document.getElementById('total-amount').textContent = 
            'Rp' + total.toLocaleString('id-ID');
    });
});
</script>
@endsection
