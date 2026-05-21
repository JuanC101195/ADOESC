@extends('layouts.app')
@section('titulo', 'Detalle de pago - ADOESC')

@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="text-adoesc mb-0"><i class="bi bi-cash-coin"></i> Pago #{{ $pago->id_pago }}</h3>
    <a href="{{ route('pagos.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Volver</a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <dl class="row mb-0">
            <dt class="col-sm-3">Reserva</dt><dd class="col-sm-9">#{{ $pago->id_reserva }}</dd>
            <dt class="col-sm-3">Evento</dt><dd class="col-sm-9">{{ $pago->reserva->evento->nombre_evento ?? '—' }}</dd>
            <dt class="col-sm-3">Servicio</dt><dd class="col-sm-9">{{ $pago->reserva->servicio->nombre ?? '—' }}</dd>
            <dt class="col-sm-3">Monto</dt><dd class="col-sm-9">${{ number_format($pago->monto ?? 0, 2) }}</dd>
            <dt class="col-sm-3">Fecha de pago</dt><dd class="col-sm-9">{{ $pago->fecha_pago?->format('d/m/Y') }}</dd>
        </dl>
    </div>
</div>
@endsection
