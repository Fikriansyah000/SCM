@extends('layouts.app')

@section('title', 'Edit ' . ($product->product_type === 'service' ? 'Layanan' : 'Produk') . ' - PestiMart')

@section('content')
<style>
    .product-form-container {
        background: white;
        border-radius: 0.75rem;
        padding: 2rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    
    .form-section {
        margin-bottom: 2rem;
    }
    
    .form-section-title {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid #f0f0f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .form-group {
        margin-bottom: 1.5rem;
    }
    
    .form-label {
        font-weight: 500;
        margin-bottom: 0.5rem;
        display: block;
        color: #333;
    }
    
    .form-control {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #ddd;
        border-radius: 0.5rem;
        font-family: inherit;
    }
    
    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }
    
    textarea.form-control {
        resize: vertical;
        min-height: 120px;
    }
    
    .type-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-radius: 999px;
        font-weight: 600;
        font-size: 0.9rem;
    }
    
    .type-badge.product {
        background: #e8f5e9;
        color: #2e7d32;
    }
    
    .type-badge.service {
        background: #e3f2fd;
        color: #1565c0;
    }
    
    .service-fields {
        background: #f8f9ff;
        padding: 1.5rem;
        border-radius: 0.75rem;
        margin-bottom: 1.5rem;
    }
    
    .physical-fields {
        background: #f8fff8;
        padding: 1.5rem;
        border-radius: 0.75rem;
        margin-bottom: 1.5rem;
    }
    
    .upload-area {
        border: 2px dashed #ddd;
        border-radius: 0.75rem;
        padding: 2rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        background: #f8f9fa;
    }
    
    .upload-area:hover {
        border-color: #667eea;
        background: #f0f4ff;
    }
    
    .upload-area i {
        font-size: 2rem;
        color: #667eea;
        margin-bottom: 1rem;
    }
    
    .image-preview {
        margin-top: 1rem;
        max-width: 300px;
    }
    
    .image-preview img {
        width: 100%;
        border-radius: 0.5rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    
    .form-actions {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
        flex-wrap: wrap;
    }
    
    .btn-submit {
        padding: 0.75rem 2rem;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        border-radius: 0.5rem;
        font-weight: 600;
        cursor: pointer;
        transition: transform 0.3s ease;
    }
    
    .btn-submit:hover {
        transform: translateY(-2px);
        color: white;
    }
    
    .btn-cancel {
        padding: 0.75rem 2rem;
        background: white;
        color: #666;
        border: 2px solid #ddd;
        border-radius: 0.5rem;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
    }
    
    .btn-cancel:hover {
        background: #f5f5f5;
        color: #333;
    }

    .form-check {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .form-check input[type="checkbox"] {
        width: 1.25rem;
        height: 1.25rem;
    }

    /* Slot Management */
    .slots-container {
        background: #fafbff;
        border-radius: 0.75rem;
        padding: 1.5rem;
        margin-top: 1rem;
    }

    .slot-card {
        background: white;
        border: 1px solid #e0e4f0;
        border-radius: 0.65rem;
        padding: 1rem;
        margin-bottom: 0.75rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .slot-card.inactive {
        opacity: 0.6;
        background: #f5f5f5;
    }

    .slot-info {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .slot-date {
        font-weight: 600;
        color: #333;
    }

    .slot-time {
        color: #666;
        font-size: 0.9rem;
    }

    .slot-capacity {
        display: flex;
        gap: 0.5rem;
        align-items: center;
    }

    .slot-capacity .badge {
        padding: 0.35rem 0.75rem;
        border-radius: 999px;
        font-size: 0.85rem;
        font-weight: 600;
    }

    .slot-capacity .badge.available {
        background: #e8f5e9;
        color: #2e7d32;
    }

    .slot-capacity .badge.full {
        background: #ffebee;
        color: #c62828;
    }

    .slot-actions {
        display: flex;
        gap: 0.5rem;
    }

    .slot-actions button, .slot-actions form button {
        padding: 0.4rem 0.75rem;
        border-radius: 0.4rem;
        font-size: 0.85rem;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-toggle {
        background: #fff3e0;
        color: #e65100;
    }

    .btn-toggle:hover {
        background: #ffe0b2;
    }

    .btn-delete {
        background: #ffebee;
        color: #c62828;
    }

    .btn-delete:hover {
        background: #ffcdd2;
    }

    .add-slot-form {
        background: white;
        border: 2px dashed #667eea;
        border-radius: 0.75rem;
        padding: 1.5rem;
        margin-top: 1rem;
    }

    .add-slot-form .row {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .add-slot-form .col {
        flex: 1;
        min-width: 140px;
    }

    .btn-add-slot {
        background: #667eea;
        color: white;
        border: none;
        padding: 0.6rem 1.25rem;
        border-radius: 0.5rem;
        font-weight: 600;
        cursor: pointer;
        margin-top: 1rem;
    }

    .btn-add-slot:hover {
        background: #5a6fd6;
    }

    .empty-slots {
        text-align: center;
        padding: 2rem;
        color: #888;
    }

    .empty-slots i {
        font-size: 2.5rem;
        margin-bottom: 1rem;
        color: #ccc;
    }
</style>

<div class="container my-4">
    <div class="product-form-container">
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
            <h2 class="mb-0">
                <i class="fas fa-edit me-2"></i>Edit {{ $product->product_type === 'service' ? 'Layanan' : 'Produk' }}
            </h2>
            <span class="type-badge {{ $product->product_type === 'service' ? 'service' : 'product' }}">
                <i class="fas {{ $product->product_type === 'service' ? 'fa-concierge-bell' : 'fa-box' }}"></i>
                {{ $product->product_type === 'service' ? 'Layanan' : 'Produk Fisik' }}
            </span>
        </div>
        
        <form method="POST" action="{{ route('seller.products.update', $product->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" name="product_type" value="{{ $product->product_type }}">
            
            <!-- Basic Information -->
            <div class="form-section">
                <div class="form-section-title">
                    <span><i class="fas fa-info-circle me-2"></i>Informasi Dasar</span>
                </div>
                
                <div class="form-group">
                    <label for="name" class="form-label">Nama {{ $product->product_type === 'service' ? 'Layanan' : 'Produk' }}</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                           id="name" name="name" value="{{ old('name', $product->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="category" class="form-label">Kategori</label>
                    <select class="form-control @error('category') is-invalid @enderror" id="category" name="category" required>
                        <option value="">-- Pilih Kategori --</option>
                        <option value="Makanan & Minuman" {{ old('category', $product->category) == 'Makanan & Minuman' ? 'selected' : '' }}>Makanan & Minuman</option>
                        <option value="Jasa & Layanan" {{ old('category', $product->category) == 'Jasa & Layanan' ? 'selected' : '' }}>Jasa & Layanan</option>
                        <option value="Buku & Alat Tulis" {{ old('category', $product->category) == 'Buku & Alat Tulis' ? 'selected' : '' }}>Buku & Alat Tulis</option>
                        <option value="Elektronik" {{ old('category', $product->category) == 'Elektronik' ? 'selected' : '' }}>Elektronik</option>
                        <option value="Lainnya" {{ old('category', $product->category) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                    @error('category')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="description" class="form-label">Deskripsi</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" 
                              id="description" name="description" required>{{ old('description', $product->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            @if(($product->product_type ?? 'food') === 'food')
            <!-- Price & Stock (Physical Products) -->
            <div class="physical-fields">
                <div class="form-section-title" style="border:none; padding:0; margin-bottom:1rem;">
                    <span><i class="fas fa-money-bill-wave me-2"></i>Harga & Stok</span>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="price" class="form-label">Harga (Rp)</label>
                            <input type="number" class="form-control @error('price') is-invalid @enderror" 
                                   id="price" name="price" value="{{ old('price', $product->price) }}" required step="1000" min="0">
                            @error('price')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="stock" class="form-label">Stok</label>
                            <input type="number" class="form-control @error('stock') is-invalid @enderror" 
                                   id="stock" name="stock" value="{{ old('stock', $product->stock) }}" required min="0">
                            @error('stock')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            @else
            <!-- Service Fields -->
            <div class="service-fields">
                <div class="form-section-title" style="border:none; padding:0; margin-bottom:1rem;">
                    <span><i class="fas fa-concierge-bell me-2"></i>Detail Layanan</span>
                </div>
                
                @php $sp = $product->service_profile ?? []; @endphp
                
                <div class="form-group">
                    <label for="price" class="form-label">Harga Layanan (Rp)</label>
                    <input type="number" class="form-control @error('price') is-invalid @enderror" 
                           id="price" name="price" value="{{ old('price', $product->price) }}" required step="1000" min="0">
                    @error('price')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="duration_minutes" class="form-label">Durasi (menit)</label>
                            <input type="number" class="form-control @error('duration_minutes') is-invalid @enderror" 
                                   id="duration_minutes" name="duration_minutes" 
                                   value="{{ old('duration_minutes', $sp['duration_minutes'] ?? '') }}" min="1">
                            @error('duration_minutes')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="location_type" class="form-label">Lokasi Layanan</label>
                            <select class="form-control @error('location_type') is-invalid @enderror" id="location_type" name="location_type">
                                <option value="flexible" {{ old('location_type', $sp['location_type'] ?? '') == 'flexible' ? 'selected' : '' }}>Fleksibel</option>
                                <option value="online" {{ old('location_type', $sp['location_type'] ?? '') == 'online' ? 'selected' : '' }}>Online</option>
                                <option value="onsite" {{ old('location_type', $sp['location_type'] ?? '') == 'onsite' ? 'selected' : '' }}>Di Tempat</option>
                            </select>
                            @error('location_type')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="requirements" class="form-label">Persyaratan / Catatan</label>
                    <textarea class="form-control @error('requirements') is-invalid @enderror" 
                              id="requirements" name="requirements" rows="2">{{ old('requirements', $sp['requirements'] ?? '') }}</textarea>
                    @error('requirements')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <div class="form-check">
                        <input type="checkbox" id="requires_booking" name="requires_booking" value="1" 
                               {{ old('requires_booking', $product->requires_booking) ? 'checked' : '' }}>
                        <label for="requires_booking">Memerlukan pemilihan jadwal/slot</label>
                    </div>
                </div>
            </div>
            @endif
            
            <!-- Product Image -->
            <div class="form-section">
                <div class="form-section-title">
                    <span><i class="fas fa-image me-2"></i>Foto</span>
                </div>
                
                @if($product->image)
                <div class="image-preview mb-3">
                    <p class="small text-muted mb-2">Foto Saat Ini:</p>
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                </div>
                @endif
                
                <div class="form-group">
                    <label class="form-label">Ganti Foto</label>
                    <div class="upload-area" onclick="document.getElementById('image').click()">
                        <i class="fas fa-image"></i>
                        <p>Klik untuk upload foto baru</p>
                        <small class="text-muted">Max 2MB, Format: JPG, PNG, GIF, WEBP</small>
                    </div>
                    <input type="file" id="image" name="image" accept="image/*" style="display: none;">
                    @error('image')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <!-- Actions -->
            <div class="form-actions">
                <button type="submit" class="btn-submit">
                    <i class="fas fa-save me-2"></i>Simpan Perubahan
                </button>
                <a href="{{ route('seller.products.index') }}" class="btn-cancel">
                    <i class="fas fa-times me-2"></i>Batal
                </a>
            </div>
        </form>
        
        @if(($product->product_type ?? 'food') === 'service')
        <!-- Service Slots Management -->
        <div class="form-section mt-5">
            <div class="form-section-title">
                <span><i class="fas fa-calendar-alt me-2"></i>Jadwal / Slot Layanan</span>
            </div>
            
            <div class="slots-container">
                @forelse($product->serviceSlots ?? [] as $slot)
                    <div class="slot-card {{ $slot->is_active ? '' : 'inactive' }}">
                        <div class="slot-info">
                            <div class="slot-date">
                                @if($slot->slot_date)
                                    {{ \Carbon\Carbon::parse($slot->slot_date)->translatedFormat('l, d M Y') }}
                                @elseif($slot->day_of_week)
                                    Setiap {{ ucfirst($slot->day_of_week) }}
                                    @if($slot->is_recurring)
                                        <span class="badge bg-info text-white" style="font-size:.75rem;">Berulang</span>
                                    @endif
                                @else
                                    Tanggal tidak ditentukan
                                @endif
                            </div>
                            <div class="slot-time">
                                <i class="fas fa-clock me-1"></i>{{ substr($slot->start_time, 0, 5) }} - {{ substr($slot->end_time, 0, 5) }}
                            </div>
                        </div>
                        
                        <div class="slot-capacity">
                            <span class="badge {{ $slot->availableCapacity() > 0 ? 'available' : 'full' }}">
                                Sisa: {{ $slot->availableCapacity() }} / {{ $slot->capacity }}
                            </span>
                            @if(!$slot->is_active)
                                <span class="badge" style="background:#eee;color:#666;">Nonaktif</span>
                            @endif
                        </div>
                        
                        <div class="slot-actions">
                            <form method="POST" action="{{ route('seller.products.slots.toggle', [$product->id, $slot->id]) }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn-toggle" title="{{ $slot->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                    <i class="fas {{ $slot->is_active ? 'fa-pause' : 'fa-play' }}"></i>
                                </button>
                            </form>
                            @if($slot->booked_count == 0)
                            <form method="POST" action="{{ route('seller.products.slots.destroy', [$product->id, $slot->id]) }}" class="d-inline" onsubmit="return confirm('Hapus slot ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="empty-slots">
                        <i class="fas fa-calendar-times"></i>
                        <p>Belum ada jadwal/slot layanan.<br>Tambahkan jadwal di bawah ini.</p>
                    </div>
                @endforelse
                
                <!-- Add New Slot Form -->
                <div class="add-slot-form">
                    <h6 class="mb-3"><i class="fas fa-plus-circle me-2"></i>Tambah Jadwal Baru</h6>
                    <form method="POST" action="{{ route('seller.products.slots.store', $product->id) }}">
                        @csrf
                        <div class="row">
                            <div class="col">
                                <label class="form-label small">Tanggal (opsional)</label>
                                <input type="date" name="slot_date" class="form-control" min="{{ date('Y-m-d') }}">
                            </div>
                            <div class="col">
                                <label class="form-label small">Atau Hari (berulang)</label>
                                <select name="day_of_week" class="form-control">
                                    <option value="">-- Pilih Hari --</option>
                                    <option value="monday">Senin</option>
                                    <option value="tuesday">Selasa</option>
                                    <option value="wednesday">Rabu</option>
                                    <option value="thursday">Kamis</option>
                                    <option value="friday">Jumat</option>
                                    <option value="saturday">Sabtu</option>
                                    <option value="sunday">Minggu</option>
                                </select>
                            </div>
                            <div class="col">
                                <label class="form-label small">Jam Mulai</label>
                                <input type="time" name="start_time" class="form-control" required>
                            </div>
                            <div class="col">
                                <label class="form-label small">Jam Selesai</label>
                                <input type="time" name="end_time" class="form-control" required>
                            </div>
                            <div class="col">
                                <label class="form-label small">Kapasitas</label>
                                <input type="number" name="capacity" class="form-control" min="1" value="1" required>
                            </div>
                        </div>
                        <div class="form-check mt-3">
                            <input type="checkbox" id="is_recurring" name="is_recurring" value="1">
                            <label for="is_recurring" class="small">Jadwal berulang setiap minggu</label>
                        </div>
                        <button type="submit" class="btn-add-slot">
                            <i class="fas fa-plus me-2"></i>Tambah Jadwal
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<script>
document.getElementById('image').addEventListener('change', function(e) {
    if (e.target.files.length > 0) {
        const file = e.target.files[0];
        const reader = new FileReader();
        reader.onload = function(event) {
            let preview = document.querySelector('.image-preview');
            if (!preview) {
                preview = document.createElement('div');
                preview.className = 'image-preview mb-3';
                document.querySelector('.upload-area').before(preview);
            }
            preview.innerHTML = '<p class="small text-muted mb-2">Foto Baru:</p><img src="' + event.target.result + '" alt="Preview">';
        };
        reader.readAsDataURL(file);
    }
});
</script>
@endsection
