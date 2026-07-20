<style>
    .footer-section {
        background:
            radial-gradient(circle at 12% 12%, rgba(255, 255, 255, 0.36), transparent 28%),
            radial-gradient(circle at 88% 4%, rgba(14, 165, 233, 0.26), transparent 26%),
            linear-gradient(135deg, #f97316 0%, #fb923c 42%, #0ea5e9 100%);
        color: #ffffff;
        font-family: 'Roboto', sans-serif;
        overflow: hidden;
        padding: 58px 24px 28px;
        position: relative;
    }

    .footer-section::before {
        background: rgba(255, 255, 255, 0.16);
        border-radius: 999px;
        content: '';
        height: 220px;
        position: absolute;
        right: -90px;
        top: -120px;
        transform: rotate(18deg);
        width: 360px;
    }

    .footer-container {
        margin: 0 auto;
        max-width: 1280px;
        position: relative;
        z-index: 1;
    }

    .footer-grid {
        display: grid;
        gap: 24px;
        grid-template-columns: repeat(1, minmax(0, 1fr));
    }

    @media (min-width: 768px) {
        .footer-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    }

    @media (min-width: 1120px) {
        .footer-grid { grid-template-columns: 1.2fr 1.55fr 0.9fr 0.95fr; }
    }

    .footer-col {
        min-height: 100%;
        padding: 0;
    }

    .footer-title,
    .footer-subtitle {
        align-items: center;
        color: #ffffff;
        display: flex;
        font-weight: 800;
        gap: 10px;
        letter-spacing: 0;
        margin: 0 0 14px;
    }

    .footer-title { font-size: 1.35rem; line-height: 1.25; }
    .footer-subtitle { font-size: 1.08rem; }

    .footer-title::before,
    .footer-subtitle::before {
        background: #ffffff;
        border-radius: 999px;
        content: '';
        height: 10px;
        width: 10px;
    }

    .footer-description {
        color: rgba(255, 255, 255, 0.9);
        font-size: 0.92rem;
        line-height: 1.75;
        margin: 0 0 16px;
    }

    .footer-divider {
        background: linear-gradient(90deg, #ffffff, rgba(255, 255, 255, 0.28));
        border-radius: 999px;
        height: 4px;
        width: 86px;
    }

    .footer-map-wrap { margin-bottom: 12px; }

    .footer-map-wrap iframe {
        aspect-ratio: 16 / 9;
        border: 0;
        border-radius: 12px;
        box-shadow: 0 14px 28px rgba(15, 23, 42, 0.22);
        display: block;
        height: auto;
        max-width: 100%;
        width: 100%;
    }

    .footer-list {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .footer-list li {
        color: rgba(255, 255, 255, 0.92);
        font-size: 0.9rem;
        line-height: 1.6;
        margin-bottom: 12px;
    }

    .footer-list.flex-item,
    .footer-list.align-center {
        align-items: flex-start;
        display: flex;
        gap: 11px;
    }

    .footer-list.align-center { align-items: center; }

    .footer-icon {
        align-items: center;
        background: rgba(255, 255, 255, 0.22);
        border-radius: 9px;
        color: #ffffff;
        display: inline-flex;
        flex: 0 0 34px;
        height: 34px;
        justify-content: center;
        margin-right: 0;
        width: 34px;
    }

    .footer-icon.mt-1 { margin-top: 2px; }

    .footer-link,
    .footer-bottom-link,
    .footer-map-link {
        color: #ffffff;
        text-decoration: none;
        transition: color .2s ease, transform .2s ease;
    }

    .footer-link:hover,
    .footer-map-link:hover,
    .footer-bottom-link:hover {
        color: #fff7ed;
    }

    .footer-list li > .footer-link {
        display: inline-flex;
        font-weight: 700;
        padding: 4px 0;
    }

    .footer-list li > .footer-link:hover { transform: translateX(4px); }
    .footer-link.white-hover:hover { color: #ffffff; }

    .footer-map-link {
        align-items: center;
        display: inline-flex;
        font-size: 0.84rem;
        font-weight: 800;
        gap: 8px;
        margin-top: 4px;
    }

    .social-links {
        display: flex;
        gap: 12px;
        margin-top: 18px;
    }

    .social-link {
        align-items: center;
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 10px 22px rgba(15, 23, 42, 0.18);
        color: #f97316;
        display: flex;
        height: 44px;
        justify-content: center;
        text-decoration: none;
        transition: transform .2s ease, background .2s ease, color .2s ease;
        width: 44px;
    }

    .social-link:hover {
        background: #fff7ed;
        color: #0ea5e9;
        transform: translateY(-3px);
    }

    .footer-hr {
        border: none;
        border-top: 1px solid rgba(255, 255, 255, 0.28);
        margin: 28px 0 18px;
    }

    .footer-bottom {
        align-items: center;
        color: rgba(255, 255, 255, 0.92);
        display: flex;
        flex-direction: column;
        font-size: 0.82rem;
        gap: 12px;
        justify-content: space-between;
        padding: 0;
    }

    .footer-bottom p { margin: 0; }

    .footer-bottom-links {
        display: flex;
        flex-wrap: wrap;
        gap: 14px;
        justify-content: center;
    }

    .footer-bottom-link {
        font-weight: 700;
        padding: 0;
    }

    @media (min-width: 768px) {
        .footer-bottom { flex-direction: row; }
    }

    @media (max-width: 767px) {
        .footer-section { padding: 44px 16px 24px; }
        .footer-title { font-size: 1.18rem; }
        .footer-description, .footer-list li { font-size: 0.95rem; }
        .footer-list li > .footer-link { display: flex; justify-content: flex-start; min-height: 0; }
        .social-link { height: 48px; width: 48px; }
        .footer-bottom { text-align: center; }
    }
</style>

@php
    $footerVillage = $currentVillage ?? config('villages.items.gunung-sugih', []);
    $footerSlug = $currentVillageSlug ?? config('villages.default', 'gunung-sugih');
    $footerOfficialName = $footerVillage['official_name'] ?? 'Kelurahan Gunung Sugih';
    $footerName = $footerVillage['name'] ?? 'Gunung Sugih';
    $footerDistrict = $footerVillage['district'] ?? 'Ciwandan';
    $footerCity = $footerVillage['city'] ?? 'Kota Cilegon';
    $footerProvince = $footerVillage['province'] ?? 'Banten';
    $footerPostalCode = $footerVillage['postal_code'] ?? '42447';
    $footerAddress = $footerVillage['address'] ?? 'Jl. Raya Gunung Sugih No. 123';
    $footerBeranda = App\Models\Beranda::first();
    $footerPhone = $footerBeranda?->no_hp ?? ($footerVillage['phone'] ?? '(0254) 123-4567');
    $footerEmail = $footerVillage['email'] ?? ($footerBeranda?->email ?? 'kelurahan@gunungsugih.go.id');
    $footerMapUrls = [
        'karangasem' => 'https://maps.app.goo.gl/dT9KcyktwJwvw9Mn6',
        'bulakan' => 'https://maps.app.goo.gl/iT9Qgtzg9PiHTrhz8',
    ];
    $footerMapQuery = $footerVillage['map_query'] ?? ('Kantor ' . $footerOfficialName . ', Cilegon');
    $footerMapEmbed = 'https://www.google.com/maps?q=' . rawurlencode($footerMapQuery) . '&output=embed';
    $footerMapUrl = $footerMapUrls[$footerSlug] ?? ('https://www.google.com/maps/search/?api=1&query=' . rawurlencode($footerMapQuery));
@endphp

<footer class="footer-section">
    <div class="footer-container">
        <div class="footer-grid">
            <div class="footer-col">
                <h3 class="footer-title">{{ $footerOfficialName }}</h3>
                <p class="footer-description">
                    Melayani dengan sepenuh hati untuk kemajuan dan kesejahteraan masyarakat {{ $footerName }}.
                </p>
                <div class="footer-divider"></div>
            </div>

            <div class="footer-col">
                <h3 class="footer-subtitle">Kontak</h3>
                <ul class="footer-list">
                    <li>
                        <div class="footer-map-wrap">
                            <iframe
                                src="{{ $footerMapEmbed }}"
                                loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"
                                allowfullscreen
                                title="Peta Lokasi {{ $footerOfficialName }}">
                            </iframe>
                        </div>
                        <a href="{{ $footerMapUrl }}" class="footer-map-link" target="_blank" rel="noopener">
                            <i class="fas fa-location-arrow"></i>
                            Buka lokasi di Google Maps
                        </a>
                    </li>
                    <li class="footer-list flex-item">
                        <i class="fas fa-map-marker-alt footer-icon mt-1"></i>
                        <span>{{ $footerAddress }}<br>Kec. {{ $footerDistrict }}, {{ $footerCity }}<br>{{ $footerProvince }} {{ $footerPostalCode }}</span>
                    </li>
                    <li class="footer-list align-center">
                        <i class="fas fa-phone-alt footer-icon"></i>
                        <span>{{ $footerPhone }}</span>
                    </li>
                    <li class="footer-list align-center">
                        <i class="fas fa-envelope footer-icon"></i>
                        <a href="mailto:{{ $footerEmail }}" class="footer-link white-hover">{{ $footerEmail }}</a>
                    </li>
                </ul>
            </div>

            <div class="footer-col">
                <h3 class="footer-subtitle">Tautan Cepat</h3>
                <ul class="footer-list">
                    <li><a href="/profil-kelurahan" class="footer-link">Tentang Kami</a></li>
                    <li><a href="/layanan" class="footer-link">Layanan</a></li>
                    <li><a href="/berita" class="footer-link">Berita</a></li>
                    <li><a href="/kontak" class="footer-link">Pengaduan</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h3 class="footer-subtitle">Media Sosial</h3>
                <p class="footer-description">Ikuti kami untuk update terbaru seputar kegiatan kelurahan.</p>
                <div class="social-links">
                    <a href="#" class="social-link" aria-label="Facebook">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="social-link" aria-label="Instagram">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="social-link" aria-label="Twitter">
                        <i class="fab fa-twitter"></i>
                    </a>
                </div>
            </div>
        </div>

        <hr class="footer-hr">

        <div class="footer-bottom">
            <p>&copy; 2026 {{ $footerOfficialName }}. Hak Cipta Dilindungi.</p>
            <div class="footer-bottom-links">
                <a href="#" class="footer-bottom-link">Kebijakan Privasi</a>
                <a href="#" class="footer-bottom-link">Syarat & Ketentuan</a>
            </div>
        </div>
    </div>
</footer>
