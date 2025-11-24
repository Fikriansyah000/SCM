@extends('layouts.app')

@section('title', 'Notifikasi - PestiMart')

@section('content')
<style>
    .notifications-container {
        max-width: 600px;
        margin: 0 auto;
    }

    .notification-card {
        background: white;
        border-left: 4px solid #667eea;
        border-radius: 0.75rem;
        padding: 1.5rem;
        margin-bottom: 1rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .notification-card:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.12);
        transform: translateY(-2px);
    }

    .notification-card.unread {
        background: #f8f9ff;
    }

    .notification-card.is-order {
        border-left-color: #667eea;
    }

    .notification-card.is-delivery {
        border-left-color: #43e97b;
    }

    .notification-card.is-message {
        border-left-color: #f093fb;
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
        background: #f0f4ff;
        border-radius: 50%;
        color: #667eea;
        font-size: 1.2rem;
        margin-right: 1rem;
        flex-shrink: 0;
    }

    .notification-title {
        font-weight: 600;
        color: #333;
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
    }

    .btn-notif-action {
        flex: 1;
        padding: 0.6rem 1rem;
        background: #667eea;
        color: white;
        border: none;
        border-radius: 0.4rem;
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        text-align: center;
        transition: all 0.3s ease;
    }

    .btn-notif-action:hover {
        background: #764ba2;
        text-decoration: none;
        color: white;
    }

    .btn-secondary {
        background: #f0f0f0;
        color: #333;
    }

    .btn-secondary:hover {
        background: #e0e0e0;
    }

    .empty-notifications {
        text-align: center;
        padding: 3rem;
        background: white;
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
    }

    .btn-mark-all {
        padding: 0.5rem 1rem;
        background: #f0f0f0;
        border: none;
        border-radius: 0.4rem;
        cursor: pointer;
        font-size: 0.85rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-mark-all:hover {
        background: #e0e0e0;
    }

    @media (max-width: 768px) {
        .notifications-container {
            padding: 0 1rem;
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
                $orderLink = null;
                if (isset($notification->data['order_id'])) {
                    if (auth()->user()->isSeller()) {
                        $orderLink = route('seller.orders.show', $notification->data['order_id']);
                    } else {
                        $orderLink = route('buyer.orders.show', $notification->data['order_id']);
                    }
                }
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
                            <span style="display: inline-block; width: 10px; height: 10px; background: #667eea; border-radius: 50%;"></span>
                            @endif
                        </div>

                        <div class="notification-time">
                            {{ $notification->created_at->diffForHumans() }}
                        </div>

                        <!-- Action Buttons -->
                        <div class="notification-actions">
                            @if($notification->type === 'new_order' && $notification->data && isset($notification->data['order_id']))
                            <a href="{{ route('seller.orders.show', $notification->data['order_id']) }}" 
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
