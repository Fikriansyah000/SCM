@extends('layouts.app')

@section('title', 'Profil Saya - PestiMart')

@section('content')
<style>
    /* ===== CSS Variables ===== */
    :root {
        --primary: #1e3a5f;
        --primary-light: #2d5a87;
        --primary-lighter: #3d6a9f;
        --accent: #00c9a7;
        --bg-gradient: linear-gradient(135deg, #1e3a5f 0%, #2d5a87 50%, #3d6a9f 100%);
    }

    /* ===== Page Background ===== */
    .profile-page {
        min-height: 100vh;
        background: linear-gradient(135deg, #f0f4f8 0%, #e8f0fe 100%);
        position: relative;
        overflow: hidden;
        padding-bottom: 60px;
    }

    /* Animated Background Particles */
    .profile-particles {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
        overflow: hidden;
        z-index: 0;
    }

    .profile-particle {
        position: absolute;
        width: 8px;
        height: 8px;
        background: linear-gradient(135deg, var(--primary), var(--primary-lighter));
        border-radius: 50%;
        opacity: 0.15;
        animation: particleFloat 20s infinite ease-in-out;
    }

    .profile-particle:nth-child(1) { left: 5%; top: 20%; animation-delay: 0s; }
    .profile-particle:nth-child(2) { left: 15%; top: 60%; animation-delay: 2s; width: 12px; height: 12px; }
    .profile-particle:nth-child(3) { left: 25%; top: 35%; animation-delay: 4s; }
    .profile-particle:nth-child(4) { left: 45%; top: 80%; animation-delay: 6s; width: 10px; height: 10px; }
    .profile-particle:nth-child(5) { left: 65%; top: 25%; animation-delay: 8s; }
    .profile-particle:nth-child(6) { left: 75%; top: 55%; animation-delay: 10s; width: 6px; height: 6px; }
    .profile-particle:nth-child(7) { left: 85%; top: 75%; animation-delay: 12s; }
    .profile-particle:nth-child(8) { left: 90%; top: 15%; animation-delay: 14s; width: 14px; height: 14px; }

    @keyframes particleFloat {
        0%, 100% { transform: translateY(0) rotate(0deg); opacity: 0.15; }
        25% { transform: translateY(-30px) rotate(90deg); opacity: 0.25; }
        50% { transform: translateY(-50px) rotate(180deg); opacity: 0.15; }
        75% { transform: translateY(-25px) rotate(270deg); opacity: 0.2; }
    }

    /* ===== Profile Header ===== */
    .profile-header {
        background: var(--bg-gradient);
        position: relative;
        padding: 60px 0 120px;
        overflow: hidden;
    }

    .profile-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        animation: patternMove 30s linear infinite;
    }

    @keyframes patternMove {
        0% { background-position: 0 0; }
        100% { background-position: 60px 60px; }
    }

    /* Floating Shapes */
    .header-shapes {
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        overflow: hidden;
        pointer-events: none;
    }

    .header-shape {
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.08);
    }

    .header-shape:nth-child(1) {
        width: 300px;
        height: 300px;
        top: -100px;
        right: -50px;
        animation: shapeFloat1 15s ease-in-out infinite;
    }

    .header-shape:nth-child(2) {
        width: 200px;
        height: 200px;
        bottom: -50px;
        left: 10%;
        animation: shapeFloat2 18s ease-in-out infinite;
    }

    .header-shape:nth-child(3) {
        width: 150px;
        height: 150px;
        top: 30%;
        right: 20%;
        animation: shapeFloat3 12s ease-in-out infinite;
    }

    @keyframes shapeFloat1 {
        0%, 100% { transform: translate(0, 0) scale(1); }
        50% { transform: translate(-20px, 20px) scale(1.1); }
    }

    @keyframes shapeFloat2 {
        0%, 100% { transform: translate(0, 0) scale(1); }
        50% { transform: translate(30px, -20px) scale(0.9); }
    }

    @keyframes shapeFloat3 {
        0%, 100% { transform: translate(0, 0); }
        50% { transform: translate(-15px, 15px); }
    }

    .profile-header-content {
        position: relative;
        z-index: 2;
        display: flex;
        align-items: center;
        gap: 2rem;
        animation: slideUp 0.8s ease-out;
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* ===== Avatar ===== */
    .profile-avatar {
        position: relative;
        width: 140px;
        height: 140px;
        flex-shrink: 0;
    }

    .profile-avatar::before {
        content: '';
        position: absolute;
        top: -5px;
        left: -5px;
        right: -5px;
        bottom: -5px;
        background: linear-gradient(135deg, #00c9a7, #ffffff, #00c9a7);
        border-radius: 50%;
        animation: avatarGlow 3s ease-in-out infinite;
        z-index: -1;
    }

    @keyframes avatarGlow {
        0%, 100% { transform: rotate(0deg) scale(1); opacity: 0.8; }
        50% { transform: rotate(180deg) scale(1.05); opacity: 1; }
    }

    .avatar-inner {
        width: 100%;
        height: 100%;
        background: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        border: 4px solid white;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        transition: transform 0.3s ease;
    }

    .profile-avatar:hover .avatar-inner {
        transform: scale(1.05);
    }

    .avatar-inner img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .avatar-inner .no-avatar {
        font-size: 3.5rem;
        color: var(--primary);
    }

    /* Status Badge */
    .avatar-status {
        position: absolute;
        bottom: 10px;
        right: 5px;
        width: 24px;
        height: 24px;
        background: #00c9a7;
        border: 3px solid white;
        border-radius: 50%;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(0, 201, 167, 0.4); }
        50% { transform: scale(1.1); box-shadow: 0 0 0 10px rgba(0, 201, 167, 0); }
    }

    /* ===== Profile Info ===== */
    .profile-info {
        color: white;
    }

    .profile-info h2 {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    }

    .profile-info-role {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        padding: 8px 16px;
        border-radius: 50px;
        font-size: 0.9rem;
        font-weight: 600;
        margin-bottom: 10px;
        border: 1px solid rgba(255, 255, 255, 0.2);
        animation: shimmer 3s infinite;
    }

    @keyframes shimmer {
        0%, 100% { background: rgba(255, 255, 255, 0.15); }
        50% { background: rgba(255, 255, 255, 0.25); }
    }

    .profile-info p {
        opacity: 0.9;
        font-size: 1rem;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    /* ===== Wave Divider ===== */
    .wave-divider {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        overflow: hidden;
        line-height: 0;
    }

    .wave-divider svg {
        position: relative;
        display: block;
        width: calc(100% + 1.3px);
        height: 80px;
    }

    .wave-divider .shape-fill {
        fill: #f0f4f8;
    }

    /* ===== Profile Card ===== */
    .profile-main {
        position: relative;
        z-index: 10;
        margin-top: -60px;
        padding: 0 15px;
    }

    .profile-container {
        background: white;
        border-radius: 20px;
        padding: 0;
        box-shadow: 0 10px 60px rgba(30, 58, 95, 0.15);
        overflow: hidden;
        animation: cardEnter 0.8s ease-out 0.3s backwards;
    }

    @keyframes cardEnter {
        from {
            opacity: 0;
            transform: translateY(40px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* ===== Tabs ===== */
    .profile-tabs {
        display: flex;
        background: linear-gradient(135deg, #f8fafc, #f1f5f9);
        border-bottom: 2px solid #e2e8f0;
        padding: 0;
        overflow-x: auto;
    }

    .profile-tab {
        flex: 1;
        padding: 20px 24px;
        background: none;
        border: none;
        border-bottom: 3px solid transparent;
        cursor: pointer;
        font-weight: 600;
        font-size: 0.95rem;
        color: #64748b;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        position: relative;
        overflow: hidden;
    }

    .profile-tab::before {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        width: 0;
        height: 3px;
        background: var(--bg-gradient);
        transition: all 0.3s ease;
        transform: translateX(-50%);
    }

    .profile-tab:hover {
        color: var(--primary);
        background: rgba(30, 58, 95, 0.05);
    }

    .profile-tab:hover::before {
        width: 50%;
    }

    .profile-tab.active {
        color: var(--primary);
        background: white;
    }

    .profile-tab.active::before {
        width: 100%;
    }

    .profile-tab i {
        font-size: 1.1rem;
        transition: transform 0.3s ease;
    }

    .profile-tab:hover i {
        transform: scale(1.2);
    }

    /* ===== Tab Content ===== */
    .profile-content {
        padding: 30px;
    }

    .profile-section {
        display: none;
        animation: fadeIn 0.5s ease;
    }

    .profile-section.active {
        display: block;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* ===== Info Grid ===== */
    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 20px;
    }

    .info-card {
        background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 24px;
        transition: all 0.4s ease;
        position: relative;
        overflow: hidden;
    }

    .info-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: var(--bg-gradient);
        transform: scaleY(0);
        transition: transform 0.4s ease;
    }

    .info-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(30, 58, 95, 0.12);
        border-color: var(--primary-lighter);
    }

    .info-card:hover::before {
        transform: scaleY(1);
    }

    .info-card-icon {
        width: 50px;
        height: 50px;
        background: var(--bg-gradient);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 15px;
        color: white;
        font-size: 1.3rem;
        transition: transform 0.3s ease;
    }

    .info-card:hover .info-card-icon {
        transform: rotate(10deg) scale(1.1);
    }

    .info-label {
        font-size: 0.85rem;
        font-weight: 600;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 8px;
        display: block;
    }

    .info-value {
        font-size: 1.1rem;
        font-weight: 600;
        color: #1e293b;
        margin: 0;
        word-break: break-word;
    }

    .info-value .badge {
        font-size: 0.85rem;
        padding: 6px 14px;
        border-radius: 50px;
        font-weight: 600;
    }

    .badge-seller {
        background: linear-gradient(135deg, var(--primary), var(--primary-light));
        color: white;
    }

    .badge-buyer {
        background: linear-gradient(135deg, #00c9a7, #00b894);
        color: white;
    }

    /* ===== Action Buttons ===== */
    .profile-actions {
        margin-top: 30px;
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
    }

    .action-button {
        padding: 14px 28px;
        background: var(--bg-gradient);
        color: white;
        border: none;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.95rem;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        position: relative;
        overflow: hidden;
    }

    .action-button::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s ease;
    }

    .action-button:hover::before {
        left: 100%;
    }

    .action-button:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(30, 58, 95, 0.3);
        color: white;
        text-decoration: none;
    }

    .action-button i {
        transition: transform 0.3s ease;
    }

    .action-button:hover i {
        transform: translateX(3px);
    }

    /* ===== Password Form ===== */
    .password-form {
        max-width: 500px;
    }

    .form-group {
        margin-bottom: 24px;
        position: relative;
    }

    .form-label {
        font-weight: 600;
        color: #374151;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .form-label i {
        color: var(--primary);
    }

    .form-control {
        width: 100%;
        padding: 14px 18px;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: #f8fafc;
    }

    .form-control:focus {
        outline: none;
        border-color: var(--primary);
        background: white;
        box-shadow: 0 0 0 4px rgba(30, 58, 95, 0.1);
    }

    .form-hint {
        margin-top: 8px;
        font-size: 0.85rem;
        color: #64748b;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    /* Password Toggle */
    .password-wrapper {
        position: relative;
    }

    .password-toggle {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: #64748b;
        cursor: pointer;
        padding: 5px;
        transition: color 0.3s ease;
    }

    .password-toggle:hover {
        color: var(--primary);
    }

    /* ===== Success/Error Messages ===== */
    .alert {
        padding: 16px 20px;
        border-radius: 12px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 12px;
        animation: slideIn 0.5s ease;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateX(-20px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .alert-success {
        background: linear-gradient(135deg, #d1fae5, #a7f3d0);
        color: #065f46;
        border: 1px solid #34d399;
    }

    .alert-danger {
        background: linear-gradient(135deg, #fee2e2, #fecaca);
        color: #991b1b;
        border: 1px solid #f87171;
    }

    /* ===== Responsive ===== */
    @media (max-width: 768px) {
        .profile-header-content {
            flex-direction: column;
            text-align: center;
        }

        .profile-info {
            text-align: center;
        }

        .profile-info p {
            justify-content: center;
        }

        .profile-tabs {
            flex-wrap: nowrap;
            overflow-x: auto;
        }

        .profile-tab {
            flex: 0 0 auto;
            padding: 15px 20px;
        }

        .info-grid {
            grid-template-columns: 1fr;
        }

        .profile-actions {
            flex-direction: column;
        }

        .action-button {
            width: 100%;
            justify-content: center;
        }
    }

    /* ===== Loading Animation ===== */
    .skeleton {
        background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
        background-size: 200% 100%;
        animation: skeleton-loading 1.5s infinite;
    }

    @keyframes skeleton-loading {
        0% { background-position: 200% 0; }
        100% { background-position: -200% 0; }
    }
</style>

<div class="profile-page">
    <!-- Background Particles -->
    <div class="profile-particles">
        <div class="profile-particle"></div>
        <div class="profile-particle"></div>
        <div class="profile-particle"></div>
        <div class="profile-particle"></div>
        <div class="profile-particle"></div>
        <div class="profile-particle"></div>
        <div class="profile-particle"></div>
        <div class="profile-particle"></div>
    </div>

    <!-- Profile Header -->
    <div class="profile-header">
        <!-- Floating Shapes -->
        <div class="header-shapes">
            <div class="header-shape"></div>
            <div class="header-shape"></div>
            <div class="header-shape"></div>
        </div>

        <div class="container">
            <div class="profile-header-content">
                <div class="profile-avatar">
                    <div class="avatar-inner">
                        @if(auth()->user()->profile_photo)
                            <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}" alt="Avatar">
                        @else
                            <div class="no-avatar">
                                <i class="fas fa-user"></i>
                            </div>
                        @endif
                    </div>
                    <div class="avatar-status"></div>
                </div>
                <div class="profile-info">
                    <h2>{{ auth()->user()->name }}</h2>
                    <span class="profile-info-role">
                        @if(auth()->user()->role === 'seller')
                            <i class="fas fa-store"></i> Penjual Terverifikasi
                        @else
                            <i class="fas fa-shopping-bag"></i> Pembeli Aktif
                        @endif
                    </span>
                    <p><i class="fas fa-envelope"></i> {{ auth()->user()->email }}</p>
                </div>
            </div>
        </div>

        <!-- Wave Divider -->
        <div class="wave-divider">
            <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z" class="shape-fill"></path>
            </svg>
        </div>
    </div>

    <!-- Profile Main Content -->
    <div class="profile-main">
        <div class="container">
            <div class="profile-container">
                <!-- Tabs -->
                <div class="profile-tabs">
                    <button class="profile-tab active" onclick="switchTab('information', this)">
                        <i class="fas fa-id-card"></i>
                        <span>Informasi Profil</span>
                    </button>
                    <button class="profile-tab" onclick="switchTab('password', this)">
                        <i class="fas fa-shield-alt"></i>
                        <span>Keamanan</span>
                    </button>
                </div>

                <!-- Tab Content -->
                <div class="profile-content">
                    @if(session('success'))
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle"></i>
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ session('error') }}
                        </div>
                    @endif

                    <!-- Information Tab -->
                    <div id="information" class="profile-section active">
                        <div class="info-grid">
                            <div class="info-card">
                                <div class="info-card-icon">
                                    <i class="fas fa-user"></i>
                                </div>
                                <span class="info-label">Nama Lengkap</span>
                                <p class="info-value">{{ auth()->user()->name }}</p>
                            </div>

                            <div class="info-card">
                                <div class="info-card-icon">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <span class="info-label">Alamat Email</span>
                                <p class="info-value">{{ auth()->user()->email }}</p>
                            </div>

                            <div class="info-card">
                                <div class="info-card-icon">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <span class="info-label">Nomor Telepon</span>
                                <p class="info-value">{{ auth()->user()->phone ?? 'Belum diisi' }}</p>
                            </div>

                            <div class="info-card">
                                <div class="info-card-icon">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <span class="info-label">Alamat</span>
                                <p class="info-value">{{ auth()->user()->address ?? 'Belum diisi' }}</p>
                            </div>

                            <div class="info-card">
                                <div class="info-card-icon">
                                    <i class="fas fa-user-tag"></i>
                                </div>
                                <span class="info-label">Peran Akun</span>
                                <p class="info-value">
                                    @if(auth()->user()->role === 'seller')
                                        <span class="badge badge-seller"><i class="fas fa-store me-1"></i> Penjual</span>
                                    @else
                                        <span class="badge badge-buyer"><i class="fas fa-shopping-bag me-1"></i> Pembeli</span>
                                    @endif
                                </p>
                            </div>

                            <div class="info-card">
                                <div class="info-card-icon">
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                                <span class="info-label">Bergabung Sejak</span>
                                <p class="info-value">{{ auth()->user()->created_at->format('d M Y') }}</p>
                            </div>
                        </div>

                        <div class="profile-actions">
                            <a href="{{ route('profile.edit') }}" class="action-button">
                                <i class="fas fa-edit"></i>
                                Edit Profil
                            </a>
                        </div>
                    </div>

                    <!-- Password Tab -->
                    <div id="password" class="profile-section">
                        <div class="password-form">
                            <form method="POST" action="{{ route('profile.password') }}">
                                @csrf
                                @method('PUT')

                                <div class="form-group">
                                    <label for="current_password" class="form-label">
                                        <i class="fas fa-lock"></i> Password Saat Ini
                                    </label>
                                    <div class="password-wrapper">
                                        <input type="password" 
                                               class="form-control @error('current_password') is-invalid @enderror" 
                                               id="current_password" 
                                               name="current_password" 
                                               required
                                               placeholder="Masukkan password saat ini">
                                        <button type="button" class="password-toggle" onclick="togglePassword('current_password')">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    @error('current_password')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="password" class="form-label">
                                        <i class="fas fa-key"></i> Password Baru
                                    </label>
                                    <div class="password-wrapper">
                                        <input type="password" 
                                               class="form-control @error('password') is-invalid @enderror" 
                                               id="password" 
                                               name="password" 
                                               required
                                               placeholder="Masukkan password baru">
                                        <button type="button" class="password-toggle" onclick="togglePassword('password')">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    @error('password')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                    <div class="form-hint">
                                        <i class="fas fa-info-circle"></i>
                                        Minimal 8 karakter, kombinasi huruf dan angka
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="password_confirmation" class="form-label">
                                        <i class="fas fa-check-circle"></i> Konfirmasi Password
                                    </label>
                                    <div class="password-wrapper">
                                        <input type="password" 
                                               class="form-control" 
                                               id="password_confirmation" 
                                               name="password_confirmation" 
                                               required
                                               placeholder="Ulangi password baru">
                                        <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation')">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="profile-actions">
                                    <button type="submit" class="action-button">
                                        <i class="fas fa-save"></i>
                                        Ubah Password
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function switchTab(tab, element) {
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
    element.classList.add('active');
}

function togglePassword(inputId) {
    const input = document.getElementById(inputId);
    const button = input.nextElementSibling;
    const icon = button.querySelector('i');
    
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}

// Add ripple effect to buttons
document.querySelectorAll('.action-button').forEach(button => {
    button.addEventListener('click', function(e) {
        const ripple = document.createElement('span');
        const rect = this.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;
        
        ripple.style.cssText = `
            position: absolute;
            background: rgba(255,255,255,0.3);
            border-radius: 50%;
            width: 100px;
            height: 100px;
            left: ${x - 50}px;
            top: ${y - 50}px;
            transform: scale(0);
            animation: ripple 0.6s ease-out;
            pointer-events: none;
        `;
        
        this.appendChild(ripple);
        setTimeout(() => ripple.remove(), 600);
    });
});

// Add animation keyframe for ripple
const style = document.createElement('style');
style.textContent = `
    @keyframes ripple {
        to {
            transform: scale(4);
            opacity: 0;
        }
    }
`;
document.head.appendChild(style);

// Animate info cards on scroll
const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry, index) => {
        if (entry.isIntersecting) {
            entry.target.style.animationDelay = `${index * 0.1}s`;
            entry.target.classList.add('animate-in');
        }
    });
}, { threshold: 0.1 });

document.querySelectorAll('.info-card').forEach(card => {
    card.style.opacity = '0';
    card.style.transform = 'translateY(20px)';
    observer.observe(card);
});

// Add animate-in styles
const animateStyle = document.createElement('style');
animateStyle.textContent = `
    .info-card.animate-in {
        animation: cardSlideIn 0.5s ease forwards;
    }
    @keyframes cardSlideIn {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
`;
document.head.appendChild(animateStyle);
</script>
@endsection
