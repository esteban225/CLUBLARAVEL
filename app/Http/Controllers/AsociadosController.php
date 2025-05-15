<?php

namespace App\Http\Controllers;

use App\Models\Asociados;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Illuminate\Routing\Controller;
class AsociadosController extends Controller
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
        $asociados = Asociados::all();
        if ($asociados->isEmpty()) {
            return response()->json(['message' => 'No hay asociados registrados'], 404);
        }
        return response()->json($asociados);
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
            'documento' => 'required|string|max:255',
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'fecha_nacimiento' => 'required|date',
            'direccion_recidencia' => 'required|string|max:255',
            'telefono' => 'required|string|max:255',
            'email' => 'required|email|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $asociado = Asociados::create($request->all());
        if ($asociado) {
            return response()->json([
                'message' => 'Asociado registrado correctamente',
                'asociado' => $asociado,
                'status' => 201
            ], 201);
        }
        return response()->json($asociado, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $asociado = Asociados::find($id);
        if (!$asociado) {
            return response()->json(['message' => 'Asociado no encontrado'], 404);
        }
        return response()->json($asociado);
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
            'documento' => 'string|max:255',
            'nombres' => 'string|max:255',
            'apellidos' => 'string|max:255',
            'fecha_nacimiento' => 'date',
            'direccion_recidencia' => 'string|max:255',
            'telefono' => 'string|max:255',
            'email' => 'email|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $asociado = Asociados::find($id);
        if (!$asociado) {
            return response()->json(['message' => 'Asociado no encontrado'], 404);
        }

        $asociado->update($request->all());
        return response()->json([
            'message' => 'Asociado actualizado correctamente',
            'asociado' => $asociado,
            'status' => 200
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $asociado = Asociados::find($id);
        if (!$asociado) {
            return response()->json(['message' => 'Asociado no encontrado'], 404);
        }

        $asociado->delete();
        return response()->json([
            'message' => 'Asociado eliminado correctamente',
            'status' => 200
        ], 200);
    }
}
