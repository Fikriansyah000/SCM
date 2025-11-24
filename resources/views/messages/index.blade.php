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
        padding: 1.25rem;
        border-bottom: 1px solid #f0f0f0;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: block;
        color: inherit;
    }
    
    .conversation-item:last-child {
        border-bottom: none;
    }
    
    .conversation-item:hover {
        background: #f8f9fa;
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
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 600;
        flex-shrink: 0;
    }
    
    .conversation-info {
        flex-grow: 1;
    }
    
    .conversation-name {
        font-weight: 600;
        color: #333;
        margin-bottom: 0.25rem;
    }
    
    .conversation-message {
        color: #999;
        font-size: 0.9rem;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    
    .conversation-time {
        color: #999;
        font-size: 0.85rem;
        text-align: right;
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
                        if ($conversation->shop) {
                            $displayName = $conversation->shop->shop_name;
                        }
                        $chatUrl = $conversation->shop 
                            ? route('messages.show', ['user' => $otherUserId, 'shop_id' => $conversation->shop->id])
                            : route('messages.show', $otherUserId);
                    @endphp
                    
                    <a href="{{ $chatUrl }}" class="conversation-item">
                        <div class="conversation-header">
                            <div class="conversation-avatar">
                                {{ strtoupper(substr($displayName, 0, 1)) }}
                            </div>
                            <div class="conversation-info">
                                <div class="conversation-name">{{ $displayName }}</div>
                                <div class="conversation-message">{{ Str::limit($conversation->message, 40) }}</div>
                            </div>
                            <div class="conversation-time">
                                {{ $conversation->created_at->format('H:i') }}
                            </div>
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
