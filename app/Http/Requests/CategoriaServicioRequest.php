<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Validación para crear y actualizar categorías de servicio.
 */
class CategoriaServicioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Al actualizar, ignoramos el registro actual en la regla unique.
        $idCategoria = $this->route('categoria')?->id_categoria;

        return [
            'nombre' => [
                'required', 'string', 'max:40',
                Rule::unique('categoria_servicio', 'nombre')->ignore($idCategoria, 'id_categoria'),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre de la categoría es obligatorio.',
            'nombre.unique' => 'Ya existe una categoría con ese nombre.',
            'nombre.max' => 'El nombre no puede superar los 40 caracteres.',
        ];
    }
}
