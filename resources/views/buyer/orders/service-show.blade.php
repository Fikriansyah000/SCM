@extends('layouts.app')

@section('title', 'Detail Layanan - PestiMart')

@section('content')
<style>
    .service-card { background: #fff; border-radius: .75rem; box-shadow: 0 2px 10px rgba(0,0,0,.06); padding: 1.5rem; margin-bottom: 1rem; }
    .service-header { display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 1rem; margin-bottom: 1rem; }
    .service-title { font-size: 1.25rem; font-weight: 600; }
    
    .info-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 1rem; margin-bottom: 1rem; }
    .info-item { padding: .75rem; background: #f9fafb; border-radius: .5rem; }
    .info-label { font-size: .8rem; color: #6b7280; margin-bottom: .25rem; }
    .info-value { font-weight: 600; color: #1f2937; }
    
    .extension-alert { background: #fef3c7; border: 1px solid #fcd34d; border-radius: .75rem; padding: 1rem; margin-bottom: 1rem; }
    .extension-alert h5 { color: #92400e; margin-bottom: .5rem; }
    .extension-meta { font-size: .9rem; color: #78350f; margin-bottom: .75rem; }
    
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
    
    .review-card { background: #ecfdf5; border: 2px solid #a7f3d0; border-radius: .75rem; padding: 1.25rem; }
    .review-card h5 { color: #065f46; }
    
    .status-badge { padding: .4rem .85rem; border-radius: 999px; font-size: .85rem; font-weight: 600; }
    .status-pending, .status-proposal_pending { background: #fef3c7; color: #92400e; }
    .status-accepted { background: #d1fae5; color: #065f46; }
    .status-in_progress { background: #dbeafe; color: #1e40af; }
    .status-review { background: #e0e7ff; color: #3730a3; }
    .status-revision { background: #fee2e2; color: #991b1b; }
    .status-completed { background: #e5e7eb; color: #374151; }
</style>

<div class="container my-4">
    <a href="{{ route('buyer.orders') }}" class="text-muted mb-3 d-inline-block">
        <i class="fas fa-arrow-left me-1"></i>Kembali ke Pesanan
    </a>

    <div class="service-card">
        <div class="service-header">
            <div>
                <div class="service-title">Order #{{ $order->order_number }}</div>
                <div class="text-muted">{{ $order->shop->shop_name ?? 'Toko' }} · {{ $order->created_at->format('d M Y H:i') }}</div>
            </div>
            <span class="status-badge status-{{ $order->service_status ?? 'pending' }}">
                {{ $order->getServiceStatusLabel() }}
            </span>
        </div>

        <div class="info-grid">
            <div class="info-item">
                <div class="info-label">Total Harga</div>
                <div class="info-value">Rp{{ number_format($order->total_amount, 0, ',', '.') }}</div>
            </div>
            @if($order->service_due_at)
                <div class="info-item">
                    <div class="info-label">Deadline</div>
                    <div class="info-value">{{ \Carbon\Carbon::parse($order->service_due_at)->format('d M Y') }}</div>
                </div>
            @endif
            <div class="info-item">
                <div class="info-label">Status</div>
                <div class="info-value">{{ $order->getServiceStatusLabel() }}</div>
            </div>
        </div>
    </div>

    {{-- Pending Extension Alert --}}
    @if($order->pendingExtension)
        @php $ext = $order->pendingExtension; @endphp
        <div class="extension-alert">
            <h5><i class="fas fa-clock me-2"></i>Permintaan Perpanjangan Waktu</h5>
            <div class="extension-meta">
                Seller meminta perpanjangan <strong>{{ $ext->extension_days }} hari</strong>. 
                Deadline baru: <strong>{{ $ext->new_deadline->format('d M Y') }}</strong>
            </div>
            <p class="mb-3">Alasan: {{ $ext->reason }}</p>
            <p class="mb-3" style="font-size:.85rem; color:#92400e;">
                <i class="fas fa-info-circle me-1"></i>
                Jika tidak ada respon hingga <strong>{{ $ext->auto_approve_at->format('d M Y H:i') }}</strong>, 
                perpanjangan akan disetujui otomatis.
            </p>
            <div class="d-flex gap-2 flex-wrap">
                <form method="POST" action="{{ route('buyer.services.extensions.approve', $ext) }}">
                    @csrf
                    <button type="submit" class="btn btn-success btn-sm">
                        <i class="fas fa-check me-1"></i>Setujui
                    </button>
                </form>
                <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#rejectExtensionModal">
                    <i class="fas fa-times me-1"></i>Tolak
                </button>
            </div>
        </div>

        {{-- Reject Extension Modal --}}
        <div class="modal fade" id="rejectExtensionModal" tabindex="-1">
            <div class="modal-dialog">
                <form method="POST" action="{{ route('buyer.services.extensions.reject', $ext) }}">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Tolak Perpanjangan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Alasan Penolakan</label>
                                <textarea name="response_message" class="form-control" rows="3" required minlength="10" placeholder="Jelaskan alasan Anda menolak perpanjangan..."></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-danger">Tolak Perpanjangan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endif

    {{-- Service Proposals --}}
    @foreach($order->serviceProposals as $proposal)
        <div class="service-card">
            <h5><i class="fas fa-file-alt me-2" style="color:#667eea"></i>{{ $proposal->product->name ?? 'Layanan' }}</h5>
            
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Harga Final</div>
                    <div class="info-value">Rp{{ number_format($proposal->getFinalPrice(), 0, ',', '.') }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Deadline</div>
                    <div class="info-value">{{ $proposal->getFinalDeadline()->format('d M Y') }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Status</div>
                    <div class="info-value">{{ $proposal->getStatusLabel() }}</div>
                </div>
            </div>

            <div class="mb-3">
                <strong>Deskripsi:</strong>
                <p class="mt-1 mb-0 text-muted">{{ $proposal->description }}</p>
            </div>

            {{-- Actions based on status --}}
            @if($proposal->status === 'review')
                <div class="review-card">
                    <h5><i class="fas fa-check-circle me-2"></i>Hasil Pekerjaan Siap Direview</h5>
                    <p class="text-muted mb-3">Seller telah mengirimkan hasil pekerjaan. Silakan review dan berikan keputusan.</p>
                    <div class="d-flex gap-2 flex-wrap">
                        <form method="POST" action="{{ route('buyer.services.proposals.complete', $proposal) }}">
                            @csrf
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-check me-1"></i>Setujui & Selesaikan
                            </button>
                        </form>
                        <button type="button" class="btn btn-outline-warning" data-bs-toggle="modal" data-bs-target="#revisionModal{{ $proposal->id }}">
                            <i class="fas fa-redo me-1"></i>Minta Revisi
                        </button>
                    </div>
                </div>

                {{-- Revision Modal --}}
                <div class="modal fade" id="revisionModal{{ $proposal->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <form method="POST" action="{{ route('buyer.services.proposals.revision', $proposal) }}">
                            @csrf
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Minta Revisi</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label">Feedback & Detail Revisi</label>
                                        <textarea name="revision_feedback" class="form-control" rows="4" required minlength="20" placeholder="Jelaskan apa yang perlu direvisi..."></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-warning">Kirim Permintaan Revisi</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            @endif

            @if(in_array($proposal->status, ['pending', 'negotiating', 'accepted']))
                <div class="mt-3">
                    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#cancelModal{{ $proposal->id }}">
                        <i class="fas fa-times me-1"></i>Batalkan Layanan
                    </button>
                </div>

                {{-- Cancel Modal --}}
                <div class="modal fade" id="cancelModal{{ $proposal->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <form method="POST" action="{{ route('buyer.services.proposals.cancel', $proposal) }}">
                            @csrf
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Batalkan Layanan</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="alert alert-warning">
                                        <i class="fas fa-exclamation-triangle me-1"></i>
                                        Pembatalan tidak dapat dibatalkan setelah pengerjaan dimulai.
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Alasan Pembatalan</label>
                                        <textarea name="cancel_reason" class="form-control" rows="3" required minlength="10" placeholder="Jelaskan alasan pembatalan..."></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-danger">Batalkan Layanan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    @endforeach

    {{-- Timeline --}}
    @if($order->orderEvents->isNotEmpty())
        <div class="service-card">
            <h5 class="mb-3"><i class="fas fa-history me-2"></i>Timeline</h5>
            <div class="timeline">
                @foreach($order->orderEvents as $event)
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
@endsection
