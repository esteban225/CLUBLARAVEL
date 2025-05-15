<?php

namespace App\Http\Controllers;

use App\Models\Pagos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PagosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pagos = Pagos::all();
        if ($pagos->isEmpty()) {
            return response()->json(['message' => 'No hay pagos registrados'], 404);
        }
        return response()->json($pagos);
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
            'prestamos_id' => 'required|integer|exists:prestamos,id',
            'valor_pago' => 'required|numeric',
            'fecha_pago' => 'required|date',
            'numero_cuota' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $pago = Pagos::create($request->all());
        if ($pago) {
            return response()->json([
                'message' => 'Pago registrado correctamente',
                'pago' => $pago,
                'status' => 201
            ], 201);
        }
        return response()->json($pago, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pago = Pagos::find($id);
        if (!$pago) {
            return response()->json(['message' => 'Pago no encontrado'], 404);
        }
        return response()->json($pago);
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
            'prestamos_id' => 'sometimes|required|integer|exists:prestamos,id',
            'valor_pago' => 'sometimes|required|numeric',
            'fecha_pago' => 'sometimes|required|date',
            'numero_cuota' => 'sometimes|required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $pago = Pagos::find($id);
        if (!$pago) {
            return response()->json(['message' => 'Pago no encontrado'], 404);
        }

        $pago->update($request->all());
        return response()->json([
            'message' => 'Pago actualizado correctamente',
            'pago' => $pago,
            'status' => 200
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pago = Pagos::find($id);
        if (!$pago) {
            return response()->json(['message' => 'Pago no encontrado'], 404);
        }

        $pago->delete();
        return response()->json(['message' => 'Pago eliminado correctamente'], 200);
    }
}
