@extends('layouts.app')
@section('titulo', 'Detalle de servicio - ADOESC')

@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="text-adoesc mb-0"><i class="bi bi-gear-wide-connected"></i> {{ $servicio->nombre }}</h3>
    <a href="{{ route('servicios.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Volver</a>
</div>

<div class="card shadow-sm mb-4">
    <div class="card-body">
        <dl class="row mb-0">
            <dt class="col-sm-3">Categoría</dt><dd class="col-sm-9">{{ $servicio->categoria->nombre ?? '—' }}</dd>
            <dt class="col-sm-3">Proveedor</dt><dd class="col-sm-9">{{ $servicio->proveedor->nombre ?? '—' }}</dd>
            <dt class="col-sm-3">Precio</dt><dd class="col-sm-9">${{ number_format($servicio->precio ?? 0, 2) }}</dd>
        </dl>
    </div>
</div>

<h5 class="text-adoesc">Reservas de este servicio</h5>
<div class="card shadow-sm">
    <div class="card-body p-0">
        <table class="table mb-0">
            <thead class="table-light"><tr><th>Evento</th><th>Fecha reserva</th><th>Estado</th></tr></thead>
            <tbody>
                @forelse($servicio->reservas as $reserva)
                    <tr>
                        <td>{{ $reserva->evento->nombre_evento ?? '—' }}</td>
                        <td>{{ $reserva->fecha_reserva?->format('d/m/Y') }}</td>
                        <td><span class="badge bg-secondary">{{ $reserva->estado }}</span></td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="text-center text-muted py-3">Sin reservas para este servicio.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
