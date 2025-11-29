@extends('layouts.app')

@section('title', 'Detail Pesanan - PestiMart')

@section('content')
<style>
    .order-detail-container {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 2rem;
    }

    .order-card,
    .order-summary {
        background: white;
        border-radius: 0.75rem;
        padding: 1.5rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .order-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid #f0f0f0;
    }

    .order-number-big {
        font-size: 1.5rem;
        font-weight: 700;
        color: #667eea;
    }

    .status-badge-big {
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

    .section-title {
        font-weight: 600;
        color: #333;
        margin-bottom: 1rem;
        margin-top: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .order-item {
        display: flex;
        gap: 1rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #f0f0f0;
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

    .item-price {
        color: #667eea;
        font-weight: 600;
    }

    .order-actions {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
        margin-top: 1.5rem;
    }

    .btn-action {
        padding: 0.75rem;
        background: #667eea;
        color: white;
        border: none;
        border-radius: 0.4rem;
        text-decoration: none;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-align: center;
    }

    .btn-action:hover {
        background: #764ba2;
        text-decoration: none;
        color: white;
    }

    .timeline {
        position: relative;
        padding: 1.5rem 0;
    }

    .timeline-item {
        display: flex;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .timeline-item:last-child {
        margin-bottom: 0;
    }

    .timeline-dot {
        width: 16px;
        height: 16px;
        background: #ddd;
        border-radius: 50%;
        margin-top: 0.25rem;
        flex-shrink: 0;
    }

    .timeline-item.active .timeline-dot {
        background: #667eea;
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
    }

    .timeline-content h4 {
        font-weight: 600;
        font-size: 0.95rem;
        margin-bottom: 0.25rem;
    }

    .timeline-content p {
        font-size: 0.85rem;
        color: #999;
        margin-bottom: 0;
    }

    .summary-item {
        display: flex;
        justify-content: space-between;
        margin-bottom: 1rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #f0f0f0;
    }

    .summary-item:last-child {
        border-bottom: none;
    }

    .summary-total {
        display: flex;
        justify-content: space-between;
        font-size: 1.2rem;
        font-weight: 700;
        color: #667eea;
        padding-top: 1rem;
        border-top: 2px solid #f0f0f0;
    }

    @media (max-width: 768px) {
        .order-detail-container {
            grid-template-columns: 1fr;
        }

        .order-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }
    }
<<<<<<< HEAD
    /* Modal styles */
    .modal {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.5);
        z-index: 9999;
        align-items: center;
        justify-content: center;
    }

    .modal.show {
        display: flex;
    }

    .modal-content {
        background: #fff;
        padding: 1.5rem;
        border-radius: 0.5rem;
        max-width: 520px;
        width: 95%;
        box-shadow: 0 8px 30px rgba(0,0,0,0.15);
    }

    .modal-header { font-weight:700; margin-bottom:0.75rem; }

    .btn-confirm {
        padding: 0.6rem 1rem;
        border-radius: 0.4rem;
        background: #667eea;
        color: #fff;
        border: none;
        font-weight: 600;
        cursor: pointer;
    }

    .btn-cancel {
        padding: 0.6rem 1rem;
        border-radius: 0.4rem;
        background: #f0f0f0;
        color: #333;
        border: none;
        font-weight: 600;
        cursor: pointer;
    }
=======
>>>>>>> 81f0d06 (First Up|)
</style>

<div class="container my-4">
    <div class="order-detail-container">
        <!-- Main Content -->
        <div>
            <!-- Order Header -->
            <div class="order-card">
                <div class="order-header">
                    <div>
                        <div class="order-number-big">{{ $order->order_number }}</div>
                        <small class="text-muted">{{ $order->created_at->format('d M Y H:i') }}</small>
                    </div>
                    <span class="status-badge-big status-{{ $order->status }}">
                        {{ $order->getStatusLabel() }}
                    </span>
                </div>

                <!-- Order Items -->
                <div class="section-title">
                    <i class="fas fa-box"></i>Produk
                </div>
                @foreach($order->items as $item)
                <div class="order-item">
                    <img src="{{ $item->product->image ? asset('storage/' . $item->product->image) : asset('images/no-product.png') }}" alt="{{ $item->product->name }}">
                    <div class="item-details">
                        <div class="item-name">{{ $item->product->name }}</div>
                        <small class="text-muted">{{ $item->quantity }}x</small>
                    </div>
                    <div class="item-price">
                        Rp{{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                    </div>
                </div>
<<<<<<< HEAD
                {{-- Review block per item --}}
                @php
                    $existingReview = \App\Models\ProductReview::where('product_id', $item->product_id)
                        ->where('user_id', auth()->id())
                        ->where('order_id', $order->id)
                        ->first();
                @endphp

                <div style="padding: 0.75rem 1rem 1.5rem; border-bottom: 1px dashed #eee;">
                    @if($existingReview)
                        <div><strong>Ulasan Anda:</strong></div>
                        <div style="margin-top:6px;">
                            <div>
                                @for($s=1;$s<=5;$s++)
                                    <i class="fas fa-star" style="color: {{ $s <= $existingReview->rating ? '#f6ad55' : '#ddd' }};"></i>
                                @endfor
                            </div>
                            @if($existingReview->title)
                                <div style="font-weight:700; margin-top:6px;">{{ $existingReview->title }}</div>
                            @endif
                            @if($existingReview->review)
                                <div class="text-muted" style="margin-top:6px;">{{ $existingReview->review }}</div>
                            @endif
                        </div>
                    @else
                        @if(in_array($order->status, ['delivered','completed']))
                            <form method="POST" action="{{ route('reviews.store') }}" style="display:flex; gap:10px; align-items:flex-start; flex-wrap:wrap;">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $item->product_id }}">
                                <input type="hidden" name="order_id" value="{{ $order->id }}">
                                <input type="hidden" name="rating" id="rating-{{ $item->id }}" value="5">
                                <div style="flex: 0 0 220px;">
                                    <div style="font-weight:700; margin-bottom:6px;">Berikan Rating</div>
                                    <div class="stars-input" data-target="#rating-{{ $item->id }}">
                                        @for($s=1;$s<=5;$s++)
                                            <i class="fas fa-star star-clickable" data-value="{{ $s }}" style="font-size:20px; color: #f0f0f0; cursor:pointer; margin-right:4px;"></i>
                                        @endfor
                                    </div>
                                </div>
                                <div style="flex:1; min-width:240px;">
                                    <div class="form-group">
                                        <input name="title" class="form-control" placeholder="Judul ulasan (opsional)" />
                                    </div>
                                    <div class="form-group" style="margin-top:6px;">
                                        <textarea name="review" class="form-control" rows="2" placeholder="Tulis ulasan Anda... (opsional)"></textarea>
                                    </div>
                                </div>
                                <div style="flex:0 0 140px; display:flex; align-items:center;">
                                    <button class="btn btn-primary" type="submit">Kirim Ulasan</button>
                                </div>
                            </form>
                        @endif
                    @endif
                </div>
=======
>>>>>>> 81f0d06 (First Up|)
                @endforeach

                <!-- Shipping Address -->
                <div class="section-title">
                    <i class="fas fa-map-marker-alt"></i>Alamat Pengiriman
                </div>
                <p>{{ $order->shipping_address }}</p>

                <!-- Tracking Number -->
<<<<<<< HEAD
                <div class="section-title">
                    <i class="fas fa-shipping-fast"></i>Informasi Pengiriman
                </div>
                <p>
                    <strong>Mode:</strong> {{ $order->getShippingModeLabel() ?? ucfirst($order->shipping_mode) }}<br>
                    <strong>Biaya Ongkir:</strong> Rp{{ number_format($order->shipping_cost ?? 0, 0, ',', '.') }}<br>
                    <strong>Estimasi Tiba:</strong>
                    @if($order->estimated_delivery)
                        {{ is_string($order->estimated_delivery) ? \Carbon\Carbon::parse($order->estimated_delivery)->format('d M Y H:i') : $order->estimated_delivery->format('d M Y H:i') }}
                    @else
                        -
                    @endif
                    <br>
                    <strong>Status Pengiriman:</strong> {{ $order->getShippingStatusLabel() ?? ucfirst($order->shipping_status) }}
                </p>

=======
>>>>>>> 81f0d06 (First Up|)
                @if($order->tracking_number)
                <div class="section-title">
                    <i class="fas fa-barcode"></i>Nomor Resi
                </div>
                <p><strong>{{ $order->tracking_number }}</strong></p>
<<<<<<< HEAD
                    @if($order->live_tracking_url)
                        <p><a href="{{ $order->live_tracking_url }}" target="_blank" class="btn btn-outline-primary btn-sm">Lacak Pengiriman</a></p>
                    @endif
=======
>>>>>>> 81f0d06 (First Up|)
                @endif

                <!-- Order Actions -->
                <div class="order-actions">
                    <!-- Jika status SHIPPED, tampilkan tombol konfirmasi diterima -->
@if($order->status === 'shipped')
    <form method="POST" action="{{ route('buyer.orders.confirm-delivery', $order) }}">
        @csrf
        <button type="submit" class="btn btn-success">
            <i class="fas fa-box-open"></i> Konfirmasi Diterima
        </button>
    </form>
@endif

<!-- Jika status DELIVERED, tampilkan tombol Selesaikan -->
@if($order->status === 'delivered')
    <form method="POST" action="{{ route('buyer.orders.complete', $order) }}">
        @csrf
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-check"></i> Selesaikan Pesanan
        </button>
    </form>
@endif

<<<<<<< HEAD
                {{-- Return flow: request return when delivered/completed and no active return --}}
                @if(in_array($order->status, ['delivered','completed']) && !$order->return_status)
                    <button type="button" class="btn btn-warning" onclick="openReturnModal()">
                        <i class="fas fa-undo"></i> Ajukan Retur
                    </button>
                @endif

                {{-- If return is approved, buyer can ship return --}}
                @if($order->return_status === 'approved')
                    <button type="button" class="btn btn-outline-primary" onclick="openShipReturnModal()">
                        <i class="fas fa-truck"></i> Kirim Retur
                    </button>
                @endif

                {{-- Show status note for return states --}}
                @if($order->return_status)
                    <div style="margin-top:8px;">
                        <small class="text-muted">Status Retur: <strong>{{ ucfirst($order->return_status) }}</strong></small>
                        @if($order->return_reason)
                            <div><small>Alasan: {{ $order->return_reason }}</small></div>
                        @endif
                        @if($order->return_tracking_number)
                            <div><small>Resi Retur: {{ $order->return_tracking_number }}</small></div>
                        @endif
                    </div>
                @endif

=======
>>>>>>> 81f0d06 (First Up|)
                </div>
            </div>

            <!-- Timeline -->
            <div class="order-card">
                <div class="section-title">
                    <i class="fas fa-clock"></i>Status Pesanan
                </div>
                <div class="timeline">
    <div class="timeline-item {{ !$order->isPending() ? 'active' : '' }}">
        <div class="timeline-dot"></div>
        <div class="timeline-content">
            <h4>Pesanan Dibuat</h4>
            <p>{{ is_string($order->created_at) ? \Carbon\Carbon::parse($order->created_at)->format('d M Y H:i') : $order->created_at->format('d M Y H:i') }}</p>
        </div>
    </div>

    <div class="timeline-item {{ $order->confirmed_at ? 'active' : '' }}">
        <div class="timeline-dot"></div>
        <div class="timeline-content">
            <h4>Dikonfirmasi Penjual</h4>
            <p>{{ $order->confirmed_at ? (is_string($order->confirmed_at) ? \Carbon\Carbon::parse($order->confirmed_at)->format('d M Y H:i') : $order->confirmed_at->format('d M Y H:i')) : 'Menunggu...' }}</p>
        </div>
    </div>

    <div class="timeline-item {{ $order->shipped_at ? 'active' : '' }}">
        <div class="timeline-dot"></div>
        <div class="timeline-content">
            <h4>Dalam Pengiriman</h4>
            <p>{{ $order->shipped_at ? (is_string($order->shipped_at) ? \Carbon\Carbon::parse($order->shipped_at)->format('d M Y H:i') : $order->shipped_at->format('d M Y H:i')) : 'Menunggu...' }}</p>
        </div>
    </div>

    <div class="timeline-item {{ $order->delivered_at ? 'active' : '' }}">
        <div class="timeline-dot"></div>
        <div class="timeline-content">
            <h4>Diterima</h4>
            <p>{{ $order->delivered_at ? (is_string($order->delivered_at) ? \Carbon\Carbon::parse($order->delivered_at)->format('d M Y H:i') : $order->delivered_at->format('d M Y H:i')) : 'Menunggu...' }}</p>
        </div>
    </div>

    <div class="timeline-item {{ $order->completed_at ? 'active' : '' }}">
        <div class="timeline-dot"></div>
        <div class="timeline-content">
            <h4>Selesai</h4>
            <p>{{ $order->completed_at ? (is_string($order->completed_at) ? \Carbon\Carbon::parse($order->completed_at)->format('d M Y H:i') : $order->completed_at->format('d M Y H:i')) : 'Menunggu...' }}</p>
        </div>
    </div>
</div>

            </div>
        </div>

<<<<<<< HEAD
        <!-- Return Request Modal -->
        <div id="returnModal" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <i class="fas fa-undo me-2"></i>Ajukan Retur
                </div>

                <form method="POST" action="{{ route('buyer.orders.request-return', $order) }}">
                    @csrf
                    <div class="form-group">
                        <label for="reason" class="form-label">Alasan Retur</label>
                        <textarea name="reason" id="reason" class="form-control" rows="4" required placeholder="Jelaskan alasan retur..."></textarea>
                    </div>

                    <div class="modal-buttons">
                        <button type="submit" class="btn-confirm">
                            <i class="fas fa-paper-plane me-1"></i>Kirim Permintaan
                        </button>
                        <button type="button" class="btn-cancel" onclick="closeReturnModal()">Batal</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Ship Return Modal -->
        <div id="shipReturnModal" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <i class="fas fa-truck me-2"></i>Kirim Retur
                </div>

                <form method="POST" action="{{ route('buyer.orders.ship-return', $order) }}">
                    @csrf
                    <div class="form-group">
                        <label for="return_tracking_number" class="form-label">Nomor Resi (Opsional)</label>
                        <input type="text" class="form-control" id="return_tracking_number" name="return_tracking_number" placeholder="Nomor resi pengembalian">
                        <small class="text-muted">Jika ada resi, masukkan di sini.</small>
                    </div>

                    <div class="modal-buttons">
                        <button type="submit" class="btn-confirm">
                            <i class="fas fa-check me-1"></i>Kirim Retur
                        </button>
                        <button type="button" class="btn-cancel" onclick="closeShipReturnModal()">Batal</button>
                    </div>
                </form>
            </div>
        </div>

=======
>>>>>>> 81f0d06 (First Up|)
        <!-- Sidebar -->
        <div>
            <div class="order-summary">
                <div class="section-title">
                    <i class="fas fa-receipt"></i>Ringkasan
                </div>

                @php
                    $subtotal = $order->items->sum(fn($item) => $item->price * $item->quantity);
<<<<<<< HEAD
                    $shipping = $order->shipping_cost ?? 0;
=======
                    $shipping = $order->shipping_method === 'delivery' ? 10000 : 0;
>>>>>>> 81f0d06 (First Up|)
                    $total = $subtotal + $shipping;
                @endphp

                <div class="summary-item">
                    <span>Subtotal</span>
                    <strong>Rp{{ number_format($subtotal, 0, ',', '.') }}</strong>
                </div>

                <div class="summary-item">
<<<<<<< HEAD
                    <span>Ongkir <small class="text-muted">({{ $order->getShippingModeLabel() }})</small></span>
                    <strong>Rp{{ number_format($shipping, 0, ',', '.') }}</strong>
                </div>

                <div class="summary-item">
                    <span>Estimasi Tiba</span>
                    <strong>
                        @if($order->estimated_delivery)
                            {{ is_string($order->estimated_delivery) ? \Carbon\Carbon::parse($order->estimated_delivery)->format('d M Y') : $order->estimated_delivery->format('d M Y') }}
                        @else
                            -
                        @endif
                    </strong>
                </div>

=======
                    <span>Ongkir</span>
                    <strong>Rp{{ number_format($shipping, 0, ',', '.') }}</strong>
                </div>

>>>>>>> 81f0d06 (First Up|)
                <div class="summary-total">
                    <span>Total</span>
                    <span>Rp{{ number_format($total, 0, ',', '.') }}</span>
                </div>

                <div class="section-title mt-3">
                    <i class="fas fa-store"></i>Penjual
                </div>
                <p>
                    <strong>{{ $order->shop->shop_name }}</strong><br>
                    <small class="text-muted">{{ $order->shop->address }}</small>
                </p>

                <a href="{{ route('buyer.shop.visit', $order->shop) }}" class="btn btn-outline-primary w-100 mt-2">
                    <i class="fas fa-store me-1"></i>Kunjungi Toko
                </a>
            </div>
        </div>
    </div>
</div>
<<<<<<< HEAD
<script>
function openReturnModal() {
    const el = document.getElementById('returnModal');
    if (el) el.classList.add('show');
}

function closeReturnModal() {
    const el = document.getElementById('returnModal');
    if (el) el.classList.remove('show');
}

function openShipReturnModal() {
    const el = document.getElementById('shipReturnModal');
    if (el) el.classList.add('show');
}

function closeShipReturnModal() {
    const el = document.getElementById('shipReturnModal');
    if (el) el.classList.remove('show');
}

// Close modals when clicking outside the content
['returnModal', 'shipReturnModal'].forEach(id => {
    const modal = document.getElementById(id);
    if (!modal) return;
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            modal.classList.remove('show');
        }
    });
});

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

=======
>>>>>>> 81f0d06 (First Up|)
@endsection
