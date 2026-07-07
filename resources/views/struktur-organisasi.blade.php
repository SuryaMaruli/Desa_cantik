@extends('layouts.app')

@section('title', 'Struktur Organisasi - Kelurahan Gunung Sugih')

@section('content')
<style>
.page-header {
        background: linear-gradient(135deg, #F89039 0%, #E57A2A 100%);
        color: white;
        padding: 80px 0;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .page-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        opacity: 0.5;
    }

    .page-header .container {
        position: relative;
        z-index: 1;
    }

    .page-header h1 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 12px;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .page-header p {
        font-size: 1.2rem;
        opacity: 0.95;
        font-weight: 400;
    }

    .header-icon {
        width: 80px;
        height: 80px;
        background: rgba(255, 255, 255, 0.15);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        backdrop-filter: blur(5px);
    }

    .header-icon i {
        font-size: 36px;
    }

    .content-section {
        padding: 60px 0;
        min-height: 60vh;
    }

    .image-container {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        padding: 30px;
        text-align: center;
    }

    .image-container img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #6b7280;
    }

    .empty-state i {
        font-size: 64px;
        color: #d1d5db;
        margin-bottom: 20px;
    }

    .breadcrumb {
        display: flex;
        justify-content: center;
        gap: 10px;
        margin-top: 15px;
        font-size: 14px;
    }

    .breadcrumb a {
        color: white;
        text-decoration: none;
        opacity: 0.9;
    }

    .breadcrumb a:hover {
        opacity: 1;
        text-decoration: underline;
    }

    .breadcrumb span {
        opacity: 0.9;
    }

.header-bottom-curve {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 40px;
        background: white;
        border-radius: 50% 50% 0 0;
    }

    .image-container {
        background: white;
        border-radius: 16px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
        padding: 40px;
        text-align: center;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .image-container:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.12);
    }

    .image-container img {
        max-width: 100%;
        height: auto;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }
</style>

<div class="page-header">
    <div class="container">
        <div class="header-icon">
            <i class="fas fa-sitemap"></i>
        </div>
        <h1>Struktur Organisasi</h1>
        <p>Struktur organisasi kelurahan Gunung Sugih</p>
        <div class="breadcrumb">
            <a href="{{ route('home') }}">Beranda</a>
            <span>/</span>
            <span>Tentang Kami</span>
            <span>/</span>
            <span>Struktur Organisasi</span>
        </div>
    </div>
    <div class="header-bottom-curve"></div>
</div>

<section class="content-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="image-container">
                    @php
                        $struktur = \App\Models\StrukturOrganisasi::first();
                    @endphp
                    
                    @if($struktur && $struktur->gambar)
                        <img src="{{ asset('storage/' . $struktur->gambar) }}" alt="Struktur Organisasi" class="img-fluid">
                    @else
                        <div class="empty-state">
                            <i class="fas fa-sitemap"></i>
                            <h3>Belum Ada Gambar</h3>
                            <p>Struktur organisasi belum tersedia. Silakan hubungi administrator.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
