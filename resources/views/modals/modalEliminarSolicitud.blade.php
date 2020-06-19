

<div id="modalDelete" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="margin-top:10%">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">¿Desea eliminar esta solicitud?</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
          <form action="{{route('reclutador.eliminarSolicitud')}}" method="post" id="eliminarSolicitud">
            @csrf
            <input type="hidden" name="solicitud_id" value="{{$solicitud->id}}">
            <input type="hidden" name="reclutador_id" value="{{Auth::user()->id}}">

            <textarea class="form-control" rows="4" cols="50" name="motivo" required style="display: block;margin-left: auto;margin-right: auto;margin-top:25px " placeholder=" Debes Ingresar un Motivo de Eliminacion"></textarea>
            <div class="form-row text-center">
              <div class="col-sm-12" style="margin-top:4%">
                <div class="col-sm-4"></div>
                <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i> Eliminar</button>
                <!-- <button type="button" data-dismiss="modal" class="btn btn-default"><i class="fas fa-undo-alt"></i> Cancelar</button> -->
              </div>
            </div>
          </form>
        </div>

        <!-- Modal footer -->
        <!-- <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div> -->

      </div>
    </div>
  </div>

  <script>
    $(".btnEliminar").attr('disabled', false);

    // $("#eliminarSolicitud").submit(function(e) {

    // });
  </script>
