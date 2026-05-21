@extends('layouts.app')
@section('titulo', 'Detalle del evento - ADOESC')

@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="text-adoesc mb-0"><i class="bi bi-calendar2-event"></i> {{ $evento->nombre_evento }}</h3>
    <a href="{{ route('eventos.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Volver</a>
</div>

<div class="card shadow-sm mb-4">
    <div class="card-body">
        <dl class="row mb-0">
            <dt class="col-sm-3">Fecha</dt><dd class="col-sm-9">{{ $evento->fecha?->format('d/m/Y') }}</dd>
            <dt class="col-sm-3">Lugar</dt><dd class="col-sm-9">{{ $evento->lugar }}</dd>
            <dt class="col-sm-3">Invitados</dt><dd class="col-sm-9">{{ $evento->invitados ?? '—' }}</dd>
            <dt class="col-sm-3">Organizador</dt><dd class="col-sm-9">{{ $evento->usuario->nombre ?? '—' }}</dd>
        </dl>
    </div>
</div>

<h5 class="text-adoesc">Servicios reservados</h5>
<div class="card shadow-sm">
    <div class="card-body p-0">
        <table class="table mb-0">
            <thead class="table-light"><tr><th>Servicio</th><th>Fecha reserva</th><th>Estado</th></tr></thead>
            <tbody>
                @forelse($evento->reservas as $reserva)
                    <tr>
                        <td>{{ $reserva->servicio->nombre ?? '—' }}</td>
                        <td>{{ $reserva->fecha_reserva?->format('d/m/Y') }}</td>
                        <td><span class="badge bg-secondary">{{ $reserva->estado }}</span></td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="text-center text-muted py-3">Sin reservas para este evento.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
