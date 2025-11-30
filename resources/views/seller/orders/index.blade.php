@extends('layouts.app')

@section('title', 'Pesanan - PestiMart Seller')

@section('content')
<style>
    .orders-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: var(--card-bg, #FFFFFF);
        padding: 1.5rem;
        border-radius: 0.75rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        text-align: center;
    }

    .stat-number {
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--primary, #3A7BFF);
        margin-bottom: 0.5rem;
    }

    .stat-label {
        font-size: 0.85rem;
        color: #999;
        text-transform: uppercase;
    }

    .filter-tabs {
        display: flex;
        gap: 0.5rem;
        margin-bottom: 2rem;
        flex-wrap: wrap;
    }

    .filter-btn {
        padding: 0.75rem 1.5rem;
        background: var(--card-bg, #FFFFFF);
        border: 2px solid #ddd;
        border-radius: 2rem;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.3s ease;
        text-decoration: none;
        color: #666;
    }

    @media (hover: hover) {
        .filter-btn:hover {
            border-color: var(--primary, #3A7BFF);
            color: var(--primary, #3A7BFF);
        }
    }

    .filter-btn.active {
        background: linear-gradient(135deg, var(--primary, #3A7BFF), var(--secondary, #6ECBF9));
        border-color: var(--primary, #3A7BFF);
        color: white;
    }

    .orders-container {
        background: var(--card-bg, #FFFFFF);
        border-radius: 0.75rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        overflow: hidden;
    }

    .order-row {
        display: grid;
        grid-template-columns: 2fr 1fr 1fr 1.5fr;
        gap: 1rem;
        padding: 1.5rem;
        border-bottom: 1px solid var(--neutral-gray, #ECEEF3);
        align-items: center;
        transition: all 0.3s ease;
    }

    @media (hover: hover) {
        .order-row:hover {
            background: var(--neutral-gray, #ECEEF3);
        }
    }

    .order-info h4 {
        font-weight: 600;
        margin-bottom: 0.25rem;
        color: var(--primary, #3A7BFF);
    }

    .order-number {
        font-size: 0.9rem;
    }

    .order-details {
        font-size: 0.85rem;
        color: #999;
    }

    .order-buyer {
        font-weight: 500;
    }

    .order-items {
        font-size: 0.85rem;
        color: #666;
    }

    .order-status {
        display: inline-block;
        padding: 0.5rem 1rem;
        border-radius: 2rem;
        font-size: 0.85rem;
        font-weight: 600;
    }

    .status-pending {
        background: #fff3cd;
        color: #856404;
    }

    .status-processing {
        background: #d1ecf1;
        color: #0c5460;
    }

    .status-shipped {
        background: #cfe2ff;
        color: #084298;
    }

    .status-delivered {
        background: #d1e7dd;
        color: #0f5132;
    }

    .status-completed {
        background: #d1e7dd;
        color: #0f5132;
    }

    .order-actions {
        display: flex;
        gap: 0.5rem;
    }

    .btn-small {
        padding: 0.5rem 1rem;
        background: linear-gradient(135deg, var(--primary, #3A7BFF), var(--secondary, #6ECBF9));
        color: white;
        border: none;
        border-radius: 0.4rem;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.85rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    @media (hover: hover) {
        .btn-small:hover {
            filter: brightness(1.05);
            transform: translateY(-1px);
            text-decoration: none;
            color: white;
        }
    }

    .empty-state {
        text-align: center;
        padding: 3rem;
    }

    .empty-state i {
        font-size: 3rem;
        color: #ddd;
        margin-bottom: 1rem;
    }

    @media (max-width: 1024px) {
        .order-row {
            grid-template-columns: 1fr;
            gap: 0.75rem;
        }

        .order-actions {
            justify-content: flex-end;
        }
    }

    @media (max-width: 576px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
        
        .stat-card {
            padding: 1rem;
        }
        
        .stat-number {
            font-size: 1.4rem;
        }
    }
</style>

<div class="container my-4">
    <div class="orders-header">
        <h2>
            <i class="fas fa-box me-2"></i>Pesanan
        </h2>
        <a href="{{ route('seller.dashboard') }}" class="btn btn-outline-primary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <!-- Stats -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-number">{{ $stats['pending'] ?? 0 }}</div>
            <div class="stat-label">Menunggu</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $stats['processing'] ?? 0 }}</div>
            <div class="stat-label">Diproses</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $stats['shipped'] ?? 0 }}</div>
            <div class="stat-label">Dikirim</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $stats['completed'] ?? 0 }}</div>
            <div class="stat-label">Selesai</div>
        </div>
    </div>

    <!-- Filter Tabs -->
    <div class="filter-tabs">
        <a href="{{ route('seller.orders') }}" class="filter-btn {{ !request('status') ? 'active' : '' }}">
            Semua
        </a>
        <a href="{{ route('seller.orders', ['status' => 'pending']) }}" class="filter-btn {{ request('status') === 'pending' ? 'active' : '' }}">
            <i class="fas fa-clock me-1"></i>Menunggu
        </a>
        <a href="{{ route('seller.orders', ['status' => 'processing']) }}" class="filter-btn {{ request('status') === 'processing' ? 'active' : '' }}">
            <i class="fas fa-cogs me-1"></i>Diproses
        </a>
        <a href="{{ route('seller.orders', ['status' => 'shipped']) }}" class="filter-btn {{ request('status') === 'shipped' ? 'active' : '' }}">
            <i class="fas fa-truck me-1"></i>Dikirim
        </a>
        <a href="{{ route('seller.orders', ['status' => 'completed']) }}" class="filter-btn {{ request('status') === 'completed' ? 'active' : '' }}">
            <i class="fas fa-check-circle me-1"></i>Selesai
        </a>
    </div>

    <!-- Orders List -->
    @if($orders->count() > 0)
        <div class="orders-container">
            @foreach($orders as $order)
            <div class="order-row">
                <div class="order-info">
                    <h4>{{ $order->order_number }}</h4>
                    <div class="order-number">Pembeli: <strong>{{ $order->user->name }}</strong></div>
                    <div class="order-details">{{ $order->created_at->format('d M Y H:i') }}</div>
                </div>

                <div class="order-items">
                    <div>{{ $order->items->count() }} item</div>
                    <div class="text-muted">Rp{{ number_format($order->total_amount, 0, ',', '.') }}</div>
                    <div style="margin-top:0.5rem; font-size:0.85rem; color:#666;">
                        <strong>Mode:</strong> {{ $order->getShippingModeLabel() ?? ucfirst($order->shipping_mode) }}
                        &nbsp;•&nbsp;
                        <strong>Ongkir:</strong> Rp{{ number_format($order->shipping_cost ?? 0, 0, ',', '.') }}
                    </div>
                </div>

                <div>
                    <span class="order-status status-{{ $order->status }}">
                        {{ $order->getStatusLabel() }}
                    </span>
                </div>

                <div class="order-actions">
                    <a href="{{ route('seller.orders.show', $order) }}" class="btn-small">
                        <i class="fas fa-eye me-1"></i>Lihat
                    </a>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $orders->links('pagination::bootstrap-5') }}
        </div>
    @else
        <div class="orders-container">
            <div class="empty-state">
                <i class="fas fa-inbox"></i>
                <h4>Belum Ada Pesanan</h4>
                <p class="text-muted">Belum ada pesanan masuk untuk toko Anda</p>
            </div>
        </div>
    @endif
</div>
@endsection
