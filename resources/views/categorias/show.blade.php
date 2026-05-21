@extends('layouts.app')
@section('titulo', 'Detalle de categoría - ADOESC')

@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="text-adoesc mb-0"><i class="bi bi-tags"></i> {{ $categoria->nombre }}</h3>
    <a href="{{ route('categorias.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Volver</a>
</div>

<h5 class="text-adoesc">Servicios en esta categoría</h5>
<div class="card shadow-sm">
    <div class="card-body p-0">
        <table class="table mb-0">
            <thead class="table-light"><tr><th>Servicio</th><th>Proveedor</th><th>Precio</th></tr></thead>
            <tbody>
                @forelse($categoria->servicios as $servicio)
                    <tr>
                        <td>{{ $servicio->nombre }}</td>
                        <td>{{ $servicio->proveedor->nombre ?? '—' }}</td>
                        <td>${{ number_format($servicio->precio ?? 0, 2) }}</td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="text-center text-muted py-3">No hay servicios en esta categoría.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
