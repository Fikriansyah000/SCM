@extends('layouts.seller')

@section('title', 'Dashboard - PestiMart')

@section('page-title', 'Dashboard')

@section('content')
<style>
    /* Dashboard Header */
    .dashboard-welcome {
        background: var(--gradient-primary);
        color: var(--color-white);
        padding: var(--space-6);
        border-radius: var(--radius-lg);
        margin-bottom: var(--space-6);
        position: relative;
        overflow: hidden;
    }
    
    .dashboard-welcome::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }
    
    .dashboard-welcome h2 {
        font-size: var(--font-size-xl);
        font-weight: 700;
        margin-bottom: var(--space-2);
    }
    
    .dashboard-welcome p {
        opacity: 0.9;
        margin: 0;
    }
    
    /* Section Reveal Animation */
    .section-reveal {
        opacity: 0;
        transform: translateY(30px);
        transition: opacity 0.6s cubic-bezier(0.16, 1, 0.3, 1),
                    transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .section-reveal.in-view {
        opacity: 1;
        transform: translateY(0);
    }
    
    /* Chart Section */
    .chart-section {
        background: var(--color-white);
        border-radius: var(--radius-lg);
        border: 1px solid var(--color-border);
        box-shadow: var(--shadow-card);
        padding: var(--space-5);
        margin-bottom: var(--space-6);
    }
    
    .chart-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: var(--space-5);
        flex-wrap: wrap;
        gap: var(--space-3);
    }
    
    .chart-title {
        font-size: var(--font-size-lg);
        font-weight: 600;
        color: var(--color-neutral-dark);
        display: flex;
        align-items: center;
        gap: var(--space-2);
    }
    
    .chart-title i {
        color: var(--color-primary);
    }
    
    .chart-container {
        position: relative;
        width: 100%;
        height: 320px;
        background: linear-gradient(180deg, rgba(58, 123, 255, 0.02) 0%, rgba(110, 203, 249, 0.05) 100%);
        border-radius: var(--radius-md);
        padding: var(--space-4);
    }
    
    .chart-container.chart-sm {
        height: 220px;
    }

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
    
    /* Charts Grid */
    .charts-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: var(--space-5);
        margin-bottom: var(--space-6);
    }
    
    @media (min-width: 992px) {
        .charts-grid {
            grid-template-columns: 1fr 1fr;
        }
    }
    
    /* Summary Cards */
    .summary-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: var(--space-4);
        margin-bottom: var(--space-6);
    }
    
    .summary-card {
        background: var(--color-white);
        padding: var(--space-5);
        border-radius: var(--radius-lg);
        border: 1px solid var(--color-border);
        box-shadow: var(--shadow-card);
        display: flex;
        align-items: center;
        gap: var(--space-4);
        transition: all var(--transition-base);
    }
    
    .summary-card:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-card-hover);
    }
    
    .summary-icon {
        width: 56px;
        height: 56px;
        border-radius: var(--radius-lg);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: var(--font-size-xl);
        flex-shrink: 0;
    }
    
    .summary-icon.yearly {
        background: linear-gradient(135deg, #3A7BFF 0%, #6ECBF9 100%);
        color: white;
    }
    
    .summary-icon.weekly {
        background: linear-gradient(135deg, #10B981 0%, #34D399 100%);
        color: white;
    }
    
    .summary-icon.daily {
        background: linear-gradient(135deg, #FF8F3A 0%, #FBBF24 100%);
        color: white;
    }
    
    .summary-info h4 {
        font-size: var(--font-size-xs);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: var(--color-text-muted);
        margin-bottom: var(--space-1);
    }
    
    .summary-value {
        font-size: var(--font-size-xl);
        font-weight: 700;
        color: var(--color-neutral-dark);
    }
    
    @media (max-width: 575.98px) {
        .summary-value {
            font-size: var(--font-size-lg);
        }
    }
    
    /* Action Cards Section */
    .section-title {
        font-size: var(--font-size-lg);
        font-weight: 600;
        margin-bottom: var(--space-5);
        color: var(--color-neutral-dark);
        display: flex;
        align-items: center;
        gap: var(--space-2);
    }
    
    .section-title i {
        color: var(--color-primary);
    }
    
    .action-cards-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: var(--space-4);
    }
    
    .action-card {
        background: var(--color-white);
        border-radius: var(--radius-lg);
        border: 1px solid var(--color-border);
        box-shadow: var(--shadow-card);
        padding: var(--space-5);
        text-decoration: none;
        color: inherit;
        display: flex;
        align-items: center;
        gap: var(--space-4);
        transition: all var(--transition-base);
        position: relative;
        overflow: hidden;
    }
    
    .action-card::before {
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
    
    .action-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-card-hover);
        border-color: var(--color-primary);
    }
    
    .action-card:hover::before {
        opacity: 1;
    }
    
    .action-card-icon {
        width: 56px;
        height: 56px;
        border-radius: var(--radius-lg);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: var(--font-size-xl);
        flex-shrink: 0;
    }
    
    .action-card-icon.proposals {
        background: linear-gradient(135deg, #8B5CF6 0%, #A78BFA 100%);
        color: white;
    }
    
    .action-card-icon.orders {
        background: linear-gradient(135deg, #3A7BFF 0%, #6ECBF9 100%);
        color: white;
    }
    
    .action-card-icon.products {
        background: linear-gradient(135deg, #10B981 0%, #34D399 100%);
        color: white;
    }
    
    .action-card-icon.returns {
        background: linear-gradient(135deg, #EF4444 0%, #F87171 100%);
        color: white;
    }
    
    .action-card-content {
        flex: 1;
        min-width: 0;
    }
    
    .action-card-title {
        font-size: var(--font-size-base);
        font-weight: 600;
        color: var(--color-neutral-dark);
        margin-bottom: var(--space-1);
    }
    
    .action-card-desc {
        font-size: var(--font-size-sm);
        color: var(--color-text-muted);
        margin: 0;
    }
    
    .action-card-badge {
        background: var(--color-danger);
        color: white;
        font-size: var(--font-size-xs);
        font-weight: 600;
        padding: var(--space-1) var(--space-3);
        border-radius: var(--radius-full);
    }
    
    .action-card-arrow {
        color: var(--color-text-muted);
        transition: transform 0.2s ease, color 0.2s ease;
    }
    
    .action-card:hover .action-card-arrow {
        transform: translateX(4px);
        color: var(--color-primary);
    }

    /* ========== Mobile Responsive ========== */
    @media (max-width: 991.98px) {
        .dashboard-welcome {
            padding: var(--space-5);
        }
        .dashboard-welcome::before {
            width: 200px;
            height: 200px;
        }
        .chart-section {
            padding: var(--space-4);
        }
        .chart-container {
            height: 280px;
        }
        .chart-container.chart-sm {
            height: 200px;
        }
        .summary-grid {
            grid-template-columns: repeat(2, 1fr);
        }
        .action-cards-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 767.98px) {
        .dashboard-welcome {
            padding: var(--space-4);
            border-radius: var(--radius-md);
            margin-bottom: var(--space-4);
        }
        .dashboard-welcome h2 {
            font-size: var(--font-size-lg);
        }
        .dashboard-welcome p {
            font-size: var(--font-size-sm);
        }
        .dashboard-welcome::before {
            display: none;
        }
        .chart-section {
            padding: var(--space-3);
            margin-bottom: var(--space-4);
            border-radius: var(--radius-md);
        }
        .chart-header {
            flex-direction: column;
            align-items: flex-start;
        }
        .chart-title {
            font-size: var(--font-size-base);
        }
        .chart-container {
            height: 250px;
            padding: var(--space-2);
        }
        .chart-container.chart-sm {
            height: 180px;
        }
        .charts-grid {
            gap: var(--space-4);
            margin-bottom: var(--space-4);
        }
        .summary-grid {
            gap: var(--space-3);
            margin-bottom: var(--space-4);
        }
        .summary-card {
            padding: var(--space-4);
        }
        .summary-card-icon {
            width: 44px;
            height: 44px;
            font-size: var(--font-size-lg);
        }
        .section-title {
            font-size: var(--font-size-base);
            margin-bottom: var(--space-4);
        }
        .action-cards-grid {
            grid-template-columns: 1fr;
            gap: var(--space-3);
        }
        .action-card {
            padding: var(--space-4);
            gap: var(--space-3);
        }
        .action-card-icon {
            width: 48px;
            height: 48px;
            font-size: var(--font-size-lg);
        }
    }

    @media (max-width: 575.98px) {
        .dashboard-welcome {
            padding: 1rem;
        }
        .dashboard-welcome h2 {
            font-size: 1.1rem;
        }
        .summary-grid {
            grid-template-columns: 1fr 1fr;
            gap: 0.75rem;
        }
        .summary-card {
            padding: 0.875rem;
            flex-direction: column;
            align-items: flex-start;
            gap: 0.75rem;
        }
        .summary-card-icon {
            width: 40px;
            height: 40px;
            font-size: 1rem;
        }
        .summary-label {
            font-size: 0.7rem;
        }
        .summary-value {
            font-size: 1rem;
        }
        .chart-section {
            padding: 0.75rem;
        }
        .chart-title {
            font-size: 0.9rem;
        }
        .chart-container {
            height: 220px;
            padding: 0.5rem;
        }
        .action-card {
            padding: 0.875rem;
        }
        .action-card-icon {
            width: 44px;
            height: 44px;
        }
        .action-card-title {
            font-size: 0.9rem;
        }
        .action-card-desc {
            font-size: 0.8rem;
        }
    }
</style>

<!-- Welcome Header -->
<div class="dashboard-welcome section-reveal">
    <h2><i class="fas fa-hand-wave me-2"></i>Selamat datang, {{ auth()->user()->name }}!</h2>
    <p>Berikut ringkasan performa toko Anda</p>
</div>

<!-- Main Revenue Chart (Full Width) -->
<div class="chart-section section-reveal chart-wrapper">
    <div class="chart-header">
        <div class="chart-title">
            <i class="fas fa-chart-line"></i>
            Revenue 12 Bulan Terakhir
        </div>
    </div>
    <div class="chart-container chart-glow">
        <canvas id="revenueChart"></canvas>
    </div>
</div>

<!-- Weekly & Daily Charts Grid -->
<div class="charts-grid">
    <div class="chart-section section-reveal">
        <div class="chart-header">
            <div class="chart-title">
                <i class="fas fa-calendar-week"></i>
                Revenue Mingguan
            </div>
        </div>
        <div class="chart-container chart-sm">
            <canvas id="weeklyChart"></canvas>
        </div>
    </div>
    
    <div class="chart-section section-reveal">
        <div class="chart-header">
            <div class="chart-title">
                <i class="fas fa-calendar-day"></i>
                Revenue Harian
            </div>
        </div>
        <div class="chart-container chart-sm">
            <canvas id="dailyChart"></canvas>
        </div>
    </div>
</div>

<!-- Revenue Summary Cards -->
<div class="summary-grid section-reveal">
    <div class="summary-card">
        <div class="summary-icon yearly">
            <i class="fas fa-calendar-alt"></i>
        </div>
        <div class="summary-info">
            <h4>Revenue Tahun Ini</h4>
            <div class="summary-value">Rp{{ number_format($yearlyRevenue ?? $totalRevenue ?? 0, 0, ',', '.') }}</div>
        </div>
    </div>
    
    <div class="summary-card">
        <div class="summary-icon weekly">
            <i class="fas fa-calendar-week"></i>
        </div>
        <div class="summary-info">
            <h4>Revenue Minggu Ini</h4>
            <div class="summary-value">Rp{{ number_format($weeklyRevenue ?? 0, 0, ',', '.') }}</div>
        </div>
    </div>
    
    <div class="summary-card">
        <div class="summary-icon daily">
            <i class="fas fa-calendar-day"></i>
        </div>
        <div class="summary-info">
            <h4>Revenue Hari Ini</h4>
            <div class="summary-value">Rp{{ number_format($dailyRevenue ?? 0, 0, ',', '.') }}</div>
        </div>
    </div>
</div>

<!-- Action Cards Section -->
<div class="section-reveal">
    <h3 class="section-title">
        <i class="fas fa-tasks"></i>
        Kelola Toko
    </h3>
    
    <div class="action-cards-grid">
        <a href="{{ route('seller.services.proposals') }}?status=pending" class="action-card">
            <div class="action-card-icon proposals">
                <i class="fas fa-file-contract"></i>
            </div>
            <div class="action-card-content">
                <div class="action-card-title">Layanan Pending</div>
                <p class="action-card-desc">Proposal layanan menunggu persetujuan</p>
            </div>
            @if(($pendingProposals ?? 0) > 0)
                <span class="action-card-badge">{{ $pendingProposals }}</span>
            @endif
            <i class="fas fa-chevron-right action-card-arrow"></i>
        </a>
        
        <a href="{{ route('seller.orders') }}?status=pending" class="action-card">
            <div class="action-card-icon orders">
                <i class="fas fa-shopping-bag"></i>
            </div>
            <div class="action-card-content">
                <div class="action-card-title">Pesanan Pending</div>
                <p class="action-card-desc">Pesanan baru menunggu konfirmasi</p>
            </div>
            @if(($pendingOrders ?? 0) > 0)
                <span class="action-card-badge">{{ $pendingOrders }}</span>
            @endif
            <i class="fas fa-chevron-right action-card-arrow"></i>
        </a>
        
        <a href="{{ route('seller.products.index') }}" class="action-card">
            <div class="action-card-icon products">
                <i class="fas fa-box"></i>
            </div>
            <div class="action-card-content">
                <div class="action-card-title">Kelola Produk</div>
                <p class="action-card-desc">{{ $totalProducts ?? 0 }} produk aktif</p>
            </div>
            <i class="fas fa-chevron-right action-card-arrow"></i>
        </a>
        
        <a href="{{ route('seller.orders') }}?return_status=requested" class="action-card">
            <div class="action-card-icon returns">
                <i class="fas fa-undo"></i>
            </div>
            <div class="action-card-content">
                <div class="action-card-title">Permintaan Retur</div>
                <p class="action-card-desc">Pesanan retur menunggu proses</p>
            </div>
            @if(($returnRequests ?? 0) > 0)
                <span class="action-card-badge">{{ $returnRequests }}</span>
            @endif
            <i class="fas fa-chevron-right action-card-arrow"></i>
        </a>
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
            threshold: 0.1,
            rootMargin: '0px 0px -30px 0px'
        });

        revealElements.forEach(el => revealObserver.observe(el));
    }

    document.addEventListener('DOMContentLoaded', initSectionReveal);

    // Chart Colors
    const primaryColor = getComputedStyle(document.documentElement).getPropertyValue('--color-primary').trim() || '#3A7BFF';
    const secondaryColor = getComputedStyle(document.documentElement).getPropertyValue('--color-secondary').trim() || '#6ECBF9';
    const accentColor = getComputedStyle(document.documentElement).getPropertyValue('--color-accent').trim() || '#FF8F3A';
    const successColor = '#10B981';
    
    // Main Revenue Chart (Yearly)
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    
    const gradientFill = revenueCtx.createLinearGradient(0, 0, 0, 400);
    gradientFill.addColorStop(0, 'rgba(58, 123, 255, 0.35)');
    gradientFill.addColorStop(0.5, 'rgba(110, 203, 249, 0.15)');
    gradientFill.addColorStop(1, 'rgba(255, 143, 58, 0.02)');

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
                pointHoverBorderWidth: 4
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
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(26, 31, 54, 0.95)',
                    titleColor: '#fff',
                    titleFont: { size: 14, weight: '600', family: "'Poppins', sans-serif" },
                    bodyColor: '#fff',
                    bodyFont: { size: 16, weight: '700', family: "'Poppins', sans-serif" },
                    borderColor: secondaryColor,
                    borderWidth: 2,
                    padding: 16,
                    cornerRadius: 12,
                    displayColors: false,
                    caretSize: 8,
                    callbacks: {
                        title: function(context) { return '📅 ' + context[0].label; },
                        label: function(context) { return '💰 Rp' + context.parsed.y.toLocaleString('id-ID'); }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        color: '#6c757d',
                        font: { size: 11, family: "'Poppins', sans-serif" },
                        padding: 10,
                        callback: function(value) {
                            if (value >= 1000000) return 'Rp' + (value / 1000000).toFixed(1) + 'M';
                            return 'Rp' + (value / 1000).toFixed(0) + 'K';
                        }
                    },
                    grid: { color: 'rgba(58, 123, 255, 0.08)', drawBorder: false },
                    border: { display: false }
                },
                x: {
                    ticks: { color: '#6c757d', font: { size: 11, family: "'Poppins', sans-serif" }, padding: 10 },
                    grid: { display: false },
                    border: { display: false }
                }
            },
            animation: { duration: 2000, easing: 'easeOutQuart' }
        }
    });
    
    // Weekly Revenue Chart
    const weeklyCtx = document.getElementById('weeklyChart').getContext('2d');
    
    const weeklyGradient = weeklyCtx.createLinearGradient(0, 0, 0, 200);
    weeklyGradient.addColorStop(0, 'rgba(16, 185, 129, 0.3)');
    weeklyGradient.addColorStop(1, 'rgba(16, 185, 129, 0.02)');
    
    new Chart(weeklyCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($weeklyLabels ?? ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min']) !!},
            datasets: [{
                label: 'Revenue',
                data: {!! json_encode($weeklyData ?? [0,0,0,0,0,0,0]) !!},
                backgroundColor: weeklyGradient,
                borderColor: successColor,
                borderWidth: 2,
                borderRadius: 8,
                borderSkipped: false
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: 'rgba(26, 31, 54, 0.95)',
                    padding: 12,
                    cornerRadius: 8,
                    callbacks: {
                        label: function(context) { return 'Rp' + context.parsed.y.toLocaleString('id-ID'); }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        color: '#6c757d',
                        font: { size: 10 },
                        callback: function(value) {
                            if (value >= 1000000) return (value / 1000000).toFixed(0) + 'M';
                            if (value >= 1000) return (value / 1000).toFixed(0) + 'K';
                            return value;
                        }
                    },
                    grid: { color: 'rgba(0,0,0,0.05)' },
                    border: { display: false }
                },
                x: {
                    ticks: { color: '#6c757d', font: { size: 10 } },
                    grid: { display: false },
                    border: { display: false }
                }
            }
        }
    });
    
    // Daily Revenue Chart
    const dailyCtx = document.getElementById('dailyChart').getContext('2d');
    
    const dailyGradient = dailyCtx.createLinearGradient(0, 0, 0, 200);
    dailyGradient.addColorStop(0, 'rgba(255, 143, 58, 0.3)');
    dailyGradient.addColorStop(1, 'rgba(255, 143, 58, 0.02)');
    
    new Chart(dailyCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($dailyLabels ?? ['00:00', '04:00', '08:00', '12:00', '16:00', '20:00', '24:00']) !!},
            datasets: [{
                label: 'Revenue',
                data: {!! json_encode($dailyData ?? [0,0,0,0,0,0,0]) !!},
                backgroundColor: dailyGradient,
                borderColor: accentColor,
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointRadius: 4,
                pointBackgroundColor: accentColor,
                pointBorderColor: '#fff',
                pointBorderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: 'rgba(26, 31, 54, 0.95)',
                    padding: 12,
                    cornerRadius: 8,
                    callbacks: {
                        label: function(context) { return 'Rp' + context.parsed.y.toLocaleString('id-ID'); }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        color: '#6c757d',
                        font: { size: 10 },
                        callback: function(value) {
                            if (value >= 1000000) return (value / 1000000).toFixed(0) + 'M';
                            if (value >= 1000) return (value / 1000).toFixed(0) + 'K';
                            return value;
                        }
                    },
                    grid: { color: 'rgba(0,0,0,0.05)' },
                    border: { display: false }
                },
                x: {
                    ticks: { color: '#6c757d', font: { size: 10 } },
                    grid: { display: false },
                    border: { display: false }
                }
            }
        }
    });
</script>
@endsection
