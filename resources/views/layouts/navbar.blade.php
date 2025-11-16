<nav class="navbar navbar-expand-lg navbar-light">
    <div class="container">
        <a class="navbar-brand" href="{{ route('landing') }}">
            <i class="fas fa-shopping-cart me-2"></i>PestiMart
        </a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
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

<style>
    /* Navigation */
    .navbar {
        background: rgba(166, 189, 213, 0.95);
        backdrop-filter: blur(10px);
        padding: 15px 5%;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
    }

    .navbar-brand {
        color: #0a4c8c !important;
        font-size: clamp(20px, 3vw, 26px);
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 12px;
        transition: all 0.3s ease;
    }

    .navbar-brand:hover {
        transform: translateY(-2px);
    }

    .navbar-brand i {
        font-size: 1.3em;
    }

    .navbar-nav {
        gap: 8px;
    }

    .nav-link {
        color: #0a4c8c !important;
        font-weight: 600;
        font-size: clamp(13px, 1.5vw, 15px);
        transition: all 0.3s ease;
        padding: 8px 15px !important;
        border-radius: 5px;
        position: relative;
    }

    .nav-link:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: translateY(-2px);
    }

    .nav-link.active {
        background: rgba(255, 255, 255, 0.4);
        color: #0a4c8c !important;
        font-weight: 700;
    }

    .nav-link.btn-login {
        background: white;
        color: #0a4c8c !important;
        border: none;
        padding: 8px 20px !important;
    }

    .nav-link.btn-login:hover {
        background: #f0f4f8;
        transform: translateY(-2px);
    }

    .nav-link.btn-register {
        background: #0a4c8c;
        color: white !important;
        border: none;
        padding: 8px 20px !important;
    }

    .nav-link.btn-register:hover {
        background: #083b6d;
        transform: translateY(-2px);
    }

    .navbar-toggler {
        border-color: #0a4c8c;
        padding: 0.25rem 0.5rem;
    }

    .navbar-toggler:focus {
        box-shadow: 0 0 0 0.25rem rgba(10, 76, 140, 0.25);
    }

    .navbar-toggler-icon {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='%230a4c8c' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
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
        color: #0a4c8c;
        transition: all 0.2s ease;
    }

    .dropdown-item:hover {
        background: rgba(10, 76, 140, 0.1);
        color: #083b6d;
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

    /* Mobile Responsive */
    @media (max-width: 991px) {
        .navbar {
            padding: 12px 5%;
        }

        .navbar-nav {
            margin-top: 15px;
            gap: 0;
        }

        .nav-link {
            padding: 10px 15px !important;
            margin-bottom: 5px;
        }

        .nav-link.btn-login,
        .nav-link.btn-register {
            margin-top: 10px;
            text-align: center;
            padding: 10px 15px !important;
        }

        .navbar-collapse {
            background: rgba(255, 255, 255, 0.95);
            padding: 15px;
            border-radius: 8px;
            margin-top: 10px;
        }
    }

    /* Dark Mode Support */
    @media (prefers-color-scheme: dark) {
        .navbar {
            background: rgba(10, 76, 140, 0.9);
        }

        .navbar-collapse {
            background: rgba(10, 76, 140, 0.95);
        }

        .nav-link {
            color: white !important;
        }

        .nav-link.btn-login {
            background: #0a4c8c;
            color: white !important;
        }

        .nav-link.btn-login:hover {
            background: #083b6d;
        }
    }
</style>
