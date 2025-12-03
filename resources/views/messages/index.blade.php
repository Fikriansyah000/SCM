@extends('layouts.app')

@section('title', 'Pesan - PestiMart')

@section('content')
<style>
    .messages-page-container {
        max-width: 1000px;
        margin: 0 auto;
        padding: 0 1rem;
    }

    .messages-header {
        background: linear-gradient(135deg, var(--primary, #3A7BFF) 0%, var(--secondary, #6ECBF9) 100%);
        color: white;
        padding: 2.5rem 0;
        margin-bottom: 2rem;
    }

    .messages-header h2 {
        font-size: 1.75rem;
        font-weight: 700;
        margin: 0;
    }
    
    .messages-container {
        background: var(--card-bg, #FFFFFF);
        border-radius: 1rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        overflow: hidden;
        border: 1px solid var(--neutral-gray, #ECEEF3);
    }
    
    .conversation-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    
    .conversation-item {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid var(--neutral-gray, #ECEEF3);
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
        display: flex;
        align-items: center;
        color: inherit;
        gap: 1.25rem;
    }
    
    .conversation-item:last-child {
        border-bottom: none;
    }
    
    @media (hover: hover) {
        .conversation-item:hover {
            background: linear-gradient(90deg, rgba(58,123,255,0.05) 0%, transparent 100%);
            padding-left: 2rem;
        }
    }
    
    .conversation-avatar-wrapper {
        flex-shrink: 0;
        display: flex;
        align-items: center;
    }
    
    .conversation-avatar {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, var(--primary, #3A7BFF) 0%, var(--secondary, #6ECBF9) 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 1.35rem;
        flex-shrink: 0;
        box-shadow: 0 4px 12px rgba(58, 123, 255, 0.25);
    }

    .conversation-avatar.shop {
        background: linear-gradient(135deg, var(--accent, #FF8F3A) 0%, #FFB366 100%);
        box-shadow: 0 4px 12px rgba(255, 143, 58, 0.25);
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
        color: var(--neutral-dark, #1A1F36);
        font-size: 1.05rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    .conversation-time {
        color: #9ca3af;
        font-size: 0.85rem;
        text-align: right;
        white-space: nowrap;
        flex-shrink: 0;
    }
    
    .conversation-message {
        color: #6b7280;
        font-size: 0.95rem;
        word-break: break-word;
        overflow-wrap: break-word;
        line-height: 1.4;
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
        gap: 0.35rem;
        padding: 0.3rem 0.75rem;
        background: linear-gradient(135deg, rgba(58, 123, 255, 0.1) 0%, rgba(110, 203, 249, 0.1) 100%);
        color: var(--primary, #3A7BFF);
        border-radius: 999px;
        font-size: 0.75rem;
        font-weight: 600;
        margin-top: 0.35rem;
        width: fit-content;
    }
    
    .empty-messages {
        text-align: center;
        padding: 4rem 2rem;
    }
    
    .empty-messages i {
        font-size: 4rem;
        color: #d1d5db;
        margin-bottom: 1.5rem;
        display: block;
    }

    .empty-messages h4 {
        color: var(--neutral-dark, #1A1F36);
        margin-bottom: 0.75rem;
        font-size: 1.25rem;
    }

    .empty-messages p {
        color: #6b7280;
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
        .messages-header {
            padding: 1.5rem 0;
            margin-bottom: 1rem;
        }

        .messages-header h2 {
            font-size: 1.4rem;
        }

        .messages-container {
            border-radius: 0.75rem;
            margin: 0 -0.5rem;
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
            font-size: 0.9rem;
        }

        .conversation-time {
            font-size: 0.8rem;
        }
    }

    /* Small mobile */
    @media (max-width: 480px) {
        .messages-header {
            padding: 1.25rem 0;
        }

        .conversation-item {
            padding: 0.9rem 1rem;
            gap: 0.85rem;
        }

        .conversation-avatar {
            width: 48px;
            height: 48px;
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
            font-size: 0.7rem;
        }
    }
</style>

<div class="messages-header">
    <div class="messages-page-container">
        <h2>
            <i class="fas fa-envelope me-2"></i>Pesan
        </h2>
    </div>
</div>

<div class="messages-page-container" style="padding-bottom: 3rem;">
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
