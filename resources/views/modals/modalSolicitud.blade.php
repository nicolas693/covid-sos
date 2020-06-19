<!-- Select2 -->
<link rel="stylesheet" href="{{asset('/plugins/select2/css/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>

<!-- DatePicker -->
<link rel="stylesheet" href="{{asset('plugins/datePicker/css/bootstrap-datepicker3.css')}}">
<link rel="stylesheet" href="{{asset('plugins/datePicker/css/bootstrap-datepicker3.standalone.css')}}">
<script src="{{asset('plugins/datePicker/js/bootstrap-datepicker.js')}}"></script>
<script src="{{asset('plugins/datePicker/locales/bootstrap-datepicker.es.min.js')}}"></script>

<!-- Libreria español -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/i18n/es.js"></script>

<script>
    $.fn.select2.defaults.set('language', 'es');
</script>

<style>
    .error {
        border: 1px dashed #f00;
    }

    input:-moz-read-only { /* For Firefox */
    background-color: white;
    }

    input:read-only {
    background-color: white;
    }

</style>

<div id="modalSolicitud" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Solicitud de profesional: <span></span></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
{{--
            $alumno = new Alumno($request->input());
            $alumno->save(); --}}

            <!-- Modal body -->
            <div class="modal-body">
                <form action="{{route('reclutador.crearSolicitud')}}" method="POST" id="formulario_reclutador">
                    @csrf
                    <input type="hidden" name="reclutador_id" id="reclutador_id" value="{{old('reclutador_id') ?? Auth::user()->id}}">
                    <input type="hidden" name="establecimiento_id" id="establecimiento_id" value="{{old('establecimiento_id') ?? Auth::user()->getEstablecimiento()->establecimiento_id}}">


                    {{-- establecimiento origen --}}
                    <div class="col-md-12 form-group">
                            <label for="establecimiento_id">Establecimiento solicitante</label>
                            <input type="text" class="form-control" value="{{old('establecimiento_id')??Auth::user()->getEstablecimiento()->tx_descripcion}}" readonly style="background-color: white">
                    </div>

                    {{-- servicio clinico --}}
                    <div class="col-md-12 form-group">
                            <label for="servicio_clinico">Servicio clinico donde se desempeñara el profesional:</label>
                            <select class="form-control select2 servicio_clinico" name="servicio_clinico_id" id="servicio_clinico" value="{{ old('servicio_clinico') }}">
                                @foreach($servicioClinico as $key => $servicio)
                                <option value="{{$servicio->id}}">{{$servicio->tx_descripcion}}</option>
                                @endforeach
                            </select>
                    </div>

                    {{-- tipo profesional --}}
                    {{-- especialidad --}}
                    <div class="col-md-12 form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="profesion">Tipo profesional solicitado:</label>
                                <select name="tipo_profesional_id" id="profesion" class="form-control profesionalRequerido">
                                    @foreach ($titulos as $key => $titulo_id)
                                        <option value="{{$titulo_id}}">{{$key}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6" id="div_especialidad" style="display: block;">
                                <label for="especialidad">Especialidad del profesional solicitado:</label>
                                <select name="especialidad_id" id="especialidad" class="form-control especialidadRequerida" value="{{ old('especialidad') }}">
                                    <option value="">NO APLICA</option>
                                    @foreach ($especialidades as $key => $especialidad)
                                    <option value="{{$especialidad->id}}">{{$especialidad->tx_descripcion}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- postgrado --}}
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="postgrado">PosGrado del profecional solicitado: </label>
                                <select class="form-control posgrado" name="postgrado_id" id="postgrado" value="">
                                    <option value="">NO APLICA</option>
                                    @foreach($postgrado as $posgrado)
                                        @if(old('postgrado')==$posgrado->id)
                                            <option value="{{$posgrado->id}}" selected>{{$posgrado->tx_descripcion}}</option>
                                        @else
                                            <option value="{{$posgrado->id}}">{{$posgrado->tx_descripcion}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="cantidad">Cantidad de profesionales solicitados:</label>
                                <input type="number" min=1 class="form-control" name="cantidad" value="{{ old('canntidad')??1 }}">
                            </div>
                        </div>
                    </div>

                    {{-- capacitaciones --}}
                    <div class="col-md-12 form-group" id="div_capacitaciones">
                        <label for="capacitaciones">Capacitaciones requeridas :</label>
                        <div class="select2-purple">
                            <select class="form-control select2 capacitaciones" name="capacitaciones[]" id="capacitaciones" multiple="multiple" value="">
                                @foreach($capacitaciones as $key => $capacitacion)

                                <option value="{{$capacitacion->id}}">{{$capacitacion->tx_descripcion}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- experiencia requerida --}}
                    {{-- anios --}}
                    <div class="col-md-12 form-group row" style="margin-left:0px;margin-right:0px;padding:0px">
                            <div class="col-md-10" id="" >
                                    <label for="experiencia_servicio">Experiencia en servicio clinico requerida:</label>
                                    <div class="select2-purple">
                                        <select class="form-control select2 experiencia_servicio" name="experiencia_servicio[]" id="experiencia_servicio" multiple="multiple" value="">
                                            @foreach($servicioClinico as $key => $servicio)
                                            <option value="{{$servicio->id}}">{{$servicio->tx_descripcion}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                            </div>
                            <div class="col-md-2">
                                <label for="aniosExperiencia">Años:</label>
                                <input type="number" min=0 max=10 class="form-control" name="anios" id="anios" value="{{ old('anios') }}">
                            </div>
                    </div>

                    {{-- fechas --}}
                    <div class="col-md-12 form-group">
                        <div class="row">
                            <div class="col">
                                <label for="jornada">Diurno/Turno:</label>
                                <select class="form-control select2 jornada" name="jornada" id="">
                                    <option value="1">Diurno</option>
                                    <option value="2">Turno</option>
                                </select>
                            </div>
                            <div class="col">
                                <label for="horas">Horas:</label>
                                <input type="number" min=1 max=24 name="horas" class="form-control">
                            </div>

                            <div class="col">
                                <label for="fechaInicio">Fecha inicio</label>
                                <input type="text" class="form-control datepickerInicio" id="inicio" name="inicio"  readonly style="background-color: white">

                            </div>
                            <div class="col">
                                <label for="fechaTermino">Fecha Termino</label>
                                <input type="text" class="form-control datepickerTermino" id="termino" name="termino"  readonly style="background-color: white" >
                                {{-- <span class="text-danger ml-1" style="font-size: 11px" >Debe ser mayor a inicio</span> --}}
                            </div>
                            <div class="col">
                                <label for="dias">Dias de servicio</label>
                                <input type="text" class="form-control" id="dias" readonly style="background-color: white" >
                                <input type="hidden" name="dias" id="dias_input">
                            </div>
                        </div>
                    </div>

                    {{-- OBSERVACIONES--}}
                    <div class="col-md-12 form-group">
                        <label for="observaciones">Observaciones:</label>
                        <input type="text" class="form-control" name="observaciones" id="observaciones">
                    </div>
                </form>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer botones">
                <div>
                    <button type="button" class="btn btn-primary" id="btn_enviar">Guardar</button>
                    <span class="text-danger" id="error_establecimiento" style="display: none">Este profesional ya se encuantra asignado a otro $miento</span>
                </div>
            </div>

        </div>
    </div>
</div>



<script>
var inicio=null;
var termino=null;
    $(document).ready(function() {

        $(".crearSolicitud").attr('disabled', false);
        var error = 0;

        $("input#anios").keypress(function(event) {
            return /\d/.test(String.fromCharCode(event.keyCode));
        });

        //  configurar los select2
        $(".servicio_clinico").select2({
        });

        $(".capacitaciones").select2({
            tags: true,
        })
        $(".experiencia_servicio").select2({
            language: "es",
            tags: true,
            maximumSelectionLength: 3,
        })
        $('.profesionalRequerido').select2();
        $('.especialidadRequerida').select2();
        $('.jornada').select2();

        // datapickers
        $('.datepickerInicio').datepicker({
            startDate: new Date(),
            autoclose: true,
            format: 'yyyy/mm/dd',
        })
        .on('changeDate', function(selected){
            startDate = new Date(selected.date.valueOf());
            startDate.setDate(startDate.getDate(new Date(selected.date.valueOf())));
            inicio=startDate;
            console.log(startDate);
            $('.datepickerTermino').datepicker('setStartDate', startDate);
        });

        $('.datepickerTermino').datepicker({
            autoclose: true,
            format: 'yyyy/mm/dd',
        }) .on('changeDate', function(selected){
            startDate = new Date(selected.date.valueOf());
            startDate.setDate(startDate.getDate(new Date(selected.date.valueOf())));

            termino=startDate;
            var diffMS = inicio-termino;
            $('#dias').val((  (Math.ceil((termino - inicio) / 86400000)+1)+ " dias" ));
            $('#dias_input').val((  (Math.ceil((termino - inicio) / 86400000)+1)));
        });

        $(".profesionalRequerido").on('change', function(e) {
            value = e.currentTarget.value;
            if (value == '32' || value == '1') {
                $('.especialidadRequerida').val("4");
                $('#div_especialidad').fadeIn();
            } else {
                $('#div_especialidad').fadeOut();
                $('.especialidadRequerida').val("");
            }
        });

        // enviar formulario
        $("#btn_enviar").click(function(e) {
            error=0;
             console.log($("#anios").val());
            // VALIDACIONES
            $("input").removeClass('error');
            if($(".datepickerInicio").val()==''){
                error++;$('#inicio').addClass('error');
            }
            if($(".datepickerTermino").val()==''){
                error++;$('#termino').addClass('error');
            }
            if($("input[name='horas']").val()==''){
                error++;$("input[name='horas']").addClass('error');
            }

            if($("#anios").val()!=''){
                if( $(".experiencia_servicio").val().length==0){
                    error++;$("#anios").addClass('error');
                }
            }

            if( $(".experiencia_servicio").val().length!=0){
                if($("#anios").val()==''){
                    error++;$("#anios").addClass('error');
                }
            }


            // ENVIADO DE FORMULARIO
            if (error != 0) {
                console.log('hay errores en el fomulario');
                return false;
            } else {
                console.log('no  errores en el fomulario');
                $("#formulario_reclutador").submit();
            }

            // $(this).find('.servicioClinico').addClass('error');

            // $("#formulario_reclutador").submit();
            // $('#observaciones_input').val($('#observaciones').val());
            // $('.fila_completa .form-control ').removeClass('error');
            // experiencias = [];

            // var error = 0;
            // // e.preventDefault();
            // $('.fila_completa').each(function(index, element) {


            //     if ($(this).find('.servicioClinico').val() == "") {
            //         error++, $(this).find('.servicioClinico').addClass('error');
            //     }
            //     if ($(this).find('.lugarTrabajo').val() == "") {
            //         error++, $(this).find('.lugarTrabajo').addClass('error');
            //     }


            //     if ($(this).find('.tiempoPeriodo').val() == "") {
            //         error++, $(this).find('.tiempoPeriodo').addClass('error');
            //     }

            //     var fila = {
            //         tiempoTipo: $(this).find('.tiempoTipo').val(),

            //         // if(tiempoTipo==""){error++}
            //         tiempoPeriodo: $(this).find('.tiempoPeriodo').val(),
            //         // if(tiempoPeriodo==""){error++}
            //         servicioClinico: $(this).find('.servicioClinico').val(),

            //         // if(servicioClinico==""){error++,$(this).find('.servicioClinico').addClass('error')}
            //         lugarTrabajo: $(this).find('.lugarTrabajo').val(),
            //         // if(lugarTrabajo==""){error++}

            //     };

            //     experiencias.push(fila);
            //     // console.log("fila "+JSON.stringify(fila));

            //     // data = Object.keys(fila).map(function (key) { return fila[key] })
            //     // console.log(experiencias.find(esVacio))
            // });

            // if (error != 0) {
            //     console.log('hay errores en el fomulario');
            //     return false;
            // } else {
            //     //  console.log("fila "+JSON.stringify(experiencias));
            //     $('#experiencias_input').val(JSON.stringify(experiencias));
            //     console.log("experienncias " + $('#experiencias_input').val());
            //     experiencias = [];
            //      $(".formulario_complementar").submit();
            // }

        });

    $('.select2-selection--single').css('height', 'calc(2.25rem + 2px)');
    });

</script>
