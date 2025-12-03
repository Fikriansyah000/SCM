@extends('layouts.app')

@section('title', 'Pesan - PestiMart')

@section('content')
<style>
    :root {
        --msg-primary: #6366f1;
        --msg-secondary: #8b5cf6;
    }

    .messages-page-container {
        max-width: 900px;
        margin: 0 auto;
        padding: 1.5rem 1rem 3rem;
    }

    .page-header {
        margin-bottom: 1.5rem;
    }

    .page-title {
        font-size: 1.75rem;
        font-weight: 800;
        background: linear-gradient(135deg, var(--msg-primary) 0%, var(--msg-secondary) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .page-title i {
        font-size: 1.5rem;
    }
    
    .messages-container {
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.98) 0%, rgba(248, 250, 252, 0.95) 100%);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        box-shadow: 0 8px 32px rgba(0,0,0,0.08);
        overflow: hidden;
        border: 1px solid rgba(226, 232, 240, 0.8);
        position: relative;
    }

    .messages-container::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--msg-primary) 0%, var(--msg-secondary) 50%, var(--msg-primary) 100%);
        background-size: 200% 100%;
        animation: shimmer 3s ease-in-out infinite;
    }

    @keyframes shimmer {
        0%, 100% { background-position: 200% 0; }
        50% { background-position: 0% 0; }
    }
    
    .conversation-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    
    .conversation-item {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid rgba(226, 232, 240, 0.6);
        cursor: pointer;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        text-decoration: none;
        display: flex;
        align-items: center;
        color: inherit;
        gap: 1.25rem;
        position: relative;
    }
    
    .conversation-item:last-child {
        border-bottom: none;
    }
    
    @media (hover: hover) {
        .conversation-item:hover {
            background: linear-gradient(90deg, rgba(99, 102, 241, 0.06) 0%, transparent 100%);
            transform: translateX(6px);
        }
    }

    .conversation-item::after {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 4px;
        height: 0;
        background: linear-gradient(180deg, var(--msg-primary), var(--msg-secondary));
        border-radius: 0 4px 4px 0;
        transition: height 0.25s ease;
    }

    .conversation-item:hover::after {
        height: 60%;
    }
    
    .conversation-avatar-wrapper {
        flex-shrink: 0;
        display: flex;
        align-items: center;
    }
    
    .conversation-avatar {
        width: 58px;
        height: 58px;
        background: linear-gradient(135deg, var(--msg-primary) 0%, var(--msg-secondary) 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 1.3rem;
        flex-shrink: 0;
        box-shadow: 0 4px 14px rgba(99, 102, 241, 0.3);
        transition: all 0.25s ease;
    }

    .conversation-item:hover .conversation-avatar {
        transform: scale(1.05);
        box-shadow: 0 6px 20px rgba(99, 102, 241, 0.4);
    }

    .conversation-avatar.shop {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        box-shadow: 0 4px 14px rgba(245, 158, 11, 0.3);
    }

    .conversation-item:hover .conversation-avatar.shop {
        box-shadow: 0 6px 20px rgba(245, 158, 11, 0.4);
    }
    
    .conversation-content {
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
        min-width: 0;
        gap: 0.5rem;
    }
    
    .conversation-header {
        display: flex;
        align-items: baseline;
        justify-content: space-between;
        gap: 1rem;
    }
    
    .conversation-name {
        font-weight: 600;
        color: #1e293b;
        font-size: 1.05rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    .conversation-time {
        color: #94a3b8;
        font-size: 0.82rem;
        text-align: right;
        white-space: nowrap;
        flex-shrink: 0;
        font-weight: 500;
    }
    
    .conversation-message {
        color: #64748b;
        font-size: 0.92rem;
        word-break: break-word;
        overflow-wrap: break-word;
        line-height: 1.45;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        margin: 0;
    }

    .conversation-type-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.35rem 0.85rem;
        background: linear-gradient(135deg, rgba(245, 158, 11, 0.12) 0%, rgba(217, 119, 6, 0.08) 100%);
        color: #b45309;
        border-radius: 999px;
        font-size: 0.75rem;
        font-weight: 600;
        margin-top: 0.4rem;
        width: fit-content;
        border: 1px solid rgba(245, 158, 11, 0.2);
    }
    
    .empty-messages {
        text-align: center;
        padding: 4rem 2rem;
    }
    
    .empty-messages i {
        font-size: 4rem;
        background: linear-gradient(135deg, var(--msg-primary) 0%, var(--msg-secondary) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 1.5rem;
        display: block;
        opacity: 0.6;
    }

    .empty-messages h4 {
        color: #1e293b;
        margin-bottom: 0.75rem;
        font-size: 1.25rem;
        font-weight: 700;
    }

    .empty-messages p {
        color: #64748b;
        font-size: 1rem;
    }

    /* Tablet */
    @media (max-width: 992px) {
        .messages-page-container {
            max-width: 100%;
        }
    }

    /* Mobile */
    @media (max-width: 768px) {
        .messages-page-container {
            padding: 1rem;
        }

        .page-title {
            font-size: 1.5rem;
        }

        .messages-container {
            border-radius: 16px;
        }

        .conversation-item {
            padding: 1rem 1.25rem;
            gap: 1rem;
        }

        .conversation-avatar {
            width: 52px;
            height: 52px;
            font-size: 1.15rem;
        }

        .conversation-name {
            font-size: 1rem;
        }

        .conversation-message {
            font-size: 0.88rem;
        }

        .conversation-time {
            font-size: 0.78rem;
        }
    }

    /* Small mobile */
    @media (max-width: 480px) {
        .page-title {
            font-size: 1.35rem;
        }

        .conversation-item {
            padding: 0.9rem 1rem;
            gap: 0.85rem;
        }

        .conversation-avatar {
            width: 46px;
            height: 46px;
            font-size: 1.05rem;
        }

        .conversation-name {
            font-size: 0.95rem;
        }

        .conversation-message {
            font-size: 0.85rem;
            -webkit-line-clamp: 1;
        }

        .conversation-time {
            font-size: 0.72rem;
        }
    }
</style>

<div class="messages-page-container">
    <div class="page-header">
        <h2 class="page-title">
            <i class="fas fa-envelope"></i>Pesan
        </h2>
    </div>

    <div class="messages-container">
        @if($conversations->count() > 0)
            <div class="conversation-list">
                @foreach($conversations as $conversation)
                    @php
                        $otherUserId = $conversation->sender_id == auth()->id() 
                            ? $conversation->receiver_id 
                            : $conversation->sender_id;
                        $otherUser = $conversation->sender_id == auth()->id() 
                            ? $conversation->receiver 
                            : $conversation->sender;
                        $displayName = $otherUser->name;
                        $isShopChat = false;
                        if ($conversation->shop) {
                            $displayName = $conversation->shop->shop_name;
                            $isShopChat = true;
                        }
                        $chatUrl = $conversation->shop 
                            ? route('messages.show', ['user' => $otherUserId, 'shop_id' => $conversation->shop->id])
                            : route('messages.show', $otherUserId);
                    @endphp
                    
                    <a href="{{ $chatUrl }}" class="conversation-item">
                        <div class="conversation-avatar-wrapper">
                            <div class="conversation-avatar {{ $isShopChat ? 'shop' : '' }}">
                                {{ strtoupper(substr($displayName, 0, 1)) }}
                            </div>
                        </div>
                        <div class="conversation-content">
                            <div class="conversation-header">
                                <div class="conversation-name">{{ $displayName }}</div>
                                <div class="conversation-time">
                                    {{ $conversation->created_at->format('H:i') }}
                                </div>
                            </div>
                            <p class="conversation-message">{{ $conversation->message }}</p>
                            @if($isShopChat)
                                <span class="conversation-type-badge">
                                    <i class="fas fa-store me-1"></i>Shop Chat
                                </span>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="empty-messages">
                <i class="fas fa-envelope"></i>
                <h4>Belum Ada Pesan</h4>
                <p class="text-muted">Mulai percakapan dengan menghubungi penjual atau pembeli</p>
            </div>
        @endif
    </div>
</div>
@endsection
