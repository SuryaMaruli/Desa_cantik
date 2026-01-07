@extends('layouts.admin')

@section('title', 'Layanan - Admin Kelurahan Citangkil')
@section('page-title', 'Layanan')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="container">
    {{-- Notifikasi Sukses/Error --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                <i class="fas fa-times"></i>
            </button>
        </div>
    @endif
    
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
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

    {{-- KATEGORI: KEPENDUDUKAN --}}
    <div class="card">
        <h3 class="section-title">Layanan Kependudukan</h3>
        @forelse($layananKependudukan as $item)
        <div class="service-item">
            <div class="service-header">
                <div class="service-name">{{ $item->nama_layanan }}</div>
                <div class="actions">
                    {{-- TOMBOL EDIT YANG SUDAH DIPERBAIKI --}}
                    <button class="icon-btn btn-edit" 
                        onclick="openEditModal(this)"
                        data-id="{{ $item->id }}"
                        data-nama="{{ $item->nama_layanan }}"
                        data-kategori="{{ $item->kategori }}"
                        data-persyaratan="{{ json_encode($item->persyaratan) }}"
                    >
                        <i class="fa-solid fa-pen-to-square"></i>
                    </button>

                    {{-- Tombol Hapus --}}
                    <button class="icon-btn btn-delete" onclick="deleteLayanan({{ $item->id }})">
                        <i class="fa-solid fa-trash-can"></i>
                    </button>
                </div>
            </div>
            <span class="requirements-label">Persyaratan:</span>
            <ul class="requirements-list">
                @foreach($item->persyaratan as $requirement)
                <li>{{ $requirement }}</li>
                @endforeach
            </ul>
        </div>
        @empty
        <p class="text-muted text-center py-3">Belum ada layanan kependudukan.</p>
        @endforelse
    </div>

    {{-- KATEGORI: DATA --}}
    <div class="card">
        <h3 class="section-title">Layanan Permintaan Data</h3>
        @forelse($layananData as $item)
        <div class="service-item">
            <div class="service-header">
                <div class="service-name">{{ $item->nama_layanan }}</div>
                <div class="actions">
                    {{-- TOMBOL EDIT YANG SUDAH DIPERBAIKI --}}
                    <button class="icon-btn btn-edit" 
                        onclick="openEditModal(this)"
                        data-id="{{ $item->id }}"
                        data-nama="{{ $item->nama_layanan }}"
                        data-kategori="{{ $item->kategori }}"
                        data-persyaratan="{{ json_encode($item->persyaratan) }}"
                    >
                        <i class="fa-solid fa-pen-to-square"></i>
                    </button>

                    <button class="icon-btn btn-delete" onclick="deleteLayanan({{ $item->id }})">
                        <i class="fa-solid fa-trash-can"></i>
                    </button>
                </div>
            </div>
            <span class="requirements-label">Persyaratan:</span>
            <ul class="requirements-list">
                @foreach($item->persyaratan as $requirement)
                <li>{{ $requirement }}</li>
                @endforeach
            </ul>
        </div>
        @empty
        <p class="text-muted text-center py-3">Belum ada layanan permintaan data.</p>
        @endforelse
    </div>

</div>

{{-- MODAL TAMBAH --}}
<div class="modal-overlay" id="serviceModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Tambah Layanan Baru</h3>
            <button class="close-modal" id="closeModalIcon"><i class="fa-solid fa-xmark"></i></button>
        </div>
        
        <form id="addServiceForm" action="{{ route('admin.layanan.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Nama Layanan</label>
                <input type="text" name="nama_layanan" class="form-control" placeholder="Nama Layanan..." required>
            </div>

            <div class="form-group">
                <label>Kategori</label>
                <select name="kategori" class="form-control">
                    <option value="kependudukan">Kependudukan</option>
                    <option value="data">Data</option>
                </select>
            </div>

            <div class="form-group">
                <label>Persyaratan</label>
                <div id="requirementsContainer">
                    <div class="requirement-item">
                        <input type="text" name="persyaratan[]" class="form-control requirement-input" placeholder="Syarat 1..." required>
                        <button type="button" class="btn btn-sm btn-danger" onclick="removeRequirement(this)"><i class="fa-solid fa-trash"></i></button>
                    </div>
                </div>
                <button type="button" class="btn btn-sm btn-secondary btn-add-requirement" onclick="addRequirement()">
                    <i class="fa-solid fa-plus"></i> Tambah Syarat
                </button>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="cancelBtn">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL EDIT --}}
<div class="modal-overlay" id="editModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Edit Layanan</h3>
            <button class="close-modal" id="closeEditModalIcon"><i class="fa-solid fa-xmark"></i></button>
        </div>
        
        <form id="editServiceForm" action="{{ route('admin.layanan.update', ':id') }}" method="POST">
            @csrf
            @method('PUT')
            
            <input type="hidden" id="editId" name="id">
            
            <div class="form-group">
                <label>Nama Layanan</label>
                <input type="text" id="editServiceName" name="nama_layanan" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Kategori</label>
                <select id="editServiceCategory" name="kategori" class="form-control">
                    <option value="kependudukan">Kependudukan</option>
                    <option value="data">Data</option>
                </select>
            </div>

            <div class="form-group">
                <label>Persyaratan</label>
                <div id="editRequirementsContainer">
                    {{-- Input dinamis akan masuk sini via JS --}}
                </div>
                <button type="button" class="btn btn-sm btn-secondary btn-add-requirement" onclick="addEditRequirement()">
                    <i class="fa-solid fa-plus"></i> Tambah Syarat
                </button>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="cancelEditBtn">Batal</button>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
    /* Style Dasar */
    .container { max-width: 900px; margin: 0 auto; }
    .card { background: #fff; border-radius: 16px; padding: 24px; margin-bottom: 24px; box-shadow: 0 2px 10px rgba(0,0,0,0.03); border: 1px solid #eef0f2; }
    
    /* Header & Buttons */
    .header-content { display: flex; justify-content: space-between; align-items: center; }
    .header-text h2 { margin: 0; font-size: 1.25rem; }
    .btn { padding: 10px 20px; border-radius: 8px; cursor: pointer; border: none; font-weight: 500; display: inline-flex; align-items: center; gap: 8px; }
    .btn-primary { background: #F6903A; color: white; }
    .btn-secondary { background: #e2e8f0; color: #4a5568; }
    .btn-danger { background: #dc3545; color: white; }
    .icon-btn { width: 32px; height: 32px; border-radius: 6px; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; }
    .btn-edit { background: #e6f6ff; color: #007bff; }
    .btn-delete { background: #ffeef0; color: #dc3545; }

    /* Service Items */
    .service-item { background: #fcfcfc; border-radius: 12px; padding: 20px; border: 1px solid #f0f0f0; margin-bottom: 15px; }
    .service-header { display: flex; justify-content: space-between; margin-bottom: 10px; }
    .service-name { font-weight: 600; font-size: 1rem; }
    .requirements-list { padding-left: 20px; margin: 0; color: #718096; font-size: 0.9rem; }
    
    /* MODAL STYLES */
    .modal-overlay { 
        display: none; /* Hidden by default */
        position: fixed; top: 0; left: 0; width: 100%; height: 100%; 
        background: rgba(0,0,0,0.5); z-index: 1000; 
        justify-content: center; align-items: center; 
    }
    .modal-content { 
        background: white; padding: 30px; border-radius: 16px; width: 90%; max-width: 500px; 
        max-height: 90vh; overflow-y: auto; 
    }
    .modal-header { display: flex; justify-content: space-between; margin-bottom: 20px; }
    .close-modal { background: none; border: none; font-size: 1.2rem; cursor: pointer; }
    .form-group { margin-bottom: 15px; }
    .form-control { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; }
    .requirement-item { display: flex; gap: 10px; margin-bottom: 8px; }
    .btn-sm { padding: 5px 10px; font-size: 0.8rem; }
</style>
@endpush

@push('scripts')
<script>
    // --- SETUP MODAL ---
    const modal = document.getElementById('serviceModal');
    const editModal = document.getElementById('editModal');
    
    // Buka Modal Tambah
    document.getElementById('addServiceBtn').onclick = () => modal.style.display = 'flex';
    
    // Tutup Modal
    const closeModals = () => {
        modal.style.display = 'none';
        editModal.style.display = 'none';
    };
    
    document.getElementById('closeModalIcon').onclick = closeModals;
    document.getElementById('cancelBtn').onclick = closeModals;
    document.getElementById('closeEditModalIcon').onclick = closeModals;
    document.getElementById('cancelEditBtn').onclick = closeModals;
    
    // Tutup jika klik di luar modal
    window.onclick = (e) => {
        if (e.target === modal || e.target === editModal) closeModals();
    };

    // --- LOGIKA FORM TAMBAH ---
    function addRequirement() {
        const container = document.getElementById('requirementsContainer');
        const div = document.createElement('div');
        div.className = 'requirement-item';
        div.innerHTML = `
            <input type="text" name="persyaratan[]" class="form-control" placeholder="Syarat..." required>
            <button type="button" class="btn btn-sm btn-danger" onclick="removeRequirement(this)"><i class="fa-solid fa-trash"></i></button>
        `;
        container.appendChild(div);
    }

    function removeRequirement(btn) {
        if (document.querySelectorAll('#requirementsContainer .requirement-item').length > 1) {
            btn.parentElement.remove();
        } else {
            alert('Minimal 1 syarat!');
        }
    }

    // --- LOGIKA FORM EDIT (POPUP) ---
    function openEditModal(button) {
        // 1. Ambil data dari Atribut Tombol (Aman dari kutip)
        const id = button.getAttribute('data-id');
        const nama = button.getAttribute('data-nama');
        const kategori = button.getAttribute('data-kategori');
        let persyaratan = [];
        
        try {
            persyaratan = JSON.parse(button.getAttribute('data-persyaratan'));
        } catch (e) {
            console.error("Error parsing JSON", e);
        }

        // 2. Isi data dasar
        document.getElementById('editId').value = id;
        document.getElementById('editServiceName').value = nama;
        document.getElementById('editServiceCategory').value = kategori;

        // 3. Update URL Action Form (Ganti placeholder :id dengan id asli)
        const form = document.getElementById('editServiceForm');
        // Pastikan URL dasar sesuai dengan route resource Anda
        let actionUrl = "{{ route('admin.layanan.update', ':id') }}";
        form.action = actionUrl.replace(':id', id);

        // 4. Render ulang persyaratan
        const container = document.getElementById('editRequirementsContainer');
        container.innerHTML = ''; // Reset isi sebelumnya

        if (persyaratan && persyaratan.length > 0) {
            persyaratan.forEach(req => {
                const div = document.createElement('div');
                div.className = 'requirement-item';
                div.innerHTML = `
                    <input type="text" name="persyaratan[]" class="form-control" value="${req}" required>
                    <button type="button" class="btn btn-sm btn-danger" onclick="removeEditRequirement(this)"><i class="fa-solid fa-trash"></i></button>
                `;
                container.appendChild(div);
            });
        } else {
            addEditRequirement(); // Default 1 kosong jika tidak ada data
        }

        // 5. Tampilkan Modal
        editModal.style.display = 'flex';
    }

    function addEditRequirement() {
        const container = document.getElementById('editRequirementsContainer');
        const div = document.createElement('div');
        div.className = 'requirement-item';
        div.innerHTML = `
            <input type="text" name="persyaratan[]" class="form-control" placeholder="Syarat tambahan..." required>
            <button type="button" class="btn btn-sm btn-danger" onclick="removeEditRequirement(this)"><i class="fa-solid fa-trash"></i></button>
        `;
        container.appendChild(div);
    }

    function removeEditRequirement(btn) {
        const container = document.getElementById('editRequirementsContainer');
        if (container.querySelectorAll('.requirement-item').length > 1) {
            btn.parentElement.remove();
        } else {
            alert('Minimal 1 syarat!');
        }
    }

    // --- LOGIKA HAPUS ---
    function deleteLayanan(id) {
        if (confirm('Yakin ingin menghapus layanan ini?')) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/admin/layanan/${id}`; // Sesuaikan route delete

            const csrf = document.createElement('input');
            csrf.type = 'hidden';
            csrf.name = '_token';
            csrf.value = document.querySelector('meta[name="csrf-token"]').content;
            
            const method = document.createElement('input');
            method.type = 'hidden';
            method.name = '_method';
            method.value = 'DELETE';

            form.appendChild(csrf);
            form.appendChild(method);
            document.body.appendChild(form);
            form.submit();
        }
    }
</script>
@endpush