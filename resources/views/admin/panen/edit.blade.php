@extends('user.layouts.app')

@section('styles')
    <!-- Leaflet -->
    {{-- <link rel = "stylesheet" href = "http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.css" /> --}}
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
                        <h1 class="m-0">Data Panen</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Edit Data Panen</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">

                <!-- Main row -->

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <h1 class="card-title">Edit Data Panen</h1>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <form action="{{ route('panen.update', $panen->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group row">
                                        <label for="provinsi" class="col-sm-2 col-form-label">Provinsi</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" id="provinsi" name="provinsi" required>
                                                @foreach ($provinsis as $prov)
                                                    <option value="{{ $prov->id }}"
                                                        @if ($prov->id == $panen->id_provinsi) selected @endif>
                                                        {{ $prov->nama_provinsi }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="luas" class="col-sm-2 col-form-label">Luas
                                            Panen<sub>(ha)</sub></label>
                                        <div class="col-sm-10">
                                            <input type="number" class="form-control" id="luas" name="luas"
                                                required value="{{ $panen->luas_panen }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="produktivitas"
                                            class="col-sm-2 col-form-label">Produktivitas<sub>(ku/ha)</sub></label>
                                        <div class="col-sm-10">
                                            <input type="number" class="form-control" id="produktivitas"
                                                name="produktivitas" readonly required value="{{ $panen->produktivitas }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="produksi"
                                            class="col-sm-2 col-form-label">Produksi<sub>(ton)</sub></label>
                                        <div class="col-sm-10">
                                            <input type="number" class="form-control" id="produksi" name="produksi"
                                                required value="{{ $panen->produksi }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="Lokasi" class="col-sm-2 col-form-label">Lokasi</label>
                                        <div class="col-sm-5">
                                            <input type="text" class="form-control" id="latitude" name="latitude"
                                                required readonly placeholder="latitude" value="{{ $panen->latitude }}">
                                        </div>
                                        <div class="col-sm-5">
                                            <input type="text" class="form-control" id="longitude" name="longitude"
                                                required readonly placeholder="longitude" value="{{ $panen->longitude }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <div id="map" style="height: 600px;"></div>
                                        </div>
                                    </div>
                                    {{-- button submit --}}
                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <button type="submit" class="btn btn-primary">Update</button>
                                        </div>
                                    </div>
                                </form>
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

        const panen = @json($panen);

        const latitude = document.getElementById('latitude');
        const longitude = document.getElementById('longitude');
        var mapOptions = {
            center: [panen.latitude, panen.longitude],
            zoom: 10,
        }
        // Creating a map object
        var map = new L.map("map", mapOptions);

        // Creating a Layer object
        var layer = new L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        let marker = L.marker([panen.latitude, panen.longitude]).addTo(map);
        // Event klik pada peta
        map.on('click', function(e) {

            if (marker != null) {
                map.removeLayer(marker);
            }

            marker = L.marker(e.latlng).addTo(map);

            var lat = e.latlng.lat;
            var lng = e.latlng.lng;

            latitude.value = lat;
            longitude.value = lng;
        });
        // Adding layer to the map
        map.addLayer(layer);
    </script>
    <script>
        const luas = document.getElementById('luas');
        const produktivitas = document.getElementById('produktivitas');
        const produksi = document.getElementById('produksi');

        // count produktivitas
        luas.addEventListener('input', function() {
            // convert ton to kwintal
            let produksiKw = produksi.value * 10;
            const luasValue = luas.value;
            const produktivitasValue = produksiKw / luasValue;
            // bulatkan menjadi 2 angka dibelakang koma
            const rounded = Math.round(produktivitasValue * 100) / 100;
            produktivitas.value = rounded;
        });

        produksi.addEventListener('input', function() {
            let produk = produksi.value * 10;
            const luasValue = luas.value;
            const produktivitasValue = produk / luasValue;
            const rounded = Math.round(produktivitasValue * 100) / 100;
            produktivitas.value = rounded;
        });
    </script>
@endsection
