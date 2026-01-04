@extends('layouts.admin')

@section('title', 'Desa Cantik - Admin Kelurahan Citangkil')
@section('page-title', 'Desa Cantik')

@section('content')
<div class="container-fluid">
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
                <h2>Informasi Utama</h2>
                <div class="info-group">
                    <span class="label">Judul Program</span>
                    <p class="text-content" id="view-judul">Program Desa Cinta Statistik (Desa Cantik)</p>
                </div>
                <div class="info-group">
                    <span class="label">Deskripsi</span>
                    <p class="text-content" id="view-deskripsi">Program Desa Cinta Statistik (Desa Cantik) adalah program inovatif yang bertujuan untuk meningkatkan kualitas data statistik...</p>
                </div>
            </div>

            <div class="card">
                <h2>Metadata Statistik</h2>
                <div class="metadata-grid">
                    <div class="meta-item">
                        <i class="fas fa-user-group meta-icon icon-users"></i>
                        <h3>Data Penduduk</h3>
                        <p>Informasi lengkap jumlah dan sebaran penduduk</p>
                    </div>
                    <div class="meta-item">
                        <i class="fas fa-map meta-icon icon-map"></i>
                        <h3>Pemetaan Wilayah</h3>
                        <p>Data geografis dan batas wilayah kelurahan</p>
                    </div>
                    <div class="meta-item">
                        <i class="fas fa-chart-simple meta-icon icon-chart"></i>
                        <h3>Statistik Sosial</h3>
                        <p>Data kesehatan, pendidikan, dan kesejahteraan</p>
                    </div>
                </div>
            </div>

            <div class="card">
                <h2>Output Program</h2>
                <div class="output-grid">
                    <div class="output-item">
                        <div class="number-badge">1</div>
                        <div class="output-content">
                            <h4>Database Terintegrasi</h4>
                            <p>Sistem database yang terkoneksi</p>
                        </div>
                    </div>
                    <div class="output-item">
                        <div class="number-badge">2</div>
                        <div class="output-content">
                            <h4>Portal Data Terbuka</h4>
                            <p>Platform akses data untuk umum</p>
                        </div>
                    </div>
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
                        <i class="fas fa-save"></i> Simpan
                    </button>
                </div>
            </div>

            <div class="card">
                <h2>Informasi Utama</h2>
                <div class="form-group">
                    <label class="form-label">Judul Program</label>
                    <input type="text" class="form-input" id="edit-judul" value="Program Desa Cinta Statistik (Desa Cantik)">
                </div>
                <div class="form-group">
                    <label class="form-label">Deskripsi</label>
                    <textarea class="form-textarea" id="edit-deskripsi">Program Desa Cinta Statistik (Desa Cantik) adalah program inovatif yang bertujuan untuk meningkatkan kualitas data statistik...</textarea>
                </div>
            </div>

            <div class="card">
                <h2>Metadata Statistik</h2>
                <div class="metadata-grid">
                    <div class="meta-item">
                        <div style="text-align: center; margin-bottom: 10px;">
                            <i class="fas fa-user-group icon-users" style="font-size: 24px;"></i>
                        </div>
                        <button class="btn btn-upload"><i class="fas fa-upload"></i> Upload Gambar</button>
                        <input type="text" class="form-input card-input" value="Data Penduduk">
                        <input type="text" class="form-input card-input" placeholder="Deskripsi">
                        <button class="btn btn-delete"><i class="fas fa-trash"></i> Hapus</button>
                    </div>
                    <div class="meta-item">
                        <div style="text-align: center; margin-bottom: 10px;">
                            <i class="fas fa-map icon-map" style="font-size: 24px;"></i>
                        </div>
                        <button class="btn btn-upload"><i class="fas fa-upload"></i> Upload Gambar</button>
                        <input type="text" class="form-input card-input" value="Pemetaan Wilayah">
                        <input type="text" class="form-input card-input" placeholder="Deskripsi">
                        <button class="btn btn-delete"><i class="fas fa-trash"></i> Hapus</button>
                    </div>
                    <div class="meta-item">
                        <div style="text-align: center; margin-bottom: 10px;">
                            <i class="fas fa-chart-simple icon-chart" style="font-size: 24px;"></i>
                        </div>
                        <button class="btn btn-upload"><i class="fas fa-upload"></i> Upload Gambar</button>
                        <input type="text" class="form-input card-input" value="Statistik Sosial">
                        <input type="text" class="form-input card-input" placeholder="Deskripsi">
                        <button class="btn btn-delete"><i class="fas fa-trash"></i> Hapus</button>
                    </div>
                </div>
                <div style="margin-top: 20px;">
                    <button class="btn btn-add" style="width: auto; padding: 10px 20px;">
                        <i class="fas fa-plus"></i> Tambah Metadata
                    </button>
                </div>
            </div>

            <div class="card">
                <h2>Output Program</h2>
                <div class="output-grid" id="output-grid">
                    <div class="output-item-edit">
                        <input type="text" class="form-input card-input" value="Database Terintegrasi" style="background: white;">
                        <input type="text" class="form-input card-input" value="Sistem database yang terkoneksi..." style="background: white;">
                        <button class="btn btn-delete"><i class="fas fa-trash"></i> Hapus</button>
                    </div>
                    <div class="output-item-edit">
                        <input type="text" class="form-input card-input" value="Portal Data Terbuka" style="background: white;">
                        <input type="text" class="form-input card-input" value="Platform akses data untuk..." style="background: white;">
                        <button class="btn btn-delete"><i class="fas fa-trash"></i> Hapus</button>
                    </div>
                    <div class="output-item-edit">
                        <input type="text" class="form-input card-input" value="Laporan Berkala" style="background: white;">
                        <input type="text" class="form-input card-input" value="Publikasi rutin data..." style="background: white;">
                        <button class="btn btn-delete"><i class="fas fa-trash"></i> Hapus</button>
                    </div>
                    <div class="output-item-edit">
                        <input type="text" class="form-input card-input" value="Pelatihan SDM" style="background: white;">
                        <input type="text" class="form-input card-input" value="Peningkatan kapasitas..." style="background: white;">
                        <button class="btn btn-delete"><i class="fas fa-trash"></i> Hapus</button>
                    </div>
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

    /* --- VIEW MODE STYLES (Existing) --- */
    .info-group { margin-bottom: 16px; }
    .label { display: block; font-size: 14px; color: #4B5563; margin-bottom: 6px; font-weight: 500; }
    .text-content { color: #6B7280; font-size: 14px; line-height: 1.6; }
    
    .metadata-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; }
    .meta-item { background-color: #F9FAFB; border-radius: 8px; padding: 20px; text-align: left;}
    .meta-icon { font-size: 24px; margin-bottom: 12px; display: block; text-align: center; }
    .icon-users { color: #3B82F6; } .icon-map { color: #F59E0B; } .icon-chart { color: #10B981; }

    .output-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px; }
    @media (max-width: 600px) { .output-grid { grid-template-columns: 1fr; } }
    
    .output-item { background-color: #ECFDF5; border-radius: 8px; padding: 16px; display: flex; align-items: flex-start; gap: 12px; }
    .output-item-edit { background-color: #ECFDF5; border-radius: 8px; padding: 16px; display: block; }
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
    let outputCount = 4;

    // Fungsi untuk menukar tampilan antara View Mode dan Edit Mode
    function toggleMode() {
        const viewMode = document.getElementById('view-mode');
        const editMode = document.getElementById('edit-mode');

        if (viewMode.style.display === 'none') {
            // Pindah ke View Mode (Save)
            saveMode();
        } else {
            // Pindah ke Edit Mode
            viewMode.style.display = 'none';
            editMode.style.display = 'block';
            window.scrollTo(0, 0);
        }
    }

    // Fungsi untuk menyimpan dan kembali ke view mode
    function saveMode() {
        // Update judul
        const editJudul = document.getElementById('edit-judul');
        const viewJudul = document.getElementById('view-judul');
        if (editJudul && viewJudul) {
            viewJudul.textContent = editJudul.value;
        }

        // Update deskripsi
        const editDeskripsi = document.getElementById('edit-deskripsi');
        const viewDeskripsi = document.getElementById('view-deskripsi');
        if (editDeskripsi && viewDeskripsi) {
            viewDeskripsi.textContent = editDeskripsi.value;
        }

        // Update output items
        updateOutputItems();

        // Pindah ke view mode
        const viewMode = document.getElementById('view-mode');
        const editMode = document.getElementById('edit-mode');
        viewMode.style.display = 'block';
        editMode.style.display = 'none';
        window.scrollTo(0, 0);

        // Show notification
        showNotification('Konten Desa Cantik berhasil diperbarui!');
    }

    // Fungsi untuk menambah output baru
    function addOutput() {
        outputCount++;
        const outputGrid = document.getElementById('output-grid');
        const addButton = outputGrid.querySelector('.add-card-container');
        
        const newOutput = document.createElement('div');
        newOutput.className = 'output-item-edit';
        newOutput.innerHTML = `
            <input type="text" class="form-input card-input" value="Output Baru ${outputCount}" style="background: white;">
            <input type="text" class="form-input card-input" placeholder="Deskripsi output baru..." style="background: white;">
            <button class="btn btn-delete" onclick="removeOutput(this)"><i class="fas fa-trash"></i> Hapus</button>
        `;
        
        outputGrid.insertBefore(newOutput, addButton);
    }

    // Fungsi untuk menghapus output
    function removeOutput(button) {
        const outputGrid = document.getElementById('output-grid');
        const outputItems = outputGrid.querySelectorAll('.output-item-edit');
        
        if (outputItems.length > 1) {
            button.closest('.output-item-edit').remove();
            updateOutputItems();
        } else {
            showNotification('Minimal harus ada 1 output!', 'warning');
        }
    }

    // Fungsi untuk update output items di view mode
    function updateOutputItems() {
        const editOutputs = document.querySelectorAll('.output-item-edit');
        const viewOutputGrid = document.querySelector('#view-mode .output-grid');
        
        if (viewOutputGrid) {
            viewOutputGrid.innerHTML = '';
            
            editOutputs.forEach((output, index) => {
                const inputs = output.querySelectorAll('.form-input');
                const title = inputs[0] ? inputs[0].value : '';
                const desc = inputs[1] ? inputs[1].value : '';
                
                const outputItem = document.createElement('div');
                outputItem.className = 'output-item';
                outputItem.innerHTML = `
                    <div class="number-badge">${index + 1}</div>
                    <div class="output-content">
                        <h4>${title}</h4>
                        <p>${desc}</p>
                    </div>
                `;
                
                viewOutputGrid.appendChild(outputItem);
            });
        }
    }

    // Fungsi untuk menampilkan notifikasi
    function showNotification(message, type = 'success') {
        const notification = document.createElement('div');
        const bgColor = type === 'success' ? '#22c55e' : '#f59e0b';
        
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: ${bgColor};
            color: white;
            padding: 12px 20px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            z-index: 1000;
            font-family: 'Inter', sans-serif;
            font-size: 14px;
            animation: slideInRight 0.3s ease;
        `;
        notification.textContent = message;
        
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideInRight {
                from { transform: translateX(100%); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
        `;
        document.head.appendChild(style);
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.style.animation = 'slideInRight 0.3s ease reverse';
            setTimeout(() => {
                notification.remove();
                style.remove();
            }, 300);
        }, 3000);
    }

    // Event listeners untuk delete buttons yang sudah ada
    document.addEventListener('DOMContentLoaded', function() {
        const deleteButtons = document.querySelectorAll('.btn-delete');
        deleteButtons.forEach(button => {
            if (!button.onclick) {
                button.addEventListener('click', function() {
                    if (this.closest('.output-item-edit')) {
                        removeOutput(this);
                    }
                });
            }
        });
    });
</script>
@endpush
