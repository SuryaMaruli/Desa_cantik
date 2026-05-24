@extends('layouts.admin')

@section('title', 'Kelola Beranda - Admin')

@section('page-title', 'Kelola Beranda')

@push('styles')
<style>
    /* Custom Modal Styles */
    #confirmUpdateModal .modal-content {
        border: none;
        border-radius: 16px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
        overflow: hidden;
    }
    
    #confirmUpdateModal .modal-header {
        position: relative;
    }
    
    .modal-icon-container {
        position: absolute;
        top: 20px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 1;
    }
    
    .icon-circle {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: linear-gradient(135deg, #F6903A 0%, #E57A2A 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 8px 20px rgba(246, 144, 58, 0.35);
        animation: pulse-icon 2s infinite;
    }
    
    .icon-circle i {
        font-size: 36px;
        color: white;
    }
    
    @keyframes pulse-icon {
        0%, 100% {
            transform: scale(1);
            box-shadow: 0 8px 20px rgba(246, 144, 58, 0.35);
        }
        50% {
            transform: scale(1.05);
            box-shadow: 0 12px 30px rgba(246, 144, 58, 0.5);
        }
    }
    
    #confirmUpdateModal .modal-body {
        padding-top: 60px;
    }
    
    #confirmUpdateModal .modal-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: #333;
    }
    
    #confirmUpdateModal .text-muted {
        color: #6c757d !important;
        line-height: 1.6;
    }
    
    .warning-box {
        background: linear-gradient(135deg, #fff3e0 0%, #ffe0b2 100%);
        border: 1px solid #ffcc80;
        border-radius: 8px;
        padding: 10px 15px;
        color: #e65100;
    }
    
    .warning-box small {
        display: flex;
        align-items: center;
    }
    
    /* Button Styles */
    #confirmUpdateModal .modal-footer .btn {
        min-width: 140px;
        font-weight: 500;
        border-radius: 8px;
        transition: all 0.3s ease;
    }
    
    .btn-cancel {
        background-color: #f8f9fa;
        border: 2px solid #dee2e6;
        color: #6c757d;
    }
    
    .btn-cancel:hover {
        background-color: #e9ecef;
        border-color: #dee2e6;
        color: #495057;
        transform: translateY(-2px);
    }
    
    .btn-confirm {
        background: linear-gradient(135deg, #F6903A 0%, #E57A2A 100%);
        border: none;
        color: white;
        box-shadow: 0 4px 15px rgba(246, 144, 58, 0.3);
    }
    
    .btn-confirm:hover {
        background: linear-gradient(135deg, #E57A2A 0%, #d66a1a 100%);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(246, 144, 58, 0.4);
    }
    
    .btn-confirm:active {
        transform: translateY(0);
    }
    
    /* Loading state */
    .btn-confirm.loading {
        pointer-events: none;
        opacity: 0.7;
    }
    
    .btn-confirm.loading::after {
        content: '';
        display: inline-block;
        width: 16px;
        height: 16px;
        border: 2px solid #ffffff;
        border-top-color: transparent;
        border-radius: 50%;
        animation: spin 0.8s linear infinite;
        margin-left: 8px;
    }
    
    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    @keyframes slideInRight {
        from { transform: translateX(120%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    
    /* Success animation */
    @keyframes success-pulse {
        0% { box-shadow: 0 0 0 0 rgba(40, 167, 69, 0.7); }
        70% { box-shadow: 0 0 0 20px rgba(40, 167, 69, 0); }
        100% { box-shadow: 0 0 0 0 rgba(40, 167, 69, 0); }
    }

    @keyframes pulse-delete {
        0%, 100% {
            transform: scale(1);
            box-shadow: 0 8px 20px rgba(220, 53, 69, 0.35);
        }
        50% {
            transform: scale(1.05);
            box-shadow: 0 12px 30px rgba(220, 53, 69, 0.5);
        }
    }
    
    /* Make submit button more visible and clickable */
    #berandaForm button[type="submit"] {
        cursor: pointer;
        position: relative;
        z-index: 1;
    }
</style>
@endpush

@section('content')
<!-- Confirmation Modal for Data Update -->
<div class="modal fade" id="confirmUpdateModal" tabindex="-1" aria-labelledby="confirmUpdateModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <div class="modal-icon-container">
                    <div class="icon-circle">
                        <i class='bx bx-edit-alt'></i>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center px-4 pb-4">
                <h4 class="modal-title mb-3" id="confirmUpdateModalLabel">Konfirmasi Perubahan Data</h4>
                
                <!-- Data Preview Card -->
                <div class="data-preview-card bg-light rounded-3 p-3 mb-3">
                    <div class="row text-start">
                        <div class="col-6 mb-2">
                            <small class="text-muted d-block">Nama Kelurahan</small>
                            <strong id="previewNamaKelurahan">-</strong>
                        </div>
                        <div class="col-6 mb-2">
                            <small class="text-muted d-block">Email</small>
                            <strong id="previewEmail">-</strong>
                        </div>
                        <div class="col-6 mb-2">
                            <small class="text-muted d-block">No. HP</small>
                            <strong id="previewNoHp">-</strong>
                        </div>
                        <div class="col-6 mb-2">
                            <small class="text-muted d-block">Deskripsi</small>
                            <strong id="previewDeskripsi" class="d-block text-truncate" style="max-width: 200px;">-</strong>
                        </div>
                    </div>
                </div>
                
                <p class="text-muted mb-2" id="dataConfirmText">Apakah Anda yakin ingin <strong>Mengupdate Data</strong>?</p>
                <div class="warning-box mt-2">
                    <small><i class='bx bx-info-circle me-1'></i> Pastikan data yang Anda masukkan sudah benar!</small>
                </div>
            </div>
            <div class="modal-footer border-0 pt-0 justify-content-center">
                <button type="button" class="btn btn-cancel btn-lg px-4" data-bs-dismiss="modal">
                    <i class='bx bx-x'></i> Batal
                </button>
                <button type="submit" class="btn btn-confirm btn-lg px-4" id="confirmUpdateBtn">
                    <i class='bx bx-check'></i> Ya, Perbarui
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Image/Gambar Preview -->
<div class="modal fade" id="imagePreviewModal" tabindex="-1" aria-labelledby="imagePreviewModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <div class="image-icon-container" style="position:absolute;top:20px;left:50%;transform:translateX(-50%);z-index:1;">
                    <div class="icon-circle" style="width:80px;height:80px;border-radius:50%;background:linear-gradient(135deg,#28a745,#20c997);display:flex;align-items:center;justify-content:center;box-shadow:0 8px 20px rgba(40,167,69,0.35);animation:pulse-icon 2s infinite;">
                        <i class='bx bx-image' style="font-size:36px;color:white;"></i>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center px-4 pb-4" style="padding-top:60px;">
                <h4 class="modal-title mb-3" id="imagePreviewModalLabel">Konfirmasi Perubahan Gambar</h4>
                
                <!-- Image Preview -->
                <div class="image-preview-container bg-light rounded-3 p-3 mb-3">
                    <img id="previewImage" src="" alt="Preview" class="img-thumbnail" style="max-height: 200px; max-width: 100%;">
                    <p class="text-muted mt-2 mb-0" id="previewImageLabel">Gambar baru akan disimpan</p>
                </div>
                
                <p class="text-muted mb-2" id="imageConfirmText">Apakah Anda yakin ingin <strong>Mengupdate Gambar</strong>?</p>
                <div class="warning-box mt-2">
                    <small><i class='bx bx-info-circle me-1'></i> Pastikan gambar sesuai dengan yang diinginkan!</small>
                </div>
            </div>
            <div class="modal-footer border-0 pt-0 justify-content-center">
                <button type="button" class="btn btn-cancel btn-lg px-4" data-bs-dismiss="modal">
                    <i class='bx bx-x'></i> Batal
                </button>
                <button type="submit" class="btn btn-confirm-image btn-lg px-4" id="confirmImageBtn" style="background:linear-gradient(135deg,#28a745,#20c997);">
                    <i class='bx bx-check'></i> Ya, Simpan
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Delete Confirmation -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <div class="delete-icon-container" style="position:absolute;top:20px;left:50%;transform:translateX(-50%);z-index:1;">
                    <div class="icon-circle" style="width:80px;height:80px;border-radius:50%;background:linear-gradient(135deg,#dc3545,#c82333);display:flex;align-items:center;justify-content:center;box-shadow:0 8px 20px rgba(220,53,69,0.35);animation:pulse-delete 2s infinite;">
                        <i class='bx bx-trash' style="font-size:36px;color:white;"></i>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center px-4 pb-4" style="padding-top:60px;">
                <h4 class="modal-title mb-3" id="deleteModalLabel">Hapus Gambar?</h4>
                
                <div class="delete-info bg-light rounded-3 p-3 mb-3">
                    <img id="deleteImagePreview" src="" alt="Gambar" class="img-thumbnail mb-2" style="max-height: 120px;">
                    <p class="text-muted mb-0" id="deleteInfoText">Gambar ini akan dihapus secara permanen!</p>
                </div>
                
                <div class="warning-box-delete" style="background:#ffeef0;border:1px solid #f5c6cb;border-radius:8px;padding:10px 15px;color:#721c24;">
                    <small><i class='bx bx-warning me-1'></i> Tindakan ini tidak dapat dibatalkan!</small>
                </div>
            </div>
            <div class="modal-footer border-0 pt-0 justify-content-center">
                <button type="button" class="btn btn-secondary btn-lg px-4" data-bs-dismiss="modal">
                    <i class='bx bx-x'></i> Batal
                </button>
                <button type="button" class="btn btn-confirm-delete btn-lg px-4" id="confirmDeleteBtn" style="background:linear-gradient(135deg,#dc3545,#c82333);border:none;color:white;box-shadow:0 4px 15px rgba(220,53,69,0.3);">
                    <i class='bx bx-trash'></i> Ya, Hapus
                </button>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Card Data Utama -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Data Utama</h5>
                </div>
                <div class="card-body">
                    @if($beranda)
                        <form action="{{ route('admin.beranda.update', $beranda->id) }}" method="POST" id="dataForm">
                            @csrf
                            @method('PUT')
                    @else
                        <form action="{{ route('admin.beranda.store') }}" method="POST" id="dataForm">
                            @csrf
                    @endif

<div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nama_kelurahan" class="form-label">Nama Kelurahan <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="nama_kelurahan" name="nama_kelurahan" 
value="{{ old('nama_kelurahan', $beranda->nama_kelurahan ?? '') }}" required oninput="checkForChanges()">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="email" name="email" 
value="{{ old('email', $beranda->email ?? '') }}" required oninput="checkForChanges()">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="no_hp" class="form-label">No. HP <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="no_hp" name="no_hp" 
value="{{ old('no_hp', $beranda->no_hp ?? '') }}" required oninput="checkForChanges()">
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi <span class="text-danger">*</span></label>
<textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" required oninput="checkForChanges()">{{ old('deskripsi', $beranda->deskripsi ?? '') }}</textarea>
                        </div>

                        <div class="d-flex justify-content-end">
<button type="submit" class="btn btn-primary" id="perbaruiDataBtn" onclick="showConfirmModal(event, 'data')" disabled>
                                <i class='bx bx-save'></i> {{ $beranda ? 'Perbarui Data' : 'Simpan Data' }}
                            </button>
                    </form>
                </div>
            </div>

<!-- Card Gambar Header -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Gambar Header</h5>
                </div>
                <div class="card-body">
                    @if($beranda)
                        <form action="{{ route('admin.beranda.update.image', $beranda->id) }}" method="POST" enctype="multipart/form-data" id="gambarHeaderForm">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="remove_gambar_header" id="remove_gambar_header" value="0" disabled>
                    @endif

                        <div class="mb-3">
                            <label for="gambar_header" class="form-label">Gambar Header <small class="text-muted">(Maks. 1 foto)</small></label>
                            
                            @if($beranda && $beranda->gambar_header)
                                <div class="current-image-container border rounded p-3 text-center bg-light mb-2">
                                    <img src="{{ asset('storage/' . $beranda->gambar_header) }}" 
                                         alt="Gambar Header" class="img-thumbnail mb-2" style="max-height: 150px; max-width: 100%;">
                                    <br>
                                    <small class="text-muted d-block mb-2">Gambar saat ini</small>
                                </div>
                            @endif

                            <input type="file" class="form-control" id="gambar_header" name="gambar_header" 
                                   accept="image/*" onchange="previewImage(this, 'gambarHeaderPreview')">
                            <div id="gambarHeaderPreview" class="mt-2"></div>
                        </div>

                        @if($beranda)
                        <div class="d-flex justify-content-end gap-2">
                            @if($beranda && $beranda->gambar_header)
                            <button type="button" class="btn btn-danger" onclick="deleteImage('gambar_header')">
                                <i class='bx bx-trash'></i> Hapus Foto
                            </button>
                            @endif
                            <button type="submit" class="btn btn-primary" onclick="showConfirmModal(event, 'gambar')">
                                <i class='bx bx-image'></i> 
                                {{ $beranda && $beranda->gambar_header ? 'Ganti Foto' : 'Tambahkan Foto' }}
                            </button>
                        </div>
                        @endif
                    </form>
                </div>
            </div>

            <!-- Card Logo -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Logo</h5>
                </div>
                <div class="card-body">
                    @if($beranda)
                        <form action="{{ route('admin.beranda.update.logo', $beranda->id) }}" method="POST" enctype="multipart/form-data" id="logoForm">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="remove_logo" id="remove_logo" value="0" disabled>
                    @endif

                        <div class="mb-3">
                            <label for="logo" class="form-label">Logo <small class="text-muted">(Maks. 1 foto)</small></label>
                            
                            @if($beranda && $beranda->logo)
                                <div class="current-image-container border rounded p-3 text-center bg-light mb-2">
                                    <img src="{{ asset('storage/' . $beranda->logo) }}" 
                                         alt="Logo" class="img-thumbnail mb-2" style="max-height: 150px; max-width: 100%;">
                                    <br>
                                    <small class="text-muted d-block mb-2">Logo saat ini</small>
                                </div>
                            @endif

                            <input type="file" class="form-control" id="logo" name="logo" 
                                   accept="image/*" onchange="previewImage(this, 'logoPreview')">
                            <div id="logoPreview" class="mt-2"></div>
                        </div>

                        @if($beranda)
                        <div class="d-flex justify-content-end gap-2">
                            @if($beranda && $beranda->logo)
                            <button type="button" class="btn btn-danger" onclick="deleteImage('logo')">
                                <i class='bx bx-trash'></i> Hapus Logo
                            </button>
                            @endif
                            <button type="submit" class="btn btn-primary" onclick="showConfirmModal(event, 'logo')">
                                <i class='bx bx-flag'></i> 
                                {{ $beranda && $beranda->logo ? 'Ganti Logo' : 'Tambahkan Logo' }}
                            </button>
                        </div>
                        @endif
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let currentFormType = '';
let currentFormId = '';
let deleteType = '';

function showNotification(message, type = 'success') {
    document.querySelectorAll('.custom-notification').forEach(n => n.remove());

    const notification = document.createElement('div');
    const config = {
        success: { icon: 'bx-check-circle', bg: 'linear-gradient(135deg, #10b981, #059669)', color: '#fff' },
        error: { icon: 'bx-x-circle', bg: 'linear-gradient(135deg, #ef4444, #dc2626)', color: '#fff' },
        warning: { icon: 'bx-exclamation-circle', bg: 'linear-gradient(135deg, #f59e0b, #d97706)', color: '#fff' },
        info: { icon: 'bx-info-circle', bg: 'linear-gradient(135deg, #3b82f6, #2563eb)', color: '#fff' }
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
        <i class="bx ${c.icon}" style="font-size: 24px;"></i>
        <span style="font-weight: 500;">${message}</span>
    `;

    document.body.appendChild(notification);

    setTimeout(() => {
        notification.style.transform = 'translateX(120%)';
        notification.style.opacity = '0';
        notification.style.transition = 'all 0.4s ease';
        setTimeout(() => notification.remove(), 400);
    }, 3500);
}

// Image preview function
function previewImage(input, previewId) {
    const preview = document.getElementById(previewId);
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.innerHTML = `
                <div class="mt-2">
                    <small class="text-muted">Preview:</small>
                    <div class="mt-1">
                        <img src="${e.target.result}" alt="Preview" class="img-thumbnail" style="max-height: 150px;">
                    </div>
                </div>
            `;
        };
        
        reader.readAsDataURL(input.files[0]);
        showNotification('Preview gambar berhasil dimuat.', 'info');
    } else {
        preview.innerHTML = '';
    }
}

// Show confirm modal for Data
function showConfirmModal(event, type) {
    event.preventDefault();
    currentFormType = type;
    
    if (type === 'data') {
        currentFormId = 'dataForm';
        const form = document.getElementById(currentFormId);
        if (form && !form.checkValidity()) {
            form.reportValidity();
            showNotification('Lengkapi data wajib terlebih dahulu.', 'warning');
            return;
        }
        
        // Get current form values for preview
        const namaKelurahan = document.getElementById('nama_kelurahan').value;
        const email = document.getElementById('email').value;
        const noHp = document.getElementById('no_hp').value;
        const deskripsi = document.getElementById('deskripsi').value;
        
        // Update preview elements
        document.getElementById('previewNamaKelurahan').textContent = namaKelurahan || '-';
        document.getElementById('previewEmail').textContent = email || '-';
        document.getElementById('previewNoHp').textContent = noHp || '-';
        document.getElementById('previewDeskripsi').textContent = (deskripsi ? deskripsi.substring(0, 50) + (deskripsi.length > 50 ? '...' : '') : '-');
        
        // Show preview card for data
        document.querySelector('.data-preview-card').style.display = 'block';
        
        const modal = document.getElementById('confirmUpdateModal');
        const isUpdate = form?.querySelector('input[name="_method"]') !== null;
        const actionText = isUpdate ? 'Mengupdate Data' : 'Menyimpan Data';
        document.getElementById('confirmUpdateModalLabel').textContent = isUpdate ? 'Konfirmasi Perubahan Data' : 'Konfirmasi Simpan Data';
        document.getElementById('dataConfirmText').innerHTML = `Apakah Anda yakin ingin <strong>${actionText}</strong>?`;
        
// Show modal using Bootstrap 5 method
        if (typeof bootstrap !== 'undefined') {
            const bsModal = new bootstrap.Modal(modal);
            bsModal.show();
        }
    } else if (type === 'gambar') {
        showImagePreviewModal('gambar');
    } else if (type === 'logo') {
        showImagePreviewModal('logo');
    }
}

// Show image preview modal with actual image
function showImagePreviewModal(type) {
    const fileInput = document.getElementById(type === 'gambar' ? 'gambar_header' : 'logo');
    const modal = document.getElementById('imagePreviewModal');
    const previewImg = document.getElementById('previewImage');
    const previewLabel = document.getElementById('previewImageLabel');
    const confirmText = document.getElementById('imageConfirmText');
    const confirmBtn = document.getElementById('confirmImageBtn');
    
    if (type === 'gambar') {
        currentFormId = 'gambarHeaderForm';
        if (!fileInput || !fileInput.files || !fileInput.files[0]) {
            showNotification('Pilih gambar header terlebih dahulu.', 'warning');
            return;
        }
        document.getElementById('imagePreviewModalLabel').textContent = 'Konfirmasi Perubahan Gambar Header';
        confirmText.innerHTML = 'Apakah Anda yakin ingin <strong>Mengupdate Gambar Header</strong>?';
    } else {
        currentFormId = 'logoForm';
        if (!fileInput || !fileInput.files || !fileInput.files[0]) {
            showNotification('Pilih logo terlebih dahulu.', 'warning');
            return;
        }
        document.getElementById('imagePreviewModalLabel').textContent = 'Konfirmasi Perubahan Logo';
        confirmText.innerHTML = 'Apakah Anda yakin ingin <strong>Mengupdate Logo</strong>?';
    }
    
    // Get preview image or current image
    if (fileInput && fileInput.files && fileInput.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            previewLabel.textContent = 'Gambar baru akan disimpan';
        };
        reader.readAsDataURL(fileInput.files[0]);
    }
    
if (typeof bootstrap !== 'undefined') {
        const bsModal = new bootstrap.Modal(modal);
        bsModal.show();
    }
}

// Show delete confirmation modal
function confirmDeleteImage(type) {
    deleteType = type;
    const modal = document.getElementById('deleteModal');
    
    // Get current image
    let imageSrc = '';
    let infoText = '';
    
    if (type === 'gambar_header') {
        const currentImg = document.querySelector('#gambarHeaderForm .current-image-container img');
        if (currentImg) {
            imageSrc = currentImg.src;
        } else {
            showNotification('Tidak ada gambar header yang bisa dihapus.', 'warning');
            return;
        }
        infoText = 'Gambar Header ini akan dihapus secara permanen!';
        document.getElementById('deleteImagePreview').src = imageSrc;
        document.getElementById('deleteInfoText').textContent = infoText;
    } else {
        const currentImg = document.querySelector('#logoForm .current-image-container img');
        if (currentImg) {
            imageSrc = currentImg.src;
        } else {
            showNotification('Tidak ada logo yang bisa dihapus.', 'warning');
            return;
        }
        infoText = 'Logo ini akan dihapus secara permanen!';
        document.getElementById('deleteImagePreview').src = imageSrc;
        document.getElementById('deleteInfoText').textContent = infoText;
    }
    
if (typeof bootstrap !== 'undefined') {
        const bsModal = new bootstrap.Modal(modal);
        bsModal.show();
    }
}

// Handle confirmation button click for Data modal
document.addEventListener('DOMContentLoaded', function() {
    const flashMessages = [
        @if(session('success_data'))
            { message: @json(session('success_data')), type: 'success' },
        @endif
        @if(session('success_gambar'))
            { message: @json(session('success_gambar')), type: 'success' },
        @endif
        @if(session('success_logo'))
            { message: @json(session('success_logo')), type: 'success' },
        @endif
        @if(session('error'))
            { message: @json(session('error')), type: 'error' },
        @endif
        @if($errors->any())
            { message: @json($errors->first()), type: 'error' },
        @endif
    ];

    flashMessages.forEach((flash, index) => {
        setTimeout(() => showNotification(flash.message, flash.type), index * 500);
    });

    const dataModal = document.getElementById('confirmUpdateModal');
    const confirmBtn = document.getElementById('confirmUpdateBtn');
    
    if (confirmBtn) {
        confirmBtn.addEventListener('click', function() {
            if (currentFormId) {
                const form = document.getElementById(currentFormId);
                if (form) {
                    // Add loading state
                    confirmBtn.classList.add('loading');
                    confirmBtn.disabled = true;
                    confirmBtn.innerHTML = '<i class="bx bx-loader-alt animate-spin"></i> Memproses...';
                    
                    // Submit the form after a small delay
                    setTimeout(function() {
                        form.submit();
                    }, 300);
                }
            }
        });
        
        // Reset button state when modal is hidden
        dataModal.addEventListener('hidden.bs.modal', function() {
            confirmBtn.classList.remove('loading');
            confirmBtn.disabled = false;
            confirmBtn.innerHTML = '<i class="bx bx-check"></i> Ya, Perbarui';
        });
    }
    
    // Handle Image confirmation button
    const imageConfirmBtn = document.getElementById('confirmImageBtn');
    const imageModal = document.getElementById('imagePreviewModal');
    
    if (imageConfirmBtn && imageModal) {
        imageConfirmBtn.addEventListener('click', function() {
            if (currentFormId) {
                const form = document.getElementById(currentFormId);
                if (form) {
                    imageConfirmBtn.classList.add('loading');
                    imageConfirmBtn.disabled = true;
                    imageConfirmBtn.innerHTML = '<i class="bx bx-loader-alt animate-spin"></i> Menyimpan...';
                    
                    setTimeout(function() {
                        form.submit();
                    }, 300);
                }
            }
        });
        
        imageModal.addEventListener('hidden.bs.modal', function() {
            imageConfirmBtn.classList.remove('loading');
            imageConfirmBtn.disabled = false;
            imageConfirmBtn.innerHTML = '<i class="bx bx-check"></i> Ya, Simpan';
        });
    }
    
    // Handle Delete confirmation button
    const deleteBtn = document.getElementById('confirmDeleteBtn');
    const deleteModal = document.getElementById('deleteModal');
    
    if (deleteBtn && deleteModal) {
        deleteBtn.addEventListener('click', function() {
            // Set nilai hidden input untuk menunjukkan penghapusan
            const removeInput = document.getElementById('remove_' + deleteType);
            if (!removeInput) {
                showNotification('Aksi hapus tidak dapat diproses.', 'error');
                return;
            }
            removeInput.disabled = false;
            removeInput.value = '1';
            
            deleteBtn.classList.add('loading');
            deleteBtn.disabled = true;
            deleteBtn.innerHTML = '<i class="bx bx-loader-alt animate-spin"></i> Menghapus...';
            
            setTimeout(function() {
                if (deleteType === 'gambar_header') {
                    document.getElementById('gambarHeaderForm').submit();
                } else {
                    document.getElementById('logoForm').submit();
                }
            }, 300);
        });
        
        deleteModal.addEventListener('hidden.bs.modal', function() {
            const removeInput = document.getElementById('remove_' + deleteType);
            if (removeInput) {
                removeInput.disabled = true;
                removeInput.value = '0';
            }
            deleteBtn.classList.remove('loading');
            deleteBtn.disabled = false;
            deleteBtn.innerHTML = '<i class="bx bx-trash"></i> Ya, Hapus';
        });
    }
});

// Store original values for comparison
let originalValues = {};

function storeOriginalValues() {
    originalValues = {
        nama_kelurahan: document.getElementById('nama_kelurahan').value,
        email: document.getElementById('email').value,
        no_hp: document.getElementById('no_hp').value,
        deskripsi: document.getElementById('deskripsi').value
    };
}

function checkForChanges() {
    const currentValues = {
        nama_kelurahan: document.getElementById('nama_kelurahan').value,
        email: document.getElementById('email').value,
        no_hp: document.getElementById('no_hp').value,
        deskripsi: document.getElementById('deskripsi').value
    };
    
    const btn = document.getElementById('perbaruiDataBtn');
    
    // Check if any value has changed
    const hasChanges = (
        currentValues.nama_kelurahan !== originalValues.nama_kelurahan ||
        currentValues.email !== originalValues.email ||
        currentValues.no_hp !== originalValues.no_hp ||
        currentValues.deskripsi !== originalValues.deskripsi
    );
    
    // Enable/disable button based on whether there are changes
    btn.disabled = !hasChanges;
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    storeOriginalValues();
    
    // Set initial button state to disabled (no changes yet)
    const btn = document.getElementById('perbaruiDataBtn');
    if (btn) {
        btn.disabled = true;
    }
});

// Alias function for compatibility
function deleteImage(type) {
    confirmDeleteImage(type);
}

// Toast Notification Function
function showToast(message, type = 'success') {
    showNotification(message, type);
}
</script>
@endpush
