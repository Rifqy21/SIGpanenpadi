@extends('admin.layouts.app')

@section('styles')
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
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>150</h3>

                                <p>New Orders</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
                            <a href="#" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>53<sup style="font-size: 20px">%</sup></h3>

                                <p>Bounce Rate</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                            <a href="#" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>44</h3>

                                <p>User Registrations</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>
                            <a href="#" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>65</h3>

                                <p>Unique Visitors</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-pie-graph"></i>
                            </div>
                            <a href="#" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                </div>
                <!-- /.row -->
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
                                                <option value="{{ $prov->id }}">{{ $prov->nama_provinsi }}</option>
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
                                        <th>Luas Panen (Ha)</th>
                                        <th>Produksi (Ton)</th>
                                        <th>Produktivitas (Ku/Ha)</th>
                                        <th>Action</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($panens as $dataPanen)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $dataPanen->petani->name }}</td>
                                                <td>{{ $dataPanen->provinsi->nama_provinsi }}</td>
                                                <td>{{ $dataPanen->created_at }}</td>
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
                                                        <button type="submit" class="btn btn-danger">Delete</button>
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
                                        <a href="#" class="btn btn-primary"> <i class="fas fa-plus"></i> Tambah
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
                                        <th>Tanggal Dibuat</th>
                                        <th>Peran</th>
                                        <th>Action</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($petanis as $petani)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $petani->name }}</td>
                                                <td>{{ $petani->created_at }}</td>
                                                <td>{{ $petani->role }}</td>
                                                <td>
                                                    <a href="#" class="btn btn-primary">Detail</a>
                                                    <a href="#" class="btn btn-warning">Edit</a>
                                                    <form action="#" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Delete</button>
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
            $("#example2").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example2_wrapper .col-md-6:eq(0)');
        });
    </script>
@endsection
