{{-- Campos compartidos del formulario de pago --}}
@php($pago = $pago ?? null)

<div class="mb-3">
    <label for="id_reserva" class="form-label">Reserva</label>
    <select name="id_reserva" id="id_reserva" class="form-select" required>
        <option value="">— Selecciona —</option>
        @foreach($reservas as $reserva)
            <option value="{{ $reserva->id_reserva }}" @selected(old('id_reserva', $pago->id_reserva ?? '') == $reserva->id_reserva)>
                #{{ $reserva->id_reserva }} — {{ $reserva->evento->nombre_evento ?? 's/evento' }} / {{ $reserva->servicio->nombre ?? 's/servicio' }}
            </option>
        @endforeach
    </select>
</div>
<div class="row">
    <div class="col-md-6 mb-3">
        <label for="monto" class="form-label">Monto</label>
        <input type="number" step="0.01" min="0.01" name="monto" id="monto" class="form-control"
               value="{{ old('monto', $pago->monto ?? '') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label for="fecha_pago" class="form-label">Fecha de pago</label>
        <input type="date" name="fecha_pago" id="fecha_pago" class="form-control"
               value="{{ old('fecha_pago', isset($pago->fecha_pago) ? $pago->fecha_pago->format('Y-m-d') : '') }}" required>
    </div>
</div>
