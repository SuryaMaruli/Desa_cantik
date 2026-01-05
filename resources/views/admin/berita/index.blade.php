@extends('layouts.admin')

@section('page-title', 'Berita & Informasi')

@section('content')
<div class="home-content">
    <div class="news-toolbar">
        <div class="toolbar-container">
            <div class="search-box">
                <i class='bx bx-search'></i>
                <input type="text" placeholder="Cari berita..." id="searchBerita">
            </div>
            <a href="#" class="btn-add-news" data-bs-toggle="modal" data-bs-target="#tambahBeritaModal">
                <i class='bx bx-plus'></i> Tambah Berita
            </a>
        </div>
    </div>

    <div class="content-card">
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
            @foreach($beritas as $berita)
                <div class="news-list-item" data-berita-id="{{ $berita->id }}">
                    @if($berita->gambar)
                        <img src="{{ asset('storage/berita/' . $berita->gambar) }}" alt="{{ $berita->judul }}" class="news-thumbnail">
                    @else
                        <img src="https://placehold.co/600x400/008C6E/ffffff?text={{ $berita->judul }}" alt="{{ $berita->judul }}" class="news-thumbnail">
                    @endif
                    <div class="news-content-wrapper">
                        <div class="news-header">
                            <h3>{{ $berita->judul }}</h3>
                        </div>
                        <p class="news-excerpt">
                            {{ Str::limit(strip_tags($berita->konten), 150) }}
                        </p>
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
                            <a href="{{ route('admin.berita.show', $berita) }}" class="btn-action btn-view">
                                <i class='bx bx-show'></i> Lihat
                            </a>
                            <button type="button" class="btn-action btn-edit" onclick="openEditModal({{ $berita->id }})">
                                <i class='bx bx-edit-alt'></i> Edit
                            </button>
                            <form action="{{ route('admin.berita.toggle-publish', $berita) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn-action {{ $berita->is_published ? 'btn-unpublish' : 'btn-publish' }}">
                                    <i class='bx {{ $berita->is_published ? 'bx-eye-slash' : 'bx-show' }}'></i> 
                                    {{ $berita->is_published ? 'Unpublish' : 'Publish' }}
                                </button>
                            </form>
                            <button type="button" class="btn-action btn-delete" onclick="deleteBerita({{ $berita->id }})">
                                <i class='bx bx-trash'></i> Hapus
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach

            <!-- Pagination -->
            <div class="pagination-wrapper">
                {{ $beritas->links() }}
            </div>
        @else
            <div class="empty-state">
                <i class='bx bx-news-paper'></i>
                <h4>Belum ada berita</h4>
                <p>Belum ada berita yang ditambahkan. Klik "Tambah Berita" untuk membuat berita pertama.</p>
                <a href="#" class="btn-add-news" data-bs-toggle="modal" data-bs-target="#tambahBeritaModal">
                    <i class='bx bx-plus'></i> Tambah Berita Pertama
                </a>
            </div>
        @endif
    </div>
</div>

<style>
    /* --- 1. RESET & GLOBAL --- */
    :root {
        --sidebar-bg: #005740;     
        --sidebar-active: #0b755b; 
        --header-height: 80px;
        --sidebar-width: 260px;
        --text-dark: #333;
        --text-grey: #666;
        --primary-green: #008C6E;
    }

    /* --- 2. KONTEN BERITA --- */
    .news-toolbar {
        background: #fff;
        padding: 15px 25px;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.02);
        border: 1px solid #eee;
        margin-bottom: 25px;
    }
    
    .toolbar-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        width: 100%;
        max-width: 100%;
    }
    
    .search-box {
        position: relative; 
        background: #fff; 
        border-radius: 8px; 
        border: 1px solid #ddd;
        width: 100%; 
        max-width: 700px;  /* Increased from 600px */
        display: flex; 
        align-items: center; 
        padding: 0 15px;
        flex: 1;  /* Allow it to grow and take available space */
    }
    
    .search-box i { 
        color: #999; 
        font-size: 20px; 
    }
    
    .search-box input {
        height: 45px; 
        width: 100%; 
        border: none; 
        outline: none; 
        padding-left: 10px; 
        font-size: 14px;
    }
    
    .btn-add-news {
        background-color: #009669; 
        color: white; 
        padding: 12px 20px; 
        border-radius: 8px;
        text-decoration: none; 
        display: flex; 
        align-items: center; 
        gap: 8px; 
        font-size: 14px; 
        font-weight: 500;
        transition: 0.3s; 
        white-space: nowrap;
    }
    
    .btn-add-news:hover { 
        background-color: #007d57; 
    }

    .content-card {
        background: #fff; 
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.02); 
        border: 1px solid #eee; 
        padding: 25px;
    }

    /* --- 3. LIST BERITA DENGAN GAMBAR --- */
    .news-list-item {
        display: flex;
        gap: 25px;
        padding-bottom: 25px; 
        margin-bottom: 25px;
        border-bottom: 1px solid #f0f0f0;
        align-items: flex-start;
    }
    
    .news-list-item:last-child { 
        border-bottom: none; 
        margin-bottom: 0; 
        padding-bottom: 0; 
    }

    /* Styling Gambar Thumbnail */
    .news-thumbnail {
        width: 200px;         /* Lebar tetap */
        height: 140px;        /* Tinggi tetap */
        border-radius: 8px;
        object-fit: cover;    /* Agar gambar tidak gepeng */
        background-color: #eee;
        flex-shrink: 0;       /* Mencegah gambar mengecil */
        border: 1px solid #eee;
    }

    /* Wrapper Konten Teks */
    .news-content-wrapper {
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .news-header h3 { 
        font-size: 18px; 
        font-weight: 600; 
        color: #222; 
        margin-bottom: 8px; 
        line-height: 1.4; 
    }
    
    .news-excerpt { 
        font-size: 14px; 
        color: #666; 
        line-height: 1.6; 
        margin-bottom: 15px; 
    }

    .news-meta-row {
        display: flex; 
        align-items: center; 
        gap: 20px; 
        margin-bottom: 15px; 
        font-size: 13px; 
        color: #888;
    }
    
    .meta-item { 
        display: flex; 
        align-items: center; 
        gap: 6px; 
    }
    
    .badge-status { 
        padding: 4px 12px; 
        border-radius: 20px; 
        font-size: 11px; 
        font-weight: 600; 
    }
    
    .status-published { 
        background: #d1fae5; 
        color: #047857; 
    }
    
    .status-draft { 
        background: #fef3c7; 
        color: #b45309; 
    }

    .action-buttons { 
        display: flex; 
        gap: 10px; 
        margin-top: auto;
    }
    
    .btn-action {
        padding: 8px 16px; 
        border-radius: 6px; 
        font-size: 13px; 
        font-weight: 500;
        text-decoration: none; 
        display: flex; 
        align-items: center; 
        gap: 6px; 
        transition: 0.2s;
    }
    
    .btn-edit { 
        background: #eff6ff; 
        color: #1d4ed8; 
    }
    
    .btn-edit:hover { 
        background: #dbeafe; 
    }
    
    .btn-delete { 
        background: #fef2f2; 
        color: #dc2626; 
    }
    
    .btn-delete:hover { 
        background: #fee2e2; 
    }

    .btn-view { 
        background: #f0fdf4; 
        color: #16a34a; 
    }
    
    .btn-view:hover { 
        background: #dcfce7; 
    }

    .btn-publish { 
        background: #f0f9ff; 
        color: #0ea5e9; 
    }
    
    .btn-publish:hover { 
        background: #e0f2fe; 
    }

    .btn-unpublish { 
        background: #fefce8; 
        color: #eab308; 
    }
    
    .btn-unpublish:hover { 
        background: #fef3c7; 
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #666;
    }

    .empty-state i {
        font-size: 64px;
        color: #ddd;
        margin-bottom: 20px;
        display: block;
    }

    .empty-state h4 {
        font-size: 20px;
        margin-bottom: 10px;
        color: #333;
    }

    .empty-state p {
        margin-bottom: 25px;
        font-size: 14px;
    }

    /* Pagination */
    .pagination-wrapper {
        margin-top: 30px;
        display: flex;
        justify-content: center;
    }

    .pagination-wrapper .pagination {
        display: flex;
        gap: 5px;
    }

    .pagination-wrapper .page-link {
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 6px;
        color: #666;
        text-decoration: none;
        transition: 0.2s;
    }

    .pagination-wrapper .page-link:hover {
        background: #f8f9fa;
        color: #333;
    }

    .pagination-wrapper .page-item.active .page-link {
        background: var(--primary-green);
        color: white;
        border-color: var(--primary-green);
    }

    /* Responsiveness untuk Mobile */
    @media (max-width: 768px) {
        .news-toolbar { 
            flex-direction: column; 
            align-items: stretch; 
        }
        
        .news-list-item { 
            flex-direction: column; 
            gap: 15px; 
        }
        
        .news-thumbnail { 
            width: 100%; 
            height: 200px; 
        }
    }
</style>

<!-- Modal Tambah Berita -->
<div class="modal fade" id="tambahBeritaModal" tabindex="-1" aria-labelledby="tambahBeritaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahBeritaModalLabel">Tambah Berita Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.berita.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="judul" class="form-label">Judul Berita</label>
                        <input type="text" class="form-control" id="judul" name="judul" required maxlength="255">
                    </div>
                    
                    <div class="mb-3">
                        <label for="kategori" class="form-label">Kategori</label>
                        <select class="form-select" id="kategori" name="kategori" required>
                            <option value="">Pilih Kategori</option>
                            <option value="Pembangunan">Pembangunan</option>
                            <option value="Layanan">Layanan</option>
                            <option value="Penghargaan">Penghargaan</option>
                            <option value="Kesehatan">Kesehatan</option>
                            <option value="Pendidikan">Pendidikan</option>
                            <option value="Keamanan">Keamanan</option>
                            <option value="Sosial">Sosial</option>
                            <option value="Ekonomi">Ekonomi</option>
                            <option value="Lingkungan">Lingkungan</option>
                            <option value="Pengumuman">Pengumuman</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="penulis" class="form-label">Penulis</label>
                        <input type="text" class="form-control" id="penulis" name="penulis" value="Admin Kelurahan" required>
                    </div>

                    <div class="mb-3">
                        <label for="excerpt" class="form-label">Ringkasan</label>
                        <textarea class="form-control" id="excerpt" name="excerpt" rows="2" maxlength="300"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="konten" class="form-label">Konten Berita</label>
                        <textarea class="form-control" id="konten" name="konten" rows="5" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="tanggal_publikasi" class="form-label">Tanggal Publikasi</label>
                        <input type="date" class="form-control" id="tanggal_publikasi" name="tanggal_publikasi" required>
                    </div>

                    <div class="mb-3">
                        <label for="gambar" class="form-label">Gambar Utama</label>
                        <input class="form-control" type="file" id="gambar" name="gambar" accept="image/*">
                        <div class="mt-2" id="gambarPreview" style="display: none;">
                            <img src="" alt="Preview" class="img-thumbnail" style="max-height: 150px;">
                            <button type="button" class="btn btn-sm btn-danger mt-2" onclick="removeGambar()">
                                <i class='bx bx-trash'></i> Hapus Gambar
                            </button>
                        </div>
                    </div>

                    <div class="form-check mb-3">
                        <input type="hidden" name="is_published" value="0">
                        <input class="form-check-input" type="checkbox" id="is_published" name="is_published" value="1" checked>
                        <label class="form-check-label" for="is_published">
                            Terbitkan Sekarang
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Berita</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Berita -->
<div class="modal fade" id="editBeritaModal" tabindex="-1" aria-labelledby="editBeritaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editBeritaModalLabel">Edit Berita</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editBeritaForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_berita_id" name="berita_id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_judul" class="form-label">Judul Berita</label>
                        <input type="text" class="form-control" id="edit_judul" name="judul" required maxlength="255">
                    </div>
                    
                    <div class="mb-3">
                        <label for="edit_kategori" class="form-label">Kategori</label>
                        <select class="form-select" id="edit_kategori" name="kategori" required>
                            <option value="">Pilih Kategori</option>
                            <option value="Pembangunan">Pembangunan</option>
                            <option value="Layanan">Layanan</option>
                            <option value="Penghargaan">Penghargaan</option>
                            <option value="Kesehatan">Kesehatan</option>
                            <option value="Pendidikan">Pendidikan</option>
                            <option value="Keamanan">Keamanan</option>
                            <option value="Sosial">Sosial</option>
                            <option value="Ekonomi">Ekonomi</option>
                            <option value="Lingkungan">Lingkungan</option>
                            <option value="Pengumuman">Pengumuman</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="edit_penulis" class="form-label">Penulis</label>
                        <input type="text" class="form-control" id="edit_penulis" name="penulis" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit_excerpt" class="form-label">Ringkasan</label>
                        <textarea class="form-control" id="edit_excerpt" name="excerpt" rows="2" maxlength="300"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="edit_konten" class="form-label">Konten Berita</label>
                        <textarea class="form-control" id="edit_konten" name="konten" rows="5" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="edit_tanggal_publikasi" class="form-label">Tanggal Publikasi</label>
                        <input type="date" class="form-control" id="edit_tanggal_publikasi" name="tanggal_publikasi" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit_gambar" class="form-label">Ganti Gambar Utama (kosongkan jika tidak ingin mengubah)</label>
                        <input class="form-control" type="file" id="edit_gambar" name="gambar" accept="image/*">
                        <div class="mt-2" id="edit_gambar_preview" style="display: none;">
                            <img src="" alt="Preview" class="img-thumbnail" style="max-height: 150px;">
                            <button type="button" class="btn btn-sm btn-danger mt-2" onclick="removeEditGambar()">
                                <i class='bx bx-trash'></i> Hapus Gambar
                            </button>
                        </div>
                        <div class="mt-2" id="edit_current_gambar" style="display: none;">
                            <small class="text-muted">Gambar saat ini:</small><br>
                            <img src="" alt="Current" class="img-thumbnail" style="max-height: 100px;">
                        </div>
                    </div>

                    <div class="form-check mb-3">
                        <input type="hidden" name="is_published" value="0">
                        <input class="form-check-input" type="checkbox" id="edit_is_published" name="is_published" value="1">
                        <label class="form-check-label" for="edit_is_published">
                            Terbitkan Sekarang
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Update Berita</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Set default tanggal publikasi ke hari ini
    document.addEventListener('DOMContentLoaded', function() {
        const tanggalInput = document.getElementById('tanggal_publikasi');
        if (tanggalInput) {
            const today = new Date().toISOString().split('T')[0];
            tanggalInput.value = today;
        }

        // Preview gambar
        const gambarInput = document.getElementById('gambar');
        const gambarPreview = document.getElementById('gambarPreview');
        const previewImage = gambarPreview.querySelector('img');

        gambarInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                // Validasi file
                if (file.size > 2 * 1024 * 1024) { // 2MB
                    alert('Ukuran file terlalu besar. Maksimal 2MB.');
                    e.target.value = '';
                    return;
                }

                // Validasi tipe file
                if (!file.type.match('image.*')) {
                    alert('File harus berupa gambar.');
                    e.target.value = '';
                    return;
                }

                // Tampilkan preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    gambarPreview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        });

        // Handle form submission
        const form = document.querySelector('#tambahBeritaModal form');
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(form);
            
            // Debug: Log form data
            console.log('Submitting form with data:');
            for (let [key, value] of formData.entries()) {
                console.log(key + ':', value);
            }
            
            fetch('{{ route('admin.berita.store') }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                console.log('Response status:', response.status);
                return response.json();
            })
            .then(data => {
                console.log('Response data:', data);
                if (data.success) {
                    // Close modal
                    const modal = bootstrap.Modal.getInstance(document.getElementById('tambahBeritaModal'));
                    modal.hide();
                    
                    // Reset form
                    form.reset();
                    gambarPreview.style.display = 'none';
                    
                    // Show success message and reload
                    location.reload();
                } else {
                    alert('Error: ' + (data.message || 'Unknown error occurred'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan: ' + error.message);
            });
        });
    });

    // Fungsi hapus gambar
    function removeGambar() {
        const gambarInput = document.getElementById('gambar');
        const gambarPreview = document.getElementById('gambarPreview');
        
        gambarInput.value = '';
        gambarPreview.style.display = 'none';
    }

    // Fungsi hapus berita
    function deleteBerita(beritaId) {
        if (confirm('Apakah Anda yakin ingin menghapus berita ini?')) {
            const deleteUrl = `/admin/berita/${beritaId}`;
            
            // Create form data for proper DELETE method
            const formData = new FormData();
            formData.append('_method', 'DELETE');
            formData.append('_token', '{{ csrf_token() }}');
            
            fetch(deleteUrl, {
                method: 'POST', // Use POST with _method override
                body: formData,
                headers: {
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Remove the news item from DOM with animation
                    const newsItem = document.querySelector(`[data-berita-id="${beritaId}"]`);
                    if (newsItem) {
                        newsItem.style.transition = 'opacity 0.3s, transform 0.3s';
                        newsItem.style.opacity = '0';
                        newsItem.style.transform = 'translateX(-20px)';
                        
                        setTimeout(() => {
                            newsItem.remove();
                            
                            // Check if there are any remaining items
                            const remainingItems = document.querySelectorAll('.news-list-item');
                            if (remainingItems.length === 0) {
                                location.reload(); // Reload to show empty state
                            }
                        }, 300);
                    } else {
                        // Fallback: reload page
                        location.reload();
                    }
                } else {
                    alert('Error: ' + (data.message || 'Gagal menghapus berita'));
                }
            })
            .catch(error => {
                console.error('Delete error:', error);
                alert('Terjadi kesalahan: ' + error.message);
            });
        }
    }

    // Fungsi buka modal edit
    function openEditModal(beritaId) {
        // Fetch berita data
        fetch(`/admin/berita/${beritaId}/edit-data`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const berita = data.berita;
                    
                    // Populate form fields
                    document.getElementById('edit_berita_id').value = berita.id;
                    document.getElementById('edit_judul').value = berita.judul;
                    document.getElementById('edit_kategori').value = berita.kategori;
                    document.getElementById('edit_penulis').value = berita.penulis;
                    document.getElementById('edit_excerpt').value = berita.excerpt || '';
                    document.getElementById('edit_konten').value = berita.konten;
                    document.getElementById('edit_tanggal_publikasi').value = berita.tanggal_publikasi;
                    document.getElementById('edit_is_published').checked = berita.is_published;
                    
                    // Show current image if exists
                    const currentImageDiv = document.getElementById('edit_current_gambar');
                    if (berita.gambar) {
                        const currentImage = currentImageDiv.querySelector('img');
                        currentImage.src = `{{ asset('storage/berita/') }}${berita.gambar}`;
                        currentImageDiv.style.display = 'block';
                    } else {
                        currentImageDiv.style.display = 'none';
                    }
                    
                    // Set form action
                    document.getElementById('editBeritaForm').action = `/admin/berita/${berita.id}`;
                    
                    // Show modal
                    const modal = new bootstrap.Modal(document.getElementById('editBeritaModal'));
                    modal.show();
                } else {
                    alert('Error: ' + (data.message || 'Gagal mengambil data berita'));
                }
            })
            .catch(error => {
                console.error('Error fetching berita data:', error);
                alert('Terjadi kesalahan: ' + error.message);
            });
    }

    // Fungsi hapus gambar edit
    function removeEditGambar() {
        const gambarInput = document.getElementById('edit_gambar');
        const gambarPreview = document.getElementById('edit_gambar_preview');
        
        gambarInput.value = '';
        gambarPreview.style.display = 'none';
    }

    // Handle edit form submission
    document.addEventListener('DOMContentLoaded', function() {
        const editForm = document.getElementById('editBeritaForm');
        if (editForm) {
            editForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const formData = new FormData(editForm);
                const beritaId = document.getElementById('edit_berita_id').value;
                
                fetch(`/admin/berita/${beritaId}`, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Close modal
                        const modal = bootstrap.Modal.getInstance(document.getElementById('editBeritaModal'));
                        modal.hide();
                        
                        // Reload page to show updated data
                        location.reload();
                    } else {
                        alert('Error: ' + (data.message || 'Gagal mengupdate berita'));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan: ' + error.message);
                });
            });

            // Handle edit image preview
            const editGambarInput = document.getElementById('edit_gambar');
            const editGambarPreview = document.getElementById('edit_gambar_preview');
            const editPreviewImage = editGambarPreview.querySelector('img');

            editGambarInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    // Validasi file
                    if (file.size > 2 * 1024 * 1024) { // 2MB
                        alert('Ukuran file terlalu besar. Maksimal 2MB.');
                        e.target.value = '';
                        return;
                    }

                    // Validasi tipe file
                    if (!file.type.match('image.*')) {
                        alert('File harus berupa gambar.');
                        e.target.value = '';
                        return;
                    }

                    // Tampilkan preview
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        editPreviewImage.src = e.target.result;
                        editGambarPreview.style.display = 'block';
                    };
                    reader.readAsDataURL(file);
                }
            });
        }
    });
</script>
@endpush
@endsection
