@extends('layouts.seller')

@section('title', 'Pesan - PestiMart')
@section('page-title', 'Pesan')

@section('content')
<style>
    .messages-container {
        background: white;
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-sm);
        overflow: hidden;
        border: 1px solid var(--color-border);
    }
    
    .conversation-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    
    .conversation-item {
        padding: var(--space-md);
        border-bottom: 1px solid var(--color-border);
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
        display: flex;
        align-items: center;
        color: inherit;
        gap: var(--space-md);
    }
    
    .conversation-item:last-child {
        border-bottom: none;
    }
    
    .conversation-item:hover {
        background: linear-gradient(90deg, rgba(58, 123, 255, 0.05) 0%, transparent 100%);
        padding-left: calc(var(--space-md) + var(--space-xs));
    }
    
    .conversation-avatar-wrapper {
        flex-shrink: 0;
        display: flex;
        align-items: center;
    }
    
    .conversation-avatar {
        width: 52px;
        height: 52px;
        background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary) 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 1.2rem;
        flex-shrink: 0;
        box-shadow: var(--shadow-sm);
    }

    .conversation-avatar.shop {
        background: linear-gradient(135deg, var(--color-accent, #FF8F3A) 0%, #FFB366 100%);
    }
    
    .conversation-content {
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
        min-width: 0;
        gap: var(--space-xxs);
    }
    
    .conversation-header {
        display: flex;
        align-items: baseline;
        justify-content: space-between;
        gap: var(--space-sm);
    }
    
    .conversation-name {
        font-weight: 600;
        color: var(--color-text);
        font-size: var(--font-size-base);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    .conversation-time {
        color: var(--color-text-muted);
        font-size: var(--font-size-xs);
        text-align: right;
        white-space: nowrap;
        flex-shrink: 0;
    }
    
    .conversation-message {
        color: var(--color-text-secondary);
        font-size: var(--font-size-sm);
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
        gap: var(--space-xxs);
        padding: 0.2rem 0.6rem;
        background: var(--color-primary-light);
        color: var(--color-primary);
        border-radius: var(--radius-full);
        font-size: var(--font-size-xs);
        font-weight: 600;
        margin-top: var(--space-xxs);
        width: fit-content;
    }
    
    .empty-messages {
        text-align: center;
        padding: var(--space-xxl);
    }
    
    .empty-messages i {
        font-size: 3rem;
        color: var(--color-text-muted);
        margin-bottom: var(--space-md);
        display: block;
    }

    .empty-messages h4 {
        color: var(--color-text);
        margin-bottom: var(--space-xs);
        font-size: var(--font-size-lg);
    }

    .empty-messages p {
        color: var(--color-text-secondary);
        font-size: var(--font-size-sm);
    }

    /* Mobile */
    @media (max-width: 768px) {
        .conversation-item {
            padding: var(--space-sm);
            gap: var(--space-sm);
        }

        .conversation-avatar {
            width: 44px;
            height: 44px;
            font-size: 1rem;
        }

        .conversation-name {
            font-size: var(--font-size-sm);
        }

        .conversation-message {
            font-size: var(--font-size-xs);
            -webkit-line-clamp: 1;
        }
    }

    @media (max-width: 575.98px) {
        .messages-container {
            padding: 0;
        }
        .conversation-list {
            gap: 0.5rem;
        }
        .conversation-item {
            padding: 0.75rem;
            border-radius: 10px;
        }
        .conversation-avatar {
            width: 40px;
            height: 40px;
            font-size: 0.9rem;
        }
        .conversation-header {
            gap: 0.25rem;
        }
        .conversation-name {
            font-size: 0.85rem;
        }
        .conversation-time {
            font-size: 0.7rem;
        }
        .conversation-message {
            font-size: 0.8rem;
        }
        .unread-badge {
            width: 18px;
            height: 18px;
            font-size: 0.65rem;
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
                        ? route('seller.messages.show', ['user' => $otherUserId, 'shop_id' => $conversation->shop->id])
                        : route('seller.messages.show', $otherUserId);
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
                                <i class="fas fa-store"></i> Shop Chat
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
            <p>Mulai percakapan dengan menghubungi pembeli</p>
        </div>
    @endif
</div>
@endsection
