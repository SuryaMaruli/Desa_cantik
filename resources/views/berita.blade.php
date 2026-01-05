@extends('layouts.app')

@section('title', 'Berita & Informasi - Kelurahan Citangkil')

@section('content')
    <style>
        /* --- 1. RESET & VARIABLES --- */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
        }

        :root {
            --primary-color: #009668; /* Hijau Tosca Utama */
            --primary-dark: #007a55;
            --bg-body: #f8f9fa;
            --white: #ffffff;
            --text-dark: #1f2937;
            --text-gray: #6b7280;
            --shadow-sm: 0 2px 4px rgba(0,0,0,0.05);
            --shadow-md: 0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -2px rgba(0, 0, 0, 0.025);
            
            /* Warna Badge Kategori */
            --badge-prestasi-bg: #fef3c7; --badge-prestasi-text: #d97706; /* Kuning */
            --badge-kesehatan-bg: #dcfce7; --badge-kesehatan-text: #166534; /* Hijau Muda */
            --badge-sosial-bg: #dbeafe; --badge-sosial-text: #1e40af; /* Biru */
            --badge-lingkungan-bg: #d1fae5; --badge-lingkungan-text: #065f46; /* Emerald */
            --badge-ekonomi-bg: #f3e8ff; --badge-ekonomi-text: #6b21a8; /* Ungu */
            --badge-program-bg: #fee2e2; --badge-program-text: #991b1b; /* Merah/Pink */
            --badge-kegiatan-bg: #ccfbf1; --badge-kegiatan-text: #0f766e; /* Teal Muda */
        }

        body {
            background-color: var(--bg-body);
            color: var(--text-dark);
            padding-bottom: 80px;
            overflow-x: hidden;
        }

        /* --- 2. HEADER / HERO SECTION --- */
        .hero {
            background-color: var(--primary-color);
            padding: 80px 20px 100px 20px; /* Padding bawah lebih besar */
            color: var(--white);
        }

        .container {
            width: 95%;
            max-width: none;
            margin: 0 auto;
            padding: 0 20px;
        }

        .hero h1 {
            font-size: 2.5rem;
            font-weight: 500;
            margin-bottom: 12px;
        }

        .hero p {
            opacity: 0.9;
            font-weight: 300;
            font-size: 1.1rem;
        }

        /* --- 3. FILTER NAVIGATION --- */
        .filters-wrapper {
            margin-top: -30px; /* Supaya nempel dikit ke hero area */
            margin-bottom: 40px;
            padding: 20px 0;
        }

        .filters {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 12px;
        }

        .filter-btn {
            padding: 10px 28px;
            border-radius: 50px;
            border: none;
            background-color: var(--white);
            color: var(--text-gray);
            font-size: 0.95rem;
            cursor: pointer;
            box-shadow: var(--shadow-sm);
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .filter-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .filter-btn.active {
            background-color: var(--primary-color);
            color: var(--white);
        }

        /* --- 4. TYPOGRAPHY & LAYOUT UTILS --- */
        .section-title {
            color: var(--primary-color);
            font-size: 1.5rem;
            margin-bottom: 24px;
            font-weight: 500;
        }

        .meta-info {
            display: flex;
            align-items: center;
            gap: 20px;
            font-size: 0.85rem;
            color: #9ca3af;
            margin-top: auto; /* Push ke bawah */
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        /* SVG Icon styling */
        .icon {
            width: 16px;
            height: 16px;
            fill: currentColor;
        }

        /* --- 5. FEATURED CARD (BERITA UTAMA) --- */
        /* Layout Horizontal */
        .featured-card {
            background: var(--white);
            border-radius: 20px;
            box-shadow: var(--shadow-md);
            display: flex;
            overflow: hidden;
            min-height: 400px;
            margin-bottom: 60px;
        }

        .featured-img-col {
            width: 50%;
            background-color: #eee; /* Placeholder gambar */
            position: relative;
        }

        .featured-content-col {
            width: 50%;
            padding: 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-start;
        }

        .featured-title {
            font-size: 2rem;
            line-height: 1.3;
            margin-bottom: 16px;
            color: var(--text-dark);
        }

        .featured-desc {
            color: var(--text-gray);
            line-height: 1.6;
            margin-bottom: 24px;
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background-color: var(--primary-color);
            color: var(--white);
            padding: 12px 24px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            margin-top: 24px;
            transition: background 0.3s;
        }
        .btn-primary:hover {
            background-color: var(--primary-dark);
        }

        /* --- 6. GRID SYSTEM (BERITA TERBARU) --- */
        .news-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 30px;
        }

        /* --- 7. NEWS CARD (VERTICAL) --- */
        .news-card {
            background: var(--white);
            border-radius: 16px;
            box-shadow: var(--shadow-md);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            transition: transform 0.3s ease;
            height: 100%;
        }

        .news-card:hover {
            transform: translateY(-5px);
        }

        .card-img-top {
            height: 200px;
            background-color: #f3f4f6; /* Placeholder abu-abu terang */
            position: relative;
        }

        .card-body {
            padding: 24px;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }

        .card-title {
            font-size: 1.15rem;
            font-weight: 600;
            margin-bottom: 12px;
            line-height: 1.4;
            color: var(--text-dark);
        }

        .card-text {
            font-size: 0.95rem;
            color: var(--text-gray);
            line-height: 1.5;
            margin-bottom: 20px;
            display: -webkit-box;
            -webkit-line-clamp: 3; /* Batasi 3 baris */
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .card-meta-date {
            font-size: 0.8rem;
            color: #9ca3af;
            display: flex;
            align-items: center;
            gap: 6px;
            margin-bottom: 16px;
        }

        /* Link teks hijau di bawah */
        .link-read-more {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
            font-size: 0.95rem;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            margin-top: auto; /* Selalu di bawah */
        }
        .link-read-more:hover {
            text-decoration: underline;
        }

        /* --- 8. BADGES --- */
        .badge {
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            position: absolute;
            z-index: 10;
        }

        /* Posisi Badge Berbeda antara Featured dan Grid */
        .featured-card .badge {
            top: 40px;
            left: 40px; /* Sesuai layout featured */
        }
        
        .news-card .badge {
            top: 15px;
            right: 15px; /* Pojok kanan atas untuk grid */
        }

        /* Warna-warna Badge */
        .bg-prestasi { background-color: var(--badge-prestasi-bg); color: var(--badge-prestasi-text); }
        .bg-kesehatan { background-color: var(--badge-kesehatan-bg); color: var(--badge-kesehatan-text); }
        .bg-sosial { background-color: var(--badge-sosial-bg); color: var(--badge-sosial-text); }
        .bg-lingkungan { background-color: var(--badge-lingkungan-bg); color: var(--badge-lingkungan-text); }
        .bg-ekonomi { background-color: var(--badge-ekonomi-bg); color: var(--badge-ekonomi-text); }
        .bg-program { background-color: var(--badge-program-bg); color: var(--badge-program-text); }
        .bg-kegiatan { background-color: var(--badge-kegiatan-bg); color: var(--badge-kegiatan-text); }

        /* --- RESPONSIVE --- */
        @media (max-width: 768px) {
            .featured-card {
                flex-direction: column;
            }
            .featured-img-col, .featured-content-col {
                width: 100%;
            }
            .featured-img-col {
                height: 250px;
            }
            .featured-content-col {
                padding: 30px;
            }
            .hero h1 { font-size: 2rem; }
            .hero { padding-bottom: 60px; }
        }
    </style>

    <header class="hero">
        <div class="container">
            <h1>Berita & Informasi</h1>
            <p>Update terkini seputar kegiatan, pengumuman, dan berita dari Kelurahan Citangkil</p>
        </div>
    </header>

    <div class="container">
        <div class="filters-wrapper">
            <div class="filters">
                <button class="filter-btn active">Semua</button>
                <button class="filter-btn">Prestasi</button>
                <button class="filter-btn">Kesehatan</button>
                <button class="filter-btn">Sosial</button>
                <button class="filter-btn">Lingkungan</button>
                <button class="filter-btn">Ekonomi</button>
                <button class="filter-btn">Program</button>
                <button class="filter-btn">Kegiatan</button>
            </div>
        </div>

        <h2 class="section-title">Berita Utama</h2>
        
        <article class="featured-card">
            <div class="featured-img-col">
                <span class="badge bg-prestasi">Prestasi</span>
                </div>
            
            <div class="featured-content-col">
                <h3 class="featured-title">Kelurahan Citangkil Raih Penghargaan Desa Cantik Terbaik 2024</h3>
                <p class="featured-desc">
                    Kelurahan Citangkil kembali menorehkan prestasi dengan meraih penghargaan sebagai Desa Cantik Terbaik tingkat Kota Cilegon tahun 2024. Penghargaan ini diberikan atas komitmen dan kerja keras...
                </p>
                
                <div class="meta-info">
                    <div class="meta-item">
                        <svg class="icon" viewBox="0 0 24 24"><path d="M19 4h-1V2h-2v2H8V2H6v2H5c-1.11 0-1.99.9-1.99 2L3 20a2 2 0 0 0 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V10h14v10zM9 14H7v-2h2v2zm4 0h-2v-2h2v2zm4 0h-2v-2h2v2zm-8 4H7v-2h2v2zm4 0h-2v-2h2v2zm4 0h-2v-2h2v2z"/></svg>
                        <span>15 Desember 2024</span>
                    </div>
                    <div class="meta-item">
                        <svg class="icon" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                        <span>Admin Kelurahan</span>
                    </div>
                </div>

                <a href="#" class="btn-primary">Baca Selengkapnya &rarr;</a>
            </div>
        </article>

        <h2 class="section-title">Berita Terbaru</h2>
        
        <div class="news-grid">
            
            <article class="news-card">
                <div class="card-img-top">
                    <span class="badge bg-kesehatan">Kesehatan</span>
                </div>
                <div class="card-body">
                    <h3 class="card-title">Vaksinasi Gratis untuk Lansia di Kelurahan Citangkil</h3>
                    <p class="card-text">Pemerintah Kelurahan Citangkil mengadakan program vaksinasi gratis untuk lansia sebagai upaya pencegahan penyakit musiman.</p>
                    <div class="card-meta-date">
                        <svg class="icon" viewBox="0 0 24 24"><path d="M19 4h-1V2h-2v2H8V2H6v2H5c-1.11 0-1.99.9-1.99 2L3 20a2 2 0 0 0 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V10h14v10z"/></svg>
                        12 Desember 2024
                    </div>
                    <a href="#" class="link-read-more">Baca Selengkapnya &rarr;</a>
                </div>
            </article>

            <article class="news-card">
                <div class="card-img-top">
                    <span class="badge bg-sosial">Sosial</span>
                </div>
                <div class="card-body">
                    <h3 class="card-title">Program Bantuan Sembako untuk Warga Kurang Mampu</h3>
                    <p class="card-text">Dalam rangka meringankan beban masyarakat, Kelurahan Citangkil menyalurkan bantuan sembako kepada warga yang membutuhkan.</p>
                    <div class="card-meta-date">
                        <svg class="icon" viewBox="0 0 24 24"><path d="M19 4h-1V2h-2v2H8V2H6v2H5c-1.11 0-1.99.9-1.99 2L3 20a2 2 0 0 0 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V10h14v10z"/></svg>
                        10 Desember 2024
                    </div>
                    <a href="#" class="link-read-more">Baca Selengkapnya &rarr;</a>
                </div>
            </article>

            <article class="news-card">
                <div class="card-img-top">
                    <span class="badge bg-lingkungan">Lingkungan</span>
                </div>
                <div class="card-body">
                    <h3 class="card-title">Gotong Royong Bersihkan Lingkungan</h3>
                    <p class="card-text">Warga Kelurahan Citangkil bersama aparat kelurahan mengadakan kegiatan gotong royong membersihkan saluran air.</p>
                    <div class="card-meta-date">
                        <svg class="icon" viewBox="0 0 24 24"><path d="M19 4h-1V2h-2v2H8V2H6v2H5c-1.11 0-1.99.9-1.99 2L3 20a2 2 0 0 0 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V10h14v10z"/></svg>
                        8 Desember 2024
                    </div>
                    <a href="#" class="link-read-more">Baca Selengkapnya &rarr;</a>
                </div>
            </article>

            <article class="news-card">
                <div class="card-img-top">
                    <span class="badge bg-ekonomi">Ekonomi</span>
                </div>
                <div class="card-body">
                    <h3 class="card-title">Pelatihan Kewirausahaan untuk UMKM Lokal</h3>
                    <p class="card-text">Kelurahan Citangkil menyelenggarakan pelatihan kewirausahaan bagi pelaku UMKM untuk meningkatkan daya saing produk lokal.</p>
                    <div class="card-meta-date">
                        <svg class="icon" viewBox="0 0 24 24"><path d="M19 4h-1V2h-2v2H8V2H6v2H5c-1.11 0-1.99.9-1.99 2L3 20a2 2 0 0 0 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V10h14v10z"/></svg>
                        5 Desember 2024
                    </div>
                    <a href="#" class="link-read-more">Baca Selengkapnya &rarr;</a>
                </div>
            </article>

            <article class="news-card">
                <div class="card-img-top">
                    <span class="badge bg-program">Program</span>
                </div>
                <div class="card-body">
                    <h3 class="card-title">Sosialisasi Program Desa Cantik kepada Masyarakat</h3>
                    <p class="card-text">Lurah Citangkil mengadakan sosialisasi program Desa Cantik kepada seluruh RT dan RW untuk meningkatkan partisipasi warga.</p>
                    <div class="card-meta-date">
                        <svg class="icon" viewBox="0 0 24 24"><path d="M19 4h-1V2h-2v2H8V2H6v2H5c-1.11 0-1.99.9-1.99 2L3 20a2 2 0 0 0 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V10h14v10z"/></svg>
                        3 Desember 2024
                    </div>
                    <a href="#" class="link-read-more">Baca Selengkapnya &rarr;</a>
                </div>
            </article>

            <article class="news-card">
                <div class="card-img-top">
                    <span class="badge bg-kegiatan">Kegiatan</span>
                </div>
                <div class="card-body">
                    <h3 class="card-title">Lomba Kebersihan Antar RT Tingkat Kelurahan</h3>
                    <p class="card-text">Dalam rangka memperingati HUT Kelurahan, diadakan lomba kebersihan antar RT dengan hadiah menarik.</p>
                    <div class="card-meta-date">
                        <svg class="icon" viewBox="0 0 24 24"><path d="M19 4h-1V2h-2v2H8V2H6v2H5c-1.11 0-1.99.9-1.99 2L3 20a2 2 0 0 0 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V10h14v10z"/></svg>
                        1 Desember 2024
                    </div>
                    <a href="#" class="link-read-more">Baca Selengkapnya &rarr;</a>
                </div>
            </article>

        </div>
    </div>
@endsection
