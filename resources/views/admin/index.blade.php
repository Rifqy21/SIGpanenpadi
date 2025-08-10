@extends('admin.layouts.app')

@section('styles')
    <style>
        .dataTables_filter {
            text-align: right !important;
            float: right !important;
        }
    </style>
    <!-- Leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                    <h3>
                        Statistik Panen Padi
                    </h3>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>

        
        <!-- /.content-header -->
        <!-- Kolom Info Total Provinsi -->
<div class="row justify-content-center mb-5">
    <div class="col-md-4 col-sm-6">
        <div class="small-box bg-gradient-primary shadow">
            <div class="inner text-center">
                <h3>{{ $jumlahProvinsi }}</h3>
                <p>Jumlah Provinsi di Indonesia</p>
            </div>
            <div class="icon">
                <i class="fas fa-map-marked-alt"></i>
            </div>
        </div>
    </div>
</div>


        <!-- Main content -->

        <!-- Dropdown Provinsi -->
        <section class="chart-section bg-light" id="data_panen">
        <div class="container">
            <div class="row mb-2 align-items-center">
                <div class="col-auto">
                    <label for="provinsi" class="col-form-label">Provinsi</label>
                </div>
                <div class="col-3">
                    <select name="provinsi" id="provinsi" class="form-control">
                        @foreach ($provinsi as $p)
                            <option value="{{ $p->nama_provinsi }}">{{ $p->nama_provinsi }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

       <!-- Chart Panen -->
           <div class="row">
                <div class="col-4">
                    <div class="card">
                        <div class="card-header bg-info text-white fw-bold">
                            <h3>Luas Panen</h3>
                        </div>
                        <div class="card-body">
                            <canvas id="luasPanenChart" width="400" height="400"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="card">
                        <div class="card-header bg-info text-white fw-bold">
                            <h3>Produksi Panen</h3>
                        </div>
                        <div class="card-body">
                            <canvas id="produksiPanenChart" width="400" height="400"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="card">
                        <div class="card-header bg-info text-white fw-bold">
                            <h3>Produktivitas Panen</h3>
                        </div>
                        <div class="card-body">
                            <canvas id="produktifitasPanenChart" width="400" height="400"></canvas>
                        </div>
                    </div>
                </div>
            </div>

       
</section>
@endsection

@section('scripts')
    <!-- DataTables  & Plugins -->
    <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/flot/jquery.flot.js') }}"></script>
    <script src="{{ asset('assets/plugins/flot/plugins/jquery.flot.resize.js') }}"></script>
    <script src="{{ asset('assets/plugins/flot/plugins/jquery.flot.pie.js') }}"></script>
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
      
   
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @if (session('info'))
        <script>
            $(document).Toasts('create', {
                class: 'bg-info',
                title: 'Informasi',
                body: '{{ session('info') }}'
            });
        </script>
    @endif
    @if (session('error'))
        <script>
            $(document).Toasts('create', {
                class: 'bg-danger',
                title: 'Gagal',
                body: '{{ session('success') }}'
            });
        </script>
    @endif
    @if ($errors->any())
        <script>
            @foreach ($errors->all() as $error)
                $(document).Toasts('create', {
                    class: 'bg-danger',
                    title: 'Gagal',
                    body: '{{ $error }}'
                });
            @endforeach
        </script>
    @endif

<script>
        $('#provinsi').select2({
            placeholder: 'Pilih Provinsi',
        });
        $('#provinsi').on('change', function() {
            getChart();
        });
    </script>

    <!-- Custom JS -->
    <script>
        $(document).ready(function() {
            $('#world-map').vectorMap({
                map: 'indonesia_id',
                backgroundColor: 'transparent',
                regionStyle: {
                    initial: {
                        fill: '#c4c4c4',
                        "fill-opacity": 1,
                        stroke: 'none',
                        "stroke-width": 0,
                        "stroke-opacity": 1
                    }
                },
                series: {
                    regions: [{
                        values: {},
                        scale: ['#C8EEFF', '#0071A4'],
                        normalizeFunction: 'polynomial'
                    }]
                }
            });
            getChart();
        });
    </script>
    <script>
    // Variabel global chart supaya bisa di-destroy saat update data
    let luasPanenChart, produksiPanenChart, produktifitasPanenChart;

    function getChart() {
        const provinsi = $('#provinsi').val();

        // Ambil data dari PHP ke JS (pastikan sudah ada di blade)
        const dataBps = {!! json_encode($dataBps) !!};

        // Filter data berdasarkan provinsi yang dipilih
        const dataFiltered = dataBps.filter(d => d.provinsi === provinsi);

        // Map dan parse data agar numerik dan siap dipakai chart
        const data = dataFiltered.map(d => ({
            ...d,
            luas_panen: parseInt(d.luas_panen) || 0,
            produksi: parseInt(d.produksi) || 0,
            produktifitas: parseFloat(
                (d.produktifitas || d.produktifitas || '0').toString().replace(',', '.')
            ) || 0,
            tahun: d.tahun
        }));

        // Ambil context canvas chart
        const ctxLuas = document.getElementById('luasPanenChart').getContext('2d');
        const ctxProduksi = document.getElementById('produksiPanenChart').getContext('2d');
        const ctxProduktifitas = document.getElementById('produktifitasPanenChart').getContext('2d');

        // Destroy chart lama jika sudah ada, agar tidak bertumpuk
        if (luasPanenChart) luasPanenChart.destroy();
        if (produksiPanenChart) produksiPanenChart.destroy();
        if (produktifitasPanenChart) produktifitasPanenChart.destroy();

        // Buat chart Luas Panen
        luasPanenChart = new Chart(ctxLuas, {
            type: 'line',
            data: {
                labels: data.map(d => d.tahun),
                datasets: [{
                    label: 'Luas Panen (Ha)',
                    data: data.map(d => d.luas_panen),
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.3,
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });

        // Buat chart Produksi
        produksiPanenChart = new Chart(ctxProduksi, {
            type: 'line',
            data: {
                labels: data.map(d => d.tahun),
                datasets: [{
                    label: 'Produksi (Ton)',
                    data: data.map(d => d.produksi),
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.3,
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });

        // Buat chart Produktivitas
        produktifitasPanenChart = new Chart(ctxProduktifitas, {
            type: 'line',
            data: {
                labels: data.map(d => d.tahun),
                datasets: [{
                    label: 'Produktivitas (Ku/Ha)',
                    data: data.map(d => d.produktifitas),
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.3,
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    }

    // Jalankan saat halaman siap dan pas dropdown provinsi berubah
    $(document).ready(function() {
        getChart();

        $('#provinsi').on('change', function() {
            getChart();
        });
    });
</script>
@endsection


