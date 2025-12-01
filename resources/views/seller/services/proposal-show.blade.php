@extends('layouts.app')

@section('title', 'Detail Proposal - PestiMart')

@section('content')
<style>
    /* PestiMart Theme - Blue Color Scheme */
    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.6rem 1.25rem;
        background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%);
        border: 1px solid rgba(58, 123, 255, 0.3);
        border-radius: 999px;
        color: #2563eb;
        font-weight: 500;
        font-size: 0.9rem;
        text-decoration: none;
        transition: all 0.3s ease;
        margin-bottom: 1rem;
    }
    .btn-back:hover {
        background: linear-gradient(135deg, #bae6fd 0%, #7dd3fc 100%);
        color: #1e3a5f;
        transform: translateX(-4px);
        box-shadow: 0 4px 12px rgba(58, 123, 255, 0.2);
        text-decoration: none;
    }
    .btn-back i {
        transition: transform 0.3s ease;
    }
    .btn-back:hover i {
        transform: translateX(-3px);
    }

    .detail-card { 
        background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 50%, #bae6fd 100%);
        border-radius: 1rem; 
        box-shadow: 0 4px 15px rgba(58, 123, 255, 0.1);
        padding: 1.75rem; 
        margin-bottom: 1.25rem;
        border: 1px solid rgba(58, 123, 255, 0.2);
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
        background: linear-gradient(90deg, #3A7BFF 0%, #6ECBF9 50%, #7dd3fc 100%);
        border-radius: 1rem 1rem 0 0;
    }

    .detail-header { 
        display: flex; 
        justify-content: space-between; 
        align-items: flex-start; 
        margin-bottom: 1.25rem; 
        flex-wrap: wrap; 
        gap: 1rem; 
    }
    .detail-title { 
        font-size: 1.35rem; 
        font-weight: 700;
        color: #1e3a5f;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .detail-title i {
        color: #3A7BFF;
    }
    .detail-subtitle {
        color: #bae6fd;
        background: linear-gradient(135deg, #1e3a5f 0%, #2563eb 100%);
        padding: 0.4rem 0.85rem;
        border-radius: 999px;
        font-size: 0.85rem;
        margin-top: 0.5rem;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
    }
    
    .info-grid { 
        display: grid; 
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); 
        gap: 1rem; 
        margin-bottom: 1.25rem; 
    }
    .info-item { 
        padding: 1rem; 
        background: linear-gradient(135deg, rgba(255,255,255,0.95) 0%, rgba(240,249,255,0.95) 100%);
        border-radius: 0.75rem;
        border: 1px solid rgba(58, 123, 255, 0.15);
        transition: all 0.2s ease;
    }
    .info-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(58, 123, 255, 0.12);
    }
    .info-label { 
        font-size: 0.8rem; 
        color: #2563eb; 
        margin-bottom: 0.35rem;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 0.35rem;
    }
    .info-label i {
        color: #3A7BFF;
    }
    .info-value { 
        font-weight: 700; 
        color: #1e3a5f;
        font-size: 1.05rem;
    }
    .info-value.success {
        color: #059669;
    }
    
    .desc-section { margin-bottom: 1.5rem; }
    .desc-label { 
        font-weight: 600; 
        color: #2563eb; 
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 1rem;
    }
    .desc-label i {
        color: #3A7BFF;
    }
    .desc-content { 
        background: linear-gradient(135deg, rgba(255,255,255,0.95) 0%, rgba(240,249,255,0.95) 100%);
        padding: 1.25rem; 
        border-radius: 0.75rem; 
        white-space: pre-wrap; 
        line-height: 1.7;
        color: #374151;
        border: 1px solid rgba(58, 123, 255, 0.1);
    }

    /* Timeline Card */
    .timeline-card {
        background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 50%, #bfdbfe 100%);
        border-radius: 1rem;
        box-shadow: 0 4px 15px rgba(58, 123, 255, 0.1);
        padding: 1.75rem;
        margin-bottom: 1.25rem;
        border: 1px solid rgba(58, 123, 255, 0.2);
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
        background: linear-gradient(90deg, #3A7BFF 0%, #6ECBF9 50%, #7dd3fc 100%);
        border-radius: 1rem 1rem 0 0;
    }
    .timeline-card h5 {
        color: #1e40af;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .timeline-card h5 i {
        background: linear-gradient(135deg, #3A7BFF 0%, #6ECBF9 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .timeline { 
        position: relative; 
        padding-left: 2.5rem; 
    }
    .timeline::before { 
        content: ''; 
        position: absolute; 
        left: 12px; 
        top: 0; 
        bottom: 0; 
        width: 3px; 
        background: linear-gradient(180deg, #3A7BFF 0%, #6ECBF9 50%, #7dd3fc 100%);
        border-radius: 3px;
    }
    .timeline-item { 
        position: relative; 
        padding: 1rem 1.25rem;
        margin-bottom: 0.75rem;
        background: linear-gradient(135deg, rgba(255,255,255,0.95) 0%, rgba(239,246,255,0.95) 100%);
        border-radius: 0.6rem;
        border: 1px solid rgba(58, 123, 255, 0.15);
        box-shadow: 0 2px 8px rgba(0,0,0,.04);
        transition: all 0.3s ease;
    }
    .timeline-item:hover {
        transform: translateX(4px);
        box-shadow: 0 4px 12px rgba(58, 123, 255, 0.15);
        border-color: rgba(58, 123, 255, 0.3);
    }
    .timeline-item::before { 
        content: ''; 
        position: absolute; 
        left: -2rem; 
        top: 1.25rem; 
        width: 14px; 
        height: 14px; 
        border-radius: 50%; 
        background: linear-gradient(135deg, #3A7BFF 0%, #6ECBF9 100%);
        border: 3px solid #fff; 
        box-shadow: 0 2px 6px rgba(58, 123, 255, 0.3);
        z-index: 1;
    }
    .timeline-item.success::before { background: linear-gradient(135deg, #10b981 0%, #059669 100%); }
    .timeline-item.warning::before { background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); box-shadow: 0 2px 6px rgba(245, 158, 11, 0.3); }
    .timeline-item.danger::before { background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); box-shadow: 0 2px 6px rgba(239, 68, 68, 0.3); }
    .timeline-item.info::before { background: linear-gradient(135deg, #3A7BFF 0%, #6ECBF9 100%); box-shadow: 0 2px 6px rgba(58, 123, 255, 0.3); }

    .timeline-time { 
        font-size: 0.75rem; 
        color: #6b7280;
        display: flex;
        align-items: center;
        gap: 0.35rem;
        margin-bottom: 0.25rem;
    }
    .timeline-time::before {
        content: '';
        width: 4px;
        height: 4px;
        background: #bfdbfe;
        border-radius: 50%;
    }
    .timeline-title { 
        font-weight: 600; 
        color: #1e3a5f;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .timeline-msg { 
        font-size: 0.9rem; 
        color: #6b7280; 
        margin-top: 0.35rem;
        padding-left: 1.4rem;
        border-left: 2px solid #bfdbfe;
    }
    
    .action-card { 
        border: 2px dashed rgba(58, 123, 255, 0.4); 
        border-radius: 1rem; 
        padding: 1.5rem; 
        text-align: center;
        background: linear-gradient(135deg, rgba(240,249,255,0.9) 0%, rgba(224,242,254,0.9) 100%);
        transition: all 0.3s ease;
    }
    .action-card:hover {
        border-color: rgba(58, 123, 255, 0.6);
        box-shadow: 0 4px 15px rgba(58, 123, 255, 0.1);
    }
    .action-card h5 {
        color: #2563eb;
        font-weight: 600;
    }
    .action-card.pending { 
        border-color: rgba(245, 158, 11, 0.5); 
        background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%); 
    }
    .action-card.pending h5 { color: #92400e; }
    .action-card.work { 
        border-color: rgba(16, 185, 129, 0.5); 
        background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%); 
    }
    .action-card.work h5 { color: #065f46; }
    
    .status-badge { 
        padding: 0.45rem 1rem; 
        border-radius: 999px; 
        font-size: 0.85rem; 
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
    }
    .status-pending { background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); color: #92400e; }
    .status-accepted { background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%); color: #065f46; }
    .status-in_progress { background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%); color: #1e40af; }
    .status-review { background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%); color: #3730a3; }
    .status-revision { background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%); color: #991b1b; }
    .status-completed { background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%); color: #065f46; }

    /* Chat Card */
    .chat-card {
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 50%, #93c5fd 100%);
        border: 1px solid rgba(58, 123, 255, 0.3);
        border-radius: 1rem;
        padding: 1.25rem;
        margin-bottom: 1.25rem;
        position: relative;
        overflow: hidden;
    }
    .chat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #3A7BFF 0%, #6ECBF9 50%, #7dd3fc 100%);
        border-radius: 1rem 1rem 0 0;
    }
    .chat-card h6 {
        color: #1e40af;
        font-weight: 600;
    }
    .chat-card p {
        color: #2563eb;
    }

    /* Work Card */
    .work-card {
        background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 50%, #a7f3d0 100%);
        border: 1px solid rgba(16, 185, 129, 0.3);
        border-radius: 1rem;
        padding: 1.5rem;
        margin-bottom: 1.25rem;
        position: relative;
        overflow: hidden;
    }
    .work-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #10b981 0%, #34d399 50%, #6ee7b7 100%);
        border-radius: 1rem 1rem 0 0;
    }
    .work-card h5 {
        color: #065f46;
        font-weight: 600;
    }

    /* Review Waiting Card */
    .review-card {
        background: linear-gradient(135deg, #eef2ff 0%, #e0e7ff 50%, #c7d2fe 100%);
        border: 2px solid rgba(99, 102, 241, 0.3);
        border-radius: 1rem;
        padding: 1.5rem;
        margin-bottom: 1.25rem;
        position: relative;
        overflow: hidden;
    }
    .review-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #6366f1 0%, #818cf8 50%, #a5b4fc 100%);
        border-radius: 1rem 1rem 0 0;
    }
    .review-card h5 {
        color: #3730a3;
        font-weight: 600;
    }

    /* Buttons */
    .btn-action {
        padding: 0.6rem 1.25rem;
        font-size: 0.9rem;
        border-radius: 0.5rem;
        font-weight: 500;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        text-decoration: none;
    }
    .btn-action:hover {
        transform: translateY(-2px);
        text-decoration: none;
    }

    .btn-primary-teal {
        background: linear-gradient(135deg, #3A7BFF 0%, #6ECBF9 100%);
        color: white;
        border: none;
    }
    .btn-primary-teal:hover {
        background: linear-gradient(135deg, #2563eb 0%, #3A7BFF 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(58, 123, 255, 0.3);
    }

    .btn-success-green {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        border: none;
    }
    .btn-success-green:hover {
        background: linear-gradient(135deg, #059669 0%, #047857 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }

    .btn-warning-amber {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: white;
        border: none;
    }
    .btn-warning-amber:hover {
        background: linear-gradient(135deg, #d97706 0%, #b45309 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
    }

    .btn-danger-red {
        background: transparent;
        color: #ef4444;
        border: 2px solid #ef4444;
    }
    .btn-danger-red:hover {
        background: #ef4444;
        color: white;
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
    }
</style>

<div class="container my-4">
    <a href="{{ route('seller.services.proposals') }}" class="btn-back">
        <i class="fas fa-arrow-left"></i>Kembali ke Daftar Proposal
    </a>

    <div class="detail-card">
        <div class="detail-header">
            <div>
                <div class="detail-title">
                    <i class="fas fa-concierge-bell"></i>
                    {{ $proposal->product->name ?? 'Produk' }}
                </div>
                <div class="detail-subtitle">
                    <i class="fas fa-receipt"></i>Order #{{ $proposal->order->order_number ?? '-' }} · {{ $proposal->buyer->name ?? 'Buyer' }}
                </div>
            </div>
            <span class="status-badge status-{{ $proposal->status }}">
                @if($proposal->status === 'pending')<i class="fas fa-clock"></i>@endif
                @if($proposal->status === 'accepted')<i class="fas fa-check"></i>@endif
                @if($proposal->status === 'in_progress')<i class="fas fa-tools"></i>@endif
                @if($proposal->status === 'review')<i class="fas fa-eye"></i>@endif
                @if($proposal->status === 'revision')<i class="fas fa-redo"></i>@endif
                @if($proposal->status === 'completed')<i class="fas fa-flag-checkered"></i>@endif
                {{ $proposal->getStatusLabel() }}
            </span>
        </div>

        <div class="info-grid">
            <div class="info-item">
                <div class="info-label"><i class="fas fa-tag"></i>Harga Diajukan</div>
                <div class="info-value">Rp{{ number_format($proposal->proposed_price, 0, ',', '.') }}</div>
            </div>
            <div class="info-item">
                <div class="info-label"><i class="fas fa-check-circle"></i>Harga Final</div>
                <div class="info-value success">Rp{{ number_format($proposal->getFinalPrice(), 0, ',', '.') }}</div>
            </div>
            <div class="info-item">
                <div class="info-label"><i class="fas fa-calendar"></i>Deadline Diajukan</div>
                <div class="info-value">{{ $proposal->proposed_deadline->format('d M Y') }}</div>
            </div>
            <div class="info-item">
                <div class="info-label"><i class="fas fa-calendar-check"></i>Deadline Final</div>
                <div class="info-value success">{{ $proposal->getFinalDeadline()->format('d M Y') }}</div>
            </div>
            <div class="info-item">
                <div class="info-label"><i class="fas fa-clock"></i>Tanggal Proposal</div>
                <div class="info-value">{{ $proposal->created_at->format('d M Y H:i') }}</div>
            </div>
            @if($proposal->started_at)
                <div class="info-item">
                    <div class="info-label"><i class="fas fa-play"></i>Mulai Dikerjakan</div>
                    <div class="info-value">{{ $proposal->started_at->format('d M Y H:i') }}</div>
                </div>
            @endif
        </div>

        <div class="desc-section">
            <div class="desc-label"><i class="fas fa-file-alt"></i>Deskripsi Pekerjaan</div>
            <div class="desc-content">{{ $proposal->description }}</div>
        </div>

        @if($proposal->notes)
            <div class="desc-section">
                <div class="desc-label"><i class="fas fa-sticky-note"></i>Catatan Tambahan</div>
                <div class="desc-content">{{ $proposal->notes }}</div>
            </div>
        @endif
    </div>

    {{-- Action Cards --}}
    {{-- Quick Chat with Buyer --}}
    <div class="chat-card">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h6 class="mb-1"><i class="fas fa-comments me-2"></i>Komunikasi dengan Buyer</h6>
                <p class="mb-0" style="font-size: .85rem;">Chat langsung dengan {{ $proposal->buyer->name ?? 'Buyer' }} tentang proposal ini</p>
            </div>
            <a href="{{ route('messages.show', [
                'user' => $proposal->buyer_id,
                'shop_id' => $proposal->product->shop_id ?? '',
                'proposal_id' => $proposal->id,
                'product_id' => $proposal->product_id
            ]) }}" class="btn-action btn-primary-teal">
                <i class="fas fa-comments"></i>Chat Buyer
            </a>
        </div>
    </div>

    @if($proposal->isPending())
        <div class="action-card pending mb-3">
            <h5><i class="fas fa-hourglass-half me-2"></i>Menunggu Keputusan Anda</h5>
            <p class="text-muted">Terima atau tolak proposal ini.</p>
            <div class="d-flex gap-2 justify-content-center flex-wrap">
                <form method="POST" action="{{ route('seller.services.proposals.accept', $proposal) }}">
                    @csrf
                    <button type="submit" class="btn-action btn-success-green">
                        <i class="fas fa-check"></i>Terima Proposal
                    </button>
                </form>
                <button type="button" class="btn-action btn-danger-red" data-bs-toggle="modal" data-bs-target="#rejectModal">
                    <i class="fas fa-times"></i>Tolak
                </button>
            </div>
        </div>
    @endif

    @if($proposal->isAccepted() && !$proposal->order_id)
        <div class="action-card mb-3" style="border-color: rgba(245, 158, 11, 0.5); background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%);">
            <h5 style="color: #92400e;"><i class="fas fa-hourglass-half me-2"></i>Menunggu Pembayaran</h5>
            <p class="text-muted">Proposal sudah diterima. Menunggu pembayaran dari buyer untuk memulai pengerjaan.</p>
        </div>
    @endif

    @if(in_array($proposal->status, ['in_progress', 'revision']))
        <div class="work-card">
            <h5><i class="fas fa-tools me-2"></i>Pengerjaan Aktif</h5>
            <p class="text-muted mb-3">Deadline: <strong>{{ $proposal->getFinalDeadline()->format('d M Y') }}</strong> 
                ({{ $proposal->getFinalDeadline()->diffForHumans() }})</p>
            
            <div class="d-flex gap-2 flex-wrap">
                <form method="POST" action="{{ route('seller.services.proposals.submit-review', $proposal) }}">
                    @csrf
                    <button type="submit" class="btn-action btn-success-green">
                        <i class="fas fa-paper-plane"></i>Kirim Hasil untuk Review
                    </button>
                </form>
                <button type="button" class="btn-action btn-warning-amber" data-bs-toggle="modal" data-bs-target="#extensionModal">
                    <i class="fas fa-clock"></i>Minta Perpanjangan Waktu
                </button>
            </div>
        </div>
    @endif

    @if($proposal->status === 'review')
        <div class="review-card">
            <h5><i class="fas fa-eye me-2"></i>Menunggu Review Buyer</h5>
            <p class="text-muted mb-0">Buyer sedang mereview hasil pekerjaan Anda. Anda akan diberi notifikasi jika buyer meminta revisi atau menyetujui.</p>
        </div>
    @endif

    {{-- Timeline --}}
    @if($proposal->order && $proposal->order->orderEvents->isNotEmpty())
        <div class="timeline-card">
            <h5 class="mb-4"><i class="fas fa-stream me-2"></i>Timeline Aktivitas</h5>
            <div class="timeline">
                @foreach($proposal->order->orderEvents as $event)
                    <div class="timeline-item {{ $event->getColorClass() }}">
                        <div class="timeline-time">{{ $event->created_at->format('d M Y H:i') }}</div>
                        <div class="timeline-title"><i class="{{ $event->getIconClass() }}"></i>{{ $event->title }}</div>
                        @if($event->message)
                            <div class="timeline-msg">{{ $event->message }}</div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>

{{-- Reject Modal --}}
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('seller.services.proposals.reject', $proposal) }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%); border-bottom: none;">
                    <h5 class="modal-title" style="color: #991b1b;"><i class="fas fa-times-circle me-2"></i>Tolak Proposal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Alasan Penolakan</label>
                        <textarea name="rejection_reason" class="form-control" rows="4" required minlength="10" placeholder="Jelaskan alasan Anda menolak proposal ini..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Tolak Proposal</button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Extension Modal --}}
<div class="modal fade" id="extensionModal" tabindex="-1">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('seller.services.proposals.request-extension', $proposal) }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Minta Perpanjangan Waktu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info small">
                        <i class="fas fa-info-circle me-1"></i>
                        Jika buyer tidak merespon dalam 24 jam, perpanjangan akan disetujui otomatis.
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jumlah Hari Perpanjangan</label>
                        <input type="number" name="extension_days" class="form-control" required min="1" max="30" value="3">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alasan Perpanjangan</label>
                        <textarea name="reason" class="form-control" rows="4" required minlength="20" placeholder="Jelaskan mengapa Anda membutuhkan perpanjangan waktu..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning">Kirim Permintaan</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
