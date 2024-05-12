<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;  // Include the Role model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role_id' => 'required|integer|exists:roles,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'activo' => 1,
            'role_id' => $request->role_id,
        ], [ // Add this with clause to eager load the role relationship
            'role'
        ]);

        //Generate token (optional for immediate token return)
         //$token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['message' => 'User registered successfully!'], 201);
    }

    public function login(Request $request)
    {
      $validator = Validator::make($request->all(), [
        'email' => 'required|string|email|exists:users',
        'password' => 'required|string',
      ]);
    
      if ($validator->fails()) {
        return response()->json($validator->errors(), 422);
      }
    
      $credenciales = $request->only(['email', 'password']);
    
      if (Auth::attempt($credenciales)) {
        $usuario = Auth::user();

        // Verifica si el usuario tiene el rol requerido (reemplaza 1 con el ID de tu rol real)
        if ($usuario->role->id === 1) {
            // Genera un token para el usuario usando Sanctum
            $token = $usuario->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message' => '¡Inicio de sesión exitoso!',
                'access_token' => $token,
            ], 200);
        } else {
            return response()->json(['error' => 'El usuario no tiene el rol requerido'], 403);
        }
    } else {
        return response()->json(['error' => 'Credenciales inválidas'], 401);
    }
}
} 