@extends('layouts.app')

@section('title', 'Detail Proposal - PestiMart')

@section('content')
<style>
    .detail-card { background: #fff; border-radius: .75rem; box-shadow: 0 2px 10px rgba(0,0,0,.06); padding: 1.5rem; margin-bottom: 1rem; }
    .detail-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem; flex-wrap: wrap; gap: 1rem; }
    .detail-title { font-size: 1.25rem; font-weight: 600; }
    
    .info-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 1rem; }
    .info-item { padding: .75rem; background: #f9fafb; border-radius: .5rem; }
    .info-label { font-size: .8rem; color: #6b7280; margin-bottom: .25rem; }
    .info-value { font-weight: 600; color: #1f2937; }
    
    .desc-section { margin-bottom: 1.5rem; }
    .desc-label { font-weight: 600; color: #374151; margin-bottom: .5rem; }
    .desc-content { background: #f9fafb; padding: 1rem; border-radius: .5rem; white-space: pre-wrap; line-height: 1.6; }
    
    .timeline { position: relative; padding-left: 1.5rem; }
    .timeline::before { content: ''; position: absolute; left: 0; top: .5rem; bottom: .5rem; width: 2px; background: #e5e7eb; }
    .timeline-item { position: relative; padding-bottom: 1rem; }
    .timeline-item::before { content: ''; position: absolute; left: -1.5rem; top: .35rem; width: 10px; height: 10px; border-radius: 50%; background: #667eea; border: 2px solid #fff; }
    .timeline-item.success::before { background: #10b981; }
    .timeline-item.warning::before { background: #f59e0b; }
    .timeline-item.danger::before { background: #ef4444; }
    .timeline-time { font-size: .8rem; color: #9ca3af; }
    .timeline-title { font-weight: 600; color: #374151; }
    .timeline-msg { font-size: .9rem; color: #6b7280; margin-top: .25rem; }
    
    .action-card { border: 2px dashed #d1d5db; border-radius: .75rem; padding: 1.25rem; text-align: center; }
    .action-card.pending { border-color: #f59e0b; background: #fffbeb; }
    .action-card.work { border-color: #10b981; background: #ecfdf5; }
    
    .status-badge { padding: .4rem .85rem; border-radius: 999px; font-size: .85rem; font-weight: 600; }
    .status-pending { background: #fef3c7; color: #92400e; }
    .status-accepted { background: #d1fae5; color: #065f46; }
    .status-in_progress { background: #dbeafe; color: #1e40af; }
    .status-review { background: #e0e7ff; color: #3730a3; }
    .status-revision { background: #fee2e2; color: #991b1b; }
    .status-completed { background: #e5e7eb; color: #374151; }
</style>

<div class="container my-4">
    <a href="{{ route('seller.services.proposals') }}" class="text-muted mb-3 d-inline-block">
        <i class="fas fa-arrow-left me-1"></i>Kembali ke Daftar Proposal
    </a>

    <div class="detail-card">
        <div class="detail-header">
            <div>
                <div class="detail-title">{{ $proposal->product->name ?? 'Produk' }}</div>
                <div class="text-muted">Order #{{ $proposal->order->order_number ?? '-' }} · {{ $proposal->buyer->name ?? 'Buyer' }}</div>
            </div>
            <span class="status-badge status-{{ $proposal->status }}">{{ $proposal->getStatusLabel() }}</span>
        </div>

        <div class="info-grid">
            <div class="info-item">
                <div class="info-label">Harga Diajukan</div>
                <div class="info-value">Rp{{ number_format($proposal->proposed_price, 0, ',', '.') }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Harga Final</div>
                <div class="info-value text-success">Rp{{ number_format($proposal->getFinalPrice(), 0, ',', '.') }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Deadline Diajukan</div>
                <div class="info-value">{{ $proposal->proposed_deadline->format('d M Y') }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Deadline Final</div>
                <div class="info-value text-success">{{ $proposal->getFinalDeadline()->format('d M Y') }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Tanggal Proposal</div>
                <div class="info-value">{{ $proposal->created_at->format('d M Y H:i') }}</div>
            </div>
            @if($proposal->started_at)
                <div class="info-item">
                    <div class="info-label">Mulai Dikerjakan</div>
                    <div class="info-value">{{ $proposal->started_at->format('d M Y H:i') }}</div>
                </div>
            @endif
        </div>

        <div class="desc-section">
            <div class="desc-label"><i class="fas fa-file-alt me-1"></i>Deskripsi Pekerjaan</div>
            <div class="desc-content">{{ $proposal->description }}</div>
        </div>

        @if($proposal->notes)
            <div class="desc-section">
                <div class="desc-label"><i class="fas fa-sticky-note me-1"></i>Catatan Tambahan</div>
                <div class="desc-content">{{ $proposal->notes }}</div>
            </div>
        @endif
    </div>

    {{-- Action Cards --}}
    @if($proposal->isPending())
        <div class="action-card pending mb-3">
            <h5><i class="fas fa-hourglass-half me-2"></i>Menunggu Keputusan Anda</h5>
            <p class="text-muted">Terima atau tolak proposal ini.</p>
            <div class="d-flex gap-2 justify-content-center flex-wrap">
                <form method="POST" action="{{ route('seller.services.proposals.accept', $proposal) }}">
                    @csrf
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-check me-1"></i>Terima Proposal
                    </button>
                </form>
                <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#rejectModal">
                    <i class="fas fa-times me-1"></i>Tolak
                </button>
            </div>
        </div>
    @endif

    @if($proposal->status === 'accepted')
        <div class="action-card work mb-3">
            <h5><i class="fas fa-play-circle me-2"></i>Proposal Diterima!</h5>
            <p class="text-muted">Mulai kerjakan sekarang dan beri notifikasi ke buyer.</p>
            <form method="POST" action="{{ route('seller.services.proposals.start', $proposal) }}">
                @csrf
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-play me-1"></i>Mulai Pengerjaan
                </button>
            </form>
        </div>
    @endif

    @if(in_array($proposal->status, ['in_progress', 'revision']))
        <div class="detail-card">
            <h5><i class="fas fa-tools me-2"></i>Pengerjaan Aktif</h5>
            <p class="text-muted mb-3">Deadline: <strong>{{ $proposal->getFinalDeadline()->format('d M Y') }}</strong> 
                ({{ $proposal->getFinalDeadline()->diffForHumans() }})</p>
            
            <div class="d-flex gap-2 flex-wrap">
                <form method="POST" action="{{ route('seller.services.proposals.submit-review', $proposal) }}">
                    @csrf
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-paper-plane me-1"></i>Kirim Hasil untuk Review
                    </button>
                </form>
                <button type="button" class="btn btn-outline-warning" data-bs-toggle="modal" data-bs-target="#extensionModal">
                    <i class="fas fa-clock me-1"></i>Minta Perpanjangan Waktu
                </button>
            </div>
        </div>
    @endif

    @if($proposal->status === 'review')
        <div class="detail-card" style="background: #f0f9ff; border: 2px solid #bae6fd;">
            <h5><i class="fas fa-eye me-2"></i>Menunggu Review Buyer</h5>
            <p class="text-muted">Buyer sedang mereview hasil pekerjaan Anda. Anda akan diberi notifikasi jika buyer meminta revisi atau menyetujui.</p>
        </div>
    @endif

    {{-- Timeline --}}
    @if($proposal->order && $proposal->order->orderEvents->isNotEmpty())
        <div class="detail-card">
            <h5 class="mb-3"><i class="fas fa-history me-2"></i>Timeline</h5>
            <div class="timeline">
                @foreach($proposal->order->orderEvents as $event)
                    <div class="timeline-item {{ $event->getColorClass() }}">
                        <div class="timeline-time">{{ $event->created_at->format('d M Y H:i') }}</div>
                        <div class="timeline-title"><i class="{{ $event->getIconClass() }} me-1"></i>{{ $event->title }}</div>
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
                <div class="modal-header">
                    <h5 class="modal-title">Tolak Proposal</h5>
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
