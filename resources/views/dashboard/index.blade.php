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

        /* --- RESPONSIVE --- */
        @media (max-width: 900px) {
            .lurah-card { flex-direction: column; }
            .lurah-left { padding: 40px 20px; }
            .lurah-right { padding: 40px 25px; }
            .contacts { flex-direction: column; gap: 15px; }
            .hero-section h1 { font-size: 1.8rem; }
            .info-card { padding: 25px; }
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
                <a href="#sambutan-lengkap" class="btn-sambutan">Baca Sambutan Lengkap</a>
            </div>
        </div>
    </section>

    <section class="info-section">
        <div class="info-header">
            <h2>INFORMASI PUBLIK</h2>
        </div>
        <div class="info-grid">
            @forelse($informasiPubliks ?? \App\Models\InformasiPublik::all() as $index => $item)
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
                <h4>Agenda & Kegiatan</h4>
                <p>Jadwal kegiatan dan acara yang akan dilaksanakan di kelurahan.</p>
                <a href="#" class="info-link">Pelajari lebih lanjut <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="info-card">
                <div class="info-icon">4</div>
                <h4>Dokumen Publik</h4>
                <p>Akses dokumen dan peraturan yang dapat diakses oleh masyarakat.</p>
                <a href="#" class="info-link">Pelajari lebih lanjut <i class="fas fa-arrow-right"></i></a>
            </div>
            @endforelse
        </div>
    </section>

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
            display: grid;
            grid-template-columns: repeat(1, 1fr);
            gap: 14px;
        }

        @media (min-width: 768px) {
            .visit-stats-grid {
                grid-template-columns: repeat(3, 1fr);
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
        $visitStats = $visitStats ?? ['weekly' => 0, 'monthly' => 0, 'total' => 0];
    @endphp
    <section class="visit-stats-section">
        <div class="visit-stats-container">
            <h2 class="visit-stats-title">Jumlah Kunjungan Website</h2>
            <div class="visit-stats-grid">
                <div class="visit-stat-card">
                    <p class="visit-stat-label">Mingguan</p>
                    <p class="visit-stat-value">{{ number_format($visitStats['weekly'] ?? 0, 0, ',', '.') }}</p>
                </div>
                <div class="visit-stat-card">
                    <p class="visit-stat-label">Bulanan</p>
                    <p class="visit-stat-value">{{ number_format($visitStats['monthly'] ?? 0, 0, ',', '.') }}</p>
                </div>
                <div class="visit-stat-card">
                    <p class="visit-stat-label">Total</p>
                    <p class="visit-stat-value">{{ number_format($visitStats['total'] ?? 0, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
    </section>
@endsection
