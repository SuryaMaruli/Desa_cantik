@extends('layouts.app')

@section('title', 'Galeri Kegiatan - Kelurahan Gunung Sugih')

@push('styles')
<style>
    @include('partials.galeri-kegiatan-styles')

    body {
        background-color: #f9fafb;
        color: #333;
    }

    .gallery-page-header {
        background-color: #F6903A;
        color: white;
        padding: 60px 0;
        margin-bottom: 40px;
    }

    .gallery-page-container {
        width: 95%;
        max-width: none;
        margin: 0 auto;
        padding: 0 20px;
    }

    .gallery-page-header h1 {
        font-size: 2.8rem;
        font-weight: 700;
        margin-bottom: 14px;
    }

    .gallery-page-header .subtitle {
        max-width: 760px;
        font-size: 1.05rem;
        line-height: 1.7;
        margin: 0 0 6px;
        opacity: 0.95;
    }

    .gallery-page {
        padding-bottom: 60px;
    }

    .gallery-page .section-title {
        color: #1f3b5d;
        font-size: 22px;
        font-weight: 700;
        margin: 0 0 25px;
        text-align: left;
    }

    .gallery-page .grid-3 {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 30px;
    }

    @media (max-width: 768px) {
        .gallery-page-header {
            padding: 32px 0;
        }

        .gallery-page-header h1 {
            font-size: 2rem;
        }

        .gallery-page-header .subtitle {
            font-size: 15px;
        }

        .gallery-page .grid-3 {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
<header class="gallery-page-header">
    <div class="gallery-page-container">
        <h1>Galeri Kegiatan</h1>
        <p class="subtitle">Dokumentasi kegiatan, agenda, dan momen penting Kelurahan Gunung Sugih.</p>
        <p class="subtitle">Kelurahan Gunung Sugih</p>
    </div>
</header>

<main class="gallery-page">
    <div class="gallery-page-container">
        @include('partials.galeri-kegiatan-content', ['galeri' => $galeri])
    </div>
</main>
@endsection
