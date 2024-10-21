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
                    <div class="col-lg-3 col-6">
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
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-success">
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
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3 class="text-white">
                                    {{ $produktivitas }} <sup>Ku/Ha</sup>
                                </h3>

                                <p class="text-white">Produktivitas Panen</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>{{ count($petanis) }}</h3>

                                <p>Pengguna Terdaftar</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                        </div>
                    </div>
                    <!-- ./col -->
                </div>
                <!-- /.row -->

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

                <!-- Main row -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-1 mt-2">
                                        <h1 class="card-title">Laporan Panen</h1>
                                    </div>
                                    <div class="col-2">
                                        <select name="provinsi" id="provinsi" class="form-control">
                                            <option value="semua_provinsi">Semua Provinsi</option>
                                            @foreach ($provinsis as $prov)
                                                <option value="{{ $prov->nama_provinsi }}">{{ $prov->nama_provinsi }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-7"></div>
                                    <div class="col-2 d-flex justify-content-end">
                                        <a href="{{ route('createDataPanen') }}" class="btn btn-primary"> <i
                                                class="fas fa-plus"></i> Tambah
                                            Laporan</a>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <th>No</th>
                                        <th>Nama Petani</th>
                                        <th>Nama Provinsi</th>
                                        <th>Tanggal Dibuat</th>
                                        <th>Terakhir Diupdate</th>
                                        <th>Luas Panen (Ha)</th>
                                        <th>Produksi (Ton)</th>
                                        <th>Produktivitas (Ku/Ha)</th>
                                        <th>Action</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($panens as $dataPanen)
                                            <tr id="dataBody">
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $dataPanen->petani->name }}</td>
                                                <td>{{ $dataPanen->provinsi->nama_provinsi }}</td>
                                                <td>{{ date('d-m-Y', strtotime($dataPanen->created_at)) }}</td>
                                                <td>{{ date('d-m-Y', strtotime($dataPanen->updated_at)) }}</td>
                                                <td>{{ $dataPanen->luas_panen }}</td>
                                                <td>{{ $dataPanen->produksi }}</td>
                                                <td>{{ $dataPanen->produktivitas }}</td>
                                                <td>
                                                    <a href="{{ route('admin.panen.show', $dataPanen->id) }}"
                                                        class="btn btn-primary">Detail</a>
                                                    <a href="{{ route('admin.panen.edit', $dataPanen->id) }}"
                                                        class="btn btn-warning">Edit</a>
                                                    <form action="{{ route('admin.panen.delete', $dataPanen->id) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger"
                                                            onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')">Delete</button>
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

                <!-- Main row -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">

                                    <h1 class="card-title">Peta Sebaran Lokasi Panen Petani</h1>

                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div id = "map" style = "width: 100%; height: 800px"></div>
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
                                        <h1 class="card-title">Data Pengguna</h1>
                                    </div>
                                    <div class="col-2">
                                    </div>
                                    <div class="col-7"></div>
                                    <div class="col-2 d-flex justify-content-end">
                                        <a href="{{ route('admin.user.create') }}" class="btn btn-primary"> <i
                                                class="fas fa-plus"></i> Tambah
                                            Pengguna</a>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example2" class="table table-bordered table-striped">
                                    <thead>
                                        <th>No</th>
                                        <th>Nama Pengguna</th>
                                        <th>Email Pengguna</th>
                                        <th>Tanggal Dibuat</th>
                                        <th>Terakhir Diupdate</th>
                                        <th>Peran</th>
                                        <th>Action</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($petanis as $petani)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $petani->name }}</td>
                                                <td>{{ $petani->email }}</td>
                                                <td>{{ date('d-m-Y', strtotime($petani->created_at)) }}</td>
                                                <td>{{ date('d-m-Y', strtotime($petani->updated_at)) }}</td>
                                                <td>{{ $petani->role }}</td>
                                                <td>
                                                    <a href="{{ route('admin.user.edit', $petani->id) }}"
                                                        class="btn btn-warning">Edit</a>
                                                    <form action="{{ route('admin.user.delete', $petani->id) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger"
                                                            onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')">Delete</button>
                                                    </form>
                                                    {{-- change password --}}
                                                    <button data-toggle="modal"
                                                        data-target="#changePasswordModal{{ $petani->id }}"
                                                        class="btn btn-info">Ganti Password</button>
                                                </td>
                                            </tr>

                                            <!-- Modal -->
                                            <div class="modal fade " id="changePasswordModal{{ $petani->id }}"
                                                tabindex="-1" aria-labelledby="changePasswordModalLabel"
                                                aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="changePasswordModalLabel">Ganti
                                                                Password</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form
                                                                action="{{ route('admin.user.change-password.update', $petani->id) }}"
                                                                method="POST">
                                                                @method('PUT')
                                                                @csrf
                                                                <div
                                                                    class="form-group
                                                                ">
                                                                    <label for="password">Password Baru</label>
                                                                    <input type="password" class="form-control"
                                                                        id="password{{ $petani->id }}" name="password"
                                                                        required>
                                                                </div>
                                                                <div
                                                                    class="form-group
                                                            ">
                                                                    <label for="password_confirmation">Konfirmasi Password
                                                                        Baru</label>
                                                                    <input type="password" class="form-control"
                                                                        id="password_confirmation{{ $petani->id }}"
                                                                        name="password_confirmation" required>
                                                                </div>
                                                                <button type="submit" class="btn btn-primary">Ganti
                                                                    Password</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </tbody>
                                </table>
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
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>

    <script>
        $(document).ready(function() {
            // Initialize DataTable
            var table = $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": [{
                        extend: 'copy',
                        exportOptions: {
                            columns: ':not(:last-child)' // Exclude last column (Action)
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
            });

            // Custom filter for Provinsi
            $('#provinsi').on('change', function() {
                var selectedProvinsi = $(this).val();
                if (selectedProvinsi === 'semua_provinsi') {
                    table.column(2).search('').draw();
                } else {
                    if (selectedProvinsi) {
                        table.column(2).search('^' + selectedProvinsi + '$', true, false).draw();
                    } else {
                        table.column(2).search('').draw();
                    }
                }
            });

            var table2 = $("#example2").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": [{
                        extend: 'copy',
                        exportOptions: {
                            columns: ':not(:last-child)' // Exclude last column (Action)
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
            });

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
    <script>
        const panen = @json($panens);
        const provinsis = @json($provinsis);

        var map = L.map('map').setView([-6.200000, 106.816666], 12); // Pusatkan di Jakarta, Indonesia

        // Tambahkan layer peta
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        var panenPerProvinsi = {};
        provinsis.forEach(function(provinsi) {
            console.log(provinsi.nama_provinsi)
            panenPerProvinsi[provinsi.nama_provinsi] = 0;
        });


        // sum the total panen for each provinsi
        panen.forEach(function(p) {
            var provinsi = p.provinsi.nama_provinsi;
            // sum the total panen for each provinsi p.produksi
            panenPerProvinsi[provinsi] += parseInt(p.produksi); // dalam format ton
        });


        // panen.forEach(function(p) {
        //     var provinsi = p.provinsi.nama_provinsi;
        //     if (!panenPerProvinsi[provinsi]) {
        //         panenPerProvinsi[provinsi] = 0;
        //     }
        //     // sum the total panen for each provinsi p.produksi
        //     panenPerProvinsi[provinsi] += parseInt(p.produksi); // dalam format ton
        // });

        // remove all space in the provinsi name
        Object.keys(panenPerProvinsi).forEach(function(provinsi) {
            // if nama provinsi contains space trim
            if (provinsi.includes(' ')) {
                var newProvinsi = provinsi.replace(/\s/g, '');
                panenPerProvinsi[newProvinsi] = panenPerProvinsi[provinsi];
                delete panenPerProvinsi[provinsi];
            }
        });




        function getColor(jumlahPanen) {
            if (jumlahPanen > 20) return 'green'; // produksi lebih dari 20 ton
            else if (jumlahPanen > 10) return 'yellow'; // produksi lebih dari 10 ton
            else if (jumlahPanen > 0) return 'red' // produksi lebih dari 1 ton
            // if there is no data, return no color
            else return 'none';
        }


        // Titik-titik koordinat yang sudah ditentukan
        var locations = panen.map(function(panen, index) {
            return {
                name: 'Lokasi Panen  ' + panen.name + ' ' + panen.provinsi.nama_provinsi + ' #' + index,
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

        fetch('data/geo.json') // Sesuaikan dengan path file Anda
            .then(response => response.json())
            .then(data => {
                // Menambahkan poligon kecamatan ke peta
                L.geoJSON(data, {
                    style: function(feature) {
                        var provinsi = feature.properties.NAME_1; // Ambil nama provinsi dari GeoJSON
                        var jumlahPanen = panenPerProvinsi[
                            provinsi] // Ambil jumlah panen dari data panenPerProvinsi
                        return {
                            fillColor: getColor(jumlahPanen), // Tentukan warna berdasarkan jumlah panen
                            weight: 1,
                            opacity: 1,
                            color: 'white',
                            dashArray: '3',
                            fillOpacity: 0.5
                        };
                    },
                    onEachFeature: function(feature, layer) {
                        // Menampilkan popup dengan informasi kecamatan dan provinsi
                        layer.bindPopup("Kecamatan: " + feature.properties.NAME_3 + "<br>Provinsi: " +
                            feature.properties.NAME_1 + "<br>Jumlah Panen: " + (panenPerProvinsi[feature
                                .properties.NAME_1] + " ton" || "Data tidak tersedia"));
                    }
                }).addTo(map);
            })
            .catch(error => {
                console.error('Error loading the GeoJSON:', error);
            });
    </script>
@endsection
