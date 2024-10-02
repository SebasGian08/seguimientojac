@extends('auth.index')

@section('titulo')
    <title>JAC | Aniversario</title>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('auth/plugins/datatable/datatables.min.css') }}">
    <style>
        .estado-pagado {
            background-color: #d4edda;
            /* Verde claro */
            color: #155724;
            /* Texto verde oscuro */
            padding: 5px;
            border-radius: 5px;
        }

        .estado-faltante {
            background-color: #f8d7da;
            /* Rojo claro */
            color: #721c24;
            /* Texto rojo oscuro */
            padding: 5px;
            border-radius: 5px;
        }
    </style>
@endsection

@section('contenido')
    <div class="content-wrapper">

        <section class="content-header">
            <h1>
                Listado de Asistentes
                <small>Aniversario</small>
            </h1>
        </section>

        <section class="content">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <br><br>
                    <div class="content-header">
                        <div class="form-group row">
                            <div class="col-md-4">
                                <label>Desde:</label>
                                <input type="date" id="dateFrom" class="form-control form-control-lg" />
                            </div>
                            <div class="col-md-4">
                                <label>Hasta:</label>
                                <input type="date" id="dateTo" class="form-control form-control-lg" />
                            </div>
                            <div class="col-md-4">
                                <label>&nbsp;</label>
                                <button id="filterButton" class="btn btn-primary form-control">Consultar</button>
                            </div>
                        </div>
                    </div>
                    <br><br>
                    <div class="content-header">
                        <table id="tableAniversario"
                            class="table table-bordered table-striped display nowrap margin-top-10 dataTable no-footer">
                        </table>
                        <div class="form-group col-lg-3 col-md-12 d-flex flex-column">
                            <a href="javascript:void(0)" class="btn-m btn-success-m" onclick="clickExcel()">
                                <i class="fa fa-file"></i> Reporte de Aniversario
                            </a>
                            <a href="javascript:void(0)" class="btn-pdf" onclick="clickPDF()">
                                <i class="fa fa-file-pdf"></i> Reporte PDF
                            </a>
                            <style>
                                .btn-pdf {
                                    display: flex;
                                    align-items: center;
                                    justify-content: center;
                                    padding: 10px;
                                    margin-top: 5px;
                                    border-radius: 5px;
                                    background-color: #dc3545;
                                    /* Color rojo */
                                    color: white;
                                    text-decoration: none;
                                    font-weight: bold;
                                }
                            </style>
                        </div>
                    </div>

                </div>
            </div>
    </div>
    </section>

    </div>
@endsection

@section('scripts')
    <script type="text/javascript" src="{{ asset('auth/plugins/datatable/datatables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('auth/plugins/datatable/dataTables.config.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('auth/js/aniversario/index.js') }}"></script>
@endsection
