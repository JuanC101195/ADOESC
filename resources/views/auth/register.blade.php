@extends('layouts.guest')
@section('titulo', 'Registro - ADOESC')

@section('contenido')
<div class="card shadow auth-card">
    <div class="card-body p-4">
        <h4 class="card-title text-adoesc mb-3">Crear cuenta</h4>
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre completo</label>
                <input type="text" name="nombre" id="nombre" class="form-control"
                       value="{{ old('nombre') }}" autofocus required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Correo electrónico</label>
                <input type="email" name="email" id="email" class="form-control"
                       value="{{ old('email') }}" required>
            </div>
            <div class="mb-3">
                <label for="telefono" class="form-label">Teléfono <span class="text-muted">(opcional)</span></label>
                <input type="text" name="telefono" id="telefono" class="form-control"
                       value="{{ old('telefono') }}">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirmar contraseña</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-adoesc w-100">Registrarme</button>
        </form>
        <p class="text-center mt-3 mb-0">
            ¿Ya tienes cuenta? <a href="{{ route('login') }}" class="text-adoesc">Inicia sesión</a>
        </p>
    </div>
</div>
@endsection
