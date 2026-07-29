@extends('layouts.app')

@section('title', 'Layanan Masyarakat - Kelurahan Gunung Sugih')

@section('content')
    @php
        $serviceInfo = $serviceInfo ?? [];
    @endphp
    <style>
        /* --- RESET & GLOBAL STYLES --- */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #ffffff;
            color: #333;
            line-height: 1.6;
        }

        /* --- COLORS --- */
        :root {
            --primary-green: #F6903A; /* Warna Header */
            --bg-green-light: #FFF9F2; /* BG Card Kiri */
            --icon-bg-green: #d1e7dd;
            --text-green: #146c43;
            
            --bg-blue-light: #FFF9F2; /* BG Card Kanan */
            --icon-bg-blue: #dbeafe;
            --text-blue: #1e40af;
            
            --bg-info-blue: #FFF9F2; /* BG Info Bawah */
        }

        /* --- HEADER SECTION --- */
        .hero-header {
            background-color: var(--primary-green);
            color: white;
            padding: 60px 20px;
        }

        .container {
            width: 95%;
            max-width: none;
            margin: 0 auto;
            padding: 0 20px;
        }

        .hero-header h1 {
            font-size: 2.5rem;
            font-weight: 500;
            margin-bottom: 15px;
        }

        .hero-header p {
            max-width: 600px;
            font-size: 1rem;
            opacity: 0.9;
        }

        /* --- MAIN CONTENT --- */
        .main-content {
            padding: 40px 0;
        }

        .section-title {
            color: var(--primary-green);
            font-size: 1.8rem;
            margin-bottom: 30px;
            font-weight: 500;
        }

        /* --- CARDS GRID --- */
        .cards-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-bottom: 50px;
        }

        .card {
            padding: 40px;
            border-radius: 12px;
            transition: transform 0.2s;
            box-shadow: 0 4px 6px rgba(0,0,0,0.02);
            min-height: 320px;
            display: flex;
            flex-direction: column;
        }

        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 15px rgba(0,0,0,0.05);
        }

        .card-green {
            background-color: var(--bg-green-light);
            border: 1px solid #e0f2f1;
        }

        .card-blue {
            background-color: var(--bg-blue-light);
            border: 1px solid #e3f2fd;
        }

        /* Icon Styling inside Cards */
        .icon-box {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 20px;
        }

        .card-green .icon-box {
            background-color: var(--icon-bg-green);
            color: var(--text-green);
        }

        .card-blue .icon-box {
            background-color: var(--icon-bg-blue);
            color: #2563eb;
        }

        .card h3 {
            font-size: 1.1rem;
            margin-bottom: 10px;
            color: #333;
        }

        .card p {
            font-size: 0.9rem;
            color: #555;
            margin-bottom: 20px;
            min-height: 120px; /* Agar tinggi card sejajar */
            flex-grow: 1;
        }

        .card-link {
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .card-green .card-link { color: #059669; }
        .card-blue .card-link { color: #0284c7; }

        .card-link:hover {
            text-decoration: underline;
        }

        /* --- INFO SECTION (BOTTOM) --- */
        .info-section {
            background-color: var(--bg-info-blue);
            padding: 30px;
            border-radius: 12px;
            border: 1px solid #e0f2fe;
        }

        .info-section h3 {
            color: #3b82f6;
            margin-bottom: 20px;
            font-size: 1.3rem;
        }

        .info-item {
            margin-bottom: 15px;
            font-size: 0.95rem;
            color: #333;
        }

        .info-item strong {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }

        /* --- RESPONSIVE MOBILE --- */
        @media (max-width: 768px) {
            .cards-container {
                grid-template-columns: 1fr; /* Stack cards on mobile */
            }
            
            .hero-header {
                padding: 40px 20px;
            }
            
            .hero-header h1 {
                font-size: 2rem;
            }
        }
    </style>

    <header class="hero-header">
        <div class="container">
            <h1>Layanan Masyarakat</h1>
            <p>Berbagai layanan administrasi dan pelayanan publik untuk kemudahan masyarakat Kelurahan Gunung Sugih</p>
        </div>
    </header>

    <main class="container main-content">
        
        <h2 class="section-title">Layanan Utama</h2>

        <div class="cards-container">
            
            <div class="card card-green">
                <div class="icon-box">
                    <i class="fa-solid fa-users"></i>
                </div>
                <h3>Layanan Kependudukan</h3>
                <p>Berbagai layanan administrasi kependudukan seperti KTP, KK, Akta Kelahiran, dan dokumen kependudukan lainnya.</p>
                <a href="/layanan-kependudukan" class="card-link">Lihat Detail <i class="fa-solid fa-arrow-right"></i></a>
            </div>

            <div class="card card-blue">
                <div class="icon-box">
                    <i class="fa-regular fa-file-lines"></i>
                </div>
                <h3>Layanan Permintaan Data</h3>
                <p>Layanan permintaan data dan informasi kelurahan melalui berbagai channel: Online, Offline, dan Website.</p>
                <a href="/layanan-data" class="card-link">Lihat Detail <i class="fa-solid fa-arrow-right"></i></a>
            </div>

        </div>

        <section class="info-section">
            <h3>Informasi Pelayanan</h3>
            
            <div class="info-item">
                <strong>Jam Pelayanan:</strong>
                {!! nl2br(e($serviceInfo['service_hours'] ?? '-')) !!}
            </div>
            
            <div class="info-item">
                <strong>Lokasi Kantor:</strong>
                {!! nl2br(e($serviceInfo['office_location'] ?? '-')) !!}
            </div>
            
            <div class="info-item">
                <strong>Kontak:</strong>
                {!! nl2br(e($serviceInfo['contact'] ?? '-')) !!}
            </div>
        </section>

    </main>
@endsection

