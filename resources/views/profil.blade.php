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
        /* --- 5. IMAGE/BOARD STYLING (BARU) --- */
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





