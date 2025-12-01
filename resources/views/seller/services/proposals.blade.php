@extends('layouts.app')

@section('title', 'Proposal Layanan - PestiMart')

@section('content')
<style>
    /* PestiMart Theme - Blue Color Scheme */
    .page-header {
        background: linear-gradient(135deg, #2563eb 0%, #3A7BFF 50%, #6ECBF9 100%);
        border-radius: 1rem;
        padding: 1.5rem 2rem;
        margin-bottom: 1.5rem;
        color: white;
        box-shadow: 0 4px 20px rgba(58, 123, 255, 0.25);
        position: relative;
        overflow: hidden;
    }
    .page-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 300px;
        height: 300px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
    }
    .page-header h2 {
        margin: 0;
        font-weight: 700;
        position: relative;
        z-index: 1;
    }
    .page-header p {
        margin: 0.5rem 0 0;
        opacity: 0.9;
        font-size: 0.95rem;
        position: relative;
        z-index: 1;
    }

    .proposal-card {
        background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 50%, #bae6fd 100%);
        border-radius: 1rem;
        box-shadow: 0 4px 15px rgba(58, 123, 255, 0.1);
        padding: 1.5rem;
        margin-bottom: 1.25rem;
        border: 1px solid rgba(58, 123, 255, 0.2);
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
    }
    .proposal-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 5px;
        height: 100%;
        background: linear-gradient(180deg, #3A7BFF 0%, #6ECBF9 100%);
        border-radius: 1rem 0 0 1rem;
    }
    .proposal-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 25px rgba(58, 123, 255, 0.2);
        border-color: rgba(58, 123, 255, 0.4);
    }

    .proposal-card.pending::before { background: linear-gradient(180deg, #f59e0b 0%, #d97706 100%); }
    .proposal-card.accepted::before, .proposal-card.in_progress::before { background: linear-gradient(180deg, #10b981 0%, #059669 100%); }
    .proposal-card.review::before { background: linear-gradient(180deg, #6366f1 0%, #4f46e5 100%); }
    .proposal-card.revision::before { background: linear-gradient(180deg, #ef4444 0%, #dc2626 100%); }
    .proposal-card.completed::before { background: linear-gradient(180deg, #64748b 0%, #475569 100%); }
    
    .proposal-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem; }
    .proposal-product { 
        font-weight: 700; 
        font-size: 1.15rem; 
        color: #1e3a5f;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .proposal-product i {
        color: #3A7BFF;
    }
    .proposal-buyer { 
        color: #bae6fd; 
        background: linear-gradient(135deg, #1e3a5f 0%, #2563eb 100%);
        padding: 0.35rem 0.75rem;
        border-radius: 999px;
        font-size: 0.85rem;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        margin-top: 0.5rem;
    }
    
    .proposal-meta { 
        display: flex; 
        flex-wrap: wrap; 
        gap: 0.75rem; 
        margin-bottom: 1rem; 
    }
    .proposal-meta-item { 
        display: flex; 
        align-items: center; 
        gap: 0.4rem;
        background: linear-gradient(135deg, rgba(255,255,255,0.9) 0%, rgba(224,242,254,0.9) 100%);
        padding: 0.5rem 0.85rem;
        border-radius: 0.5rem;
        font-size: 0.875rem;
        border: 1px solid rgba(58, 123, 255, 0.15);
        transition: all 0.2s ease;
    }
    .proposal-meta-item:hover {
        background: white;
        box-shadow: 0 2px 8px rgba(58, 123, 255, 0.15);
    }
    .proposal-meta-item i { color: #3A7BFF; }
    
    .proposal-desc { 
        background: linear-gradient(135deg, rgba(255,255,255,0.95) 0%, rgba(240,249,255,0.95) 100%);
        border-radius: 0.75rem; 
        padding: 1rem; 
        font-size: 0.9rem; 
        color: #374151; 
        margin-bottom: 1rem;
        border: 1px solid rgba(58, 123, 255, 0.1);
        line-height: 1.6;
    }

    .product-preview {
        background: linear-gradient(135deg, rgba(255,255,255,0.95) 0%, rgba(240,249,255,0.95) 100%);
        border: 1px solid rgba(58, 123, 255, 0.2);
        border-radius: 0.75rem;
        padding: 0.85rem;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        transition: all 0.2s ease;
    }
    .product-preview:hover {
        box-shadow: 0 4px 12px rgba(58, 123, 255, 0.1);
    }
    .product-preview-img {
        width: 70px;
        height: 70px;
        border-radius: 0.6rem;
        overflow: hidden;
        background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .product-preview-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .product-preview-img i {
        font-size: 1.5rem;
        color: #3A7BFF;
    }
    
    .status-badge { 
        padding: 0.4rem 0.9rem; 
        border-radius: 999px; 
        font-size: 0.8rem; 
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
    .status-completed { background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e1 100%); color: #475569; }
    .status-rejected, .status-cancelled { background: linear-gradient(135deg, #fecaca 0%, #fca5a5 100%); color: #991b1b; }
    
    .btn-action {
        padding: 0.5rem 1rem;
        font-size: 0.85rem;
        border-radius: 0.5rem;
        font-weight: 500;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
    }
    .btn-action:hover {
        transform: translateY(-2px);
    }

    .btn-detail {
        background: linear-gradient(135deg, #3A7BFF 0%, #2563eb 100%);
        color: white;
        border: none;
    }
    .btn-detail:hover {
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(58, 123, 255, 0.3);
    }

    .btn-chat {
        background: linear-gradient(135deg, #6ECBF9 0%, #38bdf8 100%);
        color: white;
        border: none;
    }
    .btn-chat:hover {
        background: linear-gradient(135deg, #38bdf8 0%, #0ea5e9 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(110, 203, 249, 0.3);
    }

    .btn-accept {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        border: none;
    }
    .btn-accept:hover {
        background: linear-gradient(135deg, #059669 0%, #047857 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }

    .btn-reject {
        background: transparent;
        color: #ef4444;
        border: 2px solid #ef4444;
    }
    .btn-reject:hover {
        background: #ef4444;
        color: white;
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
    }

    .btn-submit {
        background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
        color: white;
        border: none;
    }
    .btn-submit:hover {
        background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
    }

    .filter-bar { 
        display: flex; 
        gap: 1rem; 
        margin-bottom: 1.5rem; 
        flex-wrap: wrap; 
        align-items: center;
        background: linear-gradient(135deg, rgba(255,255,255,0.9) 0%, rgba(240,249,255,0.9) 100%);
        padding: 1rem 1.25rem;
        border-radius: 0.75rem;
        border: 1px solid rgba(58, 123, 255, 0.15);
    }
    .filter-bar select { 
        padding: 0.5rem 1rem; 
        border-radius: 0.5rem; 
        border: 1px solid rgba(58, 123, 255, 0.3);
        background: white;
        color: #1e3a5f;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .filter-bar select:focus {
        outline: none;
        border-color: #3A7BFF;
        box-shadow: 0 0 0 3px rgba(58, 123, 255, 0.15);
    }
    .filter-bar .filter-count {
        background: linear-gradient(135deg, #3A7BFF 0%, #6ECBF9 100%);
        color: white;
        padding: 0.4rem 0.85rem;
        border-radius: 999px;
        font-size: 0.85rem;
        font-weight: 600;
    }

    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
        border-radius: 1rem;
        border: 2px dashed rgba(58, 123, 255, 0.3);
    }
    .empty-state i {
        font-size: 4rem;
        color: #bae6fd;
        margin-bottom: 1rem;
    }
    .empty-state p {
        color: #2563eb;
        font-size: 1.1rem;
    }

    .waiting-badge {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        color: #92400e;
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
        font-size: 0.85rem;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        animation: pulse 2s infinite;
    }
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.7; }
    }
</style>

<div class="container my-4">
    <div class="page-header">
        <h2><i class="fas fa-file-contract me-2"></i>Proposal Layanan</h2>
        <p>Kelola semua proposal layanan dari buyer</p>
    </div>

    <div class="filter-bar">
        <form method="GET" class="d-flex gap-2">
            <select name="status" onchange="this.form.submit()">
                <option value="">📋 Semua Status</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>⏳ Pending</option>
                <option value="accepted" {{ request('status') === 'accepted' ? 'selected' : '' }}>✅ Diterima</option>
                <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>🔧 Dikerjakan</option>
                <option value="review" {{ request('status') === 'review' ? 'selected' : '' }}>👁️ Review</option>
                <option value="revision" {{ request('status') === 'revision' ? 'selected' : '' }}>🔄 Revisi</option>
                <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>🏁 Selesai</option>
            </select>
        </form>
        <span class="filter-count"><i class="fas fa-list me-1"></i>{{ $proposals->total() }} proposal</span>
    </div>

    @forelse($proposals as $proposal)
        <div class="proposal-card {{ $proposal->status }}">
            <div class="proposal-header">
                <div>
                    <div class="proposal-product">
                        <i class="fas fa-concierge-bell"></i>
                        {{ $proposal->product->name ?? 'Produk' }}
                    </div>
                    <div class="proposal-buyer">
                        <i class="fas fa-user"></i>{{ $proposal->buyer->name ?? 'Buyer' }}
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

            {{-- Product/Service Card --}}
            @if($proposal->product)
            <div class="product-preview">
                <div class="product-preview-img">
                    @if($proposal->product->image)
                        <img src="{{ asset('storage/' . $proposal->product->image) }}" alt="{{ $proposal->product->name }}">
                    @else
                        <i class="fas fa-concierge-bell"></i>
                    @endif
                </div>
                <div class="flex-grow-1" style="min-width:0;">
                    <div style="font-weight:600;color:#1e3a5f;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $proposal->product->name }}</div>
                    <div style="font-size:.8rem;color:#bae6fd;background:#1e3a5f;display:inline-block;padding:0.2rem 0.5rem;border-radius:0.25rem;margin-top:0.25rem;">Harga awal: Rp{{ number_format($proposal->product->price,0,',','.') }}</div>
                </div>
            </div>
            @endif

            <div class="proposal-meta">
                <div class="proposal-meta-item">
                    <i class="fas fa-tag"></i>
                    <span>Harga: <strong>Rp{{ number_format($proposal->proposed_price ?? $proposal->offered_price, 0, ',', '.') }}</strong></span>
                    @if($proposal->agreed_price && $proposal->agreed_price != ($proposal->proposed_price ?? $proposal->offered_price))
                        <span style="color:#059669;font-weight:600;">→ Rp{{ number_format($proposal->agreed_price, 0, ',', '.') }}</span>
                    @endif
                </div>
                <div class="proposal-meta-item">
                    <i class="fas fa-calendar-alt"></i>
                    <span>Deadline: <strong>{{ $proposal->deadline ? \Carbon\Carbon::parse($proposal->deadline)->format('d M Y') : '-' }}</strong></span>
                    @if($proposal->agreed_deadline && (!$proposal->deadline || \Carbon\Carbon::parse($proposal->agreed_deadline)->ne(\Carbon\Carbon::parse($proposal->deadline))))
                        <span style="color:#059669;font-weight:600;">→ {{ \Carbon\Carbon::parse($proposal->agreed_deadline)->format('d M Y') }}</span>
                    @endif
                </div>
                <div class="proposal-meta-item">
                    <i class="fas fa-history"></i>
                    <span>{{ $proposal->created_at->diffForHumans() }}</span>
                </div>
                @if($proposal->order_id)
                    <div class="proposal-meta-item">
                        <i class="fas fa-receipt"></i>
                        <span>Order #{{ $proposal->order->order_number ?? '-' }}</span>
                    </div>
                @endif
            </div>

            <div class="proposal-desc">
                {{ Str::limit($proposal->description, 200) }}
            </div>

            <div class="d-flex gap-2 flex-wrap">
                <a href="{{ route('seller.services.proposals.show', $proposal) }}" class="btn-action btn-detail">
                    <i class="fas fa-eye"></i>Detail
                </a>

                <a href="{{ route('messages.show', [
                    'user' => $proposal->buyer_id,
                    'shop_id' => $proposal->product->shop_id ?? '',
                    'proposal_id' => $proposal->id,
                    'product_id' => $proposal->product_id
                ]) }}" class="btn-action btn-chat">
                    <i class="fas fa-comments"></i>Chat Buyer
                </a>

                @if($proposal->isPending())
                    <form method="POST" action="{{ route('seller.services.proposals.accept', $proposal) }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn-action btn-accept">
                            <i class="fas fa-check"></i>Terima
                        </button>
                    </form>
                    <button type="button" class="btn-action btn-reject" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $proposal->id }}">
                        <i class="fas fa-times"></i>Tolak
                    </button>
                @endif

                @if($proposal->isAccepted() && !$proposal->order_id)
                    <span class="waiting-badge">
                        <i class="fas fa-hourglass-half"></i>Menunggu Pembayaran
                    </span>
                @endif

                @if(in_array($proposal->status, ['in_progress', 'revision']))
                    <form method="POST" action="{{ route('seller.services.proposals.submit-review', $proposal) }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn-action btn-submit">
                            <i class="fas fa-paper-plane"></i>Kirim Hasil
                        </button>
                    </form>
                @endif
            </div>
        </div>
    @empty
        <div class="empty-state">
            <i class="fas fa-inbox"></i>
            <p>Belum ada proposal layanan.</p>
        </div>
    @endforelse

    <div class="mt-4">
        {{ $proposals->withQueryString()->links() }}
    </div>
</div>

{{-- Reject Modals for each proposal --}}
@foreach($proposals as $proposal)
@if($proposal->isPending())
<div class="modal fade" id="rejectModal{{ $proposal->id }}" tabindex="-1">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('seller.services.proposals.reject', $proposal) }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%); border-bottom: none;">
                    <h5 class="modal-title" style="color: #991b1b;"><i class="fas fa-times-circle me-2"></i>Tolak Proposal #{{ $proposal->id }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p class="text-muted mb-3">Layanan: <strong>{{ $proposal->product->name ?? 'N/A' }}</strong></p>
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
@endif
@endforeach
@endsection
