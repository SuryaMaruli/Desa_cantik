@extends('layouts.admin')

@section('page-title', 'Kelola Admin')

@section('content')
<div class="home-content">
    <div class="news-toolbar">
        <div class="toolbar-container">
            <div class="search-box">
                <span class="search-icon-wrap">
                    <i class='bx bx-search'></i>
                </span>
                <input type="text" placeholder="Cari nama atau email admin..." id="searchAdmin">
            </div>
            <a href="{{ route('admin.admin.create') }}" class="btn-add-news">
                <i class='bx bx-plus'></i> Tambah Admin
            </a>
        </div>
    </div>

<div class="content-card">
        @php
            $sessionMessage = '';
            $sessionType = '';
            if(session('success')) {
                $sessionMessage = session('success');
                $sessionType = 'success';
            } elseif(session('error')) {
                $sessionMessage = session('error');
                $sessionType = 'error';
            }
        @endphp
        
        @if($sessionMessage)
            <div id="session-notification-data" data-message="{{ $sessionMessage }}" data-type="{{ $sessionType }}" style="display: none;"></div>
        @endif

@if($admins->count() > 0)
            @foreach($admins as $admin)
                <div class="news-list-item">
                    <div class="admin-avatar" @if($admin->foto_profil && file_exists(public_path('storage/' . $admin->foto_profil))) onclick="previewPhoto('{{ asset('storage/' . $admin->foto_profil) }}', '{{ $admin->name }}')" data-bs-toggle="modal" data-bs-target="#photoPreviewModal" @endif>
                        @if($admin->id === auth()->id())
                            <div class="current-user-badge">
                                <i class='bx bx-shield-check'></i>
                            </div>
                        @endif
                        @if($admin->foto_profil && file_exists(public_path('storage/' . $admin->foto_profil)))
                            <img src="{{ asset('storage/' . $admin->foto_profil) }}" 
                                 alt="Foto Profil" 
                                 style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                        @else
                            <i class='bx bx-user'></i>
                        @endif
                    </div>
                    <div class="news-content-wrapper">
                        <div class="news-header">
                            <h3>{{ $admin->name }}</h3>
                            @if($admin->id === auth()->id())
                                <span class="badge-current-user">Anda</span>
                            @endif
                        </div>
                        <p class="admin-email">
                            <i class='bx bx-envelope'></i> {{ $admin->email }}
                        </p>
                        <p class="admin-role">
                            @if($admin->role === 'super_admin')
                                <span class="badge badge-super-admin"><i class='bx bx-shield-check'></i> Super Admin</span>
                            @else
                                <span class="badge badge-admin"><i class='bx bx-user'></i> Admin</span>
                            @endif
                        </p>
<div class="news-meta-row">
                            <span class="meta-item">
                                <i class='bx bx-time-five'></i> 
                                {{ optional($admin->updated_at)->diffForHumans() ?? '-' }}
                            </span>
                            @if($admin->id === auth()->id())
                                <span class="badge-status status-active">
                                    <i class='bx bx-shield-check'></i> Aktif
                                </span>
                            @endif
                        </div>
                        <div class="action-buttons">
                            <a href="{{ route('admin.admin.edit', $admin) }}" class="btn-action btn-edit">
                                <i class='bx bx-edit-alt'></i> Edit
                            </a>
                            @if($admin->id !== auth()->id())
                                @if($isSuperAdmin && $admin->role === 'admin')
                                    <button type="button" class="btn-action btn-delete" onclick='deleteAdmin({{ $admin->id }}, @json($admin->name))'>
                                        <i class='bx bx-trash'></i> Hapus
                                    </button>
                                @elseif(!$isSuperAdmin)
                                    <button type="button" class="btn-action btn-delete" onclick='deleteAdmin({{ $admin->id }}, @json($admin->name))'>
                                        <i class='bx bx-trash'></i> Hapus
                                    </button>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
@endforeach

            <!-- Pagination -->
            <div class="pagination-wrapper">
                {{ $admins->links() }}
            </div>
        @else
            <div class="empty-state">
                <i class='bx bx-user-plus'></i>
                <h4>Belum ada admin</h4>
                <p>Belum ada admin yang terdaftar. Klik "Tambah Admin" untuk membuat admin pertama.</p>
            </div>
        @endif
    </div>
</div>

<!-- Photo Preview Modal -->
<div class="modal fade" id="photoPreviewModal" tabindex="-1" aria-labelledby="photoPreviewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="photoPreviewModalLabel">
                    <i class='bx bx-user'></i> Foto Profil
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="previewPhoto" src="" alt="Foto Profil" style="max-width: 100%; max-height: 70vh; border-radius: 10px;">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class='bx bx-x'></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<style>
.search-box {
    display: flex;
    align-items: center;
    gap: 10px;
    min-width: 320px;
    padding: 10px 14px;
    background: linear-gradient(135deg, #ffffff 0%, #fff8f2 100%);
    border: 1px solid #f3d2b7;
    border-radius: 14px;
    box-shadow: 0 4px 14px rgba(217, 107, 24, 0.08);
    transition: all 0.25s ease;
}

.search-box:hover {
    border-color: #e7b489;
    box-shadow: 0 8px 20px rgba(217, 107, 24, 0.14);
}

.search-box:focus-within {
    border-color: #d96b18;
    box-shadow: 0 0 0 4px rgba(217, 107, 24, 0.15), 0 10px 24px rgba(217, 107, 24, 0.2);
    transform: translateY(-1px);
}

.search-icon-wrap {
    width: 32px;
    height: 32px;
    border-radius: 10px;
    background: linear-gradient(135deg, #ffeede 0%, #ffd6b5 100%);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    color: #c85e0f;
    flex-shrink: 0;
}

.search-icon-wrap i {
    font-size: 18px;
}

.search-box input {
    width: 100%;
    border: none;
    outline: none;
    background: transparent;
    color: #3d3d3d;
    font-size: 14px;
    font-weight: 500;
}

.search-box input::placeholder {
    color: #a78a73;
    font-weight: 400;
}

.btn-add-news {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #ffffff;
    color: #d96b18 !important;
    border: 1px solid #f1c7a3;
    border-radius: 10px;
    padding: 9px 16px;
    font-weight: 600;
    letter-spacing: 0.1px;
    text-decoration: none;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
    transition: all 0.2s ease;
}

.btn-add-news:hover {
    background: #fff7f1;
    border-color: #e5a36d;
    color: #bf5a0f !important;
    box-shadow: 0 4px 12px rgba(217, 107, 24, 0.14);
}

.btn-add-news:active {
    transform: translateY(1px);
    box-shadow: 0 2px 6px rgba(217, 107, 24, 0.12);
}

.btn-add-news i {
    font-size: 17px;
}

.btn-action.btn-edit {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 14px;
    border-radius: 10px;
    border: 1px solid rgba(246, 144, 58, 0.25);
    background: linear-gradient(135deg, #fff9f4 0%, #ffefdF 100%);
    color: #d96b18 !important;
    font-weight: 700;
    text-decoration: none;
    box-shadow: 0 4px 10px rgba(229, 122, 42, 0.12);
    transition: all 0.25s ease;
}

.btn-action.btn-edit:hover {
    background: linear-gradient(135deg, #ffeede 0%, #ffe2c6 100%);
    color: #c85e0f !important;
    border-color: rgba(229, 122, 42, 0.45);
    transform: translateY(-1px);
    box-shadow: 0 8px 16px rgba(229, 122, 42, 0.2);
}

.btn-action.btn-edit i {
    font-size: 16px;
}

.admin-avatar {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: linear-gradient(135deg, #F6903A 0%, #E57A2A 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 24px;
    position: relative;
    flex-shrink: 0;
    cursor: pointer;
    overflow: hidden;
}

.admin-avatar img {
    cursor: pointer;
}

.admin-avatar:hover {
    transform: scale(1.05);
    box-shadow: 0 4px 12px rgba(246, 144, 58, 0.4);
}

.current-user-badge {
    position: absolute;
    top: -5px;
    right: -5px;
    width: 20px;
    height: 20px;
    background: #28a745;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 12px;
    border: 2px solid white;
    font-weight: 500;
}

.admin-email {
    color: #6c757d;
    font-size: 14px;
    margin: 8px 0;
    display: flex;
    align-items: center;
    gap: 6px;
}

.admin-role {
    margin: 8px 0;
}

.badge-super-admin {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    color: white;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}

.badge-admin {
    background: linear-gradient(135deg, #6c757d 0%, #5a6268 100%);
    color: white;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}

.badge-current-user {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    color: white;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
    margin-left: 10px;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}

.status-active {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    color: white;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}

.news-list-item {
    display: flex;
    align-items: flex-start;
    padding: 20px;
    border: 1px solid #e9ecef;
    border-radius: 12px;
    margin-bottom: 15px;
    background: white;
    transition: all 0.3s ease;
    position: relative;
}

.news-list-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.08);
    border-color: #F6903A;
}

.news-content-wrapper {
    flex: 1;
    margin-left: 20px;
}

.news-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 10px;
}

.news-header h3 {
    margin: 0;
    font-size: 18px;
    font-weight: 600;
    color: #2c3e50;
}

.modal-header {
    background: linear-gradient(135deg, #F6903A 0%, #E57A2A 100%);
    color: white;
    border-bottom: none;
}

.modal-header .btn-close {
    filter: brightness(0) invert(1);
}

.modal-body {
    padding: 20px;
}

.modal-body .alert-warning {
    margin-bottom: 15px;
}

.btn-action.btn-delete {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 14px;
    border-radius: 10px;
    border: 1px solid rgba(220, 53, 69, 0.28);
    background: linear-gradient(135deg, #fff6f7 0%, #ffe9ec 100%);
    color: #c12f3f !important;
    font-weight: 700;
    text-decoration: none;
    box-shadow: 0 4px 10px rgba(220, 53, 69, 0.1);
    transition: all 0.25s ease;
}

.btn-action.btn-delete:hover {
    background: linear-gradient(135deg, #ffeef1 0%, #ffd9df 100%);
    color: #a92332 !important;
    border-color: rgba(200, 35, 51, 0.45);
    transform: translateY(-1px);
    box-shadow: 0 8px 16px rgba(200, 35, 51, 0.16);
}

.btn-action.btn-delete i {
    font-size: 16px;
}

.btn-danger {
    background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
    border: none;
    padding: 8px 16px;
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(220, 53, 69, 0.22);
    transition: all 0.2s ease;
}

.btn-danger:hover {
    background: linear-gradient(135deg, #c82333 0%, #bd2130 100%);
    transform: translateY(-1px);
    box-shadow: 0 8px 14px rgba(200, 35, 51, 0.28);
}

.btn-secondary {
    background-color: #6c757d;
    border: none;
    padding: 8px 16px;
}

.btn-secondary:hover {
    background-color: #5a6268;
}

.empty-state {
    text-align: center;
    padding: 60px 20px;
    color: #6c757d;
}

.empty-state i {
    font-size: 4rem;
    color: #F6903A;
    margin-bottom: 20px;
}

.empty-state h4 {
    font-size: 1.5rem;
    margin-bottom: 10px;
}

.pagination-wrapper {
    margin-top: 20px;
    display: flex;
    justify-content: center;
}
</style>

<script>
function previewPhoto(photoUrl, adminName) {
    document.getElementById('previewPhoto').src = photoUrl;
    document.getElementById('photoPreviewModalLabel').innerHTML = '<i class="bx bx-user"></i> Foto Profil - ' + adminName;
    showNotification('Membuka foto profil ' + adminName, 'info');
}

function deleteAdmin(id, name) {
    showDeleteConfirm(id, name);
}

function showDeleteConfirm(id, name) {
    const existingModal = document.getElementById('delete-confirm-modal');
    if (existingModal) {
        existingModal.remove();
    }

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
                    <strong style="color: #1f2937; font-size: 16px;"></strong>?
                </p>
            </div>
            <div style="display: flex; gap: 12px; justify-content: center;">
                <button type="button" onclick="closeDeleteModal()" style="flex: 1; padding: 12px 24px; border: none;
                            border-radius: 10px; background: #f3f4f6; color: #374151; font-weight: 500;
                            cursor: pointer; transition: all 0.2s;">Batal</button>
                <button type="button" onclick="confirmDelete(${id})" style="flex: 1; padding: 12px 24px; border: none;
                            border-radius: 10px; background: #ef4444; color: white; font-weight: 500;
                            cursor: pointer; transition: all 0.2s;">Ya, Hapus</button>
            </div>
        </div>
    `;

    modal.querySelector('strong').textContent = `"${name}"`;

    const style = document.createElement('style');
    style.id = 'delete-confirm-animation-style';
    style.textContent = `
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        @keyframes scaleIn { from { transform: scale(0.9); opacity: 0; } to { transform: scale(1); opacity: 1; } }
    `;
    document.head.appendChild(style);
    modal.onclick = function(e) {
        if (e.target === modal) closeDeleteModal();
    };
    document.body.appendChild(modal);
}

function closeDeleteModal() {
    const modal = document.getElementById('delete-confirm-modal');
    const style = document.getElementById('delete-confirm-animation-style');
    if (modal) {
        modal.style.opacity = '0';
        modal.style.transform = 'scale(0.9)';
        modal.style.transition = 'all 0.3s ease';
        setTimeout(() => {
            modal.remove();
            if (style) style.remove();
        }, 300);
    }
}

function confirmDelete(id) {
    closeDeleteModal();
    showNotification('Menghapus admin...', 'info');

    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '/admin/admin/' + id;
    form.style.display = 'none';
    form.innerHTML = `
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="_method" value="DELETE">
    `;
    document.body.appendChild(form);
    setTimeout(() => form.submit(), 500);
}

window.closeDeleteModal = closeDeleteModal;
window.confirmDelete = confirmDelete;

// Show session notification on page load (only one popup)
document.addEventListener('DOMContentLoaded', function() {
    const sessionData = document.getElementById('session-notification-data');
    if (sessionData) {
        const message = sessionData.getAttribute('data-message');
        const type = sessionData.getAttribute('data-type');
        if (message) {
            showNotification(message, type);
        }
    }
});

// Custom Notification Function (same as data-kelurahan page)
function showNotification(message, type = 'success') {
    // Hapus notifikasi yang ada terlebih dahulu
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
    
    // Tambahkan animasi CSS
    const style = document.createElement('style');
    style.textContent = `
        @keyframes slideInRight { 
            from { transform: translateX(120%); opacity: 0; } 
            to { transform: translateX(0); opacity: 1; } 
        }
    `;
    document.head.appendChild(style);
    document.body.appendChild(notification);
    
    // Hapus notifikasi setelah 3.5 detik
    setTimeout(() => {
        notification.style.transform = 'translateX(120%)';
        notification.style.opacity = '0';
        notification.style.transition = 'all 0.4s ease';
        setTimeout(() => { notification.remove(); style.remove(); }, 400);
    }, 3500);
}

// Search functionality
document.getElementById('searchAdmin').addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const items = document.querySelectorAll('.news-list-item');
    let visibleCount = 0;
    
    items.forEach(item => {
        const name = item.querySelector('h3').textContent.toLowerCase();
        const email = item.querySelector('.admin-email').textContent.toLowerCase();
        
        if (name.includes(searchTerm) || email.includes(searchTerm)) {
            item.style.display = 'flex';
            visibleCount++;
        } else {
            item.style.display = 'none';
        }
    });

    if (searchTerm.trim() !== '' && visibleCount === 0) {
        showNotification('Tidak ada admin yang cocok dengan pencarian', 'warning');
    }
});

document.querySelector('.btn-add-news')?.addEventListener('click', function(e) {
    e.preventDefault();
    const targetUrl = this.href;
    this.innerHTML = '<i class="bx bx-loader-alt bx-spin"></i> Membuka...';
    showNotification('Membuka form tambah admin', 'info');
    setTimeout(() => {
        window.location.href = targetUrl;
    }, 500);
});

document.querySelectorAll('.btn-action.btn-edit').forEach(button => {
    button.addEventListener('click', function(e) {
        e.preventDefault();
        const targetUrl = this.href;
        this.innerHTML = '<i class="bx bx-loader-alt bx-spin"></i> Membuka...';
        showNotification('Membuka form edit admin', 'info');
        setTimeout(() => {
            window.location.href = targetUrl;
        }, 500);
    });
});
</script>
@endsection
