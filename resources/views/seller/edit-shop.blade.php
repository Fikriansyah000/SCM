@extends('layouts.app')

@section('title', 'Edit Toko - PestiMart')

@section('content')
<style>
    .edit-shop-container {
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
    }
    
    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }
    
    textarea.form-control {
        resize: vertical;
        min-height: 100px;
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
        margin-bottom: 0;
        color: #666;
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
        color: #667eea;
        border: 2px solid #667eea;
        border-radius: 0.5rem;
        font-weight: 600;
        cursor: pointer;
        margin-left: 1rem;
        transition: all 0.3s ease;
    }
    
    .btn-cancel:hover {
        background: #f0f4ff;
        text-decoration: none;
    }
</style>

<div class="container my-4">
    <div class="edit-shop-container">
        <h2 class="mb-4">
            <i class="fas fa-edit me-2"></i>Edit Toko
        </h2>
        
        <form method="POST" action="{{ route('seller.shop.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <!-- Basic Information -->
            <div class="form-section">
                <div class="form-section-title">
                    <i class="fas fa-info-circle me-2"></i>Informasi Dasar
                </div>
                
                <div class="form-group">
                    <label for="shop_name" class="form-label">Nama Toko</label>
                    <input type="text" class="form-control @error('shop_name') is-invalid @enderror" 
                           id="shop_name" name="shop_name" value="{{ old('shop_name', $shop->shop_name) }}" required>
                    @error('shop_name')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="description" class="form-label">Deskripsi Toko</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" 
                              id="description" name="description" required>{{ old('description', $shop->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="address" class="form-label">Alamat Toko</label>
                    <input type="text" class="form-control @error('address') is-invalid @enderror" 
                           id="address" name="address" value="{{ old('address', $shop->address) }}" required>
                    @error('address')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="phone" class="form-label">Nomor Telepon</label>
                    <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                           id="phone" name="phone" value="{{ old('phone', $shop->phone) }}" required>
                    @error('phone')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <!-- Logo -->
            <div class="form-section">
                <div class="form-section-title">
                    <i class="fas fa-image me-2"></i>Logo Toko
                </div>
                
                @if($shop->logo)
                <div class="image-preview mb-3">
                    <p class="small text-muted mb-2">Logo Saat Ini:</p>
                    <img src="{{ asset('storage/' . $shop->logo) }}" alt="Logo">
                </div>
                @endif
                
                <div class="form-group">
                    <label for="logo" class="form-label">Ganti Logo</label>
                    <div class="upload-area" onclick="document.getElementById('logo').click()">
                        <i class="fas fa-image"></i>
                        <p>Klik untuk upload atau drag & drop</p>
                        <small class="text-muted">Max 2MB, Format: JPG, PNG, GIF</small>
                    </div>
                    <input type="file" id="logo" name="logo" accept="image/*" style="display: none;">
                    <div id="logoPreview" class="image-preview" style="display:none;"></div>
                    @error('logo')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <!-- Banner -->
            <div class="form-section">
                <div class="form-section-title">
                    <i class="fas fa-image me-2"></i>Banner Toko
                </div>
                
                @if($shop->banner)
                <div class="image-preview mb-3">
                    <p class="small text-muted mb-2">Banner Saat Ini:</p>
                    <img src="{{ asset('storage/' . $shop->banner) }}" alt="Banner">
                </div>
                @endif
                
                <div class="form-group">
                    <label for="banner" class="form-label">Ganti Banner</label>
                    <div class="upload-area" onclick="document.getElementById('banner').click()">
                        <i class="fas fa-image"></i>
                        <p>Klik untuk upload atau drag & drop</p>
                        <small class="text-muted">Max 2MB, Format: JPG, PNG, GIF</small>
                    </div>
                    <input type="file" id="banner" name="banner" accept="image/*" style="display: none;">
                    <div id="bannerPreview" class="image-preview" style="display:none;"></div>
                    @error('banner')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <!-- Actions -->
            <div class="form-section">
                <button type="submit" class="btn-submit">
                    <i class="fas fa-save me-2"></i>Simpan Perubahan
                </button>
                <a href="{{ route('seller.shop') }}" class="btn-cancel">
                    <i class="fas fa-times me-2"></i>Batal
                </a>
            </div>
        </form>
    </div>
</div>
<script>
function bindPreview(inputId, previewId) {
    const input = document.getElementById(inputId);
    const preview = document.getElementById(previewId);
    if (!input || !preview) return;
    input.addEventListener('change', (e) => {
        const file = e.target.files && e.target.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = () => {
            preview.innerHTML = `<img src="${reader.result}" alt="preview" />`;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(file);
    });
}
bindPreview('logo', 'logoPreview');
bindPreview('banner', 'bannerPreview');
</script>
@endsection
