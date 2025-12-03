@extends('layouts.seller')

@section('title', 'Pesanan - PestiMart Seller')

@section('page-title', 'Kelola Pesanan')

@section('content')
<style>
    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: var(--space-4);
        margin-bottom: var(--space-6);
    }

    .stat-card {
        background: var(--color-white);
        padding: var(--space-5);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-card);
        border: 1px solid var(--color-border);
        text-align: center;
        transition: all var(--transition-base);
    }

    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-card-hover);
    }

    .stat-number {
        font-size: var(--font-size-2xl);
        font-weight: 700;
        color: var(--color-primary);
        margin-bottom: var(--space-2);
    }

    .stat-label {
        font-size: var(--font-size-sm);
        color: var(--color-text-muted);
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    /* Filter Tabs */
    .filter-tabs {
        display: flex;
        gap: var(--space-2);
        margin-bottom: var(--space-5);
        flex-wrap: wrap;
        background: var(--color-white);
        padding: var(--space-3);
        border-radius: var(--radius-lg);
        border: 1px solid var(--color-border);
    }

    .filter-btn {
        padding: var(--space-2) var(--space-4);
        background: transparent;
        border: 2px solid var(--color-border);
        border-radius: var(--radius-full);
        cursor: pointer;
        font-weight: 600;
        font-size: var(--font-size-sm);
        transition: all 0.2s ease;
        text-decoration: none;
        color: var(--color-text-muted);
    }

    .filter-btn:hover {
        border-color: var(--color-primary);
        color: var(--color-primary);
    }

    .filter-btn.active {
        background: var(--gradient-primary);
        border-color: var(--color-primary);
        color: white;
    }

    /* Desktop Table View */
    .orders-table {
        background: var(--color-white);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-card);
        border: 1px solid var(--color-border);
        overflow: hidden;
    }

    .order-row {
        display: grid;
        grid-template-columns: 2fr 1.5fr 1fr 1fr auto;
        gap: var(--space-4);
        padding: var(--space-4) var(--space-5);
        border-bottom: 1px solid var(--color-border);
        align-items: center;
        transition: background 0.2s ease;
    }

    .order-row:hover {
        background: rgba(58, 123, 255, 0.03);
    }

    .order-row:last-child {
        border-bottom: none;
    }

    .order-info h4 {
        font-weight: 600;
        font-size: var(--font-size-base);
        margin-bottom: var(--space-1);
        color: var(--color-primary);
    }

    .order-buyer {
        font-size: var(--font-size-sm);
        color: var(--color-neutral-dark);
    }

    .order-date {
        font-size: var(--font-size-xs);
        color: var(--color-text-muted);
        margin-top: var(--space-1);
    }

    .order-amount {
        font-weight: 600;
        color: var(--color-neutral-dark);
    }

    .order-shipping {
        font-size: var(--font-size-xs);
        color: var(--color-text-muted);
        margin-top: var(--space-1);
    }

    .order-status {
        display: inline-flex;
        align-items: center;
        gap: var(--space-1);
        padding: var(--space-2) var(--space-3);
        border-radius: var(--radius-full);
        font-size: var(--font-size-xs);
        font-weight: 600;
        white-space: nowrap;
    }

    .status-pending { background: #fef3c7; color: #92400e; }
    .status-processing { background: #dbeafe; color: #1e40af; }
    .status-shipped { background: #cffafe; color: #0e7490; }
    .status-delivered, .status-completed { background: #d1fae5; color: #065f46; }

    .status-accepted { background: #dbeafe; color: #1e40af; }
    .status-in_progress { background: #bfdbfe; color: #1e3a8a; }
    .status-review { background: #ede9fe; color: #5b21b6; }
    .status-revision { background: #ffedd5; color: #c2410c; }
    .status-cancelled { background: #fee2e2; color: #b91c1c; }

    .btn-view {
        padding: var(--space-2) var(--space-4);
        background: var(--gradient-primary);
        color: white;
        border: none;
        border-radius: var(--radius-md);
        text-decoration: none;
        font-weight: 600;
        font-size: var(--font-size-sm);
        display: inline-flex;
        align-items: center;
        gap: var(--space-2);
        transition: all 0.2s ease;
    }

    .btn-view:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(58, 123, 255, 0.3);
        color: white;
    }

    .empty-state {
        text-align: center;
        padding: var(--space-10);
    }

    .empty-state i {
        font-size: 4rem;
        color: var(--color-border);
        margin-bottom: var(--space-4);
    }

    .empty-state h4 {
        color: var(--color-neutral-dark);
        margin-bottom: var(--space-2);
    }

    .empty-state p {
        color: var(--color-text-muted);
    }

    /* Mobile Card View */
    .orders-cards {
        display: none;
    }

    .order-card {
        background: var(--color-white);
        border-radius: var(--radius-lg);
        border: 1px solid var(--color-border);
        box-shadow: var(--shadow-card);
        padding: var(--space-4);
        margin-bottom: var(--space-4);
    }

    .order-card-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: var(--space-3);
    }

    .order-card-title {
        font-weight: 600;
        color: var(--color-primary);
        font-size: var(--font-size-base);
    }

    .order-card-buyer {
        font-size: var(--font-size-sm);
        color: var(--color-neutral-dark);
        margin-top: var(--space-1);
    }

    .order-card-meta {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: var(--space-3);
        padding: var(--space-3) 0;
        border-top: 1px solid var(--color-border);
        border-bottom: 1px solid var(--color-border);
        margin-bottom: var(--space-3);
    }

    .meta-item {
        font-size: var(--font-size-sm);
    }

    .meta-label {
        color: var(--color-text-muted);
        display: block;
        margin-bottom: var(--space-1);
    }

    .meta-value {
        font-weight: 600;
        color: var(--color-neutral-dark);
    }

    .order-card-footer {
        display: flex;
        justify-content: flex-end;
    }

    /* Responsive */
    @media (max-width: 991.98px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 767.98px) {
        .orders-table {
            display: none;
        }

        .orders-cards {
            display: block;
        }

        .filter-tabs {
            padding: var(--space-2);
        }

        .filter-btn {
            padding: var(--space-2) var(--space-3);
            font-size: var(--font-size-xs);
        }
    }

    @media (max-width: 575.98px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: var(--space-3);
        }

        .stat-card {
            padding: var(--space-4);
        }

        .stat-number {
            font-size: var(--font-size-xl);
        }
    }
</style>

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

@if($orders->count() > 0)
    <!-- Desktop Table View -->
    <div class="orders-table">
        @foreach($orders as $order)
        <div class="order-row">
            <div class="order-info">
                <h4>{{ $order->order_number }}</h4>
                <div class="order-buyer">{{ $order->user->name }}</div>
                <div class="order-date">{{ $order->created_at->format('d M Y H:i') }}</div>
            </div>

            <div>
                <div class="order-amount">Rp{{ number_format($order->total_amount, 0, ',', '.') }}</div>
                <div class="order-shipping">{{ $order->items->count() }} item · {{ $order->getShippingModeLabel() ?? ucfirst($order->shipping_mode) }}</div>
            </div>

            <div>
                @php
                    $isServiceOrder = $order->isServiceOrder();
                    $statusKey = $isServiceOrder ? ($order->service_status ?? 'pending') : $order->status;
                    $statusLabel = $isServiceOrder ? $order->getServiceStatusLabel() : $order->getStatusLabel();
                @endphp
                <span class="order-status status-{{ $statusKey }}">
                    {{ $statusLabel }}
                </span>
                @if($isServiceOrder)
                    <div style="font-size: 0.7rem; color: var(--color-text-muted); margin-top: 4px;">Layanan</div>
                @endif
            </div>

            <div style="text-align: right;">
                <a href="{{ route('seller.orders.show', $order) }}" class="btn-view">
                    <i class="fas fa-eye"></i>Lihat
                </a>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Mobile Card View -->
    <div class="orders-cards">
        @foreach($orders as $order)
        <div class="order-card">
            <div class="order-card-header">
                <div>
                    <div class="order-card-title">{{ $order->order_number }}</div>
                    <div class="order-card-buyer">{{ $order->user->name }}</div>
                </div>
                @php
                    $isServiceOrder = $order->isServiceOrder();
                    $statusKey = $isServiceOrder ? ($order->service_status ?? 'pending') : $order->status;
                    $statusLabel = $isServiceOrder ? $order->getServiceStatusLabel() : $order->getStatusLabel();
                @endphp
                <span class="order-status status-{{ $statusKey }}">
                    {{ $statusLabel }}
                </span>
            </div>
            <div class="order-card-meta">
                <div class="meta-item">
                    <span class="meta-label">Total</span>
                    <span class="meta-value">Rp{{ number_format($order->total_amount, 0, ',', '.') }}</span>
                </div>
                <div class="meta-item">
                    <span class="meta-label">Item</span>
                    <span class="meta-value">{{ $order->items->count() }} produk</span>
                </div>
                <div class="meta-item">
                    <span class="meta-label">Tanggal</span>
                    <span class="meta-value">{{ $order->created_at->format('d M Y') }}</span>
                </div>
                <div class="meta-item">
                    <span class="meta-label">Pengiriman</span>
                    <span class="meta-value">{{ $order->getShippingModeLabel() ?? ucfirst($order->shipping_mode) }}</span>
                </div>
            </div>
            <div class="order-card-footer">
                <a href="{{ route('seller.orders.show', $order) }}" class="btn-view">
                    <i class="fas fa-eye"></i>Lihat Detail
                </a>
            </div>
        </div>
        @endforeach
    </div>

    <div class="mt-4">
        {{ $orders->links('pagination::bootstrap-5') }}
    </div>
@else
    <div class="orders-table">
        <div class="empty-state">
            <i class="fas fa-inbox"></i>
            <h4>Belum Ada Pesanan</h4>
            <p>Belum ada pesanan masuk untuk toko Anda</p>
        </div>
    </div>
@endif
@endsection
