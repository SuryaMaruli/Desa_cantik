@php
    $agendaItems = collect($agendaKegiatans ?? [])->map(function ($agenda) {
        return [
            'id' => $agenda->id,
            'nama_kegiatan' => $agenda->nama_kegiatan,
            'tanggal_kegiatan' => $agenda->tanggal_kegiatan->format('Y-m-d'),
            'tempat_kegiatan' => $agenda->tempat_kegiatan,
            'jam_kegiatan' => $agenda->jam_kegiatan,
            'keterangan' => $agenda->keterangan,
            'surat_pendukung' => $agenda->surat_pendukung,
        ];
    })->values();
@endphp

<style>
    .home-agenda-section { padding: 64px 20px 84px; background: #ffffff; }
    .home-agenda-header { text-align: center; margin-bottom: 30px; }
    .home-agenda-header h2 { color: #e65100; font-size: 2rem; font-weight: 600; margin-bottom: 10px; text-transform: uppercase; }
    .home-agenda-header p { color: #666; font-size: 1rem; margin: 0; }
    .home-agenda-wrap { max-width: 1080px; margin: 0 auto; display: grid; grid-template-columns: minmax(0, 1.1fr) minmax(300px, 0.9fr); gap: 24px; align-items: start; }
    .home-calendar-panel,
    .home-agenda-detail { background: #fff; border: 1px solid #eceff3; border-radius: 12px; box-shadow: 0 10px 24px rgba(31, 41, 55, 0.06); overflow: hidden; }
    .home-calendar-toolbar { display: flex; justify-content: space-between; align-items: center; gap: 16px; padding: 18px 20px; border-bottom: 1px solid #eef1f5; }
    .home-calendar-title { font-size: 1.15rem; font-weight: 700; color: #243042; margin: 0; }
    .home-calendar-nav { display: inline-flex; gap: 8px; }
    .home-calendar-nav button { width: 38px; height: 38px; border-radius: 8px; color: #475569; border: 1px solid #e2e8f0; background: transparent; cursor: pointer; transition: all 0.2s ease; }
    .home-calendar-nav button:hover { color: #fff; background: #F6903A; border-color: #F6903A; }
    .home-calendar-grid { display: grid; grid-template-columns: repeat(7, minmax(0, 1fr)); gap: 8px; padding: 18px 20px 22px; }
    .home-calendar-weekday { color: #64748b; font-size: 0.8rem; font-weight: 700; text-align: center; padding: 6px 0; }
    .home-calendar-day { min-height: 66px; border-radius: 10px; border: 1px solid #edf1f5; color: #334155; background: #fbfcfe; display: flex; flex-direction: column; justify-content: space-between; align-items: flex-start; padding: 9px; text-align: left; transition: all 0.2s ease; cursor: pointer; }
    .home-calendar-day:hover { border-color: #F6903A; box-shadow: 0 8px 18px rgba(246, 144, 58, 0.12); transform: translateY(-1px); }
    .home-calendar-day.is-empty { visibility: hidden; pointer-events: none; }
    .home-calendar-day.is-past { opacity: 0.65; background: #f1f5f9; }
    .home-calendar-day.is-past.has-agenda { opacity: 0.9; }
    .home-calendar-day.is-past:hover { border-color: #cbd5e1; box-shadow: 0 8px 18px rgba(100, 116, 139, 0.1); transform: translateY(-1px); }
    .home-calendar-day.is-today { border-color: #94a3b8; background: #f8fafc; }
    .home-calendar-day.has-agenda { background: #fff7ed; border-color: #fed7aa; }
    .home-calendar-day.is-selected { background: #F6903A; border-color: #F6903A; color: #fff; }
    .home-calendar-number { font-weight: 700; line-height: 1; }
    .home-agenda-count { min-width: 22px; height: 22px; border-radius: 999px; background: #fff; color: #C2410C; border: 1px solid #fed7aa; display: inline-flex; align-items: center; justify-content: center; font-size: 0.75rem; font-weight: 700; }
    .home-calendar-day.is-selected .home-agenda-count { color: #F6903A; border-color: #fff; }
    .home-agenda-detail-header { padding: 20px; border-bottom: 1px solid #eef1f5; }
    .home-agenda-detail-header span { display: inline-flex; align-items: center; gap: 8px; color: #F6903A; font-weight: 700; font-size: 0.9rem; margin-bottom: 8px; }
    .home-agenda-detail-header h3 { margin: 0; color: #243042; font-size: 1.25rem; font-weight: 700; }
    .home-agenda-list { display: grid; gap: 14px; padding: 20px; }
    .home-agenda-card { border: 1px solid #edf1f5; border-radius: 10px; padding: 18px; background: #fff; }
    .home-agenda-card h4 { color: #243042; font-size: 1.05rem; font-weight: 700; margin-bottom: 14px; }
    .home-agenda-info { display: grid; gap: 10px; margin-bottom: 16px; }
    .home-agenda-info-item { display: grid; grid-template-columns: 26px minmax(0, 1fr); gap: 10px; align-items: start; color: #475569; font-size: 0.95rem; }
    .home-agenda-info-item i { color: #F6903A; margin-top: 3px; }
    .home-agenda-pdf { display: inline-flex; align-items: center; justify-content: center; gap: 8px; padding: 10px 14px; border-radius: 8px; background: #dc2626; color: #fff; font-weight: 700; transition: all 0.2s ease; }
    .home-agenda-pdf:hover { background: #b91c1c; color: #fff; transform: translateY(-1px); }
    .home-agenda-card-actions { display: flex; flex-wrap: wrap; gap: 8px; margin-top: 14px; }
    .home-agenda-action { display: inline-flex; align-items: center; justify-content: center; gap: 7px; border: 0; border-radius: 8px; padding: 9px 12px; color: #fff; font-weight: 700; font-size: 0.85rem; cursor: pointer; }
    .home-agenda-action.edit { background: #2563eb; }
    .home-agenda-action.delete { background: #dc2626; }
    .home-agenda-modal-overlay { position: fixed; inset: 0; background: rgba(0, 0, 0, 0.5); z-index: 9999; display: flex; align-items: center; justify-content: center; padding: 18px; animation: homeAgendaFadeIn 0.3s ease; }
    .home-agenda-modal-content { background: #fff; border-radius: 16px; width: min(640px, 95vw); max-height: 92vh; overflow-y: auto; box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3); animation: homeAgendaScaleIn 0.3s ease; }
    .home-agenda-modal-header { background: linear-gradient(135deg, #F6903A, #E57A2A); color: #fff; padding: 18px 22px; border-radius: 16px 16px 0 0; display: flex; align-items: center; justify-content: space-between; gap: 16px; }
    .home-agenda-modal-header h3 { margin: 0; font-size: 1.1rem; font-weight: 700; }
    .home-agenda-modal-close { width: 32px; height: 32px; border: 0; border-radius: 50%; background: transparent; color: #fff; font-size: 1.4rem; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; }
    .home-agenda-modal-close:hover { background: rgba(255, 255, 255, 0.2); }
    .home-agenda-modal-body { padding: 22px; }
    .home-agenda-form-grid { display: grid; grid-template-columns: 1fr; gap: 14px; }
    .home-agenda-field label { display: block; color: #475569; font-size: 0.9rem; font-weight: 700; margin-bottom: 7px; }
    .home-agenda-field input, .home-agenda-field textarea { width: 100%; border: 1px solid #e2e8f0; border-radius: 8px; padding: 11px 12px; font-size: 0.95rem; }
    .home-agenda-field textarea { min-height: 86px; resize: vertical; }
    .home-agenda-field input:focus, .home-agenda-field textarea:focus { outline: none; border-color: #F6903A; box-shadow: 0 0 0 3px rgba(246, 144, 58, 0.12); }
    .home-agenda-time-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 12px; }
    .home-agenda-time-field span { display: block; color: #64748b; font-size: 0.78rem; font-weight: 700; margin-bottom: 5px; }
    .home-agenda-form-actions { display: flex; justify-content: flex-end; margin-top: 16px; }
    .home-agenda-submit { display: inline-flex; align-items: center; gap: 8px; border: 0; border-radius: 8px; background: #F6903A; color: #fff; padding: 11px 16px; font-weight: 700; cursor: pointer; }
    .home-agenda-submit:hover { background: #E57A2A; }
    .home-agenda-empty { padding: 28px 20px; color: #64748b; text-align: center; }
    .home-agenda-empty i { color: #cbd5e1; font-size: 2rem; margin-bottom: 12px; }
    @keyframes homeAgendaFadeIn { from { opacity: 0; } to { opacity: 1; } }
    @keyframes homeAgendaScaleIn { from { transform: scale(0.9); opacity: 0; } to { transform: scale(1); opacity: 1; } }
    @keyframes homeAgendaSlideInRight { from { transform: translateX(120%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }

    @media (max-width: 768px) {
        .home-agenda-wrap { grid-template-columns: 1fr; }
        .home-calendar-toolbar { align-items: flex-start; flex-direction: column; }
        .home-calendar-grid { gap: 6px; padding: 14px; }
        .home-calendar-day { min-height: 52px; padding: 7px; }
        .home-agenda-time-grid { grid-template-columns: 1fr; }
        .home-agenda-form-actions { justify-content: stretch; }
        .home-agenda-submit { width: 100%; justify-content: center; }
    }
</style>

<section class="home-agenda-section" id="agenda-kegiatan">
    <div class="home-agenda-header">
        <h2>Agenda Kegiatan</h2>
        <p>Jadwal kegiatan dan acara Kelurahan Gunung Sugih.</p>
    </div>

    <div class="home-agenda-wrap" data-home-agenda-calendar>
        <div class="home-calendar-panel">
            <div class="home-calendar-toolbar">
                <h3 class="home-calendar-title" data-home-calendar-title></h3>
                <div class="home-calendar-nav">
                    <button type="button" data-home-calendar-prev aria-label="Bulan sebelumnya" title="Bulan sebelumnya"><i class="fas fa-chevron-left"></i></button>
                    <button type="button" data-home-calendar-next aria-label="Bulan berikutnya" title="Bulan berikutnya"><i class="fas fa-chevron-right"></i></button>
                </div>
            </div>
            <div class="home-calendar-grid" data-home-calendar-grid></div>
        </div>

        <aside class="home-agenda-detail">
            <div class="home-agenda-detail-header">
                <span><i class="fas fa-calendar-day"></i> Detail Kegiatan</span>
                <h3 data-home-selected-date></h3>
            </div>
            <div class="home-agenda-list" data-home-agenda-detail></div>
        </aside>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const root = document.querySelector('[data-home-agenda-calendar]');
        if (!root) return;

        const agendaItems = @json($agendaItems);
        const canManageAgenda = @json(auth()->check() && in_array(auth()->user()->role, ['admin', 'super_admin']));
        const csrfToken = @json(csrf_token());
        const titleElement = root.querySelector('[data-home-calendar-title]');
        const gridElement = root.querySelector('[data-home-calendar-grid]');
        const detailElement = root.querySelector('[data-home-agenda-detail]');
        const selectedDateElement = root.querySelector('[data-home-selected-date]');
        const prevButton = root.querySelector('[data-home-calendar-prev]');
        const nextButton = root.querySelector('[data-home-calendar-next]');
        const monthNames = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        const weekdayNames = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];
        const todayKey = formatDateKey(new Date());
        const firstAgendaDate = agendaItems.length ? new Date(agendaItems[0].tanggal_kegiatan + 'T00:00:00') : new Date();
        let currentMonth = new Date(firstAgendaDate.getFullYear(), firstAgendaDate.getMonth(), 1);
        let selectedDateKey = agendaItems.length ? agendaItems[0].tanggal_kegiatan : todayKey;

        const agendaByDate = agendaItems.reduce(function (grouped, item) {
            if (!grouped[item.tanggal_kegiatan]) grouped[item.tanggal_kegiatan] = [];
            grouped[item.tanggal_kegiatan].push(item);
            return grouped;
        }, {});

        function formatDateKey(date) {
            return date.getFullYear() + '-' + String(date.getMonth() + 1).padStart(2, '0') + '-' + String(date.getDate()).padStart(2, '0');
        }

        function formatDisplayDate(dateKey) {
            const date = new Date(dateKey + 'T00:00:00');
            return date.getDate() + ' ' + monthNames[date.getMonth()] + ' ' + date.getFullYear();
        }

        function escapeHtml(value) {
            const div = document.createElement('div');
            div.textContent = value || '';
            return div.innerHTML;
        }

        function renderCalendar() {
            const year = currentMonth.getFullYear();
            const month = currentMonth.getMonth();
            const firstDay = new Date(year, month, 1);
            const lastDay = new Date(year, month + 1, 0);
            titleElement.textContent = monthNames[month] + ' ' + year;
            gridElement.innerHTML = '';

            weekdayNames.forEach(function (weekday) {
                const el = document.createElement('div');
                el.className = 'home-calendar-weekday';
                el.textContent = weekday;
                gridElement.appendChild(el);
            });

            for (let i = 0; i < firstDay.getDay(); i++) {
                const empty = document.createElement('div');
                empty.className = 'home-calendar-day is-empty';
                gridElement.appendChild(empty);
            }

            for (let day = 1; day <= lastDay.getDate(); day++) {
                const date = new Date(year, month, day);
                const dateKey = formatDateKey(date);
                const dayAgendas = agendaByDate[dateKey] || [];
                const button = document.createElement('button');
                button.type = 'button';
                button.className = 'home-calendar-day';
                if (dateKey === todayKey) button.classList.add('is-today');
                if (dateKey < todayKey) button.classList.add('is-past');
                if (dateKey === selectedDateKey) button.classList.add('is-selected');
                if (dayAgendas.length) button.classList.add('has-agenda');
                button.innerHTML = '<span class="home-calendar-number">' + day + '</span>' + (dayAgendas.length ? '<span class="home-agenda-count">' + dayAgendas.length + '</span>' : '');
                button.addEventListener('click', function () {
                    selectedDateKey = dateKey;
                    renderCalendar();
                    renderDetail();
                    if (canManageAgenda && dateKey >= todayKey) {
                        openAddAgendaModal(dateKey);
                    }
                });
                gridElement.appendChild(button);
            }
        }

        function renderDetail() {
            const selectedAgendas = agendaByDate[selectedDateKey] || [];
            selectedDateElement.textContent = formatDisplayDate(selectedDateKey);
            if (!selectedAgendas.length) {
                detailElement.innerHTML = '<div class="home-agenda-empty"><i class="fas fa-calendar-xmark d-block"></i><p class="mb-0">Belum ada kegiatan pada tanggal ini.</p></div>';
                return;
            }

            detailElement.innerHTML = selectedAgendas.map(function (item) {
                const pdfUrl = item.surat_pendukung ? '{{ url('/storage') }}/' + item.surat_pendukung : '';
                const keteranganMarkup = item.keterangan ? '<div class="home-agenda-info-item"><i class="fas fa-align-left"></i><span>' + escapeHtml(item.keterangan) + '</span></div>' : '';
                const manageMarkup = canManageAgenda ? renderManageMarkup(item) : '';
                return '<article class="home-agenda-card">' +
                    '<h4>' + escapeHtml(item.nama_kegiatan) + '</h4>' +
                    '<div class="home-agenda-info">' +
                    '<div class="home-agenda-info-item"><i class="fas fa-calendar-alt"></i><span>' + formatDisplayDate(item.tanggal_kegiatan) + '</span></div>' +
                    '<div class="home-agenda-info-item"><i class="fas fa-map-marker-alt"></i><span>' + escapeHtml(item.tempat_kegiatan) + '</span></div>' +
                    '<div class="home-agenda-info-item"><i class="fas fa-clock"></i><span>' + escapeHtml(item.jam_kegiatan) + '</span></div>' +
                    keteranganMarkup +
                    '</div>' +
                    (pdfUrl ? '<a class="home-agenda-pdf" href="' + pdfUrl + '" target="_blank" rel="noopener"><i class="fas fa-file-pdf"></i> Surat Pendukung PDF</a>' : '<span class="text-muted">Surat pendukung belum tersedia.</span>') +
                    manageMarkup +
                    '</article>';
            }).join('');
        }

        function renderManageMarkup(item) {
            return '<div class="home-agenda-card-actions">' +
                '<button type="button" class="home-agenda-action edit" data-home-edit-agenda="' + item.id + '"><i class="fas fa-pen"></i> Edit</button>' +
                '<button type="button" class="home-agenda-action delete" data-home-delete-agenda="' + item.id + '"><i class="fas fa-trash"></i> Hapus</button>' +
                '</div>';
        }

        function parseTimeRange(value) {
            const match = String(value || '').match(/(\d{2}:\d{2})\s*-\s*(\d{2}:\d{2})/);
            return {
                start: match ? match[1] : '',
                end: match ? match[2] : '',
            };
        }

        function escapeAttribute(value) {
            return escapeHtml(value).replace(/"/g, '&quot;');
        }

        function openAddAgendaModal(dateKey) {
            if (dateKey < todayKey) {
                showNotification('Kegiatan tidak bisa dijadwalkan pada tanggal sebelum hari ini.', 'warning');
                return;
            }

            closeAgendaModal();
            const modal = document.createElement('div');
            modal.className = 'home-agenda-modal-overlay';
            modal.id = 'home-agenda-action-modal';
            modal.innerHTML =
                '<div class="home-agenda-modal-content">' +
                '<div class="home-agenda-modal-header">' +
                '<h3>Tambah Jadwal Kegiatan</h3>' +
                '<button type="button" class="home-agenda-modal-close" data-home-close-agenda-modal>&times;</button>' +
                '</div>' +
                '<div class="home-agenda-modal-body">' +
                '<form action="{{ route('admin.informasi-publik.agenda.store') }}" method="POST" enctype="multipart/form-data" data-home-add-agenda-form>' +
                '<input type="hidden" name="_token" value="' + csrfToken + '">' +
                '<div class="home-agenda-form-grid">' +
                '<div class="home-agenda-field"><label>Tanggal Kegiatan</label><input type="date" name="tanggal_kegiatan" value="' + escapeAttribute(dateKey) + '" readonly required></div>' +
                '<div class="home-agenda-field"><label>Nama Kegiatan</label><input type="text" name="nama_kegiatan" required></div>' +
                '<div class="home-agenda-field"><label>Tempat Kegiatan</label><input type="text" name="tempat_kegiatan" required></div>' +
                '<div class="home-agenda-field"><label>Keterangan <small style="color:#94a3b8;font-weight:600;">(opsional)</small></label><textarea name="keterangan" placeholder="Tambahkan catatan kegiatan jika diperlukan"></textarea></div>' +
                '<div class="home-agenda-field"><label>Jam Kegiatan</label><div class="home-agenda-time-grid">' +
                '<div class="home-agenda-time-field"><span>Jam Mulai</span><input type="time" name="jam_mulai" required></div>' +
                '<div class="home-agenda-time-field"><span>Jam Selesai</span><input type="time" name="jam_selesai" required></div>' +
                '</div></div>' +
                '<div class="home-agenda-field"><label>Surat Pendukung Kegiatan (PDF)</label><input type="file" name="surat_pendukung" accept="application/pdf,.pdf"></div>' +
                '</div>' +
                '<div class="home-agenda-form-actions"><button type="submit" class="home-agenda-submit"><i class="fas fa-save"></i> Simpan Jadwal</button></div>' +
                '</form>' +
                '</div>' +
                '</div>';

            bindModalClose(modal);
            modal.querySelector('[data-home-add-agenda-form]').addEventListener('submit', function (event) {
                event.preventDefault();
                submitAgendaForm(event.currentTarget, 'Menyimpan...', 'Jadwal kegiatan berhasil ditambahkan!');
            });
            document.body.appendChild(modal);
            document.body.style.overflow = 'hidden';
        }

        function openEditAgendaModal(item) {
            closeAgendaModal();
            const timeRange = parseTimeRange(item.jam_kegiatan);
            const updateUrl = '{{ url('/admin/informasi-publik/agenda') }}/' + item.id;
            const modal = document.createElement('div');
            modal.className = 'home-agenda-modal-overlay';
            modal.id = 'home-agenda-action-modal';
            modal.innerHTML =
                '<div class="home-agenda-modal-content">' +
                '<div class="home-agenda-modal-header">' +
                '<h3>Edit Jadwal Kegiatan</h3>' +
                '<button type="button" class="home-agenda-modal-close" data-home-close-agenda-modal>&times;</button>' +
                '</div>' +
                '<div class="home-agenda-modal-body">' +
                '<form action="' + updateUrl + '" method="POST" enctype="multipart/form-data" data-home-edit-agenda-form>' +
                '<input type="hidden" name="_token" value="' + csrfToken + '">' +
                '<input type="hidden" name="_method" value="PUT">' +
                '<div class="home-agenda-form-grid">' +
                '<div class="home-agenda-field"><label>Tanggal Kegiatan</label><input type="date" name="tanggal_kegiatan" value="' + escapeAttribute(item.tanggal_kegiatan) + '" min="' + todayKey + '" required><small style="display:block;margin-top:6px;color:#64748b;font-size:12px;line-height:1.35;">Ubah tanggal ini untuk memindahkan kegiatan.</small></div>' +
                '<div class="home-agenda-field"><label>Nama Kegiatan</label><input type="text" name="nama_kegiatan" value="' + escapeAttribute(item.nama_kegiatan) + '" required></div>' +
                '<div class="home-agenda-field"><label>Tempat Kegiatan</label><input type="text" name="tempat_kegiatan" value="' + escapeAttribute(item.tempat_kegiatan) + '" required></div>' +
                '<div class="home-agenda-field"><label>Keterangan <small style="color:#94a3b8;font-weight:600;">(opsional)</small></label><textarea name="keterangan" placeholder="Tambahkan catatan kegiatan jika diperlukan">' + escapeHtml(item.keterangan || '') + '</textarea></div>' +
                '<div class="home-agenda-field"><label>Jam Kegiatan</label><div class="home-agenda-time-grid">' +
                '<div class="home-agenda-time-field"><span>Jam Mulai</span><input type="time" name="jam_mulai" value="' + escapeAttribute(timeRange.start) + '" required></div>' +
                '<div class="home-agenda-time-field"><span>Jam Selesai</span><input type="time" name="jam_selesai" value="' + escapeAttribute(timeRange.end) + '" required></div>' +
                '</div></div>' +
                '<div class="home-agenda-field"><label>Ganti Surat Pendukung (PDF)</label><input type="file" name="surat_pendukung" accept="application/pdf,.pdf"></div>' +
                '</div>' +
                '<div class="home-agenda-form-actions"><button type="submit" class="home-agenda-submit"><i class="fas fa-save"></i> Update Jadwal</button></div>' +
                '</form>' +
                '</div>' +
                '</div>';

            bindModalClose(modal);
            modal.querySelector('[data-home-edit-agenda-form]').addEventListener('submit', function (event) {
                event.preventDefault();
                submitAgendaForm(event.currentTarget, 'Mengupdate...', 'Jadwal kegiatan berhasil diperbarui!');
            });
            document.body.appendChild(modal);
            document.body.style.overflow = 'hidden';
        }

        function showDeleteConfirm(item) {
            closeAgendaModal();
            const modal = document.createElement('div');
            modal.className = 'home-agenda-modal-overlay';
            modal.id = 'home-agenda-action-modal';
            modal.innerHTML =
                '<div style="background: white; border-radius: 16px; padding: 30px; max-width: 400px; width: 90%; box-shadow: 0 20px 60px rgba(0,0,0,0.3); animation: homeAgendaScaleIn 0.3s ease;">' +
                '<div style="text-align: center; margin-bottom: 20px;">' +
                '<div style="width: 70px; height: 70px; border-radius: 50%; background: #fef2f2; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px;">' +
                '<i class="fas fa-trash" style="font-size: 36px; color: #ef4444;"></i>' +
                '</div>' +
                '<h3 style="margin: 0 0 8px; font-size: 20px; color: #1f2937;">Konfirmasi Hapus</h3>' +
                '<p style="margin: 0; color: #6b7280; font-size: 14px;">Apakah Anda yakin ingin menghapus<br><strong style="color: #1f2937; font-size: 16px;">"' + escapeHtml(item.nama_kegiatan) + '"</strong>?</p>' +
                '</div>' +
                '<div style="display: flex; gap: 12px; justify-content: center;">' +
                '<button type="button" data-home-close-agenda-modal style="flex: 1; padding: 12px 24px; border: none; border-radius: 10px; background: #f3f4f6; color: #374151; font-weight: 500; cursor: pointer;">Batal</button>' +
                '<button type="button" data-home-confirm-delete-agenda style="flex: 1; padding: 12px 24px; border: none; border-radius: 10px; background: #ef4444; color: white; font-weight: 500; cursor: pointer;">Ya, Hapus</button>' +
                '</div>' +
                '</div>';

            modal.addEventListener('click', function (event) {
                if (event.target === modal || event.target.closest('[data-home-close-agenda-modal]')) {
                    closeAgendaModal();
                    return;
                }
                if (event.target.closest('[data-home-confirm-delete-agenda]')) {
                    deleteAgenda(item.id);
                }
            });
            document.body.appendChild(modal);
            document.body.style.overflow = 'hidden';
        }

        function bindModalClose(modal) {
            modal.addEventListener('click', function (event) {
                if (event.target === modal || event.target.closest('[data-home-close-agenda-modal]')) {
                    closeAgendaModal();
                }
            });
        }

        function timeToMinutes(value) {
            const parts = String(value || '').split(':').map(Number);
            return parts.length === 2 && parts.every(Number.isFinite) ? (parts[0] * 60) + parts[1] : null;
        }

        function validateAgendaDuration(form) {
            const startInput = form.querySelector('[name="jam_mulai"]');
            const endInput = form.querySelector('[name="jam_selesai"]');
            const start = timeToMinutes(startInput ? startInput.value : '');
            const end = timeToMinutes(endInput ? endInput.value : '');

            if (start === null || end === null) {
                return true;
            }

            const dateInput = form.querySelector('[name="tanggal_kegiatan"]');
            const now = new Date();
            const currentMinutes = (now.getHours() * 60) + now.getMinutes();

            if (dateInput && dateInput.value === todayKey && start < currentMinutes) {
                showNotification('Jam mulai tidak boleh lebih awal dari jam saat ini.', 'warning');
                return false;
            }

            const duration = end - start;

            if (duration <= 0) {
                showNotification('Jam mulai harus lebih awal daripada jam selesai.', 'warning');
                return false;
            }

            if (duration < 60) {
                showNotification('Lama pertemuan minimal 1 jam.', 'warning');
                return false;
            }

            if (duration > 450) {
                showNotification('Lama pertemuan maksimal 7 jam 30 menit.', 'warning');
                return false;
            }

            return true;
        }

        function submitAgendaForm(form, loadingText, fallbackMessage) {
            const dateInput = form.querySelector('[name="tanggal_kegiatan"]');
            if (dateInput && dateInput.value < todayKey) {
                showNotification('Kegiatan tidak bisa dijadwalkan pada tanggal sebelum hari ini.', 'warning');
                return;
            }

            if (!form.reportValidity() || !validateAgendaDuration(form)) {
                return;
            }

            const submitButton = form.querySelector('button[type="submit"]');
            const originalHtml = submitButton ? submitButton.innerHTML : '';
            if (submitButton) {
                submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> ' + loadingText;
                submitButton.disabled = true;
            }

            fetch(form.action, {
                method: 'POST',
                body: new FormData(form),
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(async function (response) {
                const data = await response.json();
                if (!response.ok) throw data;
                return data;
            })
            .then(function (data) {
                showNotification(data.message || fallbackMessage, 'success');
                setTimeout(function () { window.location.reload(); }, 1200);
            })
            .catch(function (error) {
                const firstError = error.errors ? Object.values(error.errors)[0][0] : null;
                showNotification(firstError || error.message || 'Terjadi kesalahan saat memproses jadwal kegiatan.', 'error');
            })
            .finally(function () {
                if (submitButton) {
                    submitButton.innerHTML = originalHtml;
                    submitButton.disabled = false;
                }
            });
        }

        function deleteAgenda(id) {
            const confirmButton = document.querySelector('[data-home-confirm-delete-agenda]');
            if (confirmButton) {
                confirmButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menghapus...';
                confirmButton.disabled = true;
            }

            fetch('{{ url('/admin/informasi-publik/agenda') }}/' + id, {
                method: 'DELETE',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                }
            })
            .then(async function (response) {
                const data = await response.json();
                if (!response.ok) throw data;
                return data;
            })
            .then(function (data) {
                closeAgendaModal();
                showNotification(data.message || 'Jadwal kegiatan berhasil dihapus!', 'success');
                setTimeout(function () { window.location.reload(); }, 1200);
            })
            .catch(function (error) {
                showNotification(error.message || 'Terjadi kesalahan saat menghapus jadwal kegiatan.', 'error');
                if (confirmButton) {
                    confirmButton.innerHTML = 'Ya, Hapus';
                    confirmButton.disabled = false;
                }
            });
        }

        function closeAgendaModal() {
            const modal = document.getElementById('home-agenda-action-modal');
            if (!modal) return;
            modal.style.opacity = '0';
            modal.style.transform = 'scale(0.9)';
            setTimeout(function () {
                modal.remove();
                document.body.style.overflow = 'auto';
            }, 300);
        }

        function showNotification(message, type = 'success') {
            document.querySelectorAll('.custom-notification').forEach(function (notification) {
                notification.remove();
            });
            const config = {
                success: { icon: 'fa-check-circle', bg: 'linear-gradient(135deg, #10b981, #059669)', color: '#fff' },
                error: { icon: 'fa-times-circle', bg: 'linear-gradient(135deg, #ef4444, #dc2626)', color: '#fff' },
                warning: { icon: 'fa-exclamation-circle', bg: 'linear-gradient(135deg, #f59e0b, #d97706)', color: '#fff' },
                info: { icon: 'fa-info-circle', bg: 'linear-gradient(135deg, #3b82f6, #2563eb)', color: '#fff' }
            };
            const c = config[type] || config.success;
            const notification = document.createElement('div');
            notification.className = 'custom-notification';
            notification.style.cssText = 'position: fixed; top: 20px; right: 20px; background: ' + c.bg + '; color: ' + c.color + '; padding: 16px 24px; border-radius: 12px; box-shadow: 0 10px 40px rgba(0,0,0,0.2); z-index: 10000; font-family: Poppins, sans-serif; font-size: 14px; display: flex; align-items: center; gap: 12px; animation: homeAgendaSlideInRight 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55); min-width: 280px; max-width: 400px;';
            notification.innerHTML = '<i class="fas ' + c.icon + '" style="font-size: 24px;"></i><span style="font-weight: 500;">' + escapeHtml(message) + '</span>';
            document.body.appendChild(notification);
            setTimeout(function () {
                notification.style.transform = 'translateX(120%)';
                notification.style.opacity = '0';
                notification.style.transition = 'all 0.4s ease';
                setTimeout(function () { notification.remove(); }, 400);
            }, 3500);
        }

        detailElement.addEventListener('click', function (event) {
            const editButton = event.target.closest('[data-home-edit-agenda]');
            if (editButton) {
                const agenda = agendaItems.find(function (item) {
                    return String(item.id) === String(editButton.dataset.homeEditAgenda);
                });
                agenda ? openEditAgendaModal(agenda) : showNotification('Data jadwal kegiatan tidak ditemukan', 'error');
                return;
            }

            const deleteButton = event.target.closest('[data-home-delete-agenda]');
            if (deleteButton) {
                const agenda = agendaItems.find(function (item) {
                    return String(item.id) === String(deleteButton.dataset.homeDeleteAgenda);
                });
                agenda ? showDeleteConfirm(agenda) : showNotification('Data jadwal kegiatan tidak ditemukan', 'error');
            }
        });

        prevButton.addEventListener('click', function () {
            currentMonth = new Date(currentMonth.getFullYear(), currentMonth.getMonth() - 1, 1);
            renderCalendar();
        });

        nextButton.addEventListener('click', function () {
            currentMonth = new Date(currentMonth.getFullYear(), currentMonth.getMonth() + 1, 1);
            renderCalendar();
        });

        renderCalendar();
        renderDetail();
    });
</script>
