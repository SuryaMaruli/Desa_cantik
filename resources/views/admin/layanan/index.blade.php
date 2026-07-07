@extends('layouts.admin')

@section('title', 'Layanan - Admin Kelurahan Gunung Sugih')
@section('page-title', 'Layanan')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

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
                        data-persyaratan='@json($item->persyaratan)'
                    >
                        <i class="fa-solid fa-pen-to-square"></i>
                    </button>

                    {{-- Tombol Hapus --}}
                    <button class="icon-btn btn-delete" onclick="deleteLayanan({{ $item->id }}, @js($item->nama_layanan))">
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
                        data-persyaratan='@json($item->persyaratan)'
                    >
                        <i class="fa-solid fa-pen-to-square"></i>
                    </button>

                    <button class="icon-btn btn-delete" onclick="deleteLayanan({{ $item->id }}, @js($item->nama_layanan))">
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
        display: none;
        position: fixed; top: 0; left: 0; width: 100%; height: 100%; 
        background: rgba(0,0,0,0.5); z-index: 1000; 
        justify-content: center; align-items: center; 
        animation: fadeIn 0.3s ease;
    }
    .modal-content { 
        background: white; padding: 0; border-radius: 16px; width: 90%; max-width: 500px; 
        max-height: 90vh; overflow-y: auto; 
        box-shadow: 0 20px 60px rgba(0,0,0,0.2);
        animation: scaleIn 0.3s ease;
    }
    .modal-header {
        background: linear-gradient(135deg, #F6903A, #E57A2A);
        color: white;
        padding: 20px 25px;
        border-radius: 16px 16px 0 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }
    .modal-header h3 { margin: 0; font-size: 18px; font-weight: 600; }
    .close-modal {
        background: none;
        border: none;
        color: white;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        font-size: 1.2rem;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background 0.2s;
    }
    .close-modal:hover { background: rgba(255,255,255,0.2); }
    .form-group { margin-bottom: 15px; padding: 0 25px; }
    .form-control { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; }
    .requirement-item { display: flex; gap: 10px; margin-bottom: 8px; }
    .btn-sm { padding: 5px 10px; font-size: 0.8rem; }
    .modal-footer {
        display: flex;
        gap: 10px;
        justify-content: flex-end;
        padding: 20px 25px;
        background: #f8f9fa;
        border-radius: 0 0 16px 16px;
    }
    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    @keyframes scaleIn {
        from { transform: scale(0.92); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }
    @keyframes slideInRight {
        from { transform: translateX(120%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
</style>
@endpush

@push('scripts')
<script>
    // --- SETUP MODAL ---
    const modal = document.getElementById('serviceModal');
    const editModal = document.getElementById('editModal');

    function escapeHTML(value) {
        const div = document.createElement('div');
        div.textContent = value ?? '';
        return div.innerHTML;
    }

    function showNotification(message, type = 'success') {
        document.querySelectorAll('.custom-notification').forEach(n => n.remove());

        const notification = document.createElement('div');
        const config = {
            success: { icon: 'fa-circle-check', bg: 'linear-gradient(135deg, #10b981, #059669)', color: '#fff' },
            error: { icon: 'fa-circle-xmark', bg: 'linear-gradient(135deg, #ef4444, #dc2626)', color: '#fff' },
            warning: { icon: 'fa-circle-exclamation', bg: 'linear-gradient(135deg, #f59e0b, #d97706)', color: '#fff' },
            info: { icon: 'fa-circle-info', bg: 'linear-gradient(135deg, #3b82f6, #2563eb)', color: '#fff' }
        };
        const c = config[type] || config.success;

        notification.className = 'custom-notification';
        notification.style.cssText = `
            position: fixed; top: 20px; right: 20px;
            background: ${c.bg}; color: ${c.color};
            padding: 16px 24px; border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2); z-index: 10000;
            font-family: 'Poppins', sans-serif; font-size: 14px;
            display: flex; align-items: center; gap: 12px;
            animation: slideInRight 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            min-width: 280px; max-width: 400px;
        `;
        notification.innerHTML = `
            <i class="fa-solid ${c.icon}" style="font-size: 24px;"></i>
            <span style="font-weight: 500;">${escapeHTML(message)}</span>
        `;

        document.body.appendChild(notification);

        setTimeout(() => {
            notification.style.transform = 'translateX(120%)';
            notification.style.opacity = '0';
            notification.style.transition = 'all 0.4s ease';
            setTimeout(() => notification.remove(), 400);
        }, 3500);
    }

    function showDeleteConfirm(id, nama) {
        document.getElementById('delete-confirm-modal')?.remove();

        const deleteModal = document.createElement('div');
        deleteModal.id = 'delete-confirm-modal';
        deleteModal.style.cssText = `
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.5); z-index: 9999;
            display: flex; align-items: center; justify-content: center;
            animation: fadeIn 0.3s ease;
        `;

        deleteModal.innerHTML = `
            <div style="background: white; border-radius: 16px; padding: 30px; max-width: 400px; width: 90%;
                        box-shadow: 0 20px 60px rgba(0,0,0,0.3); animation: scaleIn 0.3s ease;">
                <div style="text-align: center; margin-bottom: 20px;">
                    <div style="width: 70px; height: 70px; border-radius: 50%; background: #fef2f2;
                                display: flex; align-items: center; justify-content: center; margin: 0 auto 15px;">
                        <i class="fa-solid fa-trash-can" style="font-size: 32px; color: #ef4444;"></i>
                    </div>
                    <h3 style="margin: 0 0 8px; font-size: 20px; color: #1f2937;">Konfirmasi Hapus</h3>
                    <p style="margin: 0; color: #6b7280; font-size: 14px;">
                        Apakah Anda yakin ingin menghapus<br>
                        <strong style="color: #1f2937; font-size: 16px;">"${escapeHTML(nama)}"</strong>?
                    </p>
                </div>
                <div style="display: flex; gap: 12px; justify-content: center;">
                    <button onclick="closeDeleteModal()" style="flex: 1; padding: 12px 24px; border: none;
                                border-radius: 10px; background: #f3f4f6; color: #374151; font-weight: 500;
                                cursor: pointer; transition: all 0.2s;">Batal</button>
                    <button onclick="confirmDeleteLayanan(${id})" style="flex: 1; padding: 12px 24px; border: none;
                                border-radius: 10px; background: #ef4444; color: white; font-weight: 500;
                                cursor: pointer; transition: all 0.2s;">Ya, Hapus</button>
                </div>
            </div>
        `;

        deleteModal.onclick = function(e) {
            if (e.target === deleteModal) closeDeleteModal();
        };
        document.body.appendChild(deleteModal);
    }

    function closeDeleteModal() {
        const deleteModal = document.getElementById('delete-confirm-modal');
        if (deleteModal) {
            deleteModal.style.opacity = '0';
            deleteModal.style.transition = 'opacity 0.3s ease';
            setTimeout(() => deleteModal.remove(), 300);
        }
    }

    window.closeDeleteModal = closeDeleteModal;

    document.addEventListener('DOMContentLoaded', () => {
        @if(session('success'))
            showNotification(@js(session('success')), 'success');
        @endif

        @if(session('error'))
            showNotification(@js(session('error')), 'error');
        @endif

        @if ($errors->any())
            @foreach ($errors->all() as $error)
                showNotification(@js($error), 'error');
            @endforeach
        @endif
    });
    
    // Buka Modal Tambah
    document.getElementById('addServiceBtn').onclick = () => {
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    };
    
    // Tutup Modal
    const closeModals = () => {
        modal.style.display = 'none';
        editModal.style.display = 'none';
        document.body.style.overflow = 'auto';
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
            showNotification('Minimal 1 syarat!', 'warning');
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
                    <input type="text" name="persyaratan[]" class="form-control" value="${escapeHTML(req)}" required>
                    <button type="button" class="btn btn-sm btn-danger" onclick="removeEditRequirement(this)"><i class="fa-solid fa-trash"></i></button>
                `;
                container.appendChild(div);
            });
        } else {
            addEditRequirement(); // Default 1 kosong jika tidak ada data
        }

        // 5. Tampilkan Modal
        editModal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
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
            showNotification('Minimal 1 syarat!', 'warning');
        }
    }

    // --- LOGIKA HAPUS ---
    function deleteLayanan(id, nama) {
        showDeleteConfirm(id, nama);
    }

    function confirmDeleteLayanan(id) {
        closeDeleteModal();

        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/layanan/${id}`;

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

    window.confirmDeleteLayanan = confirmDeleteLayanan;
</script>
@endpush
