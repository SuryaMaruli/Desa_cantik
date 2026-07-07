@extends('layouts.app')

@section('title', 'Kontak - Kelurahan Gunung Sugih')

@section('content')
    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <h1>Hubungi Kami</h1>
            <p class="lead">Silakan hubungi kami untuk informasi lebih lanjut</p>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="contact">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="contact-info">
                        <div class="row">
                            <div class="col-md-4 text-center mb-4">
                                <div class="contact-item">
                                    <i class="bi bi-geo-alt text-success" style="font-size: 2rem;"></i>
                                    <h5 class="mt-3">Alamat</h5>
                                    <p>Jl. Sunan Kalijaga No.36, Gunungsugih<br>Ciwandan, Cilegon</p>
                                </div>
                            </div>
                            <div class="col-md-4 text-center mb-4">
                                <div class="contact-item">
                                    <i class="bi bi-telephone text-success" style="font-size: 2rem;"></i>
                                    <h5 class="mt-3">Telepon</h5>
                                    <p>{{ App\Models\Beranda::first()?->no_hp ?? '(0251) 123456' }}</p>
                                </div>
                            </div>
                            <div class="col-md-4 text-center mb-4">
                                <div class="contact-item">
                                    <i class="bi bi-envelope text-success" style="font-size: 2rem;"></i>
                                    <h5 class="mt-3">Email</h5>
                                    <p>{{ App\Models\Beranda::first()?->email ?? 'info@bulakan.go.id' }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="text-center mt-4">
                            <h5>Jam Operasional</h5>
                            <p>Senin - Kamis: 08:00 - 15:00<br>Jumat: 08:00 - 11:00<br>Sabtu - Minggu: Tutup</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

