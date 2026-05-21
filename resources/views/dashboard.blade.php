@extends('layouts.app')
@section('titulo', 'Panel - ADOESC')

@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="mb-0">Hola, {{ $usuario->nombre }} 👋</h3>
        <small class="text-muted">Rol: <strong>{{ $usuario->rol->nombre ?? 'Sin rol' }}</strong></small>
    </div>
</div>

{{-- Tarjetas de estadísticas --}}
<div class="row g-3 mb-4">
    @if(isset($estadisticas['totalUsuarios']))
        <div class="col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <i class="bi bi-people fs-2 text-adoesc"></i>
                    <h4 class="mt-2 mb-0">{{ $estadisticas['totalUsuarios'] }}</h4>
                    <small class="text-muted">Usuarios</small>
                </div>
            </div>
        </div>
    @endif
    @if(isset($estadisticas['misEventos']))
        <div class="col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <i class="bi bi-calendar-heart fs-2 text-adoesc"></i>
                    <h4 class="mt-2 mb-0">{{ $estadisticas['misEventos'] }}</h4>
                    <small class="text-muted">Mis eventos</small>
                </div>
            </div>
        </div>
    @endif
    <div class="col-md-3">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <i class="bi bi-calendar2-event fs-2 text-adoesc"></i>
                <h4 class="mt-2 mb-0">{{ $estadisticas['totalEventos'] }}</h4>
                <small class="text-muted">Eventos</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <i class="bi bi-gear-wide-connected fs-2 text-adoesc"></i>
                <h4 class="mt-2 mb-0">{{ $estadisticas['totalServicios'] }}</h4>
                <small class="text-muted">Servicios</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <i class="bi bi-bookmark-check fs-2 text-adoesc"></i>
                <h4 class="mt-2 mb-0">{{ $estadisticas['totalReservas'] }}</h4>
                <small class="text-muted">Reservas</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <i class="bi bi-cash-coin fs-2 text-adoesc"></i>
                <h4 class="mt-2 mb-0">{{ $estadisticas['totalPagos'] }}</h4>
                <small class="text-muted">Pagos</small>
            </div>
        </div>
    </div>
</div>

{{-- Próximos eventos --}}
<div class="card shadow-sm">
    <div class="card-header card-header-adoesc">
        <i class="bi bi-calendar-week"></i>
        {{ $usuario->esOrganizador() ? 'Mis próximos eventos' : 'Próximos eventos' }}
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Evento</th>
                    <th>Fecha</th>
                    <th>Lugar</th>
                    <th>Organizador</th>
                </tr>
            </thead>
            <tbody>
                @forelse($proximosEventos as $evento)
                    <tr>
                        <td><a href="{{ route('eventos.show', $evento) }}" class="text-adoesc">{{ $evento->nombre_evento }}</a></td>
                        <td>{{ $evento->fecha?->format('d/m/Y') }}</td>
                        <td>{{ $evento->lugar }}</td>
                        <td>{{ $evento->usuario->nombre ?? '—' }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center text-muted py-3">No hay eventos próximos.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
