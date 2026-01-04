@extends('layouts.app')

@section('title', 'Program Desa Cantik - Kelurahan Citangkil')

@section('content')
    <style>
        /* --- CSS DASAR --- */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
            color: #333;
            line-height: 1.6;
            overflow-x: hidden;
        }

        .container {
            width: 95%;
            max-width: none;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Header Hijau */
        .main-header {
            background-color: #00897B;
            color: white;
            padding-top: 60px;
            padding-bottom: 80px;
        }

        .main-header h1 {
            font-size: 2.5rem;
            font-weight: 400;
            margin-bottom: 15px;
        }

        .main-header .subtitle {
            font-size: 1rem;
            opacity: 0.9;
            margin-bottom: 5px;
            font-weight: 300;
        }

        main {
            padding-top: 40px;
            padding-bottom: 80px;
        }

        /* Judul Section */
        .section-title {
            text-align: center;
            color: #00897B; /* Warna Hijau Teal */
            font-size: 1.8rem;
            font-weight: 500;
            margin-top: 70px;
            margin-bottom: 40px;
            text-transform: capitalize;
        }

        /* --- KARTU DESKRIPSI UTAMA --- */
        .main-card {
            background-color: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
        }

        .main-card h2 {
            color: #00897B;
            font-size: 1.8rem;
            font-weight: 400;
            margin-bottom: 25px;
        }

        .main-card p {
            color: #555;
            margin-bottom: 20px;
            font-size: 0.95rem;
            text-align: justify;
        }

        /* --- GRID SYSTEMS --- */
        .grid-3 {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
            margin-bottom: 40px;
        }

        .grid-2 {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 25px;
        }

        /* --- INFO CARDS (Metadata, Output & Prestasi) --- */
        .info-card {
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.03);
            display: flex;
            flex-direction: column;
            /* Default alignment kiri untuk metadata/output */
            align-items: flex-start; 
            height: 100%;
        }

        .icon-box {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 25px;
            font-size: 20px;
        }

        /* Tema Warna Kartu (Hijau, Biru, Ungu) */
        .card-theme-green { background-color: #E9F7F3; }
        .card-theme-green .icon-box { background-color: #C0EBE1; color: #009688; }

        .card-theme-blue { background-color: #EBF3FB; }
        .card-theme-blue .icon-box { background-color: #CDE4F7; color: #2196F3; }

        .card-theme-purple { background-color: #F5EFF8; }
        .card-theme-purple .icon-box { background-color: #E6CEF2; color: #9C27B0; }

        /* Typography Kartu Info */
        .info-card h3 {
            font-size: 1rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 15px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .info-card p {
            font-size: 0.9rem;
            color: #666;
            line-height: 1.5;
        }

        /* --- CSS KHUSUS BAGIAN PRESTASI (BARU) --- */
        /* Tema Oranye/Krem untuk Prestasi */
        .card-theme-orange {
            background-color: #FFFBE6; /* Latar belakang krem kekuningan */
            align-items: center; /* Override: konten di tengah */
            text-align: center; /* Teks di tengah */
        }

        .card-theme-orange .icon-box {
            background-color: #FF9800; /* Ikon oranye */
            color: white;
            width: 64px; /* Ukuran ikon lebih besar dan bulat */
            height: 64px;
            font-size: 28px;
            border-radius: 50%; /* Bentuk lingkaran */
        }

        .achievement-year {
            color: #FF9800;
            font-weight: 700;
            font-size: 1.1rem;
            margin-bottom: 10px;
        }


        /* --- GALERI KEGIATAN --- */
        .gallery-card {
            background-color: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
            transition: transform 0.2s ease;
            display: flex;
            flex-direction: column;
        }

        .gallery-card:hover {
            transform: translateY(-5px);
        }

        .gallery-img-placeholder {
            width: 100%;
            height: 180px;
            background-color: #EEEEEE;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #BDBDBD;
            font-size: 3rem;
        }

        .gallery-content {
            padding: 20px;
            flex-grow: 1;
        }

        .gallery-title {
            font-size: 1rem;
            font-weight: 500;
            color: #333;
            margin-bottom: 8px;
        }

        .gallery-subtitle {
            font-size: 0.85rem;
            color: #777;
        }

        /* --- RESPONSIVE --- */
        @media (max-width: 768px) {
            .main-header { padding: 40px 0; }
            .main-header h1 { font-size: 2rem; }
            .main-card { padding: 25px; }
            .section-title { font-size: 1.5rem; margin-top: 50px; }
            
            /* Grid menjadi 1 kolom di HP */
            .grid-3, .grid-2 {
                grid-template-columns: 1fr;
                gap: 20px;
            }
        }
    </style>

    <header class="main-header">
        <div class="container">
            <h1>Program Desa Cantik</h1>
            <p class="subtitle">Dapori Pembuasan Desa Cantik oleh RPS Kota Cilegon - Mitra Modular</p>
            <p class="subtitle">Kelurahan Citangkil</p>
        </div>
    </header>

    <main>
        <div class="container">
            
            <div class="main-card">
                <h2>Tentang Program Desa Cantik</h2>
                <p>Desa Cinta Statistik, atau yang dikenal dengan Desa Cantik, adalah sebuah program yang bertujuan untuk meningkatkan kemampuan aparat desa dalam mengelola dan memanfaatkan data agar perencanaan pembangunan desa lebih tepat sasaran. Saat ini, desa-desa telah dibekali dengan berbagai aplikasi pendataan seperti SDGs Desa, Prodeskel (Profil Desa dan Kelurahan), dan SIKS-NG (Sistem Informasi Kesejahteraan Sosial Next Generation).</p>
                <p>Namun, kualitas dan kapasitas sumber daya manusia di pemerintahan desa dalam hal pengelolaan dan literasi data masih tergolong rendah. Badan Pusat Statistik (BPS) sebagai lembaga yang membina statistik memiliki peranan penting dalam meningkatkan pengelolaan, pemanfaatan, dan literasi data di tingkat desa.</p>
                <p>Oleh karena itu, program Desa Cantik diluncurkan dengan tujuan untuk meningkatkan literasi data di kalangan seluruh aparat desa.</p>
            </div>


            <h2 class="section-title">METADATA STATISTIK</h2>
            <div class="grid-3">
                <div class="info-card card-theme-green">
                    <div class="icon-box"><i class="fas fa-database"></i></div>
                    <h3>Meta Data Kegiatan</h3>
                    <p>Dokumentasi dan pencatatan seluruh kegiatan updating data kependudukan</p>
                </div>
                <div class="info-card card-theme-blue">
                    <div class="icon-box"><i class="far fa-file-alt"></i></div>
                    <h3>Meta Data Variabel</h3>
                    <p>Definisi dan klasifikasi variabel-variabel yang digunakan dalam pendataan</p>
                </div>
                <div class="info-card card-theme-purple">
                    <div class="icon-box"><i class="far fa-chart-bar"></i></div>
                    <h3>Meta Data Indikator</h3>
                    <p>Indikator-indikator statistik untuk mengukur kualitas data kependudukan</p>
                </div>
            </div>


            <h2 class="section-title">Output Desa Cantik</h2>
            <div class="grid-2">
                <div class="info-card card-theme-green">
                    <div class="icon-box"><i class="fas fa-clipboard-list"></i></div>
                    <h3>SISTEM UPDATING DATA KEPENDUDUKAN</h3>
                    <p>Kuesioner Updating Data Kependudukan</p>
                </div>
                <div class="info-card card-theme-blue">
                    <div class="icon-box"><i class="fas fa-server"></i></div>
                    <h3>MEDIA PENGELOLAAN DATA KEPENDUDUKAN</h3>
                    <p>Website Kelurahan Citangkil</p>
                </div>
                <div class="info-card card-theme-green">
                    <div class="icon-box"><i class="fas fa-book-open"></i></div>
                    <h3>PENINGKATAN KAPABILITAS & LITERASI STATISTIK</h3>
                    <p>Booklet Kelurahan Citangkil</p>
                </div>
                <div class="info-card card-theme-purple">
                    <div class="icon-box"><i class="fas fa-passport"></i></div>
                    <h3>SEGMENTASI DEMOGRAFIS KELUARGA</h3>
                    <p>Buku Segmentasi Demografis Keluarga Kelurahan Citangkil</p>
                </div>
            </div>
            
            <h2 class="section-title">Galeri Kegiatan</h2>
            <div class="grid-3">
                <div class="gallery-card">
                    <div class="gallery-img-placeholder"><i class="far fa-image"></i></div>
                    <div class="gallery-content">
                        <div class="gallery-title">Kegiatan Program Desa Cantik</div>
                        <div class="gallery-subtitle">Kelurahan Citangkil 2024</div>
                    </div>
                </div>
                <div class="gallery-card">
                    <div class="gallery-img-placeholder"><i class="far fa-image"></i></div>
                    <div class="gallery-content">
                        <div class="gallery-title">Kegiatan Program Desa Cantik</div>
                        <div class="gallery-subtitle">Kelurahan Citangkil 2024</div>
                    </div>
                </div>
                <div class="gallery-card">
                    <div class="gallery-img-placeholder"><i class="far fa-image"></i></div>
                    <div class="gallery-content">
                        <div class="gallery-title">Kegiatan Program Desa Cantik</div>
                        <div class="gallery-subtitle">Kelurahan Citangkil 2024</div>
                    </div>
                </div>
                 <div class="gallery-card">
                    <div class="gallery-img-placeholder"><i class="far fa-image"></i></div>
                    <div class="gallery-content">
                        <div class="gallery-title">Kegiatan Program Desa Cantik</div>
                        <div class="gallery-subtitle">Kelurahan Citangkil 2024</div>
                    </div>
                </div>
                <div class="gallery-card">
                    <div class="gallery-img-placeholder"><i class="far fa-image"></i></div>
                    <div class="gallery-content">
                        <div class="gallery-title">Kegiatan Program Desa Cantik</div>
                        <div class="gallery-subtitle">Kelurahan Citangkil 2024</div>
                    </div>
                </div>
                <div class="gallery-card">
                    <div class="gallery-img-placeholder"><i class="far fa-image"></i></div>
                    <div class="gallery-content">
                        <div class="gallery-title">Kegiatan Program Desa Cantik</div>
                        <div class="gallery-subtitle">Kelurahan Citangkil 2024</div>
                    </div>
                </div>
            </div>

            <h2 class="section-title">Prestasi & Penghargaan</h2>
            <div class="grid-3">
                <div class="info-card card-theme-orange">
                    <div class="icon-box"><i class="fas fa-medal"></i></div>
                    <p class="achievement-year">2023</p>
                    <p>Juara 1 Desa Cantik Tingkat Kota Cilegon</p>
                </div>
                
                <div class="info-card card-theme-orange">
                    <div class="icon-box"><i class="fas fa-medal"></i></div>
                    <p class="achievement-year">2023</p>
                    <p>Penghargaan Lingkungan Terbersih</p>
                </div>

                <div class="info-card card-theme-orange">
                    <div class="icon-box"><i class="fas fa-medal"></i></div>
                    <p class="achievement-year">2024</p>
                    <p>Kelurahan Terbaik Program Penghijauan</p>
                </div>
            </div>

        </div> </main>
@endsection
