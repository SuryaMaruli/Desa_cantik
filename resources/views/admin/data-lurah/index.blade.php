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
            <button class="btn-edit" onclick="openDataLurahModal()">
                <i class="fa-regular fa-pen-to-square"></i> Edit Data
            </button>
        </div>
    </div>

    <div class="content-grid">
        
        <div class="card photo-card">
            <div class="card-title">
                <i class="fa-regular fa-user"></i> Foto Lurah
            </div>
            <div class="photo-placeholder">
                <div class="placeholder-content">
                    <div class="user-icon-wrapper">
                        <i class="fa-solid fa-user"></i>
                    </div>
                    <span>Belum ada foto</span>
                </div>
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
                    <div class="data-box" id="displayJabatanLurah">{{ $dataLurah->jabatan ?? 'Lurah Citangkil' }}</div>
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
</style>

@push('scripts')
<script>
// Fungsi untuk menampilkan notifikasi
function showNotification(message, type = 'info') {
    // Buat elemen notifikasi
    const notification = document.createElement('div');
    notification.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
    notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    notification.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;
    
    // Tambahkan ke body
    document.body.appendChild(notification);
    
    // Auto remove setelah 5 detik
    setTimeout(() => {
        if (notification.parentNode) {
            notification.remove();
        }
    }, 5000);
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
        });
}

// Fungsi untuk update display dengan data dari database
function updateDisplayWithData(dataLurah) {
    document.getElementById('displayNamaLurah').textContent = dataLurah.nama_lurah || 'M. ALI WAHIDI, S.Sos.M.Si';
    document.getElementById('displayJabatanLurah').textContent = dataLurah.jabatan || 'Lurah Citangkil';
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
    document.getElementById('golonganLurah').value = dataLurah.golongan || 'IV/b';
    document.getElementById('jabatanLurah').value = dataLurah.jabatan || 'Lurah Citangkil';
    document.getElementById('sambutanLurah').value = dataLurah.sambutan_lurah || 'Situs web ini kami hadirkan sebagai wadah untuk mempublikasi atau informasi kepada masyarakat. Dengan kemudahan yang diberikan, diharapkan dapat mempercepat proses pelayanan publik dan mempermudah masyarakat dalam memperoleh informasi terkini.';
    
    // Load foto jika ada
    if (dataLurah.foto_lurah) {
        showFotoPreview('/storage/foto-lurah/' + dataLurah.foto_lurah);
    }
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
}

// Event listener untuk file input
document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('fotoLurah');
    if (fileInput) {
        fileInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    showFotoPreview(e.target.result);
                };
                reader.readAsDataURL(file);
            }
        });
    }
});

// Override fungsi simpanDataLurah untuk menggunakan backend
window.simpanDataLurah = function() {
    const formData = new FormData();
    formData.append('namaLurah', document.getElementById('namaLurah').value);
    formData.append('nipLurah', document.getElementById('nipLurah').value);
    formData.append('pangkatLurah', document.getElementById('pangkatLurah').value);
    formData.append('golonganLurah', document.getElementById('golonganLurah').value);
    formData.append('jabatanLurah', document.getElementById('jabatanLurah').value);
    formData.append('sambutanLurah', document.getElementById('sambutanLurah').value);
    
    // Add foto if selected
    const fotoInput = document.getElementById('fotoLurah');
    if (fotoInput.files[0]) {
        formData.append('fotoLurah', fotoInput.files[0]);
    }
    
    formData.append('_token', '{{ csrf_token() }}');

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
            showNotification('Data lurah berhasil disimpan!', 'success');
            
            // Tutup modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('dataLurahModal'));
            if (modal) {
                modal.hide();
            }
        } else {
            showNotification(data.message || 'Gagal menyimpan data lurah!', 'danger');
        }
    })
    .catch(error => {
        console.error('Error saving data lurah:', error);
        showNotification('Terjadi kesalahan saat menyimpan data!', 'danger');
    });
};

// Fungsi untuk update foto di halaman display
function updateFotoDisplay(fotoUrl) {
    const photoPlaceholder = document.querySelector('.photo-placeholder');
    if (photoPlaceholder) {
        photoPlaceholder.innerHTML = `
            <img src="${fotoUrl}" alt="Foto Lurah" style="max-width: 100%; max-height: 320px; border-radius: 12px; object-fit: cover;">
        `;
    }
}

// Fungsi untuk membuka modal Data Lurah
window.openDataLurahModal = function() {
    // Load data terbaru dari database
    loadDataLurahFromDB();
    
    // Buka modal
    const modal = new bootstrap.Modal(document.getElementById('dataLurahModal'));
    modal.show();
};
</script>
@endpush
@endsection
