<?php

namespace App\Http\Requests\Api;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

/**
 * Validación del servicio web de registro.
 * Garantiza que los errores se devuelvan siempre en formato JSON.
 */
class RegistroApiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de validación para el registro de un usuario.
     */
    public function rules(): array
    {
        return [
            'nombre' => ['required', 'string', 'max:60'],
            'email' => ['required', 'email', 'max:80', 'unique:usuario,email'],
            'telefono' => ['nullable', 'string', 'max:15'],
            'password' => ['required', 'string', 'min:6'],
        ];
    }

    /**
     * Mensajes de error en español.
     */
    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre es obligatorio.',
            'email.required' => 'El correo es obligatorio.',
            'email.email' => 'El correo no tiene un formato válido.',
            'email.unique' => 'Ya existe un usuario registrado con ese correo.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 6 caracteres.',
        ];
    }

    /**
     * Devuelve los errores de validación como respuesta JSON (código 422).
     */
    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Los datos enviados no son válidos.',
            'errors' => $validator->errors(),
        ], 422));
    }
}
