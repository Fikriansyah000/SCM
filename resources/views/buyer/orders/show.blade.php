@extends('layouts.app')

@section('title', 'Detail Pesanan - PestiMart')

@section('content')
<style>
    .order-detail-container {
        display: grid;
        grid-template-columns: 1fr;
        gap: var(--space-6);
    }

    @media (min-width: 992px) {
        .order-detail-container {
            grid-template-columns: 2fr 1fr;
        }
    }

    .order-card,
    .order-summary {
        background: var(--color-white);
        border-radius: var(--radius-lg);
        padding: var(--space-4);
        box-shadow: var(--shadow-card);
        border: 1px solid var(--color-border);
    }

    @media (min-width: 768px) {
        .order-card,
        .order-summary {
            padding: var(--space-6);
        }
    }

    .order-header {
        display: flex;
        flex-direction: column;
        gap: var(--space-4);
        margin-bottom: var(--space-6);
        padding-bottom: var(--space-4);
        border-bottom: 2px solid var(--color-border);
    }

    @media (min-width: 576px) {
        .order-header {
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
        }
    }

    .order-number-big {
        font-size: var(--font-size-2xl);
        font-weight: 700;
        color: var(--color-primary);
    }

    .status-badge-big {
        display: inline-block;
        padding: var(--space-3) var(--space-6);
        border-radius: var(--radius-full);
        font-weight: 600;
        font-size: var(--font-size-sm);
    }

    .status-pending { background: var(--color-warning-light); color: #856404; }
    .status-processing { background: var(--color-info-light); color: var(--color-info); }
    .status-shipped { background: rgba(58, 123, 255, 0.15); color: var(--color-primary); }
    .status-delivered { background: var(--color-success-light); color: var(--color-success); }
    .status-completed { background: var(--color-success-light); color: var(--color-success); }

    .section-title {
        font-weight: 600;
        color: var(--color-neutral-dark);
        margin-bottom: var(--space-4);
        margin-top: var(--space-6);
        display: flex;
        align-items: center;
        gap: var(--space-2);
    }

    .section-title:first-child {
        margin-top: 0;
    }

    .order-item {
        display: flex;
        gap: var(--space-4);
        padding-bottom: var(--space-4);
        border-bottom: 1px solid var(--color-border);
        flex-wrap: wrap;
    }

    .order-item img {
        width: 80px;
        height: 80px;
        background: var(--color-neutral-gray);
        border-radius: var(--radius-md);
        object-fit: cover;
        flex-shrink: 0;
    }

    .item-details {
        flex: 1;
        min-width: 0;
    }

    .item-name {
        font-weight: 600;
        margin-bottom: var(--space-1);
        color: var(--color-neutral-dark);
    }

    .item-price {
        color: var(--color-primary);
        font-weight: 600;
        white-space: nowrap;
    }

    .order-actions {
        display: flex;
        flex-direction: column;
        gap: var(--space-3);
        margin-top: var(--space-6);
    }

    .order-actions .btn {
        width: 100%;
    }

    @media (min-width: 576px) {
        .order-actions {
            flex-direction: row;
            flex-wrap: wrap;
        }
        .order-actions .btn {
            width: auto;
        }
    }

    .order-timeline {
        position: relative;
        padding-left: var(--space-8);
    }

    .order-timeline::before {
        content: '';
        position: absolute;
        left: 7px;
        top: 4px;
        bottom: 4px;
        width: 2px;
        background: var(--color-border);
    }

    .timeline-item {
        position: relative;
        margin-bottom: var(--space-6);
    }

    .timeline-item:last-child {
        margin-bottom: 0;
    }

    .timeline-dot {
        position: absolute;
        left: calc(-1 * var(--space-8) + 4px);
        width: 16px;
        height: 16px;
        background: var(--color-neutral-gray);
        border-radius: var(--radius-full);
        border: 3px solid var(--color-white);
        box-shadow: var(--shadow-sm);
    }

    .timeline-item.active .timeline-dot {
        background: var(--color-primary);
        box-shadow: 0 0 0 4px rgba(58, 123, 255, 0.15);
    }

    .timeline-content h4 {
        font-weight: 600;
        font-size: var(--font-size-sm);
        margin-bottom: var(--space-1);
        color: var(--color-neutral-dark);
    }

    .timeline-content p {
        font-size: var(--font-size-xs);
        color: var(--color-text-muted);
        margin-bottom: 0;
    }

    .summary-item {
        display: flex;
        justify-content: space-between;
        margin-bottom: var(--space-4);
        padding-bottom: var(--space-4);
        border-bottom: 1px solid var(--color-border);
    }

    .summary-item:last-child {
        border-bottom: none;
    }

    .order-summary .summary-total {
        display: flex;
        justify-content: space-between;
        font-size: var(--font-size-lg);
        font-weight: 700;
        color: var(--color-primary);
        padding-top: var(--space-4);
        border-top: 2px solid var(--color-border);
    }

    /* Review Form */
    .review-block {
        padding: var(--space-4);
        border-bottom: 1px dashed var(--color-border);
    }

    .review-form {
        display: flex;
        gap: var(--space-4);
        flex-wrap: wrap;
        align-items: flex-start;
    }

    .review-rating-col {
        flex: 0 0 180px;
    }

    .review-input-col {
        flex: 1;
        min-width: 200px;
    }

    .review-submit-col {
        flex: 0 0 auto;
        display: flex;
        align-items: flex-end;
    }

    @media (max-width: 575.98px) {
        .review-rating-col,
        .review-input-col,
        .review-submit-col {
            flex: 1 1 100%;
        }
    }

    .rating-label {
        font-weight: 700;
        margin-bottom: var(--space-2);
        color: var(--color-neutral-dark);
    }

    .stars-input .fa-star {
        font-size: 20px;
        color: var(--color-neutral-gray);
        cursor: pointer;
        margin-right: var(--space-1);
        transition: color var(--transition-fast);
    }

    .stars-input .fa-star.active {
        color: var(--color-accent);
    }

    /* Return status */
    .return-status-block {
        margin-top: var(--space-3);
        padding: var(--space-3);
        background: var(--color-neutral-light);
        border-radius: var(--radius-md);
    }

    /* Modal styles */
    .modal {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.5);
        z-index: var(--z-modal);
        align-items: center;
        justify-content: center;
    }

    .modal.show {
        display: flex;
    }

    .modal-content {
        background: var(--color-white);
        padding: var(--space-6);
        border-radius: var(--radius-xl);
        max-width: 520px;
        width: clamp(320px, 95vw, 520px);
        box-shadow: var(--shadow-lg);
    }

    .modal-header {
        font-weight: 700;
        font-size: var(--font-size-lg);
        margin-bottom: var(--space-4);
        color: var(--color-neutral-dark);
    }

    .modal-buttons {
        display: flex;
        gap: var(--space-3);
        margin-top: var(--space-6);
        flex-wrap: wrap;
    }

    .btn-confirm {
        padding: var(--space-3) var(--space-6);
        border-radius: var(--radius-md);
        background: var(--gradient-primary);
        color: var(--color-white);
        border: none;
        font-weight: 600;
        cursor: pointer;
        transition: transform var(--transition-fast);
    }

    @media (hover: hover) {
        .btn-confirm:hover {
            transform: translateY(-2px);
        }
    }

    .btn-cancel {
        padding: var(--space-3) var(--space-6);
        border-radius: var(--radius-md);
        background: var(--color-neutral-gray);
        color: var(--color-text-primary);
        border: none;
        font-weight: 600;
        cursor: pointer;
    }

    @media (max-width: 575.98px) {
        .modal-content {
            padding: var(--space-4);
        }
    }

    /* Sticky sidebar on desktop */
    @media (min-width: 992px) {
        .order-summary-wrapper {
            position: sticky;
            top: var(--space-4);
        }
    }
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
                {{-- Review block per item --}}
                @php
                    $existingReview = \App\Models\ProductReview::where('product_id', $item->product_id)
                        ->where('user_id', auth()->id())
                        ->where('order_id', $order->id)
                        ->first();
                @endphp

                <div class="review-block">
                    @if($existingReview)
                        <div class="font-semibold mb-2">Ulasan Anda:</div>
                        <div class="mt-2">
                            <div class="rating-stars">
                                @for($s=1;$s<=5;$s++)
                                    <i class="fas fa-star {{ $s <= $existingReview->rating ? 'filled' : '' }}"></i>
                                @endfor
                            </div>
                            @if($existingReview->title)
                                <div class="font-bold mt-2">{{ $existingReview->title }}</div>
                            @endif
                            @if($existingReview->review)
                                <div class="text-muted mt-2">{{ $existingReview->review }}</div>
                            @endif
                        </div>
                    @else
                        @if(in_array($order->status, ['delivered','completed']))
                            <form method="POST" action="{{ route('reviews.store') }}" class="review-form">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $item->product_id }}">
                                <input type="hidden" name="order_id" value="{{ $order->id }}">
                                <input type="hidden" name="rating" id="rating-{{ $item->id }}" value="5">
                                <div class="review-rating-col">
                                    <div class="rating-label">Berikan Rating</div>
                                    <div class="stars-input" data-target="#rating-{{ $item->id }}">
                                        @for($s=1;$s<=5;$s++)
                                            <i class="fas fa-star star-clickable" data-value="{{ $s }}"></i>
                                        @endfor
                                    </div>
                                </div>
                                <div class="review-input-col">
                                    <div class="form-group">
                                        <input name="title" class="form-control" placeholder="Judul ulasan (opsional)" />
                                    </div>
                                    <div class="form-group mt-2">
                                        <textarea name="review" class="form-control" rows="2" placeholder="Tulis ulasan Anda... (opsional)"></textarea>
                                    </div>
                                </div>
                                <div class="review-submit-col">
                                    <button class="btn-gradient" type="submit">Kirim Ulasan</button>
                                </div>
                            </form>
                        @endif
                    @endif
                </div>
                @endforeach

                <!-- Shipping Address -->
                <div class="section-title">
                    <i class="fas fa-map-marker-alt"></i>Alamat Pengiriman
                </div>
                <p>{{ $order->shipping_address }}</p>

                <!-- Tracking Number -->
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

                @if($order->tracking_number)
                <div class="section-title">
                    <i class="fas fa-barcode"></i>Nomor Resi
                </div>
                <p><strong>{{ $order->tracking_number }}</strong></p>
                    @if($order->live_tracking_url)
                        <p><a href="{{ $order->live_tracking_url }}" target="_blank" class="btn btn-outline-primary btn-sm">Lacak Pengiriman</a></p>
                    @endif
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
                    <div class="return-status-block">
                        <small class="text-muted">Status Retur: <strong>{{ ucfirst($order->return_status) }}</strong></small>
                        @if($order->return_reason)
                            <div><small>Alasan: {{ $order->return_reason }}</small></div>
                        @endif
                        @if($order->return_tracking_number)
                            <div><small>Resi Retur: {{ $order->return_tracking_number }}</small></div>
                        @endif
                    </div>
                @endif

                </div>
            </div>

            <!-- Timeline -->
            <div class="order-card">
                <div class="section-title">
                    <i class="fas fa-clock"></i>Status Pesanan
                </div>
                <div class="order-timeline">
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

        <!-- Sidebar -->
        <div class="order-summary-wrapper">
            <div class="order-summary">
                <div class="section-title">
                    <i class="fas fa-receipt"></i>Ringkasan
                </div>

                @php
                    $subtotal = $order->items->sum(fn($item) => $item->price * $item->quantity);
                    $shipping = $order->shipping_cost ?? 0;
                    $total = $subtotal + $shipping;
                @endphp

                <div class="summary-item">
                    <span>Subtotal</span>
                    <strong>Rp{{ number_format($subtotal, 0, ',', '.') }}</strong>
                </div>

                <div class="summary-item">
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

                <div class="summary-total">
                    <span>Total</span>
                    <span>Rp{{ number_format($total, 0, ',', '.') }}</span>
                </div>

                <div class="section-title mt-4">
                    <i class="fas fa-store"></i>Penjual
                </div>
                <p>
                    <strong>{{ $order->shop->shop_name }}</strong><br>
                    <small class="text-muted">{{ $order->shop->address }}</small>
                </p>

                <a href="{{ route('buyer.shop.visit', $order->shop) }}" class="btn-gradient w-full mt-3">
                    <i class="fas fa-store me-1"></i>Kunjungi Toko
                </a>
            </div>
        </div>
    </div>
</div>
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
        const accentColor = getComputedStyle(document.documentElement).getPropertyValue('--color-accent').trim() || '#FF8F3A';
        const neutralColor = getComputedStyle(document.documentElement).getPropertyValue('--color-neutral-gray').trim() || '#ECEEF3';
        
        const setRating = (value) => {
            stars.forEach(s => {
                const v = parseInt(s.getAttribute('data-value'));
                s.style.color = v <= value ? accentColor : neutralColor;
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
                    s.style.color = sv <= v ? accentColor : neutralColor;
                });
            });
            star.addEventListener('mouseout', function() {
                const current = parseInt(target ? target.value : 0) || 0;
                stars.forEach(s => {
                    const sv = parseInt(s.getAttribute('data-value'));
                    s.style.color = sv <= current ? accentColor : neutralColor;
                });
            });
        });

        // initialize default
        if (target) setRating(parseInt(target.value) || 5);
    });
});
</script>

@endsection
