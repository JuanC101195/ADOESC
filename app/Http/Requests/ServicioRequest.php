<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Validación para crear y actualizar servicios.
 */
class ServicioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_proveedor' => ['required', 'exists:proveedor,id_proveedor'],
            'id_categoria' => ['required', 'exists:categoria_servicio,id_categoria'],
            'nombre' => ['required', 'string', 'max:60'],
            'precio' => ['nullable', 'numeric', 'gt:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'id_proveedor.required' => 'Debes seleccionar el proveedor.',
            'id_proveedor.exists' => 'El proveedor seleccionado no existe.',
            'id_categoria.required' => 'Debes seleccionar la categoría.',
            'id_categoria.exists' => 'La categoría seleccionada no existe.',
            'nombre.required' => 'El nombre del servicio es obligatorio.',
            'precio.numeric' => 'El precio debe ser un número.',
            'precio.gt' => 'El precio debe ser mayor que 0.',
        ];
    }
}
