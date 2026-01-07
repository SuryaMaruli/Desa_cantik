@extends('layouts.app')

@section('title', 'Data Kelurahan - Dashboard')

@section('content')
    <style>
        /* Reset & Base Styles */
        :root {
            --primary-green: #F6903A;
            --light-green-bg: #e0f2f1;
            --text-color: #333;
            --text-muted: #666;
            --card-bg: #ffffff;
            --blue-accent: #039be5;
            --pink-accent: #f06292;
            --bg-color: #f4f6f8;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-color);
            overflow-x: hidden;
        }

        /* Header */
        .header {
            background-color: var(--primary-green);
            color: white;
            padding: 40px 0 80px 0; /* Extra padding bottom for overlap effect */
            margin-bottom: 20px;
        }

        .container {
            width: 95%;
            max-width: none;
            margin: 0 auto;
            padding: 0 20px;
        }

        .header h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .header p {
            font-size: 1rem;
            opacity: 0.9;
            max-width: 600px;
            line-height: 1.5;
        }

        /* Layout Grid & Flex */
        .main-content {
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        /* Cards */
        .card {
            background: var(--card-bg);
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }

        /* Card background colors */
        .card-green { background-color: #e8f5e9; }
        .card-blue { background-color: #e3f2fd; }
        .card-pink { background-color: #fce4ec; }

        /* Summary Cards (Top Row) */
        .summary-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 24px;
        }

        .stat-card .card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 20px;
        }

        .icon-box {
            width: 48px;
            height: 48px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }

        .icon-box.green { background: #e0f2f1; color: var(--primary-green); }
        .icon-box.blue { background: #e1f5fe; color: var(--blue-accent); }
        .icon-box.pink { background: #fce4ec; color: var(--pink-accent); }

        .badge {
            font-size: 0.85rem;
            font-weight: 600;
        }
        .badge.green-text { color: var(--primary-green); }
        .badge.blue-text { color: var(--blue-accent); }
        .badge.pink-text { color: var(--pink-accent); }

        .stat-card .card-body p {
            color: var(--text-muted);
            font-size: 0.9rem;
            margin-bottom: 8px;
        }

        .stat-card .card-body h2 {
            font-size: 2rem;
            font-weight: 700;
        }

        /* Charts Generic */
        h3 {
            color: var(--primary-green);
            margin-bottom: 20px;
            font-size: 1.2rem;
            font-weight: 600;
        }

        .chart-container {
            position: relative;
            height: 300px;
            width: 100%;
        }

        /* Pie Charts Row */
        .charts-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 24px;
        }

        .chart-container-pie {
            position: relative;
            height: 250px;
            display: flex;
            justify-content: center;
        }

        .pie-legend {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
            text-align: center;
            padding: 0 40px;
        }

        .pie-legend h3 {
            color: var(--text-color);
            margin-bottom: 0;
            font-size: 1.1rem;
        }

        .pie-legend span {
            font-size: 0.85rem;
            color: var(--text-muted);
        }

        /* Additional Info Section */
        .info-card-wrapper {
            background-color: #e8f5e9; /* Light green bg */
            border: none;
            margin-bottom: 20px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }

        .info-item {
            background: white;
            padding: 20px;
            border-radius: 10px;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .info-label {
            font-size: 0.85rem;
            color: var(--primary-green);
            font-weight: 500;
        }

        .info-value {
            font-size: 1.2rem;
            font-weight: 600;
            color: #333;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .header {
                padding-bottom: 60px;
            }
            .header h1 {
                font-size: 1.8rem;
            }
            .charts-row {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <header class="header">
        <div class="container">
            <h1>Data Kelurahan</h1>
            <p>Data statistik dan informasi kependudukan Kelurahan Citangkil yang transparan dan akurat</p>
        </div>
    </header>

    <div class="container main-content">
        
        <section class="summary-cards">
            <div class="card stat-card card-green">
                <div class="card-header">
                    <div class="icon-box green">
                        <i class="fas fa-users"></i>
                    </div>
                    <span class="badge green-text"><i class="fas fa-arrow-up"></i> +2.5%</span>
                </div>
                <div class="card-body">
                    <p>Total Penduduk</p>
                    <h2>{{ number_format($totalPenduduk, 0, ',', '.') }}</h2>
                </div>
            </div>

            <div class="card stat-card card-blue">
                <div class="card-header">
                    <div class="icon-box blue">
                        <i class="fas fa-male"></i>
                    </div>
                    <span class="badge blue-text"><i class="fas fa-arrow-up"></i> +2.3%</span>
                </div>
                <div class="card-body">
                    <p>Jumlah Penduduk Pria</p>
                    <h2>{{ number_format($lakiLaki, 0, ',', '.') }}</h2>
                </div>
            </div>

            <div class="card stat-card card-pink">
                <div class="card-header">
                    <div class="icon-box pink">
                        <i class="fas fa-female"></i>
                    </div>
                    <span class="badge pink-text"><i class="fas fa-arrow-up"></i> +2.7%</span>
                </div>
                <div class="card-body">
                    <p>Jumlah Penduduk Wanita</p>
                    <h2>{{ number_format($perempuan, 0, ',', '.') }}</h2>
                </div>
            </div>
        </section>

        <section class="chart-section full-width">
            <div class="card">
                <h3>Data Penduduk per RW</h3>
                <div class="chart-container">
                    <canvas id="barChartRW"></canvas>
                </div>
            </div>
        </section>

        <section class="charts-row">
            <div class="card">
                <h3>Sebaran Berdasarkan Jenis Kelamin</h3>
                <div class="chart-container-pie">
                    <canvas id="pieChartGender"></canvas>
                </div>
                <div class="pie-legend">
                    <div>
                        <h3>{{ number_format($lakiLaki, 0, ',', '.') }}</h3>
                        <span>Laki-laki</span>
                    </div>
                    <div>
                        <h3>{{ number_format($perempuan, 0, ',', '.') }}</h3>
                        <span>Perempuan</span>
                    </div>
                </div>
            </div>

            <div class="card">
                <h3>Sebaran Berdasarkan RW</h3>
                <div class="chart-container-pie">
                    <canvas id="pieChartRW"></canvas>
                </div>
            </div>
        </section>

        <section class="info-section">
            <div class="card info-card-wrapper">
                <h3>Informasi Tambahan</h3>
                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">Kepadatan Penduduk</span>
                        <span class="info-value">2,981 jiwa/km²</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Rata-rata Anggota KK</span>
                        <span class="info-value">3.2 jiwa</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Tingkat Partisipasi</span>
                        <span class="info-value">87.5%</span>
                    </div>
                </div>
            </div>
        </section>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // --- Konfigurasi Warna ---
            const colorBlue = '#039be5';
            const colorPink = '#f06292';
            const colorPiePalette = [
                '#4caf50', '#2196f3', '#9c27b0', '#e91e63', '#00bcd4', '#f44336', '#ff9800', '#8bc34a'
            ];

            // --- 1. Bar Chart (Data Penduduk per RW) ---
            const ctxBar = document.getElementById('barChartRW').getContext('2d');
            new Chart(ctxBar, {
                type: 'bar',
                data: {
                    labels: @json($rwLabels),
                    datasets: [
                        {
                            label: 'Laki-laki',
                            data: @json($rwLakiData),
                            backgroundColor: colorBlue,
                            borderRadius: 4,
                            barPercentage: 0.7,
                            categoryPercentage: 0.8
                        },
                        {
                            label: 'Perempuan',
                            data: @json($rwPerempuanData),
                            backgroundColor: colorPink,
                            borderRadius: 4,
                            barPercentage: 0.7,
                            categoryPercentage: 0.8
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: { usePointStyle: true, padding: 20 }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { borderDash: [2, 4], color: '#eee' },
                            ticks: { maxTicksLimit: 6 }
                        },
                        x: {
                            grid: { display: false }
                        }
                    }
                }
            });

            // --- 2. Pie Chart (Jenis Kelamin) ---
            const ctxPieGender = document.getElementById('pieChartGender').getContext('2d');
            new Chart(ctxPieGender, {
                type: 'pie',
                data: {
                    labels: ['Laki-laki', 'Perempuan'],
                    datasets: [{
                        data: [{{ $lakiLaki }}, {{ $perempuan }}],
                        backgroundColor: [colorBlue, colorPink],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.label + ': ' + context.raw + '%';
                                }
                            }
                        }
                    }
                }
            });

            // --- 3. Pie Chart (Sebaran RW) ---
            const ctxPieRW = document.getElementById('pieChartRW').getContext('2d');
            new Chart(ctxPieRW, {
                type: 'pie',
                data: {
                    labels: @json($rwPieLabels),
                    datasets: [{
                        data: @json($rwPieData),
                        backgroundColor: colorPiePalette,
                        borderWidth: 1,
                        borderColor: '#fff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'right',
                            labels: {
                                boxWidth: 10,
                                font: { size: 10 }
                            }
                        }
                    }
                }
            });
        });
    </script>
@endsection
