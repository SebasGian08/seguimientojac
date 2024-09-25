<?php

namespace BolsaTrabajo\Http\Controllers\Auth;

use BolsaTrabajo\Aniversario;
use Illuminate\Http\Request;
use BolsaTrabajo\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AniversarioController extends Controller
{


    public function index()
    {
        return view('auth.aniversario.index');
    }

    public function list_all()
    {
        $events = Aniversario::orderby('id', 'desc')->get(['id', 'nombre', 'tel', 'foto']); // Asegúrate de incluir 'id'

        // Mapear los eventos para incluir la URL completa de la foto
        $events = $events->map(function ($event) {
            return [
                'id' => $event->id, // Asegúrate de que 'id' esté aquí
                'nombre' => $event->nombre,
                'tel' => $event->tel,
                'foto' => $event->foto,
            ];
        });

        return response()->json($events);
    }



    public function partialView($id)
    {
        $entity = Aniversario::find($id);
        
        // Si no se encuentra la entidad, podrías redirigir o devolver un error
        if (!$entity) {
            return response()->json(['error' => 'Not Found'], 404);
        }

        return view('auth.aniversario._Mantenimiento', [
            'Entity' => $entity,
        ]);
    }

    

    


    
    


}