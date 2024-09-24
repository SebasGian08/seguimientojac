<?php

namespace BolsaTrabajo\Http\Controllers\App;

use BolsaTrabajo\Alumno;
use BolsaTrabajo\App;
use BolsaTrabajo\Area;
use BolsaTrabajo\Aviso;
use BolsaTrabajo\Actividad_economica;
use BolsaTrabajo\Cargo;
use BolsaTrabajo\Distrito;
use BolsaTrabajo\Empresa;
use BolsaTrabajo\Provincia;
use BolsaTrabajo\User;
use BolsaTrabajo\Opinion;
use Carbon\Carbon;
use Illuminate\Http\Request;
use BolsaTrabajo\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    private $alumno, $empresa;

    public function __construct(Alumno $alumno, Empresa $empresa)
    {
        $this->middleware('guest:alumnos', ['except' => ['filtro_distritos']]);
        $this->middleware('guest:empresasw', ['except' => ['filtro_distritos']]);

        $this->alumno = $alumno;
        $this->empresa = $empresa;
    }

    public function index()
    {
        return view('app.home.index');
    }

    public function store(Request $request)
    {
        // Validar la solicitud
        $validatedData = $request->validate([
            'opinion' => 'required|string|max:255',
            'rating' => 'required|integer|between:1,5',
        ]);

        // Crear una nueva instancia del modelo y guardar los datos
        $opinion = new Opinion();
        $opinion->fill($validatedData);
        $opinion->save();

        // Redirigir a la ruta principal con mensaje de éxito
        return redirect('/')->with('success', 'Opinión guardada exitosamente!');
    }




}