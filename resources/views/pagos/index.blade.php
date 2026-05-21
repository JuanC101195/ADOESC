@extends('layouts.app')
@section('titulo', 'Pagos - ADOESC')

@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="text-adoesc mb-0"><i class="bi bi-cash-coin"></i> Pagos</h3>
    @unless(auth()->user()->esInvitado())
        <a href="{{ route('pagos.create') }}" class="btn btn-adoesc"><i class="bi bi-plus-lg"></i> Registrar pago</a>
    @endunless
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover mb-0 align-middle">
            <thead class="table-light">
                <tr><th>Reserva</th><th>Evento</th><th>Monto</th><th>Fecha</th><th class="text-end">Acciones</th></tr>
            </thead>
            <tbody>
                @forelse($pagos as $pago)
                    <tr>
                        <td>#{{ $pago->id_reserva }}</td>
                        <td>{{ $pago->reserva->evento->nombre_evento ?? '—' }}</td>
                        <td>${{ number_format($pago->monto ?? 0, 2) }}</td>
                        <td>{{ $pago->fecha_pago?->format('d/m/Y') }}</td>
                        <td class="text-end">
                            <a href="{{ route('pagos.show', $pago) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-eye"></i></a>
                            @unless(auth()->user()->esInvitado())
                                <a href="{{ route('pagos.edit', $pago) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('pagos.destroy', $pago) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('¿Eliminar este pago?');">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            @endunless
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted py-4">No hay pagos registrados.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">{{ $pagos->links() }}</div>
@endsection
