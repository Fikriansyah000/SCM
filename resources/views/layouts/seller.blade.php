<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Seller Dashboard - PestiMart')</title>
    
    <!-- Google Fonts - Poppins for Display Typography -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Site Design System -->
    <link rel="stylesheet" href="{{ asset('css/site.css') }}">
    
    <style>
        /* ========================================
           SELLER SIDEBAR LAYOUT SYSTEM
        ======================================== */
        
        :root {
            --sidebar-width: 260px;
            --sidebar-collapsed-width: 72px;
            --header-height: 64px;
        }
        
        /* Seller Layout Container */
        .seller-layout {
            display: flex;
            min-height: 100vh;
            background: var(--color-bg);
        }
        
        /* Sidebar */
        .seller-sidebar {
            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;
            width: var(--sidebar-width);
            background: linear-gradient(180deg, #1A1F36 0%, #252B43 100%);
            z-index: 1040;
            display: flex;
            flex-direction: column;
            transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1), transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 4px 0 24px rgba(0, 0, 0, 0.15);
        }
        
        .seller-sidebar.collapsed {
            width: var(--sidebar-collapsed-width);
        }
        
        /* Sidebar Header with Logo */
        .sidebar-header {
            padding: var(--space-5) var(--space-4);
            display: flex;
            align-items: center;
            gap: var(--space-3);
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            min-height: var(--header-height);
        }
        
        .sidebar-logo {
            width: 40px;
            height: 40px;
            border-radius: var(--radius-md);
            object-fit: contain;
            flex-shrink: 0;
        }
        
        .sidebar-brand {
            font-size: var(--font-size-lg);
            font-weight: 700;
            color: var(--color-white);
            white-space: nowrap;
            opacity: 1;
            transition: opacity 0.2s ease;
        }
        
        .seller-sidebar.collapsed .sidebar-brand {
            opacity: 0;
            width: 0;
            overflow: hidden;
        }
        
        /* Sidebar Toggle Button */
        .sidebar-toggle {
            position: absolute;
            right: -14px;
            top: 22px;
            width: 28px;
            height: 28px;
            background: var(--color-primary);
            border: 3px solid var(--color-bg);
            border-radius: var(--radius-full);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 10;
            transition: transform 0.3s ease, background 0.2s ease;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }
        
        .sidebar-toggle:hover {
            background: var(--color-primary-dark);
            transform: scale(1.1);
        }
        
        .sidebar-toggle i {
            color: white;
            font-size: 12px;
            transition: transform 0.3s ease;
        }
        
        .seller-sidebar.collapsed .sidebar-toggle i {
            transform: rotate(180deg);
        }
        
        /* Sidebar Navigation */
        .sidebar-nav {
            flex: 1;
            padding: var(--space-4) 0;
            overflow-y: auto;
            overflow-x: hidden;
        }
        
        .sidebar-nav::-webkit-scrollbar {
            width: 4px;
        }
        
        .sidebar-nav::-webkit-scrollbar-track {
            background: transparent;
        }
        
        .sidebar-nav::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 4px;
        }
        
        .nav-section {
            margin-bottom: var(--space-4);
        }
        
        .nav-section-title {
            padding: var(--space-2) var(--space-5);
            font-size: var(--font-size-xs);
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: rgba(255, 255, 255, 0.4);
            font-weight: 600;
            white-space: nowrap;
            overflow: hidden;
        }
        
        .seller-sidebar.collapsed .nav-section-title {
            opacity: 0;
            height: 0;
            padding: 0;
            margin: 0;
        }
        
        .sidebar-link {
            display: flex;
            align-items: center;
            gap: var(--space-3);
            padding: var(--space-3) var(--space-5);
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            font-size: var(--font-size-sm);
            font-weight: 500;
            transition: all 0.2s ease;
            position: relative;
            white-space: nowrap;
            margin: var(--space-1) var(--space-3);
            border-radius: var(--radius-md);
        }
        
        .sidebar-link:hover {
            color: var(--color-white);
            background: rgba(255, 255, 255, 0.08);
        }
        
        .sidebar-link.active {
            color: var(--color-white);
            background: var(--gradient-primary);
            box-shadow: 0 4px 12px rgba(30, 58, 95, 0.4);
        }
        
        .sidebar-link i {
            width: 20px;
            font-size: 16px;
            text-align: center;
            flex-shrink: 0;
        }
        
        .sidebar-link span {
            opacity: 1;
            transition: opacity 0.2s ease;
        }
        
        .seller-sidebar.collapsed .sidebar-link {
            justify-content: center;
            padding: var(--space-3);
        }
        
        .seller-sidebar.collapsed .sidebar-link span {
            opacity: 0;
            width: 0;
            overflow: hidden;
        }
        
        /* Badge for notifications */
        .sidebar-badge {
            margin-left: auto;
            background: var(--color-danger);
            color: white;
            font-size: 10px;
            padding: 2px 6px;
            border-radius: var(--radius-full);
            font-weight: 600;
        }
        
        .seller-sidebar.collapsed .sidebar-badge {
            display: none;
        }
        
        /* Sidebar Footer */
        .sidebar-footer {
            padding: var(--space-4);
            border-top: 1px solid rgba(255, 255, 255, 0.08);
        }
        
        .sidebar-user {
            display: flex;
            align-items: center;
            gap: var(--space-3);
            padding: var(--space-3);
            background: rgba(255, 255, 255, 0.05);
            border-radius: var(--radius-md);
        }
        
        .sidebar-user-avatar {
            width: 36px;
            height: 36px;
            border-radius: var(--radius-full);
            background: var(--gradient-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            flex-shrink: 0;
        }
        
        .sidebar-user-info {
            flex: 1;
            min-width: 0;
        }
        
        .sidebar-user-name {
            color: var(--color-white);
            font-size: var(--font-size-sm);
            font-weight: 600;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        .sidebar-user-role {
            color: rgba(255, 255, 255, 0.5);
            font-size: var(--font-size-xs);
        }
        
        .seller-sidebar.collapsed .sidebar-user-info {
            display: none;
        }
        
        .sidebar-logout {
            margin-top: var(--space-3);
        }
        
        .sidebar-logout button {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: var(--space-2);
            padding: var(--space-3);
            background: rgba(239, 68, 68, 0.15);
            border: 1px solid rgba(239, 68, 68, 0.3);
            border-radius: var(--radius-md);
            color: #f87171;
            font-size: var(--font-size-sm);
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        
        .sidebar-logout button:hover {
            background: rgba(239, 68, 68, 0.25);
        }
        
        .seller-sidebar.collapsed .sidebar-logout span {
            display: none;
        }
        
        /* Main Content Area */
        .seller-main {
            flex: 1;
            margin-left: var(--sidebar-width);
            min-width: 0;
            transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .seller-sidebar.collapsed ~ .seller-main {
            margin-left: var(--sidebar-collapsed-width);
        }
        
        /* Top Header Bar */
        .seller-topbar {
            position: sticky;
            top: 0;
            z-index: 1020;
            background: var(--color-white);
            border-bottom: 1px solid var(--color-border);
            padding: 0 var(--space-6);
            height: var(--header-height);
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .seller-topbar * {
            pointer-events: auto;
        }
        
        .topbar-title {
            font-size: var(--font-size-lg);
            font-weight: 600;
            color: var(--color-neutral-dark);
        }
        
        .topbar-badge {
            position: absolute;
            top: -2px;
            right: -2px;
            width: 18px;
            height: 18px;
            background: var(--color-danger);
            color: white;
            font-size: 10px;
            border-radius: var(--radius-full);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }
        
        /* Content Wrapper */
        .seller-content {
            padding: var(--space-6);
            min-height: calc(100vh - var(--header-height));
        }
        
        /* Mobile Overlay */
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1035;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .sidebar-overlay.active {
            opacity: 1;
        }
        
        /* Mobile Menu Toggle */
        .mobile-menu-btn {
            display: none;
            width: 40px;
            height: 40px;
            border-radius: var(--radius-md);
            background: var(--color-bg);
            border: 1px solid var(--color-border);
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: var(--color-text);
            z-index: 100;
        }

        .mobile-menu-btn:hover {
            background: var(--color-primary);
            color: white;
            border-color: var(--color-primary);
        }

        /* Topbar Actions - ensure clickable */
        .topbar-actions {
            display: flex;
            align-items: center;
            gap: var(--space-3);
            position: relative;
            z-index: 100;
        }

        .topbar-icon-btn {
            width: 40px;
            height: 40px;
            border-radius: var(--radius-full);
            background: var(--color-bg);
            border: 1px solid var(--color-border);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--color-text-muted);
            text-decoration: none;
            position: relative;
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .topbar-icon-btn:hover {
            background: var(--color-primary);
            border-color: var(--color-primary);
            color: white;
            transform: scale(1.05);
        }
        
        /* ========================================
           RESPONSIVE STYLES
        ======================================== */
        
        /* Tablet - Sidebar always collapsed */
        @media (max-width: 991.98px) {
            .seller-sidebar {
                width: var(--sidebar-collapsed-width);
            }
            
            .seller-sidebar .sidebar-brand,
            .seller-sidebar .nav-section-title,
            .seller-sidebar .sidebar-link span,
            .seller-sidebar .sidebar-badge,
            .seller-sidebar .sidebar-user-info,
            .seller-sidebar .sidebar-logout span {
                opacity: 0;
                width: 0;
                overflow: hidden;
            }
            
            .seller-sidebar .sidebar-link {
                justify-content: center;
                padding: var(--space-3);
            }
            
            .seller-sidebar .sidebar-toggle {
                display: none;
            }
            
            .seller-main {
                margin-left: var(--sidebar-collapsed-width);
            }
        }
        
        /* Mobile - Sidebar as drawer */
        @media (max-width: 767.98px) {
            .seller-sidebar {
                transform: translateX(-100%);
                width: var(--sidebar-width);
            }
            
            .seller-sidebar.mobile-open {
                transform: translateX(0);
            }
            
            .seller-sidebar.mobile-open .sidebar-brand,
            .seller-sidebar.mobile-open .nav-section-title,
            .seller-sidebar.mobile-open .sidebar-link span,
            .seller-sidebar.mobile-open .sidebar-badge,
            .seller-sidebar.mobile-open .sidebar-user-info,
            .seller-sidebar.mobile-open .sidebar-logout span {
                opacity: 1;
                width: auto;
            }
            
            .seller-sidebar.mobile-open .sidebar-link {
                justify-content: flex-start;
                padding: var(--space-3) var(--space-5);
            }
            
            .seller-main {
                margin-left: 0;
            }
            
            .sidebar-overlay {
                display: block;
                pointer-events: none;
            }

            .sidebar-overlay.active {
                pointer-events: auto;
            }
            
            .mobile-menu-btn {
                display: flex !important;
            }
            
            .seller-content {
                padding: var(--space-4);
            }
            
            .seller-topbar {
                padding: 0 var(--space-4);
                position: sticky;
                top: 0;
                z-index: 1020;
            }

            .topbar-title {
                font-size: var(--font-size-base);
            }

            .topbar-actions {
                gap: var(--space-2);
            }

            .topbar-icon-btn {
                width: 36px;
                height: 36px;
            }
        }

        /* Extra Small Mobile */
        @media (max-width: 575.98px) {
            .seller-topbar {
                padding: 0 0.75rem;
            }

            .topbar-title {
                font-size: 0.95rem;
            }

            .topbar-icon-btn {
                width: 34px;
                height: 34px;
            }

            .topbar-badge {
                width: 16px;
                height: 16px;
                font-size: 9px;
            }

            .mobile-menu-btn {
                width: 36px;
                height: 36px;
            }

            .seller-content {
                padding: 0.75rem;
            }
        }
        
        /* Legacy overrides from app.blade.php */
        .btn-primary {
            background: var(--gradient-primary);
            border: none;
            transition: transform var(--transition-fast);
        }
        
        .btn-primary:hover {
            background: var(--gradient-primary-hover);
            transform: translateY(-2px);
        }
        
        .form-control {
            border-radius: var(--radius-md);
            border: 1px solid var(--color-border);
            padding: var(--space-3) var(--space-4);
        }
        
        .form-control:focus {
            border-color: var(--color-primary);
            box-shadow: 0 0 0 0.2rem rgba(30, 58, 95, 0.25);
        }
        
        .alert {
            border-radius: var(--radius-md);
            border: none;
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <div class="seller-layout">
        <!-- Sidebar Overlay for Mobile -->
        <div class="sidebar-overlay" id="sidebarOverlay" onclick="closeMobileSidebar()"></div>
        
        <!-- Left Sidebar -->
        <aside class="seller-sidebar" id="sellerSidebar">
            <!-- Toggle Button -->
            <button class="sidebar-toggle" onclick="toggleSidebar()" title="Toggle Sidebar">
                <i class="fas fa-chevron-left"></i>
            </button>
            
            <!-- Sidebar Header -->
            <div class="sidebar-header">
                <img src="{{ asset('images/landing/logo-pestimart.png') }}" alt="PestiMart" class="sidebar-logo">
                <span class="sidebar-brand">PestiMart</span>
            </div>
            
            <!-- Navigation -->
            <nav class="sidebar-nav">
                <div class="nav-section">
                    <div class="nav-section-title">Menu Utama</div>
                    <a href="{{ route('seller.dashboard') }}" class="sidebar-link {{ request()->routeIs('seller.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-chart-pie"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="{{ route('seller.orders') }}" class="sidebar-link {{ request()->routeIs('seller.orders*') ? 'active' : '' }}">
                        <i class="fas fa-shopping-bag"></i>
                        <span>Kelola Pesanan</span>
                        @php
                            $pendingOrderCount = \App\Models\Order::whereHas('items.product', fn($q) => $q->where('shop_id', auth()->user()->shop->id ?? 0))
                                ->where('status', 'pending')->count();
                        @endphp
                        @if($pendingOrderCount > 0)
                            <span class="sidebar-badge">{{ $pendingOrderCount }}</span>
                        @endif
                    </a>
                    <a href="{{ route('seller.services.proposals') }}" class="sidebar-link {{ request()->routeIs('seller.services.proposals*') ? 'active' : '' }}">
                        <i class="fas fa-file-contract"></i>
                        <span>Kelola Proposal</span>
                        @php
                            $pendingProposalCount = \App\Models\ServiceProposal::whereHas('product', fn($q) => $q->where('shop_id', auth()->user()->shop->id ?? 0))
                                ->where('status', 'pending')->count();
                        @endphp
                        @if($pendingProposalCount > 0)
                            <span class="sidebar-badge">{{ $pendingProposalCount }}</span>
                        @endif
                    </a>
                </div>
                
                <div class="nav-section">
                    <div class="nav-section-title">Toko</div>
                    <a href="{{ route('seller.products.index') }}" class="sidebar-link {{ request()->routeIs('seller.products.*') ? 'active' : '' }}">
                        <i class="fas fa-box"></i>
                        <span>Produk</span>
                    </a>
                    <a href="{{ route('seller.shop') }}" class="sidebar-link {{ request()->routeIs('seller.shop') && !request()->routeIs('seller.shop.edit') ? 'active' : '' }}">
                        <i class="fas fa-store"></i>
                        <span>Lihat Toko</span>
                    </a>
                </div>
                
                <div class="nav-section">
                    <div class="nav-section-title">Lainnya</div>
                    <a href="{{ route('seller.messages.index') }}" class="sidebar-link {{ request()->routeIs('seller.messages.*') ? 'active' : '' }}">
                        <i class="fas fa-comments"></i>
                        <span>Pesan</span>
                    </a>
                    <a href="{{ route('seller.notifications.index') }}" class="sidebar-link {{ request()->routeIs('seller.notifications.*') ? 'active' : '' }}">
                        <i class="fas fa-bell"></i>
                        <span>Notifikasi</span>
                        @php
                            $unreadNotifCount = \App\Models\Notification::where('user_id', auth()->id())->where('is_read', false)->count();
                        @endphp
                        @if($unreadNotifCount > 0)
                            <span class="sidebar-badge">{{ $unreadNotifCount > 99 ? '99+' : $unreadNotifCount }}</span>
                        @endif
                    </a>
                    <a href="{{ route('seller.profile.show') }}" class="sidebar-link {{ request()->routeIs('seller.profile.*') ? 'active' : '' }}">
                        <i class="fas fa-cog"></i>
                        <span>Pengaturan</span>
                    </a>
                </div>
            </nav>
            
            <!-- Sidebar Footer -->
            <div class="sidebar-footer">
                <div class="sidebar-user">
                    <div class="sidebar-user-avatar">
                        {{ strtoupper(substr(auth()->user()->name ?? 'S', 0, 1)) }}
                    </div>
                    <div class="sidebar-user-info">
                        <div class="sidebar-user-name">{{ auth()->user()->name ?? 'Seller' }}</div>
                        <div class="sidebar-user-role">Seller</div>
                    </div>
                </div>
                <div class="sidebar-logout">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </aside>
        
        <!-- Main Content -->
        <div class="seller-main">
            <!-- Top Bar -->
            <header class="seller-topbar">
                <div class="d-flex align-items-center gap-3">
                    <button class="mobile-menu-btn" onclick="openMobileSidebar()">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h1 class="topbar-title">@yield('page-title', 'Dashboard')</h1>
                </div>
                <div class="topbar-actions">
                    <a href="{{ route('seller.notifications.index') }}" class="topbar-icon-btn" title="Notifikasi">
                        <i class="fas fa-bell"></i>
                        @if($unreadNotifCount > 0)
                            <span class="topbar-badge">{{ $unreadNotifCount > 9 ? '9+' : $unreadNotifCount }}</span>
                        @endif
                    </a>
                    <a href="{{ route('seller.messages.index') }}" class="topbar-icon-btn" title="Pesan">
                        <i class="fas fa-envelope"></i>
                    </a>
                </div>
            </header>
            
            <!-- Page Content -->
            <div class="seller-content">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                
                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Terjadi Kesalahan!</strong>
                        <ul class="mb-0 mt-2">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                
                @yield('content')
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <script>
        // Sidebar toggle functionality
        const sidebar = document.getElementById('sellerSidebar');
        const overlay = document.getElementById('sidebarOverlay');
        
        // Check saved state
        const sidebarCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
        if (sidebarCollapsed && window.innerWidth >= 992) {
            sidebar.classList.add('collapsed');
        }
        
        function toggleSidebar() {
            if (sidebar) {
                sidebar.classList.toggle('collapsed');
                localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('collapsed'));
            }
        }
        
        function openMobileSidebar() {
            if (sidebar && overlay) {
                sidebar.classList.add('mobile-open');
                overlay.classList.add('active');
                document.body.style.overflow = 'hidden';
            }
        }
        
        function closeMobileSidebar() {
            if (sidebar && overlay) {
                sidebar.classList.remove('mobile-open');
                overlay.classList.remove('active');
                document.body.style.overflow = '';
            }
        }
        
        // Close sidebar on resize to desktop
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 768) {
                closeMobileSidebar();
            }
        });

        // Ensure all topbar buttons are clickable
        document.addEventListener('DOMContentLoaded', function() {
            const topbarBtns = document.querySelectorAll('.topbar-icon-btn, .mobile-menu-btn');
            topbarBtns.forEach(function(btn) {
                btn.style.pointerEvents = 'auto';
                btn.style.cursor = 'pointer';
            });
        });
    </script>
    
    @stack('scripts')
</body>
</html>
