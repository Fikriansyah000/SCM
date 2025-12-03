@extends('layouts.seller')

@section('title', 'Edit ' . ($product->product_type === 'service' ? 'Layanan' : 'Produk') . ' - PestiMart')
@section('page-title', 'Edit ' . ($product->product_type === 'service' ? 'Layanan' : 'Produk'))

@section('content')
<style>
    /* Main Wrapper */
    .product-editor-wrapper {
        background: transparent;
        padding: 0;
        border-radius: 0;
        border: none;
        box-shadow: none;
    }
    .product-edit-grid {
        display: grid;
        grid-template-columns: minmax(0, 2fr) minmax(320px, 1fr);
        gap: 2rem;
        align-items: flex-start;
    }
    
    /* Form Container */
    .product-form-container {
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(248, 250, 252, 0.9) 100%);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(226, 232, 240, 0.8);
        width: 100%;
        position: relative;
        overflow: hidden;
    }
    .product-form-container::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--color-primary) 0%, var(--color-secondary, #6366f1) 50%, var(--color-primary) 100%);
        background-size: 200% 100%;
        animation: shimmer 3s ease-in-out infinite;
    }
    @keyframes shimmer {
        0%, 100% { background-position: 200% 0; }
        50% { background-position: 0% 0; }
    }
    
    /* Form Section */
    .form-section {
        margin-bottom: 1.75rem;
        background: rgba(255, 255, 255, 0.7);
        border-radius: 16px;
        padding: 1.5rem;
        border: 1px solid rgba(226, 232, 240, 0.6);
        transition: all 0.3s ease;
    }
    .form-section:hover {
        background: rgba(255, 255, 255, 0.9);
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.04);
    }
    .form-section-title {
        font-size: 1.1rem;
        font-weight: 700;
        margin-bottom: 1.25rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid transparent;
        border-image: linear-gradient(90deg, var(--color-primary), var(--color-secondary, #6366f1)) 1;
        display: flex;
        justify-content: space-between;
        align-items: center;
        color: var(--color-text);
    }
    .form-section-title i {
        background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary, #6366f1) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-right: 0.5rem;
    }
    
    /* Form Controls */
    .form-group {
        margin-bottom: 1.25rem;
    }
    .form-label {
        font-weight: 600;
        margin-bottom: 0.5rem;
        display: block;
        color: var(--color-text);
        font-size: 0.9rem;
        letter-spacing: -0.01em;
    }
    .form-control {
        width: 100%;
        padding: 0.875rem 1rem;
        border: 2px solid rgba(226, 232, 240, 0.8);
        border-radius: 12px;
        font-family: inherit;
        font-size: 0.95rem;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        background: rgba(255, 255, 255, 0.8);
    }
    .form-control:hover {
        border-color: rgba(99, 102, 241, 0.3);
    }
    .form-control:focus {
        border-color: var(--color-primary);
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.12);
        outline: none;
        background: white;
    }
    textarea.form-control {
        resize: vertical;
        min-height: 120px;
    }
    
    /* Type Badge */
    .type-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.6rem 1.25rem;
        border-radius: 12px;
        font-weight: 700;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .type-badge.product {
        background: linear-gradient(135deg, rgba(34, 197, 94, 0.15) 0%, rgba(16, 185, 129, 0.1) 100%);
        color: #16a34a;
        border: 1px solid rgba(34, 197, 94, 0.2);
    }
    .type-badge.service {
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.12) 0%, rgba(139, 92, 246, 0.08) 100%);
        color: var(--color-primary);
        border: 1px solid rgba(99, 102, 241, 0.2);
    }
    
    /* Service & Physical Fields */
    .service-fields {
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.06) 0%, rgba(139, 92, 246, 0.04) 100%);
        padding: 1.5rem;
        border-radius: 16px;
        margin-bottom: 1.75rem;
        border: 1px solid rgba(99, 102, 241, 0.15);
    }
    .physical-fields {
        background: linear-gradient(135deg, rgba(34, 197, 94, 0.06) 0%, rgba(16, 185, 129, 0.04) 100%);
        padding: 1.5rem;
        border-radius: 16px;
        margin-bottom: 1.75rem;
        border: 1px solid rgba(34, 197, 94, 0.15);
    }
    
    /* Upload Area */
    .upload-area {
        border: 2px dashed rgba(99, 102, 241, 0.3);
        border-radius: 16px;
        padding: 2rem 1.5rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        background: linear-gradient(135deg, rgba(248, 250, 252, 0.8) 0%, rgba(241, 245, 249, 0.6) 100%);
    }
    .upload-area:hover {
        border-color: var(--color-primary);
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(99, 102, 241, 0.15);
    }
    .upload-area i {
        font-size: 2.5rem;
        background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary, #6366f1) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 0.75rem;
        display: block;
    }
    .upload-area p {
        color: var(--color-text);
        margin: 0 0 0.25rem;
        font-weight: 600;
    }
    
    .image-preview {
        margin-top: 1rem;
        max-width: 280px;
    }
    .image-preview img {
        width: 100%;
        border-radius: 12px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
        border: 3px solid white;
    }
    
    /* Form Actions */
    .form-actions {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
        padding-top: 1.5rem;
        border-top: 1px solid rgba(226, 232, 240, 0.8);
        flex-wrap: wrap;
    }
    .btn-submit {
        padding: 0.875rem 2rem;
        border: none;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.95rem;
    }
    .btn-submit.btn-primary-solid {
        border-radius: 12px;
        background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary, #6366f1) 100%);
        color: white;
        box-shadow: 0 4px 16px rgba(99, 102, 241, 0.35);
    }
    .btn-submit.btn-primary-solid:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(99, 102, 241, 0.4);
    }
    .btn-cancel {
        padding: 0.875rem 1.75rem;
        background: rgba(255, 255, 255, 0.9);
        color: var(--color-text-secondary);
        border: 2px solid rgba(226, 232, 240, 0.8);
        border-radius: 12px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.95rem;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .btn-cancel:hover {
        background: rgba(248, 250, 252, 1);
        color: var(--color-text);
        border-color: rgba(203, 213, 225, 1);
        transform: translateY(-2px);
    }
    
    /* Form Check */
    .form-check {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.875rem 1rem;
        background: rgba(255, 255, 255, 0.7);
        border-radius: 12px;
        border: 1px solid rgba(226, 232, 240, 0.5);
        cursor: pointer;
        transition: all 0.2s ease;
        margin-top: 1rem;
    }
    .form-check:hover {
        background: rgba(255, 255, 255, 0.95);
    }
    .form-check input[type="checkbox"] {
        width: 1.35rem;
        height: 1.35rem;
        accent-color: var(--color-primary);
        cursor: pointer;
    }
    .form-check-label {
        font-weight: 500;
        color: var(--color-text);
        cursor: pointer;
    }
    
    /* Form Row */
    .form-row {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.25rem;
    }

    /* Side Panel */
    .product-side-panel {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
        position: sticky;
        top: 1rem;
    }
    .side-card {
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(248, 250, 252, 0.9) 100%);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        padding: 1.5rem;
        border: 1px solid rgba(226, 232, 240, 0.8);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
    }
    .side-card h4,
    .side-card h5 {
        margin-top: 0;
        margin-bottom: 1rem;
        font-weight: 700;
        color: var(--color-text);
        font-size: 1.1rem;
    }
    .preview-image {
        border-radius: 16px;
        overflow: hidden;
        aspect-ratio: 4 / 3;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.1) 0%, rgba(139, 92, 246, 0.1) 100%);
        border: 1px solid rgba(226, 232, 240, 0.8);
    }
    .preview-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .preview-image i {
        font-size: 3.5rem;
        background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary, #6366f1) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        opacity: 0.5;
    }
    .status-chip {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.4rem 0.85rem;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        background: linear-gradient(135deg, rgba(34, 197, 94, 0.15) 0%, rgba(16, 185, 129, 0.1) 100%);
        color: #16a34a;
        border: 1px solid rgba(34, 197, 94, 0.2);
        margin-bottom: 0.75rem;
    }
    .status-chip.archived {
        background: linear-gradient(135deg, rgba(100, 116, 139, 0.12) 0%, rgba(71, 85, 105, 0.08) 100%);
        color: #64748b;
        border-color: rgba(100, 116, 139, 0.2);
    }
    .summary-description {
        color: var(--color-text-secondary);
        margin-bottom: 1.25rem;
        font-size: 0.9rem;
        line-height: 1.6;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .meta-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 1.25rem 1rem;
    }
    .meta-stat {
        background: rgba(248, 250, 252, 0.8);
        padding: 0.875rem;
        border-radius: 12px;
        border: 1px solid rgba(226, 232, 240, 0.5);
    }
    .meta-stat small {
        display: block;
        color: var(--color-text-muted);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-size: 0.65rem;
        font-weight: 600;
        margin-bottom: 0.35rem;
    }
    .meta-stat strong {
        font-size: 1.15rem;
        background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary, #6366f1) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    .stat-note {
        display: block;
        color: var(--color-text-secondary);
        font-size: 0.75rem;
        margin-top: 0.25rem;
    }
    
    /* Slot & Insights */
    .slot-stats,
    .insights-list {
        list-style: none;
        margin: 0;
        padding: 0;
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }
    .slot-stats li {
        display: flex;
        justify-content: space-between;
        font-weight: 600;
        color: var(--color-text);
        padding: 0.5rem 0;
        border-bottom: 1px solid rgba(226, 232, 240, 0.5);
    }
    .slot-stats li:last-child {
        border-bottom: none;
    }
    .slot-stats span {
        color: var(--color-text-muted);
        font-weight: 500;
    }
    .insights-list li {
        display: flex;
        gap: 0.75rem;
        color: var(--color-text-secondary);
        font-size: 0.9rem;
        padding: 0.5rem 0;
    }
    .insights-list i {
        background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary, #6366f1) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-top: 0.1rem;
    }
    .small-text {
        font-size: 0.8rem;
        color: var(--color-text-muted);
        margin-top: 0.75rem;
    }
    
    /* Slot Management */
    .slots-container {
        background: rgba(248, 250, 252, 0.8);
        border-radius: 16px;
        padding: 1.5rem;
        margin-top: 1rem;
        border: 1px solid rgba(226, 232, 240, 0.6);
    }
    .slot-card {
        background: rgba(255, 255, 255, 0.9);
        border: 1px solid rgba(226, 232, 240, 0.8);
        border-radius: 12px;
        padding: 1rem;
        margin-bottom: 0.75rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: all 0.25s ease;
    }
    .slot-card:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
        border-color: rgba(99, 102, 241, 0.3);
    }
    .slot-card.inactive {
        opacity: 0.6;
        background: rgba(248, 250, 252, 0.9);
    }

    .slot-info {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .slot-date {
        font-weight: 600;
        color: var(--color-text);
        font-size: 0.95rem;
    }

    .slot-time {
        color: var(--color-text-secondary);
        font-size: 0.85rem;
    }

    .slot-capacity {
        display: flex;
        gap: 0.5rem;
        align-items: center;
    }

    .slot-capacity .badge {
        padding: 0.4rem 0.75rem;
        border-radius: 10px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .slot-capacity .badge.available {
        background: linear-gradient(135deg, rgba(34, 197, 94, 0.15) 0%, rgba(16, 185, 129, 0.1) 100%);
        color: #16a34a;
    }

    .slot-capacity .badge.full {
        background: linear-gradient(135deg, rgba(220, 38, 38, 0.12) 0%, rgba(239, 68, 68, 0.08) 100%);
        color: #dc2626;
    }

    .slot-actions {
        display: flex;
        gap: 0.5rem;
    }

    .slot-actions button, .slot-actions form button {
        padding: 0.5rem 0.875rem;
        border-radius: 10px;
        font-size: 0.85rem;
        border: none;
        cursor: pointer;
        transition: all 0.25s ease;
        font-weight: 600;
    }

    .btn-toggle {
        background: linear-gradient(135deg, rgba(245, 158, 11, 0.1) 0%, rgba(251, 191, 36, 0.08) 100%);
        color: #d97706;
        border: 1px solid rgba(245, 158, 11, 0.2);
    }

    .btn-toggle:hover {
        background: linear-gradient(135deg, #f59e0b 0%, #fbbf24 100%);
        color: white;
        border-color: transparent;
        transform: translateY(-1px);
    }

    .btn-delete {
        background: linear-gradient(135deg, rgba(220, 38, 38, 0.08) 0%, rgba(239, 68, 68, 0.05) 100%);
        color: #dc2626;
        border: 1px solid rgba(220, 38, 38, 0.2);
    }

    .btn-delete:hover {
        background: linear-gradient(135deg, #dc2626 0%, #ef4444 100%);
        color: white;
        border-color: transparent;
        transform: translateY(-1px);
    }

    .add-slot-form {
        background: rgba(255, 255, 255, 0.9);
        border: 2px dashed rgba(99, 102, 241, 0.3);
        border-radius: 16px;
        padding: 1.5rem;
        margin-top: 1rem;
        transition: all 0.3s ease;
    }
    .add-slot-form:hover {
        border-color: var(--color-primary);
    }

    .add-slot-form .row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
        gap: 1rem;
    }

    .btn-add-slot {
        background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary, #6366f1) 100%);
        color: white;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        font-weight: 600;
        cursor: pointer;
        margin-top: 1rem;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
    }

    .btn-add-slot:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(99, 102, 241, 0.4);
    }

    .empty-slots {
        text-align: center;
        padding: 2.5rem 1.5rem;
        color: var(--color-text-muted);
    }
    .empty-slots i {
        font-size: 3rem;
        margin-bottom: 1rem;
        background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary, #6366f1) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        opacity: 0.5;
    }
    /* Responsive */
    @media (max-width: 1024px) {
        .product-edit-grid {
            grid-template-columns: 1fr;
        }
        .product-side-panel {
            position: static;
        }
    }
    @media (max-width: 768px) {
        .product-form-container {
            padding: 1.25rem;
            border-radius: 16px;
        }
        .form-section {
            padding: 1rem;
        }
        .form-row {
            grid-template-columns: 1fr;
        }
        .form-actions {
            flex-direction: column;
        }
        .btn-submit, .btn-cancel {
            width: 100%;
            justify-content: center;
        }
        .slot-card {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }
        .slot-actions {
            width: 100%;
        }
        .slot-actions button, .slot-actions form {
            flex: 1;
        }
        .add-slot-form .row {
            grid-template-columns: 1fr;
        }
        .service-fields,
        .physical-fields {
            padding: 1rem;
        }
        .side-card {
            padding: 1.25rem;
        }
        .meta-grid {
            gap: 1rem 0.75rem;
        }
    }

    @media (max-width: 575.98px) {
        .product-form-container {
            padding: 1rem;
            border-radius: 12px;
        }
        .form-section {
            padding: 0.875rem;
        }
        .section-title {
            font-size: 1rem;
        }
        .form-label {
            font-size: 0.9rem;
        }
        .form-control {
            padding: 0.65rem 0.75rem;
            font-size: 0.9rem;
        }
        .btn-submit, .btn-cancel {
            padding: 0.75rem 1rem;
            font-size: 0.9rem;
        }
        .type-badge {
            font-size: 0.7rem;
            padding: 0.35rem 0.75rem;
        }
        .side-card {
            padding: 1rem;
        }
        .side-card h4,
        .side-card h5 {
            font-size: 1rem;
        }
        .meta-stat {
            padding: 0.75rem;
        }
        .meta-stat strong {
            font-size: 1rem;
        }
        .slot-card {
            padding: 0.875rem;
        }
        .preview-image i {
            font-size: 2.5rem;
        }
        .upload-area {
            padding: 1.25rem;
        }
        .upload-area i {
            font-size: 1.5rem;
        }
    }
</style>

@php
    $isServiceType = $product->product_type === 'service';
    $serviceSlots = $product->serviceSlots ?? collect();
    $activeSlotsCount = $serviceSlots->where('is_active', true)->count();
    $inactiveSlotsCount = $serviceSlots->where('is_active', false)->count();
@endphp

<div class="product-editor-wrapper">
    <div class="product-edit-grid">

        <div class="product-form-container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem;">
        <span class="type-badge {{ $product->product_type === 'service' ? 'service' : 'product' }}">
            <i class="fas {{ $product->product_type === 'service' ? 'fa-concierge-bell' : 'fa-box' }}"></i>
            {{ $product->product_type === 'service' ? 'Layanan' : 'Produk Fisik' }}
        </span>
        <a href="{{ route('seller.products.index') }}" class="btn-cancel" style="font-size: 0.85rem; padding: 0.5rem 1rem;">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
    
    <form method="POST" action="{{ route('seller.products.update', $product->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <input type="hidden" name="product_type" value="{{ $product->product_type }}">
            
            <!-- Basic Information -->
            <div class="form-section">
                <div class="form-section-title">
                    <span><i class="fas fa-info-circle"></i>Informasi Dasar</span>
                </div>
                
                <div class="form-group">
                    <label for="name" class="form-label">Nama {{ $product->product_type === 'service' ? 'Layanan' : 'Produk' }}</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                           id="name" name="name" value="{{ old('name', $product->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="category" class="form-label">Kategori</label>
                    <select class="form-control @error('category') is-invalid @enderror" id="category" name="category" required>
                        <option value="">-- Pilih Kategori --</option>
                        <option value="Makanan & Minuman" {{ old('category', $product->category) == 'Makanan & Minuman' ? 'selected' : '' }}>Makanan & Minuman</option>
                        <option value="Jasa & Layanan" {{ old('category', $product->category) == 'Jasa & Layanan' ? 'selected' : '' }}>Jasa & Layanan</option>
                        <option value="Buku & Alat Tulis" {{ old('category', $product->category) == 'Buku & Alat Tulis' ? 'selected' : '' }}>Buku & Alat Tulis</option>
                        <option value="Elektronik" {{ old('category', $product->category) == 'Elektronik' ? 'selected' : '' }}>Elektronik</option>
                        <option value="Lainnya" {{ old('category', $product->category) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                    @error('category')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="description" class="form-label">Deskripsi</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" 
                              id="description" name="description" required>{{ old('description', $product->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            @if(($product->product_type ?? 'food') === 'food')
            <!-- Price & Stock (Physical Products) -->
            <div class="physical-fields">
                <div class="form-section-title" style="border:none; padding:0; margin-bottom: 1rem;">
                    <span><i class="fas fa-money-bill-wave"></i>Harga & Stok</span>
                </div>
                
                <div class="form-row">
                    <div class="form-group" style="margin-bottom: 0;">
                        <label for="price" class="form-label">Harga (Rp)</label>
                        <input type="number" class="form-control @error('price') is-invalid @enderror" 
                               id="price" name="price" value="{{ old('price', $product->price) }}" required step="1000" min="0">
                        @error('price')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group" style="margin-bottom: 0;">
                        <label for="stock" class="form-label">Stok</label>
                        <input type="number" class="form-control @error('stock') is-invalid @enderror" 
                               id="stock" name="stock" value="{{ old('stock', $product->stock) }}" required min="0">
                        @error('stock')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            @else
            <!-- Service Fields -->
            <div class="service-fields">
                <div class="form-section-title" style="border:none; padding:0; margin-bottom: 1rem;">
                    <span><i class="fas fa-concierge-bell"></i>Detail Layanan</span>
                </div>
                
                @php $sp = $product->service_profile ?? []; @endphp
                
                <div class="form-group">
                    <label for="price" class="form-label">Harga Layanan (Rp)</label>
                    <input type="number" class="form-control @error('price') is-invalid @enderror" 
                           id="price" name="price" value="{{ old('price', $product->price) }}" required step="1000" min="0">
                    @error('price')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-row">
                    <div class="form-group" style="margin-bottom: 0;">
                        <label for="duration_minutes" class="form-label">Durasi (menit)</label>
                        <input type="number" class="form-control @error('duration_minutes') is-invalid @enderror" 
                               id="duration_minutes" name="duration_minutes" 
                               value="{{ old('duration_minutes', $sp['duration_minutes'] ?? '') }}" min="1">
                        @error('duration_minutes')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group" style="margin-bottom: 0;">
                        <label for="location_type" class="form-label">Lokasi Layanan</label>
                        <select class="form-control @error('location_type') is-invalid @enderror" id="location_type" name="location_type">
                            <option value="flexible" {{ old('location_type', $sp['location_type'] ?? '') == 'flexible' ? 'selected' : '' }}>Fleksibel</option>
                            <option value="online" {{ old('location_type', $sp['location_type'] ?? '') == 'online' ? 'selected' : '' }}>Online</option>
                            <option value="onsite" {{ old('location_type', $sp['location_type'] ?? '') == 'onsite' ? 'selected' : '' }}>Di Tempat</option>
                        </select>
                        @error('location_type')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="requirements" class="form-label">Persyaratan / Catatan</label>
                    <textarea class="form-control @error('requirements') is-invalid @enderror" 
                              id="requirements" name="requirements" rows="2">{{ old('requirements', $sp['requirements'] ?? '') }}</textarea>
                    @error('requirements')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-check">
                    <input type="checkbox" id="requires_booking" name="requires_booking" value="1" 
                           {{ old('requires_booking', $product->requires_booking) ? 'checked' : '' }}>
                    <label for="requires_booking" class="form-check-label">Memerlukan pemilihan jadwal/slot</label>
                </div>
            </div>
            @endif
            
            <!-- Product Image -->
            <div class="form-section">
                <div class="form-section-title">
                    <span><i class="fas fa-image"></i>Foto</span>
                </div>
                
                @if($product->image)
                <div class="image-preview" style="margin-bottom: 1rem;">
                    <p style="font-size: 0.85rem; color: var(--color-text-muted); margin-bottom: 0.5rem;">Foto Saat Ini:</p>
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                </div>
                @endif
                
                <div class="form-group">
                    <label class="form-label">Ganti Foto</label>
                    <div class="upload-area" onclick="document.getElementById('image').click()">
                        <i class="fas fa-image"></i>
                        <p>Klik untuk upload foto baru</p>
                        <small class="text-muted">Max 2MB, Format: JPG, PNG, GIF, WEBP</small>
                    </div>
                    <input type="file" id="image" name="image" accept="image/*" style="display: none;">
                    @error('image')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <!-- Actions -->
            <div class="form-actions">
                <button type="submit" class="btn-submit btn-primary-solid">
                    <i class="fas fa-save"></i>
                    <span>Simpan Perubahan</span>
                </button>
                <a href="{{ route('seller.products.index') }}" class="btn-cancel">
                    <i class="fas fa-times"></i>
                    <span>Batal</span>
                </a>
            </div>
        </form>
        
        @if(($product->product_type ?? 'food') === 'service')
        <!-- Service Slots Management -->
        <div class="form-section" style="margin-top: 2.5rem;">
            <div class="form-section-title">
                <span><i class="fas fa-calendar-alt"></i>Jadwal / Slot Layanan</span>
            </div>
            
            <div class="slots-container">
                @forelse($product->serviceSlots ?? [] as $slot)
                    <div class="slot-card {{ $slot->is_active ? '' : 'inactive' }}">
                        <div class="slot-info">
                            <div class="slot-date">
                                @if($slot->slot_date)
                                    {{ \Carbon\Carbon::parse($slot->slot_date)->translatedFormat('l, d M Y') }}
                                @elseif($slot->day_of_week)
                                    Setiap {{ ucfirst($slot->day_of_week) }}
                                    @if($slot->is_recurring)
                                        <span class="badge bg-info text-white" style="font-size:.75rem;">Berulang</span>
                                    @endif
                                @else
                                    Tanggal tidak ditentukan
                                @endif
                            </div>
                            <div class="slot-time">
                                <i class="fas fa-clock"></i> {{ substr($slot->start_time, 0, 5) }} - {{ substr($slot->end_time, 0, 5) }}
                            </div>
                        </div>
                        
                        <div class="slot-capacity">
                            <span class="badge {{ $slot->availableCapacity() > 0 ? 'available' : 'full' }}">
                                Sisa: {{ $slot->availableCapacity() }} / {{ $slot->capacity }}
                            </span>
                            @if(!$slot->is_active)
                                <span class="badge" style="background:#eee;color:#666;">Nonaktif</span>
                            @endif
                        </div>
                        
                        <div class="slot-actions">
                            <form method="POST" action="{{ route('seller.products.slots.toggle', [$product->id, $slot->id]) }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn-toggle" title="{{ $slot->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                    <i class="fas {{ $slot->is_active ? 'fa-pause' : 'fa-play' }}"></i>
                                </button>
                            </form>
                            @if($slot->booked_count == 0)
                            <form method="POST" action="{{ route('seller.products.slots.destroy', [$product->id, $slot->id]) }}" class="d-inline" onsubmit="return confirm('Hapus slot ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="empty-slots">
                        <i class="fas fa-calendar-times"></i>
                        <p>Belum ada jadwal/slot layanan.<br>Tambahkan jadwal di bawah ini.</p>
                    </div>
                @endforelse
                
                <!-- Add New Slot Form -->
                <div class="add-slot-form">
                    <h6 class="mb-3"><i class="fas fa-plus-circle me-2"></i>Tambah Jadwal Baru</h6>
                    <form method="POST" action="{{ route('seller.products.slots.store', $product->id) }}">
                        @csrf
                        <div class="row">
                            <div class="col">
                                <label class="form-label small">Tanggal (opsional)</label>
                                <input type="date" name="slot_date" class="form-control" min="{{ date('Y-m-d') }}">
                            </div>
                            <div class="col">
                                <label class="form-label small">Atau Hari (berulang)</label>
                                <select name="day_of_week" class="form-control">
                                    <option value="">-- Pilih Hari --</option>
                                    <option value="monday">Senin</option>
                                    <option value="tuesday">Selasa</option>
                                    <option value="wednesday">Rabu</option>
                                    <option value="thursday">Kamis</option>
                                    <option value="friday">Jumat</option>
                                    <option value="saturday">Sabtu</option>
                                    <option value="sunday">Minggu</option>
                                </select>
                            </div>
                            <div class="col">
                                <label class="form-label small">Jam Mulai</label>
                                <input type="time" name="start_time" class="form-control" required>
                            </div>
                            <div class="col">
                                <label class="form-label small">Jam Selesai</label>
                                <input type="time" name="end_time" class="form-control" required>
                            </div>
                            <div class="col">
                                <label class="form-label small">Kapasitas</label>
                                <input type="number" name="capacity" class="form-control" min="1" value="1" required>
                            </div>
                        </div>
                        <div class="form-check mt-3">
                            <input type="checkbox" id="is_recurring" name="is_recurring" value="1">
                            <label for="is_recurring" class="small">Jadwal berulang setiap minggu</label>
                        </div>
                        <button type="submit" class="btn-add-slot">
                            <i class="fas fa-plus me-2"></i>Tambah Jadwal
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endif
        </div>

        <aside class="product-side-panel">
            @php $isArchived = ($product->status ?? 'available') === 'unavailable'; @endphp
            <div class="side-card product-summary-card">
                <div class="preview-image">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                    @else
                        <i class="fas fa-image"></i>
                    @endif
                </div>
                <span class="status-chip {{ $isArchived ? 'archived' : '' }}">
                    <i class="fas {{ $isArchived ? 'fa-archive' : 'fa-check-circle' }}"></i>
                    {{ $isArchived ? 'Diarsipkan' : 'Aktif' }}
                </span>
                <h4>{{ $product->name }}</h4>
                <p class="summary-description">{{ \Illuminate\Support\Str::limit($product->description, 120) }}</p>
                <div class="meta-grid">
                    <div class="meta-stat">
                        <small>Harga</small>
                        <strong>Rp{{ number_format($product->price, 0, ',', '.') }}</strong>
                    </div>
                    <div class="meta-stat">
                        <small>{{ $isServiceType ? 'Slot aktif' : 'Stok fisik' }}</small>
                        <strong>{{ $isServiceType ? $activeSlotsCount : $product->stock }}</strong>
                        @if($isServiceType)
                            <span class="stat-note">{{ $inactiveSlotsCount }} slot nonaktif</span>
                        @endif
                    </div>
                    <div class="meta-stat">
                        <small>Kategori</small>
                        <strong>{{ $product->category }}</strong>
                    </div>
                    <div class="meta-stat">
                        <small>Tipe</small>
                        <strong>{{ $isServiceType ? 'Layanan' : 'Produk' }}</strong>
                    </div>
                </div>
            </div>

            @if($isServiceType)
                <div class="side-card slot-summary-card">
                    <h5>Ringkasan Slot</h5>
                    <ul class="slot-stats">
                        <li><span>Total slot terdaftar</span><strong>{{ $serviceSlots->count() }}</strong></li>
                        <li><span>Slot aktif</span><strong>{{ $activeSlotsCount }}</strong></li>
                        <li><span>Slot nonaktif</span><strong>{{ $inactiveSlotsCount }}</strong></li>
                    </ul>
                    <p class="small-text">Gunakan panel jadwal di bawah form untuk mengaktifkan/menambah slot baru agar kalender buyer selalu up to date.</p>
                </div>
            @else
                <div class="side-card slot-summary-card">
                    <h5>Catatan Inventori</h5>
                    <ul class="slot-stats">
                        <li><span>Stok saat ini</span><strong>{{ $product->stock }}</strong></li>
                        <li><span>Status stok</span><strong>{{ $product->stock > 0 ? 'Tersedia' : 'Habis' }}</strong></li>
                    </ul>
                    <p class="small-text">Perbarui stok setiap kali barang masuk/keluar supaya kartu produk di buyer tidak menampilkan jumlah yang salah.</p>
                </div>
            @endif

            <div class="side-card checklist-card">
                <h5>Checklist Cepat</h5>
                <ul class="insights-list">
                    <li>
                        <i class="fas fa-magic"></i>
                        <div>Pastikan foto utama terang dan menunjukkan detail terbaik produk/layanan.</div>
                    </li>
                    <li>
                        <i class="fas fa-align-left"></i>
                        <div>Gunakan paragraf pertama deskripsi untuk menonjolkan manfaat utama.</div>
                    </li>
                    <li>
                        <i class="fas fa-calendar-check"></i>
                        <div>Segera perbarui stok atau slot agar ketersediaan di buyer tetap sinkron.</div>
                    </li>
                    <li>
                        <i class="fas fa-clipboard-list"></i>
                        <div>Tulis catatan layanan (lokasi, peralatan, batasan) supaya buyer tidak perlu bertanya ulang.</div>
                    </li>
                </ul>
            </div>
        </aside>
    </div>
</div>

<script>
document.getElementById('image').addEventListener('change', function(e) {
    if (e.target.files.length > 0) {
        const file = e.target.files[0];
        const reader = new FileReader();
        reader.onload = function(event) {
            let preview = document.querySelector('.image-preview');
            if (!preview) {
                preview = document.createElement('div');
                preview.className = 'image-preview mb-3';
                document.querySelector('.upload-area').before(preview);
            }
            preview.innerHTML = '<p class="small text-muted mb-2">Foto Baru:</p><img src="' + event.target.result + '" alt="Preview">';
        };
        reader.readAsDataURL(file);
    }
});
</script>
@endsection
