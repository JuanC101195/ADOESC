<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventoRequest;
use App\Models\Evento;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * CRUD de eventos. El Organizador solo gestiona sus propios eventos;
 * el Administrador gestiona todos; el Invitado solo consulta.
 */
class EventoController extends Controller implements HasMiddleware
{
    /**
     * Restringe la creación/edición/borrado a Administrador y Organizador.
     */
    public static function middleware(): array
    {
        return [
            new Middleware('rol:Administrador,Organizador', except: ['index', 'show']),
        ];
    }

    /**
     * Lista los eventos. El organizador solo ve los suyos.
     */
    public function index(): View
    {
        $usuario = Auth::user();
        $consulta = Evento::with('usuario')->orderByDesc('fecha');

        if ($usuario->esOrganizador()) {
            $consulta->where('id_usuario', $usuario->id_usuario);
        }

        $eventos = $consulta->paginate(10);

        return view('eventos.index', compact('eventos'));
    }

    /**
     * Muestra el formulario de creación de un evento.
     */
    public function create(): View
    {
        $organizadores = $this->organizadoresDisponibles();

        return view('eventos.create', compact('organizadores'));
    }

    /**
     * Guarda un nuevo evento en la BD.
     */
    public function store(EventoRequest $request): RedirectResponse
    {
        $datos = $request->validated();

        // Un organizador solo puede crear eventos a su propio nombre.
        if (Auth::user()->esOrganizador()) {
            $datos['id_usuario'] = Auth::id();
        }

        Evento::create($datos);

        return redirect()->route('eventos.index')
            ->with('success', 'Evento creado correctamente.');
    }

    /**
     * Muestra el detalle de un evento con sus reservas.
     */
    public function show(Evento $evento): View
    {
        $evento->load('usuario', 'reservas.servicio');

        return view('eventos.show', compact('evento'));
    }

    /**
     * Muestra el formulario de edición de un evento.
     */
    public function edit(Evento $evento): View
    {
        $this->autorizarPropietario($evento);
        $organizadores = $this->organizadoresDisponibles();

        return view('eventos.edit', compact('evento', 'organizadores'));
    }

    /**
     * Actualiza un evento existente.
     */
    public function update(EventoRequest $request, Evento $evento): RedirectResponse
    {
        $this->autorizarPropietario($evento);
        $datos = $request->validated();

        if (Auth::user()->esOrganizador()) {
            $datos['id_usuario'] = Auth::id();
        }

        $evento->update($datos);

        return redirect()->route('eventos.index')
            ->with('success', 'Evento actualizado correctamente.');
    }

    /**
     * Elimina un evento.
     */
    public function destroy(Evento $evento): RedirectResponse
    {
        $this->autorizarPropietario($evento);
        $evento->delete();

        return redirect()->route('eventos.index')
            ->with('success', 'Evento eliminado correctamente.');
    }

    /**
     * Lista de organizadores para el selector (solo necesario para el admin).
     */
    private function organizadoresDisponibles()
    {
        return User::whereHas('rol', fn ($q) => $q->whereIn('nombre', ['Administrador', 'Organizador']))
            ->orderBy('nombre')
            ->get();
    }

    /**
     * Verifica que un organizador solo manipule sus propios eventos.
     */
    private function autorizarPropietario(Evento $evento): void
    {
        $usuario = Auth::user();

        if ($usuario->esOrganizador() && $evento->id_usuario !== $usuario->id_usuario) {
            abort(403, 'Solo puedes gestionar tus propios eventos.');
        }
    }
}
