@extends('layouts.seller')

@section('title', 'Edit Profil - PestiMart Seller')

@section('page-title', 'Edit Profil')

@section('content')
<style>
    .edit-profile-card {
        background: var(--color-surface);
        border-radius: var(--radius-lg);
        padding: var(--space-6);
        box-shadow: var(--shadow-sm);
    }
    
    .edit-profile-header {
        display: flex;
        align-items: center;
        gap: var(--space-3);
        margin-bottom: var(--space-6);
        padding-bottom: var(--space-4);
        border-bottom: 2px solid var(--color-border);
    }
    
    .edit-profile-header h2 {
        font-size: var(--font-size-xl);
        font-weight: 600;
        color: var(--color-text);
        margin: 0;
    }
    
    .edit-profile-header i {
        color: var(--color-primary);
        font-size: 1.25rem;
    }
    
    /* Avatar Section */
    .avatar-section {
        text-align: center;
        margin-bottom: var(--space-6);
        padding-bottom: var(--space-6);
        border-bottom: 2px solid var(--color-border);
    }
    
    .current-avatar {
        width: 100px;
        height: 100px;
        background: var(--color-surface);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        margin: 0 auto var(--space-4);
        border: 3px solid var(--color-primary);
    }
    
    .current-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .current-avatar .no-avatar {
        font-size: 2rem;
        color: var(--color-primary);
    }
    
    .upload-avatar-area {
        border: 2px dashed var(--color-border);
        border-radius: var(--radius-lg);
        padding: var(--space-6);
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        background: var(--color-background);
        max-width: 400px;
        margin: 0 auto;
    }
    
    .upload-avatar-area:hover {
        border-color: var(--color-primary);
        background: rgba(102, 126, 234, 0.05);
    }
    
    .upload-avatar-area i {
        font-size: 1.5rem;
        color: var(--color-primary);
        margin-bottom: var(--space-2);
        display: block;
    }
    
    .upload-avatar-area p {
        margin: 0 0 var(--space-1);
        color: var(--color-text);
        font-weight: 500;
    }
    
    .upload-avatar-area small {
        color: var(--color-muted);
    }
    
    /* Form Fields */
    .form-row {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: var(--space-4);
        margin-bottom: var(--space-4);
    }
    
    .form-group {
        margin-bottom: var(--space-4);
    }
    
    .form-group.full-width {
        grid-column: 1 / -1;
    }
    
    .form-label {
        font-weight: 500;
        margin-bottom: var(--space-2);
        display: block;
        color: var(--color-text);
        font-size: var(--font-size-sm);
    }
    
    .form-control {
        width: 100%;
        padding: var(--space-3);
        border: 1px solid var(--color-border);
        border-radius: var(--radius-md);
        font-size: var(--font-size-base);
        transition: border-color 0.2s, box-shadow 0.2s;
        background: var(--color-surface);
        color: var(--color-text);
    }
    
    .form-control:focus {
        outline: none;
        border-color: var(--color-primary);
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.15);
    }
    
    .form-control.is-invalid {
        border-color: var(--color-danger);
    }
    
    textarea.form-control {
        resize: vertical;
        min-height: 100px;
    }
    
    .invalid-feedback {
        color: var(--color-danger);
        font-size: var(--font-size-sm);
        margin-top: var(--space-1);
    }
    
    /* Buttons */
    .form-actions {
        display: flex;
        gap: var(--space-3);
        margin-top: var(--space-6);
        padding-top: var(--space-4);
        border-top: 1px solid var(--color-border);
    }
    
    .btn-submit {
        display: inline-flex;
        align-items: center;
        gap: var(--space-2);
        padding: var(--space-3) var(--space-5);
        background: linear-gradient(135deg, var(--color-primary) 0%, #764ba2 100%);
        color: white;
        border: none;
        border-radius: var(--radius-md);
        font-weight: 600;
        cursor: pointer;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    
    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
        color: white;
        text-decoration: none;
    }
    
    .btn-cancel {
        display: inline-flex;
        align-items: center;
        gap: var(--space-2);
        padding: var(--space-3) var(--space-5);
        background: var(--color-surface);
        color: var(--color-primary);
        border: 2px solid var(--color-primary);
        border-radius: var(--radius-md);
        font-weight: 600;
        cursor: pointer;
        transition: background 0.2s;
        text-decoration: none;
    }
    
    .btn-cancel:hover {
        background: rgba(102, 126, 234, 0.05);
        text-decoration: none;
    }
    
    /* Mobile Responsive */
    @media (max-width: 768px) {
        .edit-profile-card {
            padding: var(--space-4);
        }
        
        .form-row {
            grid-template-columns: 1fr;
        }
        
        .form-actions {
            flex-direction: column;
        }
        
        .btn-submit,
        .btn-cancel {
            width: 100%;
            justify-content: center;
        }
    }

    @media (max-width: 575.98px) {
        .edit-profile-card {
            padding: 1rem;
            border-radius: 12px;
        }
        .edit-profile-header {
            gap: 0.5rem;
        }
        .edit-profile-header h2 {
            font-size: 1.15rem;
        }
        .edit-profile-header i {
            font-size: 1rem;
        }
        .avatar-section {
            flex-direction: column;
            align-items: center;
            gap: 1rem;
        }
        .current-avatar {
            width: 80px;
            height: 80px;
        }
        .upload-avatar-area {
            padding: 1rem;
            width: 100%;
        }
        .upload-avatar-area i {
            font-size: 1.25rem;
        }
        .upload-avatar-area p {
            font-size: 0.85rem;
        }
        .form-group label {
            font-size: 0.85rem;
        }
        .form-control {
            padding: 0.6rem 0.75rem;
            font-size: 0.9rem;
        }
        .form-section-title {
            font-size: 0.95rem;
        }
        .btn-submit,
        .btn-cancel {
            padding: 0.7rem 1rem;
            font-size: 0.9rem;
        }
    }
</style>

<div class="edit-profile-card">
    <div class="edit-profile-header">
        <i class="fas fa-edit"></i>
        <h2>Edit Profil</h2>
    </div>
    
    <form method="POST" action="{{ route('seller.profile.update') }}" enctype="multipart/form-data">
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
            
            <div class="upload-avatar-area" onclick="document.getElementById('profile_photo').click()">
                <i class="fas fa-camera"></i>
                <p>Klik untuk upload foto profil</p>
                <small>Max 2MB, Format: JPG, PNG, GIF</small>
            </div>
            <input type="file" id="profile_photo" name="profile_photo" accept="image/*" style="display: none;">
            @error('profile_photo')
                <div class="invalid-feedback d-block" style="text-align: center; margin-top: var(--space-2);">{{ $message }}</div>
            @enderror
        </div>
        
        <!-- Profile Information -->
        <div class="form-row">
            <div class="form-group">
                <label for="name" class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                       id="name" name="name" value="{{ old('name', auth()->user()->name) }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                       id="email" name="email" value="{{ old('email', auth()->user()->email) }}" required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label for="phone" class="form-label">Nomor Telepon</label>
                <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                       id="phone" name="phone" value="{{ old('phone', auth()->user()->phone) }}">
                @error('phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div></div>
        </div>
        
        <div class="form-group">
            <label for="address" class="form-label">Alamat</label>
            <textarea class="form-control @error('address') is-invalid @enderror" 
                      id="address" name="address">{{ old('address', auth()->user()->address) }}</textarea>
            @error('address')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        
        <!-- Buttons -->
        <div class="form-actions">
            <button type="submit" class="btn-submit">
                <i class="fas fa-save"></i>
                <span>Simpan Perubahan</span>
            </button>
            <a href="{{ route('seller.profile.show') }}" class="btn-cancel">
                <i class="fas fa-times"></i>
                <span>Batal</span>
            </a>
        </div>
    </form>
</div>
@endsection
