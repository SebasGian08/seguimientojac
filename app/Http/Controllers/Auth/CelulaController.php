<?php

namespace BolsaTrabajo\Http\Controllers\Auth;

use BolsaTrabajo\Celula;
use BolsaTrabajo\Asistentes;
use BolsaTrabajo\User;
use Illuminate\Support\Facades\Auth; // Importa la clase Auth
use Illuminate\Http\Request;
use BolsaTrabajo\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class CelulaController extends Controller
{

    public function index()
    {
        $user = User::all();
        return view('auth.celula.index', ['user' => $user]);
    }
      

    public function list_all()
    {
        // Obtener todas las instancias de Celula con la relación lider cargada
        $celulas = Celula::with('lider')->orderby('id', 'desc')->get();

        // Formatear la respuesta para incluir el nombre del líder
        $data = $celulas->map(function ($celula) {
            return [
                'id' => $celula->id, // Campo 'nombre' de Celula
                'nombre' => $celula->nombre, // Campo 'nombre' de Celula
                'nombrelider' => $celula->lider ? $celula->lider->nombres : 'Sin líder', // Campo 'name' de User
                'descripcion' => $celula->descripcion, // Campo 'descripcion' de Celula
                'estado' => $celula->estado, // Campo 'descripcion' de Celula
            ];
        });

        // Devolver la respuesta en formato JSON
        return response()->json(['data' => $data]);
    }
    public function store(Request $request)
    {
        $status = false;
        
        // Validar los datos de la solicitud
        $validator = Validator::make($request->all(), [
            'lider_id' => 'required|exists:users,id', // Asegúrate de que el ID del usuario exista en la tabla `users`
            'nombre' => 'required|string|max:255',
        ]);
        
        // Verifica si la validación falla
        if (!$validator->fails()) {
            // Recolecta los datos para crear el nuevo registro
            $data = [
                'lider_id' => $request->lider_id, // Usa `liderid` aquí
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
            ];

            // Crea el nuevo registro en la base de datos
            Celula::create($data);
            $status = true;
        }

        // Redirige basado en el resultado de la operación
        return $status ? redirect(route('auth.celula')) : redirect(route('auth.celula'))->withErrors($validator)->withInput();
    }


    //ELIMINAR CELULA
    public function delete(Request $request)
    {
        $status = false;

        // Encuentra el evento con el id proporcionado
        $event = Celula::find($request->id);

        if ($event) {
            // Verifica si hay asistentes asociados a la célula del evento
            $hasParticipants = Asistentes::where('celula_id', $event->id)->exists();

            if (!$hasParticipants) {
                // Elimina el evento si no tiene asistentes asociados
                if ($event->delete()) {
                    $status = true;
                } else {
                    // Error al intentar eliminar
                    return response()->json(['Success' => $status, 'Message' => 'Error al intentar eliminar la celula.']);
                }
            } else {
                // El evento tiene asistentes asociados
                return response()->json(['Success' => $status, 'Message' => 'No se puede eliminar la celula porque tiene asistentes asociados.']);
            }
        } else {
            // El evento no se encuentra
            return response()->json(['Success' => $status, 'Message' => 'Celula no encontrado.']);
        }

        return response()->json(['Success' => $status]);
    }

    public function partialViewAsistentes($id)
    {
        // Asegúrate de que el ID es válido y que la entidad se encuentra en la base de datos
        $entity = Celula::find($id);
        // Pasar la entidad a la vista
        return view('auth.celula.listadoasistentes', ['Entity' => $entity]);
    }

    /* Mostrar Asistentes en Tabla al momento de abrir el modal LISTADO TABLA*/
    public function mostrarAsistentes(Request $request)
    {
        $celula_id = $request->input('celula_id');

        // Consulta usando el modelo Eloquent
        $asistentes = Asistentes::join('celulas as c', 'asistentes.celula_id', '=', 'c.id') // Unir con la tabla de células
                                ->join('distritos as d', 'asistentes.distrito_id', '=', 'd.id') // Unir con la tabla de distritos
                                ->select('asistentes.dni', 'asistentes.nombre', 'asistentes.apellido',
                                        'asistentes.fecha_nac', 'asistentes.direccion', 'asistentes.tel', 'asistentes.genero', 'asistentes.id',
                                        'd.nombre as distrito') // Seleccionar el nombre del distrito
                                ->where('c.id', $celula_id) // Filtrar por el id de la célula
                                ->orderBy('asistentes.created_at', 'DESC') // Ordenar por la fecha de creación
                                ->get();

        return response()->json(['data' => $asistentes]);
    }


    /* EDITAR 1 */     
    public function modalSeguimientoAsistentes($id)
    {
        // Asegúrate de que el ID es válido y que la entidad se encuentra en la base de datos
        $entity = Asistentes::find($id);
        // Pasar la entidad a la vista
        return view('auth.celula.seguimiento', ['Entity' => $entity]);
    }

    public function listSeguimiento(Request $request)
    {
        $asistenteId = $request->input('asistente_id');
        
        $seguimientos = DB::table('seguimiento as s')
                        ->select('s.id', 's.asistente_id', 's.fecha_contacto', 's.tipo_contacto', 
                                's.detalle', 's.oracion')
                        ->where('s.asistente_id', $asistenteId)
                        ->whereNull('s.deleted_at')
                        ->orderBy('s.fecha_contacto', 'DESC')
                        ->get();
        
        return response()->json(['data' => $seguimientos]);
    }



}