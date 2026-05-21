<?php

namespace App\Http\Controllers;

use App\Http\Requests\PagoRequest;
use App\Models\Pago;
use App\Models\Reserva;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\View\View;

/**
 * CRUD de pagos asociados a reservas.
 */
class PagoController extends Controller implements HasMiddleware
{
    /** Solo Administrador y Organizador pueden modificar. */
    public static function middleware(): array
    {
        return [
            new Middleware('rol:Administrador,Organizador', except: ['index', 'show']),
        ];
    }

    /** Lista todos los pagos. */
    public function index(): View
    {
        $pagos = Pago::with('reserva.evento', 'reserva.servicio')->orderByDesc('fecha_pago')->paginate(10);

        return view('pagos.index', compact('pagos'));
    }

    /** Formulario de creación con selector de reserva. */
    public function create(): View
    {
        $reservas = Reserva::with('evento', 'servicio')->orderByDesc('fecha_reserva')->get();

        return view('pagos.create', compact('reservas'));
    }

    /** Registra un nuevo pago. */
    public function store(PagoRequest $request): RedirectResponse
    {
        Pago::create($request->validated());

        return redirect()->route('pagos.index')
            ->with('success', 'Pago registrado correctamente.');
    }

    /** Detalle del pago. */
    public function show(Pago $pago): View
    {
        $pago->load('reserva.evento', 'reserva.servicio');

        return view('pagos.show', compact('pago'));
    }

    /** Formulario de edición. */
    public function edit(Pago $pago): View
    {
        $reservas = Reserva::with('evento', 'servicio')->orderByDesc('fecha_reserva')->get();

        return view('pagos.edit', compact('pago', 'reservas'));
    }

    /** Actualiza el pago. */
    public function update(PagoRequest $request, Pago $pago): RedirectResponse
    {
        $pago->update($request->validated());

        return redirect()->route('pagos.index')
            ->with('success', 'Pago actualizado correctamente.');
    }

    /** Elimina el pago. */
    public function destroy(Pago $pago): RedirectResponse
    {
        $pago->delete();

        return redirect()->route('pagos.index')
            ->with('success', 'Pago eliminado correctamente.');
    }
}
