@extends('layouts.admin')

@section('title', 'Kelola Beranda - Admin')

@section('page-title', 'Kelola Beranda')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Kelola Beranda</h5>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if($beranda)
                        <form action="{{ route('admin.beranda.update', $beranda->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                    @else
                        <form action="{{ route('admin.beranda.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                    @endif

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nama_kelurahan" class="form-label">Nama Kelurahan <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="nama_kelurahan" name="nama_kelurahan" 
                                           value="{{ old('nama_kelurahan', $beranda->nama_kelurahan ?? '') }}" required>
                                    @error('nama_kelurahan')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="email" name="email" 
                                           value="{{ old('email', $beranda->email ?? '') }}" required>
                                    @error('email')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="no_hp" class="form-label">No. HP <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="no_hp" name="no_hp" 
                                           value="{{ old('no_hp', $beranda->no_hp ?? '') }}" required>
                                    @error('no_hp')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" required>{{ old('deskripsi', $beranda->deskripsi ?? '') }}</textarea>
                            @error('deskripsi')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="gambar_header" class="form-label">Gambar Header</label>
                                    <input type="file" class="form-control" id="gambar_header" name="gambar_header" 
                                           accept="image/*" onchange="previewImage(this, 'gambarHeaderPreview')">
                                    @error('gambar_header')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                    
                                    @if($beranda && $beranda->gambar_header)
                                        <div class="mt-2">
                                            <small class="text-muted">Gambar saat ini:</small>
                                            <div class="mt-1">
                                                <img src="{{ asset('storage/' . $beranda->gambar_header) }}" 
                                                     alt="Gambar Header" class="img-thumbnail" style="max-height: 150px;">
                                                <div class="form-check mt-1">
                                                    <input class="form-check-input" type="checkbox" id="remove_gambar_header" name="remove_gambar_header" value="1">
                                                    <label class="form-check-label" for="remove_gambar_header">
                                                        Hapus gambar ini
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    <div id="gambarHeaderPreview" class="mt-2"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="logo" class="form-label">Logo</label>
                                    <input type="file" class="form-control" id="logo" name="logo" 
                                           accept="image/*" onchange="previewImage(this, 'logoPreview')">
                                    @error('logo')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                    
                                    @if($beranda && $beranda->logo)
                                        <div class="mt-2">
                                            <small class="text-muted">Logo saat ini:</small>
                                            <div class="mt-1">
                                                <img src="{{ asset('storage/' . $beranda->logo) }}" 
                                                     alt="Logo" class="img-thumbnail" style="max-height: 150px;">
                                                <div class="form-check mt-1">
                                                    <input class="form-check-input" type="checkbox" id="remove_logo" name="remove_logo" value="1">
                                                    <label class="form-check-label" for="remove_logo">
                                                        Hapus logo ini
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    <div id="logoPreview" class="mt-2"></div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary me-2">
                                <i class='bx bx-arrow-back'></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class='bx bx-save'></i> 
                                {{ $beranda ? 'Perbarui' : 'Simpan' }} Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
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
    } else {
        preview.innerHTML = '';
    }
}
</script>
@endpush
