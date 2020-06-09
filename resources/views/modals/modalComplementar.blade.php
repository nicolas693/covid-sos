<!-- Select2 -->
<link rel="stylesheet" href="{{asset('/plugins/select2/css/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>

<style>
    /* .botones {
        display: flex;
        justify-content: space-between;
    } */
    .borde{
        padding: 15px;
    }
    .bordeLight{
        font-weight: normal;
    }

    .error {
    border: 1px dashed #f00;
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

            {{-- DATOS PERSONALES --}}
            <div class="col-md-12" style="padding:0px">
                <div class="row" >
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
                            <textarea class="form-control"  id="observaciones" rows="2" placeholder="Observaciones" style="resize:none;border:none;"></textarea>
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


                    {{-- INSCRIPCIONES --}}
                    <div class="row">
                        <div class="col-md-4" style="margin-top: 10px;">
                            <label >Inscripciones: </label>
                        </div>
                        <div class="col-md-2" style="margin-top: 10px;">
                            <a href="#" style='text-decoration : none;color:gray' id="btn_inscripciones">+</a>
                        </div>
                    </div>
                    {{-- <label style="margin-top: 10px;">Inscripciones: </label> --}}
                    <div  class="col-md-12 border borde" >
                        {{-- Eunacom --}}
                        <div class="form-group row" style="margin-bottom:5px">
                            <label for="eunacom" class="col-md-2 col-form-label" style="font-weight: normal">Eunacom</label>
                            <div class="col-md-3" id="eunacom">
                                <select id="eunacom" class="form-control form-control-sm" name="eunacom">
                                <option>No lo tiene</option>
                                <option>Lo tiene</option>
                                <option>En proceso</option>
                            </select>
                            </div>
                        </div>

                        {{-- <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1">
                        <label class="form-check-label" for="inlineRadio1">1</label>
                        </div>
                        <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2">
                        <label class="form-check-label" for="inlineRadio2">2</label>
                        </div>
                        <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio3" value="option3" disabled>
                        <label class="form-check-label" for="inlineRadio3">3 (disabled)</label>
                        </div> --}}

                        {{-- conacem --}}
                        <div class="form-group row" style="margin-bottom:5px">
                            <label for="conacem" class="col-sm-2 col-form-label" style="font-weight: normal">Conacem</label>
                            <div class="col-md-3" id="conacem">
                                <select id="conacem" class="form-control form-control-sm" name="conacem">
                                <option>No lo tiene</option>
                                <option>Lo tiene</option>
                                <option>En proceso</option>
                            </select>
                            </div>
                        </div>
                        {{-- supersalud --}}
                        <div class="form-group row" style="margin-bottom:5px">
                            <label for="supersalud" class="col-sm-2 col-form-label" style="font-weight: normal">Super salud</label>
                            <div class="col-md-3" id="supersalud">
                                <select id="supersalud" class="form-control form-control-sm" name="supersalud">
                                <option>Inscrito</option>
                                <option>No inscrito</option>
                            </select>
                            </div>
                        </div>
                    </div>

                    {{-- EXPERIENCIA --}}
                    <div class="row">
                        <div class="col-md-4" style="margin-top: 10px;">
                            <label >Experiencia: </label>
                        </div>
                        <div class="col-md-2" style="margin-top: 10px;">
                            <a href="#" style='text-decoration : none;color:gray' id="btn_experiencia">+</a>
                        </div>
                    </div>
                    {{-- <label style="margin-top: 10px;">Experiencia: </label> --}}
                    <div  class="col-md-12 border borde" >
                        <div class="row" style="margin-bottom: 10px">
                            <div class="col-md-2" >
                                Años\Meses
                            </div>
                            <div class="col-md-2" >
                                Periodo
                            </div>
                            <div class="col">
                                Servicio clinico de desempeño
                            </div>
                            <div class="col">
                                Lugar de Trabajo
                            </div>
                            <div class="col-xs-3" >
                                <div>
                                    <span style="font-size: 20px; color: rgb(255, 30, 30); ">
                                        <i class="fas fa-minus-circle remove_fecha text-danger" style="visibility:hidden "></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="experiencia">

                            <div id="divRow0" class="clonerow">
                                <div class="row fila_completa" id="innerDivRow0">
                                    {{-- TIEMPO --}}
                                    <div class="col-md-2">
                                        {{-- <select name="tiempoTipo" class="form-control fila_select tiempoTipo"> --}}
                                        <select  class="form-control fila_select tiempoTipo">
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
                                        <input type="text"  class="form-control servicioClinico" required>
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
                        </div>
                    </div>

                    {{-- CAPACITACIONES --}}
                    {{-- <label style="margin-top: 10px;">Capacitaciones: </label>
                    <div  class="col-md-12 border borde" >
                    </div> --}}

                    {{-- CAPACITACIONES --}}
                    <div class="row">
                        <div class="col-md-4" style="margin-top: 10px;">
                            <label >Capacitaciones: </label>
                        </div>
                        <div class="col-md-2" style="margin-top: 10px;">
                            <span class="btn" style='text-decoration : none;color:gray' id="btn_capacitaciones">+</span>
                        </div>
                    </div>
                    <div  class="col-md-12 border borde" >
                        {{-- IAAS --}}
                        <div class="form-group row" style="margin-bottom:5px">
                            <label for="iaas" class="col-md-5 col-form-label" style="font-weight: normal;margin-top:-3px">Curso IAAS</label>
                            <div class="col-md-2">
                                <select id="iaas" name="iaas" class="form-control form-control-sm " >
                                <option value="si">Si</option>
                                <option value="no" selected>No</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select id="iaasCurso" name="iaasCurso" class="form-control form-control-sm " style="display: none">
                                <option value="curso">Curso</option>
                                <option value="diplomado">Diplomado</option>
                                </select>
                            </div>
                        </div>
                        {{-- RCP --}}
                        <div class="form-group row" style="margin-bottom:5px">
                            <label for="rcp" class="col-md-5 col-form-label" style="font-weight: normal;margin-top:-3px">Curso RCP</label>
                            <div class="col-md-2" >
                                <select id="rcp" name="rcp" class="form-control form-control-sm ">
                                <option value="si">Si</option>
                                <option value="no" selected>No</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select id="rcpCurso"  name="rcpCurso" class="form-control form-control-sm " style="display: none">
                                    <option value="curso">Curso</option>
                                    <option value="diplomado">Diplomado</option>
                                </select>
                            </div>
                        </div>
                        {{-- MANEJO PACIENTE CRITICO --}}
                        <div class="form-group row" style="margin-bottom:5px">
                            <label for="pacienteCritico" class="col-md-5 col-form-label" style="font-weight: normal;margin-top:-3px">Manejo paciente critico</label>
                            <div class="col-md-2">
                                <select id="pacienteCritico" name="pacienteCritico" class="form-control form-control-sm">
                                <option value="si">Si</option>
                                <option value="no" selected>No</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select id="pacienteCriticoCurso" name="pacienteCriticoCurso" class="form-control form-control-sm" style="display: none" >
                                    <option value="curso">Curso</option>
                                    <option value="diplomado">Diplomado</option>
                                </select>
                            </div>
                        </div>
                        {{-- MANEJO VENTILADOR MECANICO --}}
                        <div class="form-group row" style="margin-bottom:5px">
                            <label for="ventilacion" class="col-md-5 col-form-label" style="font-weight: normal;margin-top:-3px">Manejo ventilador mecanico</label>
                            <div class="col-md-2" >
                                <select id="ventilacion" name="ventilacion" class="form-control form-control-sm">
                                <option value="si">Si</option>
                                <option value="no" selected>No</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select id="ventilacionCurso" name="ventilacionCurso" class="form-control form-control-sm" style="display: none">
                                    <option value="curso">Curso</option>
                                    <option value="diplomado">Diplomado</option>
                                </select>
                            </div>
                        </div>
                        {{-- INDUCCION GENERAL A LA ADMINISTRACION DEL ESTADO --}}
                        <div class="form-group row" style="margin-bottom:5px">
                            <label for="adminEstado" class="col-md-5 col-form-label" style="font-weight: normal;margin-top:-3px">Induccion a la administracion del estado</label>
                            <div class="col-md-2">
                                <select id="adminEstado"  name="adminEstado" class="form-control form-control-sm">
                                <option value="si">Si</option>
                                <option value="no" selected>No</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select id="adminEstadoCurso" name="adminEstadoCurso" class="form-control form-control-sm" style="display: none">
                                    <option value="curso">Curso</option>
                                    <option value="diplomado">Diplomado</option>
                                </select>
                            </div>
                        </div>
                        {{-- ATENCION EN URGENCIA EMERGENCIA Y DESASTRES --}}
                        <div class="form-group row" style="margin-bottom:5px">
                            <label for="urgenciaDesastres" class="col-md-5 col-form-label" style="font-weight: normal;margin-top:-3px">Atencion urgencia emergencia y desastres</label>
                            <div class="col-md-2">
                                <select id="urgenciaDesastres" name="urgenciaDesastres" class="form-control form-control-sm">
                                <option value="si">Si</option>
                                <option value="no" selected>No</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select id="urgenciaDesastresCurso" name="urgenciaDesastresCurso" class="form-control form-control-sm" style="display: none">
                                    <option value="curso">Curso</option>
                                    <option value="diplomado">Diplomado</option>
                                </select>
                            </div>
                        </div>
                        {{-- ATENCION Y CUIDADOS DEL ADULTO MAYOR --}}
                        <div class="form-group row" style="margin-bottom:5px">
                            <label for="adultoMayor" class="col-md-5 col-form-label" style="font-weight: normal;margin-top:-3px">Atencion y cuidados del adulto mayor</label>
                            <div class="col-md-2">
                                <select id="adultoMayor" name="adultoMayor" class="form-control form-control-sm">
                                <option value="si">Si</option>
                                <option value="no" selected>No</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select id="adultoMayorCurso" name="adultoMayorCurso" class="form-control form-control-sm" style="display: none">
                                    <option value="curso">Curso</option>
                                    <option value="diplomado">Diplomado</option>
                                </select>
                            </div>
                        </div>
                        {{-- MANEJO CLINICO DE INFECCIONES RESPIRATORIAS --}}
                        <div class="form-group row" style="margin-bottom:5px">
                            <label for="infeccionesRespiratorias" class="col-md-5 col-form-label" style="font-weight: normal;margin-top:-3px">Manejo clinico de infecciones respiratorias</label>
                            <div class="col-md-2">
                                <select id="infeccionesRespiratorias" name="infeccionesRespiratorias" class="form-control form-control-sm">
                                <option value="si">Si</option>
                                <option value="no" selected>No</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select id="infeccionesRespiratoriasCurso" name="infeccionesRespiratoriasCurso" class="form-control form-control-sm" style="display: none">
                                    <option value="curso">Curso</option>
                                    <option value="diplomado">Diplomado</option>
                                </select>
                            </div>
                        </div>
                        {{-- IRA: INFECCIONES RESPIRATORIAS DEL NINO --}}
                        <div class="form-group row" style="margin-bottom:5px">
                            <label for="ira" class="col-md-5 col-form-label" style="font-weight: normal;margin-top:-3px">Infecciones respiratorias del niño</label>
                            <div class="col-md-2">
                                <select id="ira" name="ira" class="form-control form-control-sm">
                                <option value="si">Si</option>
                                <option value="no" selected>No</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select id="iraCurso" name="iraCurso" class="form-control form-control-sm" style="display: none">
                                    <option value="curso">Curso</option>
                                    <option value="diplomado">Diplomado</option>
                                </select>
                            </div>
                        </div>
                        {{-- ERA: ENFERMEDADES RESPIRATORIAS DEL ADULTO --}}
                        <div class="form-group row" style="margin-bottom:5px">
                            <label for="era" class="col-md-5 col-form-label" style="font-weight: normal;margin-top:-3px">Infecciones respiratorias del adulto</label>
                            <div class="col-md-2">
                                <select id="era"  name="era" class="form-control form-control-sm">
                                <option value="si">Si</option>
                                <option value="no" selected>No</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select id="eraCurso" name="eraCurso" class="form-control form-control-sm" style="display: none">
                                    <option value="curso">Curso</option>
                                    <option value="diplomado">Diplomado</option>
                                </select>
                            </div>
                        </div>
                        {{-- CURSO COVID 19 --}}
                        <div class="form-group row" style="margin-bottom:5px">
                            <label for="covid19" class="col-md-5 col-form-label" style="font-weight: normal;margin-top:-3px">Curso COVID-19</label>
                            <div class="col-md-2">
                                <select id="covid19" name="covid19" class="form-control form-control-sm">
                                <option value="si">Si</option>
                                <option value="no" selected>No</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select id="covid19Curso" name="covid19Curso" class="form-control form-control-sm" style="display: none">
                                    <option value="curso">Curso</option>
                                    <option value="diplomado">Diplomado</option>
                                </select>
                            </div>
                        </div>
                        {{-- OTRO --}}
                        <div class="form-group row" style="margin-bottom:5px">
                            <label for="otro" class="col-md-5 col-form-label" style="font-weight: normal;margin-top:-3px">Otros</label>
                            <div class="col-md-2">
                                <select id="otro" name="otro" class="form-control form-control-sm">
                                <option value="si">Si</option>
                                <option value="no" selected>No</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <input type="text" class="form-control form-control-sm" id="otroCurso" name="otroCurso" style="display: none">
                            </div>
                        </div>

                    </div>

                    {{-- OBSERVACIONES --}}
                    {{-- <div style="margin-bottom: 10px">
                        <label for="observaciones">Observaciones</label>
                        <textarea class="form-control" name="observaciones" id="observaciones" rows="5" placeholder="Observaciones"></textarea>
                    </div> --}}

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
        function enviar(){
            console.log("aprete");
            $("#formularioComplementar").submit();
        };
        function esVacio(obj){
            return obj.servicioClinico==='';
        }
    $(document).ready(function() {

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
            $('.fila_completa .form-control ').removeClass('error');
            experiencias = [];

            var error=0;
            // e.preventDefault();
            $('.fila_completa').each(function(index, element) {


                if($(this).find('.servicioClinico').val()==""){
                    error++,$(this).find('.servicioClinico').addClass('error');
                }
                if($(this).find('.lugarTrabajo').val()==""){
                    error++,$(this).find('.lugarTrabajo').addClass('error');
                }


                if($(this).find('.tiempoPeriodo').val()==""){
                    error++,$(this).find('.tiempoPeriodo').addClass('error');
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

            if(error!=0){
                console.log('hay errores en el fomulario');
                return false;
            }else{
                //  console.log("fila "+JSON.stringify(experiencias));
                $('#experiencias_input').val(JSON.stringify(experiencias));
                console.log("experienncias "+$('#experiencias_input').val() );
                experiencias = [];
                $(".formulario_complementar").submit();
            }

        });

        $('#iaas').change(function(e) {
            value = e.target.value;
            if (value=='si') {
                $('#iaasCurso').fadeIn();
            } else {
                $('#iaasCurso').fadeOut();
            }
        });
        $('#rcp').change(function(e) {
            value = e.target.value;
            if (value=='si') {
                $('#rcpCurso').fadeIn();
            } else {
                $('#rcpCurso').fadeOut();
            }
        });
        $('#pacienteCritico').change(function(e) {
            value = e.target.value;
            if (value=='si') {
                $('#pacienteCriticoCurso').fadeIn();
            } else {
                $('#pacienteCriticoCurso').fadeOut();
            }
        });
        $('#ventilacion').change(function(e) {
            value = e.target.value;
            if (value=='si') {
                $('#ventilacionCurso').fadeIn();
            } else {
                $('#ventilacionCurso').fadeOut();
            }
        });
        $('#adminEstado').change(function(e) {
            value = e.target.value;
            if (value=='si') {
                $('#adminEstadoCurso').fadeIn();
            } else {
                $('#adminEstadoCurso').fadeOut();
            }
        });
        $('#urgenciaDesastres').change(function(e) {
            value = e.target.value;
            if (value=='si') {
                $('#urgenciaDesastresCurso').fadeIn();
            } else {
                $('#urgenciaDesastresCurso').fadeOut();
            }
        });
        $('#adultoMayor').change(function(e) {
            value = e.target.value;
            if (value=='si') {
                $('#adultoMayorCurso').fadeIn();
            } else {
                $('#adultoMayorCurso').fadeOut();
            }
        });
        $('#infeccionesRespiratorias').change(function(e) {
            value = e.target.value;
            if (value=='si') {
                $('#infeccionesRespiratoriasCurso').fadeIn();
            } else {
                $('#infeccionesRespiratoriasCurso').fadeOut();
            }
        });
        $('#ira').change(function(e) {
            value = e.target.value;
            if (value=='si') {
                $('#iraCurso').fadeIn();
            } else {
                $('#iraCurso').fadeOut();
            }
        });
        $('#era').change(function(e) {
            value = e.target.value;
            if (value=='si') {
                $('#eraCurso').fadeIn();
            } else {
                $('#eraCurso').fadeOut();
            }
        });
        $('#covid19').change(function(e) {
            value = e.target.value;
            if (value=='si') {
                $('#covid19Curso').fadeIn();
            } else {
                $('#covid19Curso').fadeOut();
            }
        });
        $('#otro').change(function(e) {
            value = e.target.value;
            if (value=='si') {
                $('#otroCurso').fadeIn();
            } else {
                $('#otroCurso').fadeOut();
            }
        });



    });

  </script>
