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

    <title>COVID-SOS</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{URL::asset('/plugins/fontawesome-free/css/all.min.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{URL::asset('/dist/css/adminlte.min.css')}}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">


    <!-- jQuery -->
    <script src="{{ URL::asset('/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ URL::asset('/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ URL::asset('/dist/js/adminlte.min.js') }}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{ URL::asset('/dist/js/demo.js') }}"></script>

    <script src="{{ URL::asset('/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <script src="{{ URL::asset('/plugins/datatables/FixedHeader/js/dataTables.fixedHeader.min.js') }}"></script>
    <script src="{{ URL::asset('/plugins/datatables/Responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('/plugins/datatables/Responsive/js/responsive.bootstrap4.min.js') }}"></script>


    <link rel="stylesheet" href="{{asset('/plugins/datatables/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('/plugins/datatables/FixedHeader/css/fixedHeader.bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('/plugins/datatables/Responsive/css/responsive.bootstrap.min.css')}}">


    <link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="{{asset('/plugins/toastr/toastr.min.css')}}">
    <!-- Toastr -->
    <script src="{{asset('/plugins/toastr/toastr.min.js')}}"></script>

    <!-- Select2 -->
    <link rel="stylesheet" href="{{asset('/plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
    <!-- Select2 -->
    <script src="{{asset('/plugins/select2/js/select2.full.min.js')}}"></script>

     <!-- Moment -->
     <script src="{{asset('/plugins/moment/moment.min.js')}}"></script>

</head>

<body class="hold-transition layout-top-nav">
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
            <div class="container">
                <a href="../../index3.html" class="navbar-brand">
                    <img src="../../dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                    <span class="brand-text font-weight-light">COVID-SOS</span>
                </a>

                <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse order-3" id="navbarCollapse">
                    <!-- Left navbar links -->
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a href="{{route('profesional.index')}}" class="nav-link">Profesional</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('reclutador.index')}}" class="nav-link">Reclutador</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('callcenter.index')}}" class="nav-link">Call Center</a>
                        </li>

                    </ul>

                    <!-- SEARCH FORM -->
                    <!-- <form class="form-inline ml-0 ml-md-3">
                        <div class="input-group input-group-sm">
                            <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                            <div class="input-group-append">
                                <button class="btn btn-navbar" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form> -->
                </div>

                <!-- Right navbar links -->
                <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
                    <li class="nav-item">
                        <a href="#" class="nav-link">Login</a>
                    </li>


                    <li class="nav-item">
                        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button"><i class="fas fa-th-large"></i></a>
                    </li>
                </ul>
            </div>
        </nav>
        <!-- /.navbar -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @yield('content')
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

        <!-- Main Footer -->
        <footer class="main-footer">
            <!-- To the right -->
            <div class="float-right d-none d-sm-inline">
                Servicio de Salud Metropolitano Occidente
            </div>
            <!-- Default to the left -->
            <strong>COVID-SOS</strong>
        </footer>
    </div>
    <!-- ./wrapper -->


</body>

</html>
