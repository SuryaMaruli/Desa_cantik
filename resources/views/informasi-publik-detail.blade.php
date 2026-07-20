@extends('layouts.app')

@section('title', 'Detail Informasi Publik - Kelurahan Gunung Sugih')

@section('content')
@php
    $isAgendaPage = $informasi && ($informasi->id == 4 || str_contains(strtolower($informasi->judul), 'agenda'));
    $agendaKegiatan = collect($agendaKegiatans ?? [])->map(function ($agenda) {
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
    /* --- RESET & GLOBAL --- */
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: 'Roboto', sans-serif; background-color: #f8f9fa; color: #333; overflow-x: hidden; }
    a { text-decoration: none; }

    /* --- HERO SECTION --- */
    .hero-section {
        background-color: #F6903A;
        color: #ffffff;
        text-align: center;
        position: relative;
        overflow: hidden;
        padding-top: 60px;
        padding-bottom: 120px;
    }

    .hero-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-image: url('https://images.unsplash.com/photo-1486312338219-ce68d2C6f44d?ixlib=rb-1.2.1&auto=format&fit=crop&w=1200&q=80');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        opacity: 0.3;
        z-index: 1;
    }

    .hero-content {
        position: relative;
        z-index: 2;
    }

    .hero-section h1 { font-size: 2.8rem; font-weight: 400; margin-bottom: 25px; text-transform: uppercase; }
    .description { font-size: 1.1rem; font-weight: 300; line-height: 1.8; margin-bottom: 40px; }

    .wave-container { 
        position: absolute; 
        bottom: -1px; 
        left: 0; 
        width: 100%; 
        overflow: hidden; 
        line-height: 0; 
        z-index: 4; 
    }
    .wave-container svg { 
        position: relative; 
        display: block; 
        width: calc(100% + 1.3px); 
        height: 160px; 
    }
    .wave-fill { fill: #ffffff; }

    /* --- CONTENT SECTION --- */
    .content-section {
        padding: 80px 20px 100px 20px;
        max-width: 900px;
        margin: 0 auto;
    }

    .detail-card {
        background: white;
        border-radius: 20px;
        padding: 40px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        border: 1px solid #f0f0f0;
        margin-bottom: 40px;
    }

    .detail-header {
        border-bottom: 2px solid #f0f0f0;
        padding-bottom: 30px;
        margin-bottom: 30px;
    }

    .detail-title {
        color: #333;
        font-size: 2rem;
        font-weight: 600;
        margin-bottom: 15px;
    }

    .detail-meta {
        display: flex;
        gap: 30px;
        color: #666;
        font-size: 0.9rem;
        margin-bottom: 20px;
    }

    .detail-meta-item {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .detail-meta i {
        color: #F6903A;
    }

    .detail-content {
        line-height: 1.8;
        color: #555;
        font-size: 1.05rem;
    }

    .detail-content p {
        margin-bottom: 20px;
    }

    .agenda-wrapper {
        display: grid;
        grid-template-columns: minmax(0, 1.1fr) minmax(300px, 0.9fr);
        gap: 24px;
        align-items: start;
        margin-top: 28px;
    }

    .agenda-admin-form {
        background: #fffaf5;
        border: 1px solid #fed7aa;
        border-radius: 12px;
        padding: 20px;
        margin: 0 20px 20px;
        display: none;
    }

    .agenda-admin-form.is-visible {
        display: block;
    }

    .agenda-admin-form h3 {
        color: #243042;
        font-size: 1.2rem;
        font-weight: 700;
        margin-bottom: 16px;
    }

    .agenda-admin-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 14px;
    }

    .agenda-admin-field label {
        display: block;
        color: #475569;
        font-size: 0.9rem;
        font-weight: 700;
        margin-bottom: 7px;
    }

    .agenda-admin-field input {
        width: 100%;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 11px 12px;
        font-size: 0.95rem;
    }

    .agenda-time-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 12px;
    }

    .agenda-time-field span {
        display: block;
        color: #64748b;
        font-size: 0.78rem;
        font-weight: 700;
        margin-bottom: 5px;
    }

    .agenda-admin-field input:focus {
        outline: none;
        border-color: #F6903A;
        box-shadow: 0 0 0 3px rgba(246, 144, 58, 0.12);
    }

    .agenda-admin-actions {
        display: flex;
        justify-content: flex-end;
        margin-top: 16px;
    }

    .agenda-admin-submit {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border: 0;
        border-radius: 8px;
        background: #F6903A;
        color: #fff;
        padding: 11px 16px;
        font-weight: 700;
        cursor: pointer;
    }

    .agenda-admin-submit:hover {
        background: #E57A2A;
    }

    .agenda-alert {
        border-radius: 10px;
        padding: 12px 14px;
        margin-top: 18px;
        font-weight: 600;
    }

    .agenda-alert-success {
        background: #ecfdf5;
        color: #047857;
        border: 1px solid #a7f3d0;
    }

    .agenda-alert-error {
        background: #fef2f2;
        color: #b91c1c;
        border: 1px solid #fecaca;
    }

    .agenda-modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.5);
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 18px;
        animation: fadeIn 0.3s ease;
    }

    .agenda-modal-content {
        background: #ffffff;
        border-radius: 16px;
        width: min(640px, 95vw);
        max-height: 92vh;
        overflow-y: auto;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        animation: scaleIn 0.3s ease;
    }

    .agenda-modal-header {
        background: linear-gradient(135deg, #F6903A, #E57A2A);
        color: #ffffff;
        padding: 18px 22px;
        border-radius: 16px 16px 0 0;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
    }

    .agenda-modal-header h3 {
        margin: 0;
        font-size: 1.1rem;
        font-weight: 700;
    }

    .agenda-modal-close {
        width: 32px;
        height: 32px;
        border: 0;
        border-radius: 50%;
        background: transparent;
        color: #ffffff;
        font-size: 1.4rem;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .agenda-modal-close:hover {
        background: rgba(255, 255, 255, 0.2);
    }

    .agenda-modal-body {
        padding: 22px;
    }

    @keyframes scaleIn {
        from { transform: scale(0.9); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }

    @keyframes slideInRight {
        from { transform: translateX(120%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }

    .calendar-panel,
    .agenda-detail-panel {
        background: #ffffff;
        border: 1px solid #eceff3;
        border-radius: 12px;
        box-shadow: 0 10px 24px rgba(31, 41, 55, 0.06);
        overflow: hidden;
    }

    .calendar-toolbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
        padding: 18px 20px;
        border-bottom: 1px solid #eef1f5;
    }

    .calendar-title {
        font-size: 1.15rem;
        font-weight: 700;
        color: #243042;
        margin: 0;
    }

    .calendar-nav {
        display: inline-flex;
        gap: 8px;
    }

    .calendar-nav button,
    .calendar-day {
        border: 0;
        background: transparent;
        cursor: pointer;
    }

    .calendar-nav button {
        width: 38px;
        height: 38px;
        border-radius: 8px;
        color: #475569;
        border: 1px solid #e2e8f0;
        transition: all 0.2s ease;
    }

    .calendar-nav button:hover {
        color: #ffffff;
        background: #F6903A;
        border-color: #F6903A;
    }

    .calendar-grid {
        display: grid;
        grid-template-columns: repeat(7, minmax(0, 1fr));
        gap: 8px;
        padding: 18px 20px 22px;
    }

    .calendar-weekday {
        color: #64748b;
        font-size: 0.8rem;
        font-weight: 700;
        text-align: center;
        padding: 6px 0;
    }

    .calendar-day {
        min-height: 66px;
        border-radius: 10px;
        border: 1px solid #edf1f5;
        color: #334155;
        background: #fbfcfe;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        align-items: flex-start;
        padding: 9px;
        text-align: left;
        transition: all 0.2s ease;
    }

    .calendar-day:hover {
        border-color: #F6903A;
        box-shadow: 0 8px 18px rgba(246, 144, 58, 0.12);
        transform: translateY(-1px);
    }

    .calendar-day.is-empty {
        visibility: hidden;
        pointer-events: none;
    }

    .calendar-day.is-past {
        opacity: 0.65;
        background: #f1f5f9;
    }

    .calendar-day.is-past.has-agenda {
        opacity: 0.9;
    }

    .calendar-day.is-past:hover {
        border-color: #cbd5e1;
        box-shadow: 0 8px 18px rgba(100, 116, 139, 0.1);
        transform: translateY(-1px);
    }

    .calendar-day.is-today {
        border-color: #94a3b8;
        background: #f8fafc;
    }

    .calendar-day.has-agenda {
        background: #fff7ed;
        border-color: #fed7aa;
    }

    .calendar-day.is-selected {
        background: #F6903A;
        border-color: #F6903A;
        color: #ffffff;
    }

    .calendar-date-number {
        font-weight: 700;
        line-height: 1;
    }

    .agenda-count {
        min-width: 22px;
        height: 22px;
        border-radius: 999px;
        background: #ffffff;
        color: #C2410C;
        border: 1px solid #fed7aa;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        font-weight: 700;
    }

    .calendar-day.is-selected .agenda-count {
        color: #F6903A;
        border-color: #ffffff;
    }

    .agenda-detail-panel {
        min-height: 100%;
    }

    .agenda-detail-header {
        padding: 20px;
        border-bottom: 1px solid #eef1f5;
    }

    .agenda-detail-header span {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #F6903A;
        font-weight: 700;
        font-size: 0.9rem;
        margin-bottom: 8px;
    }

    .agenda-detail-header h3 {
        margin: 0;
        color: #243042;
        font-size: 1.25rem;
        font-weight: 700;
    }

    .agenda-detail-list {
        display: grid;
        gap: 14px;
        padding: 20px;
    }

    .agenda-card {
        border: 1px solid #edf1f5;
        border-radius: 10px;
        padding: 18px;
        background: #ffffff;
    }

    .agenda-card h4 {
        color: #243042;
        font-size: 1.05rem;
        font-weight: 700;
        margin-bottom: 14px;
    }

    .agenda-card-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-top: 14px;
    }

    .agenda-mini-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        border: 0;
        border-radius: 8px;
        padding: 9px 12px;
        color: #ffffff;
        font-weight: 700;
        font-size: 0.85rem;
        cursor: pointer;
    }

    .agenda-mini-button.edit {
        background: #2563eb;
    }

    .agenda-mini-button.delete {
        background: #dc2626;
    }

    .agenda-edit-form {
        display: none;
        margin-top: 14px;
        padding-top: 14px;
        border-top: 1px solid #edf1f5;
    }

    .agenda-edit-form.is-visible {
        display: block;
    }

    .agenda-info {
        display: grid;
        gap: 10px;
        margin-bottom: 16px;
    }

    .agenda-info-item {
        display: grid;
        grid-template-columns: 26px minmax(0, 1fr);
        gap: 10px;
        align-items: start;
        color: #475569;
        font-size: 0.95rem;
    }

    .agenda-info-item i {
        color: #F6903A;
        margin-top: 3px;
    }

    .pdf-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 10px 14px;
        border-radius: 8px;
        background: #dc2626;
        color: #ffffff;
        font-weight: 700;
        transition: all 0.2s ease;
    }

    .pdf-button:hover {
        background: #b91c1c;
        color: #ffffff;
        transform: translateY(-1px);
    }

    .agenda-empty {
        padding: 28px 20px;
        color: #64748b;
        text-align: center;
    }

    .agenda-empty i {
        color: #cbd5e1;
        font-size: 2rem;
        margin-bottom: 12px;
    }

    .back-button {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 12px 24px;
        background: #F6903A;
        color: white;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
        margin-bottom: 30px;
    }

    .back-button:hover {
        background: #E57A2A;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(246, 144, 58, 0.3);
    }

    /* --- RESPONSIVE --- */
    @media (max-width: 768px) {
        .hero-section { padding: 40px 0; }
        .hero-section h1 { font-size: 2rem; }
        .detail-card { padding: 25px; }
        .detail-title { font-size: 1.5rem; }
        .detail-meta { flex-direction: column; gap: 15px; }
        .content-section { padding: 40px 15px; }
        .agenda-admin-grid { grid-template-columns: 1fr; }
        .agenda-time-grid { grid-template-columns: 1fr; }
        .agenda-admin-actions { justify-content: stretch; }
        .agenda-admin-submit { width: 100%; justify-content: center; }
        .agenda-wrapper { grid-template-columns: 1fr; }
        .calendar-toolbar { align-items: flex-start; flex-direction: column; }
        .calendar-grid { gap: 6px; padding: 14px; }
        .calendar-day { min-height: 52px; padding: 7px; }
    }
</style>

    <div class="hero-section">
        <div class="hero-content">
            <h1>Detail Informasi Publik</h1>
            <div class="description">
                <span>Informasi lengkap mengenai layanan dan program Kelurahan Gunung Sugih</span>
            </div>
        </div>
        <div class="wave-container">
            <svg viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path d="M0,60 C400,160 800,-40 1200,60 L1200,120 L0,120 Z" class="wave-fill"></path>
            </svg>
        </div>
    </div>

    <section class="content-section">
        <a href="{{ url()->previous() }}" class="back-button">
            <i class="fas fa-arrow-left"></i>
            Kembali
        </a>

        <div class="detail-card">
            @if($informasi)
                <div class="detail-header">
                    <h2 class="detail-title">{{ $informasi->judul }}</h2>
                </div>
                
                @if($isAgendaPage)
                    <div class="detail-content">
                        <div class="agenda-wrapper" data-agenda-calendar>
                            <div class="calendar-panel">
                                <div class="calendar-toolbar">
                                    <h3 class="calendar-title" data-calendar-title></h3>
                                    <div class="calendar-nav">
                                        <button type="button" data-calendar-prev aria-label="Bulan sebelumnya" title="Bulan sebelumnya">
                                            <i class="fas fa-chevron-left"></i>
                                        </button>
                                        <button type="button" data-calendar-next aria-label="Bulan berikutnya" title="Bulan berikutnya">
                                            <i class="fas fa-chevron-right"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="calendar-grid" data-calendar-grid></div>
                            </div>

                            <aside class="agenda-detail-panel">
                                <div class="agenda-detail-header">
                                    <span><i class="fas fa-calendar-day"></i> Detail Kegiatan</span>
                                    <h3 data-selected-date></h3>
                                </div>
                                <div class="agenda-detail-list" data-agenda-detail></div>
                            </aside>
                        </div>
                    </div>
                @else
                    <div class="detail-content">
                        <h3>Deskripsi</h3>
                        <div class="sub-description">
                            <p><strong>{{ $informasi->sub_deskripsi }}</strong></p>
                        </div>
                        <div class="full-description">
                            {!! nl2br(e($informasi->deskripsi)) !!}
                        </div>
                    </div>
                @endif
            @else
                <div class="text-center py-5">
                    <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3 d-block"></i>
                    <h3>Informasi Tidak Ditemukan</h3>
                    <p class="text-muted">Maaf, informasi yang Anda cari tidak tersedia.</p>
                    <a href="{{ url('/desa-cantik#informasi-publik') }}" class="btn btn-primary mt-3">
                        <i class="fas fa-arrow-left me-2"></i>
                        Kembali ke Informasi Publik
                    </a>
                </div>
            @endif
        </div>
    </section>

@if($isAgendaPage)
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const calendarRoot = document.querySelector('[data-agenda-calendar]');
        if (!calendarRoot) {
            return;
        }

        const agendaItems = @json($agendaKegiatan);
        const canManageAgenda = @json(auth()->check() && in_array(auth()->user()->role, ['admin', 'super_admin']));
        const csrfToken = @json(csrf_token());
        const sessionSuccess = @json(session('success'));
        const hasValidationErrors = @json($errors->any());
        const titleElement = calendarRoot.querySelector('[data-calendar-title]');
        const gridElement = calendarRoot.querySelector('[data-calendar-grid]');
        const detailElement = calendarRoot.querySelector('[data-agenda-detail]');
        const selectedDateElement = calendarRoot.querySelector('[data-selected-date]');
        const prevButton = calendarRoot.querySelector('[data-calendar-prev]');
        const nextButton = calendarRoot.querySelector('[data-calendar-next]');
        const monthNames = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        const weekdayNames = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];
        const todayKey = formatDateKey(new Date());
        const firstAgendaDate = agendaItems.length ? new Date(agendaItems[0].tanggal_kegiatan + 'T00:00:00') : new Date();
        let currentMonth = new Date(firstAgendaDate.getFullYear(), firstAgendaDate.getMonth(), 1);
        let selectedDateKey = agendaItems.length ? agendaItems[0].tanggal_kegiatan : todayKey;

        const agendaByDate = agendaItems.reduce(function (grouped, item) {
            if (!grouped[item.tanggal_kegiatan]) {
                grouped[item.tanggal_kegiatan] = [];
            }
            grouped[item.tanggal_kegiatan].push(item);
            return grouped;
        }, {});

        function formatDateKey(date) {
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            return year + '-' + month + '-' + day;
        }

        function formatDisplayDate(dateKey) {
            const date = new Date(dateKey + 'T00:00:00');
            return date.getDate() + ' ' + monthNames[date.getMonth()] + ' ' + date.getFullYear();
        }

        function renderCalendar() {
            const year = currentMonth.getFullYear();
            const month = currentMonth.getMonth();
            const firstDay = new Date(year, month, 1);
            const lastDay = new Date(year, month + 1, 0);

            titleElement.textContent = monthNames[month] + ' ' + year;
            gridElement.innerHTML = '';

            weekdayNames.forEach(function (weekday) {
                const weekdayElement = document.createElement('div');
                weekdayElement.className = 'calendar-weekday';
                weekdayElement.textContent = weekday;
                gridElement.appendChild(weekdayElement);
            });

            for (let i = 0; i < firstDay.getDay(); i++) {
                const emptyElement = document.createElement('div');
                emptyElement.className = 'calendar-day is-empty';
                gridElement.appendChild(emptyElement);
            }

            for (let day = 1; day <= lastDay.getDate(); day++) {
                const date = new Date(year, month, day);
                const dateKey = formatDateKey(date);
                const dayAgendas = agendaByDate[dateKey] || [];
                const dayButton = document.createElement('button');
                dayButton.type = 'button';
                dayButton.className = 'calendar-day';
                dayButton.dataset.date = dateKey;

                if (dateKey === todayKey) {
                    dayButton.classList.add('is-today');
                }

                if (dateKey < todayKey) {
                    dayButton.classList.add('is-past');
                }

                if (dateKey === selectedDateKey) {
                    dayButton.classList.add('is-selected');
                }

                if (dayAgendas.length) {
                    dayButton.classList.add('has-agenda');
                }

                dayButton.innerHTML = '<span class="calendar-date-number">' + day + '</span>' +
                    (dayAgendas.length ? '<span class="agenda-count">' + dayAgendas.length + '</span>' : '');

                dayButton.addEventListener('click', function () {
                    selectedDateKey = dateKey;
                    renderCalendar();
                    renderDetail();
                    showAgendaForm(dateKey);
                });

                gridElement.appendChild(dayButton);
            }
        }

        function renderDetail() {
            const selectedAgendas = agendaByDate[selectedDateKey] || [];
            selectedDateElement.textContent = formatDisplayDate(selectedDateKey);

            if (!selectedAgendas.length) {
                detailElement.innerHTML = '<div class="agenda-empty"><i class="fas fa-calendar-xmark d-block"></i><p class="mb-0">Belum ada kegiatan pada tanggal ini.</p></div>';
                return;
            }

            detailElement.innerHTML = selectedAgendas.map(function (item) {
                const pdfUrl = item.surat_pendukung ? '{{ url('/storage') }}/' + item.surat_pendukung : '';
                const keteranganMarkup = item.keterangan ? '<div class="agenda-info-item"><i class="fas fa-align-left"></i><span>' + escapeHtml(item.keterangan) + '</span></div>' : '';
                const timeRange = parseTimeRange(item.jam_kegiatan);
                const manageMarkup = canManageAgenda ? renderManageMarkup(item, timeRange) : '';
                return '<article class="agenda-card">' +
                    '<h4>' + escapeHtml(item.nama_kegiatan) + '</h4>' +
                    '<div class="agenda-info">' +
                    '<div class="agenda-info-item"><i class="fas fa-calendar-alt"></i><span>' + formatDisplayDate(item.tanggal_kegiatan) + '</span></div>' +
                    '<div class="agenda-info-item"><i class="fas fa-map-marker-alt"></i><span>' + escapeHtml(item.tempat_kegiatan) + '</span></div>' +
                    '<div class="agenda-info-item"><i class="fas fa-clock"></i><span>' + escapeHtml(item.jam_kegiatan) + '</span></div>' +
                    keteranganMarkup +
                    '</div>' +
                    (pdfUrl ? '<a class="pdf-button" href="' + pdfUrl + '" target="_blank" rel="noopener"><i class="fas fa-file-pdf"></i> Surat Pendukung PDF</a>' : '<span class="text-muted">Surat pendukung belum tersedia.</span>') +
                    manageMarkup +
                    '</article>';
            }).join('');
        }

        function renderManageMarkup(item, timeRange) {
            const safeId = String(item.id);

            return '<div class="agenda-card-actions">' +
                '<button type="button" class="agenda-mini-button edit" data-edit-agenda="' + safeId + '"><i class="fas fa-pen"></i> Edit</button>' +
                '<button type="button" class="agenda-mini-button delete" data-delete-agenda="' + safeId + '"><i class="fas fa-trash"></i> Hapus</button>' +
                '</div>';
        }

        function showAgendaForm(dateKey) {
            if (!canManageAgenda) {
                return;
            }

            if (dateKey < todayKey) {
                return;
            }

            openAddAgendaModal(dateKey);
        }

        function openAddAgendaModal(dateKey) {
            if (dateKey < todayKey) {
                showNotification('Kegiatan tidak bisa dijadwalkan pada tanggal sebelum hari ini.', 'warning');
                return;
            }

            closeAgendaModal();

            const modal = document.createElement('div');
            modal.className = 'agenda-modal-overlay';
            modal.id = 'agenda-action-modal';
            modal.innerHTML =
                '<div class="agenda-modal-content">' +
                '<div class="agenda-modal-header">' +
                '<h3>Tambah Jadwal Kegiatan</h3>' +
                '<button type="button" class="agenda-modal-close" data-close-agenda-modal>&times;</button>' +
                '</div>' +
                '<div class="agenda-modal-body">' +
                '<form action="{{ route('admin.informasi-publik.agenda.store') }}" method="POST" enctype="multipart/form-data" data-add-agenda-form>' +
                '<input type="hidden" name="_token" value="' + csrfToken + '">' +
                '<input type="hidden" name="redirect_to" value="public_agenda">' +
                '<div class="agenda-admin-grid">' +
                '<div class="agenda-admin-field"><label>Tanggal Kegiatan</label><input type="date" name="tanggal_kegiatan" value="' + escapeAttribute(dateKey) + '" readonly required></div>' +
                '<div class="agenda-admin-field"><label>Nama Kegiatan</label><input type="text" name="nama_kegiatan" required></div>' +
                '<div class="agenda-admin-field"><label>Tempat Kegiatan</label><input type="text" name="tempat_kegiatan" required></div>' +
                '<div class="agenda-admin-field"><label>Keterangan <small style="color:#94a3b8;font-weight:600;">(opsional)</small></label><textarea name="keterangan" placeholder="Tambahkan catatan kegiatan jika diperlukan"></textarea></div>' +
                '<div class="agenda-admin-field"><label>Jam Kegiatan</label><div class="agenda-time-grid">' +
                '<div class="agenda-time-field"><span>Jam Mulai</span><input type="time" name="jam_mulai" required></div>' +
                '<div class="agenda-time-field"><span>Jam Selesai</span><input type="time" name="jam_selesai" required></div>' +
                '</div></div>' +
                '<div class="agenda-admin-field"><label>Surat Pendukung Kegiatan (PDF)</label><input type="file" name="surat_pendukung" accept="application/pdf,.pdf"></div>' +
                '</div>' +
                '<div class="agenda-admin-actions"><button type="submit" class="agenda-admin-submit"><i class="fas fa-save"></i> Simpan Jadwal</button></div>' +
                '</form>' +
                '</div>' +
                '</div>';

            modal.addEventListener('click', function (event) {
                if (event.target === modal || event.target.closest('[data-close-agenda-modal]')) {
                    closeAgendaModal();
                }
            });

            modal.querySelector('[data-add-agenda-form]').addEventListener('submit', function (event) {
                event.preventDefault();
                submitAgendaForm(event.currentTarget, 'Menyimpan...', 'Jadwal kegiatan berhasil ditambahkan!');
            });

            document.body.appendChild(modal);
            document.body.style.overflow = 'hidden';
        }

        function parseTimeRange(value) {
            const match = String(value || '').match(/(\d{2}:\d{2})\s*-\s*(\d{2}:\d{2})/);
            return {
                start: match ? match[1] : '',
                end: match ? match[2] : '',
            };
        }

        function escapeHtml(value) {
            const div = document.createElement('div');
            div.textContent = value || '';
            return div.innerHTML;
        }

        function escapeAttribute(value) {
            return escapeHtml(value).replace(/"/g, '&quot;');
        }

        detailElement.addEventListener('click', function (event) {
            const editButton = event.target.closest('[data-edit-agenda]');
            if (editButton) {
                const agenda = agendaItems.find(function (item) {
                    return String(item.id) === String(editButton.dataset.editAgenda);
                });

                if (agenda) {
                    openEditAgendaModal(agenda);
                } else {
                    showNotification('Data jadwal kegiatan tidak ditemukan', 'error');
                }
                return;
            }

            const deleteButton = event.target.closest('[data-delete-agenda]');
            if (deleteButton) {
                const agenda = agendaItems.find(function (item) {
                    return String(item.id) === String(deleteButton.dataset.deleteAgenda);
                });

                if (agenda) {
                    showDeleteConfirm(agenda);
                } else {
                    showNotification('Data jadwal kegiatan tidak ditemukan', 'error');
                }
            }
        });

        if (sessionSuccess) {
            showNotification(sessionSuccess, 'success');
        }

        if (hasValidationErrors) {
            showNotification('Periksa kembali data jadwal kegiatan yang diisi.', 'warning');
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
                if (!response.ok) {
                    throw data;
                }
                return data;
            })
            .then(function (data) {
                showNotification(data.message || fallbackMessage, 'success');
                setTimeout(function () {
                    window.location.reload();
                }, 1200);
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

        function openEditAgendaModal(item) {
            closeAgendaModal();

            const timeRange = parseTimeRange(item.jam_kegiatan);
            const updateUrl = '{{ url('/admin/informasi-publik/agenda') }}/' + item.id;
            const modal = document.createElement('div');
            modal.className = 'agenda-modal-overlay';
            modal.id = 'agenda-action-modal';
            modal.innerHTML =
                '<div class="agenda-modal-content">' +
                '<div class="agenda-modal-header">' +
                '<h3>Edit Jadwal Kegiatan</h3>' +
                '<button type="button" class="agenda-modal-close" data-close-agenda-modal>&times;</button>' +
                '</div>' +
                '<div class="agenda-modal-body">' +
                '<form action="' + updateUrl + '" method="POST" enctype="multipart/form-data" data-edit-agenda-form>' +
                '<input type="hidden" name="_token" value="' + csrfToken + '">' +
                '<input type="hidden" name="_method" value="PUT">' +
                '<input type="hidden" name="redirect_to" value="public_agenda">' +
                '<div class="agenda-admin-grid">' +
                '<div class="agenda-admin-field"><label>Tanggal Kegiatan</label><input type="date" name="tanggal_kegiatan" value="' + escapeAttribute(item.tanggal_kegiatan) + '" min="' + todayKey + '" required><small style="display:block;margin-top:6px;color:#64748b;font-size:12px;line-height:1.35;">Ubah tanggal ini untuk memindahkan kegiatan.</small></div>' +
                '<div class="agenda-admin-field"><label>Nama Kegiatan</label><input type="text" name="nama_kegiatan" value="' + escapeAttribute(item.nama_kegiatan) + '" required></div>' +
                '<div class="agenda-admin-field"><label>Tempat Kegiatan</label><input type="text" name="tempat_kegiatan" value="' + escapeAttribute(item.tempat_kegiatan) + '" required></div>' +
                '<div class="agenda-admin-field"><label>Keterangan <small style="color:#94a3b8;font-weight:600;">(opsional)</small></label><textarea name="keterangan" placeholder="Tambahkan catatan kegiatan jika diperlukan">' + escapeHtml(item.keterangan || '') + '</textarea></div>' +
                '<div class="agenda-admin-field"><label>Jam Kegiatan</label><div class="agenda-time-grid">' +
                '<div class="agenda-time-field"><span>Jam Mulai</span><input type="time" name="jam_mulai" value="' + escapeAttribute(timeRange.start) + '" required></div>' +
                '<div class="agenda-time-field"><span>Jam Selesai</span><input type="time" name="jam_selesai" value="' + escapeAttribute(timeRange.end) + '" required></div>' +
                '</div></div>' +
                '<div class="agenda-admin-field"><label>Ganti Surat Pendukung (PDF)</label><input type="file" name="surat_pendukung" accept="application/pdf,.pdf"></div>' +
                '</div>' +
                '<div class="agenda-admin-actions"><button type="submit" class="agenda-admin-submit"><i class="fas fa-save"></i> Update Jadwal</button></div>' +
                '</form>' +
                '</div>' +
                '</div>';

            modal.addEventListener('click', function (event) {
                if (event.target === modal || event.target.closest('[data-close-agenda-modal]')) {
                    closeAgendaModal();
                }
            });

            modal.querySelector('[data-edit-agenda-form]').addEventListener('submit', function (event) {
                event.preventDefault();
                submitAgendaForm(event.currentTarget, 'Mengupdate...', 'Jadwal kegiatan berhasil diperbarui!');
            });

            document.body.appendChild(modal);
            document.body.style.overflow = 'hidden';
        }

        function showDeleteConfirm(item) {
            closeAgendaModal();

            const modal = document.createElement('div');
            modal.className = 'agenda-modal-overlay';
            modal.id = 'agenda-action-modal';
            modal.innerHTML =
                '<div style="background: white; border-radius: 16px; padding: 30px; max-width: 400px; width: 90%; box-shadow: 0 20px 60px rgba(0,0,0,0.3); animation: scaleIn 0.3s ease;">' +
                '<div style="text-align: center; margin-bottom: 20px;">' +
                '<div style="width: 70px; height: 70px; border-radius: 50%; background: #fef2f2; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px;">' +
                '<i class="fas fa-trash" style="font-size: 36px; color: #ef4444;"></i>' +
                '</div>' +
                '<h3 style="margin: 0 0 8px; font-size: 20px; color: #1f2937;">Konfirmasi Hapus</h3>' +
                '<p style="margin: 0; color: #6b7280; font-size: 14px;">Apakah Anda yakin ingin menghapus<br><strong style="color: #1f2937; font-size: 16px;">"' + escapeHtml(item.nama_kegiatan) + '"</strong>?</p>' +
                '</div>' +
                '<div style="display: flex; gap: 12px; justify-content: center;">' +
                '<button type="button" data-close-agenda-modal style="flex: 1; padding: 12px 24px; border: none; border-radius: 10px; background: #f3f4f6; color: #374151; font-weight: 500; cursor: pointer; transition: all 0.2s;">Batal</button>' +
                '<button type="button" data-confirm-delete-agenda style="flex: 1; padding: 12px 24px; border: none; border-radius: 10px; background: #ef4444; color: white; font-weight: 500; cursor: pointer; transition: all 0.2s;">Ya, Hapus</button>' +
                '</div>' +
                '</div>';

            modal.addEventListener('click', function (event) {
                if (event.target === modal || event.target.closest('[data-close-agenda-modal]')) {
                    closeAgendaModal();
                    return;
                }

                if (event.target.closest('[data-confirm-delete-agenda]')) {
                    deleteAgenda(item.id);
                }
            });

            document.body.appendChild(modal);
            document.body.style.overflow = 'hidden';
        }

        function deleteAgenda(id) {
            const confirmButton = document.querySelector('[data-confirm-delete-agenda]');
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
                if (!response.ok) {
                    throw data;
                }
                return data;
            })
            .then(function (data) {
                closeAgendaModal();
                showNotification(data.message || 'Jadwal kegiatan berhasil dihapus!', 'success');
                setTimeout(function () {
                    window.location.reload();
                }, 1200);
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
            const modal = document.getElementById('agenda-action-modal');
            if (!modal) {
                return;
            }

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

            const notification = document.createElement('div');
            const config = {
                success: { icon: 'fa-check-circle', bg: 'linear-gradient(135deg, #10b981, #059669)', color: '#fff' },
                error: { icon: 'fa-times-circle', bg: 'linear-gradient(135deg, #ef4444, #dc2626)', color: '#fff' },
                warning: { icon: 'fa-exclamation-circle', bg: 'linear-gradient(135deg, #f59e0b, #d97706)', color: '#fff' },
                info: { icon: 'fa-info-circle', bg: 'linear-gradient(135deg, #3b82f6, #2563eb)', color: '#fff' }
            };
            const c = config[type] || config.success;

            notification.className = 'custom-notification';
            notification.style.cssText =
                'position: fixed; top: 20px; right: 20px;' +
                'background: ' + c.bg + '; color: ' + c.color + ';' +
                'padding: 16px 24px; border-radius: 12px;' +
                'box-shadow: 0 10px 40px rgba(0,0,0,0.2); z-index: 10000;' +
                'font-family: Poppins, sans-serif; font-size: 14px;' +
                'display: flex; align-items: center; gap: 12px;' +
                'animation: slideInRight 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);' +
                'min-width: 280px; max-width: 400px;';
            notification.innerHTML =
                '<i class="fas ' + c.icon + '" style="font-size: 24px;"></i>' +
                '<span style="font-weight: 500;">' + escapeHtml(message) + '</span>';

            document.body.appendChild(notification);

            setTimeout(function () {
                notification.style.transform = 'translateX(120%)';
                notification.style.opacity = '0';
                notification.style.transition = 'all 0.4s ease';
                setTimeout(function () {
                    notification.remove();
                }, 400);
            }, 3500);
        }

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
@endpush
@endif
@endsection
