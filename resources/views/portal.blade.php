<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Desa Cantik - Pilih Website Kelurahan</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        :root {
            --ink: #172026;
            --muted: #5e6b73;
            --surface: rgba(255, 255, 255, 0.86);
            --line: rgba(23, 32, 38, 0.12);
            --orange: #f47f24;
            --green: #198754;
            --teal: #0f9f9a;
            --yellow: #f5b642;
            --shadow: 0 24px 70px rgba(23, 32, 38, 0.16);
        }

        * { box-sizing: border-box; }
        html { scroll-behavior: smooth; }

        body {
            margin: 0;
            min-height: 100vh;
            color: var(--ink);
            font-family: Inter, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background:
                radial-gradient(circle at 14% 18%, rgba(244, 127, 36, 0.22), transparent 30%),
                radial-gradient(circle at 82% 12%, rgba(15, 159, 154, 0.18), transparent 28%),
                linear-gradient(135deg, #fffaf2 0%, #eff9f6 48%, #fff7ed 100%);
            overflow-x: hidden;
        }

        body::before {
            content: "";
            position: fixed;
            inset: 0;
            background-image:
                linear-gradient(rgba(23, 32, 38, 0.04) 1px, transparent 1px),
                linear-gradient(90deg, rgba(23, 32, 38, 0.04) 1px, transparent 1px);
            background-size: 48px 48px;
            mask-image: linear-gradient(to bottom, rgba(0, 0, 0, 0.7), transparent 78%);
            pointer-events: none;
        }

        a { color: inherit; }

        .portal-shell {
            position: relative;
            z-index: 1;
            width: min(1180px, calc(100% - 36px));
            min-height: 100vh;
            margin: 0 auto;
            padding: 28px 0 34px;
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        .portal-nav {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
        }

        .brand {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            min-width: 0;
        }

        .brand-mark {
            width: 46px;
            height: 46px;
            border-radius: 14px;
            display: grid;
            place-items: center;
            background: #fff;
            border: 1px solid rgba(244, 127, 36, 0.28);
            box-shadow: 0 10px 28px rgba(244, 127, 36, 0.18);
        }

        .brand-mark img {
            width: 30px;
            height: 30px;
            object-fit: contain;
        }

        .brand-title {
            display: block;
            font-size: 15px;
            font-weight: 800;
            text-transform: uppercase;
        }

        .brand-subtitle {
            display: block;
            margin-top: 2px;
            color: var(--muted);
            font-size: 12px;
            font-weight: 600;
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .partner-logos {
            display: flex;
            align-items: center;
            gap: 18px;
        }

        .partner-logo {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            line-height: 0;
        }

        .partner-logo img {
            display: block;
            width: auto;
            max-width: 132px;
            max-height: 42px;
            object-fit: contain;
        }

        .partner-logo--bps img {
            max-width: 108px;
            max-height: 44px;
        }

        .partner-logo--wbk img {
            max-width: 82px;
            max-height: 44px;
        }

        .partner-logo--dc img {
            max-width: 78px;
            max-height: 44px;
        }

        .icon-button {
            width: 42px;
            height: 42px;
            border: 1px solid var(--line);
            border-radius: 12px;
            display: inline-grid;
            place-items: center;
            color: var(--ink);
            background: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            transition: transform 0.2s ease, background-color 0.2s ease, border-color 0.2s ease;
        }

        .icon-button:hover,
        .icon-button:focus-visible {
            transform: translateY(-2px);
            background: #fff;
            border-color: rgba(244, 127, 36, 0.45);
            outline: none;
        }

        .portal-user-menu {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            min-width: 0;
            padding: 7px 8px 7px 12px;
            border: 1px solid rgba(244, 127, 36, 0.2);
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.72);
            backdrop-filter: blur(12px);
        }

        .portal-user-greeting {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            min-width: 0;
            color: var(--ink);
            font-size: 13px;
            font-weight: 700;
            white-space: nowrap;
        }

        .portal-user-greeting i {
            color: var(--orange);
            font-size: 17px;
        }

        .portal-user-greeting span {
            max-width: 210px;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .portal-logout-form {
            margin: 0;
        }

        .portal-logout-button {
            width: 34px;
            height: 34px;
            border: 0;
            border-radius: 50%;
            display: inline-grid;
            place-items: center;
            color: #ffffff;
            background: var(--orange);
            cursor: pointer;
            transition: transform 0.2s ease, background-color 0.2s ease;
        }

        .portal-logout-button:hover,
        .portal-logout-button:focus-visible {
            transform: translateY(-2px);
            background: #dc6f1d;
            outline: none;
        }

        .hero {
            display: grid;
            grid-template-columns: minmax(0, 1.02fr) minmax(320px, 0.98fr);
            align-items: center;
            gap: 34px;
            flex: 1;
        }

        .hero-copy { padding: 24px 0; }

        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 18px;
            padding: 9px 12px;
            border: 1px solid rgba(25, 135, 84, 0.18);
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.62);
            color: #136d45;
            font-size: 13px;
            font-weight: 800;
        }

        h1 {
            margin: 0;
            max-width: 720px;
            font-size: clamp(34px, 7vw, 82px);
            line-height: 0.96;
            letter-spacing: 0;
            font-weight: 800;
        }

        .accent { color: var(--orange); }

        .lead {
            max-width: 650px;
            margin: 22px 0 0;
            color: var(--muted);
            font-size: clamp(16px, 2vw, 19px);
            line-height: 1.7;
        }

        .search-row {
            display: flex;
            align-items: center;
            gap: 12px;
            width: min(620px, 100%);
            margin-top: 28px;
            padding: 10px 12px;
            border: 1px solid rgba(23, 32, 38, 0.12);
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.78);
            box-shadow: 0 16px 34px rgba(23, 32, 38, 0.08);
        }

        .search-row i {
            color: var(--orange);
            font-size: 20px;
        }

        .search-row input {
            width: 100%;
            min-height: 34px;
            border: 0;
            color: var(--ink);
            background: transparent;
            font: inherit;
            font-size: 15px;
            outline: none;
        }

        .empty-state {
            display: none;
            margin-top: 14px;
            color: #7b2b1e;
            font-size: 14px;
            font-weight: 700;
        }

        .empty-state.show { display: block; }

        .quick-stats {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 12px;
            max-width: 590px;
            margin-top: 30px;
        }

        .stat {
            min-height: 98px;
            padding: 16px;
            border: 1px solid var(--line);
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.68);
            backdrop-filter: blur(12px);
        }

        .stat strong {
            display: block;
            font-size: 30px;
            line-height: 1;
        }

        .stat span {
            display: block;
            margin-top: 8px;
            color: var(--muted);
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .portal-panel {
            position: relative;
            padding: 16px;
            border: 1px solid rgba(255, 255, 255, 0.8);
            border-radius: 22px;
            background: rgba(255, 255, 255, 0.58);
            box-shadow: var(--shadow);
            backdrop-filter: blur(18px);
        }

        .map-stage {
            position: relative;
            min-height: 560px;
            border-radius: 16px;
            overflow: hidden;
            background: linear-gradient(135deg, rgba(25, 135, 84, 0.14), rgba(244, 127, 36, 0.08)), #fff;
        }

        .map-stage::before {
            content: "";
            position: absolute;
            inset: 22px;
            border: 1px dashed rgba(23, 32, 38, 0.18);
            border-radius: 18px;
        }

        .route-line {
            position: absolute;
            inset: 70px 62px 92px;
            border: 2px solid rgba(15, 159, 154, 0.34);
            border-left-color: transparent;
            border-bottom-color: rgba(244, 127, 36, 0.32);
            border-radius: 42% 58% 44% 56%;
            animation: floatRoute 7s ease-in-out infinite;
        }

        .route-line:nth-child(2) {
            inset: 132px 92px 130px 82px;
            border-color: rgba(245, 182, 66, 0.36);
            border-right-color: transparent;
            animation-delay: -2.8s;
        }

        .village-card {
            display: block;
            position: absolute;
            width: min(280px, calc(100% - 36px));
            padding: 17px;
            border: 1px solid rgba(255, 255, 255, 0.94);
            border-radius: 8px;
            background: var(--surface);
            box-shadow: 0 16px 36px rgba(23, 32, 38, 0.13);
            text-decoration: none;
            backdrop-filter: blur(16px);
            transform: translateY(0);
            transition: transform 0.24s ease, box-shadow 0.24s ease, border-color 0.24s ease;
        }

        .village-card:hover,
        .village-card:focus-visible {
            transform: translateY(-8px) scale(1.01);
            border-color: rgba(244, 127, 36, 0.54);
            box-shadow: 0 24px 54px rgba(23, 32, 38, 0.19);
            outline: none;
        }

        .village-card:nth-of-type(1) { top: 44px; left: 34px; }
        .village-card:nth-of-type(2) { top: 212px; right: 30px; }
        .village-card:nth-of-type(3) { left: 68px; bottom: 42px; }

        .card-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .pin {
            width: 43px;
            height: 43px;
            border-radius: 14px;
            display: grid;
            place-items: center;
            color: #fff;
            background: var(--orange);
            box-shadow: 0 12px 26px rgba(244, 127, 36, 0.26);
        }

        .village-card:nth-of-type(2) .pin { background: var(--green); box-shadow: 0 12px 26px rgba(25, 135, 84, 0.22); }
        .village-card:nth-of-type(3) .pin { background: var(--teal); box-shadow: 0 12px 26px rgba(15, 159, 154, 0.22); }

        .arrow {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            display: grid;
            place-items: center;
            color: var(--orange);
            background: #fff6ed;
        }

        .village-card h2 {
            margin: 16px 0 6px;
            font-size: 21px;
            line-height: 1.2;
        }

        .village-card p {
            margin: 0;
            color: var(--muted);
            font-size: 14px;
            line-height: 1.55;
        }

        .meta {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 15px;
            color: #40505a;
            font-size: 13px;
            font-weight: 700;
        }

        .pulse-dot {
            position: absolute;
            width: 14px;
            height: 14px;
            border-radius: 50%;
            background: var(--orange);
            box-shadow: 0 0 0 0 rgba(244, 127, 36, 0.42);
            animation: pulse 2s infinite;
        }

        .dot-one { top: 184px; left: 326px; }
        .dot-two { right: 280px; bottom: 188px; background: var(--green); box-shadow: 0 0 0 0 rgba(25, 135, 84, 0.42); animation-delay: -0.7s; }
        .dot-three { left: 284px; bottom: 98px; background: var(--teal); box-shadow: 0 0 0 0 rgba(15, 159, 154, 0.42); animation-delay: -1.2s; }

        .hint-bar {
            position: absolute;
            right: 20px;
            bottom: 20px;
            left: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            padding: 12px 14px;
            border: 1px solid rgba(23, 32, 38, 0.08);
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.76);
            color: var(--muted);
            font-size: 13px;
            font-weight: 700;
        }

        .hint-bar span {
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        @keyframes pulse {
            70% { box-shadow: 0 0 0 16px transparent; }
            100% { box-shadow: 0 0 0 0 transparent; }
        }

        @keyframes floatRoute {
            0%, 100% { transform: translate3d(0, 0, 0) rotate(0deg); }
            50% { transform: translate3d(7px, -8px, 0) rotate(1.5deg); }
        }

        @media (max-width: 980px) {
            .portal-shell {
                width: min(720px, calc(100% - 28px));
                min-height: auto;
                padding-bottom: 28px;
            }

            .portal-nav {
                align-items: flex-start;
                flex-wrap: wrap;
            }

            .nav-actions {
                flex: 1 1 100%;
                justify-content: space-between;
                align-items: flex-start;
                gap: 14px;
            }

            .partner-logos {
                flex: 1 1 auto;
                justify-content: flex-start;
                flex-wrap: wrap;
                row-gap: 10px;
            }

            .hero {
                grid-template-columns: 1fr;
                gap: 16px;
                align-items: start;
            }

            .hero-copy { padding: 18px 0 6px; }

            .portal-panel {
                padding: 12px;
                border-radius: 16px;
            }

            .map-stage {
                min-height: auto;
                padding: 1px 0 78px;
                border-radius: 12px;
            }

            .map-stage::before,
            .route-line,
            .pulse-dot {
                display: none;
            }

            .village-card:nth-of-type(1),
            .village-card:nth-of-type(2),
            .village-card:nth-of-type(3) {
                position: relative;
                top: auto;
                right: auto;
                bottom: auto;
                left: auto;
                width: auto;
                margin: 14px;
            }
        }

        @media (max-width: 640px) {
            body::before { background-size: 34px 34px; }

            .portal-shell {
                width: min(100% - 24px, 520px);
                gap: 18px;
                padding-top: 16px;
            }

            .portal-nav { gap: 14px; }

            .brand {
                width: 100%;
                align-items: center;
            }

            .brand-mark {
                width: 42px;
                height: 42px;
                border-radius: 12px;
                flex: 0 0 auto;
            }

            .brand-title { font-size: 13px; }
            .brand-subtitle { font-size: 11px; }

            .nav-actions {
                width: 100%;
                flex-direction: column;
                align-items: stretch;
                gap: 12px;
            }

            .partner-logos {
                width: 100%;
                display: grid;
                grid-template-columns: repeat(4, minmax(0, 1fr));
                align-items: center;
                justify-items: center;
                gap: 10px;
            }

            .partner-logo {
                width: 100%;
                min-width: 0;
            }

            .partner-logo img {
                max-width: 100%;
                max-height: 34px;
            }

            .partner-logo--berakhlak img { max-height: 28px; }
            .partner-logo--bps img { max-height: 34px; }
            .partner-logo--wbk img,
            .partner-logo--dc img { max-height: 36px; }

            .icon-button {
                align-self: flex-end;
                width: 40px;
                height: 40px;
            }

            .portal-user-menu {
                width: 100%;
                justify-content: space-between;
                border-radius: 8px;
            }

            .portal-user-greeting span { max-width: calc(100vw - 132px); }

            .eyebrow {
                max-width: 100%;
                align-items: flex-start;
                border-radius: 8px;
                font-size: 12px;
                line-height: 1.35;
            }

            h1 {
                font-size: 34px;
                line-height: 1.04;
            }

            .lead {
                margin-top: 16px;
                font-size: 15px;
                line-height: 1.62;
            }

            .search-row {
                margin-top: 20px;
                padding: 9px 10px;
            }

            .quick-stats {
                grid-template-columns: 1fr;
                gap: 10px;
                margin-top: 20px;
            }

            .stat {
                min-height: auto;
                padding: 14px;
            }

            .stat strong { font-size: 26px; }

            .portal-panel {
                padding: 8px;
                box-shadow: 0 16px 42px rgba(23, 32, 38, 0.12);
            }

            .map-stage { padding: 1px 0 10px; }

            .village-card:nth-of-type(1),
            .village-card:nth-of-type(2),
            .village-card:nth-of-type(3) {
                display: block;
                margin: 10px;
                padding: 14px;
            }

            .village-card h2 {
                font-size: 18px;
                overflow-wrap: anywhere;
            }

            .village-card p {
                font-size: 13px;
            }

            .pin {
                width: 40px;
                height: 40px;
            }

            .hint-bar {
                position: relative;
                right: auto;
                bottom: auto;
                left: auto;
                margin: 10px;
                align-items: flex-start;
                flex-direction: column;
                gap: 8px;
                font-size: 12px;
            }
        }

        @media (max-width: 380px) {
            .portal-shell { width: min(100% - 18px, 360px); }
            .partner-logos { gap: 8px; }
            .partner-logo img { max-height: 30px; }
            .partner-logo--berakhlak img { max-height: 24px; }
            h1 { font-size: 30px; }
            .lead { font-size: 14px; }
            .village-card:nth-of-type(1),
            .village-card:nth-of-type(2),
            .village-card:nth-of-type(3) { margin: 8px; }
        }
    </style>
</head>
<body>
    <main class="portal-shell">
        <nav class="portal-nav" aria-label="Navigasi portal">
            <div class="brand">
                <div class="brand-mark">
                    <img src="{{ asset('favicon.ico') }}" alt="Logo Desa Cantik">
                </div>
                <div>
                    <span class="brand-title">Portal Desa Cantik</span>
                    <span class="brand-subtitle">Kota Cilegon, Banten</span>
                </div>
            </div>
            <div class="nav-actions">
                <div class="partner-logos" aria-label="Logo instansi pendukung">
                    <span class="partner-logo partner-logo--bps">
                        <img src="{{ asset('Logo BPS Cilegon Warna Biru (1).png') }}" alt="BPS Kota Cilegon">
                    </span>
                    <span class="partner-logo partner-logo--wbk">
                        <img src="{{ asset('wbk_copy.png') }}" alt="Zona Integritas WBK">
                    </span>
                    <span class="partner-logo partner-logo--berakhlak">
                        <img src="{{ asset('berakhlak-bangga-melayani-bangsa.png') }}" alt="BerAKHLAK Bangga Melayani Bangsa">
                    </span>
                    <span class="partner-logo partner-logo--dc">
                        <img src="{{ asset('logodcnew.png') }}" alt="Logo Desa Cantik">
                    </span>
                </div>
                @guest
                    <a class="icon-button" href="/login" aria-label="Login admin" title="Login admin">
                        <i class="bi bi-box-arrow-in-right"></i>
                    </a>
                @endguest

                @auth
                    <div class="portal-user-menu">
                        <div class="portal-user-greeting" title="{{ auth()->user()->name }}">
                            <i class="bi bi-person-circle" aria-hidden="true"></i>
                            <span>Selamat Datang, {{ auth()->user()->name }}</span>
                        </div>
                        <form class="portal-logout-form" action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button class="portal-logout-button" type="submit" aria-label="Logout" title="Logout">
                                <i class="bi bi-box-arrow-right"></i>
                            </button>
                        </form>
                    </div>
                @endauth
            </div>
        </nav>

        <section class="hero">
            <div class="hero-copy">
                <div class="eyebrow">
                    <i class="bi bi-stars"></i>
                    Satu portal untuk seluruh kelurahan binaan
                </div>
                <h1>Portal Terpadu Kelurahan Binaan <span class="accent">Desa Cantik</span></h1>
                <p class="lead">
                    Jelajahi informasi layanan, data statistik, berita, galeri kegiatan, dan program Desa Cantik dari setiap kelurahan melalui pintu masuk yang cepat dan interaktif.
                </p>

                <label class="search-row" for="villageSearch">
                    <i class="bi bi-search"></i>
                    <input id="villageSearch" type="search" placeholder="Cari kelurahan..." autocomplete="off">
                </label>
                <div class="empty-state" id="emptyState">Kelurahan tidak ditemukan.</div>

                <div class="quick-stats" aria-label="Ringkasan portal">
                    <div class="stat">
                        <strong>{{ count($villages) }}</strong>
                        <span>Website kelurahan</span>
                    </div>
                    <div class="stat">
                        <strong>24/7</strong>
                        <span>Akses informasi</span>
                    </div>
                    <div class="stat">
                        <strong>1</strong>
                        <span>Portal terpadu</span>
                    </div>
                </div>
            </div>

            <div class="portal-panel">
                <div class="map-stage" id="villageGrid">
                    <div class="route-line"></div>
                    <div class="route-line"></div>

                    @foreach($villages as $slug => $village)
                        @php
                            $url = '/' . $slug;
                            $officialName = $village['official_name'] ?? 'Kelurahan ' . ($village['name'] ?? ucfirst($slug));
                            $district = $village['district'] ?? '-';
                            $city = $village['city'] ?? 'Kota Cilegon';
                        @endphp
                        <a class="village-card" href="{{ $url }}" data-village-card data-search="{{ strtolower($officialName . ' ' . $district . ' ' . $city) }}">
                            <div class="card-top">
                                <span class="pin" aria-hidden="true"><i class="bi bi-geo-alt-fill"></i></span>
                                <span class="arrow" aria-hidden="true"><i class="bi bi-arrow-up-right"></i></span>
                            </div>
                            <h2>{{ $officialName }}</h2>
                            <p>Kecamatan {{ $district }}, {{ $city }}</p>
                            <div class="meta">
                                <i class="bi bi-compass"></i>
                                <span>Kunjungi website</span>
                            </div>
                        </a>
                    @endforeach

                    <span class="pulse-dot dot-one" aria-hidden="true"></span>
                    <span class="pulse-dot dot-two" aria-hidden="true"></span>
                    <span class="pulse-dot dot-three" aria-hidden="true"></span>

                    <div class="hint-bar">
                        <span><i class="bi bi-hand-index-thumb"></i> Klik kartu kelurahan untuk masuk</span>
                        <span><i class="bi bi-mouse"></i> Arahkan kursor untuk melihat gerakan</span>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <script>
        const searchInput = document.getElementById('villageSearch');
        const emptyState = document.getElementById('emptyState');
        const cards = Array.from(document.querySelectorAll('[data-village-card]'));

        if (searchInput) {
            searchInput.addEventListener('input', function () {
                const query = this.value.trim().toLowerCase();
                let visibleCount = 0;

                cards.forEach(function (card) {
                    const isVisible = card.dataset.search.includes(query);
                    card.style.display = isVisible ? '' : 'none';
                    visibleCount += isVisible ? 1 : 0;
                });

                emptyState.classList.toggle('show', visibleCount === 0);
            });
        }

        cards.forEach(function (card) {
            card.addEventListener('pointermove', function (event) {
                const rect = card.getBoundingClientRect();
                const x = (event.clientX - rect.left - rect.width / 2) / rect.width;
                const y = (event.clientY - rect.top - rect.height / 2) / rect.height;
                card.style.transform = `translateY(-8px) scale(1.01) rotateX(${y * -5}deg) rotateY(${x * 5}deg)`;
            });

            card.addEventListener('pointerleave', function () {
                card.style.transform = '';
            });
        });
    </script>
</body>
</html>