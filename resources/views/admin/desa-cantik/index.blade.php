@extends('layouts.admin')

@section('title', 'Desa Cantik - Admin Kelurahan Gunung Sugih')
@section('page-title', 'Desa Cantik')

@section('content')
<div class="container-fluid">
    {{-- ALERT MESSAGES --}}
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

    <main class="container">
        
        {{-- === VIEW MODE === --}}
        <div id="view-mode">
            <div class="card header-card">
                <div class="header-content">
                    <div class="header-info">
                        <h1>Desa Cantik</h1>
                        <p>Kelola konten program Desa Cinta Statistik</p>
                    </div>
                    <button class="btn btn-edit" onclick="toggleMode()">
                        <i class="fas fa-edit"></i> Edit Konten
                    </button>
                </div>
            </div>

            {{-- View: Tentang --}}
            <div class="card">
                <h2>Tentang Program Desa Cantik</h2>
                <div class="info-group">
                    <p class="text-content">
                        {{ $tentang->deskripsi ?? 'Belum ada deskripsi program.' }}
                    </p>
                </div>
            </div>

            {{-- View: Metadata --}}
            <div class="card">
                <h2>Metadata Statistik</h2>
                <div class="metadata-grid">
                    @forelse($metadata as $item)
                    <div class="meta-item">
                        <i class="fas fa-database meta-icon"></i>
                        <h3>{{ $item->nama_metadata }}</h3>
                        <p>{{ $item->deskripsi }}</p>
                        @if($item->file_pdf)
                            <div class="mt-2">
                                <a href="{{ url('/storage/' . $item->file_pdf) }}" target="_blank" class="btn btn-sm btn-primary">
                                    <i class="fas fa-file-pdf"></i> Lihat PDF
                                </a>
                            </div>
                        @endif
                        @if($item->link)
                            <div class="mt-1">
                                <a href="{{ $item->link }}" target="_blank" class="btn btn-sm btn-secondary">
                                    <i class="fas fa-external-link-alt"></i> Link Eksternal
                                </a>
                            </div>
                        @endif
                    </div>
                    @empty
                    <div class="meta-item"><p>Belum ada data metadata.</p></div>
                    @endforelse
                </div>
            </div>

            {{-- View: Output --}}
            <div class="card">
                <h2>Output Program</h2>
                <div class="output-grid">
                    @forelse($outputPrograms as $index => $program)
                    <div class="output-item">
                        <div class="number-badge">{{ $index + 1 }}</div>
                        <div class="output-content">
                            <h4>{{ $program->judul_program }}</h4>
                            <p>{{ $program->deskripsi_program }}</p>
                            @if($program->informasi_tambahan)
                                <p class="text-muted small">{{ $program->informasi_tambahan }}</p>
                            @endif
                            @if($program->gambar)
                                <img src="{{ asset('storage/' . $program->gambar) }}" class="img-fluid rounded mt-2" style="max-height: 150px;">
                            @endif
                        </div>
                    </div>
                    @empty
                    <div class="output-item"><p>Belum ada data output.</p></div>
                    @endforelse
                </div>
            </div>
        </div>


        {{-- === EDIT MODE === --}}
        <div id="edit-mode" style="display: none;">
            <div class="card header-card">
                <div class="header-content">
                    <div class="header-info">
                        <h1>Mode Edit</h1>
                        <p>Silahkan ubah data di bawah ini</p>
                    </div>
                    <div>
                        <button class="btn btn-secondary" onclick="toggleMode()" style="margin-right: 10px;">
                            <i class="fas fa-times"></i> Batal
                        </button>
                        <button class="btn btn-save" id="btn-save-all" onclick="saveMode()">
                            <i class="fas fa-save"></i> Simpan Semua Perubahan
                        </button>
                    </div>
                </div>
            </div>

            {{-- Edit: Tentang --}}
            <div class="card">
                <h2>Tentang Program Desa Cantik</h2>
                <form action="{{ route('admin.desa-cantik.update-tentang') }}" method="POST" class="edit-form">
                    @csrf
                    {{-- Tentang biasanya POST, tidak perlu @method('PUT') kecuali di route didefinisikan PUT --}}
                    <div class="form-group">
                        <label class="form-label">Deskripsi</label>
                        <textarea class="form-textarea" name="deskripsi">{{ $tentang->deskripsi ?? '' }}</textarea>
                    </div>
                </form>
            </div>

            {{-- Edit: Metadata --}}
            <div class="card">
                <h2>Metadata Statistik</h2>
                <div class="metadata-grid" id="metadata-grid-edit">
                    @foreach($metadata as $item)
                    <div class="meta-item">
                        {{-- Form Update --}}
                        <form action="{{ route('admin.desa-cantik.update-metadata', $item->id_metadata) }}" method="POST" class="edit-form">
                            @csrf
                            @method('PUT') {{-- Pastikan Route di web.php pakai Route::put --}}
                            <div class="text-center mb-2"><i class="fas fa-database fa-2x"></i></div>
                            <input type="text" name="nama_metadata" class="form-input card-input mb-2" value="{{ $item->nama_metadata }}">
                            <textarea name="deskripsi" class="form-input card-input mb-2" rows="3">{{ $item->deskripsi }}</textarea>
                            
                            {{-- File PDF --}}
                            @if($item->file_pdf)
                                <div class="mb-2">
                                    <small class="text-muted d-block mb-1">PDF saat ini:</small>
                                    <a href="{{ url('/storage/' . $item->file_pdf) }}" target="_blank" class="btn btn-sm btn-outline-primary me-2">
                                        <i class="fas fa-eye"></i> Lihat
                                    </a>
                                </div>
                            @endif
                            <input type="file" name="file_pdf" class="form-input card-input mb-2" accept=".pdf">
                            
                            {{-- Link --}}
                            <input type="url" name="link" class="form-input card-input mb-2" placeholder="Link eksternal (opsional)" value="{{ $item->link ?? '' }}">
                        </form>
                        
                        {{-- Form Delete (Terpisah agar tidak ikut ke submit "Simpan Semua") --}}
                        <form action="{{ route('admin.desa-cantik.delete-metadata', $item->id_metadata) }}" method="POST" onsubmit="return confirm('Hapus data ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-delete w-100"><i class="fas fa-trash"></i> Hapus</button>
                        </form>
                    </div>
                    @endforeach
                </div>
                <button class="btn btn-add mt-3" onclick="addMetadata()"><i class="fas fa-plus"></i> Tambah Metadata</button>
            </div>

            {{-- Edit: Output Program --}}
            <div class="card">
                <h2>Output Program</h2>
                <div class="output-grid" id="output-grid-edit">
                    @foreach($outputPrograms as $index => $program)
                    <div class="output-item-edit">
                        <form action="{{ route('admin.desa-cantik.update-output', $program->id_program) }}" method="POST" enctype="multipart/form-data" class="edit-form w-100">
                            @csrf
                            @method('PUT') {{-- Pastikan Route di web.php pakai Route::put --}}
                            <div class="d-flex align-items-start">
                                <div class="number-badge me-3 mt-2">{{ $index + 1 }}</div>
                                <div class="flex-grow-1">
                                    <input type="text" name="judul_program" class="form-input card-input mb-2" value="{{ $program->judul_program }}">
                                    <textarea name="deskripsi_program" class="form-input card-input mb-2" rows="3">{{ $program->deskripsi_program }}</textarea>
                                    <textarea name="informasi_tambahan" class="form-input card-input mb-2" rows="2" placeholder="Info tambahan">{{ $program->informasi_tambahan }}</textarea>
                                    
                                    @if($program->gambar)
                                        <div class="mb-2">
                                            <img src="{{ asset('storage/' . $program->gambar) }}" height="60" class="rounded">
                                        </div>
                                    @endif
                                    <input type="file" name="gambar" class="form-input">
                                </div>
                            </div>
                        </form>
                        
                        <form action="{{ route('admin.desa-cantik.delete-output', $program->id_program) }}" method="POST" class="mt-2" onsubmit="return confirm('Hapus output ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-delete w-100"><i class="fas fa-trash"></i> Hapus</button>
                        </form>
                    </div>
                    @endforeach
                </div>
                <div class="add-card-container mt-3">
                    <button class="btn btn-add" onclick="addOutput()"><i class="fas fa-plus"></i> Tambah Output</button>
                </div>
            </div>
        </div>
    </main>
</div>

{{-- TEMPLATES UNTUK JAVASCRIPT (Hidden) --}}
{{-- Ini trik agar tidak ada syntax error JS karena Blade --}}
<template id="tpl-metadata-new">
    <div class="meta-item new-item" style="border: 2px dashed #00A86B;">
        <form action="{{ route('admin.desa-cantik.store-metadata') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <h4 class="text-center text-success mb-2">Item Baru</h4>
            <input type="text" name="nama_metadata" class="form-input card-input mb-2" placeholder="Nama Metadata" required>
            <textarea name="deskripsi" class="form-input card-input mb-2" placeholder="Deskripsi" required rows="3"></textarea>
            <input type="file" name="file_pdf" class="form-input card-input mb-2" accept=".pdf">
            <input type="url" name="link" class="form-input card-input mb-2" placeholder="Link eksternal (opsional)">
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-save w-100">Simpan</button>
                <button type="button" class="btn btn-secondary" onclick="this.closest('.meta-item').remove()">Batal</button>
            </div>
        </form>
    </div>
</template>

<template id="tpl-output-new">
    <div class="output-item-edit new-item" style="border: 2px dashed #00A86B;">
        <form action="{{ route('admin.desa-cantik.store-output') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <h4 class="text-center text-success mb-2">Item Baru</h4>
            <input type="text" name="judul_program" class="form-input card-input mb-2" placeholder="Judul Program" required>
            <textarea name="deskripsi_program" class="form-input card-input mb-2" placeholder="Deskripsi" required rows="3"></textarea>
            <textarea name="informasi_tambahan" class="form-input card-input mb-2" placeholder="Info Tambahan (Opsional)" rows="2"></textarea>
            <input type="file" name="gambar" class="form-input mb-2">
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-save w-100">Simpan</button>
                <button type="button" class="btn btn-secondary" onclick="this.closest('.output-item-edit').remove()">Batal</button>
            </div>
        </form>
    </div>
</template>

@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
    /* CSS Sederhana tapi Rapi */
    .container { max-width: 900px; margin: 0 auto; padding-bottom: 50px; }
    .card { background: white; border-radius: 10px; padding: 20px; margin-bottom: 20px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); border: 1px solid #eee; }
    h1 { font-size: 20px; font-weight: bold; margin: 0; }
    h2 { font-size: 18px; font-weight: 600; margin-bottom: 15px; border-bottom: 2px solid #f0f0f0; padding-bottom: 10px; }
    .btn { padding: 8px 15px; border: none; border-radius: 5px; cursor: pointer; color: white; display: inline-flex; align-items: center; gap: 5px; font-size: 14px; text-decoration: none; }
    .btn-edit { background: #10B981; }
    .btn-save { background: #3B82F6; }
    .btn-delete { background: #EF4444; }
    .btn-secondary { background: #6B7280; }
    .btn-add { background: #10B981; width: 100%; justify-content: center; padding: 10px; }
    .btn-sm { padding: 5px 10px; font-size: 12px; }
    .btn-primary { background: #3B82F6; }
    .btn-outline-primary { background: transparent; border: 1px solid #3B82F6; color: #3B82F6; }
    
    .form-input, .form-textarea { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 5px; font-size: 14px; }
    .card-input { background: #f9fafb; }
    
    .metadata-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 15px; }
    .meta-item { background: #f8f9fa; padding: 15px; border-radius: 8px; border: 1px solid #e5e7eb; }
    
    .output-grid { display: flex; flex-direction: column; gap: 15px; }
    .output-item, .output-item-edit { background: #f0fdf4; padding: 15px; border-radius: 8px; border: 1px solid #dcfce7; }
    .number-badge { background: #10B981; color: white; width: 25px; height: 25px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 12px; }
    
    .header-card { display: flex; justify-content: space-between; align-items: center; }
    .w-100 { width: 100%; }
    .mb-2 { margin-bottom: 0.5rem; }
    .mt-2 { margin-top: 0.5rem; }
    .mt-3 { margin-top: 1rem; }
    .d-flex { display: flex; }
    .align-items-start { align-items: flex-start; }
    .flex-grow-1 { flex-grow: 1; }
    .me-3 { margin-right: 1rem; }
    .gap-2 { gap: 0.5rem; }
    .text-center { text-align: center; }

    /* Visual refresh */
    .container {
        max-width: 1180px;
        padding: 18px 18px 64px;
    }

    .card {
        background: #ffffff;
        border: 1px solid rgba(15, 23, 42, 0.08);
        border-radius: 14px;
        box-shadow: 0 16px 36px rgba(15, 23, 42, 0.08);
        margin-bottom: 22px;
        overflow: hidden;
        padding: 24px;
        position: relative;
    }

    .card::before {
        background: linear-gradient(90deg, #f97316, #06b6d4, #22c55e, #8b5cf6);
        content: '';
        height: 5px;
        left: 0;
        position: absolute;
        top: 0;
        width: 100%;
    }

    .header-card {
        background: linear-gradient(135deg, #fff7ed 0%, #ecfeff 48%, #f0fdf4 100%);
        border-color: rgba(249, 115, 22, 0.18);
        padding: 28px;
    }

    .header-content {
        align-items: center;
        display: flex;
        gap: 18px;
        justify-content: space-between;
        width: 100%;
    }

    .header-info h1 {
        color: #1f2937;
        font-size: 28px;
        font-weight: 800;
        letter-spacing: 0;
        margin-bottom: 6px;
    }

    .header-info p {
        color: #64748b;
        font-size: 14px;
        font-weight: 600;
        margin: 0;
    }

    h2 {
        align-items: center;
        border-bottom: 1px solid #e5e7eb;
        color: #1f2937;
        display: flex;
        font-size: 20px;
        font-weight: 800;
        gap: 10px;
        margin-bottom: 18px;
        padding-bottom: 14px;
    }

    h2::before {
        background: #f97316;
        border-radius: 999px;
        content: '';
        height: 12px;
        width: 12px;
    }

    .text-content {
        background: linear-gradient(135deg, #ffffff 0%, #fff7ed 100%);
        border: 1px solid rgba(249, 115, 22, 0.14);
        border-left: 5px solid #f97316;
        border-radius: 12px;
        color: #475569;
        font-size: 15px;
        line-height: 1.8;
        margin: 0;
        padding: 18px 20px;
    }

    .metadata-grid {
        display: grid;
        gap: 18px;
        grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
    }

    .meta-item,
    .output-item,
    .output-item-edit {
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        box-shadow: 0 10px 24px rgba(15, 23, 42, 0.06);
        padding: 18px;
        transition: border-color .2s ease, box-shadow .2s ease, transform .2s ease;
    }

    .meta-item:hover,
    .output-item:hover,
    .output-item-edit:hover {
        border-color: rgba(249, 115, 22, 0.34);
        box-shadow: 0 16px 32px rgba(15, 23, 42, 0.10);
        transform: translateY(-2px);
    }

    .meta-icon {
        align-items: center;
        background: #fff7ed;
        border-radius: 10px;
        color: #f97316;
        display: inline-flex;
        font-size: 22px;
        height: 44px;
        justify-content: center;
        margin-bottom: 14px;
        width: 44px;
    }

    .meta-item h3,
    .output-content h4 {
        color: #1f2937;
        font-size: 16px;
        font-weight: 800;
        line-height: 1.35;
        margin-bottom: 10px;
    }

    .meta-item p,
    .output-content p {
        color: #64748b;
        font-size: 14px;
        line-height: 1.7;
        margin-bottom: 12px;
    }

    .output-grid {
        display: grid;
        gap: 18px;
        grid-template-columns: 1fr;
    }

    .output-item {
        align-items: flex-start;
        display: flex;
        gap: 16px;
    }

    .number-badge {
        background: linear-gradient(135deg, #f97316, #22c55e);
        box-shadow: 0 8px 18px rgba(249, 115, 22, 0.25);
        flex: 0 0 34px;
        font-size: 14px;
        height: 34px;
        width: 34px;
    }

    .btn {
        border-radius: 8px;
        font-weight: 750;
        justify-content: center;
        min-height: 38px;
        padding: 9px 14px;
        transition: box-shadow .2s ease, transform .2s ease, filter .2s ease;
    }

    .btn:hover {
        filter: brightness(0.98);
        transform: translateY(-1px);
    }

    .btn-edit:hover,
    .btn-add:hover,
    .btn-save:hover,
    .btn-primary:hover,
    .btn-delete:hover,
    .btn-secondary:hover {
        color: #fff;
    }

    .btn-outline-primary {
        background: #fff;
        border: 1px solid #2563eb;
        color: #2563eb;
    }

    .btn-outline-primary:hover {
        background: #eff6ff;
        border-color: #1d4ed8;
        color: #1d4ed8;
    }

    .btn-edit,
    .btn-add { background: #16a34a; }
    .btn-save,
    .btn-primary { background: #2563eb; }
    .btn-delete { background: #ef4444; }
    .btn-secondary { background: #64748b; }

    .form-label {
        color: #334155;
        font-size: 13px;
        font-weight: 800;
        margin-bottom: 8px;
    }

    .form-input,
    .form-textarea {
        background: #f8fafc;
        border: 1px solid #cbd5e1;
        border-radius: 10px;
        color: #1f2937;
        font-size: 14px;
        min-height: 42px;
        padding: 10px 12px;
        transition: border-color .2s ease, box-shadow .2s ease, background .2s ease;
    }

    .form-textarea,
    textarea.form-input {
        line-height: 1.6;
        min-height: 132px;
        resize: vertical;
    }

    .form-input:focus,
    .form-textarea:focus {
        background: #fff;
        border-color: #f97316;
        box-shadow: 0 0 0 4px rgba(249, 115, 22, 0.12);
        outline: none;
    }

    .new-item {
        background: linear-gradient(135deg, #f0fdf4 0%, #ecfeff 100%) !important;
        border: 2px dashed #22c55e !important;
    }

    #edit-mode .card {
        border-color: rgba(37, 99, 235, 0.12);
    }

    #edit-mode .header-card {
        background: linear-gradient(135deg, #eff6ff 0%, #f5f3ff 52%, #fff7ed 100%);
    }


    /* Keep edit buttons visible on hover */
    .btn-edit,
    .btn-edit:hover,
    .btn-add,
    .btn-add:hover {
        background-color: #16a34a !important;
        border-color: #16a34a !important;
        color: #ffffff !important;
    }

    .btn-save,
    .btn-save:hover,
    .btn-primary,
    .btn-primary:hover {
        background-color: #2563eb !important;
        border-color: #2563eb !important;
        color: #ffffff !important;
    }

    .btn-delete,
    .btn-delete:hover {
        background-color: #ef4444 !important;
        border-color: #ef4444 !important;
        color: #ffffff !important;
    }

    .btn-secondary,
    .btn-secondary:hover {
        background-color: #64748b !important;
        border-color: #64748b !important;
        color: #ffffff !important;
    }

    .btn-outline-primary,
    .btn-outline-primary:hover {
        background-color: #ffffff !important;
        border-color: #2563eb !important;
        color: #2563eb !important;
    }

    #edit-mode .btn:hover,
    #edit-mode .btn:focus {
        opacity: 1 !important;
        text-decoration: none !important;
        visibility: visible !important;
    }
    @media (max-width: 760px) {
        .container { padding: 12px 10px 48px; }
        .header-content { align-items: stretch; flex-direction: column; }
        .header-info h1 { font-size: 24px; }
        .card { padding: 18px; }
        .output-item { flex-direction: column; }
        #edit-mode .header-content > div:last-child { display: grid; gap: 10px; }
        #edit-mode .btn-secondary { margin-right: 0 !important; }
    }
</style>
@endpush

@push('scripts')
<script>
    // Toggle Mode Script
    function toggleMode() {
        const viewMode = document.getElementById('view-mode');
        const editMode = document.getElementById('edit-mode');
        
        if (viewMode.style.display === 'none') {
            viewMode.style.display = 'block';
            editMode.style.display = 'none';
        } else {
            viewMode.style.display = 'none';
            editMode.style.display = 'block';
            window.scrollTo(0, 0);
        }
    }

    // Add Metadata (Menggunakan Template agar tidak error syntax)
    function addMetadata() {
        const grid = document.getElementById('metadata-grid-edit');
        const tpl = document.getElementById('tpl-metadata-new');
        grid.insertAdjacentHTML('beforeend', tpl.innerHTML);
    }

    // Add Output
    function addOutput() {
        const grid = document.querySelector('.add-card-container'); // Insert before container button
        const tpl = document.getElementById('tpl-output-new');
        
        // Buat elemen div sementara
        const tempDiv = document.createElement('div');
        tempDiv.innerHTML = tpl.innerHTML;
        
        // Insert sebelum tombol tambah
        grid.parentNode.insertBefore(tempDiv.firstElementChild, grid);
    }

    // SAVE ALL FUNCTION (AJAX)
    async function saveMode() {
        const btnSave = document.getElementById('btn-save-all');
        const originalText = btnSave.innerHTML;
        
        // 1. Ambil semua form yang memiliki class 'edit-form'
        // Kita abaikan form delete dan form 'new-item' (karena new item punya tombol simpan sendiri)
        const forms = document.querySelectorAll('form.edit-form');

        if (forms.length === 0) {
            alert("Tidak ada data untuk disimpan.");
            return;
        }

        btnSave.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';
        btnSave.disabled = true;

        let successCount = 0;
        let errorCount = 0;

        // Ambil CSRF Token
        const csrfToken = document.querySelector('input[name="_token"]').value;

        // 2. Loop dan kirim request
        const promises = Array.from(forms).map(async (form) => {
            const formData = new FormData(form);
            const url = form.action;
            
            try {
                const response = await fetch(url, {
                    method: 'POST', // Browser selalu kirim POST, Laravel baca _method: PUT dari FormData
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    }
                });

                if (!response.ok) {
                    throw new Error(`HTTP Error: ${response.status}`);
                }
                successCount++;
            } catch (error) {
                console.error("Gagal simpan form:", form, error);
                errorCount++;
            }
        });

        // 3. Tunggu semua selesai
        await Promise.all(promises);

        btnSave.innerHTML = originalText;
        btnSave.disabled = false;

        if (errorCount === 0) {
            alert(`Berhasil menyimpan ${successCount} data!`);
            location.reload(); // Reload untuk refresh data
        } else {
            alert(`Selesai. ${successCount} berhasil, ${errorCount} gagal. Periksa konsol untuk detail.`);
            // Jangan reload agar user bisa fix errornya
        }
    }
</script>
@endpush