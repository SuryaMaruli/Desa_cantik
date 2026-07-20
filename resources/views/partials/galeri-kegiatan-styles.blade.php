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

