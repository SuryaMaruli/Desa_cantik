@extends('layouts.app')

@section('title', 'Layanan Permintaan Data - Kelurahan Citangkil')

@section('content')
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
            --primary-blue: #1e40af;
            --bg-blue-light: #eff6ff;
            --icon-bg-blue: #dbeafe;
            --text-blue: #1e40af;
            --bg-gray-light: #f8f9fa;
            --border-color: #e9ecef;
        }

        /* --- HEADER SECTION --- */
        .hero-header {
            background-color: var(--primary-blue);
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
            color: var(--primary-blue);
            font-size: 1.8rem;
            margin-bottom: 30px;
            font-weight: 500;
        }

        /* --- CHANNEL CARDS --- */
        .channels-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
            margin-bottom: 50px;
        }

        .channel-card {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 30px;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            text-align: center;
        }

        .channel-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            border-color: var(--primary-blue);
        }

        .channel-icon {
            width: 80px;
            height: 80px;
            background-color: var(--icon-bg-blue);
            color: var(--text-blue);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            margin: 0 auto 20px;
        }

        .channel-card h3 {
            font-size: 1.3rem;
            margin-bottom: 15px;
            color: #333;
            font-weight: 600;
        }

        .channel-card p {
            color: #666;
            margin-bottom: 20px;
            line-height: 1.6;
        }

        .channel-steps {
            text-align: left;
            background-color: var(--bg-gray-light);
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .channel-steps h4 {
            font-size: 0.9rem;
            margin-bottom: 15px;
            color: var(--primary-blue);
            font-weight: 600;
        }

        .channel-steps ol {
            list-style: none;
            padding: 0;
            counter-reset: step-counter;
        }

        .channel-steps li {
            padding: 8px 0;
            font-size: 0.85rem;
            color: #555;
            position: relative;
            padding-left: 35px;
            margin-bottom: 8px;
        }

        .channel-steps li::before {
            counter-increment: step-counter;
            content: counter(step-counter);
            position: absolute;
            left: 0;
            top: 8px;
            width: 25px;
            height: 25px;
            background-color: var(--primary-blue);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
            font-weight: bold;
        }

        .channel-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background-color: var(--primary-blue);
            color: white;
            padding: 12px 24px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .channel-link:hover {
            background-color: #1e3a8a;
            transform: translateX(5px);
        }

        /* --- DATA TYPES SECTION --- */
        .data-types-section {
            background-color: var(--bg-blue-light);
            padding: 40px;
            border-radius: 12px;
            border: 1px solid #dbeafe;
            margin-bottom: 40px;
        }

        .data-types-section h3 {
            color: var(--primary-blue);
            font-size: 1.4rem;
            margin-bottom: 30px;
            text-align: center;
        }

        .data-types-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .data-type-item {
            background: white;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #e0e7ff;
            text-align: center;
        }

        .data-type-item i {
            font-size: 2rem;
            color: var(--primary-blue);
            margin-bottom: 10px;
        }

        .data-type-item h4 {
            font-size: 1rem;
            margin-bottom: 8px;
            color: #333;
            font-weight: 600;
        }

        .data-type-item p {
            color: #666;
            font-size: 0.85rem;
        }

        /* --- INFO SECTION --- */
        .info-section {
            background-color: var(--bg-gray-light);
            padding: 40px;
            border-radius: 12px;
            border: 1px solid var(--border-color);
            margin-bottom: 40px;
        }

        .info-section h3 {
            color: var(--primary-blue);
            font-size: 1.4rem;
            margin-bottom: 20px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
        }

        .info-item {
            text-align: center;
        }

        .info-item i {
            font-size: 2.5rem;
            color: var(--primary-blue);
            margin-bottom: 15px;
        }

        .info-item h4 {
            font-size: 1.1rem;
            margin-bottom: 10px;
            color: #333;
        }

        .info-item p {
            color: #666;
            font-size: 0.9rem;
        }

        /* --- FAQ SECTION --- */
        .faq-section {
            margin-bottom: 40px;
        }

        .faq-item {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            margin-bottom: 15px;
            overflow: hidden;
        }

        .faq-question {
            width: 100%;
            padding: 20px;
            background: none;
            border: none;
            text-align: left;
            font-size: 1rem;
            font-weight: 600;
            color: #333;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: background-color 0.3s ease;
        }

        .faq-question:hover {
            background-color: var(--bg-gray-light);
        }

        .faq-question i {
            transition: transform 0.3s ease;
        }

        .faq-question.active i {
            transform: rotate(180deg);
        }

        .faq-answer {
            padding: 0 20px;
            max-height: 0;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .faq-answer.show {
            padding: 20px;
            max-height: 200px;
        }

        .faq-answer p {
            color: #666;
            line-height: 1.6;
        }

        /* --- RESPONSIVE --- */
        @media (max-width: 768px) {
            .hero-header {
                padding: 40px 20px;
            }
            
            .hero-header h1 {
                font-size: 2rem;
            }
            
            .channels-grid {
                grid-template-columns: 1fr;
            }
            
            .data-types-grid {
                grid-template-columns: 1fr;
            }
            
            .info-section, .data-types-section {
                padding: 25px;
            }
        }
    </style>

    <header class="hero-header">
        <div class="container">
            <h1>Layanan Permintaan Data</h1>
            <p>Akses data dan informasi kelurahan melalui berbagai channel pelayanan yang tersedia</p>
        </div>
    </header>

    <main class="container main-content">
        
        <div class="info-section">
            <h3>Informasi Layanan</h3>
            <div class="info-grid">
                <div class="info-item">
                    <i class="fa-solid fa-clock"></i>
                    <h4>Jam Pelayanan</h4>
                    <p>Senin - Jumat<br>08.00 - 15.00 WIB</p>
                </div>
                <div class="info-item">
                    <i class="fa-solid fa-location-dot"></i>
                    <h4>Lokasi</h4>
                    <p>Kantor Kelurahan Citangkil<br>Jl. Raya Citangkil No. 123</p>
                </div>
                <div class="info-item">
                    <i class="fa-solid fa-phone"></i>
                    <h4>Kontak</h4>
                    <p>(0254) 123-4567<br>data@citangkil.go.id</p>
                </div>
            </div>
        </div>

        <h2 class="section-title">Channel Pelayanan</h2>

        <div class="channels-grid">
            
            <div class="channel-card">
                <div class="channel-icon">
                    <i class="fa-solid fa-laptop"></i>
                </div>
                <h3>Layanan Online</h3>
                <p>Ajukan permintaan data secara online melalui website resmi Kelurahan Citangkil.</p>
                <div class="channel-steps">
                    <h4>Cara Pengajuan:</h4>
                    <ol>
                        <li>Kunjungi website kelurahan</li>
                        <li>Isi formulir permintaan data</li>
                        <li>Upload dokumen pendukung</li>
                        <li>Tunggu verifikasi dari admin</li>
                        <li>Data dikirim via email</li>
                    </ol>
                </div>
                <a href="#" class="channel-link">Ajukan Online <i class="fa-solid fa-arrow-right"></i></a>
            </div>

            <div class="channel-card">
                <div class="channel-icon">
                    <i class="fa-solid fa-building"></i>
                </div>
                <h3>Layanan Offline</h3>
                <p>Datang langsung ke kantor kelurahan untuk mengajukan permintaan data.</p>
                <div class="channel-steps">
                    <h4>Cara Pengajuan:</h4>
                    <ol>
                        <li>Siapkan dokumen identitas</li>
                        <li>Datang ke kantor kelurahan</li>
                        <li>Isi formulir permintaan data</li>
                        <li>Serahkan dokumen pendukung</li>
                        <li>Ambil data di lokasi atau tunggu pengiriman</li>
                    </ol>
                </div>
                <a href="#" class="channel-link">Datang Langsung <i class="fa-solid fa-arrow-right"></i></a>
            </div>

            <div class="channel-card">
                <div class="channel-icon">
                    <i class="fa-solid fa-mobile-screen"></i>
                </div>
                <h3>Layanan WhatsApp</h3>
                <p>Ajukan permintaan data melalui WhatsApp untuk kemudahan dan kecepatan.</p>
                <div class="channel-steps">
                    <h4>Cara Pengajuan:</h4>
                    <ol>
                        <li>Simpan nomor WhatsApp kelurahan</li>
                        <li>Kirim pesan dengan format permintaan</li>
                        <li>Lampirkan dokumen yang dibutuhkan</li>
                        <li>Konfirmasi identitas Anda</li>
                        <li>Data dikirim via WhatsApp</li>
                    </ol>
                </div>
                <a href="#" class="channel-link">Hubungi WA <i class="fa-solid fa-arrow-right"></i></a>
            </div>

        </div>

        <div class="data-types-section">
            <h3>Jenis Data yang Tersedia</h3>
            <div class="data-types-grid">
                <div class="data-type-item">
                    <i class="fa-solid fa-chart-line"></i>
                    <h4>Data Demografi</h4>
                    <p>Jumlah penduduk, kepadatan, pertumbuhan penduduk</p>
                </div>
                <div class="data-type-item">
                    <i class="fa-solid fa-home"></i>
                    <h4Data Wilayah</h4>
                    <p>Batas wilayah, luas area, penggunaan lahan</p>
                </div>
                <div class="data-type-item">
                    <i class="fa-solid fa-graduation-cap"></i>
                    <h4>Data Pendidikan</h4>
                    <p>Jumlah sekolah, tingkat pendidikan, fasilitas pendidikan</p>
                </div>
                <div class="data-type-item">
                    <i class="fa-solid fa-hospital"></i>
                    <h4>Data Kesehatan</h4>
                    <p>Fasilitas kesehatan, cakupan layanan, program kesehatan</p>
                </div>
                <div class="data-type-item">
                    <i class="fa-solid fa-briefcase"></i>
                    <h4Data Ekonomi</h4>
                    <p>Data usaha, tingkat pengangguran, program ekonomi</p>
                </div>
                <div class="data-type-item">
                    <i class="fa-solid fa-road"></i>
                    <h4Data Infrastruktur</h4>
                    <p>Jalan, drainase, listrik, air bersih, fasilitas umum</p>
                </div>
                <div class="data-type-item">
                    <i class="fa-solid fa-shield-alt"></i>
                    <h4>Data Keamanan</h4>
                    <p>Pos kamling, ronda, program keamanan masyarakat</p>
                </div>
                <div class="data-type-item">
                    <i class="fa-solid fa-hands-helping"></i>
                    <h4Data Sosial</h4>
                    <p>Penerima bantuan, program sosial, kegiatan kemasyarakatan</p>
                </div>
            </div>
        </div>

        <div class="faq-section">
            <h2 class="section-title">Pertanyaan Umum (FAQ)</h2>
            
            <div class="faq-item">
                <button class="faq-question" onclick="toggleFAQ(this)">
                    <span>Bagaimana cara mengajukan permintaan data?</span>
                    <i class="fa-solid fa-chevron-down"></i>
                </button>
                <div class="faq-answer">
                    <p>Anda dapat mengajukan permintaan data melalui tiga cara: online melalui website, datang langsung ke kantor, atau via WhatsApp. Pilih cara yang paling nyaman untuk Anda.</p>
                </div>
            </div>

            <div class="faq-item">
                <button class="faq-question" onclick="toggleFAQ(this)">
                    <span>Dokumen apa yang diperlukan untuk pengajuan data?</span>
                    <i class="fa-solid fa-chevron-down"></i>
                </button>
                <div class="faq-answer">
                    <p>Umumnya diperlukan KTP, KK, dan surat pengantar RT/RW. Untuk data tertentu mungkin diperlukan dokumen tambahan sesuai dengan jenis data yang diminta.</p>
                </div>
            </div>

            <div class="faq-item">
                <button class="faq-question" onclick="toggleFAQ(this)">
                    <span>Berapa lama waktu pemrosesan permintaan data?</span>
                    <i class="fa-solid fa-chevron-down"></i>
                </button>
                <div class="faq-answer">
                    <p>Waktu pemrosesan biasanya 1-3 hari kerja tergantung pada kompleksitas data yang diminta. Data yang umum tersedia bisa lebih cepat, sedangkan data khusus memerlukan waktu lebih lama.</p>
                </div>
            </div>

            <div class="faq-item">
                <button class="faq-question" onclick="toggleFAQ(this)">
                    <span>Apakah ada biaya untuk permintaan data?</span>
                    <i class="fa-solid fa-chevron-down"></i>
                </button>
                <div class="faq-answer">
                    <p>Data umum untuk kepentingan masyarakat biasanya gratis. Namun untuk data khusus atau dalam jumlah besar mungkin dikenakan biaya administrasi sesuai dengan peraturan yang berlaku.</p>
                </div>
            </div>

        </div>

    </main>

    <script>
        function toggleFAQ(button) {
            const answer = button.nextElementSibling;
            const allQuestions = document.querySelectorAll('.faq-question');
            const allAnswers = document.querySelectorAll('.faq-answer');
            
            // Close all other FAQs
            allQuestions.forEach(q => {
                if (q !== button) {
                    q.classList.remove('active');
                }
            });
            
            allAnswers.forEach(a => {
                if (a !== answer) {
                    a.classList.remove('show');
                }
            });
            
            // Toggle current FAQ
            button.classList.toggle('active');
            answer.classList.toggle('show');
        }
    </script>
@endsection
