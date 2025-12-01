@extends('layouts.app')

@section('title', 'Detail Pengajuan #' . $proposal->id . ' - PestiMart')

@section('content')
<style>
    .proposal-detail-header {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: white;
        padding: 2rem 0;
        margin-bottom: 2rem;
    }
    
    .proposal-detail-card {
        background: white;
        border-radius: 0.75rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        margin-bottom: 1.5rem;
        overflow: hidden;
    }
    
    .proposal-detail-card .card-header {
        background: #f9fafb;
        border-bottom: 1px solid #e5e7eb;
        padding: 1rem 1.5rem;
        font-weight: 600;
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
    }
    
    .status-pending {
        background: #fef3c7;
        color: #92400e;
    }
    
    .status-accepted {
        background: #dcfce7;
        color: #166534;
    }
    
    .status-rejected, .status-cancelled {
        background: #fee2e2;
        color: #991b1b;
    }
    
    .status-in-progress {
        background: #dbeafe;
        color: #0c4a6e;
    }

    .status-review {
        background: #e0e7ff;
        color: #3730a3;
    }

    .status-revision {
        background: #fef3c7;
        color: #92400e;
    }
    
    .service-product-card {
        display: flex;
        gap: 1.5rem;
        align-items: flex-start;
    }
    
    .service-product-image {
        width: 120px;
        height: 120px;
        background: #f0f0f0;
        border-radius: 0.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        flex-shrink: 0;
    }
    
    .service-product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .service-product-info h4 {
        margin-bottom: 0.5rem;
        color: #333;
    }
    
    .service-product-shop {
        color: #667eea;
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
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
        background: #fffbeb;
        border-radius: 0.5rem;
    }
    
    .price-item {
        text-align: center;
    }
    
    .price-label {
        font-size: 0.75rem;
        color: #92400e;
        text-transform: uppercase;
    }
    
    .price-value {
        font-size: 1.25rem;
        font-weight: 700;
    }
    
    .price-value.original {
        color: #999;
        text-decoration: line-through;
    }
    
    .price-value.offered {
        color: #f59e0b;
    }
    
    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
    }
    
    .info-item {
        padding: 1rem;
        background: #f9fafb;
        border-radius: 0.5rem;
    }
    
    .info-item-label {
        font-size: 0.75rem;
        color: #999;
        text-transform: uppercase;
        margin-bottom: 0.25rem;
    }
    
    .info-item-value {
        font-weight: 600;
        color: #333;
        font-size: 1.1rem;
    }
    
    .description-box {
        padding: 1.5rem;
        background: #fffbeb;
        border-radius: 0.5rem;
        border-left: 4px solid #f59e0b;
    }
    
    .description-box h6 {
        color: #92400e;
        margin-bottom: 0.75rem;
    }
    
    .notes-box {
        padding: 1.5rem;
        background: #f0fdf4;
        border-radius: 0.5rem;
        border-left: 4px solid #10b981;
    }
    
    .notes-box h6 {
        color: #166534;
        margin-bottom: 0.75rem;
    }
    
    .rejection-box {
        padding: 1.5rem;
        background: #fef2f2;
        border-radius: 0.5rem;
        border-left: 4px solid #ef4444;
    }
    
    .rejection-box h6 {
        color: #991b1b;
        margin-bottom: 0.75rem;
    }
    
    .action-buttons {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }
    
    .btn-action {
        padding: 0.75rem 1.5rem;
        border-radius: 0.5rem;
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
        background: #667eea;
        color: white;
    }
    
    .btn-action.btn-primary:hover {
        background: #5a67d8;
    }
    
    .btn-action.btn-success {
        background: #10b981;
        color: white;
    }
    
    .btn-action.btn-success:hover {
        background: #059669;
    }
    
    .btn-action.btn-outline {
        background: white;
        color: #667eea;
        border: 2px solid #667eea;
    }
    
    .btn-action.btn-outline:hover {
        background: #667eea;
        color: white;
    }
    
    .btn-action.btn-warning {
        background: #f59e0b;
        color: white;
    }
    
    .btn-action.btn-warning:hover {
        background: #d97706;
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
        background: #e5e7eb;
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
        background: #667eea;
        border: 3px solid white;
        box-shadow: 0 0 0 2px #667eea;
    }
    
    .timeline-marker.pending {
        background: #f59e0b;
        box-shadow: 0 0 0 2px #f59e0b;
    }
    
    .timeline-marker.completed {
        background: #10b981;
        box-shadow: 0 0 0 2px #10b981;
    }
    
    .timeline-content {
        padding-left: 0.5rem;
    }
    
    .timeline-title {
        font-weight: 600;
        color: #333;
    }
    
    .timeline-date {
        font-size: 0.85rem;
        color: #999;
    }
    
    .payment-summary {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        padding: 2rem;
        border-radius: 0.75rem;
        text-align: center;
    }
    
    .payment-summary h4 {
        margin-bottom: 0.5rem;
    }
    
    .payment-summary .amount {
        font-size: 2rem;
        font-weight: 700;
        margin: 1rem 0;
    }
</style>

<div class="proposal-detail-header">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <a href="{{ route('buyer.proposals') }}" class="text-white text-decoration-none mb-2 d-inline-block">
                    <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar Pengajuan
                </a>
                <h2 class="mb-0">
                    <i class="fas fa-file-alt me-2"></i>Detail Pengajuan #{{ $proposal->id }}
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
                    <div class="mb-3">
                        @if($proposal->seller && $proposal->seller->avatar)
                            <img src="{{ asset('storage/' . $proposal->seller->avatar) }}" 
                                 alt="{{ $proposal->seller->name }}"
                                 class="rounded-circle"
                                 style="width: 80px; height: 80px; object-fit: cover;">
                        @else
                            <div class="rounded-circle bg-primary d-inline-flex align-items-center justify-content-center"
                                 style="width: 80px; height: 80px;">
                                <i class="fas fa-store fa-2x text-white"></i>
                            </div>
                        @endif
                    </div>
                    <h5 class="mb-1">{{ $proposal->seller->shop->name ?? $proposal->seller->name ?? 'Seller' }}</h5>
                    @if($proposal->seller)
                        <p class="text-muted mb-3">{{ $proposal->seller->email }}</p>
                    @endif
                    <a href="{{ route('buyer.chat') }}?seller={{ $proposal->seller_id }}&shop={{ $proposal->product->shop_id ?? '' }}&proposal_id={{ $proposal->id }}&product_id={{ $proposal->product_id }}" class="btn btn-outline-primary btn-sm w-100">
                        <i class="fas fa-comments me-1"></i>Chat Seller
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
