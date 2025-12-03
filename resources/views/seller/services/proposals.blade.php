@extends('layouts.seller')

@section('title', 'Proposal Layanan - PestiMart')

@section('page-title', 'Kelola Proposal')

@section('content')
<style>
    /* Filter Bar */
    .filter-bar { 
        display: flex; 
        gap: var(--space-3); 
        margin-bottom: var(--space-5); 
        flex-wrap: wrap; 
        align-items: center;
        background: var(--color-white);
        padding: var(--space-4);
        border-radius: var(--radius-lg);
        border: 1px solid var(--color-border);
        box-shadow: var(--shadow-card);
    }

    .filter-bar select { 
        padding: var(--space-2) var(--space-4); 
        border-radius: var(--radius-md); 
        border: 1px solid var(--color-border);
        background: var(--color-bg);
        color: var(--color-neutral-dark);
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .filter-bar select:focus {
        outline: none;
        border-color: var(--color-primary);
        box-shadow: 0 0 0 3px rgba(58, 123, 255, 0.15);
    }

    .filter-count {
        background: var(--gradient-primary);
        color: white;
        padding: var(--space-2) var(--space-4);
        border-radius: var(--radius-full);
        font-size: var(--font-size-sm);
        font-weight: 600;
    }

    /* Proposal Card */
    .proposal-card {
        background: var(--color-white);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-card);
        padding: var(--space-5);
        margin-bottom: var(--space-4);
        border: 1px solid var(--color-border);
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
        background: var(--gradient-primary);
    }

    .proposal-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-card-hover);
    }

    .proposal-card.pending::before { background: linear-gradient(180deg, #f59e0b 0%, #d97706 100%); }
    .proposal-card.accepted::before, .proposal-card.in_progress::before { background: linear-gradient(180deg, #10b981 0%, #059669 100%); }
    .proposal-card.review::before { background: linear-gradient(180deg, #6366f1 0%, #4f46e5 100%); }
    .proposal-card.revision::before { background: linear-gradient(180deg, #ef4444 0%, #dc2626 100%); }
    .proposal-card.completed::before { background: linear-gradient(180deg, #64748b 0%, #475569 100%); }
    
    .proposal-header { 
        display: flex; 
        justify-content: space-between; 
        align-items: flex-start; 
        margin-bottom: var(--space-4);
        gap: var(--space-3);
    }

    .proposal-product { 
        font-weight: 700; 
        font-size: var(--font-size-lg); 
        color: var(--color-neutral-dark);
        display: flex;
        align-items: center;
        gap: var(--space-2);
    }

    .proposal-product i {
        color: var(--color-primary);
    }

    .proposal-buyer { 
        color: white; 
        background: var(--gradient-primary);
        padding: var(--space-1) var(--space-3);
        border-radius: var(--radius-full);
        font-size: var(--font-size-sm);
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: var(--space-2);
        margin-top: var(--space-2);
    }
    
    /* Product Preview */
    .product-preview {
        background: var(--color-bg);
        border: 1px solid var(--color-border);
        border-radius: var(--radius-md);
        padding: var(--space-3);
        margin-bottom: var(--space-4);
        display: flex;
        align-items: center;
        gap: var(--space-4);
    }

    .product-preview-img {
        width: 64px;
        height: 64px;
        border-radius: var(--radius-md);
        overflow: hidden;
        background: var(--color-white);
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
        color: var(--color-primary);
    }

    /* Meta Items */
    .proposal-meta { 
        display: flex; 
        flex-wrap: wrap; 
        gap: var(--space-3); 
        margin-bottom: var(--space-4); 
    }

    .proposal-meta-item { 
        display: flex; 
        align-items: center; 
        gap: var(--space-2);
        background: var(--color-bg);
        padding: var(--space-2) var(--space-3);
        border-radius: var(--radius-md);
        font-size: var(--font-size-sm);
        border: 1px solid var(--color-border);
    }

    .proposal-meta-item i { 
        color: var(--color-primary); 
    }
    
    .proposal-desc { 
        background: var(--color-bg);
        border-radius: var(--radius-md); 
        padding: var(--space-4); 
        font-size: var(--font-size-sm); 
        color: var(--color-text-muted); 
        margin-bottom: var(--space-4);
        border: 1px solid var(--color-border);
        line-height: 1.6;
    }

    /* Status Badge */
    .status-badge { 
        padding: var(--space-2) var(--space-3); 
        border-radius: var(--radius-full); 
        font-size: var(--font-size-xs); 
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: var(--space-1);
        white-space: nowrap;
    }

    .status-pending { background: #fef3c7; color: #92400e; }
    .status-accepted { background: #d1fae5; color: #065f46; }
    .status-in_progress { background: #dbeafe; color: #1e40af; }
    .status-review { background: #ede9fe; color: #5b21b6; }
    .status-revision { background: #ffedd5; color: #c2410c; }
    .status-completed { background: #e2e8f0; color: #475569; }
    .status-rejected, .status-cancelled { background: #fee2e2; color: #b91c1c; }
    
    /* Action Buttons */
    .btn-action {
        padding: var(--space-2) var(--space-4);
        font-size: var(--font-size-sm);
        border-radius: var(--radius-md);
        font-weight: 600;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: var(--space-2);
        text-decoration: none;
        border: none;
        cursor: pointer;
    }

    .btn-action:hover {
        transform: translateY(-2px);
    }

    .btn-detail {
        background: var(--gradient-primary);
        color: white;
    }

    .btn-detail:hover {
        color: white;
        box-shadow: 0 4px 12px rgba(58, 123, 255, 0.3);
    }

    .btn-chat {
        background: linear-gradient(135deg, #6ECBF9 0%, #38bdf8 100%);
        color: white;
    }

    .btn-chat:hover {
        color: white;
        box-shadow: 0 4px 12px rgba(110, 203, 249, 0.3);
    }

    .btn-accept {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
    }

    .btn-accept:hover {
        color: white;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }

    .btn-reject {
        background: transparent;
        color: #ef4444;
        border: 2px solid #ef4444 !important;
    }

    .btn-reject:hover {
        background: #ef4444;
        color: white;
    }

    .btn-submit {
        background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
        color: white;
    }

    .btn-submit:hover {
        color: white;
        box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
    }

    .waiting-badge {
        background: #fef3c7;
        color: #92400e;
        padding: var(--space-2) var(--space-4);
        border-radius: var(--radius-md);
        font-size: var(--font-size-sm);
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: var(--space-2);
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.7; }
    }

    .empty-state {
        text-align: center;
        padding: var(--space-10);
        background: var(--color-white);
        border-radius: var(--radius-lg);
        border: 2px dashed var(--color-border);
    }

    .empty-state i {
        font-size: 4rem;
        color: var(--color-border);
        margin-bottom: var(--space-4);
    }

    .empty-state p {
        color: var(--color-text-muted);
        font-size: var(--font-size-lg);
    }

    /* Mobile Responsive */
    @media (max-width: 767.98px) {
        .proposal-header {
            flex-direction: column;
        }

        .proposal-product {
            font-size: var(--font-size-base);
        }

        .proposal-meta {
            flex-direction: column;
            gap: var(--space-2);
        }

        .proposal-meta-item {
            width: 100%;
        }

        .product-preview {
            flex-direction: column;
            text-align: center;
        }

        .btn-action {
            width: 100%;
            justify-content: center;
        }

        .d-flex.gap-2 {
            flex-direction: column;
        }
    }

    @media (max-width: 575.98px) {
        .filter-bar {
            flex-direction: column;
            align-items: stretch;
        }

        .filter-bar select {
            width: 100%;
        }
    }
</style>

<div class="filter-bar">
    <form method="GET" class="d-flex gap-2 flex-grow-1">
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

                <a href="{{ route('seller.messages.show', [
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
