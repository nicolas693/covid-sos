<!-- Select2 -->
<link rel="stylesheet" href="{{asset('/plugins/select2/css/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">

<div id="modalAsignacion" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Asignar Estado y Establecimiento</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
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

{{--
            @if($profesional->estado=="disponible")
                <label style="margin-top: 15px;">Asignar establecimiento: </label>
            @else
                <label style="margin-top: 15px;">Cambiar estado: </label>
            @endif --}}

            <label style="margin-top: 15px;">Cambiar estado: </label>
            <div  class="col-md-12 border">
                <form action="{{route('asignacion.guardar')}}" method="post" class="formulario_asignacion">

                 @csrf
                <input type="hidden" name="profesional_id" value={{$profesional->id}}>
                <input type="hidden" id="estado_id" name="estado" value="{{$profesional->estado}}">
                <input type="hidden" id="user_id" name="user_id" value="">
                <input type="hidden" id="establecimiento_id" name="establecimiento_id" value="null">
                <input type="hidden" id="modo" name="modo" value="">

                {{-- <div class="form-group" style="margin-top:10px">
                    <div class="form-check">
                        <input class="form-check-input" name="accion" type="radio" id="accion1" value="establecimiento" checked>
                        <label class="form-check-label" for="exampleRadios1">
                        Asignar Profesional a un Establecimiento
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="accion" type="radio" id="accion2" value="estado">
                        <label class="form-check-label" for="exampleRadios1">
                        Cambiar Estado del Profesional
                        </label>
                    </div>
                </div> --}}

                <input type="text" name="cod_establecimiento" id="cod_establecimiento" @if(old('cod_establecimiento')) value="{{ old('cod_establecimiento') }}" @else value="570" @endif hidden>
                <input type="text" name="tx_establecimiento" id="tx_establecimiento" @if(old('tx_establecimiento')) value="{{ old('tx_establecimiento') }}" @else value="Hospital San Juan de Dios (Santiago, Santiago)" @endif hidden>
                <input type="text" id="cd_servicio" name="cd_servicio" hidden>



                <div class="form-group" style="margin-top: 15px;display:none" id="caja_establecimiento">
                    <label>Seleccione Establecimiento <b style="color:red"><b style="color:red">(*)</b></b></label>
                    <div>
                        <select class="form-control select2" name="establecimiento" id="establecimiento" value="{{ old('establecimiento') }}">
                        </select>
                        @if ($errors->has('establecimiento'))
                        <span class="text-danger">{{ $errors->first('establecimiento') }}</span>
                        @endif
                    </div>
                </div>

                <div  class="form-group"  style="margin-top: 15px;display:none" id="caja_estado">
                    <label>Cambiar Estado Profesional <b style="color:red"><b style="color:red">(*)</b></b></label>
                    <div>
                        <select class="form-control" name="estadoProfesional" id="estadoProfesional" value="">
                            <option value="disponible" @if ($profesional->estado== "disponible")selected="selected"@endif>Disponible</option>
                            {{-- <option value="contratado"  @if ($profesional->estado== "contratado")selected="selected"@endif>Contratado</option> --}}
                            <option value="no disponible"  @if ($profesional->estado== "no disponible")selected="selected"@endif>No disponible</option>
                        </select>
                    </div>
                </div>


                <div style="margin-bottom: 10px">
                    <label for="observaciones">Observaciones</label>
                    <textarea class="form-control" name="observaciones" id="observaciones" rows="5" placeholder="Observaciones"></textarea>
                </div>

            </form>
            </div>
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


  <style>
    .botones {
        display: flex;
        justify-content: space-between;
    }
  </style>
  <script>
$(document).ready(function() {
    $(".asignar").attr('disabled', false);
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

    var estado_original=$("#estado_id").val();

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


$('#caja_estado').css({"display":"block"});
$("#modo").val("estado");


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

    $("#establecimiento").select2({
        placeholder: "Seleccione establecimiento",
        allowClear: true,
        minimumInputLength: 3,
        formatInputTooShort: function() {
            return "Ingrese 3 o más caracteres para la búsqueda";
        },
        ajax: {
            url: "{{ route('live_search.establecimientos') }}",
            data: function(params) {

                var query = {
                    name: params.term,
                }
                return query;
            },
            processResults: function(data) {
                console.log(data);
                return {
                    results: data
                };
            }
        },
        initSelection: function(element, callback) {
            cod_est_e = document.getElementById('cod_establecimiento').value;
            tx_est_e = document.getElementById('tx_establecimiento').value;

            callback({
                id: cod_est_e,
                text: tx_est_e
            });
        }
    });

    studentSelect = $("#establecimiento");
    var option = new Option(tx_est_e, cod_est_e, true, true);
    studentSelect.append(option).trigger('change');

    $('.select2-selection--single').css('height', 'calc(2.25rem + 2px)');

    function enviar(){
        console.log($("#estado_id").val());
        var seleccion=$("input[name='accion']:checked").val();

        if(seleccion=="establecimiento"){
            $("#establecimiento_id").val($("#establecimiento").val());

        }
        if(seleccion=="estado"){
            $("estado_id").val($("#estadoProfesional").val());
        }

        if($("#estado_id").val()=="ya asignado"){
            $("#error_establecimiento").css({"display":"inline"});
        }else{
            $(".formulario_asignacion").submit();
        }

    }

  </script>
