<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Kelurahan Citangkil - Website Resmi')</title>
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
        }

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
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: white;
            padding: 15px 40px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
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
            gap: 30px;
        }

        .nav-links li a {
            text-decoration: none;
            color: #555;
            font-size: 15px;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        /* Efek saat mouse diarahkan ke menu (Hover) */
        .nav-links li a:hover {
            color: #F89039;
        }

        /* Membuat icon lokasi sederhana dengan CSS/SVG */
        .icon-location svg {
            width: 24px;
            height: 24px;
            fill: white;
        }

        /* Responsif untuk layar kecil (HP) - Menyembunyikan menu */
        @media (max-width: 768px) {
            .nav-links {
                display: none;
            }
            .navbar {
                padding: 15px 20px;
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
    </style>
    @stack('styles')
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="brand-section">
            <div class="logo-circle">
                <div class="icon-location">
                    <svg viewBox="0 0 24 24">
                        <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5-1.12 2.5-2.5 2.5z"/>
                    </svg>
                </div>
            </div>
            <div class="brand-text">
                <span class="brand-title">Kelurahan Citangkil</span>
                <span class="brand-subtitle">Kec. Citangkil, Kota Cilegon</span>
            </div>
        </div>
        <ul class="nav-links">
            <li><a href="/">Beranda</a></li>
            <li><a href="/profil">Profil</a></li>
            <li><a href="/layanan">Layanan</a></li>
            <li><a href="/data">Data</a></li>
            <li><a href="/desa-cantik">Desa Cantik</a></li>
            <li><a href="">Berita dan Informasi</a></li>
        </ul>
    </nav>

    @yield('content')

    <!-- Footer -->
    @include('layouts.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
