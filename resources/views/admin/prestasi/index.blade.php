@extends('layouts.admin')

@section('title', 'Prestasi - Admin Kelurahan Citangkil')
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
        grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
        gap: 25px;
    }
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
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                <i class="fas fa-times"></i>
            </button>
        </div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                <i class="fas fa-times"></i>
            </button>
        </div>
    @endif

    <div class="page-header">
        <div class="header-content">
            <h1>Manajemen Prestasi</h1>
            <p>Kelola data prestasi dan penghargaan Kelurahan Citangkil</p>
        </div>
        <button class="btn-add" id="openModalBtn">
            <i class="fa-solid fa-plus"></i> Tambah Prestasi
        </button>
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
                <div class="card-meta">
                    <span><i class="fa-regular fa-calendar"></i> {{ $item['tahun'] }}</span>
                    <span>&bull;</span>
                    <span>{{ $item['tanggal']->format('d M Y') }}</span>
                </div>
            </div>
            <div class="card-actions">
                <button class="btn-action btn-edit" onclick="openEditModal({{ $item['id'] }}, '{{ $item['judul'] }}', '{{ $item['peringkat'] }}', '{{ $item['tingkat'] }}', '{{ $item['penyelenggara'] ?? '' }}', '{{ $item['tahun'] }}', '{{ $item['deskripsi'] }}', '{{ $item['tanggal']->format('Y-m-d') }}')">
                    <i class="fa-regular fa-pen-to-square"></i> Edit
                </button>
                <form action="{{ route('admin.prestasi.destroy', $item['id']) }}" method="POST" style="display: inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus prestasi ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-action btn-delete">
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
                <button class="btn-add" onclick="document.getElementById('openModalBtn').click()">
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
        <form action="{{ route('admin.prestasi.store') }}" method="POST">
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
        <form id="editForm" method="POST">
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

            <div class="modal-footer">
                <button type="submit" class="btn-modal btn-save">Update</button>
                <button type="button" class="btn-modal btn-cancel" id="closeEditModalBtn">Batal</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Modal Tambah
    const modal = document.getElementById('addModal');
    const openBtn = document.getElementById('openModalBtn');
    const closeBtn = document.getElementById('closeModalBtn');

    // Modal Edit
    const editModal = document.getElementById('editModal');
    const closeEditBtn = document.getElementById('closeEditModalBtn');

    // Fungsi Buka Modal Tambah
    openBtn.addEventListener('click', () => {
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
    });
</script>

@endsection
