@extends('layouts.app')

@section('title', 'Detail Layanan - PestiMart')

@section('content')
<style>
    .service-card { 
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 50%, #e2e8f0 100%);
        border-radius: .75rem; 
        box-shadow: 0 4px 15px rgba(0,0,0,.05), 0 1px 3px rgba(0,0,0,.08); 
        padding: 1.5rem; 
        margin-bottom: 1rem; 
        border: 1px solid rgba(148, 163, 184, 0.2);
        position: relative;
        overflow: hidden;
    }
    .service-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #667eea 0%, #764ba2 50%, #6366f1 100%);
        border-radius: .75rem .75rem 0 0;
    }
    .service-header { display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 1rem; margin-bottom: 1rem; }
    .service-title { font-size: 1.25rem; font-weight: 600; color: #1e293b; }
    
    .info-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 1rem; margin-bottom: 1rem; }
    .info-item { 
        padding: .85rem; 
        background: linear-gradient(135deg, rgba(255,255,255,0.9) 0%, rgba(248,250,252,0.9) 100%);
        border-radius: .5rem; 
        border: 1px solid rgba(148, 163, 184, 0.15);
        backdrop-filter: blur(10px);
    }
    .info-label { font-size: .8rem; color: #64748b; margin-bottom: .25rem; }
    .info-value { font-weight: 600; color: #1e293b; }
    
    .extension-alert { background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); border: 1px solid #fcd34d; border-radius: .75rem; padding: 1rem; margin-bottom: 1rem; }
    .extension-alert h5 { color: #92400e; margin-bottom: .5rem; }
    .extension-meta { font-size: .9rem; color: #78350f; margin-bottom: .75rem; }
    
    /* Improved Timeline Styles */
    .timeline-card {
        background: linear-gradient(135deg, #fafbff 0%, #f0f4ff 50%, #e8ecff 100%);
        border-radius: .75rem;
        box-shadow: 0 4px 15px rgba(99, 102, 241, 0.08), 0 1px 3px rgba(0,0,0,.06);
        padding: 1.5rem;
        margin-bottom: 1rem;
        border: 1px solid rgba(99, 102, 241, 0.15);
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
        background: linear-gradient(90deg, #6366f1 0%, #8b5cf6 50%, #a855f7 100%);
        border-radius: .75rem .75rem 0 0;
    }
    .timeline-card h5 {
        color: #4338ca;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .timeline-card h5 i {
        background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    
    .timeline { position: relative; padding-left: 2.5rem; }
    .timeline::before { 
        content: ''; 
        position: absolute; 
        left: 12px; 
        top: 0; 
        bottom: 0; 
        width: 3px; 
        background: linear-gradient(180deg, #6366f1 0%, #a855f7 50%, #ec4899 100%);
        border-radius: 3px;
    }
    
    .timeline-item { 
        position: relative; 
        padding: 1rem 1.25rem;
        margin-bottom: 0.75rem;
        background: linear-gradient(135deg, rgba(255,255,255,0.95) 0%, rgba(248,250,252,0.95) 100%);
        border-radius: .6rem;
        border: 1px solid rgba(148, 163, 184, 0.2);
        box-shadow: 0 2px 8px rgba(0,0,0,.04);
        transition: all 0.3s ease;
    }
    .timeline-item:hover {
        transform: translateX(4px);
        box-shadow: 0 4px 12px rgba(99, 102, 241, 0.12);
        border-color: rgba(99, 102, 241, 0.3);
    }
    .timeline-item::before { 
        content: ''; 
        position: absolute; 
        left: -2rem; 
        top: 1.25rem; 
        width: 14px; 
        height: 14px; 
        border-radius: 50%; 
        background: linear-gradient(135deg, #667eea 0%, #6366f1 100%);
        border: 3px solid #fff; 
        box-shadow: 0 2px 6px rgba(99, 102, 241, 0.3);
        z-index: 1;
    }
    .timeline-item.success::before { background: linear-gradient(135deg, #10b981 0%, #059669 100%); box-shadow: 0 2px 6px rgba(16, 185, 129, 0.3); }
    .timeline-item.warning::before { background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); box-shadow: 0 2px 6px rgba(245, 158, 11, 0.3); }
    .timeline-item.danger::before { background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); box-shadow: 0 2px 6px rgba(239, 68, 68, 0.3); }
    .timeline-item.info::before { background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); box-shadow: 0 2px 6px rgba(59, 130, 246, 0.3); }
    
    .timeline-time { 
        font-size: .75rem; 
        color: #94a3b8; 
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 0.35rem;
        margin-bottom: 0.35rem;
    }
    .timeline-time::before {
        content: '';
        width: 4px;
        height: 4px;
        background: #cbd5e1;
        border-radius: 50%;
    }
    .timeline-title { 
        font-weight: 600; 
        color: #1e293b; 
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .timeline-title i {
        font-size: 0.9rem;
        opacity: 0.8;
    }
    .timeline-msg { 
        font-size: .875rem; 
        color: #64748b; 
        margin-top: .35rem;
        padding-left: 1.4rem;
        border-left: 2px solid #e2e8f0;
        margin-left: 0.1rem;
    }
    
    .review-card { background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%); border: 2px solid #a7f3d0; border-radius: .75rem; padding: 1.25rem; }
    .review-card h5 { color: #065f46; }
    
    .status-badge { padding: .4rem .85rem; border-radius: 999px; font-size: .85rem; font-weight: 600; }
    .status-pending, .status-proposal_pending { background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); color: #92400e; }
    .status-accepted { background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%); color: #065f46; }
    .status-in_progress { background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%); color: #1e40af; }
    .status-review { background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%); color: #3730a3; }
    .status-revision { background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%); color: #991b1b; }
    .status-completed { background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%); color: #065f46; }

    .status-pill-group { display: flex; gap: 1rem; flex-wrap: wrap; margin-bottom: 1rem; }
    .status-pill { 
        flex: 1 1 220px; 
        border: 1px solid rgba(148, 163, 184, 0.2); 
        border-radius: .75rem; 
        padding: .85rem 1rem; 
        background: linear-gradient(135deg, rgba(255,255,255,0.9) 0%, rgba(248,250,252,0.9) 100%);
        backdrop-filter: blur(10px);
    }
    .status-pill span { display: block; font-size: .8rem; color: #64748b; }
    .status-pill strong { font-size: 1rem; color: #1e293b; }

    .status-flow { display: flex; gap: 0.75rem; flex-wrap: wrap; position: relative; }
    .status-step { 
        flex: 1 1 140px; 
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        border-radius: .75rem; 
        padding: .9rem; 
        border: 1px solid rgba(148, 163, 184, 0.2); 
        position: relative; 
        transition: all 0.3s ease;
    }
    .status-step::after { content: ""; position: absolute; right: -0.4rem; top: 50%; transform: translateY(-50%); width: 0.8rem; height: 0.8rem; border-top: 2px solid #cbd5f5; border-right: 2px solid #cbd5f5; opacity: 0.5; }
    .status-step:last-child::after { display: none; }
    .status-step.completed { 
        background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 50%, #7dd3fc 100%); 
        border-color: #38bdf8; 
        box-shadow: 0 4px 12px rgba(56, 189, 248, 0.2); 
    }
    .status-step.current { 
        border-color: #6366f1; 
        box-shadow: 0 4px 12px rgba(99, 102, 241, 0.25);
        background: linear-gradient(135deg, #eef2ff 0%, #e0e7ff 100%);
    }
    .status-step h6 { font-size: .9rem; margin-bottom: .3rem; color: #0f172a; display: flex; align-items: center; gap: .4rem; }
    .status-step p { font-size: .75rem; color: #475569; margin: 0; }
    .status-step .icon { width: 26px; height: 26px; border-radius: 999px; background: rgba(99,102,241,.15); display: inline-flex; align-items: center; justify-content: center; color: #4c1d95; font-size: .8rem; }
    .status-step.completed .icon { background: rgba(16,185,129, .2); color: #065f46; }
    @media (max-width: 768px) { .status-step::after { display:none; } }

    /* Proposal Card Specific */
    .proposal-card {
        background: linear-gradient(135deg, #fefce8 0%, #fef9c3 30%, #fef08a 100%);
        border: 1px solid rgba(234, 179, 8, 0.3);
    }
    .proposal-card::before {
        background: linear-gradient(90deg, #eab308 0%, #f59e0b 50%, #d97706 100%);
    }

    /* Back Button */
    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.6rem 1.25rem;
        background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
        border: 1px solid rgba(148, 163, 184, 0.3);
        border-radius: 999px;
        color: #475569;
        font-weight: 500;
        font-size: 0.9rem;
        text-decoration: none;
        transition: all 0.3s ease;
        margin-bottom: 1rem;
    }

    .btn-back:hover {
        background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e1 100%);
        color: #1e293b;
        transform: translateX(-4px);
        box-shadow: 0 4px 12px rgba(100, 116, 139, 0.15);
        text-decoration: none;
    }

    .btn-back i {
        transition: transform 0.3s ease;
    }

    .btn-back:hover i {
        transform: translateX(-3px);
    }
</style>

<div class="container my-4">
    <a href="{{ route('buyer.orders') }}" class="btn-back">
        <i class="fas fa-arrow-left"></i>Kembali ke Pesanan
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

        <div class="status-pill-group">
            <div class="status-pill">
                <span>Status Pesanan</span>
                <strong>{{ $order->getStatusLabel() }}</strong>
            </div>
            <div class="status-pill" style="border-color:#c4b5fd;background:#f5f3ff;">
                <span>Status Layanan (Fiverr Flow)</span>
                <strong>{{ $order->getServiceStatusLabel() }}</strong>
            </div>
        </div>

        @php
            $serviceFlow = \App\Models\Order::serviceStatusFlow();
            $currentKey = $order->service_status ?? 'pending';
            $flowKeys = array_keys($serviceFlow);
            $currentIndex = array_search($currentKey, $flowKeys, true);
            $currentIndex = $currentIndex === false ? 0 : $currentIndex;
        @endphp

        <div class="status-flow mb-4">
            @foreach($serviceFlow as $key => $meta)
                @php
                    $stepIndex = $loop->index;
                    $isCompleted = $stepIndex < $currentIndex || ($key === 'completed' && $currentKey === 'completed');
                    $isCurrent = $key === $currentKey;
                @endphp
                <div class="status-step {{ $isCompleted ? 'completed' : '' }} {{ $isCurrent ? 'current' : '' }}">
                    <h6>
                        <span class="icon">
                            <i class="fas {{ $isCompleted ? 'fa-check' : 'fa-circle-notch' }}"></i>
                        </span>
                        {{ $meta['label'] }}
                    </h6>
                    <p>{{ $meta['hint'] }}</p>
                </div>
            @endforeach
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

            @if(in_array($proposal->status, ['pending', 'accepted']))
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

    {{-- Rating Section for Completed Services --}}
    @if($order->service_status === 'completed')
        @foreach($order->serviceProposals as $proposal)
            @if($proposal->status === 'completed' && $proposal->product)
                @php
                    $existingReview = \App\Models\ProductReview::where('product_id', $proposal->product_id)
                        ->where('user_id', auth()->id())
                        ->where('order_id', $order->id)
                        ->first();
                @endphp
                
                <div class="service-card" style="border: 2px solid {{ $existingReview ? '#10b981' : '#fbbf24' }}; background: {{ $existingReview ? '#ecfdf5' : '#fffbeb' }};">
                    <h5 class="mb-3">
                        <i class="fas fa-star me-2" style="color: {{ $existingReview ? '#10b981' : '#fbbf24' }};"></i>
                        {{ $existingReview ? 'Ulasan Anda' : 'Berikan Rating untuk Layanan Ini' }}
                    </h5>
                    
                    <div class="d-flex gap-3 mb-3 align-items-center">
                        @if($proposal->product->image)
                            <img src="{{ asset('storage/' . $proposal->product->image) }}" alt="{{ $proposal->product->name }}" 
                                 style="width: 60px; height: 60px; border-radius: .5rem; object-fit: cover;">
                        @else
                            <div style="width: 60px; height: 60px; border-radius: .5rem; background: #e5e7eb; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-concierge-bell text-muted"></i>
                            </div>
                        @endif
                        <div>
                            <strong>{{ $proposal->product->name }}</strong>
                            <div class="text-muted" style="font-size: .85rem;">oleh {{ $proposal->seller->name ?? 'Seller' }}</div>
                        </div>
                    </div>
                    
                    @if($existingReview)
                        <div class="p-3" style="background: white; border-radius: .5rem;">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                @for($s=1;$s<=5;$s++)
                                    <i class="fas fa-star" style="color: {{ $s <= $existingReview->rating ? '#fbbf24' : '#e5e7eb' }}; font-size: 1.25rem;"></i>
                                @endfor
                                <span class="ms-2 text-muted">({{ $existingReview->rating }}/5)</span>
                            </div>
                            @if($existingReview->title)
                                <div class="fw-bold">{{ $existingReview->title }}</div>
                            @endif
                            @if($existingReview->review)
                                <p class="text-muted mb-0 mt-1">{{ $existingReview->review }}</p>
                            @endif
                            <div class="text-muted mt-2" style="font-size: .8rem;">
                                <i class="fas fa-check-circle text-success me-1"></i>Dikirim {{ $existingReview->created_at->format('d M Y H:i') }}
                            </div>
                        </div>
                    @else
                        <form method="POST" action="{{ route('reviews.store') }}">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $proposal->product_id }}">
                            <input type="hidden" name="order_id" value="{{ $order->id }}">
                            <input type="hidden" name="rating" id="service-rating-{{ $proposal->id }}" value="5">
                            
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Rating</label>
                                <div class="stars-input d-flex gap-2" data-target="#service-rating-{{ $proposal->id }}">
                                    @for($s=1;$s<=5;$s++)
                                        <i class="fas fa-star star-clickable" data-value="{{ $s }}" 
                                           style="font-size: 1.75rem; cursor: pointer; color: #fbbf24; transition: transform 0.2s;"></i>
                                    @endfor
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Judul Ulasan <span class="text-muted">(opsional)</span></label>
                                <input type="text" name="title" class="form-control" placeholder="Contoh: Layanan yang sangat memuaskan!">
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Ulasan <span class="text-muted">(opsional)</span></label>
                                <textarea name="review" class="form-control" rows="3" placeholder="Ceritakan pengalaman Anda dengan layanan ini..."></textarea>
                            </div>
                            
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-paper-plane me-1"></i>Kirim Ulasan
                            </button>
                        </form>
                    @endif
                </div>
            @endif
        @endforeach
    @endif

    {{-- Timeline --}}
    @if($order->orderEvents->isNotEmpty())
        <div class="timeline-card">
            <h5 class="mb-4"><i class="fas fa-stream me-2"></i>Timeline Aktivitas</h5>
            <div class="timeline">
                @foreach($order->orderEvents as $event)
                    <div class="timeline-item {{ $event->getColorClass() }}">
                        <div class="timeline-time"><i class="far fa-clock" style="font-size: 0.7rem;"></i>{{ $event->created_at->format('d M Y H:i') }}</div>
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

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Star rating functionality
    document.querySelectorAll('.stars-input').forEach(container => {
        const stars = container.querySelectorAll('.star-clickable');
        const targetInput = document.querySelector(container.dataset.target);
        
        if (!targetInput) return;
        
        // Set initial state (all stars filled for default value 5)
        updateStars(5);
        
        stars.forEach(star => {
            // Hover effect
            star.addEventListener('mouseenter', function() {
                const value = parseInt(this.dataset.value);
                stars.forEach(s => {
                    const sValue = parseInt(s.dataset.value);
                    s.style.color = sValue <= value ? '#fbbf24' : '#e5e7eb';
                    s.style.transform = sValue === value ? 'scale(1.2)' : 'scale(1)';
                });
            });
            
            // Click to select
            star.addEventListener('click', function() {
                const value = parseInt(this.dataset.value);
                targetInput.value = value;
                updateStars(value);
            });
        });
        
        // Reset on mouse leave to selected value
        container.addEventListener('mouseleave', function() {
            updateStars(parseInt(targetInput.value));
        });
        
        function updateStars(selectedValue) {
            stars.forEach(s => {
                const sValue = parseInt(s.dataset.value);
                s.style.color = sValue <= selectedValue ? '#fbbf24' : '#e5e7eb';
                s.style.transform = 'scale(1)';
            });
        }
    });
});
</script>
@endpush
@endsection
