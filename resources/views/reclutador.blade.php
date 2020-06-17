@extends('layouts.master-top')


@section('content')


<script src="{{ URL::asset('/plugins/datatables/Responsive/js/dataTables2.responsive.min.js') }}"></script>
<script>
    $("#container_header").addClass("col-md-10");
</script>
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
            {{-- <div class="col-md-8 offset-md-2"> --}}
                <div class="col-md-11" style="margin-left:auto;margin-right:auto">
                <div class="card mt-5">
                    <div class="card-header">
                        <h3 class="card-title" style="margin-top:5px">Modulo Reclutador</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-primary btn-sm" onclick="crearSolicitud()" >
                                <i class="fas fa-plus"></i>
                                <span style="margin-left:5px">Crear Solicitud</span>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="col-md-12">
                            @if (session('status')=='created')
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <h5><i class="icon fas fa-check"></i> Atención!</h5>
                                El registro ha sido ingresado exitosamente!
                            </div>
                            @endif

                            @if (session('status')=='updated')
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <h5><i class="icon fas fa-check"></i> Atención!</h5>
                                El registro ha sido actualizado exitosamente!
                            </div>
                            @endif
                            @if (session('status')=='complementario')
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <h5><i class="icon fas fa-check"></i> Atención!</h5>
                                Los datos complementarios han sido actualizado exitosamente!
                            </div>
                            @endif
                        </div>
                        {{-- <table class="table table-sm nowrap" id="tabla_reclutador" style="width: 100%;"> --}}
                            <table  class="table table-striped table-bordered table-sm nowrap" id="modulo_reclutador" style="width: 100%">

                            <thead class="bold">
                                <tr>
                                    <td>Establecimiento</td>
                                    <td>Tipo Atencion</td>
                                    <td>Profecional</td>
                                    <td>Especialidad</td>
                                    <td>Experiencia</td>
                                    <td>Años</td>
                                    <td>Diurno/Turno</td>
                                    <td>Horas</td>
                                    <td>Capacitaciones</td>
                                    <td>Dias</td>
                                    <td>Inicio</td>
                                    <td>Termino</td>
                                    <td>Crecion</td>
                                    <td>Acción</td>
                                </tr>
                            </thead>


                            <tbody>
                                {{-- @foreach($solicitudes as $key => $solicitud)
                                <tr>
                                    <td>{{$solicitud->establecimiento}}</td>
                                    <td>{{$solicitud->atencion}}</td>
                                    <td>{{$solicitud->profesional}}</td>
                                    <td>{{$solicitud->jornada}}</td>
                                    <td>{{$solicitud->horas}}</td>
                                    <td>{{$solicitud->capacitacion}}</td>
                                    <td>{{$solicitud->dias}}</td>
                                    <td>{{$solicitud->inicio}}</td>
                                    <td>{{$solicitud->termino}}</td>
                                    <td>{{$solicitud->creacion}}</td>


                                    <td style="text-align:center">
                                        <button type="button" class="btn btn-info btn-sm verinfo" name="{{$solicitud->id}}"  title="Información solicitudfesional" onclick="verInfo(this.name)"><i class="fas fa-info-circle"></i></button>
                                        <button type="button" class="btn btn-primary btn-sm complementar" name="{{$solicitud->id}}"  onclick="complementarsolicitudfesional(this.name)"title="Asignar solicitudfesional"><i class="fas fa-user-md"></i></button>

                                        <button type="button" class="btn btn-success btn-sm asignar" name="{{$solicitud->id}}"  onclick="asignarsolicitudfesional(this.name)"title="Asignar solicitudfesional"><i class="fas fa-plus"></i></button>

                                    </td>
                                </tr>
                                @endforeach --}}

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
    </div>
    <div id="modal">
        @include('modals.modalSolicitud', ['user' =>$usuario = Auth::user()])
    </div>
</section>
<script>
    $(document).ready(function() {
        $('#modulo_reclutador').DataTable({
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
        null,
        null,
        null,
        null,
        null,
        null, //Added New

        // {"orderable": false, "width":"2%"},
    ],
        });


        mensaje = @json(session()->get('message'));
        if (mensaje == 'creado') {
            Swal.fire({
                type: 'success',
                title: 'Postulante creado exitosamente!',
                showConfirmButton: false,
                timer: 2500,
                onClose: function() {
                    $('.modal').modal('hide');
                    $(".REV").attr('disabled', false);
                },
            });
        }

        if (mensaje == 'error al buscar archivo') {
            Swal.fire({
                type: 'warning',
                title: 'No se encontró el archivo solicitado!',
                showConfirmButton: false,
                timer: 2500,
                onClose: function() {
                    $('.modal').modal('hide');
                    $(".REV").attr('disabled', false);
                },
            });
        }
    });
    function verInfo(id) {
        $(".verinfo").attr('disabled', true);
        ruta = @json(route('callcenter.verinfo', ['id' => 'id_prof']));
        ruta = ruta.replace('id_prof', id);
        console.log(ruta);
        $('.modal').modal('hide');
        $.get(ruta, function(data) {
            $('#modal').html(data);
            $('#modalInfo').modal('show');
        });

    };
    function asignarProfesional(id) {
        $(".asignar").attr('disabled', true);
        ruta = @json(route('callcenter.asignarProfesional', ['id' => 'id_prof']));
        ruta = ruta.replace('id_prof', id);


        $('.modal').modal('hide');
        $.get(ruta, function(data) {
            //  console.log(data);
            $('#modal').html(data);
            $('#modalAsignacion').modal('show');
        });

    };
    function complementarProfesional(id) {
        $(".complementar").attr('disabled', true);
        ruta = @json(route('callcenter.complementarProfesional', ['id' => 'id_prof']));
        ruta = ruta.replace('id_prof', id);
        console.log("aprete",ruta);

         $('.modal').modal('hide');
            $.get(ruta, function(data) {
            //   console.log(data);
            $('#modal').html(data);
            $('#modalComplementar').modal('show');
        });

    };
    function crearSolicitud(id) {
        $('.modal').modal('hide');
        $('#modalSolicitud').modal('show');
    };

</script>
@endsection
