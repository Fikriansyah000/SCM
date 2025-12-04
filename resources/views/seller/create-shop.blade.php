@extends('layouts.app')

@section('title', 'Buat Toko - PestiMart')

@section('content')
<style>
    /* ===== CSS Variables ===== */
    :root {
        --orange-primary: #FF8F3A;
        --orange-dark: #f5700a;
        --orange-darker: #d35400;
        --orange-light: #ffb980;
        --orange-gradient: linear-gradient(135deg, #FF8F3A 0%, #f5700a 50%, #d35400 100%);
        --dark-bg: #1A1F36;
        --dark-secondary: #252B43;
    }

    /* ===== Page Layout ===== */
    .create-shop-page {
        min-height: 100vh;
        display: flex;
        background: linear-gradient(135deg, #f8f9fc 0%, #eef2f7 100%);
    }

    /* ===== Left Sidebar Panel ===== */
    .shop-sidebar {
        width: 320px;
        background: linear-gradient(180deg, var(--dark-bg) 0%, var(--dark-secondary) 100%);
        position: fixed;
        left: 0;
        top: 0;
        bottom: 0;
        display: flex;
        flex-direction: column;
        z-index: 100;
        overflow: hidden;
    }

    /* Animated Background Pattern */
    .shop-sidebar::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        animation: patternMove 30s linear infinite;
        pointer-events: none;
    }

    @keyframes patternMove {
        0% { background-position: 0 0; }
        100% { background-position: 60px 60px; }
    }

    /* Floating Shapes */
    .sidebar-shapes {
        position: absolute;
        width: 100%;
        height: 100%;
        pointer-events: none;
        overflow: hidden;
    }

    .sidebar-shape {
        position: absolute;
        border-radius: 50%;
        background: var(--orange-gradient);
        opacity: 0.1;
    }

    .sidebar-shape:nth-child(1) {
        width: 200px;
        height: 200px;
        top: -80px;
        right: -80px;
        animation: shapeFloat1 15s ease-in-out infinite;
    }

    .sidebar-shape:nth-child(2) {
        width: 150px;
        height: 150px;
        bottom: 20%;
        left: -60px;
        animation: shapeFloat2 18s ease-in-out infinite;
    }

    .sidebar-shape:nth-child(3) {
        width: 100px;
        height: 100px;
        bottom: -30px;
        right: 20%;
        animation: shapeFloat3 12s ease-in-out infinite;
    }

    @keyframes shapeFloat1 {
        0%, 100% { transform: translate(0, 0) scale(1); }
        50% { transform: translate(-15px, 20px) scale(1.1); }
    }

    @keyframes shapeFloat2 {
        0%, 100% { transform: translate(0, 0) scale(1); }
        50% { transform: translate(20px, -15px) scale(0.95); }
    }

    @keyframes shapeFloat3 {
        0%, 100% { transform: translate(0, 0); }
        50% { transform: translate(-10px, -20px); }
    }

    .sidebar-content {
        position: relative;
        z-index: 1;
        padding: 40px 30px;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    /* Logo Section */
    .sidebar-logo {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 50px;
        animation: slideDown 0.6s ease-out;
    }

    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .sidebar-logo img {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        object-fit: contain;
    }

    .sidebar-logo-text {
        font-size: 1.5rem;
        font-weight: 700;
        color: white;
    }

    .sidebar-logo-text span {
        color: var(--orange-primary);
    }

    /* Sidebar Info */
    .sidebar-info {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
        animation: fadeInUp 0.8s ease-out 0.2s backwards;
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .sidebar-icon {
        width: 80px;
        height: 80px;
        background: var(--orange-gradient);
        border-radius: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        color: white;
        margin-bottom: 30px;
        box-shadow: 0 15px 40px rgba(255, 143, 58, 0.3);
        animation: iconFloat 3s ease-in-out infinite;
    }

    @keyframes iconFloat {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }

    .sidebar-info h2 {
        color: white;
        font-size: 1.8rem;
        font-weight: 700;
        margin-bottom: 15px;
        line-height: 1.3;
    }

    .sidebar-info p {
        color: rgba(255, 255, 255, 0.7);
        font-size: 1rem;
        line-height: 1.7;
        margin-bottom: 30px;
    }

    /* Features List */
    .sidebar-features {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .sidebar-features li {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 12px 0;
        color: rgba(255, 255, 255, 0.8);
        font-size: 0.95rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        opacity: 0;
        animation: featureSlide 0.5s ease-out forwards;
    }

    .sidebar-features li:last-child {
        border-bottom: none;
    }

    .sidebar-features li:nth-child(1) { animation-delay: 0.4s; }
    .sidebar-features li:nth-child(2) { animation-delay: 0.5s; }
    .sidebar-features li:nth-child(3) { animation-delay: 0.6s; }
    .sidebar-features li:nth-child(4) { animation-delay: 0.7s; }

    @keyframes featureSlide {
        from { opacity: 0; transform: translateX(-20px); }
        to { opacity: 1; transform: translateX(0); }
    }

    .feature-icon {
        width: 36px;
        height: 36px;
        background: rgba(255, 143, 58, 0.15);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--orange-primary);
        flex-shrink: 0;
    }

    /* ===== Main Content Area ===== */
    .shop-main {
        flex: 1;
        margin-left: 320px;
        padding: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
    }

    /* Background Particles */
    .main-particles {
        position: fixed;
        top: 0;
        left: 320px;
        right: 0;
        bottom: 0;
        pointer-events: none;
        overflow: hidden;
        z-index: 0;
    }

    .main-particle {
        position: absolute;
        width: 8px;
        height: 8px;
        background: var(--orange-gradient);
        border-radius: 50%;
        opacity: 0.15;
        animation: particleFloat 20s infinite ease-in-out;
    }

    .main-particle:nth-child(1) { left: 10%; top: 20%; animation-delay: 0s; }
    .main-particle:nth-child(2) { left: 25%; top: 70%; animation-delay: 3s; width: 12px; height: 12px; }
    .main-particle:nth-child(3) { left: 45%; top: 30%; animation-delay: 6s; }
    .main-particle:nth-child(4) { left: 65%; top: 80%; animation-delay: 9s; width: 10px; height: 10px; }
    .main-particle:nth-child(5) { left: 80%; top: 25%; animation-delay: 12s; }
    .main-particle:nth-child(6) { left: 90%; top: 60%; animation-delay: 15s; width: 6px; height: 6px; }

    @keyframes particleFloat {
        0%, 100% { transform: translateY(0) rotate(0deg); opacity: 0.15; }
        50% { transform: translateY(-50px) rotate(180deg); opacity: 0.25; }
    }

    /* ===== Form Card ===== */
    .shop-card {
        background: white;
        border-radius: 24px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
        max-width: 600px;
        width: 100%;
        position: relative;
        z-index: 1;
        overflow: hidden;
        animation: cardEnter 0.8s cubic-bezier(0.16, 1, 0.3, 1);
    }

    @keyframes cardEnter {
        from {
            opacity: 0;
            transform: translateY(40px) scale(0.95);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    /* Card Shimmer Effect */
    .shop-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 143, 58, 0.03), transparent);
        animation: cardShimmer 3s infinite;
    }

    @keyframes cardShimmer {
        0% { left: -100%; }
        50%, 100% { left: 100%; }
    }

    /* Card Header */
    .shop-card-header {
        background: var(--orange-gradient);
        padding: 30px;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .shop-card-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -30%;
        width: 200px;
        height: 200px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        animation: headerShape 8s ease-in-out infinite;
    }

    @keyframes headerShape {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.2); }
    }

    .shop-card-header::after {
        content: '';
        position: absolute;
        bottom: -60%;
        left: -20%;
        width: 150px;
        height: 150px;
        background: rgba(255, 255, 255, 0.08);
        border-radius: 50%;
    }

    .header-icon {
        width: 70px;
        height: 70px;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        font-size: 2rem;
        color: white;
        position: relative;
        z-index: 1;
        animation: iconPop 0.6s ease-out 0.3s backwards;
    }

    @keyframes iconPop {
        from { transform: scale(0); }
        to { transform: scale(1); }
    }

    .shop-card-header h3 {
        color: white;
        font-size: 1.6rem;
        font-weight: 700;
        margin: 0 0 8px;
        position: relative;
        z-index: 1;
    }

    .shop-card-header p {
        color: rgba(255, 255, 255, 0.9);
        margin: 0;
        font-size: 0.95rem;
        position: relative;
        z-index: 1;
    }

    /* Card Body */
    .shop-card-body {
        padding: 35px;
    }

    /* Progress Steps */
    .form-progress {
        display: flex;
        justify-content: center;
        gap: 10px;
        margin-bottom: 30px;
    }

    .progress-step {
        width: 40px;
        height: 4px;
        background: #e2e8f0;
        border-radius: 2px;
        transition: all 0.3s ease;
    }

    .progress-step.active {
        background: var(--orange-gradient);
        width: 60px;
    }

    .progress-step.completed {
        background: var(--orange-primary);
    }

    /* Form Groups */
    .form-group {
        margin-bottom: 24px;
        position: relative;
        opacity: 0;
        animation: formGroupEnter 0.5s ease-out forwards;
    }

    .form-group:nth-child(1) { animation-delay: 0.1s; }
    .form-group:nth-child(2) { animation-delay: 0.15s; }
    .form-group:nth-child(3) { animation-delay: 0.2s; }
    .form-group:nth-child(4) { animation-delay: 0.25s; }
    .form-group:nth-child(5) { animation-delay: 0.3s; }
    .form-group:nth-child(6) { animation-delay: 0.35s; }

    @keyframes formGroupEnter {
        from { opacity: 0; transform: translateY(15px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .form-label {
        display: flex;
        align-items: center;
        gap: 8px;
        font-weight: 600;
        color: #374151;
        margin-bottom: 10px;
        font-size: 0.95rem;
    }

    .form-label i {
        color: var(--orange-primary);
    }

    .form-label .required {
        color: #ef4444;
    }

    /* Input Fields */
    .form-control {
        width: 100%;
        padding: 16px 20px;
        border: 2px solid #e2e8f0;
        border-radius: 14px;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: #f8fafc;
    }

    .form-control:focus {
        outline: none;
        border-color: var(--orange-primary);
        background: white;
        box-shadow: 0 0 0 4px rgba(255, 143, 58, 0.1);
    }

    .form-control::placeholder {
        color: #94a3b8;
    }

    textarea.form-control {
        resize: vertical;
        min-height: 120px;
    }

    /* Input with Icon */
    .input-with-icon {
        position: relative;
    }

    .input-with-icon .form-control {
        padding-left: 50px;
    }

    .input-icon {
        position: absolute;
        left: 18px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 1.1rem;
        transition: color 0.3s ease;
    }

    .input-with-icon:focus-within .input-icon {
        color: var(--orange-primary);
    }

    /* Upload Areas */
    .upload-area {
        border: 2px dashed #cbd5e1;
        border-radius: 16px;
        padding: 30px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        background: white;
        position: relative;
        overflow: hidden;
    }

    .upload-area::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 143, 58, 0.05), transparent);
        transition: left 0.5s ease;
    }

    .upload-area:hover::before {
        left: 100%;
    }

    .upload-area:hover {
        border-color: var(--orange-primary);
        background: linear-gradient(135deg, #fffaf5, #fff5eb);
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(255, 143, 58, 0.1);
    }

    .upload-icon {
        width: 60px;
        height: 60px;
        background: var(--orange-gradient);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 15px;
        color: white;
        font-size: 1.5rem;
        transition: transform 0.3s ease;
    }

    .upload-area:hover .upload-icon {
        transform: scale(1.1) rotate(5deg);
    }

    .upload-area h4 {
        color: #1e293b;
        font-weight: 600;
        margin: 0 0 8px;
        font-size: 1rem;
    }

    .upload-area p {
        color: #64748b;
        font-size: 0.85rem;
        margin: 0;
    }

    /* Image Preview */
    .image-preview {
        margin-top: 15px;
        animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: scale(0.95); }
        to { opacity: 1; transform: scale(1); }
    }

    .image-preview img {
        border-radius: 12px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        border: 3px solid var(--orange-light);
    }

    .preview-label {
        color: var(--orange-dark);
        font-weight: 600;
        font-size: 0.85rem;
        margin-top: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
    }

    /* Submit Button */
    .btn-submit {
        width: 100%;
        padding: 18px 32px;
        background: var(--orange-gradient);
        color: white;
        border: none;
        border-radius: 14px;
        font-weight: 600;
        font-size: 1.1rem;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        position: relative;
        overflow: hidden;
        margin-top: 30px;
    }

    .btn-submit::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s ease;
    }

    .btn-submit:hover::before {
        left: 100%;
    }

    .btn-submit:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 40px rgba(255, 143, 58, 0.4);
    }

    .btn-submit i {
        transition: transform 0.3s ease;
    }

    .btn-submit:hover i {
        transform: translateX(5px);
    }

    /* Error Feedback */
    .form-control.is-invalid {
        border-color: #ef4444;
        background: #fef2f2;
    }

    .invalid-feedback {
        color: #dc2626;
        font-size: 0.85rem;
        margin-top: 8px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    /* ===== Mobile Toggle Button ===== */
    .mobile-sidebar-toggle {
        display: none;
        position: fixed;
        top: 20px;
        left: 20px;
        width: 50px;
        height: 50px;
        background: var(--orange-gradient);
        border: none;
        border-radius: 14px;
        color: white;
        font-size: 1.3rem;
        cursor: pointer;
        z-index: 200;
        box-shadow: 0 8px 25px rgba(255, 143, 58, 0.4);
        transition: transform 0.3s ease;
    }

    .mobile-sidebar-toggle:hover {
        transform: scale(1.05);
    }

    /* Sidebar Overlay for Mobile */
    .sidebar-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        z-index: 99;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .sidebar-overlay.active {
        opacity: 1;
    }

    /* ===== Responsive Design ===== */
    @media (max-width: 991.98px) {
        .shop-sidebar {
            transform: translateX(-100%);
            transition: transform 0.3s ease;
        }

        .shop-sidebar.mobile-open {
            transform: translateX(0);
        }

        .shop-main {
            margin-left: 0;
            padding: 30px 20px;
        }

        .main-particles {
            left: 0;
        }

        .mobile-sidebar-toggle {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .sidebar-overlay {
            display: block;
        }
    }

    @media (max-width: 767.98px) {
        .shop-main {
            padding: 80px 15px 30px;
        }

        .shop-card {
            border-radius: 20px;
        }

        .shop-card-header {
            padding: 25px 20px;
        }

        .header-icon {
            width: 60px;
            height: 60px;
            font-size: 1.6rem;
        }

        .shop-card-header h3 {
            font-size: 1.4rem;
        }

        .shop-card-body {
            padding: 25px 20px;
        }

        .form-control {
            padding: 14px 16px;
        }

        .input-with-icon .form-control {
            padding-left: 45px;
        }

        .upload-area {
            padding: 25px 15px;
        }

        .upload-icon {
            width: 50px;
            height: 50px;
            font-size: 1.3rem;
        }

        .btn-submit {
            padding: 16px 24px;
            font-size: 1rem;
        }
    }

    @media (max-width: 575.98px) {
        .shop-main {
            padding: 70px 12px 25px;
        }

        .shop-card-body {
            padding: 20px 15px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            font-size: 0.9rem;
        }

        .form-control {
            padding: 12px 14px;
            font-size: 0.95rem;
        }

        .upload-area {
            padding: 20px 12px;
        }

        .upload-area h4 {
            font-size: 0.9rem;
        }

        .upload-area p {
            font-size: 0.8rem;
        }
    }

    /* Loading State */
    .btn-submit.loading {
        pointer-events: none;
        opacity: 0.8;
    }

    .btn-submit.loading i {
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
</style>

<div class="create-shop-page">
    <!-- Sidebar Overlay for Mobile -->
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

    <!-- Mobile Toggle Button -->
    <button class="mobile-sidebar-toggle" onclick="toggleSidebar()">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Left Sidebar Panel -->
    <aside class="shop-sidebar" id="shopSidebar">
        <div class="sidebar-shapes">
            <div class="sidebar-shape"></div>
            <div class="sidebar-shape"></div>
            <div class="sidebar-shape"></div>
        </div>
        
        <div class="sidebar-content">
            <div class="sidebar-logo">
                <img src="{{ asset('images/landing/logo-pestimart.png') }}" alt="PestiMart">
                <span class="sidebar-logo-text">Pesti<span>Mart</span></span>
            </div>

            <div class="sidebar-info">
                <div class="sidebar-icon">
                    <i class="fas fa-store"></i>
                </div>
                <h2>Mulai Berjualan di PestiMart</h2>
                <p>Buat toko Anda dan mulai jual produk ke ribuan mahasiswa di seluruh kampus. Proses mudah dan cepat!</p>

                <ul class="sidebar-features">
                    <li>
                        <div class="feature-icon">
                            <i class="fas fa-rocket"></i>
                        </div>
                        <span>Setup toko dalam 5 menit</span>
                    </li>
                    <li>
                        <div class="feature-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <span>Akses ke ribuan pembeli</span>
                    </li>
                    <li>
                        <div class="feature-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <span>Transaksi aman & terpercaya</span>
                    </li>
                    <li>
                        <div class="feature-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <span>Dashboard analitik lengkap</span>
                    </li>
                </ul>
            </div>
        </div>
    </aside>

    <!-- Main Content Area -->
    <main class="shop-main">
        <!-- Background Particles -->
        <div class="main-particles">
            <div class="main-particle"></div>
            <div class="main-particle"></div>
            <div class="main-particle"></div>
            <div class="main-particle"></div>
            <div class="main-particle"></div>
            <div class="main-particle"></div>
        </div>

        <!-- Form Card -->
        <div class="shop-card">
            <!-- Card Header -->
            <div class="shop-card-header">
                <div class="header-icon">
                    <i class="fas fa-store-alt"></i>
                </div>
                <h3>Buat Toko Baru</h3>
                <p>Lengkapi informasi toko Anda untuk mulai berjualan</p>
            </div>

            <!-- Card Body -->
            <div class="shop-card-body">
                <!-- Progress Steps -->
                <div class="form-progress">
                    <div class="progress-step active"></div>
                    <div class="progress-step"></div>
                    <div class="progress-step"></div>
                </div>

                <form method="POST" action="{{ route('seller.shop.store') }}" enctype="multipart/form-data" id="createShopForm">
                    @csrf

                    <div class="form-group">
                        <label for="shop_name" class="form-label">
                            <i class="fas fa-store"></i>
                            Nama Toko
                            <span class="required">*</span>
                        </label>
                        <div class="input-with-icon">
                            <i class="fas fa-store input-icon"></i>
                            <input type="text" 
                                   class="form-control @error('shop_name') is-invalid @enderror" 
                                   id="shop_name" 
                                   name="shop_name" 
                                   value="{{ old('shop_name') }}" 
                                   placeholder="Contoh: Toko Buku Mahasiswa"
                                   required>
                        </div>
                        @error('shop_name')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="description" class="form-label">
                            <i class="fas fa-align-left"></i>
                            Deskripsi Toko
                            <span class="required">*</span>
                        </label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" 
                                  name="description" 
                                  placeholder="Deskripsikan toko Anda, produk yang dijual, dan keunggulannya..."
                                  required>{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="address" class="form-label">
                            <i class="fas fa-map-marker-alt"></i>
                            Alamat Toko
                            <span class="required">*</span>
                        </label>
                        <div class="input-with-icon">
                            <i class="fas fa-map-marker-alt input-icon"></i>
                            <input type="text" 
                                   class="form-control @error('address') is-invalid @enderror" 
                                   id="address" 
                                   name="address" 
                                   value="{{ old('address') }}" 
                                   placeholder="Alamat lengkap toko Anda"
                                   required>
                        </div>
                        @error('address')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="phone" class="form-label">
                            <i class="fas fa-phone"></i>
                            Nomor Telepon
                            <span class="required">*</span>
                        </label>
                        <div class="input-with-icon">
                            <i class="fas fa-phone input-icon"></i>
                            <input type="tel" 
                                   class="form-control @error('phone') is-invalid @enderror" 
                                   id="phone" 
                                   name="phone" 
                                   value="{{ old('phone') }}" 
                                   placeholder="08xxxxxxxxxx"
                                   required>
                        </div>
                        @error('phone')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="logo" class="form-label">
                            <i class="fas fa-image"></i>
                            Logo Toko
                        </label>
                        <div class="upload-area" onclick="document.getElementById('logo').click()">
                            <div class="upload-icon">
                                <i class="fas fa-cloud-upload-alt"></i>
                            </div>
                            <h4>Upload Logo Toko</h4>
                            <p>Klik atau seret gambar ke sini • Max 2MB • JPG, PNG, GIF</p>
                        </div>
                        <input type="file" id="logo" name="logo" accept="image/*" style="display: none;" onchange="previewFile(this, 'logoPreview')">
                        <div id="logoPreview" class="image-preview" style="display:none; max-width:150px; margin: 15px auto 0;"></div>
                        @error('logo')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="banner" class="form-label">
                            <i class="fas fa-panorama"></i>
                            Banner Toko
                        </label>
                        <div class="upload-area" onclick="document.getElementById('banner').click()">
                            <div class="upload-icon">
                                <i class="fas fa-image"></i>
                            </div>
                            <h4>Upload Banner Toko</h4>
                            <p>Klik atau seret gambar ke sini • Max 2MB • JPG, PNG, GIF</p>
                        </div>
                        <input type="file" id="banner" name="banner" accept="image/*" style="display: none;" onchange="previewFile(this, 'bannerPreview')">
                        <div id="bannerPreview" class="image-preview" style="display:none; max-width:100%; margin-top: 15px;"></div>
                        @error('banner')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn-submit" id="submitBtn">
                        <i class="fas fa-check-circle"></i>
                        Buat Toko Sekarang
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </form>
            </div>
        </div>
    </main>
</div>

<script>
// Preview uploaded files
function previewFile(input, previewId) {
    const preview = document.getElementById(previewId);
    if (!preview) return;
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = `
                <img src="${e.target.result}" alt="Preview" style="width: 100%; border-radius: 12px; box-shadow: 0 8px 25px rgba(0,0,0,0.1); border: 3px solid #ffb980;">
                <div class="preview-label">
                    <i class="fas fa-check-circle"></i>
                    Gambar dipilih
                </div>
            `;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    }
}

// Mobile sidebar toggle
function toggleSidebar() {
    const sidebar = document.getElementById('shopSidebar');
    const overlay = document.getElementById('sidebarOverlay');
    
    sidebar.classList.toggle('mobile-open');
    overlay.classList.toggle('active');
    
    if (sidebar.classList.contains('mobile-open')) {
        document.body.style.overflow = 'hidden';
    } else {
        document.body.style.overflow = '';
    }
}

function closeSidebar() {
    const sidebar = document.getElementById('shopSidebar');
    const overlay = document.getElementById('sidebarOverlay');
    
    sidebar.classList.remove('mobile-open');
    overlay.classList.remove('active');
    document.body.style.overflow = '';
}

// Form submit loading
document.getElementById('createShopForm').addEventListener('submit', function() {
    const submitBtn = document.getElementById('submitBtn');
    submitBtn.classList.add('loading');
    submitBtn.innerHTML = '<i class="fas fa-spinner"></i> Membuat Toko...';
});

// Add ripple effect to button
document.querySelector('.btn-submit').addEventListener('click', function(e) {
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

// Ripple animation
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

// Input focus animations
document.querySelectorAll('.form-control').forEach(input => {
    input.addEventListener('focus', function() {
        this.closest('.form-group').classList.add('focused');
    });
    
    input.addEventListener('blur', function() {
        this.closest('.form-group').classList.remove('focused');
    });
});

// Progress bar update on input
const inputs = document.querySelectorAll('.form-control');
const progressSteps = document.querySelectorAll('.progress-step');

function updateProgress() {
    let filledCount = 0;
    inputs.forEach(input => {
        if (input.value.trim() !== '') filledCount++;
    });
    
    const progress = Math.min(Math.ceil(filledCount / 2), 3);
    
    progressSteps.forEach((step, index) => {
        step.classList.remove('active', 'completed');
        if (index < progress - 1) {
            step.classList.add('completed');
        } else if (index === progress - 1) {
            step.classList.add('active');
        }
    });
}

inputs.forEach(input => {
    input.addEventListener('input', updateProgress);
});

// Drag and drop for upload areas
document.querySelectorAll('.upload-area').forEach(area => {
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        area.addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    ['dragenter', 'dragover'].forEach(eventName => {
        area.addEventListener(eventName, () => {
            area.style.borderColor = '#FF8F3A';
            area.style.background = 'linear-gradient(135deg, #fffaf5, #fff5eb)';
        }, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        area.addEventListener(eventName, () => {
            area.style.borderColor = '#cbd5e1';
            area.style.background = 'white';
        }, false);
    });

    area.addEventListener('drop', function(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        const input = this.nextElementSibling;
        
        if (input && input.type === 'file') {
            input.files = files;
            const previewId = input.id + 'Preview';
            previewFile(input, previewId);
        }
    }, false);
});

// Close sidebar on window resize
window.addEventListener('resize', function() {
    if (window.innerWidth > 991) {
        closeSidebar();
    }
});
</script>
@endsection
