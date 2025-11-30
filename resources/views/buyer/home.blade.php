@extends('layouts.app')

@section('title', 'Belanja - PestiMart')

@section('content')
<style>
    .hero-banner {
        background: linear-gradient(135deg, var(--primary, #3A7BFF) 0%, var(--secondary, #6ECBF9) 100%);
        color: white;
        padding: 2rem 0;
        margin-bottom: 2rem;
        border-radius: 0.75rem;
        overflow: hidden;
        box-shadow: 0 4px 18px rgba(58, 123, 255, 0.15);
    }
    
    .hero-content {
        margin-left: 30px;
        gap: 2rem;
    }
    
    .hero-text h2 {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 1rem;
    }
    
    .hero-text p {
        font-size: 1rem;
        opacity: 0.9;
        margin-bottom: 1.5rem;
    }
    
    .search-container {
        background: var(--card-bg, #FFFFFF);
        border-radius: 0.75rem;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }
    
    .search-form .input-group {
        display: flex;
        gap: 0.5rem;
    }
    
    .search-form .form-control {
        border-radius: 0.5rem;
        border: 1px solid #ddd;
        padding: 0.75rem;
        flex: 1;
    }
    
    .search-form .btn {
        background: linear-gradient(135deg, var(--primary, #3A7BFF), var(--secondary, #6ECBF9));
        color: white;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 0.5rem;
        cursor: pointer;
        font-weight: 600;
    }
    
    @media (hover: hover) {
        .search-form .btn:hover {
            filter: brightness(1.05);
            text-decoration: none;
            color: white;
        }
    }
    
    .category-section {
        margin-bottom: 2rem;
    }
    
    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
        gap: 1rem;
    }
    
    .section-title {
        font-size: 1.3rem;
        font-weight: 700;
        color: var(--neutral-dark, #1A1F36);
    }
    
    .see-all-link {
        color: var(--primary, #3A7BFF);
        text-decoration: none;
        font-weight: 600;
    }
    
    @media (hover: hover) {
        .see-all-link:hover {
            text-decoration: underline;
        }
    }
    
    .categories-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 1rem;
        margin-bottom: 2rem;
    }
    
    .category-card {
        background: var(--card-bg, #FFFFFF);
        border-radius: 0.75rem;
        padding: 1.25rem;
        text-align: center;
        cursor: pointer;
        transition: transform 0.25s ease, box-shadow 0.25s ease;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        border: 1px solid var(--neutral-gray, #ECEEF3);
        text-decoration: none;
        color: var(--neutral-dark, #1A1F36);
    }
    
    @media (hover: hover) {
        .category-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 30px rgba(0,0,0,0.1);
            text-decoration: none;
            color: var(--primary, #3A7BFF);
        }
    }
    
    .category-icon {
        font-size: 2rem;
        margin-bottom: 0.75rem;
    }
    
    .category-name {
        font-weight: 600;
        font-size: 0.95rem;
    }
    
    .promo-banner {
        background: linear-gradient(135deg, var(--accent, #FF8F3A), #FFB366);
        color: white;
        padding: 1.5rem;
        border-radius: 0.75rem;
        margin-bottom: 2rem;
        text-align: center;
    }
    
    .promo-title {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }
    
    .promo-subtitle {
        font-size: 0.95rem;
        opacity: 0.9;
    }
    
    /* Flash sale cards */
    .flash-banner {
        border-radius: 0.75rem;
        background: linear-gradient(90deg,#ff4d4f,#ff7675);
        color: white;
        padding: 0.85rem 1rem;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 0.75rem;
        margin-bottom: 1rem;
    }

    .flash-title {
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 1rem;
    }

    .flash-countdown {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-weight: 600;
        font-size: 0.95rem;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .flash-sale-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        gap: 1rem;
    }

    .flash-sale-card {
        background: var(--card-bg, #FFFFFF);
        border-radius: 0.85rem;
        border: 1px solid rgba(255, 143, 58, 0.25);
        box-shadow: 0 10px 25px rgba(255, 143, 58, 0.12);
        overflow: hidden;
        display: flex;
        flex-direction: column;
        min-height: 220px;
    }

    .flash-sale-card .card-link {
        display: flex;
        gap: 0;
        text-decoration: none;
        color: inherit;
        flex: 1;
    }

    .flash-card-media {
        flex: 0 0 140px;
        max-width: 160px;
        background: #f7f7f7;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }

    .flash-card-media img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .flash-card-body {
        padding: 0.9rem;
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .flash-card-title {
        font-weight: 700;
        font-size: 0.95rem;
        margin-bottom: 0.2rem;
        color: var(--neutral-dark, #1A1F36);
    }

    .flash-card-shop {
        font-size: 0.85rem;
        color: #9a9a9a;
    }

    .flash-card-pricing {
        margin-top: 0.6rem;
        display: flex;
        flex-direction: column;
        gap: 0.2rem;
        font-size: 0.95rem;
    }

    .flash-card-pricing .original {
        text-decoration: line-through;
        color: rgba(0,0,0,0.4);
        font-size: 0.85rem;
    }

    .flash-card-pricing .discounted {
        color: #ff4d4f;
        font-weight: 700;
        font-size: 1.05rem;
    }

    .flash-card-benefit {
        font-size: 0.8rem;
        color: #28a745;
        margin-top: 0.4rem;
    }

    .flash-card-footer {
        padding: 0.7rem 1rem 1rem;
        background: white;
    }

    .flash-card-footer .btn-add-cart {
        box-shadow: none;
    }

    @media (max-width: 576px) {
        .flash-sale-card .card-link {
            flex-direction: column;
        }

        .flash-card-media {
            width: 100%;
            max-width: 100%;
            height: 150px;
        }

        .flash-card-body {
            padding: 1rem;
        }

        .flash-card-title {
            font-size: 1rem;
        }

        .flash-card-pricing {
            flex-direction: row;
            align-items: baseline;
            gap: 0.5rem;
        }

        .flash-card-pricing .discounted {
            font-size: 1.2rem;
        }
    }

    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 1.25rem;
        margin-bottom: 2rem;
    }
    
    .product-card {
        border-radius: 0.75rem;
        overflow: hidden;
        transition: transform 0.25s ease, box-shadow 0.25s ease;
        display: flex;
        flex-direction: column;
        height: 100%;
        background: var(--card-bg, #FFFFFF);
        border: 1px solid var(--neutral-gray, #ECEEF3);
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }
    
    @media (hover: hover) {
        .product-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 30px rgba(0,0,0,0.12);
        }
    }
    
    .product-image {
        height: 180px;
        background: var(--neutral-gray, #ECEEF3);
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        position: relative;
        border-bottom: 1px solid var(--neutral-gray, #ECEEF3);
    }
    
    .product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .product-body {
        flex-grow: 1;
        padding: 1rem;
        display: flex;
        flex-direction: column;
    }
    
    .product-name {
        font-weight: 600;
        color: var(--neutral-dark, #1A1F36);
        margin-bottom: 0.5rem;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        font-size: 0.95rem;
    }
    
    .product-rating {
        display: flex;
        align-items: center;
        gap: 0.35rem;
        margin-bottom: 0.5rem;
        font-size: 0.85rem;
    }
    
    .product-rating .stars {
        display: flex;
        gap: 0.1rem;
        color: var(--accent, #FF8F3A);
    }
    
    .product-rating .stars i {
        font-size: 0.75rem;
    }
    
    .product-rating .rating-value {
        font-weight: 600;
        color: var(--neutral-dark, #1A1F36);
    }
    
    .product-rating .rating-count {
        color: #999;
        font-size: 0.8rem;
    }
    
    .product-shop {
        font-size: 0.8rem;
        color: #999;
        margin-bottom: 0.75rem;
    }
    
    .product-price {
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--primary, #3A7BFF);
        margin-bottom: 0.75rem;
    }
    
    .product-stock {
        font-size: 0.8rem;
        color: #999;
        margin-bottom: 1rem;
    }
    
    .btn-add-cart {
        width: 100%;
        padding: 0.65rem;
        background: linear-gradient(135deg, var(--primary, #3A7BFF) 0%, var(--secondary, #6ECBF9) 100%);
        color: white;
        border: 0;
        border-radius: 0.45rem;
        font-weight: 600;
        cursor: pointer;
        transition: transform 0.15s ease, box-shadow 0.15s ease;
        margin-top: auto;
        box-shadow: 0 6px 16px rgba(58, 123, 255, 0.15);
    }
    
    @media (hover: hover) {
        .btn-add-cart:hover {
            transform: translateY(-2px);
            text-decoration: none;
            color: white;
            filter: brightness(1.05);
        }
    }

    /* Flash card visual tweak */
    .category-card.flash {
        border: 1px solid rgba(255, 143, 58, 0.2);
        box-shadow: 0 4px 12px rgba(255, 143, 58, 0.1);
        background: linear-gradient(135deg, rgba(255, 143, 58, 0.05) 0%, var(--card-bg, #FFFFFF) 100%);
    }

    /* Responsive refinements */
    @media (max-width: 1200px) {
        .hero-text h2 { font-size: 1.8rem; }
        .product-image { height: 160px; }
    }

    @media (max-width: 768px) {
        .categories-grid { grid-template-columns: repeat(auto-fit, minmax(140px, 1fr)); }
        .product-grid { grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); }
        .hero-content { margin-left: 0; padding: 0 1rem; }
        .hero-banner { padding: 1.25rem 0; }
    }
</style>

<div class="container my-4">
    <!-- Hero Banner -->
    <div class="hero-banner mb-4">
        <div class="hero-content">
            <div class="hero-text">
                <h2>Belanja Kebutuhan Kampusmu</h2>
                <p>Temukan ribuan produk dan layanan dari seller mahasiswa dengan harga terjangkau</p>
            </div>
        </div>
    </div>
    
    <!-- Search Bar -->
    <div class="search-container">
        <form method="GET" action="{{ route('buyer.search') }}" class="search-form">
            <div class="input-group input-group-lg">
                <input type="text" class="form-control" name="q" 
                       placeholder="Cari produk, kategori, atau seller..."
                       value="{{ $search ?? '' }}">
                <button class="btn" type="submit">
                    <i class="fas fa-search"></i> Cari
                </button>
            </div>
        </form>
    </div>
    
    <!-- Categories / Filters Section -->
    <div class="category-section">
        <div class="section-header">
            <h3 class="section-title">
                <i class="fas fa-th me-2"></i>Kategori
            </h3>
            <div>
                <a href="#" class="see-all-link me-3">Lihat Semua</a>
                <!-- Filter buttons: Semua / Makanan / Jasa -->
                <div style="display:inline-block;">
                    <button class="btn btn-sm btn-outline-primary me-1" id="filter-all" onclick="filterProducts('all'); return false;">Semua</button>
                    <button class="btn btn-sm btn-outline-primary me-1" id="filter-makanan" onclick="filterProducts('makanan'); return false;">Makanan & Minuman</button>
                    <button class="btn btn-sm btn-outline-primary" id="filter-jasa" onclick="filterProducts('jasa'); return false;">Jasa</button>
                </div>
            </div>
        </div>
        
        <div class="categories-grid">
            <a href="#" class="category-card" onclick="filterProducts('makanan'); return false;">
                <div class="category-icon">🍜</div>
                <div class="category-name">Makanan & Minuman</div>
            </a>
            <a href="#" class="category-card" onclick="filterProducts('jasa'); return false;">
                <div class="category-icon">🛠️</div>
                <div class="category-name">Jasa</div>
            </a>
        </div>
    </div>
    
    <!-- Flash Sale Section -->
    <div class="category-section">
        <div class="section-header">
            <h3 class="section-title">
                <i class="fas fa-bolt me-2"></i>Flash Sale
            </h3>
            <a href="#" class="see-all-link">Lihat Semua</a>
        </div>

        <div class="flash-banner" data-ends="{{ $flashEnds ?? session('flash_sale_ends_at') }}">
            <div class="flash-title"><i class="fas fa-bolt"></i> FLASH SALE — Terbatas!</div>
            <div class="flash-countdown">
                <span>Waktu tersisa:</span>
                <span id="flash-countdown">--:--:--</span>
            </div>
        </div>

        <div class="flash-sale-grid">
            @if(!empty($flashProducts) && $flashProducts->count() > 0)
                @foreach($flashProducts as $fp)
                    @php
                        $orig = $fp->price;
                        $discounted = round($orig * 0.90);
                    @endphp
                    <div class="flash-sale-card">
                        <a href="{{ route('buyer.shop.visit', $fp->shop->id) }}" class="card-link">
                            <div class="flash-card-media">
                                @if($fp->image)
                                    <img src="{{ asset('storage/' . $fp->image) }}" alt="{{ $fp->name }}">
                                @else
                                    <i class="fas fa-image" style="font-size:2rem; color:#ddd;"></i>
                                @endif
                            </div>
                            <div class="flash-card-body">
                                <div class="flash-card-title">{{ Str::limit($fp->name, 40) }}</div>
                                <div class="flash-card-shop">{{ $fp->shop->shop_name }}</div>
                                <div class="flash-card-pricing">
                                    <span class="original">Rp{{ number_format($orig,0,',','.') }}</span>
                                    <span class="discounted">Rp{{ number_format($discounted,0,',','.') }}</span>
                                </div>
                                <div class="flash-card-benefit">Diskon 10% • Gratis Ongkir</div>
                            </div>
                        </a>
                        <div class="flash-card-footer">
                            <form method="POST" action="{{ route('buyer.cart.add', $fp->id) }}">
                                @csrf
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="btn-add-cart">Tambah Keranjang</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="category-card">Tidak ada flash sale saat ini</div>
            @endif
        </div>
    </div>
    
    <!-- Products Section -->
    <div class="category-section">
        <div class="section-header">
            <h3 class="section-title">
                @if(isset($search))
                    Hasil Pencarian: "{{ $search }}"
                @else
                    <i class="fas fa-tag me-2"></i>Deal Hemat Mahasiswa
                @endif
            </h3>
        </div>
        
        @if($products->count() > 0)
            <div class="product-grid">
                @foreach($products as $product)
                @php
                    // determine coarse type for client-side filtering
                    $prodType = 'other';
                    if(Str::contains($product->category ?? '', 'Makan') || Str::contains($product->category ?? '', 'makan')) {
                        $prodType = 'makanan';
                    } elseif(Str::contains($product->category ?? '', 'Jasa') || Str::contains($product->category ?? '', 'jasa')) {
                        $prodType = 'jasa';
                    }
                @endphp
                <div class="product-card" data-type="{{ $prodType }}">
                    <div class="product-image">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                        @else
                            <i class="fas fa-image" style="font-size: 3rem; color: #ddd;"></i>
                        @endif
                    </div>
                    <div class="product-body">
                        <h5 class="product-name">{{ $product->name }}</h5>
                        <div class="product-rating">
                            <div class="stars">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                            <span class="rating-value">4.5</span>
                            <span class="rating-count">({{ rand(50, 300) }})</span>
                        </div>
                        <a href="{{ route('buyer.shop.visit', $product->shop->id) }}" class="product-shop">
                            <i class="fas fa-store me-1"></i>{{ Str::limit($product->shop->shop_name, 15) }}
                        </a>
                        <div class="product-price">
                            Rp{{ number_format($product->price, 0, ',', '.') }}
                        </div>
                        <div class="product-stock">
                            <i class="fas fa-box me-1"></i>Stok: {{ $product->stock }}
                        </div>
                        <form method="POST" action="{{ route('buyer.cart.add', $product->id) }}" class="d-inline-block w-100">
                            @csrf
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="btn-add-cart">
                                <i class="fas fa-shopping-cart me-1"></i>Tambah Keranjang
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
            
            <div class="d-flex justify-content-center">
                {{ $products->links('pagination::bootstrap-5') }}
            </div>
        @else
            <div style="text-align: center; padding: 3rem; background: white; border-radius: 0.75rem;">
                <i class="fas fa-search" style="font-size: 3rem; color: #ddd; display: block; margin-bottom: 1rem;"></i>
                <h5>Produk Tidak Ditemukan</h5>
                <p class="text-muted">
                    @if(isset($search))
                        Tidak ada produk dengan keyword "{{ $search }}"
                    @else
                        Belum ada produk yang tersedia
                    @endif
                </p>
            </div>
        @endif
    </div>
</div>
<script>
function filterProducts(type) {
    const grid = document.querySelectorAll('.product-card');
    grid.forEach(card => {
        const t = card.getAttribute('data-type') || 'other';
        if (type === 'all') {
            card.style.display = '';
        } else if (type === 'makanan') {
            card.style.display = (t === 'makanan') ? '' : 'none';
        } else if (type === 'jasa') {
            card.style.display = (t === 'jasa') ? '' : 'none';
        }
    });

    // active state for filter buttons
    ['all','makanan','jasa'].forEach(key => {
        const btn = document.getElementById('filter-' + key);
        if (!btn) return;
        if (key === type) {
            btn.classList.remove('btn-outline-primary');
            btn.classList.add('btn-primary');
        } else {
            btn.classList.remove('btn-primary');
            btn.classList.add('btn-outline-primary');
        }
    });
}

// default: show all
document.addEventListener('DOMContentLoaded', function(){
    filterProducts('all');

    // Flash countdown
    const flashBanner = document.querySelector('.flash-banner');
    if (flashBanner) {
        const ends = flashBanner.getAttribute('data-ends');
        const countdownEl = document.getElementById('flash-countdown');
        if (ends && countdownEl) {
            function updateCountdown() {
                const endTime = new Date(ends).getTime();
                const now = new Date().getTime();
                const diff = endTime - now;
                if (diff <= 0) {
                    countdownEl.textContent = '00:00:00';
                    clearInterval(countInterval);
                    return;
                }
                const hours = Math.floor(diff / (1000 * 60 * 60));
                const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((diff % (1000 * 60)) / 1000);
                const pad = v => String(v).padStart(2, '0');
                countdownEl.textContent = pad(hours) + ':' + pad(minutes) + ':' + pad(seconds);
            }
            updateCountdown();
            const countInterval = setInterval(updateCountdown, 1000);
        }
    }

});
</script>
@endsection
