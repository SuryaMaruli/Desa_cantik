@extends('layouts.admin')

@section('title', 'Pengaturan - Admin Kelurahan Citangkil')
@section('page-title', 'Pengaturan')

@section('content')
<div class="container-fluid">
    <main class="container">
        
        <nav class="top-nav">
            <button class="nav-item active" onclick="openTab(event, 'tab-akun')">
                <i class="fa-regular fa-user"></i>
                <span>Akun</span>
            </button>
            <button class="nav-item" onclick="openTab(event, 'tab-keamanan')">
                <i class="fa-solid fa-shield-halved"></i>
                <span>Keamanan</span>
            </button>
        </nav>

        <div id="tab-akun" class="tab-content active">
            <div class="card">
                <h2>Pengaturan Akun</h2>
                <form>
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" value="admin">
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" value="admin@citangkil.go.id">
                    </div>
                    <div class="form-group">
                        <label>Nama Lengkap</label>
                        <input type="text" value="Administrator">
                    </div>
                    <button type="button" class="btn-primary">Simpan Perubahan</button>
                </form>
            </div>
        </div>

        <div id="tab-keamanan" class="tab-content">
            <div class="card">
                <h2>Ubah Password</h2>
                <form>
                    <div class="form-group">
                        <label>Password Saat Ini</label>
                        <input type="password">
                    </div>
                    <div class="form-group">
                        <label>Password Baru</label>
                        <input type="password">
                    </div>
                    <div class="form-group">
                        <label>Konfirmasi Password Baru</label>
                        <input type="password">
                    </div>
                    <button type="button" class="btn-primary">Ubah Password</button>
                </form>
            </div>

            <div class="card">
                <h2>Keamanan Tambahan</h2>
                <div class="security-box">
                    <div class="security-text">
                        <h3>Two-Factor Authentication</h3>
                        <p>Tambahkan lapisan keamanan ekstra</p>
                    </div>
                    <button type="button" class="btn-secondary">Aktifkan</button>
                </div>
            </div>
        </div>

    </main>
</div>
@endsection

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
    /* --- 1. CSS GLOBAL --- */
    .container {
        width: 100%;
        max-width: 800px;
        display: flex;
        flex-direction: column;
        gap: 25px;
        margin: 0 auto;
    }

    /* --- 2. NAVIGASI (TAB MENU) --- */
    .top-nav {
        background-color: #ffffff;
        padding: 15px;
        border-radius: 16px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.03);
        display: flex;
        gap: 10px;
        border: 1px solid #eaeaea;
        flex-wrap: wrap;
        max-width: fit-content;
    }

    .nav-item {
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px 20px;
        border-radius: 10px;
        color: #64748b;
        font-weight: 500;
        font-size: 15px;
        cursor: pointer;
        transition: all 0.2s ease;
        border: none;
        background: none;
    }

    .nav-item:hover { 
        background-color: #f1f5f9; 
        color: #334155; 
    }

    /* Style untuk Tab Aktif */
    .nav-item.active {
        background-color: #00a06b;
        color: #ffffff;
        font-weight: 600;
        box-shadow: 0 4px 6px rgba(0, 160, 107, 0.2);
    }
    .nav-item i { font-size: 16px; }

    /* --- 3. KARTU & FORM --- */
    .card {
        background-color: #ffffff;
        border-radius: 16px;
        padding: 35px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.03);
        border: 1px solid #eaeaea;
        animation: fadeIn 0.3s ease-in-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(5px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .card h2 { 
        font-size: 20px; 
        font-weight: 600; 
        color: #1e293b; 
        margin-bottom: 25px; 
    }

    .form-group { 
        margin-bottom: 20px; 
    }
    
    .form-group label { 
        display: block; 
        margin-bottom: 8px; 
        font-size: 14px; 
        color: #475569; 
        font-weight: 500; 
    }
    
    .form-group input {
        width: 100%; 
        padding: 12px 16px; 
        border-radius: 8px;
        border: 1px solid #cbd5e1; 
        font-size: 14px; 
        color: #1e293b;
        outline: none; 
        transition: border-color 0.2s;
    }
    
    .form-group input:focus { 
        border-color: #00a06b; 
        box-shadow: 0 0 0 3px rgba(0, 160, 107, 0.1); 
    }

    /* --- 4. TOMBOL --- */
    .btn-primary {
        background-color: #00a06b; 
        color: white; 
        border: none;
        padding: 12px 24px; 
        border-radius: 8px; 
        font-size: 14px;
        font-weight: 500; 
        cursor: pointer; 
        transition: background-color 0.2s;
    }
    
    .btn-primary:hover { 
        background-color: #008f5d; 
    }

    .btn-secondary {
        background-color: #e2e8f0; 
        color: #334155; 
        border: none;
        padding: 10px 20px; 
        border-radius: 8px; 
        font-size: 14px;
        font-weight: 500; 
        cursor: pointer; 
        transition: background-color 0.2s;
    }
    
    .btn-secondary:hover { 
        background-color: #cbd5e1; 
    }

    /* --- 5. KEAMANAN TAMBAHAN (2FA) --- */
    .security-box {
        background-color: #f8fafc; 
        border-radius: 8px; 
        padding: 20px;
        display: flex; 
        justify-content: space-between; 
        align-items: center;
    }
    
    .security-text h3 { 
        font-size: 15px; 
        font-weight: 600; 
        color: #334155; 
        margin-bottom: 4px; 
    }
    
    .security-text p { 
        font-size: 13px; 
        color: #64748b; 
    }

    /* --- 6. LOGIKA TAMPILAN (UTILITY) --- */
    .tab-content { 
        display: none; 
    }
    
    .tab-content.active { 
        display: block; 
    }

    /* Responsif Mobile */
    @media (max-width: 600px) {
        .container {
            max-width: 100%;
            padding: 0 10px;
        }

        .top-nav { 
            flex-direction: column; 
            gap: 5px; 
        }
        
        .nav-item { 
            width: 100%; 
        }
        
        .security-box { 
            flex-direction: column; 
            align-items: flex-start; 
            gap: 15px; 
        }
        
        .btn-secondary { 
            width: 100%; 
        }

        .card {
            padding: 20px;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    function openTab(evt, tabName) {
        // 1. Sembunyikan semua konten tab
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tab-content");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
            tabcontent[i].classList.remove("active");
        }

        // 2. Hapus class "active" dari semua tombol navigasi
        tablinks = document.getElementsByClassName("nav-item");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }

        // 3. Tampilkan tab yang dipilih dan tambahkan class "active" ke tombolnya
        document.getElementById(tabName).style.display = "block";
        document.getElementById(tabName).classList.add("active");
        evt.currentTarget.className += " active";
    }
</script>
@endpush
