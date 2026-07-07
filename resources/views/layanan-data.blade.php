@extends('layouts.app')

@section('title', 'Layanan Permintaan Data - Kelurahan Gunung Sugih')

@section('content')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* --- CSS Reset & Global --- */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background-color: #ffffff; color: #333; overflow-x: hidden; }

        /* --- HEADER SECTION --- */
        .hero {
            background-color: #F79433; 
            color: white;
            padding: 40px 5%;
            padding-bottom: 80px;
        }
        .header-container { max-width: 1200px; margin: 0 auto; padding: 0 20px; }
        .back-link {
            text-decoration: none; color: white; font-size: 14px;
            display: inline-flex; align-items: center; gap: 8px;
            margin-bottom: 25px; font-weight: 500;
        }
        .back-link:hover { text-decoration: underline; }
        .hero h1 { font-size: 36px; font-weight: 600; margin-bottom: 15px; }
        .hero p { font-size: 16px; max-width: 600px; opacity: 0.9; line-height: 1.5; }

        /* --- MAIN CONTAINER --- */
        .container {
            max-width: 1200px; margin: 0 auto; padding: 0 20px;
            margin-top: -40px; padding-bottom: 80px;
        }

        /* --- SECTION TITLE --- */
        .section-header { text-align: center; margin-top: 60px; margin-bottom: 40px; }
        .section-header h2 { color: #D84E25; font-size: 28px; font-weight: 600; margin-bottom: 15px; }
        .section-header p { color: #666; max-width: 600px; margin: 0 auto; }

        /* --- CARD STYLES --- */
        .method-card {
            background-color: #FFF9EF; border-radius: 20px; padding: 40px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05); margin-bottom: 50px;
        }
        .method-header { display: flex; align-items: center; gap: 20px; margin-bottom: 30px; }
        .icon-box {
            background-color: #F03E1A; width: 60px; height: 60px; border-radius: 12px;
            display: flex; justify-content: center; align-items: center;
            color: white; font-size: 24px; flex-shrink: 0;
        }
        .icon-box.google-icon { background-color: #E65100; } /* Style khusus Google */

        .method-info h3 { color: #D84E25; font-size: 22px; margin-bottom: 5px; font-weight: 700; }
        .method-info p { color: #666; font-size: 14px; }

        /* --- GRID STEPS --- */
        .steps-grid { display: grid; gap: 20px; }
        .cols-4 { grid-template-columns: repeat(4, 1fr); }
        .cols-5 { grid-template-columns: repeat(5, 1fr); }

        .step-item {
            background-color: white; padding: 25px; border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.03);
            display: flex; flex-direction: column; align-items: flex-start; height: 100%;
        }
        .step-number {
            background-color: #FFECCB; color: #E67E22;
            width: 36px; height: 36px; border-radius: 50%;
            display: flex; justify-content: center; align-items: center;
            font-weight: bold; font-size: 14px; margin-bottom: 15px;
        }
        .step-number.yellow { background-color: #FFF5CC; color: #D9A404; } /* Style khusus nomor Google */

        .step-item h4 { font-size: 15px; margin-bottom: 8px; color: #333; font-weight: 600; }
        .step-item p { font-size: 13px; color: #666; line-height: 1.5; width: 100%; }
        .step-item p a { color: #F79433; text-decoration: underline; word-break: break-all; font-weight: 500; }

        /* --- CTA BOX (Google Form) --- */
        .cta-container {
            background-color: white; border-radius: 15px; padding: 30px; margin-top: 30px;
            text-align: center; box-shadow: 0 2px 10px rgba(0,0,0,0.03);
        }
        .cta-container h4 { margin-bottom: 15px; color: #333; font-weight: 600; }
        .btn-google {
            display: inline-flex; align-items: center; gap: 10px;
            background-color: #E65100; color: white; text-decoration: none;
            padding: 12px 40px; border-radius: 8px; font-weight: 600;
            transition: background 0.3s; margin-bottom: 10px;
        }
        .btn-google:hover { background-color: #C44200; }
        .cta-note { font-size: 13px; color: #888; }

        /* --- INFO SECTION --- */
        .info-section-wrapper { margin-top: 60px; border-top: 1px solid #eee; padding-top: 40px; }
        .info-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 25px; }
        .info-card {
            background-color: white; border: 1px solid #f0f0f0; padding: 25px;
            border-radius: 16px; display: flex; flex-direction: column; transition: transform 0.2s;
        }
        .info-card:hover { transform: translateY(-5px); border-color: #F79433; }
        .info-header { display: flex; align-items: center; margin-bottom: 15px; }
        .info-header i { font-size: 20px; margin-right: 12px; color: #F79433; }
        .info-header h4 { font-size: 16px; font-weight: 600; color: #333; }
        .info-content p { font-size: 14px; color: #555; line-height: 1.6; margin-bottom: 5px; }

        /* --- RESPONSIVE --- */
        @media (max-width: 1024px) {
            .cols-4, .cols-5 { grid-template-columns: repeat(2, 1fr); }
            .info-grid { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 600px) {
            .hero h1 { font-size: 28px; }
            .cols-4, .cols-5, .info-grid { grid-template-columns: 1fr; }
            .method-card { padding: 25px; }
            .method-header { flex-direction: column; text-align: center; }
            .container { padding: 0 15px; }
        }
    </style>

    <header class="hero">
        <div class="header-container">
            <a href="{{ url('/layanan') }}" class="back-link">
                <i class="fas fa-arrow-left"></i> Kembali ke Layanan
            </a>
            <h1>Layanan Permintaan Data</h1>
            <p>Ajukan permintaan data dan informasi kelurahan dengan mudah melalui berbagai channel yang tersedia.</p>
        </div>
    </header>

    <main class="container">
        
        <section class="section-header">
            <h2>Pilih Cara Permintaan Data</h2>
            <p>Kami menyediakan berbagai cara untuk memudahkan Anda dalam mengajukan permintaan data</p>
        </section>

        {{-- 
            1. LOOPING DARI DATABASE 
            (Untuk WhatsApp, Offline, dll yang diinput dari Admin)
        --}}
        @foreach($layananData as $layanan)
            @php
                // Logika Icon & Judul dinamis sederhana
                $iconClass = 'fas fa-clipboard-list'; // Default
                $subTitle = 'Ikuti langkah-langkah berikut';

                if (stripos($layanan->nama_layanan, 'WhatsApp') !== false) {
                    $iconClass = 'fab fa-whatsapp';
                    $subTitle = 'Ajukan permintaan data melalui WhatsApp';
                } elseif (stripos($layanan->nama_layanan, 'Offline') !== false || stripos($layanan->nama_layanan, 'Langsung') !== false) {
                    $iconClass = 'fas fa-building';
                    $subTitle = 'Kunjungi kantor kelurahan secara langsung';
                }
                
                // Menghitung kolom grid
                $gridClass = count($layanan->persyaratan) >= 5 ? 'cols-5' : 'cols-4';
            @endphp

            {{-- Filter: Jangan tampilkan "Website/Google" dari DB jika user tidak sengaja menginputnya, 
                 karena kita sudah punya card statis di bawah. Opsional. --}}
            @if(stripos($layanan->nama_layanan, 'Google') === false && stripos($layanan->nama_layanan, 'Website') === false)
            
            <div class="method-card">
                <div class="method-header">
                    <div class="icon-box"><i class="{{ $iconClass }}"></i></div>
                    <div class="method-info">
                        <h3>{{ $layanan->nama_layanan }}</h3>
                        <p>{{ $subTitle }}</p>
                    </div>
                </div>

                <div class="steps-grid {{ $gridClass }}">
                    @foreach($layanan->persyaratan as $index => $syarat)
                        <div class="step-item">
                            <div class="step-number">{{ $loop->iteration }}</div>
                            <h4>Langkah {{ $loop->iteration }}</h4>
                            <p>{!! $syarat !!}</p>
                        </div>
                    @endforeach
                </div>
            </div>
            
            @endif
        @endforeach


        {{-- 
            2. CARD WEBSITE (GOOGLE FORM) - STATIC / HARDCODED 
            Sesuai permintaan: Bagian ini dibiarkan manual agar desain tombol & warna tetap terjaga.
        --}}
        <div class="method-card">
            <div class="method-header">
                <div class="icon-box google-icon"><i class="fas fa-globe"></i></div>
                <div class="method-info">
                    <h3>Website (Google Form)</h3>
                    <p>Isi formulir permintaan data secara online</p>
                </div>
            </div>

            <div class="steps-grid cols-4">
                <div class="step-item">
                    <div class="step-number yellow">1</div>
                    <h4>Siapkan Dokumen</h4>
                    <p>Nama, alamat, dan jenis data yang dibutuhkan</p>
                </div>
                <div class="step-item">
                    <div class="step-number yellow">2</div>
                    <h4>Isikan Google Form</h4>
                    <p>Lengkapi formulir permintaan data secara online</p>
                </div>
                <div class="step-item">
                    <div class="step-number yellow">3</div>
                    <h4>Tunggu Proses</h4>
                    <p>Petugas akan mengolah data</p>
                </div>
                <div class="step-item">
                    <div class="step-number yellow">4</div>
                    <h4>Terima Data</h4>
                    <p>Terima data pada waktu yang ditentukan</p>
                </div>
            </div>

            <div class="cta-container">
                <h4>Formulir Permintaan Data</h4>
                {{-- Masukkan Link Google Form Anda di href --}}
                <a href="https://forms.google.com/..." target="_blank" class="btn-google">
                    <i class="fas fa-file-alt"></i> Isi Google Form
                </a>
                <p class="cta-note">Klik tombol di atas untuk mengisi formulir permintaan data</p>
            </div>
        </div>
        {{-- END CARD STATIC --}}


        {{-- INFO SECTION --}}
        <div class="info-section-wrapper">
            <div class="info-grid">
                <div class="info-card">
                    <div class="info-header">
                        <i class="fas fa-map-marker-alt"></i>
                        <h4>Lokasi Kantor</h4>
                    </div>
                    <div class="info-content">
                        <p><strong>Kantor Kelurahan Gunung Sugih</strong></p>
                        <p>Jl. Raya Bulakan No. 123</p>
                        <p>Kota Cilegon, Banten 42441</p>
                    </div>
                </div>

                <div class="info-card">
                    <div class="info-header">
                        <i class="far fa-clock"></i>
                        <h4>Jam Pelayanan</h4>
                    </div>
                    <div class="info-content">
                        <p>Senin – Jumat</p>
                        <p>08:00 – 15:30 WIB</p>
                        <p style="color: #999; font-size: 13px; margin-top: 5px;">(Tutup pada hari libur nasional)</p>
                    </div>
                </div>

                <div class="info-card">
                    <div class="info-header">
                        <i class="fas fa-headset"></i>
                        <h4>Kontak</h4>
                    </div>
                    <div class="info-content">
                        <p>Telepon: (0254) 123-4567</p>
                        <p>WhatsApp: +62 878-5351-6685</p>
                        <p>Email: admin@bulakan.go.id</p>
                    </div>
                </div>
            </div>
        </div>

    </main>
@endsection
