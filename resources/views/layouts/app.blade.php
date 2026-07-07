<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'Kelurahan Gunung Sugih - Website Resmi')</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
        /* Reset dasar agar tampilan konsisten */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background-color: #ffffff;
            padding-top: 80px;
        }

        /* ============================================
           PRELOADER - Elegant Loading Screen
           ============================================ */
        .preloader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #F89039 0%, #e27e2e 50%, #F89039 100%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            transition: opacity 0.6s ease-out, visibility 0.6s ease-out;
        }

        .preloader.fade-out {
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
        }

        /* Logo Circle Animation */
        .preloader-logo {
            width: 100px;
            height: 100px;
            background: white;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            animation: pulse-logo 2s ease-in-out infinite;
            margin-bottom: 30px;
        }

        .preloader-logo i {
            color: #F89039;
            font-size: 42px;
        }

        @keyframes pulse-logo {
            0%, 100% {
                transform: scale(1);
                box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            }
            50% {
                transform: scale(1.1);
                box-shadow: 0 15px 50px rgba(0, 0, 0, 0.3);
            }
        }

        /* Title */
        .preloader-title {
            color: white;
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .preloader-subtitle {
            color: rgba(255, 255, 255, 0.9);
            font-size: 14px;
            margin-bottom: 35px;
            letter-spacing: 1px;
        }

        /* Loading Bar Container */
        .loading-bar-container {
            width: 200px;
            height: 4px;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 10px;
            overflow: hidden;
        }

        /* Loading Bar Progress */
        .loading-bar {
            height: 100%;
            width: 0%;
            background: white;
            border-radius: 10px;
            animation: load-progress 2s ease-in-out infinite;
        }

        @keyframes load-progress {
            0% {
                width: 0%;
                margin-left: 0;
            }
            50% {
                width: 70%;
                margin-left: 15%;
            }
            100% {
                width: 0%;
                margin-left: 100%;
            }
        }

        /* Loading Dots Animation */
        .loading-dots {
            display: flex;
            gap: 8px;
            margin-top: 25px;
        }

        .loading-dots span {
            width: 10px;
            height: 10px;
            background: white;
            border-radius: 50%;
            animation: dots-bounce 1.4s ease-in-out infinite;
        }

        .loading-dots span:nth-child(2) {
            animation-delay: 0.2s;
        }

        .loading-dots span:nth-child(3) {
            animation-delay: 0.4s;
        }

        @keyframes dots-bounce {
            0%, 80%, 100% {
                transform: scale(0.6);
                opacity: 0.5;
            }
            40% {
                transform: scale(1);
                opacity: 1;
            }
        }

        /* Hide Preloader when loaded */
        body.loaded .preloader {
            opacity: 0;
            visibility: hidden;
        }

        /* Responsive */
        @media (max-width: 600px) {
            .preloader-logo {
                width: 80px;
                height: 80px;
            }
            .preloader-logo i {
                font-size: 34px;
            }
            .preloader-title {
                font-size: 20px;
            }
            .preloader-subtitle {
                font-size: 12px;
            }
        }
        /* ============================================
           END PRELOADER
           ============================================ */

        /* --- Header Hijau --- */
        .hero-section {
            background-color: #F89039; /* Warna Oranye */
            color: white;
            text-align: center;
            position: relative;
            padding-top: 90px;
            /* Padding bawah besar agar gelombang tidak menutupi teks */
            padding-bottom: 180px; 
        }

        /* --- Ikon Lingkaran --- */
        .icon-circle {
            background: white;
            width: 85px;
            height: 85px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 25px auto;
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        }
        .icon-circle i {
            color: #F89039;
            font-size: 34px;
        }

        /* --- Teks --- */
        .hero-section h1 {
            font-size: 2.5rem;
            font-weight: 400;
            margin-bottom: 25px;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .description {
            font-size: 1.1rem;
            font-weight: 300;
            line-height: 1.6;
            margin-bottom: 40px;
            opacity: 0.95;
        }
        .description span { display: block; }

        /* --- Kontak --- */
        .contacts {
            display: flex;
            justify-content: center;
            gap: 30px;
            font-weight: 300;
            font-size: 1rem;
        }
        .contacts div {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* --- PENTING: Pengaturan Gelombang S (1 Bawah, 1 Atas) --- */
        .wave-container {
            position: absolute;
            bottom: -1px; /* Tutup celah pixel */
            left: 0;
            width: 100%;
            overflow: hidden;
            line-height: 0;
        }

        .wave-container svg {
            position: relative;
            display: block;
            width: calc(100% + 1.3px);
            height: 150px; /* Tinggi SVG lebih besar agar lengkungan terlihat jelas */
        }

        .wave-fill {
            fill: #ffffff; /* Warna putih (background bawah) */
        }

        /* Responsif HP */
        @media (max-width: 600px) {
            .hero-section h1 { font-size: 1.8rem; padding: 0 10px; }
            .contacts { flex-direction: column; gap: 15px; }
            .hero-section { padding-bottom: 140px; }
            .wave-container svg { height: 100px; }
        }

        /* Container utama Navbar */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: white;
            padding: 15px 40px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            z-index: 1000;
        }

        /* Bagian Kiri: Logo dan Teks */
        .brand-section {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .logo-circle {
            width: 45px;
            height: 45px;
            background-color: #F89039;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            font-size: 24px;
        }

        .brand-text {
            display: flex;
            flex-direction: column;
        }

        .brand-title {
            color: #F89039;
            font-weight: 600;
            font-size: 18px;
            line-height: 1.2;
        }

        .brand-subtitle {
            color: #888;
            font-size: 12px;
            margin-top: 2px;
        }

        /* Bagian Kanan: Menu Link */
        .nav-links {
            list-style: none;
            display: flex;
            align-items: center;
            gap: 22px;
            margin: 0;
            padding: 0;
        }

        .nav-links li a,
        .nav-links li button {
            text-decoration: none;
            color: #555;
            font-size: 15px;
            font-weight: 500;
            transition: color 0.3s ease, background-color 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        /* Efek saat mouse diarahkan ke menu (Hover) */
        .nav-links li a:hover,
        .nav-links li button:hover {
            color: #F89039;
        }

        .admin-menu-toggle {
            border: 1px solid rgba(248, 144, 57, 0.22);
            background: #fff7f0;
            border-radius: 999px;
            padding: 8px 12px;
            color: #F89039 !important;
        }

        .admin-menu-toggle i:first-child {
            font-size: 17px;
        }

        .admin-menu .dropdown-menu {
            right: 0;
            left: auto;
            min-width: 175px;
        }

        .admin-menu .logout-button {
            width: 100%;
            border: none;
            background: transparent;
            padding: 10px 20px;
            text-align: left;
            cursor: pointer;
        }

        .login-icon-link i {
            font-size: 18px;
            line-height: 1;
        }

        /* Membuat icon lokasi sederhana dengan CSS/SVG */
        .icon-location svg {
            width: 24px;
            height: 24px;
            fill: white;
        }

/* Responsif untuk layar kecil (HP) - Menyembunyikan menu dan menambahkan hamburger */
        @media (max-width: 1024px) {
            .nav-links {
                display: none;
                position: absolute;
                top: 70px;
                left: 0;
                right: 0;
                background: white;
                flex-direction: column;
                padding: 15px 20px;
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
                gap: 0;
            }
            
            .nav-links.active {
                display: flex;
            }
            
            .nav-links li {
                width: 100%;
                border-bottom: 1px solid #f0f0f0;
            }
            
            .nav-links li:last-child {
                border-bottom: none;
            }
            
            .nav-links li a,
            .nav-links li button {
                display: flex;
                padding: 12px 0;
                width: 100%;
            }

            .admin-menu-toggle {
                border: none;
                background: transparent;
                border-radius: 0;
                padding: 12px 0;
                color: #555 !important;
            }
            
            /* Dropdown untuk mobile */
            .nav-links li.dropdown .dropdown-menu {
                position: static;
                box-shadow: none;
                padding-left: 15px;
                display: none;
            }
            
            .nav-links li.dropdown .dropdown-menu.show {
                display: block;
            }
            
            .nav-links li.dropdown .dropdown-toggle::after {
                float: right;
            }
            
            .navbar {
                padding: 15px 20px;
                flex-wrap: wrap;
            }
            
            /* Hamburger Button */
            .hamburger {
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                width: 40px;
                height: 40px;
                background: none;
                border: none;
                cursor: pointer;
                padding: 5px;
                z-index: 1001;
            }
            
            .hamburger span {
                display: block;
                width: 25px;
                height: 3px;
                background-color: #555;
                margin: 2px 0;
                transition: all 0.3s ease;
                border-radius: 2px;
            }
            
            .hamburger.active span:nth-child(1) {
                transform: rotate(45deg) translate(5px, 6px);
            }
            
            .hamburger.active span:nth-child(2) {
                opacity: 0;
            }
            
            .hamburger.active span:nth-child(3) {
                transform: rotate(-45deg) translate(5px, -6px);
            }
            
            .navbar .brand-section {
                flex: 1;
            }
            
            .navbar .hamburger-wrapper {
                display: flex;
            }
        }
        
        @media (min-width: 1025px) {
            .hamburger-wrapper {
                display: none;
            }
        }

        /* About */
        .about {
            padding: 80px 0;
        }

        /* Features */
        .features {
            padding: 80px 0;
            background-color: #f8f9fa;
        }
        
        .feature-icon {
            font-size: 2.5rem;
            color: #F89039;
            margin-bottom: 20px;
        }
        
        .feature-card {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            transition: transform 0.3s ease;
            height: 100%;
        }
        
        .feature-card:hover {
            transform: translateY(-10px);
        }
        
        /* About */
        .about {
            padding: 80px 0;
        }
        
        /* Services */
        .services {
            padding: 80px 0;
            background-color: #f8f9fa;
        }
        
        .service-card {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            height: 100%;
            transition: all 0.3s ease;
        }
        
        .service-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        
        .service-icon {
            font-size: 3rem;
            color: #F89039;
            margin-bottom: 20px;
        }
        
        /* Contact */
        .contact {
            padding: 80px 0;
        }
        
        .contact-info {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }
        
        /* Footer */
        .footer {
            background-color: #343a40;
            color: white;
            padding: 50px 0 20px;
        }
        
        .footer-links h5 {
            color: #F89039;
            margin-bottom: 20px;
            font-weight: 600;
        }
        
        .footer-links ul {
            list-style: none;
            padding: 0;
        }
        
        .footer-links ul li {
            margin-bottom: 10px;
        }
        
        .footer-links ul li a {
            color: #ccc;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        .footer-links ul li a:hover {
            color: #F89039;
        }
        
        .social-icons a {
            display: inline-block;
            width: 40px;
            height: 40px;
            background: rgba(255,255,255,0.1);
            color: white;
            text-align: center;
            line-height: 40px;
            border-radius: 50%;
            margin-right: 10px;
            transition: all 0.3s ease;
        }
        
        .social-icons a:hover {
            background: #F89039;
            transform: translateY(-3px);
        }

        .back-to-top-wrapper {
            display: flex;
            justify-content: flex-end;
            padding: 24px;
            position: relative;
            z-index: 20;
            background: #ffffff;
        }

        #backToTopBtn {
            width: 46px;
            height: 46px;
            border: none;
            border-radius: 50%;
            background-color: #F89039;
            color: #fff;
            box-shadow: 0 8px 18px rgba(0, 0, 0, 0.18);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.25s ease;
            position: relative;
            z-index: 21;
        }

        #backToTopBtn:hover {
            background-color: #e27e2e;
            transform: translateY(-2px);
        }

#backToTopBtn i {
            font-size: 1.2rem;
            line-height: 1;
        }
        
        /* Dropdown Menu Styles */
        .nav-links li.dropdown {
            position: relative;
        }
        
        .nav-links li.dropdown .dropdown-toggle::after {
            content: '';
            border: none;
            font-size: 10px;
        }
        
        .nav-links .dropdown-menu {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            background: white;
            min-width: 200px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            padding: 10px 0;
            list-style: none;
            z-index: 1001;
        }
        
        .nav-links .dropdown-menu li {
            padding: 0;
        }
        
        .nav-links .dropdown-menu li a {
            display: block;
            padding: 10px 20px;
            color: #555;
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 14px;
        }
        
        .nav-links .dropdown-menu li a:hover {
            background: #f8f9fa;
            color: #F89039;
        }
        
        .nav-links li.dropdown:hover .dropdown-menu {
            display: block;
        }
        
        .nav-links li.dropdown:hover .dropdown-toggle {
            color: #F89039;
        }
    </style>
    @stack('styles')
</head>
<body>
<!-- Preloader - Elegant Loading Screen -->
    <div class="preloader">
        <div class="preloader-logo">
            <img src="{{ asset('favicon.ico') }}" alt="Logo" style="width: 60px; height: 60px; object-fit: contain;">
        </div>
        <h1 class="preloader-title">Kelurahan Gunung Sugih</h1>
        <p class="preloader-subtitle">Kec. Ciwandan, Kota Cilegon</p>
        
        <div class="loading-bar-container">
            <div class="loading-bar"></div>
        </div>
        
        <div class="loading-dots">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>

    <!-- Navbar -->
    <nav class="navbar">
        <div class="brand-section">
            @php
                $beranda = App\Models\Beranda::first();
            @endphp
            @if($beranda && $beranda->logo)
                <div style="width: 45px; height: 45px; border-radius: 50%; overflow: hidden; border: 2px solid #F89039;">
                    <img src="{{ asset('storage/' . $beranda->logo) }}" alt="{{ $beranda->nama_kelurahan ?? 'Logo Kelurahan' }}" 
                         style="width: 100%; height: 100%; object-fit: cover;">
                </div>
            @else
                <div class="logo-circle">
                    <div class="icon-location">
                        <svg viewBox="0 0 24 24">
                            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5-1.12 2.5-2.5 2.5z"/>
                        </svg>
                    </div>
                </div>
            @endif
            <div class="brand-text">
                <span class="brand-title">{{ $currentVillage['official_name'] ?? 'Kelurahan Gunung Sugih' }}</span>
                <span class="brand-subtitle">Kecamatan {{ $currentVillage['district'] ?? 'Ciwandan' }}</span>
            </div>
        </div>
<ul class="nav-links">
            <li><a href="{{ ($currentVillageSlug ?? config('villages.default')) === config('villages.default') ? '/' : '/' . ($currentVillageSlug ?? '') }}">Beranda</a></li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle">Website Kelurahan <i class="fas fa-chevron-down"></i></a>
                <ul class="dropdown-menu">
                    @foreach(($villages ?? []) as $slug => $village)
                        <li><a href="{{ $slug === config('villages.default') ? '/' : '/' . $slug }}" data-village-switcher-option>{{ $village['official_name'] }}</a></li>
                    @endforeach
                </ul>
            </li>
<li class="dropdown">
                <a href="#" class="dropdown-toggle">Tentang Kami <i class="fas fa-chevron-down"></i></a>
                <ul class="dropdown-menu">
                    <li><a href="/profil-kelurahan">Profil</a></li>
                    <li><a href="/maklumat-pelayananan">Maklumat Pelayanan</a></li>
                </ul>
            </li>
            <li><a href="/layanan">Layanan</a></li>
            <li><a href="/data">Data</a></li>
            <li><a href="/desa-cantik">Desa Cantik</a></li>
            <li><a href="/berita">Berita dan Informasi</a></li>

            @guest
                <li>
                    <a href="/login" class="login-icon-link" aria-label="Login" title="Login">
                        <i class="bi bi-box-arrow-in-right"></i>
                    </a>
                </li>
            @endguest

            @auth
                <li class="dropdown admin-menu">
                    <a href="#" class="dropdown-toggle admin-menu-toggle" aria-label="Menu admin">
                        <i class="bi bi-person-circle"></i>
                        <span>Admin</span>
                        <i class="fas fa-chevron-down"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            @php
                                $authUser = auth()->user();
                                $adminDashboardUrl = '/admin/dashboard';

                                if ($authUser?->role === 'admin' && $authUser->village?->slug) {
                                    $adminDashboardUrl = '/admin/' . $authUser->village->slug . '/dashboard';
                                }
                            @endphp
                            <a href="{{ $adminDashboardUrl }}">
                                <i class="bi bi-speedometer2"></i> Dashboard
                            </a>
                        </li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <input type="hidden" name="village" value="{{ $currentVillageSlug ?? config('villages.default') }}">
                                <button type="submit" class="logout-button">
                                    <i class="bi bi-box-arrow-right"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
            @endauth
        </ul>
        
        <!-- Hamburger Button for Mobile -->
        <div class="hamburger-wrapper">
            <button class="hamburger" aria-label="Toggle menu">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </nav>

    @yield('content')

    <div class="back-to-top-wrapper">
        <button id="backToTopBtn" aria-label="Kembali ke atas" title="Kembali ke atas">
            <i class="bi bi-arrow-up"></i>
        </button>
    </div>

    <!-- Footer -->
    @include('layouts.footer')

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Preloader functionality - Hide when page is loaded
        window.addEventListener('load', function() {
            document.body.classList.add('loaded');
            // Remove preloader from DOM after animation completes
            setTimeout(function() {
                var preloader = document.querySelector('.preloader');
                if (preloader) {
                    preloader.style.display = 'none';
                }
            }, 600); // Match with CSS transition duration
        });

// Fallback: Hide preloader after 7 seconds anyway
        setTimeout(function() {
            document.body.classList.add('loaded');
            var preloader = document.querySelector('.preloader');
            if (preloader) {
                preloader.style.display = 'none';
            }
        }, 7000);

const backToTopBtn = document.getElementById('backToTopBtn');
        if (backToTopBtn) {
            backToTopBtn.addEventListener('click', function () {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });
        }
        
        // Mobile Menu Toggle
        const hamburger = document.querySelector('.hamburger');
        const navLinks = document.querySelector('.nav-links');
        
        if (hamburger && navLinks) {
            hamburger.addEventListener('click', function() {
                hamburger.classList.toggle('active');
                navLinks.classList.toggle('active');
            });
        }
        
        // Mobile Dropdown Toggle
        const dropdownToggles = document.querySelectorAll('.dropdown-toggle');
        dropdownToggles.forEach(function(dropdownToggle) {
            dropdownToggle.addEventListener('click', function(e) {
                if (window.innerWidth <= 1024) {
                    e.preventDefault();
                    const dropdownMenu = this.nextElementSibling;
                    if (dropdownMenu) {
                        dropdownMenu.classList.toggle('show');
                    }
                }
            });
        });
        
        // Close mobile menu when clicking outside
        document.addEventListener('click', function(e) {
            if (navLinks && hamburger) {
                if (!navLinks.contains(e.target) && !hamburger.contains(e.target)) {
                    navLinks.classList.remove('active');
                    hamburger.classList.remove('active');
                }
            }
        });
        
        // Close mobile menu when window is resized to desktop
        window.addEventListener('resize', function() {
            if (window.innerWidth > 1024 && navLinks) {
                navLinks.classList.remove('active');
                if (hamburger) {
                    hamburger.classList.remove('active');
                }
            }
        });
    </script>
    @stack('scripts')
</body>
</html>

