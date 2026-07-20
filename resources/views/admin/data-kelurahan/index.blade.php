@extends('layouts.admin')

@section('page-title', 'Data Kelurahan')

@push('styles')
<style>
    .data-page { padding: 24px; }
    .data-header-card {
        background: linear-gradient(135deg, #f97316, #0f766e);
        border-radius: 12px;
        color: #fff;
        padding: 24px;
        margin-bottom: 24px;
        box-shadow: 0 14px 32px rgba(15, 118, 110, 0.18);
    }
    .data-header-card h3 { margin: 0 0 8px; font-size: 24px; font-weight: 700; }
    .data-header-card p { margin: 0; max-width: 760px; color: rgba(255, 255, 255, 0.9); }
    .alert-success { background: #dcfce7; border: 1px solid #86efac; border-radius: 8px; color: #166534; margin-bottom: 18px; padding: 12px 14px; }

    .subject-picker { background: #fff; border: 1px solid #e5e7eb; border-radius: 8px; box-shadow: 0 8px 22px rgba(15, 23, 42, 0.06); margin-bottom: 18px; padding: 18px; }
    .subject-picker-top { align-items: flex-start; display: flex; gap: 14px; justify-content: space-between; margin-bottom: 14px; }
    .subject-picker-title { align-items: center; display: flex; gap: 10px; }
    .subject-picker-title i { align-items: center; background: #ecfdf5; border-radius: 8px; color: #0f766e; display: inline-flex; font-size: 22px; height: 40px; justify-content: center; width: 40px; }
    .subject-picker-title h4 { color: #111827; font-size: 17px; font-weight: 750; margin: 0; }
    .subject-picker-title p { color: #64748b; font-size: 14px; line-height: 1.5; margin: 3px 0 0; }
    .subject-picker-actions { display: flex; flex-wrap: wrap; gap: 8px; justify-content: flex-end; }
    .subject-mini-btn { align-items: center; background: #f8fafc; border: 1px solid #dbe3ee; border-radius: 8px; color: #334155; cursor: pointer; display: inline-flex; font-size: 13px; font-weight: 700; gap: 6px; min-height: 36px; padding: 8px 11px; }
    .subject-mini-btn:hover { background: #ecfdf5; border-color: #0f766e; color: #0f766e; }
    .subject-choice-grid { display: grid; gap: 12px; grid-template-columns: repeat(auto-fit, minmax(210px, 1fr)); }
    .subject-choice { align-items: flex-start; background: #f8fafc; border: 1px solid #e5e7eb; border-radius: 8px; color: #111827; cursor: pointer; display: flex; gap: 12px; min-height: 92px; padding: 14px; position: relative; text-align: left; transition: border-color .2s ease, box-shadow .2s ease, transform .2s ease, background .2s ease; width: 100%; }
    .subject-choice:hover, .subject-choice:focus { background: #fff; border-color: #f97316; box-shadow: 0 12px 26px rgba(249, 115, 22, 0.14); outline: none; transform: translateY(-2px); }
    .subject-choice.is-active { background: #fff7ed; border-color: #f97316; box-shadow: inset 0 0 0 1px #f97316, 0 12px 26px rgba(15, 118, 110, 0.10); }
    .subject-choice.is-active::after { align-items: center; background: #0f766e; border-radius: 999px; color: #fff; content: '\2713'; display: inline-flex; font-size: 12px; font-weight: 800; height: 22px; justify-content: center; position: absolute; right: 10px; top: 10px; width: 22px; }
    .subject-choice-icon { align-items: center; background: #fff; border: 1px solid #e5e7eb; border-radius: 8px; color: #0f766e; display: inline-flex; flex: 0 0 42px; font-size: 23px; height: 42px; justify-content: center; width: 42px; }
    .subject-choice.is-active .subject-choice-icon { background: #0f766e; border-color: #0f766e; color: #fff; }
    .subject-choice-name { display: block; font-size: 14px; font-weight: 750; line-height: 1.35; padding-right: 20px; }
    .subject-choice-meta { color: #64748b; display: block; font-size: 12px; font-weight: 600; margin-top: 6px; }
    .subject-choice.is-active .subject-choice-meta { color: #9a3412; }

    .empty-state { align-items: center; background: #fff; border: 1px dashed #cbd5e1; border-radius: 8px; color: #64748b; display: flex; gap: 10px; min-height: 112px; padding: 20px; }
    .empty-state i { color: #0f766e; font-size: 25px; }

    .subject-stack { display: grid; gap: 18px; }
    .subject-panel { background: #fff; border: 1px solid #e5e7eb; border-radius: 8px; box-shadow: 0 8px 22px rgba(15, 23, 42, 0.06); display: none; overflow: hidden; }
    .subject-panel.is-active { display: block; animation: subjectReveal .22s ease; }
    @keyframes subjectReveal { from { opacity: 0; transform: translateY(8px); } to { opacity: 1; transform: translateY(0); } }
    .subject-header { align-items: center; background: #f8fafc; border-bottom: 1px solid #e5e7eb; display: flex; gap: 12px; padding: 16px 18px; }
    .subject-icon { align-items: center; background: #fff7ed; border-radius: 8px; color: #ea580c; display: inline-flex; flex: 0 0 42px; font-size: 23px; height: 42px; justify-content: center; width: 42px; }
    .subject-title { color: #111827; font-size: 18px; font-weight: 700; line-height: 1.35; margin: 0; }
    .dataset-list { display: grid; gap: 0; }
    .dataset-row { border-bottom: 1px solid #eef2f7; display: grid; gap: 14px; grid-template-columns: minmax(260px, 1fr) minmax(180px, 240px); padding: 16px 18px; }
    .dataset-row:last-child { border-bottom: 0; }
    .dataset-name { color: #1f2937; font-size: 15px; font-weight: 650; line-height: 1.45; }
    .dataset-children { display: grid; gap: 10px; margin-top: 12px; }
    .child-row { align-items: center; display: grid; gap: 12px; grid-template-columns: minmax(180px, 1fr) minmax(160px, 220px); }
    .child-label { color: #64748b; font-size: 14px; line-height: 1.4; padding-left: 14px; position: relative; }
    .child-label::before { background: #cbd5e1; border-radius: 999px; content: ''; height: 5px; left: 0; position: absolute; top: 8px; width: 5px; }
    .value-input { border: 1px solid #d1d5db; border-radius: 8px; color: #111827; font-size: 14px; height: 42px; padding: 9px 12px; width: 100%; }
    .value-input:focus { border-color: #f97316; box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.14); outline: none; }
    .form-footer { display: none; justify-content: flex-end; margin-top: 22px; }
    .form-footer.is-active { display: flex; }
    .btn-save-data { align-items: center; background: #0f766e; border: 0; border-radius: 8px; color: #fff; cursor: pointer; display: inline-flex; font-size: 15px; font-weight: 700; gap: 8px; min-height: 44px; padding: 10px 18px; }
    .btn-save-data:hover { background: #115e59; }

    @media (max-width: 768px) {
        .data-page { padding: 16px; }
        .subject-picker-top { flex-direction: column; }
        .subject-picker-actions { justify-content: flex-start; }
        .dataset-row, .child-row { grid-template-columns: 1fr; }
    }
</style>
@endpush

@section('content')
<div class="data-page">
    <div class="data-header-card">
        <h3>Data Kelurahan</h3>
        <p>Pilih satu atau beberapa subjek, lalu isi nilai dataset statistik yang tersedia.</p>
    </div>

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.data-kelurahan.store') }}" method="POST">
        @csrf

        <div class="subject-picker" aria-labelledby="adminSubjectPickerTitle">
            <div class="subject-picker-top">
                <div class="subject-picker-title">
                    <i class='bx bx-category-alt'></i>
                    <div>
                        <h4 id="adminSubjectPickerTitle">Pilih Subjek Data</h4>
                        <p>Aktifkan beberapa kartu subjek untuk mengisi banyak dataset sekaligus.</p>
                    </div>
                </div>
                <div class="subject-picker-actions">
                    <button type="button" class="subject-mini-btn" id="adminSelectAllSubjects"><i class='bx bx-select-multiple'></i> Pilih Semua</button>
                    <button type="button" class="subject-mini-btn" id="adminClearSubjects"><i class='bx bx-x'></i> Bersihkan</button>
                </div>
            </div>
            <div class="subject-choice-grid" role="listbox" aria-label="Subjek Data" aria-multiselectable="true">
                @foreach($subjects as $subject)
                    @php($datasetCount = count($subject['datasets'] ?? []))
                    <button type="button" class="subject-choice" data-subject-choice="{{ $subject['key'] }}" role="option" aria-selected="false" aria-pressed="false">
                        <span class="subject-choice-icon"><i class='bx {{ $subject['icon'] ?? 'bx-data' }}'></i></span>
                        <span>
                            <span class="subject-choice-name">{{ $subject['name'] }}</span>
                            <span class="subject-choice-meta">{{ $datasetCount }} dataset utama</span>
                        </span>
                    </button>
                @endforeach
            </div>
        </div>

        <div class="empty-state" id="adminEmptyState">
            <i class='bx bx-pointer'></i>
            <span>Silakan pilih satu atau beberapa subjek data untuk mulai mengisi.</span>
        </div>

        <div class="subject-stack">
            @foreach($subjects as $subject)
                <section class="subject-panel" data-subject-panel="{{ $subject['key'] }}">
                    <div class="subject-header">
                        <span class="subject-icon"><i class='bx {{ $subject['icon'] ?? 'bx-data' }}'></i></span>
                        <h4 class="subject-title">{{ $subject['name'] }}</h4>
                    </div>

                    <div class="dataset-list">
                        @foreach($subject['datasets'] as $dataset)
                            @php($datasetValue = optional($values->get($dataset['key']))->value)
                            <div class="dataset-row">
                                <div>
                                    <div class="dataset-name">{{ $dataset['name'] }}</div>

                                    @if(!empty($dataset['children']))
                                        <div class="dataset-children">
                                            @foreach($dataset['children'] as $child)
                                                @php($childValue = optional($values->get($child['key']))->value)
                                                <div class="child-row">
                                                    <label class="child-label" for="value_{{ $child['key'] }}">{{ $child['name'] }}</label>
                                                    <input class="value-input" id="value_{{ $child['key'] }}" type="number" min="0" step="0.01" name="values[{{ $child['key'] }}]" value="{{ old('values.' . $child['key'], $childValue) }}" placeholder="0">
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>

                                @if(empty($dataset['children']))
                                    <input class="value-input" id="value_{{ $dataset['key'] }}" type="number" min="0" step="0.01" name="values[{{ $dataset['key'] }}]" value="{{ old('values.' . $dataset['key'], $datasetValue) }}" placeholder="0" aria-label="{{ $dataset['name'] }}">
                                @else
                                    <input type="hidden" name="values[{{ $dataset['key'] }}]" value="{{ old('values.' . $dataset['key'], $datasetValue) }}">
                                @endif
                            </div>
                        @endforeach
                    </div>
                </section>
            @endforeach
        </div>

        <div class="form-footer" id="adminFormFooter">
            <button class="btn-save-data" type="submit"><i class='bx bx-save'></i> Simpan Data</button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const emptyState = document.getElementById('adminEmptyState');
        const footer = document.getElementById('adminFormFooter');
        const panels = document.querySelectorAll('[data-subject-panel]');
        const choices = document.querySelectorAll('[data-subject-choice]');
        const activeSubjects = new Set();

        function renderSubjects() {
            choices.forEach(choice => {
                const isActive = activeSubjects.has(choice.dataset.subjectChoice);
                choice.classList.toggle('is-active', isActive);
                choice.setAttribute('aria-selected', isActive ? 'true' : 'false');
                choice.setAttribute('aria-pressed', isActive ? 'true' : 'false');
            });
            panels.forEach(panel => panel.classList.toggle('is-active', activeSubjects.has(panel.dataset.subjectPanel)));
            emptyState.style.display = activeSubjects.size ? 'none' : 'flex';
            footer.classList.toggle('is-active', activeSubjects.size > 0);
        }

        choices.forEach(choice => {
            choice.addEventListener('click', () => {
                const subjectKey = choice.dataset.subjectChoice;
                activeSubjects.has(subjectKey) ? activeSubjects.delete(subjectKey) : activeSubjects.add(subjectKey);
                renderSubjects();
            });
        });

        document.getElementById('adminSelectAllSubjects')?.addEventListener('click', () => {
            choices.forEach(choice => activeSubjects.add(choice.dataset.subjectChoice));
            renderSubjects();
        });

        document.getElementById('adminClearSubjects')?.addEventListener('click', () => {
            activeSubjects.clear();
            renderSubjects();
        });

        renderSubjects();
    });
</script>
@endpush
