<footer>
    <div class="container">
        <div class="row mb-4">
            <div class="col-md-3 mb-4 mb-md-0">
                <h5 class="mb-3">
                    <i class="fas fa-shopping-cart me-2"></i>PestiMart
                </h5>
                <p class="text-muted small">Platform e-commerce khusus mahasiswa untuk jual beli kebutuhan kampus dengan aman dan terpercaya.</p>
            </div>
            <div class="col-md-3 mb-4 mb-md-0">
                <h5 class="mb-3">Menu</h5>
                <ul class="list-unstyled text-muted small">
                    <li><a href="{{ route('landing') }}" class="text-muted text-decoration-none">Beranda</a></li>
                    @auth
                        @if(auth()->user()->role === 'buyer')
                            <li><a href="{{ route('buyer.home') }}" class="text-muted text-decoration-none">Belanja</a></li>
                        @else
                            <li><a href="{{ route('seller.dashboard') }}" class="text-muted text-decoration-none">Dashboard</a></li>
                        @endif
                    @endauth
                </ul>
            </div>
            <div class="col-md-3 mb-4 mb-md-0">
                <h5 class="mb-3">Bantuan</h5>
                <ul class="list-unstyled text-muted small">
                    <li><a href="#" class="text-muted text-decoration-none">Hubungi Kami</a></li>
                    <li><a href="#" class="text-muted text-decoration-none">FAQ</a></li>
                    <li><a href="#" class="text-muted text-decoration-none">Kebijakan</a></li>
                </ul>
            </div>
            <div class="col-md-3">
                <h5 class="mb-3">Ikuti Kami</h5>
                <div class="d-flex gap-2">
                    <a href="#" class="btn btn-sm btn-outline-light rounded-circle">
                        <i class="fab fa-facebook"></i>
                    </a>
                    <a href="#" class="btn btn-sm btn-outline-light rounded-circle">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="btn btn-sm btn-outline-light rounded-circle">
                        <i class="fab fa-instagram"></i>
                    </a>
                </div>
            </div>
        </div>
        <hr class="bg-secondary">
        <div class="row">
            <div class="col-md-6">
                <p class="text-muted small mb-0">&copy; {{ date('Y') }} PestiMart. Semua hak dilindungi.</p>
            </div>
            <div class="col-md-6 text-md-end">
                <p class="text-muted small mb-0">
                    Made with <i class="fas fa-heart text-danger"></i> for Students
                </p>
            </div>
        </div>
    </div>
</footer>

<style>
    footer {
        background: #2d3e50;
        color: white;
        padding: 30px 5%;
        margin-top: 3rem;
    }

    footer .container {
        max-width: 100%;
        padding: 0;
    }

    footer h5 {
        color: white;
        font-weight: 600;
        font-size: clamp(14px, 1.8vw, 16px);
    }

    footer p {
        font-size: clamp(13px, 1.5vw, 15px);
        opacity: 0.9;
        margin-bottom: 8px;
        line-height: 1.6;
    }

    footer a {
        color: #a6bdd5;
        text-decoration: none;
        transition: all 0.3s ease;
        display: inline-block;
    }

    footer a:hover {
        color: #5273a1;
        transform: translateX(2px);
    }

    footer ul li {
        margin-bottom: 8px;
    }

    footer ul li a {
        font-size: clamp(12px, 1.4vw, 14px);
        opacity: 0.85;
    }

    footer hr {
        background-color: rgba(255, 255, 255, 0.1) !important;
        margin: 2rem 0;
    }

    footer .btn-outline-light {
        color: #a6bdd5;
        border-color: #a6bdd5;
        transition: all 0.3s ease;
    }

    footer .btn-outline-light:hover {
        color: white;
        background-color: #5273a1;
        border-color: #5273a1;
        transform: translateY(-2px);
    }

    footer .text-muted {
        color: #a6bdd5 !important;
        opacity: 0.85;
    }

    @media (max-width: 768px) {
        footer {
            padding: 20px 5%;
            text-align: center;
        }

        footer .col-md-6 {
            text-align: center !important;
            margin-bottom: 1rem;
        }

        footer a {
            display: inline;
        }

        footer .d-flex {
            justify-content: center !important;
        }
    }
</style>
