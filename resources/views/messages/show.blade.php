@extends('layouts.app')

@section('title', 'Chat dengan ' . $otherUser->name . ' - PestiMart')

@section('content')
<style>
    .chat-page-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 1.5rem;
    }

    .chat-wrapper {
        background: var(--card-bg, #FFFFFF);
        border-radius: 1.25rem;
        box-shadow: 0 8px 30px rgba(0,0,0,0.1);
        overflow: hidden;
        display: flex;
        flex-direction: column;
        height: calc(100vh - 90px);
        min-height: 720px;
        margin-bottom: 2.5rem;
        border: 1px solid var(--neutral-gray, #ECEEF3);
    }
    
    .chat-header {
        background: linear-gradient(135deg, var(--primary, #3A7BFF) 0%, var(--secondary, #6ECBF9) 100%);
        color: white;
        padding: 1.25rem 1.75rem;
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
        gap: 0.75rem;
        margin-bottom: 0.35rem;
        max-width: 75%;
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
        box-shadow: 0 2px 8px rgba(0,0,0,0.12);
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
        padding: 0.85rem 1.15rem;
        max-width: 100%;
        word-wrap: break-word;
        word-break: break-word;
        overflow-wrap: break-word;
        white-space: pre-wrap;
        line-height: 1.5;
        font-size: 0.95rem;
        box-shadow: 0 2px 4px rgba(0,0,0,0.06);
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

    /* Large desktop - full navbar width */
    @media (min-width: 1400px) {
        .chat-page-container {
            max-width: 1400px;
        }
    }

    /* Tablet landscape */
    @media (max-width: 1200px) {
        .chat-page-container {
            max-width: 100%;
            padding: 0 1rem;
        }
    }
    
    @media (max-width: 768px) {
        .chat-page-container {
            padding: 0;
        }

        .chat-wrapper {
            height: calc(100vh - 100px);
            min-height: 520px;
            border-radius: 0;
            margin-bottom: 0;
            border: none;
        }

        .message {
            max-width: 85%;
        }

        .message-bubble {
            font-size: 0.92rem;
            padding: 0.75rem 1rem;
        }
        
        .chat-header {
            padding: 1rem 1.25rem;
        }
        
        .chat-avatar {
            width: 42px;
            height: 42px;
            font-size: 1rem;
        }

        .message-avatar {
            width: 30px;
            height: 30px;
            font-size: 0.75rem;
        }

        .reply-card {
            padding: 0.6rem;
            gap: 0.6rem;
        }

        .reply-thumb {
            width: 48px;
            height: 48px;
        }

        .reply-title {
            font-size: 0.82rem;
        }

        .reply-subtitle {
            font-size: 0.72rem;
        }
    }
    
    @media (max-width: 480px) {
        .chat-wrapper {
            height: calc(100vh - 85px);
        }

        .message {
            max-width: 90%;
        }

        .message-bubble {
            font-size: 0.88rem;
            padding: 0.7rem 0.9rem;
        }

        .message-avatar {
            display: none;
        }

        .reply-thumb {
            width: 44px;
            height: 44px;
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

    /* Reply Product Card Styles - compact 1:1 square */
    .reply-card {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.6rem 0.85rem;
        border-radius: 0.75rem;
        border: 1px solid rgba(0,0,0,0.08);
        margin-bottom: 0.5rem;
        background: linear-gradient(135deg, #fdf2f8 0%, #fce7f3 100%);
        box-shadow: 0 2px 6px rgba(0,0,0,0.04);
        max-width: 280px;
    }

    .reply-card.product {
        background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%);
        border-color: #7dd3fc;
    }

    .reply-card.proposal {
        background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%);
        border-color: #fcd34d;
    }

    .reply-thumb {
        width: 56px;
        height: 56px;
        border-radius: 0.5rem;
        overflow: hidden;
        flex-shrink: 0;
        background: rgba(255,255,255,0.6);
        display: flex;
        align-items: center;
        justify-content: center;
        aspect-ratio: 1 / 1;
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

    .reply-meta {
        flex: 1;
        min-width: 0;
        display: flex;
        flex-direction: column;
        gap: 0.2rem;
    }

    .reply-title {
        font-weight: 600;
        font-size: 0.85rem;
        color: #0f172a;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        line-height: 1.3;
    }

    .reply-subtitle {
        font-size: 0.75rem;
        color: #475569;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .reply-badge {
        font-size: 0.68rem;
        font-weight: 700;
        color: #fff;
        padding: 0.2rem 0.5rem;
        border-radius: 999px;
        background: rgba(15, 23, 42, 0.5);
        white-space: nowrap;
        align-self: flex-start;
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

<div class="chat-page-container" style="padding-top: 1.5rem; padding-bottom: 2rem;">
    <div class="back-header" style="margin-bottom: 1rem;">
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

        {{-- Context banner for proposal/product --}}
        @if(isset($proposal) && $proposal)
            <div style="background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); padding: 1rem 1.5rem; display: flex; align-items: center; gap: 1rem; border-bottom: 1px solid #fcd34d;">
                <div style="width: 56px; height: 56px; border-radius: 0.6rem; overflow: hidden; flex-shrink: 0; background: rgba(255,255,255,0.5); display: flex; align-items: center; justify-content: center;">
                    @if($proposal->product && $proposal->product->image)
                        <img src="{{ asset('storage/' . $proposal->product->image) }}" alt="{{ $proposal->product->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        <i class="fas fa-concierge-bell" style="font-size: 1.5rem; color: #f59e0b;"></i>
                    @endif
                </div>
                <div style="flex: 1; min-width: 0;">
                    <div style="font-weight: 600; color: #92400e; font-size: 0.95rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                        {{ $proposal->product->name ?? 'Layanan' }}
                    </div>
                    <div style="font-size: 0.85rem; color: #b45309;">
                        Harga: Rp{{ number_format($proposal->proposed_price ?? $proposal->offered_price ?? 0, 0, ',', '.') }}
                        &middot; Deadline: {{ $proposal->proposed_deadline ? \Carbon\Carbon::parse($proposal->proposed_deadline)->format('d M Y') : '-' }}
                    </div>
                </div>
                <span style="background: #f59e0b; color: #fff; padding: 0.3rem 0.75rem; border-radius: 999px; font-size: 0.78rem; font-weight: 600; white-space: nowrap;">
                    Proposal #{{ $proposal->id }}
                </span>
            </div>
        @elseif(isset($product) && $product)
            <div style="background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%); padding: 1rem 1.5rem; display: flex; align-items: center; gap: 1rem; border-bottom: 1px solid #7dd3fc;">
                <div style="width: 56px; height: 56px; border-radius: 0.6rem; overflow: hidden; flex-shrink: 0; background: rgba(255,255,255,0.5); display: flex; align-items: center; justify-content: center;">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        <i class="fas fa-box" style="font-size: 1.5rem; color: #3b82f6;"></i>
                    @endif
                </div>
                <div style="flex: 1; min-width: 0;">
                    <div style="font-weight: 600; color: #0369a1; font-size: 0.95rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                        {{ $product->name }}
                    </div>
                    <div style="font-size: 0.85rem; color: #0284c7;">
                        {{ $product->shop->shop_name ?? 'Toko' }} &middot; Rp{{ number_format($product->price, 0, ',', '.') }}
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
                            <div class="reply-card {{ $message->context_type }}">
                                <div class="reply-thumb">
                                    @if($thumb)
                                        <img src="{{ $thumb }}" alt="{{ $contextProduct->name ?? 'Layanan' }}">
                                    @else
                                        <i class="fas {{ $isProposalContext ? 'fa-concierge-bell' : 'fa-box' }} text-muted"></i>
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
