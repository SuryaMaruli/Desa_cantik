<h2 class="section-title">Galeri Kegiatan</h2>

<div class="grid-3">
    @forelse($galeri as $item)

        @php
            /*
            |--------------------------------------------------------------------------
            | Ambil semua foto
            |--------------------------------------------------------------------------
            */
            $allPhotos = ($item->is_group && $item->group_photos->count() > 0)
                ? $item->group_photos
                : collect([
                    (object) [
                        'id' => $item->id_galeri,
                        'foto' => $item->foto,
                        'judul_foto' => $item->judul_foto,
                        'deskripsi' => $item->deskripsi,
                        'kategori' => $item->kategori,
                        'tanggal_kegiatan' => $item->tanggal_kegiatan,
                    ]
                ]);

            /*
            |--------------------------------------------------------------------------
            | Data viewer modal
            |--------------------------------------------------------------------------
            */
            $viewerPhotos = $allPhotos->map(function ($photo) {

                $formattedDate = '';

                if (!empty($photo->tanggal_kegiatan)) {
                    $formattedDate = is_string($photo->tanggal_kegiatan)
                        ? \Carbon\Carbon::parse($photo->tanggal_kegiatan)->format('d M Y')
                        : $photo->tanggal_kegiatan->format('d M Y');
                }

                return [
                    'src' => asset('storage/' . $photo->foto),
                    'title' => $photo->judul_foto,
                    'description' => $photo->deskripsi,
                    'category' => ucfirst($photo->kategori),
                    'date' => $formattedDate,
                ];
            })->values();
        @endphp

        <div class="gallery-card">

            {{-- JSON DATA --}}
            <script type="application/json" id="public-gallery-viewer-data-{{ $item->id_galeri }}">
                {!! json_encode($viewerPhotos) !!}
            </script>

            {{-- ========================= --}}
            {{-- CAROUSEL --}}
            {{-- ========================= --}}
            @if($item->foto && $allPhotos->count() > 0)

                <div class="ig-carousel" id="igCarousel{{ $item->id_galeri }}" onclick="openGalleryModal({{ $item->id_galeri }})">

                    {{-- MAIN IMAGE --}}
                    <div class="ig-main">

                        @foreach($allPhotos as $photoIndex => $photo)

                            <img
                                src="{{ asset('storage/' . $photo->foto) }}"
                                alt="{{ $photo->judul_foto }}"
                                class="ig-main-img {{ $photoIndex === 0 ? 'active' : '' }}"
                                data-index="{{ $photoIndex }}"
                                data-title="{{ $photo->judul_foto }}"
                                data-description="{{ $photo->deskripsi }}"
                                data-category="{{ ucfirst($photo->kategori) }}"
                                data-date="{{ !empty($photo->tanggal_kegiatan) ? (is_string($photo->tanggal_kegiatan) ? \Carbon\Carbon::parse($photo->tanggal_kegiatan)->format('d M Y') : $photo->tanggal_kegiatan->format('d M Y')) : '' }}"
                            >

                        @endforeach

                        @if($allPhotos->count() > 1)
                            <button type="button" class="ig-nav prev" id="igPrev{{ $item->id_galeri }}" aria-label="Foto sebelumnya" onclick="event.stopPropagation(); window['moveSlide' + {{ $item->id_galeri }}](-1)">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                            <button type="button" class="ig-nav next" id="igNext{{ $item->id_galeri }}" aria-label="Foto berikutnya" onclick="event.stopPropagation(); window['moveSlide' + {{ $item->id_galeri }}](1)">
                                <i class="fas fa-chevron-right"></i>
                            </button>
                        @endif

                        @if($allPhotos->count() > 1)
                            <div class="gallery-photo-count">
                                <i class="far fa-images"></i>
                                <span>{{ $allPhotos->count() }} foto</span>
                            </div>

                            <div class="ig-dots" id="igDots{{ $item->id_galeri }}">
                                @foreach($allPhotos as $photoIndex => $photo)
                                    <span class="ig-dot {{ $photoIndex === 0 ? 'active' : '' }}" data-index="{{ $photoIndex }}" onclick="event.stopPropagation(); window['goToSlide' + {{ $item->id_galeri }}]({{ $photoIndex }})"></span>
                                @endforeach
                            </div>
                        @endif

                        <div class="gallery-expand-btn">
                            <i class="fas fa-expand"></i>
                        </div>
                    </div>

                    @if($allPhotos->count() > 1)
                        <div class="ig-thumbs" id="igThumbs{{ $item->id_galeri }}">
                            @foreach($allPhotos as $photoIndex => $photo)
                                <img src="{{ asset('storage/' . $photo->foto) }}" alt="Thumbnail {{ $photoIndex + 1 }}" class="ig-thumb {{ $photoIndex === 0 ? 'active' : '' }}" data-index="{{ $photoIndex }}" onclick="event.stopPropagation(); window['goToSlide' + {{ $item->id_galeri }}]({{ $photoIndex }})">
                            @endforeach
                        </div>
                    @endif

                </div>

                <script>
                (function () {
                    const carouselId = '{{ $item->id_galeri }}';
                    const images = Array.from(document.querySelectorAll('#igCarousel' + carouselId + ' .ig-main-img'));
                    const dots = Array.from(document.querySelectorAll('#igDots' + carouselId + ' .ig-dot'));
                    const thumbs = Array.from(document.querySelectorAll('#igThumbs' + carouselId + ' .ig-thumb'));

                    window['carouselState' + carouselId] = { current: 0 };

                    window['renderSlide' + carouselId] = function(index) {
                        window['carouselState' + carouselId].current = index;
                        images.forEach((img, i) => {
                            const isActive = i === index;
                            img.classList.toggle('active', isActive);
                            img.style.display = isActive ? 'block' : 'none';
                        });
                        if (dots.length) dots.forEach((dot, i) => dot.classList.toggle('active', i === index));
                        if (thumbs.length) thumbs.forEach((th, i) => th.classList.toggle('active', i === index));
                    };

                    window['moveSlide' + carouselId] = function(direction) {
                        const current = window['carouselState' + carouselId].current;
                        window['renderSlide' + carouselId]((current + direction + images.length) % images.length);
                    };

                    window['goToSlide' + carouselId] = function(index) {
                        window['renderSlide' + carouselId](index);
                    };

                    window['getGalleryPhotos' + carouselId] = function() {
                        return images.map(img => ({
                            src: img.src,
                            alt: img.alt,
                            title: img.dataset.title || img.alt,
                            description: img.dataset.description || '',
                            category: img.dataset.category || '',
                            date: img.dataset.date || ''
                        }));
                    };
})();
                </script>

            @else

                <div class="gallery-img-placeholder">
                    <i class="far fa-image"></i>
                </div>

            @endif

            {{-- ========================= --}}
            {{-- CONTENT --}}
            {{-- ========================= --}}
            <div class="gallery-content">

{{-- Kategori --}}
                @if($item->kategori)
                    <span class="gallery-category {{ $item->kategori }}">
                        {{ $item->kategori }}
                    </span>
                @endif

                <div class="gallery-title">
                    {{ $item->judul_foto }}
                </div>

                {{-- Deskripsi --}}
                @if($item->deskripsi)
                    <div class="gallery-description">
                        {{ $item->deskripsi }}
                    </div>
                @endif

                @if($item->tanggal_kegiatan)
                    <div class="gallery-subtitle">
                        <i class="far fa-calendar-alt"></i>

                        {{ is_string($item->tanggal_kegiatan)
                            ? \Carbon\Carbon::parse($item->tanggal_kegiatan)->format('d M Y')
                            : $item->tanggal_kegiatan->format('d M Y')
                        }}
                    </div>
                @endif

            </div>

        </div>

    @empty

        <div class="gallery-card">

            <div class="gallery-img-placeholder">
                <i class="far fa-image"></i>
            </div>

            <div class="gallery-content">
                <div class="gallery-title">
                    Belum ada kegiatan
                </div>

                <div class="gallery-subtitle">
                    Kegiatan akan segera ditampilkan
                </div>
            </div>

        </div>

@endforelse
</div>

{{-- GLOBAL MODAL FOR GALLERY VIEWER --}}
<div class="modal fade gallery-viewer-modal" id="galleryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" style="max-width: 1100px;">
        <div class="modal-content">
            <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3" style="z-index: 20;" data-bs-dismiss="modal"></button>
            <div class="gallery-viewer-stage" id="galleryModalStage" style="min-height: 70vh; background: #020617; display: flex; align-items: center; justify-content: center;">
                <div class="gallery-zoom-toolbar" aria-label="Kontrol zoom foto">
                    <button type="button" class="gallery-zoom-btn" onclick="changeGalleryZoom(-0.25)" aria-label="Perkecil foto">
                        <i class="fas fa-minus"></i>
                    </button>
                    <span class="gallery-zoom-level" id="galleryZoomLevel">100%</span>
                    <button type="button" class="gallery-zoom-btn" onclick="changeGalleryZoom(0.25)" aria-label="Perbesar foto">
                        <i class="fas fa-plus"></i>
                    </button>
                    <button type="button" class="gallery-zoom-btn" onclick="resetGalleryZoom()" aria-label="Reset zoom foto">
                        <i class="fas fa-compress-arrows-alt"></i>
                    </button>
                </div>
                <img id="galleryModalImage" src="" alt="Foto" style="max-width: 100%; max-height: 72vh; object-fit: contain;">
                <button type="button" class="gallery-viewer-nav gallery-viewer-prev" onclick="moveModalSlide(-1)" style="position: absolute; top: 50%; transform: translateY(-50%); width: 42px; height: 42px; border: 0; border-radius: 50%; background: rgba(255,255,255,0.14); color: white; display: flex; align-items: center; justify-content: center; font-size: 22px; cursor: pointer; left: 16px;">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button type="button" class="gallery-viewer-nav gallery-viewer-next" onclick="moveModalSlide(1)" style="position: absolute; top: 50%; transform: translateY(-50%); width: 42px; height: 42px; border: 0; border-radius: 50%; background: rgba(255,255,255,0.14); color: white; display: flex; align-items: center; justify-content: center; font-size: 22px; cursor: pointer; right: 16px;">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
            <div class="gallery-viewer-info">
                <div class="gallery-viewer-heading">
                    <div>
                        <div class="gallery-viewer-eyebrow">Dokumentasi Kegiatan</div>
                        <h3 class="gallery-viewer-title" id="galleryModalTitle"></h3>
                    </div>
                    <div class="gallery-viewer-counter" id="galleryModalCounter">1 / 1</div>
                </div>
                <div class="gallery-viewer-meta" id="galleryModalMeta"></div>
                <p class="gallery-viewer-description" id="galleryModalDescription"></p>
            </div>
            <div class="gallery-viewer-thumbs" id="galleryModalThumbs" style="background: #0f172a; display: flex; gap: 8px; overflow-x: auto; padding: 12px 18px 18px;"></div>
        </div>
    </div>
</div>

<script>
let galleryModalPhotos = [];
let galleryModalIndex = 0;
let galleryModal = null;
let galleryZoom = 1;
let galleryPanX = 0;
let galleryPanY = 0;
let galleryIsDragging = false;
let galleryDragStartX = 0;
let galleryDragStartY = 0;
let galleryDragOriginX = 0;
let galleryDragOriginY = 0;

function getGalleryZoomElements() {
    return {
        stage: document.getElementById('galleryModalStage'),
        image: document.getElementById('galleryModalImage'),
        level: document.getElementById('galleryZoomLevel')
    };
}

function applyGalleryZoom() {
    const { stage, image, level } = getGalleryZoomElements();
    if (!stage || !image || !level) return;

    if (galleryZoom <= 1) {
        galleryPanX = 0;
        galleryPanY = 0;
    }

    image.style.transform = 'translate(' + galleryPanX + 'px, ' + galleryPanY + 'px) scale(' + galleryZoom + ')';
    level.textContent = Math.round(galleryZoom * 100) + '%';
    stage.classList.toggle('is-zoomed', galleryZoom > 1);
}

function changeGalleryZoom(amount) {
    galleryZoom = Math.min(3, Math.max(1, galleryZoom + amount));
    applyGalleryZoom();
}

function resetGalleryZoom() {
    galleryZoom = 1;
    galleryPanX = 0;
    galleryPanY = 0;
    applyGalleryZoom();
}

function openGalleryModal(id) {
    const photos = window['getGalleryPhotos' + id]();
    if (!photos || !photos.length) return;
    
    galleryModalPhotos = photos;
    galleryModalIndex = window['carouselState' + id] ? window['carouselState' + id].current : 0;
    
    renderGalleryModal();
    
    if (!galleryModal) {
        galleryModal = new bootstrap.Modal(document.getElementById('galleryModal'));
    }
    galleryModal.show();
}

function renderGalleryModal() {
    const photo = galleryModalPhotos[galleryModalIndex];
    if (!photo) return;

    resetGalleryZoom();
    
    document.getElementById('galleryModalImage').src = photo.src;
    document.getElementById('galleryModalImage').alt = photo.alt || 'Foto';
    document.getElementById('galleryModalTitle').textContent = photo.title || photo.alt || 'Tanpa Judul';
    document.getElementById('galleryModalCounter').textContent = (galleryModalIndex + 1) + ' / ' + galleryModalPhotos.length;

    const meta = document.getElementById('galleryModalMeta');
    meta.innerHTML = '';

    [
        { icon: 'fas fa-tag', text: photo.category },
        { icon: 'far fa-calendar-alt', text: photo.date }
    ].filter(item => item.text).forEach(item => {
        const badge = document.createElement('span');
        badge.className = 'gallery-viewer-badge';

        const icon = document.createElement('i');
        icon.className = item.icon;

        const text = document.createElement('span');
        text.textContent = item.text;

        badge.appendChild(icon);
        badge.appendChild(text);
        meta.appendChild(badge);
    });

    const description = document.getElementById('galleryModalDescription');
    description.textContent = photo.description || 'Belum terdapat keterangan tambahan untuk foto kegiatan ini.';
    
    // Update nav buttons visibility
    const navButtons = document.querySelectorAll('#galleryModal .gallery-viewer-nav');
    navButtons.forEach(btn => {
        btn.style.display = galleryModalPhotos.length > 1 ? 'flex' : 'none';
    });

    const thumbs = document.getElementById('galleryModalThumbs');
    thumbs.innerHTML = '';
    galleryModalPhotos.forEach((item, index) => {
        const button = document.createElement('button');
        button.type = 'button';
        button.className = 'gallery-viewer-thumb' + (index === galleryModalIndex ? ' active' : '');
        button.onclick = function() {
            galleryModalIndex = index;
            renderGalleryModal();
        };

        const image = document.createElement('img');
        image.src = item.src;
        image.alt = item.title || item.alt || 'Thumbnail';
        button.appendChild(image);
        thumbs.appendChild(button);
    });
}

function moveModalSlide(direction) {
    if (!galleryModalPhotos.length) return;
    galleryModalIndex = (galleryModalIndex + direction + galleryModalPhotos.length) % galleryModalPhotos.length;
    renderGalleryModal();
}

document.addEventListener('DOMContentLoaded', function() {
    const { stage } = getGalleryZoomElements();
    if (!stage) return;

    stage.addEventListener('click', function(event) {
        if (event.target.closest('button')) return;
        if (galleryZoom === 1) {
            changeGalleryZoom(0.5);
        }
    });

    stage.addEventListener('wheel', function(event) {
        event.preventDefault();
        changeGalleryZoom(event.deltaY < 0 ? 0.25 : -0.25);
    }, { passive: false });

    stage.addEventListener('pointerdown', function(event) {
        if (galleryZoom <= 1 || event.target.closest('button')) return;
        galleryIsDragging = true;
        galleryDragStartX = event.clientX;
        galleryDragStartY = event.clientY;
        galleryDragOriginX = galleryPanX;
        galleryDragOriginY = galleryPanY;
        stage.classList.add('is-dragging');
        stage.setPointerCapture(event.pointerId);
    });

    stage.addEventListener('pointermove', function(event) {
        if (!galleryIsDragging) return;
        galleryPanX = galleryDragOriginX + (event.clientX - galleryDragStartX);
        galleryPanY = galleryDragOriginY + (event.clientY - galleryDragStartY);
        applyGalleryZoom();
    });

    function stopGalleryDrag(event) {
        if (!galleryIsDragging) return;
        galleryIsDragging = false;
        stage.classList.remove('is-dragging');
        if (event && stage.hasPointerCapture(event.pointerId)) {
            stage.releasePointerCapture(event.pointerId);
        }
    }

    stage.addEventListener('pointerup', stopGalleryDrag);
    stage.addEventListener('pointercancel', stopGalleryDrag);
    stage.addEventListener('pointerleave', stopGalleryDrag);
});
</script>
