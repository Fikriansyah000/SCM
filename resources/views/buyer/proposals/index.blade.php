@extends('layouts.app')

@section('title', 'Pengajuan Layanan Saya - PestiMart')

@section('content')
<style>
    .proposals-header {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: white;
        padding: 2rem 0;
        margin-bottom: 2rem;
    }
    
    .proposal-card {
        background: white;
        border: 1px solid #e0e0e0;
        border-radius: 0.75rem;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        transition: all 0.3s ease;
    }
    
    .proposal-card:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    
    .proposal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #f0f0f0;
    }
    
    .proposal-number {
        font-weight: 600;
        color: #333;
    }
    
    .proposal-date {
        font-size: 0.85rem;
        color: #999;
    }
    
    .proposal-status-badge {
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
    
    .status-accepted {
        background: #dcfce7;
        color: #166534;
    }
    
    .status-rejected {
        background: #fee2e2;
        color: #991b1b;
    }
    
    .status-negotiating {
        background: #dbeafe;
        color: #0c4a6e;
    }
    
    .status-expired {
        background: #f3f4f6;
        color: #6b7280;
    }
    
    .proposal-content {
        margin: 1rem 0;
    }
    
    .proposal-product {
        display: flex;
        gap: 1rem;
        margin-bottom: 1rem;
    }
    
    .proposal-product-image {
        width: 80px;
        height: 80px;
        background: #f0f0f0;
        border-radius: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        flex-shrink: 0;
    }
    
    .proposal-product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .proposal-product-info {
        flex-grow: 1;
    }
    
    .proposal-product-name {
        font-weight: 600;
        color: #333;
        margin-bottom: 0.25rem;
        font-size: 1.1rem;
    }
    
    .proposal-shop {
        font-size: 0.85rem;
        color: #667eea;
        margin-bottom: 0.5rem;
    }
    
    .proposal-shop i {
        margin-right: 0.25rem;
    }
    
    .proposal-details {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 1rem;
        margin-top: 1rem;
        padding: 1rem;
        background: #f9fafb;
        border-radius: 0.5rem;
    }
    
    .detail-item {
        text-align: center;
    }
    
    .detail-label {
        font-size: 0.75rem;
        color: #999;
        text-transform: uppercase;
        margin-bottom: 0.25rem;
    }
    
    .detail-value {
        font-weight: 600;
        color: #333;
    }
    
    .detail-value.price {
        color: #f59e0b;
        font-size: 1.1rem;
    }
    
    .proposal-description {
        margin-top: 1rem;
        padding: 1rem;
        background: #fffbeb;
        border-radius: 0.5rem;
        border-left: 4px solid #f59e0b;
    }
    
    .proposal-description-label {
        font-size: 0.75rem;
        color: #92400e;
        text-transform: uppercase;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }
    
    .proposal-description-text {
        color: #333;
        line-height: 1.6;
    }
    
    .proposal-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 1rem;
        border-top: 1px solid #f0f0f0;
        margin-top: 1rem;
    }
    
    .proposal-actions {
        display: flex;
        gap: 0.5rem;
    }
    
    .btn-proposal-action {
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
    
    .btn-proposal-action:hover {
        background: #667eea;
        color: white;
    }
    
    .btn-proposal-action.btn-primary {
        background: #f59e0b;
        border-color: #f59e0b;
        color: white;
    }
    
    .btn-proposal-action.btn-primary:hover {
        background: #d97706;
        border-color: #d97706;
    }
    
    .btn-proposal-action.btn-success {
        background: #10b981;
        border-color: #10b981;
        color: white;
    }
    
    .btn-proposal-action.btn-success:hover {
        background: #059669;
        border-color: #059669;
    }
    
    .empty-proposals {
        text-align: center;
        padding: 3rem;
        background: white;
        border-radius: 0.75rem;
    }
    
    .empty-proposals i {
        font-size: 3rem;
        color: #ddd;
        margin-bottom: 1rem;
    }
    
    .status-info {
        margin-top: 0.5rem;
        font-size: 0.85rem;
        color: #666;
    }
    
    .status-info i {
        margin-right: 0.25rem;
    }
    
    .nav-tabs-proposals {
        background: white;
        border-radius: 0.5rem;
        padding: 0.5rem;
        margin-bottom: 1.5rem;
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }
    
    .nav-tabs-proposals .nav-link {
        border: none;
        background: transparent;
        color: #666;
        padding: 0.75rem 1.25rem;
        border-radius: 0.5rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    
    .nav-tabs-proposals .nav-link:hover {
        background: #f3f4f6;
    }
    
    .nav-tabs-proposals .nav-link.active {
        background: #f59e0b;
        color: white;
    }
    
    .nav-tabs-proposals .badge {
        margin-left: 0.5rem;
        font-size: 0.75rem;
    }
</style>

<div class="proposals-header">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2>
                    <i class="fas fa-file-alt me-2"></i>Pengajuan Layanan Saya
                </h2>
                <p class="mb-0 mt-2 opacity-75">Kelola pengajuan layanan yang sedang menunggu persetujuan seller</p>
            </div>
            <a href="{{ route('buyer.home') }}?tab=services" class="btn btn-light">
                <i class="fas fa-plus me-2"></i>Cari Layanan
            </a>
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

    <!-- Filter Tabs -->
    <div class="nav-tabs-proposals">
        <a href="{{ route('buyer.proposals') }}" class="nav-link {{ !request('status') ? 'active' : '' }}">
            Semua
        </a>
        <a href="{{ route('buyer.proposals', ['status' => 'pending']) }}" class="nav-link {{ request('status') == 'pending' ? 'active' : '' }}">
            <i class="fas fa-clock"></i> Menunggu
        </a>
        <a href="{{ route('buyer.proposals', ['status' => 'accepted']) }}" class="nav-link {{ request('status') == 'accepted' ? 'active' : '' }}">
            <i class="fas fa-check-circle"></i> Diterima
        </a>
        <a href="{{ route('buyer.proposals', ['status' => 'rejected']) }}" class="nav-link {{ request('status') == 'rejected' ? 'active' : '' }}">
            <i class="fas fa-times-circle"></i> Ditolak
        </a>
        <a href="{{ route('buyer.proposals', ['status' => 'negotiating']) }}" class="nav-link {{ request('status') == 'negotiating' ? 'active' : '' }}">
            <i class="fas fa-comments"></i> Negosiasi
        </a>
    </div>

    @if($proposals->count() > 0)
        @foreach($proposals as $proposal)
            <div class="proposal-card">
                <div class="proposal-header">
                    <div>
                        <div class="proposal-number">Pengajuan #{{ $proposal->id }}</div>
                        <div class="proposal-date">
                            <i class="far fa-calendar-alt me-1"></i>
                            {{ $proposal->created_at->format('d M Y, H:i') }}
                        </div>
                    </div>
                    <div class="text-end">
                        @php
                            $statusClass = match($proposal->status) {
                                'pending' => 'status-pending',
                                'accepted' => 'status-accepted',
                                'rejected' => 'status-rejected',
                                'negotiating' => 'status-negotiating',
                                'expired' => 'status-expired',
                                default => 'status-pending'
                            };
                            $statusLabel = match($proposal->status) {
                                'pending' => 'Menunggu Konfirmasi',
                                'accepted' => 'Diterima - Siap Bayar',
                                'rejected' => 'Ditolak',
                                'negotiating' => 'Dalam Negosiasi',
                                'expired' => 'Kadaluarsa',
                                default => $proposal->status
                            };
                        @endphp
                        <span class="proposal-status-badge {{ $statusClass }}">
                            {{ $statusLabel }}
                        </span>
                        @if($proposal->status == 'pending')
                            <div class="status-info">
                                <i class="fas fa-hourglass-half"></i>
                                Menunggu respon seller
                            </div>
                        @elseif($proposal->status == 'accepted')
                            <div class="status-info text-success">
                                <i class="fas fa-credit-card"></i>
                                Silakan lakukan pembayaran
                            </div>
                        @endif
                    </div>
                </div>
                
                <div class="proposal-content">
                    <div class="proposal-product">
                        <div class="proposal-product-image">
                            @if($proposal->product && $proposal->product->image)
                                <img src="{{ asset('storage/' . $proposal->product->image) }}" alt="{{ $proposal->product->name }}">
                            @else
                                <i class="fas fa-concierge-bell fa-2x text-muted"></i>
                            @endif
                        </div>
                        <div class="proposal-product-info">
                            <div class="proposal-product-name">
                                {{ $proposal->product->name ?? 'Layanan tidak tersedia' }}
                            </div>
                            <div class="proposal-shop">
                                <i class="fas fa-store"></i>
                                {{ $proposal->seller->shop->name ?? $proposal->seller->name ?? 'Toko' }}
                            </div>
                        </div>
                    </div>
                    
                    <div class="proposal-details">
                        <div class="detail-item">
                            <div class="detail-label">Harga yang Ditawarkan</div>
                            <div class="detail-value price">Rp {{ number_format($proposal->offered_price, 0, ',', '.') }}</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Deadline</div>
                            <div class="detail-value">
                                <i class="far fa-calendar text-muted me-1"></i>
                                {{ $proposal->deadline ? \Carbon\Carbon::parse($proposal->deadline)->format('d M Y') : '-' }}
                            </div>
                        </div>
                        @if($proposal->product)
                            <div class="detail-item">
                                <div class="detail-label">Harga Awal</div>
                                <div class="detail-value text-muted">
                                    <s>Rp {{ number_format($proposal->product->price, 0, ',', '.') }}</s>
                                </div>
                            </div>
                        @endif
                    </div>
                    
                    @if($proposal->description)
                        <div class="proposal-description">
                            <div class="proposal-description-label">
                                <i class="fas fa-info-circle me-1"></i>Deskripsi Kebutuhan
                            </div>
                            <div class="proposal-description-text">
                                {{ Str::limit($proposal->description, 200) }}
                            </div>
                        </div>
                    @endif
                </div>
                
                <div class="proposal-footer">
                    <div>
                        @if($proposal->notes)
                            <small class="text-muted">
                                <i class="fas fa-sticky-note me-1"></i>
                                Catatan Seller: {{ Str::limit($proposal->notes, 100) }}
                            </small>
                        @endif
                    </div>
                    <div class="proposal-actions">
                        <a href="{{ route('buyer.proposals.show', $proposal) }}" class="btn-proposal-action">
                            <i class="fas fa-eye"></i> Detail
                        </a>
                        
                        @if($proposal->status == 'accepted')
                            <form action="{{ route('buyer.proposals.pay', $proposal) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn-proposal-action btn-success">
                                    <i class="fas fa-credit-card"></i> Bayar Sekarang
                                </button>
                            </form>
                        @elseif($proposal->status == 'pending')
                            <a href="{{ route('buyer.chat') }}?seller={{ $proposal->seller_id }}" class="btn-proposal-action btn-primary">
                                <i class="fas fa-comments"></i> Chat Seller
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
        
        <div class="d-flex justify-content-center mt-4">
            {{ $proposals->links() }}
        </div>
    @else
        <div class="empty-proposals">
            <i class="fas fa-file-alt d-block"></i>
            <h5>Belum Ada Pengajuan Layanan</h5>
            <p class="text-muted">Anda belum memiliki pengajuan layanan. Cari layanan yang Anda butuhkan dan ajukan proposal!</p>
            <a href="{{ route('buyer.home') }}?tab=services" class="btn btn-primary mt-3">
                <i class="fas fa-search me-2"></i>Cari Layanan
            </a>
        </div>
    @endif
</div>
@endsection
