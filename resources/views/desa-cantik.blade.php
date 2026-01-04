@extends('layouts.app')

@section('title', 'Desa Cantik - Kelurahan Citangkil')

@section('content')
    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <h1>Desa Cantik</h1>
            <p class="lead">Program inovatif untuk kemajuan desa yang bersih dan sejahtera</p>
        </div>
    </section>

    <!-- Program Overview -->
    <section class="about">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="program-intro text-center mb-5">
                        <h2>Program Desa Cantik Citangkil</h2>
                        <p class="lead">Program Desa Cantik adalah program inovatif yang bertujuan untuk meningkatkan kualitas lingkungan dan kehidupan masyarakat desa melalui berbagai inisiatif pembangunan berkelanjutan.</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="program-card">
                        <div class="program-icon">
                            <i class="bi bi-broom-fill"></i>
                        </div>
                        <h3>Bersih Desa</h3>
                        <p>Program kebersihan lingkungan dan pengelolaan sampah yang berkelanjutan.</p>
                        <ul class="program-features">
                            <li>Bank Sampah</li>
                            <li>Gotong Royong</li>
                            <li>TPS 3R</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="program-card">
                        <div class="program-icon">
                            <i class="bi bi-tree-fill"></i>
                        </div>
                        <h3>Hijau Desa</h3>
                        <p>Program penghijauan dan penanaman pohon untuk lingkungan yang asri.</p>
                        <ul class="program-features">
                            <li>Taman Kota</li>
                            <li>Penanaman Pohon</li>
                            <li>Taman Bermain</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="program-card">
                        <div class="program-icon">
                            <i class="bi bi-people-fill"></i>
                        </div>
                        <h3>Sehat Desa</h3>
                        <p>Program kesehatan masyarakat dan sanitasi lingkungan yang komprehensif.</p>
                        <ul class="program-features">
                            <li>Posyandu</li>
                            <li>Stunting</li>
                            <li>Jamban Sehat</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Achievement Section -->
            <div class="row mt-5">
                <div class="col-lg-12">
                    <div class="achievement-section">
                        <h2>Pencapaian Program</h2>
                        <div class="row">
                            <div class="col-md-3 col-sm-6 mb-4">
                                <div class="achievement-card">
                                    <div class="achievement-icon">
                                        <i class="bi bi-trophy-fill text-warning"></i>
                                    </div>
                                    <h4>85%</h4>
                                    <p>Partisipasi Masyarakat</p>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 mb-4">
                                <div class="achievement-card">
                                    <div class="achievement-icon">
                                        <i class="bi bi-recycle text-success"></i>
                                    </div>
                                    <h4>12</h4>
                                    <p>Program Berjalan</p>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 mb-4">
                                <div class="achievement-card">
                                    <div class="achievement-icon">
                                        <i class="bi bi-award text-primary"></i>
                                    </div>
                                    <h4>450+</h4>
                                    <p>Relawan Terlibat</p>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 mb-4">
                                <div class="achievement-card">
                                    <div class="achievement-icon">
                                        <i class="bi bi-star-fill text-info"></i>
                                    </div>
                                    <h4>3</h4>
                                    <p>Penghargaan</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Gallery Section -->
            <div class="row mt-5">
                <div class="col-lg-12">
                    <div class="gallery-section">
                        <h2>Galeri Kegiatan</h2>
                        <div class="row">
                            <div class="col-md-4 mb-4">
                                <div class="gallery-item">
                                    <img src="https://images.unsplash.com/photo-1589829545856-d10d557cf95f?ixlib=rb-1.2.1&auto=format&fit=crop&w=400&q=80" class="img-fluid rounded" alt="Kegiatan Bersih Desa">
                                    <div class="gallery-overlay">
                                        <h5>Bersih Desa</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-4">
                                <div class="gallery-item">
                                    <img src="https://images.unsplash.com/photo-1542831021-7481c6700d9?ixlib=rb-1.2.1&auto=format&fit=crop&w=400&q=80" class="img-fluid rounded" alt="Kegiatan Hijau Desa">
                                    <div class="gallery-overlay">
                                        <h5>Hijau Desa</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-4">
                                <div class="gallery-item">
                                    <img src="https://images.unsplash.com/photo-1571019613456-1bd8a4ab6bd?ixlib=rb-1.2.1&auto=format&fit=crop&w=400&q=80" class="img-fluid rounded" alt="Kegiatan Sehat Desa">
                                    <div class="gallery-overlay">
                                        <h5>Sehat Desa</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CTA Section -->
            <div class="row mt-5">
                <div class="col-lg-12 text-center">
                    <div class="cta-section">
                        <h3>Bergabung Bersama Kami</h3>
                        <p class="lead">Mari bersama-sama membangun Desa Citangkil yang lebih baik</p>
                        <div class="mt-4">
                            <a href="/kontak" class="btn btn-primary btn-lg me-3">Daftar Sebagai Relawan</a>
                            <a href="/layanan" class="btn btn-outline-light btn-lg">Lihat Layanan</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('styles')
<style>
    .program-card {
        background: white;
        padding: 25px;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        height: 100%;
    }

    .program-icon {
        font-size: 3rem;
        color: #009688;
        margin-bottom: 20px;
    }

    .program-features {
        list-style: none;
        padding: 0;
        margin-top: 15px;
    }

    .program-features li {
        padding: 5px 0;
        color: #666;
        border-bottom: 1px solid #f0f0f0;
    }

    .program-features li::before {
        content: "✓";
        color: #009688;
        font-weight: bold;
        margin-right: 8px;
    }

    .achievement-card {
        background: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        text-align: center;
        height: 100%;
    }

    .achievement-icon {
        font-size: 2.5rem;
        margin-bottom: 15px;
    }

    .achievement-card h4 {
        font-size: 2rem;
        font-weight: 700;
        color: #009688;
        margin-bottom: 5px;
    }

    .gallery-item {
        position: relative;
        overflow: hidden;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .gallery-item img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .gallery-item:hover img {
        transform: scale(1.05);
    }

    .gallery-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(transparent, rgba(0,0,0,0.7));
        color: white;
        padding: 10px;
        text-align: center;
    }

    .gallery-overlay h5 {
        margin: 0;
        font-weight: 600;
    }

    .cta-section {
        background: linear-gradient(135deg, #009688, #00a86b);
        color: white;
        padding: 40px;
        border-radius: 10px;
    }

    .cta-section h3 {
        margin-bottom: 15px;
    }
</style>
@endpush
