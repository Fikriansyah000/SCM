@extends('layouts.app')

@section('title', 'PestiMart - E-Commerce Mahasiswa')

@section('content')
 <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    /* Landing page scroll container */
    .landing-scroll-container {
      height: calc(100vh - 76px);
      overflow-y: auto;
      scroll-behavior: smooth;
      scroll-snap-type: y mandatory;
      -webkit-overflow-scrolling: touch;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(to bottom, #e8f1f8 0%, #ffffff 100%);
      color: #333;
    }

    /* Section-Based Scroll System */
    .section-fullscreen {
      min-height: calc(100vh - 76px);
      scroll-snap-align: start;
      scroll-snap-stop: always;
      display: flex;
      flex-direction: column;
      justify-content: center;
      position: relative;
      overflow: hidden;
    }

    .section-fullscreen.section-auto-height {
      min-height: auto;
      padding: 80px 0;
    }

    /* Section scroll indicator */
    .scroll-indicator {
      position: fixed;
      right: 15px;
      top: 50%;
      transform: translateY(-50%);
      display: flex;
      flex-direction: column;
      gap: 12px;
      z-index: 100;
    }

    .scroll-dot {
      width: 12px;
      height: 12px;
      border-radius: 50%;
      background: rgba(58, 123, 255, 0.3);
      border: 2px solid var(--primary, #3A7BFF);
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .scroll-dot.active {
      background: var(--primary, #3A7BFF);
      transform: scale(1.3);
    }

    .scroll-dot:hover {
      background: var(--primary, #3A7BFF);
      transform: scale(1.2);
    }

    /* Section entrance animations */
    .section-fullscreen .section-content {
      opacity: 0;
      transform: translateY(60px);
      transition: opacity 1s cubic-bezier(0.16, 1, 0.3, 1),
                  transform 1s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .section-fullscreen.in-view .section-content {
      opacity: 1;
      transform: translateY(0);
    }

    /* Staggered children animation */
    .section-fullscreen.in-view .section-content > *:nth-child(1) { transition-delay: 0.1s; }
    .section-fullscreen.in-view .section-content > *:nth-child(2) { transition-delay: 0.2s; }
    .section-fullscreen.in-view .section-content > *:nth-child(3) { transition-delay: 0.3s; }
    .section-fullscreen.in-view .section-content > *:nth-child(4) { transition-delay: 0.4s; }

    /* Mobile Section-Based Scroll */
    @media (max-width: 768px) {
      .landing-scroll-container {
        height: calc(100vh - 60px);
        scroll-snap-type: y mandatory;
      }

      .scroll-indicator {
        right: 8px;
        gap: 10px;
      }

      .scroll-dot {
        width: 10px;
        height: 10px;
        border-width: 1.5px;
      }
      
      .section-fullscreen {
        min-height: calc(100vh - 60px);
        scroll-snap-align: start;
        scroll-snap-stop: always;
        padding: 30px 0;
      }
    }

    @media (max-width: 480px) {
      .landing-scroll-container {
        height: calc(100vh - 56px);
      }

      .section-fullscreen {
        min-height: calc(100vh - 56px);
        padding: 20px 0;
      }

      .scroll-dot {
        width: 8px;
        height: 8px;
      }

      .scroll-indicator {
        right: 6px;
        gap: 8px;
      }
    }

    /* Hero Section */
    .hero-section {
      padding: 60px 5% 40px;
      display: flex;
      align-items: center;
      gap: 40px;
      max-width: 1200px;
      margin: 0 auto;
      flex-wrap: wrap;
    }

    .hero-content {
      flex: 1;
      min-width: 300px;
    }

    .hero-content h2 {
      font-family: var(--font-display, 'Poppins'), sans-serif;
      color: var(--neutral-dark, #1A1F36);
      font-size: clamp(32px, 5vw, 48px);
      font-weight: 700;
      line-height: 1.3;
      margin-bottom: 20px;
    }

    .hero-content p {
      color: #555;
      font-size: clamp(15px, 2vw, 18px);
      line-height: 1.7;
      margin-bottom: 30px;
    }
    a{
        text-decoration: none;
    }
    .hero-btn {
      padding: 12px 30px;
      border-radius: 8px;
      border: none;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      font-size: clamp(14px, 1.8vw, 16px);
      background: linear-gradient(135deg, var(--primary, #3A7BFF), var(--secondary, #6ECBF9));
      color: white;
      box-shadow: 0 4px 12px rgba(58, 123, 255, 0.3);
    }

    @media (hover: hover) {
        .hero-btn:hover {
          filter: brightness(1.05);
          transform: translateY(-3px);
          box-shadow: 0 6px 18px rgba(58, 123, 255, 0.4);
        }
    }

    .hero-image {
      flex: 1;
      min-width: 300px;
      text-align: center;
      position: relative;
    }

    .hero-image img {
      width: 100%;
      max-width: 300px;
      border-radius: 20px;
      box-shadow: 0 20px 60px rgba(10, 76, 140, 0.2);
      animation: floatMain 6s ease-in-out infinite;
    }

    /* Mobile Hero adjustments */
    @media (max-width: 768px) {
      .hero-section {
        padding: 30px 5% 20px;
        gap: 20px;
        flex-direction: column;
        text-align: center;
      }

      .hero-content {
        min-width: 100%;
      }

      .hero-content h2 {
        font-size: clamp(24px, 6vw, 32px);
        margin-bottom: 15px;
      }

      .hero-content p {
        font-size: clamp(14px, 3.5vw, 16px);
        margin-bottom: 20px;
        line-height: 1.6;
      }

      .hero-btn {
        padding: 10px 24px;
        font-size: 14px;
      }

      .hero-image {
        min-width: 100%;
        order: -1;
      }

      .hero-image img {
        max-width: 200px;
      }

      .float-icon {
        font-size: 28px;
      }
    }

    @media (max-width: 480px) {
      .hero-section {
        padding: 20px 4% 15px;
        gap: 15px;
      }

      .hero-content h2 {
        font-size: 22px;
        margin-bottom: 10px;
      }

      .hero-content p {
        font-size: 13px;
        margin-bottom: 15px;
      }

      .hero-btn {
        padding: 10px 20px;
        font-size: 13px;
      }

      .hero-image img {
        max-width: 160px;
      }

      .float-icon {
        font-size: 22px;
      }
    }

    /* ====== ABOUT SECTION MOBILE ====== */
    @media (max-width: 768px) {
      .about-section {
        padding: 30px 4%;
        margin: 0;
      }

      .about-container {
        flex-direction: column;
        gap: 20px;
        text-align: center;
      }

      .about-text h3 {
        font-size: 26px;
        margin-bottom: 12px;
      }

      .about-text p {
        font-size: 14px;
        line-height: 1.6;
        text-align: center;
      }

      .about-image img {
        max-width: 200px;
        order: -1;
      }
    }

    @media (max-width: 480px) {
      .about-section {
        padding: 20px 3%;
      }

      .about-text h3 {
        font-size: 22px;
      }

      .about-text p {
        font-size: 13px;
      }

      .about-image img {
        max-width: 150px;
      }
    }

    /* ====== FEATURES SECTION MOBILE ====== */
    @media (max-width: 768px) {
      .features-section {
        padding: 30px 4%;
      }

      .features-title h3 {
        font-size: 26px;
        margin-bottom: 8px;
      }

      .features-title p {
        font-size: 14px;
        margin-bottom: 20px;
      }

      .features-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
      }

      .feature-card {
        padding: 15px;
      }

      .feature-icon {
        font-size: 28px;
        margin-bottom: 8px;
      }

      .feature-card h4 {
        font-size: 14px;
        margin-bottom: 5px;
      }

      .feature-card p {
        font-size: 12px;
        line-height: 1.4;
      }
    }

    @media (max-width: 480px) {
      .features-section {
        padding: 20px 3%;
      }

      .features-title h3 {
        font-size: 22px;
      }

      .features-title p {
        font-size: 13px;
      }

      .features-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 10px;
      }

      .feature-card {
        padding: 12px;
      }

      .feature-icon {
        font-size: 24px;
      }

      .feature-card h4 {
        font-size: 13px;
      }

      .feature-card p {
        font-size: 11px;
      }
    }

    /* ====== CTA SECTION MOBILE ====== */
    @media (max-width: 768px) {
      .cta-section {
        padding: 30px 4%;
      }

      .cta-section h3 {
        font-size: 24px;
        margin-bottom: 10px;
      }

      .cta-section p {
        font-size: 14px;
        margin-bottom: 15px;
      }

      .cta-btn {
        padding: 12px 30px;
        font-size: 14px;
      }
    }

    @media (max-width: 480px) {
      .cta-section {
        padding: 25px 3%;
      }

      .cta-section h3 {
        font-size: 20px;
      }

      .cta-section p {
        font-size: 13px;
      }

      .cta-btn {
        padding: 10px 25px;
        font-size: 13px;
      }
    }

    /* ====== PRODUCTS CAROUSEL MOBILE ====== */
    @media (max-width: 768px) {
      #section-products .section-content {
        padding: 30px 4% !important;
      }

      #section-products .features-title h3 {
        font-size: 26px;
      }

      #section-products .features-title p {
        font-size: 14px;
      }

      .product-card {
        min-width: 180px !important;
        max-width: 180px !important;
      }

      .product-card img {
        height: 120px !important;
      }

      .product-card h4 {
        font-size: 13px !important;
      }

      .product-card .price {
        font-size: 14px !important;
      }

      #productCarousel button {
        width: 32px !important;
        height: 32px !important;
        font-size: 16px !important;
      }
    }

    @media (max-width: 480px) {
      #section-products .section-content {
        padding: 20px 3% !important;
      }

      #section-products .features-title h3 {
        font-size: 22px;
      }

      #section-products .features-title p {
        font-size: 13px;
      }

      .product-card {
        min-width: 150px !important;
        max-width: 150px !important;
      }

      .product-card img {
        height: 100px !important;
      }

      .product-card h4 {
        font-size: 12px !important;
      }

      .product-card .price {
        font-size: 13px !important;
      }

      #productCarousel button {
        width: 28px !important;
        height: 28px !important;
        font-size: 14px !important;
      }
    }

    /* Floating decorative elements */
    .floating-elements {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      pointer-events: none;
    }

    .float-icon {
      position: absolute;
      font-size: 40px;
      animation: float 3s ease-in-out infinite;
    }

    .float-icon:nth-child(1) {
      top: 10%;
      left: 5%;
      animation-delay: 0s;
    }

    .float-icon:nth-child(2) {
      top: 15%;
      right: 8%;
      animation-delay: 1s;
    }

    .float-icon:nth-child(3) {
      bottom: 20%;
      left: 10%;
      animation-delay: 2s;
    }

    .float-icon:nth-child(4) {
      bottom: 15%;
      right: 5%;
      animation-delay: 1.5s;
    }

    /* Floating animations */
    @keyframes floatMain {
      0%, 100% { 
        transform: translateY(0px) scale(1);
      }
      50% { 
        transform: translateY(-20px) scale(1.02);
      }
    }

    @keyframes float {
      0%, 100% { 
        transform: translateY(0px) rotate(0deg);
        opacity: 0.7;
      }
      50% { 
        transform: translateY(-25px) rotate(10deg);
        opacity: 1;
      }
    }

    /* About Section */
    .about-section {
      background: white;
      padding: 60px 5%;
      margin: 40px 0;
    }

    .about-container {
      max-width: 1200px;
      margin: 0 auto;
      display: flex;
      gap: 50px;
      align-items: center;
      flex-wrap: wrap;
    }

    .about-text {
      flex: 1;
      min-width: 280px;
    }

    .about-text h3 {
      font-family: var(--font-display, 'Poppins'), sans-serif;
      color: var(--primary, #3A7BFF);
      font-size: clamp(24px, 3.5vw, 36px);
      font-weight: 700;
      margin-bottom: 20px;
    }

    .about-text p {
      color: #555;
      font-size: clamp(14px, 1.8vw, 16px);
      line-height: 1.8;
      margin-bottom: 18px;
      text-align: justify;
      word-wrap: break-word;
      overflow-wrap: break-word;
    }

    .about-image {
      flex: 1;
      min-width: 280px;
      position: relative;
      margin-left: 0;
    }

    @media (min-width: 992px) {
      .about-image {
        margin-left: 50px;
      }
    }

    .about-image img {
      width: 100%;
      max-width: 350px;
      border-radius: 5px;
      box-shadow: 0 15px 50px rgba(10, 76, 140, 0.15);
      animation: floatAbout  ease-in-out infinite;
    }

    @keyframes floatAbout {
      0%, 100% { 
        transform: translateY(0px);
      }
      50% { 
        transform: translateY(-15px);
      }
    }

    /* Features Section */
    .features-section {
      padding: 60px 5%;
      background: linear-gradient(to bottom, #f8fbfd 0%, #e8f1f8 100%);
    }

    .features-title {
      text-align: center;
      margin-bottom: 50px;
    }

    .features-title h3 {
      font-family: var(--font-display, 'Poppins'), sans-serif;
      color: var(--primary, #3A7BFF);
      font-size: clamp(26px, 4vw, 38px);
      font-weight: 700;
      margin-bottom: 10px;
    }

    .features-title p {
      color: #666;
      font-size: clamp(14px, 1.8vw, 17px);
    }

    .features-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 30px;
      max-width: 1200px;
      margin: 0 auto;
    }

    .feature-card {
      background: white;
      padding: 30px 25px;
      border-radius: 12px;
      text-align: center;
      transition: all 0.3s ease;
      box-shadow: 0 3px 15px rgba(0, 0, 0, 0.08);
      border: 2px solid transparent;
    }

    .feature-card:hover {
      transform: translateY(-8px);
      box-shadow: 0 8px 25px rgba(10, 76, 140, 0.15);
      border-color: #a6bdd5;
    }

    .feature-icon {
      width: 70px;
      height: 70px;
      background: linear-gradient(135deg, var(--primary, #3A7BFF) 0%, var(--secondary, #6ECBF9) 100%);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 18px;
      font-size: 35px;
    }

    .feature-card h4 {
      color: var(--primary, #3A7BFF);
      font-size: clamp(17px, 2vw, 20px);
      font-weight: 600;
      margin-bottom: 12px;
    }

    .feature-card p {
      color: #666;
      font-size: clamp(13px, 1.5vw, 15px);
      line-height: 1.6;
    }

    /* Product Card Styles */
    .product-showcase-card {
      flex: 0 0 calc(25% - 1.125rem);
      background: white;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 3px 15px rgba(0, 0, 0, 0.1);
      transition: all 0.3s ease;
      cursor: pointer;
      min-width: 200px;
    }

    .product-showcase-card:hover {
      transform: translateY(-8px);
      box-shadow: 0 8px 25px rgba(10, 76, 140, 0.15);
    }

    .product-image-showcase {
      width: 100%;
      height: 180px;
      background: #f5f5f5;
      display: flex;
      align-items: center;
      justify-content: center;
      overflow: hidden;
      position: relative;
    }

    .product-image-showcase img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.3s ease;
    }

    .product-showcase-card:hover .product-image-showcase img {
      transform: scale(1.05);
    }

    .product-info-showcase {
      padding: 1rem;
    }

    .product-name-showcase {
      font-weight: 600;
      color: #333;
      margin-bottom: 0.5rem;
      font-size: 0.95rem;
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
    }

    .product-shop-showcase {
      color: #999;
      font-size: 0.85rem;
      margin-bottom: 0.75rem;
      display: flex;
      align-items: center;
      gap: 0.3rem;
    }

    .product-price-showcase {
      font-weight: 700;
      color: var(--primary, #3A7BFF);
      font-size: 1rem;
      margin-bottom: 0.5rem;
    }

    .product-rating-showcase {
      display: flex;
      align-items: center;
      gap: 0.3rem;
      font-size: 0.8rem;
      color: #999;
    }

    .product-rating-showcase i {
      color: #ffc107;
      font-size: 0.7rem;
    }

    @media (max-width: 1024px) {
      .product-showcase-card {
        flex: 0 0 calc(33.333% - 1rem);
      }
    }

    @media (max-width: 768px) {
      .product-showcase-card {
        flex: 0 0 calc(50% - 0.75rem);
      }
    }

    @media (max-width: 480px) {
      .product-showcase-card {
        flex: 0 0 calc(100% - 0.5rem);
      }
    }

    /* CTA Section */
    .cta-section {
      background: linear-gradient(135deg, var(--primary, #3A7BFF) 0%, var(--secondary, #6ECBF9) 100%);
      padding: 60px 5%;
      text-align: center;
      color: white;
    }

    .cta-section h3 {
      font-family: var(--font-display, 'Poppins'), sans-serif;
      font-size: clamp(28px, 4.5vw, 42px);
      font-weight: 700;
      margin-bottom: 15px;
    }

    .cta-section p {
      font-size: clamp(15px, 2vw, 18px);
      margin-bottom: 35px;
      opacity: 0.95;
    }

    .cta-btn {
      padding: 14px 35px;
      border-radius: 8px;
      border: none;
      font-weight: 700;
      cursor: pointer;
      transition: all 0.3s ease;
      font-size: clamp(15px, 1.8vw, 17px);
      background: white;
      color: var(--primary, #3A7BFF);
      box-shadow: 0 4px 15px rgba(255, 255, 255, 0.3);
    }

    @media (hover: hover) {
        .cta-btn:hover {
          transform: translateY(-3px);
          box-shadow: 0 6px 20px rgba(255, 255, 255, 0.4);
        }
    }

   
    /* Mobile Menu */
    .mobile-menu-btn {
      display: none;
      background: none;
      border: none;
      font-size: 26px;
      color: #0a4c8c;
      cursor: pointer;
    }

    @media (max-width: 768px) {
      .nav-buttons {
        display: none;
      }

      .mobile-menu-btn {
        display: block;
      }

      .hero-section,
      .about-container {
        text-align: center;
      }

      .about-text p {
        text-align: center;
      }
    }

    /* Scroll Reveal Animations */
    .js-reveal {
      opacity: 0;
      transform: translateY(40px);
      transition: opacity 0.8s cubic-bezier(0.16, 1, 0.3, 1), 
                  transform 0.8s cubic-bezier(0.16, 1, 0.3, 1);
    }
    
    .js-reveal.is-visible {
      opacity: 1;
      transform: translateY(0);
    }

    .js-reveal-left {
      opacity: 0;
      transform: translateX(-50px);
      transition: opacity 0.8s ease, transform 0.8s ease;
    }

    .js-reveal-right {
      opacity: 0;
      transform: translateX(50px);
      transition: opacity 0.8s ease, transform 0.8s ease;
    }

    .js-reveal-left.is-visible,
    .js-reveal-right.is-visible {
      opacity: 1;
      transform: translateX(0);
    }

    /* Feature cards staggered reveal */
    .features-grid .feature-card {
      opacity: 0;
      transform: translateY(30px);
      transition: opacity 0.6s ease, transform 0.6s ease;
    }

    .features-grid.is-visible .feature-card:nth-child(1) { transition-delay: 0.1s; }
    .features-grid.is-visible .feature-card:nth-child(2) { transition-delay: 0.2s; }
    .features-grid.is-visible .feature-card:nth-child(3) { transition-delay: 0.3s; }
    .features-grid.is-visible .feature-card:nth-child(4) { transition-delay: 0.4s; }
    .features-grid.is-visible .feature-card:nth-child(5) { transition-delay: 0.5s; }
    .features-grid.is-visible .feature-card:nth-child(6) { transition-delay: 0.6s; }

    .features-grid.is-visible .feature-card {
      opacity: 1;
      transform: translateY(0);
    }

    /* Parallax floating icons */
    .js-parallax {
      transition: transform 0.15s ease-out;
    }
  </style>
</head>
<body>

  <!-- Scroll Indicator Dots -->
  <nav class="scroll-indicator" id="scrollIndicator">
    <div class="scroll-dot active" data-section="0" title="Hero"></div>
    <div class="scroll-dot" data-section="1" title="Produk"></div>
    <div class="scroll-dot" data-section="2" title="Tentang"></div>
    <div class="scroll-dot" data-section="3" title="Fitur"></div>
    @guest
    <div class="scroll-dot" data-section="4" title="Bergabung"></div>
    @endguest
  </nav>

  <!-- Landing Scroll Container -->
  <div class="landing-scroll-container" id="landingScrollContainer">

  <!-- Hero Section -->
  <section class="section-fullscreen" id="section-hero" style="background: linear-gradient(135deg, #e8f1f8 0%, #ffffff 50%, #f0f7ff 100%);">
    <div class="section-content">
      <div class="hero-section">
        @guest
        <div class="hero-content js-reveal-left">
          <h2>Platform Jual Beli Khusus Mahasiswa</h2>
          <p>PestiMart hadir sebagai solusi praktis untuk jual beli kebutuhan kampus. Dari buku, alat tulis, hingga perlengkapan kos—semuanya ada dalam satu platform yang mudah dan aman.</p>
          <a href="{{ route('register.buyer') }}" class="hero-btn btn-outline-primary btn-lg">
            Daftar Sekarang
          </a>
        </div>
        @else
        <div class="hero-content js-reveal-left">
          <h2>Selamat Datang di PestiMart</h2>
          <p>Platform jual beli khusus mahasiswa. Temukan kebutuhan kampus Anda dengan mudah dan aman.</p>
          @if(auth()->user()->role === 'buyer')
          <a href="{{ route('buyer.home') }}" class="hero-btn btn-outline-primary btn-lg">
            Jelajahi Produk
          </a>
          @else
          <a href="{{ route('seller.dashboard') }}" class="hero-btn btn-outline-primary btn-lg">
            Ke Dashboard
          </a>
          @endif
        </div>
        @endguest
        <div class="hero-image js-reveal-right">
          <div class="floating-elements">
            <div class="float-icon js-parallax" data-parallax-speed="0.3">📦</div>
            <div class="float-icon js-parallax" data-parallax-speed="0.5">🛒</div>
            <div class="float-icon js-parallax" data-parallax-speed="0.4">💳</div>
            <div class="float-icon js-parallax" data-parallax-speed="0.6">⭐</div>
          </div>
          <img src="https://i.postimg.cc/yx8K3Nbg/ecommerce-isometric.jpg" alt="E-commerce Illustration" onerror="this.src='logo.png'" class="js-parallax" data-parallax-speed="0.2">
        </div>
      </div>
    </div>
  </section>

  <!-- Products Showcase Section -->
  <section class="section-fullscreen" id="section-products" style="background: white;">
    <div class="section-content" style="padding: 60px 5%;">
      <div class="features-title">
        <h3>Produk Unggulan</h3>
        <p>Jelajahi koleksi produk terpopuler dari seller terpercaya</p>
      </div>
      <div style="max-width: 1200px; margin: 0 auto;">
        <div style="position: relative; overflow: hidden;">
          <div id="productCarousel" style="display: flex; gap: 1.5rem; overflow-x: auto; scroll-behavior: smooth; padding: 1rem 0; -webkit-overflow-scrolling: touch;">
            <!-- Products will be populated here -->
          </div>
          <!-- Navigation arrows -->
          <button onclick="scrollCarousel(-1)" style="position: absolute; left: 0; top: 50%; transform: translateY(-50%); background: white; border: 2px solid var(--primary, #3A7BFF); color: var(--primary, #3A7BFF); width: 40px; height: 40px; border-radius: 50%; font-size: 20px; cursor: pointer; z-index: 10; transition: all 0.3s ease;" onmouseover="this.style.background='var(--primary, #3A7BFF)'; this.style.color='white'" onmouseout="this.style.background='white'; this.style.color='var(--primary, #3A7BFF)'">
            ❮
          </button>
          <button onclick="scrollCarousel(1)" style="position: absolute; right: 0; top: 50%; transform: translateY(-50%); background: white; border: 2px solid var(--primary, #3A7BFF); color: var(--primary, #3A7BFF); width: 40px; height: 40px; border-radius: 50%; font-size: 20px; cursor: pointer; z-index: 10; transition: all 0.3s ease;" onmouseover="this.style.background='var(--primary, #3A7BFF)'; this.style.color='white'" onmouseout="this.style.background='white'; this.style.color='var(--primary, #3A7BFF)'">
            ❯
          </button>
        </div>
      </div>
    </div>
  </section>

  <!-- About Section -->
  <section class="section-fullscreen" id="section-about" style="background: linear-gradient(135deg, #f0f7ff 0%, #ffffff 100%);">
    <div class="section-content">
      <div class="about-section">
        <div class="about-container">
          <div class="about-text js-reveal-left">
            <h3>Tentang PestiMart</h3>
            <p><strong>PestiMart</strong> adalah solusi e-commerce khusus mahasiswa yang dirancang untuk memudahkan jual beli kebutuhan kampus. Mulai dari buku, alat tulis, hingga perlengkapan kos, semuanya tersedia dalam satu platform yang praktis, cepat, dan hemat.</p>
            <p>Dengan sistem verifikasi mahasiswa menggunakan NIM dan E-KTM, kami memastikan setiap transaksi berlangsung aman dan terpercaya. PestiMart bukan hanya tempat berbelanja, tapi juga komunitas mahasiswa yang saling membantu dalam memenuhi kebutuhan kampus.</p>
          </div>
          <div class="about-image js-reveal-right">
            <img src="ecommerce-illustration.jpg" alt="PestiMart E-commerce" onerror="this.src='heroAbout.png'" class="js-parallax" data-parallax-speed="0.15">
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Features Section -->
  <section class="section-fullscreen" id="section-features" style="background: linear-gradient(180deg, #ffffff 0%, #f8f9fa 100%);">
    <div class="section-content">
      <div class="features-section">
        <div class="features-title">
          <h3>Keunggulan PestiMart</h3>
      <p>Solusi lengkap untuk kebutuhan mahasiswa</p>
    </div>
        <div class="features-grid js-reveal">
          <div class="feature-card">
            <div class="feature-icon">🎓</div>
            <h4>Khusus Mahasiswa</h4>
            <p>Platform eksklusif dengan verifikasi NIM dan E-KTM untuk keamanan maksimal</p>
          </div>
          <div class="feature-card">
            <div class="feature-icon">⚡</div>
            <h4>Cepat & Praktis</h4>
            <p>Temukan dan beli kebutuhan kampus dalam hitungan menit</p>
          </div>
          <div class="feature-card">
            <div class="feature-icon">💰</div>
            <h4>Harga Terjangkau</h4>
            <p>Dapatkan harga terbaik dari sesama mahasiswa</p>
          </div>
          <div class="feature-card">
            <div class="feature-icon">🔒</div>
            <h4>Aman Terpercaya</h4>
            <p>Sistem keamanan berlapis untuk melindungi setiap transaksi</p>
          </div>
          <div class="feature-card">
            <div class="feature-icon">📱</div>
            <h4>Mudah Diakses</h4>
            <p>Responsive design yang dapat diakses dari perangkat apapun</p>
          </div>
          <div class="feature-card">
            <div class="feature-icon">🤝</div>
            <h4>Komunitas Aktif</h4>
            <p>Bergabung dengan komunitas mahasiswa se-Indonesia</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- CTA Section -->
  @guest
  <section class="section-fullscreen" id="section-cta" style="background: linear-gradient(135deg, var(--primary, #3A7BFF) 0%, #6366f1 100%);">
    <div class="section-content">
      <div class="cta-section" style="background: transparent; box-shadow: none;">
        <h3>Siap Bergabung?</h3>
        <p>Mulai pengalaman jual beli yang lebih mudah bersama ribuan mahasiswa lainnya</p>
        <a href="{{ route('register.buyer') }}" class="cta-btn btn-outline-primary btn-lg">
          Daftar Sekarang
        </a>
      </div>
    </div>
  </section>
  @endguest

  </div><!-- End Landing Scroll Container -->

  <script>
    function toggleMenu() {
      alert('Mobile menu akan muncul di sini');
    }

    // Section-Based Scroll with Indicator
    function initSectionScroll() {
      const scrollContainer = document.getElementById('landingScrollContainer');
      const sections = document.querySelectorAll('.section-fullscreen');
      const dots = document.querySelectorAll('.scroll-dot');
      
      // Observer for section visibility - use scroll container as root
      const sectionObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            // Add in-view class for animations
            entry.target.classList.add('in-view');
            
            // Update active dot
            const sectionIndex = Array.from(sections).indexOf(entry.target);
            dots.forEach((dot, idx) => {
              dot.classList.toggle('active', idx === sectionIndex);
            });
          }
        });
      }, {
        root: scrollContainer,
        threshold: 0.5,
        rootMargin: '0px'
      });

      sections.forEach(section => sectionObserver.observe(section));

      // Click on dots to scroll to section
      dots.forEach((dot, idx) => {
        dot.addEventListener('click', () => {
          const targetSection = sections[idx];
          if (targetSection && scrollContainer) {
            targetSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
          }
        });
      });
    }

    // Scroll Reveal with IntersectionObserver
    function initScrollReveal() {
      const scrollContainer = document.getElementById('landingScrollContainer');
      const revealElements = document.querySelectorAll('.js-reveal, .js-reveal-left, .js-reveal-right');
      
      const revealObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            entry.target.classList.add('is-visible');
          }
        });
      }, {
        root: scrollContainer,
        threshold: 0.15,
        rootMargin: '0px 0px -50px 0px'
      });

      revealElements.forEach(el => revealObserver.observe(el));
    }

    // Parallax Effect on Scroll
    function initParallax() {
      const scrollContainer = document.getElementById('landingScrollContainer');
      const parallaxElements = document.querySelectorAll('.js-parallax');
      
      function updateParallax() {
        const scrollY = scrollContainer ? scrollContainer.scrollTop : window.scrollY;
        
        parallaxElements.forEach(el => {
          const speed = parseFloat(el.dataset.parallaxSpeed) || 0.3;
          const rect = el.getBoundingClientRect();
          const centerY = rect.top + rect.height / 2;
          const windowCenterY = window.innerHeight / 2;
          const offset = (centerY - windowCenterY) * speed;
          
          el.style.transform = `translateY(${offset * -0.3}px)`;
        });
      }

      let ticking = false;
      const scrollTarget = scrollContainer || window;
      scrollTarget.addEventListener('scroll', () => {
        if (!ticking) {
          requestAnimationFrame(() => {
            updateParallax();
            ticking = false;
          });
          ticking = true;
        }
      }, { passive: true });
    }

    // Product Carousel
    const carousel = document.getElementById('productCarousel');
    let products = [];
    let currentIndex = 0;

    // Fetch products from API
    async function loadProducts() {
      try {
        const response = await fetch('/api/products');
        const data = await response.json();
        products = data.slice(0, 12); // Get first 12 products
        renderCarousel();
      } catch (error) {
        console.error('Error loading products:', error);
      }
    }

    function renderCarousel() {
      if (carousel && products.length > 0) {
        carousel.innerHTML = products.map(product => `
          <div class="product-showcase-card">
            <div class="product-image-showcase">
              ${product.image 
                ? `<img src="/storage/${product.image}" alt="${product.name}" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22200%22 height=%22180%22%3E%3Crect fill=%22%23f5f5f5%22 width=%22200%22 height=%22180%22/%3E%3Ctext x=%2250%25%22 y=%2250%25%22 font-size=%2214%22 fill=%22%23ccc%22 text-anchor=%22middle%22 dy=%22.3em%22%3ENo Image%3C/text%3E%3C/svg%3E'">`
                : `<div style="width:100%; height:100%; display:flex; align-items:center; justify-content:center; background:#f5f5f5;"><i class="fas fa-image" style="font-size:2rem; color:#ddd;"></i></div>`
              }
            </div>
            <div class="product-info-showcase">
              <div class="product-name-showcase">${product.name}</div>
              <div class="product-shop-showcase">
                <i class="fas fa-store" style="font-size:0.7rem;"></i>
                ${product.shop?.shop_name || 'Unknown Shop'}
              </div>
              <div class="product-price-showcase">
                Rp${parseInt(product.price).toLocaleString('id-ID')}
              </div>
              <div class="product-rating-showcase">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star-half-alt"></i>
                <span>(4.5)</span>
              </div>
            </div>
          </div>
        `).join('');
      }
    }

    function scrollCarousel(direction) {
      if (carousel) {
        const scrollAmount = 400;
        carousel.scrollBy({
          left: direction * scrollAmount,
          behavior: 'smooth'
        });
      }
    }

    // Auto-rotate carousel every 5 seconds
    function autoRotateCarousel() {
      setInterval(() => {
        scrollCarousel(1);
      }, 5000);
    }

    // Initialize
    document.addEventListener('DOMContentLoaded', () => {
      loadProducts();
      autoRotateCarousel();
      initSectionScroll();
      initScrollReveal();
      initParallax();
    });
  </script>
</div>
@endsection
