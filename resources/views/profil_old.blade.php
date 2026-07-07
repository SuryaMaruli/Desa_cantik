@extends('layouts.app')

@section('title', 'Profil Kelurahan Gunung Sugih')

@section('content')
    <style>
        /* --- CSS RESET & GLOBAL --- */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f7f9fc;
            color: #333;
            line-height: 1.6;
        }
        .container { width: 90%; max-width: 1000px; margin: 0 auto; }

        /* --- HEADER SECTION --- */
        .header-section {
            background-color: #009688;
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
            <h2 class="profile-title">Kelurahan Gunung Sugih</h2>
            <div class="info-list">
                <div class="info-row">
                    <div class="label">Nama Kelurahan</div>
                    <div class="separator">:</div>
                    <div class="value">Ciwandan</div>
                </div>
                <div class="info-row">
                    <div class="label">Tahun Pembentukan</div>
                    <div class="separator">:</div>
                    <div class="value">2003</div>
                </div>
                <div class="info-row">
                    <div class="label">Dasar Hukum Pembentukan</div>
                    <div class="separator">:</div>
                    <div class="value">Perda Nomor 12 Tahun 2003</div>
                </div>
                <div class="info-row">
                    <div class="label">Nomor Kode Wilayah</div>
                    <div class="separator">:</div>
                    <div class="value">3672081007</div>
                </div>
                <div class="info-row">
                    <div class="label">Nomor Kode Pos</div>
                    <div class="separator">:</div>
                    <div class="value">42441</div>
            <div class="row">
                <div class="col-lg-6 mb-4">
                    <div class="info-card">
                        <h3><i class="bi bi-graph-up me-2"></i>Statistik Demografi</h3>
                        <ul class="info-list">
                            <li><strong>Jumlah Penduduk:</strong> 5.234 jiwa</li>
                            <li><strong>Laki-laki:</strong> 2.678 jiwa</li>
                            <li><strong>Perempuan:</strong> 2.556 jiwa</li>
                            <li><strong>Kepala Keluarga:</strong> 1.567 KK</li>
                            <li><strong>Luas Wilayah:</strong> 450 Ha</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="info-card">
                        <h3><i class="bi bi-award me-2"></i>Prestasi</h3>
                        <ul class="achievement-list">
                            <li><i class="bi bi-trophy-fill text-warning"></i> Desa Terbaik Tingkat Provinsi 2023</li>
                            <li><i class="bi bi-award-fill text-success"></i> Program Inovasi Pelayanan Publik</li>
                            <li><i class="bi bi-star-fill text-primary"></i> Sistem Informasi Desa Terpadu</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('styles')
<style>
    .profile-image {
        width: 150px;
        height: 150px;
        object-fit: cover;
        border: 4px solid #009688;
    }

    .leader-image {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border: 3px solid #009688;
    }

    .leader-info {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .leader-details h4 {
        margin-bottom: 5px;
        color: #009688;
    }

    .leader-details p {
        margin-bottom: 2px;
    }

    .info-card {
        background: white;
        padding: 25px;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        height: 100%;
    }

    .info-card h3 {
        color: #009688;
        margin-bottom: 20px;
        font-size: 18px;
    }

    .info-list {
        list-style: none;
        padding: 0;
    }

    .info-list li {
        padding: 8px 0;
        border-bottom: 1px solid #f0f0f0;
    }

    .info-list li:last-child {
        border-bottom: none;
    }

    .org-structure {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
    }

    .org-level {
        text-align: center;
        padding: 20px;
        background: #f8f9fa;
        border-radius: 8px;
    }

    .org-level h4 {
        color: #009688;
        margin-bottom: 10px;
    }

    .achievement-list {
        list-style: none;
        padding: 0;
    }

    .achievement-list li {
        padding: 10px 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }
</style>
@endpush
