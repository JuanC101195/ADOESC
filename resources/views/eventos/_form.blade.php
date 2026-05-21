{{-- Campos compartidos por los formularios de crear y editar evento --}}
@php($evento = $evento ?? null)

<div class="mb-3">
    <label for="nombre_evento" class="form-label">Nombre del evento</label>
    <input type="text" name="nombre_evento" id="nombre_evento" class="form-control"
           value="{{ old('nombre_evento', $evento->nombre_evento ?? '') }}" required>
</div>

@if(auth()->user()->esAdministrador())
    <div class="mb-3">
        <label for="id_usuario" class="form-label">Organizador</label>
        <select name="id_usuario" id="id_usuario" class="form-select" required>
            <option value="">— Selecciona —</option>
            @foreach($organizadores as $org)
                <option value="{{ $org->id_usuario }}" @selected(old('id_usuario', $evento->id_usuario ?? '') == $org->id_usuario)>
                    {{ $org->nombre }}
                </option>
            @endforeach
        </select>
    </div>
@else
    {{-- El organizador crea/edita siempre a su propio nombre --}}
    <input type="hidden" name="id_usuario" value="{{ auth()->id() }}">
@endif

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="fecha" class="form-label">Fecha</label>
        <input type="date" name="fecha" id="fecha" class="form-control"
               value="{{ old('fecha', isset($evento->fecha) ? $evento->fecha->format('Y-m-d') : '') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label for="invitados" class="form-label">Número de invitados</label>
        <input type="number" name="invitados" id="invitados" class="form-control" min="1"
               value="{{ old('invitados', $evento->invitados ?? '') }}">
    </div>
</div>

<div class="mb-3">
    <label for="lugar" class="form-label">Lugar</label>
    <input type="text" name="lugar" id="lugar" class="form-control"
           value="{{ old('lugar', $evento->lugar ?? '') }}" required>
</div>
