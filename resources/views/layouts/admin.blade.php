<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminLTE 3 | Starter</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href={{ asset('https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback') }}>
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href={{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}>
    <link rel="stylesheet" href={{ asset('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}>
    <link rel="stylesheet" href={{ asset('adminlte/plugins/daterangepicker/daterangepicker.css') }}>
    <!-- Theme style -->
    <link rel="stylesheet" href={{ asset('adminlte/dist/css/adminlte.min.css') }}>
    <!-- Select2  -->
    <link rel="stylesheet" href={{ asset('adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}>
    <link rel="stylesheet" href={{ asset('adminlte/plugins/select2/css/select2.min.css') }}>

    <style>
        .ui-autocomplete {

            list-style: none;
            background-color: white;
            border: 1px solid rgba(0, 0, 0, 0.2);
            width: 10%;
            padding: 10px;

        }
    </style>
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        <!-- Navbar -->
        @include('includes.admin.header')
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href={{ asset('index3.html') }} class="brand-link">
                <img src={{ asset('admin_assets/img/LOGO.png') }} alt="Logo"
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">Happy B-day</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src={{ asset('adminlte/dist/img/user2-160x160.jpg') }} class="img-circle elevation-2"
                            alt="User Image">
                    </div>
                    <div class="info">
                        <a href={{ asset('#') }} class="d-block">{{ Auth::user()->name }}</a>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                @include('includes.admin.sidebar')
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">

                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <div class="content">
                <div class="container-fluid">
                    @yield('content')
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
            <div class="p-3">
                <h5>Title</h5>
                <p>Sidebar content</p>
            </div>
        </aside>
        <!-- /.control-sidebar -->

    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src={{ asset('adminlte/plugins/jquery/jquery.min.js') }}></script>
    <script src={{ asset('adminlte/plugins/jquery-ui/jquery-ui.min.js') }}></script>
    <script src={{ asset('adminlte/plugins/datatables/jquery.dataTables.min.js') }}></script>
    <!-- Bootstrap 4 -->
    <script src={{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}></script>
    <script src={{ asset('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}></script>
    <script src={{ asset('adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}></script>
    <script src={{ asset('adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}></script>
    <script src={{ asset('adminlte/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}></script>
    <script src={{ asset('adminlte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}></script>

    <script src={{ asset('adminlte/plugins/datatables-buttons/js/buttons.html5.min.js') }}></script>
    <script src={{ asset('adminlte/plugins/datatables-buttons/js/buttons.print.min.js') }}></script>
    <script src={{ asset('adminlte/plugins/datatables-buttons/js/buttons.colVis.min.js') }}></script>

    <!-- custom-file-input -->
    <script src="{{ asset('adminlte/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
    <!-- daterangepicker -->
    <script src="{{ asset('adminlte/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/daterangepicker/daterangepicker.js') }}"></script>

    <!--Select2 -->
    <script src="{{ asset('adminlte/plugins/select2/js/select2.full.min.js') }}"></script>

    @yield('custom-script')

    <!-- AdminLTE App -->
    <script src={{ asset('adminlte/dist/js/adminlte.min.js') }}></script>
    <script src={{ asset('adminlte/admin.js') }}></script>
    <script>
        $(function() {
            $('#celebrants, #companies').DataTable({
                "language": {
                    "paginate": {
                        "next": "Наступний",
                        "previous": "Попередній"
                    },
                    "search": "Пошук:",
                },
                "order": [
                    [0, 'desc']
                ],
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": false,
                "autoWidth": false,
                "responsive": true,
            });
        });

        $(function() {
            $('#greetingCompanies').DataTable({
                "language": {
                    "paginate": {
                        "next": "Наступний",
                        "previous": "Попередній"
                    },
                    "search": "Пошук:",
                },
                "order": [
                    [0, 'desc']
                ],
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": false,
                "info": false,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>
</body>

</html>
