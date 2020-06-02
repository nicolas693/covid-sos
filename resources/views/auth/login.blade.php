<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Agenda | Log in</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>

<body class="hold-transition login-page">
    <div class="login-box" style="margin-top: -10%;">
        <div class="login-logo">
            <a href="../../index2.html"><b>COVID-SOS</b>OCCIDENTE</a>
        </div>
        <!-- /.login-logo -->
        <div class="card">

            <div class="card-body login-card-body">
                <!-- <p class="login-box-msg">Sign in to start your session</p> -->
                @if(Session::has('error'))
                <div class="card bg-danger">
                    <div class="card-body">
                        <span>{{ Session::get('error') }}</span>
                    </div>
                </div>
                @endif

                <div class="row text-center mb-3">
                    <div class="col-md-12">
                        <b>INICIO SESIÓN</b>
                    </div>
                </div>

                <form action="{{route('login')}}" method="post">
                    @csrf
                    <div class="input-group">
                        <input type="email" class="form-control" name="email" placeholder="Email" @if(old('email')) value="{{old('email')}}" @endif>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>

                    <div class="input-group mb-3">
                        @if ($errors->has('email'))
                        <span class="text-danger">{{ $errors->first('email') }}</span>
                        @endif
                    </div>

                    <div class="input-group">
                        <input type="password" class="form-control" name="password" placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>

                    <div class="input-group mb-3">
                        @if ($errors->has('password'))
                        <span class="text-danger">{{ $errors->first('password') }}</span>
                        @endif
                    </div>


                    <div class="row">
                        <div class="col-md-6 offset-3"><button type="submit" class="btn btn-info btn-block btn-flat">Log In</button></div>
                    </div>

                </form>
                <div class="row mt-2">
                    <div class="col-12 text-center">
                        <a href="#">Recuperar Contraseña</a>
                    </div>
                    <!-- /.col -->
                    <div class="col-12 text-center">
                        <a href="{{route('register')}}">Registrar nuevo usuario</a>
                    </div>
                    <!-- /.col -->
                </div>

            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="../../plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../../dist/js/adminlte.min.js"></script>

</body>

</html>