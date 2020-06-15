@extends('layouts.master-top')
@section('content')


<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 offset-md-2 ">
                <!-- <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1></h1>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="#">Ingresar Solicitud</a></li>
                                    <li class="breadcrumb-item"><a href="#">Editar mis datos</a></li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </section> -->
                <!-- Default box -->
                <div class="card mt-5">
                    <div class="card-header">
                        <h3 class="card-title">Información de postulación</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                <i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-7">
                                <div class="card card-widget widget-user">
                                    @php $user = Auth::user(); $profesional = $user->getProfesional(); @endphp
                                    <!-- Add the bg color to the header using any of the bg-* classes -->

                                    <div class="widget-user-header bg-info">
                                        <h3 class="widget-user-username">{{$user->name}}</h3>
                                        @if($profesional!=null)
                                        <h5 class="widget-user-desc">{{$profesional->getTitulo()->tx_descripcion}}</h5>
                                        @else
                                        <h5 class="widget-user-desc">SIN INFORMACIÓN</h5>
                                        @endif


                                    </div>
                                    <div class="widget-user-image">
                                        <img class="img-circle elevation-2" src="{{asset('/dist/img/user-icon.png')}}" alt="User Avatar">
                                    </div>
                                    <div class="card-footer">
                                        <div class="row">
                                            <div class="col-sm-4 border-right">
                                                <div class="description-block">
                                                    <h5 class="description-header">Estado actual :</h5>
                                                    @if($profesional!=null)
                                                    <span class="description-text">{{$profesional->estado}}</span>
                                                    @else
                                                    <span class="description-text">Sin información</span>
                                                    @endif
                                                </div>
                                                <!-- /.description-block -->
                                            </div>
                                            <!-- /.col -->
                                            <div class="col-sm-4 border-right">
                                                <div class="description-block">
                                                    <h5 class="description-header">Lugar de trabajo:</h5>
                                                    @if($profesional!=null && $profesional->getAsignacion()!=null)
                                                    <span class="description-text">{{$profesional->getAsignacion()->getNombreEstablecimiento()}}</span>
                                                    @else
                                                    <span class="description-text">SIN INFORMACIÓN</span>
                                                    @endif

                                                </div>
                                                <!-- /.description-block -->
                                            </div>
                                            <!-- /.col -->
                                            <div class="col-sm-4">
                                                <div class="description-block">
                                                    <h5 class="description-header">Correo electrónico</h5>
                                                    @if($profesional!=null)
                                                    <span class="description-text"><span class="description-text">{{$user->email}}</span></span>
                                                    @else
                                                    <span class="description-text">SIN INFORMACIÓN</span>
                                                    @endif

                                                </div>
                                                <!-- /.description-block -->
                                            </div>
                                            <!-- /.col -->
                                        </div>
                                        <!-- /.row -->
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="small-box bg-success">
                                            <div class="inner">
                                                <h4>Formulario de postulación PRAM</h4>
                                                <p>Ingreso de datos del postulante</p>
                                            </div>
                                            <div class="icon">
                                                <i class="ion ion-person-add"></i>
                                            </div>

                                            @if($profesional!=null)
                                            <a href="#" class="small-box-footer" onclick="profesionalIngresado()">Ir al formulario <i class="fas fa-arrow-circle-right"></i></a>
                                            @else
                                            <a href="{{route('profesional.index')}}" class="small-box-footer">Ir al formulario <i class="fas fa-arrow-circle-right"></i></a>
                                            @endif


                                        </div>
                                    </div>
                                    <div class="col-md-12">

                                        <div class="small-box bg-warning">
                                            <div class="inner">
                                                <h4>Formulario edición</h4>
                                                <p>Edicion datos básicos del postulante</p>
                                            </div>
                                            <div class="icon">
                                                <i class="far fa-address-card"></i>
                                            </div>
                                            @if($profesional!=null)
                                            <input type="hidden" name="input_prof" id="input_prof" value="lleno">
                                            <a href="{{route('profesional.edit',['id'=> $profesional->id])}}" class="small-box-footer">Ir al formulario <i class="fas fa-arrow-circle-right"></i></a>
                                            @else
                                            <input type="hidden" name="input_prof" id="input_prof" value="nulo">
                                            <a href="#" class="small-box-footer" onclick="profesionalVacio()">Ir al formulario <i class="fas fa-arrow-circle-right"></i></a>
                                            @endif

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
    </div>
</section>
<script>
    $(document).ready(function() {
        mensaje = @json(session()->get('message'));
        if (mensaje == 'creado') {
            Swal.fire({
                type: 'success',
                title: 'Postulante creado exitosamente!',
                showConfirmButton: false,
                timer: 2500,
                onClose: function() {
                    $('.modal').modal('hide');
                    $(".REV").attr('disabled', false);
                },
            });
        }

        if (mensaje == 'actualizado') {
            Swal.fire({
                type: 'success',
                title: 'Postulante actualizado exitosamente!',
                showConfirmButton: false,
                timer: 2500,
                onClose: function() {
                    $('.modal').modal('hide');
                    $(".REV").attr('disabled', false);
                },
            });
        }
    });

    function profesionalVacio() {
        Swal.fire({
            type: 'warning',
            title: 'Usted aún no ha ingresado un formulario!',
            showConfirmButton: false,
            timer: 2500,
            onClose: function() {
                $('.modal').modal('hide');
                $(".REV").attr('disabled', false);
            },
        });
    }

    function profesionalIngresado() {
        Swal.fire({
            type: 'warning',
            title: 'Usted ya ha ingresado un formulario de postulación!',
            showConfirmButton: false,
            timer: 2500,
            onClose: function() {
                $('.modal').modal('hide');
                $(".REV").attr('disabled', false);
            },
        });
    }
</script>
@endsection