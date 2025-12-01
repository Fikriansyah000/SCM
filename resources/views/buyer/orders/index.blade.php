@extends('layouts.app')

@section('title', 'Pesanan Saya - PestiMart')

@section('content')
<style>
    .orders-container {
        background: white;
        border-radius: 0.75rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        overflow: hidden;
    }

    .order-item {
        padding: 1.5rem;
        border-bottom: 1px solid #f0f0f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: all 0.3s ease;
    }

    .order-item:hover {
        background: #f8f9fa;
    }

    .order-info h5 {
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .order-number {
        color: #667eea;
        font-weight: 600;
    }

    .order-date {
        font-size: 0.85rem;
        color: #999;
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

    .status-cancelled {
        background: #f8d7da;
        color: #842029;
    }

    .service-badge {
        display: inline-block;
        padding: 0.25rem 0.5rem;
        background: #e0e7ff;
        color: #3730a3;
        border-radius: 0.25rem;
        font-size: 0.75rem;
        font-weight: 600;
        margin-left: 0.5rem;
    }

    .order-actions {
        display: flex;
        gap: 0.5rem;
    }

    .btn-view {
        padding: 0.5rem 1rem;
        background: #667eea;
        color: white;
        border: none;
        border-radius: 0.4rem;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.85rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-view:hover {
        background: #764ba2;
        text-decoration: none;
        color: white;
    }

    .empty-orders {
        text-align: center;
        padding: 3rem;
    }

    .empty-orders i {
        font-size: 3rem;
        color: #ddd;
        margin-bottom: 1rem;
    }
</style>

<div class="container my-4">
    <h2 class="mb-4">
        <i class="fas fa-history me-2"></i>Pesanan Saya
    </h2>

    @if($orders->count() > 0)
        <div class="orders-container">
            @foreach($orders as $order)
            <div class="order-item">
                <div class="order-info">
                    <h5>
                        <span class="order-number">{{ $order->order_number }}</span>
                        @if($order->is_service_order)
                            <span class="service-badge"><i class="fas fa-concierge-bell me-1"></i>Layanan</span>
                        @endif
                    </h5>
                    <div class="order-date">
                        {{ $order->created_at->format('d M Y H:i') }}
                    </div>
                    <small class="text-muted">
                        {{ $order->items->count() }} item • Rp{{ number_format($order->total_amount, 0, ',', '.') }}
                    </small>
                </div>
                
                <div class="d-flex align-items-center gap-3">
                    @if($order->is_service_order)
                        <span class="order-status status-{{ $order->service_status ?? 'pending' }}">
                            {{ $order->getServiceStatusLabel() }}
                        </span>
                    @else
                        <span class="order-status status-{{ $order->status }}">
                            {{ $order->getStatusLabel() }}
                        </span>
                    @endif
                    
                    <div class="order-actions">
                        @if($order->is_service_order)
                            <a href="{{ route('buyer.services.show', $order) }}" class="btn-view">
                                <i class="fas fa-eye me-1"></i>Lihat
                            </a>
                        @else
                            <a href="{{ route('buyer.orders.show', $order) }}" class="btn-view">
                                <i class="fas fa-eye me-1"></i>Lihat
                            </a>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $orders->links('pagination::bootstrap-5') }}
        </div>
    @else
        <div class="orders-container">
            <div class="empty-orders">
                <i class="fas fa-shopping-cart"></i>
                <h4>Belum Ada Pesanan</h4>
                <p class="text-muted mb-3">Mulai belanja sekarang dan lacak pesanan Anda</p>
                <a href="{{ route('buyer.home') }}" class="btn btn-primary">
                    <i class="fas fa-shopping-bag me-2"></i>Belanja Sekarang
                </a>
            </div>
        </div>
    @endif
</div>
@endsection
