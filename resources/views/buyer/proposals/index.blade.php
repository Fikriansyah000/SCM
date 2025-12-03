@extends('layouts.app')

@section('title', 'Pengajuan Layanan Saya - PestiMart')

@section('content')
<style>
    /* Proposals Header */
    .proposals-header {
        background: linear-gradient(135deg, #1e3a5f 0%, #2d5a87 50%, #1e3a5f 100%);
        color: white;
        padding: 2.5rem 0;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
    }

    .proposals-header::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 60%);
        animation: headerShine 8s linear infinite;
    }

    @keyframes headerShine {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .proposals-header .container {
        position: relative;
        z-index: 1;
    }

    .proposals-header h2 {
        font-size: 1.75rem;
        font-weight: 700;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .proposals-header h2 i {
        background: rgba(255,255,255,0.2);
        padding: 0.6rem;
        border-radius: 50%;
        font-size: 1.2rem;
    }

    .proposals-header-subtitle {
        margin-top: 0.5rem;
        opacity: 0.9;
        font-size: 0.95rem;
    }

    .proposals-header .btn-light {
        background: rgba(255,255,255,0.95);
        border: none;
        color: #1e3a5f;
        font-weight: 700;
        padding: 0.65rem 1.25rem;
        border-radius: 0.75rem;
        transition: all 0.3s ease;
    }

    .proposals-header .btn-light:hover {
        background: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    /* Stats Section */
    .proposals-stats {
        display: flex;
        gap: 1rem;
        margin-top: 1.25rem;
        flex-wrap: wrap;
    }

    .stat-item {
        background: rgba(255,255,255,0.15);
        backdrop-filter: blur(10px);
        padding: 0.6rem 1.25rem;
        border-radius: 2rem;
        font-size: 0.85rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    /* Proposal Card */
    .proposal-card {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 1rem;
        padding: 0;
        margin-bottom: 1.25rem;
        transition: all 0.3s ease;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    }
    
    .proposal-card:hover {
        box-shadow: 0 8px 24px rgba(30, 58, 95, 0.12);
        transform: translateY(-2px);
        border-color: #cbd5e1;
    }

    .proposal-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        padding: 1.25rem 1.5rem;
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        border-bottom: 1px solid #e5e7eb;
        flex-wrap: wrap;
        gap: 1rem;
    }
    
    .proposal-number {
        font-weight: 700;
        color: #1e293b;
        font-size: 1rem;
    }
    
    .proposal-date {
        font-size: 0.8rem;
        color: #64748b;
        margin-top: 0.25rem;
        display: flex;
        align-items: center;
        gap: 0.35rem;
    }
    
    .proposal-status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.5rem 1rem;
        border-radius: 2rem;
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .status-pending {
        background: linear-gradient(135deg, #fef3c7, #fde68a);
        color: #92400e;
        box-shadow: 0 2px 8px rgba(251, 191, 36, 0.3);
    }
    
    .status-accepted {
        background: linear-gradient(135deg, #dcfce7, #bbf7d0);
        color: #166534;
        box-shadow: 0 2px 8px rgba(34, 197, 94, 0.3);
    }
    
    .status-rejected, .status-cancelled {
        background: linear-gradient(135deg, #fee2e2, #fecaca);
        color: #991b1b;
        box-shadow: 0 2px 8px rgba(239, 68, 68, 0.3);
    }
    
    .status-in-progress {
        background: linear-gradient(135deg, #dbeafe, #bfdbfe);
        color: #1e40af;
        box-shadow: 0 2px 8px rgba(59, 130, 246, 0.3);
    }

    .status-review {
        background: linear-gradient(135deg, #e0e7ff, #c7d2fe);
        color: #4338ca;
        box-shadow: 0 2px 8px rgba(99, 102, 241, 0.3);
    }

    .status-revision {
        background: linear-gradient(135deg, #fef3c7, #fde68a);
        color: #92400e;
        box-shadow: 0 2px 8px rgba(251, 191, 36, 0.3);
    }

    .status-completed {
        background: linear-gradient(135deg, #dcfce7, #bbf7d0);
        color: #166534;
        box-shadow: 0 2px 8px rgba(34, 197, 94, 0.3);
    }
    
    .proposal-content {
        padding: 1.25rem 1.5rem;
    }
    
    .proposal-product {
        display: flex;
        gap: 1rem;
        margin-bottom: 1rem;
        align-items: center;
    }
    
    .proposal-product-image {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
        border-radius: 0.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        flex-shrink: 0;
        border: 2px solid #e5e7eb;
    }
    
    .proposal-product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .proposal-product-info {
        flex-grow: 1;
        min-width: 0;
    }
    
    .proposal-product-name {
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 0.35rem;
        font-size: 1.1rem;
    }
    
    .proposal-shop {
        font-size: 0.85rem;
        color: #1e3a5f;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.35rem;
    }
    
    .proposal-shop i {
        color: #2d5a87;
    }
    
    .proposal-details {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 1rem;
        margin-top: 1rem;
        padding: 1.25rem;
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        border-radius: 0.75rem;
        border: 1px solid #e5e7eb;
    }
    
    .detail-item {
        text-align: center;
    }
    
    .detail-label {
        font-size: 0.75rem;
        color: #64748b;
        text-transform: uppercase;
        margin-bottom: 0.35rem;
        font-weight: 600;
        letter-spacing: 0.5px;
    }
    
    .detail-value {
        font-weight: 700;
        color: #1e293b;
    }
    
    .detail-value.price {
        color: #1e3a5f;
        font-size: 1.15rem;
    }
    
    .proposal-description {
        margin-top: 1rem;
        padding: 1rem 1.25rem;
        background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
        border-radius: 0.75rem;
        border-left: 4px solid #1e3a5f;
    }
    
    .proposal-description-label {
        font-size: 0.75rem;
        color: #1e3a5f;
        text-transform: uppercase;
        font-weight: 700;
        margin-bottom: 0.5rem;
        letter-spacing: 0.5px;
    }
    
    .proposal-description-text {
        color: #334155;
        line-height: 1.6;
        font-size: 0.95rem;
    }
    
    .proposal-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1.25rem 1.5rem;
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        border-top: 1px solid #e5e7eb;
        flex-wrap: wrap;
        gap: 1rem;
    }
    
    .proposal-actions {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
    }
    
    .btn-proposal-action {
        padding: 0.65rem 1.25rem;
        border: 2px solid #1e3a5f;
        border-radius: 0.75rem;
        background: white;
        color: #1e3a5f;
        font-size: 0.85rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .btn-proposal-action:hover {
        background: linear-gradient(135deg, #1e3a5f, #2d5a87);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(30, 58, 95, 0.25);
        text-decoration: none;
    }
    
    .btn-proposal-action.btn-primary {
        background: linear-gradient(135deg, #1e3a5f, #2d5a87);
        border-color: transparent;
        color: white;
    }
    
    .btn-proposal-action.btn-primary:hover {
        background: linear-gradient(135deg, #2d5a87, #3d6a9f);
        box-shadow: 0 6px 16px rgba(30, 58, 95, 0.35);
    }
    
    .btn-proposal-action.btn-success {
        background: linear-gradient(135deg, #059669, #10b981);
        border-color: transparent;
        color: white;
    }
    
    .btn-proposal-action.btn-success:hover {
        background: linear-gradient(135deg, #047857, #059669);
        box-shadow: 0 6px 16px rgba(16, 185, 129, 0.35);
    }
    
    /* Empty State */
    .empty-proposals {
        text-align: center;
        padding: 4rem 2rem;
        background: white;
        border-radius: 1rem;
        border: 2px dashed #e5e7eb;
    }

    .empty-proposals-icon {
        width: 100px;
        height: 100px;
        background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
    }
    
    .empty-proposals i {
        font-size: 2.5rem;
        color: #94a3b8;
    }

    .empty-proposals h5 {
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 0.5rem;
    }

    .empty-proposals p {
        color: #64748b;
        margin-bottom: 1.5rem;
    }

    .empty-proposals .btn-primary {
        background: linear-gradient(135deg, #1e3a5f, #2d5a87);
        border: none;
        padding: 0.75rem 1.75rem;
        border-radius: 0.75rem;
        font-weight: 700;
        transition: all 0.3s ease;
    }

    .empty-proposals .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(30, 58, 95, 0.3);
    }
    
    .status-info {
        margin-top: 0.5rem;
        font-size: 0.8rem;
        color: #64748b;
        display: flex;
        align-items: center;
        gap: 0.35rem;
    }
    
    /* Filter Tabs */
    .nav-tabs-proposals {
        background: white;
        border-radius: 1rem;
        padding: 0.75rem;
        margin-bottom: 1.5rem;
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        border: 1px solid #e5e7eb;
    }
    
    .nav-tabs-proposals .nav-link {
        border: none;
        background: transparent;
        color: #64748b;
        padding: 0.65rem 1.25rem;
        border-radius: 0.75rem;
        font-weight: 600;
        transition: all 0.3s ease;
        font-size: 0.875rem;
        display: flex;
        align-items: center;
        gap: 0.4rem;
    }
    
    .nav-tabs-proposals .nav-link:hover {
        background: #f1f5f9;
        color: #1e3a5f;
    }
    
    .nav-tabs-proposals .nav-link.active {
        background: linear-gradient(135deg, #1e3a5f, #2d5a87);
        color: white;
    }
    
    .nav-tabs-proposals .badge {
        margin-left: 0.5rem;
        font-size: 0.7rem;
        background: rgba(255,255,255,0.25);
        padding: 0.2rem 0.5rem;
        border-radius: 999px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .proposals-header {
            padding: 1.75rem 0;
        }

        .proposals-header h2 {
            font-size: 1.4rem;
        }

        .proposals-header .d-flex {
            flex-direction: column;
            align-items: flex-start !important;
            gap: 1rem;
        }

        .proposal-header,
        .proposal-content,
        .proposal-footer {
            padding: 1rem;
        }

        .proposal-product-image {
            width: 65px;
            height: 65px;
        }

        .proposal-details {
            grid-template-columns: repeat(2, 1fr);
            padding: 1rem;
        }

        .proposal-actions {
            width: 100%;
        }

        .btn-proposal-action {
            flex: 1;
            justify-content: center;
        }

        .nav-tabs-proposals {
            gap: 0.35rem;
            padding: 0.5rem;
        }

        .nav-tabs-proposals .nav-link {
            padding: 0.5rem 0.85rem;
            font-size: 0.8rem;
        }
    }
</style>

<div class="proposals-header">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2>
                    <i class="fas fa-file-signature"></i>
                    Pengajuan Layanan Saya
                </h2>
                <p class="proposals-header-subtitle mb-0 mt-2">Kelola pengajuan layanan yang sedang menunggu persetujuan seller</p>
                <div class="proposals-stats">
                    <div class="stat-item">
                        <i class="fas fa-file-alt"></i>
                        <span>{{ $proposals->total() }} Total Pengajuan</span>
                    </div>
                    <div class="stat-item">
                        <i class="fas fa-clock"></i>
                        <span>{{ $proposals->where('status', 'pending')->count() }} Menunggu</span>
                    </div>
                    <div class="stat-item">
                        <i class="fas fa-check-circle"></i>
                        <span>{{ $proposals->where('status', 'accepted')->count() }} Diterima</span>
                    </div>
                </div>
            </div>
            <a href="{{ route('buyer.home') }}?tab=services" class="btn btn-light">
                <i class="fas fa-search me-2"></i>Cari Layanan
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
            <i class="fas fa-list"></i> Semua
        </a>
        <a href="{{ route('buyer.proposals', ['status' => 'pending']) }}" class="nav-link {{ request('status') == 'pending' ? 'active' : '' }}">
            <i class="fas fa-clock"></i> Menunggu
        </a>
        <a href="{{ route('buyer.proposals', ['status' => 'accepted']) }}" class="nav-link {{ request('status') == 'accepted' ? 'active' : '' }}">
            <i class="fas fa-check-circle"></i> Siap Bayar
        </a>
        <a href="{{ route('buyer.proposals', ['status' => 'in_progress']) }}" class="nav-link {{ request('status') == 'in_progress' ? 'active' : '' }}">
            <i class="fas fa-spinner"></i> Dalam Pengerjaan
        </a>
        <a href="{{ route('buyer.proposals', ['status' => 'rejected']) }}" class="nav-link {{ request('status') == 'rejected' ? 'active' : '' }}">
            <i class="fas fa-times-circle"></i> Ditolak
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
                        @elseif($proposal->status == 'in_progress')
                            <div class="status-info text-primary">
                                <i class="fas fa-spinner fa-spin"></i>
                                Seller sedang mengerjakan
                            </div>
                        @elseif($proposal->status == 'review')
                            <div class="status-info text-info">
                                <i class="fas fa-eye"></i>
                                Silakan review hasil pekerjaan
                            </div>
                        @elseif($proposal->status == 'revision')
                            <div class="status-info text-warning">
                                <i class="fas fa-redo"></i>
                                Menunggu seller merevisi
                            </div>
                        @elseif($proposal->status == 'completed')
                            <div class="status-info text-success">
                                <i class="fas fa-check-circle"></i>
                                Layanan selesai
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
                        @if(in_array($proposal->status, ['in_progress', 'review', 'revision', 'completed']))
                            {{-- Link to service order detail for active/completed services --}}
                            @if($proposal->order_id)
                                <a href="{{ route('buyer.services.show', $proposal->order_id) }}" class="btn-proposal-action btn-primary">
                                    <i class="fas fa-tasks"></i> 
                                    @if($proposal->status == 'completed')
                                        Lihat Riwayat
                                    @elseif($proposal->status == 'review')
                                        Review Hasil
                                    @else
                                        Lihat Progress
                                    @endif
                                </a>
                            @endif
                        @else
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
                                <a href="{{ route('buyer.chat') }}?seller={{ $proposal->seller_id }}&shop={{ $proposal->product->shop_id ?? '' }}&proposal_id={{ $proposal->id }}&product_id={{ $proposal->product_id }}" class="btn-proposal-action btn-primary">
                                    <i class="fas fa-comments"></i> Chat Seller
                                </a>
                            @endif
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
            <div class="empty-proposals-icon">
                <i class="fas fa-file-alt"></i>
            </div>
            <h5>Belum Ada Pengajuan Layanan</h5>
            <p>Anda belum memiliki pengajuan layanan. Cari layanan yang Anda butuhkan dan ajukan proposal!</p>
            <a href="{{ route('buyer.home') }}?tab=services" class="btn btn-primary mt-2">
                <i class="fas fa-search me-2"></i>Cari Layanan
            </a>
        </div>
    @endif
</div>
@endsection
