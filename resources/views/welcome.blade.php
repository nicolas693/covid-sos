@extends('layouts.master-top')
@section('content')



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
                        <div >
                            <div class="col-md-12">
                                <form action="{{route('enviar.solicitud')}}" method="POST" class="formulario_profesional">
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

                                        <select class="form-control select2" name="pais" id="pais" value="{{ old('pais') }}">
                                        </select>


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
                                        <label for="profesion">Tipo Profesional : <b style="color:red">(*)</b></label>
                                        <select name="profesion" id="profesion" class="form-control select2">

                                        </select>
                                        <div class="input-group mb-3">
                                            @if ($errors->has('tipoProfesional'))
                                            <span class="text-danger">{{ $errors->first('tipoProfesional') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <label for="especialidad">Especialidad si la opción es médico : <b style="color:red">(*)</b></label>
                                        <!-- <input type="text" class="form-control" name="especialidad" id="especialidad" value="{{ old('direccion') }}"> -->
                                        <select name="especialidad" id="especialidad" class="form-control select2">
                                            <option value="">Seleccione especialidad</option>
                                            <option value="uno ">Uno</option>
                                            <option value="dos">Dos</option>
                                            <option value="tres">Tres</option>

                                        </select>
                                        <div class="input-group mb-3">
                                            @if ($errors->has('especialidad'))
                                            <span class="text-danger">{{ $errors->first('especialidad') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <label for="fechas">Ingrese su disponibilidad : <b style="color:red">(*)</b></label>
                                        <div class="row">
                                            <label class="col" style="font-weight:normal !important;">Dia: </label>
                                            <label class="col" style="font-weight:normal !important;">Inicio: </label>
                                            <label class="col" style="font-weight:normal !important;">Termino: </label>
                                            <div class="col"></div>
                                        </div>

                                        <div class="fechas">
                                            <div id="divRow0" class="clonerow">
                                            <div class="row fila_completa" id="innerDivRow0">

                                                <div class="col">
                                                    {{-- <label for="example-time-input" class="col-form-label" >Dia: </label> --}}
                                                    <select class="form-control fila_select">
                                                    <option value="lunes">Lunes</option>
                                                    <option value="martes">Martes</option>
                                                    <option value="miercoles">Miercoles</option>
                                                    <option value="jueves">Jueves</option>
                                                    <option value="viernes" >Viernes</option>
                                                    <option value="sabado">Sabado</option>
                                                    <option value="domingo">Domingo</option>
                                                    </select>
                                                </div>
                                                <div class="col">
                                                    {{-- <label for="example-time-input" >Inicio: </label> --}}
                                                    {{-- style="margin-left:5px;margin-right:5px" --}}
                                                    <input class="form-control fila_inicio"   type="time" value="08:00"  placeholder="Hora Inicio" >
                                                </div>
                                                <div class="col">
                                                    {{-- <label for="example-time-input" >Termino: </label> --}}
                                                    <input class="form-control fila_termino"  type="time" value="16:00"  >
                                                </div>
                                                <div class="col">
                                                    <div class="form-group boton_add">
                                                        <span style="font-size: 20px; color: Dodgerblue;">
                                                            <i class="fas fa-plus-circle add_fecha"></i>
                                                        </span>
                                                    </div>
                                                    <div class="form-group boton_remove">
                                                        <span style="font-size: 20px; color: rgb(255, 30, 30);">
                                                            <i class="fas fa-minus-circle remove_fecha text-danger"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <label for="observaciones">Observaciones</label>
                                        <textarea class="form-control" name="observaciones" id="observaciones" rows="5" placeholder="Observaciones"></textarea>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="float-right">
                                            <button type="submit" class="btn btn-success mt-3 btn_enviar">Enviar</button>
                                        </div>
                                    </div>

                                    <div><input type="hidden" name="fechas" id="fechas_input" value=""></div>
                                    <div><input type="hidden" name="tipoProfesional" value="medico"></div>
                                    <div><input type="hidden" name="pais" value="chile"></div>
                                </form>


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
    $("#pais").select2({
        placeholder: "Seleccione nacionalidad",
        allowClear: true,
        minimumInputLength: 3,
        formatInputTooShort: function() {
            return "Ingrese 3 o más caracteres para la búsqueda";
        },
        ajax: {
            url: "{{ route('live_search.nacionalidades') }}",
            data: function(params) {
                var query = {
                    name: params.term,
                }
                return query;
            },
            processResults: function(data) {
                return {
                    results: data
                };
            }
        }
    });

    $("#profesion").select2({
        placeholder: "Seleccione nacionalidad",
        allowClear: true,
        minimumInputLength: 3,
        formatInputTooShort: function() {
            return "Ingrese 3 o más caracteres para la búsqueda";
        },
        ajax: {
            url: "{{ route('live_search.nacionalidades') }}",
            data: function(params) {
                var query = {
                    name: params.term,
                }
                return query;
            },
            processResults: function(data) {
                return {
                    results: data
                };
            }
        }
    });

    function buscarProfesional(value) {


        rut = document.getElementById('rut').value;
        ruta = @json(route('obtener.profesional', ['rut' => 'rut']));
        ruta = ruta.replace('rut', rut);
        $.ajax({
            type: "GET",
            url: ruta,
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
    $('.select2-selection--single').css('height', 'calc(2.25rem + 2px)');
</script>
<script>
    $(document).ready(function() {
        var max_fields      = 10; //maximum input boxes allowed
        var wrapper   		= $(".fechas"); //Fields wrapper
        var add_button      = $(".add_fecha"); //Add button ID
        var remove_button      = $(".remove_fecha"); //Add button ID

        var fechas_formulario=[];
        var x = 1; //initlal text box count
        // var div_nuevo=$("#clonar").clone();
        var div_nuevo=$("#nuevo");
        // console.log(x);

        $(".boton_remove").hide();


        original = $('#divRow0');
        $(add_button).click(function(e){ //on add input button click
            clone = $(original).clone(true, true);
            clone.find('.boton_add').remove();
            clone.find('.boton_remove').show();
            // console.log($('.boton_add'));
            // console.log($('.clonerow').length);
            clone.find('#divRow0').prop('id', 'divRow' + $('.clonerow').length);
            clone.find('#innerDivRow0').prop('id', 'innerDivRow' + $('.clonerow').length);
            // e.preventDefault();



                // $algo="<div id=user'"+x+"'>hola</div>";
                // console.log(div_nuevo);
                $(wrapper).append(clone); //add input box
                // x = $('.fechas > div').length
            // console.log(x);
                // $(wrapper).append('<div><input type="text" name="mytext[]"/><a href="#" class="remove_field">Remove</a></div>'); //add input box
        });



        $(remove_button).click(function(e){
            // console.log(Array.from($('.fila_select, .fila_inicio').get(), e => e.value));
            // console.log($('.fila_completa').length);
            // console.log($(this).parentsUntil('.clonerow'));
            $(this).parentsUntil('.fechas').remove();


        })

        $(".formulario_profesional").submit(function(e)
        {
            // e.preventDefault();

           $( '.fila_completa' ).each( function( index, element ){
            //  console.log( $( this ).find('.fila_select').val() );
            //  console.log( $( this ).find('.fila_inicio').val() );
            //  console.log( $( this ).find('.fila_termino').val() );
                var fila={
                    dia: $( this ).find('.fila_select').val(),
                    hora_inicio:$( this ).find('.fila_inicio').val(),
                    hora_termino:$( this ).find('.fila_termino').val()
                }
                fechas_formulario.push(fila);
            });
            console.log(fechas_formulario);
            $('#fechas_input').val(JSON.stringify(fechas_formulario));

            // $("#formulario_profesional").submit();
             return true;
        });

    });

</script>
@endsection
