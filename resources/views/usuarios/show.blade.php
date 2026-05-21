@extends('layouts.app')
@section('titulo', 'Detalle de usuario - ADOESC')

@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="text-adoesc mb-0"><i class="bi bi-person"></i> {{ $usuario->nombre }}</h3>
    <a href="{{ route('usuarios.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Volver</a>
</div>

<div class="card shadow-sm mb-4">
    <div class="card-body">
        <dl class="row mb-0">
            <dt class="col-sm-3">Correo</dt><dd class="col-sm-9">{{ $usuario->email }}</dd>
            <dt class="col-sm-3">Teléfono</dt><dd class="col-sm-9">{{ $usuario->telefono ?? '—' }}</dd>
            <dt class="col-sm-3">Rol</dt><dd class="col-sm-9"><span class="badge bg-success">{{ $usuario->rol->nombre ?? 'Sin rol' }}</span></dd>
        </dl>
    </div>
</div>

<h5 class="text-adoesc">Eventos del usuario</h5>
<div class="card shadow-sm">
    <div class="card-body p-0">
        <table class="table mb-0">
            <thead class="table-light"><tr><th>Evento</th><th>Fecha</th><th>Lugar</th></tr></thead>
            <tbody>
                @forelse($usuario->eventos as $evento)
                    <tr>
                        <td>{{ $evento->nombre_evento }}</td>
                        <td>{{ $evento->fecha?->format('d/m/Y') }}</td>
                        <td>{{ $evento->lugar }}</td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="text-center text-muted py-3">Este usuario no tiene eventos.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
