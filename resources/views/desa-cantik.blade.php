@extends('layouts.app')

@section('title', 'Program Desa Cantik - Kelurahan Citangkil')

@section('content')
    <style>
        /* --- CSS DASAR --- */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
            color: #333;
            line-height: 1.6;
            overflow-x: hidden;
        }

        .container {
            width: 95%;
            max-width: none;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Header Hijau */
        .main-header {
            background-color: #F6903A;
            color: white;
            padding-top: 60px;
            padding-bottom: 80px;
        }

        .main-header h1 {
            font-size: 2.5rem;
            font-weight: 400;
            margin-bottom: 15px;
        }

        .main-header .subtitle {
            font-size: 1rem;
            opacity: 0.9;
            margin-bottom: 5px;
            font-weight: 300;
        }

        main {
            padding-top: 40px;
            padding-bottom: 80px;
        }

        /* Judul Section */
        .section-title {
            text-align: center;
            color: #F6903A; /* Warna Hijau Teal */
            font-size: 1.8rem;
            font-weight: 600;
            text-transform: uppercase;
            margin-bottom: 40px;
            letter-spacing: 1px;
        }

        .section-title.metadata {
            color: #C8461F; /* Warna oranye/merah bata */
        }

        /* --- KARTU DESKRIPSI UTAMA --- */
        .main-card {
            background-color: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
        }

        .main-card h2 {
            color: #c75310ff;
            font-size: 1.8rem;
            font-weight: 400;
            margin-bottom: 25px;
        }

        .main-card p {
            color: #555;
            margin-bottom: 20px;
            font-size: 0.95rem;
            text-align: justify;
        }

        /* --- GRID SYSTEMS --- */
        .grid-3 {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
            margin-bottom: 40px;
        }

        .grid-2 {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 25px;
        }

        /* --- INFO CARDS (Metadata, Output & Prestasi) --- */
        .info-card {
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.03);
            display: flex;
            flex-direction: column;
            /* Default alignment kiri untuk metadata/output */
            align-items: flex-start; 
            height: 100%;
        }

        .icon-box {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 25px;
            font-size: 20px;
        }

        /* Tema Warna Kartu (Hijau, Biru, Ungu) */
        .card-theme-green { background-color: #E9F7F3; }
        .card-theme-green .icon-box { background-color: #C0EBE1; color: #009688; }

        .card-theme-blue { background-color: #EBF3FB; }
        .card-theme-blue .icon-box { background-color: #CDE4F7; color: #2196F3; }

        .card-theme-purple { background-color: #F5EFF8; }
        .card-theme-purple .icon-box { background-color: #E6CEF2; color: #9C27B0; }

        /* Typography Kartu Info */
        .info-card h3 {
            font-size: 1rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 15px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .info-card p {
            font-size: 0.9rem;
            color: #666;
            line-height: 1.5;
        }

        /* --- CSS KHUSUS BAGIAN PRESTASI (BARU) --- */
        /* Tema Oranye/Krem untuk Prestasi */
        .card-theme-orange {
            background-color: #FFFBE6; /* Latar belakang krem kekuningan */
            align-items: center; /* Override: konten di tengah */
            text-align: center; /* Teks di tengah */
        }

        .card-theme-orange .icon-box {
            background-color: #FF9800; /* Ikon oranye */
            color: white;
            width: 64px; /* Ukuran ikon lebih besar dan bulat */
            height: 64px;
            font-size: 28px;
            border-radius: 50%; /* Bentuk lingkaran */
        }

        .achievement-year {
            color: #FF9800;
            font-weight: 700;
            font-size: 1.1rem;
            margin-bottom: 10px;
        }


        /* --- GALERI KEGIATAN --- */
        .gallery-card {
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 10px 28px rgba(15, 23, 42, 0.08);
            border: 1px solid rgba(15, 23, 42, 0.06);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .gallery-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 16px 34px rgba(15, 23, 42, 0.12);
        }

        .gallery-img-placeholder {
            width: 100%;
            height: 180px;
            background-color: #EEEEEE;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
        }

.gallery-img-container {
            width: 100%;
            /* height: 280px; */ /* Removed fixed height */
            aspect-ratio: 4 / 3;
            overflow: hidden;
            border-radius: 8px;
            position: relative;
            background: rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            cursor: zoom-in;
        }

        /* Adjust aspect ratio for different image sizes */
        .gallery-img-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .gallery-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .gallery-card:hover .gallery-img {
            transform: scale(1.05);
        }

        .gallery-carousel {
            position: relative;
            width: 100%;
            height: 100%;
        }

        .gallery-carousel-slide {
            position: absolute;
            inset: 0;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.25s ease;
        }

        .gallery-carousel-slide.active {
            opacity: 1;
            pointer-events: auto;
        }

        .gallery-carousel-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 32px;
            height: 32px;
            border: 0;
            border-radius: 50%;
            background: rgba(17, 24, 39, 0.72);
            color: white;
            z-index: 5;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        .gallery-carousel-btn:hover {
            background: rgba(17, 24, 39, 0.9);
        }

        .gallery-carousel-prev {
            left: 10px;
        }

        .gallery-carousel-next {
            right: 10px;
        }

        .gallery-carousel-counter,
        .gallery-group-badge {
            position: absolute;
            top: 10px;
            z-index: 6;
            padding: 4px 9px;
            border-radius: 999px;
            background: rgba(17, 24, 39, 0.72);
            color: white;
            font-size: 11px;
            font-weight: 600;
        }

        .gallery-carousel-counter {
            right: 10px;
        }

        .gallery-group-badge {
            left: 10px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .gallery-carousel-dots {
            position: absolute;
            left: 0;
            right: 0;
            bottom: 10px;
            z-index: 6;
            display: flex;
            justify-content: center;
            gap: 6px;
        }

        .gallery-carousel-dot {
            width: 7px;
            height: 7px;
            padding: 0;
            border: 0;
            border-radius: 50%;
            background: rgba(255,255,255,0.55);
            cursor: pointer;
        }

        .gallery-carousel-dot.active {
            width: 18px;
            border-radius: 999px;
            background: white;
        }

        .ig-carousel {
            background: #fff;
            cursor: zoom-in;
        }

        .ig-main {
            width: 100%;
            aspect-ratio: 16 / 10;
            background: #f3f4f6;
            overflow: hidden;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .ig-main::after {
            content: "";
            position: absolute;
            inset: auto 0 0 0;
            height: 45%;
            background: linear-gradient(180deg, rgba(15, 23, 42, 0) 0%, rgba(15, 23, 42, 0.48) 100%);
            pointer-events: none;
            z-index: 2;
        }

        .ig-main img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: none;
            transition: transform 0.35s ease;
        }

        .ig-main img.active {
            display: block;
        }

        .gallery-card:hover .ig-main img.active {
            transform: scale(1.035);
        }

        .ig-nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 36px;
            height: 36px;
            border: none;
            border-radius: 50%;
            background: rgba(15, 23, 42, 0.62);
            color: #fff;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            z-index: 6;
            transition: background 0.2s ease, transform 0.2s ease;
        }

        .ig-nav:hover {
            background: rgba(15, 23, 42, 0.86);
            transform: translateY(-50%) scale(1.04);
        }

        .ig-nav.prev { left: 12px; }
        .ig-nav.next { right: 12px; }

        .ig-dots {
            position: absolute;
            left: 0;
            right: 0;
            bottom: 12px;
            z-index: 5;
            display: flex;
            justify-content: center;
            gap: 7px;
            margin: 0;
        }

        .ig-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.62);
            cursor: pointer;
            box-shadow: 0 1px 4px rgba(15, 23, 42, 0.2);
            transition: width 0.2s ease, background 0.2s ease;
        }

        .ig-dot.active {
            width: 22px;
            border-radius: 999px;
            background: #fff;
        }

        .ig-thumbs {
            display: flex;
            gap: 6px;
            overflow-x: auto;
            padding: 10px 14px 12px;
            background: #fff;
            scrollbar-width: thin;
        }

        .ig-thumb {
            width: 54px;
            height: 42px;
            flex-shrink: 0;
            border-radius: 6px;
            object-fit: cover;
            border: 2px solid transparent;
            cursor: pointer;
            opacity: 0.66;
            transition: opacity 0.2s ease, border-color 0.2s ease, transform 0.2s ease;
        }

        .ig-thumb:hover {
            opacity: 0.9;
        }

        .ig-thumb.active {
            border-color: #f97316;
            opacity: 1;
            transform: translateY(-1px);
        }

        .gallery-photo-count,
        .gallery-expand-btn {
            position: absolute;
            z-index: 6;
            background: rgba(15, 23, 42, 0.72);
            color: white;
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
        }

        .gallery-photo-count {
            top: 12px;
            left: 12px;
            border-radius: 999px;
            padding: 5px 10px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            font-weight: 600;
        }

        .gallery-expand-btn {
            right: 12px;
            bottom: 12px;
            width: 34px;
            height: 34px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
        }

        .gallery-zoom-hint {
            position: absolute;
            right: 10px;
            bottom: 10px;
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: rgba(17, 24, 39, 0.72);
            color: white;
            z-index: 7;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.2s, background 0.2s;
        }

        .gallery-img-container:hover .gallery-zoom-hint {
            opacity: 1;
        }

        /* IG-style Modal Viewer */
        .gallery-viewer-modal .modal-content {
            background: #0f172a;
            color: white;
            border: 0;
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 28px 70px rgba(2, 6, 23, 0.42);
        }

        .gallery-viewer-stage {
            position: relative;
            min-height: 64vh;
            background: #020617;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            cursor: zoom-in;
            user-select: none;
        }

        .gallery-viewer-stage img {
            max-width: 100%;
            max-height: 72vh;
            object-fit: contain;
            display: block;
            transform-origin: center center;
            transition: transform 0.16s ease;
            will-change: transform;
            user-select: none;
            -webkit-user-drag: none;
        }

        .gallery-viewer-stage.is-zoomed {
            cursor: grab;
        }

        .gallery-viewer-stage.is-dragging {
            cursor: grabbing;
        }

        .gallery-viewer-stage.is-dragging img {
            transition: none;
        }

        .gallery-viewer-stage img.active {
            display: block;
        }

        .gallery-zoom-toolbar {
            position: absolute;
            top: 16px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 15;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px;
            border-radius: 999px;
            background: rgba(15, 23, 42, 0.72);
            border: 1px solid rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            box-shadow: 0 10px 28px rgba(2, 6, 23, 0.24);
        }

        .gallery-zoom-btn {
            width: 34px;
            height: 34px;
            border: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background 0.2s ease, transform 0.2s ease;
        }

        .gallery-zoom-btn:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-1px);
        }

        .gallery-zoom-level {
            min-width: 52px;
            color: rgba(255, 255, 255, 0.84);
            font-size: 12px;
            font-weight: 700;
            text-align: center;
        }

        .gallery-viewer-nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 42px;
            height: 42px;
            border: 0;
            border-radius: 50%;
            background: rgba(255,255,255,0.14);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            cursor: pointer;
            z-index: 10;
        }

        .gallery-viewer-nav:hover {
            background: rgba(255,255,255,0.24);
        }

        .gallery-viewer-prev {
            left: 16px;
        }

        .gallery-viewer-next {
            right: 16px;
        }

        .gallery-viewer-dots {
            display: flex;
            justify-content: center;
            gap: 8px;
            padding: 12px 0;
        }

        .gallery-viewer-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: rgba(255,255,255,0.4);
            cursor: pointer;
            border: 0;
            padding: 0;
        }

        .gallery-viewer-dot.active {
            background: #fff;
        }

        .gallery-viewer-info {
            padding: 22px 26px 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            background:
                linear-gradient(135deg, rgba(246, 144, 58, 0.12), rgba(15, 23, 42, 0) 42%),
                #0f172a;
        }

        .gallery-viewer-heading {
            display: grid;
            grid-template-columns: minmax(0, 1fr) auto;
            gap: 18px;
            align-items: flex-start;
            margin-bottom: 14px;
        }

        .gallery-viewer-eyebrow {
            color: #fbbf24;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            margin-bottom: 7px;
        }

        .gallery-viewer-title {
            font-size: 20px;
            font-weight: 700;
            line-height: 1.35;
            margin: 0;
            color: #ffffff;
        }

        .gallery-viewer-counter {
            min-width: 58px;
            padding: 6px 10px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.12);
            color: rgba(255, 255, 255, 0.78);
            font-size: 12px;
            font-weight: 600;
            text-align: center;
            white-space: nowrap;
        }

        .gallery-viewer-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 14px;
        }

        .gallery-viewer-badge {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 6px 10px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.12);
            color: rgba(255, 255, 255, 0.82);
            font-size: 12px;
            font-weight: 600;
        }

        .gallery-viewer-description {
            position: relative;
            margin: 0;
            padding-left: 16px;
            color: rgba(255, 255, 255, 0.84);
            font-size: 14px;
            line-height: 1.75;
            max-width: 920px;
        }

        .gallery-viewer-description::before {
            content: "";
            position: absolute;
            left: 0;
            top: 6px;
            bottom: 6px;
            width: 3px;
            border-radius: 999px;
            background: #F6903A;
        }

        .gallery-viewer-thumbs {
            display: flex;
            gap: 8px;
            overflow-x: auto;
            padding: 12px 18px 18px;
        }

        .gallery-viewer-thumb {
            width: 72px;
            height: 72px;
            border: 2px solid transparent;
            border-radius: 8px;
            padding: 0;
            overflow: hidden;
            background: transparent;
            flex: 0 0 auto;
            cursor: pointer;
        }

        .gallery-viewer-thumb.active {
            border-color: #F6903A;
        }

        .gallery-viewer-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Metadata Statistik Cards */
        .cards-wrapper {
            display: flex;
            gap: 30px;
            justify-content: center;
            flex-wrap: wrap;
            margin-bottom: 60px;
        }

        .card {
            flex: 1;
            min-width: 300px;
            border-radius: 20px;
            padding: 40px 30px;
            text-align: left;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card-cream {
            background-color: #FFFCF5;
        }

        .card-pink {
            background-color: #FFF5F4;
        }

        .card .icon-box {
            background-color: #ffffff;
            width: 70px;
            height: 70px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 25px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            border: 1px solid rgba(0,0,0,0.02);
        }

        .card .icon-box svg {
            width: 32px;
            height: 32px;
            color: #C8461F;
        }

        .card h3 {
            color: #333;
            font-size: 18px;
            margin-bottom: 15px;
            font-weight: 600;
        }

        .card p {
            color: #666;
            font-size: 15px;
            line-height: 1.6;
        }

        /* Output Desa Cantik Section */
        .main-title {
            text-align: center;
            color: #c84e30;
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 40px;
        }

        .grid-wrapper {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
            margin-bottom: 60px;
        }

        .grid-wrapper .card {
            border-radius: 16px;
            padding: 32px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.03);
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            transition: transform 0.3s ease;
            height: 100%;
        }

        .grid-wrapper .card:hover {
            transform: translateY(-5px);
        }

        .bg-cream {
            background-color: #fffef5;
            border: 1px solid #fcf7e6;
        }

        .bg-pink {
            background-color: #fffafa;
            border: 1px solid #fcf0f0;
        }

        .grid-wrapper .icon-box {
            width: 50px;
            height: 50px;
            background-color: white;
            border-radius: 12px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 24px;
            border: 1px solid #eee;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
        }

        .grid-wrapper .icon-box i {
            color: #c84e30;
            font-size: 20px;
        }

        .grid-wrapper .card h3 {
            font-size: 14px;
            font-weight: 700;
            text-transform: uppercase;
            color: #2c2c2c;
            line-height: 1.5;
            margin-bottom: 12px;
            letter-spacing: 0.3px;
        }

        .grid-wrapper .card p {
            font-size: 14px;
            color: #666;
            line-height: 1.5;
            margin-bottom: 16px;
        }

        .detail-btn {
            display: inline-block;
            background-color: #F6903A;
            color: white;
            padding: 8px 16px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            margin-top: auto;
        }

        .detail-btn:hover {
            background-color: #e57d2b;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(246, 144, 58, 0.3);
        }

        /* Metadata Links Hover Effects */
        .pdf-preview-link:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            border-color: #ced4da !important;
        }

        .pdf-preview-link:hover .pdf-thumbnail {
            background: linear-gradient(135deg, #e9ecef 0%, #dee2e6 100%) !important;
        }

        .link-external:hover {
            background-color: #d1e7ff !important;
            border-color: #99ccff !important;
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0,102,204,0.2);
        }

        .gallery-content {
            padding: 18px 18px 20px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .gallery-title {
            font-size: 1.02rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 8px;
            line-height: 1.35;
        }

        .gallery-subtitle {
            margin-top: auto;
            font-size: 0.84rem;
            color: #6b7280;
            display: inline-flex;
            align-items: center;
            gap: 7px;
        }

        .gallery-description {
            font-size: 0.9rem;
            color: #4b5563;
            margin-bottom: 14px;
            line-height: 1.6;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .gallery-category {
            align-self: flex-start;
            display: inline-flex;
            align-items: center;
            background-color: #fff4e8;
            color: #b45309;
            font-size: 0.72rem;
            font-weight: 600;
            padding: 5px 10px;
            border-radius: 999px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 10px;
        }

        .gallery-category.more {
            background-color: #f3f4f6;
            color: #4b5563;
        }

        .gallery-category.kegagalan {
            background-color: #ecfdf5;
            color: #047857;
        }

        .gallery-category.pengumuman {
            background-color: #fef2f2;
            color: #b91c1c;
        }

        .gallery-category.pelatihan {
            background-color: #eff6ff;
            color: #1d4ed8;
        }

        .gallery-category.sosialisasi {
            background-color: #f5f3ff;
            color: #6d28d9;
        }

        /* --- RESPONSIVE --- */
        @media (max-width: 768px) {
            .main-header { padding: 40px 0; }
            .main-header h1 { font-size: 2rem; }
            .main-card { padding: 25px; }
            .section-title { font-size: 1.5rem; margin-top: 50px; }
            
            /* Grid menjadi 1 kolom di HP */
            .grid-3, .grid-2 {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            /* Output Desa Cantik Responsive */
            .grid-wrapper {
                grid-template-columns: 1fr;
            }
            
            .main-title {
                font-size: 24px;
                margin-bottom: 30px;
            }

            .ig-main {
                aspect-ratio: 4 / 3;
            }

            .ig-nav {
                width: 34px;
                height: 34px;
            }

            .ig-thumbs {
                padding: 8px 12px 10px;
            }

            .ig-thumb {
                width: 48px;
                height: 38px;
            }

            .gallery-content {
                padding: 16px;
            }

            .gallery-description {
                -webkit-line-clamp: 2;
            }

            .gallery-viewer-info {
                padding: 18px 18px 16px;
            }

            .gallery-viewer-heading {
                grid-template-columns: 1fr;
                gap: 10px;
            }

            .gallery-viewer-title {
                font-size: 17px;
            }

            .gallery-zoom-toolbar {
                top: 12px;
            }

            .gallery-zoom-btn {
                width: 32px;
                height: 32px;
            }
        }
    </style>

    <header class="main-header">
        <div class="container">
            <h1>Program Desa Cantik</h1>
            <p class="subtitle">Output Pembinaan Desa Cantik oleh BPS Kota Cilegon - Mirroring Website</p>
            <p class="subtitle">Kelurahan Citangkil</p>
        </div>
    </header>

    <main>
        <div class="container">
            
            <div class="main-card">
                <h2>Tentang Program Desa Cantik</h2>
                @if($tentang)
                    {!! $tentang->deskripsi !!}
                @else
                    <p>Desa Cinta Statistik, atau yang dikenal dengan Desa Cantik, adalah sebuah program yang bertujuan untuk meningkatkan kemampuan aparat desa dalam mengelola dan memanfaatkan data agar perencanaan pembangunan desa lebih tepat sasaran. Saat ini, desa-desa telah dibekali dengan berbagai aplikasi pendataan seperti SDGs Desa, Prodeskel (Profil Desa dan Kelurahan), dan SIKS-NG (Sistem Informasi Kesejahteraan Sosial Next Generation).</p>
                    <p>Namun, kualitas dan kapasitas sumber daya manusia di pemerintahan desa dalam hal pengelolaan dan literasi data masih tergolong rendah. Badan Pusat Statistik (BPS) sebagai lembaga yang membina statistik memiliki peranan penting dalam meningkatkan pengelolaan, pemanfaatan, dan literasi data di tingkat desa.</p>
                    <p>Oleh karena itu, program Desa Cantik diluncurkan dengan tujuan untuk meningkatkan literasi data di kalangan seluruh aparat desa.</p>
                @endif
            </div>

            <h2 class="section-title metadata">Metadata Statistik</h2>
            <div class="cards-wrapper">
                @forelse($metadata as $item)
                <div class="card {{ $loop->index % 2 == 0 ? 'card-cream' : 'card-pink' }}">
                    <div class="icon-box">
                        <div style="width: 32px; height: 32px; background-color: #F6903A; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 14px;">
                            {{ $loop->index + 1 }}
                        </div>
                    </div>
                    <h3>{{ $item->nama_metadata }}</h3>
                    <p>{{ $item->deskripsi }}</p>
                    
                    {{-- Preview PDF dan Link --}}
                    <div class="metadata-links" style="margin-top: 20px;">
                        @if($item->file_pdf)
                            <div class="pdf-preview" style="margin-bottom: 12px;">
                                <a href="{{ url('/storage/' . $item->file_pdf) }}" target="_blank" class="pdf-preview-link" style="display: block; text-decoration: none; border-radius: 8px; overflow: hidden; border: 1px solid #dee2e6; transition: all 0.3s ease;">
                                    <div class="pdf-thumbnail" style="width: 100%; height: 120px; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); display: flex; align-items: center; justify-content: center; position: relative;">
                                        <div style="text-align: center;">
                                            <i class="fas fa-file-pdf" style="color: #dc3545; font-size: 32px; margin-bottom: 8px;"></i>
                                            <div style="font-size: 12px; color: #6c757d; font-weight: 500;">PDF Document</div>
                                        </div>
                                        <div style="position: absolute; top: 8px; right: 8px; background: rgba(220, 53, 69, 0.1); padding: 4px 8px; border-radius: 4px;">
                                            <i class="fas fa-expand" style="color: #dc3545; font-size: 12px;"></i>
                                        </div>
                                    </div>
                                    <div class="pdf-info" style="padding: 10px; background: white;">
                                        <div style="font-size: 13px; color: #495057; font-weight: 500; display: flex; align-items: center; gap: 6px;">
                                            <i class="fas fa-eye" style="font-size: 12px; color: #6c757d;"></i>
                                            Klik untuk melihat PDF
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endif
                        
                        @if($item->link)
                            <div class="external-link">
                                <a href="{{ $item->link }}" target="_blank" class="link-external" style="display: flex; align-items: center; gap: 8px; padding: 8px 12px; background-color: #e7f3ff; border: 1px solid #b3d9ff; border-radius: 6px; text-decoration: none; color: #0066cc; font-size: 14px; transition: all 0.2s ease;">
                                    <i class="fas fa-link" style="font-size: 16px;"></i>
                                    <span>Link Eksternal</span>
                                    <i class="fas fa-external-link-alt" style="font-size: 12px; color: #0066cc; margin-left: auto;"></i>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
                @empty
                <div class="card card-cream">
                    <div class="icon-box">
                        <div style="width: 32px; height: 32px; background-color: #ccc; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 14px;">
                            -
                        </div>
                    </div>
                    <h3>Belum Ada Data</h3>
                    <p>Metadata statistik belum tersedia</p>
                </div>
                @endforelse
            </div>
            
            <h1 class="main-title">Output Desa Cantik</h1>
            <div class="grid-wrapper">
                @forelse($outputPrograms as $index => $program)
                <div class="card {{ $loop->index % 2 == 0 ? 'bg-cream' : 'bg-pink' }}">
                    <div class="icon-box">
                        <i class="fa-solid fa-{{ $loop->index % 3 == 0 ? 'clipboard-list' : ($loop->index % 3 == 1 ? 'database' : 'book-open') }}"></i>
                    </div>
                    <h3>{{ $program->judul_program }}</h3>
                    <p>{{ $program->deskripsi_program }}</p>
                    <a href="/desa-cantik/output/{{ $program->id_program }}" class="detail-btn">
                        Lihat Detail
                    </a>
                </div>
                @empty
                <div class="card bg-cream">
                    <div class="icon-box">
                        <i class="fa-solid fa-clipboard-list"></i>
                    </div>
                    <h3>Belum Ada Data</h3>
                    <p>Output program Desa Cantik belum tersedia</p>
                </div>
                @endforelse
            </div>
            
{{-- ========================= --}}
{{-- GALERI KEGIATAN --}}
{{-- ========================= --}}
<h2 class="section-title">Galeri Kegiatan</h2>

<div class="grid-3">
    @forelse($galeri as $item)

        @php
            /*
            |--------------------------------------------------------------------------
            | Ambil semua foto
            |--------------------------------------------------------------------------
            */
            $allPhotos = ($item->is_group && $item->group_photos->count() > 0)
                ? $item->group_photos
                : collect([
                    (object) [
                        'id' => $item->id_galeri,
                        'foto' => $item->foto,
                        'judul_foto' => $item->judul_foto,
                        'deskripsi' => $item->deskripsi,
                        'kategori' => $item->kategori,
                        'tanggal_kegiatan' => $item->tanggal_kegiatan,
                    ]
                ]);

            /*
            |--------------------------------------------------------------------------
            | Data viewer modal
            |--------------------------------------------------------------------------
            */
            $viewerPhotos = $allPhotos->map(function ($photo) {

                $formattedDate = '';

                if (!empty($photo->tanggal_kegiatan)) {
                    $formattedDate = is_string($photo->tanggal_kegiatan)
                        ? \Carbon\Carbon::parse($photo->tanggal_kegiatan)->format('d M Y')
                        : $photo->tanggal_kegiatan->format('d M Y');
                }

                return [
                    'src' => asset('storage/' . $photo->foto),
                    'title' => $photo->judul_foto,
                    'description' => $photo->deskripsi,
                    'category' => ucfirst($photo->kategori),
                    'date' => $formattedDate,
                ];
            })->values();
        @endphp

        <div class="gallery-card">

            {{-- JSON DATA --}}
            <script type="application/json" id="public-gallery-viewer-data-{{ $item->id_galeri }}">
                {!! json_encode($viewerPhotos) !!}
            </script>

            {{-- ========================= --}}
            {{-- CAROUSEL --}}
            {{-- ========================= --}}
            @if($item->foto && $allPhotos->count() > 0)

                <div class="ig-carousel" id="igCarousel{{ $item->id_galeri }}" onclick="openGalleryModal({{ $item->id_galeri }})">

                    {{-- MAIN IMAGE --}}
                    <div class="ig-main">

                        @foreach($allPhotos as $photoIndex => $photo)

                            <img
                                src="{{ asset('storage/' . $photo->foto) }}"
                                alt="{{ $photo->judul_foto }}"
                                class="ig-main-img {{ $photoIndex === 0 ? 'active' : '' }}"
                                data-index="{{ $photoIndex }}"
                                data-title="{{ $photo->judul_foto }}"
                                data-description="{{ $photo->deskripsi }}"
                                data-category="{{ ucfirst($photo->kategori) }}"
                                data-date="{{ !empty($photo->tanggal_kegiatan) ? (is_string($photo->tanggal_kegiatan) ? \Carbon\Carbon::parse($photo->tanggal_kegiatan)->format('d M Y') : $photo->tanggal_kegiatan->format('d M Y')) : '' }}"
                            >

                        @endforeach

                        @if($allPhotos->count() > 1)
                            <button type="button" class="ig-nav prev" id="igPrev{{ $item->id_galeri }}" aria-label="Foto sebelumnya" onclick="event.stopPropagation(); window['moveSlide' + {{ $item->id_galeri }}](-1)">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                            <button type="button" class="ig-nav next" id="igNext{{ $item->id_galeri }}" aria-label="Foto berikutnya" onclick="event.stopPropagation(); window['moveSlide' + {{ $item->id_galeri }}](1)">
                                <i class="fas fa-chevron-right"></i>
                            </button>
                        @endif

                        @if($allPhotos->count() > 1)
                            <div class="gallery-photo-count">
                                <i class="far fa-images"></i>
                                <span>{{ $allPhotos->count() }} foto</span>
                            </div>

                            <div class="ig-dots" id="igDots{{ $item->id_galeri }}">
                                @foreach($allPhotos as $photoIndex => $photo)
                                    <span class="ig-dot {{ $photoIndex === 0 ? 'active' : '' }}" data-index="{{ $photoIndex }}" onclick="event.stopPropagation(); window['goToSlide' + {{ $item->id_galeri }}]({{ $photoIndex }})"></span>
                                @endforeach
                            </div>
                        @endif

                        <div class="gallery-expand-btn">
                            <i class="fas fa-expand"></i>
                        </div>
                    </div>

                    @if($allPhotos->count() > 1)
                        <div class="ig-thumbs" id="igThumbs{{ $item->id_galeri }}">
                            @foreach($allPhotos as $photoIndex => $photo)
                                <img src="{{ asset('storage/' . $photo->foto) }}" alt="Thumbnail {{ $photoIndex + 1 }}" class="ig-thumb {{ $photoIndex === 0 ? 'active' : '' }}" data-index="{{ $photoIndex }}" onclick="event.stopPropagation(); window['goToSlide' + {{ $item->id_galeri }}]({{ $photoIndex }})">
                            @endforeach
                        </div>
                    @endif

                </div>

                <script>
                (function () {
                    const carouselId = '{{ $item->id_galeri }}';
                    const images = Array.from(document.querySelectorAll('#igCarousel' + carouselId + ' .ig-main-img'));
                    const dots = Array.from(document.querySelectorAll('#igDots' + carouselId + ' .ig-dot'));
                    const thumbs = Array.from(document.querySelectorAll('#igThumbs' + carouselId + ' .ig-thumb'));

                    window['carouselState' + carouselId] = { current: 0 };

                    window['renderSlide' + carouselId] = function(index) {
                        window['carouselState' + carouselId].current = index;
                        images.forEach((img, i) => {
                            const isActive = i === index;
                            img.classList.toggle('active', isActive);
                            img.style.display = isActive ? 'block' : 'none';
                        });
                        if (dots.length) dots.forEach((dot, i) => dot.classList.toggle('active', i === index));
                        if (thumbs.length) thumbs.forEach((th, i) => th.classList.toggle('active', i === index));
                    };

                    window['moveSlide' + carouselId] = function(direction) {
                        const current = window['carouselState' + carouselId].current;
                        window['renderSlide' + carouselId]((current + direction + images.length) % images.length);
                    };

                    window['goToSlide' + carouselId] = function(index) {
                        window['renderSlide' + carouselId](index);
                    };

                    window['getGalleryPhotos' + carouselId] = function() {
                        return images.map(img => ({
                            src: img.src,
                            alt: img.alt,
                            title: img.dataset.title || img.alt,
                            description: img.dataset.description || '',
                            category: img.dataset.category || '',
                            date: img.dataset.date || ''
                        }));
                    };
})();
                </script>

            @else

                <div class="gallery-img-placeholder">
                    <i class="far fa-image"></i>
                </div>

            @endif

            {{-- ========================= --}}
            {{-- CONTENT --}}
            {{-- ========================= --}}
            <div class="gallery-content">

{{-- Kategori --}}
                @if($item->kategori)
                    <span class="gallery-category {{ $item->kategori }}">
                        {{ $item->kategori }}
                    </span>
                @endif

                <div class="gallery-title">
                    {{ $item->judul_foto }}
                </div>

                {{-- Deskripsi --}}
                @if($item->deskripsi)
                    <div class="gallery-description">
                        {{ $item->deskripsi }}
                    </div>
                @endif

                @if($item->tanggal_kegiatan)
                    <div class="gallery-subtitle">
                        <i class="far fa-calendar-alt"></i>

                        {{ is_string($item->tanggal_kegiatan)
                            ? \Carbon\Carbon::parse($item->tanggal_kegiatan)->format('d M Y')
                            : $item->tanggal_kegiatan->format('d M Y')
                        }}
                    </div>
                @endif

            </div>

        </div>

    @empty

        <div class="gallery-card">

            <div class="gallery-img-placeholder">
                <i class="far fa-image"></i>
            </div>

            <div class="gallery-content">
                <div class="gallery-title">
                    Belum ada kegiatan
                </div>

                <div class="gallery-subtitle">
                    Kegiatan akan segera ditampilkan
                </div>
            </div>

        </div>

@endforelse
</div>

{{-- GLOBAL MODAL FOR GALLERY VIEWER --}}
<div class="modal fade gallery-viewer-modal" id="galleryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" style="max-width: 1100px;">
        <div class="modal-content">
            <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3" style="z-index: 20;" data-bs-dismiss="modal"></button>
            <div class="gallery-viewer-stage" id="galleryModalStage" style="min-height: 70vh; background: #020617; display: flex; align-items: center; justify-content: center;">
                <div class="gallery-zoom-toolbar" aria-label="Kontrol zoom foto">
                    <button type="button" class="gallery-zoom-btn" onclick="changeGalleryZoom(-0.25)" aria-label="Perkecil foto">
                        <i class="fas fa-minus"></i>
                    </button>
                    <span class="gallery-zoom-level" id="galleryZoomLevel">100%</span>
                    <button type="button" class="gallery-zoom-btn" onclick="changeGalleryZoom(0.25)" aria-label="Perbesar foto">
                        <i class="fas fa-plus"></i>
                    </button>
                    <button type="button" class="gallery-zoom-btn" onclick="resetGalleryZoom()" aria-label="Reset zoom foto">
                        <i class="fas fa-compress-arrows-alt"></i>
                    </button>
                </div>
                <img id="galleryModalImage" src="" alt="Foto" style="max-width: 100%; max-height: 72vh; object-fit: contain;">
                <button type="button" class="gallery-viewer-nav gallery-viewer-prev" onclick="moveModalSlide(-1)" style="position: absolute; top: 50%; transform: translateY(-50%); width: 42px; height: 42px; border: 0; border-radius: 50%; background: rgba(255,255,255,0.14); color: white; display: flex; align-items: center; justify-content: center; font-size: 22px; cursor: pointer; left: 16px;">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button type="button" class="gallery-viewer-nav gallery-viewer-next" onclick="moveModalSlide(1)" style="position: absolute; top: 50%; transform: translateY(-50%); width: 42px; height: 42px; border: 0; border-radius: 50%; background: rgba(255,255,255,0.14); color: white; display: flex; align-items: center; justify-content: center; font-size: 22px; cursor: pointer; right: 16px;">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
            <div class="gallery-viewer-info">
                <div class="gallery-viewer-heading">
                    <div>
                        <div class="gallery-viewer-eyebrow">Dokumentasi Kegiatan</div>
                        <h3 class="gallery-viewer-title" id="galleryModalTitle"></h3>
                    </div>
                    <div class="gallery-viewer-counter" id="galleryModalCounter">1 / 1</div>
                </div>
                <div class="gallery-viewer-meta" id="galleryModalMeta"></div>
                <p class="gallery-viewer-description" id="galleryModalDescription"></p>
            </div>
            <div class="gallery-viewer-thumbs" id="galleryModalThumbs" style="background: #0f172a; display: flex; gap: 8px; overflow-x: auto; padding: 12px 18px 18px;"></div>
        </div>
    </div>
</div>

<script>
let galleryModalPhotos = [];
let galleryModalIndex = 0;
let galleryModal = null;
let galleryZoom = 1;
let galleryPanX = 0;
let galleryPanY = 0;
let galleryIsDragging = false;
let galleryDragStartX = 0;
let galleryDragStartY = 0;
let galleryDragOriginX = 0;
let galleryDragOriginY = 0;

function getGalleryZoomElements() {
    return {
        stage: document.getElementById('galleryModalStage'),
        image: document.getElementById('galleryModalImage'),
        level: document.getElementById('galleryZoomLevel')
    };
}

function applyGalleryZoom() {
    const { stage, image, level } = getGalleryZoomElements();
    if (!stage || !image || !level) return;

    if (galleryZoom <= 1) {
        galleryPanX = 0;
        galleryPanY = 0;
    }

    image.style.transform = 'translate(' + galleryPanX + 'px, ' + galleryPanY + 'px) scale(' + galleryZoom + ')';
    level.textContent = Math.round(galleryZoom * 100) + '%';
    stage.classList.toggle('is-zoomed', galleryZoom > 1);
}

function changeGalleryZoom(amount) {
    galleryZoom = Math.min(3, Math.max(1, galleryZoom + amount));
    applyGalleryZoom();
}

function resetGalleryZoom() {
    galleryZoom = 1;
    galleryPanX = 0;
    galleryPanY = 0;
    applyGalleryZoom();
}

function openGalleryModal(id) {
    const photos = window['getGalleryPhotos' + id]();
    if (!photos || !photos.length) return;
    
    galleryModalPhotos = photos;
    galleryModalIndex = window['carouselState' + id] ? window['carouselState' + id].current : 0;
    
    renderGalleryModal();
    
    if (!galleryModal) {
        galleryModal = new bootstrap.Modal(document.getElementById('galleryModal'));
    }
    galleryModal.show();
}

function renderGalleryModal() {
    const photo = galleryModalPhotos[galleryModalIndex];
    if (!photo) return;

    resetGalleryZoom();
    
    document.getElementById('galleryModalImage').src = photo.src;
    document.getElementById('galleryModalImage').alt = photo.alt || 'Foto';
    document.getElementById('galleryModalTitle').textContent = photo.title || photo.alt || 'Tanpa Judul';
    document.getElementById('galleryModalCounter').textContent = (galleryModalIndex + 1) + ' / ' + galleryModalPhotos.length;

    const meta = document.getElementById('galleryModalMeta');
    meta.innerHTML = '';

    [
        { icon: 'fas fa-tag', text: photo.category },
        { icon: 'far fa-calendar-alt', text: photo.date }
    ].filter(item => item.text).forEach(item => {
        const badge = document.createElement('span');
        badge.className = 'gallery-viewer-badge';

        const icon = document.createElement('i');
        icon.className = item.icon;

        const text = document.createElement('span');
        text.textContent = item.text;

        badge.appendChild(icon);
        badge.appendChild(text);
        meta.appendChild(badge);
    });

    const description = document.getElementById('galleryModalDescription');
    description.textContent = photo.description || 'Belum terdapat keterangan tambahan untuk foto kegiatan ini.';
    
    // Update nav buttons visibility
    const navButtons = document.querySelectorAll('#galleryModal .gallery-viewer-nav');
    navButtons.forEach(btn => {
        btn.style.display = galleryModalPhotos.length > 1 ? 'flex' : 'none';
    });

    const thumbs = document.getElementById('galleryModalThumbs');
    thumbs.innerHTML = '';
    galleryModalPhotos.forEach((item, index) => {
        const button = document.createElement('button');
        button.type = 'button';
        button.className = 'gallery-viewer-thumb' + (index === galleryModalIndex ? ' active' : '');
        button.onclick = function() {
            galleryModalIndex = index;
            renderGalleryModal();
        };

        const image = document.createElement('img');
        image.src = item.src;
        image.alt = item.title || item.alt || 'Thumbnail';
        button.appendChild(image);
        thumbs.appendChild(button);
    });
}

function moveModalSlide(direction) {
    if (!galleryModalPhotos.length) return;
    galleryModalIndex = (galleryModalIndex + direction + galleryModalPhotos.length) % galleryModalPhotos.length;
    renderGalleryModal();
}

document.addEventListener('DOMContentLoaded', function() {
    const { stage } = getGalleryZoomElements();
    if (!stage) return;

    stage.addEventListener('click', function(event) {
        if (event.target.closest('button')) return;
        if (galleryZoom === 1) {
            changeGalleryZoom(0.5);
        }
    });

    stage.addEventListener('wheel', function(event) {
        event.preventDefault();
        changeGalleryZoom(event.deltaY < 0 ? 0.25 : -0.25);
    }, { passive: false });

    stage.addEventListener('pointerdown', function(event) {
        if (galleryZoom <= 1 || event.target.closest('button')) return;
        galleryIsDragging = true;
        galleryDragStartX = event.clientX;
        galleryDragStartY = event.clientY;
        galleryDragOriginX = galleryPanX;
        galleryDragOriginY = galleryPanY;
        stage.classList.add('is-dragging');
        stage.setPointerCapture(event.pointerId);
    });

    stage.addEventListener('pointermove', function(event) {
        if (!galleryIsDragging) return;
        galleryPanX = galleryDragOriginX + (event.clientX - galleryDragStartX);
        galleryPanY = galleryDragOriginY + (event.clientY - galleryDragStartY);
        applyGalleryZoom();
    });

    function stopGalleryDrag(event) {
        if (!galleryIsDragging) return;
        galleryIsDragging = false;
        stage.classList.remove('is-dragging');
        if (event && stage.hasPointerCapture(event.pointerId)) {
            stage.releasePointerCapture(event.pointerId);
        }
    }

    stage.addEventListener('pointerup', stopGalleryDrag);
    stage.addEventListener('pointercancel', stopGalleryDrag);
    stage.addEventListener('pointerleave', stopGalleryDrag);
});
</script>
@endsection
