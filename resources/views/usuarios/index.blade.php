@extends('layouts.app')
@section('titulo', 'Usuarios - ADOESC')

@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="text-adoesc mb-0"><i class="bi bi-people"></i> Usuarios</h3>
    <a href="{{ route('usuarios.create') }}" class="btn btn-adoesc"><i class="bi bi-plus-lg"></i> Nuevo usuario</a>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover mb-0 align-middle">
            <thead class="table-light">
                <tr><th>Nombre</th><th>Correo</th><th>Teléfono</th><th>Rol</th><th class="text-end">Acciones</th></tr>
            </thead>
            <tbody>
                @forelse($usuarios as $usuario)
                    <tr>
                        <td>{{ $usuario->nombre }}</td>
                        <td>{{ $usuario->email }}</td>
                        <td>{{ $usuario->telefono ?? '—' }}</td>
                        <td><span class="badge bg-success">{{ $usuario->rol->nombre ?? 'Sin rol' }}</span></td>
                        <td class="text-end">
                            <a href="{{ route('usuarios.show', $usuario) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-eye"></i></a>
                            <a href="{{ route('usuarios.edit', $usuario) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('usuarios.destroy', $usuario) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('¿Eliminar este usuario?');">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted py-4">No hay usuarios registrados.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">{{ $usuarios->links() }}</div>
@endsection
