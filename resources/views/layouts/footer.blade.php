<footer class="site-footer">
    <div class="container">
        <div class="row mb-4">
            <div class="col-md-3 mb-4 mb-md-0">
                <div class="footer-brand mb-3">
                    <img src="{{ asset('images/landing/logo-pestimart.png') }}" alt="PestiMart" class="footer-logo">
                </div>
                <p class="footer-text small">Platform e-commerce khusus mahasiswa untuk jual beli kebutuhan kampus dengan aman dan terpercaya.</p>
            </div>
            <div class="col-md-3 mb-4 mb-md-0">
                <h5 class="footer-heading mb-3">Menu</h5>
                <ul class="footer-links list-unstyled small">
                    <li><a href="{{ route('landing') }}">Beranda</a></li>
                    @auth
                        @if(auth()->user()->role === 'buyer')
                            <li><a href="{{ route('buyer.home') }}">Belanja</a></li>
                        @else
                            <li><a href="{{ route('seller.dashboard') }}">Dashboard</a></li>
                        @endif
                    @endauth
                </ul>
            </div>
            <div class="col-md-3 mb-4 mb-md-0">
                <h5 class="footer-heading mb-3">Bantuan</h5>
                <ul class="footer-links list-unstyled small">
                    <li><a href="#">Hubungi Kami</a></li>
                    <li><a href="#">FAQ</a></li>
                    <li><a href="#">Kebijakan</a></li>
                </ul>
            </div>
            <div class="col-md-3">
                <h5 class="footer-heading mb-3">Ikuti Kami</h5>
                <div class="footer-social d-flex gap-2">
                    <a href="#" class="btn btn-sm rounded-circle" aria-label="Facebook">
                        <i class="fab fa-facebook"></i>
                    </a>
                    <a href="#" class="btn btn-sm rounded-circle" aria-label="Twitter">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="btn btn-sm rounded-circle" aria-label="Instagram">
                        <i class="fab fa-instagram"></i>
                    </a>
                </div>
            </div>
        </div>
        <hr class="footer-divider">
        <div class="row footer-bottom">
            <div class="col-md-6">
                <p class="footer-copyright small mb-0">&copy; {{ date('Y') }} PestiMart. Semua hak dilindungi.</p>
            </div>
            <div class="col-md-6 text-md-end">
                <p class="footer-credit small mb-0">
                    Made with <i class="fas fa-heart"></i> 5A PSTI
                </p>
            </div>
        </div>
    </div>
</footer>

<style>
    .site-footer {
        background: linear-gradient(135deg, var(--color-neutral-dark, #1A1F36), #2a3040);
        color: white;
        padding: 40px 5% 30px;
        margin-top: 3rem;
    }

    .site-footer .container {
        max-width: 100%;
        padding: 0;
    }

    .footer-brand {
        display: flex;
        align-items: center;
    }

    .footer-logo {
        height: 40px;
        width: auto;
        object-fit: contain;
    }

    .footer-heading {
        color: white;
        font-family: var(--font-display, 'Poppins'), sans-serif;
        font-weight: 600;
        font-size: clamp(14px, 1.8vw, 16px);
    }

    .footer-text {
        color: rgba(255, 255, 255, 0.75);
        font-size: clamp(13px, 1.5vw, 15px);
        line-height: 1.7;
        margin-bottom: 8px;
    }

    .footer-links li {
        margin-bottom: 10px;
    }

    .footer-links a {
        color: rgba(255, 255, 255, 0.7);
        text-decoration: none;
        font-size: clamp(13px, 1.4vw, 14px);
        transition: all 0.3s ease;
        display: inline-block;
    }

    .footer-links a:hover {
        color: #7db3d8;
        transform: translateX(4px);
    }

    .footer-social .btn {
        width: 38px;
        height: 38px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: rgba(255, 255, 255, 0.8);
        border: 2px solid rgba(255, 255, 255, 0.3);
        background: transparent;
        transition: all 0.3s ease;
    }

    .footer-social .btn:hover {
        color: white;
        background: #2d5a87;
        border-color: #2d5a87;
        transform: translateY(-3px);
    }

    .footer-divider {
        border: none;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        margin: 2rem 0;
    }

    .footer-copyright,
    .footer-credit {
        color: rgba(255, 255, 255, 0.6);
    }

    .footer-credit .fa-heart {
        color: var(--color-accent, #FF8F3A);
        animation: heartbeat 1.5s ease-in-out infinite;
    }

    @keyframes heartbeat {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.15); }
    }

    @media (max-width: 768px) {
        .site-footer {
            padding: 30px 5% 20px;
            text-align: center;
        }

        .footer-bottom .col-md-6 {
            text-align: center !important;
            margin-bottom: 0.5rem;
        }

        .footer-links a:hover {
            transform: none;
        }

        .footer-social {
            justify-content: center !important;
        }
    }
</style>
