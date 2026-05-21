<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Validación para crear y actualizar usuarios (gestión por Administrador).
 */
class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Al actualizar, ignoramos el usuario actual en la regla unique del email.
        $idUsuario = $this->route('usuario')?->id_usuario;
        $esCreacion = $this->isMethod('post');

        return [
            'id_rol' => ['required', 'exists:rol,id_rol'],
            'nombre' => ['required', 'string', 'max:60'],
            'email' => [
                'required', 'email', 'max:80',
                Rule::unique('usuario', 'email')->ignore($idUsuario, 'id_usuario'),
            ],
            'telefono' => ['nullable', 'string', 'max:15'],
            // La contraseña es obligatoria al crear; opcional al editar.
            'password' => [$esCreacion ? 'required' : 'nullable', 'string', 'min:6'],
        ];
    }

    public function messages(): array
    {
        return [
            'id_rol.required' => 'Debes asignar un rol al usuario.',
            'id_rol.exists' => 'El rol seleccionado no existe.',
            'nombre.required' => 'El nombre es obligatorio.',
            'email.required' => 'El correo es obligatorio.',
            'email.unique' => 'Ya existe un usuario con ese correo.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 6 caracteres.',
        ];
    }
}
