@extends('layouts.admin')

@section('title', 'Monografi')

@section('page-title', 'Monografi')

@section('content')
<style>
    .header-card {
        background: white;
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        margin-bottom: 24px;
    }

    .header-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
    }

    .header-text h1 {
        font-size: 24px;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 6px;
    }

    .header-text p {
        color: #64748b;
        font-size: 14px;
        margin: 0;
    }

    .btn-primary,
    .btn-submit {
        background: #F6903A;
        border: none;
        color: white;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        cursor: pointer;
    }

    .btn-primary:hover,
    .btn-submit:hover {
        background: #E57A2A;
    }

    .table-container {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }

    .table-header {
        background-color: #f58e3e;
        color: white;
        padding: 15px 20px;
        font-weight: 600;
        font-size: 14px;
    }

    .table-row {
        display: flex;
        padding: 20px;
        align-items: center;
        border-bottom: 1px solid #e0e0e0;
    }

    .table-row:last-child {
        border-bottom: none;
    }

    .image-preview {
        width: 100%;
        max-width: 400px;
        height: auto;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .current-image {
        max-width: 200px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #64748b;
    }

    .empty-state i {
        font-size: 48px;
        color: #d1d5db;
        margin-bottom: 16px;
    }

    .action-buttons {
        display: flex;
        gap: 8px;
        justify-content: flex-end;
        flex-wrap: wrap;
    }

    .btn-action {
        padding: 6px 10px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 12px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        transition: all 0.2s;
    }

    .btn-edit {
        background: #007bff;
        color: white;
    }

    .btn-edit:hover {
        background: #0056b3;
    }

    .btn-delete {
        background: #dc3545;
        color: white;
    }

    .btn-delete:hover {
        background: #c82333;
    }

    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.5);
        animation: fadeIn 0.3s;
    }

    .modal-content {
        background-color: #fefefe;
        margin: 10% auto;
        padding: 0;
        border: 1px solid #888;
        border-radius: 12px;
        width: 500px;
        max-width: 90%;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        animation: slideIn 0.3s;
    }

    .modal-header {
        background: linear-gradient(135deg, #F6903A, #E57A2A);
        color: white;
        padding: 20px 25px;
        border-radius: 12px 12px 0 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal-header h3 {
        margin: 0;
        font-size: 18px;
        font-weight: 600;
    }

    .modal-close {
        background: none;
        border: none;
        font-size: 24px;
        color: white;
        cursor: pointer;
        padding: 0;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        transition: background 0.2s;
    }

    .modal-close:hover {
        background: rgba(255, 255, 255, 0.2);
    }

    .modal-body {
        padding-top: 20px;
    }

    .form-group {
        margin-bottom: 20px;
        padding: 0 25px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
        color: #333;
    }

    .form-group input {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 14px;
        transition: border-color 0.2s;
        box-sizing: border-box;
    }

    .form-group input:focus {
        outline: none;
        border-color: #F6903A;
        box-shadow: 0 0 0 3px rgba(246, 144, 58, 0.1);
    }

    .text-muted {
        color: #9ca3af;
        font-size: 13px;
        margin: 8px 0 0;
    }

    .form-actions {
        display: flex;
        gap: 10px;
        justify-content: flex-end;
        padding: 20px 25px;
        background: #f8f9fa;
        border-radius: 0 0 12px 12px;
        margin: 0;
    }

    .btn-cancel {
        background: #6c757d;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 14px;
        transition: background 0.2s;
    }

    .btn-cancel:hover {
        background: #5a6268;
    }

    .status-badge {
        background: #d4edda;
        color: #155724;
        border-radius: 20px;
        padding: 6px 12px;
        font-size: 12px;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        white-space: nowrap;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes slideIn {
        from { transform: translateY(-50px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }

    @media (max-width: 768px) {
        .header-content {
            align-items: flex-start;
            flex-direction: column;
        }

        .table-row .row {
            gap: 16px;
        }

        .action-buttons {
            justify-content: flex-start;
        }
    }
</style>

<div class="container-fluid p-4">
    <div class="header-card">
        <div class="header-content">
            <div class="header-text">
                <h1>Monografi</h1>
                <p>Kelola gambar monografi kelurahan</p>
            </div>
            @if($monografis->count() == 0)
                <button type="button" class="btn-primary" onclick="openActionModal('uploadModal')">
                    <i class="bx bx-plus-circle"></i>Tambah Gambar
                </button>
            @else
                <span class="status-badge"><i class="bx bx-check-circle"></i>Foto sudah ditambahkan</span>
            @endif
        </div>
    </div>

    <div class="table-container">
        <div class="table-header">
            Daftar Gambar Monografi
        </div>

        @if($monografis->count() > 0)
            @foreach($monografis as $item)
                <div class="table-row">
                    <div class="row w-100">
                        <div class="col-md-8">
                            <img src="{{ url('storage/' . $item->gambar_mono) }}" alt="Monografi" class="image-preview">
                        </div>
                        <div class="col-md-4 d-flex align-items-center justify-content-end">
                            <div class="action-buttons">
                                <button type="button" class="btn-action btn-edit" onclick="openActionModal('editModal{{ $item->id_monografi }}')">
                                    <i class="bx bx-edit"></i> Edit
                                </button>
                                <button type="button" class="btn-action btn-delete" onclick="showDeleteConfirm('deleteForm{{ $item->id_monografi }}', 'Gambar Monografi')">
                                    <i class="bx bx-trash"></i> Hapus
                                </button>
                            </div>
                            <form id="deleteForm{{ $item->id_monografi }}" action="{{ route('admin.monografi.destroy', $item->id_monografi) }}" method="POST" class="d-none">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                    </div>
                </div>

                <div id="editModal{{ $item->id_monografi }}" class="modal">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3>Edit Gambar</h3>
                            <button type="button" class="modal-close" onclick="closeActionModal('editModal{{ $item->id_monografi }}')">&times;</button>
                        </div>
                        <form action="{{ route('admin.monografi.update', $item->id_monografi) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Gambar Saat Ini</label>
                                    <img src="{{ asset('storage/' . $item->gambar_mono) }}" alt="Current" class="current-image">
                                </div>
                                <div class="form-group">
                                    <label for="gambar{{ $item->id_monografi }}">Ganti Gambar (Opsional)</label>
                                    <input type="file" id="gambar{{ $item->id_monografi }}" name="gambar" accept="image/*">
                                    <p class="text-muted">Format: JPG, PNG, JPEG, GIF. Max: 5MB</p>
                                </div>
                            </div>
                            <div class="form-actions">
                                <button type="button" class="btn-cancel" onclick="closeActionModal('editModal{{ $item->id_monografi }}')">Batal</button>
                                <button type="submit" class="btn-submit">
                                    <i class="bx bx-save"></i> Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @endforeach
        @else
            <div class="empty-state">
                <i class="fas fa-image"></i>
                <h3>Informasi Monografi belum ditambahkan</h3>
                <p>Silakan upload gambar monografi terlebih dahulu.</p>
            </div>
        @endif
    </div>
</div>

<div id="uploadModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Tambah Gambar Monografi</h3>
            <button type="button" class="modal-close" onclick="closeActionModal('uploadModal')">&times;</button>
        </div>
        <form action="{{ route('admin.monografi.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label for="gambar">Pilih Gambar</label>
                    <input type="file" id="gambar" name="gambar" accept="image/*" required>
                    <p class="text-muted">Format: JPG, PNG, JPEG, GIF. Max: 5MB</p>
                </div>
            </div>
            <div class="form-actions">
                <button type="button" class="btn-cancel" onclick="closeActionModal('uploadModal')">Batal</button>
                <button type="submit" class="btn-submit">
                    <i class="bx bx-save"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const successMessage = @js(session('success'));
    const errorMessage = @js(session('error'));

    if (successMessage) {
        showNotification(successMessage, 'success');
    }

    if (errorMessage) {
        showNotification(errorMessage, 'error');
    }
});

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

    ensurePopupKeyframes();
    document.body.appendChild(notification);

    setTimeout(() => {
        notification.style.transform = 'translateX(120%)';
        notification.style.opacity = '0';
        notification.style.transition = 'all 0.4s ease';
        setTimeout(() => notification.remove(), 400);
    }, 3500);
}

function openActionModal(id) {
    const modal = document.getElementById(id);
    if (!modal) return;

    modal.style.display = 'block';
    document.body.style.overflow = 'hidden';
}

function closeActionModal(id) {
    const modal = document.getElementById(id);
    if (!modal) return;

    modal.style.display = 'none';
    document.body.style.overflow = 'auto';
}

function showDeleteConfirm(formId, nama) {
    const oldModal = document.getElementById('delete-confirm-modal');
    if (oldModal) oldModal.remove();

    const modal = document.createElement('div');
    modal.id = 'delete-confirm-modal';
    modal.style.cssText = `
        position: fixed; top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(0,0,0,0.5); z-index: 9999;
        display: flex; align-items: center; justify-content: center;
        animation: fadeIn 0.3s ease;
    `;

    modal.innerHTML = `
        <div style="background: white; border-radius: 16px; padding: 30px; max-width: 400px; width: 90%;
                    box-shadow: 0 20px 60px rgba(0,0,0,0.3); animation: scaleIn 0.3s ease;">
            <div style="text-align: center; margin-bottom: 20px;">
                <div style="width: 70px; height: 70px; border-radius: 50%; background: #fef2f2;
                            display: flex; align-items: center; justify-content: center; margin: 0 auto 15px;">
                    <i class="bx bx-trash" style="font-size: 36px; color: #ef4444;"></i>
                </div>
                <h3 style="margin: 0 0 8px; font-size: 20px; color: #1f2937;">Konfirmasi Hapus</h3>
                <p style="margin: 0; color: #6b7280; font-size: 14px;">
                    Apakah Anda yakin ingin menghapus<br>
                    <strong style="color: #1f2937; font-size: 16px;">"${nama}"</strong>?
                </p>
            </div>
            <div style="display: flex; gap: 12px; justify-content: center;">
                <button onclick="closeDeleteModal()" style="flex: 1; padding: 12px 24px; border: none;
                            border-radius: 10px; background: #f3f4f6; color: #374151; font-weight: 500;
                            cursor: pointer; transition: all 0.2s;">Batal</button>
                <button onclick="confirmDelete('${formId}')" style="flex: 1; padding: 12px 24px; border: none;
                            border-radius: 10px; background: #ef4444; color: white; font-weight: 500;
                            cursor: pointer; transition: all 0.2s;">Ya, Hapus</button>
            </div>
        </div>
    `;

    ensurePopupKeyframes();
    modal.onclick = function(e) {
        if (e.target === modal) closeDeleteModal();
    };
    document.body.appendChild(modal);
}

function closeDeleteModal() {
    const modal = document.getElementById('delete-confirm-modal');
    if (modal) {
        modal.style.opacity = '0';
        modal.style.transform = 'scale(0.9)';
        setTimeout(() => modal.remove(), 300);
    }
}

function confirmDelete(formId) {
    const form = document.getElementById(formId);
    if (form) {
        form.submit();
    }
}

function ensurePopupKeyframes() {
    if (document.getElementById('monografi-popup-keyframes')) return;

    const style = document.createElement('style');
    style.id = 'monografi-popup-keyframes';
    style.textContent = `
        @keyframes slideInRight {
            from { transform: translateX(120%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        @keyframes scaleIn {
            from { transform: scale(0.9); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }
    `;
    document.head.appendChild(style);
}

window.onclick = function(event) {
    if (event.target.classList && event.target.classList.contains('modal')) {
        closeActionModal(event.target.id);
    }
};
</script>
@endsection
