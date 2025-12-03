@extends('layouts.app')

@section('title', $product->name . ' - Layanan PestiMart')

@section('content')
<style>
    :root {
        --primary: #3A7BFF;
        --primary-dark: #2563eb;
        --primary-light: #6ECBF9;
        --gradient-primary: linear-gradient(135deg, #3A7BFF, #6ECBF9);
        --neutral-dark: #1A1F36;
        --neutral-gray: #ECEEF3;
        --accent: #FF8F3A;
        --service-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .pdp-container { 
        max-width: 1200px; 
        margin: 0 auto; 
        padding: 1.5rem 1rem; 
    }

    .breadcrumb-nav {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1.5rem;
        font-size: 0.9rem;
    }
    .breadcrumb-nav a {
        color: var(--primary);
        text-decoration: none;
    }
    .breadcrumb-nav a:hover {
        text-decoration: underline;
    }
    .breadcrumb-nav span {
        color: #6b7280;
    }

    .pdp-grid { 
        display: grid; 
        grid-template-columns: 1fr 1fr; 
        gap: 2rem; 
    }

    @media (max-width: 992px) {
        .pdp-grid { grid-template-columns: 1fr; }
    }

    .pdp-card { 
        background: #fff; 
        border-radius: 1rem; 
        box-shadow: 0 4px 20px rgba(0,0,0,0.06); 
        padding: 1.5rem;
        border: 1px solid var(--neutral-gray);
    }

    /* Service Gallery */
    .service-gallery {
        position: sticky;
        top: 1rem;
    }
    .service-main-image {
        width: 100%;
        aspect-ratio: 16/10;
        border-radius: 0.75rem;
        overflow: hidden;
        background: var(--service-gradient);
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }
    .service-main-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .service-main-image .no-image {
        font-size: 5rem;
        color: rgba(255,255,255,0.8);
    }
    .service-badge-overlay {
        position: absolute;
        top: 1rem;
        left: 1rem;
        background: rgba(0,0,0,0.6);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 999px;
        font-weight: 600;
        font-size: 0.85rem;
        display: flex;
        align-items: center;
        gap: 0.35rem;
    }

    /* Service Info */
    .service-badges {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-bottom: 1rem;
    }
    .badge-item {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.4rem 0.85rem;
        border-radius: 999px;
        font-weight: 600;
        font-size: 0.8rem;
    }
    .badge-service {
        background: var(--service-gradient);
        color: white;
    }
    .badge-category {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        color: #92400e;
    }
    .badge-duration {
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
        color: #065f46;
    }

    .service-title {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--neutral-dark);
        margin-bottom: 0.75rem;
        line-height: 1.3;
    }

    .service-rating-row {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1rem;
        flex-wrap: wrap;
    }
    .rating-stars {
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }
    .rating-stars i {
        color: var(--accent);
        font-size: 1rem;
    }
    .rating-value {
        font-weight: 700;
        color: var(--neutral-dark);
        margin-left: 0.35rem;
    }
    .rating-count {
        color: #6b7280;
        font-size: 0.9rem;
    }

    .service-price-box {
        background: linear-gradient(135deg, #eff6ff 0%, #e0e7ff 100%);
        border-radius: 0.75rem;
        padding: 1.25rem;
        margin-bottom: 1.25rem;
        border-left: 4px solid #667eea;
    }
    .price-label {
        font-size: 0.85rem;
        color: #6b7280;
        margin-bottom: 0.25rem;
    }
    .service-price {
        font-size: 2rem;
        font-weight: 800;
        color: #667eea;
    }
    .price-note {
        font-size: 0.85rem;
        color: #6b7280;
        margin-top: 0.35rem;
    }

    /* Service Profile */
    .service-profile-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 0.75rem;
        margin-bottom: 1.25rem;
    }
    .service-profile-item {
        background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
        border-radius: 0.75rem;
        padding: 1rem;
        text-align: center;
    }
    .service-profile-icon {
        font-size: 1.5rem;
        margin-bottom: 0.35rem;
    }
    .service-profile-label {
        font-size: 0.75rem;
        color: #6b7280;
        text-transform: uppercase;
    }
    .service-profile-value {
        font-weight: 700;
        color: var(--neutral-dark);
        font-size: 0.95rem;
    }

    /* Shop Row */
    .service-shop-row {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem;
        background: var(--neutral-gray);
        border-radius: 0.75rem;
        margin-bottom: 1.25rem;
    }
    .shop-logo {
        width: 50px;
        height: 50px;
        border-radius: 0.5rem;
        background: white;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        border: 1px solid #e5e7eb;
    }
    .shop-logo img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .shop-info {
        flex: 1;
    }
    .shop-name {
        font-weight: 600;
        color: var(--neutral-dark);
    }
    .shop-location {
        font-size: 0.85rem;
        color: #6b7280;
    }
    .shop-actions {
        display: flex;
        gap: 0.5rem;
    }
    .btn-shop-action {
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
        font-size: 0.85rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s ease;
    }
    .btn-shop-visit {
        background: white;
        border: 1px solid var(--primary);
        color: var(--primary);
    }
    .btn-shop-visit:hover {
        background: var(--primary);
        color: white;
    }
    .btn-shop-chat {
        background: var(--gradient-primary);
        color: white;
        border: none;
    }
    .btn-shop-chat:hover {
        filter: brightness(1.05);
        color: white;
    }

    /* Proposal Form */
    .proposal-section {
        background: linear-gradient(135deg, #faf5ff 0%, #ede9fe 100%);
        border-radius: 1rem;
        padding: 1.5rem;
        border: 2px solid #c4b5fd;
    }
    .proposal-title {
        font-size: 1.15rem;
        font-weight: 700;
        color: #5b21b6;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .form-group {
        margin-bottom: 1rem;
    }
    .form-label {
        display: block;
        font-weight: 600;
        color: var(--neutral-dark);
        margin-bottom: 0.5rem;
        font-size: 0.95rem;
    }
    .form-label .required {
        color: #dc2626;
    }
    .form-control, .form-select {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid #d8b4fe;
        border-radius: 0.5rem;
        font-size: 0.95rem;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }
    .form-control:focus, .form-select:focus {
        outline: none;
        border-color: #8b5cf6;
        box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.15);
    }
    textarea.form-control {
        resize: vertical;
        min-height: 100px;
    }
    .form-hint {
        font-size: 0.8rem;
        color: #6b7280;
        margin-top: 0.35rem;
    }
    .input-group {
        display: flex;
    }
    .input-group-text {
        padding: 0.75rem 1rem;
        background: #ede9fe;
        border: 1px solid #d8b4fe;
        border-right: none;
        border-radius: 0.5rem 0 0 0.5rem;
        font-weight: 600;
        color: #5b21b6;
    }
    .input-group .form-control {
        border-radius: 0 0.5rem 0.5rem 0;
    }

    .proposal-info-box {
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        border-radius: 0.75rem;
        padding: 1rem;
        margin-bottom: 1rem;
        border-left: 4px solid var(--primary);
    }
    .proposal-info-box i {
        color: var(--primary);
        margin-right: 0.5rem;
    }

    .btn-submit-proposal {
        width: 100%;
        padding: 1rem;
        background: var(--service-gradient);
        color: white;
        border: none;
        border-radius: 0.75rem;
        font-size: 1.1rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }
    .btn-submit-proposal:hover {
        filter: brightness(1.05);
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    }

    /* Description & Details */
    .detail-section {
        margin-top: 1.5rem;
    }
    .detail-section h4 {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--neutral-dark);
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid var(--neutral-gray);
    }
    .detail-content {
        color: #4b5563;
        line-height: 1.7;
    }

    /* Requirements List */
    .requirements-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .requirements-list li {
        display: flex;
        align-items: flex-start;
        gap: 0.5rem;
        padding: 0.5rem 0;
        border-bottom: 1px dashed var(--neutral-gray);
    }
    .requirements-list li:last-child {
        border-bottom: none;
    }
    .requirements-list li i {
        color: #8b5cf6;
        margin-top: 0.2rem;
    }

    /* Variations */
    .variation-list {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-bottom: 1rem;
    }
    .variation-item {
        padding: 0.6rem 1rem;
        border: 2px solid var(--neutral-gray);
        border-radius: 0.5rem;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.2s ease;
        background: white;
    }
    .variation-item:hover, .variation-item.active {
        border-color: #8b5cf6;
        background: linear-gradient(135deg, #faf5ff 0%, #ede9fe 100%);
    }
    .variation-price {
        font-size: 0.8rem;
        color: #059669;
        font-weight: 600;
    }

    /* Reviews */
    .reviews-summary {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        padding: 1rem;
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        border-radius: 0.75rem;
        margin-bottom: 1rem;
    }
    .reviews-summary-score {
        text-align: center;
    }
    .reviews-summary-score .big-score {
        font-size: 2.5rem;
        font-weight: 800;
        color: var(--neutral-dark);
        line-height: 1;
    }
    .reviews-summary-score .stars {
        color: var(--accent);
        margin-top: 0.25rem;
    }
    .reviews-list {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }
    .review-item {
        padding: 1rem;
        background: var(--neutral-gray);
        border-radius: 0.75rem;
    }
    .review-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.5rem;
    }
    .review-user {
        font-weight: 600;
        color: var(--neutral-dark);
    }
    .review-rating {
        color: var(--accent);
        font-weight: 600;
    }
    .review-date {
        font-size: 0.8rem;
        color: #6b7280;
    }
    .review-content {
        color: #4b5563;
        line-height: 1.6;
    }
    .empty-reviews {
        text-align: center;
        padding: 2rem;
        color: #6b7280;
        background: var(--neutral-gray);
        border-radius: 0.75rem;
    }

    @media (max-width: 768px) {
        .service-title { font-size: 1.4rem; }
        .service-price { font-size: 1.6rem; }
        .service-shop-row { flex-direction: column; text-align: center; }
        .shop-actions { width: 100%; }
        .btn-shop-action { flex: 1; justify-content: center; text-align: center; }
    }
</style>

<div class="pdp-container">
    <!-- Breadcrumb -->
    <nav class="breadcrumb-nav">
        <a href="{{ route('buyer.home') }}"><i class="fas fa-home"></i></a>
        <span>/</span>
        <a href="{{ route('buyer.home', ['tab' => 'services']) }}">Layanan</a>
        <span>/</span>
        @if($product->category)
            <a href="{{ route('buyer.search', ['category' => $product->category, 'tab' => 'services']) }}">{{ ucfirst($product->category) }}</a>
            <span>/</span>
        @endif
        <span>{{ Str::limit($product->name, 30) }}</span>
    </nav>

    <div class="pdp-grid">
        <!-- Left Column: Gallery & Description -->
        <div class="service-gallery">
            <div class="pdp-card">
                <div class="service-main-image">
                    @if($product->image)
                        <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}">
                    @else
                        <i class="fas fa-concierge-bell no-image"></i>
                    @endif
                    <div class="service-badge-overlay">
                        <i class="fas fa-concierge-bell"></i> Layanan
                    </div>
                </div>
            </div>

            <!-- Description Section (Desktop) -->
            <div class="pdp-card detail-section d-none d-lg-block">
                <h4><i class="fas fa-info-circle me-2"></i>Deskripsi Layanan</h4>
                <div class="detail-content">
                    {!! nl2br(e($product->description)) !!}
                </div>
            </div>

            <!-- Service Requirements -->
            @php $sp = $product->service_profile ?? []; @endphp
            @if(!empty($sp['requirements']))
            <div class="pdp-card detail-section d-none d-lg-block">
                <h4><i class="fas fa-clipboard-list me-2"></i>Persyaratan Layanan</h4>
                <ul class="requirements-list">
                    @if(is_array($sp['requirements']))
                        @foreach($sp['requirements'] as $req)
                        <li><i class="fas fa-check-circle"></i> {{ $req }}</li>
                        @endforeach
                    @else
                        <li><i class="fas fa-check-circle"></i> {{ $sp['requirements'] }}</li>
                    @endif
                </ul>
            </div>
            @endif

            <!-- Reviews Section (Desktop) -->
            <div class="pdp-card detail-section d-none d-lg-block">
                <h4><i class="fas fa-star me-2"></i>Ulasan Layanan</h4>
                
                @if(($reviewStats['count'] ?? 0) > 0)
                <div class="reviews-summary">
                    <div class="reviews-summary-score">
                        <div class="big-score">{{ number_format($reviewStats['average'], 1) }}</div>
                        <div class="stars">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= floor($reviewStats['average']))
                                    <i class="fas fa-star"></i>
                                @elseif($i - 0.5 <= $reviewStats['average'])
                                    <i class="fas fa-star-half-alt"></i>
                                @else
                                    <i class="far fa-star"></i>
                                @endif
                            @endfor
                        </div>
                    </div>
                    <div>
                        <div style="font-weight:600;">{{ $reviewStats['count'] }} Ulasan</div>
                        <div style="font-size:0.85rem;color:#6b7280;">Dari pembeli yang puas</div>
                    </div>
                </div>
                @endif

                <div class="reviews-list">
                    @forelse($completedReviews as $review)
                    <div class="review-item">
                        <div class="review-header">
                            <div>
                                <span class="review-user">{{ $review->user->name ?? 'Pengguna' }}</span>
                                <span class="review-date ms-2">{{ optional($review->created_at)->format('d M Y') }}</span>
                            </div>
                            <div class="review-rating">
                                <i class="fas fa-star"></i> {{ $review->rating }}/5
                            </div>
                        </div>
                        @if($review->title)
                        <div style="font-weight:600;margin-bottom:0.25rem;">{{ $review->title }}</div>
                        @endif
                        <div class="review-content">{{ $review->comment ?? $review->review }}</div>
                    </div>
                    @empty
                    <div class="empty-reviews">
                        <i class="fas fa-comment-slash" style="font-size:2rem;margin-bottom:0.5rem;display:block;"></i>
                        Belum ada ulasan untuk layanan ini.
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Right Column: Service Info & Proposal Form -->
        <div>
            <div class="pdp-card">
                <!-- Badges -->
                <div class="service-badges">
                    <span class="badge-item badge-service">
                        <i class="fas fa-concierge-bell"></i> Layanan
                    </span>
                    @if($product->category)
                    <span class="badge-item badge-category">
                        <i class="fas fa-tag"></i> {{ ucfirst($product->category) }}
                    </span>
                    @endif
                    @if(isset($sp['duration_minutes']))
                    <span class="badge-item badge-duration">
                        <i class="fas fa-clock"></i> {{ $sp['duration_minutes'] }} menit
                    </span>
                    @endif
                </div>

                <!-- Title -->
                <h1 class="service-title">{{ $product->name }}</h1>

                <!-- Rating Row -->
                <div class="service-rating-row">
                    <div class="rating-stars">
                        @if(($reviewStats['count'] ?? 0) > 0)
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= floor($reviewStats['average']))
                                    <i class="fas fa-star"></i>
                                @elseif($i - 0.5 <= $reviewStats['average'])
                                    <i class="fas fa-star-half-alt"></i>
                                @else
                                    <i class="far fa-star"></i>
                                @endif
                            @endfor
                            <span class="rating-value">{{ number_format($reviewStats['average'], 1) }}</span>
                        @else
                            <i class="far fa-star"></i>
                            <i class="far fa-star"></i>
                            <i class="far fa-star"></i>
                            <i class="far fa-star"></i>
                            <i class="far fa-star"></i>
                            <span class="rating-value">-</span>
                        @endif
                    </div>
                    <span class="rating-count">({{ $reviewStats['count'] ?? 0 }} ulasan)</span>
                </div>

                <!-- Price Box -->
                <div class="service-price-box">
                    <div class="price-label">Mulai dari</div>
                    <div class="service-price">Rp{{ number_format($displayPrice, 0, ',', '.') }}</div>
                    <div class="price-note">*Harga final ditentukan setelah diskusi dengan seller</div>
                </div>

                <!-- Service Profile Quick Info -->
                @if(!empty($sp))
                <div class="service-profile-grid">
                    @if(isset($sp['duration_minutes']))
                    <div class="service-profile-item">
                        <div class="service-profile-icon">⏱️</div>
                        <div class="service-profile-label">Durasi</div>
                        <div class="service-profile-value">{{ $sp['duration_minutes'] }} menit</div>
                    </div>
                    @endif
                    @if(isset($sp['location_type']))
                    <div class="service-profile-item">
                        <div class="service-profile-icon">📍</div>
                        <div class="service-profile-label">Lokasi</div>
                        <div class="service-profile-value">{{ ucfirst($sp['location_type']) }}</div>
                    </div>
                    @endif
                </div>
                @endif

                <!-- Shop Row -->
                <div class="service-shop-row">
                    <div class="shop-logo">
                        @if($product->shop->logo)
                            <img src="{{ asset('storage/'.$product->shop->logo) }}" alt="{{ $product->shop->shop_name }}">
                        @else
                            <i class="fas fa-store text-muted"></i>
                        @endif
                    </div>
                    <div class="shop-info">
                        <div class="shop-name">{{ $product->shop->shop_name ?? $product->shop->name ?? 'Penyedia Layanan' }}</div>
                        <div class="shop-location">
                            <i class="fas fa-map-marker-alt me-1"></i>{{ $product->shop->address ?? 'Lokasi tidak tersedia' }}
                        </div>
                    </div>
                    <div class="shop-actions">
                        <a href="{{ route('buyer.shop.visit', $product->shop->id) }}" class="btn-shop-action btn-shop-visit">
                            <i class="fas fa-store me-1"></i>Kunjungi
                        </a>
                        <a href="{{ route('messages.show', ['user' => $product->shop->user_id, 'shop_id' => $product->shop->id, 'product_id' => $product->id]) }}" class="btn-shop-action btn-shop-chat">
                            <i class="fas fa-comments me-1"></i>Chat
                        </a>
                    </div>
                </div>

                <!-- Variations (if any) -->
                @if($product->variations->count() > 0)
                <div class="mb-3">
                    <div class="section-title" style="font-weight:700;margin-bottom:0.75rem;">Pilih Paket</div>
                    <div class="variation-list">
                        @foreach($product->variations as $variation)
                        <div class="variation-item {{ $variation->is_default ? 'active' : '' }}" data-variation-id="{{ $variation->id }}" data-price="{{ $product->price + $variation->price_adjustment }}">
                            <div style="font-weight:600;">{{ $variation->name }}</div>
                            <div class="variation-price">
                                Rp{{ number_format($product->price + $variation->price_adjustment, 0, ',', '.') }}
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <!-- Proposal Form -->
            <div class="proposal-section mt-3">
                <div class="proposal-title">
                    <i class="fas fa-file-signature"></i>
                    Ajukan Proposal Layanan
                </div>

                <div class="proposal-info-box">
                    <i class="fas fa-info-circle"></i>
                    <strong>Cara kerja:</strong> Jelaskan kebutuhan Anda, tentukan deadline dan harga yang Anda tawarkan. Seller akan mereview dan dapat menerima, menolak, atau bernegosiasi.
                </div>

                <form method="POST" action="{{ route('buyer.cart.add', $product) }}" id="proposal-form">
                    @csrf
                    <input type="hidden" name="quantity" value="1">
                    <input type="hidden" name="variation_id" id="variation-input" value="{{ $defaultVariation->id ?? '' }}">

                    <div class="form-group">
                        <label class="form-label">
                            Deskripsi Pekerjaan <span class="required">*</span>
                        </label>
                        <textarea name="proposal_description" class="form-control" rows="4" required placeholder="Jelaskan detail pekerjaan yang Anda butuhkan, termasuk spesifikasi dan hasil yang diharapkan...">{{ old('proposal_description') }}</textarea>
                        @error('proposal_description')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            Target Deadline <span class="required">*</span>
                        </label>
                        <input type="date" name="proposed_deadline" class="form-control" required min="{{ date('Y-m-d', strtotime('+1 day')) }}" value="{{ old('proposed_deadline') }}">
                        <div class="form-hint">Minimal H+1 dari hari ini</div>
                        @error('proposed_deadline')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            Harga yang Anda Tawarkan <span class="required">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" name="proposed_price" class="form-control" required min="10000" step="1000" value="{{ old('proposed_price', $displayPrice) }}" placeholder="{{ number_format($displayPrice, 0) }}">
                        </div>
                        <div class="form-hint">Harga dasar: <strong>Rp{{ number_format($displayPrice, 0, ',', '.') }}</strong>. Anda dapat mengajukan harga sesuai kebutuhan.</div>
                        @error('proposed_price')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            Catatan Tambahan (Opsional)
                        </label>
                        <textarea name="notes" class="form-control" rows="2" placeholder="Catatan atau preferensi khusus lainnya...">{{ old('notes') }}</textarea>
                    </div>

                    <button type="submit" class="btn-submit-proposal">
                        <i class="fas fa-paper-plane"></i>
                        Kirim Proposal
                    </button>
                </form>
            </div>

            <!-- Description Section (Mobile) -->
            <div class="pdp-card detail-section d-lg-none">
                <h4><i class="fas fa-info-circle me-2"></i>Deskripsi Layanan</h4>
                <div class="detail-content">
                    {!! nl2br(e($product->description)) !!}
                </div>
            </div>

            <!-- Reviews Section (Mobile) -->
            <div class="pdp-card detail-section d-lg-none">
                <h4><i class="fas fa-star me-2"></i>Ulasan Layanan</h4>
                <div class="reviews-list">
                    @forelse($completedReviews as $review)
                    <div class="review-item">
                        <div class="review-header">
                            <span class="review-user">{{ $review->user->name ?? 'Pengguna' }}</span>
                            <span class="review-rating"><i class="fas fa-star"></i> {{ $review->rating }}/5</span>
                        </div>
                        <div class="review-content">{{ $review->comment ?? $review->review }}</div>
                    </div>
                    @empty
                    <div class="empty-reviews">Belum ada ulasan untuk layanan ini.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.querySelectorAll('.variation-item').forEach(item => {
    item.addEventListener('click', function() {
        document.querySelectorAll('.variation-item').forEach(v => v.classList.remove('active'));
        this.classList.add('active');
        document.getElementById('variation-input').value = this.dataset.variationId;
        
        // Update price display if needed
        const newPrice = this.dataset.price;
        // Could update price display here
    });
});
</script>
@endsection
