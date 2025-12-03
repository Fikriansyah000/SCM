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

    /* Product/Service Tabs */
    .product-tabs {
        display: flex;
        gap: 0.5rem;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
    }

    .product-tab {
        padding: 0.65rem 1.5rem;
        border-radius: 999px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.25s ease;
        border: 2px solid transparent;
        font-size: 0.95rem;
    }

    .product-tab.active {
        background: linear-gradient(135deg, var(--primary, #3A7BFF), var(--secondary, #6ECBF9));
        color: white;
    }

    .product-tab:not(.active) {
        background: var(--card-bg, #FFFFFF);
        color: var(--neutral-dark, #1A1F36);
        border-color: #ddd;
    }

    @media (hover: hover) {
        .product-tab:not(.active):hover {
            border-color: var(--primary, #3A7BFF);
            color: var(--primary, #3A7BFF);
            text-decoration: none;
        }
    }

    .product-tab i {
        margin-right: 0.4rem;
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

    /* Flash Sale Section Styles */
    .flash-sale-section {
        background: linear-gradient(180deg, #fff5f5 0%, #ffffff 100%);
        padding: 1.5rem;
        border-radius: 1rem;
        border: 2px solid #fecaca;
        margin-bottom: 2rem;
    }

    .flash-header {
        margin-bottom: 1rem;
    }

    .flash-section-title {
        display: flex;
        align-items: center;
        gap: 0.6rem;
        color: #dc2626;
        font-size: 1.4rem;
    }

    .flash-icon-wrapper {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        background: linear-gradient(135deg, #dc2626, #ef4444);
        border-radius: 50%;
        color: white;
        animation: flashPulse 1.5s ease-in-out infinite;
    }

    .flash-icon-wrapper i {
        font-size: 1rem;
    }

    @keyframes flashPulse {
        0%, 100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(220, 38, 38, 0.4); }
        50% { transform: scale(1.1); box-shadow: 0 0 20px 5px rgba(220, 38, 38, 0.2); }
    }

    .flash-badge {
        background: linear-gradient(135deg, #dc2626, #b91c1c);
        color: white;
        font-size: 0.65rem;
        font-weight: 700;
        padding: 0.25rem 0.6rem;
        border-radius: 999px;
        text-transform: uppercase;
        letter-spacing: 1px;
        animation: flashBadge 1s ease-in-out infinite;
    }

    @keyframes flashBadge {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.7; }
    }

    .flash-see-all {
        color: #dc2626 !important;
        font-weight: 700;
        padding: 0.5rem 1rem;
        background: #fef2f2;
        border-radius: 2rem;
        transition: all 0.3s ease;
    }

    .flash-see-all:hover {
        background: #dc2626;
        color: white !important;
        text-decoration: none;
    }
    
    /* Flash sale cards */
    .flash-banner {
        border-radius: 1rem;
        background: linear-gradient(135deg, #dc2626 0%, #ef4444 25%, #f87171 50%, #ef4444 75%, #dc2626 100%);
        background-size: 200% 200%;
        animation: flashGradient 3s ease infinite;
        color: white;
        padding: 1rem 1.5rem;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        margin-bottom: 1.25rem;
        box-shadow: 0 8px 32px rgba(220, 38, 38, 0.4), 0 0 0 3px rgba(255, 255, 255, 0.2) inset;
        position: relative;
        overflow: hidden;
    }

    .flash-banner::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: linear-gradient(45deg, transparent 30%, rgba(255,255,255,0.1) 50%, transparent 70%);
        animation: flashShine 2s linear infinite;
    }

    @keyframes flashGradient {
        0%, 100% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
    }

    @keyframes flashShine {
        0% { transform: translateX(-100%) rotate(45deg); }
        100% { transform: translateX(100%) rotate(45deg); }
    }

    .flash-title {
        font-weight: 800;
        display: flex;
        align-items: center;
        gap: 0.6rem;
        font-size: 1.15rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        text-shadow: 0 2px 4px rgba(0,0,0,0.2);
        position: relative;
        z-index: 1;
    }

    .flash-title i {
        animation: flashBolt 0.8s ease-in-out infinite;
        font-size: 1.3rem;
    }

    @keyframes flashBolt {
        0%, 100% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.2); opacity: 0.8; }
    }

    .flash-countdown {
        display: flex;
        align-items: center;
        gap: 0.6rem;
        font-weight: 700;
        font-size: 1rem;
        background: rgba(0,0,0,0.25);
        padding: 0.5rem 1rem;
        border-radius: 2rem;
        position: relative;
        z-index: 1;
    }

    .flash-countdown #flash-countdown {
        font-family: 'Courier New', monospace;
        font-size: 1.1rem;
        background: rgba(255,255,255,0.2);
        padding: 0.25rem 0.6rem;
        border-radius: 0.35rem;
        letter-spacing: 2px;
    }

    .flash-sale-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.25rem;
    }
    
    /* Mobile horizontal scroll for flash sale */
    @media (max-width: 768px) {
        .flash-sale-section {
            position: relative;
            overflow: visible;
        }
        
        .flash-sale-grid-wrapper {
            overflow: hidden;
            margin: 0 -1.5rem;
            padding: 0 1.5rem;
        }
        
        .flash-sale-grid {
            display: flex;
            gap: 1rem;
            padding: 0.5rem 0;
            animation: autoScrollFlash 25s linear infinite;
            width: max-content;
        }
        
        .flash-sale-grid:hover {
            animation-play-state: paused;
        }
        
        @keyframes autoScrollFlash {
            0% {
                transform: translateX(0);
            }
            100% {
                transform: translateX(-50%);
            }
        }
        
        .flash-sale-grid .flash-sale-card {
            flex: 0 0 280px;
            min-width: 280px;
            max-width: 280px;
        }
        
        /* Ensure card content doesn't overflow */
        .flash-sale-card .card-link {
            flex-direction: column;
        }
        
        .flash-sale-card .flash-card-media {
            flex: none;
            max-width: 100%;
            width: 100%;
            height: 140px;
        }
        
        .flash-sale-card .flash-card-body {
            padding: 0.75rem;
        }
        
        .flash-sale-card .flash-card-footer {
            padding: 0.5rem 0.75rem 0.75rem;
        }
        
        .flash-sale-card::before {
            top: 10px;
            right: -30px;
            font-size: 0.6rem;
            padding: 0.25rem 2rem;
        }
    }
    
    @media (max-width: 480px) {
        .flash-sale-grid .flash-sale-card {
            flex: 0 0 250px;
            min-width: 250px;
            max-width: 250px;
        }
        
        .flash-sale-card .flash-card-media {
            height: 120px;
        }
        
        .flash-sale-grid {
            animation-duration: 20s;
        }
    }
    
    /* Scroll hint for mobile - hidden since auto scroll */
    .scroll-hint {
        display: none;
    }
    
    /* Flash sale duplicates for infinite scroll */
    .flash-sale-duplicates {
        display: none;
    }
    
    @media (max-width: 768px) {
        .flash-sale-duplicates {
            display: contents;
        }
        
        .flash-sale-grid-wrapper {
            overflow: hidden;
        }
    }
    
    @media (min-width: 769px) {
        .flash-sale-grid-wrapper {
            overflow: visible;
        }
    }

    .flash-sale-card {
        background: var(--card-bg, #FFFFFF);
        border-radius: 1rem;
        border: 2px solid #fecaca;
        box-shadow: 0 8px 24px rgba(220, 38, 38, 0.12);
        overflow: hidden;
        display: flex;
        flex-direction: column;
        min-height: 220px;
        position: relative;
        transition: all 0.3s ease;
    }

    .flash-sale-card::before {
        content: '🔥 FLASH SALE';
        position: absolute;
        top: 12px;
        right: -35px;
        background: linear-gradient(135deg, #dc2626, #ef4444);
        color: white;
        font-size: 0.65rem;
        font-weight: 700;
        padding: 0.3rem 2.5rem;
        transform: rotate(45deg);
        z-index: 10;
        box-shadow: 0 2px 8px rgba(220, 38, 38, 0.4);
        letter-spacing: 0.5px;
    }

    .flash-sale-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 16px 40px rgba(220, 38, 38, 0.2);
        border-color: #f87171;
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
        .flash-card-title {
            font-size: 0.9rem;
        }
        
        .flash-card-pricing .original {
            font-size: 0.75rem;
        }
        
        .flash-card-pricing .discounted {
            font-size: 0.95rem;
        }
        
        .flash-card-benefit {
            font-size: 0.7rem;
        }

        .flash-card-pricing {
            flex-direction: row;
            align-items: baseline;
            gap: 0.5rem;
        }

        .flash-card-pricing .discounted {
            font-size: 1.05rem;
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

    .product-image-link, .product-name-link {
        text-decoration: none;
        color: inherit;
    }

    .product-image-link:hover, .product-name-link:hover {
        text-decoration: none;
    }

    .product-type-badge {
        position: absolute;
        top: 0.5rem;
        left: 0.5rem;
        padding: 0.25rem 0.6rem;
        border-radius: 0.35rem;
        font-size: 0.75rem;
        font-weight: 600;
        z-index: 5;
    }

    .service-badge {
        background: linear-gradient(135deg, #1565c0, #42a5f5);
        color: white;
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
                {{-- Tab filter buttons using server-side filtering --}}
                <div style="display:inline-block;">
                    <a href="{{ route('buyer.home', ['tab' => 'all']) }}" 
                       class="btn btn-sm {{ ($tab ?? 'all') === 'all' ? 'btn-primary' : 'btn-outline-primary' }} me-1">
                        Semua
                    </a>
                    <a href="{{ route('buyer.home', ['tab' => 'products']) }}" 
                       class="btn btn-sm {{ ($tab ?? 'all') === 'products' ? 'btn-primary' : 'btn-outline-primary' }} me-1">
                        Produk
                    </a>
                    <a href="{{ route('buyer.home', ['tab' => 'services']) }}" 
                       class="btn btn-sm {{ ($tab ?? 'all') === 'services' ? 'btn-primary' : 'btn-outline-primary' }}">
                        Layanan
                    </a>
                </div>
            </div>
        </div>
        
        <div class="categories-grid">
            <a href="{{ route('buyer.home', ['tab' => 'products']) }}" class="category-card">
                <div class="category-icon">🍜</div>
                <div class="category-name">Produk</div>
            </a>
            <a href="{{ route('buyer.home', ['tab' => 'services']) }}" class="category-card">
                <div class="category-icon">🛠️</div>
                <div class="category-name">Layanan</div>
            </a>
        </div>
    </div>
    
    <!-- Flash Sale Section -->
    <div class="category-section flash-sale-section">
        <div class="section-header flash-header">
            <h3 class="section-title flash-section-title">
                <span class="flash-icon-wrapper">
                    <i class="fas fa-bolt"></i>
                </span>
                Flash Sale
                <span class="flash-badge">HOT</span>
            </h3>
            <a href="#" class="see-all-link flash-see-all">Lihat Semua <i class="fas fa-arrow-right ms-1"></i></a>
        </div>

        <div class="flash-banner" data-ends="{{ $flashEnds ?? session('flash_sale_ends_at') }}">
            <div class="flash-title"><i class="fas fa-bolt"></i> FLASH SALE — Terbatas!</div>
            <div class="flash-countdown">
                <span>⏰ Berakhir dalam:</span>
                <span id="flash-countdown">--:--:--</span>
            </div>
        </div>

        <div class="flash-sale-grid-wrapper">
        <div class="flash-sale-grid">
            @if(!empty($flashProducts) && $flashProducts->count() > 0)
                @foreach($flashProducts as $fp)
                    @php
                        $orig = $fp->price;
                        $discounted = round($orig * 0.90);
                        $isFlashService = ($fp->product_type ?? 'food') === 'service';
                    @endphp
                    <div class="flash-sale-card">
                        <a href="{{ route('buyer.products.show', $fp->id) }}" class="card-link">
                            <div class="flash-card-media">
                                @if($fp->image)
                                    <img src="{{ asset('storage/' . $fp->image) }}" alt="{{ $fp->name }}">
                                @else
                                    <i class="fas {{ $isFlashService ? 'fa-concierge-bell' : 'fa-image' }}" style="font-size:2rem; color:{{ $isFlashService ? '#667eea' : '#ddd' }};"></i>
                                @endif
                                @if($isFlashService)
                                <span style="position:absolute;top:0.35rem;left:0.35rem;background:linear-gradient(135deg,#667eea,#764ba2);color:#fff;font-size:0.65rem;font-weight:600;padding:0.2rem 0.4rem;border-radius:999px;">
                                    <i class="fas fa-concierge-bell"></i> Layanan
                                </span>
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
                            @if($isFlashService)
                            <a href="{{ route('buyer.products.show', $fp->id) }}" class="btn-add-cart" style="display:block;text-decoration:none;text-align:center;background:linear-gradient(135deg,#667eea,#764ba2);">
                                <i class="fas fa-file-signature me-1"></i>Lihat & Pesan
                            </a>
                            @else
                            <form method="POST" action="{{ route('buyer.cart.add', $fp->id) }}">
                                @csrf
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="btn-add-cart">Tambah Keranjang</button>
                            </form>
                            @endif
                        </div>
                    </div>
                @endforeach
                {{-- Duplicate cards for infinite scroll effect on mobile --}}
                <div class="flash-sale-duplicates d-md-none">
                @foreach($flashProducts as $fp)
                    @php
                        $orig = $fp->price;
                        $discounted = round($orig * 0.90);
                        $isFlashService = ($fp->product_type ?? 'food') === 'service';
                    @endphp
                    <div class="flash-sale-card">
                        <a href="{{ route('buyer.products.show', $fp->id) }}" class="card-link">
                            <div class="flash-card-media">
                                @if($fp->image)
                                    <img src="{{ asset('storage/' . $fp->image) }}" alt="{{ $fp->name }}">
                                @else
                                    <i class="fas {{ $isFlashService ? 'fa-concierge-bell' : 'fa-image' }}" style="font-size:2rem; color:{{ $isFlashService ? '#667eea' : '#ddd' }};"></i>
                                @endif
                                @if($isFlashService)
                                <span style="position:absolute;top:0.35rem;left:0.35rem;background:linear-gradient(135deg,#667eea,#764ba2);color:#fff;font-size:0.65rem;font-weight:600;padding:0.2rem 0.4rem;border-radius:999px;">
                                    <i class="fas fa-concierge-bell"></i> Layanan
                                </span>
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
                            @if($isFlashService)
                            <a href="{{ route('buyer.products.show', $fp->id) }}" class="btn-add-cart" style="display:block;text-decoration:none;text-align:center;background:linear-gradient(135deg,#667eea,#764ba2);">
                                <i class="fas fa-file-signature me-1"></i>Lihat & Pesan
                            </a>
                            @else
                            <form method="POST" action="{{ route('buyer.cart.add', $fp->id) }}">
                                @csrf
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="btn-add-cart">Tambah Keranjang</button>
                            </form>
                            @endif
                        </div>
                    </div>
                @endforeach
                </div>
            @else
                <div class="category-card">Tidak ada flash sale saat ini</div>
            @endif
        </div>
        </div>
    </div>
    
    <!-- Products Section -->
    <div class="category-section">
        <!-- Product/Service Tabs -->
        <div class="product-tabs">
            <a href="{{ route('buyer.home', array_merge(request()->except('tab'), ['tab' => 'all'])) }}" 
               class="product-tab {{ ($tab ?? 'all') === 'all' ? 'active' : '' }}">
                <i class="fas fa-th-large"></i>Semua
            </a>
            <a href="{{ route('buyer.home', array_merge(request()->except('tab'), ['tab' => 'products'])) }}" 
               class="product-tab {{ ($tab ?? 'all') === 'products' ? 'active' : '' }}">
                <i class="fas fa-box"></i>Produk
            </a>
            <a href="{{ route('buyer.home', array_merge(request()->except('tab'), ['tab' => 'services'])) }}" 
               class="product-tab {{ ($tab ?? 'all') === 'services' ? 'active' : '' }}">
                <i class="fas fa-concierge-bell"></i>Layanan
            </a>
        </div>

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
                    $isService = ($product->product_type ?? 'food') === 'service';
                @endphp
                <div class="product-card">
                    <a href="{{ route('buyer.products.show', $product->id) }}" class="product-image-link">
                        <div class="product-image">
                            @if($isService)
                                <span class="product-type-badge service-badge">
                                    <i class="fas fa-concierge-bell"></i> Layanan
                                </span>
                            @endif
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                            @else
                                <i class="fas {{ $isService ? 'fa-concierge-bell' : 'fa-image' }}" style="font-size: 3rem; color: #ddd;"></i>
                            @endif
                        </div>
                    </a>
                    <div class="product-body">
                        <a href="{{ route('buyer.products.show', $product->id) }}" class="product-name-link">
                            <h5 class="product-name">{{ $product->name }}</h5>
                        </a>
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
                        @if($isService)
                            <div class="product-stock">
                                <i class="fas fa-clock me-1"></i>{{ $product->service_profile['duration_minutes'] ?? '60' }} menit
                            </div>
                            <a href="{{ route('buyer.products.show', $product->id) }}" class="btn-add-cart">
                                <i class="fas fa-calendar-check me-1"></i>Lihat & Pesan
                            </a>
                        @else
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
                        @endif
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
// Flash countdown
document.addEventListener('DOMContentLoaded', function(){
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
