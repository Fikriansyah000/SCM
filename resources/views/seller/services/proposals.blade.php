@extends('layouts.app')

@section('title', 'Proposal Layanan - PestiMart')

@section('content')
<style>
    .proposal-card {
        background: #fff;
        border-radius: .75rem;
        box-shadow: 0 2px 10px rgba(0,0,0,.06);
        padding: 1.25rem;
        margin-bottom: 1rem;
        border-left: 4px solid #667eea;
    }
    .proposal-card.pending { border-left-color: #f59e0b; }
    .proposal-card.accepted, .proposal-card.in_progress { border-left-color: #10b981; }
    .proposal-card.review { border-left-color: #3b82f6; }
    .proposal-card.revision { border-left-color: #ef4444; }
    .proposal-card.completed { border-left-color: #6b7280; }
    
    .proposal-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: .75rem; }
    .proposal-product { font-weight: 600; font-size: 1.1rem; color: #1f2937; }
    .proposal-buyer { color: #6b7280; font-size: .9rem; }
    
    .proposal-meta { display: flex; flex-wrap: wrap; gap: 1rem; margin-bottom: .75rem; font-size: .9rem; }
    .proposal-meta-item { display: flex; align-items: center; gap: .35rem; }
    .proposal-meta-item i { color: #667eea; }
    
    .proposal-desc { background: #f9fafb; border-radius: .5rem; padding: .75rem; font-size: .9rem; color: #4b5563; margin-bottom: .75rem; }
    
    .status-badge { padding: .35rem .75rem; border-radius: 999px; font-size: .8rem; font-weight: 600; }
    .status-pending { background: #fef3c7; color: #92400e; }
    .status-accepted { background: #d1fae5; color: #065f46; }
    .status-in_progress { background: #dbeafe; color: #1e40af; }
    .status-review { background: #e0e7ff; color: #3730a3; }
    .status-revision { background: #fee2e2; color: #991b1b; }
    .status-completed { background: #e5e7eb; color: #374151; }
    .status-rejected, .status-cancelled { background: #fecaca; color: #991b1b; }
    
    .btn-sm { padding: .4rem .85rem; font-size: .85rem; border-radius: .5rem; }
    .filter-bar { display: flex; gap: 1rem; margin-bottom: 1.5rem; flex-wrap: wrap; align-items: center; }
    .filter-bar select { padding: .5rem 1rem; border-radius: .5rem; border: 1px solid #d1d5db; }
</style>

<div class="container my-4">
    <h2 class="mb-4"><i class="fas fa-file-alt me-2" style="color:#667eea"></i>Proposal Layanan</h2>

    <div class="filter-bar">
        <form method="GET" class="d-flex gap-2">
            <select name="status" onchange="this.form.submit()">
                <option value="">Semua Status</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="accepted" {{ request('status') === 'accepted' ? 'selected' : '' }}>Diterima</option>
                <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>Dikerjakan</option>
                <option value="review" {{ request('status') === 'review' ? 'selected' : '' }}>Review</option>
                <option value="revision" {{ request('status') === 'revision' ? 'selected' : '' }}>Revisi</option>
                <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Selesai</option>
            </select>
        </form>
        <span class="text-muted">Total: {{ $proposals->total() }} proposal</span>
    </div>

    @forelse($proposals as $proposal)
        <div class="proposal-card {{ $proposal->status }}">
            <div class="proposal-header">
                <div>
                    <div class="proposal-product">{{ $proposal->product->name ?? 'Produk' }}</div>
                    <div class="proposal-buyer">
                        <i class="fas fa-user me-1"></i>{{ $proposal->buyer->name ?? 'Buyer' }}
                    </div>
                </div>
                <span class="status-badge status-{{ $proposal->status }}">
                    {{ $proposal->getStatusLabel() }}
                </span>
            </div>

            <div class="proposal-meta">
                <div class="proposal-meta-item">
                    <i class="fas fa-tag"></i>
                    <span>Harga: <strong>Rp{{ number_format($proposal->offered_price, 0, ',', '.') }}</strong></span>
                    @if($proposal->agreed_price && $proposal->agreed_price != $proposal->offered_price)
                        <span class="text-success ms-1">→ Rp{{ number_format($proposal->agreed_price, 0, ',', '.') }}</span>
                    @endif
                </div>
                <div class="proposal-meta-item">
                    <i class="fas fa-calendar"></i>
                    <span>Deadline: <strong>{{ $proposal->deadline ? \Carbon\Carbon::parse($proposal->deadline)->format('d M Y') : '-' }}</strong></span>
                    @if($proposal->agreed_deadline && (!$proposal->deadline || \Carbon\Carbon::parse($proposal->agreed_deadline)->ne(\Carbon\Carbon::parse($proposal->deadline))))
                        <span class="text-success ms-1">→ {{ \Carbon\Carbon::parse($proposal->agreed_deadline)->format('d M Y') }}</span>
                    @endif
                </div>
                <div class="proposal-meta-item">
                    <i class="fas fa-clock"></i>
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
                <a href="{{ route('seller.services.proposals.show', $proposal) }}" class="btn btn-outline-primary btn-sm">
                    <i class="fas fa-eye me-1"></i>Detail
                </a>

                @if($proposal->isPending())
                    <form method="POST" action="{{ route('seller.services.proposals.accept', $proposal) }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-success btn-sm">
                            <i class="fas fa-check me-1"></i>Terima
                        </button>
                    </form>
                @endif

                @if($proposal->status === 'accepted' && !$proposal->order_id)
                    <span class="badge bg-warning text-dark d-flex align-items-center">
                        <i class="fas fa-hourglass-half me-1"></i>Menunggu Pembayaran
                    </span>
                @endif

                @if($proposal->status === 'accepted' && $proposal->order_id)
                    <form method="POST" action="{{ route('seller.services.proposals.start', $proposal) }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="fas fa-play me-1"></i>Mulai Kerjakan
                        </button>
                    </form>
                @endif

                @if(in_array($proposal->status, ['in_progress', 'revision']))
                    <form method="POST" action="{{ route('seller.services.proposals.submit-review', $proposal) }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-info btn-sm">
                            <i class="fas fa-paper-plane me-1"></i>Kirim Hasil
                        </button>
                    </form>
                @endif
            </div>
        </div>
    @empty
        <div class="text-center py-5 text-muted">
            <i class="fas fa-inbox fa-3x mb-3"></i>
            <p>Belum ada proposal layanan.</p>
        </div>
    @endforelse

    <div class="mt-4">
        {{ $proposals->withQueryString()->links() }}
    </div>
</div>
@endsection
