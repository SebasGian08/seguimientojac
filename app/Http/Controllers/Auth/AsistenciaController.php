<?php

namespace BolsaTrabajo\Http\Controllers\Auth;


use Illuminate\Support\Facades\Auth; // Importa la clase Auth
use Illuminate\Http\Request;
use BolsaTrabajo\Celula;
use BolsaTrabajo\Asistentes;
use BolsaTrabajo\Asistencia;
use BolsaTrabajo\TipoPrograma;
use BolsaTrabajo\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class AsistenciaController extends Controller
{
    public function index()
    {
        $celulas = Celula::where('estado', 1) // Solo estado 1
                 ->whereNull('deleted_at') // Excluir registros eliminados
                 ->get();
        $User = Auth::guard('web')->user();
        $userId = $User->id; // Extraer el ID del usuario         
        $tipoprograma = TipoPrograma::all();
        return view('auth.asistencia.index', compact('celulas','tipoprograma','userId'));
    }

    public function verlistado(){
        $celulas = Celula::where('estado', 1) // Solo estado 1
                 ->whereNull('deleted_at') // Excluir registros eliminados
                 ->get();


        return view('auth.asistencia.listado' , compact('celulas'));
    }

    // Nuevo método para obtener asistentes por célula
    public function asistentesPorCelula(Request $request)
    {
        $celulaId = $request->input('id');

        // Obtener los asistentes correspondientes a la célula
        $asistentes = Asistentes::where('celula_id', $celulaId)->where('estado',1)->get();

        return response()->json($asistentes);
    }

    public function list_all(Request $request)
    {
        $query = Asistencia::with(['programa', 'celula', 'asistente'])
                        ->orderby('id', 'desc');

        // Aplicar filtros
        if ($request->has('fecha_exacta') && $request->fecha_exacta) {
            $query->whereDate('fecha_registro', $request->fecha_exacta);
        }

        if ($request->has('estado_asistencia') && $request->estado_asistencia) {
            $query->where('estado', $request->estado_asistencia);
        }

        if ($request->has('celula_filter_id') && $request->celula_filter_id) {
            $query->whereHas('celula', function ($q) use ($request) {
                $q->where('id', $request->celula_filter_id);
            });
        }

        $asistencias = $query->get()->map(function ($asistencia) {
            return [
                'id' => $asistencia->id,
                'fecha_registro' => $asistencia->fecha_registro,
                'estado' => $asistencia->estado,
                'programa' => $asistencia->programa ? [
                    'id_programa' => $asistencia->programa->id,
                    'nombre_programa' => $asistencia->programa->nombre,
                ] : null,
                'celula' => $asistencia->celula ? [
                    'id_celula' => $asistencia->celula->id,
                    'nombre_celula' => $asistencia->celula->nombre,
                ] : null,
                'asistente' => $asistencia->asistente ? [
                    'id_asistente' => $asistencia->asistente->id,
                    'nombre_asistente' => $asistencia->asistente->nombre,
                    'apellido_asistente' => $asistencia->asistente->apellido,
                ] : null,
            ];
        });

        return response()->json(['data' => $asistencias]);
    }

    public function delete(Request $request)
    {
        $status = false;

        $entity = Asistencia::find($request->id);

        if($entity->delete()) $status = true;

        return response()->json(['Success' => $status]);
    }

    public function store(Request $request)
    {
        // Validar los datos del formulario
        $validator = Validator::make($request->all(), [
            'programa_id' => 'required|exists:tipo_programas,id',
            'fecha_registro' => 'required|date',
            'celula_id' => 'required|exists:celulas,id',
            'asistente_id' => [
                'required',
                'exists:asistentes,id',
                function ($attribute, $value, $fail) use ($request) {
                    // Verifica si ya existe un registro para el mismo asistente y fecha
                    $exists = Asistencia::where('asistente_id', $value)
                        ->where('fecha_registro', $request->input('fecha_registro'))
                        ->exists();

                    if ($exists) {
                        $fail('El asistente ya está registrado para esta fecha.');
                    }
                },
            ],
            'estado' => 'required|in:presente,ausente,justificado',
        ]);
        
        // Verifica si la validación falla
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        // Recolecta los datos para crear el nuevo registro
        $data = [
            'programa_id' => $request->input('programa_id'),
            'fecha_registro' => $request->input('fecha_registro'),
            'celula_id' => $request->input('celula_id'),
            'asistente_id' => $request->input('asistente_id'),
            'estado' => $request->input('estado'),
            'motivo' => $request->input('motivo'), // Puede ser null si no se proporciona
            'id_user' => $request->input('id_user'),
        ];
        
        // Crea el nuevo registro en la base de datos
        Asistencia::create($data);
        
        // Redireccionar a la ruta del programa con un mensaje de éxito
        return redirect()->route('auth.asistencia')->with('success', 'Registro creado exitosamente.');
    }

}