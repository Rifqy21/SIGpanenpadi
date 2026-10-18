@extends('admin.layouts.app')

@section('styles')
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        /* ---------- Base ---------- */
        .dash-page {
            --dash-primary: #5A67D8;
            --dash-ink: #1A202C;
            --dash-muted: #64748B;
            --dash-border: #E5E7EF;
        }

        /* ---------- Filter bar ---------- */
        .dash-filter {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 14px;
            padding: 16px 20px;
            margin-bottom: 20px;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 8px 30px rgba(15, 23, 42, .06);
        }

        .dash-filter .filter-count {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 14px;
            margin: 0;
            border-radius: 12px;
            background: #EEF0FF;
            color: var(--dash-primary);
            font-size: .8rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: .04em;
            white-space: nowrap;
            cursor: default;
        }

        .dash-filter .filter-count .num {
            font-size: 1.1rem;
            font-weight: 800;
            line-height: 1;
        }

        .dash-filter .filter-select {
            flex: 1 1 260px;
            max-width: 360px;
        }

        .dash-filter .filter-hint {
            margin-left: auto;
            font-size: .82rem;
            color: var(--dash-muted);
        }

        /* ---------- Select2 ---------- */
        .select2-container {
            width: 100% !important;
        }

        .select2-container .select2-selection--single {
            height: 42px;
            border: 1px solid var(--dash-border);
            border-radius: 11px;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 40px;
            font-size: .875rem;
            color: var(--dash-ink);
            padding-left: 12px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 40px;
        }

        .select2-container--default.select2-container--focus .select2-selection--single,
        .select2-container--default.select2-container--open .select2-selection--single {
            border-color: var(--dash-primary);
            box-shadow: 0 0 0 4px rgba(90, 103, 216, .14);
        }

        /* ---------- Section title (tanpa icon) ---------- */
        .section-title {
            font-size: .95rem;
            font-weight: 800;
            color: var(--dash-ink);
            margin: 6px 0 14px;
        }

        /* ---------- KPI cards (garis warna di kiri) ---------- */
        .stat-card {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 14px 12px 16px;
            border-radius: 14px;
            background: #fff;
            box-shadow: 0 8px 30px rgba(15, 23, 42, .06);
            border-left: 4px solid var(--kpi-color, #5A67D8);
            height: 100%;
            transition: transform .2s, box-shadow .2s;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 14px 34px rgba(15, 23, 42, .1);
        }

        .stat-card.kpi-green  { --kpi-color: #10B981; }
        .stat-card.kpi-amber  { --kpi-color: #F59E0B; }
        .stat-card.kpi-indigo { --kpi-color: #5A67D8; }
        .stat-card.kpi-rose   { --kpi-color: #F43F5E; }

        .stat-icon {
            flex-shrink: 0;
            width: 30px;
            height: 30px;
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: color-mix(in srgb, var(--kpi-color) 14%, #fff);
        }

        .stat-icon i {
            font-size: .72rem !important;
            color: var(--kpi-color) !important;
        }

        .stat-label {
            font-size: .66rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .04em;
            color: var(--dash-muted);
            margin-bottom: 2px;
            line-height: 1.3;
        }

        .stat-value {
            font-size: 1.05rem;
            font-weight: 800;
            color: var(--dash-ink);
            line-height: 1.2;
        }

        .stat-unit {
            font-size: .7rem;
            font-weight: 600;
            color: var(--dash-muted);
        }

        /* ---------- Chart cards ---------- */
        .chart-card {
            border: 0;
            border-radius: 16px;
            box-shadow: 0 8px 30px rgba(15, 23, 42, .06);
        }

        .chart-card .card-header {
            background: #fff;
            border: 0;
            padding: 18px 20px 0;
        }

        .chart-card .chart-title {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1rem;
            font-weight: 800;
            margin: 0;
            color: var(--dash-ink);
        }

        .chart-card .t-icon {
            width: 32px;
            height: 32px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .85rem;
            color: #fff;
        }

        .chart-card .chart-sub {
            font-size: .78rem;
            color: var(--dash-muted);
            margin: 4px 0 0 42px;
        }

        .chart-card .card-body {
            padding: 16px 20px 20px;
        }

        .chart-box {
            position: relative;
            height: 260px;
        }

        @media (max-width: 576px) {
            .dash-filter .filter-hint {
                margin-left: 0;
            }
        }
    </style>
@endsection

@section('content')
    <!-- Content Wrapper -->
    <div class="content-wrapper dash-page">

        <!-- Content Header -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0" style="font-size:1.5rem;font-weight:800;">Statistik Panen Padi</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right bg-transparent p-0 m-0">
                            <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i> Home</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">

                <!-- Filter provinsi + jumlah provinsi -->
                <div class="dash-filter">
                    <label for="provinsi" class="filter-count">
                        <i class="fas fa-map-marked-alt"></i>
                        <span class="num">{{ $jumlahProvinsi }}</span> Provinsi
                    </label>
                    <div class="filter-select">
                        <select name="provinsi" id="provinsi" class="form-control">
                            @foreach ($provinsi as $p)
                                <option value="{{ $p->nama_provinsi }}">{{ $p->nama_provinsi }}</option>
                            @endforeach
                        </select>
                    </div>
                    <span class="filter-hint">
                        <i class="fas fa-info-circle mr-1"></i> Data ringkasan mengikuti provinsi yang dipilih
                    </span>
                </div>

                <!-- Statistik -->
                <div class="section-title">Ringkasan Provinsi Terpilih</div>
                <div class="row">
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="stat-card kpi-green">
                            <div class="stat-icon"><i class="fas fa-seedling"></i></div>
                            <div>
                                <div class="stat-label">Total Luas Panen</div>
                                <div class="stat-value"><span id="stat-luas">-</span> <span class="stat-unit">Ha</span></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="stat-card kpi-amber">
                            <div class="stat-icon"><i class="fas fa-weight"></i></div>
                            <div>
                                <div class="stat-label">Total Produksi</div>
                                <div class="stat-value"><span id="stat-produksi">-</span> <span class="stat-unit">Ton</span></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="stat-card kpi-rose">
                            <div class="stat-icon"><i class="fas fa-chart-line"></i></div>
                            <div>
                                <div class="stat-label">Rata-rata Produktivitas</div>
                                <div class="stat-value"><span id="stat-produktivitas">-</span> <span class="stat-unit">Ku/Ha</span></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="stat-card kpi-indigo">
                            <div class="stat-icon"><i class="fas fa-calendar-alt"></i></div>
                            <div>
                                <div class="stat-label">Jumlah Tahun Data</div>
                                <div class="stat-value"><span id="stat-tahun">-</span> <span class="stat-unit">Tahun</span></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Grafik -->
                <div class="section-title">Tren Panen per Tahun</div>
                <div class="row">
                    <div class="col-lg-4 mb-4">
                        <div class="card chart-card h-100">
                            <div class="card-header">
                                <h3 class="chart-title">
                                    <span class="t-icon" style="background:linear-gradient(135deg,#10B981,#34D399);"><i class="fas fa-seedling"></i></span>
                                    Luas Panen
                                </h3>
                                <p class="chart-sub">Satuan Hektar (Ha)</p>
                            </div>
                            <div class="card-body">
                                <div class="chart-box">
                                    <canvas id="luasPanenChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 mb-4">
                        <div class="card chart-card h-100">
                            <div class="card-header">
                                <h3 class="chart-title">
                                    <span class="t-icon" style="background:linear-gradient(135deg,#F59E0B,#FBBF24);"><i class="fas fa-weight"></i></span>
                                    Produksi Panen
                                </h3>
                                <p class="chart-sub">Satuan Ton</p>
                            </div>
                            <div class="card-body">
                                <div class="chart-box">
                                    <canvas id="produksiPanenChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 mb-4">
                        <div class="card chart-card h-100">
                            <div class="card-header">
                                <h3 class="chart-title">
                                    <span class="t-icon" style="background:linear-gradient(135deg,#5A67D8,#8B5CF6);"><i class="fas fa-chart-line"></i></span>
                                    Produktivitas Panen
                                </h3>
                                <p class="chart-sub">Satuan Ku/Ha</p>
                            </div>
                            <div class="card-body">
                                <div class="chart-box">
                                    <canvas id="produktifitasPanenChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </div>
    <!-- /.content-wrapper -->
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    @if (session('info'))
        <script>
            $(document).Toasts('create', { class: 'bg-info', title: 'Informasi', body: @json(session('info')) });
        </script>
    @endif
    @if (session('error'))
        <script>
            $(document).Toasts('create', { class: 'bg-danger', title: 'Gagal', body: @json(session('error')) });
        </script>
    @endif
    @if ($errors->any())
        <script>
            @foreach ($errors->all() as $error)
                $(document).Toasts('create', { class: 'bg-danger', title: 'Gagal', body: @json($error) });
            @endforeach
        </script>
    @endif

    <script>
        // Data dari PHP, diambil sekali saat halaman dimuat
        const DATA_BPS = @json($dataBps);

        // Chart disimpan di variabel global agar bisa di-destroy saat provinsi berganti
        let luasPanenChart, produksiPanenChart, produktifitasPanenChart;

        const fmt = (n, digit = 2) =>
            Number(n || 0).toLocaleString('id-ID', { minimumFractionDigits: 0, maximumFractionDigits: digit });

        // Ubah string ke angka (mendukung koma sebagai desimal)
        const toNum = v => parseFloat(String(v ?? 0).replace(',', '.')) || 0;

        function buatChart(canvasId, label, labels, values, warna) {
            const ctx = document.getElementById(canvasId).getContext('2d');

            return new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: label,
                        data: values,
                        borderColor: warna.garis,
                        backgroundColor: warna.isi,
                        borderWidth: 2.5,
                        fill: true,
                        tension: .35,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: warna.garis,
                        pointBorderWidth: 2,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: { mode: 'index', intersect: false },
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#1A202C',
                            padding: 10,
                            cornerRadius: 10,
                        }
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                            ticks: { color: '#64748B' }
                        },
                        y: {
                            beginAtZero: true,
                            grid: { color: '#F1F3F9' },
                            ticks: { color: '#64748B' }
                        }
                    }
                }
            });
        }

        function getChart() {
            const provinsi = $('#provinsi').val();

            // Filter data sesuai provinsi terpilih, lalu urutkan berdasarkan tahun
            const dataFiltered = DATA_BPS
                .filter(d => d.provinsi === provinsi)
                .map(d => ({
                    tahun: d.tahun,
                    luas_panen: toNum(d.luas_panen),
                    produksi: toNum(d.produksi),
                    produktifitas: toNum(d.produktifitas),
                }))
                .sort((a, b) => Number(a.tahun) - Number(b.tahun));

            const labels = dataFiltered.map(d => d.tahun);

            // Update kartu ringkasan
            const totalLuas = dataFiltered.reduce((s, d) => s + d.luas_panen, 0);
            const totalProduksi = dataFiltered.reduce((s, d) => s + d.produksi, 0);
            const rataProd = dataFiltered.length
                ? dataFiltered.reduce((s, d) => s + d.produktifitas, 0) / dataFiltered.length
                : 0;

            $('#stat-luas').text(fmt(totalLuas));
            $('#stat-produksi').text(fmt(totalProduksi));
            $('#stat-produktivitas').text(fmt(rataProd));
            $('#stat-tahun').text(dataFiltered.length);

            // Hapus chart lama sebelum membuat yang baru
            if (luasPanenChart) luasPanenChart.destroy();
            if (produksiPanenChart) produksiPanenChart.destroy();
            if (produktifitasPanenChart) produktifitasPanenChart.destroy();

            luasPanenChart = buatChart('luasPanenChart', 'Luas Panen (Ha)', labels,
                dataFiltered.map(d => d.luas_panen),
                { garis: '#10B981', isi: 'rgba(16, 185, 129, .15)' });

            produksiPanenChart = buatChart('produksiPanenChart', 'Produksi (Ton)', labels,
                dataFiltered.map(d => d.produksi),
                { garis: '#F59E0B', isi: 'rgba(245, 158, 11, .15)' });

            produktifitasPanenChart = buatChart('produktifitasPanenChart', 'Produktivitas (Ku/Ha)', labels,
                dataFiltered.map(d => d.produktifitas),
                { garis: '#5A67D8', isi: 'rgba(90, 103, 216, .15)' });
        }

        $(document).ready(function() {
            $('#provinsi').select2({
                placeholder: 'Pilih Provinsi',
            });

            $('#provinsi').on('change', function() {
                getChart();
            });

            getChart();
        });
    </script>
@endsection