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
  </script>
</div>
@endsection
