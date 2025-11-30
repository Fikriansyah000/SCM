@extends('layouts.app')

@section('title', 'Belanja - PestiMart')

@section('content')
<style>
    .hero-banner {
        background: linear-gradient(90deg, rgba(166,189,213,0.95) 0%, rgba(230,240,250,0.9) 100%);
        color: #0a4c8c;
        padding: 2rem 0;
        margin-bottom: 2rem;
        border-radius: 0.75rem;
        overflow: hidden;
        border: 1px solid rgba(10,76,140,0.04);
        box-shadow: 0 4px 18px rgba(10,76,140,0.035);
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
        background: white;
        border-radius: 0.75rem;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
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
        background: rgba(166, 189, 213, 0.95);
        color: #0a4c8c;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 0.5rem;
        cursor: pointer;
        font-weight: 600;
    }
    
    .search-form .btn:hover {
        text-decoration: none;
        color: white;
    }
    
    .category-section {
        margin-bottom: 2rem;
    }
    
    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }
    
    .section-title {
        font-size: 1.3rem;
        font-weight: 700;
        color: #333;
    }
    
    .see-all-link {
        color: #667eea;
        text-decoration: none;
        font-weight: 600;
    }
    
    .see-all-link:hover {
        text-decoration: underline;
    }
    
    .categories-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 1rem;
        margin-bottom: 2rem;
    }
    
    .category-card {
        background: linear-gradient(180deg, #faf6f1 0%, #f5f0eb 100%);
        border-radius: 0.75rem;
        padding: 1.25rem;
        text-align: center;
        cursor: pointer;
        transition: transform 0.25s ease, box-shadow 0.25s ease;
        box-shadow: 0 8px 20px rgba(139,113,89,0.06);
        border: 1px solid rgba(139,113,89,0.08);
        text-decoration: none;
        color: #333;
    }
    
    .category-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 30px rgba(7,18,46,0.08);
        text-decoration: none;
        color: #4f6ed9;
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
        background: #ff6700;
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
        background: #faf6f1;
        border: 1px solid rgba(139,113,89,0.08);
        box-shadow: 0 12px 32px rgba(139,113,89,0.06);
    }
    
    .product-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 18px 46px rgba(7,18,46,0.06);
    }
    
    .product-image {
        height: 180px;
        background: linear-gradient(180deg, #f0ede8 0%, #e8e2da 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        position: relative;
        border-bottom: 1px solid rgba(139,113,89,0.08);
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
        color: #333;
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
        color: #ffc107;
    }
    
    .product-rating .stars i {
        font-size: 0.75rem;
    }
    
    .product-rating .rating-value {
        font-weight: 600;
        color: #333;
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
        color: #667eea;
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
        background: linear-gradient(90deg, rgba(166,189,213,0.98) 0%, rgba(120,160,210,0.95) 100%);
        color: #06385f;
        border: 0;
        border-radius: 0.45rem;
        font-weight: 600;
        cursor: pointer;
        transition: transform 0.15s ease, box-shadow 0.15s ease;
        margin-top: auto;
        box-shadow: 0 6px 16px rgba(102,126,234,0.09);
    }
    
    .btn-add-cart:hover {
        transform: translateY(-2px);
        text-decoration: none;
        color: white;
        box-shadow: 0 10px 30px rgba(102,126,234,0.12);
    }

    /* Flash card visual tweak */
    .category-card.flash {
        border: 1px solid rgba(255,77,79,0.12);
        box-shadow: 0 12px 32px rgba(255,77,79,0.08);
        background: linear-gradient(180deg, #fff5f3 0%, #faf6f1 100%);
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

        <div class="flash-banner" data-ends="{{ $flashEnds ?? session('flash_sale_ends_at') }}" style="margin-bottom:1rem;">
            <div style="display:flex;align-items:center;justify-content:space-between;gap:1rem;padding:0.75rem 1rem;border-radius:0.5rem;background:linear-gradient(90deg,#ff4d4f,#ff7675);color:white;">
                <div style="font-weight:700;display:flex;align-items:center;gap:0.5rem;"><i class="fas fa-bolt"></i> FLASH SALE — Terbatas!</div>
                <div style="display:flex;align-items:center;gap:0.75rem;">
                    <div style="font-size:0.95rem;opacity:0.95;">Waktu tersisa:</div>
                    <div id="flash-countdown" style="font-weight:700;font-family:monospace;">--:--:--</div>
                </div>
            </div>
        </div>

        <div class="categories-grid">
            @if(!empty($flashProducts) && $flashProducts->count() > 0)
                @foreach($flashProducts as $fp)
                    @php
                        $orig = $fp->price;
                        $discounted = round($orig * 0.90);
                    @endphp
                    <div class="category-card flash" style="padding:0; overflow:hidden;">
                        <a href="{{ route('buyer.shop.visit', $fp->shop->id) }}" style="display:block; text-decoration:none; color:inherit;">
                            <div style="display:flex; gap:0;">
                                <div style="flex:0 0 140px; height:100px; background:#f7f7f7; display:flex; align-items:center; justify-content:center;">
                                    @if($fp->image)
                                        <img src="{{ asset('storage/' . $fp->image) }}" style="width:100%; height:100%; object-fit:cover;" alt="{{ $fp->name }}">
                                    @else
                                        <i class="fas fa-image" style="font-size:2rem; color:#ddd;"></i>
                                    @endif
                                </div>
                                <div style="padding:0.75rem; flex:1;">
                                    <div style="font-weight:700; margin-bottom:0.25rem;">{{ Str::limit($fp->name, 40) }}</div>
                                    <div style="font-size:0.85rem; color:#999;">{{ $fp->shop->shop_name }}</div>
                                    <div style="margin-top:0.5rem;">
                                        <span style="color:#999; text-decoration:line-through; margin-right:0.5rem;">Rp{{ number_format($orig,0,',','.') }}</span>
                                        <span style="color:#ff4d4f; font-weight:700;">Rp{{ number_format($discounted,0,',','.') }}</span>
                                    </div>
                                    <div style="font-size:0.8rem; color:#28a745; margin-top:0.4rem;">Diskon 10% • Gratis Ongkir</div>
                                </div>
                            </div>
                        </a>
                        <div style="padding:0.5rem; text-align:center; background:#fff;">
                            <form method="POST" action="{{ route('buyer.cart.add', $fp->id) }}">
                                @csrf
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="btn-add-cart" style="padding:0.5rem 1rem;">Tambah Keranjang</button>
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
