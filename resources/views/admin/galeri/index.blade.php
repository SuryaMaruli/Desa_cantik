@extends('layouts.admin')

@section('page-title', 'Galeri Foto')

@push('styles')
<!-- SortableJS for Drag and Drop -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js"></script>
<style>
    /* --- 1. RESET & GLOBAL --- */
    * { box-sizing: border-box; }
    body { background-color: #f8fafc; min-height: 100vh; }
    :root {
        --header-height: 80px;
        --text-dark: #1e293b;
        --text-muted: #64748b;
        --primary-green: #059669;
        --primary-green-dark: #047857;
        --card-shadow: 0 4px 20px rgba(0,0,0,0.08);
        --card-shadow-hover: 0 12px 40px rgba(0,0,0,0.15);
    }

    /* --- 3. MAIN CONTENT --- */
    .home-content { 
        padding: 30px; 
        background-color: #f8fafc;
        min-height: calc(100vh - var(--header-height));
    }

    /* --- 4. KONTEN KHUSUS GALERI --- */
    /* A. Header Section - Enhanced */
    .gallery-header-card {
        background: #fff; 
        border-radius: 20px; 
        padding: 28px 32px;
        box-shadow: 0 4px 24px rgba(0,0,0,0.06); 
        border: 1px solid #e2e8f0;
        display: flex; 
        justify-content: space-between; 
        align-items: center;
        margin-bottom: 30px;
    }
    .header-text h3 { 
        font-size: 24px; 
        font-weight: 700; 
        color: #0f172a; 
        margin-bottom: 6px; 
        letter-spacing: -0.5px;
    }
    .header-text p { 
        font-size: 14px; 
        color: #64748b; 
    }

    /* Statistics Cards */
    .gallery-stats {
        display: flex;
        gap: 16px;
        margin-bottom: 24px;
    }
    .stat-card {
        background: #fff;
        border-radius: 14px;
        padding: 18px 22px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.04);
        border: 1px solid #e2e8f0;
        flex: 1;
        display: flex;
        align-items: center;
        gap: 14px;
    }
    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
    }
    .stat-icon.total { background: linear-gradient(135deg, #eff6ff, #dbeafe); color: #3b82f6; }
    .stat-icon.kesehatan { background: linear-gradient(135deg, #ecfdf5, #d1fae5); color: #10b981; }
    .stat-icon.sosial { background: linear-gradient(135deg, #eff6ff, #dbeafe); color: #3b82f6; }
    .stat-icon.lingkungan { background: linear-gradient(135deg, #f0fdfa, #ccfbf1); color: #14b8a6; }
    .stat-icon.ekonomi { background: linear-gradient(135deg, #fffbeb, #fef3c7); color: #f59e0b; }
    .stat-icon.budaya { background: linear-gradient(135deg, #faf5ff, #f3e8ff); color: #a855f7; }
    .stat-info h4 { margin: 0; font-size: 26px; font-weight: 700; color: #0f172a; }
    .stat-info span { font-size: 13px; color: #64748b; }

    /* Search and Filter Bar */
    .filter-bar {
        background: #fff;
        border-radius: 16px;
        padding: 20px 24px;
        box-shadow: 0 2px 16px rgba(0,0,0,0.04);
        border: 1px solid #e2e8f0;
        margin-bottom: 24px;
        display: flex;
        gap: 16px;
        align-items: center;
        flex-wrap: wrap;
    }
    .search-input-wrapper {
        position: relative;
        flex: 1;
        min-width: 250px;
    }
    .search-input-wrapper i {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 18px;
    }
    .search-input {
        width: 100%;
        padding: 12px 14px 12px 44px;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        font-size: 14px;
        transition: 0.2s;
        background: #f8fafc;
    }
    .search-input:focus {
        outline: none;
        border-color: #059669;
        background: #fff;
        box-shadow: 0 0 0 4px rgba(5, 150, 105, 0.1);
    }
    .filter-select {
        padding: 12px 36px 12px 14px;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        font-size: 14px;
        background: #fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%2364748b' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E") no-repeat right 12px center;
        appearance: none;
        cursor: pointer;
        min-width: 150px;
    }
    .filter-select:focus {
        outline: none;
        border-color: #059669;
    }
    .view-toggle {
        display: flex;
        background: #f1f5f9;
        border-radius: 10px;
        padding: 4px;
    }
    .view-btn {
        padding: 10px 14px;
        border: none;
        background: transparent;
        border-radius: 8px;
        cursor: pointer;
        transition: 0.2s;
        color: #64748b;
    }
    .view-btn.active {
        background: #fff;
        color: #059669;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    
    .btn-add-photo {
        background: linear-gradient(135deg, #059669, #10b981); 
        color: white; 
        padding: 12px 24px; 
        border-radius: 12px;
        text-decoration: none; 
        display: flex; 
        align-items: center; 
        gap: 8px; 
        font-size: 14px; 
        font-weight: 600;
        transition: 0.3s;
        border: none;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(5, 150, 105, 0.3);
    }
    .btn-add-photo:hover { 
        background: linear-gradient(135deg, #047857, #059669);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(5, 150, 105, 0.4);
        color: white;
    }

    /* B. Grid Galeri (3 Kolom) - Enhanced */
    .gallery-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 24px;
    }

    /* List View */
    .gallery-grid.list-view {
        grid-template-columns: 1fr;
        gap: 16px;
    }
    .gallery-grid.list-view .gallery-card {
        flex-direction: row;
        align-items: center;
        gap: 20px;
        padding: 16px;
    }
    .gallery-grid.list-view .image-placeholder {
        width: 160px;
        height: 120px;
        aspect-ratio: unset;
        flex-shrink: 0;
        margin-bottom: 0;
    }
    .gallery-grid.list-view .card-content {
        flex: 1;
        display: flex;
        flex-direction: row;
        align-items: center;
        gap: 20px;
    }
    .gallery-grid.list-view .card-title {
        margin-bottom: 0;
        flex: 1;
    }
    .gallery-grid.list-view .card-description {
        display: none;
    }
    .gallery-grid.list-view .card-footer {
        margin-top: 0;
    }

    /* Drag and Drop Styles - Enhanced */
    .gallery-card {
        background: #fff; 
        border-radius: 20px; 
        padding: 20px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06); 
        border: 1px solid #e2e8f0;
        display: flex; 
        flex-direction: column;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: grab;
        position: relative;
        overflow: hidden;
    }
    .gallery-card:hover { 
        transform: translateY(-6px); 
        box-shadow: 0 16px 48px rgba(0,0,0,0.12); 
        border-color: #cbd5e1;
    }
    .gallery-card.sortable-ghost {
        opacity: 0.4;
        background: #f0fdf4;
    }
    .gallery-card.sortable-drag {
        cursor: grabbing;
    }
    .gallery-card.dragging {
        box-shadow: 0 20px 50px rgba(0,0,0,0.2);
        transform: scale(1.02) rotate(1deg);
    }
    
    /* Drag Handle */
    .drag-handle {
        position: absolute;
        top: 10px;
        left: 10px;
        width: 28px;
        height: 28px;
        background: rgba(0,0,0,0.6);
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 14px;
        opacity: 0;
        transition: opacity 0.2s;
        z-index: 10;
        cursor: grab;
    }
    .gallery-card:hover .drag-handle {
        opacity: 1;
    }
    
.image-placeholder {
        width: 100%; 
        background-color: #fff; 
        border-radius: 10px;
        margin-bottom: 0;
        overflow: hidden;
        position: relative;
        cursor: zoom-in;
        transition: all 0.3s ease;
    }
.image-placeholder:hover {
        box-shadow: 0 8px 30px rgba(0,0,0,0.12);
    }
.image-placeholder img {
        width: 100%; 
        height: 100%; 
        object-fit: cover;
    }

    .image-placeholder > img {
        aspect-ratio: 16 / 10;
        display: block;
    }

/* ============================================
       PUBLIC GALLERY CAROUSEL STYLE
       ============================================ */

    .gallery-carousel-wrap {
        background: #fff;
        cursor: zoom-in;
        overflow: hidden;
    }

    .gallery-carousel {
        position: relative;
        width: 100%;
        aspect-ratio: 16 / 10;
        background: #f3f4f6;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .gallery-carousel::after {
        content: "";
        position: absolute;
        inset: auto 0 0 0;
        height: 45%;
        background: linear-gradient(180deg, rgba(15, 23, 42, 0) 0%, rgba(15, 23, 42, 0.48) 100%);
        pointer-events: none;
        z-index: 2;
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

    .gallery-carousel-slide img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.35s ease;
    }

    .gallery-card:hover .gallery-carousel-slide.active img {
        transform: scale(1.035);
    }

    .gallery-carousel-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 36px;
        height: 36px;
        border: none;
        border-radius: 50%;
        background: rgba(15, 23, 42, 0.62);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 6;
        cursor: pointer;
        transition: background 0.2s ease, transform 0.2s ease;
    }

    .gallery-carousel-btn:hover {
        background: rgba(15, 23, 42, 0.86);
        transform: translateY(-50%) scale(1.04);
    }

    .gallery-carousel-btn:active {
        transform: translateY(-50%) scale(0.95);
    }

    .gallery-carousel-btn i {
        font-size: 18px;
    }

    .gallery-carousel-prev {
        left: 12px;
    }

    .gallery-carousel-next {
        right: 12px;
    }

    .gallery-photo-count {
        position: absolute;
        top: 12px;
        left: 12px;
        z-index: 6;
        padding: 5px 10px;
        border-radius: 999px;
        background: rgba(15, 23, 42, 0.72);
        color: white;
        font-size: 12px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
    }

    .gallery-expand-btn {
        position: absolute;
        right: 12px;
        bottom: 12px;
        width: 34px;
        height: 34px;
        border-radius: 50%;
        background: rgba(15, 23, 42, 0.72);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        z-index: 6;
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
    }

    .gallery-carousel-dots {
        position: absolute;
        left: 0;
        right: 0;
        bottom: 12px;
        z-index: 5;
        display: flex;
        justify-content: center;
        gap: 7px;
        padding: 0;
    }

    .gallery-carousel-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.62);
        border: 0;
        padding: 0;
        cursor: pointer;
        box-shadow: 0 1px 4px rgba(15, 23, 42, 0.2);
        transition: width 0.2s ease, background 0.2s ease;
    }

    .gallery-carousel-dot:hover {
        background: rgba(255, 255, 255, 0.86);
    }

    .gallery-carousel-dot.active {
        width: 22px;
        border-radius: 999px;
        background: #fff;
    }

    .gallery-carousel-autoplay {
        display: none;
    }

    .gallery-carousel-thumbs {
        display: flex;
        gap: 6px;
        overflow-x: auto;
        overflow-y: hidden;
        padding: 10px 14px 12px;
        background: #fff;
        scrollbar-width: thin;
    }

    .image-placeholder .gallery-carousel-thumbs .gallery-carousel-thumb {
        width: 54px;
        height: 42px;
        flex-shrink: 0;
        display: block;
        border-radius: 6px;
        object-fit: cover;
        border: 2px solid transparent;
        cursor: pointer;
        opacity: 0.66;
        transition: opacity 0.2s ease, border-color 0.2s ease, transform 0.2s ease;
    }

    .image-placeholder .gallery-carousel-thumbs .gallery-carousel-thumb:hover {
        opacity: 0.9;
    }

    .image-placeholder .gallery-carousel-thumbs .gallery-carousel-thumb.active {
        border-color: #f97316;
        opacity: 1;
        transform: translateY(-1px);
    }

    .image-zoom-hint {
        position: absolute;
        right: 10px;
        bottom: 10px;
        width: 34px;
        height: 34px;
        border-radius: 50%;
        background: rgba(17, 24, 39, 0.72);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 6;
        opacity: 1;
        transition: opacity 0.2s, background 0.2s;
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
    }

    .image-placeholder:hover .image-zoom-hint {
        opacity: 1;
    }

    .image-zoom-hint:hover {
        background: rgba(17, 24, 39, 0.9);
    }

.gallery-viewer-modal .modal-content {
        background: #1e293b;
        color: white;
        border: 0;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.5);
    }

.gallery-viewer-stage {
        position: relative;
        min-height: 64vh;
        background: transparent;
        display: flex;
        align-items: center;
        justify-content: center;
        border-bottom: 1px solid rgba(148, 163, 184, 0.15);
    }

    .gallery-viewer-stage img {
        max-width: 100%;
        max-height: 72vh;
        object-fit: contain;
        border-radius: 4px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.4);
    }

    .gallery-viewer-nav {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 48px;
        height: 48px;
        border: 1px solid rgba(148, 163, 184, 0.2);
        border-radius: 12px;
        background: rgba(30, 41, 59, 0.8);
        backdrop-filter: blur(8px);
        color: #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        cursor: pointer;
        transition: all 0.2s ease;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
    }

    .gallery-viewer-nav:hover {
        background: rgba(59, 130, 246, 0.3);
        border-color: rgba(59, 130, 246, 0.5);
        color: #fff;
        transform: translateY(-50%) scale(1.05);
    }

    .gallery-viewer-prev {
        left: 20px;
    }

    .gallery-viewer-next {
        right: 20px;
    }

.gallery-viewer-info {
        padding: 0;
        background: #fff;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    }

    .gallery-viewer-photo-wrapper {
        position: relative;
        background: #f8fafc;
    }

    .gallery-viewer-details {
        padding: 20px 24px;
        background: #fff;
        border-top: 1px solid #e2e8f0;
    }

    .gallery-viewer-title {
        font-size: 20px;
        font-weight: 700;
        margin-bottom: 12px;
        color: #1e293b;
        letter-spacing: 0.3px;
        line-height: 1.3;
    }

    .gallery-viewer-meta {
        color: #64748b;
        font-size: 13px;
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 16px;
        padding-bottom: 16px;
        border-bottom: 1px solid #e2e8f0;
    }

    .gallery-viewer-meta-item {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .gallery-viewer-meta-icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
    }

    .meta-kategori {
        background: linear-gradient(135deg, #ecfdf5, #d1fae5);
        color: #059669;
    }

    .meta-tanggal {
        background: linear-gradient(135deg, #eff6ff, #dbeafe);
        color: #3b82f6;
    }

    .gallery-viewer-description {
        color: #475569;
        font-size: 14px;
        line-height: 1.7;
        background: #f8fafc;
        padding: 16px 20px;
        border-radius: 12px;
        border-left: 4px solid #059669;
    }

    .gallery-viewer-description-label {
        font-weight: 600;
        color: #1e293b;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 8px;
    }

    .gallery-viewer-thumbs {
        display: flex;
        gap: 10px;
        overflow-x: auto;
        padding: 14px 24px 20px;
        background: #e2e8f0;
        border-top: 1px solid rgba(148, 163, 184, 0.15);
    }

    .gallery-viewer-thumb {
        width: 80px;
        height: 80px;
        border: 2px solid rgba(148, 163, 184, 0.2);
        border-radius: 10px;
        padding: 0;
        overflow: hidden;
        background: transparent;
        flex: 0 0 auto;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .gallery-viewer-thumb:hover {
        border-color: rgba(148, 163, 184, 0.4);
        transform: scale(1.05);
    }

    .gallery-viewer-thumb.active {
        border-color: #3b82f6;
        box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.3);
    }

.gallery-viewer-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* Zoom Controls */
    .gallery-viewer-zoom-controls {
        position: absolute;
        bottom: 24px;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        gap: 8px;
        z-index: 10;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        padding: 8px 16px;
        border-radius: 12px;
        border: 1px solid rgba(148, 163, 184, 0.2);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .gallery-viewer-zoom-btn {
        width: 36px;
        height: 36px;
        border: 1px solid rgba(148, 163, 184, 0.25);
        border-radius: 8px;
        background: #fff;
        color: #475569;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .gallery-viewer-zoom-btn:hover {
        background: rgba(59, 130, 246, 0.15);
        border-color: rgba(59, 130, 246, 0.4);
        color: #3b82f6;
    }

    .gallery-viewer-zoom-btn:disabled {
        opacity: 0.4;
        cursor: not-allowed;
    }

    .gallery-viewer-zoom-level {
        display: flex;
        align-items: center;
        padding: 0 14px;
        font-size: 13px;
        color: #475569;
        font-weight: 500;
    }

    /* Public Desa Cantik modal style */
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
        border-bottom: 0;
    }

    .gallery-viewer-stage img {
        max-width: 100%;
        max-height: 72vh;
        object-fit: contain;
        display: block;
        border-radius: 0;
        box-shadow: none;
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
        width: 42px;
        height: 42px;
        border: 0;
        border-radius: 50%;
        background: rgba(255,255,255,0.14);
        color: white;
        font-size: 22px;
        z-index: 10;
        box-shadow: none;
    }

    .gallery-viewer-nav:hover {
        background: rgba(255,255,255,0.24);
        border-color: transparent;
        color: #fff;
        transform: translateY(-50%);
    }

    .gallery-viewer-prev {
        left: 16px;
    }

    .gallery-viewer-next {
        right: 16px;
    }

    .gallery-viewer-info {
        padding: 22px 26px 20px;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 0;
        box-shadow: none;
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
        padding-bottom: 0;
        border-bottom: 0;
        color: inherit;
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
        padding: 0 0 0 16px;
        color: rgba(255, 255, 255, 0.84);
        font-size: 14px;
        line-height: 1.75;
        max-width: 920px;
        background: transparent;
        border: 0;
        border-radius: 0;
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
        background: #0f172a;
        border-top: 0;
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
        box-shadow: none;
    }

    .gallery-viewer-thumb:hover {
        border-color: rgba(255, 255, 255, 0.36);
        transform: none;
    }

    .gallery-viewer-thumb.active {
        border-color: #F6903A;
        box-shadow: none;
    }

    .gallery-viewer-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .group-overlay {
        display: none;
    }

/* Card Title - Enhanced */
    .card-title {
        font-size: 16px; 
        font-weight: 700; 
        color: #1e293b; 
        margin-bottom: 10px; 
        line-height: 1.4;
    }
    
    .card-description {
        font-size: 13px;
        color: #64748b;
        line-height: 1.5;
        margin-bottom: 12px;
    }

    /* ============================================
       SEPARATE BOXES FOR PHOTO AND CAPTION
       ============================================ */
    .gallery-card-separator {
        display: flex;
        flex-direction: column;
        gap: 0;
        background: #fff;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        border: 1px solid #e2e8f0;
    }
    
    /* Image Box - Top */
    .image-box {
        padding: 0;
        background: #f3f4f6;
        position: relative;
    }
    
    /* Caption Box - Bottom */
    .caption-box {
        padding: 16px 20px;
        background: #fff;
        display: flex;
        flex-direction: column;
        gap: 12px;
    }
    
    .caption-box .card-title {
        margin-bottom: 0;
    }
    
    .caption-box .card-description {
        margin-bottom: 0;
    }
    
    .caption-box .card-footer {
        margin-top: 0;
        padding-top: 12px;
        border-top: 1px solid #f1f5f9;
    }

    /* Fallback for non-separator cards - keep original style */
    .gallery-card:not(.gallery-card-separator) {
        background: #fff; 
        border-radius: 20px; 
        padding: 20px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06); 
        border: 1px solid #e2e8f0;
        display: flex; 
        flex-direction: column;
    }
    
    .card-info {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .card-footer {
        display: flex; 
        justify-content: space-between; 
        align-items: center; 
        margin-top: auto;
        flex-wrap: wrap;
        gap: 12px;
        padding-top: 12px;
        border-top: 1px solid #f1f5f9;
    }
    
    .card-actions {
        display: flex;
        gap: 6px;
    }
    
    .btn-edit, .btn-delete {
        padding: 8px 12px;
        border-radius: 8px;
        font-size: 13px;
        border: none;
        cursor: pointer;
        transition: 0.2s;
        display: flex;
        align-items: center;
        gap: 4px;
    }
    
    .btn-edit {
        background: linear-gradient(135deg, #eff6ff, #dbeafe);
        color: #2563eb;
    }
    
    .btn-edit:hover {
        background: linear-gradient(135deg, #dbeafe, #bfdbfe);
        color: #1d4ed8;
        transform: translateY(-1px);
    }
    
    .btn-delete {
        background: linear-gradient(135deg, #fef2f2, #fee2e2);
        color: #dc2626;
    }
    
    .btn-delete:hover {
        background: linear-gradient(135deg, #fee2e2, #fecaca);
        color: #b91c1c;
        transform: translateY(-1px);
    }
    
    .date-text { 
        font-size: 12px; 
        color: #94a3b8; 
        display: flex;
        align-items: center;
        gap: 4px;
    }
    
    .date-text i {
        font-size: 14px;
    }

    /* Tags Kategori - Enhanced with Icons */
    .tag-badge { 
        padding: 6px 14px; 
        border-radius: 20px; 
        font-size: 12px; 
        font-weight: 600; 
        display: inline-flex;
        align-items: center;
        gap: 5px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    }
    
    .tag-badge i {
        font-size: 14px;
    }
    
    .tag-kesehatan { 
        background: linear-gradient(135deg, #ecfdf5, #d1fae5); 
        color: #047857; 
    }
    .tag-sosial { 
        background: linear-gradient(135deg, #eff6ff, #dbeafe); 
        color: #1d4ed8; 
    }
    .tag-lingkungan { 
        background: linear-gradient(135deg, #f0fdfa, #ccfbf1); 
        color: #0f766e; 
    }
    .tag-ekonomi { 
        background: linear-gradient(135deg, #fffbeb, #fef3c7); 
        color: #b45309; 
    }
    .tag-budaya { 
        background: linear-gradient(135deg, #faf5ff, #f3e8ff); 
        color: #7e22ce; 
    }

    /* Multiple Upload Preview */
    .upload-preview-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 10px;
        margin-top: 15px;
    }
    .upload-preview-item {
        position: relative;
        aspect-ratio: 1;
        border-radius: 8px;
        overflow: hidden;
    }
    .upload-preview-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .upload-preview-item .remove-btn {
        position: absolute;
        top: 5px;
        right: 5px;
        width: 24px;
        height: 24px;
        background: rgba(220, 53, 69, 0.9);
        color: white;
        border: none;
        border-radius: 50%;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
    }
    .upload-preview-item .file-name {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(0,0,0,0.7);
        color: white;
        font-size: 10px;
        padding: 4px;
        text-overflow: ellipsis;
        overflow: hidden;
        white-space: nowrap;
    }
    .add-more-photos {
        border: 2px dashed #ccc;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: 0.2s;
        aspect-ratio: 1;
    }
    .add-more-photos:hover {
        border-color: #009669;
        color: #009669;
    }

/* Responsive */
    @media (max-width: 1024px) {
        .gallery-grid { 
            grid-template-columns: repeat(2, 1fr); 
        }
    }
    
    @media (max-width: 768px) {
        .gallery-grid { 
            grid-template-columns: 1fr; 
        }
        .gallery-carousel,
        .image-placeholder > img {
            aspect-ratio: 4 / 3;
        }
        .gallery-grid.list-view .gallery-carousel {
            aspect-ratio: 4 / 3;
        }
        .gallery-grid.list-view .gallery-carousel-thumbs {
            display: none;
        }
        .gallery-header-card { 
            flex-direction: column; 
            align-items: flex-start; 
            gap: 15px; 
        }
        .upload-preview-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    /* Photo list similar to news page */
    .photo-list {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(130px, 1fr));
        gap: 10px;
    }
    .photo-card {
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 8px;
        background: #fff;
        cursor: grab;
    }
    .photo-card.dragging {
        opacity: 0.5;
        border-style: dashed;
    }
    .photo-card img {
        width: 100%;
        height: 90px;
        object-fit: cover;
        border-radius: 6px;
        margin-bottom: 6px;
    }
    .photo-order-label {
        font-size: 11px;
        color: #666;
    }
    .remove-photo-btn {
        width: 100%;
        margin-top: 5px;
        font-size: 11px;
        padding: 4px 6px;
    }
    .multi-photo-help {
        font-size: 12px;
        color: #666;
        margin-top: 6px;
    }
</style>
@endpush

@section('content')

<div class="home-content">

    <!-- Header -->
    <div class="gallery-header-card">

        <div class="header-text">
            <h3>Galeri Foto</h3>

            <p>
                Total:
                <span class="fw-bold">{{ count($galeri) }}</span> foto
            </p>
        </div>

        <div>
            <button type="button"
                    class="btn-add-photo"
                    data-bs-toggle="modal"
                    data-bs-target="#tambahFotoModal">

                <i class='bx bx-plus'></i>
                Tambah Foto
            </button>
        </div>

    </div>


    <!-- Filter -->
    <div class="filter-bar">

        <div class="search-input-wrapper">
            <i class='bx bx-search'></i>

            <input type="text"
                   class="search-input"
                   id="searchInput"
                   placeholder="Cari foto..."
                   onkeyup="filterGallery()">
        </div>

        <select class="filter-select"
                id="categoryFilter"
                onchange="filterGallery()">

            <option value="">Semua Kategori</option>
            <option value="kesehatan">Kesehatan</option>
            <option value="sosial">Sosial</option>
            <option value="lingkungan">Lingkungan</option>
            <option value="ekonomi">Ekonomi</option>
            <option value="budaya">Budaya</option>

        </select>

        <div class="view-toggle">

            <button type="button"
                    class="view-btn active"
                    onclick="setView('grid')"
                    title="Tampilan Grid">

                <i class='bx bx-grid-alt'></i>
            </button>

            <button type="button"
                    class="view-btn"
                    onclick="setView('list')"
                    title="Tampilan List">

                <i class='bx bx-list-ul'></i>
            </button>

        </div>

    </div>


    <!-- Gallery Grid -->
    <div class="gallery-grid" id="galleryGrid">

        @forelse($galeri as $item)

            @php
                $viewerPhotos = $item->group_photos->map(function ($photo) {
                    return [
                        'src' => asset('storage/' . $photo->foto),
                        'title' => $photo->judul_foto,
                        'description' => $photo->deskripsi,
                        'category' => ucfirst($photo->kategori),
                        'date' => is_string($photo->tanggal_kegiatan)
                            ? \Carbon\Carbon::parse($photo->tanggal_kegiatan)->format('d/m/Y')
                            : $photo->tanggal_kegiatan->format('d/m/Y'),
                    ];
                })->values();
            @endphp

            <div class="gallery-card gallery-card-separator"
                 data-id="{{ $item->id }}"
                 data-grup-id="{{ $item->grup_id ?? '' }}">

                <!-- Drag Handle -->
                <div class="drag-handle" title="Drag untuk mengurutkan">
                    <i class='bx bx-menu'></i>
                </div>

                <!-- JSON Viewer -->
                <script type="application/json"
                        id="gallery-viewer-data-{{ $item->id }}">
                    @json($viewerPhotos)
                </script>


                <!-- IMAGE BOX -->
                <div class="image-box">

                    <div class="image-placeholder"
                         data-gallery-viewer-id="{{ $item->id }}"
                         onclick="openGalleryViewerFromCard(this)"
                         title="Klik untuk memperbesar foto">

                        @if($item->is_group && $item->photo_count > 1)

                            <!-- Carousel -->
                            <div class="gallery-carousel-wrap">
                            <div class="gallery-carousel"
                                 data-photo-carousel
                                 data-current-index="0">

                                @foreach($item->group_photos as $photoIndex => $photo)

                                    <div class="gallery-carousel-slide {{ $photoIndex === 0 ? 'active' : '' }}"
                                         data-slide-index="{{ $photoIndex }}">

                                        <img src="{{ asset('storage/' . $photo->foto) }}"
                                             alt="{{ $photo->judul_foto }}">

                                    </div>

                                @endforeach


                                <!-- Photo Count -->
                                <div class="gallery-photo-count">
                                    <i class='bx bx-images'></i>
                                    <span>{{ $item->photo_count }} foto</span>
                                </div>


                                <!-- Autoplay -->
                                <div class="gallery-carousel-autoplay paused"
                                     onclick="event.stopPropagation(); toggleCarouselAutoplay(this.closest('.gallery-carousel'))"
                                     title="Klik untuk auto-play">

                                    <i class="bx bx-play"></i> Play
                                </div>


                                <!-- Prev -->
                                <button type="button"
                                        class="gallery-carousel-btn gallery-carousel-prev"
                                        onclick="event.stopPropagation(); moveGalleryCarousel(this, -1)"
                                        title="Foto sebelumnya">

                                    <i class='bx bx-chevron-left'></i>
                                </button>


                                <!-- Next -->
                                <button type="button"
                                        class="gallery-carousel-btn gallery-carousel-next"
                                        onclick="event.stopPropagation(); moveGalleryCarousel(this, 1)"
                                        title="Foto berikutnya">

                                    <i class='bx bx-chevron-right'></i>
                                </button>


                                <!-- Dots -->
                                <div class="gallery-carousel-dots"
                                     aria-label="Navigasi foto">

                                    @foreach($item->group_photos as $photoIndex => $photo)

                                        <button type="button"
                                                class="gallery-carousel-dot {{ $photoIndex === 0 ? 'active' : '' }}"
                                                onclick="event.stopPropagation(); goToGalleryCarousel(this, {{ $photoIndex }})"
                                                title="Lihat foto {{ $photoIndex + 1 }}">
                                        </button>

                                    @endforeach

                                </div>


                                <div class="gallery-expand-btn">
                                    <i class='bx bx-expand-alt'></i>
                                </div>

                            </div>

                            <div class="gallery-carousel-thumbs">
                                @foreach($item->group_photos as $photoIndex => $photo)
                                    <img src="{{ asset('storage/' . $photo->foto) }}"
                                         alt="Thumbnail {{ $photoIndex + 1 }}"
                                         class="gallery-carousel-thumb {{ $photoIndex === 0 ? 'active' : '' }}"
                                         onclick="event.stopPropagation(); goToGalleryCarousel(this, {{ $photoIndex }})">
                                @endforeach
                            </div>
                            </div>

                        @else

                            <!-- Single Image -->
                            <img src="{{ asset('storage/' . $item->foto) }}"
                                 alt="{{ $item->judul_foto }}">

                        @endif


                        @unless($item->is_group && $item->photo_count > 1)
                            <!-- Zoom Hint -->
                            <div class="image-zoom-hint">
                                <i class='bx bx-expand-alt'></i>
                            </div>
                        @endunless

                    </div>

                </div>


                <!-- CAPTION BOX -->
                <div class="caption-box">

                    <div class="card-title">
                        {{ $item->judul_foto }}
                    </div>

                    @if($item->deskripsi)

                        <div class="card-description text-muted small">
                            {{ Str::limit($item->deskripsi, 80) }}
                        </div>

                    @endif


                    <div class="card-footer">

                        <div class="card-info">

                            <span class="tag-badge tag-{{ $item->kategori }}">
                                {{ ucfirst($item->kategori) }}
                            </span>

                            <span class="date-text">
                                {{ is_string($item->tanggal_kegiatan)
                                    ? \Carbon\Carbon::parse($item->tanggal_kegiatan)->format('d/m/Y')
                                    : $item->tanggal_kegiatan->format('d/m/Y') }}
                            </span>

                        </div>


                        <div class="card-actions">

                            <!-- Edit -->
                            <button type="button"
                                    class="btn-edit"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editFotoModal{{ $item->id_galeri }}"
                                    title="Edit Foto">

                                <i class='bx bx-edit'></i>
                            </button>


                            <!-- Delete -->
                            <form action="{{ route('admin.galeri.destroy', $item->id_galeri) }}"
                                  method="POST"
                                  class="gallery-delete-form"
                                  data-title="{{ $item->judul_foto }}"
                                  style="display:inline;">

                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        class="btn-delete"
                                        title="Hapus Foto">

                                    <i class='bx bx-trash'></i>
                                </button>

                            </form>

                        </div>

                    </div>

                </div>

            </div>

        @empty

            <div class="text-center py-5">
                <h5 class="text-muted">Belum ada foto galeri</h5>
            </div>

        @endforelse

    </div>

</div>

<!-- Full Gallery Viewer Modal -->
<div class="modal fade gallery-viewer-modal" id="galleryViewerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" style="max-width: 1100px;">
        <div class="modal-content">
            <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3" style="z-index: 20;" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="gallery-viewer-stage" id="galleryViewerStage" style="min-height: 70vh;">
                <div class="gallery-zoom-toolbar" aria-label="Kontrol zoom foto">
                    <button type="button" class="gallery-zoom-btn" onclick="changeGalleryZoom(-0.25)" aria-label="Perkecil foto">
                        <i class='bx bx-minus'></i>
                    </button>
                    <span class="gallery-zoom-level" id="galleryZoomLevel">100%</span>
                    <button type="button" class="gallery-zoom-btn" onclick="changeGalleryZoom(0.25)" aria-label="Perbesar foto">
                        <i class='bx bx-plus'></i>
                    </button>
                    <button type="button" class="gallery-zoom-btn" onclick="resetGalleryZoom()" aria-label="Reset zoom foto">
                        <i class='bx bx-collapse-alt'></i>
                    </button>
                </div>
                <img id="galleryViewerImage" src="" alt="Foto">
                <button type="button" class="gallery-viewer-nav gallery-viewer-prev" onclick="moveGalleryViewer(-1)" title="Foto sebelumnya" style="display: none;">
                    <i class='bx bx-chevron-left'></i>
                </button>
                <button type="button" class="gallery-viewer-nav gallery-viewer-next" onclick="moveGalleryViewer(1)" title="Foto berikutnya" style="display: none;">
                    <i class='bx bx-chevron-right'></i>
                </button>
            </div>
            <div class="gallery-viewer-info">
                <div class="gallery-viewer-heading">
                    <div>
                        <div class="gallery-viewer-eyebrow">Dokumentasi Kegiatan</div>
                        <h3 class="gallery-viewer-title" id="galleryViewerPhotoTitle"></h3>
                    </div>
                    <div class="gallery-viewer-counter" id="galleryViewerCounter">1 / 1</div>
                </div>
                <div class="gallery-viewer-meta" id="galleryViewerPhotoMeta"></div>
                <p class="gallery-viewer-description" id="galleryViewerPhotoDescription"></p>
            </div>
            <div class="gallery-viewer-thumbs" id="galleryViewerThumbs"></div>
        </div>
    </div>
</div>

    <!-- Edit Modals -->
    @foreach($galeri as $item)
    <!-- Modal Edit Foto -->
    <div class="modal fade" id="editFotoModal{{ $item->id_galeri }}" tabindex="-1" aria-labelledby="editFotoModalLabel{{ $item->id_galeri }}" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="editFotoModalLabel{{ $item->id_galeri }}">
                        <i class='bx bx-edit me-2'></i>Edit Foto
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.galeri.update', $item->id_galeri) }}" method="POST" enctype="multipart/form-data" class="gallery-edit-form">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="edit_judul_foto_{{ $item->id_galeri }}" class="form-label fw-medium">Judul Foto <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-lg" id="edit_judul_foto_{{ $item->id_galeri }}" name="judul_foto" value="{{ $item->judul_foto }}" required>
                                    <div class="form-text">Masukkan judul yang deskriptif untuk foto Anda</div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="edit_deskripsi_{{ $item->id_galeri }}" class="form-label fw-medium">Deskripsi (Opsional)</label>
                                    <textarea class="form-control" id="edit_deskripsi_{{ $item->id_galeri }}" name="deskripsi" rows="3" placeholder="Tambahkan deskripsi singkat tentang foto ini">{{ $item->deskripsi ?? '' }}</textarea>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="edit_kategori_{{ $item->id_galeri }}" class="form-label fw-medium">Kategori <span class="text-danger">*</span></label>
                                            <select class="form-select" id="edit_kategori_{{ $item->id_galeri }}" name="kategori" required>
                                                <option value="" disabled>Pilih Kategori</option>
                                                <option value="kesehatan" {{ $item->kategori == 'kesehatan' ? 'selected' : '' }}>Kesehatan</option>
                                                <option value="sosial" {{ $item->kategori == 'sosial' ? 'selected' : '' }}>Sosial</option>
                                                <option value="lingkungan" {{ $item->kategori == 'lingkungan' ? 'selected' : '' }}>Lingkungan</option>
                                                <option value="ekonomi" {{ $item->kategori == 'ekonomi' ? 'selected' : '' }}>Ekonomi</option>
                                                <option value="budaya" {{ $item->kategori == 'budaya' ? 'selected' : '' }}>Budaya</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="edit_tanggal_kegiatan_{{ $item->id_galeri }}" class="form-label fw-medium">Tanggal Kegiatan</label>
                                            <input type="date" class="form-control" id="edit_tanggal_kegiatan_{{ $item->id_galeri }}" name="tanggal_kegiatan" value="{{ is_string($item->tanggal_kegiatan) ? \Carbon\Carbon::parse($item->tanggal_kegiatan)->format('Y-m-d') : $item->tanggal_kegiatan->format('Y-m-d') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="upload-area p-4 border rounded-3 text-center">
                                    <div id="editImagePreview{{ $item->id_galeri }}" class="mb-3" style="min-height: 150px; display: flex; align-items: center; justify-content: center; background: #f8f9fa; border-radius: 8px;">
                                        <img src="{{ asset('storage/' . $item->foto) }}" class="img-fluid rounded" alt="Current image" style="max-height: 150px; object-fit: cover;">
                                    </div>
                                    <div class="mb-3">
                                        <label for="edit_foto_{{ $item->id_galeri }}" class="btn btn-outline-primary w-100">
                                            <i class='bx bx-upload me-2'></i>Ganti Gambar
                                            <input type="file" class="d-none" id="edit_foto_{{ $item->id_galeri }}" name="foto" accept="image/*">
                                        </label>
                                        <div class="form-text text-center mt-2">Format: JPG, PNG, atau GIF (Maks. 5MB)<br>Kosongkan jika tidak ingin mengubah foto</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0 bg-light">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                            <i class='bx bx-x me-1'></i> Batal
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class='bx bx-save me-1'></i> Update Foto
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach
</div>

<!-- Modal Tambah Foto -->
<div class="modal fade" id="tambahFotoModal" tabindex="-1" aria-labelledby="tambahFotoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="tambahFotoModalLabel">
                    <i class='bx bx-image-add me-2'></i>Unggah Foto Baru
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.galeri.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="judul_foto" class="form-label fw-medium">Judul Foto <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-lg" id="judul_foto" name="judul_foto" placeholder="Contoh: Kegiatan Vaksinasi 2024" required>
                                <div class="form-text">Masukkan judul yang deskriptif untuk foto Anda</div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="deskripsi" class="form-label fw-medium">Deskripsi (Opsional)</label>
                                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" placeholder="Tambahkan deskripsi singkat tentang foto ini"></textarea>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="kategori" class="form-label fw-medium">Kategori <span class="text-danger">*</span></label>
                                        <select class="form-select" id="kategori" name="kategori" required>
                                            <option value="" disabled selected>Pilih Kategori</option>
                                            <option value="kesehatan">Kesehatan</option>
                                            <option value="sosial">Sosial</option>
                                            <option value="lingkungan">Lingkungan</option>
                                            <option value="ekonomi">Ekonomi</option>
                                            <option value="budaya">Budaya</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="tanggal_kegiatan" class="form-label fw-medium">Tanggal Kegiatan</label>
                                        <input type="date" class="form-control" id="tanggal_kegiatan" name="tanggal_kegiatan" value="{{ date('Y-m-d') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
<div class="col-md-4">
                            <div class="upload-area p-4 border rounded-3 text-center">
                                <div class="mb-3">
                                    <label for="foto" class="btn btn-outline-primary w-100">
                                        <i class='bx bx-upload me-2'></i>Pilih Gambar (Bisa pilih beberapa)
                                        <input type="file" class="d-none" id="foto" name="fotos[]" accept="image/*" multiple>
                                    </label>
                                    <div class="form-text text-center mt-2">Format: JPG, PNG, atau GIF (Maks. 5MB per file)<br>Bisa pilih beberapa foto sekaligus | Drag-drop untuk ubah urutan</div>
                                </div>
                                <!-- Photo list similar to news page -->
                                <div id="galleryPhotoList" class="photo-list"></div>
                                <input type="hidden" id="gallery_foto_utama_index" name="foto_utama_index" value="0">
                            </div>
                        </div>
                    </div>
                </div>
<div class="modal-footer border-top-0 bg-light">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                        <i class='bx bx-x me-1'></i> Batal
                    </button>
                    <button type="button" class="btn btn-primary" onclick="submitGalleryForm()">
                        <i class='bx bx-save me-1'></i> Simpan Foto
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Store selected files for multiple upload (news-style)
    let galleryFiles = [];
    let galleryDragged = null;
    let galleryViewerPhotos = [];
    let galleryViewerIndex = 0;
    let galleryViewerModal = null;

    const galleryUid = (p = 'id') => `${p}_${Math.random().toString(36).slice(2, 10)}`;
    const galleryFlash = {
        success: @json(session('success')),
        error: @json(session('error')),
        errors: @json($errors->any() ? $errors->all() : []),
    };

    function escapeHtml(value) {
        return String(value)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    // Popup notification, matched to admin/data-kelurahan style.
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
            min-width: 280px; max-width: 420px;
        `;
        notification.innerHTML = `
            <i class="bx ${c.icon}" style="font-size: 24px;"></i>
            <span style="font-weight: 500;">${escapeHtml(message)}</span>
        `;

        document.body.appendChild(notification);

        setTimeout(() => {
            notification.style.transform = 'translateX(120%)';
            notification.style.opacity = '0';
            notification.style.transition = 'all 0.4s ease';
            setTimeout(() => notification.remove(), 400);
        }, 3500);
    }

    function showDeleteConfirm(form) {
        const title = form.dataset.title || 'foto ini';
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
                        <strong style="color: #1f2937; font-size: 16px;">"${escapeHtml(title)}"</strong>?
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

        const closeDeleteModal = () => {
            modal.style.opacity = '0';
            modal.style.transform = 'scale(0.9)';
            setTimeout(() => modal.remove(), 300);
        };

        modal.addEventListener('click', function(e) {
            if (e.target === modal || e.target.closest('[data-delete-cancel]')) {
                closeDeleteModal();
            }
            if (e.target.closest('[data-delete-confirm]')) {
                const confirmBtn = e.target.closest('[data-delete-confirm]');
                confirmBtn.innerHTML = '<i class="bx bx-loader-alt bx-spin"></i> Menghapus...';
                confirmBtn.disabled = true;
                showNotification('Menghapus foto galeri...', 'info');
                form.submit();
            }
        });

        document.body.appendChild(modal);
    }

    if (!document.getElementById('gallery-popup-keyframes')) {
        const style = document.createElement('style');
        style.id = 'gallery-popup-keyframes';
        style.textContent = `
            @keyframes slideInRight {
                from { transform: translateX(120%); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
            @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
            @keyframes scaleIn { from { transform: scale(0.9); opacity: 0; } to { transform: scale(1); opacity: 1; } }
        `;
        document.head.appendChild(style);
    }

    // Wire drag and drop for photo list (news-style)
    function galleryWireDnD(container, cb) {
        container.querySelectorAll('.photo-card').forEach(card => {
            card.draggable = true;
            card.ondragstart = () => {
                galleryDragged = card;
                card.classList.add('dragging');
            };
            card.ondragend = () => {
                card.classList.remove('dragging');
                galleryDragged = null;
                if (cb) cb();
            };
            card.ondragover = (e) => {
                e.preventDefault();
                if (!galleryDragged || galleryDragged === card) return;
                const r = card.getBoundingClientRect();
                const before = (e.clientY - r.top) < r.height / 2;
                card.parentNode.insertBefore(galleryDragged, before ? card : card.nextSibling);
            };
        });
    }

    // Render gallery photo list (news-style)
    function galleryRenderPhotos() {
        const box = document.getElementById('galleryPhotoList');
        box.innerHTML = '';
        
        if (galleryFiles.length === 0) {
            box.innerHTML = '<div class="text-center text-muted py-3">Belum ada foto dipilih</div>';
            return;
        }
        
        galleryFiles.forEach((f, i) => {
            const el = document.createElement('div');
            el.className = 'photo-card';
            el.dataset.uid = f.uid;
            el.innerHTML = `
                <img src="${f.preview}">
                <div class="photo-order-label">Urutan #${i + 1}</div>
                <div class="form-check mt-1">
                    <input class="form-check-input gallery-main" type="radio" name="gallery_main" ${f.isMain ? 'checked' : ''} data-uid="${f.uid}">
                    <label class="form-check-label" style="font-size: 11px">Foto Utama</label>
                </div>
                <button type="button" class="btn btn-sm btn-outline-danger remove-photo-btn" data-remove="${f.uid}">Hapus</button>
            `;
            box.appendChild(el);
        });
        
        // Wire drag and drop
        galleryWireDnD(box, () => {
            const ordered = [];
            box.querySelectorAll('.photo-card').forEach(c => {
                const found = galleryFiles.find(f => f.uid === c.dataset.uid);
                if (found) ordered.push(found);
            });
            galleryFiles = ordered.filter(Boolean);
            galleryRenderPhotos();
        });
        
        // Handle main photo selection
        box.querySelectorAll('.gallery-main').forEach(r => {
            r.onchange = function() {
                galleryFiles = galleryFiles.map(f => ({...f, isMain: f.uid === this.dataset.uid}));
                galleryRenderPhotos();
            };
        });
        
        // Handle remove
        box.querySelectorAll('[data-remove]').forEach(b => {
            b.onclick = function() {
                galleryFiles = galleryFiles.filter(f => f.uid !== this.dataset.remove);
                if (!galleryFiles.some(f => f.isMain) && galleryFiles[0]) {
                    galleryFiles[0].isMain = true;
                }
                galleryRenderPhotos();
            };
        });
        
        // Update hidden input for main photo index
        const idx = galleryFiles.findIndex(f => f.isMain);
        document.getElementById('gallery_foto_utama_index').value = idx >= 0 ? idx : 0;
    }

// Auto-play functionality for carousel
    const carouselAutoplayIntervals = {};
    const AUTOPLAY_DELAY = 3000; // 3 seconds per slide

    function toggleCarouselAutoplay(carousel) {
        const carouselId = carousel.closest('.gallery-card')?.dataset?.id || Math.random().toString(36).slice(2, 10);
        
        if (carouselAutoplayIntervals[carouselId]) {
            // Stop autoplay
            clearInterval(carouselAutoplayIntervals[carouselId]);
            delete carouselAutoplayIntervals[carouselId];
            
            const autoplayBtn = carousel.querySelector('.gallery-carousel-autoplay');
            if (autoplayBtn) {
                autoplayBtn.classList.add('paused');
                autoplayBtn.innerHTML = '<i class="bx bx-play"></i> Play';
            }
        } else {
            // Start autoplay
            carouselAutoplayIntervals[carouselId] = setInterval(() => {
                const currentIndex = parseInt(carousel.dataset.currentIndex || '0', 10);
                setGalleryCarousel(carousel, currentIndex + 1);
            }, AUTOPLAY_DELAY);
            
            const autoplayBtn = carousel.querySelector('.gallery-carousel-autoplay');
            if (autoplayBtn) {
                autoplayBtn.classList.remove('paused');
                autoplayBtn.innerHTML = '<i class="bx bx-pause"></i> Pause';
            }
        }
    }

    function setGalleryCarousel(carousel, index) {
        const slides = carousel.querySelectorAll('.gallery-carousel-slide');
        const dots = carousel.querySelectorAll('.gallery-carousel-dot');
        const current = carousel.querySelector('[data-carousel-current]');
        const thumbs = carousel.closest('.gallery-carousel-wrap')?.querySelectorAll('.gallery-carousel-thumb') || [];
        if (!slides.length) return;

        const nextIndex = (index + slides.length) % slides.length;
        carousel.dataset.currentIndex = nextIndex;

        slides.forEach((slide, i) => {
            slide.classList.toggle('active', i === nextIndex);
        });

        dots.forEach((dot, i) => {
            dot.classList.toggle('active', i === nextIndex);
        });

        thumbs.forEach((thumb, i) => {
            thumb.classList.toggle('active', i === nextIndex);
        });

        if (current) {
            current.textContent = nextIndex + 1;
        }
    }

    function moveGalleryCarousel(button, direction) {
        const carousel = button.closest('[data-photo-carousel]');
        if (!carousel) return;
        const currentIndex = parseInt(carousel.dataset.currentIndex || '0', 10);
        setGalleryCarousel(carousel, currentIndex + direction);
    }

    function goToGalleryCarousel(button, index) {
        const carousel = button.closest('.gallery-carousel-wrap')?.querySelector('[data-photo-carousel]')
            || button.closest('[data-photo-carousel]');
        if (!carousel) return;
        setGalleryCarousel(carousel, index);
    }

    function openGalleryViewerFromCard(target) {
        const dataId = target.dataset.galleryViewerId;
        const dataScript = document.getElementById(`gallery-viewer-data-${dataId}`);
        if (!dataScript) return;

        const carousel = target.querySelector('[data-photo-carousel]');
        const startIndex = carousel ? parseInt(carousel.dataset.currentIndex || '0', 10) : 0;

        try {
            openGalleryViewer(JSON.parse(dataScript.textContent), startIndex);
        } catch (error) {
            console.error('Gagal membuka pratinjau galeri:', error);
        }
    }

    function openGalleryViewer(photos, index = 0) {
        if (!Array.isArray(photos) || photos.length === 0) return;

        galleryViewerPhotos = photos;
        galleryViewerIndex = Math.max(0, Math.min(index, photos.length - 1));
        renderGalleryViewer();

        if (!galleryViewerModal) {
            galleryViewerModal = new bootstrap.Modal(document.getElementById('galleryViewerModal'));
        }

        galleryViewerModal.show();
    }

function renderGalleryViewer() {
        const photo = galleryViewerPhotos[galleryViewerIndex];
        if (!photo) return;

        resetGalleryZoom();

        const image = document.getElementById('galleryViewerImage');
        const photoTitle = document.getElementById('galleryViewerPhotoTitle');
        const meta = document.getElementById('galleryViewerPhotoMeta');
        const description = document.getElementById('galleryViewerPhotoDescription');
        const thumbs = document.getElementById('galleryViewerThumbs');
        const counter = document.getElementById('galleryViewerCounter');
        const navButtons = document.querySelectorAll('#galleryViewerModal .gallery-viewer-nav');

        image.src = photo.src;
        image.alt = photo.title || 'Foto galeri';
        photoTitle.textContent = photo.title || 'Tanpa judul';
        counter.textContent = (galleryViewerIndex + 1) + ' / ' + galleryViewerPhotos.length;

        meta.innerHTML = '';
        [
            { icon: 'bx bx-category', text: photo.category },
            { icon: 'bx bx-calendar', text: photo.date }
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

        description.textContent = photo.description || 'Belum terdapat keterangan tambahan untuk foto kegiatan ini.';

        navButtons.forEach(button => {
            button.style.display = galleryViewerPhotos.length > 1 ? 'flex' : 'none';
        });

thumbs.innerHTML = '';
        galleryViewerPhotos.forEach((item, i) => {
            const button = document.createElement('button');
            button.type = 'button';
            button.className = `gallery-viewer-thumb ${i === galleryViewerIndex ? 'active' : ''}`;
            button.title = `Lihat foto ${i + 1}`;
            button.onclick = () => {
                galleryViewerIndex = i;
                renderGalleryViewer();
            };
            button.innerHTML = `<img src="${item.src}" alt="${item.title || 'Foto galeri'}">`;
            thumbs.appendChild(button);
        });
    }

// Zoom functionality matching public gallery
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
            stage: document.getElementById('galleryViewerStage'),
            image: document.getElementById('galleryViewerImage'),
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

function moveGalleryViewer(direction) {
        if (!galleryViewerPhotos.length) return;
        galleryViewerIndex = (galleryViewerIndex + direction + galleryViewerPhotos.length) % galleryViewerPhotos.length;
        renderGalleryViewer();
    }

    // Search and Filter Functions
    function filterGallery() {
        const searchInput = document.getElementById('searchInput');
        const categoryFilter = document.getElementById('categoryFilter');
        const searchTerm = searchInput.value.toLowerCase();
        const category = categoryFilter.value;
        
        const cards = document.querySelectorAll('.gallery-card');
        
        cards.forEach(card => {
            const title = card.querySelector('.card-title').textContent.toLowerCase();
            const description = card.querySelector('.card-description')?.textContent.toLowerCase() || '';
            const badge = card.querySelector('.tag-badge').className;
            const hasCategory = badge.includes(`tag-${category}`);
            
            const matchesSearch = title.includes(searchTerm) || description.includes(searchTerm);
            const matchesCategory = category === '' || hasCategory;
            
            if (matchesSearch && matchesCategory) {
                card.style.display = '';
            } else {
                card.style.display = 'none';
            }
        });
        
        // Update empty state if no results
        const visibleCards = document.querySelectorAll('.gallery-card:not([style*="display: none"])');
        const gridContainer = document.getElementById('galleryGrid');
        let emptyState = gridContainer.querySelector('.empty-state');
        
        if (visibleCards.length === 0) {
            if (!emptyState) {
                emptyState = document.createElement('div');
                emptyState.className = 'empty-state col-12';
                emptyState.innerHTML = `
                    <div class="text-center py-5">
                        <i class='bx bx-search display-1 text-muted'></i>
                        <h4 class="text-muted mt-3">Tidak ada foto ditemukan</h4>
                        <p class="text-muted">Coba ubah kata kunci atau filter</p>
                    </div>
                `;
                gridContainer.appendChild(emptyState);
            }
            emptyState.style.display = '';
        } else if (emptyState) {
            emptyState.style.display = 'none';
        }
    }

    // View Toggle
    let currentView = 'grid';
    function setView(view) {
        const grid = document.getElementById('galleryGrid');
        const buttons = document.querySelectorAll('.view-btn');
        
        currentView = view;
        
        buttons.forEach(btn => btn.classList.remove('active'));
        event.target.closest('.view-btn').classList.add('active');
        
        if (view === 'list') {
            grid.classList.add('list-view');
            showNotification('Tampilan list diaktifkan', 'info');
        } else {
            grid.classList.remove('list-view');
            showNotification('Tampilan grid diaktifkan', 'info');
        }
    }

document.addEventListener('DOMContentLoaded', function() {
        if (galleryFlash.success) {
            showNotification(galleryFlash.success, 'success');
        }

        if (galleryFlash.error) {
            showNotification(galleryFlash.error, 'error');
        }

        if (galleryFlash.errors.length > 0) {
            showNotification(galleryFlash.errors.join(' '), 'warning');
        }

        document.querySelector('.btn-add-photo')?.addEventListener('click', function() {
            showNotification('Form unggah foto dibuka', 'info');
        });

        document.querySelectorAll('[data-bs-target^="#editFotoModal"]').forEach(button => {
            button.addEventListener('click', function() {
                showNotification('Form edit foto dibuka', 'info');
            });
        });

        document.querySelectorAll('.gallery-edit-form').forEach(form => {
            form.addEventListener('submit', function() {
                const submitBtn = form.querySelector('button[type="submit"]');
                if (submitBtn) {
                    submitBtn.innerHTML = '<i class="bx bx-loader-alt bx-spin me-1"></i> Mengupdate...';
                    submitBtn.disabled = true;
                }
                showNotification('Menyimpan perubahan foto...', 'info');
            });
        });

        document.querySelectorAll('.gallery-delete-form').forEach(form => {
            form.addEventListener('submit', function(event) {
                if (form.dataset.confirmed === 'true') return;
                event.preventDefault();
                showDeleteConfirm(form);
            });
        });

        // Note: Drag and drop for gallery grid (Already uploaded photos) is disabled
        // Only the photo selection in "Add Photo" modal is draggable for reordering

        const { stage } = getGalleryZoomElements();
        if (stage) {
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
                galleryPanX = galleryDragOriginX + event.clientX - galleryDragStartX;
                galleryPanY = galleryDragOriginY + event.clientY - galleryDragStartY;
                applyGalleryZoom();
            });

            stage.addEventListener('pointerup', function(event) {
                galleryIsDragging = false;
                stage.classList.remove('is-dragging');
                if (stage.hasPointerCapture(event.pointerId)) {
                    stage.releasePointerCapture(event.pointerId);
                }
            });

            stage.addEventListener('pointercancel', function() {
                galleryIsDragging = false;
                stage.classList.remove('is-dragging');
            });
        }

        // Photo upload handling (news-style)
        document.getElementById('foto').addEventListener('change', function(e) {
            galleryFiles = [];
            if (e.target.files.length > 0) {
                showNotification(`${e.target.files.length} foto dipilih`, 'info');
            }
            Array.from(e.target.files).forEach((file, i) => {
                if (!file.type.match('image.*') || file.size > 5 * 1024 * 1024) {
                    showNotification(`${file.name} dilewati. Format harus gambar dan ukuran maksimal 5MB.`, 'warning');
                    return;
                }
                const fr = new FileReader();
                fr.onload = ev => {
                    galleryFiles.push({
                        uid: galleryUid('g'),
                        file: file,
                        preview: ev.target.result,
                        isMain: i === 0
                    });
                    galleryRenderPhotos();
                };
                fr.readAsDataURL(file);
            });
        });

        // Preview gambar untuk form edit
        @foreach($galeri as $item)
        document.getElementById('edit_foto_{{ $item->id_galeri }}').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('editImagePreview{{ $item->id_galeri }}').innerHTML = 
                        `<img src="${e.target.result}" class="img-fluid rounded" alt="Preview" style="max-height: 150px; object-fit: cover;">`;
                }
                reader.readAsDataURL(file);
            }
        });
        @endforeach

        // Reset form ketika modal ditutup
        document.getElementById('tambahFotoModal').addEventListener('hidden.bs.modal', function () {
            document.querySelector('#tambahFotoModal form').reset();
            galleryFiles = [];
            galleryRenderPhotos();
            showNotification('Form unggah foto ditutup', 'info');
        });
    });

    // Handle multiple file selection
    function handleMultipleFiles(input) {
        const files = input.files;
        const previewContainer = document.getElementById('multiplePreview');
        const singlePreview = document.getElementById('imagePreview');
        
        if (files.length > 0) {
            // Show multiple preview grid
            previewContainer.innerHTML = '';
            singlePreview.style.display = 'none';
            
            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                const reader = new FileReader();
                reader.onload = function(e) {
                    const div = document.createElement('div');
                    div.className = 'upload-preview-item';
                    div.innerHTML = `
                        <img src="${e.target.result}" alt="${file.name}">
                        <button type="button" class="remove-btn" onclick="removeFile(this, ${i})">×</button>
                        <div class="file-name">${file.name}</div>
                    `;
                    previewContainer.appendChild(div);
                }
                reader.readAsDataURL(file);
            }
        } else {
            previewContainer.innerHTML = '';
            singlePreview.style.display = 'flex';
        }
    }

    // Remove file from selection (optional - just clears for UX)
    function removeFile(btn, index) {
        const previewItem = btn.parentElement;
        previewItem.style.opacity = '0.3';
        btn.disabled = true;
        btn.innerHTML = '✓';
        btn.style.background = '#28a745';
        showNotification('Foto ditandai untuk diabaikan dari pilihan', 'info');
    }

    // Submit gallery form (news-style with galleryFiles)
    function submitGalleryForm() {
        // Validate required fields
        const judul = document.getElementById('judul_foto').value;
        const kategori = document.getElementById('kategori').value;
        
        if (!judul || !judul.trim()) {
            showNotification('Mohon masukkan judul foto.', 'warning');
            return;
        }
        
        if (!kategori) {
            showNotification('Mohon pilih kategori.', 'warning');
            return;
        }
        
        if (galleryFiles.length === 0) {
            showNotification('Minimal pilih 1 foto.', 'warning');
            return;
        }

        const submitBtn = document.querySelector('#tambahFotoModal .btn-primary');
        const originalSubmitHtml = submitBtn ? submitBtn.innerHTML : '';
        if (submitBtn) {
            submitBtn.innerHTML = '<i class="bx bx-loader-alt bx-spin me-1"></i> Menyimpan...';
            submitBtn.disabled = true;
        }
        showNotification('Mengunggah foto galeri...', 'info');

        // Create FormData
        const form = document.querySelector('#tambahFotoModal form');
        const fd = new FormData(form);
        fd.delete('fotos[]');
        fd.delete('foto_utama_index');
        
        // Add files once, in the preview order.
        galleryFiles.forEach(f => fd.append('fotos[]', f.file));
        
        // Add main photo index
        const mainIdx = galleryFiles.findIndex(f => f.isMain);
        fd.set('foto_utama_index', String(mainIdx >= 0 ? mainIdx : 0));

        // Submit via fetch with proper error handling
        fetch('{{ route("admin.galeri.store") }}', {
            method: 'POST',
            body: fd,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            // First check if response is OK (status 200-299) and handle redirects
            if (!response.ok) {
                // Handle redirect (302) - session might be expired
                if (response.type === 'opaque' || response.redirected || response.status === 302) {
                    showNotification('Sesi berakhir. Silakan login ulang.', 'warning');
                    window.location.href = '/login';
                    throw new Error('Session expired');
                }
                throw new Error('Server error: ' + response.status);
            }
            
            // Check content type
            const contentType = response.headers.get('content-type') || '';
            
            if (contentType.includes('application/json')) {
                return response.json().then(data => {
                    if (data.success) {
                        showNotification(data.message || 'Foto berhasil ditambahkan!', 'success');
                        window.location.reload();
                    } else {
                        showNotification(data.message || 'Gagal menyimpan foto', 'error');
                    }
                });
            } else {
                // HTML response - try to parse as text
                return response.text().then(text => {
                    console.error('Non-JSON response:', text.substring(0, 500));
                    // Check if it's a login redirect
                    if (text.includes('login') || text.includes('Login')) {
                        showNotification('Sesi berakhir. Silakan login ulang.', 'warning');
                        window.location.href = '/login';
                    } else if (text.includes('<!DOCTYPE') || text.includes('<html')) {
                        // It's an HTML error page
                        showNotification('Terjadi kesalahan pada server. Silakan coba lagi atau hubungi administrator.', 'error');
                    } else {
                        showNotification('Terjadi kesalahan: ' + text.substring(0, 100), 'error');
                    }
                });
            }
        })
        .catch(err => {
            console.error('Fetch error:', err);
            if (err.message === 'Session expired') return;
            showNotification('Terjadi kesalahan: ' + err.message, 'error');
        })
        .finally(() => {
            if (submitBtn) {
                submitBtn.innerHTML = originalSubmitHtml;
                submitBtn.disabled = false;
            }
        });
    }
</script>
@endpush
@endsection
