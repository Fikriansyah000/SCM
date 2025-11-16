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
        background-color: white;
    }

    .login-logo {
        text-align: center;
        margin-bottom: 2rem;
    }

    .login-logo img {
        width: clamp(60px, 15vw, 100px);
        height: auto;
    }

    .login-card {
        background-color: #a6bdd5;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        width: 100%;
        max-width: 600px;
        padding: clamp(20px, 5vw, 40px);
        transition: all 0.3s ease;
    }

    .login-card:hover {
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
    }

    .card-title {
        text-align: center;
        color: white;
        font-weight: 600;
        font-size: clamp(18px, 2.5vw, 26px);
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
    }

    .form-group {
        text-align: left;
        margin-bottom: 1.5rem;
    }

    .form-label {
        display: block;
        margin-bottom: 0.5rem;
        color: black;
        font-size: clamp(13px, 1.5vw, 15px);
        font-weight: 500;
    }

    .input-group {
        display: flex;
        flex-direction: row-reverse;
        border: none;
        border-radius: 5px;
        overflow: hidden;
    }

    .form-control {
        width: 100%;
        padding: 10px 12px;
        border: none;
        background-color: #5273a1;
        color: white;
        font-size: clamp(13px, 1.5vw, 15px);
        outline: none;
        transition: all 0.2s ease;
        border-left: 1px solid #4a5f8f;
    }

    .form-control::placeholder {
        color: rgba(255, 255, 255, 0.7);
    }

    .form-control:focus {
        background-color: #6e8bb4;
        box-shadow: inset 0 0 0 2px rgba(255, 255, 255, 0.2);
    }
    .input-group-text {
        background: #5273a1;
        color: white;
        border: none;
        padding: 10px 12px;
        font-size: clamp(13px, 1.5vw, 15px);
        display: flex;
        align-items: center;
        justify-content: center;
        width: 50px;
        margin-right: 10px;
    }

    .input-group-text i {
        opacity: 0.8;
    }

    .form-check {
        margin-bottom: 1rem;
        margin-top: -0.5rem;
    }

    .form-check-input {
        cursor: pointer;
        background-color: #5273a1;
        border: 1px solid #4a5f8f;
        transition: all 0.2s ease;
    }

    .form-check-input:checked {
        background-color: #0a4c8c;
        border-color: #0a4c8c;
    }

    .form-check-label {
        color: black;
        font-size: clamp(13px, 1.5vw, 15px);
        cursor: pointer;
        margin-left: 0.5rem;
    }

    .btn-login {
        background-color: #0a4c8c;
        color: white;
        border: none;
        padding: 10px 25px;
        border-radius: 5px;
        cursor: pointer;
        font-weight: 600;
        font-size: clamp(13px, 1.6vw, 15px);
        transition: all 0.3s ease;
        width: 100%;
    }

    .btn-login:hover {
        background-color: #083b6d;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .btn-login:active {
        transform: translateY(0);
    }

    .divider {
        display: flex;
        align-items: center;
        margin: 2rem 0;
        gap: 1rem;
    }

    .divider::before,
    .divider::after {
        content: '';
        flex: 1;
        height: 1px;
        background: rgba(0, 0, 0, 0.2);
    }

    .divider span {
        color: black;
        font-size: clamp(12px, 1.4vw, 14px);
        font-weight: 500;
    }

    .register-links {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .register-links a {
        display: block;
        padding: 12px 0;
        text-align: center;
        text-decoration: none;
        color: white;
        border-radius: 5px;
        font-weight: 600;
        font-size: clamp(13px, 1.5vw, 15px);
        transition: all 0.3s ease;
    }

    .register-links a:hover {
        transform: translateY(-2px);
    }

    .btn-register-buyer {
        background: linear-gradient(135deg, #0a4c8c 0%, #083b6d 100%);
    }

    .btn-register-buyer:hover {
        background: linear-gradient(135deg, #083b6d 0%, #062850 100%);
        box-shadow: 0 4px 12px rgba(10, 76, 140, 0.3);
    }

    .btn-register-seller {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    }

    .btn-register-seller:hover {
        background: linear-gradient(135deg, #f5576c 0%, #f093fb 100%);
        box-shadow: 0 4px 12px rgba(245, 87, 108, 0.3);
    }

    .invalid-feedback {
        color: #fff3cd;
        font-size: clamp(12px, 1.4vw, 13px);
        margin-top: 0.25rem;
        display: block;
    }

    .form-control.is-invalid {
        background-color: #c41e3a;
        border-color: #c41e3a;
    }

    .form-control.is-invalid:focus {
        background-color: #a01830;
    }

    /* Responsive Design */
    @media (max-width: 600px) {
        .login-card {
            padding: 20px;
            margin: 0 15px;
        }

        .card-title {
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .register-links {
            gap: 0.5rem;
        }

        .register-links a {
            padding: 10px 0;
        }
    }

    @media (max-width: 400px) {
        .login-container {
            padding: 1rem;
        }

        .login-card {
            padding: 15px;
            margin: 0;
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
            padding: 8px 10px;
            font-size: 13px;
        }

        .btn-login {
            padding: 8px 20px;
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
    <!-- Logo Section -->
    <div class="login-logo">
        <img src="{{ asset('images/logo-pestimart.png') }}" alt="PestiMart Logo">
    </div>

    <!-- Login Card -->
    <div class="login-card">
        <h5 class="card-title">
            <i class="fas fa-sign-in-alt"></i>Login
        </h5>
        
        <form method="POST" action="{{ route('login') }}">
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
            <button type="submit" class="btn-login">
                <i class="fas fa-arrow-right me-2"></i>Login
            </button>
        </form>
        
        <!-- Divider -->
        <div class="divider">
            <span>atau</span>
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
@endsection
