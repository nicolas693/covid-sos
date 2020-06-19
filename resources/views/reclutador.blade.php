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
                        <h3 class="card-title" style="margin-top:5px">MODULO RECLUTADOR - <strong>{{Auth::user()->getEstablecimiento()->tx_descripcion}}</strong></h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-primary btn-sm crearSolicitud" onclick="crearSolicitud({{Auth::user()->id}})" >
                                <i class="fas fa-plus"></i>
                                <span style="margin-left:5px">Crear Solicitud</span>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="col-md-12" style="padding:0px">
                            @if (session('status')=='solicitud_creada')
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <h5><i class="icon fas fa-check"></i> Atención!</h5>
                                La solicitud ha sido ingresada exitosamente!
                            </div>
                            @endif

                            @if (session('status')=='updated')
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <h5><i class="icon fas fa-check"></i> Atención!</h5>
                                El registro ha sido actualizado exitosamente!
                            </div>
                            @endif
                            @if (session('status')=='solicitud_eliminada')
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <h5><i class="icon fas fa-check"></i> Atención!</h5>
                                La solicitud ha sido eliminada!
                            </div>
                            @endif
                        </div>
                        {{-- <table class="table table-sm nowrap" id="tabla_reclutador" style="width: 100%;"> --}}
                            <table  class="table table-striped table-bordered table-sm nowrap" id="tabla_reclutador" style="width: 100%">

                                {{--  --}}
                            <thead class="bold">
                                <tr>
                                    <td>Id</td>
                                    <td>Profecional</td>
                                    <td>Especialidad</td>
                                    <td>Posgrado</td>
                                    <td>Canntidad</td>
                                    <td>Diurno/Turno</td>
                                    <td>Horas p/dia</td>
                                    {{-- <td>Capacitaciones</td> --}}
                                    <td>Dias</td>
                                    <td>Fecha inicio</td>
                                    <td>Fecha creacion</td>
                                    <td>Acción</td>
                                </tr>
                            </thead>


                            <tbody>
                                @foreach($solicitudes as $key => $solicitud)
                                    <tr>
                                        <td>{{$solicitud->id}}</td>
                                        <td>{{$solicitud->getTitulo()->tx_descripcion}}</td>
                                        <td>{{$solicitud->getEspecialidad()->tx_descripcion??$solicitud->getEspecialidad()}}</td>
                                        <td>{{$solicitud->getPosgrado()->tx_descripcion??$solicitud->getPosgrado()}}</td>
                                        <td>{{$solicitud->cantidad}}</td>
                                        <td>{{$solicitud->getJornada()->tx_descripcion}}</td>
                                        <td>{{$solicitud->horas}}</td>
                                        <td>{{$solicitud->dias}}</td>
                                        @php
                                            $fecha=\Carbon\Carbon::parse($solicitud->fecha_inicio)->format('d-m-Y');
                                        @endphp
                                        <td>{{$fecha}}</td>
                                        <td>{{$solicitud->created_at->format('d-m-Y')}}</td>


                                        <td style="text-align:center">
                                            <button type="button" class="btn btn-info btn-sm verSolicitud" name="{{$solicitud->id}}"  title="Información solicitud" onclick="verSolicitud(this.name)"><i class="fas fa-info-circle"></i></button>
                                            <button type="button" class="btn btn-danger btn-sm eliminarSolicitud" name="{{$solicitud->id}}"  onclick="eliminarSolicitud(this.name)"title="eliminar solicitud "><i class="fa fa-trash"></i></button>
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
    <div id="modal">

    </div>
</section>
<script>
    $(document).ready(function() {
        $('#tabla_reclutador').DataTable({
            responsive: true,
            "pageLength": 50,
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
        // null,
        // null,
        // null,
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



    // MODALES
    function crearSolicitud(id) {
        // console.log(id);
        $(".crearSolicitud").attr('disabled', true);
        ruta = @json(route('reclutador.nuevaSolicitud'));
        // console.log(ruta);
            $('.modal').modal('hide');
            $.get(ruta, function(data) {
            $('#modal').html(data);
            $('#modalSolicitud').modal('show');
            });
    };

    function verSolicitud(id) {
        $(".verSolicitud").attr('disabled', true);
        ruta = @json(route('reclutador.verSolicitud', ['id' => 'id_prof']));
        ruta = ruta.replace('id_prof', id);
        // console.log("aprete",ruta);
        $('.modal').modal('hide');
            $.get(ruta, function(data) {
            //   console.log(data);
            $('#modal').html(data);
            $('#modalVerSolicitud').modal('show');
        });
    };

    function eliminarSolicitud(id) {
        $(".btnEliminar").attr('disabled', true);
        ruta = @json(route('reclutador.modalEliminarSolicitud', ['id' => 'id_prof']));
        ruta = ruta.replace('id_prof', id);
        $('.modal').modal('hide');
        $.get(ruta, function(data) {
            $('#modal').html(data);
            $('#modalDelete').modal('show');
        });
        // setTimeout(() => {  $(".ELIMINAR").attr('disabled', false) }, 500);
    }


</script>
@endsection
