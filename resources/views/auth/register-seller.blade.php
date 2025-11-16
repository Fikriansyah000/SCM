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
    }

    .register-logo {
        text-align: center;
        margin-bottom: 1.5rem;
    }

    .register-logo img {
        width: clamp(50px, 12vw, 80px);
        height: auto;
    }

    .register-card {
        background-color: #a7bed3;
        width: 100%;
        max-width: 1000px;
        border-radius: 10px;
        padding: clamp(20px, 5vw, 40px);
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .register-card:hover {
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
    }

    .card-title {
        text-align: center;
        color: #ffffff;
        font-weight: bold;
        font-size: clamp(18px, 2.5vw, 26px);
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
    }

    .register-subtitle {
        text-align: center;
        color: #0a1b33;
        font-size: clamp(12px, 1.5vw, 15px);
        margin-bottom: 2rem;
        font-weight: 500;
    }

    .toggle {
        display: flex;
        justify-content: center;
        background-color: #6d93c0;
        border-radius: 5px;
        overflow: hidden;
        margin-bottom: 2rem;
    }

    .toggle button {
        flex: 1;
        padding: 10px 0;
        border: none;
        color: #fff;
        font-weight: bold;
        background-color: transparent;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: clamp(12px, 1.5vw, 14px);
    }

    .toggle .active {
        background-color: #3d6a9f;
        border-radius: 5px;
    }

    .toggle button:hover {
        background-color: rgba(61, 106, 159, 0.7);
    }

    form {
        text-align: left;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        display: block;
        color: #0a1b33;
        font-size: clamp(12px, 1.5vw, 14px);
        font-weight: bold;
        margin-bottom: 0.5rem;
        margin-left: 5px;
    }

    .input-group {
        display: flex;
        flex-direction: row-reverse;
        border-radius: 5px;
        overflow: hidden;
    }

    .form-control {
        width: 100%;
        padding: 10px 12px;
        border: none;
        background-color: #3d6a9f;
        color: white;
        font-size: clamp(12px, 1.5vw, 14px);
        outline: none;
        transition: all 0.2s ease;
        border-left: 1px solid #2d5080;
    }

    .form-control::placeholder {
        color: #e0e0e0;
    }

    .form-control:focus {
        background-color: #4a7ab3;
        box-shadow: inset 0 0 0 2px rgba(255, 255, 255, 0.1);
    }

    .input-group-text {
        background-color: #3d6a9f;
        color: white;
        border: none;
        padding: 10px 12px;
        font-size: clamp(12px, 1.5vw, 14px);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 10px;
    }

    .input-group-text i {
        opacity: 0.8;
    }

    .form-control.is-invalid {
        background-color: #c41e3a;
        border-color: #c41e3a;
    }

    .form-control.is-invalid:focus {
        background-color: #a01830;
    }

    .invalid-feedback {
        color: #fff3cd;
        font-size: clamp(11px, 1.4vw, 13px);
        margin-top: 0.25rem;
        display: block;
        margin-left: 5px;
    }

    .form-check {
        margin-bottom: 1rem;
    }

    .form-check-input {
        cursor: pointer;
        background-color: #3d6a9f;
        border: 1px solid #2d5080;
        transition: all 0.2s ease;
    }

    .form-check-input:checked {
        background-color: #1c4e80;
        border-color: #1c4e80;
    }

    .form-check-label {
        color: #0a1b33;
        font-size: clamp(12px, 1.5vw, 14px);
        cursor: pointer;
        margin-left: 0.5rem;
    }

    .btn-register {
        display: block;
        width: 100%;
        background-color: #1c4e80;
        color: white;
        border: none;
        border-radius: 7px;
        padding: 12px 0;
        font-weight: bold;
        font-size: clamp(13px, 1.6vw, 15px);
        cursor: pointer;
        margin: 1rem 0;
        transition: all 0.3s ease;
    }

    .btn-register:hover {
        background-color: #163e66;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .btn-register:active {
        transform: translateY(0);
    }

    .login-link {
        text-align: center;
        margin-top: 2rem;
        padding-top: 1.5rem;
        border-top: 1px solid rgba(0, 0, 0, 0.1);
    }

    .login-link p {
        color: #0a1b33;
        font-size: clamp(12px, 1.5vw, 14px);
        margin-bottom: 0.75rem;
    }

    .login-link a {
        color: #1c4e80;
        font-weight: bold;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .login-link a:hover {
        color: #163e66;
        text-decoration: underline;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .register-card {
            padding: clamp(15px, 4vw, 30px);
            margin: 0 15px;
        }

        .card-title {
            font-size: 1.5rem;
        }

        .toggle {
            margin-bottom: 1.5rem;
        }

        .form-group {
            margin-bottom: 1.2rem;
        }
    }

    @media (max-width: 480px) {
        .register-container {
            padding: 1rem;
        }

        .register-card {
            padding: 15px;
            margin: 0;
            width: 95%;
        }

        .register-logo img {
            width: 50px;
        }

        .card-title {
            font-size: 1.2rem;
            gap: 0.5rem;
        }

        .register-subtitle {
            font-size: 12px;
        }

        .form-label {
            font-size: 11px;
        }

        .form-control,
        .input-group-text {
            padding: 8px 10px;
            font-size: 13px;
        }

        .btn-register {
            padding: 10px 0;
            font-size: 13px;
        }

        .toggle button {
            padding: 8px 0;
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
    <!-- Logo Section -->
    <div class="register-logo">
        <img src="{{ asset('images/logo-pestimart.png') }}" alt="PestiMart Logo">
    </div>

    <!-- Register Card -->
    <div class="register-card">
        <!-- Title -->
        <h2 class="card-title">
            <i class="fas fa-store"></i>Daftar Penjual
        </h2>
        <p class="register-subtitle">Buka toko Anda di PestiMart</p>

        <!-- Registration Form -->
        <form method="POST" action="{{ route('register.seller') }}">
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
            <button type="submit" class="btn-register">
                <i class="fas fa-store me-2"></i>Daftar Penjual
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
@endsection
