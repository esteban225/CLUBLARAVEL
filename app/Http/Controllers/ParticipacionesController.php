<?php

namespace App\Http\Controllers;

use App\Models\Participaciones;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ParticipacionesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $participaciones = Participaciones::all();
        if ($participaciones->isEmpty()) {
            return response()->json(['message' => 'No hay participaciones registradas'], 404);
        }
        return response()->json($participaciones);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'asociados_id' => 'required|integer|exists:asociados,id',
            'actividades_id' => 'required|integer|exists:actividades,id',
            'valor_aporte' => 'required|numeric',
            'fecha_participacion' => 'required|date'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $participacion = Participaciones::create($request->all());
        if ($participacion) {
            return response()->json([
                'message' => 'Participación registrada correctamente',
                'participacion' => $participacion,
                'status' => 201
            ], 201);
        }
        return response()->json($participacion, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $participacion = Participaciones::find($id);
        if (!$participacion) {
            return response()->json(['message' => 'Participación no encontrada'], 404);
        }
        return response()->json($participacion);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'asociados_id' => 'sometimes|required|integer|exists:asociados,id',
            'actividades_id' => 'sometimes|required|integer|exists:actividades,id',
            'valor_aporte' => 'sometimes|required|numeric',
            'fecha_participacion' => 'sometimes|required|date'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $participacion = Participaciones::find($id);
        if (!$participacion) {
            return response()->json(['message' => 'Participación no encontrada'], 404);
        }

        $participacion->update($request->all());
        return response()->json([
            'message' => 'Participación actualizada correctamente',
            'participacion' => $participacion,
            'status' => 200
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $participacion = Participaciones::find($id);
        if (!$participacion) {
            return response()->json(['message' => 'Participación no encontrada'], 404);
        }

        $participacion->delete();
        return response()->json([
            'message' => 'Participación eliminada correctamente',
            'status' => 200
        ], 200);
    }
}
