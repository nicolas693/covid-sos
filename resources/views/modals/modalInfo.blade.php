<div id="modalInfo" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Información de profesional en este modal</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <div class="row">
          <div class="col-md-10">
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
        </div>
      </div>



      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
      </div>

    </div>
  </div>
</div>