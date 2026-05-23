<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin - Kelurahan Citangkil')</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Boxicons -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    
<!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.0/dist/sweetalert2.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <style>
        /* Reset CSS */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: #f4f4f4;
            min-height: 100vh;
            font-family: 'Poppins', sans-serif;
        }

        /* Variabel Warna */
        :root {
            --sidebar-color: #F6903A; /* Oranye Utama */
            --hover-color: #E57A2A;   /* Oranye lebih gelap untuk hover */
            --text-color: #ffffff;
            --sub-text-color: #FFE5CC; /* Oranye muda untuk sub teks */
            --sidebar-width: 260px;
            --header-height: 60px;
        }

        /* Sidebar Styles */
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            background: var(--sidebar-color);
            padding: 20px 14px;
            transition: all 0.5s ease;
            z-index: 1000;
            overflow-y: auto;
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
        }
        
        /* Logo Section */
        .logo-details {
            margin-bottom: 30px;
            padding: 10px 10px 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .logo-details .logo_name {
            color: var(--text-color);
            font-size: 20px;
            font-weight: 500;
            margin-bottom: 0;
        }

        .logo-details .sub_name {
            color: var(--sub-text-color);
            font-size: 13px;
            margin-top: 4px;
            display: block;
        }
        
        /* Navigation List */
        .nav-list {
            padding: 0;
            list-style: none;
            margin-top: 20px;
        }

        .nav-list li {
            position: relative;
            margin: 8px 0;
        }

        .nav-list li a {
            display: flex;
            align-items: center;
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s ease;
            padding: 12px 10px;
            color: var(--text-color);
        }

        /* Icons */
        .nav-list li a i {
            height: 30px;
            min-width: 30px;
            line-height: 30px;
            text-align: center;
            font-size: 20px;
            margin-right: 15px;
        }

        /* Menu Text */
        .nav-list li a .links_name {
            font-size: 15px;
            font-weight: 400;
            white-space: nowrap;
        }

        /* Hover & Active States */
        .nav-list li a:hover,
        .nav-list li a.active {
            background: var(--hover-color);
            color: var(--text-color);
        }

        /* Logout Button Spacing */
        .nav-list li:last-child {
            margin-top: 30px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 10px;
        }
        
        /* Header Styles */
        .main-header {
            height: var(--header-height);
            background: #fff;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            position: fixed;
            left: var(--sidebar-width);
            right: 0;
            top: 0;
            z-index: 999;
            display: flex;
            align-items: center;
            padding: 0 20px;
            justify-content: space-between;
            transition: all 0.3s;
        }
        
        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            margin-top: var(--header-height);
            padding: 20px;
            min-height: calc(100vh - var(--header-height));
            transition: all 0.3s;
        }

        /* Desktop collapsed state */
        body.sidebar-collapsed .sidebar {
            left: calc(-1 * var(--sidebar-width));
        }

        body.sidebar-collapsed .main-header {
            left: 0;
        }

        body.sidebar-collapsed .main-content {
            margin-left: 0;
        }
        
        /* Toggle Button */
        #sidebarToggle {
            background: none;
            border: none;
            color: #6c757d;
            cursor: pointer;
            font-size: 1.5rem;
            padding: 5px 10px;
        }
        
        #sidebarToggle:hover {
            color: var(--primary-color);
        }
        
        /* User Dropdown */
        .user-dropdown {
            position: relative;
        }
        
        .user-dropdown .dropdown-toggle {
            display: flex;
            align-items: center;
            text-decoration: none;
            color: #6c757d;
            transition: all 0.3s;
            padding: 8px 12px;
            border-radius: 8px;
        }
        
        .user-dropdown .dropdown-toggle:hover {
            background-color: #f8f9fa;
        }
        
        .user-dropdown .dropdown-toggle::after {
            display: none;
        }
        
        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: var(--sidebar-color);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            margin-right: 10px;
        }
        
        .user-info {
            margin-right: 10px;
            text-align: right;
            display: none;
        }
        
        .user-name {
            font-size: 14px;
            font-weight: 500;
            color: #333;
            margin: 0;
            line-height: 1.2;
        }
        
        .user-role {
            font-size: 12px;
            color: #6c757d;
            margin: 0;
            line-height: 1.2;
        }
        
        .dropdown-menu {
            border: none;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            border-radius: 8px;
            padding: 8px 0;
            margin-top: 5px;
            min-width: 220px;
        }
        
        .dropdown-item {
            padding: 8px 16px;
            color: #333;
            display: flex;
            align-items: center;
            transition: all 0.2s;
        }
        
        .dropdown-item i {
            margin-right: 10px;
            font-size: 18px;
            width: 20px;
            text-align: center;
        }
        
        .dropdown-item:hover {
            background-color: #f8f9fa;
            color: var(--sidebar-color);
        }
        
        .dropdown-divider {
            margin: 5px 0;
            border-top: 1px solid #eee;
        }
        
        @media (min-width: 768px) {
            .user-info {
                display: block;
            }
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                left: calc(-1 * var(--sidebar-width));
            }
            
            .sidebar.active {
                left: 0;
            }
            
            .main-content,
            .main-header {
                margin-left: 0;
                left: 0;
            }
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="logo-details">
            <div class="logo_name">Admin Panel</div>
            <div class="sub_name">Kelurahan Citangkil</div>
        </div>
        
        <ul class="nav-list">
<li>
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->is('admin/dashboard*') ? 'active' : '' }}">
                    <i class='bx bx-grid-alt'></i>
                    <span class="links_name">Dashboard</span>
                </a>
            </li>
            <li>
<a href="{{ route('home') }}" class="">
                    <i class='bx bx-home-alt'></i>
                    <span class="links_name">Kembali ke Beranda</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.beranda.index') }}" class="{{ request()->is('admin/beranda*') ? 'active' : '' }}">
                    <i class='bx bx-home'></i>
                    <span class="links_name">Beranda</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.berita.index') }}" class="{{ request()->is('admin/berita*') ? 'active' : '' }}">
                    <i class='bx bx-news'></i>
                    <span class="links_name">Berita & Informasi</span>
                </a>
            </li>
<li>
                <a href="{{ route('admin.data-kelurahan.index') }}" class="{{ request()->is('admin/data-kelurahan*') ? 'active' : '' }}">
                    <i class='bx bx-data'></i>
                    <span class="links_name">Data Kelurahan</span>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.galeri.index') }}" class="{{ request()->is('admin/galeri*') ? 'active' : '' }}">
                    <i class='bx bx-image'></i>
                    <span class="links_name">Galeri</span>
                </a>
            </li>
<li>
                <a href="{{ route('admin.layanan.index') }}" class="{{ request()->is('admin/layanan*') ? 'active' : '' }}">
                    <i class='bx bx-file'></i>
                    <span class="links_name">Layanan</span>
                </a>
            </li>
<li>
                <a href="{{ route('admin.maklumat-pelayananan.index') }}" class="{{ request()->is('admin/maklumat-pelayananan*') ? 'active' : '' }}">
                    <i class='bx bx-info-square'></i>
                    <span class="links_name">Maklumat Pelayanan</span>
                </a>
            </li>
<li>
                <a href="{{ route('admin.struktur-organisasi.index') }}" class="{{ request()->is('admin/struktur-organisasi*') ? 'active' : '' }}">
                    <i class='bx bx-sitemap'></i>
                    <span class="links_name">Struktur Organisasi</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.monografi.index') }}" class="{{ request()->is('admin/monografi*') ? 'active' : '' }}">
                    <i class='bx bx-map-alt'></i>
                    <span class="links_name">Monografi</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.profil-kelurahan.index') }}" class="{{ request()->is('admin/profil-kelurahan*') ? 'active' : '' }}">
                    <i class='bx bx-group'></i>
                    <span class="links_name">Profil Kelurahan</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.desa-cantik.index') }}" class="{{ request()->is('admin/desa-cantik*') ? 'active' : '' }}">
                    <i class='bx bx-map'></i>
                    <span class="links_name">Desa Cantik</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.informasi-publik.index') }}" class="{{ request()->is('admin/informasi-publik*') ? 'active' : '' }}">
                    <i class='bx bx-info-circle'></i>
                    <span class="links_name">Informasi Publik</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.prestasi.index') }}" class="{{ request()->is('admin/prestasi*') ? 'active' : '' }}">
                    <i class='bx bx-trophy'></i>
                    <span class="links_name">Prestasi</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.data-lurah.index') }}" class="{{ request()->is('admin/data-lurah*') ? 'active' : '' }}">
                    <i class='bx bx-user'></i>
                    <span class="links_name">Data Lurah</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.admin.index') }}" class="{{ request()->is('admin/admin*') ? 'active' : '' }}">
                    <i class='bx bx-user-plus'></i>
                    <span class="links_name">Kelola Admin</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.profil.edit') }}" class="{{ request()->is('admin/profil*') ? 'active' : '' }}">
                    <i class='bx bx-user'></i>
                    <span class="links_name">Profil Saya</span>
                </a>
            </li>
<li>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class='bx bx-log-out'></i>
                    <span class="links_name">Logout</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        </ul>
    </div>

    <!-- Header -->
    <header class="main-header">
        <div class="d-flex align-items-center">
            <button class="btn" id="sidebarToggle">
                <i class='bx bx-menu'></i>
            </button>
            <h4 class="mb-0 ms-3 d-none d-md-block">@yield('page-title', 'Dashboard')</h4>
        </div>
        
<div class="dropdown user-dropdown">
            <a class="dropdown-toggle" href="#" role="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
<div class="d-flex align-items-center">
                        @if(Auth::user()->foto_profil)
                            <img src="{{ asset('storage/' . Auth::user()->foto_profil) }}"
                                 alt="Foto Profil" 
                                 class="user-avatar"
                                 style="width: 36px; height: 36px; border-radius: 50%; object-fit: cover;"
                                 onerror="this.onerror=null; this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            <div class="user-avatar" style="display: none;">
                                {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                            </div>
                        @else
                            <div class="user-avatar">
                                {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                            </div>
                        @endif
<div class="user-info">
                        <p class="user-name mb-0">{{ Auth::user()->name ?? 'Administrator' }}</p>
                        <small class="user-role">{{ Auth::user()->role === 'super_admin' ? 'Super Admin' : 'Admin' }}</small>
                    </div>
                    <i class='bx bx-chevron-down ms-1'></i>
                </div>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                <li>
                    <a class="dropdown-item" href="{{ route('admin.profil.edit') }}">
                        <i class='bx bx-user'></i>
                        <span>Profil Saya</span>
                    </a>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class='bx bx-log-out'></i>
                        <span>Keluar</span>
                    </a>
                </li>
            </ul>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        @yield('content')
    </main>

<!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.0/dist/sweetalert2.min.js"></script>
    
    <!-- Data Lurah Modal (Global) -->
    <div class="modal fade" id="dataLurahModal" tabindex="-1" aria-labelledby="dataLurahModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="dataLurahModalLabel">Edit Data Lurah</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="dataLurahForm">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="namaLurah" class="form-label">Nama Lurah</label>
                                <input type="text" class="form-control" id="namaLurah" value="Budi Santoso, S.Sos">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="nipLurah" class="form-label">NIP</label>
                                <input type="text" class="form-control" id="nipLurah" value="198504152009031001">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="pangkatLurah" class="form-label">Pangkat</label>
                                <input type="text" class="form-control" id="pangkatLurah" value="Pembina Tingkat I">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="golonganLurah" class="form-label">Golongan</label>
                                <input type="text" class="form-control" id="golonganLurah" value="IV/b">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="jabatanLurah" class="form-label">Jabatan</label>
                                <input type="text" class="form-control" id="jabatanLurah" value="Lurah Citangkil">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="nipLurah" class="form-label">NIP</label>
                                <input type="text" class="form-control" id="nipLurah" value="196512311985031023">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="fotoLurah" class="form-label">Foto Lurah</label>
                            <input type="file" class="form-control" id="fotoLurah" accept="image/*">
                            <div class="mt-2" id="fotoPreview" style="display: none;">
                                <img id="previewImage" src="" alt="Preview" style="max-width: 200px; max-height: 200px; border-radius: 8px;">
                                <button type="button" class="btn btn-sm btn-danger mt-2" onclick="removeFoto()">
                                    <i class='bx bx-trash'></i> Hapus Foto
                                </button>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="sambutanLurah" class="form-label">Sambutan Lurah</label>
                            <textarea class="form-control" id="sambutanLurah" rows="4">Situs web ini kami hadirkan sebagai wadah untuk mempublikasi atau informasi kepada masyarakat. Dengan kemudahan yang diberikan, diharapkan dapat mempercepat proses pelayanan publik dan mempermudah masyarakat dalam memperoleh informasi terkini.</textarea>
                        </div>
                    </form>
                </div>
<div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="btnSimpanDataLurah" onclick="simpanDataLurah()" disabled>
                        <i class='bx bx-save'></i> Simpan Perubahan
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Custom Scripts -->
    <script>
    const sidebar = document.getElementById('sidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebarIcon = sidebarToggle.querySelector('i');

    function setSidebarIcon(isOpen) {
        if (isOpen) {
            sidebarIcon.classList.remove('bx-menu');
            sidebarIcon.classList.add('bx-x');
        } else {
            sidebarIcon.classList.remove('bx-x');
            sidebarIcon.classList.add('bx-menu');
        }
    }

    // Toggle Sidebar
    sidebarToggle.addEventListener('click', function(e) {
        e.preventDefault();

        if (window.innerWidth > 768) {
            // Desktop: gunakan class body untuk collapsed state
            document.body.classList.toggle('sidebar-collapsed');
            const isSidebarOpen = !document.body.classList.contains('sidebar-collapsed');
            setSidebarIcon(isSidebarOpen);
        } else {
            // Mobile: gunakan class active pada sidebar
            sidebar.classList.toggle('active');
            const isSidebarOpen = sidebar.classList.contains('active');
            setSidebarIcon(isSidebarOpen);
        }
    });

    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', function(event) {
        if (window.innerWidth <= 768 &&
            !sidebar.contains(event.target) &&
            !sidebarToggle.contains(event.target) &&
            sidebar.classList.contains('active')) {

            sidebar.classList.remove('active');
            setSidebarIcon(false);
        }
    });

    // Add active class to current menu item based on URL
    document.addEventListener('DOMContentLoaded', function() {
        const currentPath = window.location.pathname;
        const navLinks = document.querySelectorAll('.nav-list a');
        
        navLinks.forEach(link => {
            if (link.getAttribute('href') === currentPath) {
                link.classList.add('active');
            }
        });
        
        // Close sidebar by default on mobile
        if (window.innerWidth <= 768) {
            document.getElementById('sidebar').classList.remove('active');
        }
    });

    // Handle window resize
    function handleResize() {
        if (window.innerWidth > 768) {
            // Desktop view: reset mobile state, icon mengikuti desktop state
            sidebar.classList.remove('active');
            const isSidebarOpen = !document.body.classList.contains('sidebar-collapsed');
            setSidebarIcon(isSidebarOpen);
        } else {
            // Mobile view: pastikan desktop state tidak mengganggu
            document.body.classList.remove('sidebar-collapsed');
            const isSidebarOpen = sidebar.classList.contains('active');
            setSidebarIcon(isSidebarOpen);
        }
    }

    // Data Lurah Functions
    // Load data lurah dari localStorage saat page load
    document.addEventListener('DOMContentLoaded', function() {
        loadDataLurah();
    });

// Fungsi untuk membuka modal Data Lurah
    function openDataLurahModal() {
        // Simpan data original saat modal dibuka
        simpanOriginalDataLurah();
        
        // Inisialisasi event listeners untuk form fields
        initEventListenersDataLurah();
        
        // Cek perubahan dan update status tombol
        cekPerubahanDataLurah();
        
        const modal = new bootstrap.Modal(document.getElementById('dataLurahModal'));
        modal.show();
    }

    // Variable untuk menyimpan data original
    var originalDataLurah = {};

    // Fungsi untuk menyimpan data original
    function simpanOriginalDataLurah() {
        originalDataLurah = {
            namaLurah: document.getElementById('namaLurah').value,
            nipLurah: document.getElementById('nipLurah').value,
            pangkatLurah: document.getElementById('pangkatLurah').value,
            golonganLurah: document.getElementById('golonganLurah').value,
            jabatanLurah: document.getElementById('jabatanLurah').value,
            sambutanLurah: document.getElementById('sambutanLurah').value
        };
    }

    // Fungsi untuk cek perubahan
    function cekPerubahanDataLurah() {
        const btn = document.getElementById('btnSimpanDataLurah');
        if (!btn) return;

        const dataSaatIni = {
            namaLurah: document.getElementById('namaLurah').value,
            nipLurah: document.getElementById('nipLurah').value,
            pangkatLurah: document.getElementById('pangkatLurah').value,
            golonganLurah: document.getElementById('golonganLurah').value,
            jabatanLurah: document.getElementById('jabatanLurah').value,
            sambutanLurah: document.getElementById('sambutanLurah').value
        };

        // Cek apakah ada perubahan
        const adaPerubahan = 
            dataSaatIni.namaLurah !== originalDataLurah.namaLurah ||
            dataSaatIni.nipLurah !== originalDataLurah.nipLurah ||
            dataSaatIni.pangkatLurah !== originalDataLurah.pangkatLurah ||
            dataSaatIni.golonganLurah !== originalDataLurah.golonganLurah ||
            dataSaatIni.jabatanLurah !== originalDataLurah.jabatanLurah ||
            dataSaatIni.sambutanLurah !== originalDataLurah.sambutanLurah;

        // Cek apakah ada file foto baru
        const fotoInput = document.getElementById('fotoLurah');
        const adaFotoBaru = fotoInput && fotoInput.files && fotoInput.files.length > 0;

// Enable tombol jika ada perubahan atau ada foto baru
        if (adaPerubahan || adaFotoBaru) {
            btn.disabled = false;
        } else {
            btn.disabled = true;
        }
    }

    // Event listeners untuk form fields Data Lurah
    function initEventListenersDataLurah() {
        const fields = ['namaLurah', 'nipLurah', 'pangkatLurah', 'golonganLurah', 'jabatanLurah', 'sambutanLurah'];
        
        fields.forEach(function(fieldId) {
            const field = document.getElementById(fieldId);
            if (field) {
                field.addEventListener('input', cekPerubahanDataLurah);
                field.addEventListener('change', cekPerubahanDataLurah);
            }
        });

        // Event listener untuk file input
        const fotoInput = document.getElementById('fotoLurah');
        if (fotoInput) {
            fotoInput.addEventListener('change', cekPerubahanDataLurah);
        }
    }

    // Fungsi untuk menyimpan data lurah ke localStorage
    function simpanDataLurah() {
        const dataLurah = {
            namaLurah: document.getElementById('namaLurah').value,
            nipLurah: document.getElementById('nipLurah').value,
            pangkatLurah: document.getElementById('pangkatLurah').value,
            golonganLurah: document.getElementById('golonganLurah').value,
            jabatanLurah: document.getElementById('jabatanLurah').value,
            sambutanLurah: document.getElementById('sambutanLurah').value,
            updatedAt: new Date().toISOString()
        };
        
        // Simpan ke localStorage
        localStorage.setItem('dataLurah', JSON.stringify(dataLurah));
        
        // Tampilkan notifikasi sukses
        showNotification('Data lurah berhasil disimpan!', 'success');
        
        // Tutup modal
        const modal = bootstrap.Modal.getInstance(document.getElementById('dataLurahModal'));
        modal.hide();
    }

    // Fungsi untuk load data lurah dari localStorage
    function loadDataLurah() {
        const savedData = localStorage.getItem('dataLurah');
        
        if (savedData) {
            const dataLurah = JSON.parse(savedData);
            
            // Isi form dengan data yang tersimpan
            document.getElementById('namaLurah').value = dataLurah.namaLurah || 'M. ALI WAHIDI, S.Sos.M.Si';
            document.getElementById('nipLurah').value = dataLurah.nipLurah || '196512311985031023';
            document.getElementById('pangkatLurah').value = dataLurah.pangkatLurah || 'Pembina Tingkat I';
            document.getElementById('golonganLurah').value = dataLurah.golonganLurah || 'IV/b';
            document.getElementById('jabatanLurah').value = dataLurah.jabatanLurah || 'Lurah Citangkil';
            document.getElementById('sambutanLurah').value = dataLurah.sambutanLurah || 'Situs web ini kami hadirkan sebagai wadah untuk mempublikasi atau informasi kepada masyarakat. Dengan kemudahan yang diberikan, diharapkan dapat mempercepat proses pelayanan publik dan mempermudah masyarakat dalam memperoleh informasi terkini.';
            
            // Load foto jika ada
            if (dataLurah.fotoLurah) {
                showFotoPreview(dataLurah.fotoLurah);
            }
        }
    }

    // Fungsi untuk preview foto
    function showFotoPreview(imageSrc) {
        const previewDiv = document.getElementById('fotoPreview');
        const previewImage = document.getElementById('previewImage');
        
        previewImage.src = imageSrc;
        previewDiv.style.display = 'block';
    }

    // Fungsi untuk menghapus foto
    function removeFoto() {
        const previewDiv = document.getElementById('fotoPreview');
        const fileInput = document.getElementById('fotoLurah');
        
        previewDiv.style.display = 'none';
        fileInput.value = '';
    }

    // Event listener untuk file input
    document.addEventListener('DOMContentLoaded', function() {
        const fileInput = document.getElementById('fotoLurah');
        if (fileInput) {
            fileInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file && file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        showFotoPreview(e.target.result);
                    };
                    reader.readAsDataURL(file);
                }
            });
        }
    });

    // Fungsi untuk menampilkan notifikasi
    function showNotification(message, type = 'info') {
        // Buat elemen notifikasi
        const notification = document.createElement('div');
        notification.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
        notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
        notification.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;
        
        // Tambahkan ke body
        document.body.appendChild(notification);
        
        // Auto remove setelah 5 detik
        setTimeout(() => {
            if (notification.parentNode) {
                notification.remove();
            }
        }, 5000);
    }

    // Fungsi untuk export data lurah (backup)
    function exportDataLurah() {
        const savedData = localStorage.getItem('dataLurah');
        
        if (savedData) {
            const dataLurah = JSON.parse(savedData);
            const dataStr = JSON.stringify(dataLurah, null, 2);
            const dataUri = 'data:application/json;charset=utf-8,'+ encodeURIComponent(dataStr);
            
            const exportFileDefaultName = 'data_lurah_' + new Date().toISOString().slice(0,10) + '.json';
            
            const linkElement = document.createElement('a');
            linkElement.setAttribute('href', dataUri);
            linkElement.setAttribute('download', exportFileDefaultName);
            linkElement.click();
            
            showNotification('Data lurah berhasil di-export!', 'success');
        } else {
            showNotification('Tidak ada data lurah untuk di-export!', 'warning');
        }
    }

    // Fungsi untuk import data lurah
    function importDataLurah(event) {
        const file = event.target.files[0];
        
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                try {
                    const importedData = JSON.parse(e.target.result);
                    
                    // Validasi data
                    if (importedData.namaLurah) {
                        localStorage.setItem('dataLurah', JSON.stringify(importedData));
                        loadDataLurah();
                        showNotification('Data lurah berhasil di-import!', 'success');
                    } else {
                        showNotification('Format file tidak valid!', 'danger');
                    }
                } catch (error) {
                    showNotification('Gagal membaca file. Pastikan format JSON benar!', 'danger');
                }
            };
            reader.readAsText(file);
        }
    }

// Initial call - wrapped in try-catch to prevent errors from breaking script chain
    try {
        if (typeof handleResize === 'function') {
            handleResize();
        }
    } catch (e) {
        console.warn('handleResize error:', e);
    }
    
    // Add event listener for window resize with debounce - also wrapped in try-catch
    let resizeTimer;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function() {
            try {
                if (typeof handleResize === 'function') {
                    handleResize();
                }
            } catch (e) {
                console.warn('handleResize on resize error:', e);
            }
        }, 250);
    });
    
    // Close dropdown when clicking outside
    document.addEventListener('click', function(event) {
        const dropdowns = document.querySelectorAll('.dropdown');
        dropdowns.forEach(dropdown => {
            if (!dropdown.contains(event.target)) {
                const menu = dropdown.querySelector('.dropdown-menu');
                if (menu && menu.classList.contains('show')) {
                    const toggle = dropdown.querySelector('[data-bs-toggle="dropdown"]');
                    if (toggle) {
                        const bsDropdown = new bootstrap.Dropdown(toggle);
                        bsDropdown.hide();
                    }
                }
            }
        });
});
</script>
@stack('scripts')
</body>
</html>
