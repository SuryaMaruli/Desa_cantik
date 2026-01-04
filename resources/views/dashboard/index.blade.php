@extends('layouts.app')

@section('title', 'Beranda - Kelurahan Citangkil')

@section('content')
    <style>
        /* --- RESET & GLOBAL --- */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Roboto', sans-serif; background-color: #ffffff; color: #333; overflow-x: hidden; }

        /* --- HEADER --- */
        .hero-section {
            background-color: #037d58;
            color: #ffffff;
            text-align: center;
            position: relative;
            padding-top: 100px;
            padding-bottom: 220px;
        }
        .icon-circle {
            background: #ffffff; width: 85px; height: 85px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 30px auto; box-shadow: 0 4px 10px rgba(0,0,0,0.15);
        }
        .icon-circle i { color: #037d58; font-size: 36px; }
        .hero-section h1 { font-size: 2.8rem; font-weight: 400; margin-bottom: 25px; text-transform: uppercase; }
        .description { font-size: 1.1rem; font-weight: 300; line-height: 1.8; margin-bottom: 40px; }
        .description span { display: block; }
        .contacts { display: flex; justify-content: center; gap: 40px; font-weight: 300; }
        .contacts div { display: flex; align-items: center; gap: 10px; }
        
        /* Wave S-Curve */
        .wave-container { position: absolute; bottom: -1px; left: 0; width: 100%; overflow: hidden; line-height: 0; }
        .wave-container svg { position: relative; display: block; width: calc(100% + 1.3px); height: 160px; }
        .wave-fill { fill: #ffffff; }

        /* --- FITUR UTAMA --- */
        .features-section { padding: 0 20px 80px 20px; max-width: 1200px; margin: 0 auto; margin-top: -50px; position: relative; z-index: 2; }
        .section-header { text-align: center; margin-bottom: 50px; }
        .section-header h2 { color: #037d58; font-size: 2rem; font-weight: 500; margin-bottom: 10px; text-transform: uppercase; }
        .section-header .underline { width: 70px; height: 4px; background-color: #037d58; margin: 0 auto; border-radius: 2px; }
        .cards-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px; }
        
        .card { border-radius: 20px; padding: 35px 30px; display: flex; flex-direction: column; transition: 0.3s; box-shadow: 0 5px 20px rgba(0,0,0,0.03); border: 1px solid rgba(0,0,0,0.02); }
        .card:hover { transform: translateY(-8px); box-shadow: 0 10px 30px rgba(0,0,0,0.08); }
        .icon-box { width: 60px; height: 60px; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-bottom: 25px; font-size: 26px; }
        .card h3 { font-size: 1.2rem; margin-bottom: 15px; font-weight: 500; }
        .card p { font-size: 0.95rem; color: #555; line-height: 1.6; margin-bottom: 30px; flex-grow: 1; }
        .card-btn { text-decoration: none; padding: 12px 0; border-radius: 8px; color: white; font-weight: 500; display: flex; align-items: center; justify-content: center; gap: 10px; width: 100%; transition: 0.3s; }
        
        /* Tema Warna */
        .theme-green { background: #eefcf5; } .theme-green .icon-box { background: #d1f7e3; color: #009665; } .theme-green .card-btn { background: #009665; }
        .theme-blue { background: #eef6ff; } .theme-blue .icon-box { background: #dbeafe; color: #1869f5; } .theme-blue .card-btn { background: #1869f5; }
        .theme-purple { background: #fcf2ff; } .theme-purple .icon-box { background: #f3d9fa; color: #9700f5; } .theme-purple .card-btn { background: #9700f5; }
        .theme-orange { background: #fffbf0; } .theme-orange .icon-box { background: #ffecc2; color: #e67e00; } .theme-orange .card-btn { background: #e67e00; }
        .theme-red { background: #fff0f3; } .theme-red .icon-box { background: #ffccd5; color: #f5003d; } .theme-red .card-btn { background: #f5003d; }

        /* --- SAMBUTAN LURAH --- */
        .lurah-section { padding: 60px 20px 100px 20px; background-color: #eafaf6; }
        .lurah-card { max-width: 1000px; margin: 0 auto; background: #ffffff; border-radius: 30px; display: flex; box-shadow: 0 10px 40px rgba(0,0,0,0.08); overflow: hidden; }
        .lurah-left { flex: 4; background-color: #009670; padding: 40px; display: flex; flex-direction: column; align-items: center; justify-content: center; }
        .photo-frame { background: #fff; border-radius: 20px; width: 100%; max-width: 260px; height: 300px; margin-bottom: 20px; overflow: hidden; }
        .photo-frame img { width: 100%; height: 100%; object-fit: cover; }
        .name-label { background: #004d3d; width: 100%; max-width: 260px; padding: 15px; border-radius: 12px; text-align: center; color: #fff; }
        .lurah-right { flex: 6; padding: 50px; display: flex; flex-direction: column; justify-content: center; }
        .quote-icon { font-size: 40px; color: #8cebc6; margin-bottom: 20px; }
        .btn-sambutan { background: #009665; color: white; padding: 12px 30px; border-radius: 8px; text-decoration: none; font-weight: 500; width: fit-content; margin-top: 10px; }

        /* --- INFO PUBLIK (NEW) --- */
        .info-section { padding: 60px 20px 100px 20px; background-color: #ffffff; }
        .info-grid { max-width: 1200px; margin: 0 auto; display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 30px; }
        .info-card { background: #fff; border: 1px solid #eeeeee; border-radius: 16px; padding: 30px; box-shadow: 0 4px 15px rgba(0,0,0,0.03); display: flex; flex-direction: column; transition: 0.3s; }
        .info-card:hover { transform: translateY(-5px); box-shadow: 0 10px 25px rgba(0,0,0,0.08); border-color: #e0e0e0; }
        .info-icon { width: 50px; height: 50px; background-color: #00cba9; color: white; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 22px; margin-bottom: 20px; }
        .info-card h4 { font-size: 1.1rem; color: #333; margin-bottom: 10px; font-weight: 600; min-height: 3rem; }
        .info-card p { font-size: 0.9rem; color: #666; line-height: 1.6; margin-bottom: 20px; flex-grow: 1; }
        .info-link { color: #00cba9; text-decoration: none; font-weight: 500; font-size: 0.9rem; display: inline-flex; align-items: center; gap: 8px; transition: gap 0.3s; }
        .info-link:hover { gap: 12px; }

        /* --- RESPONSIVE --- */
        @media (max-width: 768px) {
            .hero-section { padding-top: 60px; padding-bottom: 180px; }
            .hero-section h1 { font-size: 1.8rem; }
            .contacts { flex-direction: column; gap: 15px; }
            .cards-grid, .info-grid { grid-template-columns: 1fr; }
            .lurah-card { flex-direction: column; }
            .lurah-left, .lurah-right { padding: 30px; }
        }
    </style>

    <div class="hero-section">
        <div class="icon-circle"><i class="fas fa-map-marker-alt"></i></div>
        <h1>Kelurahan Citangkil</h1>
        <div class="description">
            <span>Dapori Pembuasan Desa Cantik oleh RPS Kota Cilegon</span>
            <span>Mitra Mobular Kelurahan Citangkil</span>
            <span>Kecamatan Citangkil, Kota Cilegon</span>
        </div>
        <div class="contacts">
            <div><i class="fas fa-phone-alt"></i> (0254) 123-4567</div>
            <div><i class="far fa-envelope"></i> kelurahan@citangkil.go.id</div>
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
            <div class="card theme-green">
                <div class="icon-box"><i class="far fa-check-circle"></i></div>
                <h3>Profil Kelurahan</h3>
                <p>Informasi lengkap tentang sejarah, visi misi, dan struktur organisasi Kelurahan Citangkil</p>
                <a href="/profil" class="card-btn">Selengkapnya <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="card theme-blue">
                <div class="icon-box"><i class="fas fa-bullseye"></i></div>
                <h3>Layanan Masyarakat</h3>
                <p>Berbagai layanan administrasi dan pelayanan publik untuk kemudahan masyarakat</p>
                <a href="/layanan" class="card-btn">Selengkapnya <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="card theme-purple">
                <div class="icon-box"><i class="far fa-chart-bar"></i></div>
                <h3>Data</h3>
                <p>Data statistik dan informasi kependudukan Kelurahan Citangkil yang transparan</p>
                <a href="/data" class="card-btn">Akses Data <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="card theme-orange">
                <div class="icon-box"><i class="fas fa-home"></i></div>
                <h3>Desa Cantik</h3>
                <p>Program pembangunan dan pengembangan desa untuk meningkatkan kualitas lingkungan</p>
                <a href="/desa-cantik" class="card-btn">Lihat Galeri <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="card theme-red">
                <div class="icon-box"><i class="far fa-newspaper"></i></div>
                <h3>Berita & Informasi</h3>
                <p>Update terkini seputar kegiatan, pengumuman, dan berita dari Kelurahan Citangkil</p>
                <a href="/berita" class="card-btn">Baca Berita <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
    </section>

    <section class="lurah-section">
        <div class="section-header">
            <h2>LURAH CITANGKIL</h2>
            <div class="underline"></div>
        </div>
        <div class="lurah-card">
            <div class="lurah-left">
                <div class="photo-frame">
                    <img src="https://via.placeholder.com/300x400/eeeeee/999999?text=FOTO+LURAH" alt="Foto Lurah">
                </div>
                <div class="name-label">
                    <span>Lurah Citangkil</span>
                    <h3>M. ALI WAHIDI, S.Sos.M.Si</h3>
                </div>
            </div>
            <div class="lurah-right">
                <i class="fas fa-quote-left quote-icon"></i>
                <p>"Situs web ini kami hadirkan sebagai wadah untuk mempublikasi atau informasi kepada masyarakat..."</p>
                <p>"Kami berkomitmen untuk terus memberikan layanan terbaik, transparan..."</p>
                <a href="#" class="btn-sambutan">Baca Sambutan Lengkap</a>
            </div>
        </div>
    </section>

    <section class="info-section">
        <div class="info-grid">
            <div class="info-card">
                <div class="info-icon"><i class="far fa-building"></i></div>
                <h4>Lembaga Kemasyarakatan</h4>
                <p>Informasi lengkap tentang lembaga-lembaga yang ada di Kelurahan Citangkil.</p>
                <a href="#" class="info-link">Pelajari lebih lanjut <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="info-card">
                <div class="info-icon"><i class="fas fa-users"></i></div>
                <h4>Lembaga Pemberdayaan Masyarakat</h4>
                <p>Program pemberdayaan untuk meningkatkan kesejahteraan masyarakat.</p>
                <a href="#" class="info-link">Pelajari lebih lanjut <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="info-card">
                <div class="info-icon"><i class="far fa-calendar-alt"></i></div>
                <h4>Agenda & Kegiatan</h4>
                <p>Jadwal kegiatan dan acara yang akan dilaksanakan di kelurahan.</p>
                <a href="#" class="info-link">Pelajari lebih lanjut <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="info-card">
                <div class="info-icon"><i class="far fa-file-alt"></i></div>
                <h4>Dokumen Publik</h4>
                <p>Akses dokumen dan peraturan yang dapat diakses oleh masyarakat.</p>
                <a href="#" class="info-link">Pelajari lebih lanjut <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
    </section>
@endsection
