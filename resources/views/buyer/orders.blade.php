@extends('layouts.app')

@section('title', 'Pesanan Saya - PestiMart')

@section('content')
<style>
    /* Orders Page Header */
    .orders-header {
        background: linear-gradient(135deg, #1e3a5f 0%, #2d5a87 50%, #1e3a5f 100%);
        color: white;
        padding: 2.5rem 0;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
    }

    .orders-header::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 60%);
        animation: headerShine 8s linear infinite;
    }

    @keyframes headerShine {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .orders-header .container {
        position: relative;
        z-index: 1;
    }

    .orders-header h2 {
        font-size: 1.75rem;
        font-weight: 700;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .orders-header h2 i {
        background: rgba(255,255,255,0.2);
        padding: 0.6rem;
        border-radius: 50%;
        font-size: 1.2rem;
    }

    .orders-header-subtitle {
        margin-top: 0.5rem;
        opacity: 0.9;
        font-size: 0.95rem;
    }

    /* Orders Stats */
    .orders-stats {
        display: flex;
        gap: 1rem;
        margin-top: 1.25rem;
        flex-wrap: wrap;
    }

    .stat-item {
        background: rgba(255,255,255,0.15);
        backdrop-filter: blur(10px);
        padding: 0.6rem 1.25rem;
        border-radius: 2rem;
        font-size: 0.85rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .stat-item i {
        opacity: 0.9;
    }

    /* Filter Tabs */
    .orders-filter-section {
        background: white;
        padding: 1rem 1.5rem;
        border-radius: 1rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        border: 1px solid #e5e7eb;
    }

    .filter-tabs {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .filter-tab {
        padding: 0.6rem 1.25rem;
        border-radius: 2rem;
        font-weight: 600;
        font-size: 0.875rem;
        text-decoration: none;
        transition: all 0.3s ease;
        border: 2px solid transparent;
        display: flex;
        align-items: center;
        gap: 0.4rem;
    }

    .filter-tab.active {
        background: linear-gradient(135deg, #1e3a5f, #2d5a87);
        color: white;
    }

    .filter-tab:not(.active) {
        background: #f3f4f6;
        color: #374151;
    }

    .filter-tab:not(.active):hover {
        background: #e5e7eb;
        color: #1e3a5f;
        text-decoration: none;
    }

    .filter-count {
        background: rgba(255,255,255,0.25);
        padding: 0.15rem 0.5rem;
        border-radius: 999px;
        font-size: 0.75rem;
    }

    .filter-tab:not(.active) .filter-count {
        background: rgba(0,0,0,0.08);
    }
    
    /* Order Card */
    .order-card {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 1rem;
        padding: 0;
        margin-bottom: 1.25rem;
        transition: all 0.3s ease;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    }
    
    .order-card:hover {
        box-shadow: 0 8px 24px rgba(30, 58, 95, 0.12);
        transform: translateY(-2px);
        border-color: #cbd5e1;
    }

    .order-card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1.25rem 1.5rem;
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        border-bottom: 1px solid #e5e7eb;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .order-shop-info {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .order-shop-icon {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #1e3a5f, #2d5a87);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1rem;
    }

    .order-shop-details {
        display: flex;
        flex-direction: column;
    }

    .order-shop-name {
        font-weight: 700;
        color: #1e293b;
        font-size: 0.95rem;
    }
    
    .order-number {
        font-size: 0.8rem;
        color: #64748b;
        font-weight: 500;
    }
    
    .order-date {
        font-size: 0.8rem;
        color: #94a3b8;
        display: flex;
        align-items: center;
        gap: 0.35rem;
    }
    
    .order-status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.5rem 1rem;
        border-radius: 2rem;
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .status-pending {
        background: linear-gradient(135deg, #fef3c7, #fde68a);
        color: #92400e;
        box-shadow: 0 2px 8px rgba(251, 191, 36, 0.3);
    }
    
    .status-processing {
        background: linear-gradient(135deg, #dbeafe, #bfdbfe);
        color: #1e40af;
        box-shadow: 0 2px 8px rgba(59, 130, 246, 0.3);
    }
    
    .status-shipped {
        background: linear-gradient(135deg, #e0e7ff, #c7d2fe);
        color: #4338ca;
        box-shadow: 0 2px 8px rgba(99, 102, 241, 0.3);
    }
    
    .status-completed {
        background: linear-gradient(135deg, #dcfce7, #bbf7d0);
        color: #166534;
        box-shadow: 0 2px 8px rgba(34, 197, 94, 0.3);
    }
    
    .status-cancelled {
        background: linear-gradient(135deg, #fee2e2, #fecaca);
        color: #991b1b;
        box-shadow: 0 2px 8px rgba(239, 68, 68, 0.3);
    }

    .order-card-body {
        padding: 1.25rem 1.5rem;
    }
    
    .order-items {
        margin: 0;
    }
    
    .order-item {
        display: flex;
        gap: 1rem;
        padding: 1rem 0;
        border-bottom: 1px dashed #e5e7eb;
        align-items: center;
    }
    
    .order-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .order-item:first-child {
        padding-top: 0;
    }
    
    .order-item-image {
        width: 70px;
        height: 70px;
        background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
        border-radius: 0.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        flex-shrink: 0;
        border: 2px solid #e5e7eb;
    }
    
    .order-item-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .order-item-info {
        flex-grow: 1;
        min-width: 0;
    }
    
    .order-item-name {
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 0.35rem;
        font-size: 0.95rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    .order-item-qty {
        font-size: 0.85rem;
        color: #64748b;
        display: flex;
        align-items: center;
        gap: 0.35rem;
    }

    .order-item-qty i {
        font-size: 0.75rem;
        color: #94a3b8;
    }
    
    .order-item-price {
        font-weight: 700;
        color: #1e3a5f;
        font-size: 1rem;
        text-align: right;
        white-space: nowrap;
    }

    .order-card-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1.25rem 1.5rem;
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        border-top: 1px solid #e5e7eb;
        flex-wrap: wrap;
        gap: 1rem;
    }
    
    .order-total {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .order-total-label {
        font-size: 0.8rem;
        color: #64748b;
        font-weight: 500;
    }

    .order-total-amount {
        font-size: 1.25rem;
        font-weight: 800;
        color: #1e3a5f;
    }
    
    .order-actions {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
    }
    
    .btn-order-action {
        padding: 0.65rem 1.25rem;
        border: 2px solid #1e3a5f;
        border-radius: 0.75rem;
        background: white;
        color: #1e3a5f;
        font-size: 0.85rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .btn-order-action:hover {
        background: linear-gradient(135deg, #1e3a5f, #2d5a87);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(30, 58, 95, 0.25);
        text-decoration: none;
    }

    .btn-order-action.btn-primary-action {
        background: linear-gradient(135deg, #1e3a5f, #2d5a87);
        color: white;
        border-color: transparent;
    }

    .btn-order-action.btn-primary-action:hover {
        background: linear-gradient(135deg, #2d5a87, #3d6a9f);
        box-shadow: 0 6px 16px rgba(30, 58, 95, 0.35);
    }
    
    /* Empty State */
    .empty-orders {
        text-align: center;
        padding: 4rem 2rem;
        background: white;
        border-radius: 1rem;
        border: 2px dashed #e5e7eb;
    }

    .empty-orders-icon {
        width: 100px;
        height: 100px;
        background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
    }
    
    .empty-orders-icon i {
        font-size: 2.5rem;
        color: #94a3b8;
    }

    .empty-orders h4 {
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 0.5rem;
    }

    .empty-orders p {
        color: #64748b;
        margin-bottom: 1.5rem;
    }

    .empty-orders .btn-primary {
        background: linear-gradient(135deg, #1e3a5f, #2d5a87);
        border: none;
        padding: 0.75rem 1.75rem;
        border-radius: 0.75rem;
        font-weight: 700;
        transition: all 0.3s ease;
    }

    .empty-orders .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(30, 58, 95, 0.3);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .orders-header {
            padding: 1.75rem 0;
        }

        .orders-header h2 {
            font-size: 1.4rem;
        }

        .orders-stats {
            gap: 0.5rem;
        }

        .stat-item {
            padding: 0.5rem 1rem;
            font-size: 0.8rem;
        }

        .order-card-header,
        .order-card-body,
        .order-card-footer {
            padding: 1rem;
        }

        .order-item-image {
            width: 55px;
            height: 55px;
        }

        .order-total-amount {
            font-size: 1.1rem;
        }

        .order-actions {
            width: 100%;
        }

        .btn-order-action {
            flex: 1;
            justify-content: center;
        }

        .filter-tabs {
            gap: 0.35rem;
        }

        .filter-tab {
            padding: 0.5rem 1rem;
            font-size: 0.8rem;
        }
    }
</style>

<div class="orders-header">
    <div class="container">
        <h2>
            <i class="fas fa-receipt"></i>
            Pesanan Saya
        </h2>
        <p class="orders-header-subtitle">Lacak dan kelola semua pesanan Anda di sini</p>
        <div class="orders-stats">
            <div class="stat-item">
                <i class="fas fa-shopping-bag"></i>
                <span>{{ $orders->total() }} Total Pesanan</span>
            </div>
            <div class="stat-item">
                <i class="fas fa-check-circle"></i>
                <span>{{ $orders->where('status', 'completed')->count() }} Selesai</span>
            </div>
            <div class="stat-item">
                <i class="fas fa-truck"></i>
                <span>{{ $orders->where('status', 'shipped')->count() }} Dalam Pengiriman</span>
            </div>
        </div>
    </div>
</div>

<div class="container my-4">
    <!-- Filter Tabs -->
    <div class="orders-filter-section">
        <div class="filter-tabs">
            <a href="{{ route('buyer.orders') }}" class="filter-tab {{ !request('status') ? 'active' : '' }}">
                <i class="fas fa-list"></i> Semua
            </a>
            <a href="{{ route('buyer.orders', ['status' => 'pending']) }}" class="filter-tab {{ request('status') == 'pending' ? 'active' : '' }}">
                <i class="fas fa-clock"></i> Pending
            </a>
            <a href="{{ route('buyer.orders', ['status' => 'processing']) }}" class="filter-tab {{ request('status') == 'processing' ? 'active' : '' }}">
                <i class="fas fa-cog"></i> Diproses
            </a>
            <a href="{{ route('buyer.orders', ['status' => 'shipped']) }}" class="filter-tab {{ request('status') == 'shipped' ? 'active' : '' }}">
                <i class="fas fa-truck"></i> Dikirim
            </a>
            <a href="{{ route('buyer.orders', ['status' => 'completed']) }}" class="filter-tab {{ request('status') == 'completed' ? 'active' : '' }}">
                <i class="fas fa-check-circle"></i> Selesai
            </a>
            <a href="{{ route('buyer.orders', ['status' => 'cancelled']) }}" class="filter-tab {{ request('status') == 'cancelled' ? 'active' : '' }}">
                <i class="fas fa-times-circle"></i> Dibatalkan
            </a>
        </div>
    </div>

    @if($orders->count() > 0)
        @foreach($orders as $order)
        <div class="order-card">
            <div class="order-card-header">
                <div class="order-shop-info">
                    <div class="order-shop-icon">
                        <i class="fas fa-store"></i>
                    </div>
                    <div class="order-shop-details">
                        <div class="order-shop-name">{{ $order->orderItems->first()->product->shop->shop_name ?? 'Toko' }}</div>
                        <div class="order-number">Order #{{ $order->order_number }}</div>
                    </div>
                </div>
                <div style="display: flex; align-items: center; gap: 1rem; flex-wrap: wrap;">
                    <div class="order-date">
                        <i class="fas fa-calendar-alt"></i>
                        {{ $order->created_at->format('d M Y, H:i') }}
                    </div>
                    <span class="order-status-badge status-{{ $order->status }}">
                        @switch($order->status)
                            @case('pending')
                                <i class="fas fa-clock"></i>Menunggu
                                @break
                            @case('processing')
                                <i class="fas fa-spinner fa-spin"></i>Diproses
                                @break
                            @case('shipped')
                                <i class="fas fa-truck"></i>Dikirim
                                @break
                            @case('completed')
                                <i class="fas fa-check-circle"></i>Selesai
                                @break
                            @case('cancelled')
                                <i class="fas fa-times-circle"></i>Dibatalkan
                                @break
                        @endswitch
                    </span>
                </div>
            </div>
            
            <div class="order-card-body">
                <div class="order-items">
                    @foreach($order->orderItems as $item)
                    <div class="order-item">
                        <div class="order-item-image">
                            @if($item->product->image)
                                <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}">
                            @else
                                <i class="fas fa-image" style="font-size: 1.5rem; color: #cbd5e1;"></i>
                            @endif
                        </div>
                        <div class="order-item-info">
                            <div class="order-item-name">{{ $item->product->name }}</div>
                            <div class="order-item-qty">
                                <i class="fas fa-times"></i>{{ $item->quantity }} item
                            </div>
                        </div>
                        <div class="order-item-price">
                            Rp{{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            
            <div class="order-card-footer">
                <div class="order-total">
                    <span class="order-total-label">Total Pembayaran</span>
                    <span class="order-total-amount">Rp{{ number_format($order->total_amount, 0, ',', '.') }}</span>
                </div>
                <div class="order-actions">
                    @if($order->status === 'pending')
                    <a href="{{ route('buyer.orders.show', $order->id) }}" class="btn-order-action">
                        <i class="fas fa-credit-card"></i>Bayar Sekarang
                    </a>
                    @endif
                    <a href="{{ route('buyer.orders.show', $order->id) }}" class="btn-order-action btn-primary-action">
                        <i class="fas fa-eye"></i>Lihat Detail
                    </a>
                </div>
            </div>
        </div>
        @endforeach
        
        <div class="d-flex justify-content-center mt-4">
            {{ $orders->links('pagination::bootstrap-5') }}
        </div>
    @else
        <div class="empty-orders">
            <div class="empty-orders-icon">
                <i class="fas fa-shopping-bag"></i>
            </div>
            <h4>Belum Ada Pesanan</h4>
            <p>Anda belum melakukan pembelian apapun. Yuk mulai belanja!</p>
            <a href="{{ route('buyer.home') }}" class="btn btn-primary">
                <i class="fas fa-shopping-cart me-2"></i>Mulai Belanja
            </a>
        </div>
    @endif
</div>
@endsection
@push('scripts')
<script>
// Star rating interaction
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.stars-input').forEach(function(container) {
        const targetSelector = container.getAttribute('data-target');
        const target = document.querySelector(targetSelector);
        const stars = container.querySelectorAll('.star-clickable');
        const setRating = (value) => {
            stars.forEach(s => {
                const v = parseInt(s.getAttribute('data-value'));
                s.style.color = v <= value ? '#f6ad55' : '#ddd';
            });
            if (target) target.value = value;
        };
        stars.forEach(function(star) {
            star.addEventListener('click', function() {
                const v = parseInt(this.getAttribute('data-value'));
                setRating(v);
            });
            star.addEventListener('mouseover', function() {
                const v = parseInt(this.getAttribute('data-value'));
                stars.forEach(s => {
                    const sv = parseInt(s.getAttribute('data-value'));
                    s.style.color = sv <= v ? '#f6ad55' : '#ddd';
                });
            });
            star.addEventListener('mouseout', function() {
                const current = parseInt(target ? target.value : 0) || 0;
                stars.forEach(s => {
                    const sv = parseInt(s.getAttribute('data-value'));
                    s.style.color = sv <= current ? '#f6ad55' : '#ddd';
                });
            });
        });
        // initialize default
        if (target) setRating(parseInt(target.value) || 5);
    });
});
</script>
@endpush
