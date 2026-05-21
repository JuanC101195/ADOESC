{{-- Campos compartidos del formulario de proveedor --}}
@php($proveedor = $proveedor ?? null)

<div class="mb-3">
    <label for="nombre" class="form-label">Nombre</label>
    <input type="text" name="nombre" id="nombre" class="form-control"
           value="{{ old('nombre', $proveedor->nombre ?? '') }}" required autofocus>
</div>
<div class="row">
    <div class="col-md-6 mb-3">
        <label for="telefono" class="form-label">Teléfono</label>
        <input type="text" name="telefono" id="telefono" class="form-control"
               value="{{ old('telefono', $proveedor->telefono ?? '') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label for="categoria" class="form-label">Categoría / Rubro</label>
        <input type="text" name="categoria" id="categoria" class="form-control"
               value="{{ old('categoria', $proveedor->categoria ?? '') }}" required>
    </div>
</div>
