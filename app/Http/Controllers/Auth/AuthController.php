<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Rol;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

/**
 * Controlador de autenticación manual contra la tabla `usuario`.
 *
 * No usa Breeze: maneja login, registro y cierre de sesión directamente,
 * porque la tabla tiene columnas no estándar (email, contraseña).
 */
class AuthController extends Controller
{
    /**
     * Muestra el formulario de inicio de sesión.
     */
    public function mostrarLogin(): View
    {
        return view('auth.login');
    }

    /**
     * Procesa el inicio de sesión validando email y contraseña.
     */
    public function login(Request $request): RedirectResponse
    {
        // Validación de las credenciales en español.
        $credenciales = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ], [
            'email.required' => 'El correo es obligatorio.',
            'email.email' => 'El correo no tiene un formato válido.',
            'password.required' => 'La contraseña es obligatoria.',
        ]);

        $recordar = $request->boolean('remember');

        // Auth::attempt usa getAuthPassword() del modelo para comparar el hash.
        if (Auth::attempt($credenciales, $recordar)) {
            $request->session()->regenerate();

            return redirect()->intended(route('dashboard'))
                ->with('success', '¡Bienvenido de nuevo!');
        }

        // Si falla, regresamos con el mensaje de error y conservamos el email.
        return back()
            ->withInput($request->only('email'))
            ->with('error', 'Las credenciales no coinciden con nuestros registros.');
    }

    /**
     * Muestra el formulario de registro de nuevos usuarios.
     */
    public function mostrarRegistro(): View
    {
        return view('auth.register');
    }

    /**
     * Registra un nuevo usuario con rol "Invitado" por defecto.
     */
    public function registrar(Request $request): RedirectResponse
    {
        // Validación de los datos del nuevo usuario.
        $datos = $request->validate([
            'nombre' => ['required', 'string', 'max:60'],
            'email' => ['required', 'email', 'max:80', 'unique:usuario,email'],
            'telefono' => ['nullable', 'string', 'max:15'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'email.required' => 'El correo es obligatorio.',
            'email.unique' => 'Ya existe un usuario con ese correo.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 6 caracteres.',
            'password.confirmed' => 'La confirmación de la contraseña no coincide.',
        ]);

        // Rol "Invitado" por defecto para los autorregistros.
        $rolInvitado = Rol::where('nombre', 'Invitado')->first();

        // Creamos el usuario hasheando la contraseña en la columna `contraseña`.
        $usuario = User::create([
            'id_rol' => $rolInvitado?->id_rol,
            'nombre' => $datos['nombre'],
            'email' => $datos['email'],
            'telefono' => $datos['telefono'] ?? null,
            'contraseña' => Hash::make($datos['password']),
        ]);

        // Iniciamos sesión automáticamente tras el registro.
        Auth::login($usuario);
        $request->session()->regenerate();

        return redirect()->route('dashboard')
            ->with('success', '¡Cuenta creada correctamente!');
    }

    /**
     * Cierra la sesión del usuario actual.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Sesión cerrada correctamente.');
    }
}
