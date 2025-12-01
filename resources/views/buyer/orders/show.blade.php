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

    .order-card {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 50%, #e2e8f0 100%);
        border-radius: var(--radius-lg);
        padding: var(--space-4);
        box-shadow: 0 4px 15px rgba(0,0,0,.05), 0 1px 3px rgba(0,0,0,.08);
        border: 1px solid rgba(148, 163, 184, 0.2);
        position: relative;
        overflow: hidden;
    }

    .order-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #3b82f6 0%, #6366f1 50%, #8b5cf6 100%);
        border-radius: var(--radius-lg) var(--radius-lg) 0 0;
    }

    .order-summary {
        background: linear-gradient(135deg, #fefce8 0%, #fef9c3 50%, #fef08a 100%);
        border-radius: var(--radius-lg);
        padding: var(--space-4);
        box-shadow: 0 4px 15px rgba(234, 179, 8, 0.1), 0 1px 3px rgba(0,0,0,.06);
        border: 1px solid rgba(234, 179, 8, 0.3);
        position: relative;
        overflow: hidden;
    }

    .order-summary::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #eab308 0%, #f59e0b 50%, #d97706 100%);
        border-radius: var(--radius-lg) var(--radius-lg) 0 0;
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
        border-bottom: 2px solid rgba(148, 163, 184, 0.2);
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
        background: linear-gradient(135deg, #3b82f6 0%, #6366f1 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .status-badge-big {
        display: inline-block;
        padding: var(--space-3) var(--space-6);
        border-radius: var(--radius-full);
        font-weight: 600;
        font-size: var(--font-size-sm);
    }

    .status-pending { background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); color: #92400e; }
    .status-processing { background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%); color: #1e40af; }
    .status-shipped { background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%); color: #4338ca; }
    .status-delivered { background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%); color: #065f46; }
    .status-completed { background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%); color: #065f46; }

    .section-title {
        font-weight: 600;
        color: #1e293b;
        margin-bottom: var(--space-4);
        margin-top: var(--space-6);
        display: flex;
        align-items: center;
        gap: var(--space-2);
    }

    .section-title i {
        color: #6366f1;
    }

    .section-title:first-child {
        margin-top: 0;
    }

    .order-item {
        display: flex;
        gap: var(--space-4);
        padding: var(--space-4);
        background: linear-gradient(135deg, rgba(255,255,255,0.9) 0%, rgba(248,250,252,0.9) 100%);
        border-radius: var(--radius-md);
        border: 1px solid rgba(148, 163, 184, 0.15);
        margin-bottom: var(--space-3);
        flex-wrap: wrap;
        transition: all 0.2s ease;
    }

    .order-item:hover {
        box-shadow: 0 4px 12px rgba(99, 102, 241, 0.1);
        border-color: rgba(99, 102, 241, 0.2);
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
        padding-left: 2.5rem;
    }

    .order-timeline::before {
        content: '';
        position: absolute;
        left: 12px;
        top: 0;
        bottom: 0;
        width: 3px;
        background: linear-gradient(180deg, #3b82f6 0%, #6366f1 50%, #8b5cf6 100%);
        border-radius: 3px;
    }

    .timeline-item {
        position: relative;
        padding: 1rem 1.25rem;
        margin-bottom: 0.75rem;
        background: linear-gradient(135deg, rgba(255,255,255,0.95) 0%, rgba(248,250,252,0.95) 100%);
        border-radius: .6rem;
        border: 1px solid rgba(148, 163, 184, 0.2);
        box-shadow: 0 2px 8px rgba(0,0,0,.04);
        transition: all 0.3s ease;
    }

    .timeline-item:hover {
        transform: translateX(4px);
        box-shadow: 0 4px 12px rgba(99, 102, 241, 0.12);
        border-color: rgba(99, 102, 241, 0.3);
    }

    .timeline-item:last-child {
        margin-bottom: 0;
    }

    .timeline-dot {
        position: absolute;
        left: -2rem;
        top: 1.25rem;
        width: 14px;
        height: 14px;
        background: linear-gradient(135deg, #94a3b8 0%, #64748b 100%);
        border-radius: var(--radius-full);
        border: 3px solid var(--color-white);
        box-shadow: 0 2px 6px rgba(100, 116, 139, 0.3);
        z-index: 1;
    }

    .timeline-item.active .timeline-dot {
        background: linear-gradient(135deg, #3b82f6 0%, #6366f1 100%);
        box-shadow: 0 2px 6px rgba(99, 102, 241, 0.4);
    }

    .timeline-content h4 {
        font-weight: 600;
        font-size: var(--font-size-sm);
        margin-bottom: var(--space-1);
        color: #1e293b;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .timeline-content p {
        font-size: var(--font-size-xs);
        color: #64748b;
        margin-bottom: 0;
        display: flex;
        align-items: center;
        gap: 0.35rem;
    }

    .timeline-content p::before {
        content: '';
        width: 4px;
        height: 4px;
        background: #cbd5e1;
        border-radius: 50%;
    }

    .summary-item {
        display: flex;
        justify-content: space-between;
        margin-bottom: var(--space-4);
        padding: var(--space-3);
        background: linear-gradient(135deg, rgba(255,255,255,0.8) 0%, rgba(254,252,232,0.8) 100%);
        border-radius: var(--radius-md);
        border: 1px solid rgba(234, 179, 8, 0.15);
    }

    .summary-item:last-child {
        border-bottom: none;
    }

    .order-summary .summary-total {
        display: flex;
        justify-content: space-between;
        font-size: var(--font-size-lg);
        font-weight: 700;
        padding: var(--space-4);
        margin-top: var(--space-3);
        background: linear-gradient(135deg, rgba(234, 179, 8, 0.15) 0%, rgba(245, 158, 11, 0.15) 100%);
        border-radius: var(--radius-md);
        border: 1px solid rgba(234, 179, 8, 0.3);
    }

    .order-summary .summary-total span:last-child {
        background: linear-gradient(135deg, #d97706 0%, #b45309 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    /* Timeline Card */
    .timeline-card {
        background: linear-gradient(135deg, #fafbff 0%, #f0f4ff 50%, #e8ecff 100%);
        border-radius: var(--radius-lg);
        box-shadow: 0 4px 15px rgba(99, 102, 241, 0.08), 0 1px 3px rgba(0,0,0,.06);
        padding: var(--space-6);
        border: 1px solid rgba(99, 102, 241, 0.15);
        position: relative;
        overflow: hidden;
    }

    .timeline-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #6366f1 0%, #8b5cf6 50%, #a855f7 100%);
        border-radius: var(--radius-lg) var(--radius-lg) 0 0;
    }

    .timeline-card .section-title {
        color: #4338ca;
    }

    .timeline-card .section-title i {
        background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    /* Shipping Info Card */
    .shipping-info-box {
        background: linear-gradient(135deg, rgba(255,255,255,0.9) 0%, rgba(248,250,252,0.9) 100%);
        border-radius: var(--radius-md);
        padding: var(--space-4);
        border: 1px solid rgba(148, 163, 184, 0.15);
        margin-bottom: var(--space-3);
    }

    .shipping-info-box p {
        margin-bottom: 0;
    }

    .shipping-info-box strong {
        color: #475569;
    }

    /* Review Form */
    .review-block {
        padding: var(--space-4);
        border-radius: var(--radius-lg);
        margin-top: var(--space-3);
        margin-bottom: var(--space-3);
    }

    .review-block-pending {
        background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%);
        border: 2px solid #fbbf24;
    }

    .review-block-done {
        background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%);
        border: 2px solid #10b981;
    }

    .review-header {
        display: flex;
        align-items: center;
        gap: var(--space-3);
        margin-bottom: var(--space-4);
    }

    .review-header-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
    }

    .review-header-icon.pending {
        background: rgba(251, 191, 36, 0.2);
        color: #b45309;
    }

    .review-header-icon.done {
        background: rgba(16, 185, 129, 0.2);
        color: #065f46;
    }

    .review-header h5 {
        margin: 0;
        font-size: 1rem;
        font-weight: 600;
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
        font-size: 1.5rem;
        color: #e5e7eb;
        cursor: pointer;
        margin-right: 4px;
        transition: all 0.2s ease;
    }

    .stars-input .fa-star.active {
        color: #fbbf24;
    }

    .stars-input .fa-star:hover {
        transform: scale(1.15);
    }

    .rating-stars-display {
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .rating-stars-display .fa-star {
        font-size: 1.25rem;
        color: #e5e7eb;
    }

    .rating-stars-display .fa-star.filled {
        color: #fbbf24;
    }

    .review-content-box {
        background: white;
        border-radius: var(--radius-md);
        padding: var(--space-3);
        margin-top: var(--space-3);
    }

    .review-content-box .review-title {
        font-weight: 600;
        color: var(--color-neutral-dark);
        margin-bottom: var(--space-1);
    }

    .review-content-box .review-text {
        color: var(--color-text-muted);
        margin: 0;
    }

    .review-meta {
        font-size: 0.8rem;
        color: var(--color-text-muted);
        margin-top: var(--space-2);
        display: flex;
        align-items: center;
        gap: var(--space-2);
    }

    .btn-rating-submit {
        background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
        color: white;
        border: none;
        padding: var(--space-3) var(--space-5);
        border-radius: var(--radius-md);
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: var(--space-2);
    }

    .btn-rating-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(251, 191, 36, 0.4);
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

    /* Back Button */
    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.6rem 1.25rem;
        background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
        border: 1px solid rgba(148, 163, 184, 0.3);
        border-radius: 999px;
        color: #475569;
        font-weight: 500;
        font-size: 0.9rem;
        text-decoration: none;
        transition: all 0.3s ease;
        margin-bottom: 1rem;
    }

    .btn-back:hover {
        background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e1 100%);
        color: #1e293b;
        transform: translateX(-4px);
        box-shadow: 0 4px 12px rgba(100, 116, 139, 0.15);
        text-decoration: none;
    }

    .btn-back i {
        transition: transform 0.3s ease;
    }

    .btn-back:hover i {
        transform: translateX(-3px);
    }
</style>

<div class="container my-4">
    <a href="{{ route('buyer.orders') }}" class="btn-back">
        <i class="fas fa-arrow-left"></i>Kembali ke Pesanan
    </a>

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

                @if($existingReview)
                    <div class="review-block review-block-done">
                        <div class="review-header">
                            <div class="review-header-icon done">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div>
                                <h5>Ulasan Anda untuk {{ $item->product->name }}</h5>
                            </div>
                        </div>
                        <div class="review-content-box">
                            <div class="rating-stars-display mb-2">
                                @for($s=1;$s<=5;$s++)
                                    <i class="fas fa-star {{ $s <= $existingReview->rating ? 'filled' : '' }}"></i>
                                @endfor
                                <span class="ms-2 text-muted">({{ $existingReview->rating }}/5)</span>
                            </div>
                            @if($existingReview->title)
                                <div class="review-title">{{ $existingReview->title }}</div>
                            @endif
                            @if($existingReview->review)
                                <p class="review-text">{{ $existingReview->review }}</p>
                            @endif
                            <div class="review-meta">
                                <i class="fas fa-check-circle text-success"></i>
                                Dikirim {{ $existingReview->created_at->format('d M Y H:i') }}
                            </div>
                        </div>
                    </div>
                @else
                    @if(in_array($order->status, ['delivered','completed']))
                        <div class="review-block review-block-pending">
                            <div class="review-header">
                                <div class="review-header-icon pending">
                                    <i class="fas fa-star"></i>
                                </div>
                                <div>
                                    <h5>Berikan Rating untuk {{ $item->product->name }}</h5>
                                </div>
                            </div>
                            <form method="POST" action="{{ route('reviews.store') }}" class="review-form">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $item->product_id }}">
                                <input type="hidden" name="order_id" value="{{ $order->id }}">
                                <input type="hidden" name="rating" id="rating-{{ $item->id }}" value="5">
                                <div class="review-rating-col">
                                    <div class="rating-label">Rating</div>
                                    <div class="stars-input" data-target="#rating-{{ $item->id }}">
                                        @for($s=1;$s<=5;$s++)
                                            <i class="fas fa-star star-clickable active" data-value="{{ $s }}"></i>
                                        @endfor
                                    </div>
                                </div>
                                <div class="review-input-col">
                                    <div class="form-group">
                                        <input name="title" class="form-control" placeholder="Judul ulasan (opsional)" />
                                    </div>
                                    <div class="form-group mt-2">
                                        <textarea name="review" class="form-control" rows="2" placeholder="Ceritakan pengalaman Anda dengan produk ini... (opsional)"></textarea>
                                    </div>
                                </div>
                                <div class="review-submit-col">
                                    <button class="btn-rating-submit" type="submit">
                                        <i class="fas fa-paper-plane"></i>Kirim Ulasan
                                    </button>
                                </div>
                            </form>
                        </div>
                    @endif
                @endif
                @endforeach

                <!-- Shipping Address -->
                <div class="section-title">
                    <i class="fas fa-map-marker-alt"></i>Alamat Pengiriman
                </div>
                <div class="shipping-info-box">
                    <p><i class="fas fa-home me-2" style="color: #6366f1;"></i>{{ $order->shipping_address }}</p>
                </div>

                <!-- Tracking Number -->
                <div class="section-title">
                    <i class="fas fa-shipping-fast"></i>Informasi Pengiriman
                </div>
                <div class="shipping-info-box">
                    <p>
                        <i class="fas fa-box me-2" style="color: #6366f1;"></i><strong>Mode:</strong> {{ $order->getShippingModeLabel() ?? ucfirst($order->shipping_mode) }}<br>
                        <i class="fas fa-coins me-2" style="color: #eab308;"></i><strong>Biaya Ongkir:</strong> Rp{{ number_format($order->shipping_cost ?? 0, 0, ',', '.') }}<br>
                        <i class="fas fa-calendar-alt me-2" style="color: #10b981;"></i><strong>Estimasi Tiba:</strong>
                        @if($order->estimated_delivery)
                            {{ is_string($order->estimated_delivery) ? \Carbon\Carbon::parse($order->estimated_delivery)->format('d M Y H:i') : $order->estimated_delivery->format('d M Y H:i') }}
                        @else
                            -
                        @endif
                        <br>
                        <i class="fas fa-info-circle me-2" style="color: #8b5cf6;"></i><strong>Status Pengiriman:</strong> {{ $order->getShippingStatusLabel() ?? ucfirst($order->shipping_status) }}
                    </p>
                </div>

                @if($order->tracking_number)
                <div class="section-title">
                    <i class="fas fa-barcode"></i>Nomor Resi
                </div>
                <div class="shipping-info-box">
                    <p><i class="fas fa-qrcode me-2" style="color: #6366f1;"></i><strong>{{ $order->tracking_number }}</strong></p>
                    @if($order->live_tracking_url)
                        <a href="{{ $order->live_tracking_url }}" target="_blank" class="btn btn-outline-primary btn-sm mt-2">
                            <i class="fas fa-map-marker-alt me-1"></i>Lacak Pengiriman
                        </a>
                    @endif
                </div>
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
            <div class="timeline-card">
                <div class="section-title" style="margin-top: 0;">
                    <i class="fas fa-stream"></i>Status Pesanan
                </div>
                <div class="order-timeline">
    <div class="timeline-item {{ !$order->isPending() ? 'active' : '' }}">
        <div class="timeline-dot"></div>
        <div class="timeline-content">
            <h4><i class="fas fa-shopping-cart" style="color: #6366f1;"></i>Pesanan Dibuat</h4>
            <p>{{ is_string($order->created_at) ? \Carbon\Carbon::parse($order->created_at)->format('d M Y H:i') : $order->created_at->format('d M Y H:i') }}</p>
        </div>
    </div>

    <div class="timeline-item {{ $order->confirmed_at ? 'active' : '' }}">
        <div class="timeline-dot"></div>
        <div class="timeline-content">
            <h4><i class="fas fa-check-circle" style="color: #10b981;"></i>Dikonfirmasi Penjual</h4>
            <p>{{ $order->confirmed_at ? (is_string($order->confirmed_at) ? \Carbon\Carbon::parse($order->confirmed_at)->format('d M Y H:i') : $order->confirmed_at->format('d M Y H:i')) : 'Menunggu...' }}</p>
        </div>
    </div>

    <div class="timeline-item {{ $order->shipped_at ? 'active' : '' }}">
        <div class="timeline-dot"></div>
        <div class="timeline-content">
            <h4><i class="fas fa-truck" style="color: #3b82f6;"></i>Dalam Pengiriman</h4>
            <p>{{ $order->shipped_at ? (is_string($order->shipped_at) ? \Carbon\Carbon::parse($order->shipped_at)->format('d M Y H:i') : $order->shipped_at->format('d M Y H:i')) : 'Menunggu...' }}</p>
        </div>
    </div>

    <div class="timeline-item {{ $order->delivered_at ? 'active' : '' }}">
        <div class="timeline-dot"></div>
        <div class="timeline-content">
            <h4><i class="fas fa-box-open" style="color: #8b5cf6;"></i>Diterima</h4>
            <p>{{ $order->delivered_at ? (is_string($order->delivered_at) ? \Carbon\Carbon::parse($order->delivered_at)->format('d M Y H:i') : $order->delivered_at->format('d M Y H:i')) : 'Menunggu...' }}</p>
        </div>
    </div>

    <div class="timeline-item {{ $order->completed_at ? 'active' : '' }}">
        <div class="timeline-dot"></div>
        <div class="timeline-content">
            <h4><i class="fas fa-flag-checkered" style="color: #059669;"></i>Selesai</h4>
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
        const activeColor = '#fbbf24';  // Gold/yellow color
        const inactiveColor = '#e5e7eb'; // Light gray
        
        const setRating = (value) => {
            stars.forEach(s => {
                const v = parseInt(s.getAttribute('data-value'));
                s.style.color = v <= value ? activeColor : inactiveColor;
                s.classList.toggle('active', v <= value);
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
                    s.style.color = sv <= v ? activeColor : inactiveColor;
                    s.style.transform = sv === v ? 'scale(1.15)' : 'scale(1)';
                });
            });
            star.addEventListener('mouseout', function() {
                const current = parseInt(target ? target.value : 0) || 5;
                stars.forEach(s => {
                    const sv = parseInt(s.getAttribute('data-value'));
                    s.style.color = sv <= current ? activeColor : inactiveColor;
                    s.style.transform = 'scale(1)';
                });
            });
        });

        // initialize default (5 stars selected by default)
        if (target) setRating(parseInt(target.value) || 5);
    });
});
</script>

@endsection
