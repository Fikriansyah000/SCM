@extends('layouts.seller')

@section('title', 'Buat Produk Baru - PestiMart')
@section('page-title', 'Tambah Produk')

@section('content')
<style>
    .product-form-container {
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(248, 250, 252, 0.9) 100%);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(226, 232, 240, 0.8);
        position: relative;
        overflow: hidden;
    }
    .product-form-container::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--color-primary) 0%, var(--color-secondary, #6366f1) 50%, var(--color-primary) 100%);
        background-size: 200% 100%;
        animation: shimmer 3s ease-in-out infinite;
    }
    @keyframes shimmer {
        0%, 100% { background-position: 200% 0; }
        50% { background-position: 0% 0; }
    }
    .form-section {
        margin-bottom: 2rem;
        padding: 1.5rem;
        background: rgba(255, 255, 255, 0.6);
        border-radius: 16px;
        border: 1px solid rgba(226, 232, 240, 0.5);
        transition: all 0.3s ease;
    }
    .form-section:hover {
        background: rgba(255, 255, 255, 0.8);
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.04);
    }
    .form-section-title {
        font-size: 1.1rem;
        font-weight: 700;
        margin-bottom: 1.25rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid transparent;
        border-image: linear-gradient(90deg, var(--color-primary), var(--color-secondary, #6366f1)) 1;
        color: var(--color-text);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .form-section-title i {
        background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary, #6366f1) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        font-size: 1.2rem;
    }
    .form-group {
        margin-bottom: 1.25rem;
    }
    .form-label {
        font-weight: 600;
        margin-bottom: 0.5rem;
        display: block;
        color: var(--color-text);
        font-size: 0.9rem;
        letter-spacing: -0.01em;
    }
    .form-control {
        width: 100%;
        padding: 0.875rem 1rem;
        border: 2px solid rgba(226, 232, 240, 0.8);
        border-radius: 12px;
        font-family: inherit;
        font-size: 0.95rem;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        background: rgba(255, 255, 255, 0.8);
    }
    .form-control:hover {
        border-color: rgba(99, 102, 241, 0.3);
    }
    .form-control:focus {
        border-color: var(--color-primary);
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.12);
        outline: none;
        background: white;
    }
    textarea.form-control {
        resize: vertical;
        min-height: 120px;
    }
    .upload-area {
        border: 2px dashed rgba(99, 102, 241, 0.3);
        border-radius: 16px;
        padding: 2.5rem 1.5rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        background: linear-gradient(135deg, rgba(248, 250, 252, 0.8) 0%, rgba(241, 245, 249, 0.6) 100%);
        position: relative;
        overflow: hidden;
    }
    .upload-area::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.05) 0%, rgba(139, 92, 246, 0.05) 100%);
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    .upload-area:hover {
        border-color: var(--color-primary);
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(99, 102, 241, 0.15);
    }
    .upload-area:hover::before {
        opacity: 1;
    }
    .upload-area i {
        font-size: 3rem;
        background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary, #6366f1) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 0.75rem;
        display: block;
    }
    .upload-area p {
        margin-bottom: 0.25rem;
        color: var(--color-text);
        font-weight: 600;
        font-size: 1rem;
    }
    .upload-area small {
        color: var(--color-text-muted);
        font-size: 0.85rem;
    }
    .type-selector {
        display: flex;
        gap: 1.25rem;
        margin-bottom: 0;
    }
    .type-btn {
        flex: 1;
        padding: 1.75rem 1.25rem;
        border: 2px solid rgba(226, 232, 240, 0.8);
        border-radius: 16px;
        background: rgba(255, 255, 255, 0.7);
        cursor: pointer;
        text-align: center;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }
    .type-btn::before {
        content: '';
        position: absolute;
        inset: 0;
        border-radius: 14px;
        padding: 2px;
        background: linear-gradient(135deg, var(--color-primary), var(--color-secondary, #6366f1));
        -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
        mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
        -webkit-mask-composite: xor;
        mask-composite: exclude;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    .type-btn:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
    }
    .type-btn:hover::before {
        opacity: 0.5;
    }
    .type-btn.selected {
        border-color: transparent;
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.08) 0%, rgba(139, 92, 246, 0.08) 100%);
        box-shadow: 0 8px 24px rgba(99, 102, 241, 0.2);
    }
    .type-btn.selected::before {
        opacity: 1;
    }
    .type-btn i {
        font-size: 2.5rem;
        background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary, #6366f1) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 0.75rem;
        display: block;
    }
    .type-btn strong {
        display: block;
        margin-bottom: 0.35rem;
        color: var(--color-text);
        font-size: 1.05rem;
    }
    .type-btn small {
        color: var(--color-text-secondary);
        font-size: var(--font-size-xs);
    }
    .service-fields {
        display: none;
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.06) 0%, rgba(139, 92, 246, 0.04) 100%);
        padding: 1.5rem;
        border-radius: 16px;
        margin-top: 0.75rem;
        border: 1px solid rgba(99, 102, 241, 0.15);
    }
    .service-fields.show {
        display: block;
        animation: slideDown 0.3s ease;
    }
    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .physical-fields {
        display: block;
    }
    .physical-fields.hide {
        display: none;
    }
    .form-actions {
        display: flex;
        gap: 1rem;
        margin-top: 0;
        flex-wrap: wrap;
        padding-top: 0.5rem;
    }
    .form-actions .btn-primary-solid {
        padding: 1rem 2rem;
        font-size: 1rem;
        border-radius: 12px;
        box-shadow: 0 4px 16px rgba(99, 102, 241, 0.3);
    }
    .form-actions .btn-primary-solid:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(99, 102, 241, 0.4);
    }
    .btn-cancel {
        padding: 1rem 1.75rem;
        background: rgba(255, 255, 255, 0.8);
        color: var(--color-text-secondary);
        border: 2px solid rgba(226, 232, 240, 0.8);
        border-radius: 12px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .btn-cancel:hover {
        background: rgba(248, 250, 252, 1);
        color: var(--color-text);
        border-color: rgba(203, 213, 225, 1);
        transform: translateY(-2px);
    }
    .image-preview {
        margin-top: 1rem;
        max-width: 220px;
    }
    .image-preview img {
        width: 100%;
        border-radius: 12px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
        border: 3px solid white;
    }
    .form-check {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem 1rem;
        background: rgba(255, 255, 255, 0.6);
        border-radius: 10px;
        border: 1px solid rgba(226, 232, 240, 0.5);
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .form-check:hover {
        background: rgba(255, 255, 255, 0.9);
    }
    .form-check input[type="checkbox"] {
        width: 1.35rem;
        height: 1.35rem;
        accent-color: var(--color-primary);
        cursor: pointer;
    }
    .form-check label {
        cursor: pointer;
        font-weight: 500;
    }
    .alert-info {
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.08) 0%, rgba(99, 102, 241, 0.06) 100%);
        border: 1px solid rgba(59, 130, 246, 0.2);
        color: #1e40af;
        border-radius: 12px;
        padding: 1rem 1.25rem;
    }
    /* Responsive */
    @media (max-width: 768px) {
        .product-form-container {
            padding: 1.25rem;
            border-radius: 16px;
        }
        .form-section {
            padding: 1rem;
        }
        .type-selector {
            flex-direction: column;
            gap: 1rem;
        }
        .type-btn {
            padding: 1.25rem 1rem;
        }
        .form-actions {
            flex-direction: column;
        }
        .form-actions .btn-primary-solid, 
        .btn-cancel {
            width: 100%;
            justify-content: center;
        }
    }

    @media (max-width: 575.98px) {
        .product-form-container {
            padding: 1rem;
            border-radius: 12px;
        }
        .form-section {
            padding: 0.875rem;
            border-radius: 10px;
        }
        .form-section-title {
            font-size: 0.95rem;
        }
        .form-group label {
            font-size: 0.9rem;
        }
        .form-control {
            padding: 0.65rem 0.75rem;
            font-size: 0.9rem;
        }
        .upload-area {
            padding: 1.25rem;
        }
        .upload-area i {
            font-size: 1.75rem;
        }
        .upload-area p {
            font-size: 0.9rem;
        }
        .type-btn {
            padding: 1rem 0.875rem;
        }
        .type-btn strong {
            font-size: 0.9rem;
        }
        .type-btn small {
            font-size: 0.75rem;
        }
        .type-btn i {
            font-size: 1.25rem;
        }
        .form-actions .btn-primary-solid,
        .btn-cancel {
            padding: 0.7rem 1rem;
            font-size: 0.9rem;
        }
    }
</style>

<div class="product-form-container">
    <form method="POST" action="{{ route('seller.products.store') }}" enctype="multipart/form-data">
        @csrf
        
        <!-- Product Type Selection -->
        <div class="form-section">
            <div class="form-section-title">
                <i class="fas fa-tags"></i> Jenis Produk
            </div>
                
                <div class="type-selector">
                    <div class="type-btn selected" data-type="food" onclick="selectProductType('food')">
                        <i class="fas fa-box"></i>
                        <strong>Produk Fisik</strong>
                        <small>Makanan, minuman, barang fisik</small>
                    </div>
                    <div class="type-btn" data-type="service" onclick="selectProductType('service')">
                        <i class="fas fa-concierge-bell"></i>
                        <strong>Layanan / Jasa</strong>
                        <small>Les privat, jasa print, konsultasi</small>
                    </div>
                </div>
                <input type="hidden" name="product_type" id="product_type" value="{{ old('product_type', 'food') }}">
            </div>
            
            <!-- Product Photo -->
            <div class="form-section">
                <div class="form-section-title">
                    <i class="fas fa-image me-2"></i>Foto Produk
                </div>
                
                <div class="form-group">
                    <div class="upload-area" onclick="document.getElementById('image').click()">
                        <i class="fas fa-image"></i>
                        <p>Klik untuk tambah foto</p>
                        <small>(Maks. 2MB, format: JPG, PNG, GIF, WEBP)</small>
                    </div>
                    <input type="file" id="image" name="image" accept="image/*" style="display: none;">
                    @error('image')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <!-- Basic Information -->
            <div class="form-section">
                <div class="form-section-title">
                    <i class="fas fa-info-circle me-2"></i>Informasi Dasar
                </div>
                
                <div class="form-group">
                    <label for="name" class="form-label">Nama <span id="typeLabel">Produk</span></label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                           id="name" name="name" value="{{ old('name') }}" required 
                           placeholder="Nama produk/layanan wajib diisi">
                    @error('name')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="description" class="form-label">Deskripsi</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" 
                              id="description" name="description" required 
                              placeholder="Jelaskan detail produk/layanan Anda.">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <!-- Category -->
            <div class="form-section">
                <div class="form-section-title">
                    <i class="fas fa-list me-2"></i>Kategori
                </div>
                
                <div class="form-group">
                    <label for="category" class="form-label">Pilih kategori</label>
                    <select class="form-control @error('category') is-invalid @enderror" 
                            id="category" name="category" required>
                        <option value="">-- Pilih Kategori --</option>
                        <option value="Makanan & Minuman" {{ old('category') == 'Makanan & Minuman' ? 'selected' : '' }}>
                            Makanan & Minuman
                        </option>
                        <option value="Jasa & Layanan" {{ old('category') == 'Jasa & Layanan' ? 'selected' : '' }}>
                            Jasa & Layanan
                        </option>
                        <option value="Buku & Alat Tulis" {{ old('category') == 'Buku & Alat Tulis' ? 'selected' : '' }}>
                            Buku & Alat Tulis
                        </option>
                        <option value="Elektronik" {{ old('category') == 'Elektronik' ? 'selected' : '' }}>
                            Elektronik
                        </option>
                        <option value="Lainnya" {{ old('category') == 'Lainnya' ? 'selected' : '' }}>
                            Lainnya
                        </option>
                    </select>
                    @error('category')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <!-- Price & Stock (Physical Products) -->
            <div class="form-section physical-fields" id="physicalFields">
                <div class="form-section-title">
                    <i class="fas fa-money-bill-wave me-2"></i>Harga & Stok
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="price" class="form-label">Harga (Rp)</label>
                            <input type="number" class="form-control @error('price') is-invalid @enderror" 
                                   id="price" name="price" value="{{ old('price') }}" required 
                                   placeholder="Harga produk" step="1000" min="0">
                            @error('price')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="stock" class="form-label">Stok</label>
                            <input type="number" class="form-control @error('stock') is-invalid @enderror" 
                                   id="stock" name="stock" value="{{ old('stock') }}" 
                                   placeholder="Stok produk" min="0">
                            @error('stock')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Service-specific Fields -->
            <div class="form-section service-fields" id="serviceFields">
                <div class="form-section-title">
                    <i class="fas fa-concierge-bell me-2"></i>Detail Layanan
                </div>
                
                <div class="form-group">
                    <label for="service_price" class="form-label">Harga Layanan (Rp)</label>
                    <input type="number" class="form-control" 
                           id="service_price" 
                           placeholder="Harga per sesi/layanan" step="1000" min="0">
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="duration_minutes" class="form-label">Durasi (menit)</label>
                            <input type="number" class="form-control @error('duration_minutes') is-invalid @enderror" 
                                   id="duration_minutes" name="duration_minutes" value="{{ old('duration_minutes') }}" 
                                   placeholder="Durasi layanan dalam menit" min="1">
                            @error('duration_minutes')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="location_type" class="form-label">Lokasi Layanan</label>
                            <select class="form-control @error('location_type') is-invalid @enderror" 
                                    id="location_type" name="location_type">
                                <option value="flexible" {{ old('location_type') == 'flexible' ? 'selected' : '' }}>Fleksibel</option>
                                <option value="online" {{ old('location_type') == 'online' ? 'selected' : '' }}>Online</option>
                                <option value="onsite" {{ old('location_type') == 'onsite' ? 'selected' : '' }}>Di Tempat</option>
                            </select>
                            @error('location_type')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="requirements" class="form-label">Persyaratan / Catatan (opsional)</label>
                    <textarea class="form-control @error('requirements') is-invalid @enderror" 
                              id="requirements" name="requirements" rows="2"
                              placeholder="Misalnya: bawa laptop sendiri, minimal 2 orang, dll.">{{ old('requirements') }}</textarea>
                    @error('requirements')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <div class="form-check">
                        <input type="checkbox" id="requires_booking" name="requires_booking" value="1" 
                               {{ old('requires_booking', true) ? 'checked' : '' }}>
                        <label for="requires_booking">Memerlukan pemilihan jadwal/slot</label>
                    </div>
                    <small class="text-muted">Jika dicentang, pembeli harus memilih jadwal sebelum memesan.</small>
                </div>
                
                <div class="alert alert-info mt-3" style="border-radius: .5rem;">
                    <i class="fas fa-info-circle me-2"></i>
                    Setelah menyimpan layanan, Anda bisa menambahkan jadwal/slot layanan di halaman edit.
                </div>
            </div>
            
        <!-- Actions -->
        <div class="form-section">
            <div class="form-actions">
                <button type="submit" class="btn-primary-solid">
                    <i class="fas fa-check"></i> Publikasikan
                </button>
                <a href="{{ route('seller.products.index') }}" class="btn-cancel">
                    <i class="fas fa-times"></i> Batal
                </a>
            </div>
        </div>
    </form>
</div>

<script>
function selectProductType(type) {
    document.getElementById('product_type').value = type;
    
    document.querySelectorAll('.type-btn').forEach(btn => {
        btn.classList.remove('selected');
    });
    document.querySelector(`.type-btn[data-type="${type}"]`).classList.add('selected');
    
    const physicalFields = document.getElementById('physicalFields');
    const serviceFields = document.getElementById('serviceFields');
    const stockInput = document.getElementById('stock');
    const priceInput = document.getElementById('price');
    const servicePriceInput = document.getElementById('service_price');
    const typeLabel = document.getElementById('typeLabel');
    
    if (type === 'service') {
        physicalFields.classList.add('hide');
        serviceFields.classList.add('show');
        stockInput.removeAttribute('required');
        typeLabel.textContent = 'Layanan';
        
        // Sync price fields
        servicePriceInput.addEventListener('input', function() {
            priceInput.value = this.value;
        });
    } else {
        physicalFields.classList.remove('hide');
        serviceFields.classList.remove('show');
        stockInput.setAttribute('required', 'required');
        typeLabel.textContent = 'Produk';
    }
}

// Initialize based on old value
document.addEventListener('DOMContentLoaded', function() {
    const oldType = '{{ old('product_type', 'food') }}';
    selectProductType(oldType);
    
    // Image preview
    document.getElementById('image').addEventListener('change', function(e) {
        if (e.target.files.length > 0) {
            const file = e.target.files[0];
            const reader = new FileReader();
            reader.onload = function(event) {
                let preview = document.querySelector('.image-preview');
                if (!preview) {
                    preview = document.createElement('div');
                    preview.className = 'image-preview';
                    document.querySelector('.upload-area').after(preview);
                }
                preview.innerHTML = '<img src="' + event.target.result + '" alt="Preview">';
            };
            reader.readAsDataURL(file);
        }
    });
});
</script>
@endsection
