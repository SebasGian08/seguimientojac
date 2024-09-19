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

        <section class="content">
            @csrf
            <div class="row">
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
