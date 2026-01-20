@extends('layouts.admin')

@section('title', 'Informasi Publik - Admin Kelurahan Citangkil')
@section('page-title', 'Kelola Informasi Publik')

@section('content')
<div class="container-fluid">
    <!-- Alert Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Informasi Publik</h4>
            <p class="text-muted mb-0">Kelola informasi publik yang akan ditampilkan di halaman dashboard</p>
        </div>
        <a href="{{ route('admin.informasi-publik.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Tambah Informasi
        </a>
    </div>

    <!-- Table Section -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th style="width: 60px;">No</th>
                            <th>Judul</th>
                            <th>Sub Deskripsi</th>
                            <th style="width: 150px;">Dibuat</th>
                            <th style="width: 120px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($informasiPubliks as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <strong>{{ $item->judul }}</strong>
                            </td>
                            <td>
                                <span class="text-muted">{{ Str::limit($item->sub_deskripsi, 100) }}</span>
                            </td>
                            <td>
                                <small class="text-muted">{{ $item->created_at->format('d M Y') }}</small>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('admin.informasi-publik.edit', $item->id) }}" 
                                       class="btn btn-outline-primary" 
                                       title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.informasi-publik.destroy', $item->id) }}" 
                                          method="POST" 
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus informasi ini?');"
                                          style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4">
                                <i class="fas fa-info-circle fa-3x text-muted mb-3 d-block"></i>
                                <p class="text-muted">Belum ada data informasi publik</p>
                                <a href="{{ route('admin.informasi-publik.create') }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-plus me-2"></i>Tambah Informasi
                                </a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
