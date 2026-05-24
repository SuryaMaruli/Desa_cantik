@extends('layouts.app')

@section('title', 'Beranda - Kelurahan Citangkil')

@section('content')
    <style>
        /* --- RESET & GLOBAL --- */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Roboto', sans-serif; background-color: #ffffff; color: #333; overflow-x: hidden; }
        a { text-decoration: none; }

        /* --- HERO SECTION --- */
        .hero-section {
            background-color: #F89039;
            color: #ffffff;
            text-align: center;
            position: relative;
            overflow: hidden;
            padding-top: 60px;
            padding-bottom: 220px;
        }
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: url('{{ $beranda?->gambar_header ? asset("storage/".$beranda->gambar_header) : "https://images.unsplash.com/photo-1486312338219-ce68d2C6f44d?ixlib=rb-1.2.1&auto=format&fit=crop&w=1200&q=80" }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            opacity: 0.3;
            z-index: 1;
        }
        .hero-content {
            position: relative;
            z-index: 2;
        }
        .logo-container {
            margin-bottom: 30px;
            position: relative;
            z-index: 3;
        }
        .logo-container img {
            max-width: 120px;
            max-height: 120px;
            border-radius: 50%;
            background: white;
            padding: 8px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.25);
            border: 3px solid white;
            position: relative;
            z-index: 3;
        }
        .icon-circle {
            background: #ffffff; width: 85px; height: 85px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 30px auto; box-shadow: 0 4px 10px rgba(0,0,0,0.15);
        }
        .icon-circle i { color: #F89039; font-size: 36px; }
        .hero-section h1 { font-size: 2.8rem; font-weight: 400; margin-bottom: 25px; text-transform: uppercase; }
        .description { font-size: 1.1rem; font-weight: 300; line-height: 1.8; margin-bottom: 40px; }
        .description span { display: block; }
        .contacts { display: flex; justify-content: center; gap: 40px; font-weight: 300; }
        .contacts div { display: flex; align-items: center; gap: 10px; }
        
        .wave-container { position: absolute; bottom: -1px; left: 0; width: 100%; overflow: hidden; line-height: 0; z-index: 4; }
        .wave-container svg { position: relative; display: block; width: calc(100% + 1.3px); height: 160px; }
        .wave-fill { fill: #ffffff; }

        /* --- FITUR UTAMA (CREAM & ORANGE) --- */
        .features-section { 
            padding: 0 20px 80px 20px; 
            max-width: 1200px; 
            margin: 0 auto; 
            margin-top: -20px; 
            position: relative; 
            z-index: 5;
        }
        .section-header { text-align: center; margin-bottom: 50px; }
        .section-header h2 { color: #e65100; font-size: 2rem; font-weight: 500; margin-bottom: 10px; text-transform: uppercase; letter-spacing: 1px; }
        .section-header .underline { width: 70px; height: 4px; background-color: #e65100; margin: 0 auto; border-radius: 2px; }
        
        .cards-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px; }
        
        .card { 
            border-radius: 20px; 
            padding: 35px 30px; 
            display: flex; flex-direction: column; 
            transition: 0.3s; 
            box-shadow: 0 5px 20px rgba(0,0,0,0.05); 
            border: 1px solid rgba(0,0,0,0.02); 
            background: #fffbf0;
        }
        .card:hover { transform: translateY(-8px); box-shadow: 0 15px 35px rgba(230, 81, 0, 0.15); }
        
        .icon-box { 
            width: 60px; height: 60px; border-radius: 12px; 
            display: flex; align-items: center; justify-content: center; 
            margin-bottom: 25px; font-size: 26px;
            background: #fff; 
            color: #e65100; 
            border: 2px solid #ffe0b2;
        }
        .card h3 { font-size: 1.2rem; margin-bottom: 15px; font-weight: 500; color: #333; }
        .card p { font-size: 0.95rem; color: #666; line-height: 1.6; margin-bottom: 30px; flex-grow: 1; }
        
        .card-btn { 
            text-decoration: none; padding: 12px 0; border-radius: 8px; color: white; font-weight: 500; 
            display: flex; align-items: center; justify-content: center; gap: 10px; width: 100%; transition: 0.3s;
            background: linear-gradient(90deg, #e65100, #d50000);
            box-shadow: 0 4px 10px rgba(213, 0, 0, 0.2);
        }
        .card-btn:hover { opacity: 0.9; box-shadow: 0 6px 15px rgba(213, 0, 0, 0.3); }

        /* --- SAMBUTAN LURAH (MERAH-ORANYE) --- */
        .lurah-section { 
            padding: 80px 20px 100px 20px; 
            background-color: #fffbf0; 
            margin-top: 0; 
        }
        .lurah-card { 
            max-width: 1100px; 
            margin: 0 auto; 
            background: #ffffff; 
            border-radius: 24px; 
            display: flex; 
            box-shadow: 0 15px 50px rgba(0,0,0,0.08); 
            overflow: hidden; 
            min-height: 500px;
        }
        
        .lurah-left { 
            flex: 4; 
            background: linear-gradient(160deg, #ff5722 0%, #d50000 100%);
            padding: 40px; 
            display: flex; flex-direction: column; align-items: center; justify-content: center; 
            position: relative;
        }
        
        .photo-frame { 
            background: #fff; border-radius: 12px; padding: 10px;
            width: 100%; max-width: 280px; height: 320px; 
            margin-bottom: 20px; box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        }
        .photo-frame img { width: 100%; height: 100%; object-fit: cover; border-radius: 8px; background-color: #eee; }

        .name-container {
            width: 100%; max-width: 280px;
            background: rgba(80, 0, 0, 0.3);
            border-radius: 12px; padding: 15px; text-align: center; color: #fff;
            border: 1px solid rgba(255,255,255,0.2);
        }
        .name-container span { display: block; font-size: 0.85rem; opacity: 0.9; margin-bottom: 5px; }
        .name-container h3 { font-size: 1.1rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; }

        .lurah-right { flex: 6; padding: 60px; display: flex; flex-direction: column; justify-content: center; }
        .quote-icon { 
            font-size: 45px; color: transparent; 
            -webkit-text-stroke: 2px #ff6d00; 
            margin-bottom: 25px; display: inline-block;
        }
        
        .lurah-right p { margin-bottom: 20px; line-height: 1.8; color: #555; font-size: 1.05rem; }
        
        .btn-sambutan { 
            background: linear-gradient(90deg, #ff6d00, #f57c00);
            color: white; padding: 14px 35px; border-radius: 8px; text-decoration: none; 
            font-weight: 500; width: fit-content; margin-top: 15px; transition: 0.3s; 
            box-shadow: 0 4px 15px rgba(245, 124, 0, 0.3);
        }
        .btn-sambutan:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(245, 124, 0, 0.4); }

        /* --- INFO PUBLIK (DESAIN BARU SESUAI GAMBAR) --- */
        .info-section { padding: 80px 20px 100px 20px; background-color: #ffffff; }
        .info-header { text-align: center; margin-bottom: 60px; }
        .info-header h2 { color: #333; font-size: 2rem; font-weight: 600; margin-bottom: 10px; text-transform: uppercase; }
        
        .info-grid { max-width: 1200px; margin: 0 auto; display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 30px; }
        
        .info-card { 
            background: #fff; 
            border: 1px solid #f0f0f0; /* Border sangat halus */
            border-radius: 16px; 
            padding: 35px 30px; 
            box-shadow: 0 4px 20px rgba(0,0,0,0.03); 
            display: flex; flex-direction: column; 
            align-items: flex-start; /* Rata Kiri */
            transition: 0.3s; 
        }
        .info-card:hover { transform: translateY(-5px); box-shadow: 0 15px 30px rgba(0,0,0,0.08); border-color: #eee; }
        
        /* Icon Box Oranye */
        .info-icon { 
            width: 60px; height: 60px; 
            background: linear-gradient(135deg, #ff6d00, #ff3d00); /* Gradasi Oranye */
            color: white; 
            border-radius: 16px; 
            display: flex; align-items: center; justify-content: center; 
            font-size: 28px; 
            font-weight: bold;
            margin-bottom: 25px; 
        }
        
        .info-card h4 { font-size: 1.15rem; color: #222; margin-bottom: 15px; font-weight: 600; line-height: 1.4; }
        .info-card p { font-size: 0.95rem; color: #666; line-height: 1.6; margin-bottom: 30px; flex-grow: 1; }
        
        /* Link Oranye */
        .info-link { 
            color: #ff3d00; 
            text-decoration: none; 
            font-weight: 500; 
            font-size: 0.95rem; 
            display: inline-flex; align-items: center; gap: 8px; 
            transition: 0.3s; 
        }
        .info-link:hover { gap: 12px; color: #d50000; }

        /* --- PRESTASI --- */
        .prestasi-section { padding: 60px 20px 78px; background: #fffbf0; }
        .prestasi-header { text-align: center; margin-bottom: 34px; }
        .prestasi-header h2 { color: #e65100; font-size: 2rem; font-weight: 600; margin-bottom: 10px; text-transform: uppercase; }
        .prestasi-header p { color: #666; font-size: 1rem; margin: 0; }
        .prestasi-grid { max-width: 960px; margin: 0 auto; display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 16px; }
        .prestasi-card {
            background: #ffffff;
            border: 1px solid #f3e4d5;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 6px 18px rgba(230, 81, 0, 0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            display: flex;
            flex-direction: column;
            min-height: 100%;
        }
        .prestasi-card:hover { transform: translateY(-4px); box-shadow: 0 12px 28px rgba(230, 81, 0, 0.13); }
        .prestasi-carousel-wrap {
            background: #fff;
            overflow: hidden;
            cursor: zoom-in;
            border-bottom: 1px solid #f5e7d6;
        }
        .prestasi-carousel {
            position: relative;
            width: 100%;
            aspect-ratio: 16 / 9;
            overflow: hidden;
            background: #f3f4f6;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .prestasi-carousel::after {
            content: "";
            position: absolute;
            inset: auto 0 0 0;
            height: 45%;
            background: linear-gradient(180deg, rgba(15, 23, 42, 0) 0%, rgba(15, 23, 42, 0.48) 100%);
            pointer-events: none;
            z-index: 2;
        }
        .prestasi-carousel-track { position: absolute; inset: 0; }
        .prestasi-carousel-slide {
            position: absolute;
            inset: 0;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.25s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #f57c00;
            font-size: 38px;
            background: linear-gradient(135deg, #fff4e8, #ffe1c4);
        }
        .prestasi-carousel-slide.active { opacity: 1; pointer-events: auto; }
        .prestasi-carousel-slide img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            transition: transform 0.35s ease;
        }
        .prestasi-carousel-wrap:hover .prestasi-carousel-slide.active img { transform: scale(1.035); }
        .prestasi-badge {
            position: absolute;
            left: 10px;
            top: 10px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 9px;
            border-radius: 999px;
            background: rgba(15, 23, 42, 0.72);
            color: white;
            font-size: 0.7rem;
            font-weight: 700;
            z-index: 6;
            backdrop-filter: blur(8px);
        }
        .prestasi-photo-count {
            position: absolute;
            right: 10px;
            top: 10px;
            z-index: 6;
            padding: 5px 9px;
            border-radius: 999px;
            background: rgba(15, 23, 42, 0.72);
            color: white;
            font-size: 0.7rem;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            backdrop-filter: blur(8px);
        }
        .prestasi-carousel-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 30px;
            height: 30px;
            border: none;
            border-radius: 50%;
            background: rgba(15, 23, 42, 0.62);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 6;
            cursor: pointer;
            transition: background 0.2s ease, transform 0.2s ease;
        }
        .prestasi-carousel-btn:hover { background: rgba(15, 23, 42, 0.86); transform: translateY(-50%) scale(1.04); }
        .prestasi-carousel-btn.prev { left: 10px; }
        .prestasi-carousel-btn.next { right: 10px; }
        .prestasi-carousel-dots {
            position: absolute;
            left: 0;
            right: 0;
            bottom: 10px;
            z-index: 5;
            display: flex;
            justify-content: center;
            gap: 6px;
        }
        .prestasi-carousel-dot {
            width: 7px;
            height: 7px;
            border: 0;
            border-radius: 50%;
            padding: 0;
            background: rgba(255, 255, 255, 0.62);
            box-shadow: 0 1px 4px rgba(15, 23, 42, 0.2);
            cursor: pointer;
            transition: width 0.2s ease, background 0.2s ease;
        }
        .prestasi-carousel-dot.active {
            width: 18px;
            border-radius: 999px;
            background: #fff;
        }
        .prestasi-expand-btn {
            position: absolute;
            right: 10px;
            bottom: 10px;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: rgba(15, 23, 42, 0.72);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            z-index: 6;
            pointer-events: none;
        }
        .prestasi-carousel-thumbs {
            display: flex;
            gap: 5px;
            overflow-x: auto;
            padding: 8px 10px 9px;
            background: #fff;
            scrollbar-width: thin;
        }
        .prestasi-carousel-thumb {
            width: 42px;
            height: 32px;
            flex-shrink: 0;
            display: block;
            border-radius: 5px;
            object-fit: cover;
            border: 2px solid transparent;
            cursor: pointer;
            opacity: 0.66;
            transition: opacity 0.2s ease, border-color 0.2s ease, transform 0.2s ease;
        }
        .prestasi-carousel-thumb:hover { opacity: 0.9; }
        .prestasi-carousel-thumb.active {
            border-color: #f97316;
            opacity: 1;
            transform: translateY(-1px);
        }
        .prestasi-content { padding: 14px 15px 16px; display: flex; flex-direction: column; flex: 1; }
        .prestasi-meta { display: flex; flex-wrap: wrap; gap: 6px; margin-bottom: 10px; }
        .prestasi-meta span {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 8px;
            border-radius: 999px;
            background: #fff4e8;
            color: #b45309;
            font-size: 0.7rem;
            font-weight: 600;
        }
        .prestasi-card h3 { font-size: 0.98rem; color: #222; line-height: 1.35; margin-bottom: 8px; font-weight: 700; }
        .prestasi-card p {
            color: #666;
            font-size: 0.82rem;
            line-height: 1.55;
            margin-bottom: 0;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .prestasi-viewer-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.82);
            z-index: 10001;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 72px 24px 28px;
        }
        .prestasi-viewer-overlay.active { display: flex; }
        .prestasi-viewer-stage {
            width: 100%;
            height: 100%;
            overflow: auto;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .prestasi-viewer-stage img {
            max-width: 90vw;
            max-height: 82vh;
            object-fit: contain;
            border-radius: 10px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.35);
            transition: transform 0.2s ease;
            transform-origin: center center;
        }
        .prestasi-viewer-toolbar {
            position: absolute;
            top: 18px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px;
            border-radius: 12px;
            background: rgba(255,255,255,0.12);
            backdrop-filter: blur(10px);
            z-index: 3;
        }
        .prestasi-viewer-btn {
            width: 38px;
            height: 38px;
            border: none;
            border-radius: 8px;
            background: rgba(255,255,255,0.92);
            color: #1f2937;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: 0.2s;
        }
        .prestasi-viewer-btn:hover { background: #fff3e0; color: #e65100; }
        .prestasi-viewer-zoom {
            min-width: 58px;
            color: white;
            font-size: 13px;
            font-weight: 600;
            text-align: center;
        }
        .prestasi-viewer-nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 46px;
            height: 46px;
            border: none;
            border-radius: 50%;
            background: rgba(255,255,255,0.92);
            color: #1f2937;
            cursor: pointer;
            display: none;
            align-items: center;
            justify-content: center;
            box-shadow: 0 12px 30px rgba(0,0,0,0.25);
            transition: 0.2s;
            z-index: 2;
        }
        .prestasi-viewer-nav:hover { background: #fff3e0; color: #e65100; }
        .prestasi-viewer-nav.prev { left: 28px; }
        .prestasi-viewer-nav.next { right: 28px; }
        .prestasi-viewer-overlay.has-multiple .prestasi-viewer-nav { display: flex; }
        .prestasi-empty {
            max-width: 620px;
            margin: 0 auto;
            padding: 34px;
            border-radius: 18px;
            background: #ffffff;
            text-align: center;
            color: #666;
            border: 1px dashed #f0c7a3;
        }
        .prestasi-empty i { color: #F89039; font-size: 42px; margin-bottom: 14px; }

        /* --- RESPONSIVE --- */
        @media (max-width: 900px) {
            .lurah-card { flex-direction: column; }
            .lurah-left { padding: 40px 20px; }
            .lurah-right { padding: 40px 25px; }
            .contacts { flex-direction: column; gap: 15px; }
            .hero-section h1 { font-size: 1.8rem; }
            .info-card { padding: 25px; }
            .prestasi-section { padding: 60px 15px; }
            .prestasi-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); max-width: 640px; }
        }

        @media (max-width: 575px) {
            .prestasi-grid { grid-template-columns: 1fr; max-width: 340px; }
        }
    </style>

    <div class="hero-section">
        <div class="hero-content">
            @if($beranda && $beranda->logo)
                <div class="logo-container">
                    <img src="{{ asset('storage/' . $beranda->logo) }}" alt="{{ $beranda->nama_kelurahan ?? 'Logo Kelurahan' }}">
                </div>
            @endif
            <h1>{{ $beranda->nama_kelurahan ?? 'Kelurahan Citangkil' }}</h1>
            <div class="description">
                <span>{{ $beranda->deskripsi ?? 'Dapori Pembuasan Desa Cantik oleh RPS Kota Cilegon' }}</span>
            </div>
            <div class="contacts">
                <div><i class="fas fa-phone-alt"></i> {{ $beranda->no_hp ?? '(0254) 123-4567' }}</div>
                <div><i class="far fa-envelope"></i> {{ $beranda->email ?? 'kelurahan@citangkil.go.id' }}</div>
            </div>
        </div>
        <div class="wave-container">
            <svg viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path d="M0,60 C400,160 800,-40 1200,60 L1200,120 L0,120 Z" class="wave-fill"></path>
            </svg>
        </div>
    </div>

    <section class="features-section">
        <div class="section-header">
            <h2>FITUR UTAMA</h2>
            <div class="underline"></div>
        </div>
        <div class="cards-grid">
            <div class="card">
                <div class="icon-box"><i class="far fa-check-circle"></i></div>
                <h3>Profil Kelurahan</h3>
                <p>Informasi lengkap tentang sejarah, visi misi, dan struktur organisasi Kelurahan Citangkil.</p>
                <a href="/profil-kelurahan" class="card-btn">Selengkapnya <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="card">
                <div class="icon-box"><i class="fas fa-bullseye"></i></div>
                <h3>Layanan Masyarakat</h3>
                <p>Berbagai layanan administrasi dan pelayanan publik untuk kemudahan masyarakat.</p>
                <a href="/layanan" class="card-btn">Selengkapnya <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="card">
                <div class="icon-box"><i class="far fa-chart-bar"></i></div>
                <h3>Data</h3>
                <p>Data statistik dan informasi kependudukan Kelurahan Citangkil yang transparan.</p>
                <a href="/data" class="card-btn">Akses Data <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="card">
                <div class="icon-box"><i class="fas fa-home"></i></div>
                <h3>Desa Cantik</h3>
                <p>Program pembangunan dan pengembangan desa untuk meningkatkan kualitas lingkungan.</p>
                <a href="/desa-cantik" class="card-btn">Lihat Galeri <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="card">
                <div class="icon-box"><i class="far fa-newspaper"></i></div>
                <h3>Berita & Informasi</h3>
                <p>Update terkini seputar kegiatan, pengumuman, dan berita dari Kelurahan Citangkil.</p>
                <a href="/berita" class="card-btn">Baca Berita <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
    </section>

    <section class="lurah-section">
        <div class="section-header">
            <h2 style="color: #e65100;">LURAH CITANGKIL</h2>
            <div class="underline" style="background-color: #e65100;"></div>
        </div>
        <div class="lurah-card">
            <div class="lurah-left">
                <div class="photo-frame">
                    @if($dataLurah && $dataLurah->foto_lurah)
                        <img src="{{ asset('storage/foto-lurah/' . $dataLurah->foto_lurah) }}" alt="Foto Lurah">
                    @else
                        <img src="https://via.placeholder.com/300x400/eeeeee/333333?text=FOTO+LURAH" alt="Foto Lurah">
                    @endif
                </div>
                <div class="name-container">
                    <span>{{ $dataLurah->jabatan ?? 'Lurah Citangkil' }}</span>
                    <h3>{{ $dataLurah->nama_lurah ?? 'M. ALI WAHIDI, S.Sos.M.Si' }}</h3>
                </div>
            </div>
            <div class="lurah-right">
                <i class="fas fa-quote-left quote-icon"></i>
                @if($dataLurah && $dataLurah->sambutan_lurah)
                    <p>"{{ $dataLurah->sambutan_lurah }}"</p>
                @else
                    <p>"Situs web ini kami hadirkan sebagai wadah untuk mempublikasi atau informasi kepada masyarakat..."</p>
                    <p>"Kami berkomitmen untuk terus memberikan layanan terbaik, transparan, dan akuntabilitas..."</p>
                @endif
                <a href="{{ route('kata-sambutan') }}" class="btn-sambutan">Baca Sambutan Lengkap</a>
            </div>
        </div>
    </section>

    <section class="info-section">
        <div class="info-header">
            <h2>INFORMASI PUBLIK</h2>
        </div>
        <div class="info-grid">
            @forelse($informasiPubliks ?? \App\Models\InformasiPublik::where('judul', 'not like', '%Agenda%')->get() as $index => $item)
            <div class="info-card">
                <div class="info-icon">{{ $index + 1 }}</div>
                <h4>{{ $item->judul }}</h4>
                <p>{{ $item->sub_deskripsi }}</p>
                <a href="{{ route('informasi-publik.detail', $item->id) }}" class="info-link">Pelajari lebih lanjut <i class="fas fa-arrow-right"></i></a>
            </div>
            @empty
            <div class="info-card">
                <div class="info-icon">1</div>
                <h4>Lembaga Kemasyarakatan</h4>
                <p>Informasi lengkap tentang lembaga-lembaga yang ada di Kelurahan Citangkil.</p>
                <a href="#" class="info-link">Pelajari lebih lanjut <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="info-card">
                <div class="info-icon">2</div>
                <h4>Lembaga Pemberdayaan Masyarakat</h4>
                <p>Program pemberdayaan untuk meningkatkan kesejahteraan masyarakat.</p>
                <a href="#" class="info-link">Pelajari lebih lanjut <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="info-card">
                <div class="info-icon">3</div>
                <h4>Dokumen Publik</h4>
                <p>Akses dokumen dan peraturan yang dapat diakses oleh masyarakat.</p>
                <a href="#" class="info-link">Pelajari lebih lanjut <i class="fas fa-arrow-right"></i></a>
            </div>
            @endforelse
        </div>
    </section>

    <section class="prestasi-section">
        <div class="prestasi-header">
            <h2>Prestasi</h2>
            <p>Prestasi dan penghargaan yang telah diraih Kelurahan Citangkil.</p>
        </div>

        @if(($prestasi ?? collect())->count() > 0)
            <div class="prestasi-grid">
                @foreach($prestasi as $item)
                    <article class="prestasi-card">
                        <div class="prestasi-carousel-wrap">
                            <div class="prestasi-carousel" data-prestasi-carousel data-current-index="0">
                                <div class="prestasi-carousel-track">
                                    @forelse($item->fotos as $index => $foto)
                                        <div class="prestasi-carousel-slide {{ $index === 0 ? 'active' : '' }}" data-slide-index="{{ $index }}">
                                            <img src="{{ asset('storage/' . $foto->foto) }}" alt="{{ $item->judul }}">
                                        </div>
                                    @empty
                                        <div class="prestasi-carousel-slide active" data-slide-index="0">
                                            <i class="fas fa-trophy"></i>
                                        </div>
                                    @endforelse
                                </div>
                                <span class="prestasi-badge">
                                    <i class="fas fa-award"></i>
                                    {{ $item->peringkat }}
                                </span>
                                @if($item->fotos->count() > 1)
                                    <span class="prestasi-photo-count">
                                        <i class="far fa-images"></i>
                                        {{ $item->fotos->count() }} foto
                                    </span>
                                    <button type="button" class="prestasi-carousel-btn prev" data-prestasi-prev aria-label="Foto sebelumnya">
                                        <i class="fas fa-chevron-left"></i>
                                    </button>
                                    <button type="button" class="prestasi-carousel-btn next" data-prestasi-next aria-label="Foto berikutnya">
                                        <i class="fas fa-chevron-right"></i>
                                    </button>
                                    <div class="prestasi-carousel-dots">
                                        @foreach($item->fotos as $index => $foto)
                                            <button type="button" class="prestasi-carousel-dot {{ $index === 0 ? 'active' : '' }}" data-prestasi-dot="{{ $index }}" aria-label="Lihat foto {{ $index + 1 }}"></button>
                                        @endforeach
                                    </div>
                                @endif
                                @if($item->fotos->count() > 0)
                                    <div class="prestasi-expand-btn">
                                        <i class="fas fa-expand-alt"></i>
                                    </div>
                                @endif
                            </div>
                            @if($item->fotos->count() > 1)
                                <div class="prestasi-carousel-thumbs">
                                    @foreach($item->fotos as $index => $foto)
                                        <img src="{{ asset('storage/' . $foto->foto) }}"
                                             alt="Thumbnail {{ $index + 1 }}"
                                             class="prestasi-carousel-thumb {{ $index === 0 ? 'active' : '' }}"
                                             data-prestasi-thumb="{{ $index }}">
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        <div class="prestasi-content">
                            <div class="prestasi-meta">
                                <span><i class="far fa-calendar"></i> {{ $item->tahun }}</span>
                                <span><i class="fas fa-location-dot"></i> {{ $item->tingkat }}</span>
                            </div>
                            <h3>{{ $item->judul }}</h3>
                            <p>{{ $item->deskripsi }}</p>
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            <div class="prestasi-empty">
                <i class="fas fa-trophy"></i>
                <h3>Belum Ada Prestasi</h3>
                <p>Prestasi kelurahan akan ditampilkan di sini setelah ditambahkan oleh admin.</p>
            </div>
        @endif
    </section>

    @include('partials.agenda-calendar', ['agendaKegiatans' => $agendaKegiatans ?? collect()])

    <div class="prestasi-viewer-overlay" id="prestasiViewer" aria-hidden="true">
        <div class="prestasi-viewer-toolbar">
            <button type="button" class="prestasi-viewer-btn" id="prestasiZoomOutBtn" aria-label="Zoom out">
                <i class="fas fa-minus"></i>
            </button>
            <span class="prestasi-viewer-zoom" id="prestasiZoomLabel">100%</span>
            <button type="button" class="prestasi-viewer-btn" id="prestasiZoomInBtn" aria-label="Zoom in">
                <i class="fas fa-plus"></i>
            </button>
        </div>
        <div class="prestasi-viewer-stage">
            <img src="" alt="" id="prestasiViewerImage">
        </div>
        <button type="button" class="prestasi-viewer-nav prev" id="prestasiViewerPrevBtn" aria-label="Foto sebelumnya">
            <i class="fas fa-chevron-left"></i>
        </button>
        <button type="button" class="prestasi-viewer-nav next" id="prestasiViewerNextBtn" aria-label="Foto berikutnya">
            <i class="fas fa-chevron-right"></i>
        </button>
    </div>

    <script>
        const prestasiViewer = document.getElementById('prestasiViewer');
        const prestasiViewerImage = document.getElementById('prestasiViewerImage');
        const prestasiZoomLabel = document.getElementById('prestasiZoomLabel');
        let prestasiViewerPhotos = [];
        let prestasiViewerIndex = 0;
        let prestasiZoom = 1;

        document.querySelectorAll('[data-prestasi-carousel]').forEach(carousel => {
            const slides = carousel.querySelectorAll('.prestasi-carousel-slide');
            const dots = carousel.querySelectorAll('[data-prestasi-dot]');
            const thumbs = carousel.closest('.prestasi-carousel-wrap')?.querySelectorAll('[data-prestasi-thumb]') || [];
            const prevBtn = carousel.querySelector('[data-prestasi-prev]');
            const nextBtn = carousel.querySelector('[data-prestasi-next]');
            let currentIndex = 0;

            const carouselPhotos = Array.from(slides).map(slide => {
                const image = slide.querySelector('img');
                return {
                    src: image?.src || '',
                    alt: image?.alt || 'Foto prestasi',
                };
            }).filter(photo => photo.src);

            slides.forEach((slide, slideIndex) => {
                const image = slide.querySelector('img');
                image?.addEventListener('click', () => openPrestasiViewer(carouselPhotos, slideIndex));
            });

            if (slides.length <= 1) return;

            const goToSlide = index => {
                currentIndex = (index + slides.length) % slides.length;
                carousel.dataset.currentIndex = currentIndex;

                slides.forEach((slide, slideIndex) => {
                    slide.classList.toggle('active', slideIndex === currentIndex);
                });
                dots.forEach((dot, dotIndex) => {
                    dot.classList.toggle('active', dotIndex === currentIndex);
                });
                thumbs.forEach((thumb, thumbIndex) => {
                    thumb.classList.toggle('active', thumbIndex === currentIndex);
                });
            };

            prevBtn?.addEventListener('click', event => {
                event.stopPropagation();
                goToSlide(currentIndex - 1);
            });
            nextBtn?.addEventListener('click', event => {
                event.stopPropagation();
                goToSlide(currentIndex + 1);
            });
            dots.forEach(dot => {
                dot.addEventListener('click', event => {
                    event.stopPropagation();
                    goToSlide(Number(dot.dataset.prestasiDot));
                });
            });
            thumbs.forEach(thumb => {
                thumb.addEventListener('click', event => {
                    event.stopPropagation();
                    goToSlide(Number(thumb.dataset.prestasiThumb));
                });
            });
        });

        function openPrestasiViewer(photos, index = 0) {
            prestasiViewerPhotos = Array.isArray(photos) ? photos : [];
            prestasiViewerIndex = index;
            prestasiViewer.classList.toggle('has-multiple', prestasiViewerPhotos.length > 1);
            showPrestasiViewerPhoto(prestasiViewerIndex);
            prestasiViewer.classList.add('active');
            prestasiViewer.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';
        }

        function showPrestasiViewerPhoto(index) {
            if (prestasiViewerPhotos.length === 0) return;

            prestasiViewerIndex = (index + prestasiViewerPhotos.length) % prestasiViewerPhotos.length;
            const photo = prestasiViewerPhotos[prestasiViewerIndex];
            prestasiZoom = 1;
            prestasiViewerImage.src = photo.src;
            prestasiViewerImage.alt = photo.alt || 'Foto prestasi';
            updatePrestasiZoom();
        }

        function closePrestasiViewer() {
            prestasiViewer.classList.remove('active');
            prestasiViewer.classList.remove('has-multiple');
            prestasiViewer.setAttribute('aria-hidden', 'true');
            prestasiViewerImage.src = '';
            prestasiViewerPhotos = [];
            prestasiViewerIndex = 0;
            document.body.style.overflow = '';
        }

        function updatePrestasiZoom() {
            prestasiViewerImage.style.transform = `scale(${prestasiZoom})`;
            prestasiZoomLabel.textContent = `${Math.round(prestasiZoom * 100)}%`;
        }

        function zoomPrestasiPhoto(delta) {
            prestasiZoom = Math.min(4, Math.max(0.5, prestasiZoom + delta));
            updatePrestasiZoom();
        }

        document.getElementById('prestasiZoomOutBtn').addEventListener('click', () => zoomPrestasiPhoto(-0.25));
        document.getElementById('prestasiZoomInBtn').addEventListener('click', () => zoomPrestasiPhoto(0.25));
        document.getElementById('prestasiViewerPrevBtn').addEventListener('click', () => showPrestasiViewerPhoto(prestasiViewerIndex - 1));
        document.getElementById('prestasiViewerNextBtn').addEventListener('click', () => showPrestasiViewerPhoto(prestasiViewerIndex + 1));

        window.addEventListener('click', event => {
            if (
                prestasiViewer.classList.contains('active') &&
                event.target.closest('#prestasiViewer') &&
                !event.target.closest('#prestasiViewerImage') &&
                !event.target.closest('.prestasi-viewer-toolbar') &&
                !event.target.closest('.prestasi-viewer-nav')
            ) {
                closePrestasiViewer();
            }
        });

        document.addEventListener('keydown', event => {
            if (event.key === 'Escape' && prestasiViewer.classList.contains('active')) {
                closePrestasiViewer();
            }
            if (event.key === 'ArrowLeft' && prestasiViewer.classList.contains('active') && prestasiViewerPhotos.length > 1) {
                showPrestasiViewerPhoto(prestasiViewerIndex - 1);
            }
            if (event.key === 'ArrowRight' && prestasiViewer.classList.contains('active') && prestasiViewerPhotos.length > 1) {
                showPrestasiViewerPhoto(prestasiViewerIndex + 1);
            }
        });
    </script>

    <style>
        .visit-stats-section {
            background: #ffffff;
            padding: 20px 20px 36px;
        }

        .visit-stats-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .visit-stats-title {
            font-size: 1.4rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 18px;
        }

.visit-stats-grid {
            display: flex;
            flex-wrap: nowrap;
            gap: 14px;
            overflow-x: auto;
        }

        @media (max-width: 575px) {
            .visit-stats-grid .visit-stat-card {
                min-width: calc(50% - 7px);
                flex: 0 0 calc(50% - 7px);
            }
        }

        @media (min-width: 576px) {
            .visit-stats-grid .visit-stat-card {
                min-width: calc(25% - 10.5px);
                flex: 0 0 calc(25% - 10.5px);
            }
        }

        .visit-stat-card {
            border: 1px solid #f0f0f0;
            border-radius: 12px;
            padding: 18px;
            background: #fff8f2;
            box-shadow: 0 6px 18px rgba(248, 144, 57, 0.08);
        }

        .visit-stat-label {
            font-size: 0.95rem;
            color: #666;
            margin-bottom: 8px;
        }

        .visit-stat-value {
            font-size: 1.8rem;
            font-weight: 700;
            color: #F89039;
            line-height: 1.2;
        }

    </style>

@php
        $uniqueStats = $visitStats['unique'] ?? ['daily' => 0, 'weekly' => 0, 'monthly' => 0, 'total' => 0];
        $visitorStats = $visitStats['visitor'] ?? ['daily' => 0, 'weekly' => 0, 'monthly' => 0, 'total' => 0];
    @endphp
    <section class="visit-stats-section">
        <div class="visit-stats-container">
            <h2 class="visit-stats-title">Jumlah Pengunjung Unik</h2>
            <div class="visit-stats-grid">
                <div class="visit-stat-card">
                    <p class="visit-stat-label">Harian</p>
                    <p class="visit-stat-value">{{ number_format($uniqueStats['daily'] ?? 0, 0, ',', '.') }}</p>
                </div>
                <div class="visit-stat-card">
                    <p class="visit-stat-label">Mingguan</p>
                    <p class="visit-stat-value">{{ number_format($uniqueStats['weekly'] ?? 0, 0, ',', '.') }}</p>
                </div>
                <div class="visit-stat-card">
                    <p class="visit-stat-label">Bulanan</p>
                    <p class="visit-stat-value">{{ number_format($uniqueStats['monthly'] ?? 0, 0, ',', '.') }}</p>
                </div>
                <div class="visit-stat-card">
                    <p class="visit-stat-label">Total</p>
                    <p class="visit-stat-value">{{ number_format($uniqueStats['total'] ?? 0, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
    </section>

    <section class="visit-stats-section">
        <div class="visit-stats-container">
            <h2 class="visit-stats-title">Jumlah Kunjungan Website</h2>

            <div class="visit-stats-grid">
                <div class="visit-stat-card">
                    <p class="visit-stat-label">Harian</p>
                    <p class="visit-stat-value">{{ number_format($visitorStats['daily'] ?? 0, 0, ',', '.') }}</p>
                </div>
                <div class="visit-stat-card">
                    <p class="visit-stat-label">Mingguan</p>
                    <p class="visit-stat-value">{{ number_format($visitorStats['weekly'] ?? 0, 0, ',', '.') }}</p>
                </div>
                <div class="visit-stat-card">
                    <p class="visit-stat-label">Bulanan</p>
                    <p class="visit-stat-value">{{ number_format($visitorStats['monthly'] ?? 0, 0, ',', '.') }}</p>
                </div>
                <div class="visit-stat-card">
                    <p class="visit-stat-label">Total</p>
                    <p class="visit-stat-value">{{ number_format($visitorStats['total'] ?? 0, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
    </section>

@endsection
