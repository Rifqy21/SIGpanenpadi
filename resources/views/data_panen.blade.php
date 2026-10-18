<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Panen</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Icon -->
    <script src="https://kit.fontawesome.com/26af10689e.js" crossorigin="anonymous"></script>

    <!-- Bootstrap 4 + AdminLTE lokal (sama seperti halaman lain) -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/dist/css/adminlte.min.css') }}">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        :root {
            --lp-primary: #5A67D8;
            --lp-primary-dark: #4C51BF;
            --lp-primary-soft: #EEF0FF;
            --lp-ink: #1A202C;
            --lp-muted: #64748B;
            --lp-border: #E5E7EF;
            --lp-bg: #F8F9FD;
        }

        body.lp-body {
            font-family: 'Inter', sans-serif;
            color: var(--lp-ink);
            background:
                radial-gradient(600px 300px at 10% 0%, rgba(90, 103, 216, .14), transparent 70%),
                radial-gradient(500px 300px at 95% 10%, rgba(139, 92, 246, .12), transparent 70%),
                var(--lp-bg);
            background-attachment: fixed;
            margin: 0;
            overflow-x: hidden;
        }

        /* ---------- Navbar (sama dengan halaman lain) ---------- */
        .lp-nav {
            position: fixed;
            top: 16px;
            left: 50%;
            transform: translateX(-50%);
            width: min(1100px, calc(100% - 32px));
            z-index: 1100;
            background: rgba(255, 255, 255, .85);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border: 1px solid var(--lp-border);
            border-radius: 16px;
            box-shadow: 0 8px 30px rgba(90, 103, 216, .1);
            padding: 10px 18px;
        }

        .lp-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 800;
            color: var(--lp-ink);
            text-decoration: none !important;
            letter-spacing: -.01em;
        }

        .lp-brand .logo {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--lp-primary), #8B5CF6);
            color: #fff;
            display: grid;
            place-items: center;
            font-size: 16px;
        }

        .lp-nav .nav-link {
            color: var(--lp-muted);
            font-weight: 600;
            font-size: .9rem;
            padding: 8px 14px !important;
            border-radius: 10px;
            transition: all .2s;
        }

        .lp-nav .nav-link:hover,
        .lp-nav .nav-link.active-lp { color: var(--lp-primary); background: var(--lp-primary-soft); }

        .lp-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            font-weight: 600;
            border-radius: 10px;
            border: 1px solid transparent;
            transition: all .2s;
            text-decoration: none !important;
            cursor: pointer;
        }

        .lp-btn-primary { background: var(--lp-primary); color: #fff !important; }
        .lp-btn-primary:hover { background: var(--lp-primary-dark); }
        .lp-nav .lp-btn { padding: 5px 14px; font-size: .78rem; }

        /* ---------- Halaman ---------- */
        .page-wrap { padding: 110px 0 60px; }

        .page-head {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 24px;
        }

        .page-head .ico {
            flex: none;
            width: 52px;
            height: 52px;
            border-radius: 16px;
            background: linear-gradient(135deg, var(--lp-primary), #8B5CF6);
            color: #fff;
            display: grid;
            place-items: center;
            font-size: 22px;
            box-shadow: 0 10px 25px rgba(90, 103, 216, .3);
        }

        .page-head h1 {
            font-size: clamp(1.4rem, 3vw, 1.9rem);
            font-weight: 800;
            letter-spacing: -.02em;
            margin: 0;
        }

        .page-head p { margin: 2px 0 0; color: var(--lp-muted); font-size: .95rem; }

        .panel-card {
            background: #fff;
            border: 1px solid var(--lp-border);
            border-radius: 22px;
            box-shadow: 0 20px 50px rgba(90, 103, 216, .08);
        }

        /* ---------- Filter ---------- */
        .filter-card { padding: 20px 22px; margin-bottom: 20px; }

        .filter-card label {
            display: block;
            font-size: .72rem;
            font-weight: 700;
            letter-spacing: .06em;
            text-transform: uppercase;
            color: var(--lp-muted);
            margin-bottom: 6px;
        }

        .filter-card .form-control,
        .select2-container .select2-selection--single {
            height: 44px !important;
            border: 1px solid var(--lp-border) !important;
            border-radius: 12px !important;
            font-size: .92rem;
            font-weight: 500;
            box-shadow: none;
            background-color: #fff;
        }

        .filter-card .form-control:focus,
        .select2-container--default.select2-container--focus .select2-selection--single,
        .select2-container--default.select2-container--open .select2-selection--single {
            border-color: var(--lp-primary) !important;
            box-shadow: 0 0 0 3px rgba(90, 103, 216, .15);
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 42px !important;
            padding-left: 14px;
            color: var(--lp-ink);
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow { height: 42px !important; right: 8px; }

        .select2-dropdown {
            border: 1px solid var(--lp-border) !important;
            border-radius: 14px !important;
            overflow: hidden;
            box-shadow: 0 16px 40px rgba(90, 103, 216, .18);
        }

        .select2-container--default .select2-results__option--highlighted[aria-selected],
        .select2-container--default .select2-results__option--highlighted.select2-results__option--selectable {
            background: var(--lp-primary) !important;
        }

        .select2-search--dropdown .select2-search__field {
            border: 1px solid var(--lp-border) !important;
            border-radius: 10px;
            padding: 6px 10px;
        }

        /* ---------- Tabel ---------- */
        .table-card { padding: 22px; }

        .table-card .dataTables_wrapper .row:first-child { margin-bottom: 14px; align-items: center; }
        .table-card .dataTables_wrapper .row:last-child { margin-top: 14px; align-items: center; }

        .dataTables_filter { text-align: right !important; }

        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info {
            font-size: .85rem;
            color: var(--lp-muted);
            font-weight: 500;
        }

        .dataTables_wrapper .dataTables_length select,
        .dataTables_wrapper .dataTables_filter input {
            border: 1px solid var(--lp-border);
            border-radius: 10px;
            height: 38px;
            padding: 0 12px;
            color: var(--lp-ink);
            background: #fff;
            outline: none;
            transition: all .2s;
        }

        .dataTables_wrapper .dataTables_filter input { margin-left: 8px; min-width: 220px; }

        .dataTables_wrapper .dataTables_length select:focus,
        .dataTables_wrapper .dataTables_filter input:focus {
            border-color: var(--lp-primary);
            box-shadow: 0 0 0 3px rgba(90, 103, 216, .15);
        }

        table.lp-table {
            width: 100% !important;
            border-collapse: separate;
            border-spacing: 0;
            border: 1px solid var(--lp-border);
            border-radius: 16px;
            overflow: hidden;
            margin-bottom: 0 !important;
        }

        table.lp-table thead th {
            background: #fff;
            color: #111827;
            font-size: .74rem;
            font-weight: 700;
            letter-spacing: .06em;
            text-transform: uppercase;
            border: 0 !important;
            border-bottom: 1px solid var(--lp-border) !important;
            padding: 14px 16px;
            white-space: nowrap;
        }

        table.lp-table tbody td {
            border: 0;
            border-bottom: 1px solid var(--lp-border);
            padding: 13px 16px;
            font-size: .9rem;
            vertical-align: middle;
        }

        table.lp-table tbody tr:last-child td { border-bottom: 0; }
        table.lp-table tbody tr:nth-child(even) td { background: #FAFBFF; }
        table.lp-table tbody tr:hover td { background: var(--lp-primary-soft); }

        table.lp-table td.col-prov { font-weight: 600; }
        table.lp-table td.col-num,
        table.lp-table th.col-num { text-align: right; font-variant-numeric: tabular-nums; }

        .badge-tahun {
            display: inline-block;
            padding: 3px 12px;
            border-radius: 999px;
            background: var(--lp-primary-soft);
            color: var(--lp-primary-dark);
            font-size: .78rem;
            font-weight: 700;
        }

        /* Panah urut DataTables */
        table.dataTable thead .sorting:before,
        table.dataTable thead .sorting_asc:before,
        table.dataTable thead .sorting_desc:before,
        table.dataTable thead .sorting:after,
        table.dataTable thead .sorting_asc:after,
        table.dataTable thead .sorting_desc:after { color: #111827; }

        /* Paginasi */
        .dataTables_wrapper .pagination { margin: 0; gap: 4px; justify-content: flex-end; flex-wrap: wrap; }

        .dataTables_wrapper .page-item .page-link {
            border: 1px solid var(--lp-border);
            border-radius: 10px !important;
            color: var(--lp-muted);
            font-size: .85rem;
            font-weight: 600;
            padding: 7px 13px;
            margin: 0;
            background: #fff;
        }

        .dataTables_wrapper .page-item .page-link:hover { color: var(--lp-primary); border-color: var(--lp-primary); background: var(--lp-primary-soft); }

        .dataTables_wrapper .page-item.active .page-link {
            background: var(--lp-primary);
            border-color: var(--lp-primary);
            color: #fff;
        }

        .dataTables_wrapper .page-item.disabled .page-link { opacity: .5; background: #fff; }

        table.dataTable.dtr-inline.collapsed > tbody > tr > td.dtr-control:before,
        table.dataTable.dtr-inline.collapsed > tbody > tr > th.dtr-control:before { background-color: var(--lp-primary); }

        @media (max-width: 991px) {
            .lp-nav { top: 10px; padding: 8px 14px; }
            .lp-nav .navbar-collapse { padding: 12px 0 6px; }
        }

        @media (max-width: 767px) {
            .page-wrap { padding-top: 90px; }
            .filter-card, .table-card { padding: 16px; }
            .dataTables_filter { text-align: left !important; margin-top: 10px; }
            .dataTables_wrapper .dataTables_filter input { min-width: 0; width: calc(100% - 70px); }
            .dataTables_wrapper .pagination { justify-content: flex-start; margin-top: 10px; }
        }
    </style>
</head>

<body class="lp-body">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg lp-nav">
        <a class="lp-brand" href="{{ route('landing-page') }}">
            <span class="logo"><i class="fas fa-wheat-awn"></i></span>
            SIG Panen Padi
        </a>
        <button class="navbar-toggler border-0" type="button" data-toggle="collapse" data-target="#lpNav"
            aria-controls="lpNav" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="lpNav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                    <a class="nav-link @if (request()->is('/')) active-lp @endif"
                        href="{{ route('landing-page') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if (request()->is('dataPanen') || request()->is('data-panen')) active-lp @endif"
                        href="{{ route('data-panen') }}">Data Panen</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if (request()->is('bpsMaps')) active-lp @endif"
                        href="{{ route('bps-maps') }}">Peta</a>
                </li>
            </ul>
            <a class="lp-btn lp-btn-primary" href="{{ route('login') }}">
                <i class="fas fa-sign-in-alt"></i> Login
            </a>
        </div>
    </nav>

    <!-- Konten -->
    <main class="page-wrap" id="data_panen">
        <div class="container">

            <div class="page-head">
                <div>
                    <h1>Data Panen Padi</h1>
                    <p>Luas panen, produktivitas, dan produksi padi per provinsi.</p>
                </div>
            </div>

            <!-- Filter -->
            <div class="panel-card filter-card">
                <div class="row align-items-end">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <div class="form-group mb-0">
                            <label for="provinsi">Provinsi</label>
                            <select name="provinsi" id="provinsi" class="form-control">
                                <option value="">Pilih Provinsi</option>
                                @foreach ($provinsi as $item)
                                    <option value="{{ $item->nama_provinsi }}">{{ $item->nama_provinsi }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3 ml-md-auto">
                        <form method="GET" action="{{ route('data-panen') }}" class="mb-0">
                            <div class="form-group mb-0">
                                <label for="tahun">Filter Tahun</label>
                                <select name="tahun" id="tahun" class="form-control" onchange="this.form.submit()">
                                    <option value="semua_tahun" {{ request('tahun') == 'semua_tahun' ? 'selected' : '' }}>Semua Tahun</option>
                                    @foreach ($tahunList as $t)
                                        <option value="{{ $t }}" {{ request('tahun') == $t ? 'selected' : '' }}>{{ $t }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Tabel -->
            <div class="panel-card table-card">
                <div class="table-responsive">
                    <table id="example1" class="table lp-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Provinsi</th>
                                <th class="col-num">Luas Panen</th>
                                <th class="col-num">Produktivitas</th>
                                <th class="col-num">Produksi</th>
                                <th>Tahun</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dataBps as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="col-prov">{{ $item['provinsi'] }}</td>
                                    <td class="col-num">{{ $item['luas_panen'] }}</td>
                                    <td class="col-num">{{ $item['produktifitas'] }}</td>
                                    <td class="col-num">{{ $item['produksi'] }}</td>
                                    <td><span class="badge-tahun">{{ $item['tahun'] }}</span></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>

    <!-- Scripts -->
    <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/dist/js/adminlte.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    @if (session('success'))
        <script>
            $(document).Toasts('create', { class: 'bg-success', title: 'Sukses', body: @json(session('success')) });
        </script>
    @endif
    @if (session('info'))
        <script>
            $(document).Toasts('create', { class: 'bg-info', title: 'Informasi', body: @json(session('info')) });
        </script>
    @endif
    @if (session('error'))
        <script>
            $(document).Toasts('create', { class: 'bg-danger', title: 'Gagal', body: @json(session('error')) });
        </script>
    @endif
    @if ($errors->any())
        <script>
            @foreach ($errors->all() as $error)
                $(document).Toasts('create', { class: 'bg-danger', title: 'Gagal', body: @json($error) });
            @endforeach
        </script>
    @endif

    <script>
        $('#provinsi').select2({
            placeholder: 'Pilih Provinsi',
            width: '100%'
        });

        // datatable dengan provinsi sebagai filter
        $(document).ready(function() {
            const table = $('#example1').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true,
                "responsive": true,
                "language": {
                    "search": "Cari:",
                    "searchPlaceholder": "Ketik untuk mencari...",
                    "lengthMenu": "Tampilkan _MENU_ data",
                    "info": "Menampilkan _START_–_END_ dari _TOTAL_ data",
                    "infoEmpty": "Tidak ada data",
                    "infoFiltered": "(disaring dari _MAX_ data)",
                    "zeroRecords": "Data tidak ditemukan",
                    "paginate": { "first": "Awal", "last": "Akhir", "next": "›", "previous": "‹" }
                }
            });

            $('#provinsi').on('change', function() {
                const selectedProvinsi = $(this).val(); // Mendapatkan nilai provinsi yang dipilih
                // Terapkan filter berdasarkan provinsi yang dipilih (kolom 1 = Provinsi)
                if (selectedProvinsi) {
                    const aman = selectedProvinsi.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
                    table.column(1).search('^' + aman + '$', true, false).draw();
                } else {
                    table.column(1).search('').draw(); // Kosongkan filter jika tidak ada provinsi yang dipilih
                }
            });
        });
    </script>
</body>

</html>