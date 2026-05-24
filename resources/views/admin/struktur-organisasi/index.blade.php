@extends('layouts.admin')

@section('title', 'Struktur Organisasi')

@section('page-title', 'Struktur Organisasi')

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
        flex-wrap: wrap;
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

    .btn-primary-custom {
        background: #F6903A;
        border: none;
        color: white;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .btn-primary-custom:hover {
        background: #E57A2A;
        transform: translateY(-1px);
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

    .current-preview {
        max-width: 220px;
        width: 100%;
        border-radius: 8px;
        border: 1px solid #e5e7eb;
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
        flex-wrap: wrap;
        justify-content: flex-end;
    }

    .btn-action {
        padding: 8px 12px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 13px;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        transition: all 0.2s;
        color: white;
        font-weight: 500;
    }

    .btn-edit {
        background: #007bff;
    }

    .btn-edit:hover {
        background: #0056b3;
    }

    .btn-delete {
        background: #dc3545;
    }

    .btn-delete:hover {
        background: #c82333;
    }

    .status-badge {
        background: #dcfce7;
        color: #166534;
        border-radius: 999px;
        padding: 7px 12px;
        font-size: 13px;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 5px;
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
        background-color: rgba(0,0,0,0.5);
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
        box-shadow: 0 4px 20px rgba(0,0,0,0.15);
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
        background: rgba(255,255,255,0.2);
    }

    .form-group {
        margin-bottom: 20px;
        padding: 0 25px;
    }

    .form-group:first-child {
        padding-top: 25px;
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

    .form-help {
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

    .btn-submit {
        background: #F6903A;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 14px;
        transition: background 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .btn-submit:hover {
        background: #E57A2A;
    }

    .btn-submit:disabled {
        opacity: 0.7;
        cursor: not-allowed;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes slideIn {
        from { transform: translateY(-30px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }

    @media (max-width: 768px) {
        .table-row {
            padding: 16px;
        }

        .action-buttons {
            justify-content: flex-start;
            margin-top: 14px;
        }
    }
</style>

<div class="container-fluid p-4">
    <div class="header-card">
        <div class="header-content">
            <div class="header-text">
                <h1>Struktur Organisasi</h1>
                <p>Kelola gambar struktur organisasi kelurahan</p>
            </div>
            @if($struktur->count() == 0)
                <button type="button" class="btn-primary-custom" onclick="openUploadModal()">
                    <i class="bx bx-plus-circle"></i> Tambah Gambar
                </button>
            @else
                <span class="status-badge"><i class="bx bx-check-circle"></i> Foto sudah ditambahkan</span>
            @endif
        </div>
    </div>

    <div class="table-container">
        <div class="table-header">
            Daftar Gambar Struktur Organisasi
        </div>

        @if($struktur->count() > 0)
            @foreach($struktur as $item)
                <div class="table-row" id="struktur-row-{{ $item->id }}">
                    <div class="row w-100">
                        <div class="col-md-8">
                            <img src="{{ asset('storage/' . $item->gambar) }}" alt="Struktur Organisasi" class="image-preview">
                        </div>
                        <div class="col-md-4 d-flex align-items-center justify-content-end">
                            <div class="action-buttons">
                                <button type="button" class="btn-action btn-edit" onclick="openEditModal({{ $item->id }})">
                                    <i class="bx bx-edit"></i> Edit
                                </button>
                                <button type="button" class="btn-action btn-delete" onclick="deleteStruktur({{ $item->id }}, 'Gambar Struktur Organisasi')">
                                    <i class="bx bx-trash"></i> Delete
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="empty-state">
                <i class="bx bx-image"></i>
                <h3>Informasi Struktur Organisasi belum ditambahkan</h3>
                <p>Silakan upload gambar struktur organisasi terlebih dahulu.</p>
            </div>
        @endif
    </div>
</div>

<div id="uploadModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Tambah Gambar Struktur Organisasi</h3>
            <button class="modal-close" onclick="closeUploadModal()">&times;</button>
        </div>
        <form id="formUploadStruktur" onsubmit="return submitStruktur(event)">
            @csrf
            <div class="form-group">
                <label for="gambar">Pilih Gambar</label>
                <input type="file" id="gambar" name="gambar" accept="image/*" required>
                <p class="form-help">Format: JPG, PNG, JPEG, GIF. Max: 4MB</p>
            </div>
            <div class="form-actions">
                <button type="button" class="btn-cancel" onclick="closeUploadModal()">Batal</button>
                <button type="submit" class="btn-submit">
                    <i class="bx bx-save"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>

@foreach($struktur as $item)
    <div id="editModal{{ $item->id }}" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Edit Gambar</h3>
                <button class="modal-close" onclick="closeEditModal({{ $item->id }})">&times;</button>
            </div>
            <form id="formEditStruktur{{ $item->id }}" onsubmit="return updateStruktur(event, {{ $item->id }})">
                @csrf
                <div class="form-group">
                    <label>Gambar Saat Ini</label>
                    <img src="{{ asset('storage/' . $item->gambar) }}" alt="Gambar saat ini" class="current-preview">
                </div>
                <div class="form-group">
                    <label for="gambar{{ $item->id }}">Ganti Gambar</label>
                    <input type="file" id="gambar{{ $item->id }}" name="gambar" accept="image/*" required>
                    <p class="form-help">Format: JPG, PNG, JPEG, GIF. Max: 4MB</p>
                </div>
                <div class="form-actions">
                    <button type="button" class="btn-cancel" onclick="closeEditModal({{ $item->id }})">Batal</button>
                    <button type="submit" class="btn-submit">
                        <i class="bx bx-save"></i> Update
                    </button>
                </div>
            </form>
        </div>
    </div>
@endforeach

<script>
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

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

        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideInRight {
                from { transform: translateX(120%); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
        `;
        document.head.appendChild(style);
        document.body.appendChild(notification);

        setTimeout(() => {
            notification.style.transform = 'translateX(120%)';
            notification.style.opacity = '0';
            notification.style.transition = 'all 0.4s ease';
            setTimeout(() => { notification.remove(); style.remove(); }, 400);
        }, 3500);
    }

    function openUploadModal() {
        document.getElementById('uploadModal').style.display = 'block';
        document.body.style.overflow = 'hidden';
    }

    function closeUploadModal() {
        const modal = document.getElementById('uploadModal');
        const form = document.getElementById('formUploadStruktur');
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
        form.reset();
    }

    function openEditModal(id) {
        document.getElementById(`editModal${id}`).style.display = 'block';
        document.body.style.overflow = 'hidden';
    }

    function closeEditModal(id) {
        const modal = document.getElementById(`editModal${id}`);
        const form = document.getElementById(`formEditStruktur${id}`);
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
        form.reset();
    }

    function setLoading(form, isLoading, text) {
        const submitBtn = form.querySelector('.btn-submit');
        if (!submitBtn.dataset.originalHtml) {
            submitBtn.dataset.originalHtml = submitBtn.innerHTML;
        }

        submitBtn.disabled = isLoading;
        submitBtn.innerHTML = isLoading
            ? `<i class="bx bx-loader-alt bx-spin"></i> ${text}`
            : submitBtn.dataset.originalHtml;
    }

    function handleActionResponse(response) {
        const contentType = response.headers.get('content-type') || '';
        if (!contentType.includes('application/json')) {
            throw new Error('Terjadi kesalahan. Silakan muat ulang halaman dan coba lagi.');
        }

        return response.json().then(data => {
            if (!response.ok) {
                throw new Error(data.message || 'Terjadi kesalahan. Silakan coba lagi.');
            }
            return data;
        });
    }

    function submitStruktur(event) {
        event.preventDefault();

        const form = document.getElementById('formUploadStruktur');
        const formData = new FormData(form);

        setLoading(form, true, 'Menyimpan...');

        fetch('{{ route('admin.struktur-organisasi.store') }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(handleActionResponse)
        .then(data => {
            showNotification(data.message || 'Gambar struktur organisasi berhasil ditambahkan!', 'success');
            closeUploadModal();
            setTimeout(() => window.location.reload(), 1500);
        })
        .catch(error => {
            showNotification(error.message || 'Terjadi kesalahan jaringan. Silakan coba lagi.', 'error');
        })
        .finally(() => setLoading(form, false, ''));

        return false;
    }

    function updateStruktur(event, id) {
        event.preventDefault();

        const form = document.getElementById(`formEditStruktur${id}`);
        const formData = new FormData(form);
        formData.append('_method', 'PUT');

        setLoading(form, true, 'Mengupdate...');

        fetch(`/admin/struktur-organisasi/${id}`, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(handleActionResponse)
        .then(data => {
            showNotification(data.message || 'Gambar struktur organisasi berhasil diupdate!', 'success');
            closeEditModal(id);
            setTimeout(() => window.location.reload(), 1500);
        })
        .catch(error => {
            showNotification(error.message || 'Terjadi kesalahan jaringan. Silakan coba lagi.', 'error');
        })
        .finally(() => setLoading(form, false, ''));

        return false;
    }

    function showDeleteConfirm(id, nama) {
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
                    <button onclick="confirmDelete(${id})" style="flex: 1; padding: 12px 24px; border: none;
                                border-radius: 10px; background: #ef4444; color: white; font-weight: 500;
                                cursor: pointer; transition: all 0.2s;">Ya, Hapus</button>
                </div>
            </div>
        `;

        const style = document.createElement('style');
        style.textContent = `
            @keyframes scaleIn { from { transform: scale(0.9); opacity: 0; } to { transform: scale(1); opacity: 1; } }
        `;
        document.head.appendChild(style);
        modal.dataset.styleId = 'delete-confirm-style';
        modal.onclick = function(e) { if (e.target === modal) closeDeleteModal(); };
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

    function deleteStruktur(id, nama) {
        showDeleteConfirm(id, nama);
    }

    function confirmDelete(id) {
        closeDeleteModal();

        fetch(`/admin/struktur-organisasi/${id}`, {
            method: 'DELETE',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            }
        })
        .then(handleActionResponse)
        .then(data => {
            const row = document.getElementById(`struktur-row-${id}`);
            if (row) {
                row.style.transition = 'opacity 0.3s, transform 0.3s';
                row.style.opacity = '0';
                row.style.transform = 'translateX(-20px)';
                setTimeout(() => row.remove(), 300);
            }

            showNotification(data.message || 'Gambar struktur organisasi berhasil dihapus!', 'success');
            setTimeout(() => window.location.reload(), 1500);
        })
        .catch(error => {
            showNotification(error.message || 'Terjadi kesalahan jaringan. Silakan coba lagi.', 'error');
        });
    }

    window.onclick = function(event) {
        const uploadModal = document.getElementById('uploadModal');
        if (event.target === uploadModal) {
            closeUploadModal();
            return;
        }

        document.querySelectorAll('[id^="editModal"]').forEach(modal => {
            if (event.target === modal) {
                closeEditModal(modal.id.replace('editModal', ''));
            }
        });
    };

    @if(session('success'))
        showNotification(@json(session('success')), 'success');
    @endif

    @if(session('error'))
        showNotification(@json(session('error')), 'error');
    @endif
</script>
@endsection
