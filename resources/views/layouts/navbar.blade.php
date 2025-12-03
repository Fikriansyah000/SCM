<nav class="navbar navbar-expand-lg navbar-light">
    <div class="container">
        <a class="navbar-brand" href="@auth @if(auth()->user()->role === 'buyer'){{ route('buyer.home') }}@elseif(auth()->user()->role === 'seller'){{ route('seller.dashboard') }}@else{{ route('landing') }}@endif @else{{ route('landing') }}@endauth">
            <img src="{{ asset('images/landing/logo-pestimart.png') }}" alt="PestiMart" class="navbar-logo">
        </a>
        
        <!-- Mobile Menu Toggle Button -->
        <button class="mobile-menu-toggle d-lg-none" type="button" onclick="openOffcanvasMenu()" aria-label="Open menu">
            <i class="fas fa-bars"></i>
        </button>
        
        <!-- Desktop Navigation -->
        <div class="collapse navbar-collapse desktop-nav" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                @guest
                    <li class="nav-item">
                        <a class="nav-link btn-login" href="{{ route('login') }}">
                            <i class="fas fa-sign-in-alt me-1"></i>Login
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn-register" href="{{ route('register.buyer') }}">
                            <i class="fas fa-user-plus me-1"></i>Daftar
                        </a>
                    </li>
                @else
                    @if(auth()->user()->role === 'buyer')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('buyer.home') ? 'active' : '' }}" href="{{ route('buyer.home') }}">
                                <i class="fas fa-home me-1"></i>Home
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link position-relative {{ request()->routeIs('buyer.cart') ? 'active' : '' }}" href="{{ route('buyer.cart') }}">
                                <i class="fas fa-shopping-cart me-1"></i>Keranjang
                                @php
                                    $cartCount = \App\Models\Cart::where('user_id', auth()->id())->count();
                                @endphp
                                @if($cartCount > 0)
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        {{ $cartCount }}
                                    </span>
                                @endif
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('buyer.orders') ? 'active' : '' }}" href="{{ route('buyer.orders') }}">
                                <i class="fas fa-history me-1"></i>Pesanan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('buyer.proposals') || request()->routeIs('buyer.proposals.*') ? 'active' : '' }}" href="{{ route('buyer.proposals') }}">
                                <i class="fas fa-file-alt me-1"></i>Pengajuan
                            </a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('seller.dashboard') ? 'active' : '' }}" href="{{ route('seller.dashboard') }}">
                                <i class="fas fa-chart-line me-1"></i>Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('seller.shop') ? 'active' : '' }}" href="{{ route('seller.shop') }}">
                                <i class="fas fa-store me-1"></i>Toko Saya
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('seller.products.*') ? 'active' : '' }}" href="{{ route('seller.products.index') }}">
                                <i class="fas fa-box me-1"></i>Produk
                            </a>
                        </li>
                    @endif
                    
                    <li class="nav-item">
    <a class="nav-link position-relative" href="{{ route('notifications.index') }}">
        <i class="fas fa-bell me-1"></i>Notifikasi
        @php
            $unreadCount = \App\Models\Notification::where('user_id', auth()->id())
                ->where('is_read', false)
                ->count();
        @endphp
        @if($unreadCount > 0)
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" 
                  style="animation: pulse 1s infinite;">
                {{ $unreadCount > 99 ? '99+' : $unreadCount }}
            </span>
        @endif
    </a>
</li>
                    
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('messages.index') }}">
                            <i class="fas fa-envelope me-1"></i>Pesan
                        </a>
                    </li>
                    
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle me-1"></i>{{ auth()->user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="{{ route('profile.show') }}">
                                <i class="fas fa-id-card me-2"></i>Profil
                            </a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>

<!-- Off-Canvas Mobile Menu Overlay -->
<div class="offcanvas-overlay" id="offcanvasOverlay" onclick="closeOffcanvasMenu()"></div>

<!-- Off-Canvas Mobile Menu -->
<div class="offcanvas-menu" id="offcanvasMenu">
    <div class="offcanvas-header">
        <a href="@auth @if(auth()->user()->role === 'buyer'){{ route('buyer.home') }}@elseif(auth()->user()->role === 'seller'){{ route('seller.dashboard') }}@else{{ route('landing') }}@endif @else{{ route('landing') }}@endauth" class="offcanvas-brand">
            <img src="{{ asset('images/landing/logo-pestimart.png') }}" alt="PestiMart" class="offcanvas-logo">
        </a>
        <button class="offcanvas-close" onclick="closeOffcanvasMenu()" aria-label="Close menu">
            <i class="fas fa-times"></i>
        </button>
    </div>
    
    <div class="offcanvas-body">
        <ul class="offcanvas-nav">
            @guest
                <li class="offcanvas-nav-item">
                    <a class="offcanvas-nav-link" href="{{ route('login') }}">
                        <i class="fas fa-sign-in-alt"></i>Login
                    </a>
                </li>
                <li class="offcanvas-nav-item">
                    <a class="offcanvas-nav-link" href="{{ route('register.buyer') }}">
                        <i class="fas fa-user-plus"></i>Daftar
                    </a>
                </li>
            @else
                @if(auth()->user()->role === 'buyer')
                    <li class="offcanvas-nav-item">
                        <a class="offcanvas-nav-link {{ request()->routeIs('buyer.home') ? 'active' : '' }}" href="{{ route('buyer.home') }}">
                            <i class="fas fa-home"></i>Home
                        </a>
                    </li>
                    <li class="offcanvas-nav-item">
                        <a class="offcanvas-nav-link position-relative {{ request()->routeIs('buyer.cart') ? 'active' : '' }}" href="{{ route('buyer.cart') }}">
                            <i class="fas fa-shopping-cart"></i>Keranjang
                            @php
                                $cartCount = \App\Models\Cart::where('user_id', auth()->id())->count();
                            @endphp
                            @if($cartCount > 0)
                                <span class="badge bg-danger ms-2">{{ $cartCount }}</span>
                            @endif
                        </a>
                    </li>
                    <li class="offcanvas-nav-item">
                        <a class="offcanvas-nav-link {{ request()->routeIs('buyer.orders') ? 'active' : '' }}" href="{{ route('buyer.orders') }}">
                            <i class="fas fa-history"></i>Pesanan
                        </a>
                    </li>
                    <li class="offcanvas-nav-item">
                        <a class="offcanvas-nav-link {{ request()->routeIs('buyer.proposals') || request()->routeIs('buyer.proposals.*') ? 'active' : '' }}" href="{{ route('buyer.proposals') }}">
                            <i class="fas fa-file-alt"></i>Pengajuan
                        </a>
                    </li>
                @else
                    <li class="offcanvas-nav-item">
                        <a class="offcanvas-nav-link {{ request()->routeIs('seller.dashboard') ? 'active' : '' }}" href="{{ route('seller.dashboard') }}">
                            <i class="fas fa-chart-line"></i>Dashboard
                        </a>
                    </li>
                    <li class="offcanvas-nav-item">
                        <a class="offcanvas-nav-link {{ request()->routeIs('seller.shop') ? 'active' : '' }}" href="{{ route('seller.shop') }}">
                            <i class="fas fa-store"></i>Toko Saya
                        </a>
                    </li>
                    <li class="offcanvas-nav-item">
                        <a class="offcanvas-nav-link {{ request()->routeIs('seller.products.*') ? 'active' : '' }}" href="{{ route('seller.products.index') }}">
                            <i class="fas fa-box"></i>Produk
                        </a>
                    </li>
                @endif
                
                <li class="offcanvas-nav-item">
                    <a class="offcanvas-nav-link" href="{{ route('notifications.index') }}">
                        <i class="fas fa-bell"></i>Notifikasi
                        @php
                            $unreadCount = \App\Models\Notification::where('user_id', auth()->id())
                                ->where('is_read', false)
                                ->count();
                        @endphp
                        @if($unreadCount > 0)
                            <span class="badge bg-danger ms-2">{{ $unreadCount > 99 ? '99+' : $unreadCount }}</span>
                        @endif
                    </a>
                </li>
                
                <li class="offcanvas-nav-item">
                    <a class="offcanvas-nav-link" href="{{ route('messages.index') }}">
                        <i class="fas fa-envelope"></i>Pesan
                    </a>
                </li>
                
                <li class="offcanvas-nav-item">
                    <a class="offcanvas-nav-link" href="{{ route('profile.show') }}">
                        <i class="fas fa-id-card"></i>Profil
                    </a>
                </li>
            @endguest
        </ul>
    </div>
    
    @auth
    <div class="offcanvas-footer">
        <div class="d-flex align-items-center gap-2 mb-3">
            <i class="fas fa-user-circle" style="font-size: 1.5rem; color: var(--color-primary);"></i>
            <span class="fw-semibold">{{ auth()->user()->name }}</span>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-outline-danger w-100">
                <i class="fas fa-sign-out-alt me-2"></i>Logout
            </button>
        </form>
    </div>
    @endauth
</div>

<script>
    function openOffcanvasMenu() {
        document.getElementById('offcanvasMenu').classList.add('is-open');
        document.getElementById('offcanvasOverlay').classList.add('is-open');
        document.body.classList.add('offcanvas-open');
    }
    
    function closeOffcanvasMenu() {
        document.getElementById('offcanvasMenu').classList.remove('is-open');
        document.getElementById('offcanvasOverlay').classList.remove('is-open');
        document.body.classList.remove('offcanvas-open');
    }
    
    // Close menu when pressing Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeOffcanvasMenu();
        }
    });
</script>

<style>
    /* Navigation */
    .navbar {
        background: linear-gradient(135deg, #1e3a5f 0%, #2d5a87 50%, #1e3a5f 100%);
        backdrop-filter: blur(12px);
        padding: 15px 5%;
        box-shadow: 0 4px 20px rgba(30, 58, 95, 0.4);
        position: sticky;
        top: 0;
        z-index: 1050;
        height: 76px;
        border-bottom: 2px solid rgba(255, 255, 255, 0.1);
    }

    @media (max-width: 768px) {
        .navbar {
            padding: 10px 4%;
            height: 60px;
        }
    }

    @media (max-width: 480px) {
        .navbar {
            padding: 8px 3%;
            height: 56px;
        }
    }

    .navbar-brand {
        display: flex;
        align-items: center;
        transition: all 0.3s ease;
    }

    .navbar-brand:hover {
        transform: translateY(-2px);
    }

    .navbar-logo {
        height: 50px;
        width: auto;
        object-fit: contain;
        filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2));
    }

    @media (max-width: 768px) {
        .navbar-logo {
            height: 40px;
        }
    }

    @media (max-width: 480px) {
        .navbar-logo {
            height: 36px;
        }
    }

    .navbar-nav {
        gap: 8px;
        align-items: center;
    }

    .nav-link {
        color: white !important;
        font-weight: 600;
        font-size: clamp(13px, 1.5vw, 15px);
        transition: all 0.3s ease;
        padding: 8px 15px !important;
        border-radius: 5px;
        position: relative;
        display: flex;
        align-items: center;
    }

    .nav-link:hover {
        background: rgba(255, 255, 255, 0.2);
        transform: translateY(-2px);
    }

    .nav-link.active {
        background: rgba(255, 255, 255, 0.3);
        font-weight: 700;
    }

    .nav-link.btn-login {
        background: white;
        color: #1e3a5f !important;
        border: 2px solid white;
        padding: 8px 20px !important;
        border-radius: 8px;
        margin-right: 8px;
    }

    .nav-link.btn-login:hover {
        background: #f0f4f8;
        transform: translateY(-2px);
        color: #1e3a5f !important;
        box-shadow: 0 4px 15px rgba(255, 255, 255, 0.3);
    }

    .nav-link.btn-register {
        background: linear-gradient(135deg, #FF8F3A 0%, #f5700a 100%);
        color: white !important;
        border: none;
        padding: 8px 20px !important;
        border-radius: 8px;
        box-shadow: 0 4px 15px rgba(255, 143, 58, 0.3);
    }

    .nav-link.btn-register:hover {
        background: linear-gradient(135deg, #f5700a 0%, #e66000 100%);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(255, 143, 58, 0.4);
    }

    /* Mobile Menu Toggle */
    .mobile-menu-toggle {
        display: none;
        background: rgba(255, 255, 255, 0.2);
        border: 2px solid white;
        color: white;
        width: 44px;
        height: 44px;
        border-radius: var(--radius-md, 8px);
        cursor: pointer;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        transition: all 0.3s ease;
    }

    .mobile-menu-toggle:hover {
        background: rgba(255, 255, 255, 0.3);
    }

    @media (max-width: 991px) {
        .mobile-menu-toggle {
            display: flex;
        }
        
        .desktop-nav {
            display: none !important;
        }
    }

    .dropdown-menu {
        border-radius: 8px;
        border: none;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        animation: slideDown 0.2s ease;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .dropdown-item {
        color: #1e3a5f;
        transition: all 0.2s ease;
    }

    .dropdown-item:hover {
        background: rgba(30, 58, 95, 0.1);
        color: #1e3a5f;
    }

    .dropdown-divider {
        border-color: #e0e0e0;
    }

    .badge {
        font-size: 0.7rem;
        padding: 0.35rem 0.55rem;
        animation: pulse 2s infinite;
    }

     @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.7; }
    }

    /* Off-Canvas Menu Styles */
    .offcanvas-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(4px);
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.3s ease, visibility 0.3s ease;
        z-index: 1040;
    }

    .offcanvas-overlay.is-open {
        opacity: 1;
        visibility: visible;
    }

    .offcanvas-menu {
        position: fixed;
        top: 0;
        left: 0;
        width: min(300px, 85vw);
        height: 100%;
        background: white;
        box-shadow: 4px 0 25px rgba(0, 0, 0, 0.15);
        transform: translateX(-100%);
        transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        z-index: 1050;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
    }

    .offcanvas-menu.is-open {
        transform: translateX(0);
    }

    .offcanvas-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1rem 1.25rem;
        border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        background: linear-gradient(135deg, #1e3a5f 0%, #2d5a87 100%);
        color: white;
    }

    .offcanvas-brand {
        display: flex;
        align-items: center;
        text-decoration: none;
    }

    .offcanvas-logo {
        height: 36px;
        width: auto;
        object-fit: contain;
        filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2));
    }

    .offcanvas-close {
        background: rgba(255, 255, 255, 0.2);
        border: none;
        color: white;
        width: 36px;
        height: 36px;
        border-radius: var(--radius-md, 8px);
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        transition: background 0.2s ease;
    }

    .offcanvas-close:hover {
        background: rgba(255, 255, 255, 0.3);
    }

    .offcanvas-body {
        flex: 1;
        padding: 1rem;
    }

    .offcanvas-nav {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .offcanvas-nav-item {
        margin-bottom: 0.5rem;
    }

    .offcanvas-nav-link {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem 1rem;
        color: var(--color-text-primary, #333);
        text-decoration: none;
        border-radius: var(--radius-md, 8px);
        font-weight: 500;
        transition: background 0.2s ease, color 0.2s ease;
    }

    .offcanvas-nav-link:hover,
    .offcanvas-nav-link.active {
        background: rgba(30, 58, 95, 0.1);
        color: #1e3a5f;
    }

    .offcanvas-nav-link i {
        width: 20px;
        text-align: center;
        color: #1e3a5f;
    }

    .offcanvas-footer {
        padding: 1rem 1.25rem;
        border-top: 1px solid rgba(0, 0, 0, 0.1);
        background: var(--color-neutral-light, #f8f9fa);
    }

    body.offcanvas-open {
        overflow: hidden;
    }

    @media (min-width: 992px) {
        .offcanvas-menu,
        .offcanvas-overlay {
            display: none !important;
        }
    }
</style>
