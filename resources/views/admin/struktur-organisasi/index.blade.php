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
        padding: 24px;
    }

    .modal-header {
        background: #F6903A;
        color: white;
        padding: 16px 24px;
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

    .btn-close {
        background: none;
        border: none;
        color: white;
        font-size: 24px;
        cursor: pointer;
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
</style>

<div class="container-fluid p-4">
    @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-circle me-2"></i>
            {{ session('error') }}
        </div>
    @endif

<div class="header-card">
        <div class="header-content">
            <div class="header-text">
                <h1>Struktur Organisasi</h1>
                <p>Kelola gambar struktur organisasi kelurahan</p>
            </div>
            @if($struktur->count() == 0)
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
            Daftar Gambar Struktur Organisasi
        </div>

        @if($struktur->count() > 0)
            @foreach($struktur as $item)
            <div class="table-row">
                <div class="row w-100">
                    <div class="col-md-8">
                        <img src="{{ asset('storage/' . $item->gambar) }}" alt="Struktur Organisasi" class="image-preview">
                    </div>
<div class="col-md-4 d-flex align-items-center justify-content-end gap-2">
                        <button type="button" class="btn btn-primary btn-sm btn-edit" data-bs-toggle="modal" data-bs-target="#editModal{{ $item->id }}">
                            <i class="fas fa-edit me-1"></i> Edit
                        </button>
                        <form action="{{ route('admin.struktur-organisasi.destroy', $item->id) }}" method="POST" class="d-inline">
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
                        <form action="{{ route('admin.struktur-organisasi.update', $item->id) }}" method="POST" enctype="multipart/form-data">
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
                <h3>Informasi Struktur Organisasi belum ditambahkan</h3>
                <p>Silakan upload gambar struktur organisasi terlebih dahulu.</p>
            </div>
        @endif
    </div>
</div>

<!-- Upload Modal -->
<div class="modal fade" id="uploadModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Tambah Gambar Struktur Organisasi</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.struktur-organisasi.store') }}" method="POST" enctype="multipart/form-data">
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

<!-- SweetAlert2 CSS & JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Show success/error messages with SweetAlert
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: '{{ session('error') }}',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 4000,
            timerProgressBar: true
        });
    @endif

    // Delete confirmation with SweetAlert
    document.querySelectorAll('.btn-delete').forEach(function(button) {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const form = this.closest('form');
            Swal.fire({
                icon: 'warning',
                title: 'Apakah Anda yakin?',
                text: 'Data yang dihapus tidak dapat dikembalikan!',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });

    // Edit click - show confirmation
    document.querySelectorAll('.btn-edit').forEach(function(button) {
        button.addEventListener('click', function(e) {
            const target = this.getAttribute('data-bs-target');
            Swal.fire({
                icon: 'info',
                title: 'Edit Foto',
                text: 'Anda akan mengedit foto Struktur Organisasi.',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true
            });
        });
    });
});
</script>
@endsection
