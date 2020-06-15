@extends('layouts.master-top')
@section('content')
<style>
    .toastr-margin {
        margin-top: 25px;
    }

    .toast-message {
        font-size: 15px !important;
    }

    .toast-warning {
        background-color: #eb990c !important
    }

    #toast-container>div {
        opacity: 1;
        margin-top: 25%;
    }

    .bold {
        font-weight: bold !important;
    }
</style>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 offset-md-2 ">

                <div class="card mt-5">
                    <div class="card-header">
                        <h3 class="card-title">Información de postulación</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                <i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-sm nowrap" id="tabla_usuarios" style="width: 100%;">
                                    <thead class="bold">
                                        <tr>
                                            <td>Nombre</td>
                                            <td>E-mail</td>
                                            <td>Tipo de usuario</td>
                                            <td>Acción</td>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach($users as $key => $u)
                                        <tr>
                                            <td>{{$u->name}}</td>
                                            <td>{{$u->email}}</td>
                                            <td>{{$u->obtenerTipoUsuario()}}</td>
                                            <td>
                                                <button type="button" class="btn btn-warning border border-dark btn-sm" onclick="editarUsuario(this.id)" id="{{route('admin.edit',['id'=> $u->id])}}" title="Editar"><i class="fas fa-user-edit"></i></button>
                                                <button type="button" class="btn btn-danger border border-dark btn-sm" id="{{route('admin.edit',['id',$u->id])}}" onclick="eliminarUsuario(this.id)" id="" title="Eliminar"><i class="far fa-trash-alt"></i></button>
                                            </td>
                                        </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
    </div>
    <div id="modal">

    </div>
</section>
<script>
    $(document).ready(function() {
        $('#tabla_usuarios').DataTable({
            responsive: true,
            language: {
                "lengthMenu": "Mostrar _MENU_ registros por página",
                "zeroRecords": "No se encontraron registros",
                "info": "Mostrando página _PAGE_ de _PAGES_",
                "infoEmpty": "No hay registros disponibles",
                "infoFiltered": "(filtered from _MAX_ total records)",
                "search": "Buscar:",
                "processing": "Consultando...",
                "paginate": {
                    "first": "Primera",
                    "last": "Ultima",
                    "next": "Siguiente",
                    "previous": "Anterior"
                },
            }
        });
    });

    function editarUsuario(url) {
        $(".asignar").attr('disabled', true);


        $('.modal').modal('hide');
        $.get(url, function(data) {
            //  console.log(data);
            $('#modal').html(data);
            $('#modalEdit').modal('show');
        });
    }
</script>
@endsection