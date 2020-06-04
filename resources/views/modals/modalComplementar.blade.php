<!-- Select2 -->
<link rel="stylesheet" href="{{asset('/plugins/select2/css/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">


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
</style>

<div id="modalComplementar" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Complementar datos Postulante</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">

            {{-- DATOS PERSONALES --}}
            <label>Datos del Profesional:</label>
            <div class="col-md-12 border" >
                <table style="width: 100%;">
                    <tbody>
                    <tr>
                        <td>Nombre :</td>
                        <td>{{$profesional->nombre}}</td>
                    </tr>
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
                    <tr>
                        <td>E-mail :</td>
                        <td>{{$profesional->email}}</td>
                    </tr>

                    <tr>
                        <td>Preferencias de comuna :</td>
                        <td>{{$profesional->getComunasPreferenciaString()}}</td>
                    </tr>

                    </tbody>
                </table>
            </div>

            {{-- DATOS COMPLEMENTARIOS --}}
            <form action="{{route('asignacion.guardar')}}" method="post" class="formulario_asignacion">
                @csrf
                <input type="hidden" name="profesional_id" value={{$profesional->id}}>
                <input type="hidden" id="estado_id" name="estado" value="{{$profesional->estado}}">
                <input type="hidden" id="user_id" name="user_id" value="">
                <input type="hidden" id="establecimiento_id" name="establecimiento_id" value="null">
                <input type="hidden" id="modo" name="modo" value="">

                {{-- INSCRIPCIONES --}}
                <label style="margin-top: 10px;">Inscripciones: </label>
                <div  class="col-md-12 border borde" >
                    {{-- Eunacom --}}
                    <div class="form-group row" style="margin-bottom:10px">
                        <label for="eunacom" class="col-md-2 col-form-label" style="font-weight: normal">Eunacom</label>
                        <div class="col-md-6" id="eunacom">
                            <select id="inputState" class="form-control">
                            <option>No lo tiene</option>
                            <option>Lo tiene</option>
                            <option>En proceso</option>
                          </select>
                        </div>
                    </div>
                    {{-- conacem --}}
                    <div class="form-group row" style="margin-bottom:10px">
                        <label for="conacem" class="col-sm-2 col-form-label" style="font-weight: normal">Conacem</label>
                        <div class="col-md-6" id="conacem">
                            <select id="inputState" class="form-control">
                            <option>No lo tiene</option>
                            <option>Lo tiene</option>
                            <option>En proceso</option>
                          </select>
                        </div>
                    </div>
                    {{-- supersalud --}}
                    <div class="form-group row" style="margin-bottom:5px">
                        <label for="supersalud" class="col-sm-2 col-form-label" style="font-weight: normal">Super salud</label>
                        <div class="col-md-6" id="supersalud">
                            <select id="inputState" class="form-control">
                            <option>Inscrito</option>
                            <option>No inscrito</option>
                          </select>
                        </div>
                    </div>
                </div>
                {{-- EXPERIENCIA --}}
                <label style="margin-top: 10px;">Experiencia: </label>


{{-- Meses de experiencia	Años de experiencia	Servicio clínico de desempeño	Lugar de trabajo --}}


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
                                    <select name="tiempoTipo" class="form-control fila_select">
                                        <option value="años">Años</option>
                                        <option value="meses">Meses</option>
                                    </select>
                                </div>
                                {{-- CANTIDAD DE TIEMPO --}}
                                <div class="col-md-2">
                                    <input type="number" name="cantidadTiempo" class="form-control" min="1" max="10">
                                </div>

                                {{-- SERVICIO CLINICO DE DESEMPEÑO --}}
                                <div class="col">
                                    <input type="text" name="servicioClinico" class="form-control">
                                </div>

                                {{-- LUGAR DE TRABAJO--}}
                                <div class="col">
                                    <input type="text" name="lugarTrabajo" class="form-control">
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
                <label style="margin-top: 10px;">Capacitaciones: </label>
                <div  class="col-md-12 border borde" >
                </div>
                {{-- OBSERVACIONES --}}
                <div style="margin-bottom: 10px">
                    <label for="observaciones">Observaciones</label>
                    <textarea class="form-control" name="observaciones" id="observaciones" rows="5" placeholder="Observaciones"></textarea>
                </div>

            </form>
        </div>

        <!-- Modal footer -->
        <div class="modal-footer botones">
            <div>
                <button class="btn btn-primary" onclick="enviar()">Guardar</button>
                <span class="text-danger" id="error_establecimiento" style="display: none">Este profesional ya se encuantra asignado a otro establecimiento</span>
            </div>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
        </div>

      </div>
    </div>
  </div>



  <script>
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
            // e.preventDefault();
            $(wrapper).append(clone); //add input box
                    // $(wrapper).append('<div><input type="text" name="mytext[]"/><a href="#" class="remove_field">Remove</a></div>'); //add input box
        });


        $(remove_button).click(function(e) {
            // console.log(Array.from($('.fila_select, .fila_inicio').get(), e => e.value));
            // console.log($('.fila_completa').length);
            // console.log($(this).parentsUntil('.clonerow'));
            $(this).parentsUntil('.experiencia').remove();
        })

    });

// $(document).ready(function() {

//     var estado_original=$("#estado_id).val();

//     // if(estado_original=="disponible"){
//     //     $('#caja_establecimiento').css({"display":"block"});
//     // };

//     // if(estado_original=="no disponible"){
//     //     $('#caja_estado').css({"display":"block"});
//     // }
//     // if(estado_original=="contratado"){
//     //     $('#caja_estado').css({"display":"block"});
//     // }

// });

    // var estado_original=$("#estado_id").val();

    // if(estado_original=="disponible"){
    //     $('#caja_establecimiento').css({"display":"block"});
    //     $("#modo").val("establecimiento");

    // };
    // if(estado_original=="no disponible"){
    //     $('#caja_estado').css({"display":"block"});
    //     $("#modo").val("estado");
    // }
    // if(estado_original=="contratado"){
    //     $('#caja_estado').css({"display":"block"});
    //     $("#modo").val("estado");
    // }

    // $('input[type=radio][name=accion]').change(function() {
    //     if (this.value == 'establecimiento') {
    //         $('#caja_estado').css({"display":"none"});
    //         $('#caja_establecimiento').css({"display":"block"});
    //     }
    //     else {
    //         $('#caja_establecimiento').css({"display":"none"});
    //         $('#caja_estado').css({"display":"block"});
    //     }
    // });

    // $("#establecimiento").select2({
    //     placeholder: "Seleccione establecimiento",
    //     allowClear: true,
    //     minimumInputLength: 3,
    //     formatInputTooShort: function() {
    //         return "Ingrese 3 o más caracteres para la búsqueda";
    //     },
    //     ajax: {
    //         url: "{{ route('live_search.establecimientos') }}",
    //         data: function(params) {

    //             var query = {
    //                 name: params.term,
    //             }
    //             return query;
    //         },
    //         processResults: function(data) {
    //             console.log(data);
    //             return {
    //                 results: data
    //             };
    //         }
    //     },
    //     initSelection: function(element, callback) {
    //         cod_est_e = document.getElementById('cod_establecimiento').value;
    //         tx_est_e = document.getElementById('tx_establecimiento').value;

    //         callback({
    //             id: cod_est_e,
    //             text: tx_est_e
    //         });
    //     }
    // });

    // studentSelect = $("#establecimiento");
    // var option = new Option(tx_est_e, cod_est_e, true, true);
    // studentSelect.append(option).trigger('change');

    // $('.select2-selection--single').css('height', 'calc(2.25rem + 2px)');

    // function enviar(){
    //     console.log($("#estado_id").val());
    //     var seleccion=$("input[name='accion']:checked").val();

    //     if(seleccion=="establecimiento"){
    //         $("#establecimiento_id").val($("#establecimiento").val());

    //     }
    //     if(seleccion=="estado"){
    //         $("estado_id").val($("#estadoProfesional").val());
    //     }

    //     if($("#estado_id").val()=="ya asignado"){
    //         $("#error_establecimiento").css({"display":"inline"});
    //     }else{
    //         $(".formulario_asignacion").submit();
    //     }

    // }

  </script>
