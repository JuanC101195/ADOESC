<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware que restringe el acceso a rutas según el rol del usuario autenticado.
 *
 * Uso en rutas:  ->middleware('rol:Administrador,Organizador')
 */
class RoleMiddleware
{
    /**
     * Verifica que el usuario esté autenticado y que su rol esté permitido.
     */
    public function handle(Request $request, Closure $next, string ...$rolesPermitidos): Response
    {
        // Si no hay sesión iniciada, lo enviamos al login.
        if (! Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Debes iniciar sesión para continuar.');
        }

        $usuario = Auth::user();

        // Si su rol no está dentro de los permitidos, negamos el acceso.
        $tienePermiso = collect($rolesPermitidos)
            ->contains(fn ($rol) => $usuario->tieneRol($rol));

        if (! $tienePermiso) {
            abort(403, 'No tienes permisos para acceder a esta sección.');
        }

        return $next($request);
    }
}
