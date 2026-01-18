@extends('layouts.admin')

@section('title', 'Desa Cantik - Admin Kelurahan Citangkil')
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
        <form action="{{ route('admin.desa-cantik.store-metadata') }}" method="POST">
            @csrf
            <h4 class="text-center text-success mb-2">Item Baru</h4>
            <input type="text" name="nama_metadata" class="form-input card-input mb-2" placeholder="Nama Metadata" required>
            <textarea name="deskripsi" class="form-input card-input mb-2" placeholder="Deskripsi" required rows="3"></textarea>
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
    .btn { padding: 8px 15px; border: none; border-radius: 5px; cursor: pointer; color: white; display: inline-flex; align-items: center; gap: 5px; font-size: 14px; }
    .btn-edit { background: #10B981; }
    .btn-save { background: #3B82F6; }
    .btn-delete { background: #EF4444; }
    .btn-secondary { background: #6B7280; }
    .btn-add { background: #10B981; width: 100%; justify-content: center; padding: 10px; }
    
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