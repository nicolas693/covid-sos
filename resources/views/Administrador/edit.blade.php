<style>
    .botones {
        margin-top: 10px;
        display: flex;
        justify-content: space-around;
    }

    .btn_info {
        width: 100%;
    }

    /* table, th, td {
  border: 1px solid black;
} */
</style>

<div id="modalEdit" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Edición de usuario</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <div class="">
                    <div class="col-md-10" style="margin:auto">

                        <form action="{{route('admin.update')}}" method="POST" id="admin_update">

                            @csrf
                            <div class="row">
                                <input type="hidden" name="usuario_id" id="usuario_id" value="{{$user->id}}">
                                <div class="col-md-12">
                                    <label for="name">Nombre : </label>
                                    <input type="text" class="form-control" name="name" id="name" value="{{$user->name}}">
                                    @if ($errors->has('name'))
                                    <span class="text-danger" id="name_span">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>

                                <div class="col-md-12">
                                    <label for="name">Correo : </label>
                                    <input type="text" class="form-control" name="email" id="email" value="{{$user->email}}">
                                    @if ($errors->has('email'))
                                    <span class="text-danger" id="email_span">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>

                                <div class="col-md-12">
                                    <label for="select_tipo">Correo : </label>
                                    <select name="select_tipo" id="select_tipo" class="form-control select2">
                                        @foreach($user_type as $key => $ut)
                                        @if($user->user_type==$key)
                                        <option value="{{$key}}" selected>{{$ut}}</option>
                                        @else
                                        <option value="{{$key}}">{{$ut}}</option>
                                        @endif

                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-md-12 mt-3">
                                    <label for="radioPrimary1">
                                        Resetear password : <b style="color:red">(*)</b>
                                    </label>
                                    <div class="form-group clearfix">
                                        <div class="icheck-primary d-inline" style="margin-right:5%">
                                            <input type="radio" id="reset_si" name="reset_password" value="1" @if(old('reset_password')=="1" ) checked @endif>
                                            <label for="reset_si">
                                                Si
                                            </label>
                                        </div>
                                        <div class="icheck-primary d-inline" style="margin-right:5%">
                                            <input type="radio" id="reset_no" name="reset_password" value="0" @if(old('reset_password')=="0" ) checked @endif>
                                            <label for="reset_no">
                                                No
                                            </label>
                                        </div>
                                    </div>
                                    @if ($errors->has('reset_password'))
                                    <span class="text-danger">{{ $errors->first('reset_password') }}</span>
                                    @endif
                                </div>

                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-success">Guardar</button>
                                </div>
                            </div>

                        </form>

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

<script>
    $(document).ready(function() {});
    $('.select2').select2({});
    $('.select2-selection--single').css('height', 'calc(2.25rem + 2px)');

    $('#admin_update').on('submit', function(e) {
        e.preventDefault();
        var form = $(this);
        var url = form.attr('action');
        console.log(form, url);

        $.ajax({
            type: "POST",
            url: url,
            data: form.serialize(),
            success: function(data) {
                if (data == 'usuario_actualizado') {
                    Swal.fire({
                        type: 'success',
                        title: 'Usuario actualizado correctamente!',
                        showConfirmButton: false,
                        timer: 2500,
                        onClose: function() {
                            $('.modal').modal('hide');
                        },
                    });
                }
            },
            error: function(error) {
                spanErrores(error);

            }

        });
    });
    function insertAfter(el, referenceNode) {
        referenceNode.parentNode.insertBefore(el, referenceNode.nextSibling);
    }
    function spanErrores(error) {
        errores = error.responseJSON.errors;
        //obtiene los spans donde se muestran los errores de las validaciones y se setea el texto a vacio
        spans = document.getElementsByClassName("spanclass");
        for (let item in spans) {
            spans[item].innerHTML = "";
        }
        //itera sobre los errores de las validaciones
        for (let key in errores) {
            if (key == 'formulario_vacio') {
                Swal.fire({
                    type: 'error',
                    title: 'No puede ingresar un formulario sin información',
                    showConfirmButton: false,
                    timer: 2500,
                });
            } else {
                if (errores.hasOwnProperty(key)) {
                    //si el elemento ya existe solo agrega el texto de error
                    if (document.getElementById(key + "_span")) {
                        console.log(key + "_span");
                        var newEl = document.getElementById(key + "_span");
                        newEl.innerHTML = errores[key];
                    } else {
                        //para cada error se crea un objeto span con id y clase para identificarlas, además de que sean color rojo y agrega el texto dle error
                        var newEl = document.createElement('span');
                        newEl.setAttribute("id", key + "_span");
                        newEl.setAttribute("class", "spanclass " + key);
                        newEl.setAttribute("style", "color:red");
                        newEl.innerHTML = errores[key];
                        var ref = document.getElementById(key);
                        insertAfter(newEl, ref);
                    }
                }
            }

        }
    }
</script>