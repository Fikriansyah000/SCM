@extends('layouts.app')

@section('title', 'Chat dengan ' . $otherUser->name . ' - PestiMart')

@section('content')
<style>
    .chat-wrapper {
        background: white;
        border-radius: 0.75rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        overflow: hidden;
        display: flex;
        flex-direction: column;
        height: calc(100vh - 200px);
        margin-bottom: 2rem;
    }
    
    .chat-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 1.5rem;
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
        width: 50px;
        height: 50px;
        background: rgba(255,255,255,0.3);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 1.2rem;
    }
    
    .user-details h5 {
        margin-bottom: 0;
        font-size: 1rem;
    }
    
    .user-status {
        font-size: 0.85rem;
        opacity: 0.9;
    }
    
    .chat-messages {
        flex-grow: 1;
        overflow-y: auto;
        padding: 1.5rem;
        display: flex;
        flex-direction: column;
<<<<<<< HEAD
        gap: 0.75rem;
        background: #fafbfc;
=======
        gap: 1rem;
>>>>>>> 81f0d06 (First Up|)
    }
    
    .message {
        display: flex;
<<<<<<< HEAD
        flex-direction: column;
        margin-bottom: 0;
    }
    
    .message.sent {
        align-items: flex-end;
    }
    
    .message.received {
        align-items: flex-start;
    }
    
    .message-bubble {
        padding: 0.875rem 1.125rem;
        border-radius: 1.125rem;
        max-width: 75%;
        word-wrap: break-word;
        word-break: break-word;
        overflow-wrap: break-word;
        white-space: pre-wrap;
        animation: fadeIn 0.3s ease;
        line-height: 1.4;
        font-size: 0.95rem;
=======
        margin-bottom: 0.5rem;
    }
    
    .message.sent {
        justify-content: flex-end;
    }
    
    .message-bubble {
        padding: 0.75rem 1rem;
        border-radius: 1rem;
        max-width: 70%;
        word-wrap: break-word;
        animation: fadeIn 0.3s ease;
>>>>>>> 81f0d06 (First Up|)
    }
    
    .message.received .message-bubble {
        background: #f0f0f0;
        color: #333;
    }
    
    .message.sent .message-bubble {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }
    
    .message-time {
        font-size: 0.75rem;
        color: #999;
<<<<<<< HEAD
        margin-top: 0.375rem;
        padding: 0 0.5rem;
        opacity: 0.8;
    }
    
    @media (max-width: 768px) {
        .message-bubble {
            max-width: 85%;
            font-size: 0.9rem;
            padding: 0.75rem 1rem;
        }
    }
    
    @media (max-width: 480px) {
        .message-bubble {
            max-width: 90%;
            font-size: 0.85rem;
            padding: 0.7rem 0.9rem;
        }
=======
        margin-top: 0.25rem;
        padding: 0 0.5rem;
>>>>>>> 81f0d06 (First Up|)
    }
    
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .chat-input-area {
        padding: 1.5rem;
        border-top: 1px solid #f0f0f0;
        background: #f8f9fa;
    }
    
    .input-group {
        display: flex;
        gap: 0.5rem;
    }
    
    .message-input {
        flex-grow: 1;
        padding: 0.75rem 1rem;
        border: 1px solid #ddd;
        border-radius: 2rem;
        font-family: inherit;
        resize: none;
        max-height: 100px;
    }
    
    .message-input:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }
    
    .send-button {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        border-radius: 50%;
        cursor: pointer;
        transition: transform 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
    }
    
    .send-button:hover {
        transform: scale(1.05);
    }
    
    .send-button:active {
        transform: scale(0.95);
    }
    
    .back-header {
        padding: 1rem;
        border-bottom: 1px solid #f0f0f0;
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    
    .back-link {
        color: #667eea;
        text-decoration: none;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .back-link:hover {
        text-decoration: underline;
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
<<<<<<< HEAD
                        @if($shop)
                            <i class="fas fa-store me-1"></i>{{ $shop->shop_name }}
                        @else
                            @if($otherUser->role === 'seller')
                                <i class="fas fa-store me-1"></i>Penjual
                            @else
                                <i class="fas fa-shopping-cart me-1"></i>Pembeli
                            @endif
=======
                        @if($otherUser->role === 'seller')
                            <i class="fas fa-store me-1"></i>Penjual
                        @else
                            <i class="fas fa-shopping-cart me-1"></i>Pembeli
>>>>>>> 81f0d06 (First Up|)
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Messages -->
        <div class="chat-messages" id="messagesContainer">
            @foreach($messages as $message)
            <div class="message {{ $message->sender_id == auth()->id() ? 'sent' : 'received' }}">
                <div>
                    <div class="message-bubble">
                        {{ $message->message }}
                    </div>
                    <div class="message-time">
                        {{ $message->created_at->format('H:i') }}
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <!-- Input Area -->
        <div class="chat-input-area">
            <form method="POST" action="{{ route('messages.send', $otherUser->id) }}" id="messageForm">
                @csrf
<<<<<<< HEAD
                @if($shop)
                    <input type="hidden" name="shop_id" value="{{ $shop->id }}">
                @endif
=======
>>>>>>> 81f0d06 (First Up|)
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
// Auto scroll ke bawah
const messagesContainer = document.getElementById('messagesContainer');
if (messagesContainer) {
    messagesContainer.scrollTop = messagesContainer.scrollHeight;
}

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
                messagesContainer.scrollTop = messagesContainer.scrollHeight;
            }
        });
}, 3000);

// Disable send button saat form submit
document.getElementById('messageForm').addEventListener('submit', function(e) {
    const textarea = this.querySelector('textarea');
    if (textarea.value.trim() === '') {
        e.preventDefault();
    }
});

// Auto-resize textarea
document.querySelector('.message-input').addEventListener('input', function() {
    this.style.height = 'auto';
    this.style.height = Math.min(this.scrollHeight, 100) + 'px';
});
</script>
@endsection
