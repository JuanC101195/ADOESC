@extends('layouts.app')
@section('titulo', 'Proveedores - ADOESC')

@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="text-adoesc mb-0"><i class="bi bi-truck"></i> Proveedores</h3>
    @unless(auth()->user()->esInvitado())
        <a href="{{ route('proveedores.create') }}" class="btn btn-adoesc"><i class="bi bi-plus-lg"></i> Nuevo proveedor</a>
    @endunless
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover mb-0 align-middle">
            <thead class="table-light">
                <tr><th>Nombre</th><th>Teléfono</th><th>Categoría</th><th>Servicios</th><th class="text-end">Acciones</th></tr>
            </thead>
            <tbody>
                @forelse($proveedores as $proveedor)
                    <tr>
                        <td>{{ $proveedor->nombre }}</td>
                        <td>{{ $proveedor->telefono }}</td>
                        <td>{{ $proveedor->categoria }}</td>
                        <td><span class="badge bg-secondary">{{ $proveedor->servicios_count }}</span></td>
                        <td class="text-end">
                            <a href="{{ route('proveedores.show', $proveedor) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-eye"></i></a>
                            @unless(auth()->user()->esInvitado())
                                <a href="{{ route('proveedores.edit', $proveedor) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('proveedores.destroy', $proveedor) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('¿Eliminar este proveedor?');">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            @endunless
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted py-4">No hay proveedores registrados.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">{{ $proveedores->links() }}</div>
@endsection
