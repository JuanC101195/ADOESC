<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\Rol;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

/**
 * CRUD de usuarios con asignación de rol. Acceso exclusivo del Administrador.
 */
class UserController extends Controller implements HasMiddleware
{
    /** Toda la gestión de usuarios queda restringida al Administrador. */
    public static function middleware(): array
    {
        return [
            new Middleware('rol:Administrador'),
        ];
    }

    /** Lista todos los usuarios con su rol. */
    public function index(): View
    {
        $usuarios = User::with('rol')->orderBy('nombre')->paginate(10);

        return view('usuarios.index', compact('usuarios'));
    }

    /** Formulario de creación. */
    public function create(): View
    {
        $roles = Rol::orderBy('nombre')->get();

        return view('usuarios.create', compact('roles'));
    }

    /** Guarda un nuevo usuario hasheando su contraseña. */
    public function store(UserRequest $request): RedirectResponse
    {
        $datos = $request->validated();

        $usuario = new User();
        $usuario->id_rol = $datos['id_rol'];
        $usuario->nombre = $datos['nombre'];
        $usuario->email = $datos['email'];
        $usuario->telefono = $datos['telefono'] ?? null;
        $usuario->setAttribute('contraseña', Hash::make($datos['password']));
        $usuario->save();

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario creado correctamente.');
    }

    /** Detalle del usuario. */
    public function show(User $usuario): View
    {
        $usuario->load('rol', 'eventos');

        return view('usuarios.show', compact('usuario'));
    }

    /** Formulario de edición. */
    public function edit(User $usuario): View
    {
        $roles = Rol::orderBy('nombre')->get();

        return view('usuarios.edit', compact('usuario', 'roles'));
    }

    /** Actualiza el usuario; la contraseña solo cambia si se ingresa una nueva. */
    public function update(UserRequest $request, User $usuario): RedirectResponse
    {
        $datos = $request->validated();

        $usuario->id_rol = $datos['id_rol'];
        $usuario->nombre = $datos['nombre'];
        $usuario->email = $datos['email'];
        $usuario->telefono = $datos['telefono'] ?? null;

        // Solo re-hashea si el administrador escribió una contraseña nueva.
        if (! empty($datos['password'])) {
            $usuario->setAttribute('contraseña', Hash::make($datos['password']));
        }

        $usuario->save();

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario actualizado correctamente.');
    }

    /** Elimina el usuario, evitando que se borre a sí mismo o a uno con eventos. */
    public function destroy(User $usuario): RedirectResponse
    {
        if ($usuario->id_usuario === Auth::id()) {
            return back()->with('error', 'No puedes eliminar tu propia cuenta.');
        }

        if ($usuario->eventos()->exists()) {
            return back()->with('error', 'No se puede eliminar: el usuario tiene eventos asociados.');
        }

        $usuario->delete();

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario eliminado correctamente.');
    }
}
