@extends('layouts.app')
@section('titulo', 'Categorías - ADOESC')

@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="text-adoesc mb-0"><i class="bi bi-tags"></i> Categorías de servicio</h3>
    @unless(auth()->user()->esInvitado())
        <a href="{{ route('categorias.create') }}" class="btn btn-adoesc"><i class="bi bi-plus-lg"></i> Nueva categoría</a>
    @endunless
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover mb-0 align-middle">
            <thead class="table-light">
                <tr><th>Nombre</th><th>Servicios</th><th class="text-end">Acciones</th></tr>
            </thead>
            <tbody>
                @forelse($categorias as $categoria)
                    <tr>
                        <td>{{ $categoria->nombre }}</td>
                        <td><span class="badge bg-secondary">{{ $categoria->servicios_count }}</span></td>
                        <td class="text-end">
                            <a href="{{ route('categorias.show', $categoria) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-eye"></i></a>
                            @unless(auth()->user()->esInvitado())
                                <a href="{{ route('categorias.edit', $categoria) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('categorias.destroy', $categoria) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('¿Eliminar esta categoría?');">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            @endunless
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="text-center text-muted py-4">No hay categorías registradas.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">{{ $categorias->links() }}</div>
@endsection
