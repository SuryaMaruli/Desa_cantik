@extends('layouts.app')

@section('title', 'Berita & Informasi - Kelurahan Gunung Sugih')

@section('content')
    <style>
        /* =========================================
           1. RESET & BASE STYLES
           ========================================= */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
        }

body {
            background-color: #f9fafb; 
            /* Padding-top 80px untuk mengakomodasi fixed navbar */
            padding-top: 80px;
            padding-left: 0;
            padding-right: 0;
            padding-bottom: 0;
            margin: 0;
            color: #333;
        }

/* Container untuk membungkus konten agar rapi di tengah */
        .container {
            width: 95%;
            max-width: none;
            margin: 0 auto;
            padding: 0 20px;
            padding-bottom: 60px;
        }

/* =========================================
           2. HEADER SECTION
           ========================================= */
.main-header {
            background-color: #F6903A;
            color: white;
            padding-top: 60px;
            padding-bottom: 40px;
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

        /* Override container untuk main content */
        main {
            padding-top: 40px;
            padding-bottom: 80px;
        }

        main .container {
            max-width: 1100px;
        }

        /* =========================================
           3. NAVIGATION
           ========================================= */
        .nav-tabs-wrapper {
            position: relative;
            margin-bottom: 40px;
            margin-top: 36px;
        }
        
        .nav-tabs {
            display: flex;
            gap: 12px;
            list-style: none;
            overflow-x: auto;
            padding-bottom: 5px;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
        }
        .nav-tabs::-webkit-scrollbar { display: none; }

        .nav-item {
            padding: 10px 24px;
            border-radius: 50px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            white-space: nowrap;
            background-color: #fff;
            border: 1px solid #e5e7eb;
            color: #6b7280;
            transition: all 0.2s ease;
            box-shadow: 0 2px 5px rgba(0,0,0,0.03);
        }

        /* Style Active Merah/Oranye */
        .nav-item.active {
            background: #F03E15; /* Merah Oranye Solid */
            color: white;
            border: 1px solid #F03E15;
            box-shadow: 0 4px 10px rgba(240, 62, 21, 0.3);
        }

        .nav-item:hover:not(.active) {
            background-color: #f3f4f6;
            color: #111;
        }

        /* =========================================
           4. HERO SECTION (Berita Utama)
           ========================================= */
        .section-title {
            color: #1f3b5d;
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .hero-card {
            background-color: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            display: flex;
            overflow: hidden;
            min-height: 420px;
            margin-bottom: 60px;
            transition: transform 0.3s ease;
            border: 1px solid #f0f0f0;
        }

        .hero-image {
            flex: 1;
            background-color: #fff; /* Area gambar putih/kosong sesuai gambar */
            /* Jika nanti ada gambar: background-image: url(...); */
            position: relative;
        }

        .hero-content {
            flex: 1.2;
            padding: 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .hero-badge {
            display: inline-block;
            background-color: #FEF3C7; /* Kuning pucat */
            color: #D97706; /* Emas gelap */
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 20px;
            align-self: flex-start;
        }

        .hero-title {
            font-size: 32px;
            line-height: 1.3;
            color: #1F2937;
            margin-bottom: 15px;
            font-weight: 700;
        }

        .hero-desc {
            color: #6B7280;
            line-height: 1.7;
            font-size: 16px;
            margin-bottom: 25px;
        }

        /* =========================================
           5. GRID SECTION (Berita Terbaru)
           ========================================= */
        .latest-section-label {
            color: #1f3b5d;
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 25px;
        }

        .grid-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }

        .grid-card {
            background-color: white;
            border-radius: 16px;
            padding: 30px; /* Padding lebih besar agar lega */
            box-shadow: 0 4px 15px rgba(0,0,0,0.03);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 380px;
            position: relative;
            border: 1px solid #f3f4f6;
            transition: all 0.3s ease;
        }

        .grid-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.08);
        }

        /* Placeholder Gambar Grid (Hapus background color jika ingin putih polos seperti gambar) */
        .grid-card-img-placeholder {
            height: 140px;
            background-color: transparent; 
            border-radius: 12px;
            margin-bottom: 10px;
        }

        /* Badge Grid (Pojok Kanan Atas) */
        .grid-badge {
            position: absolute;
            top: 30px;
            right: 30px;
            padding: 5px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        /* Variasi Warna Badge */
        .badge-kesehatan { background-color: #FFEDD5; color: #C2410C; }
        .badge-sosial { background-color: #FCE7F3; color: #BE185D; }
        .badge-lingkungan { background-color: #FFEDD5; color: #C2410C; }
        .badge-ekonomi { background-color: #FEF9C3; color: #A16207; }
        .badge-program { background-color: #FEE2E2; color: #B91C1C; }
        .badge-kegiatan { background-color: #FFEDD5; color: #C2410C; }

        .grid-title {
            font-size: 18px;
            font-weight: 700;
            color: #333;
            margin-bottom: 12px;
            line-height: 1.4;
        }

        .grid-desc {
            font-size: 14px;
            color: #666;
            line-height: 1.6;
            margin-bottom: 20px;
            display: -webkit-box;
            -webkit-line-clamp: 4; /* Tampilkan 4 baris teks */
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* =========================================
           6. COMPONENTS (Meta & Buttons)
           ========================================= */
        .meta-info {
            display: flex;
            align-items: center;
            gap: 15px;
            color: #9CA3AF;
            font-size: 13px;
            margin-bottom: 20px;
        }
        
        .meta-item {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        /* Tombol Baca Selengkapnya (Hero) - Merah Oranye */
        .btn-read-more {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            background-color: #F03E15; /* Merah sesuai gambar */
            color: white;
            text-decoration: none;
            padding: 12px 24px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 14px;
            width: fit-content;
            transition: opacity 0.3s;
            box-shadow: 0 4px 12px rgba(240, 62, 21, 0.2);
        }
        .btn-read-more:hover { opacity: 0.9; }

        /* Link Baca Selengkapnya (Grid) - Teks Oranye */
        .grid-link {
            color: #F03E15;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            transition: gap 0.2s;
        }
        .grid-link:hover { gap: 8px; }

/* =========================================
           7. RESPONSIVE
           ========================================= */
@media (max-width: 768px) {
            .main-header {
                padding: 20px 20px;
                margin-top: 0;
            }
            .main-header h1 {
                font-size: 2rem;
            }
            .main-header .subtitle {
                font-size: 15px;
                line-height: 1.7;
                max-width: 100%;
            }
            .hero-card { flex-direction: column; min-height: auto; }
            .hero-image { min-height: 200px; width: 100%; }
            .hero-content { padding: 25px; }
            .hero-title { font-size: 24px; }
            .grid-container { grid-template-columns: 1fr; }
        }
    </style>

<header class="main-header">
        <div class="container">
            <h1>Berita & Informasi</h1>
            <p class="subtitle">Update terkini seputar kegiatan, pengumuman, dan berita dari Kelurahan Gunung Sugih</p>
            <p class="subtitle">Kelurahan Gunung Sugih</p>
        </div>
</header>

<main>
        <div class="container">
        
        <div class="nav-tabs-wrapper">
            <ul class="nav-tabs">
                <li class="nav-item {{ !$kategori || $kategori === 'Semua' ? 'active' : '' }}" onclick="filterKategori('Semua')">Semua</li>
                @if($kategoriList && $kategoriList->count() > 0)
                    @foreach($kategoriList as $kat)
                        <li class="nav-item {{ $kategori === $kat ? 'active' : '' }}" onclick="filterKategori('{{ $kat }}')">{{ $kat }}</li>
                    @endforeach
                @endif
            </ul>
        </div>

@if($beritaUtama || $berita->count() > 0)
            <!-- Berita Utama (Diprioritaskan dari is_utama) -->
            @php
                $heroBerita = $beritaUtama;
                $otherBerita = $berita;
            @endphp
            
            @if($heroBerita)
                <h2 class="section-title">Berita Utama</h2>
                
                <article class="hero-card">
                    <div class="hero-image">
                        @if($heroBerita->gambar)
                            <div style="width: 100%; height: 100%; background-image: url('{{ asset('storage/berita/' . $heroBerita->gambar) }}'); background-size: cover; background-position: center; border-radius: 20px 0 0 20px; min-height: 420px;"></div>
                        @else
                            <div style="width: 100%; height: 100%; background: linear-gradient(135deg, #f0f0f0 0%, #e0e0e0 100%); display: flex; align-items: center; justify-content: center; color: #9CA3AF; font-size: 4rem; border-radius: 20px 0 0 20px;">
                                📰
                            </div>
                        @endif
                        <span class="hero-badge">{{ $heroBerita->kategori ?? 'Umum' }}</span>
                    </div>

                    <div class="hero-content">
                        <h3 class="hero-title">{{ $heroBerita->judul }}</h3>
                        
                        <p class="hero-desc">
                            {{ Str::limit(strip_tags($heroBerita->konten), 200) }}
                        </p>
                        
                        <div class="meta-info">
                            <div class="meta-item">
                                <svg width="14" height="14" fill="currentColor" viewBox="0 0 16 16"><path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/></svg>
                                {{ \Carbon\Carbon::parse($heroBerita->tanggal_publikasi)->format('d F Y') }}
                            </div>
                            <div class="meta-item">
                                <svg width="14" height="14" fill="currentColor" viewBox="0 0 16 16"><path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4z"/></svg>
                                {{ $heroBerita->penulis ?? 'Admin Kelurahan' }}
                            </div>
                        </div>

                        <a href="/berita/{{ $heroBerita->id }}" class="btn-read-more">
                            Baca Selengkapnya <span>&rarr;</span>
                        </a>
                    </div>
                </article>
            @endif

            <!-- Berita Terbaru -->
            @if($otherBerita->count() > 0)
                <h2 class="latest-section-label">Berita Terbaru</h2>

                <div class="grid-container">
@foreach($otherBerita as $item)
                        <div class="grid-card">
                            <span class="grid-badge badge-{{ strtolower($item->kategori ?? 'program') }}">{{ $item->kategori ?? 'Umum' }}</span>
                            @if($item->gambar)
                                <div class="grid-card-img-placeholder" style="background-image: url('{{ asset('storage/berita/' . $item->gambar) }}'); background-size: cover; background-position: center; border-radius: 12px; background-color: #f9fafb;"></div>
                            @else
                                <div class="grid-card-img-placeholder" style="background: linear-gradient(135deg, #f0f0f0 0%, #e0e0e0 100%); display: flex; align-items: center; justify-content: center; color: #9CA3AF; font-size: 3rem;">
                                    📰
                                </div>
                            @endif
                            
                            <div>
                                <h3 class="grid-title">{{ $item->judul }}</h3>
                                <p class="grid-desc">
                                    {{ Str::limit(strip_tags($item->konten), 150) }}
                                </p>
                            </div>

                            <div style="margin-top: auto;">
                                <div class="meta-info">
                                    <svg width="14" height="14" fill="currentColor" viewBox="0 0 16 16"><path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/></svg>
                                    {{ \Carbon\Carbon::parse($item->tanggal_publikasi)->format('d F Y') }}
                                </div>
                                <a href="/berita/{{ $item->id }}" class="grid-link">
                                    Baca Selengkapnya <span>&rarr;</span>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        @else
            <!-- Empty State -->
            <div style="text-align: center; padding: 100px 20px;">
                <div style="width: 120px; height: 120px; margin: 0 auto 30px; background: linear-gradient(135deg, #FF7E30 0%, #F35F12 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 3rem;">
                    📰
                </div>
                <h1 style="font-size: 2rem; color: #1F2937; margin-bottom: 15px; font-weight: 600;">Belum Ada Berita</h1>
                <p style="font-size: 1.1rem; color: #6B7280; line-height: 1.6;">
                    Saat ini belum ada berita yang tersedia. Silakan kembali lagi beberapa saat lagi untuk mendapatkan informasi terbaru.
                </p>
            </div>
        @endif
</div>
</main>

    <script>
        function filterKategori(kategori) {
            const url = new URL(window.location);
            if (kategori === 'Semua') {
                url.searchParams.delete('kategori');
            } else {
                url.searchParams.set('kategori', kategori);
            }
            window.location.href = url.toString();
        }
    </script>
@endsection
