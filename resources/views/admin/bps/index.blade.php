@extends('admin.layouts.app')

@section('styles')
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        /* ---------- Base ---------- */
        .dp-page {
            --dp-primary: #5A67D8;
            --dp-primary-dark: #4C51BF;
            --dp-ink: #1A202C;
            --dp-muted: #64748B;
            --dp-border: #E5E7EF;
            --dp-soft: #F8F9FC;
        }

        /* ---------- Filter bar ---------- */
        .dp-filter {
            display: flex;
            flex-wrap: wrap;
            align-items: flex-end;
            gap: 14px;
            padding: 16px 20px;
            margin-bottom: 20px;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 8px 30px rgba(15, 23, 42, .06);
        }

        .dp-filter .filter-group {
            flex: 1 1 220px;
            max-width: 300px;
        }

        .dp-filter .filter-label {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: .68rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .04em;
            color: var(--dp-muted);
            margin-bottom: 6px;
        }

        .dp-filter .filter-label i {
            color: var(--dp-primary);
        }

        .dp-filter .filter-action {
            margin-left: auto;
        }

        .dp-btn-add {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            height: 42px;
            padding: 0 18px;
            border: 0;
            border-radius: 11px;
            background: var(--dp-primary);
            color: #fff;
            font-size: .875rem;
            font-weight: 700;
            box-shadow: 0 6px 16px rgba(90, 103, 216, .25);
            transition: background .2s, transform .2s;
        }

        .dp-btn-add:hover {
            background: var(--dp-primary-dark);
            color: #fff;
            transform: translateY(-1px);
        }

        .dp-filter .form-control {
            height: 42px;
            border: 1px solid var(--dp-border);
            border-radius: 11px;
            font-size: .875rem;
            box-shadow: none;
        }

        .dp-filter .form-control:focus {
            border-color: var(--dp-primary);
            box-shadow: 0 0 0 4px rgba(90, 103, 216, .14);
        }

        /* ---------- Select2 ---------- */
        .select2-container {
            width: 100% !important;
        }

        .select2-container .select2-selection--single {
            height: 42px;
            border: 1px solid var(--dp-border);
            border-radius: 11px;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 40px;
            font-size: .875rem;
            color: var(--dp-ink);
            padding-left: 12px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 40px;
        }

        .select2-container--default.select2-container--focus .select2-selection--single,
        .select2-container--default.select2-container--open .select2-selection--single {
            border-color: var(--dp-primary);
            box-shadow: 0 0 0 4px rgba(90, 103, 216, .14);
        }

        /* ---------- Card tabel ---------- */
        .dp-card {
            border: 0;
            border-radius: 16px;
            box-shadow: 0 8px 30px rgba(15, 23, 42, .06);
            overflow: hidden;
        }

        .dp-card .card-header {
            background: #fff;
            border: 0;
            padding: 18px 20px 0;
        }

        .dp-card .card-title-main {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1rem;
            font-weight: 800;
            color: var(--dp-ink);
            margin: 0;
        }

        .dp-card .card-sub {
            font-size: .78rem;
            color: var(--dp-muted);
            margin: 4px 0 0;
        }

        .dp-card .card-body {
            padding: 16px 20px 20px;
        }

        /* ---------- Tabel: garis tipis antar sel ---------- */
        .dp-page table.dataTable {
            border-collapse: collapse !important;
            border: 1px solid var(--dp-border) !important;
        }

        .dp-page table.dataTable thead th,
        .dp-page table.dataTable tbody td {
            border: 1px solid var(--dp-border) !important;
        }

        .dp-page table.dataTable thead th {
            background: var(--dp-soft);
            color: var(--dp-muted);
            font-size: .72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .04em;
            padding: 12px 14px;
            vertical-align: middle;
        }

        .dp-page table.dataTable tbody td {
            vertical-align: middle;
            font-size: .875rem;
            color: var(--dp-ink);
            padding: 10px 14px;
            background: #fff;
        }

        .dp-page table.dataTable tbody tr:hover td {
            background: #FAFAFF;
        }

        .dp-page .prov-name {
            font-weight: 700;
        }

        .badge-tahun {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 999px;
            background: #EEF0FF;
            color: var(--dp-primary);
            font-weight: 700;
            font-size: .78rem;
        }

           /* ---------- Tombol aksi berwarna (icon di atas, keterangan di bawah, ukuran pas) ---------- */
        .aksi-btns {
            display: inline-flex;
            gap: 5px;
            white-space: nowrap;
        }

        .btn-aksi {
            display: inline-flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 2px;
            width: auto;
            padding: 4px 8px;
            border: 0;
            border-radius: 7px;
            color: #fff;
            font-size: .6rem;
            font-weight: 600;
            line-height: 1.1;
            box-shadow: 0 2px 5px rgba(15, 23, 42, .08);
            transition: transform .15s, box-shadow .15s, filter .15s;
        }

        .btn-aksi i {
            font-size: .72rem;
            line-height: 1;
        }

        .btn-aksi:hover {
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 5px 12px rgba(15, 23, 42, .15);
            filter: brightness(1.05);
        }

        .btn-aksi.btn-view   { background: #0EA5E9; }
        .btn-aksi.btn-edit   { background: #F59E0B; }
        .btn-aksi.btn-delete { background: #F43F5E; }

        /* ---------- DataTables toolbar ---------- */
        .dp-page .dataTables_wrapper .dt-buttons .btn {
            border-radius: 9px;
            font-size: .8rem;
            font-weight: 600;
            margin-right: 6px;
            border: 1px solid var(--dp-border);
            background: #fff;
            color: var(--dp-ink);
            box-shadow: none;
        }

        .dp-page .dataTables_wrapper .dt-buttons .btn:hover {
            background: var(--dp-soft);
            color: var(--dp-primary);
        }

        .dp-page .dataTables_wrapper .dataTables_filter label {
            font-size: .85rem;
            font-weight: 600;
            color: var(--dp-muted);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .dp-page .dataTables_wrapper .dataTables_filter input {
            border: 1px solid var(--dp-border);
            border-radius: 10px;
            padding: 6px 12px;
            margin-left: 0;
            box-shadow: none;
            font-size: .85rem;
        }

        .dp-page .dataTables_wrapper .dataTables_filter input:focus {
            border-color: var(--dp-primary);
            box-shadow: 0 0 0 4px rgba(90, 103, 216, .14);
            outline: none;
        }

        .dp-page .dataTables_wrapper .dataTables_info {
            font-size: .85rem;
            color: var(--dp-muted);
        }

        .dp-page .dataTables_wrapper .page-link {
            border-radius: 8px !important;
            margin: 0 2px;
            border: 0;
            color: var(--dp-primary);
        }

        .dp-page .dataTables_wrapper .page-item.active .page-link {
            background: var(--dp-primary);
            color: #fff;
        }

        /* ---------- Modal ---------- */
        .dp-page .modal-content {
            border: 0;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 25px 60px rgba(15, 23, 42, .2);
        }

        .dp-page .modal-header {
            background: #fff;
            border-bottom: 1px solid var(--dp-border);
            padding: 16px 22px;
        }

        .dp-page .modal-title {
            font-weight: 800;
            font-size: 1rem;
            color: var(--dp-ink);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .dp-page .modal-title i {
            color: var(--dp-primary);
        }

        .dp-page .modal-body {
            padding: 22px;
        }

        .dp-page .modal-body label {
            font-size: .78rem;
            font-weight: 700;
            color: var(--dp-muted);
            margin-bottom: 6px;
        }

        .dp-page .modal-body .form-control {
            height: 42px;
            border: 1px solid var(--dp-border);
            border-radius: 11px;
            box-shadow: none;
        }

        .dp-page .modal-body .form-control:focus {
            border-color: var(--dp-primary);
            box-shadow: 0 0 0 4px rgba(90, 103, 216, .14);
        }

        .dp-page .modal-footer {
            border-top: 1px solid var(--dp-border);
            padding: 14px 22px;
        }

        .dp-page .modal-footer .btn {
            border-radius: 11px;
            font-weight: 600;
            padding: 8px 18px;
        }

        .dp-page .btn-primary {
            background: var(--dp-primary);
            border-color: var(--dp-primary);
        }

        .dp-page .btn-primary:hover {
            background: var(--dp-primary-dark);
            border-color: var(--dp-primary-dark);
        }

        .dp-page .detail-table td {
            padding: 10px 6px;
            font-size: .9rem;
        }

        .dp-page .detail-table tr {
            border-bottom: 1px dashed var(--dp-border);
        }

        .dp-page .detail-table tr:last-child {
            border-bottom: 0;
        }

        @media (max-width: 768px) {
            .dp-filter .filter-action {
                margin-left: 0;
                width: 100%;
            }

            .dp-btn-add {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
@endsection

@section('content')
    <!-- Content Wrapper -->
    <div class="content-wrapper dp-page">

        <!-- Content Header -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0" style="font-size:1.5rem;font-weight:800;">Data Panen Padi</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right bg-transparent p-0 m-0">
                            <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i> Home</a></li>
                            <li class="breadcrumb-item active">Data Panen</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">

                <!-- Filter bar -->
                <div class="dp-filter">
                    <div class="filter-group">
                        <label for="provinsi" class="filter-label">
                            <i class="fas fa-map-marker-alt"></i> Provinsi
                        </label>
                        <select name="provinsi" id="provinsi" class="form-control">
                            <option value="semua_provinsi">Semua Provinsi</option>
                            @foreach ($provinsis as $prov)
                                <option value="{{ $prov->nama_provinsi }}">{{ $prov->nama_provinsi }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="filter-group">
                        <label for="tahun" class="filter-label">
                            <i class="fas fa-calendar-alt"></i> Tahun
                        </label>
                        <select name="tahun" id="tahun" class="form-control">
                            <option value="semua_tahun" selected>Semua Tahun</option>
                            @foreach ($tahun as $t)
                                <option value="{{ $t }}">{{ $t }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="filter-action">
                        <button type="button" class="dp-btn-add" data-toggle="modal" data-target="#addModal">
                            <i class="fas fa-plus"></i> Tambah Data
                        </button>
                    </div>
                </div>

                <!-- Tabel -->
                <div class="card dp-card">
                    <div class="card-header">
                        <h3 class="card-title-main">
                            <i class="fas fa-table" style="color:#5A67D8;"></i> Daftar Data Panen
                        </h3>
                        <p class="card-sub">Data luas panen, produktivitas, dan produksi per provinsi</p>
                    </div>

                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped w-100">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Provinsi</th>
                                    <th>Luas Panen (Ha)</th>
                                    <th>Produktivitas (Ton/Ha)</th>
                                    <th>Produksi (Ton)</th>
                                    <th>Tahun</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dataBps as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td class="prov-name">{{ $item['provinsi'] }}</td>
                                        <td>{{ $item['luas_panen'] }}</td>
                                        <td>{{ $item['produktifitas'] }}</td>
                                        <td>{{ $item['produksi'] }}</td>
                                        <td><span class="badge-tahun">{{ $item['tahun'] }}</span></td>
                                        <td class="text-center">
                                            <div class="aksi-btns">
                                                <button type="button" class="btn-aksi btn-view"
                                                    onclick="showDetail({{ json_encode($item) }})" title="Detail">
                                                    <i class="fas fa-eye"></i> Detail
                                                </button>
                                                <button type="button" class="btn-aksi btn-edit"
                                                    onclick="editData({{ json_encode($item) }})" title="Ubah">
                                                    <i class="fas fa-edit"></i> Ubah
                                                </button>
                                                <button type="button" class="btn-aksi btn-delete"
                                                    onclick="deleteData('{{ $item['id'] ?? $loop->iteration }}', '{{ $item['provinsi'] }}')"
                                                    title="Hapus">
                                                    <i class="fas fa-trash"></i> Hapus
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </section>

        <!-- Modal Tambah Data -->
        <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel"><i class="fas fa-plus-circle"></i> Tambah Data Panen</h5>
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
                            <button type="button" class="btn btn-light" data-dismiss="modal">Batal</button>
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
                        <h5 class="modal-title" id="editModalLabel"><i class="fas fa-edit"></i> Ubah Data Panen</h5>
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
                            <button type="button" class="btn btn-light" data-dismiss="modal">Batal</button>
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
                        <h5 class="modal-title" id="detailModalLabel"><i class="fas fa-info-circle"></i> Detail Data Panen</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-borderless detail-table mb-0">
                            <tr>
                                <td width="35%" class="text-muted">Provinsi</td>
                                <td width="5%">:</td>
                                <td id="detail_provinsi" class="font-weight-bold">-</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Luas Panen</td>
                                <td>:</td>
                                <td id="detail_luas_panen">-</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Produktivitas</td>
                                <td>:</td>
                                <td id="detail_produktifitas">-</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Produksi</td>
                                <td>:</td>
                                <td id="detail_produksi">-</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Tahun</td>
                                <td>:</td>
                                <td id="detail_tahun">-</td>
                            </tr>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- /.content-wrapper -->
@endsection

@section('scripts')
    <!-- DataTables & Plugins -->
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {

            $('#provinsi').select2({
                placeholder: 'Semua Provinsi',
            });

            $('#tahun').select2({
                placeholder: 'Semua Tahun',
            });

            $('#add_provinsi').select2({
                placeholder: 'Pilih Provinsi',
                dropdownParent: $('#addModal')
            });

            $('#edit_provinsi').select2({
                placeholder: 'Pilih Provinsi',
                dropdownParent: $('#editModal')
            });

            var table = $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "language": {
                    "search": "Cari:",
                    "zeroRecords": "Data tidak ditemukan",
                    "info": "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                    "infoEmpty": "Tidak ada data",
                    "infoFiltered": "(difilter dari _MAX_ data)",
                    "paginate": { "previous": "‹", "next": "›" }
                },
                "buttons": [{
                        extend: 'copy',
                        exportOptions: { columns: ':not(:last-child)' }
                    },
                    {
                        extend: 'csv',
                        exportOptions: { columns: ':not(:last-child)' }
                    },
                    {
                        extend: 'excel',
                        exportOptions: { columns: ':not(:last-child)' }
                    },
                    {
                        extend: 'pdf',
                        exportOptions: { columns: ':not(:last-child)' }
                    },
                    {
                        extend: 'print',
                        exportOptions: { columns: ':not(:last-child)' }
                    }
                ],
                "dom": '<"d-flex flex-wrap justify-content-between align-items-center mb-3"<"dt-left"B><"dt-right"f>>' +
                    '<"row"<"col-sm-12"tr>>' +
                    '<"d-flex flex-wrap justify-content-between align-items-center mt-3"<"dt-info"i><"dt-pages"p>>',
            });

            // Filter Provinsi (kolom 1)
            $('#provinsi').on('change', function() {
                var selectedProvinsi = $(this).val();
                if (selectedProvinsi === 'semua_provinsi' || !selectedProvinsi) {
                    table.column(1).search('').draw();
                } else {
                    table.column(1).search('^' + selectedProvinsi + '$', true, false).draw();
                }
            });

            // Filter Tahun (kolom 5)
            $('#tahun').on('change', function() {
                var selectedTahun = $(this).val();
                if (selectedTahun === 'semua_tahun' || !selectedTahun) {
                    table.column(5).search('').draw();
                } else {
                    table.column(5).search('^' + selectedTahun + '$', true, false).draw();
                }
            });

            // Hitung produksi otomatis (luas panen x produktivitas)
            function calculateProduksi(luasInput, produktifitasInput, produksiInput) {
                $(luasInput + ', ' + produktifitasInput).on('input', function() {
                    var luasPanen = parseFloat($(luasInput).val()) || 0;
                    var produktifitas = parseFloat($(produktifitasInput).val()) || 0;
                    $(produksiInput).val((luasPanen * produktifitas).toFixed(2));
                });
            }

            calculateProduksi('#add_luas_panen', '#add_produktifitas', '#add_produksi');
            calculateProduksi('#edit_luas_panen', '#edit_produktifitas', '#edit_produksi');
        });

        // Modal detail
        function showDetail(data) {
            $('#detail_provinsi').text(data.provinsi);
            $('#detail_luas_panen').text(data.luas_panen + ' Ha');
            $('#detail_produktifitas').text(data.produktifitas + ' Ton/Ha');
            $('#detail_produksi').text(data.produksi + ' Ton');
            $('#detail_tahun').text(data.tahun);
            $('#detailModal').modal('show');
        }

        // Modal ubah
        function editData(data) {
            $('#edit_provinsi').val(data.provinsi).trigger('change');
            $('#edit_luas_panen').val(data.luas_panen);
            $('#edit_produktifitas').val(data.produktifitas);
            $('#edit_produksi').val(data.produksi);
            $('#edit_tahun').val(data.tahun);

            $('#editForm').attr('action', '{{ route("bps.update", ":id") }}'.replace(':id', data.id || ''));

            $('#editModal').modal('show');
        }

        // Hapus data dengan konfirmasi
        function deleteData(id, provinsi) {
            Swal.fire({
                title: 'Konfirmasi Hapus',
                text: 'Apakah Anda yakin ingin menghapus data panen untuk provinsi ' + provinsi + '?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#F43F5E',
                cancelButtonColor: '#64748B',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    var form = $('<form>', {
                        'method': 'POST',
                        'action': '{{ route("bps.destroy", ":id") }}'.replace(':id', id)
                    });

                    form.append($('<input>', { 'type': 'hidden', 'name': '_token', 'value': '{{ csrf_token() }}' }));
                    form.append($('<input>', { 'type': 'hidden', 'name': '_method', 'value': 'DELETE' }));

                    $('body').append(form);
                    form.submit();
                }
            });
        }

        // Notifikasi sukses
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session("success") }}',
                timer: 3000,
                showConfirmButton: false
            });
        @endif

        // Notifikasi error
        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: '{{ session("error") }}',
            });
        @endif
    </script>
@endsection