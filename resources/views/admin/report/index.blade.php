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
                        <h1 class="m-0">Report</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Report</li>
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
                                    <div class="col-1 mt-2">
                                        <h1 class="card-title">Laporan Panen</h1>
                                    </div>
                                    <div class="col-2">
                                        <select name="tahun" id="tahun" class="form-control">
                                            <option value="semua_tahun">Semua Tahun</option>
                                            @foreach ($tahun as $t)
                                                <option value="{{ $t }}">{{ $t }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-7"></div>
                                    <div class="col-2 d-flex justify-content-end">
                                        <button type="button" class="btn btn-primary" data-toggle="modal"
                                            data-target="#modal-xl">
                                            Generate
                                            Laporan
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <th>No</th>
                                        <th>Judul</th>
                                        <th>Dibuat Oleh</th>
                                        <th>Deskripsi</th>
                                        <th>Tahun</th>
                                        <th>File</th>
                                        <th>Action</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($reports as $key => $report)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $report->title }}</td>
                                                <td>{{ $report->user->name }}</td>
                                                <td>{{ $report->description }}</td>
                                                <td>{{ $report->year }}</td>
                                                <td>
                                                    <a href="{{ asset('assets/reports/' . $report->file) }}"
                                                        target="_blank">Download</a>
                                                </td>
                                                <td>
                                                    <form action="{{ route('admin.report.delete', $report->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger"
                                                            onclick="return confirm('Apakah yakin ingin menghapus Laporan ini ?')">Delete</button>
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

    <!-- /.Start Modal -->
    <div class="modal fade" id="modal-xl" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <form action="{{ route('admin.report.generate') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title">Extra Large Modal</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group mb-3">
                                    <label for="judul">Judul Laporan</label>
                                    <input type="text" class="form-control" id="judul"
                                        placeholder="Silahkan Masukan Judul Laporan" name="title" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group mb-3">
                                    <label for="deskripsi">Deskripsi Laporan</label>
                                    <textarea class="form-control" id="deskripsi" placeholder="Silahkan Masukan Deskripsi Laporan" name="description"
                                        required></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group mb-3">
                                    <label for="deskripsi">Pilih Tahun Panen</label>
                                    <select name="tahun" id="tahun" class="form-control">
                                        @foreach ($tahunPanen as $t)
                                            <option value="{{ $t }}">{{ $t }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Generate</button>
                    </div>
                </form>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.End Modal -->
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
            $('#tahun').on('change', function() {
                var selectedProvinsi = $(this).val();
                if (selectedProvinsi === 'semua_tahun') {
                    table.column(4).search('').draw();
                } else {
                    if (selectedProvinsi) {
                        table.column(4).search('^' + selectedProvinsi + '$', true, false).draw();
                    } else {
                        table.column(4).search('').draw();
                    }
                }
            });
        });
    </script>
@endsection
