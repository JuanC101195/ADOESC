<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReservaRequest;
use App\Models\Evento;
use App\Models\Reserva;
use App\Models\Servicio;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * CRUD de reservas (asocian un evento con un servicio contratado).
 */
class ReservaController extends Controller implements HasMiddleware
{
    /** Solo Administrador y Organizador pueden modificar. */
    public static function middleware(): array
    {
        return [
            new Middleware('rol:Administrador,Organizador', except: ['index', 'show']),
        ];
    }

    /** Lista las reservas. El organizador solo ve las de sus eventos. */
    public function index(): View
    {
        $usuario = Auth::user();
        $consulta = Reserva::with('evento.usuario', 'servicio')->orderByDesc('fecha_reserva');

        if ($usuario->esOrganizador()) {
            $consulta->whereHas('evento', fn ($q) => $q->where('id_usuario', $usuario->id_usuario));
        }

        $reservas = $consulta->paginate(10);

        return view('reservas.index', compact('reservas'));
    }

    /** Formulario de creación con selects de evento y servicio. */
    public function create(): View
    {
        return view('reservas.create', $this->datosFormulario());
    }

    /** Guarda una nueva reserva. */
    public function store(ReservaRequest $request): RedirectResponse
    {
        Reserva::create($request->validated());

        return redirect()->route('reservas.index')
            ->with('success', 'Reserva creada correctamente.');
    }

    /** Detalle de la reserva con sus pagos. */
    public function show(Reserva $reserva): View
    {
        $reserva->load('evento.usuario', 'servicio.proveedor', 'pagos');

        return view('reservas.show', compact('reserva'));
    }

    /** Formulario de edición. */
    public function edit(Reserva $reserva): View
    {
        return view('reservas.edit', array_merge(['reserva' => $reserva], $this->datosFormulario()));
    }

    /** Actualiza la reserva. */
    public function update(ReservaRequest $request, Reserva $reserva): RedirectResponse
    {
        $reserva->update($request->validated());

        return redirect()->route('reservas.index')
            ->with('success', 'Reserva actualizada correctamente.');
    }

    /** Elimina la reserva. */
    public function destroy(Reserva $reserva): RedirectResponse
    {
        if ($reserva->pagos()->exists()) {
            return back()->with('error', 'No se puede eliminar: la reserva tiene pagos registrados.');
        }

        $reserva->delete();

        return redirect()->route('reservas.index')
            ->with('success', 'Reserva eliminada correctamente.');
    }

    /** Datos comunes (eventos y servicios) para los formularios. */
    private function datosFormulario(): array
    {
        $usuario = Auth::user();
        $consultaEventos = Evento::orderBy('nombre_evento');

        // El organizador solo puede reservar para sus propios eventos.
        if ($usuario->esOrganizador()) {
            $consultaEventos->where('id_usuario', $usuario->id_usuario);
        }

        return [
            'eventos' => $consultaEventos->get(),
            'servicios' => Servicio::with('proveedor')->orderBy('nombre')->get(),
            'estados' => Reserva::ESTADOS,
        ];
    }
}
