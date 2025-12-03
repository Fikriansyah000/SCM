@extends('layouts.app')

@section('title', 'Daftar Penjual - PestiMart')

@section('content')
<style>
    * {
        box-sizing: border-box;
    }

    body {
        font-family: 'Arial', sans-serif;
        background-color: #ffffff;
    }

    .register-container {
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 2rem 0;
        position: relative;
        overflow: hidden;
        background: linear-gradient(135deg, #fff5eb 0%, #ffffff 50%, #fff0e0 100%);
    }
    
    /* Animated Background */
    .register-container::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: 
            radial-gradient(circle at 20% 20%, rgba(255, 143, 58, 0.05) 0%, transparent 50%),
            radial-gradient(circle at 80% 80%, rgba(245, 112, 10, 0.05) 0%, transparent 50%),
            radial-gradient(circle at 40% 60%, rgba(255, 143, 58, 0.03) 0%, transparent 40%);
        animation: bgFloat 20s ease-in-out infinite;
        pointer-events: none;
    }
    
    @keyframes bgFloat {
        0%, 100% { transform: translate(0, 0) scale(1); }
        25% { transform: translate(-20px, 10px) scale(1.02); }
        50% { transform: translate(10px, -15px) scale(1); }
        75% { transform: translate(-10px, -10px) scale(1.01); }
    }
    
    /* Floating Particles */
    .floating-particles {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
        overflow: hidden;
    }
    
    .particle {
        position: absolute;
        width: 10px;
        height: 10px;
        background: linear-gradient(135deg, #FF8F3A, #f5700a);
        border-radius: 50%;
        opacity: 0.15;
        animation: particleFloat 15s infinite ease-in-out;
    }
    
    .particle:nth-child(1) { left: 10%; top: 20%; animation-delay: 0s; animation-duration: 12s; }
    .particle:nth-child(2) { left: 20%; top: 80%; animation-delay: 2s; animation-duration: 14s; width: 15px; height: 15px; }
    .particle:nth-child(3) { left: 60%; top: 10%; animation-delay: 4s; animation-duration: 16s; width: 8px; height: 8px; }
    .particle:nth-child(4) { left: 80%; top: 40%; animation-delay: 1s; animation-duration: 13s; }
    .particle:nth-child(5) { left: 90%; top: 70%; animation-delay: 3s; animation-duration: 15s; width: 12px; height: 12px; }
    .particle:nth-child(6) { left: 5%; top: 50%; animation-delay: 5s; animation-duration: 11s; width: 6px; height: 6px; }
    .particle:nth-child(7) { left: 70%; top: 90%; animation-delay: 2.5s; animation-duration: 17s; }
    .particle:nth-child(8) { left: 40%; top: 5%; animation-delay: 1.5s; animation-duration: 14s; width: 14px; height: 14px; }
    
    @keyframes particleFloat {
        0%, 100% { transform: translate(0, 0) rotate(0deg); opacity: 0.15; }
        25% { transform: translate(30px, -30px) rotate(90deg); opacity: 0.25; }
        50% { transform: translate(-20px, 20px) rotate(180deg); opacity: 0.1; }
        75% { transform: translate(25px, 10px) rotate(270deg); opacity: 0.2; }
    }

    .register-logo {
        text-align: center;
        margin-bottom: 1.5rem;
        position: relative;
        z-index: 1;
        animation: logoEnter 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
    }
    
    @keyframes logoEnter {
        0% { opacity: 0; transform: translateY(-30px) scale(0.8); }
        100% { opacity: 1; transform: translateY(0) scale(1); }
    }

    .register-logo img {
        width: clamp(60px, 12vw, 90px);
        height: auto;
        display: block;
        margin: 0 auto;
        filter: drop-shadow(0 4px 15px rgba(255, 143, 58, 0.3));
        animation: logoFloat 4s ease-in-out infinite;
    }
    
    @keyframes logoFloat {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-8px); }
    }

    .register-card {
        background: linear-gradient(145deg, #ffe4cc 0%, #ffd4b3 100%);
        width: 100%;
        max-width: 520px;
        border-radius: 20px;
        padding: clamp(25px, 5vw, 45px);
        box-shadow: 
            0 20px 60px rgba(255, 143, 58, 0.2),
            0 0 0 1px rgba(255, 255, 255, 0.5) inset;
        margin: 0 15px;
        position: relative;
        z-index: 1;
        animation: cardEnter 0.8s 0.2s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
        opacity: 0;
        transform: translateY(40px);
        overflow: hidden;
    }
    
    @keyframes cardEnter {
        0% { opacity: 0; transform: translateY(40px) scale(0.95); }
        100% { opacity: 1; transform: translateY(0) scale(1); }
    }
    
    /* Card Shimmer Effect */
    .register-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        animation: cardShimmer 3s infinite;
        pointer-events: none;
    }
    
    @keyframes cardShimmer {
        0% { left: -100%; }
        50%, 100% { left: 100%; }
    }

    .register-card:hover {
        box-shadow: 
            0 25px 70px rgba(255, 143, 58, 0.25),
            0 0 0 1px rgba(255, 255, 255, 0.6) inset;
        transform: translateY(-5px);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .card-title {
        text-align: center;
        color: #d35400;
        font-weight: bold;
        font-size: clamp(20px, 2.5vw, 28px);
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
        text-shadow: 0 2px 10px rgba(255, 143, 58, 0.2);
        animation: titlePulse 2s ease-in-out infinite;
    }
    
    @keyframes titlePulse {
        0%, 100% { text-shadow: 0 2px 10px rgba(255, 143, 58, 0.2); }
        50% { text-shadow: 0 4px 20px rgba(255, 143, 58, 0.4); }
    }
    
    .card-title i {
        animation: iconBounce 2s ease-in-out infinite;
        color: #FF8F3A;
    }
    
    @keyframes iconBounce {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.1); }
    }

    .register-subtitle {
        text-align: center;
        color: #8b5a2b;
        font-size: clamp(13px, 1.5vw, 16px);
        margin-bottom: 2rem;
        font-weight: 500;
        opacity: 0.9;
    }

    .toggle {
        display: flex;
        justify-content: center;
        background-color: rgba(255, 143, 58, 0.2);
        border-radius: 10px;
        overflow: hidden;
        margin-bottom: 2rem;
        box-shadow: 0 4px 15px rgba(255, 143, 58, 0.15);
    }

    .toggle button {
        flex: 1;
        padding: 12px 0;
        border: none;
        color: #d35400;
        font-weight: bold;
        background-color: transparent;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: clamp(12px, 1.5vw, 14px);
    }

    .toggle .active {
        background: linear-gradient(135deg, #FF8F3A 0%, #f5700a 100%);
        border-radius: 8px;
        color: white;
    }

    .toggle button:hover:not(.active) {
        background-color: rgba(255, 143, 58, 0.3);
    }

    form {
        text-align: left;
    }

    .form-group {
        margin-bottom: 1.5rem;
        animation: formGroupEnter 0.5s ease forwards;
        opacity: 0;
        transform: translateX(-20px);
    }
    
    .form-group:nth-child(1) { animation-delay: 0.3s; }
    .form-group:nth-child(2) { animation-delay: 0.4s; }
    .form-group:nth-child(3) { animation-delay: 0.5s; }
    .form-group:nth-child(4) { animation-delay: 0.6s; }
    .form-group:nth-child(5) { animation-delay: 0.7s; }
    
    @keyframes formGroupEnter {
        0% { opacity: 0; transform: translateX(-20px); }
        100% { opacity: 1; transform: translateX(0); }
    }

    .form-label {
        display: block;
        color: #8b5a2b;
        font-size: clamp(12px, 1.5vw, 14px);
        font-weight: bold;
        margin-bottom: 0.5rem;
        margin-left: 5px;
        transition: all 0.3s ease;
    }

    .input-group {
        display: flex;
        flex-direction: row-reverse;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(255, 143, 58, 0.15);
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    
    .input-group:focus-within {
        transform: translateY(-3px) scale(1.02);
        box-shadow: 0 8px 25px rgba(255, 143, 58, 0.25);
    }
    
    .input-group:focus-within .form-label {
        color: #d35400;
    }

    .form-control {
        width: 100%;
        padding: 12px 15px;
        border: none;
        background: linear-gradient(135deg, #FF8F3A 0%, #f5700a 100%);
        color: white;
        font-size: clamp(13px, 1.5vw, 15px);
        outline: none;
        transition: all 0.3s ease;
        border-left: 1px solid rgba(255, 255, 255, 0.2);
    }

    .form-control::placeholder {
        color: rgba(255, 255, 255, 0.7);
    }

    .form-control:focus {
        background: linear-gradient(135deg, #ffa04d 0%, #FF8F3A 100%);
        box-shadow: inset 0 0 0 2px rgba(255, 255, 255, 0.15);
    }

    .input-group-text {
        background: linear-gradient(135deg, #FF8F3A 0%, #f5700a 100%);
        color: white;
        border: none;
        padding: 12px 15px;
        font-size: clamp(14px, 1.5vw, 16px);
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 50px;
        transition: all 0.3s ease;
    }
    
    .input-group:focus-within .input-group-text {
        background: linear-gradient(135deg, #ffa04d 0%, #FF8F3A 100%);
    }
    
    .input-group:focus-within .input-group-text i {
        animation: iconPop 0.3s ease;
    }
    
    @keyframes iconPop {
        0% { transform: scale(1); }
        50% { transform: scale(1.3); }
        100% { transform: scale(1); }
    }

    .input-group-text i {
        opacity: 0.9;
        transition: all 0.3s ease;
    }

    .form-control.is-invalid {
        background: linear-gradient(135deg, #c41e3a 0%, #a01830 100%);
        border-color: #c41e3a;
        animation: shake 0.5s ease;
    }
    
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        20%, 60% { transform: translateX(-5px); }
        40%, 80% { transform: translateX(5px); }
    }

    .form-control.is-invalid:focus {
        background: linear-gradient(135deg, #d32f4a 0%, #c41e3a 100%);
    }

    .invalid-feedback {
        color: #c0392b;
        font-size: clamp(11px, 1.4vw, 13px);
        margin-top: 0.5rem;
        display: block;
        margin-left: 5px;
        animation: fadeIn 0.3s ease;
    }
    
    @keyframes fadeIn {
        0% { opacity: 0; transform: translateY(-5px); }
        100% { opacity: 1; transform: translateY(0); }
    }

    .form-check {
        margin-bottom: 1rem;
    }

    .form-check-input {
        cursor: pointer;
        background-color: #FF8F3A;
        border: 2px solid #f5700a;
        transition: all 0.3s ease;
        width: 18px;
        height: 18px;
    }

    .form-check-input:checked {
        background-color: #d35400;
        border-color: #d35400;
        animation: checkPop 0.3s ease;
    }
    
    @keyframes checkPop {
        0% { transform: scale(1); }
        50% { transform: scale(1.2); }
        100% { transform: scale(1); }
    }

    .form-check-label {
        color: #8b5a2b;
        font-size: clamp(12px, 1.5vw, 14px);
        cursor: pointer;
        margin-left: 0.5rem;
        font-weight: 500;
    }

    .btn-register {
        display: block;
        width: 100%;
        background: linear-gradient(135deg, #d35400 0%, #e67e22 100%);
        color: white;
        border: none;
        border-radius: 10px;
        padding: 14px 0;
        font-weight: bold;
        font-size: clamp(14px, 1.6vw, 16px);
        cursor: pointer;
        margin: 1.5rem 0;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        position: relative;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(211, 84, 0, 0.3);
        animation: formGroupEnter 0.5s 0.8s ease forwards;
        opacity: 0;
    }
    
    .btn-register::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s ease;
    }
    
    .btn-register:hover::before {
        left: 100%;
    }

    .btn-register:hover {
        background: linear-gradient(135deg, #e67e22 0%, #f39c12 100%);
        transform: translateY(-4px) scale(1.02);
        box-shadow: 0 8px 30px rgba(211, 84, 0, 0.4);
    }
    
    .btn-register:active {
        transform: translateY(-2px) scale(1.01);
    }
    
    /* Ripple Effect */
    .btn-register .ripple {
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.4);
        transform: scale(0);
        animation: ripple 0.6s ease-out;
        pointer-events: none;
    }
    
    @keyframes ripple {
        to {
            transform: scale(4);
            opacity: 0;
        }
    }

    .login-link {
        text-align: center;
        margin-top: 2rem;
        padding-top: 1.5rem;
        border-top: 1px solid rgba(211, 84, 0, 0.2);
        animation: formGroupEnter 0.5s 0.9s ease forwards;
        opacity: 0;
    }

    .login-link p {
        color: #8b5a2b;
        font-size: clamp(12px, 1.5vw, 14px);
        margin-bottom: 0.75rem;
        transition: all 0.3s ease;
    }

    .login-link a {
        color: #d35400;
        font-weight: bold;
        text-decoration: none;
        transition: all 0.3s ease;
        position: relative;
    }
    
    .login-link a::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        width: 0;
        height: 2px;
        background: linear-gradient(90deg, #d35400, #e67e22);
        transition: width 0.3s ease;
    }

    .login-link a:hover {
        color: #e67e22;
    }
    
    .login-link a:hover::after {
        width: 100%;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .register-card {
            padding: clamp(20px, 4vw, 35px);
            margin: 0 10px;
            border-radius: 16px;
        }

        .card-title {
            font-size: 1.4rem;
            gap: 0.5rem;
        }

        .toggle {
            margin-bottom: 1.5rem;
        }

        .form-group {
            margin-bottom: 1.2rem;
        }
        
        .form-control,
        .input-group-text {
            padding: 10px 12px;
            font-size: 14px;
        }

        .btn-register {
            padding: 12px 0;
            font-size: 14px;
        }
    }

    @media (max-width: 480px) {
        .register-container {
            padding: 1rem;
        }

        .register-card {
            padding: 20px;
            margin: 0;
            width: 95%;
            border-radius: 14px;
        }

        .register-logo img {
            width: 55px;
        }

        .card-title {
            font-size: 1.25rem;
            gap: 0.5rem;
        }

        .register-subtitle {
            font-size: 12px;
            margin-bottom: 1.5rem;
        }

        .form-label {
            font-size: 12px;
        }

        .form-control,
        .input-group-text {
            padding: 10px;
            font-size: 13px;
        }

        .btn-register {
            padding: 12px 0;
            font-size: 13px;
        }

        .toggle button {
            padding: 10px 0;
            font-size: 12px;
        }
        
        .login-link p {
            font-size: 12px;
        }
    }

    @media (max-height: 600px) {
        .register-container {
            justify-content: flex-start;
            padding-top: 1rem;
        }

        .register-logo {
            margin-bottom: 1rem;
        }
    }
</style>

<!-- Register Container -->
<div class="register-container">
    <!-- Floating Particles -->
    <div class="floating-particles">
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
    </div>

    <!-- Logo Section -->
    <div class="register-logo">
        <img src="{{ asset('images/landing/logo-pestimart.png') }}" alt="PestiMart Logo">
    </div>

    <!-- Register Card -->
    <div class="register-card">
        <!-- Title -->
        <h2 class="card-title">
            <i class="fas fa-store"></i>Daftar Penjual
        </h2>
        <p class="register-subtitle">Buka toko Anda dan mulai berjualan di PestiMart</p>

        <!-- Registration Form -->
        <form method="POST" action="{{ route('register.seller') }}" id="registerForm">
            @csrf

            <!-- Full Name -->
            <div class="form-group">
                <label for="name" class="form-label">Nama Lengkap</label>
                <div class="input-group">
                    <input 
                        type="text" 
                        class="form-control @error('name') is-invalid @enderror"
                        id="name" 
                        name="name" 
                        value="{{ old('name') }}" 
                        required 
                        autofocus
                        placeholder="Masukkan nama lengkap">
                    <span class="input-group-text">
                        <i class="fas fa-user"></i>
                    </span>
                </div>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Email -->
            <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <div class="input-group">
                    <input 
                        type="email" 
                        class="form-control @error('email') is-invalid @enderror"
                        id="email" 
                        name="email" 
                        value="{{ old('email') }}" 
                        required
                        placeholder="Masukkan email Anda">
                    <span class="input-group-text">
                        <i class="fas fa-envelope"></i>
                    </span>
                </div>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Phone -->
            <div class="form-group">
                <label for="phone" class="form-label">Nomor Telepon</label>
                <div class="input-group">
                    <input 
                        type="tel" 
                        class="form-control @error('phone') is-invalid @enderror"
                        id="phone" 
                        name="phone" 
                        value="{{ old('phone') }}" 
                        required
                        placeholder="Masukkan nomor telepon">
                    <span class="input-group-text">
                        <i class="fas fa-phone"></i>
                    </span>
                </div>
                @error('phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password -->
            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <div class="input-group">
                    <input 
                        type="password" 
                        class="form-control @error('password') is-invalid @enderror"
                        id="password" 
                        name="password" 
                        required
                        placeholder="Buat password (minimal 8 karakter)">
                    <span class="input-group-text">
                        <i class="fas fa-lock"></i>
                    </span>
                </div>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div class="form-group">
                <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                <div class="input-group">
                    <input 
                        type="password" 
                        class="form-control"
                        id="password_confirmation" 
                        name="password_confirmation" 
                        required
                        placeholder="Konfirmasi password Anda">
                    <span class="input-group-text">
                        <i class="fas fa-lock"></i>
                    </span>
                </div>
            </div>

            <!-- Register Button -->
            <button type="submit" class="btn-register" id="btnRegister">
                <i class="fas fa-store me-2"></i>Buka Toko Sekarang
            </button>
        </form>

        <!-- Login Links -->
        <div class="login-link">
            <p>
                Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a>
            </p>
            <p>
                Ingin membeli? <a href="{{ route('register.buyer') }}">Daftar sebagai pembeli</a>
            </p>
        </div>
    </div>
</div>

<script>
    // Button Ripple Effect
    document.getElementById('btnRegister').addEventListener('click', function(e) {
        const ripple = document.createElement('span');
        ripple.classList.add('ripple');
        
        const rect = this.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;
        
        ripple.style.left = x + 'px';
        ripple.style.top = y + 'px';
        
        this.appendChild(ripple);
        
        setTimeout(() => ripple.remove(), 600);
    });
    
    // Input Focus Animation
    document.querySelectorAll('.form-control').forEach(input => {
        input.addEventListener('focus', function() {
            const label = this.closest('.form-group').querySelector('.form-label');
            if (label) {
                label.style.color = '#d35400';
                label.style.transform = 'translateX(5px)';
            }
        });
        
        input.addEventListener('blur', function() {
            const label = this.closest('.form-group').querySelector('.form-label');
            if (label) {
                label.style.color = '';
                label.style.transform = '';
            }
        });
    });
</script>
@endsection
