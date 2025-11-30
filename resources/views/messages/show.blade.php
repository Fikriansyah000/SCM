@extends('layouts.app')

@section('title', 'Chat dengan ' . $otherUser->name . ' - PestiMart')

@section('content')
<style>
    .chat-wrapper {
        background: var(--card-bg, #FFFFFF);
        border-radius: 1rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        overflow: hidden;
        display: flex;
        flex-direction: column;
        height: calc(100vh - 180px);
        margin-bottom: 2rem;
    }
    
    .chat-header {
        background: linear-gradient(135deg, var(--primary, #3A7BFF) 0%, var(--secondary, #6ECBF9) 100%);
        color: white;
        padding: 1.25rem 1.5rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
    }
    
    .chat-user-info {
        display: flex;
        align-items: center;
        gap: 1rem;
        flex-grow: 1;
    }
    
    .chat-avatar {
        width: 48px;
        height: 48px;
        background: rgba(255,255,255,0.25);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 1.1rem;
        flex-shrink: 0;
        border: 2px solid rgba(255,255,255,0.3);
    }
    
    .user-details h5 {
        margin-bottom: 0.25rem;
        font-size: 1rem;
        font-weight: 600;
    }
    
    .user-status {
        font-size: 0.8rem;
        opacity: 0.85;
        display: flex;
        align-items: center;
        gap: 0.4rem;
    }

    .user-status::before {
        content: '';
        width: 8px;
        height: 8px;
        background: #4ade80;
        border-radius: 50%;
        display: inline-block;
    }
    
    .chat-messages {
        flex-grow: 1;
        overflow-y: auto;
        padding: 1.25rem;
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        background: linear-gradient(180deg, #f0f4f8 0%, #e8ecf1 100%);
    }
    
    /* Native Chat Message Styling */
    .message {
        display: flex;
        align-items: flex-end;
        gap: 0.5rem;
        margin-bottom: 0.25rem;
        max-width: 85%;
    }

    .message.sent {
        align-self: flex-end;
        flex-direction: row-reverse;
    }

    .message.received {
        align-self: flex-start;
        flex-direction: row;
    }

    .message-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 0.8rem;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }

    .message.received .message-avatar {
        background: #e5e7eb;
        color: #4b5563;
    }

    .message.sent .message-avatar {
        background: linear-gradient(135deg, var(--primary, #3A7BFF) 0%, var(--secondary, #6ECBF9) 100%);
        color: #fff;
    }

    .message-content {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .message.sent .message-content {
        align-items: flex-end;
    }

    .message.received .message-content {
        align-items: flex-start;
    }
    
    .message-bubble {
        padding: 0.75rem 1rem;
        max-width: 100%;
        word-wrap: break-word;
        word-break: break-word;
        overflow-wrap: break-word;
        white-space: pre-wrap;
        line-height: 1.45;
        font-size: 0.95rem;
        box-shadow: 0 1px 2px rgba(0,0,0,0.06);
    }
    
    /* Native asymmetric corners - iMessage style */
    .message.received .message-bubble {
        background: #ffffff;
        color: var(--neutral-dark, #1A1F36);
        border-radius: 1.125rem 1.125rem 1.125rem 0.375rem;
    }
    
    .message.sent .message-bubble {
        background: linear-gradient(135deg, var(--primary, #3A7BFF) 0%, #5a9bff 100%);
        color: white;
        border-radius: 1.125rem 1.125rem 0.375rem 1.125rem;
    }
    
    .message-time {
        font-size: 0.7rem;
        color: #9ca3af;
        padding: 0 0.25rem;
    }

    .message.sent .message-time {
        text-align: right;
    }

    /* Date separator */
    .date-separator {
        text-align: center;
        padding: 0.75rem 0;
        font-size: 0.75rem;
        color: #6b7280;
        font-weight: 500;
    }

    .date-separator span {
        background: rgba(255,255,255,0.8);
        padding: 0.4rem 0.75rem;
        border-radius: 1rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }
    
    @media (max-width: 768px) {
        .chat-wrapper {
            height: calc(100vh - 150px);
            border-radius: 0;
            margin-bottom: 0;
        }

        .message {
            max-width: 90%;
        }

        .message-bubble {
            font-size: 0.9rem;
            padding: 0.7rem 0.9rem;
        }
        
        .chat-header {
            padding: 1rem;
        }
        
        .chat-avatar {
            width: 40px;
            height: 40px;
            font-size: 1rem;
        }

        .message-avatar {
            width: 28px;
            height: 28px;
            font-size: 0.7rem;
        }
    }
    
    @media (max-width: 480px) {
        .message-bubble {
            font-size: 0.875rem;
            padding: 0.65rem 0.85rem;
        }

        .message-avatar {
            display: none;
        }
    }
    
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(8px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .message-bubble {
        animation: fadeIn 0.25s ease-out;
    }
    
    .chat-input-area {
        padding: 1rem 1.25rem;
        border-top: 1px solid rgba(0,0,0,0.08);
        background: var(--card-bg, #FFFFFF);
    }
    
    .input-group {
        display: flex;
        align-items: flex-end;
        gap: 0.75rem;
    }
    
    .message-input {
        flex-grow: 1;
        padding: 0.75rem 1rem;
        border: 1px solid #e5e7eb;
        border-radius: 1.5rem;
        font-family: inherit;
        resize: none;
        max-height: 120px;
        min-height: 44px;
        font-size: 0.95rem;
        line-height: 1.4;
        background: #f9fafb;
        transition: all 0.2s ease;
    }
    
    .message-input:focus {
        outline: none;
        border-color: var(--primary, #3A7BFF);
        box-shadow: 0 0 0 3px rgba(58, 123, 255, 0.15);
        background: #ffffff;
    }

    .message-input::placeholder {
        color: #9ca3af;
    }
    
    .send-button {
        width: 44px;
        height: 44px;
        background: linear-gradient(135deg, var(--primary, #3A7BFF) 0%, var(--secondary, #6ECBF9) 100%);
        color: white;
        border: none;
        border-radius: 50%;
        cursor: pointer;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        box-shadow: 0 2px 8px rgba(58, 123, 255, 0.3);
    }

    .send-button i {
        font-size: 1rem;
        margin-left: 2px;
    }
    
    @media (hover: hover) {
        .send-button:hover {
            transform: scale(1.08);
            box-shadow: 0 4px 12px rgba(58, 123, 255, 0.4);
        }
    }
    
    .send-button:active {
        transform: scale(0.95);
    }
    
    .back-header {
        padding: 1rem;
        border-bottom: 1px solid var(--neutral-gray, #ECEEF3);
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    
    .back-link {
        color: var(--primary, #3A7BFF);
        text-decoration: none;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    @media (hover: hover) {
        .back-link:hover {
            text-decoration: underline;
        }
    }
</style>

<div class="container my-4">
    <div class="back-header">
        <a href="{{ route('messages.index') }}" class="back-link">
            <i class="fas fa-arrow-left"></i>Kembali ke Pesan
        </a>
    </div>
    
    <div class="chat-wrapper">
        <!-- Chat Header -->
        <div class="chat-header">
            <div class="chat-user-info">
                <div class="chat-avatar">
                    {{ strtoupper(substr($otherUser->name, 0, 1)) }}
                </div>
                <div class="user-details">
                    <h5>{{ $otherUser->name }}</h5>
                    <div class="user-status">
                        @if($shop)
                            <i class="fas fa-store me-1"></i>{{ $shop->shop_name }}
                        @else
                            @if($otherUser->role === 'seller')
                                <i class="fas fa-store me-1"></i>Penjual
                            @else
                                <i class="fas fa-shopping-cart me-1"></i>Pembeli
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Messages -->
        <div class="chat-messages" id="messagesContainer">
            @foreach($messages as $message)
                @php
                    $isSent = $message->sender_id == auth()->id();
                    $initials = strtoupper(substr($isSent ? auth()->user()->name : $otherUser->name, 0, 1));
                @endphp
                <div class="message {{ $isSent ? 'sent' : 'received' }}">
                    <div class="message-avatar" title="{{ $isSent ? auth()->user()->name : $otherUser->name }}">{{ $initials }}</div>
                    <div class="message-content">
                        <div class="message-bubble">{{ $message->message }}</div>
                        <div class="message-time">{{ $message->created_at->format('H:i') }}</div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Input Area -->
        <div class="chat-input-area">
            <form method="POST" action="{{ route('messages.send', $otherUser->id) }}" id="messageForm">
                @csrf
                @if($shop)
                    <input type="hidden" name="shop_id" value="{{ $shop->id }}">
                @endif
                <div class="input-group">
                    <textarea class="message-input" name="message" placeholder="Tulis pesan..." required></textarea>
                    <button type="submit" class="send-button" title="Kirim">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Smooth scroll ke bawah
const messagesContainer = document.getElementById('messagesContainer');

function scrollToBottom(smooth = true) {
    if (messagesContainer) {
        messagesContainer.scrollTo({
            top: messagesContainer.scrollHeight,
            behavior: smooth ? 'smooth' : 'instant'
        });
    }
}

// Initial scroll (instant)
scrollToBottom(false);

// Auto refresh messages setiap 3 detik
setInterval(() => {
    fetch(window.location.href)
        .then(response => response.text())
        .then(html => {
            const parser = new DOMParser();
            const newDoc = parser.parseFromString(html, 'text/html');
            const newMessages = newDoc.getElementById('messagesContainer');
            if (newMessages && newMessages.innerHTML !== messagesContainer.innerHTML) {
                messagesContainer.innerHTML = newMessages.innerHTML;
                scrollToBottom(true);
            }
        });
}, 3000);

// Handle form submit
document.getElementById('messageForm').addEventListener('submit', function(e) {
    const textarea = this.querySelector('textarea');
    if (textarea.value.trim() === '') {
        e.preventDefault();
        return;
    }
    // Reset textarea height after send
    setTimeout(() => {
        textarea.style.height = 'auto';
    }, 100);
});

// Auto-resize textarea with better max height
const messageInput = document.querySelector('.message-input');
messageInput.addEventListener('input', function() {
    this.style.height = 'auto';
    this.style.height = Math.min(this.scrollHeight, 120) + 'px';
});

// Submit on Enter (without Shift)
messageInput.addEventListener('keydown', function(e) {
    if (e.key === 'Enter' && !e.shiftKey) {
        e.preventDefault();
        if (this.value.trim() !== '') {
            document.getElementById('messageForm').submit();
        }
    }
});
</script>
@endsection
