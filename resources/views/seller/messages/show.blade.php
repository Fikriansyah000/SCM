@extends('layouts.seller')

@section('title', 'Chat dengan ' . $otherUser->name . ' - PestiMart')
@section('page-title', 'Chat')

@section('content')
<style>
    .chat-wrapper {
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 0 8px 32px rgba(0,0,0,0.08);
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
        background: linear-gradient(90deg, #3A7BFF 0%, #6ECBF9 50%, #3A7BFF 100%);
        background-size: 200% 100%;
        animation: shimmer 3s ease-in-out infinite;
        z-index: 10;
    }
    @keyframes shimmer {
        0%, 100% { background-position: 200% 0; }
        50% { background-position: 0% 0; }
    }
    
    /* Chat Header */
    .chat-header {
        background: linear-gradient(135deg, #3A7BFF 0%, #6ECBF9 100%);
        color: white;
        padding: 1rem 1.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        box-shadow: 0 4px 20px rgba(58, 123, 255, 0.25);
        position: relative;
        z-index: 5;
    }
    
    .back-btn {
        width: 40px;
        height: 40px;
        background: rgba(255,255,255,0.2);
        backdrop-filter: blur(8px);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        text-decoration: none;
        transition: all 0.25s ease;
        flex-shrink: 0;
        border: 2px solid rgba(255,255,255,0.3);
    }
    .back-btn:hover {
        background: rgba(255,255,255,0.3);
        color: white;
        transform: translateX(-3px);
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
    
    .user-details {
        flex: 1;
        min-width: 0;
    }
    
    .user-details h5 {
        margin: 0 0 0.3rem 0;
        font-size: 1.1rem;
        font-weight: 600;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        color: #ffffff;
    }
    
    .user-status {
        font-size: 0.85rem;
        opacity: 0.95;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: rgba(255,255,255,0.9);
    }

    .online-dot {
        width: 10px;
        height: 10px;
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
    
    .shop-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        background: rgba(255,255,255,0.2);
        padding: 0.3rem 0.75rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 500;
    }
    
    /* Context Banner */
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
        width: 60px;
        height: 60px;
        border-radius: 12px;
        overflow: hidden;
        flex-shrink: 0;
        background: rgba(255,255,255,0.8);
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
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
        margin-bottom: 0.3rem;
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
    .context-banner.product .context-title { color: #1e40af; }
    .context-banner.product .context-subtitle { color: #3b82f6; }
    .context-banner.product .context-badge { background: #3b82f6; color: white; }
    
    /* Messages Container */
    .chat-messages {
        flex-grow: 1;
        overflow-y: auto;
        padding: 1.5rem 1.25rem;
        display: flex;
        flex-direction: column;
        gap: 0.85rem;
        background: linear-gradient(180deg, #f8fafc 0%, #f1f5f9 100%);
    }
    
    /* Message Styling */
    .message {
        display: flex;
        align-items: flex-end;
        gap: 0.5rem;
        margin-bottom: 0.25rem;
        max-width: 78%;
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
        width: 36px;
        height: 36px;
        border-radius: 50%;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 0.85rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .message.received .message-avatar {
        background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e1 100%);
        color: #475569;
    }

    .message.sent .message-avatar {
        background: linear-gradient(135deg, var(--color-primary, #6366f1) 0%, var(--color-secondary, #8b5cf6) 100%);
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
        padding: 0.85rem 1.15rem;
        max-width: 100%;
        word-wrap: break-word;
        word-break: break-word;
        overflow-wrap: break-word;
        white-space: pre-wrap;
        line-height: 1.55;
        font-size: 0.95rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        animation: fadeIn 0.3s ease-out;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(8px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .message.received .message-bubble {
        background: #ffffff;
        color: #1e293b;
        border-radius: 20px 20px 20px 6px;
        border: 1px solid rgba(226, 232, 240, 0.9);
    }
    
    .message.sent .message-bubble {
        background: linear-gradient(135deg, #3A7BFF 0%, #6ECBF9 100%);
        color: white;
        border-radius: 20px 20px 6px 20px;
        box-shadow: 0 4px 14px rgba(58, 123, 255, 0.25);
    }
    
    .message-time {
        font-size: 0.7rem;
        color: #94a3b8;
        padding: 0 0.4rem;
        display: flex;
        align-items: center;
        gap: 0.3rem;
    }

    /* Reply Card - Kotak untuk produk/proposal */
    .reply-card {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem;
        border-radius: 14px;
        border: 1px solid rgba(0,0,0,0.08);
        margin-bottom: 0.4rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        max-width: 280px;
    }
    .reply-card.product {
        background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%);
        border-color: #a7f3d0;
    }
    .reply-card.proposal {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        border-color: #fcd34d;
    }
    .reply-thumb {
        width: 56px;
        height: 56px;
        border-radius: 10px;
        overflow: hidden;
        flex-shrink: 0;
        background: rgba(255,255,255,0.8);
        display: flex;
        align-items: center;
        justify-content: center;
        aspect-ratio: 1 / 1;
        box-shadow: 0 2px 6px rgba(0,0,0,0.08);
    }
    .reply-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .reply-thumb i {
        font-size: 1.25rem;
        color: #9ca3af;
    }
    .reply-card.product .reply-thumb i { color: #10b981; }
    .reply-card.proposal .reply-thumb i { color: #f59e0b; }
    
    .reply-meta {
        flex: 1;
        min-width: 0;
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }
    .reply-title {
        font-weight: 600;
        font-size: 0.85rem;
        color: #0f172a;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        line-height: 1.35;
    }
    .reply-subtitle {
        font-size: 0.78rem;
        color: #475569;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .reply-card.product .reply-subtitle { color: #047857; }
    .reply-card.proposal .reply-subtitle { color: #b45309; }
    
    .reply-badge {
        font-size: 0.68rem;
        font-weight: 700;
        color: #fff;
        padding: 0.25rem 0.6rem;
        border-radius: 20px;
        white-space: nowrap;
        align-self: flex-start;
    }
    .reply-card.product .reply-badge { background: linear-gradient(135deg, #10b981, #059669); }
    .reply-card.proposal .reply-badge { background: linear-gradient(135deg, #f59e0b, #d97706); }
    
    /* Input Area */
    .chat-input-area {
        padding: 1rem 1.5rem;
        border-top: 1px solid rgba(226, 232, 240, 0.8);
        background: #ffffff;
    }
    
    .input-wrapper {
        display: flex;
        align-items: flex-end;
        gap: 0.85rem;
        background: #f8fafc;
        border: 2px solid #e2e8f0;
        border-radius: 28px;
        padding: 0.35rem 0.5rem 0.35rem 0.75rem;
        transition: all 0.25s ease;
    }
    
    .input-wrapper:focus-within {
        border-color: #3A7BFF;
        box-shadow: 0 0 0 4px rgba(58, 123, 255, 0.12);
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
        color: #1A1F36;
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
        background: linear-gradient(135deg, #3A7BFF 0%, #6ECBF9 100%);
        color: white;
        border: none;
        border-radius: 50%;
        cursor: pointer;
        transition: all 0.25s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        box-shadow: 0 4px 16px rgba(58, 123, 255, 0.35);
    }

    .send-button i {
        font-size: 1.1rem;
        margin-left: 2px;
    }
    
    .send-button:hover {
        transform: scale(1.08) translateY(-2px);
        box-shadow: 0 6px 24px rgba(58, 123, 255, 0.45);
    }
    
    .send-button:active {
        transform: scale(0.95);
    }

    /* Empty State */
    .empty-chat {
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 3rem;
        color: #94a3b8;
        text-align: center;
    }
    .empty-chat i {
        font-size: 4rem;
        margin-bottom: 1rem;
        background: linear-gradient(135deg, #3A7BFF 0%, #6ECBF9 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        opacity: 0.5;
    }
    .empty-chat p {
        font-size: 1rem;
        line-height: 1.6;
    }

    /* Responsive */
    @media (max-width: 992px) {
        .chat-wrapper {
            height: calc(100vh - 160px);
        }
    }
    @media (max-width: 768px) {
        .chat-wrapper {
            height: calc(100vh - 140px);
            min-height: 450px;
            border-radius: 16px;
        }
        .chat-header {
            padding: 0.875rem 1.25rem;
        }
        .chat-avatar {
            width: 44px;
            height: 44px;
            font-size: 1.05rem;
        }
        .message {
            max-width: 85%;
        }
        .message-avatar {
            width: 32px;
            height: 32px;
            font-size: 0.8rem;
        }
        .chat-input-area {
            padding: 0.75rem 1rem;
        }
        .reply-card {
            max-width: 260px;
        }
        .reply-thumb {
            width: 50px;
            height: 50px;
        }
    }
    @media (max-width: 480px) {
        .message {
            max-width: 90%;
        }
        .message-avatar {
            display: none;
        }
        .back-btn {
            width: 36px;
            height: 36px;
        }
        .send-button {
            width: 44px;
            height: 44px;
        }
    }
</style>

<div class="chat-wrapper">
    <!-- Chat Header -->
    <div class="chat-header">
        <a href="{{ route('seller.messages.index') }}" class="back-btn" title="Kembali">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div class="chat-user-info">
            <div class="chat-avatar">
                {{ strtoupper(substr($otherUser->name, 0, 1)) }}
            </div>
            <div class="user-details">
                <h5>{{ $otherUser->name }}</h5>
                <div class="user-status">
                    <span class="online-dot"></span>
                    @if($shop)
                        <span class="shop-badge">
                            <i class="fas fa-store"></i> {{ $shop->shop_name }}
                        </span>
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
                <div class="context-title" style="color: #92400e;">
                    {{ $proposal->product->name ?? 'Layanan' }}
                </div>
                <div class="context-subtitle" style="color: #b45309;">
                    Harga: Rp{{ number_format($proposal->proposed_price ?? $proposal->offered_price ?? 0, 0, ',', '.') }}
                    · Deadline: {{ $proposal->proposed_deadline ? \Carbon\Carbon::parse($proposal->proposed_deadline)->format('d M Y') : '-' }}
                </div>
            </div>
            <span class="context-badge" style="background: #f59e0b; color: #fff;">
                Proposal #{{ $proposal->id }}
            </span>
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
                <div class="context-title" style="color: #1e40af;">
                    {{ $product->name }}
                </div>
                <div class="context-subtitle" style="color: #3b82f6;">
                    {{ $product->shop->shop_name ?? 'Toko' }} · Rp{{ number_format($product->price, 0, ',', '.') }}
                </div>
            </div>
        </div>
    @endif
    
    <!-- Messages -->
    <div class="chat-messages" id="messagesContainer">
        @forelse($messages as $message)
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
                        <div class="reply-card {{ $message->context_type }}">
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
                            <span class="reply-badge">
                                {{ $isProposalContext ? 'Proposal #' . $context->id : 'Produk' }}
                            </span>
                        </div>
                    @endif
                    <div class="message-bubble">{{ $message->message }}</div>
                    <div class="message-time">{{ $message->created_at->format('H:i') }}</div>
                </div>
            </div>
        @empty
            <div class="empty-chat">
                <i class="fas fa-comments"></i>
                <p>Belum ada pesan.<br>Mulai percakapan dengan mengirim pesan.</p>
            </div>
        @endforelse
    </div>
    
    <!-- Input Area -->
    <div class="chat-input-area">
        <form method="POST" action="{{ route('seller.messages.send', $otherUser->id) }}" id="messageForm">
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
            <div class="input-wrapper">
                <textarea class="message-input" name="message" placeholder="Tulis pesan..." required></textarea>
                <button type="submit" class="send-button" title="Kirim">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
const messagesContainer = document.getElementById('messagesContainer');

function scrollToBottom(smooth = true) {
    if (messagesContainer) {
        messagesContainer.scrollTo({
            top: messagesContainer.scrollHeight,
            behavior: smooth ? 'smooth' : 'instant'
        });
    }
}

// Scroll to bottom on load
scrollToBottom(false);

// Polling for new messages
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

// Form submission handler
document.getElementById('messageForm').addEventListener('submit', function(e) {
    const textarea = this.querySelector('textarea');
    if (textarea.value.trim() === '') {
        e.preventDefault();
        return;
    }
    setTimeout(() => { textarea.style.height = 'auto'; }, 100);
});

// Auto-resize textarea
const messageInput = document.querySelector('.message-input');
messageInput.addEventListener('input', function() {
    this.style.height = 'auto';
    this.style.height = Math.min(this.scrollHeight, 120) + 'px';
});

// Enter to send (Shift+Enter for new line)
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
