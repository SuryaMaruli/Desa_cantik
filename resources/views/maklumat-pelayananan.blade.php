@extends('layouts.app')

@section('title', 'Maklumat Pelayanan - Kelurahan Citangkil')

@section('page-title', 'Maklumat Pelayanan')

@section('content')
<style>
    .main-container {
        max-width: 1000px;
        margin: 0 auto;
        padding: 40px 20px;
    }
    
    .page-header {
        text-align: center;
        margin-bottom: 40px;
    }
    
    .page-header h1 {
        font-size: 32px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 12px;
    }
    
    .page-header p {
        color: #64748b;
        font-size: 16px;
        margin: 0;
    }
    
    .content-card {
        background: white;
        border-radius: 16px;
        padding: 32px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        margin-bottom: 30px;
    }
    
    .image-container {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-wrap: wrap;
        gap: 24px;
    }
    
    .maklumat-item {
        flex: 1;
        min-width: 300px;
        max-width: 500px;
    }
    
    .maklumat-item img {
        width: 100%;
        height: auto;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        object-fit: contain;
    }
    
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #64748b;
    }
    
    .empty-state i {
        font-size: 64px;
        color: #d1d5db;
        margin-bottom: 20px;
    }
    
    .empty-state h3 {
        font-size: 20px;
        color: #374151;
        margin-bottom: 8px;
    }
    
    .empty-state p {
        font-size: 14px;
        color: #6b7280;
    }
    
    .back-link {
        display: inline-flex;
        align-items: center;
        color: #F6903A;
        text-decoration: none;
        font-weight: 500;
        margin-bottom: 24px;
        transition: all 0.2s;
    }
    
    .back-link:hover {
        color: #E57A2A;
    }
    
    .back-link i {
        margin-right: 8px;
    }
</style>

<div class="main-container">
    <a href="{{ route('home') }}" class="back-link">
        <i class="fas fa-arrow-left"></i> Kembali ke Beranda
    </a>
    
    <div class="page-header">
        <h1>Maklumat Pelayanan</h1>
        <p>Informasi lengkap mengenai layanan di Kelurahan Citangkil</p>
    </div>
    
    <div class="content-card">
        @php
            $maklumat = \App\Models\MaklumatPelayananan::latest()->get();
        @endphp
        
        @if($maklumat->count() > 0)
        <div class="image-container">
            @foreach($maklumat as $item)
            <div class="maklumat-item">
                <img src="{{ asset('storage/' . $item->gambar) }}" alt="Maklumat Pelayanan">
            </div>
            @endforeach
        </div>
        @else
        <div class="empty-state">
            <i class="fas fa-info-circle"></i>
            <h3>Belum Ada Informasi</h3>
            <p>Maklumat pelayanan akan ditampilkan di sini setelah ditambahkan oleh admin.</p>
        </div>
        @endif
    </div>
</div>
@endsection
