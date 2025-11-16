@extends('layouts.app')

@section('title', 'Edit Produk - PestiMart')

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
        min-height: 120px;
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
        transition: all 0.3s ease;
    }
    
    .btn-cancel:hover {
        background: #f0f4ff;
        text-decoration: none;
    }
</style>

<div class="container my-4">
    <div class="product-form-container">
        <h2 class="mb-4">
            <i class="fas fa-edit me-2"></i>Edit Produk
        </h2>
        
        <form method="POST" action="{{ route('seller.products.update', $product->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <!-- Basic Information -->
            <div class="form-section">
                <div class="form-section-title">
                    <i class="fas fa-info-circle me-2"></i>Informasi Produk
                </div>
                
                <div class="form-group">
                    <label for="name" class="form-label">Nama Produk</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                           id="name" name="name" value="{{ old('name', $product->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="category" class="form-label">Kategori</label>
                    <input type="text" class="form-control @error('category') is-invalid @enderror" 
                           id="category" name="category" value="{{ old('category', $product->category) }}" required>
                    @error('category')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="description" class="form-label">Deskripsi Produk</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" 
                              id="description" name="description" required>{{ old('description', $product->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <!-- Price & Stock -->
            <div class="form-section">
                <div class="form-section-title">
                    <i class="fas fa-money-bill-wave me-2"></i>Harga & Stok
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
            
            <!-- Product Image -->
            <div class="form-section">
                <div class="form-section-title">
                    <i class="fas fa-image me-2"></i>Foto Produk
                </div>
                
                @if($product->image)
                <div class="image-preview mb-3">
                    <p class="small text-muted mb-2">Foto Saat Ini:</p>
                    <img src="{{ asset('storage/' . $product->image) }}" alt="Product">
                </div>
                @endif
                
                <div class="form-group">
                    <label for="image" class="form-label">Ganti Foto</label>
                    <div class="upload-area" onclick="document.getElementById('image').click()">
                        <i class="fas fa-image"></i>
                        <p>Klik untuk upload atau drag & drop</p>
                        <small class="text-muted">Max 2MB, Format: JPG, PNG, GIF</small>
                    </div>
                    <input type="file" id="image" name="image" accept="image/*" style="display: none;">
                    @error('image')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <!-- Actions -->
            <div class="form-section">
                <div class="form-actions">
                    <button type="submit" class="btn-submit">
                        <i class="fas fa-save me-2"></i>Simpan Perubahan
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
document.getElementById('image').addEventListener('change', function(e) {
    if (e.target.files.length > 0) {
        const file = e.target.files[0];
        const reader = new FileReader();
        reader.onload = function(event) {
            const preview = document.querySelector('.image-preview');
            if (!preview) {
                const div = document.createElement('div');
                div.className = 'image-preview';
                div.innerHTML = '<img src="' + event.target.result + '" alt="Preview">';
                document.querySelector('.upload-area').after(div);
            } else {
                preview.querySelector('img').src = event.target.result;
            }
        };
        reader.readAsDataURL(file);
    }
});
</script>
@endsection
