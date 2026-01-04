<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin - Kelurahan Citangkil')</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Boxicons -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    
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
            --sidebar-color: #025945; /* Hijau Tua Utama */
            --hover-color: #0d7a5e;   /* Hijau lebih terang untuk tombol aktif */
            --text-color: #ffffff;
            --sub-text-color: #8dbcb2;
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
                <a href="{{ route('admin.profil-kelurahan.index') }}" class="{{ request()->is('admin/profil-kelurahan*') ? 'active' : '' }}">
                    <i class='bx bx-group'></i>
                    <span class="links_name">Profil Kelurahan</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class='bx bx-map'></i>
                    <span class="links_name">Desa Cantik</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class='bx bx-cog'></i>
                    <span class="links_name">Pengaturan</span>
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
                    <div class="user-avatar">
                        {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                    </div>
                    <div class="user-info">
                        <p class="user-name mb-0">{{ Auth::user()->name ?? 'Administrator' }}</p>
                        <small class="user-role">Admin</small>
                    </div>
                    <i class='bx bx-chevron-down ms-1'></i>
                </div>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                <li>
                    <a class="dropdown-item" href="#">
                        <i class='bx bx-user'></i>
                        <span>Profil Saya</span>
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="#">
                        <i class='bx bx-cog'></i>
                        <span>Pengaturan</span>
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
    
    <!-- Custom Scripts -->
    <script>
        // Toggle Sidebar
        document.getElementById('sidebarToggle').addEventListener('click', function(e) {
            e.preventDefault();
            const sidebar = document.getElementById('sidebar');
            const icon = this.querySelector('i');
            
            sidebar.classList.toggle('active');
            
            // Toggle icon between menu and x
            if (icon.classList.contains('bx-menu')) {
                icon.classList.remove('bx-menu');
                icon.classList.add('bx-x');
            } else {
                icon.classList.remove('bx-x');
                icon.classList.add('bx-menu');
            }
        });

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const sidebarToggle = document.getElementById('sidebarToggle');
            
            if (window.innerWidth <= 768 && 
                !sidebar.contains(event.target) && 
                !sidebarToggle.contains(event.target) &&
                sidebar.classList.contains('active')) {
                
                sidebar.classList.remove('active');
                const icon = sidebarToggle.querySelector('i');
                icon.classList.remove('bx-x');
                icon.classList.add('bx-menu');
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
            const sidebar = document.getElementById('sidebar');
            const mainHeader = document.querySelector('.main-header');
            const mainContent = document.querySelector('.main-content');
            const sidebarToggle = document.getElementById('sidebarToggle');
            const icon = sidebarToggle.querySelector('i');
            
            if (window.innerWidth > 768) {
                // Desktop view
                sidebar.style.left = '0';
                mainHeader.style.left = 'var(--sidebar-width)';
                mainContent.style.marginLeft = 'var(--sidebar-width)';
                
                // Reset icon to menu
                if (icon.classList.contains('bx-x')) {
                    icon.classList.remove('bx-x');
                    icon.classList.add('bx-menu');
                }
            } else {
                // Mobile view
                sidebar.style.left = '-100%';
                mainHeader.style.left = '0';
                mainContent.style.marginLeft = '0';
                
                // Close sidebar if open
                if (sidebar.classList.contains('active')) {
                    sidebar.classList.remove('active');
                    if (icon.classList.contains('bx-x')) {
                        icon.classList.remove('bx-x');
                        icon.classList.add('bx-menu');
                    }
                }
            }
        }

        // Initial call
        handleResize();
        
        // Add event listener for window resize with debounce
        let resizeTimer;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(handleResize, 250);
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