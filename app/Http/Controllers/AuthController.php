<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }



        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        try {
            $token = JWTAuth::fromUser($user);


            return response()->json([
                'success' => true,
                'message' => 'Usuario registrado correctamente',
                'user' => $user,
                'token' => $token,
                'status' => 201
            ], 201);
        } catch (\Throwable $e) {
            return response()->json([

                'success' => false,
                'message' => 'Error al crear el token',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function login(Request $request)
    {
        $response = [];
        $statusCode = 200;

        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            $response = $validator->errors();
            $statusCode = 422;
        } else {
            $credentials = $request->only('email', 'password');

            try {
                if (!$token = JWTAuth::attempt($credentials)) {
                    $response = [
                        'success' => false,
                        'message' => 'Credenciales incorrectas'
                    ];
                    $statusCode = 401;
                } else {
                    $response = [
                        'success' => true,
                        'message' => 'Usuario autenticado correctamente',
                        'token' => $token,
                        'status' => 200
                    ];
                }
            } catch (\Throwable $e) {
                $response = [
                    'success' => false,
                    'message' => 'Error al intentar iniciar sesión',
                    'error' => $e->getMessage()
                ];
                $statusCode = 500;
            }
        }

        return response()->json($response, $statusCode);
    }

    public function refresh()
    {
        try {
            $newToken = JWTAuth::parseToken()->refresh();

            return response()->json([
                'success' => true,
                'token' => $newToken,
                'status' => 200
            ]);
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Token inválido',
            ], 401);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al refrescar el token',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function logout()
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());

            return response()->json([
                'success' => true,
                'message' => 'Usuario desconectado correctamente',
                'status' => 200
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al intentar cerrar sesión',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function user()
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();

            return response()->json([
                'success' => true,
                'user' => $user,
                'status' => 200
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener el usuario',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
