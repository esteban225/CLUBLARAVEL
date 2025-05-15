<?php

namespace App\Http\Controllers;

use App\Models\Prestamos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PrestamosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $prestamos = Prestamos::all();
        if ($prestamos->isEmpty()) {
            return response()->json(['message' => 'No hay prestamos registrados'], 404);
        }
        return response()->json($prestamos);
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
            'asociados_id' => 'required|integer|exists:asociados,id',
            'valor_prestamo' => 'required|numeric',
            'fecha_prestamo' => 'required|date',
            'numero_cuotas' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $prestamo = Prestamos::create($request->all());
        if ($prestamo) {
            return response()->json([
                'message' => 'Prestamo registrado correctamente',
                'prestamo' => $prestamo,
                'status' => 201
            ], 201);
        }
        return response()->json($prestamo, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $prestamo = Prestamos::find($id);
        if (!$prestamo) {
            return response()->json(['message' => 'Prestamo no encontrado'], 404);
        }
        return response()->json($prestamo);
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
        $validator = Validator::make($request->all(), [
            'asociados_id' => 'sometimes|required|integer|exists:asociados,id',
            'valor_prestamo' => 'sometimes|required|numeric',
            'fecha_prestamo' => 'sometimes|required|date',
            'numero_cuotas' => 'sometimes|required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $prestamo = Prestamos::find($id);
        if (!$prestamo) {
            return response()->json(['message' => 'Prestamo no encontrado'], 404);
        }

        $prestamo->update($request->all());
        return response()->json([
            'message' => 'Prestamo actualizado correctamente',
            'prestamo' => $prestamo,
            'status' => 200
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $prestamo = Prestamos::find($id);
        if (!$prestamo) {
            return response()->json(['message' => 'Prestamo no encontrado'], 404);
        }
        $prestamo->delete();
        return response()->json(['message' => 'Prestamo eliminado correctamente'], 200);
    }
}
