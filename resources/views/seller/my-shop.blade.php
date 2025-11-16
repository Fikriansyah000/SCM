@extends('layouts.app')

@section('title', 'Toko Saya - PestiMart')

@section('content')
<style>
    .shop-header {
        background: white;
        border-bottom: 2px solid #f0f0f0;
        padding: 2rem 0;
        margin-bottom: 2rem;
    }
    
    .shop-banner {
        height: 250px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 0.75rem;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
    }
    
    .shop-banner img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .shop-banner-overlay {
        position: absolute;
        top: 0;
        right: 0;
        padding: 1rem;
    }
    
    .btn-edit-banner {
        background: white;
        color: #667eea;
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-edit-banner:hover {
        background: #f0f4ff;
    }
    
    .shop-info-section {
        display: flex;
        gap: 2rem;
        align-items: flex-start;
        margin-bottom: 2rem;
    }
    
    .shop-logo {
        width: 150px;
        height: 150px;
        background: white;
        border-radius: 0.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        overflow: hidden;
        flex-shrink: 0;
        border: 3px solid white;
    }
    
    .shop-logo img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .shop-logo .no-logo {
        font-size: 3rem;
        color: #ddd;
    }
    
    .shop-details {
        flex-grow: 1;
    }
    
    .shop-name {
        font-size: 1.8rem;
        font-weight: 700;
        color: #333;
        margin-bottom: 0.75rem;
    }
    
    .shop-detail-item {
        margin-bottom: 1rem;
        color: #666;
    }
    
    .shop-detail-label {
        font-weight: 600;
        display: inline-block;
        width: 100px;
    }
    
    .action-buttons {
        display: flex;
        gap: 1rem;
    }
    
    .btn-action {
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: 0.5rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        text-decoration: none;
        color: white;
    }
    
    .btn-secondary {
        background: white;
        color: #667eea;
        border: 2px solid #667eea;
    }
    
    .btn-secondary:hover {
        background: #f0f4ff;
    }
    
    .products-section {
        background: white;
        padding: 2rem;
        border-radius: 0.75rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    
    .section-title {
        font-size: 1.2rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid #f0f0f0;
    }
    
    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 1.5rem;
    }
    
    .product-card {
        border: 1px solid #e0e0e0;
        border-radius: 0.75rem;
        overflow: hidden;
        transition: all 0.3s ease;
    }
    
    .product-card:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    
    .product-image {
        height: 150px;
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
        padding: 1rem;
    }
    
    .product-name {
        font-weight: 600;
        color: #333;
        margin-bottom: 0.5rem;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    
    .product-price {
        color: #667eea;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }
    
    .product-stock {
        font-size: 0.85rem;
        color: #999;
        margin-bottom: 1rem;
    }
    
    .product-actions {
        display: flex;
        gap: 0.5rem;
    }
    
    .btn-product-action {
        flex: 1;
        padding: 0.5rem;
        border: 1px solid #ddd;
        background: white;
        border-radius: 0.5rem;
        font-size: 0.8rem;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        color: #667eea;
        font-weight: 600;
    }
    
    .btn-product-action:hover {
        background: #667eea;
        color: white;
        border-color: #667eea;
        text-decoration: none;
    }
    
    .btn-delete {
        color: #f5576c;
    }
    
    .btn-delete:hover {
        background: #f5576c;
        color: white;
        border-color: #f5576c;
    }
</style>

<div class="shop-header">
    <div class="container">
        <div class="shop-banner">
            @if($shop->banner)
                <img src="{{ asset('storage/' . $shop->banner) }}" alt="Banner">
            @else
                <div style="width: 100%; height: 100%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);"></div>
            @endif
            <div class="shop-banner-overlay">
                <a href="{{ route('seller.shop.edit') }}" class="btn-edit-banner">
                    <i class="fas fa-edit me-1"></i>Edit
                </a>
            </div>
        </div>
        
        <div class="shop-info-section">
            <div class="shop-logo">
                @if($shop->logo)
                    <img src="{{ asset('storage/' . $shop->logo) }}" alt="Logo">
                @else
                    <div class="no-logo">
                        <i class="fas fa-store"></i>
                    </div>
                @endif
            </div>
            
            <div class="shop-details">
                <h2 class="shop-name">{{ $shop->shop_name }}</h2>
                <div class="shop-detail-item">
                    <span class="shop-detail-label"><i class="fas fa-map-marker-alt me-1"></i>Alamat:</span>
                    {{ $shop->address }}
                </div>
                <div class="shop-detail-item">
                    <span class="shop-detail-label"><i class="fas fa-phone me-1"></i>Telepon:</span>
                    {{ $shop->phone }}
                </div>
                <div class="shop-detail-item">
                    <span class="shop-detail-label"><i class="fas fa-info-circle me-1"></i>Status:</span>
                    <span class="badge bg-success">{{ ucfirst($shop->status) }}</span>
                </div>
                <div class="mt-3">
                    <p><strong>Deskripsi:</strong></p>
                    <p class="text-muted">{{ $shop->description }}</p>
                </div>
                <div class="action-buttons mt-3">
                    <a href="{{ route('seller.shop.edit') }}" class="btn-action btn-primary">
                        <i class="fas fa-edit me-1"></i>Edit Toko
                    </a>
                    <a href="{{ route('seller.products.create') }}" class="btn-action btn-secondary">
                        <i class="fas fa-plus me-1"></i>Tambah Produk
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container my-4">
    <div class="products-section">
        <div class="section-title">
            <i class="fas fa-box me-2"></i>Produk Toko
            <span class="badge bg-primary ms-2">{{ $products->total() }}</span>
        </div>
        
        @if($products->count() > 0)
            <div class="product-grid">
                @foreach($products as $product)
                <div class="product-card">
                    <div class="product-image">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                        @else
                            <i class="fas fa-image" style="font-size: 2rem; color: #ddd;"></i>
                        @endif
                    </div>
                    <div class="product-body">
                        <h5 class="product-name">{{ $product->name }}</h5>
                        <div class="product-price">Rp{{ number_format($product->price, 0, ',', '.') }}</div>
                        <div class="product-stock">Stok: {{ $product->stock }}</div>
                        <div class="product-actions">
                            <a href="{{ route('seller.products.edit', $product->id) }}" class="btn-product-action">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form method="POST" action="{{ route('seller.products.destroy', $product->id) }}" style="flex: 1;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-product-action btn-delete w-100" onclick="return confirm('Yakin hapus produk ini?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <div class="mt-4">
                {{ $products->links('pagination::bootstrap-5') }}
            </div>
        @else
            <div style="text-align: center; padding: 3rem;">
                <i class="fas fa-box" style="font-size: 3rem; color: #ddd; margin-bottom: 1rem; display: block;"></i>
                <h5>Belum Ada Produk</h5>
                <p class="text-muted mb-3">Mulai tambahkan produk ke toko Anda</p>
                <a href="{{ route('seller.products.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Tambah Produk Pertama
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
