@extends('layouts.app')

@section('title', 'Login - PestiMart')

@section('content')
<style>
    * {
        box-sizing: border-box;
    }

    .login-container {
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 2rem 0;
        position: relative;
        overflow: hidden;
        background: linear-gradient(135deg, #f0f7ff 0%, #ffffff 50%, #e8f1f8 100%);
    }
    
    /* Animated Background */
    .login-container::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: 
            radial-gradient(circle at 20% 20%, rgba(30, 58, 95, 0.05) 0%, transparent 50%),
            radial-gradient(circle at 80% 80%, rgba(61, 106, 159, 0.05) 0%, transparent 50%),
            radial-gradient(circle at 40% 60%, rgba(30, 58, 95, 0.03) 0%, transparent 40%);
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
        background: linear-gradient(135deg, #1e3a5f, #3d6a9f);
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
    
    @keyframes particleFloat {
        0%, 100% { transform: translate(0, 0) rotate(0deg); opacity: 0.15; }
        25% { transform: translate(30px, -30px) rotate(90deg); opacity: 0.25; }
        50% { transform: translate(-20px, 20px) rotate(180deg); opacity: 0.1; }
        75% { transform: translate(25px, 10px) rotate(270deg); opacity: 0.2; }
    }

    .login-logo {
        text-align: center;
        margin-bottom: 2rem;
        position: relative;
        z-index: 1;
        animation: logoEnter 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
    }
    
    @keyframes logoEnter {
        0% { opacity: 0; transform: translateY(-30px) scale(0.8); }
        100% { opacity: 1; transform: translateY(0) scale(1); }
    }

    .login-logo img {
        width: clamp(70px, 15vw, 100px);
        height: auto;
        filter: drop-shadow(0 4px 15px rgba(30, 58, 95, 0.3));
        animation: logoFloat 4s ease-in-out infinite;
    }
    
    @keyframes logoFloat {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-8px); }
    }

    .login-card {
        background: linear-gradient(145deg, #a7bed3 0%, #8fafc8 100%);
        border-radius: 20px;
        box-shadow: 
            0 20px 60px rgba(30, 58, 95, 0.2),
            0 0 0 1px rgba(255, 255, 255, 0.3) inset;
        width: 100%;
        max-width: 500px;
        padding: clamp(25px, 5vw, 45px);
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
    .login-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
        animation: cardShimmer 3s infinite;
        pointer-events: none;
    }
    
    @keyframes cardShimmer {
        0% { left: -100%; }
        50%, 100% { left: 100%; }
    }

    .login-card:hover {
        box-shadow: 
            0 25px 70px rgba(30, 58, 95, 0.25),
            0 0 0 1px rgba(255, 255, 255, 0.4) inset;
        transform: translateY(-5px);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .card-title {
        text-align: center;
        color: white;
        font-weight: bold;
        font-size: clamp(22px, 2.5vw, 30px);
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        animation: titlePulse 2s ease-in-out infinite;
    }
    
    @keyframes titlePulse {
        0%, 100% { text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2); }
        50% { text-shadow: 0 4px 20px rgba(30, 58, 95, 0.4); }
    }
    
    .card-title i {
        animation: iconBounce 2s ease-in-out infinite;
    }
    
    @keyframes iconBounce {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.15); }
    }

    .form-group {
        text-align: left;
        margin-bottom: 1.5rem;
        animation: formGroupEnter 0.5s ease forwards;
        opacity: 0;
        transform: translateX(-20px);
    }
    
    .form-group:nth-child(1) { animation-delay: 0.3s; }
    .form-group:nth-child(2) { animation-delay: 0.4s; }
    
    @keyframes formGroupEnter {
        0% { opacity: 0; transform: translateX(-20px); }
        100% { opacity: 1; transform: translateX(0); }
    }

    .form-label {
        display: block;
        margin-bottom: 0.5rem;
        color: #0a1b33;
        font-size: clamp(13px, 1.5vw, 15px);
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .input-group {
        display: flex;
        flex-direction: row-reverse;
        border: none;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(30, 58, 95, 0.15);
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    
    .input-group:focus-within {
        transform: translateY(-3px) scale(1.02);
        box-shadow: 0 8px 25px rgba(30, 58, 95, 0.25);
    }

    .form-control {
        width: 100%;
        padding: 14px 15px;
        border: none;
        background: linear-gradient(135deg, #3d6a9f 0%, #2d5080 100%);
        color: white;
        font-size: clamp(14px, 1.5vw, 16px);
        outline: none;
        transition: all 0.3s ease;
        border-left: 1px solid rgba(255, 255, 255, 0.1);
    }

    .form-control::placeholder {
        color: rgba(255, 255, 255, 0.7);
    }

    .form-control:focus {
        background: linear-gradient(135deg, #4a7ab3 0%, #3d6a9f 100%);
        box-shadow: inset 0 0 0 2px rgba(255, 255, 255, 0.15);
    }
    
    .input-group-text {
        background: linear-gradient(135deg, #3d6a9f 0%, #2d5080 100%);
        color: white;
        border: none;
        padding: 14px 15px;
        font-size: clamp(14px, 1.5vw, 16px);
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 55px;
        transition: all 0.3s ease;
    }
    
    .input-group:focus-within .input-group-text {
        background: linear-gradient(135deg, #4a7ab3 0%, #3d6a9f 100%);
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

    .form-check {
        margin-bottom: 1.5rem;
        margin-top: 0.5rem;
        animation: formGroupEnter 0.5s 0.5s ease forwards;
        opacity: 0;
    }

    .form-check-input {
        cursor: pointer;
        background-color: #3d6a9f;
        border: 2px solid #2d5080;
        transition: all 0.3s ease;
        width: 18px;
        height: 18px;
    }

    .form-check-input:checked {
        background-color: #1e3a5f;
        border-color: #1e3a5f;
        animation: checkPop 0.3s ease;
    }
    
    @keyframes checkPop {
        0% { transform: scale(1); }
        50% { transform: scale(1.2); }
        100% { transform: scale(1); }
    }

    .form-check-label {
        color: #0a1b33;
        font-size: clamp(13px, 1.5vw, 15px);
        cursor: pointer;
        margin-left: 0.5rem;
        font-weight: 500;
    }

    .btn-login {
        background: linear-gradient(135deg, #1e3a5f 0%, #2d5a87 100%);
        color: white;
        border: none;
        padding: 14px 25px;
        border-radius: 10px;
        cursor: pointer;
        font-weight: bold;
        font-size: clamp(14px, 1.6vw, 16px);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        width: 100%;
        position: relative;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(30, 58, 95, 0.3);
        animation: formGroupEnter 0.5s 0.6s ease forwards;
        opacity: 0;
    }
    
    .btn-login::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s ease;
    }
    
    .btn-login:hover::before {
        left: 100%;
    }

    .btn-login:hover {
        background: linear-gradient(135deg, #2d5a87 0%, #3d6a9f 100%);
        transform: translateY(-4px) scale(1.02);
        box-shadow: 0 8px 30px rgba(30, 58, 95, 0.4);
    }

    .btn-login:active {
        transform: translateY(-2px) scale(1.01);
    }
    
    /* Ripple Effect */
    .btn-login .ripple {
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

    .divider {
        display: flex;
        align-items: center;
        margin: 2rem 0;
        gap: 1rem;
        animation: formGroupEnter 0.5s 0.7s ease forwards;
        opacity: 0;
    }

    .divider::before,
    .divider::after {
        content: '';
        flex: 1;
        height: 2px;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
    }

    .divider span {
        color: #0a1b33;
        font-size: clamp(12px, 1.4vw, 14px);
        font-weight: 600;
        padding: 5px 15px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 20px;
    }

    .register-links {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
        animation: formGroupEnter 0.5s 0.8s ease forwards;
        opacity: 0;
    }

    .register-links a {
        display: block;
        padding: 14px 0;
        text-align: center;
        text-decoration: none;
        color: white;
        border-radius: 10px;
        font-weight: bold;
        font-size: clamp(13px, 1.5vw, 15px);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        position: relative;
        overflow: hidden;
    }
    
    .register-links a::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.15), transparent);
        transition: left 0.5s ease;
    }
    
    .register-links a:hover::before {
        left: 100%;
    }

    .register-links a:hover {
        transform: translateY(-3px) scale(1.02);
    }

    .btn-register-buyer {
        background: linear-gradient(135deg, #1e3a5f 0%, #2d5a87 100%);
        box-shadow: 0 4px 15px rgba(30, 58, 95, 0.25);
    }

    .btn-register-buyer:hover {
        background: linear-gradient(135deg, #2d5a87 0%, #3d6a9f 100%);
        box-shadow: 0 8px 25px rgba(30, 58, 95, 0.35);
    }

    .btn-register-seller {
        background: linear-gradient(135deg, #FF8F3A 0%, #f5700a 100%);
        box-shadow: 0 4px 15px rgba(255, 143, 58, 0.25);
    }

    .btn-register-seller:hover {
        background: linear-gradient(135deg, #f5700a 0%, #e66000 100%);
        box-shadow: 0 8px 25px rgba(255, 143, 58, 0.35);
    }

    .invalid-feedback {
        color: #fff3cd;
        font-size: clamp(12px, 1.4vw, 13px);
        margin-top: 0.5rem;
        display: block;
        animation: fadeIn 0.3s ease;
    }
    
    @keyframes fadeIn {
        0% { opacity: 0; transform: translateY(-5px); }
        100% { opacity: 1; transform: translateY(0); }
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

    /* Responsive Design */
    @media (max-width: 600px) {
        .login-card {
            padding: 25px;
            margin: 0 15px;
            border-radius: 16px;
        }

        .card-title {
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .register-links {
            gap: 0.6rem;
        }

        .register-links a {
            padding: 12px 0;
        }
    }

    @media (max-width: 400px) {
        .login-container {
            padding: 1rem;
        }

        .login-card {
            padding: 20px;
            margin: 0;
            border-radius: 14px;
        }
        
        .login-logo img {
            width: 60px;
        }

        .card-title {
            font-size: 1.3rem;
            gap: 0.5rem;
        }

        .form-label {
            font-size: 12px;
        }

        .form-control,
        .input-group-text {
            padding: 12px;
            font-size: 14px;
        }

        .btn-login {
            padding: 12px 20px;
        }
    }

    @media (max-height: 500px) {
        .login-container {
            justify-content: flex-start;
            padding-top: 2rem;
        }

        .login-logo {
            margin-bottom: 1rem;
        }

        .card-title {
            margin-bottom: 1rem;
        }
    }
</style>

<div class="login-container">
    <!-- Floating Particles -->
    <div class="floating-particles">
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
    </div>

    <!-- Logo Section -->
    <div class="login-logo">
        <img src="{{ asset('images/landing/logo-pestimart.png') }}" alt="PestiMart Logo">
    </div>

    <!-- Login Card -->
    <div class="login-card">
        <h5 class="card-title">
            <i class="fas fa-sign-in-alt"></i>Selamat Datang
        </h5>
        
        <form method="POST" action="{{ route('login') }}" id="loginForm">
            @csrf
            
            <!-- Email Input -->
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
                        autofocus 
                        placeholder="Masukkan email Anda">
                    <span class="input-group-text">
                        <i class="fas fa-envelope"></i>
                    </span>
                </div>
                @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            
            <!-- Password Input -->
            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <div class="input-group">
                    <input 
                        type="password" 
                        class="form-control @error('password') is-invalid @enderror" 
                        id="password" 
                        name="password" 
                        required 
                        placeholder="Masukkan password Anda">
                    <span class="input-group-text">
                        <i class="fas fa-lock"></i>
                    </span>
                </div>
                @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            
            <!-- Remember Me -->
            <div class="form-check">
                <input 
                    type="checkbox" 
                    class="form-check-input" 
                    id="remember" 
                    name="remember">
                <label class="form-check-label" for="remember">
                    Ingat saya
                </label>
            </div>
            
            <!-- Login Button -->
            <button type="submit" class="btn-login" id="btnLogin">
                <i class="fas fa-arrow-right me-2"></i>Masuk Sekarang
            </button>
        </form>
        
        <!-- Divider -->
        <div class="divider">
            <span>atau daftar</span>
        </div>
        
        <!-- Register Links -->
        <div class="register-links">
            <a href="{{ route('register.buyer') }}" class="btn-register-buyer">
                <i class="fas fa-user me-2"></i>Daftar Sebagai Pembeli
            </a>
            <a href="{{ route('register.seller') }}" class="btn-register-seller">
                <i class="fas fa-store me-2"></i>Daftar Sebagai Penjual
            </a>
        </div>
    </div>
</div>

<script>
    // Button Ripple Effect
    document.getElementById('btnLogin').addEventListener('click', function(e) {
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
                label.style.color = '#1e3a5f';
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
    
    // Register buttons ripple
    document.querySelectorAll('.register-links a').forEach(btn => {
        btn.addEventListener('click', function(e) {
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
    });
</script>
@endsection
