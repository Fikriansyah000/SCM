@extends('layouts.app')

@section('title', 'Keranjang - PestiMart')

@section('content')
<style>
    .cart-container {
        background: #faf6f1;
        border-radius: 0.75rem;
        padding: 2rem;
        box-shadow: 0 10px 28px rgba(7,18,46,0.04);
        border: 1px solid rgba(139,113,89,0.08);
    }
    
    .cart-item {
        display: flex;
        gap: 1.5rem;
        padding: 1.5rem 0;
        border-bottom: 1px solid #eee;
        align-items: center;
    }
    
    .cart-item:last-child {
        border-bottom: none;
    }
    
    .cart-image {
        width: 100px;
        height: 100px;
        background: #f0ede8;
        border-radius: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        border: 1px solid rgba(139,113,89,0.1);
    }
    
    .cart-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .cart-image .no-image {
        font-size: 2rem;
        color: #ddd;
    }
    
    .cart-details {
        flex-grow: 1;
    }
    
    .cart-product-name {
        font-weight: 600;
        color: #333;
        margin-bottom: 0.25rem;
    }
    
    .cart-shop {
        font-size: 0.85rem;
        color: #999;
        margin-bottom: 0.5rem;
    }
    
    .cart-price {
        color: #667eea;
        font-weight: 600;
    }
    
    .quantity-control {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin: 0 1rem;
    }
    
    .quantity-btn {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f0ede8;
        border: 1px solid rgba(139,113,89,0.1);
        border-radius: 0.25rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .quantity-btn:hover {
        background: #a87d68;
        color: white;
    }
    
    .quantity-input {
        width: 50px;
        text-align: center;
        border: 1px solid #ddd;
        border-radius: 0.25rem;
        padding: 0.5rem;
    }
    
    .cart-actions {
        display: flex;
        gap: 1rem;
        align-items: center;
    }
    
    .btn-remove {
        background: none;
        border: none;
        color: #f5576c;
        cursor: pointer;
        font-size: 1.2rem;
        transition: transform 0.3s ease;
    }
    
    .btn-remove:hover {
        transform: scale(1.2);
    }
    
    .cart-summary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 2rem;
        border-radius: 0.75rem;
        position: sticky;
        top: 20px;
    }
    
    .cart-summary h4 {
        margin-bottom: 1.5rem;
        font-weight: 600;
    }
    
    .summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 1rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid rgba(255,255,255,0.2);
    }
    
    .summary-row.total {
        border-bottom: none;
        font-size: 1.2rem;
        font-weight: 700;
        margin-top: 1rem;
    }
    
    .btn-checkout {
        width: 100%;
        padding: 0.75rem;
        background: white;
        color: #667eea;
        border: none;
        border-radius: 0.5rem;
        font-weight: 600;
        cursor: pointer;
        margin-top: 1rem;
        transition: transform 0.3s ease;
    }
    
    .btn-checkout:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    
    .btn-continue-shopping {
        width: 100%;
        padding: 0.75rem;
        background: transparent;
        color: white;
        border: 2px solid white;
        border-radius: 0.5rem;
        font-weight: 600;
        cursor: pointer;
        margin-top: 1rem;
        transition: all 0.3s ease;
    }
    
    .btn-continue-shopping:hover {
        background: white;
        color: #667eea;
    }
    
    .empty-cart {
        text-align: center;
        padding: 3rem;
        color: #999;
    }
    
    .empty-cart i {
        font-size: 4rem;
        color: #ddd;
        margin-bottom: 1rem;
    }
</style>

<div class="container my-4">
    @if($carts->count() > 0)
        <div class="row">
            <div class="col-lg-8">
                <h2 class="mb-4">
                    <i class="fas fa-shopping-cart me-2"></i>Keranjang Belanja
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
                                <div class="cart-price">
                                    @php
                                        $isFlash = in_array($cart->product_id, session('flash_sale_ids', []));
                                        $unitPrice = $cart->product->price;
                                        $displayPrice = $unitPrice;
                                        if ($isFlash) {
                                            $displayPrice = round($unitPrice * 0.90);
                                        }
                                    @endphp
                                    Rp{{ number_format($displayPrice, 0, ',', '.') }} x {{ $cart->quantity }}
                                    @if($isFlash)
                                        <div style="font-size:0.8rem; color:#28a745;">(Flash Sale: 10% off + Gratis Ongkir)</div>
                                    @endif
                                </div>
                            </div>                            
                            <div class="quantity-control">
                                <form method="PUT" action="{{ route('buyer.cart.update', $cart->id) }}" class="d-flex align-items-center gap-2">
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
                            </div>
                            
                            <div class="cart-actions">
                                <form method="POST" action="{{ route('buyer.cart.remove', $cart->id) }}" style="display: inline;">
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
            
            <div class="col-lg-4">
                <div class="cart-summary">
                    <h4>Ringkasan Pesanan</h4>
                    
                    <div class="summary-row">
                        <span>Subtotal:</span>
                        <span>Rp{{ number_format($subtotal ?? $total, 0, ',', '.') }}</span>
                    </div>

                    @if(isset($discount) && $discount > 0)
                    <div class="summary-row">
                        <span>Diskon:</span>
                        <span>-Rp{{ number_format($discount, 0, ',', '.') }}</span>
                    </div>
                    @endif

                    <div class="summary-row">
                        <span>Ongkos Kirim:</span>
                        <span>{{ (isset($shipping) && $shipping === 0) ? 'Gratis' : (isset($shipping) ? 'Rp' . number_format($shipping,0,',','.') : 'Gratis') }}</span>
                    </div>
                    
                    <div class="summary-row total">
                        <span>Total:</span>
                        <span>Rp{{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                    
                    <a href="{{ route('buyer.checkout') }}" class="btn btn-checkout">
                        <i class="fas fa-arrow-right me-2"></i>Lanjut Checkout
                    </a>
                    
                    <a href="{{ route('buyer.home') }}" class="btn btn-continue-shopping">
                        <i class="fas fa-arrow-left me-2"></i>Lanjut Belanja
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
                <a href="{{ route('buyer.home') }}" class="btn btn-primary btn-lg">
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
