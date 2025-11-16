@extends('layouts.app')

@section('title', 'Belanja - PestiMart')

@section('content')
<style>
    .hero-banner {
        background: rgba(166, 189, 213, 0.95);
        color: #0a4c8c;
        padding: 2rem 0;
        margin-bottom: 2rem;
        border-radius: 0.75rem;
        overflow: hidden;
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
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 1rem;
        margin-bottom: 2rem;
    }
    
    .category-card {
        background: white;
        border-radius: 0.75rem;
        padding: 1.5rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        text-decoration: none;
        color: #333;
    }
    
    .category-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0,0,0,0.15);
        text-decoration: none;
        color: #667eea;
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
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    
    .product-card {
        border: none;
        border-radius: 0.75rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        overflow: hidden;
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
        height: 100%;
    }
    
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0,0,0,0.15);
    }
    
    .product-image {
        height: 180px;
        background: #f0f0f0;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        position: relative;
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
        padding: 0.75rem;
        background: rgba(166, 189, 213, 0.95);
        color: #0a4c8c;
        border: none;
        border-radius: 0.5rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-top: auto;
    }
    
    .btn-add-cart:hover {
        transform: translateY(-2px);
        text-decoration: none;
        color: white;
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
    
    <!-- Categories Section -->
    <div class="category-section">
        <div class="section-header">
            <h3 class="section-title">
                <i class="fas fa-th me-2"></i>Kategori
            </h3>
            <a href="#" class="see-all-link">Lihat Semua</a>
        </div>
        
        <div class="categories-grid">
            <a href="#" class="category-card">
                <div class="category-icon">🍜</div>
                <div class="category-name">Makanan & Minuman</div>
            </a>
            <a href="#" class="category-card">
                <div class="category-icon">🖨️</div>
                <div class="category-name">Jasa Print & Fotocopy</div>
            </a>
            <a href="#" class="category-card">
                <div class="category-icon">📚</div>
                <div class="category-name">Buku & Alat Tulis</div>
            </a>
            <a href="#" class="category-card">
                <div class="category-icon">💻</div>
                <div class="category-name">Elektronik & Gadget</div>
            </a>
            <a href="#" class="category-card">
                <div class="category-icon">👕</div>
                <div class="category-name">Fashion</div>
            </a>
            <a href="#" class="category-card">
                <div class="category-icon">🎓</div>
                <div class="category-name">Jasa Akademik</div>
            </a>
        </div>
    </div>
    
    <!-- Promo Banner -->
    <div class="promo-banner">
        <div class="promo-title">
            <i class="fas fa-shipping-fast me-2"></i>Gratis Ongkir Kampus!
        </div>
        <div class="promo-subtitle">Minimal pembelian Rp 50.000 untuk area kampus</div>
    </div>
    
    <!-- Services Section -->
    <div class="category-section">
        <div class="section-header">
            <h3 class="section-title">
                <i class="fas fa-concierge-bell me-2"></i>Layanan Kampus
            </h3>
            <a href="#" class="see-all-link">Lihat Semua</a>
        </div>
        
        <div class="categories-grid">
            <div class="category-card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                <div class="category-icon">🖨️</div>
                <div class="category-name">Print & Fotocopy</div>
                <small>Print dokumen dengan harga murah</small>
            </div>
            <div class="category-card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white;">
                <div class="category-icon">✍️</div>
                <div class="category-name">Joki Tugas</div>
                <small>Bantuan mengerjakan tugas kuliah</small>
            </div>
            <div class="category-card" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white;">
                <div class="category-icon">🎯</div>
                <div class="category-name">Les Privat</div>
                <small>Bimbingan belajar mata kuliah</small>
            </div>
            <div class="category-card" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); color: white;">
                <div class="category-icon">📷</div>
                <div class="category-name">Jasa Fotografi</div>
                <small>Foto untuk kebutuhan akademik</small>
            </div>
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
                <div class="product-card">
                    <div class="product-image">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                        @else
                            <i class="fas fa-image" style="font-size: 3rem; color: #ddd;"></i>
                        @endif
                    </div>
                    <div class="product-body">
                        <h5 class="product-name">{{ $product->name }}</h5>
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
@endsection
