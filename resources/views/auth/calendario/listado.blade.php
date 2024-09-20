@extends('auth.index')

@section('titulo')
    <title>JAC | Listado de Actividades</title>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('auth/plugins/datatable/datatables.min.css') }}">
@endsection

@section('contenido')
    <div class="content-wrapper">

        <section class="content-header">
            <h1>
                Listado de Actividades
                <small>| Mantenimiento</small>
            </h1>
        </section>
        <br>
        <div class="content-header">
            <div class="form-row">
                <!-- Filtro fecha_desde -->
                <div class="form-group col-lg-4 col-md-6">
                    <label for="fecha_desde" class="m-0 label-primary">Fecha desde</label>
                    <input type="date" class="form-control-m form-control-sm" id="fecha_desde">
                </div>
                <div class="form-group col-lg-4 col-md-6">
                    <label for="fecha_hasta" class="m-0 label-primary">Fecha hasta</label>
                    <input type="date" class="form-control-m form-control-sm" id="fecha_hasta">
                </div>
                <!-- Botón de Consulta -->
                <div class="form-group col-lg-3 col-md-12 d-flex flex-column">
                    <label for="" class="m-0 w-100">.</label>
                    <a href="javascript:void(0)" id="btn-consultar" class="btn-m btn-primary-m">
                        <i class="fa fa-search"></i> Consultar Actividad
                    </a>
                </div>
            </div>
        </div>
        <hr>
        <section class="content">
            @csrf
            <div class="row">
                <style>
                    #tableActividades tbody tr:hover {
                        cursor: pointer;
                        /* Cambia el cursor a una mano cuando se pasa sobre la fila */
                    }
                </style>
                <div class="col-md-12">
                    <table id="tableActividades"
                        class="table table-bordered table-striped display nowrap margin-top-10 dataTable no-footer"></table>
                </div>
                <div class="form-group col-lg-3 col-md-12 d-flex flex-column">
                    <a href="javascript:void(0)" class="btn-m btn-success-m" onclick="clickExcel()">
                        <i class="fa fa-file"></i> Reporte de Actividades
                    </a>
                </div>
            </div>
        </section>

    </div>
@endsection

@section('scripts')
    <script type="text/javascript" src="{{ asset('auth/plugins/datatable/datatables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('auth/plugins/datatable/dataTables.config.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('auth/js/calendario/index.js') }}"></script>
@endsection
