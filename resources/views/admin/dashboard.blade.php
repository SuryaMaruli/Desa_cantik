@extends('layouts.admin')

@section('page-title', 'Dashboard')

@section('content')
<div class="home-content">
    <!-- Welcome Banner -->
    <div class="welcome-banner">
        <h2>Selamat Datang, {{ Auth::user()->name ?? 'Administrator' }}!</h2>
        <p>Kelola dan pantau website {{ $currentVillage['official_name'] ?? 'Kelurahan Gunung Sugih' }} dari dashboard ini</p>
    </div>

    <!-- Statistics Grid -->
    <div class="overview-boxes">
        <div class="box">
            <div class="box-header">
                <div class="icon-box icon-news"><i class='bx bx-news'></i></div>
                <i class='bx bx-trending-up trend-icon'></i>
            </div>
            <div class="number">{{ $totalBeritaPublished }}</div>
            <span class="box-topic">Total Berita</span>
            <div class="indicator">+{{ $beritaBulanIni }} bulan ini</div>
        </div>

        <div class="box">
            <div class="box-header">
                <div class="icon-box icon-people"><i class='bx bx-group'></i></div>
                <i class='bx bx-trending-up trend-icon'></i>
            </div>
            <div class="number">{{ number_format($totalPenduduk, 0, ',', '.') }}</div>
            <span class="box-topic">Total Penduduk</span>
            <div class="indicator">+{{ $pendudukBulanIni }} bulan ini</div>
        </div>

        <div class="box">
            <div class="box-header">
                <div class="icon-box icon-visitor"><i class='bx bx-show'></i></div>
                <i class='bx bx-trending-up trend-icon'></i>
            </div>
            <div class="number">{{ number_format($totalKepalaKeluarga, 0, ',', '.') }}</div>
            <span class="box-topic">Kepala Keluarga</span>
            <div class="indicator">{{ number_format($totalLakiLaki, 0, ',', '.') }} L, {{ number_format($totalPerempuan, 0, ',', '.') }} P</div>
        </div>

        <div class="box">
            <div class="box-header">
                <div class="icon-box icon-service"><i class='bx bx-file'></i></div>
                <i class='bx bx-trending-up trend-icon'></i>
            </div>
            <div class="number">{{ $totalBerita - $totalBeritaPublished }}</div>
            <span class="box-topic">Draft Berita</span>
            <div class="indicator">{{ $totalBerita }} total</div>
        </div>
    </div>

    <!-- Details Boxes -->
    <div class="details-box">
        <!-- Berita Terbaru -->
        <div class="recent-panel">
            <div class="panel-header">
                <h3>Berita Terbaru</h3>
                <a href="/admin/berita">Lihat Semua</a>
            </div>

            @if($recentBerita->count() > 0)
                @foreach($recentBerita as $berita)
                    <div class="news-item">
                        <div class="news-title">{{ $berita->judul }}</div>
                        <div class="news-meta">
                            <span class="date"><i class='bx bx-calendar'></i> {{ \Carbon\Carbon::parse($berita->tanggal_publikasi)->format('d M Y') }}</span>
                            <span class="badge {{ $berita->is_published ? 'published' : 'draft' }}">
                                {{ $berita->is_published ? 'Published' : 'Draft' }}
                            </span>
                        </div>
                    </div>
                @endforeach
            @else
                <div style="text-align: center; padding: 30px; color: #999;">
                    <i class='bx bx-news' style="font-size: 2rem; margin-bottom: 10px;"></i>
                    <p>Belum ada berita</p>
                </div>
            @endif
        </div>

        <!-- Aktivitas Terbaru -->
        <div class="recent-panel">
            <div class="panel-header">
                <h3>Aktivitas Terbaru</h3>
            </div>

            <ul class="activity-list">
                <li class="activity-item">
                    <div class="activity-title">Update data penduduk</div>
                    <div class="activity-time">Admin • 2 jam yang lalu</div>
                </li>
                <li class="activity-item">
                    <div class="activity-title">Publish berita baru</div>
                    <div class="activity-time">Admin • 5 jam yang lalu</div>
                </li>
                <li class="activity-item">
                    <div class="activity-title">Upload foto galeri</div>
                    <div class="activity-time">Admin • 1 hari yang lalu</div>
                </li>
                <li class="activity-item">
                    <div class="activity-title">Edit profil kelurahan</div>
                    <div class="activity-time">Admin • 2 hari yang lalu</div>
                </li>
            </ul>
        </div>
    </div>
    
    <!-- Quick Actions -->
    <div class="quick-actions">
        <h3>Aksi Cepat</h3>
        <div class="action-buttons">
            <a href="/admin/berita/create" class="action-btn btn-green">
                <i class='bx bx-layer-plus'></i>
                <span>Tambah<br>Berita</span>
            </a>
            <a href="/admin/data-kelurahan" class="action-btn btn-blue">
                <i class='bx bx-user-check'></i>
                <span>Update<br>Data</span>
            </a>
            <a href="/admin/galeri" class="action-btn btn-purple">
                <i class='bx bx-image-add'></i>
                <span>Upload<br>Galeri</span>
            </a>
            <a href="/admin/profil" class="action-btn btn-orange">
                <i class='bx bx-edit'></i>
                <span>Edit<br>Profil</span>
            </a>
        </div>
    </div>
</div>

<style>
    /* Dashboard Content */
    .home-content {
        padding: 30px;
        margin-top: 20px;
    }

    /* Welcome Banner */
    .welcome-banner {
        background-color: #008C6E;
        color: white;
        padding: 30px;
        border-radius: 12px;
        margin-bottom: 30px;
        box-shadow: 0 4px 10px rgba(0, 140, 110, 0.2);
    }
    
    .welcome-banner h2 { 
        font-size: 24px; 
        font-weight: 500; 
        margin-bottom: 8px; 
    }
    
    .welcome-banner p { 
        font-size: 14px; 
        opacity: 0.9; 
        font-weight: 300; 
    }

    /* Stats Grid */
    .overview-boxes {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 30px;
    }

    .box {
        background: #fff;
        padding: 25px 20px;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.02);
        border: 1px solid #eee;
        transition: transform 0.3s ease;
    }
    
    .box:hover { 
        transform: translateY(-3px); 
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }

    /* Box Header */
    .box-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 15px;
    }

    .icon-box {
        height: 45px; 
        width: 45px;
        border-radius: 10px;
        display: flex; 
        align-items: center; 
        justify-content: center;
        color: white;
        font-size: 24px;
    }

    /* Card Colors */
    .icon-news { background-color: #00C292; }
    .icon-people { background-color: #3b82f6; }
    .icon-visitor { background-color: #a855f7; }
    .icon-service { background-color: #f59e0b; }

    .trend-icon {
        color: #10b981;
        font-size: 22px;
    }

    /* Typography */
    .number {
        font-size: 28px;
        font-weight: 600;
        color: #333;
        margin-bottom: 5px;
        line-height: 1.2;
    }
    
    .box-topic {
        font-size: 14px;
        color: #666;
        margin-bottom: 12px;
        display: block;
    }

    .indicator {
        font-size: 12px;
        color: #10b981;
        font-weight: 500;
    }

    /* Details Boxes */
    .details-box {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 25px;
        margin-bottom: 30px;
    }

    .recent-panel {
        background: #fff;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.02);
        border: 1px solid #eee;
    }

    .panel-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
    }

    .panel-header h3 { 
        font-size: 18px; 
        font-weight: 600; 
        color: #333; 
        margin: 0;
    }
    
    .panel-header a { 
        font-size: 13px; 
        color: #00C292; 
        text-decoration: none; 
        font-weight: 500; 
    }
    
    .panel-header a:hover { 
        text-decoration: underline; 
    }

    /* News Item Styles */
    .news-item {
        display: flex;
        flex-direction: column;
        padding-bottom: 15px;
        margin-bottom: 15px;
        border-bottom: 1px solid #f0f0f0;
    }
    
    .news-item:last-child { 
        border-bottom: none; 
        margin-bottom: 0; 
        padding-bottom: 0; 
    }

    .news-title { 
        font-size: 15px; 
        font-weight: 500; 
        color: #333; 
        margin-bottom: 8px; 
    }
    
    .news-meta {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .date { 
        font-size: 12px; 
        color: #888; 
        display: flex; 
        align-items: center; 
        gap: 5px; 
    }
    
    /* Badge Styles */
    .badge {
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
    }
    
    .badge.published { 
        background-color: #d1fae5; 
        color: #047857; 
    }
    
    .badge.draft { 
        background-color: #fef3c7; 
        color: #b45309; 
    }

    /* Activity List Styles */
    .activity-list {
        list-style: none;
        padding-left: 10px;
    }

    .activity-item {
        position: relative;
        padding-left: 25px;
        padding-bottom: 25px;
        border-left: 2px solid #f0f0f0;
    }
    
    .activity-item:last-child { 
        border-left: 2px solid transparent; 
        padding-bottom: 0; 
    }

    .activity-item::before {
        content: '';
        position: absolute;
        left: -6px;
        top: 5px;
        width: 10px;
        height: 10px;
        background-color: #00C292;
        border-radius: 50%;
        outline: 3px solid #fff;
    }

    .activity-title { 
        font-size: 14px; 
        font-weight: 500; 
        color: #333; 
        margin-bottom: 4px; 
    }
    
    .activity-time { 
        font-size: 12px; 
        color: #999; 
    }

    /* Quick Actions */
    .quick-actions {
        background: #fff;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.02);
        border: 1px solid #eee;
        margin-bottom: 30px;
    }

    .quick-actions h3 {
        font-size: 18px;
        font-weight: 600;
        color: #333;
        margin-bottom: 20px;
    }

    .action-buttons {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 15px;
    }

    .action-btn {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 15px 20px;
        border-radius: 10px;
        text-decoration: none;
        transition: all 0.3s ease;
    }
    
    .action-btn:hover { 
        transform: translateY(-3px); 
        filter: brightness(95%);
    }

    .action-btn i { 
        font-size: 24px; 
    }
    
    .action-btn span { 
        font-size: 14px; 
        font-weight: 500; 
        white-space: nowrap; 
    }

    /* Button Colors */
    .btn-green { 
        background: #ecfdf5; 
        color: #047857; 
    }
    
    .btn-blue { 
        background: #eff6ff; 
        color: #1d4ed8; 
    }
    
    .btn-purple { 
        background: #faf5ff; 
        color: #7e22ce; 
    }
    
    .btn-orange { 
        background: #fffbeb; 
        color: #b45309; 
    }

    /* Responsive */
    @media (max-width: 1200px) {
        .overview-boxes {
            grid-template-columns: repeat(2, 1fr);
        }
        .action-buttons {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .overview-boxes {
            grid-template-columns: 1fr;
        }
        
        .details-box {
            grid-template-columns: 1fr;
        }
        
        /* Action buttons will use the 2-column layout from the 1200px breakpoint */
    }
    
    @media (max-width: 576px) {
        .action-buttons {
            grid-template-columns: 1fr;
        }
        
        .home-content {
            padding: 15px;
        }
        
        .welcome-banner {
            padding: 20px;
        }
        
        .welcome-banner h2 {
            font-size: 20px;
        }
    }
</style>

@endsection
