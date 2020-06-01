@extends('layouts.master-top')
@section('content')


<script src="https://cdn.datatables.net/responsive/2.2.4/js/dataTables.responsive.min.js"></script>
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


<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1>Inicio</h1>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                                    <li class="breadcrumb-item"><a href="#">Página 1</a></li>
                                    <li class="breadcrumb-item active">Página 2</li>
                                </ol>
                            </div>
                        </div>
                    </div><!-- /.container-fluid -->
                </section>

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">VISTA CALL CENTER</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                <i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="card-body">

                        <table class="table table-sm nowrap" id="tabla_reclutador" style="width: 100%;">
                            <thead class="bold">
                                <tr>
                                    <td>Nombre</td>
                                    <td>Profesion</td>
                                    <td>Titulo</td>
                                    <td>Especialidad</td>
                                    <td>Horas Sem.</td>
                                    <td>Estado</td>
                                    <td>Telefono</td>
                                    <td>E-mail</td>
                                    <td>Acción</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($profesionales as $key => $pro)
                                <tr>
                                    <td>{{$pro->nombre}}</td>
                                    <td>{{$pro->tipo_profesional}}</td>
                                    <td>{{$pro->estado_titulo}}</td>
                                    <td>{{$pro->especialidad}}</td>
                                    <td>{{$pro->horas}}</td>
                                    <td>{{$pro->estado}}</td>
                                    <td>{{$pro->telefono}}</td>
                                    <td>{{$pro->email}}</td>
                                    <td>
                                        <button type="button" class="btn btn-info btn-sm" name="{{$pro->id}}"  title="Información Profesional" onclick="verInfo(this.name)"><i class="fas fa-info-circle"></i></button>
                                        <button type="button" class="btn btn-success btn-sm" name="{{$pro->id}}"  title="Asignar Profesional"><i class="fas fa-plus"></i></button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
    </div>
    <div id="modal"></div>
</section>
<script>
    $(document).ready(function() {
        $('#tabla_reclutador').DataTable({
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
            },
            "columns": [
        null,
        null,
        null,
        null,
        null,
        null,
        null,
        null,
        null, //Added New

        // {"orderable": false, "width":"2%"},
    ],
        });
    });
    function verInfo(id) {
        $(".CC").attr('disabled', true);
        ruta = @json(route('callcenter.verinfo', ['id' => 'id']));
        ruta = ruta.replace('id', id);
        console.log(ruta);
        $('.modal').modal('hide');
        $.get(ruta, function(data) {
            $('#modal').html(data);
            $('#modalInfo').modal('show');
        });

   };


</script>
@endsection
