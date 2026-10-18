<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ADMIN | SIG</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
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
    @yield('styles')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="{{ asset('assets/plugins/dist/img/AdminLTELogo.png') }}"
                alt="AdminLTELogo" height="60" width="60">
        </div>

        <!-- Navbar -->
        @include('admin.layouts.navbar')
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        @include('admin.layouts.sidebar')

        @yield('content')

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('assets/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- ChartJS -->
    <script src="{{ asset('assets/plugins/chart.js/Chart.min.js') }}"></script>
    <!-- Sparkline -->
    <script src="{{ asset('assets/plugins/sparklines/sparkline.js') }}"></script>
    <!-- JQVMap -->
    <script src="{{ asset('assets/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
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

    <!-- ========== Notifikasi (SweetAlert2, tertutup otomatis) ========== -->
    @php
        $toastType = null;
        $toastTitle = null;
        $toastMsg = null;

        if (session('success')) {
            $toastType = 'success'; $toastTitle = 'Berhasil'; $toastMsg = session('success');
        } elseif (session('info')) {
            $toastType = 'info'; $toastTitle = 'Informasi'; $toastMsg = session('info');
        } elseif (session('error')) {
            $toastType = 'error'; $toastTitle = 'Gagal'; $toastMsg = session('error');
        } elseif ($errors->any()) {
            $toastType = 'error'; $toastTitle = 'Gagal'; $toastMsg = $errors->first();
        }
    @endphp

    @if ($toastType)
        <style>
            .pm-toast {
                border-radius: 14px !important;
                box-shadow: 0 12px 30px rgba(15, 23, 42, .15) !important;
                padding: 12px 16px !important;
                font-family: 'Source Sans Pro', 'Inter', sans-serif !important;
                border: 1px solid #E5E7EF;
                width: 340px !important;
            }

            .pm-toast .swal2-title {
                font-size: .9rem !important;
                font-weight: 700 !important;
                color: #1A202C !important;
                margin: 0 !important;
                text-align: left !important;
                padding: 0 !important;
            }

            .pm-toast .swal2-html-container {
                font-size: .8rem !important;
                color: #64748B !important;
                margin: 2px 0 0 !important;
                padding: 0 !important;
                text-align: left !important;
            }

            .pm-toast .swal2-icon {
                width: 32px !important;
                height: 32px !important;
                min-width: 32px;
                margin: 0 12px 0 0 !important;
                border-width: 2px !important;
            }

            .pm-toast .swal2-icon .swal2-icon-content {
                font-size: .95rem !important;
            }

            .pm-toast .swal2-timer-progress-bar-container {
                height: 3px !important;
                background: #EEF0FF !important;
            }

            .pm-toast .swal2-timer-progress-bar {
                background: #5A67D8 !important;
            }

            .pm-toast .swal2-close {
                font-size: 1.2rem !important;
                color: #94A3B8 !important;
            }
        </style>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            (function () {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2500,
                    timerProgressBar: true,
                    showCloseButton: true,
                    customClass: { popup: 'pm-toast' },
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer);
                        toast.addEventListener('mouseleave', Swal.resumeTimer);
                    }
                });

                Toast.fire({
                    icon: @json($toastType),
                    title: @json($toastTitle),
                    text: @json($toastMsg)
                });
            })();
        </script>
    @endif
    <!-- ========== /Notifikasi ========== -->

    @yield('scripts')
</body>

</html>