<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginApiRequest;
use App\Http\Requests\Api\RegistroApiRequest;
use App\Models\Rol;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

/**
 * Servicio web (API REST) de autenticación del proyecto ADOESC.
 *
 * Expone dos operaciones que reciben usuario/contraseña y responden en JSON:
 *  - registro(): da de alta un nuevo usuario.
 *  - login():    verifica las credenciales e informa si la autenticación fue
 *                satisfactoria o devuelve error en la autenticación.
 */
class AuthApiController extends Controller
{
    /**
     * Servicio de REGISTRO.
     * Recibe los datos del usuario, los valida, hashea la contraseña y crea
     * el registro en la tabla `usuario` con el rol "Invitado" por defecto.
     */
    public function registro(RegistroApiRequest $request): JsonResponse
    {
        // En este punto los datos ya fueron validados por RegistroApiRequest.
        $datos = $request->validated();

        // Rol "Invitado" por defecto para los usuarios autorregistrados.
        $rolInvitado = Rol::where('nombre', 'Invitado')->first();

        // Se crea el usuario; la contraseña se almacena hasheada (bcrypt).
        $usuario = new User();
        $usuario->id_rol = $rolInvitado?->id_rol;
        $usuario->nombre = $datos['nombre'];
        $usuario->email = $datos['email'];
        $usuario->telefono = $datos['telefono'] ?? null;
        $usuario->setAttribute('contraseña', Hash::make($datos['password']));
        $usuario->save();

        // Respuesta satisfactoria (código 201: recurso creado).
        return response()->json([
            'success' => true,
            'message' => 'Usuario registrado correctamente.',
            'usuario' => [
                'id' => $usuario->id_usuario,
                'nombre' => $usuario->nombre,
                'email' => $usuario->email,
                'rol' => $rolInvitado?->nombre,
            ],
        ], 201);
    }

    /**
     * Servicio de INICIO DE SESIÓN.
     * Recibe email y contraseña: si las credenciales son correctas devuelve un
     * mensaje de autenticación satisfactoria; en caso contrario, error 401.
     */
    public function login(LoginApiRequest $request): JsonResponse
    {
        $datos = $request->validated();

        // Se busca el usuario por su correo.
        $usuario = User::where('email', $datos['email'])->first();

        // Verificación: el usuario debe existir y la contraseña debe coincidir
        // con el hash almacenado en la columna `contraseña`.
        if (! $usuario || ! Hash::check($datos['password'], $usuario->getAuthPassword())) {
            return response()->json([
                'success' => false,
                'message' => 'Error en la autenticación: el correo o la contraseña son incorrectos.',
            ], 401);
        }

        // Autenticación satisfactoria.
        return response()->json([
            'success' => true,
            'message' => 'Autenticación satisfactoria. Bienvenido ' . $usuario->nombre . '.',
            'usuario' => [
                'id' => $usuario->id_usuario,
                'nombre' => $usuario->nombre,
                'email' => $usuario->email,
                'rol' => $usuario->rol->nombre ?? null,
            ],
        ], 200);
    }
}
