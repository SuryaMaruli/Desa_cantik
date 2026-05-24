@extends('layouts.admin')

@section('title', 'Maklumat Pelayanan')

@section('page-title', 'Maklumat Pelayanan')

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

    .btn-primary {
        background: #F6903A;
        border-color: #F6903A;
        color: white;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s;
    }

    .btn-primary:hover {
        background: #E57A2A;
        border-color: #E57A2A;
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

    .btn-sm {
        padding: 6px 12px;
        font-size: 13px;
        border-radius: 6px;
    }

    .btn-danger {
        background: #dc2626;
        border-color: #dc2626;
    }

    .btn-danger:hover {
        background: #b91c1c;
        border-color: #b91c1c;
    }

    .alert {
        padding: 12px 20px;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .alert-success {
        background: #dcfce7;
        color: #166534;
        border: 1px solid #bbf7d0;
    }

    .alert-danger {
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #fecaca;
    }

    .modal-content {
        background: white;
        border-radius: 12px;
        padding: 0;
        overflow: hidden;
        border: 1px solid #e5e7eb;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
    }

    .modal-header {
        background: linear-gradient(135deg, #F6903A, #E57A2A);
        color: white;
        padding: 20px 25px;
        border-radius: 12px 12px 0 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 0;
    }

    .modal-header h3 {
        margin: 0;
        font-size: 18px;
        font-weight: 600;
    }

    .btn-close {
        background: none;
        border: none;
        color: white;
        font-size: 24px;
        cursor: pointer;
        opacity: 1;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        transition: background 0.2s;
    }

    .btn-close::before {
        content: '\00d7';
        line-height: 1;
    }

    .btn-close:hover {
        background: rgba(255, 255, 255, 0.2);
        color: white;
        opacity: 1;
    }

    .form-label {
        font-weight: 500;
        color: #374151;
        margin-bottom: 8px;
    }

    .form-control {
        padding: 10px 14px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 14px;
    }

    .form-control:focus {
        border-color: #F6903A;
        box-shadow: 0 0 0 3px rgba(246, 144, 58, 0.1);
    }

    .text-muted {
        color: #9ca3af;
        font-size: 13px;
    }

    .modal-body {
        padding: 25px;
    }

    .modal-footer {
        background: #f8f9fa;
        border-top: 0;
        border-radius: 0 0 12px 12px;
        padding: 20px 25px;
        gap: 10px;
    }

    .modal-footer .btn {
        border: none;
        border-radius: 6px;
        font-size: 14px;
        padding: 10px 20px;
        font-weight: 500;
    }

    .modal-footer .btn-secondary {
        background: #6c757d;
        color: white;
    }

    .modal-footer .btn-secondary:hover {
        background: #5a6268;
    }

    .modal-footer .btn-primary {
        background: #F6903A;
        color: white;
    }

    .modal-footer .btn-primary:hover {
        background: #E57A2A;
    }
</style>

<div class="container-fluid p-4">
<div class="header-card">
        <div class="header-content">
            <div class="header-text">
                <h1>Maklumat Pelayanan</h1>
                <p>Kelola gambar maklumat pelayanan kelurahan</p>
            </div>
            @if($maklumat->count() == 0)
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadModal">
                <i class="fas fa-plus me-2"></i>Tambah Gambar
            </button>
            @else
            <span class="badge bg-success"><i class="fas fa-check-circle me-1"></i>Foto sudah ditambahkan</span>
            @endif
        </div>
    </div>

    <div class="table-container">
        <div class="table-header">
            Daftar Gambar Maklumat Pelayanan
        </div>

        @if($maklumat->count() > 0)
            @foreach($maklumat as $item)
            <div class="table-row">
                <div class="row w-100">
                    <div class="col-md-8">
                        <img src="{{ asset('storage/' . $item->gambar) }}" alt="Maklumat Pelayanan" class="image-preview">
                    </div>
<div class="col-md-4 d-flex align-items-center justify-content-end gap-2">
                        <button type="button" class="btn btn-primary btn-sm btn-edit" data-bs-toggle="modal" data-bs-target="#editModal{{ $item->id }}">
                            <i class="fas fa-edit me-1"></i> Edit
                        </button>
                        <form action="{{ route('admin.maklumat-pelayananan.destroy', $item->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm btn-delete">
                                <i class="fas fa-trash me-1"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Edit Modal -->
            <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3>Edit Gambar</h3>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ route('admin.maklumat-pelayananan.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label">Gambar Saat Ini</label>
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/' . $item->gambar) }}" alt="Current" style="max-width: 200px; border-radius: 8px;">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="gambar{{ $item->id }}" class="form-label">Ganti Gambar (Opsional)</label>
                                    <input type="file" class="form-control" id="gambar{{ $item->id }}" name="gambar" accept="image/*">
                                    <p class="text-muted mt-1">Format: JPG, PNG, JPEG, GIF. Max: 4MB</p>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
@else
            <div class="empty-state">
                <i class="fas fa-image"></i>
                <h3>Informasi Maklumat Pelayanan belum ditambahkan</h3>
                <p>Silakan upload gambar maklumat pelayanan terlebih dahulu.</p>
            </div>
        @endif
    </div>
</div>

<!-- Upload Modal -->
<div class="modal fade" id="uploadModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Tambah Gambar Maklumat Pelayanan</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.maklumat-pelayananan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="gambar" class="form-label">Pilih Gambar</label>
                        <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*" required>
                        <p class="text-muted mt-1">Format: JPG, PNG, JPEG, GIF. Max: 4MB</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    @if(session('success'))
        showNotification(@json(session('success')), 'success');
    @endif

    @if(session('error'))
        showNotification(@json(session('error')), 'error');
    @endif

    document.querySelectorAll('.btn-delete').forEach(function(button) {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const form = this.closest('form');
            showDeleteConfirm(form);
        });
    });

    document.querySelectorAll('.btn-edit').forEach(function(button) {
        button.addEventListener('click', function(e) {
            showNotification('Anda akan mengedit foto Maklumat Pelayanan.', 'info');
        });
    });
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

    ensurePopupAnimations();
    document.body.appendChild(notification);

    setTimeout(() => {
        notification.style.transform = 'translateX(120%)';
        notification.style.opacity = '0';
        notification.style.transition = 'all 0.4s ease';
        setTimeout(() => notification.remove(), 400);
    }, 3500);
}

function showDeleteConfirm(form) {
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
                    <strong style="color: #1f2937; font-size: 16px;">gambar Maklumat Pelayanan</strong>?
                </p>
            </div>
            <div style="display: flex; gap: 12px; justify-content: center;">
                <button type="button" onclick="closeDeleteModal()" style="flex: 1; padding: 12px 24px; border: none;
                            border-radius: 10px; background: #f3f4f6; color: #374151; font-weight: 500;
                            cursor: pointer; transition: all 0.2s;">Batal</button>
                <button type="button" id="confirm-delete-action" style="flex: 1; padding: 12px 24px; border: none;
                            border-radius: 10px; background: #ef4444; color: white; font-weight: 500;
                            cursor: pointer; transition: all 0.2s;">Ya, Hapus</button>
            </div>
        </div>
    `;

    ensurePopupAnimations();
    modal.onclick = function(e) {
        if (e.target === modal) closeDeleteModal();
    };
    document.body.appendChild(modal);

    document.getElementById('confirm-delete-action').addEventListener('click', function() {
        closeDeleteModal();
        form.submit();
    });
}

function closeDeleteModal() {
    const modal = document.getElementById('delete-confirm-modal');
    if (modal) {
        modal.style.opacity = '0';
        modal.style.transform = 'scale(0.9)';
        setTimeout(() => modal.remove(), 300);
    }
}

function ensurePopupAnimations() {
    if (document.getElementById('data-kelurahan-popup-animations')) {
        return;
    }

    const style = document.createElement('style');
    style.id = 'data-kelurahan-popup-animations';
    style.textContent = `
        @keyframes slideInRight {
            from { transform: translateX(120%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        @keyframes scaleIn {
            from { transform: scale(0.9); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }
    `;
    document.head.appendChild(style);
}

window.closeDeleteModal = closeDeleteModal;
</script>
@endsection
