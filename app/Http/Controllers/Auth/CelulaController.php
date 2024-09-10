<?php

namespace BolsaTrabajo\Http\Controllers\Auth;

use BolsaTrabajo\Celula;
use Illuminate\Support\Facades\Auth; // Importa la clase Auth
use Illuminate\Http\Request;
use BolsaTrabajo\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class CelulaController extends Controller
{

    public function index()
    {
     
        return view('auth.celula.index');
       
    }
      

    public function list_all()
    {
        return response()->json(['data' => Celula::orderby('id', 'desc')->get()]);
    }
    
}