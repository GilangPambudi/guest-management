<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>QREW - Guest Management System</title>
    <meta name="description" content="Sistem Manajemen Tamu Digital yang Modern dan Efisien untuk Event Anda">
    <meta name="keywords" content="guest management, event management, QR code, digital invitation">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Main CSS File -->
    <style>
        /* CSS Variables */
        :root {
            --default-font: "Roboto", system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            --heading-font: "Raleway", sans-serif;
            --nav-font: "Ubuntu", sans-serif;
            --background-color: #ffffff;
            --default-color: #212529;
            --heading-color: #32353a;
            --accent-color: #667eea;
            --surface-color: #ffffff;
            --contrast-color: #ffffff;
            --nav-color: #3a3939;
            --nav-hover-color: #667eea;
            --nav-mobile-background-color: #ffffff;
            --nav-dropdown-background-color: #ffffff;
            --nav-dropdown-color: #3a3939;
            --nav-dropdown-hover-color: #667eea;
        }

        /* Global Styles */
        * {
            box-sizing: border-box;
        }

        body {
            color: var(--default-color);
            background-color: var(--background-color);
            font-family: var(--default-font);
        }

        a {
            color: var(--accent-color);
            text-decoration: none;
            transition: 0.3s;
        }

        a:hover {
            color: color-mix(in srgb, var(--accent-color), transparent 25%);
            text-decoration: none;
        }

        h1, h2, h3, h4, h5, h6 {
            color: var(--heading-color);
            font-family: var(--heading-font);
        }

        /* Header */
        .header {
            color: var(--default-color);
            background-color: var(--background-color);
            padding: 15px 0;
            transition: all 0.5s;
            z-index: 997;
            box-shadow: 0px 0 18px rgba(0, 0, 0, 0.1);
        }

        .header .logo {
            line-height: 1;
        }

        .header .logo h1 {
            font-size: 30px;
            margin: 0;
            font-weight: 700;
            color: var(--accent-color);
        }

        .header .btn-getstarted,
        .header .btn-getstarted:focus {
            color: var(--contrast-color);
            background: var(--accent-color);
            font-size: 14px;
            padding: 8px 25px;
            margin: 0 0 0 30px;
            border-radius: 50px;
            transition: 0.3s;
            border: none;
        }

        .header .btn-getstarted:hover,
        .header .btn-getstarted:focus:hover {
            color: var(--contrast-color);
            background: color-mix(in srgb, var(--accent-color), transparent 15%);
        }

        /* Navigation Menu */
        .navmenu {
            padding: 0;
        }

        .navmenu ul {
            margin: 0;
            padding: 0;
            display: flex;
            list-style: none;
            align-items: center;
        }

        .navmenu li {
            position: relative;
        }

        .navmenu a,
        .navmenu a:focus {
            color: var(--nav-color);
            padding: 18px 15px;
            font-size: 16px;
            font-family: var(--nav-font);
            font-weight: 400;
            display: flex;
            align-items: center;
            justify-content: space-between;
            white-space: nowrap;
            transition: 0.3s;
        }

        .navmenu a:hover,
        .navmenu .active,
        .navmenu .active:focus {
            color: var(--nav-hover-color);
        }

        /* Mobile Navigation */
        .mobile-nav-toggle {
            color: var(--nav-color);
            font-size: 28px;
            line-height: 0;
            margin-right: 10px;
            cursor: pointer;
            transition: color 0.3s;
        }

        /* Sections */
        section, .section {
            color: var(--default-color);
            background-color: var(--background-color);
            padding: 60px 0;
            scroll-margin-top: 100px;
            overflow: clip;
        }

        /* Section Titles */
        .section-title {
            text-align: center;
            padding: 30px 0;
            margin-bottom: 30px;
            position: relative;
        }

        .section-title h2 {
            font-size: 32px;
            font-weight: 700;
            text-transform: uppercase;
            margin-bottom: 20px;
            padding-bottom: 0;
            position: relative;
            z-index: 2;
        }

        .section-title span {
            position: absolute;
            top: 4px;
            color: color-mix(in srgb, var(--heading-color), transparent 95%);
            left: 0;
            right: 0;
            z-index: 1;
            font-weight: 700;
            font-size: 52px;
            text-transform: uppercase;
            line-height: 1;
        }

        .section-title p {
            margin-bottom: 0;
            position: relative;
            z-index: 2;
        }

        /* Hero Section */
        .hero {
            width: 100%;
            min-height: 70vh;
            position: relative;
            padding: 120px 0 60px 0;
            display: flex;
            align-items: center;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .hero h1 {
            margin: 0;
            font-size: 48px;
            font-weight: 700;
            line-height: 56px;
            color: white;
        }

        .hero p {
            color: rgba(255, 255, 255, 0.8);
            margin: 5px 0 30px 0;
            font-size: 20px;
            font-weight: 400;
        }

        .hero .btn-get-started {
            color: var(--contrast-color);
            background: rgba(255, 255, 255, 0.2);
            font-family: var(--heading-font);
            font-weight: 400;
            font-size: 15px;
            letter-spacing: 1px;
            display: inline-block;
            padding: 10px 28px 12px 28px;
            border-radius: 50px;
            transition: 0.5s;
            box-shadow: 0 8px 28px rgba(0, 0, 0, 0.1);
            border: 2px solid rgba(255, 255, 255, 0.3);
        }

        .hero .btn-get-started:hover {
            color: var(--accent-color);
            background: white;
            box-shadow: 0 8px 28px rgba(0, 0, 0, 0.1);
        }

        .hero .btn-watch-video {
            font-size: 16px;
            transition: 0.5s;
            margin-left: 25px;
            color: white;
            font-weight: 600;
        }

        .hero .btn-watch-video i {
            color: rgba(255, 255, 255, 0.8);
            font-size: 32px;
            transition: 0.3s;
            line-height: 0;
            margin-right: 8px;
        }

        .hero .btn-watch-video:hover {
            color: white;
        }

        .hero .btn-watch-video:hover i {
            color: white;
        }

        /* Featured Services */
        .featured-services .service-item {
            background-color: var(--surface-color);
            padding: 60px 30px;
            transition: all ease-in-out 0.3s;
            border-radius: 18px;
            height: 100%;
            position: relative;
            z-index: 1;
            box-shadow: 0 0 45px rgba(0, 0, 0, 0.08);
        }

        .featured-services .service-item .icon {
            margin: 0 auto 20px auto;
            width: 64px;
            height: 64px;
            background: var(--accent-color);
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            transition: 0.3s;
        }

        .featured-services .service-item .icon i {
            color: var(--contrast-color);
            font-size: 28px;
            transition: ease-in-out 0.3s;
        }

        .featured-services .service-item h4 {
            font-weight: 700;
            margin-bottom: 15px;
            font-size: 24px;
        }

        .featured-services .service-item h4 a {
            color: var(--heading-color);
            transition: ease-in-out 0.3s;
        }

        .featured-services .service-item p {
            line-height: 24px;
            font-size: 14px;
            margin-bottom: 0;
        }

        .featured-services .service-item:hover {
            transform: translateY(-10px);
        }

        .featured-services .service-item:hover h4 a {
            color: var(--accent-color);
        }

        /* Services Section */
        .services .service-item {
            background-color: var(--surface-color);
            text-align: center;
            border: 1px solid color-mix(in srgb, var(--default-color), transparent 85%);
            padding: 80px 20px;
            transition: border ease-in-out 0.3s;
            height: 100%;
        }

        .services .service-item .icon {
            margin: 0 auto;
            width: 64px;
            height: 64px;
            background: var(--accent-color);
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            transition: 0.3s;
        }

        .services .service-item .icon i {
            color: var(--contrast-color);
            font-size: 28px;
            transition: ease-in-out 0.3s;
        }

        .services .service-item h3 {
            font-weight: 700;
            margin: 10px 0 15px 0;
            font-size: 22px;
            transition: 0.3s;
        }

        .services .service-item p {
            line-height: 24px;
            font-size: 14px;
            margin-bottom: 0;
        }

        .services .service-item:hover {
            border-color: var(--accent-color);
        }

        .services .service-item:hover h3 {
            color: var(--accent-color);
        }

        /* Call to Action */
        .call-to-action {
            padding: 80px 0;
            position: relative;
            background: var(--accent-color);
            color: white;
        }

        .call-to-action h3 {
            color: white;
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 15px;
        }

        .call-to-action p {
            color: rgba(255, 255, 255, 0.8);
        }

        .call-to-action .cta-btn {
            font-family: var(--heading-font);
            font-weight: 500;
            font-size: 16px;
            letter-spacing: 1px;
            display: inline-block;
            padding: 12px 40px;
            border-radius: 50px;
            transition: 0.5s;
            margin: 10px;
            border: 2px solid white;
            color: white;
        }

        .call-to-action .cta-btn:hover {
            background: white;
            color: var(--accent-color);
        }

        /* Footer */
        .footer {
            color: var(--default-color);
            background-color: var(--heading-color);
            font-size: 14px;
            position: relative;
        }

        .footer h4 {
            color: white;
            font-size: 16px;
            font-weight: bold;
            position: relative;
            padding-bottom: 12px;
        }

        .footer .footer-links {
            margin-bottom: 30px;
        }

        .footer .footer-links ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .footer .footer-links ul i {
            padding-right: 2px;
            font-size: 12px;
            line-height: 0;
        }

        .footer .footer-links ul li {
            padding: 10px 0;
            display: flex;
            align-items: center;
        }

        .footer .footer-links ul li:first-child {
            padding-top: 0;
        }

        .footer .footer-links ul a {
            color: color-mix(in srgb, white, transparent 30%);
            display: inline-block;
            line-height: 1;
        }

        .footer .footer-links ul a:hover {
            color: white;
        }

        .footer .social-links a {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 1px solid color-mix(in srgb, white, transparent 50%);
            font-size: 16px;
            color: color-mix(in srgb, white, transparent 30%);
            margin-right: 10px;
            transition: 0.3s;
        }

        .footer .social-links a:hover {
            color: white;
            border-color: white;
        }

        .footer .copyright {
            padding: 25px 0;
            border-top: 1px solid color-mix(in srgb, white, transparent 90%);
        }

        .footer .copyright p {
            margin-bottom: 0;
            color: color-mix(in srgb, white, transparent 30%);
        }

        .footer .credits {
            margin-top: 6px;
            font-size: 13px;
            color: color-mix(in srgb, white, transparent 30%);
        }

        /* Responsive */
        @media (max-width: 1199px) {
            .header .logo {
                order: 1;
            }
            .header .btn-getstarted {
                order: 2;
                margin: 0 15px 0 0;
                padding: 6px 15px;
            }
            .header .navmenu {
                order: 3;
            }
        }

        @media (max-width: 640px) {
            .hero h1 {
                font-size: 28px;
                line-height: 36px;
            }
            .hero p {
                font-size: 18px;
                line-height: 24px;
                margin-bottom: 30px;
            }
        }
    </style>
</head>
<body class="index-page">

    <!-- Header -->
    <header id="header" class="header d-flex align-items-center sticky-top">
        <div class="container-fluid container-xl position-relative d-flex align-items-center">

            <a href="/" class="logo d-flex align-items-center me-auto">
                <i class="bi bi-qr-code me-2"></i>
                <h1 class="sitename">QREW</h1>
            </a>

            <nav id="navmenu" class="navmenu">
                <ul>
                    <li><a href="#hero" class="active">Home</a></li>
                    <li><a href="#featured-services">Fitur</a></li>
                    <li><a href="#services">Layanan</a></li>
                    <li><a href="#call-to-action">Mulai</a></li>
                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>

            @auth
                <a class="btn-getstarted" href="{{ url('/dashboard') }}">Dashboard</a>
            @else
                <a class="btn-getstarted" href="{{ route('register') }}">Get Started</a>
            @endauth

        </div>
    </header>

    <main class="main">

        <!-- Hero Section -->
        <section id="hero" class="hero section">
            <div class="container">
                <div class="row gy-4">
                    <div class="col-lg-6 order-2 order-lg-1 d-flex flex-column justify-content-center">
                        <h1>Sistem Manajemen Tamu Digital yang Inovatif</h1>
                        <p>QREW adalah platform modern untuk mengelola undangan, tamu, dan acara dengan teknologi QR Code terintegrasi</p>
                        <div class="d-flex">
                            @auth
                                <a href="{{ url('/dashboard') }}" class="btn-get-started">Ke Dashboard</a>
                            @else
                                <a href="{{ route('register') }}" class="btn-get-started">Mulai Sekarang</a>
                                <a href="{{ route('login') }}" class="btn-watch-video d-flex align-items-center">
                                    <i class="bi bi-box-arrow-in-right"></i><span>Login</span>
                                </a>
                            @endauth
                        </div>
                    </div>
                    <div class="col-lg-6 order-1 order-lg-2 hero-img">
                        <img src="{{ asset('logoQR-transparent.png') }}" class="img-fluid animated" alt="QREW Logo">
                    </div>
                </div>
            </div>
        </section><!-- /Hero Section -->

        <!-- Featured Services Section -->
        <section id="featured-services" class="featured-services section">
            <div class="container">
                <div class="row gy-4">
                    <div class="col-lg-4 d-flex">
                        <div class="service-item position-relative">
                            <div class="icon">
                                <i class="bi bi-qr-code icon"></i>
                            </div>
                            <h4><a href="" class="stretched-link">QR Code Integration</a></h4>
                            <p>Setiap tamu mendapat QR code unik untuk check-in yang cepat dan mudah</p>
                        </div>
                    </div><!-- End Service Item -->

                    <div class="col-lg-4 d-flex">
                        <div class="service-item position-relative">
                            <div class="icon">
                                <i class="bi bi-people icon"></i>
                            </div>
                            <h4><a href="" class="stretched-link">Manajemen Tamu</a></h4>
                            <p>Kelola daftar tamu dan pantau kehadiran secara real-time</p>
                        </div>
                    </div><!-- End Service Item -->

                    <div class="col-lg-4 d-flex">
                        <div class="service-item position-relative">
                            <div class="icon">
                                <i class="bi bi-gift icon"></i>
                            </div>
                            <h4><a href="" class="stretched-link">Gift & Payment</a></h4>
                            <p>Terima hadiah digital melalui sistem pembayaran terintegrasi</p>
                        </div>
                    </div><!-- End Service Item -->
                </div>
            </div>
        </section><!-- /Featured Services Section -->

        <!-- Services Section -->
        <section id="services" class="services section light-background">

            <!-- Section Title -->
            <div class="container section-title">
                <span>QREW Features</span>
                <h2>Layanan</h2>
                <p>Fitur lengkap untuk mengelola acara Anda dengan lebih efisien dan profesional</p>
            </div><!-- End Section Title -->

            <div class="container">
                <div class="row gy-4">

                    <div class="col-lg-4 col-md-6">
                        <div class="service-item position-relative">
                            <div class="icon">
                                <i class="bi bi-envelope"></i>
                            </div>
                            <h3>Undangan Digital</h3>
                            <p>Buat undangan digital yang menarik dan personal. Kirim melalui WhatsApp atau bagikan link langsung.</p>
                        </div>
                    </div><!-- End Service Item -->

                    <div class="col-lg-4 col-md-6">
                        <div class="service-item position-relative">
                            <div class="icon">
                                <i class="bi bi-heart"></i>
                            </div>
                            <h3>Wishes & Messages</h3>
                            <p>Kumpulkan ucapan dan harapan dari tamu dalam satu tempat. Kenangan indah yang tersimpan digital.</p>
                        </div>
                    </div><!-- End Service Item -->

                    <div class="col-lg-4 col-md-6">
                        <div class="service-item position-relative">
                            <div class="icon">
                                <i class="bi bi-bar-chart"></i>
                            </div>
                            <h3>Analytics & Reports</h3>
                            <p>Dapatkan insight mendalam tentang acara Anda dengan laporan dan analitik yang komprehensif.</p>
                        </div>
                    </div><!-- End Service Item -->

                    <div class="col-lg-4 col-md-6">
                        <div class="service-item position-relative">
                            <div class="icon">
                                <i class="bi bi-phone"></i>
                            </div>
                            <h3>WhatsApp Integration</h3>
                            <p>Kirim undangan dan notifikasi langsung melalui WhatsApp untuk kemudahan komunikasi dengan tamu.</p>
                        </div>
                    </div><!-- End Service Item -->

                    <div class="col-lg-4 col-md-6">
                        <div class="service-item position-relative">
                            <div class="icon">
                                <i class="bi bi-shield-check"></i>
                            </div>
                            <h3>Keamanan Terjamin</h3>
                            <p>Sistem keamanan berlapis untuk melindungi data tamu dan informasi acara Anda.</p>
                        </div>
                    </div><!-- End Service Item -->

                    <div class="col-lg-4 col-md-6">
                        <div class="service-item position-relative">
                            <div class="icon">
                                <i class="bi bi-clock"></i>
                            </div>
                            <h3>Real-time Monitoring</h3>
                            <p>Pantau kehadiran tamu secara real-time dengan dashboard yang mudah dipahami.</p>
                        </div>
                    </div><!-- End Service Item -->

                </div>
            </div>

        </section><!-- /Services Section -->

        <!-- Call To Action Section -->
        <section id="call-to-action" class="call-to-action section">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-6 text-center">
                        <h3>Siap Membuat Acara yang Berkesan?</h3>
                        <p>Bergabunglah dengan ribuan pengguna yang telah mempercayai QREW untuk mengelola acara mereka. Mulai gratis hari ini!</p>
                        @auth
                            <a class="cta-btn" href="{{ url('/dashboard') }}">Ke Dashboard</a>
                        @else
                            <a class="cta-btn" href="{{ route('register') }}">Daftar Gratis</a>
                            <a class="cta-btn" href="{{ route('login') }}">Login</a>
                        @endauth
                    </div>
                </div>
            </div>
        </section><!-- /Call To Action Section -->

    </main>

    <!-- Footer -->
    <footer id="footer" class="footer">
        <div class="container">
            <div class="row gy-3">
                <div class="col-lg-3 col-md-6 d-flex">
                    <div>
                        <h4>QREW</h4>
                        <p>
                            Sistem Manajemen Tamu Digital yang Modern dan Efisien untuk Event Anda.
                            <br><br>
                            <strong>Email:</strong> info@qrew.id<br>
                        </p>
                    </div>
                </div>

                <div class="col-lg-2 col-md-3 footer-links">
                    <h4>Menu Utama</h4>
                    <ul>
                        <li><i class="bi bi-chevron-right"></i> <a href="#hero">Home</a></li>
                        <li><i class="bi bi-chevron-right"></i> <a href="#featured-services">Fitur</a></li>
                        <li><i class="bi bi-chevron-right"></i> <a href="#services">Layanan</a></li>
                        @auth
                            <li><i class="bi bi-chevron-right"></i> <a href="{{ url('/dashboard') }}">Dashboard</a></li>
                        @else
                            <li><i class="bi bi-chevron-right"></i> <a href="{{ route('register') }}">Daftar</a></li>
                        @endauth
                    </ul>
                </div>

                <div class="col-lg-2 col-md-3 footer-links">
                    <h4>Layanan Kami</h4>
                    <ul>
                        <li><i class="bi bi-chevron-right"></i> <a href="#">Guest Management</a></li>
                        <li><i class="bi bi-chevron-right"></i> <a href="#">QR Code System</a></li>
                        <li><i class="bi bi-chevron-right"></i> <a href="#">Digital Invitation</a></li>
                        <li><i class="bi bi-chevron-right"></i> <a href="#">Payment Gateway</a></li>
                    </ul>
                </div>

                <div class="col-lg-4 col-md-12">
                    <h4>Ikuti Kami</h4>
                    <p>Dapatkan update terbaru tentang fitur dan layanan QREW</p>
                    <div class="social-links d-flex">
                        <a href=""><i class="bi bi-twitter-x"></i></a>
                        <a href=""><i class="bi bi-facebook"></i></a>
                        <a href=""><i class="bi bi-instagram"></i></a>
                        <a href=""><i class="bi bi-linkedin"></i></a>
                    </div>
                </div>

            </div>
        </div>

        <div class="container copyright text-center mt-4">
            <p>© <span>Copyright</span> <strong class="px-1 sitename">QREW</strong> <span>All Rights Reserved</span></p>
            <div class="credits">
                Guest Management System - Powered by Laravel
            </div>
        </div>

    </footer>

    <!-- Vendor JS Files -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>