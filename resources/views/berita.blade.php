@extends('layouts.app')

@section('title', 'Berita dan Informasi - Kelurahan Citangkil')

@section('content')
    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <h1>Berita dan Informasi</h1>
            <p class="lead">Update terkini seputar kegiatan dan informasi Kelurahan Citangkil</p>
        </div>
    </section>

    <!-- News Section -->
    <section class="about">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="news-list">
                        <h2>Berita Terkini</h2>
                        
                        <!-- News Item 1 -->
                        <div class="news-item">
                            <div class="news-image">
                                <img src="https://images.unsplash.com/photo-1589829545856-d10d557cf95f?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" class="img-fluid" alt="Berita 1">
                            </div>
                            <div class="news-content">
                                <div class="news-meta">
                                    <span class="category">Pengumuman</span>
                                    <span class="date">15 Januari 2024</span>
                                </div>
                                <h3>Pengumuman Libur Imlek 2024</h3>
                                <p>Diberitahukan kepada seluruh masyarakat Kelurahan Citangkil bahwa dalam rangka menyambut Tahun Baru Imlek 2575, kantor Kelurahan Citangkil akan libur pada tanggal...</p>
                                <a href="#" class="read-more">Baca Selengkapnya →</a>
                            </div>
                        </div>

                        <!-- News Item 2 -->
                        <div class="news-item">
                            <div class="news-image">
                                <img src="https://images.unsplash.com/photo-1486312338219-ce68d2C6f44d?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" class="img-fluid" alt="Berita 2">
                            </div>
                            <div class="news-content">
                                <div class="news-meta">
                                    <span class="category">Kegiatan</span>
                                    <span class="date">10 Januari 2024</span>
                                </div>
                                <h3>Gotong Royong Bersih Desa</h3>
                                <p>Seluruh masyarakat Kelurahan Citangkil turut serta dalam kegiatan gotong royong bersih desa yang dilaksanakan pada hari Minggu...</p>
                                <a href="#" class="read-more">Baca Selengkapnya →</a>
                            </div>
                        </div>

                        <!-- News Item 3 -->
                        <div class="news-item">
                            <div class="news-image">
                                <img src="https://images.unsplash.com/photo-1542831371-7b54a0082b3f?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" class="img-fluid" alt="Berita 3">
                            </div>
                            <div class="news-content">
                                <div class="news-meta">
                                    <span class="category">Layanan</span>
                                    <span class="date">5 Januari 2024</span>
                                </div>
                                <h3>Pelayanan KTP Elektronik</h3>
                                <p>Kelurahan Citangkil kembali membuka layanan perekaman KTP elektronik untuk mempermudah masyarakat dalam mengurus keperluan administrasi...</p>
                                <a href="#" class="read-more">Baca Selengkapnya →</a>
                            </div>
                        </div>
                    </div>

                    <!-- Pagination -->
                    <div class="pagination-wrapper">
                        <nav aria-label="Page navigation">
                            <ul class="pagination">
                                <li class="page-item disabled">
                                    <a class="page-link" href="#" tabindex="-1">Previous</a>
                                </li>
                                <li class="page-item active">
                                    <a class="page-link" href="#">1</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#">2</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#">3</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#">Next</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
                    <div class="sidebar">
                        <!-- Categories -->
                        <div class="sidebar-section">
                            <h3>Kategori</h3>
                            <ul class="category-list">
                                <li><a href="#" class="active">Semua</a></li>
                                <li><a href="#">Pengumuman</a></li>
                                <li><a href="#">Kegiatan</a></li>
                                <li><a href="#">Layanan</a></li>
                                <li><a href="#">Pembangunan</a></li>
                            </ul>
                        </div>

                        <!-- Popular News -->
                        <div class="sidebar-section">
                            <h3>Populer</h3>
                            <ul class="popular-list">
                                <li>
                                    <a href="#">
                                        <span class="popular-number">1</span>
                                        Pengumuman Libur Imlek 2024
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <span class="popular-number">2</span>
                                        Gotong Royong Bersih Desa
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <span class="popular-number">3</span>
                                        Pelayanan KTP Elektronik
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <span class="popular-number">4</span>
                                        Program Desa Cantik
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <!-- Archive -->
                        <div class="sidebar-section">
                            <h3>Arsip</h3>
                            <div class="archive-list">
                                <div class="archive-item">
                                    <h4>Januari 2024</h4>
                                    <span>15 berita</span>
                                </div>
                                <div class="archive-item">
                                    <h4>Desember 2023</h4>
                                    <span>23 berita</span>
                                </div>
                                <div class="archive-item">
                                    <h4>November 2023</h4>
                                    <span>18 berita</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('styles')
<style>
    .news-item {
        display: flex;
        gap: 20px;
        margin-bottom: 30px;
        padding-bottom: 30px;
        border-bottom: 1px solid #e9ecef;
    }

    .news-item:last-child {
        border-bottom: none;
    }

    .news-image {
        flex: 0 0 300px;
    }

    .news-image img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        border-radius: 8px;
    }

    .news-content {
        flex: 1;
    }

    .news-meta {
        display: flex;
        gap: 15px;
        margin-bottom: 10px;
    }

    .category {
        background: #009688;
        color: white;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
    }

    .date {
        color: #6c757d;
        font-size: 14px;
    }

    .news-content h3 {
        color: #333;
        margin-bottom: 10px;
        font-size: 20px;
    }

    .news-content p {
        color: #666;
        line-height: 1.6;
        margin-bottom: 15px;
    }

    .read-more {
        color: #009688;
        text-decoration: none;
        font-weight: 500;
        transition: color 0.3s ease;
    }

    .read-more:hover {
        color: #00a86b;
    }

    .sidebar-section {
        background: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        margin-bottom: 20px;
    }

    .sidebar-section h3 {
        color: #009688;
        margin-bottom: 15px;
        font-size: 18px;
    }

    .category-list, .popular-list {
        list-style: none;
        padding: 0;
    }

    .category-list li, .popular-list li {
        margin-bottom: 10px;
    }

    .category-list a, .popular-list a {
        color: #333;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 8px 0;
        transition: color 0.3s ease;
    }

    .category-list a:hover, .popular-list a:hover {
        color: #009688;
    }

    .category-list a.active {
        color: #009688;
        font-weight: 600;
    }

    .popular-number {
        background: #009688;
        color: white;
        width: 24px;
        height: 24px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: 600;
    }

    .archive-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 0;
        border-bottom: 1px solid #f0f0f0;
    }

    .archive-item:last-child {
        border-bottom: none;
    }

    .archive-item h4 {
        color: #333;
        font-size: 16px;
        margin: 0;
    }

    .archive-item span {
        color: #6c757d;
        font-size: 14px;
    }

    .pagination-wrapper {
        margin-top: 40px;
    }

    .pagination {
        display: flex;
        justify-content: center;
        gap: 5px;
        list-style: none;
    }

    .page-item .page-link {
        color: #009688;
        border: 1px solid #009688;
        padding: 8px 16px;
        text-decoration: none;
        border-radius: 4px;
        transition: all 0.3s ease;
    }

    .page-item .page-link:hover {
        background: #009688;
        color: white;
    }

    .page-item.active .page-link {
        background: #009688;
        color: white;
    }

    .page-item.disabled .page-link {
        color: #6c757d;
        border-color: #6c757d;
        cursor: not-allowed;
    }
</style>
@endpush
