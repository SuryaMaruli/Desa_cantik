@extends('layouts.app')

@section('title', 'Profil Kelurahan Gunung Sugih')

@section('content')
    @php
        $villageText = fn ($value) => $value;
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
            <h2 class="profile-title">{{ $villageText($profilKelurahan->nama_kelurahan ?? 'Kelurahan Gunung Sugih') }}</h2>
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
                        @if($profilKelurahan->misi && count($profilKelurahan->misi) > 0)
                            @foreach($profilKelurahan->misi as $misi)
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

<h2 class="section-title">Perbatasan Wilayah Kelurahan Gunung Sugih</h2>
        <div class="card">
            <div class="map-placeholder" id="mapLoading">
                <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; height: 250px; background: #f8f9fa; border-radius: 12px;">
                    <i class="fas fa-map-marked-alt" style="font-size: 48px; color: #F6903A; margin-bottom: 15px;"></i>
                    <p style="color: #666;">Memuat peta wilayah...</p>
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
            .map-container {
                width: 100%;
                height: 450px;
                border-radius: 12px;
                overflow: hidden;
                box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            }
            
            #villageMap {
                width: 100%;
                height: 100%;
            }
            
            /* Custom marker styles */
            .custom-marker {
                background: #F6903A;
                border-radius: 50%;
                border: 3px solid white;
                box-shadow: 0 3px 10px rgba(0,0,0,0.3);
            }
            
            /* Map controls styling */
            .leaflet-control-zoom {
                border: none !important;
                box-shadow: 0 2px 10px rgba(0,0,0,0.15) !important;
            }
            
            .leaflet-control-zoom a {
                background: white !important;
                color: #333 !important;
            }
            
            .leaflet-control-zoom a:hover {
                background: #f5f5f5 !important;
            }
            
/* Popup styling - Override Leaflet default dark styles */
            .leaflet-popup-content-wrapper {
                border-radius: 8px;
                box-shadow: 0 3px 14px rgba(0,0,0,0.3);
                background: #fff !important;
                color: #333 !important;
            }
            
            .leaflet-popup-tip {
                background: #fff !important;
                box-shadow: none;
            }
            
            .leaflet-popup-tip:after {
                background: #fff !important;
            }
            
            .leaflet-popup-content {
                margin: 10px 12px;
                line-height: 1.4;
                background: transparent;
                color: #333;
            }
            
            .leaflet-popup-content h4 {
                color: inherit;
                margin: 0 0 4px 0;
                font-size: 13px;
                font-weight: 600;
            }
            
            .leaflet-popup-content p {
                margin: 0;
                color: #555;
                font-size: 11px;
            }
            
            .leaflet-popup-close-button {
                color: #333 !important;
            }
            
            .leaflet-popup-close-button:hover {
                color: #666 !important;
            }
        </style>
        
<script>
            // Initialize map - with error handling
            try {
            var map = L.map('villageMap').setView([-5.9825, 106.0515], 14);
            
            // Add OpenStreetMap tiles
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                maxZoom: 18,
            }).addTo(map);
            
            // Custom village marker icon
            var villageIcon = L.divIcon({
                className: 'custom-marker',
                html: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="white" stroke="white" stroke-width="1"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>',
                iconSize: [40, 40],
                iconAnchor: [20, 40],
                popupAnchor: [0, -40]
            });
            
            // Add scale control
            L.control.scale({
                imperial: false,
                metric: true
            }).addTo(map);
            
// =========================================================
            // BATAS WILAYAH - LOAD GEOJSON FROM STORAGE (BatasWilayah.py output)
            // =========================================================
            
            // Define colors from Python code
            var warna = {
                "GUNUNG SUGIH": "red",
                "ANYAR": "purple",
                "KOSAMBIRONYOK": "orange",
                "KARANGASEM": "green"
            };
            
            // Boundary info shown in map popups
            var keteranganBatas = {
                "ANYAR": "Barat: Berbatasan dengan Desa Anyar di wilayah Kabupaten Serang.",
                "KOSAMBIRONYOK": "Selatan: Berbatasan dengan Desa Kosambi dan Ronyok di wilayah Kabupaten Serang.",
                "KARANGASEM": "Timur: Berbatasan dengan Kelurahan Karangasem."
            };

            var namaTampil = {
                "GUNUNG SUGIH": "KELURAHAN GUNUNG SUGIH",
                "ANYAR": "DESA ANYAR",
                "KOSAMBIRONYOK": "DESA KOSAMBI DAN RONYOK",
                "KARANGASEM": "KELURAHAN KARANGASEM"
            };
            
            // Style function for GeoJSON layers
            function getStyle(feature) {
                var desaName = feature.properties.DESA;
                var color = warna[desaName] || 'gray';
                return {
                    color: color,
                    weight: 2,
                    fillColor: color,
                    fillOpacity: 0.35
                };
            }
            
// Popup function
            function onEachFeature(feature, layer) {
                var desa = feature.properties.DESA;
                var displayDesa = namaTampil[desa] || desa;
                var kecamatan = feature.properties.KECAMATAN || '-';
                var kabKota = feature.properties.KAB_KOTA || '-';
                
                // Build popup content
                var popupContent;
                if (desa === "GUNUNG SUGIH") {
                    popupContent = '<h4 style="color:' + warna[desa] + '">' + 
                        '<b>' + displayDesa + '</b><br>' +
                        'Kecamatan : ' + kecamatan + '<br>' +'</h4>';
                } else {
                    var batas = keteranganBatas[desa] || '-';
                    popupContent = '<h4 style="color:' + warna[desa] + '">' + 
                        '<b>' + batas + '</b><br>' +
                        'KELURAHAN: ' + displayDesa + '<br>' +
                        'KECAMATAN: ' + kecamatan + '<br>'+'</h4>';
                }
                
                // Bind popup and show on mouseover (hover) immediately
                layer.bindPopup(popupContent);
                
                // Add mouseover event to show popup immediately on hover
                layer.on({
                    mouseover: function(e) {
                        this.openPopup();
                    },
                    mouseout: function(e) {
                        this.closePopup();
                    }
                });
                
                // Add tooltip on hover
                layer.bindTooltip(displayDesa, {
                    permanent: false,
                    direction: 'center',
                    className: 'village-tooltip',
                    sticky: true
                });
            }
            
// Variable to store GeoJSON data for later use
            var geoJsonLayer = null;
            
// Load GeoJSON from public folder
            var geoJsonUrl = '{{ asset("shapefile/bulakan_boundaries.geojson") }}';
            console.log('Loading GeoJSON from:', geoJsonUrl);
            
            fetch(geoJsonUrl)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('HTTP error! status: ' + response.status);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('GeoJSON loaded successfully, features:', data.features.length);
                    
                    // Add GeoJSON layer to map
                    geoJsonLayer = L.geoJSON(data, {
                        style: getStyle,
                        onEachFeature: onEachFeature
                    }).addTo(map);
                    
                    // Hide loading, show map container
                    document.getElementById('mapLoading').style.display = 'none';
                    document.querySelector('.map-container').style.display = 'block';
                    
                    // Fit map bounds to GeoJSON data
                    map.invalidateSize();
                    var bounds = L.geoJSON(data).getBounds();
                    if (bounds.isValid()) {
                        map.fitBounds(bounds, {padding: [50, 50]});
                    }

                    var gunungSugihFeature = data.features.find(function(feature) {
                        return feature.properties && feature.properties.DESA === 'GUNUNG SUGIH';
                    });

                    if (gunungSugihFeature) {
                        var gunungSugihBounds = L.geoJSON(gunungSugihFeature).getBounds();
                        var center = gunungSugihBounds.getCenter();
                        var northPoint = L.latLng(gunungSugihBounds.getNorth() + 0.01, center.lng);

                        L.polyline([center, northPoint], {
                            color: 'blue',
                            weight: 3,
                            dashArray: '8, 8'
                        }).addTo(map).bindTooltip('Utara: Berbatasan langsung dengan Perairan Selat Sunda.');

                        L.circleMarker(northPoint, {
                            radius: 7,
                            color: 'blue',
                            fillColor: 'blue',
                            fillOpacity: 0.75,
                            weight: 2
                        }).addTo(map).bindPopup('<b>Utara: Perairan Selat Sunda</b>');
                    }
                })
                .catch(error => {
                    console.error('Error loading GeoJSON:', error);
                    document.getElementById('mapLoading').innerHTML = 
                        '<div style="display:flex;flex-direction:column;align-items:center;justify-content:center;height:250px;background:#f8f9fa;border-radius:12px;">' +
                        '<i class="fas fa-exclamation-triangle" style="font-size:48px;color:#F6903A;margin-bottom:15px;"></i>' +
                        '<p style="color:#666;">Gagal memuat data batas wilayah</p>' +
                        '<p style="color:#999;font-size:11px;margin-top:5px;">Error: ' + error.message + '</p></div>';
                });
            
// =========================================================
            // ADD LEGEND
            // =========================================================
            var legend = L.control({position: 'bottomright'});
            legend.onAdd = function(map) {
                var div = L.DomUtil.create('div', 'map-legend');
                div.innerHTML = `
                    <div style="background:white;padding:10px;border-radius:8px;box-shadow:0 2px 10px rgba(0,0,0,0.15);font-size:12px;">
                        <strong style="display:block;margin-bottom:8px;">Legenda Batas Wilayah</strong>
                        <div style="display:flex;align-items:center;margin-bottom:4px;">
                            <span style="width:16px;height:16px;background:blue;opacity:0.5;margin-right:8px;border-radius:3px;"></span>
                            <span>Utara: Perairan Selat Sunda</span>
                        </div>
                        <div style="display:flex;align-items:center;margin-bottom:4px;">
                            <span style="width:16px;height:16px;background:purple;opacity:0.5;margin-right:8px;border-radius:3px;"></span>
                            <span>Barat: Desa Anyar, Kabupaten Serang</span>
                        </div>
                        <div style="display:flex;align-items:center;margin-bottom:4px;">
                            <span style="width:16px;height:16px;background:green;opacity:0.5;margin-right:8px;border-radius:3px;"></span>
                            <span>Timur: Kelurahan Karangasem</span>
                        </div>
                        <div style="display:flex;align-items:center;margin-bottom:4px;">
                            <span style="width:16px;height:16px;background:orange;opacity:0.5;margin-right:8px;border-radius:3px;"></span>
                            <span>Selatan: Desa Kosambi dan Ronyok, Kabupaten Serang</span>
                        </div>
                        <div style="display:flex;align-items:center;margin-top:6px;padding-top:6px;border-top:1px solid #eee;">
                            <span style="width:16px;height:16px;background:red;opacity:0.3;margin-right:8px;border-radius:3px;border:2px solid red;"></span>
                            <span>Gunung Sugih</span>
                        </div>
                    </div>
                `;
                return div;
            };
            legend.addTo(map);
            
// =========================================================
            // MAP LAYER CONTROLS
            // =========================================================
            var baseLayers = {
                'Peta Standard': L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; OpenStreetMap'
                }),
                'Peta Satelit': L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
                    attribution: '&copy; Esri'
                }),
                'Peta Gelap': L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
                    attribution: '&copy; CartoDB'
                })
            };
            
            L.control.layers(baseLayers).addTo(map);
            
            } catch(e) {
                console.error('Error initializing map:', e);
                document.getElementById('villageMap').innerHTML = 
                    '<div style="padding:20px;text-align:center;color:red;">' +
                    'Error loading map. Please refresh the page.' +
                    '</div>';
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


