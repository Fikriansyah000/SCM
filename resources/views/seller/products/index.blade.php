@extends('layouts.seller')

@section('title', 'Produk Saya - PestiMart')
@section('page-title', 'Kelola Produk')

@section('content')
<style>
    /* Header Controls */
    .header-controls {
        display: flex;
        gap: var(--header-gap);
        margin-bottom: var(--space-xl);
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        padding: var(--header-pad-y) var(--header-pad-x);
        background: var(--color-white);
        border-radius: var(--radius-lg);
        border: 1px solid var(--color-border);
        box-shadow: var(--shadow-sm);
    }
    .filter-tabs {
        display: flex;
        gap: 0.75rem;
    }
    .filter-btn {
        background: linear-gradient(135deg, rgba(255,255,255,0.9) 0%, rgba(248,250,252,0.9) 100%);
        color: var(--color-text-secondary);
        border: 2px solid rgba(226, 232, 240, 0.8);
        padding: 0.75rem 1.25rem;
        border-radius: 12px;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        font-size: 0.9rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    }
    .filter-btn i {
        font-size: 0.95rem;
    }
    .filter-btn:hover {
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.1) 0%, rgba(139, 92, 246, 0.08) 100%);
        border-color: rgba(99, 102, 241, 0.4);
        color: var(--color-primary);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(99, 102, 241, 0.15);
    }
    .filter-btn.active {
        background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary, #6366f1) 100%);
        color: white;
        border-color: transparent;
        box-shadow: 0 4px 16px rgba(99, 102, 241, 0.35);
    }
    .filter-btn.active i {
        color: white;
    }
    .btn-add-product {
        font-size: 0.9rem;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        box-shadow: 0 4px 16px rgba(99, 102, 241, 0.3);
    }
    .btn-add-product:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(99, 102, 241, 0.4);
    }

    /* Products Grid */
    .products-shell {
        padding: 0;
        background: transparent;
        border-radius: 0;
        border: none;
        box-shadow: none;
    }
    .products-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 1.75rem;
        row-gap: 1.75rem;
    }
    
    /* Product Card - Modern Glass Style */
    .product-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        flex-direction: column;
        border: 1px solid rgba(226, 232, 240, 0.8);
        padding-bottom: var(--space-sm);
        position: relative;
    }
    .product-card::before {
        content: '';
        position: absolute;
        inset: 0;
        border-radius: 16px;
        padding: 2px;
        background: linear-gradient(135deg, transparent, transparent);
        -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
        mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
        -webkit-mask-composite: xor;
        mask-composite: exclude;
        opacity: 0;
        transition: opacity 0.3s ease;
        pointer-events: none;
    }
    .product-card:hover::before {
        background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary, #6366f1) 100%);
        opacity: 1;
    }
    .product-card.archived {
        opacity: 0.85;
        border-style: dashed;
        background: rgba(248, 250, 252, 0.9);
    }
    .product-card:hover {
        transform: translateY(-8px) scale(1.01);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
    }
    .product-image {
        height: 200px;
        background: linear-gradient(145deg, #f1f5f9 0%, #e2e8f0 50%, #cbd5e1 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        position: relative;
    }
    .product-image::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 60px;
        background: linear-gradient(to top, rgba(255,255,255,0.9), transparent);
        pointer-events: none;
    }
    .product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .product-card:hover .product-image img {
        transform: scale(1.08);
    }
    
    .product-body {
        padding: var(--space-lg);
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        gap: var(--space-xs);
    }
    .product-name {
        font-weight: 600;
        color: var(--color-text);
        margin: 0;
        font-size: var(--font-size-base);
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        line-height: 1.4;
    }
    .product-category {
        font-size: var(--font-size-xs);
        color: var(--color-text-muted);
        display: flex;
        align-items: center;
        gap: var(--space-xxs);
    }
    .product-price {
        font-size: 1.25rem;
        font-weight: 800;
        background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary, #6366f1) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-top: var(--space-sm);
        letter-spacing: -0.02em;
    }
    .product-meta {
        display: flex;
        align-items: center;
        gap: var(--space-xs);
        font-size: var(--font-size-xs);
        color: var(--color-text-secondary);
        padding: var(--space-xs) 0;
        border-top: 1px solid var(--color-border);
        margin-top: var(--space-xs);
    }
    .product-meta i {
        color: var(--color-primary);
    }
    .status-pill {
        align-self: flex-start;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 700;
        background: linear-gradient(135deg, rgba(34, 197, 94, 0.15) 0%, rgba(16, 185, 129, 0.1) 100%);
        color: #16a34a;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        margin-bottom: var(--space-xs);
        border: 1px solid rgba(34, 197, 94, 0.2);
    }
    .status-pill.archived {
        background: linear-gradient(135deg, rgba(100, 116, 139, 0.12) 0%, rgba(71, 85, 105, 0.08) 100%);
        color: #64748b;
        border-color: rgba(100, 116, 139, 0.2);
    }
    .product-actions {
        display: flex;
        gap: var(--space-xs);
        margin-top: auto;
        padding-top: var(--space-sm);
        border-top: 1px solid var(--color-border);
    }
    .action-form {
        flex: 1;
        display: flex;
    }
    .action-btn {
        flex: 1;
        padding: var(--space-sm) var(--space-md);
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        border: 1px solid var(--color-border);
        border-radius: 10px;
        cursor: pointer;
        font-size: var(--font-size-xs);
        font-weight: 600;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        text-decoration: none;
        color: var(--color-primary);
        text-align: center;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: var(--space-xxs);
    }
    .action-btn:hover {
        background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary, #6366f1) 100%);
        color: white;
        border-color: transparent;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
    }
    .action-btn.delete {
        color: #dc2626;
        background: linear-gradient(135deg, rgba(220, 38, 38, 0.05) 0%, rgba(239, 68, 68, 0.03) 100%);
        border-color: rgba(220, 38, 38, 0.2);
    }
    .action-btn.delete:hover {
        background: linear-gradient(135deg, #dc2626 0%, #ef4444 100%);
        color: white;
        border-color: transparent;
        box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
    }
    .empty-products {
        text-align: center;
        padding: var(--space-xxl) var(--space-lg);
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(248, 250, 252, 0.9) 100%);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        border: 2px dashed rgba(203, 213, 225, 0.6);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.06);
    }
    .empty-products i {
        font-size: 5rem;
        background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary, #6366f1) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: var(--space-lg);
        opacity: 0.7;
    }
    .empty-products h4 {
        color: var(--color-text);
        margin-bottom: var(--space-sm);
        font-size: 1.5rem;
        font-weight: 700;
    }
    .product-type-badge {
        position: absolute;
        top: 12px;
        left: 12px;
        padding: 6px 12px;
        border-radius: 10px;
        font-size: 0.7rem;
        font-weight: 700;
        z-index: 5;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        backdrop-filter: blur(8px);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .badge-service {
        background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary, #6366f1) 100%);
        color: white;
    }
    .badge-product {
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.9) 0%, rgba(255, 255, 255, 0.8) 100%);
        color: #16a34a;
        border: 1px solid rgba(34, 197, 94, 0.3);
    }

    /* Responsive */
    @media (max-width: 992px) {
        .products-container {
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
        }
    }
    @media (max-width: 768px) {
        .header-controls {
            flex-direction: column;
            align-items: stretch;
            gap: var(--space-sm);
        }
        .filter-tabs {
            justify-content: center;
            flex-wrap: wrap;
        }
        .filter-btn {
            padding: 0.6rem 1rem;
            font-size: 0.85rem;
        }
        .btn-add-product {
            justify-content: center;
        }
        .products-container {
            grid-template-columns: repeat(2, 1fr);
            gap: 1.25rem;
        }
        .product-image {
            height: 160px;
        }
        .product-actions {
            flex-direction: column;
        }
    }
    @media (max-width: 575.98px) {
        .header-controls {
            flex-direction: column;
            gap: 0.75rem;
            align-items: stretch;
        }
        .filter-tabs {
            width: 100%;
        }
        .filter-btn {
            flex: 1;
            justify-content: center;
            padding: 0.5rem 0.75rem;
            font-size: 0.8rem;
        }
        .btn-add-product {
            width: 100%;
            justify-content: center;
        }
        .products-container {
            gap: 0.75rem;
        }
        .product-card {
            border-radius: 12px;
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
        .product-stock {
            font-size: 0.75rem;
        }
        .product-actions button,
        .product-actions a {
            font-size: 0.8rem;
            padding: 0.5rem 0.75rem;
        }
        .type-badge {
            font-size: 0.6rem;
            padding: 0.2rem 0.5rem;
        }
    }
    @media (max-width: 480px) {
        .products-container {
            grid-template-columns: 1fr;
            gap: 1rem;
        }
        .product-image {
            height: 180px;
        }
        .filter-tabs {
            gap: 0.5rem;
        }
        .filter-btn {
            flex: 1;
            justify-content: center;
        }
        .product-body {
            padding: 1rem;
        }
    }
</style>

@php
    $currentFilter = $filter ?? request('filter', 'active');
@endphp

<div class="header-controls">
    <div class="filter-tabs">
        <a href="{{ route('seller.products.index', ['filter' => 'active']) }}" class="filter-btn {{ $currentFilter === 'active' ? 'active' : '' }}">
            <i class="fas fa-boxes"></i> Stok aktif
        </a>
        <a href="{{ route('seller.products.index', ['filter' => 'archived']) }}" class="filter-btn {{ $currentFilter === 'archived' ? 'active' : '' }}">
            <i class="fas fa-archive"></i> Arsip
        </a>
    </div>
        <a href="{{ route('seller.products.create') }}" class="btn-primary-solid btn-add-product">
        <i class="fas fa-plus"></i> Tambah Produk
    </a>
</div>

@if($products->count() > 0)
    <div class="products-shell">
        <div class="products-container">
        @foreach($products as $product)
        @php
            $isService = ($product->product_type ?? 'food') === 'service';
            $isArchived = ($product->status ?? 'available') === 'unavailable';
        @endphp
        <div class="product-card {{ $isArchived ? 'archived' : '' }}">
            <div class="product-image">
                <span class="product-type-badge {{ $isService ? 'badge-service' : 'badge-product' }}">
                    <i class="fas {{ $isService ? 'fa-concierge-bell' : 'fa-box' }}"></i>
                    {{ $isService ? 'Layanan' : 'Produk' }}
                </span>
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                @else
                    <i class="fas fa-image" style="font-size: 3rem; color: var(--color-text-muted); opacity: 0.3;"></i>
                @endif
            </div>
            <div class="product-body">
                <span class="status-pill {{ $isArchived ? 'archived' : '' }}">
                    {{ $isArchived ? 'Diarsipkan' : 'Aktif' }}
                </span>
                <h5 class="product-name">{{ $product->name }}</h5>
                <div class="product-category">
                    <i class="fas fa-tag"></i> {{ $product->category }}
                </div>
                <div class="product-price">
                    Rp{{ number_format($product->price, 0, ',', '.') }}
                </div>
                <div class="product-meta">
                    @if($isService)
                        <i class="fas fa-clock"></i>
                        <span>{{ $product->service_profile['duration_minutes'] ?? '60' }} menit</span>
                        @if($product->requires_booking)
                            <span style="margin-left: auto; color: var(--color-primary); font-weight: 600;">
                                <i class="fas fa-calendar-check"></i> Slot
                            </span>
                        @endif
                    @else
                        <i class="fas fa-boxes"></i>
                        <span>Stok: {{ $product->stock }}</span>
                    @endif
                </div>
                <div class="product-actions">
                    <form method="POST" action="{{ route('seller.products.archive', $product->id) }}" class="action-form">
                        @csrf
                        <button type="submit" class="action-btn" title="{{ $isArchived ? 'Pulihkan' : 'Arsipkan' }}" onclick="return confirm('Yakin ingin {{ $isArchived ? 'membuka kembali' : 'mengarsipkan' }} produk ini?')">
                            <i class="fas {{ $isArchived ? 'fa-undo' : 'fa-archive' }}"></i> {{ $isArchived ? 'Pulihkan' : 'Arsip' }}
                        </button>
                    </form>
                    <a href="{{ route('seller.products.edit', $product->id) }}" class="action-btn" title="Ubah">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <form method="POST" action="{{ route('seller.products.destroy', $product->id) }}" class="action-form">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="action-btn delete" onclick="return confirm('Yakin hapus produk ini?')" title="Hapus">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
        </div>
    </div>
    
    <div style="margin-top: var(--space-xl);">
        {{ $products->links('pagination::bootstrap-5') }}
    </div>
@else
    <div class="empty-products">
        <i class="fas fa-box-open"></i>
        <h4>Belum Ada Produk</h4>
        <p style="color: var(--color-text-muted); margin-bottom: var(--space-lg);">Mulai tambahkan produk ke toko Anda</p>
        <a href="{{ route('seller.products.create') }}" class="btn-primary-solid btn-add-product">
            <i class="fas fa-plus"></i> Tambah Produk Pertama
        </a>
    </div>
@endif
@endsection
