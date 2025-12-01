@extends('layouts.app')

@section('title', 'Buat Produk Baru - PestiMart')

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
        min-height: 100px;
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
    
    .upload-area p {
        margin-bottom: 0.5rem;
        color: #666;
    }
    
    .upload-area small {
        color: #999;
    }
    
    .type-selector {
        display: flex;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    
    .type-btn {
        flex: 1;
        padding: 1.25rem;
        border: 2px solid #ddd;
        border-radius: 0.75rem;
        background: white;
        cursor: pointer;
        text-align: center;
        transition: all 0.3s ease;
    }
    
    .type-btn:hover {
        border-color: #667eea;
        background: #f0f4ff;
    }
    
    .type-btn.selected {
        border-color: #667eea;
        background: linear-gradient(135deg, #667eea15 0%, #764ba215 100%);
    }
    
    .type-btn i {
        font-size: 2rem;
        color: #667eea;
        margin-bottom: 0.5rem;
        display: block;
    }
    
    .type-btn strong {
        display: block;
        margin-bottom: 0.25rem;
    }
    
    .type-btn small {
        color: #666;
    }
    
    .service-fields {
        display: none;
        background: #f8f9ff;
        padding: 1.5rem;
        border-radius: 0.75rem;
        margin-top: 1rem;
    }
    
    .service-fields.show {
        display: block;
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
        margin-top: 2rem;
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
        text-decoration: none;
        color: white;
    }
    
    .btn-cancel {
        padding: 0.75rem 2rem;
        background: white;
        color: #666;
        border: 2px solid #ddd;
        border-radius: 0.5rem;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
    }
    
    .btn-cancel:hover {
        background: #f5f5f5;
        color: #333;
    }
    
    .image-preview {
        margin-top: 1rem;
        max-width: 200px;
    }
    
    .image-preview img {
        width: 100%;
        border-radius: 0.5rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
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
</style>

<div class="container my-4">
    <div class="product-form-container">
        <h2 class="mb-4">
            <i class="fas fa-plus-circle me-2"></i>Buat Produk Baru
        </h2>
        
        <form method="POST" action="{{ route('seller.products.store') }}" enctype="multipart/form-data">
            @csrf
            
            <!-- Product Type Selection -->
            <div class="form-section">
                <div class="form-section-title">
                    <i class="fas fa-tags me-2"></i>Jenis Produk
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
                    <button type="submit" class="btn-submit">
                        <i class="fas fa-arrow-right me-2"></i>Publikasikan
                    </button>
                    <a href="{{ route('seller.products.index') }}" class="btn-cancel">
                        <i class="fas fa-times me-2"></i>Batal
                    </a>
                </div>
            </div>
        </form>
    </div>
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
