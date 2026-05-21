<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Validación para crear y actualizar eventos.
 */
class EventoRequest extends FormRequest
{
    /** El control de acceso se hace con middleware de roles. */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de validación del evento.
     */
    public function rules(): array
    {
        return [
            'id_usuario' => ['required', 'exists:usuario,id_usuario'],
            'nombre_evento' => ['required', 'string', 'max:80'],
            'fecha' => ['required', 'date'],
            'lugar' => ['required', 'string', 'max:100'],
            'invitados' => ['nullable', 'integer', 'min:1'],
        ];
    }

    /**
     * Mensajes de error en español.
     */
    public function messages(): array
    {
        return [
            'id_usuario.required' => 'Debes seleccionar el organizador del evento.',
            'id_usuario.exists' => 'El organizador seleccionado no existe.',
            'nombre_evento.required' => 'El nombre del evento es obligatorio.',
            'fecha.required' => 'La fecha del evento es obligatoria.',
            'fecha.date' => 'La fecha no es válida.',
            'lugar.required' => 'El lugar del evento es obligatorio.',
            'invitados.min' => 'El número de invitados debe ser al menos 1.',
        ];
    }
}
