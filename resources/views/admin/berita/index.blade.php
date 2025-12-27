@extends('layouts.admin')

@section('page-title', 'Berita & Informasi')

@section('content')
<div class="home-content">
    <div class="news-toolbar">
        <div class="toolbar-container">
            <div class="search-box">
                <i class='bx bx-search'></i>
                <input type="text" placeholder="Cari berita...">
            </div>
            <button type="button" class="btn-add-news" data-bs-toggle="modal" data-bs-target="#tambahBeritaModal">
                <i class='bx bx-plus'></i> Tambah Berita
            </button>
        </div>
    </div>

    <div class="content-card">
        <div class="news-list-item">
            <img src="https://placehold.co/600x400/008C6E/ffffff?text=Vaksinasi+Covid" alt="Vaksinasi" class="news-thumbnail">
            <div class="news-content-wrapper">
                <div class="news-header">
                    <h3>Vaksinasi Massal COVID-19 di Kelurahan Citangkil</h3>
                </div>
                <p class="news-excerpt">
                    Pemerintah Kelurahan Citangkil mengadakan vaksinasi massal untuk warga agar tercipta kekebalan komunal dan mendukung program pemerintah pusat...
                </p>
                <div class="news-meta-row">
                    <span class="meta-item"><i class='bx bx-calendar'></i> 2024-12-15</span>
                    <span class="meta-item"><i class='bx bx-user'></i> Admin</span>
                    <span class="badge-status status-published">Published</span>
                </div>
                <div class="action-buttons">
                    <a href="#" class="btn-action btn-edit" data-bs-toggle="modal" data-bs-target="#editBeritaModal" 
                       data-id="1" 
                       data-judul="Vaksinasi Massal COVID-19 di Kelurahan Citangkil"
                       data-kategori="berita"
                       data-isi="Pemerintah Kelurahan Citangkil mengadakan vaksinasi massal untuk warga agar tercipta kekebalan komunal dan mendukung program pemerintah pusat..."
                       data-gambar="https://placehold.co/600x400/008C6E/ffffff?text=Vaksinasi+Covid"
                       data-status="published">
                        <i class='bx bx-edit-alt'></i> Edit
                    </a>
                    <a href="#" class="btn-action btn-delete"><i class='bx bx-trash'></i> Hapus</a>
                </div>
            </div>
        </div>

        <div class="news-list-item">
            <img src="https://placehold.co/600x400/3b82f6/ffffff?text=Bantuan+Sosial" alt="Bansos" class="news-thumbnail">
            <div class="news-content-wrapper">
                <div class="news-header">
                    <h3>Pembagian Bantuan Sosial kepada Warga Kurang Mampu</h3>
                </div>
                <p class="news-excerpt">
                    Penyaluran bantuan sosial tahap ke-3 telah dilaksanakan di aula kelurahan dengan tertib dan lancar kepada 50 penerima manfaat yang terdata dalam DTKS...
                </p>
                <div class="news-meta-row">
                    <span class="meta-item"><i class='bx bx-calendar'></i> 2024-12-10</span>
                    <span class="meta-item"><i class='bx bx-user'></i> Admin</span>
                    <span class="badge-status status-published">Published</span>
                </div>
                <div class="action-buttons">
                    <a href="#" class="btn-action btn-edit" data-bs-toggle="modal" data-bs-target="#editBeritaModal" 
                       data-id="1" 
                       data-judul="Vaksinasi Massal COVID-19 di Kelurahan Citangkil"
                       data-kategori="berita"
                       data-isi="Pemerintah Kelurahan Citangkil mengadakan vaksinasi massal untuk warga agar tercipta kekebalan komunal dan mendukung program pemerintah pusat..."
                       data-gambar="https://placehold.co/600x400/008C6E/ffffff?text=Vaksinasi+Covid"
                       data-status="published">
                        <i class='bx bx-edit-alt'></i> Edit
                    </a>
                    <a href="#" class="btn-action btn-delete"><i class='bx bx-trash'></i> Hapus</a>
                </div>
            </div>
        </div>

        <div class="news-list-item">
            <img src="https://placehold.co/600x400/f59e0b/ffffff?text=Kerja+Bakti" alt="Kerja Bakti" class="news-thumbnail">
            <div class="news-content-wrapper">
                <div class="news-header">
                    <h3>Kegiatan Gotong Royong Bersama Warga RW 05</h3>
                </div>
                <p class="news-excerpt">
                    Rencana kegiatan kerja bakti membersihkan saluran air untuk antisipasi banjir di musim penghujan yang akan dilaksanakan akhir pekan ini...
                </p>
                <div class="news-meta-row">
                    <span class="meta-item"><i class='bx bx-calendar'></i> 2024-12-05</span>
                    <span class="meta-item"><i class='bx bx-user'></i> Admin</span>
                    <span class="badge-status status-draft">Draft</span>
                </div>
                <div class="action-buttons">
                    <a href="#" class="btn-action btn-edit" data-bs-toggle="modal" data-bs-target="#editBeritaModal" 
                       data-id="1" 
                       data-judul="Vaksinasi Massal COVID-19 di Kelurahan Citangkil"
                       data-kategori="berita"
                       data-isi="Pemerintah Kelurahan Citangkil mengadakan vaksinasi massal untuk warga agar tercipta kekebalan komunal dan mendukung program pemerintah pusat..."
                       data-gambar="https://placehold.co/600x400/008C6E/ffffff?text=Vaksinasi+Covid"
                       data-status="published">
                        <i class='bx bx-edit-alt'></i> Edit
                    </a>
                    <a href="#" class="btn-action btn-delete"><i class='bx bx-trash'></i> Hapus</a>
                </div>
            </div>
        </div>
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
<!-- Modal -->
<div class="modal fade" id="tambahBeritaModal" tabindex="-1" aria-labelledby="tambahBeritaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahBeritaModalLabel">Tambah Berita Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formTambahBerita">
                    <div class="mb-3">
                        <label for="judulBerita" class="form-label">Judul Berita</label>
                        <input type="text" class="form-control" id="judulBerita" required>
                    </div>
                    <div class="mb-3">
                        <label for="kategoriBerita" class="form-label">Kategori</label>
                        <select class="form-select" id="kategoriBerita" required>
                            <option value="">Pilih Kategori</option>
                            <option value="pengumuman">Pengumuman</option>
                            <option value="kegiatan">Kegiatan</option>
                            <option value="berita">Berita</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="gambarBerita" class="form-label">Gambar Utama</label>
                        <input class="form-control" type="file" id="gambarBerita" accept="image/*">
                    </div>
                    <div class="mb-3">
                        <label for="isiBerita" class="form-label">Isi Berita</label>
                        <textarea class="form-control" id="isiBerita" rows="5" required></textarea>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="terbitkanSekarang">
                        <label class="form-check-label" for="terbitkanSekarang">
                            Terbitkan Sekarang
                        </label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary">Simpan Berita</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Berita Modal -->
<div class="modal fade" id="editBeritaModal" tabindex="-1" aria-labelledby="editBeritaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editBeritaModalLabel">Edit Berita</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formEditBerita">
                    <input type="hidden" id="editId">
                    <div class="mb-3">
                        <label for="editJudulBerita" class="form-label">Judul Berita</label>
                        <input type="text" class="form-control" id="editJudulBerita" required>
                    </div>
                    <div class="mb-3">
                        <label for="editKategoriBerita" class="form-label">Kategori</label>
                        <select class="form-select" id="editKategoriBerita" required>
                            <option value="">Pilih Kategori</option>
                            <option value="pengumuman">Pengumuman</option>
                            <option value="kegiatan">Kegiatan</option>
                            <option value="berita">Berita</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editGambarBerita" class="form-label">Gambar Utama</label>
                        <input class="form-control" type="file" id="editGambarBerita" accept="image/*">
                        <small class="text-muted">Biarkan kosong jika tidak ingin mengubah gambar</small>
                        <div class="mt-2">
                            <img id="editGambarPreview" src="" alt="Preview" class="img-thumbnail" style="max-height: 150px; display: none;">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="editIsiBerita" class="form-label">Isi Berita</label>
                        <textarea class="form-control" id="editIsiBerita" rows="5" required></textarea>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="editTerbitkanSekarang">
                        <label class="form-check-label" for="editTerbitkanSekarang">
                            Terbitkan Sekarang
                        </label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" onclick="updateBerita()">Simpan Perubahan</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Inisialisasi modal jika diperlukan
    document.addEventListener('DOMContentLoaded', function() {
        // Inisialisasi tooltip jika diperlukan
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Inisialisasi text editor (contoh menggunakan textarea biasa)
        // Jika ingin menggunakan rich text editor, bisa diintegrasikan di sini
    });

    // Fungsi untuk menangani submit form
    function simpanBerita() {
        // Validasi form
        const form = document.getElementById('formTambahBerita');
        if (!form.checkValidity()) {
            form.classList.add('was-validated');
            return;
        }

        // Ambil data dari form
        const judul = document.getElementById('judulBerita').value;
        const kategori = document.getElementById('kategoriBerita').value;
        const isi = document.getElementById('isiBerita').value;
        const gambar = document.getElementById('gambarBerita').files[0];
        const terbitkan = document.getElementById('terbitkanSekarang').checked;

        // Buat form data untuk mengirim file
        const formData = new FormData();
        formData.append('judul', judul);
        formData.append('kategori', kategori);
        formData.append('isi', isi);
        formData.append('terbitkan', terbitkan);
        if (gambar) {
            formData.append('gambar', gambar);
        }

        // Kirim data ke server (contoh menggunakan fetch API)
        fetch('/admin/berita/simpan', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            // Tampilkan pesan sukses
            alert('Berita berhasil disimpan!');
            // Tutup modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('tambahBeritaModal'));
            modal.hide();
            // Refresh halaman atau update daftar berita
            location.reload();
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat menyimpan berita');
        });
    }
</script>
@endpush

<style>
    /* Style untuk modal */
    .modal-content {
        border: none;
        border-radius: 12px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    }
    
    .modal-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid #eee;
        border-radius: 12px 12px 0 0;
        padding: 1rem 1.25rem;
    }
    
    .modal-dialog {
        max-width: 600px;
    }
    
    .modal-body {
        padding: 1.25rem;
    }
    
    .modal-footer {
        border-top: 1px solid #eee;
        padding: 1.2rem 1.5rem;
        background-color: #f8f9fa;
        border-radius: 0 0 12px 12px;
    }
    
    .form-label {
        font-weight: 500;
        color: var(--text-dark);
        margin-bottom: 0.5rem;
    }
    
    .form-control, .form-select {
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 0.6rem 1rem;
        font-size: 0.95rem;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: var(--primary-green);
        box-shadow: 0 0 0 0.25rem rgba(0, 140, 110, 0.1);
    }
    
    .btn-close {
        background: none;
        opacity: 0.6;
        transition: opacity 0.2s;
    }
    
    .btn-close:hover {
        opacity: 1;
    }
    
    .btn-secondary {
        background-color: #6c757d;
        border: none;
        padding: 0.5rem 1.25rem;
        border-radius: 8px;
        font-weight: 500;
    }
    
    .btn-primary {
        background-color: var(--primary-green);
        border: none;
        padding: 0.5rem 1.25rem;
        border-radius: 8px;
        font-weight: 500;
    }
    
    .btn-primary:hover {
        background-color: #007d5e;
    }
    
    /* Style untuk preview gambar */
    .image-preview {
        width: 100%;
        height: 150px;
        border: 2px dashed #ddd;
        border-radius: 8px;
        margin-top: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        background-color: #f9f9f9;
    }
    
    .image-preview img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }
    
    .image-preview-text {
        color: #999;
        text-align: center;
        padding: 1rem;
    }
</style>

<script>
    // Preview gambar yang dipilih di form tambah
    document.getElementById('gambarBerita').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                let preview = document.querySelector('#tambahBeritaModal .image-preview');
                if (!preview) {
                    preview = document.createElement('div');
                    preview.className = 'image-preview';
                    document.querySelector('#tambahBeritaModal .modal-body').insertBefore(preview, document.getElementById('isiBerita').parentNode);
                }
                preview.innerHTML = `<img src="${e.target.result}" alt="Preview Gambar" class="img-fluid">`;
            }
            reader.readAsDataURL(file);
        }
    });

    // Preview gambar yang dipilih di form edit
    document.getElementById('editGambarBerita').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('editGambarPreview');
                preview.src = e.target.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(file);
        }
    });

    // Handle edit button click
    document.addEventListener('DOMContentLoaded', function() {
        const editButtons = document.querySelectorAll('.btn-edit');
        editButtons.forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const judul = this.getAttribute('data-judul');
                const kategori = this.getAttribute('data-kategori');
                const isi = this.getAttribute('data-isi');
                const gambar = this.getAttribute('data-gambar');
                const status = this.getAttribute('data-status');

                // Set values in the edit form
                document.getElementById('editId').value = id;
                document.getElementById('editJudulBerita').value = judul;
                document.getElementById('editKategoriBerita').value = kategori;
                document.getElementById('editIsiBerita').value = isi;
                document.getElementById('editTerbitkanSekarang').checked = status === 'published';
                
                // Set image preview
                const preview = document.getElementById('editGambarPreview');
                if (gambar) {
                    preview.src = gambar;
                    preview.style.display = 'block';
                } else {
                    preview.style.display = 'none';
                }
            });
        });
    });

    // Function to update news
    function updateBerita() {
        // Get form data
        const formData = new FormData();
        formData.append('id', document.getElementById('editId').value);
        formData.append('judul', document.getElementById('editJudulBerita').value);
        formData.append('kategori', document.getElementById('editKategoriBerita').value);
        formData.append('isi', document.getElementById('editIsiBerita').value);
        formData.append('terbitkan', document.getElementById('editTerbitkanSekarang').checked);
        
        const gambar = document.getElementById('editGambarBerita').files[0];
        if (gambar) {
            formData.append('gambar', gambar);
        }

        // Here you would typically send this data to your server
        // Example using fetch:
        fetch('/admin/berita/update', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            // Handle success
            alert('Berita berhasil diperbarui!');
            // Close modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('editBeritaModal'));
            modal.hide();
            // Refresh the page or update the news list
            location.reload();
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat memperbarui berita');
        });
    }
</script>
@endsection
