@extends('layouts.app')

@section('title', 'Chat dengan ' . $otherUser->name . ' - PestiMart')

@section('content')
<style>
    :root {
        --chat-primary: #6366f1;
        --chat-secondary: #8b5cf6;
        --chat-radius: 20px;
    }

    .chat-page-container {
        max-width: 900px;
        margin: 0 auto;
        padding: 1.5rem 1rem 2rem;
    }

    /* Back Link */
    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--chat-primary);
        text-decoration: none;
        font-weight: 600;
        font-size: 0.95rem;
        padding: 0.6rem 1.25rem;
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.08) 0%, rgba(139, 92, 246, 0.05) 100%);
        border-radius: 12px;
        transition: all 0.25s ease;
        margin-bottom: 1rem;
    }
    .back-link:hover {
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.15) 0%, rgba(139, 92, 246, 0.1) 100%);
        color: var(--chat-secondary);
        transform: translateX(-3px);
    }

    .chat-wrapper {
        background: #ffffff;
        border-radius: var(--chat-radius);
        box-shadow: 0 8px 40px rgba(0,0,0,0.08);
        overflow: hidden;
        display: flex;
        flex-direction: column;
        height: calc(100vh - 180px);
        min-height: 550px;
        border: 1px solid rgba(226, 232, 240, 0.8);
        position: relative;
    }
    .chat-wrapper::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--chat-primary) 0%, var(--chat-secondary) 50%, var(--chat-primary) 100%);
        background-size: 200% 100%;
        animation: shimmer 3s ease-in-out infinite;
        z-index: 10;
    }
    @keyframes shimmer {
        0%, 100% { background-position: 200% 0; }
        50% { background-position: 0% 0; }
    }
    
    /* Chat Header - Modern Style */
    .chat-header {
        background: linear-gradient(135deg, var(--chat-primary) 0%, var(--chat-secondary) 100%);
        color: white;
        padding: 1.25rem 1.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        box-shadow: 0 4px 20px rgba(99, 102, 241, 0.25);
    }
    
    .chat-user-info {
        display: flex;
        align-items: center;
        gap: 0.875rem;
        flex-grow: 1;
    }
    
    .chat-avatar {
        width: 50px;
        height: 50px;
        background: rgba(255,255,255,0.2);
        backdrop-filter: blur(8px);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1.2rem;
        flex-shrink: 0;
        border: 3px solid rgba(255,255,255,0.3);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    
    .user-details h5 {
        margin: 0 0 0.2rem;
        font-size: 1.1rem;
        font-weight: 600;
    }
    
    .user-status {
        font-size: 0.85rem;
        opacity: 0.95;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .user-status::before {
        content: '';
        width: 8px;
        height: 8px;
        background: #4ade80;
        border-radius: 50%;
        display: inline-block;
        box-shadow: 0 0 8px rgba(74, 222, 128, 0.7);
        animation: pulse 2s infinite;
    }
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }
    
    /* Chat Messages Area */
    .chat-messages {
        flex-grow: 1;
        overflow-y: auto;
        padding: 1.5rem 1.25rem;
        display: flex;
        flex-direction: column;
        gap: 0.85rem;
        background: linear-gradient(180deg, #f8fafc 0%, #f1f5f9 100%);
    }
    
    /* Native Chat Message - WhatsApp/iMessage Style */
    .message {
        display: flex;
        align-items: flex-end;
        gap: 0.5rem;
        max-width: 78%;
    }

    .message.sent {
        align-self: flex-end;
        flex-direction: row-reverse;
    }

    .message.received {
        align-self: flex-start;
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
        font-size: 0.75rem;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        margin-bottom: 1.25rem;
    }

    .message.received .message-avatar {
        background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e1 100%);
        color: #475569;
    }

    .message.sent .message-avatar {
        background: linear-gradient(135deg, var(--chat-primary) 0%, var(--chat-secondary) 100%);
        color: #fff;
    }

    .message-content {
        display: flex;
        flex-direction: column;
        gap: 0.35rem;
        max-width: 100%;
    }

    .message.sent .message-content {
        align-items: flex-end;
    }

    .message.received .message-content {
        align-items: flex-start;
    }
    
    /* Message Bubble - Native Style */
    .message-bubble {
        padding: 0.85rem 1.15rem;
        max-width: 100%;
        word-wrap: break-word;
        word-break: break-word;
        overflow-wrap: break-word;
        white-space: pre-wrap;
        line-height: 1.55;
        font-size: 0.95rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        position: relative;
    }
    
    /* Native asymmetric corners - iMessage style */
    .message.received .message-bubble {
        background: #ffffff;
        color: #1e293b;
        border-radius: 20px 20px 20px 6px;
        border: 1px solid rgba(226, 232, 240, 0.9);
    }
    
    .message.sent .message-bubble {
        background: linear-gradient(135deg, var(--chat-primary) 0%, var(--chat-secondary) 100%);
        color: white;
        border-radius: 20px 20px 6px 20px;
        box-shadow: 0 4px 14px rgba(99, 102, 241, 0.25);
    }
    
    .message-time {
        font-size: 0.7rem;
        color: #94a3b8;
        padding: 0 0.4rem;
        display: flex;
        align-items: center;
        gap: 0.3rem;
    }

    .message.sent .message-time {
        justify-content: flex-end;
    }

    /* Date separator */
    .date-separator {
        text-align: center;
        padding: 1rem 0;
        font-size: 0.78rem;
        color: #64748b;
        font-weight: 500;
    }

    .date-separator span {
        background: rgba(255,255,255,0.95);
        padding: 0.5rem 1rem;
        border-radius: 20px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        border: 1px solid rgba(226, 232, 240, 0.6);
    }
        background: rgba(255,255,255,0.9);
        padding: 0.4rem 0.85rem;
        border-radius: 1rem;
        box-shadow: 0 1px 4px rgba(0,0,0,0.06);
    }

    /* ========================================
       SYMMETRIC REPLY CARD - Native Style
       ======================================== */
    .reply-card {
        width: 100%;
        max-width: 280px;
        border-radius: 16px;
        overflow: hidden;
        margin-bottom: 0.5rem;
        transition: all 0.25s ease;
    }

    .reply-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0,0,0,0.1);
    }

    /* Product context card */
    .reply-card.product {
        background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%);
        border: 1px solid #a7f3d0;
        box-shadow: 0 3px 12px rgba(16, 185, 129, 0.15);
    }

    /* Proposal context card */
    .reply-card.proposal {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        border: 1px solid #fcd34d;
        box-shadow: 0 3px 12px rgba(245, 158, 11, 0.15);
    }

    /* Card inner layout - symmetric centered */
    .reply-card-inner {
        display: flex;
        align-items: center;
        gap: 0.85rem;
        padding: 0.75rem;
    }

    /* Thumbnail - perfectly square */
    .reply-thumb {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        overflow: hidden;
        flex-shrink: 0;
        background: rgba(255,255,255,0.7);
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 6px rgba(0,0,0,0.08);
    }

    .reply-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .reply-thumb i {
        font-size: 1.5rem;
        color: #9ca3af;
    }

    .reply-card.product .reply-thumb i {
        color: #10b981;
    }

    .reply-card.proposal .reply-thumb i {
        color: #f59e0b;
    }

    /* Meta info section */
    .reply-meta {
        flex: 1;
        min-width: 0;
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .reply-title {
        font-weight: 600;
        font-size: 0.88rem;
        color: #1e293b;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        line-height: 1.35;
    }

    .reply-subtitle {
        font-size: 0.78rem;
        color: #64748b;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .reply-card.product .reply-subtitle {
        color: #047857;
    }

    .reply-card.proposal .reply-subtitle {
        color: #b45309;
    }

    /* Badge - positioned at top-right corner */
    .reply-badge {
        position: absolute;
        top: 0.5rem;
        right: 0.5rem;
        font-size: 0.65rem;
        font-weight: 700;
        color: #fff;
        padding: 0.2rem 0.5rem;
        border-radius: 8px;
        text-transform: uppercase;
        letter-spacing: 0.4px;
    }

    .reply-card.product .reply-badge {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    }

    .reply-card.proposal .reply-badge {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    }

    /* Card wrapper for positioning badge */
    .reply-card-wrapper {
        position: relative;
    }

    /* Large desktop - full navbar width */
    @media (min-width: 1400px) {
        .chat-page-container {
            max-width: 1100px;
        }
    }

    /* Tablet landscape */
    @media (max-width: 1200px) {
        .chat-page-container {
            max-width: 100%;
            padding: 1rem;
        }
    }
    
    @media (max-width: 768px) {
        .chat-page-container {
            padding: 0.75rem;
        }

        .chat-wrapper {
            height: calc(100vh - 140px);
            min-height: 480px;
            border-radius: 16px;
        }

        .message {
            max-width: 85%;
        }

        .message-bubble {
            font-size: 0.92rem;
            padding: 0.8rem 1rem;
        }
        
        .chat-header {
            padding: 1rem 1.25rem;
        }
        
        .chat-avatar {
            width: 44px;
            height: 44px;
            font-size: 1.05rem;
        }

        .message-avatar {
            width: 30px;
            height: 30px;
            font-size: 0.75rem;
        }

        .reply-card {
            max-width: 260px;
        }

        .reply-thumb {
            width: 52px;
            height: 52px;
        }
        }

        .reply-title {
            font-size: 0.82rem;
        }

        .reply-subtitle {
            font-size: 0.72rem;
        }

        .back-link {
            font-size: 0.9rem;
            padding: 0.5rem 1rem;
        }
    }
    
    @media (max-width: 480px) {
        .chat-wrapper {
            height: calc(100vh - 120px);
            border-radius: 12px;
        }

        .message {
            max-width: 90%;
        }

        .message-bubble {
            font-size: 0.9rem;
            padding: 0.75rem 0.95rem;
        }

        .message-avatar {
            display: none;
        }

        .reply-card {
            max-width: 230px;
        }

        .reply-thumb {
            width: 48px;
            height: 48px;
        }

        .reply-card-inner {
            padding: 0.6rem;
            gap: 0.65rem;
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
        animation: fadeIn 0.3s ease-out;
    }
    
    /* Input Area */
    .chat-input-area {
        padding: 1rem 1.5rem;
        border-top: 1px solid rgba(226, 232, 240, 0.8);
        background: #ffffff;
    }
    
    .input-group {
        display: flex;
        align-items: flex-end;
        gap: 0.85rem;
        background: #f8fafc;
        border: 2px solid #e2e8f0;
        border-radius: 28px;
        padding: 0.35rem 0.5rem 0.35rem 0.75rem;
        transition: all 0.25s ease;
    }

    .input-group:focus-within {
        border-color: var(--chat-primary);
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.12);
        background: #ffffff;
    }
    
    .message-input {
        flex-grow: 1;
        padding: 0.75rem 0.5rem;
        border: none;
        font-family: inherit;
        resize: none;
        max-height: 120px;
        min-height: 46px;
        font-size: 0.95rem;
        line-height: 1.45;
        background: transparent;
    }
    
    .message-input:focus {
        outline: none;
    }

    .message-input::placeholder {
        color: #94a3b8;
    }
    
    .send-button {
        width: 48px;
        height: 48px;
        background: linear-gradient(135deg, var(--chat-primary) 0%, var(--chat-secondary) 100%);
        color: white;
        border: none;
        border-radius: 50%;
        cursor: pointer;
        transition: all 0.25s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        box-shadow: 0 4px 16px rgba(99, 102, 241, 0.35);
    }

    .send-button i {
        font-size: 1.1rem;
        margin-left: 2px;
    }
    
    @media (hover: hover) {
        .send-button:hover {
            transform: scale(1.08) translateY(-2px);
            box-shadow: 0 6px 24px rgba(99, 102, 241, 0.45);
        }
    }
    
    .send-button:active {
        transform: scale(0.95);
    }

    /* Context Banner Styling */
    .context-banner {
        padding: 1rem 1.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        border-bottom: 1px solid rgba(0,0,0,0.08);
    }
    .context-banner.proposal {
        background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%);
        border-color: #fcd34d;
    }
    .context-banner.product {
        background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
        border-color: #93c5fd;
    }
    .context-thumb {
        width: 58px;
        height: 58px;
        border-radius: 12px;
        overflow: hidden;
        flex-shrink: 0;
        background: rgba(255,255,255,0.7);
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }
    .context-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .context-meta {
        flex: 1;
        min-width: 0;
    }
    .context-title {
        font-weight: 600;
        font-size: 0.95rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        margin-bottom: 0.25rem;
    }
    .context-subtitle {
        font-size: 0.85rem;
    }
    .context-badge {
        padding: 0.4rem 0.85rem;
        border-radius: 999px;
        font-size: 0.78rem;
        font-weight: 600;
        white-space: nowrap;
        flex-shrink: 0;
    }
    .context-banner.proposal .context-title { color: #92400e; }
    .context-banner.proposal .context-subtitle { color: #b45309; }
    .context-banner.proposal .context-badge { background: #f59e0b; color: white; }
    .context-banner.product .context-title { color: #0369a1; }
    .context-banner.product .context-subtitle { color: #0284c7; }
    .context-banner.product .context-badge { background: #3b82f6; color: white; }
</style>

<div class="chat-page-container">
    <a href="{{ route('messages.index') }}" class="back-link">
        <i class="fas fa-arrow-left"></i>Kembali ke Pesan
    </a>
    
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
                            {{ $shop->shop_name }}
                        @else
                            @if($otherUser->role === 'seller')
                                Penjual
                            @else
                                Pembeli
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Context banner for proposal/product --}}
        @if(isset($proposal) && $proposal)
            <div class="context-banner proposal">
                <div class="context-thumb">
                    @if($proposal->product && $proposal->product->image)
                        <img src="{{ asset('storage/' . $proposal->product->image) }}" alt="{{ $proposal->product->name }}">
                    @else
                        <i class="fas fa-concierge-bell" style="font-size: 1.5rem; color: #f59e0b;"></i>
                    @endif
                </div>
                <div class="context-meta">
                    <div class="context-title">{{ $proposal->product->name ?? 'Layanan' }}</div>
                    <div class="context-subtitle">
                        Harga: Rp{{ number_format($proposal->proposed_price ?? $proposal->offered_price ?? 0, 0, ',', '.') }}
                        · Deadline: {{ $proposal->proposed_deadline ? \Carbon\Carbon::parse($proposal->proposed_deadline)->format('d M Y') : '-' }}
                    </div>
                </div>
                <span class="context-badge">Proposal #{{ $proposal->id }}</span>
            </div>
        @elseif(isset($product) && $product)
            <div class="context-banner product">
                <div class="context-thumb">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                    @else
                        <i class="fas fa-box" style="font-size: 1.5rem; color: #3b82f6;"></i>
                    @endif
                </div>
                <div class="context-meta">
                    <div class="context-title">{{ $product->name }}</div>
                    <div class="context-subtitle">
                        {{ $product->shop->shop_name ?? 'Toko' }} · Rp{{ number_format($product->price, 0, ',', '.') }}
                    </div>
                </div>
            </div>
        @endif
        
        <!-- Messages -->
        <div class="chat-messages" id="messagesContainer">
            @foreach($messages as $message)
                @php
                    $isSent = $message->sender_id == auth()->id();
                    $initials = strtoupper(substr($isSent ? auth()->user()->name : $otherUser->name, 0, 1));
                    $context = $message->context;
                @endphp
                <div class="message {{ $isSent ? 'sent' : 'received' }}">
                    <div class="message-avatar" title="{{ $isSent ? auth()->user()->name : $otherUser->name }}">{{ $initials }}</div>
                    <div class="message-content">
                        @if($context)
                            @php
                                $isProposalContext = $message->context_type === 'proposal';
                                $contextProduct = $isProposalContext ? ($context->product ?? null) : $context;
                                $thumb = $contextProduct && $contextProduct->image ? asset('storage/' . $contextProduct->image) : null;
                                $priceValue = $isProposalContext ? $context->getFinalPrice() : ($context->price ?? 0);
                            @endphp
                            <div class="reply-card-wrapper">
                                <div class="reply-card {{ $message->context_type }}">
                                    <div class="reply-card-inner">
                                        <div class="reply-thumb">
                                            @if($thumb)
                                                <img src="{{ $thumb }}" alt="{{ $contextProduct->name ?? 'Layanan' }}">
                                            @else
                                                <i class="fas {{ $isProposalContext ? 'fa-concierge-bell' : 'fa-box' }}"></i>
                                            @endif
                                        </div>
                                        <div class="reply-meta">
                                            <div class="reply-title">{{ $contextProduct->name ?? 'Layanan Khusus' }}</div>
                                            <div class="reply-subtitle">
                                                Rp{{ number_format($priceValue, 0, ',', '.') }}
                                                @if($isProposalContext && $context->getFinalDeadline())
                                                    · {{ $context->getFinalDeadline()->format('d M Y') }}
                                                @elseif(!$isProposalContext && $contextProduct && $contextProduct->shop)
                                                    · {{ $contextProduct->shop->shop_name }}
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <span class="reply-badge">
                                        {{ $isProposalContext ? 'Proposal' : 'Produk' }}
                                    </span>
                                </div>
                            </div>
                        @endif
                        <div class="message-bubble">{{ $message->message }}</div>
                        <div class="message-time">
                            <i class="far fa-clock" style="font-size: 0.6rem;"></i>
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
                @if($shop)
                    <input type="hidden" name="shop_id" value="{{ $shop->id }}">
                @endif
                @if(isset($proposal) && $proposal)
                    <input type="hidden" name="proposal_id" value="{{ $proposal->id }}">
                @endif
                @if(isset($product) && $product)
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
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
