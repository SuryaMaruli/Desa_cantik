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
            background-color: #F6903A;
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
            color: #F6903A; /* Warna Hijau Teal */
            font-size: 1.8rem;
            font-weight: 600;
            text-transform: uppercase;
            margin-bottom: 40px;
            letter-spacing: 1px;
        }

        .section-title.metadata {
            color: #C8461F; /* Warna oranye/merah bata */
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
            color: #c75310ff;
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
            border-radius: 8px;
        }

        .gallery-img-container {
            width: 100%;
            height: 180px;
            overflow: hidden;
            border-radius: 8px;
        }

        .gallery-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .gallery-card:hover .gallery-img {
            transform: scale(1.05);
        }

        /* Metadata Statistik Cards */
        .cards-wrapper {
            display: flex;
            gap: 30px;
            justify-content: center;
            flex-wrap: wrap;
            margin-bottom: 60px;
        }

        .card {
            flex: 1;
            min-width: 300px;
            border-radius: 20px;
            padding: 40px 30px;
            text-align: left;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card-cream {
            background-color: #FFFCF5;
        }

        .card-pink {
            background-color: #FFF5F4;
        }

        .card .icon-box {
            background-color: #ffffff;
            width: 70px;
            height: 70px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 25px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            border: 1px solid rgba(0,0,0,0.02);
        }

        .card .icon-box svg {
            width: 32px;
            height: 32px;
            color: #C8461F;
        }

        .card h3 {
            color: #333;
            font-size: 18px;
            margin-bottom: 15px;
            font-weight: 600;
        }

        .card p {
            color: #666;
            font-size: 15px;
            line-height: 1.6;
        }

        /* Output Desa Cantik Section */
        .main-title {
            text-align: center;
            color: #c84e30;
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 40px;
        }

        .grid-wrapper {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
            margin-bottom: 60px;
        }

        .grid-wrapper .card {
            border-radius: 16px;
            padding: 32px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.03);
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            transition: transform 0.3s ease;
            height: 100%;
        }

        .grid-wrapper .card:hover {
            transform: translateY(-5px);
        }

        .bg-cream {
            background-color: #fffef5;
            border: 1px solid #fcf7e6;
        }

        .bg-pink {
            background-color: #fffafa;
            border: 1px solid #fcf0f0;
        }

        .grid-wrapper .icon-box {
            width: 50px;
            height: 50px;
            background-color: white;
            border-radius: 12px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 24px;
            border: 1px solid #eee;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
        }

        .grid-wrapper .icon-box i {
            color: #c84e30;
            font-size: 20px;
        }

        .grid-wrapper .card h3 {
            font-size: 14px;
            font-weight: 700;
            text-transform: uppercase;
            color: #2c2c2c;
            line-height: 1.5;
            margin-bottom: 12px;
            letter-spacing: 0.3px;
        }

        .grid-wrapper .card p {
            font-size: 14px;
            color: #666;
            line-height: 1.5;
            margin-bottom: 16px;
        }

        .detail-btn {
            display: inline-block;
            background-color: #F6903A;
            color: white;
            padding: 8px 16px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            margin-top: auto;
        }

        .detail-btn:hover {
            background-color: #e57d2b;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(246, 144, 58, 0.3);
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

            /* Output Desa Cantik Responsive */
            .grid-wrapper {
                grid-template-columns: 1fr;
            }
            
            .main-title {
                font-size: 24px;
                margin-bottom: 30px;
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
                @if($tentang)
                    {!! $tentang->deskripsi !!}
                @else
                    <p>Desa Cinta Statistik, atau yang dikenal dengan Desa Cantik, adalah sebuah program yang bertujuan untuk meningkatkan kemampuan aparat desa dalam mengelola dan memanfaatkan data agar perencanaan pembangunan desa lebih tepat sasaran. Saat ini, desa-desa telah dibekali dengan berbagai aplikasi pendataan seperti SDGs Desa, Prodeskel (Profil Desa dan Kelurahan), dan SIKS-NG (Sistem Informasi Kesejahteraan Sosial Next Generation).</p>
                    <p>Namun, kualitas dan kapasitas sumber daya manusia di pemerintahan desa dalam hal pengelolaan dan literasi data masih tergolong rendah. Badan Pusat Statistik (BPS) sebagai lembaga yang membina statistik memiliki peranan penting dalam meningkatkan pengelolaan, pemanfaatan, dan literasi data di tingkat desa.</p>
                    <p>Oleh karena itu, program Desa Cantik diluncurkan dengan tujuan untuk meningkatkan literasi data di kalangan seluruh aparat desa.</p>
                @endif
            </div>

            <h2 class="section-title metadata">Metadata Statistik</h2>
            <div class="cards-wrapper">
                @forelse($metadata as $item)
                <div class="card {{ $loop->index % 2 == 0 ? 'card-cream' : 'card-pink' }}">
                    <div class="icon-box">
                        <div style="width: 32px; height: 32px; background-color: #F6903A; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 14px;">
                            {{ $loop->index + 1 }}
                        </div>
                    </div>
                    <h3>{{ $item->nama_metadata }}</h3>
                    <p>{{ $item->deskripsi }}</p>
                </div>
                @empty
                <div class="card card-cream">
                    <div class="icon-box">
                        <div style="width: 32px; height: 32px; background-color: #ccc; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 14px;">
                            -
                        </div>
                    </div>
                    <h3>Belum Ada Data</h3>
                    <p>Metadata statistik belum tersedia</p>
                </div>
                @endforelse
            </div>
            
            <h1 class="main-title">Output Desa Cantik</h1>
            <div class="grid-wrapper">
                @forelse($outputPrograms as $index => $program)
                <div class="card {{ $loop->index % 2 == 0 ? 'bg-cream' : 'bg-pink' }}">
                    <div class="icon-box">
                        <i class="fa-solid fa-{{ $loop->index % 3 == 0 ? 'clipboard-list' : ($loop->index % 3 == 1 ? 'database' : 'book-open') }}"></i>
                    </div>
                    <h3>{{ $program->judul_program }}</h3>
                    <p>{{ $program->deskripsi_program }}</p>
                    <a href="/desa-cantik/output/{{ $program->id_program }}" class="detail-btn">
                        Lihat Detail
                    </a>
                </div>
                @empty
                <div class="card bg-cream">
                    <div class="icon-box">
                        <i class="fa-solid fa-clipboard-list"></i>
                    </div>
                    <h3>Belum Ada Data</h3>
                    <p>Output program Desa Cantik belum tersedia</p>
                </div>
                @endforelse
            </div>
            
            <h2 class="section-title">Galeri Kegiatan</h2>
            <div class="grid-3">
                @forelse($galeri as $item)
                <div class="gallery-card">
                    @if($item->foto)
                    <div class="gallery-img-container">
                        <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->judul_foto }}" class="gallery-img">
                    </div>
                    @else
                    <div class="gallery-img-placeholder"><i class="far fa-image"></i></div>
                    @endif
                    <div class="gallery-content">
                        <div class="gallery-title">{{ $item->judul_foto }}</div>
                        <div class="gallery-subtitle">{{ is_string($item->tanggal_kegiatan) ? \Carbon\Carbon::parse($item->tanggal_kegiatan)->format('d M Y') : $item->tanggal_kegiatan->format('d M Y') }}</div>
                    </div>
                </div>
                @empty
                <div class="gallery-card">
                    <div class="gallery-img-placeholder"><i class="far fa-image"></i></div>
                    <div class="gallery-content">
                        <div class="gallery-title">Belum ada kegiatan</div>
                        <div class="gallery-subtitle">Kegiatan akan segera ditampilkan</div>
                    </div>
                </div>
                @endforelse
            </div>

            <h2 class="section-title">Prestasi & Penghargaan</h2>
            <div class="grid-3">
                @forelse($prestasi as $item)
                <div class="info-card card-theme-orange">
                    <div class="icon-box"><i class="fas fa-medal"></i></div>
                    <p class="achievement-year">{{ $item->tahun }}</p>
                    <p>{{ $item->judul }}</p>
                </div>
                @empty
                <div class="info-card card-theme-orange">
                    <div class="icon-box"><i class="fas fa-medal"></i></div>
                    <p class="achievement-year">-</p>
                    <p>Belum ada prestasi</p>
                </div>
                @endforelse
            </div>

        </div> </main>
@endsection
