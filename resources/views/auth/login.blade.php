@extends('layouts.guest')
@section('titulo', 'Iniciar sesión - ADOESC')

@section('contenido')
<div class="card shadow auth-card">
    <div class="card-body p-4">
        <h4 class="card-title text-adoesc mb-3">Iniciar sesión</h4>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Correo electrónico</label>
                <input type="email" name="email" id="email" class="form-control"
                       value="{{ old('email') }}" autofocus required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>
            <div class="form-check mb-3">
                <input type="checkbox" name="remember" id="remember" class="form-check-input">
                <label for="remember" class="form-check-label">Recordarme</label>
            </div>
            <button type="submit" class="btn btn-adoesc w-100">Entrar</button>
        </form>
        <p class="text-center mt-3 mb-0">
            ¿No tienes cuenta? <a href="{{ route('register') }}" class="text-adoesc">Regístrate</a>
        </p>
    </div>
</div>
@endsection
