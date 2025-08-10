<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PETA</title>
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

        .filter-container {
            max-width: 200px;
        }

        .filter-container label {
            font-weight: bold;
        }
    </style>
</head>

<body>

    <!-- Main Sidebar Container -->
    @include('admin.layouts.sidebar')


    <!-- Filter Tahun dan Klasifikasi -->
    <div class="filter-container"
     style="position: absolute; top: 10px; right: 10px; z-index: 1000; background: white; padding: 10px; border-radius: 8px; box-shadow: 0px 2px 8px rgba(0, 0, 0, 0.2);">
    <label for="tahunSelect">Pilih Tahun</label>
    <select id="tahunSelect" class="form-control mb-2">
        @foreach($years as $year)
            <option value="{{ $year }}">{{ $year }}</option>
        @endforeach
    </select>
    </div>

      <!-- Search Provinsi -->
    <div class="search-container"
        style="position: absolute; top: 120px; right: 10px; z-index: 1000; background: white; padding: 10px; border-radius: 8px; box-shadow: 0px 2px 8px rgba(0, 0, 0, 0.2); width: 220px;">
        
        <label for="searchProvinsi" style="font-weight: 600;">Cari Provinsi</label>
        <div class="d-flex gap-2">
            <input type="text" id="searchProvinsi" class="form-control" placeholder="Contoh: Jawa Tengah" list="provinsiList" style="width: 140px;" />
            <button class="btn btn-primary" style="padding: 5px 10px;" onclick="zoomToProvinsi()">Cari</button>
        </div>
        <datalist id="provinsiList">
            @foreach ($provinsis as $provinsi)
                <option value="{{ $provinsi->nama_provinsi }}"></option>
            @endforeach
        </datalist>
    </div>

    <!-- Display Full Map -->
    <div id="map" style="width: 100%; height: 100vh;"></div>

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

<script>
    const provinsis = @json($provinsis);
    let panen;
    let panenPerProvinsi = {};
    let map = L.map('map').setView([-0.789275, 113.921327], 5);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    function getColor(jumlah, batasAtas, batasBawah) {
        if (jumlah > batasAtas) return 'green';
        else if (jumlah < batasBawah) return 'red';
        else return 'yellow';
    }

    function formatAngka(angka) {
        return Math.floor(angka).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    // Leaflet Legend Control
    const legend = L.control({ position: 'bottomright' });

    legend.onAdd = function () {
    const div = L.DomUtil.create('div', 'info legend');
    div.style.backgroundColor = 'white';
    div.style.padding = '10px';
    div.style.border = '1px solid #ccc';
    div.style.borderRadius = '6px';
    div.style.boxShadow = '0 2px 6px rgba(0,0,0,0.2)';

    div.innerHTML = `
        <strong>Keterangan:</strong><br>
        <i style="background:green; width:18px; height:18px; display:inline-block; border:1px solid #999;"></i>
        <span class="legend-text-green">...</span><br>
        <i style="background:yellow; width:18px; height:18px; display:inline-block; border:1px solid #999;"></i>
        <span class="legend-text-yellow">...</span><br>
        <i style="background:red; width:18px; height:18px; display:inline-block; border:1px solid #999;"></i>
        <span class="legend-text-red">...</span>
    `;
    return div;
};
    legend.addTo(map);

    function updateLegend(lowerLimit, upperLimit) {
        document.querySelector(".legend-text-green").textContent = `> ${formatAngka(upperLimit)} Ton`;
        document.querySelector(".legend-text-yellow").textContent = `${formatAngka(lowerLimit)} – ${formatAngka(upperLimit)} Ton`;
        document.querySelector(".legend-text-red").textContent = `< ${formatAngka(lowerLimit)} Ton`;
    }

    function showMap() {
        panen = @json($dataBps);
        const selectedTahun = document.getElementById('tahunSelect').value;
        panen = panen.filter(p => p.tahun == selectedTahun);

        panenPerProvinsi = {};
        provinsis.forEach(function (provinsi) {
            let nama = provinsi.nama_provinsi.replace(/\s/g, '');
            panenPerProvinsi[nama] = 0;
        });

        panen.forEach(function (p) {
            let namaProvinsi = p.provinsi.replace(/\s/g, '');
            if (panenPerProvinsi[namaProvinsi] !== undefined) {
                panenPerProvinsi[namaProvinsi] += parseInt(p.produksi);
            } else {
                panenPerProvinsi[namaProvinsi] = parseInt(p.produksi);
            }
        });

        fetch(`/limits-panen?tahun=${selectedTahun}`)
            .then(res => res.json())
            .then(({ upperLimit, lowerLimit }) => {
                updateLegend(lowerLimit, upperLimit);

                // Hapus layer geojson lama
                map.eachLayer(layer => {
                    if (layer instanceof L.GeoJSON) {
                        map.removeLayer(layer);
                    }
                });

                const url = "{{ asset('data/provinsi.json') }}";
                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        const provinsiOnly = {
                            ...data,
                            features: data.features.filter(f => !f.properties.NAME_2 && !f.properties.NAME_3)
                        };

                        L.geoJSON(provinsiOnly, {
                           style: function (feature) {
                                    const namaProvinsi = feature.properties.NAME_1;
                                    const key = namaProvinsi.replace(/\s/g, '');
                                    const jumlahPanen = panenPerProvinsi[key];

                                    // Hanya warnai jika ada data
                                    let warna = null;
                                    if (jumlahPanen !== undefined && jumlahPanen !== 0) {
                                        warna = getColor(jumlahPanen, upperLimit, lowerLimit);
                                    }

                                    return {
                                        fillColor: warna ?? 'transparent',
                                        weight: 1,
                                        opacity: 1,
                                        color: 'white',
                                        dashArray: '3',
                                        fillOpacity: warna ? 0.6 : 0
                                    };
                                },

                            onEachFeature: function (feature, layer) {
                                const namaProvinsi = feature.properties.NAME_1;
                                const key = namaProvinsi.replace(/\s/g, '');
                                const jumlahPanen = panenPerProvinsi[key] ?? "Data tidak tersedia";

                                layer.bindPopup(
                                    `<strong>Provinsi:</strong> ${namaProvinsi}<br>` +
                                    `<strong>Jumlah Panen:</strong> ${formatAngka(jumlahPanen)} Ton`
                                );
                            }
                        }).addTo(map);
                    });
            })
            .catch(error => {
                console.error('Gagal mengambil batas atas/bawah dari backend:', error);
            });
    }

    showMap();

    document.getElementById('tahunSelect').addEventListener('change', function () {
        showMap();
    });

    function zoomToProvinsi() {
        const provinsiDicari = document.getElementById('searchProvinsi').value.toLowerCase().replace(/\s/g, '');

        fetch("{{ asset('data/provinsi.json') }}")
            .then(response => response.json())
            .then(data => {
                const fitur = data.features.find(f => {
                    const nama = f.properties.NAME_1.toLowerCase().replace(/\s/g, '');
                    return nama === provinsiDicari;
                });

                if (fitur) {
                    const layer = L.geoJSON(fitur);
                    map.fitBounds(layer.getBounds());
                } else {
                    alert("Provinsi tidak ditemukan");
                }
            })
            .catch(error => {
                console.error("Gagal mencari provinsi:", error);
            });
    }
</script>

</body>
</html>
