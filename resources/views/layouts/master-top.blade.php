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

    <title>PRAM</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{URL::asset('/plugins/fontawesome-free/css/all.min.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{asset('plugins/ionicons/css/ionicons.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{URL::asset('/dist/css/adminlte.min.css')}}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

    <!-- SweetAlerts 2 -->
    <script src="{{asset('plugins/sweetalert2/sweetalert2.all.min.js')}}"></script>
    <!-- Optional: include a polyfill for ES6 Promises for IE11 -->
    <script src="{{asset('plugins/sweetalert2/polyfill.js')}}"></script>
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


    <link rel="stylesheet" href="{{asset('/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
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
                <a href="{{route('home')}}" class="navbar-brand">
                    <img src="{{asset('/images/PRAM_login.png')}}" alt="Logo" style="max-height: 35px;">
                    <!-- <span class="brand-text font-weight-light">PRAM</span> -->
                </a>

                <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse order-3" id="navbarCollapse">
                    @php $usuario = Auth::user(); @endphp
                    <!-- Left navbar links -->
                    <ul class="navbar-nav">
                        @if($usuario->obtenerTipoUsuario()=='Profesional')
                        <li class="nav-item" style="margin-bottom: 20%;">
                            <a href="{{route('home')}}" class="nav-link"><i class="fas fa-home fa-2x" style="vertical-align: middle;"></i></a>
                        </li>
                        @endif
                        @if($usuario->obtenerTipoUsuario()=='CallCenter')
                        <li class="nav-item" style="margin-bottom: 20%;">
                            <a href="{{route('callcenter.index')}}" class="nav-link"><i class="fas fa-home fa-2x" style="vertical-align: middle;"></i></a>
                        </li>
                        @endif
                        @if($usuario->obtenerTipoUsuario()=='Reclutador')
                        <li class="nav-item">
                            <!-- <a href="{{route('reclutador.index')}}" class="nav-link">Reclutador</a> -->
                            <a href="#" class="nav-link">Reclutador</a>
                        </li>
                        @endif
                        @if($usuario->obtenerTipoUsuario()=='Administrador')
                        <li class="nav-item">
                            <!-- <a href="{{route('reclutador.index')}}" class="nav-link">Reclutador</a> -->
                            <a href="{{route('admin.index')}}" class="nav-link">Administrador</a>
                        </li>
                        @endif

                    </ul>
                </div>

                <!-- Right navbar links -->
                @guest
                <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
                    <li class="nav-item">
                        <a href="{{route('login')}}" class="nav-link">Login</a>
                    </li>

                    <li class="nav-item">
                        <a href="{{route('register')}}" class="nav-link">Register</a>
                    </li>


                    <li class="nav-item">
                        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button"><i class="fas fa-th-large"></i></a>
                    </li>
                </ul>
                @else
                <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="#" id="{{route('user.cambiar',['id'=>$usuario->id])}}" onclick="getCambiarPassword(this.id)">Cambiar Contraseña</a>
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                </ul>

                @endguest
            </div>
        </nav>
        <!-- /.navbar -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <div id="modalP"></div>
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
            <strong>PRAM</strong>
        </footer>
    </div>
    <!-- ./wrapper -->


</body>

</html>

<script>
    function getCambiarPassword(url) {
        $(".verinfo").attr('disabled', true);
        $('.modal').modal('hide');
        $.get(url, function(data) {
            $('#modalP').html(data);
            $('#modalPassword').modal('show');
        });
    }
</script>