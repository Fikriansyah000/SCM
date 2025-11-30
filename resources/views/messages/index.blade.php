@extends('layouts.app')

@section('title', 'Pesan - PestiMart')

@section('content')
<style>
    .messages-header {
        background: linear-gradient(135deg, var(--primary, #3A7BFF) 0%, var(--secondary, #6ECBF9) 100%);
        color: white;
        padding: 2rem 0;
        margin-bottom: 2rem;
    }
    
    .messages-container {
        background: var(--card-bg, #FFFFFF);
        border-radius: 0.75rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        overflow: hidden;
    }
    
    .conversation-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    
    .conversation-item {
        padding: 1rem;
        border-bottom: 1px solid var(--neutral-gray, #ECEEF3);
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: flex;
        align-items: stretch;
        color: inherit;
        gap: 1rem;
    }
    
    .conversation-item:last-child {
        border-bottom: none;
    }
    
    @media (hover: hover) {
        .conversation-item:hover {
            background: var(--neutral-gray, #ECEEF3);
            padding-left: 1.5rem;
        }
    }
    
    .conversation-avatar-wrapper {
        flex-shrink: 0;
        display: flex;
        align-items: center;
    }
    
    .conversation-avatar {
        width: 56px;
        height: 56px;
        background: linear-gradient(135deg, var(--primary, #3A7BFF) 0%, var(--secondary, #6ECBF9) 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 1.2rem;
        flex-shrink: 0;
        box-shadow: 0 2px 6px rgba(58, 123, 255, 0.2);
    }

    .conversation-avatar.shop {
        background: linear-gradient(135deg, var(--accent, #FF8F3A) 0%, #FFB366 100%);
    }
    
    .conversation-content {
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
        min-width: 0;
        gap: 0.35rem;
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
        font-size: 0.95rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        flex-shrink: 0;
    }
    
    .conversation-time {
        color: #999;
        font-size: 0.8rem;
        text-align: right;
        white-space: nowrap;
        flex-shrink: 0;
    }
    
    .conversation-message {
        color: #666;
        font-size: 0.87rem;
        word-break: break-word;
        overflow-wrap: break-word;
        hyphens: auto;
        line-height: 1.3;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        margin: 0;
    }

    .conversation-type-badge {
        display: inline-block;
        padding: 0.2rem 0.6rem;
        background: rgba(58, 123, 255, 0.1);
        color: var(--primary, #3A7BFF);
        border-radius: 0.25rem;
        font-size: 0.7rem;
        font-weight: 600;
        margin-top: 0.25rem;
    }
    
    .empty-messages {
        text-align: center;
        padding: 3rem;
    }
    
    .empty-messages i {
        font-size: 3rem;
        color: #ddd;
        margin-bottom: 1rem;
    }

    .empty-messages h4 {
        color: var(--neutral-dark, #1A1F36);
        margin-bottom: 0.5rem;
    }

    @media (max-width: 768px) {
        .conversation-item {
            padding: 0.85rem;
            gap: 0.75rem;
        }

        .conversation-avatar {
            width: 48px;
            height: 48px;
            font-size: 1rem;
        }

        .conversation-name {
            font-size: 0.9rem;
        }

        .conversation-message {
            font-size: 0.8rem;
        }

        .conversation-time {
            font-size: 0.75rem;
        }
    }

    @media (max-width: 480px) {
        .conversation-item {
            padding: 0.75rem;
            gap: 0.6rem;
        }

        .conversation-avatar {
            width: 44px;
            height: 44px;
            font-size: 0.9rem;
        }

        .conversation-name {
            font-size: 0.85rem;
        }

        .conversation-message {
            font-size: 0.75rem;
            -webkit-line-clamp: 1;
        }

        .conversation-time {
            font-size: 0.7rem;
        }
    }
</style>

<div class="messages-header">
    <div class="container">
        <h2>
            <i class="fas fa-envelope me-2"></i>Pesan
        </h2>
    </div>
</div>

<div class="container my-4">
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
