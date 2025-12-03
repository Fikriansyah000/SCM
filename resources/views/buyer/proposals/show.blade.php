@extends('layouts.app')

@section('title', 'Detail Pengajuan #' . $proposal->id . ' - PestiMart')

@section('content')
<style>
    @keyframes headerShine {
        0% { background-position: -200% center; }
        100% { background-position: 200% center; }
    }
    
    .proposal-detail-header {
        background: linear-gradient(135deg, #1e3a5f 0%, #2d5a87 50%, #3d6a9f 100%);
        color: white;
        padding: 2.5rem 0;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
    }
    
    .proposal-detail-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
        background-size: 200% 100%;
        animation: headerShine 3s ease-in-out infinite;
    }
    
    .proposal-detail-header .container {
        position: relative;
        z-index: 1;
    }
    
    .proposal-detail-card {
        background: white;
        border-radius: 1rem;
        box-shadow: 0 4px 15px rgba(30, 58, 95, 0.1);
        margin-bottom: 1.5rem;
        overflow: hidden;
        border: 1px solid rgba(30, 58, 95, 0.08);
        transition: all 0.3s ease;
    }
    
    .proposal-detail-card:hover {
        box-shadow: 0 8px 25px rgba(30, 58, 95, 0.15);
        transform: translateY(-2px);
    }
    
    .proposal-detail-card .card-header {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        border-bottom: 1px solid #e2e8f0;
        padding: 1rem 1.5rem;
        font-weight: 600;
        color: #1e3a5f;
    }
    
    .proposal-detail-card .card-header i {
        color: #2d5a87;
    }
    
    .proposal-detail-card .card-body {
        padding: 1.5rem;
    }
    
    .proposal-status-large {
        display: inline-block;
        padding: 0.75rem 1.5rem;
        border-radius: 2rem;
        font-size: 1rem;
        font-weight: 600;
        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
    }
    
    .status-pending {
        background: linear-gradient(135deg, #dbeafe, #bfdbfe);
        color: #1e40af;
    }
    
    .status-accepted {
        background: linear-gradient(135deg, #dcfce7, #bbf7d0);
        color: #166534;
    }
    
    .status-rejected, .status-cancelled {
        background: linear-gradient(135deg, #fee2e2, #fecaca);
        color: #991b1b;
    }
    
    .status-in-progress {
        background: linear-gradient(135deg, #e0e7ff, #c7d2fe);
        color: #3730a3;
    }

    .status-review {
        background: linear-gradient(135deg, #fef3c7, #fde68a);
        color: #92400e;
    }

    .status-revision {
        background: linear-gradient(135deg, #fed7aa, #fdba74);
        color: #9a3412;
    }
    
    .status-completed {
        background: linear-gradient(135deg, #d1fae5, #a7f3d0);
        color: #047857;
    }
    
    .service-product-card {
        display: flex;
        gap: 1.5rem;
        align-items: flex-start;
    }
    
    .service-product-image {
        width: 120px;
        height: 120px;
        background: linear-gradient(135deg, #f1f5f9, #e2e8f0);
        border-radius: 0.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        flex-shrink: 0;
        border: 2px solid #e2e8f0;
    }
    
    .service-product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .service-product-info h4 {
        margin-bottom: 0.5rem;
        color: #1e3a5f;
        font-weight: 700;
    }
    
    .service-product-shop {
        color: #2d5a87;
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
        font-weight: 500;
    }
    
    .service-product-shop i {
        margin-right: 0.25rem;
    }
    
    .price-comparison {
        display: flex;
        gap: 1rem;
        align-items: center;
        margin-top: 1rem;
        padding: 1rem;
        background: linear-gradient(135deg, #eff6ff, #dbeafe);
        border-radius: 0.75rem;
        border: 1px solid #bfdbfe;
    }
    
    .price-item {
        text-align: center;
    }
    
    .price-label {
        font-size: 0.75rem;
        color: #1e40af;
        text-transform: uppercase;
        font-weight: 600;
    }
    
    .price-value {
        font-size: 1.25rem;
        font-weight: 700;
    }
    
    .price-value.original {
        color: #94a3b8;
        text-decoration: line-through;
    }
    
    .price-value.offered {
        color: #1e3a5f;
    }
    
    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
    }
    
    .info-item {
        padding: 1rem;
        background: linear-gradient(135deg, #f8fafc, #f1f5f9);
        border-radius: 0.75rem;
        border: 1px solid #e2e8f0;
    }
    
    .info-item-label {
        font-size: 0.75rem;
        color: #64748b;
        text-transform: uppercase;
        margin-bottom: 0.25rem;
        font-weight: 600;
    }
    
    .info-item-value {
        font-weight: 600;
        color: #1e3a5f;
        font-size: 1.1rem;
    }
    
    .description-box {
        padding: 1.5rem;
        background: linear-gradient(135deg, #eff6ff, #dbeafe);
        border-radius: 0.75rem;
        border-left: 4px solid #2d5a87;
    }
    
    .description-box h6 {
        color: #1e3a5f;
        margin-bottom: 0.75rem;
        font-weight: 600;
    }
    
    .notes-box {
        padding: 1.5rem;
        background: linear-gradient(135deg, #f0fdf4, #dcfce7);
        border-radius: 0.75rem;
        border-left: 4px solid #10b981;
    }
    
    .notes-box h6 {
        color: #166534;
        margin-bottom: 0.75rem;
        font-weight: 600;
    }
    
    .rejection-box {
        padding: 1.5rem;
        background: linear-gradient(135deg, #fef2f2, #fee2e2);
        border-radius: 0.75rem;
        border-left: 4px solid #ef4444;
    }
    
    .rejection-box h6 {
        color: #991b1b;
        margin-bottom: 0.75rem;
        font-weight: 600;
    }
    
    .action-buttons {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }
    
    .btn-action {
        padding: 0.75rem 1.5rem;
        border-radius: 0.75rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
        text-decoration: none;
        border: none;
        cursor: pointer;
    }
    
    .btn-action.btn-primary {
        background: linear-gradient(135deg, #1e3a5f, #2d5a87);
        color: white;
        box-shadow: 0 4px 15px rgba(30, 58, 95, 0.3);
    }
    
    .btn-action.btn-primary:hover {
        background: linear-gradient(135deg, #2d5a87, #3d6a9f);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(30, 58, 95, 0.4);
    }
    
    .btn-action.btn-success {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
    }
    
    .btn-action.btn-success:hover {
        background: linear-gradient(135deg, #059669, #047857);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
    }
    
    .btn-action.btn-outline {
        background: white;
        color: #1e3a5f;
        border: 2px solid #1e3a5f;
    }
    
    .btn-action.btn-outline:hover {
        background: #1e3a5f;
        color: white;
        transform: translateY(-2px);
    }
    
    .btn-action.btn-warning {
        background: linear-gradient(135deg, #f59e0b, #d97706);
        color: white;
        box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3);
    }
    
    .btn-action.btn-warning:hover {
        background: linear-gradient(135deg, #d97706, #b45309);
        transform: translateY(-2px);
    }
    
    .timeline {
        position: relative;
        padding-left: 2rem;
    }
    
    .timeline::before {
        content: '';
        position: absolute;
        left: 0.5rem;
        top: 0;
        bottom: 0;
        width: 2px;
        background: linear-gradient(180deg, #2d5a87, #e2e8f0);
    }
    
    .timeline-item {
        position: relative;
        padding-bottom: 1.5rem;
    }
    
    .timeline-item:last-child {
        padding-bottom: 0;
    }
    
    .timeline-marker {
        position: absolute;
        left: -1.75rem;
        width: 1rem;
        height: 1rem;
        border-radius: 50%;
        background: #2d5a87;
        border: 3px solid white;
        box-shadow: 0 0 0 2px #2d5a87;
    }
    
    .timeline-marker.pending {
        background: #3b82f6;
        box-shadow: 0 0 0 2px #3b82f6;
    }
    
    .timeline-marker.completed {
        background: #10b981;
        box-shadow: 0 0 0 2px #10b981;
    }
    
    .timeline-marker.active {
        background: #8b5cf6;
        box-shadow: 0 0 0 2px #8b5cf6;
    }
    
    .timeline-content {
        padding-left: 0.5rem;
    }
    
    .timeline-title {
        font-weight: 600;
        color: #1e3a5f;
    }
    
    .timeline-date {
        font-size: 0.85rem;
        color: #64748b;
    }
    
    .payment-summary {
        background: linear-gradient(135deg, #1e3a5f 0%, #2d5a87 50%, #3d6a9f 100%);
        color: white;
        padding: 2rem;
        border-radius: 1rem;
        text-align: center;
        position: relative;
        overflow: hidden;
        box-shadow: 0 8px 25px rgba(30, 58, 95, 0.3);
    }
    
    .payment-summary::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
        background-size: 200% 100%;
        animation: headerShine 3s ease-in-out infinite;
    }
    
    .payment-summary h4 {
        margin-bottom: 0.5rem;
        position: relative;
        z-index: 1;
    }
    
    .payment-summary .amount {
        font-size: 2rem;
        font-weight: 700;
        margin: 1rem 0;
        position: relative;
        z-index: 1;
    }
    
    .payment-summary p {
        position: relative;
        z-index: 1;
    }
    
    .payment-summary form {
        position: relative;
        z-index: 1;
    }
    
    .payment-summary .btn-light {
        background: white;
        color: #1e3a5f;
        font-weight: 600;
        border: none;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        transition: all 0.3s ease;
    }
    
    .payment-summary .btn-light:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.25);
    }
    
    .proposal-status-badge {
        display: inline-block;
        padding: 0.35rem 0.75rem;
        border-radius: 1rem;
        font-size: 0.8rem;
        font-weight: 600;
    }
    
    .back-link {
        color: rgba(255,255,255,0.9);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        background: rgba(255,255,255,0.1);
        border-radius: 0.5rem;
        transition: all 0.3s ease;
        margin-bottom: 1rem;
    }
    
    .back-link:hover {
        background: rgba(255,255,255,0.2);
        color: white;
    }
    
    .header-title {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .header-title i {
        font-size: 1.5rem;
        opacity: 0.9;
    }
    
    .seller-card-avatar {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #1e3a5f, #2d5a87);
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1rem;
    }
    
    .seller-card-avatar i {
        font-size: 2rem;
        color: white;
    }
    
    .seller-card-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
    }
    
    .btn-seller-chat {
        background: linear-gradient(135deg, #1e3a5f, #2d5a87);
        color: white;
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
        font-weight: 500;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
    }
    
    .btn-seller-chat:hover {
        background: linear-gradient(135deg, #2d5a87, #3d6a9f);
        color: white;
        transform: translateY(-2px);
    }
</style>

<div class="proposal-detail-header">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <a href="{{ route('buyer.proposals') }}" class="back-link">
                    <i class="fas fa-arrow-left"></i>Kembali ke Daftar Pengajuan
                </a>
                <h2 class="mb-0 header-title">
                    <i class="fas fa-file-alt"></i>Detail Pengajuan #{{ $proposal->id }}
                </h2>
            </div>
            @php
                $statusClass = match($proposal->status) {
                    'pending' => 'status-pending',
                    'accepted' => 'status-accepted',
                    'in_progress' => 'status-in-progress',
                    'review' => 'status-review',
                    'revision' => 'status-revision',
                    'rejected' => 'status-rejected',
                    'completed' => 'status-completed',
                    'cancelled' => 'status-cancelled',
                    default => 'status-pending'
                };
                $statusLabel = match($proposal->status) {
                    'pending' => 'Menunggu Konfirmasi',
                    'accepted' => 'Diterima - Siap Bayar',
                    'in_progress' => 'Dalam Pengerjaan',
                    'review' => 'Menunggu Review',
                    'revision' => 'Revisi Diminta',
                    'rejected' => 'Ditolak',
                    'completed' => 'Selesai',
                    'cancelled' => 'Dibatalkan',
                    default => $proposal->status
                };
            @endphp
            <span class="proposal-status-large {{ $statusClass }}">
                {{ $statusLabel }}
            </span>
        </div>
    </div>
</div>

<div class="container pb-4">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-8">
            <!-- Service Info -->
            <div class="proposal-detail-card">
                <div class="card-header">
                    <i class="fas fa-concierge-bell me-2"></i>Informasi Layanan
                </div>
                <div class="card-body">
                    <div class="service-product-card">
                        <div class="service-product-image">
                            @if($proposal->product && $proposal->product->image)
                                <img src="{{ asset('storage/' . $proposal->product->image) }}" alt="{{ $proposal->product->name }}">
                            @else
                                <i class="fas fa-concierge-bell fa-3x text-muted"></i>
                            @endif
                        </div>
                        <div class="service-product-info">
                            <h4>{{ $proposal->product->name ?? 'Layanan tidak tersedia' }}</h4>
                            <div class="service-product-shop">
                                <i class="fas fa-store"></i>
                                {{ $proposal->seller->shop->name ?? $proposal->seller->name ?? 'Toko' }}
                            </div>
                            @if($proposal->product && $proposal->product->description)
                                <p class="text-muted mb-0">
                                    {{ Str::limit($proposal->product->description, 150) }}
                                </p>
                            @endif
                        </div>
                    </div>
                    
                    <div class="price-comparison">
                        @if($proposal->product)
                            <div class="price-item">
                                <div class="price-label">Harga Awal</div>
                                <div class="price-value original">Rp {{ number_format($proposal->product->price, 0, ',', '.') }}</div>
                            </div>
                            <div class="price-item">
                                <i class="fas fa-arrow-right text-muted"></i>
                            </div>
                        @endif
                        <div class="price-item">
                            <div class="price-label">Harga Penawaran Anda</div>
                            <div class="price-value offered">Rp {{ number_format($proposal->offered_price, 0, ',', '.') }}</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Proposal Details -->
            <div class="proposal-detail-card">
                <div class="card-header">
                    <i class="fas fa-info-circle me-2"></i>Detail Pengajuan
                </div>
                <div class="card-body">
                    <div class="info-grid mb-4">
                        <div class="info-item">
                            <div class="info-item-label">Tanggal Pengajuan</div>
                            <div class="info-item-value">
                                <i class="far fa-calendar-alt text-muted me-1"></i>
                                {{ $proposal->created_at->format('d M Y, H:i') }}
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-item-label">Deadline yang Diminta</div>
                            <div class="info-item-value">
                                <i class="far fa-clock text-muted me-1"></i>
                                {{ $proposal->deadline ? \Carbon\Carbon::parse($proposal->deadline)->format('d M Y') : 'Tidak ditentukan' }}
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-item-label">Status</div>
                            <div class="info-item-value">
                                <span class="proposal-status-badge {{ $statusClass }}">{{ $statusLabel }}</span>
                            </div>
                        </div>
                        @if($proposal->responded_at)
                            <div class="info-item">
                                <div class="info-item-label">Tanggal Respon Seller</div>
                                <div class="info-item-value">
                                    <i class="far fa-check-circle text-muted me-1"></i>
                                    {{ \Carbon\Carbon::parse($proposal->responded_at)->format('d M Y, H:i') }}
                                </div>
                            </div>
                        @endif
                    </div>
                    
                    @if($proposal->description)
                        <div class="description-box mb-4">
                            <h6><i class="fas fa-info-circle me-1"></i>Deskripsi Kebutuhan Anda</h6>
                            <p class="mb-0">{{ $proposal->description }}</p>
                        </div>
                    @endif
                    
                    @if($proposal->notes && $proposal->status != 'rejected')
                        <div class="notes-box">
                            <h6><i class="fas fa-sticky-note me-1"></i>Catatan dari Seller</h6>
                            <p class="mb-0">{{ $proposal->notes }}</p>
                        </div>
                    @endif
                    
                    @if($proposal->status == 'rejected' && $proposal->notes)
                        <div class="rejection-box">
                            <h6><i class="fas fa-times-circle me-1"></i>Alasan Penolakan</h6>
                            <p class="mb-0">{{ $proposal->notes }}</p>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Actions -->
            @if(in_array($proposal->status, ['accepted', 'pending']))
                <div class="proposal-detail-card">
                    <div class="card-header">
                        <i class="fas fa-cog me-2"></i>Tindakan
                    </div>
                    <div class="card-body">
                        <div class="action-buttons">
                            @if($proposal->status == 'accepted')
                                <form action="{{ route('buyer.proposals.pay', $proposal) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn-action btn-success">
                                        <i class="fas fa-credit-card"></i> Lanjutkan ke Pembayaran
                                    </button>
                                </form>
                            @endif
                            
                            <a href="{{ route('buyer.chat') }}?seller={{ $proposal->seller_id }}&shop={{ $proposal->product->shop_id ?? '' }}&proposal_id={{ $proposal->id }}&product_id={{ $proposal->product_id }}" class="btn-action btn-primary">
                                <i class="fas fa-comments"></i> Chat dengan Seller
                            </a>
                            
                            @if($proposal->product)
                                <a href="{{ route('buyer.products.show', $proposal->product) }}" class="btn-action btn-outline">
                                    <i class="fas fa-eye"></i> Lihat Layanan
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </div>
        
        <div class="col-lg-4">
            <!-- Payment Summary (if accepted) -->
            @if($proposal->status == 'accepted')
                <div class="payment-summary mb-4">
                    <h4><i class="fas fa-check-circle me-2"></i>Pengajuan Diterima!</h4>
                    <p class="mb-0 opacity-75">Total yang harus dibayar</p>
                    <div class="amount">Rp {{ number_format($proposal->offered_price, 0, ',', '.') }}</div>
                    <form action="{{ route('buyer.proposals.pay', $proposal) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-light btn-lg w-100">
                            <i class="fas fa-credit-card me-2"></i>Bayar Sekarang
                        </button>
                    </form>
                </div>
            @endif
            
            <!-- Timeline -->
            <div class="proposal-detail-card">
                <div class="card-header">
                    <i class="fas fa-history me-2"></i>Riwayat Status
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-marker completed"></div>
                            <div class="timeline-content">
                                <div class="timeline-title">Pengajuan Dibuat</div>
                                <div class="timeline-date">{{ $proposal->created_at->format('d M Y, H:i') }}</div>
                            </div>
                        </div>
                        
                        @if($proposal->status == 'pending')
                            <div class="timeline-item">
                                <div class="timeline-marker pending"></div>
                                <div class="timeline-content">
                                    <div class="timeline-title">Menunggu Konfirmasi Seller</div>
                                    <div class="timeline-date">Dalam proses</div>
                                </div>
                            </div>
                        @elseif($proposal->status == 'accepted')
                            <div class="timeline-item">
                                <div class="timeline-marker completed"></div>
                                <div class="timeline-content">
                                    <div class="timeline-title">Pengajuan Diterima</div>
                                    <div class="timeline-date">
                                        {{ $proposal->responded_at ? \Carbon\Carbon::parse($proposal->responded_at)->format('d M Y, H:i') : 'Diterima' }}
                                    </div>
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-marker pending"></div>
                                <div class="timeline-content">
                                    <div class="timeline-title">Menunggu Pembayaran</div>
                                    <div class="timeline-date">Silakan lakukan pembayaran</div>
                                </div>
                            </div>
                        @elseif($proposal->status == 'rejected')
                            <div class="timeline-item">
                                <div class="timeline-marker" style="background: #ef4444; box-shadow: 0 0 0 2px #ef4444;"></div>
                                <div class="timeline-content">
                                    <div class="timeline-title text-danger">Pengajuan Ditolak</div>
                                    <div class="timeline-date">
                                        {{ $proposal->responded_at ? \Carbon\Carbon::parse($proposal->responded_at)->format('d M Y, H:i') : 'Ditolak' }}
                                    </div>
                                </div>
                            </div>
                        @elseif($proposal->status == 'in_progress')
                            <div class="timeline-item">
                                <div class="timeline-marker active"></div>
                                <div class="timeline-content">
                                    <div class="timeline-title">Dalam Pengerjaan</div>
                                    <div class="timeline-date">Seller sedang mengerjakan layanan</div>
                                </div>
                            </div>
                        @elseif($proposal->status == 'review')
                            <div class="timeline-item">
                                <div class="timeline-marker pending"></div>
                                <div class="timeline-content">
                                    <div class="timeline-title">Menunggu Review</div>
                                    <div class="timeline-date">Silakan review hasil pekerjaan</div>
                                </div>
                            </div>
                        @elseif($proposal->status == 'revision')
                            <div class="timeline-item">
                                <div class="timeline-marker" style="background: #f59e0b; box-shadow: 0 0 0 2px #f59e0b;"></div>
                                <div class="timeline-content">
                                    <div class="timeline-title text-warning">Revisi Diminta</div>
                                    <div class="timeline-date">Menunggu seller melakukan revisi</div>
                                </div>
                            </div>
                        @elseif($proposal->status == 'completed')
                            <div class="timeline-item">
                                <div class="timeline-marker" style="background: #10b981; box-shadow: 0 0 0 2px #10b981;"></div>
                                <div class="timeline-content">
                                    <div class="timeline-title text-success">Selesai</div>
                                    <div class="timeline-date">Layanan telah selesai</div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Seller Info -->
            <div class="proposal-detail-card">
                <div class="card-header">
                    <i class="fas fa-store me-2"></i>Informasi Seller
                </div>
                <div class="card-body text-center">
                    <div class="seller-card-avatar">
                        @if($proposal->seller && $proposal->seller->avatar)
                            <img src="{{ asset('storage/' . $proposal->seller->avatar) }}" 
                                 alt="{{ $proposal->seller->name }}">
                        @else
                            <i class="fas fa-store"></i>
                        @endif
                    </div>
                    <h5 class="mb-1" style="color: #1e3a5f;">{{ $proposal->seller->shop->name ?? $proposal->seller->name ?? 'Seller' }}</h5>
                    @if($proposal->seller)
                        <p class="text-muted mb-3">{{ $proposal->seller->email }}</p>
                    @endif
                    <a href="{{ route('buyer.chat') }}?seller={{ $proposal->seller_id }}&shop={{ $proposal->product->shop_id ?? '' }}&proposal_id={{ $proposal->id }}&product_id={{ $proposal->product_id }}" class="btn-seller-chat w-100">
                        <i class="fas fa-comments"></i>Chat Seller
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
