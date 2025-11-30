@extends('layouts.app')

@section('title', 'Checkout - PestiMart')

@section('content')
<style>
    .checkout-container {
        display: grid;
        grid-template-columns: 1fr;
        gap: var(--space-6);
        max-width: 1200px;
        margin: 0 auto;
    }

    @media (min-width: 992px) {
        .checkout-container {
            grid-template-columns: 2fr 1fr;
        }
    }

    .checkout-card {
        background: var(--color-white);
        border-radius: var(--radius-lg);
        padding: var(--space-4);
        box-shadow: var(--shadow-card);
        border: 1px solid var(--color-border);
        margin-bottom: var(--space-4);
    }

    @media (min-width: 768px) {
        .checkout-card {
            padding: var(--space-6);
        }
    }

    .section-title {
        font-size: var(--font-size-lg);
        font-weight: 600;
        margin-bottom: var(--space-6);
        padding-bottom: var(--space-4);
        border-bottom: 2px solid var(--color-border);
        color: var(--color-neutral-dark);
        display: flex;
        align-items: center;
        gap: var(--space-2);
    }

    .section-title i {
        color: var(--color-primary);
    }

    .form-group {
        margin-bottom: var(--space-6);
    }

    .form-label {
        display: block;
        font-weight: 500;
        margin-bottom: var(--space-2);
        color: var(--color-neutral-dark);
    }

    /* Shipping Mode Selection - Mobile First */
    .shipping-modes-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: var(--space-4);
        margin-bottom: var(--space-6);
    }

    @media (min-width: 576px) {
        .shipping-modes-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (min-width: 992px) {
        .shipping-modes-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    .shipping-option {
        position: relative;
        padding: var(--space-4);
        border: 2px solid var(--color-border);
        border-radius: var(--radius-lg);
        cursor: pointer;
        transition: all var(--transition-fast);
        text-align: center;
        background: var(--color-white);
    }

    .shipping-option input[type="radio"] {
        position: absolute;
        opacity: 0;
        cursor: pointer;
    }

    .shipping-option.is-selected,
    .shipping-option:has(input:checked) {
        background: rgba(58, 123, 255, 0.05);
        border-color: var(--color-primary);
    }

    .shipping-option.is-selected .shipping-badge,
    .shipping-option:has(input:checked) .shipping-badge {
        background: var(--color-primary);
        color: var(--color-white);
    }

    @media (hover: hover) {
        .shipping-option:hover:not(.shipping-unavailable) {
            border-color: var(--color-primary-light);
        }
    }

    .shipping-badge {
        position: absolute;
        top: var(--space-2);
        right: var(--space-2);
        background: var(--color-neutral-gray);
        color: var(--color-text-secondary);
        border-radius: var(--radius-full);
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: var(--font-size-xs);
        font-weight: 700;
        transition: all var(--transition-fast);
    }

    .shipping-content h4 {
        font-size: var(--font-size-base);
        font-weight: 600;
        color: var(--color-neutral-dark);
        margin-bottom: var(--space-2);
    }

    .shipping-estimate {
        font-size: var(--font-size-sm);
        color: var(--color-primary);
        font-weight: 500;
        margin-bottom: var(--space-1);
    }

    .shipping-cost {
        font-size: var(--font-size-lg);
        font-weight: 700;
        color: var(--color-success);
        margin-bottom: var(--space-1);
    }

    .shipping-weight {
        font-size: var(--font-size-xs);
        color: var(--color-text-muted);
    }

    .shipping-unavailable {
        opacity: 0.6;
        pointer-events: none;
    }

    .shipping-warning {
        display: none;
        padding: var(--space-3);
        background: var(--color-warning-light);
        color: #856404;
        border: 1px solid #ffeaa7;
        border-radius: var(--radius-md);
        font-size: var(--font-size-sm);
        margin-bottom: var(--space-4);
    }

    .shipping-warning.show {
        display: block;
    }

    .cutoff-alert {
        background: var(--color-danger-light);
        color: var(--color-danger);
        padding: var(--space-2) var(--space-3);
        border-radius: var(--radius-md);
        margin-top: var(--space-3);
        font-size: var(--font-size-xs);
        text-align: center;
        font-weight: 500;
    }

    .radio-group {
        display: flex;
        flex-direction: column;
        gap: var(--space-3);
        margin-top: var(--space-2);
    }

    @media (min-width: 576px) {
        .radio-group {
            flex-direction: row;
        }
    }

    .radio-option {
        display: flex;
        align-items: center;
        gap: var(--space-3);
        padding: var(--space-3);
        border: 2px solid var(--color-border);
        border-radius: var(--radius-md);
        cursor: pointer;
        transition: all var(--transition-fast);
        flex: 1;
    }

    .radio-option input[type="radio"] {
        cursor: pointer;
        accent-color: var(--color-primary);
    }

    .radio-option.is-selected,
    .radio-option:has(input:checked) {
        background: rgba(58, 123, 255, 0.05);
        border-color: var(--color-primary);
    }

    .cart-item {
        display: flex;
        gap: var(--space-4);
        padding: var(--space-4);
        border-bottom: 1px solid var(--color-border);
        flex-wrap: wrap;
    }

    .cart-item:last-child {
        border-bottom: none;
    }

    .cart-item img {
        width: 80px;
        height: 80px;
        background: var(--color-neutral-gray);
        border-radius: var(--radius-md);
        object-fit: cover;
        flex-shrink: 0;
    }

    .item-details {
        flex: 1;
        min-width: 0;
    }

    .item-name {
        font-weight: 600;
        margin-bottom: var(--space-1);
        color: var(--color-neutral-dark);
    }

    .item-qty {
        font-size: var(--font-size-sm);
        color: var(--color-text-muted);
    }

    .item-price {
        font-weight: 600;
        color: var(--color-primary);
        white-space: nowrap;
    }

    .flash-sale-note {
        font-size: var(--font-size-sm);
        color: var(--color-success);
        margin-top: var(--space-1);
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: var(--space-4);
        color: var(--color-text-secondary);
    }

    .summary-row strong {
        color: var(--color-neutral-dark);
    }

    .summary-total {
        display: flex;
        justify-content: space-between;
        font-size: var(--font-size-xl);
        font-weight: 700;
        color: var(--color-primary);
        padding-top: var(--space-4);
        border-top: 2px solid var(--color-border);
    }

    .btn-checkout {
        width: 100%;
        padding: var(--space-4);
        background: var(--gradient-primary);
        color: var(--color-white);
        border: none;
        border-radius: var(--radius-md);
        font-weight: 600;
        font-size: var(--font-size-base);
        cursor: pointer;
        transition: all var(--transition-fast);
        margin-top: var(--space-6);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: var(--space-2);
    }

    @media (hover: hover) {
        .btn-checkout:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(58, 123, 255, 0.3);
        }
    }

    .btn-checkout:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
    }

    /* Summary sticky on desktop */
    @media (min-width: 992px) {
        .checkout-summary-wrapper {
            position: sticky;
            top: var(--space-4);
        }
    }

    .loading-spinner {
        text-align: center;
        padding: var(--space-8);
        color: var(--color-text-muted);
    }

    .shipping-error {
        color: var(--color-danger);
        text-align: center;
        padding: var(--space-4);
    }
</style>

<div class="container my-4">
    <h2 class="mb-4 heading-clamp">
        <i class="fas fa-shopping-cart me-2" style="color: var(--color-primary);"></i>Checkout
    </h2>

    <form method="POST" action="{{ route('buyer.checkout.store') }}" class="checkout-container" id="checkoutForm">
        @csrf

        <!-- Form -->
        <div>
            <!-- Alamat Pengiriman -->
            <div class="checkout-card">
                <h3 class="section-title">
                    <i class="fas fa-map-marker-alt"></i>Alamat Pengiriman
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
                    <i class="fas fa-truck"></i>Mode Transportasi
                </h3>

                <div class="shipping-warning" id="shippingWarning"></div>

                <div class="shipping-modes-grid" id="shippingModesGrid">
                    <!-- Will be populated by JavaScript -->
                    <div class="loading-spinner">
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
                    <i class="fas fa-cog"></i>Pengaturan Pengiriman
                </h3>

                <div class="form-group">
                    <div class="radio-group">
                        <label class="radio-option">
                            <input type="radio" name="shipping_method" value="pickup" required>
                            <div>
                                <strong>Ambil Sendiri</strong><br>
                                <small class="text-muted">Gratis</small>
                            </div>
                        </label>
                        <label class="radio-option">
                            <input type="radio" name="shipping_method" value="delivery" checked required>
                            <div>
                                <strong>Diantar</strong><br>
                                <small class="text-muted">Lihat opsi di atas</small>
                            </div>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Summary -->
        <div class="checkout-summary-wrapper">
            <!-- Cart Items -->
            <div class="checkout-card">
                <h3 class="section-title">
                    <i class="fas fa-box"></i>Produk
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
                            <div class="flash-sale-note">
                                <i class="fas fa-bolt me-1"></i>Flash Sale: 10% off + Gratis Ongkir
                            </div>
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
                    <i class="fas fa-receipt"></i>Ringkasan
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
                    <i class="fas fa-check"></i>Lanjutkan Pembayaran
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
                <label class="shipping-option ${!mode.available ? 'shipping-unavailable' : ''} ${idx === 0 ? 'is-selected' : ''}" data-mode="${mode.mode}">
                    <input type="radio" name="shipping_mode_select" value="${mode.mode}" 
                        ${mode.available ? 'required' : 'disabled'}
                        ${idx === 0 ? 'checked' : ''}
                        onchange="updateShippingMode('${mode.mode}', ${mode.cost}, this)">
                    <div class="shipping-badge"><i class="fas fa-check" style="font-size: 10px;"></i></div>
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
                updateShippingMode(firstAvailable.mode, firstAvailable.cost, null);
            }
        } catch (error) {
            console.error('Error loading shipping modes:', error);
            document.getElementById('shippingModesGrid').innerHTML = 
                '<div class="shipping-error"><i class="fas fa-exclamation-circle me-2"></i>Error memuat opsi pengiriman</div>';
        }
    }

    function updateShippingMode(mode, cost, inputEl) {
        document.getElementById('shipping_mode').value = mode;
        document.getElementById('shipping_cost').value = cost;

        // Update is-selected class for visual feedback (fallback for browsers without :has())
        document.querySelectorAll('.shipping-option').forEach(opt => {
            opt.classList.remove('is-selected');
        });
        if (inputEl) {
            inputEl.closest('.shipping-option').classList.add('is-selected');
        } else {
            const targetOpt = document.querySelector(`.shipping-option[data-mode="${mode}"]`);
            if (targetOpt) targetOpt.classList.add('is-selected');
        }

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
