@extends('auth.index')

@section('titulo')
    <title>BolsaTrabajo | Eventos Asistencia</title>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('auth/plugins/datatable/datatables.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.11.0/main.min.css">
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

        #calendar {
            background-color: white;
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
    </style>
    <div class="content-wrapper">
        <section class="content-header">
            <h1>Gestión</h1>
        </section>
        <br>
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
                <form class="col-lg-12 col-md-12" action="{{ route('auth.calendario.store') }}" method="post">
                    @csrf
                    <div style="display: flex; flex-wrap: wrap;">
                        <!-- Campo Nombre de Actividad -->
                        <div class="form-group col-lg-6">
                            <label for="nombre" class="m-0 label-primary" style="font-size: 15px;">
                                <i class="fa fa-check"></i> Nombre de Actividad
                            </label>
                            <input autocomplete="off" type="text" class="form-control form-control-lg" id="nombre"
                                name="nombre" placeholder="Ingrese nombre de célula" required>
                        </div>

                        <!-- Campo Fecha de Registro -->
                        <div class="form-group col-lg-6">
                            <label for="fecha_registro" class="m-0 label-primary" style="font-size: 15px;">
                                <i class="fa fa-calendar"></i> Fecha de Registro
                            </label>
                            <input autocomplete="off" type="date" class="form-control form-control-lg"
                                id="fecha_registro" name="fecha_registro" required>
                        </div>

                        <!-- Campo Lugar -->
                        <div class="form-group col-lg-6">
                            <label for="lugar" class="m-0 label-primary" style="font-size: 15px;">
                                <i class="fa fa-map-marker"></i> Lugar de Actividad
                            </label>
                            <input autocomplete="off" type="text" class="form-control form-control-lg" id="lugar"
                                name="lugar" placeholder="Ingrese lugar del evento" required>
                        </div>
                    </div>

                    <div class="form-group col-lg-12">
                        <button type="submit" class="btn btn-primary btn-lg" style="font-size: 16px;">
                            <i class="fa fa-save"></i> Registrar Actividad
                        </button>
                    </div>
                </form>

            </div>
        </div><br>
        <!-- Calendario -->
        <div id="calendar"></div>
        <!-- Menú contextual para eliminar eventos -->
        <div id="contextMenu" style="display: none; position: absolute; background: white; border: 1px solid #ccc; z-index: 1000;">
            <ul style="list-style-type: none; margin: 0; padding: 0;">
                <li><button id="deleteEventButton">Eliminar</button></li>
            </ul>
        </div>

    </div>
@endsection

@section('scripts')
    <!-- Bootstrap CSS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.11.0/main.min.js"></script>


    <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.15/index.global.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6.1.15/index.global.min.js'></script>
    <script type="text/javascript" src="{{ asset('auth/plugins/datatable/datatables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('auth/plugins/datatable/dataTables.config.min.js') }}"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.11.0/main.min.js"></script>
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var contextMenu = document.getElementById('contextMenu');
            var eventIdToDelete = null;
    
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                events: function(info, successCallback, failureCallback) {
                    fetch("{{ route('auth.calendario.list_all') }}")
                        .then(response => response.json())
                        .then(data => {
                            console.log('Eventos:', data); // Verifica los eventos
                            successCallback(data);
                        })
                        .catch(error => {
                            console.error('Error fetching events:', error);
                            failureCallback(error);
                        });
                },
                dateClick: function(info) {
                    // Set the date in the modal
                    document.getElementById('eventDate').value = info.dateStr;
    
                    // Show the modal
                    $('#eventModal').modal('show');
                },
                eventDidMount: function(info) {
                    // Añadir un listener de clic derecho en los eventos
                    info.el.addEventListener('contextmenu', function(e) {
                        e.preventDefault(); // Evitar el menú contextual del navegador
    
                        // Guardar el ID del evento que se va a eliminar
                        eventIdToDelete = info.event.id;
    
                        // Mostrar el menú contextual
                        contextMenu.style.display = 'block';
                        contextMenu.style.left = e.pageX + 'px';
                        contextMenu.style.top = e.pageY + 'px';
                    });
                }
            });
    
            calendar.render();
    
            // Manejar el clic en el botón de eliminar
            document.getElementById('deleteEventButton').addEventListener('click', function() {
                if (eventIdToDelete) {
                    fetch(`{{ route('auth.calendario.delete') }}/${eventIdToDelete}`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}' // Asegúrate de incluir el token CSRF
                        }
                    })
                    .then(response => {
                        if (response.ok) {
                            // Recargar el calendario después de eliminar el evento
                            calendar.refetchEvents();
                        } else {
                            console.error('Error deleting event');
                        }
                    })
                    .catch(error => console.error('Error deleting event:', error));
    
                    // Ocultar el menú contextual
                    contextMenu.style.display = 'none';
                    eventIdToDelete = null;
                }
            });
    
            // Ocultar el menú contextual si se hace clic fuera de él
            document.addEventListener('click', function(e) {
                if (!contextMenu.contains(e.target)) {
                    contextMenu.style.display = 'none';
                }
            });
        });
    </script>
    
@endsection
