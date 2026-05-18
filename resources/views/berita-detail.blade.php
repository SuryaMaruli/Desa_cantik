@extends('layouts.app')

@section('title', $berita->judul . ' - Berita & Informasi - Kelurahan Citangkil')

@section('content')
@php
    $fotos = $berita->relationLoaded('fotos') ? $berita->fotos : $berita->fotos()->orderBy('urutan')->get();
    if ($fotos->isEmpty() && $berita->gambar) {
        $fotos = collect([(object)['foto' => $berita->gambar]]);
    }
@endphp

<style>
    body { background-color: #f9fafb; color: #333; font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; }
    .container { max-width: 860px; margin: 0 auto; padding: 100px 20px 40px; }
    .back-link { display:inline-flex; align-items:center; gap:8px; color:#F03E15; text-decoration:none; font-weight:600; margin-bottom:30px; transition:gap .2s; }
    .back-link:hover { gap:12px; }
    .article-header { text-align:center; margin-bottom:40px; }
    .article-category { display:inline-block; background:#FEF3C7; color:#D97706; padding:6px 16px; border-radius:20px; font-size:13px; font-weight:600; margin-bottom:20px; }
    .article-title { font-size:2.5rem; color:#1F2937; margin-bottom:20px; font-weight:700; line-height:1.3; }
    .article-meta { display:flex; justify-content:center; align-items:center; gap:30px; color:#6B7280; font-size:14px; margin-bottom:30px; }
    .meta-item { display:flex; align-items:center; gap:6px; }

    .ig-carousel { margin-bottom: 30px; }
    .ig-main {
        width: 100%;
        min-height: 200px;
        background: #f3f4f6;
        border-radius: 12px;
        overflow: hidden;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .ig-main img {
        max-width: 100%;
        max-height: 70vh;
        height: auto;
        width: auto;
        object-fit: contain;
        display: none;
    }
    .ig-main img.active { display: block; }
    .ig-nav {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 38px;
        height: 38px;
        border: none;
        border-radius: 50%;
        background: rgba(0,0,0,.45);
        color: #fff;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }
    .ig-nav.prev { left: 12px; }
    .ig-nav.next { right: 12px; }

    .ig-dots {
        display: flex;
        justify-content: center;
        gap: 8px;
        margin: 12px 0;
    }
    .ig-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #d1d5db;
        cursor: pointer;
    }
    .ig-dot.active { background: #111827; }

    .ig-thumbs {
        display: flex;
        gap: 8px;
        overflow-x: auto;
        padding-bottom: 4px;
    }
    .ig-thumb {
        width: 76px;
        height: 76px;
        flex-shrink: 0;
        border-radius: 8px;
        object-fit: cover;
        border: 2px solid transparent;
        cursor: pointer;
    }
    .ig-thumb.active {
        border-color: #f97316;
    }

    .article-image-fallback {
        width:100%;
        height:400px;
        background:#f3f4f6;
        border-radius:12px;
        margin-bottom:30px;
        display:flex;
        align-items:center;
        justify-content:center;
        color:#9CA3AF;
        font-size:3rem;
        overflow:hidden;
    }

    .article-content { background:#fff; border-radius:12px; padding:40px; box-shadow:0 4px 15px rgba(0,0,0,.03); line-height:1.8; font-size:16px; color:#374151; }
    .article-content h2 { color:#1F2937; font-size:1.5rem; font-weight:600; margin:30px 0 15px; }
    .article-content h3 { color:#1F2937; font-size:1.2rem; font-weight:600; margin:25px 0 10px; }
    .article-content p { margin-bottom:20px; }
    .article-content ul, .article-content ol { margin-bottom:20px; padding-left:30px; }
    .article-content li { margin-bottom:8px; }

    @media (max-width: 768px) {
        .container { padding:80px 20px 30px; }
        .article-title { font-size:2rem; }
        .ig-main { height: 300px; }
        .article-content { padding:25px; }
    }
</style>

<div class="container">
    <a href="/berita" class="back-link">
        <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 1 .708-.708L1.707 7.5a.5.5 0 0 1 0-.708l4.146-4.146a.5.5 0 0 1 .708 0l3.147 3.146H1.5A.5.5 0 0 0 1 8z"/></svg>
        Kembali ke Berita
    </a>

    <div class="article-header">
        <span class="article-category">{{ $berita->kategori ?? 'Umum' }}</span>
        <h1 class="article-title">{{ $berita->judul }}</h1>

        <div class="article-meta">
            <div class="meta-item">
                <svg width="14" height="14" fill="currentColor" viewBox="0 0 16 16"><path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/></svg>
                {{ \Carbon\Carbon::parse($berita->tanggal_publikasi)->format('d F Y') }}
            </div>
            <div class="meta-item">
                <svg width="14" height="14" fill="currentColor" viewBox="0 0 16 16"><path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4z"/></svg>
                {{ $berita->penulis ?? 'Admin Kelurahan' }}
            </div>
        </div>
    </div>

    @if($fotos->count() > 0)
        <div class="ig-carousel" id="igCarousel">
            <div class="ig-main">
                @foreach($fotos as $idx => $foto)
                    <img
                        src="{{ asset('storage/berita/' . $foto->foto) }}"
                        class="ig-main-img {{ $idx === 0 ? 'active' : '' }}"
                        data-index="{{ $idx }}"
                        alt="Foto berita {{ $idx + 1 }}"
                    >
                @endforeach

                @if($fotos->count() > 1)
                    <button class="ig-nav prev" type="button" id="igPrev">&#10094;</button>
                    <button class="ig-nav next" type="button" id="igNext">&#10095;</button>
                @endif
            </div>

            @if($fotos->count() > 1)
                <div class="ig-dots" id="igDots">
                    @foreach($fotos as $idx => $foto)
                        <span class="ig-dot {{ $idx === 0 ? 'active' : '' }}" data-index="{{ $idx }}"></span>
                    @endforeach
                </div>

                <div class="ig-thumbs" id="igThumbs">
                    @foreach($fotos as $idx => $foto)
                        <img
                            src="{{ asset('storage/berita/' . $foto->foto) }}"
                            class="ig-thumb {{ $idx === 0 ? 'active' : '' }}"
                            data-index="{{ $idx }}"
                            alt="Thumbnail {{ $idx + 1 }}"
                        >
                    @endforeach
                </div>
            @endif
        </div>
    @else
        <div class="article-image-fallback">📰</div>
    @endif

    <div class="article-content">
        {!! $berita->konten !!}
    </div>
</div>

@if($fotos->count() > 1)
<script>
    (function () {
        const images = Array.from(document.querySelectorAll('.ig-main-img'));
        const dots = Array.from(document.querySelectorAll('.ig-dot'));
        const thumbs = Array.from(document.querySelectorAll('.ig-thumb'));
        const prevBtn = document.getElementById('igPrev');
        const nextBtn = document.getElementById('igNext');

        let current = 0;

        function render(index) {
            current = index;
            images.forEach((img, i) => img.classList.toggle('active', i === current));
            dots.forEach((dot, i) => dot.classList.toggle('active', i === current));
            thumbs.forEach((th, i) => th.classList.toggle('active', i === current));
        }

        function next() {
            render((current + 1) % images.length);
        }

        function prev() {
            render((current - 1 + images.length) % images.length);
        }

        if (nextBtn) nextBtn.addEventListener('click', next);
        if (prevBtn) prevBtn.addEventListener('click', prev);

        dots.forEach(dot => {
            dot.addEventListener('click', () => render(parseInt(dot.dataset.index, 10)));
        });

        thumbs.forEach(th => {
            th.addEventListener('click', () => render(parseInt(th.dataset.index, 10)));
        });
    })();
</script>
@endif
@endsection
