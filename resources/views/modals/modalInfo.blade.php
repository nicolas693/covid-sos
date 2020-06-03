<style>
   .botones {
margin-top: 10px;
  display:flex;
  justify-content:space-around;
}
.btn_info {
  width: 100%;
}
/* table, th, td {
  border: 1px solid black;
} */
</style>

<div id="modalInfo" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Información del postulante</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <div class="">
          <div class="col-md-10" style="margin:auto">
            <table style="width:100%">
                <tbody>
                    <tr>
                    <td><strong> Nombre :</strong></td>
                    <td class="border" style="padding-left:10px">{{$profesional->nombre}}</td>
                    </tr>
                    <tr>
                    <td><strong> Nacionalidad :</strong></td>
                    <td class="border" style="padding-left:10px">{{$profesional->getPais()->tx_descripcion}}</td>
                    </tr>
                    <tr>
                    <td><strong> Comuna de residencia :</strong></td>
                    <td class="border" style="padding-left:10px">{{ $profesional->getComunasResidencia()->tx_descripcion}}</td>
                    </tr>
                    <tr>
                    <td><strong> Número Telefónico :</strong></td>
                    <td class="border" style="padding-left:10px">{{$profesional->telefono}}</td>
                    </tr>
                    <tr>
                    <td><strong> E-mail :</strong></td>
                    <td class="border" style="padding-left:10px">{{$profesional->email}}</td>
                    </tr>

                    <tr>
                        <td><strong> Título Profesional :</strong></td>
                        <td class="border" style="padding-left:10px">{{$profesional->getTitulo()->tx_descripcion}}</td>
                    </tr>
                    <tr>
                        <td><strong> Estado Titulacion :</strong></td>
                        <td class="border" style="padding-left:10px">{{$profesional->getEstadoTitulo()->tx_descripcion}}</td>
                    </tr>
                    <tr>
                        <td><strong> Especialidad :</strong></td>
                        @if($profesional->getEspecialidad()!='vacio')
                        <td class="border" style="padding-left:10px">{{$profesional->getEspecialidad()->tx_descripcion}}</td>
                        @else
                        <td class="border" style="padding-left:10px">SIN ESPECIALIDAD</td>
                        @endif
                    </tr>

                    <tr>
                    <td><strong> Comuna de preferencia laboral :</strong></td>
                    <td class="border" style="padding-left:10px;">{{$profesional->getComunasPreferenciaString()}}</td>
                    </tr>

                    <tr>
                    <td><strong> Disponibilidad :</strong></td>
                    @php $d = $profesional->getDisponibilidad(); $m=$profesional->getModalidad(); @endphp
                    @if($d!='' && $m!='')
                    <td class="border" style="padding-left:10px">{{$profesional->getDisponibilidad()}} de {{$profesional->getModalidad()}} horas </td>
                    @else
                    <td class="border" style="padding-left:10px">Sin Información</td>
                    @endif
                    </tr>

                    <tr>
                    <td><strong> Estado del postulante :</strong></td>
                    @switch($profesional->estado)
                    @case("disponible")
                    <td class="text-success border" style="padding-left:10px"><strong>{{strtoupper($profesional->estado)}}</strong></td>
                    @break
                    @case("no disponible")
                    <td class="text-danger border" style="padding-left:10px"><strong>{{strtoupper($profesional->estado)}}</strong></td>
                    @break
                    @case("contratado")
                    <td class="text-warning border" style="padding-left:10px"><strong>{{strtoupper($profesional->estado)}}</strong></td>
                    @break
                    @endswitch
                    </tr>

                    @if($asignacion!=null)
                    <tr>
                    <td><strong> Establecimiento asignado :</td>
                    <td class="border" style="padding-left:10px; padding-right:10px">{{$asignacion->getNombreEstablecimiento()}}</td>
                    </tr>
                    <tr>
                    <td><strong>Observacion :</strong></td>
                    <td class="border" style="padding-left:10px">{{$asignacion->observaciones}}</td>
                    </tr>
                    @else
                    @endif
                </tbody>
            </table>
          </div>

          @if($tiene_doc=='1')
          <div class="col-md-9" style="margin:auto;margin-top:30px" >
            <div class="row" style="display:flex;justify-content:space-around">
              @if($tiene_cert=='1')
              <div class="col-md-4 ">
                <a class="btn btn-info btn_info" href="{{route('descargar.certificado',['id'=> $profesional->id])}}"><i class="fas fa-download"></i> Certificado Título</a>
              </div>
              @endif

              @if($tiene_ci=='1')
              <div class="col-md-4 ">
                <a class="btn btn-success btn_info" href="{{route('descargar.cedula',['id'=> $profesional->id])}}"><i class="fas fa-download"></i> Cedula Identidad</a>
              </div>
              @endif

              @if($tiene_cv=='1')
              <div class="col-md-4 ">
                <a class="btn btn-default btn_info" href="{{route('descargar.curriculum',['id'=> $profesional->id])}}"><i class="fas fa-download"></i> Curriculum</a>
              </div>
              @endif
            </div>
          </div>
          @endif
        </div>
      </div>



      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
      </div>

    </div>
  </div>
</div>

<script>
  $(document).ready(function() {
    $(".verinfo").attr('disabled', false);
  });
//   $(document).ready(function() {
//     $(".asignar").attr('disabled', false);
//   });
</script>
