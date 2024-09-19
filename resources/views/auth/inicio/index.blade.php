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
            <!-- Shortcut Buttons Row -->
            <div class="row justify-content-center mb-4">
                <div class="col-6 col-md-3 text-center mb-3">
                    <a href="{{ route('auth.asistencia') }}" class="btn"
                        style="background-color: #28a745; color: #ffffff; padding: 15px 20px; border-radius: 10px; transition: all 0.3s ease; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">
                        <i class="fa fa-check-circle fa-2x"></i><br>
                        <span style="font-size: 1.2em;">Registrar Asistencia</span>
                    </a>
                </div>
                <div class="col-6 col-md-3 text-center mb-3">
                    <a href="{{ route('auth.asistentes') }}" class="btn" style="background-color: #007bff; color: #ffffff; padding: 15px 20px; border-radius: 10px; transition: all 0.3s ease; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">
                        <i class="fa fa-user-plus fa-2x"></i><br>
                        <span style="font-size: 1.2em;">Registrar Asistentes</span>
                    </a>
                </div>
                <div class="col-6 col-md-3 text-center mb-3">
                    <a href="{{ route('auth.asistencia.listado') }}" class="btn"
                        style="background-color: #ffc107; color: #ffffff; padding: 15px 20px; border-radius: 10px; transition: all 0.3s ease; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">
                        <i class="fa fa-calendar fa-2x"></i><br>
                        <span style="font-size: 1.2em;">Listado de Asistencia</span>
                    </a>
                </div>
                <div class="col-6 col-md-3 text-center mb-3">
                    <a href="{{-- {{ route('auth.reporte') }} --}}" class="btn" style="background-color: #dc3545; color: #ffffff; padding: 15px 20px; border-radius: 10px; transition: all 0.3s ease; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">
                        <i class="fa fa-users fa-2x"></i><br>
                        <span style="font-size: 1.2em;">Nuevos Asistentes</span>
                    </a>
                </div>
            </div>
            
            <style>
                .btn:hover {
                    filter: brightness(1.1);
                    transform: translateY(-5px);
                }
            </style>
            
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

                {{-- Remaining content (totals) goes here --}}
                <div class="col-lg-3 mb-4 zoom-container">
                    <div class="totales text-center"
                        style="background: linear-gradient(to bottom right, #34495e, #536f8b);">
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
                                <span class="icon-up"><i class="fa fa-arrow-up" style="color:white"></i></span>
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
                        style="background: linear-gradient(to bottom right, #34495e, #536f8b);">
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
                                <a href="{{ route('auth.calendario.listado') }}" class="ver-mas"
                                    style="color: white; text-decoration: none; margin-top: 10px;">
                                    Ver más <i class="fa fa-chevron-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="row justify-content-center mt-4">
            <div class="col-lg-9">
                <div class="alert alert-success" role="alert">
                    <span class="fa fa-check-circle"></span>
                    Por favor, aplique filtros por fecha para visualizar gráficos e indicadores actualizados.
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
                <h3 style="text-align: center;font-weight: 700">Control de Asistencia</h3>
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
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <script type="text/javascript" src="{{ asset('auth/js/inicio/index.js') }}"></script>

    <script type="text/javascript">
        // Obtener los datos proporcionados por el controlador
        var TotalDeAsistentesporCelula = @json($TotalDeAsistentesporCelula);
        var seguimientoPorCelula = @json($seguimientoPorCelula);
        var asistenciasPresente = @json($asistenciasPresente);
        var asistenciasAusente = @json($asistenciasAusente);
        var asistenciasPorPrograma = @json($asistenciasPorPrograma);

        // Imprimir datos en la consola para depuración
        console.log('TotalDeAsistentesporCelula:', TotalDeAsistentesporCelula);
        console.log('seguimientoPorCelula:', seguimientoPorCelula);
        console.log('asistenciasPresente:', asistenciasPresente);
        console.log('asistenciasAusente:', asistenciasAusente);
        console.log('asistenciasPorPrograma:', asistenciasPorPrograma);

        // Función para transformar datos a números
        function transformData(data) {
            return data.map(item => ({
                name: item.celula || item.name,
                y: parseFloat(item.cantidad_asistentes || item.cantidad_seguimientos || item.y)
            }));
        }

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
                data: transformData(TotalDeAsistentesporCelula)
            }]
        });

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
                        enabled: true,
                        format: '{point.name}: {point.y}'
                    },
                    showInLegend: true
                }
            },
            series: [{
                name: 'Cantidad de Seguimientos',
                colorByPoint: true,
                data: transformData(seguimientoPorCelula)
            }]
        });

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
                data: transformData(asistenciasPresente)
            }]
        });

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
                data: transformData(asistenciasAusente)
            }]
        });

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
                data: transformData(asistenciasPorPrograma)
            }]
        });
    </script>
@endsection
