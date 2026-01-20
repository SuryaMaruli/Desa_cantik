@extends('layouts.app')

@section('title', 'Detail Informasi Publik - Kelurahan Citangkil')

@section('content')
<style>
    /* --- RESET & GLOBAL --- */
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: 'Roboto', sans-serif; background-color: #f8f9fa; color: #333; overflow-x: hidden; }
    a { text-decoration: none; }

    /* --- HERO SECTION --- */
    .hero-section {
        background-color: #F6903A;
        color: #ffffff;
        text-align: center;
        position: relative;
        overflow: hidden;
        padding-top: 60px;
        padding-bottom: 120px;
    }

    .hero-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-image: url('https://images.unsplash.com/photo-1486312338219-ce68d2C6f44d?ixlib=rb-1.2.1&auto=format&fit=crop&w=1200&q=80');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        opacity: 0.3;
        z-index: 1;
    }

    .hero-content {
        position: relative;
        z-index: 2;
    }

    .hero-section h1 { font-size: 2.8rem; font-weight: 400; margin-bottom: 25px; text-transform: uppercase; }
    .description { font-size: 1.1rem; font-weight: 300; line-height: 1.8; margin-bottom: 40px; }

    .wave-container { 
        position: absolute; 
        bottom: -1px; 
        left: 0; 
        width: 100%; 
        overflow: hidden; 
        line-height: 0; 
        z-index: 4; 
    }
    .wave-container svg { 
        position: relative; 
        display: block; 
        width: calc(100% + 1.3px); 
        height: 160px; 
    }
    .wave-fill { fill: #ffffff; }

    /* --- CONTENT SECTION --- */
    .content-section {
        padding: 80px 20px 100px 20px;
        max-width: 900px;
        margin: 0 auto;
    }

    .detail-card {
        background: white;
        border-radius: 20px;
        padding: 40px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        border: 1px solid #f0f0f0;
        margin-bottom: 40px;
    }

    .detail-header {
        border-bottom: 2px solid #f0f0f0;
        padding-bottom: 30px;
        margin-bottom: 30px;
    }

    .detail-title {
        color: #333;
        font-size: 2rem;
        font-weight: 600;
        margin-bottom: 15px;
    }

    .detail-meta {
        display: flex;
        gap: 30px;
        color: #666;
        font-size: 0.9rem;
        margin-bottom: 20px;
    }

    .detail-meta-item {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .detail-meta i {
        color: #F6903A;
    }

    .detail-content {
        line-height: 1.8;
        color: #555;
        font-size: 1.05rem;
    }

    .detail-content p {
        margin-bottom: 20px;
    }

    .back-button {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 12px 24px;
        background: #F6903A;
        color: white;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
        margin-bottom: 30px;
    }

    .back-button:hover {
        background: #E57A2A;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(246, 144, 58, 0.3);
    }

    /* --- RESPONSIVE --- */
    @media (max-width: 768px) {
        .hero-section { padding: 40px 0; }
        .hero-section h1 { font-size: 2rem; }
        .detail-card { padding: 25px; }
        .detail-title { font-size: 1.5rem; }
        .detail-meta { flex-direction: column; gap: 15px; }
        .content-section { padding: 40px 15px; }
    }
</style>

    <div class="hero-section">
        <div class="hero-content">
            <h1>Detail Informasi Publik</h1>
            <div class="description">
                <span>Informasi lengkap mengenai layanan dan program Kelurahan Citangkil</span>
            </div>
        </div>
        <div class="wave-container">
            <svg viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path d="M0,60 C400,160 800,-40 1200,60 L1200,120 L0,120 Z" class="wave-fill"></path>
            </svg>
        </div>
    </div>

    <section class="content-section">
        <a href="{{ url()->previous() }}" class="back-button">
            <i class="fas fa-arrow-left"></i>
            Kembali
        </a>

        <div class="detail-card">
            @if($informasi)
                <div class="detail-header">
                    <h2 class="detail-title">{{ $informasi->judul }}</h2>
                    <div class="detail-meta">
                        <div class="detail-meta-item">
                            <i class="fas fa-calendar-plus"></i>
                            <span>Dibuat: {{ $informasi->created_at->format('d M Y H:i') }}</span>
                        </div>
                        <div class="detail-meta-item">
                            <i class="fas fa-calendar-edit"></i>
                            <span>Diperbarui: {{ $informasi->updated_at->format('d M Y H:i') }}</span>
                        </div>
                    </div>
                </div>
                
                <div class="detail-content">
                    <h3>Deskripsi</h3>
                    <div class="sub-description">
                        <p><strong>{{ $informasi->sub_deskripsi }}</strong></p>
                    </div>
                    <div class="full-description">
                        {!! nl2br(e($informasi->deskripsi)) !!}
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3 d-block"></i>
                    <h3>Informasi Tidak Ditemukan</h3>
                    <p class="text-muted">Maaf, informasi yang Anda cari tidak tersedia.</p>
                    <a href="{{ url('/desa-cantik#informasi-publik') }}" class="btn btn-primary mt-3">
                        <i class="fas fa-arrow-left me-2"></i>
                        Kembali ke Informasi Publik
                    </a>
                </div>
            @endif
        </div>
    </section>
@endsection
