@extends('layouts.admin')

@section('page-title', 'Data Kelurahan')

@push('styles')
<style>
    /* --- 1. RESET & GLOBAL --- */
    :root {
        --header-height: 80px;
        --text-dark: #333;
        --primary-green: #008C6E;
    }

    /* --- 3. MAIN CONTENT --- */
    .home-content { 
        padding: 30px; 
        background-color: #fcfcfc;
        min-height: calc(100vh - var(--header-height));
    }

    /* --- 4. KONTEN KHUSUS DATA KELURAHAN --- */
    /* A. Header Section (Judul & Tombol) */
    .data-header-card {
        background: #fff; 
        border-radius: 12px; 
        padding: 25px 30px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.02); 
        border: 1px solid #eee;
        display: flex; 
        justify-content: space-between; 
        align-items: center;
        margin-bottom: 30px;
    }
    .header-text h3 { 
        font-size: 20px; 
        font-weight: 600; 
        color: #333; 
        margin-bottom: 5px; 
    }
    .header-text p { 
        font-size: 14px; 
        color: #666; 
        margin: 0; 
    }

    /* E. Tabel Data Penduduk */
.table-container {
        background: #fff;
        border-radius: 12px;
        padding: 25px 30px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.02);
        border: 1px solid #eee;
        margin-bottom: 30px;
        overflow-x: auto;
    }
    .table-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }
    .header-actions {
        display: flex;
        align-items: center;
        gap: 15px;
    }
    .btn-tambah {
        background: #28a745;
        color: white;
        padding: 8px 16px;
        border: none;
        border-radius: 8px;
        font-size: 14px;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s;
        font-weight: 500;
    }
    .btn-tambah:hover {
        background: #218838;
        transform: translateY(-1px);
    }
    .table-title {
        font-size: 18px;
        font-weight: 600;
        color: #333;
    }
.search-box {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }
    .search-input {
        padding: 10px 15px;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 14px;
        width: 100%;
        min-width: 150px;
        flex: 1;
    }
    .data-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }
    .data-table th {
        background: #f8f9fa;
        padding: 12px 15px;
        text-align: left;
        font-weight: 600;
        color: #333;
        border-bottom: 2px solid #e9ecef;
        font-size: 14px;
    }
    .data-table td {
        padding: 12px 15px;
        border-bottom: 1px solid #f1f3f4;
        font-size: 14px;
        color: #555;
    }
    .data-table tbody tr:hover {
        background: #f8f9fa;
    }
    .badge-status {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
    }
    .badge-menikah {
        background: #d4edda;
        color: #155724;
    }
    .badge-belum {
        background: #fff3cd;
        color: #856404;
    }
    .action-buttons {
        display: flex;
        gap: 8px;
    }
    .btn-action {
        padding: 6px 10px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 12px;
        display: flex;
        align-items: center;
        gap: 4px;
        transition: all 0.2s;
    }
    .btn-edit {
        background: #007bff;
        color: white;
    }
    .btn-edit:hover {
        background: #0056b3;
    }
    .btn-delete {
        background: #dc3545;
        color: white;
    }
    .btn-delete:hover {
        background: #c82333;
    }
    
    /* Modal Styles */
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0,0,0,0.0.5);
        animation: fadeIn 0.3s;
    }
    .modal-content {
        background-color: #fefefe;
        margin: 10% auto;
        padding: 0;
        border: 1px solid #888;
        border-radius: 12px;
        width: 500px;
        max-width: 90%;
        box-shadow: 0 4px 20px rgba(0,0,0,0.15);
        animation: slideIn 0.3s;
    }
    .modal-header {
        background: linear-gradient(135deg, #F6903A, #E57A2A);
        color: white;
        padding: 20px 25px;
        border-radius: 12px 12px 0 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .modal-header h3 {
        margin: 0;
        font-size: 18px;
        font-weight: 600;
    }
    .modal-close {
        background: none;
        border: none;
        font-size: 24px;
        color: white;
        cursor: pointer;
        padding: 0;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        transition: background 0.2s;
    }
    .modal-close:hover {
        background: rgba(255,255,255,0.2);
    }
    .form-group {
        margin-bottom: 20px;
        padding: 0 25px;
    }
    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
        color: #333;
    }
    .form-group input,
    .form-group select {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 14px;
        transition: border-color 0.2s;
        box-sizing: border-box;
    }
    .form-group input:focus,
    .form-group select:focus {
        outline: none;
        border-color: #F6903A;
        box-shadow: 0 0 0 3px rgba(246, 144, 58, 0.1);
    }
    .form-actions {
        display: flex;
        gap: 10px;
        justify-content: flex-end;
        padding: 20px 25px;
        background: #f8f9fa;
        border-radius: 0 0 12px 12px;
        margin: 0;
    }
    .btn-cancel {
        background: #6c757d;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 14px;
        transition: background 0.2s;
    }
    .btn-cancel:hover {
        background: #5a6268;
    }
    .btn-submit {
        background: #F6903A;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 6px;
        transition: background 0.2s;
    }
    .btn-submit:hover {
        background: #E57A2A;
    }
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    @keyframes slideIn {
        from { transform: translateY(-50px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }
    .header-text p { 
        font-size: 14px; 
        color: #666; 
    }
    
    /* B. Statistik Cards (4 Kotak Warna-warni) */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 25px; 
        margin-bottom: 30px;
    }
    
    .stat-card {
        background: #fff; 
        border-radius: 12px; 
        padding: 25px;
    }

    /* Varian Warna Card */
    .card-green { background-color: #ecfdf5; }
    .card-blue { background-color: #eff6ff; }
    .card-purple { background-color: #faf5ff; }
    .card-orange { background-color: #fff7ed; }

    .stat-icon {
        width: 45px; 
        height: 45px; 
        border-radius: 10px;
        display: flex; 
        align-items: center; 
        justify-content: center;
        font-size: 24px; 
        margin-bottom: 15px;
    }
    /* Icon Colors */
    .icon-green { background: #10b981; color: white; }
    .icon-blue { background: #3b82f6; color: white; }
    .icon-purple { background: #a855f7; color: white; }
    .icon-orange { background: #f97316; color: white; }

    .stat-title { 
        font-size: 14px; 
        color: #555; 
        margin-bottom: 8px; 
        font-weight: 500; 
    }
    .stat-value { 
        font-size: 28px; 
        font-weight: 600; 
        color: #333; 
        margin-bottom: 5px; 
    }
    .stat-unit { 
        font-size: 13px; 
        font-weight: 500; 
    }
    
    .text-green { color: #10b981; }
    .text-blue { color: #3b82f6; }
    .text-purple { color: #a855f7; }
    .text-orange { color: #f97316; }

    /* C. Sebaran Penduduk (Progress Bars) */
    .distribution-card {
        background: #fff; 
        border-radius: 12px; 
        padding: 30px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.02); 
        border: 1px solid #eee;
    }
    .distribution-card h3 { 
        font-size: 18px; 
        font-weight: 600; 
        color: #333; 
        margin-bottom: 25px; 
    }

    .rw-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        column-gap: 50px;
        row-gap: 25px;
    }

    .rw-item { 
        margin-bottom: 5px; 
    }
    
    .rw-info {
        display: flex; 
        justify-content: space-between; 
        margin-bottom: 8px; 
        font-size: 14px;
    }
    .rw-name { 
        font-weight: 500; 
        color: #333; 
    }
    .rw-count { 
        font-weight: 600; 
        color: #333; 
    }
    .rw-unit { 
        font-weight: 400; 
        color: #999; 
        font-size: 12px; 
        margin-left: 4px;
    }

    .progress-bg {
        width: 100%; 
        height: 8px; 
        background-color: #f3f4f6; 
        border-radius: 10px; 
        overflow: hidden;
    }
    .progress-fill {
        height: 100%; 
        background-color: #009669; 
        border-radius: 10px;
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .stats-grid { 
            grid-template-columns: repeat(2, 1fr); 
        }
        .rw-grid { 
            grid-template-columns: 1fr; 
        }
    }
    
@media (max-width: 768px) {
        .stats-grid { 
            grid-template-columns: 1fr; 
        }
        .data-header-card { 
            flex-direction: column; 
            align-items: flex-start; 
            gap: 15px; 
        }
        .rw-grid {
            grid-template-columns: 1fr;
            column-gap: 20px;
        }
    }

    /* Mobile Responsive Table & Buttons */
    @media (max-width: 480px) {
        .home-content {
            padding: 15px;
        }
        .table-container {
            padding: 15px;
        }
        .table-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 12px;
        }
        .header-actions {
            width: 100%;
            flex-wrap: wrap;
            gap: 10px;
        }
        .btn-tambah {
            width: 100%;
            justify-content: center;
            padding: 12px 16px;
            min-height: 44px;
        }
        .search-box {
            width: 100%;
        }
        .data-table {
            display: block;
            overflow-x: auto;
        }
        .data-table th,
        .data-table td {
            padding: 10px 8px;
            font-size: 13px;
            white-space: nowrap;
        }
        .btn-action {
            padding: 8px 12px;
            min-height: 44px;
            min-width: 44px;
            font-size: 11px;
        }
        .action-buttons {
            gap: 6px;
        }
        .modal-content {
            width: 95%;
            max-width: 95%;
            margin: 5% auto;
        }
        .form-group {
            padding: 0 15px;
        }
        .form-group input,
        .form-group select {
            font-size: 16px;
            padding: 12px;
        }
        .form-actions {
            flex-direction: column;
            gap: 10px;
        }
        .btn-cancel,
        .btn-submit {
            width: 100%;
            justify-content: center;
            padding: 12px;
            min-height: 44px;
        }
    }
</style>
@endpush

@section('content')
<div class="home-content">
    <div class="data-header-card">
        <div class="header-text">
            <h3>Data Kependudukan</h3>
            <p>Kelola data statistik penduduk kelurahan</p>
        </div>
    </div>

    <div class="stats-grid">
        <div class="stat-card card-green">
            <div class="stat-icon icon-green"><i class='bx bx-group'></i></div>
            <div class="stat-title">Total Penduduk</div>
            <div class="stat-value">{{ $data['total_penduduk'] }}</div>
            <div class="stat-unit text-green">Jiwa</div>
        </div>

        <div class="stat-card card-blue">
            <div class="stat-icon icon-blue"><i class='bx bx-male'></i></div>
            <div class="stat-title">Laki-Laki</div>
            <div class="stat-value">{{ $data['laki_laki'] }}</div>
            <div class="stat-unit text-blue">Jiwa</div>
        </div>

        <div class="stat-card card-purple">
            <div class="stat-icon icon-purple"><i class='bx bx-female'></i></div>
            <div class="stat-title">Perempuan</div>
            <div class="stat-value">{{ $data['perempuan'] }}</div>
            <div class="stat-unit text-purple">Jiwa</div>
        </div>

        <div class="stat-card card-orange">
            <div class="stat-icon icon-orange"><i class='bx bx-home-heart'></i></div>
            <div class="stat-title">Kepala Keluarga</div>
            <div class="stat-value">{{ $data['kepala_keluarga'] }}</div>
            <div class="stat-unit text-orange">KK</div>
        </div>
    </div>

    <div class="distribution-card">
        <h3>Sebaran Penduduk per RW</h3>
        
        <div class="rw-grid">
            <div class="rw-column">
                @foreach(array_slice($data['rws'], 0, 5) as $rw)
                <div class="rw-item">
                    <div class="rw-info">
                        <span class="rw-name">RW {{ $rw['no'] }}</span>
                        <div><span class="rw-count">{{ $rw['jumlah'] }}</span> <span class="rw-unit">jiwa</span></div>
                    </div>
                    <div class="progress-bg">
                        <div class="progress-fill" style="width: {{ $rw['persentase'] }}%;"></div>
                    </div>
                </div>
                @if(!$loop->last)<br>@endif
                @endforeach
            </div>

            <div class="rw-column">
                @foreach(array_slice($data['rws'], 5) as $rw)
                <div class="rw-item">
                    <div class="rw-info">
                        <span class="rw-name">RW {{ $rw['no'] }}</span>
                        <div><span class="rw-count">{{ $rw['jumlah'] }}</span> <span class="rw-unit">jiwa</span></div>
                    </div>
                    <div class="progress-bg">
                        <div class="progress-fill" style="width: {{ $rw['persentase'] }}%;"></div>
                    </div>
                </div>
                @if(!$loop->last)<br>@endif
                @endforeach
            </div>
        </div>
    </div>

    <!-- Tabel Data Penduduk -->
    <div class="table-container">
        <div class="table-header">
            <h3 class="table-title">Data Penduduk</h3>
            <div class="header-actions">
                <button class="btn-tambah" onclick="tambahPenduduk()">
                    <i class='bx bx-plus-circle'></i> Tambah Penduduk
                </button>
                <div class="search-box">
                    <input type="text" class="search-input" placeholder="Cari nama penduduk...">
                    <button class="btn-edit-data">
                        <i class='bx bx-search'></i> Cari
                    </button>
                </div>
            </div>
        </div>
        
        <table class="data-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Jenis Kelamin</th>
                    <th>Status</th>
                    <th>RW</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['penduduk'] as $penduduk)
                <tr>
                    <td>{{ $penduduk['no'] }}</td>
                    <td>{{ $penduduk['nama'] }}</td>
                    <td>{{ $penduduk['jenis_kelamin'] }}</td>
                    <td>
                        <span class="badge-status {{ $penduduk['status'] == 'Menikah' ? 'badge-menikah' : 'badge-belum' }}">
                            {{ $penduduk['status'] }}
                        </span>
                    </td>
                    <td>{{ $penduduk['rw'] }}</td>
                    <td>
                            <div class="action-buttons">
                                <button class="btn-action btn-edit" onclick="editPenduduk({{ $penduduk['id'] }})">
                                    <i class='bx bx-edit'></i> Edit
                                </button>
                                <button class="btn-action btn-delete" onclick="deletePenduduk({{ $penduduk['id'] }}, '{{ $penduduk['nama'] }}')">
                                    <i class='bx bx-trash'></i> Delete
                                </button>
                            </div>
                        </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Edit Penduduk -->
<div id="editPendudukModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Edit Penduduk</h3>
            <button class="modal-close" onclick="closeEditModal()">&times;</button>
        </div>
        <form id="formEditPenduduk" onsubmit="return updatePenduduk(event)">
            @csrf
            <input type="hidden" id="editPendudukId" name="id">
            <div class="form-group">
                <label for="editNama">Nama Lengkap</label>
                <input type="text" id="editNama" name="nama" required>
            </div>
            <div class="form-group">
                <label for="editJenisKelamin">Jenis Kelamin</label>
                <select id="editJenisKelamin" name="jenis_kelamin" required>
                    <option value="">-- Pilih Jenis Kelamin --</option>
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
            </div>
            <div class="form-group">
                <label for="editStatus">Status Pernikahan</label>
                <select id="editStatus" name="status" required>
                    <option value="">-- Pilih Status --</option>
                    <option value="Menikah">Menikah</option>
                    <option value="Belum Menikah">Belum Menikah</option>
                </select>
            </div>
            <div class="form-group">
                <label for="editRw">RW</label>
                <select id="editRw" name="rw" required>
                    <option value="">-- Pilih RW --</option>
                    @for($i = 1; $i <= 10; $i++)
                        <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}">RW {{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</option>
                    @endfor
                </select>
            </div>
            <div class="form-actions">
                <button type="button" class="btn-cancel" onclick="closeEditModal()">Batal</button>
                <button type="submit" class="btn-submit">
                    <i class='bx bx-save'></i> Update
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Tambah Penduduk -->
<div id="tambahPendudukModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Tambah Penduduk Baru</h3>
            <button class="modal-close" onclick="closeModal()">&times;</button>
        </div>
        <form id="formTambahPenduduk" onsubmit="return submitPenduduk(event)">
            @csrf
            <div class="form-group">
                <label for="nama">Nama Lengkap</label>
                <input type="text" id="nama" name="nama" required>
            </div>
            <div class="form-group">
                <label for="jenis_kelamin">Jenis Kelamin</label>
                <select id="jenis_kelamin" name="jenis_kelamin" required>
                    <option value="">-- Pilih Jenis Kelamin --</option>
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
            </div>
            <div class="form-group">
                <label for="status">Status Pernikahan</label>
                <select id="status" name="status" required>
                    <option value="">-- Pilih Status --</option>
                    <option value="Menikah">Menikah</option>
                    <option value="Belum Menikah">Belum Menikah</option>
                </select>
            </div>
            <div class="form-group">
                <label for="rw">RW</label>
                <select id="rw" name="rw" required>
                    <option value="">-- Pilih RW --</option>
                    @for($i = 1; $i <= 10; $i++)
                        <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}">RW {{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</option>
                    @endfor
                </select>
            </div>
            <div class="form-actions">
                <button type="button" class="btn-cancel" onclick="closeModal()">Batal</button>
                <button type="submit" class="btn-submit">
                    <i class='bx bx-save'></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // ========== 1. REALTIME SEARCH FUNCTIONALITY ==========
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.querySelector('.search-input');
        const tableRows = document.querySelectorAll('.data-table tbody tr');
        
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase().trim();
                
                tableRows.forEach(row => {
                    const namaCell = row.querySelector('td:nth-child(2)');
                    if (namaCell) {
                        const namaText = namaCell.textContent.toLowerCase();
                        if (namaText.includes(searchTerm)) {
                            row.style.display = '';
                            row.style.animation = 'fadeInRow 0.3s ease';
                        } else {
                            row.style.display = 'none';
                        }
                    }
                });
                
                // Show/hide "no results" message
                const visibleRows = Array.from(tableRows).filter(row => row.style.display !== 'none');
                const tableBody = document.querySelector('.data-table tbody');
                let noResultMsg = document.getElementById('no-result-message');
                
                if (visibleRows.length === 0 && searchTerm !== '') {
                    if (!noResultMsg) {
                        noResultMsg = document.createElement('tr');
                        noResultMsg.id = 'no-result-message';
                        noResultMsg.innerHTML = `<td colspan="6" style="text-align: center; padding: 30px; color: #888;">
                            <i class="bx bx-search" style="font-size: 48px; margin-bottom: 10px;"></i><br>
                            Tidak ada data yang cocok dengan "<strong>${searchTerm}</strong>"
                        </td>`;
                        tableBody.appendChild(noResultMsg);
                    }
                    noResultMsg.style.display = '';
                } else if (noResultMsg) {
                    noResultMsg.style.display = 'none';
                }
            });
        }
    });

    // ========== 2. ENHANCED NOTIFICATION SYSTEM ==========
    function showNotification(message, type = 'success') {
        // Remove existing notifications first
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
            font-family: 'Poppins', sans-serif; font-size: 14px;
            display: flex; align-items: center; gap: 12px;
            animation: slideInRight 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            min-width: 280px; max-width: 400px;
        `;
        notification.innerHTML = `
            <i class="bx ${c.icon}" style="font-size: 24px;"></i>
            <span style="font-weight: 500;">${message}</span>
        `;
        
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideInRight { 
                from { transform: translateX(120%); opacity: 0; } 
                to { transform: translateX(0); opacity: 1; } 
            }
            @keyframes fadeInRow {
                from { opacity: 0.5; transform: translateX(-10px); }
                to { opacity: 1; transform: translateX(0); }
            }
        `;
        document.head.appendChild(style);
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.style.transform = 'translateX(120%)';
            notification.style.opacity = '0';
            notification.style.transition = 'all 0.4s ease';
            setTimeout(() => { notification.remove(); style.remove(); }, 400);
        }, 3500);
    }

    // ========== 3. BUTTON FEEDBACK TOASTS ==========
    function showButtonFeedback(btn, message, type = 'info') {
        const originalHTML = btn.innerHTML;
        
        // Show temporary feedback
        btn.innerHTML = `<i class="bx bx-check" style="margin-right: 4px;"></i>${message}`;
        btn.style.transition = 'all 0.3s ease';
        
        setTimeout(() => {
            btn.innerHTML = originalHTML;
        }, 1500);
    }

    // ========== 4. INTERACTIVE TOAST FOR DELETE ==========
    function showDeleteConfirm(id, nama) {
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
                        <strong style="color: #1f2937; font-size: 16px;">"${nama}"</strong>?
                    </p>
                </div>
                <div style="display: flex; gap: 12px; justify-content: center;">
                    <button onclick="closeDeleteModal()" style="flex: 1; padding: 12px 24px; border: none; 
                                border-radius: 10px; background: #f3f4f6; color: #374151; font-weight: 500;
                                cursor: pointer; transition: all 0.2s;">Batal</button>
                    <button onclick="confirmDelete(${id})" style="flex: 1; padding: 12px 24px; border: none; 
                                border-radius: 10px; background: #ef4444; color: white; font-weight: 500;
                                cursor: pointer; transition: all 0.2s;">Ya, Hapus</button>
                </div>
            </div>
        `;
        
        const style = document.createElement('style');
        style.textContent = `
            @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
            @keyframes scaleIn { from { transform: scale(0.9); opacity: 0; } to { transform: scale(1); opacity: 1; } }
        `;
        document.head.appendChild(style);
        modal.onclick = function(e) { if(e.target === modal) closeDeleteModal(); };
        document.body.appendChild(modal);
    }

    function closeDeleteModal() {
        const modal = document.getElementById('delete-confirm-modal');
        if (modal) {
            modal.style.opacity = '0';
            modal.style.transform = 'scale(0.9)';
            setTimeout(() => modal.remove(), 300);
        }
    }

    window.closeDeleteModal = closeDeleteModal;

    function tambahPenduduk() {
        // Tampilkan modal tambah penduduk
        document.getElementById('tambahPendudukModal').style.display = 'block';
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        // Sembunyikan modal
        document.getElementById('tambahPendudukModal').style.display = 'none';
        document.body.style.overflow = 'auto';
        
        // Reset form
        document.getElementById('formTambahPenduduk').reset();
    }

    function submitPenduduk(event) {
        event.preventDefault();
        
        const form = document.getElementById('formTambahPenduduk');
        const formData = new FormData(form);
        
        // Tampilkan loading
        const submitBtn = form.querySelector('.btn-submit');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="bx bx-loader-alt bx-spin"></i> Menyimpan...';
        submitBtn.disabled = true;
        
        // Kirim data ke server
        fetch('/admin/data-kelurahan/store', {
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
                showNotification('Data penduduk berhasil ditambahkan!', 'success');
                closeModal();
                // Reload halaman untuk melihat data terbaru
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            } else {
                showNotification(data.message || 'Terjadi kesalahan saat menyimpan data', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Terjadi kesalahan jaringan. Silakan coba lagi.', 'error');
        })
        .finally(() => {
            // Kembalikan button ke state semula
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        });
    }

    function closeEditModal() {
        // Sembunyikan modal edit
        document.getElementById('editPendudukModal').style.display = 'none';
        document.body.style.overflow = 'auto';
        
        // Reset form
        document.getElementById('formEditPenduduk').reset();
    }

    function editPenduduk(id) {
        // Ambil data penduduk berdasarkan ID database
        const pendudukData = @json($data['penduduk']);
        const penduduk = pendudukData.find(p => p.id === id);
        
        if (penduduk) {
            // Isi form dengan data yang ada
            document.getElementById('editNama').value = penduduk.nama;
            document.getElementById('editJenisKelamin').value = penduduk.jenis_kelamin;
            document.getElementById('editStatus').value = penduduk.status;
            document.getElementById('editRw').value = penduduk.rw;
            
            // Tampilkan modal edit
            document.getElementById('editPendudukModal').style.display = 'block';
            document.body.style.overflow = 'hidden';
            
            // Simpan ID untuk update
            document.getElementById('editPendudukId').value = penduduk.id;
        } else {
            showNotification('Data penduduk tidak ditemukan', 'error');
        }
    }

    function updatePenduduk(event) {
        event.preventDefault();
        
        const form = document.getElementById('formEditPenduduk');
        const id = document.getElementById('editPendudukId').value;
        
        // Ambil data form sebagai object
        const formData = {
            _method: 'PUT',
            _token: form.querySelector('input[name="_token"]').value,
            nama: form.querySelector('#editNama').value,
            jenis_kelamin: form.querySelector('#editJenisKelamin').value,
            status: form.querySelector('#editStatus').value,
            rw: form.querySelector('#editRw').value
        };
        
        // Tampilkan loading
        const submitBtn = form.querySelector('.btn-submit');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="bx bx-loader-alt bx-spin"></i> Mengupdate...';
        submitBtn.disabled = true;
        
        // Kirim data ke server sebagai JSON
        fetch(`/admin/data-kelurahan/update/${id}`, {
            method: 'PUT',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(formData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                showNotification('Data penduduk berhasil diupdate!', 'success');
                closeEditModal();
                // Reload halaman untuk melihat data terbaru
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            } else {
                showNotification(data.message || 'Terjadi kesalahan saat mengupdate data', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Terjadi kesalahan jaringan. Silakan coba lagi.', 'error');
        })
        .finally(() => {
            // Kembalikan button ke state semula
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        });
    }

    // Update window onclick untuk handle kedua modal
    window.onclick = function(event) {
        const tambahModal = document.getElementById('tambahPendudukModal');
        const editModal = document.getElementById('editPendudukModal');
        
        if (event.target === tambahModal) {
            closeModal();
        } else if (event.target === editModal) {
            closeEditModal();
        }
    }

// ========== 5. DELETE FUNCTIONS WITH INTERACTIVE CONFIRM ==========
    function deletePenduduk(id, nama) {
        // Use interactive modal instead of basic confirm
        showDeleteConfirm(id, nama);
    }

    function confirmDelete(id) {
        // Tutup modal konfirmasi
        closeDeleteModal();
        
        // Kirim request delete ke server
        fetch(`/admin/data-kelurahan/delete/${id}`, {
            method: 'DELETE',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                // Hapus baris dari tabel dengan animasi
                const row = document.querySelector(`tr:nth-child(${id + 1})`);
                if (row) {
                    row.style.transition = 'opacity 0.3s, transform 0.3s';
                    row.style.opacity = '0';
                    row.style.transform = 'translateX(-20px)';
                    setTimeout(() => row.remove(), 300);
                }
                
                // Tampilkan notifikasi sukses
                showNotification('🎉 Data penduduk berhasil dihapus!', 'success');
                
                // Reload halaman setelah 1.5 detik untuk update statistik
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            } else {
                showNotification(data.message || 'Terjadi kesalahan saat menghapus data', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Terjadi kesalahan jaringan. Silakan coba lagi.', 'error');
        });
    }

    window.confirmDelete = confirmDelete;

    // ========== 6. BUTTON CLICK FEEDBACK ==========
    // Add nice ripple effect to add button
    document.querySelector('.btn-tambah')?.addEventListener('click', function() {
        this.innerHTML = '<i class="bx bx Loader-alt bx-spin" style="font-size: 18px;"></i> Membuka...';
        setTimeout(() => {
            this.innerHTML = '<i class="bx bx-plus-circle"></i> Tambah Penduduk';
        }, 500);
    });

// Add search feedback
    document.querySelector('.btn-edit-data')?.addEventListener('click', function() {
        const searchInput = document.querySelector('.search-input');
        if (searchInput && searchInput.value.trim() !== '') {
            this.innerHTML = '<i class="bx bx-check"></i> Ditemukan!';
            showNotification(`Mencari: "${searchInput.value}"`, 'info');
            setTimeout(() => {
                this.innerHTML = '<i class="bx bx-search"></i> Cari';
            }, 1500);
        } else {
            showNotification('Mohon masukkan nama yang ingin dicari', 'warning');
        }
    });
</script>
@endpush
@endsection
