@extends('user.layouts.app')

@section('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
    <style>
        .dataTables_filter {
            text-align: right !important;
            float: right !important;
        }
    </style>
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Dashboard</h1>
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

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Small boxes (Stat box) -->
                <div class="row">
                    <div class="col-lg-4 col-6">
                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>
                                    {{ $luas }} <sup>Hektar</sup>
                                </h3>

                                <p>Total Luas Panen</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-4 col-6">
                        <!-- small box -->
                        <div class="small-box bg-secondary">
                            <div class="inner">
                                <h3>
                                    {{ $produksi }} <sup>Ton</sup>
                                </h3>

                                <p>Produksi Panen</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-6">
                        <!-- small box -->
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>
                                    {{ $produktivitas }} <sup>Ku/Ha</sup>
                                </h3>

                                <p>Produktivitas Panen</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
                <!-- Main row -->

                <div class="row">
                    <div class="col-6">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <h1 class="card-title">Data Produksi Panen</h1>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                {{-- <div id="bar-chart" style="height: 300px;"></div> --}}
                                <div class="chart">
                                    <canvas id="barChart"
                                        style="min-height: 300px; height: 300px; max-height: 300px;"></canvas>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <h1 class="card-title">Data Produktivitas Panen</h1>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="chart2">
                                    <canvas id="barChart2"
                                        style="min-height: 300px; height: 300px; max-height: 300px;"></canvas>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-1 mt-2">
                                        <h1 class="card-title">Data Panen</h1>
                                    </div>
                                    <div class="col-2">
                                        <select name="provinsi" id="provinsi" class="form-control">
                                            <option value="semua_provinsi">Semua Provinsi</option>
                                        </select>
                                    </div>
                                    <div class="col-7"></div>
                                    <div class="col-2 d-flex justify-content-end">
                                        <a href="{{ route('user.tambah') }}" class="btn btn-primary"> <i
                                                class="fas fa-plus"></i> Tambah
                                            Panen</a>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <th>No</th>
                                        <th>Nama Provinsi</th>
                                        <th>Tanggal Dibuat</th>
                                        <th>Luas Panen (Ha)</th>
                                        <th>Produksi (Ton)</th>
                                        <th>Produktivitas (Ku/Ha)</th>
                                        <th>Action</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($panens as $panen)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $panen->provinsi->nama_provinsi }}</td>
                                                <td>{{ $panen->created_at }}</td>
                                                <td>{{ $panen->luas_panen }} Hektar</td>
                                                <td>{{ $panen->produksi }} Ton</td>
                                                <td>{{ $panen->produktivitas }}</td>
                                                <td>
                                                    <a href="{{ route('panen.show', $panen->id) }}"
                                                        class="btn btn-primary">Detail</a>
                                                    <a href="{{ route('panen.edit', $panen->id) }}"
                                                        class="btn btn-warning">Edit</a>
                                                    <form action="{{ route('panen.delete', $panen->id) }}" method="POSt"
                                                        style="display: inline-block">
                                                        @csrf
                                                        @method('DELETE')
                                                        <input type="submit" class="btn btn-danger" value="Delete"
                                                            onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Peta Lokasi Panen</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div id="map" style="height: 600px;"></div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                </div>

                <!-- /.row (main row) -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
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
    <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": [{
                        extend: 'copy',
                        exportOptions: {
                            columns: ':not(:last-child)' // Mengecualikan kolom terakhir (Action)
                        }
                    },
                    {
                        extend: 'csv',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        }
                    },
                    {
                        extend: 'excel',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        }
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        }
                    },
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        }
                    }
                ],
                "dom": '<"row"<"col-md-6"B><"col-md-6 text-right"f>>' +
                    '<"row"<"col-sm-12"tr>>' +
                    '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });
    </script>
    <script>
        const panens = @json($panens);
        const user = @json(auth()->user());

        var map = L.map('map').setView([-6.200000, 106.816666], 12); // Pusatkan di Jakarta, Indonesia

        // Tambahkan layer peta
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // Titik-titik koordinat yang sudah ditentukan
        var locations = panens.map(function(panen, index) {
            return {
                name: 'Lokasi Panen ' + user.name + ' ' + panen.provinsi.nama_provinsi + ' #' + index,
                latitude: panen.latitude,
                longitude: panen.longitude
            };
        });

        // Tambahkan marker untuk setiap koordinat
        locations.forEach(function(location) {
            var lat = location.latitude;
            var lng = location.longitude;
            L.marker([lat, lng]).addTo(map)
                .bindPopup(location.name + '<br>Latitude: ' + lat + '<br>Longitude: ' + lng);
        });
    </script>
    <script>
        const dataProduksi = @json($bar_data);
        const bar_produktivitas = @json($bar_produktivitas);
        

        var bar_data_new = {
            labels: ['Jan', 'Feb', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agust', 'Sept', 'Okt',
                'Nov', 'Des'
            ],
            datasets: [{
                label: 'Produksi Panen',
                backgroundColor: 'rgba(60,141,188,0.9)',
                borderColor: 'rgba(60,141,188,0.8)',
                pointRadius: false,
                pointColor: '#3b8bba',
                pointStrokeColor: 'rgba(60,141,188,1)',
                pointHighlightFill: '#fff',
                pointHighlightStroke: 'rgba(60,141,188,1)',
                data: dataProduksi
            }]
        }

        var barChartCanvas = $('#barChart').get(0).getContext('2d')
        var barChartData = jQuery.extend(true, {}, bar_data_new)
        var temp0 = barChartData

        var barChartOptions = {
            responsive: true,
            maintainAspectRatio: false,
            datasetFill: false
        }

        new Chart(barChartCanvas, {
            type: 'bar',
            data: barChartData,
            options: barChartOptions
        })
       
        var bar_data_new = {
            labels: ['Jan', 'Feb', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agust', 'Sept', 'Okt',
                'Nov', 'Des'
            ],
            datasets: [{
                label: 'Produktivitas Panen',
                backgroundColor: 'rgba(60,141,188,0.9)',
                borderColor: 'rgba(60,141,188,0.8)',
                pointRadius: false,
                pointColor: '#3b8bba',
                pointStrokeColor: 'rgba(60,141,188,1)',
                pointHighlightFill: '#fff',
                pointHighlightStroke: 'rgba(60,141,188,1)',
                data: bar_produktivitas
            }]
        }

        var barChartCanvas = $('#barChart2').get(0).getContext('2d')
        var barChartData = jQuery.extend(true, {}, bar_data_new)
        var temp0 = barChartData

        var barChartOptions = {
            responsive: true,
            maintainAspectRatio: false,
            datasetFill: false
        }

        new Chart(barChartCanvas, {
            type: 'bar',
            data: barChartData,
            options: barChartOptions
        })
    </script>
@endsection
