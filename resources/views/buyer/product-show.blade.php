@extends('layouts.app')

@section('title', $product->name . ' - PestiMart')

@section('content')
<style>
    .pdp-container { max-width: 1150px; margin: 2rem auto; padding: 0 1rem; }
    .pdp-grid { display: grid; grid-template-columns: minmax(0, 1.3fr) minmax(0, 1fr); gap: 2rem; }
    .pdp-card { background: #fff; border-radius: .9rem; box-shadow: 0 8px 30px rgba(20,24,58,.08); padding: 1.75rem; }
    .product-hero img { width: 100%; border-radius: .8rem; max-height: 420px; object-fit: cover; }
    .badge { display: inline-flex; align-items: center; gap: .25rem; padding: .35rem .8rem; border-radius: 999px; background: #eef3ff; color: #3651d4; font-weight: 600; font-size: .85rem; }
    .badge + .badge { margin-left: .35rem; }
    .price { font-size: 2rem; font-weight: 700; color: #2643d3; margin-top: 1rem; }
    .rating-meta { display: flex; flex-wrap: wrap; gap: .5rem; align-items: center; margin: 1rem 0; }
    .rating-score { font-weight: 700; color: #f59e0b; display: inline-flex; align-items: center; gap: .3rem; }
    .rating-score i { color: #f59e0b; }
    .purchase-card form { display: flex; flex-direction: column; gap: 1rem; }
    .form-label { font-weight: 600; font-size: .95rem; margin-bottom: .35rem; }
    .form-control, .form-select, textarea { width: 100%; border: 1px solid #d8def3; border-radius: .6rem; padding: .65rem .75rem; font-size: .95rem; }
    textarea { resize: vertical; min-height: 90px; }
    .btn-primary { background: linear-gradient(135deg, #4f46e5, #667eea); color: #fff; border: none; padding: .85rem 1.2rem; border-radius: .65rem; font-weight: 700; cursor: pointer; transition: transform .2s, box-shadow .2s; text-align: center; }
    .btn-primary:disabled { opacity: .6; cursor: not-allowed; }
    .variation { display:flex; justify-content:space-between; border:1px solid #e5e7f5; border-radius:.65rem; padding:.6rem .9rem; margin-bottom:.75rem; }
    .slot-option { display:flex; flex-direction:column; }
    .slot-option span { font-size:.9rem; color:#6b7280; }
    .stock-note { font-size:.9rem; color:#6b7280; }
    .reviews-list { margin-top: 1rem; }
    .review-item { border-bottom: 1px solid #eef1ff; padding: .85rem 0; }
    .review-rating { color: #f59e0b; font-weight: 600; font-size: .95rem; }
    .empty-state { padding: 1rem; border: 1px dashed #cdd4f9; border-radius: .65rem; text-align: center; color: #6b7280; }

    @media (max-width: 992px) {
        .pdp-grid { grid-template-columns: 1fr; }
    }
</style>

<div class="pdp-container">
    <div class="pdp-grid">
        <div>
            <div class="pdp-card product-hero">
                <img src="{{ $product->image ? asset('storage/'.$product->image) : asset('images/placeholder.png') }}" alt="{{ $product->name }}">
                <h2 class="mt-3 mb-2">{{ $product->name }}</h2>
                <div class="mb-2">
                    @if($product->category)
                        <span class="badge"><i class="fas fa-tag"></i>{{ ucfirst($product->category) }}</span>
                    @endif
                    <span class="badge"><i class="fas fa-layer-group"></i>{{ $product->product_type === 'service' ? 'Layanan' : 'Produk Fisik' }}</span>
                    <span class="badge"><i class="fas fa-store"></i>{{ $product->shop->shop_name ?? $product->shop->name ?? 'Toko' }}</span>
                </div>
                <div class="rating-meta">
                    @if(($reviewStats['count'] ?? 0) > 0)
                        <div class="rating-score">
                            <i class="fas fa-star"></i>{{ number_format($reviewStats['average'], 1) }}
                        </div>
                        <span class="text-muted">{{ $reviewStats['count'] }} ulasan dari pesanan selesai</span>
                    @else
                        <span class="text-muted">Belum ada ulasan dari pesanan selesai.</span>
                    @endif
                </div>
                <div class="price">Rp{{ number_format($displayPrice, 0, ',', '.') }}</div>
                @if(($product->product_type ?? 'food') === 'food')
                    <div class="stock-note">Stok tersedia: <strong>{{ $product->stock }}</strong> unit</div>
                @endif
                <p class="mt-3 text-muted">{!! nl2br(e($product->description)) !!}</p>
            </div>

            @if(($product->product_type ?? 'food') === 'food')
                <div class="pdp-card mt-3">
                    <h4>Profil Makanan</h4>
                    @php $fp = $product->food_profile ?? []; @endphp
                    <ul style="margin:0; padding-left:1rem;">
                        @if(isset($fp['calories']))<li>Kalori: {{ $fp['calories'] }}</li>@endif
                        @if(isset($fp['ingredients']))<li>Bahan: {{ is_array($fp['ingredients']) ? implode(', ', $fp['ingredients']) : $fp['ingredients'] }}</li>@endif
                        @if(isset($fp['spice_level']))<li>Kepedasan: {{ $fp['spice_level'] }}</li>@endif
                        @if(isset($fp['diet']))<li>Diet: {{ is_array($fp['diet']) ? implode(', ', $fp['diet']) : $fp['diet'] }}</li>@endif
                    </ul>
                </div>
            @else
                <div class="pdp-card mt-3">
                    <h4>Detail Layanan</h4>
                    @php $sp = $product->service_profile ?? []; @endphp
                    <ul style="margin:0; padding-left:1rem;">
                        @if(isset($sp['duration_minutes']))<li>Durasi: {{ $sp['duration_minutes'] }} menit</li>@endif
                        @if(isset($sp['location_type']))<li>Lokasi: {{ ucfirst($sp['location_type']) }}</li>@endif
                        @if(isset($sp['requirements']))<li>Syarat: {{ is_array($sp['requirements']) ? implode(', ', $sp['requirements']) : $sp['requirements'] }}</li>@endif
                    </ul>
                </div>
            @endif

            <div class="pdp-card mt-3">
                <h4>Variasi & Tambahan</h4>
                @forelse($product->variations as $variation)
                    <div class="variation">
                        <div>
                            <strong>{{ $variation->name }}</strong>
                            <div class="text-muted" style="font-size:.9rem;">Tipe: {{ ucfirst($variation->variation_type) }}</div>
                        </div>
                        <div>
                            @if((float)$variation->price_adjustment !== 0)
                                <span>+ Rp{{ number_format($variation->price_adjustment, 0, ',', '.') }}</span>
                            @else
                                <span>Termasuk</span>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="text-muted">Tidak ada variasi tambahan.</div>
                @endforelse
            </div>
        </div>

        <div>
            <div class="pdp-card purchase-card">
                <h4>Atur Pesanan</h4>
                <form method="POST" action="{{ route('buyer.cart.add', $product) }}">
                    @csrf

                    @if(($product->product_type ?? 'food') === 'food')
                        <div>
                            <label class="form-label" for="quantity">Jumlah</label>
                            <input id="quantity" class="form-control" type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" required>
                            <small class="stock-note">Maksimal sesuai stok tersedia.</small>
                            @error('quantity')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    @else
                        <input type="hidden" name="quantity" value="1">
                        
                        {{-- PROPOSAL-BASED ORDERING FOR SERVICES --}}
                        <div class="mb-3">
                            <label class="form-label" for="proposal_description">Deskripsi Pekerjaan <span class="text-danger">*</span></label>
                            <textarea id="proposal_description" name="proposal_description" class="form-control" rows="4" required placeholder="Jelaskan detail pekerjaan yang Anda butuhkan, termasuk spesifikasi dan hasil yang diharapkan...">{{ old('proposal_description') }}</textarea>
                            @error('proposal_description')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="proposed_deadline">Target Deadline <span class="text-danger">*</span></label>
                            <input type="date" id="proposed_deadline" name="proposed_deadline" class="form-control" required min="{{ date('Y-m-d', strtotime('+1 day')) }}" value="{{ old('proposed_deadline') }}">
                            <small class="text-muted">Minimal H+1 dari hari ini.</small>
                            @error('proposed_deadline')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="proposed_price">Harga yang Anda Tawarkan <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" id="proposed_price" name="proposed_price" class="form-control" required min="10000" step="1000" value="{{ old('proposed_price', $displayPrice) }}" placeholder="{{ number_format($displayPrice, 0) }}">
                            </div>
                            <small class="text-muted">Harga dasar seller: <strong>Rp{{ number_format($displayPrice, 0, ',', '.') }}</strong>. Anda bisa mengajukan harga sesuai kebutuhan.</small>
                            @error('proposed_price')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="notes">Catatan Tambahan (Opsional)</label>
                            <textarea id="notes" name="notes" class="form-control" rows="2" placeholder="Catatan atau preferensi khusus lainnya...">{{ old('notes') }}</textarea>
                        </div>

                        <div class="alert alert-info small mb-3" style="background:#e8f4fd; border:1px solid #bee5eb; border-radius:.5rem; padding:.75rem;">
                            <i class="fas fa-info-circle me-1"></i>
                            <strong>Cara kerja:</strong> Proposal Anda akan dikirim ke seller. Seller dapat menerima, menolak, atau bernegosiasi. Pekerjaan dimulai setelah kedua pihak sepakat.
                        </div>
                    @endif

                    <button class="btn-primary" type="submit">
                        <i class="fas fa-cart-plus me-1"></i>
                        {{ ($product->product_type ?? 'food') === 'service' ? 'Ajukan Proposal' : 'Tambah ke Keranjang' }}
                    </button>
                </form>
            </div>

            <div class="pdp-card mt-3">
                <h4>Ulasan Pesanan Selesai</h4>
                <div class="reviews-list">
                    @forelse($completedReviews as $review)
                        <div class="review-item">
                            <div style="font-weight:600;">{{ $review->user->name ?? 'Pengguna' }}</div>
                            <div class="review-rating">{{ $review->rating }} / 5</div>
                            <div class="text-muted" style="font-size:.85rem;">{{ optional($review->created_at)->format('d M Y') }}</div>
                            <p class="mt-1 mb-0">{{ $review->comment ?? $review->review }}</p>
                        </div>
                    @empty
                        <div class="empty-state">Belum ada ulasan dari pesanan yang sudah selesai.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection