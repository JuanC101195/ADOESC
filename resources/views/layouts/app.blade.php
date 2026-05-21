<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('titulo', 'ADOESC')</title>

    {{-- Bootstrap 5 y Bootstrap Icons por CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        :root { --adoesc-verde: #007940; --adoesc-negro: #111111; }
        body { background-color: #f4f6f5; }
        .navbar-adoesc { background-color: var(--adoesc-negro); }
        .navbar-adoesc .navbar-brand { color: var(--adoesc-verde); font-weight: 700; }
        .navbar-adoesc .nav-link { color: #e9ecef; }
        .navbar-adoesc .nav-link.active, .navbar-adoesc .nav-link:hover { color: var(--adoesc-verde); }
        .btn-adoesc { background-color: var(--adoesc-verde); border-color: var(--adoesc-verde); color: #fff; }
        .btn-adoesc:hover { background-color: #005c30; border-color: #005c30; color: #fff; }
        .text-adoesc { color: var(--adoesc-verde); }
        .card-header-adoesc { background-color: var(--adoesc-verde); color: #fff; }
        a.text-adoesc:hover { color: #005c30; }
    </style>
    @stack('estilos')
</head>
<body>
@auth
    {{-- Barra de navegación: los enlaces se muestran según el rol --}}
    <nav class="navbar navbar-expand-lg navbar-adoesc navbar-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ route('dashboard') }}">
                <i class="bi bi-calendar2-event"></i> ADOESC
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="menu">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('eventos.*') ? 'active' : '' }}" href="{{ route('eventos.index') }}">Eventos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('categorias.*') ? 'active' : '' }}" href="{{ route('categorias.index') }}">Categorías</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('servicios.*') ? 'active' : '' }}" href="{{ route('servicios.index') }}">Servicios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('proveedores.*') ? 'active' : '' }}" href="{{ route('proveedores.index') }}">Proveedores</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('reservas.*') ? 'active' : '' }}" href="{{ route('reservas.index') }}">Reservas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('pagos.*') ? 'active' : '' }}" href="{{ route('pagos.index') }}">Pagos</a>
                    </li>
                    @if(auth()->user()->esAdministrador())
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('usuarios.*') ? 'active' : '' }}" href="{{ route('usuarios.index') }}">Usuarios</a>
                        </li>
                    @endif
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle"></i> {{ auth()->user()->nombre }}
                            <span class="badge bg-success ms-1">{{ auth()->user()->rol->nombre ?? 'Sin rol' }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="dropdown-item" type="submit"><i class="bi bi-box-arrow-right"></i> Cerrar sesión</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
@endauth

<main class="container py-4">
    {{-- Mensajes flash de éxito/error --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Errores de validación --}}
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Revisa los siguientes datos:</strong>
            <ul class="mb-0 mt-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @yield('contenido')
</main>

<footer class="text-center text-muted py-3 small">
    ADOESC &copy; {{ date('Y') }} — Aplicación Digital para la Organización Eficiente de Eventos
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
