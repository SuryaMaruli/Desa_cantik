@extends('layouts.app')

@section('title', 'Profil - Kelurahan Citangkil')

@section('content')
    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <h1>Profil Kelurahan</h1>
            <p class="lead">Mengenal lebih dekat Kelurahan Citangkil</p>
        </div>
    </section>

    <!-- Profile Content -->
    <section class="about">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="profile-header text-center mb-5">
                        <img src="https://images.unsplash.com/photo-1486312338219-ce68d2C6f44d?ixlib=rb-1.2.1&auto=format&fit=crop&w=400&q=80" class="profile-image rounded-circle mb-4" alt="Kelurahan Citangkil">
                        <h2>Kelurahan Citangkil</h2>
                        <p class="lead">Kecamatan Citangkil, Kota Cilegon</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6 mb-4">
                    <div class="info-card">
                        <h3><i class="bi bi-geo-alt me-2"></i>Informasi Umum</h3>
                        <ul class="info-list">
                            <li><strong>Kecamatan:</strong> Citangkil</li>
                            <li><strong>Kota:</strong> Cilegon</li>
                            <li><strong>Provinsi:</strong> Jawa Barat</li>
                            <li><strong>Kode Pos:</strong> 43155</li>
                            <li><strong>Telepon:</strong> (0251) 123456</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="info-card">
                        <h3><i class="bi bi-person-badge me-2"></i>Kepala Desa</h3>
                        <div class="leader-info">
                            <img src="https://images.unsplash.com/photo-1472099645785-565eab4e4a?ixlib=rb-1.2.1&auto=format&fit=crop&w=150&q=80" class="leader-image rounded-circle" alt="Kepala Desa">
                            <div class="leader-details">
                                <h4>M. ALI WAHIDI, S.Sos., M.Si</h4>
                                <p>NIP. 19750101 200001 1 001</p>
                                <p class="text-muted">Periode 2021-2026</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 mb-4">
                    <div class="info-card">
                        <h3><i class="bi bi-building me-2"></i>Struktur Organisasi</h3>
                        <div class="org-structure">
                            <div class="org-level">
                                <h4>Kepala Desa</h4>
                                <p>M. ALI WAHIDI, S.Sos., M.Si</p>
                            </div>
                            <div class="org-level">
                                <h4>Sekretaris Desa</h4>
                                <p>Nama Sekretaris</p>
                            </div>
                            <div class="org-level">
                                <h4>Kasi Pemerintahan</h4>
                                <p>Nama Kasi</p>
                            </div>
                            <div class="org-level">
                                <h4>Kasi Kesejahteraan</h4>
                                <p>Nama Kasi</p>
                            </div>
                            <div class="org-level">
                                <h4>Kasi Pelayanan</h4>
                                <p>Nama Kasi</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

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
