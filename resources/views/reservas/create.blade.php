@extends('layouts.app')
@section('titulo', 'Nueva reserva - ADOESC')

@section('contenido')
<div class="card shadow-sm">
    <div class="card-header card-header-adoesc"><i class="bi bi-plus-lg"></i> Nueva reserva</div>
    <div class="card-body">
        <form method="POST" action="{{ route('reservas.store') }}">
            @csrf
            @include('reservas._form')
            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('reservas.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                <button type="submit" class="btn btn-adoesc">Guardar</button>
            </div>
        </form>
    </div>
</div>
@endsection
