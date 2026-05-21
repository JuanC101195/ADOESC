@extends('layouts.app')
@section('titulo', 'Registrar pago - ADOESC')

@section('contenido')
<div class="card shadow-sm">
    <div class="card-header card-header-adoesc"><i class="bi bi-plus-lg"></i> Registrar pago</div>
    <div class="card-body">
        <form method="POST" action="{{ route('pagos.store') }}">
            @csrf
            @include('pagos._form')
            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('pagos.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                <button type="submit" class="btn btn-adoesc">Guardar</button>
            </div>
        </form>
    </div>
</div>
@endsection
