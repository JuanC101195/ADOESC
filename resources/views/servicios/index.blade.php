@extends('layouts.app')
@section('titulo', 'Servicios - ADOESC')

@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="text-adoesc mb-0"><i class="bi bi-gear-wide-connected"></i> Servicios</h3>
    @unless(auth()->user()->esInvitado())
        <a href="{{ route('servicios.create') }}" class="btn btn-adoesc"><i class="bi bi-plus-lg"></i> Nuevo servicio</a>
    @endunless
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover mb-0 align-middle">
            <thead class="table-light">
                <tr><th>Nombre</th><th>Categoría</th><th>Proveedor</th><th>Precio</th><th class="text-end">Acciones</th></tr>
            </thead>
            <tbody>
                @forelse($servicios as $servicio)
                    <tr>
                        <td>{{ $servicio->nombre }}</td>
                        <td>{{ $servicio->categoria->nombre ?? '—' }}</td>
                        <td>{{ $servicio->proveedor->nombre ?? '—' }}</td>
                        <td>${{ number_format($servicio->precio ?? 0, 2) }}</td>
                        <td class="text-end">
                            <a href="{{ route('servicios.show', $servicio) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-eye"></i></a>
                            @unless(auth()->user()->esInvitado())
                                <a href="{{ route('servicios.edit', $servicio) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('servicios.destroy', $servicio) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('¿Eliminar este servicio?');">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            @endunless
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted py-4">No hay servicios registrados.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">{{ $servicios->links() }}</div>
@endsection
