@extends('layouts.admin')

@section('title', 'Desa Cantik - Admin Kelurahan Citangkil')
@section('page-title', 'Desa Cantik')

@section('content')
<div class="container-fluid">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                <i class="fas fa-times"></i>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                <i class="fas fa-times"></i>
            </button>
        </div>
    @endif

    <main class="container">
        
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

            <div class="card">
                <h2>Tentang Program Desa Cantik</h2>
                <div class="info-group">
                    <span class="label">Deskripsi</span>
                    <p class="text-content" id="view-deskripsi">
                        @if($tentang)
                            {{ $tentang->deskripsi }}
                        @else
                            Belum ada deskripsi program. Klik "Edit Konten" untuk menambahkan.
                        @endif
                    </p>
                </div>
            </div>

            <div class="card">
                <h2>Metadata Statistik</h2>
                <div class="metadata-grid">
                    @forelse($metadata as $item)
                    <div class="meta-item">
                        <i class="fas fa-database meta-icon icon-database"></i>
                        <h3>{{ $item->nama_metadata }}</h3>
                        <p>{{ $item->deskripsi }}</p>
                    </div>
                    @empty
                    <div class="meta-item">
                        <i class="fas fa-database meta-icon icon-database"></i>
                        <h3>Belum ada data</h3>
                        <p>Metadata statistik belum tersedia</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <div class="card">
                <h2>Output Program</h2>
                <div class="output-grid">
                    @forelse($outputPrograms as $index => $program)
                    <div class="output-item">
                        <div class="number-badge">{{ $index + 1 }}</div>
                        <div class="output-content">
                            <h4>{{ $program->judul_program }}</h4>
                            <p>{{ $program->deskripsi_program }}</p>
                        </div>
                    </div>
                    @empty
                    <div class="output-item">
                        <div class="number-badge">-</div>
                        <div class="output-content">
                            <h4>Belum ada data</h4>
                            <p>Output program belum tersedia</p>
                        </div>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>


        <div id="edit-mode" style="display: none;">
            <div class="card header-card">
                <div class="header-content">
                    <div class="header-info">
                        <h1>Desa Cantik</h1>
                        <p>Kelola konten program Desa Cinta Statistik</p>
                    </div>
                    <button class="btn btn-save" onclick="saveMode()">
                        <i class="fas fa-save"></i> Selesai Edit
                    </button>
                </div>
            </div>

            <div class="card">
                <h2>Tentang Program Desa Cantik</h2>
                <form action="{{ route('admin.desa-cantik.update-tentang') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">Deskripsi</label>
                        <textarea class="form-textarea" name="deskripsi" id="edit-deskripsi">{{ $tentang->deskripsi ?? '' }}</textarea>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan Deskripsi
                        </button>
                    </div>
                </form>
            </div>

            <div class="card">
                <h2>Metadata Statistik</h2>
                <div class="metadata-grid" id="metadata-grid-edit">
                    @forelse($metadata as $item)
                    <div class="meta-item">
                        <form action="{{ route('admin.desa-cantik.update-metadata', $item->id_metadata) }}" method="POST" style="width: 100%;">
                            @csrf
                            <div style="text-align: center; margin-bottom: 10px;">
                                <i class="fas fa-database icon-database" style="font-size: 24px;"></i>
                            </div>
                            <div style="margin-bottom: 10px;">
                                <button type="button" class="btn btn-upload">
                                    <i class="fas fa-upload"></i> Upload Gambar
                                </button>
                            </div>
                            <input type="text" name="nama_metadata" class="form-input card-input" value="{{ $item->nama_metadata }}" style="background: white;">
                            <textarea name="deskripsi" class="form-input card-input" placeholder="Deskripsi" style="background: white; min-height: 60px; resize: vertical;">{{ $item->deskripsi }}</textarea>
                            <div style="display: flex; gap: 5px; margin-top: 10px;">
                                <button type="submit" class="btn btn-primary" style="flex: 1;">
                                    <i class="fas fa-save"></i> Simpan
                                </button>
                                <form action="{{ route('admin.desa-cantik.delete-metadata', $item->id_metadata) }}" method="POST" style="display: inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus metadata ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-delete" style="flex: 0 0 auto;">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </form>
                    </div>
                    @empty
                    @endforelse
                </div>
                
                <div style="margin-top: 20px;">
                    <button class="btn btn-add" style="width: auto; padding: 10px 20px;" onclick="addMetadata()">
                        <i class="fas fa-plus"></i> Tambah Metadata
                    </button>
                </div>
            </div>

            <div class="card">
                <h2>Output Program</h2>
                <div class="output-grid" id="output-grid">
                    @forelse($outputPrograms as $index => $program)
                    <div class="output-item-edit">
                        <form action="{{ route('admin.desa-cantik.update-output', $program->id_program) }}" method="POST" style="width: 100%;">
                            @csrf
                            <div style="display: flex; align-items: center; margin-bottom: 10px;">
                                <div class="number-badge" style="margin-right: 15px;">{{ $index + 1 }}</div>
                                <div style="flex: 1;">
                                    <input type="text" name="judul_program" class="form-input card-input" value="{{ $program->judul_program }}" style="background: white;">
                                    <textarea name="deskripsi_program" class="form-input card-input" style="background: white; min-height: 50px; resize: vertical; margin-top: 5px;">{{ $program->deskripsi_program }}</textarea>
                                </div>
                            </div>
                            <div style="display: flex; gap: 5px;">
                                <button type="submit" class="btn btn-primary" style="flex: 1;">
                                    <i class="fas fa-save"></i> Simpan
                                </button>
                                <form action="{{ route('admin.desa-cantik.delete-output', $program->id_program) }}" method="POST" style="display: inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus output program ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-delete" style="flex: 0 0 auto;">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </form>
                    </div>
                    @empty
                    @endforelse
                    
                    <div class="add-card-container">
                        <button class="btn btn-add" style="width: auto;" onclick="addOutput()">
                            <i class="fas fa-plus"></i> Tambah Output
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </main>
</div>
@endsection

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
    /* --- ANIMATION --- */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* --- GLOBAL STYLES --- */
    .container {
        width: 100%;
        max-width: 900px;
        display: flex;
        flex-direction: column;
        gap: 20px;
        margin: 0 auto;
    }

    /* --- CARD & UTILS --- */
    .card {
        background-color: white;
        border-radius: 12px;
        padding: 24px;
        margin-bottom: 20px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        border: 1px solid #E5E7EB;
    }
    h2 { font-size: 18px; font-weight: 600; color: #1F2937; margin-bottom: 20px; }
    .header-card { 
        display: flex; 
        justify-content: space-between; 
        align-items: center; 
    }
    .header-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%;
    }
    .header-info h1 { font-size: 18px; font-weight: 600; color: #111827; margin-bottom: 4px; }
    .header-info p { font-size: 14px; color: #6B7280; }

    /* --- BUTTONS --- */
    .btn {
        border: none; padding: 10px 16px; border-radius: 6px;
        font-size: 14px; font-weight: 500; cursor: pointer;
        display: flex; align-items: center; gap: 8px; transition: 0.2s;
    }
    .btn-edit { background-color: #00A86B; color: white; }
    .btn-edit:hover { background-color: #008f5b; }
    
    .btn-save { background-color: #2563EB; color: white; }
    .btn-save:hover { background-color: #1d4ed8; }

    .btn-upload { background-color: #2563EB; color: white; width: 100%; justify-content: center; margin-bottom: 12px;}
    
    .btn-delete { background-color: #DC2626; color: white; margin-top: 10px; }
    .btn-delete:hover { background-color: #b91c1c; }

    .btn-secondary { background-color: #6B7280; color: white; margin-top: 10px; }
    .btn-secondary:hover { background-color: #4B5563; }

    .btn-add { background-color: #00A86B; color: white; width: 100%; justify-content: center; padding: 12px; }

    /* --- FORM ELEMENTS (EDIT MODE) --- */
    .form-group { margin-bottom: 16px; }
    .form-label { display: block; font-size: 14px; color: #4B5563; margin-bottom: 6px; font-weight: 500; }
    
    .form-input, .form-textarea {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #D1D5DB;
        border-radius: 6px;
        font-family: inherit;
        font-size: 14px;
        color: #111827;
        background-color: #fff;
    }
    .form-textarea { min-height: 100px; resize: vertical; }
    
    /* Input khusus di dalam kartu (Metadata/Output) */
    .card-input { margin-bottom: 8px; background-color: #F9FAFB; }

    /* --- VIEW MODE STYLES --- */
    .info-group { margin-bottom: 16px; }
    .label { display: block; font-size: 14px; color: #4B5563; margin-bottom: 6px; font-weight: 500; }
    .text-content { color: #6B7280; font-size: 14px; line-height: 1.6; }
    
    .metadata-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; }
    .meta-item { background-color: #F9FAFB; border-radius: 8px; padding: 20px; text-align: left; position: relative; }
    .meta-icon { font-size: 24px; margin-bottom: 12px; display: block; text-align: center; }

    .output-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px; }
    @media (max-width: 600px) { .output-grid { grid-template-columns: 1fr; } }
    
    .output-item { background-color: #ECFDF5; border-radius: 8px; padding: 16px; display: flex; align-items: flex-start; gap: 12px; }
    .output-item-edit { background-color: #ECFDF5; border-radius: 8px; padding: 16px; display: block; position: relative;}
    .number-badge { background-color: #00A86B; color: white; width: 24px; height: 24px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: bold; flex-shrink: 0; }
    .output-content h4 { font-size: 14px; font-weight: 600; color: #1F2937; }
    .output-content p { font-size: 13px; color: #4B5563; }

    /* Add Button Container Styles */
    .add-card-container {
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #ECFDF5;
        border-radius: 8px;
        padding: 20px;
        min-height: 150px;
    }
</style>
@endpush

@push('scripts')
<script>
    // --- MODE TOGGLING ---
    function toggleMode() {
        const viewMode = document.getElementById('view-mode');
        const editMode = document.getElementById('edit-mode');

        if (viewMode.style.display === 'none') {
            // Cancel mode (refresh to reset) or simply hide
            location.reload(); 
        } else {
            // Pindah ke Edit Mode
            viewMode.style.display = 'none';
            editMode.style.display = 'block';
            window.scrollTo(0, 0);
        }
    }

    function saveMode() {
        // Logikanya bisa reload page untuk melihat hasil
        // atau trigger submit global (opsional)
        location.reload(); 
    }

    // --- ADD METADATA FUNCTION ---
    function addMetadata() {
        // 1. Ambil container grid
        const metadataGrid = document.getElementById('metadata-grid-edit');
        
        // 2. Buat element div wrapper
        const newCard = document.createElement('div');
        newCard.className = 'meta-item';
        newCard.style.animation = 'fadeIn 0.5s ease';
        
        // 3. Masukkan HTML Form ke dalamnya
        // Perhatikan: Menggunakan route store-metadata
        newCard.innerHTML = `
            <form action="{{ route('admin.desa-cantik.store-metadata') }}" method="POST" style="width: 100%;">
                @csrf
                <div style="text-align: center; margin-bottom: 10px;">
                    <i class="fas fa-plus-circle icon-database" style="font-size: 24px; color: #00A86B;"></i>
                    <p style="font-size: 12px; color: #6B7280; margin-top: 5px;">Data Baru</p>
                </div>
                <div style="margin-bottom: 10px;">
                    <button type="button" class="btn btn-upload" disabled style="opacity: 0.6; cursor: not-allowed;">
                        <i class="fas fa-upload"></i> Simpan data dulu
                    </button>
                </div>
                <input type="text" name="nama_metadata" class="form-input card-input" placeholder="Nama Metadata" required style="background: white;">
                <textarea name="deskripsi" class="form-input card-input" placeholder="Deskripsi Metadata" required style="background: white; min-height: 60px; resize: vertical;"></textarea>
                <div style="display: flex; gap: 5px; margin-top: 10px;">
                    <button type="submit" class="btn btn-primary" style="flex: 1;">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-secondary" onclick="this.closest('.meta-item').remove()" style="flex: 0 0 auto;">
                        <i class="fas fa-times"></i> Batal
                    </button>
                </div>
            </form>
        `;

        // 4. Masukkan ke grid
        metadataGrid.appendChild(newCard);

        // 5. Scroll ke element baru
        newCard.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }

    // --- ADD OUTPUT FUNCTION ---
    function addOutput() {
        const outputGrid = document.getElementById('output-grid');
        const addButtonContainer = outputGrid.querySelector('.add-card-container');
        
        const newCard = document.createElement('div');
        newCard.className = 'output-item-edit';
        newCard.style.animation = 'fadeIn 0.5s ease';

        newCard.innerHTML = `
            <form action="{{ route('admin.desa-cantik.store-output') }}" method="POST" style="width: 100%;">
                @csrf
                <div style="display: flex; align-items: center; margin-bottom: 10px;">
                    <div class="number-badge" style="margin-right: 15px;">+</div>
                    <div style="flex: 1;">
                        <input type="text" name="judul_program" class="form-input card-input" placeholder="Judul Program" required style="background: white;">
                        <textarea name="deskripsi_program" class="form-input card-input" placeholder="Deskripsi Program" required style="background: white; min-height: 50px; resize: vertical; margin-top: 5px;"></textarea>
                    </div>
                </div>
                <div style="display: flex; gap: 5px;">
                    <button type="submit" class="btn btn-primary" style="flex: 1;">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-secondary" onclick="this.closest('.output-item-edit').remove()" style="flex: 0 0 auto;">
                        <i class="fas fa-times"></i> Batal
                    </button>
                </div>
            </form>
        `;

        // Insert before the Add Button container
        outputGrid.insertBefore(newCard, addButtonContainer);
        newCard.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }

    // --- NOTIFICATION FUNCTION (Optional) ---
    function showNotification(message, type = 'success') {
        const notification = document.createElement('div');
        const bgColor = type === 'success' ? '#22c55e' : '#f59e0b';
        
        notification.style.cssText = `
            position: fixed; top: 20px; right: 20px;
            background-color: ${bgColor}; color: white;
            padding: 12px 20px; border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            z-index: 1000; font-family: 'Inter', sans-serif;
            font-size: 14px; animation: slideInRight 0.3s ease;
        `;
        notification.textContent = message;
        
        const style = document.createElement('style');
        style.textContent = `@keyframes slideInRight { from { transform: translateX(100%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }`;
        document.head.appendChild(style);
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.remove();
            style.remove();
        }, 3000);
    }
</script>
@endpush