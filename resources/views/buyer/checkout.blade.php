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

    /* Shipping Mode Selection */
    .shipping-modes-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .shipping-option {
        position: relative;
        padding: 1.25rem;
        border: 2px solid #ddd;
        border-radius: 0.75rem;
        cursor: pointer;
        transition: all 0.3s ease;
        text-align: center;
    }

    .shipping-option input[type="radio"] {
        position: absolute;
        opacity: 0;
        cursor: pointer;
    }

    .shipping-option input[type="radio"]:checked + .shipping-content {
        opacity: 1;
    }

    .shipping-option input[type="radio"]:checked ~ .shipping-badge {
        background: #667eea;
        color: white;
    }

    .shipping-option:has(input:checked) {
        background: #f0f4ff;
        border-color: #667eea;
    }

    .shipping-option:hover {
        border-color: #667eea;
    }

    .shipping-badge {
        position: absolute;
        top: 0.5rem;
        right: 0.5rem;
        background: #e0e0e0;
        color: #666;
        border-radius: 50%;
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.8rem;
        font-weight: 700;
        transition: all 0.3s ease;
    }

    .shipping-content h4 {
        font-size: 1rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 0.5rem;
    }

    .shipping-estimate {
        font-size: 0.85rem;
        color: #667eea;
        font-weight: 500;
        margin-bottom: 0.35rem;
    }

    .shipping-cost {
        font-size: 1.1rem;
        font-weight: 700;
        color: #28a745;
        margin-bottom: 0.35rem;
    }

    .shipping-weight {
        font-size: 0.75rem;
        color: #999;
    }

    .shipping-unavailable {
        opacity: 0.6;
        pointer-events: none;
    }

    .shipping-warning {
        display: none;
        padding: 0.75rem;
        background: #fff3cd;
        color: #856404;
        border: 1px solid #ffeaa7;
        border-radius: 0.5rem;
        font-size: 0.85rem;
        margin-bottom: 1rem;
    }

    .shipping-warning.show {
        display: block;
    }

    .cutoff-alert {
        background: #ffe4e1;
        color: #c41c3b;
        padding: 0.75rem;
        border-radius: 0.5rem;
        margin-top: 0.75rem;
        font-size: 0.8rem;
        text-align: center;
        font-weight: 500;
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

        .shipping-modes-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="container my-4">
    <h2 class="mb-4">
        <i class="fas fa-shopping-cart me-2"></i>Checkout
    </h2>

    <form method="POST" action="{{ route('buyer.checkout.store') }}" class="checkout-container" id="checkoutForm">
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

            <!-- Mode Transportasi -->
            <div class="checkout-card">
                <h3 class="section-title">
                    <i class="fas fa-truck me-2"></i>Mode Transportasi
                </h3>

                <div class="shipping-warning" id="shippingWarning"></div>

                <div class="shipping-modes-grid" id="shippingModesGrid">
                    <!-- Will be populated by JavaScript -->
                    <div style="text-align: center; padding: 2rem; color: #999;">
                        <i class="fas fa-spinner fa-spin me-2"></i>Memuat opsi pengiriman...
                    </div>
                </div>

                <input type="hidden" name="shipping_mode" id="shipping_mode" value="reguler">
                <input type="hidden" name="shipping_cost" id="shipping_cost" value="0">

                @error('shipping_mode')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <!-- Metode Pengiriman (Legacy - kept for compatibility) -->
            <div class="checkout-card">
                <h3 class="section-title">
                    <i class="fas fa-cog me-2"></i>Pengaturan Pengiriman
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
                                <small>Lihat opsi di atas</small>
                            </div>
                        </label>
                    </div>
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
                @php
                    $isFlash = in_array($item->product_id, session('flash_sale_ids', []));
                    $unitPrice = $item->product->price;
                    $displayPrice = $isFlash ? round($unitPrice * 0.90) : $unitPrice;
                @endphp
                <div class="cart-item">
                    <img src="{{ $item->product->image ? asset('storage/' . $item->product->image) : asset('images/no-product.png') }}" 
                         alt="{{ $item->product->name }}">
                    <div class="item-details">
                        <div class="item-name">{{ $item->product->name }}</div>
                        <div class="item-qty">{{ $item->quantity }}x</div>
                        @if($isFlash)
                            <div style="font-size:0.85rem; color:#28a745;">Flash Sale: 10% off + Gratis Ongkir</div>
                        @endif
                    </div>
                    <div class="item-price">
                        Rp{{ number_format($displayPrice * $item->quantity, 0, ',', '.') }}
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Summary -->
            <div class="checkout-card">
                <h3 class="section-title">
                    <i class="fas fa-receipt me-2"></i>Ringkasan
                </h3>

                <div class="summary-row">
                    <span>Subtotal</span>
                    <strong id="subtotal-display">Rp{{ number_format($subtotal, 0, ',', '.') }}</strong>
                </div>

                <div class="summary-row">
                    <span>Diskon</span>
                    <strong id="discount-display">-Rp{{ number_format($discount, 0, ',', '.') }}</strong>
                </div>

                <div class="summary-row" id="shipping-fee">
                    <span>Ongkir</span>
                    <strong id="shipping-display">Rp{{ number_format($shipping, 0, ',', '.') }}</strong>
                </div>

                <div class="summary-total">
                    <span>Total</span>
                    <span id="total-amount">Rp{{ number_format($total, 0, ',', '.') }}</span>
                </div>

                <button type="submit" class="btn-checkout" id="checkoutBtn">
                    <i class="fas fa-check me-2"></i>Lanjutkan Pembayaran
                </button>
            </div>
        </div>
    </form>
</div>

<script>
    const subtotal = {{ $subtotal }};
    const discount = {{ $discount }};
    const flashHasDiscount = {{ $discount > 0 ? 'true' : 'false' }};

    // Perkiraan jarak (dalam praktik ini dihitung dari geolocation atau database)
    const estimatedDistance = 10; // km (default)
    const totalWeight = {{ $cart->sum(fn($c) => $c->quantity) }}; // total quantity as proxy for weight

    async function loadShippingModes() {
        try {
            const response = await fetch(`/api/shipping/modes?distance=${estimatedDistance}&weight=${totalWeight}`);
            if (!response.ok) {
                const txt = await response.text();
                console.error('Shipping API error:', response.status, txt);
                throw new Error('Error memuat opsi pengiriman (server returned ' + response.status + ')');
            }

            const contentType = response.headers.get('content-type') || '';
            if (!contentType.includes('application/json')) {
                const txt = await response.text();
                console.error('Shipping API returned non-JSON response:', txt);
                throw new Error('Error memuat opsi pengiriman (invalid response)');
            }

            const data = await response.json();

            const gridHtml = data.modes.map((mode, idx) => `
                <label class="shipping-option ${!mode.available ? 'shipping-unavailable' : ''}">
                    <input type="radio" name="shipping_mode_select" value="${mode.mode}" 
                        ${mode.available ? 'required' : 'disabled'}
                        ${idx === 0 ? 'checked' : ''}
                        onchange="updateShippingMode('${mode.mode}', ${mode.cost})">
                    <div class="shipping-badge"></div>
                    <div class="shipping-content">
                        <h4>${mode.label}</h4>
                        <div class="shipping-estimate">
                            <i class="fas fa-clock me-1"></i>${mode.estimatedDays}
                        </div>
                        <div class="shipping-cost">
                            Rp${mode.cost.toLocaleString('id-ID')}
                        </div>
                        <div class="shipping-weight">
                            Maks ${mode.maxWeight}kg
                        </div>
                        ${!mode.available && mode.reason ? `<div class="cutoff-alert">${mode.reason}</div>` : ''}
                    </div>
                </label>
            `).join('');

            document.getElementById('shippingModesGrid').innerHTML = gridHtml;

            // Set default to first available mode
            const firstAvailable = data.modes.find(m => m.available);
            if (firstAvailable) {
                updateShippingMode(firstAvailable.mode, firstAvailable.cost);
            }
        } catch (error) {
            console.error('Error loading shipping modes:', error);
            document.getElementById('shippingModesGrid').innerHTML = 
                '<div style="color: #c00;">Error memuat opsi pengiriman</div>';
        }
    }

    function updateShippingMode(mode, cost) {
        document.getElementById('shipping_mode').value = mode;
        document.getElementById('shipping_cost').value = cost;

        // Update display
        const shippingDisplay = document.getElementById('shipping-display');
        const totalAmountDisplay = document.getElementById('total-amount');
        
        let baseTotal = subtotal - discount;
        
        // Jika ada flash sale, ongkir gratis
        let finalShippingCost = flashHasDiscount ? 0 : cost;
        let finalTotal = baseTotal + finalShippingCost;

        shippingDisplay.textContent = `Rp${finalShippingCost.toLocaleString('id-ID')}`;
        totalAmountDisplay.textContent = `Rp${finalTotal.toLocaleString('id-ID')}`;
    }

    // Load modes on page load
    document.addEventListener('DOMContentLoaded', loadShippingModes);

    // Form submission
    document.getElementById('checkoutForm').addEventListener('submit', function(e) {
        const selectedMode = document.querySelector('input[name="shipping_mode_select"]:checked');
        if (!selectedMode) {
            e.preventDefault();
            alert('Pilih mode transportasi terlebih dahulu');
            return false;
        }
    });
</script>
@endsection
