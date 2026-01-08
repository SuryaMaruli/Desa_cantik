@extends('layouts.app')

@section('title', $program->judul_program . ' - Output Desa Cantik - Kelurahan Citangkil')

@section('content')
    <style>
        body {
            background-color: #f9fafb;
            color: #333;
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 100px 20px 40px;
        }
        
        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #F6903A;
            text-decoration: none;
            font-weight: 600;
            margin-bottom: 30px;
            transition: gap 0.2s;
        }
        
        .back-link:hover {
            gap: 12px;
        }
        
        .article-header {
            text-align: center;
            margin-bottom: 40px;
        }
        
        .article-category {
            display: inline-block;
            background-color: #FEF3C7;
            color: #D97706;
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 20px;
        }
        
        .article-title {
            font-size: 2.5rem;
            color: #1F2937;
            margin-bottom: 20px;
            font-weight: 700;
            line-height: 1.3;
        }
        
        .article-meta {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 30px;
            color: #6B7280;
            font-size: 14px;
            margin-bottom: 30px;
        }
        
        .meta-item {
            display: flex;
            align-items: center;
            gap: 6px;
        }
        
        .article-image {
            width: 100%;
            height: 400px;
            background-color: #f3f4f6;
            border-radius: 12px;
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #9CA3AF;
            font-size: 3rem;
            overflow: hidden;
        }
        
        .article-content {
            background-color: white;
            border-radius: 12px;
            padding: 40px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.03);
            line-height: 1.8;
            font-size: 16px;
            color: #374151;
        }
        
        .article-content h2 {
            color: #1F2937;
            font-size: 1.5rem;
            font-weight: 600;
            margin: 30px 0 15px 0;
        }
        
        .article-content h3 {
            color: #1F2937;
            font-size: 1.2rem;
            font-weight: 600;
            margin: 25px 0 10px 0;
        }
        
        .article-content p {
            margin-bottom: 20px;
        }
        
        .article-content ul, .article-content ol {
            margin-bottom: 20px;
            padding-left: 30px;
        }
        
        .article-content li {
            margin-bottom: 8px;
        }
        
        @media (max-width: 768px) {
            .container {
                padding: 80px 20px 30px;
            }
            
            .article-title {
                font-size: 2rem;
            }
            
            .article-content {
                padding: 25px;
            }
        }
    </style>

    <div class="container">
        <a href="/desa-cantik" class="back-link">
            <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 1 .708-.708L1.707 7.5a.5.5 0 0 1 0-.708l4.146-4.146a.5.5 0 0 1 .708 0l3.147 3.146H1.5A.5.5 0 0 0 1 8z"/></svg>
            Kembali ke Desa Cantik
        </a>
        
        <div class="article-header">
            <span class="article-category">Output Program</span>
            <h1 class="article-title">{{ $program->judul_program }}</h1>
            
            <div class="article-meta">
                <div class="meta-item">
                    <svg width="14" height="14" fill="currentColor" viewBox="0 0 16 16"><path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/></svg>
                    Program Desa Cantik
                </div>
                <div class="meta-item">
                    <svg width="14" height="14" fill="currentColor" viewBox="0 0 16 16"><path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4z"/></svg>
                    Kelurahan Citangkil
                </div>
            </div>
        </div>
        
        <div class="article-image">
            <i class="fa-solid fa-clipboard-list" style="font-size: 4rem; color: #F6903A;"></i>
        </div>
        
        <div class="article-content">
            <h2>Deskripsi Program</h2>
            <p>{{ $program->deskripsi_program }}</p>
            
            <h2>Informasi Tambahan</h2>
            <p>Program ini merupakan bagian dari inisiatif Desa Cantik yang bertujuan untuk meningkatkan kemampuan aparat desa dalam mengelola dan memanfaatkan data agar perencanaan pembangunan desa lebih tepat sasaran.</p>
            
            <p>Untuk informasi lebih lanjut mengenai program ini, dapat menghubungi Kantor Kelurahan Citangkil atau melalui layanan pengaduan masyarakat yang telah tersedia.</p>
        </div>
    </div>
@endsection
