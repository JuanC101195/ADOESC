<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\Pago;
use App\Models\Reserva;
use App\Models\Servicio;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * Controlador del panel principal. Muestra información distinta según el rol.
 */
class DashboardController extends Controller
{
    /**
     * Arma el dashboard según el rol del usuario autenticado.
     */
    public function index(): View
    {
        $usuario = Auth::user();

        // Estadísticas base visibles para todos los roles.
        $estadisticas = [
            'totalEventos' => Evento::count(),
            'totalServicios' => Servicio::count(),
            'totalReservas' => Reserva::count(),
            'totalPagos' => Pago::count(),
        ];

        // El organizador ve además el conteo de SUS eventos.
        if ($usuario->esOrganizador()) {
            $estadisticas['misEventos'] = Evento::where('id_usuario', $usuario->id_usuario)->count();
        }

        // El administrador ve además el total de usuarios.
        if ($usuario->esAdministrador()) {
            $estadisticas['totalUsuarios'] = User::count();
        }

        // Próximos eventos (los del organizador si aplica, todos para admin/invitado).
        $consultaEventos = Evento::with('usuario')->orderBy('fecha');
        if ($usuario->esOrganizador()) {
            $consultaEventos->where('id_usuario', $usuario->id_usuario);
        }
        $proximosEventos = $consultaEventos->take(5)->get();

        return view('dashboard', compact('usuario', 'estadisticas', 'proximosEventos'));
    }
}
