@extends('layouts.app')

@section('title', 'Kata Sambutan Lurah - Kelurahan Citangkil')

@section('content')
<style>
    .sambutan-page {
        background: #fffaf3;
        padding: 50px 20px 80px;
    }

    .sambutan-container {
        max-width: 1100px;
        margin: 0 auto;
    }

    .sambutan-header {
        text-align: center;
        margin-bottom: 36px;
    }

    .sambutan-header h1 {
        color: #e65100;
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .sambutan-header p {
        color: #666;
        font-size: 1rem;
    }

    .sambutan-card {
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 14px 40px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        display: grid;
        grid-template-columns: 320px 1fr;
        min-height: 500px;
    }

    .sambutan-left {
        background: linear-gradient(160deg, #ff5722 0%, #d50000 100%);
        padding: 28px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: #fff;
    }

    .photo-frame {
        width: 100%;
        max-width: 250px;
        height: 320px;
        background: #fff;
        border-radius: 12px;
        padding: 10px;
        box-shadow: 0 10px 24px rgba(0, 0, 0, 0.25);
        margin-bottom: 18px;
    }

    .photo-frame img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 8px;
    }

    .name-box {
        width: 100%;
        max-width: 250px;
        background: rgba(80, 0, 0, 0.28);
        border: 1px solid rgba(255,255,255,0.25);
        border-radius: 12px;
        text-align: center;
        padding: 14px;
    }

    .name-box span {
        display: block;
        font-size: 0.9rem;
        opacity: 0.9;
        margin-bottom: 4px;
    }

    .name-box h2 {
        font-size: 1.08rem;
        text-transform: uppercase;
        margin: 0;
        letter-spacing: 0.4px;
    }

    .sambutan-right {
        padding: 50px;
    }

    .quote-icon {
        font-size: 46px;
        color: transparent;
        -webkit-text-stroke: 2px #ff6d00;
        margin-bottom: 14px;
        display: inline-block;
    }

    .sambutan-text {
        color: #4a4a4a;
        font-size: 1.02rem;
        line-height: 1.95;
        text-align: justify;
        white-space: pre-line;
    }

    @media (max-width: 900px) {
        .sambutan-card {
            grid-template-columns: 1fr;
        }

        .sambutan-right {
            padding: 30px 22px;
        }

        .sambutan-header h1 {
            font-size: 1.6rem;
        }
    }
</style>

<section class="sambutan-page">
    <div class="sambutan-container">
        <div class="sambutan-header">
            <h1>Kata Sambutan Lurah</h1>
            <p>Kelurahan Citangkil</p>
        </div>

        <div class="sambutan-card">
            <div class="sambutan-left">
                <div class="photo-frame">
                    @if($dataLurah && $dataLurah->foto_lurah)
                        <img src="{{ asset('storage/foto-lurah/' . $dataLurah->foto_lurah) }}" alt="Foto Lurah">
                    @else
                        <img src="https://via.placeholder.com/300x400/eeeeee/333333?text=FOTO+LURAH" alt="Foto Lurah">
                    @endif
                </div>
                <div class="name-box">
                    <span>{{ $dataLurah->jabatan ?? 'Lurah Citangkil' }}</span>
                    <h2>{{ $dataLurah->nama_lurah ?? 'M. ALI WAHIDI, S.Sos.M.Si' }}</h2>
                </div>
            </div>

            <div class="sambutan-right">
                <i class="fas fa-quote-left quote-icon"></i>
                <div class="sambutan-text">
                    {{ $dataLurah->sambutan_lurah ?? 'Situs web ini kami hadirkan sebagai wadah untuk mempublikasi atau informasi kepada masyarakat. Dengan kemudahan yang diberikan, diharapkan dapat mempercepat proses pelayanan publik dan mempermudah masyarakat dalam memperoleh informasi terkini.' }}
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
