@extends('layouts.app')

@section('title', 'PestiMart - E-Commerce Mahasiswa')

@section('content')
 <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(to bottom, #e8f1f8 0%, #ffffff 100%);
      color: #333;
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
      color: #0a4c8c;
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
      background: #0a4c8c;
      color: white;
      box-shadow: 0 4px 12px rgba(10, 76, 140, 0.3);
    }

    .hero-btn:hover {
      background: #083b6d;
      transform: translateY(-3px);
      box-shadow: 0 6px 18px rgba(10, 76, 140, 0.4);
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
      min-width: 450px;
    }

    .about-text h3 {
      color: #0a4c8c;
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
    }

    .about-image {
      flex: 1;
      min-width: 300px;
      position: relative;
      margin-left: 100px;
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
      color: #0a4c8c;
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
      background: linear-gradient(135deg, #a6bdd5 0%, #5273a1 100%);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 18px;
      font-size: 35px;
    }

    .feature-card h4 {
      color: #0a4c8c;
      font-size: clamp(17px, 2vw, 20px);
      font-weight: 600;
      margin-bottom: 12px;
    }

    .feature-card p {
      color: #666;
      font-size: clamp(13px, 1.5vw, 15px);
      line-height: 1.6;
    }

<<<<<<< HEAD
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
      color: #667eea;
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

=======
>>>>>>> 81f0d06 (First Up|)
    /* CTA Section */
    .cta-section {
      background: linear-gradient(135deg, #5273a1 0%, #0a4c8c 100%);
      padding: 60px 5%;
      text-align: center;
      color: white;
    }

    .cta-section h3 {
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
      color: #0a4c8c;
      box-shadow: 0 4px 15px rgba(255, 255, 255, 0.3);
    }

    .cta-btn:hover {
      transform: translateY(-3px);
      box-shadow: 0 6px 20px rgba(255, 255, 255, 0.4);
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
  </style>
</head>
<body>

  <!-- Hero Section -->
   @guest
  <section class="hero-section">
    <div class="hero-content">
      <h2>Platform Jual Beli Khusus Mahasiswa</h2>
      <p>PestiMart hadir sebagai solusi praktis untuk jual beli kebutuhan kampus. Dari buku, alat tulis, hingga perlengkapan kos—semuanya ada dalam satu platform yang mudah dan aman.</p>
      <a href="{{ route('register.buyer') }}" class="hero-btn btn-outline-primary btn-lg">
                        Daftar Sekarang
                    </a>
    </div>
    @endguest
    <div class="hero-image">
      <div class="floating-elements">
        <div class="float-icon">📦</div>
        <div class="float-icon">🛒</div>
        <div class="float-icon">💳</div>
        <div class="float-icon">⭐</div>
      </div>
      <img src="https://i.postimg.cc/yx8K3Nbg/ecommerce-isometric.jpg" alt="E-commerce Illustration" onerror="this.src='logo.png'">
    </div>
  </section>

<<<<<<< HEAD
    <!-- Products Showcase Section -->
  <section style="padding: 60px 5%; background: white;">
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
        <button onclick="scrollCarousel(-1)" style="position: absolute; left: 0; top: 50%; transform: translateY(-50%); background: white; border: 2px solid #667eea; color: #667eea; width: 40px; height: 40px; border-radius: 50%; font-size: 20px; cursor: pointer; z-index: 10; transition: all 0.3s ease;" onmouseover="this.style.background='#667eea'; this.style.color='white'" onmouseout="this.style.background='white'; this.style.color='#667eea'">
          ❮
        </button>
        <button onclick="scrollCarousel(1)" style="position: absolute; right: 0; top: 50%; transform: translateY(-50%); background: white; border: 2px solid #667eea; color: #667eea; width: 40px; height: 40px; border-radius: 50%; font-size: 20px; cursor: pointer; z-index: 10; transition: all 0.3s ease;" onmouseover="this.style.background='#667eea'; this.style.color='white'" onmouseout="this.style.background='white'; this.style.color='#667eea'">
          ❯
        </button>
      </div>
    </div>
  </section>

=======
>>>>>>> 81f0d06 (First Up|)
  <!-- About Section -->
  <section class="about-section">
    <div class="about-container">
      <div class="about-text">
        <h3>Tentang PestiMart</h3>
        <p><strong>PestiMart</strong> adalah solusi e-commerce khusus mahasiswa yang dirancang untuk memudahkan jual beli kebutuhan kampus. Mulai dari buku, alat tulis, hingga perlengkapan kos, semuanya tersedia dalam satu platform yang praktis, cepat, dan hemat.</p>
        <p>Dengan sistem verifikasi mahasiswa menggunakan NIM dan E-KTM, kami memastikan setiap transaksi berlangsung aman dan terpercaya. PestiMart bukan hanya tempat berbelanja, tapi juga komunitas mahasiswa yang saling membantu dalam memenuhi kebutuhan kampus.</p>
      </div>
      <div class="about-image">
        <img src="ecommerce-illustration.jpg" alt="PestiMart E-commerce" onerror="this.src='heroAbout.png'">
      </div>
    </div>
  </section>

<<<<<<< HEAD


=======
>>>>>>> 81f0d06 (First Up|)
  <!-- Features Section -->
  <section class="features-section">
    <div class="features-title">
      <h3>Keunggulan PestiMart</h3>
      <p>Solusi lengkap untuk kebutuhan mahasiswa</p>
    </div>
    <div class="features-grid">
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
  </section>

  <!-- CTA Section -->
@guest
  <section class="cta-section">
    <h3>Siap Bergabung?</h3>
    <p>Mulai pengalaman jual beli yang lebih mudah bersama ribuan mahasiswa lainnya</p>
   <a href="{{ route('register.buyer') }}" class="cta-btn btn-outline-primary btn-lg">
                        Daftar Sekarang
                    </a>
  </section>
@endguest


  <script>
    function toggleMenu() {
      alert('Mobile menu akan muncul di sini');
    }
<<<<<<< HEAD

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
    });
=======
>>>>>>> 81f0d06 (First Up|)
  </script>
</div>
@endsection
