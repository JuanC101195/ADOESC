@extends('layouts.app')
@section('titulo', 'Nuevo usuario - ADOESC')

@section('contenido')
<div class="card shadow-sm">
    <div class="card-header card-header-adoesc"><i class="bi bi-plus-lg"></i> Nuevo usuario</div>
    <div class="card-body">
        <form method="POST" action="{{ route('usuarios.store') }}">
            @csrf
            @include('usuarios._form')
            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('usuarios.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                <button type="submit" class="btn btn-adoesc">Guardar</button>
            </div>
        </form>
    </div>
</div>
@endsection
