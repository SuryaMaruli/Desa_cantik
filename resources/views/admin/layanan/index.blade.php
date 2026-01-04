@extends('layouts.admin')

@section('title', 'Layanan - Admin Kelurahan Citangkil')
@section('page-title', 'Layanan')

@section('content')
<div class="container-fluid">
    <div class="container">
        
        <div class="card header-card">
            <div class="header-content">
                <div class="header-text">
                    <h2>Manajemen Layanan</h2>
                    <p>Kelola layanan-layanan kelurahan</p>
                </div>
                <button class="btn btn-primary" id="addServiceBtn">
                    <i class="fa-solid fa-plus"></i> Tambah Layanan
                </button>
            </div>
        </div>

        <div class="card">
            <h3 class="section-title">Layanan Kependudukan</h3>
            
            <div class="service-item">
                <div class="service-header">
                    <div class="service-name">Kartu Tanda Penduduk (KTP)</div>
                    <div class="actions">
                        <button class="icon-btn btn-edit"><i class="fa-solid fa-pen-to-square"></i></button>
                        <button class="icon-btn btn-delete"><i class="fa-solid fa-trash-can"></i></button>
                    </div>
                </div>
                <span class="requirements-label">Persyaratan:</span>
                <ul class="requirements-list">
                    <li>Surat Pengantar RT/RW</li>
                    <li>Kartu Keluarga Asli</li>
                    <li>Akta Kelahiran</li>
                </ul>
            </div>
        </div>

        <div class="card">
            <h3 class="section-title">Layanan Permintaan Data</h3>
            
            <div class="service-item">
                <div class="service-header">
                    <div class="service-name">Permohonan Data Statistik Warga</div>
                    <div class="actions">
                        <button class="icon-btn btn-edit"><i class="fa-solid fa-pen-to-square"></i></button>
                        <button class="icon-btn btn-delete"><i class="fa-solid fa-trash-can"></i></button>
                    </div>
                </div>
                <span class="requirements-label">Persyaratan:</span>
                <ul class="requirements-list">
                    <li>Surat Permohonan Resmi</li>
                    <li>Identitas Pemohon (KTP)</li>
                    <li>Tujuan Penggunaan Data</li>
                </ul>
            </div>
        </div>

    </div>

    <div class="modal-overlay" id="serviceModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Tambah Layanan Baru</h3>
                <button class="close-modal" id="closeModalIcon"><i class="fa-solid fa-xmark"></i></button>
            </div>
            
            <form id="addServiceForm">
                <div class="form-group">
                    <label for="serviceName">Nama Layanan</label>
                    <input type="text" id="serviceName" class="form-control" placeholder="Nama Layanan..." required>
                </div>

                <div class="form-group">
                    <label for="serviceCategory">Kategori</label>
                    <select id="serviceCategory" class="form-control">
                        <option value="kependudukan">Layanan Kependudukan</option>
                        <option value="data">Layanan Permintaan Data</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="requirements">Persyaratan</label>
                    <textarea id="requirements" class="form-control" rows="4" placeholder="Masukkan persyaratan dipisahkan baris baru..."></textarea>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="cancelBtn">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
    /* --- RESET & BASIC STYLES --- */
    .container { max-width: 900px; margin: 0 auto; }

    /* --- CARD COMPONENT --- */
    .card {
        background-color: #ffffff;
        border-radius: 16px;
        padding: 24px 30px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
        margin-bottom: 24px;
        border: 1px solid #eef0f2;
    }

    /* --- HEADER --- */
    .header-content { display: flex; justify-content: space-between; align-items: center; }
    .header-card { display: block; }
    .header-text h2 { font-size: 1.25rem; color: #2d3748; margin-bottom: 6px; }
    .header-text p { color: #718096; font-size: 0.9rem; }

    /* --- BUTTONS --- */
    .btn { padding: 10px 20px; border-radius: 8px; border: none; cursor: pointer; font-weight: 500; font-size: 0.9rem; display: inline-flex; align-items: center; gap: 8px; transition: opacity 0.2s; }
    .btn:hover { opacity: 0.9; }
    .btn-primary { background-color: #00a65a; color: white; }

    /* --- CONTENT ITEMS --- */
    .section-title { font-size: 1.1rem; margin-bottom: 20px; color: #2d3748; font-weight: 700; }
    
    .service-item {
        background-color: #fcfcfc;
        border-radius: 12px;
        padding: 20px;
        border: 1px solid #f0f0f0;
    }

    .service-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 10px; }
    .service-name { font-weight: 600; font-size: 1rem; color: #2d3748; }

    .actions { display: flex; gap: 10px; }
    .icon-btn { width: 32px; height: 32px; border-radius: 6px; display: flex; align-items: center; justify-content: center; border: none; cursor: pointer; font-size: 0.85rem; }
    .btn-edit { background-color: #e6f6ff; color: #007bff; }
    .btn-delete { background-color: #ffeef0; color: #dc3545; }

    /* REQUIREMENTS LIST */
    .requirements-label { display: block; font-size: 0.9rem; color: #4a5568; margin-bottom: 5px; font-weight: 500;}
    .requirements-list { list-style: none; padding-left: 10px; }
    .requirements-list li { color: #718096; font-size: 0.9rem; margin-bottom: 4px; position: relative; padding-left: 15px; }
    .requirements-list li::before { content: ""; position: absolute; left: 0; top: 8px; width: 4px; height: 4px; background-color: #a0aec0; border-radius: 50%; }

    /* --- MODAL --- */
    .modal-overlay { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); z-index: 1000; justify-content: center; align-items: center; animation: fadeIn 0.3s; }
    .modal-content { background-color: white; padding: 30px; border-radius: 16px; width: 100%; max-width: 500px; box-shadow: 0 4px 20px rgba(0,0,0,0.15); animation: slideUp 0.3s; }
    .modal-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
    .close-modal { background: none; border: none; font-size: 1.2rem; cursor: pointer; color: #a0aec0; }
    
    .form-group { margin-bottom: 15px; }
    .form-group label { display: block; margin-bottom: 8px; font-size: 0.9rem; color: #4a5568; font-weight: 500; }
    .form-control { width: 100%; padding: 10px 12px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 0.95rem; outline: none; }
    .form-control:focus { border-color: #00a65a; }
    
    .modal-footer { display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px; }
    .btn-secondary { background-color: #e2e8f0; color: #4a5568; }

    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    @keyframes slideUp { from { transform: translateY(20px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
</style>
@endpush

@push('scripts')
<script>
    // Logika Javascript untuk Modal
    const modal = document.getElementById('serviceModal');
    const openBtn = document.getElementById('addServiceBtn');
    const closeIcon = document.getElementById('closeModalIcon');
    const cancelBtn = document.getElementById('cancelBtn');
    const form = document.getElementById('addServiceForm');

    openBtn.addEventListener('click', () => modal.style.display = 'flex');

    const closeModal = () => modal.style.display = 'none';
    closeIcon.addEventListener('click', closeModal);
    cancelBtn.addEventListener('click', closeModal);
    window.addEventListener('click', (e) => { if (e.target === modal) closeModal(); });

    form.addEventListener('submit', (e) => {
        e.preventDefault();
        const name = document.getElementById('serviceName').value;
        const category = document.getElementById('serviceCategory').options[document.getElementById('serviceCategory').selectedIndex].text;
        
        alert(`Berhasil menambahkan "${name}" ke kategori "${category}" (Mode Demo)`);
        closeModal();
        form.reset();
    });
</script>
@endpush
