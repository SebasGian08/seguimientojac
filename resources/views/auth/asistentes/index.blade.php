@extends('auth.index')

@section('titulo')
    <title>BolsaTrabajo | Eventos Asistencia</title>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('auth/plugins/datatable/datatables.min.css') }}">
@endsection

@section('contenido')
    <style>
        .activo {
            background-color: green;
            color: white;
        }

        .inactivo {
            background-color: red;
            color: white;
        }
    </style>
    <div class="content-wrapper">

        <section class="content-header">
            <h1>
                Gestión
            </h1>
        </section>

        <br>
        <div class="content-header">
            <div class="row align-items-center">
                <!-- Contenedor para los mensajes -->
                <div class="col-lg-12">
                    <!-- Mensaje de éxito -->
                    @if (session('success'))
                        <div class="alert alert-success d-flex align-items-center" role="alert">
                            <i class="fa fa-check-circle me-2"></i> <!-- Icono de éxito -->
                            <div>
                                <ul class="mb-0">
                                    {{ session('success') }}
                                </ul>
                            </div>
                        </div>
                    @endif
                    <!-- Mensaje de error -->
                    @if ($errors->any())
                        <div class="alert alert-danger d-flex align-items-center" role="alert">
                            <i class="fa fa-exclamation-triangle me-2"></i> <!-- Icono de error -->
                            <div>
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        {{ $error }}
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <div class="form-row">
                <form class="col-lg-12 col-md-12" action="{{-- {{ route('auth.eventosasistencia.store') }} --}}" method="post">
                    @csrf
                    {{-- <input type="hidden" name="id_user" class="id_user" value="{{ $userId }}" required> --}}
                    <div style="display: flex; flex-wrap: wrap;">
                        <div class="form-group col-lg-6">
                            <label for="nombres" class="m-0 label-primary" style="font-size: 15px;">
                                <i class="fa fa-check"></i> Nombre del Asistente</label>
                            <input autocomplete="off" type="text" class="form-control form-control-lg" id="nombres"
                                name="nombres" placeholder="Ingrese nombre del asistente" required>
                        </div>

                        <div class="form-group col-lg-6">
                            <label for="apellidos" class="m-0 label-primary" style="font-size: 15px;">
                                <i class="fa fa-check"></i> Apellidos</label>
                            <input autocomplete="off" type="text" class="form-control form-control-lg" id="apellidos"
                                name="apellidos" placeholder="Ingrese apellidos del asistente" required>
                        </div>

                        <div class="form-group col-lg-6">
                            <label for="fecha_cumpleanos" class="m-0 label-primary" style="font-size: 15px;">
                                <i class="fa fa-calendar"></i> Fecha de Nacimiento</label>
                            <input autocomplete="off" type="date" class="form-control form-control-lg"
                                id="fecha_cumpleanos" name="fecha_cumpleanos" required>
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="distrito" class="m-0 label-primary" style="font-size: 15px;">
                                <i class="fa fa-map-marker"></i> Distrito</label>
                            <select class="form-control form-control-lg" id="distrito" name="distrito" required>
                                <option value="" disabled selected>Seleccione Distrito</option>
                                @foreach($distritos as $distritos)
                                    <option value="{{ $distritos->id }}">{{ $distritos->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="direccion" class="m-0 label-primary" style="font-size: 15px;">
                                <i class="fa fa-home"></i> Dirección</label>
                            <input autocomplete="off" type="text" class="form-control form-control-lg" id="direccion"
                                name="direccion" placeholder="Ingrese dirección del asistente" required>
                        </div>

                        <div class="form-group col-lg-6">
                            <label for="telefono" class="m-0 label-primary" style="font-size: 15px;">
                                <i class="fa fa-phone"></i> Teléfono/Celular
                            </label>
                            <input
                                autocomplete="off"
                                type="tel"
                                class="form-control form-control-lg"
                                min="6"
                                id="telefono"
                                name="telefono"
                                placeholder="Ingrese número de teléfono"
                                required
                                oninput="this.value = this.value.replace(/\D/g, '')"
                            >
                        </div>
                        

                        <div class="form-group col-lg-6">
                            <label for="genero" class="m-0 label-primary" style="font-size: 15px;">
                                <i class="fa fa-genderless"></i> Género</label>
                            <select class="form-control form-control-lg" id="genero" name="genero" required>
                                <option value="" disabled selected>Seleccione su género</option>
                                <option value="masculino">Masculino</option>
                                <option value="femenino">Femenino</option>
                            </select>
                        </div>

                        <div class="form-group col-lg-6">
                            <label for="celula" class="m-0 label-primary" style="font-size: 15px;">
                                <i class="fa fa-tag"></i> Célula
                            </label>
                            <select class="form-control form-control-lg" id="celula" name="celula" required>
                                <option value="" disabled selected>Seleccione Celula..</option>
                                @foreach ($celulas as $celula)
                                    <option value="{{ $celula->id }}">{{ $celula->nombre }}</option>
                                @endforeach
                            </select>
                        </div>



                    </div>


                    <div class="form-group col-lg-12">
                        <button type="submit" class="btn btn-primary btn-lg" style="font-size: 16px;">
                            <i class="fa fa-save"></i> Registrar Asistente</button>
                    </div>
                </form>
            </div>



        </div>
        <hr>
        <style>
            .table th,
            .table td {
                border: 1px solid #ddd;
                padding: 8px;
                text-align: center;
            }
        </style>

        <section class="content-header">
            @csrf
            <div class="row">
                <div class="col-md-12">

                    <table id="tableAsistentes" width="100%"
                        class='table dataTables_wrapper container-fluid dt-bootstrap4 no-footer'></table>
                </div>
            </div>
        </section>

    </div>
@endsection

@section('scripts')
    <script type="text/javascript" src="{{ asset('auth/plugins/datatable/datatables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('auth/plugins/datatable/dataTables.config.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('auth/js/asistentes/index.js') }}"></script>
@endsection
