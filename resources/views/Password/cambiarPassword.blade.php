<div id="modalPassword" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Formulario cambio de pasword</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <div class="">
                    <div class="col-md-10" style="margin:auto">
                        <form action="{{route('user.cambiarpassword')}}" method="POST" id="form_cambiar_password">
                            <input type="hidden" id="usuario_id" name="usuario_id" value="{{$user->id}}">
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="password">Password actual</label>
                                    <input type="password" name="password_a" id="password_a" class="form-control" value="">
                                    <span id="password_a_span" class="spanclass" style="color:red"></span>
                                </div>
                                <div class="col-md-12">
                                    <label for="password">Password nueva</label>
                                    <input type="password" name="password" id="password" class="form-control" value="">
                                    <span id="password_span" class="spanclass" style="color:red"></span>
                                </div>
                                <div class="col-md-12">
                                    <label for="password_confirmation">Repita password</label>
                                    <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" value="">
                                    <span id="password_a_span" class="spanclass" style="color:red"></span>
                                </div>
                                <div class="col-md-12 mt-3">
                                    <button type="submit" class="btn btn-info float-right">Cambiar</button>
                                </div>
                            </div>
                            @csrf
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modal footer -->
            <!-- <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
            </div> -->

        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $(".verinfo").attr('disabled', false);
    });

    $('#form_cambiar_password').on('submit', function(e) {
        e.preventDefault();
        var form = $(this);
        var url = form.attr('action');
        console.log(form, url);

        $.ajax({
            type: "POST",
            url: url,
            data: form.serialize(),
            success: function(data) {
                if (data == 'password_actualizada') {
                    Swal.fire({
                        type: 'success',
                        title: 'Password actualizada correctamente!',
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