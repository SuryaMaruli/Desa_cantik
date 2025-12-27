@extends('layouts.admin')

@section('page-title', 'Galeri Foto')

@push('styles')
<style>
    /* --- 1. RESET & GLOBAL --- */
    * { box-sizing: border-box; }
    body { background-color: #fcfcfc; min-height: 100vh; }
    :root {
        --sidebar-bg: #005740;     
        --sidebar-active: #0b755b; 
        --header-height: 80px;
        --sidebar-width: 260px;
        --text-dark: #333;
        --primary-green: #008C6E;
    }

    /* --- 2. SIDEBAR --- */
    .sidebar {
        background: var(--sidebar-bg) !important;
    }
    .sidebar ul li a:hover, 
    .sidebar ul li a.active { 
        background: var(--sidebar-active) !important; 
    }

    /* --- 3. MAIN CONTENT --- */
    .home-content { 
        padding: 30px; 
        background-color: #fcfcfc;
        min-height: calc(100vh - var(--header-height));
    }

    /* --- 4. KONTEN KHUSUS GALERI --- */
    /* A. Header Section */
    .gallery-header-card {
        background: #fff; 
        border-radius: 12px; 
        padding: 25px 30px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.02); 
        border: 1px solid #eee;
        display: flex; 
        justify-content: space-between; 
        align-items: center;
        margin-bottom: 30px;
    }
    .header-text h3 { 
        font-size: 20px; 
        font-weight: 600; 
        color: #333; 
        margin-bottom: 5px; 
    }
    .header-text p { 
        font-size: 14px; 
        color: #666; 
    }
    
    .btn-add-photo {
        background-color: #009669; 
        color: white; 
        padding: 10px 20px; 
        border-radius: 8px;
        text-decoration: none; 
        display: flex; 
        align-items: center; 
        gap: 8px; 
        font-size: 14px; 
        font-weight: 500;
        transition: 0.3s;
        border: none;
        cursor: pointer;
    }
    .btn-add-photo:hover { 
        background-color: #007d57; 
        color: white;
    }

    /* B. Grid Galeri (3 Kolom) */
    .gallery-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 25px;
    }

    .gallery-card {
        background: #fff; 
        border-radius: 16px; 
        padding: 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.02); 
        border: 1px solid #eee;
        display: flex; 
        flex-direction: column;
        transition: transform 0.2s;
    }
    .gallery-card:hover { 
        transform: translateY(-5px); 
        box-shadow: 0 5px 15px rgba(0,0,0,0.05); 
    }

    .image-placeholder {
        width: 100%; 
        height: 200px; 
        background-color: #f3f4f6; 
        border-radius: 12px;
        margin-bottom: 15px;
        overflow: hidden;
    }
    .image-placeholder img {
        width: 100%; 
        height: 100%; 
        object-fit: cover;
    }

    .card-title { 
        font-size: 16px; 
        font-weight: 600; 
        color: #333; 
        margin-bottom: 12px; 
        line-height: 1.4;
    }

    .card-footer {
        display: flex; 
        justify-content: space-between; 
        align-items: center; 
        margin-top: auto;
    }
    
    .date-text { 
        font-size: 12px; 
        color: #888; 
    }

    /* Tags Kategori */
    .tag-badge { 
        padding: 5px 12px; 
        border-radius: 20px; 
        font-size: 11px; 
        font-weight: 600; 
    }
    
    .tag-kesehatan { background: #d1fae5; color: #047857; }   /* Hijau */
    .tag-sosial { background: #dbeafe; color: #1e40af; }       /* Biru */
    .tag-lingkungan { background: #ccfbf1; color: #0f766e; }   /* Tosca */
    .tag-ekonomi { background: #fef3c7; color: #b45309; }      /* Kuning/Orange */
    .tag-budaya { background: #f3e8ff; color: #7e22ce; }       /* Ungu */

    /* Responsive */
    @media (max-width: 1024px) {
        .gallery-grid { 
            grid-template-columns: repeat(2, 1fr); 
        }
    }
    
    @media (max-width: 768px) {
        .gallery-grid { 
            grid-template-columns: 1fr; 
        }
        .gallery-header-card { 
            flex-direction: column; 
            align-items: flex-start; 
            gap: 15px; 
        }
    }
</style>
@endpush

@section('content')
<div class="home-content">
    <div class="gallery-header-card">
        <div class="header-text">
            <h3>Galeri Foto</h3>
            <p>Total: {{ count($galeri) }} foto</p>
        </div>
        <button type="button" class="btn-add-photo" data-bs-toggle="modal" data-bs-target="#tambahFotoModal">
            <i class='bx bx-plus'></i> Tambah Foto
        </button>
    </div>

    <div class="gallery-grid">
        @foreach($galeri as $item)
        <div class="gallery-card">
            <div class="image-placeholder">
                <img src="{{ $item['gambar'] }}" alt="{{ $item['judul'] }}">
            </div>
            <div class="card-title">{{ $item['judul'] }}</div>
            <div class="card-footer">
                <span class="tag-badge tag-{{ $item['kategori'] }}">{{ $item['kategori_label'] }}</span>
                <span class="date-text">{{ $item['tanggal'] }}</span>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Modal Tambah Foto -->
<div class="modal fade" id="tambahFotoModal" tabindex="-1" aria-labelledby="tambahFotoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="tambahFotoModalLabel">
                    <i class='bx bx-image-add me-2'></i>Unggah Foto Baru
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formTambahFoto" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="judul" class="form-label fw-medium">Judul Foto <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-lg" id="judul" name="judul" placeholder="Contoh: Kegiatan Vaksinasi 2024" required>
                                <div class="form-text">Masukkan judul yang deskriptif untuk foto Anda</div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="deskripsi" class="form-label fw-medium">Deskripsi (Opsional)</label>
                                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" placeholder="Tambahkan deskripsi singkat tentang foto ini"></textarea>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="kategori" class="form-label fw-medium">Kategori <span class="text-danger">*</span></label>
                                        <select class="form-select" id="kategori" name="kategori" required>
                                            <option value="" disabled selected>Pilih Kategori</option>
                                            <option value="kesehatan">Kesehatan</option>
                                            <option value="sosial">Sosial</option>
                                            <option value="lingkungan">Lingkungan</option>
                                            <option value="ekonomi">Ekonomi</option>
                                            <option value="budaya">Budaya</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="tanggal" class="form-label fw-medium">Tanggal Kegiatan</label>
                                        <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ date('Y-m-d') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="upload-area p-4 border rounded-3 text-center">
                                <div id="imagePreview" class="mb-3" style="min-height: 150px; display: flex; align-items: center; justify-content: center; background: #f8f9fa; border-radius: 8px;">
                                    <div class="text-center">
                                        <i class='bx bx-image-add display-4 text-muted mb-2'></i>
                                        <p class="mb-0 text-muted">Pratinjau gambar akan muncul di sini</p>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="gambar" class="btn btn-outline-primary w-100">
                                        <i class='bx bx-upload me-2'></i>Pilih Gambar
                                        <input type="file" class="d-none" id="gambar" name="gambar" accept="image/*" required>
                                    </label>
                                    <div class="form-text text-center mt-2">Format: JPG, PNG, atau GIF (Maks. 5MB)</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top-0 bg-light">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                        <i class='bx bx-x me-1'></i> Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class='bx bx-save me-1'></i> Simpan Foto
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inisialisasi tooltip
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
          return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Inisialisasi modal
        var tambahFotoModal = new bootstrap.Modal(document.getElementById('tambahFotoModal'));
        
        // Preview gambar yang diunggah
        document.getElementById('gambar').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('imagePreview').innerHTML = 
                        `<img src="${e.target.result}" class="img-fluid rounded" alt="Preview">`;
                }
                reader.readAsDataURL(file);
            }
        });

        // Handle form submission
        document.getElementById('formTambahFoto').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Show loading state
            const submitBtn = document.querySelector('#formTambahFoto button[type="submit"]');
            const originalBtnText = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Menyimpan...';
            
            // Simulate API call (ganti dengan kode AJAX sebenarnya)
            setTimeout(() => {
                // Reset form
                this.reset();
                document.getElementById('imagePreview').innerHTML = '';
                
                // Show success message
                const alertDiv = document.createElement('div');
                alertDiv.className = 'alert alert-success alert-dismissible fade show';
                alertDiv.role = 'alert';
                alertDiv.innerHTML = `
                    <strong>Berhasil!</strong> Foto baru berhasil ditambahkan.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                `;
                document.querySelector('.home-content').insertBefore(alertDiv, document.querySelector('.gallery-header-card'));
                
                // Hide modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('tambahFotoModal'));
                modal.hide();
                
                // Reset button state
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnText;
                
                // Auto-hide alert after 5 seconds
                setTimeout(() => {
                    alertDiv.classList.remove('show');
                    setTimeout(() => alertDiv.remove(), 150);
                }, 5000);
                
            }, 1500);
        });

        // Reset form when modal is closed
        document.getElementById('tambahFotoModal').addEventListener('hidden.bs.modal', function () {
            document.getElementById('formTambahFoto').reset();
            document.getElementById('imagePreview').innerHTML = '';
        });
    });
</script>
@endpush
@endsection
