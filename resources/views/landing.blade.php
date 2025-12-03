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

    /* Hero Section - Banner Full Width dengan Animasi Interaktif */
    .hero-section {
      padding: 20px 3%;
      display: flex;
      justify-content: center;
      align-items: center;
      width: 100%;
      margin: 0 auto;
    }

    .hero-banner {
      position: relative;
      width: 100%;
      max-width: 1400px;
      border-radius: 24px;
      overflow: hidden;
      box-shadow: 0 20px 60px rgba(30, 58, 95, 0.25);
    }

    .hero-banner img {
      width: 100%;
      height: auto;
      min-height: 450px;
      max-height: 600px;
      object-fit: cover;
      display: block;
      transition: transform 8s ease-out;
    }
    
    .hero-banner:hover img {
      transform: scale(1.05);
    }

    .hero-overlay {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: linear-gradient(135deg, rgba(30, 58, 95, 0.88) 0%, rgba(45, 90, 135, 0.75) 40%, rgba(61, 106, 159, 0.6) 100%);
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      text-align: center;
      padding: 40px 30px;
    }
    
    /* Animated floating particles */
    .hero-overlay::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-image: 
        radial-gradient(circle at 15% 25%, rgba(255,255,255,0.15) 0%, transparent 25%),
        radial-gradient(circle at 85% 75%, rgba(255,255,255,0.1) 0%, transparent 20%),
        radial-gradient(circle at 50% 10%, rgba(255,255,255,0.08) 0%, transparent 30%),
        radial-gradient(circle at 80% 30%, rgba(255,255,255,0.12) 0%, transparent 15%);
      animation: floatParticles 12s ease-in-out infinite;
      pointer-events: none;
    }
    
    @keyframes floatParticles {
      0%, 100% { transform: translateY(0) scale(1); opacity: 1; }
      50% { transform: translateY(-15px) scale(1.02); opacity: 0.85; }
    }
    
    /* Shine sweep effect */
    .hero-overlay::after {
      content: '';
      position: absolute;
      top: -100%;
      left: -100%;
      width: 300%;
      height: 300%;
      background: linear-gradient(
        45deg,
        transparent 30%,
        rgba(255,255,255,0.03) 40%,
        rgba(255,255,255,0.1) 50%,
        rgba(255,255,255,0.03) 60%,
        transparent 70%
      );
      animation: shineSweep 6s ease-in-out infinite;
      pointer-events: none;
    }
    
    @keyframes shineSweep {
      0% { transform: translateX(-30%) translateY(-30%) rotate(45deg); }
      100% { transform: translateX(30%) translateY(30%) rotate(45deg); }
    }

    .hero-content {
      max-width: 800px;
      position: relative;
      z-index: 2;
    }
    
    /* Typing text container */
    .hero-typing-wrapper {
      min-height: 1.3em;
      margin-bottom: 5px;
    }

    .hero-content h2 {
      font-family: var(--font-display, 'Poppins'), sans-serif;
      color: #ffffff;
      font-size: clamp(34px, 5vw, 58px);
      font-weight: 700;
      line-height: 1.2;
      margin-bottom: 20px;
      text-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
      animation: fadeSlideUp 0.8s ease-out both;
    }
    
    .hero-content h2 .typing-text {
      display: inline;
      border-right: 3px solid rgba(255,255,255,0.8);
      animation: blink 0.8s step-end infinite;
    }
    
    @keyframes blink {
      50% { border-color: transparent; }
    }
    
    @keyframes fadeSlideUp {
      from { opacity: 0; transform: translateY(30px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .hero-content p {
      color: rgba(255, 255, 255, 0.95);
      font-size: clamp(15px, 2vw, 20px);
      line-height: 1.7;
      margin-bottom: 35px;
      text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
      animation: fadeSlideUp 0.8s ease-out 0.2s both;
    }

    a {
      text-decoration: none;
    }

    .hero-btn {
      padding: 16px 44px;
      border-radius: 50px;
      border: 2px solid white;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
      font-size: clamp(15px, 1.8vw, 18px);
      background: white;
      color: #1e3a5f;
      box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
      animation: fadeSlideUp 0.8s ease-out 0.4s both, btnGlow 3s ease-in-out 1.5s infinite;
      position: relative;
      overflow: hidden;
    }
    
    .hero-btn::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255,255,255,0.5), transparent);
      transition: left 0.6s ease;
    }
    
    @keyframes btnGlow {
      0%, 100% { box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2); }
      50% { box-shadow: 0 8px 40px rgba(255, 255, 255, 0.25), 0 0 25px rgba(255, 255, 255, 0.15); }
    }

    @media (hover: hover) {
      .hero-btn:hover {
        background: transparent;
        color: white;
        transform: translateY(-5px) scale(1.05);
        box-shadow: 0 15px 45px rgba(0, 0, 0, 0.3);
      }
      
      .hero-btn:hover::before {
        left: 100%;
      }
    }
    
    /* Stats counter in hero */
    .hero-stats {
      display: flex;
      gap: 2.5rem;
      margin-top: 2.5rem;
      animation: fadeSlideUp 0.8s ease-out 0.6s both;
    }
    
    .hero-stat {
      text-align: center;
    }
    
    .hero-stat-number {
      font-size: clamp(28px, 4vw, 42px);
      font-weight: 700;
      color: white;
      display: block;
      text-shadow: 0 2px 15px rgba(0,0,0,0.3);
    }
    
    .hero-stat-label {
      font-size: clamp(12px, 1.5vw, 14px);
      color: rgba(255,255,255,0.85);
      text-transform: uppercase;
      letter-spacing: 1px;
    }

    /* Mobile Hero adjustments */
    @media (max-width: 768px) {
      .hero-section {
        padding: 15px 3%;
      }

      .hero-banner {
        border-radius: 20px;
      }

      .hero-banner img {
        min-height: 380px;
        max-height: 480px;
      }

      .hero-overlay {
        padding: 30px 20px;
      }

      .hero-content h2 {
        font-size: clamp(26px, 7vw, 36px);
        margin-bottom: 15px;
      }

      .hero-content p {
        font-size: clamp(14px, 3.5vw, 16px);
        margin-bottom: 25px;
        line-height: 1.6;
      }

      .hero-btn {
        padding: 14px 34px;
        font-size: 15px;
      }
      
      .hero-stats {
        gap: 1.5rem;
        margin-top: 2rem;
      }
      
      .hero-stat-number {
        font-size: 28px;
      }
      
      .hero-stat-label {
        font-size: 11px;
      }
    }

    @media (max-width: 480px) {
      .hero-section {
        padding: 10px 2%;
      }

      .hero-banner {
        border-radius: 16px;
      }

      .hero-banner img {
        min-height: 340px;
        max-height: 420px;
      }

      .hero-overlay {
        padding: 25px 15px;
      }

      .hero-content h2 {
        font-size: 24px;
        margin-bottom: 12px;
      }

      .hero-content p {
        font-size: 13px;
        margin-bottom: 20px;
      }

      .hero-btn {
        padding: 12px 28px;
        font-size: 14px;
      }
      
      .hero-stats {
        gap: 1rem;
        flex-wrap: wrap;
        justify-content: center;
      }
      
      .hero-stat-number {
        font-size: 24px;
      }
      
      .hero-stat-label {
        font-size: 10px;
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

    /* ====== PRODUCTS CAROUSEL ENHANCED ====== */
    .products-title-animated {
      position: relative;
    }
    
    .products-badge {
      display: inline-block;
      background: linear-gradient(135deg, #ff6b6b, #ee5a5a);
      color: white;
      font-size: 0.85rem;
      font-weight: 600;
      padding: 0.4rem 1rem;
      border-radius: 2rem;
      margin-bottom: 0.75rem;
      animation: badgePulse 2s ease-in-out infinite;
    }
    
    @keyframes badgePulse {
      0%, 100% { transform: scale(1); }
      50% { transform: scale(1.05); }
    }
    
    .products-carousel-wrapper {
      max-width: 1300px;
      margin: 0 auto;
      position: relative;
      padding: 0 50px;
    }
    
    .products-carousel-container {
      overflow: hidden;
      border-radius: 1rem;
    }
    
    .products-carousel {
      display: flex;
      gap: 1.5rem;
      overflow-x: auto;
      scroll-behavior: smooth;
      padding: 1.5rem 0.5rem;
      -webkit-overflow-scrolling: touch;
      scrollbar-width: none;
      -ms-overflow-style: none;
    }
    
    .products-carousel::-webkit-scrollbar {
      display: none;
    }
    
    /* Progress bar */
    .carousel-progress-bar {
      height: 4px;
      background: #e0e7ff;
      border-radius: 2px;
      margin-top: 1rem;
      overflow: hidden;
    }
    
    .carousel-progress-fill {
      height: 100%;
      background: linear-gradient(90deg, #1e3a5f, #3d6a9f);
      border-radius: 2px;
      width: 0%;
      transition: width 0.3s ease;
    }
    
    /* Navigation buttons */
    .carousel-nav-btn {
      position: absolute;
      top: 50%;
      transform: translateY(-50%);
      width: 48px;
      height: 48px;
      border-radius: 50%;
      background: white;
      border: 2px solid #1e3a5f;
      color: #1e3a5f;
      font-size: 1.1rem;
      cursor: pointer;
      z-index: 10;
      transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
      box-shadow: 0 4px 15px rgba(30, 58, 95, 0.15);
      display: flex;
      align-items: center;
      justify-content: center;
    }
    
    .carousel-nav-btn:hover {
      background: linear-gradient(135deg, #1e3a5f, #2d5a87);
      color: white;
      border-color: transparent;
      transform: translateY(-50%) scale(1.1);
      box-shadow: 0 8px 25px rgba(30, 58, 95, 0.3);
    }
    
    .carousel-prev {
      left: 0;
    }
    
    .carousel-next {
      right: 0;
    }
    
    /* Carousel indicators */
    .carousel-indicators {
      display: flex;
      justify-content: center;
      gap: 0.5rem;
      margin-top: 1.25rem;
    }
    
    .carousel-dot {
      width: 10px;
      height: 10px;
      border-radius: 50%;
      background: #cbd5e1;
      cursor: pointer;
      transition: all 0.3s ease;
    }
    
    .carousel-dot.active {
      background: linear-gradient(135deg, #1e3a5f, #2d5a87);
      transform: scale(1.3);
    }
    
    .carousel-dot:hover {
      background: #94a3b8;
    }
    
    /* Auto-scroll toggle */
    .carousel-controls {
      display: flex;
      justify-content: center;
      margin-top: 1.5rem;
    }
    
    .auto-scroll-toggle {
      display: flex;
      align-items: center;
      gap: 0.5rem;
      padding: 0.6rem 1.25rem;
      background: linear-gradient(135deg, #f0f7ff, #e0e7ff);
      border: 1px solid #c7d2fe;
      border-radius: 2rem;
      color: #1e3a5f;
      font-size: 0.85rem;
      font-weight: 500;
      cursor: pointer;
      transition: all 0.3s ease;
    }
    
    .auto-scroll-toggle:hover {
      background: linear-gradient(135deg, #1e3a5f, #2d5a87);
      color: white;
      border-color: transparent;
    }
    
    .auto-scroll-toggle.paused {
      background: #fee2e2;
      border-color: #fecaca;
      color: #991b1b;
    }
    
    .auto-scroll-toggle.paused:hover {
      background: #ef4444;
      color: white;
    }
    
    /* Product card enhanced */
    .product-card-enhanced {
      flex: 0 0 280px;
      min-width: 280px;
      background: white;
      border-radius: 1rem;
      overflow: hidden;
      box-shadow: 0 4px 20px rgba(30, 58, 95, 0.08);
      transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
      position: relative;
      border: 1px solid #e2e8f0;
    }
    
    .product-card-enhanced:hover {
      transform: translateY(-10px) scale(1.02);
      box-shadow: 0 20px 40px rgba(30, 58, 95, 0.15);
      border-color: #3d6a9f;
    }
    
    .product-card-enhanced::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 4px;
      background: linear-gradient(90deg, #1e3a5f, #3d6a9f, #1e3a5f);
      background-size: 200% 100%;
      opacity: 0;
      transition: opacity 0.3s ease;
      animation: shimmer 2s linear infinite;
    }
    
    .product-card-enhanced:hover::before {
      opacity: 1;
    }
    
    @keyframes shimmer {
      0% { background-position: 200% 0; }
      100% { background-position: -200% 0; }
    }
    
    .product-card-image {
      position: relative;
      height: 200px;
      overflow: hidden;
      background: #f8fafc;
    }
    
    .product-card-image img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.5s ease;
    }
    
    .product-card-enhanced:hover .product-card-image img {
      transform: scale(1.1);
    }
    
    .product-card-badge {
      position: absolute;
      top: 0.75rem;
      left: 0.75rem;
      background: linear-gradient(135deg, #1e3a5f, #2d5a87);
      color: white;
      font-size: 0.7rem;
      font-weight: 600;
      padding: 0.3rem 0.6rem;
      border-radius: 0.5rem;
      z-index: 2;
    }
    
    .product-card-wishlist {
      position: absolute;
      top: 0.75rem;
      right: 0.75rem;
      width: 36px;
      height: 36px;
      background: white;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      transition: all 0.3s ease;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
      z-index: 2;
    }
    
    .product-card-wishlist:hover {
      background: #fee2e2;
      transform: scale(1.1);
    }
    
    .product-card-wishlist i {
      color: #ef4444;
      font-size: 1rem;
    }
    
    .product-card-body {
      padding: 1rem;
    }
    
    .product-card-name {
      font-weight: 600;
      font-size: 1rem;
      color: #1e3a5f;
      margin-bottom: 0.35rem;
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
      overflow: hidden;
    }
    
    .product-card-shop {
      font-size: 0.85rem;
      color: #64748b;
      margin-bottom: 0.5rem;
      display: flex;
      align-items: center;
      gap: 0.35rem;
    }
    
    .product-card-shop i {
      color: #3d6a9f;
    }
    
    .product-card-price {
      font-size: 1.2rem;
      font-weight: 700;
      color: #1e3a5f;
      margin-bottom: 0.5rem;
    }
    
    .product-card-rating {
      display: flex;
      align-items: center;
      gap: 0.25rem;
      font-size: 0.85rem;
    }
    
    .product-card-rating i {
      color: #fbbf24;
    }
    
    .product-card-rating span {
      color: #64748b;
      margin-left: 0.25rem;
    }
    
    /* Mobile adjustments */
    @media (max-width: 768px) {
      .products-carousel-wrapper {
        padding: 0 40px;
      }
      
      .carousel-nav-btn {
        width: 38px;
        height: 38px;
        font-size: 0.9rem;
      }
      
      .product-card-enhanced {
        flex: 0 0 240px;
        min-width: 240px;
      }
      
      .product-card-image {
        height: 160px;
      }
      
      .products-badge {
        font-size: 0.75rem;
        padding: 0.3rem 0.8rem;
      }
    }
    
    @media (max-width: 480px) {
      .products-carousel-wrapper {
        padding: 0 35px;
      }
      
      .carousel-nav-btn {
        width: 32px;
        height: 32px;
        font-size: 0.8rem;
      }
      
      .product-card-enhanced {
        flex: 0 0 200px;
        min-width: 200px;
      }
      
      .product-card-image {
        height: 130px;
      }
      
      .product-card-name {
        font-size: 0.9rem;
      }
      
      .product-card-price {
        font-size: 1rem;
      }
      
      .auto-scroll-toggle {
        font-size: 0.75rem;
        padding: 0.5rem 1rem;
      }
      
      .carousel-dot {
        width: 8px;
        height: 8px;
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

    /* Banner styling handled by .hero-banner */

    /* About Section */
    .about-section {
      background: linear-gradient(135deg, #f8fbff 0%, #ffffff 50%, #f0f7ff 100%);
      padding: 80px 5%;
      margin: 0;
      position: relative;
      overflow: hidden;
    }
    
    /* Animated Background Pattern */
    .about-section::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: 
        radial-gradient(circle at 10% 20%, rgba(30, 58, 95, 0.03) 0%, transparent 50%),
        radial-gradient(circle at 90% 80%, rgba(61, 106, 159, 0.03) 0%, transparent 50%);
      animation: aboutBgFloat 20s ease-in-out infinite;
      pointer-events: none;
    }
    
    @keyframes aboutBgFloat {
      0%, 100% { transform: translate(0, 0); }
      50% { transform: translate(-15px, -10px); }
    }
    
    /* Floating Decorations */
    .about-decorations {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      pointer-events: none;
      overflow: hidden;
    }
    
    .about-decoration {
      position: absolute;
      border-radius: 50%;
      opacity: 0.08;
      background: linear-gradient(135deg, #1e3a5f, #3d6a9f);
    }
    
    .about-decoration:nth-child(1) {
      width: 300px;
      height: 300px;
      top: -100px;
      right: -100px;
      animation: decorFloat1 15s ease-in-out infinite;
    }
    
    .about-decoration:nth-child(2) {
      width: 200px;
      height: 200px;
      bottom: -50px;
      left: -50px;
      animation: decorFloat2 18s ease-in-out infinite;
    }
    
    .about-decoration:nth-child(3) {
      width: 100px;
      height: 100px;
      top: 50%;
      left: 10%;
      animation: decorFloat3 12s ease-in-out infinite;
    }
    
    @keyframes decorFloat1 {
      0%, 100% { transform: translate(0, 0) scale(1); }
      50% { transform: translate(-20px, 20px) scale(1.1); }
    }
    
    @keyframes decorFloat2 {
      0%, 100% { transform: translate(0, 0) scale(1); }
      50% { transform: translate(20px, -15px) scale(0.95); }
    }
    
    @keyframes decorFloat3 {
      0%, 100% { transform: translate(0, 0); }
      50% { transform: translate(10px, -20px); }
    }

    .about-container {
      max-width: 1200px;
      margin: 0 auto;
      display: flex;
      gap: 60px;
      align-items: center;
      flex-wrap: wrap;
      position: relative;
      z-index: 1;
    }

    .about-text {
      flex: 1;
      min-width: 300px;
    }
    
    .about-badge {
      display: inline-block;
      background: linear-gradient(135deg, #1e3a5f 0%, #3d6a9f 100%);
      color: white;
      padding: 8px 20px;
      border-radius: 30px;
      font-size: 14px;
      font-weight: 600;
      margin-bottom: 15px;
      box-shadow: 0 4px 15px rgba(30, 58, 95, 0.3);
      animation: badgePulse 2s ease-in-out infinite;
    }
    
    @keyframes badgePulse {
      0%, 100% { transform: scale(1); }
      50% { transform: scale(1.05); }
    }

    .about-text h3 {
      font-family: var(--font-display, 'Poppins'), sans-serif;
      color: #1e3a5f;
      font-size: clamp(28px, 3.5vw, 42px);
      font-weight: 700;
      margin-bottom: 25px;
      position: relative;
      display: inline-block;
    }
    
    .about-text h3::after {
      content: '';
      position: absolute;
      bottom: -8px;
      left: 0;
      width: 80px;
      height: 4px;
      background: linear-gradient(90deg, #1e3a5f, #3d6a9f);
      border-radius: 2px;
      animation: underlineGrow 1s ease-out forwards;
    }
    
    @keyframes underlineGrow {
      0% { width: 0; }
      100% { width: 80px; }
    }

    .about-text p {
      color: #555;
      font-size: clamp(15px, 1.8vw, 17px);
      line-height: 1.9;
      margin-bottom: 20px;
      text-align: justify;
      word-wrap: break-word;
      overflow-wrap: break-word;
      position: relative;
    }
    
    .about-text p strong {
      color: #1e3a5f;
      font-weight: 700;
    }
    
    /* Highlight keywords */
    .about-highlight {
      background: linear-gradient(120deg, rgba(30, 58, 95, 0.1) 0%, rgba(61, 106, 159, 0.1) 100%);
      padding: 2px 8px;
      border-radius: 4px;
      color: #1e3a5f;
      font-weight: 600;
    }
    
    /* About Stats */
    .about-stats {
      display: flex;
      gap: 30px;
      margin-top: 30px;
      flex-wrap: wrap;
    }
    
    .about-stat {
      text-align: center;
      padding: 15px 20px;
      background: white;
      border-radius: 12px;
      box-shadow: 0 4px 20px rgba(30, 58, 95, 0.1);
      transition: all 0.3s ease;
      min-width: 100px;
    }
    
    .about-stat:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 30px rgba(30, 58, 95, 0.15);
    }
    
    .about-stat-number {
      display: block;
      font-size: 28px;
      font-weight: 800;
      color: #1e3a5f;
      line-height: 1.2;
    }
    
    .about-stat-label {
      display: block;
      font-size: 13px;
      color: #64748b;
      font-weight: 500;
    }

    .about-image {
      flex: 1;
      min-width: 320px;
      position: relative;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    
    .about-image-wrapper {
      position: relative;
      width: 100%;
      max-width: 400px;
    }
    
    /* Decorative Frame */
    .about-image-wrapper::before {
      content: '';
      position: absolute;
      top: -15px;
      left: -15px;
      right: 15px;
      bottom: 15px;
      border: 3px solid #1e3a5f;
      border-radius: 20px;
      opacity: 0.2;
      animation: frameFloat 4s ease-in-out infinite;
    }
    
    .about-image-wrapper::after {
      content: '';
      position: absolute;
      top: 15px;
      left: 15px;
      right: -15px;
      bottom: -15px;
      background: linear-gradient(135deg, #1e3a5f 0%, #3d6a9f 100%);
      border-radius: 20px;
      opacity: 0.1;
      z-index: -1;
      animation: frameShadow 4s ease-in-out infinite reverse;
    }
    
    @keyframes frameFloat {
      0%, 100% { transform: translate(0, 0); }
      50% { transform: translate(-5px, -5px); }
    }
    
    @keyframes frameShadow {
      0%, 100% { transform: translate(0, 0); }
      50% { transform: translate(5px, 5px); }
    }

    .about-image img {
      width: 100%;
      max-width: 400px;
      border-radius: 16px;
      box-shadow: 0 20px 60px rgba(30, 58, 95, 0.2);
      animation: imageFloat 5s ease-in-out infinite;
      object-fit: cover;
      aspect-ratio: 1 / 1;
      transition: all 0.4s ease;
    }
    
    .about-image img:hover {
      transform: scale(1.03) rotate(1deg);
      box-shadow: 0 25px 70px rgba(30, 58, 95, 0.25);
    }

    @keyframes imageFloat {
      0%, 100% { 
        transform: translateY(0px) rotate(0deg);
      }
      25% {
        transform: translateY(-10px) rotate(0.5deg);
      }
      50% { 
        transform: translateY(-15px) rotate(0deg);
      }
      75% {
        transform: translateY(-8px) rotate(-0.5deg);
      }
    }
    
    /* Floating Icons around image */
    .about-floating-icons {
      position: absolute;
      width: 100%;
      height: 100%;
      pointer-events: none;
    }
    
    .about-floating-icon {
      position: absolute;
      width: 50px;
      height: 50px;
      background: white;
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 24px;
      box-shadow: 0 8px 25px rgba(30, 58, 95, 0.15);
      animation: iconFloat 4s ease-in-out infinite;
    }
    
    .about-floating-icon:nth-child(1) {
      top: 0;
      right: -20px;
      animation-delay: 0s;
    }
    
    .about-floating-icon:nth-child(2) {
      bottom: 20%;
      left: -25px;
      animation-delay: 1s;
    }
    
    .about-floating-icon:nth-child(3) {
      bottom: -10px;
      right: 20%;
      animation-delay: 2s;
    }
    
    @keyframes iconFloat {
      0%, 100% { transform: translateY(0) rotate(0deg); }
      50% { transform: translateY(-10px) rotate(5deg); }
    }
    
    /* Responsive */
    @media (max-width: 991px) {
      .about-container {
        flex-direction: column;
        text-align: center;
      }
      
      .about-text h3::after {
        left: 50%;
        transform: translateX(-50%);
      }
      
      .about-text p {
        text-align: center;
      }
      
      .about-stats {
        justify-content: center;
      }
      
      .about-image {
        order: -1;
        margin-bottom: 20px;
      }
    }

    /* Features Section */
    .features-section {
      padding: 60px 5%;
      background: linear-gradient(to bottom, #f8fbfd 0%, #e8f1f8 100%);
      position: relative;
      overflow: hidden;
    }
    
    /* Animated background pattern for features section */
    .features-section::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-image: 
        radial-gradient(circle at 20% 30%, rgba(30, 58, 95, 0.03) 0%, transparent 50%),
        radial-gradient(circle at 80% 70%, rgba(61, 106, 159, 0.03) 0%, transparent 50%);
      animation: featureBgFloat 15s ease-in-out infinite;
      pointer-events: none;
    }
    
    @keyframes featureBgFloat {
      0%, 100% { transform: translate(0, 0); }
      50% { transform: translate(-20px, -10px); }
    }

    .features-title {
      text-align: center;
      margin-bottom: 50px;
      position: relative;
      z-index: 1;
    }

    .features-title h3 {
      font-family: var(--font-display, 'Poppins'), sans-serif;
      color: #1e3a5f;
      font-size: clamp(26px, 4vw, 38px);
      font-weight: 700;
      margin-bottom: 10px;
      animation: titleGlow 3s ease-in-out infinite;
    }
    
    @keyframes titleGlow {
      0%, 100% { text-shadow: 0 0 0 transparent; }
      50% { text-shadow: 0 0 20px rgba(30, 58, 95, 0.15); }
    }

    .features-title p {
      color: #64748b;
      font-size: clamp(14px, 1.8vw, 17px);
    }

    .features-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 30px;
      max-width: 1200px;
      margin: 0 auto;
      position: relative;
      z-index: 1;
    }

    .feature-card {
      background: white;
      padding: 30px 25px;
      border-radius: 16px;
      text-align: center;
      transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
      box-shadow: 0 4px 20px rgba(30, 58, 95, 0.08);
      border: 2px solid transparent;
      position: relative;
      overflow: hidden;
      cursor: pointer;
    }
    
    .feature-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 4px;
      background: linear-gradient(90deg, #1e3a5f, #3d6a9f, #1e3a5f);
      background-size: 200% 100%;
      transform: scaleX(0);
      transform-origin: left;
      transition: transform 0.4s ease;
    }
    
    .feature-card::after {
      content: '';
      position: absolute;
      top: -50%;
      left: -50%;
      width: 200%;
      height: 200%;
      background: radial-gradient(circle, rgba(30, 58, 95, 0.03) 0%, transparent 70%);
      opacity: 0;
      transition: opacity 0.4s ease;
      pointer-events: none;
    }

    .feature-card:hover {
      transform: translateY(-12px) scale(1.02);
      box-shadow: 0 20px 40px rgba(30, 58, 95, 0.18);
      border-color: #3d6a9f;
    }
    
    .feature-card:hover::before {
      transform: scaleX(1);
      animation: featureShimmer 1.5s linear infinite;
    }
    
    .feature-card:hover::after {
      opacity: 1;
    }
    
    @keyframes featureShimmer {
      0% { background-position: 200% 0; }
      100% { background-position: -200% 0; }
    }

    .feature-icon {
      width: 80px;
      height: 80px;
      background: linear-gradient(135deg, #1e3a5f 0%, #3d6a9f 100%);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 20px;
      font-size: 38px;
      position: relative;
      transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
      box-shadow: 0 8px 25px rgba(30, 58, 95, 0.25);
    }
    
    .feature-icon::before {
      content: '';
      position: absolute;
      inset: -4px;
      border-radius: 50%;
      background: linear-gradient(135deg, #1e3a5f, #3d6a9f, #1e3a5f);
      background-size: 200% 200%;
      z-index: -1;
      opacity: 0;
      transition: opacity 0.3s ease;
      animation: iconRing 3s linear infinite;
    }
    
    @keyframes iconRing {
      0% { background-position: 0% 50%; transform: rotate(0deg); }
      100% { background-position: 200% 50%; transform: rotate(360deg); }
    }
    
    .feature-card:hover .feature-icon {
      transform: scale(1.15) rotate(5deg);
      box-shadow: 0 12px 35px rgba(30, 58, 95, 0.35);
    }
    
    .feature-card:hover .feature-icon::before {
      opacity: 1;
    }
    
    /* Floating animation for icons */
    .feature-card:nth-child(1) .feature-icon { animation: iconFloat 4s ease-in-out infinite; }
    .feature-card:nth-child(2) .feature-icon { animation: iconFloat 4s ease-in-out 0.5s infinite; }
    .feature-card:nth-child(3) .feature-icon { animation: iconFloat 4s ease-in-out 1s infinite; }
    .feature-card:nth-child(4) .feature-icon { animation: iconFloat 4s ease-in-out 1.5s infinite; }
    .feature-card:nth-child(5) .feature-icon { animation: iconFloat 4s ease-in-out 2s infinite; }
    .feature-card:nth-child(6) .feature-icon { animation: iconFloat 4s ease-in-out 2.5s infinite; }
    
    @keyframes iconFloat {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(-8px); }
    }
    
    .feature-card:hover .feature-icon {
      animation: iconBounce 0.6s ease;
    }
    
    @keyframes iconBounce {
      0% { transform: scale(1); }
      30% { transform: scale(1.2) rotate(10deg); }
      50% { transform: scale(0.95) rotate(-5deg); }
      70% { transform: scale(1.1) rotate(3deg); }
      100% { transform: scale(1.15) rotate(5deg); }
    }

    .feature-card h4 {
      color: #1e3a5f;
      font-size: clamp(17px, 2vw, 20px);
      font-weight: 700;
      margin-bottom: 12px;
      transition: all 0.3s ease;
    }
    
    .feature-card:hover h4 {
      color: #2d5a87;
      transform: scale(1.05);
    }

    .feature-card p {
      color: #64748b;
      font-size: clamp(13px, 1.5vw, 15px);
      line-height: 1.7;
      transition: color 0.3s ease;
    }
    
    .feature-card:hover p {
      color: #475569;
    }
    
    /* Ripple effect on click */
    .feature-card .ripple {
      position: absolute;
      border-radius: 50%;
      background: rgba(30, 58, 95, 0.15);
      transform: scale(0);
      animation: rippleEffect 0.6s ease-out;
      pointer-events: none;
    }
    
    @keyframes rippleEffect {
      to {
        transform: scale(4);
        opacity: 0;
      }
    }
    
    /* Features Badge */
    .features-badge {
      display: inline-block;
      background: linear-gradient(135deg, #1e3a5f 0%, #3d6a9f 100%);
      color: white;
      padding: 8px 20px;
      border-radius: 30px;
      font-size: 14px;
      font-weight: 600;
      margin-bottom: 15px;
      box-shadow: 0 4px 15px rgba(30, 58, 95, 0.3);
      animation: badgePulse 2s ease-in-out infinite;
    }
    
    @keyframes badgePulse {
      0%, 100% { transform: scale(1); box-shadow: 0 4px 15px rgba(30, 58, 95, 0.3); }
      50% { transform: scale(1.05); box-shadow: 0 6px 25px rgba(30, 58, 95, 0.4); }
    }
    
    /* Feature Icon Wrapper */
    .feature-icon-wrapper {
      position: relative;
      width: 100px;
      height: 100px;
      margin: 0 auto 20px;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    
    /* Feature Icon Particles */
    .feature-icon-particles {
      position: absolute;
      width: 100%;
      height: 100%;
      pointer-events: none;
    }
    
    .feature-icon-particles span {
      position: absolute;
      width: 8px;
      height: 8px;
      background: linear-gradient(135deg, #1e3a5f, #3d6a9f);
      border-radius: 50%;
      opacity: 0;
    }
    
    .feature-card:hover .feature-icon-particles span {
      animation: particleBurst 0.8s ease-out forwards;
    }
    
    .feature-icon-particles span:nth-child(1) {
      top: 10%;
      left: 50%;
      animation-delay: 0s;
    }
    
    .feature-icon-particles span:nth-child(2) {
      top: 50%;
      right: 10%;
      animation-delay: 0.1s;
    }
    
    .feature-icon-particles span:nth-child(3) {
      bottom: 10%;
      left: 50%;
      animation-delay: 0.2s;
    }
    
    .feature-icon-particles span:nth-child(4) {
      top: 50%;
      left: 10%;
      animation-delay: 0.3s;
    }
    
    @keyframes particleBurst {
      0% {
        opacity: 1;
        transform: scale(0) translate(0, 0);
      }
      100% {
        opacity: 0;
        transform: scale(2) translate(var(--tx, 20px), var(--ty, -20px));
      }
    }
    
    .feature-icon-particles span:nth-child(1) { --tx: 0px; --ty: -30px; }
    .feature-icon-particles span:nth-child(2) { --tx: 30px; --ty: 0px; }
    .feature-icon-particles span:nth-child(3) { --tx: 0px; --ty: 30px; }
    .feature-icon-particles span:nth-child(4) { --tx: -30px; --ty: 0px; }
    
    /* Enhanced entrance animation for feature cards */
    .features-grid .feature-card {
      opacity: 0;
      transform: translateY(50px) scale(0.9);
    }
    
    .features-grid.is-visible .feature-card {
      animation: featureCardEnter 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
    }
    
    .features-grid.is-visible .feature-card:nth-child(1) { animation-delay: 0.1s; }
    .features-grid.is-visible .feature-card:nth-child(2) { animation-delay: 0.2s; }
    .features-grid.is-visible .feature-card:nth-child(3) { animation-delay: 0.3s; }
    .features-grid.is-visible .feature-card:nth-child(4) { animation-delay: 0.4s; }
    .features-grid.is-visible .feature-card:nth-child(5) { animation-delay: 0.5s; }
    .features-grid.is-visible .feature-card:nth-child(6) { animation-delay: 0.6s; }
    
    @keyframes featureCardEnter {
      0% {
        opacity: 0;
        transform: translateY(50px) scale(0.9) rotate(-2deg);
      }
      60% {
        transform: translateY(-10px) scale(1.02) rotate(1deg);
      }
      100% {
        opacity: 1;
        transform: translateY(0) scale(1) rotate(0deg);
      }
    }
    
    /* Subtle continuous animation on cards */
    .features-grid.is-visible .feature-card:nth-child(1) { animation: featureCardEnter 0.8s 0.1s forwards, cardSubtle 6s 1s ease-in-out infinite; }
    .features-grid.is-visible .feature-card:nth-child(2) { animation: featureCardEnter 0.8s 0.2s forwards, cardSubtle 6s 1.5s ease-in-out infinite; }
    .features-grid.is-visible .feature-card:nth-child(3) { animation: featureCardEnter 0.8s 0.3s forwards, cardSubtle 6s 2s ease-in-out infinite; }
    .features-grid.is-visible .feature-card:nth-child(4) { animation: featureCardEnter 0.8s 0.4s forwards, cardSubtle 6s 2.5s ease-in-out infinite; }
    .features-grid.is-visible .feature-card:nth-child(5) { animation: featureCardEnter 0.8s 0.5s forwards, cardSubtle 6s 3s ease-in-out infinite; }
    .features-grid.is-visible .feature-card:nth-child(6) { animation: featureCardEnter 0.8s 0.6s forwards, cardSubtle 6s 3.5s ease-in-out infinite; }
    
    @keyframes cardSubtle {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(-5px); }
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
        <div class="hero-banner js-reveal">
          <img src="{{ asset('images/landing/Banner_landing.webp') }}" alt="Banner PestiMart">
          <div class="hero-overlay">
            @guest
            <div class="hero-content">
              <div class="hero-typing-wrapper">
                <h2><span class="typing-text" id="heroTypingText"></span></h2>
              </div>
              <p>PestiMart hadir sebagai solusi praktis untuk jual beli kebutuhan kampus. Dari buku, alat tulis, hingga perlengkapan kos—semuanya ada dalam satu platform yang mudah dan aman.</p>
              <a href="{{ route('register.buyer') }}" class="hero-btn">
                <i class="fas fa-rocket" style="margin-right: 8px;"></i>Daftar Sekarang
              </a>
              <div class="hero-stats">
                <div class="hero-stat">
                  <span class="hero-stat-number" data-count="500">0</span>
                  <span class="hero-stat-label">Produk</span>
                </div>
                <div class="hero-stat">
                  <span class="hero-stat-number" data-count="200">0</span>
                  <span class="hero-stat-label">Seller</span>
                </div>
                <div class="hero-stat">
                  <span class="hero-stat-number" data-count="1000">0</span>
                  <span class="hero-stat-label">Mahasiswa</span>
                </div>
              </div>
            </div>
            @else
            <div class="hero-content">
              <div class="hero-typing-wrapper">
                <h2><span class="typing-text" id="heroTypingText"></span></h2>
              </div>
              <p>Platform jual beli khusus mahasiswa. Temukan kebutuhan kampus Anda dengan mudah dan aman.</p>
              @if(auth()->user()->role === 'buyer')
              <a href="{{ route('buyer.home') }}" class="hero-btn">
                <i class="fas fa-shopping-bag" style="margin-right: 8px;"></i>Jelajahi Produk
              </a>
              @else
              <a href="{{ route('seller.dashboard') }}" class="hero-btn">
                <i class="fas fa-store" style="margin-right: 8px;"></i>Ke Dashboard
              </a>
              @endif
              <div class="hero-stats">
                <div class="hero-stat">
                  <span class="hero-stat-number" data-count="500">0</span>
                  <span class="hero-stat-label">Produk</span>
                </div>
                <div class="hero-stat">
                  <span class="hero-stat-number" data-count="200">0</span>
                  <span class="hero-stat-label">Seller</span>
                </div>
                <div class="hero-stat">
                  <span class="hero-stat-number" data-count="1000">0</span>
                  <span class="hero-stat-label">Mahasiswa</span>
                </div>
              </div>
            </div>
            @endguest
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Products Showcase Section -->
  <section class="section-fullscreen" id="section-products" style="background: linear-gradient(180deg, #f8faff 0%, #ffffff 50%, #f0f7ff 100%);">
    <div class="section-content" style="padding: 60px 5%;">
      <div class="features-title products-title-animated">
        <span class="products-badge">🔥 Trending</span>
        <h3>Produk Unggulan</h3>
        <p>Jelajahi koleksi produk terpopuler dari seller terpercaya</p>
      </div>
      <div class="products-carousel-wrapper">
        <div class="products-carousel-container">
          <div id="productCarousel" class="products-carousel">
            <!-- Products will be populated here -->
          </div>
          <!-- Progress bar -->
          <div class="carousel-progress-bar">
            <div class="carousel-progress-fill" id="carouselProgress"></div>
          </div>
        </div>
        <!-- Navigation arrows -->
        <button class="carousel-nav-btn carousel-prev" onclick="scrollCarousel(-1)" aria-label="Previous">
          <i class="fas fa-chevron-left"></i>
        </button>
        <button class="carousel-nav-btn carousel-next" onclick="scrollCarousel(1)" aria-label="Next">
          <i class="fas fa-chevron-right"></i>
        </button>
        <!-- Carousel indicators -->
        <div class="carousel-indicators" id="carouselIndicators">
          <!-- Will be populated by JS -->
        </div>
      </div>
      <!-- Auto-scroll toggle -->
      <div class="carousel-controls">
        <button class="auto-scroll-toggle" id="autoScrollToggle" onclick="toggleAutoScroll()">
          <i class="fas fa-pause" id="autoScrollIcon"></i>
          <span id="autoScrollText">Auto-scroll: ON</span>
        </button>
      </div>
    </div>
  </section>

  <!-- About Section -->
  <section class="section-fullscreen" id="section-about" style="background: linear-gradient(135deg, #f0f7ff 0%, #ffffff 100%);">
    <div class="section-content">
      <div class="about-section">
        <!-- Floating Decorations -->
        <div class="about-decorations">
          <div class="about-decoration"></div>
          <div class="about-decoration"></div>
          <div class="about-decoration"></div>
        </div>
        
        <div class="about-container">
          <div class="about-text js-reveal-left">
            <span class="about-badge">📖 Tentang Kami</span>
            <h3>Tentang PestiMart</h3>
            <p><strong>PestiMart</strong> adalah solusi <span class="about-highlight">e-commerce khusus mahasiswa</span> yang dirancang untuk memudahkan jual beli kebutuhan kampus. Mulai dari buku, alat tulis, hingga perlengkapan kos, semuanya tersedia dalam satu platform yang <span class="about-highlight">praktis, cepat, dan hemat</span>.</p>
            <p>Dengan sistem verifikasi mahasiswa menggunakan <span class="about-highlight">NIM dan E-KTM</span>, kami memastikan setiap transaksi berlangsung aman dan terpercaya. PestiMart bukan hanya tempat berbelanja, tapi juga komunitas mahasiswa yang saling membantu dalam memenuhi kebutuhan kampus.</p>
            
            <!-- About Stats -->
            <div class="about-stats">
              <div class="about-stat">
                <span class="about-stat-number" data-count="500">0</span>
                <span class="about-stat-label">Produk</span>
              </div>
              <div class="about-stat">
                <span class="about-stat-number" data-count="200">0</span>
                <span class="about-stat-label">Penjual</span>
              </div>
              <div class="about-stat">
                <span class="about-stat-number" data-count="1000">0</span>
                <span class="about-stat-label">Mahasiswa</span>
              </div>
            </div>
          </div>
          <div class="about-image js-reveal-right">
            <div class="about-image-wrapper">
              <img src="{{ asset('images/landing/about-us.webp') }}" alt="PestiMart E-commerce" class="js-parallax" data-parallax-speed="0.15">
              
              <!-- Floating Icons -->
              <div class="about-floating-icons">
                <div class="about-floating-icon">🎓</div>
                <div class="about-floating-icon">📚</div>
                <div class="about-floating-icon">🛒</div>
              </div>
            </div>
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
          <span class="features-badge">✨ Keunggulan Kami</span>
          <h3>Keunggulan PestiMart</h3>
          <p>Solusi lengkap untuk kebutuhan mahasiswa</p>
        </div>
        <div class="features-grid js-reveal">
          <div class="feature-card" data-feature="1">
            <div class="feature-icon-wrapper">
              <div class="feature-icon">🎓</div>
              <div class="feature-icon-particles">
                <span></span><span></span><span></span><span></span>
              </div>
            </div>
            <h4>Khusus Mahasiswa</h4>
            <p>Platform eksklusif dengan verifikasi NIM dan E-KTM untuk keamanan maksimal</p>
          </div>
          <div class="feature-card" data-feature="2">
            <div class="feature-icon-wrapper">
              <div class="feature-icon">⚡</div>
              <div class="feature-icon-particles">
                <span></span><span></span><span></span><span></span>
              </div>
            </div>
            <h4>Cepat & Praktis</h4>
            <p>Temukan dan beli kebutuhan kampus dalam hitungan menit</p>
          </div>
          <div class="feature-card" data-feature="3">
            <div class="feature-icon-wrapper">
              <div class="feature-icon">💰</div>
              <div class="feature-icon-particles">
                <span></span><span></span><span></span><span></span>
              </div>
            </div>
            <h4>Harga Terjangkau</h4>
            <p>Dapatkan harga terbaik dari sesama mahasiswa</p>
          </div>
          <div class="feature-card" data-feature="4">
            <div class="feature-icon-wrapper">
              <div class="feature-icon">🔒</div>
              <div class="feature-icon-particles">
                <span></span><span></span><span></span><span></span>
              </div>
            </div>
            <h4>Aman Terpercaya</h4>
            <p>Sistem keamanan berlapis untuk melindungi setiap transaksi</p>
          </div>
          <div class="feature-card" data-feature="5">
            <div class="feature-icon-wrapper">
              <div class="feature-icon">📱</div>
              <div class="feature-icon-particles">
                <span></span><span></span><span></span><span></span>
              </div>
            </div>
            <h4>Mudah Diakses</h4>
            <p>Responsive design yang dapat diakses dari perangkat apapun</p>
          </div>
          <div class="feature-card" data-feature="6">
            <div class="feature-icon-wrapper">
              <div class="feature-icon">🤝</div>
              <div class="feature-icon-particles">
                <span></span><span></span><span></span><span></span>
              </div>
            </div>
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
    
    // About Stats Counter Animation
    function initAboutStatsCounter() {
      const scrollContainer = document.getElementById('landingScrollContainer');
      const statNumbers = document.querySelectorAll('.about-stat-number');
      
      if (statNumbers.length === 0) return;
      
      const animateCounter = (element) => {
        const target = parseInt(element.dataset.count) || 0;
        const duration = 2000;
        const startTime = performance.now();
        const startValue = 0;
        
        const updateCounter = (currentTime) => {
          const elapsed = currentTime - startTime;
          const progress = Math.min(elapsed / duration, 1);
          
          // Easing function for smooth animation
          const easeOut = 1 - Math.pow(1 - progress, 3);
          const currentValue = Math.floor(startValue + (target - startValue) * easeOut);
          
          element.textContent = currentValue.toLocaleString() + '+';
          
          if (progress < 1) {
            requestAnimationFrame(updateCounter);
          }
        };
        
        requestAnimationFrame(updateCounter);
      };
      
      const statsObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting && !entry.target.classList.contains('counted')) {
            entry.target.classList.add('counted');
            animateCounter(entry.target);
          }
        });
      }, {
        root: scrollContainer,
        threshold: 0.5
      });
      
      statNumbers.forEach(el => statsObserver.observe(el));
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

    // Product Carousel Enhanced
    const carousel = document.getElementById('productCarousel');
    const progressBar = document.getElementById('carouselProgress');
    const indicatorsContainer = document.getElementById('carouselIndicators');
    let products = [];
    let currentIndex = 0;
    let autoScrollInterval = null;
    let isAutoScrolling = true;
    const AUTO_SCROLL_DELAY = 4000;

    // Fetch products from API
    async function loadProducts() {
      try {
        const response = await fetch('/api/products');
        const data = await response.json();
        products = data.slice(0, 12); // Get first 12 products
        renderCarousel();
        initCarouselFeatures();
      } catch (error) {
        console.error('Error loading products:', error);
      }
    }

    function renderCarousel() {
      if (carousel && products.length > 0) {
        carousel.innerHTML = products.map((product, index) => `
          <div class="product-card-enhanced" data-index="${index}">
            <div class="product-card-image">
              ${product.image 
                ? `<img src="/storage/${product.image}" alt="${product.name}" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22200%22 height=%22180%22%3E%3Crect fill=%22%23f5f5f5%22 width=%22200%22 height=%22180%22/%3E%3Ctext x=%2250%25%22 y=%2250%25%22 font-size=%2214%22 fill=%22%23ccc%22 text-anchor=%22middle%22 dy=%22.3em%22%3ENo Image%3C/text%3E%3C/svg%3E'">`
                : `<div style="width:100%; height:100%; display:flex; align-items:center; justify-content:center; background:#f5f5f5;"><i class="fas fa-image" style="font-size:2rem; color:#ddd;"></i></div>`
              }
              ${index < 3 ? '<span class="product-card-badge">Popular</span>' : ''}
              <div class="product-card-wishlist">
                <i class="far fa-heart"></i>
              </div>
            </div>
            <div class="product-card-body">
              <div class="product-card-name">${product.name}</div>
              <div class="product-card-shop">
                <i class="fas fa-store"></i>
                ${product.shop?.shop_name || 'Unknown Shop'}
              </div>
              <div class="product-card-price">
                Rp${parseInt(product.price).toLocaleString('id-ID')}
              </div>
              <div class="product-card-rating">
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
        
        // Create indicators
        createIndicators();
        
        // Add wishlist click handlers
        document.querySelectorAll('.product-card-wishlist').forEach(btn => {
          btn.addEventListener('click', (e) => {
            e.stopPropagation();
            const icon = btn.querySelector('i');
            icon.classList.toggle('far');
            icon.classList.toggle('fas');
            btn.style.background = icon.classList.contains('fas') ? '#fee2e2' : 'white';
          });
        });
      }
    }
    
    function createIndicators() {
      if (!indicatorsContainer || products.length === 0) return;
      
      const numDots = Math.ceil(products.length / 3);
      indicatorsContainer.innerHTML = '';
      
      for (let i = 0; i < numDots; i++) {
        const dot = document.createElement('div');
        dot.className = 'carousel-dot' + (i === 0 ? ' active' : '');
        dot.addEventListener('click', () => scrollToIndex(i));
        indicatorsContainer.appendChild(dot);
      }
    }
    
    function scrollToIndex(index) {
      if (!carousel) return;
      const cards = carousel.querySelectorAll('.product-card-enhanced');
      if (cards[index * 3]) {
        cards[index * 3].scrollIntoView({ behavior: 'smooth', inline: 'start', block: 'nearest' });
      }
      updateIndicators(index);
    }
    
    function updateIndicators(activeIndex) {
      const dots = indicatorsContainer?.querySelectorAll('.carousel-dot');
      dots?.forEach((dot, idx) => {
        dot.classList.toggle('active', idx === activeIndex);
      });
    }
    
    function updateProgressBar() {
      if (!carousel || !progressBar) return;
      const scrollLeft = carousel.scrollLeft;
      const scrollWidth = carousel.scrollWidth - carousel.clientWidth;
      const progress = scrollWidth > 0 ? (scrollLeft / scrollWidth) * 100 : 0;
      progressBar.style.width = progress + '%';
      
      // Update indicators based on scroll position
      const numDots = Math.ceil(products.length / 3);
      const activeIndex = Math.round((scrollLeft / scrollWidth) * (numDots - 1)) || 0;
      updateIndicators(activeIndex);
    }
    
    function initCarouselFeatures() {
      if (!carousel) return;
      
      // Track scroll for progress bar
      carousel.addEventListener('scroll', updateProgressBar);
      
      // Pause auto-scroll on hover
      carousel.addEventListener('mouseenter', () => {
        if (isAutoScrolling) pauseAutoScroll();
      });
      
      carousel.addEventListener('mouseleave', () => {
        if (isAutoScrolling) startAutoScroll();
      });
      
      // Touch events for mobile
      carousel.addEventListener('touchstart', () => {
        if (isAutoScrolling) pauseAutoScroll();
      }, { passive: true });
      
      carousel.addEventListener('touchend', () => {
        if (isAutoScrolling) {
          setTimeout(() => startAutoScroll(), 2000);
        }
      }, { passive: true });
      
      // Start auto-scroll
      startAutoScroll();
    }

    function scrollCarousel(direction) {
      if (carousel) {
        const cardWidth = carousel.querySelector('.product-card-enhanced')?.offsetWidth || 300;
        const scrollAmount = (cardWidth + 24) * direction; // card width + gap
        carousel.scrollBy({
          left: scrollAmount,
          behavior: 'smooth'
        });
        
        // If at end, loop back to start
        setTimeout(() => {
          if (carousel.scrollLeft >= carousel.scrollWidth - carousel.clientWidth - 10) {
            carousel.scrollTo({ left: 0, behavior: 'smooth' });
          }
        }, 500);
      }
    }
    
    function startAutoScroll() {
      if (autoScrollInterval) clearInterval(autoScrollInterval);
      autoScrollInterval = setInterval(() => {
        if (carousel) {
          const atEnd = carousel.scrollLeft >= carousel.scrollWidth - carousel.clientWidth - 10;
          if (atEnd) {
            carousel.scrollTo({ left: 0, behavior: 'smooth' });
          } else {
            scrollCarousel(1);
          }
        }
      }, AUTO_SCROLL_DELAY);
    }
    
    function pauseAutoScroll() {
      if (autoScrollInterval) {
        clearInterval(autoScrollInterval);
        autoScrollInterval = null;
      }
    }
    
    function toggleAutoScroll() {
      isAutoScrolling = !isAutoScrolling;
      const btn = document.getElementById('autoScrollToggle');
      const icon = document.getElementById('autoScrollIcon');
      const text = document.getElementById('autoScrollText');
      
      if (isAutoScrolling) {
        startAutoScroll();
        btn.classList.remove('paused');
        icon.className = 'fas fa-pause';
        text.textContent = 'Auto-scroll: ON';
      } else {
        pauseAutoScroll();
        btn.classList.add('paused');
        icon.className = 'fas fa-play';
        text.textContent = 'Auto-scroll: OFF';
      }
    }

    // Initialize
    document.addEventListener('DOMContentLoaded', () => {
      loadProducts();
      initSectionScroll();
      initScrollReveal();
      initParallax();
      initTypingEffect();
      initCounterAnimation();
      initAboutStatsCounter();
    });
    
    // Typing Effect for Hero Title
    function initTypingEffect() {
      const typingElement = document.getElementById('heroTypingText');
      if (!typingElement) return;
      
      const texts = [
        'Platform Jual Beli Khusus Mahasiswa',
        'Belanja Mudah & Aman',
        'Harga Terjangkau Mahasiswa',
        'Komunitas Kampus Terpercaya'
      ];
      
      let textIndex = 0;
      let charIndex = 0;
      let isDeleting = false;
      let typingSpeed = 80;
      
      function type() {
        const currentText = texts[textIndex];
        
        if (isDeleting) {
          typingElement.textContent = currentText.substring(0, charIndex - 1);
          charIndex--;
          typingSpeed = 40;
        } else {
          typingElement.textContent = currentText.substring(0, charIndex + 1);
          charIndex++;
          typingSpeed = 80;
        }
        
        if (!isDeleting && charIndex === currentText.length) {
          isDeleting = true;
          typingSpeed = 2000; // Pause at end
        } else if (isDeleting && charIndex === 0) {
          isDeleting = false;
          textIndex = (textIndex + 1) % texts.length;
          typingSpeed = 500; // Pause before next text
        }
        
        setTimeout(type, typingSpeed);
      }
      
      // Start typing
      setTimeout(type, 1000);
    }
    
    // Counter Animation for Stats
    function initCounterAnimation() {
      const counters = document.querySelectorAll('.hero-stat-number');
      
      const animateCounter = (counter) => {
        const target = parseInt(counter.getAttribute('data-count'));
        const duration = 2000;
        const increment = target / (duration / 16);
        let current = 0;
        
        const updateCounter = () => {
          current += increment;
          if (current < target) {
            counter.textContent = Math.floor(current) + '+';
            requestAnimationFrame(updateCounter);
          } else {
            counter.textContent = target + '+';
          }
        };
        
        updateCounter();
      };
      
      // Use Intersection Observer to trigger animation when visible
      const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            const counters = entry.target.querySelectorAll('.hero-stat-number');
            counters.forEach(counter => {
              if (!counter.classList.contains('animated')) {
                counter.classList.add('animated');
                animateCounter(counter);
              }
            });
          }
        });
      }, { threshold: 0.5 });
      
      const heroSection = document.getElementById('section-hero');
      if (heroSection) {
        observer.observe(heroSection);
      }
    }
    
    // Feature Cards Ripple Effect
    function initFeatureCardsInteraction() {
      const featureCards = document.querySelectorAll('.feature-card');
      
      featureCards.forEach(card => {
        // Ripple effect on click
        card.addEventListener('click', function(e) {
          const ripple = document.createElement('span');
          ripple.classList.add('ripple');
          
          const rect = this.getBoundingClientRect();
          const x = e.clientX - rect.left;
          const y = e.clientY - rect.top;
          
          ripple.style.left = x + 'px';
          ripple.style.top = y + 'px';
          ripple.style.width = ripple.style.height = Math.max(rect.width, rect.height) + 'px';
          
          this.appendChild(ripple);
          
          setTimeout(() => ripple.remove(), 600);
        });
        
        // Tilt effect on mouse move
        card.addEventListener('mousemove', function(e) {
          const rect = this.getBoundingClientRect();
          const x = e.clientX - rect.left;
          const y = e.clientY - rect.top;
          
          const centerX = rect.width / 2;
          const centerY = rect.height / 2;
          
          const rotateX = (y - centerY) / 20;
          const rotateY = (centerX - x) / 20;
          
          this.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) translateY(-12px) scale(1.02)`;
        });
        
        card.addEventListener('mouseleave', function() {
          this.style.transform = '';
        });
      });
    }
    
    // Initialize feature cards interaction
    document.addEventListener('DOMContentLoaded', function() {
      setTimeout(initFeatureCardsInteraction, 100);
    });
  </script>
</div>
@endsection
