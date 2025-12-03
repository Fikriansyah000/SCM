@extends('layouts.app')

@section('title', 'Edit Profil - PestiMart')

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
    .edit-profile-page {
        min-height: 100vh;
        background: linear-gradient(135deg, #f0f4f8 0%, #e8f0fe 100%);
        position: relative;
        overflow: hidden;
        padding: 40px 0 80px;
    }

    /* Animated Background Particles */
    .edit-particles {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
        overflow: hidden;
        z-index: 0;
    }

    .edit-particle {
        position: absolute;
        width: 8px;
        height: 8px;
        background: linear-gradient(135deg, var(--primary), var(--primary-lighter));
        border-radius: 50%;
        opacity: 0.1;
        animation: particleFloat 20s infinite ease-in-out;
    }

    .edit-particle:nth-child(1) { left: 5%; top: 15%; animation-delay: 0s; }
    .edit-particle:nth-child(2) { left: 20%; top: 70%; animation-delay: 3s; width: 12px; height: 12px; }
    .edit-particle:nth-child(3) { left: 35%; top: 25%; animation-delay: 6s; }
    .edit-particle:nth-child(4) { left: 55%; top: 85%; animation-delay: 9s; width: 10px; height: 10px; }
    .edit-particle:nth-child(5) { left: 70%; top: 20%; animation-delay: 12s; }
    .edit-particle:nth-child(6) { left: 85%; top: 65%; animation-delay: 15s; width: 6px; height: 6px; }

    @keyframes particleFloat {
        0%, 100% { transform: translateY(0) rotate(0deg); opacity: 0.1; }
        50% { transform: translateY(-40px) rotate(180deg); opacity: 0.2; }
    }

    /* ===== Main Container ===== */
    .edit-profile-wrapper {
        position: relative;
        z-index: 1;
    }

    /* ===== Header Card ===== */
    .edit-header {
        background: var(--bg-gradient);
        border-radius: 24px;
        padding: 40px;
        margin-bottom: 30px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 15px 50px rgba(30, 58, 95, 0.25);
        animation: slideDown 0.6s ease-out;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .edit-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url("data:image/svg+xml,%3Csvg width='40' height='40' viewBox='0 0 40 40' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M20 20c0-5.5-4.5-10-10-10s-10 4.5-10 10 4.5 10 10 10 10-4.5 10-10zm10 0c0-5.5-4.5-10-10-10s-10 4.5-10 10 4.5 10 10 10 10-4.5 10-10z'/%3E%3C/g%3E%3C/svg%3E");
        animation: patternMove 25s linear infinite;
    }

    @keyframes patternMove {
        0% { background-position: 0 0; }
        100% { background-position: 40px 40px; }
    }

    /* Floating Shapes */
    .header-shapes {
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        pointer-events: none;
        overflow: hidden;
    }

    .header-shape {
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.1);
    }

    .header-shape:nth-child(1) {
        width: 200px;
        height: 200px;
        top: -80px;
        right: -60px;
        animation: shapeFloat 12s ease-in-out infinite;
    }

    .header-shape:nth-child(2) {
        width: 120px;
        height: 120px;
        bottom: -40px;
        left: 10%;
        animation: shapeFloat 15s ease-in-out infinite reverse;
    }

    @keyframes shapeFloat {
        0%, 100% { transform: translate(0, 0) scale(1); }
        50% { transform: translate(15px, -15px) scale(1.1); }
    }

    .edit-header-content {
        position: relative;
        z-index: 2;
        display: flex;
        align-items: center;
        gap: 20px;
        color: white;
    }

    .edit-header-icon {
        width: 70px;
        height: 70px;
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        animation: iconBounce 2s ease-in-out infinite;
    }

    @keyframes iconBounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-8px); }
    }

    .edit-header h2 {
        font-size: 1.8rem;
        font-weight: 700;
        margin: 0;
    }

    .edit-header p {
        margin: 5px 0 0;
        opacity: 0.9;
        font-size: 1rem;
    }

    /* ===== Form Card ===== */
    .edit-profile-container {
        background: white;
        border-radius: 24px;
        padding: 0;
        box-shadow: 0 10px 60px rgba(30, 58, 95, 0.12);
        overflow: hidden;
        animation: cardEnter 0.6s ease-out 0.2s backwards;
    }

    @keyframes cardEnter {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* ===== Avatar Section ===== */
    .avatar-section {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        padding: 40px;
        text-align: center;
        border-bottom: 1px solid #e2e8f0;
        position: relative;
    }

    .avatar-section::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 100px;
        height: 4px;
        background: var(--bg-gradient);
        border-radius: 2px;
    }

    .current-avatar {
        position: relative;
        width: 140px;
        height: 140px;
        margin: 0 auto 25px;
    }

    .current-avatar::before {
        content: '';
        position: absolute;
        top: -6px;
        left: -6px;
        right: -6px;
        bottom: -6px;
        background: linear-gradient(135deg, var(--primary), var(--accent), var(--primary));
        border-radius: 50%;
        animation: avatarRing 4s linear infinite;
        z-index: -1;
    }

    @keyframes avatarRing {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
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
        box-shadow: 0 10px 30px rgba(30, 58, 95, 0.15);
        transition: transform 0.3s ease;
    }

    .current-avatar:hover .avatar-inner {
        transform: scale(1.05);
    }

    .avatar-inner img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .avatar-inner .no-avatar {
        font-size: 3rem;
        color: var(--primary);
    }

    .avatar-edit-badge {
        position: absolute;
        bottom: 5px;
        right: 5px;
        width: 40px;
        height: 40px;
        background: var(--bg-gradient);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1rem;
        cursor: pointer;
        box-shadow: 0 4px 15px rgba(30, 58, 95, 0.3);
        transition: transform 0.3s ease;
    }

    .avatar-edit-badge:hover {
        transform: scale(1.1);
    }

    /* Upload Area */
    .upload-avatar-area {
        max-width: 400px;
        margin: 0 auto;
        border: 3px dashed #cbd5e1;
        border-radius: 16px;
        padding: 30px;
        cursor: pointer;
        transition: all 0.3s ease;
        background: white;
        position: relative;
        overflow: hidden;
    }

    .upload-avatar-area::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(30, 58, 95, 0.05), transparent);
        transition: left 0.5s ease;
    }

    .upload-avatar-area:hover::before {
        left: 100%;
    }

    .upload-avatar-area:hover {
        border-color: var(--primary);
        background: linear-gradient(135deg, #f8fafc, #e8f4ff);
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(30, 58, 95, 0.1);
    }

    .upload-icon {
        width: 60px;
        height: 60px;
        background: var(--bg-gradient);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 15px;
        color: white;
        font-size: 1.5rem;
        transition: transform 0.3s ease;
    }

    .upload-avatar-area:hover .upload-icon {
        transform: scale(1.1) rotate(5deg);
    }

    .upload-avatar-area h4 {
        color: #1e293b;
        font-weight: 600;
        margin: 0 0 8px;
    }

    .upload-avatar-area p {
        color: #64748b;
        font-size: 0.9rem;
        margin: 0;
    }

    /* ===== Form Section ===== */
    .form-section {
        padding: 40px;
    }

    .section-title {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 30px;
        padding-bottom: 15px;
        border-bottom: 2px solid #f1f5f9;
    }

    .section-title-icon {
        width: 45px;
        height: 45px;
        background: var(--bg-gradient);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.2rem;
    }

    .section-title h3 {
        font-size: 1.3rem;
        font-weight: 700;
        color: #1e293b;
        margin: 0;
    }

    /* Form Grid */
    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 24px;
    }

    .form-grid-full {
        grid-column: span 2;
    }

    @media (max-width: 768px) {
        .form-grid {
            grid-template-columns: 1fr;
        }
        .form-grid-full {
            grid-column: span 1;
        }
    }

    /* Form Group */
    .form-group {
        position: relative;
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
        color: var(--primary);
        font-size: 1rem;
    }

    .form-label .required {
        color: #ef4444;
    }

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
        border-color: var(--primary);
        background: white;
        box-shadow: 0 0 0 4px rgba(30, 58, 95, 0.1);
    }

    .form-control::placeholder {
        color: #94a3b8;
    }

    textarea.form-control {
        resize: vertical;
        min-height: 120px;
    }

    /* Input Icons */
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
        color: var(--primary);
    }

    /* Error State */
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

    .invalid-feedback::before {
        content: '\f071';
        font-family: 'Font Awesome 6 Free';
        font-weight: 900;
    }

    /* ===== Action Buttons ===== */
    .form-actions {
        display: flex;
        gap: 15px;
        margin-top: 40px;
        padding-top: 30px;
        border-top: 2px solid #f1f5f9;
    }

    .btn-submit {
        flex: 1;
        padding: 18px 32px;
        background: var(--bg-gradient);
        color: white;
        border: none;
        border-radius: 14px;
        font-weight: 600;
        font-size: 1rem;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        position: relative;
        overflow: hidden;
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
        box-shadow: 0 15px 40px rgba(30, 58, 95, 0.3);
    }

    .btn-submit i {
        transition: transform 0.3s ease;
    }

    .btn-submit:hover i {
        transform: translateX(3px);
    }

    .btn-cancel {
        padding: 18px 32px;
        background: white;
        color: var(--primary);
        border: 2px solid #e2e8f0;
        border-radius: 14px;
        font-weight: 600;
        font-size: 1rem;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        text-decoration: none;
    }

    .btn-cancel:hover {
        background: #f8fafc;
        border-color: var(--primary);
        color: var(--primary);
        text-decoration: none;
        transform: translateY(-3px);
    }

    /* ===== Preview Image ===== */
    .preview-container {
        margin-top: 15px;
        text-align: center;
        display: none;
    }

    .preview-container.active {
        display: block;
        animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: scale(0.95); }
        to { opacity: 1; transform: scale(1); }
    }

    .preview-image {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid var(--accent);
        box-shadow: 0 8px 25px rgba(0, 201, 167, 0.2);
    }

    .preview-label {
        color: var(--accent);
        font-weight: 600;
        font-size: 0.9rem;
        margin-top: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
    }

    /* ===== Responsive ===== */
    @media (max-width: 768px) {
        .edit-profile-page {
            padding: 20px 0 60px;
        }

        .edit-header {
            padding: 25px;
            border-radius: 16px;
        }

        .edit-header-content {
            flex-direction: column;
            text-align: center;
        }

        .edit-header h2 {
            font-size: 1.4rem;
        }

        .form-section {
            padding: 25px;
        }

        .form-actions {
            flex-direction: column;
        }

        .btn-cancel {
            order: 2;
        }
    }

    /* ===== Loading State ===== */
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

<div class="edit-profile-page">
    <!-- Background Particles -->
    <div class="edit-particles">
        <div class="edit-particle"></div>
        <div class="edit-particle"></div>
        <div class="edit-particle"></div>
        <div class="edit-particle"></div>
        <div class="edit-particle"></div>
        <div class="edit-particle"></div>
    </div>

    <div class="container">
        <div class="edit-profile-wrapper">
            <!-- Header -->
            <div class="edit-header">
                <div class="header-shapes">
                    <div class="header-shape"></div>
                    <div class="header-shape"></div>
                </div>
                <div class="edit-header-content">
                    <div class="edit-header-icon">
                        <i class="fas fa-user-edit"></i>
                    </div>
                    <div>
                        <h2>Edit Profil</h2>
                        <p>Perbarui informasi profil Anda untuk pengalaman yang lebih baik</p>
                    </div>
                </div>
            </div>

            <!-- Form Card -->
            <div class="edit-profile-container">
                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" id="editProfileForm">
                    @csrf
                    @method('PUT')

                    <!-- Avatar Section -->
                    <div class="avatar-section">
                        <div class="current-avatar">
                            <div class="avatar-inner">
                                @if(auth()->user()->profile_photo)
                                    <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}" alt="Avatar" id="currentAvatar">
                                @else
                                    <div class="no-avatar" id="noAvatar">
                                        <i class="fas fa-user"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="avatar-edit-badge" onclick="document.getElementById('profile_photo').click()">
                                <i class="fas fa-camera"></i>
                            </div>
                        </div>

                        <div class="upload-avatar-area" onclick="document.getElementById('profile_photo').click()">
                            <div class="upload-icon">
                                <i class="fas fa-cloud-upload-alt"></i>
                            </div>
                            <h4>Upload Foto Profil</h4>
                            <p>Klik atau seret foto ke sini • Max 2MB • JPG, PNG, GIF</p>
                        </div>
                        <input type="file" id="profile_photo" name="profile_photo" accept="image/*" style="display: none;" onchange="previewImage(this)">
                        
                        <div class="preview-container" id="previewContainer">
                            <img src="" alt="Preview" class="preview-image" id="previewImage">
                            <div class="preview-label">
                                <i class="fas fa-check-circle"></i>
                                Foto baru dipilih
                            </div>
                        </div>

                        @error('profile_photo')
                            <div class="invalid-feedback d-block" style="margin-top: 15px;">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Form Section -->
                    <div class="form-section">
                        <div class="section-title">
                            <div class="section-title-icon">
                                <i class="fas fa-id-card"></i>
                            </div>
                            <h3>Informasi Personal</h3>
                        </div>

                        <div class="form-grid">
                            <div class="form-group">
                                <label for="name" class="form-label">
                                    <i class="fas fa-user"></i>
                                    Nama Lengkap
                                    <span class="required">*</span>
                                </label>
                                <div class="input-with-icon">
                                    <i class="fas fa-user input-icon"></i>
                                    <input type="text" 
                                           class="form-control @error('name') is-invalid @enderror" 
                                           id="name" 
                                           name="name" 
                                           value="{{ old('name', auth()->user()->name) }}" 
                                           placeholder="Masukkan nama lengkap"
                                           required>
                                </div>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="email" class="form-label">
                                    <i class="fas fa-envelope"></i>
                                    Alamat Email
                                    <span class="required">*</span>
                                </label>
                                <div class="input-with-icon">
                                    <i class="fas fa-envelope input-icon"></i>
                                    <input type="email" 
                                           class="form-control @error('email') is-invalid @enderror" 
                                           id="email" 
                                           name="email" 
                                           value="{{ old('email', auth()->user()->email) }}" 
                                           placeholder="contoh@email.com"
                                           required>
                                </div>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="phone" class="form-label">
                                    <i class="fas fa-phone"></i>
                                    Nomor Telepon
                                </label>
                                <div class="input-with-icon">
                                    <i class="fas fa-phone input-icon"></i>
                                    <input type="tel" 
                                           class="form-control @error('phone') is-invalid @enderror" 
                                           id="phone" 
                                           name="phone" 
                                           value="{{ old('phone', auth()->user()->phone) }}"
                                           placeholder="08xxxxxxxxxx">
                                </div>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group form-grid-full">
                                <label for="address" class="form-label">
                                    <i class="fas fa-map-marker-alt"></i>
                                    Alamat Lengkap
                                </label>
                                <textarea class="form-control @error('address') is-invalid @enderror" 
                                          id="address" 
                                          name="address"
                                          placeholder="Masukkan alamat lengkap Anda">{{ old('address', auth()->user()->address) }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="form-actions">
                            <button type="submit" class="btn-submit" id="submitBtn">
                                <i class="fas fa-save"></i>
                                Simpan Perubahan
                            </button>
                            <a href="{{ route('profile.show') }}" class="btn-cancel">
                                <i class="fas fa-times"></i>
                                Batal
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Preview Image
function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            const previewContainer = document.getElementById('previewContainer');
            const previewImage = document.getElementById('previewImage');
            
            previewImage.src = e.target.result;
            previewContainer.classList.add('active');
            
            // Update current avatar
            const currentAvatar = document.getElementById('currentAvatar');
            const noAvatar = document.getElementById('noAvatar');
            
            if (currentAvatar) {
                currentAvatar.src = e.target.result;
            } else if (noAvatar) {
                noAvatar.outerHTML = `<img src="${e.target.result}" alt="Avatar" id="currentAvatar">`;
            }
        };
        
        reader.readAsDataURL(input.files[0]);
    }
}

// Form Submit Loading
document.getElementById('editProfileForm').addEventListener('submit', function() {
    const submitBtn = document.getElementById('submitBtn');
    submitBtn.classList.add('loading');
    submitBtn.innerHTML = '<i class="fas fa-spinner"></i> Menyimpan...';
});

// Drag and Drop for Upload Area
const uploadArea = document.querySelector('.upload-avatar-area');

['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
    uploadArea.addEventListener(eventName, preventDefaults, false);
});

function preventDefaults(e) {
    e.preventDefault();
    e.stopPropagation();
}

['dragenter', 'dragover'].forEach(eventName => {
    uploadArea.addEventListener(eventName, highlight, false);
});

['dragleave', 'drop'].forEach(eventName => {
    uploadArea.addEventListener(eventName, unhighlight, false);
});

function highlight() {
    uploadArea.style.borderColor = 'var(--primary)';
    uploadArea.style.background = 'linear-gradient(135deg, #f8fafc, #e8f4ff)';
}

function unhighlight() {
    uploadArea.style.borderColor = '#cbd5e1';
    uploadArea.style.background = 'white';
}

uploadArea.addEventListener('drop', handleDrop, false);

function handleDrop(e) {
    const dt = e.dataTransfer;
    const files = dt.files;
    const fileInput = document.getElementById('profile_photo');
    
    fileInput.files = files;
    previewImage(fileInput);
}

// Add ripple effect to buttons
document.querySelectorAll('.btn-submit, .btn-cancel').forEach(button => {
    button.addEventListener('click', function(e) {
        if (this.classList.contains('btn-cancel')) return;
        
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

// Add ripple animation keyframe
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

// Input focus animation
document.querySelectorAll('.form-control').forEach(input => {
    input.addEventListener('focus', function() {
        this.parentElement.classList.add('focused');
    });
    
    input.addEventListener('blur', function() {
        this.parentElement.classList.remove('focused');
    });
});
</script>
@endsection
