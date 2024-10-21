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
                        <h1 class="m-0">Aduan Pengguna</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Aduan</li>
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
                                    <h1 class="card-title">Aduan Pengguna</h1>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <th>No</th>
                                        <th>Nama </th>
                                        <th>Email</th>
                                        <th>Subjek</th>
                                        <th>Pesan</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($aduans as $aduan)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $aduan->name }}</td>
                                                <td>{{ $aduan->email }}</td>
                                                <td>{{ $aduan->subject }}</td>
                                                <td>{{ $aduan->message }}</td>
                                                <td>
                                                    @if ($aduan->status == 'unreply')
                                                        <span class="badge badge-warning text-white">Aduan Belum
                                                            Dibalas</span>
                                                    @elseif ($aduan->status == 'replied')
                                                        <span class="badge badge-success">{{ $aduan->status }}</span>
                                                    @else
                                                        <span class="badge badge-danger">{{ $aduan->status }}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($aduan->status == 'unreply')
                                                        <button type="button" class="btn btn-primary btn-sm"
                                                            data-toggle="modal" data-target="#modal-xl{{ $aduan->id }}">
                                                            Balas Pesan
                                                        </button>
                                                        <a href="{{ route('admin.aduan.changeStatus', $aduan->id) }}"
                                                            class="btn btn-success btn-sm"
                                                            onclick="return confirm('apakah yakin sudah mengirim balasan ?')">Tandai
                                                            Selesai</a>
                                                    @endif
                                                </td>
                                            </tr>

                                            <!-- /.Start Modal -->
                                            <div class="modal fade" id="modal-xl{{ $aduan->id }}" style="display: none;"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-xl">
                                                    <div class="modal-content">
                                                        <form id="formEmail{{ $aduan->id }}">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">Kirim Balasan</h4>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <span aria-hidden="true">×</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="row">
                                                                    <div class="col-12">
                                                                        <div class="form-group mb-3">
                                                                            <label for="email">Email Tujuan</label>
                                                                            <input type="email" class="form-control"
                                                                                id="email{{ $aduan->id }}"
                                                                                value="{{ $aduan->email }}" readonly
                                                                                name="email" required>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-12">
                                                                        <div class="form-group mb-3">
                                                                            <label for="subject">Subjek</label>
                                                                            <input type="text" class="form-control"
                                                                                id="subject{{ $aduan->id }}"
                                                                                placeholder="Masukan Subjek Balasan"
                                                                                name="subject" required>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-12">
                                                                        <div class="form-group mb-3">
                                                                            <label for="body">Pesan</label>
                                                                            <textarea class="form-control" id="body{{ $aduan->id }}" rows="5" placeholder="Masukan Pesan Balasan"
                                                                                name="body" required></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer justify-content-between">
                                                                <button type="button" class="btn btn-default"
                                                                    data-dismiss="modal">Close</button>
                                                                <button type="submit" id="submitBtn{{ $aduan->id }}"
                                                                    class="btn btn-primary">Kirim
                                                                    Pesan</button>
                                                            </div>
                                                        </form>

                                                    </div>
                                                    <!-- /.modal-content -->
                                                </div>
                                                <!-- /.modal-dialog -->
                                            </div>
                                            <!-- /.End Modal -->
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
                "buttons": ["copy", "csv", "excel", "pdf", "print"],
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
    <script>
        $(document).ready(function() {
            const aduans = @json($aduans);
            aduans.forEach(aduan => {
                const formId = 'formEmail' + aduan.id;
    
                // Tangkap submit form
                document.getElementById(formId).addEventListener('submit', function(e) {
                    e.preventDefault(); // Mencegah form agar tidak me-refresh halaman
    
                    // Ambil nilai input dari form
                    const email = document.getElementById('email' + aduan.id).value;
                    const subject = document.getElementById('subject' + aduan.id).value;
                    const body = document.getElementById('body' + aduan.id).value;
    
                    // Encode parameter subject dan body
                    const encodedSubject = encodeURIComponent(subject);
                    const encodedBody = encodeURIComponent(body).replace(/%0A/g,
                        '%0D%0A'); // Line break handling
    
                    // Buat URL mailto dengan encodeURIComponent untuk memastikan format URL aman
                    const mailtoUrl =
                        `mailto:${email}?subject=${encodedSubject}&body=${encodedBody}`;
    
                    // Redirect ke URL mailto (akan membuka aplikasi email default)
                    window.location.href = mailtoUrl;
    
                    // Tutup modal secara manual setelah mailto
                    $('#modal-xl' + aduan.id).modal('hide');
                });
            });
        });

    </script>
@endsection
