@extends('layouts.app')

@section('title', 'Layanan Permintaan Data - Kelurahan Citangkil')

@section('content')
    <style>
        /* --- CSS Reset & Global --- */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background-color: #f9f9f9; color: #333; overflow-x: hidden; }

        /* --- Header Section --- */
        .header { background-color: #00856F; color: white; padding: 40px 20px 60px 20px; }
        .header-container { width: 95%; max-width: none; margin: 0 auto; }
        .back-link { display: inline-flex; align-items: center; color: white; text-decoration: none; font-size: 14px; margin-bottom: 20px; cursor: pointer; }
        .back-link i { margin-right: 8px; }
        .header h1 { font-size: 32px; font-weight: 600; margin-bottom: 15px; }
        .header p { font-size: 16px; opacity: 0.9; line-height: 1.5; max-width: 600px; }

        /* --- Main Content Section --- */
        .main-content { width: 95%; max-width: none; margin: 0 auto; padding: 40px 20px 0 20px; }
        .section-title { text-align: center; margin-bottom: 40px; }
        .section-title h2 { color: #00856F; font-size: 24px; margin-bottom: 10px; }
        .section-title p { color: #666; font-size: 14px; }

        /* --- CARD STYLE (Layanan) --- */
        .service-card {
            border-radius: 16px;
            padding: 40px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            margin-bottom: 40px;
        }

        /* --- THEME COLORS --- */
        /* Hijau (WhatsApp) */
        .theme-green { background-color: #F0FDF9; }
        .theme-green .icon-box { background-color: #009688; }
        .theme-green h3 { color: #00856F; }
        .theme-green .step-number { background-color: #C8E6C9; color: #2E7D32; }

        /* Biru (Offline) */
        .theme-blue { background-color: #F0F8FF; }
        .theme-blue .icon-box { background-color: #1877F2; }
        .theme-blue h3 { color: #1877F2; }
        .theme-blue .step-number { background-color: #D1E9FF; color: #1877F2; }

        /* Ungu (Website) */
        .theme-purple { background-color: #FDF2FF; }
        .theme-purple .icon-box { background-color: #A020F0; }
        .theme-purple h3 { color: #A020F0; }
        .theme-purple .step-number { background-color: #F3E5F5; color: #A020F0; }

        /* --- Common Elements --- */
        .method-header { display: flex; align-items: center; margin-bottom: 30px; }
        .icon-box { width: 50px; height: 50px; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; font-size: 24px; margin-right: 15px; }
        .method-info h3 { font-size: 20px; margin-bottom: 4px; }
        .method-info p { color: #666; font-size: 14px; }

        /* --- Steps Grid --- */
        .steps-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 20px;
        }
        .step-item {
            background-color: white;
            padding: 25px;
            border-radius: 12px;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            height: 100%;
            box-shadow: 0 2px 8px rgba(0,0,0,0.03);
        }
        .step-number {
            width: 35px; height: 35px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-weight: bold; font-size: 14px; margin-bottom: 20px;
        }
        .step-item h4 { font-size: 15px; color: #333; margin-bottom: 8px; font-weight: 600; }
        .step-item p { font-size: 13px; color: #666; line-height: 1.5; }
        .step-link { color: inherit; text-decoration: underline; word-break: break-all; font-weight: 600; }

        /* --- CTA Box (Google Form) --- */
        .cta-box {
            background-color: white; border-radius: 12px; padding: 30px; margin-top: 30px;
            text-align: center; box-shadow: 0 2px 8px rgba(0,0,0,0.03);
            display: flex; flex-direction: column; align-items: center; justify-content: center;
        }
        .cta-box h4 { margin-bottom: 15px; font-weight: 500; font-size: 16px; }
        .btn-purple {
            background-color: #A020F0; color: white; text-decoration: none; padding: 12px 30px;
            border-radius: 8px; font-weight: 600; display: inline-flex; align-items: center; transition: background 0.3s;
        }
        .btn-purple:hover { background-color: #8a1bc9; }
        .btn-purple i { margin-right: 8px; }
        .cta-caption { margin-top: 15px; font-size: 12px; color: #888; }


        /* --- INFO SECTION (Bagian Baru Paling Bawah) --- */
        .info-section {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .info-card {
            background-color: white;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
        }

        .info-header {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .info-header i {
            font-size: 22px;
            margin-right: 12px;
        }

        .info-header h4 {
            font-size: 16px;
            font-weight: 600;
            color: #333;
        }

        .info-content p {
            font-size: 14px;
            color: #555;
            line-height: 1.6;
            margin-bottom: 8px;
        }

        /* Warna Khusus untuk Header Info */
        .text-green { color: #00856F; }
        .text-blue { color: #1877F2; }
        .text-purple { color: #A020F0; }

        /* --- Responsive --- */
        @media (max-width: 768px) {
            .header h1 { font-size: 24px; }
            .service-card { padding: 20px; }
            .steps-grid, .info-section { grid-template-columns: 1fr; }
        }
    </style>

    <header class="header">
        <div class="header-container">
            <a href="/layanan" class="back-link"><i class="fas fa-arrow-left"></i> Kembali ke Layanan</a>
            <h1>Layanan Permintaan Data</h1>
            <p>Ajukan permintaan data dan informasi kelurahan dengan mudah melalui berbagai channel yang tersedia</p>
        </div>
    </header>

    <main class="main-content">
        
        <section class="section-title">
            <h2>Pilih Cara Permintaan Data</h2>
            <p>Kami menyediakan 3 cara untuk memudahkan Anda dalam mengajukan permintaan data kelurahan</p>
        </section>

        <section class="service-card theme-green">
            <div class="method-header">
                <div class="icon-box"><i class="fab fa-whatsapp"></i></div>
                <div class="method-info">
                    <h3>Online (WhatsApp)</h3>
                    <p>Ajukan permintaan data melalui WhatsApp</p>
                </div>
            </div>
            <div class="steps-grid">
                <div class="step-item">
                    <div class="step-number">1</div>
                    <h4>Siapkan Data</h4>
                    <p>Nama, alamat, dan jenis data yang dibutuhkan</p>
                </div>
                <div class="step-item">
                    <div class="step-number">2</div>
                    <h4>Hubungi WhatsApp</h4>
                    <p><a href="#" class="step-link" style="color: #00856F;">wa.me/62878...</a></p>
                </div>
                <div class="step-item">
                    <div class="step-number">3</div>
                    <h4>Tunggu Konfirmasi</h4>
                    <p>Petugas akan memberikan instruksi lebih lanjut</p>
                </div>
                <div class="step-item">
                    <div class="step-number">4</div>
                    <h4>Ambil Data</h4>
                    <p>Data dikirimkan atau diambil langsung sesuai instruksi</p>
                </div>
            </div>
        </section>

        <section class="service-card theme-blue">
            <div class="method-header">
                <div class="icon-box"><i class="fas fa-building"></i></div>
                <div class="method-info">
                    <h3>Offline (Datang Langsung)</h3>
                    <p>Kunjungi kantor kelurahan secara langsung</p>
                </div>
            </div>
            <div class="steps-grid">
                <div class="step-item">
                    <div class="step-number">1</div>
                    <h4>Siapkan Dokumen</h4>
                    <p>KTP, surat permohonan, dan informasi data yang dibutuhkan</p>
                </div>
                <div class="step-item">
                    <div class="step-number">2</div>
                    <h4>Kunjungi Kantor</h4>
                    <p>Buka Senin – Jumat<br>08:00 – 15:30 WIB</p>
                </div>
                <div class="step-item">
                    <div class="step-number">3</div>
                    <h4>Sampaikan Permintaan</h4>
                    <p>Berikan data yang diperlukan kepada petugas</p>
                </div>
                <div class="step-item">
                    <div class="step-number">4</div>
                    <h4>Tunggu Proses</h4>
                    <p>Petugas akan mengolah data</p>
                </div>
                <div class="step-item">
                    <div class="step-number">5</div>
                    <h4>Ambil Data</h4>
                    <p>Ambil data pada waktu yang ditentukan</p>
                </div>
            </div>
        </section>

        <section class="service-card theme-purple">
            <div class="method-header">
                <div class="icon-box"><i class="fas fa-globe"></i></div>
                <div class="method-info">
                    <h3>Website (Google Form)</h3>
                    <p>Isi formulir permintaan data secara online</p>
                </div>
            </div>
            <div class="steps-grid">
                <div class="step-item">
                    <div class="step-number">1</div>
                    <h4>Siapkan Dokumen</h4>
                    <p>Nama, alamat, dan jenis data yang dibutuhkan</p>
                </div>
                <div class="step-item">
                    <div class="step-number">2</div>
                    <h4>Isikan Form</h4>
                    <p>Lengkapi formulir permintaan data secara online</p>
                </div>
                <div class="step-item">
                    <div class="step-number">3</div>
                    <h4>Tunggu Proses</h4>
                    <p>Petugas akan mengolah data</p>
                </div>
                <div class="step-item">
                    <div class="step-number">4</div>
                    <h4>Terima Data</h4>
                    <p>Terima data pada waktu yang ditentukan</p>
                </div>
            </div>
            <div class="cta-box">
                <h4>Formulir Permintaan Data</h4>
                <a href="#" class="btn-purple"><i class="fas fa-globe"></i> Isi Google Form</a>
                <p class="cta-caption">Klik tombol di atas untuk mengisi formulir permintaan data</p>
            </div>
        </section>

        <section class="info-section">
            
            <div class="info-card">
                <div class="info-header">
                    <i class="fas fa-map-marker-alt text-green"></i>
                    <h4>Lokasi Kantor</h4>
                </div>
                <div class="info-content">
                    <p><strong>Kantor Kelurahan Citangkil</strong></p>
                    <p>Jl. Raya Citangkil No. 123</p>
                    <p>Kota Cilegon, Banten 42441</p>
                </div>
            </div>

            <div class="info-card">
                <div class="info-header">
                    <i class="far fa-clock text-blue"></i>
                    <h4>Jam Pelayanan</h4>
                </div>
                <div class="info-content">
                    <p>Senin – Jumat</p>
                    <p>08:00 – 15:30 WIB</p>
                    <p style="color: #888; font-size: 13px; margin-top: 5px;">(Tutup pada hari libur nasional)</p>
                </div>
            </div>

            <div class="info-card">
                <div class="info-header">
                    <i class="fas fa-phone-alt text-purple"></i>
                    <h4>Kontak</h4>
                </div>
                <div class="info-content">
                    <p>Telepon: (0254) 123-4567</p>
                    <p>WhatsApp: +62 878-5351-6685</p>
                    <p>Email: kelurahan@citangkil.go.id</p>
                </div>
            </div>

        </section>

    </main>
@endsection
