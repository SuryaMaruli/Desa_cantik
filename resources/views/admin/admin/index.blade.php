@extends('layouts.admin')

@section('page-title', 'Kelola Admin')

@section('content')
<div class="home-content">
    <div class="news-toolbar">
        <div class="toolbar-container">
            <div class="search-box">
                <i class='bx bx-search'></i>
                <input type="text" placeholder="Cari admin..." id="searchAdmin">
            </div>
            <a href="{{ route('admin.admin.create') }}" class="btn-add-news">
                <i class='bx bx-plus'></i> Tambah Admin
            </a>
        </div>
    </div>

    <div class="content-card">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($admins->count() > 0)
            @foreach($admins as $admin)
                <div class="news-list-item">
                    <div class="admin-avatar">
                        @if($admin->id === auth()->id())
                            <div class="current-user-badge">
                                <i class='bx bx-shield-check'></i>
                            </div>
                        @endif
                        <i class='bx bx-user'></i>
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
                        <div class="news-meta-row">
                            <span class="meta-item">
                                <i class='bx bx-calendar'></i> 
                                {{ $admin->created_at->format('d M Y') }}
                            </span>
                            <span class="meta-item">
                                <i class='bx bx-time-five'></i> 
                                {{ $admin->updated_at->diffForHumans() }}
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
                                <button type="button" class="btn-action btn-delete" onclick="deleteAdmin({{ $admin->id }}, '{{ $admin->name }}')">
                                    <i class='bx bx-trash'></i> Hapus
                                </button>
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

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">
                    <i class='bx bx-error-circle'></i> Konfirmasi Hapus
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning">
                    <i class='bx bx-error'></i>
                    <strong>Perhatian!</strong> Tindakan ini tidak dapat dibatalkan.
                </div>
                <p>Apakah Anda yakin ingin menghapus admin "<strong id="adminName"></strong>"?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class='bx bx-x'></i> Batal
                </button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class='bx bx-trash'></i> Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
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
}

.admin-email {
    color: #6c757d;
    font-size: 14px;
    margin: 8px 0;
    display: flex;
    align-items: center;
    gap: 6px;
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

.btn-danger {
    background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
    border: none;
    padding: 8px 16px;
}

.btn-danger:hover {
    background: linear-gradient(135deg, #c82333 0%, #bd2130 100%);
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
function deleteAdmin(id, name) {
    document.getElementById('adminName').textContent = name;
    document.getElementById('deleteForm').action = '/admin/admin/' + id;
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}

// Search functionality
document.getElementById('searchAdmin').addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const items = document.querySelectorAll('.news-list-item');
    
    items.forEach(item => {
        const name = item.querySelector('h3').textContent.toLowerCase();
        const email = item.querySelector('.admin-email').textContent.toLowerCase();
        
        if (name.includes(searchTerm) || email.includes(searchTerm)) {
            item.style.display = 'flex';
        } else {
            item.style.display = 'none';
        }
    });
});
</script>
@endsection
