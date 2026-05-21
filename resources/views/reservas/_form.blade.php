{{-- Campos compartidos del formulario de reserva --}}
@php($reserva = $reserva ?? null)

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="id_evento" class="form-label">Evento</label>
        <select name="id_evento" id="id_evento" class="form-select" required>
            <option value="">— Selecciona —</option>
            @foreach($eventos as $evento)
                <option value="{{ $evento->id_evento }}" @selected(old('id_evento', $reserva->id_evento ?? '') == $evento->id_evento)>
                    {{ $evento->nombre_evento }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6 mb-3">
        <label for="id_servicio" class="form-label">Servicio</label>
        <select name="id_servicio" id="id_servicio" class="form-select" required>
            <option value="">— Selecciona —</option>
            @foreach($servicios as $servicio)
                <option value="{{ $servicio->id_servicio }}" @selected(old('id_servicio', $reserva->id_servicio ?? '') == $servicio->id_servicio)>
                    {{ $servicio->nombre }} ({{ $servicio->proveedor->nombre ?? 's/proveedor' }})
                </option>
            @endforeach
        </select>
    </div>
</div>
<div class="row">
    <div class="col-md-6 mb-3">
        <label for="fecha_reserva" class="form-label">Fecha de la reserva</label>
        <input type="date" name="fecha_reserva" id="fecha_reserva" class="form-control"
               value="{{ old('fecha_reserva', isset($reserva->fecha_reserva) ? $reserva->fecha_reserva->format('Y-m-d') : '') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label for="estado" class="form-label">Estado</label>
        <select name="estado" id="estado" class="form-select" required>
            @foreach($estados as $estado)
                <option value="{{ $estado }}" @selected(old('estado', $reserva->estado ?? 'Pendiente') == $estado)>{{ $estado }}</option>
            @endforeach
        </select>
    </div>
</div>
