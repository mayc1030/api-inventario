<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

/**
 * Controlador para autenticación de usuarios.
 *
 * Maneja el registro, login y logout usando tokens API con Laravel Sanctum.
 */
class AuthController extends Controller
{
    /**
     * Registro de un nuevo usuario.
     *
     * Valida los datos recibidos, asigna rol (solo admin puede asignar rol explícito),
     * crea el usuario con la contraseña hasheada y responde con mensaje de éxito.
     *
     * @param Request $request Datos de registro: name, email, password (+ confirmado), role opcional
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        // Validar datos recibidos
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed', // 'confirmed' requiere campo password_confirmation
            'role' => 'sometimes|in:admin,user', // Rol opcional y solo valores permitidos
        ]);

        // Por defecto el rol será 'user'
        $role = 'user';

        // Solo un usuario admin autenticado puede asignar rol explícito
        if ($request->user()?->role === 'admin' && isset($validated['role'])) {
            $role = $validated['role'];
        }

        // Crear usuario en base de datos con password hasheada
        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $role,
        ]);

        return response()->json(['message' => 'Usuario creado con éxito.'], 201);
    }

    /**
     * Login de usuario.
     *
     * Valida credenciales, verifica la contraseña y genera un token API.
     *
     * @param Request $request Datos de login: email y password
     * @return \Illuminate\Http\JsonResponse Token o error
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Buscar usuario por email
        $user = User::where('email', $credentials['email'])->first();

        // Verificar usuario y contraseña
        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return response()->json(['message' => 'Credenciales inválidas.'], 401);
        }

        // Crear token API para el usuario autenticado
        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json(['token' => $token]);
    }

    /**
     * Logout de usuario.
     *
     * Elimina el token de acceso actual para invalidar la sesión.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse Mensaje de sesión cerrada
     */
    public function logout(Request $request)
    {
        // Borra el token actual (el que se usó para hacer la petición)
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Sesión cerrada.']);
    }
}
