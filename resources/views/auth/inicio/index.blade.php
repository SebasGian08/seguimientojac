@extends('auth.index')

@section('titulo')
    <title>JAC | Inicio</title>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('auth/plugins/datatable/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('auth/css/inicio/core.css') }}">
    {{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.6.0/css/bootstrap.min.css"> --}}
@endsection
@section('contenido')
    <div class="content-wrapper">

        <section class="content-header d-flex justify-content-between align-items-center">
            <h2>
                Dashboard
                <small>| Inicio</small>
            </h2>
            <!-- Botón de refresco alineado a la derecha -->
            <div>
                <a href="javascript:void(0)" class="btn-m btn-secondary-m" onclick="window.location.reload();">
                    <i class="fa fa-refresh"></i> Refrescar | Dashboard
                </a>
            </div>
        </section>

        <br>
        {{-- Cargando --}}
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-3 mb-4">
                    <div class="container rounded"
                        style="background-color: #ffffff; padding: 20px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); text-align: center;
                        border-radius:35px !important;">
                        <form id="filtro-form" action="{{ route('auth.inicio') }}" method="GET">
                            <div class="form-group">
                                <label for="fecha_desde" class="m-0 label-primary">Mostrar desde</label>
                                <input type="date" class="form-control form-control-sm" id="fecha_desde"
                                    name="fecha_desde" value="{{ request()->input('fecha_desde', date('Y-m-d')) }}">
                                @error('fecha_desde')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="fecha_hasta" class="m-0 label-primary">Mostrar hasta</label>
                                <input type="date" class="form-control form-control-sm" id="fecha_hasta"
                                    name="fecha_hasta" value="{{ request()->input('fecha_hasta', date('Y-m-d')) }}">
                                @error('fecha_hasta')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group mt-3">
                                <button type="submit" id="filtro-submit" class="btn btn-primary btn-sm"
                                    style="border-color: #2ecc71; border-radius: 5px;">Aplicar Filtro</button>
                                <div id="loading" style="display: none;">
                                    Cargando...
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                {{-- Style hecho por sebastian --}}
                <style>
                    .zoom-container {
                        transition: transform 0.2s ease;
                        /* Transición suave */
                    }

                    .zoom-container:hover {
                        transform: scale(1.05);
                        /* Escala del 105% al hacer hover */
                    }

                    .range {
                        width: 100%;
                        height: 10px;
                        /* Altura del barra de carga */
                        background-color: rgba(255, 255, 255, 0.2);
                        /* Color de fondo */
                        border-radius: 5px;
                        /* Bordes redondeados */
                        overflow: hidden;
                        /* Oculta el contenido que se desborda */
                    }

                    .fill {
                        width: 0%;
                        /* Ancho inicial de la barra de carga */
                        height: 100%;
                        /* Altura para llenar completamente el contenedor */
                        background-color: #00e272;
                        /* Color de la barra de carga */
                        animation: fillAnimation 2s ease-out forwards;
                        /* Animación de llenado */
                    }

                    @keyframes fillAnimation {
                        0% {
                            width: 0%;
                        }

                        100% {
                            width: 100%;
                        }
                    }

                    .icon-up {
                        margin-left: 5px;
                        /* Espacio entre el texto y el icono */
                        color: rgb(255, 255, 255);
                        /* Color del icono */
                        font-size: 13px;
                        /* Tamaño del icono */
                    }
                </style>
                {{-- Fin estilo --}}
                <div class="col-lg-3 mb-4 zoom-container">
                    <div class="totales text-center"
                        style="background: linear-gradient(to bottom right, #007bc5, #00b2e9);">
                        <div class="title">
                            <p class="title-text" style="color:rgb(255, 255, 255)">
                                <i class="fa fa-user"></i> Total de Asistentes
                                <span class="icon-up"><i class="fa fa-arrow-up"></i></span>
                            </p>
                        </div>
                        <div class="data">
                            <p id="totalAsistentes" style="color: white">
                                {{ $totalAsistentes }}
                            </p>
                            <div class="range">
                                <div class="fill" style="background-color: #00e272 !important;"></div>
                            </div>
                        </div>
                        <div style="margin-top: 10px;"> <!-- Espacio entre contenido principal y enlace -->
                            <a href="{{ route('auth.asistentes') }}" class="ver-mas"
                                style="color: white; text-decoration: none; margin-top: 10px;">
                                Ver más <i class="fa fa-chevron-right"></i>
                            </a>
                        </div>
                    </div>
                </div>





                <div class="col-lg-3 mb-4 zoom-container">
                    <div class="totales text-center">
                        <div class="title">
                            <p class="title-text" style="color:rgb(0, 175, 102)">
                                <i class="fa fa-users"></i> Total de Celulas
                                <span class="icon-up"><i class="fa fa-arrow-up"></i></span>
                            </p>
                        </div>
                        <div class="data">
                            <p id="totalUsuarios">
                                {{ $totalCelulas }}
                            </p>
                            <div class="range">
                                <div class="fill" style="background-color: #00e272 !important;"></div>
                            </div>
                        </div>
                        <div style="margin-top: 10px;"> <!-- Espacio entre contenido principal y enlace -->
                            <a href="{{ route('auth.celula') }}" class="ver-mas"
                                style="color: #00e272; text-decoration: none; margin-top: 10px;">
                                Ver más <i class="fa fa-chevron-right"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 mb-4 zoom-container">
                    <div class="totales text-center"
                        style="background: linear-gradient(to bottom right, #007bc5, #00b2e9);">
                        <div class="title">
                            <p class="title-text" style="color:rgb(255, 255, 255)">
                                <i class="fa fa-calendar mr-5"></i> Total de Actividades
                                <span class="icon-up"><i class="fa fa-arrow-up"></i></span>
                            </p>
                        </div>
                        <div class="data">
                            <p id="totalActividades" style="color: white">
                                {{ $totalActividades }}
                            </p>
                            <div class="range">
                                <div class="fill" style="background-color: #00e272 !important;"></div>
                            </div>
                            <div style="margin-top: 10px;"> <!-- Espacio entre contenido principal y enlace -->
                                <a href="{{ route('auth.calendario') }}" class="ver-mas"
                                    style="color: white; text-decoration: none; margin-top: 10px;">
                                    Ver más <i class="fa fa-chevron-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center mt-4">
                <div class="col-lg-9">
                    <div class="alert alert-success" role="alert">
                        <span class="fa fa-check-circle"></span> <!-- Icono de check -->
                        Por favor, aplique filtros por fecha para visualizar gráficos e indicadores actualizados.
                    </div>
                </div>
            </div>

        </div>
        <br>


        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6 mb-4">
                    <div class="content-header"
                        style="box-shadow: 0 2px 25px -5px rgba(0, 0, 0, .16), 0 25px 21px -5px rgba(0, 0, 0, .1) !important;">
                        <div id="container"></div>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="content-header"
                        style="box-shadow: 0 2px 25px -5px rgba(0, 0, 0, .16), 0 25px 21px -5px rgba(0, 0, 0, .1) !important;">
                        <div id="seguimiento"></div>
                    </div>
                </div>
            </div>

            <br>
            <div class="row">
                <div class="col-lg-12 mb-4">
                    <div class="content-header"
                        style="box-shadow: 0 2px 25px -5px rgba(0, 0, 0, .16), 0 25px 21px -5px rgba(0, 0, 0, .1) !important;">
                        <div id="grafico"></div>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-lg-6 mb-4">
                    <div class="content-header"
                        style="box-shadow: 0 2px 25px -5px rgba(0, 0, 0, .16), 0 25px 21px -5px rgba(0, 0, 0, .1) !important;">
                        <div id="carreraporcontratado"></div>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="content-header"
                        style="box-shadow: 0 2px 25px -5px rgba(0, 0, 0, .16), 0 25px 21px -5px rgba(0, 0, 0, .1) !important;">
                        <div id="otro"></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 mb-4">
                    <section class="content-header">
                        @csrf
                        <table id="tableInicio" width="100%"
                            class='table dataTables_wrapper container-fluid dt-bootstrap4 no-footer'></table>
                    </section>
                </div>
            </div>
        </div>
        <br>

    </div>
@endsection

@section('scripts')
    <!-- Incluir archivos de Highcharts -->
    <script src="https://code.highcharts.com/highcharts.js"></script>



    <script type="text/javascript" src="{{ asset('auth/js/inicio/index.js') }}"></script>

    <script type="text/javascript">
        // Obtener los datos proporcionados por el controlador

        var TotalDeAsistentesporCelula = @json($TotalDeAsistentesporCelula);
        // Configurar el gráfico de Highcharts
        Highcharts.chart('container', {
            chart: {
                type: 'pie'
            },
            title: {
                text: 'Cantidad de Asistentes por Célula'
            },
            tooltip: {
                formatter: function() {
                    return '<b>' + this.point.name + ': ' + this.point.percentage.toFixed(0) + '%</b>';
                }
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '{point.name}: {point.y}'
                    }
                }
            },
            series: [{
                name: 'Cantidad',
                colorByPoint: true,
                data: TotalDeAsistentesporCelula.map(item => ({
                    name: item.celula,
                    y: item.cantidad_asistentes
                }))
            }]
        });

        var data = @json($seguimientoPorCelula); // Carga los datos dinámicamente
        Highcharts.chart('seguimiento', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: 'Seguimiento por Célula',
                align: 'center'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            accessibility: {
                point: {
                    valueSuffix: '%'
                }
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true, // Habilita las etiquetas de datos para mostrar nombre y cantidad
                        format: '{point.name}: {point.y}'
                    },
                    showInLegend: true
                }
            },
            series: [{
                name: 'Cantidad de Seguimientos',
                colorByPoint: true,
                data: data.map(item => ({
                    name: item.celula,
                    y: item.cantidad_seguimientos
                }))
            }]
        });


        var seriesData = @json($asistenciasPresente);
        Highcharts.chart('grafico', {
            chart: {
                type: 'bar'
            },
            title: {
                align: 'center',
                text: 'Cantidad de Asistencias por Participante'
            },
            xAxis: {
                type: 'category',
                title: {
                    text: 'Participantes'
                }
            },
            yAxis: {
                title: {
                    text: 'Cantidad de Asistencias'
                }
            },
            legend: {
                enabled: false
            },
            plotOptions: {
                series: {
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true,
                        format: '{point.y}'
                    }
                }
            },
            series: [{
                name: 'Cantidad de Asistencias',
                colorByPoint: true,
                data: seriesData
            }]
        });

        /*  */
        var asistenciasAusente = @json($asistenciasAusente);
        Highcharts.chart('carreraporcontratado', {
            chart: {
                type: 'column'
            },
            title: {
                align: 'center',
                text: 'Cantidad de Inasistencias por Participante'
            },
            xAxis: {
                type: 'category',
                title: {
                    text: 'Participantes'
                }
            },
            yAxis: {
                title: {
                    text: 'Cantidad de Inasistencias'
                }
            },
            legend: {
                enabled: false
            },
            plotOptions: {
                series: {
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true,
                        format: '{point.y}'
                    }
                }
            },
            series: [{
                name: 'Cantidad de Contratados',
                colorByPoint: true,
                data: asistenciasAusente
            }]
        });

        // Datos pasados desde el controlador
        var seriesData = @json($asistenciasPorPrograma);
        Highcharts.chart('otro', {
            chart: {
                type: 'column'
            },
            title: {
                align: 'center',
                text: 'Cantidad de Asistencias por Programa'
            },
            xAxis: {
                type: 'category',
                title: {
                    text: 'Programa'
                }
            },
            yAxis: {
                title: {
                    text: 'Cantidad de Asistencias'
                }
            },
            legend: {
                enabled: false
            },
            plotOptions: {
                series: {
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true,
                        format: '{point.y}'
                    }
                }
            },
            series: [{
                name: 'Cantidad de Asistencias',
                colorByPoint: true,
                data: seriesData
            }]
        });
    </script>
@endsection
