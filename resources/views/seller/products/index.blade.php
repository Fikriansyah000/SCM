@extends('layouts.app')

@section('title', 'Produk Saya - PestiMart')

@section('content')
<style>
    .products-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 2rem 0;
        margin-bottom: 2rem;
    }
    
    .header-controls {
        display: flex;
        gap: 1rem;
        margin-top: 1rem;
        flex-wrap: wrap;
    }
    
    .filter-tabs {
        display: flex;
        gap: 0.5rem;
    }
    
    .filter-btn {
        background: rgba(255,255,255,0.2);
        color: white;
        border: 2px solid transparent;
        padding: 0.5rem 1rem;
        border-radius: 2rem;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.3s ease;
        font-size: 0.9rem;
    }
    
    .filter-btn:hover,
    .filter-btn.active {
        background: white;
        color: #667eea;
        border-color: white;
    }
    
    .btn-add-product {
        background: white;
        color: #667eea;
        padding: 0.5rem 1.5rem;
        border: none;
        border-radius: 2rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        font-size: 0.9rem;
    }
    
    .btn-add-product:hover {
        transform: translateY(-2px);
        text-decoration: none;
        color: #667eea;
    }
    
    .products-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 1.5rem;
    }
    
    .product-card {
        background: white;
        border-radius: 0.75rem;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
    }
    
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0,0,0,0.15);
    }
    
    .product-image {
        height: 150px;
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
        padding: 1rem;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }
    
    .product-name {
        font-weight: 600;
        color: #333;
        margin-bottom: 0.5rem;
        font-size: 0.95rem;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    
    .product-category {
        font-size: 0.8rem;
        color: #999;
        margin-bottom: 0.75rem;
    }
    
    .product-price {
        font-size: 1.1rem;
        font-weight: 700;
        color: #667eea;
        margin-bottom: 0.5rem;
    }
    
    .product-stock {
        font-size: 0.85rem;
        color: #999;
        margin-bottom: 1rem;
    }
    
    .product-actions {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        gap: 0.5rem;
        margin-top: auto;
    }
    
    .action-btn {
        padding: 0.5rem;
        background: white;
        border: 1px solid #ddd;
        border-radius: 0.4rem;
        cursor: pointer;
        font-size: 0.8rem;
        font-weight: 600;
        transition: all 0.3s ease;
        text-decoration: none;
        color: #667eea;
    }
    
    .action-btn:hover {
        background: #667eea;
        color: white;
        border-color: #667eea;
    }
    
    .action-btn.delete {
        color: #f5576c;
    }
    
    .action-btn.delete:hover {
        background: #f5576c;
        color: white;
        border-color: #f5576c;
    }
    
    .empty-products {
        text-align: center;
        padding: 3rem;
        background: white;
        border-radius: 0.75rem;
    }
    
    .empty-products i {
        font-size: 3rem;
        color: #ddd;
        margin-bottom: 1rem;
    }

    .product-type-badge {
        position: absolute;
        top: 0.5rem;
        left: 0.5rem;
        padding: 0.25rem 0.6rem;
        border-radius: 0.35rem;
        font-size: 0.7rem;
        font-weight: 600;
        z-index: 5;
    }

    .badge-service {
        background: linear-gradient(135deg, #1565c0, #42a5f5);
        color: white;
    }

    .badge-product {
        background: #e8f5e9;
        color: #2e7d32;
    }

    .product-type-icon {
        display: flex;
        align-items: center;
        gap: 0.35rem;
        font-size: 0.8rem;
        color: #666;
        margin-bottom: 0.5rem;
    }
</style>

<div class="products-header">
    <div class="container">
        <h2>
            <i class="fas fa-box me-2"></i>Produk Saya
        </h2>
        <div class="header-controls">
            <div class="filter-tabs">
                <button class="filter-btn active">Stok</button>
                <button class="filter-btn">Arsip</button>
            </div>
            <a href="{{ route('seller.products.create') }}" class="btn-add-product">
                <i class="fas fa-plus me-2"></i>Tambahkan produk baru
            </a>
        </div>
    </div>
</div>

<div class="container my-4">
    @if($products->count() > 0)
        <div class="products-container">
            @foreach($products as $product)
            @php $isService = ($product->product_type ?? 'food') === 'service'; @endphp
            <div class="product-card">
                <div class="product-image">
                    <span class="product-type-badge {{ $isService ? 'badge-service' : 'badge-product' }}">
                        <i class="fas {{ $isService ? 'fa-concierge-bell' : 'fa-box' }}"></i>
                        {{ $isService ? 'Layanan' : 'Produk' }}
                    </span>
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                    @else
                        <i class="fas fa-image" style="font-size: 2rem; color: #ddd;"></i>
                    @endif
                </div>
                <div class="product-body">
                    <h5 class="product-name">{{ $product->name }}</h5>
                    <div class="product-category">{{ $product->category }}</div>
                    <div class="product-price">
                        Rp{{ number_format($product->price, 0, ',', '.') }}
                    </div>
                    @if($isService)
                        <div class="product-type-icon">
                            <i class="fas fa-clock"></i>
                            {{ $product->service_profile['duration_minutes'] ?? '60' }} menit
                            @if($product->requires_booking)
                                <span style="color:#1565c0;">• Slot</span>
                            @endif
                        </div>
                    @else
                        <div class="product-stock">
                            <i class="fas fa-box me-1"></i>Stok: {{ $product->stock }}
                        </div>
                    @endif
                    <div class="product-actions">
                        <button class="action-btn" title="Arsipkan">
                            <i class="fas fa-archive"></i> Arsipkan
                        </button>
                        <a href="{{ route('seller.products.edit', $product->id) }}" class="action-btn" title="Ubah">
                            <i class="fas fa-edit"></i> Ubah
                        </a>
                        <form method="POST" action="{{ route('seller.products.destroy', $product->id) }}" style="display: contents;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="action-btn delete" onclick="return confirm('Yakin hapus?')" title="Hapus">
                                <i class="fas fa-trash"></i> Hapus
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
        <div class="empty-products">
            <i class="fas fa-box"></i>
            <h4>Belum Ada Produk</h4>
            <p class="text-muted mb-3">Mulai tambahkan produk ke toko Anda</p>
            <a href="{{ route('seller.products.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Tambah Produk Pertama
            </a>
        </div>
    @endif
</div>
@endsection
