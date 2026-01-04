@extends('layouts.app')

@section('title', 'Layanan Kependudukan - Kelurahan Citangkil')

@section('content')
    <style>
        /* --- 1. RESET & GLOBAL VARIABLES --- */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            /* Warna Utama */
            --primary-green: #00897B;
            --text-dark: #1f2937;
            --text-muted: #4b5563;
            
            /* Warna Komponen Info */
            --info-bg: #eff6ff;
            --info-border: #3b82f6;
            --info-text: #1e40af;

            /* Warna Tema Card (Background & Icon) */
            --card-green-bg: #ecfdf5;
            --card-green-icon: #10b981;
            
            --card-blue-bg: #eff6ff;
            --card-blue-icon: #3b82f6;
            
            --card-purple-bg: #faf5ff;
            --card-purple-icon: #a855f7;
            
            --card-teal-bg: #f0fdfa;
            --card-teal-icon: #14b8a6;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #ffffff;
            color: var(--text-dark);
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }

        .container {
            max-width: 1100px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* --- 2. HEADER SECTION --- */
        .page-header {
            background-color: var(--primary-green);
            color: white;
            padding: 60px 0;
            margin-bottom: 50px;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: white;
            text-decoration: none;
            font-size: 0.95rem;
            margin-bottom: 25px;
            opacity: 0.9;
            transition: opacity 0.2s;
        }

        .back-link:hover {
            opacity: 1;
            text-decoration: underline;
        }

        .page-header h1 {
            font-size: 2.5rem;
            font-weight: 500;
            margin-bottom: 15px;
            letter-spacing: -0.5px;
        }

        .page-header p {
            font-size: 1.1rem;
            opacity: 0.9;
            max-width: 700px;
            line-height: 1.6;
        }

        /* --- 3. INFO ALERT BOX --- */
        .info-alert {
            background-color: var(--info-bg);
            border-left: 5px solid var(--info-border);
            border-radius: 8px;
            padding: 30px;
            margin-bottom: 50px;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .info-header {
            display: flex;
            align-items: center;
            gap: 12px;
            color: var(--info-text);
            font-weight: 600;
            font-size: 1.1rem;
        }

        .info-header i {
            font-size: 1.4rem;
        }

        .info-list {
            list-style: none;
            padding-left: 36px; /* Align with text inside header */
        }

        .info-list li {
            position: relative;
            margin-bottom: 8px;
            color: #1e3a8a;
            font-size: 0.95rem;
        }

        .info-list li::before {
            content: "•";
            color: var(--info-border);
            font-weight: bold;
            position: absolute;
            left: -15px;
        }

        /* --- 4. SERVICES GRID SYSTEM --- */
        .services-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr); /* 2 Kolom */
            gap: 30px;
            margin-bottom: 80px;
        }

        .service-card {
            padding: 35px;
            border-radius: 20px;
            border: 1px solid transparent;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0,0,0,0.02);
        }

        .service-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.08);
        }

        /* Tema Warna Card */
        .theme-green { background-color: var(--card-green-bg); }
        .theme-blue { background-color: var(--card-blue-bg); }
        .theme-purple { background-color: var(--card-purple-bg); }
        .theme-teal { background-color: var(--card-teal-bg); }

        /* Icon Box di dalam Card */
        .card-icon {
            width: 55px;
            height: 55px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.6rem;
            margin-bottom: 25px;
        }

        .theme-green .card-icon { background-color: #d1fae5; color: var(--card-green-icon); }
        .theme-blue .card-icon { background-color: #dbeafe; color: var(--card-blue-icon); }
        .theme-purple .card-icon { background-color: #f3e8ff; color: var(--card-purple-icon); }
        .theme-teal .card-icon { background-color: #ccfbf1; color: var(--card-teal-icon); }

        /* Typography Card */
        .service-card h3 {
            font-size: 1.25rem;
            margin-bottom: 12px;
            color: #111827;
            font-weight: 600;
        }

        .service-card p {
            color: var(--text-muted);
            margin-bottom: 25px;
            font-size: 0.95rem;
            min-height: 45px;
        }

        /* Requirements List */
        .req-label {
            display: block;
            font-weight: 600;
            font-size: 0.9rem;
            margin-bottom: 12px;
            color: #374151;
        }

        .req-list {
            list-style: none;
        }

        .req-list li {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            font-size: 0.9rem;
            color: #4b5563;
            margin-bottom: 10px;
            line-height: 1.5;
        }

        .req-list li i {
            margin-top: 3px;
            flex-shrink: 0;
        }

        /* Warna Check Icon sesuai Tema */
        .theme-green .req-list i { color: var(--card-green-icon); }
        .theme-blue .req-list i { color: var(--card-blue-icon); }
        .theme-purple .req-list i { color: var(--card-purple-icon); }
        .theme-teal .req-list i { color: var(--card-teal-icon); }

        /* --- 5. RESPONSIVE MEDIA QUERIES --- */
        @media (max-width: 768px) {
            .page-header {
                padding: 40px 0;
            }
            
            .page-header h1 {
                font-size: 2rem;
            }
            
            .services-grid {
                grid-template-columns: 1fr; /* 1 Kolom di HP */
                gap: 20px;
            }
            
            .info-list {
                padding-left: 0; /* Reset padding di mobile agar rapi */
            }
            
            .info-list li {
                padding-left: 15px;
            }
        }
    </style>

    <header class="page-header">
        <div class="container">
            <a href="/layanan" class="back-link">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Layanan
            </a>
            <h1>Layanan Kependudukan</h1>
            <p>Layanan administrasi kependudukan untuk pengurusan dokumen kependudukan seperti KTP, KK, Akta Kelahiran, dan lainnya</p>
        </div>
    </header>

    <main class="container">
        
        <div class="info-alert">
            <div class="info-header">
                <i class="fa-solid fa-circle-exclamation"></i>
                <span>Informasi Penting</span>
            </div>
            <ul class="info-list">
                <li>Semua layanan kependudukan dilayani di Kantor Kelurahan Citangkil</li>
                <li>Pastikan semua berkas persyaratan sudah lengkap dan asli</li>
                <li>Waktu pelayanan: Senin - Jumat, 08.00 - 15.00 WIB</li>
                <li>Untuk informasi lebih lanjut, hubungi (0254) 123-4567</li>
            </ul>
        </div>

        <div class="services-grid">

            <div class="service-card theme-green">
                <div class="card-icon">
                    <i class="fa-regular fa-id-card"></i>
                </div>
                <h3>Pembuatan E-KTP</h3>
                <p>Pengurusan KTP elektronik baru, perpanjangan, dan penggantian.</p>
                
                <span class="req-label">Persyaratan:</span>
                <ul class="req-list">
                    <li><i class="fa-regular fa-circle-check"></i> Pengantar RT/RW</li>
                    <li><i class="fa-regular fa-circle-check"></i> Fotocopi Kartu Keluarga</li>
                    <li><i class="fa-regular fa-circle-check"></i> Membawa Kartu Keluarga Asli</li>
                    <li><i class="fa-regular fa-circle-check"></i> Fotocopi Buku Nikah</li>
                    <li><i class="fa-regular fa-circle-check"></i> Membawa data dukungan apabila terdapat perubahan elemen data</li>
                    <li><i class="fa-regular fa-circle-check"></i> Surat Keterangan Kehilangan dari Kelurahan jika hilang</li>
                </ul>
            </div>

            <div class="service-card theme-blue">
                <div class="card-icon">
                    <i class="fa-solid fa-users"></i>
                </div>
                <h3>KK Baru/Perubahan</h3>
                <p>Pengurusan Kartu Keluarga baru atau perubahan data anggota keluarga.</p>
                
                <span class="req-label">Persyaratan:</span>
                <ul class="req-list">
                    <li><i class="fa-regular fa-circle-check"></i> Pengantar RT/RW</li>
                    <li><i class="fa-regular fa-circle-check"></i> Kartu Keluarga Asli</li>
                    <li><i class="fa-regular fa-circle-check"></i> FC Kartu Keluarga Induk suami istri</li>
                    <li><i class="fa-regular fa-circle-check"></i> FC Buku Nikah yang bersangkutan</li>
                    <li><i class="fa-regular fa-circle-check"></i> FC Buku Nikah Kartu Keluarga Induk</li>
                    <li><i class="fa-regular fa-circle-check"></i> Surat Pindah (SKPWNI) bila salah satu bukan Penduduk Kota Cilegon</li>
                </ul>
            </div>

            <div class="service-card theme-purple">
                <div class="card-icon">
                    <i class="fa-solid fa-file-contract"></i>
                </div>
                <h3>KK Hilang</h3>
                <p>Pengurusan Kartu Keluarga yang hilang.</p>
                
                <span class="req-label">Persyaratan:</span>
                <ul class="req-list">
                    <li><i class="fa-regular fa-circle-check"></i> Pengantar RT/RW</li>
                    <li><i class="fa-regular fa-circle-check"></i> Surat Keterangan hilang dari Kepolisian</li>
                    <li><i class="fa-regular fa-circle-check"></i> FC Kartu Keluarga/KTP/Buku Nikah</li>
                    <li><i class="fa-regular fa-circle-check"></i> FC Data Pendukung</li>
                </ul>
            </div>

            <div class="service-card theme-teal">
                <div class="card-icon">
                    <i class="fa-solid fa-user-pen"></i>
                </div>
                <h3>KK Perubahan Elemen Data</h3>
                <p>Perubahan data spesifik pada Kartu Keluarga.</p>
                
                <span class="req-label">Persyaratan:</span>
                <ul class="req-list">
                    <li><i class="fa-regular fa-circle-check"></i> Pengantar RT/RW</li>
                    <li><i class="fa-regular fa-circle-check"></i> Kartu Keluarga Asli</li>
                    <li><i class="fa-regular fa-circle-check"></i> FC Kartu Keluarga</li>
                    <li><i class="fa-regular fa-circle-check"></i> FC Buku Nikah</li>
                    <li><i class="fa-regular fa-circle-check"></i> FC Data Pendukung Perubahan-perubahan data (Ijazah dan Akte Kelahiran)</li>
                </ul>
            </div>

        </div>
    </main>
@endsection
