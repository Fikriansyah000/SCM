@extends('layouts.app')

@section('title', 'Dashboard - PestiMart')

@section('content')
<style>
    .dashboard-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 2rem 0;
        margin-bottom: 2rem;
    }
    
    .stat-card {
        background: white;
        padding: 2rem;
        border-radius: 0.75rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        margin-bottom: 1.5rem;
        text-align: center;
        transition: all 0.3s ease;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0,0,0,0.15);
    }
    
    .stat-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        margin: 0 auto 1rem;
        font-size: 1.5rem;
    }
    
    .stat-icon.primary {
        background: #667eea;
        color: white;
    }
    
    .stat-icon.success {
        background: #48bb78;
        color: white;
    }
    
    .stat-icon.warning {
        background: #f6ad55;
        color: white;
    }
    
    .stat-icon.danger {
        background: #f5576c;
        color: white;
    }
    
    .stat-value {
        font-size: 1.8rem;
        font-weight: 700;
        color: #333;
        margin-bottom: 0.5rem;
    }
    
    .stat-label {
        color: #999;
        font-size: 0.95rem;
        font-weight: 500;
    }
    
    .section-card {
        background: white;
        padding: 2rem;
        border-radius: 0.75rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        margin-bottom: 1.5rem;
    }
    
    .section-title {
        font-size: 1.2rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid #f0f0f0;
    }
    
    .quick-actions {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 1rem;
    }
    
    .action-btn {
        padding: 1rem;
        text-align: center;
        border: 2px solid #f0f0f0;
        border-radius: 0.75rem;
        background: white;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        color: #333;
    }
    
    .action-btn:hover {
        border-color: #667eea;
        background: #f0f4ff;
        color: #667eea;
    }
    
    .action-btn i {
        display: block;
        font-size: 1.8rem;
        margin-bottom: 0.5rem;
    }
    
    .action-btn span {
        display: block;
        font-weight: 600;
        font-size: 0.9rem;
    }
</style>

<div class="dashboard-header">
    <div class="container">
        <h2>
            <i class="fas fa-tachometer-alt me-2"></i>Dashboard Penjual
        </h2>
        <p class="mt-2">Selamat datang, {{ auth()->user()->name }}!</p>
    </div>
</div>

<div class="container my-4">
    <!-- Statistics -->
    <div class="row mb-4">
        <div class="col-md-6 col-lg-3">
            <div class="stat-card">
                <div class="stat-icon primary">
                    <i class="fas fa-box"></i>
                </div>
                <div class="stat-value">{{ $totalProducts }}</div>
                <div class="stat-label">Total Produk</div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="stat-card">
                <div class="stat-icon warning">
                    <i class="fas fa-shopping-bag"></i>
                </div>
                <div class="stat-value">{{ $totalOrders }}</div>
                <div class="stat-label">Total Pesanan</div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="stat-card">
                <div class="stat-icon danger">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-value">{{ $pendingOrders }}</div>
                <div class="stat-label">Pesanan Pending</div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="stat-card">
                <div class="stat-icon success">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
                <div class="stat-value">Rp{{ number_format($totalRevenue, 0, ',', '.') }}</div>
                <div class="stat-label">Total Revenue</div>
            </div>
        </div>
    </div>
    
    <!-- Shop Info -->
    <div class="section-card">
        <div class="section-title">
            <i class="fas fa-store me-2"></i>Informasi Toko
        </div>
        <div class="row">
            <div class="col-md-6">
                <p><strong>Nama Toko:</strong> {{ $shop->shop_name }}</p>
                <p><strong>Alamat:</strong> {{ $shop->address }}</p>
                <p><strong>Nomor Telepon:</strong> {{ $shop->phone }}</p>
                <p><strong>Status:</strong> 
                    <span class="badge bg-success">{{ ucfirst($shop->status) }}</span>
                </p>
            </div>
            <div class="col-md-6">
                <p><strong>Deskripsi Toko:</strong></p>
                <p class="text-muted">{{ $shop->description }}</p>
            </div>
        </div>
        <div class="mt-3">
            <a href="{{ route('seller.shop.edit') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-edit me-2"></i>Edit Toko
            </a>
        </div>
    </div>
    
    <!-- Quick Actions -->
    <div class="section-card">
        <div class="section-title">
            <i class="fas fa-bolt me-2"></i>Aksi Cepat
        </div>
        <div class="quick-actions">
            <a href="{{ route('seller.products.create') }}" class="action-btn">
                <i class="fas fa-plus-circle"></i>
                <span>Tambah Produk</span>
            </a>
            <a href="{{ route('seller.products.index') }}" class="action-btn">
                <i class="fas fa-list"></i>
                <span>Kelola Produk</span>
            </a>
            <a href="{{ route('seller.shop') }}" class="action-btn">
                <i class="fas fa-eye"></i>
                <span>Lihat Toko</span>
            </a>
            <a href="{{ route('messages.index') }}" class="action-btn">
                <i class="fas fa-comments"></i>
                <span>Pesan</span>
            </a>
            <a href="{{ route('seller.orders') }}" class="action-btn">
                <i class="fas fa-clipboard-list"></i>
                <span>Kelola Pesanan</span>
              </a>
        </div>
    </div>
</div>
@endsection
