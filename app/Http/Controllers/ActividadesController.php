<?php

namespace App\Http\Controllers;

use App\Models\Actividades;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Illuminate\Routing\Controller;

class ActividadesController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth.role:user');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $actividades = Actividades::all();
        if ($actividades->isEmpty()) {
            return response()->json(['message' => 'No hay actividades registradas'], 404);
        }
        return response()->json($actividades);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre_actividad' => 'required|string|max:255',
            'fecha_actividad' => 'required|date',
            'total_recaudado' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $actividad = Actividades::create([
            'nombre_actividad' => $request->nombre_actividad,
            'fecha_actividad' => $request->fecha_actividad,
            'total_recaudado' => $request->total_recaudado
        ]);
        if ($actividad) {
            $data = [
                'message' => 'Actividad registrada correctamente',
                'actividad' => $actividad,
                'status' => 201
            ];
            return response()->json($data, 201);
        }
        return response()->json($actividad, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $actividad = Actividades::find($id);
        if (!$actividad) {
            $data = [
                'message' => 'Actividad no encontrada',
                'status' => 404
            ];
            return response()->json($data, 404);
        }
        $data = [
            'message' => 'Actividad encontrada',
            'actividad' => $actividad,
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id) {}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $actividad = Actividades::find($id);
        if (!$actividad) {
            return response()->json(['message' => 'Actividad no encontrada'], 404);
        }
        $validator = Validator::make($request->all(), [
            'nombre_actividad' => 'required|string|max:255',
            'fecha_actividad' => 'required|date',
            'total_recaudado' => 'required|numeric'
        ]);
        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validacion',
                'errors' => $validator->errors(),
                'status' => 422
            ];
            return response()->json($data, 422);
        }
        $actividad->update($request->all());
        $data = [
            'message' => 'Actividad actualizada correctamente',
            'actividad' => $actividad,
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $actividad = Actividades::find($id);
        if (!$actividad) {
            return response()->json(['message' => 'Actividad no encontrada'], 404);
        }
        $actividad->delete();
        $data = [
            'message' => 'Actividad eliminada correctamente',
            'status' => 200
        ];
        return response()->json($data, 200);
    }
}
