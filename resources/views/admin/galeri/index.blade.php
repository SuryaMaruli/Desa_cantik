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
        flex-wrap: wrap;
        gap: 8px;
    }
    
    .card-actions {
        display: flex;
        gap: 8px;
    }
    
    .btn-edit, .btn-delete {
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 12px;
        border: none;
        cursor: pointer;
        transition: 0.2s;
    }
    
    .btn-edit {
        background: #e3f2fd;
        color: #1976d2;
    }
    
    .btn-edit:hover {
        background: #bbdefb;
        color: #1565c0;
    }
    
    .btn-delete {
        background: #ffebee;
        color: #d32f2f;
    }
    
    .btn-delete:hover {
        background: #ffcdd2;
        color: #c62828;
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
    <!-- Session Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
            <i class='bx bx-check-circle me-2'></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
            <i class='bx bx-error-circle me-2'></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-warning alert-dismissible fade show mb-3" role="alert">
            <i class='bx bx-error me-2'></i>
            <strong>Perhatian!</strong> Mohon perbaiki kesalahan berikut:
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
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
        @forelse($galeri as $item)
        <div class="gallery-card">
            <div class="image-placeholder">
                <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->judul_foto }}">
            </div>
            <div class="card-title">{{ $item->judul_foto }}</div>
            @if($item->deskripsi)
            <div class="card-description text-muted small mb-2">{{ Str::limit($item->deskripsi, 80) }}</div>
            @endif
            <div class="card-footer">
                <div class="card-info">
                    <span class="tag-badge tag-{{ $item->kategori }}">{{ ucfirst($item->kategori) }}</span>
                    <span class="date-text">{{ is_string($item->tanggal_kegiatan) ? \Carbon\Carbon::parse($item->tanggal_kegiatan)->format('d M Y') : $item->tanggal_kegiatan->format('d M Y') }}</span>
                </div>
                <div class="card-actions">
                    <button type="button" class="btn-edit" data-bs-toggle="modal" data-bs-target="#editFotoModal{{ $item->id_galeri }}" title="Edit Foto">
                        <i class='bx bx-edit'></i>
                    </button>
                    <form action="{{ route('admin.galeri.destroy', $item->id_galeri) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-delete" onclick="return confirm('Apakah Anda yakin ingin menghapus foto ini?')" title="Hapus Foto">
                            <i class='bx bx-trash'></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="text-center py-5">
                <i class='bx bx-image display-1 text-muted'></i>
                <h4 class="text-muted mt-3">Belum ada foto</h4>
                <p class="text-muted">Mulai dengan menambahkan foto pertama Anda</p>
            </div>
        </div>
        @endforelse
    </div>
    
    <!-- Edit Modals -->
    @foreach($galeri as $item)
    <!-- Modal Edit Foto -->
    <div class="modal fade" id="editFotoModal{{ $item->id_galeri }}" tabindex="-1" aria-labelledby="editFotoModalLabel{{ $item->id_galeri }}" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="editFotoModalLabel{{ $item->id_galeri }}">
                        <i class='bx bx-edit me-2'></i>Edit Foto
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.galeri.update', $item->id_galeri) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="edit_judul_foto_{{ $item->id_galeri }}" class="form-label fw-medium">Judul Foto <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-lg" id="edit_judul_foto_{{ $item->id_galeri }}" name="judul_foto" value="{{ $item->judul_foto }}" required>
                                    <div class="form-text">Masukkan judul yang deskriptif untuk foto Anda</div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="edit_deskripsi_{{ $item->id_galeri }}" class="form-label fw-medium">Deskripsi (Opsional)</label>
                                    <textarea class="form-control" id="edit_deskripsi_{{ $item->id_galeri }}" name="deskripsi" rows="3" placeholder="Tambahkan deskripsi singkat tentang foto ini">{{ $item->deskripsi ?? '' }}</textarea>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="edit_kategori_{{ $item->id_galeri }}" class="form-label fw-medium">Kategori <span class="text-danger">*</span></label>
                                            <select class="form-select" id="edit_kategori_{{ $item->id_galeri }}" name="kategori" required>
                                                <option value="" disabled>Pilih Kategori</option>
                                                <option value="kesehatan" {{ $item->kategori == 'kesehatan' ? 'selected' : '' }}>Kesehatan</option>
                                                <option value="sosial" {{ $item->kategori == 'sosial' ? 'selected' : '' }}>Sosial</option>
                                                <option value="lingkungan" {{ $item->kategori == 'lingkungan' ? 'selected' : '' }}>Lingkungan</option>
                                                <option value="ekonomi" {{ $item->kategori == 'ekonomi' ? 'selected' : '' }}>Ekonomi</option>
                                                <option value="budaya" {{ $item->kategori == 'budaya' ? 'selected' : '' }}>Budaya</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="edit_tanggal_kegiatan_{{ $item->id_galeri }}" class="form-label fw-medium">Tanggal Kegiatan</label>
                                            <input type="date" class="form-control" id="edit_tanggal_kegiatan_{{ $item->id_galeri }}" name="tanggal_kegiatan" value="{{ is_string($item->tanggal_kegiatan) ? \Carbon\Carbon::parse($item->tanggal_kegiatan)->format('Y-m-d') : $item->tanggal_kegiatan->format('Y-m-d') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="upload-area p-4 border rounded-3 text-center">
                                    <div id="editImagePreview{{ $item->id_galeri }}" class="mb-3" style="min-height: 150px; display: flex; align-items: center; justify-content: center; background: #f8f9fa; border-radius: 8px;">
                                        <img src="{{ asset('storage/' . $item->foto) }}" class="img-fluid rounded" alt="Current image" style="max-height: 150px; object-fit: cover;">
                                    </div>
                                    <div class="mb-3">
                                        <label for="edit_foto_{{ $item->id_galeri }}" class="btn btn-outline-primary w-100">
                                            <i class='bx bx-upload me-2'></i>Ganti Gambar
                                            <input type="file" class="d-none" id="edit_foto_{{ $item->id_galeri }}" name="foto" accept="image/*">
                                        </label>
                                        <div class="form-text text-center mt-2">Format: JPG, PNG, atau GIF (Maks. 5MB)<br>Kosongkan jika tidak ingin mengubah foto</div>
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
                            <i class='bx bx-save me-1'></i> Update Foto
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach
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
            <form action="{{ route('admin.galeri.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="judul_foto" class="form-label fw-medium">Judul Foto <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-lg" id="judul_foto" name="judul_foto" placeholder="Contoh: Kegiatan Vaksinasi 2024" required>
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
                                        <label for="tanggal_kegiatan" class="form-label fw-medium">Tanggal Kegiatan</label>
                                        <input type="date" class="form-control" id="tanggal_kegiatan" name="tanggal_kegiatan" value="{{ date('Y-m-d') }}">
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
                                    <label for="foto" class="btn btn-outline-primary w-100">
                                        <i class='bx bx-upload me-2'></i>Pilih Gambar
                                        <input type="file" class="d-none" id="foto" name="foto" accept="image/*" required>
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
        // Preview gambar yang diunggah untuk form tambah
        document.getElementById('foto').addEventListener('change', function(e) {
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

        // Preview gambar untuk form edit
        @foreach($galeri as $item)
        document.getElementById('edit_foto_{{ $item->id_galeri }}').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('editImagePreview{{ $item->id_galeri }}').innerHTML = 
                        `<img src="${e.target.result}" class="img-fluid rounded" alt="Preview" style="max-height: 150px; object-fit: cover;">`;
                }
                reader.readAsDataURL(file);
            }
        });
        @endforeach

        // Reset form ketika modal ditutup
        document.getElementById('tambahFotoModal').addEventListener('hidden.bs.modal', function () {
            document.querySelector('#tambahFotoModal form').reset();
            document.getElementById('imagePreview').innerHTML = `
                <div class="text-center">
                    <i class='bx bx-image-add display-4 text-muted mb-2'></i>
                    <p class="mb-0 text-muted">Pratinjau gambar akan muncul di sini</p>
                </div>
            `;
        });

        // Reset form edit ketika modal ditutup
        @foreach($galeri as $item)
        document.getElementById('editFotoModal{{ $item->id_galeri }}').addEventListener('hidden.bs.modal', function () {
            document.getElementById('editImagePreview{{ $item->id_galeri }}').innerHTML = 
                `<img src="{{ asset('storage/' . $item->foto) }}" class="img-fluid rounded" alt="Current image" style="max-height: 150px; object-fit: cover;">`;
        });
        @endforeach
    });
</script>
@endpush
@endsection
