{{-- Campos compartidos del formulario de categoría --}}
@php($categoria = $categoria ?? null)

<div class="mb-3">
    <label for="nombre" class="form-label">Nombre de la categoría</label>
    <input type="text" name="nombre" id="nombre" class="form-control"
           value="{{ old('nombre', $categoria->nombre ?? '') }}" required autofocus>
</div>
