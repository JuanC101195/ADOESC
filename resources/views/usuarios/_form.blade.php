{{-- Campos compartidos del formulario de usuario --}}
@php($usuario = $usuario ?? null)
@php($esEdicion = isset($usuario) && $usuario->exists)

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="nombre" class="form-label">Nombre completo</label>
        <input type="text" name="nombre" id="nombre" class="form-control"
               value="{{ old('nombre', $usuario->nombre ?? '') }}" required autofocus>
    </div>
    <div class="col-md-6 mb-3">
        <label for="email" class="form-label">Correo electrónico</label>
        <input type="email" name="email" id="email" class="form-control"
               value="{{ old('email', $usuario->email ?? '') }}" required>
    </div>
</div>
<div class="row">
    <div class="col-md-6 mb-3">
        <label for="telefono" class="form-label">Teléfono <span class="text-muted">(opcional)</span></label>
        <input type="text" name="telefono" id="telefono" class="form-control"
               value="{{ old('telefono', $usuario->telefono ?? '') }}">
    </div>
    <div class="col-md-6 mb-3">
        <label for="id_rol" class="form-label">Rol</label>
        <select name="id_rol" id="id_rol" class="form-select" required>
            <option value="">— Selecciona —</option>
            @foreach($roles as $rol)
                <option value="{{ $rol->id_rol }}" @selected(old('id_rol', $usuario->id_rol ?? '') == $rol->id_rol)>
                    {{ $rol->nombre }}
                </option>
            @endforeach
        </select>
    </div>
</div>
<div class="mb-3">
    <label for="password" class="form-label">
        Contraseña
        @if($esEdicion)<span class="text-muted">(déjala vacía para no cambiarla)</span>@endif
    </label>
    <input type="password" name="password" id="password" class="form-control" {{ $esEdicion ? '' : 'required' }}>
</div>
