@extends('layouts.app')

@section('title', 'Beranda - Kelurahan Citangkil')

@section('content')
    <!-- Hero Section -->
    <section id="home" class="hero">
        <div class="container">
            @php
                $beranda = App\Models\Beranda::first();
            @endphp
            @if($beranda && $beranda->logo)
                <div class="text-center mb-4">
                    <img src="{{ asset('storage/' . $beranda->logo) }}" alt="{{ $beranda->nama_kelurahan ?? 'Logo Kelurahan' }}" 
                         style="max-width: 100px; max-height: 100px; border-radius: 50%; background: white; padding: 8px; box-shadow: 0 8px 25px rgba(0,0,0,0.25); border: 3px solid white; position: relative; z-index: 2;">
                </div>
            @endif
            <h1>{{ $beranda->nama_kelurahan ?? 'Selamat Datang di Kelurahan Citangkil' }}</h1>
            <p class="lead">{{ $beranda->deskripsi ?? 'Melayani dengan hati untuk kesejahteraan masyarakat yang lebih baik' }}</p>
            <div class="mt-4">
                <a href="/layanan" class="btn btn-primary btn-lg me-3">Lihat Layanan</a>
                <a href="/kontak" class="btn btn-outline-light btn-lg">Hubungi Kami</a>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="about">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h2>Tentang Kelurahan Citangkil</h2>
                    <p class="lead">Kelurahan Citangkil adalah salah satu kelurahan yang terletak di Kecamatan Citangkil, Kota Cilegon. Kami berkomitmen untuk memberikan pelayanan terbaik kepada seluruh masyarakat.</p>
                    <p>Dengan didukung oleh perangkat kelurahan yang profesional dan berdedikasi, kami terus berinovasi dalam meningkatkan kualitas pelayanan publik untuk menciptakan masyarakat yang sejahtera dan mandiri.</p>
                    <ul class="list-unstyled mt-4">
                        <li><i class="bi bi-check-circle text-success me-2"></i> Pelayanan yang cepat dan tepat</li>
                        <li><i class="bi bi-check-circle text-success me-2"></i> Transparan dan akuntabel</li>
                        <li><i class="bi bi-check-circle text-success me-2"></i> Melayani dengan hati</li>
                    </ul>
                </div>
                <div class="col-lg-6">
                    @if($beranda && $beranda->gambar_header)
                        <img src="{{ asset('storage/' . $beranda->gambar_header) }}" class="img-fluid rounded" alt="Gambar Header">
                    @else
                        <img src="https://images.unsplash.com/photo-1486312338219-ce68d2C6f44d?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80" class="img-fluid rounded" alt="About Us">
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center mb-5">
                    <h2>Keunggulan Kami</h2>
                    <p class="lead">Berbagai keunggulan yang menjadi nilai tambah dalam pelayanan kami</p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="feature-card text-center">
                        <div class="feature-icon">
                            <i class="bi bi-speedometer2"></i>
                        </div>
                        <h4>Pelayanan Cepat</h4>
                        <p>Proses pelayanan yang cepat dan efisien untuk kemudahan masyarakat.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="feature-card text-center">
                        <div class="feature-icon">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <h4>Amanah</h4>
                        <p>Menjalankan tugas dengan penuh tanggung jawab dan kepercayaan.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="feature-card text-center">
                        <div class="feature-icon">
                            <i class="bi bi-people"></i>
                        </div>
                        <h4>Profesional</h4>
                        <p>Tim yang profesional dan berpengalaman dalam melayani masyarakat.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <style>
        .visit-stats-section {
            background: #ffffff;
            padding: 20px 0 36px;
        }

        .visit-stats-title {
            font-size: 1.4rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 18px;
        }

.visit-stats-grid {
            display: flex;
            flex-wrap: nowrap;
            gap: 14px;
            overflow-x: auto;
        }

        @media (max-width: 575px) {
            .visit-stats-grid .visit-stat-card {
                min-width: calc(50% - 7px);
                flex: 0 0 calc(50% - 7px);
            }
        }

        @media (min-width: 576px) {
            .visit-stats-grid .visit-stat-card {
                min-width: calc(25% - 10.5px);
                flex: 0 0 calc(25% - 10.5px);
            }
        }

        .visit-stat-card {
            border: 1px solid #f0f0f0;
            border-radius: 12px;
            padding: 18px;
            background: #fff8f2;
            box-shadow: 0 6px 18px rgba(248, 144, 57, 0.08);
        }

        .visit-stat-label {
            font-size: 0.95rem;
            color: #666;
            margin-bottom: 8px;
        }

        .visit-stat-value {
            font-size: 1.8rem;
            font-weight: 700;
            color: #F89039;
            line-height: 1.2;
        }
    </style>

@php
        $uniqueStats = $visitStats['unique'] ?? ['daily' => 0, 'weekly' => 0, 'monthly' => 0, 'total' => 0];
        $visitorStats = $visitStats['visitor'] ?? ['daily' => 0, 'weekly' => 0, 'monthly' => 0, 'total' => 0];
    @endphp
    <section class="visit-stats-section">
        <div class="container">
            <h2 class="visit-stats-title">Jumlah Pengunjung Unik</h2>
            <p style="font-size: 0.85rem; color: #888; margin-bottom: 14px;">Cookie berlaku 1 tahun - 1 orang diakses beberapa kali tetap dihitung 1x</p>
            <div class="visit-stats-grid">
                <div class="visit-stat-card">
                    <p class="visit-stat-label">Harian</p>
                    <p class="visit-stat-value">{{ number_format($uniqueStats['daily'] ?? 0, 0, ',', '.') }}</p>
                </div>
                <div class="visit-stat-card">
                    <p class="visit-stat-label">Mingguan</p>
                    <p class="visit-stat-value">{{ number_format($uniqueStats['weekly'] ?? 0, 0, ',', '.') }}</p>
                </div>
                <div class="visit-stat-card">
                    <p class="visit-stat-label">Bulanan</p>
                    <p class="visit-stat-value">{{ number_format($uniqueStats['monthly'] ?? 0, 0, ',', '.') }}</p>
                </div>
                <div class="visit-stat-card">
                    <p class="visit-stat-label">Total</p>
                    <p class="visit-stat-value">{{ number_format($uniqueStats['total'] ?? 0, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
    </section>

    <section class="visit-stats-section">
        <div class="container">
            <h2 class="visit-stats-title">Jumlah Kunjungan Website</h2>
            <p style="font-size: 0.85rem; color: #888; margin-bottom: 14px;">Session berlaku 30 menit - Setiap akses dihitung</p>
            <div class="visit-stats-grid">
                <div class="visit-stat-card">
                    <p class="visit-stat-label">Harian</p>
                    <p class="visit-stat-value">{{ number_format($visitorStats['daily'] ?? 0, 0, ',', '.') }}</p>
                </div>
                <div class="visit-stat-card">
                    <p class="visit-stat-label">Mingguan</p>
                    <p class="visit-stat-value">{{ number_format($visitorStats['weekly'] ?? 0, 0, ',', '.') }}</p>
                </div>
                <div class="visit-stat-card">
                    <p class="visit-stat-label">Bulanan</p>
                    <p class="visit-stat-value">{{ number_format($visitorStats['monthly'] ?? 0, 0, ',', '.') }}</p>
                </div>
                <div class="visit-stat-card">
                    <p class="visit-stat-label">Total</p>
                    <p class="visit-stat-value">{{ number_format($visitorStats['total'] ?? 0, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    // Smooth scrolling for navigation links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Active navigation highlighting
    window.addEventListener('scroll', function() {
        const sections = document.querySelectorAll('section');
        const navLinks = document.querySelectorAll('.nav-links a');
        
        let current = '';
        sections.forEach(section => {
            const sectionTop = section.offsetTop;
            const sectionHeight = section.clientHeight;
            if (pageYOffset >= (sectionTop - 200)) {
                current = section.getAttribute('id');
            }
        });

        navLinks.forEach(link => {
            link.classList.remove('active');
            if (link.getAttribute('href') === '#' + current) {
                link.classList.add('active');
            }
        });
    });

</script>
@endpush
