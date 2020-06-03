<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>PRAM | Registro</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

     <!-- Font Awesome -->
     <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css')}}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>

<body class="hold-transition register-page"style="background-color: white;">
    <div class="register-box" style="margin-top: -10%;" >
       
        <div class="login-logo">
            <img src="{{asset('/images/PRAM_login.png')}}" alt="Logo" style="max-width: 100%;">
        </div><!-- /.login-logo -->
        <div class="card">
            <div class="card-body register-card-body">
                <div class="row text-center mb-3">
                    <div class="col-md-12">
                        <b>REGISTRO DE USUARIO</b>
                    </div>
                </div>

                <form action="{{route('register')}}" method="post">
                    @csrf
                    <div class="row">
                    <div class="col-md-12">
                            <input type="email" class="form-control" name="email" placeholder="Email" value="{{old('email')}}">

                            <div class="input-group mb-3">
                                @if ($errors->has('email'))
                                <span class="text-danger ml-1">{{ $errors->first('email') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-12">
                            <input type="text" class="form-control" name="name" placeholder="Nombre Completo" value="{{old('name')}}">
                            <div class="input-group mb-3">
                                @if ($errors->has('name'))
                                <span class="text-danger ml-1">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                        </div>
                       
                        <div class="col-md-12">
                            <input type="password" class="form-control" name="password" placeholder="Contraseña">
                            <div class="input-group mb-3">
                                @if ($errors->has('password'))
                                <span class="text-danger ml-1">{{ $errors->first('password') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-12">
                            <input type="password" class="form-control" name="password_confirmation" placeholder="Repita Contraseña">
                            <!-- <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div> -->
                        </div>
                    </div>

                    <div class="row">
                        
                        <!-- /.col -->
                        <div class="col-md-6 offset-md-3 mt-3">
                            <button type="submit" class="btn btn-info btn-block btn-flat">Registrar</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
                <div class="row mt-2">
                    <div class="col-12 text-center">
                        <a href="{{route('login')}}" class="text-center">Ya tengo una cuenta</a>
                    </div>
                </div>

            </div>
            <!-- /.form-box -->
        </div><!-- /.card -->
    </div>
    <!-- /.register-box -->

    <!-- jQuery -->
    <script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <!-- AdminLTE App -->
    <script src="{{asset('dist/js/adminlte.min.js')}}"></script>
</body>

</html>