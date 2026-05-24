@extends('layouts.admin')

@section('title', 'Informasi Publik - Admin Kelurahan Citangkil')
@section('page-title', 'Kelola Informasi Publik')

@push('styles')
<style>
    .informasi-header-card,
    .informasi-table-container,
    .agenda-admin-card {
        background: #fff;
        border-radius: 12px;
        padding: 25px 30px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.02);
        border: 1px solid #eee;
        margin-bottom: 30px;
    }

    .informasi-header-card {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
    }

    .header-text h4 {
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

    .btn-tambah {
        background: #28a745;
        color: white;
        padding: 10px 18px;
        border: none;
        border-radius: 8px;
        font-size: 14px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s;
        font-weight: 500;
        text-decoration: none;
        white-space: nowrap;
    }

    .btn-tambah:hover {
        background: #218838;
        color: white;
        transform: translateY(-1px);
    }

    .informasi-table {
        width: 100%;
        border-collapse: collapse;
    }

    .informasi-table th {
        background: #f8f9fa;
        padding: 12px 15px;
        text-align: left;
        font-weight: 600;
        color: #333;
        border-bottom: 2px solid #e9ecef;
        font-size: 14px;
    }

    .informasi-table td {
        padding: 12px 15px;
        border-bottom: 1px solid #f1f3f4;
        font-size: 14px;
        color: #555;
        vertical-align: middle;
    }

    .informasi-table tbody tr:hover {
        background: #f8f9fa;
    }

    .action-buttons {
        display: flex;
        gap: 8px;
    }

    .btn-action {
        padding: 7px 10px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 12px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        transition: all 0.2s;
        color: white;
    }

    .btn-edit {
        background: #007bff;
    }

    .btn-edit:hover {
        background: #0056b3;
    }

    .btn-delete {
        background: #dc3545;
    }

    .btn-delete:hover {
        background: #c82333;
    }

    .empty-state {
        text-align: center;
        padding: 35px 15px;
        color: #888;
    }

    .empty-state i {
        display: block;
        font-size: 48px;
        margin-bottom: 12px;
    }

    .agenda-admin-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 20px;
        margin-bottom: 22px;
    }

    .agenda-admin-header h4 {
        font-size: 20px;
        font-weight: 600;
        color: #333;
        margin-bottom: 5px;
    }

    .agenda-admin-header p {
        color: #666;
        font-size: 14px;
        margin: 0;
    }

    .agenda-form-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 18px;
        margin-bottom: 22px;
    }

    .agenda-form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
        color: #333;
    }

    .agenda-form-group input {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 14px;
        transition: border-color 0.2s;
        box-sizing: border-box;
    }

    .agenda-form-group input:focus {
        outline: none;
        border-color: #F6903A;
        box-shadow: 0 0 0 3px rgba(246, 144, 58, 0.1);
    }

    .agenda-time-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 12px;
    }

    .agenda-time-field span {
        display: block;
        color: #666;
        font-size: 12px;
        font-weight: 600;
        margin-bottom: 5px;
    }

    .agenda-form-actions {
        display: flex;
        justify-content: flex-end;
        margin-bottom: 24px;
    }

    .agenda-table {
        width: 100%;
        border-collapse: collapse;
        border-top: 1px solid #f1f3f4;
    }

    .agenda-table th {
        background: #f8f9fa;
        padding: 12px 15px;
        text-align: left;
        font-weight: 600;
        color: #333;
        border-bottom: 2px solid #e9ecef;
        font-size: 14px;
    }

    .agenda-table td {
        padding: 12px 15px;
        border-bottom: 1px solid #f1f3f4;
        font-size: 14px;
        color: #555;
        vertical-align: middle;
    }

    .btn-pdf {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #dc3545;
        color: #fff;
        padding: 7px 10px;
        border-radius: 6px;
        text-decoration: none;
        font-size: 12px;
        font-weight: 500;
    }

    .btn-pdf:hover {
        background: #bd2130;
        color: #fff;
    }

    .info-public-modal {
        display: none;
        position: fixed;
        z-index: 9999;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background: rgba(0,0,0,0.5);
        animation: fadeIn 0.3s;
    }

    .info-public-modal .modal-content-custom {
        background-color: #fefefe;
        margin: 6% auto;
        padding: 0;
        border: 1px solid #888;
        border-radius: 12px;
        width: 620px;
        max-width: 90%;
        box-shadow: 0 4px 20px rgba(0,0,0,0.15);
        animation: slideIn 0.3s;
    }

    .info-public-modal .modal-header-custom {
        background: linear-gradient(135deg, #F6903A, #E57A2A);
        color: white;
        padding: 20px 25px;
        border-radius: 12px 12px 0 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .info-public-modal .modal-header-custom h3 {
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

    .form-group-custom {
        margin-bottom: 20px;
        padding: 0 25px;
    }

    .form-group-custom:first-of-type {
        padding-top: 25px;
    }

    .form-group-custom label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
        color: #333;
    }

    .form-group-custom input,
    .form-group-custom textarea {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 14px;
        transition: border-color 0.2s;
        box-sizing: border-box;
        resize: vertical;
    }

    .form-group-custom input:focus,
    .form-group-custom textarea:focus {
        outline: none;
        border-color: #F6903A;
        box-shadow: 0 0 0 3px rgba(246, 144, 58, 0.1);
    }

    .form-error {
        display: block;
        color: #dc3545;
        font-size: 12px;
        margin-top: 6px;
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
        display: inline-flex;
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

    @media (max-width: 768px) {
        .informasi-header-card {
            flex-direction: column;
            align-items: flex-start;
        }

        .btn-tambah {
            width: 100%;
            justify-content: center;
        }

        .informasi-table-container {
            padding: 15px;
            overflow-x: auto;
        }

        .agenda-admin-card {
            padding: 18px;
        }

        .agenda-admin-header,
        .agenda-form-actions {
            flex-direction: column;
            align-items: stretch;
        }

        .agenda-form-grid {
            grid-template-columns: 1fr;
        }

        .agenda-time-grid {
            grid-template-columns: 1fr;
        }

        .agenda-table th,
        .agenda-table td {
            white-space: nowrap;
        }

        .informasi-table th,
        .informasi-table td {
            white-space: nowrap;
        }

        .info-public-modal .modal-content-custom {
            width: 95%;
            max-width: 95%;
            margin: 5% auto;
        }

        .form-group-custom {
            padding-left: 15px;
            padding-right: 15px;
        }

        .form-actions {
            flex-direction: column;
        }

        .btn-cancel,
        .btn-submit {
            width: 100%;
            justify-content: center;
            min-height: 44px;
        }
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="informasi-header-card">
        <div class="header-text">
            <h4>Informasi Publik</h4>
            <p>Kelola informasi publik yang akan ditampilkan di halaman dashboard</p>
        </div>
        <button type="button" class="btn-tambah" onclick="openCreateModal()">
            <i class='bx bx-plus-circle'></i> Tambah Informasi
        </button>
    </div>

    <div class="informasi-table-container">
        <div class="table-responsive">
            <table class="informasi-table">
                <thead>
                    <tr>
                        <th style="width: 60px;">No</th>
                        <th>Judul</th>
                        <th>Sub Deskripsi</th>
                        <th style="width: 150px;">Dibuat</th>
                        <th style="width: 170px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($informasiPubliks as $index => $item)
                    <tr data-row-id="{{ $item->id }}">
                        <td>{{ $index + 1 }}</td>
                        <td><strong>{{ $item->judul }}</strong></td>
                        <td><span class="text-muted">{{ Str::limit($item->sub_deskripsi, 100) }}</span></td>
                        <td><small class="text-muted">{{ $item->created_at->format('d M Y') }}</small></td>
                        <td>
                            <div class="action-buttons">
                                <button type="button" class="btn-action btn-edit" onclick="openEditModal({{ $item->id }})">
                                    <i class='bx bx-edit'></i> Edit
                                </button>
                                <button type="button" class="btn-action btn-delete" onclick="showDeleteConfirm({{ $item->id }}, @js($item->judul))">
                                    <i class='bx bx-trash'></i> Delete
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5">
                            <div class="empty-state">
                                <i class='bx bx-info-circle'></i>
                                <p>Belum ada data informasi publik</p>
                                <button type="button" class="btn-tambah" onclick="openCreateModal()">
                                    <i class='bx bx-plus-circle'></i> Tambah Informasi
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="agenda-admin-card">
        <div class="agenda-admin-header">
            <div>
                <h4>Jadwal Kegiatan</h4>
                <p>Tambah agenda yang akan tampil pada kalender di halaman informasi publik.</p>
            </div>
            <a href="{{ route('informasi-publik.detail', 4) }}" target="_blank" class="btn-tambah">
                <i class='bx bx-calendar'></i> Lihat Kalender
            </a>
        </div>

        <form action="{{ route('admin.informasi-publik.agenda.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="agenda-form-grid">
                <div class="agenda-form-group">
                    <label for="nama_kegiatan">Nama Kegiatan</label>
                    <input type="text" id="nama_kegiatan" name="nama_kegiatan" value="{{ old('nama_kegiatan') }}" placeholder="Contoh: Musyawarah Kelurahan" required>
                    @error('nama_kegiatan') <span class="form-error">{{ $message }}</span> @enderror
                </div>
                <div class="agenda-form-group">
                    <label for="tanggal_kegiatan">Tanggal Kegiatan</label>
                    <input type="date" id="tanggal_kegiatan" name="tanggal_kegiatan" value="{{ old('tanggal_kegiatan') }}" required>
                    @error('tanggal_kegiatan') <span class="form-error">{{ $message }}</span> @enderror
                </div>
                <div class="agenda-form-group">
                    <label for="tempat_kegiatan">Tempat Kegiatan</label>
                    <input type="text" id="tempat_kegiatan" name="tempat_kegiatan" value="{{ old('tempat_kegiatan') }}" placeholder="Contoh: Aula Kelurahan Citangkil" required>
                    @error('tempat_kegiatan') <span class="form-error">{{ $message }}</span> @enderror
                </div>
                <div class="agenda-form-group">
                    <label for="jam_kegiatan">Jam Kegiatan</label>
                    <div class="agenda-time-grid">
                        <div class="agenda-time-field">
                            <span>Jam Mulai</span>
                            <input type="time" id="jam_mulai" name="jam_mulai" value="{{ old('jam_mulai') }}" required>
                        </div>
                        <div class="agenda-time-field">
                            <span>Jam Selesai</span>
                            <input type="time" id="jam_selesai" name="jam_selesai" value="{{ old('jam_selesai') }}" required>
                        </div>
                    </div>
                    @error('jam_mulai') <span class="form-error">{{ $message }}</span> @enderror
                    @error('jam_selesai') <span class="form-error">{{ $message }}</span> @enderror
                    @error('jam_kegiatan') <span class="form-error">{{ $message }}</span> @enderror
                </div>
                <div class="agenda-form-group">
                    <label for="surat_pendukung">Surat Pendukung Kegiatan (PDF)</label>
                    <input type="file" id="surat_pendukung" name="surat_pendukung" accept="application/pdf,.pdf">
                    @error('surat_pendukung') <span class="form-error">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="agenda-form-actions">
                <button type="submit" class="btn-submit">
                    <i class='bx bx-save'></i> Tambah Jadwal
                </button>
            </div>
        </form>

        <div class="table-responsive">
            <table class="agenda-table">
                <thead>
                    <tr>
                        <th style="width: 60px;">No</th>
                        <th>Nama Kegiatan</th>
                        <th>Tanggal</th>
                        <th>Tempat</th>
                        <th>Jam</th>
                        <th>Surat</th>
                        <th style="width: 100px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse(($agendaKegiatans ?? collect()) as $index => $agenda)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td><strong>{{ $agenda->nama_kegiatan }}</strong></td>
                        <td>{{ $agenda->tanggal_kegiatan->format('d M Y') }}</td>
                        <td>{{ $agenda->tempat_kegiatan }}</td>
                        <td>{{ $agenda->jam_kegiatan }}</td>
                        <td>
                            @if($agenda->surat_pendukung)
                                <a href="{{ asset('storage/' . $agenda->surat_pendukung) }}" target="_blank" class="btn-pdf">
                                    <i class='bx bxs-file-pdf'></i> PDF
                                </a>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            <div class="action-buttons">
                                <button type="button" class="btn-action btn-edit" onclick="openAgendaEditModal({{ $agenda->id }})">
                                    <i class='bx bx-edit'></i> Edit
                                </button>
                                <form action="{{ route('admin.informasi-publik.agenda.destroy', $agenda->id) }}" method="POST" onsubmit="return confirm('Hapus jadwal kegiatan ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action btn-delete">
                                        <i class='bx bx-trash'></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7">
                            <div class="empty-state">
                                <i class='bx bx-calendar-x'></i>
                                <p>Belum ada jadwal kegiatan</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @foreach(($agendaKegiatans ?? collect()) as $agenda)
            @php
                preg_match('/(\d{2}:\d{2})\s*-\s*(\d{2}:\d{2})/', $agenda->jam_kegiatan, $jamMatches);
                $jamMulai = $jamMatches[1] ?? '';
                $jamSelesai = $jamMatches[2] ?? '';
            @endphp
            <div id="agendaEditModal{{ $agenda->id }}" class="info-public-modal">
                <div class="modal-content-custom">
                    <div class="modal-header-custom">
                        <h3>Edit Jadwal Kegiatan</h3>
                        <button type="button" class="modal-close" onclick="closeAgendaEditModal({{ $agenda->id }})">&times;</button>
                    </div>
                    <form action="{{ route('admin.informasi-publik.agenda.update', $agenda->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group-custom">
                            <label for="edit_agenda_nama_{{ $agenda->id }}">Nama Kegiatan</label>
                            <input type="text" id="edit_agenda_nama_{{ $agenda->id }}" name="nama_kegiatan" value="{{ old('nama_kegiatan', $agenda->nama_kegiatan) }}" required>
                        </div>
                        <div class="form-group-custom">
                            <label for="edit_agenda_tanggal_{{ $agenda->id }}">Tanggal Kegiatan</label>
                            <input type="date" id="edit_agenda_tanggal_{{ $agenda->id }}" name="tanggal_kegiatan" value="{{ old('tanggal_kegiatan', $agenda->tanggal_kegiatan->format('Y-m-d')) }}" required>
                        </div>
                        <div class="form-group-custom">
                            <label for="edit_agenda_tempat_{{ $agenda->id }}">Tempat Kegiatan</label>
                            <input type="text" id="edit_agenda_tempat_{{ $agenda->id }}" name="tempat_kegiatan" value="{{ old('tempat_kegiatan', $agenda->tempat_kegiatan) }}" required>
                        </div>
                        <div class="form-group-custom">
                            <label>Jam Kegiatan</label>
                            <div class="agenda-time-grid">
                                <div class="agenda-time-field">
                                    <span>Jam Mulai</span>
                                    <input type="time" name="jam_mulai" value="{{ old('jam_mulai', $jamMulai) }}" required>
                                </div>
                                <div class="agenda-time-field">
                                    <span>Jam Selesai</span>
                                    <input type="time" name="jam_selesai" value="{{ old('jam_selesai', $jamSelesai) }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group-custom">
                            <label for="edit_agenda_surat_{{ $agenda->id }}">Ganti Surat Pendukung Kegiatan (PDF)</label>
                            <input type="file" id="edit_agenda_surat_{{ $agenda->id }}" name="surat_pendukung" accept="application/pdf,.pdf">
                            @if($agenda->surat_pendukung)
                                <small class="text-muted d-block mt-2">PDF saat ini: {{ basename($agenda->surat_pendukung) }}</small>
                            @endif
                        </div>
                        <div class="form-actions">
                            <button type="button" class="btn-cancel" onclick="closeAgendaEditModal({{ $agenda->id }})">Batal</button>
                            <button type="submit" class="btn-submit">
                                <i class='bx bx-save'></i> Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
</div>

<div id="informasiCreateModal" class="info-public-modal">
    <div class="modal-content-custom">
        <div class="modal-header-custom">
            <h3>Tambah Informasi Publik</h3>
            <button type="button" class="modal-close" onclick="closeCreateModal()">&times;</button>
        </div>
        <form id="createInformasiForm" onsubmit="return submitInformasi(event)">
            @csrf
            <div class="form-group-custom">
                <label for="createJudul">Judul</label>
                <input type="text" id="createJudul" name="judul" placeholder="Masukkan judul informasi" required>
                <span class="form-error" data-error-for="create-judul"></span>
            </div>
            <div class="form-group-custom">
                <label for="createSubDeskripsi">Sub Deskripsi</label>
                <input type="text" id="createSubDeskripsi" name="sub_deskripsi" placeholder="Masukkan sub deskripsi singkat" required>
                <span class="form-error" data-error-for="create-sub_deskripsi"></span>
            </div>
            <div class="form-group-custom">
                <label for="createDeskripsi">Deskripsi Lengkap</label>
                <textarea id="createDeskripsi" name="deskripsi" rows="6" placeholder="Masukkan deskripsi lengkap informasi" required></textarea>
                <span class="form-error" data-error-for="create-deskripsi"></span>
            </div>
            <div class="form-actions">
                <button type="button" class="btn-cancel" onclick="closeCreateModal()">Batal</button>
                <button type="submit" class="btn-submit">
                    <i class='bx bx-save'></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<div id="informasiEditModal" class="info-public-modal">
    <div class="modal-content-custom">
        <div class="modal-header-custom">
            <h3>Edit Informasi Publik</h3>
            <button type="button" class="modal-close" onclick="closeEditModal()">&times;</button>
        </div>
        <form id="editInformasiForm" onsubmit="return updateInformasi(event)">
            @csrf
            <input type="hidden" id="editInformasiId" name="id">
            <div class="form-group-custom">
                <label for="editJudul">Judul</label>
                <input type="text" id="editJudul" name="judul" required>
                <span class="form-error" data-error-for="edit-judul"></span>
            </div>
            <div class="form-group-custom">
                <label for="editSubDeskripsi">Sub Deskripsi</label>
                <input type="text" id="editSubDeskripsi" name="sub_deskripsi" required>
                <span class="form-error" data-error-for="edit-sub_deskripsi"></span>
            </div>
            <div class="form-group-custom">
                <label for="editDeskripsi">Deskripsi Lengkap</label>
                <textarea id="editDeskripsi" name="deskripsi" rows="6" required></textarea>
                <span class="form-error" data-error-for="edit-deskripsi"></span>
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
@endsection

@push('scripts')
<script>
    const informasiPubliks = @json($informasiPubliks->values());
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

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

    function clearErrors(prefix) {
        document.querySelectorAll(`[data-error-for^="${prefix}-"]`).forEach(el => {
            el.textContent = '';
        });
    }

    function showErrors(prefix, errors) {
        clearErrors(prefix);
        Object.keys(errors || {}).forEach(field => {
            const errorEl = document.querySelector(`[data-error-for="${prefix}-${field}"]`);
            if (errorEl) {
                errorEl.textContent = errors[field][0];
            }
        });
    }

    function setButtonLoading(button, isLoading, loadingText) {
        if (!button.dataset.originalHtml) {
            button.dataset.originalHtml = button.innerHTML;
        }

        button.innerHTML = isLoading
            ? `<i class="bx bx-loader-alt bx-spin"></i> ${loadingText}`
            : button.dataset.originalHtml;
        button.disabled = isLoading;
    }

    function openCreateModal() {
        clearErrors('create');
        document.getElementById('createInformasiForm').reset();
        document.getElementById('informasiCreateModal').style.display = 'block';
        document.body.style.overflow = 'hidden';
    }

    function closeCreateModal() {
        document.getElementById('informasiCreateModal').style.display = 'none';
        document.body.style.overflow = 'auto';
        document.getElementById('createInformasiForm').reset();
        clearErrors('create');
    }

    function openEditModal(id) {
        const informasi = informasiPubliks.find(item => Number(item.id) === Number(id));

        if (!informasi) {
            showNotification('Data informasi publik tidak ditemukan', 'error');
            return;
        }

        clearErrors('edit');
        document.getElementById('editInformasiId').value = informasi.id;
        document.getElementById('editJudul').value = informasi.judul;
        document.getElementById('editSubDeskripsi').value = informasi.sub_deskripsi;
        document.getElementById('editDeskripsi').value = informasi.deskripsi;
        document.getElementById('informasiEditModal').style.display = 'block';
        document.body.style.overflow = 'hidden';
    }

    function closeEditModal() {
        document.getElementById('informasiEditModal').style.display = 'none';
        document.body.style.overflow = 'auto';
        document.getElementById('editInformasiForm').reset();
        clearErrors('edit');
    }

    function openAgendaEditModal(id) {
        const modal = document.getElementById(`agendaEditModal${id}`);
        if (!modal) {
            showNotification('Data jadwal kegiatan tidak ditemukan', 'error');
            return;
        }

        modal.style.display = 'block';
        document.body.style.overflow = 'hidden';
    }

    function closeAgendaEditModal(id) {
        const modal = document.getElementById(`agendaEditModal${id}`);
        if (!modal) {
            return;
        }

        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
    }

    function submitInformasi(event) {
        event.preventDefault();

        const form = document.getElementById('createInformasiForm');
        const submitBtn = form.querySelector('.btn-submit');
        setButtonLoading(submitBtn, true, 'Menyimpan...');

        fetch('{{ route('admin.informasi-publik.store') }}', {
            method: 'POST',
            body: new FormData(form),
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(async response => {
            const data = await response.json();
            if (!response.ok) {
                throw data;
            }
            return data;
        })
        .then(data => {
            showNotification(data.message || 'Informasi publik berhasil ditambahkan!', 'success');
            closeCreateModal();
            setTimeout(() => window.location.reload(), 1200);
        })
        .catch(error => {
            if (error.errors) {
                showErrors('create', error.errors);
                showNotification('Periksa kembali data yang diisi.', 'warning');
                return;
            }
            showNotification(error.message || 'Terjadi kesalahan saat menyimpan data.', 'error');
        })
        .finally(() => setButtonLoading(submitBtn, false, ''));

        return false;
    }

    function updateInformasi(event) {
        event.preventDefault();

        const form = document.getElementById('editInformasiForm');
        const id = document.getElementById('editInformasiId').value;
        const formData = new FormData(form);
        formData.append('_method', 'PUT');

        const submitBtn = form.querySelector('.btn-submit');
        setButtonLoading(submitBtn, true, 'Mengupdate...');

        fetch(`/admin/informasi-publik/${id}`, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(async response => {
            const data = await response.json();
            if (!response.ok) {
                throw data;
            }
            return data;
        })
        .then(data => {
            showNotification(data.message || 'Informasi publik berhasil diperbarui!', 'success');
            closeEditModal();
            setTimeout(() => window.location.reload(), 1200);
        })
        .catch(error => {
            if (error.errors) {
                showErrors('edit', error.errors);
                showNotification('Periksa kembali data yang diisi.', 'warning');
                return;
            }
            showNotification(error.message || 'Terjadi kesalahan saat mengupdate data.', 'error');
        })
        .finally(() => setButtonLoading(submitBtn, false, ''));

        return false;
    }

    function showDeleteConfirm(id, judul) {
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
                        <strong style="color: #1f2937; font-size: 16px;">"${escapeHtml(judul)}"</strong>?
                    </p>
                </div>
                <div style="display: flex; gap: 12px; justify-content: center;">
                    <button type="button" data-delete-cancel style="flex: 1; padding: 12px 24px; border: none;
                                border-radius: 10px; background: #f3f4f6; color: #374151; font-weight: 500;
                                cursor: pointer; transition: all 0.2s;">Batal</button>
                    <button type="button" data-delete-confirm style="flex: 1; padding: 12px 24px; border: none;
                                border-radius: 10px; background: #ef4444; color: white; font-weight: 500;
                                cursor: pointer; transition: all 0.2s;">Ya, Hapus</button>
                </div>
            </div>
        `;

        const style = document.createElement('style');
        style.textContent = `
            @keyframes scaleIn { from { transform: scale(0.9); opacity: 0; } to { transform: scale(1); opacity: 1; } }
        `;
        document.head.appendChild(style);

        function closeDeleteModal() {
            modal.style.opacity = '0';
            modal.style.transform = 'scale(0.9)';
            setTimeout(() => {
                modal.remove();
                style.remove();
            }, 300);
        }

        modal.addEventListener('click', function(e) {
            if (e.target === modal || e.target.closest('[data-delete-cancel]')) {
                closeDeleteModal();
                return;
            }

            const confirmBtn = e.target.closest('[data-delete-confirm]');
            if (confirmBtn) {
                confirmBtn.innerHTML = '<i class="bx bx-loader-alt bx-spin"></i> Menghapus...';
                confirmBtn.disabled = true;
                deleteInformasi(id, closeDeleteModal);
            }
        });

        document.body.appendChild(modal);
    }

    function deleteInformasi(id, closeDeleteModal) {
        fetch(`/admin/informasi-publik/${id}`, {
            method: 'DELETE',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            }
        })
        .then(async response => {
            const data = await response.json();
            if (!response.ok) {
                throw data;
            }
            return data;
        })
        .then(data => {
            closeDeleteModal();
            const row = document.querySelector(`tr[data-row-id="${id}"]`);
            if (row) {
                row.style.transition = 'opacity 0.3s, transform 0.3s';
                row.style.opacity = '0';
                row.style.transform = 'translateX(-20px)';
            }
            showNotification(data.message || 'Informasi publik berhasil dihapus!', 'success');
            setTimeout(() => window.location.reload(), 1200);
        })
        .catch(error => {
            showNotification(error.message || 'Terjadi kesalahan saat menghapus data.', 'error');
        });
    }

    function escapeHtml(value) {
        const div = document.createElement('div');
        div.textContent = value;
        return div.innerHTML;
    }

    window.addEventListener('click', function(event) {
        const createModal = document.getElementById('informasiCreateModal');
        const editModal = document.getElementById('informasiEditModal');

        if (event.target === createModal) {
            closeCreateModal();
        } else if (event.target === editModal) {
            closeEditModal();
        } else if (event.target.classList.contains('info-public-modal') && event.target.id.startsWith('agendaEditModal')) {
            event.target.style.display = 'none';
            document.body.style.overflow = 'auto';
        }
    });

    @if(session('success'))
        document.addEventListener('DOMContentLoaded', () => showNotification(@js(session('success')), 'success'));
    @endif

    @if(session('error'))
        document.addEventListener('DOMContentLoaded', () => showNotification(@js(session('error')), 'error'));
    @endif
</script>
@endpush
