@extends('layouts.app')

@section('title', $product->name . ' - PestiMart')

@section('content')
<style>
    .pdp-container { max-width: 1100px; margin: 2rem auto; }
    .pdp-grid { display: grid; grid-template-columns: 1.2fr 1fr; gap: 2rem; }
    .pdp-card { background: #fff; border-radius: .75rem; box-shadow: 0 2px 8px rgba(0,0,0,.08); padding: 1.25rem; }
    .price { font-size: 1.8rem; font-weight: 700; color: #667eea; }
    .badge { display: inline-block; padding: .35rem .6rem; border-radius: 999px; background: #eef2ff; color: #4f46e5; font-weight: 600; }
    .slot { display:flex; justify-content:space-between; padding:.6rem .8rem; border:1px solid #eee; border-radius:.5rem; margin-bottom:.5rem; }
    .variation { display:flex; align-items:center; justify-content:space-between; padding:.5rem .75rem; border:1px solid #eee; border-radius:.5rem; margin-bottom:.5rem; }
    .btn-primary { background:#667eea; color:#fff; border:none; padding:.7rem 1rem; border-radius:.5rem; font-weight:700; cursor:pointer; }
</style>
<div class="pdp-container">
    <div class="pdp-grid">
        <div>
            <div class="pdp-card">
                <img src="{{ $product->image ? asset('storage/'.$product->image) : asset('images/placeholder.png') }}" alt="{{ $product->name }}" style="width:100%; border-radius:.5rem; object-fit:cover; max-height:380px;">
                <h2 class="mt-3">{{ $product->name }}</h2>
                <div class="mb-2">
                    <span class="badge">{{ ucfirst($product->category) }}</span>
                    <span class="badge">{{ ucfirst($product->product_type ?? 'food') }}</span>
                    <span class="badge">Toko: {{ $product->shop->name }}</span>
                </div>
                <div class="price">Rp{{ number_format($displayPrice, 0, ',', '.') }}</div>
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
        </div>

        <div>
            <div class="pdp-card">
                <h4>Pilihan & Variasi</h4>
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

                <div class="mt-3">
                    <form method="POST" action="{{ route('buyer.cart.add', $product) }}">
                        @csrf
                        <input type="hidden" name="quantity" value="1">
                        <button class="btn-primary" type="submit">
                            <i class="fas fa-cart-plus me-1"></i>Tambah ke Keranjang
                        </button>
                    </form>
                </div>
            </div>

            @if(($product->product_type ?? 'food') === 'service' && ($product->requires_booking ?? false))
            <div class="pdp-card mt-3">
                <h4>Jadwal Tersedia</h4>
                @forelse($product->serviceSlots as $slot)
                    <div class="slot">
                        <div>
                            <div style="font-weight:600;">{{ $slot->slot_date ? \Carbon\Carbon::parse($slot->slot_date)->format('d M Y') : ucfirst($slot->day_of_week) }}</div>
                            <div class="text-muted">{{ substr($slot->start_time,0,5) }} - {{ substr($slot->end_time,0,5) }}</div>
                        </div>
                        <div>
                            <span class="badge">Sisa: {{ $slot->availableCapacity() }}</span>
                        </div>
                    </div>
                @empty
                    <div class="text-muted">Belum ada slot aktif.</div>
                @endforelse
            </div>
            @endif

            <div class="pdp-card mt-3">
                <h4>Ulasan</h4>
                @forelse($product->reviews as $review)
                    <div style="border-bottom:1px solid #eee; padding:.5rem 0;">
                        <div style="font-weight:600;">{{ $review->user->name ?? 'Pengguna' }}</div>
                        <div class="text-muted" style="font-size:.9rem;">{{ $review->rating }} / 5</div>
                        <div>{{ $review->comment }}</div>
                    </div>
                @empty
                    <div class="text-muted">Belum ada ulasan.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection