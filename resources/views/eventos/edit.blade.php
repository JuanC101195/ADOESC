@extends('layouts.app')
@section('titulo', 'Editar evento - ADOESC')

@section('contenido')
<div class="card shadow-sm">
    <div class="card-header card-header-adoesc"><i class="bi bi-pencil"></i> Editar evento</div>
    <div class="card-body">
        <form method="POST" action="{{ route('eventos.update', $evento) }}">
            @csrf @method('PUT')
            @include('eventos._form')
            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('eventos.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                <button type="submit" class="btn btn-adoesc">Actualizar</button>
            </div>
        </form>
    </div>
</div>
@endsection
