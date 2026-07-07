@extends('layouts.admin')

@section('title', 'Prestasi - Admin Kelurahan Gunung Sugih')
@section('page-title', 'Manajemen Prestasi')

@section('content')
<style>
    :root {
        --primary-orange: #ff5421;
        --bg-color: #f8f9fa;
        --text-dark: #333;
        --text-light: #666;
        --card-shadow: 0 4px 20px rgba(0,0,0,0.05);
        --radius: 12px;
        --border-color: #ddd;
    }

    .main-content {
        background-color: var(--bg-color);
        padding: 20px;
    }

    * { box-sizing: border-box; margin: 0; padding: 0; }

    .container { max-width: 1200px; margin: 0 auto; }

    /* --- Header Section --- */
    .page-header {
        background: white;
        padding: 25px 30px;
        border-radius: var(--radius);
        box-shadow: var(--card-shadow);
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        flex-wrap: wrap;
        gap: 15px;
    }

    .header-content h1 { font-size: 20px; font-weight: 600; margin-bottom: 5px; }
    .header-content p { color: var(--text-light); font-size: 14px; }

    .btn-add {
        background-color: var(--primary-orange);
        color: white;
        border: none;
        padding: 12px 20px;
        border-radius: 8px;
        font-weight: 500;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
        transition: 0.3s;
    }
    .btn-add:hover { opacity: 0.9; }

    /* --- Stats Grid --- */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }
    .stat-card {
        padding: 20px;
        border-radius: var(--radius);
        display: flex;
        align-items: center;
        gap: 20px;
    }
    .stat-card.orange { background-color: #fff8e1; }
    .stat-card.yellow { background-color: #fffae5; }
    .stat-card.pink { background-color: #fff5f5; }

    .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        color: white;
    }
    .bg-icon-orange { background-color: #ff5722; }
    .bg-icon-yellow { background-color: #fbc02d; }
    .bg-icon-red { background-color: #f44336; }

    .stat-info p { font-size: 13px; color: #555; margin-bottom: 2px; }
    .stat-info h3 { font-size: 24px; font-weight: 600; }

    /* --- Achievements Grid --- */
    .achievements-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 20px;
    }
    @media (max-width: 1100px) { .achievements-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
    @media (max-width: 768px) { .achievements-grid { grid-template-columns: 1fr; } }

    .card {
        background: white;
        padding: 25px;
        border-radius: var(--radius);
        box-shadow: var(--card-shadow);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .card-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 10px; }
    .card-title-group { display: flex; gap: 12px; }
    .card-icon { color: var(--primary-orange); font-size: 18px; margin-top: 3px; }
    .card-title h4 { font-size: 16px; font-weight: 600; margin-bottom: 5px; line-height: 1.4; }
    .card-location { color: var(--primary-orange); font-size: 12px; font-weight: 500; }
    .badge { padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 600; height: fit-content; }
    .badge-green { background-color: #e0f2f1; color: #009688; }
    .badge-pink { background-color: #ffebee; color: #e91e63; }
    .badge-blue { background-color: #e3f2fd; color: #2196f3; }
    .card-desc { font-size: 13px; color: #666; margin-top: 10px; margin-bottom: 15px; line-height: 1.6; }
    .card-meta { display: flex; align-items: center; gap: 15px; font-size: 13px; color: #888; margin-bottom: 20px; }
    .card-meta span { display: flex; align-items: center; gap: 6px; }
    .card-actions { display: flex; gap: 15px; margin-top: auto; }
    .achievement-carousel-wrap {
        background: #fff;
        border-radius: 10px;
        overflow: hidden;
        margin: 14px 0 16px;
        cursor: zoom-in;
        border: 1px solid #f1f1f1;
    }
    .achievement-carousel {
        position: relative;
        width: 100%;
        aspect-ratio: 16 / 10;
        overflow: hidden;
        background: #f3f4f6;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .achievement-carousel::after {
        content: "";
        position: absolute;
        inset: auto 0 0 0;
        height: 45%;
        background: linear-gradient(180deg, rgba(15, 23, 42, 0) 0%, rgba(15, 23, 42, 0.48) 100%);
        pointer-events: none;
        z-index: 2;
    }
    .achievement-carousel-track {
        position: absolute;
        inset: 0;
    }
    .achievement-carousel-slide {
        position: absolute;
        inset: 0;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.25s ease;
    }
    .achievement-carousel-slide.active {
        opacity: 1;
        pointer-events: auto;
    }
    .achievement-carousel-slide img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        cursor: zoom-in;
        transition: transform 0.35s ease;
    }
    .achievement-carousel-wrap:hover .achievement-carousel-slide.active img {
        transform: scale(1.035);
    }
    .achievement-carousel-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 36px;
        height: 36px;
        border: none;
        border-radius: 50%;
        background: rgba(15, 23, 42, 0.62);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-shadow: none;
        transition: background 0.2s ease, transform 0.2s ease;
        z-index: 6;
    }
    .achievement-carousel-btn:hover {
        background: rgba(15, 23, 42, 0.86);
        transform: translateY(-50%) scale(1.04);
    }
    .achievement-carousel-btn i { font-size: 18px; }
    .achievement-carousel-btn.prev { left: 12px; }
    .achievement-carousel-btn.next { right: 12px; }
    .achievement-photo-count {
        position: absolute;
        top: 12px;
        left: 12px;
        z-index: 6;
        padding: 5px 10px;
        border-radius: 999px;
        background: rgba(15, 23, 42, 0.72);
        color: white;
        font-size: 12px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
    }
    .achievement-expand-btn {
        position: absolute;
        right: 12px;
        bottom: 12px;
        width: 34px;
        height: 34px;
        border-radius: 50%;
        background: rgba(15, 23, 42, 0.72);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        z-index: 6;
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        pointer-events: none;
    }
    .achievement-carousel-dots {
        position: absolute;
        left: 0;
        right: 0;
        bottom: 12px;
        display: flex;
        justify-content: center;
        gap: 7px;
        z-index: 5;
    }
    .achievement-carousel-dot {
        width: 8px;
        height: 8px;
        border: none;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.62);
        box-shadow: 0 1px 4px rgba(15, 23, 42, 0.2);
        cursor: pointer;
        padding: 0;
        transition: width 0.2s ease, background 0.2s ease;
    }
    .achievement-carousel-dot:hover { background: rgba(255, 255, 255, 0.86); }
    .achievement-carousel-dot.active {
        background: #fff;
        width: 22px;
        border-radius: 999px;
    }
    .achievement-carousel-thumbs {
        display: flex;
        gap: 6px;
        overflow-x: auto;
        overflow-y: hidden;
        padding: 10px 14px 12px;
        background: #fff;
        scrollbar-width: thin;
    }
    .achievement-carousel-thumb {
        width: 54px;
        height: 42px;
        flex-shrink: 0;
        display: block;
        border-radius: 6px;
        object-fit: cover;
        border: 2px solid transparent;
        cursor: pointer;
        opacity: 0.66;
        transition: opacity 0.2s ease, border-color 0.2s ease, transform 0.2s ease;
    }
    .achievement-carousel-thumb:hover { opacity: 0.9; }
    .achievement-carousel-thumb.active {
        border-color: #f97316;
        opacity: 1;
        transform: translateY(-1px);
    }
    .photo-viewer-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.82);
        z-index: 10001;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 72px 24px 28px;
    }
    .photo-viewer-overlay.active { display: flex; }
    .photo-viewer-stage {
        width: 100%;
        height: 100%;
        overflow: auto;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .photo-viewer-stage img {
        max-width: 90vw;
        max-height: 82vh;
        object-fit: contain;
        border-radius: 10px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.35);
        transition: transform 0.2s ease;
        transform-origin: center center;
    }
    .photo-viewer-toolbar {
        position: absolute;
        top: 18px;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 8px;
        border-radius: 12px;
        background: rgba(255,255,255,0.12);
        backdrop-filter: blur(10px);
    }
    .photo-viewer-btn {
        width: 38px;
        height: 38px;
        border: none;
        border-radius: 8px;
        background: rgba(255,255,255,0.92);
        color: #1f2937;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: 0.2s;
    }
    .photo-viewer-btn:hover { background: #fff3e0; color: #e65100; }
    .photo-viewer-nav {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 46px;
        height: 46px;
        border: none;
        border-radius: 50%;
        background: rgba(255,255,255,0.92);
        color: #1f2937;
        cursor: pointer;
        display: none;
        align-items: center;
        justify-content: center;
        box-shadow: 0 12px 30px rgba(0,0,0,0.25);
        transition: 0.2s;
        z-index: 2;
    }
    .photo-viewer-nav:hover { background: #fff3e0; color: #e65100; }
    .photo-viewer-nav.prev { left: 28px; }
    .photo-viewer-nav.next { right: 28px; }
    .photo-viewer-overlay.has-multiple .photo-viewer-nav { display: flex; }
    .photo-viewer-zoom {
        min-width: 58px;
        color: white;
        font-size: 13px;
        font-weight: 600;
        text-align: center;
    }
    .btn-action {
        flex: 1;
        padding: 10px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 500;
        font-size: 14px;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 8px;
        transition: 0.2s;
    }
    .btn-edit { background-color: #fff3e0; color: #e65100; }
    .btn-delete { background-color: #ffebee; color: #c62828; }
    .btn-action:hover { filter: brightness(0.95); }

    /* ========================================= */
    /* MODAL STYLES (NEW) */
    /* ========================================= */
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 1000;
        padding: 20px;
    }

    .modal-content {
        background-color: white;
        padding: 30px;
        border-radius: var(--radius);
        width: 100%;
        max-width: 600px;
        max-height: 90vh;
        overflow-y: auto;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        position: relative;
        animation: slideDown 0.3s ease-out;
    }

    @keyframes slideDown {
        from { transform: translateY(-30px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }

    .modal-header { margin-bottom: 25px; }
    .modal-header h2 { font-size: 20px; font-weight: 600; color: var(--text-dark); }

    .form-group { margin-bottom: 15px; }
    .form-row { display: flex; gap: 20px; }
    .form-col { flex: 1; }

    .form-label {
        display: block;
        font-size: 13px;
        color: #555;
        margin-bottom: 8px;
        font-weight: 500;
    }

    .form-control {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid var(--border-color);
        border-radius: 6px;
        font-family: 'Poppins', sans-serif;
        font-size: 14px;
        color: #333;
        outline: none;
        transition: border-color 0.2s;
    }

    .form-control:focus {
        border-color: var(--primary-orange);
    }

    textarea.form-control {
        resize: vertical;
        height: 80px;
    }

    .photo-upload-list {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
        gap: 10px;
        margin-top: 10px;
    }
    .photo-upload-item {
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 8px;
        background: #fff;
        cursor: grab;
        user-select: none;
    }
    .photo-upload-item.dragging {
        opacity: 0.45;
        border-style: dashed;
    }
    .photo-upload-item img {
        width: 100%;
        height: 86px;
        object-fit: cover;
        border-radius: 6px;
        margin-bottom: 6px;
    }
    .photo-upload-label {
        font-size: 11px;
        color: #666;
        display: flex;
        justify-content: space-between;
        gap: 6px;
    }
    .photo-upload-empty {
        color: #888;
        border: 1px dashed #ddd;
        border-radius: 8px;
        padding: 14px;
        text-align: center;
        font-size: 13px;
    }

    .modal-footer {
        margin-top: 30px;
        display: flex;
        gap: 15px;
    }

    .btn-modal {
        flex: 1;
        padding: 12px;
        border: none;
        border-radius: 8px;
        font-weight: 500;
        font-size: 14px;
        cursor: pointer;
        transition: 0.2s;
    }

    .btn-save { background-color: var(--primary-orange); color: white; }
    .btn-save:hover { background-color: #e64a1c; }

    .btn-cancel { background-color: #e9ecef; color: #495057; }
    .btn-cancel:hover { background-color: #dee2e6; }

    /* Responsive Modal */
    @media (max-width: 600px) {
        .form-row { flex-direction: column; gap: 15px; }
    }
</style>

<div class="container">
    <div class="page-header">
        <div class="header-content">
            <h1>Manajemen Prestasi</h1>
            <p>Kelola data prestasi dan penghargaan Kelurahan Gunung Sugih</p>
        </div>
        @if($prestasi->count() > 0)
            <button class="btn-add" id="openModalBtn">
                <i class="fa-solid fa-plus"></i> Tambah Prestasi
            </button>
        @endif
    </div>

    <div class="stats-grid">
        <div class="stat-card orange">
            <div class="stat-icon bg-icon-orange"><i class="fa-solid fa-trophy"></i></div>
            <div class="stat-info"><p>Total Prestasi</p><h3>{{ count($prestasi) }}</h3></div>
        </div>
        <div class="stat-card yellow">
            <div class="stat-icon bg-icon-yellow"><i class="fa-solid fa-medal"></i></div>
            <div class="stat-info"><p>Tahun Ini</p><h3>{{ collect($prestasi)->where('tahun', date('Y'))->count() }}</h3></div>
        </div>
        <div class="stat-card pink">
            <div class="stat-icon bg-icon-red"><i class="fa-solid fa-award"></i></div>
            <div class="stat-info"><p>Kategori</p><h3>{{ collect($prestasi)->pluck('tingkat')->unique()->count() }}</h3></div>
        </div>
    </div>

    <div class="achievements-grid">
        @forelse($prestasi as $item)
        <div class="card">
            <div>
                <div class="card-header">
                    <div class="card-title-group">
                        <i class="fa-solid fa-trophy card-icon"></i>
                        <div class="card-title">
                            <h4>{{ $item['judul'] }}</h4>
                            <span class="card-location">{{ $item['tingkat'] }}</span>
                        </div>
                    </div>
                    <span class="badge badge-green">{{ $item['peringkat'] }}</span>
                </div>
                <p class="card-desc">{{ $item['deskripsi'] }}</p>
                @if($item->fotos->count() > 0)
                <div class="achievement-carousel-wrap">
                    <div class="achievement-carousel" data-carousel data-current-index="0">
                        <div class="achievement-carousel-track">
                            @foreach($item->fotos as $index => $foto)
                            <div class="achievement-carousel-slide {{ $index === 0 ? 'active' : '' }}" data-slide-index="{{ $index }}">
                                <img src="{{ asset('storage/' . $foto->foto) }}" alt="{{ $item['judul'] }}">
                            </div>
                            @endforeach
                        </div>
                        @if($item->fotos->count() > 1)
                        <div class="achievement-photo-count">
                            <i class="fa-regular fa-images"></i>
                            <span>{{ $item->fotos->count() }} foto</span>
                        </div>
                        <button type="button" class="achievement-carousel-btn prev" data-carousel-prev aria-label="Foto sebelumnya">
                            <i class="fa-solid fa-chevron-left"></i>
                        </button>
                        <button type="button" class="achievement-carousel-btn next" data-carousel-next aria-label="Foto berikutnya">
                            <i class="fa-solid fa-chevron-right"></i>
                        </button>
                        <div class="achievement-carousel-dots">
                            @foreach($item->fotos as $index => $foto)
                            <button type="button" class="achievement-carousel-dot {{ $index === 0 ? 'active' : '' }}" data-carousel-dot="{{ $index }}" aria-label="Lihat foto {{ $index + 1 }}"></button>
                            @endforeach
                        </div>
                        @endif
                        <div class="achievement-expand-btn">
                            <i class="fa-solid fa-up-right-and-down-left-from-center"></i>
                        </div>
                    </div>
                    @if($item->fotos->count() > 1)
                    <div class="achievement-carousel-thumbs">
                        @foreach($item->fotos as $index => $foto)
                        <img src="{{ asset('storage/' . $foto->foto) }}"
                             alt="Thumbnail {{ $index + 1 }}"
                             class="achievement-carousel-thumb {{ $index === 0 ? 'active' : '' }}"
                             data-carousel-thumb="{{ $index }}">
                        @endforeach
                    </div>
                    @endif
                </div>
                @endif
                <div class="card-meta">
                    <span><i class="fa-regular fa-calendar"></i> {{ $item['tahun'] }}</span>
                    <span>&bull;</span>
                    <span>{{ $item['tanggal']->format('d M Y') }}</span>
                </div>
            </div>
            <div class="card-actions">
                <button class="btn-action btn-edit" onclick="openEditModal({{ $item['id'] }}, @js($item['judul']), @js($item['peringkat']), @js($item['tingkat']), @js($item['penyelenggara'] ?? ''), @js($item['tahun']), @js($item['deskripsi']), @js($item['tanggal']->format('Y-m-d')))">
                    <i class="fa-regular fa-pen-to-square"></i> Edit
                </button>
                <form action="{{ route('admin.prestasi.destroy', $item['id']) }}" method="POST" id="deletePrestasiForm{{ $item['id'] }}" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn-action btn-delete" onclick="showDeleteConfirm({{ $item['id'] }}, @js($item['judul']))">
                        <i class="fa-regular fa-trash-can"></i> Hapus
                    </button>
                </form>
            </div>
        </div>
        @empty
        <div class="card">
            <div class="text-center py-5">
                <i class="fa-solid fa-trophy fa-3x text-muted mb-3"></i>
                <h4 class="text-muted">Belum Ada Data Prestasi</h4>
                <p class="text-muted">Tambahkan prestasi pertama untuk memulai.</p>
                <button class="btn-add" id="openModalBtn">
                    <i class="fa-solid fa-plus"></i> Tambah Prestasi
                </button>
            </div>
        </div>
        @endforelse
    </div>
</div>

<!-- Modal Tambah Prestasi -->
<div class="modal-overlay" id="addModal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Tambah Prestasi Baru</h2>
        </div>
        <form action="{{ route('admin.prestasi.store') }}" method="POST" enctype="multipart/form-data" id="addForm">
            @csrf
            <div class="form-group">
                <label class="form-label">Judul Prestasi</label>
                <input type="text" name="judul" class="form-control" required>
            </div>

            <div class="form-row">
                <div class="form-col form-group">
                    <label class="form-label">Kategori</label>
                    <select name="peringkat" class="form-control" required>
                        <option value="">Pilih Kategori</option>
                        <option value="Juara 1">Juara 1</option>
                        <option value="Juara 2">Juara 2</option>
                        <option value="Juara 3">Juara 3</option>
                        <option value="Penghargaan">Penghargaan</option>
                        <option value="Terbaik">Terbaik</option>
                    </select>
                </div>
                <div class="form-col form-group">
                    <label class="form-label">Tingkat</label>
                    <select name="tingkat" class="form-control" required>
                        <option value="">Pilih Tingkat</option>
                        <option value="Kota Cilegon">Kota Cilegon</option>
                        <option value="Provinsi Banten">Provinsi Banten</option>
                        <option value="Nasional">Nasional</option>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-col form-group">
                    <label class="form-label">Penyelenggara</label>
                    <input type="text" name="penyelenggara" class="form-control">
                </div>
                <div class="form-col form-group">
                    <label class="form-label">Tahun</label>
                    <input type="text" name="tahun" class="form-control" value="{{ date('Y') }}" required>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Deskripsi</label>
                <textarea name="deskripsi" class="form-control" rows="4" required></textarea>
            </div>

            <div class="form-group">
                <label class="form-label">Tanggal</label>
                <input type="date" name="tanggal" class="form-control" required>
            </div>

            <div class="form-group">
                <label class="form-label">Foto Prestasi</label>
                <input type="file" name="fotos[]" id="addFotos" class="form-control" accept="image/*" multiple>
                <div class="photo-upload-list" id="addPhotoList"></div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn-modal btn-save">Simpan</button>
                <button type="button" class="btn-modal btn-cancel" id="closeModalBtn">Batal</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Prestasi -->
<div class="modal-overlay" id="editModal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Edit Prestasi</h2>
        </div>
        <form id="editForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" id="editId">
            
            <div class="form-group">
                <label class="form-label">Judul Prestasi</label>
                <input type="text" name="judul" id="editJudul" class="form-control" required>
            </div>

            <div class="form-row">
                <div class="form-col form-group">
                    <label class="form-label">Kategori</label>
                    <select name="peringkat" id="editPeringkat" class="form-control" required>
                        <option value="">Pilih Kategori</option>
                        <option value="Juara 1">Juara 1</option>
                        <option value="Juara 2">Juara 2</option>
                        <option value="Juara 3">Juara 3</option>
                        <option value="Penghargaan">Penghargaan</option>
                        <option value="Terbaik">Terbaik</option>
                    </select>
                </div>
                <div class="form-col form-group">
                    <label class="form-label">Tingkat</label>
                    <select name="tingkat" id="editTingkat" class="form-control" required>
                        <option value="">Pilih Tingkat</option>
                        <option value="Kota Cilegon">Kota Cilegon</option>
                        <option value="Provinsi Banten">Provinsi Banten</option>
                        <option value="Nasional">Nasional</option>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-col form-group">
                    <label class="form-label">Penyelenggara</label>
                    <input type="text" name="penyelenggara" id="editPenyelenggara" class="form-control">
                </div>
                <div class="form-col form-group">
                    <label class="form-label">Tahun</label>
                    <input type="text" name="tahun" id="editTahun" class="form-control" required>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Deskripsi</label>
                <textarea name="deskripsi" id="editDeskripsi" class="form-control" rows="4" required></textarea>
            </div>

            <div class="form-group">
                <label class="form-label">Tanggal</label>
                <input type="date" name="tanggal" id="editTanggal" class="form-control" required>
            </div>

            <div class="form-group">
                <label class="form-label">Foto Saat Ini</label>
                <input type="hidden" name="existing_photo_order" id="editExistingPhotoOrder" value="[]">
                <div class="photo-upload-list" id="editExistingPhotoList"></div>
            </div>

            <div class="form-group">
                <label class="form-label">Tambah Foto Baru</label>
                <input type="file" name="new_fotos[]" id="editNewFotos" class="form-control" accept="image/*" multiple>
                <div class="photo-upload-list" id="editNewPhotoList"></div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn-modal btn-save">Update</button>
                <button type="button" class="btn-modal btn-cancel" id="closeEditModalBtn">Batal</button>
            </div>
        </form>
    </div>
</div>

<div class="photo-viewer-overlay" id="photoViewer" aria-hidden="true">
    <div class="photo-viewer-toolbar">
        <button type="button" class="photo-viewer-btn" id="photoZoomOutBtn" aria-label="Zoom out">
            <i class="fa-solid fa-minus"></i>
        </button>
        <span class="photo-viewer-zoom" id="photoZoomLabel">100%</span>
        <button type="button" class="photo-viewer-btn" id="photoZoomInBtn" aria-label="Zoom in">
            <i class="fa-solid fa-plus"></i>
        </button>
    </div>
    <div class="photo-viewer-stage">
        <img src="" alt="" id="photoViewerImage">
    </div>
    <button type="button" class="photo-viewer-nav prev" id="photoViewerPrevBtn" aria-label="Foto sebelumnya">
        <i class="fa-solid fa-chevron-left"></i>
    </button>
    <button type="button" class="photo-viewer-nav next" id="photoViewerNextBtn" aria-label="Foto berikutnya">
        <i class="fa-solid fa-chevron-right"></i>
    </button>
</div>

<script>
    const prestasiFlash = {
        success: @json(session('success')),
        error: @json(session('error') ?: ($errors->any() ? $errors->first() : null)),
    };

    const prestasiExistingPhotos = {
        @foreach($prestasi as $item)
            {{ $item->id }}: @json($item->fotos->map(fn($foto) => [
                'id' => $foto->id,
                'src' => asset('storage/' . $foto->foto),
            ])->values()),
        @endforeach
    };

    let addPhotoFiles = [];
    let editNewPhotoFiles = [];
    let editExistingPhotos = [];
    let draggedPhotoItem = null;

    // Modal Tambah
    const modal = document.getElementById('addModal');
    const openBtn = document.getElementById('openModalBtn');
    const closeBtn = document.getElementById('closeModalBtn');

    // Modal Edit
    const editModal = document.getElementById('editModal');
    const closeEditBtn = document.getElementById('closeEditModalBtn');
    const photoViewer = document.getElementById('photoViewer');
    const photoViewerImage = document.getElementById('photoViewerImage');
    const photoZoomLabel = document.getElementById('photoZoomLabel');
    let photoZoom = 1;
    let viewerPhotos = [];
    let viewerPhotoIndex = 0;

    function showNotification(message, type = 'success') {
        if (!message) return;

        document.querySelectorAll('.custom-notification').forEach(notification => notification.remove());

        const notification = document.createElement('div');
        const config = {
            success: { icon: 'bx-check-circle', bg: 'linear-gradient(135deg, #10b981, #059669)', color: '#fff' },
            error: { icon: 'bx-x-circle', bg: 'linear-gradient(135deg, #ef4444, #dc2626)', color: '#fff' },
            warning: { icon: 'bx-exclamation-circle', bg: 'linear-gradient(135deg, #f59e0b, #d97706)', color: '#fff' },
            info: { icon: 'bx-info-circle', bg: 'linear-gradient(135deg, #3b82f6, #2563eb)', color: '#fff' },
        };
        const c = config[type] || config.success;

        notification.className = 'custom-notification';
        notification.style.cssText = `
            position: fixed; top: 20px; right: 20px;
            background: ${c.bg}; color: ${c.color};
            padding: 16px 24px; border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2); z-index: 10000;
            font-family: 'Poppins', sans-serif; font-size: 14px;
            display: flex; align-items: center; gap: 12px;
            animation: slideInRight 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            min-width: 280px; max-width: 400px;
        `;
        notification.innerHTML = `
            <i class="bx ${c.icon}" style="font-size: 24px;"></i>
            <span style="font-weight: 500;">${message}</span>
        `;

        ensurePopupKeyframes();
        document.body.appendChild(notification);

        setTimeout(() => {
            notification.style.transform = 'translateX(120%)';
            notification.style.opacity = '0';
            notification.style.transition = 'all 0.4s ease';
            setTimeout(() => notification.remove(), 400);
        }, 3500);
    }

    function ensurePopupKeyframes() {
        if (document.getElementById('prestasi-popup-keyframes')) return;

        const style = document.createElement('style');
        style.id = 'prestasi-popup-keyframes';
        style.textContent = `
            @keyframes slideInRight {
                from { transform: translateX(120%); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
            @keyframes fadeIn {
                from { opacity: 0; }
                to { opacity: 1; }
            }
            @keyframes scaleIn {
                from { transform: scale(0.9); opacity: 0; }
                to { transform: scale(1); opacity: 1; }
            }
        `;
        document.head.appendChild(style);
    }

    function showDeleteConfirm(id, judul) {
        const existingModal = document.getElementById('delete-confirm-modal');
        if (existingModal) existingModal.remove();

        const modal = document.createElement('div');
        modal.id = 'delete-confirm-modal';
        modal.style.cssText = `
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.5); z-index: 9999;
            display: flex; align-items: center; justify-content: center;
            animation: fadeIn 0.3s ease;
        `;

        modal.innerHTML = `
            <div style="background: white; border-radius: 16px; padding: 30px; max-width: 400px; width: 90%;
                        box-shadow: 0 20px 60px rgba(0,0,0,0.3); animation: scaleIn 0.3s ease;">
                <div style="text-align: center; margin-bottom: 20px;">
                    <div style="width: 70px; height: 70px; border-radius: 50%; background: #fef2f2;
                                display: flex; align-items: center; justify-content: center; margin: 0 auto 15px;">
                        <i class="bx bx-trash" style="font-size: 36px; color: #ef4444;"></i>
                    </div>
                    <h3 style="margin: 0 0 8px; font-size: 20px; color: #1f2937;">Konfirmasi Hapus</h3>
                    <p style="margin: 0; color: #6b7280; font-size: 14px;">
                        Apakah Anda yakin ingin menghapus<br>
                        <strong style="color: #1f2937; font-size: 16px;">"${escapeHtml(judul)}"</strong>?
                    </p>
                </div>
                <div style="display: flex; gap: 12px; justify-content: center;">
                    <button type="button" onclick="closeDeleteModal()" style="flex: 1; padding: 12px 24px; border: none;
                                border-radius: 10px; background: #f3f4f6; color: #374151; font-weight: 500;
                                cursor: pointer; transition: all 0.2s;">Batal</button>
                    <button type="button" onclick="confirmDelete(${id})" style="flex: 1; padding: 12px 24px; border: none;
                                border-radius: 10px; background: #ef4444; color: white; font-weight: 500;
                                cursor: pointer; transition: all 0.2s;">Ya, Hapus</button>
                </div>
            </div>
        `;

        ensurePopupKeyframes();
        modal.onclick = function(e) {
            if (e.target === modal) closeDeleteModal();
        };
        document.body.appendChild(modal);
    }

    function closeDeleteModal() {
        const modal = document.getElementById('delete-confirm-modal');
        if (modal) {
            modal.style.opacity = '0';
            modal.style.transform = 'scale(0.9)';
            modal.style.transition = 'all 0.3s ease';
            setTimeout(() => modal.remove(), 300);
        }
    }

    function confirmDelete(id) {
        closeDeleteModal();
        showNotification('Menghapus prestasi...', 'info');
        document.getElementById(`deletePrestasiForm${id}`)?.submit();
    }

    function escapeHtml(value) {
        const div = document.createElement('div');
        div.textContent = value || '';
        return div.innerHTML;
    }

    function initializeAchievementCarousels() {
        document.querySelectorAll('[data-carousel]').forEach(carousel => {
            const track = carousel.querySelector('.achievement-carousel-track');
            const slides = carousel.querySelectorAll('.achievement-carousel-slide');
            const dots = carousel.querySelectorAll('[data-carousel-dot]');
            const thumbs = carousel.closest('.achievement-carousel-wrap')?.querySelectorAll('[data-carousel-thumb]') || [];
            const prevBtn = carousel.querySelector('[data-carousel-prev]');
            const nextBtn = carousel.querySelector('[data-carousel-next]');
            let currentIndex = 0;

            const carouselPhotos = Array.from(slides).map(slide => {
                const image = slide.querySelector('img');
                return {
                    src: image?.src || '',
                    alt: image?.alt || 'Foto prestasi',
                };
            }).filter(photo => photo.src);

            slides.forEach((slide, slideIndex) => {
                const image = slide.querySelector('img');
                image?.addEventListener('click', () => openPhotoViewer(carouselPhotos, slideIndex));
            });

            if (!track || slides.length <= 1) return;

            const goToSlide = index => {
                currentIndex = (index + slides.length) % slides.length;
                carousel.dataset.currentIndex = currentIndex;
                slides.forEach((slide, slideIndex) => {
                    slide.classList.toggle('active', slideIndex === currentIndex);
                });
                dots.forEach((dot, dotIndex) => {
                    dot.classList.toggle('active', dotIndex === currentIndex);
                });
                thumbs.forEach((thumb, thumbIndex) => {
                    thumb.classList.toggle('active', thumbIndex === currentIndex);
                });
            };

            prevBtn?.addEventListener('click', () => goToSlide(currentIndex - 1));
            nextBtn?.addEventListener('click', () => goToSlide(currentIndex + 1));
            dots.forEach(dot => {
                dot.addEventListener('click', () => goToSlide(Number(dot.dataset.carouselDot)));
            });
            thumbs.forEach(thumb => {
                thumb.addEventListener('click', event => {
                    event.stopPropagation();
                    goToSlide(Number(thumb.dataset.carouselThumb));
                });
            });
        });
    }

    function openPhotoViewer(photos, index = 0) {
        viewerPhotos = Array.isArray(photos) ? photos : [];
        viewerPhotoIndex = index;
        photoViewer.classList.toggle('has-multiple', viewerPhotos.length > 1);
        showViewerPhoto(viewerPhotoIndex);
        photoViewer.classList.add('active');
        photoViewer.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
    }

    function showViewerPhoto(index) {
        if (viewerPhotos.length === 0) return;

        viewerPhotoIndex = (index + viewerPhotos.length) % viewerPhotos.length;
        const photo = viewerPhotos[viewerPhotoIndex];
        photoZoom = 1;
        photoViewerImage.src = photo.src;
        photoViewerImage.alt = photo.alt || 'Foto prestasi';
        updatePhotoZoom();
    }

    function showNextViewerPhoto() {
        showViewerPhoto(viewerPhotoIndex + 1);
    }

    function showPrevViewerPhoto() {
        showViewerPhoto(viewerPhotoIndex - 1);
    }

    function closePhotoViewer() {
        photoViewer.classList.remove('active');
        photoViewer.classList.remove('has-multiple');
        photoViewer.setAttribute('aria-hidden', 'true');
        photoViewerImage.src = '';
        viewerPhotos = [];
        viewerPhotoIndex = 0;
        document.body.style.overflow = '';
    }

    function updatePhotoZoom() {
        photoViewerImage.style.transform = `scale(${photoZoom})`;
        photoZoomLabel.textContent = `${Math.round(photoZoom * 100)}%`;
    }

    function zoomPhoto(delta) {
        photoZoom = Math.min(4, Math.max(0.5, photoZoom + delta));
        updatePhotoZoom();
    }

    function uid(prefix = 'photo') {
        return `${prefix}_${Math.random().toString(36).slice(2, 10)}`;
    }

    function syncInputFiles(input, files) {
        const dataTransfer = new DataTransfer();
        files.forEach(item => dataTransfer.items.add(item.file));
        input.files = dataTransfer.files;
    }

    function wirePhotoDrag(container, onReorder) {
        container.querySelectorAll('.photo-upload-item').forEach(item => {
            item.draggable = true;
            item.ondragstart = () => {
                draggedPhotoItem = item;
                item.classList.add('dragging');
            };
            item.ondragend = () => {
                item.classList.remove('dragging');
                draggedPhotoItem = null;
                onReorder();
            };
            item.ondragover = (event) => {
                event.preventDefault();
                if (!draggedPhotoItem || draggedPhotoItem === item) return;

                const rect = item.getBoundingClientRect();
                const before = (event.clientY - rect.top) < rect.height / 2;
                item.parentNode.insertBefore(draggedPhotoItem, before ? item : item.nextSibling);
            };
        });
    }

    function renderNewPhotoList(listId, inputId, files, setFiles) {
        const list = document.getElementById(listId);
        const input = document.getElementById(inputId);

        if (files.length === 0) {
            list.innerHTML = '<div class="photo-upload-empty">Belum ada foto dipilih</div>';
            syncInputFiles(input, []);
            return;
        }

        list.innerHTML = '';
        files.forEach((item, index) => {
            const el = document.createElement('div');
            el.className = 'photo-upload-item';
            el.dataset.uid = item.uid;
            el.innerHTML = `
                <img src="${item.preview}" alt="${item.file.name}">
                <div class="photo-upload-label">
                    <span>Urutan #${index + 1}</span>
                    <span>${item.file.name}</span>
                </div>
            `;
            list.appendChild(el);
        });

        wirePhotoDrag(list, () => {
            const ordered = [];
            list.querySelectorAll('.photo-upload-item').forEach(item => {
                const found = files.find(file => file.uid === item.dataset.uid);
                if (found) ordered.push(found);
            });
            setFiles(ordered);
        });

        syncInputFiles(input, files);
    }

    function readPhotoInput(input, assignFiles, render) {
        const selected = Array.from(input.files).filter(file => file.type.startsWith('image/'));

        if (selected.length === 0) {
            assignFiles([]);
            render();
            return;
        }

        const nextFiles = [];
        let loaded = 0;
        selected.forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = event => {
                nextFiles[index] = {
                    uid: uid('new'),
                    file,
                    preview: event.target.result,
                };
                loaded++;
                if (loaded === selected.length) {
                    assignFiles(nextFiles.filter(Boolean));
                    render();
                }
            };
            reader.readAsDataURL(file);
        });
    }

    function renderAddPhotoList() {
        renderNewPhotoList('addPhotoList', 'addFotos', addPhotoFiles, files => {
            addPhotoFiles = files;
            renderAddPhotoList();
        });
    }

    function renderEditNewPhotoList() {
        renderNewPhotoList('editNewPhotoList', 'editNewFotos', editNewPhotoFiles, files => {
            editNewPhotoFiles = files;
            renderEditNewPhotoList();
        });
    }

    function renderEditExistingPhotoList() {
        const list = document.getElementById('editExistingPhotoList');
        const orderInput = document.getElementById('editExistingPhotoOrder');

        if (editExistingPhotos.length === 0) {
            list.innerHTML = '<div class="photo-upload-empty">Belum ada foto tersimpan</div>';
            orderInput.value = '[]';
            return;
        }

        list.innerHTML = '';
        editExistingPhotos.forEach((item, index) => {
            const el = document.createElement('div');
            el.className = 'photo-upload-item';
            el.dataset.id = item.id;
            el.innerHTML = `
                <img src="${item.src}" alt="Foto prestasi">
                <div class="photo-upload-label">
                    <span>Urutan #${index + 1}</span>
                    <span>Foto tersimpan</span>
                </div>
            `;
            list.appendChild(el);
        });

        orderInput.value = JSON.stringify(editExistingPhotos.map(item => item.id));

        wirePhotoDrag(list, () => {
            const ordered = [];
            list.querySelectorAll('.photo-upload-item').forEach(item => {
                const found = editExistingPhotos.find(photo => String(photo.id) === item.dataset.id);
                if (found) ordered.push(found);
            });
            editExistingPhotos = ordered;
            renderEditExistingPhotoList();
        });
    }

    document.getElementById('addFotos').addEventListener('change', function() {
        readPhotoInput(this, files => addPhotoFiles = files, renderAddPhotoList);
    });

    document.getElementById('editNewFotos').addEventListener('change', function() {
        readPhotoInput(this, files => editNewPhotoFiles = files, renderEditNewPhotoList);
    });

    document.getElementById('addForm').addEventListener('submit', function() {
        syncInputFiles(document.getElementById('addFotos'), addPhotoFiles);
        showNotification('Menyimpan prestasi...', 'info');
    });

    document.getElementById('editForm').addEventListener('submit', function() {
        syncInputFiles(document.getElementById('editNewFotos'), editNewPhotoFiles);
        document.getElementById('editExistingPhotoOrder').value = JSON.stringify(editExistingPhotos.map(item => item.id));
        showNotification('Memperbarui prestasi...', 'info');
    });

    // Fungsi Buka Modal Tambah
    openBtn.addEventListener('click', () => {
        addPhotoFiles = [];
        document.getElementById('addFotos').value = '';
        renderAddPhotoList();
        modal.style.display = 'flex';
    });

    // Fungsi Tutup Modal Tambah
    closeBtn.addEventListener('click', () => {
        modal.style.display = 'none';
    });

    // Fungsi Tutup Modal Edit
    closeEditBtn.addEventListener('click', () => {
        editModal.style.display = 'none';
    });

    document.getElementById('photoZoomOutBtn').addEventListener('click', () => zoomPhoto(-0.25));
    document.getElementById('photoZoomInBtn').addEventListener('click', () => zoomPhoto(0.25));
    document.getElementById('photoViewerPrevBtn').addEventListener('click', showPrevViewerPhoto);
    document.getElementById('photoViewerNextBtn').addEventListener('click', showNextViewerPhoto);

    // Fungsi Buka Modal Edit
    function openEditModal(id, judul, peringkat, tingkat, penyelenggara, tahun, deskripsi, tanggal) {
        document.getElementById('editId').value = id;
        document.getElementById('editJudul').value = judul;
        document.getElementById('editPeringkat').value = peringkat;
        document.getElementById('editTingkat').value = tingkat;
        document.getElementById('editPenyelenggara').value = penyelenggara;
        document.getElementById('editTahun').value = tahun;
        document.getElementById('editDeskripsi').value = deskripsi;
        document.getElementById('editTanggal').value = tanggal;
        editExistingPhotos = [...(prestasiExistingPhotos[id] || [])];
        editNewPhotoFiles = [];
        document.getElementById('editNewFotos').value = '';
        renderEditExistingPhotoList();
        renderEditNewPhotoList();
        
        // Set form action dengan route yang benar
        document.getElementById('editForm').action = '{{ route('admin.prestasi.update', ':id') }}'.replace(':id', id);
        
        editModal.style.display = 'flex';
    }

    // Tutup modal saat klik di luar
    window.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.style.display = 'none';
        }
        if (e.target === editModal) {
            editModal.style.display = 'none';
        }
        if (
            photoViewer.classList.contains('active') &&
            e.target.closest('#photoViewer') &&
            !e.target.closest('#photoViewerImage') &&
            !e.target.closest('.photo-viewer-toolbar') &&
            !e.target.closest('.photo-viewer-nav')
        ) {
            closePhotoViewer();
        }
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && photoViewer.classList.contains('active')) {
            closePhotoViewer();
        }
        if (e.key === 'ArrowLeft' && photoViewer.classList.contains('active') && viewerPhotos.length > 1) {
            showPrevViewerPhoto();
        }
        if (e.key === 'ArrowRight' && photoViewer.classList.contains('active') && viewerPhotos.length > 1) {
            showNextViewerPhoto();
        }
    });

    document.addEventListener('DOMContentLoaded', () => {
        initializeAchievementCarousels();

        if (prestasiFlash.success) {
            showNotification(prestasiFlash.success, 'success');
        }

        if (prestasiFlash.error) {
            showNotification(prestasiFlash.error, 'error');
        }
    });

    window.showDeleteConfirm = showDeleteConfirm;
    window.closeDeleteModal = closeDeleteModal;
    window.confirmDelete = confirmDelete;
</script>

@endsection
