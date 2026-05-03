<!doctype html>
<html lang="{{ str_replace('_','-',app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <title>Ticiby - Yönetici paneli</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="author" content="Ticiby" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico" />

    <script src="{{ asset('other/notyf/notyf.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('other/notyf/notyf.min.css') }}">
    <!-- Vector Maps css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="{{ asset('panel/assets/plugins/jsvectormap/jsvectormap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Theme Config Js -->
    <script src="{{ asset('panel/assets/js/config.js') }}"></script>

    <!-- Vendor css -->
    <link href="{{ asset('panel/assets/css/vendors.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- App css -->
    <link href="{{ asset('panel/assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('panel/assets/css/custom.css') }}" rel="stylesheet" type="text/css" />

    @livewireStyles
    <style>[x-cloak]{display:none !important;}</style>

</head>

<body>
<!-- Begin page -->
<div class="wrapper">
    @include('setting::backend.include.header')
    <!-- Topbar End -->
    @include('setting::backend.include.sidebar')
    <!-- Sidenav Menu End -->

    <!-- ============================================================== -->
    <!-- Start Main Content -->
    <!-- ============================================================== -->

    <div class="content-page">
       @yield('content')
        <!-- container -->

        <!-- Footer Start -->
        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 text-center">
                        ©
                        <script>
                            document.write(new Date().getFullYear())
                        </script>
                        Powered by <span class="fw-semibold">Ticiby</span>
                    </div>
                </div>
            </div>
        </footer>
        <!-- end Footer -->

    </div>

    <!-- ============================================================== -->
    <!-- End of Main Content -->
    <!-- ============================================================== -->
</div>
<!-- END wrapper -->

@include('setting::backend.include.canvas-bar')
<script>
    const notyf = new Notyf({
        duration: 3000,
        position: {x: "right", y: "top"},
        dismissible: true
    });
    @if(Session::has('success'))
    notyf.success("{{ Session::get('success') }}");
    @endif
    @if(Session::has('error'))
    notyf.error("{{ Session::get('error') }}");
    @endif
    @if(Session::has('warning'))
    notyf.warning("{{ Session::get('warning') }}");
    @endif
    @if($errors->any())
    @foreach($errors->all() as $error)
    notyf.error("{{ $error }}");
    @endforeach
    @endif
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('panel/assets/js/vendors.min.js') }}"></script>

<!-- App js -->
<script src="{{ asset('panel/assets/js/app.js') }}"></script>


<!-- Apex Charts js -->
<script src="{{ asset('panel/assets/plugins/apexcharts/apexcharts.min.js') }}"></script>

<!-- Vector Map Js -->
<script src="{{ asset('panel/assets/plugins/jsvectormap/jsvectormap.min.js') }}"></script>

@stack('page-scripts')
@yield('js')
@livewireScripts
</body>

</html>
