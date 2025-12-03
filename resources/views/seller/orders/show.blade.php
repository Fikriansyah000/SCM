@extends('layouts.seller')

@section('title', 'Detail Pesanan - PestiMart Seller')
@section('page-title', 'Detail Pesanan')

@section('content')
<style>
    .order-detail-container {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 1.5rem;
        max-width: 1100px;
        margin: 0 auto;
    }

    @media (max-width: 991px) {
        .order-detail-container {
            grid-template-columns: 1fr;
        }

        .status-stack {
            align-items: flex-start;
        }
    }

    /* Modern Glass Card */
    .detail-card {
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.98) 0%, rgba(248, 250, 252, 0.95) 100%);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        padding: 1.75rem;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(226, 232, 240, 0.8);
        position: relative;
        overflow: hidden;
    }
    .detail-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--color-primary, #3A7BFF) 0%, #6366f1 50%, var(--color-primary, #3A7BFF) 100%);
        background-size: 200% 100%;
        animation: shimmer 3s ease-in-out infinite;
    }
    @keyframes shimmer {
        0%, 100% { background-position: 200% 0; }
        50% { background-position: 0% 0; }
    }

    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        padding-bottom: 1.25rem;
        border-bottom: 1px solid rgba(226, 232, 240, 0.8);
        flex-wrap: wrap;
        gap: 1rem;
    }

    .section-title {
        font-size: 1rem;
        font-weight: 700;
        color: #1e293b;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .section-title i {
        background: linear-gradient(135deg, var(--color-primary, #3A7BFF) 0%, #6366f1 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .order-number {
        font-size: 1.5rem;
        font-weight: 800;
        background: linear-gradient(135deg, var(--color-primary, #3A7BFF) 0%, #6366f1 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        letter-spacing: -0.02em;
    }

    .order-date {
        font-size: 0.85rem;
        color: #94a3b8;
        margin-top: 0.25rem;
    }

    /* Status Badges */
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.65rem 1.25rem;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.85rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
    }

    .status-pending {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        color: #92400e;
    }

    .status-processing {
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        color: #1e40af;
    }

    .status-shipped {
        background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%);
        color: #4338ca;
    }

    .status-delivered {
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
        color: #065f46;
    }

    .status-completed {
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
        color: #065f46;
    }

    /* Service order badges */
    .status-accepted {
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        color: #1d4ed8;
    }

    .status-in_progress {
        background: linear-gradient(135deg, #c7d2fe 0%, #a5b4fc 100%);
        color: #3730a3;
    }

    .status-review {
        background: linear-gradient(135deg, #ede9fe 0%, #ddd6fe 100%);
        color: #6d28d9;
    }

    .status-revision {
        background: linear-gradient(135deg, #ffedd5 0%, #fed7aa 100%);
        color: #c2410c;
    }

    .status-cancelled {
        background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
        color: #b91c1c;
    }

    .status-stack {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 0.5rem;
    }

    .status-secondary-badge {
        background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
        color: #475569;
        border: 1px dashed rgba(148, 163, 184, 0.6);
        padding: 0.5rem 1rem;
        font-size: 0.8rem;
    }

    /* Order Items */
    .order-item {
        display: flex;
        gap: 1rem;
        padding: 1rem 0;
        border-bottom: 1px solid rgba(226, 232, 240, 0.6);
    }
    .order-item:last-child {
        border-bottom: none;
    }

    .order-item img {
        width: 72px;
        height: 72px;
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        border-radius: 12px;
        object-fit: cover;
        flex-shrink: 0;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
    }

    .item-details {
        flex-grow: 1;
        min-width: 0;
    }

    .item-name {
        font-weight: 600;
        margin-bottom: 0.25rem;
        color: #1e293b;
    }

    .item-qty {
        font-size: 0.82rem;
        color: #94a3b8;
    }

    .item-price {
        color: var(--color-primary, #3A7BFF);
        font-weight: 700;
    }

    /* Buyer Info Card */
    .buyer-info {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        padding: 1.25rem;
        border-radius: 14px;
        margin-bottom: 1rem;
        border: 1px solid rgba(226, 232, 240, 0.6);
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.75rem;
        font-size: 0.9rem;
        flex-wrap: wrap;
        gap: 0.5rem;
    }

    .info-row:last-child {
        margin-bottom: 0;
    }

    .info-label {
        color: #94a3b8;
        font-weight: 500;
    }

    .info-value {
        color: #1e293b;
        font-weight: 600;
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
        margin-top: 1.5rem;
    }

    .btn-action {
        padding: 0.875rem 1.25rem;
        background: linear-gradient(135deg, var(--color-primary, #3A7BFF) 0%, #6366f1 100%);
        color: white;
        border: none;
        border-radius: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        text-decoration: none;
        text-align: center;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        box-shadow: 0 4px 14px rgba(99, 102, 241, 0.3);
    }

    @media (hover: hover) {
        .btn-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(99, 102, 241, 0.4);
            color: white;
        }
    }

    .btn-action:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }

    .btn-back {
        background: linear-gradient(135deg, #94a3b8 0%, #64748b 100%);
        box-shadow: 0 4px 14px rgba(100, 116, 139, 0.3);
    }

    @media (hover: hover) {
        .btn-back:hover {
            box-shadow: 0 6px 20px rgba(100, 116, 139, 0.4);
        }
    }

    /* Form Styles */
    .form-group {
        margin-bottom: 1rem;
    }

    .form-label {
        display: block;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: #1e293b;
    }

    .form-control {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        font-family: inherit;
        font-size: 0.9rem;
        transition: all 0.2s ease;
        background: #f8fafc;
    }

    .form-control:focus {
        border-color: var(--color-primary, #3A7BFF);
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.12);
        outline: none;
        background: white;
    }

    /* Modal */
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.5);
        backdrop-filter: blur(4px);
        z-index: 999;
        align-items: center;
        justify-content: center;
        padding: 1rem;
    }

    .modal.show {
        display: flex;
    }

    .modal-content {
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.98) 0%, rgba(248, 250, 252, 0.95) 100%);
        padding: 2rem;
        border-radius: 20px;
        width: clamp(320px, 95vw, 440px);
        box-shadow: 0 20px 60px rgba(0,0,0,0.2);
        border: 1px solid rgba(226, 232, 240, 0.8);
    }

    .modal-header {
        font-size: 1.15rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
        color: #1e293b;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .modal-header i {
        color: var(--color-primary, #3A7BFF);
    }

    .modal-buttons {
        display: flex;
        gap: 0.75rem;
        margin-top: 1.5rem;
    }

    .modal-buttons button {
        flex: 1;
        padding: 0.75rem;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .btn-confirm {
        background: linear-gradient(135deg, var(--color-primary, #3A7BFF) 0%, #6366f1 100%);
        color: white;
        box-shadow: 0 3px 12px rgba(99, 102, 241, 0.25);
    }

    .btn-cancel {
        background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
        color: #64748b;
    }

    /* Return Section Styles */
    .return-section {
        background: linear-gradient(135deg, rgba(245, 158, 11, 0.08) 0%, rgba(245, 158, 11, 0.15) 100%);
        border-left: 4px solid #f59e0b;
        padding: 1.5rem;
        border-radius: 14px;
        margin: 1.5rem 0;
    }

    .return-status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.5rem 1rem;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.85rem;
        margin-bottom: 1rem;
    }

    .return-status-requested {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        color: #92400e;
    }

    .return-status-approved {
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        color: #1e40af;
    }

    .return-status-shipped {
        background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%);
        color: #4338ca;
    }

    .return-status-received {
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
        color: #065f46;
    }

    .return-status-rejected {
        background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
        color: #991b1b;
    }

    .return-info {
        background: rgba(255, 255, 255, 0.9);
        padding: 1.25rem;
        border-radius: 12px;
        margin-bottom: 1rem;
        border: 1px solid rgba(226, 232, 240, 0.6);
    }

    .return-info-item {
        display: flex;
        justify-content: space-between;
        padding: 0.75rem 0;
        border-bottom: 1px solid rgba(226, 232, 240, 0.6);
        flex-wrap: wrap;
        gap: 0.5rem;
    }

    .return-info-item:last-child {
        border-bottom: none;
    }

    .return-info-label {
        font-weight: 600;
        color: #64748b;
    }

    .return-info-value {
        color: #1e293b;
        font-weight: 500;
    }

    .return-timeline {
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1px solid rgba(245, 158, 11, 0.25);
    }

    .return-timeline-item {
        display: flex;
        gap: 1rem;
        margin-bottom: 0.75rem;
    }

    .return-timeline-dot {
        width: 12px;
        height: 12px;
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        border-radius: 50%;
        margin-top: 0.4rem;
        flex-shrink: 0;
        box-shadow: 0 0 6px rgba(245, 158, 11, 0.4);
    }

    .return-timeline-content {
        font-size: 0.85rem;
    }

    .return-timeline-label {
        font-weight: 600;
        color: #1e293b;
    }

    .return-timeline-date {
        color: #94a3b8;
        font-size: 0.8rem;
    }

    .return-actions {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
        margin-top: 1rem;
    }

    .btn-approve {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
        box-shadow: 0 4px 14px rgba(16, 185, 129, 0.3) !important;
    }

    .btn-reject {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%) !important;
        box-shadow: 0 4px 14px rgba(239, 68, 68, 0.3) !important;
    }

    .btn-confirm-return {
        background: linear-gradient(135deg, var(--color-primary, #3A7BFF) 0%, #6366f1 100%) !important;
    }

    /* Back Button Modern */
    .btn-back-top {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.65rem 1.35rem;
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(248, 250, 252, 0.9) 100%);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(226, 232, 240, 0.8);
        border-radius: 12px;
        color: var(--color-primary, #3A7BFF);
        font-weight: 600;
        font-size: 0.9rem;
        text-decoration: none;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        margin-bottom: 1.25rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    }
    .btn-back-top:hover {
        background: linear-gradient(135deg, var(--color-primary, #3A7BFF) 0%, #6366f1 100%);
        color: white;
        border-color: transparent;
        transform: translateX(-4px);
        box-shadow: 0 6px 20px rgba(99, 102, 241, 0.3);
    }
    .btn-back-top i {
        transition: transform 0.25s ease;
    }
    .btn-back-top:hover i {
        transform: translateX(-3px);
    }

    /* Summary Card */
    .summary-card {
        position: sticky;
        top: 1rem;
    }
    .summary-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 1.25rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .summary-title i {
        background: linear-gradient(135deg, var(--color-primary, #3A7BFF) 0%, #6366f1 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    .summary-row {
        display: flex;
        justify-content: space-between;
        padding: 0.65rem 0;
        border-bottom: 1px solid rgba(226, 232, 240, 0.6);
        font-size: 0.9rem;
    }
    .summary-row:last-of-type {
        border-bottom: none;
    }
    .summary-label {
        color: #64748b;
    }
    .summary-value {
        font-weight: 600;
        color: #1e293b;
    }
    .summary-total {
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 2px solid rgba(99, 102, 241, 0.2);
    }
    .summary-total .summary-label {
        font-weight: 600;
        color: var(--color-primary, #3A7BFF);
    }
    .summary-total .summary-value {
        font-size: 1.25rem;
        font-weight: 800;
        background: linear-gradient(135deg, var(--color-primary, #3A7BFF) 0%, #6366f1 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    @media (max-width: 768px) {
        .modal-content {
            padding: 1.5rem;
        }
        
        .detail-card {
            padding: 1.25rem;
            border-radius: 16px;
        }
        
        .return-section {
            padding: 1rem;
        }

        .order-number {
            font-size: 1.25rem;
        }

        .summary-card {
            position: static;
        }
    }

    @media (max-width: 575.98px) {
        .btn-back-top {
            padding: 0.5rem 1rem;
            font-size: 0.85rem;
        }
        .detail-card {
            padding: 1rem;
            border-radius: 12px;
        }
        .section-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.75rem;
        }
        .order-number {
            font-size: 1.1rem;
        }
        .order-date {
            font-size: 0.8rem;
        }
        .status-stack {
            width: 100%;
        }
        .status-badge {
            font-size: 0.7rem;
            padding: 0.35rem 0.75rem;
        }
        .section-title {
            font-size: 0.95rem;
        }
        .info-row {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.25rem;
        }
        .info-label {
            min-width: auto;
        }
        .summary-card {
            padding: 1rem;
        }
        .summary-card h4 {
            font-size: 1rem;
        }
        .product-card {
            padding: 0.75rem;
        }
        .product-image {
            width: 60px;
            height: 60px;
        }
        .product-name {
            font-size: 0.9rem;
        }
        .product-meta {
            font-size: 0.8rem;
        }
        .product-price {
            font-size: 0.95rem;
        }
        .summary-row {
            font-size: 0.9rem;
        }
        .summary-row.total {
            font-size: 1rem;
        }
        .modal-content {
            padding: 1rem;
        }
        .modal-content h3 {
            font-size: 1.1rem;
        }
        .return-section {
            padding: 0.875rem;
        }
        .return-info-item {
            flex-direction: column;
            gap: 0.25rem;
        }
        .action-buttons {
            flex-direction: column;
            gap: 0.5rem;
        }
        .btn-action {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<a href="{{ route('seller.orders') }}" class="btn-back-top">
    <i class="fas fa-arrow-left"></i>Kembali
</a>

<div class="order-detail-container">
    <!-- Main Content -->
    <div>
        <!-- Order Header -->
        <div class="detail-card">
            @php
                $isServiceOrder = $order->isServiceOrder();
                $primaryStatusKey = $isServiceOrder ? ($order->service_status ?? 'pending') : $order->status;
                $primaryStatusLabel = $isServiceOrder ? $order->getServiceStatusLabel() : $order->getStatusLabel();
            @endphp
            <div class="section-header">
                <div>
                    <div class="order-number">{{ $order->order_number }}</div>
                    <div class="order-date"><i class="far fa-calendar-alt me-1"></i>{{ $order->created_at->format('d M Y H:i') }}</div>
                </div>
                <div class="status-stack">
                    <span class="status-badge status-{{ $primaryStatusKey }}">
                        {{ $isServiceOrder ? 'Status Layanan:' : 'Status Pesanan:' }} {{ $primaryStatusLabel }}
                    </span>
                    @if($isServiceOrder)
                        <span class="status-badge status-secondary-badge">
                            Logistik: {{ $order->getStatusLabel() }}
                            </span>
                        @endif
                    </div>
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

            <!-- Return Request from Buyer -->
                @if($order->return_status)
                <div class="section-title mt-4">
                    <i class="fas fa-undo"></i>Status Pengajuan Retur
                </div>
                <div class="return-section">
                    <span class="return-status-badge return-status-{{ $order->return_status }}">
                        @switch($order->return_status)
                            @case('requested')
                                <i class="fas fa-clock me-1"></i>Retur Diminta
                                @break
                            @case('approved')
                                <i class="fas fa-check-circle me-1"></i>Retur Disetujui
                                @break
                            @case('shipped')
                                <i class="fas fa-truck me-1"></i>Retur Dikirim
                                @break
                            @case('received')
                                <i class="fas fa-check-double me-1"></i>Retur Diterima
                                @break
                            @case('rejected')
                                <i class="fas fa-times-circle me-1"></i>Retur Ditolak
                                @break
                            @default
                                {{ ucfirst($order->return_status) }}
                        @endswitch
                    </span>

                    <div class="return-info">
                        <div class="return-info-item">
                            <span class="return-info-label">Alasan Retur:</span>
                            <span class="return-info-value">
                                {{ $order->return_reason ?? '-' }}
                            </span>
                        </div>

                        @if($order->return_requested_at)
                        <div class="return-info-item">
                            <span class="return-info-label">Tanggal Permintaan:</span>
                            <span class="return-info-value">
                                {{ $order->return_requested_at ? (is_string($order->return_requested_at) ? \Carbon\Carbon::parse($order->return_requested_at)->format('d M Y H:i') : $order->return_requested_at->format('d M Y H:i')) : '-' }}
                            </span>
                        </div>
                        @endif

                        @if($order->return_tracking_number)
                        <div class="return-info-item">
                            <span class="return-info-label">Nomor Resi Retur:</span>
                            <span class="return-info-value">
                                <strong>{{ $order->return_tracking_number }}</strong>
                            </span>
                        </div>
                        @endif

                        @if($order->return_shipped_at)
                        <div class="return-info-item">
                            <span class="return-info-label">Tanggal Pengiriman Retur:</span>
                            <span class="return-info-value">
                                {{ $order->return_shipped_at ? (is_string($order->return_shipped_at) ? \Carbon\Carbon::parse($order->return_shipped_at)->format('d M Y H:i') : $order->return_shipped_at->format('d M Y H:i')) : '-' }}
                            </span>
                        </div>
                        @endif

                        @if($order->return_received_at)
                        <div class="return-info-item">
                            <span class="return-info-label">Tanggal Penerimaan Retur:</span>
                            <span class="return-info-value">
                                {{ $order->return_received_at ? (is_string($order->return_received_at) ? \Carbon\Carbon::parse($order->return_received_at)->format('d M Y H:i') : $order->return_received_at->format('d M Y H:i')) : '-' }}
                            </span>
                        </div>
                        @endif
                    </div>

                    <!-- Timeline Retur -->
                    <div class="return-timeline">
                        <div class="return-timeline-item">
                            <div class="return-timeline-dot"></div>
                            <div class="return-timeline-content">
                                <div class="return-timeline-label">
                                    <i class="fas fa-clock text-warning"></i> Retur Diminta
                                </div>
                                <div class="return-timeline-date">
                                    {{ $order->return_requested_at ? (is_string($order->return_requested_at) ? \Carbon\Carbon::parse($order->return_requested_at)->format('d M Y H:i') : $order->return_requested_at->format('d M Y H:i')) : '-' }}
                                </div>
                            </div>
                        </div>

                        <div class="return-timeline-item">
                            <div class="return-timeline-dot"></div>
                            <div class="return-timeline-content">
                                <div class="return-timeline-label">
                                    <i class="fas fa-check text-info"></i> Disetujui Penjual
                                </div>
                                <div class="return-timeline-date">
                                    @if(in_array($order->return_status, ['approved', 'shipped', 'received']))
                                        Telah Disetujui
                                    @else
                                        Menunggu...
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="return-timeline-item">
                            <div class="return-timeline-dot"></div>
                            <div class="return-timeline-content">
                                <div class="return-timeline-label">
                                    <i class="fas fa-truck text-info"></i> Dikirim Kembali
                                </div>
                                <div class="return-timeline-date">
                                    {{ $order->return_shipped_at ? (is_string($order->return_shipped_at) ? \Carbon\Carbon::parse($order->return_shipped_at)->format('d M Y H:i') : $order->return_shipped_at->format('d M Y H:i')) : 'Menunggu...' }}
                                </div>
                            </div>
                        </div>

                        <div class="return-timeline-item">
                            <div class="return-timeline-dot"></div>
                            <div class="return-timeline-content">
                                <div class="return-timeline-label">
                                    <i class="fas fa-check-double text-success"></i> Diterima Penjual
                                </div>
                                <div class="return-timeline-date">
                                    {{ $order->return_received_at ? (is_string($order->return_received_at) ? \Carbon\Carbon::parse($order->return_received_at)->format('d M Y H:i') : $order->return_received_at->format('d M Y H:i')) : 'Menunggu...' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
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
                <div class="info-row mb-3" style="border-bottom: 1px solid var(--neutral-gray, #ECEEF3); padding-bottom: 1rem;">
                    <span class="info-label">Ongkir:</span>
                    <strong>Rp{{ number_format($shipping, 0, ',', '.') }}</strong>
                </div>
                <div class="info-row" style="font-size: 1.1rem; color: var(--primary, #3A7BFF);">
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

                    {{-- Return management actions --}}
                    @if($order->return_status === 'requested')
                        <div style="background:#e3f2fd;padding:1rem;border-radius:0.5rem;margin-bottom:1rem;">
                            <div style="margin-bottom:0.75rem;color:#1976d2;">
                                <strong><i class="fas fa-info-circle me-1"></i>Pengajuan Retur Baru</strong>
                            </div>
                            <p style="font-size:0.85rem;color:#666;margin-bottom:1rem;">
                                Pembeli telah mengajukan retur dengan alasan: <br>
                                <em>"{{ $order->return_reason }}"</em>
                            </p>
                        </div>

                        <form method="POST" action="{{ route('seller.orders.return.approve', $order) }}" style="margin-bottom:0.75rem;">
                            @csrf
                            <button type="submit" class="btn-action btn-approve">
                                <i class="fas fa-check me-1"></i>Setujui Retur
                            </button>
                        </form>

                        <form method="POST" action="{{ route('seller.orders.return.reject', $order) }}">
                            @csrf
                            <button type="submit" class="btn-action btn-reject">
                                <i class="fas fa-times me-1"></i>Tolak Retur
                            </button>
                        </form>

                    @elseif($order->return_status === 'approved')
                        <div style="background:#e8f5e9;padding:1rem;border-radius:0.5rem;margin-bottom:1rem;">
                            <div style="margin-bottom:0.75rem;color:#388e3c;">
                                <strong><i class="fas fa-check-circle me-1"></i>Retur Telah Disetujui</strong>
                            </div>
                            <p style="font-size:0.85rem;color:#666;">
                                Menunggu pembeli mengirimkan barang kembali dengan nomor resi retur.
                            </p>
                        </div>

                        <a href="{{ route('seller.orders') }}" class="btn-action btn-back">
                            <i class="fas fa-arrow-left me-1"></i>Kembali
                        </a>

                    @elseif($order->return_status === 'shipped')
                        <div style="background:#e1f5fe;padding:1rem;border-radius:0.5rem;margin-bottom:1rem;">
                            <div style="margin-bottom:0.75rem;color:#0277bd;">
                                <strong><i class="fas fa-truck me-1"></i>Barang Dalam Pengiriman</strong>
                            </div>
                            <p style="font-size:0.85rem;color:#666;">
                                Nomor Resi: <strong>{{ $order->return_tracking_number }}</strong> <br>
                                Harap konfirmasi ketika barang retur telah diterima.
                            </p>
                        </div>

                        <form method="POST" action="{{ route('seller.orders.return.confirm-received', $order) }}" style="margin-bottom:0.75rem;">
                            @csrf
                            <button type="submit" class="btn-action btn-confirm-return">
                                <i class="fas fa-check-double me-1"></i>Konfirmasi Retur Diterima
                            </button>
                        </form>

                        <a href="{{ route('seller.orders') }}" class="btn-action btn-back">
                            <i class="fas fa-arrow-left me-1"></i>Kembali
                        </a>

                    @elseif($order->return_status === 'received')
                        <div style="background:#f3e5f5;padding:1rem;border-radius:0.5rem;margin-bottom:1rem;">
                            <div style="margin-bottom:0.75rem;color:#7b1fa2;">
                                <strong><i class="fas fa-check-double me-1"></i>Retur Selesai</strong>
                            </div>
                            <p style="font-size:0.85rem;color:#666;">
                                Proses retur telah selesai. Stok produk telah dikembalikan ke inventory.
                            </p>
                        </div>

                        <a href="{{ route('seller.orders') }}" class="btn-action btn-back">
                            <i class="fas fa-arrow-left me-1"></i>Kembali
                        </a>

                    @elseif($order->return_status === 'rejected')
                        <div style="background:#ffebee;padding:1rem;border-radius:0.5rem;margin-bottom:1rem;">
                            <div style="margin-bottom:0.75rem;color:#c62828;">
                                <strong><i class="fas fa-times-circle me-1"></i>Retur Ditolak</strong>
                            </div>
                            <p style="font-size:0.85rem;color:#666;">
                                Permintaan retur telah ditolak. Transaksi pesanan tetap valid.
                            </p>
                        </div>

                        <a href="{{ route('seller.orders') }}" class="btn-action btn-back">
                            <i class="fas fa-arrow-left me-1"></i>Kembali
                        </a>
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
