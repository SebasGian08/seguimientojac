@extends('auth.index')

@section('titulo')
    <title>JAC | Registro de Asistencia</title>
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
                <i class="fas fa-user-check"></i> Asistencia
            </h1>
        </section>


        <br>

        {{--  --}}
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
                <form class="col-lg-12 col-md-12" action="{{ route('auth.asistencia.store') }}" method="post">
                    @csrf
                    <input type="hidden" name="id_user" class="id_user" value="{{ $userId }}" required>
                    <div style="display: flex; flex-wrap: wrap;">
                        <!-- Programa -->
                        <div class="form-group col-lg-6">
                            <label for="tipoprograma" class="m-0 label-primary" style="font-size: 17px;">
                                <i class="fa fa-briefcase"></i> Programa
                            </label>
                            <select class="form-control form-control-lg" id="programa_id" name="programa_id" required>
                                <option value="" disabled selected>Seleccione Programa..</option>
                                @foreach ($tipoprograma as $tipoprograma)
                                    <option value="{{ $tipoprograma->id }}">{{ $tipoprograma->nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Fecha -->
                        <div class="form-group col-lg-6">
                            <label for="fecha" class="m-0 label-primary" style="font-size: 17px;">
                                <i class="fa fa-calendar-alt"></i> Fecha
                            </label>
                            <input type="date" class="form-control form-control-lg" id="fecha_registro"
                                name="fecha_registro" required>
                            <div id="fechaError" class="form-text text-danger"
                                style="display: none; font-size: 12px; margin-top: 5px;">
                                <i class="fa fa-exclamation-circle"></i> Por favor, debes seleccionar un Sábado.
                            </div>
                        </div>

                        <!-- Célula -->
                        <div class="form-group col-lg-6">
                            <label for="celula" class="m-0 label-primary" style="font-size: 17px;">
                                <i class="fa fa-users"></i> Célula
                            </label>
                            <select class="form-control form-control-lg" id="celula_id" name="celula_id" required>
                                <option value="" disabled selected>Seleccione Célula..</option>
                                @foreach ($celulas as $celula)
                                    <option value="{{ $celula->id }}">{{ $celula->nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Asistentes -->
                        <div class="form-group col-lg-6">
                            <label for="asistentes" class="m-0 label-primary" style="font-size: 17px;">
                                <i class="fa fa-user"></i> Asistentes
                            </label>
                            <select class="form-control form-control-lg" id="asistente_id" name="asistente_id" required>
                                <option value="" disabled selected>Seleccione Asistente..</option>
                                <!-- Opciones dinámicas aquí -->
                            </select>
                        </div>

                        <!-- Asistió? -->
                        <div class="form-group col-lg-6">
                            <label for="asistio" class="m-0 label-primary" style="font-size: 17px;">
                                <i class="fa fa-check-circle"></i> Estado
                            </label>
                            <select class="form-control form-control-lg" id="estado" name="estado" required>
                                <option value="" disabled selected>Seleccione..</option>
                                <option value="presente">PRESENTE</option>
                                <option value="ausente">AUSENTE</option>
                                <option value="justificado">JUSTIFICADO</option>
                            </select>
                        </div>

                        <!-- Motivo de Justificación -->
                        <div class="form-group col-lg-6 hidden" id="motivo-container">
                            <label for="descripcion" class="m-0 label-primary" style="font-size: 17px;">
                                <i class="fa fa-sticky-note"></i> Motivo de Justificación
                            </label>
                            <input autocomplete="off" type="text" class="form-control form-control-lg" id="motivo"
                                name="motivo" placeholder="Ingrese Descripción">
                        </div>
                    </div>


                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const asistioSelect = document.getElementById('estado');
                            const motivoContainer = document.getElementById('motivo-container');

                            asistioSelect.addEventListener('change', function() {
                                if (asistioSelect.value === 'justificado') {
                                    motivoContainer.classList.remove('hidden');
                                } else {
                                    motivoContainer.classList.add('hidden');
                                }
                            });

                            const fechaInput = document.getElementById('fecha_registro');
                            const fechaError = document.getElementById('fechaError');

                            fechaInput.addEventListener('change', function() {
                                const fecha = new Date(fechaInput.value);
                                const dayOfWeek = fecha.getDay(); // 0 = Domingo, 1 = Lunes, ..., 6 = Sábado

                                if (dayOfWeek !== 5) { // Verifica si no es sábado
                                    fechaError.style.display = 'block';
                                    fechaInput.value = ''; // Limpiar el campo de fecha
                                } else {
                                    fechaError.style.display = 'none';
                                }
                            });

                        });
                    </script>

                    <div class="form-group col-lg-12">
                        <button type="submit" class="btn btn-primary btn-lg" style="font-size: 17px;border-radius:15px;">
                            <i class="fa fa-save"></i> Registrar Asistencia</button>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript" src="{{ asset('auth/plugins/datatable/datatables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('auth/plugins/datatable/dataTables.config.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('auth/js/asistencia/index.js') }}"></script>
    <script>
        var csrfToken = '{{ csrf_token() }}';
    </script>
@endsection
