@extends('layouts.app')

@section('title', 'Data - Kelurahan Citangkil')

@section('content')
    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <h1>Data Kelurahan</h1>
            <p class="lead">Informasi statistik dan data demografi Kelurahan Citangkil</p>
        </div>
    </section>

    <!-- Data Overview Section -->
    <section class="about">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="data-overview">
                        <h2>Ringkasan Data</h2>
                        <div class="row">
                            <div class="col-md-3 col-sm-6 mb-4">
                                <div class="stat-card">
                                    <div class="stat-icon">
                                        <i class="bi bi-people-fill"></i>
                                    </div>
                                    <div class="stat-content">
                                        <h3>5.234</h3>
                                        <p>Total Penduduk</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 mb-4">
                                <div class="stat-card">
                                    <div class="stat-icon">
                                        <i class="bi bi-house-fill"></i>
                                    </div>
                                    <div class="stat-content">
                                        <h3>1.567</h3>
                                        <p>Kepala Keluarga</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 mb-4">
                                <div class="stat-card">
                                    <div class="stat-icon">
                                        <i class="bi bi-person-badge-fill"></i>
                                    </div>
                                    <div class="stat-content">
                                        <h3>450</h3>
                                        <p>Laki-laki</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 mb-4">
                                <div class="stat-card">
                                    <div class="stat-icon">
                                        <i class="bi bi-gender-female"></i>
                                    </div>
                                    <div class="stat-content">
                                        <h3>2.556</h3>
                                        <p>Perempuan</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detailed Data Tables -->
            <div class="row mt-5">
                <div class="col-lg-6 mb-4">
                    <div class="info-card">
                        <h3><i class="bi bi-graph-up me-2"></i>Data Kependudukan</h3>
                        <div class="table-responsive">
                            <table class="data-table">
                                <thead>
                                    <tr>
                                        <th>Kategori</th>
                                        <th>Jumlah</th>
                                        <th>Persentase</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Bayi (0-4 tahun)</td>
                                        <td>423</td>
                                        <td>8.1%</td>
                                    </tr>
                                    <tr>
                                        <td>Anak-anak (5-14 tahun)</td>
                                        <td>892</td>
                                        <td>17.0%</td>
                                    </tr>
                                    <tr>
                                        <td>Remaja (15-24 tahun)</td>
                                        <td>1.234</td>
                                        <td>23.6%</td>
                                    </tr>
                                    <tr>
                                        <td>Dewasa (25-59 tahun)</td>
                                        <td>2.345</td>
                                        <td>44.8%</td>
                                    </tr>
                                    <tr>
                                        <td>Lansia (60+ tahun)</td>
                                        <td>340</td>
                                        <td>6.5%</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="info-card">
                        <h3><i class="bi bi-building me-2"></i>Data Sarana & Prasarana</h3>
                        <div class="table-responsive">
                            <table class="data-table">
                                <thead>
                                    <tr>
                                        <th>Sarana</th>
                                        <th>Jumlah</th>
                                        <th>Kondisi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Sekolah</td>
                                        <td>5</td>
                                        <td><span class="badge bg-success">Baik</span></td>
                                    </tr>
                                    <tr>
                                        <td>Puskesmas</td>
                                        <td>2</td>
                                        <td><span class="badge bg-success">Baik</span></td>
                                    </tr>
                                    <tr>
                                        <td>Posyandu</td>
                                        <td>3</td>
                                        <td><span class="badge bg-warning">Sedang</span></td>
                                    </tr>
                                    <tr>
                                        <td>Masjid</td>
                                        <td>8</td>
                                        <td><span class="badge bg-success">Baik</span></td>
                                    </tr>
                                    <tr>
                                        <td>Gedung Olahraga</td>
                                        <td>4</td>
                                        <td><span class="badge bg-info">Perlu Perhatian</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Download Section -->
            <div class="row mt-4">
                <div class="col-lg-12 text-center">
                    <div class="download-section">
                        <h3>Unduh Data Lengkap</h3>
                        <p>Download data statistik kelurahan dalam format PDF atau Excel</p>
                        <div class="mt-3">
                            <a href="#" class="btn btn-primary me-3">
                                <i class="bi bi-file-earmark-pdf me-2"></i>Download PDF
                            </a>
                            <a href="#" class="btn btn-success">
                                <i class="bi bi-file-earmark-excel me-2"></i>Download Excel
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('styles')
<style>
    .stat-card {
        background: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        text-align: center;
        height: 100%;
    }

    .stat-icon {
        font-size: 2.5rem;
        color: #009688;
        margin-bottom: 15px;
    }

    .stat-content h3 {
        font-size: 2rem;
        font-weight: 700;
        color: #009688;
        margin-bottom: 5px;
    }

    .stat-content p {
        color: #666;
        margin: 0;
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 15px;
    }

    .data-table th {
        background: #f8f9fa;
        border: 1px solid #dee2e6;
        padding: 12px;
        text-align: left;
        font-weight: 600;
        color: #495057;
    }

    .data-table td {
        border: 1px solid #dee2e6;
        padding: 10px 12px;
        vertical-align: middle;
    }

    .data-table tr:nth-child(even) {
        background: #f8f9fa;
    }

    .badge {
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 500;
    }

    .download-section {
        background: #f8f9fa;
        padding: 30px;
        border-radius: 10px;
        border: 2px dashed #009688;
    }

    .download-section h3 {
        color: #009688;
        margin-bottom: 15px;
    }
</style>
@endpush
