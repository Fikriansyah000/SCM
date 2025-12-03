@extends('layouts.seller')

@section('title', 'Toko Saya - PestiMart')
@section('page-title', 'Toko Saya')

@section('content')
<style>
    /* Shop Banner */
    .shop-banner {
        height: 240px;
        background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary, #6366f1) 100%);
        border-radius: 20px;
        margin-bottom: 1.5rem;
        position: relative;
        overflow: hidden;
        box-shadow: 0 8px 32px rgba(99, 102, 241, 0.25);
    }
    .shop-banner img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .shop-banner-overlay {
        position: absolute;
        top: 1rem;
        right: 1rem;
    }
    .btn-edit-banner {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        color: var(--color-primary);
        border: none;
        padding: 0.6rem 1.25rem;
        border-radius: 12px;
        cursor: pointer;
        font-weight: 600;
        font-size: 0.9rem;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    .btn-edit-banner:hover {
        background: white;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
    }

    /* Shop Info */
    .shop-info-section {
        display: flex;
        gap: 2rem;
        align-items: flex-start;
        margin-bottom: 2rem;
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(248, 250, 252, 0.9) 100%);
        backdrop-filter: blur(10px);
        padding: 2rem;
        border-radius: 20px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(226, 232, 240, 0.8);
        position: relative;
        overflow: hidden;
    }
    .shop-info-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--color-primary) 0%, var(--color-secondary, #6366f1) 50%, var(--color-primary) 100%);
        background-size: 200% 100%;
        animation: shimmer 3s ease-in-out infinite;
    }
    @keyframes shimmer {
        0%, 100% { background-position: 200% 0; }
        50% { background-position: 0% 0; }
    }
    .shop-logo {
        width: 140px;
        height: 140px;
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        flex-shrink: 0;
        border: 4px solid white;
        position: relative;
    }
    .shop-logo::after {
        content: '';
        position: absolute;
        inset: -4px;
        border-radius: 24px;
        padding: 4px;
        background: linear-gradient(135deg, var(--color-primary), var(--color-secondary, #6366f1));
        -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
        mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
        -webkit-mask-composite: xor;
        mask-composite: exclude;
        z-index: -1;
    }
    .shop-logo img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .shop-logo .no-logo {
        font-size: 3rem;
        background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary, #6366f1) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    .shop-details {
        flex-grow: 1;
    }
    .shop-name {
        font-size: 1.75rem;
        font-weight: 800;
        background: linear-gradient(135deg, var(--color-text) 0%, #475569 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 1rem;
        letter-spacing: -0.02em;
    }
    .shop-detail-item {
        margin-bottom: 0.6rem;
        color: var(--color-text-secondary);
        font-size: 0.95rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .shop-detail-item i {
        width: 20px;
        text-align: center;
        color: var(--color-primary);
    }
    .shop-detail-label {
        font-weight: 600;
        color: var(--color-text);
        display: inline-block;
        min-width: 80px;
    }
    .shop-description {
        margin-top: 1.25rem;
        padding-top: 1.25rem;
        border-top: 1px solid rgba(226, 232, 240, 0.8);
    }
    .shop-description p {
        color: var(--color-text-secondary);
        font-size: 0.95rem;
        line-height: 1.7;
    }
    .shop-description p strong {
        color: var(--color-text);
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 0.75rem;
        margin-top: 1.5rem;
        flex-wrap: wrap;
    }
    .btn-action {
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    .btn-action.btn-primary {
        background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary, #6366f1) 100%);
        color: white;
        box-shadow: 0 4px 16px rgba(99, 102, 241, 0.35);
    }
    .btn-action.btn-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 24px rgba(99, 102, 241, 0.4);
        color: white;
    }
    .btn-action.btn-secondary {
        background: rgba(255, 255, 255, 0.9);
        color: var(--color-primary);
        border: 2px solid rgba(99, 102, 241, 0.3);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    }
    .btn-action.btn-secondary:hover {
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.08) 0%, rgba(139, 92, 246, 0.06) 100%);
        border-color: var(--color-primary);
        transform: translateY(-2px);
    }

    /* Products Section */
    .products-section {
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(248, 250, 252, 0.9) 100%);
        backdrop-filter: blur(10px);
        padding: 2rem;
        border-radius: 20px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(226, 232, 240, 0.8);
    }
    .section-title {
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid transparent;
        border-image: linear-gradient(90deg, var(--color-primary), var(--color-secondary, #6366f1)) 1;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    .section-title i {
        background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary, #6366f1) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    .section-title .badge {
        font-size: 0.75rem;
        padding: 0.35rem 0.75rem;
        border-radius: 20px;
    }

    /* Product Grid */
    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 1.5rem;
    }
    .product-card {
        background: rgba(255, 255, 255, 0.9);
        border: 1px solid rgba(226, 232, 240, 0.8);
        border-radius: 16px;
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
    }
    .product-card::before {
        content: '';
        position: absolute;
        inset: 0;
        border-radius: 16px;
        padding: 2px;
        background: linear-gradient(135deg, var(--color-primary), var(--color-secondary, #6366f1));
        -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
        mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
        -webkit-mask-composite: xor;
        mask-composite: exclude;
        opacity: 0;
        transition: opacity 0.3s ease;
        pointer-events: none;
    }
    .product-card:hover {
        box-shadow: 0 12px 32px rgba(0, 0, 0, 0.12);
        transform: translateY(-6px);
    }
    .product-card:hover::before {
        opacity: 1;
    }
    .product-image {
        height: 160px;
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }
    .product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    .product-card:hover .product-image img {
        transform: scale(1.05);
    }
    .product-body {
        padding: 1rem;
    }
    .product-name {
        font-weight: 600;
        color: var(--color-text);
        margin-bottom: 0.35rem;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        font-size: 0.95rem;
    }
    .product-price {
        font-size: 1.1rem;
        font-weight: 700;
        background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary, #6366f1) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 0.35rem;
    }
    .product-stock {
        font-size: 0.8rem;
        color: var(--color-text-muted);
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
        gap: 0.35rem;
    }
    .product-stock i {
        color: var(--color-primary);
    }
    .product-actions {
        display: flex;
        gap: 0.5rem;
    }
    .btn-product-action {
        flex: 1;
        padding: 0.5rem;
        border: 1px solid rgba(226, 232, 240, 0.8);
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        border-radius: 10px;
        font-size: 0.85rem;
        cursor: pointer;
        transition: all 0.25s ease;
        text-decoration: none;
        color: var(--color-primary);
        font-weight: 600;
        text-align: center;
    }
    .btn-product-action:hover {
        background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary, #6366f1) 100%);
        color: white;
        border-color: transparent;
        transform: translateY(-2px);
    }
    .btn-delete {
        color: #dc2626;
        background: linear-gradient(135deg, rgba(220, 38, 38, 0.05) 0%, rgba(239, 68, 68, 0.03) 100%);
        border-color: rgba(220, 38, 38, 0.2);
    }
    .btn-delete:hover {
        background: linear-gradient(135deg, #dc2626 0%, #ef4444 100%);
        color: white;
        border-color: transparent;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
    }
    .empty-state i {
        font-size: 4rem;
        background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary, #6366f1) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 1.5rem;
        display: block;
        opacity: 0.7;
    }
    .empty-state h5 {
        color: var(--color-text);
        margin-bottom: 0.5rem;
        font-size: 1.25rem;
        font-weight: 700;
    }
    .empty-state p {
        color: var(--color-text-muted);
        margin-bottom: 1.5rem;
    }

    /* Responsive */
    @media (max-width: 991.98px) {
        .shop-banner {
            height: 200px;
        }
        .shop-info-section {
            gap: 1.5rem;
            padding: 1.75rem;
        }
        .shop-logo {
            width: 120px;
            height: 120px;
        }
        .product-grid {
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            gap: 1.25rem;
        }
    }

    @media (max-width: 768px) {
        .shop-info-section {
            flex-direction: column;
            align-items: center;
            text-align: center;
            padding: 1.5rem;
        }
        .shop-detail-item {
            justify-content: center;
            flex-wrap: wrap;
        }
        .shop-detail-label {
            min-width: auto;
        }
        .action-buttons {
            justify-content: center;
            width: 100%;
        }
        .product-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }
        .shop-banner {
            height: 180px;
            border-radius: 16px;
            margin-bottom: 1rem;
        }
        .shop-logo {
            width: 110px;
            height: 110px;
        }
        .products-section {
            padding: 1.5rem;
            border-radius: 16px;
        }
        .section-title {
            font-size: 1.1rem;
            margin-bottom: 1.25rem;
        }
        .product-image {
            height: 140px;
        }
        .product-body {
            padding: 0.875rem;
        }
        .product-name {
            font-size: 0.9rem;
        }
        .product-price {
            font-size: 1rem;
        }
    }

    @media (max-width: 575.98px) {
        .shop-banner {
            height: 150px;
            border-radius: 12px;
        }
        .btn-edit-banner {
            padding: 0.5rem 1rem;
            font-size: 0.8rem;
        }
        .shop-info-section {
            padding: 1.25rem;
            border-radius: 16px;
        }
        .shop-logo {
            width: 90px;
            height: 90px;
            border-radius: 16px;
        }
        .shop-logo::after {
            border-radius: 20px;
        }
        .shop-logo .no-logo {
            font-size: 2.25rem;
        }
        .shop-name {
            font-size: 1.35rem;
        }
        .shop-detail-item {
            font-size: 0.85rem;
            margin-bottom: 0.5rem;
        }
        .shop-description {
            margin-top: 1rem;
            padding-top: 1rem;
        }
        .shop-description p {
            font-size: 0.9rem;
        }
        .action-buttons {
            flex-direction: column;
            gap: 0.5rem;
        }
        .btn-action {
            width: 100%;
            justify-content: center;
            padding: 0.7rem 1.25rem;
            font-size: 0.85rem;
        }
        .products-section {
            padding: 1.25rem;
            border-radius: 12px;
        }
        .section-title {
            font-size: 1rem;
            gap: 0.5rem;
        }
        .section-title .badge {
            font-size: 0.7rem;
            padding: 0.25rem 0.6rem;
        }
        .product-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 0.75rem;
        }
        .product-image {
            height: 120px;
        }
        .product-body {
            padding: 0.75rem;
        }
        .product-name {
            font-size: 0.85rem;
            margin-bottom: 0.25rem;
        }
        .product-price {
            font-size: 0.95rem;
            margin-bottom: 0.25rem;
        }
        .product-stock {
            font-size: 0.75rem;
            margin-bottom: 0.5rem;
        }
        .product-actions {
            gap: 0.35rem;
        }
        .btn-product-action {
            padding: 0.4rem;
            font-size: 0.8rem;
            border-radius: 8px;
        }
        .empty-state {
            padding: 3rem 1.5rem;
        }
        .empty-state i {
            font-size: 3rem;
            margin-bottom: 1rem;
        }
        .empty-state h5 {
            font-size: 1.1rem;
        }
        .empty-state p {
            font-size: 0.9rem;
        }
    }

    @media (max-width: 480px) {
        .product-grid {
            grid-template-columns: 1fr;
        }
        .product-image {
            height: 160px;
        }
        .product-body {
            padding: 1rem;
        }
        .product-name {
            font-size: 0.95rem;
        }
    }
</style>

<div class="shop-banner">
    @if($shop->banner)
        <img src="{{ asset('storage/' . $shop->banner) }}" alt="Banner">
    @else
        <div style="width: 100%; height: 100%; background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary) 100%);"></div>
    @endif
    <div class="shop-banner-overlay">
        <a href="{{ route('seller.shop.edit') }}" class="btn-edit-banner">
            <i class="fas fa-edit"></i> Edit
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
            <span class="shop-detail-label"><i class="fas fa-map-marker-alt"></i> Alamat:</span>
            {{ $shop->address }}
        </div>
        <div class="shop-detail-item">
            <span class="shop-detail-label"><i class="fas fa-phone"></i> Telepon:</span>
            {{ $shop->phone }}
        </div>
        <div class="shop-detail-item">
            <span class="shop-detail-label"><i class="fas fa-info-circle"></i> Status:</span>
            <span class="badge bg-success">{{ ucfirst($shop->status) }}</span>
        </div>
        <div class="shop-description">
            <p><strong>Deskripsi:</strong></p>
            <p>{{ $shop->description }}</p>
        </div>
        <div class="action-buttons">
            <a href="{{ route('seller.shop.edit') }}" class="btn-action btn-primary">
                <i class="fas fa-edit"></i> Edit Toko
            </a>
            <a href="{{ route('seller.products.create') }}" class="btn-action btn-secondary">
                <i class="fas fa-plus"></i> Tambah Produk
            </a>
        </div>
    </div>
</div>

<div class="products-section">
    <div class="section-title">
        <i class="fas fa-box"></i> Produk Toko
        <span class="badge bg-primary">{{ $products->total() }}</span>
    </div>
    
    @if($products->count() > 0)
        <div class="product-grid">
            @foreach($products as $product)
            <div class="product-card">
                <div class="product-image">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                    @else
                        <i class="fas fa-image" style="font-size: 2rem; color: var(--color-text-muted);"></i>
                    @endif
                </div>
                <div class="product-body">
                    <h5 class="product-name">{{ $product->name }}</h5>
                    <div class="product-price">Rp{{ number_format($product->price, 0, ',', '.') }}</div>
                    <div class="product-stock"><i class="fas fa-boxes"></i> Stok: {{ $product->stock }}</div>
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
        <div class="empty-state">
            <i class="fas fa-box"></i>
            <h5>Belum Ada Produk</h5>
            <p>Mulai tambahkan produk ke toko Anda</p>
            <a href="{{ route('seller.products.create') }}" class="btn-action btn-primary">
                <i class="fas fa-plus"></i> Tambah Produk Pertama
            </a>
        </div>
    @endif
</div>
@endsection
