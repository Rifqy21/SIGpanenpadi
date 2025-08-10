@extends('admin.layouts.app')

@section('styles')
    <style>
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
    <!-- Leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Data Panen Padi</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Data BPS</li>
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
                        <div class="row g-0 text-left ">
                            <div class="col-1 mt-1">
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
                            
                            <div class="col-5"></div>
                            <div class="col-1 mt-2 text-end pr-0">
                                <h1 class="card-title">Filter Tahun</h1>
                            </div>
                            <div class="col-2">
                                <select name="tahun" id="tahun" class="form-control">
                                    <option value="semua_tahun" selected>Semua Tahun</option>
                                    @foreach ($tahun as $t)
                                        <option value="{{ $t }}">{{ $t }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-1">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal">
                                    <i class="fas fa-plus"></i> Tambah Data
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <th>No</th>
                                <th>Provinsi</th>
                                <th>Luas Panen</th>
                                <th>Produktivitas</th>
                                <th>Produksi</th>
                                <th>Tahun</th>
                                <th>Aksi</th>
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
                                        <td>
                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn btn-info btn-sm" 
                                                        onclick="showDetail({{ json_encode($item) }})" 
                                                        title="Detail">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button type="button" class="btn btn-warning btn-sm" 
                                                        onclick="editData({{ json_encode($item) }})" 
                                                        title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button type="button" class="btn btn-danger btn-sm" 
                                                        onclick="deleteData('{{ $item['id'] ?? $loop->iteration }}', '{{ $item['provinsi'] }}')" 
                                                        title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
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


<!-- Modal Tambah Data -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header ">
               <h5 class="modal-title" id="addModalLabel">Tambah Data Panen</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addForm" action="{{ route('bps.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="add_provinsi">Provinsi</label>
                        <select name="provinsi" id="add_provinsi" class="form-control" required>
                            <option value="">Pilih Provinsi</option>
                            @foreach ($provinsis as $prov)
                                <option value="{{ $prov->nama_provinsi }}">{{ $prov->nama_provinsi }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="add_luas_panen">Luas Panen (Ha)</label>
                        <input type="number" step="0.01" name="luas_panen" id="add_luas_panen" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="add_produktifitas">Produktivitas (Ton/Ha)</label>
                        <input type="number" step="0.01" name="produktifitas" id="add_produktifitas" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="add_produksi">Produksi (Ton)</label>
                        <input type="number" step="0.01" name="produksi" id="add_produksi" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="add_tahun">Tahun</label>
                        <input type="number" name="tahun" id="add_tahun" class="form-control" min="2000" max="2030" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Data -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Data Panen</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editForm" action="" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit_provinsi">Provinsi</label>
                        <select name="provinsi" id="edit_provinsi" class="form-control" required>
                            <option value="">Pilih Provinsi</option>
                            @foreach ($provinsis as $prov)
                                <option value="{{ $prov->nama_provinsi }}">{{ $prov->nama_provinsi }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit_luas_panen">Luas Panen (Ha)</label>
                        <input type="number" step="0.01" name="luas_panen" id="edit_luas_panen" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_produktifitas">Produktivitas (Ton/Ha)</label>
                        <input type="number" step="0.01" name="produktifitas" id="edit_produktifitas" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_produksi">Produksi (Ton)</label>
                        <input type="number" step="0.01" name="produksi" id="edit_produksi" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_tahun">Tahun</label>
                        <input type="number" name="tahun" id="edit_tahun" class="form-control" min="2000" max="2030" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Detail Data -->
<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel">Detail Data Panen</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-borderless">
                    <tr>
                        <td width="30%"><strong>Provinsi</strong></td>
                        <td width="10%">:</td>
                        <td id="detail_provinsi">-</td>
                    </tr>
                    <tr>
                        <td><strong>Luas Panen</strong></td>
                        <td>:</td>
                        <td id="detail_luas_panen">-</td>
                    </tr>
                    <tr>
                        <td><strong>Produktivitas</strong></td>
                        <td>:</td>
                        <td id="detail_produktifitas">-</td>
                    </tr>
                    <tr>
                        <td><strong>Produksi</strong></td>
                        <td>:</td>
                        <td id="detail_produksi">-</td>
                    </tr>
                    <tr>
                        <td><strong>Tahun</strong></td>
                        <td>:</td>
                        <td id="detail_tahun">-</td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {

            $('#provinsi').select2({
                placeholder: 'Semua Provinsi',
            });

            $('#add_provinsi').select2({
                placeholder: 'Pilih Provinsi',
                dropdownParent: $('#addModal')
            });

            $('#edit_provinsi').select2({
                placeholder: 'Pilih Provinsi',
                dropdownParent: $('#editModal')
            });

            // Initialize DataTable untuk download
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
                    table.column(1).search('').draw();
                } else {
                    if (selectedProvinsi) {
                        table.column(1).search('^' + selectedProvinsi + '$', true, false).draw();
                    } else {
                        table.column(1).search('').draw();
                    }
                }
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

            // Auto calculate produksi when luas_panen or produktifitas changes
            function calculateProduksi(luasInput, produktifitasInput, produksiInput) {
                $(luasInput + ', ' + produktifitasInput).on('input', function() {
                    var luasPanen = parseFloat($(luasInput).val()) || 0;
                    var produktifitas = parseFloat($(produktifitasInput).val()) || 0;
                    var produksi = luasPanen * produktifitas;
                    $(produksiInput).val(produksi.toFixed(2));
                });
            }

            // Apply to both add and edit forms
            calculateProduksi('#add_luas_panen', '#add_produktifitas', '#add_produksi');
            calculateProduksi('#edit_luas_panen', '#edit_produktifitas', '#edit_produksi');

        });

        // Function to show detail modal
        function showDetail(data) {
            $('#detail_provinsi').text(data.provinsi);
            $('#detail_luas_panen').text(data.luas_panen + ' Ha');
            $('#detail_produktifitas').text(data.produktifitas + ' Ton/Ha');
            $('#detail_produksi').text(data.produksi + ' Ton');
            $('#detail_tahun').text(data.tahun);
            $('#detailModal').modal('show');
        }

        // Function to edit data
        function editData(data) {
            $('#edit_provinsi').val(data.provinsi).trigger('change');
            $('#edit_luas_panen').val(data.luas_panen);
            $('#edit_produktifitas').val(data.produktifitas);
            $('#edit_produksi').val(data.produksi);
            $('#edit_tahun').val(data.tahun);
            
            // Set form action URL (adjust based on your route)
            $('#editForm').attr('action', '{{ route("bps.update", ":id") }}'.replace(':id', data.id || ''));
            
            $('#editModal').modal('show');
        }

        // Function to delete data
        function deleteData(id, provinsi) {
            Swal.fire({
                title: 'Konfirmasi Hapus',
                text: 'Apakah Anda yakin ingin menghapus data panen untuk provinsi ' + provinsi + '?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Create form for delete request
                    var form = $('<form>', {
                        'method': 'POST',
                        'action': '{{ route("bps.destroy", ":id") }}'.replace(':id', id)
                    });
                    
                    // Add CSRF token
                    form.append($('<input>', {
                        'type': 'hidden',
                        'name': '_token',
                        'value': '{{ csrf_token() }}'
                    }));
                    
                    // Add method spoofing for DELETE
                    form.append($('<input>', {
                        'type': 'hidden',
                        'name': '_method',
                        'value': 'DELETE'
                    }));
                    
                    // Append form to body and submit
                    $('body').append(form);
                    form.submit();
                }
            });
        }

        // Handle success messages
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session("success") }}',
                timer: 3000,
                showConfirmButton: false
            });
        @endif

        // Handle error messages
        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: '{{ session("error") }}',
            });
        @endif
    </script>

    
@endsection
