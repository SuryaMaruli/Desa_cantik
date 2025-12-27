<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelurahan Citangkil - Website Resmi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-color: #28a745;
            --secondary-color: #218838;
            --light-color: #f8f9fa;
            --dark-color: #343a40;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        
        /* Navbar */
        .navbar {
            background-color: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 15px 0;
        }
        
        .navbar-brand {
            font-weight: 700;
            color: var(--primary-color) !important;
            font-size: 1.5rem;
        }
        
        .nav-link {
            color: var(--dark-color) !important;
            font-weight: 500;
            margin: 0 10px;
            transition: all 0.3s ease;
        }
        
        .nav-link:hover, .nav-link.active {
            color: var(--primary-color) !important;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            padding: 8px 20px;
            font-weight: 500;
        }
        
        .btn-primary:hover {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }
        
        /* Hero Section */
        .hero {
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('https://images.unsplash.com/photo-1589829545856-d10d557cf95f?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 120px 0;
            text-align: center;
        }
        
        .hero h1 {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 20px;
        }
        
        .hero p {
            font-size: 1.2rem;
            max-width: 700px;
            margin: 0 auto 30px;
        }
        
        /* Features */
        .features {
            padding: 80px 0;
            background-color: var(--light-color);
        }
        
        .feature-icon {
            font-size: 2.5rem;
            color: var(--primary-color);
            margin-bottom: 20px;
        }
        
        .feature-card {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            transition: transform 0.3s ease;
            height: 100%;
        }
        
        .feature-card:hover {
            transform: translateY(-10px);
        }
        
        /* Footer */
        footer {
            background-color: var(--dark-color);
            color: white;
            padding: 50px 0 20px;
        }
        
        .footer-links h5 {
            color: var(--primary-color);
            margin-bottom: 20px;
            font-weight: 600;
        }
        
        .footer-links ul {
            list-style: none;
            padding: 0;
        }
        
        .footer-links li {
            margin-bottom: 10px;
        }
        
        .footer-links a {
            color: #adb5bd;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        .footer-links a:hover {
            color: white;
            text-decoration: none;
        }
        
        .social-icons a {
            display: inline-block;
            width: 40px;
            height: 40px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            text-align: center;
            line-height: 40px;
            color: white;
            margin-right: 10px;
            transition: all 0.3s ease;
        }
        
        .social-icons a:hover {
            background: var(--primary-color);
            transform: translateY(-3px);
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="bi bi-house-heart-fill me-2"></i>Kelurahan Citangkil
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#home">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">Profil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#services">Layanan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Kontak</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="hero">
        <div class="container">
            <h1>Selamat Datang di Kelurahan Citangkil</h1>
            <p class="lead">Melayani dengan hati untuk kesejahteraan masyarakat yang lebih baik</p>
            <div class="mt-4">
                <a href="#services" class="btn btn-primary btn-lg me-3">Lihat Layanan</a>
                <a href="#contact" class="btn btn-outline-light btn-lg">Hubungi Kami</a>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h2 class="mb-4">Tentang Kelurahan Citangkil</h2>
                    <p>Kelurahan Citangkil merupakan salah satu kelurahan yang terletak di Kecamatan Citangkil, Kota Cilegon, Provinsi Banten. Kami berkomitmen untuk memberikan pelayanan terbaik kepada seluruh warga dengan mengedepankan prinsip transparansi dan akuntabilitas.</p>
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center mb-3">
                                <i class="bi bi-geo-alt-fill text-primary me-3" style="font-size: 1.5rem;"></i>
                                <div>
                                    <h5 class="mb-0">Lokasi</h5>
                                    <p class="mb-0 text-muted">Kec. Citangkil, Kota Cilegon</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center mb-3">
                                <i class="bi bi-telephone-fill text-primary me-3" style="font-size: 1.5rem;"></i>
                                <div>
                                    <h5 class="mb-0">Telepon</h5>
                                    <p class="mb-0 text-muted">(0254) 1234567</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mt-4 mt-lg-0">
                    <div class="ratio ratio-16x9">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15862.123456789012!2d106.12345678901234!3d-6.123456789012345!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNsKwMDcnMjQuNCJTIDEwNsKwMDcnMjQuNCJF!5e0!3m2!1sen!2sid!4v1234567890123!5m2!1sen!2sid" 
                                style="border:0; border-radius: 10px;" allowfullscreen="" loading="lazy"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2>Layanan Kami</h2>
                <p class="lead">Berbagai layanan yang dapat dimanfaatkan oleh warga</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-card text-center h-100">
                        <div class="feature-icon">
                            <i class="bi bi-file-earmark-text"></i>
                        </div>
                        <h4>Surat Menyurat</h4>
                        <p>Pelayanan pembuatan surat keterangan, surat pengantar, dan dokumen resmi lainnya.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card text-center h-100">
                        <div class="feature-icon">
                            <i class="bi bi-people"></i>
                        </div>
                        <h4>Administrasi Kependudukan</h4>
                        <p>Pendataan dan pengelolaan data kependudukan warga Kelurahan Citangkil.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card text-center h-100">
                        <div class="feature-icon">
                            <i class="bi bi-house-heart"></i>
                        </div>
                        <h4>Bantuan Sosial</h4>
                        <p>Penyaluran bantuan sosial untuk warga yang membutuhkan.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <h2 class="mb-4">Hubungi Kami</h2>
                    <p class="mb-4">Silakan hubungi kami untuk informasi lebih lanjut atau jika Anda memiliki pertanyaan.</p>
                    <div class="mb-4">
                        <div class="d-flex mb-3">
                            <i class="bi bi-geo-alt-fill text-primary me-3 mt-1"></i>
                            <div>
                                <h5 class="mb-1">Alamat</h5>
                                <p class="mb-0">Jl. Raya Citangkil No. 123, Kec. Citangkil, Kota Cilegon, Banten</p>
                            </div>
                        </div>
                        <div class="d-flex mb-3">
                            <i class="bi bi-telephone-fill text-primary me-3 mt-1"></i>
                            <div>
                                <h5 class="mb-1">Telepon</h5>
                                <p class="mb-0">(0254) 1234567</p>
                            </div>
                        </div>
                        <div class="d-flex">
                            <i class="bi bi-envelope-fill text-primary me-3 mt-1"></i>
                            <div>
                                <h5 class="mb-1">Email</h5>
                                <p class="mb-0">kelurahan.citangkil@cilegon.go.id</p>
                            </div>
                        </div>
                    </div>
                    <div class="social-icons">
                        <a href="#"><i class="bi bi-facebook"></i></a>
                        <a href="#"><i class="bi bi-instagram"></i></a>
                        <a href="#"><i class="bi bi-whatsapp"></i></a>
                        <a href="#"><i class="bi bi-youtube"></i></a>
                    </div>
                </div>
                <div class="col-lg-6 mt-4 mt-lg-0">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title mb-4">Kirim Pesan</h5>
                            <form>
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nama Lengkap</label>
                                    <input type="text" class="form-control" id="name" required>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" required>
                                </div>
                                <div class="mb-3">
                                    <label for="subject" class="form-label">Subjek</label>
                                    <input type="text" class="form-control" id="subject" required>
                                </div>
                                <div class="mb-3">
                                    <label for="message" class="form-label">Pesan</label>
                                    <textarea class="form-control" id="message" rows="4" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Kirim Pesan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white">
        <div class="container py-5">
            <div class="row">
                <div class="col-lg-4 mb-4 mb-lg-0">
                    <h5 class="text-uppercase mb-4">Kelurahan Citangkil</h5>
                    <p>Melayani dengan hati untuk kesejahteraan masyarakat yang lebih baik di Kecamatan Citangkil, Kota Cilegon.</p>
                </div>
                <div class="col-md-4 col-lg-2 mb-4 mb-md-0">
                    <h5 class="text-uppercase mb-4">Tautan Cepat</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#home" class="text-white-50">Beranda</a></li>
                        <li class="mb-2"><a href="#about" class="text-white-50">Profil</a></li>
                        <li class="mb-2"><a href="#services" class="text-white-50">Layanan</a></li>
                        <li class="mb-2"><a href="#contact" class="text-white-50">Kontak</a></li>
                        <li><a href="{{ route('login') }}" class="text-white-50">Login</a></li>
                    </ul>
                </div>
                <div class="col-md-4 col-lg-3 mb-4 mb-md-0">
                    <h5 class="text-uppercase mb-4">Jam Pelayanan</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2">Senin - Kamis: 08.00 - 16.00 WIB</li>
                        <li class="mb-2">Jumat: 08.00 - 16.30 WIB</li>
                        <li>Sabtu - Minggu: Tutup</li>
                    </ul>
                </div>
                <div class="col-md-4 col-lg-3">
                    <h5 class="text-uppercase mb-4">Kontak Kami</h5>
                    <address>
                        <p class="mb-2">
                            <i class="bi bi-geo-alt-fill me-2"></i>Jl. Raya Citangkil No. 123
                        </p>
                        <p class="mb-2">
                            <i class="bi bi-telephone-fill me-2"></i>(0254) 1234567
                        </p>
                        <p class="mb-0">
                            <i class="bi bi-envelope-fill me-2"></i>kelurahan.citangkil@cilegon.go.id
                        </p>
                    </address>
                </div>
            </div>
            <hr class="my-4">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start">
                    <p class="mb-0">&copy; {{ date('Y') }} Kelurahan Citangkil. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-center text-md-end mt-3 mt-md-0">
                    <div class="social-icons">
                        <a href="#" class="text-white me-2"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="text-white me-2"><i class="bi bi-twitter"></i></a>
                        <a href="#" class="text-white me-2"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="text-white"><i class="bi bi-youtube"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Back to Top Button -->
    <a href="#" class="btn btn-primary btn-lg back-to-top" style="position: fixed; bottom: 20px; right: 20px; display: none; z-index: 1000;">
        <i class="bi bi-arrow-up"></i>
    </a>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JavaScript -->
    <script>
        // Back to top button
        const backToTopButton = document.querySelector('.back-to-top');
        
        // Show/hide back to top button
        window.addEventListener('scroll', () => {
            if (window.pageYOffset > 300) {
                backToTopButton.style.display = 'block';
            } else {
                backToTopButton.style.display = 'none';
            }
        });
        
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                
                const targetId = this.getAttribute('href');
                if (targetId === '#') return;
                
                const targetElement = document.querySelector(targetId);
                if (targetElement) {
                    window.scrollTo({
                        top: targetElement.offsetTop - 70, // Adjust for fixed navbar
                        behavior: 'smooth'
                    });
                    
                    // Close mobile menu if open
                    const navbarCollapse = document.querySelector('.navbar-collapse');
                    if (navbarCollapse.classList.contains('show')) {
                        const bsCollapse = new bootstrap.Collapse(navbarCollapse, {toggle: false});
                        bsCollapse.hide();
                    }
                }
            });
        });
        
        // Form submission handling
        const contactForm = document.querySelector('#contact form');
        if (contactForm) {
            contactForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Get form data
                const formData = new FormData(this);
                const formObject = {};
                formData.forEach((value, key) => {
                    formObject[key] = value;
                });
                
                // Here you would typically send the form data to a server
                console.log('Form submitted:', formObject);
                
                // Show success message
                alert('Terima kasih! Pesan Anda telah terkirim. Kami akan segera menghubungi Anda.');
                this.reset();
            });
        }
        
        // Add animation on scroll
        const animateOnScroll = () => {
            const elements = document.querySelectorAll('.feature-card, .card, .map-container');
            elements.forEach(element => {
                const elementPosition = element.getBoundingClientRect().top;
                const screenPosition = window.innerHeight / 1.3;
                
                if (elementPosition < screenPosition) {
                    element.style.opacity = '1';
                    element.style.transform = 'translateY(0)';
                }
            });
        };
        
        // Initial check on page load
        window.addEventListener('load', () => {
            // Add animation classes
            document.querySelectorAll('.feature-card, .card, .map-container').forEach(el => {
                el.style.opacity = '0';
                el.style.transform = 'translateY(20px)';
                el.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            });
            
            // Trigger animation
            setTimeout(animateOnScroll, 100);
        });
        
        // Check on scroll
        window.addEventListener('scroll', animateOnScroll);
    </script>
</body>
</html>
                                <p class="text-muted">Jiwa</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Keluarga</h5>
                                <h2 class="card-text">1,320</h2>
                                <p class="text-muted">KK</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">RT/RW</h5>
                                <h2 class="card-text">20/5</h2>
                                <p class="text-muted">Wilayah</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="card mt-4">
                    <div class="card-header">
                        Aktivitas Terkini
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Kegiatan</th>
                                        <th>Tanggal</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Pendataan Penduduk Baru</td>
                                        <td>27 Des 2025</td>
                                        <td><span class="badge bg-success">Selesai</span></td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Pembaruan Data KK</td>
                                        <td>26 Des 2025</td>
                                        <td><span class="badge bg-warning">Proses</span></td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>Pembuatan Surat Keterangan</td>
                                        <td>25 Des 2025</td>
                                        <td><span class="badge bg-success">Selesai</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</body>
</html>
