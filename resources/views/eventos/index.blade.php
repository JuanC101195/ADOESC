@extends('layouts.app')
@section('titulo', 'Eventos - ADOESC')

@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="text-adoesc mb-0"><i class="bi bi-calendar2-event"></i> Eventos</h3>
    @unless(auth()->user()->esInvitado())
        <a href="{{ route('eventos.create') }}" class="btn btn-adoesc"><i class="bi bi-plus-lg"></i> Nuevo evento</a>
    @endunless
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th>Nombre</th>
                    <th>Fecha</th>
                    <th>Lugar</th>
                    <th>Invitados</th>
                    <th>Organizador</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($eventos as $evento)
                    <tr>
                        <td>{{ $evento->nombre_evento }}</td>
                        <td>{{ $evento->fecha?->format('d/m/Y') }}</td>
                        <td>{{ $evento->lugar }}</td>
                        <td>{{ $evento->invitados ?? '—' }}</td>
                        <td>{{ $evento->usuario->nombre ?? '—' }}</td>
                        <td class="text-end">
                            <a href="{{ route('eventos.show', $evento) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-eye"></i></a>
                            @unless(auth()->user()->esInvitado())
                                <a href="{{ route('eventos.edit', $evento) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('eventos.destroy', $evento) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('¿Eliminar este evento?');">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            @endunless
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">No hay eventos registrados.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">{{ $eventos->links() }}</div>
@endsection
