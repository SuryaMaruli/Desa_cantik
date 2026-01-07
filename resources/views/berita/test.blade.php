@extends('layouts.app')

@section('title', 'Berita & Informasi')

@section('content')
<div class="container">
    <h1>Berita & Informasi</h1>
    
    @if($beritas->count() > 0)
        <div class="alert alert-success">
            Found {{ $beritas->count() }} berita(s)
        </div>
        
        @foreach($beritas as $berita)
            <div class="card mb-3">
                <div class="card-body">
                    <h3>{{ $berita->judul }}</h3>
                    <p>{{ Str::limit($berita->konten, 100) }}</p>
                    <small>{{ $berita->tanggal_publikasi->format('d M Y') }}</small>
                </div>
            </div>
        @endforeach
        
        <div class="mt-4">
            {{ $beritas->links() }}
        </div>
    @else
        <div class="alert alert-warning">
            Tidak ada berita yang dipublikasikan.
        </div>
    @endif
</div>
@endsection
