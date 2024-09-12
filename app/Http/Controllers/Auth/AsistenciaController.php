<?php

namespace BolsaTrabajo\Http\Controllers\Auth;


use Illuminate\Support\Facades\Auth; // Importa la clase Auth
use Illuminate\Http\Request;
use BolsaTrabajo\Celula;
use BolsaTrabajo\Asistentes;
use BolsaTrabajo\TipoPrograma;
use BolsaTrabajo\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class AsistenciaController extends Controller
{
    public function index()
    {
        $celulas = Celula::all();
        $tipoprograma = TipoPrograma::all();
        return view('auth.asistencia.index', compact('celulas','tipoprograma'));
    }

    public function verlistado(){
        return view('auth.asistencia.listado');
    }

    // Nuevo método para obtener asistentes por célula
    public function asistentesPorCelula(Request $request)
    {
        $celulaId = $request->input('id');

        // Obtener los asistentes correspondientes a la célula
        $asistentes = Asistentes::where('celula_id', $celulaId)->get();

        return response()->json($asistentes);
    }
}
