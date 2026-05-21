@extends('layouts.app')
@section('titulo', 'Reservas - ADOESC')

@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="text-adoesc mb-0"><i class="bi bi-bookmark-check"></i> Reservas</h3>
    @unless(auth()->user()->esInvitado())
        <a href="{{ route('reservas.create') }}" class="btn btn-adoesc"><i class="bi bi-plus-lg"></i> Nueva reserva</a>
    @endunless
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover mb-0 align-middle">
            <thead class="table-light">
                <tr><th>Evento</th><th>Servicio</th><th>Fecha reserva</th><th>Estado</th><th class="text-end">Acciones</th></tr>
            </thead>
            <tbody>
                @forelse($reservas as $reserva)
                    <tr>
                        <td>{{ $reserva->evento->nombre_evento ?? '—' }}</td>
                        <td>{{ $reserva->servicio->nombre ?? '—' }}</td>
                        <td>{{ $reserva->fecha_reserva?->format('d/m/Y') }}</td>
                        <td>
                            @php($color = ['Pendiente' => 'warning', 'Confirmado' => 'success', 'Cancelado' => 'danger'][$reserva->estado] ?? 'secondary')
                            <span class="badge bg-{{ $color }}">{{ $reserva->estado }}</span>
                        </td>
                        <td class="text-end">
                            <a href="{{ route('reservas.show', $reserva) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-eye"></i></a>
                            @unless(auth()->user()->esInvitado())
                                <a href="{{ route('reservas.edit', $reserva) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('reservas.destroy', $reserva) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('¿Eliminar esta reserva?');">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            @endunless
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted py-4">No hay reservas registradas.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">{{ $reservas->links() }}</div>
@endsection
