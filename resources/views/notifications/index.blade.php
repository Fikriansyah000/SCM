@extends('layouts.app')

@section('title', 'Notifikasi - PestiMart')

@section('content')
<style>
    .notifications-container {
        max-width: 600px;
        margin: 0 auto;
    }

    .notification-card {
        background: var(--card-bg, #FFFFFF);
        border-left: 4px solid var(--primary, #3A7BFF);
        border-radius: 0.75rem;
        padding: 1.5rem;
        margin-bottom: 1rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
        cursor: pointer;
    }

    @media (hover: hover) {
        .notification-card:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.12);
            transform: translateY(-2px);
        }
    }

    .notification-card.unread {
        background: rgba(58, 123, 255, 0.05);
    }

    .notification-card.is-order {
        border-left-color: var(--primary, #3A7BFF);
    }

    .notification-card.is-delivery {
        border-left-color: #43e97b;
    }

    .notification-card.is-message {
        border-left-color: var(--accent, #FF8F3A);
    }

    .notification-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 0.75rem;
    }

    .notification-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        background: rgba(58, 123, 255, 0.1);
        border-radius: 50%;
        color: var(--primary, #3A7BFF);
        font-size: 1.2rem;
        margin-right: 1rem;
        flex-shrink: 0;
    }

    .notification-title {
        font-weight: 600;
        color: var(--neutral-dark, #1A1F36);
        margin-bottom: 0.25rem;
    }

    .notification-message {
        color: #666;
        font-size: 0.95rem;
        margin-bottom: 0.75rem;
        line-height: 1.5;
    }

    .notification-time {
        font-size: 0.8rem;
        color: #999;
    }

    .notification-actions {
        display: flex;
        gap: 0.75rem;
        margin-top: 1rem;
        flex-wrap: wrap;
    }

    .btn-notif-action {
        flex: 1;
        padding: 0.6rem 1rem;
        background: linear-gradient(135deg, var(--primary, #3A7BFF), var(--secondary, #6ECBF9));
        color: white;
        border: none;
        border-radius: 0.4rem;
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        text-align: center;
        transition: all 0.3s ease;
        min-width: 120px;
    }

    @media (hover: hover) {
        .btn-notif-action:hover {
            filter: brightness(1.05);
            text-decoration: none;
            color: white;
        }
    }

    .btn-secondary {
        background: var(--neutral-gray, #ECEEF3);
        color: var(--neutral-dark, #1A1F36);
    }

    @media (hover: hover) {
        .btn-secondary:hover {
            background: #ddd;
        }
    }

    .empty-notifications {
        text-align: center;
        padding: 3rem;
        background: var(--card-bg, #FFFFFF);
        border-radius: 0.75rem;
    }

    .empty-notifications i {
        font-size: 3rem;
        color: #ddd;
        margin-bottom: 1rem;
    }

    .notifications-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .btn-mark-all {
        padding: 0.5rem 1rem;
        background: var(--neutral-gray, #ECEEF3);
        border: none;
        border-radius: 0.4rem;
        cursor: pointer;
        font-size: 0.85rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    @media (hover: hover) {
        .btn-mark-all:hover {
            background: #ddd;
        }
    }

    @media (max-width: 768px) {
        .notifications-container {
            padding: 0;
        }
        
        .notification-card {
            padding: 1rem;
        }
        
        .notification-actions {
            flex-direction: column;
        }
        
        .btn-notif-action {
            min-width: 100%;
        }
    }
</style>

<div class="container my-4">
    <div class="notifications-header">
        <h2>
            <i class="fas fa-bell me-2"></i>Notifikasi
        </h2>
        @if($notifications->count() > 0)
        <form method="POST" action="{{ route('notifications.read-all') }}" style="display: inline;">
            @csrf
            <button type="submit" class="btn-mark-all">
                Tandai Semua Sudah Dibaca
            </button>
        </form>
        @endif
    </div>

    <div class="notifications-container">
        @if($notifications->count() > 0)
            @foreach($notifications as $notification)
            @php
                $orderLink = $notification->action_url ?? null;
            @endphp

            <div data-href="{{ $orderLink }}" class="notification-card {{ !$notification->is_read ? 'unread' : '' }} is-{{ getNotificationType($notification->type) }}" @if($orderLink) style="cursor:pointer;" @endif>
                <div style="display: flex; gap: 1rem;">
                    <div class="notification-icon">
                        {!! getNotificationIcon($notification->type) !!}
                    </div>

                    <div style="flex-grow: 1;">
                        <div class="notification-header" style="margin: 0; align-items: center;">
                            <div style="flex-grow: 1;">
                                <div class="notification-title">{{ $notification->title }}</div>
                                <div class="notification-message">{{ $notification->message }}</div>
                            </div>
                            @if(!$notification->is_read)
                            <span style="display: inline-block; width: 10px; height: 10px; background: var(--primary, #3A7BFF); border-radius: 50%;"></span>
                            @endif
                        </div>

                        <div class="notification-time">
                            {{ $notification->created_at->diffForHumans() }}
                        </div>

                        <!-- Action Buttons -->
                        <div class="notification-actions">
                            @if($notification->type === 'new_order' && $orderLink)
                            <a href="{{ $orderLink }}" 
                               class="btn-notif-action">
                                <i class="fas fa-eye me-1"></i>Lihat Pesanan
                            </a>
                            @endif

                            <form method="POST" action="{{ route('notifications.read', $notification) }}" style="flex: 1;" onsubmit="event.stopPropagation();">
                                @csrf
                                <button type="submit" class="btn-notif-action btn-secondary w-100">
                                    <i class="fas fa-check me-1"></i>Sudah Dibaca
                                </button>
                            </form>
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
                        // If click originated from a button or link, ignore
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
                <i class="fas fa-inbox"></i>
                <h4>Belum Ada Notifikasi</h4>
                <p class="text-muted">Anda akan mendapat notifikasi ketika ada aktivitas baru</p>
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
