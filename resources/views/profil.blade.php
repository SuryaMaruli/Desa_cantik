@extends('layouts.app')

@section('title', 'Profil Kelurahan Gunung Sugih')

@section('content')
    @php
        $villageText = fn ($value) => $value;
        $misiItems = $profilKelurahan?->misi ?? [];
        $profileVillageName = $profilKelurahan?->nama_kelurahan ?? ($currentVillage['official_name'] ?? 'Kelurahan Gunung Sugih');
    @endphp
    <style>
        /* --- CSS RESET & GLOBAL --- */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f7f9fc;
            color: #333;
            line-height: 1.6;
        }
        .container { width: 95%; max-width: 100%; margin: 0 auto; padding: 0 20px; }

        /* --- HEADER SECTION --- */
        .header-section {
            background-color: #F6903A;
            color: white;
            padding: 60px 0 120px 0;
        }
        .header-section h1 { font-size: 2.5rem; font-weight: 400; margin-bottom: 10px; }
        .header-section p { font-size: 1rem; font-weight: 300; opacity: 0.9; }

        /* --- MAIN LAYOUT --- */
        .main-content { margin-top: -70px; padding-bottom: 80px; }

        /* --- CARD STYLE GLOBAL --- */
        .card {
            background: white;
            width: 100%;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
            padding: 40px;
            margin-bottom: 40px;
            max-width: none;
        }

        /* --- IMAGE BOARD STYLING --- */
        .image-container {
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px 0;
        }
        .image-board {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            object-fit: cover;
        }

        /* --- TYPOGRAPHY UTILS --- */
        .section-title {
            color: #00897b;
            font-size: 1.5rem;
            margin-bottom: 25px;
            font-weight: 500;
            margin-top: 10px;
        }

        /* Judul Tengah untuk Monografi & Struktur */
        .section-title-center {
            color: #00897b;
            font-size: 1.5rem;
            margin-bottom: 25px;
            font-weight: 500;
            margin-top: 10px;
            text-align: center; /* Posisi tengah sesuai gambar baru */
            text-transform: uppercase; /* Huruf kapital */
        }
        
        .section-title-center.normal-case {
            text-transform: none; /* Kembali ke huruf biasa untuk Struktur Organisasi */
        }

        /* --- 1. PROFIL SECTION --- */
        .profile-title { text-align: center; color: #009688; font-size: 1.8rem; font-weight: 400; margin-bottom: 40px; }
        .info-list { display: flex; flex-direction: column; }
        .info-row { display: flex; padding: 15px 0; border-bottom: 1px solid #f0f0f0; }
        .info-row:last-child { border-bottom: none; }
        .label { width: 35%; color: #5f6368; }
        .separator { width: 5%; text-align: center; color: #5f6368; }
        .value { width: 60%; color: #202124; font-weight: 500; }

        /* --- 2. SEJARAH SECTION --- */
        .history-text p { margin-bottom: 15px; color: #4a4a4a; font-size: 0.95rem; text-align: justify; }

        /* --- 3. VISI & MISI SECTION --- */
        .vm-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-bottom: 40px; }
        .vm-card { padding: 40px; border-radius: 16px; height: 100%; }
        .visi-card { background-color: #eafbf4; }
        .misi-card { background-color: #eef8ff; }
        .vm-header { display: flex; align-items: center; margin-bottom: 20px; gap: 15px; }
        .vm-title { font-size: 1.5rem; font-weight: 500; }
        .text-green { color: #009688; }
        .text-blue { color: #1e88e5; }
        .icon-circle { width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; }
        .bg-green-icon { background-color: #009688; color: white; }
        .bg-blue-icon { background-color: #1e88e5; color: white; }
        .vm-content { font-size: 0.95rem; line-height: 1.7; }
        .visi-text { font-style: italic; color: #444; }
        .misi-list { list-style: none; padding: 0; }
        .misi-list li { position: relative; padding-left: 20px; margin-bottom: 10px; color: #444; }
        .misi-list li::before { content: "•"; color: #1e88e5; font-weight: bold; position: absolute; left: 0; }

        /* --- 4. DATA WILAYAH (STATS) --- */
        .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 50px; }
        .stat-card {
            background: white; padding: 25px 20px; border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            display: flex; flex-direction: column; justify-content: space-between;
            position: relative; overflow: hidden; height: 140px;
        }
        .stat-card::before { content: ''; position: absolute; left: 0; top: 0; bottom: 0; width: 4px; }
        .border-green::before { background-color: #009688; }
        .border-blue::before { background-color: #2979ff; }
        .border-purple::before { background-color: #9c27b0; }
        .border-orange::before { background-color: #ff9800; }
        .stat-icon { margin-bottom: 10px; }
        .icon-green { color: #009688; }
        .icon-blue { color: #2979ff; }
        .icon-purple { color: #9c27b0; }
        .icon-orange { color: #ff9800; }
        .stat-label { font-size: 0.85rem; color: #888; margin-bottom: 5px; }
        .stat-number { font-size: 1.5rem; font-weight: 500; color: #333; }

        /* --- 5. BATAS WILAYAH --- */
        .boundaries-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .boundary-item { padding: 20px; border-radius: 12px; display: flex; align-items: center; gap: 20px; }
        .bg-blue-light { background-color: #e3f2fd; }
        .bg-orange-light { background-color: #fff3e0; }
        .bg-purple-light { background-color: #f3e5f5; }
        .bg-green-light { background-color: #e8f5e9; }
        .direction-box {
            width: 50px; height: 50px; min-width: 50px; border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.2rem; font-weight: 500; color: white;
        }
        .bg-blue { background-color: #2979ff; }
        .bg-orange { background-color: #ff9800; }
        .bg-purple { background-color: #ab47bc; }
        .bg-green { background-color: #009688; }
        .boundary-info h4 { font-size: 0.95rem; margin-bottom: 4px; font-weight: 500; }
        .bg-blue-light .boundary-info h4 { color: #2979ff; }
        .bg-orange-light .boundary-info h4 { color: #ef6c00; }
        .bg-purple-light .boundary-info h4 { color: #9c27b0; }
        .bg-green-light .boundary-info h4 { color: #009688; }
        .boundary-info p { font-size: 0.9rem; color: #444; line-height: 1.4; }

        /* --- 6. IMAGE/BOARD STYLING (BARU) --- */
        .image-container {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
        }
        .image-board {
            max-width: 100%;
            height: auto;
            border-radius: 8px; /* Sudut gambar tumpul */
            border: 1px solid #eaeaea; /* Garis tipis halus di sekeliling gambar */
        }

        /* --- RESPONSIF (HP) --- */
        @media (max-width: 768px) {
            .header-section { text-align: center; padding-bottom: 90px; }
            .container { padding: 0 15px; }
            .info-row { flex-direction: column; }
            .separator { display: none; }
            .label, .value { width: 100%; }
            .label { font-size: 0.85rem; margin-bottom: 5px; }
            .vm-grid { grid-template-columns: 1fr; }
            .stats-grid { grid-template-columns: 1fr; gap: 15px; }
            .stat-card { height: auto; flex-direction: row; align-items: center; gap: 15px; padding: 20px; }
            .stat-card::before { width: 4px; }
            .stat-content { text-align: left; }
            .stat-icon { margin-bottom: 0; }
            .boundaries-grid { grid-template-columns: 1fr; }
            .card { padding: 25px; }
            .section-title-center { font-size: 1.3rem; }
        }
    </style>

    <header class="header-section">
        <div class="container">
            <h1>Profil Kelurahan</h1>
            <p>Mengenal lebih dekat Kelurahan Gunung Sugih, sejarah, visi misi, dan struktur organisasi</p>
        </div>
    </header>

    <main class="container main-content">
        
        <div class="card">
            <h2 class="profile-title">{{ $villageText($profileVillageName) }}</h2>
            <div class="info-list">
                <div class="info-row">
                    <div class="label">Nama Kelurahan</div>
                    <div class="separator">:</div>
                    <div class="value">{{ $villageText($profilKelurahan->nama_kelurahan ?? '-') }}</div>
                </div>
                <div class="info-row">
                    <div class="label">Tahun Pembentukan</div>
                    <div class="separator">:</div>
                    <div class="value">{{ $profilKelurahan->tahun_pembukaan ?? '-' }}</div>
                </div>
                <div class="info-row">
                    <div class="label">Dasar Hukum Pembentukan</div>
                    <div class="separator">:</div>
                    <div class="value">{{ $villageText($profilKelurahan->dasar_hukum_pembentukan ?? '-') }}</div>
                </div>
                <div class="info-row">
                    <div class="label">Nomor Kode Wilayah</div>
                    <div class="separator">:</div>
                    <div class="value">{{ $profilKelurahan->nomor_kode_wilayah ?? '-' }}</div>
                </div>
                <div class="info-row">
                    <div class="label">Nomor Kode Pos</div>
                    <div class="separator">:</div>
                    <div class="value">{{ $profilKelurahan->nomor_kode_pos ?? '-' }}</div>
                </div>
                <div class="info-row">
                    <div class="label">Kecamatan</div>
                    <div class="separator">:</div>
                    <div class="value">{{ $villageText($profilKelurahan->kecamatan ?? '-') }}</div>
                </div>
                <div class="info-row">
                    <div class="label">Kabupaten/Kota</div>
                    <div class="separator">:</div>
                    <div class="value">{{ $villageText($profilKelurahan->kabupaten_kota ?? '-') }}</div>
                </div>
                <div class="info-row">
                    <div class="label">Provinsi</div>
                    <div class="separator">:</div>
                    <div class="value">{{ $villageText($profilKelurahan->provinsi ?? '-') }}</div>
                </div>
            </div>
        </div>

        <h2 class="section-title">Sejarah Kelurahan Gunung Sugih</h2>
        <div class="card history-text">
            <p>Kelurahan
                Gunung Sugih sebelum menjadi kelurahan adalah sebuah Desa bernama Desa Gunung
                Sugih yang merupakan hasil pemekaran dari Desa Gunung Sugih pada tahun 2006,
                seiring dengan ditetapan dan disahkannya UU No.15 Tahun 1999 tanggal 27 April
                1999 tentang pembentukan Kotamadya Daerah Tingkat II Depok dan Kota Madya
                daerah Tingkat II Cilegon, status Kota Administratif Cilegon berubah menjadi
                Kotamadya Cilegon.
            </p>
        </div>

        <div class="vm-grid">
            <div class="vm-card visi-card">
                <div class="vm-header">
                    <div class="icon-circle bg-green-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                    </div>
                    <h3 class="vm-title text-green">Visi</h3>
                </div>
                <div class="vm-content visi-text">
                    "{{ $villageText($profilKelurahan->visi ?? 'Belum ada visi') }}"
                </div>
            </div>

            <div class="vm-card misi-card">
                <div class="vm-header">
                    <div class="icon-circle bg-blue-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><circle cx="12" cy="12" r="6"></circle><circle cx="12" cy="12" r="2"></circle></svg>
                    </div>
                    <h3 class="vm-title text-blue">Misi</h3>
                </div>
                <div class="vm-content">
                    <ul class="misi-list">
                        @if(count($misiItems) > 0)
                            @foreach($misiItems as $misi)
                                <li>{{ $villageText($misi) }}</li>
                            @endforeach
                        @else
                            <li>Belum ada misi</li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>

        <h2 class="section-title">Data Wilayah</h2>
        <div class="stats-grid">
            <div class="stat-card border-green">
                <div class="stat-icon icon-green">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                </div>
                <div class="stat-content">
                    <div class="stat-label">Luas Wilayah</div>
                    <div class="stat-number">8.5 km²</div>
                </div>
            </div>
            <div class="stat-card border-blue">
                <div class="stat-icon icon-blue">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                </div>
                <div class="stat-content">
                    <div class="stat-label">Jumlah Penduduk</div>
                    <div class="stat-number">25,340</div>
                </div>
            </div>
            <div class="stat-card border-purple">
                <div class="stat-icon icon-purple">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2l9 4.9V17L12 22l-9-4.9V7z"/></svg>
                </div>
                <div class="stat-content">
                    <div class="stat-label">Jumlah RW</div>
                    <div class="stat-number">12 RW</div>
                </div>
            </div>
            <div class="stat-card border-orange">
                <div class="stat-icon icon-orange">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="7"></circle><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline></svg>
                </div>
                <div class="stat-content">
                    <div class="stat-label">Jumlah RT</div>
                    <div class="stat-number">48 RT</div>
                </div>
            </div>
        </div>

@php
    $profileVillageSlug = $currentVillageSlug ?? config('villages.default', 'gunung-sugih');
    $boundaryTargetMap = [
        'gunung-sugih' => 'GUNUNG SUGIH',
        'karangasem' => 'KARANGASEM',
        'bulakan' => 'BULAKAN',
    ];
    $boundaryTarget = $boundaryTargetMap[$profileVillageSlug] ?? 'GUNUNG SUGIH';
@endphp

<h2 class="section-title">Perbatasan Wilayah {{ $profileVillageName }}</h2>
        <div class="card boundary-map-card">
            <div class="map-header-panel">
                <div>
                    <span class="map-eyebrow">Visualisasi Wilayah</span>
                    <h3>{{ $profileVillageName }}</h3>
                </div>
                <div class="map-focus-badge">
                    <i class="fas fa-location-crosshairs"></i>
                    <span>Fokus peta aktif</span>
                </div>
            </div>

            <div class="map-placeholder" id="mapLoading">
                <div class="map-loading-state">
                    <i class="fas fa-map-marked-alt"></i>
                    <p>Memuat peta wilayah...</p>
                </div>
            </div>
            <div class="map-container" style="display: none;">
                <div id="villageMap"></div>
            </div>
        </div>
        
        <!-- Leaflet CSS & JS -->
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
        
        <style>
            .boundary-map-card {
                background: linear-gradient(135deg, #ffffff 0%, #f0fdfa 48%, #eff6ff 100%);
                border: 1px solid #dbeafe;
                overflow: hidden;
                padding: 24px;
            }

            .map-header-panel {
                align-items: center;
                display: flex;
                gap: 16px;
                justify-content: space-between;
                margin-bottom: 18px;
            }

            .map-header-panel h3 {
                color: #0f766e;
                font-size: 1.45rem;
                font-weight: 800;
                margin: 4px 0 0;
            }

            .map-eyebrow {
                color: #2563eb;
                font-size: 0.78rem;
                font-weight: 800;
                letter-spacing: 0;
                text-transform: uppercase;
            }

            .map-focus-badge {
                align-items: center;
                background: #ffffff;
                border: 1px solid #bae6fd;
                border-radius: 999px;
                color: #0369a1;
                display: inline-flex;
                font-size: 0.86rem;
                font-weight: 800;
                gap: 8px;
                padding: 10px 14px;
                white-space: nowrap;
            }

            .map-loading-state {
                align-items: center;
                background: #f8fafc;
                border: 1px dashed #7dd3fc;
                border-radius: 16px;
                color: #475569;
                display: flex;
                flex-direction: column;
                height: 280px;
                justify-content: center;
            }

            .map-loading-state i {
                color: #F6903A;
                font-size: 48px;
                margin-bottom: 15px;
            }

            .map-container {
                border: 1px solid #bfdbfe;
                border-radius: 18px;
                box-shadow: 0 18px 40px rgba(15, 23, 42, 0.12);
                height: 540px;
                overflow: hidden;
                width: 100%;
            }
            
            #villageMap {
                height: 100%;
                width: 100%;
            }
            
            .custom-marker {
                background: #F6903A;
                border: 3px solid white;
                border-radius: 50%;
                box-shadow: 0 3px 10px rgba(0,0,0,0.3);
            }
            
            .leaflet-control-zoom {
                border: none !important;
                box-shadow: 0 2px 10px rgba(0,0,0,0.15) !important;
            }
            
            .leaflet-control-zoom a {
                background: white !important;
                color: #333 !important;
            }
            
            .leaflet-control-zoom a:hover { background: #f5f5f5 !important; }
            .leaflet-popup-content-wrapper { background: #fff !important; border-radius: 10px; box-shadow: 0 8px 22px rgba(15,23,42,0.24); color: #333 !important; }
            .leaflet-popup-tip { background: #fff !important; box-shadow: none; }
            .leaflet-popup-content { background: transparent; color: #333; line-height: 1.45; margin: 12px 14px; }
            .leaflet-popup-content h4 { color: inherit; font-size: 13px; font-weight: 700; margin: 0 0 4px; }
            .leaflet-popup-content p { color: #555; font-size: 11px; margin: 0; }
            .leaflet-popup-close-button { color: #333 !important; }
            .leaflet-popup-close-button:hover { color: #666 !important; }

            .map-legend {
                background: #ffffff;
                border: 1px solid #dbeafe;
                border-radius: 12px;
                box-shadow: 0 12px 28px rgba(15, 23, 42, 0.16);
                color: #334155;
                font-size: 12px;
                max-width: 280px;
                padding: 12px;
            }

            .map-legend strong {
                color: #0f172a;
                display: block;
                margin-bottom: 8px;
            }

            .map-legend-row {
                align-items: center;
                display: flex;
                gap: 8px;
                margin-bottom: 6px;
            }

            .map-legend-swatch {
                border-radius: 4px;
                display: inline-flex;
                flex: 0 0 16px;
                height: 16px;
                opacity: 0.72;
                width: 16px;
            }

            .village-tooltip {
                background: #ffffff;
                border: 1px solid #93c5fd;
                border-radius: 999px;
                box-shadow: 0 6px 16px rgba(15, 23, 42, 0.18);
                color: #0f172a;
                font-weight: 800;
                padding: 4px 8px;
            }

            @media (max-width: 767px) {
                .boundary-map-card { padding: 18px; }
                .map-header-panel { align-items: flex-start; flex-direction: column; }
                .map-container { height: 420px; }
                .map-focus-badge { white-space: normal; }
            }
        </style>
        
<script>
            try {
                var activeVillageName = @json($profileVillageName);
                var targetVillage = @json($boundaryTarget);
                var map = L.map('villageMap').setView([-5.9825, 106.0515], 14);
                var standardLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                    maxZoom: 18
                }).addTo(map);
                var satelliteLayer = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
                    attribution: '&copy; Esri'
                });

                L.control.scale({ imperial: false, metric: true }).addTo(map);

                var colors = {
                    'GUNUNG SUGIH': '#ef4444',
                    'KARANGASEM': '#16a34a',
                    'BULAKAN': '#0ea5e9',
                    'ANYAR': '#8b5cf6',
                    'KOSAMBIRONYOK': '#f97316'
                };

                var displayNames = {
                    'GUNUNG SUGIH': 'KELURAHAN GUNUNG SUGIH',
                    'KARANGASEM': 'KELURAHAN KARANGASEM',
                    'BULAKAN': 'KELURAHAN BULAKAN',
                    'ANYAR': 'DESA ANYAR',
                    'KOSAMBIRONYOK': 'DESA KOSAMBI DAN RONYOK'
                };

                var boundaryPresets = {
                    'GUNUNG SUGIH': [
                        { name: 'Perairan Selat Sunda', direction: 'Utara', color: '#2563eb' },
                        { name: 'Desa Anyar, Kabupaten Serang', direction: 'Barat', color: colors.ANYAR },
                        { name: 'Kelurahan Karangasem', direction: 'Timur', color: colors.KARANGASEM },
                        { name: 'Desa Kosambi dan Ronyok, Kabupaten Serang', direction: 'Selatan', color: colors.KOSAMBIRONYOK }
                    ],
                    'KARANGASEM': [
                        { name: 'Kelurahan Gunung Sugih', direction: 'Barat', color: colors['GUNUNG SUGIH'] },
                        { name: 'Data batas lain mengikuti polygon Karangasem pada peta', direction: 'Sekitar', color: colors.KARANGASEM }
                    ],
                    'BULAKAN': [
                        { name: 'Data polygon Bulakan belum tersedia pada file GeoJSON saat ini', direction: 'Catatan', color: colors.BULAKAN },
                        { name: 'Area sekitar Gunung Sugih dan Karangasem ditampilkan sebagai referensi', direction: 'Referensi', color: colors['GUNUNG SUGIH'] }
                    ]
                };

                function featureName(feature) {
                    return feature.properties && feature.properties.DESA ? feature.properties.DESA : '';
                }

                function isTarget(feature) {
                    return featureName(feature) === targetVillage;
                }

                function getStyle(feature) {
                    var desa = featureName(feature);
                    var target = isTarget(feature);
                    var color = colors[desa] || '#64748b';
                    return {
                        color: color,
                        fillColor: color,
                        fillOpacity: target ? 0.62 : 0.2,
                        opacity: target ? 1 : 0.72,
                        weight: target ? 4 : 2
                    };
                }

                function popupFor(feature) {
                    var desa = featureName(feature);
                    var color = colors[desa] || '#64748b';
                    var display = displayNames[desa] || desa;
                    var kecamatan = feature.properties.KECAMATAN || '-';
                    var kabKota = feature.properties.KAB_KOTA || '-';
                    var luas = feature.properties.LUAS_WILAY ? Number(feature.properties.LUAS_WILAY).toLocaleString('id-ID') + ' km2' : '-';
                    var prefix = desa === targetVillage ? 'Wilayah aktif' : 'Wilayah sekitar';

                    return '<h4 style="color:' + color + '"><b>' + display + '</b></h4>' +
                        '<p><b>' + prefix + '</b><br>' +
                        'Kecamatan: ' + kecamatan + '<br>' +
                        'Kab/Kota: ' + kabKota + '<br>' +
                        'Luas: ' + luas + '</p>';
                }

                function onEachFeature(feature, layer) {
                    var desa = featureName(feature);
                    var display = displayNames[desa] || desa;
                    layer.bindPopup(popupFor(feature));
                    layer.bindTooltip(display, {
                        permanent: isTarget(feature),
                        direction: 'center',
                        className: 'village-tooltip',
                        sticky: true
                    });
                    layer.on({
                        mouseover: function() {
                            this.setStyle({ fillOpacity: isTarget(feature) ? 0.72 : 0.36, weight: isTarget(feature) ? 5 : 3 });
                            this.openPopup();
                        },
                        mouseout: function() {
                            if (geoJsonLayer) geoJsonLayer.resetStyle(this);
                            this.closePopup();
                        }
                    });
                }

                function showUnavailableNotice() {
                    var notice = L.control({ position: 'topright' });
                    notice.onAdd = function() {
                        var div = L.DomUtil.create('div', 'map-legend');
                        div.innerHTML = '<strong>Data batas Bulakan</strong><div>Polygon Kelurahan Bulakan belum tersedia pada GeoJSON lokal. Peta menampilkan wilayah rujukan terdekat.</div>';
                        return div;
                    };
                    notice.addTo(map);
                }

                function addNorthBoundary(feature) {
                    if (!feature || targetVillage !== 'GUNUNG SUGIH') return;
                    var bounds = L.geoJSON(feature).getBounds();
                    var center = bounds.getCenter();
                    var northPoint = L.latLng(bounds.getNorth() + 0.01, center.lng);

                    L.polyline([center, northPoint], {
                        color: '#2563eb',
                        dashArray: '8, 8',
                        weight: 3
                    }).addTo(map).bindTooltip('Utara: Berbatasan langsung dengan Perairan Selat Sunda.');

                    L.circleMarker(northPoint, {
                        color: '#2563eb',
                        fillColor: '#2563eb',
                        fillOpacity: 0.8,
                        radius: 7,
                        weight: 2
                    }).addTo(map).bindPopup('<b>Utara: Perairan Selat Sunda</b>');
                }

                var geoJsonLayer = null;
                var geoJsonUrl = '{{ asset("shapefile/bulakan_boundaries.geojson") }}';

                fetch(geoJsonUrl)
                    .then(function(response) {
                        if (!response.ok) throw new Error('HTTP error! status: ' + response.status);
                        return response.json();
                    })
                    .then(function(data) {
                        var targetFeature = data.features.find(function(feature) { return isTarget(feature); });

                        geoJsonLayer = L.geoJSON(data, {
                            filter: function(feature) {
                                return targetVillage === 'BULAKAN' || ['GUNUNG SUGIH', 'KARANGASEM', 'ANYAR', 'KOSAMBIRONYOK'].includes(featureName(feature));
                            },
                            style: getStyle,
                            onEachFeature: onEachFeature
                        }).addTo(map);

                        document.getElementById('mapLoading').style.display = 'none';
                        document.querySelector('.map-container').style.display = 'block';
                        map.invalidateSize();

                        if (targetFeature) {
                            map.fitBounds(L.geoJSON(targetFeature).getBounds(), { padding: [42, 42] });
                            addNorthBoundary(targetFeature);
                        } else {
                            var bounds = geoJsonLayer.getBounds();
                            if (bounds.isValid()) map.fitBounds(bounds, { padding: [50, 50] });
                            showUnavailableNotice();
                        }
                    })
                    .catch(function(error) {
                        console.error('Error loading GeoJSON:', error);
                        document.getElementById('mapLoading').innerHTML =
                            '<div class="map-loading-state">' +
                            '<i class="fas fa-exclamation-triangle"></i>' +
                            '<p>Gagal memuat data batas wilayah</p>' +
                            '<p style="color:#94a3b8;font-size:11px;margin-top:5px;">Error: ' + error.message + '</p></div>';
                    });

                var legend = L.control({ position: 'bottomright' });
                legend.onAdd = function() {
                    var div = L.DomUtil.create('div', 'map-legend');
                    var rows = boundaryPresets[targetVillage] || boundaryPresets['GUNUNG SUGIH'];
                    div.innerHTML = '<strong>Legenda Batas Wilayah</strong>' + rows.map(function(item) {
                        return '<div class="map-legend-row"><span class="map-legend-swatch" style="background:' + item.color + '"></span><span>' + item.direction + ': ' + item.name + '</span></div>';
                    }).join('') + '<div class="map-legend-row" style="border-top:1px solid #e2e8f0;margin-top:8px;padding-top:8px;"><span class="map-legend-swatch" style="background:' + (colors[targetVillage] || '#0ea5e9') + ';border:2px solid ' + (colors[targetVillage] || '#0ea5e9') + '"></span><span>' + activeVillageName + '</span></div>';
                    return div;
                };
                legend.addTo(map);

                L.control.layers({
                    'Peta Standard': standardLayer,
                    'Peta Satelit': satelliteLayer
                }).addTo(map);
            } catch(e) {
                console.error('Error initializing map:', e);
                document.getElementById('villageMap').innerHTML = '<div style="padding:20px;text-align:center;color:red;">Error loading map. Please refresh the page.</div>';
            }
        </script>

<h2 class="section-title-center">MONOGRAFI KELURAHAN GUNUNG SUGIH</h2>
@if($monografis->count() > 0)
            @foreach($monografis as $monografi)
            <div class="card">
                <div class="image-container">
<img src="{{ $monografi->gambar_mono ? url('storage/' . $monografi->gambar_mono) : '' }}" alt="Papan Monografi" class="image-board">
                </div>
            </div>
            @endforeach
        @else
            <div class="card">
                <div class="empty-state">
                    <i class="fas fa-info-circle"></i>
                    <h3>Informasi Monografi belum ditambahkan</h3>
                    <p>Monografi Kelurahan akan ditampilkan di sini setelah ditambahkan oleh admin.</p>
                </div>
            </div>
        @endif

<h2 class="section-title-center normal-case">Struktur Organisasi</h2>
        @php
            $struktur = \App\Models\StrukturOrganisasi::first();
        @endphp
        @if($struktur && $struktur->gambar)
            <div class="card">
                <div class="image-container">
                    <img src="{{ asset('storage/' . $struktur->gambar) }}" alt="Struktur Organisasi" class="image-board">
                </div>
            </div>
        @else
            <div class="card">
                <div class="empty-state">
                    <i class="fas fa-info-circle"></i>
                    <h3>Struktur Organisasi belum ditambahkan</h3>
                    <p>Struktur Organisasi Kelurahan akan ditampilkan di sini setelah ditambahkan oleh admin.</p>
                </div>
            </div>
        @endif

    </main>
@endsection



