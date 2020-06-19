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

<div id="modalVerSolicitud" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Solicitud de profesional: <span></span></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <form action="">
                    @csrf
                    <input type="hidden"  id="capacitaciones" value="{{$capacitaciones}}">
                    <input type="hidden"  id="servicios" value="{{$servicios}}">
                    {{-- establecimiento origen --}}
                    <div class="col-md-12 form-group">
                            <label for="establecimiento_id">Establecimiento solicitante</label>
                            <input type="text" class="form-control" value="{{old('establecimiento_id')??Auth::user()->getEstablecimiento()->tx_descripcion}}" readonly style="background-color: white">
                    </div>

                    {{-- servicio clinico --}}
                    <div class="col-md-12 form-group">
                            <label for="servicio_clinico">Servicio clinico donde se desempeñara el profesional:</label>
                        <input type="text" class="form-control" value="{{$solicitud->getServicio()->tx_descripcion}}" readonly style="background-color: white">
                    </div>

                    {{-- tipo profesional --}}
                    {{-- especialidad --}}
                    <div class="col-md-12 form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="profesion">Tipo profesional solicitado:</label>
                                <input type="text" class="form-control" value="{{$solicitud->getTitulo()->tx_descripcion}}" readonly style="background-color: white">
                            </div>
                            <div class="col-md-6" id="div_especialidad" style="display: block;">
                                <label for="especialidad">Especialidad del profesional solicitado:</label>
                                <input type="text" class="form-control" value="{{$solicitud->getEspecialidad()->tx_descripcion??$solicitud->getEspecialidad()}}" readonly style="background-color: white">
                            </div>
                        </div>
                    </div>

                    {{-- postgrado --}}
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="postgrado">PosGrado del profecional solicitado: </label>
                                <input type="text" class="form-control" value="{{$solicitud->getPosgrado()->tx_descripcion??$solicitud->getPosgrado()}}" readonly style="background-color: white">
                            </div>
                            <div class="col-md-6">
                                <label for="cantidad">Cantidad de profesionales solicitados:</label>
                                <input type="text" class="form-control" value="{{$solicitud->cantidad}}" readonly style="background-color: white">
                            </div>
                        </div>
                    </div>

                    {{-- capacitaciones --}}
                    <div class="col-md-12 form-group" id="div_capacitaciones">
                        <label for="capacitaciones">Capacitaciones requeridas :</label>
                        <div class="select2-purple">
                            <select class="form-control select2 capacitaciones" name="capacitaciones[]" id="capacitaciones" multiple="multiple" value="">
                                @foreach($capacitacionesTodas as $key => $capacitacion)
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
                                        <select class="form-control select2 experiencia_servicio" name="experiencia_servicio[]" id="experiencia_servicio" multiple="multiple" value=""  style="background-color: white">
                                            @foreach($servicioClinico as $key => $servicio)
                                            <option value="{{$servicio->id}}">{{$servicio->tx_descripcion}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                            </div>
                            <div class="col-md-2">
                                <label for="aniosExperiencia">Años:</label>
                                <input type="text" class="form-control" value="{{$solicitud->anios}}" readonly style="background-color: white">
                            </div>
                    </div>

                    {{-- fechas --}}
                    <div class="col-md-12 form-group">
                        <div class="row">
                            <div class="col">
                                <label for="jornada">Diurno/Turno:</label>
                                <input type="text" class="form-control" value="{{$solicitud->getJornada()->tx_descripcion}}" readonly style="background-color: white">
                            </div>
                            <div class="col">
                                <label for="horas">Horas:</label>
                                <input type="text" class="form-control" value="{{$solicitud->horas}}" readonly style="background-color: white">
                            </div>

                            <div class="col">
                                <label for="fechaInicio">Fecha inicio</label>
                                <input type="text" class="form-control" value="{{$solicitud->fecha_inicio}}" readonly style="background-color: white">

                            </div>
                            <div class="col">
                                <label for="fechaTermino">Fecha Termino</label>
                                <input type="text" class="form-control" value="{{$solicitud->fecha_termino}}" readonly style="background-color: white">

                            </div>
                            <div class="col">
                                <label for="dias">Dias de servicio</label>
                                <input type="text" class="form-control" value="{{$solicitud->dias}}" readonly style="background-color: white">
                            </div>
                        </div>
                    </div>

                    {{-- OBSERVACIONES--}}
                    <div>
                        <label for="observaciones">Observaciones:</label>
                        <input type="text" class="form-control" value="{{$solicitud->observacio}}" readonly style="background-color: white">
                    </div>

                </form>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer botones">
                <div>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                </div>
            </div>

        </div>
    </div>
</div>
<script>



$(document).ready(function() {

    //quito el bloqueo del boton en la vista del callcenter
    $(".verSolicitud").attr('disabled', false);
    var capacitaciones=$("#capacitaciones").val().replace("[", "").replace("]", "").split(",");
    var servicios=$("#servicios").val().replace("[", "").replace("]", "").split(",");
// console.log(capacitaciones);
// console.log(servicios);

    // llenado select2
    $(".experiencia_servicio").select2({
            language: "es",
            tags: true,
        })
     $(".experiencia_servicio").val(servicios).trigger('change');
     $(".experiencia_servicio").prop("disabled", true);

     $(".capacitaciones").select2({
            language: "es",
            tags: true,
        })
     $(".capacitaciones").val(capacitaciones).trigger('change');
     $(".capacitaciones").prop("disabled", true);

     $(".select2-selection.select2-selection--multiple").css("background-color", "white");

});
</script>
