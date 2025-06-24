<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }} - QREW</title>
    <link rel="icon" href="{{ asset('logoQR-transparent.png') }}" type="image/png">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">

    {{-- SweetAlert2 --}}
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">

    {{-- Toastr --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastr@2.1.4/build/toastr.min.css">

    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">


</head>

<body class="hold-transition sidebar-mini layout-navbar-fixed layout-footer-fixed layout-fixed">
    <!-- Site wrapper -->
    <div class="wrapper">

        @include('layouts.navbar')

        @include('layouts.sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">

            @include('layouts.breadcrumb')

            <!-- Main content -->
            <section class="content">
                @yield('content')
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        @include('layouts.footer')

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- DataTables & Plugins -->
    <script src="{{ asset('adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

    <!-- jquery-validation -->
    <script src="{{ asset('adminlte/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/jquery-validation/additional-methods.min.js') }}"></script>

    <!-- SweetAlert2 -->
    <script src="{{ asset('adminlte/plugins/sweetalert2/sweetalert2.min.js') }}"></script>

    <!-- Toastr -->
    <script src="https://cdn.jsdelivr.net/npm/toastr@2.1.4/toastr.min.js"></script>

    <!-- CUID -->
    <script src="https://cdn.jsdelivr.net/npm/cuid@3.0.0/dist/cuid.min.js"></script>

    <!-- AdminLTE App -->
    <script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Global DataTable error handler
        $(document).ready(function() {
            $.fn.dataTable.ext.errMode = function(settings, helpPage, message) {
                console.error('DataTable error:', message);
                console.error('Settings:', settings);
                
                // Show user-friendly error message
                if (message.includes('Invalid JSON response')) {
                    toastr.error('Failed to load data. Please refresh the page.');
                } else {
                    toastr.error('An error occurred while loading data.');
                }
            };

            // Global function to safely reload DataTable
            window.safeReloadDataTable = function(tableId) {
                try {
                    if ($.fn.DataTable.isDataTable(tableId)) {
                        $(tableId).DataTable().ajax.reload(null, false);
                    } else {
                        console.warn('DataTable not found:', tableId);
                        window.location.reload();
                    }
                } catch (e) {
                    console.error('Error reloading DataTable:', e);
                    window.location.reload();
                }
            };

            // Debug function to check DataTable status
            window.debugDataTable = function(tableId) {
                console.log('=== DataTable Debug Info ===');
                console.log('Table ID:', tableId);
                console.log('Table exists:', $(tableId).length > 0);
                console.log('Is DataTable:', $.fn.DataTable.isDataTable(tableId));
                if ($.fn.DataTable.isDataTable(tableId)) {
                    var table = $(tableId).DataTable();
                    console.log('DataTable instance:', table);
                    console.log('Ajax URL:', table.ajax.url());
                }
                console.log('=== End Debug Info ===');
            };
        });
    </script>
    @yield('scripts')
</body>

</html>
