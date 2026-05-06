@extends('layouts.admin')

@section('title', 'Monografi Kelurahan')
@section('page-title', 'Monografi')

@section('content')

{{-- 1. CSS STYLES --}}
<style>
    /* --- RESET CSS & LAYOUT --- */
    * { margin: 0; padding: 0; box-sizing: border-box; }
    .main-container { max-width: 1000px; margin: 0 auto; }
    
    /* --- CARD & HEADER --- */
    .card { background: white; border-radius: 12px; padding: 24px 30px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05); margin-bottom: 30px; }
    .header-content { display: flex; justify-content: space-between; align-items: center; width: 100%; }
    .header-text h1 { font-size: 24px; font-weight: 600; color: #1e293b; margin-bottom: 6px; }
    .header-text p { color: #64748b; font-size: 14px; margin: 0; }

    /* --- BUTTONS --- */
    .btn { border: none; padding: 10px 16px; border-radius: 6px; font-family: 'Inter', sans-serif; font-weight: 500; cursor: pointer; font-size: 14px; display: inline-flex; align-items: center; gap: 8px; transition: opacity 0.2s; }
    .btn:hover { opacity: 0.9; }
    .btn-add { background-color: #f34f00; color: white; font-weight: 600; padding: 12px 20px; box-shadow: 0 2px 5px rgba(243, 79, 0, 0.3); }
    .btn-edit { background-color: #f35800; color: white; }
    .btn-delete { background-color: #e60000; color: white; }

    /* --- TABLE --- */
    .table-container { background: white; border-radius: 12px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05); overflow: hidden; border: 1px solid #e0e0e0; }
    .table-header { background-color: #f58e3e; display: flex; padding: 15px 20px; color: white; font-weight: 600; font-size: 13px; letter-spacing: 0.5px; text-transform: uppercase; align-items: center; border-bottom: 2px solid #e67e22; }
    .table-row { background-color: white; display: flex; padding: 20px; align-items: center; border-bottom: 1px solid #e0e0e0; }
    .table-row:last-child { border-bottom: none; }

    /* --- COLUMNS --- */
    .col { padding: 0 10px; }
    .col-no { width: 60px; font-weight: 500; text-align: center; border-right: 1px solid #f0f0f0; }
    .col-img { flex: 1; display: flex; justify-content: center; }
    .col-action { width: 200px; display: flex; justify-content: flex-end; gap: 10px; }

    /* --- THUMBNAILS --- */
    .img-wrapper { width: 100%; max-width: 220px; height: 120px; border-radius: 8px; overflow: hidden; border: 2px solid #e0e0e0; background: #fafafa; }
    .img-wrapper img { width: 100%; height: 100%; object-fit: cover; display: block; }

    /* --- RESPONSIVE --- */
    @media (max-width: 768px) {
        .card { flex-direction: column; align-items: flex-start; gap: 15px; }
        .table-header { display: none; }
        .table-row { flex-direction: column; align-items: flex-start; gap: 15px; border: 1px solid #ddd; margin-bottom: 10px; }
        .col, .col-action { width: 100%; padding: 0; justify-content: flex-start; }
        .img-wrapper { height: 180px; }
    }

    /* --- MODAL --- */
    .modal-overlay { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); z-index: 1000; justify-content: center; align-items: center; }
    .modal-content { background: white; border-radius: 12px; width: 90%; max-width: 600px; max-height: 90vh; overflow-y: auto; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3); }
    .modal-header { background: #f58e3e; color: white; padding: 20px 24px; border-radius: 12px 12px 0 0; display: flex; justify-content: space-between; align-items: center; }
    .modal-header h3 { margin: 0; font-size: 18px; font-weight: 600; }
    .close-modal { background: none; border: none; color: white; font-size: 24px; cursor: pointer; }
    .modal-body { padding: 24px; }
    .form-group { margin-bottom: 20px; }
    .form-group label { display: block; margin-bottom: 8px; font-weight: 500; color: #333; }
    .file-upload { position: relative; display: flex; flex-direction: column; align-items: center; padding: 30px; border: 2px dashed #ddd; border-radius: 8px; background: #f9f9f9; cursor: pointer; transition: all 0.2s; }
    .file-upload:hover { border-color: #f58e3e; background: #fff5f0; }
    .file-upload input[type="file"] { position: absolute; opacity: 0; width: 100%; height: 100%; cursor: pointer; }
    .file-upload i { font-size: 48px; color: #f58e3e; margin-bottom: 15px; }
    .modal-footer { padding: 20px 24px; border-top: 1px solid #eee; display: flex; justify-content: flex-end; gap: 10px; }
    .btn-cancel { background: #6c757d; color: white; }
    .btn-save { background: #f34f00; color: white; font-weight: 600; }
    .current-image img { max-width: 150px; max-height: 100px; border-radius: 4px; border: 1px solid #ddd; margin-top: 5px; }
</style>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<div class="main-container">
    
    {{-- HEADER --}}
    <div class="card header-card">
        <div class="header-content">
            <div class="header-text">
                <h1>Monografi Kelurahan</h1>
                <p>Kelola gambar monografi dan struktur organisasi</p>
            </div>
            <button class="btn btn-add" onclick="openModal()">
                <i class="fas fa-plus"></i> Tambah Data
            </button>
        </div>
    </div>

    {{-- TABLE DATA --}}
    <div class="table-container">
        <div class="table-header">
            <div class="col col-no">NO</div>
            <div class="col col-img">GAMBAR MONOGRAFI</div>
            <div class="col col-img">GAMBAR STRUKTUR</div>
            <div class="col col-action">AKSI</div>
        </div>

        @if(isset($monografis) && $monografis->count() > 0)
            @foreach($monografis as $index => $monografi)
            <div class="table-row">
                <div class="col col-no">{{ $index + 1 }}</div>
                
                <div class="col col-img">
                    <div class="img-wrapper">
                        {{-- Menggunakan URL yang sudah di-generate di Controller --}}
                        <img src="{{ $monografi->gambar_mono_url }}" alt="Monografi">
                    </div>
                </div>
                
                <div class="col col-img">
                    <div class="img-wrapper">
                        <img src="{{ $monografi->gambar_struktur_url }}" alt="Struktur">
                    </div>
                </div>
                
                <div class="col col-action buttons">
    {{-- Ubah $monografi->id menjadi $monografi->id_monografi --}}
    
    <button class="btn btn-edit" onclick="openEditModal({{ $monografi->id_monografi }})">
        <i class="far fa-edit"></i> Edit
    </button>
    
    <button class="btn btn-delete" onclick="deleteMonografi({{ $monografi->id_monografi }}, event)">
        <i class="fas fa-trash"></i> Hapus
    </button>
</div>
            </div>
            @endforeach
        @else
            <div class="table-row" style="justify-content: center; padding: 40px;">
                <div style="text-align: center; color: #666;">
                    <i class="fas fa-inbox" style="font-size: 48px; margin-bottom: 15px; color: #ccc;"></i>
                    <p style="margin: 0; font-size: 16px;">Belum ada data monografi</p>
                </div>
            </div>
        @endif
    </div>
</div>

{{-- 2. MODAL TAMBAH (ADD) --}}
<div class="modal-overlay" id="addModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Tambah Data Monografi</h3>
            <button class="close-modal" onclick="closeModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <form id="addForm" enctype="multipart/form-data">
            <div class="modal-body">
                <div class="form-group">
                    <label for="monografiImage">Gambar Monografi</label>
                    <div class="file-upload">
                        <input type="file" id="monografiImage" name="gambar_mono" accept="image/*" onchange="previewImage(this, 'monografiPreview')">
                        <i class="fas fa-cloud-upload-alt"></i>
                        <p>Klik untuk upload gambar monografi</p>
                        <small style="color: #999; margin-top: 5px;">Format: JPG, PNG (Max: 5MB)</small>
                    </div>
                    <div id="monografiPreview" style="margin-top: 15px; display: none;">
                        <img src="" alt="Preview" style="max-width: 100%; max-height: 200px; border-radius: 8px; border: 1px solid #ddd;">
                    </div>
                </div>

                <div class="form-group">
                    <label for="strukturImage">Gambar Struktur Organisasi</label>
                    <div class="file-upload">
                        <input type="file" id="strukturImage" name="gambar_struktur" accept="image/*" onchange="previewImage(this, 'strukturPreview')">
                        <i class="fas fa-cloud-upload-alt"></i>
                        <p>Klik untuk upload gambar struktur organisasi</p>
                        <small style="color: #999; margin-top: 5px;">Format: JPG, PNG (Max: 5MB)</small>
                    </div>
                    <div id="strukturPreview" style="margin-top: 15px; display: none;">
                        <img src="" alt="Preview" style="max-width: 100%; max-height: 200px; border-radius: 8px; border: 1px solid #ddd;">
                    </div>
                </div>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-cancel" onclick="closeModal()">Batal</button>
                <button type="submit" class="btn btn-save"><i class="fas fa-save"></i> Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- 3. MODAL EDIT --}}
<div class="modal-overlay" id="editModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Edit Data Monografi</h3>
            <button class="close-modal" onclick="closeEditModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <form id="editForm" enctype="multipart/form-data">
            <input type="hidden" id="editId" name="id">
            <input type="hidden" name="_method" value="PUT">
            
            <div class="modal-body">
                <div class="form-group">
                    <label>Gambar Monografi</label>
                    <div class="file-upload">
                        <input type="file" id="editMonografiImage" name="gambar_mono" accept="image/*" onchange="previewImage(this, 'editMonografiPreview')">
                        <i class="fas fa-cloud-upload-alt"></i>
                        <p>Klik untuk ganti gambar</p>
                    </div>
                    <div id="editMonografiPreview" style="margin-top: 15px; display: none;">
                        <img src="" alt="New Preview" style="max-width: 100%; max-height: 200px; border-radius: 8px; border: 1px solid #ddd;">
                    </div>
                    <div class="current-image" id="currentMonoContainer" style="margin-top: 10px;">
                        <small style="color: #666;">Gambar saat ini:</small><br>
                        <img src="" id="currentMonoImg" alt="Current Monografi">
                    </div>
                </div>

                <div class="form-group">
                    <label>Gambar Struktur Organisasi</label>
                    <div class="file-upload">
                        <input type="file" id="editStrukturImage" name="gambar_struktur" accept="image/*" onchange="previewImage(this, 'editStrukturPreview')">
                        <i class="fas fa-cloud-upload-alt"></i>
                        <p>Klik untuk ganti gambar</p>
                    </div>
                    <div id="editStrukturPreview" style="margin-top: 15px; display: none;">
                        <img src="" alt="New Preview" style="max-width: 100%; max-height: 200px; border-radius: 8px; border: 1px solid #ddd;">
                    </div>
                    <div class="current-image" id="currentStrukturContainer" style="margin-top: 10px;">
                        <small style="color: #666;">Gambar saat ini:</small><br>
                        <img src="" id="currentStrukturImg" alt="Current Struktur">
                    </div>
                </div>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-cancel" onclick="closeEditModal()">Batal</button>
                <button type="submit" class="btn btn-save"><i class="fas fa-save"></i> Update</button>
            </div>
        </form>
    </div>
</div>

{{-- 4. JAVASCRIPT LOGIC --}}
<script>
    // --- HELPER FUNCTIONS ---
    function getCsrfToken() {
        return document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    }

    // --- MODAL CONTROLS ---
    function openModal() {
        document.getElementById('addModal').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        document.getElementById('addModal').style.display = 'none';
        document.body.style.overflow = 'auto';
        document.getElementById('addForm').reset();
        document.getElementById('monografiPreview').style.display = 'none';
        document.getElementById('strukturPreview').style.display = 'none';
    }

    function closeEditModal() {
        document.getElementById('editModal').style.display = 'none';
        document.body.style.overflow = 'auto';
        document.getElementById('editForm').reset();
        document.getElementById('editMonografiPreview').style.display = 'none';
        document.getElementById('editStrukturPreview').style.display = 'none';
    }

    // --- 1. OPEN EDIT MODAL & FETCH DATA ---
    function openEditModal(id) {
        if (!id) return alert('ID Data tidak valid');

        // Tampilkan Modal Loading
        document.getElementById('editModal').style.display = 'flex';
        document.body.style.overflow = 'hidden';
        
        // Reset state
        document.getElementById('editId').value = id;
        
        // Fetch Data JSON dari Server
        fetch(`/admin/monografi/${id}/edit`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(res => {
            if (res.success) {
                const data = res.data;
                // Isi Gambar Saat Ini
                document.getElementById('currentMonoImg').src = data.gambar_mono_url;
                document.getElementById('currentStrukturImg').src = data.gambar_struktur_url;
                
                document.getElementById('currentMonoContainer').style.display = 'block';
                document.getElementById('currentStrukturContainer').style.display = 'block';
            } else {
                alert('Gagal mengambil data: ' + res.message);
                closeEditModal();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat mengambil data.');
            closeEditModal();
        });
    }

    // --- PREVIEW IMAGE LOGIC ---
    function previewImage(input, previewId) {
        const preview = document.getElementById(previewId);
        const file = input.files[0];
        
        if (file) {
            if (file.size > 5 * 1024 * 1024) { 
                alert('File terlalu besar! Maksimal 5MB.');
                input.value = '';
                return;
            }
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.querySelector('img').src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            preview.style.display = 'none';
        }
    }

    // --- EVENT LISTENERS ---
    document.addEventListener('DOMContentLoaded', function() {
        
        // Klik luar modal untuk menutup
        window.onclick = function(event) {
            if (event.target == document.getElementById('addModal')) closeModal();
            if (event.target == document.getElementById('editModal')) closeEditModal();
        }

        // --- SUBMIT ADD FORM ---
        document.getElementById('addForm').addEventListener('submit', function(e) {
            e.preventDefault();
            handleFormSubmit(this, '{{ route("admin.monografi.store") }}', 'POST', false);
        });

        // --- SUBMIT EDIT FORM ---
        document.getElementById('editForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const id = document.getElementById('editId').value;
            // Kirim ke route update dengan ID
            handleFormSubmit(this, `/admin/monografi/${id}`, 'POST', true);
        });
    });

    // --- GENERIC FORM HANDLER ---
    function handleFormSubmit(form, url, method, isReload) {
        const formData = new FormData(form);
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;

        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Loading...';
        submitBtn.disabled = true;

        fetch(url, {
            method: method,
            body: formData,
            headers: {
                'X-CSRF-TOKEN': getCsrfToken(),
                'X-Requested-With': 'XMLHttpRequest', // Agar Laravel return JSON jika error
                'Accept': 'application/json'
            }
        })
        .then(response => response.json().then(data => ({status: response.status, body: data})))
        .then(res => {
            if (res.status >= 200 && res.status < 300 && res.body.success) {
                alert(res.body.message);
                location.reload(); 
            } else {
                let msg = res.body.message || 'Terjadi kesalahan.';
                if(res.body.errors) {
                    msg += '\n' + JSON.stringify(res.body.errors);
                }
                alert('Gagal: ' + msg);
            }
        })
        .catch(err => {
            console.error(err);
            alert('Terjadi kesalahan sistem.');
        })
        .finally(() => {
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        });
    }

    // --- DELETE FUNCTION ---
    function deleteMonografi(id, event) {
        if (!confirm('Apakah Anda yakin ingin menghapus data ini?')) return;

        const deleteBtn = event.target.closest('button');
        const originalHtml = deleteBtn.innerHTML;
        
        deleteBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        deleteBtn.disabled = true;

        fetch(`/admin/monografi/${id}`, {
            method: 'POST', 
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': getCsrfToken(),
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                _method: 'DELETE'
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                location.reload(); 
            } else {
                alert('Gagal menghapus: ' + data.message);
                deleteBtn.innerHTML = originalHtml;
                deleteBtn.disabled = false;
            }
        })
        .catch(err => {
            console.error(err);
            alert('Terjadi kesalahan sistem.');
            deleteBtn.innerHTML = originalHtml;
            deleteBtn.disabled = false;
        });
    }
</script>
@endsection