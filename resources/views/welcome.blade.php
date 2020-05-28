@extends('layouts.master')
@section('content')
<!-- iCheck for checkboxes and radio inputs -->


<style>
    .toastr-margin {
        margin-top: 25px;
    }

    .toast-message {
        font-size: 15px !important;
    }

    .toast-warning {
        background-color: #eb990c !important
    }

    #toast-container>div {
        opacity: 1;
        margin-top: 25%;
    }
</style>

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Inicio</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="#">Página 1</a></li>
                    <li class="breadcrumb-item active">Página 2</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 offset-2">
                <!-- Default box -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Ingreso Solicitud Profesional</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                <i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <form action="{{route('enviar.solicitud')}}" method="POST">
                                    @csrf
                                    <div class="col-md-12">
                                        <label for="rut">Rut : <b style="color:red">(*)</b></label>

                                        <div class="form-group input-group" style="margin-bottom:0">
                                            <input type="text" class="form-control" id="rut" name="rut" placeholder="Ej: 11222333-0" value="{{ old('rut') }}">
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-info" name="boton_consultar" title="Buscar Paciente Por RUT" onclick="buscarProfesional()"><i class="fas fa-search"></i></button>
                                            </span>
                                        </div>
                                        <div class="input-group mb-3">
                                            @if ($errors->has('rut'))
                                            <span class="text-danger">{{ $errors->first('rut') }}</span>
                                            @endif
                                        </div>

                                    </div>
                                    <div class="col-md-12">
                                        <label for="nombre">Nombre : <b style="color:red">(*)</b></label>
                                        <input type="text" class="form-control" name="nombre" id="nombre" value="{{ old('nombre') }}">
                                        <div class="input-group mb-3">
                                            @if ($errors->has('nombre'))
                                            <span class="text-danger">{{ $errors->first('nombre') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="aPaterno">Apellido Materno : <b style="color:red">(*)</b></label>
                                        <input type="text" class="form-control" name="aPaterno" id="aPaterno" value="{{ old('aPaterno') }}">
                                        <div class="input-group mb-3">
                                            @if ($errors->has('aPaterno'))
                                            <span class="text-danger">{{ $errors->first('aPaterno') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="aMaterno">Apellido Materno : <b style="color:red">(*)</b></label>
                                        <input type="text" class="form-control" name="aMaterno" id="aMaterno" value="{{ old('aMaterno') }}">
                                        <div class="input-group mb-3">
                                            @if ($errors->has('aMaterno'))
                                            <span class="text-danger">{{ $errors->first('aMaterno') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="telefono">Teléfono de contacto : <b style="color:red">(*)</b></label>
                                        <input type="text" class="form-control" name="telefono" id="telefono" value="{{ old('telefono') }}">
                                        <div class="input-group mb-3">
                                            @if ($errors->has('telefono'))
                                            <span class="text-danger">{{ $errors->first('telefono') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="correo">Correo Electrónico : <b style="color:red">(*)</b></label>
                                        <input type="text" class="form-control" name="correo" id="correo" value="{{ old('correo') }}">
                                        <div class="input-group mb-3">
                                            @if ($errors->has('correo'))
                                            <span class="text-danger">{{ $errors->first('correo') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="pais">País : <b style="color:red">(*)</b></label>
                                        <input type="text" class="form-control" name="pais" id="pais" value="{{ old('pais') }}">
                                        <div class="input-group mb-3">
                                            @if ($errors->has('pais'))
                                            <span class="text-danger">{{ $errors->first('pais') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="direccion">Dirección : <b style="color:red">(*)</b></label>
                                        <input type="text" class="form-control" name="direccion" id="direccion" value="{{ old('direccion') }}">
                                        <div class="input-group mb-3">
                                            @if ($errors->has('direccion'))
                                            <span class="text-danger">{{ $errors->first('direccion') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <label for="radio">Tipo Profesional : <b style="color:red">(*)</b></label>
                                        <div class="form-group clearfix">
                                            <div class="icheck-primary">
                                                <input type="radio" name="tipoProfesional" value="medico" id="medico" @if(old('tipoProfesional')=="medico" ) checked @endif>
                                                <label class="form-check-label" for="medico">Médico</label>
                                            </div>
                                            <div class="icheck-primary">
                                                <input type="radio" name="tipoProfesional" value="enfermero" id="enfermero" @if(old('tipoProfesional')=="enfermero" ) checked @endif>
                                                <label class="form-check-label" for="enfermero">Enfermero/a</label>
                                            </div>
                                            <div class="icheck-primary">
                                                <input type="radio" name="tipoProfesional" value="kinesiologo" id="kinesiologo" @if(old('tipoProfesional')=="kinesiologo" ) checked @endif>
                                                <label class="form-check-label" for="kinesiologo">Kinesiologo</label>
                                            </div>
                                            <div class="icheck-primary">
                                                <input type="radio" name="tipoProfesional" value="tecnico" id="tecnico" @if(old('tipoProfesional')=="tecnico" ) checked @endif>
                                                <label class="form-check-label" for="tecnico">Técnico de enfermería de nivel superior</label>
                                            </div>
                                            <div class="icheck-primary">
                                                <input type="radio" name="tipoProfesional" value="paramedico" id="paramedico" @if(old('tipoProfesional')=="paramedico" ) checked @endif>
                                                <label class="form-check-label" for="paramedico">Paramédico</label>
                                            </div>
                                        </div>
                                        <div class="input-group mb-3">
                                            @if ($errors->has('tipoProfesional'))
                                            <span class="text-danger">{{ $errors->first('tipoProfesional') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <label for="especialidad">Especialidad si la opción es médico : <b style="color:red">(*)</b></label>
                                        <input type="text" class="form-control" name="especialidad" id="especialidad">
                                        <div class="input-group mb-3">
                                            @if ($errors->has('especialidad'))
                                            <span class="text-danger">{{ $errors->first('especialidad') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <hr>
                                        <h1>parte de las fechas y horas</h1>
                                        <hr>
                                    </div>

                                    <div class="col-md-12">
                                        <label for="observaciones">Observaciones</label>
                                        <textarea class="form-control" name="observaciones" id="observaciones" rows="5" placeholder="Observaciones"></textarea>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="float-right">
                                            <button type="submit" class="btn btn-success mt-3">Enviar</button>
                                        </div>
                                    </div>
                                </form>


                            </div>
                            <div class="col-md-6">
                                <div class="callout callout-info mt-4">
                                    <h2>Atención!</h2>

                                    <b>Para buscar tu información en la base de datos pulsa el botón buscar : </b>
                                    <button type="button" class="btn btn-info"><i class="fas fa-search"></i></button>
                                </div>
                             
                            </div>

                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">

                    </div>
                    <!-- /.card-footer-->
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div>
</section>
<script>
    function buscarProfesional(value) {
        rut = document.getElementById('rut').value;
        console.log(document.getElementById('rut').value);
        $.ajax({
            type: "GET",
            url: '/obtenerProfesional/' + rut,
            success: function(data) {
                if (data != 'vacio') {
                    document.getElementById('nombre').value = data['nombre'];
                    document.getElementById('aPaterno').value = data['apellido_paterno'];
                    document.getElementById('aMaterno').value = data['apellido_materno'];
                    document.getElementById('direccion').value = data['direccion'];
                    document.getElementById('telefono').value = data['telefono'];
                    document.getElementById('pais').value = data['pais'];
                    document.getElementById('correo').value = data['email'];
                    if (data['tipo_profesional'] == 'medico') {
                        document.getElementById('medico').checked = true;
                        document.getElementById('especialidad').value = data['especialidad'];
                    }
                    if (data['tipo_profesional'] == 'enfermero') {
                        document.getElementById('enfermero').checked = true;
                    }
                    if (data['tipo_profesional'] == 'kinesiologo') {
                        document.getElementById('kinesiologo').checked = true;
                    }
                    if (data['tipo_profesional'] == 'tecnico') {
                        document.getElementById('tecnico').checked = true;
                    }
                    if (data['tipo_profesional'] == 'paramedico') {
                        document.getElementById('paramedico').checked = true;
                    }
                } else {
                    document.getElementById('nombre').value = '';
                    document.getElementById('aPaterno').value = '';
                    document.getElementById('aMaterno').value = '';
                    document.getElementById('direccion').value = '';
                    document.getElementById('telefono').value = '';
                    document.getElementById('pais').value = '';
                    document.getElementById('correo').value = '';
                    document.getElementById('especialidad').value = '';
                    toastr.warning('No se encuentra información asociada a el rut ingresado !');
                    
                }


            }
        });
    }
</script>
@endsection