@extends('layouts.admin')

@section('title', 'Profil Saya - Admin')

@section('page-title', 'Profil Saya')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Profil Saya</h5>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('admin.profil.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <div class="text-center">
                                    <label for="foto_profil" class="form-label d-block">Foto Profil</label>
                                    <div class="mb-2">
                                        @if($user->foto_profil)
                                            <img src="{{ asset('storage/' . $user->foto_profil) }}"
                                                 alt="Foto Profil" 
                                                 class="rounded-circle cursor-pointer"
                                                 style="width: 120px; height: 120px; object-fit: cover; border: 3px solid #F6903A; cursor: pointer;"
                                                 data-bs-toggle="modal"
                                                 data-bs-target="#fotoProfilModal"
                                                 onclick="document.getElementById('fotoProfilFull').src = this.src">
                                        @else
                                            <div class="bg-secondary rounded-circle d-inline-flex align-items-center justify-content-center text-white" 
                                                 style="width: 120px; height: 120px; font-size: 48px; cursor: pointer;"
                                                 data-bs-toggle="modal"
                                                 data-bs-target="#fotoProfilModal">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                        @endif
                                    </div>
                                    <small class="text-muted d-block">Klik foto untuk memperbesar</small>
                                    <input type="file" class="form-control mt-2" id="foto_profil" name="foto_profil" 
                                           accept="image/jpeg,image/png,image/jpg,image/gif,image/webp"
                                           style="max-width: 300px; margin: 0 auto;">
                                    <small class="text-muted d-block mt-1">Format: JPEG, PNG, JPG, GIF, WebP. Max 2MB.</small>
                                    @error('foto_profil')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Modal untuk melihat foto profil penuh -->
                        <div class="modal fade" id="fotoProfilModal" tabindex="-1" aria-labelledby="fotoProfilModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="fotoProfilModalLabel">Foto Profil</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body text-center">
                                        @if($user->foto_profil)
                                            <img src="{{ asset('storage/' . $user->foto_profil) }}"
                                                 alt="Foto Profil Penuh" 
                                                 id="fotoProfilFull"
                                                 class="img-fluid"
                                                 style="max-height: 70vh; object-fit: contain;">
                                        @else
                                            <p class="text-muted">Tidak ada foto profil</p>
                                        @endif
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="name" name="name" 
                                           value="{{ old('name', $user->name) }}" required>
                                    @error('name')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="email" name="email" 
                                           value="{{ old('email', $user->email) }}" required>
                                    @error('email')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password Baru <small class="text-muted">(Kosongkan jika tidak ingin mengubah)</small></label>
                                    <input type="password" class="form-control" id="password" name="password" 
                                           placeholder="Masukkan password baru">
                                    @error('password')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                                    <input type="password" class="form-control" id="password_confirmation" 
                                           name="password_confirmation" placeholder="Konfirmasi password baru">
                                    @error('password_confirmation')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary me-2">
                                <i class='bx bx-arrow-back'></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class='bx bx-save'></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
