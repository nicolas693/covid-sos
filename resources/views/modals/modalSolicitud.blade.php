<!-- Select2 -->
<link rel="stylesheet" href="{{asset('/plugins/select2/css/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>

<style>
    /* .botones {
        display: flex;
        justify-content: space-between;
    } */
    .borde {
        padding: 15px;
    }

    .bordeLight {
        font-weight: normal;
    }

    .error {
        border: 1px dashed #f00;
    }

    /* .fas {
        padding-left: 5px;
    } */

    .btn_colapse a{
    text-align: center;
	float: left;
	width: 20px;
	height: 20px;
	border: 1px solid #909090;
	border-radius: 100%;
	margin-right: 7px; /*space between*/
    text-decoration:none;
    font-size: 13px;
    color: #909090;

    }
    .btn_colapse a:hover {
        color: #909090;
    }

input:-moz-read-only { /* For Firefox */
  background-color: white;
}

input:read-only {
  background-color: white;
}

</style>

<div id="modalSolicitud" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Complementar datos de: <span></span></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
{{--
            $alumno = new Alumno($request->input());
            $alumno->save(); --}}

            <!-- Modal body -->
            <div class="modal-body">
                <form action="{{route('reclutador.store')}}" method="post" id="solicitud_add">
                    @csrf
                    <input type="hidden" name="reclutador_id" id="reclutador_id" value="{{old('reclutador_id') ?? $user->id}}">

                    {{-- DATOS DEL ESTABLECIMIENTO --}}

                    {{-- establecimiento origen --}}
                    <div class="col-md-12">
                            <label for="establecimiento_id">Establecimiento solicitante</label>
                            <input type="text" class="form-control" name="establecimiento_id" value="{{old('establecimiento_id')??Auth::user()->getEstablecimiento()->tx_descripcion}}" readonly style="background-color: white">
                    </div>
                    {{-- servicio clinico --}}
                    <div class="col-md-12">

                            <label for="servicio_clinico">Servicio clinico: <b style="color:red">(*)</b></label>
                            <select class="form-control select2 servicio_clinico" name="servicio_clinico" id="servicio_clinico" value="{{ old('servicio_clinico') }}">
                            </select>
                            <input type="hidden" name="cod_servicio_clinico" id="cod_servicio_clinico" value="{{ old('cod_servicio_clinico') }}">
                            <input type="hidden" name="tx_servicio_clinico" id="tx_servicio_clinico" value="{{ old('tx_servicio_clinico') }}">
                            <div class="input-group mb-3">
                                @if ($errors->has('servicio_clinico'))
                                <span class="text-danger ml-1">{{ $errors->first('servicio_clinico') }}</span>
                                @endif
                            </div>

                    </div>

                    {{-- DATOS DEL PROFESIONAL --}}

                    {{-- tipo profesional --}}
                    <div class="col-md-12">
                        <label for="profesion">Tipo profesional : <b style="color:red">(*)</b></label>
                        <select name="profesion" id="profesion" class="form-control profesionalRequerido">
                            @foreach ($titulos as $key => $titulo_id)
                                <option value="{{$titulo_id}}">{{$key}}</option>
                            @endforeach
                        </select>
                        <input type="hidden" name="cod_tp" id="cod_tp" value="{{ old('cod_tp') }}">
                        <input type="hidden" name="tx_tp" id="tx_tp" value="{{ old('tx_tp') }}">
                        <div class="input-group mb-3">
                            @if ($errors->has('profesion'))
                            <span class="text-danger ml-1">{{ $errors->first('profesion') }}</span>
                            @endif
                        </div>
                    </div>
                    {{-- especialidad --}}
                    <div class="col-md-12" id="div_especialidad" style="display: none;">
                        <label for="especialidad">Especialidad : <b style="color:red">(*)</b></label>
                        <select name="especialidad" id="especialidad" class="form-control select2 multiple" value="{{ old('especialidad') }}">
                        </select>
                        <input type="hidden" name="cod_es" id="cod_es" value="{{ old('cod_es') }}">
                        <input type="hidden" name="tx_es" id="tx_es" value="{{ old('tx_es') }}">
                        <div class="input-group mb-3">
                            @if ($errors->has('especialidad'))
                            <span class="text-danger ml-1">{{ $errors->first('especialidad') }}</span>
                            @endif
                        </div>
                    </div>
                    {{-- postgrado --}}
                    <div class="col-md-6">
                        <label for="postgrado">PosGrado : <b style="color:red"></b></label>
                        <select class="form-control posgrado" name="postgrado" id="postgrado" value="">
                            @foreach($postgrado as $posgrado)
                                @if(old('postgrado')==$posgrado->id)
                                    <option value="{{$posgrado->id}}" selected>{{$posgrado->tx_descripcion}}</option>
                                @else
                                    <option value="{{$posgrado->id}}">{{$posgrado->tx_descripcion}}</option>
                                @endif
                            @endforeach
                        </select>
                        <div class="input-group mb-3">
                            @if ($errors->has('postgrado'))
                            <span class="text-danger ml-1">{{ $errors->first('postgrado') }}</span>
                            @endif
                        </div>
                    </div>
                    {{-- capacitaciones --}}
                    <div class="col-md-12" id="div_capacitaciones">
                        <label for="capacitaciones">Capacitaciones requeridas : <b style="color:red">(*)</b></label>
                        <div class="select2-purple">
                            <select class="form-control select2 capacitaciones" name="capacitaciones[]" id="capacitaciones" multiple="multiple" value="">
                                {{-- @foreach($comunas as $key => $comuna)
                                <option value="{{$key}}">{{$comuna}}</option>
                                @endforeach --}}
                                <option value="1">1</option>
                                <option value="2">2</option>
                            </select>
                        </div>
                        <input type="hidden" name="cod_capacitaciones" id="cod_capacitaciones" value="{{old('cod_capacitaciones')}}">
                        <div class="input-group mb-3">
                            @if ($errors->has('capacitaciones'))
                            <span class="text-danger ml-1">{{ $errors->first('capacitaciones') }}</span>
                            @endif
                        </div>
                    </div>
                    {{-- experiencia requerida --}}
                    <div class="col-md-12 row" style="margin:0px">
                            <div class="col-md-8" id="" style="margin:0px;padding:0px">
                                    <label for="experiecia_servicio">Experiencia en servicio clinico requerida: <b style="color:red">(*)</b></label>
                                    <div class="select2-purple">
                                        <select class="form-control select2 experiencia_servicio" name="experiecia_servicio[]" id="experiecia_servicio" multiple="multiple" value="">
                                            @foreach($servicioClinico as $key => $servicio)
                                            <option value="{{$servicio->id}}">{{$servicio->tx_descripcion}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <input type="hidden" name="cod_experiecia_servicio" id="cod_experiecia_servicio" value="{{old('cod_experiecia_servicio')}}">
                                    <div class="input-group mb-3">
                                        @if ($errors->has('experiecia_servicio'))
                                        <span class="text-danger ml-1">{{ $errors->first('experiecia_servicio') }}</span>
                                        @endif
                                    </div>

                            </div>
                            <div class="col-md-4" style="padding-right:0px">
                                <label for="aniosExperiencia">Años experencia minima: <b style="color:red">(*)</b></label>
                                <input type="number" class="form-control" name="aniosExperiencia" value="{{ old('aniosExperiencia') }}">
                            </div>
                    </div>
                    {{-- Días que necesita	Horas por día	Fecha que se necesita que ingrese	fecha de finalización --}}

                    {{-- FECHAS --}}

                    {{--  --}}
            </div>

            <!-- Modal footer -->
            <div class="modal-footer botones">
                <div>
                    <button type="button" class="btn btn-primary" id="btn_enviar">Guardar</button>
                    <span class="text-danger" id="error_establecimiento" style="display: none">Este profesional ya se encuantra asignado a otro $miento</span>
                </div>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
            </div>

        </div>
    </div>
</div>



<script>

    $(document).ready(function() {

        $(".servicio_clinico").select2({
            placeholder: "Seleccione servicio",
            allowClear: true,
            minimumInputLength: 2,
            formatInputTooShort: function() {
                return "Ingrese 2 o más caracteres para la búsqueda";
            },
            ajax: {
                url: "{{ route('live_search.servicio') }}",
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

        $(".capacitaciones").select2({
            tags: true,
        })


        $(".experiencia_servicio").select2({
            tags: true,
        })

        $('.profesionalRequerido').select2();

    $('.select2-selection--single').css('height', 'calc(2.25rem + 2px)');
    });

</script>
