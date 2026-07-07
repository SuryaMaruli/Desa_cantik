@extends('layouts.admin')

@section('page-title', 'Data Lurah')

@section('content')
<div class="container">
    
    <div class="header-card">
        <div class="header-content">
            <div class="header-text">
                <h1>Manajemen Data Lurah</h1>
                <p>Kelola informasi dan foto Lurah yang ditampilkan di beranda</p>
            </div>
<div style="display:flex; gap:10px; flex-wrap:wrap;">
                <button class="btn-edit" onclick="openDataLurahModal()">
                    <i class="fa-regular fa-pen-to-square"></i> Edit Data
                </button>
            </div>
        </div>
    </div>

    <div class="content-grid">
        
        <div class="card photo-card">
            <div class="card-title">
                <i class="fa-regular fa-user"></i> Foto Lurah
            </div>
        <div class="photo-placeholder">
            @if($dataLurah && $dataLurah->foto_lurah)
                <img src="{{ asset('storage/foto-lurah/' . $dataLurah->foto_lurah) }}" alt="Foto Lurah" style="max-width: 100%; max-height: 320px; border-radius: 12px; object-fit: cover;">
            @else
                <div class="placeholder-content">
                    <div class="user-icon-wrapper">
                        <i class="fa-solid fa-user"></i>
                    </div>
                    <span>Belum ada foto</span>
                </div>
            @endif
        </div>
        </div>

        <div class="card info-card">
            <div class="card-title">
                <i class="fa-regular fa-file-lines"></i> Informasi Personal
            </div>

            <div class="form-grid">
                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <div class="data-box" id="displayNamaLurah">{{ $dataLurah->nama_lurah ?? 'M. ALI WAHIDI, S.Sos.M.Si' }}</div>
                </div>
                <div class="form-group">
                    <label>Jabatan</label>
                    <div class="data-box" id="displayJabatanLurah">{{ $dataLurah->jabatan ?? 'Lurah Bulakan' }}</div>
                </div>
                <div class="form-group">
                    <label>NIP</label>
                    <div class="data-box" id="displayNipLurah">{{ $dataLurah->nip ?? '196512311985031023' }}</div>
                </div>
                <div class="form-group">
                    <label>Pangkat</label>
                    <div class="data-box" id="displayPangkatLurah">{{ $dataLurah->pangkat ?? 'Pembina Tingkat I' }}</div>
                </div>
                <div class="form-group" style="grid-column: span 2;">
                    <label>Golongan</label>
                    <div class="data-box" id="displayGolonganLurah">{{ $dataLurah->golongan ?? 'IV/b' }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="card sambutan-card">
        <div class="card-title">
            <i class="fa-solid fa-quote-left"></i> Sambutan Lurah
        </div>

        <div class="form-group">
            <label>Sambutan</label>
            <div class="data-box" id="displaySambutanLurah">
                {{ $dataLurah->sambutan_lurah ?? 'Situs web ini kami hadirkan sebagai wadah untuk mempublikasi atau informasi kepada masyarakat. Dengan kemudahan yang diberikan, diharapkan dapat mempercepat proses pelayanan publik dan mempermudah masyarakat dalam memperoleh informasi terkini.' }}
            </div>
        </div>
    </div>

    <div class="alert-card">
        <div class="alert-title">
            <i class="fa-solid fa-medal"></i> Informasi Preview
        </div>
        <p class="alert-text">
            Perubahan yang Anda lakukan akan langsung terlihat di halaman beranda website. Pastikan semua informasi sudah benar sebelum menyimpan.
        </p>
    </div>

</div>

<style>
/* --- CSS STYLING --- */

/* Reset Dasar */
.container {
    width: 100%;
    max-width: 1050px;
    display: flex;
    flex-direction: column;
    gap: 24px;
    margin: 0 auto;
    padding: 20px;
}

/* Styling Umum Kartu (Card) */
.card {
    background-color: #ffffff;
    border-radius: 12px;
    padding: 24px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    border: 1px solid #eef0f2;
}

/* --- Header --- */
.header-card {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 15px;
}

.header-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 100%;
    gap: 20px;
}

.header-text h1 {
    font-size: 22px;
    font-weight: 600;
    color: #2d3436;
    margin-bottom: 8px;
}

.header-text p {
    font-size: 15px;
    color: #636e72;
}

.btn-edit {
    background-color: #ff5400;
    color: white;
    border: none;
    padding: 12px 24px;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 8px;
    transition: background-color 0.2s;
    flex-shrink: 0;
}

.btn-edit:hover {
    background-color: #e04a00;
}

/* --- Layout Grid (Foto & Info) --- */
.content-grid {
    display: grid;
    grid-template-columns: 320px 1fr;
    gap: 24px;
    align-items: start;
}

.card-title {
    font-size: 16px;
    font-weight: 600;
    color: #2d3436;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 12px;
}

.card-title i {
    color: #ff5400;
    font-size: 18px;
}

/* --- Bagian Foto --- */
.photo-placeholder {
    background-color: #fff8e1;
    border-radius: 12px;
    height: 320px;
    display: flex;
    justify-content: center;
    align-items: center;
    color: #ff8a65;
}

.placeholder-content {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 12px;
}

.user-icon-wrapper {
    font-size: 40px;
    border: 3px solid #ffccbc;
    border-radius: 50%;
    width: 80px;
    height: 80px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #ff7043;
}

.placeholder-content span {
    font-size: 14px;
    color: #ff5400;
    font-weight: 500;
}

/* --- Form Elements --- */
.form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    column-gap: 24px;
    row-gap: 24px;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 8px;
    margin-bottom: 20px;
}

/* Menghapus margin bawah untuk elemen terakhir agar rapi */
.form-group:last-child {
    margin-bottom: 0;
}

.form-group label {
    font-size: 14px;
    color: #636e72;
    font-weight: 500;
}

.data-box {
    background-color: #f8f9fa;
    padding: 14px 16px;
    border-radius: 6px;
    font-size: 15px;
    color: #2d3436;
    font-weight: 400;
    line-height: 1.6;
    border: 1px solid transparent;
}

/* --- Alert Card (Bagian Bawah) --- */
.alert-card {
    background-color: #fffbf0;
    border: 1px solid #ffe0b2;
    border-radius: 12px;
    padding: 24px;
}

.alert-title {
    color: #bf360c;
    font-size: 16px;
    font-weight: 600;
    margin-bottom: 8px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.alert-title i {
    color: #ff5400;
}

.alert-text {
    color: #d84315;
    font-size: 14px;
    line-height: 1.5;
    margin-left: 28px;
}

/* --- Responsive --- */
@media (max-width: 850px) {
    .content-grid {
        grid-template-columns: 1fr;
    }
    .header-content {
        flex-direction: column;
        align-items: flex-start;
    }
    .btn-edit {
        width: 100%;
        justify-content: center;
    }
    .alert-text {
        margin-left: 0;
    }
}
@media (max-width: 600px) {
    .form-grid {
        grid-template-columns: 1fr;
    }
}

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

@push('scripts')
<script>
function showNotification(message, type = 'success') {
    document.querySelectorAll('.custom-notification').forEach(n => n.remove());

    const notification = document.createElement('div');
    const config = {
        success: { icon: 'bx-check-circle', bg: 'linear-gradient(135deg, #10b981, #059669)', color: '#fff' },
        error: { icon: 'bx-x-circle', bg: 'linear-gradient(135deg, #ef4444, #dc2626)', color: '#fff' },
        danger: { icon: 'bx-x-circle', bg: 'linear-gradient(135deg, #ef4444, #dc2626)', color: '#fff' },
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
        font-family: 'Poppins', sans-serif; font-size: 14px;
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

function showDeleteConfirm(onConfirm) {
    const oldModal = document.getElementById('delete-confirm-modal');
    if (oldModal) oldModal.remove();

    const modal = document.createElement('div');
    modal.id = 'delete-confirm-modal';
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
                <div style="width: 70px; height: 70px; border-radius: 50%; background: #fef2f2;
                            display: flex; align-items: center; justify-content: center; margin: 0 auto 15px;">
                    <i class="bx bx-trash" style="font-size: 36px; color: #ef4444;"></i>
                </div>
                <h3 style="margin: 0 0 8px; font-size: 20px; color: #1f2937;">Konfirmasi Hapus</h3>
                <p style="margin: 0; color: #6b7280; font-size: 14px;">
                    Apakah Anda yakin ingin menghapus<br>
                    <strong style="color: #1f2937; font-size: 16px;">kata sambutan dan foto lurah</strong>?
                </p>
            </div>
            <div style="display: flex; gap: 12px; justify-content: center;">
                <button type="button" id="cancelDeleteSambutan" style="flex: 1; padding: 12px 24px; border: none;
                            border-radius: 10px; background: #f3f4f6; color: #374151; font-weight: 500;
                            cursor: pointer; transition: all 0.2s;">Batal</button>
                <button type="button" id="confirmDeleteSambutan" style="flex: 1; padding: 12px 24px; border: none;
                            border-radius: 10px; background: #ef4444; color: white; font-weight: 500;
                            cursor: pointer; transition: all 0.2s;">Ya, Hapus</button>
            </div>
        </div>
    `;

    modal.onclick = function(e) {
        if (e.target === modal) closeDeleteModal();
    };

    document.body.appendChild(modal);

    document.getElementById('cancelDeleteSambutan').onclick = closeDeleteModal;
    document.getElementById('confirmDeleteSambutan').onclick = function() {
        closeDeleteModal();
        onConfirm();
    };
}

function closeDeleteModal() {
    const modal = document.getElementById('delete-confirm-modal');
    if (modal) {
        modal.style.opacity = '0';
        setTimeout(() => modal.remove(), 300);
    }
}

// Load data lurah dari database saat page load
document.addEventListener('DOMContentLoaded', function() {
    loadDataLurahFromDB();
});

// Fungsi untuk load data lurah dari database
function loadDataLurahFromDB() {
    fetch('{{ route("admin.data-lurah.api") }}')
        .then(response => response.json())
        .then(data => {
            if (data.success && data.data) {
                updateDisplayWithData(data.data);
                updateModalWithData(data.data);
            }
        })
        .catch(error => {
            console.error('Error loading data lurah:', error);
            showNotification('Gagal memuat data lurah terbaru.', 'error');
        });
}

// Fungsi untuk update display dengan data dari database
function updateDisplayWithData(dataLurah) {
    document.getElementById('displayNamaLurah').textContent = dataLurah.nama_lurah || 'M. ALI WAHIDI, S.Sos.M.Si';
    document.getElementById('displayJabatanLurah').textContent = dataLurah.jabatan || 'Lurah Bulakan';
    document.getElementById('displayNipLurah').textContent = dataLurah.nip || '196512311985031023';
    document.getElementById('displayPangkatLurah').textContent = dataLurah.pangkat || 'Pembina Tingkat I';
    document.getElementById('displayGolonganLurah').textContent = dataLurah.golongan || 'IV/b';
    document.getElementById('displaySambutanLurah').textContent = dataLurah.sambutan_lurah || 'Situs web ini kami hadirkan sebagai wadah untuk mempublikasi atau informasi kepada masyarakat. Dengan kemudahan yang diberikan, diharapkan dapat mempercepat proses pelayanan publik dan mempermudah masyarakat dalam memperoleh informasi terkini.';
}

// Fungsi untuk update modal dengan data dari database
function updateModalWithData(dataLurah) {
    document.getElementById('namaLurah').value = dataLurah.nama_lurah || 'M. ALI WAHIDI, S.Sos.M.Si';
    document.getElementById('nipLurah').value = dataLurah.nip || '196512311985031023';
    document.getElementById('pangkatLurah').value = dataLurah.pangkat || 'Pembina Tingkat I';
    document.getElementById('golonganLurah').value = dataLurah.golang || 'IV/b';
    document.getElementById('jabatanLurah').value = dataLurah.jabatan || 'Lurah Bulakan';
    document.getElementById('sambutanLurah').value = dataLurah.sambutan_lurah || 'Situs web ini kami hadirkan sebagai wadah untuk mempublikasi atau informasi kepada masyarakat. Dengan kemudahan yang diberikan, diharapkan dapat mempercepat proses pelayanan publik dan mempermudah masyarakat dalam memperoleh informasi terkini.';
    
    // Load foto jika ada
    if (dataLurah.foto_lurah) {
        showFotoPreview('/storage/foto-lurah/' + dataLurah.foto_lurah);
    } else {
        document.getElementById('fotoPreview').style.display = 'none';
        document.getElementById('fotoLurah').value = '';
    }
    
    // Setelah data dimuat, simpan sebagai data original dan inisialisasi event listeners untuk deteksi perubahan
    // Ini memastikan tombol "Simpan Perubahan" hanya aktif jika ada perubahan
    if (typeof simpanOriginalDataLurah === 'function') {
        simpanOriginalDataLurah();
    }
    if (typeof initEventListenersDataLurah === 'function') {
        initEventListenersDataLurah();
    }
    if (typeof cekPerubahanDataLurah === 'function') {
        cekPerubahanDataLurah();
    }
    
    // Force update tombol status setelah semua inisialisasi selesai
    setTimeout(function() {
        if (typeof cekPerubahanDataLurah === 'function') {
            cekPerubahanDataLurah();
        }
    }, 200);
}

// Fungsi untuk preview foto
function showFotoPreview(imageSrc) {
    const previewDiv = document.getElementById('fotoPreview');
    const previewImage = document.getElementById('previewImage');
    
    previewImage.src = imageSrc;
    previewDiv.style.display = 'block';
}

// Fungsi untuk menghapus foto
function removeFoto() {
    const previewDiv = document.getElementById('fotoPreview');
    const fileInput = document.getElementById('fotoLurah');
    
    previewDiv.style.display = 'none';
    fileInput.value = '';
    showNotification('Preview foto dihapus. Perubahan berlaku setelah disimpan.', 'info');
}

// Event listener untuk file input
document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('fotoLurah');
    if (fileInput) {
        fileInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (!file) return;

            const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
            if (!allowedTypes.includes(file.type)) {
                fileInput.value = '';
                showNotification('Format foto harus JPG, JPEG, PNG, atau WebP.', 'warning');
                return;
            }

            if (file.size > 2 * 1024 * 1024) {
                fileInput.value = '';
                showNotification('Ukuran foto maksimal 2 MB.', 'warning');
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                showFotoPreview(e.target.result);
                showNotification('Preview foto lurah berhasil dimuat.', 'info');
            };
            reader.readAsDataURL(file);
        });
    }
});

// Override fungsi simpanDataLurah untuk menggunakan backend
window.simpanDataLurah = function() {
    const namaLurah = document.getElementById('namaLurah').value.trim();
    const jabatanLurah = document.getElementById('jabatanLurah').value.trim();

    if (!namaLurah || !jabatanLurah) {
        showNotification('Nama dan jabatan lurah wajib diisi.', 'warning');
        return;
    }

    const formData = new FormData();
    formData.append('namaLurah', namaLurah);
    formData.append('nipLurah', document.getElementById('nipLurah').value);
    formData.append('pangkatLurah', document.getElementById('pangkatLurah').value);
    formData.append('golonganLurah', document.getElementById('golonganLurah').value);
    formData.append('jabatanLurah', jabatanLurah);
    formData.append('sambutanLurah', document.getElementById('sambutanLurah').value);
    
    // Add foto if selected
    const fotoInput = document.getElementById('fotoLurah');
    if (fotoInput.files[0]) {
        formData.append('fotoLurah', fotoInput.files[0]);
    }
    
    formData.append('_token', '{{ csrf_token() }}');

    const saveButton = document.querySelector('#dataLurahModal .btn-primary');
    const originalButtonHtml = saveButton ? saveButton.innerHTML : '';
    if (saveButton) {
        saveButton.disabled = true;
        saveButton.innerHTML = '<i class="bx bx-loader-alt bx-spin"></i> Menyimpan...';
    }

    fetch('{{ route("admin.data-lurah.update") }}', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update display dengan data baru
            updateDisplayWithData(data.data);
            
            // Update foto di halaman utama jika ada
            if (data.foto_url) {
                updateFotoDisplay(data.foto_url);
            }
            
            // Tampilkan notifikasi sukses
            showNotification(data.message || 'Data lurah berhasil disimpan!', 'success');
            
            // Tutup modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('dataLurahModal'));
            if (modal) {
                modal.hide();
            }
        } else {
            showNotification(data.message || 'Gagal menyimpan data lurah!', 'error');
        }
    })
    .catch(error => {
        console.error('Error saving data lurah:', error);
        showNotification('Terjadi kesalahan saat menyimpan data!', 'error');
    })
    .finally(() => {
        if (saveButton) {
            saveButton.disabled = false;
            saveButton.innerHTML = originalButtonHtml;
        }
    });
};

// Fungsi untuk update foto di halaman display
function updateFotoDisplay(fotoUrl) {
    const photoPlaceholder = document.querySelector('.photo-placeholder');
    if (!photoPlaceholder) return;

    if (fotoUrl) {
        photoPlaceholder.innerHTML = `
            <img src="${fotoUrl}" alt="Foto Lurah" style="max-width: 100%; max-height: 320px; border-radius: 12px; object-fit: cover;">
        `;
        return;
    }

    photoPlaceholder.innerHTML = `
        <div class="placeholder-content">
            <div class="user-icon-wrapper">
                <i class="fa-solid fa-user"></i>
            </div>
            <span>Belum ada foto</span>
        </div>
    `;
}

// Fungsi untuk membuka modal Data Lurah - dengan integrasi deteksi perubahan
window.openDataLurahModal = function() {
    // Load data terbaru dari database dan simpan sebagai data original
    loadDataLurahFromDBUntukEdit();
    
    // Buka modal
    const modal = new bootstrap.Modal(document.getElementById('dataLurahModal'));
    modal.show();
};

// Fungsi khusus untuk load data saat modal dibuka (menyimpan original data juga)
function loadDataLurahFromDBUntukEdit() {
    fetch('{{ route("admin.data-lurah.api") }}')
        .then(response => response.json())
        .then(data => {
            if (data.success && data.data) {
                updateDisplayWithData(data.data);
                updateModalWithData(data.data);
            }
        })
        .catch(error => {
            console.error('Error loading data lurah:', error);
            showNotification('Gagal memuat data lurah terbaru.', 'error');
        });
}

// Fungsi hapus kata sambutan + foto
window.hapusSambutanLurah = function() {
    showDeleteConfirm(function() {
    fetch('{{ route("admin.data-lurah.destroy-sambutan") }}', {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            updateDisplayWithData(data.data);
            updateFotoDisplay('');
            showNotification(data.message || 'Kata sambutan berhasil dihapus!', 'success');
            loadDataLurahFromDB();
        } else {
            showNotification(data.message || 'Gagal menghapus kata sambutan!', 'error');
        }
    })
    .catch(error => {
        console.error('Error deleting kata sambutan:', error);
        showNotification('Terjadi kesalahan saat menghapus data!', 'error');
    });
    });
};
</script>
@endpush
@endsection

