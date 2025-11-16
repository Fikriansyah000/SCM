@extends('layouts.app')

@section('title', 'Pesanan Saya - PestiMart')

@section('content')
<style>
    .orders-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 2rem 0;
        margin-bottom: 2rem;
    }
    
    .order-card {
        background: white;
        border: 1px solid #e0e0e0;
        border-radius: 0.75rem;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        transition: all 0.3s ease;
    }
    
    .order-card:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    
    .order-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #f0f0f0;
    }
    
    .order-number {
        font-weight: 600;
        color: #333;
    }
    
    .order-date {
        font-size: 0.85rem;
        color: #999;
    }
    
    .order-status-badge {
        display: inline-block;
        padding: 0.5rem 1rem;
        border-radius: 2rem;
        font-size: 0.85rem;
        font-weight: 600;
    }
    
    .status-pending {
        background: #fef3c7;
        color: #92400e;
    }
    
    .status-processing {
        background: #dbeafe;
        color: #0c4a6e;
    }
    
    .status-shipped {
        background: #ddd6fe;
        color: #4c1d95;
    }
    
    .status-completed {
        background: #dcfce7;
        color: #166534;
    }
    
    .status-cancelled {
        background: #fee2e2;
        color: #991b1b;
    }
    
    .order-items {
        margin: 1rem 0;
    }
    
    .order-item {
        display: flex;
        gap: 1rem;
        margin-bottom: 0.75rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid #f0f0f0;
    }
    
    .order-item:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }
    
    .order-item-image {
        width: 60px;
        height: 60px;
        background: #f0f0f0;
        border-radius: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        flex-shrink: 0;
    }
    
    .order-item-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .order-item-info {
        flex-grow: 1;
    }
    
    .order-item-name {
        font-weight: 500;
        color: #333;
        margin-bottom: 0.25rem;
    }
    
    .order-item-qty {
        font-size: 0.85rem;
        color: #999;
    }
    
    .order-item-price {
        font-weight: 600;
        color: #667eea;
    }
    
    .order-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 1rem;
        border-top: 1px solid #f0f0f0;
        margin-top: 1rem;
    }
    
    .order-total {
        font-size: 1.1rem;
        font-weight: 700;
        color: #333;
    }
    
    .order-total-amount {
        color: #667eea;
    }
    
    .order-actions {
        display: flex;
        gap: 0.5rem;
    }
    
    .btn-order-action {
        padding: 0.5rem 1rem;
        border: 1px solid #667eea;
        border-radius: 0.5rem;
        background: white;
        color: #667eea;
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .btn-order-action:hover {
        background: #667eea;
        color: white;
    }
    
    .empty-orders {
        text-align: center;
        padding: 3rem;
        background: white;
        border-radius: 0.75rem;
    }
    
    .empty-orders i {
        font-size: 3rem;
        color: #ddd;
        margin-bottom: 1rem;
    }
</style>

<div class="orders-header">
    <div class="container">
        <h2>
            <i class="fas fa-history me-2"></i>Pesanan Saya
        </h2>
    </div>
</div>

<div class="container my-4">
    @if($orders->count() > 0)
        @foreach($orders as $order)
        <div class="order-card">
            <div class="order-header">
                <div>
                    <div class="order-number">Order #{{ $order->order_number }}</div>
                    <div class="order-date">{{ $order->created_at->format('d M Y H:i') }}</div>
                </div>
                <span class="order-status-badge status-{{ $order->status }}">
                    @switch($order->status)
                        @case('pending')
                            <i class="fas fa-clock me-1"></i>Pending
                            @break
                        @case('processing')
                            <i class="fas fa-spinner me-1"></i>Diproses
                            @break
                        @case('shipped')
                            <i class="fas fa-truck me-1"></i>Dikirim
                            @break
                        @case('completed')
                            <i class="fas fa-check-circle me-1"></i>Selesai
                            @break
                        @case('cancelled')
                            <i class="fas fa-times-circle me-1"></i>Dibatalkan
                            @break
                    @endswitch
                </span>
            </div>
            
            <div class="order-items">
                @foreach($order->orderItems as $item)
                <div class="order-item">
                    <div class="order-item-image">
                        @if($item->product->image)
                            <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}">
                        @else
                            <i class="fas fa-image" style="font-size: 1.5rem; color: #ddd;"></i>
                        @endif
                    </div>
                    <div class="order-item-info">
                        <div class="order-item-name">{{ $item->product->name }}</div>
                        <div class="order-item-qty">{{ $item->quantity }} item</div>
                    </div>
                    <div class="order-item-price">
                        Rp{{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                    </div>
                </div>
                @endforeach
            </div>
            
            <div class="order-footer">
                <div>
                    <div class="order-total">
                        Total Pembelian: 
                        <span class="order-total-amount">Rp{{ number_format($order->total_amount, 0, ',', '.') }}</span>
                    </div>
                </div>
                <div class="order-actions">
                    <a href="{{ route('buyer.orders.show', $order->id) }}" class="btn-order-action">
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
            <i class="fas fa-shopping-bag"></i>
            <h4>Belum Ada Pesanan</h4>
            <p class="text-muted mb-3">Anda belum melakukan pembelian apapun</p>
            <a href="{{ route('buyer.home') }}" class="btn btn-primary">
                <i class="fas fa-shopping-cart me-2"></i>Mulai Belanja
            </a>
        </div>
    @endif
</div>
@endsection
