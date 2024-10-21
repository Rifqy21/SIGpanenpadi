<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page</title>
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
                            href="#home">HOME</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-bold" href="#data_panen">DATA PANEN</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-bold" href="#peta">PETA LOKASI PANEN</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-bold" href="#contact">CONTACT</a>
                    </li>
                </ul>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link fw-bold" href="{{ route('register') }}">Register</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-primary text-white" href="{{ route('login') }}">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section" id="home">
        <div class="container w-100">
            <div class="row align-items-center">
                <div class="col-md-5">
                    <div class="decoration"></div>
                    <div class="card p-4" id="special_card" style="text-align: left;">
                        <h1 style="color: #5956e9;">SISTEM INFORMASI GEOGRAFIS</h1>
                        <p style="text-align: justify;">Selamat datang di Sistem Informasi Geografis (SIG) Dinas Ketahanan Pangan dan Pertanian. SIG ini
                            menyediakan informasi mengenai data panen di Indonesia. Anda dapat melihat data panen
                            berdasarkan provinsi, tahun, dan lainnya. Selamat menikmati!</p>
                    </div>
                </div>
                <div class="col-md-1"></div>
                <div class="col-md-6">
                    {{-- <img src="{{ asset('assets/img/landing_page/world.png') }}" class="img-fluid" alt="Peta"> --}}
                    <div class="card-body">
                        <!-- Map card -->
                        <div class="card bg-gradient-primary">
                            <div class="card-header border-0">
                                <!-- card tools -->
                                <div class="card-tools">
                                    <button type="button" class="btn btn-primary btn-sm" data-card-widget="collapse"
                                        title="Collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                                <!-- /.card-tools -->
                            </div>
                            <div class="card-body">
                                <div id="world-map" style="height: 250px; width: 100%;"></div>
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Chart Section -->
    <section class="chart-section bg-light" id="data_panen">
        <div class="container">
            <h3 class="text-center">Produksi Panen</h3>


            <div class="row">
                <div class="col-md-12">
                    <canvas id="myChart" height="100"></canvas>
                </div>
            </div>
        </div>
    </section>

    <!-- Data Section -->
    <section class="data-section">
        <div class="container">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-2">
                            <h3>Data Panen</h3>
                        </div>
                        <div class="col-3">
                            <select name="provinsi" id="provinsi" class="form-control">
                                <option value="semua_provinsi">Semua Provinsi</option>
                                @foreach ($provinsi as $p)
                                    <option value="{{ $p->nama_provinsi }}">{{ $p->nama_provinsi }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-4"></div>
                    </div>

                </div>
                <div class="card-body">
                    <table id="dataTable" class="table table-striped table-bordered" style="width:100%;">
                        <thead>
                            <tr>
                                <th>Provinsi</th>
                                <th>Luas Panen (Ha)</th>
                                <th>Produksi (TON)</th>
                                <th>Produktivitas (Ku/Ha)</th>
                                <th>Tahun</th>
                            </tr>
                        </thead>
                        <tbody id="dataBody">
                            @foreach ($books as $p)
                                <tr>
                                    <td>{{ $p[0] }}</td>
                                    <td>{{ $p[1] }}</td>
                                    <td>{{ $p[2] }}</td>
                                    <td>{{ $p[3] }}</td>
                                    <td>{{ $p[4] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </section>

    <!-- Peta Lokasi Panen -->
    <section id="peta">
        <div class="container">
            <h3 class="text-center">Peta Lokasi Panen</h3>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div id = "map" style = "width: 100%; height: 800px"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <footer class="bg-dark text-white text-center py-4">
        <section id="contact" class="bg-dark">

            <div class="container">
                <h3 class="text-center">Contact</h3>
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="whiteCard">
                                    <div class="row mb-3">
                                        <i class="fa-solid fa-location-dot text-black" style="font-size: 40px;"></i>
                                    </div>
                                    <div class="row">
                                        <h5 class="text-black">Address</h5>
                                    </div>
                                    <div class="row">
                                        <p class="text-black">Kantor Pusat Kementerian Pertanian Gedung D Lantai 8 Jl. Harsono RM. No. 3 </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="whiteCard">
                                    <div class="row mb-3">
                                        <i class="fa-solid fa-phone text-black" style="font-size: 40px;"></i>
                                    </div>
                                    <div class="row">
                                        <h5 class="text-black">Call Us</h5>
                                    </div>
                                    <div class="row">
                                        <p class="text-black">(021) 7816082</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="whiteCard">
                                    <div class="row mb-3">
                                        <i class="fa-solid fa-envelope text-black" style="font-size: 40px;"></i>
                                    </div>
                                    <div class="row">
                                        <h5 class="text-black">Email Us</h5>
                                    </div>
                                    <div class="row">
                                        <p class="text-black">ditjen.psp@pertanian.go.id </p>
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="whiteCard">
                                    <div class="row mb-3">
                                        <i class="fa-solid fa-clock text-black" style="font-size: 40px;"></i>
                                    </div>
                                    <div class="row">
                                        <h5 class="text-black">Jam Operasional</h5>
                                    </div>
                                    <div class="row">
                                        <p class="text-black">Senin - Jumat <br> 08.00 – 16.00</p>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="col-12">
                            <div class="whiteCardLong p-3">
                                <h3 class="text-center fw-bold text-black">Send Us Message</h3>
                                <form action="{{ route('sendAduan') }}" method="POST">
                                    @csrf
                                    <div class="row mb-2">
                                        <div class="col-md-6">
                                            <input type="text" name="name" id="name" class="form-control"
                                                placeholder="Your Name" required>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="email" name="email" id="email" class="form-control"
                                                placeholder="Your Email" required>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <input type="text" name="subject" id="subject" class="form-control"
                                                placeholder="Your Subjek" required>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <textarea name="message" id="message" class="form-control" placeholder="Your Message" rows="8" required></textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <center><button type="submit" class="btn btn-primary">Send
                                                    Message</button>
                                            </center>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <hr class="bg-white">
            <p> &copy; Copyright 2024</p>
        </section>

    </footer>

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
        });
    </script>
    <script>
        // Chart.js Example
        const produksi = @json($produksi);
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Januari', 'Febuari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September',
                    'Oktober', 'November', 'Desember'
                ],
                datasets: [{
                    label: 'Produksi Panen (TON)',
                    data: produksi,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
    <script>
        const panen = @json($panen);
        var map = L.map('map').setView([-6.200000, 106.816666], 12); // Pusatkan di Jakarta, Indonesia

        // Tambahkan layer peta
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // Titik-titik koordinat yang sudah ditentukan
        var locations = panen.map(function(panen, index) {
            return {
                name: 'Lokasi Panen  ' + panen.name + ' ' + panen.nama_provinsi + ' #' + index,
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
        document.addEventListener('DOMContentLoaded', function() {
            const menuItems = document.querySelectorAll('.nav-link');
            menuItems.forEach(item => {
                item.addEventListener('click', function() {
                    // Menghapus kelas 'active' dari semua item
                    menuItems.forEach(el => el.classList.remove('activeCustome'));

                    // Menambahkan kelas 'activeCustome' ke item yang diklik
                    this.classList.add('activeCustome');
                });
            });
        });

        const search = document.getElementById('search');
        const provinsi = document.getElementById('provinsi');
    </script>

    <script>
        $(document).ready(function() {
            // Initialize DataTable
            var table = $("#dataTable").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
            });


            // Custom filter for Provinsi
            $('#provinsi').on('change', function() {
                var selectedProvinsi = $(this).val();
                if (selectedProvinsi === 'semua_provinsi') {
                    table.column(0).search('').draw();
                } else {
                    if (selectedProvinsi) {
                        table.column(0).search('^' + selectedProvinsi + '$', true, false).draw();
                    } else {
                        table.column(0).search('').draw();
                    }
                }
            });


        });
    </script>


</body>

</html>
