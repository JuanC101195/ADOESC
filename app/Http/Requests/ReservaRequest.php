<?php

namespace App\Http\Requests;

use App\Models\Reserva;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Validación para crear y actualizar reservas (evento + servicio).
 */
class ReservaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_evento' => ['required', 'exists:evento,id_evento'],
            'id_servicio' => ['required', 'exists:servicio,id_servicio'],
            'fecha_reserva' => ['required', 'date'],
            'estado' => ['required', Rule::in(Reserva::ESTADOS)],
        ];
    }

    public function messages(): array
    {
        return [
            'id_evento.required' => 'Debes seleccionar el evento.',
            'id_evento.exists' => 'El evento seleccionado no existe.',
            'id_servicio.required' => 'Debes seleccionar el servicio.',
            'id_servicio.exists' => 'El servicio seleccionado no existe.',
            'fecha_reserva.required' => 'La fecha de la reserva es obligatoria.',
            'estado.required' => 'El estado de la reserva es obligatorio.',
            'estado.in' => 'El estado debe ser Pendiente, Confirmado o Cancelado.',
        ];
    }
}
