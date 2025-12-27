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
        <button class="btn-add-photo" data-bs-toggle="modal" data-bs-target="#tambahFotoModal">
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
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahFotoModalLabel">Tambah Foto Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formTambahFoto">
                    <div class="mb-3">
                        <label for="judul" class="form-label">Judul Foto</label>
                        <input type="text" class="form-control" id="judul" required>
                    </div>
                    <div class="mb-3">
                        <label for="kategori" class="form-label">Kategori</label>
                        <select class="form-select" id="kategori" required>
                            <option value="">Pilih Kategori</option>
                            <option value="kesehatan">Kesehatan</option>
                            <option value="sosial">Sosial</option>
                            <option value="lingkungan">Lingkungan</option>
                            <option value="ekonomi">Ekonomi</option>
                            <option value="budaya">Budaya</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="gambar" class="form-label">Unggah Gambar</label>
                        <input class="form-control" type="file" id="gambar" accept="image/*" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" form="formTambahFoto" class="btn btn-primary">Simpan</button>
            </div>
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

        // Handle form submission
        document.getElementById('formTambahFoto').addEventListener('submit', function(e) {
            e.preventDefault();
            // Add your form submission logic here
            alert('Foto berhasil ditambahkan!');
            var tambahFotoModal = bootstrap.Modal.getInstance(document.getElementById('tambahFotoModal'));
            tambahFotoModal.hide();
        });
    });
</script>
@endpush
@endsection
