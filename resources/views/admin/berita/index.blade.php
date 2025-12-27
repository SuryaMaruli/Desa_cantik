@extends('layouts.admin')

@section('page-title', 'Berita & Informasi')

@section('content')
<div class="home-content">
    <div class="news-toolbar">
        <div class="toolbar-container">
            <div class="search-box">
                <i class='bx bx-search'></i>
                <input type="text" placeholder="Cari berita...">
            </div>
            <a href="#" class="btn-add-news">
                <i class='bx bx-plus'></i> Tambah Berita
            </a>
        </div>
    </div>

    <div class="content-card">
        <div class="news-list-item">
            <img src="https://placehold.co/600x400/008C6E/ffffff?text=Vaksinasi+Covid" alt="Vaksinasi" class="news-thumbnail">
            <div class="news-content-wrapper">
                <div class="news-header">
                    <h3>Vaksinasi Massal COVID-19 di Kelurahan Citangkil</h3>
                </div>
                <p class="news-excerpt">
                    Pemerintah Kelurahan Citangkil mengadakan vaksinasi massal untuk warga agar tercipta kekebalan komunal dan mendukung program pemerintah pusat...
                </p>
                <div class="news-meta-row">
                    <span class="meta-item"><i class='bx bx-calendar'></i> 2024-12-15</span>
                    <span class="meta-item"><i class='bx bx-user'></i> Admin</span>
                    <span class="badge-status status-published">Published</span>
                </div>
                <div class="action-buttons">
                    <a href="#" class="btn-action btn-edit"><i class='bx bx-edit-alt'></i> Edit</a>
                    <a href="#" class="btn-action btn-delete"><i class='bx bx-trash'></i> Hapus</a>
                </div>
            </div>
        </div>

        <div class="news-list-item">
            <img src="https://placehold.co/600x400/3b82f6/ffffff?text=Bantuan+Sosial" alt="Bansos" class="news-thumbnail">
            <div class="news-content-wrapper">
                <div class="news-header">
                    <h3>Pembagian Bantuan Sosial kepada Warga Kurang Mampu</h3>
                </div>
                <p class="news-excerpt">
                    Penyaluran bantuan sosial tahap ke-3 telah dilaksanakan di aula kelurahan dengan tertib dan lancar kepada 50 penerima manfaat yang terdata dalam DTKS...
                </p>
                <div class="news-meta-row">
                    <span class="meta-item"><i class='bx bx-calendar'></i> 2024-12-10</span>
                    <span class="meta-item"><i class='bx bx-user'></i> Admin</span>
                    <span class="badge-status status-published">Published</span>
                </div>
                <div class="action-buttons">
                    <a href="#" class="btn-action btn-edit"><i class='bx bx-edit-alt'></i> Edit</a>
                    <a href="#" class="btn-action btn-delete"><i class='bx bx-trash'></i> Hapus</a>
                </div>
            </div>
        </div>

        <div class="news-list-item">
            <img src="https://placehold.co/600x400/f59e0b/ffffff?text=Kerja+Bakti" alt="Kerja Bakti" class="news-thumbnail">
            <div class="news-content-wrapper">
                <div class="news-header">
                    <h3>Kegiatan Gotong Royong Bersama Warga RW 05</h3>
                </div>
                <p class="news-excerpt">
                    Rencana kegiatan kerja bakti membersihkan saluran air untuk antisipasi banjir di musim penghujan yang akan dilaksanakan akhir pekan ini...
                </p>
                <div class="news-meta-row">
                    <span class="meta-item"><i class='bx bx-calendar'></i> 2024-12-05</span>
                    <span class="meta-item"><i class='bx bx-user'></i> Admin</span>
                    <span class="badge-status status-draft">Draft</span>
                </div>
                <div class="action-buttons">
                    <a href="#" class="btn-action btn-edit"><i class='bx bx-edit-alt'></i> Edit</a>
                    <a href="#" class="btn-action btn-delete"><i class='bx bx-trash'></i> Hapus</a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* --- 1. RESET & GLOBAL --- */
    :root {
        --sidebar-bg: #005740;     
        --sidebar-active: #0b755b; 
        --header-height: 80px;
        --sidebar-width: 260px;
        --text-dark: #333;
        --text-grey: #666;
        --primary-green: #008C6E;
    }

    /* --- 2. KONTEN BERITA --- */
    .news-toolbar {
        background: #fff;
        padding: 15px 25px;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.02);
        border: 1px solid #eee;
        margin-bottom: 25px;
    }
    
    .toolbar-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        width: 100%;
        max-width: 100%;
    }
    
    .search-box {
        position: relative; 
        background: #fff; 
        border-radius: 8px; 
        border: 1px solid #ddd;
        width: 100%; 
        max-width: 700px;  /* Increased from 600px */
        display: flex; 
        align-items: center; 
        padding: 0 15px;
        flex: 1;  /* Allow it to grow and take available space */
    }
    
    .search-box i { 
        color: #999; 
        font-size: 20px; 
    }
    
    .search-box input {
        height: 45px; 
        width: 100%; 
        border: none; 
        outline: none; 
        padding-left: 10px; 
        font-size: 14px;
    }
    
    .btn-add-news {
        background-color: #009669; 
        color: white; 
        padding: 12px 20px; 
        border-radius: 8px;
        text-decoration: none; 
        display: flex; 
        align-items: center; 
        gap: 8px; 
        font-size: 14px; 
        font-weight: 500;
        transition: 0.3s; 
        white-space: nowrap;
    }
    
    .btn-add-news:hover { 
        background-color: #007d57; 
    }

    .content-card {
        background: #fff; 
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.02); 
        border: 1px solid #eee; 
        padding: 25px;
    }

    /* --- 3. LIST BERITA DENGAN GAMBAR --- */
    .news-list-item {
        display: flex;
        gap: 25px;
        padding-bottom: 25px; 
        margin-bottom: 25px;
        border-bottom: 1px solid #f0f0f0;
        align-items: flex-start;
    }
    
    .news-list-item:last-child { 
        border-bottom: none; 
        margin-bottom: 0; 
        padding-bottom: 0; 
    }

    /* Styling Gambar Thumbnail */
    .news-thumbnail {
        width: 200px;         /* Lebar tetap */
        height: 140px;        /* Tinggi tetap */
        border-radius: 8px;
        object-fit: cover;    /* Agar gambar tidak gepeng */
        background-color: #eee;
        flex-shrink: 0;       /* Mencegah gambar mengecil */
        border: 1px solid #eee;
    }

    /* Wrapper Konten Teks */
    .news-content-wrapper {
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .news-header h3 { 
        font-size: 18px; 
        font-weight: 600; 
        color: #222; 
        margin-bottom: 8px; 
        line-height: 1.4; 
    }
    
    .news-excerpt { 
        font-size: 14px; 
        color: #666; 
        line-height: 1.6; 
        margin-bottom: 15px; 
    }

    .news-meta-row {
        display: flex; 
        align-items: center; 
        gap: 20px; 
        margin-bottom: 15px; 
        font-size: 13px; 
        color: #888;
    }
    
    .meta-item { 
        display: flex; 
        align-items: center; 
        gap: 6px; 
    }
    
    .badge-status { 
        padding: 4px 12px; 
        border-radius: 20px; 
        font-size: 11px; 
        font-weight: 600; 
    }
    
    .status-published { 
        background: #d1fae5; 
        color: #047857; 
    }
    
    .status-draft { 
        background: #fef3c7; 
        color: #b45309; 
    }

    .action-buttons { 
        display: flex; 
        gap: 10px; 
        margin-top: auto;
    }
    
    .btn-action {
        padding: 8px 16px; 
        border-radius: 6px; 
        font-size: 13px; 
        font-weight: 500;
        text-decoration: none; 
        display: flex; 
        align-items: center; 
        gap: 6px; 
        transition: 0.2s;
    }
    
    .btn-edit { 
        background: #eff6ff; 
        color: #1d4ed8; 
    }
    
    .btn-edit:hover { 
        background: #dbeafe; 
    }
    
    .btn-delete { 
        background: #fef2f2; 
        color: #dc2626; 
    }
    
    .btn-delete:hover { 
        background: #fee2e2; 
    }

    /* Responsiveness untuk Mobile */
    @media (max-width: 768px) {
        .news-toolbar { 
            flex-direction: column; 
            align-items: stretch; 
        }
        
        .news-list-item { 
            flex-direction: column; 
            gap: 15px; 
        }
        
        .news-thumbnail { 
            width: 100%; 
            height: 200px; 
        }
    }
</style>
@endsection
