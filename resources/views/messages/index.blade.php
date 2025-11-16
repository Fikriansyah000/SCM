@extends('layouts.app')

@section('title', 'Pesan - PestiMart')

@section('content')
<style>
    .messages-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 2rem 0;
        margin-bottom: 2rem;
    }
    
    .messages-container {
        background: white;
        border-radius: 0.75rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        overflow: hidden;
    }
    
    .conversation-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    
    .conversation-item {
<<<<<<< HEAD
        padding: 1rem;
=======
        padding: 1.25rem;
>>>>>>> 81f0d06 (First Up|)
        border-bottom: 1px solid #f0f0f0;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
<<<<<<< HEAD
        display: flex;
        align-items: stretch;
        color: inherit;
        gap: 1rem;
=======
        display: block;
        color: inherit;
>>>>>>> 81f0d06 (First Up|)
    }
    
    .conversation-item:last-child {
        border-bottom: none;
    }
    
    .conversation-item:hover {
        background: #f8f9fa;
<<<<<<< HEAD
        padding-left: 1.5rem;
    }
    
    .conversation-avatar-wrapper {
        flex-shrink: 0;
        display: flex;
        align-items: center;
    }
    
    .conversation-avatar {
        width: 56px;
        height: 56px;
=======
    }
    
    .conversation-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 0.75rem;
    }
    
    .conversation-avatar {
        width: 50px;
        height: 50px;
>>>>>>> 81f0d06 (First Up|)
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
<<<<<<< HEAD
        font-weight: 700;
        font-size: 1.2rem;
        flex-shrink: 0;
        box-shadow: 0 2px 6px rgba(102, 126, 234, 0.2);
    }

    .conversation-avatar.shop {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
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
=======
        font-weight: 600;
        flex-shrink: 0;
    }
    
    .conversation-info {
        flex-grow: 1;
>>>>>>> 81f0d06 (First Up|)
    }
    
    .conversation-name {
        font-weight: 600;
        color: #333;
<<<<<<< HEAD
        font-size: 0.95rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        flex-shrink: 0;
=======
        margin-bottom: 0.25rem;
    }
    
    .conversation-message {
        color: #999;
        font-size: 0.9rem;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
>>>>>>> 81f0d06 (First Up|)
    }
    
    .conversation-time {
        color: #999;
<<<<<<< HEAD
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
        background: #e8f0ff;
        color: #667eea;
        border-radius: 0.25rem;
        font-size: 0.7rem;
        font-weight: 600;
        margin-top: 0.25rem;
=======
        font-size: 0.85rem;
        text-align: right;
>>>>>>> 81f0d06 (First Up|)
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
<<<<<<< HEAD

    .empty-messages h4 {
        color: #333;
        margin-bottom: 0.5rem;
    }

    @media (max-width: 768px) {
        .conversation-item {
            padding: 0.85rem;
            gap: 0.75rem;
        }

        .conversation-item:hover {
            padding-left: 1rem;
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
=======
>>>>>>> 81f0d06 (First Up|)
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
<<<<<<< HEAD
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
=======
                    @endphp
                    
                    <a href="{{ route('messages.show', $otherUserId) }}" class="conversation-item">
                        <div class="conversation-header">
                            <div class="conversation-avatar">
                                {{ strtoupper(substr($otherUser->name, 0, 1)) }}
                            </div>
                            <div class="conversation-info">
                                <div class="conversation-name">{{ $otherUser->name }}</div>
                                <div class="conversation-message">{{ Str::limit($conversation->message, 40) }}</div>
                            </div>
                            <div class="conversation-time">
                                {{ $conversation->created_at->format('H:i') }}
                            </div>
>>>>>>> 81f0d06 (First Up|)
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
