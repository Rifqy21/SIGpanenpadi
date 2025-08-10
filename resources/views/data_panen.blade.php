<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DATA PANEN</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/css/adminlte.min.css">
    <!-- Leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
    <!-- icon -->
    <script src="https://kit.fontawesome.com/26af10689e.js" crossorigin="anonymous"></script>

    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet"
        href="{{ asset('assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/jqvmap/jqvmap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/dist/css/adminlte.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/daterangepicker/daterangepicker.css') }}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/summernote/summernote-bs4.min.css') }}">

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Source Sans Pro', sans-serif;
            /* always on full width */
            margin: 0;
            padding: 0;
            overflow-x: hidden;
            width: 100%;
        }

        .hero-section {
            background: #5A67D8;
            color: white;
            padding: 50px 0;
            text-align: center;
        }

        .hero-section .card {
            background: rgba(255, 255, 255, 0.1);
            border: none;
        }

        .chart-section {
            padding: 50px 0;
        }

        .data-section {
            padding: 50px 0;
            overflow-x: auto;
        }

        @media (max-width: 768px) {
            .hero-section {
                padding: 30px 0;
            }

            .hero-section .col-md-6 {
                margin-bottom: 20px;
            }
        }

        .navbar {
            position: fixed;
            top: 30px;
            width: 60%;
            left: 20%;
            right: 20%;
            z-index: 1000;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        @media (max-width: 768px) {
            .navbar {
                position: fixed;
                top: 0;
                width: 100%;
                left: 0;
                right: 0;
                border-radius: 0;
                z-index: 1000;
            }
        }

        .activeCustome {
            color: #5A67D8 !important;
            font-weight: bold;
        }

        #home {
            background-image: url('assets/img/landing_page/Background Image.png');
            background-size: cover;
            background-position: center;
            height: 80vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            text-align: center;
        }

        .decoration {
            width: 470px;
            height: 350px;
            position: absolute;
            top: -40px;
            left: 35px;
            border: 15px solid #6d6be9;
            ;
        }

        @media (max-width: 1200px) {
            .decoration {
                display: none;
            }
        }

        #special_card {
            /* semi transparent white */
            background-color: rgba(255, 255, 255);
        }

        #contact {
            background-color: black;
            color: white;
            padding: 20px 0;
        }

        .whiteCard {
            background-color: white;
            height: 200px;
            margin: 10px;
            padding: 20px;
            width: 100%;
        }

        .whiteCardLong {
            background-color: white;
            height: 420px;
            margin: 10px;
        }

        .fi {
            color: black;
        }

        .dataTables_filter {
            text-align: right !important;
            float: right !important;
        }

        .select2-container .select2-selection--single {
            height: calc(2.25rem + 2px);
            /* Tinggi default .form-control Bootstrap */
            padding: 0.175rem 0.25rem;
            /* Padding default dari .form-control */
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: calc(2.25rem);
            /* Sejajarkan teks di tengah */
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-md navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link fw-bold @if (request()->is('/')) activeCustome @endif"
                            href="{{ route('landing-page') }}">HOME</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-bold @if (request()->is('dataPanen')) activeCustome @endif"
                            href="{{ route('data-panen') }}">DATA PANEN</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-bold @if (request()->is('bpsMaps')) activeCustome @endif"
                            href="{{ route('bps-maps') }}">PETA</a>
                    </li>
                </ul>
                    <li class="navbar-nav ml-auto">
                        <a class="nav-link btn btn-primary text-white" href="{{ route('login') }}">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


    <!-- Chart Section -->
    <section class="chart-section bg-light" id="data_panen" style="margin-top: 100px;">
        <div class="container">
            <div class="card">
                <div class="card-header">
                    <h4>Data Panen Padi</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="provinsi">Provinsi</label>
                                <select name="provinsi" id="provinsi" class="form-control">
                                    <option value="">Pilih Provinsi</option>
                                    @foreach ($provinsi as $item)
                                        <option value="{{ $item->nama_provinsi }}">{{ $item->nama_provinsi }}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                    </div>

                        <form method="GET" action="{{ route('data-panen') }}">
                        <div class="row">
                            <div class="col-9"></div>
                            <div class="col-1 mt-2 text-end pr-0">
                            <label for="provinsi">Filter Tahun</label>
                            </div>
                            <div class="col-2">
                                <select name="tahun" id="tahun" class="form-control" onchange="this.form.submit()">
                                    <option value="semua_tahun" {{ request('tahun') == 'semua_tahun' ? 'selected' : '' }}>Semua Tahun</option>
                                    @foreach ($tahunList as $t)
                                        <option value="{{ $t }}" {{ request('tahun') == $t ? 'selected' : '' }}>{{ $t }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </form>


                    <div class="row">
                        <div class="col-12">
                            {{-- table --}}
                            <div class="table-responsive">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Provinsi</th>
                                            <th>Luas Panen</th>
                                            <th>Produktivitas</th>
                                            <th>Produksi</th>
                                            <th>Tahun</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($dataBps as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item['provinsi'] }}</td>
                                                <td>{{ $item['luas_panen'] }}</td>
                                                <td>{{ $item['produktifitas'] }}</td>
                                                <td>{{ $item['produksi'] }}</td>
                                                <td>{{ $item['tahun'] }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- AdminLTE JS -->
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/js/adminlte.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>

    <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('assets/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- ChartJS -->
    <script src="{{ asset('assets/plugins/chart.js/Chart.min.js') }}"></script>
    <!-- Sparkline -->
    <script src="{{ asset('assets/plugins/sparklines/sparkline.js') }}"></script>
    <!-- JQVMap -->
    <script src="{{ asset('assets/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jqvmap/maps/jquery.vmap.indonesia.js') }}"></script>
    <!-- jQuery Knob Chart -->
    <script src="{{ asset('assets/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
    <!-- daterangepicker -->
    <script src="{{ asset('assets/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{ asset('assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <!-- Summernote -->
    <script src="{{ asset('assets/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('assets/plugins/dist/js/adminlte.js') }}"></script>
    <script src="{{ asset('assets/plugins/dist/js/pages/dashboard.js') }}"></script>
    <script src="{{ asset('assets/plugins/toastr/toastr.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    @if (session('success'))
        <script>
            $(document).Toasts('create', {
                class: 'bg-success',
                title: 'Sukses',
                body: '{{ session('success') }}'
            });
        </script>
    @endif
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
        // datatable with provinsi as filter
        $(document).ready(function() {
            const table = $('#example1').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true,
                "responsive": true,
            });

            $('#provinsi').on('change', function() {
                const selectedProvinsi = $(this).val(); // Mendapatkan nilai provinsi yang dipilih
                console.log(selectedProvinsi);
                // Terapkan filter berdasarkan provinsi yang dipilih
                if (selectedProvinsi) {
                    table.column(1).search('^' + selectedProvinsi + '$', true, false)
                .draw(); // Kolom 0 adalah kolom provinsi
                } else {
                    table.column(1).search('')
                .draw(); // Kosongkan filter jika tidak ada provinsi yang dipilih
                }
            });

        });

        
         $('#tahun').on('change', function() {
                var selectedTahun = $(this).val();
                if (selectedTahun === 'semua_tahun') {
                    table.column(5).search('').draw();
                } else {
                    if (selectedTahun) {
                        table.column(5).search('^' + selectedTahun + '$', true, false).draw();
                    } else {
                        table.column(5).search('').draw();
                    }
                }
            });


        
    </script>
</body>
</html>
