@extends('layouts.app')

@section('title', 'Edit Profil - PestiMart')

@section('content')
<style>
    .edit-profile-container {
        background: white;
        border-radius: 0.75rem;
        padding: 2rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
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
    
    .avatar-section {
        text-align: center;
        margin-bottom: 2rem;
        padding-bottom: 2rem;
        border-bottom: 2px solid #f0f0f0;
    }
    
    .current-avatar {
        width: 100px;
        height: 100px;
        background: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        margin: 0 auto 1rem;
        border: 3px solid #667eea;
    }
    
    .current-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .current-avatar .no-avatar {
        font-size: 2rem;
        color: #667eea;
    }
    
    .upload-avatar-area {
        border: 2px dashed #ddd;
        border-radius: 0.75rem;
        padding: 2rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        background: #f8f9fa;
    }
    
    .upload-avatar-area:hover {
        border-color: #667eea;
        background: #f0f4ff;
    }
    
    .upload-avatar-area i {
        font-size: 1.5rem;
        color: #667eea;
        margin-bottom: 0.5rem;
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
    <div class="edit-profile-container">
        <h2 class="mb-4">
            <i class="fas fa-edit me-2"></i>Edit Profil
        </h2>
        
        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <!-- Avatar Section -->
            <div class="avatar-section">
                <div class="current-avatar">
                    @if(auth()->user()->profile_photo)
                        <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}" alt="Avatar">
                    @else
                        <div class="no-avatar">
                            <i class="fas fa-user"></i>
                        </div>
                    @endif
                </div>
                
                <div class="form-group">
                    <label for="profile_photo" class="form-label">Foto Profil</label>
                    <div class="upload-avatar-area" onclick="document.getElementById('profile_photo').click()">
                        <i class="fas fa-camera"></i>
                        <p class="mb-0">Klik untuk upload foto profil</p>
                        <small class="text-muted">Max 2MB, Format: JPG, PNG, GIF</small>
                    </div>
                    <input type="file" id="profile_photo" name="profile_photo" accept="image/*" style="display: none;">
                    @error('profile_photo')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <!-- Profile Information -->
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name', auth()->user()->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                               id="email" name="email" value="{{ old('email', auth()->user()->email) }}" required>
                        @error('email')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="phone" class="form-label">Nomor Telepon</label>
                        <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                               id="phone" name="phone" value="{{ old('phone', auth()->user()->phone) }}">
                        @error('phone')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <label for="address" class="form-label">Alamat</label>
                <textarea class="form-control @error('address') is-invalid @enderror" 
                          id="address" name="address">{{ old('address', auth()->user()->address) }}</textarea>
                @error('address')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
            
            <!-- Buttons -->
            <div class="mt-4">
                <button type="submit" class="btn-submit">
                    <i class="fas fa-save me-2"></i>Simpan Perubahan
                </button>
                <a href="{{ route('profile.show') }}" class="btn-cancel">
                    <i class="fas fa-times me-2"></i>Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
