@extends('layouts.seller')

@section('title', 'Notifikasi - PestiMart')
@section('page-title', 'Notifikasi')

@section('content')
<style>
    .notifications-wrapper {
        max-width: 800px;
        margin: 0 auto;
    }

    .notifications-header {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        margin-bottom: 1.25rem;
        flex-wrap: wrap;
        gap: 0.75rem;
    }

    .btn-mark-all {
        padding: 0.65rem 1.25rem;
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(248, 250, 252, 0.9) 100%);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(226, 232, 240, 0.8);
        border-radius: 12px;
        cursor: pointer;
        font-size: 0.875rem;
        font-weight: 600;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        color: var(--color-primary, #3A7BFF);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    }
    .btn-mark-all:hover {
        background: linear-gradient(135deg, var(--color-primary, #3A7BFF) 0%, #6366f1 100%);
        color: white;
        border-color: transparent;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(99, 102, 241, 0.3);
    }
    .btn-mark-all i {
        font-size: 0.9rem;
    }

    /* Notification Card - Modern Glass Style */
    .notification-card {
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.98) 0%, rgba(248, 250, 252, 0.95) 100%);
        backdrop-filter: blur(10px);
        border-radius: 16px;
        padding: 1.25rem 1.5rem;
        margin-bottom: 1rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
        border: 1px solid rgba(226, 232, 240, 0.8);
        position: relative;
        overflow: hidden;
    }
    .notification-card::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 4px;
        background: linear-gradient(180deg, var(--color-primary, #3A7BFF) 0%, #6366f1 100%);
        border-radius: 4px 0 0 4px;
    }
    .notification-card:hover {
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        transform: translateY(-3px);
        border-color: rgba(99, 102, 241, 0.3);
    }
    .notification-card.unread {
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.04) 0%, rgba(139, 92, 246, 0.02) 100%);
    }
    .notification-card.unread::after {
        content: '';
        position: absolute;
        top: 1rem;
        right: 1rem;
        width: 10px;
        height: 10px;
        background: linear-gradient(135deg, var(--color-primary, #3A7BFF) 0%, #6366f1 100%);
        border-radius: 50%;
        box-shadow: 0 0 8px rgba(99, 102, 241, 0.5);
        animation: pulse 2s infinite;
    }
    @keyframes pulse {
        0%, 100% { opacity: 1; transform: scale(1); }
        50% { opacity: 0.7; transform: scale(1.1); }
    }

    /* Type-based left border colors */
    .notification-card.is-order::before {
        background: linear-gradient(180deg, var(--color-primary, #3A7BFF) 0%, #6366f1 100%);
    }
    .notification-card.is-delivery::before {
        background: linear-gradient(180deg, #10b981 0%, #34d399 100%);
    }
    .notification-card.is-message::before {
        background: linear-gradient(180deg, #f59e0b 0%, #fbbf24 100%);
    }

    /* Icon Styles */
    .notification-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 48px;
        height: 48px;
        border-radius: 14px;
        font-size: 1.15rem;
        flex-shrink: 0;
        position: relative;
    }
    .notification-card.is-order .notification-icon {
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.12) 0%, rgba(139, 92, 246, 0.08) 100%);
        color: var(--color-primary, #3A7BFF);
    }
    .notification-card.is-delivery .notification-icon {
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.12) 0%, rgba(52, 211, 153, 0.08) 100%);
        color: #10b981;
    }
    .notification-card.is-message .notification-icon {
        background: linear-gradient(135deg, rgba(245, 158, 11, 0.12) 0%, rgba(251, 191, 36, 0.08) 100%);
        color: #f59e0b;
    }

    .notification-content {
        display: flex;
        gap: 1rem;
    }

    .notification-body {
        flex-grow: 1;
        min-width: 0;
    }

    .notification-title {
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 0.35rem;
        font-size: 0.95rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        flex-wrap: wrap;
    }
    .notification-title .badge-type {
        font-size: 0.65rem;
        font-weight: 700;
        padding: 0.2rem 0.5rem;
        border-radius: 6px;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }
    .notification-card.is-order .badge-type {
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.15) 0%, rgba(139, 92, 246, 0.1) 100%);
        color: #6366f1;
    }
    .notification-card.is-delivery .badge-type {
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.15) 0%, rgba(52, 211, 153, 0.1) 100%);
        color: #059669;
    }
    .notification-card.is-message .badge-type {
        background: linear-gradient(135deg, rgba(245, 158, 11, 0.15) 0%, rgba(251, 191, 36, 0.1) 100%);
        color: #d97706;
    }

    .notification-message {
        color: #64748b;
        font-size: 0.875rem;
        margin-bottom: 0.65rem;
        line-height: 1.6;
    }

    .notification-time {
        font-size: 0.75rem;
        color: #94a3b8;
        display: flex;
        align-items: center;
        gap: 0.35rem;
    }
    .notification-time i {
        font-size: 0.7rem;
    }

    /* Action Buttons */
    .notification-actions {
        display: flex;
        gap: 0.65rem;
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1px solid rgba(226, 232, 240, 0.6);
    }

    .btn-notif-action {
        padding: 0.6rem 1.1rem;
        background: linear-gradient(135deg, var(--color-primary, #3A7BFF) 0%, #6366f1 100%);
        color: white;
        border: none;
        border-radius: 10px;
        font-size: 0.8rem;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        text-align: center;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.4rem;
        box-shadow: 0 3px 12px rgba(99, 102, 241, 0.25);
    }
    .btn-notif-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(99, 102, 241, 0.35);
        color: white;
    }
    .btn-notif-action.btn-secondary {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        color: #64748b;
        border: 1px solid rgba(226, 232, 240, 0.8);
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.04);
    }
    .btn-notif-action.btn-secondary:hover {
        background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e1 100%);
        color: #1e293b;
        border-color: #cbd5e1;
    }

    .btn-notif-action i {
        font-size: 0.75rem;
    }

    /* Read indicator */
    .read-indicator {
        display: flex;
        align-items: center;
        gap: 0.35rem;
        font-size: 0.72rem;
        color: #94a3b8;
        margin-top: 0.5rem;
    }
    .read-indicator i {
        color: #10b981;
    }

    /* Empty State */
    .empty-notifications {
        text-align: center;
        padding: 4rem 2rem;
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.98) 0%, rgba(248, 250, 252, 0.95) 100%);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        border: 1px solid rgba(226, 232, 240, 0.8);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.06);
    }
    .empty-notifications .empty-icon {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.1) 0%, rgba(139, 92, 246, 0.06) 100%);
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
    }
    .empty-notifications .empty-icon i {
        font-size: 2.5rem;
        background: linear-gradient(135deg, var(--color-primary, #3A7BFF) 0%, #6366f1 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    .empty-notifications h4 {
        color: #1e293b;
        margin-bottom: 0.5rem;
        font-size: 1.25rem;
        font-weight: 700;
    }
    .empty-notifications p {
        color: #64748b;
        font-size: 0.9rem;
        max-width: 300px;
        margin: 0 auto;
    }

    /* Mobile Responsive */
    @media (max-width: 768px) {
        .notifications-wrapper {
            padding: 0 0.5rem;
        }
        .notification-card {
            padding: 1rem 1.25rem;
            border-radius: 14px;
        }
        .notification-icon {
            width: 42px;
            height: 42px;
            font-size: 1rem;
        }
        .notification-actions {
            flex-direction: column;
        }
        .btn-notif-action {
            width: 100%;
        }
        .notification-title {
            font-size: 0.9rem;
        }
        .notification-message {
            font-size: 0.82rem;
        }
    }

    @media (max-width: 575.98px) {
        .notifications-wrapper {
            padding: 0;
        }
        .notifications-header {
            margin-bottom: 0.75rem;
        }
        .btn-mark-all {
            width: 100%;
            justify-content: center;
            padding: 0.6rem 1rem;
            font-size: 0.85rem;
        }
        .notification-card {
            padding: 0.875rem 1rem;
            border-radius: 12px;
            gap: 0.75rem;
        }
        .notification-icon {
            width: 38px;
            height: 38px;
            font-size: 0.9rem;
        }
        .notification-title {
            font-size: 0.85rem;
            flex-wrap: wrap;
            gap: 0.35rem;
        }
        .badge-type {
            font-size: 0.6rem;
        }
        .notification-message {
            font-size: 0.8rem;
            -webkit-line-clamp: 2;
        }
        .notification-time {
            font-size: 0.7rem;
        }
        .notification-actions {
            gap: 0.35rem;
        }
        .btn-notif-action {
            padding: 0.4rem 0.75rem;
            font-size: 0.8rem;
        }
        .empty-state {
            padding: 2rem 1rem;
        }
        .empty-state i {
            font-size: 2.5rem;
        }
        .empty-state h5 {
            font-size: 1rem;
        }
        .empty-state p {
            font-size: 0.85rem;
        }
    }
</style>

<div class="notifications-wrapper">
    @if($notifications->count() > 0)
    <div class="notifications-header">
        <form method="POST" action="{{ route('seller.notifications.read-all') }}" style="display: inline;">
            @csrf
            <button type="submit" class="btn-mark-all">
                <i class="fas fa-check-double"></i> Tandai Semua Dibaca
            </button>
        </form>
    </div>
    @endif

    <div class="notifications-container">
        @if($notifications->count() > 0)
            @foreach($notifications as $notification)
            @php
                $orderLink = $notification->action_url ?? null;
                $notifType = getNotificationType($notification->type);
            @endphp

            <div data-href="{{ $orderLink }}" class="notification-card {{ !$notification->is_read ? 'unread' : '' }} is-{{ $notifType }}" @if($orderLink) style="cursor:pointer;" @endif>
                <div class="notification-content">
                    <div class="notification-icon">
                        {!! getNotificationIcon($notification->type) !!}
                    </div>

                    <div class="notification-body">
                        <div class="notification-title">
                            {{ $notification->title }}
                            @if($notifType === 'order')
                                <span class="badge-type">Pesanan</span>
                            @elseif($notifType === 'delivery')
                                <span class="badge-type">Pengiriman</span>
                            @else
                                <span class="badge-type">Pesan</span>
                            @endif
                        </div>
                        <div class="notification-message">{{ $notification->message }}</div>
                        
                        <div class="notification-time">
                            <i class="far fa-clock"></i>
                            {{ $notification->created_at->diffForHumans() }}
                        </div>

                        @if($notification->is_read)
                        <div class="read-indicator">
                            <i class="fas fa-check-circle"></i> Sudah Dibaca
                        </div>
                        @endif

                        <div class="notification-actions">
                            @if($notification->type === 'new_order' && $orderLink)
                            <a href="{{ $orderLink }}" class="btn-notif-action">
                                <i class="fas fa-eye"></i> Lihat Pesanan
                            </a>
                            @endif

                            @if(!$notification->is_read)
                            <form method="POST" action="{{ route('seller.notifications.read', $notification) }}" style="flex: 1;" onsubmit="event.stopPropagation();">
                                @csrf
                                <button type="submit" class="btn-notif-action btn-secondary w-100">
                                    <i class="fas fa-check"></i> Tandai Dibaca
                                </button>
                            </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    document.querySelectorAll('.notification-card[data-href]').forEach(function(card) {
                        const href = card.getAttribute('data-href');
                        if (!href) return;
                        card.addEventListener('click', function(e) {
                            if (e.target.closest('button') || e.target.closest('a') || e.target.closest('form')) return;
                            window.location.href = href;
                        });
                    });
                });
            </script>

            <div class="mt-4">
                {{ $notifications->links('pagination::bootstrap-5') }}
            </div>
        @else
            <div class="empty-notifications">
                <div class="empty-icon">
                    <i class="fas fa-bell-slash"></i>
                </div>
                <h4>Belum Ada Notifikasi</h4>
                <p>Anda akan mendapat notifikasi ketika ada aktivitas baru di toko Anda</p>
            </div>
        @endif
    </div>
</div>
@endsection

@php
function getNotificationType($type) {
    return match($type) {
        'new_order' => 'order',
        'order_confirmed', 'order_shipped', 'order_delivered', 'order_completed' => 'delivery',
        default => 'message'
    };
}

function getNotificationIcon($type) {
    return match($type) {
        'new_order' => '<i class="fas fa-shopping-cart"></i>',
        'order_confirmed' => '<i class="fas fa-check-circle"></i>',
        'order_shipped' => '<i class="fas fa-truck"></i>',
        'order_delivered' => '<i class="fas fa-box-open"></i>',
        'order_completed' => '<i class="fas fa-star"></i>',
        default => '<i class="fas fa-envelope"></i>'
    };
}
@endphp
