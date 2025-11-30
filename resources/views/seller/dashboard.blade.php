@extends('layouts.app')

@section('title', 'Dashboard - PestiMart')

@section('content')
<style>
    .dashboard-header {
        background: var(--gradient-primary);
        color: var(--color-white);
        padding: var(--space-8) 0;
        margin-bottom: var(--space-8);
    }
    
    /* Section Reveal Animation */
    .section-reveal {
        opacity: 0;
        transform: translateY(50px);
        transition: opacity 0.8s cubic-bezier(0.16, 1, 0.3, 1),
                    transform 0.8s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .section-reveal.in-view {
        opacity: 1;
        transform: translateY(0);
    }

    /* Staggered stat card reveal */
    .stats-grid .stat-link {
        opacity: 0;
        transform: translateY(30px) scale(0.95);
        transition: opacity 0.6s ease, transform 0.6s ease;
    }

    .stats-grid.in-view .stat-link:nth-child(1) { transition-delay: 0.1s; }
    .stats-grid.in-view .stat-link:nth-child(2) { transition-delay: 0.2s; }
    .stats-grid.in-view .stat-link:nth-child(3) { transition-delay: 0.3s; }
    .stats-grid.in-view .stat-link:nth-child(4) { transition-delay: 0.4s; }
    .stats-grid.in-view .stat-link:nth-child(5) { transition-delay: 0.5s; }

    .stats-grid.in-view .stat-link {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
    
    .stat-card {
        background: var(--color-white);
        padding: var(--space-6);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-card);
        border: 1px solid var(--color-border);
        margin-bottom: var(--space-4);
        text-align: center;
        transition: all var(--transition-base);
        position: relative;
        overflow: hidden;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--color-primary), var(--color-secondary));
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .stat-card:hover::before {
        opacity: 1;
    }

    @media (hover: hover) {
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-card-hover);
        }
    }
    
    .stat-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 50px;
        height: 50px;
        border-radius: var(--radius-full);
        margin: 0 auto var(--space-4);
        font-size: var(--font-size-2xl);
    }
    
    .stat-icon.primary { background: var(--color-primary); color: var(--color-white); }
    .stat-icon.success { background: var(--color-success); color: var(--color-white); }
    .stat-icon.warning { background: var(--color-accent); color: var(--color-white); }
    .stat-icon.danger { background: var(--color-danger); color: var(--color-white); }
    
    .stat-value {
        font-size: var(--font-size-2xl);
        font-weight: 700;
        color: var(--color-neutral-dark);
        margin-bottom: var(--space-2);
    }

    @media (max-width: 575.98px) {
        .stat-value {
            font-size: var(--font-size-xl);
        }
    }
    
    .stat-label {
        color: var(--color-text-muted);
        font-size: var(--font-size-sm);
        font-weight: 500;
    }
    
    .section-card {
        background: var(--color-white);
        padding: var(--space-4);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-card);
        border: 1px solid var(--color-border);
        margin-bottom: var(--space-6);
    }

    @media (min-width: 768px) {
        .section-card {
            padding: var(--space-6);
        }
    }
    
    .section-title {
        font-size: var(--font-size-lg);
        font-weight: 600;
        margin-bottom: var(--space-6);
        padding-bottom: var(--space-4);
        border-bottom: 2px solid var(--color-border);
        color: var(--color-neutral-dark);
        display: flex;
        align-items: center;
        gap: var(--space-2);
    }

    .section-title i {
        color: var(--color-primary);
    }
    
    .quick-actions {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: var(--space-4);
    }

    @media (min-width: 576px) {
        .quick-actions {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    @media (min-width: 992px) {
        .quick-actions {
            grid-template-columns: repeat(5, 1fr);
        }
    }
    
    .action-btn {
        padding: var(--space-4);
        text-align: center;
        border: 2px solid var(--color-border);
        border-radius: var(--radius-lg);
        background: var(--color-white);
        cursor: pointer;
        transition: all var(--transition-fast);
        text-decoration: none;
        color: var(--color-neutral-dark);
    }

    @media (hover: hover) {
        .action-btn:hover {
            border-color: var(--color-primary);
            background: rgba(58, 123, 255, 0.05);
            color: var(--color-primary);
        }
    }
    
    .action-btn i {
        display: block;
        font-size: var(--font-size-2xl);
        margin-bottom: var(--space-2);
        color: var(--color-primary);
    }
    
    .action-btn span {
        display: block;
        font-weight: 600;
        font-size: var(--font-size-sm);
    }

    .chart-container {
        position: relative;
        width: 100%;
        height: clamp(240px, 40vw, 400px);
        background: linear-gradient(180deg, rgba(58, 123, 255, 0.02) 0%, rgba(110, 203, 249, 0.05) 100%);
        border-radius: var(--radius-lg);
        padding: var(--space-4);
    }

    /* Unique Chart Styling */
    .chart-wrapper {
        position: relative;
    }

    .chart-wrapper::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 80%;
        height: 60%;
        background: radial-gradient(ellipse at center, rgba(58, 123, 255, 0.08) 0%, transparent 70%);
        transform: translate(-50%, -50%);
        pointer-events: none;
        z-index: 0;
    }

    .chart-glow {
        filter: drop-shadow(0 0 20px rgba(58, 123, 255, 0.15));
    }

    .stat-link {
        text-decoration: none;
        color: inherit;
        display: block;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: var(--space-4);
    }

    @media (min-width: 576px) {
        .stats-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    @media (min-width: 992px) {
        .stats-grid {
            grid-template-columns: repeat(5, 1fr);
        }
    }
</style>

<div class="dashboard-header">
    <div class="container">
        <h2 class="heading-clamp">
            <i class="fas fa-tachometer-alt me-2"></i>Dashboard Penjual
        </h2>
        <p class="mt-2">Selamat datang, {{ auth()->user()->name }}!</p>
    </div>
</div>

<div class="container my-4">
    
    <!-- Revenue Chart -->
    <div class="section-card section-reveal chart-wrapper">
        <div class="section-title">
            <i class="fas fa-chart-line"></i>Revenue 12 Bulan Terakhir
        </div>
        <div class="chart-container chart-glow">
            <canvas id="revenueChart"></canvas>
        </div>
    </div>

    <!-- Statistics -->
    <div class="stats-grid section-reveal mb-4">
        <a href="{{ route('seller.products.index') }}" class="stat-link">
            <div class="stat-card">
                <div class="stat-icon primary">
                    <i class="fas fa-box"></i>
                </div>
                <div class="stat-value">{{ $totalProducts }}</div>
                <div class="stat-label">Total Produk</div>
            </div>
        </a>

        <a href="{{ route('seller.orders') }}" class="stat-link">
            <div class="stat-card">
                <div class="stat-icon warning">
                    <i class="fas fa-shopping-bag"></i>
                </div>
                <div class="stat-value">{{ $totalOrders }}</div>
                <div class="stat-label">Total Pesanan</div>
            </div>
        </a>

        <a href="{{ route('seller.orders') }}?status=pending" class="stat-link">
            <div class="stat-card">
                <div class="stat-icon danger">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-value">{{ $pendingOrders }}</div>
                <div class="stat-label">Pesanan Pending</div>
            </div>
        </a>

        <a href="{{ route('seller.orders') }}?return_status=requested" class="stat-link">
            <div class="stat-card">
                <div class="stat-icon danger">
                    <i class="fas fa-undo"></i>
                </div>
                <div class="stat-value">{{ $returnRequests ?? 0 }}</div>
                <div class="stat-label">Pesanan Retur</div>
            </div>
        </a>

        <a href="{{ route('seller.orders') }}" class="stat-link">
            <div class="stat-card">
                <div class="stat-icon success">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
                <div class="stat-value">Rp{{ number_format($totalRevenue, 0, ',', '.') }}</div>
                <div class="stat-label">Total Revenue</div>
            </div>
        </a>
    </div>

    
    <!-- Shop Info -->
    <div class="section-card section-reveal">
        <div class="section-title">
            <i class="fas fa-store"></i>Informasi Toko
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
            <a href="{{ route('seller.shop.edit') }}" class="btn-gradient btn-gradient-sm">
                <i class="fas fa-edit me-2"></i>Edit Toko
            </a>
        </div>
    </div>
    
    <!-- Quick Actions -->
    <div class="section-card section-reveal">
        <div class="section-title">
            <i class="fas fa-bolt"></i>Aksi Cepat
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

<!-- Chart.js Library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

<script>
    // Section Reveal with IntersectionObserver
    function initSectionReveal() {
        const revealElements = document.querySelectorAll('.section-reveal');
        
        const revealObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('in-view');
                }
            });
        }, {
            threshold: 0.15,
            rootMargin: '0px 0px -50px 0px'
        });

        revealElements.forEach(el => revealObserver.observe(el));
    }

    // Initialize reveals
    document.addEventListener('DOMContentLoaded', initSectionReveal);

    // Revenue Chart Configuration with Unique Styling
    const primaryColor = getComputedStyle(document.documentElement).getPropertyValue('--color-primary').trim() || '#3A7BFF';
    const secondaryColor = getComputedStyle(document.documentElement).getPropertyValue('--color-secondary').trim() || '#6ECBF9';
    const accentColor = getComputedStyle(document.documentElement).getPropertyValue('--color-accent').trim() || '#FF8F3A';
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    
    // Create animated gradient
    const gradientFill = revenueCtx.createLinearGradient(0, 0, 0, 400);
    gradientFill.addColorStop(0, 'rgba(58, 123, 255, 0.35)');
    gradientFill.addColorStop(0.5, 'rgba(110, 203, 249, 0.15)');
    gradientFill.addColorStop(1, 'rgba(255, 143, 58, 0.02)');

    // Create border gradient
    const gradientBorder = revenueCtx.createLinearGradient(0, 0, 800, 0);
    gradientBorder.addColorStop(0, primaryColor);
    gradientBorder.addColorStop(0.5, secondaryColor);
    gradientBorder.addColorStop(1, accentColor);
    
    const revenueChart = new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($labels) !!},
            datasets: [{
                label: 'Revenue (Rp)',
                data: {!! json_encode($revenueData) !!},
                borderColor: gradientBorder,
                backgroundColor: gradientFill,
                borderWidth: 4,
                fill: true,
                tension: 0.4,
                pointRadius: 0,
                pointHoverRadius: 10,
                pointBackgroundColor: primaryColor,
                pointBorderColor: '#fff',
                pointBorderWidth: 3,
                pointHoverBackgroundColor: accentColor,
                pointHoverBorderColor: '#fff',
                pointHoverBorderWidth: 4,
                hoverBackgroundColor: 'rgba(58, 123, 255, 0.2)'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                mode: 'index',
                intersect: false
            },
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                    align: 'end',
                    labels: {
                        color: '#1A1F36',
                        font: {
                            size: 13,
                            weight: '600',
                            family: "'Poppins', sans-serif"
                        },
                        padding: 20,
                        usePointStyle: true,
                        pointStyle: 'rectRounded'
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(26, 31, 54, 0.95)',
                    titleColor: '#fff',
                    titleFont: {
                        size: 14,
                        weight: '600',
                        family: "'Poppins', sans-serif"
                    },
                    bodyColor: '#fff',
                    bodyFont: {
                        size: 16,
                        weight: '700',
                        family: "'Poppins', sans-serif"
                    },
                    borderColor: secondaryColor,
                    borderWidth: 2,
                    padding: 16,
                    cornerRadius: 12,
                    displayColors: false,
                    caretSize: 8,
                    callbacks: {
                        title: function(context) {
                            return '📅 ' + context[0].label;
                        },
                        label: function(context) {
                            let value = context.parsed.y;
                            return '💰 Rp' + value.toLocaleString('id-ID');
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        color: '#6c757d',
                        font: {
                            size: 11,
                            family: "'Poppins', sans-serif"
                        },
                        padding: 10,
                        callback: function(value) {
                            if (value >= 1000000) {
                                return 'Rp' + (value / 1000000).toFixed(1) + 'M';
                            }
                            return 'Rp' + (value / 1000).toFixed(0) + 'K';
                        }
                    },
                    grid: {
                        color: 'rgba(58, 123, 255, 0.08)',
                        drawBorder: false,
                        lineWidth: 1,
                        drawTicks: false
                    },
                    border: {
                        display: false
                    }
                },
                x: {
                    ticks: {
                        color: '#6c757d',
                        font: {
                            size: 11,
                            family: "'Poppins', sans-serif"
                        },
                        padding: 10
                    },
                    grid: {
                        display: false,
                        drawBorder: false
                    },
                    border: {
                        display: false
                    }
                }
            },
            elements: {
                line: {
                    capBezierPoints: true
                }
            },
            animation: {
                duration: 2000,
                easing: 'easeOutQuart'
            }
        }
    });
</script>
@endsection
