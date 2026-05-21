@extends('layouts.app')
@section('titulo', 'Nuevo proveedor - ADOESC')

@section('contenido')
<div class="card shadow-sm">
    <div class="card-header card-header-adoesc"><i class="bi bi-plus-lg"></i> Nuevo proveedor</div>
    <div class="card-body">
        <form method="POST" action="{{ route('proveedores.store') }}">
            @csrf
            @include('proveedores._form')
            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('proveedores.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                <button type="submit" class="btn btn-adoesc">Guardar</button>
            </div>
        </form>
    </div>
</div>
@endsection
