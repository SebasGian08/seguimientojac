<?php

namespace BolsaTrabajo\Http\Controllers\Auth;

use BolsaTrabajo\Asistentes;
use Illuminate\Support\Facades\Auth; // Importa la clase Auth
use Illuminate\Http\Request;
use BolsaTrabajo\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class AsistentesController extends Controller
{

    public function index()
    {
     
        return view('auth.asistentes.index');
       
    }
      

    public function list_all()
    {
        return response()->json(['data' => Asistentes::orderby('id', 'desc')->get()]);
    }
    
}