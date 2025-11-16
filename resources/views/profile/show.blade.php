@extends('layouts.app')

@section('title', 'Profil Saya - PestiMart')

@section('content')
<style>
    .profile-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 3rem 0;
        margin-bottom: 2rem;
    }
    
    .profile-header-content {
        display: flex;
        align-items: center;
        gap: 2rem;
    }
    
    .profile-avatar {
        width: 120px;
        height: 120px;
        background: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        flex-shrink: 0;
        border: 4px solid white;
    }
    
    .profile-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .profile-avatar .no-avatar {
        font-size: 3rem;
        color: #667eea;
    }
    
    .profile-info h2 {
        font-size: 1.8rem;
        margin-bottom: 0.5rem;
    }
    
    .profile-info-role {
        display: inline-block;
        background: rgba(255,255,255,0.2);
        padding: 0.5rem 1rem;
        border-radius: 2rem;
        font-size: 0.9rem;
        margin-bottom: 1rem;
    }
    
    .profile-container {
        background: white;
        border-radius: 0.75rem;
        padding: 2rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    
    .profile-tabs {
        display: flex;
        gap: 1rem;
        border-bottom: 2px solid #f0f0f0;
        margin-bottom: 2rem;
    }
    
    .profile-tab {
        padding: 1rem;
        background: none;
        border: none;
        border-bottom: 3px solid transparent;
        cursor: pointer;
        font-weight: 600;
        color: #999;
        transition: all 0.3s ease;
    }
    
    .profile-tab:hover {
        color: #667eea;
    }
    
    .profile-tab.active {
        color: #667eea;
        border-bottom-color: #667eea;
    }
    
    .profile-section {
        display: none;
    }
    
    .profile-section.active {
        display: block;
    }
    
    .profile-info-item {
        margin-bottom: 1.5rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid #f0f0f0;
    }
    
    .profile-info-item:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }
    
    .info-label {
        font-weight: 600;
        color: #333;
        margin-bottom: 0.5rem;
        display: block;
    }
    
    .info-value {
        color: #666;
        margin-bottom: 0;
    }
    
    .action-button {
        padding: 0.75rem 1.5rem;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        border-radius: 0.5rem;
        font-weight: 600;
        cursor: pointer;
        transition: transform 0.3s ease;
        text-decoration: none;
        display: inline-block;
    }
    
    .action-button:hover {
        transform: translateY(-2px);
        text-decoration: none;
        color: white;
    }
</style>

<div class="profile-header">
    <div class="container">
        <div class="profile-header-content">
            <div class="profile-avatar">
                @if(auth()->user()->profile_photo)
                    <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}" alt="Avatar">
                @else
                    <div class="no-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                @endif
            </div>
            <div class="profile-info">
                <h2>{{ auth()->user()->name }}</h2>
                <span class="profile-info-role">
                    @if(auth()->user()->role === 'seller')
                        <i class="fas fa-store me-1"></i>Penjual
                    @else
                        <i class="fas fa-shopping-cart me-1"></i>Pembeli
                    @endif
                </span>
                <p class="mb-0">{{ auth()->user()->email }}</p>
            </div>
        </div>
    </div>
</div>

<div class="container my-4">
    <div class="profile-container">
        <div class="profile-tabs">
            <button class="profile-tab active" onclick="switchTab('information')">
                <i class="fas fa-id-card me-2"></i>Informasi
            </button>
            <button class="profile-tab" onclick="switchTab('password')">
                <i class="fas fa-lock me-2"></i>Password
            </button>
        </div>
        
        <!-- Information Tab -->
        <div id="information" class="profile-section active">
            <div class="row">
                <div class="col-md-8">
                    <div class="profile-info-item">
                        <span class="info-label">Nama Lengkap</span>
                        <p class="info-value">{{ auth()->user()->name }}</p>
                    </div>
                    
                    <div class="profile-info-item">
                        <span class="info-label">Email</span>
                        <p class="info-value">{{ auth()->user()->email }}</p>
                    </div>
                    
                    <div class="profile-info-item">
                        <span class="info-label">Nomor Telepon</span>
                        <p class="info-value">{{ auth()->user()->phone ?? 'Belum diisi' }}</p>
                    </div>
                    
                    <div class="profile-info-item">
                        <span class="info-label">Alamat</span>
                        <p class="info-value">{{ auth()->user()->address ?? 'Belum diisi' }}</p>
                    </div>
                    
                    <div class="profile-info-item">
                        <span class="info-label">Peran</span>
                        <p class="info-value">
                            @if(auth()->user()->role === 'seller')
                                <span class="badge bg-primary">Penjual</span>
                            @else
                                <span class="badge bg-success">Pembeli</span>
                            @endif
                        </p>
                    </div>
                    
                    <a href="{{ route('profile.edit') }}" class="action-button">
                        <i class="fas fa-edit me-2"></i>Edit Profil
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Password Tab -->
        <div id="password" class="profile-section">
            <div class="row">
                <div class="col-md-6">
                    <form method="POST" action="{{ route('profile.password') }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="current_password" class="form-label">Password Saat Ini</label>
                            <input type="password" class="form-control @error('current_password') is-invalid @enderror" 
                                   id="current_password" name="current_password" required>
                            @error('current_password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label">Password Baru</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                   id="password" name="password" required>
                            @error('password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Minimal 8 karakter</small>
                        </div>
                        
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                            <input type="password" class="form-control" 
                                   id="password_confirmation" name="password_confirmation" required>
                        </div>
                        
                        <button type="submit" class="action-button">
                            <i class="fas fa-save me-2"></i>Ubah Password
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function switchTab(tab) {
    // Hide all sections
    document.querySelectorAll('.profile-section').forEach(el => {
        el.classList.remove('active');
    });
    
    // Remove active from all tabs
    document.querySelectorAll('.profile-tab').forEach(el => {
        el.classList.remove('active');
    });
    
    // Show selected section
    document.getElementById(tab).classList.add('active');
    
    // Set active tab
    event.target.closest('.profile-tab').classList.add('active');
}
</script>
@endsection
