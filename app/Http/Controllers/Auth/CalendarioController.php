<?php

namespace BolsaTrabajo\Http\Controllers\Auth;

use BolsaTrabajo\Calendario;
use Illuminate\Http\Request;
use BolsaTrabajo\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class CalendarioController extends Controller
{
    public function index()
    {
        return view('auth.calendario.index');
    }

    public function list_all()
    {
        $events = Calendario::orderby('id', 'desc')->get()->map(function($event) {
            // Crear una instancia de Carbon a partir de la fecha en formato YYYY-MM-DD
            $startDate = Carbon::parse($event->fecha_registro);

            return [
                'title' => $event->nombre,
                'start' => $startDate->format('Y-m-d'), // Convertir a DD/MM/YYYY para visualización
                'classNames' => $event->estado == 'activo' ? ['activo'] : ['inactivo']
            ];
        });

        return response()->json($events);
    }



    private function convertToDateFormat($date)
    {
        // Convertir la fecha de formato DD/MM/YYYY a YYYY-MM-DD
        $dateParts = explode('/', $date);
        if (count($dateParts) === 3) {
            return "{$dateParts[2]}-{$dateParts[1]}-{$dateParts[0]}";
        }
        return $date; // Retornar la fecha original si el formato es incorrecto
    }


    public function store(Request $request)
    {
        // Validar los datos del formulario
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'fecha_registro' => 'required|date', // Laravel valida que sea en el formato YYYY-MM-DD
            'lugar' => 'required|string|max:255',
        ]);

        try {
            // La fecha ya está en el formato correcto (YYYY-MM-DD)
            $startDate = $validatedData['fecha_registro'];

            // Crear un nuevo registro en la base de datos
            $event = Calendario::create([
                'nombre' => $validatedData['nombre'],
                'fecha_registro' => $startDate, // Guardar la fecha tal como está
                'lugar' => $validatedData['lugar'],
                'estado' => 'activo', // o 'inactivo', dependiendo del caso
            ]);

            // Redireccionar a la ruta del programa con un mensaje de éxito
            return redirect()->route('auth.calendario')->with('success', 'Actividad registrada exitosamente.');

        } catch (\Exception $e) {
            // En caso de error, redireccionar con un mensaje de error
            return redirect()->route('auth.calendario')->withErrors(['error' => 'Ocurrió un error al registrar la actividad.'])->withInput();
        }
    }



    

   /*  public function delete(Request $request)
    {
        $status = false;

        $entity = Cargo::find($request->id);

        if($entity->delete()) $status = true;

        return response()->json(['Success' => $status]);
    } */
}
