<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="user" content="{{ Auth::user() }}">
    <title>{{ config('app.name') }} | Dashboard</title>

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="/adminlte/plugins/fontawesome-free/css/all.min.css">
        {{-- Themify Icons --}}
    {{-- <link rel="stylesheet" href="/themify_icons/themify_icons.css"> --}}
    <link rel="stylesheet" href="https://rawgit.com/lykmapipo/themify-icons/master/css/themify-icons.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

    <!-- Theme style -->
    <link rel="stylesheet" href="/adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="/adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="/adminlte/plugins/toastr/toastr.min.css">
    <!-- Theme style login -->
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="/adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/adminlte/dist/css/adminlte.min.css">
    
    {{-- <link rel="stylesheet" href="/adminlte/plugins/sweetalert2/sweetalert2.min.css"> --}}
    <link rel="stylesheet" href="/adminlte/css/adminlte.min.css">

    <link rel="stylesheet" href="{{ mix('css/app.css') }}>

    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <!-- CSS pages -->
  <script type="text/javascript">
    // console.log(json_encode(Auth::user()->allPermissions()))
    window.Laravel = {
        csrfToken: "{{ csrf_token() }}",
        jsPermissions: JSON.parse(localStorage.getItem('permissions'))
        // Json.parse('localStorage.getItem('user')')
        // jsPermissions: {{ Auth::user() }}
    }
    console.log(window.Laravel)
</script>
</head>
{{-- <body class="hold-transition sidebar-mini"> --}}
    <body class="hold-transition login-page">   

    <div id="app">
        <main-app></main-app>
    </div>

    <!-- REQUIRED SCRIPTS -->
    <!-- jQuery -->
    <script src="/adminlte/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/adminlte/plugins/chart.js/Chart.min.js"></script>
    <!-- DataTables -->
    {{-- <script src="/adminlte/plugins/datatables/jquery.dataTables.js"></script>
    <script src="/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="/adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="/adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script> --}}
    <script src="/adminlte/plugins/toastr/toastr.min.js"></script>
    <script src="/adminlte/plugins/sweetalert2/sweetalert_2.min.js"></script>
    <!-- AdminLTE App -->
    <script src="/adminlte/js/adminlte.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>
    <!-- AdminLTE App -->
    <script src="{{ mix('js/app.js') }}"></script>


</body>

</html>
