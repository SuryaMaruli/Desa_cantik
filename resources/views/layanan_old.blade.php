@extends('layouts.app')

@section('title', 'Layanan - Kelurahan Citangkil')

@section('content')
    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <h1>Layanan Kami</h1>
            <p class="lead">Berbagai layanan yang tersedia untuk kemudahan masyarakat</p>
        </div>
    </section>

    <!-- Services Section -->
    <section class="services">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="service-card text-center">
                        <div class="service-icon">
                            <i class="bi bi-file-earmark-text"></i>
                        </div>
                        <h4>Pelayanan Administrasi</h4>
                        <p>Pengurusan surat keterangan, KTP, KK, dan dokumen administrasi lainnya.</p>
                        <ul class="service-details">
                            <li>Surat Keterangan</li>
                            <li>KTP Elektronik</li>
                            <li>Kartu Keluarga</li>
                            <li>Akta Kelahiran</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="service-card text-center">
                        <div class="service-icon">
                            <i class="bi bi-heart-pulse"></i>
                        </div>
                        <h4>Pelayanan Kesehatan</h4>
                        <p>Pelayanan kesehatan dasar dan program kesehatan masyarakat.</p>
                        <ul class="service-details">
                            <li>Puskesmas</li>
                            <li>Posyandu</li>
                            <li>KB Mandiri</li>
                            <li>Imunisasi</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="service-card text-center">
                        <div class="service-icon">
                            <i class="bi bi-mortarboard"></i>
                        </div>
                        <h4>Pendidikan</h4>
                        <p>Program pendidikan dan beasiswa untuk masyarakat kurang mampu.</p>
                        <ul class="service-details">
                            <li>PAUD/TK</li>
                            <li>SD/MI</li>
                            <li>SMP/MTs</li>
                            <li>Beasiswa</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="service-card text-center">
                        <div class="service-icon">
                            <i class="bi bi-graph-up"></i>
                        </div>
                        <h4>Pemberdayaan Ekonomi</h4>
                        <p>Pelatihan keterampilan dan bantuan modal usaha mikro.</p>
                        <ul class="service-details">
                            <li>Pelatihan Keterampilan</li>
                            <li>Bantuan Modal</li>
                            <li>Koperasi</li>
                            <li>UMKM</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="service-card text-center">
                        <div class="service-icon">
                            <i class="bi bi-tree"></i>
                        </div>
                        <h4>Lingkungan</h4>
                        <p>Program kebersihan lingkungan dan penghijauan.</p>
                        <ul class="service-details">
                            <li>Gotong Royong</li>
                            <li>Bank Sampah</li>
                            <li>Taman Kota</li>
                            <li>Penghijauan</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="service-card text-center">
                        <div class="service-icon">
                            <i class="bi bi-shield"></i>
                        </div>
                        <h4>Keamanan</h4>
                        <p>Pelayanan keamanan dan ketertiban masyarakat.</p>
                        <ul class="service-details">
                            <li>Siskamling</li>
                            <li>Linmas</li>
                            <li>Pam Swakarsa</li>
                            <li>Patroli</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="service-card text-center">
                        <div class="service-icon">
                            <i class="bi bi-wifi"></i>
                        </div>
                        <h4>Layanan Digital</h4>
                        <p>Layanan berbasis teknologi untuk kemudahan akses.</p>
                        <ul class="service-details">
                            <li>WiFi Publik</li>
                            <li>E-Kelurahan</li>
                            <li>Layanan Online</li>
                            <li>Media Sosial</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="contact">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2>Butuh Bantuan?</h2>
                    <p class="lead">Hubungi kami untuk informasi lebih lanjut tentang layanan yang tersedia</p>
                    <div class="mt-4">
                        <a href="/kontak" class="btn btn-primary btn-lg me-3">Hubungi Kami</a>
                        <a href="/data" class="btn btn-outline-light btn-lg">Lihat Data</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('styles')
<style>
    .service-details {
        list-style: none;
        padding: 0;
        margin-top: 15px;
        text-align: left;
    }

    .service-details li {
        padding: 5px 0;
        font-size: 14px;
        color: #666;
        border-bottom: 1px solid #f0f0f0;
    }

    .service-details li:last-child {
        border-bottom: none;
    }

    .service-details li::before {
        content: "•";
        color: #009688;
        font-weight: bold;
        margin-right: 8px;
    }
</style>
@endpush
