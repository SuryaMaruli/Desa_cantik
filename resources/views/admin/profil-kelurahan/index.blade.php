@extends('layouts.admin')

@section('title', 'Profil Kelurahan - Admin')
@section('page-title', 'Profil Kelurahan')

@section('content')
<div class="container-fluid">
    <main class="container">
        
        <form id="form-profil-kelurahan" action="{{ route('admin.profil-kelurahan.update') }}" method="POST">
            @csrf
            {{-- Method Spoofing untuk PUT --}}
            @method('PUT') 

            <div class="card header-card">
                <div class="header-content">
                    <div>
                        <h1>Profil Kelurahan</h1>
<p class="subtitle">Kelola informasi umum, visi, dan misi.</p>
                    </div>
                    
                    <div class="header-actions">
                        <button type="button" class="btn-action btn-edit" onclick="toggleEditMode()">
                            <i class="fa-regular fa-pen-to-square"></i> Edit Profil
                        </button>
                        
                        {{-- Button Simpan memanggil fungsi saveData() di JS --}}
                        <button type="button" class="btn-action btn-save" onclick="saveData()">
                            <i class="fa-regular fa-floppy-disk"></i> Simpan Perubahan
                        </button>
                    </div>
                </div>
            </div>

            <div class="card">
                <h2>Informasi Dasar</h2>
                <div class="info-grid">
                    
                    <div class="info-item">
                        <div class="info-header">
                            <i class="fa-solid fa-building"></i>
                            <span class="label">Nama Kelurahan</span>
                        </div>
                        <div class="info-content">
                            <span class="view-value" id="view-nama_kelurahan">{{ $profilKelurahan->nama_kelurahan ?? '-' }}</span>
                            <input type="text" class="form-control" name="nama_kelurahan" id="input-nama_kelurahan" value="{{ $profilKelurahan->nama_kelurahan ?? '' }}">
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-header">
                            <i class="fa-solid fa-calendar"></i>
                            <span class="label">Tahun Pembukaan</span>
                        </div>
                        <div class="info-content">
                            <span class="view-value" id="view-tahun_pembukaan">{{ $profilKelurahan->tahun_pembukaan ?? '-' }}</span>
                            <input type="number" class="form-control" name="tahun_pembukaan" id="input-tahun_pembukaan" value="{{ $profilKelurahan->tahun_pembukaan ?? '' }}">
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-header">
                            <i class="fa-solid fa-hashtag"></i>
                            <span class="label">Kode Wilayah</span>
                        </div>
                        <div class="info-content">
                            <span class="view-value" id="view-nomor_kode_wilayah">{{ $profilKelurahan->nomor_kode_wilayah ?? '-' }}</span>
                            <input type="text" class="form-control" name="nomor_kode_wilayah" id="input-nomor_kode_wilayah" value="{{ $profilKelurahan->nomor_kode_wilayah ?? '' }}">
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-header">
                            <i class="fa-solid fa-envelope"></i>
                            <span class="label">Kode Pos</span>
                        </div>
                        <div class="info-content">
                            <span class="view-value" id="view-nomor_kode_pos">{{ $profilKelurahan->nomor_kode_pos ?? '-' }}</span>
                            <input type="text" class="form-control" name="nomor_kode_pos" id="input-nomor_kode_pos" value="{{ $profilKelurahan->nomor_kode_pos ?? '' }}">
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-header">
                            <i class="fa-solid fa-map-location-dot"></i>
                            <span class="label">Kecamatan</span>
                        </div>
                        <div class="info-content">
                            <span class="view-value" id="view-kecamatan">{{ $profilKelurahan->kecamatan ?? '-' }}</span>
                            <input type="text" class="form-control" name="kecamatan" id="input-kecamatan" value="{{ $profilKelurahan->kecamatan ?? '' }}">
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-header">
                            <i class="fa-solid fa-city"></i>
                            <span class="label">Kabupaten/Kota</span>
                        </div>
                        <div class="info-content">
                            <span class="view-value" id="view-kabupaten_kota">{{ $profilKelurahan->kabupaten_kota ?? '-' }}</span>
                            <input type="text" class="form-control" name="kabupaten_kota" id="input-kabupaten_kota" value="{{ $profilKelurahan->kabupaten_kota ?? '' }}">
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-header">
                            <i class="fa-solid fa-flag"></i>
                            <span class="label">Provinsi</span>
                        </div>
                        <div class="info-content">
                            <span class="view-value" id="view-provinsi">{{ $profilKelurahan->provinsi ?? '-' }}</span>
                            <input type="text" class="form-control" name="provinsi" id="input-provinsi" value="{{ $profilKelurahan->provinsi ?? '' }}">
                        </div>
                    </div>
                </div>

                <div class="info-item full-width" style="margin-top: 20px;">
                    <div class="info-header">
                        <i class="fa-solid fa-gavel"></i>
                        <span class="label">Dasar Hukum Pembentukan</span>
                    </div>
                    <div class="info-content">
                        <span class="view-value" id="view-dasar_hukum_pembentukan">{{ $profilKelurahan->dasar_hukum_pembentukan ?? '-' }}</span>
                        <textarea class="form-control" name="dasar_hukum_pembentukan" id="input-dasar_hukum_pembentukan" rows="2">{{ $profilKelurahan->dasar_hukum_pembentukan ?? '' }}</textarea>
                    </div>
                </div>
            </div>

            <div class="card">
                <h2>Visi & Misi</h2>

                <div class="visi-section">
                    <h3>Visi</h3>
                    <div class="visi-content">
                        <span class="view-value" id="view-visi" style="font-style: italic; font-size: 1.1em;">
                            "{{ $profilKelurahan->visi ?? 'Belum ada visi' }}"
                        </span>
                        <textarea class="form-control" name="visi" id="input-visi" rows="3">{{ $profilKelurahan->visi ?? '' }}</textarea>
                    </div>
                </div>

                <div class="misi-section">
                    <div class="misi-header">
                        <h3>Misi</h3>
                        <div class="misi-actions">
                            <button type="button" class="btn-misi btn-add-misi" onclick="addMisi()">
                                <i class="fa-solid fa-plus"></i> Tambah Misi
                            </button>
                        </div>
                    </div>
                    
                    <div class="misi-list" id="misi-list-container">
                        @php
                            // Logika: Ambil data misi dari DB. Karena di Model sudah di cast 'array', 
                            // $profilKelurahan->misi sudah berbentuk Array PHP.
                            $misiItems = $profilKelurahan->misi ?? [];
                            
                            // Jika kosong, sediakan array kosong agar loop tidak error, 
                            // atau berikan 1 input kosong default di Javascript nanti.
                        @endphp

                        @forelse($misiItems as $index => $misi)
                            <div class="misi-item">
                                <span class="misi-num">{{ $index + 1 }}</span>
                                <div class="content-wrapper">
                                    <span class="view-value" id="view-misi_{{ $index }}">{{ $misi }}</span>
                                    
                                    {{-- name="misi[]" penting agar dikirim sebagai array ke controller --}}
                                    <input type="text" class="form-control" name="misi[]" id="input-misi_{{ $index }}" value="{{ $misi }}">
                                    
                                    <button type="button" class="btn-remove-misi" onclick="removeMisi(this)" style="display: none;">
                                        <i class="fa-solid fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        @empty
                            <div class="misi-item">
                                <span class="misi-num">1</span>
                                <div class="content-wrapper">
                                    <span class="view-value" id="view-misi_0">-</span>
                                    <input type="text" class="form-control" name="misi[]" id="input-misi_0" placeholder="Masukkan misi...">
                                    <button type="button" class="btn-remove-misi" onclick="removeMisi(this)" style="display: none;">
                                        <i class="fa-solid fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

</form>

    </main>
</div>
@endsection

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
    /* CSS SAMA SEPERTI SEBELUMNYA, TIDAK ADA PERUBAHAN SIGNIFIKAN DIPERLUKAN */
    /* Copy paste style dari kode Anda sebelumnya di sini */
    
    .container { width: 100%; max-width: 800px; display: flex; flex-direction: column; gap: 20px; margin: 0 auto; }
    .card { background-color: #ffffff; border-radius: 12px; padding: 24px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); border: 1px solid #eef0f2; }
    h1 { font-size: 20px; font-weight: 600; color: #1f2937; }
    h2 { font-size: 18px; font-weight: 600; color: #1f2937; margin-bottom: 20px; }
    h3 { font-size: 16px; font-weight: 500; color: #374151; margin-bottom: 8px; }
    p.subtitle { font-size: 14px; color: #6b7280; margin-top: 4px; }
    .label { font-size: 14px; color: #6b7280; margin-bottom: 6px; display: block; }
    .header-content { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px; }
    .header-actions { display: flex; gap: 10px; align-items: center; }
    .btn-action { border: none; padding: 10px 20px; border-radius: 6px; font-size: 14px; font-weight: 500; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; transition: all 0.2s; }
    .btn-edit { background-color: #00a86b; color: white; } .btn-edit:hover { background-color: #008f5b; }
    .btn-save { background-color: #0d6efd; color: white; display: none; } .btn-save:hover { background-color: #0b5ed7; }
    .form-control { width: 100%; padding: 10px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-family: inherit; font-size: 15px; color: #1f2937; background-color: #fff; outline: none; transition: border-color 0.2s; display: none; }
    .form-control:focus { border-color: #0d6efd; box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.15); }
    textarea.form-control { resize: vertical; min-height: 80px; }
    .view-value { font-size: 15px; color: #4b5563; line-height: 1.6; display: block; }
    .info-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; margin-bottom: 24px; }
    .info-item { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 16px; transition: all 0.2s ease; }
    .info-item:hover { border-color: #cbd5e1; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
    .info-item.full-width { grid-column: 1 / -1; background: #f1f5f9; border-color: #cbd5e1; }
    .info-header { display: flex; align-items: center; gap: 10px; margin-bottom: 12px; padding-bottom: 8px; border-bottom: 1px solid #e2e8f0; }
    .info-header i { color: #00a86b; font-size: 16px; width: 20px; text-align: center; }
    .info-header .label { font-weight: 600; color: #374151; font-size: 14px; margin: 0; }
    .info-content { position: relative; }
    .info-content .view-value { color: #1f2937; font-size: 15px; line-height: 1.5; padding: 8px 0; }
    @media (max-width: 768px) { .info-grid { grid-template-columns: 1fr; gap: 16px; } }
    .row-grid { display: grid; grid-template-columns: 1fr; gap: 20px; }
    @media (min-width: 600px) { .row-grid { grid-template-columns: 1fr 1fr; } }
    .visi-section { margin-bottom: 32px; padding-bottom: 24px; border-bottom: 1px solid #e5e7eb; }
    .misi-section { margin-top: 24px; }
    .misi-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
    .misi-list { list-style: none; counter-reset: misi-counter; }
    .misi-item { position: relative; padding-left: 32px; margin-bottom: 16px; display: flex; align-items: flex-start; }
    .misi-num { position: absolute; left: 0; top: 2px; color: #00a86b; font-weight: 600; font-size: 14px; width: 24px; height: 24px; background-color: #f0fdf4; border: 2px solid #00a86b; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 12px; }
    body.is-editing .misi-num { top: 12px; }
    .misi-item .content-wrapper { flex: 1; position: relative; padding-right: 40px; }
    .misi-actions { display: flex; gap: 8px; align-items: center; }
    .btn-misi { border: none; padding: 8px 16px; border-radius: 6px; font-size: 13px; font-weight: 500; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; transition: all 0.2s; }
    .btn-add-misi { background-color: #22c55e; color: white; border: 1px solid #22c55e; }
    .btn-add-misi:hover { background-color: #16a34a; border-color: #16a34a; }
    .btn-remove-misi { position: absolute; right: 8px; top: 8px; background-color: #ef4444; color: white; border: none; border-radius: 50%; width: 24px; height: 24px; display: flex; align-items: center; justify-content: center; cursor: pointer; font-size: 12px; transition: all 0.2s; box-shadow: 0 2px 4px rgba(239, 68, 68, 0.2); z-index: 10; }
    .btn-remove-misi:hover { background-color: #dc2626; transform: scale(1.1); }
    body.is-editing .btn-remove-misi { display: flex !important; }
    body:not(.is-editing) .btn-add-misi { display: none; }
    body.is-editing .view-value { display: none; }
    body.is-editing .form-control { display: block; }
    body.is-editing .btn-edit { display: none; }
    body.is-editing .btn-save { display: inline-flex; }
    @keyframes slideInRight {
        from { transform: translateX(120%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    @keyframes scaleIn {
        from { transform: scale(0.9); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }
</style>
@endpush

@push('scripts')
<script>
    // Inisialisasi jumlah misi berdasarkan data yang dirender server
    let misiCount = {{ isset($misiItems) ? count($misiItems) : 1 }};

    function toggleEditMode() {
        document.body.classList.add('is-editing');
        showNotification('Mode edit aktif. Silakan ubah data profil kelurahan.', 'info');
    }

    function saveData() {
        const form = document.getElementById('form-profil-kelurahan');
        const namaKelurahan = document.getElementById('input-nama_kelurahan');

        if (!namaKelurahan.value.trim()) {
            showNotification('Nama kelurahan wajib diisi.', 'warning');
            namaKelurahan.focus();
            return;
        }

        showActionConfirm({
            type: 'success',
            title: 'Simpan Perubahan?',
            message: 'Apakah Anda yakin ingin menyimpan perubahan profil kelurahan?',
            confirmText: 'Ya, Simpan',
            onConfirm: submitProfilKelurahan
        });
    }

    function submitProfilKelurahan() {
        // Tampilkan loading state
        const saveButton = document.querySelector('.btn-save');
        const originalText = saveButton.innerHTML;
        saveButton.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Menyimpan...';
        saveButton.disabled = true;

        // Ambil data form
        const form = document.getElementById('form-profil-kelurahan');
        const formData = new FormData(form);

        // Kirim data via AJAX/Fetch
        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                // Update tampilan DOM dengan data terbaru
                const inputs = document.querySelectorAll('.form-control');
                inputs.forEach(input => {
                    const idPart = input.id.replace('input-', '');
                    const viewElement = document.getElementById('view-' + idPart);
                    
                    if(viewElement) {
                        viewElement.innerText = input.value || '-';
                    }
                });

                document.body.classList.remove('is-editing');
                showNotification(data.message || 'Profil Kelurahan berhasil disimpan!', 'success');
            } else {
                showNotification(getErrorMessage(data, 'Terjadi kesalahan saat menyimpan data'), 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Terjadi kesalahan jaringan. Silakan coba lagi.', 'error');
        })
        .finally(() => {
            // Kembalikan button ke state semula
            saveButton.innerHTML = originalText;
            saveButton.disabled = false;
        });
    }

    function addMisi() {
        misiCount++;
        const misiList = document.getElementById('misi-list-container');
        const newMisiItem = document.createElement('div');
        newMisiItem.className = 'misi-item';
        
        // Perhatikan penambahan name="misi[]" pada input
        newMisiItem.innerHTML = `
            <span class="misi-num">${misiCount}</span>
            <div class="content-wrapper">
                <span class="view-value" id="view-misi_${misiCount}"></span>
                <input type="text" class="form-control" name="misi[]" id="input-misi_${misiCount}" placeholder="Masukkan misi baru...">
                <button type="button" class="btn-remove-misi" onclick="removeMisi(this)" style="display: block;">
                    <i class="fa-solid fa-times"></i>
                </button>
            </div>
        `;
        
        misiList.appendChild(newMisiItem);
        showNotification('Kolom misi baru berhasil ditambahkan.', 'info');
        
        // Karena kita dalam mode edit (tombol add muncul), pastikan input baru terlihat
        // CSS body.is-editing .form-control { display: block } akan menanganinya,
        // tapi kita perlu memastikan input tersebut fokus.
        setTimeout(() => {
             document.getElementById(`input-misi_${misiCount}`).focus();
        }, 100);
    }

    function removeMisi(button) {
        const misiItem = button.closest('.misi-item');
        const misiList = document.getElementById('misi-list-container');
        
        if (misiList.children.length > 1) {
            showActionConfirm({
                type: 'delete',
                title: 'Hapus Misi?',
                message: 'Apakah Anda yakin ingin menghapus misi ini?',
                confirmText: 'Ya, Hapus',
                onConfirm: function() {
                    misiItem.remove();
                    updateMisiNumbers();
                    showNotification('Misi berhasil dihapus dari daftar.', 'success');
                }
            });
        } else {
            showNotification('Minimal harus ada 1 misi!', 'warning');
        }
    }

    function updateMisiNumbers() {
        const misiItems = document.querySelectorAll('.misi-item');
        misiItems.forEach((item, index) => {
            const numElement = item.querySelector('.misi-num');
            const viewElement = item.querySelector('.view-value');
            const inputElement = item.querySelector('.form-control');
            
            const newNum = index + 1;
            
            numElement.textContent = newNum;
            
            // Update ID agar sinkron saat save local
            // Gunakan _ sebagai pemisah agar konsisten dengan PHP loop
            if (viewElement) viewElement.id = `view-misi_${index}`;
            if (inputElement) inputElement.id = `input-misi_${index}`;
        });
        misiCount = misiItems.length;
    }

    function showNotification(message, type = 'success') {
        document.querySelectorAll('.custom-notification').forEach(n => n.remove());

        const notification = document.createElement('div');
        const config = {
            success: { icon: 'bx-check-circle', bg: 'linear-gradient(135deg, #10b981, #059669)', color: '#fff' },
            error: { icon: 'bx-x-circle', bg: 'linear-gradient(135deg, #ef4444, #dc2626)', color: '#fff' },
            warning: { icon: 'bx-exclamation-circle', bg: 'linear-gradient(135deg, #f59e0b, #d97706)', color: '#fff' },
            info: { icon: 'bx-info-circle', bg: 'linear-gradient(135deg, #3b82f6, #2563eb)', color: '#fff' }
        };
        const c = config[type] || config.success;
        
        notification.className = 'custom-notification';
        notification.style.cssText = `
            position: fixed; top: 20px; right: 20px;
            background: ${c.bg}; color: ${c.color};
            padding: 16px 24px; border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2); z-index: 10000;
            font-family: 'Inter', sans-serif; font-size: 14px;
            display: flex; align-items: center; gap: 12px;
            animation: slideInRight 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            min-width: 280px; max-width: 400px;
        `;
        notification.innerHTML = `
            <i class="bx ${c.icon}" style="font-size: 24px;"></i>
            <span style="font-weight: 500;">${message}</span>
        `;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.style.transform = 'translateX(120%)';
            notification.style.opacity = '0';
            notification.style.transition = 'all 0.4s ease';
            setTimeout(() => notification.remove(), 400);
        }, 3500);
    }

    function showActionConfirm({ type = 'success', title, message, confirmText = 'Ya', onConfirm }) {
        const oldModal = document.getElementById('action-confirm-modal');
        if (oldModal) oldModal.remove();

        const isDelete = type === 'delete';
        const modal = document.createElement('div');
        modal.id = 'action-confirm-modal';
        modal.style.cssText = `
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.5); z-index: 9999;
            display: flex; align-items: center; justify-content: center;
            animation: fadeIn 0.3s ease;
        `;

        modal.innerHTML = `
            <div style="background: white; border-radius: 16px; padding: 30px; max-width: 400px; width: 90%;
                        box-shadow: 0 20px 60px rgba(0,0,0,0.3); animation: scaleIn 0.3s ease;">
                <div style="text-align: center; margin-bottom: 20px;">
                    <div style="width: 70px; height: 70px; border-radius: 50%; background: ${isDelete ? '#fef2f2' : '#ecfdf5'};
                                display: flex; align-items: center; justify-content: center; margin: 0 auto 15px;">
                        <i class="bx ${isDelete ? 'bx-trash' : 'bx-check-circle'}" style="font-size: 36px; color: ${isDelete ? '#ef4444' : '#10b981'};"></i>
                    </div>
                    <h3 style="margin: 0 0 8px; font-size: 20px; color: #1f2937;">${title}</h3>
                    <p style="margin: 0; color: #6b7280; font-size: 14px;">${message}</p>
                </div>
                <div style="display: flex; gap: 12px; justify-content: center;">
                    <button type="button" id="cancelActionConfirm" style="flex: 1; padding: 12px 24px; border: none;
                                border-radius: 10px; background: #f3f4f6; color: #374151; font-weight: 500;
                                cursor: pointer; transition: all 0.2s;">Batal</button>
                    <button type="button" id="confirmActionConfirm" style="flex: 1; padding: 12px 24px; border: none;
                                border-radius: 10px; background: ${isDelete ? '#ef4444' : '#10b981'}; color: white; font-weight: 500;
                                cursor: pointer; transition: all 0.2s;">${confirmText}</button>
                </div>
            </div>
        `;

        modal.onclick = function(e) {
            if (e.target === modal) closeActionConfirm();
        };

        document.body.appendChild(modal);
        document.getElementById('cancelActionConfirm').onclick = closeActionConfirm;
        document.getElementById('confirmActionConfirm').onclick = function() {
            closeActionConfirm();
            if (typeof onConfirm === 'function') onConfirm();
        };
    }

    function closeActionConfirm() {
        const modal = document.getElementById('action-confirm-modal');
        if (modal) {
            modal.style.opacity = '0';
            setTimeout(() => modal.remove(), 300);
        }
    }

    function getErrorMessage(data, fallback) {
        if (data?.errors) {
            const firstKey = Object.keys(data.errors)[0];
            if (firstKey && data.errors[firstKey]?.length) return data.errors[firstKey][0];
        }
        return data?.message || fallback;
    }
</script>
@endpush
