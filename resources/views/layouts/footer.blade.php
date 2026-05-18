<style>
    /* --- FOOTER STYLES --- */
    .footer-section {
        background-color: #F89039;
        color: #f7f7f7;
        font-family: 'Roboto', sans-serif;
        padding: 48px 24px;
    }

    .footer-container {
        max-width: 1280px;
        margin: 0 auto;
    }

    .footer-grid {
        display: grid;
        grid-template-columns: repeat(1, 1fr);
        gap: 32px;
    }

    @media (min-width: 768px) {
        .footer-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (min-width: 1024px) {
        .footer-grid {
            grid-template-columns: repeat(4, 1fr);
        }
    }

    .footer-title {
        color: white;
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 16px;
    }

    .footer-subtitle {
        color: white;
        font-size: 1.125rem;
        font-weight: 600;
        margin-bottom: 16px;
    }

    .footer-description {
        font-size: 0.875rem;
        line-height: 1.625;
        margin-bottom: 16px;
    }

    .footer-divider {
        width: 48px;
        height: 4px;
        background-color: #F89039;
        border-radius: 2px;
    }

    .footer-map-wrap {
        margin-bottom: 12px;
    }

    .footer-map-wrap iframe {
        width: 100%;
        max-width: 260px;
        height: 140px;
        border: 0;
        border-radius: 10px;
        display: block;
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.2);
    }

    .footer-map-link {
        display: inline-block;
        margin-top: 8px;
        color: #ffffff;
        font-size: 0.8rem;
        text-decoration: underline;
    }

    .footer-map-link:hover {
        color: #ffe6d1;
    }

    .footer-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .footer-list li {
        margin-bottom: 12px;
        font-size: 0.875rem;
    }

    .footer-list.flex-item {
        display: flex;
        align-items: flex-start;
    }

    .footer-list.align-center {
        display: flex;
        align-items: center;
    }

    .footer-icon {
        color: #F89039;
        margin-right: 12px;
        font-size: 1rem;
    }

    .footer-icon.mt-1 {
        margin-top: 4px;
    }

    .footer-link {
        color: #ffffff;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .footer-link:hover {
        color: #F89039;
        padding-left: 4px;
    }

    .footer-link.white-hover:hover {
        color: white;
    }

    .social-links {
        display: flex;
        gap: 12px;
        margin-top: 16px;
    }

    .social-link {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background-color: #cc5500;
        color: white;
        text-decoration: none;
        transition: background-color 0.3s ease;
    }

    .social-link:hover {
        background-color: #F89039;
    }

    .footer-hr {
        border: none;
        border-top: 1px solid #cc5500;
        margin: 32px 0;
    }

    .footer-bottom {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        align-items: center;
        font-size: 0.75rem;
        color: #ffffff;
    }

    @media (min-width: 768px) {
        .footer-bottom {
            flex-direction: row;
            align-items: center;
        }
    }

    .footer-bottom-links {
        display: flex;
        gap: 24px;
        margin-top: 16px;
    }

    @media (min-width: 768px) {
        .footer-bottom-links {
            margin-top: 0;
        }
    }

    .footer-bottom-link {
        color: #9ca3af;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .footer-bottom-link:hover {
        color: white;
    }
</style>

<footer class="footer-section">
    <div class="footer-container">
        <div class="footer-grid">
            
            <div>
                <h3 class="footer-title">Kelurahan Citangkil</h3>
                <p class="footer-description">
                    Melayani dengan sepenuh hati untuk kemajuan dan kesejahteraan masyarakat Citangkil.
                </p>
                <div class="footer-divider"></div>
            </div>

            <div>
                <h3 class="footer-subtitle">Kontak</h3>
                <ul class="footer-list">
                    <li>
                        <div class="footer-map-wrap">
                            <iframe
                                src="https://www.google.com/maps?q=Kantor+Kelurahan+Citangkil,+Cilegon&output=embed"
                                loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"
                                allowfullscreen
                                title="Peta Lokasi Kelurahan Citangkil">
                            </iframe>
                        </div>
                    </li>
                    <li class="footer-list flex-item">
                        <i class="fas fa-map-marker-alt footer-icon mt-1"></i>
                        <span>Jl. Raya Citangkil No. 123<br>Kec. Citangkil, Kota Cilegon<br>Banten 42441</span>
                    </li>
                    <li class="footer-list align-center">
                        <i class="fas fa-phone-alt footer-icon"></i>
                        <span>{{ App\Models\Beranda::first()?->no_hp ?? '(0254) 123-4567' }}</span>
                    </li>
                    <li class="footer-list align-center">
                        <i class="fas fa-envelope footer-icon"></i>
                        <a href="mailto:{{ App\Models\Beranda::first()?->email ?? 'kelurahan@citangkil.go.id' }}" class="footer-link white-hover">{{ App\Models\Beranda::first()?->email ?? 'kelurahan@citangkil.go.id' }}</a>
                    </li>
                </ul>
            </div>

            <div>
                <h3 class="footer-subtitle">Tautan Cepat</h3>
                <ul class="footer-list">
                    <li><a href="/profil-kelurahan" class="footer-link">Tentang Kami</a></li>
                    <li><a href="/layanan" class="footer-link">Layanan</a></li>
                    <li><a href="/berita" class="footer-link">Berita</a></li>
                    <li><a href="/kontak" class="footer-link">Pengaduan</a></li>
                </ul>
            </div>

            <div>
                <h3 class="footer-subtitle">Media Sosial</h3>
                <p class="footer-description">Ikuti kami untuk update terbaru seputar kegiatan kelurahan.</p>
                <div class="social-links">
                    <a href="#" class="social-link">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="social-link">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="social-link">
                        <i class="fab fa-twitter"></i>
                    </a>
                </div>
            </div>
        </div>

        <hr class="footer-hr">

        <div class="footer-bottom">
            <p>&copy; 2025 Kelurahan Citangkil. Hak Cipta Dilindungi.</p>
            <div class="footer-bottom-links">
                <a href="#" class="footer-bottom-link">Kebijakan Privasi</a>
                <a href="#" class="footer-bottom-link">Syarat & Ketentuan</a>
            </div>
        </div>
    </div>
</footer>
