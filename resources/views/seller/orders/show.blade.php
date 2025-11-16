@extends('layouts.app')

@section('title', 'Detail Pesanan - PestiMart Seller')

@section('content')
<style>
    .order-detail-container {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 2rem;
        max-width: 1200px;
        margin: 0 auto;
    }

    .detail-card {
        background: white;
        border-radius: 0.75rem;
        padding: 1.5rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid #f0f0f0;
    }

    .section-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #333;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .status-badge {
        display: inline-block;
        padding: 0.75rem 1.5rem;
        border-radius: 2rem;
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

    .order-item {
        display: flex;
        gap: 1rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #f0f0f0;
        margin-bottom: 1rem;
    }

    .order-item img {
        width: 80px;
        height: 80px;
        background: #f0f0f0;
        border-radius: 0.4rem;
        object-fit: cover;
    }

    .item-details {
        flex-grow: 1;
    }

    .item-name {
        font-weight: 600;
        margin-bottom: 0.25rem;
    }

    .item-qty {
        font-size: 0.85rem;
        color: #999;
    }

    .item-price {
        color: #667eea;
        font-weight: 600;
    }

    .buyer-info {
        background: #f8f9fa;
        padding: 1rem;
        border-radius: 0.5rem;
        margin-bottom: 1rem;
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.75rem;
        font-size: 0.95rem;
    }

    .info-row:last-child {
        margin-bottom: 0;
    }

    .info-label {
        color: #999;
    }

    .action-buttons {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
        margin-top: 1.5rem;
    }

    .btn-action {
        padding: 0.875rem;
        background: #667eea;
        color: white;
        border: none;
        border-radius: 0.5rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        text-align: center;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .btn-action:hover {
        background: #764ba2;
        text-decoration: none;
        color: white;
    }

    .btn-action:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }

    .btn-back {
        background: #999;
    }

    .btn-back:hover {
        background: #777;
    }

    .form-group {
        margin-bottom: 1rem;
    }

    .form-label {
        display: block;
        font-weight: 500;
        margin-bottom: 0.5rem;
    }

    .form-control {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #ddd;
        border-radius: 0.4rem;
        font-family: inherit;
    }

    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        outline: none;
    }

    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.5);
        z-index: 999;
        align-items: center;
        justify-content: center;
    }

    .modal.show {
        display: flex;
    }

    .modal-content {
        background: white;
        padding: 2rem;
        border-radius: 0.75rem;
        max-width: 400px;
        width: 95%;
        box-shadow: 0 8px 24px rgba(0,0,0,0.15);
    }

    .modal-header {
        font-size: 1.2rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
    }

    .modal-buttons {
        display: flex;
        gap: 1rem;
        margin-top: 1.5rem;
    }

    .modal-buttons button {
        flex: 1;
        padding: 0.75rem;
        border: none;
        border-radius: 0.4rem;
        font-weight: 600;
        cursor: pointer;
    }

    .btn-confirm {
        background: #667eea;
        color: white;
    }

    .btn-cancel {
        background: #f0f0f0;
        color: #333;
    }

    @media (max-width: 768px) {
        .order-detail-container {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="container my-4">
    <a href="{{ route('seller.orders') }}" class="btn btn-outline-primary mb-3">
        <i class="fas fa-arrow-left me-2"></i>Kembali
    </a>

    <div class="order-detail-container">
        <!-- Main Content -->
        <div>
            <!-- Order Header -->
            <div class="detail-card">
                <div class="section-header">
                    <div>
                        <div style="font-size: 1.5rem; font-weight: 700; color: #667eea;">{{ $order->order_number }}</div>
                        <small class="text-muted">{{ $order->created_at->format('d M Y H:i') }}</small>
                    </div>
                    <span class="status-badge status-{{ $order->status }}">
                        {{ $order->getStatusLabel() }}
                    </span>
                </div>

                <!-- Buyer Info -->
                <div class="section-title">
                    <i class="fas fa-user"></i>Pembeli
                </div>
                <div class="buyer-info">
                    <div class="info-row">
                        <span class="info-label">Nama:</span>
                        <strong>{{ $order->user->name }}</strong>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Email:</span>
                        <span>{{ $order->user->email }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">No. Telp:</span>
                        <span>{{ $order->user->phone ?? '-' }}</span>
                    </div>
                </div>

                <!-- Shipping Address -->
                <div class="section-title mt-4">
                    <i class="fas fa-map-marker-alt"></i>Alamat Pengiriman
                </div>
                <p>{{ $order->shipping_address }}</p>

                <!-- Shipping Method -->
                <div class="section-title mt-4">
                    <i class="fas fa-truck"></i>Metode Pengiriman
                </div>
                <p>
                    @if($order->shipping_method === 'pickup')
                        <i class="fas fa-store me-1"></i>Ambil Sendiri
                    @else
                        <i class="fas fa-truck me-1"></i>Diantar (Rp 10.000)
                    @endif
                </p>

                @if($order->tracking_number)
                <div class="section-title mt-4">
                    <i class="fas fa-barcode"></i>Nomor Resi
                </div>
                <p><strong>{{ $order->tracking_number }}</strong></p>
                @endif

                <!-- Items -->
                <div class="section-title mt-4">
                    <i class="fas fa-box"></i>Produk ({{ $order->items->count() }})
                </div>
                @foreach($order->items as $item)
                <div class="order-item">
                    <img src="{{ $item->product->image ? asset('storage/' . $item->product->image) : asset('images/no-product.png') }}" 
                         alt="{{ $item->product->name }}">
                    <div class="item-details">
                        <div class="item-name">{{ $item->product->name }}</div>
                        <div class="item-qty">{{ $item->quantity }}x</div>
                    </div>
                    <div class="item-price">
                        Rp{{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Sidebar -->
        <div>
            <!-- Summary -->
            <div class="detail-card">
                <div class="section-title">
                    <i class="fas fa-receipt"></i>Ringkasan
                </div>

                @php
                    $subtotal = $order->items->sum(fn($item) => $item->price * $item->quantity);
                    $shipping = $order->shipping_method === 'delivery' ? 10000 : 0;
                    $total = $subtotal + $shipping;
                @endphp

                <div class="info-row">
                    <span class="info-label">Subtotal:</span>
                    <strong>Rp{{ number_format($subtotal, 0, ',', '.') }}</strong>
                </div>
                <div class="info-row mb-3" style="border-bottom: 1px solid #f0f0f0; padding-bottom: 1rem;">
                    <span class="info-label">Ongkir:</span>
                    <strong>Rp{{ number_format($shipping, 0, ',', '.') }}</strong>
                </div>
                <div class="info-row" style="font-size: 1.1rem; color: #667eea;">
                    <span>Total:</span>
                    <strong>Rp{{ number_format($total, 0, ',', '.') }}</strong>
                </div>

                <!-- Action Buttons -->
                <div class="action-buttons">
                    @if($order->isPending())
                    <form method="POST" action="{{ route('seller.orders.confirm', $order) }}">
                        @csrf
                        <button type="submit" class="btn-action">
                            <i class="fas fa-check me-1"></i>Konfirmasi Pesanan
                        </button>
                    </form>

                    @elseif($order->isProcessing())
                    <button type="button" class="btn-action" onclick="openShipModal()">
                        <i class="fas fa-truck me-1"></i>Kirim Pesanan
                    </button>

                    @endif

                    <a href="{{ route('seller.orders') }}" class="btn-action btn-back">
                        <i class="fas fa-arrow-left me-1"></i>Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Ship Modal -->
<div id="shipModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <i class="fas fa-truck me-2"></i>Kirim Pesanan
        </div>

        <form method="POST" action="{{ route('seller.orders.ship', $order) }}">
            @csrf

            <div class="form-group">
                <label for="tracking_number" class="form-label">Nomor Resi (Opsional)</label>
                <input type="text" class="form-control" id="tracking_number" name="tracking_number" 
                       placeholder="Masukkan nomor resi pengiriman">
                <small class="text-muted">Contoh: 1Z999AA1012345674</small>
            </div>

            <div class="modal-buttons">
                <button type="submit" class="btn-confirm">
                    <i class="fas fa-check me-1"></i>Kirim
                </button>
                <button type="button" class="btn-cancel" onclick="closeShipModal()">
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openShipModal() {
    document.getElementById('shipModal').classList.add('show');
}

function closeShipModal() {
    document.getElementById('shipModal').classList.remove('show');
}

// Close modal when clicking outside
document.getElementById('shipModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeShipModal();
    }
});
</script>
@endsection
