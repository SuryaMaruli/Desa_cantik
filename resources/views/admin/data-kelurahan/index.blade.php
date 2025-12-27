@extends('layouts.admin')

@section('page-title', 'Data Kelurahan')

@push('styles')
<style>
    /* --- 1. RESET & GLOBAL --- */
    :root {
        --sidebar-bg: #005740;     
        --sidebar-active: #0b755b; 
        --header-height: 80px;
        --sidebar-width: 260px;
        --text-dark: #333;
        --primary-green: #008C6E;
    }

    /* --- 2. SIDEBAR --- */
    .sidebar {
        background: var(--sidebar-bg) !important;
    }
    .sidebar ul li a:hover, 
    .sidebar ul li a.active { 
        background: var(--sidebar-active) !important; 
    }

    /* --- 3. MAIN CONTENT --- */
    .home-content { 
        padding: 30px; 
        background-color: #fcfcfc;
        min-height: calc(100vh - var(--header-height));
    }

    /* --- 4. KONTEN KHUSUS DATA KELURAHAN --- */
    /* A. Header Section (Judul & Tombol) */
    .data-header-card {
        background: #fff; 
        border-radius: 12px; 
        padding: 25px 30px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.02); 
        border: 1px solid #eee;
        display: flex; 
        justify-content: space-between; 
        align-items: center;
        margin-bottom: 30px;
    }
    .header-text h3 { 
        font-size: 20px; 
        font-weight: 600; 
        color: #333; 
        margin-bottom: 5px; 
    }
    .header-text p { 
        font-size: 14px; 
        color: #666; 
    }
    
    .btn-edit-data {
        background-color: #009669; 
        color: white; 
        padding: 10px 20px; 
        border-radius: 8px;
        text-decoration: none; 
        display: flex; 
        align-items: center; 
        gap: 8px; 
        font-size: 14px; 
        font-weight: 500;
        transition: 0.3s;
        border: none;
        cursor: pointer;
    }
    .btn-edit-data:hover { 
        background-color: #007d57; 
        color: white;
    }

    /* B. Statistik Cards (4 Kotak Warna-warni) */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 25px; 
        margin-bottom: 30px;
    }
    
    .stat-card {
        background: #fff; 
        border-radius: 12px; 
        padding: 25px;
    }

    /* Varian Warna Card */
    .card-green { background-color: #ecfdf5; }
    .card-blue { background-color: #eff6ff; }
    .card-purple { background-color: #faf5ff; }
    .card-orange { background-color: #fff7ed; }

    .stat-icon {
        width: 45px; 
        height: 45px; 
        border-radius: 10px;
        display: flex; 
        align-items: center; 
        justify-content: center;
        font-size: 24px; 
        margin-bottom: 15px;
    }
    /* Icon Colors */
    .icon-green { background: #10b981; color: white; }
    .icon-blue { background: #3b82f6; color: white; }
    .icon-purple { background: #a855f7; color: white; }
    .icon-orange { background: #f97316; color: white; }

    .stat-title { 
        font-size: 14px; 
        color: #555; 
        margin-bottom: 8px; 
        font-weight: 500; 
    }
    .stat-value { 
        font-size: 28px; 
        font-weight: 600; 
        color: #333; 
        margin-bottom: 5px; 
    }
    .stat-unit { 
        font-size: 13px; 
        font-weight: 500; 
    }
    
    .text-green { color: #10b981; }
    .text-blue { color: #3b82f6; }
    .text-purple { color: #a855f7; }
    .text-orange { color: #f97316; }

    /* C. Sebaran Penduduk (Progress Bars) */
    .distribution-card {
        background: #fff; 
        border-radius: 12px; 
        padding: 30px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.02); 
        border: 1px solid #eee;
    }
    .distribution-card h3 { 
        font-size: 18px; 
        font-weight: 600; 
        color: #333; 
        margin-bottom: 25px; 
    }

    .rw-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        column-gap: 50px;
        row-gap: 25px;
    }

    .rw-item { 
        margin-bottom: 5px; 
    }
    
    .rw-info {
        display: flex; 
        justify-content: space-between; 
        margin-bottom: 8px; 
        font-size: 14px;
    }
    .rw-name { 
        font-weight: 500; 
        color: #333; 
    }
    .rw-count { 
        font-weight: 600; 
        color: #333; 
    }
    .rw-unit { 
        font-weight: 400; 
        color: #999; 
        font-size: 12px; 
        margin-left: 4px;
    }

    .progress-bg {
        width: 100%; 
        height: 8px; 
        background-color: #f3f4f6; 
        border-radius: 10px; 
        overflow: hidden;
    }
    .progress-fill {
        height: 100%; 
        background-color: #009669; 
        border-radius: 10px;
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .stats-grid { 
            grid-template-columns: repeat(2, 1fr); 
        }
        .rw-grid { 
            grid-template-columns: 1fr; 
        }
    }
    
    @media (max-width: 768px) {
        .stats-grid { 
            grid-template-columns: 1fr; 
        }
        .data-header-card { 
            flex-direction: column; 
            align-items: flex-start; 
            gap: 15px; 
        }
        .rw-grid {
            grid-template-columns: 1fr;
            column-gap: 20px;
        }
    }
</style>
@endpush

@section('content')
<div class="home-content">
    <div class="data-header-card">
        <div class="header-text">
            <h3>Data Kependudukan</h3>
            <p>Kelola data statistik penduduk kelurahan</p>
        </div>
        <button class="btn-edit-data">
            <i class='bx bx-edit'></i> Edit Data
        </button>
    </div>

    <div class="stats-grid">
        <div class="stat-card card-green">
            <div class="stat-icon icon-green"><i class='bx bx-group'></i></div>
            <div class="stat-title">Total Penduduk</div>
            <div class="stat-value">{{ $data['total_penduduk'] }}</div>
            <div class="stat-unit text-green">Jiwa</div>
        </div>

        <div class="stat-card card-blue">
            <div class="stat-icon icon-blue"><i class='bx bx-male'></i></div>
            <div class="stat-title">Laki-Laki</div>
            <div class="stat-value">{{ $data['laki_laki'] }}</div>
            <div class="stat-unit text-blue">Jiwa</div>
        </div>

        <div class="stat-card card-purple">
            <div class="stat-icon icon-purple"><i class='bx bx-female'></i></div>
            <div class="stat-title">Perempuan</div>
            <div class="stat-value">{{ $data['perempuan'] }}</div>
            <div class="stat-unit text-purple">Jiwa</div>
        </div>

        <div class="stat-card card-orange">
            <div class="stat-icon icon-orange"><i class='bx bx-home-heart'></i></div>
            <div class="stat-title">Kepala Keluarga</div>
            <div class="stat-value">{{ $data['kepala_keluarga'] }}</div>
            <div class="stat-unit text-orange">KK</div>
        </div>
    </div>

    <div class="distribution-card">
        <h3>Sebaran Penduduk per RW</h3>
        
        <div class="rw-grid">
            <div class="rw-column">
                @foreach(array_slice($data['rws'], 0, 5) as $rw)
                <div class="rw-item">
                    <div class="rw-info">
                        <span class="rw-name">RW {{ $rw['no'] }}</span>
                        <div><span class="rw-count">{{ $rw['jumlah'] }}</span> <span class="rw-unit">jiwa</span></div>
                    </div>
                    <div class="progress-bg">
                        <div class="progress-fill" style="width: {{ $rw['persentase'] }}%;"></div>
                    </div>
                </div>
                @if(!$loop->last)<br>@endif
                @endforeach
            </div>

            <div class="rw-column">
                @foreach(array_slice($data['rws'], 5) as $rw)
                <div class="rw-item">
                    <div class="rw-info">
                        <span class="rw-name">RW {{ $rw['no'] }}</span>
                        <div><span class="rw-count">{{ $rw['jumlah'] }}</span> <span class="rw-unit">jiwa</span></div>
                    </div>
                    <div class="progress-bg">
                        <div class="progress-fill" style="width: {{ $rw['persentase'] }}%;"></div>
                    </div>
                </div>
                @if(!$loop->last)<br>@endif
                @endforeach
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize any required JavaScript components
    });
</script>
@endpush
@endsection
