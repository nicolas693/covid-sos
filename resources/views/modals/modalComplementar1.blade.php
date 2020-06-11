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


</style>

<div id="modalComplementar" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Complementar datos de: <span>{{$profesional->nombre}}</span></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>


            <!-- Modal body -->
            <div class="modal-body">
                {{$complementario}}
        {{$exp}}


                {{-- DATOS PERSONALES --}}
                <div class="col-md-12" style="padding:0px">
                    <div class="row">
                        <div class="col-md-6">
                            <label>Datos del Profesional:</label>
                            <div class=" border" style="height: 80px">
                                <table style="width: 100%; ">
                                    <tbody>
                                        <tr>
                                            <td>Título Profesional :</td>
                                            <td>{{$profesional->getTitulo()->tx_descripcion}}</td>
                                        </tr>
                                        <tr>
                                            <td>Especialidad :</td>
                                            @if($profesional->getEspecialidad()!='vacio')
                                            <td>{{$profesional->getEspecialidad()->tx_descripcion}}</td>
                                            @else
                                            <td>SIN ESPECIALIDAD</td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <td>Número Telefónico :</td>
                                            <td>{{$profesional->telefono}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label>Observaciones :</label>
                            <div class="border" style="height: 80px">
                                <textarea class="form-control"  id="observaciones" rows="2" placeholder="" style="resize:none;border:none;"> @if(isset($complementario)&& $complementario->observaciones!=null){{$complementario->observaciones}} @endif</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- DATOS COMPLEMENTARIOS --}}
                <div>
                    <form action="{{route('callcenter.complementarProfesionalEnviar')}}" method="post" class="formulario_complementar" id="formularioComplementar">
                        @csrf
                        <input type="hidden" name="profesional_id" value={{$profesional->id}}>
                        <input type="hidden" id="estado_id" name="estado" value="{{$profesional->estado}}">
                        <input type="hidden" id="user_id" name="user_id" value="">
                        <input type="hidden" id="establecimiento_id" name="establecimiento_id" value="null">
                        <input type="hidden" id="modo" name="modo" value="">
                        <input type="hidden" id="experiencias_input" name="experiencias" value="">
                        <input type="hidden" id="observaciones_input" name="observaciones" value="">
                        <input type="hidden" id="modo_input" name="modo" value="{{$modo}}">


                        {{-- INSCRIPCIONES --}}
                        <div class="row">
                            <div class="col-md-2" style="margin-top: 10px;">
                                <label >Inscripciones: </label>
                            </div>
                            <div class="col-md-2 btn_colapse" style="margin-top: 10px;" >
                                <a href="#"  id="btn_inscripciones"  onclick="mostrarInscripciones()" style="margin-top: 3px">-</a>
                            </div>
                        </div>
                        <div class="col-md-12 border borde" id="div_inscripciones" style="display: block;">
                            {{-- Eunacom --}}
                            <div class="form-group row" style="margin-bottom:0px">
                                <label for="eunacom" class="col-md-2 col-form-label" style="font-weight: normal">Eunacom</label>
                                <div class="col-md-3" id="eunacom">
                                    <select id="eunacom" class="form-control form-control-sm" name="eunacom">
                                    <option @if( isset($complementario) && $complementario->eunacom=="No lo tiene") selected @endif>No lo tiene</option>
                                    <option @if( isset($complementario) && $complementario->eunacom=="Lo tiene") selected @endif>Lo tiene</option>
                                    <option @if( isset($complementario) && $complementario->eunacom=="En proceso") selected @endif>En proceso</option>
                                </select>
                                </div>
                            </div>

                            {{-- conacem --}}
                            <div class="form-group row" style="margin-bottom:0px">
                                <label for="conacem" class="col-sm-2 col-form-label" style="font-weight: normal">Conacem</label>
                                <div class="col-md-3" id="conacem">
                                    <select id="conacem" class="form-control form-control-sm" name="conacem">
                                    <option @if( isset($complementario) && $complementario->conacem=="No lo tiene") selected @endif>No lo tiene</option>
                                    <option @if( isset($complementario) && $complementario->conacem=="Lo tiene") selected @endif>Lo tiene</option>
                                    <option @if( isset($complementario) && $complementario->conacem=="En proceso") selected @endif>En proceso</option>
                                    </select>
                                </div>
                            </div>
                            {{-- supersalud --}}
                            <div class="form-group row" style="margin-bottom:0px">
                                <label for="supersalud" class="col-sm-2 col-form-label" style="font-weight: normal">Super salud</label>
                                <div class="col-md-3" id="supersalud">
                                    <select id="supersalud" class="form-control form-control-sm" name="supersalud">
                                        <option @if( isset($complementario) && $complementario->supersalud=="Inscrito") selected @endif>Inscrito</option>
                                        <option @if( isset($complementario) && $complementario->supersalud=="No inscrito") selected @endif>No inscrito</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        {{-- EXPERIENCIA --}}
                        <div class="row">
                            <div class="col-md-2" style="margin-top: 10px;">
                                <label>Experiencia: </label>
                            </div>
                            <div class="col-md-2 btn_colapse" style="margin-top: 10px;" >
                                <a href="#"  id="btn_experiencias"  onclick="mostrarExperiencia()" style="margin-top: 3px">-</a>
                            </div>
                            {{-- <div class="col-md-2" style="margin-top: 10px;">
                                <a href="#" style='text-decoration : none;color:gray' id="btn_experiencia" onclick="mostrarExperiencia()"><i class="fas fa-minus-circle text-danger"></i></a>
                            </div> --}}
                        </div>
                        <div class="col-md-12 border borde" id="div_experiencia" style="display: block;">
                            <div class="row" style="margin-bottom: 10px">
                                <div class="col-md-2">
                                    Años\Meses
                                </div>
                                <div class="col-md-2">
                                    Periodo
                                </div>
                                <div class="col">
                                    Servicio clinico de desempeño
                                </div>
                                <div class="col">
                                    Lugar de Trabajo
                                </div>
                                <div class="col-xs-3">
                                    <div>
                                        <span style="font-size: 20px; color: rgb(255, 30, 30); ">
                                            <i class="fas fa-minus-circle remove_fecha text-danger" style="visibility:hidden "></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="experiencia">

                                @if(empty($exp[0]))
                                <div id="divRow0" class="clonerow">
                                    <div class="row fila_completa" id="innerDivRow0">
                                        {{-- TIEMPO --}}
                                        <div class="col-md-2">
                                            {{-- <select name="tiempoTipo" class="form-control fila_select tiempoTipo"> --}}
                                            <select class="form-control fila_select tiempoTipo">
                                                <option value="años">Años</option>
                                                <option value="meses">Meses</option>
                                            </select>
                                        </div>
                                        {{-- CANTIDAD DE TIEMPO --}}
                                        <div class="col-md-2">
                                            {{-- <input type="number" name="cantidadTiempo" class="form-control tiempoPeriodo" min="1" max="10" value="1"> --}}
                                            <input type="number" class="form-control tiempoPeriodo" min="1" max="10" value="1">
                                        </div>

                                        {{-- SERVICIO CLINICO DE DESEMPEÑO --}}
                                        <div class="col">
                                            {{-- <input type="text" name="servicioClinico" class="form-control servicioClinico" required> --}}
                                            <input type="text" class="form-control servicioClinico" required>
                                        </div>

                                        {{-- LUGAR DE TRABAJO--}}
                                        <div class="col">
                                            {{-- <input type="text" name="lugarTrabajo" class="form-control lugarTrabajo"> --}}
                                            <input type="text" class="form-control lugarTrabajo">
                                        </div>

                                        {{-- BOTONES ADD/ELIMINATE --}}
                                        <div class="col-xs-3">
                                            <div class="form-group boton_add">
                                                <span style="font-size: 20px; color: Dodgerblue;">
                                                    <i class="fas fa-plus-circle add_experiencia"></i>
                                                </span>
                                            </div>
                                            <div class="form-group boton_remove">
                                                <span style="font-size: 20px; color: rgb(255, 30, 30);">
                                                    <i class="fas fa-minus-circle remove_experiencia text-danger"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @else
                                <div id="divRow0" class="clonerow">
                                    <div class="row fila_completa" id="innerDivRow0">
                                        {{-- TIEMPO --}}
                                        <div class="col-md-2">
                                            {{-- <select name="tiempoTipo" class="form-control fila_select tiempoTipo"> --}}
                                            <select class="form-control fila_select tiempoTipo">
                                                <option value="años" @if($exp[0]->tiempoTipo=="años") selected @endif>Años</option>
                                                <option value="meses" @if($exp[0]->tiempoTipo=="meses") selected @endif>Meses</option>
                                            </select>
                                        </div>
                                        {{-- CANTIDAD DE TIEMPO --}}
                                        <div class="col-md-2">
                                            {{-- <input type="number" name="cantidadTiempo" class="form-control tiempoPeriodo" min="1" max="10" value="1"> --}}
                                            <input type="number" class="form-control tiempoPeriodo" min="1" max="10" value="{{$exp[0]->tiempoPeriodo}}">
                                        </div>

                                        {{-- SERVICIO CLINICO DE DESEMPEÑO --}}
                                        <div class="col">
                                            {{-- <input type="text" name="servicioClinico" class="form-control servicioClinico" required> --}}
                                            <input type="text" class="form-control servicioClinico" value="{{$exp[0]->lugarTrabajo}}" required>
                                        </div>

                                        {{-- LUGAR DE TRABAJO--}}
                                        <div class="col">
                                            {{-- <input type="text" name="lugarTrabajo" class="form-control lugarTrabajo"> --}}
                                            <input type="text" class="form-control lugarTrabajo" value="{{$exp[0]->lugarTrabajo}}">
                                        </div>

                                        {{-- BOTONES ADD/ELIMINATE --}}
                                        <div class="col-xs-3">
                                            <div class="form-group boton_add">
                                                <span style="font-size: 20px; color: Dodgerblue;">
                                                    <i class="fas fa-plus-circle add_experiencia"></i>
                                                </span>
                                            </div>
                                            <div class="form-group boton_remove">
                                                <span style="font-size: 20px; color: rgb(255, 30, 30);">
                                                    <i class="fas fa-minus-circle remove_experiencia text-danger"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @foreach($exp as $key => $e)
                                @if($key!=0)
                                <div id="divRow{{$key+1}}" class="clonerow">
                                    <div class="row fila_completa" id="innerDivRow0">
                                        {{-- TIEMPO --}}
                                        <div class="col-md-2">
                                            {{-- <select name="tiempoTipo" class="form-control fila_select tiempoTipo"> --}}
                                            <select class="form-control fila_select tiempoTipo">
                                                <option value="años" @if($e->tiempoTipo=="años") selected @endif>Años</option>
                                                <option value="meses" @if($e->tiempoTipo=="meses") selected @endif>Meses</option>
                                            </select>
                                        </div>
                                        {{-- CANTIDAD DE TIEMPO --}}
                                        <div class="col-md-2">
                                            {{-- <input type="number" name="cantidadTiempo" class="form-control tiempoPeriodo" min="1" max="10" value="1"> --}}
                                            <input type="number" class="form-control tiempoPeriodo" min="1" max="10" value="{{$e->tiempoPeriodo}}">
                                        </div>

                                        {{-- SERVICIO CLINICO DE DESEMPEÑO --}}
                                        <div class="col">
                                            {{-- <input type="text" name="servicioClinico" class="form-control servicioClinico" required> --}}
                                            <input type="text" class="form-control servicioClinico" required value="{{$e->servicioClinico}}">
                                        </div>

                                        {{-- LUGAR DE TRABAJO--}}
                                        <div class="col">
                                            {{-- <input type="text" name="lugarTrabajo" class="form-control lugarTrabajo"> --}}
                                            <input type="text" class="form-control lugarTrabajo" value="{{$e->lugarTrabajo}}">
                                        </div>

                                        {{-- BOTONES ADD/ELIMINATE --}}
                                        <div class="col-xs-3">
                                            <div class="form-group boton_add">
                                                <span style="font-size: 20px; color: Dodgerblue;">
                                                    <i class="fas fa-minus-circle remove_experiencia text-danger" id="boton_{{$key+1}}" onclick="quitarFila(this.id)"></i>
                                                </span>
                                            </div>
                                            <div class="form-group boton_remove">
                                                <span style="font-size: 20px; color: rgb(255, 30, 30);">
                                                    <i class="fas fa-minus-circle remove_experiencia text-danger" onclick="quitarFila()"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif

                                @endforeach
                                @endif



                            </div>
                        </div>

                        {{-- CAPACITACIONES --}}
                        <div class="row">
                            <div class="col-md-2" style="margin-top: 10px;">
                                <label>Capacitaciones: </label>
                            </div>
                            <div class="col-md-2 btn_colapse" style="margin-top: 10px;" >
                                <a href="#"  id="btn_capacitaciones"  onclick="mostrarCapacitaciones()" style="margin-top: 3px">-</a>
                            </div>

                            {{-- <div class="col-md-2" style="margin-top: 10px;">
                                <span class="btn" style='text-decoration : none;color:gray' id="btn_capacitaciones" onclick="mostrarCapacitaciones()"><i class="fas fa-minus-circle text-danger"></i></span>
                            </div> --}}
                        </div>
                        <div class="col-md-12 border borde" id="div_capacitaciones" style="display: block;">
                            {{-- IAAS --}}
                            <div class="form-group row" style="margin-bottom:5px">
                                <label for="iaas" class="col-md-5 col-form-label" style="font-weight: normal;margin-top:-3px">Curso IAAS</label>
                                <div class="col-md-2">
                                    <select id="iaas" name="iaas" class="form-control form-control-sm " >
                                        <option value="no"  @if( isset($complementario) && $complementario->iaas=="no") selected @endif>No</option>
                                        <option value="si"  @if( isset($complementario) && $complementario->iaas=="si") selected @endif>Si</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <select id="iaasCurso" name="iaasCurso" class="form-control form-control-sm " style="display: none">
                                    <option value="curso" @if( isset($complementario) && $complementario->iaasCurso=="curso") selected @endif>Curso</option>
                                    <option value="diplomado" @if( isset($complementario) && $complementario->iaasCurso=="diplomado") selected @endif>Diplomado</option>
                                    </select>
                                </div>
                            </div>
                            {{-- RCP --}}
                            <div class="form-group row" style="margin-bottom:5px">
                                <label for="rcp" class="col-md-5 col-form-label" style="font-weight: normal;margin-top:-3px">Curso RCP</label>
                                <div class="col-md-2" >
                                    <select id="rcp" name="rcp" class="form-control form-control-sm ">
                                        <option value="no"  @if( isset($complementario) && $complementario->rcp=="no") selected @endif>No</option>
                                        <option value="si"  @if( isset($complementario) && $complementario->rcp=="si") selected @endif>Si</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <select id="rcpCurso"  name="rcpCurso" class="form-control form-control-sm " style="display: none">
                                        <option value="curso" @if( isset($complementario) && $complementario->rcpCurso=="curso") selected @endif>Curso</option>
                                        <option value="diplomado" @if( isset($complementario) && $complementario->rcpCurso=="diplomado") selected @endif>Diplomado</option>
                                    </select>
                                </div>
                            </div>
                            {{-- MANEJO PACIENTE CRITICO --}}
                            <div class="form-group row" style="margin-bottom:5px">
                                <label for="pacienteCritico" class="col-md-5 col-form-label" style="font-weight: normal;margin-top:-3px">Manejo paciente critico</label>
                                <div class="col-md-2">
                                    <select id="pacienteCritico" name="pacienteCritico" class="form-control form-control-sm">
                                        <option value="no"  @if( isset($complementario) && $complementario->pacienteCritico=="no") selected @endif>No</option>
                                        <option value="si"  @if( isset($complementario) && $complementario->pacienteCritico=="si") selected @endif>Si</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <select id="pacienteCriticoCurso" name="pacienteCriticoCurso" class="form-control form-control-sm" style="display: none" >
                                        <option value="curso" @if( isset($complementario) && $complementario->pacienteCriticoCurso=="curso") selected @endif>Curso</option>
                                        <option value="diplomado" @if( isset($complementario) && $complementario->pacienteCriticoCurso=="diplomado") selected @endif>Diplomado</option>
                                    </select>
                                </div>
                            </div>
                            {{-- MANEJO VENTILADOR MECANICO --}}
                            <div class="form-group row" style="margin-bottom:5px">
                                <label for="ventilacion" class="col-md-5 col-form-label" style="font-weight: normal;margin-top:-3px">Manejo ventilador mecanico</label>
                                <div class="col-md-2" >
                                    <select id="ventilacion" name="ventilacion" class="form-control form-control-sm">
                                        <option value="no"  @if( isset($complementario) && $complementario->ventilacionMecanica=="no") selected @endif>No</option>
                                        <option value="si"  @if( isset($complementario) && $complementario->ventilacionMecanica=="si") selected @endif>Si</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <select id="ventilacionCurso" name="ventilacionCurso" class="form-control form-control-sm" style="display: none">
                                        <option value="curso" @if( isset($complementario) && $complementario->ventilacionCurso=="curso") selected @endif>Curso</option>
                                        <option value="diplomado" @if( isset($complementario) && $complementario->ventilacionCurso=="diplomado") selected @endif>Diplomado</option>
                                    </select>
                                </div>
                            </div>
                            {{-- INDUCCION GENERAL A LA ADMINISTRACION DEL ESTADO --}}
                            <div class="form-group row" style="margin-bottom:5px">
                                <label for="adminEstado" class="col-md-5 col-form-label" style="font-weight: normal;margin-top:-3px">Induccion a la administracion del estado</label>
                                <div class="col-md-2">
                                    <select id="adminEstado"  name="adminEstado" class="form-control form-control-sm">
                                        <option value="no"  @if( isset($complementario) && $complementario->adminEstado=="no") selected @endif>No</option>
                                        <option value="si"  @if( isset($complementario) && $complementario->adminEstado=="si") selected @endif>Si</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <select id="adminEstadoCurso" name="adminEstadoCurso" class="form-control form-control-sm" style="display: none">
                                        <option value="curso" @if( isset($complementario) && $complementario->adminEstadoCurso=="curso") selected @endif>Curso</option>
                                        <option value="diplomado" @if( isset($complementario) && $complementario->adminEstadoCurso=="diplomado") selected @endif>Diplomado</option>
                                    </select>
                                </div>
                            </div>
                            {{-- ATENCION EN URGENCIA EMERGENCIA Y DESASTRES --}}
                            <div class="form-group row" style="margin-bottom:5px">
                                <label for="urgenciaDesastres" class="col-md-5 col-form-label" style="font-weight: normal;margin-top:-3px">Atencion urgencia emergencia y desastres</label>
                                <div class="col-md-2">
                                    <select id="urgenciaDesastres" name="urgenciaDesastres" class="form-control form-control-sm">
                                        <option value="no"  @if( isset($complementario) && $complementario->urgenciaDesastres=="no") selected @endif>No</option>
                                        <option value="si"  @if( isset($complementario) && $complementario->urgenciaDesastres=="si") selected @endif>Si</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <select id="urgenciaDesastresCurso" name="urgenciaDesastresCurso" class="form-control form-control-sm" style="display: none">
                                        <option value="curso" @if( isset($complementario) && $complementario->urgenciaDesastresCurso=="curso") selected @endif>Curso</option>
                                        <option value="diplomado" @if( isset($complementario) && $complementario->urgenciaDesastresCurso=="diplomado") selected @endif>Diplomado</option>
                                    </select>
                                </div>
                            </div>
                            {{-- ATENCION Y CUIDADOS DEL ADULTO MAYOR --}}
                            <div class="form-group row" style="margin-bottom:5px">
                                <label for="adultoMayor" class="col-md-5 col-form-label" style="font-weight: normal;margin-top:-3px">Atencion y cuidados del adulto mayor</label>
                                <div class="col-md-2">
                                    <select id="adultoMayor" name="adultoMayor" class="form-control form-control-sm">
                                        <option value="no"  @if( isset($complementario) && $complementario->adultoMayor=="no") selected @endif>No</option>
                                        <option value="si"  @if( isset($complementario) && $complementario->adultoMayor=="si") selected @endif>Si</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <select id="adultoMayorCurso" name="adultoMayorCurso" class="form-control form-control-sm" style="display: none">
                                        <option value="curso" @if( isset($complementario) && $complementario->adultoMayorCurso=="curso") selected @endif>Curso</option>
                                        <option value="diplomado" @if( isset($complementario) && $complementario->adultoMayorCurso=="diplomado") selected @endif>Diplomado</option>
                                    </select>
                                </div>
                            </div>
                            {{-- MANEJO CLINICO DE INFECCIONES RESPIRATORIAS --}}
                            <div class="form-group row" style="margin-bottom:5px">
                                <label for="infeccionesRespiratorias" class="col-md-5 col-form-label" style="font-weight: normal;margin-top:-3px">Manejo clinico de infecciones respiratorias</label>
                                <div class="col-md-2">
                                    <select id="infeccionesRespiratorias" name="infeccionesRespiratorias" class="form-control form-control-sm">
                                        <option value="no"  @if( isset($complementario) && $complementario->infeccionesRespiratorias=="no") selected @endif>No</option>
                                        <option value="si"  @if( isset($complementario) && $complementario->infeccionesRespiratorias=="si") selected @endif>Si</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <select id="infeccionesRespiratoriasCurso" name="infeccionesRespiratoriasCurso" class="form-control form-control-sm" style="display: none">
                                        <option value="curso" @if( isset($complementario) && $complementario->infeccionesRespiratoriasCurso=="curso") selected @endif>Curso</option>
                                        <option value="diplomado" @if( isset($complementario) && $complementario->infeccionesRespiratoriasCurso=="diplomado") selected @endif>Diplomado</option>
                                    </select>
                                </div>
                            </div>
                            {{-- IRA: INFECCIONES RESPIRATORIAS DEL NINO --}}
                            <div class="form-group row" style="margin-bottom:5px">
                                <label for="ira" class="col-md-5 col-form-label" style="font-weight: normal;margin-top:-3px">Infecciones respiratorias del niño</label>
                                <div class="col-md-2">
                                    <select id="ira" name="ira" class="form-control form-control-sm">
                                        <option value="no"  @if( isset($complementario) && $complementario->ira=="no") selected @endif>No</option>
                                        <option value="si"  @if( isset($complementario) && $complementario->ira=="si") selected @endif>Si</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <select id="iraCurso" name="iraCurso" class="form-control form-control-sm" style="display: none">
                                        <option value="curso" @if( isset($complementario) && $complementario->iraCurso=="curso") selected @endif>Curso</option>
                                        <option value="diplomado" @if( isset($complementario) && $complementario->iraCurso=="diplomado") selected @endif>Diplomado</option>
                                    </select>
                                </div>
                            </div>
                            {{-- ERA: ENFERMEDADES RESPIRATORIAS DEL ADULTO --}}
                            <div class="form-group row" style="margin-bottom:5px">
                                <label for="era" class="col-md-5 col-form-label" style="font-weight: normal;margin-top:-3px">Infecciones respiratorias del adulto</label>
                                <div class="col-md-2">
                                    <select id="era"  name="era" class="form-control form-control-sm">
                                        <option value="no"  @if( isset($complementario) && $complementario->era=="no") selected @endif>No</option>
                                        <option value="si"  @if( isset($complementario) && $complementario->era=="si") selected @endif>Si</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <select id="eraCurso" name="eraCurso" class="form-control form-control-sm" style="display: none">
                                        <option value="curso" @if( isset($complementario) && $complementario->eraCurso=="curso") selected @endif>Curso</option>
                                        <option value="diplomado" @if( isset($complementario) && $complementario->eraCurso=="diplomado") selected @endif>Diplomado</option>
                                    </select>
                                </div>
                            </div>
                            {{-- CURSO COVID 19 --}}
                            <div class="form-group row" style="margin-bottom:5px">
                                <label for="covid19" class="col-md-5 col-form-label" style="font-weight: normal;margin-top:-3px">Curso COVID-19</label>
                                <div class="col-md-2">
                                    <select id="covid19" name="covid19" class="form-control form-control-sm">
                                        <option value="no"  @if( isset($complementario) && $complementario->covid19=="no") selected @endif>No</option>
                                        <option value="si"  @if( isset($complementario) && $complementario->covid19=="si") selected @endif>Si</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <select id="covid19Curso" name="covid19Curso" class="form-control form-control-sm" style="display: none">
                                        <option value="curso" @if( isset($complementario) && $complementario->covid19Curso=="curso") selected @endif>Curso</option>
                                        <option value="diplomado" @if( isset($complementario) && $complementario->covid19Curso=="diplomado") selected @endif>Diplomado</option>
                                    </select>
                                </div>
                            </div>
                            {{-- OTRO --}}
                            <div class="form-group row" style="margin-bottom:5px">
                                <label for="otro" class="col-md-5 col-form-label" style="font-weight: normal;margin-top:-3px">Otros</label>
                                <div class="col-md-2">
                                    <select id="otro" name="otro" class="form-control form-control-sm">
                                        <option value="no"  @if( isset($complementario) && $complementario->otro=="no") selected @endif>No</option>
                                        <option value="si"  @if( isset($complementario) && $complementario->otro=="si") selected @endif>Si</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" class="form-control form-control-sm" id="otroCurso" name="otroCurso" style="display: none" @if( isset($complementario) && $complementario->otroCurso!="null") value={{$complementario->otroCurso}} @endif>
                                </div>
                            </div>
                        </div>

                        {{-- VACUNAS --}}
                        <div class="row">
                            <div class="col-md-2" style="margin-top: 10px;">
                                <label >Vacunas: </label>
                            </div>
                            <div class="col-md-2 btn_colapse" style="margin-top: 10px;" >
                                <a href="#"  id="btn_inscripciones"  onclick="mostrarVacunas()" style="margin-top: 3px">-</a>
                            </div>
                        </div>
                        <div class="col-md-12 border borde" id="div_inscripciones" style="display: block;">
                            {{-- hepatita a --}}
                            <div class="form-group row" style="margin-bottom:0px">
                                <label for="hepatitisA" class="col-md-3 col-form-label" style="font-weight: normal">Hepatitis A</label>
                                <div class="col-md-2" id="hepatitisA">
                                    <select id="hepatitisA" class="form-control form-control-sm" name="hepatitisA">
                                    <option value="no" @if( isset($complementario) && $complementario->hepatitisA=="no") selected @endif>No</option>
                                    <option value="si" @if( isset($complementario) && $complementario->hepatitisA=="si") selected @endif>Si</option>
                                </select>
                                </div>
                            </div>

                            {{-- hepatita b --}}
                            <div class="form-group row" style="margin-bottom:0px">
                                <label for="hepatitisB" class="col-md-3 col-form-label" style="font-weight: normal">Hepatitis B</label>
                                <div class="col-md-2" id="hepatitisB">
                                    <select id="hepatitisB" class="form-control form-control-sm" name="hepatitisB">
                                        <option value="no" @if( isset($complementario) && $complementario->hepatitisB=="no") selected @endif>No</option>
                                        <option value="si" @if( isset($complementario) && $complementario->hepatitisB=="si") selected @endif>Si</option>
                                    </select>
                                </div>
                            </div>
                            {{-- hepatita c --}}
                            <div class="form-group row" style="margin-bottom:0px">
                                <label for="hepatitisC" class="col-md-3 col-form-label" style="font-weight: normal">Hepatitis C</label>
                                <div class="col-md-2" id="hepatitisC">
                                    <select id="hepatitisC" class="form-control form-control-sm" name="hepatitisC">
                                        <option value="no" @if( isset($complementario) && $complementario->hepatitisC=="no") selected @endif>No</option>
                                        <option value="si" @if( isset($complementario) && $complementario->hepatitisC=="si") selected @endif>Si</option>
                                    </select>
                                </div>
                            </div>
                            {{-- influenza en 2020 --}}
                            <div class="form-group row" style="margin-bottom:0px">
                                <label for="influeza" class="col-md-3 col-form-label" style="font-weight: normal">Influenza en 2020</label>
                                <div class="col-md-2" id="influeza">
                                    <select id="influeza" class="form-control form-control-sm" name="influeza">
                                        <option value="no" @if( isset($complementario) && $complementario->influenza=="no") selected @endif>No</option>
                                        <option value="si" @if( isset($complementario) && $complementario->influenza=="si") selected @endif>Si</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer botones">
                <div>
                    <button type="button" class="btn btn-primary" id="btn_enviar">Guardar</button>
                    <span class="text-danger" id="error_establecimiento" style="display: none">Este profesional ya se encuantra asignado a otro establecimiento</span>
                </div>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
            </div>

        </div>
    </div>
</div>



<script>
    function enviar() {
        console.log("aprete");
        $("#formularioComplementar").submit();
    };

    function esVacio(obj) {
        return obj.servicioClinico === '';
    }
    $(document).ready(function() {

        if($('#iaas').val()=="si"){
            $('#iaasCurso').fadeIn();
        }
        if($('#rcp').val()=="si"){
            $('#rcpCurso').fadeIn();
        }
        if($('#pacienteCritico').val()=="si"){
            $('#pacienteCriticoCurso').fadeIn();
        }
        if($('#ventilacion').val()=="si"){
            $('#ventilacionCurso').fadeIn();
        }
        if($('#adminEstado').val()=="si"){
            $('#adminEstadoCurso').fadeIn();
        }
        if($('#urgenciaDesastres').val()=="si"){
            $('#urgenciaDesastresCurso').fadeIn();
        }
        if($('#adultoMayor').val()=="si"){
            $('#adultoMayorCurso').fadeIn();
        }
        if($('#infeccionesRespiratorias').val()=="si"){
            $('#infeccionesRespiratoriasCurso').fadeIn();
        }
        if($('#ira').val()=="si"){
            $('#iraCurso').fadeIn();
        }
        if($('#era').val()=="si"){
            $('#eraCurso').fadeIn();
        }
        if($('#covid19').val()=="si"){
            $('#covid19Curso').fadeIn();
        }
        if($('#otro').val()=="si"){
            $('#otroCurso').fadeIn();
        }







        //quito el bloqueo del boton en la vista del callcenter
        $(".complementar").attr('disabled', false);

        var max_fields = 5; //maximum input boxes allowed
        var wrapper = $(".experiencia"); //Fields wrapper
        var add_button = $(".add_experiencia"); //Add button ID
        var remove_button = $(".remove_experiencia"); //Add button ID

        var experiencias = [];
        var x = 1;

        $(".boton_remove").hide();

        original = $('#divRow0');
        $(add_button).click(function(e) { //on add input button click
            clone = $(original).clone(true, true);
            clone.find('.boton_add').remove();
            clone.find('.boton_remove').show();
            clone.find('#divRow0').prop('id', 'divRow' + $('.clonerow').length);
            clone.find('#innerDivRow0').prop('id', 'innerDivRow' + $('.clonerow').length);

            clone.find('.tiempoTipo').val("años");
            clone.find('.tiempoTipo').prop('id', 'tiempoTipoRow' + $('.clonerow').length);
            clone.find('.tiempoPeriodo').val("1");
            clone.find('.tiempoPeriodo').prop('id', 'tiempoPeriodoRow' + $('.clonerow').length);
            clone.find('.servicioClinico').val("");
            clone.find('.servicioClinico').prop('id', 'servicioClinicoRow' + $('.clonerow').length);
            clone.find('.lugarTrabajo').val("");
            clone.find('.lugarTrabajo').prop('id', 'lugarTrabajoRow' + $('.clonerow').length);

            // e.preventDefault();
            $(wrapper).append(clone); //add input box
            // $(wrapper).append('<div><input type="text" name="mytext[]"/><a href="#" class="remove_field">Remove</a></div>'); //add input box
        });


        $(remove_button).click(function(e) {
            $(this).parentsUntil('.experiencia').remove();
        });

        $("#btn_enviar").click(function(e) {
            $('#observaciones_input').val($('#observaciones').val());
            console.log( $('#observaciones_input').val());
            $('.fila_completa .form-control ').removeClass('error');
            experiencias = [];

            var error = 0;
            // e.preventDefault();
            $('.fila_completa').each(function(index, element) {


                if ($(this).find('.servicioClinico').val() == "") {
                    error++, $(this).find('.servicioClinico').addClass('error');
                }
                if ($(this).find('.lugarTrabajo').val() == "") {
                    error++, $(this).find('.lugarTrabajo').addClass('error');
                }


                if ($(this).find('.tiempoPeriodo').val() == "") {
                    error++, $(this).find('.tiempoPeriodo').addClass('error');
                }

                var fila = {
                    tiempoTipo: $(this).find('.tiempoTipo').val(),

                    // if(tiempoTipo==""){error++}
                    tiempoPeriodo: $(this).find('.tiempoPeriodo').val(),
                    // if(tiempoPeriodo==""){error++}
                    servicioClinico: $(this).find('.servicioClinico').val(),

                    // if(servicioClinico==""){error++,$(this).find('.servicioClinico').addClass('error')}
                    lugarTrabajo: $(this).find('.lugarTrabajo').val(),
                    // if(lugarTrabajo==""){error++}

                };

                experiencias.push(fila);
                // console.log("fila "+JSON.stringify(fila));

                // data = Object.keys(fila).map(function (key) { return fila[key] })
                // console.log(experiencias.find(esVacio))
            });

            if (error != 0) {
                console.log('hay errores en el fomulario');
                return false;
            } else {
                //  console.log("fila "+JSON.stringify(experiencias));
                $('#experiencias_input').val(JSON.stringify(experiencias));
                console.log("experienncias " + $('#experiencias_input').val());
                experiencias = [];
                 $(".formulario_complementar").submit();
            }

        });

        $('#iaas').change(function(e) {
            value = e.target.value;
            if (value == 'si') {
                $('#iaasCurso').fadeIn();
            } else {
                $('#iaasCurso').fadeOut();
            }
        });
        $('#rcp').change(function(e) {
            value = e.target.value;
            if (value == 'si') {
                $('#rcpCurso').fadeIn();
            } else {
                $('#rcpCurso').fadeOut();
            }
        });
        $('#pacienteCritico').change(function(e) {
            value = e.target.value;
            if (value == 'si') {
                $('#pacienteCriticoCurso').fadeIn();
            } else {
                $('#pacienteCriticoCurso').fadeOut();
            }
        });
        $('#ventilacion').change(function(e) {
            value = e.target.value;
            if (value == 'si') {
                $('#ventilacionCurso').fadeIn();
            } else {
                $('#ventilacionCurso').fadeOut();
            }
        });
        $('#adminEstado').change(function(e) {
            value = e.target.value;
            if (value == 'si') {
                $('#adminEstadoCurso').fadeIn();
            } else {
                $('#adminEstadoCurso').fadeOut();
            }
        });
        $('#urgenciaDesastres').change(function(e) {
            value = e.target.value;
            if (value == 'si') {
                $('#urgenciaDesastresCurso').fadeIn();
            } else {
                $('#urgenciaDesastresCurso').fadeOut();
            }
        });
        $('#adultoMayor').change(function(e) {
            value = e.target.value;
            if (value == 'si') {
                $('#adultoMayorCurso').fadeIn();
            } else {
                $('#adultoMayorCurso').fadeOut();
            }
        });
        $('#infeccionesRespiratorias').change(function(e) {
            value = e.target.value;
            if (value == 'si') {
                $('#infeccionesRespiratoriasCurso').fadeIn();
            } else {
                $('#infeccionesRespiratoriasCurso').fadeOut();
            }
        });
        $('#ira').change(function(e) {
            value = e.target.value;
            if (value == 'si') {
                $('#iraCurso').fadeIn();
            } else {
                $('#iraCurso').fadeOut();
            }
        });
        $('#era').change(function(e) {
            value = e.target.value;
            if (value == 'si') {
                $('#eraCurso').fadeIn();
            } else {
                $('#eraCurso').fadeOut();
            }
        });
        $('#covid19').change(function(e) {
            value = e.target.value;
            if (value == 'si') {
                $('#covid19Curso').fadeIn();
            } else {
                $('#covid19Curso').fadeOut();
            }
        });
        $('#otro').change(function(e) {
            value = e.target.value;
            if (value == 'si') {
                $('#otroCurso').fadeIn();
            } else {
                $('#otroCurso').fadeOut();
            }
        });



    });

    function mostrarInscripciones() {

        if (!$('#div_inscripciones').is(':visible')) {

            $('#div_inscripciones').fadeIn();
            $('#btn_inscripciones').text("-");
            // document.getElementById('btn_inscripciones').innerHTML = '<i class="fas fa-minus-circle text-danger"></i>';
        } else {
            $('#div_inscripciones').fadeOut();
            $('#btn_inscripciones').text("+");
            // document.getElementById('btn_inscripciones').innerHTML = '<i class="fas fa-plus-circle text-success"></i>';
        }

    }

    function mostrarExperiencia() {

        if (!$('#div_experiencia').is(':visible')) {

            $('#div_experiencia').fadeIn(function(e) {
                $('#btn_experiencias').text("-");
                // document.getElementById('btn_experiencia').innerHTML = '<i class="fas fa-minus-circle text-danger"></i>';
            });
        } else {
            $('#div_experiencia').fadeOut(function(e) {
                $('#btn_experiencias').text("+");
                // document.getElementById('btn_experiencia').innerHTML = '<i class="fas fa-plus-circle text-success"></i>';
            });
        }

    }

    function mostrarCapacitaciones() {

        if (!$('#div_capacitaciones').is(':visible')) {

            $('#div_capacitaciones').fadeIn(function(e) {
                $('#btn_capacitaciones').text("-");
                // document.getElementById('btn_capacitaciones').innerHTML = '<i class="fas fa-minus-circle text-danger"></i>';
            });
        } else {
            $('#div_capacitaciones').fadeOut(function(e) {
                $('#btn_capacitaciones').text("+");
                // document.getElementById('btn_capacitaciones').innerHTML = '<i class="fas fa-plus-circle text-success"></i>';
            });
        }

    }

    function quitarFila(name) {
        console.log('divRow' + name.split('_')['0']);
        document.getElementById('divRow' + name.split('_')['1']).remove();
    }
</script>
