@extends('layouts.admin')

@section('page-title', 'Berita & Informasi')

@section('content')
<div class="home-content">
<div class="news-toolbar">
        <div class="toolbar-container">
            <div class="search-box" style="width:100%;max-width:700px;display:flex;align-items:center;margin:0;padding:0 15px;">
                <i class='bx bx-search'></i>
                <input type="text" 
                       placeholder="Cari berita..." 
                       id="searchBerita" 
                       value="{{ $keyword ?? '' }}"
                       style="border:none;outline:none;padding-left:10px;font-size:14px;flex:1;height:45px;">
                <button type="button" id="btnClearSearch" class="btn-clear-search" title="Clear search" style="display:none;align-items:center;justify-content:center;width:30px;height:30px;border-radius:50%;background:#dc2626;color:#fff;border:none;margin-left:8px;cursor:pointer;">
                    <i class='bx bx-x'></i>
                </button>
            </div>
            <a href="#" class="btn-add-news" data-bs-toggle="modal" data-bs-target="#tambahBeritaModal">
                <i class='bx bx-plus'></i> Tambah Berita
            </a>
        </div>
    </div>

    <div class="content-card" id="beritaContent">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Validation Error:</strong><br>
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

@if($beritas->count() > 0)
            @if(isset($keyword) && $keyword !== '')
                <div class="search-result-info">
                    <p>Ditemukan {{ $beritas->total() }} berita untuk keyword "<strong>{{ $keyword }}</strong>"</p>
                </div>
            @endif
            @foreach($beritas as $berita)
                <div class="news-list-item" data-berita-id="{{ $berita->id }}">
                    @php
                        $thumb = $berita->fotoUtama ? $berita->fotoUtama->foto : $berita->gambar;
                    @endphp
                    @if($thumb)
                        <img src="{{ asset('storage/berita/' . $thumb) }}" alt="{{ $berita->judul }}" class="news-thumbnail">
                    @else
                        <img src="https://placehold.co/600x400/008C6E/ffffff?text={{ $berita->judul }}" alt="{{ $berita->judul }}" class="news-thumbnail">
                    @endif

                    <div class="news-content-wrapper">
                        <div class="news-header">
                            <h3>{{ $berita->judul }}</h3>
                        </div>
                        <p class="news-excerpt">{{ Str::limit(strip_tags($berita->konten), 150) }}</p>
                        <div class="news-meta-row">
                            <span class="meta-item"><i class='bx bx-calendar'></i> {{ $berita->tanggal_publikasi->format('d M Y') }}</span>
                            <span class="meta-item"><i class='bx bx-user'></i> {{ $berita->penulis }}</span>
                            <span class="meta-item"><i class='bx bx-category'></i> {{ $berita->kategori }}</span>
                            <span class="meta-item"><i class='bx bx-show'></i> {{ $berita->views }}</span>
                            <span class="badge-status {{ $berita->is_published ? 'status-published' : 'status-draft' }}">
                                {{ $berita->is_published ? 'Published' : 'Draft' }}
                            </span>
                        </div>
<div class="action-buttons">
                            <button type="button" class="btn-action btn-edit" onclick="openEditModal({{ $berita->id }})">
                                <i class='bx bx-edit-alt'></i> Edit
                            </button>
                            <button type="button" class="btn-action {{ $berita->is_utama ? 'btn-utama-active' : 'btn-utama' }}" onclick="{{ $berita->is_utama ? 'hapusUtamaBerita' : 'jadikanUtamaBerita' }}({{ $berita->id }})">
                                <i class='bx {{ $berita->is_utama ? 'bx-star' : 'bx-star' }}'></i>
                                {{ $berita->is_utama ? 'Batal Utama' : 'Jadikan Utama' }}
                            </button>
                            <button type="button" class="btn-action {{ $berita->is_published ? 'btn-unpublish' : 'btn-publish' }}" onclick="{{ $berita->is_published ? 'unpublishBerita' : 'publishBerita' }}({{ $berita->id }})">
                                <i class='bx {{ $berita->is_published ? 'bx-eye-slash' : 'bx-show' }}'></i>
                                {{ $berita->is_published ? 'Unpublish' : 'Publish' }}
                            </button>
                            <button type="button" class="btn-action btn-delete" onclick="deleteBerita({{ $berita->id }})">
                                <i class='bx bx-trash'></i> Hapus
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="pagination-wrapper">{{ $beritas->links() }}</div>
        @else
            <div class="empty-state">
                @if(isset($keyword) && $keyword !== '')
                    <i class='bx bx-search'></i>
                    <h4>Tidak ada hasil pencarian</h4>
                    <p>Tidak ada berita yang cocok dengan keyword "<strong>{{ $keyword }}</strong>"</p>
                    <button type="button" class="btn-add-news" onclick="clearSearch()">
                        <i class='bx bx-arrow-back'></i> Lihat Semua Berita
                    </button>
                @else
                    <i class='bx bx-news-paper'></i>
                    <h4>Belum ada berita</h4>
                    <p>Belum ada berita yang ditambahkan. Klik "Tambah Berita" untuk membuat berita pertama.</p>
                    <a href="#" class="btn-add-news" data-bs-toggle="modal" data-bs-target="#tambahBeritaModal">
                        <i class='bx bx-plus'></i> Tambah Berita Pertama
                    </a>
                @endif
            </div>
        @endif
    </div>
</div>

<style>
    :root { --primary-green:#008C6E; }
    .news-toolbar{background:#fff;padding:15px 25px;border-radius:12px;box-shadow:0 2px 10px rgba(0,0,0,.02);border:1px solid #eee;margin-bottom:25px}
    .toolbar-container{display:flex;justify-content:space-between;align-items:center;gap:20px;width:100%}
    .search-box{position:relative;background:#fff;border-radius:8px;border:1px solid #ddd;width:100%;max-width:700px;display:flex;align-items:center;padding:0 15px;flex:1}
.search-box i{color:#999;font-size:20px}
    .search-box input{height:45px;width:100%;border:none;outline:none;padding-left:10px;font-size:14px}
    .btn-clear-search{display:flex;align-items:center;justify-content:center;width:30px;height:30px;border-radius:50%;background:#dc2626;color:#fff;text-decoration:none;margin-left:8px}
    .btn-clear-search:hover{background:#b91c1c}
    .btn-add-news{background:#009669;color:#fff;padding:12px 20px;border-radius:8px;text-decoration:none;display:flex;align-items:center;gap:8px;font-size:14px;font-weight:500;transition:.3s;white-space:nowrap}
    .btn-add-news:hover{background:#007d57}
    .content-card{background:#fff;border-radius:12px;box-shadow:0 2px 10px rgba(0,0,0,.02);border:1px solid #eee;padding:25px}
    .news-list-item{display:flex;gap:25px;padding-bottom:25px;margin-bottom:25px;border-bottom:1px solid #f0f0f0;align-items:flex-start}
    .news-list-item:last-child{border-bottom:none;margin-bottom:0;padding-bottom:0}
    .news-thumbnail{width:200px;height:140px;border-radius:8px;object-fit:cover;background:#eee;flex-shrink:0;border:1px solid #eee}
    .news-content-wrapper{flex:1;display:flex;flex-direction:column}
    .news-header h3{font-size:18px;font-weight:600;color:#222;margin-bottom:8px;line-height:1.4}
    .news-excerpt{font-size:14px;color:#666;line-height:1.6;margin-bottom:15px}
    .news-meta-row{display:flex;align-items:center;gap:20px;margin-bottom:15px;font-size:13px;color:#888;flex-wrap:wrap}
    .meta-item{display:flex;align-items:center;gap:6px}
    .badge-status{padding:4px 12px;border-radius:20px;font-size:11px;font-weight:600}
    .status-published{background:#d1fae5;color:#047857}
    .status-draft{background:#fef3c7;color:#b45309}
    .action-buttons{display:flex;gap:10px;margin-top:auto;flex-wrap:wrap}
    .btn-action{padding:8px 16px;border-radius:6px;font-size:13px;font-weight:500;text-decoration:none;display:flex;align-items:center;gap:6px;transition:.2s;border:none}
    .btn-edit{background:#eff6ff;color:#1d4ed8}.btn-edit:hover{background:#dbeafe}
    .btn-delete{background:#fef2f2;color:#dc2626}.btn-delete:hover{background:#fee2e2}
    .btn-view{background:#f0fdf4;color:#16a34a}.btn-view:hover{background:#dcfce7}
.btn-publish{background:#f0f9ff;color:#0ea5e9}.btn-publish:hover{background:#e0f2fe}
    .btn-unpublish{background:#fefce8;color:#eab308}.btn-unpublish:hover{background:#fef3c7}
    .btn-utama{background:#fefce8;color:#eab308}.btn-utama:hover{background:#fef3c7}
    .btn-utama-active{background:#d1fae5;color:#047857}.btn-utama-active:hover{background:#a7f3d0}
.empty-state{text-align:center;padding:60px 20px;color:#666}
    .empty-state i{font-size:64px;color:#ddd;margin-bottom:20px;display:block}
    .empty-state h4{font-size:20px;margin-bottom:10px;color:#333}
    .empty-state p{margin-bottom:25px;font-size:14px}
    .search-result-info{background:#f0f9ff;border:1px solid #0ea5e9;border-radius:8px;padding:12px 20px;margin-bottom:20px;color:#0c4a6e;font-size:14px}
    .pagination-wrapper{margin-top:30px;display:flex;justify-content:center}
    .photo-list{display:grid;grid-template-columns:repeat(auto-fill,minmax(130px,1fr));gap:10px}
    .photo-card{border:1px solid #ddd;border-radius:8px;padding:8px;background:#fff;cursor:grab}
    .photo-card.dragging{opacity:.5;border-style:dashed}
    .photo-card img{width:100%;height:90px;object-fit:cover;border-radius:6px;margin-bottom:6px}
    .photo-order-label{font-size:11px;color:#666}
    .remove-photo-btn{width:100%;margin-top:5px;font-size:11px;padding:4px 6px}
    .multi-photo-help{font-size:12px;color:#666;margin-top:6px}
    @media (max-width:768px){.news-list-item{flex-direction:column;gap:15px}.news-thumbnail{width:100%;height:200px}}
</style>

<div class="modal fade" id="tambahBeritaModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Berita Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="createBeritaForm" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="foto_utama_index" name="foto_utama_index" value="0">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3"><label class="form-label">Judul Berita</label><input type="text" class="form-control" name="judul" required maxlength="255"></div>
                            <div class="mb-3">
                                <label class="form-label">Kategori</label>
                                <select class="form-select" name="kategori" required>
                                    <option value="">Pilih Kategori</option>
                                    <option value="Pembangunan">Pembangunan</option><option value="Layanan">Layanan</option><option value="Penghargaan">Penghargaan</option>
                                    <option value="Kesehatan">Kesehatan</option><option value="Pendidikan">Pendidikan</option><option value="Keamanan">Keamanan</option>
                                    <option value="Sosial">Sosial</option><option value="Ekonomi">Ekonomi</option><option value="Lingkungan">Lingkungan</option><option value="Pengumuman">Pengumuman</option>
                                </select>
                            </div>
                            <div class="mb-3"><label class="form-label">Penulis</label><input type="text" class="form-control" name="penulis" value="Admin Kelurahan" required></div>
                            <div class="mb-3"><label class="form-label">Ringkasan</label><textarea class="form-control" name="excerpt" rows="2" maxlength="300"></textarea></div>
                            <div class="mb-3"><label class="form-label">Konten Berita</label><textarea class="form-control" name="konten" rows="5" required></textarea></div>
                            <div class="mb-3"><label class="form-label">Tanggal Publikasi</label><input type="date" class="form-control" id="tanggal_publikasi" name="tanggal_publikasi" required></div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Foto Berita (multi)</label>
                                <input class="form-control" type="file" id="create_fotos" accept="image/*" multiple required>
                                <div class="multi-photo-help">Wajib pilih 1 foto utama. Drag-drop untuk ubah urutan.</div>
                            </div>
                            <div id="createPhotoList" class="photo-list"></div>
                            <div class="form-check mt-3">
                                <input type="hidden" name="is_published" value="0">
                                <input class="form-check-input" type="checkbox" name="is_published" value="1" checked>
                                <label class="form-check-label">Terbitkan Sekarang</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn btn-primary">Simpan Berita</button></div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editBeritaModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header"><h5 class="modal-title">Edit Berita</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <form id="editBeritaForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_berita_id" name="berita_id">
                <input type="hidden" id="edit_foto_orders" name="foto_orders" value="[]">
                <input type="hidden" id="edit_foto_utama_id" name="foto_utama_id" value="">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3"><label class="form-label">Judul Berita</label><input type="text" class="form-control" id="edit_judul" name="judul" required maxlength="255"></div>
                            <div class="mb-3">
                                <label class="form-label">Kategori</label>
                                <select class="form-select" id="edit_kategori" name="kategori" required>
                                    <option value="">Pilih Kategori</option>
                                    <option value="Pembangunan">Pembangunan</option><option value="Layanan">Layanan</option><option value="Penghargaan">Penghargaan</option>
                                    <option value="Kesehatan">Kesehatan</option><option value="Pendidikan">Pendidikan</option><option value="Keamanan">Keamanan</option>
                                    <option value="Sosial">Sosial</option><option value="Ekonomi">Ekonomi</option><option value="Lingkungan">Lingkungan</option><option value="Pengumuman">Pengumuman</option>
                                </select>
                            </div>
                            <div class="mb-3"><label class="form-label">Penulis</label><input type="text" class="form-control" id="edit_penulis" name="penulis" required></div>
                            <div class="mb-3"><label class="form-label">Ringkasan</label><textarea class="form-control" id="edit_excerpt" name="excerpt" rows="2" maxlength="300"></textarea></div>
                            <div class="mb-3"><label class="form-label">Konten Berita</label><textarea class="form-control" id="edit_konten" name="konten" rows="5" required></textarea></div>
                            <div class="mb-3"><label class="form-label">Tanggal Publikasi</label><input type="date" class="form-control" id="edit_tanggal_publikasi" name="tanggal_publikasi" required></div>
                            <div class="form-check mb-3">
                                <input type="hidden" name="is_published" value="0">
                                <input class="form-check-input" type="checkbox" id="edit_is_published" name="is_published" value="1">
                                <label class="form-check-label">Terbitkan Sekarang</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Tambah Foto Baru</label>
                                <input class="form-control" type="file" id="edit_new_fotos" accept="image/*" multiple>
                                <div class="multi-photo-help">Urutan final berlaku untuk foto existing. Foto baru ditambahkan di akhir.</div>
                            </div>
                            <div id="editPhotoList" class="photo-list"></div>
                            <div id="editDeleteInputs"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn btn-primary">Update Berita</button></div>
            </form>
        </div>
    </div>
</div>

<!-- Custom Popups for Edit, Unpublish, Delete -->
<div class="custom-popup-overlay" id="actionPopupOverlay">
    <div class="custom-popup-modal">
        <div class="popup-icon" id="popupIcon"></div>
        <div class="popup-title" id="popupTitle"></div>
        <div class="popup-message" id="popupMessage"></div>
        <div class="popup-buttons">
            <button type="button" class="popup-btn popup-btn-cancel" id="popupCancel">Batal</button>
            <button type="button" class="popup-btn popup-btn-confirm" id="popupConfirm">Ya</button>
        </div>
    </div>
</div>

<style>
    .custom-popup-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.6);
        z-index: 9999;
        justify-content: center;
        align-items: center;
        backdrop-filter: blur(4px);
    }
    .custom-popup-overlay.active { display: flex; }
    .custom-popup-modal {
        background: #fff;
        border-radius: 16px;
        padding: 30px;
        max-width: 400px;
        width: 90%;
        text-align: center;
        box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        transform: scale(0.8);
        opacity: 0;
        transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    }
    .custom-popup-overlay.active .custom-popup-modal {
        transform: scale(1);
        opacity: 1;
    }
    .popup-icon {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        margin: 0 auto 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 32px;
    }
    .popup-icon.edit { background: #dbeafe; color: #1d4ed8; }
    .popup-icon.unpublish { background: #fef3c7; color: #b45309; }
    .popup-icon.publish { background: #d1fae5; color: #059669; }
.popup-icon.delete { background: #fee2e2; color: #dc2626; }
    .popup-icon.utama { background: #fef3c7; color: #b45309; }
    .popup-btn-confirm.utama { background: #b45309; }
    .popup-btn-confirm.utama:hover { background: #92400e; }
    .popup-title {
        font-size: 20px;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 10px;
    }
    .popup-message {
        font-size: 14px;
        color: #6b7280;
        margin-bottom: 25px;
        line-height: 1.6;
    }
    .popup-buttons {
        display: flex;
        gap: 12px;
        justify-content: center;
    }
    .popup-btn {
        padding: 12px 28px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        border: none;
    }
    .popup-btn-cancel {
        background: #f3f4f6;
        color: #4b5563;
    }
    .popup-btn-cancel:hover { background: #e5e7eb; }
    .popup-btn-confirm {
        color: #fff;
    }
    .popup-btn-confirm.edit { background: #1d4ed8; }
    .popup-btn-confirm.edit:hover { background: #1e40af; }
    .popup-btn-confirm.unpublish { background: #b45309; }
    .popup-btn-confirm.unpublish:hover { background: #92400e; }
    .popup-btn-confirm.publish { background: #059669; }
    .popup-btn-confirm.publish:hover { background: #047857; }
    .popup-btn-confirm.delete { background: #dc2626; }
    .popup-btn-confirm.delete:hover { background: #b91c1c; }
</style>

@push('scripts')
<script>
    let createFiles = [];
    let editExisting = [];
    let editNewFiles = [];
    let dragged = null;

    const uid = (p='id') => `${p}_${Math.random().toString(36).slice(2,10)}`;

    function wireDnD(container, cb) {
        container.querySelectorAll('.photo-card').forEach(card => {
            card.draggable = true;
            card.ondragstart = () => { dragged = card; card.classList.add('dragging'); };
            card.ondragend = () => { card.classList.remove('dragging'); dragged = null; cb(); };
            card.ondragover = (e) => {
                e.preventDefault();
                if (!dragged || dragged === card) return;
                const r = card.getBoundingClientRect();
                const before = (e.clientY - r.top) < r.height / 2;
                card.parentNode.insertBefore(dragged, before ? card : card.nextSibling);
            };
        });
    }

    function renderCreate() {
        const box = document.getElementById('createPhotoList');
        box.innerHTML = '';
        createFiles.forEach((f, i) => {
            const el = document.createElement('div');
            el.className = 'photo-card';
            el.dataset.uid = f.uid;
            el.innerHTML = `
                <img src="${f.preview}">
                <div class="photo-order-label">Urutan #${i + 1}</div>
                <div class="form-check mt-1">
                    <input class="form-check-input create-main" type="radio" name="create_main" ${f.isMain?'checked':''} data-uid="${f.uid}">
                    <label class="form-check-label" style="font-size:11px">Foto Utama</label>
                </div>
                <button type="button" class="btn btn-sm btn-outline-danger remove-photo-btn" data-remove="${f.uid}">Hapus</button>
            `;
            box.appendChild(el);
        });
        wireDnD(box, () => {
            const ordered = [];
            box.querySelectorAll('.photo-card').forEach(c => ordered.push(createFiles.find(f => f.uid === c.dataset.uid)));
            createFiles = ordered.filter(Boolean);
            renderCreate();
        });
        box.querySelectorAll('.create-main').forEach(r => r.onchange = function() {
            createFiles = createFiles.map(f => ({...f, isMain: f.uid === this.dataset.uid}));
            renderCreate();
        });
        box.querySelectorAll('[data-remove]').forEach(b => b.onclick = function() {
            createFiles = createFiles.filter(f => f.uid !== this.dataset.remove);
            if (!createFiles.some(f => f.isMain) && createFiles[0]) createFiles[0].isMain = true;
            renderCreate();
        });
        const idx = createFiles.findIndex(f => f.isMain);
        document.getElementById('foto_utama_index').value = idx >= 0 ? idx : 0;
    }

    function renderEdit() {
        const box = document.getElementById('editPhotoList');
        const del = document.getElementById('editDeleteInputs');
        box.innerHTML = ''; del.innerHTML = '';

        const visibleExisting = editExisting.filter(f => !f.deleted);
        visibleExisting.forEach((f, i) => {
            const el = document.createElement('div');
            el.className = 'photo-card';
            el.dataset.id = f.id;
            el.innerHTML = `
                <img src="${f.url}">
                <div class="photo-order-label">Existing #${i + 1}</div>
                <div class="form-check mt-1">
                    <input class="form-check-input edit-main-existing" type="radio" name="edit_main" ${f.isMain?'checked':''} data-id="${f.id}">
                    <label class="form-check-label" style="font-size:11px">Foto Utama</label>
                </div>
                <button type="button" class="btn btn-sm btn-outline-danger remove-photo-btn" data-remove-existing="${f.id}">Hapus</button>
            `;
            box.appendChild(el);
        });

        editNewFiles.forEach((f, i) => {
            const el = document.createElement('div');
            el.className = 'photo-card';
            el.dataset.uid = f.uid;
            el.innerHTML = `
                <img src="${f.preview}">
                <div class="photo-order-label">Baru #${i + 1}</div>
                <div class="form-check mt-1">
                    <input class="form-check-input edit-main-new" type="radio" name="edit_main" ${f.isMain?'checked':''} data-uid="${f.uid}">
                    <label class="form-check-label" style="font-size:11px">Foto Utama</label>
                </div>
                <button type="button" class="btn btn-sm btn-outline-danger remove-photo-btn" data-remove-new="${f.uid}">Hapus</button>
            `;
            box.appendChild(el);
        });

        editExisting.filter(f => f.deleted).forEach(f => {
            del.insertAdjacentHTML('beforeend', `<input type="hidden" name="delete_foto_ids[]" value="${f.id}">`);
        });

        wireDnD(box, collectEditOrder);

        box.querySelectorAll('.edit-main-existing').forEach(r => r.onchange = function() {
            const id = this.dataset.id;
            editExisting = editExisting.map(f => ({...f, isMain: String(f.id) === id && !f.deleted}));
            editNewFiles = editNewFiles.map(f => ({...f, isMain: false}));
            renderEdit();
        });

        box.querySelectorAll('.edit-main-new').forEach(r => r.onchange = function() {
            const u = this.dataset.uid;
            editExisting = editExisting.map(f => ({...f, isMain: false}));
            editNewFiles = editNewFiles.map(f => ({...f, isMain: f.uid === u}));
            renderEdit();
        });

        box.querySelectorAll('[data-remove-existing]').forEach(b => b.onclick = function() {
            editExisting = editExisting.map(f => String(f.id) === this.dataset.removeExisting ? {...f, deleted:true, isMain:false} : f);
            ensureEditMain();
            renderEdit();
        });

        box.querySelectorAll('[data-remove-new]').forEach(b => b.onclick = function() {
            editNewFiles = editNewFiles.filter(f => f.uid !== this.dataset.removeNew);
            ensureEditMain();
            renderEdit();
        });

        collectEditOrder();
    }

    function ensureEditMain() {
        if (editExisting.some(f => !f.deleted && f.isMain) || editNewFiles.some(f => f.isMain)) return;
        const firstEx = editExisting.find(f => !f.deleted);
        if (firstEx) {
            editExisting = editExisting.map(f => ({...f, isMain: f.id === firstEx.id}));
        } else if (editNewFiles[0]) {
            editNewFiles = editNewFiles.map((f,i) => ({...f, isMain: i === 0}));
        }
    }

    function collectEditOrder() {
        const ids = [];
        document.querySelectorAll('#editPhotoList .photo-card').forEach(c => {
            if (c.dataset.id) ids.push(parseInt(c.dataset.id, 10));
        });
        document.getElementById('edit_foto_orders').value = JSON.stringify(ids);
        const mainEx = editExisting.find(f => !f.deleted && f.isMain);
        document.getElementById('edit_foto_utama_id').value = mainEx ? mainEx.id : '';
    }

    document.addEventListener('DOMContentLoaded', function() {
        const t = document.getElementById('tanggal_publikasi');
        if (t) t.value = new Date().toISOString().split('T')[0];

        document.getElementById('create_fotos').addEventListener('change', function(e) {
            createFiles = [];
            Array.from(e.target.files).forEach((file, i) => {
                if (!file.type.match('image.*') || file.size > 2 * 1024 * 1024) return;
                const fr = new FileReader();
                fr.onload = ev => {
                    createFiles.push({uid: uid('c'), file, preview: ev.target.result, isMain: i === 0});
                    renderCreate();
                };
                fr.readAsDataURL(file);
            });
        });

        document.getElementById('createBeritaForm').addEventListener('submit', function(e) {
            e.preventDefault();
            if (createFiles.length === 0) return alert('Minimal unggah 1 foto.');
            const mainIdx = createFiles.findIndex(f => f.isMain);
            if (mainIdx < 0) return alert('Pilih 1 foto utama.');

            const fd = new FormData(this);
            createFiles.forEach(f => fd.append('fotos[]', f.file));
            fd.set('foto_utama_index', String(mainIdx));

            fetch('{{ route('admin.berita.store') }}', {
                method:'POST',
                body:fd,
                headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}','Accept':'application/json'}
            }).then(r => r.json()).then(d => {
                if (d.success) location.reload(); else alert(d.message || 'Gagal menyimpan');
            }).catch(err => alert('Terjadi kesalahan: ' + err.message));
        });

        document.getElementById('edit_new_fotos').addEventListener('change', function(e) {
            Array.from(e.target.files).forEach((file, i) => {
                if (!file.type.match('image.*') || file.size > 2 * 1024 * 1024) return;
                const fr = new FileReader();
                fr.onload = ev => {
                    const noMain = !editExisting.some(f => !f.deleted && f.isMain) && !editNewFiles.some(f => f.isMain);
                    editNewFiles.push({uid: uid('n'), file, preview: ev.target.result, isMain: noMain && i === 0});
                    renderEdit();
                };
                fr.readAsDataURL(file);
            });
        });

// Show "Edit Berita" popup confirmation BEFORE submitting the edit form
        let editPopupShown = false;
        
        document.getElementById('editBeritaForm').addEventListener('submit', function(e) {
            if (editPopupShown) {
                // Popup was already confirmed, proceed with submission
                editPopupShown = false;
                return;
            }
            
            e.preventDefault();
            
            // Show "Edit Berita" popup before proceeding
            showPopup('edit', 'Edit Berita', 'Apakah Anda yakin ingin menyimpan perubahan pada berita ini?', function() {
                editPopupShown = true;
                
                const remaining = editExisting.filter(f => !f.deleted).length + editNewFiles.length;
                if (remaining <= 0) return alert('Minimal harus ada 1 foto.');
                if (!editExisting.some(f => !f.deleted && f.isMain) && !editNewFiles.some(f => f.isMain)) return alert('Pilih 1 foto utama.');

                collectEditOrder();
                const fd = new FormData(document.getElementById('editBeritaForm'));
                editNewFiles.forEach(f => fd.append('fotos[]', f.file));

                const id = document.getElementById('edit_berita_id').value;
                fetch(`/admin/berita/${id}`, {
                    method:'POST',
                    body:fd,
                    headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}','Accept':'application/json'}
                }).then(r => r.json()).then(d => {
                    if (d.success) location.reload(); else alert(d.message || 'Gagal update');
                }).catch(err => alert('Terjadi kesalahan: ' + err.message));
            });
        });
    });

function openEditModal(id) {
        // Reset popup flag when opening edit modal to ensure popup shows on every update click
        editPopupShown = false;
        
        fetch(`/admin/berita/${id}/edit-data`)
            .then(r => r.json())
            .then(d => {
                if (!d.success) return alert(d.message || 'Gagal ambil data');
                const b = d.berita;
                document.getElementById('edit_berita_id').value = b.id;
                document.getElementById('edit_judul').value = b.judul;
                document.getElementById('edit_kategori').value = b.kategori;
                document.getElementById('edit_penulis').value = b.penulis;
                document.getElementById('edit_excerpt').value = b.excerpt || '';
                document.getElementById('edit_konten').value = b.konten;
                document.getElementById('edit_tanggal_publikasi').value = b.tanggal_publikasi;
                document.getElementById('edit_is_published').checked = !!b.is_published;
                document.getElementById('editBeritaForm').action = `/admin/berita/${b.id}`;

                editExisting = (b.fotos || []).map((f, i) => ({
                    id: f.id,
                    url: `{{ asset('storage/berita') }}/${f.foto}`,
                    isMain: !!f.is_utama || (i === 0 && !(b.fotos || []).some(x => x.is_utama)),
                    deleted: false
                }));
                editNewFiles = [];
                ensureEditMain();
                renderEdit();

                new bootstrap.Modal(document.getElementById('editBeritaModal')).show();
            })
            .catch(err => alert('Terjadi kesalahan: ' + err.message));
    }

// Custom Popup Functions
    let currentAction = null;
    let currentBeritaId = null;

    const popupOverlay = document.getElementById('actionPopupOverlay');
    const popupIcon = document.getElementById('popupIcon');
    const popupTitle = document.getElementById('popupTitle');
    const popupMessage = document.getElementById('popupMessage');
    const popupCancel = document.getElementById('popupCancel');
    const popupConfirm = document.getElementById('popupConfirm');

    function showPopup(type, title, message, onConfirm) {
        popupIcon.className = 'popup-icon ' + type;
        popupIcon.innerHTML = type === 'edit' ? '✏️' : type === 'delete' ? '🗑️' : type === 'unpublish' ? '👁️' : '✅';
        popupTitle.innerHTML = title;
        popupMessage.innerHTML = message;
        
        popupConfirm.className = 'popup-btn popup-btn-confirm ' + type;
        
        popupOverlay.classList.add('active');
        
        currentAction = onConfirm;
        
popupConfirm.onclick = function() {
            // Execute action BEFORE hiding popup (so currentAction is still available)
            if (currentAction) {
                currentAction();
            }
            hidePopup();
        };
        
        popupCancel.onclick = hidePopup;
        popupOverlay.onclick = function(e) {
            if (e.target === popupOverlay) hidePopup();
        };
    }

    function hidePopup() {
        popupOverlay.classList.remove('active');
        currentAction = null;
    }

    // Modified function handlers for Edit, Unpublish, Delete
    function openEditModalWithPopup(id) {
        showPopup('edit', 'Edit Berita?', 'Apakah Anda yakin ingin mengedit berita ini?', function() {
            openEditModal(id);
        });
    }

    function unpublishBerita(id) {
        showPopup('unpublish', 'Unpublish Berita?', 'Apakah Anda yakin akan menyembunyikan berita ini dari publik?<br>Berita tidak akan muncul di halaman depan.', function() {
            const fd = new FormData();
            fd.append('_token', '{{ csrf_token() }}');
            
            fetch(`/admin/berita/${id}/toggle-publish`, { method:'POST', body:fd, headers:{'Accept':'application/json'} })
                .then(r => r.json())
                .then(d => { if (d.success) location.reload(); else alert(d.message || 'Gagal'); })
                .catch(err => alert('Terjadi kesalahan: ' + err.message));
        });
    }

    function publishBerita(id) {
        showPopup('publish', 'Publish Berita?', 'Apakah Anda yakin ingin mempublikasi berita ini?<br>Berita akan muncul di halaman depan.', function() {
            const fd = new FormData();
            fd.append('_token', '{{ csrf_token() }}');
            
            fetch(`/admin/berita/${id}/toggle-publish`, { method:'POST', body:fd, headers:{'Accept':'application/json'} })
                .then(r => r.json())
                .then(d => { if (d.success) location.reload(); else alert(d.message || 'Gagal'); })
                .catch(err => alert('Terjadi kesalahan: ' + err.message));
        });
    }

    function deleteBeritaWithPopup(id) {
        showPopup('delete', 'Hapus Berita?', 'Apakah Anda yakin ingin menghapus berita ini?<br><strong>Tindakan ini tidak dapat dibatalkan!</strong>', function() {
            const fd = new FormData();
            fd.append('_method', 'DELETE');
            fd.append('_token', '{{ csrf_token() }}');

            fetch(`/admin/berita/${id}`, { method:'POST', body:fd, headers:{'Accept':'application/json'} })
                .then(r => r.json())
                .then(d => { if (d.success) location.reload(); else alert(d.message || 'Gagal hapus'); })
                .catch(err => alert('Terjadi kesalahan: ' + err.message));
        });
    }

// Legacy function for backward compatibility
    function deleteBerita(id) {
        deleteBeritaWithPopup(id);
    }

    // Functions for Utama button
    function jadikanUtamaBerita(id) {
        showPopup('utama', 'Jadikan Berita Utama?', 'Apakah Anda yakin ingin menjadikan berita ini sebagai berita utama?<br>Berita utama akan ditampilkan di halaman depan.', function() {
            const fd = new FormData();
            fd.append('_token', '{{ csrf_token() }}');
            
            fetch(`/admin/berita/${id}/set-utama`, { method:'POST', body:fd, headers:{'Accept':'application/json'} })
                .then(r => r.json())
                .then(d => { if (d.success) location.reload(); else alert(d.message || 'Gagal'); })
                .catch(err => alert('Terjadi kesalahan: ' + err.message));
        });
    }

    function hapusUtamaBerita(id) {
        showPopup('utama', 'Batalkan Berita Utama?', 'Apakah Anda yakin ingin membatalkan status berita utama?<br>Berita ini tidak lagi ditampilkan sebagai utama.', function() {
            const fd = new FormData();
            fd.append('_token', '{{ csrf_token() }}');
            
            fetch(`/admin/berita/${id}/set-utama`, { method:'POST', body:fd, headers:{'Accept':'application/json'} })
                .then(r => r.json())
                .then(d => { if (d.success) location.reload(); else alert(d.message || 'Gagal'); })
                .catch(err => alert('Terjadi kesalahan: ' + err.message));
        });
    }

// Handle open_edit URL parameter to auto-open edit modal
    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const openEditId = urlParams.get('open_edit');
        if (openEditId) {
            window.history.replaceState({}, document.title, window.location.pathname);
            openEditModal(parseInt(openEditId, 10));
        }
        
        // Check initial keyword and show clear button
        const currentKeyword = '{{ $keyword ?? '' }}';
        if (currentKeyword) {
            document.getElementById('btnClearSearch').style.display = 'flex';
        }
    });

// AJAX Search functionality - no page refresh
    let searchTimeout = null;
    const searchInput = document.getElementById('searchBerita');
    const btnClearSearch = document.getElementById('btnClearSearch');
    const contentDiv = document.getElementById('beritaContent');
    
    function performSearch(keyword) {
        // Show loading state
        contentDiv.style.opacity = '0.5';
        contentDiv.style.pointerEvents = 'none';
        
        fetch('{{ route('admin.berita.search') }}?keyword=' + encodeURIComponent(keyword), {
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(r => r.json())
        .then(d => {
            contentDiv.style.opacity = '1';
            contentDiv.style.pointerEvents = 'auto';
            
            if (d.success) {
                renderSearchResults(d.beritas, d.total, keyword);
            }
        })
        .catch(err => {
            contentDiv.style.opacity = '1';
            contentDiv.style.pointerEvents = 'auto';
            console.error('Search error:', err);
        });
    }
    
    function renderSearchResults(beritas, total, keyword) {
        let html = '';
        
        if (beritas.length > 0) {
            if (keyword) {
                html += '<div class="search-result-info"><p>Ditemukan ' + total + ' berita untuk keyword "<strong>' + keyword + '</strong>"</p></div>';
            }
            
            beritas.forEach(berita => {
                const thumb = berita.foto_utama ? berita.foto_utama.foto : berita.gambar;
                const thumbUrl = thumb 
                    ? '{{ asset('storage/berita') }}/' + thumb 
                    : 'https://placehold.co/600x400/008C6E/ffffff?text=' + encodeURIComponent(berita.judul);
                
                const statusClass = berita.is_published ? 'status-published' : 'status-draft';
                const statusText = berita.is_published ? 'Published' : 'Draft';
                const toggleIcon = berita.is_published ? 'bx-eye-slash' : 'bx-show';
                const toggleText = berita.is_published ? 'Unpublish' : 'Publish';
                
                html += `
                <div class="news-list-item" data-berita-id="${berita.id}">
                    <img src="${thumbUrl}" alt="${berita.judul}" class="news-thumbnail">
                    <div class="news-content-wrapper">
                        <div class="news-header"><h3>${berita.judul}</h3></div>
                        <p class="news-excerpt">${berita.konten.replace(/<[^>]*>/g, '').substring(0, 150)}...</p>
                        <div class="news-meta-row">
                            <span class="meta-item"><i class='bx bx-calendar'></i> ${berita.tanggal_publikasi}</span>
                            <span class="meta-item"><i class='bx bx-user'></i> ${berita.penulis}</span>
                            <span class="meta-item"><i class='bx bx-category'></i> ${berita.kategori}</span>
                            <span class="meta-item"><i class='bx bx-show'></i> ${berita.views}</span>
                            <span class="badge-status ${statusClass}">${statusText}</span>
                        </div>
                        <div class="action-buttons">
                            <button type="button" class="btn-action btn-edit" onclick="openEditModal(${berita.id})">
                                <i class='bx bx-edit-alt'></i> Edit
                            </button>
                            <form action="/admin/berita/${berita.id}/toggle-publish" method="POST" style="display:inline;">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <button type="submit" class="btn-action ${berita.is_published ? 'btn-unpublish' : 'btn-publish'}">
                                    <i class='bx ${toggleIcon}'></i> ${toggleText}
                                </button>
                            </form>
                            <button type="button" class="btn-action btn-delete" onclick="deleteBerita(${berita.id})">
                                <i class='bx bx-trash'></i> Hapus
                            </button>
                        </div>
                    </div>
                </div>`;
            });
            
            html += '<div class="pagination-wrapper"></div>';
        } else {
            if (keyword) {
                html = `
                <div class="empty-state">
                    <i class='bx bx-search'></i>
                    <h4>Tidak ada hasil pencarian</h4>
                    <p>Tidak ada berita yang cocok dengan keyword "<strong>${keyword}</strong>"</p>
                    <button type="button" class="btn-add-news" onclick="clearSearch()">
                        <i class='bx bx-arrow-back'></i> Lihat Semua Berita
                    </button>
                </div>`;
            } else {
                html = `
                <div class="empty-state">
                    <i class='bx bx-news-paper'></i>
                    <h4>Belum ada berita</h4>
                    <p>Belum ada berita yang ditambahkan. Klik "Tambah Berita" untuk membuat berita pertama.</p>
                    <a href="#" class="btn-add-news" data-bs-toggle="modal" data-bs-target="#tambahBeritaModal">
                        <i class='bx bx-plus'></i> Tambah Berita Pertama
                    </a>
                </div>`;
            }
        }
        
        contentDiv.innerHTML = html;
        
        // Show/hide clear button
        btnClearSearch.style.display = keyword ? 'flex' : 'none';
        searchInput.value = keyword;
    }
    
    function clearSearch() {
        searchInput.value = '';
        btnClearSearch.style.display = 'none';
        performSearch('');
    }
    
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            if (searchTimeout) clearTimeout(searchTimeout);
            
            searchTimeout = setTimeout(function() {
                const keyword = searchInput.value.trim();
                performSearch(keyword);
            }, 500);
        });
    }
    
    if (btnClearSearch) {
        btnClearSearch.addEventListener('click', clearSearch);
    }
</script>
@endpush
@endsection
