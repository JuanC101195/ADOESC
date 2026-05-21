@extends('layouts.app')
@section('titulo', 'Detalle de proveedor - ADOESC')

@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="text-adoesc mb-0"><i class="bi bi-truck"></i> {{ $proveedor->nombre }}</h3>
    <a href="{{ route('proveedores.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Volver</a>
</div>

<div class="card shadow-sm mb-4">
    <div class="card-body">
        <dl class="row mb-0">
            <dt class="col-sm-3">Teléfono</dt><dd class="col-sm-9">{{ $proveedor->telefono }}</dd>
            <dt class="col-sm-3">Categoría</dt><dd class="col-sm-9">{{ $proveedor->categoria }}</dd>
        </dl>
    </div>
</div>

<h5 class="text-adoesc">Servicios que ofrece</h5>
<div class="card shadow-sm">
    <div class="card-body p-0">
        <table class="table mb-0">
            <thead class="table-light"><tr><th>Servicio</th><th>Categoría</th><th>Precio</th></tr></thead>
            <tbody>
                @forelse($proveedor->servicios as $servicio)
                    <tr>
                        <td>{{ $servicio->nombre }}</td>
                        <td>{{ $servicio->categoria->nombre ?? '—' }}</td>
                        <td>${{ number_format($servicio->precio ?? 0, 2) }}</td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="text-center text-muted py-3">Este proveedor no tiene servicios.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
