{{-- Campos compartidos del formulario de servicio --}}
@php($servicio = $servicio ?? null)

<div class="mb-3">
    <label for="nombre" class="form-label">Nombre del servicio</label>
    <input type="text" name="nombre" id="nombre" class="form-control"
           value="{{ old('nombre', $servicio->nombre ?? '') }}" required autofocus>
</div>
<div class="row">
    <div class="col-md-6 mb-3">
        <label for="id_proveedor" class="form-label">Proveedor</label>
        <select name="id_proveedor" id="id_proveedor" class="form-select" required>
            <option value="">— Selecciona —</option>
            @foreach($proveedores as $prov)
                <option value="{{ $prov->id_proveedor }}" @selected(old('id_proveedor', $servicio->id_proveedor ?? '') == $prov->id_proveedor)>
                    {{ $prov->nombre }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6 mb-3">
        <label for="id_categoria" class="form-label">Categoría</label>
        <select name="id_categoria" id="id_categoria" class="form-select" required>
            <option value="">— Selecciona —</option>
            @foreach($categorias as $cat)
                <option value="{{ $cat->id_categoria }}" @selected(old('id_categoria', $servicio->id_categoria ?? '') == $cat->id_categoria)>
                    {{ $cat->nombre }}
                </option>
            @endforeach
        </select>
    </div>
</div>
<div class="mb-3">
    <label for="precio" class="form-label">Precio</label>
    <input type="number" step="0.01" min="0.01" name="precio" id="precio" class="form-control"
           value="{{ old('precio', $servicio->precio ?? '') }}">
</div>
