@extends('layouts.seller')

@section('title', 'Detail Proposal - PestiMart')
@section('page-title', 'Detail Proposal')

@section('content')
<style>
    /* Modern Back Button */
    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.65rem 1.35rem;
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(248, 250, 252, 0.9) 100%);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(226, 232, 240, 0.8);
        border-radius: 12px;
        color: var(--color-primary, #3A7BFF);
        font-weight: 600;
        font-size: 0.9rem;
        text-decoration: none;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        margin-bottom: 1.25rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    }
    .btn-back:hover {
        background: linear-gradient(135deg, var(--color-primary, #3A7BFF) 0%, #6366f1 100%);
        color: white;
        border-color: transparent;
        transform: translateX(-4px);
        box-shadow: 0 6px 20px rgba(99, 102, 241, 0.3);
        text-decoration: none;
    }
    .btn-back i {
        transition: transform 0.25s ease;
    }
    .btn-back:hover i {
        transform: translateX(-3px);
    }

    /* Modern Glass Card */
    .detail-card { 
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.98) 0%, rgba(248, 250, 252, 0.95) 100%);
        backdrop-filter: blur(10px);
        border-radius: 20px; 
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
        padding: 1.75rem; 
        margin-bottom: 1.25rem;
        border: 1px solid rgba(226, 232, 240, 0.8);
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
        background: linear-gradient(90deg, var(--color-primary, #3A7BFF) 0%, #6366f1 50%, var(--color-primary, #3A7BFF) 100%);
        background-size: 200% 100%;
        animation: shimmer 3s ease-in-out infinite;
    }
    @keyframes shimmer {
        0%, 100% { background-position: 200% 0; }
        50% { background-position: 0% 0; }
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
        font-weight: 800;
        background: linear-gradient(135deg, #1e293b 0%, #475569 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        letter-spacing: -0.02em;
    }
    .detail-title i {
        background: linear-gradient(135deg, var(--color-primary, #3A7BFF) 0%, #6366f1 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    .detail-subtitle {
        color: white;
        background: linear-gradient(135deg, var(--color-primary, #3A7BFF) 0%, #6366f1 100%);
        padding: 0.45rem 1rem;
        border-radius: 10px;
        font-size: 0.82rem;
        font-weight: 600;
        margin-top: 0.5rem;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        box-shadow: 0 3px 10px rgba(99, 102, 241, 0.25);
    }
    
    .info-grid { 
        display: grid; 
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); 
        gap: 1rem; 
        margin-bottom: 1.25rem; 
    }
    .info-item { 
        padding: 1rem; 
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        border-radius: 14px;
        border: 1px solid rgba(226, 232, 240, 0.6);
        transition: all 0.25s ease;
    }
    .info-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(99, 102, 241, 0.12);
    }
    .info-label { 
        font-size: 0.78rem; 
        color: var(--color-primary, #3A7BFF);
        margin-bottom: 0.35rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.35rem;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }
    .info-label i {
        background: linear-gradient(135deg, var(--color-primary, #3A7BFF) 0%, #6366f1 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    .info-value { 
        font-weight: 700; 
        color: #1e293b;
        font-size: 1.05rem;
    }
    .info-value.success {
        color: #059669;
    }
    
    .desc-section { margin-bottom: 1.5rem; }
    .desc-label { 
        font-weight: 700; 
        color: #1e293b;
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 1rem;
    }
    .desc-label i {
        background: linear-gradient(135deg, var(--color-primary, #3A7BFF) 0%, #6366f1 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    .desc-content { 
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        padding: 1.25rem; 
        border-radius: 14px; 
        white-space: pre-wrap; 
        line-height: 1.7;
        color: #475569;
        border: 1px solid rgba(226, 232, 240, 0.6);
    }

    /* Timeline Card */
    .timeline-card {
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.98) 0%, rgba(248, 250, 252, 0.95) 100%);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
        padding: 1.75rem;
        margin-bottom: 1.25rem;
        border: 1px solid rgba(226, 232, 240, 0.8);
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
        background: linear-gradient(90deg, var(--color-primary, #3A7BFF) 0%, #6366f1 50%, var(--color-primary, #3A7BFF) 100%);
        background-size: 200% 100%;
        animation: shimmer 3s ease-in-out infinite;
    }
    .timeline-card h5 {
        color: #1e293b;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .timeline-card h5 i {
        background: linear-gradient(135deg, var(--color-primary, #3A7BFF) 0%, #6366f1 100%);
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
        background: linear-gradient(180deg, var(--color-primary, #3A7BFF) 0%, #6366f1 50%, #818cf8 100%);
        border-radius: 3px;
    }
    .timeline-item { 
        position: relative; 
        padding: 1rem 1.25rem;
        margin-bottom: 0.75rem;
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        border-radius: 14px;
        border: 1px solid rgba(226, 232, 240, 0.6);
        box-shadow: 0 2px 8px rgba(0,0,0,.04);
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .timeline-item:hover {
        transform: translateX(4px);
        box-shadow: 0 6px 16px rgba(99, 102, 241, 0.12);
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
        background: linear-gradient(135deg, var(--color-primary, #3A7BFF) 0%, #6366f1 100%);
        border: 3px solid #fff; 
        box-shadow: 0 2px 6px rgba(99, 102, 241, 0.3);
        z-index: 1;
    }
    .timeline-item.success::before { background: linear-gradient(135deg, #10b981 0%, #059669 100%); box-shadow: 0 2px 6px rgba(16, 185, 129, 0.3); }
    .timeline-item.warning::before { background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); box-shadow: 0 2px 6px rgba(245, 158, 11, 0.3); }
    .timeline-item.danger::before { background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); box-shadow: 0 2px 6px rgba(239, 68, 68, 0.3); }
    .timeline-item.info::before { background: linear-gradient(135deg, var(--color-primary, #3A7BFF) 0%, #6366f1 100%); box-shadow: 0 2px 6px rgba(99, 102, 241, 0.3); }

    .timeline-time { 
        font-size: 0.75rem; 
        color: #94a3b8;
        display: flex;
        align-items: center;
        gap: 0.35rem;
        margin-bottom: 0.25rem;
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
    .timeline-msg { 
        font-size: 0.9rem; 
        color: #64748b; 
        margin-top: 0.35rem;
        padding-left: 1.4rem;
        border-left: 2px solid #e2e8f0;
    }
    
    /* Action Cards */
    .action-card { 
        border: 2px dashed rgba(99, 102, 241, 0.35); 
        border-radius: 16px; 
        padding: 1.5rem; 
        text-align: center;
        background: linear-gradient(135deg, rgba(248, 250, 252, 0.95) 0%, rgba(241, 245, 249, 0.9) 100%);
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .action-card:hover {
        border-color: rgba(99, 102, 241, 0.5);
        box-shadow: 0 6px 20px rgba(99, 102, 241, 0.12);
    }
    .action-card h5 {
        color: #1e293b;
        font-weight: 700;
    }
    .action-card.pending { 
        border-color: rgba(245, 158, 11, 0.4); 
        background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%); 
    }
    .action-card.pending h5 { color: #92400e; }
    .action-card.work { 
        border-color: rgba(16, 185, 129, 0.4); 
        background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%); 
    }
    .action-card.work h5 { color: #065f46; }
    
    /* Status Badges */
    .status-badge { 
        padding: 0.5rem 1.1rem; 
        border-radius: 10px; 
        font-size: 0.82rem; 
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
    }
    .status-pending { background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); color: #92400e; }
    .status-accepted { background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%); color: #065f46; }
    .status-in_progress { background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%); color: #1e40af; }
    .status-review { background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%); color: #4338ca; }
    .status-revision { background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%); color: #991b1b; }
    .status-completed { background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%); color: #065f46; }

    /* Chat Card */
    .chat-card {
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.98) 0%, rgba(248, 250, 252, 0.95) 100%);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(226, 232, 240, 0.8);
        border-radius: 16px;
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
        background: linear-gradient(90deg, var(--color-primary, #3A7BFF) 0%, #6366f1 50%, var(--color-primary, #3A7BFF) 100%);
        background-size: 200% 100%;
        animation: shimmer 3s ease-in-out infinite;
    }
    .chat-card h6 {
        color: #1e293b;
        font-weight: 700;
    }
    .chat-card p {
        color: #64748b;
    }

    /* Work Card */
    .work-card {
        background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%);
        border: 1px solid rgba(16, 185, 129, 0.25);
        border-radius: 16px;
        padding: 1.5rem;
        margin-bottom: 1.25rem;
        position: relative;
        overflow: hidden;
        box-shadow: 0 4px 16px rgba(16, 185, 129, 0.1);
    }
    .work-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #10b981 0%, #34d399 50%, #6ee7b7 100%);
    }
    .work-card h5 {
        color: #065f46;
        font-weight: 700;
    }

    /* Review Waiting Card */
    .review-card {
        background: linear-gradient(135deg, #eef2ff 0%, #e0e7ff 100%);
        border: 1px solid rgba(99, 102, 241, 0.25);
        border-radius: 16px;
        padding: 1.5rem;
        margin-bottom: 1.25rem;
        position: relative;
        overflow: hidden;
        box-shadow: 0 4px 16px rgba(99, 102, 241, 0.1);
    }
    .review-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #6366f1 0%, #818cf8 50%, #a5b4fc 100%);
    }
    .review-card h5 {
        color: #4338ca;
        font-weight: 700;
    }

    /* Buttons */
    .btn-action {
        padding: 0.7rem 1.35rem;
        font-size: 0.875rem;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        text-decoration: none;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.1);
    }
    .btn-action:hover {
        transform: translateY(-2px);
        text-decoration: none;
    }

    .btn-primary-teal {
        background: linear-gradient(135deg, var(--color-primary, #3A7BFF) 0%, #6366f1 100%);
        color: white;
        border: none;
        box-shadow: 0 4px 14px rgba(99, 102, 241, 0.3);
    }
    .btn-primary-teal:hover {
        background: linear-gradient(135deg, #4f46e5 0%, var(--color-primary, #3A7BFF) 100%);
        color: white;
        box-shadow: 0 6px 20px rgba(99, 102, 241, 0.4);
    }

    .btn-success-green {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        border: none;
        box-shadow: 0 4px 14px rgba(16, 185, 129, 0.3);
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
        box-shadow: 0 4px 14px rgba(245, 158, 11, 0.3);
    }
    .btn-warning-amber:hover {
        background: linear-gradient(135deg, #d97706 0%, #b45309 100%);
        color: white;
        box-shadow: 0 6px 20px rgba(245, 158, 11, 0.4);
    }

    .btn-danger-red {
        background: linear-gradient(135deg, rgba(239, 68, 68, 0.1) 0%, rgba(239, 68, 68, 0.05) 100%);
        color: #ef4444;
        border: 2px solid rgba(239, 68, 68, 0.3);
    }
    .btn-danger-red:hover {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
        border-color: transparent;
        box-shadow: 0 6px 20px rgba(239, 68, 68, 0.35);
    }

    /* Modal Styling */
    .modal-content {
        border-radius: 20px;
        border: none;
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
        overflow: hidden;
    }
    .modal-header {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        padding: 1.25rem 1.5rem;
    }
    .modal-header.danger {
        background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
    }
    .modal-header.danger .modal-title {
        color: #991b1b;
    }
    .modal-header.warning {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
    }
    .modal-header.warning .modal-title {
        color: #92400e;
    }
    .modal-title {
        font-weight: 600;
        font-size: 1.1rem;
        color: var(--color-text-primary);
    }
    .modal-body {
        padding: 1.5rem;
    }
    .modal-body .form-label {
        font-weight: 500;
        color: var(--color-text-secondary);
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
    }
    .modal-body .form-control {
        border-radius: 12px;
        border: 2px solid #e2e8f0;
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
    }
    .modal-body .form-control:focus {
        border-color: var(--color-primary);
        box-shadow: 0 0 0 3px rgba(var(--color-primary-rgb, 99, 102, 241), 0.15);
    }
    .modal-footer {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        border-top: 1px solid rgba(0, 0, 0, 0.05);
        padding: 1rem 1.5rem;
        gap: 0.75rem;
    }
    .modal-footer .btn {
        border-radius: 12px;
        padding: 0.6rem 1.25rem;
        font-weight: 500;
    }
    .modal-footer .btn-secondary {
        background: #e2e8f0;
        border: none;
        color: #64748b;
    }
    .modal-footer .btn-secondary:hover {
        background: #cbd5e1;
    }
    .modal-footer .btn-danger {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        border: none;
        color: white;
    }
    .modal-footer .btn-danger:hover {
        background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
        box-shadow: 0 4px 14px rgba(239, 68, 68, 0.3);
    }
    .modal-footer .btn-warning {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        border: none;
        color: white;
    }
    .modal-footer .btn-warning:hover {
        background: linear-gradient(135deg, #d97706 0%, #b45309 100%);
        box-shadow: 0 4px 14px rgba(245, 158, 11, 0.3);
    }
    .modal-body .alert-info {
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.1) 0%, rgba(99, 102, 241, 0.05) 100%);
        border: 1px solid rgba(99, 102, 241, 0.2);
        color: #4338ca;
        border-radius: 12px;
        padding: 0.875rem 1rem;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .detail-card {
            padding: 1.25rem;
            border-radius: 16px;
        }
        .info-grid {
            grid-template-columns: 1fr 1fr;
        }
        .detail-title {
            font-size: 1.15rem;
        }
        .btn-action {
            padding: 0.6rem 1rem;
            font-size: 0.82rem;
        }
    }
    @media (max-width: 575.98px) {
        .btn-back {
            padding: 0.5rem 1rem;
            font-size: 0.85rem;
        }
        .detail-card {
            padding: 1rem;
            border-radius: 12px;
        }
        .detail-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.75rem;
        }
        .detail-title {
            font-size: 1.05rem;
        }
        .detail-subtitle {
            font-size: 0.8rem;
        }
        .status-badge {
            align-self: flex-start;
        }
        .section-title {
            font-size: 0.95rem;
        }
        .info-item {
            padding: 0.75rem;
        }
        .info-label {
            font-size: 0.7rem;
        }
        .info-value {
            font-size: 0.95rem;
        }
        .action-buttons {
            flex-direction: column;
            gap: 0.5rem;
        }
        .btn-action {
            width: 100%;
            justify-content: center;
        }
        .timeline {
            padding-left: 1.5rem;
        }
        .timeline-item::before {
            left: -1.25rem;
        }
    }
    @media (max-width: 480px) {
        .info-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

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
            <a href="{{ route('seller.messages.show', [
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
                <div class="modal-header danger">
                    <h5 class="modal-title"><i class="fas fa-times-circle me-2"></i>Tolak Proposal</h5>
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
                <div class="modal-header warning">
                    <h5 class="modal-title"><i class="fas fa-clock me-2"></i>Minta Perpanjangan Waktu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info small mb-3">
                        <i class="fas fa-info-circle me-2"></i>
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
