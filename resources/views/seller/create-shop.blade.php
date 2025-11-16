@extends('layouts.app')

@section('title', 'Buat Toko - PestiMart')

@section('content')
<style>
    .create-shop-container {
        min-height: 80vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem 0;
    }
    
    .shop-card {
        background: white;
        border-radius: 1rem;
        box-shadow: 0 8px 24px rgba(0,0,0,0.12);
        max-width: 600px;
        width: 100%;
    }
    
    .shop-card-body {
        padding: 3rem;
    }
    
    .shop-card-title {
        text-align: center;
        font-size: 1.8rem;
        font-weight: 700;
        color: #667eea;
        margin-bottom: 1rem;
    }
    
    .shop-card-subtitle {
        text-align: center;
        color: #999;
        margin-bottom: 2rem;
    }
    
    .form-group {
        margin-bottom: 1.5rem;
    }
    
    .form-label {
        font-weight: 500;
        color: #333;
        margin-bottom: 0.5rem;
        display: block;
    }
    
    .form-control {
        border-radius: 0.5rem;
        border: 1px solid #ddd;
        padding: 0.75rem;
        width: 100%;
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
        width: 100%;
        padding: 0.75rem;
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
</style>

<div class="create-shop-container">
    <div class="shop-card">
        <div class="shop-card-body">
            <h3 class="shop-card-title">
                <i class="fas fa-store me-2"></i>Buat Toko
            </h3>
            <p class="shop-card-subtitle">Mulai berjualan dengan membuat toko Anda</p>
            
            <form method="POST" action="{{ route('seller.shop.store') }}" enctype="multipart/form-data">
                @csrf
                
                <div class="form-group">
                    <label for="shop_name" class="form-label">Nama Toko</label>
                    <input type="text" class="form-control @error('shop_name') is-invalid @enderror" 
                           id="shop_name" name="shop_name" value="{{ old('shop_name') }}" required 
                           placeholder="Masukkan nama toko Anda">
                    @error('shop_name')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="description" class="form-label">Deskripsi Toko</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" 
                              id="description" name="description" required 
                              placeholder="Deskripsikan toko Anda...">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="address" class="form-label">Alamat Toko</label>
                    <input type="text" class="form-control @error('address') is-invalid @enderror" 
                           id="address" name="address" value="{{ old('address') }}" required 
                           placeholder="Masukkan alamat toko">
                    @error('address')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="phone" class="form-label">Nomor Telepon</label>
                    <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                           id="phone" name="phone" value="{{ old('phone') }}" required 
                           placeholder="Masukkan nomor telepon">
                    @error('phone')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="logo" class="form-label">Logo Toko</label>
                    <div class="upload-area" onclick="document.getElementById('logo').click()">
                        <i class="fas fa-image"></i>
                        <p>Klik untuk upload logo atau drag & drop</p>
                        <small class="text-muted">Max 2MB, Format: JPG, PNG, GIF</small>
                    </div>
                    <input type="file" id="logo" name="logo" accept="image/*" style="display: none;">
                    @error('logo')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="banner" class="form-label">Banner Toko</label>
                    <div class="upload-area" onclick="document.getElementById('banner').click()">
                        <i class="fas fa-image"></i>
                        <p>Klik untuk upload banner atau drag & drop</p>
                        <small class="text-muted">Max 2MB, Format: JPG, PNG, GIF</small>
                    </div>
                    <input type="file" id="banner" name="banner" accept="image/*" style="display: none;">
                    @error('banner')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
                
                <button type="submit" class="btn-submit">
                    <i class="fas fa-check me-2"></i>Buat Toko
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
