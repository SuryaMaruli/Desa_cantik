@extends('layouts.admin')

@section('title', 'Detail Berita')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-1">Detail Berita</h4>
            <p class="text-muted mb-0">Informasi lengkap berita</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.berita.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
            <a href="{{ route('admin.berita.edit', ['beritum' => $berita->id]) }}" class="btn btn-primary">
                <i class="fas fa-edit me-1"></i> Edit
            </a>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <h3 class="mb-2">{{ $berita->judul }}</h3>

            <div class="row g-3 mb-3">
                <div class="col-md-3">
                    <small class="text-muted d-block">Tanggal Publikasi</small>
                    <strong>{{ \Carbon\Carbon::parse($berita->tanggal_publikasi)->translatedFormat('d F Y') }}</strong>
                </div>
                <div class="col-md-3">
                    <small class="text-muted d-block">Penulis</small>
                    <strong>{{ $berita->penulis ?? '-' }}</strong>
                </div>
                <div class="col-md-3">
                    <small class="text-muted d-block">Kategori</small>
                    <strong>{{ $berita->kategori ?? '-' }}</strong>
                </div>
                <div class="col-md-3">
                    <small class="text-muted d-block">Status</small>
                    @if($berita->is_published)
                        <span class="badge bg-success">Dipublikasikan</span>
                    @else
                        <span class="badge bg-secondary">Draft</span>
                    @endif
                </div>
            </div>

            @if(!empty($berita->gambar))
                <div class="mb-4">
                    <small class="text-muted d-block mb-2">Gambar</small>
                    <img src="{{ asset('storage/berita/' . $berita->gambar) }}"
                         alt="{{ $berita->judul }}"
                         class="img-fluid rounded"
                         style="max-height: 360px; object-fit: cover;">
                </div>
            @endif

            @if(!empty($berita->excerpt))
                <div class="mb-3">
                    <small class="text-muted d-block mb-1">Ringkasan</small>
                    <p class="mb-0">{{ $berita->excerpt }}</p>
                </div>
            @endif

            <div>
                <small class="text-muted d-block mb-1">Konten</small>
                <div class="p-3 bg-light rounded">
                    {!! nl2br(e($berita->konten)) !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
