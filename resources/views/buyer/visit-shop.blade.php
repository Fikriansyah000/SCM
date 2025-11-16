@extends('layouts.app')

@section('title', $shop->shop_name . ' - PestiMart')

@section('content')
<style>
    .shop-header {
        background: white;
        border-bottom: 2px solid #f0f0f0;
        padding: 2rem 0;
        margin-bottom: 2rem;
    }
    
    .shop-banner {
        height: 200px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 0.75rem;
        margin-bottom: 1.5rem;
        position: relative;
        overflow: hidden;
    }
    
    .shop-banner img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .shop-logo {
        width: 120px;
        height: 120px;
        background: white;
        border-radius: 0.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        position: absolute;
        bottom: -60px;
        left: 2rem;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        overflow: hidden;
        border: 3px solid white;
    }
    
    .shop-logo img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .shop-logo .no-logo {
        font-size: 2rem;
        color: #ddd;
    }
    
    .shop-info {
        margin-top: 3rem;
        padding-left: 140px;
    }
    
    .shop-name {
        font-size: 1.8rem;
        font-weight: 700;
        color: #333;
        margin-bottom: 0.5rem;
    }
    
    .shop-meta {
        display: flex;
        gap: 2rem;
        color: #666;
        font-size: 0.95rem;
    }
    
    .shop-meta-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .shop-description {
        margin-top: 1rem;
        padding: 1rem;
        background: #f8f9fa;
        border-left: 4px solid #667eea;
        border-radius: 0.5rem;
        color: #666;
    }
    
    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
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
        height: 200px;
        background: #f0f0f0;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }
    
    .product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .product-body {
        flex-grow: 1;
        padding: 1.25rem;
        display: flex;
        flex-direction: column;
    }
    
    .product-name {
        font-weight: 600;
        color: #333;
        margin-bottom: 0.5rem;
        line-height: 1.3;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }
    
    .product-description {
        font-size: 0.85rem;
        color: #666;
        margin-bottom: 0.75rem;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }
    
    .product-footer {
        margin-top: auto;
    }
    
    .product-price {
        font-size: 1.3rem;
        font-weight: 700;
        color: #667eea;
        margin-bottom: 0.75rem;
    }
    
    .product-stock {
        font-size: 0.85rem;
        color: #999;
        margin-bottom: 1rem;
    }
    
    .btn-add-cart {
        width: 100%;
        padding: 0.75rem;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        border-radius: 0.5rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .btn-add-cart:hover {
        transform: translateY(-2px);
        text-decoration: none;
        color: white;
    }
    
    .empty-shop {
        text-align: center;
        padding: 3rem;
        color: #999;
    }
    
    .empty-shop i {
        font-size: 3rem;
        color: #ddd;
        margin-bottom: 1rem;
    }
</style>

<div class="shop-header">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="shop-banner">
                    @if($shop->banner)
                        <img src="{{ asset('storage/' . $shop->banner) }}" alt="Banner">
                    @else
                        <div style="width: 100%; height: 100%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);"></div>
                    @endif
                    
                    <div class="shop-logo">
                        @if($shop->logo)
                            <img src="{{ asset('storage/' . $shop->logo) }}" alt="Logo">
                        @else
                            <div class="no-logo">
                                <i class="fas fa-store"></i>
                            </div>
                        @endif
                    </div>
                </div>
                
                <div class="shop-info">
                    <div class="shop-name">{{ $shop->shop_name }}</div>
                    <div class="shop-meta">
                        <div class="shop-meta-item">
                            <i class="fas fa-map-marker-alt"></i>
                            {{ $shop->address }}
                        </div>
                        <div class="shop-meta-item">
                            <i class="fas fa-phone"></i>
                            {{ $shop->phone }}
                        </div>
                        <div class="shop-meta-item">
                            <i class="fas fa-box"></i>
                            {{ $shop->products()->count() }} Produk
                        </div>
                    </div>
                    
                    @if($shop->description)
                    <div class="shop-description">
                        {{ $shop->description }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <h3 class="mb-4">Produk dari {{ $shop->shop_name }}</h3>
    
    @if($shop->products->count() > 0)
        <div class="product-grid">
            @foreach($shop->products as $product)
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
                    <p class="product-description">{{ Str::limit($product->description, 50) }}</p>
                    <p class="product-stock">
                        <i class="fas fa-box me-1"></i>Stok: {{ $product->stock }}
                    </p>
                    <div class="product-footer">
                        <div class="product-price">
                            Rp{{ number_format($product->price, 0, ',', '.') }}
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
            </div>
            @endforeach
        </div>
    @else
        <div class="empty-shop">
            <i class="fas fa-box"></i>
            <h4>Belum Ada Produk</h4>
            <p>Toko ini belum menambahkan produk apapun</p>
        </div>
    @endif
</div>
@endsection
