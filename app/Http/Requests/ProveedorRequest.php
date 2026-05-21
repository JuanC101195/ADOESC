<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Validación para crear y actualizar proveedores.
 */
class ProveedorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' => ['required', 'string', 'max:60'],
            'telefono' => ['required', 'string', 'max:15'],
            'categoria' => ['required', 'string', 'max:40'],
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre del proveedor es obligatorio.',
            'telefono.required' => 'El teléfono del proveedor es obligatorio.',
            'categoria.required' => 'La categoría del proveedor es obligatoria.',
        ];
    }
}
