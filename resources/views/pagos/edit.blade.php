@extends('layouts.app')
@section('titulo', 'Editar pago - ADOESC')

@section('contenido')
<div class="card shadow-sm">
    <div class="card-header card-header-adoesc"><i class="bi bi-pencil"></i> Editar pago</div>
    <div class="card-body">
        <form method="POST" action="{{ route('pagos.update', $pago) }}">
            @csrf @method('PUT')
            @include('pagos._form')
            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('pagos.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                <button type="submit" class="btn btn-adoesc">Actualizar</button>
            </div>
        </form>
    </div>
</div>
@endsection
