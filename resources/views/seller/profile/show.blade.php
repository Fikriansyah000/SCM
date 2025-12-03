@extends('layouts.seller')

@section('title', 'Profil Saya - PestiMart')
@section('page-title', 'Profil')

@section('content')
<style>
    .profile-header-card {
        background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary) 100%);
        color: white;
        padding: var(--space-lg);
        border-radius: var(--radius-lg);
        margin-bottom: var(--space-lg);
        display: flex;
        align-items: center;
        gap: var(--space-lg);
    }
    
    .profile-avatar {
        width: 80px;
        height: 80px;
        background: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        flex-shrink: 0;
        border: 3px solid rgba(255,255,255,0.3);
    }
    .profile-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .profile-avatar .no-avatar {
        font-size: 2rem;
        color: var(--color-primary);
    }
    
    .profile-info h2 {
        font-size: var(--font-size-xl);
        margin-bottom: var(--space-xxs);
    }
    .profile-info-role {
        display: inline-block;
        background: rgba(255,255,255,0.2);
        padding: var(--space-xxs) var(--space-sm);
        border-radius: var(--radius-full);
        font-size: var(--font-size-xs);
        margin-bottom: var(--space-xs);
    }
    .profile-info p {
        margin: 0;
        opacity: 0.9;
        font-size: var(--font-size-sm);
    }
    
    .profile-container {
        background: white;
        border-radius: var(--radius-lg);
        padding: var(--space-lg);
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--color-border);
    }
    
    .profile-tabs {
        display: flex;
        gap: var(--space-sm);
        border-bottom: 2px solid var(--color-border);
        margin-bottom: var(--space-lg);
    }
    .profile-tab {
        padding: var(--space-sm);
        background: none;
        border: none;
        border-bottom: 3px solid transparent;
        cursor: pointer;
        font-weight: 600;
        color: var(--color-text-muted);
        transition: all 0.2s ease;
        font-size: var(--font-size-sm);
        display: flex;
        align-items: center;
        gap: var(--space-xxs);
    }
    .profile-tab:hover {
        color: var(--color-primary);
    }
    .profile-tab.active {
        color: var(--color-primary);
        border-bottom-color: var(--color-primary);
    }
    
    .profile-section {
        display: none;
    }
    .profile-section.active {
        display: block;
    }
    
    .profile-info-item {
        margin-bottom: var(--space-md);
        padding-bottom: var(--space-md);
        border-bottom: 1px solid var(--color-border);
    }
    .profile-info-item:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }
    .info-label {
        font-weight: 600;
        color: var(--color-text);
        margin-bottom: var(--space-xxs);
        display: block;
        font-size: var(--font-size-sm);
    }
    .info-value {
        color: var(--color-text-secondary);
        margin-bottom: 0;
        font-size: var(--font-size-sm);
    }
    
    .action-button {
        padding: var(--space-sm) var(--space-md);
        background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary) 100%);
        color: white;
        border: none;
        border-radius: var(--radius-md);
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: var(--space-xs);
        font-size: var(--font-size-sm);
    }
    .action-button:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
        color: white;
    }

    .form-label {
        font-weight: 500;
        color: var(--color-text);
        margin-bottom: var(--space-xs);
        font-size: var(--font-size-sm);
    }
    .form-control {
        padding: var(--space-sm);
        border: 1px solid var(--color-border);
        border-radius: var(--radius-md);
        font-size: var(--font-size-sm);
        transition: all 0.2s ease;
    }
    .form-control:focus {
        border-color: var(--color-primary);
        box-shadow: 0 0 0 3px rgba(58, 123, 255, 0.15);
        outline: none;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .profile-header-card {
            flex-direction: column;
            text-align: center;
            padding: var(--space-md);
        }
        .profile-avatar {
            width: 70px;
            height: 70px;
        }
        .profile-tabs {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
    }

    @media (max-width: 575.98px) {
        .profile-header-card {
            padding: 1rem;
            border-radius: 12px;
        }
        .profile-avatar {
            width: 60px;
            height: 60px;
        }
        .profile-avatar .no-avatar i {
            font-size: 1.25rem;
        }
        .profile-info h2 {
            font-size: 1.1rem;
        }
        .profile-info-role {
            font-size: 0.75rem;
        }
        .profile-info p {
            font-size: 0.85rem;
        }
        .profile-container {
            border-radius: 12px;
        }
        .profile-tabs {
            gap: 0.5rem;
            padding: 0.75rem;
        }
        .profile-tab {
            font-size: 0.8rem;
            padding: 0.5rem 0.75rem;
        }
        .profile-section {
            padding: 1rem;
        }
        .profile-info-item {
            padding: 0.75rem 0;
        }
        .info-label {
            font-size: 0.75rem;
        }
        .info-value {
            font-size: 0.9rem;
        }
        .form-group label {
            font-size: 0.85rem;
        }
        .form-control {
            padding: 0.6rem 0.75rem;
            font-size: 0.9rem;
        }
        .btn-primary-solid {
            width: 100%;
            justify-content: center;
            padding: 0.7rem 1rem;
        }
    }
</style>

<div class="profile-header-card">
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
            <i class="fas fa-store"></i> Penjual
        </span>
        <p>{{ auth()->user()->email }}</p>
    </div>
</div>

<div class="profile-container">
    <div class="profile-tabs">
        <button class="profile-tab active" onclick="switchTab('information')">
            <i class="fas fa-id-card"></i> Informasi
        </button>
        <button class="profile-tab" onclick="switchTab('password')">
            <i class="fas fa-lock"></i> Password
        </button>
    </div>
    
    <!-- Information Tab -->
    <div id="information" class="profile-section active">
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
                <span class="badge bg-primary">Penjual</span>
            </p>
        </div>
        
        <a href="{{ route('seller.profile.edit') }}" class="action-button">
            <i class="fas fa-edit"></i> Edit Profil
        </a>
    </div>
    
    <!-- Password Tab -->
    <div id="password" class="profile-section">
        <form method="POST" action="{{ route('seller.profile.password') }}" style="max-width: 400px;">
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
                <small style="color: var(--color-text-muted); font-size: var(--font-size-xs);">Minimal 8 karakter</small>
            </div>
            
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                <input type="password" class="form-control" 
                       id="password_confirmation" name="password_confirmation" required>
            </div>
            
            <button type="submit" class="action-button">
                <i class="fas fa-save"></i> Ubah Password
            </button>
        </form>
    </div>
</div>

<script>
function switchTab(tab) {
    document.querySelectorAll('.profile-section').forEach(el => {
        el.classList.remove('active');
    });
    document.querySelectorAll('.profile-tab').forEach(el => {
        el.classList.remove('active');
    });
    document.getElementById(tab).classList.add('active');
    event.target.closest('.profile-tab').classList.add('active');
}
</script>
@endsection
