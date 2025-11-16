@extends('layouts.app')

@section('title', 'Detail Pesanan - PestiMart')

@section('content')
<style>
    .order-detail-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 2rem 0;
        margin-bottom: 2rem;
    }
    
    .detail-section {
        background: white;
        padding: 2rem;
        border-radius: 0.75rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    
    .section-title {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid #f0f0f0;
    }
    
    .detail-row {
        display: flex;
        justify-content: space-between;
        padding: 0.75rem 0;
        border-bottom: 1px solid #f0f0f0;
    }
    
    .detail-row:last-child {
        border-bottom: none;
    }
    
    .detail-label {
        color: #666;
        font-weight: 500;
    }
    
    .detail-value {
        color: #333;
        font-weight: 600;
    }
    
    .status-badge {
        display: inline-block;
        padding: 0.5rem 1rem;
        border-radius: 2rem;
        font-size: 0.9rem;
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
    
    .product-item {
        display: flex;
        gap: 1.5rem;
        padding: 1.5rem 0;
        border-bottom: 1px solid #f0f0f0;
    }
    
    .product-item:last-child {
        border-bottom: none;
    }
    
    .product-image {
        width: 100px;
        height: 100px;
        background: #f0f0f0;
        border-radius: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        flex-shrink: 0;
    }
    
    .product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .product-info {
        flex-grow: 1;
    }
    
    .product-name {
        font-weight: 600;
        color: #333;
        margin-bottom: 0.5rem;
    }
    
    .product-shop {
        font-size: 0.9rem;
        color: #999;
        margin-bottom: 0.5rem;
    }
    
    .product-qty {
        font-size: 0.9rem;
        color: #666;
    }
    
    .product-price {
        text-align: right;
    }
    
    .product-price-value {
        font-size: 1.1rem;
        font-weight: 700;
        color: #667eea;
    }
    
    .summary-table {
        background: #f8f9fa;
        padding: 1.5rem;
        border-radius: 0.75rem;
        margin-top: 1.5rem;
    }
    
    .summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.75rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid #ddd;
    }
    
    .summary-row:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }
    
    .summary-row.total {
        font-size: 1.1rem;
        font-weight: 700;
        color: #667eea;
        border-top: 2px solid #ddd;
        padding-top: 1rem;
    }
    
    .action-buttons {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
    }
    
    .btn-detail-action {
        flex: 1;
        padding: 0.75rem;
        border: none;
        border-radius: 0.5rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .btn-primary-action {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }
    
    .btn-primary-action:hover {
        transform: translateY(-2px);
        text-decoration: none;
        color: white;
    }
    
    .btn-secondary-action {
        background: white;
        color: #667eea;
        border: 2px solid #667eea;
    }
    
    .btn-secondary-action:hover {
        background: #f0f4ff;
    }
</style>

<div class="order-detail-header">
    <div class="container">
        <h2>
            <i class="fas fa-receipt me-2"></i>Detail Pesanan
        </h2>
    </div>
</div>

<div class="container my-4">
    <div class="row">
        <div class="col-lg-8">
            <!-- Order Status -->
            <div class="detail-section">
                <div class="section-title">
                    <i class="fas fa-info-circle me-2"></i>Informasi Pesanan
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Nomor Pesanan</span>
                    <span class="detail-value">#{{ $order->order_number }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Tanggal Pesanan</span>
                    <span class="detail-value">{{ $order->created_at->format('d M Y H:i') }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Status</span>
                    <span class="status-badge status-{{ $order->status }}">
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
            </div>
            
            <!-- Products -->
            <div class="detail-section">
                <div class="section-title">
                    <i class="fas fa-box me-2"></i>Produk Pesanan
                </div>
                
                @foreach($order->orderItems as $item)
                <div class="product-item">
                    <div class="product-image">
                        @if($item->product->image)
                            <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}">
                        @else
                            <i class="fas fa-image" style="font-size: 2rem; color: #ddd;"></i>
                        @endif
                    </div>
                    <div class="product-info">
                        <div class="product-name">{{ $item->product->name }}</div>
                        <div class="product-shop">
                            <i class="fas fa-store me-1"></i>{{ $order->shop->shop_name }}
                        </div>
                        <div class="product-qty">
                            Jumlah: <strong>{{ $item->quantity }}</strong>
                        </div>
                    </div>
                    <div class="product-price">
                        <div class="text-muted small mb-2">Harga Satuan</div>
                        <div class="product-price-value">
                            Rp{{ number_format($item->price, 0, ',', '.') }}
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <!-- Shipping Address -->
            <div class="detail-section">
                <div class="section-title">
                    <i class="fas fa-map-marker-alt me-2"></i>Alamat Pengiriman
                </div>
                
                <p class="detail-value" style="line-height: 1.6;">
                    {{ $order->shipping_address }}
                </p>
                
                @if($order->notes)
                <div class="mt-2 pt-2 border-top">
                    <p class="detail-label mb-2">Catatan:</p>
                    <p class="detail-value">{{ $order->notes }}</p>
                </div>
                @endif
            </div>
        </div>
        
        <div class="col-lg-4">
            <!-- Payment Summary -->
            <div class="detail-section">
                <div class="section-title">
                    <i class="fas fa-receipt me-2"></i>Ringkasan Pembayaran
                </div>
                
                <div class="summary-table">
                    <div class="summary-row">
                        <span>Subtotal</span>
                        <span>Rp{{ number_format($order->total_amount, 0, ',', '.') }}</span>
                    </div>
                    <div class="summary-row">
                        <span>Diskon</span>
                        <span>Rp0</span>
                    </div>
                    <div class="summary-row">
                        <span>Ongkos Kirim</span>
                        <span>Gratis</span>
                    </div>
                    <div class="summary-row total">
                        <span>Total Pembayaran</span>
                        <span>Rp{{ number_format($order->total_amount, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
            
            <!-- Actions -->
            <div class="detail-section">
                <div class="action-buttons">
                    <a href="{{ route('buyer.orders') }}" class="btn-detail-action btn-secondary-action">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                    <a href="{{ route('messages.show', $order->shop->user_id) }}" class="btn-detail-action btn-primary-action">
                        <i class="fas fa-comment me-2"></i>Chat Penjual
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
