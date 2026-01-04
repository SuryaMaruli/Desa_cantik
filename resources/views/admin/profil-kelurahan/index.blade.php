@extends('layouts.admin')

@section('title', 'Profil Kelurahan - Admin Kelurahan Citangkil')
@section('page-title', 'Profil Kelurahan')

@section('content')
<div class="container-fluid">
    <main class="container">
        
        <div class="card header-card">
            <div class="header-content">
                <div>
                    <h1>Profil Kelurahan</h1>
                    <p class="subtitle">Kelola informasi profil kelurahan</p>
                </div>
                
                <div class="header-actions">
                    <button class="btn-action btn-edit" onclick="toggleEditMode()">
                        <i class="fa-regular fa-pen-to-square"></i> Edit Profil
                    </button>
                    
                    <button class="btn-action btn-save" onclick="saveData()">
                        <i class="fa-regular fa-floppy-disk"></i> Simpan
                    </button>
                </div>
            </div>
        </div>

        <div class="card">
            <h2>Informasi Dasar</h2>

            <div class="icon-text">
                <div class="content-wrapper">
                    <span class="label">Nama Lurah</span>
                    <span class="view-value" id="view-nama">M. ALI WAHIDI, S.Sos.M.Si</span>
                    <input type="text" class="form-control" id="input-nama" value="M. ALI WAHIDI, S.Sos.M.Si">
                </div>
            </div>

            <div class="icon-text">
                <i class="fa-solid fa-location-dot"></i>
                <div class="content-wrapper">
                    <span class="label">Alamat</span>
                    <span class="view-value" id="view-alamat">Jl. Raya Citangkil No. 123, Kota Cilegon, Banten 42441</span>
                    <textarea class="form-control" id="input-alamat">Jl. Raya Citangkil No. 123, Kota Cilegon, Banten 42441</textarea>
                </div>
            </div>

            <div class="row-grid">
                <div class="icon-text">
                    <i class="fa-solid fa-phone"></i>
                    <div class="content-wrapper">
                        <span class="label">Telepon</span>
                        <span class="view-value" id="view-telp">(0254) 123-4567</span>
                        <input type="text" class="form-control" id="input-telp" value="(0254) 123-4567">
                    </div>
                </div>
                <div class="icon-text">
                    <i class="fa-regular fa-envelope"></i>
                    <div class="content-wrapper">
                        <span class="label">Email</span>
                        <span class="view-value" id="view-email">kelurahan@citangkil.go.id</span>
                        <input type="email" class="form-control" id="input-email" value="kelurahan@citangkil.go.id">
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <h2>Visi & Misi</h2>

            <div class="visi-section">
                <h3>Visi</h3>
                <div class="visi-content">
                    <span class="view-value" id="view-visi">Menjadi kelurahan yang maju, sejahtera, dan berbudaya</span>
                    <textarea class="form-control" id="input-visi">Menjadi kelurahan yang maju, sejahtera, dan berbudaya</textarea>
                </div>
            </div>

            <div class="misi-section">
                <div class="misi-header">
                    <h3>Misi</h3>
                    <div class="misi-actions">
                        <button type="button" class="btn-misi btn-add-misi" onclick="addMisi()">
                            <i class="fa-solid fa-plus"></i> Tambah
                        </button>
                    </div>
                </div>
                <div class="misi-list" id="misi-list-container">
                    <div class="misi-item">
                        <span class="misi-num">1</span>
                        <div class="content-wrapper">
                            <span class="view-value" id="view-misi1">Meningkatkan kualitas pelayanan publik</span>
                            <input type="text" class="form-control" id="input-misi1" value="Meningkatkan kualitas pelayanan publik">
                            <button type="button" class="btn-remove-misi" onclick="removeMisi(this)" style="display: none;">
                                <i class="fa-solid fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="misi-item">
                        <span class="misi-num">2</span>
                        <div class="content-wrapper">
                            <span class="view-value" id="view-misi2">Memberdayakan masyarakat melalui program-program pembangunan</span>
                            <input type="text" class="form-control" id="input-misi2" value="Memberdayakan masyarakat melalui program-program pembangunan">
                            <button type="button" class="btn-remove-misi" onclick="removeMisi(this)" style="display: none;">
                                <i class="fa-solid fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="misi-item">
                        <span class="misi-num">3</span>
                        <div class="content-wrapper">
                            <span class="view-value" id="view-misi3">Menciptakan lingkungan yang bersih dan sehat</span>
                            <input type="text" class="form-control" id="input-misi3" value="Menciptakan lingkungan yang bersih dan sehat">
                            <button type="button" class="btn-remove-misi" onclick="removeMisi(this)" style="display: none;">
                                <i class="fa-solid fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="misi-item">
                        <span class="misi-num">4</span>
                        <div class="content-wrapper">
                            <span class="view-value" id="view-misi4">Meningkatkan partisipasi masyarakat dalam pembangunan</span>
                            <input type="text" class="form-control" id="input-misi4" value="Meningkatkan partisipasi masyarakat dalam pembangunan">
                            <button type="button" class="btn-remove-misi" onclick="removeMisi(this)" style="display: none;">
                                <i class="fa-solid fa-times"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <h2>Batas Wilayah</h2>
            
            <div class="row-grid">
                <div>
                    <div class="content-wrapper" style="margin-bottom: 15px;">
                        <span class="label">Utara</span>
                        <span class="view-value" id="view-utara">Kelurahan Cibeber</span>
                        <input type="text" class="form-control" id="input-utara" value="Kelurahan Cibeber">
                    </div>
                    <div class="content-wrapper">
                        <span class="label">Timur</span>
                        <span class="view-value" id="view-timur">Kelurahan Kepuh</span>
                        <input type="text" class="form-control" id="input-timur" value="Kelurahan Kepuh">
                    </div>
                </div>

                <div>
                    <div class="content-wrapper" style="margin-bottom: 15px;">
                        <span class="label">Selatan</span>
                        <span class="view-value" id="view-selatan">Selat Sunda</span>
                        <input type="text" class="form-control" id="input-selatan" value="Selat Sunda">
                    </div>
                    <div class="content-wrapper">
                        <span class="label">Barat</span>
                        <span class="view-value" id="view-barat">Kelurahan Bagendung</span>
                        <input type="text" class="form-control" id="input-barat" value="Kelurahan Bagendung">
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
    /* --- 1. Global Styles --- */
    .container {
        width: 100%;
        max-width: 800px;
        display: flex;
        flex-direction: column;
        gap: 20px;
        margin: 0 auto;
    }

    /* --- 2. Card Styles --- */
    .card {
        background-color: #ffffff;
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        border: 1px solid #eef0f2;
    }

    /* --- 3. Typography & Labels --- */
    h1 { font-size: 20px; font-weight: 600; color: #1f2937; }
    h2 { font-size: 18px; font-weight: 600; color: #1f2937; margin-bottom: 20px; }
    h3 { font-size: 16px; font-weight: 500; color: #374151; margin-bottom: 8px; }
    p.subtitle { font-size: 14px; color: #6b7280; margin-top: 4px; }
    
    .label {
        font-size: 14px;
        color: #6b7280;
        margin-bottom: 6px;
        display: block;
    }

    /* --- 4. Header & Button --- */
    .header-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
    }

    .header-actions {
        display: flex;
        gap: 10px;
        align-items: center;
    }

    .btn-action {
        border: none;
        padding: 10px 20px;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s;
    }

    /* Tombol Edit (Hijau) */
    .btn-edit { background-color: #00a86b; color: white; }
    .btn-edit:hover { background-color: #008f5b; }

    /* Tombol Simpan (Biru) - Awalnya hidden */
    .btn-save { background-color: #0d6efd; color: white; display: none; }
    .btn-save:hover { background-color: #0b5ed7; }

    /* --- 5. Form Elements (Inputs) --- */
    /* Input & Textarea Styling */
    .form-control {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        font-family: inherit;
        font-size: 15px;
        color: #1f2937;
        background-color: #fff;
        outline: none;
        transition: border-color 0.2s;
        display: none; /* Hidden by default */
    }

    .form-control:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.15);
    }

    textarea.form-control {
        resize: vertical;
        min-height: 80px;
    }

    /* View Value Styling */
    .view-value {
        font-size: 15px;
        color: #4b5563;
        line-height: 1.6;
        display: block; /* Visible by default */
    }

    /* Icon wrapper */
    .icon-text {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        margin-bottom: 20px;
    }
    .icon-text i { margin-top: 4px; color: #6b7280; width: 16px; }
    .content-wrapper { flex: 1; }

    /* Grid Layouts */
    .row-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 20px;
    }
    @media (min-width: 600px) {
        .row-grid { grid-template-columns: 1fr 1fr; }
    }

    /* --- 6. Visi & Misi Styles --- */
    .visi-section {
        margin-bottom: 32px;
        padding-bottom: 24px;
        border-bottom: 1px solid #e5e7eb;
    }

    .visi-content {
        margin-top: 8px;
    }

    .misi-section {
        margin-top: 24px;
    }

    .misi-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .misi-list {
        list-style: none;
        counter-reset: misi-counter;
    }
    
    .misi-item {
        position: relative;
        padding-left: 32px;
        margin-bottom: 16px;
        display: flex;
        align-items: flex-start;
    }

    /* Penomoran Custom */
    .misi-num {
        position: absolute;
        left: 0;
        top: 2px;
        color: #00a86b;
        font-weight: 600;
        font-size: 14px;
        width: 24px;
        height: 24px;
        background-color: #f0fdf4;
        border: 2px solid #00a86b;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
    }
    
    /* Saat mode edit, sesuaikan posisi nomor agar sejajar input */
    body.is-editing .misi-num {
        top: 12px; 
    }

    /* Content wrapper untuk misi */
    .misi-item .content-wrapper {
        flex: 1;
        position: relative;
        padding-right: 40px; /* Ruang untuk tombol remove */
    }

    /* Misi Actions */
    .misi-actions {
        display: flex;
        gap: 8px;
        align-items: center;
    }

    .btn-misi {
        border: none;
        padding: 8px 16px;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 500;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s;
    }

    .btn-add-misi {
        background-color: #22c55e;
        color: white;
        border: 1px solid #22c55e;
    }

    .btn-add-misi:hover {
        background-color: #16a34a;
        border-color: #16a34a;
    }

    .btn-remove-misi {
        position: absolute;
        right: 8px;
        top: 8px;
        background-color: #ef4444;
        color: white;
        border: none;
        border-radius: 50%;
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 12px;
        transition: all 0.2s;
        box-shadow: 0 2px 4px rgba(239, 68, 68, 0.2);
        z-index: 10;
    }

    .btn-remove-misi:hover {
        background-color: #dc2626;
        transform: scale(1.1);
    }

    /* Show remove button only in edit mode */
    body.is-editing .btn-remove-misi {
        display: flex !important;
    }

    /* Hide add button in normal mode */
    body:not(.is-editing) .btn-add-misi {
        display: none;
    }

    /* Styling untuk view-value dan form-control di Visi & Misi */
    .visi-section .view-value,
    .misi-item .view-value {
        line-height: 1.6;
        color: #374151;
        font-size: 15px;
    }

    .visi-section .form-control,
    .misi-item .form-control {
        border: 1px solid #d1d5db;
        border-radius: 6px;
        padding: 10px 12px;
        font-size: 15px;
        transition: all 0.2s;
    }

    .visi-section .form-control:focus,
    .misi-item .form-control:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.1);
        outline: none;
    }

    /* --- 7. TOGGLE LOGIC (The Magic) --- */
    
    /* Saat class .is-editing ada di body: */
    body.is-editing .view-value { display: none; }      /* Sembunyikan teks */
    body.is-editing .form-control { display: block; }   /* Tampilkan input */
    
    body.is-editing .btn-edit { display: none; }        /* Sembunyikan tombol Edit */
    body.is-editing .btn-save { display: inline-flex; } /* Tampilkan tombol Simpan */

    /* Hilangkan ikon saat mode edit agar tampilan bersih seperti request */
    body.is-editing .icon-text i { display: none; } 
    body.is-editing .icon-text { gap: 0; }
</style>
@endpush

@push('scripts')
<script>
    let misiCount = 4; // Jumlah misi awal

    // Fungsi untuk mengaktifkan Mode Edit
    function toggleEditMode() {
        // Kita cukup menambahkan class 'is-editing' ke body
        // CSS akan menangani perubahan tampilan (sembunyi teks, muncul input, ubah tombol)
        document.body.classList.add('is-editing');
    }

    // Fungsi untuk Simpan (Kembali ke Mode Baca & Update Nilai)
    function saveData() {
        // 1. Ambil semua input
        const inputs = document.querySelectorAll('.form-control');
        
        // 2. Loop setiap input untuk memindahkan nilainya ke teks tampilan (view-value)
        inputs.forEach(input => {
            // Kita asumsikan ID input adalah "input-xyz" dan viewnya "view-xyz"
            const idPart = input.id.replace('input-', ''); 
            const viewElement = document.getElementById('view-' + idPart);
            
            if(viewElement) {
                viewElement.innerText = input.value;
            }
        });

        // 3. Matikan class editing
        document.body.classList.remove('is-editing');
        
        // Tampilkan notifikasi sukses
        showNotification('Profil kelurahan berhasil diperbarui!');
    }

    // Fungsi untuk menambah misi baru
    function addMisi() {
        misiCount++;
        
        const misiList = document.getElementById('misi-list-container');
        const newMisiItem = document.createElement('div');
        newMisiItem.className = 'misi-item';
        newMisiItem.innerHTML = `
            <span class="misi-num">${misiCount}</span>
            <div class="content-wrapper">
                <span class="view-value" id="view-misi${misiCount}"></span>
                <input type="text" class="form-control" id="input-misi${misiCount}" placeholder="Masukkan misi baru...">
                <button type="button" class="btn-remove-misi" onclick="removeMisi(this)" style="display: none;">
                    <i class="fa-solid fa-times"></i>
                </button>
            </div>
        `;
        
        misiList.appendChild(newMisiItem);
        
        // Auto focus ke input baru
        document.getElementById(`input-misi${misiCount}`).focus();
    }

    // Fungsi untuk menghapus misi
    function removeMisi(button) {
        const misiItem = button.closest('.misi-item');
        const misiList = document.getElementById('misi-list-container');
        
        // Hanya hapus jika masih ada lebih dari 1 misi
        if (misiList.children.length > 1) {
            misiItem.remove();
            updateMisiNumbers();
        } else {
            showNotification('Minimal harus ada 1 misi!', 'warning');
        }
    }

    // Fungsi untuk update nomor misi setelah penghapusan
    function updateMisiNumbers() {
        const misiItems = document.querySelectorAll('.misi-item');
        misiItems.forEach((item, index) => {
            const numElement = item.querySelector('.misi-num');
            const viewElement = item.querySelector('.view-value');
            const inputElement = item.querySelector('.form-control');
            const removeButton = item.querySelector('.btn-remove-misi');
            
            const newNum = index + 1;
            
            // Update nomor
            numElement.textContent = newNum;
            
            // Update ID jika perlu
            if (viewElement && !viewElement.id.includes('misi')) {
                viewElement.id = `view-misi${newNum}`;
            }
            if (inputElement && !inputElement.id.includes('misi')) {
                inputElement.id = `input-misi${newNum}`;
            }
        });
        
        misiCount = misiItems.length;
    }

    // Fungsi untuk menampilkan notifikasi
    function showNotification(message, type = 'success') {
        // Buat notifikasi element
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
        
        // Tambahkan animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideInRight {
                from { transform: translateX(100%); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
        `;
        document.head.appendChild(style);
        
        document.body.appendChild(notification);
        
        // Hapus notifikasi setelah 3 detik
        setTimeout(() => {
            notification.style.animation = 'slideInRight 0.3s ease reverse';
            setTimeout(() => {
                notification.remove();
                style.remove();
            }, 300);
        }, 3000);
    }
</script>
@endpush
