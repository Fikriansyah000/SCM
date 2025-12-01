@extends('layouts.app')

@section('title', 'Keranjang - PestiMart')

@section('content')
<style>
    .cart-container {
        background: var(--color-white);
        border-radius: var(--radius-lg);
        padding: var(--space-4);
        box-shadow: var(--shadow-card);
        border: 1px solid var(--color-border);
    }

    @media (min-width: 768px) {
        .cart-container {
            padding: var(--space-6);
        }
    }
    
    .cart-item {
        display: flex;
        gap: var(--space-4);
        padding: var(--space-4) 0;
        border-bottom: 1px solid var(--color-border);
        align-items: center;
        flex-wrap: wrap;
    }
    
    .cart-item:last-child {
        border-bottom: none;
    }
    
    .cart-image {
        width: 80px;
        height: 80px;
        background: var(--color-neutral-gray);
        border-radius: var(--radius-md);
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        flex-shrink: 0;
    }

    @media (min-width: 576px) {
        .cart-image {
            width: 100px;
            height: 100px;
        }
    }
    
    .cart-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .cart-image .no-image {
        font-size: 2rem;
        color: var(--color-text-muted);
    }
    
    .cart-details {
        flex: 1;
        min-width: 0;
    }
    
    .cart-product-name {
        font-weight: 600;
        color: var(--color-neutral-dark);
        margin-bottom: var(--space-1);
    }
    
    .cart-shop {
        font-size: var(--font-size-sm);
        color: var(--color-text-muted);
        margin-bottom: var(--space-2);
    }
    
    .cart-price {
        color: var(--color-primary);
        font-weight: 600;
    }

    .flash-sale-tag {
        font-size: var(--font-size-xs);
        color: var(--color-success);
        margin-top: var(--space-1);
    }
    
    .quantity-control {
        display: flex;
        align-items: center;
        gap: var(--space-2);
        margin: 0 var(--space-2);
    }

    @media (max-width: 575.98px) {
        .quantity-control {
            flex-basis: 100%;
            justify-content: flex-start;
            margin: var(--space-3) 0 0;
        }
    }
    
    .quantity-btn {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--color-neutral-gray);
        border: 1px solid var(--color-border);
        border-radius: var(--radius-sm);
        cursor: pointer;
        transition: all var(--transition-fast);
    }

    @media (hover: hover) {
        .quantity-btn:hover {
            background: var(--color-primary);
            color: var(--color-white);
            border-color: var(--color-primary);
        }
    }
    
    .quantity-input {
        width: 50px;
        text-align: center;
        border: 1px solid var(--color-border);
        border-radius: var(--radius-sm);
        padding: var(--space-2);
    }
    
    .cart-actions {
        display: flex;
        gap: var(--space-4);
        align-items: center;
    }

    @media (max-width: 575.98px) {
        .cart-actions {
            margin-left: auto;
        }
    }
    
    .btn-remove {
        background: none;
        border: none;
        color: var(--color-danger);
        cursor: pointer;
        font-size: var(--font-size-lg);
        transition: transform var(--transition-fast);
        padding: var(--space-2);
    }

    @media (hover: hover) {
        .btn-remove:hover {
            transform: scale(1.2);
        }
    }
    
    .cart-summary {
        background: var(--gradient-primary);
        color: var(--color-white);
        padding: var(--space-6);
        border-radius: var(--radius-lg);
    }

    /* Disable sticky on mobile */
    @media (min-width: 992px) {
        .cart-summary {
            position: sticky;
            top: var(--space-4);
        }
    }
    
    .cart-summary h4 {
        margin-bottom: var(--space-6);
        font-weight: 600;
    }
    
    .summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: var(--space-4);
        padding-bottom: var(--space-4);
        border-bottom: 1px solid rgba(255,255,255,0.2);
    }
    
    .summary-row.total {
        border-bottom: none;
        font-size: var(--font-size-lg);
        font-weight: 700;
        margin-top: var(--space-4);
    }
    
    .btn-checkout {
        width: 100%;
        padding: var(--space-3);
        background: var(--color-white);
        color: var(--color-primary);
        border: none;
        border-radius: var(--radius-md);
        font-weight: 600;
        cursor: pointer;
        margin-top: var(--space-4);
        transition: transform var(--transition-fast), box-shadow var(--transition-fast);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: var(--space-2);
        text-decoration: none;
    }

    @media (hover: hover) {
        .btn-checkout:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            color: var(--color-primary);
        }
    }
    
    .btn-continue-shopping {
        width: 100%;
        padding: var(--space-3);
        background: transparent;
        color: var(--color-white);
        border: 2px solid var(--color-white);
        border-radius: var(--radius-md);
        font-weight: 600;
        cursor: pointer;
        margin-top: var(--space-3);
        transition: all var(--transition-fast);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: var(--space-2);
        text-decoration: none;
    }

    @media (hover: hover) {
        .btn-continue-shopping:hover {
            background: var(--color-white);
            color: var(--color-primary);
        }
    }
    
    .empty-cart {
        text-align: center;
        padding: var(--space-12);
        color: var(--color-text-muted);
    }
    
    .empty-cart i {
        font-size: 4rem;
        color: var(--color-neutral-gray);
        margin-bottom: var(--space-4);
    }

    .cart-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: var(--space-6);
    }

    @media (min-width: 992px) {
        .cart-grid {
            grid-template-columns: 2fr 1fr;
        }
    }
</style>

<div class="container my-4">
    @if($carts->count() > 0)
        <div class="cart-grid">
            <div>
                <h2 class="mb-4 heading-clamp">
                    <i class="fas fa-shopping-cart me-2" style="color: var(--color-primary);"></i>Keranjang Belanja
                </h2>
                
                <div class="cart-container">
                    @forelse($carts as $cart)
                        <div class="cart-item">
                            <div class="cart-image">
                                @if($cart->product->image)
                                    <img src="{{ asset('storage/' . $cart->product->image) }}" alt="{{ $cart->product->name }}">
                                @else
                                    <div class="no-image">
                                        <i class="fas fa-image"></i>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="cart-details">
                                <div class="cart-product-name">{{ $cart->product->name }}</div>
                                <div class="cart-shop">
                                    <i class="fas fa-store me-1"></i>{{ $cart->product->shop->shop_name }}
                                </div>

                                @php
                                    $isService = ($cart->product->product_type ?? 'food') === 'service';
                                    $proposalDesc = $cart->customizations['proposal_description'] ?? null;
                                    $proposedDeadline = $cart->customizations['proposed_deadline'] ?? null;
                                    $proposedPrice = $cart->customizations['proposed_price'] ?? null;
                                    $notes = $cart->customizations['notes'] ?? null;
                                @endphp

                                @if($isService && $proposalDesc)
                                    <div class="service-info" style="background: #f0f4ff; border-radius: .5rem; padding: .65rem .9rem; margin: .5rem 0; font-size: .9rem;">
                                        <div class="mb-1"><i class="fas fa-file-alt me-1" style="color: var(--color-primary);"></i>
                                            <strong>Proposal Layanan</strong>
                                        </div>
                                        <div class="text-muted mb-1" style="font-size: .85rem;">
                                            {{ Str::limit($proposalDesc, 100) }}
                                        </div>
                                        <div class="d-flex flex-wrap gap-3 mt-2">
                                            <div><i class="fas fa-calendar-check me-1" style="color: var(--color-warning);"></i>
                                                Deadline: <strong>{{ \Carbon\Carbon::parse($proposedDeadline)->translatedFormat('d M Y') }}</strong>
                                            </div>
                                            <div><i class="fas fa-tag me-1" style="color: var(--color-success);"></i>
                                                Harga: <strong>Rp{{ number_format($proposedPrice, 0, ',', '.') }}</strong>
                                            </div>
                                        </div>
                                        @if($notes)
                                            <div class="text-muted mt-1" style="font-size: .85rem;"><i class="fas fa-sticky-note me-1"></i>{{ $notes }}</div>
                                        @endif
                                        <div class="mt-2" style="font-size: .8rem; color: #6b7280;">
                                            <i class="fas fa-info-circle me-1"></i>Menunggu persetujuan seller saat checkout
                                        </div>
                                    </div>
                                @endif

                                <div class="cart-price">
                                    @php
                                        $isFlash = in_array($cart->product_id, session('flash_sale_ids', []));
                                        $unitPrice = $isService && $proposedPrice ? $proposedPrice : $cart->product->price;
                                        $displayPrice = $unitPrice;
                                        if ($isFlash) {
                                            $displayPrice = round($unitPrice * 0.90);
                                        }
                                    @endphp
                                    Rp{{ number_format($displayPrice, 0, ',', '.') }}
                                    @if(!$isService)
                                        x {{ $cart->quantity }}
                                    @endif
                                    @if($isFlash)
                                        <div class="flash-sale-tag">
                                            <i class="fas fa-bolt me-1"></i>Flash Sale: 10% off + Gratis Ongkir
                                        </div>
                                    @endif
                                </div>
                            </div>                            
                            <div class="quantity-control">
                                @if($isService)
                                    {{-- For services, cannot change quantity --}}
                                    <span class="text-muted" style="font-size:.85rem;">
                                        <i class="fas fa-lock me-1"></i>1 layanan
                                    </span>
                                @else
                                    <form method="POST" action="{{ route('buyer.cart.update', $cart->id) }}" class="d-flex align-items-center gap-2">
                                        @csrf
                                        @method('PUT')
                                        <button type="button" class="quantity-btn" onclick="decreaseQty(this)">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <input type="number" name="quantity" class="quantity-input" value="{{ $cart->quantity }}" min="1" max="{{ $cart->product->stock }}" onchange="this.form.submit()">
                                        <button type="button" class="quantity-btn" onclick="increaseQty(this)">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                            
                            <div class="cart-actions">
                                <form method="POST" action="{{ route('buyer.cart.remove', $cart->id) }}" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-remove" title="Hapus dari keranjang">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="empty-cart">
                            <i class="fas fa-shopping-cart"></i>
                            <h5>Keranjang Kosong</h5>
                            <p>Anda belum menambahkan produk ke keranjang</p>
                        </div>
                    @endempty
                </div>
            </div>
            
            <div>
                @php
                    $physicalItems = $carts->filter(fn($c) => ($c->product->product_type ?? 'food') !== 'service');
                    $serviceItems = $carts->filter(fn($c) => ($c->product->product_type ?? 'food') === 'service');
                @endphp

                <div class="cart-summary">
                    <h4>Ringkasan Pesanan</h4>

                    <div class="summary-row">
                        <span>Total Item Produk</span>
                        <span>{{ $physicalItems->count() }}</span>
                    </div>
                    <div class="summary-row">
                        <span>Total Item Layanan</span>
                        <span>{{ $serviceItems->count() }}</span>
                    </div>

                    <div class="summary-row total">
                        <span>Total Perkiraan</span>
                        <span>Rp{{ number_format($total, 0, ',', '.') }}</span>
                    </div>

                    @if($physicalItems->isNotEmpty())
                        <a href="{{ route('buyer.checkout', ['mode' => 'products']) }}" class="btn-checkout mb-2">
                            <i class="fas fa-box"></i>Checkout Produk
                        </a>
                    @endif

                    @if($serviceItems->isNotEmpty())
                        <a href="{{ route('buyer.checkout', ['mode' => 'services']) }}" class="btn-checkout" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: #fff;">
                            <i class="fas fa-concierge-bell"></i>Ajukan Layanan
                        </a>
                    @endif

                    <a href="{{ route('buyer.home') }}" class="btn-continue-shopping">
                        <i class="fas fa-arrow-left"></i>Lanjut Belanja
                    </a>
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-5">
            <div class="empty-cart">
                <i class="fas fa-shopping-cart"></i>
                <h3>Keranjang Anda Kosong</h3>
                <p class="mb-4">Mulai belanja produk kebutuhan kampusmu sekarang</p>
                <a href="{{ route('buyer.home') }}" class="btn-gradient btn-gradient-lg">
                    <i class="fas fa-shopping-bag me-2"></i>Mulai Belanja
                </a>
            </div>
        </div>
    @endif
</div>

<script>
function increaseQty(btn) {
    const input = btn.parentElement.querySelector('.quantity-input');
    input.value = parseInt(input.value) + 1;
}

function decreaseQty(btn) {
    const input = btn.parentElement.querySelector('.quantity-input');
    if (parseInt(input.value) > 1) {
        input.value = parseInt(input.value) - 1;
    }
}
</script>
@endsection
