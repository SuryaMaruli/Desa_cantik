@extends('layouts.app')

@section('title', 'Berita & Informasi - Kelurahan Citangkil')

@section('content')
    <style>
        body {
            background-color: #ffffff;
            color: #1f2937;
            padding: 80px 20px;
            text-align: center;
            font-family: 'Segoe UI', Roboto, sans-serif;
        }
        
        .empty-state {
            max-width: 600px;
            margin: 0 auto;
        }
        
        .empty-icon {
            width: 120px;
            height: 120px;
            margin: 0 auto 30px;
            background: linear-gradient(135deg, #f48c06 0%, #f35525 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 3rem;
        }
        
        .empty-title {
            font-size: 2rem;
            color: #1f2937;
            margin-bottom: 15px;
            font-weight: 600;
        }
        
        .empty-description {
            font-size: 1.1rem;
            color: #6b7280;
            line-height: 1.6;
        }
    </style>

    <div class="empty-state">
        <div class="empty-icon">
            📰
        </div>
        <h1 class="empty-title">Halaman Berita Sedang Dikosongkan</h1>
        <p class="empty-description">
            Halaman berita sedang dalam perbaikan atau pengembangan. Silakan kembali lagi beberapa saat lagi.
        </p>

            </div>

        <!-- Pagination -->
        @if($beritas->hasPages())
            <div style="margin-top: 50px; text-align: center;">
                {{ $beritas->links() }}
            </div>
        @endif
    </div>

    <!-- Filter Script -->
    <script>
    function filterBerita(category) {
        if (category === 'Semua') {
            window.location.href = '{{ route("berita.index") }}';
        } else {
            window.location.href = `{{ route("berita.filter", ":category") }}`.replace(':category', category);
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const currentUrl = window.location.pathname;
        const filterButtons = document.querySelectorAll('.filter-btn');
        
        // Set active button based on current URL
        if (currentUrl.includes('/kategori/')) {
            const urlCategory = currentUrl.split('/').pop();
            filterButtons.forEach(btn => {
                btn.classList.remove('active');
                if (btn.textContent.toLowerCase() === urlCategory.toLowerCase()) {
                    btn.classList.add('active');
                }
            });
        } else {
            // Set "Semua" as active if on main page
            filterButtons.forEach(btn => {
                btn.classList.remove('active');
                if (btn.textContent === 'Semua') {
                    btn.classList.add('active');
                }
            });
        }
    });
    </script>
@endsection