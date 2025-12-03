@extends('layouts.app')

@section('title', $product->name . ' - PestiMart')

@section('content')
<style>
    :root {
        --primary: #3A7BFF;
        --primary-dark: #2563eb;
        --primary-light: #6ECBF9;
        --gradient-primary: linear-gradient(135deg, #3A7BFF, #6ECBF9);
        --neutral-dark: #1A1F36;
        --neutral-gray: #ECEEF3;
        --accent: #FF8F3A;
    }

    .pdp-container { 
        max-width: 1200px; 
        margin: 0 auto; 
        padding: 1.5rem 1rem; 
    }

    .breadcrumb-nav {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1.5rem;
        font-size: 0.9rem;
    }
    .breadcrumb-nav a {
        color: var(--primary);
        text-decoration: none;
    }
    .breadcrumb-nav a:hover {
        text-decoration: underline;
    }
    .breadcrumb-nav span {
        color: #6b7280;
    }

    .pdp-grid { 
        display: grid; 
        grid-template-columns: 1fr 1fr; 
        gap: 2rem; 
    }

    @media (max-width: 992px) {
        .pdp-grid { grid-template-columns: 1fr; }
    }

    .pdp-card { 
        background: #fff; 
        border-radius: 1rem; 
        box-shadow: 0 4px 20px rgba(0,0,0,0.06); 
        padding: 1.5rem;
        border: 1px solid var(--neutral-gray);
    }

    /* Product Gallery */
    .product-gallery {
        position: sticky;
        top: 1rem;
    }
    .product-main-image {
        width: 100%;
        aspect-ratio: 1;
        border-radius: 0.75rem;
        overflow: hidden;
        background: var(--neutral-gray);
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .product-main-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .product-main-image .no-image {
        font-size: 4rem;
        color: #ddd;
    }

    /* Product Info */
    .product-badges {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-bottom: 1rem;
    }
    .badge-item {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.4rem 0.85rem;
        border-radius: 999px;
        background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
        color: var(--primary);
        font-weight: 600;
        font-size: 0.8rem;
    }
    .badge-item.category {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        color: #92400e;
    }

    .product-title {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--neutral-dark);
        margin-bottom: 0.75rem;
        line-height: 1.3;
    }

    .product-rating-row {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1rem;
        flex-wrap: wrap;
    }
    .rating-stars {
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }
    .rating-stars i {
        color: var(--accent);
        font-size: 1rem;
    }
    .rating-value {
        font-weight: 700;
        color: var(--neutral-dark);
        margin-left: 0.35rem;
    }
    .rating-count {
        color: #6b7280;
        font-size: 0.9rem;
    }
    .sold-count {
        color: #6b7280;
        font-size: 0.9rem;
    }

    .product-price-box {
        background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
        border-radius: 0.75rem;
        padding: 1.25rem;
        margin-bottom: 1.25rem;
    }
    .product-price {
        font-size: 2rem;
        font-weight: 800;
        color: var(--primary);
    }
    .product-stock {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-top: 0.5rem;
        font-size: 0.9rem;
        color: #059669;
    }
    .product-stock.low {
        color: #dc2626;
    }

    .product-shop-row {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem;
        background: var(--neutral-gray);
        border-radius: 0.75rem;
        margin-bottom: 1.25rem;
    }
    .shop-logo {
        width: 50px;
        height: 50px;
        border-radius: 0.5rem;
        background: white;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        border: 1px solid #e5e7eb;
    }
    .shop-logo img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .shop-info {
        flex: 1;
    }
    .shop-name {
        font-weight: 600;
        color: var(--neutral-dark);
    }
    .shop-location {
        font-size: 0.85rem;
        color: #6b7280;
    }
    .shop-actions {
        display: flex;
        gap: 0.5rem;
    }
    .btn-shop-action {
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
        font-size: 0.85rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s ease;
    }
    .btn-shop-visit {
        background: white;
        border: 1px solid var(--primary);
        color: var(--primary);
    }
    .btn-shop-visit:hover {
        background: var(--primary);
        color: white;
    }
    .btn-shop-chat {
        background: var(--gradient-primary);
        color: white;
        border: none;
    }
    .btn-shop-chat:hover {
        filter: brightness(1.05);
        color: white;
    }

    /* Variations */
    .section-title {
        font-size: 1rem;
        font-weight: 700;
        color: var(--neutral-dark);
        margin-bottom: 0.75rem;
    }
    .variation-list {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-bottom: 1.25rem;
    }
    .variation-item {
        padding: 0.5rem 1rem;
        border: 2px solid var(--neutral-gray);
        border-radius: 0.5rem;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .variation-item:hover, .variation-item.active {
        border-color: var(--primary);
        background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
    }
    .variation-price {
        font-size: 0.8rem;
        color: #059669;
    }

    /* Quantity */
    .quantity-row {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1.25rem;
    }
    .quantity-controls {
        display: flex;
        align-items: center;
        border: 1px solid var(--neutral-gray);
        border-radius: 0.5rem;
        overflow: hidden;
    }
    .qty-btn {
        width: 40px;
        height: 40px;
        border: none;
        background: white;
        font-size: 1.25rem;
        cursor: pointer;
        transition: background 0.2s ease;
    }
    .qty-btn:hover {
        background: var(--neutral-gray);
    }
    .qty-input {
        width: 60px;
        height: 40px;
        border: none;
        text-align: center;
        font-size: 1rem;
        font-weight: 600;
    }
    .qty-input:focus {
        outline: none;
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 0.75rem;
        margin-top: 1rem;
    }
    .btn-action {
        flex: 1;
        padding: 1rem;
        border-radius: 0.75rem;
        font-size: 1rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }
    .btn-add-cart {
        background: white;
        border: 2px solid var(--primary);
        color: var(--primary);
    }
    .btn-add-cart:hover {
        background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
    }
    .btn-buy-now {
        background: var(--gradient-primary);
        border: none;
        color: white;
    }
    .btn-buy-now:hover {
        filter: brightness(1.05);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(58, 123, 255, 0.3);
    }

    /* Description & Details */
    .detail-section {
        margin-top: 1.5rem;
    }
    .detail-section h4 {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--neutral-dark);
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid var(--neutral-gray);
    }
    .detail-content {
        color: #4b5563;
        line-height: 1.7;
    }

    /* Food Profile */
    .food-profile-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
    }
    .food-profile-item {
        background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
        border-radius: 0.75rem;
        padding: 1rem;
        text-align: center;
    }
    .food-profile-icon {
        font-size: 1.5rem;
        margin-bottom: 0.5rem;
    }
    .food-profile-label {
        font-size: 0.8rem;
        color: #6b7280;
        margin-bottom: 0.25rem;
    }
    .food-profile-value {
        font-weight: 600;
        color: var(--neutral-dark);
    }

    /* Reviews */
    .reviews-summary {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        padding: 1rem;
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        border-radius: 0.75rem;
        margin-bottom: 1rem;
    }
    .reviews-summary-score {
        text-align: center;
    }
    .reviews-summary-score .big-score {
        font-size: 3rem;
        font-weight: 800;
        color: var(--neutral-dark);
        line-height: 1;
    }
    .reviews-summary-score .stars {
        color: var(--accent);
        margin-top: 0.25rem;
    }
    .reviews-list {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }
    .review-item {
        padding: 1rem;
        background: var(--neutral-gray);
        border-radius: 0.75rem;
    }
    .review-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.5rem;
    }
    .review-user {
        font-weight: 600;
        color: var(--neutral-dark);
    }
    .review-rating {
        color: var(--accent);
        font-weight: 600;
    }
    .review-date {
        font-size: 0.8rem;
        color: #6b7280;
    }
    .review-content {
        color: #4b5563;
        line-height: 1.6;
    }
    .empty-reviews {
        text-align: center;
        padding: 2rem;
        color: #6b7280;
        background: var(--neutral-gray);
        border-radius: 0.75rem;
    }

    @media (max-width: 768px) {
        .product-title { font-size: 1.4rem; }
        .product-price { font-size: 1.6rem; }
        .action-buttons { flex-direction: column; }
        .product-shop-row { flex-direction: column; text-align: center; }
        .shop-actions { width: 100%; }
        .btn-shop-action { flex: 1; justify-content: center; }
    }
</style>

<div class="pdp-container">
    <!-- Breadcrumb -->
    <nav class="breadcrumb-nav">
        <a href="{{ route('buyer.home') }}"><i class="fas fa-home"></i></a>
        <span>/</span>
        <a href="{{ route('buyer.home', ['tab' => 'products']) }}">Produk</a>
        <span>/</span>
        @if($product->category)
            <a href="{{ route('buyer.search', ['category' => $product->category]) }}">{{ ucfirst($product->category) }}</a>
            <span>/</span>
        @endif
        <span>{{ Str::limit($product->name, 30) }}</span>
    </nav>

    <div class="pdp-grid">
        <!-- Left Column: Gallery -->
        <div class="product-gallery">
            <div class="pdp-card">
                <div class="product-main-image">
                    @if($product->image)
                        <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}">
                    @else
                        <i class="fas fa-image no-image"></i>
                    @endif
                </div>
            </div>

            <!-- Description Section (Desktop) -->
            <div class="pdp-card detail-section d-none d-lg-block">
                <h4><i class="fas fa-info-circle me-2"></i>Deskripsi Produk</h4>
                <div class="detail-content">
                    {!! nl2br(e($product->description)) !!}
                </div>
            </div>

            <!-- Food Profile -->
            @php $fp = $product->food_profile ?? []; @endphp
            @if(!empty($fp))
            <div class="pdp-card detail-section d-none d-lg-block">
                <h4><i class="fas fa-utensils me-2"></i>Profil Produk</h4>
                <div class="food-profile-grid">
                    @if(isset($fp['calories']))
                    <div class="food-profile-item">
                        <div class="food-profile-icon">🔥</div>
                        <div class="food-profile-label">Kalori</div>
                        <div class="food-profile-value">{{ $fp['calories'] }}</div>
                    </div>
                    @endif
                    @if(isset($fp['ingredients']))
                    <div class="food-profile-item">
                        <div class="food-profile-icon">🥗</div>
                        <div class="food-profile-label">Bahan</div>
                        <div class="food-profile-value">{{ is_array($fp['ingredients']) ? implode(', ', $fp['ingredients']) : $fp['ingredients'] }}</div>
                    </div>
                    @endif
                    @if(isset($fp['spice_level']))
                    <div class="food-profile-item">
                        <div class="food-profile-icon">🌶️</div>
                        <div class="food-profile-label">Tingkat Pedas</div>
                        <div class="food-profile-value">{{ $fp['spice_level'] }}</div>
                    </div>
                    @endif
                    @if(isset($fp['diet']))
                    <div class="food-profile-item">
                        <div class="food-profile-icon">🥬</div>
                        <div class="food-profile-label">Diet</div>
                        <div class="food-profile-value">{{ is_array($fp['diet']) ? implode(', ', $fp['diet']) : $fp['diet'] }}</div>
                    </div>
                    @endif
                </div>
            </div>
            @endif
        </div>

        <!-- Right Column: Product Info -->
        <div>
            <div class="pdp-card">
                <!-- Badges -->
                <div class="product-badges">
                    <span class="badge-item">
                        <i class="fas fa-box"></i> Produk Fisik
                    </span>
                    @if($product->category)
                    <span class="badge-item category">
                        <i class="fas fa-tag"></i> {{ ucfirst($product->category) }}
                    </span>
                    @endif
                </div>

                <!-- Title -->
                <h1 class="product-title">{{ $product->name }}</h1>

                <!-- Rating Row -->
                <div class="product-rating-row">
                    <div class="rating-stars">
                        @if(($reviewStats['count'] ?? 0) > 0)
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= floor($reviewStats['average']))
                                    <i class="fas fa-star"></i>
                                @elseif($i - 0.5 <= $reviewStats['average'])
                                    <i class="fas fa-star-half-alt"></i>
                                @else
                                    <i class="far fa-star"></i>
                                @endif
                            @endfor
                            <span class="rating-value">{{ number_format($reviewStats['average'], 1) }}</span>
                        @else
                            <i class="far fa-star"></i>
                            <i class="far fa-star"></i>
                            <i class="far fa-star"></i>
                            <i class="far fa-star"></i>
                            <i class="far fa-star"></i>
                            <span class="rating-value">-</span>
                        @endif
                    </div>
                    <span class="rating-count">({{ $reviewStats['count'] ?? 0 }} ulasan)</span>
                </div>

                <!-- Price Box -->
                <div class="product-price-box">
                    <div class="product-price">Rp{{ number_format($displayPrice, 0, ',', '.') }}</div>
                    <div class="product-stock {{ $product->stock < 10 ? 'low' : '' }}">
                        <i class="fas fa-box"></i>
                        @if($product->stock > 10)
                            Stok tersedia: <strong>{{ $product->stock }}</strong> unit
                        @elseif($product->stock > 0)
                            Stok terbatas: <strong>{{ $product->stock }}</strong> unit tersisa
                        @else
                            <span class="text-danger">Stok habis</span>
                        @endif
                    </div>
                </div>

                <!-- Shop Row -->
                <div class="product-shop-row">
                    <div class="shop-logo">
                        @if($product->shop->logo)
                            <img src="{{ asset('storage/'.$product->shop->logo) }}" alt="{{ $product->shop->shop_name }}">
                        @else
                            <i class="fas fa-store text-muted"></i>
                        @endif
                    </div>
                    <div class="shop-info">
                        <div class="shop-name">{{ $product->shop->shop_name ?? $product->shop->name ?? 'Toko' }}</div>
                        <div class="shop-location">
                            <i class="fas fa-map-marker-alt me-1"></i>{{ $product->shop->address ?? 'Lokasi tidak tersedia' }}
                        </div>
                    </div>
                    <div class="shop-actions">
                        <a href="{{ route('buyer.shop.visit', $product->shop->id) }}" class="btn-shop-action btn-shop-visit">
                            <i class="fas fa-store me-1"></i>Kunjungi
                        </a>
                        <a href="{{ route('messages.show', ['user' => $product->shop->user_id, 'shop_id' => $product->shop->id]) }}" class="btn-shop-action btn-shop-chat">
                            <i class="fas fa-comments me-1"></i>Chat
                        </a>
                    </div>
                </div>

                <!-- Variations -->
                @if($product->variations->count() > 0)
                <div class="mb-3">
                    <div class="section-title">Pilih Variasi</div>
                    <div class="variation-list">
                        @foreach($product->variations as $variation)
                        <div class="variation-item {{ $variation->is_default ? 'active' : '' }}" data-variation-id="{{ $variation->id }}" data-price-adj="{{ $variation->price_adjustment }}">
                            <div>{{ $variation->name }}</div>
                            @if((float)$variation->price_adjustment != 0)
                            <div class="variation-price">
                                {{ (float)$variation->price_adjustment > 0 ? '+' : '' }}Rp{{ number_format($variation->price_adjustment, 0, ',', '.') }}
                            </div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Quantity -->
                <div class="quantity-row">
                    <div class="section-title mb-0">Jumlah</div>
                    <div class="quantity-controls">
                        <button type="button" class="qty-btn" onclick="updateQty(-1)">-</button>
                        <input type="number" id="quantity-display" class="qty-input" value="1" min="1" max="{{ $product->stock }}" readonly>
                        <button type="button" class="qty-btn" onclick="updateQty(1)">+</button>
                    </div>
                    <span class="text-muted" style="font-size:0.85rem;">Maks. {{ $product->stock }} unit</span>
                </div>

                <!-- Action Buttons -->
                <form method="POST" action="{{ route('buyer.cart.add', $product) }}" id="add-to-cart-form">
                    @csrf
                    <input type="hidden" name="quantity" id="quantity-input" value="1">
                    <input type="hidden" name="variation_id" id="variation-input" value="{{ $defaultVariation->id ?? '' }}">
                    
                    <div class="action-buttons">
                        <button type="submit" class="btn-action btn-add-cart" {{ $product->stock < 1 ? 'disabled' : '' }}>
                            <i class="fas fa-cart-plus"></i>
                            Tambah Keranjang
                        </button>
                        <button type="submit" name="buy_now" value="1" class="btn-action btn-buy-now" {{ $product->stock < 1 ? 'disabled' : '' }}>
                            <i class="fas fa-bolt"></i>
                            Beli Langsung
                        </button>
                    </div>
                </form>
            </div>

            <!-- Description Section (Mobile) -->
            <div class="pdp-card detail-section d-lg-none">
                <h4><i class="fas fa-info-circle me-2"></i>Deskripsi Produk</h4>
                <div class="detail-content">
                    {!! nl2br(e($product->description)) !!}
                </div>
            </div>

            <!-- Food Profile (Mobile) -->
            @if(!empty($fp))
            <div class="pdp-card detail-section d-lg-none">
                <h4><i class="fas fa-utensils me-2"></i>Profil Produk</h4>
                <div class="food-profile-grid">
                    @if(isset($fp['calories']))
                    <div class="food-profile-item">
                        <div class="food-profile-icon">🔥</div>
                        <div class="food-profile-label">Kalori</div>
                        <div class="food-profile-value">{{ $fp['calories'] }}</div>
                    </div>
                    @endif
                    @if(isset($fp['ingredients']))
                    <div class="food-profile-item">
                        <div class="food-profile-icon">🥗</div>
                        <div class="food-profile-label">Bahan</div>
                        <div class="food-profile-value">{{ is_array($fp['ingredients']) ? implode(', ', $fp['ingredients']) : $fp['ingredients'] }}</div>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            <!-- Reviews Section -->
            <div class="pdp-card detail-section">
                <h4><i class="fas fa-star me-2"></i>Ulasan Pembeli</h4>
                
                @if(($reviewStats['count'] ?? 0) > 0)
                <div class="reviews-summary">
                    <div class="reviews-summary-score">
                        <div class="big-score">{{ number_format($reviewStats['average'], 1) }}</div>
                        <div class="stars">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= floor($reviewStats['average']))
                                    <i class="fas fa-star"></i>
                                @elseif($i - 0.5 <= $reviewStats['average'])
                                    <i class="fas fa-star-half-alt"></i>
                                @else
                                    <i class="far fa-star"></i>
                                @endif
                            @endfor
                        </div>
                    </div>
                    <div>
                        <div style="font-weight:600;">{{ $reviewStats['count'] }} Ulasan</div>
                        <div style="font-size:0.85rem;color:#6b7280;">Dari pembeli yang sudah menyelesaikan pesanan</div>
                    </div>
                </div>
                @endif

                <div class="reviews-list">
                    @forelse($completedReviews as $review)
                    <div class="review-item">
                        <div class="review-header">
                            <div>
                                <span class="review-user">{{ $review->user->name ?? 'Pengguna' }}</span>
                                <span class="review-date ms-2">{{ optional($review->created_at)->format('d M Y') }}</span>
                            </div>
                            <div class="review-rating">
                                <i class="fas fa-star"></i> {{ $review->rating }}/5
                            </div>
                        </div>
                        @if($review->title)
                        <div style="font-weight:600;margin-bottom:0.25rem;">{{ $review->title }}</div>
                        @endif
                        <div class="review-content">{{ $review->comment ?? $review->review }}</div>
                    </div>
                    @empty
                    <div class="empty-reviews">
                        <i class="fas fa-comment-slash" style="font-size:2rem;margin-bottom:0.5rem;display:block;"></i>
                        Belum ada ulasan dari pembeli yang sudah menyelesaikan pesanan.
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function updateQty(change) {
    const input = document.getElementById('quantity-display');
    const hiddenInput = document.getElementById('quantity-input');
    let val = parseInt(input.value) + change;
    const max = parseInt(input.max);
    if (val < 1) val = 1;
    if (val > max) val = max;
    input.value = val;
    hiddenInput.value = val;
}

document.querySelectorAll('.variation-item').forEach(item => {
    item.addEventListener('click', function() {
        document.querySelectorAll('.variation-item').forEach(v => v.classList.remove('active'));
        this.classList.add('active');
        document.getElementById('variation-input').value = this.dataset.variationId;
    });
});
</script>
@endsection
