@extends('layouts.app')
@section('titulo', 'Detalle de reserva - ADOESC')

@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="text-adoesc mb-0"><i class="bi bi-bookmark-check"></i> Reserva #{{ $reserva->id_reserva }}</h3>
    <a href="{{ route('reservas.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Volver</a>
</div>

<div class="card shadow-sm mb-4">
    <div class="card-body">
        <dl class="row mb-0">
            <dt class="col-sm-3">Evento</dt><dd class="col-sm-9">{{ $reserva->evento->nombre_evento ?? '—' }}</dd>
            <dt class="col-sm-3">Servicio</dt><dd class="col-sm-9">{{ $reserva->servicio->nombre ?? '—' }}</dd>
            <dt class="col-sm-3">Proveedor</dt><dd class="col-sm-9">{{ $reserva->servicio->proveedor->nombre ?? '—' }}</dd>
            <dt class="col-sm-3">Fecha reserva</dt><dd class="col-sm-9">{{ $reserva->fecha_reserva?->format('d/m/Y') }}</dd>
            <dt class="col-sm-3">Estado</dt><dd class="col-sm-9"><span class="badge bg-secondary">{{ $reserva->estado }}</span></dd>
        </dl>
    </div>
</div>

<h5 class="text-adoesc">Pagos registrados</h5>
<div class="card shadow-sm">
    <div class="card-body p-0">
        <table class="table mb-0">
            <thead class="table-light"><tr><th>Monto</th><th>Fecha de pago</th></tr></thead>
            <tbody>
                @forelse($reserva->pagos as $pago)
                    <tr>
                        <td>${{ number_format($pago->monto ?? 0, 2) }}</td>
                        <td>{{ $pago->fecha_pago?->format('d/m/Y') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="2" class="text-center text-muted py-3">Sin pagos para esta reserva.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
