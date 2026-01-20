@extends('layouts.admin')

@section('title', 'Edit Informasi Publik - Admin Kelurahan Citangkil')
@section('page-title', 'Edit Informasi Publik')

@section('content')
<div class="container-fluid">
    <!-- Alert Messages -->
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <strong>Terjadi kesalahan:</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Form Section -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.informasi-publik.update', $informasiPublik->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <!-- Judul -->
                        <div class="mb-3">
                            <label for="judul" class="form-label">Judul <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('judul') is-invalid @enderror" 
                                   id="judul" 
                                   name="judul" 
                                   value="{{ old('judul', $informasiPublik->judul) }}"
                                   placeholder="Masukkan judul informasi"
                                   required>
                            @error('judul')
                                <div class="invalid-feedback d-block">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Sub Deskripsi -->
                        <div class="mb-3">
                            <label for="sub_deskripsi" class="form-label">Sub Deskripsi <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('sub_deskripsi') is-invalid @enderror" 
                                   id="sub_deskripsi" 
                                   name="sub_deskripsi" 
                                   value="{{ old('sub_deskripsi', $informasiPublik->sub_deskripsi) }}"
                                   placeholder="Masukkan sub deskripsi singkat"
                                   required>
                            @error('sub_deskripsi')
                                <div class="invalid-feedback d-block">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Deskripsi -->
                        <div class="mb-4">
                            <label for="deskripsi" class="form-label">Deskripsi Lengkap <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                      id="deskripsi" 
                                      name="deskripsi" 
                                      rows="6"
                                      placeholder="Masukkan deskripsi lengkap informasi"
                                      required>{{ old('deskripsi', $informasiPublik->deskripsi) }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback d-block">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Info Timestamp -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <small class="text-muted">
                                    <i class="fas fa-calendar-plus me-1"></i>
                                    Dibuat: {{ $informasiPublik->created_at->format('d M Y H:i') }}
                                </small>
                            </div>
                            <div class="col-md-6">
                                <small class="text-muted">
                                    <i class="fas fa-calendar-edit me-1"></i>
                                    Diperbarui: {{ $informasiPublik->updated_at->format('d M Y H:i') }}
                                </small>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Perbarui
                            </button>
                            <a href="{{ route('admin.informasi-publik.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                            <form action="{{ route('admin.informasi-publik.destroy', $informasiPublik->id) }}" 
                                  method="POST" 
                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus informasi ini?');"
                                  style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-trash me-2"></i>Hapus
                                </button>
                            </form>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Info Card -->
        <div class="col-lg-4">
            <div class="card bg-light">
                <div class="card-body">
                    <h6 class="card-title">
                        <i class="fas fa-info-circle me-2"></i>Informasi
                    </h6>
                    <p class="card-text small text-muted">
                        Informasi publik akan ditampilkan di halaman dashboard pada bagian "Informasi Publik". Pastikan data yang dimasukkan akurat dan mudah dipahami oleh masyarakat.
                    </p>
                    <hr>
                    <h6 class="card-title">
                        <i class="fas fa-lightbulb me-2"></i>Tips
                    </h6>
                    <ul class="small text-muted">
                        <li>Judul singkat dan jelas</li>
                        <li>Sub deskripsi maksimal 255 karakter</li>
                        <li>Deskripsi lengkap bisa berisi detail informasi</li>
                        <li>Gunakan bahasa yang mudah dimengerti</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
