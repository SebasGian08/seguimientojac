<?php

namespace BolsaTrabajo\Http\Controllers\Auth;

use BolsaTrabajo\Asistentes;
use BolsaTrabajo\Celula;
use BolsaTrabajo\Distrito;
use BolsaTrabajo\Asistencia;
use BolsaTrabajo\Seguimiento;
use Illuminate\Support\Facades\Auth; // Importa la clase Auth
use Illuminate\Http\Request;
use BolsaTrabajo\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class AsistentesController extends Controller
{

    public function index()
    {
        // Obtén todas las células
        $celulas = Celula::all();
        $distritos = Distrito::where('provincia_id', 15)
                            ->orderBy('nombre')  // Ordenar alfabéticamente por nombre
                            ->get();
        // Pasar el objeto celulas a la vista
        return view('auth.asistentes.index', ['celulas' => $celulas, 'distritos' => $distritos]);
    }


    public function list_all()
    {
        // Eager load los nombres de Distrito y Celula
        $asistentes = Asistentes::with(['distrito', 'celula'])
            ->orderby('id', 'desc')
            ->get();

        // Mapear la colección para incluir los nombres
        $asistentes = $asistentes->map(function($asistente) {
            return [
                'id' => $asistente->id,
                'dni' => $asistente->dni,
                'nombre' => $asistente->nombre,
                'apellido' => $asistente->apellido,
                'fecha_nac' => $asistente->fecha_nac,
                'distrito_nombre' => $asistente->distrito ? $asistente->distrito->nombre : null,
                'direccion' => $asistente->direccion,
                'tel' => $asistente->tel,
                'genero' => $asistente->genero,
                'celula_id' => $asistente->celula_id,
                'celula_nombre' => $asistente->celula ? $asistente->celula->nombre : null,
                'estado' => $asistente->estado,
                // Agrega otros campos según sea necesario
            ];
        });

        return response()->json(['data' => $asistentes]);
    }

    public function delete(Request $request)
    {
        $status = false;

        // Encuentra asistentes con el id proporcionado
        $event = Asistentes::find($request->id);

        if ($event) {
            // Verifica si hay asistentes activos asociados a la célula del evento
            $hasParticipants = Asistencia::where('asistente_id', $event->id)
                ->whereNull('deleted_at')
                ->exists();
            // Verifica si hay seguimientos activos asociados al asistente
            $hasFollowUps = Seguimiento::where('asistente_id', $event->id)
                ->whereNull('deleted_at')
                ->exists();

            if (!$hasParticipants && !$hasFollowUps) {
                if ($event->delete()) {
                    $status = true;
                } else {
                    // Error al intentar eliminar
                    return response()->json(['Success' => $status, 'Message' => 'Error al intentar eliminar el asistente.']);
                }
            } else {
                // Mensaje específico si tiene registros asociados
                if ($hasParticipants) {
                    return response()->json(['Success' => $status, 'Message' => 'No se puede eliminar el asistente porque tiene registros de asistencia asociados.']);
                }
                if ($hasFollowUps) {
                    return response()->json(['Success' => $status, 'Message' => 'No se puede eliminar el asistente porque tiene seguimientos asociados.']);
                }
            }
        } else {
            // Asistentes no se encuentra
            return response()->json(['Success' => $status, 'Message' => 'Asistente no encontrado.']);
        }

        return response()->json(['Success' => $status]);
    }


    
}