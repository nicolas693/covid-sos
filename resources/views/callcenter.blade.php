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
    .bold{
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
                        <h3 class="card-title">VISTA RECLUTADOR</h3>

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
                                    <td>Teléfono</td>
                                    <td>E-mail</td>
                                    <td>Lugar De Trabajo</td>
                                    <td>Disponibilidad</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($profesionales as $key => $pro)
                                    <tr>
                                        <td>{{$pro->nombre}}</td>
                                        <td>{{$pro->telefono}}</td>
                                        <td>{{$pro->email}}</td>
                                        <td>{{$pro->lugar_trabajo}}</td>
                                        <td>{{$pro->disponibilidad}}</td>
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
</section>
<script>
    $(document).ready(function() {
        $('#tabla_reclutador').DataTable({
            responsive: true
        });
    });

   
</script>
@endsection